<?php
require_once '../core/common.php';
require_once "./public/demon.php";
if (empty(getAdminUser())) {
    echo "<script>alert('请先登录！')</script>";
    echo "<script>window.location.href='./public/login.php'</script>";
    exit;
}


require_once "public/header.php";
require_once "public/left.php";
//require_once "public/right.php";
includeAction($model, $action);
require_once "public/footer.php";
?>