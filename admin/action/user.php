<?php

class user
{
    function __construct()
    {

    }

    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where username like '%$keywords%' ";
            $link = "&keywords=" . $keywords;
        } else {
            $where = "";
            $link = "";
        }
        //开始分页大小
        $page_size = 3;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from " . DB_PRE . "user " . $where;
        //echo $sql;
        $row = mysql_func($sql);
        $count = $row[0]['c'];
        //计算记录总页数
        $page_count = ceil($count / $page_size);
        //防止越界
        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num >= $page_count) {
            $page_num = $page_count;
        }
        //准备SQL语句
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;
        $sql = "select u.id,u.username,u.admins,u.rtime,u.rip,d.qq,d.sex,d.age,d.email from " . DB_PRE . "user as u left join " . DB_PRE . "user_detail as d on u.id=d.uid" . $where . $limit;
        
        $row = mysql_func($sql);
        $data['admins'] = array('普通会员','管理员');
        $data['sex'] = array('保密','男','女');
        $data['list'] = $row;
        displayTpl('user/lists',$data);
    }

    public function add()
    {

        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repass = $_POST['repass'];
            $rtime = $_SERVER['REQUEST_TIME'];
            $rip = ip2long($_SERVER['REMOTE_ADDR']);

            if ($password != $repass) {
                echo "<script>alert('两次密码不一致！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
                exit;
            }

            $pattern = "/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/";

            if (!preg_match($pattern, $username)) {
                echo "<script>alert('用户名不符合规则！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
                exit;
            }


            $sql = "select username from " . DB_PRE . "user where " . DB_PRE . "user.username='$username'";

            $row = mysql_func($sql);

            if ($row) {
                echo "<script>alter('用户已存在！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
                exit;
            }
            $password = md5($password);
            $sql = "insert into " . DB_PRE . "user(username,password,rtime,rip) values('$username','$password','$rtime','$rip')";

            $row = mysql_func($sql);


            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php？m=user&a=lists'</script>";
                exit;
            }

            $sql = "insert into " . DB_PRE . "user_detail(uid) values('$row')";
            $row = mysql_func($sql);

            if (!$row === 0) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'<script/>";
                exit;
            }

            //header("location:list.php");
            echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
            exit;
        }
        displayTpl('user/add');
    }
}

