<?php
require_once '../core/common.php';
require_once "./public/demon.php";
if (empty($_SESSION['admin']['username'])) {
    echo "<script>alert('请先登录！')</script>";
    echo "<script>window.location.href='./public/login.php'</script>";
    exit;
}


include "public/header.php";
include "public/left.php";
//include "public/right.php";
includeAction($model,$action);
include "public/footer.php";
?>