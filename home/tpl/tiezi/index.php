<?php
$get = $_GET;
$cateRows = mysql_func("SELECT cname FROM bbs_cate WHERE id=" . intval($bk));
$cateName = !empty($cateRows[0]['cname']) ? $cateRows[0]['cname'] : '帖子列表';
$baseUrl = '/home/index.php?m=tiezi&a=index';
$bkParam = h($get['bk']);
$pageCountDisp = max(1, (int)$page_count);
?>
<section class="section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home/index.php"><i class="fas fa-home"></i>首页</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= h($cateName) ?></li>
            </ol>
        </nav>

        <div class="paper">
            <div class="post-list-header">
                <span class="list-icon"><i class="fas fa-list-ul"></i></span>
                <div class="list-title">
                    <h3><?= h($cateName) ?></h3>
                    <span>共 <?= h($count) ?> 篇帖子<?= $pageCountDisp > 1 ? ' · 第 ' . h($page_num) . ' / ' . h($pageCountDisp) . ' 页' : '' ?></span>
                </div>
                <div class="list-actions">
                    <a class="btn btn-primary btn-sm" href="fatie.php?bk=<?= h($bk) ?>">
                        <i class="fas fa-edit"></i>发帖
                    </a>
                </div>
            </div>

            <?php if (!empty($row)) { ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50%">帖子标题</th>
                            <th style="width: 16%">作者</th>
                            <th style="width: 10%">回复</th>
                            <th style="width: 10%">查看</th>
                            <th style="width: 14%">最后发表</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($row as $post) { ?>
                        <tr>
                            <td>
                                <a class="post-title-link" href="<?= url('tiezi/detail', array('bk' => $bk, 'zt' => $post['id'])); ?>">
                                    <?= h($post['title']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="table-meta"><i class="fas fa-user-circle"></i><?= h($post['username']) ?></span>
                            </td>
                            <td>
                                <span class="num-pill <?= $post['reply_count'] > 0 ? 'hot' : '' ?>"><?= h($post['reply_count']) ?></span>
                            </td>
                            <td>
                                <span class="num-pill"><?= h($post['view_count']) ?></span>
                            </td>
                            <td>
                                <span class="table-meta">
                                    <i class="far fa-clock"></i><?= date('Y-m-d H:i', $post['ptime']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
            <div class="post-list-empty">
                <i class="fas fa-folder-open"></i>
                <p class="mb-2">这个版块还没有帖子</p>
                <a class="btn btn-primary btn-sm" href="fatie.php?bk=<?= h($bk) ?>"><i class="fas fa-edit"></i>发第一帖</a>
            </div>
            <?php } ?>

            <div class="post-list-controller">
                <span class="page-text">共 <?= h($count) ?> 条 · 每页 15 条</span>
                <?php if ($pageCountDisp > 1) { ?>
                <nav class="page" aria-label="分页">
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=1&bk=<?= $bkParam ?>' aria-label="第一页">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= max(1, $page_num - 1) ?>&bk=<?= $bkParam ?>' aria-label="上一页">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="page-item"><span class="page-text">第 <?= h($page_num) ?> / <?= h($pageCountDisp) ?> 页</span></li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num >= $pageCountDisp ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= min($pageCountDisp, $page_num + 1) ?>&bk=<?= $bkParam ?>' aria-label="下一页">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num >= $pageCountDisp ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= h($pageCountDisp) ?>&bk=<?= $bkParam ?>' aria-label="最后一页">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
