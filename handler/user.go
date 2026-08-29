package handler

import (
	"crypto/tls"
	"fmt"
	"html/template"
	"io"
	"net/http"
	"os"
	"path/filepath"
	"strings"
	"time"

	"permeate/db"
)

// individual 个人中心
func (a *App) individual(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	a.Render(w, "individual", map[string]any{
		"PageTitle": "个人中心", "CurrentUser": user, "User": user,
	})
}

// basic 资料编辑（越权漏洞：uid 参数可查看/修改他人）
func (a *App) basic(w http.ResponseWriter, r *http.Request) {
	cur := a.IsLogin(w, r)
	if cur == nil {
		return
	}
	uid := q(r, "uid")
	if uid == "" {
		uid = toStrAny(cur["id"])
	}
	// 未校验权限，直接按 uid 拉取
	row := db.Exec("SELECT u.*, d.* FROM bbs_user u LEFT JOIN bbs_user_detail d ON u.id=d.uid WHERE u.id=" + uid)
	user := cur
	if row != nil && row.Ok && len(row.Rows) > 0 {
		user = row.Rows[0]
	}
	a.Render(w, "basic", map[string]any{
		"PageTitle": "资料编辑", "CurrentUser": cur, "User": user,
	})
}

// doBasic 保存资料（越权漏洞：POST 提交 uid 可改任意用户）
func (a *App) doBasic(w http.ResponseWriter, r *http.Request) {
	cur := a.IsLogin(w, r)
	if cur == nil {
		return
	}
	t_name := r.PostFormValue("t_name")
	age := r.PostFormValue("age")
	sex := r.PostFormValue("sex")
	edu := r.PostFormValue("edu")
	signed := r.PostFormValue("signed")
	brithday := r.PostFormValue("brithday")
	telphone := r.PostFormValue("telphone")
	qq := r.PostFormValue("qq")
	email := r.PostFormValue("email")
	uid := r.PostFormValue("uid")
	if uid == "" {
		uid = toStrAny(cur["id"])
	}
	db.Exec("update bbs_user_detail set t_name='" + t_name + "',age='" + age + "',sex='" + sex +
		"',edu='" + edu + "',signed='" + signed + "',brithday='" + brithday + "',telphone='" + telphone +
		"',qq='" + qq + "',email='" + email + "' where uid=" + uid)

	// 刷新当前用户 session
	if row := db.Exec("SELECT u.*,p.* FROM bbs_user AS u,bbs_user_detail AS p WHERE p.uid=u.id and u.id=" +
		toStrAny(cur["id"])); row != nil && row.Ok && len(row.Rows) > 0 {
		a.SaveUser(w, row.Rows[0])
	}
	JSAlert(w, "修改成功！", "/")
}

// safe 修改密码表单
func (a *App) safe(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	a.Render(w, "safe", map[string]any{
		"PageTitle": "修改密码", "CurrentUser": user,
	})
}

// doSafe 修改密码（复刻 home/hadel/dosafe.php）
func (a *App) doSafe(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	oldpassword := r.PostFormValue("oldpassword")
	newpassword := r.PostFormValue("newpassword")
	newpassword2 := r.PostFormValue("newpassword2")
	uid := toStrAny(user["id"])

	if oldpassword == "" {
		JSAlert(w, "请输入当前密码！", "/")
		return
	}
	if newpassword == "" && newpassword2 == "" {
		JSAlert(w, "请输入新的密码！", "/")
		return
	}
	if newpassword != newpassword2 {
		JSAlert(w, "两次密码不一致！", "/")
		return
	}
	old := MD5(oldpassword)
	if row := db.Exec("select * from bbs_user where password='" + old + "' and id='" + uid + "'"); row == nil || !row.Ok {
		JSAlert(w, "请输入正确的当前密码！", "/")
		return
	}
	db.Exec("update bbs_user set password='" + MD5(newpassword) + "' where id='" + uid + "'")
	a.ClearUser(w)
	JSAlert(w, "你的密码修改成功,请用新的密码登入.", "/")
}

// userInfo 用户资料（SQLi 点：id 参数直接拼接）
func (a *App) userInfo(w http.ResponseWriter, r *http.Request) {
	id := q(r, "id")
	cur := a.GetUser(r)
	if id == "" && cur != nil {
		id = toStrAny(cur["id"])
	}
	if id == "" {
		w.Write([]byte("参数错误！"))
		return
	}
	row := db.Exec("select * from bbs_user_detail where uid = " + id)
	if row == nil || !row.Ok || len(row.Rows) == 0 {
		w.Write([]byte("用户不存在"))
		return
	}
	info := row.Rows[0]
	uid := db.Str(info["uid"])
	switch db.Int(info["sex"]) {
	case 1:
		info["sex_name"] = "男"
	case 2:
		info["sex_name"] = "女"
	default:
		info["sex_name"] = "保密"
	}
	if c := db.Exec("select count(id) as count from bbs_post where uid = " + uid); c != nil && c.Ok {
		info["tiezi_count"] = c.Rows[0]["count"]
	}
	if c := db.Exec("select count(id) as count from bbs_reply where uid = " + uid); c != nil && c.Ok {
		info["reply_count"] = c.Rows[0]["count"]
	}
	if c := db.Exec("select count(id) as count from bbs_home_follow where followuid=" + uid); c != nil && c.Ok {
		info["follow_count"] = c.Rows[0]["count"]
	}
	uname := ""
	if u := db.Exec("select username from bbs_user where id=" + uid); u != nil && u.Ok && len(u.Rows) > 0 {
		uname = db.Str(u.Rows[0]["username"])
	}
	a.Render(w, "info", map[string]any{
		"PageTitle": "用户资料", "CurrentUser": cur, "Info": info, "Uname": uname,
	})
}

