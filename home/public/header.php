<?php
require_once "../conf/dbconfig.php";
require_once "../conf/web_config.php";
function bj($a, $b)
{
    if ($a == $b) {
        echo "<script>alert('网站维护中！')</script>";
        exit('网站维护！');
    }
}

bj(zt, 0);

?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <title><?php echo WZ_TITLE; ?></title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name='keywords' content='<?php echo WZ_KEY; ?>'>
    <meta name='description' content='<?php echo WZ_DES; ?>'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if( $_SERVER['PHP_SELF'] != '/home/index.php'){ ?>
    <link rel="stylesheet" type="text/css" href="/public/Bootstrap3/css/bootstrap.min.css">
    <?php } ?>
    <link href="/home/resource/dist/permeate.min.css" rel="stylesheet">
    <link href="/home/resource/font/material-icons.css" rel="stylesheet">
</head>

<body>
<header class="nav-bar is-default">
    <div class="nav container">
        <div class="nav-brand">
            Permeate
        </div>
        <ul class="nav-list">
            <li class="list-item">
                <a class="item-link is-active" href="/">首页</a>
            </li>
            <li class="list-item">
                <a class="item-link" href="/home/index.php?m=user&a=login">注册</a>
            </li>
        </ul>
        <ul class="nav-list nav-list-right">
            <li class="list-item">
                <form action="search.php">
                    <label class="search">
                        <input class="form-input" name="keywords" type="text" placeholder="搜索">
                        <a role="button">
                            <i class="material-icons search-icon">search</i>
                        </a>
                    </label>
                </form>
            </li>
            <li class="list-item">
                <a class="item-link" href="#">消息</a>
            </li>
            <li class="list-item">
                <a class="item-link" href="#">提醒</a>
            </li>
            <li class="list-item">
                <?php
                if (!empty($_SESSION['home']['username'])) {
                    $username = $_SESSION['home']['username'];
                    ?>
                    <a class="user-link" href="individual.php?id=<?php echo $username['id'] ?>">
                        <img class="user-img" src="<?php echo strstr($username['pics'], '../r'); ?>" alt="">
                        <span><small><?php echo $username['username']; ?></small></span>
                    </a>
                </li>
                <li class="list-item">
                    <a class="item-link" href="../admin/index.php">后台管理</a>
                </li>
                <li class="list-item">
                    <a class="item-link" href="./index.php?m=user&a=logout">退出</a>
                </li>
            <?php } else {
                ?>
                <li class="list-item">
                    <a class="item-link" href="./index.php?m=user&a=login">登录</a>
                </li>
                <li class="list-item">
                    <a class="item-link" href="./index.php?m=user&a=login">注册</a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="nav-secondary">
        <div class="container">
            <!--路径导航-->
            <ul class="route-guidance">
                <li class="guidance-item">
                    <span>首页</span>
                </li>
                <li class="guidance-item">
                    <a href="#">门户</a>
                </li>
            </ul>
        </div>
    </div>
</header>