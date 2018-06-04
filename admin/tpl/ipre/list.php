<main class="col-sm-12 p-4" role="main">
    <h2>过滤列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>开始IP</th>
                <th>结束IP</th>
                <th>管理</th>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>"/></td>
                    <td><?php echo $ip['id'] ?></td>
                    <td><?php echo long2ip($ip['ipmin']) ?></td>
                    <td><?php echo long2ip($ip['ipmax']) ?></td>

                    <td><a href="./index.php?m=ipre&a=mod&id=<?php echo $ip['id'] ?>">编辑</a>
                        <a href="./index.php?m=ipre&a=del&id=<?php echo $ip['id'] ?>&zd=id&table=iprefuse">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>