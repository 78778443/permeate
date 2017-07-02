<?php

	include "../core/del_func.php";
	if(empty($_SERVER['HTTP_REFERER'])){
		exit('非法请求！');
	}
	
	$id = $_REQUEST['id'];
	$zd = $_REQUEST['zd'];
	$table = $_REQUEST['table'];
	
	if(!empty($id)&&!empty($zd)&&!empty($table)){
		$row = del($id,$zd,$table);
	}
	
	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
		echo "<script>window.location.href='list.php'</script>";
		exit;
	}

		$row = del($id,'uid','user_detail');

	
	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
		
	}

		$row = del($id,'uid','post');

	
	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
	
	}
	
		$row = del($id,'uid','reply');

	if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试'!)</script>";
		
		exit;
	}

	echo "<script>window.location.href='list.php'</script>";
?>