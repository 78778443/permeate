<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>轻松渗透测试系统</title>
    <link href="../public/bootstrap3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div style="width: 900px;margin: 50 auto;">
    <?php
    $link = mysqli_connect($_POST['DB_HOST'], $_POST['DB_USER'], $_POST['DB_PASS']);

    if (!$link) {
        echo "<script>";
        echo "alert('数据库信息有误');";
        echo "window.history.back();";
        echo "</script>";
    }

    $conf = "<?php\n";

    foreach ($_POST as $key => $val) {
        if ($key != 'username' && $key != 'password') {
            $conf .= "\t!defined('{$key}') && define('$key','$val');\n";
        }
    }
    $a = "\$sex=array('保密','男','女');\n\$edu=array('保密','小学','初中','高中/中专','大专','本科','研究生','博士','博士后');\n\$admins=array('普通用户','管理员')\n?>";
    $conf = $conf . $a;

    echo $conf;
    if (file_put_contents("../conf/dbconfig.php", $conf)) {
        include "../conf/dbconfig.php";
        include "../core/mysql_func.php";
        $tables = include("./table.php");
        //var_dump($table);

        //"create table if not exists `bbs_user`";
        $pattern = "/TABLE `(.*)`/U";

        foreach ($tables as $table) {
            if (false !== mysql_func($table)) {
                preg_match($pattern, $table, $match);
                echo "创建数据表" . $match[1] . "成功！<p />";
            } else {
                exit('创建数据表失败！');
            }
        }

        //导入数据
        addOldData($link);
    } ?>
</div>
</body>
</html>

<?php

function addOldData($link)
{

    $password = md5($_POST['password']);
    //导入最新的数据格式
    $sql = "use " . DB_NAME . ";\n";
    $sql .= file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/doc/bbs_cate.sql") . "\n";
    $sql .= "UPDATE {$_POST['DB_NAME']}.bbs_user SET username='{$_POST['username']}',password='$password' ORDER BY id ASC LIMIT 1";

    //批量插入用户名
    mysqli_multi_query($link, $sql);
    if (mysqli_errno($link)) {
        exit("导入数据失败:" . mysqli_error($link));
    } else {
        echo "导入数据成功!" . PHP_EOL;
        echo "<form action='../index.php'>
                <input class=\"btn btn-success\" type='submit' value='进入首页'/>
              </form>";

        file_put_contents('install.lock', '');
    }
}