<?php
	$sql = "select * from bbs_part";

    $row = mysql_func($sql);
?>
<div class="container">
<form action="./index.php?m=cate&a=add" method="post" class="navbar-form navbar-left" >
<table class="table">
	<tr><td>分区名称：</td><td><select name="pid"> 
		<?php foreach($row as $part){echo  "<option value=".$part['id'].">".$part['pname']."</option>"; }?>
    </select > </td></tr>
	<tr><td>板块名称：</td><td><input type="text" name="cname" /></td></tr>
	<tr><td><input class="form-control" type="submit" value="添加板块" class="btn btn-info navbar-btn"/></td></tr>
   </table>
</form>
</div>