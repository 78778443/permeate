<?php
	require_once "../core/del_func.php";
	//判断分区下是否有贴子，有帖子将不允许删除
	$id = $_GET['id'];
	$sql = "select * from bbs_post where cid='$id'";
	$row = mysql_func($sql);

	if($row){
		echo "<script>alert('分区下有帖子，删除失败！')</script>";
		echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
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
		echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
		exit;
	}
	echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
	exit;
?>