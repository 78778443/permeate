<?php
	header("content-type:text/html;charset=utf-8");
	session_start();
	include "../public/demon.php";
?>
<div class="container">
<div class="page-header">
  <span  class="label label-info"">汤青松_BBS </span><small>后台管理系统
　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　
<?php echo $_SESSION['admin']['username']['username']  ?>　,欢迎你</small>
</div>


<ul class="nav nav-pills">
  <li><a href="left.php?id=1" target="left">用户管理</a></li>
  <li><a href="left.php?id=2" target="left">分区管理</a></li>
  <li><a href="left.php?id=3" target="left">板块管理</a></li>
  <li><a href="left.php?id=4" target="left">帖子管理</a></li>
  <li><a href="left.php?id=5" target="left">回帖管理</a></li>
  <li><a href="left.php?id=6" target="left">友情链接</a></li>
  <li><a href="left.php?id=7" target="left">IP过滤</a></li>
  <li><a href="left.php?id=8" target="left">词语过滤</a></li>
  <li><a href="left.php?id=9" target="left">网站管理</a></li>
  <li><a href="logout.php">退出</a></li>
</ul>
</div>




