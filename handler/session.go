package handler

import (
	"crypto/hmac"
	"crypto/sha256"
	"encoding/json"
	"net/http"
	"strings"
)

const userCookie = "permeate_user"

// hmaci 生成值签名
func (a *App) sign(val string) string {
	m := hmac.New(sha256.New, a.HmacKey)
	m.Write([]byte(val))
	return b64e(m.Sum(nil))
}

// GetUser 从 Cookie 解出当前登录用户（map）；未登录返回 nil
func (a *App) GetUser(r *http.Request) map[string]any {
	c, err := r.Cookie(userCookie)
	if err != nil || c.Value == "" {
		return nil
	}
	parts := strings.SplitN(c.Value, ".", 2)
	if len(parts) != 2 {
		return nil
	}
	raw, err := b64d(parts[0])
	if err != nil {
		return nil
	}
	sig, err := b64d(parts[1])
	if err != nil {
		return nil
	}
	expected := hmac.New(sha256.New, a.HmacKey)
	expected.Write([]byte(parts[0]))
	if !hmac.Equal(sig, expected.Sum(nil)) {
		return nil
	}
	var user map[string]any
	if err := json.Unmarshal(raw, &user); err != nil {
		return nil
	}
	return user
}

// IsLogin 校验登录，未登录则弹出跳转登录页；返回用户（nil 表示未登录）
func (a *App) IsLogin(w http.ResponseWriter, r *http.Request) map[string]any {
	u := a.GetUser(r)
	if u == nil {
		JSAlert(w, "请先登录", "/home/index.php?m=user&a=login")
		return nil
	}
	return u
}

// SaveUser 写登录 Cookie
func (a *App) SaveUser(w http.ResponseWriter, user map[string]any) {
	b, _ := json.Marshal(user)
	val := b64e(b)
	http.SetCookie(w, &http.Cookie{
		Name:  userCookie,
		Value: val + "." + a.sign(val),
		Path:  "/",
	})
}

// ClearUser 登出
func (a *App) ClearUser(w http.ResponseWriter) {
	http.SetCookie(w, &http.Cookie{
		Name: userCookie, Value: "", Path: "/", MaxAge: -1,
	})
}