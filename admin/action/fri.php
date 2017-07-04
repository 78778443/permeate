<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class fri
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

        //开始分页大小
        $page_size = 5;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from " . DB_PRE . "user " . $where;
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
        displayTpl('fri/list');
    }

    public function add()
    {
        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
            $desc1 = $_POST['desc1'];
            $url = $_POST['url'];


            if (!empty($_FILES['pic']['name'])) {
                $data = upload($info, 'pic', '../resorce/images/fri');
                $pic = $data['newname'];
                $pic = suolue($pic, 50, 30, '../resorce/images/fri/');
                $sql = "insert into " . DB_PRE . "fri(title,desc1,url,pic) values('$title','$desc1','$url','$pic')";

            } else {
                $sql = "insert into " . DB_PRE . "fri(title,desc1,url) values('$title','$desc1','$url')";
            }

            $row = mysql_func($sql);


            if (!$row) {
                echo "<script>alert('抱歉！写入数据库失败，请稍后再试！')</script>";
                echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
                exit;
            }


            //header("location:list.php");
            echo "<script>window.location.href='./index.php?m=fri&a=lists'</script>";
            exit;
        }
        displayTpl('fri/add');
    }
}