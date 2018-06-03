<?php

class tiezi
{
    function __construct()
    {

    }

    public function index()
    {
        $id = $_GET['bk'];
        $bk = &$id;
        if (empty($id)) {
            exit ("参数错误！");
        }

        //开始分页大小
        $page_size = 15;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "select count(*) as c from bbs_post where cid='$bk'";
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

        $sql = "select p.*,u.username from bbs_post as p,bbs_user as u where  p.cid=" . $id . " and u.id=p.uid and p.cid='$bk'" . $limit;
        //$sql = "select * from bbs_post where cid='$bk'".$limit;
        //$sql = "select * from bbs_post where cid='2'";
        $row = mysql_func($sql);
        foreach ($row as $k => $post) {
            $reply_count_sql = "select count(id) as count from bbs_reply where pid={$post['id']} ";
            $row[$k]['reply_count'] = mysql_func($reply_count_sql)[0]['count'];

        }
        $data['row'] = $row;
        $data['bk'] = $bk;
        $data['count'] = $count;
        $data['page_size'] = $page_size;
        $data['page_count'] = $page_count;
        $data['page_num'] = $page_num;
        displayTpl('tiezi/index', $data);
    }

    public function detail()
    {
        $zt = $_GET['zt'];
        if (empty($zt)) {
            exit ("参数1错误！");
        }
        $bk = $_GET['bk'];
        if (empty($bk)) {
            exit ("参数2错误！");
        }
        $sql = "select p.*,u.*,d.* from bbs_post as p,bbs_user as u,bbs_user_detail as d where p.uid=u.id and d.uid=p.uid and p.id='$zt'";
        $row = mysql_func($sql);
        $post = $row[0];
        $reply_count_sql = "select count(id) as count from bbs_reply where pid={$zt} ";
        $post['reply_count'] = mysql_func($reply_count_sql)[0]['count'];
        $post['content'] = html_entity_decode($post['content']);


        //开始分页大小
        $page_size = 15;

        //获取当前页码
        $page_num = empty($_GET['page']) ? 1 : $_GET['page'];

        //计算记录总数
        $sql = "SELECT count(*) AS c FROM bbs_reply where pid=$zt";
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
        $sql = "select r.*,u.*,d.* from bbs_reply as r,bbs_user as u,bbs_user_detail as d where r.uid=u.id and d.uid=r.uid and r.pid='$zt'" . $limit;
        $row = mysql_func($sql);


        //次数+1

        $sql = "update bbs_post set view_count=(view_count+1) where id=$zt";
        mysql_func($sql);


        $data['bk'] = $bk;
        $data['zt'] = $zt;
        $data['post'] = $post;
        $data['row'] = $row;
        $data['count'] = $count;
        $data['page_size'] = $page_size;
        $data['page_count'] = $page_count;
        $data['page_num'] = $page_num;
        displayTpl('tiezi/detail', $data);
    }


    public function reply()
    {
        if (!isset($_GET['bk'])) {
            exit ("参数错误！");
        }
        if (!isset($_GET['zt'])) {
            exit ("参数错误！");
        }
        $bk = $_GET['bk'];
        $zt = $_GET['zt'];

        $pid = getParam('id');
        $content = getParam('editorValue');
        $username = $_SESSION['home']['username'];
        $ptime = $_SERVER['REQUEST_TIME'];
        $pip = intval(ip2long($_SERVER['REMOTE_ADDR']));


        $sql = "SELECT * FROM bbs_iprefuse";
        $row = mysql_func($sql);
        foreach ($row as $ip) {
            if ($pip >= $ip['ipmin'] && $pip <= $ip['ipmax']) {
                echo "<script>alert('你所在的IP已被禁止发帖！')</script>";
                echo "<script>window.location.href='post.php?bk=" . $bk . "&zt=" . $zt . "'</script>";
                exit;
            }
        }

        $sql = "SELECT u.id,u.username FROM bbs_user AS u WHERE username='" . $username['username'] . "'";
        $row = mysql_func($sql);
        if (!$row) {
            echo "请先登入！";
            echo "<script>window.location.href='" . url('user/login') . "'</script>";
            exit;
        }
        $uid = $row[0]['id'];

        $sql = "insert into bbs_reply(pid,content,uid,ptime,pip) value('$pid','$content','$uid','$ptime','$pip')";

        $row = mysql_func($sql);

        if (!$row) {
            echo "<script>alert('发帖失败，请稍候再试！')</script>";
            echo "<script>window.location.href='" . url('tiezi/reply', array('bk' => $bk, 'zt' => $zt)) . "'</script>";
        } else {
            echo "<script>alert('回复成功')</script>";
            echo "<script>window.location.href='" . url('tiezi/detail', array('bk' => $bk, 'zt' => $zt)) . "'</script>";
        }

    }
}
