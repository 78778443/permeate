<?php

class part
{
    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where id like '%$keywords%' ";
            $link = "&keywords=" . $keywords;
        } else {
            $where = "";
            $link = "";
        }

        $page_size = 5;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_part " . $where;
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

        $sql = "select * from bbs_part " . $where . $limit;
        $row = mysql_func($sql);

        if (!empty($row)) {
            foreach ($row as $k => $v) {
                $sql = "select username from bbs_user where id=" . intval($v['padmins']);
                $userRow = mysql_func($sql);
                $row[$k]['username'] = !empty($userRow[0]['username']) ? $userRow[0]['username'] : '未知';

                $sql = "select count(*) as cou from bbs_cate where pid='" . $v['id'] . "' group by pid";
                $cateRow = mysql_func($sql);
                $row[$k]['cou'] = !empty($cateRow[0]['cou']) ? $cateRow[0]['cou'] : 0;
            }
        }

        $data['list'] = !empty($row) ? $row : [];
        displayTpl('part/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['pname'])) {
            $pname = $_POST['pname'];
            $padmins = !empty($_POST['padmins']) ? intval($_POST['padmins']) : 6;

            $sql = "insert into bbs_part(pname,padmins) values('$pname','$padmins')";
            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=part&a=lists'</script>";
                exit;
            }

            echo "<script>window.location.href='./index.php?m=part&a=lists'</script>";
            exit;
        }
        displayTpl('part/add');
    }
}
