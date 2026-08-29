package handler

import (
	"net/http"
	"time"

	"permeate/db"
)

type CateRow struct {
	ID         string
	CName      string
	PostCount  string
	ReplyCount string
	LastTime   string
}

type PartRow struct {
	Pname     string
	AdminName string
	Cates     []CateRow
}

type FriRow struct {
	Title string
	Url   string
}

// home 根路径
func (a *App) home(w http.ResponseWriter, r *http.Request) {
	if r.URL.Path != "/" {
		http.NotFound(w, r)
		return
	}
	a.homeIndex(w, r)
}

// homeIndex 首页分区版块墙
func (a *App) homeIndex(w http.ResponseWriter, r *http.Request) {
	parts := []PartRow{}

	pr := db.Exec("SELECT * FROM bbs_part")
	allCates := db.Exec("SELECT * FROM bbs_cate")
	postStats := db.Exec("SELECT cid, COUNT(*) AS cou, MAX(ptime) AS last_ptime FROM bbs_post GROUP BY cid")
	replyStats := db.Exec("SELECT p.cid, COUNT(r.id) AS num FROM bbs_reply r LEFT JOIN bbs_post p ON r.pid=p.id GROUP BY p.cid")

	postByCID := map[string]map[string]any{}
	if postStats != nil {
		for _, s := range postStats.Rows {
			postByCID[db.Str(s["cid"])] = s
		}
	}
	replyByCID := map[string]int64{}
	if replyStats != nil {
		for _, s := range replyStats.Rows {
			replyByCID[db.Str(s["cid"])] = db.Int(s["num"])
		}
	}

	catesByPart := map[string][]map[string]any{}
	if allCates != nil {
		for _, c := range allCates.Rows {
			pid := db.Str(c["pid"])
			catesByPart[pid] = append(catesByPart[pid], c)
		}
	}

	if pr != nil {
		for _, part := range pr.Rows {
			pid := db.Str(part["id"])
			var cates []CateRow
			for _, c := range catesByPart[pid] {
				cid := db.Str(c["id"])
				crow := CateRow{
					ID:    cid,
					CName: db.Str(c["cname"]),
				}
				if s, ok := postByCID[cid]; ok {
					crow.PostCount = toStrAny(s["cou"])
					if lt := db.Int(s["last_ptime"]); lt > 0 {
						crow.LastTime = time.Unix(lt, 0).Format("2006-01-02 15:04")
					}
				}
				crow.ReplyCount = toStrAny(replyByCID[cid])
				cates = append(cates, crow)
			}
			admin := "未知"
			if ar := db.Exec("SELECT username FROM bbs_user WHERE id=" + db.Str(part["padmins"])); ar != nil && ar.Ok && len(ar.Rows) > 0 {
				admin = db.Str(ar.Rows[0]["username"])
			}
			parts = append(parts, PartRow{Pname: db.Str(part["pname"]), AdminName: admin, Cates: cates})
		}
	}

	var fris []FriRow
	if fr := db.Exec("SELECT title,url FROM bbs_fri"); fr != nil {
		for _, f := range fr.Rows {
			fris = append(fris, FriRow{Title: db.Str(f["title"]), Url: db.Str(f["url"])})
		}
	}

	// 全站统计：帖子数 / 版块数 / 分区数
	tot := db.Exec("SELECT (SELECT COUNT(*) FROM bbs_post) AS posts, (SELECT COUNT(*) FROM bbs_cate) AS cates, (SELECT COUNT(*) FROM bbs_part) AS parts")
	totalPosts, totalCates, totalParts := "0", "0", "0"
	if tot != nil && tot.Ok && len(tot.Rows) > 0 {
		totalPosts = db.Str(tot.Rows[0]["posts"])
		totalCates = db.Str(tot.Rows[0]["cates"])
		totalParts = db.Str(tot.Rows[0]["parts"])
	}

	a.Render(w, "home", map[string]any{
		"PageTitle":  "首页",
		"Parts":      parts,
		"Fris":       fris,
		"TotalPosts": totalPosts,
		"TotalCates": totalCates,
		"TotalParts": totalParts,
		"CurrentUser": a.GetUser(r),
	})
}