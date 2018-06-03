<?php

	//获取图片的资源和大小
	function getinfo($img){
		$arr = getimagesize($img);
		switch($arr['mime']){
			case 'image/jpeg':
			case 'image/jpg':
				$res = imagecreatefromjpeg($img);
				break;
			case 'image/gif':
				$res = imagecreatefromgif($img);
				break;
			case 'image/png':
				$res = imagecreatefrompng($img);
				break;
			case 'image/wbmp':
				$res = imagecreatefromwbmp($img);
				break;
		}
		return array('res'=>$res,'width'=>$arr[0],'height'=>$arr[1]);

	}
	
	function suolue($src='./images/2.jpg',$width,$height,$pre){

		//1.创建画布
		//原图的画布
		//新建一个空的画布
		
		$dst_arr = getinfo($src);
		
		$dst_res = $dst_arr['res'];
		
		$dst_width = $dst_arr['width'];
		
		$dst_height = $dst_arr['height'];
		
		//2.将原图按比例（需要计算）缩小
		if($dst_width>$dst_height){//如果是横图
			$bl = $dst_height/$dst_width;//用高度除以宽度
			$height = $width*$bl;//通过比例算高度
		}else{
			$bl = $dst_width/$dst_height;
			$width = $height*$bl;//通过比例算宽度
		}

		$img = imagecreatetruecolor($width,$height);
		
		imagecopyresampled($img,$dst_res,0,0,0,0,$width,$height,$dst_width,$dst_height);
		
		//3.定义header（可以省略，保存图片不需要header）
		
		//4.保存图片
		$new_name = $pre.md5(time().mt_rand()).'.png';

		imagepng($img,$new_name);
		
		//5.销毁资源
		imagedestroy($img);
		imagedestroy($dst_res);


		//返回图片路径
        $new_name = str_replace($_SERVER['DOCUMENT_ROOT'],'',$new_name);
		return $new_name;
	}
	
	//suolue('./images/1.jpg',200,200,'middle_');
	//suolue('./images/1.jpg',100,100,'small_');