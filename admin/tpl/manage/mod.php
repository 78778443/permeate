<?php
	include "../core/upload_func.php";
	include "../core/image_func.php";
	
	if(empty($_FILES['WZ_LOGO']['name'])){
		echo "<script>alert('你没有选择图片')</script>";
		echo "<script>window.location.href='./index.php?m=manage&a=lists'</script>";
		exit;
	}
	
	$data = upload($info,'WZ_LOGO','../resorce/images/web_logo');
	$pic = $data['newname'];
	
	$pic = suolue($pic,129,66,'../resorce/images/userhead/');
	$str="<?php\n";
	
	//echo $str;
	foreach ($_POST as $key => $value) {
		$str.="define('".$key."','".$value."');\n";
	}
	$str.="define('WZ_LOGO','$pic');\n";
	$str.='?>';

	
	if (file_put_contents('../conf/web_config.php', $str)) {
			echo "<script>alert('操作成功')</script>";
			echo "<script>window.location.href='./index.php?m=manage&a=lists'</script>";
		} else {
			echo "<script>alert('失败')</script>";
			echo "<script>window.location.href='./index.php?m=manage&a=lists'</script>";
		}
		

	
?>
