<?php
	$sql = "select u.id,u.username,u.admins,u.rtime,u.rip,d.qq,d.sex,d.age,d.email from bbs_user as u left join bbs_user_detail as d on u.id=d.uid".$where.$limit;

	$row = mysql_func($sql);
?>
<div>
  <form>
    搜索用户名：
    <input style="float:rig;" type='text' name='keywords'  class='input-medium search-query' />
    &nbsp;&nbsp;&nbsp;
    <input type='submit' value='搜索' class='btn' />
  </form>
  <form action="del.php" method="post">
    <table border="2px" class="table table-bordered">
      <input type="hidden" name="zd" value="id" />
      <input type="hidden" name="table" value="user" />
      <tr >
        <th>多选</th>
        <th>ID</th>
        <th>用户名</th>
        <th>权限</th>
        <th>注册时间</th>
        <th>注册IP</th>
        <th>年龄</th>
        <th>性别</th>
        <th>QQ</th>
        <th>管理</th>
      <tr>
        <?php foreach($row as $user){
?>
      <tr>
        <td><input type="checkbox" name="id[]" value="<?php echo $user['id'] ?>" /></td>
        <td><?php echo $user['id'] ?></td>
        <td><?php echo $user['username'] ?></td>
        <td><?php echo  $admins[$user['admins']] ?></td>
        <td><?php echo date('Y-m-d H:i:s',$user['rtime']) ?></td>
        <td><?php echo long2ip($user['rip']) ?></td>
        <td><?php echo $user['age'] ?></td>
        <td><?php echo $sex[$user['sex']] ?></td>
        <td><?php echo $user['qq'] ?></td>
        <td><a href="./index.php?m=user&a=mod&id=<?php echo $user['id'] ?>">编辑</a> <a href="./index.php?m=user&a=del&id=<?php echo $user['id'] ?>&zd=id&table=user">删除</a></td>
      </tr>
      <?php
	}
?>
    </table>
    <input type='submit'  value='批量删除' class="btn btn-info navbar-btn"/>
  </form>
  
<?php
	echo "
	<ul class='pager'>
		<li><a href='?m=user&a=lists&page=1".$link."'>首页</a></li>
		<li><a href='?m=user&a=lists&page=".($page_num-1).$link."'>上一页</a></li>
		<li><li><a href='?m=user&a=lists&page=".($page_num+1).$link."'>下一页</a></li>
		<li><a href='?m=user&a=lists&page=".$page_count.$link."'>尾页</a></li>
		<li>总共".$page_count."页</li>
		<li>本页".(($page_num==$page_count&&$count%$page_size!=0)?($count%$page_size):$page_size)."条</li>
		<li>总共".$count."条</li>
	</ul>";
?>
</div>
