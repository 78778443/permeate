<?php
// 板块图标映射
$icons = [
    'SQL注入' => ['icon' => 'fa-database', 'class' => 'sql'],
    'XSS跨站' => ['icon' => 'fa-code', 'class' => 'xss'],
    '命令执行' => ['icon' => 'fa-terminal', 'class' => 'cmd'],
    '文件上传' => ['icon' => 'fa-cloud-upload-alt', 'class' => 'upload'],
    '密码找回' => ['icon' => 'fa-key', 'class' => 'auth'],
    '越权访问' => ['icon' => 'fa-user-lock', 'class' => 'auth'],
    'SSRF漏洞' => ['icon' => 'fa-network-wired', 'class' => 'ssrf'],
    '验证码绕过' => ['icon' => 'fa-unlock', 'class' => 'csrf'],
];

// 分区图标映射
$partIcons = [
    '常规漏洞' => ['icon' => 'fa-bug', 'class' => 'cmd'],
    '逻辑漏洞' => ['icon' => 'fa-sitemap', 'class' => 'auth'],
];

function getIconConfig($name, $icons) {
    foreach ($icons as $key => $config) {
        if (strpos($name, $key) !== false) {
            return $config;
        }
    }
    return ['icon' => 'fa-shield-alt', 'class' => 'other'];
}
?>
<section class="section">
    <div class="container">
        <?php
        // 一次性获取所有分区
        $sql = "SELECT * FROM bbs_part";
        $parts = mysql_func($sql);

        // 一次性获取所有分类
        $sql = "SELECT * FROM bbs_cate";
        $allCates = mysql_func($sql);

        // 按分区ID分组
        $catesByPart = array();
        foreach ($allCates as $cate) {
            $catesByPart[$cate['pid']][] = $cate;
        }

        // 一次性获取帖子统计
        $sql = "SELECT cid, COUNT(*) as cou, MAX(ptime) as last_ptime FROM bbs_post GROUP BY cid";
        $postStats = mysql_func($sql);
        $postStatsByCid = array();
        foreach ($postStats as $stat) {
            $postStatsByCid[$stat['cid']] = $stat;
        }

        // 一次性获取回复统计
        $sql = "SELECT p.cid, COUNT(r.id) as num FROM bbs_reply r
                LEFT JOIN bbs_post p ON r.pid = p.id
                GROUP BY p.cid";
        $replyStats = mysql_func($sql);
        $replyStatsByCid = array();
        foreach ($replyStats as $stat) {
            $replyStatsByCid[$stat['cid']] = $stat['num'];
        }

        // 一次性获取所有管理员用户
        $adminIds = array_column($parts, 'padmins');
        $adminIds = array_unique($adminIds);
        $sql = "SELECT id, username FROM bbs_user WHERE id IN (" . implode(',', $adminIds) . ")";
        $admins = mysql_func($sql);
        $adminsById = array();
        foreach ($admins as $admin) {
            $adminsById[$admin['id']] = $admin;
        }

        foreach ($parts as $part1) {
            $rowName = isset($adminsById[$part1['padmins']]) ? $adminsById[$part1['padmins']]['username'] : '未知';
            $rowId = $part1['padmins'];
            $partIcon = getIconConfig($part1['pname'], $partIcons);
        ?>
        <div class="plate">
            <div class="plate-header">
                <span class="plate-icon <?= $partIcon['class'] ?>">
                    <i class="fas <?= $partIcon['icon'] ?>"></i>
                </span>
                <span><?= htmlspecialchars($part1['pname']) ?></span>
                <span class="plate-meta">版主：<a href="<?= url('user/info', array('id' => $rowId)) ?>"><?= htmlspecialchars($rowName) ?></a></span>
            </div>
            <div class="plate-body">
                <div class="row g-4">
                    <?php
                    $cates = isset($catesByPart[$part1['id']]) ? $catesByPart[$part1['id']] : array();
                    foreach ($cates as $cate) {
                        $cid = $cate['id'];
                        $x = isset($postStatsByCid[$cid]) ? $postStatsByCid[$cid]['cou'] : 0;
                        $z = isset($postStatsByCid[$cid]) ? $postStatsByCid[$cid]['last_ptime'] : 0;
                        $replyNum = isset($replyStatsByCid[$cid]) ? $replyStatsByCid[$cid] : 0;
                        $iconConfig = getIconConfig($cate['cname'], $icons);
                    ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a class="plate-link" href="<?php echo url('tiezi/index', array('bk' => $cid)); ?>">
                            <div class="card-header">
                                <span class="icon"><i class="fas <?= $iconConfig['icon'] ?>"></i></span>
                                <span><?= htmlspecialchars($cate['cname']) ?></span>
                            </div>
                            <div class="card-body">
                                <div class="stat-item">
                                    <i class="fas fa-file-alt"></i>
                                    <span>帖子：<strong><?= $x ?></strong></span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-comment-dots"></i>
                                    <span>回复：<strong><?= $replyNum ?></strong></span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-clock"></i>
                                    <span><small><?= $z ? date('Y-m-d H:i', $z) : '暂无更新'; ?></small></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>
