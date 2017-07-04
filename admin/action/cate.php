<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class cate{
    public function lists(){
		
        displayTpl('cate/list');
    }
	public function add(){
			if(!empty($_POST['cname'])){
		$pid = $_POST['pid'];
		$cname = $_POST['cname'];

		$sql = "insert into ".DB_PRE."cate(pid,cname) values('$pid','$cname')";
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('xxxxx')</script>";
			echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
			exit;
		}

		echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
		
		exit;
	}
	displayTpl('cate/add');
	}
}