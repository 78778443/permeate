<?php
	//开启sessino
	session_start();
	header('content-type:text/html;charset=utf-8');
	include "../includes/mysql_func.php";
	
	if(!isset($_GET['bk'])){
		exit ("参数错误！");
		}
	if(!isset($_GET['zt'])){
		exit ("参数错误！");
		}
	$bk = $_GET['bk'];
	$zt = $_GET['zt'];
	if(isset($_POST['id'])){
		include "../conf/dbconfig.php";
		$pid = $_POST['id'];
		$content =$_POST['content'];
		$username= $_SESSION['home']['username'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);
		
		
		$sql = "select * from ".DB_PRE."iprefuse";
		$row = mysql_func($sql);
		foreach($row as $ip){
			if($pip>=$ip['ipmin']&&$pip<=$ip['ipmax']){
				echo "<script>alert('你所在的IP已被禁止发帖！')</script>";
				echo "<script>window.location.href='post.php?bk=".$bk."&zt=".$zt."'</script>";
				exit;
			}
		}
		
		$sql = "select u.id,u.username from ".DB_PRE."user as u where username='".$username['username']."'";
		$row = mysql_func($sql);
		if(!$row){
			echo "请先登入！";
			echo "<script>window.location.href=./fatie.php?bk=".$bk."&zt=".$zt."</script>";
			exit;
			}
		$uid=$row[0]['id'];
		
		$sql = "insert into ".DB_PRE."reply(pid,content,uid,ptime,pip) value('$pid','$content','$uid','$ptime','$pip')";
		//echo $sql;
		//exit;
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('发帖失败，请稍候再试！')</script>";
			echo "<script>window.location.href=./fatie.php?bk=".$bk."&zt=".$zt."</script>";
			}

	?>		
		<script>window.location.href="./post.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>"</script>
	<?php
		}
	?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.all.js"></script>
		<title>LAMP-72".DB_PRE."</title>
		<link rel="stylesheet" type="text/css" href="resource/styles/public.css" />
        <link rel="stylesheet" type="text/css" href="resource/styles/huifu.css" />
        <link rel="stylesheet" type="text/css" href="../public/bootstrap3/css/bootstrap.css">
	</head>
	<body>
<?php
	//引用函数库mysql_function.php
	include "public/header.php";
	
?>
<div id="main">
	<div class="main_title">回复：<?php
	$sql = "select p.title from ".DB_PRE."post as p where id=".$zt;
	$row1 = mysql_func($sql);
	$row1 = $row1[0];
	 echo $row1['title'] ?></div>
	<form action="huifu.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $zt ?>"/>
    帖子主题:<input type="text"  size="100"  value="<?php echo $row1['title']?> " disabled/></p>
    内容:</p><textarea name="content" id="content" cols="120" rows="20"></textarea></p>
    <input type="submit" value="发&nbsp;&nbsp;&nbsp;表" class="btn btn-default"/> &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="重&nbsp;&nbsp;&nbsp;写" class="btn btn-default"/> 
    </form>
</div>
<?php //引用函数库mysql_function.php
include "public/footer.php";
?>
<script type="text/javascript">
		UE.getEditor('content');
</script>
