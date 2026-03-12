<?php
// admin/public/demon.php - 后台权限验证
// 注意：common.php 已经在 admin/index.php 中引入并启动了 session

// 获取当前用户
$adminUser = getAdminUser();

// 检查用户是否登录且是管理员
if (empty($adminUser) || !isset($adminUser['admins']) || $adminUser['admins'] != 1) {
    echo "<script>alert('请先登录！')</script>";
    echo "<script>window.location.href='./public/login.php'</script>";
    exit;
}
?>