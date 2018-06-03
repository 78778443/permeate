<div class="access">
    <div class="container">
        <h2 class="text-center mb-4">注 册</h2>
        <form class="form" action="./public/reg.php" method="post">
            <div class="form-group"><input class="form-control" type="text" name="username" maxlength="16" placeholder="请输入注册账号" value="">
            </div>
            <div class="form-group"><input class="form-control" type="password" name="password" maxlength="16" placeholder="请输入注册密码" value="">
            </div>
            <div class="form-group"><input class="form-control" type="password" name="repass" maxlength="16" placeholder="请再一次确认密码" value="">
            </div>
            <div class="form-group"><input class="form-control" type="email" name="repass" maxlength="16" placeholder="请输入邮箱" value="">
            </div>
            <div class="form-group"><button class="btn btn-primary" style="width: 100%;">
                <span>注册账号</span></button>Or 
                <a href="./index.php?m=user&a=login" style="padding-top: 10px; display: inline-block;">已有账户</a>
            </div>
        </form>
    </div>
</div>