<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-user-edit me-2"></i>个人资料
                <span class="badge bg-danger ms-2">越权漏洞</span>
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php"; ?>
                    <div class="col-lg-8 pt-3">
                        <div class="alert alert-warning border-0">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                            <p class="mb-2">此功能存在水平越权漏洞：</p>
                            <ul class="mb-0">
                                <li>可通过修改URL参数uid访问其他用户的资料编辑页面</li>
                                <li>可通过修改表单隐藏字段uid修改其他用户资料</li>
                            </ul>
                            <hr>
                            <p class="mb-0"><strong>利用方式：</strong><code>?m=user&a=basic&uid=1</code> (修改uid为其他用户ID)</p>
                        </div>

                        <form action="/home/index.php?m=user&a=_dobasic" method="post">
                            <input type="hidden" name="uid" value="<?= $user['id'] ?>">

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-user text-muted me-1"></i>用户名
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-id-card text-muted me-1"></i>真实姓名
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="t_name" value="<?= htmlspecialchars($user['t_name']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-birthday-cake text-muted me-1"></i>年龄
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" name="age" value="<?= $user['age'] ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-venus-mars text-muted me-1"></i>性别
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="sex">
                                        <?php foreach ($sex as $key => $val) {?>
                                        <option <?= ($user['sex'] == $key) ? 'selected' : '' ?> value="<?= $key ?>"><?= $val ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-graduation-cap text-muted me-1"></i>学历
                                </label>
                                <div class="col-sm-9">
                                    <select class="form-select" name="edu">
                                        <?php foreach ($edu as $key => $val) {?>
                                        <option <?= ($user['edu'] == $key) ? 'selected' : '' ?> value="<?= $key ?>"><?= $val ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-pen text-muted me-1"></i>个性签名
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="signed" rows="3"><?= htmlspecialchars($user['signed']) ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-calendar text-muted me-1"></i>生日
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="date" name="brithday" value="<?= date('Y-m-d',$user['brithday']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-phone text-muted me-1"></i>电话
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="telphone" value="<?= htmlspecialchars($user['telphone']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fab fa-qq text-muted me-1"></i>QQ
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="qq" value="<?= htmlspecialchars($user['qq']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label text-sm-end">
                                    <i class="fas fa-envelope text-muted me-1"></i>电子邮箱
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save me-1"></i>保存修改
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
