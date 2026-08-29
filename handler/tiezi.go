package handler

import (
	"fmt"
	"html/template"
	"math"
	"net/http"
	"strconv"
	"strings"
	"time"

	"permeate/db"
)

// PostItem 帖子列表行
type PostItem struct {
	ID       string
	Title    template.HTML
	Username string
	Time     string
	Replies  string
	Views    string
}

// tieziIndex 版块帖子列表（SQLi 点：bk 参数）
func (a *App) tieziIndex(w http.ResponseWriter, r *http.Request) {
	bk := q(r, "bk")
	if bk == "" {
		w.Write([]byte("参数错误！"))
		return
	}
	pageSize := 15
	pageNum, _ := strconv.Atoi(q(r, "page"))
	if pageNum < 1 {
		pageNum = 1
	}

	countRow := db.Exec("select count(*) as c from bbs_post where cid=" + bk)
	count := int64(0)
	if countRow != nil && countRow.Ok && len(countRow.Rows) > 0 {
		count = db.Int(countRow.Rows[0]["c"])
	}
	pageCount := int(math.Ceil(float64(count) / float64(pageSize)))
	if pageCount < 1 {
		pageCount = 1
	}
	if pageNum > pageCount {
		pageNum = pageCount
	}
	limit := fmt.Sprintf(" limit %d,%d", (pageNum-1)*pageSize, pageSize)

	sql := "select p.*,u.username from bbs_post as p,bbs_user as u where  u.id=p.uid and p.cid=" + bk +
		" and p.del != -1" + limit
	row := db.Exec(sql)

	var posts []PostItem
	if row != nil && row.Ok {
		for _, p := range row.Rows {
			rc := db.Exec("select count(id) as count from bbs_reply where pid=" + db.Str(p["id"]))
			rcount := int64(0)
			if rc != nil && rc.Ok {
				if len(rc.Rows) > 0 {
					rcount = db.Int(rc.Rows[0]["count"])
				}
			}
			posts = append(posts, PostItem{
				ID:       db.Str(p["id"]),
				Title:    template.HTML(db.Str(p["title"])), // XSS：标题原样输出
				Username: db.Str(p["username"]),
				Time:     time.Unix(db.Int(p["ptime"]), 0).Format("2006-01-02 15:04"),
				Replies:  db.Str(rcount),
				Views:    db.Str(p["view_count"]),
			})
		}
	}

	a.Render(w, "tiezi_index", map[string]any{
		"PageTitle": "帖子列表", "CurrentUser": a.GetUser(r),
		"Bk":       bk,
		"Posts":    posts,
		"Count":    count,
		"PageNum":  pageNum,
		"PageCount": pageCount,
	})
}

