<?php
	session_start();
	unsetUser();
	setcookie('adminusername','',time()-1,'/');
	session_destroy();
	header("location:../index.php");
?>