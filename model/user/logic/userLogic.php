<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 21:42
 */
class userLogic
{

    public static function getUserOne($where)
    {
        $result = self::getUserList($where);

        return !empty($result[0]) ? $result[0] : false;
    }

    public static function getUserList($where, $sort = [], $limit = [])
    {
        $strWhere = Db::createWhereStr($where);

        $sql = "select * from bbs_user WHERE $strWhere";
        $row = mysql_func($sql);

        return !empty($row) ? $row : [];
    }
}