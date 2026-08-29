@echo off
REM 交叉编译 Windows 版 permeate.exe（双击即可运行）
REM 需要已安装 Go 1.21+，且本目录下 go.mod / go build 可用
setlocal
set GOOS=windows
set GOARCH=amd64
set CGO_ENABLED=0
echo 正在编译 Windows 版...
go build -ldflags "-s -w" -o permeate.exe .
if %errorlevel% neq 0 (
  echo 编译失败，请检查 Go 环境和网络（首次需下载依赖）。
  exit /b %errorlevel%
)
echo 完成：permeate.exe 已生成
endlocal