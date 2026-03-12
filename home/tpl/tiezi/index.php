<?php
$get = $_GET;
?>
<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list me-2"></i>帖子列表</span>
                <a class="btn btn-primary btn-sm" href="fatie.php?bk=<?= h($bk) ?>">
                    <i class="fas fa-edit me-1"></i>发帖
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%"><i class="fas fa-heading me-2"></i>帖子标题</th>
                            <th style="width: 15%"><i class="fas fa-user me-2"></i>作者</th>
                            <th style="width: 10%"><i class="fas fa-comment me-2"></i>回复</th>
                            <th style="width: 10%"><i class="fas fa-eye me-2"></i>查看</th>
                            <th style="width: 15%"><i class="fas fa-clock me-2"></i>最后发表</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($row)) foreach ($row as $post) { ?>
                        <tr>
                            <td>
                                <a href="<?= url('tiezi/detail', array('bk' => $bk, 'zt' => $post['id'])); ?>">
                                    <?= h($post['title']) ?>
                                </a>
                            </td>
                            <td>
                                <i class="fas fa-user-circle text-muted me-1"></i><?= h($post['username']) ?>
                            </td>
                            <td>
                                <span class="badge bg-info"><?= h($post['reply_count']) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= h($post['view_count']) ?></span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i><?= date('Y-m-d H:i', $post['ptime']) ?>
                                </small>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="post-list-controller">
                <nav class="page">
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link" href='/home/index.php?m=tiezi&a=index&page=1&bk=<?= h($get['bk']) ?>'>
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href='/home/index.php?m=tiezi&a=index&page=<?= ($page_num - 1) ?>&bk=<?= h($get['bk']) ?>'>
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <span class="page-text">第 <?= h($page_num) ?> / <?= h($page_count) ?> 页</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href='/home/index.php?m=tiezi&a=index&page=<?= ($page_num + 1) ?>&bk=<?= h($get['bk']) ?>'>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href='/home/index.php?m=tiezi&a=index&page=<?= h($page_count) ?>&bk=<?= h($get['bk']) ?>'>
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                        <li class="page-item ms-3">
                            <span class="page-text">共 <?= h($count) ?> 条</span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
