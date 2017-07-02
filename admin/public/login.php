<?php
	//设置页面字符集为 UTF-8
	//开启session
	session_start();
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
	
	if(isset($_POST['username'])){
				$username = $_POST['username'];
	
	$password = $_POST['password'];
	$password = md5($password);
	
	$sql = "select u.*,d.* from ".DB_PRE."user as u,".DB_PRE."user_detail as d where u.username='$username' and u.password='$password' and u.admins='1'";
	//echo $sql;
	//exit;
	//$sql = "select * from ".DB_PRE."user as u where username='$username' and password='$password' and admin='1'";
	//echo $sql;

	$row = mysql_func($sql);
	//var_dump($row);
	//echo $row;
	//exit;
	if(!$row){
		echo "<script>alert('用户不存在！')</script>";
		echo "<script>window.lockjation.href='login.php'</script>";
		exit;
		}
		
	//执行登陆操作
		//session的写入直接去给$_SESSION赋值
		$_SESSION['admin']['username'] = $row[0];
		
		
		//告诉浏览器将保存sessionid的cookie文件保存一个小时
		setcookie(session_name(),session_id(),time()+3600,"/");
		
	echo "<script>window.location.href='../index.php'</script>";
		}
		

	
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
#all {
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	width: 540px;
}
body {
	margin-top: 120px;
	text-align: center;
}
#main {
	background: url(images/login_mid.gif);
	height: 240px;
	text-align: center;
}
#title {
	height: 66px;
	margin-top: 120px;
}
#login {
	margin-top: 32px;
	width: 420px;
	margin-left: auto;
	margin-right: auto;
}
</style>
<link rel="stylesheet" type="text/css" href="../public/Bootstrap2/bootstrap.css">
<script type="text/javascript" language="javascript">
function reset_form()
{
	document.getElementById('username').value = '';
	document.getElementById('password').value = '';
	return false;
}
					 
</script>
</head>

<body>

<form action="login.php" method="post" id="login_form">
<table id="login">

<span class="label label-info">轻松参透测试系统后后台管理</span>
  <tr>
    <td>用户名： </td>
    <td><input type="text" name="username" id="username" size="32" /></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>密　码： </td>
    <td><input type="password" name="password" id="password" size="32" /></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" class="btn" value="立即登录" /><input type="reset" class="btn" value="重新填写" /></td>
  </tr>
</table>
</div>
<div id="btm">
  <div id="btm_left"></div>
  <div id="btm_mid"></div>
  <div id="btm_right"></div>
</div>
</div>
</body>
