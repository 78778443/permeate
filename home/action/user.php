<?php

class user
{
    function __construct()
    {

    }

    public function login()
    {
        displayTpl('user/login');
    }


    public function logout()
    {
        unset($_SESSION['home']['username']);
        setcookie('adminusername', '', time() - 1, '/');
        session_destroy();
        header("location:../index.php");
    }

    public function individual()
    {
        $user = $_SESSION['home']['username'];
        if (empty($user)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }

        $data['username'] = $user;
        displayTpl('user/individual', $data);
    }

    public function basic()
    {
        $edu = $sex = [];
        require "../conf/dbconfig.php";
        $user = $_SESSION['home']['username'];
        if (empty($user)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }

        $data = ['edu' => $edu, 'sex' => $sex, 'user' => $user];
        displayTpl('user/basic', $data);
    }

    public function safe()
    {
        $data = [];
        displayTpl('user/safe', $data);
    }

    /**
     * 用户上传头像
     */
    public function _upload_user_touxiang()
    {
        require_once "../core/upload_func.php";
        require_once "../core/image_func.php";
        $user = $_SESSION['home']['username'];
        $data = upload($info, 'pic', '/home/resorec/images/userhead');

        $pic = $data['newname'];
        if (!empty($pic)) {
            $pic = suolue($pic, 200, 200, '../../resorec/images/userhead/');
            $picm = suolue($pic, 100, 100, '../../resorec/images/userhead/');
            $pics = suolue($pic, 48, 48, '../../resorec/images/userhead/');
            $sql = "update " . DB_PRE . "user_detail set pic='$pic',picm='$picm',pics='$pics' where uid='" . $user['id'] . "'";
            $row = mysql_func($sql);
        }

        if (!$row) {
            echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
            echo "<script>window.location.href='../individual.php'<script/>";
            exit;
        }
        $sql = "select u.*,d.* from " . DB_PRE . "user as u," . DB_PRE . "user_detail as d where d.uid=u.id and u.username='" . $user['username'] . "' and u.password='" . $user['password'] . "'";
        //echo $sql;
        $row = mysql_func($sql);
        //var_dump($row);
        if (!$row) {
            echo "<script>window.location.href='../individual.php'<script/>";
            exit;
        }

        //session的写入直接去给$_SESSION赋值
        $_SESSION['home']['username'] = $row[0];
        //告诉浏览器将保存sessionid的cookie文件保存一个小时
        setcookie(session_name(), session_id(), time() + 3600, "/");
    }

    public function _dobasic()
    {
        $t_name = $_POST['t_name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $edu = $_POST['edu'];
        $signed = $_POST['signed'];
        $brithday = strtotime($_POST['brithday']);
        $telphone = $_POST['telphone'];
        $qq = $_POST['qq'];
        $email = $_POST['email'];
        $user = $_SESSION['home']['username'];


        $sql = "update " . DB_PRE . "user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',brithday='$brithday',telphone='$telphone',qq='$qq',email='$email' where uid=" . $user['id'];

        $row = mysql_func($sql);

        if (!$row) {
            echo "<script>alert('你没有修改，或修改失败')</script>";
            echo "<script>window.location.href='/home/'</script>";
            exit;
        }

        echo "<script>alert('修改成功！')</script>";

        $sql = "select u.*,p.* from " . DB_PRE . "user as u," . DB_PRE . "user_detail as p where u.id=" . $user['id'];

        $row = mysql_func($sql);

        if (!$row) {
            echo "<script>alert('请重新登入')</script>";
            echo "<script>window.location.href='/home/'</script>";
            exit;
        }
        $username = $row[0];
        //执行登陆操作
        //session的写入直接去给$_SESSION赋值
        $_SESSION['home']['username'] = $username;
        //告诉浏览器将保存sessionid的cookie文件保存一个小时
        setcookie(session_name(), session_id(), time() + 3600, "/");

        echo "<script>window.location.href='/home/'</script>";
    }

    public function _dosafe()
    {
        $oldpassword = $_REQUEST['oldpassword'];
        $newpassword = $_REQUEST['newpassword'];
        $newpassword2 = $_REQUEST['newpassword2'];

        if (empty($oldpassword)) {
            echo "<script>alert('请输入当前密码！')</script>";
            echo "<script>window.location.href='../safe.php'</script>";
            exit;
        }
        if (empty($newpassword) && empty($newpassword2)) {
            echo "<script>alert('请输入新的密码！')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }
        if ($newpassword !== $newpassword2) {
            echo "<script>alert('两次密码不一致！')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }

        $oldpassword = md5($oldpassword);
        $newpassword = md5($newpassword);
        $user = $_SESSION['home']['username'];


        $sql = "select * from " . DB_PRE . "user where password='$oldpassword' and id='" . $user['id'] . "'";

        $row = mysql_func($sql);
        if (!$row) {
            echo "<script>alert('请输入正确的当前密码！')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }

        $sql = "update " . DB_PRE . "user set password='$newpassword' where id='" . $user['id'] . "'";

        $row = mysql_func($sql);
        if (!$row) {
            echo "<script>alert('抱歉,密码修改失败.')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }

        unset($_SESSION['home']['username']);
        setcookie(time() - 1, '/');
        echo "<script>alert('你的密码修改成功,请用新的密码登入.')</script>";
        echo "<script>window.location.href='/'</script>";

    }

    public function info()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] : $_SESSION['home']['username']['id'];
        if (!$id)
            exit ("参数错误！");
        $sql = "select * from bbs_user_detail where uid = {$id}";
        $strUserInfo = mysql_func($sql)[0];

        if ($strUserInfo['sex'] == 1) {
            $strUserInfo['sex_name'] = '男';
        } elseif ($strUserInfo['sex'] == 2) {
            $strUserInfo['sex_name'] = '女';
        } else {
            $strUserInfo['sex_name'] = '保密';
        }
        if (!$strUserInfo)
            exit('用户不存在');
        $sql = "select count(id) as count from bbs_post where uid = {$id}";
        $strUserInfo['tiezi_count'] = mysql_func($sql)[0]['count'];
        $sql = "select count(id) as count from bbs_reply where uid = {$id}";
        $strUserInfo['reply_count'] = mysql_func($sql)[0]['count'];
        $data['strUserInfo'] = $strUserInfo;

        displayTpl('user/info', $data);
    }
}