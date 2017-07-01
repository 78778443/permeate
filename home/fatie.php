<?php
	session_start();
	header('content-type:text/html;charset=utf-8');
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";

	if(!isset($_GET['bk'])){
		exit ("参数错误！");
		}
	$bk = $_GET['bk'];
	$zt = !empty($_GET['zt']) ? $_GET['zt'] : 0;
	if(isset($_POST['bk'])){
		$cid = $_POST['bk'];
		$title = $_POST['title'];
		$content =$_POST['content'];
		$ptime = $_SERVER['REQUEST_TIME'];
		$username= $_SESSION['home']['username'];
		$pip = ip2long($_SERVER['REMOTE_ADDR']);

		$sql = "select * from ".DB_PRE."iprefuse";
		$row = mysql_func($sql);
		foreach($row as $ip){
			if($pip>=$ip['ipmin']&&$pip<=$ip['ipmax']){
				echo "<script>alert('你所在的IP已被禁止发帖！')</script>";
				echo "<script>window.location.href='list.php?bk=".$bk."&zt=".$zt."'</script>";
				exit;
			}
		}

		$sql = "select * from ".DB_PRE."fil";
		$row = mysql_func($sql);
		foreach($row as $fil){
			$count = substr_count($title,$fil['hinge']);
			if($count!=0){
				echo "<script>alert('你所发表的标题，含有非法字符')</script>";
				echo "<script>window.location.href='list.php?bk=".$bk."&zt=".$zt."'</script>";
				exit;
			}
			$count = substr_count($content,$fil['hinge']);
			if($count!=0){
				echo "<script>alert('你所发表的内容，含有非法字符')</script>";
				echo "<script>window.location.href='list.php?bk=".$bk."&zt=".$zt."'</script>";
				exit;
			}
		}
		$sql = "select u.id,u.username from ".DB_PRE."user as u where username='".$username['username']."'";
		$row = mysql_func($sql);
		if(!$row){
			echo "非法登入，用户不存在！";
			echo '<script>window.location.href=./fatie.php?bk='.$bk.'&zt='.$zt.'</script>';
			exit;
			}
		$uid=$row[0]['id'];

		$sql = "insert into ".DB_PRE."post(cid,title,content,ptime,uid,pip) value('$cid','$title','$content','$ptime','$uid','$pip')";

		$row = mysql_func($sql);

		if(!$row){
			echo "<script>alert('发帖失败，请稍候再试！')</script>";
			echo "<script>window.location.href=./fatie.php?bk=".$bk."&zt=".$zt."</script>";
			}
		//echo "<script>alert('发帖成功，即将返回列表.')</script>";
		//echo "<pre>";
?>

		<script>window.location.href="./list.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>"</script>
	<?php
		}
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.config.js"></script>
		<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.all.js"></script>
		<title>轻松渗透测试系统".DB_PRE."</title>
        <link rel="stylesheet" type="text/css" href="resource/styles/fatie.css" />
	</head>

<?php
	//引用函数库mysql_function.php
	include "public/header.php";
?>
<body>
<div id="main">
	<div class="main_title">发表新帖</div>
	<form action="fatie.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>" method="post" >
    <input type="hidden" name="bk" value="<?php echo $bk ?>"/>
    标题:<input type="text" name="title" class="title" size="100" /></p>
    内容:</p><textarea name="content" id="content"></textarea></p>
    <input type="submit"  class="btn btn-default"/>
    </form>
</div>
<?php //引用函数库mysql_function.php
include "public/footer.php";
?>

<script type="text/javascript">
		UE.getEditor('content');
</script>
