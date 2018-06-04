<?php
		//接收POST参数
	if($_POST['id']){
			$id = @$_POST['id'];
			$pid = @$_POST['pid'];
			$content = @$_POST['content'];
			$uid = @$_POST['uid'];
					
			$sql = "update bbs_reply set pid='$pid',content='$content',uid='$uid' where id=".$id;
			$row = mysql_func($sql);

			if(!$row){
				echo "<script>alert('服务器出错，请稍候再试！')</script>";
				}	
			echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
		}
	
	if(!$_GET['id']){
		echo '参数错误:缺少指定ID';
		exit;
		}
	//接收GET参数
	$id=$_GET['id'];
	
	$sql = "select * from bbs_reply where id=".$id;
	$user=mysql_func($sql);
	$reply=$user[0];
?>	
<div class="container">
	<table class="table">
		<form action="./index.php?m=reply&a=mod" method="post";>
       		<input type="hidden" name="id"  value="<?php echo $id; ?>"/><p />
		<tr><td>
        	主贴ID:
			</td><td><select class="form-control" name="pid"> 
					<?php
                    $sql = "select * from bbs_post";
                    $row = mysql_func($sql);
                    foreach($row as $post){
                    echo  "<option value=".$post['id'].">".$post['title']."</option>"; }?></select> <p />
			</td></tr>
		<tr><td> 内容：</td><td><textarea  class="form-control" name="content" cols="40" rows="4"  ><?php echo $reply['content'];?></textarea><p /></td></tr>
		<tr><td colspan=2>
            <input type="submit" value="确认提交" class="btn btn-info navbar-btn" />
            <input type="reset" value="重置表单" class="btn btn-info navbar-btn" />
		</td></tr>
		</form>
	</table>
</div>