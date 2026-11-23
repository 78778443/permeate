<?php
require_once "../conf/dbconfig.php";
require_once "../conf/web_config.php";
require_once __DIR__."/../../core/common.php";
?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <title><?php echo WZ_TITLE; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='keywords' content='<?php echo WZ_KEY; ?>'>
    <meta name='description' content='<?php echo WZ_DES; ?>'>
    <!-- Bootstrap 5 CSS -->
    <link href="/public/vendor/bootstrap-5.3.2/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/public/vendor/fontawesome-6.4.2/css/all.min.css">
    <!-- Custom Styles -->
    <link href="/home/resource/dist/style.css" rel="stylesheet">
</head>

<?php
$isAuthView = isset($_GET['m'], $_GET['a'])
    && $_GET['m'] === 'user'
    && in_array($_GET['a'], array('login', 'register'), true);
?>
<body<?= $isAuthView ? ' class="auth-view"' : '' ?>>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span class="brand-icon"><i class="fas fa-shield-alt"></i></span>
            <span>Permeate</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="切换导航">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/home/index.php"><i class="fas fa-home"></i>首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/home/index.php#range-zones"><i class="fas fa-bug"></i>靶场分区</a>
                </li>
            </ul>

            <!-- 搜索框 -->
            <form action="/home/search.php" method="get" class="navbar-search ms-lg-auto me-lg-3 my-2 my-lg-0">
                <i class="fas fa-search search-icon"></i>
                <input class="form-control" type="search" name="keywords" placeholder="搜索漏洞、帖子..." aria-label="搜索帖子">
            </form>
        </div>

        <!-- 用户区域 -->
        <div class="nav-user">
            <a class="nav-gh" href="https://github.com/78778443/permeate" target="_blank" rel="noopener" title="GitHub 仓库" aria-label="GitHub">
                <i class="fab fa-github"></i>
            </a>
            <?php
            if (!empty(getCurrentUser())) {
                $username = getCurrentUser();
            ?>
                <div class="user-link">
                    <a href="/home/index.php?m=user&a=individual&id=<?php echo $username['id'] ?>" title="<?= h($username['username']) ?>">
                        <img src="<?= getAvatar($username['pic'], $username['username']) ?>" alt="<?= h($username['username']) ?> 的头像">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= url('user/individual',['uid'=>$username['id']]) ?>">
                            <i class="fas fa-user"></i>个人资料
                        </a>
                        <?php if($username['admins']) {?>
                        <a class="dropdown-item" href="../admin/index.php">
                            <i class="fas fa-cog"></i>后台管理
                        </a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./index.php?m=user&a=logout">
                            <i class="fas fa-sign-out-alt"></i>退出登录
                        </a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="auth-links">
                    <a class="auth-link login" href="./index.php?m=user&a=login">
                        <i class="fas fa-sign-in-alt"></i>登录
                    </a>
                    <a class="auth-link register" href="./index.php?m=user&a=register">
                        <i class="fas fa-rocket"></i>开始学习
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
