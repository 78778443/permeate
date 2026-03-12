<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-globe me-2"></i>设置远程头像
                <span class="badge bg-warning text-dark ms-2">SSRF漏洞</span>
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php";?>
                    <div class="col-lg-8 pt-3">
                        <div class="alert alert-warning border-0">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                            <p class="mb-0">此功能存在SSRF漏洞，可以访问内网资源。</p>
                            <hr>
                            <p class="mb-0"><strong>利用方式：</strong><code>url=http://127.0.0.1:80</code> 或 <code>url=http://internal-server/admin</code></p>
                        </div>

                        <form action="/home/index.php?m=user&a=_set_remote_avatar" method="post">
                            <div class="mb-4 text-center">
                                <div class="upload-img-content mx-auto mb-3" style="width: 150px; height: 150px;">
                                    <img src="<?= htmlspecialchars($user['pic']) ?>" alt="当前头像" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <p class="text-muted">当前头像</p>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-link me-1"></i>远程头像URL</label>
                                <input type="url" class="form-control form-control-lg" name="avatar_url" placeholder="http://example.com/avatar.jpg" required>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>支持http/https协议，将获取远程图片作为您的头像
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-1"></i>保存头像
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
