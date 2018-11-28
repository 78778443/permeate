<?php
include "public/header.php";
include "../core/common.php";

$keywords = $_REQUEST['keywords'];
if (!empty($keywords)) {
    $where = " where title like '%$keywords%' ";
    $link = "&keywords=" . $keywords;
} else {
    $where = "";
    $link = "";
}


//开始分页大小
$page_size = 4;

//获取当前页码
$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

//计算记录总数
$sql = "SELECT count(*) AS c FROM bbs_post " . $where;
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
$limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
$sql = "SELECT * FROM bbs_post" . $where . $limit;
$row = mysql_func($sql);
?>
    <div class="section">

    <div class="container">
    <div class="paper">
        <div class="main">以下是为您找到的符合 "<?php echo $keywords ?>" 的所有内容！</div>
        <ul class="list-unstyled">

            <?php
            foreach ($row as $post) {

                //搜索关键字高亮设置
                $pattern = "/$keywords/";

                $title = preg_replace($pattern, "<em style='color:red;'>" . $keywords . "</em>", $post['title']);
                $content = preg_replace($pattern, "<em style='color:red;'>" . $keywords . "</em>", $post['content']);
                ?>

                <li class="media" style="padding-top: 20px;border-bottom: 1px solid #ddd;">
                    <div class="media-body">
                        <h5 class="mt-0 mb-1">

                            <a href="<?= url('tiezi/detail', array('bk' => $post['cid'], 'zt' => $post['id'])); ?>">
                                <em><?php echo $title ?></em>
                            </a>
                        </h5>
                        <p><em><?php echo $title ?></em><br/></p>
                        <p>发表于：<?php echo date("Y-m-d H:i:s", $post['ptime']) ?></p>
                    </div>
                </li>

                <?php
            }
            ?>
    </div>
<?php
echo "
    </ul>
    
    <ul class='pagination justify-content-center' style='margin-top: 20px;'>
		<li class='page-item'><a class='page-link' href='?page=1" . $link . "'>首页</a></li>
		<li class='page-item'><a class='page-link' href='?page=" . ($page_num - 1) . $link . "'>上一页</a></li>
		<li class='page-item'><li><a class='page-link' href='?page=" . ($page_num + 1) . $link . "'>下一页</a></li>
        <li class='page-item'><a class='page-link' href='?page=" . $page_count . $link . "'>尾页</a></li>
        <li class='page-item'><span class='page-text'>总共" . $page_count . "页</span></li>
        <li class='page-item'><span class='page-text'>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</span></li>
        <li class='page-item'><span class='page-text'>总共" . $count . "条</span></li>
    </ul>
    </div>
    </div>";
?>
<?php
include "public/footer.php";
?>