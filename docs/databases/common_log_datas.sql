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
-- Dumping data for table `common_log_record_3_1`
--

LOCK TABLES `common_log_record_3_1` WRITE;
/*!40000 ALTER TABLE `common_log_record_3_1` DISABLE KEYS */;
INSERT INTO `common_log_record_3_1` VALUES (1,3,1,'127.0.0.1',102,'101.10.90.56',1473664317,1473666480),(2,3,1,'127.0.0.1',108,'101.10.90.56\n',1473664317,1473666751);
/*!40000 ALTER TABLE `common_log_record_3_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `common_log_type`
--

LOCK TABLES `common_log_type` WRITE;
/*!40000 ALTER TABLE `common_log_type` DISABLE KEYS */;
INSERT INTO `common_log_type` VALUES (1,3,'登录日志','登录日志',0,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `common_log_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `common_log_type_property`
--

LOCK TABLES `common_log_type_property` WRITE;
/*!40000 ALTER TABLE `common_log_type_property` DISABLE KEYS */;
INSERT INTO `common_log_type_property` VALUES (1,1,'user_id','user_id','用户ID','int(11)','2016-09-09 11:17:35'),(2,1,'user_ip','user_ip','用户登录IP','varchar(32)','2016-09-09 11:17:35'),(3,1,'login_time','login_time','登录时间','int(11)','2016-09-09 11:17:35');
/*!40000 ALTER TABLE `common_log_type_property` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-19 15:12:45
