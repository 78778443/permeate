<?php
include "../core/common.php";

if (!isset($_GET['bk'])) {
    exit ("参数错误！");
}
$bk = getParam('bk');
$zt = !empty(getParam('zt')) ? getParam('zt') : 0;
$csrf_token = getParam('csrf_token');
if($csrf_token != $_SESSION['fatie']) {
	echo 'csrf不合法';die;
}
$cid = getParam('bk');
$title = getParam('title');
$content = getParam('content');


$ptime = $_SERVER['REQUEST_TIME'];
$username = empty($_SESSION['home']['username']) ? '' : $_SESSION['home']['username'];
$pip = intval(ip2long($_SERVER['REMOTE_ADDR']));

$sql = "SELECT * FROM bbs_iprefuse";
$row = mysql_func($sql);
foreach ($row as $ip) {
    if ($pip >= $ip['ipmin'] && $pip <= $ip['ipmax']) {
        echo "<script>alert('你所在的IP已被禁止发帖！')</script>";
        echo "<script>window.location.href='list.php?bk=" . $bk . "&zt=" . $zt . "'</script>";
        exit;
    }
}

$sql = "SELECT * FROM bbs_fil";
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
$sql = "SELECT u.id,u.username FROM bbs_user AS u WHERE username='" . $username['username'] . "'";
$row = mysql_func($sql);
if (!$row) {
    echo "非法登入，用户不存在！";
    $url = url('user/login');
    echo '<script>window.location.href="'.$url.'";</script>';
    exit;
}
$uid = $row[0]['id'];

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
