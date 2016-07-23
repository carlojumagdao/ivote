CREATE DATABASE  IF NOT EXISTS `dbvote++` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbvote++`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbvote++
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.13-MariaDB

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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblactiveuser`
--

DROP TABLE IF EXISTS `tblactiveuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblactiveuser` (
  `tblactiveuserID` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tblactiveuserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblactiveuser`
--

LOCK TABLES `tblactiveuser` WRITE;
/*!40000 ALTER TABLE `tblactiveuser` DISABLE KEYS */;
INSERT INTO `tblactiveuser` VALUES (1,'Mon Paulo Velasco');
/*!40000 ALTER TABLE `tblactiveuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblanswer`
--

DROP TABLE IF EXISTS `tblanswer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblanswer` (
  `intAnswerId` int(11) NOT NULL AUTO_INCREMENT,
  `strAnsMemId` varchar(45) NOT NULL,
  `intQuestId` int(11) NOT NULL,
  `intAnsSurvFormId` int(11) NOT NULL,
  `txtAnswer` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`intAnswerId`),
  KEY `fkAnsMem_idx` (`strAnsMemId`),
  KEY `fkAnsQuest_idx` (`intQuestId`),
  KEY `fkAnsSurvForm_idx` (`intAnsSurvFormId`),
  CONSTRAINT `fkAnsMem` FOREIGN KEY (`strAnsMemId`) REFERENCES `tblmember` (`strMemberId`) ON UPDATE CASCADE,
  CONSTRAINT `fkAnsQuest` FOREIGN KEY (`intQuestId`) REFERENCES `tblquestion` (`intQuestId`) ON UPDATE CASCADE,
  CONSTRAINT `fkAnsSurvForm` FOREIGN KEY (`intAnsSurvFormId`) REFERENCES `tblsurveyform` (`intSurveyFormId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblanswer`
--

LOCK TABLES `tblanswer` WRITE;
/*!40000 ALTER TABLE `tblanswer` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblanswer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblaudit`
--

DROP TABLE IF EXISTS `tblaudit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblaudit` (
  `tblmemaudId` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `strMemberId` varchar(45) NOT NULL,
  `Action` varchar(45) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tblmemaudId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblaudit`
--

LOCK TABLES `tblaudit` WRITE;
/*!40000 ALTER TABLE `tblaudit` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblaudit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcandidate`
--

DROP TABLE IF EXISTS `tblcandidate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcandidate` (
  `strCandId` varchar(45) NOT NULL,
  `strCandMemId` varchar(45) NOT NULL,
  `strCandPosId` varchar(45) NOT NULL,
  `intCandParId` int(11) DEFAULT NULL,
  `strCandEducBack` text NOT NULL,
  `strCandInfo` text NOT NULL,
  `txtCandPic` tinytext NOT NULL,
  `blCandDelete` tinyint(1) NOT NULL,
  PRIMARY KEY (`strCandMemId`,`strCandPosId`,`blCandDelete`),
  UNIQUE KEY `strCandId_UNIQUE` (`strCandId`),
  KEY `fkCandMem_idx` (`strCandMemId`),
  KEY `fkCandPos_idx` (`strCandPosId`),
  KEY `fkCandParty_idx` (`intCandParId`),
  CONSTRAINT `fkCandMem` FOREIGN KEY (`strCandMemId`) REFERENCES `tblmember` (`strMemberId`) ON UPDATE CASCADE,
  CONSTRAINT `fkCandParty` FOREIGN KEY (`intCandParId`) REFERENCES `tblparty` (`intPartyId`) ON UPDATE CASCADE,
  CONSTRAINT `fkCandPos` FOREIGN KEY (`strCandPosId`) REFERENCES `tblposition` (`strPositionId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcandidate`
--

LOCK TABLES `tblcandidate` WRITE;
/*!40000 ALTER TABLE `tblcandidate` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblcandidate` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblcandidate_AINS` AFTER INSERT ON `tblcandidate` FOR EACH ROW begin
declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1); 
INSERT INTO tblaudit (User,Action,strMemberId,Date) 
value (user,'INSERTED',new.strCandId,now());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblcandidate_AUPD` AFTER UPDATE ON `tblcandidate` FOR EACH ROW

begin

declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1);
IF (new.blCandDelete = '1')
THEN
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,old.strCandId,'DELETED',now());
ELSE
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,NEW.strCandId,'UPDATED',now());
END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tbldynamicfield`
--

DROP TABLE IF EXISTS `tbldynamicfield`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbldynamicfield` (
  `intDynFieldId` int(11) NOT NULL AUTO_INCREMENT,
  `strDynFieldName` varchar(100) NOT NULL,
  `blDynStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`intDynFieldId`),
  UNIQUE KEY `strDynFieldName_UNIQUE` (`strDynFieldName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldynamicfield`
--

LOCK TABLES `tbldynamicfield` WRITE;
/*!40000 ALTER TABLE `tbldynamicfield` DISABLE KEYS */;
INSERT INTO `tbldynamicfield` VALUES (1,'region',0),(2,'chapter',1),(3,'department',1),(5,'gender',1);
/*!40000 ALTER TABLE `tbldynamicfield` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblelection`
--

DROP TABLE IF EXISTS `tblelection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblelection` (
  `intElectionId` int(11) NOT NULL AUTO_INCREMENT,
  `strElecTitle` varchar(80) NOT NULL,
  `strElecDesc` varchar(100) DEFAULT NULL,
  `blMemFee` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`intElectionId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblelection`
--

LOCK TABLES `tblelection` WRITE;
/*!40000 ALTER TABLE `tblelection` DISABLE KEYS */;
INSERT INTO `tblelection` VALUES (1,'National Election 2016','This is a sample description for  National election 2016',1);
/*!40000 ALTER TABLE `tblelection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmember`
--

DROP TABLE IF EXISTS `tblmember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmember` (
  `strMemberId` varchar(45) NOT NULL,
  `strMemFname` varchar(45) NOT NULL,
  `strMemMname` varchar(45) DEFAULT NULL,
  `strMemLname` varchar(45) NOT NULL,
  `strMemEmail` varchar(45) NOT NULL,
  `intMemSecQuesId` int(11) DEFAULT NULL,
  `strMemSecQuesAnswer` varchar(80) DEFAULT NULL,
  `strMemPasscode` char(6) DEFAULT NULL,
  `blMemCodeSendStat` tinyint(1) NOT NULL DEFAULT '0',
  `blMemDelete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strMemberId`),
  UNIQUE KEY `strMemPasscode_UNIQUE` (`strMemPasscode`),
  KEY `fkMemSec_idx` (`intMemSecQuesId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmember`
--

LOCK TABLES `tblmember` WRITE;
/*!40000 ALTER TABLE `tblmember` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmember` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblmember_AINS` AFTER INSERT ON `tblmember` FOR EACH ROW begin
declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1); 
INSERT INTO tblaudit (User,Action,strMemberId,Date) 
value (user,'INSERTED',new.strMemberId,now());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblmember_AUPD` AFTER UPDATE ON `tblmember` FOR EACH ROW

begin

declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1);
IF (new.blMemDelete = '1')
THEN
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,old.strMemberId,'DELETED',now());
ELSE
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,NEW.strMemberId,'UPDATED',now());
END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tblmemberdetail`
--

DROP TABLE IF EXISTS `tblmemberdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmemberdetail` (
  `intMemDeId` int(11) NOT NULL AUTO_INCREMENT,
  `strMemDeMemId` varchar(45) NOT NULL,
  `strMemDeFieldName` varchar(45) NOT NULL,
  `strMemDeFieldData` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`intMemDeId`),
  UNIQUE KEY `intMemDeId_UNIQUE` (`intMemDeId`),
  KEY `fkMemDeMem_idx` (`strMemDeMemId`),
  KEY `fkMemDeFieldName_idx1` (`strMemDeFieldName`),
  CONSTRAINT `fkMemDeFieldName` FOREIGN KEY (`strMemDeFieldName`) REFERENCES `tbldynamicfield` (`strDynFieldName`) ON UPDATE CASCADE,
  CONSTRAINT `fkMemDeMemId` FOREIGN KEY (`strMemDeMemId`) REFERENCES `tblmember` (`strMemberId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmemberdetail`
--

LOCK TABLES `tblmemberdetail` WRITE;
/*!40000 ALTER TABLE `tblmemberdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblmemberdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmemberform`
--

DROP TABLE IF EXISTS `tblmemberform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmemberform` (
  `intMemForm` int(11) NOT NULL AUTO_INCREMENT,
  `strMemFormTitle` varchar(100) NOT NULL,
  `strMemForm` text NOT NULL,
  PRIMARY KEY (`intMemForm`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmemberform`
--

LOCK TABLES `tblmemberform` WRITE;
/*!40000 ALTER TABLE `tblmemberform` DISABLE KEYS */;
INSERT INTO `tblmemberform` VALUES (2,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5}]}'),(3,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Region\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(4,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(5,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(6,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Age\",\"type\":\"element-number\",\"required\":false,\"position\":8},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":9,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}'),(7,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Age\",\"type\":\"element-number\",\"required\":false,\"position\":7},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":8,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":9,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}'),(8,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":8,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}');
/*!40000 ALTER TABLE `tblmemberform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblparty`
--

DROP TABLE IF EXISTS `tblparty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblparty` (
  `intPartyId` int(11) NOT NULL AUTO_INCREMENT,
  `strPartyName` varchar(45) NOT NULL,
  `strPartyLeader` varchar(45) DEFAULT NULL,
  `txtPartyPic` text,
  `strPartyColor` varchar(45) NOT NULL DEFAULT '#ffffff',
  `blPartyDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intPartyId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblparty`
--

LOCK TABLES `tblparty` WRITE;
/*!40000 ALTER TABLE `tblparty` DISABLE KEYS */;
INSERT INTO `tblparty` VALUES (1,'Independent','None','none','#ffffff',0);
/*!40000 ALTER TABLE `tblparty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblposition`
--

DROP TABLE IF EXISTS `tblposition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblposition` (
  `strPositionId` varchar(45) NOT NULL,
  `strPosName` varchar(45) NOT NULL,
  `strPosColor` varchar(45) NOT NULL DEFAULT '#ffffff',
  `intPosVoteLimit` int(11) NOT NULL,
  `blPosDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`strPositionId`),
  UNIQUE KEY `strPosName_UNIQUE` (`strPosName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblposition`
--

LOCK TABLES `tblposition` WRITE;
/*!40000 ALTER TABLE `tblposition` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblposition` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblposition_AINS` AFTER INSERT ON `tblposition` FOR EACH ROW
begin
declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1); 
INSERT INTO tblaudit (User,Action,strMemberId,Date) 
value (user,'INSERTED',new.strPositionId,now());
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tblposition_AUPD` AFTER UPDATE ON `tblposition` FOR EACH ROW


begin

declare user varchar(50);
set user = (SELECT name from tblactiveuser where tblactiveuserID=1);
IF (new.blPosDelete = '1')
THEN
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,old.strPositionId,'DELETED',now());
ELSE
INSERT INTO tblaudit (User,strMemberId,Action,Date) 
value (user,NEW.strPositionId,'UPDATED',now());
END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tblpositiondetail`
--

DROP TABLE IF EXISTS `tblpositiondetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpositiondetail` (
  `intPosDeId` int(11) NOT NULL AUTO_INCREMENT,
  `strPosDePosId` varchar(45) NOT NULL,
  `strPosDeFieldName` varchar(80) NOT NULL,
  `strPosDeFieldData` varchar(80) NOT NULL,
  PRIMARY KEY (`intPosDeId`),
  KEY `fkPosDePos_idx` (`strPosDePosId`),
  KEY `fkPosDeFieldName_idx` (`strPosDeFieldName`),
  CONSTRAINT `fkPosDePosId` FOREIGN KEY (`strPosDePosId`) REFERENCES `tblposition` (`strPositionId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpositiondetail`
--

LOCK TABLES `tblpositiondetail` WRITE;
/*!40000 ALTER TABLE `tblpositiondetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblpositiondetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblquestion`
--

DROP TABLE IF EXISTS `tblquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblquestion` (
  `intQuestId` int(11) NOT NULL AUTO_INCREMENT,
  `txtQuestDesc` tinytext,
  PRIMARY KEY (`intQuestId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblquestion`
--

LOCK TABLES `tblquestion` WRITE;
/*!40000 ALTER TABLE `tblquestion` DISABLE KEYS */;
INSERT INTO `tblquestion` VALUES (1,'What is your favorite pet\'s name?'),(2,'What is your mother\'s maiden name?'),(3,'Who is your first kiss?');
/*!40000 ALTER TABLE `tblquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblschedule`
--

DROP TABLE IF EXISTS `tblschedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblschedule` (
  `intSchedId` int(11) NOT NULL AUTO_INCREMENT,
  `datSchedStart` date NOT NULL,
  `datSchedEnd` date NOT NULL,
  PRIMARY KEY (`intSchedId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblschedule`
--

LOCK TABLES `tblschedule` WRITE;
/*!40000 ALTER TABLE `tblschedule` DISABLE KEYS */;
INSERT INTO `tblschedule` VALUES (1,'2016-03-18','2016-03-23');
/*!40000 ALTER TABLE `tblschedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsecquestion`
--

DROP TABLE IF EXISTS `tblsecquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsecquestion` (
  `intSecQuesId` int(11) NOT NULL AUTO_INCREMENT,
  `strSecQuestion` varchar(100) NOT NULL,
  PRIMARY KEY (`intSecQuesId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsecquestion`
--

LOCK TABLES `tblsecquestion` WRITE;
/*!40000 ALTER TABLE `tblsecquestion` DISABLE KEYS */;
INSERT INTO `tblsecquestion` VALUES (1,'What is your favorite pet\'s name?'),(2,'What is your mother\'s maiden name?'),(3,'Who is your first kiss?');
/*!40000 ALTER TABLE `tblsecquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsecurityquestion`
--

DROP TABLE IF EXISTS `tblsecurityquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsecurityquestion` (
  `intSecQuesId` int(11) NOT NULL AUTO_INCREMENT,
  `strSecQuestion` varchar(100) NOT NULL,
  `blSecQuesDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intSecQuesId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsecurityquestion`
--

LOCK TABLES `tblsecurityquestion` WRITE;
/*!40000 ALTER TABLE `tblsecurityquestion` DISABLE KEYS */;
INSERT INTO `tblsecurityquestion` VALUES (1,'What is your mother\'s maiden name?',0),(2,'What is your favorite pet\'s name?',0),(3,'Who is your first love?',1);
/*!40000 ALTER TABLE `tblsecurityquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsetting`
--

DROP TABLE IF EXISTS `tblsetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsetting` (
  `intSettingId` int(11) NOT NULL AUTO_INCREMENT,
  `strSetElecName` varchar(100) NOT NULL,
  `strSetElecDesc` text NOT NULL,
  `datSetStart` datetime NOT NULL,
  `datSetEnd` datetime NOT NULL,
  `blSetSurvey` tinyint(1) NOT NULL DEFAULT '0',
  `blSetParty` tinyint(1) NOT NULL DEFAULT '0',
  `txtSetLogo` text,
  `strHeader` varchar(200) NOT NULL,
  `strSetAddress` text,
  PRIMARY KEY (`intSettingId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsetting`
--

LOCK TABLES `tblsetting` WRITE;
/*!40000 ALTER TABLE `tblsetting` DISABLE KEYS */;
INSERT INTO `tblsetting` VALUES (1,'INDRA Philippines National Election','We are one of the leading IT service providers in the country and in Southeast Asia','2016-07-20 14:00:00','2016-07-21 17:00:00',1,0,'20160710115828-981960.png','INDRA PHILIPPINES, INC','11TH & 12TH FLOOR ROCKWELL BUSINESS CENTER, ORTIGAS AVE., PASIG  METRO MANILA');
/*!40000 ALTER TABLE `tblsetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsurvey`
--

DROP TABLE IF EXISTS `tblsurvey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsurvey` (
  `strSurveyId` varchar(45) NOT NULL,
  `strSurveyTitle` varchar(45) NOT NULL,
  `strSurveyDesc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`strSurveyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsurvey`
--

LOCK TABLES `tblsurvey` WRITE;
/*!40000 ALTER TABLE `tblsurvey` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblsurvey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsurveydetail`
--

DROP TABLE IF EXISTS `tblsurveydetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsurveydetail` (
  `intSDId` int(11) NOT NULL AUTO_INCREMENT,
  `intSDSHId` int(11) NOT NULL,
  `intSDSQId` int(11) NOT NULL,
  `strSDAnswer` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`intSDId`),
  KEY `fkSQSH_idx` (`intSDSHId`),
  KEY `fkSDSQ_idx` (`intSDSQId`),
  CONSTRAINT `fkSDSH` FOREIGN KEY (`intSDSHId`) REFERENCES `tblsurveyheader` (`intSHId`) ON UPDATE CASCADE,
  CONSTRAINT `fkSDSQ` FOREIGN KEY (`intSDSQId`) REFERENCES `tblsurveyquestion` (`intSQId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsurveydetail`
--

LOCK TABLES `tblsurveydetail` WRITE;
/*!40000 ALTER TABLE `tblsurveydetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblsurveydetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsurveyform`
--

DROP TABLE IF EXISTS `tblsurveyform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsurveyform` (
  `intSurveyFormId` int(11) NOT NULL AUTO_INCREMENT,
  `strSurveyFormTitle` varchar(100) NOT NULL,
  `strSurveyFormDesc` varchar(100) DEFAULT NULL,
  `strSurveyForm` text NOT NULL,
  PRIMARY KEY (`intSurveyFormId`),
  KEY `fkSFSurvey_idx` (`strSurveyFormTitle`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsurveyform`
--

LOCK TABLES `tblsurveyform` WRITE;
/*!40000 ALTER TABLE `tblsurveyform` DISABLE KEYS */;
INSERT INTO `tblsurveyform` VALUES (31,'Survey Form','{\"title\":\"Survey Form\",\"description\":\"\",\"fields\":[{\"title\":\"Likert Scale\",\"type\":\"element-multiple-c',''),(32,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false}]}]}'),(33,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false}]},{\"title\":\"What CMS tool is better to use?\",\"type\":\"element-dropdown\",\"required\":true,\"position\":4,\"choices\":[{\"title\":\"Joomla\",\"value\":\"Joomla\",\"checked\":true},{\"title\":\"WordPress\",\"value\":\"WordPress\",\"checked\":false},{\"title\":\"Drupal\",\"value\":\"Drupal\",\"checked\":false}]}]}'),(34,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false}]}]}'),(35,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false},{\"title\":\"Console\",\"value\":\"Console\",\"checked\":false}]}]}'),(36,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false},{\"title\":\"Console\",\"value\":\"Console\",\"checked\":false}]}]}'),(37,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false},{\"title\":\"Console\",\"value\":\"Console\",\"checked\":false}]}]}'),(38,'Sample survey title','','{\"title\":\"Sample survey title\",\"description\":\"\",\"fields\":[{\"title\":\"What is your name?\",\"type\":\"element-single-line-text\",\"required\":false,\"position\":1},{\"title\":\"What is your preferred programming language?\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":2,\"choices\":[{\"title\":\"C\",\"value\":\"C\",\"checked\":true},{\"title\":\"Java\",\"value\":\"Java\",\"checked\":false},{\"title\":\"C#\",\"value\":\"C#\",\"checked\":false},{\"title\":\"PHP\",\"value\":\"PHP\",\"checked\":false}]},{\"title\":\"What gadget you have in your house?\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":3,\"choices\":[{\"title\":\"Smart phone\",\"value\":\"Smart phone\",\"checked\":false},{\"title\":\"Laptop\",\"value\":\"Laptop\",\"checked\":false},{\"title\":\"Desktop\",\"value\":\"Desktop\",\"checked\":false},{\"title\":\"Console\",\"value\":\"Console\",\"checked\":false}]},{\"title\":\"Did you undervote?\",\"type\":\"element-multiple-choice\",\"required\":true,\"position\":4,\"choices\":[{\"title\":\"Yes\",\"value\":\"Yes\",\"checked\":true},{\"title\":\"No\",\"value\":\"No\",\"checked\":false}]}]}');
/*!40000 ALTER TABLE `tblsurveyform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsurveyheader`
--

DROP TABLE IF EXISTS `tblsurveyheader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsurveyheader` (
  `intSHId` int(11) NOT NULL AUTO_INCREMENT,
  `strSHMemCode` varchar(45) NOT NULL,
  `datSHAnswered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`intSHId`,`strSHMemCode`),
  KEY `fkSHMemCode_idx` (`strSHMemCode`),
  CONSTRAINT `fkSHMemCode` FOREIGN KEY (`strSHMemCode`) REFERENCES `tblmember` (`strMemberId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsurveyheader`
--

LOCK TABLES `tblsurveyheader` WRITE;
/*!40000 ALTER TABLE `tblsurveyheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblsurveyheader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsurveyquestion`
--

DROP TABLE IF EXISTS `tblsurveyquestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsurveyquestion` (
  `intSQId` int(11) NOT NULL AUTO_INCREMENT,
  `strSQQuestion` varchar(200) DEFAULT NULL,
  `blSQStatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intSQId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsurveyquestion`
--

LOCK TABLES `tblsurveyquestion` WRITE;
/*!40000 ALTER TABLE `tblsurveyquestion` DISABLE KEYS */;
INSERT INTO `tblsurveyquestion` VALUES (5,'what_is_your_name?',1),(6,'what_is_your_preferred_programming_language?',1),(7,'what_gadget_you_have_in_your_house?',1),(8,'what_cms_tool_is_better_to_use?',0),(9,'did_you_undervote?',1);
/*!40000 ALTER TABLE `tblsurveyquestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluielement`
--

DROP TABLE IF EXISTS `tbluielement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbluielement` (
  `intUIId` int(11) NOT NULL AUTO_INCREMENT,
  `strUISkin` text NOT NULL,
  PRIMARY KEY (`intUIId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluielement`
--

LOCK TABLES `tbluielement` WRITE;
/*!40000 ALTER TABLE `tbluielement` DISABLE KEYS */;
INSERT INTO `tbluielement` VALUES (1,'skin-black-light');
/*!40000 ALTER TABLE `tbluielement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbluser` (
  `intUserId` int(11) NOT NULL AUTO_INCREMENT,
  `strUsername` varchar(45) NOT NULL,
  `strPassword` varchar(45) NOT NULL,
  `strUserEmail` varchar(45) DEFAULT NULL,
  `strUserFname` varchar(45) DEFAULT NULL,
  `strUserLname` varchar(45) DEFAULT NULL,
  `strAccountType` varchar(45) NOT NULL,
  `blDelete` tinyint(1) NOT NULL DEFAULT '0',
  `txtPicPath` tinytext,
  PRIMARY KEY (`intUserId`),
  UNIQUE KEY `strUsername_UNIQUE` (`strUsername`),
  UNIQUE KEY `strUserEmail_UNIQUE` (`strUserEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluser`
--

LOCK TABLES `tbluser` WRITE;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` VALUES (6,'monpaulo','157a8551480389ec4c467f34373cf14d','nomseo@yahoo.com','Mon Paulo','Velasco','Administrator',0,'../assets/img/uploads/Avatar.jpg'),(7,'admin','0941aae3ac81d2bfb2d93c1d741dac33','carlojumgdao@gmail.com','Carlo','Jumagdao','Administrator',0,'../assets/img/uploads/Carlo 1x1 picture.jpg'),(8,'melodylegaspi','c5cf6ece6b550a83a07f344c976ab314','melody@yahoo.com','Melody','Legaspi','Administrator',0,'../assets/img/uploads/tumblr_lkzyc3vNuh1qk266vo1_500.jpg'),(9,'arvin','a5b85dcc021937f1fb0148939ede8cf3','arvin@yahoo.com','Arvin','Gresola','Encoder',0,NULL),(11,'wendell','14871ceeb87a674f03bfc9a21ca09e4b','dogs@yahoo.com','Wendell','Clarete','Encoder',0,'../assets/img/uploads/Vote++ Document Logo.png');
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvotedetail`
--

DROP TABLE IF EXISTS `tblvotedetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblvotedetail` (
  `intVDId` int(11) NOT NULL AUTO_INCREMENT,
  `strVDVHCode` varchar(45) NOT NULL,
  `strVDCandId` varchar(45) NOT NULL,
  PRIMARY KEY (`strVDVHCode`,`strVDCandId`),
  UNIQUE KEY `intVDId_UNIQUE` (`intVDId`),
  KEY `fkVDCandId_idx` (`strVDCandId`),
  CONSTRAINT `fkVDCandId` FOREIGN KEY (`strVDCandId`) REFERENCES `tblcandidate` (`strCandId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvotedetail`
--

LOCK TABLES `tblvotedetail` WRITE;
/*!40000 ALTER TABLE `tblvotedetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblvotedetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvoteheader`
--

DROP TABLE IF EXISTS `tblvoteheader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblvoteheader` (
  `intVHId` int(11) NOT NULL AUTO_INCREMENT,
  `strVHCode` varchar(45) NOT NULL,
  `strVHMemId` varchar(45) NOT NULL,
  `blvotestraight` int(11) NOT NULL,
  `strVHParty` text NOT NULL,
  `blcandidate` int(11) NOT NULL,
  `blundervote` int(11) NOT NULL,
  `datVHVoted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strVHMemId`,`strVHCode`),
  UNIQUE KEY `intVHId_UNIQUE` (`intVHId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvoteheader`
--

LOCK TABLES `tblvoteheader` WRITE;
/*!40000 ALTER TABLE `tblvoteheader` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblvoteheader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blAdmin` tinyint(4) NOT NULL DEFAULT '0',
  `txtPath` text COLLATE utf8_unicode_ci NOT NULL,
  `blDelete` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mon Paulo Velasco','mpvelasco27@outlook.ph','$2y$10$hHPWPCPoUOfV0wLBghVEcemQwgajtCHm.uZ3Z6S1/YtOxdRurc.9C','2Im2oHO9jmciijSK0pC59R01whHcHdfbvMbtK9yAS8jTr8ILZ1M9yNjTnQTI',0,'20160706061213-619520.jpg',0,'2016-06-24 06:49:35','2016-07-22 09:51:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dbvote++'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-23 11:53:05
