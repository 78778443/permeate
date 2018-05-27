/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : qingsong_bbs

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-07-13 23:35:58
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for bbs_post
-- ----------------------------
DROP TABLE IF EXISTS `bbs_post`;
CREATE TABLE `bbs_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(32) NOT NULL DEFAULT '帖子标题',
  `content` text,
  `ptime` int(10) unsigned NOT NULL DEFAULT '0',
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `pip` int(11) NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `del` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

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
  `pics` varchar(255) NOT NULL DEFAULT '../../resorec/images/userhead/defaults.gif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
