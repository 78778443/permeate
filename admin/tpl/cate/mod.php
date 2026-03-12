<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['cname'])){
    $cname = $_POST['cname'];
    $pid = $_POST['pid'];

    $sql = "update bbs_cate set cname='$cname',pid='$pid' where id=".$id;
    $row = mysql_func($sql);

    if(!$row===0){
        echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
    exit;
}

$sql = "select c.*, p.pname from bbs_cate as c left join bbs_part as p on c.pid=p.id where c.id='$id'";
$row = mysql_func($sql);
$cate = $row[0];

$sql_parts = "select * from bbs_part";
$parts = mysql_func($sql_parts);
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-th-large me-2"></i>编辑版块
        <a href="./index.php?m=cate&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=cate&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-folder text-muted me-1"></i>所属分区</label>
                <div class="col-sm-6">
                    <select class="form-select" name="pid">
                        <?php foreach($parts as $part){ ?>
                        <option value="<?= $part['id'] ?>" <?= ($part['id'] == $cate['pid']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($part['pname']) ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-tag text-muted me-1"></i>版块名称</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="cname" value="<?= htmlspecialchars($cate['cname']) ?>">
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
