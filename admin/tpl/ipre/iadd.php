<?php
	require_once ".��/public/demon.php";


	require_once "../../core/upload_func.php";
	require_once "../../core/image_func.php";
?>
<?php

	if(!empty($_POST['ipmin'])){
		$ipmin = ip2long($_POST['ipmin']);
		$ipmax = ip2long($_POST['ipmax']);

		if($ipmin>$ipmax){
			exit('��ʼIP,���ܴ��ڽ���IP');
		}	
			
		$sql = "insert into bbs_iprefuse(ipmin,ipmax) values('$ipmin','$ipmax')";
		echo $sql;
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('��Ǹ��д������ʧ�ܣ����Ժ����ԣ�')</script>";
			echo "<script>window.location.href='../index.phpm=ipre&a=list'</script>";
			exit;
		}


		//header("location:list.php");
		echo "<script>window.location.href='../index.phpm=ipre&a=list'</script>";
		exit;
	}

?>