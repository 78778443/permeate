<?php

	if(!empty($_POST['pname'])){
		$pname = $_POST['pname'];
		$padmins = $_POST['padmins'];

		
		if(empty($padmins)){
			$padmins = "6";
		}
		$sql = "insert into ".DB_PRE."part(pname,padmins) values('$pname','$padmins')";
		echo $sql;
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.phpm=part&a=list'</script>";
			exit;
		}

		echo "<script>window.location.href='../index.phpm=part&a=list'</script>";
		exit;
	}

?>