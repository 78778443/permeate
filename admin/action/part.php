<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
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

        //开始分页大小
        $page_size = 5;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from bbs_part " . $where;
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

        $sql = "select * from bbs_part  " . $where . $limit;
        $row = mysql_func($sql);
        foreach($row as $k=>$v){
            //获取分区版主
            $sql = "select * from bbs_user where id=" . $v['padmins'];
            $row[$k]['username'] = mysql_func($sql)[0]['username'];
            //获取分区下板块数
            $sql = "select count(*) as cou from bbs_cate where pid='" . $v['id'] . "' group by pid";
            $row1 = mysql_func($sql)[0]['cou'];
            if (empty($cou)) {
                $row[$k]['cou'] = "0";
            }
        }
        $data['list'] = $row;
        displayTpl('part/list', $data);
    }

    public function add()
    {

        if (!empty($_POST['pname'])) {

            $pname = @$_POST['pname'];

            $padmins = @$_POST['padmins'];


            if (empty($padmins)) {
                $padmins = "6";
            }
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