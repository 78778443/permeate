<?php
$currentUser = getCurrentUser();
$cateRows = mysql_func("SELECT cname FROM bbs_cate WHERE id=" . intval($post['cid']));
$cateName = !empty($cateRows[0]['cname']) ? $cateRows[0]['cname'] : '帖子';
$baseUrl = '/home/index.php?m=tiezi&a=detail';
$bkParam = h($bk);
$ztParam = h($zt);
$replyPageCount = max(1, (int)$page_count);
?>
<section class="section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home/index.php"><i class="fas fa-home"></i>首页</a></li>
                <li class="breadcrumb-item"><a href="<?= url('tiezi/index', array('bk' => $bk)) ?>"><?= h($cateName) ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= h($post['title']) ?></li>
            </ol>
        </nav>

        <div class="paper">
            <div class="post-detail-header">
                <div class="post-heading">
                    <h1><?= h($post['title']) ?></h1>
                    <div class="post-sub">
                        <span><i class="fas fa-user"></i><?= h($post['username']) ?></span>
                        <span><i class="far fa-clock"></i><?= date('Y-m-d H:i', $post['ptime']) ?></span>
                        <span><i class="fas fa-eye"></i><?= h($post['view_count']) ?> 次浏览</span>
                    </div>
                </div>
                <div class="post-count">
                    <span class="num-pill"><?= h($post['reply_count']) ?> 条回复</span>
                </div>
            </div>

            <div class="paper-body p-0">
                <!-- 主帖 -->
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="<?= url('user/info', array('id' => $post['uid'])) ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?= getAvatar($post['pic'], $post['username']) ?>" alt="<?= h($post['username']) ?> 的头像"/>
                                    </span>
                                    <p class="user-name"><?= h($post['username']) ?></p>
                                </a>
                                <span class="user-role">楼主</span>
                                <div>
                                    <a class="follow-btn" href="<?= url('user/follow', array('uid' => $post['uid'])) ?>">
                                        <i class="fas fa-user-plus"></i>关注
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="post-container-details">
                                <div class="rich-text"><?= $post['content'] ?></div>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock"></i>
                                <span>发布于 <?= date('Y-m-d H:i', $post['ptime']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 回复列表 -->
                <?php if (!empty($row)) { ?>
                <div class="reply-divider">全部回复 · <?= h($count) ?></div>
                <?php foreach ($row as $reply) { ?>
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="<?= url('user/info', array('id' => $reply['uid'])) ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?= getAvatar($reply['pic'], $reply['username']) ?>" alt="<?= h($reply['username']) ?> 的头像"/>
                                    </span>
                                    <p class="user-name"><?= h($reply['username']) ?></p>
                                </a>
                                <span class="user-role">回复</span>
                                <div>
                                    <a class="follow-btn" href="<?= url('user/follow', array('uid' => $reply['uid'])) ?>">
                                        <i class="fas fa-user-plus"></i>关注
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="post-container-details">
                                <div class="rich-text"><?= $reply['content'] ?></div>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock"></i>
                                <span>回复于 <?= date('Y-m-d H:i', $reply['ptime']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } else { ?>
                <div class="reply-divider">全部回复 · 0</div>
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h5>还没有回复</h5>
                    <p class="mb-0">来写下第一条讨论吧</p>
                </div>
                <?php } ?>

                <!-- 分页 -->
                <?php if ($replyPageCount > 1) { ?>
                <div class="post-list-controller p-3 border-top flex-wrap">
                    <span class="page-text">共 <?= h($count) ?> 条回复</span>
                    <nav class="page" aria-label="回复分页">
                        <ul class="pagination mb-0">
                            <li class="page-item">
                                <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=1&bk=<?= $bkParam ?>&zt=<?= $ztParam ?>' aria-label="第一页">
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link <?= $page_num <= 1 ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= max(1, $page_num - 1) ?>&bk=<?= $bkParam ?>&zt=<?= $ztParam ?>' aria-label="上一页">
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><span class="page-text">第 <?= h($page_num) ?> / <?= h($replyPageCount) ?> 页</span></li>
                            <li class="page-item">
                                <a class="page-link <?= $page_num >= $replyPageCount ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= min($replyPageCount, $page_num + 1) ?>&bk=<?= $bkParam ?>&zt=<?= $ztParam ?>' aria-label="下一页">
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link <?= $page_num >= $replyPageCount ? 'disabled' : '' ?>" href='<?= $baseUrl ?>&page=<?= h($replyPageCount) ?>&bk=<?= $bkParam ?>&zt=<?= $ztParam ?>' aria-label="最后一页">
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php } ?>

                <!-- 回复表单 -->
                <div class="post-release-container">
                    <h4><i class="fas fa-reply"></i>发表回复</h4>
                    <?php if (!empty($currentUser)) { ?>
                    <form method="post" action="<?= url('tiezi/reply', array('bk' => $bk, 'zt' => $zt)) ?>">
                        <input type="hidden" name="id" value="<?= h($zt) ?>"/>
                        <div class="editor-wrap">
                            <textarea id="editor" style="width:100%;height:280px;"></textarea>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>发表回复
                            </button>
                        </div>
                    </form>
                    <?php } else { ?>
                    <div class="guest-reply">
                        <i class="fas fa-lock"></i>
                        <span>登录后即可参与讨论，回复内容会显示在这里。</span>
                        <a class="btn btn-primary btn-sm" href="<?= url('user/login') ?>">去登录</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (!empty($currentUser)) { ?>
<script src="resource/dist/js/ueditor/ueditor.config.js"></script>
<script src="resource/dist/js/ueditor/ueditor.all.min.js"></script>
<script src="resource/dist/js/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    var ue = UE.getEditor('editor');
</script>
<?php } ?>
