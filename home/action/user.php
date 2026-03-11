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
        $currentUser = getCurrentUser();
        if (empty($currentUser)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }

        // 越权漏洞：如果传入uid参数，可以查看/编辑其他用户的资料
        // 漏洞利用：?m=user&a=basic&uid=1 (修改uid为其他用户ID)
        $uid = isset($_GET['uid']) ? $_GET['uid'] : $currentUser['id'];

        // 漏洞：未验证当前用户是否有权限修改该uid的用户资料
        $sql = "SELECT u.*, d.* FROM bbs_user u LEFT JOIN bbs_user_detail d ON u.id=d.uid WHERE u.id={$uid}";
        $result = mysql_func($sql);
        $user = $result ? $result[0] : $currentUser;

        $data = ['edu' => $edu, 'sex' => $sex, 'user' => $user];
        displayTpl('user/basic', $data);
    }

    public function safe()
    {
        $data = ['user' => getCurrentUser()];

        displayTpl('user/safe', $data);
    }

    /**
     * 远程头像设置页面 - SSRF漏洞入口
     */
    public function avatar_remote()
    {
        $user = getCurrentUser();
        if (empty($user)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }
        $data['user'] = $user;
        displayTpl('user/avatar_remote', $data);
    }

    /**
     * SSRF漏洞：远程头像获取
     * 漏洞利用：url=http://127.0.0.1:6379/ (探测内网Redis)
     *          url=http://169.254.169.254/latest/meta-data/ (AWS元数据)
     *          url=file:///etc/passwd (读取本地文件)
     */
    public function _set_remote_avatar()
    {
        $user = getCurrentUser();
        if (empty($user)) {
            echo "<script>alert('请先登录');window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }

        $url = isset($_POST['avatar_url']) ? $_POST['avatar_url'] : '';

        if (empty($url)) {
            echo "<script>alert('请输入头像URL');history.go(-1);</script>";
            exit;
        }

        // 漏洞代码：未对URL进行任何过滤，允许访问任意协议和地址
        // 支持 http://, https://, file://, gopher://, dict:// 等协议

        $ch = curl_init();

        // 漏洞配置：允许访问任意协议
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // 危险：不验证SSL证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // 危险：允许所有协议
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_ALL);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($error) {
            echo "<script>alert('获取头像失败: " . addslashes($error) . "');history.go(-1);</script>";
            exit;
        }

        // 如果获取成功，尝试保存为头像
        $content_type = isset($info['content_type']) ? $info['content_type'] : '';
        $save_path = $_SERVER['DOCUMENT_ROOT'] . '/resources/images/userhead/';
        $filename = uniqid() . '.jpg';
        $full_path = $save_path . $filename;

        // 保存文件
        file_put_contents($full_path, $response);

        // 更新数据库
        $pic_url = '/resources/images/userhead/' . $filename;
        $sql = "update bbs_user_detail set pic='$pic_url' where uid='{$user['id']}'";
        mysql_func($sql);

        // 更新session
        $user['pic'] = $pic_url;
        saveCurrentUser($user);

        echo "<script>alert('头像设置成功！');window.location.href='/home/index.php?m=user&a=individual'</script>";
    }

    /**
     * 文件上传页面入口
     */
    public function upload_file()
    {
        $user = getCurrentUser();
        if (empty($user)) {
            echo "<script>window.location.href='/home/index.php?m=user&a=login'</script>";
            exit;
        }
        $data['user'] = $user;
        displayTpl('user/upload_vuln', $data);
    }

    /**
     * 文件上传漏洞：多种绕过方式
     * 漏洞1：MIME类型验证可绕过（修改Content-Type为image/jpeg）
     * 漏洞2：黑名单不完整（允许.php3, .php5, .phtml, .phar等）
     * 漏洞3：未重命名文件（保留原始文件名）
     */
    public function _upload_file()
    {
        $user = getCurrentUser();
        if (empty($user)) {
            echo "<script>alert('请先登录');history.go(-1);</script>";
            exit;
        }

        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo "<script>alert('请选择要上传的文件');history.go(-1);</script>";
            exit;
        }

        $file = $_FILES['file'];
        $filename = $file['name'];
        $tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_type = $file['type']; // MIME类型，可被客户端修改

        // 漏洞1：仅通过MIME类型验证，可被绕过
        $allowed_mime = ['image/jpeg', 'image/png', 'image/gif', 'text/plain', 'application/pdf'];
        if (!in_array($file_type, $allowed_mime)) {
            echo "<script>alert('不允许上传此类型的文件（MIME验证失败）');history.go(-1);</script>";
            exit;
        }

        // 获取文件后缀
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        // 漏洞2：黑名单不完整，可使用.php3, .php5, .phtml, .phar, .php.jpg等绕过
        $blacklist = ['php', 'asp', 'aspx', 'jsp', 'exe', 'bat', 'cmd', 'sh'];
        if (in_array($ext, $blacklist)) {
            echo "<script>alert('不允许上传此类型的文件（黑名单验证失败）');history.go(-1);</script>";
            exit;
        }

        // 漏洞3：未对文件内容进行检测
        // 漏洞4：未重命名文件，保留原始文件名
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // 危险：直接使用原始文件名
        $destination = $upload_dir . $filename;

        if (move_uploaded_file($tmp_name, $destination)) {
            echo "<script>alert('文件上传成功！');window.location.href='/home/index.php?m=user&a=upload_file'</script>";
        } else {
            echo "<script>alert('文件上传失败');history.go(-1);</script>";
        }
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

        // 越权漏洞：从POST参数获取uid，未验证是否有权限修改该用户
        // 漏洞利用：修改表单中的隐藏字段uid为其他用户ID
        $uid = isset($_POST['uid']) ? $_POST['uid'] : '';

        // 如果没有uid参数，使用当前登录用户
        if (empty($uid)) {
            $user = getCurrentUser();
            $uid = $user['id'];
        }

        // 漏洞：未验证当前用户是否有权限修改该uid的用户
        $sql = "update bbs_user_detail set t_name='$t_name',age='$age',sex='$sex',edu='$edu',signed='$signed',telphone='$telphone',qq='$qq',email='$email' where uid=" . $uid;


        $row = mysql_func($sql);

        echo "<script>alert('修改成功！');</script>";

        // 刷新当前用户session
        $currentUser = getCurrentUser();
        $sql = "SELECT u.*,p.* FROM bbs_user AS u,bbs_user_detail AS p WHERE p.uid = u.id and u.id=" . $currentUser['id'];
        $row = mysql_func($sql);
        if ($row) {
            saveCurrentUser($row[0]);
        }

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


    //发送重置密码邮件
    public function _re_passwd_step1()
    {
        $email = getParam('email');
        $captcha = getParam('captcha');

        // 漏洞1：验证码验证被注释掉，可绕过
        // 原本应该验证验证码，但被注释了
        // if (empty($captcha) || $captcha != $_SESSION['yzm']) {
        //     echo "<script>alert('验证码错误');history.go(-1);</script>";
        //     exit;
        // }

        // 检查邮箱是否存在
        $sql = "SELECT * FROM bbs_user WHERE email='{$email}'";
        $user = mysql_func($sql);
        if (!$user) {
            echo "<script>alert('该邮箱未注册');history.go(-1);</script>";
            exit;
        }

        // 漏洞2：Token可预测，使用时间戳MD5
        $token = md5(time());
        $_SESSION[$token] = $email;

        // 显示重置链接（实际环境中应该发送邮件）
        $reset_url = "http://{$_SERVER['SERVER_NAME']}/home/index.php?m=user&a=re_passwd_step3&email=" . urlencode($email) . "&code={$token}";

        echo "<div style='padding:50px;text-align:center;'>";
        echo "<h3>密码重置链接已生成</h3>";
        echo "<p>邮箱：{$email}</p>";
        echo "<p>Token：{$token}</p>";
        echo "<p><a href='{$reset_url}'>点击此处重置密码</a></p>";
        echo "<p class='text-muted'>注意：Token使用时间戳MD5生成，可预测！</p>";
        echo "</div>";
    }


    //重置密码处理
    public function _re_passwd_step3()
    {
        //接收参数
        $email = getParam('email');
        $password = getParam('password');
        $repassword = getParam('repassword');
        $verifyCode = getParam('code');

        // 漏洞3：Token验证逻辑缺陷
        // 如果传入空的code参数，$_SESSION[$verifyCode]为空，条件为false，不会die
        // 利用方式：直接访问 ?m=user&a=re_passwd_step3&email=target@example.com&code=
        if (!empty($_SESSION[$verifyCode]) && $_SESSION[$verifyCode] != $email) {
            die('请求不合法');
        }

        if ($password != $repassword) {
            die('两次密码不一致');
        }

        if (empty($password)) {
            die('密码不能为空');
        }

        // 漏洞4：可通过email参数修改任意用户密码
        // 修改密码
        $password = md5($password);
        $sql = "update bbs_user set password='$password' where email='{$email}'";

        $result = mysql_func($sql);
        if ($result) {
            // 清除token
            unset($_SESSION[$verifyCode]);
            echo "<script>alert('密码重置成功，请使用新密码登录');window.location.href='/home/index.php?m=user&a=login'</script>";
        } else {
            echo "<script>alert('密码重置失败，请检查邮箱是否正确');history.go(-1);</script>";
        }
    }
}