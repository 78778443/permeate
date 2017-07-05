<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class cate
{
    public function lists()
    {
        $sql = "select c.*,p.pname from " . DB_PRE . "cate as c left join " . DB_PRE . "part as p on c.pid=p.id";
        $row = mysql_func($sql);
        foreach ($row as $k=>$cate) {
            $sql = "select username from " . DB_PRE . "user where id=" . $cate['uid'];
            $row[$k]['username'] = mysql_func($sql)[0]['username'];
        }
        $data['list'] = $row;
        displayTpl('cate/list',$data);
    }

    public function add()
    {
        if (!empty($_POST['cname'])) {
            $pid = $_POST['pid'];
            $cname = $_POST['cname'];

            $sql = "insert into " . DB_PRE . "cate(pid,cname) values('$pid','$cname')";
            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('xxxxx')</script>";
                echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
                exit;
            }

            echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";

            exit;
        }
        displayTpl('cate/add');
    }
}