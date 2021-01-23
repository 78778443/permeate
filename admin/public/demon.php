<?php
if (!session_id()) session_start();//开启session

if (empty(getAdminUser())) {
    echo "<script>alert('请先登录！')</script>";
    echo "<script>window.location.href='./public/login.php'</script>";
    exit;
}
?>