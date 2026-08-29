package handler

import (
	"embed"
	"crypto/md5"
	"crypto/rand"
	"encoding/base64"
	"encoding/json"
	"fmt"
	"html/template"
	"net/http"
	"os"
	"path/filepath"
	"strings"
	"sync"
	"time"
)

// Assets 内嵌模板与静态资源
//go:embed assets
var Assets embed.FS

// App 全局应用
type App struct {
	Port    string
	HmacKey []byte
	Tmpl    *template.Template
	// ResetTokens 密码重置 token->email（内存，复刻 PHP $_SESSION）
	ResetTokens map[string]string
	ResetMu     sync.RWMutex
}

const siteTitle = "Permeate"

func NewApp(port string) (*App, error) {
	a := &App{Port: port, ResetTokens: map[string]string{}}
	if err := a.loadKey(); err != nil {
		return nil, err
	}
	if err := a.parseTemplates(); err != nil {
		return nil, err
	}
	return a, nil
}

// loadKey 载入或生成签名密钥（存 data/secret.key，保证重启后登录态仍在）
func (a *App) loadKey() error {
	kp := filepath.Join("data", "secret.key")
	if b, err := os.ReadFile(kp); err == nil && len(b) >= 32 {
		a.HmacKey = b
		return nil
	}
	key := make([]byte, 32)
	if _, err := rand.Read(key); err != nil {
		return err
	}
	os.MkdirAll("data", 0o755)
	if err := os.WriteFile(kp, key, 0o600); err != nil {
		return err
	}
	a.HmacKey = key
	return nil
}

func (a *App) parseTemplates() error {
	tmpl := template.New("_").Funcs(template.FuncMap{
		"date": func(ts any) string {
			i, ok := ts.(int64)
			if !ok {
				if f, ok2 := ts.(float64); ok2 {
					i = int64(f)
				} else {
					i = 0
				}
			}
			if i == 0 {
				return ""
			}
			return time.Unix(i, 0).Format("2006-01-02 15:04:05")
		},
		"field": func(m map[string]any, key string) any {
			if v, ok := m[key]; ok {
				return v
			}
			return ""
		},
		"add": func(a, b int) int { return a + b },
		"sub": func(a, b int) int { return a - b },
	})
	var err error
	tmpl, err = tmpl.ParseFS(Assets, "assets/templates/*.html")
	if err != nil {
		return fmt.Errorf("解析模板失败: %w", err)
	}
	a.Tmpl = tmpl
	return nil
}

// ListenAndServe 启动 HTTP 服务
func (a *App) ListenAndServe(addr string) error {
	srv := &http.Server{Addr: addr, Handler: a.Handler()}
	return srv.ListenAndServe()
}

// Render 渲染命名模板
func (a *App) Render(w http.ResponseWriter, name string, data map[string]any) {
	data["SiteTitle"] = siteTitle
	if _, ok := data["CurrentUser"]; !ok {
		data["CurrentUser"] = nil
	}
	if err := a.Tmpl.ExecuteTemplate(w, name, data); err != nil {
		http.Error(w, "模板渲染失败", 500)
		fmt.Println("[render]", err)
	}
}

// MD5 复刻 PHP md5()：32位小写十六进制
func MD5(s string) string {
	return fmt.Sprintf("%x", md5.Sum([]byte(s)))
}

// JSAlert 输出 alert+跳转的脚本页
func JSAlert(w http.ResponseWriter, msg, redirect string) {
	w.Header().Set("Content-Type", "text/html; charset=utf-8")
	fmt.Fprintf(w, `<html><body><script>alert(%s);window.location.href=%s</script></body></html>`,
		strconvQuote(msg), strconvQuote(redirect))
}

// JSHistoryBack alert + 返回
func JSHistoryBack(w http.ResponseWriter, msg string) {
	w.Header().Set("Content-Type", "text/html; charset=utf-8")
	fmt.Fprintf(w, `<html><body><script>alert(%s);history.go(-1)</script></body></html>`, strconvQuote(msg))
}

func strconvQuote(s string) string {
	s = strings.ReplaceAll(s, `\`, `\\`)
	s = strings.ReplaceAll(s, `'`, `\'`)
	b, _ := json.Marshal(s)
	return string(b)
}

// ClientIP 近似 REMOTE_ADDR
func ClientIP(r *http.Request) string {
	host, _, _ := strings.Cut(r.RemoteAddr, ":")
	if host == "" {
		host = "127.0.0.1"
	}
	return host
}

// b64 helpers
func b64e(b []byte) string { return base64.StdEncoding.EncodeToString(b) }
func b64d(s string) ([]byte, error) {
	return base64.StdEncoding.DecodeString(s)
}

// fileExists 判断文件是否存在
func fileExists(p string) bool {
	_, err := os.Stat(p)
	return err == nil
}