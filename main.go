package main

import (
	"flag"
	"fmt"
	"log"
	"os/exec"
	"runtime"
	"time"

	"permeate/db"
	"permeate/handler"
)

func main() {
	port := flag.String("port", "8080", "监听端口")
	noBrowser := flag.Bool("no-browser", false, "不自动打开浏览器")
	flag.Parse()

	// 每次启动重置一个干净数据库（教学靶场，本地练习默认重置）
	dbPath := "data/permeate.db"
	if err := db.Open(dbPath); err != nil {
		log.Fatalf("初始化数据库失败: %v\n请确保程序运行目录可写。", err)
	}

	app, err := handler.NewApp(*port)
	if err != nil {
		log.Fatalf("初始化失败: %v", err)
	}

	addr := ":" + *port
	url := fmt.Sprintf("http://127.0.0.1:%s/", *port)

	fmt.Println("========================================")
	fmt.Println("  Permeate 渗透测试靶场 (Go 版)")
	fmt.Println("  地址: " + url)
	fmt.Println("  管理员: admin / 123456")
	fmt.Println("  测试用户: test / 123456")
	fmt.Println("  按 Ctrl+C 退出")
	fmt.Println("========================================")

	if !*noBrowser && runtime.GOOS == "windows" {
		go func() {
			time.Sleep(500 * time.Millisecond)
			_ = exec.Command("cmd", "/C", "start", url).Run()
		}()
	}

	if err := app.ListenAndServe(addr); err != nil {
		log.Fatal(err)
	}
}