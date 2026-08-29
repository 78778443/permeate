package handler

import (
	"net/http"
	"time"

	"permeate/db"
)

// follow 关注用户
func (a *App) follow(w http.ResponseWriter, r *http.Request) {
	uid := q(r, "uid")
	followuid := a.IsLogin(w, r)
	if followuid == nil {
		return
	}
	myID := toStrAny(followuid["id"])

	if uid == myID {
		JSAlert(w, "自己不能关注自己", "")
		return
	}
	user := db.Exec("SELECT id,username FROM bbs_user WHERE id = " + uid)
	fu := db.Exec("SELECT id,username FROM bbs_user WHERE id = " + myID)
	if user == nil || !user.Ok || len(user.Rows) == 0 || fu == nil || !fu.Ok || len(fu.Rows) == 0 {
		JSAlert(w, "用户不存在", "")
		return
	}
	me := fu.Rows[0]

	existing := db.Exec("select id,mutual,uid,followuid from bbs_home_follow where (uid=" + uid +
		" and followuid=" + myID + " or uid=" + myID + " and followuid=" + uid + ") and status != -1")
	rows := "no"
	if existing != nil && existing.Ok && len(existing.Rows) > 0 {
		rows = "yes"
	}
	followRow := ""
	if existing != nil && existing.Ok && len(existing.Rows) > 0 {
		followRow = toStrAny(existing.Rows[0]["id"])
	}
	mutual := int64(0)
	if existing != nil && existing.Ok && len(existing.Rows) > 0 {
		mutual = db.Int(existing.Rows[0]["mutual"])
	}

	if rows == "yes" {
		// 已关注：若已互相关注或对方就是自己关注对象，则提示勿重复
		if mutual != 0 || db.Str(existing.Rows[0]["followuid"]) == myID {
			JSAlert(w, "请勿重复关注", "")
			return
		}
		// 本次互相关注
		db.Exec("UPDATE bbs_home_follow SET mutual=1 WHERE id=" + followRow)
	} else {
		db.Exec("INSERT INTO bbs_home_follow(id,uid,username,followuid,fusername,status,mutual,uptiem) VALUES(0,'" + uid +
			"','" + toStrAny(user.Rows[0]["username"]) + "','" + myID + "','" + toStrAny(me["username"]) +
			"','0',0,'" + itoa(time.Now().Unix()) + "')")
	}
	JSAlert(w, "关注成功", "")
}