<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-lock me-2"></i>密码安全
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php"; ?>
                    <div class="col-lg-8 pt-3">
                        <form action="/home/index.php?m=user&a=_dosafe" method="post">
                            <input type="hidden" name="uid" value="<?=$data['user']['uid']?>">

                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-key text-muted me-1"></i>旧密码
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="oldpassword" placeholder="请输入当前密码" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-lock text-muted me-1"></i>新密码
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="newpassword" placeholder="请输入新密码" required>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-check-circle text-muted me-1"></i>确认新密码
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="password" name="newpassword2" placeholder="请再次输入新密码" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save me-1"></i>确认修改
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
