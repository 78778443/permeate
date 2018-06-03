<section class="section">

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="padding-left: 0;background-color: transparent;">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php" title="首页">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">
                        <?php echo $strUserInfo['t_name'] ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    个人资料
                </li>
            </ol>
        </nav>
        <div class="paper">
            <div class="media" style="margin-bottom: 20px;">
                <span style="width: 88px;height: 88px;background-color: #eee;margin-right: 20px;display: inline-block;border-radius: .25rem;">
                    <img class="mr-3" src="<?= $strUserInfo['pic'] ?>" alt="头像" style="width: 88px;height: 88px;border-radius: .25rem;">
                </span>
                <div class="media-body">
                    <h5 class="mt-0">汤青松</h5>
                    <p>
                        <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>" class="xg1">
                            <?php echo $_SERVER['SERVER_NAME'] . '/index.php/?m=user&a=info&id=' . $strUserInfo['uid']; ?>
                        </a>
                    </p>
                </div>
            </div>
            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">个人资料</a>
                    </li>
                </ul>
            </div>
            <div class="pt-3 pl-2">
                <p>
                    <?php echo $strUserInfo['t_name']; ?>
                    <span class="xw0">(UID: <?php echo $strUserInfo['uid']; ?>)</span>
                </p>
                <p>邮箱状态 已验证</p>
                <p>
                    <span>统计信息：</span>
                    <span>回帖数 <?php echo $strUserInfo['reply_count'] ?></span>
                    |
                    <span>主题数 <?php echo $strUserInfo['tiezi_count'] ?></span>
                    |
                    <span>粉丝数 <?php echo $strUserInfo['follow_count'] ?></span>
                </p>
            </div>
        </div>
    </div>

</section>