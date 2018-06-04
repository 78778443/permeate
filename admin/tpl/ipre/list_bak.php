<?php
	//开始分页大小
	$page_size = 5;

	//获取当前页码
	$page_num = empty($_GET['page'])?1:$_GET['page'];

	//计算记录总数
	$sql = "select count(*) as c from bbs_user ".$where;
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
	$limit = " limit ".(($page_num-1)*$page_size).",".$page_size;;

	$sql = "select * from bbs_iprefuse".$where.$limit;
	$row = mysql_func($sql);
	
?>
<div class="container">
		<form>
		搜索id：<input type='text' name='keywords'  class='input-medium search-query' />&nbsp;&nbsp;&nbsp;
		<input type='submit' value='搜索' class='btn' />
		</form>
        
	<table width="870px" border="2px" class="table table-bordered">
	
		<tr >
			<th>多选</th>
			<th>ID</th>
			<th>开始IP</th>
			<th>结束IP</th>
			<th>管理</th>
		<tr>
		<form action="./index.php?m=ipre&a=del" method="post">
<?php foreach($row as $ip){
?>
		<tr align="center">
			<td><input type="checkbox" name="id[]" value="<?php echo $user['id'] ?>" /></td>
			<td><?php echo $ip['id'] ?></td>
			<td><?php echo long2ip($ip['ipmin']) ?></td>
			<td><?php echo long2ip($ip['ipmax']) ?></td>

			<td><a href="./index.php?m=ipre&a=mod&id=<?php echo $ip['id'] ?>">编辑</a>
				<a href="./index.php?m=ipre&a=del&id=<?php echo $ip['id'] ?>&zd=id&table=iprefuse">删除</a>
			</td>
		</tr>
<?php
	}
?>	
		
		
	</table>
		<input type='submit'  value='批量删除' class="btn btn-info navbar-btn" />
</form>
</div>