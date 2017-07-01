<?php

class user
{
    function __construct(){

    }

    public function login()
    {
        displayTpl('user/login');
    }


    public function logout()
    {
        unset($_SESSION['home']['username']);
        setcookie('adminusername','',time()-1,'/');
        session_destroy();
        header("location:../index.php");
    }

}