// avatarRemote 远程头像设置页（SSRF 入口）
func (a *App) avatarRemote(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	a.Render(w, "avatar_remote", map[string]any{
		"PageTitle": "远程头像", "CurrentUser": user,
	})
}

// setRemoteAvatar 获取远程头像（SSRF：任意协议/地址，无过滤）
func (a *App) setRemoteAvatar(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	urlStr := r.PostFormValue("avatar_url")
	if urlStr == "" {
		JSAlert(w, "请输入头像URL", "")
		return
	}
	var body []byte
	var contentType string
	msg := ""

	if strings.HasPrefix(strings.ToLower(urlStr), "file:") {
		path := strings.TrimPrefix(urlStr, "file://")
		if b, err := os.ReadFile(path); err == nil {
			body = b
			contentType = "application/octet-stream"
		} else {
			msg = "读取本地文件失败: " + err.Error()
		}
	} else {
		// 不校验协议与地址，不验证证书，可跟随跳转
		client := &http.Client{
			Timeout:   10 * time.Second,
			Transport: &http.Transport{TLSClientConfig: &tls.Config{InsecureSkipVerify: true}},
		}
		resp, err := client.Get(urlStr)
		if err != nil {
			msg = "获取头像失败: " + err.Error()
		} else {
			defer resp.Body.Close()
			b, rerr := io.ReadAll(resp.Body)
			if rerr != nil {
				msg = "读取响应失败: " + rerr.Error()
			} else {
				body = b
				contentType = resp.Header.Get("Content-Type")
				if contentType == "" {
					contentType = http.DetectContentType(b)
				}
			}
		}
	}

	if msg != "" {
		JSHistoryBack(w, msg)
		return
	}

	// 保存为头像并更新数据库
	dir := filepath.Join("uploads", "userheads")
	os.MkdirAll(dir, 0o755)
	fname := fmt.Sprintf("%d.jpg", time.Now().UnixNano())
	os.WriteFile(filepath.Join(dir, fname), body, 0o644)
	// 未知内容则不保存为图片（SSRF 只回显）
	if !strings.HasPrefix(contentType, "image/") {
		w.Header().Set("Content-Type", "text/html; charset=utf-8")
		fmt.Fprintf(w, `<html><body><h3>SSRF 探测结果(非图片内容，未保存)</h3><p>Content-Type: %s，大小: %d 字节</p><pre>%s</pre><a href="javascript:history.go(-1)">返回</a></body></html>`,
			template.HTMLEscapeString(contentType), len(body),
			template.HTMLEscapeString(string(body)))
		return
	}
	picURL := "/uploads/userheads/" + fname
	db.Exec("update bbs_user_detail set pic='" + picURL + "' where uid='" + toStrAny(user["id"]) + "'")
	user["pic"] = picURL
	a.SaveUser(w, user)
	JSAlert(w, "头像设置成功", "/home/index.php?m=user&a=individual")
}

// uploadFile 上传页
func (a *App) uploadFile(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	a.Render(w, "upload", map[string]any{
		"PageTitle": "文件上传", "CurrentUser": user,
	})
}

// doUploadFile 上传处理（MIME 白名单可伪造 + 黑名单不全 + 保留原文件名）
func (a *App) doUploadFile(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	if err := r.ParseMultipartForm(8 << 20); err != nil {
		JSHistoryBack(w, "请选择要上传的文件")
		return
	}
	file, hdr, err := r.FormFile("file")
	if err != nil {
		JSHistoryBack(w, "请选择要上传的文件")
		return
	}
	defer file.Close()

	fileType := hdr.Header.Get("Content-Type")
	allowed := []string{"image/jpeg", "image/png", "image/gif", "text/plain", "application/pdf"}
	ok := false
	for _, m := range allowed {
		if m == fileType {
			ok = true
			break
		}
	}
	if !ok {
		JSAlert(w, "不允许上传此类型的文件（MIME验证失败）", "/home/index.php?m=user&a=upload_file")
		return
	}

	ext := strings.ToLower(filepath.Ext(hdr.Filename))

	// 黑名单不全：php/asp/aspx/jsp/exe/bat/cmd/sh；php3/php5/phtml/pgif 等可绕过
	blacklist := []string{"php", "asp", "aspx", "jsp", "exe", "bat", "cmd", "sh"}
	for _, b := range blacklist {
		if "." + b == ext {
			JSAlert(w, "不允许上传此类型的文件（黑名单验证失败）", "/home/index.php?m=user&a=upload_file")
			return
		}
	}

	dir := "uploads"
	os.MkdirAll(dir, 0o755)
	// 危险：直接使用原始文件名，未重命名
	dst := filepath.Join(dir, filepath.Base(hdr.Filename))
	out, err := os.Create(dst)
	if err != nil {
		JSHistoryBack(w, "文件保存失败")
		return
	}
	defer out.Close()
	if _, err := io.Copy(out, file); err != nil {
		JSHistoryBack(w, "文件保存失败")
		return
	}
	JSAlert(w, "文件上传成功！", "/home/index.php?m=user&a=upload_file")
}