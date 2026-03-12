<div class="card">
    <div class="card-header">
        <i class="fas fa-comments me-2"></i>回帖列表
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 40px"><input type="checkbox"></th>
                    <th>ID</th>
                    <th>回帖内容</th>
                    <th>所属主题</th>
                    <th>回帖人</th>
                    <th>回帖时间</th>
                    <th>回帖IP</th>
                    <th style="width: 140px">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($list)) foreach ($list as $v) { ?>
                <tr>
                    <td><input type="checkbox" name="id[]" value="<?= h($v['id']) ?>"></td>
                    <td><?= h($v['id']) ?></td>
                    <td>
                        <span class="text-truncate d-inline-block" style="max-width: 200px;">
                            <?= h($v['content']) ?>
                        </span>
                    </td>
                    <td><a href="/home/index.php?m=tiezi&a=detail&bk=<?= h($v['post']['cid']) ?>&zt=<?= h($v['pid']) ?>" target="_blank"><?= h($v['post']['title']) ?></a></td>
                    <td><?= h($v['username']) ?></td>
                    <td><small class="text-muted"><?= date('Y-m-d H:i', $v['ptime']) ?></small></td>
                    <td><code><?= long2ip($v['pip']) ?></code></td>
                    <td>
                        <a href="./index.php?m=reply&a=mod&id=<?= h($v['id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="./index.php?m=reply&a=del&id=<?= h($v['id']) ?>&zd=id&table=reply&cz=2" class="btn btn-sm btn-outline-warning" title="屏蔽">
                            <i class="fas fa-ban"></i>
                        </a>
                        <a href="./index.php?m=reply&a=del&id=<?= h($v['id']) ?>&zd=id&table=reply" class="btn btn-sm btn-outline-danger" onclick="return confirm('确定要删除吗？')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
