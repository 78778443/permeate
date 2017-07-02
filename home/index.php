<?php
require_once "../core/common.php";
$model = !empty($_GET['m']) ? $_GET['m'] : 'index';
$action = !empty($_GET['a']) ? $_GET['a'] : 'index';
includeAction("$model","$action");