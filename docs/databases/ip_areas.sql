-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: localhost    Database: myservices
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
-- Table structure for table `ip_areas`
--

DROP TABLE IF EXISTS `ip_areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_areas` (
  `ip` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'IP地址',
  `country` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '国家',
  `province` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '省份 国外的默认值为none',
  `city` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '城市  国外的默认值为none',
  `county` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '地区 国外的默认值为none',
  `isp` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '运营商  特殊IP显示为未知',
  `the_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  UNIQUE KEY `ip_area_idx_ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='ip归属地表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ip_areas`
--

LOCK TABLES `ip_areas` WRITE;
/*!40000 ALTER TABLE `ip_areas` DISABLE KEYS */;
INSERT INTO `ip_areas` VALUES ('116.231.20.67','中国','上海','上海','宝山','中国电信','2016-08-03 07:15:50'),('116.231.59.67','中国','上海','上海','杨浦','中国电信','2016-08-02 07:45:37');
/*!40000 ALTER TABLE `ip_areas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-17 15:02:09
