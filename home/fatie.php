<?php
require_once "../core/common.php";

if (!isset($_GET['bk'])) {
    exit("参数错误！");
}
$bk = $_GET['bk'];
$zt = !empty($_GET['zt']) ? $_GET['zt'] : 0;
if (isset($_POST['bk'])) {
    $cid = $_POST['bk'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $ptime = $_SERVER['REQUEST_TIME'];
    $username = getCurrentUser();
    $pip = intval(ip2long($_SERVER['REMOTE_ADDR']));

    $sql = "select * from bbs_iprefuse";
    $row = mysql_func($sql);
    foreach ($row as $ip) {
        if ($pip >= $ip['ipmin'] && $pip <= $ip['ipmax']) {
            echo "<script>alert('你所在的IP已被禁止发帖！')</script>";
            echo "<script>window.location.href='list.php?bk=" . $bk . "&zt=" . $zt . "'</script>";
            exit;
        }
    }

    $sql = "select * from bbs_fil";
    $row = mysql_func($sql);
    foreach ($row as $fil) {
        $count = substr_count($title, $fil['hinge']);
        if ($count != 0) {
            echo "<script>alert('你所发表的标题，含有非法字符')</script>";
            echo "<script>window.location.href='list.php?bk=" . $bk . "&zt=" . $zt . "'</script>";
            exit;
        }
        $count = substr_count($content, $fil['hinge']);
        if ($count != 0) {
            echo "<script>alert('你所发表的内容，含有非法字符')</script>";
            echo "<script>window.location.href='list.php?bk=" . $bk . "&zt=" . $zt . "'</script>";
            exit;
        }
    }
    $sql = "select u.id,u.username from bbs_user as u where username='" . $username['username'] . "'";
    $row = mysql_func($sql);
    if (!$row) {
        echo "非法登入，用户不存在！";
        echo '<script>window.location.href=./fatie.php?bk=' . $bk . '&zt=' . $zt . '</script>';
        exit;
    }
    $uid = $row[0]['id'];
    $content = htmlspecialchars($content);

    $sql = "insert into bbs_post(cid,title,content,ptime,uid,pip) value('$cid','$title','$content','$ptime','$uid','$pip')";
    $row = mysql_func($sql);

    if (!$row) {
        echo "<script>alert('发帖失败，请稍候再试！')</script>";
        echo "<script>window.location.href=./fatie.php?bk=" . $bk . "&zt=" . $zt . "</script>";
        die;
    } else {
        echo "<script>alert('发帖成功，即将返回列表.')</script>";
    }

    echo "<pre>";
    ?>

    <script>window.location.href = "./index.php?m=tiezi&a=index&bk=<?php echo $bk ?>&zt=<?php echo $zt ?>"</script>
    <?php
}

$rand_a = rand(100,10000);
$_SESSION['fatie'] = $rand_a;
?>

<?php
require_once "public/header.php";
?>

<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-edit me-2"></i>发表新帖
            </div>
            <div class="paper-body">
                <form action="_fatie.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $rand_a ?>" />
                    <input type="hidden" name="bk" value="<?php echo $bk ?>"/>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-heading me-1"></i>帖子标题</label>
                        <input type="text" class="form-control form-control-lg" name="title" placeholder="请输入帖子标题" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="fas fa-content me-1"></i>帖子内容</label>
                        <textarea name="content" id="content"></textarea>
                    </div>

                    <div class="text-end">
                        <a href="./index.php?m=tiezi&a=index&bk=<?php echo $bk ?>" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i>返回
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>发表帖子
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once "public/footer.php"; ?>

<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    UE.getEditor('content');
</script>
