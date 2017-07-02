<?php if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	if(!empty($_POST['ipmin'])){
		$ipmin = ip2long($_POST['ipmin']);
		$ipmax = ip2long($_POST['ipmax']);

		
		$sql = "update ".DB_PRE."iprefuse set ipmin='$ipmin',ipmax='$ipmax' where id='$id'";
		$row = mysql_func($sql);

		if($row===false){
			echo "<script>window.location.href='../index.phpm=ipre&a=list'</script>";
			exit;
		}

		echo "<script>window.location.href='../index.phpm=ipre&a=list'</script>";
		exit;
	}

	$sql = "select * from ".DB_PRE."iprefuse where  id='$id'";
	//echo $sql;
	$row = mysql_func($sql);
	$fri = $row[0];
?>