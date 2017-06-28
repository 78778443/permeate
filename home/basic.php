<?php
header('content-type:text/html;charset=utf-8');
session_start();
include "../conf/dbconfig.php";
include "../includes/mysql_func.php";
include "public/header.php";
$user = $_SESSION['home']['username'];
if (empty($user)) {
    echo "<script>window.location.href='login.php'</script>";
    exit;
}
function aabb($a, $b)
{
    if ($a == $b) {
        return "selected";
    }
}

//var_dump($user);
?>
<link rel="stylesheet" type="text/css" href="./resource/styles/basic.css"/>
<body>
<!--individual-->
<div class="individual">
    <div class="individual_left personal_left">
        <ul>
            <li class="individual_left_h3">
                <h3>设置</h3>
            </li>
            <li><a href="individual.php">修改头像</a></li>
            <li class="individual_left_li"><a href="basic.php">个人资料</a></li>
            <li><a href="">积分</a></li>
            <li><a href="">用户组</a></li>
            <li><a href="">隐私筛选</a></li>
            <li><a href="safe.php">密码安全</a></li>
            <li><a href="">访问推广</a></li>
        </ul>
    </div>
    <div class="personal_right">
        <ul class="personal_right_ul">
            <li class="personal_right_ul_li"><a href="">基本资料</a></li>
        </ul>
        <div class="personal_right_border"></div>
        <table class="personal_right_table">
            <form action="./hadel/dobasic.php" method="post">
                <tr>
                    <th width="135" height="34">用户名</th>
                    <td width="539" height="34"><?php echo $user['username'] ?></td>
                    <td class="personal_right_table_td" width="126" height="34"></td>
                </tr>
                <tr>
                    <th width="135" height="42">真实姓名</th>
                    <td width="539" height="42"><input class="personal_right_table_text" name="t_name" type="text"
                                                       value="<?php echo $user['t_name'] ?>"/></td>
                </tr>
                <tr>
                    <th width="135" height="42">年龄</th>
                    <td width="539" height="42"><input class="personal_right_table_text" name="age" type="text"
                                                       value="<?php echo $user['age'] ?>"/></td>
                </tr>
                <tr>
                    <th width="135" height="42">性别</th>
                    <td width="539" height="42"><select name="sex">
                            <?php foreach ($sex as $key => $val) {
                                $sex = $user['sex'];
                                $select = aabb($sex, $key);
                                echo "<option $select value='$key' >$val</option>";
                            } ?>
                        </select></td>
                </tr>
                <tr>
                    <th width="135" height="42">学历</th>
                    <td width="539" height="42">
                        <select name="edu">
                            <?php foreach ($edu as $key => $val) {
                                $edu = $user['edu'];
                                $select = aabb($edu, $key);
                                echo "<option $select value='$key' >$val</option>";
                            } ?>
                        </select></td>
                </tr>
                <tr>
                    <th width="135" height="42">个性签名</th>
                    <td width="539" height="42">
                        <TEXTAREA value="signed" rows="5" cols="100" name="signed"><?php echo $user['signed'] ?></TEXTAREA></td>
                </tr>

                <tr>
                    <th width="135" height="42">生日</th>
                    <td width="539" height="42">
                        <input class="personal_right_table_text" type="text" name="brithday"
                                                       value="<?php echo $user['brithday'] ?>"/></td>
                </tr>
                <tr>
                    <th width="135" height="42">电话</th>
                    <td width="539" height="42">
                        <input class="personal_right_table_text" name="telphone"
                               value="<?php echo $user['telphone'] ?>"/></td>
                </tr>
                <tr>
                    <th width="135" height="42">QQ</th>
                    <td width="539" height="42">
                        <input class="personal_right_table_text" name="qq" value="<?php echo $user['qq'] ?>"/></td>
                </tr>
                <tr>
                    <th width="135" height="42">电子邮箱</th>
                    <td width="539" height="42">
                        <input class="personal_right_table_text" name="email" type="email"
                               value="<?php echo $user['email'] ?>"/></td>
                </tr>
                <tr>
                <tr>
                    <th width="135" height="42"></th>
                    <td width="539" height="42"><input type="submit" value="确定修改" class="btn"/>
                    <td class="personal_right_table_td" width="126" height="42"></td>
                </tr>
        </table>
        <div class="clear"></div>
    </div>
</div>
</form>
</body>
<?php //引用函数库mysql_function.php
include "public/footer.php";
?>