// tieziDetail 帖子详情（SQLi 点：zt；XSS 点：content/reply）
func (a *App) tieziDetail(w http.ResponseWriter, r *http.Request) {
	zt := q(r, "zt")
	bk := q(r, "bk")
	if zt == "" || bk == "" {
		w.Write([]byte("参数错误！"))
		return
	}
	row := db.Exec("select p.*,u.username,d.pic from bbs_post as p,bbs_user as u,bbs_user_detail as d where p.uid=u.id and d.uid=p.uid and p.id='" + zt + "'")
	if row == nil || !row.Ok || len(row.Rows) == 0 {
		w.Write([]byte("帖子不存在"))
		return
	}
	post := row.Rows[0]

	pageSize := 15
	pageNum, _ := strconv.Atoi(q(r, "page"))
	if pageNum < 1 {
		pageNum = 1
	}
	cnt := db.Exec("SELECT count(*) AS c FROM bbs_reply where pid=" + zt)
	total := int64(0)
	if cnt != nil && cnt.Ok && len(cnt.Rows) > 0 {
		total = db.Int(cnt.Rows[0]["c"])
	}
	pageCount := int(math.Ceil(float64(total) / float64(pageSize)))
	if pageCount < 1 {
		pageCount = 1
	}
	if pageNum > pageCount {
		pageNum = pageCount
	}
	limit := fmt.Sprintf(" limit %d,%d", (pageNum-1)*pageSize, pageSize)

	rid := db.Exec("select r.*,u.username,d.pic from bbs_reply as r,bbs_user as u,bbs_user_detail as d where r.uid=u.id and d.uid=r.uid and r.pid='" + zt + "'" + limit)

	var replies []map[string]any
	if rid != nil && rid.Ok {
		for _, rdm := range rid.Rows {
			m := map[string]any{
				"content":  template.HTML(toStrAny(rdm["content"])), // XSS：回复原样输出
				"username": toStrAny(rdm["username"]),
				"ptime":    db.Int(rdm["ptime"]),
				"pic":      toStrAny(rdm["pic"]),
			}
			replies = append(replies, m)
		}
	}

	db.Exec("update bbs_post set view_count=(view_count+1) where id=" + zt)

	// 帖子内容原样渲染（XSS sink）
	authorName := toStrAny(post["username"])

	a.Render(w, "tiezi_detail", map[string]any{
		"PageTitle": "帖子详情", "CurrentUser": a.GetUser(r),
		"Bk":         bk,
		"Zt":         zt,
		"Post":       post,
		"PostRaw":    template.HTML(toStrAny(post["content"])), // XSS：内容原样输出
		"PostTitle":  template.HTML(toStrAny(post["title"])),
		"PostAuthor": authorName,
		"Replies":    replies,
		"Total":      total,
		"PageNum":    pageNum,
		"PageCount":  pageCount,
	})
}

// postDetail /home/post.php 兼容直链
func (a *App) postDetail(w http.ResponseWriter, r *http.Request) {
	a.tieziDetail(w, r)
}

// reply 发表回复（XSS 存储）
func (a *App) reply(w http.ResponseWriter, r *http.Request) {
	bk := q(r, "bk")
	zt := q(r, "zt")
	user := a.IsLogin(w, r)
	if user == nil {
		return
	}
	pid := r.PostFormValue("id")
	content := r.PostFormValue("editorValue")
	username := toStrAny(user["username"])

	pip := ip2Long(ClientIP(r))
	ban := db.Exec("SELECT * FROM bbs_iprefuse")
	if ban != nil && ban.Ok {
		for _, ip := range ban.Rows {
			if pip >= db.Int(ip["ipmin"]) && pip <= db.Int(ip["ipmax"]) {
				JSAlert(w, "你所在的IP已被禁止发帖！", "/home/post.php?bk="+bk+"&zt="+zt)
				return
			}
		}
	}

	urow := db.Exec("SELECT u.id,u.username FROM bbs_user AS u WHERE username='" + username + "'")
	if urow == nil || !urow.Ok || len(urow.Rows) == 0 {
		JSAlert(w, "请先登入！", "/home/index.php?m=user&a=login")
		return
	}
	uid := db.Str(urow.Rows[0]["id"])
	ptime := fmt.Sprint(time.Now().Unix())

	ins := db.Exec("insert into bbs_reply(pid,content,uid,ptime,pip) values('" + pid + "','" + content +
		"','" + uid + "','" + ptime + "','" + fmt.Sprint(pip) + "')")
	if ins == nil {
		JSAlert(w, "回复失败，请稍候再试！", "/home/index.php?m=tiezi&a=detail&bk="+bk+"&zt="+zt)
		return
	}
	JSAlert(w, "回复成功", "/home/index.php?m=tiezi&a=detail&bk="+bk+"&zt="+zt)
}

// ip2Long 复刻 PHP ip2long
func ip2Long(ip string) int64 {
	parts := strings.Split(ip, ".")
	var sum int64 = 0
	for _, p := range parts {
		n, _ := strconv.Atoi(p)
		sum = sum<<8 | int64(n)
	}
	return int64(uint32(sum))
}