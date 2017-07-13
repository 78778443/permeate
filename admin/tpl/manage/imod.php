<?php if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (!empty($_POST['cid'])) {
    $cid = $_POST['cid'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = 'update bbs_post set cid='$cid',title='$title',content='$content' where id='$id'';

		$row = mysql_func($sql);
		if (!$row === 0) {
            echo '<script>alert('抱歉！更新用户名失败，请稍后再试！')</script>';
			echo '<script>window.location.href='list.php'</script>';
			exit;
		}
		//执行过程中没有出现意外，将跳转到LIST列表当中
		echo '<script>window.location.href=' ./list.php'</script>';
		exit;
	}
//POST不存在，将查询表中数据
$sql = 'select p.*,c.cname from bbs_post as p,bbs_cate as c where p.cid=c.id and p.id='$id'';
	$row = mysql_func($sql);
	$post = $row[0];
?>