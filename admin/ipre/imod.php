<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../conf/dbconfig.php";
	include "../../includes/mysql_func.php";
?>
<?php
	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['ipmin'])){
		$ipmin = ip2long($_POST['ipmin']);
		$ipmax = ip2long($_POST['ipmax']);
		

		//更新数据到USER详情表当中
		
		$sql = "update ".DB_PRE."iprefuse set ipmin='$ipmin',ipmax='$ipmax' where id='$id'";
		$row = mysql_func($sql);

		if($row===false){
			echo "<script>alert('抱歉！写入数据失败，请稍后再试！')</script>";
			echo "<script>window.location.href='../index.php?m=ipre&a=list'</script>";
			exit;
		}

		//执行过程中没有出现以为，将跳转到LIST列表当中
		echo "<script>window.location.href='../index.php?m=ipre&a=list'</script>";
		exit;
	}
	
	//POST不存在，将查询表中数据
	$sql = "select * from ".DB_PRE."iprefuse where  id='$id'";
	//echo $sql;
	//exit;
	$row = mysql_func($sql);
	$fri = $row[0];
	/*echo "<pre>";
	var_dump($fri);
	echo "</pre>";*/
?>