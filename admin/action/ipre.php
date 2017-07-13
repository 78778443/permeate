<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 21:02
 */
class ipre
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
        $sql = "select count(*) as c from bbs_user " . $where;
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
        $limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;

        $sql = "select * from bbs_iprefuse" . $where . $limit;
        $row = mysql_func($sql);
        $data['list'] = $row;
        displayTpl('ipre/list',$data);
    }

    public function add()
    {

        displayTpl('ipre/add');
    }
}