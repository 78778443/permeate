<link rel="stylesheet" type="text/css" href="./resource/styles/register.css"/>

<!--主体start-->
<div id="main">
    <div id="main_title">
        <span>用户登录</span>
    </div>
    <div id="main_content">
        <div class="fri_tab">
            <form action="./public/login.php" method="post">
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户名</label>
                    <div class="col-sm-9">
                        <input type="text" name="username" class="form-control"
                               placeholder="用户名需要4~15位字母或数字"></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">密码</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control"
                               placeholder="密码5~15位字母或数字"></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">&nbsp;</label>
                    <div class="col-sm-7">
                        <input type="submit" name="zhuce" value="登录" class="btn btn-success"/>
                        <input type="reset" name="chongzhi" value="重置" class="btn btn-default"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
