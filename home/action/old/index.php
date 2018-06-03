<link rel="stylesheet" type="text/css" href="./resource/styles/index.css" />
<section class="section">
    <div class="container">
        <div class="plate">

            <?php
//组装成一个大数组
$sql = "select * from bbs_part";
$row = mysql_func($sql);
foreach ($row as &$part) {
    $sql = "select * from bbs_cate where pid=" . $part['id'];
    $cate = mysql_func($sql);
    $part['cates'] = $cate;
}
foreach ($row as $part1) {
    $sql = "select * from bbs_user where id=" . $part1['padmins'];
    $rowpart = mysql_func($sql);
    $rowpart = $rowpart[0]['username'];
    ?>
                <div class="plate-item">
                    <div class="plate-content">
                        <div class="plate-header">
                            <?=$part1['pname']?>
                            <span>|</span>
                            <span>版主：<?=$rowpart?></span>
                        </div>
                        <div class="plate-body">
                            <div class="row">
                                <?php $i = 0;
    foreach ($part1['cates'] as $cate) {
        //查询主题数量
        $sql = "select count(*) as cou from bbs_post where cid=" . $cate['id'];

        $row = mysql_func($sql);
        $x = 0;
        $x = $x + ($row[0]['cou'])?>
                                <?php //查询最后发表
        $sql = "select ptime from bbs_post";
        $row = mysql_func($sql);
        $z = 0;
        if ($row[0]['ptime'] != false) {
            $z = $z + $row[0]['ptime'];
        }
        ?>
                                <div class="col col-lg-3">
                                    <a class="card plate-link" href="<?php echo url('tiezi/index', array('bk' => $cate['id'])); ?>">
                                        <div class="card-header">
                                            <?php echo $cate['cname'] ?>
                                        </div>
                                        <div class="card-body">
                                                <p>
                                                    <span>主题：<?php echo $x ?></span>
                                                </p>
                                                <p>
                                                    <span>帖子：63</span>
                                                </p>
                                                <p>
                                                    <small>最后评论时间：<?php echo date('Y-m-d H:i:s', $z) ?></small>
                                                </p>
                                        </div>
                                    </a>

                                    <!-- <a class="plate-link" href="<?php echo url('tiezi/index', array('bk' => $cate['id'])); ?>">
                                        <p class="plate-body-title">
                                            <?php echo $cate['cname'] ?>
                                        </p>
                                        <p>
                                            <span>主题：<?php echo $x ?></span>
                                            <span>帖子：63</span>
                                        </p>
                                        <p>
                                            <small>最后评论时间：<?php echo date('Y-m-d H:i:s', $z) ?></small>
                                        </p>
                                    </a> -->
                                </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
        </div>
    </div>
</section>