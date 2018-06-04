<?php
		$keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
		if (!empty($keywords)) {
			$where = " where xx=1 id like '%$keywords%' ";
			$link = "&keywords=" . $keywords;
		} else {
			$where = " where xx=1";
			$link = "";
		}

		//开始分页大小
		$page_size = 5;

		//获取当前页码
		$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

		//计算记录总数
		$sql = "select count(*) as c from bbs_reply " . $where;
		$row = mysql_func($sql);
		$count = $row[0]['c'];

		//计算记录总页数
		$page_count = ceil($count / $page_size);

		//防止越界
		if ($page_num <= 0) {
			$page_num = 1;
		}
		if ($page_num >= $page_count) {
			$page_num = $page_count;
		}
//准备SQL语句
$limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;

$sql = "select * from bbs_reply" . $where . $limit;


$row = mysql_func($sql);

/*echo "<pre>";
var_dump($row);
echo "</pre>";
exit;*/
?>
    <div class="container">
    <form>
        搜索ID：<input type='text' name='keywords' class='input-medium search-query'/>&nbsp;&nbsp;&nbsp;
        <input type='submit' value='搜索' class='btn'/>
    </form>

    <form action="./index.php?m=reply&a=del" method="post">
        <input type="hidden" name="zd" value="id"/>
        <input type="hidden" name="table" value="reply"/>
        <table width="870px" border="2px" class="table table-bordered">

            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>回帖内容</th>
                <th>回帖的主题</th>
                <th>回帖人</th>
                <th>回帖时间</th>
                <th>回帖IP</th>
                <th>管理</th>
            <tr>

                <?php

                foreach ($row as $reply){
                ?>
            <tr align="center">
                <td><input type="checkbox" name="id[]" value="<?php echo $reply['id'] ?>"/></td>
                <td><?php echo $reply['id'] ?></td>
                <td><?php echo $reply['content'] ?></td>
                <td><?php
                    $sql = "select title from bbs_post where id=" . $reply['pid'];
                    $row1 = mysql_func($sql);
                    $post = $row1[0];
                    echo $post['title'] ?></td>
                <td><?php
                    $sql = "select username from bbs_user where '" . $reply['pid'] . "'";

                    $row1 = mysql_func($sql);
                    $user = $row1[0];
                    echo $user['username'] ?></td>
                <td><?php echo date('Y-m-d H:i:s', $reply['ptime']); ?></td>
                <td><?php echo long2ip($reply['pip']) ?></td>
                <td><a href="./index.php?m=reply&a=mod&id=<?php echo $reply['id'] ?>">编辑</a>
                    <a href="./index.php?m=reply&a=del&id=<?php echo $reply['id'] ?>&zd=id&table=reply&cz=2">屏蔽</a>
                    <a href="./index.php?m=reply&a=del&id=<?php echo $reply['id'] ?>&zd=id&table=reply">删除</a>
                </td>
            </tr>
            <?php
            }
            ?>


        </table>
        <input type='submit' value='批量删除' class="btn btn-info navbar-btn"/>
    </form>
<?php
echo "
<nav >
	<ul class='pagination'>
		<li><a href='?page=1" . $link . "'>首页</a></li>
		<li><a href='?page=" . ($page_num - 1) . $link . "'>上一页</a></li>
		<li><li><a href='?page=" . ($page_num + 1) . $link . "'>下一页</a></li>
		<li><a href='?page=" . $page_count . $link . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>
	</nav>
	";
?>