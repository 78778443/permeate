<?php
	include "/public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
	
	$sql = "select * from ".DB_PRE."part";

    $row = mysql_func($sql);
?>
<div class="container">
<form action="./cate/iadd.php" method="post" class="navbar-form navbar-left" >
<table>
	<tr><td>分区名称：</td><td><select name="pid"> 
		<?php foreach($row as $part){echo  "<option value=".$part['id'].">".$part['pname']."</option>"; }?>
    </select > </td></tr>
	<tr><td>板块名称：</td><td><input type="text" name="cname" /></td></tr>
	<tr><td><input type="submit" value="添加板块" class="btn btn-default navbar-btn"/></td></tr>
   </table>
</form>
</div>