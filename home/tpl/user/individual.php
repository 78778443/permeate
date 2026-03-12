<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-user-circle me-2"></i>个人设置
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php";?>
                    <div class="col-lg-10 pt-3">
                        <div class="upload">
                            <div class="d-flex align-items-start gap-4">
                                <div class="text-center">
                                    <form action="/home/index.php?m=user&a=_upload_user_touxiang" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                                        <div class="upload-img-content mb-3">
                                            <img class="upload-img" src="<?= getAvatar($username['pic'], $username['username']) ?>" alt="头像">
                                        </div>
                                        <label class="upload-btn d-block mb-3" role="button">
                                            <input type="file" name="pic" accept="image/*">
                                            <i class="fas fa-folder-open me-2"></i>选择图片
                                        </label>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i>保存头像
                                        </button>
                                    </form>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-3">当前头像</h5>
                                    <p class="text-muted mb-2">
                                        如果您还没有设置自己的头像，系统会显示为默认头像。
                                        您可以上传自己的个性照片作为个人头像。
                                    </p>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        支持 JPG、PNG、GIF 格式，文件大小不超过 10MB
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
