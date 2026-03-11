<?php
/**
 * 数据库配置文件 - SQLite版本
 */

// 数据库类型
!defined('DB_TYPE') && define('DB_TYPE', 'sqlite');

// SQLite数据库文件路径（使用绝对路径）
$dbRootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__);
!defined('DB_PATH') && define('DB_PATH', $dbRootPath . '/data/permeate.db');

// 数据库字符集
!defined('DB_CHARSET') && define('DB_CHARSET', 'utf8');

// 基础配置
$sex = array('保密', '男', '女');
$edu = array('保密', '小学', '初中', '高中/中专', '大专', '本科', '研究生', '博士', '博士后');
$admins = array('普通用户', '管理员');
?>
