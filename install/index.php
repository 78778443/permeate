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
<html>
<head>
    <meta charset="utf-8">
    <title>Permeate 渗透测试系统 - 安装向导</title>
    <link href="../home/resource/dist/bootstrap.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; padding: 50px 0; }
        .install-box { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .install-box h2 { margin-bottom: 30px; color: #333; }
        .alert { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="install-box">
        <h2 class="text-center">Permeate 渗透测试系统安装</h2>

        <div class="alert alert-info">
            <strong>数据库类型：</strong>SQLite (无需额外配置)
        </div>

        <div class="alert alert-warning">
            <strong>注意：</strong>本系统包含安全漏洞，仅供学习使用，请勿部署到公网环境！
        </div>

        <form id="installForm">
            <div class="form-group">
                <label>管理员用户名</label>
                <input type="text" class="form-control" name="username" value="admin" required>
            </div>
            <div class="form-group">
                <label>管理员密码</label>
                <input type="password" class="form-control" name="password" value="123456" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">开始安装</button>
        </form>

        <div id="result" style="margin-top: 20px;"></div>
    </div>

    <script>
    document.getElementById('installForm').onsubmit = function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            var resultDiv = document.getElementById('result');
            if (data.success) {
                resultDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>' +
                    '<a href="../index.php" class="btn btn-success btn-block">进入首页</a>';
            } else {
                resultDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
            }
        });
    };
    </script>
</body>
</html>
