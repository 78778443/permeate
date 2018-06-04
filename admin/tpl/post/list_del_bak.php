<?php


?>
<div class="container">
    <form action="./index.php?m=post&a=del" method="post">
        <input type="hidden" name="zd" value="id"/>
        <input type="hidden" name="table" value="post"/>
        <table width="870px" border="2px" class="table table-bordered">
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>主题</th>
                <th>发帖时间</th>
                <th>发帖人</th>
                <th>管理</th>
            <tr>

                <?php
                foreach ($row as $post){
                ?>
            <tr align="center">
                <td><input type="checkbox" name="id[]" value="<?php echo $post['id'] ?>"/></td>
                <td><?php echo $post['id'] ?></td>
                <td><?php echo $post['title'] ?></td>
                <td><?php echo date('Y-m-d H:i:s', $post['ptime']) ?></td>
                <td><?php echo $post['username'] ?></td>
                <td><a href="./index.php?m=post&a=recover&id=<?php echo $post['id'] ?>&cz=1">还原</a>
                    <a href="./index.php?m=post&a=del&id=<?php echo $post['id'] ?>&zd=id&table=post">删除</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
        <input type='submit' value='批量删除' class="btn btn-info navbar-btn"/>
    </form>
</div>

