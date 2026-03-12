<?php
/**
 * SQLite数据库初始化脚本
 * 创建所有必要的数据表和初始数据
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 加载配置
require_once ROOT_PATH . '/conf/dbconfig.php';
require_once ROOT_PATH . '/core/db_func.php';

echo "=== SQLite数据库初始化脚本 ===\n\n";

// 创建数据目录
$dataDir = dirname(DB_PATH);
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
    echo "创建数据目录: {$dataDir}\n";
}

// 获取数据库连接
$db = getDbConnection();

// 创建数据表SQL
$tables = array(
    // 用户表
    "CREATE TABLE IF NOT EXISTS bbs_user (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(32) NOT NULL DEFAULT '72user',
        email VARCHAR(32) NOT NULL DEFAULT '',
        password CHAR(32) NOT NULL DEFAULT '72pass',
        rtime INTEGER NOT NULL DEFAULT 0,
        rip INTEGER NOT NULL DEFAULT 0,
        admins INTEGER NOT NULL DEFAULT 0
    )",

    // 用户详情表
    "CREATE TABLE IF NOT EXISTS bbs_user_detail (
        uid INTEGER PRIMARY KEY,
        t_name VARCHAR(32) DEFAULT '',
        age INTEGER NOT NULL DEFAULT 0,
        sex INTEGER NOT NULL DEFAULT 0,
        edu INTEGER NOT NULL DEFAULT 0,
        signed TEXT,
        pic VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/default.gif',
        telphone VARCHAR(32) NOT NULL DEFAULT '',
        qq INTEGER NOT NULL DEFAULT 0,
        email VARCHAR(255) NOT NULL DEFAULT '',
        brithday INTEGER NOT NULL DEFAULT 0,
        picm VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaultm.gif',
        pics VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaults.gif'
    )",

    // 分区表
    "CREATE TABLE IF NOT EXISTS bbs_part (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pname VARCHAR(255) NOT NULL DEFAULT '默认分区',
        padmins INTEGER NOT NULL DEFAULT 6
    )",

    // 版块表
    "CREATE TABLE IF NOT EXISTS bbs_cate (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        cname VARCHAR(255) NOT NULL DEFAULT '默认板块',
        uid INTEGER NOT NULL DEFAULT 0
    )",

    // 帖子表
    "CREATE TABLE IF NOT EXISTS bbs_post (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cid INTEGER NOT NULL DEFAULT 0,
        title VARCHAR(1000) NOT NULL DEFAULT '帖子标题',
        content TEXT,
        ptime INTEGER NOT NULL DEFAULT 0,
        uid INTEGER NOT NULL DEFAULT 0,
        pip VARCHAR(1000) NOT NULL DEFAULT '0',
        count INTEGER NOT NULL DEFAULT 0,
        del INTEGER NOT NULL DEFAULT 1,
        view_count INTEGER NOT NULL DEFAULT 0
    )",

    // 回复表
    "CREATE TABLE IF NOT EXISTS bbs_reply (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        content TEXT,
        uid INTEGER NOT NULL DEFAULT 0,
        ptime INTEGER NOT NULL DEFAULT 0,
        pip INTEGER NOT NULL DEFAULT 0,
        xx INTEGER NOT NULL DEFAULT 1
    )",

    // 友情链接表
    "CREATE TABLE IF NOT EXISTS bbs_fri (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL DEFAULT '百度',
        desc1 VARCHAR(255) NOT NULL DEFAULT '百度一下,你就知道',
        url VARCHAR(255) NOT NULL DEFAULT 'http://www.baidu.com',
        pic VARCHAR(255) NOT NULL DEFAULT 'default_fri.gif'
    )",

    // IP黑名单表
    "CREATE TABLE IF NOT EXISTS bbs_iprefuse (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ipmin VARCHAR(20) NOT NULL,
        ipmax VARCHAR(20) NOT NULL
    )",

    // 敏感词表
    "CREATE TABLE IF NOT EXISTS bbs_fil (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hinge VARCHAR(32) NOT NULL
    )",

    // 关注表
    "CREATE TABLE IF NOT EXISTS bbs_home_follow (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        uid INTEGER NOT NULL DEFAULT 0,
        username CHAR(15) NOT NULL,
        followuid INTEGER NOT NULL DEFAULT 0,
        fusername CHAR(15) NOT NULL,
        status INTEGER NOT NULL DEFAULT 0,
        mutual INTEGER NOT NULL DEFAULT 0,
        uptiem INTEGER NOT NULL DEFAULT 0
    )"
);

// 创建索引
$indexes = array(
    "CREATE INDEX IF NOT EXISTS idx_post_cid ON bbs_post(cid)",
    "CREATE INDEX IF NOT EXISTS idx_post_uid ON bbs_post(uid)",
    "CREATE INDEX IF NOT EXISTS idx_post_del ON bbs_post(del)",
    "CREATE INDEX IF NOT EXISTS idx_reply_pid ON bbs_reply(pid)",
    "CREATE INDEX IF NOT EXISTS idx_reply_uid ON bbs_reply(uid)",
    "CREATE INDEX IF NOT EXISTS idx_follow_uid ON bbs_home_follow(uid)",
    "CREATE INDEX IF NOT EXISTS idx_follow_followuid ON bbs_home_follow(followuid)"
);

// 执行创建表
echo "创建数据表...\n";
foreach ($tables as $sql) {
    try {
        $db->exec($sql);
        echo "  [OK] ";
        preg_match('/CREATE TABLE.*?(\w+)/i', $sql, $matches);
        echo isset($matches[1]) ? $matches[1] : 'table';
        echo "\n";
    } catch (PDOException $e) {
        echo "  [FAIL] " . $e->getMessage() . "\n";
    }
}

// 执行创建索引
echo "\n创建索引...\n";
foreach ($indexes as $sql) {
    try {
        $db->exec($sql);
        echo "  [OK] index created\n";
    } catch (PDOException $e) {
        echo "  [SKIP] " . $e->getMessage() . "\n";
    }
}

// 插入初始数据
echo "\n插入初始数据...\n";

// 检查是否已有数据
$count = $db->query("SELECT COUNT(*) as c FROM bbs_user")->fetch()['c'];

if ($count == 0) {
    // 插入管理员用户 (密码: 123456)
    $password = md5('123456');
    $db->exec("INSERT INTO bbs_user (id, username, email, password, rtime, rip, admins) VALUES (1, 'admin', 'admin@test.com', '{$password}', " . time() . ", 0, 1)");
    $db->exec("INSERT INTO bbs_user_detail (uid, t_name, pic) VALUES (1, '管理员', '/resources/images/userhead/default.gif')");
    echo "  [OK] 创建管理员账户 (admin/123456)\n";

    // 插入测试用户
    $db->exec("INSERT INTO bbs_user (id, username, email, password, rtime, rip, admins) VALUES (2, 'test', 'test@test.com', '{$password}', " . time() . ", 0, 0)");
    $db->exec("INSERT INTO bbs_user_detail (uid, t_name, pic) VALUES (2, '测试用户', '/resources/images/userhead/default.gif')");
    echo "  [OK] 创建测试用户 (test/123456)\n";

    // 插入分区
    $db->exec("INSERT INTO bbs_part (id, pname, padmins) VALUES (1, '常规漏洞', 1)");
    $db->exec("INSERT INTO bbs_part (id, pname, padmins) VALUES (2, '逻辑漏洞', 1)");
    echo "  [OK] 创建分区数据\n";

    // 插入版块
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (1, 1, 'SQL注入', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (2, 1, 'XSS跨站', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (3, 1, '命令执行', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (4, 1, '文件上传', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (5, 2, '密码找回', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (6, 2, '越权访问', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (7, 2, 'SSRF漏洞', 0)");
    $db->exec("INSERT INTO bbs_cate (id, pid, cname, uid) VALUES (8, 2, '验证码绕过', 0)");
    echo "  [OK] 创建版块数据\n";

    // 插入示例帖子
    $db->exec("INSERT INTO bbs_post (id, cid, title, content, ptime, uid, pip, count, del, view_count) VALUES (1, 1, 'SQL注入基础教程', '<p>SQL注入是一种常见的Web安全漏洞...</p>', " . time() . ", 1, '127.0.0.1', 0, 1, 10)");
    $db->exec("INSERT INTO bbs_post (id, cid, title, content, ptime, uid, pip, count, del, view_count) VALUES (2, 2, 'XSS攻击实战', '<p>XSS跨站脚本攻击详解...</p>', " . time() . ", 1, '127.0.0.1', 0, 1, 5)");
    echo "  [OK] 创建示例帖子\n";

} else {
    echo "  [SKIP] 数据库已有数据，跳过初始化\n";
}

echo "\n=== 数据库初始化完成 ===\n";
echo "数据库文件: " . DB_PATH . "\n";
echo "管理员账号: admin / 123456\n";
echo "测试账号: test / 123456\n";

// 创建安装锁文件
$lockFile = ROOT_PATH . '/install/install.lock';
file_put_contents($lockFile, date('Y-m-d H:i:s'));
echo "\n已创建安装锁文件: install/install.lock\n";
echo "现在可以访问系统首页了！\n";
?>
