<?php
	include "/public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
		
?>
   <link rel="stylesheet" type="text/css" href="../public/bootstrap3/css/bootstrap.css"/>
<?php
	$keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
	if(!empty($keywords)){
		$where = " where id like '%$keywords%' ";
		$link = "&keywords=".$keywords;
	}else{
		$where = "";
		$link = "";
	}
	
	//开始分页大小
	$page_size = 5;
	
	//获取当前页码
	$page_num = empty($_GET['page'])?1:$_GET['page'];

	//计算记录总数
	$sql = "select count(*) as c from ".DB_PRE."part ".$where;
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
	
	$sql = "select * from ".DB_PRE."part  ".$where.$limit;
	//echo $sql;
	//echo $sql;
	//exit;
	$row = mysql_func($sql);
	

	
	/*echo "<pre>";
	var_dump($row1);
	echo "</pre>";*/
	//exit;
?>
<div class="container">
		<form>
		搜索ID：<input type='text' name='keywords'  class='input-medium search-query' />&nbsp;&nbsp;&nbsp;
		<input type='submit' value='搜索' class='btn' />
		</form>

	<form action="del.php" method="post">
    <input type="hidden" name="zd" value="id" />
	<input type="hidden" name="table" value="part" />
	<table width="870px" border="2px" class="table table-bordered">
	
		<tr>
			<th>多选</th>
			<th>ID</th>
			<th>分区名称</th>
			<th>分区版主</th>
			<th>分区下板块数</th>
			<th>管理</th>
		</tr>
<?php
	
	foreach($row as $part){
	$sql = "select count(*) as cou from ".DB_PRE."cate where pid='".$part['id']."' group by pid";
	//echo $sql;
	$row1 = mysql_func($sql);
	
	$cou = $row1[0]['cou'];
	if(empty($cou)){$cou = "0";}
	//var_dump($cou);
?>
		<tr align="center">
			<td><input type="checkbox" name="id" value="<?php echo $part['id'] ?>" /></td>
			<td><?php echo $part['id'] ?></td>
			<td><?php echo $part['pname'] ?></td>
			<td><?php $sql = "select * from bbs_user where id=".$part['padmins']; $rowpadmins = mysql_func($sql);  echo $rowpadmins['0']['username'] ?></td>
			<td><?php echo $cou ?></td>
			<td><a href="mod.php?id=<?php echo $part['id'] ?>">编辑</a>
				<a href="del.php?id=<?php echo $part['id'] ?>&zd=id&table=part">删除</a>
			</td>
		</tr>
<?php
	}
?>	
	</table>
		<input type='submit'  value='批量删除' class="btn btn-default navbar-btn" />
</form>
<?php	
	echo "
	<ul class='pager'>
		<li><a href='?page=1".$link."'>首页</a></li>
		<li><a href='?page=".($page_num-1).$link."'>上一页</a></li>
		<li><li><a href='?page=".($page_num+1).$link."'>下一页</a></li>
		<li><a href='?page=".$page_count.$link."'>尾页</a></li>
		<li>总共".$page_count."页</li>
		<li>本页".(($page_num==$page_count&&$count%$page_size!=0)?($count%$page_size):$page_size)."条</li>
		<li>总共".$count."条</li>
	</ul>
	"
?>
</div>