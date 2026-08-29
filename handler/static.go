package handler

import (
	"io/fs"
	"log"
)

// assetsStatic 静态资源（/static/），映射到 assets/static
var assetsStatic fs.FS

func init() {
	sub, err := fs.Sub(Assets, "assets/static")
	if err != nil {
		log.Fatalf("加载静态资源失败: %v", err)
	}
	assetsStatic = sub
}