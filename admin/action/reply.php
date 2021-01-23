<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class reply
{
    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where xx=1 id like '%$keywords%' ";
            $link = "&keywords=" . $keywords;
        } else {
            $where = " where xx=1";
            $link = "";
        }

        //开始分页大小
        $page_size = 5;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from bbs_reply " . $where;
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
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;

        $sql = "select * from bbs_reply" . $where . $limit;
        $row = mysql_func($sql);
        foreach ($row as $k => $v) {
            $sql = "select title from bbs_post where id=" . $v['pid'];
            $row[$k]['post'] = mysql_func($sql)[0];

            $sql = "select username from bbs_user where '" . $v['pid'] . "'";
            $row[$k]['username'] = mysql_func($sql)[0]['username'];
        }
        $data['list'] = $row;
        displayTpl('reply/list', $data);
    }

    public function add()
    {

        if (!empty($_POST['pid'])) {
            $pid = @$_POST['pid'];
            $content = @$_POST['content'];
            $ptime = @$_SERVER['REQUEST_TIME'];
            $pip = ip2long($_SERVER['REMOTE_ADDR']);
            $uid = getAdminUid();
            $sql = "insert into bbs_reply(pid,content,uid,ptime,pip) values('$pid','$content',$uid,'$ptime','$pip')";
            $row = mysql_func($sql);
            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
                exit;
            }
            echo "<script>window.location.href='./index.php?m=reply&a=lists'</script>";
            exit;
        }
        displayTpl('reply/add');
    }

    public function list_pb()
    {
        $keywords = !empty(@$_GET['keywords']) ? @$_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where xx=2 id like '%$keywords%' ";
            $link = "&keywords=" . $keywords;
        } else {
            $where = " where xx=2";
            $link = "";
        }

        //开始分页大小
        $page_size = 5;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from bbs_reply " . $where;
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
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;

        $sql = "select * from bbs_reply" . $where . $limit;
        $row = mysql_func($sql);
        foreach ($row as $k => $v) {
            $sql = "select title from bbs_post where id=" . $v['pid'];
            $row[$k]['post'] = mysql_func($sql)[0];

            $sql = "select username from bbs_user where '" . $v['pid'] . "'";
            $row[$k]['username'] = mysql_func($sql)[0]['username'];
        }
        $data['list'] = $row;
        displayTpl('reply/list_pb',$data);
    }
}