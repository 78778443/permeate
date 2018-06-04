<?php if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['pname'])){
		$pname = $_POST['pname'];
		$padmins = $_POST['padmins'];


		//更新数据到USER详情表当中
		$sql = "update bbs_part set pname='$pname',padmins='$padmins' where id=".$id;


		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='./index.php?m=part&a=lists'<script/>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='./index.php?m=part&a=lists'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select * from bbs_part as p where id='$id'";

	$row = mysql_func($sql);
	$part = $row[0];
	
	/*echo "<pre>";
	var_dump($user);
	echo "</pre>";*/
?>
<div class="container">
<form action="./index.php?m=part&a=mod&id=<?php echo $id ?>" method="post" class="form-control" >
分区名称：<input type="text" name="pname" value="<?php echo $part['pname'] ?>"  /></p>
分区版主：<input type="text" name="padmins" value="<?php echo $part['padmins'] ?>"/>(输入版主ID)</p>
<input type="submit" value="确定修改" class="btn btn-info navbar-btn" />
</form>
</table>
</div>