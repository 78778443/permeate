<?php
if (!session_id()) session_start();//开启session

if (empty($_SESSION['admin']['username'])) {
    echo "<script>alert('请先登录！')</script>";
    echo "<script>window.location.href='../public/login.php'</script>";
    exit;
}
?>
<link rel="stylesheet" type="text/css" href="../public/Bootstrap2/bootstrap.css"/>