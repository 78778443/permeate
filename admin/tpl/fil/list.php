<main class="col-sm-12 p-4" role="main">
    <h2>生效列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>关键词</th>
                <th>管理</th>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>" /></td>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['hinge'] ?></td>
                    <td><a href="./index.php?m=fil&a=mod&id=<?php echo $v['id'] ?>">编辑</a>
                        <a href="./index.php?m=fil&a=del&id=<?php echo $v['id'] ?>&zd=id&table=fil">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>