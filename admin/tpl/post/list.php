<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-file-alt me-2"></i>帖子列表</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 40px"><input type="checkbox"></th>
                    <th>ID</th>
                    <th>主题</th>
                    <th>发帖时间</th>
                    <th>发帖人</th>
                    <th style="width: 120px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)) foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?= h($v['id']) ?>"></td>
                    <td><?= h($v['id']) ?></td>
                    <td><span class="fw-bold"><?= h($v['title']) ?></span></td>
                    <td><small class="text-muted"><?= date('Y-m-d H:i', $v['ptime']) ?></small></td>
                    <td><?= h($v['username']) ?></td>
                    <td>
                        <a href="./index.php?m=post&a=mod&id=<?= h($v['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=post&a=del&id=<?= h($v['id']) ?>&zd=id&table=post&cz=2" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
