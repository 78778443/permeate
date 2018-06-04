<?php
	include "../core/upload_func.php";
	include "../core/image_func.php";
?>
<?php
	$keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
	if(!empty($keywords)){
		$where = " where id like '%$keywords%' ";
		$link = "&keywords=".$keywords;
	}else{
		$where = "";
		$link = "";
	}
	if(!empty($_POST['hinge'])){
		$hinge = ip2long($_POST['hinge']);

		if(empty($hinge)){
			exit('请输入关键字');
		}	
			
		$sql = "insert into bbs_fil(hinge) values('$hinge')";

		$row = mysql_func($sql);
		var_dump($row);
		if($row===false){
			echo "<script>alert('抱歉！写入数据失败，请稍后再试！')</script>";
			echo "<script>window.location.href='./index.php?m=fil&a=lists'</script>";
			exit;
		}


		//header("location:list.php");
		echo "<script>window.location.href='./index.php?m=fil&a=lists'</script>";
		exit;
	}

?>
<div class="container">
<form action="./index.php?m=fil&a=add" method="post" enctype="multipart/form-data" >
<table>
	<tr><td>关键字：</td><td><input type="text" name="hinge" /><p /></td></tr>
	<tr><td><input type="submit" value="添加" class="btn btn-info navbar-btn" /></td><td>
	<input type="reset" value="重新填写" class="btn btn-info navbar-btn" /></td></tr>
</table>
</form>
</div>