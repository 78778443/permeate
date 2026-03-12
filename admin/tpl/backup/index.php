<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-database me-2"></i>数据库备份
                <span class="badge bg-danger ms-2">RCE漏洞</span>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                    <p class="mb-0">此功能存在命令执行漏洞，filename参数未经过滤直接拼接到系统命令中。</p>
                    <hr>
                    <p class="mb-0"><strong>利用方式：</strong><code>filename=test;cat /etc/passwd</code> 或 <code>filename=test|whoami</code></p>
                </div>

                <form action="./index.php?m=backup&a=_do_backup" method="post">
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label">
                            <i class="fas fa-file me-1"></i>备份文件名
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="filename" placeholder="backup_20230101">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-download me-1"></i>开始备份
                            </button>
                            <a href="./index.php?m=backup&a=ping" class="btn btn-outline-info ms-2">
                                <i class="fas fa-network-wired me-1"></i>Ping工具
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
