<?php
$get = $_GET;
?>
<section class="section">
    <div class="container">
        <div class="paper">
            <div class="post-list">
                <table class="table table-post-list">
                    <thead>
                    <tr>
                        <th>帖子标题</th>
                        <th>作者</th>
                        <th>回复/查看</th>
                        <th>最后发表</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($row as $post) { ?>
                        <tr>
                            <td>
                                <a href="<?= url('tiezi/detail',array('bk'=>$bk,'zt'=>$post['id']));?>"><?= $post['title'] ?></a>
                            </td>
                            <td><?php echo $post['username'] ?></td>
                            <td><?= $post['reply_count']; ?>/<?php echo $post['click'] ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $post['ptime']) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="post-list-controller">
                    <div style="float: right">
                        <a class="btn btn-primary" href="fatie.php?bk=<?php echo $bk ?>">发帖</a>
                    </div>

                    <nav class="page">
                        <ul class='pagination'>
                            <?php echo "
                            <li class=\"page-item\">
                            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=index&page=1&bk=" . $get['bk'] . "'>首页</a></li>
                            <li class=\"page-item\">
                            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=index&?page=" . ($page_num - 1) . "&bk=" . $get['bk'] . "'>上一页</a></li>
                            <li class=\"page-item\">
                            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=index&?page=" . ($page_num + 1) . "&bk=" . $get['bk'] . "'>下一页</a></li>
                            <li class=\"page-item\">
                            <a class=\"page-link\" href='/home/index.php?m=tiezi&a=index&?page=" . $page_count . "&bk=" . $get['bk'] . "'>尾页</a></li>
                            <li class=\"page-item\"><span class='page-text'>总共" . $page_count . "页</span></li>
                            <li class=\"page-item\"><span class='page-text'>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</span></li>
                            <li class=\"page-item\"><span class='page-text'>总共" . $count . "条</span></li>
                            " ?>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>

    </div>
</section>