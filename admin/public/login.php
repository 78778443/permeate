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
    <link href="/public/vendor/bootstrap-5.3.2/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/vendor/fontawesome-6.4.2/css/all.min.css">
    <!-- Custom Styles -->
    <link href="/home/resource/dist/style.css" rel="stylesheet">
    <style>
        body {
            background:
                radial-gradient(700px 340px at 18% 0%, rgba(99, 102, 241, 0.12), transparent 62%),
                linear-gradient(180deg, #fbfcff 0%, #f5f6f8 100%);
        }

        .admin-login {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 16px;
        }

        .admin-login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px 28px 24px;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-xl);
            background: #fff;
            box-shadow: var(--shadow-lg);
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 24px;
        }

        .login-brand .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-700));
            color: #fff;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .login-brand h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
        }

        .login-brand p {
            margin: 0;
            color: var(--gray-500);
            font-size: 12px;
        }

        .captcha-row {
            display: flex;
            align-items: stretch;
            gap: 10px;
        }

        .captcha-row .form-control {
            flex: 1;
        }

        .captcha-row img {
            width: 120px;
            height: 42px;
            object-fit: cover;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            cursor: pointer;
        }

        .login-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--gray-100);
            color: var(--gray-400);
            font-size: 12px;
        }

        .login-foot a {
            color: var(--gray-500);
        }

        .login-foot a:hover {
            color: var(--primary-600);
        }
    </style>
</head>

<body>
<div class="admin-login">
    <div class="admin-login-card">
        <div class="login-brand">
            <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
            <div>
                <h1>Permeate</h1>
                <p>后台管理系统</p>
            </div>
        </div>

        <form action="login.php" method="post">
            <div class="mb-3">
                <label class="form-label" for="admin-username">管理员账号</label>
                <input class="form-control" id="admin-username" type="text" name="username" placeholder="请输入管理员账号" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="admin-password">密码</label>
                <input class="form-control" id="admin-password" type="password" name="password" placeholder="请输入密码" required>
            </div>

            <div class="mb-4">
                <label class="form-label" for="admin-yzm">验证码</label>
                <div class="captcha-row">
                    <input class="form-control" id="admin-yzm" type="text" name="yzm" placeholder="请输入验证码" autocomplete="off">
                    <img id="yzm-img" src="/core/yzm_func.php?=<?php echo rand(1000, 3000) ?>" alt="验证码" title="点击刷新验证码">
                </div>
            </div>

            <button class="btn btn-primary w-100" type="submit">
                <i class="fas fa-sign-in-alt"></i>登录后台
            </button>
        </form>

        <div class="login-foot">
            <a href="/home/index.php"><i class="fas fa-arrow-left"></i> 返回前台</a>
            <span>仅供学习研究使用</span>
        </div>
    </div>
</div>

<script src="/public/vendor/bootstrap-5.3.2/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('yzm-img').onclick = function() {
        this.src = '/core/yzm_func.php?=' + Math.random();
    }
</script>
</body>
</html>
