<?php
/**
 * 简化版Web页面测试脚本
 * 测试各功能页面的核心逻辑
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 模拟Web环境
$_SERVER['DOCUMENT_ROOT'] = ROOT_PATH;
$_SERVER['REQUEST_TIME'] = time();
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_NAME'] = 'localhost';

echo "=== 功能页面核心逻辑测试 ===\n\n";

$passed = 0;
$failed = 0;

// 加载配置和函数
require_once ROOT_PATH . '/conf/dbconfig.php';
require_once ROOT_PATH . '/core/db_func.php';

// 开启Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "--- 数据库操作测试 ---\n";

// 测试1: 用户查询
echo "1. 用户查询测试: ";
$sql = "SELECT * FROM bbs_user WHERE username = 'admin'";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 找到admin用户\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试2: 用户详情
echo "2. 用户详情查询: ";
$sql = "SELECT u.*, d.* FROM bbs_user u LEFT JOIN bbs_user_detail d ON u.id = d.uid WHERE u.id = 1";
$result = mysql_func($sql);
if ($result && isset($result[0]['username'])) {
    echo "[PASS] 用户: {$result[0]['username']}\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试3: 分区查询
echo "3. 分区查询: ";
$sql = "SELECT * FROM bbs_part";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 找到 " . count($result) . " 个分区\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试4: 版块查询
echo "4. 版块查询: ";
$sql = "SELECT * FROM bbs_cate WHERE pid = 1";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 找到 " . count($result) . " 个版块\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试5: 帖子查询
echo "5. 帖子列表查询: ";
$sql = "SELECT p.*, u.username FROM bbs_post p, bbs_user u WHERE p.uid = u.id AND p.cid = 1 LIMIT 5";
$result = mysql_func($sql);
if ($result !== false) {
    echo "[PASS] 找到 " . count($result) . " 个帖子\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试6: 帖子详情
echo "6. 帖子详情查询: ";
$sql = "SELECT p.*, u.username, d.pic FROM bbs_post p, bbs_user u, bbs_user_detail d WHERE p.uid = u.id AND d.uid = p.uid AND p.id = 1";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 标题: {$result[0]['title']}\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试7: 搜索功能
echo "7. 搜索功能测试: ";
$sql = "SELECT * FROM bbs_post WHERE title LIKE '%SQL%'";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 找到匹配帖子\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试8: 登录验证
echo "8. 登录验证测试: ";
$password = md5('123456');
$sql = "SELECT u.*, d.* FROM bbs_user u, bbs_user_detail d WHERE d.uid = u.id AND u.username = 'admin' AND u.password = '{$password}'";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] 登录验证成功\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试9: 插入测试
echo "9. 数据插入测试: ";
$sql = "INSERT INTO bbs_post (cid, title, content, ptime, uid, pip) VALUES (1, '测试帖子', '测试内容', " . time() . ", 1, '127.0.0.1')";
$newId = mysql_func($sql);
if ($newId > 0) {
    echo "[PASS] 新帖子ID: {$newId}\n";
    $passed++;

    // 测试更新
    echo "10. 数据更新测试: ";
    $sql = "UPDATE bbs_post SET view_count = view_count + 1 WHERE id = {$newId}";
    $rows = mysql_func($sql);
    if ($rows !== false) {
        echo "[PASS]\n";
        $passed++;
    } else {
        echo "[FAIL]\n";
        $failed++;
    }

    // 测试删除
    echo "11. 数据删除测试: ";
    $sql = "DELETE FROM bbs_post WHERE id = {$newId}";
    $rows = mysql_func($sql);
    if ($rows !== false) {
        echo "[PASS]\n";
        $passed++;
    } else {
        echo "[FAIL]\n";
        $failed++;
    }
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试12: SQL注入漏洞验证
echo "12. SQL注入漏洞验证: ";
$sql = "SELECT * FROM bbs_user WHERE username = 'admin' OR '1'='1'";
$result = mysql_func($sql);
if ($result && count($result) > 0) {
    echo "[PASS] SQL注入点存在\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试13: 关联查询
echo "13. 复杂关联查询: ";
$sql = "SELECT p.id, p.title, p.ptime, u.username, c.cname
        FROM bbs_post p
        LEFT JOIN bbs_user u ON p.uid = u.id
        LEFT JOIN bbs_cate c ON p.cid = c.id
        WHERE p.del = 1
        ORDER BY p.ptime DESC
        LIMIT 5";
$result = mysql_func($sql);
if ($result !== false) {
    echo "[PASS] 查询成功\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 测试14: 关注功能
echo "14. 关注表查询: ";
$sql = "SELECT * FROM bbs_home_follow WHERE uid = 1";
$result = mysql_func($sql);
if ($result !== false) {
    echo "[PASS]\n";
    $passed++;
} else {
    echo "[FAIL]\n";
    $failed++;
}

// 输出结果
echo "\n" . str_repeat("=", 50) . "\n";
echo "测试结果汇总:\n";
echo "  通过: {$passed} 个\n";
echo "  失败: {$failed} 个\n";

if ($failed > 0) {
    echo "\n状态: 存在失败的测试项\n";
    exit(1);
} else {
    echo "\n状态: 所有测试通过!\n";
    exit(0);
}
?>
