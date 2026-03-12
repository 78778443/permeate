<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-header text-center">
                        <i class="fas fa-key me-2"></i>找回密码
                        <span class="badge bg-danger ms-2">密码重置漏洞</span>
                    </div>
                    <div class="paper-body">
                        <form action="/home/index.php?m=repasswd&a=_index" method="post">
                            <div class="mb-4 text-center">
                                <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                                <p class="text-muted">请输入注册的手机号/邮箱/用户名</p>
                            </div>

                            <div class="mb-3">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control border-start-0" placeholder="手机号/邮箱/用户名" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <input type="text" name="yzm" class="form-control" placeholder="请输入验证码" required>
                                    <img src="/core/yzm_func.php" class="rounded" style="cursor: pointer; height: 42px;" alt="验证码" onclick="this.src='/core/yzm_func.php?='+Math.random()">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-arrow-right me-2"></i>下一步
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
