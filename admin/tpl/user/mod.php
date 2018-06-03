<?php
include "../core/upload_func.php";
include "../core/image_func.php";
?>
    <?php
$id = $_GET['id'];

if (!empty($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $admins = $_POST['admins'];
    $t_name = $_POST['t_name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $edu = $_POST['edu'];
    $signed = $_POST['signed'];
    $telphone = $_POST['telphone'];
    $QQ = $_POST['qq'];
    $email = $_POST['email'];

    $data = upload($info, 'pic', '../resorce/images/userhead');
    $pic = $data['newname'];

    //更新数据到USER表
    if (!empty($password)) {
        $password = md5($password);
        $sql = "update bbs_user set password='$password' where id='$id'";
        $row = mysql_func($sql);
    }

    $sql = "update bbs_user set admins='$admins' where id='$id'";
    $row = mysql_func($sql);

    if (!$row === 0) {
        echo "<script>alert('你没有修改！')</script>";
        echo "<script>window.location.href='./index.php?m=user&a=lists'<script/>";
        exit;
    }

    if (!empty($pic)) {
        $pic = suolue($pic, 200, 200, '../resorce/images/userhead/');
        $picm = suolue($pic, 100, 100, '../resorce/images/userhead/');
        $pics = suolue($pic, 48, 48, '../resorce/images/userhead/');

        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',pic='$pic',telphone='$telphone',qq='$QQ',email='$email',picm='$picm',pics='$pics' where uid=$id";

    } else {
        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',telphone='$telphone',qq='$QQ',email='$email' where uid=$id";
    }
    //更新数据到USER详情表当中
    //echo $sql;
    $row = mysql_func($sql);

    if (!$row === 0) {
        echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=user&a=lists'<script/>";
        exit;
    }

    //执行过程中没有出现以为，将跳转到LIST列表当中
    echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
    exit;
}

//POST不存在，将查询表中数据
$sql = "select u.*,d.* from bbs_user as u,bbs_user_detail as d where uid=id and id='$id'";
$row = mysql_func($sql);
$user = $row[0];
?>
        <div class="container">
            <table>
                <form action="./index.php?m=user&a=mod&id=<?php echo $id ?>" method="post" enctype="multipart/form-data" class="navbar-form navbar-left">
                    <?php function edu($user, $val)
{if ($user == $val) {echo "selected";}}?>

                    <tr>
                        <td>管理员：</td>
                        <td><select name="admins" />
                            <option value="0" <?php edu($user[ 'admins'], 0)?> />非管理员</option>
                            <option value="1" <?php edu($user[ 'admins'], 1)?> />管理员</option>
                            </select>
                        </td>
                    </tr>
                    <p />
                    <tr>
                        <td>用户名：</td>
                        <td><input type="text" name="username" value="<?php echo $user['username'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>新密码：</td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td>真实姓名：</td>
                        <td><input type="text" name="t_name" value="<?php echo $user['t_name'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>年龄：</td>
                        <td><input type="text" name="age" value="<?php echo $user['age'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>性别：</td>
                        <td>
                            <select name="sex">
							<option value="0" <?php edu($user['sex'], 0)?>  ><?php echo $sex['0'] ?></option>
							<option value="1" <?php edu($user['sex'], 1)?>  ><?php echo $sex['1'] ?></option>
							<option value="2" <?php edu($user['sex'], 2)?>  ><?php echo $sex['2'] ?></option>
						</select>
                        </td>
                    </tr>
                    <tr>
                        <td>学历：</td>
                        <td><select name="edu">
							<option value="0" <?php edu($user['edu'], 0)?>   ><?php echo $edu['0'] ?></option>
							<option value="1" <?php edu($user['edu'], 1)?>  ><?php echo $edu['1'] ?></option>
							<option value="2" <?php edu($user['edu'], 2)?>  ><?php echo $edu['2'] ?></option>
							<option value="3" <?php edu($user['edu'], 3)?>  ><?php echo $edu['3'] ?></option>
							<option value="4" <?php edu($user['edu'], 4)?>  ><?php echo $edu['4'] ?></option>
							<option value="5" <?php edu($user['edu'], 5)?>  ><?php echo $edu['5'] ?></option>
							<option value="6" <?php edu($user['edu'], 6)?>  ><?php echo $edu['6'] ?></option>
							<option value="7" <?php edu($user['edu'], 7)?>  ><?php echo $edu['7'] ?></option>
						</select></td>
                    </tr>
                    <tr>
                        <td>个性签名：</td>
                        <td><textarea name="signed" cols="40" rows="4"><?php echo $user['signed'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td>头像：</td>
                        <td><input type="file" name="pic" value="<?php echo $user['pic'] ?>" /><img src="<?php echo $user['pic'] ?>" />&nbsp;<img src="<?php echo $user['picm'] ?>" />&nbsp;<img src="<?php echo $user['pics'] ?>" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td>电话：</td>
                        <td><input type="text" name="telphone" value="<?php echo $user['telphone'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>QQ：</td>
                        <td><input type="text" name="qq" value="<?php echo $user['qq'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>email：</td>
                        <td><input type="text" name="email" value="<?php echo $user['email'] ?>" /></td>
                    </tr>

                    <tr>
                        <td colspan=2> <input type="submit" value="确认修改" class="btn btn-default" /></td>
                    </tr>
                </form>
            </table>
        </div>