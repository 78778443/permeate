<div class="access">
    <div class="container">
        <div class="text-center mb-4">
            <h2><i class="fas fa-user-plus me-2"></i>注册账号</h2>
            <p class="text-muted mb-0">加入渗透测试学习社区</p>
        </div>

        <form class="form" action="./public/reg.php" method="post">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="text" name="username" maxlength="16" placeholder="请输入账号" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="password" name="password" maxlength="16" placeholder="请输入密码" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="password" name="repass" maxlength="16" placeholder="请确认密码" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-envelope text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="email" name="email" maxlength="32" placeholder="请输入邮箱" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-user-plus me-2"></i>注册
                </button>
            </div>

            <div class="text-center">
                <span class="text-muted">已有账号？</span>
                <a href="./index.php?m=user&a=login">立即登录</a>
            </div>
        </form>
    </div>
</div>
