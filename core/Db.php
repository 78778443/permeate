<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/16
 * Time: 21:46
 */
class Db
{
    /**
     * 通过数组生成SQL查询语句
     * @param $where
     * @return string
     */
    public static function createWhereStr($where)
    {
        $whereStr = '';

        foreach ($where as $key => $value) {
            $whereStr .= "$key='$value' and ";
        }

        $whereStr = trim($whereStr, 'and ');

        return $whereStr;
    }
}