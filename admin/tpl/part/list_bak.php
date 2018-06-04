<link rel="stylesheet" type="text/css" href="../public/bootstrap3/css/bootstrap.css"/>
<div class="container">
    <form>
        搜索ID：<input type='text' name='keywords' class='input-medium search-query'/>&nbsp;&nbsp;&nbsp;
        <input type='submit' value='搜索' class='btn'/>
    </form>

    <form action="del.php" method="post">
        <input type="hidden" name="zd" value="id"/>
        <input type="hidden" name="table" value="part"/>
        <table width="870px" border="2px" class="table table-bordered">

            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>分区名称</th>
                <th>分区版主</th>
                <th>分区下板块数</th>
                <th>管理</th>
            </tr>
            <?php foreach ($row as $part) {
                $sql = "select count(*) as cou from bbs_cate where pid='" . $part['id'] . "' group by pid";
                //echo $sql;
                $row1 = mysql_func($sql);

                $cou = $row1[0]['cou'];
                if (empty($cou)) {
                    $cou = "0";
                }
                ?>
                <tr align="center">
                    <td><input type="checkbox" name="id" value="<?php echo $part['id'] ?>"/></td>
                    <td><?php echo $part['id'] ?></td>
                    <td><?php echo $part['pname'] ?></td>
                    <td><?php $sql = "select * from bbs_user where id=" . $part['padmins'];
                        $rowpadmins = mysql_func($sql);
                        echo $rowpadmins['0']['username'] ?></td>
                    <td><?php echo $cou ?></td>
                    <td><a href="mod.phpid=<?php echo $part['id'] ?>">编辑</a>
                        <a href="del.phpid=<?php echo $part['id'] ?>&zd=id&table=part">删除</a>
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
	<ul class='pager'>
		<li><a href='?page=1" . $link . "'>首页</a></li>
		<li><a href='?page=" . ($page_num - 1) . $link . "'>上一页</a></li>
		<li><li><a href='?page=" . ($page_num + 1) . $link . "'>下一页</a></li>
		<li><a href='?page=" . $page_count . $link . "'>尾页</a></li>
		<li>总共" . $page_count . "页</li>
		<li>本页" . (($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size) . "条</li>
		<li>总共" . $count . "条</li>
	</ul>
	"
    ?>
</div>