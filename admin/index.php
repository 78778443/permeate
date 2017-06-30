<?php
session_start();//开启session
if (empty($_SESSION['admin']['username'])) {
//    echo "<script>alert('请先登录！')</script>";
//    echo "<script>window.location.href='./public/login.php'</script>";
//    exit;
}


$model = !empty($_GET['m']) ? $_GET['m'] : 'post';
$action = !empty($_GET['a']) ? $_GET['a'] : 'list';



include "public/header.php";
include "public/left.php";
//include "$model/$action.php";
include "public/right.php";
include "public/footer.php";
?>