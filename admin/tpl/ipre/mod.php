<?php 
if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['ipmin'])){
		$ipmin = ip2long($_POST['ipmin']);
		$ipmax = ip2long($_POST['ipmax']);
		

		//更新数据到USER详情表当中
		
		$sql = "update bbs_iprefuse set ipmin='$ipmin',ipmax='$ipmax' where id='$id'";
		$row = mysql_func($sql);

		if($row===false){
			echo "<script>alert('抱歉！写入数据失败，请稍后再试！')</script>";
			echo "<script>window.location.href='./index.php?m=ipre&a=lists'</script>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='./index.php?m=ipre&a=lists'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select * from bbs_iprefuse where  id='$id'";
	//echo $sql;
	//exit;
	$row = mysql_func($sql);
	$fri = $row[0];
	/*echo "<pre>";
	var_dump($fri);
	echo "</pre>";*/
?>
<div class="container">
<table class="table">
<form action="./index.php?m=ipre&a=mod&id=<?php echo $id ?>" method="post" >
	<tr><td>开始IP</td><td><input type="text" name="ipmin" value="<?php echo long2ip($fri['ipmin']) ?>" /></td></tr>
	<tr><td>结束IP</td><td><input type="ipmax" name="ipmax" value="<?php echo long2ip($fri['ipmax']) ?>"  /></td></tr>
	<tr><td colspan=2><input type="submit" value="确定修改" class="btn btn-info navbar-btn" />
	<input type="reset" value="重新填写"  class="btn btn-info navbar-btn"/></td></tr>
</form>
</table>
</div>