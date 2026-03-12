<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-link me-2"></i>友情链接</span>
        <a href="?m=fri&a=add" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>添加链接</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 40px"><input type="checkbox"></th>
                    <th>ID</th>
                    <th>标题</th>
                    <th>描述</th>
                    <th style="width: 120px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)) foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?= h($v['id']) ?>"></td>
                    <td><?= h($v['id']) ?></td>
                    <td><span class="fw-bold"><?= h($v['title']) ?></span></td>
                    <td><small class="text-muted"><?= h($v['desc1']) ?></small></td>
                    <td>
                        <a href="./index.php?m=fri&a=mod&id=<?= h($v['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=fri&a=del&id=<?= h($v['id']) ?>&zd=id&table=fri" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
