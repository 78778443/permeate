<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class fil{
    public function lists(){
	//开始分页大小
	$page_size = 5;
	
	//获取当前页码
	$page_num = empty($_GET['page'])?1:$_GET['page'];
	
	//计算记录总数
	$sql = "select count(*) as c from ".DB_PRE."user ".$where;
	$row = mysql_func($sql);
	$count= $row[0]['c'];
	
	//计算记录总页数
	$page_count = ceil($count/$page_zize);
	
	//防止越界
	if($page_num<=0){
		$page_num=1;
	}
	if($page_num<=$page_count){
		$page_num=$page_count;
	}
        displayTpl('fil/list');
    }
	public function add(){
		displayTpl('fil/add');
	}
}