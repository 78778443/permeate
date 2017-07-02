<?php
	//设置页面字符集为 UTF-8
	header('content-type:text/html;charset=utf-8');
	//开启session
	session_start();
	include "../../conf/dbconfig.php";
	include "../../core/mysql_func.php";

	$oldpassword = $_REQUEST['oldpassword'];
	$newpassword = $_REQUEST['newpassword'];
	$newpassword2 = $_REQUEST['newpassword2'];
	
	if(empty($oldpassword)){
			echo "<script>alert('请输入当前密码！')</script>";
			echo "<script>window.location.href='../safe.php'</script>";
			exit;
	}
	if(empty($newpassword)&&empty($newpassword2)){
			echo "<script>alert('请输入新的密码！')</script>";
			echo "<script>window.location.href='../safe.php'</script>";
			exit;
	}
	if($newpassword!==$newpassword2){
			echo "<script>alert('两次密码不一致！')</script>";
			echo "<script>window.location.href='../safe.php'</script>";
			exit;
	}
	
	$oldpassword = md5($oldpassword);
	$newpassword = md5($newpassword);
	$user = $_SESSION['home']['username'];
	
	
	$sql = "select * from ".DB_PRE."user where password='$oldpassword' and id='".$user['id']."'";

	$row = mysql_func($sql);
	if(!$row){
			echo "<script>alert('请输入正确的当前密码！')</script>";
			echo "<script>window.location.href='../safe.php'</script>";
			exit;
	}
	
	$sql = "update ".DB_PRE."user set password='$newpassword' where id='".$user['id']."'";
	
	$row = mysql_func($sql);
	if(!$row){
			echo "<script>alert('抱歉,密码修改失败.')</script>";
			echo "<script>window.location.href='../safe.php'</script>";
			exit;
	}
	
	unset($_SESSION['home']['username']);
	setcookie(time()-1,'/');
	echo "<script>alert('你的密码修改成功,请用新的密码登入.')</script>";
			echo "<script>window.location.href='../index.php'</script>";
	exit;
?>