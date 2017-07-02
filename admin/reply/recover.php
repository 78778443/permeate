<?php

	include "../core/del_func.php";
	if(empty($_SERVER['HTTP_REFERER'])){
		exit('非法请求！');
	}
	
	$id = $_REQUEST['id'];
	$cz = $_REQUEST['cz'];
	
	if(!empty($id) && !empty($cz)){

		$sql = "update ".DB_PRE."reply set xx='".$cz."' where id='$id'";
		$row = mysql_func($sql);
	}
	
	echo "<script>window.location.href='list.php'</script>";
	exit;
?>