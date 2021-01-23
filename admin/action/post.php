<?php

class post
{
    function __construct()
    {

    }

    public function lists()
    {
        //开始分页大小
        $page_size = 5;
        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];
        //计算记录总数
        $sql = "select count(*) as c from bbs_post where del=1";
        //echo $sql;
        $row = mysql_func($sql);
        $count = $row[0]['c'];
        //计算记录总页数
        $page_count = ceil($count / $page_size);
        //防止越界
        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num >= $page_count) {
            $page_num = $page_count;
        }
        //准备SQL语句
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
        $sql = "select p.*,u.username from bbs_post as p,bbs_user as u where p.uid=u.id and p.del='1' " . $limit;
        $row1 = mysql_func($sql);
        $data['list'] = $row1;
        displayTpl('post/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $cid = $_POST['cid'];
            $ptime = $_SERVER['REQUEST_TIME'];
            $pip = ip2long($_SERVER['REMOTE_ADDR']);
            $uid = getAdminUid();

            $sql = "insert into bbs_post(title,content,cid,ptime,uid,pip) values('$title','$content','$cid','$ptime','$uid','$pip')";

            $row = mysql_func($sql);


            if (!$row) {
                echo "<script>window.location.href='./index.php?m=post&a=lists'</script>";
                exit;
            }

            echo "<script>window.location.href='./index.php?m=post&a=lists'</script>";
            exit;
        }
        displayTpl('post/add');
    }

    public function list_del()
    {
        //开始分页大小
        $page_size = 5;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $where = "where del=2";
        $sql = "select count(*) as c from bbs_post " . $where;

        $row = mysql_func($sql);

        $count = $row[0]['c'];

        //计算记录总页数
        $page_count = ceil($count / $page_size);

        //防止越界
        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num <= $page_count) {
            $page_num = $page_count;
        }

        //准备SQL语句
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;

        $sql = "select p.*,u.username from bbs_post as p,bbs_user as u where p.uid=u.id and p.del='2' " . $limit;
        $row = mysql_func($sql);
        $data['list'] = $row;
        displayTpl('post/list_del', $data);
    }
}

