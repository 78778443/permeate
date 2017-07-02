<?php

class tiezi
{
    function __construct()
    {

    }
	
	public function index(){
		$id = $_GET['bk'];
		$bk = &$id;
		if (empty($id)) {
			exit ("参数错误！");
		}

			//开始分页大小
		$page_size = 5;

		//获取当前页码
		$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

		//计算记录总数
		$sql = "select count(*) as c from " . DB_PRE . "post where cid='$bk'";
		$row = mysql_func($sql);
		$count = $row[0]['c'];

		//计算记录总页数
		$page_count = ceil($count / $page_size);
		//防止越界
		if ($page_num >= $page_count) {
			$page_num = $page_count;
		}

		if ($page_num <= 0) {
			$page_num = 1;
		}

		//准备SQL语句
		$limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;

		$sql = "select p.*,u.username from " . DB_PRE . "post as p," . DB_PRE . "user as u where  p.cid=" . $id . " and u.id=p.uid and p.cid='$bk'" . $limit;
		//$sql = "select * from ".DB_PRE."post where cid='$bk'".$limit;
		//$sql = "select * from ".DB_PRE."post where cid='2'";
		$row = mysql_func($sql);
		foreach ($row as $k=>$post) {
			$reply_count_sql = "select count(id) as count from bbs_reply where pid={$post['id']} ";
			$row[$k]['reply_count'] = mysql_func($reply_count_sql)[0]['count'];
	
		}
		$data['row'] = $row;
		$data['bk'] = $bk;
		$data['count'] = $count;
		$data['page_size'] = $page_size;
		$data['page_count'] = $page_count;
		$data['page_num'] = $page_num;
		displayTpl('tiezi/index',$data);
	}
	
	public function detail(){
		$zt = $_GET['zt'];
		if (empty($zt)) {
			exit ("参数1错误！");
		}
		$bk = $_GET['bk'];
		if (empty($bk)) {
			exit ("参数2错误！");
		}
		$sql = "select p.*,u.*,d.* from " . DB_PRE . "post as p," . DB_PRE . "user as u," . DB_PRE . "user_detail as d where p.uid=u.id and d.uid=p.uid and p.id='$zt'";
        $row = mysql_func($sql);
        $post = $row[0];
		$reply_count_sql = "select count(id) as count from bbs_reply where pid={$zt} ";
		$post['reply_count'] = mysql_func($reply_count_sql)[0]['count'];
		
		//开始分页大小
		$page_size = 5;

		//获取当前页码
		$page_num = empty($_GET['page']) ? 1 : $_GET['page'];

		//计算记录总数
		$sql = "select count(*) as c from " . DB_PRE . "reply ";
		$row = mysql_func($sql);
		$count = $row[0]['c'];

		//计算记录总页数
		$page_count = ceil($count / $page_size);
		//防止越界
		if ($page_num >= $page_count) {
			$page_num = $page_count;
		}
		if ($page_num <= 0) {
			$page_num = 1;
		}


		//准备SQL语句
		$limit = " limit " . (($page_num - 1) * $page_size) . "," . $page_size;;
		$sql = "select r.*,u.*,d.* from " . DB_PRE . "reply as r," . DB_PRE . "user as u," . DB_PRE . "user_detail as d where r.uid=u.id and d.uid=r.uid and r.pid='$zt'" . $limit;
        $row = mysql_func($sql);
			
		$data['bk'] = $bk;
		$data['zt'] = $zt;
		$data['post'] = $post;
		$data['row'] = $row;
		$data['count'] = $count;
		$data['page_size'] = $page_size;
		$data['page_count'] = $page_count;
		$data['page_num'] = $page_num;
		displayTpl('tiezi/detail',$data);
	}
}