<link rel="stylesheet" type="text/css" href="./resource/styles/style_1_common.css"/>
<link rel="stylesheet" type="text/css" href="./resource/styles/style_1_home_space.css"/>

<div id="wp" class="wp">
    <div id="pt" class="bm cl">
        <div class="z">
            <a href="index.php" class="nvhm" title="首页"></a> <em>&#8250;</em>
            <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>"><?php echo $strUserInfo['t_name'] ?></a>
            <em>&#8250;</em>
            个人资料
        </div>
    </div>
    <style id="diy_style" type="text/css"></style>
    <div class="wp">
        <!--[diy=diy1]-->
        <div id="diy1" class="area"></div><!--[/diy]-->
    </div>
    <div id="uhd">
        <div class="h cl">
            <div class="icn avt">
                <a href="/"> <img src="/"  onerror=""></a>
            </div>
            <h2 class="mt">
                <?php echo $strUserInfo['t_name'] ?></h2>
            <p>
                <a href="index.php/?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>"
                   class="xg1"><?php echo $_SERVER['SERVER_NAME'] . '/index.php/?m=user&a=info&id=' . $strUserInfo['uid']; ?></a>
            </p>
        </div>

        <ul class="tb cl" style="padding-left: 75px;">
            <li class="a"><a href="index.php/?m=user&a=info&id=<?php echo $strUserInfo['uid']; ?>">个人资料</a>
            </li>
        </ul>
    </div>
    <div id="ct" class="ct1 wp cl">
        <div class="mn">
            <!--[diy=diycontenttop]-->
            <div id="diycontenttop" class="area"></div><!--[/diy]-->
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
                                    <span class="pipe">|</span><a
                                            href="/home.php?mod=space&uid=411938&do=thread&view=me&type=reply&from=space"
                                            target="_blank">回帖数 <?php echo $strUserInfo['reply_count'] ?></a>
                                    <span class="pipe">|</span>
                                    <a href="/home.php?mod=space&uid=411938&do=thread&view=me&type=thread&from=space"
                                       target="_blank">主题数 <?php echo $strUserInfo['tiezi_count'] ?></a>
                                </li>
                            </ul>
                            <ul class="pf_l cl">
                                <li><em>性别</em><?php echo $strUserInfo['sex_name'] ?></li>
                                <li><em>生日</em>1989 年 4 月 26 日</li>
                                <li><em>公司</em>杭州富迪文化艺术策划有限公司</li>
                            </ul>
                        </div>
                        <div class="pbm mbm bbda cl">
                            <h2 class="mbn">活跃概况</h2>
                            <ul>
                                <li><em class="xg1">用户组&nbsp;&nbsp;</em>
                                    <span style="color:" class="xi2" onmouseover="showTip(this)" tip="积分 51263, 距离下一级还需 98737 积分">
                                        <a  href="/" target="_blank">Angel</a></span>
                                </li>
                            </ul>
                            <ul id="pbbs" class="pf_l">
                                <li><em>在线时间</em>9346 小时</li>
                                <li><em>注册时间</em>2006-8-2 14:11</li>
                                <li><em>最后访问</em>2017-7-2 21:08</li>
                            </ul>
                        </div>
                    </div><!--[diy=diycontentbottom]-->
                    <div id="diycontentbottom" class="area"></div><!--[/diy]--></div>
            </div>
        </div>
    </div>

    <div class="wp mtn">
        <!--[diy=diy3]-->
        <div id="diy3" class="area"></div><!--[/diy]-->
    </div>
</div>