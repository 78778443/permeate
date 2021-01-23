<?php


	require_once "../../core/upload_func.php";
	require_once "../../core/image_func.php";
?>
<?php

	if(!empty($_POST['title'])){
		$title = $_POST['title'];
		$desc1 = $_POST['desc1'];
		$url = $_POST['url'];

			
		if(!empty($_FILES['pic']['name'])){
			$data = upload($info,'pic','../resources/images/fri');
			$pic = $data['newname'];
			$pic = suolue($pic,50,30,'../resources/images/fri/');
			$sql = "insert into bbs_fri(title,desc1,url,pic) values('$title','$desc1','$url','$pic')";

		}else{
			$sql = "insert into bbs_fri(title,desc1,url) values('$title','$desc1','$url')";
		}

		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.phpm=fri&a=list'</script>";
			exit;
		}


		//header("location:list.php");
		echo "<script>window.location.href='../index.phpm=fri&a=list'</script>";
		exit;
	}

?>