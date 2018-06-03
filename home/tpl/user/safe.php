<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                设置
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php include __DIR__ . "/left_menu.php"; ?>
                    <div class="col-lg-6 pt-3">
                        <form action="/home/index.php?m=user&a=_dosafe" method="post">
                            <input type="hidden" name="uid" value="<?=$data['user']['uid']?>">
                            <div class="form-group row">
                                <label class="col-3 col-form-label text-right">旧密码</label>
                                <div class="col-9">
                                    <input class="form-control" type="password" name="oldpassword" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label text-right">
                                    <span>新密码</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-control" type="password" name="newpassword" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label text-right">
                                    <span>确认新密码</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-control" type="password" name="newpassword2" value="">
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