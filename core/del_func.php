<?php
	if(empty($_SERVER['HTTP_REFERER'])){
		exit('非法请求！');
	}
	function del($id,$zd,$table){
		if(is_array($id)){
			$id = join(",",$id);
		}
		$sql = "delete from ".DB_PRE.$table." where $zd in(".$id.")";
		
		$row = mysql_func($sql);
		if(!$row){
			return false;
		}
		return true;
	}
?>