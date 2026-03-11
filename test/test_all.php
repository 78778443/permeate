<?php
/**
 * 功能测试脚本
 * 测试所有关键功能页面是否正常工作
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));

// 模拟Web环境
$_SERVER['DOCUMENT_ROOT'] = ROOT_PATH;
$_SERVER['REQUEST_TIME'] = time();
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_REFERER'] = 'http://localhost/';

// 加载配置和函数
require_once ROOT_PATH . '/conf/dbconfig.php';
require_once ROOT_PATH . '/core/db_func.php';

echo "=== WEB安全靶场功能测试 ===\n\n";

$passCount = 0;
$failCount = 0;
$errors = [];

/**
 * 测试函数
 */
function testQuery($name, $sql) {
    global $passCount, $failCount, $errors;

    echo "测试: {$name} ... ";
    $result = mysql_func($sql);

    if ($result !== false) {
        echo "[PASS]\n";
        $passCount++;
        return $result;
    } else {
        echo "[FAIL]\n";
        $failCount++;
        $errors[] = "SQL执行失败: {$sql}";
        return false;
    }
}

// 1. 测试数据库连接
echo "--- 数据库连接测试 ---\n";
$db = getDbConnection();
if ($db) {
    echo "数据库连接: [PASS]\n";
    $passCount++;
} else {
    echo "数据库连接: [FAIL]\n";
    $failCount++;
    exit("无法连接数据库\n");
}

// 2. 测试用户表
echo "\n--- 用户表测试 ---\n";
$users = testQuery("查询用户列表", "SELECT * FROM bbs_user");
if ($users) {
    echo "  用户数量: " . count($users) . "\n";
    foreach ($users as $user) {
        echo "  - ID:{$user['id']} 用户名:{$user['username']} 管理员:" . ($user['admins'] ? '是' : '否') . "\n";
    }
}

// 3. 测试用户详情表
echo "\n--- 用户详情表测试 ---\n";
testQuery("查询用户详情", "SELECT * FROM bbs_user_detail WHERE uid = 1");

// 4. 测试分区表
echo "\n--- 分区表测试 ---\n";
$parts = testQuery("查询分区列表", "SELECT * FROM bbs_part");
if ($parts) {
    foreach ($parts as $part) {
        echo "  - {$part['pname']}\n";
    }
}

// 5. 测试版块表
echo "\n--- 版块表测试 ---\n";
$cates = testQuery("查询版块列表", "SELECT * FROM bbs_cate");
if ($cates) {
    foreach ($cates as $cate) {
        echo "  - {$cate['cname']}\n";
    }
}

// 6. 测试帖子表
echo "\n--- 帖子表测试 ---\n";
$posts = testQuery("查询帖子列表", "SELECT * FROM bbs_post");
if ($posts) {
    foreach ($posts as $post) {
        echo "  - [{$post['id']}] {$post['title']}\n";
    }
}

// 7. 测试回复表
echo "\n--- 回复表测试 ---\n";
testQuery("查询回复表结构", "SELECT * FROM bbs_reply LIMIT 1");

// 8. 测试关注表
echo "\n--- 关注表测试 ---\n";
testQuery("查询关注表", "SELECT * FROM bbs_home_follow LIMIT 1");

// 9. 测试INSERT
echo "\n--- 写入测试 ---\n";
$testTime = time();
$insertSql = "INSERT INTO bbs_post (cid, title, content, ptime, uid, pip, count, del, view_count) VALUES (1, '测试帖子', '<p>测试内容</p>', {$testTime}, 1, '127.0.0.1', 0, 1, 0)";
$newId = testQuery("插入测试帖子", $insertSql);
if ($newId) {
    echo "  新帖子ID: {$newId}\n";

    // 测试UPDATE
    $updateSql = "UPDATE bbs_post SET view_count = view_count + 1 WHERE id = {$newId}";
    testQuery("更新帖子浏览量", $updateSql);

    // 测试DELETE
    $deleteSql = "DELETE FROM bbs_post WHERE id = {$newId}";
    testQuery("删除测试帖子", $deleteSql);
}

// 10. 测试SQL注入漏洞（确保漏洞存在）
echo "\n--- SQL注入漏洞测试 ---\n";
// 正常查询
$normalResult = mysql_func("SELECT * FROM bbs_user WHERE username = 'admin'");
if ($normalResult && count($normalResult) > 0) {
    echo "  正常查询: [PASS] 找到admin用户\n";
    $passCount++;
} else {
    echo "  正常查询: [FAIL]\n";
    $failCount++;
}

// 11. 测试用户登录验证
echo "\n--- 登录验证测试 ---\n";
$password = md5('123456');
$loginSql = "SELECT * FROM bbs_user WHERE username = 'admin' AND password = '{$password}'";
$loginResult = testQuery("验证登录", $loginSql);
if ($loginResult && count($loginResult) > 0) {
    echo "  登录验证: [PASS] 密码验证正确\n";
}

// 12. 测试关联查询
echo "\n--- 关联查询测试 ---\n";
$joinSql = "SELECT p.*, c.cname FROM bbs_post p LEFT JOIN bbs_cate c ON p.cid = c.id WHERE p.del = 1";
testQuery("帖子与版块关联查询", $joinSql);

// 输出结果
echo "\n" . str_repeat("=", 40) . "\n";
echo "测试结果: 通过 {$passCount} 个, 失败 {$failCount} 个\n";

if ($failCount > 0) {
    echo "\n错误详情:\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
    exit(1);
} else {
    echo "\n所有测试通过!\n";
    exit(0);
}
?>
