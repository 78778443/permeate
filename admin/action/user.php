<?php

class user
{
    public function logout()
    {
        session_start();
        unsetAdminUser();
        setcookie('adminusername', '', time() - 1, '/');
        header("location:../index.php");
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

        $page_size = 10;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_user " . $where;
        $row = mysql_func($sql);
        $count = !empty($row[0]['c']) ? $row[0]['c'] : 0;

        $page_count = $count > 0 ? ceil($count / $page_size) : 1;

        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num >= $page_count) {
            $page_num = $page_count;
        }

        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
        $sql = "select u.id,u.username,u.admins,u.rtime,u.rip,d.qq,d.sex,d.age,d.email from bbs_user as u left join bbs_user_detail as d on u.id=d.uid" . $where . $limit;

        $row = mysql_func($sql);
        $data['admins'] = array('普通会员', '管理员');
        $data['sex'] = array('保密', '男', '女');
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('user/lists', $data);
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

            $sql = "select username from bbs_user where bbs_user.username='$username'";
            $row = mysql_func($sql);

            if ($row) {
                echo "<script>alert('用户已存在！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
                exit;
            }

            $password = md5($password);
            $sql = "insert into bbs_user(username,password,rtime,rip) values('$username','$password','$rtime','$rip')";
            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
                exit;
            }

            $sql = "insert into bbs_user_detail(uid) values('$row')";
            mysql_func($sql);

            echo "<script>window.location.href='./index.php?m=user&a=lists'</script>";
            exit;
        }
        displayTpl('user/add');
    }
}
