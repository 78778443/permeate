<!-- <link rel="stylesheet" type="text/css" href="./resource/styles/style_1_common.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="./resource/styles/style_1_home_space.css" /> -->

<!-- <div id="wp" class="wp">
    <div id="pt" class="bm cl">
        <div class="z">
            <a href="index.php" class="nvhm" title="首页"></a> <em>&#8250;</em>
            <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">
                <?php echo $strUserInfo['t_name'] ?>
            </a>
            <em>&#8250;</em> 个人资料
        </div>
    </div>
    <style id="diy_style" type="text/css"></style>
    <div class="wp">
        <div id="diy1" class="area"></div>
    </div>
    <div id="uhd">
        <div class="h cl">
            <div class="icn avt">
                <a href="/"> <img src="/" onerror=""></a>
            </div>
            <h2 class="mt">
                <?php echo $strUserInfo['t_name'] ?>
            </h2>
            <p>
                <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>" class="xg1">
                    <?php echo $_SERVER['SERVER_NAME'] . '/index.php/?m=user&a=info&id=' . $strUserInfo['uid']; ?>
                </a>
            </p>
        </div>

        <ul class="tb cl" style="padding-left: 75px;">
            <li class="a"><a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">个人资料</a>
            </li>
        </ul>
    </div>
    <div id="ct" class="ct1 wp cl">
        <div class="mn">
            <div id="diycontenttop" class="area"></div>
            <div class="bm bw0">
                <div class="bm_c">
                    <div class="bm_c u_profile">

                        <div class="pbm mbm bbda cl">
                            <h2 class="mbn">
                                <?php echo $strUserInfo['t_name']; ?>
                                <span class="xw0">(UID: <?php echo $strUserInfo['uid']; ?>)</span>
                            </h2>
                            <ul class="pf_l cl pbm mbm">
                                <li><em>邮箱状态</em>已验证</li>
                            </ul>
                            <ul class="cl bbda pbm mbm">
                                <li>
                                    <em class="xg2">统计信息</em>
                                    <span class="pipe">|</span> 回帖数
                                    <?php echo $strUserInfo['reply_count'] ?>
                                    <span class="pipe">|</span> 主题数
                                    <?php echo $strUserInfo['tiezi_count'] ?>
                                    <span class="pipe">|</span> 粉丝数
                                    <?php echo $strUserInfo['follow_count'] ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wp mtn">
        <div id="diy3" class="area"></div>
    </div>
</div> -->

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
                    <img class="mr-3" src="..." alt="头像" style="width: 88px;height: 88px;border-radius: .25rem;">
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