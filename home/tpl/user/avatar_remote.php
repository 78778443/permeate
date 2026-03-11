<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                设置远程头像
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php";?>
                    <div class="col-lg-10 pt-3">
                        <div class="alert alert-warning">
                            <strong>漏洞说明：</strong>此功能存在SSRF漏洞，可以访问内网资源。
                            <br>利用方式：<code>url=http://127.0.0.1:80</code> 或 <code>url=http://internal-server/admin</code>
                        </div>
                        <div class="upload">
                            <div class="d-table-cell">
                                <form action="/home/index.php?m=user&a=_set_remote_avatar" method="post">
                                    <div class="form-group">
                                        <label>当前头像</label>
                                        <div class="upload-img-content">
                                            <img class="upload-img" src="<?php echo $user['pic']; ?>" alt="" style="max-width:200px;max-height:200px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>远程头像URL</label>
                                        <input type="text" class="form-control" name="avatar_url" placeholder="请输入远程头像URL，如：http://example.com/avatar.jpg">
                                        <small class="form-text text-muted">支持http/https协议，将获取远程图片作为您的头像</small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">保存头像</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
