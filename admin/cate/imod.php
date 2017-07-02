<?php
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
	
	if(isset($_GET['id'])){
		$id = @$_GET['id'];
	}

	if(!empty($_POST['cname'])){
		$cname = @$_POST['cname'];
	
	if($_POST['cname']==""){
		echo "空";
		exit;
	}



		//更新数据到USER详情表当中
		$sql = "update ".DB_PRE."cate set cname='$cname' where id=".$id;

		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.php?m=cate&a=list'<script/>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='../index.php?m=cate&a=list'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select p.*,c.cname from ".DB_PRE."part as p,".DB_PRE."cate as c where p.id=c.pid and c.id='$id'";

	$row = mysql_func($sql);
	
	/*echo "<pre>";
	var_dump($row);
	echo "</pre>";
	exit;*/
?>