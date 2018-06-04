<div class="container p-4">
	<form action="./index.php?m=manage&a=mod" method="post" enctype="multipart/form-data">
		<table class="table table-bordered">
			<tr>
				<td>*网站标题</td>
				<td>
					<input class="form-control" type="text" name="WZ_TITLE" value="<?php echo WZ_TITLE ?>">
				</td>
			</tr>
			<tr>
				<td>*网站标签</td>
				<td>
					<input class="form-control" type="text" name="WZ_KEY" value="<?php echo WZ_KEY ?>">
				</td>
			</tr>
			<tr>
				<td>*网站版权</td>
				<td>
					<input class="form-control" type="text" name="WZ_PRINT" value="<?php echo WZ_PRINT ?>">
				</td>
			</tr>
			<tr>
				<td>*网站简介</td>
				<td>
					<textarea class="form-control" name="WZ_DES">OHIH</textarea>
				</td>
			</tr>
			<tr>
				<td>*网站LOGO</td>
				<td>
					<input class="form-control" type="file" name="WZ_LOGO">
					<img src="<?php echo WZ_LOGO ?>" />
				</td>
			</tr>
			<tr>
				<td>*网站状态</td>
				<td>
					<?php function ab($a, $b)
						{if ($a == $b) {echo 'checked';}}?>
					<label>
						<input type="radio" name="zt" value="0" <?php ab(zt, 0)?> />关闭</label>
					<label>
						<input type="radio" name="zt" value="1" <?php ab(zt, 1)?> />开启</label>
				</td>
			</tr>
		</table>
		<div class="text-right">
			<input type="submit" class="btn btn-info" value="确定修改" />
		</div>
</div>