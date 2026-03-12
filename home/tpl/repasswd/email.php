<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-header text-center">
                        <i class="fas fa-envelope me-2"></i>邮箱验证
                    </div>
                    <div class="paper-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-envelope-open-text fa-4x text-primary mb-3"></i>
                            <h5>验证邮件已发送</h5>
                        </div>

                        <p class="text-muted mb-2">
                            设置新密码的链接已经发送至
                        </p>
                        <p class="text-primary fw-bold mb-4">
                            <?= isset($email) ? htmlspecialchars($email) : 'your@email.com' ?>
                        </p>

                        <div class="alert alert-info border-0 text-start">
                            <i class="fas fa-info-circle me-2"></i>
                            请您在48小时之内登录邮箱，点击邮箱内链接设置新密码
                        </div>

                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary btn-lg" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>去邮箱收信
                            </a>
                            <a href="javascript:history.back()" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>返回
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
