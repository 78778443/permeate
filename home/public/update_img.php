<?php 
	//开启session
	session_start();
	include "../../conf/dbconfig.php";
	include "../../core/mysql_func.php";
	include "../../core/upload_func.php";
	include "../../core/image_func.php";
	$user = $_SESSION['home']['username'];

	$data = upload($info,'pic','../../resorce/images/userhead');
	$pic = $data['newname'];	
	if(!empty($pic)){
		$pic = suolue($pic,200,200,'../../resorce/images/userhead/');
		$picm = suolue($pic,100,100,'../../resorce/images/userhead/');
		$pics = suolue($pic,48,48,'../../resorce/images/userhead/');
		$sql = "update bbs_user_detail set pic='$pic',picm='$picm',pics='$pics' where uid='".$user['id']."'";
		$row = mysql_func($sql);
	}
	
	if(!$row){
		echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
		echo "<script>window.location.href='../individual.php'<script/>";
		exit;
	}
		$sql = "select u.*,d.* from bbs_user as u,bbs_user_detail as d where d.uid=u.id and u.username='".$user['username']."' and u.password='".$user['password']."'";
			//echo $sql;
		$row = mysql_func($sql);
		//var_dump($row);
		if(!$row){
			echo "<script>window.location.href='../individual.php'<script/>";
			exit;
		}
			//echo "执行到这粒了";
		//session的写入直接去给$_SESSION赋值
		$_SESSION['home']['username'] = $row[0];
		//告诉浏览器将保存sessionid的cookie文件保存一个小时
		setcookie(session_name(),session_id(),time()+3600,"/");
		
		echo "<script>window.location.href='../individual.php'</script>";

	exit;
?>