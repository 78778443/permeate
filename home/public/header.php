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
    <title>permeate</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../home/resource/dist/permeate.min.css" rel="stylesheet">
    <link href="../home/resource/material-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../public/Bootstrap3/css/bootstrap.min.css">
<!--    <link rel="stylesheet" type="text/css" href='../home/resource/styles/public.css'/>-->
</head>

<body>
<header class="nav-bar is-default">
    <div class="nav container">
        <div class="nav-brand">
            Permeate
        </div>
        <ul class="nav-list">
            <li class="list-item">
                <a class="item-link is-active" href="#">首页</a>
            </li>
            <li class="list-item">
                <a class="item-link" href="#">门户</a>
            </li>
        </ul>
        <ul class="nav-list nav-list-right">
            <li class="list-item">
                <form>
                    <label class="search">
                        <input class="form-input" type="text" placeholder="搜索板块">
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
                <a class="user-link" href="#">
                    <img class="user-img" src="images/user-img.jpg" alt="">
                    <span><small>XXX用户</small></span>
                </a>
            </li>
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