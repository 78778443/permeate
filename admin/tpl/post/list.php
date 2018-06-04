<main class="col-sm-12 p-4" role="main">
    <h2>分区列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>主题</th>
                <th>发帖时间</th>
                <th>发帖人</th>
                <th>管理</th>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>"/></td>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['title'] ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $v['ptime']) ?></td>
                    <td><?php echo $v['username'] ?></td>
                    <td><a href="./index.php?m=post&a=mod&id=<?php echo $v['id'] ?>">编辑</a> <a
                                href="./index.php?m=post&a=del&id=<?php echo $v['id'] ?>&zd=id&table=post&cz=2">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>