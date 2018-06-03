<!--辅助类，垂直居中-->
<!-- <div class="vertical-center">
    <div class="sign paper vertical-middle">
        <div class="sign-header">
            <h2>Permeate</h2>
        </div>
        <div class="sign-body">
            <div class="sign-controller">
                <div class="sign-controller-item">
                    <a class="is-active" role="button">
                        登陆
                    </a>
                </div>
                <div class="sign-controller-item">
                    <a role="button">
                        注册
                    </a>
                </div>
            </div>
            <div class="sign-container">
                <div class="sign-container-item is-active">
                    <form action="./public/login.php" method="post">
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">账号</span>
                                <input class="form-outline-input" type="text" name="username" value="" placeholder="请输入账号">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">密码</span>
                                <input class="form-outline-input" type="password" name="password" value="" placeholder="请输入密码">
                            </label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" >登陆</button>
                        </div>

                    </form>
                </div>
                <div class="sign-container-item">
                    <form action="./public/reg.php" method="post">
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">账号</span>
                                <input class="form-outline-input" type="text" name="username" value="" placeholder="请输入账号">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">密码</span>
                                <input class="form-outline-input" type="password" name="password" value="" placeholder="请输入密码">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">确认密码</span>
                                <input class="form-outline-input" type="password" name="repass" value="" placeholder="请再次确认密码">
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="form-outline-label">
                                <span class="label-title">邮箱</span>
                                <input class="form-outline-input" type="email" name="email" value="" placeholder="请输入邮箱地址">
                            </label>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" >注册</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div> -->

<div class="access">
    <div class="container">
        <h2 class="text-center mb-4">登陆查看更多</h2>
        <form class="form" action="./public/login.php" method="post">
            <div class="form-group"><input class="form-control" type="text" name="username" maxlength="16" placeholder="输入你的账号" value=""></div>
            <div class="form-group"><input class="form-control" type="password" name="password" maxlength="16" placeholder="输入你的密码" value=""></div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    <span>登陆</span>
                </button>Or <a href="./index.php?m=user&a=register" style="padding-top: 10px; display: inline-block;">立即注册</a></div>
        </form>
    </div>
</div>


<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="resource/dist/js/sign.js"></script>