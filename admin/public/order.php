<?php
class order{
	//控制总线
	function Tmp($model,$action){
		if($model == "" || $action == ""){
	
		}
		else{
			echo "<br /><br /><br /><br /><br /><br /><br /><br /><br />";
			include "./$model"."/$action".".php";
		}
				//$this->Post_ListH();
				//$this->Post_ListQ();
	}
	//帖子列表后端部分
	/*function Post_ListH(){
		include_once "demon.php";
		include "../conf/dbconfig.php";
		include "../includes/mysql_func.php";
		include "../includes/del_func.php";
		//开始分页大小
		$page_size = 5;	
		//获取当前页码
		$page_num = empty($_GET['page'])?1:$_GET['page'];	
		//计算记录总数
		$sql = "select count(*) as c from ".DB_PRE."post where del=1";
		//echo $sql;
		$row = mysql_func($sql);
		$count= $row[0]['c'];
		//计算记录总页数
		$page_count = ceil($count/$page_size);
		//防止越界
		if($page_num<=0){
			$page_num=1;
		}
		if($page_num>=$page_count){
			$page_num=$page_count;
		}	
		//准备SQL语句
		$limit = " limit ".(($page_num-1)*$page_size).",".$page_size;;
		$sql = "select p.*,u.username from ".DB_PRE."post as p,".DB_PRE."user as u where p.uid=u.id and p.del='1' ".$limit;
		//exit;
		$row = mysql_func($sql);
	}
	//帖子列表前端部分
	function Post_ListQ(){
		echo "
		<div class='container'>
		<form action='./post/del.php' method='post'>
		<input type='hidden' name='zd' value='id' />
		<input type='hidden' name='table' value='post' />
		<table width='870px' border='2px' class='table table-bordered'>
		<tr >
			<th>多选</th>
			<th>ID</th>
			<th>主题</th>
			<th>发帖时间</th>
			<th>发帖人</th>
			<th>管理</th>
		<tr>";
		foreach($row as $post){
		echo "<tr align='center'>";
        echo "<td><input type='checkbox' name='id[]' value=".$post['id']."/></td>";
        echo "<td>".$post['id']."</td>";
        echo "<td>".$post['title']."</td>";
        echo "<td>".date('Y-m-d H:i:s',$post['ptime'])."</td>";
        echo "<td>".$post['username']."</td>";
        echo "<td><a href=./post/mod.php?id=".$post['id'].">编辑</a> <a href=./post/del.php?id=".$post['id']."&zd=id&table=post&cz=2>删除</a></td>";
		echo "</tr>";
		echo "</table>";
		echo "<input type='submit'  value='批量删除' class='btn btn-default navbar-btn' />";
		echo "</form>";
		}
	echo "<ul class='pager'>";
		echo "<li><a href='?page=1'.$link.''>首页</a></li>";
		echo "<li><a href='?page='.($page_num-1).$link.''>上一页</a></li>";
		echo "<li><li><a href='?page='.($page_num+1).$link.''>下一页</a></li>";
		echo "<li><a href='?page='.$page_count.$link.''>尾页</a></li>";
		echo "<li>总共".$page_count."页</li>";
		echo "<li>本页".(($page_num==$page_count&&$count%$page_size!=0)?($count%$page_size):$page_size)."条</li>";
		echo "<li>总共".$count."条</li>";
	echo "</ul>";
}
*/
}
?>