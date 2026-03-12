<?php

date_default_timezone_set('PRC');
//设置页面字符集为 UTF-8
header('content-type:text/html;charset=utf-8');
header('cache-control:no-cache');
session_start();//开启session
//引用函数库和配置文件
require_once $_SERVER['DOCUMENT_ROOT'] . "/conf/dbconfig.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/conf/web_config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/db_func.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/Db.php";

$model = !empty($_GET['m']) ? $_GET['m'] : 'index';
$action = !empty($_GET['a']) ? $_GET['a'] : 'index';


/**
 * 加载模板文件
 * @param $tplPath
 */
function displayTpl($tplPath, $data = [])
{
    $filePath = "./tpl/$tplPath.php";
    if (!is_readable($filePath)) {
        echo '模板文件' . $filePath . '不存在!';
        die;
    }

    foreach ($data as $key => $val) {
        $$key = $val;
    }

    require_once "./public/header.php";
    require_once $filePath;
    require_once "./public/footer.php";
}

function getAdminUid()
{
    $user = getAdminUser();
    return $user['id'];
}

function getAdminUser()
{
    return getCurrentUser();
//    return $_SESSION['admin']['username'] ?? [];
}

function unsetAdminUser()
{
    unsetUser();
//    unset($_SESSION['admin']['username']);
}

function saveAdminUser($userInfo)
{
    saveCurrentUser($userInfo);
//    $_SESSION['admin']['username'] = $userInfo;
}

function getCurrentUser()
{
    return $_SESSION['home']['username'] ?? [];
}

function unsetUser()
{
    unset($_SESSION['home']['username']);
}

function saveCurrentUser($userInfo)
{
    $_SESSION['home']['username'] = $userInfo;
}


/**
 * 加载类文件
 * @param $model
 * @param $action
 */
function includeAction($model, $action)
{
    //判断控制器是否存在
    $filePath = "./action/$model.php";
    if (is_readable($filePath)) {
        require_once $filePath;
        $class = new $model;
        if (is_callable(array($class, $action))) {
            $class->$action();
            return true;
        }
    }

    //如果没有找到对应的控制器，直接调用模板文件
    $tplFilePath = "./tpl/$model/$action.php";
    if (is_readable($tplFilePath)) {
        require_once $tplFilePath;
        return true;
    }

    echo '控制器或模板文件' . $filePath . '不存在!';
    die;
}

/**
 * 接收参数
 * @param $paramName
 * @return mixed
 */
function getParam($paramName)
{
    $value = isset($_GET[$paramName]) ? $_GET[$paramName] : $_POST[$paramName];
//    $value = htmlspecialchars($value);

    return $value;
}

/**
 * 实例化一个Model类
 * @param $modelPath
 * @return mixed
 */
function NewService($modelName)
{
    $filePath = "../model/$modelName/{$modelName}Service.php";
    if (!is_readable($filePath)) {
        echo '接口文件' . $filePath . '不存在!';
        die;
    }

    require_once $filePath;
    return new $modelName;
}

/**
 * 网站错误页面提示
 * @param $errorInfo
 */
function errorView($errorInfo, $retLink = '/')
{
    $data = ['errorinfo' => $errorInfo, 'link' => $retLink];
    displayTpl('common/error', $data);
}

/**
 * 发送邮件
 * @return bool|string
 */
function sendEmail($to, $content)
{
    $url = 'http://api.sendcloud.net/apiv2/mail/send';
    $API_USER = 'daxia_test_VMavET';
    $API_KEY = 'un2Dx5Z9JFsDwVoQ';

    //您需要登录SendCloud创建API_USER，使用API_USER和API_KEY才可以进行邮件的发送。
    $param = array(
        'apiUser' => $API_USER,
        'apiKey' => $API_KEY,
        'from' => '78778443@qq.com',
        'fromName' => 'permeate渗透测试系统',
        'to' => $to,
        'subject' => '来自SendCloud的第一封邮件！',
        'html' => $content,
        'respEmailId' => 'true');

    $data = http_build_query($param);

    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $data
        ));

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

/**
 * 生成URL
 * @param string $path
 * @param array $param
 * @return string
 */
function U($path = 'index/index', $param = [])
{
    $result = explode('/', $path);
    $url = "index.php?m={$result[0]}&a={$result[1]}";

    if (is_array($param)) {
        foreach ($param as $key => $value) {
            $url .= "&$key=$value";
        }
    } elseif (is_string($param) && !empty($param)) {
        $url .= $param;
    }

    return $url;
}

function url($path = 'index/index', $param = [])
{
    return U($path, $param);
}

function isLogin($module = 'home')
{
    if ($module == 'home') {
        $user = getCurrentUser();
    } elseif ($module == 'admin') {
        $user = getAdminUser();
    }
    if (empty($user)) {
        echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
        exit;
    } else {
        return intval($user['id']);
    }
}

function isGuanzhu()
{

}

/**
 * 安全的HTML转义函数，处理null值
 * @param mixed $string
 * @return string
 */
function h($string)
{
    if ($string === null) {
        return '';
    }
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

/**
 * 安全获取数组值
 * @param array $arr
 * @param string|int $key
 * @param mixed $default
 * @return mixed
 */
function arr_get($arr, $key, $default = '')
{
    return isset($arr[$key]) && $arr[$key] !== null ? $arr[$key] : $default;
}

/**
 * 获取用户头像，如果不存在则返回默认头像
 * @param string|null $pic 头像URL
 * @param string $username 用户名，用于生成首字母头像
 * @return string
 */
function getAvatar($pic, $username = '')
{
    // 检查头像是否存在且有效
    if (!empty($pic) && $pic !== 'null') {
        // 检查是否是有效的URL或路径
        if (filter_var($pic, FILTER_VALIDATE_URL) !== false ||
            file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($pic, './'))) {
            return htmlspecialchars($pic, ENT_QUOTES, 'UTF-8');
        }
    }

    // 生成首字母头像
    return generateInitialAvatar($username);
}

/**
 * 生成基于首字母的SVG头像
 * @param string $username
 * @return string data URI
 */
function generateInitialAvatar($username)
{
    // 获取首字母
    $initial = mb_substr($username ?: 'U', 0, 1, 'UTF-8');
    $initial = strtoupper($initial);

    // 根据用户名生成颜色
    $colors = [
        '#6366f1', '#8b5cf6', '#ec4899', '#ef4444',
        '#f59e0b', '#10b981', '#06b6d4', '#3b82f6'
    ];
    $colorIndex = ord($initial) % count($colors);
    $bgColor = $colors[$colorIndex];

    // 生成SVG
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">' .
           '<rect width="100" height="100" fill="' . $bgColor . '"/>' .
           '<text x="50" y="50" dominant-baseline="central" text-anchor="middle" ' .
           'fill="white" font-family="Arial, sans-serif" font-size="45" font-weight="600">' .
           htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') .
           '</text></svg>';

    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}