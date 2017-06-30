<?php
	header("content-type:text/html;charset=utf-8");
	include "../public/demon.php";
	include "../conf/web_config.php";
		
		
?>
<div class="container">
<form action="mod.php" method="post" enctype="multipart/form-data" >
<table class="table table-bordered">
	<tr><td>*网站标题</td><td><input type="text" name="WZ_TITLE" value="<?php echo WZ_TITLE ?>"></td></tr>
	<tr><td>*网站标签</td><td><input type="text" name="WZ_KEY" value="<?php echo WZ_KEY ?>"></td></tr>
	<tr><td>*网站版权</td><td><input type="text" name="WZ_PRINT" value="<?php echo WZ_PRINT ?>"></td></tr>
	<tr><td>*网站简介</td><td><textarea name="WZ_DES">OHIH</textarea></td></tr>
	<tr><td>*网站LOGO</td><td><input type="file" name="WZ_LOGO" ><img src="<?php echo WZ_LOGO ?>" /></td></tr>
	<tr><td>*网站状态</td><td>	
	<?php function ab($a,$b){if($a==$b){ echo 'checked';}} ?>
    <label><input type="radio" name="zt" value="0" <?php ab(zt,0) ?> />关闭</label>
    <label><input type="radio" name="zt" value="1"  <?php ab(zt,1) ?> />开启</label>
	</td></tr>
</table>
	<input type="submit" class="btn" value="确定修改" />
</form>
</div>