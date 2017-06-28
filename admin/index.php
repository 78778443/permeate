<?php
	header('content-type:text/html;charset=utf-8');
	session_start();//开启session
	if(empty($_SESSION['admin']['username'])){
		echo "<script>alert('请先登录！')</script>";
		echo "<script>window.location.href='./public/login.php'</script>";
		exit;
		}
?>
<frameset rows="120,*,80" frameborder="no"> 
 
<frameset cols="100,*"> 
	<frame > 
	<frame name="header" src="public/header.php"> 
</frameset>
<frameset cols="200,*"> 
	<frame name="left" src="public/left.php?id=1"> 
	<frame name="right" src="public/right.php"> 
</frameset>
<frame name="footer" src="public/footer.php"> 
</frameset><noframes></noframes> 