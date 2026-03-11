<?php
/**
 * SQLite数据表结构定义
 */

return array(
    // 用户表
    "CREATE TABLE IF NOT EXISTS bbs_user (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(32) NOT NULL DEFAULT '72user',
        email VARCHAR(32) NOT NULL DEFAULT '',
        password CHAR(32) NOT NULL DEFAULT '72pass',
        rtime INTEGER NOT NULL DEFAULT 0,
        rip INTEGER NOT NULL DEFAULT 0,
        admins INTEGER NOT NULL DEFAULT 0
    )",

    // 用户详情表
    "CREATE TABLE IF NOT EXISTS bbs_user_detail (
        uid INTEGER PRIMARY KEY,
        t_name VARCHAR(32) DEFAULT '',
        age INTEGER NOT NULL DEFAULT 0,
        sex INTEGER NOT NULL DEFAULT 0,
        edu INTEGER NOT NULL DEFAULT 0,
        signed TEXT,
        pic VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/default.gif',
        telphone VARCHAR(32) NOT NULL DEFAULT '',
        qq INTEGER NOT NULL DEFAULT 0,
        email VARCHAR(255) NOT NULL DEFAULT '',
        brithday INTEGER NOT NULL DEFAULT 0,
        picm VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaultm.gif',
        pics VARCHAR(255) NOT NULL DEFAULT '/resources/images/userhead/defaults.gif'
    )",

    // 分区表
    "CREATE TABLE IF NOT EXISTS bbs_part (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pname VARCHAR(255) NOT NULL DEFAULT '默认分区',
        padmins INTEGER NOT NULL DEFAULT 6
    )",

    // 版块表
    "CREATE TABLE IF NOT EXISTS bbs_cate (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        cname VARCHAR(255) NOT NULL DEFAULT '默认板块',
        uid INTEGER NOT NULL DEFAULT 0
    )",

    // 帖子表
    "CREATE TABLE IF NOT EXISTS bbs_post (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        cid INTEGER NOT NULL DEFAULT 0,
        title VARCHAR(1000) NOT NULL DEFAULT '帖子标题',
        content TEXT,
        ptime INTEGER NOT NULL DEFAULT 0,
        uid INTEGER NOT NULL DEFAULT 0,
        pip VARCHAR(1000) NOT NULL DEFAULT '0',
        count INTEGER NOT NULL DEFAULT 0,
        del INTEGER NOT NULL DEFAULT 1,
        view_count INTEGER NOT NULL DEFAULT 0
    )",

    // 回复表
    "CREATE TABLE IF NOT EXISTS bbs_reply (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        content TEXT,
        uid INTEGER NOT NULL DEFAULT 0,
        ptime INTEGER NOT NULL DEFAULT 0,
        pip INTEGER NOT NULL DEFAULT 0,
        xx INTEGER NOT NULL DEFAULT 1
    )",

    // 友情链接表
    "CREATE TABLE IF NOT EXISTS bbs_fri (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL DEFAULT '百度',
        desc1 VARCHAR(255) NOT NULL DEFAULT '百度一下,你就知道',
        url VARCHAR(255) NOT NULL DEFAULT 'http://www.baidu.com',
        pic VARCHAR(255) NOT NULL DEFAULT 'default_fri.gif'
    )",

    // IP黑名单表
    "CREATE TABLE IF NOT EXISTS bbs_iprefuse (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ipmin VARCHAR(20) NOT NULL,
        ipmax VARCHAR(20) NOT NULL
    )",

    // 敏感词表
    "CREATE TABLE IF NOT EXISTS bbs_fil (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hinge VARCHAR(32) NOT NULL
    )",

    // 关注表
    "CREATE TABLE IF NOT EXISTS bbs_home_follow (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        uid INTEGER NOT NULL DEFAULT 0,
        username CHAR(15) NOT NULL,
        followuid INTEGER NOT NULL DEFAULT 0,
        fusername CHAR(15) NOT NULL,
        status INTEGER NOT NULL DEFAULT 0,
        mutual INTEGER NOT NULL DEFAULT 0,
        uptiem INTEGER NOT NULL DEFAULT 0
    )"
);
?>
