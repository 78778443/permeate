<?php

### 自定义SQL注入
require_once  "../../conf/dbconfig.php";
require_once "../../core/mysql_func.php";

$id = $_GET['id'];



//$id = addslashes($id);

$sql = "SELECT * from  bbs_user where id='{$id}'";


$result = mysql_func($sql);

var_dump($result);