<section class="section">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home me-1"></i>首页</a></li>
                <li class="breadcrumb-item">
                    <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">
                        <?= htmlspecialchars($strUserInfo['t_name']) ?>
                    </a>
                </li>
                <li class="breadcrumb-item active">个人资料</li>
            </ol>
        </nav>

        <div class="paper">
            <div class="paper-body">
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <img src="<?= htmlspecialchars($strUserInfo['pic']) ?>" alt="头像" class="rounded-circle" style="width: 88px; height: 88px; object-fit: cover; border: 3px solid #e1e8ed;">
                    </div>
                    <div class="col">
                        <h4 class="mb-1"><?= htmlspecialchars($strUserInfo['t_name']) ?></h4>
                        <p class="text-muted mb-0">
                            <i class="fas fa-link me-1"></i>
                            <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">
                                <?= $_SERVER['SERVER_NAME'] ?>/index.php/?m=user&a=info&id=<?= $strUserInfo['uid'] ?>
                            </a>
                        </p>
                    </div>
                </div>

                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-user me-1"></i>个人资料</a>
                    </li>
                </ul>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong><?= htmlspecialchars($strUserInfo['t_name']) ?></strong>
                            <span class="text-muted">(UID: <?= $strUserInfo['uid'] ?>)</span>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope text-muted me-2"></i>邮箱状态：<span class="text-success">已验证</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-4 text-center">
                            <div>
                                <h4 class="mb-0 text-primary"><?= $strUserInfo['tiezi_count'] ?></h4>
                                <small class="text-muted">主题</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-info"><?= $strUserInfo['reply_count'] ?></h4>
                                <small class="text-muted">回帖</small>
                            </div>
                            <div>
                                <h4 class="mb-0 text-success"><?= $strUserInfo['follow_count'] ?></h4>
                                <small class="text-muted">粉丝</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
