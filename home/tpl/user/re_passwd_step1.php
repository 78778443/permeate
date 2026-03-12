<section class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo">
                <i class="fas fa-key"></i>
            </div>
            <h2>找回密码</h2>
            <p>重置您的账户密码</p>
        </div>

        <div class="auth-card">
            <div class="alert alert-warning mb-4">
                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                <p class="mb-0">此功能存在多个安全漏洞：</p>
                <ul class="mb-0 mt-2 ps-3">
                    <li>验证码可绕过（验证逻辑存在缺陷）</li>
                    <li>Token可预测（使用时间戳MD5）</li>
                    <li>可修改任意用户密码</li>
                </ul>
            </div>

            <form action="/home/index.php?m=user&a=_re_passwd_step1" method="post">
                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-envelope me-1"></i>邮箱地址</label>
                    <input class="form-control form-control-lg" type="email" name="email" placeholder="请输入注册时使用的邮箱" required>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-shield-alt me-1"></i>验证码</label>
                    <div class="d-flex gap-2">
                        <input class="form-control" type="text" name="captcha" placeholder="请输入验证码" required style="flex: 1;">
                        <img src="/core/yzm_func.php" id="captchaImg" class="rounded" style="cursor: pointer; height: 48px; width: 120px; flex-shrink: 0;" alt="验证码">
                    </div>
                    <small class="text-muted">点击图片刷新验证码</small>
                </div>

                <div class="mb-4">
                    <button class="btn btn-primary btn-lg w-100" type="submit">
                        <i class="fas fa-paper-plane me-2"></i>发送重置链接
                    </button>
                </div>

                <div class="text-center">
                    <a href="./index.php?m=user&a=login"><i class="fas fa-arrow-left me-1"></i>返回登录</a>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
document.getElementById('captchaImg').onclick = function() {
    this.src = '/core/yzm_func.php?' + Math.random();
}
</script>
