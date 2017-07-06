<link rel="stylesheet" type="text/css" href="./resource/styles/huifu.css"/>
<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.all.js"></script>
<div id="main">
    <div class="main_title">回复：</div>
    <form action="<?= url('tiezi/reply',array('bk'=>$bk,'zt'=>$zt))?>" method="post">
        <input type="hidden" name="id" value="<?php echo $zt ?>"/>
        帖子主题:<input type="text" size="100" value="<?php echo $title; ?> " disabled/></p>
        内容:</p><textarea name="content" id="content" cols="120" rows="20"></textarea></p>
        <input type="submit" value="发&nbsp;&nbsp;&nbsp;表" class="btn btn-default"/> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="reset" value="重&nbsp;&nbsp;&nbsp;写" class="btn btn-default"/>
    </form>
</div>
<?php //引用函数库mysql_function.php
include "public/footer.php";
?>
<script type="text/javascript">
    UE.getEditor('content');
</script>
