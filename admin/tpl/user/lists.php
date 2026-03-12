<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i>用户列表</span>
        <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>添加用户</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
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
                    <th style="width: 120px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)) foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?= h($v['id']) ?>"></td>
                    <td><?= h($v['id']) ?></td>
                    <td><span class="fw-bold"><?= h($v['username']) ?></span></td>
                    <td>
                        <?php if ($v['admins'] == 1) { ?>
                        <span class="badge bg-danger"><?= h($admins[$v['admins']]) ?></span>
                        <?php } else { ?>
                        <span class="badge bg-secondary"><?= h($admins[$v['admins']]) ?></span>
                        <?php } ?>
                    </td>
                    <td><small class="text-muted"><?= date('Y-m-d H:i', $v['rtime']) ?></small></td>
                    <td><code><?= long2ip($v['rip']) ?></code></td>
                    <td><?= h($v['age']) ?></td>
                    <td><?= h($sex[$v['sex']]) ?></td>
                    <td><?= h($v['qq']) ?></td>
                    <td>
                        <a href="./index.php?m=user&a=mod&id=<?= h($v['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=user&a=del&id=<?= h($v['id']) ?>&zd=id&table=user" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
