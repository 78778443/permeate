<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	include "../includes/upload_func.php";
	include "../includes/image_func.php";
?>
<?php

	if(!empty($_POST['ipmin'])){
		$ipmin = ip2long($_POST['ipmin']);
		$ipmax = ip2long($_POST['ipmax']);

		if($ipmin>$ipmax){
			exit('开始IP,不能大于结束IP');
		}	
			
		$sql = "insert into ".DB_PRE."iprefuse(ipmin,ipmax) values('$ipmin','$ipmax')";
		echo $sql;
		$row = mysql_func($sql);
		
		if(!$row){
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
	<tr><td>开始IP：</td><td><input type="text" name="ipmin" /><p /></td></tr>
	<tr><td>结束IP：</td><td><input type="text" name="ipmax" /><p /></td></tr>
	<tr><td><input type="submit" value="添加链接" class="btn btn-default navbar-btn" /></td><td>
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" /></td></tr>
</table>
</form>
</div>