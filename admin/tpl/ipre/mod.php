<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['ipmin'])){
    $ipmin = ip2long($_POST['ipmin']);
    $ipmax = ip2long($_POST['ipmax']);

    $sql = "update bbs_iprefuse set ipmin='$ipmin',ipmax='$ipmax' where id='$id'";
    $row = mysql_func($sql);

    if($row===false){
        echo "<script>alert('抱歉！写入数据失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=ipre&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=ipre&a=lists'</script>";
    exit;
}

$sql = "select * from bbs_iprefuse where id='$id'";
$row = mysql_func($sql);
$ipre = $row[0];
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-ban me-2"></i>编辑IP黑名单
        <a href="./index.php?m=ipre&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=ipre&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-server text-muted me-1"></i>开始IP</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="ipmin" value="<?= long2ip($ipre['ipmin']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-server text-muted me-1"></i>结束IP</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="ipmax" value="<?= long2ip($ipre['ipmax']) ?>">
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
