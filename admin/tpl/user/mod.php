<?php
require_once "../core/upload_func.php";
require_once "../core/image_func.php";

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

    $data = upload($info, 'pic', '../resources/images/userhead');
    $pic = $data['newname'];

    if (!empty($password)) {
        $password = md5($password);
        $sql = "update bbs_user set password='$password' where id='$id'";
        $row = mysql_func($sql);
    }

    $sql = "update bbs_user set admins='$admins' where id='$id'";
    $row = mysql_func($sql);

    if (!$row === 0) {
        echo "<script>alert('你没有修改！')</script>";
        echo "<script>window.location.href = './index.php?m=user&a=lists'</script>";
        exit;
    }

    if (!empty($pic)) {
        $pic = suolue($pic, 200, 200, '../resources/images/userhead/');
        $picm = suolue($pic, 100, 100, '../resources/images/userhead/');
        $pics = suolue($pic, 48, 48, '../resources/images/userhead/');
        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',pic='$pic',telphone='$telphone',qq='$QQ',email='$email',picm='$picm',pics='$pics' where uid=$id";
    } else {
        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',telphone='$telphone',qq='$QQ',email='$email' where uid=$id";
    }

    $row = mysql_func($sql);

    if (!$row === 0) {
        echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
        echo "<script>window.location.href = './index.php?m=user&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
    exit;
}

$sql = "select u.*,d.* from bbs_user as u,bbs_user_detail as d where d.uid=u.id and id='$id'";
$row = mysql_func($sql);
$user = $row[0];

function edu($user, $val) {
    if ($user == $val) echo "selected";
}
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-user-edit me-2"></i>编辑用户
        <a href="./index.php?m=user&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=user&a=mod&id=<?= $id ?>" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-user-shield text-muted me-1"></i>权限</label>
                <div class="col-sm-6">
                    <select class="form-select" name="admins">
                        <option value="0" <?php edu($user['admins'], 0) ?>>普通用户</option>
                        <option value="1" <?php edu($user['admins'], 1) ?>>管理员</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-user text-muted me-1"></i>用户名</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-lock text-muted me-1"></i>新密码</label>
                <div class="col-sm-6">
                    <input class="form-control" type="password" name="password" placeholder="留空则不修改">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-id-card text-muted me-1"></i>真实姓名</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="t_name" value="<?= htmlspecialchars($user['t_name']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-birthday-cake text-muted me-1"></i>年龄</label>
                <div class="col-sm-6">
                    <input class="form-control" type="number" name="age" value="<?= $user['age'] ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-venus-mars text-muted me-1"></i>性别</label>
                <div class="col-sm-6">
                    <select class="form-select" name="sex">
                        <option value="0" <?php edu($user['sex'], 0) ?>>保密</option>
                        <option value="1" <?php edu($user['sex'], 1) ?>>男</option>
                        <option value="2" <?php edu($user['sex'], 2) ?>>女</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-graduation-cap text-muted me-1"></i>学历</label>
                <div class="col-sm-6">
                    <select class="form-select" name="edu">
                        <?php foreach ($edu as $k => $v) { ?>
                        <option value="<?= $k ?>" <?php edu($user['edu'], $k) ?>><?= $v ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-pen text-muted me-1"></i>个性签名</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="signed" rows="3"><?= htmlspecialchars($user['signed']) ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-image text-muted me-1"></i>头像</label>
                <div class="col-sm-6">
                    <input class="form-control" type="file" name="pic">
                    <div class="mt-2">
                        <img src="<?= getAvatar($user['pic'], $user['username']) ?>" class="rounded" style="max-height: 60px;">
                        <img src="<?= getAvatar($user['picm'], $user['username']) ?>" class="rounded" style="max-height: 40px;">
                        <img src="<?= getAvatar($user['pics'], $user['username']) ?>" class="rounded" style="max-height: 30px;">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-phone text-muted me-1"></i>电话</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="telphone" value="<?= htmlspecialchars($user['telphone']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fab fa-qq text-muted me-1"></i>QQ</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="qq" value="<?= htmlspecialchars($user['qq']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-envelope text-muted me-1"></i>邮箱</label>
                <div class="col-sm-6">
                    <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 offset-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i>保存修改
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
