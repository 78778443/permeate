<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                设置
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php include __DIR__ . "/left_menu.php"; ?>
                    <div class="col-lg-6">
                        <form action="/home/index.php?m=user&a=_dobasic" method="post">
                            <input type="hidden" name="uid" value="<?= $user['id'] ?>">
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>用户名</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" value="<?= $user['username'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>真实姓名</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" name="t_name" value="<?= $user['t_name'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>年龄</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" name="age" value="<?= $user['age'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>性别</span>
                                </label>
                                <div class="col-9">
                                    <select name="sex">
                                        <?php foreach ($sex as $key => $val) {?>
                                           <option <?= ($user['sex'] == $key) ? 'selected' : '' ?> value='<?= $key?>' ><?= $val?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>学历</span>
                                </label>
                                <div class="col-9">
                                    <select name="edu">
                                        <?php foreach ($edu as $key => $val) {?>
                                            <option <?= ($user['edu'] == $key) ? 'selected' : '' ?>  value='<?= $key?>' ><?= $val?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>个性签名</span>
                                </label>
                                <div class="col-9">
                                    <textarea name="signed"><?= $user['signed'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>生日</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="date" name="brithday" value="<?= date('Y-m-d',$user['brithday']) ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>电话</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" name="telphone"
                                           value="<?= $user['telphone'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>QQ</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" name="qq"
                                           value="<?= $user['qq'] ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 form-label text-right">
                                    <span>电子邮箱</span>
                                </label>
                                <div class="col-9">
                                    <input class="form-input" type="text" name="email"
                                           value="<?= $user['email'] ?>">
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
