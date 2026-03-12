<?php
if($_POST['id']){
    $id = @$_POST['id'];
    $pid = @$_POST['pid'];
    $content = @$_POST['content'];
    $uid = @$_POST['uid'];

    $sql = "update bbs_reply set pid='$pid',content='$content',uid='$uid' where id=".$id;
    $row = mysql_func($sql);

    if(!$row){
        echo "<script>alert('服务器出错，请稍候再试！')</script>";
    }
    echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
}

if(!$_GET['id']){
    echo '参数错误:缺少指定ID';
    exit;
}

$id = $_GET['id'];

$sql = "select * from bbs_reply where id=".$id;
$user = mysql_func($sql);
$reply = $user[0];

$sql_posts = "select * from bbs_post";
$posts = mysql_func($sql_posts);
?>

<div class="card">
    <div class="card-header">
        <i class="fas fa-comments me-2"></i>编辑回帖
        <a href="./index.php?m=reply&a=lists" class="btn btn-outline-secondary btn-sm float-end">
            <i class="fas fa-arrow-left me-1"></i>返回列表
        </a>
    </div>
    <div class="card-body">
        <form action="./index.php?m=reply&a=mod" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="uid" value="<?= $reply['uid'] ?>">

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-file-alt text-muted me-1"></i>所属主贴</label>
                <div class="col-sm-6">
                    <select class="form-select" name="pid">
                        <?php foreach($posts as $post){ ?>
                        <option value="<?= $post['id'] ?>" <?= ($post['id'] == $reply['pid']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($post['title']) ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><i class="fas fa-align-left text-muted me-1"></i>内容</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="content" rows="5"><?= htmlspecialchars($reply['content']) ?></textarea>
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
