CREATE TABLE bbs_user (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username VARCHAR(32) NOT NULL DEFAULT '72user',
        email VARCHAR(32) NOT NULL DEFAULT '',
        password CHAR(32) NOT NULL DEFAULT '72pass',
        rtime INTEGER NOT NULL DEFAULT 0,
        rip INTEGER NOT NULL DEFAULT 0,
        admins INTEGER NOT NULL DEFAULT 0
    );
CREATE TABLE sqlite_sequence(name,seq);
CREATE TABLE bbs_user_detail (
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
    );
CREATE TABLE bbs_part (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pname VARCHAR(255) NOT NULL DEFAULT '默认分区',
        padmins INTEGER NOT NULL DEFAULT 6
    );
CREATE TABLE bbs_cate (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        cname VARCHAR(255) NOT NULL DEFAULT '默认板块',
        uid INTEGER NOT NULL DEFAULT 0
    );
CREATE TABLE bbs_post (
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
    );
CREATE TABLE bbs_reply (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pid INTEGER NOT NULL DEFAULT 0,
        content TEXT,
        uid INTEGER NOT NULL DEFAULT 0,
        ptime INTEGER NOT NULL DEFAULT 0,
        pip INTEGER NOT NULL DEFAULT 0,
        xx INTEGER NOT NULL DEFAULT 1
    );
CREATE TABLE bbs_fri (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(255) NOT NULL DEFAULT '百度',
        desc1 VARCHAR(255) NOT NULL DEFAULT '百度一下,你就知道',
        url VARCHAR(255) NOT NULL DEFAULT 'http://www.baidu.com',
        pic VARCHAR(255) NOT NULL DEFAULT 'default_fri.gif'
    );
CREATE TABLE bbs_iprefuse (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ipmin VARCHAR(20) NOT NULL,
        ipmax VARCHAR(20) NOT NULL
    );
CREATE TABLE bbs_fil (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        hinge VARCHAR(32) NOT NULL
    );
CREATE TABLE bbs_home_follow (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        uid INTEGER NOT NULL DEFAULT 0,
        username CHAR(15) NOT NULL,
        followuid INTEGER NOT NULL DEFAULT 0,
        fusername CHAR(15) NOT NULL,
        status INTEGER NOT NULL DEFAULT 0,
        mutual INTEGER NOT NULL DEFAULT 0,
        uptiem INTEGER NOT NULL DEFAULT 0
    );
CREATE INDEX idx_post_cid ON bbs_post(cid);
CREATE INDEX idx_post_uid ON bbs_post(uid);
CREATE INDEX idx_post_del ON bbs_post(del);
CREATE INDEX idx_reply_pid ON bbs_reply(pid);
CREATE INDEX idx_reply_uid ON bbs_reply(uid);
CREATE INDEX idx_follow_uid ON bbs_home_follow(uid);
CREATE INDEX idx_follow_followuid ON bbs_home_follow(followuid);
