<?php
function mysql_func($sql)
{
    error_reporting(0);
    //1.连接数据库
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASS);

    //2.判断是否连接成功
    if (mysql_errno()) {
        exit('数据库连接失败:' . mysql_error());
    }

    //3.选择数据库
    mysql_select_db(DB_NAME);

    //4.设置字符集
    mysql_set_charset('utf8');

    //5.判断SQL语句是增删改查的哪一种
    $action = substr($sql, 0, strpos($sql, ' '));


    //6.发送sql语句
    $res = mysql_query($sql);


    //7.处理结果集
    switch ($action) {
        //插入返回主键ID
        case 'insert':
            if ($res && Mysql_affected_rows()) {
                $result = Mysql_insert_id();
            } else {
                return false;
            }
            break;

        //删除和修改返回 受影响的记录条数
        case 'craate':
        case 'delete':
        case 'update':
            if ($res !== false) {
                $result = Mysql_affected_rows();
            } else {
                return false;
            }
            break;
        //查询返回二维数组
        case 'select':
            if ($res !== false) {
                while ($row = Mysql_fetch_assoc($res)) {
                    $result[] = $row;
                }
            } else {
                return false;
            }
            break;
        default:
            return "错误";
    }
    //8.释放结果集，关闭数据库连接
    mysql_close($link);
    return $result;
}
	