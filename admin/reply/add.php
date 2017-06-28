<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php

	if(!empty($_POST['pid'])){
		$pid = $_POST['pid'];
		$content = $_POST['content'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);
		$uid = $_SESSION['admin']['username']['id'];
		$sql = "insert into ".DB_PRE."reply(pid,content,uid,ptime,pip) values('$pid','$content',$uid,'$ptime','$pip')";
		$row = mysql_func($sql);
		if(!$row){
			echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
			echo "<script>window.location.href='add.php'</script>";
			exit;
		}
		echo "<script>window.location.href='./list.php'</script>";
		exit;
	}
	$sql = "select * from ".DB_PRE."post";
	
	$row = mysql_func($sql);
	
?>

<div class="container">
  <form action="add.php" method="post" >
    <table>
      <tr>
        <td>所属板块：</td>
        <td><select name="pid">
            <?php foreach($row as $post){echo  "<option value=".$post['id'].">".$post['title']."</option>"; }?>
          </select ></td>
      </tr>
      <tr>
        <td>帖子内容:</td>
        <td><textarea name="content" cols="40" rows="4" wrap="VIRTUAL"> </textarea></td>
      </tr>
      <tr>
        <td><input type="submit" value="注册" class="btn btn-default navbar-btn" /></td>
      </tr>
    </table>
  </form>
</div>
