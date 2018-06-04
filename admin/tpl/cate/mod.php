<?php 
if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['cname'])){
		$name = $_POST['cname'];



		//更新数据到USER详情表当中
		$sql = "update bbs_cate set cname='$cname' where id=".$id;

		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='./index.php?m=cate&a=lists'<script/>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select p.*,c.cname from bbs_part as p,bbs_cate as c where p.id=c.pid and c.id='$id'";

	$row = mysql_func($sql);
	
	/*echo "<pre>";
	var_dump($row);
	echo "</pre>";
	exit;*/
?>
<div class="container">
<table class="table">
<form action="./index.php?m=cate&a=mod&id=<?php echo $id ?>" method="POST" >
	<tr><td>分区名称：</td><td>
	<select name="pid"> 
		<?php foreach($row as $part){
			echo "<option value=".$part['id'].">".$part['pname']."</option>"; 
		}?>
	</select> </td></tr>
	<tr><td>分区名称：</td><td><input type="text" name="cname" value="<?php echo $part['cname'] ?>" /></td></tr>

	
	<tr><td colspan=2><input type="submit" value="确定修改" class="btn btn-info navbar-btn"/></td></tr>
</form>
</table>
</div>