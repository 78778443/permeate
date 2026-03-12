<section class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2>欢迎回来</h2>
            <p>登录 Permeate 开始安全学习之旅</p>
        </div>

        <div class="auth-card">
            <form action="./public/login.php" method="post">
                <div class="mb-3">
                    <label class="form-label">账号</label>
                    <input class="form-control" type="text" name="username" maxlength="16" placeholder="请输入账号" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">密码</label>
                    <input class="form-control" type="password" name="password" maxlength="16" placeholder="请输入密码" required>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fas fa-sign-in-alt me-2"></i>登录
                    </button>
                </div>

                <div class="text-center">
                    <span class="text-muted">还没有账号？</span>
                    <a href="./index.php?m=user&a=register">立即注册</a>
                </div>
            </form>
        </div>

        <div class="auth-features">
            <h6>学习内容</h6>
            <div class="feature-item">
                <i class="fas fa-database sql"></i>
                <span>SQL注入、XSS跨站、命令执行</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-code xss"></i>
                <span>文件上传、越权访问、SSRF</span>
            </div>
            <div class="feature-item">
                <i class="fas fa-terminal cmd"></i>
                <span>8大漏洞类型，实战演练</span>
            </div>
        </div>
    </div>
</section>
