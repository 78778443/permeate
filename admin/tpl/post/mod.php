<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(!empty($_POST['cid'])){
    $cid = $_POST['cid'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "update bbs_post set cid='$cid',title='$title',content='$content' where id='$id'";
    $row = mysql_func($sql);

    if(!$row===0){
        echo "<script>alert('抱歉！更新失败，请稍后再试！')</script>";
        echo "<script>window.location.href='./index.php?m=post&a=lists'</script>";
        exit;
    }

    echo "<script>window.location.href='./index.php?m=post&a=lists'</script>";
    exit;
}

$sql = "select p.*,c.cname from bbs_post as p,bbs_cate as c where p.cid=c.id and p.id='$id'";
$row = mysql_func($sql);
$post = $row[0];

$sql_cates = "select * from bbs_cate";
$cates = mysql_func($sql_cates);
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-file-alt me-2"></i>编辑帖子
        <a href="./index.php?m=post&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=post&a=mod&id=<?= $id ?>" method="post">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-th-large text-muted me-1"></i>所属板块</label>
                <div class="col-sm-6">
                    <select class="form-select" name="cid">
                        <?php foreach($cates as $cate){ ?>
                        <option value="<?= $cate['id'] ?>" <?= ($cate['id'] == $post['cid']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cate['cname']) ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-heading text-muted me-1"></i>主题</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-align-left text-muted me-1"></i>内容</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="content" rows="5"><?= htmlspecialchars($post['content']) ?></textarea>
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
