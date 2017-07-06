 <link rel="stylesheet" type="text/css" href="./resource/styles/index.css"/>
<?php
//组装成一个大数组
$sql = "select * from " . DB_PRE . "part";
$row = mysql_func($sql);
foreach ($row as &$part) {
    $sql = "select * from " . DB_PRE . "cate where pid=" . $part['id'];
    $cate = mysql_func($sql);
    $part['cates'] = $cate;
}
foreach ($row as $part1) {


    $sql = "select * from " . DB_PRE . "user where id=" . $part1['padmins'];
    $rowpart = mysql_func($sql);
    $rowpart = $rowpart[0]['username'];
    ?>
    <section class="section">
        <div class="container">
            <div class="plate">
                <h4 class="plate-title"><?= $part1['pname'] ?></h4>
                <div class="plate-content">
                    <div class="plate-header">
                        <a class="user-link" href="#">
                            <img class="user-img" src="../home/resource/images/user-img.jpg" alt="">
                            <span><small>版主<?= $rowpart ?></small> </span>
                        </a>
                    </div>
                    <div class="plate-body">
                        <div class="row">
                            <?php

                            $i = 0;
                            foreach ($part1['cates'] as $cate) {
                                //查询主题数量
                                $sql = "select count(*) as cou from " . DB_PRE . "post where cid=" . $cate['id'];

                                $row = mysql_func($sql);
                                $x = 0;
                                $x = $x + ($row[0]['cou']) ?>
                                <?php //查询最后发表
                                $sql = "select ptime from " . DB_PRE . "post";
                                $row = mysql_func($sql);
                                $z = 0;
                                if ($row[0]['ptime'] != false) {
                                    $z = $z + $row[0]['ptime'];
                                }
                                ?>
                                <div class="col-lg-3 plate-item">
                                        <a class="plate-body-title"
                                           href="<?php echo url('tiezi/index',array('bk'=>$cate['id']));?>">
                                            <?php echo $cate['cname'] ?>
                                        </a>
                                        <p>
                                            <span>主题：<?php echo $x ?></span>
                                            <span>帖子：12312</span>
                                        </p>
                                        <p>
                                            <small>最后评论时间：<?php echo date('Y-m-d H:i:s', $z) ?></small>
                                        </p>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php
include "public/footer.php";
?>