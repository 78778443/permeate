<div class="card">
    <div class="card-header">
        <i class="fas fa-trash me-2"></i>已删除帖子
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
                        <a href="./index.php?m=post&a=recover&id=<?= h($v['id']) ?>&cz=1" class="btn btn-sm btn-outline-success" title="还原">
                            <i class="fas fa-undo"></i>
                        </a>
                        <a href="./index.php?m=post&a=del&id=<?= h($v['id']) ?>&zd=id&table=post" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
