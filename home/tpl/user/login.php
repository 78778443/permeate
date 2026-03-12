<div class="access">
    <div class="container">
        <div class="text-center mb-4">
            <h2><i class="fas fa-shield-alt me-2"></i>Permeate</h2>
            <p class="text-muted mb-0">渗透测试靶场系统</p>
        </div>

        <form class="form" action="./public/login.php" method="post">
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
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i>登录
                </button>
            </div>

            <div class="text-center">
                <span class="text-muted">还没有账号？</span>
                <a href="./index.php?m=user&a=register">立即注册</a>
            </div>
        </form>
    </div>
</div>
