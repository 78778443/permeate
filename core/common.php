<?php
date_default_timezone_set('PRC');
//设置页面字符集为 UTF-8
header('content-type:text/html;charset=utf-8');
header('cache-control:no-cache');
session_start();//开启session
//引用函数库mysql_function.php
require_once $_SERVER['DOCUMENT_ROOT'] . "/conf/dbconfig.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/conf/web_config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/core/mysql_func.php";
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

    require_once $filePath;

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
        'from' => 'service@sendcloud.im',
        'fromName' => 'SendCloud测试邮件',
        'to' => 'soupqingsong@foxmail.com',
        'subject' => '来自SendCloud的第一封邮件！',
        'html' => '你太棒了！你已成功的从SendCloud发送了一封测试邮件，接下来快登录前台去完善账户信息吧！',
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
        $user = $_SESSION['home']['username'];
    } elseif ($module == 'admin') {
        $user = $_SESSION['admin']['username'];
    }
    if (empty($user)) {
        echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
        exit;
    } else {
        return intval($user['id']);
    }
}

function isGuanzhu() {

}