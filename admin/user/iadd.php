<?php
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
	if(!empty($_POST['username'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$repass= $_POST['repass'];
		$rtime = $_SERVER['REQUEST_TIME'];
		$rip = ip2long($_SERVER['REMOTE_ADDR']);
		echo "233";
		if($password!=$repass){
			echo "<script>alert('两次密码不一致！')</script>";
			echo "<script>window.location.href='../index.php?m=user&a=list'</script>";
			exit;
		}

		$pattern="/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/";
			
		if(!preg_match($pattern,$username)){
			echo "<script>alert('用户名不符合规则！')</script>";
			echo "<script>window.location.href='../index.php?m=user&a=list'</script>";
			exit;
		}

		
		$sql = "select username from ".DB_PRE."user where ".DB_PRE."user.username='$username'";
		
		$row = mysql_func($sql);

		if($row){
			echo "<script>alter('用户已存在！')</script>";
			echo "<script>window.location.href='../index.php?m=user&a=list'</script>";
			exit;
		}
		$password = md5($password);
		$sql = "insert into ".DB_PRE."user(username,password,rtime,rip) values('$username','$password','$rtime','$rip')";
		
		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.php?m=user&a=list'</script>";
			exit;
		}
		
		$sql = "insert into ".DB_PRE."user_detail(uid) values('$row')";	
		$row = mysql_func($sql);
		
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.php?m=user&a=list'<script/>";
			exit;
		}

		//header("location:list.php");
		echo "<script>window.location.href='../index.php?m=user&a=list'</script>";
		exit;
	}
?>