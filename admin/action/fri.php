<?php

class fri
{
    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where title like '%$keywords%' ";
        } else {
            $where = "";
        }

        $page_size = 20;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_fri " . $where;
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
        $sql = "select * from bbs_fri" . $where . $limit;
        $row = mysql_func($sql);
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('fri/list', $data);
    }

    public function add()
    {
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $desc1 = $_POST['desc1'];
            $url = $_POST['url'];

            if (!empty($_FILES['pic']['name'])) {
                $data = upload($info, 'pic', '../resources/images/fri');
                $pic = $data['newname'];
                $pic = suolue($pic, 50, 30, '../resources/images/fri/');
                $sql = "insert into bbs_fri(title,desc1,url,pic) values('$title','$desc1','$url','$pic')";
            } else {
                $sql = "insert into bbs_fri(title,desc1,url) values('$title','$desc1','$url')";
            }

            $row = mysql_func($sql);

            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
                exit;
            }

            echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
            exit;
        }
        displayTpl('fri/add');
    }
}
