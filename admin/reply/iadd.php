<?php
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php

	if(!empty($_POST['pid'])){
		$pid = $_POST['pid'];
		$content = $_POST['content'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);
		$uid = $_SESSION['admin']['username']['id'];
		$sql = "insert into ".DB_PRE."reply(pid,content,uid,ptime,pip) values('$pid','$content',$uid,'$ptime','$pip')";
		$row = mysql_func($sql);
		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.php?m=reply&a=list'</script>";
			exit;
		}
		echo "<script>window.location.href='../index.php?m=reply&a=list'</script>";
		exit;
	}
	$sql = "select * from ".DB_PRE."post";
	
	$row = mysql_func($sql);
	
?>