<?php
require_once '../core/common.php';
require_once "./public/demon.php";
header('content-type:text/html;charset=utf-8');
if (empty($_SESSION['admin']['username'])) {
//    echo "<script>alert('请先登录！')</script>";
//    echo "<script>window.location.href='./public/login.php'</script>";
//    exit;
}


$model = @$_GET['m'];
$action = @$_GET['a'];
include "public/header.php";
include "public/demon.php";
include "public/order.php";//控制总线
include "public/left.php";
//include "$model/$action.php";
$all = new order;
$all->Tmp($model,$action);
//include "public/right.php"; //作废
include "public/footer.php";
?>