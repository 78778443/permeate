<div class="card">
    <div class="card-header">
        <i class="fas fa-cog me-2"></i>网站设置
    </div>
    <div class="card-body">
        <form action="./index.php?m=manage&a=mod" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-heading text-muted me-1"></i>网站标题
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="WZ_TITLE" value="<?= htmlspecialchars(WZ_TITLE) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-tags text-muted me-1"></i>网站标签
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="WZ_KEY" value="<?= htmlspecialchars(WZ_KEY) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-copyright text-muted me-1"></i>网站版权
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="WZ_PRINT" value="<?= htmlspecialchars(WZ_PRINT) ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-info-circle text-muted me-1"></i>网站简介
                </label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="WZ_DES" rows="3"><?= htmlspecialchars(WZ_DES) ?></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-image text-muted me-1"></i>网站LOGO
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="file" name="WZ_LOGO">
                    <?php if (defined('WZ_LOGO') && WZ_LOGO) { ?>
                    <img src="<?= htmlspecialchars(WZ_LOGO) ?>" class="mt-2 rounded" style="max-height: 60px;">
                    <?php } ?>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">
                    <i class="fas fa-power-off text-muted me-1"></i>网站状态
                </label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="zt" id="zt0" value="0" <?php if(defined('zt') && zt == 0) echo 'checked'; ?>>
                        <label class="form-check-label" for="zt0">关闭</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="zt" id="zt1" value="1" <?php if(!defined('zt') || zt == 1) echo 'checked'; ?>>
                        <label class="form-check-label" for="zt1">开启</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i>保存设置
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
