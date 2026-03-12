<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['pname'])){
    $pname = $_POST['pname'];
    $padmins = $_POST['padmins'];

    $sql = "update bbs_part set pname='$pname',padmins='$padmins' where id=".$id;
    $row = mysql_func($sql);

    if(!$row===0){
        echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=part&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=part&a=lists'</script>";
    exit;
}

$sql = "select * from bbs_part as p where id='$id'";
$row = mysql_func($sql);
$part = $row[0];
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-folder me-2"></i>编辑分区
        <a href="./index.php?m=part&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=part&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-tag text-muted me-1"></i>分区名称</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="pname" value="<?= htmlspecialchars($part['pname']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-user text-muted me-1"></i>分区版主</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="padmins" value="<?= $part['padmins'] ?>">
                    <div class="form-text">请输入版主用户ID</div>
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
