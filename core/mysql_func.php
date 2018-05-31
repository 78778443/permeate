<?php
function mysql_func($sql)
{
    error_reporting(0);
    //1.连接数据库
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS);

    //2.判断是否连接成功
    if (mysqli_errno($link)) {
        exit('数据库连接失败:' . mysqli_error($link));
    }

    //3.选择数据库
    mysqli_select_db($link, DB_NAME);

    //4.设置字符集
    mysqli_set_charset($link, 'utf8');

    //5.判断SQL语句是增删改查的哪一种
    $action = substr($sql, 0, strpos($sql, ' '));


    //6.发送sql语句
    $res = mysqli_query($link, $sql);


    //7.处理结果集
    switch ($action) {
        //插入返回主键ID
        case 'insert':
        case 'INSERT':
            if ($res && mysqli_affected_rows($link)) {
                $result = mysqli_insert_id($link);
            } else {
                return false;
            }
            break;
        //删除和修改返回 受影响的记录条数
        case 'craate':
        case 'CREATE':
        case 'delete':
        case 'DELETE':
        case 'update':
        case 'UPDATE':
            if ($res !== false) {
                $result = mysqli_affected_rows($link);
            } else {
                return false;
            }
            break;
        //查询返回二维数组
        case 'select':
        case 'SELECT':
            if ($res !== false) {
                while ($row = mysqli_fetch_assoc($res)) {
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
    mysqli_close($link);
    return $result;
}
	