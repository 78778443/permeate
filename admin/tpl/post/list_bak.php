<?php
		$sql = "select p.*,u.username from bbs_post as p,bbs_user as u where p.uid=u.id and p.del='1' ".$limit;
		//exit;
		$row1 = mysql_func($sql);
?>
<div class="container">
  <form action="./index.php?m=post&a=del" method="post">
    <input type="hidden" name="zd" value="id" />
    <input type="hidden" name="table" value="post" />
    <table width="870px" border="2px" class="table table-bordered">
      <tr >
        <th>多选</th>
        <th>ID</th>
        <th>主题</th>
        <th>发帖时间</th>
        <th>发帖人</th>
        <th>管理</th>
      <tr>
        <?php
	foreach($row1 as $post){
?>
      <tr align="center">
        <td><input type="checkbox" name="id[]" value="<?php echo $post['id'] ?>" /></td>
        <td><?php echo $post['id'] ?></td>
        <td><?php echo $post['title'] ?></td>
        <td><?php echo date('Y-m-d H:i:s',$post['ptime']) ?></td>
        <td><?php echo $post['username'] ?></td>
        <td><a href="./index.php?m=post&a=mod&id=<?php echo $post['id'] ?>">编辑</a> <a href="./index.php?m=post&a=del&id=<?php echo $post['id'] ?>&zd=id&table=post&cz=2">删除</a></td>
      </tr>
      <?php
	}
?>
    </table>
    <input type='submit'  value='批量删除' class="btn btn-info navbar-btn" />
  </form>
  
  <?php
	echo "
	<ul class='pager'>
		<li><a href='./index.php?m=post&a=lists&page=1".$link."'>首页</a></li>
		<li><a href='./index.php?m=post&a=lists&page=".($page_num-1).$link."'>上一页</a></li>
		<li><li><a href='./index.php?m=post&a=lists&page=".($page_num+1).$link."'>下一页</a></li>
		<li><a href='./index.php?m=post&a=lists&page=".$page_count.$link."'>尾页</a></li>
		<li>总共".$page_count."页</li>
		<li>本页".(($page_num==$page_count&&$count%$page_size!=0)?($count%$page_size):$page_size)."条</li>
		<li>总共".$count."条</li>
	</ul>
	";

?>
</div>
