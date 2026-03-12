<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><i class="fas fa-users me-2"></i>用户列表</h4>
        <a href="#" class="btn btn-primary"><i class="fas fa-plus me-1"></i>添加用户</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th style="width: 40px"><input type="checkbox" id="selectAll"></th>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>权限</th>
                    <th>注册时间</th>
                    <th>注册IP</th>
                    <th>年龄</th>
                    <th>性别</th>
                    <th>QQ</th>
                    <th style="width: 150px">管理</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?php echo $v['id'] ?>"></td>
                    <td><?= $v['id'] ?></td>
                    <td>
                        <span class="fw-bold"><?= htmlspecialchars($v['username']) ?></span>
                    </td>
                    <td>
                        <?php if ($v['admins'] == 1) { ?>
                        <span class="badge bg-danger"><?= $admins[$v['admins']] ?></span>
                        <?php } else { ?>
                        <span class="badge bg-secondary"><?= $admins[$v['admins']] ?></span>
                        <?php } ?>
                    </td>
                    <td><small class="text-muted"><?= date('Y-m-d H:i', $v['rtime']) ?></small></td>
                    <td><code><?= long2ip($v['rip']) ?></code></td>
                    <td><?= $v['age'] ?></td>
                    <td><?= $sex[$v['sex']] ?></td>
                    <td><?= htmlspecialchars($v['qq']) ?></td>
                    <td>
                        <a href="./index.php?m=user&a=mod&id=<?= $v['id'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=user&a=del&id=<?= $v['id'] ?>&zd=id&table=user" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定删除？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
