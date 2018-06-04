<?php
	$sql = "select * from bbs_post";
	
	$row = mysql_func($sql);
	
?>

<div class="container">
  <form action="./index.php?m=reply&a=add" method="post" >
    <table>
      <tr>
        <td>所属板块：</td>
        <td><select name="pid">
            <?php foreach($row as $post){echo  "<option value=".$post['id'].">".$post['title']."</option>"; }?>
          </select ></td>
      </tr>
      <tr>
        <td>帖子内容:</td>
        <td><textarea name="content" cols="40" rows="4" wrap="VIRTUAL"> </textarea></td>
      </tr>
      <tr>
        <td><input type="submit" value="注册" class="btn btn-info navbar-btn" /></td>
      </tr>
    </table>
  </form>
</div>
