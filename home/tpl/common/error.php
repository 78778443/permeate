<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-times-circle fa-5x text-danger mb-3"></i>
                            <h3>系统错误</h3>
                        </div>

                        <p class="text-danger mb-4">
                            <?= !empty($data['errorinfo']) ? htmlspecialchars($data['errorinfo']) : '系统错误'; ?>
                        </p>

                        <a href="<?= !empty($data['link']) ? htmlspecialchars($data['link']) : '/'; ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>返回
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
