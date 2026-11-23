<?php
require_once "public/header.php";

// SQL注入漏洞点：$keywords 直接拼接到SQL语句中
// 漏洞利用：?keywords=test' union select 1,2,3,4,5,6,7,8,9,10--
$keywords = isset($_REQUEST['keywords']) ? $_REQUEST['keywords'] : '';
if (!empty($keywords)) {
    // 漏洞代码：直接拼接用户输入到SQL
    $where = " where title like '%$keywords%' ";
    $link = "&keywords=" . urlencode($keywords);
} else {
    $where = "";
    $link = "";
}

//开始分页大小
$page_size = 4;

//获取当前页码
$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

//计算记录总数
$sql = "SELECT count(*) AS c FROM bbs_post " . $where;
$row = mysql_func($sql);
$count = isset($row[0]['c']) ? $row[0]['c'] : 0;

//计算记录总页数
$page_count = $count > 0 ? ceil($count / $page_size) : 1;
//防止越界
if ($page_num >= $page_count) {
    $page_num = $page_count;
}
if ($page_num <= 0) {
    $page_num = 1;
}

//准备SQL语句
$limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
$sql = "SELECT * FROM bbs_post" . $where . $limit;
$row = mysql_func($sql);
?>

<div class="section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home/index.php"><i class="fas fa-home"></i>首页</a></li>
                <li class="breadcrumb-item active" aria-current="page">搜索</li>
            </ol>
        </nav>

        <div class="paper">
            <div class="post-list-header">
                <span class="list-icon"><i class="fas fa-search"></i></span>
                <div class="list-title">
                    <h3>搜索结果</h3>
                    <span>共找到 <?= $count ?> 条相关帖子</span>
                </div>
            </div>

            <div class="paper-body">
                <div class="search-summary">
                    <i class="fas fa-search"></i>
                    <span>关键词</span>
                    <strong><?php echo htmlspecialchars($keywords); ?></strong>
                    <span>· 共 <?= $count ?> 条结果</span>
                </div>

                <?php if ($row) { ?>
                <div class="search-results">
                    <?php foreach ($row as $post) {
                        $title = htmlspecialchars($post['title']);
                    ?>
                    <a href="<?= url('tiezi/detail', array('bk' => $post['cid'], 'zt' => $post['id'])); ?>" class="search-result-item">
                        <span class="result-icon"><i class="fas fa-file-alt"></i></span>
                        <span class="result-main">
                            <span class="result-title"><?= $title ?></span>
                        </span>
                        <span class="result-meta">
                            <i class="far fa-clock"></i><?= date("Y-m-d H:i", $post['ptime']) ?>
                        </span>
                    </a>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h5>没有找到相关内容</h5>
                    <p class="mb-0">换一个关键词试试，或者 <a href="/home/index.php">回到靶场首页</a></p>
                </div>
                <?php } ?>

                <?php if ($page_count > 1) { ?>
                <nav aria-label="分页" class="post-list-controller pt-3 mt-2 border-top">
                    <span class="page-text">第 <?= $page_num ?> / <?= $page_count ?> 页</span>
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='?page=1<?= $link ?>'>
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='?page=<?= max(1, $page_num - 1) ?><?= $link ?>'>
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num >= $page_count ? 'disabled' : '' ?>" href='?page=<?= min($page_count, $page_num + 1) ?><?= $link ?>'>
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link <?= $page_num >= $page_count ? 'disabled' : '' ?>" href='?page=<?= $page_count ?><?= $link ?>'>
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php include "public/footer.php"; ?>
