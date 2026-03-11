<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">网络诊断工具 - Ping</h4>
            <div class="alert alert-warning">
                <strong>漏洞说明：</strong>此功能存在命令执行漏洞，IP参数未经过滤直接拼接到系统命令中。
                <br>利用方式：<code>ip=127.0.0.1;cat /etc/passwd</code> 或 <code>ip=127.0.0.1|id</code>
            </div>
            <form action="./index.php?m=backup&a=_do_ping" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">IP地址</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ip" placeholder="请输入要Ping的IP地址，如：127.0.0.1">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">开始Ping</button>
                        <a href="./index.php?m=backup&a=index" class="btn btn-default">返回备份</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
