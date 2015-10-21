/*
 Navicat MySQL Data Transfer

 Source Server         : localmysql
 Source Server Version : 50624
 Source Host           : localhost
 Source Database       : afadbs

 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 10/08/2015 23:51:06 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL COMMENT '账号',
  `passwd` char(32) NOT NULL COMMENT '密码',
  `regtime` datetime NOT NULL COMMENT '注册时间',
  `logtime` datetime DEFAULT NULL COMMENT '最后登录时间',
  `logip` varchar(64) DEFAULT NULL COMMENT '最后登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_idx1` (`account`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
