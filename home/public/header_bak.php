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
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name='keywords' content='<?php echo WZ_KEY; ?>'>
    <meta name='description' content='<?php echo WZ_DES; ?>'>
    <title><?php echo WZ_TITLE; ?></title>
    <link rel="stylesheet" type="text/css" href="../public/Bootstrap3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href='../home/resource/styles/public.css'/>
</head>
<body>
<!--头start-->
<div id="top">
    <div id="top_left">
        <span>设为主页</span>
        <span>收藏本站</span>
    </div>
    <div id="top_right">
        <span>切换为宽屏</span>
    </div>
</div>
<!--头end-->
<!--页眉start-->
<div id="header">
    <a href="/">
        <div id="banner1"></div>
    </a>
    <div id="logo">
        <a href="/">
            <h2>轻松渗透测试</h2>
        </a>
    </div>
    <div id="login">

        <?php
        if (empty($_SESSION['home']['username'])) {
            ?>
            <form action="public/login.php" method="post" class="form-inline">
                <table>
                    <tr>
                        <td>帐号:</td>
                        <td><input type="text" name="username" placeholder="输入你的账号"/></td>
                        <td>
                            <label class="checkbox">
                                <input type="checkbox" name="auto_login" value="1"/>
                                自动登入
                                </label>
                        </td>
                        <td><a href="/home/index.php?m=repasswd" class="btn btn-link">找回密码</a></td>
                    </tr>
                    <tr>
                        <td>密码：</td>
                        <td><input type="password" name="password" placeholder="输入你的密码"/></td>
                        <td><input type="submit" class="btn btn-default" value="立即登入"/></td>
                        <td><a  class="btn btn-link" href="register.php">立即注册</a></td>
                    </tr>
                </table>
            </form>
            <?php
        } else {
            $username = $_SESSION['home']['username'];
            ?>
            <ul class="ul_1">
                <li><a href="individual.php?id=<?php echo $username['id'] ?>">
                        <?php


                        echo $username['username'];
                        ?>
                    </a></li>
                <li><a href="#">在线</a></li>
                <li>|</li>
                <li><a href="#">设置</a></li>
                <li>|</li>
                <li><a href="#">消息</a></li>
                <li>|</li>
                <li><a href="#">提醒</a></li>
                <li>|</li>
                <li><a href="../admin/index.php">模块管理</a></li>
                <li>|</li>
                <li><a href="../admin/index.php">管理中心</a></li>
                <li>|</li>
                <li><a href="./public/logout.php">退出</a></li>
                <br/>
            </ul>
            <div class="clear"></div>
            <ul class="ul_2">
                <li class="right"><a href="#"><?php echo $username['username']; ?></a></li>
                <li class="right"><a href="#">积分</a></li>
                <li class="right">:</li>
                <li class="right"><a href="#">4</a></li>
                <li class="right">|</li>
                <li class="right"><a href="#">用户组</a></li>
                <li class="right">:</li>
                <li class="right"><a href="#">管理员</a></li>
            </ul>
            <span class="ul_2_span">
                <a href="/">
                <img src="<?php echo strstr($username['pics'], '../r'); ?>"/>
            </a>
            </span>
            <div class="clear"></div>
            <?php
        }
        ?>
    </div>
    <div class="clear"></div>
    <div id="menu">
        <div class="me">
            <ul>
                <li><a href="../home/index.php">首页</a></li>
                <li class="li_line"></li>
                <li><a href="../home/register.php">注册</a></li>
                <li class="li_line"></li>
                <li><a href>主页</a></li>
                <li class="li_line"></li>
                <li><a href>门户</a></li>
            </ul>
        </div>
        <div class="clear1"></div>
        <div class="search">
            <table cellspacing="0">
                <form action="search.php" method="get" class="form-inline">
                    <tr>
                        <td class="search_ico"></td>
                        <td class="search_ipt">
                            <input type="text" name="keywords"
                                   style="height:30px;  margin-bottom:0px;" x-webkit-speech speech
                                   placeholder="请输入搜索内容"/></td>
                        <td class="search_selet"><a href>帖子</a> <span></span></td>
                        <td class="search_btn"><input type="submit" class="btn" value="搜索"/></td>
                        <td class="search_hot">
                            <span class="title">热搜:</span>
                            <span><a href="/home/search.php?keywords=美女">美女</a></span>
                            <span><a href="/home/search.php?keywords=PHP">PHP</a></span>
                            <span><a href="/home/search.php?keywords=高清">高清</a></span>
                            <span><a href="/home/search.php?keywords=幽默">幽默</a></span>
                            <span><a href="/home/search.php?keywords=无码">无码</a></span>
                            <span><a href="/home/search.php?keywords=泡妞">泡妞</a></span>
                            <span><a href="/home/search.php?keywords=看片神奇">看片神奇</a></span></td>
                    </tr>
                </form>

            </table>
        </div>
    </div>
    <!--<div class="clear"></div>-->
    <div class="path">
        <div class="ico"><a href=""></a></div>
        <div class="path_index"><em></em> <a href>论坛</a></div>
    </div>
<!--    <div class="count"> 今日: <span class="line">|</span> <em>1024</em> <span class="line">|</span> 昨日: <em>1024</em>-->
<!--        <span class="line">|</span> 新会员: <em>1024</em> <span class="line">|</span> 新会员 <em>1024</em></div>-->
</div>
<!--页眉end-->