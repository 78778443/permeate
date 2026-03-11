<?php
/**
 * Web页面模拟测试脚本
 * 模拟Web请求测试各页面功能
 */

// 定义根目录
define('ROOT_PATH', dirname(__DIR__));
define('WEB_TEST', true);

// 模拟Web环境
$_SERVER['DOCUMENT_ROOT'] = ROOT_PATH;
$_SERVER['REQUEST_TIME'] = time();
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['HTTP_REFERER'] = 'http://localhost/';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['REQUEST_METHOD'] = 'GET';

// 加载配置
require_once ROOT_PATH . '/conf/dbconfig.php';
require_once ROOT_PATH . '/core/db_func.php';

echo "=== Web页面模拟测试 ===\n\n";

// 开启输出缓冲
ob_start();

$tests = [];
$passed = 0;
$failed = 0;

/**
 * 测试页面加载
 */
function testPageLoad($name, $params = []) {
    global $tests, $passed, $failed;

    echo "测试页面: {$name} ... ";

    // 重置全局变量
    $_GET = $params;
    $_POST = [];
    $_REQUEST = array_merge($_GET, $_POST);

    // 清空输出缓冲
    ob_clean();

    try {
        // 设置错误处理
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        // 开始捕获
        ob_start();

        // 根据测试名称加载对应文件
        switch ($name) {
            case '首页':
                chdir(ROOT_PATH);
                $_GET['m'] = 'index';
                $_GET['a'] = 'index';
                include ROOT_PATH . '/home/index.php';
                break;

            case '用户登录页':
                chdir(ROOT_PATH . '/home');
                $_GET['m'] = 'user';
                $_GET['a'] = 'login';
                include ROOT_PATH . '/home/index.php';
                break;

            case '用户注册页':
                chdir(ROOT_PATH . '/home');
                $_GET['m'] = 'user';
                $_GET['a'] = 'register';
                include ROOT_PATH . '/home/index.php';
                break;

            case '帖子列表':
                chdir(ROOT_PATH . '/home');
                $_GET['m'] = 'tiezi';
                $_GET['a'] = 'index';
                $_GET['bk'] = 1;
                include ROOT_PATH . '/home/index.php';
                break;

            case '帖子详情':
                chdir(ROOT_PATH . '/home');
                $_GET['m'] = 'tiezi';
                $_GET['a'] = 'detail';
                $_GET['bk'] = 1;
                $_GET['zt'] = 1;
                include ROOT_PATH . '/home/index.php';
                break;

            case '搜索功能':
                chdir(ROOT_PATH . '/home');
                $_REQUEST['keywords'] = 'SQL';
                include ROOT_PATH . '/home/search.php';
                break;

            case '后台登录页':
                chdir(ROOT_PATH . '/admin/public');
                include ROOT_PATH . '/admin/public/login.php';
                break;

            case '找回密码页':
                chdir(ROOT_PATH . '/home');
                $_GET['m'] = 'user';
                $_GET['a'] = 're_passwd_step1';
                include ROOT_PATH . '/home/index.php';
                break;

            default:
                throw new Exception("未知测试: {$name}");
        }

        $output = ob_get_clean();
        restore_error_handler();

        // 检查是否有致命错误
        if (strpos($output, 'Fatal error') !== false ||
            strpos($output, 'Parse error') !== false) {
            echo "[FAIL] - 页面有错误\n";
            $failed++;
            return false;
        }

        echo "[PASS]\n";
        $passed++;
        return true;

    } catch (Exception $e) {
        ob_end_clean();
        restore_error_handler();
        echo "[FAIL] - " . $e->getMessage() . "\n";
        $failed++;
        return false;
    }
}

// 初始化Session
session_start();

// 运行测试
echo "--- 前台页面测试 ---\n";
testPageLoad('首页');
testPageLoad('用户登录页');
testPageLoad('用户注册页');
testPageLoad('帖子列表');
testPageLoad('帖子详情');
testPageLoad('搜索功能');
testPageLoad('找回密码页');

echo "\n--- 后台页面测试 ---\n";
testPageLoad('后台登录页');

// 输出结果
echo "\n" . str_repeat("=", 40) . "\n";
echo "测试结果: 通过 {$passed} 个, 失败 {$failed} 个\n";

if ($failed > 0) {
    exit(1);
} else {
    echo "\n所有页面测试通过!\n";
    exit(0);
}
?>
