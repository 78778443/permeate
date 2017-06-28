<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php

	if(!empty($_POST['username'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$repass= $_POST['repass'];
		$rtime = $_SERVER['REQUEST_TIME'];
		$rip = ip2long($_SERVER['REMOTE_ADDR']);
		
		if($password!=$repass){
			echo "<script>alert('两次密码不一致！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}

		$pattern="/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/";
			
		if(!preg_match($pattern,$username)){
			echo "<script>alert('用户名不符合规则！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}

		
		$sql = "select username from ".DB_PRE."user where ".DB_PRE."user.username='$username'";
		
		$row = mysql_func($sql);

		if($row){
			echo "<script>alter('用户已存在！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}
		$password = md5($password);
		$sql = "insert into ".DB_PRE."user(username,password,rtime,rip) values('$username','$password','$rtime','$rip')";
		
		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}
		
		$sql = "insert into ".DB_PRE."user_detail(uid) values('$row')";	
		$row = mysql_func($sql);
		
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='add.php'<script/>";
			exit;
		}

		//header("location:list.php");
		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}

?>
<div class="container">
<form action="add.php" method="post" >
	<table>
	<tr><td>用户名：</td><td><input type="text" name="username"   /></td></tr>
	<tr><td>密　码：</td><td><input type="password" name="password" /><p/></td></tr>
	<tr><td>确认密码：</td><td><input type="password" name="repass" /><p/></td></tr>
	<tr><td><input type="submit" class="btn"  value="添加用户" /></td><td>
	<input type="reset" class="btn" value="重新填写" /></td></tr>
    </table>
</div>
</form>