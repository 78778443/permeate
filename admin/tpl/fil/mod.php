<?php
header("content-type:text/html;charset=utf-8");
require_once "../public/demon.php";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['hinge'])){
    $hinge = $_POST['hinge'];

    $sql = "update bbs_fil set hinge='$hinge' where id='$id'";
    $row = mysql_func($sql);

    if($row===false){
        echo "<script>alert('抱歉！写入数据失败，请稍后再试')</script>";
        echo "<script>window.location.href='./index.php?m=fil&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=fil&a=lists'</script>";
    exit;
}

$sql = "select * from bbs_fil where id='$id'";
$row = mysql_func($sql);
$fil = $row[0];
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-filter me-2"></i>编辑敏感词
        <a href="./index.php?m=fil&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=fil&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-ban text-muted me-1"></i>关键词</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="hinge" value="<?= htmlspecialchars($fil['hinge']) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 offset-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i>保存修改
                    </button>
                    <button type="reset" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="fas fa-undo me-1"></i>重置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
