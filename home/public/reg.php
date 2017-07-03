<?php
//设置页面字符集为 UTF-8
header('content-type:text/html;charset=utf-8');
header('cache-control:no-cache');
session_start();//开启session
//引用函数库mysql_function.php
include "../../conf/dbconfig.php";
include "../../includes/mysql_func.php";


//if (!isset ($_SESSION['yzm'])) {
//    echo "<script>alert('参数错误，请稍候再试！')</script>";
//    echo "<script>window.location.href='../register.php'</script>";
//}

//if ($_POST['yzm'] != $_SESSION['yzm']) {
//    unset($_SESSION['yzm']);
//    echo "<script>alert('验证码错误！')</script>";
//    echo "<script>window.location.href='../register.php'</script>";
//}

unset($_SESSION['yzm']);

$username = $_POST['username'];

$password = $_POST['password'];

$repass = $_POST['repass'];

$email = $_POST['email'];

//$yzm = $_POST['yzm'];


//通过用户名从数据库中读取记录，有记录代表用户已存在
$sql = "select username from " . DB_PRE . "user where " . DB_PRE . "user.username='$username'";
if (mysql_func($sql)) {
    echo "<script>alert('用户已存在！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}


//通过正则判断用户名、密码、邮箱是否正确
$upattern = "/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/";
$ppattern = "/^[a-zA-Z0-9][a-zA-Z0-9_]{5,15}$/";
$epattern = "/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i";
if (!preg_match($upattern, $username)) {
    echo "<script>alert('用户名格式不正确！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}
if (!preg_match($ppattern, $password)) {
    echo "<script>alert('密码格式不正确！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}
if (!preg_match($epattern, $email)) {
    echo "<script>alert('邮箱格式不正确！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}

//判断两次密码是否一致
if ($password != $repass) {
    echo "<script>alert('两次密码不一致')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}
//获取服务器当前时间、客户IP
$rime = $_SERVER['REQUEST_TIME'];
$rip = ip2long($_SERVER['REMOTE_ADDR']);

//加密密码、写入数据库
$password = md5($password);
$sql = "insert into " . DB_PRE . "user(username,password,rtime,rip,email) values('$username','$password','$rime','$rip','$email')";

$id = mysql_func($sql);

//判断是否写入数据库成功
if (!$id) {
    echo "<script>alert('数据库错误：数据库写入失败！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}
//写入数据库用户详情表
$sql = "insert into " . DB_PRE . "user_detail(uid,email) values('$id','$email')";
$id = mysql_func($sql);
//判断是否写入成功
if (!$id === 0) {
    echo "<script>alert('数据库错误：数据库写入邮件失败！')</script>";
    echo "<script>window.location.href='../register.php'</script>";
    exit();
}
//自动登录
$_SESSION['username'] = $username;
setcookie();
//跳转
echo "<script>alert('注册成功！')</script>";
echo "<script>window.location.href='../index.php'</script>";
exit();
?>