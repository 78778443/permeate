<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['title'])){
    $title = $_POST['title'];
    $desc1 = $_POST['desc1'];
    $url = $_POST['url'];
    $pic = $_POST['pic'];

    $sql = "update bbs_fri set title='$title',desc1='$desc1',url='$url',pic='$pic' where id='$id'";
    $row = mysql_func($sql);

    if(!$row===0){
        echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
    exit;
}

$sql = "select * from bbs_fri where id='$id'";
$row = mysql_func($sql);
$fri = $row[0];
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-link me-2"></i>编辑友情链接
        <a href="./index.php?m=fri&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=fri&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-heading text-muted me-1"></i>标题</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="title" value="<?= htmlspecialchars($fri['title']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-align-left text-muted me-1"></i>描述</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="desc1" value="<?= htmlspecialchars($fri['desc1']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-globe text-muted me-1"></i>URL</label>
                <div class="col-sm-6">
                    <input class="form-control" type="url" name="url" value="<?= htmlspecialchars($fri['url']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-image text-muted me-1"></i>图片</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="pic" value="<?= htmlspecialchars($fri['pic']) ?>">
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
