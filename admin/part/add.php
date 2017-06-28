<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";

?>
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
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}

		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}

?>
<div class="container">
<form action="add.php" method="post" class="navbar-form navbar-left"  >
	<table>
    	<tr><td>分区名称：</td><td><input type="text" name="pname" class="form-control"/></td></tr>
    	<tr><td>分区版主：</td><td><input type="text" name="pamins" class="form-control"/>（填写ID，可省略，默认为初始管理员）</td></tr>
	<tr><td><input type="submit" value="添加分区" class="btn btn-default" /></td></tr>
    </table>
</form>
</div>