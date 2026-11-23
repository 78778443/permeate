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

// 分区副标题
$partDesc = [
    '常规漏洞' => '注入、跨站、执行与上传，打牢基础',
    '逻辑漏洞' => '认证、越权与请求伪造，练业务思维',
];

// 漏洞危险等级
$severity = [
    '命令执行' => ['label' => '严重', 'class' => 'sev-critical'],
    'SQL注入' => ['label' => '高危', 'class' => 'sev-high'],
    'XSS跨站' => ['label' => '高危', 'class' => 'sev-high'],
    '文件上传' => ['label' => '高危', 'class' => 'sev-high'],
    'SSRF漏洞' => ['label' => '高危', 'class' => 'sev-high'],
    '越权访问' => ['label' => '中危', 'class' => 'sev-medium'],
    '密码找回' => ['label' => '中危', 'class' => 'sev-medium'],
    '验证码绕过' => ['label' => '低危', 'class' => 'sev-low'],
];

function getIconConfig($name, $icons) {
    foreach ($icons as $key => $config) {
        if (strpos($name, $key) !== false) {
            return $config;
        }
    }
    return ['icon' => 'fa-shield-alt', 'class' => 'other'];
}

function getSeverity($name, $severity) {
    foreach ($severity as $key => $config) {
        if (strpos($name, $key) !== false) {
            return $config;
        }
    }
    return ['label' => '中危', 'class' => 'sev-medium'];
}
?>
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

// 首屏统计
$totalCates = count($allCates);
$totalPosts = 0;
foreach ($postStats as $stat) {
    $totalPosts += $stat['cou'];
}
$totalReplies = 0;
foreach ($replyStats as $stat) {
    $totalReplies += $stat['num'];
}
?>

<!-- 首屏：靶场控制台 -->
<section class="range-hero">
    <div class="container">
        <div class="range-hero-inner">
            <div class="range-hero-copy">
                <span class="range-kicker"><i class="fas fa-shield-alt"></i>Web 安全实战靶场</span>
                <h1>把漏洞亲手复现一遍，<br><span class="u">比看十篇教程</span>更管用。</h1>
                <p>内置 SQL 注入、XSS、命令执行、SSRF 等 <?= $totalCates ?> 类常见漏洞的<br class="hero-br">PHP 论坛靶场，配套教程与完整后台，安装后即可开始练习。</p>

                <div class="range-actions">
                    <a class="btn btn-primary btn-lg" href="#range-zones">
                        <i class="fas fa-crosshairs"></i>进入靶场
                    </a>
                    <a class="btn btn-ghost btn-lg" href="/admin/public/login.php">
                        <i class="fas fa-terminal"></i>进入后台
                    </a>
                </div>

                <div class="range-stats">
                    <div class="range-stat">
                        <strong><?= $totalCates ?></strong>
                        <span>漏洞类型</span>
                    </div>
                    <div class="range-stat">
                        <strong><?= $totalPosts ?></strong>
                        <span>实战帖子</span>
                    </div>
                    <div class="range-stat">
                        <strong><?= $totalReplies ?></strong>
                        <span>讨论回复</span>
                    </div>
                </div>
            </div>

            <div class="range-console" role="navigation" aria-label="漏洞类型">
                <div class="console-bar">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <code>permeate@range:~</code>
                </div>
                <div class="console-body">
                    <div class="console-command">
                        <span class="prompt">$</span>
                        <span class="cmd">./permeate --list vuln</span>
                        <span class="cursor"></span>
                    </div>
                    <div class="console-list">
                        <?php foreach ($allCates as $i => $cate) {
                            $sev = getSeverity($cate['cname'], $severity);
                        ?>
                        <a class="console-row" href="<?= url('tiezi/index', array('bk' => $cate['id'])); ?>">
                            <span class="idx"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                            <span class="vuln-dot"></span>
                            <span class="name"><?= htmlspecialchars($cate['cname']) ?></span>
                            <span class="sev <?= $sev['class'] ?>"><?= $sev['label'] ?></span>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="console-foot">
                        <span class="live"></span>
                        <span><?= $totalCates ?> 个靶场已就绪，选择一个开始练习</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 靶场分区 -->
<section class="section range-main" id="range-zones">
    <div class="container">
        <div class="section-heading">
            <h2>靶场分区</h2>
            <p>按漏洞类型进入对应版块，每个版块都包含原理教程与练习帖。</p>
        </div>

        <?php
        foreach ($parts as $part1) {
            $rowName = isset($adminsById[$part1['padmins']]) ? $adminsById[$part1['padmins']]['username'] : '未知';
            $rowId = $part1['padmins'];
            $partIcon = getIconConfig($part1['pname'], $partIcons);
            $desc = isset($partDesc[$part1['pname']]) ? $partDesc[$part1['pname']] : '';
        ?>
        <div class="plate">
            <div class="plate-header">
                <span class="plate-icon <?= $partIcon['class'] ?>">
                    <i class="fas <?= $partIcon['icon'] ?>"></i>
                </span>
                <div class="plate-title">
                    <h3><?= htmlspecialchars($part1['pname']) ?></h3>
                    <span><?= htmlspecialchars($desc) ?></span>
                </div>
                <span class="plate-meta">版主：<a href="<?= url('user/info', array('id' => $rowId)) ?>"><?= htmlspecialchars($rowName) ?></a></span>
            </div>
            <div class="plate-body">
                <div class="row g-3">
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
                        <a class="zone-card" href="<?php echo url('tiezi/index', array('bk' => $cid)); ?>">
                            <div class="zone-card-top">
                                <span class="zone-icon <?= $iconConfig['class'] ?>"><i class="fas <?= $iconConfig['icon'] ?>"></i></span>
                                <span class="zone-name"><?= htmlspecialchars($cate['cname']) ?></span>
                            </div>
                            <div class="zone-meta">
                                <span><span class="num"><?= $x ?></span> 帖子</span>
                                <span><span class="num"><?= $replyNum ?></span> 回复</span>
                                <span class="zone-time">
                                    <i class="far fa-clock"></i><?= $z ? date('m-d', $z) : '暂无更新' ?>
                                </span>
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
