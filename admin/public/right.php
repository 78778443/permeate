<?php
$userCount = mysql_func("SELECT COUNT(*) AS c FROM bbs_user");
$partCount = mysql_func("SELECT COUNT(*) AS c FROM bbs_part");
$cateCount = mysql_func("SELECT COUNT(*) AS c FROM bbs_cate");
$postCount = mysql_func("SELECT COUNT(*) AS c FROM bbs_post");
$replyCount = mysql_func("SELECT COUNT(*) AS c FROM bbs_reply");

$userCount = isset($userCount[0]['c']) ? (int)$userCount[0]['c'] : 0;
$partCount = isset($partCount[0]['c']) ? (int)$partCount[0]['c'] : 0;
$cateCount = isset($cateCount[0]['c']) ? (int)$cateCount[0]['c'] : 0;
$postCount = isset($postCount[0]['c']) ? (int)$postCount[0]['c'] : 0;
$replyCount = isset($replyCount[0]['c']) ? (int)$replyCount[0]['c'] : 0;

$recentPosts = mysql_func("SELECT p.id, p.cid, p.title, p.ptime, p.view_count, u.username
    FROM bbs_post p LEFT JOIN bbs_user u ON u.id = p.uid
    ORDER BY p.ptime DESC LIMIT 8");
$recentPosts = !empty($recentPosts) ? $recentPosts : [];

$admin = getAdminUser();
$adminName = isset($admin['username']) ? $admin['username'] : 'admin';
?>

<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon icon-users"><i class="fas fa-users"></i></span>
                <div>
                    <div class="stat-value"><?= $userCount ?></div>
                    <div class="stat-label">注册用户</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon icon-posts"><i class="fas fa-file-alt"></i></span>
                <div>
                    <div class="stat-value"><?= $postCount ?></div>
                    <div class="stat-label">帖子总数</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon icon-replies"><i class="fas fa-comments"></i></span>
                <div>
                    <div class="stat-value"><?= $replyCount ?></div>
                    <div class="stat-label">回复总数</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon icon-zones"><i class="fas fa-layer-group"></i></span>
                <div>
                    <div class="stat-value"><?= $partCount ?> / <?= $cateCount ?></div>
                    <div class="stat-label">分区 / 版块</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header">
                <span><i class="fas fa-clock me-2 text-primary"></i>最新帖子</span>
                <a href="?m=post&a=lists" class="btn btn-outline-primary btn-sm">全部帖子</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>标题</th>
                            <th style="width: 120px">作者</th>
                            <th style="width: 110px">查看</th>
                            <th style="width: 160px">发布时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentPosts)) { foreach ($recentPosts as $post) { ?>
                        <tr>
                            <td>
                                <a class="post-title-link-admin" href="/home/index.php?m=tiezi&a=detail&bk=<?= (int)$post['cid'] ?>&zt=<?= (int)$post['id'] ?>" target="_blank">
                                    <?= htmlspecialchars($post['title']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($post['username']) ?></td>
                            <td><?= (int)$post['view_count'] ?></td>
                            <td class="text-muted"><?= date('Y-m-d H:i', $post['ptime']) ?></td>
                        </tr>
                        <?php } } else { ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">暂无帖子</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-bolt me-2 text-primary"></i>快捷操作</span>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a class="quick-link" href="?m=user&a=lists"><i class="fas fa-users"></i>用户管理</a>
                    <a class="quick-link" href="?m=post&a=lists"><i class="fas fa-file-alt"></i>帖子管理</a>
                    <a class="quick-link" href="?m=reply&a=lists"><i class="fas fa-comments"></i>回帖管理</a>
                    <a class="quick-link" href="?m=manage&a=lists"><i class="fas fa-cog"></i>网站设置</a>
                    <a class="quick-link" href="?m=backup&a=index"><i class="fas fa-database"></i>数据库备份</a>
                    <a class="quick-link" href="/" target="_blank"><i class="fas fa-external-link-alt"></i>访问前台</a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <span><i class="fas fa-server me-2 text-primary"></i>系统信息</span>
            </div>
            <div class="card-body">
                <dl class="system-info mb-0">
                    <dt>当前管理员</dt><dd><?= htmlspecialchars($adminName) ?></dd>
                    <dt>PHP 版本</dt><dd><?= PHP_VERSION ?></dd>
                    <dt>数据库</dt><dd>SQLite (PDO)</dd>
                    <dt>服务器时间</dt><dd><?= date('Y-m-d H:i') ?></dd>
                </dl>
            </div>
        </div>

        <div class="alert alert-warning mb-0">
            <h6><i class="fas fa-exclamation-triangle me-1"></i>安全提示</h6>
            本系统内置命令执行、SQL 注入等漏洞，仅用于教学练习，请部署在隔离的内网环境中。
        </div>
    </div>
</div>
