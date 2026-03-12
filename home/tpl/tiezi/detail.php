<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-file-alt me-2"></i><?= h($post['title']) ?>
            </div>

            <div class="paper-body p-0">
                <!-- 主帖 -->
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="index.php?m=user&a=info&id=<?= h($post['id']) ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?= getAvatar($post['pic'], $post['username']) ?>" alt=""/>
                                    </span>
                                    <p class="fw-bold"><?= h($post['username']) ?></p>
                                </a>
                                <p>
                                    <a class="btn btn-outline-primary btn-sm" href="<?=url('user/follow', array('uid' => $post['uid']))?>">
                                        <i class="fas fa-user-plus me-1"></i>关注
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="post-container-details">
                                <?= $post['content'] ?>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock me-1"></i>发布于：<?= date('Y-m-d H:i:s', $post['rtime']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 回复列表 -->
                <?php if (!empty($row)) foreach ($row as $reply) {?>
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="index.php?m=user&a=info&id=<?= h($reply['id']) ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?= getAvatar($reply['pic'], $reply['username']) ?>" alt=""/>
                                    </span>
                                    <p class="fw-bold"><?= h($reply['username']) ?></p>
                                </a>
                                <p>
                                    <a class="btn btn-outline-primary btn-sm" href="<?=url('user/follow', array('uid' => $reply['uid']))?>">
                                        <i class="fas fa-user-plus me-1"></i>关注
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="post-container-details">
                                <?= $reply['content'] ?>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock me-1"></i>回复于：<?= date('Y-m-d H:i:s', $reply['ptime']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

                <!-- 分页 -->
                <div class="p-3 border-top">
                    <nav class="page">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item"><span class="page-text">第 <?= h($page_num) ?> / <?= h($page_count) ?> 页</span></li>
                            <li class="page-item"><span class="page-text">共 <?= h($count) ?> 条</span></li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=1&bk=<?= h($bk) ?>&zt=<?= h($zt) ?>'>
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num - 1)?>&bk=<?= h($bk) ?>&zt=<?= h($zt) ?>'>
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num + 1)?>&bk=<?= h($bk) ?>&zt=<?= h($zt) ?>'>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?= h($page_count) ?>&bk=<?= h($bk) ?>&zt=<?= h($zt) ?>'>
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- 回复表单 -->
                <div class="post-release-container">
                    <h4><i class="fas fa-reply me-2"></i>发表回复</h4>
                    <form method="post" action="<?=url('tiezi/reply', array('bk' => $bk, 'zt' => $zt))?>">
                        <input type="hidden" name="id" value="<?= h($zt) ?>"/>
                        <div class="mb-3">
                            <textarea id="editor" style="width:100%;height:300px;"></textarea>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane me-1"></i>发表回复
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="resource/dist/js/ueditor/ueditor.config.js"></script>
<script src="resource/dist/js/ueditor/ueditor.all.min.js"></script>
<script src="resource/dist/js/ueditor/lang/zh-cn/zh-cn.js"></script>
<script>
    var ue = UE.getEditor('editor');
</script>
