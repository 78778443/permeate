<div class="access">
    <div class="container">
        <div class="text-center mb-4">
            <h2><i class="fas fa-key me-2"></i>找回密码</h2>
            <p class="text-muted mb-0">密码重置功能</p>
        </div>

        <div class="alert alert-warning border-0">
            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
            <p class="mb-0">此功能存在多个安全漏洞：</p>
            <ul class="mb-0">
                <li>验证码可绕过（验证逻辑存在缺陷）</li>
                <li>Token可预测（使用时间戳MD5）</li>
                <li>可修改任意用户密码</li>
            </ul>
        </div>

        <form class="form" action="/home/index.php?m=user&a=_re_passwd_step1" method="post">
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope me-1"></i>请输入您的邮箱地址</label>
                <input class="form-control form-control-lg" type="email" name="email" placeholder="请输入注册时使用的邮箱" required>
            </div>

            <div class="mb-4">
                <label class="form-label"><i class="fas fa-shield-alt me-1"></i>验证码</label>
                <div class="input-group">
                    <input class="form-control form-control-lg" type="text" name="captcha" placeholder="请输入验证码" required>
                    <img src="/core/yzm_func.php" id="captchaImg" class="rounded" style="cursor: pointer; height: 48px;" alt="验证码">
                </div>
            </div>

            <button class="btn btn-primary btn-lg w-100" type="submit">
                <i class="fas fa-paper-plane me-2"></i>发送重置链接
            </button>
        </form>
    </div>
</div>
<script>
document.getElementById('captchaImg').onclick = function() {
    this.src = '/core/yzm_func.php?' + Math.random();
}
</script>
