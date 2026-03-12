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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <!-- Custom Styles -->
    <link href="/home/resource/dist/style.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="fas fa-shield-alt me-2"></i>Permeate
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- 搜索框 -->
            <form action="search.php" class="d-flex mx-lg-3">
                <div class="navbar-search">
                    <input class="form-control" type="search" name="keywords" placeholder="搜索帖子..." aria-label="Search">
                    <button class="search-btn" type="submit" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- 导航链接 -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"><i class="fas fa-home me-1"></i>首页</a>
                </li>
            </ul>
        </div>

        <!-- 用户区域 -->
        <div class="d-flex align-items-center">
            <?php
            if (!empty(getCurrentUser())) {
                $username = getCurrentUser();
            ?>
                <div class="user-link">
                    <a href="/home/index.php?m=user&a=individual&id=<?php echo $username['id'] ?>">
                        <img src="<?=$username['pic'] ?>" alt="头像">
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= url('user/individual',['uid'=>$username['id']]) ?>">
                            <i class="fas fa-user me-2"></i>个人资料
                        </a>
                        <?php if($username['admins']) {?>
                        <a class="dropdown-item" href="../admin/index.php">
                            <i class="fas fa-cog me-2"></i>后台管理
                        </a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./index.php?m=user&a=logout">
                            <i class="fas fa-sign-out-alt me-2"></i>退出登录
                        </a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="nav-sign">
                    <a class="nav-link sign-link" href="./index.php?m=user&a=login">
                        <i class="fas fa-sign-in-alt me-1"></i>登录
                    </a>
                    <span class="text-muted">|</span>
                    <a class="nav-link sign-link" href="./index.php?m=user&a=register">
                        <i class="fas fa-user-plus me-1"></i>注册
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
