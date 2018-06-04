<main class="col-sm-9 p-4" role="main">
    <h2>分区列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>回帖内容</th>
                <th>回帖的主题</th>
                <th>回帖人</th>
                <th>回帖时间</th>
                <th>回帖IP</th>
                <th>管理</th>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>" /></td>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['content'] ?></td>
                    <td><?php echo $v['post']['title'] ?></td>
                    <td><?php echo $v['username'] ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['ptime']); ?></td>
                    <td><?php echo long2ip($v['pip']) ?></td>
                    <td><a href="./index.php?m=reply&a=mod&id=<?php echo $v['id'] ?>">编辑</a>
                        <a href="./index.php?m=reply&a=del&id=<?php echo $v['id'] ?>&zd=id&table=reply&cz=1">恢复</a>
                        <a href="./index.php?m=reply&a=del&id=<?php echo $v['id'] ?>&zd=id&table=reply">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</main>