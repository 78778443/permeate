<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-header text-center">
                        <i class="fas fa-mobile-alt me-2"></i>验证密保手机
                    </div>
                    <div class="paper-body py-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-sms fa-3x text-primary mb-3"></i>
                            <p class="text-muted">短信验证码已发送至</p>
                            <p class="fw-bold"><?= isset($phone) ? htmlspecialchars($phone) : '176****5914' ?></p>
                        </div>

                        <form action="/home/index.php?m=repasswd&a=_phone" method="post">
                            <div class="mb-4">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-key text-muted"></i>
                                    </span>
                                    <input type="text" name="smsToken" class="form-control border-start-0" placeholder="请输入短信验证码" maxlength="6" required>
                                    <button type="button" class="btn btn-outline-primary" id="resendBtn">
                                        重新发送
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-arrow-right me-2"></i>下一步
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('resendBtn').onclick = function() {
    this.disabled = true;
    this.textContent = '发送中...';
    setTimeout(() => {
        this.disabled = false;
        this.textContent = '重新发送';
    }, 3000);
};
</script>
