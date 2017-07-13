<?php

	if(!empty($_POST['cname'])){
		$pid = $_POST['pid'];
		$cname = $_POST['cname'];

		$sql = "insert into bbs_cate(pid,cname) values('$pid','$cname')";
		$row = mysql_func($sql);
		
		if(!$row){
			echo "<script>alert('��Ǹ����Ӽ�¼ʧ�ܡ������ʽ�Ƿ���ȷ��')</script>";
			echo "<script>window.location.href='../index.phpm=cate&a=list'</script>";
			exit;
		}

		echo "<script>window.location.href='../index.phpm=cate&a=list'</script>";
		exit;
	}
?>