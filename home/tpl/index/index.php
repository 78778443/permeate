<link rel="stylesheet" type="text/css" href="./resource/styles/index.css"/>
<section class="section">
    <div class="container">
        <div class="plate">

            <?php
            //组装成一个大数组
            $sql = "SELECT * FROM bbs_part";
            $row = mysql_func($sql);
            foreach ($row as &$part) {
                $sql = "SELECT * FROM bbs_cate WHERE pid=" . $part['id'];
                $cate = mysql_func($sql);
                $part['cates'] = $cate;
            }
            foreach ($row as $part1) {
                $sql = "SELECT * FROM bbs_user WHERE id=" . $part1['padmins'];
                $rowpart = mysql_func($sql);
                $rowName = $rowpart[0]['username'];
                $rowId = $rowpart[0]['id'];
                ?>
                <div class="plate-item">
                    <div class="plate-content">
                        <div class="plate-header">
                            <?= $part1['pname'] ?>
                            <span>|</span>
                            <span>版主：<a href="<?= url('user/info', array('id' => $rowId)) ?>"><?= $rowName ?></a></span>
                        </div>
                        <div class="plate-body">
                            <div class="row">
                                <?php $i = 0;
                                foreach ($part1['cates'] as $cate) {
                                    //查询主题数量
                                    $sql = "SELECT count(*) AS cou FROM bbs_post WHERE cid=" . $cate['id'];

                                    $row = mysql_func($sql);
                                    $x = 0;
                                    $x = $x + ($row[0]['cou']);
                                    //查询最后发表
                                    $sql = "SELECT ptime FROM bbs_post";
                                    $row = mysql_func($sql);
                                    $z = 0;
                                    if ($row[0]['ptime'] != false) {
                                        $z = $z + $row[0]['ptime'];
                                    }
                                    //查询回复数量
                                    $sql = "select count(*) as num from bbs_reply where pid in (select id from bbs_post where cid={$cate['id']})";
                                    $replyNum = mysql_func($sql)[0]['num'];
                                    ?>
                                    <div class="col col-lg-3">
                                        <a class="card plate-link"
                                           href="<?php echo url('tiezi/index', array('bk' => $cate['id'])); ?>">
                                            <div class="card-header">
                                                <?php echo $cate['cname'] ?>
                                            </div>
                                            <div class="card-body">
                                                <p>
                                                    <span>帖子数量：<?php echo $x ?></span>
                                                </p>
                                                <p>
                                                    <span>回复数量：<?=$replyNum ?></span>
                                                </p>
                                                <p>
                                                    <small>更新时间：<?php echo date('Y-m-d H:i', $z) ?></small>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>