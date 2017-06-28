<?php
	//设置页面字符集为 UTF-8
	header('content-type:text/html;charset=utf-8');
	//开启session
	session_start();
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";

	$t_name = $_REQUEST['t_name'];
	$age = $_REQUEST['age'];
	$sex = $_REQUEST['sex'];
	$edu = $_REQUEST['edu'];
	$signed = $_REQUEST['signed'];
	$brithday = $_REQUEST['brithday'];
	$telphone = $_REQUEST['telphone'];
	$qq = $_REQUEST['qq'];
	$email = $_REQUEST['email'];

	$user = $_SESSION['home']['username'];

	
	$sql = "update ".DB_PRE."user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',brithday='$brithday',telphone='$telphone',qq='$qq',email='$email' where uid=".$user['id'];
	
	$row = mysql_func($sql);
	
	if(!$row){
			echo "<script>alert('你没有修改，或修改失败')</script>";
			echo "<script>window.location.href='../basic.php'</script>";
			exit;
	}
	
	echo "<script>alert('修改成功！')</script>";
	
	$sql = "select u.*,p.* from ".DB_PRE."user as u,".DB_PRE."user_detail as p where u.id=".$user['id'];
	
	$row = mysql_func($sql);
	
				if(!$row){
					echo "<script>alert('请重新登入')</script>";
					echo "<script>window.location.href='../index.php'</script>";
					exit;
					}
	$username = $row[0];
	//执行登陆操作
	//session的写入直接去给$_SESSION赋值
	$_SESSION['home']['username'] = $username;
	//告诉浏览器将保存sessionid的cookie文件保存一个小时
	setcookie(session_name(),session_id(),time()+3600,"/");
	echo "<script>window.location.href='../index.php'</script>";
	exit;
?>