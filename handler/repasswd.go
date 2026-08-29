package handler

import (
	"fmt"
	"net/http"
	"net/url"
	"time"

	"permeate/db"
)

// ---------- 用户模块密码重置（含多个漏洞） ----------

// repasswdStep1 GET 输入邮箱页（m=user&a=re_passwd_step1）
func (a *App) repasswdStep1(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_step1", map[string]any{
		"PageTitle": "找回密码", "CurrentUser": a.GetUser(r),
	})
}

// doRepasswdStep1 POST 生成重置链接（验证码绕过 + Token 可预测）
func (a *App) doRepasswdStep1(w http.ResponseWriter, r *http.Request) {
	email := r.PostFormValue("email")
	captcha := r.PostFormValue("captcha")
	_ = captcha // 漏洞1：验证码校验被省略

	if email == "" {
		JSHistoryBack(w, "请输入邮箱")
		return
	}
	if row := db.Exec("SELECT * FROM bbs_user WHERE email='" + email + "'"); row == nil || !row.Ok {
		JSHistoryBack(w, "该邮箱未注册")
		return
	}

	// 漏洞2：token = md5(当前时间戳)，可预测
	token := MD5(itoa(time.Now().Unix()))
	a.ResetMu.Lock()
	a.ResetTokens[token] = email
	a.ResetMu.Unlock()

	resetURL := fmt.Sprintf("/home/index.php?m=user&a=re_passwd_step3&email=%s&code=%s",
		url.QueryEscape(email), token)

	a.Render(w, "repasswd_token", map[string]any{
		"PageTitle": "重置链接已生成", "CurrentUser": a.GetUser(r),
		"Email": email, "Token": token, "ResetURL": resetURL,
	})
}

// repasswdStep2 提示提交成功
func (a *App) repasswdStep2(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "提交成功", "CurrentUser": a.GetUser(r),
		"Msg": "重置请求已提交，请前往邮箱/查看重置链接。", "Link": "/",
	})
}

// repasswdStep3 GET 修改密码表单
func (a *App) repasswdStep3(w http.ResponseWriter, r *http.Request) {
	email := q(r, "email")
	code := q(r, "code")
	a.Render(w, "repasswd_step3", map[string]any{
		"PageTitle": "重置密码", "CurrentUser": a.GetUser(r),
		"Email": email, "Code": code,
	})
}

// doRepasswdStep3 POST 重置密码（token 校验缺陷 + 任意改密）
func (a *App) doRepasswdStep3(w http.ResponseWriter, r *http.Request) {
	email := r.PostFormValue("email")
	password := r.PostFormValue("password")
	repassword := r.PostFormValue("repassword")
	verifyCode := r.PostFormValue("code")

	// 漏洞3：token 校验逻辑缺陷
	// PHP: if(!empty($_SESSION[$verifyCode]) && $_SESSION[$verifyCode] != $email) die;
	// 空 code 时 $_SESSION[$verifyCode] 为空 -> 条件 false -> 绕过
	if verifyCode != "" {
		a.ResetMu.RLock()
		stored, ok := a.ResetTokens[verifyCode]
		a.ResetMu.RUnlock()
		if ok && stored != email {
			w.Write([]byte("请求不合法"))
			return
		}
	}

	if password != repassword {
		w.Write([]byte("两次密码不一致"))
		return
	}
	if password == "" {
		w.Write([]byte("密码不能为空"))
		return
	}

	// 漏洞4：直接按 email 修改任意用户密码
	db.Exec("update bbs_user set password='" + MD5(password) + "' where email='" + email + "'")
	if verifyCode != "" {
		a.ResetMu.Lock()
		delete(a.ResetTokens, verifyCode)
		a.ResetMu.Unlock()
	}
	JSAlert(w, "密码重置成功，请使用新密码登录", "/home/index.php?m=user&a=login")
}

// repasswdStep4 成功提示
func (a *App) repasswdStep4(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "重置成功", "CurrentUser": a.GetUser(r),
		"Msg": "密码已重置", "Link": "/home/index.php?m=user&a=login",
	})
}

// ---------- 旧的 repasswd 模块（复用入口） ----------

func (a *App) repasswdIndex(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_old", map[string]any{
		"PageTitle": "找回密码", "CurrentUser": a.GetUser(r),
	})
}

func (a *App) repasswdDoIndex(w http.ResponseWriter, r *http.Request) {
	username := r.PostFormValue("username")
	_ = username
	// 验证码省略
	if row := db.Exec("select * from bbs_user where email='" + username + "'"); row != nil && row.Ok {
		http.Redirect(w, r, "/home/index.php?m=user&a=re_passwd_step1", http.StatusFound)
		return
	}
	JSHistoryBack(w, "用户信息没有找到！")
	return
}

func (a *App) repasswdEmail(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "邮箱找回", "CurrentUser": a.GetUser(r),
		"Msg": "已向您的邮箱发送重置邮件（教学中改为直接生成重置链接）",
		"Link":   "/home/index.php?m=user&a=re_passwd_step1",
	})
}

func (a *App) repasswdPhone(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "手机找回", "CurrentUser": a.GetUser(r),
		"Msg": "已向您的手机发送验证码", "Link": "/",
	})
}

func (a *App) repasswdNewpasswd(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "设置新密码", "CurrentUser": a.GetUser(r),
		"Msg": "设置新密码流程（演示占位）", "Link": "/",
	})
}

func (a *App) repasswdSuccess(w http.ResponseWriter, r *http.Request) {
	a.Render(w, "repasswd_ok", map[string]any{
		"PageTitle": "成功", "CurrentUser": a.GetUser(r),
		"Msg": "操作成功", "Link": "/home/index.php?m=user&a=login",
	})
}