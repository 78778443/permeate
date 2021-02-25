<?php
require_once __DIR__ . '/../../core/common.php';
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $password = $_POST['password'];
    $password = md5($password);
    $yzm = $_POST['yzm'];

    if ($_SESSION['yzm'] != $yzm) {
        echo "<script>alert('验证码错误！')</script>";
        echo "<script>window.location.href='/admin/public/login.php'</script>";
        exit;
    }

    $sql = "select u.*,d.* from bbs_user as u,bbs_user_detail as d where  d.uid = u.id and  u.username='$username' and u.password='$password' and u.admins='1'";

    $row = mysql_func($sql);
    if (!$row) {
        echo "<script>alert('用户不存在！')</script>";
        echo "<script>window.location.href='/admin/public/login.php'</script>";
        exit;
    }

    //执行登陆操作
    //session的写入直接去给$_SESSION赋值
    saveAdminUser($row[0]);


    //告诉浏览器将保存sessionid的cookie文件保存一个小时
    setcookie(session_name(), session_id(), time() + 3600, "/");

    echo "<script>window.location.href='../index.php'</script>";
}


?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Permeate 后台登录</title>
    <style type="text/css">
        body {
            margin-top: 120px;
            text-align: center;
        }

        #login {
            margin-top: 32px;
            width: 420px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <link href="/home/resource/dist/bootstrap.css" rel="stylesheet">
    <link href="/home/resource/dist/style.css" rel="stylesheet">
    <!--    <link rel="stylesheet" href="/home/resource/fonts/css/fontawesome-all.min.css">-->
    <script src="/static/dist/js/jquery.min.js"></script>
    <script type="text/javascript" language="javascript">
        function reset_form() {
            document.getElementById('username').value = '';
            document.getElementById('password').value = '';
            return false;
        }

    </script>
</head>

<body>
<H1 class="text-center" style="margin: 50px ">轻松渗透测试系统-后台管理</H1>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-5">
        <form class="form-horizontal" action="login.php" method="post" id="login_form">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">用户名：</label>
                <div class="col-sm-10">
                    <input type="text" name="username" id="username" class="form-control" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">密码：</label>
                <div class="col-sm-10">
                    <input type="password" name="password" id="password" class="form-control" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">
                    验证码：
                    <img id="yzm-img" src="/core/yzm_func.php?=<?php echo rand(1000, 3000) ?>">
                </label>
                <div class="col-sm-10">
                    <input type="text" name="yzm" class="form-control" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">点击登录</button>
                    <input type="reset" class="btn btn-warning" value="重新填写"/>
                </div>
            </div>

        </form>
    </div>
    <div class="col-md-3"></div>
</div>
</body>
<script>

    $("#yzm-img").click(function () {
        $(this)[0].src = '/core/yzm_func.php?=?' + Math.random()
    })
</script>