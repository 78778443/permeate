<link rel="stylesheet" href="./resource/styles/repasswd.css">
<div id="doc3">
    <div class="wrap-content findpwd-succeed none" style="z-index:110001;">
        <div class="content-title">系统错误</div>
        <div class="content-main">
            <p style="color: red;font-size: 16px;"><?= !empty($data['errorinfo']) ? $data['errorinfo'] : '系统错误'; ?></p>
            <p><a href="<?= !empty($data['link']) ? $data['link'] : '/'; ?>" class="btn btn-success btn-lg">返回</a></p>
        </div>
    </div>
</div>