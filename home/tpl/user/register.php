<section class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-rocket"></i>
            </div>
            <h2>创建账号</h2>
            <p>加入安全学习社区</p>
        </div>

        <div class="auth-card">
            <form action="./public/reg.php" method="post">
                <div class="mb-3">
                    <label class="form-label">账号</label>
                    <input class="form-control" type="text" name="username" maxlength="16" placeholder="请输入账号" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">密码</label>
                    <input class="form-control" type="password" name="password" maxlength="16" placeholder="请输入密码" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">确认密码</label>
                    <input class="form-control" type="password" name="repass" maxlength="16" placeholder="请再次输入密码" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">邮箱</label>
                    <input class="form-control" type="email" name="email" maxlength="32" placeholder="请输入邮箱" required>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fas fa-rocket me-2"></i>开始学习
                    </button>
                </div>

                <div class="text-center">
                    <span class="text-muted">已有账号？</span>
                    <a href="./index.php?m=user&a=login">立即登录</a>
                </div>
            </form>
        </div>
    </div>
</section>
