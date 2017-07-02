<?php
	header('content-type:text/html;charset=utf-8');
	session_start();
	include "../conf/dbconfig.php";
	include "../core/mysql_func.php";
	include "public/header.php";
	$user = $_SESSION['home']['username'];
	if(empty($user)){
		echo "<script>window.location.href='login.php'</script>";
	exit;
		}
?>
<link rel="stylesheet" type="text/css" href="./resource/styles/basic.css" />
<body>
<!--individual-->
<div class="individual">
<div class="individual_left personal_left">
  <ul>
    <li class="individual_left_h3">
      <h3>设置</h3>
    </li>
    <li><a href="individual.php">修改头像</a></li>
    <li ><a href="basic.php">个人资料</a></li>
    <li class="individual_left_li"><a href="safe.php">密码安全</a></li>
  </ul>
</div>
<div class="personal_right">

<div class="personal_right_border"></div>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<p class="bbda pbm mbm">您必须填写原密码才能修改下面的资料</p>
<h3 class="mt">密码安全</h3>
<form action="hadel/dosafe.php" method="post" >
  <table summary="个人资料" cellspacing="0" cellpadding="0" >
    <tr>
      <th><span title="必填">*</span>旧密码</th>
      <td><input type="password" name="oldpassword"  /></td>
    </tr>
    <tr>
      <th>新密码</th>
      <td><input type="password" name="newpassword" /></td><td>
        <p class="d" id="chk_newpassword">    如不需要更改密码，此处请留空 </p></td>
    </tr>
    <tr>
      <th>确认新密码</th>
      <td><input type="password" name="newpassword2" /></td><td>
        <p class="d" id="chk_newpassword2">如不需要更改密码，此处请留空 </p></td>
    </tr>
    <tr>
      <th>&nbsp;</th>
      <td><button type="submit" class="btn btn-large" name="pwdsubmit" value="true"/>
        <strong>保存</strong>
        </button></td>
    </tr>
  </table>
  <input type="hidden" name="passwordsubmit" value="true" />
</form>
<div class="clear"></div>
</div>
</div>
</form>
</body>
<?php //引用函数库mysql_function.php
include "public/footer.php";
?>