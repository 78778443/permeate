package handler

import (
	"fmt"
	"html/template"
	"net/http"
	"strings"
	"time"

	"permeate/db"
)

// createPost 发帖（GET 表单 / POST 发表，XSS 存储）
func (a *App) createPost(w http.ResponseWriter, r *http.Request) {
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	bk := q(r, "bk")
	if r.Method == http.MethodPost {
		cid := r.PostFormValue("bk")
		title := r.PostFormValue("title")
		content := r.PostFormValue("content")
		username := toStrAny(user["username"])
		pip := ip2Long(ClientIP(r))
		zt := q(r, "zt")

		ban := db.Exec("select * from bbs_iprefuse")
		if ban != nil && ban.Ok {
			for _, ip := range ban.Rows {
				if pip >= db.Int(ip["ipmin"]) && pip <= db.Int(ip["ipmax"]) {
					JSAlert(w, "你所在的IP已被禁止发帖！", "/home/clist.php?bk="+bk+"&zt="+zt)
					return
				}
			}
		}
		fil := db.Exec("select * from bbs_fil")
		if fil != nil && fil.Ok {
			for _, f := range fil.Rows {
				hinge := toStrAny(f["hinge"])
				if strings.Contains(title, hinge) || strings.Contains(content, hinge) {
					JSAlert(w, "你所发表的标题/内容，含有非法字符", "/home/clist.php?bk="+bk+"&zt="+zt)
					return
				}
			}
		}
		urow := db.Exec("select u.id,u.username from bbs_user as u where username='" + username + "'")
		if urow == nil || !urow.Ok || len(urow.Rows) == 0 {
			JSAlert(w, "非法登入，用户不存在！", "/home/fatie.php?bk="+bk)
			return
		}
		uid := toStrAny(urow.Rows[0]["id"])
		ptime := fmt.Sprint(time.Now().Unix())

		ins := db.Exec("insert into bbs_post(cid,title,content,ptime,uid,pip) values('" + cid + "','" + title +
			"','" + content + "','" + ptime + "','" + uid + "','" + fmt.Sprint(pip) + "')")
		if ins == nil {
			JSAlert(w, "发帖失败，请稍候再试！", "/home/fatie.php?bk="+bk)
			return
		}
		JSAlert(w, "发帖成功，即将返回列表.", "/home/index.php?m=tiezi&a=index&bk="+bk+"&zt="+zt)
		return
	}

	// 发帖页：显示一个富文本提示，content 原样提交以支持 XSS 练习
	a.Render(w, "fatie", map[string]any{
		"PageTitle": "发表新帖", "CurrentUser": user, "Bk": bk,
		"ContentJS": template.HTML(""),
	})
	_ = bk
}