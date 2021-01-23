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

    public function register()
    {
        displayTpl('user/register');
    }


    public function logout()
    {
        unsetUser();
        setcookie('adminusername', '', time() - 1, '/');
        session_destroy();
        header("location:../index.php");
    }

    public function individual()
    {
        $user = getCurrentUser();
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
        $user = getCurrentUser();
        if (empty($user)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }

        $data = ['edu' => $edu, 'sex' => $sex, 'user' => $user];
        displayTpl('user/basic', $data);
    }

    public function safe()
    {
        $data = ['user' => getCurrentUser()];

        displayTpl('user/safe', $data);
    }

    /**
     * 用户上传头像
     */
    public function _upload_user_touxiang()
    {
        $ROOTPATH = $_SERVER['DOCUMENT_ROOT'];
        require_once "../core/upload_func.php";
        require_once "../core/image_func.php";
        $user = getCurrentUser();
        $data = upload($info, 'pic', '/resources/images/userhead');

        $pic = $data['newname'];
        if (!empty($pic)) {
            $newpic = suolue($pic, 200, 200, $ROOTPATH . '/resources/images/userhead/');
            $picm = suolue($pic, 100, 100, $ROOTPATH . '/resources/images/userhead/');
            $pics = suolue($pic, 48, 48, $ROOTPATH . '/resources/images/userhead/');
            $sql = "update bbs_user_detail set pic='$newpic',picm='$picm',pics='$pics' where uid='{$user['id']}'";
            $row = mysql_func($sql);
        }

        if (!$row) {
            echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
            echo "<script>window.location.href='/home/index.php?m=user&a=individual'</script>";
            exit;
        }
        $sql = "SELECT u.*,d.* FROM bbs_user AS u,bbs_user_detail AS d WHERE d.uid=u.id AND u.username='" . $user['username'] . "' AND u.password='" . $user['password'] . "'";
        //echo $sql;
        $row = mysql_func($sql);
        //var_dump($row);
        if (!$row) {
            echo "<script>window.location.href='/home/index.php?m=user&a=individual'</script>";
            exit;
        }

        //session的写入直接去给$_SESSION赋值
        saveCurrentUser($row[0]);
        //告诉浏览器将保存sessionid的cookie文件保存一个小时
        setcookie(session_name(), session_id(), time() + 3600, "/");

        echo "<script>alert('修改成功');history.go(-1);</script>";
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
        $user = $this->getUserInfo();


        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',telphone='$telphone',qq='$qq',email='$email' where uid=" . $user['id'];


        $row = mysql_func($sql);

        if (!$row) {
            echo "<script>alert('你没有修改，或修改失败')</script>";
            echo "<script>window.location.href='/home/'</script>";
            exit;
        }

        echo "<script>alert('修改成功！')</script>";

        $sql = "SELECT u.*,p.* FROM bbs_user AS u,bbs_user_detail AS p WHERE p.uid = u.id and u.id=" . $user['id'];

        $row = mysql_func($sql);

        if (!$row) {
            echo "<script>alert('请重新登入')</script>";
            echo "<script>window.location.href='/home/'</script>";
            exit;
        }
        $username = $row[0];
        //执行登陆操作
        //session的写入直接去给$_SESSION赋值
        saveCurrentUser($username);
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
        $user = $this->getUserInfo();

        $sql = "select * from bbs_user where password='$oldpassword' and id='" . $user['id'] . "'";

        $row = mysql_func($sql);
        if (!$row) {
            echo "<script>alert('请输入正确的当前密码！')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }

        $sql = "update bbs_user set password='$newpassword' where id='" . $user['id'] . "'";

        $row = mysql_func($sql);
        if (!$row) {
            echo "<script>alert('抱歉,密码修改失败.')</script>";
            echo "<script>window.location.href='/'</script>";
            exit;
        }

        unsetUser();
        setcookie(time() - 1, '/');
        echo "<script>alert('你的密码修改成功,请用新的密码登入.')</script>";
        echo "<script>window.location.href='/'</script>";

    }

    public function info()
    {
        $userInfo = getCurrentUser();
        $id = !empty($_GET['id']) ? $_GET['id'] : $userInfo['id'];
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
        //用户关注数
        $sql = "select count(id) as count from bbs_home_follow  where followuid={$id}";
        $strUserInfo['follow_count'] = mysql_func($sql)[0]['count'];
        $data['strUserInfo'] = $strUserInfo;

        displayTpl('user/info', $data);
    }

    /**
     * 关注用户
     */
    public function follow()
    {
        $uid = intval($_GET['uid']);
        $followuid = isLogin();
        if ($uid == $followuid) {
            echo "<script>alert('自己不能关注自己')</script>";
            echo "<script>window.history.go(-1);</script>";
            exit;
        }
        $sql = "SELECT id,username FROM bbs_user WHERE id = $uid";
        $user = mysql_func($sql);

        $sql = "SELECT id,username FROM bbs_user WHERE id = $followuid";
        $follow_user = mysql_func($sql)[0];
        if (!$user || !$follow_user) {
            echo "<script>alert('用户不存在')</script>";
            echo "<script>window.history.go(-1);</script>";
            exit;
        }
        $sql = "select id,mutual,uid,followuid from bbs_home_follow where (uid={$uid} and followuid={$followuid} or uid={$followuid} and followuid={$uid}) and status != -1";
        $follow_data = mysql_func($sql)[0];
        if ($follow_data) {//已关注
            if ($follow_data['mutual'] || $follow_data['followuid'] == $followuid) {//已互相关注
                echo "<script>alert('请勿重复关注')</script>";
                echo "<script>window.history.go(-1);</script>";
                exit;
            } else {//本次互相关注
                $sql = "UPDATE bbs_home_follow SET mutual=1 WHERE id=" . $follow_data['id'];
                $res = mysql_func($sql);
            }
        } else {//新关注
            $sql = "insert into bbs_home_follow(id,uid,username,followuid,fusername,status,mutual,uptiem) value(0,'$uid','" . $user['username'] . "','$followuid','{$follow_user['username']}','0',0,'" . time() . "')";
            $res = mysql_func($sql);
        }
        if ($res) {
            echo "<script>alert('关注成功')</script>";
            echo "<script>window.history.go(-1);</script>";
            exit;
        } else {
            echo "<script>alert('关注失败，请稍候重试')</script>";
            echo "<script>window.history.go(-1);</script>";
            exit;
        }
    }


    private function getUserInfo()
    {
        $user = false;
        $uid = getParam('uid');
        if ($uid) {
            $sql = "select * from bbs_user where id = $uid";
            $userList = mysql_func($sql);
            $user = $userList[0];
        }
        if (empty($user)) {
            $user = getCurrentUser();
        }


        return $user;
    }

    //输入邮箱页面
    public function re_passwd_step1()
    {
        displayTpl('user/re_passwd_step1');
    }

    //提示提交成功页面
    public function re_passwd_step2()
    {
        displayTpl('user/re_passwd_step2');
    }

    //修改密码页面
    public function re_passwd_step3()
    {
        displayTpl('user/re_passwd_step3');
    }

    //修改密码成功页面
    public function re_passwd_step4()
    {
        displayTpl('user/re_passwd_step4');
    }


    //发送邮件
    public function _re_passwd_step1()
    {
        $email = getParam('email');

        //写入token到session
        $token = md5(time());
        $_SESSION[$token] = $email;

        //发送邮件
        $uri = U('user/re_passwd_step3');
        $content = <<<data

你好，这是<a = "http://{$_SERVER['SERVER_NAME']}{$uri}">找回密码的链接,链接15分钟有效，请不要告诉他人！
    
data;
        var_dump($content);
        die;


        sendEmail($email, $content);

    }


    //修改密码
    public function _re_passwd_step3()
    {
        //接收参数
        $email = getParam('email');
        $password = getParam('password');
        $repassword = getParam('repassword');
        $verifyCode = getParam('code');


        //进行安全验证
        if (!empty($_SESSION[$verifyCode]) && $_SESSION[$verifyCode] != $email) {
            die('请求不合法');
        }
        if ($password != $repassword) {
            die('两次密码不一致');
        }

        //修改密码
        $password = md5($password);
        $sql = "update bbs_user  set password='$password' where email='{$email}'";

        $result = mysql_func($sql);
        if ($result) {
            $url = U('user/login');
            header("location:$url");
        }

    }
}