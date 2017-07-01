<?php
$id = $_GET['bk'];
$bk = &$id;
if (empty($id)) {
    exit ("参数错误！");
}
?>
<?php
session_start();
include "public/header.php";
include "../conf/dbconfig.php";
include "../includes/mysql_func.php";


//开始分页大小
$page_size = 5;

//获取当前页码
$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

//计算记录总数
$sql = "select count(*) as c from " . DB_PRE . "post where cid='$bk'";
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
$sql = "select p.*,u.username from " . DB_PRE . "post as p," . DB_PRE . "user as u where  p.cid=" . $id . " and u.id=p.uid and p.cid='$bk'" . $limit;
$row = mysql_func($sql);
?>

    <link rel="stylesheet" type="text/css" href="./resource/styles/list.css"/>
    <!--主体start-->
    <div id="main">
        <div class=""><a class="btn btn-success" href="fatie.php?bk=<?php echo $bk ?>">发帖</a>
        </div>
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
                        <td class="tab_bt"><a href="post.php?bk=<?php echo $bk;
                            echo '&zt=' . $post['id'] ?>"><?php echo $post['title'] ?></a></td>
                        <td class="tab_zz"><a href><?php echo $post['username'] ?></a></td>
                        <td class="tab_hf"><a href>10/20</a></td>
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
        <?php
        echo "
<div class='main'>
	<ul class='pagination'>
		<li><a href='?page=1&bk=" . $id . "'>首页</a></li>
		<li><a href='?page=" . ($page_num - 1) . "&bk=" . $id . "'>上一页</a></li>
		<li><li><a href='?page=" . ($page_num + 1) . "&bk=" . $id . "'>下一页</a></li>
		<li><a href='?page=" . $page_count . "&bk=" . $id . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>
	</div>
	";
        ?>
    </div>


    <!--主体end-->
<?php
include "public/footer.php";
?>