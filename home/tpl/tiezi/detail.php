<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-file-alt me-2"></i><?php echo htmlspecialchars($post['title']) ?>
            </div>

            <div class="paper-body p-0">
                <!-- 主帖 -->
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="index.php?m=user&a=info&id=<?php echo $post['id']; ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?=$post['pic'] ?>" alt=""/>
                                    </span>
                                    <p class="fw-bold"><?php echo htmlspecialchars($post['username']) ?></p>
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
                                <?php echo $post['content'] ?>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock me-1"></i>发布于：<?php echo date('Y-m-d H:i:s', $post['rtime']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 回复列表 -->
                <?php foreach ($row as $reply) {?>
                <div class="post-container-item">
                    <div class="row g-0">
                        <div class="col-md-2 post-list-user">
                            <div class="post-list-user-details">
                                <a class="_user-link" href="index.php?m=user&a=info&id=<?php echo $reply['id']; ?>">
                                    <span class="_avatar">
                                        <img class="post-list-user-img" src="<?=$reply['pic'] ?>" alt=""/>
                                    </span>
                                    <p class="fw-bold"><?php echo htmlspecialchars($reply['username']) ?></p>
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
                                <?php echo $reply['content'] ?>
                            </div>
                            <div class="post-container-time">
                                <i class="far fa-clock me-1"></i>回复于：<?php echo date('Y-m-d H:i:s', $reply['ptime']) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>

                <!-- 分页 -->
                <div class="p-3 border-top">
                    <nav class="page">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item"><span class="page-text">第 <?= $page_num ?> / <?= $page_count ?> 页</span></li>
                            <li class="page-item"><span class="page-text">共 <?= $count ?> 条</span></li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=1&bk=<?=$bk?>&zt=<?=$zt?>'>
                                    <i class="fas fa-angle-double-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num - 1)?>&bk=<?=$bk?>&zt=<?=$zt?>'>
                                    <i class="fas fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num + 1)?>&bk=<?=$bk?>&zt=<?=$zt?>'>
                                    <i class="fas fa-angle-right"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href='/home/index.php?m=tiezi&a=detail&page=<?=$page_count?>&bk=<?=$bk?>&zt=<?=$zt?>'>
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
                        <input type="hidden" name="id" value="<?php echo $zt ?>"/>
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
