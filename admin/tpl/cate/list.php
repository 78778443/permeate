<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-th-large me-2"></i>版块列表</span>
        <a href="?m=cate&a=add" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>添加版块</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 40px"><input type="checkbox"></th>
                    <th>ID</th>
                    <th>板块名称</th>
                    <th>所属分区</th>
                    <th>版主</th>
                    <th style="width: 120px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)) foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?= h($v['id']) ?>"></td>
                    <td><?= h($v['id']) ?></td>
                    <td><span class="fw-bold"><?= h($v['cname']) ?></span></td>
                    <td><span class="badge bg-secondary"><?= h($v['pname']) ?></span></td>
                    <td><?= h($v['username']) ?></td>
                    <td>
                        <a href="./index.php?m=cate&a=mod&id=<?= h($v['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=cate&a=del&id=<?= h($v['id']) ?>&zd=id&table=cate" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
