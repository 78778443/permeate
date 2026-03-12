<?php

class post
{
    public function lists()
    {
        $page_size = 10;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_post where del=1";
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
        $sql = "select p.*,u.username from bbs_post as p,bbs_user as u where p.uid=u.id and p.del='1' " . $limit;
        $row1 = mysql_func($sql);
        $data['list'] = !empty($row1) ? $row1 : [];
        displayTpl('post/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $cid = intval($_POST['cid']);
            $ptime = $_SERVER['REQUEST_TIME'];
            $pip = ip2long($_SERVER['REMOTE_ADDR']);
            $uid = getAdminUid();

            $sql = "insert into bbs_post(title,content,cid,ptime,uid,pip) values('$title','$content','$cid','$ptime','$uid','$pip')";
            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('添加失败！')</script>";
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
        $page_size = 10;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_post where del=2";
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
        $sql = "select p.*,u.username from bbs_post as p,bbs_user as u where p.uid=u.id and p.del='2' " . $limit;
        $row = mysql_func($sql);
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('post/list_del', $data);
    }
}
