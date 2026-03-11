<div class="access">
    <div class="container">
        <h2 class="text-center mb-4">找回密码</h2>
        <div class="alert alert-warning">
            <strong>漏洞说明：</strong>此功能存在多个安全漏洞：
            <ul>
                <li>验证码可绕过（验证逻辑存在缺陷）</li>
                <li>Token可预测（使用时间戳MD5）</li>
                <li>可修改任意用户密码</li>
            </ul>
        </div>
        <form class="form" action="/home/index.php?m=user&a=_re_passwd_step1" method="post">
            <div class="form-group">
                <label>请输入您的邮箱地址</label>
                <input class="form-control" type="email" name="email" placeholder="请输入注册时使用的邮箱">
            </div>
            <div class="form-group">
                <label>验证码</label>
                <div class="row">
                    <div class="col-8">
                        <input class="form-control" type="text" name="captcha" placeholder="请输入验证码">
                    </div>
                    <div class="col-4">
                        <img src="/core/yzm_func.php" id="captchaImg" style="cursor:pointer;height:38px;">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    <span>发送重置链接</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('captchaImg').onclick = function() {
    this.src = '/core/yzm_func.php?' + Math.random();
}
</script>
