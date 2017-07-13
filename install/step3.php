<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>轻松参透测试系统</title>
    <link href="../public/bootstrap3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div style="width: 900px;margin: 50 auto;">
    <?php
    $link = @mysqli_connect($_POST['DB_HOST'], $_POST['DB_USER'], $_POST['DB_PASS']);

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

        //创建默认分区
        $sql = "insert into bbs_part(pname) values('默认分区')";
        $row = mysql_func($sql);
        if ($row) {
            echo "建立默认分区成功<p />";
        } else {
            echo "建立默认分区失败<p />";
        }

        //创建默认板块
        $sql = "insert into bbs_cate(pid,cname) values('$row','默认板块')";
        $row = mysql_func($sql);
        if ($row) {
            echo "建立默认板块成功<p />";
        } else {
            echo "建立默认板块失败<p />";
        }

        //获取服务器当前时间、客户IP
        $rime = $_SERVER['REQUEST_TIME'];
        $rip = !empty(ip2long($_SERVER['REMOTE_ADDR'])) ? ip2long($_SERVER['REMOTE_ADDR']) : 0;
        $sql = "insert into bbs_user(username,password,rtime,rip,admins) values('" . $_POST['username'] . "','" . md5($_POST['password']) . "','$rime','$rip','1')";

        $id = mysql_func($sql);

        if (!$id) {
            echo "<script>alert('数据库错误：数据库写入失败！')</script>";
            echo "<script>window.location.href='../'</script>";
            exit();
        }

        //写入数据库用户详情表
        $sql = "insert into bbs_user_detail(uid) values('$id')";
        $id = mysql_func($sql);

        if ($id !== false) {
            ?>
            创建管理员成功！<p/>
            <form action='../index.php'>
                <input class="btn btn-success" type='submit' value='进入首页'/>
            </form>
            <?php
            //生成一个锁文件
            file_put_contents('install.lock', '');
        } else {
            echo "管理员创建失败！<p />";
        }
    } ?>
</div>
</body>
</html>