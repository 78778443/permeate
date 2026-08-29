package handler

import (
	"net/http"
	"regexp"
	"time"

	"permeate/db"
)

var (
	reUsername = regexp.MustCompile(`^[a-zA-Z][a-zA-Z0-9_]{4,15}$`)
	rePassword = regexp.MustCompile(`^[a-zA-Z0-9][a-zA-Z0-9_]{5,15}$`)
	reEmail    = regexp.MustCompile(`^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$`)
)

// login GET 显示表单 / POST 处理登录（SQLi 点：username/password 直接拼接）
func (a *App) login(w http.ResponseWriter, r *http.Request) {
	username := r.PostFormValue("username")
	if r.Method == http.MethodPost && username != "" {
		password := MD5(r.PostFormValue("password"))
		sql := "select u.*,d.* from bbs_user as u, bbs_user_detail as d where d.uid=u.id and u.username='" +
			username + "' and u.password='" + password + "'"
		row := db.Exec(sql)
		if row == nil || !row.Ok || len(row.Rows) == 0 {
			JSAlert(w, "用户名或密码错误,请重新输入！", "/home/index.php?m=user&a=login")
			return
		}
		a.SaveUser(w, row.Rows[0])
		http.Redirect(w, r, "/", http.StatusFound)
		return
	}
	a.Render(w, "login", map[string]any{
		"PageTitle":   "登录",
		"CurrentUser": nil,
		"Note":        "验证码校验已省略（作为教学可绕过点）",
	})
}

// register GET 显示表单 / POST 处理注册（yzm 校验省略）
func (a *App) register(w http.ResponseWriter, r *http.Request) {
	username := r.PostFormValue("username")
	if r.Method == http.MethodPost && username != "" {
		password := r.PostFormValue("password")
		repass := r.PostFormValue("repass")
		email := r.PostFormValue("email")
		referer := "/home/index.php?m=user&a=register"

		// 用户已存在
		if row := db.Exec("select username from bbs_user where bbs_user.username='" + username + "'"); row != nil && row.Ok {
			JSAlert(w, "用户已存在！", referer)
			return
		}
		if !reUsername.MatchString(username) {
			JSAlert(w, "用户名格式不正确！", referer)
			return
		}
		if !rePassword.MatchString(password) {
			JSAlert(w, "密码格式不正确！", referer)
			return
		}
		if !reEmail.MatchString(email) {
			JSAlert(w, "邮箱格式不正确！", referer)
			return
		}
		if password != repass {
			JSAlert(w, "两次密码不一致", referer)
			return
		}

		rtime := time.Now().Unix()
		md5pwd := MD5(password)
		ins := db.Exec("insert into bbs_user(username,password,rtime,rip,email) values('" + username +
			"','" + md5pwd + "','" + itoa(rtime) + "','0','" + email + "')")
		if ins == nil || ins.LastID == 0 {
			JSAlert(w, "数据库写入失败！", referer)
			return
		}
		db.Exec("insert into bbs_user_detail(uid,email) values('" + itoa(ins.LastID) + "','" + email + "')")

		// 自动登录
		if row := db.Exec("select u.*,d.* from bbs_user as u, bbs_user_detail as d where d.uid=u.id and u.username='" + username + "'"); row != nil && row.Ok && len(row.Rows) > 0 {
			a.SaveUser(w, row.Rows[0])
		}
		JSAlert(w, "注册成功！", "/")
		return
	}
	a.Render(w, "register", map[string]any{
		"PageTitle": "注册", "CurrentUser": nil,
	})
}

// logout 退出登录
func (a *App) logout(w http.ResponseWriter, r *http.Request) {
	a.ClearUser(w)
	http.Redirect(w, r, "/", http.StatusFound)
}

// adminLogin 后台未登录/非管理员处理
func (a *App) adminLogin(w http.ResponseWriter, r *http.Request) {
	u := a.GetUser(r)
	if u == nil {
		a.Render(w, "login", map[string]any{
			"PageTitle": "后台登录", "CurrentUser": nil,
			"Note": "后台需要管理员账号（admin/123456），请先登录",
		})
		return
	}
	JSAlert(w, "抱歉，您需要管理员权限！", "/")
}

// adminLogout 后台退出
func (a *App) adminLogout(w http.ResponseWriter, r *http.Request) {
	a.ClearUser(w)
	http.Redirect(w, r, "/", http.StatusFound)
}

func itoa(n int64) string {
	if n == 0 {
		return "0"
	}
	neg := n < 0
	if neg {
		n = -n
	}
	var b [20]byte
	i := len(b)
	for n > 0 {
		i--
		b[i] = byte('0' + n%10)
		n /= 10
	}
	if neg {
		i--
		b[i] = '-'
	}
	return string(b[i:])
}