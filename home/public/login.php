<?php
	//设置页面字符集为 UTF-8
	header('content-type:text/html;charset=utf-8');
	//开启session
	session_start();
	include "../../conf/dbconfig.php";
	include "../../core/mysql_func.php";
	
	if(isset($_POST['username'])){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$password = md5($password);	
				$sql = "select u.*,d.* from bbs_user as u, bbs_user_detail as d where d.uid=u.id and u.username='$username' and u.password='$password'";
//echo $sql;
//exit;
				$row = mysql_func($sql);
				if(!$row){
					echo "<script>alert('用户名或密码错误,请重新输入！')</script>";
					echo "<script>window.location.href='../index.php'</script>";
					exit;
					}
				$username = $row[0];
				//执行登陆操作
					//session的写入直接去给$_SESSION赋值
					$_SESSION['home']['username'] = $username;
					$_SESSION['home']['last_ip'] = $_SERVER["REMOTE_ADDR"];
					//告诉浏览器将保存sessionid的cookie文件保存一个小时
					setcookie(session_name(),session_id(),time()+3600,"/");
				echo "<script>window.location.href='../index.php'</script>";
			}
?>
