<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                附件上传
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php";?>
                    <div class="col-lg-10 pt-3">
                        <div class="alert alert-warning">
                            <strong>漏洞说明：</strong>此功能存在多种文件上传绕过漏洞：
                            <ul>
                                <li>前端JS验证绕过：禁用JS或修改后缀</li>
                                <li>MIME类型绕过：修改Content-Type</li>
                                <li>黑名单绕过：使用.php3, .php5, .phtml等后缀</li>
                                <li>空字节截断：使用.php%00.jpg</li>
                            </ul>
                        </div>
                        <div class="upload">
                            <form action="/home/index.php?m=user&a=_upload_file" method="post" enctype="multipart/form-data" id="uploadForm">
                                <div class="form-group">
                                    <label>选择文件</label>
                                    <input type="file" class="form-control-file" name="file" id="fileInput">
                                    <small class="form-text text-muted">允许上传的文件类型：jpg, jpeg, png, gif, txt, pdf</small>
                                </div>
                                <button type="submit" class="btn btn-primary">上传文件</button>
                            </form>

                            <h5 class="mt-4">已上传的文件</h5>
                            <div id="uploadedFiles">
                                <?php
                                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                                if (is_dir($upload_dir)) {
                                    $files = scandir($upload_dir);
                                    foreach ($files as $file) {
                                        if ($file != '.' && $file != '..') {
                                            echo '<div class="uploaded-file"><a href="/uploads/' . $file . '" target="_blank">' . $file . '</a></div>';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 前端JS验证（可绕过） -->
<script>
document.getElementById('uploadForm').onsubmit = function(e) {
    var file = document.getElementById('fileInput').value;
    var allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'txt', 'pdf'];
    var ext = file.split('.').pop().toLowerCase();

    if (allowedExts.indexOf(ext) === -1) {
        alert('不允许上传此类型的文件！');
        e.preventDefault();
        return false;
    }
    return true;
};
</script>
