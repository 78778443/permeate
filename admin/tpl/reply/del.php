<?php
	include "../core/del_func.php";
	$id = @$_REQUEST['id'];
	$zd = @$_REQUEST['zd'];
	$table = @$_REQUEST['table'];
	$cz = @$_GET['cz'];
	
	if(!empty($id)){
		if(!empty($cz)){
			echo "<script>window.location.href='./index.php?m=reply&a=recover&id=".$id."&cz=".$cz."'</script>";
			echo "<script>alert('我执行了这里')</script>";
			exit;
		}
		
		if(!empty($id)&&!empty($zd)&&!empty($table)){
			$row = del($id,$zd,$table);
		}
		
		if(!$row){
		echo "<script>alert('删除用户失败，请稍后再试!')</script>";
		echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
		exit;
		}
		echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
		exit;
	}

?>