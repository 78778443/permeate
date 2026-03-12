<?php

class cate
{
    public function lists()
    {
        $sql = "select c.*,p.pname from bbs_cate as c left join bbs_part as p on c.pid=p.id";
        $row = mysql_func($sql);
        foreach ($row as $k => $cate) {
            $sql = "select username from bbs_user where id=" . intval($cate['uid']);
            $userRow = mysql_func($sql);
            $row[$k]['username'] = !empty($userRow[0]['username']) ? $userRow[0]['username'] : '未知';
        }
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('cate/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['cname'])) {
            $pid = intval($_POST['pid']);
            $cname = $_POST['cname'];

            $sql = "insert into bbs_cate(pid,cname) values('$pid','$cname')";
            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('添加失败！')</script>";
                echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
                exit;
            }

            echo "<script>window.location.href='./index.php?m=cate&a=lists'</script>";
            exit;
        }
        displayTpl('cate/add');
    }
}
