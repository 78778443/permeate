<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="paper">
                    <div class="paper-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                            <h3>操作成功</h3>
                        </div>

                        <p class="text-muted mb-4">
                            <?= !empty($data['msg']) ? htmlspecialchars($data['msg']) : '操作已成功完成'; ?>
                        </p>

                        <a href="<?= !empty($data['link']) ? htmlspecialchars($data['link']) : '/'; ?>" class="btn btn-success btn-lg">
                            <i class="fas fa-home me-2"></i>返回
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
