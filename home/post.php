<?php
header('content-type:text/html;charset=utf-8');
$zt = $_GET['zt'];
if (empty($zt)) {
    exit ("参数1错误！");
}
$bk = $_GET['bk'];
if (empty($bk)) {
    exit ("参数2错误！");
}
?>
<?php

session_start();
include "../conf/dbconfig.php";
include "../core/mysql_func.php";
include "public/header.php";
?>
    <link rel="stylesheet" type="text/css" href="./resource/styles/post.css"/>
    <div class="fatie">
        <a class="img" href="fatie.php?bk=<?php echo $bk ?>">
            <img src="resource/images/pn_post.png"/></a>
        <a class="img" href="huifu.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>">
            <img src="resource/images/pn_reply.png"/></a>
        <a class="btn btn-info" href="list.php?bk=<?php echo $bk ?>">返回列表
        </a>
    </div>
    </div>
    <div class="clear"></div>
    <!--头部end-->
    <!--内容start-->
    <div class="content_listshow">
        <?php
        $sql = "select p.*,u.*,d.* from bbs_post as p,bbs_user as u,bbs_user_detail as d where p.uid=u.id and d.uid=p.uid and p.id='$zt'";
        $row = mysql_func($sql);
        $post = $row[0];
		$reply_count_sql = "select count(id) as count from bbs_reply where pid={$zt} ";
		$reply_count = mysql_func($reply_count_sql)[0];
        ?>
        <table cellspacing="0" width="1170px">
            <tr>
                <td class="list_width" align="center">回复:<?= $reply_count['count'];?><span>|</span>查看:<?= $post['click'];?></td>
                <td class="list_con"><?php echo $post['title'] ?></td>
            </tr>
        </table>
        <table cellspacing="0" width="1170px">
            <tr>
                <td class="list_width" align="center">
                    <div class="list_width_title"><?php echo $post['username'] ?></div>
                    <img src="<?php echo strstr($post['pic'], '../r'); ?>" title="" alt=""/>
                    <ul class="list_style_none">
                        <li>UID:<?php echo $post['uid'] ?></li>
                        <li>NAME:<?php echo $post['username'] ?></li>
                        <li>AGE:<?php echo $post['age'] ?></li>
                    </ul>
                </td>
                <td class="list_con1" valign="top">
                    <div class="list_width_title2"><?php echo date('Y年-m月-d日 H:i:s', $post['rtime']) ?></div>
                    <div class="list_width_cont"><?php echo $post['content'] ?></div>
                </td>
            </tr>
            <?php
            //开始分页大小
            $page_size = 5;

            //获取当前页码
            $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

            //计算记录总数
            $sql = "select count(*) as c from bbs_reply ";
            $row = mysql_func($sql);
            $count = $row[0]['c'];

            //计算记录总页数
            $page_count = ceil($count / $page_size);
            //防止越界
            if ($page_num >= $page_count) {
                $page_num = $page_count;
            }
            if ($page_num <= 0) {
                $page_num = 1;
            }


            //准备SQL语句
            $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;
            $sql = "select r.*,u.*,d.* from bbs_reply as r,bbs_user as u,bbs_user_detail as d where r.uid=u.id and d.uid=r.uid and r.pid='$zt'" . $limit;
            //echo $sql;
            //echo $sql;
            //exit;
            $row = mysql_func($sql);
            foreach ($row as $reply) {
                ?>
                <tr>
                    <td class="list_width" align="center">
                        <div class="list_width_title"><?php echo $reply['username'] ?></div>
                        <img src="<?php echo strstr($reply['pic'], '../r'); ?>" title="" alt=""/>
                        <ul class="list_style_none">
                            <li>UID:<?php echo $reply['uid'] ?></li>
                            <li>NAME:<?php echo $reply['username'] ?></li>
                            <li>AGE:<?php echo $reply['age'] ?></li>
                        </ul>
                    </td>
                    <td class="list_con1" valign="top">
                        <div class="list_width_title2">发表于：<?php echo date('Y年-m月-d日 H:i:s', $reply['rtime']) ?></div>

                        <div class="list_width_cont"><?php
                            if ($reply['xx'] != '1') {
                                echo "<i>内容已被管理员屏蔽</i>";
                            } else {
                                echo $reply['content'];
                            } ?></div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
<?php
echo "
	<ul class='pager'>
		<li><a href='?page=1&bk=" . $bk . "&zt=" . $zt . "'>首页</a></li>
		<li><a href='?page=" . ($page_num - 1) . "&bk=" . $bk . "&zt=" . $zt . "'>上一页</a></li>
		<li><li><a href='?page=" . ($page_num + 1) . "&bk=" . $bk . "&zt=" . $zt . "'>下一页</a></li>
		<li><a href='?page=" . $page_count . "&bk=" . $bk . "&zt=" . $zt . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>";
?>
    <!--内容end-->
<?php
include "public/footer.php";
?>