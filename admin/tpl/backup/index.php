<div class="row">
    <div class="col-sm-12">
        <div class="card-box">
            <h4 class="header-title m-t-0 m-b-30">数据库备份</h4>
            <div class="alert alert-warning">
                <strong>漏洞说明：</strong>此功能存在命令执行漏洞，filename参数未经过滤直接拼接到系统命令中。
                <br>利用方式：<code>filename=test;cat /etc/passwd</code> 或 <code>filename=test|whoami</code>
            </div>
            <form action="./index.php?m=backup&a=_do_backup" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">备份文件名</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="filename" placeholder="请输入备份文件名，如：backup_20230101">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">开始备份</button>
                        <a href="./index.php?m=backup&a=ping" class="btn btn-info">Ping工具</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
