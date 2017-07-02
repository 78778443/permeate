<?php
	include "/public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	$sql = "select * from ".DB_PRE."cate";

    $row = mysql_func($sql);

?>
<div class="container">
<form action="./post/iadd.php" method="post" >
<table>
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
	<input type="submit" value="发表主题" class="btn btn-default navbar-btn" />
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" />
	<tr>
	<td>
	<input type="submit" value="发表主题" class="btn btn-default navbar-btn" />
	</td>
	<td>
	<input type="reset" value="重新填写" class="btn btn-default navbar-btn" />
	</td>
	</tr>
 </table>
</form>
</div>
