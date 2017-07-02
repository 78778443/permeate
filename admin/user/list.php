<?php
	include "/public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	
	$keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
	if(!empty($keywords)){
		$where = " where username like '%$keywords%' ";
		$link = "&keywords=".$keywords;
	}else{
		$where = "";
		$link = "";
	}
	
	//开始分页大小
	$page_size = 3;
	
	//获取当前页码
	$page_num = empty($_GET['page'])?1:$_GET['page'];
	
	//计算记录总数
	$sql = "select count(*) as c from ".DB_PRE."user ".$where;
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
	
	$sql = "select u.id,u.username,u.admins,u.rtime,u.rip,d.qq,d.sex,d.age,d.email from ".DB_PRE."user as u left join ".DB_PRE."user_detail as d on u.id=d.uid".$where.$limit;

	
	$row = mysql_func($sql);
	
?>
<br /><br /><br /><br /><br /><br />
<div class="container">
  <form>
    搜索用户名：
    <input style="float:rig;" type='text' name='keywords'  class='input-medium search-query' />
    &nbsp;&nbsp;&nbsp;
    <input type='submit' value='搜索' class='btn' />
  </form>
  <form action="del.php" method="post">
    <table width="870px" border="2px" class="table table-bordered">
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
        <?php
	
	foreach($row as $user){
?>
      <tr align="center">
        <td><input type="checkbox" name="id[]" value="<?php echo $user['id'] ?>" /></td>
        <td><?php echo $user['id'] ?></td>
        <td><?php echo $user['username'] ?></td>
        <td><?php echo  $admins[$user['admins']] ?></td>
        <td><?php echo date('Y-m-d H:i:s',$user['rtime']) ?></td>
        <td><?php echo long2ip($user['rip']) ?></td>
        <td><?php echo $user['age'] ?></td>
        <td><?php echo $sex[$user['sex']] ?></td>
        <td><?php echo $user['qq'] ?></td>
        <td><a href="mod.php?id=<?php echo $user['id'] ?>">编辑</a> <a href="del.php?id=<?php echo $user['id'] ?>&zd=id&table=user">删除</a></td>
      </tr>
      <?php
	}
?>
    </table>
    <input type='submit'  value='批量删除' class="btn btn-default navbar-btn"/>
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
	</ul>";
?>
</div>
