<?php

class reply
{
    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where xx=1 and content like '%$keywords%' ";
        } else {
            $where = " where xx=1";
        }

        $page_size = 10;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_reply " . $where;
        $row = mysql_func($sql);
        $count = !empty($row[0]['c']) ? $row[0]['c'] : 0;

        $page_count = $count > 0 ? ceil($count / $page_size) : 1;

        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num >= $page_count) {
            $page_num = $page_count;
        }

        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
        $sql = "select * from bbs_reply" . $where . $limit;
        $row = mysql_func($sql);

        if (!empty($row)) {
            foreach ($row as $k => $v) {
                $sql = "select title,cid from bbs_post where id=" . intval($v['pid']);
                $postRow = mysql_func($sql);
                $row[$k]['post'] = !empty($postRow[0]) ? $postRow[0] : ['title' => '未知', 'cid' => 0];

                $sql = "select username from bbs_user where id=" . intval($v['uid']);
                $userRow = mysql_func($sql);
                $row[$k]['username'] = !empty($userRow[0]['username']) ? $userRow[0]['username'] : '未知';
            }
        }

        $data['list'] = !empty($row) ? $row : [];
        displayTpl('reply/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['pid'])) {
            $pid = intval($_POST['pid']);
            $content = $_POST['content'];
            $ptime = $_SERVER['REQUEST_TIME'];
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
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where xx=2 and content like '%$keywords%' ";
        } else {
            $where = " where xx=2";
        }

        $page_size = 10;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_reply " . $where;
        $row = mysql_func($sql);
        $count = !empty($row[0]['c']) ? $row[0]['c'] : 0;

        $page_count = $count > 0 ? ceil($count / $page_size) : 1;

        if ($page_num <= 0) {
            $page_num = 1;
        }
        if ($page_num >= $page_count) {
            $page_num = $page_count;
        }

        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;
        $sql = "select * from bbs_reply" . $where . $limit;
        $row = mysql_func($sql);

        if (!empty($row)) {
            foreach ($row as $k => $v) {
                $sql = "select title,cid from bbs_post where id=" . intval($v['pid']);
                $postRow = mysql_func($sql);
                $row[$k]['post'] = !empty($postRow[0]) ? $postRow[0] : ['title' => '未知', 'cid' => 0];

                $sql = "select username from bbs_user where id=" . intval($v['uid']);
                $userRow = mysql_func($sql);
                $row[$k]['username'] = !empty($userRow[0]['username']) ? $userRow[0]['username'] : '未知';
            }
        }

        $data['list'] = !empty($row) ? $row : [];
        displayTpl('reply/list_pb', $data);
    }
}
