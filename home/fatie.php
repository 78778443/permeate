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
    $username = $_SESSION['home']['username'];
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
?>


<?php
//引用函数库mysql_function.php
include "public/header.php";
?>

<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">发表新帖</div>
            <form action="_fatie.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>" method="post" style="padding-top: 20px;">
                <input type="hidden" name="bk" value="<?php echo $bk ?>"/>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">标题：</label>
                    <div class="col-sm-11">
                    <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">内容：</label>
                    <div class="col-sm-11">
                        <textarea name="content" id="content"></textarea>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">发表</button>
                </div>
                <!-- 标题:<input type="text" name="title" class="title" size="100"/></p>
                内容:</p><textarea name="content" id="content"></textarea></p> -->
            </form>
        </div>
    </div>
</section>

<?php //引用函数库mysql_function.php
include "public/footer.php";
?>
<script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="../public/ueditor/ueditor.all.js"></script>
<script type="text/javascript">
    UE.getEditor('content');
</script>
