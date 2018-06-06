<?php
require_once "../conf/dbconfig.php";
require_once "../conf/web_config.php";


?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <title>
        <?php echo WZ_TITLE; ?>
    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name='keywords' content='<?php echo WZ_KEY; ?>'>
    <meta name='description' content='<?php echo WZ_DES; ?>'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/home/resource/dist/bootstrap.css" rel="stylesheet">
    <link href="/home/resource/dist/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/home/resource/fonts/css/fontawesome-all.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand active" aria-current="true" href="/">Permeate</a>
        <div class="collapse navbar-collapse">
            <form action="search.php">
                <div class="navbar-search">
                    <input class="form-control mr-sm-2" type="search" name="keywords" placeholder="搜索"
                           aria-label="Search">
                    <button class="search" aria-label="Search"><i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav mt-lg-0">
                <li class="nav-item"><a class="nav-link" aria-current="true" href="/">首页</a></li>
            </ul>
        </div>
        <div class="my-lg-0">
            <div class="navbar-user">
                <div class="d-flex">
                    <?php
                    if (!empty($_SESSION['home']['username'])) {
                        $username = $_SESSION['home']['username'];
                        ?>
                        <div class="user-link">
                            <a href="/home/index.php?m=user&a=individual&id=<?php echo $username['id'] ?>">
                                <img class="rounded-circle border-light"
                                     src="<?=$username['pic'] ?>" alt="头像">
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?= url('user/individual',['uid'=>$username['id']]) ?>">个人资料</a>
                                <a class="dropdown-item" href="../admin/index.php">后台管理</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./index.php?m=user&a=logout">登出</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="nav-sign">
                            <a class="nav-link sign-link" href="./index.php?m=user&a=login">登陆</a>
                            <span>|</span>
                            <a class="nav-link sign-link" href="./index.php?m=user&a=register">注册</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</nav>