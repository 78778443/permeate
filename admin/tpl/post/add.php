<?php
	$sql = "select * from bbs_cate";

    $row = mysql_func($sql);

?>
<div class="container">
<form action="./index.php?m=post&a=add" method="post" >
<table class="table">
	<tr><td>所属主题：</td><td><select name="cid"> 
		<?php foreach($row as $cate){echo  "<option value=".$cate['id'].">".$cate['cname']."</option>"; }?>   
		</select ></td></tr>
	<tr><td>标题：</td><td><input type="text" name="title" /></td></tr>
	<tr>
	<td>帖子内容：</td>
	<td>
	<textarea name="content" cols="40" rows="4" wrap="VIRTUAL"> </textarea>
	</td>
	</tr>
	<tr>
	<td>
	<input type="submit" value="发表主题" class="btn btn-info navbar-btn" />
	</td>
	<td>
	<input type="reset" value="重新填写" class="btn btn-info navbar-btn" />
	</td>
	</tr>
 </table>
</form>
</div>
