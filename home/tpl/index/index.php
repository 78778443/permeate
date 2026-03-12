<link rel="stylesheet" type="text/css" href="./resource/styles/index.css"/>
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
        ?>
        <div class="plate">
            <div class="plate-header">
                <i class="fas fa-folder me-2"></i><?= htmlspecialchars($part1['pname']) ?>
                <span class="ms-3">|</span>
                <span class="ms-3">版主：<a href="<?= url('user/info', array('id' => $rowId)) ?>"><?= htmlspecialchars($rowName) ?></a></span>
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
                    ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a class="plate-link" href="<?php echo url('tiezi/index', array('bk' => $cid)); ?>">
                            <div class="card-header">
                                <i class="fas fa-comments me-2"></i><?= htmlspecialchars($cate['cname']) ?>
                            </div>
                            <div class="card-body">
                                <p><i class="fas fa-file-alt me-2 text-muted"></i>帖子：<?php echo $x ?></p>
                                <p><i class="fas fa-comment-dots me-2 text-muted"></i>回复：<?=$replyNum ?></p>
                                <p><i class="fas fa-clock me-2 text-muted"></i><small><?php echo $z ? date('Y-m-d H:i', $z) : '暂无更新'; ?></small></p>
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
