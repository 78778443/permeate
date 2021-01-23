<?php 
	//开启session
	session_start();
	require_once "../../conf/dbconfig.php";
	require_once "../../core/mysql_func.php";
	require_once "../../core/upload_func.php";
	require_once "../../core/image_func.php";
	require_once "../../core/common.php";
	$user = getCurrentUser();

	$data = upload($info,'pic','../../resources/images/userhead');
	$pic = $data['newname'];	
	if(!empty($pic)){
		$pic = suolue($pic,200,200,'../../resources/images/userhead/');
		$picm = suolue($pic,100,100,'../../resources/images/userhead/');
		$pics = suolue($pic,48,48,'../../resources/images/userhead/');
		$sql = "update bbs_user_detail set pic='$pic',picm='$picm',pics='$pics' where uid='".$user['id']."'";
		$row = mysql_func($sql);
	}
	
	if(!$row){
		echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
		echo "<script>window.location.href='/home/index.php?m=user&a=individual'<script/>";
		exit;
	}
		$sql = "select u.*,d.* from bbs_user as u,bbs_user_detail as d where d.uid=u.id and u.username='".$user['username']."' and u.password='".$user['password']."'";
			//echo $sql;
		$row = mysql_func($sql);
		//var_dump($row);
		if(!$row){
			echo "<script>window.location.href='/home/index.php?m=user&a=individual'<script/>";
			exit;
		}
			//echo "执行到这粒了";
		//session的写入直接去给$_SESSION赋值
        saveCurrentUser($row[0]);
		//告诉浏览器将保存sessionid的cookie文件保存一个小时
		setcookie(session_name(),session_id(),time()+3600,"/");
		
		echo "<script>window.location.href='/home/index.php?m=user&a=individual'</script>";

	exit;
?>