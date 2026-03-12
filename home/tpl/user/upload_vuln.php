<section class="section">
    <div class="container">
        <div class="paper">
            <div class="paper-header">
                <i class="fas fa-upload me-2"></i>附件上传
                <span class="badge bg-info ms-2">上传漏洞</span>
            </div>
            <div class="paper-body" style="min-height: 500px;">
                <div class="row">
                    <?php require_once __DIR__ . "/left_menu.php";?>
                    <div class="col-lg-8 pt-3">
                        <div class="alert alert-warning border-0">
                            <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>漏洞说明</h6>
                            <p class="mb-2">此功能存在多种文件上传绕过漏洞：</p>
                            <ul class="mb-0">
                                <li><strong>前端JS验证绕过：</strong>禁用JS或修改后缀</li>
                                <li><strong>MIME类型绕过：</strong>修改Content-Type</li>
                                <li><strong>黑名单绕过：</strong>使用.php3, .php5, .phtml等后缀</li>
                                <li><strong>空字节截断：</strong>使用.php%00.jpg</li>
                            </ul>
                        </div>

                        <form action="/home/index.php?m=user&a=_upload_file" method="post" enctype="multipart/form-data" id="uploadForm">
                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-file me-1"></i>选择文件</label>
                                <input type="file" class="form-control form-control-lg" name="file" id="fileInput">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>允许上传的文件类型：jpg, jpeg, png, gif, txt, pdf
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-cloud-upload-alt me-1"></i>上传文件
                            </button>
                        </form>

                        <hr class="my-4">

                        <h5 class="mb-3"><i class="fas fa-folder-open me-2"></i>已上传的文件</h5>
                        <div class="list-group" id="uploadedFiles">
                            <?php
                            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                            if (is_dir($upload_dir)) {
                                $files = scandir($upload_dir);
                                foreach ($files as $file) {
                                    if ($file != '.' && $file != '..') {
                                        echo '<a href="/uploads/' . htmlspecialchars($file) . '" target="_blank" class="list-group-item list-group-item-action">';
                                        echo '<i class="fas fa-file me-2"></i>' . htmlspecialchars($file);
                                        echo '</a>';
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
