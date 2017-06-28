<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
	include "../../includes/del_func.php";

	if(empty($_SERVER['HTTP_REFERER'])){
		exit('非法请求！');
	}
	
	//判断分区下是否有板块，有板块将不允许删除
	$sql = "select * from ".DB_PRE."cate where pid='$id'";
	$row = mysql_func($sql);

	if($row){
		echo "<script>alert('分区下有板块，删除失败！')</script>";
		echo "<script>window.location.href='list.php'</script>";
		exit;
	}
	
	$id = $_REQUEST['id'];
	$zd = $_REQUEST['zd'];
	$table = $_REQUEST['table'];
	
	if(!empty($id)&&!empty($zd)&&!empty($table)){
		del($id,$zd,$table);
	}
	
	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
		echo "<script>window.location.href='list.php'</script>";
		exit;
	}
	echo "<script>window.location.href='list.php'</script>";
	exit;
?>