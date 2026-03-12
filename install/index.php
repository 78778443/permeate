<?php
/**
 * SQLite安装脚本
 * 一键安装系统
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 检查是否已安装
if (file_exists(__DIR__ . '/install.lock')) {
    die('系统已安装！如需重新安装，请删除 install/install.lock 文件。');
}

// 处理安装请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        // 加载配置
        require_once ROOT_PATH . '/conf/dbconfig.php';
        require_once ROOT_PATH . '/core/db_func.php';

        // 获取管理员信息
        $username = isset($_POST['username']) ? trim($_POST['username']) : 'admin';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '123456';

        if (empty($username) || empty($password)) {
            throw new Exception('用户名和密码不能为空');
        }

        // 运行初始化
        $db = getDbConnection();

        // 创建数据表
        $tables = include(__DIR__ . '/table_sqlite.php');

        foreach ($tables as $sql) {
            $db->exec($sql);
        }

        // 创建管理员
        $passwordMd5 = md5($password);
        $time = time();

        // 检查是否已有用户
        $count = $db->query("SELECT COUNT(*) as c FROM bbs_user")->fetch()['c'];

        if ($count == 0) {
            // 插入管理员
            $db->exec("INSERT INTO bbs_user (username, email, password, rtime, rip, admins) VALUES ('{$username}', 'admin@localhost', '{$passwordMd5}', {$time}, 0, 1)");
            $db->exec("INSERT INTO bbs_user_detail (uid, t_name, pic) VALUES (1, '管理员', '/resources/images/userhead/default.gif')");

            // 插入测试用户
            $db->exec("INSERT INTO bbs_user (username, email, password, rtime, rip, admins) VALUES ('test', 'test@localhost', '{$passwordMd5}', {$time}, 0, 0)");
            $db->exec("INSERT INTO bbs_user_detail (uid, t_name, pic) VALUES (2, '测试用户', '/resources/images/userhead/default.gif')");

            // 插入分区
            $db->exec("INSERT INTO bbs_part (pname, padmins) VALUES ('常规漏洞', 1)");
            $db->exec("INSERT INTO bbs_part (pname, padmins) VALUES ('逻辑漏洞', 1)");

            // 插入版块
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (1, 'SQL注入')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (1, 'XSS跨站')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (1, '命令执行')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (1, '文件上传')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (2, '密码找回')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (2, '越权访问')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (2, 'SSRF漏洞')");
            $db->exec("INSERT INTO bbs_cate (pid, cname) VALUES (2, '验证码绕过')");

            // 插入示例帖子
            $db->exec("INSERT INTO bbs_post (cid, title, content, ptime, uid, pip, del) VALUES (1, 'SQL注入基础教程', '<p>SQL注入是一种常见的Web安全漏洞，攻击者可以通过构造恶意的SQL语句来获取、修改或删除数据库中的数据。</p>', {$time}, 1, '127.0.0.1', 1)");
            $db->exec("INSERT INTO bbs_post (cid, title, content, ptime, uid, pip, del) VALUES (2, 'XSS攻击实战', '<p>XSS跨站脚本攻击允许攻击者将恶意脚本注入到网页中，当其他用户浏览该网页时，脚本就会执行。</p>', {$time}, 1, '127.0.0.1', 1)");
        }

        // 创建安装锁文件
        file_put_contents(__DIR__ . '/install.lock', date('Y-m-d H:i:s'));

        echo json_encode(['success' => true, 'message' => '安装成功！']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permeate 渗透测试系统 - 安装向导</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .install-box {
            max-width: 500px;
            width: 100%;
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .install-box h2 {
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="install-box">
        <h2 class="text-center mb-4">
            <i class="fas fa-shield-alt text-primary me-2"></i>Permeate
        </h2>
        <p class="text-center text-muted mb-4">渗透测试靶场系统安装向导</p>

        <div class="alert alert-info border-0">
            <i class="fas fa-database me-2"></i><strong>数据库类型：</strong>SQLite (无需额外配置)
        </div>

        <div class="alert alert-warning border-0">
            <i class="fas fa-exclamation-triangle me-2"></i><strong>警告：</strong>本系统包含安全漏洞，仅供学习使用，请勿部署到公网环境！
        </div>

        <form id="installForm">
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-user me-1"></i>管理员用户名</label>
                <input type="text" class="form-control form-control-lg" name="username" value="admin" required>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-lock me-1"></i>管理员密码</label>
                <input type="password" class="form-control form-control-lg" name="password" value="123456" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-rocket me-2"></i>开始安装
            </button>
        </form>

        <div id="result" class="mt-4"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('installForm').onsubmit = function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>安装中...';

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            var resultDiv = document.getElementById('result');
            if (data.success) {
                resultDiv.innerHTML = '<div class="alert alert-success border-0"><i class="fas fa-check-circle me-2"></i>' + data.message + '</div>' +
                    '<a href="../index.php" class="btn btn-success btn-lg w-100 mt-3"><i class="fas fa-home me-2"></i>进入首页</a>';
            } else {
                resultDiv.innerHTML = '<div class="alert alert-danger border-0"><i class="fas fa-times-circle me-2"></i>' + data.message + '</div>';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-rocket me-2"></i>开始安装';
            }
        });
    };
    </script>
</body>
</html>
