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
        <div class="paper p-4">
            <div class="main mb-4">
                <i class="fas fa-search me-2"></i>
                为您找到符合 "<strong><?php echo htmlspecialchars($keywords); ?></strong>" 的结果共 <?= $count ?> 条
            </div>

            <?php if ($row) { ?>
            <div class="list-group list-group-flush">
                <?php foreach ($row as $post) {
                    $title = htmlspecialchars($post['title']);
                ?>
                <a href="<?= url('tiezi/detail', array('bk' => $post['cid'], 'zt' => $post['id'])); ?>" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">
                            <i class="fas fa-file-alt text-muted me-2"></i><?= $title ?>
                        </h6>
                        <small class="text-muted">
                            <i class="far fa-clock me-1"></i><?= date("Y-m-d H:i", $post['ptime']) ?>
                        </small>
                    </div>
                </a>
                <?php } ?>
            </div>
            <?php } else { ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-search fa-3x mb-3"></i>
                <p>没有找到相关内容</p>
            </div>
            <?php } ?>

            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href='?page=1<?= $link ?>'>
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href='?page=<?= ($page_num - 1) ?><?= $link ?>'>
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <span class="page-text">第 <?= $page_num ?> / <?= $page_count ?> 页</span>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href='?page=<?= ($page_num + 1) ?><?= $link ?>'>
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href='?page=<?= $page_count ?><?= $link ?>'>
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php include "public/footer.php"; ?>
