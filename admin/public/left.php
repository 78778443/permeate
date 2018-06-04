<!-- <div class="left side-menu">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 874px;">
        <div class="sidebar-inner slimscrollleft" style="overflow: hidden; width: auto; height: 874px;">
            <div class="user-details">
                <div class="pull-left">
                    <img src="./resorce/moltran/avatar-1(1).jpg" alt=""
                         class="thumb-md img-circle">
                </div>
                <div class="user-info">
                    <div class="dropdown">
                        <a class="nav-link" href="#"
                           class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">J
                           ohn Doe 
                           <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="nav-link" href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile
                                    <div class="ripple-wrapper"></div>
                                </a></li>
                            <li><a class="nav-link" href="javascript:void(0)"><i class="md md-settings"></i>
                                    Settings</a></li>
                            <li><a class="nav-link" href="javascript:void(0)"><i class="md md-lock"></i> Lock screen</a>
                            </li>
                            <li><a class="nav-link" href="javascript:void(0)"><i class="md md-settings-power"></i>
                                    Logout</a></li>
                        </ul>
                    </div>

                    <p class="text-muted m-0">Admin</p>
                </div>
            </div>
            <div id="sidebar-menu">
                <ul>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="slimScrollBar"
             style="background: rgb(122, 134, 143); width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 874px; visibility: visible;"></div>
        <div class="slimScrollRail"
             style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
    </div>
</div> -->
<nav class="left-nav" style="">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a class="nav-link" href="../index.php">前台首页</a></li>
        <li class="nav-item"><a class="nav-link" href="<?=U('user/lists', array('title' => '用户'))?>">用户列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=part&a=lists">分区列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=cate&a=lists">版块列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=post&a=lists">帖子列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=reply&a=lists">回帖列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=reply&a=list_pb">屏蔽回帖</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=fri&a=lists">链接列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=ipre&a=lists">过滤列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=fil&a=lists">生效列表</a></li>
        <li class="nav-item"><a class="nav-link" href="?m=manage&a=lists">网站信息</a></li>
        <li>
            <a class="nav-link" href="<?=U('public/logout')?>"
               class="waves-effect"><i class="md md-home"></i><span> 退出后台 </span></a>
        </li>
    </ul>
</nav>