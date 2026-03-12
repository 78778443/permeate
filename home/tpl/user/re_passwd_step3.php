<section class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-lock"></i>
            </div>
            <h2>重置密码</h2>
            <p>设置您的新密码</p>
        </div>

        <div class="auth-card">
            <div class="alert alert-warning mb-4">
                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                <p class="mb-0">此功能存在密码任意修改漏洞：</p>
                <ul class="mb-0 mt-2 ps-3">
                    <li>通过email参数可修改任意邮箱对应用户的密码</li>
                    <li>Token验证可绕过（传入空code即可）</li>
                </ul>
                <div class="mt-2">
                    <strong>利用方式：</strong>
                    <code class="d-block mt-1 p-2 bg-light rounded">?m=user&a=re_passwd_step3&email=target@example.com&code=</code>
                </div>
            </div>

            <form action="/home/index.php?m=user&a=_re_passwd_step3" method="post">
                <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
                <input type="hidden" name="code" value="<?php echo isset($_GET['code']) ? htmlspecialchars($_GET['code']) : ''; ?>">

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-1"></i>新密码</label>
                    <input class="form-control" type="password" name="password" placeholder="请输入新密码" required>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-lock me-1"></i>确认密码</label>
                    <input class="form-control" type="password" name="repassword" placeholder="请再次输入新密码" required>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fas fa-save me-2"></i>重置密码
                    </button>
                </div>

                <div class="text-center">
                    <a href="./index.php?m=user&a=login"><i class="fas fa-arrow-left me-1"></i>返回登录</a>
                </div>
            </form>
        </div>
    </div>
</section>
