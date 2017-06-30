<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	include "../includes/upload_func.php";
	include "../includes/image_func.php";
?>
<?php

	if(!empty($_POST['hinge'])){
		$hinge = ip2long($_POST['hinge']);

		if(empty($hinge)){
			exit('请输入关键字');
		}	
			
		$sql = "insert into ".DB_PRE."fil(hinge) values('$hinge')";

		$row = mysql_func($sql);
		var_dump($row);
		if($row===false){
			echo "<script>alert('抱歉！写入数据失败，请稍后再试！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}


		//header("location:list.php");
		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}

?>
<div class="container">
<form action="add.php" method="post" enctype="multipart/form-data" >
<table>
	<tr><td>关键字：</td><td><input type="text" name="hinge" /><p /></td></tr>
	<tr><td><input type="submit" value="添加" class="btn btn-default navbar-btn" /></td><td>
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" /></td></tr>
</table>
</form>
</div>