<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-header text-center">
                        <i class="fas fa-key me-2"></i>设置新密码
                    </div>
                    <div class="paper-body py-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                            <p class="text-muted">密码长度8-20位，建议字母、数字的组合来提高帐号安全度</p>
                        </div>

                        <form action="/home/index.php?m=repasswd&a=_newpasswd" method="post">
                            <input type="hidden" name="token" value="<?= isset($token) ? htmlspecialchars($token) : '' ?>">

                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="请输入新密码" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-check-circle text-muted"></i>
                                    </span>
                                    <input type="password" name="passwordAgain" class="form-control border-start-0" placeholder="请再次确认密码" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-save me-2"></i>提交
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
