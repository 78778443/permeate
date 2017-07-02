<link rel="stylesheet" type="text/css" href="./resource/styles/post.css"/>
<div class="fatie">
    <a class="img" href="fatie.php?bk=<?php echo $bk ?>">
        <img src="resource/images/pn_post.png"/></a>
    <a class="img" href="huifu.php?bk=<?php echo $bk ?>&zt=<?php echo $zt ?>">
        <img src="resource/images/pn_reply.png"/></a>
    <a class="btn btn-default" href="/home/index.php?m=tiezi&a=index&bk=<?php echo $bk ?>">返回列表
    </a>
</div>
</div>
<div class="clear"></div>
<!--头部end-->
<!--内容start-->
<div class="content_listshow">
    <table cellspacing="0" width="1170px">
        <tr>
            <td class="list_width" align="center">回复:<?= $post['reply_count']; ?><span>|</span>查看:<?= $post['click']; ?>
            </td>
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
        //echo $sql;
        //echo $sql;
        //exit;
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
    <nav class="page" >
        <ul class='pagination' >
            <?php echo "
            <li class=\"page-item\">
            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=detail&page=1&bk=$bk&zt=$zt'>首页</a></li>
            <li class=\"page-item\">
            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=detail&?page=" . ($page_num - 1) . "&bk=$bk&zt=$zt'>上一页</a></li>
            <li class=\"page-item\">
            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=detail&?page=" . ($page_num + 1) . "&bk=$bk&zt=$zt'>下一页</a></li>
            <li class=\"page-item\">
            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=detail&?page=" . $page_count . "&bk=$bk&zt=$zt'>尾页</a></li>
            <li class=\"page-item\">总共" . $page_count . "页</li>
            <li class=\"page-item\">本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
            <li class=\"page-item\">总共" . $count . "条</li>
            " ?>
        </ul>
</div>

</nav>
