package handler

import (
	"html/template"
	"net/http"
	"os"
	"os/exec"
	"runtime"
	"time"

	"permeate/db"
)

// runCmd 经 shell 运行拼接命令（命令注入需 shell 解析连接符）
func runCmd(cmd string) (string, bool) {
	var c *exec.Cmd
	if runtime.GOOS == "windows" {
		c = exec.Command("cmd", "/C", cmd)
	} else {
		c = exec.Command("/bin/sh", "-c", cmd)
	}
	out, err := c.CombinedOutput()
	return string(out), err == nil
}

func platformPing(ip string) string {
	if runtime.GOOS == "windows" {
		return "ping -n 4 " + ip
	}
	return "ping -c 4 " + ip
}

// adminIndex 后台仪表盘
func (a *App) adminIndex(w http.ResponseWriter, r *http.Request) {
	cnt := func(sql string) string {
		if row := db.Exec(sql); row != nil && row.Ok && len(row.Rows) > 0 {
			return toStrAny(row.Rows[0]["c"])
		}
		return "0"
	}
	a.adminRender(w, r, "admin_index", map[string]any{
		"PageTitle": "后台管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Users":  cnt("select count(*) as c from bbs_user"),
		"Posts":  cnt("select count(*) as c from bbs_post"),
		"Replies": cnt("select count(*) as c from bbs_reply"),
		"Cates":  cnt("select count(*) as c from bbs_cate"),
	})
}

// ---------- 命令执行 ----------

