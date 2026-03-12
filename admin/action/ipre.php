<?php

class ipre
{
    public function lists()
    {
        $keywords = !empty($_GET['keywords']) ? $_GET['keywords'] : '';
        if (!empty($keywords)) {
            $where = " where id like '%$keywords%' ";
        } else {
            $where = "";
        }

        $page_size = 20;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_iprefuse " . $where;
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
        $sql = "select * from bbs_iprefuse" . $where . $limit;
        $row = mysql_func($sql);
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('ipre/list', $data);
    }

    public function add()
    {
        displayTpl('ipre/add');
    }
}
