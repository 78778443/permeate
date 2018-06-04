<?php

	$limit = " limit ".(($page_num-1)*$page_size).",".$page_size;;
	
	$sql = "select * from bbs_fri".$where.$limit;

	
	$row = mysql_func($sql);
	
?>
<div class="container">
		<form>
		搜索用户名：<input type='text' name='keywords'  class='input-medium search-query' />&nbsp;&nbsp;&nbsp;
		<input type='submit' value='搜索' class='btn' />
		</form>
        
	<table width="870px" border="2px" class="table table-bordered">
	
		<tr >
			<th>多选</th>
			<th>ID</th>
			<th>标题</th>
			<th>描述</th>
			<th>管理</th>
		<tr>
		<form action="./index.php?m=fri&a=del" method="post">
<?php foreach($row as $user){
?>
		<tr align="center">
			<td><input type="checkbox" name="id[]" value="<?php echo $user['id'] ?>" /></td>
			<td><?php echo $user['id'] ?></td>
			<td><?php echo $user['title'] ?></td>
			<td><?php echo $user['desc1'] ?></td>

			<td><a href="./index.php?m=fri&a=mod&id=<?php echo $user['id'] ?>">编辑</a>
				<a href="./index.php?m=fri&a=del&id=<?php echo $user['id'] ?>&zd=id&table=fri">删除</a>
			</td>
		</tr>
<?php
	}
?>	
		
		
	</table>
		<input type='submit'  value='批量删除' class="btn btn-info navbar-btn" />
</form>
</div>