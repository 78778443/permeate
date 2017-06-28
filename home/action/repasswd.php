<?php

class repasswd
{
    function __construct()
    {

    }

    /**
     * 找回密码
     */
    public function index()
    {
        displayTpl('repasswd/index');
    }

    public function _index()
    {
        //接收参数
        $username = getParam('username');
        $yzm = getParam('yzm');
        $preSrc = $_SERVER['HTTP_REFERER'];

        //判断验证码是否正确
//        if ($yzm != $_SESSION['yzm']) {
//            echo "<script>alert('图片验证码错误！')</script>";
//            echo "<script>window.location.href='$preSrc'</script>";
//        }

        $userInfo = NewService('user')->getUserInfoByEmail($username);
        if (empty($userInfo)) {
            errorView('用户信息没有找到！', '/home/index.php?m=repasswd');
        }

        //如果是邮箱
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $url = "/home/index.php?m=repasswd&a=email";
            header("Location: $url");
        } elseif (preg_match("/1\d{10}$/", $username)) {
            $url = "/home/index.php?m=repasswd&a=phone";
            header("Location: $url");
        } else {
            echo "<script>alert('邮箱或者手机号格式错误！')</script>";
            echo "<script>window.location.href='$preSrc'</script>";
        }
    }

    public function demo()
    {
        displayTpl('repasswd/demo');
    }

    public function email()
    {
        displayTpl('repasswd/email');
    }

    public function phone()
    {
        displayTpl('repasswd/phone');
    }

    public function newpasswd()
    {
        displayTpl('repasswd/newpasswd');
    }

    public function success()
    {
        displayTpl('repasswd/success');
    }
}
