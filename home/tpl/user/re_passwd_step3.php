<div class="access">
    <div class="container">
        <h2 class="text-center mb-4">重置密码</h2>
        <div class="alert alert-warning">
            <strong>漏洞说明：</strong>此功能存在密码任意修改漏洞：
            <ul>
                <li>通过email参数可修改任意邮箱对应用户的密码</li>
                <li>Token验证可绕过（传入空code即可）</li>
            </ul>
            利用方式：直接访问此页面并传入email参数：<code>?m=user&a=re_passwd_step3&email=target@example.com&code=</code>
        </div>
        <form class="form" action="/home/index.php?m=user&a=_re_passwd_step3" method="post">
            <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            <input type="hidden" name="code" value="<?php echo isset($_GET['code']) ? htmlspecialchars($_GET['code']) : ''; ?>">
            <div class="form-group">
                <label>新密码</label>
                <input class="form-control" type="password" name="password" placeholder="请输入新密码">
            </div>
            <div class="form-group">
                <label>确认密码</label>
                <input class="form-control" type="password" name="repassword" placeholder="请再次输入新密码">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    <span>重置密码</span>
                </button>
            </div>
        </form>
    </div>
</div>
