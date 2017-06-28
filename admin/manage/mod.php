<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../../includes/upload_func.php";
	include "../../includes/image_func.php";
	
	if(empty($_FILES['WZ_LOGO']['name'])){
		echo "<script>alert('你没有选择图片')</script>";
		echo "<script>window.location.href='list.php'</script>";
		exit;
	}
	
	$data = upload($info,'WZ_LOGO','../../resorec/images/web_logo');
	$pic = $data['newname'];
	
	$pic = suolue($pic,129,66,'../../resorec/images/userhead/');
	$str="<?php\n";
	
	//echo $str;
	foreach ($_POST as $key => $value) {
		$str.="define('".$key."','".$value."');\n";
	}
	$str.="define('WZ_LOGO','$pic');\n";
	$str.='?>';

	
	if (file_put_contents('../../conf/web_config.php', $str)) {
			echo "<script>alert('操作成功')</script>";
			echo "<script>window.location.href='list.php'</script>";
		} else {
			echo "<script>alert('失败')</script>";
			echo "<script>window.location.href='list.php'</script>";
		}
		

	
?>
