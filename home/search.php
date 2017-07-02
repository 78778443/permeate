<?php
session_start();
header("content-type:text/html;charset=utf-8");
include "public/header.php";
include "../conf/dbconfig.php";
include "../core/mysql_func.php";

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
$sql = "select count(*) as c from " . DB_PRE . "post " . $where;
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
$sql = "select * from " . DB_PRE . "post" . $where . $limit;
$row = mysql_func($sql);
?>
    <div class="container ">
        <div class="main">以下是为您找到的符合 "<?php echo $keywords ?>" 的所有内容！</div>
        <?php
        foreach ($row as $post) {

            //搜索关键字高亮设置
            $pattern = "/$keywords/";

            $title = preg_replace($pattern, "<em style='color:red;'>" . $keywords . "</em>", $post['title']);
            $content = preg_replace($pattern, "<em style='color:red;'>" . $keywords . "</em>", $post['content']);
            ?>
            <div>
                <h3>
                    <a href="post.php?bk=<?php echo $post['cid'] ?>&zt=<?php echo $post['id'] ?>"><?php echo $title ?></em></a>
                </h3>
                <p><em><?php echo $title ?></em><br/></p>
                <p>发表于：<?php echo date("Y-m-d H:i:s", $post['ptime']) ?></p>
            </div>
            <?php
        }
        ?>
    </div>
<?php
echo "
	<ul class='pager'>
		<li><a href='?page=1" . $link . "'>首页</a></li>
		<li><a href='?page=" . ($page_num - 1) . $link . "'>上一页</a></li>
		<li><li><a href='?page=" . ($page_num + 1) . $link . "'>下一页</a></li>
		<li><a href='?page=" . $page_count . $link . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>";
?>
<?php
include "public/footer.php";
?>