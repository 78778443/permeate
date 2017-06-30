<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	$id = $_GET['id'];
	switch($id){
	case 1:
?>
        <ul class="nav nav-pills nav-stacked">
         <li class="nav-header">用户管理</li>
		<li><a href='../user/list.php'  target='right'>用户列表</a></li>
		<li><a href='../user/add.php' target='right'>添加用户</a></li><p/>
		</ul>
<?php	
		break;
		case 2:
?>
		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">分区管理</li>
        <li><a href='../part/list.php' target='right'>分区列表</a></li><p/>
		<li><a href='../part/add.php' target='right'>添加分区</a></li><p/>
		</ul>
<?php	
		break;
		case 3:
?>

		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">板块管理</li>
        <li><a href='../cate/list.php' target='right'>板块列表</a></li><p/>
		<li><a href='../cate/add.php' target='right'>添加板块</a></li><p/>
		</ul>
<?php	
		break;
		case 4:
?>
		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">主题管理</li>
        <li><a href='../post/list.php' target='right'>帖子列表</a></li><p/>
		<li><a href='../post/add.php' target='right'>添加主题</a></li><p/>
		<li><a href='../post/list_del.php' target='right'>回收站</a></li><p/>
		</ul>
<?php	
		break;
		case 5:
?>
		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">回帖管理</li>
        <li><a href='../reply/list.php' target='right'>回帖列表</a></li>
		<li><a href='../reply/add.php' target='right'>添加回帖</a></li>
		<li><a href='../reply/list_pb.php' target='right'>屏蔽的回帖</a></li>
		</ul>
<?php	
		break;
		case 6:
?>
		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">链接管理</li>
        <li><a href='../fri/list.php' target='right'>友情链接</a></li>
		<li><a href='../fri/add.php' target='right'>添加链接</a></li>
		</ul>
<?php	
		break;
		case 7:
?>
		<ul class="nav nav-pills nav-stacked">
         <li class="nav-header">链接管理</li>
        <li><a href='../ipre/list.php' target='right'>过滤列表</a></li>
		<li><a href='../ipre/add.php' target='right'>添加过滤</a></li>
		</ul>
<?php	
		break;
		case 8:
?>
		<ul class="nav nav-pills nav-stacked">
        <li class="nav-header">词语过滤</li>
        <li><a href='../fil/list.php' target='right'>生效列表</a></li>
        <li><a href='../fil/add.php' target='right'>添加关键字</a></li>
		</ul>
<?php 
		break;
		case 9:
?>
		<ul class="nav nav-pills nav-stacked">
        <li class="nav-header">网站管理</li>
        <li><a href='../manage/list.php' target='right'>网站信息</a></li>
		</ul>
<?php
	}
?>


	