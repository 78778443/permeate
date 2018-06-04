<main class="col-sm-12 p-4" role="main">
    <h2>用户列表</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>多选</th>
                <th>ID</th>
                <th>用户名</th>
                <th>权限</th>
                <th>注册时间</th>
                <th>注册IP</th>
                <th>年龄</th>
                <th>性别</th>
                <th>QQ</th>
                <th>管理</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>"/></td>
                    <td><?php echo $v['id'] ?></td>
                    <td><?php echo $v['username'] ?></td>
                    <td><?php echo $admins[$v['admins']] ?></td>
                    <td><?php echo date('Y-m-d H:i:s', $v['rtime']) ?></td>
                    <td><?php echo long2ip($v['rip']) ?></td>
                    <td><?php echo $v['age'] ?></td>
                    <td><?php echo $sex[$v['sex']] ?></td>
                    <td><?php echo $v['qq'] ?></td>
                    <td><a href="./index.php?m=user&a=mod&id=<?php echo $v['id'] ?>">编辑</a> <a
                                href="./index.php?m=user&a=del&id=<?php echo $v['id'] ?>&zd=id&table=user">删除</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div class="text-right">
            <a href="#" class="btn btn-info">添加</a>
        </div>
    </div>
</main>