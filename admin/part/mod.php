<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['pname'])){
		$pname = $_POST['pname'];
		$padmins = $_POST['padmins'];


		//更新数据到USER详情表当中
		$sql = "update ".DB_PRE."part set pname='$pname',padmins='$padmins' where id=".$id;


		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='list.php'<script/>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select * from ".DB_PRE."part as p where id='$id'";

	$row = mysql_func($sql);
	$part = $row[0];
	
	/*echo "<pre>";
	var_dump($user);
	echo "</pre>";*/
?>
<div class="container">
<form action="mod.php?id=<?php echo $id ?>" method="post" class="form-control" >
分区名称：<input type="text" name="pname" value="<?php echo $part['pname'] ?>"  /></p>
分区版主：<input type="text" name="padmins" value="<?php echo $part['padmins'] ?>"/>(输入版主ID)</p>
<input type="submit" value="确定修改" class="btn btn-default navbar-btn" />
</form>
</table>
</div>