/*
 Navicat Premium Data Transfer

 Source Server         : mysql_local
 Source Server Type    : MySQL
 Source Server Version : 50638
 Source Host           : localhost:3306
 Source Schema         : permeate

 Target Server Type    : MySQL
 Target Server Version : 50638
 File Encoding         : 65001

 Date: 03/06/2018 23:57:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bbs_cate
-- ----------------------------
DROP TABLE IF EXISTS `bbs_cate`;
CREATE TABLE `bbs_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `cname` varchar(255) NOT NULL DEFAULT '默认板块',
  `uid` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_cate
-- ----------------------------
BEGIN;
INSERT INTO `bbs_cate` VALUES (5, 41, 'SQL注入', 0);
INSERT INTO `bbs_cate` VALUES (6, 41, 'XSS跨站', 0);
INSERT INTO `bbs_cate` VALUES (7, 41, '命令执行', 0);
INSERT INTO `bbs_cate` VALUES (8, 41, '代码注入', 0);
INSERT INTO `bbs_cate` VALUES (9, 42, '密码找回', 0);
INSERT INTO `bbs_cate` VALUES (10, 42, '越权访问', 0);
INSERT INTO `bbs_cate` VALUES (11, 42, '支付漏洞', 0);
INSERT INTO `bbs_cate` VALUES (12, 42, '隐私泄露', 0);
COMMIT;

-- ----------------------------
-- Table structure for bbs_fil
-- ----------------------------
DROP TABLE IF EXISTS `bbs_fil`;
CREATE TABLE `bbs_fil` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hinge` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for bbs_fri
-- ----------------------------
DROP TABLE IF EXISTS `bbs_fri`;
CREATE TABLE `bbs_fri` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '百度',
  `desc1` varchar(255) NOT NULL DEFAULT '百度一下,你就知道',
  `url` varchar(255) NOT NULL DEFAULT 'http://www.baidu.com',
  `pic` varchar(255) NOT NULL DEFAULT 'default_fri.gif',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for bbs_home_follow
-- ----------------------------
DROP TABLE IF EXISTS `bbs_home_follow`;
CREATE TABLE `bbs_home_follow` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` char(15) NOT NULL COMMENT '用户名',
  `followuid` int(10) NOT NULL DEFAULT '0' COMMENT '被关注用户ID',
  `fusername` char(15) NOT NULL COMMENT '被关注用户名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常 1:特殊关注 -1:不能再关注此人',
  `mutual` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:单向 1:已互相关注',
  `uptiem` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bbs_home_follow
-- ----------------------------
BEGIN;
INSERT INTO `bbs_home_follow` VALUES (6, 15, '', 14, '666666', 0, 0, 1526707752);
INSERT INTO `bbs_home_follow` VALUES (5, 17, '', 6, 'admin', 0, 0, 1526685269);
INSERT INTO `bbs_home_follow` VALUES (7, 6, '', 14, '666666', 0, 0, 1526708006);
INSERT INTO `bbs_home_follow` VALUES (8, 12, '', 14, '666666', 0, 0, 1526708011);
INSERT INTO `bbs_home_follow` VALUES (9, 17, '', 14, '666666', 0, 0, 1526708208);
INSERT INTO `bbs_home_follow` VALUES (10, 12, '', 10, '444444', 0, 1, 1526708270);
INSERT INTO `bbs_home_follow` VALUES (11, 6, '', 11, '555555', 0, 0, 1526708306);
INSERT INTO `bbs_home_follow` VALUES (12, 6, '', 8, '222222', 0, 0, 1526708311);
INSERT INTO `bbs_home_follow` VALUES (13, 6, '', 10, '444444', 0, 1, 1526708338);
INSERT INTO `bbs_home_follow` VALUES (14, 9, '', 14, '666666', 0, 0, 1526708773);
INSERT INTO `bbs_home_follow` VALUES (15, 10, '', 14, '666666', 0, 1, 1526708773);
INSERT INTO `bbs_home_follow` VALUES (16, 10, '', 9, '333333', 0, 1, 1526708786);
INSERT INTO `bbs_home_follow` VALUES (17, 9, '', 6, 'admin', 0, 0, 1526708794);
INSERT INTO `bbs_home_follow` VALUES (18, 9, '', 8, '222222', 0, 0, 1526708821);
INSERT INTO `bbs_home_follow` VALUES (19, 10, '', 8, '222222', 0, 0, 1526708821);
INSERT INTO `bbs_home_follow` VALUES (20, 9, '', 12, '777777', 0, 1, 1526708830);
INSERT INTO `bbs_home_follow` VALUES (21, 11, '', 14, '666666', 0, 0, 1526709314);
INSERT INTO `bbs_home_follow` VALUES (22, 10, '', 11, '555555', 0, 0, 1526709330);
INSERT INTO `bbs_home_follow` VALUES (23, 8, '', 11, '555555', 0, 0, 1526709447);
INSERT INTO `bbs_home_follow` VALUES (24, 10, '', 13, '888888', 0, 0, 1526709486);
INSERT INTO `bbs_home_follow` VALUES (25, 8, '', 12, '777777', 0, 1, 1526709868);
INSERT INTO `bbs_home_follow` VALUES (26, 12, '', 6, 'admin', 0, 0, 1526709944);
INSERT INTO `bbs_home_follow` VALUES (27, 10, '', 15, '999999', 0, 0, 1526709954);
INSERT INTO `bbs_home_follow` VALUES (28, 12, '', 15, '999999', 0, 0, 1526709954);
INSERT INTO `bbs_home_follow` VALUES (29, 12, '', 13, '888888', 0, 0, 1526710241);
INSERT INTO `bbs_home_follow` VALUES (30, 12, '', 11, '555555', 0, 0, 1526710434);
INSERT INTO `bbs_home_follow` VALUES (31, 9, '', 13, '888888', 0, 0, 1526710518);
COMMIT;

-- ----------------------------
-- Table structure for bbs_iprefuse
-- ----------------------------
DROP TABLE IF EXISTS `bbs_iprefuse`;
CREATE TABLE `bbs_iprefuse` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ipmin` varchar(20) NOT NULL,
  `ipmax` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for bbs_part
-- ----------------------------
DROP TABLE IF EXISTS `bbs_part`;
CREATE TABLE `bbs_part` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) NOT NULL DEFAULT '默认分区',
  `padmins` int(10) NOT NULL DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_part
-- ----------------------------
BEGIN;
INSERT INTO `bbs_part` VALUES (41, '常规漏洞', 6);
INSERT INTO `bbs_part` VALUES (42, '逻辑漏洞', 6);
COMMIT;

-- ----------------------------
-- Table structure for bbs_post
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE `bbs_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(1000) NOT NULL DEFAULT '帖子标题',
  `content` text,
  `ptime` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `pip` varchar(1000) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `del` int(1) unsigned NOT NULL DEFAULT '1',
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '显示数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=814 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_post
-- ----------------------------
BEGIN;
INSERT INTO `bbs_post` VALUES (801, 5, '这是帖子标题', '这是帖子内容', 1528040134, 6, '2130706433', 0, 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for bbs_reply
-- ----------------------------
DROP TABLE IF EXISTS `bbs_reply`;
CREATE TABLE `bbs_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `ptime` int(10) unsigned NOT NULL DEFAULT '0',
  `pip` int(10) unsigned NOT NULL DEFAULT '0',
  `xx` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=282 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_reply
-- ----------------------------
BEGIN;
INSERT INTO `bbs_reply` VALUES (219, 57, '<p><span style=\"color: rgb(97, 97, 97); font-family: -apple-system, system-ui, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;PingFang SC&quot;, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, &quot;Hiragino Kaku Gothic Pro&quot;, Meiryo, &quot;Malgun Gothic&quot;, &quot;Microsoft YaHei&quot;, Arial, Helvetica, sans-serif; background-color: rgb(255, 255, 255);\">&lt;img src=&quot;http://local.premeate.songboy.net/home/index.php?m=user&amp;a=follow&amp;uid=8&quot;/&gt;</span></p>', 8, 1526709450, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (217, 56, '<p>&lt;img src=&quot;http://local.premeate.songboy.net/home/index.php?m=user&amp;a=follow&amp;uid=8&quot;&gt;</p>', 8, 1526709328, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (218, 57, '<p><span style=\"color: rgb(97, 97, 97); font-family: -apple-system, system-ui, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;PingFang SC&quot;, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, &quot;Hiragino Kaku Gothic Pro&quot;, Meiryo, &quot;Malgun Gothic&quot;, &quot;Microsoft YaHei&quot;, Arial, Helvetica, sans-serif; background-color: rgb(255, 255, 255);\">&lt;img src=&quot;http://local.premeate.songboy.net/home/index.php?m=user&amp;a=follow&amp;uid=8&quot;/&gt;</span></p>', 8, 1526709437, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (216, 57, '<p>&lt;img src=&quot;http://local.premeate.songboy.net/home/index.php?m=user&amp;a=follow&amp;uid=8&quot;&gt;</p>', 8, 1526709319, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (215, 55, '<p>&lt;img src=&quot;http://local.premeate.songboy.net/home/index.php?m=user&amp;a=follow&amp;uid=8&quot;&gt;</p>', 8, 1526709310, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (180, 55, '<p>1111</p>', 15, 1526622702, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (214, 56, 'TianYeTest003</p></div><a href=http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=12>', 12, 1526709244, 3232237673, 1);
INSERT INTO `bbs_reply` VALUES (212, 55, '<p>123<br/></p>', 10, 1526709224, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (213, 55, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709242, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (187, 59, '<p>sddddddddddddddddd</p>', 14, 1526708157, 3232237676, 1);
INSERT INTO `bbs_reply` VALUES (188, 55, '<p>sddddddddddddddddd</p>', 14, 1526708170, 3232237676, 1);
INSERT INTO `bbs_reply` VALUES (189, 55, '', 9, 1526708366, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (190, 55, '<script src=\"http://local.premeate.songboy.net/home/index.php?m=user', 9, 1526708454, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (191, 66, '<p>22222222</p>', 8, 1526708471, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (192, 55, 'TianYeTest001</p></div><image src=http://local.premeate.songboy.net/home/index.php?m=user', 12, 1526708486, 3232237673, 1);
INSERT INTO `bbs_reply` VALUES (193, 55, '<p>123<br/></p>', 10, 1526708522, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (194, 56, '<p>123</p>', 8, 1526708555, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (195, 55, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526708563, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (196, 55, 'test img<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 9, 1526708595, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (197, 56, '<p>123<br/></p>', 10, 1526708624, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (198, 56, 'test img<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 9, 1526708668, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (199, 56, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526708685, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (200, 56, 'test img<script src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=9\"></script>', 9, 1526708769, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (201, 55, 'test img<script src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=9\"></script>', 9, 1526708780, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (202, 56, 'test img<script src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=9\"></script>', 9, 1526708783, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (203, 56, '<p>11111</p>', 6, 1526708792, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (204, 56, '<p>Tianye Test002</p></div><image src=http://local.premeate.songboy.net/home/index.php?m=user', 12, 1526708818, 3232237673, 1);
INSERT INTO `bbs_reply` VALUES (205, 56, '<p>hhhhhhhhhhhhhhhhhhhhhhhhh</p>', 14, 1526708822, 3232237676, 1);
INSERT INTO `bbs_reply` VALUES (206, 56, '<p>111<br/></p>', 9, 1526708831, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (207, 57, '<p>123<br/></p>', 10, 1526708854, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (208, 57, 'test img<script src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=9\"></script>', 9, 1526708857, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (209, 57, '<p>11<br/></p>', 9, 1526708863, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (210, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526708870, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (211, 56, '<p>11111</p>', 6, 1526708908, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (186, 55, '<p>test<br/></p>', 12, 1526707764, 3232237673, 1);
INSERT INTO `bbs_reply` VALUES (184, 56, '<p>测试一下哈</p>', 17, 1526685736, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (185, 55, '<p>dgsdgsd</p>', 14, 1526707727, 3232237676, 1);
INSERT INTO `bbs_reply` VALUES (220, 55, '<p>66<br/></p>', 13, 1526709497, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (221, 57, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526709505, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (222, 57, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526709537, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (223, 56, '<p>1</p>', 8, 1526709549, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (224, 56, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526709578, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (225, 57, '<p>1</p>', 8, 1526709597, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (226, 57, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526709633, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (227, 55, '111<img src=local.premeate.songboy.net/home/index.php?m=user', 13, 1526709663, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (228, 55, '<p>123<br/></p>', 10, 1526709726, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (229, 57, '<p>123<br/></p>', 10, 1526709782, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (230, 56, 'TianYe004</p></div><image src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=12\">', 12, 1526709798, 3232237673, 1);
INSERT INTO `bbs_reply` VALUES (231, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709811, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (232, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709817, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (233, 55, '123<img src = \"local.premeate.songboy.net/home/index.php?m=user', 13, 1526709817, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (234, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709823, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (235, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709828, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (236, 57, '<p>关注我</p><img src=\"http://local.premeate.songboy.net/home/index.php?m=user&a=follow&uid=10\" />', 10, 1526709834, 3232237675, 1);
INSERT INTO `bbs_reply` VALUES (237, 65, 'ttest img<script src=\"http://local.premeate.songboy.net/home/index.php?m=user', 9, 1526709902, 3232237678, 1);
INSERT INTO `bbs_reply` VALUES (238, 55, '<img src=\"local.premeate.songboy.net/home/index.php?m=user', 13, 1526710115, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (239, 57, '</div><img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 13, 1526710639, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (240, 67, '1<script type=\"text/javascript\" src=\"myscripts.js\"></script>', 8, 1526710648, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (241, 67, '<p>1<br/></p>', 8, 1526710664, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (242, 67, '<script src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526710737, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (243, 72, '42<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 8, 1526710782, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (244, 285, '<img src=\"local.premeate.songboy.net/home/index.php?m=user', 13, 1526711989, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (245, 285, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712015, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (246, 287, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712122, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (247, 285, '</p><img src=\"local.premeate.songboy.net/home/index.php?m=user', 13, 1526712151, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (248, 285, '<p>111<br/></p>', 13, 1526712164, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (249, 287, '123<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712177, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (250, 287, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712227, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (251, 285, '<p>111<br/></p><img src=\"local.premeate.songboy.net/home/index.php?m=user', 13, 1526712271, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (252, 287, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712394, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (253, 285, 'www</p><img src=\"local.premeate.songboy.net/home/index.php?m=user', 13, 1526712465, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (254, 287, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712617, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (255, 285, '<p>qq<br/></p>', 13, 1526712617, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (256, 285, '<img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 13, 1526712730, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (257, 286, 'img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712811, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (258, 285, '</div><img src=\"http://local.premeate.songboy.net/home/index.php?m=user', 13, 1526712883, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (259, 286, '<img src=\"http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526712922, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (260, 286, 'w<img src = \"http://local.premeate.songboy.net/home/index.php?m=user', 13, 1526713291, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (261, 286, '<img src=\"http://local.dvwa.songboy.net/hackable/uploads/1.js\"/>', 8, 1526713336, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (262, 286, '<img src=http://local.premeate.songboy.net/home/index.php?m=user', 13, 1526713681, 3232237679, 1);
INSERT INTO `bbs_reply` VALUES (263, 287, '<script>\r\nalert(\"My First JavaScript\");\r\n</script>', 8, 1526716737, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (264, 285, '<a href=http://local.premeate.songboy.net/home/_fatie.php?bk=5', 8, 1526716938, 3232237680, 1);
INSERT INTO `bbs_reply` VALUES (265, 289, '<p>alert(&#39;sadasd&#39;)</p>', 8, 1526789733, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (266, 289, '<p>&lt;script&gt;alert(&#39;sadasdasd&#39;)&lt;script&gt;</p>', 8, 1526789761, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (267, 289, '<p><span style=\"color: rgb(97, 97, 97); font-family: -apple-system, system-ui, system-ui, &quot;Segoe UI&quot;, Roboto, &quot;PingFang SC&quot;, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, &quot;Hiragino Kaku Gothic Pro&quot;, Meiryo, &quot;Malgun Gothic&quot;, &quot;Microsoft YaHei&quot;, Arial, Helvetica, sans-serif; background-color: rgb(255, 255, 255);\">&lt;script&gt;alert(&#39;sadasdasd&#39;)&lt;/script&gt;</span></p>', 8, 1526789776, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (268, 289, '<p>&lt;scritp&gt;</p><p><span style=\"color: #ef596f;\">alert(&#39;asdasdasd&#39;)</span></p><p>&lt;/script&gt;<br/></p>', 8, 1526789822, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (269, 289, '', 8, 1526789883, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (270, 289, '<p>&lt;script&gt;alert(&#39;sadasdasd&#39;)&lt;/script&gt;</p><p><br/></p>', 8, 1526789930, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (271, 289, '<p><span style=\"color: rgb(97, 97, 97); font-family: -apple-system, system-ui, system-ui, &quot;Segoe UI&quot;, Roboto, &quot;PingFang SC&quot;, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, &quot;Hiragino Kaku Gothic Pro&quot;, Meiryo, &quot;Malgun Gothic&quot;, &quot;Microsoft YaHei&quot;, Arial, Helvetica, sans-serif; background-color: rgb(255, 255, 255);\">&lt;script&gt;alert(&#39;sadasdasd&#39;)&lt;/script&gt;</span></p>', 8, 1526789967, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (272, 285, '<p>测试</p>', 6, 1527001758, 3232286701, 1);
INSERT INTO `bbs_reply` VALUES (273, 285, '<p>特殊</p>', 6, 1527001773, 3232286701, 1);
INSERT INTO `bbs_reply` VALUES (274, 285, '<p>123123123123</p>', 6, 1528006276, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (275, 285, '<p>123</p>', 6, 1528006284, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (276, 374, '<p>3123123123</p>', 6, 1528006312, 3232286655, 1);
INSERT INTO `bbs_reply` VALUES (277, 374, '<p>3234234</p>', 6, 1528006375, 3232286701, 1);
INSERT INTO `bbs_reply` VALUES (278, 768, '<p>1111</p>', 6, 1528033317, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (279, 768, '<p>cesdfsdf</p>', 6, 1528033690, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (280, 782, '<p>那就在测试一下吧</p>', 6, 1528037517, 2130706433, 1);
INSERT INTO `bbs_reply` VALUES (281, 782, '<p>现在进行尝试发帖试试</p>', 6, 1528037885, 2130706433, 1);
COMMIT;

-- ----------------------------
-- Table structure for bbs_user
-- ----------------------------
DROP TABLE IF EXISTS `bbs_user`;
CREATE TABLE `bbs_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL DEFAULT '72user',
  `email` varchar(32) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '72pass',
  `rtime` int(10) unsigned NOT NULL DEFAULT '0',
  `rip` bigint(11) NOT NULL DEFAULT '0',
  `admins` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_user
-- ----------------------------
BEGIN;
INSERT INTO `bbs_user` VALUES (6, 'admin', '', '96e79218965eb72c92a549dd5a330112', 1525735766, 0, 1);
INSERT INTO `bbs_user` VALUES (7, 'changqing123456', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (8, '222222', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (9, '333333', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (10, '444444', '776070848@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (11, '555555', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (12, '777777', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (13, '888888', '776070848@qq.com', 'c4ca4238a0b923820dcc509a6f75849b', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (14, '666666', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (15, '999999', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (16, '333333', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (17, '444444', '776070848@qq.com', '21232f297a57a5a743894a0e4a801fc3', 1526606850, 3232237169, 0);
INSERT INTO `bbs_user` VALUES (18, 'xx291180782', '291180782@qq.com', 'e10adc3949ba59abbe56e057f20f883e', 1527992467, 3232286655, 0);
COMMIT;

-- ----------------------------
-- Table structure for bbs_user_detail
-- ----------------------------
DROP TABLE IF EXISTS `bbs_user_detail`;
CREATE TABLE `bbs_user_detail` (
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `t_name` varchar(32) DEFAULT '汤青松',
  `age` int(10) unsigned NOT NULL DEFAULT '0',
  `sex` int(10) unsigned NOT NULL DEFAULT '0',
  `edu` int(10) unsigned NOT NULL DEFAULT '0',
  `signed` text,
  `pic` varchar(255) NOT NULL DEFAULT '../../resorec/images/userhead/default.gif',
  `telphone` varchar(32) NOT NULL DEFAULT '13888888888',
  `qq` int(10) unsigned NOT NULL DEFAULT '888888',
  `email` varchar(255) NOT NULL DEFAULT 'soupqingsong@foxmail.com',
  `brithday` int(10) unsigned NOT NULL DEFAULT '0',
  `picm` varchar(255) NOT NULL DEFAULT '../../resorec/images/userhead/defaultm.gif',
  `pics` varchar(255) NOT NULL DEFAULT '../../resorec/images/userhead/defaults.gif',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bbs_user_detail
-- ----------------------------
BEGIN;
INSERT INTO `bbs_user_detail` VALUES (6, '汤青松', 0, 0, 0, '23', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, 'soupqingsong@foxmail.com', 0, '/resorce/images/userhead/ad9f521aa6e50cbc13617e243e0b74b7.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (7, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (8, '汤青松333', 0, 0, 0, '23', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, 'soupqingsong@foxmail.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (9, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (10, '汤青松', 0, 0, 0, '555555', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (11, '汤青松', 0, 0, 0, '555555', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 860400, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (12, 'Tony', 0, 0, 0, '', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 10000, '776070848@qq.com', 270774000, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (13, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (14, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (15, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (16, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (17, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
INSERT INTO `bbs_user_detail` VALUES (18, '汤青松', 0, 0, 0, NULL, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '13888888888', 888888, '776070848@qq.com', 0, '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png', '/resorce/images/userhead/216bb6cc72448bfbf807912cc0719f4f.png');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
