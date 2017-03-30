-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: localhost    Database: myserver_common_logs
-- ------------------------------------------------------
-- Server version	5.6.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `common_log_record_3_1`
--

DROP TABLE IF EXISTS `common_log_record_3_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_log_record_3_1` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cl_account_id` int(11) NOT NULL DEFAULT '0' COMMENT '帐号ID',
  `cl_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '日志类型id',
  `cl_client_ip` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '127.0.0.1' COMMENT '自增ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `user_ip` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户登录IP',
  `login_time` int(11) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `cl_created_time` int(11) NOT NULL DEFAULT '0' COMMENT '日志记录时间',
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='登录日志表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_log_type`
--

DROP TABLE IF EXISTS `common_log_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_log_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志类型ID',
  `account_id` int(11) NOT NULL DEFAULT '0' COMMENT '帐号id',
  `type_name` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '日志类型名称，用于显示',
  `description` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '描述',
  `records_count` int(11) NOT NULL DEFAULT '0' COMMENT '日志记录数',
  `created_time` datetime NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`),
  KEY `idx_account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='日志类型表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `common_log_type_property`
--

DROP TABLE IF EXISTS `common_log_type_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `common_log_type_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT 'appId 为应用的编号, foreign key 到 gs_log_app 的id',
  `prop_name` varchar(32) NOT NULL COMMENT '程序里使用的属性名',
  `col_name` varchar(32) NOT NULL COMMENT '数据库字段名',
  `display_name` varchar(32) NOT NULL COMMENT '在网页上显示的名称',
  `data_type` varchar(32) NOT NULL COMMENT '数据类型',
  `created_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-19 14:34:07
