<link rel="stylesheet" type="text/css" href="./resource/styles/style_1_common.css"/>
<link rel="stylesheet" type="text/css" href="./resource/styles/style_1_home_space.css"/>

<div id="wp" class="wp">
    <div id="pt" class="bm cl">
        <div class="z">
            <a href="index.php" class="nvhm" title="首页"></a> <em>&#8250;</em>
            <a href="index.php?m=user&a=info&id=<?php echo $strUserInfo['uid'];?>"><?php echo $strUserInfo['t_name']?></a>
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
            <div class="icn avt"><a
                    href="./湖中沉的个人资料 - Discuz! 官方站 - Powered by Discuz!_files/湖中沉的个人资料 - Discuz! 官方站 - Powered by Discuz!.html"><img
                        src="./湖中沉的个人资料 - Discuz! 官方站 - Powered by Discuz!_files/38_avatar_small.jpg"
                        onerror="this.onerror=null;this.src=&#39;http://uc.discuz.net/images/noavatar_small.gif&#39;"></a>
            </div>
            <h2 class="mt">
                <?php echo $strUserInfo['t_name']?></h2>
            <p>
                <a href="index.php/?m=user&a=info&id=<?php echo $strUserInfo['uid'];?>" class="xg1"><?php echo  $_SERVER['SERVER_NAME'].'/index.php/?m=user&a=info&id='.$strUserInfo['uid'];?></a>
            </p>
        </div>

        <ul class="tb cl" style="padding-left: 75px;">
            <li class="a"><a href="index.php/?m=user&a=info&id=<?php echo $strUserInfo['uid'];?>">个人资料</a>
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
                                <?php echo $strUserInfo['t_name'];?>
                                <span class="xw0">(UID: <?php echo $strUserInfo['uid'];?>)</span>
                            </h2>
                            <ul class="pf_l cl pbm mbm">
                                <li><em>邮箱状态</em>已验证</li>
                            </ul>
                            <ul class="cl bbda pbm mbm">
                                <li>
                                    <em class="xg2">统计信息</em>
                                    <span class="pipe">|</span><a
                                        href="http://www.discuz.net/home.php?mod=space&uid=411938&do=thread&view=me&type=reply&from=space"
                                        target="_blank">回帖数 <?php echo $strUserInfo['reply_count']?></a>
                                    <span class="pipe">|</span>
                                    <a href="http://www.discuz.net/home.php?mod=space&uid=411938&do=thread&view=me&type=thread&from=space"
                                       target="_blank">主题数 <?php echo $strUserInfo['tiezi_count']?></a>
                                </li>
                            </ul>
                            <ul class="pf_l cl">
                                <li><em>性别</em><?php echo $strUserInfo['sex_name']?></li>
                                <li><em>生日</em>1989 年 4 月 26 日</li>
                                <li><em>公司</em>杭州富迪文化艺术策划有限公司</li>
                                <li><em>个人主页</em><a href="http://www.kuozhan.net/" target="_blank">http://www.kuozhan.net</a>
                                </li>
                            </ul>
                        </div>
                        <div class="pbm mbm bbda cl">
                            <h2 class="mbn">用户认证</h2><a
                                href="http://www.discuz.net/home.php?mod=spacecp&ac=profile&op=verify&vid=2"
                                target="_blank"><img
                                    src="./湖中沉的个人资料 - Discuz! 官方站 - Powered by Discuz!_files/common_2_verify_icon.png"
                                    class="vm" alt="建议达人" title="建议达人"></a>&nbsp;
                            <a href="http://www.discuz.net/home.php?mod=spacecp&ac=profile&op=verify&vid=4"
                               target="_blank"><img
                                    src="./湖中沉的个人资料 - Discuz! 官方站 - Powered by Discuz!_files/common_4_verify_icon.png"
                                    class="vm" alt="开发者" title="开发者"></a>&nbsp;
                        </div>
                        <div class="pbm mbm bbda cl">
                            <h2 class="mbn">活跃概况</h2>
                            <ul>
                                <li><em class="xg1">用户组&nbsp;&nbsp;</em><span style="color:" class="xi2"
                                                                              onmouseover="showTip(this)"
                                                                              tip="积分 51263, 距离下一级还需 98737 积分"><a
                                            href="http://www.discuz.net/home.php?mod=spacecp&ac=usergroup&gid=66"
                                            target="_blank">Angel</a></span></li>
                            </ul>
                            <ul id="pbbs" class="pf_l">
                                <li><em>在线时间</em>9346 小时</li>
                                <li><em>注册时间</em>2006-8-2 14:11</li>
                                <li><em>最后访问</em>2017-7-2 21:08</li>
                                <li><em>上次活动时间</em>2017-7-2 21:08</li>
                                <li><em>上次发表时间</em>2017-7-2 17:36</li>
                                <li><em>上次邮件通知</em>2009-10-5 16:13</li>
                                <li><em>所在时区</em>(GMT +08:00) 北京, 香港, 帕斯, 新加坡, 台北</li>
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