
    <link rel="stylesheet" type="text/css" href="./resource/styles/list.css"/>
    <div class="fatie"><a class="img" href="fatie.php?bk=<?php echo $bk ?>"><img src="resource/images/pn_post.png"/></a>
    </div>

    <!--主体start-->

    <div id="main">
        <div id="main_title">
            <table class="table table-striped">
                <tr>
                    <td class="tab_bt">帖子标题</td>
                    <td class="tab_zz">作者</td>
                    <td class="tab_hf">回复/查看</td>
                    <td class="tab_zh">最后发表</td>
                </tr>
            </table>
        </div>
        <div id="main_content">
            <table>
                <?php
                foreach ($row as $post) {
                    ?>
                    <tr>
                        <td class="tab_bt"><a href="index.php?m=tiezi&a=detail&bk=<?php echo $bk;
                            echo '&zt=' . $post['id'] ?>"><?php echo $post['title'] ?>
                                </href>
                            </a></td>
                        <td class="tab_zz"><a href><?php echo $post['username'] ?></a></td>
                        <td class="tab_hf"><a href><?= $post['reply_count'];?>/<?php echo $post['click']?></a></td>
                        <td class="tab_zh"><a href><?php echo date('Y-m-d H:i:s', $post['ptime']) ?></a></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="line_xhx"></div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
<?php
echo "
	<ul class='pager'>
		<li><a href='index.php?m=tiezi&bk=" . $bk . "&page=1'>首页</a></li>
		<li><a href='index.php?m=tiezi&bk=" . $bk . "&page=" . ($page_num - 1) . "'>上一页</a></li>
		<li><li><a href='index.php?m=tiezi&bk=" . $bk . "&page=" . ($page_num + 1) . "'>下一页</a></li>
		<li><a href='index.php?m=tiezi&bk=" . $bk . "&page=" . $page_count . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>
	";
?>