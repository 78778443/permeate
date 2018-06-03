<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <?php echo $post['title'] ?>
            </div>
            <div class="paper-body" style="padding: 0">
                <div class="post-container">
                    <div class="post-container-item">
                        <div class="row mx-0">
                            <!--用户组-->
                            <div class="post-list-user col-2">
                                <div class="post-list-user-details">
                                    <a class="_user-link" href="index.php?m=user&a=info&id=<?php echo $post['id']; ?>">
                                        <span class="_avatar">
                                            <img class="post-list-user-img" src="<?=$post['pic'] ?>" alt=""/>
                                        </span>
                                        <p><?php echo $post['username'] ?></p>
                                    </a>
                                    <p><a class="btn btn-primary btn-xs"
                                          href=<?=url('user/follow', array('uid' => $post['uid']))?>>关注他</a></p>
                                </div>
                            </div>
                            <!--详情-->
                            <div class="col-10 post-list-details d-flex justify-content-between flex-column">
                                <!--内容区-->
                                <div class="post-container-details">
                                    <?php echo $post['content'] ?>
                                </div>

                                <div class="post-container-time">
                                    发布时间：
                                    <time datetime="<?php echo date('Y/m/d', $post['rtime']) ?>"><?php echo date('Y-m-d H:i:s', $post['rtime']) ?></time>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($row as $reply) {?>
                        <div class="post-container-item">
                            <div class="row mx-0">
                                <!--用户组-->
                                <div class="post-list-user col-2">
                                    <div class="post-list-user-details">
                                        <a class="_user-link" href="index.php?m=user&a=info&id=<?php echo $reply['id']; ?>">
                                            <span class="_avatar">
                                                <img class="post-list-user-img" src="<?=$reply['pic'] ?>" alt=""/>
                                            </span>
                                            <p><?php echo $reply['username'] ?></p>
                                        </a>
                                        <p><a class="btn btn-primary btn-xs"
                                              href=<?=url('user/follow', array('uid' => $reply['uid']))?>>关注他</a></p>
                                    </div>
                                </div>
                                <!--详情-->
                                <div class="col-10 post-list-details d-flex justify-content-between flex-column">
                                    <!--内容区-->
                                    <div class="post-container-details">
                                        <?php echo $reply['content'] ?>
                                    </div>

                                    <div class="post-container-time">
                                        发布时间：
                                        <time datetime="<?php echo date('Y/m/d', $reply['rtime']) ?>"><?php echo date('Y-m-d H:i:s', $reply['rtime']) ?></time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
                <!--控制器-->
                <div class="post-controller">
                    <nav class="page" style="margin-top: 20px;">
                        <ul class='pagination justify-content-end'>
                            <li class="page-item"><span class='page-text'>总共<?=$page_count?>页</span></li>
                            <li class="page-item">
                                <span class='page-text'>
                                    本页<?=(($page_num == $page_count && $count % $page_size != 0) ? ($count % $page_size) : $page_size)?>
                                    条
                                </span>
                            </li>
                            <li class="page-item"><span class='page-text'>总共<?=$count?>条</span></li>
                            <li class="page-item">
                                <a class="page-link"
                                   href='/home/index.php?m=tiezi&a=detail&page=1&bk=<?=$bk?>&zt=<?=$zt?>'>首页</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num - 1)?>&bk=<?=$bk?>&zt=<?=$zt?>'>上一页</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href='/home/index.php?m=tiezi&a=detail&page=<?=($page_num + 1)?>&bk=<?=$bk?>&zt=<?=$zt?>'>下一页</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link"
                                   href='/home/index.php?m=tiezi&a=detail&page=<?=$page_count?>&bk=<?=$bk?>&zt=<?=$zt?>'>尾页</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!--发帖-->
                <div class="post-release">
                    <div class="post-release-container">
                        <h4>发帖回复</h4>
                        <form method="post" action="<?=url('tiezi/reply', array('bk' => $bk, 'zt' => $zt))?>">
                            <input type="hidden" name="id" value="<?php echo $zt ?>"/>
                            <div class="form-group row">
                                <div class="col-12">
                                    <textarea id="editor" style="width:100%;height:500px;"></textarea>
                                </div>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">确认修改</button>
                            </div>
                        </form>
                    </div>
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