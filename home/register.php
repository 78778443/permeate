<?php
session_start();
include "public/header.php";
include "../includes/mysql_func.php";
?>
    <link rel="stylesheet" type="text/css" href="./resource/styles/register.css"/>

    <!--主体start-->
    <div id="main">
        <div id="main_title">
            <span>立即注册</span>
        </div>
        <div id="main_content">
            <div class="fri_tab">
                <form action="./public/reg.php" method="post">
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
                        <label class="col-sm-3 control-label">重复密码</label>
                        <div class="col-sm-9">
                            <input type="password" name="repass" class="form-control"
                                   placeholder="确认密码需要与密码一致"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control"
                                   placeholder="输入一个正确的邮箱地址"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">验证码</label>
                        <div class="col-sm-5">
                            <input type="text" name="yzm" class="form-control" placeholder="验证码">
                        </div>
                        <div class="col-sm-4">
                            <img src="../includes/yzm_func.php" alt="看不清楚,请点击刷新验证码" style="cursor : pointer;"
                                 onClick="this.src='../includes/yzm_func.php?t='+(new Date().getTime());"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">&nbsp;</label>
                        <div class="col-sm-7">
                            <input type="submit" name="zhuce" value="注册" class="btn btn-success"/>
                            <input type="reset" name="chongzhi" value="重置" class="btn btn-default"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--主体end-->
<?php
include "public/footer.php";
?>