// adminBackup 备份页
func (a *App) adminBackup(w http.ResponseWriter, r *http.Request) {
	a.adminRender(w, r, "admin_backup", map[string]any{
		"PageTitle": "数据库备份", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// adminDoBackup 备份命令注入点（filename 参数）
func (a *App) adminDoBackup(w http.ResponseWriter, r *http.Request) {
	filename := r.PostFormValue("filename")
	if filename == "" {
		filename = "backup_" + time.Now().Format("20060102150405")
	}
	backupDir := "backup"
	os.MkdirAll(backupDir, 0o755)
	// 故意拼接用户输入到系统命令（SQLite 场景：直接 rsync/占位，保留注入点）
	command := "echo '-- permeate backup --' > " + backupDir + "/" + filename + ".sql 2>&1"
	out, _ := runCmd(command)
	a.adminRender(w, r, "admin_backup", map[string]any{
		"PageTitle": "数据库备份", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Output": template.HTML(esc(out))})
}

// adminPing ping 工具页
func (a *App) adminPing(w http.ResponseWriter, r *http.Request) {
	a.adminRender(w, r, "admin_ping", map[string]any{
		"PageTitle": "Ping 工具", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// adminDoPing ping 命令注入点（ip 参数）
func (a *App) adminDoPing(w http.ResponseWriter, r *http.Request) {
	ip := r.PostFormValue("ip")
	command := platformPing(ip) // 直接拼接，| ; & ` 可注入
	out, _ := runCmd(command)
	a.adminRender(w, r, "admin_ping", map[string]any{
		"PageTitle": "Ping 工具", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Cmd":    command,
		"Output": template.HTML(esc(out)),
	})
}

func esc(s string) string { return template.HTMLEscapeString(s) }

// ---------- 用户管理 ----------

func (a *App) adminUserLists(w http.ResponseWriter, r *http.Request) {
	keywords := q(r, "keywords")
	where := ""
	if keywords != "" {
		where = " where username like '%" + keywords + "%' "
	}
	row := db.Exec("select u.id,u.username,u.admins,u.rtime,d.qq,d.sex,d.age,d.email from bbs_user as u left join bbs_user_detail as d on u.id=d.uid" + where)
	var rows []map[string]any
	if row != nil {
		rows = row.Rows
	}
	a.adminRender(w, r, "admin_users", map[string]any{
		"PageTitle": "用户管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rows, "Keywords": keywords, "M": "user",
	})
}

func (a *App) adminUserAdd(w http.ResponseWriter, r *http.Request) {
	username := r.PostFormValue("username")
	if r.Method == http.MethodPost && username != "" {
		password := r.PostFormValue("password")
		repass := r.PostFormValue("repass")
		if password != repass {
			JSAlert(w, "两次密码不一致！", "/admin/index.php?m=user&a=lists")
			return
		}
		if !reUsername.MatchString(username) {
			JSAlert(w, "用户名不符合规则！", "/admin/index.php?m=user&a=lists")
			return
		}
		if row := db.Exec("select username from bbs_user where bbs_user.username='" + username + "'"); row != nil && row.Ok {
			JSAlert(w, "用户已存在！", "/admin/index.php?m=user&a=lists")
			return
		}
		ins := db.Exec("insert into bbs_user(username,password,rtime,rip) values('" + username + "','" +
			MD5(password) + "','" + itoa(time.Now().Unix()) + "','0')")
		if ins != nil && ins.LastID > 0 {
			db.Exec("insert into bbs_user_detail(uid) values('" + itoa(ins.LastID) + "')")
		}
		http.Redirect(w, r, "/admin/index.php?m=user&a=lists", http.StatusFound)
		return
	}
	a.adminRender(w, r, "admin_user_add", map[string]any{
		"PageTitle": "添加用户", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// ---------- 版块 ----------

func (a *App) adminCateLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select c.*,p.pname from bbs_cate as c left join bbs_part as p on c.pid=p.id")
	var rows []map[string]any
	if row != nil {
		for _, c := range row.Rows {
			cid := toStrAny(c["uid"])
			uname := "未知"
			if u := db.Exec("select username from bbs_user where id=" + cid); u != nil && u.Ok && len(u.Rows) > 0 {
				uname = toStrAny(u.Rows[0]["username"])
			}
			c["moderator"] = uname
			rows = append(rows, c)
		}
	}
	a.adminRender(w, r, "admin_cates", map[string]any{
		"PageTitle": "版块管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rows,
	})
}

func (a *App) adminCateAdd(w http.ResponseWriter, r *http.Request) {
	cname := r.PostFormValue("cname")
	if r.Method == http.MethodPost && cname != "" {
		pid := r.PostFormValue("pid")
		db.Exec("insert into bbs_cate(pid,cname) values('" + pid + "','" + cname + "')")
		http.Redirect(w, r, "/admin/index.php?m=cate&a=lists", http.StatusFound)
		return
	}
	parts := db.Exec("select * from bbs_part")
	a.adminRender(w, r, "admin_cate_add", map[string]any{
		"PageTitle": "添加版块", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Parts": rowsOf(parts),
	})
}

// ---------- 分区 ----------

func (a *App) adminPartLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select * from bbs_part")
	var rows []map[string]any
	if row != nil {
		for _, v := range row.Rows {
			uname := "未知"
			if u := db.Exec("select username from bbs_user where id=" + toStrAny(v["padmins"])); u != nil && u.Ok && len(u.Rows) > 0 {
				uname = toStrAny(u.Rows[0]["username"])
			}
			v["moderator"] = uname
			rows = append(rows, v)
		}
	}
	a.adminRender(w, r, "admin_parts", map[string]any{
		"PageTitle": "分区管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rows,
	})
}

func (a *App) adminPartAdd(w http.ResponseWriter, r *http.Request) {
	pname := r.PostFormValue("pname")
	if r.Method == http.MethodPost && pname != "" {
		padmins := r.PostFormValue("padmins")
		db.Exec("insert into bbs_part(pname,padmins) values('" + pname + "','" + padmins + "')")
		http.Redirect(w, r, "/admin/index.php?m=part&a=lists", http.StatusFound)
		return
	}
	a.adminRender(w, r, "admin_part_add", map[string]any{
		"PageTitle": "添加分区", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// ---------- 敏感词 ----------

func (a *App) adminFilLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select * from bbs_fil")
	a.adminRender(w, r, "admin_fil", map[string]any{
		"PageTitle": "敏感词", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rowsOf(row),
	})
}

func (a *App) adminFilAdd(w http.ResponseWriter, r *http.Request) {
	hinge := r.PostFormValue("hinge")
	if r.Method == http.MethodPost && hinge != "" {
		db.Exec("insert into bbs_fil(hinge) values('" + hinge + "')")
		http.Redirect(w, r, "/admin/index.php?m=fil&a=lists", http.StatusFound)
		return
	}
	a.adminRender(w, r, "admin_fil_add", map[string]any{
		"PageTitle": "添加敏感词", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// ---------- IP 黑名单 ----------

func (a *App) adminIpreLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select * from bbs_iprefuse")
	a.adminRender(w, r, "admin_ipre", map[string]any{
		"PageTitle": "IP黑名单", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rowsOf(row),
	})
}

func (a *App) adminIpreAdd(w http.ResponseWriter, r *http.Request) {
	ipmin := r.PostFormValue("ipmin")
	ipmax := r.PostFormValue("ipmax")
	if r.Method == http.MethodPost && ipmin != "" && ipmax != "" {
		db.Exec("insert into bbs_iprefuse(id,ipmin,ipmax) values(0,'" + ipmin + "','" + ipmax + "')")
		http.Redirect(w, r, "/admin/index.php?m=ipre&a=lists", http.StatusFound)
		return
	}
	a.adminRender(w, r, "admin_ipre_add", map[string]any{
		"PageTitle": "添加IP", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

// ---------- 帖子 ----------

func (a *App) adminPostLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select p.*,u.username from bbs_post as p left join bbs_user as u on p.uid=u.id order by p.id desc limit 100")
	a.adminRender(w, r, "admin_posts", map[string]any{
		"PageTitle": "帖子管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rowsOf(row),
	})
}

func (a *App) adminPostDel(w http.ResponseWriter, r *http.Request) {
	id := q(r, "id")
	db.Exec("delete from bbs_post where id=" + id)
	http.Redirect(w, r, "/admin/index.php?m=post&a=lists", http.StatusFound)
}

// ---------- 回复 ----------

func (a *App) adminReplyLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select r.*,u.username from bbs_reply as r left join bbs_user as u on r.uid=u.id order by r.id desc limit 100")
	var rows []map[string]any
	if row != nil {
		for _, m := range row.Rows {
			m["content"] = template.HTML(toStrAny(m["content"]))
			rows = append(rows, m)
		}
	}
	a.adminRender(w, r, "admin_reply", map[string]any{
		"PageTitle": "回复管理", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rows,
	})
}

func (a *App) adminReplyDel(w http.ResponseWriter, r *http.Request) {
	id := q(r, "id")
	db.Exec("delete from bbs_reply where id=" + id)
	http.Redirect(w, r, "/admin/index.php?m=reply&a=lists", http.StatusFound)
}

// ---------- 管理员/权限 ----------

func (a *App) adminManageLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select id,username,admins,email,rtime from bbs_user")
	a.adminRender(w, r, "admin_manage", map[string]any{
		"PageTitle": "管理员权限", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rowsOf(row),
	})
}

func (a *App) adminManageMod(w http.ResponseWriter, r *http.Request) {
	id := q(r, "id")
	admins := q(r, "admins")
	if admins != "" {
		db.Exec("update bbs_user set admins='" + admins + "' where id=" + id)
	}
	http.Redirect(w, r, "/admin/index.php?m=manage&a=lists", http.StatusFound)
}

// ---------- 友情链接 ----------

func (a *App) adminFriLists(w http.ResponseWriter, r *http.Request) {
	row := db.Exec("select * from bbs_fri")
	a.adminRender(w, r, "admin_fri", map[string]any{
		"PageTitle": "友情链接", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
		"Rows": rowsOf(row),
	})
}

func (a *App) adminFriAdd(w http.ResponseWriter, r *http.Request) {
	title := r.PostFormValue("title")
	if r.Method == http.MethodPost && title != "" {
		desc1 := r.PostFormValue("desc1")
		urlv := r.PostFormValue("url")
		db.Exec("insert into bbs_fri(title,desc1,url) values('" + title + "','" + desc1 + "','" + urlv + "')")
		http.Redirect(w, r, "/admin/index.php?m=fri&a=lists", http.StatusFound)
		return
	}
	a.adminRender(w, r, "admin_fri_add", map[string]any{
		"PageTitle": "添加友链", "CurrentUser": a.GetUser(r), "ShowAdmin": true,
	})
}

func (a *App) adminFriDel(w http.ResponseWriter, r *http.Request) {
	id := q(r, "id")
	db.Exec("delete from bbs_fri where id=" + id)
	http.Redirect(w, r, "/admin/index.php?m=fri&a=lists", http.StatusFound)
}


// adminRender 渲染后台页面并注入导航高亮项
func (a *App) adminRender(w http.ResponseWriter, r *http.Request, tpl string, data map[string]any) {
	nav := map[string]string{
		"admin_index":"index","admin_users":"user","admin_user_add":"user",
		"admin_cates":"cate","admin_cate_add":"cate","admin_parts":"part","admin_part_add":"part",
		"admin_posts":"post","admin_reply":"reply","admin_fil":"fil","admin_fil_add":"fil",
		"admin_ipre":"ipre","admin_ipre_add":"ipre","admin_manage":"manage",
		"admin_fri":"fri","admin_fri_add":"fri","admin_backup":"backup","admin_ping":"ping",
	}[tpl]
	data["Nav"] = nav
	data["ShowAdmin"] = true
	data["Admin"] = true
	data["CurrentUser"] = a.GetUser(r)
	a.Render(w, tpl, data)
}

// rowsOf 安全取出 Result.Rows（nil 时返回空切片）
func rowsOf(row *db.Result) []map[string]any {
	if row == nil || !row.Ok {
		return []map[string]any{}
	}
	return row.Rows
}