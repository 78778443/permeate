<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	include "../includes/del_func.php";

?>

<div class="container">
  <form action="del.php" method="post">
    <input type="hidden" name="zd" value="id" />
    <input type="hidden" name="table" value="cate" />
    <table width="870px" border="2px" class="table table-bordered">
      <tr>
        <th>多选</th>
        <th>ID</th>
        <th>板块名称</th>
        <th>所属分区</th>
        <th>版主</th>
        <th>管理</th>
      </tr>
      <?php
	$sql = "select c.*,p.pname from ".DB_PRE."cate as c left join ".DB_PRE."part as p on c.pid=p.id";
	$row = mysql_func($sql);
	foreach($row as $cate){
	$sql = "select username from ".DB_PRE."user where id=".$cate['uid'];
	
	$row1 = mysql_func($sql);
	$username = $row1[0]['username'];
	//var_dump($row1);
?>
      <tr align="center">
        <td><input type="checkbox" name="id[]" value="<?php echo $cate['id'] ?>" /></td>
        <td><?php echo $cate['id'] ?></td>
        <td><?php echo $cate['cname'] ?></td>
        <td><?php echo date('Y-m-d H:i:s',$cate['pname']); ?></td>
        <td><?php echo $username ?></td>
        <td><a href="mod.php?id=<?php echo $cate['id'] ?>">编辑</a> <a href="del.php?id=<?php echo $cate['id'] ?>&zd=id&table=cate">删除</a></td>
      </tr>
      <?php
	}
?>
    </table>
    <input type='submit'  value='批量删除' class="btn btn-default navbar-btn" />
  </form>
</div>
