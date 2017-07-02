<?php
	include "/public/demon.php";
	include "../conf/dbconfig.php";
	include "../includes/mysql_func.php";
?>
<div style="text-align:center;margin:0 auto;display:block;" class="container">
<form action="./user/iadd.php" method="post" >
	<table>
	<input type="submit" class="btn"  value="添加用户" />
	<input type="reset" class="btn" value="重新填写" />
	<tr><td>用户名：</td><td><input type="text" name="username"   /></td></tr>
	<tr><td>密　码：</td><td><input type="password" name="password" /><p/></td></tr>
	<tr><td>确认密码：</td><td><input type="password" name="repass" /><p/></td></tr>
	<tr><td><input type="submit" class="btn"  value="添加用户" /></td><td>
	<input type="reset" class="btn" value="重新填写" /></td></tr>
    </table>
</div>
</form>