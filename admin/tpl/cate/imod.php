<?php
	
	if(isset($_GET['id'])){
		$id = @$_GET['id'];
	}

	if(!empty($_POST['cname'])){
		$cname = @$_POST['cname'];
	
	if($_POST['cname']==""){
		echo "��";
		exit;
	}



		//�������ݵ�USER�������
		$sql = "update bbs_cate set cname='$cname' where id=".$id;

		$row = mysql_func($sql);
		if(!$row===0){
			echo "<script>alert('��Ǹ��д�����ݿ�ʧ�ܣ����Ժ����ԣ�')</script>";
			echo "<script>window.location.href='../index.phpm=cate&a=list'<script/>";
			exit;
		}

		//ִ�й�����û�г�����Ϊ������ת��LIST�б���
		echo "<script>window.location.href='../index.phpm=cate&a=list'</script>";
		exit;
	}
	
	//POST�����ڣ�����ѯ��������
	$sql = "select p.*,c.cname from bbs_part as p,bbs_cate as c where p.id=c.pid and c.id='$id'";

	$row = mysql_func($sql);
	
	/*echo "<pre>";
	var_dump($row);
	echo "</pre>";
	exit;*/
?>