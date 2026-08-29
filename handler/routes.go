package handler

import (
	"net/http"
)

// Handler 返回整个应用的 HTTP 处理器
func (a *App) Handler() http.Handler {
	mux := http.NewServeMux()

	// 前台入口
	mux.HandleFunc("/home/index.php", a.frontDispatch)
	mux.HandleFunc("/home/public/login", a.login)
	mux.HandleFunc("/home/public/reg", a.register)
	mux.HandleFunc("/home/public/logout", a.logout)
	mux.HandleFunc("/home/fatie.php", a.createPost)
	mux.HandleFunc("/home/post.php", a.postDetail)
	mux.HandleFunc("/home/clist.php", a.tieziIndex)
	mux.HandleFunc("/home/hadel/dosafe.php", a.doSafe)

	// 后台入口
	mux.HandleFunc("/admin/index.php", a.adminDispatch)
	mux.HandleFunc("/admin/public/logout", a.adminLogout)

	// 首页 / 静态资源
	mux.HandleFunc("/", a.home)
	mux.Handle("/uploads/", http.StripPrefix("/uploads/",
		http.FileServer(http.Dir("./uploads"))))
	mux.Handle("/static/", http.StripPrefix("/static/",
		http.FileServer(http.FS(assetsStatic))))

	return mux
}

// q 读取查询/表单参数
func q(r *http.Request, key string) string {
	return r.URL.Query().Get(key)
}

// frontDispatch 按 ?m=&a= 分发前台
func (a *App) frontDispatch(w http.ResponseWriter, r *http.Request) {
	m := q(r, "m")
	if m == "" {
		m = "index"
	}
	action := q(r, "a")
	if action == "" {
		action = "index"
	}
	a.dispatchFront(w, r, m, action)
}

func (a *App) dispatchFront(w http.ResponseWriter, r *http.Request, m, action string) {
	switch m {
	case "index":
		a.homeIndex(w, r)
	case "user":
		a.dispatchUser(w, r, action)
	case "tiezi":
		a.dispatchTiezi(w, r, action)
	case "repasswd":
		a.dispatchRepasswd(w, r, action)
	default:
		http.NotFound(w, r)
	}
}

func (a *App) dispatchUser(w http.ResponseWriter, r *http.Request, action string) {
	switch action {
	case "login":
		a.login(w, r)
	case "register":
		a.register(w, r)
	case "logout":
		a.logout(w, r)
	case "individual":
		a.individual(w, r)
	case "basic":
		a.basic(w, r)
	case "_dobasic":
		a.doBasic(w, r)
	case "safe":
		a.safe(w, r)
	case "_dosafe":
		a.doSafe(w, r)
	case "info":
		a.userInfo(w, r)
	case "avatar_remote":
		a.avatarRemote(w, r)
	case "_set_remote_avatar":
		a.setRemoteAvatar(w, r)
	case "upload_file":
		a.uploadFile(w, r)
	case "_upload_file":
		a.doUploadFile(w, r)
	case "follow":
		a.follow(w, r)
	case "re_passwd_step1":
		a.repasswdStep1(w, r)
	case "_re_passwd_step1":
		a.doRepasswdStep1(w, r)
	case "re_passwd_step2":
		a.repasswdStep2(w, r)
	case "re_passwd_step3":
		a.repasswdStep3(w, r)
	case "_re_passwd_step3":
		a.doRepasswdStep3(w, r)
	case "re_passwd_step4":
		a.repasswdStep4(w, r)
	case "":
		a.login(w, r)
	default:
		http.NotFound(w, r)
	}
}

func (a *App) dispatchTiezi(w http.ResponseWriter, r *http.Request, action string) {
	switch action {
	case "index":
		a.tieziIndex(w, r)
	case "detail":
		a.tieziDetail(w, r)
	case "reply":
		a.reply(w, r)
	default:
		http.NotFound(w, r)
	}
}

func (a *App) dispatchRepasswd(w http.ResponseWriter, r *http.Request, action string) {
	switch action {
	case "index":
		a.repasswdIndex(w, r)
	case "_index":
		a.repasswdDoIndex(w, r)
	case "email":
		a.repasswdEmail(w, r)
	case "phone":
		a.repasswdPhone(w, r)
	case "newpasswd":
		a.repasswdNewpasswd(w, r)
	case "success":
		a.repasswdSuccess(w, r)
	default:
		http.NotFound(w, r)
	}
}

// adminDispatch 按 ?m=&a= 分发后台，需管理员
func (a *App) adminDispatch(w http.ResponseWriter, r *http.Request) {
	u := a.GetUser(r)
	if u == nil || toAdmin(u) != 1 {
		a.adminLogin(w, r)
		return
	}
	m := q(r, "m")
	if m == "" {
		m = "index"
	}
	action := q(r, "a")
	if action == "" {
		action = "index"
	}
	a.dispatchAdmin(w, r, m, action)
}

func (a *App) dispatchAdmin(w http.ResponseWriter, r *http.Request, m, action string) {
	switch m {
	case "index":
		a.adminIndex(w, r)
	case "backup":
		switch action {
		case "index":
			a.adminBackup(w, r)
		case "_do_backup":
			a.adminDoBackup(w, r)
		case "ping":
			a.adminPing(w, r)
		case "_do_ping":
			a.adminDoPing(w, r)
		}
	case "user":
		switch action {
		case "lists":
			a.adminUserLists(w, r)
		case "add":
			a.adminUserAdd(w, r)
		}
	case "cate":
		switch action {
		case "lists":
			a.adminCateLists(w, r)
		case "add":
			a.adminCateAdd(w, r)
		}
	case "part":
		switch action {
		case "lists":
			a.adminPartLists(w, r)
		case "add":
			a.adminPartAdd(w, r)
		}
	case "fil":
		switch action {
		case "lists":
			a.adminFilLists(w, r)
		case "add":
			a.adminFilAdd(w, r)
		}
	case "ipre":
		switch action {
		case "lists":
			a.adminIpreLists(w, r)
		case "add":
			a.adminIpreAdd(w, r)
		}
	case "post":
		switch action {
		case "lists":
			a.adminPostLists(w, r)
		case "del":
			a.adminPostDel(w, r)
		}
	case "reply":
		switch action {
		case "lists":
			a.adminReplyLists(w, r)
		case "del":
			a.adminReplyDel(w, r)
		}
	case "manage":
		switch action {
		case "lists":
			a.adminManageLists(w, r)
		case "mod":
			a.adminManageMod(w, r)
		}
	case "fri":
		switch action {
		case "lists":
			a.adminFriLists(w, r)
		case "add":
			a.adminFriAdd(w, r)
		case "del":
			a.adminFriDel(w, r)
		}
	default:
		http.NotFound(w, r)
	}
}