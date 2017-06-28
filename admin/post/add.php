<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php

	if(!empty($_POST['title'])){
		$title = $_POST['title'];
		$content = $_POST['content'];
		$cid = $_POST['cid'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);
		$uid = $_SESSION['admin']['username']['id'];

		$sql = "insert into ".DB_PRE."post(title,content,cid,ptime,uid,pip) values('$title','$content','$cid','$ptime','$uid','$pip')";

		$row = mysql_func($sql);
		

		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}

		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}
	$sql = "select * from ".DB_PRE."cate";

    $row = mysql_func($sql);

?>
<div class="container">
<form action="add.php" method="post" >
<table>
	<tr><td>所属主题：</td><td><select name="cid"> 
		<?php foreach($row as $cate){echo  "<option value=".$cate['id'].">".$cate['cname']."</option>"; }?>   
		</select ></td></tr>
	<tr><td>标题：</td><td><input type="text" name="title" /></td></tr>
	<tr><td>帖子内容：</td><td><textarea name="content" cols="40" rows="4" wrap="VIRTUAL"> </textarea></td></tr>
	<tr><td><input type="submit" value="发表主题" class="btn btn-default navbar-btn" /></td><td>
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" /></td></tr>
 </table>
</form>
</div>
