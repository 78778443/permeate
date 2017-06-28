<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 21:40
 */
require_once __DIR__ . "/logic/userLogic.php";

class user
{
    public function getUserInfoByEmailOrPhone($param)
    {
        $result = false;
        //如果是邮箱
        if (filter_var($param, FILTER_VALIDATE_EMAIL)) {
            $result = $this->getUserInfoByEmail($param);
        } elseif (preg_match("/1\d{10}$/", $param)) {
            $result = $this->getUserInfoByPhone($param);
        }

        return $result;
    }

    public function getUserInfoByEmail($email)
    {
        $where['email'] = $email;
        return userLogic::getUserOne($where);
    }

    public function getUserInfoByPhone($phone)
    {
        $where['phone'] = $phone;
        return userLogic::getUserOne($where);
    }
}