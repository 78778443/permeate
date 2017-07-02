<?php
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
	include "../../includes/del_func.php";
	if(empty($_SERVER['HTTP_REFERER'])){
		exit('非法请求！');
	}
	//判断分区下是否有贴子，有帖子将不允许删除
	$sql = "select * from ".DB_PRE."post where cid='$id'";
	$row = mysql_func($sql);

	if($row){
		echo "<script>alert('分区下有帖子，删除失败！')</script>";
		echo "<script>window.location.href='../index.php?m=cate&a=list'</script>";
		exit;
	}
	
	$id = @$_REQUEST['id'];
	$zd = @$_REQUEST['zd'];
	$table = @$_REQUEST['table'];
	
	if(!empty($id)&&!empty($zd)&&!empty($table)){
		del($id,$zd,$table);
	}
	
	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
		echo "<script>window.location.href='../index.php?m=cate&a=list'</script>";
		exit;
	}
	echo "<script>window.location.href='../index.php?m=cate&a=list'</script>";
	exit;
?>