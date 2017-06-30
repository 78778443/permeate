<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";

?>
<?php

	if(!empty($_POST['cname'])){
		$pid = $_POST['pid'];
		$cname = $_POST['cname'];

		$sql = "insert into ".DB_PRE."cate(pid,cname) values('$pid','$cname')";
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('抱歉，添加记录失败。请检查格式是否正确！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}

		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}

	$sql = "select * from ".DB_PRE."part";

    $row = mysql_func($sql);
?>
<div class="container">
<form action="add.php" method="post" class="navbar-form navbar-left" >
<table>
	<tr><td>分区名称：</td><td><select name="pid"> 
		<?php foreach($row as $part){echo  "<option value=".$part['id'].">".$part['pname']."</option>"; }?>
    </select > </td></tr>
	<tr><td>板块名称：</td><td><input type="text" name="cname" /></td></tr>
	<tr><td><input type="submit" value="添加板块" class="btn btn-default navbar-btn"/></td></tr>
   </table>
</form>
</div>