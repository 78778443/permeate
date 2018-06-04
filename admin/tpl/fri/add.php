<?php
	include "../core/upload_func.php";
	include "../core/image_func.php";
?>
<?php

	if(!empty($_POST['title'])){
		$title = $_POST['title'];
		$desc1 = $_POST['desc1'];
		$url = $_POST['url'];

			
		if(!empty($_FILES['pic']['name'])){
			$data = upload($info,'pic','../resorce/images/fri');
			$pic = $data['newname'];
			$pic = suolue($pic,50,30,'../resorce/images/fri/');
			$sql = "insert into bbs_fri(title,desc1,url,pic) values('$title','$desc1','$url','$pic')";

		}else{
			$sql = "insert into bbs_fri(title,desc1,url) values('$title','$desc1','$url')";
		}

		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
			exit;
		}


		//header("location:list.php");
		echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
		exit;
	}

?>
<div class="container">
<form action="./index.php?m=fri&a=add" method="post" enctype="multipart/form-data" >
<table>
	<tr><td>标题：</td><td><input type="text" name="title" /><p /></td></tr>
	<tr><td>描述：</td><td><input type="text" name="desc1" /><p /></td></tr>
	<tr><td>URL：</td><td><input type="url" name="url" /><p /></td></tr>
	<tr><td>图片链接：</td><td><input type="file" name="pic"  /><p/></td></tr>
	<tr><td><input type="submit" value="添加链接" class="btn btn-info navbar-btn" /></td><td>
	<input type="reset" value="重新填写" class="btn btn-info navbar-btn" /></td></tr>
</table>
</form>
</div>