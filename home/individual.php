<?php
header('content-type:text/html;charset=utf-8');
session_start();
include "../core/mysql_func.php";
include "public/header.php";
$user = $_SESSION['home']['username'];
if (empty($user)) {
    echo "<script>window.location.href='login.php'</script>";
    exit;
}
?>
    <link rel="stylesheet" href="resource/styles/style.css" type="text/css">
    <style type="text/css"></style>

    <body>
    <form action="public/update_img.php" method="post" enctype="multipart/form-data">
        <div class="individual">
            <div class="individual_left">
                <ul>
                    <li class="individual_left_h3">
                        <h3>设置</h3>
                    </li>
                    <li class="individual_left_li"><a href="#">修改头像</a></li>
                    <li><a href="basic.php">个人资料</a></li>
                    <li><a href="safe.php">密码安全</a></li>
                </ul>
            </div>
            <div class="individual_right">
                <ul class="individual_right_ul">
                    <li>
                        <h3>当前我的头像</h3>
                    </li>
                    <li><a href="/" class="btn btn-link">返回上一页</a></li>
                </ul>
                <ul class="individual_right_ul_1">
                    <li>如果您还没有设置自己的头像，系统会显示为默认头像，您需要自己上传个性照片来作为自己的个人头像</li>
                    <li class="individual_right_ul_1_img"><img src="<?php echo strstr($username['pic'], '../r'); ?>">
                        <img src="<?php echo strstr($username['picm'], '../r'); ?>"> <img
                                src="<?php echo strstr($username['pics'], '../r'); ?>"></li>
                    <li>
                        <h3>设置我的新头像</h3>
                    </li>
                    <li>请选择一个新照片进行上传编辑</li>
                    <li>
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    </li>
                    <input type="file" name="pic">
                    <li>
                        <input type="submit" class="btn btn-success" value="确认提交">
                    </li>
                </ul>
            </div>
        </div>
    </form>
    </body>
<?php
include "public/footer.php";
?>