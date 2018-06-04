<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";


?>
<?php if(isset($_GET['id'])){
		$id = $_GET['id'];
	}
	if(!empty($_POST['hinge'])){
		$hinge = $_POST['hinge'];

		//更新数据到USER详情表当中
		
		$sql = "update bbs_fil set hinge='$hinge' where id='$id'";
		$row = mysql_func($sql);

		if($row===false){
			echo "<script>alert('抱歉！写入数据失败，请稍后再试')</script>";
			echo "<script>window.location.href='../index.phpm=fil&a=list'<script/>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='../index.phpm=fil&a=list'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select * from bbs_fil where  id='$id'";

	$row = mysql_func($sql);
	$fil = $row[0];

?>
<div class="container">
<table class="table">
<form action="imod.phpid=<?php echo $id ?>" method="post" >
	<tr><td>关键词：</td><td><input type="text" name="hinge" value="<?php echo $fil['hinge'] ?>" /></td></tr>
	<tr><td colspan=2><input type="submit" value="确定修改" class="btn btn-info navbar-btn" />
	<input type="reset" value="重新填写"  class="btn btn-info navbar-btn"/></td></tr>
</form>
</table>
</div>