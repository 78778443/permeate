<main class="col-sm-9 p-4" role="main">
    <h2>分区列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>分区名称</th>
                <th>分区版主</th>
                <th>分区下板块数</th>
                <th>管理</th>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id" value="<?php echo $v['id'] ?>"/></td>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['pname'] ?></td>
                    <td><?php echo $v['username'] ?></td>
                    <td><?php echo $v['cou'] ?></td>
                    <td><a href="mod.phpid=<?php echo $v['id'] ?>">编辑</a>
                        <a href="del.phpid=<?php echo $v['id'] ?>&zd=id&table=part">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>