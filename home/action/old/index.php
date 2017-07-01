<?php
include "public/header.php";
?>
<link rel="stylesheet" type="text/css" href="./resource/styles/index.css" />
<?php
//组装成一个大数组
$sql = "select * from ".DB_PRE."part";
$row = mysql_func($sql);
foreach($row as &$part){
    $sql = "select * from ".DB_PRE."cate where pid=".$part['id'];
    $cate = mysql_func($sql);
    $part['cates'] = $cate;
}
foreach($row as $part1){
    ?>
    <!--主体start-->
    <div id="content">
        <div class="content_title">
            <div class="cont_left"><?php echo $part1['pname'] ?></div>
            <div class="cont_right">分区版主:<b><?php $sql = "select * from ".DB_PRE."user where id=".$part1['padmins'];$rowpart = mysql_func($sql);$rowpart = $rowpart[0]['username'];echo $rowpart;?></b></div>
        </div>
        <div class="con_content">
            <table>
                <tr>
                    <?php

                    $i = 0;
                    foreach($part1['cates'] as $cate){
                        ?>
                        <span src></span>
                        <td width="33%"><li class="bk_title"><a href="index.php?m=tiezi&bk=<?php echo $cate['id'] ?>"><?php echo $cate['cname'] ?></a></li>
                            <?php //查询主题数量
                            $sql = "select count(*) as cou from ".DB_PRE."post where cid=".$cate['id'];  $row = mysql_func($sql); $x = 0; $x=$x+($row[0]['cou'])?>
                            <?php //查询最后发表
                            $sql = "select ptime from ".DB_PRE."post"; $row = mysql_func($sql); $z=0; if($row[0]['ptime']!=false){$z = $z+$row[0]['ptime'];}  ?>
                            <li class="bk_tongji">主题:<?php echo $x ?>,帖子244</li>
                            <li class="bk_news">最后发表:<?php echo date('Y-m-d H:i:s',$z) ?></li>
                        </td>
                        <?php
                        $i++;
                        if($i%3==0){
                            echo "</tr>";
                            echo "<tr><td colspan='3'><div class='xhx'></div></td></tr>";
                            echo "<tr>";
                        }
                    }
                    if($i%3!=0){
                        echo "</tr>";
                    }
                    ?>
            </table>
        </div>
    </div>
    <!--主体end-->
    <?php
}
?>
<?php
include "public/footer.php";
?>