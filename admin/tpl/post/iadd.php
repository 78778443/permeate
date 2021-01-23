<?php

	if(empty($_SERVER['HTTP_REFERER'])){
        exit(234);
	}
	if(!empty($_POST['title'])){
		$title = $_POST['title'];
		$content = $_POST['content'];
		$cid = $_POST['cid'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);
		$uid = getAdminUid();

		$sql = "insert into bbs_post(title,content,cid,ptime,uid,pip) values('$title','$content','$cid','$ptime','$uid','$pip')";

		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>window.location.href='../index.phpm=post&a=list'</script>";
			exit;
		}

		echo "<script>window.location.href='../index.phpm=post&a=list'</script>";
		exit;
	}
?>