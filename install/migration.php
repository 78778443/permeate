<?php
/**
 * 数据库迁移脚本
 * 用于更新现有数据库结构
 *
 * 使用方法: php install/migration.php
 */

require_once __DIR__ . '/../conf/dbconfig.php';
require_once __DIR__ . '/../core/mysql_func.php';

echo "开始数据库迁移...\n\n";

$migrations = array(
    // 1. 为bbs_post表添加索引
    "ALTER TABLE `bbs_post` ADD INDEX `idx_cid` (`cid`)" => "添加bbs_post.cid索引",
    "ALTER TABLE `bbs_post` ADD INDEX `idx_uid` (`uid`)" => "添加bbs_post.uid索引",
    "ALTER TABLE `bbs_post` ADD INDEX `idx_del` (`del`)" => "添加bbs_post.del索引",

    // 2. 为bbs_reply表添加索引
    "ALTER TABLE `bbs_reply` ADD INDEX `idx_pid` (`pid`)" => "添加bbs_reply.pid索引",
    "ALTER TABLE `bbs_reply` ADD INDEX `idx_uid` (`uid`)" => "添加bbs_reply.uid索引",

    // 3. 为bbs_user_detail表添加主键
    "ALTER TABLE `bbs_user_detail` ADD PRIMARY KEY (`uid`)" => "添加bbs_user_detail.uid主键",

    // 4. 为bbs_home_follow表添加索引和修改字符集
    "ALTER TABLE `bbs_home_follow` ADD INDEX `idx_uid` (`uid`)" => "添加bbs_home_follow.uid索引",
    "ALTER TABLE `bbs_home_follow` ADD INDEX `idx_followuid` (`followuid`)" => "添加bbs_home_follow.followuid索引",
    "ALTER TABLE `bbs_home_follow` CONVERT TO CHARACTER SET utf8" => "修改bbs_home_follow字符集为utf8",

    // 5. 添加view_count字段到bbs_post表（如果不存在）
    "ALTER TABLE `bbs_post` ADD COLUMN `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数'" => "添加bbs_post.view_count字段",
);

foreach ($migrations as $sql => $description) {
    echo "执行: {$description}\n";
    $result = mysql_func($sql);
    if ($result === false) {
        echo "  [跳过] 可能已存在或字段已添加\n";
    } else {
        echo "  [成功]\n";
    }
}

echo "\n数据库迁移完成!\n";
