<?php

class fil
{
    public function lists()
    {
        $page_size = 20;
        $page_num = empty($_GET['page']) ? 1 : intval($_GET['page']);

        $sql = "select count(*) as c from bbs_fil";
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
        $sql = "select * from bbs_fil" . $limit;
        $row = mysql_func($sql);
        $data['list'] = !empty($row) ? $row : [];
        displayTpl('fil/list', $data);
    }

    public function add()
    {
        displayTpl('fil/add');
    }
}
