<?php
require_once __DIR__ . '/../../core/common.php';
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $password = $_POST['password'];
    $password = md5($password);
    $yzm = isset($_POST['yzm']) ? $_POST['yzm'] : '';

    // 漏洞1：验证码复用 - 验证后不销毁，可重复使用
    // 漏洞2：空验证码绕过 - 如果yzm为空，跳过验证（需要注释掉下面的验证）
    // 漏洞利用：不填写验证码或使用已使用过的验证码

    // 以下验证存在漏洞：未在验证后销毁验证码
    if (!empty($yzm) && $_SESSION['yzm'] != $yzm) {
        echo "<script>alert('验证码错误！')</script>";
        echo "<script>window.location.href='/admin/public/login.php'</script>";
        exit;
    }
    // 漏洞：验证成功后未销毁验证码，可重复使用
    // 正确做法应该是：unset($_SESSION['yzm']);

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
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permeate 后台登录</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <!-- Custom Styles -->
    <link href="/home/resource/dist/style.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="access">
    <div class="container">
        <div class="text-center mb-4">
            <h2><i class="fas fa-shield-alt me-2"></i>Permeate</h2>
            <p class="text-muted mb-0">后台管理系统</p>
        </div>

        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="text" name="username" placeholder="请输入管理员账号" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-lock text-muted"></i>
                    </span>
                    <input class="form-control border-start-0" type="password" name="password" placeholder="请输入密码" required>
                </div>
            </div>

            <div class="form-group mb-3">
                <div class="input-group">
                    <input class="form-control" type="text" name="yzm" placeholder="请输入验证码" style="max-width: 200px;">
                    <img id="yzm-img" src="/core/yzm_func.php?=<?php echo rand(1000, 3000) ?>" class="rounded" style="cursor: pointer; height: 38px;" alt="验证码">
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-sign-in-alt me-2"></i>登录
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('yzm-img').onclick = function() {
        this.src = '/core/yzm_func.php?=' + Math.random();
    }
</script>
</body>
</html>
