CREATE DATABASE  IF NOT EXISTS `dbVote++` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbVote++`;
-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: dbVote++
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `tblCandidate`
--

DROP TABLE IF EXISTS `tblCandidate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblCandidate` (
  `strCandId` varchar(45) NOT NULL,
  `strCandMemId` varchar(45) NOT NULL,
  `strCandPosId` varchar(45) NOT NULL,
  `intCandParId` int(11) DEFAULT NULL,
  `txtCandPic` tinytext NOT NULL,
  `blCandDelete` tinyint(1) NOT NULL,
  PRIMARY KEY (`strCandMemId`,`strCandPosId`,`blCandDelete`),
  UNIQUE KEY `strCandId_UNIQUE` (`strCandId`),
  KEY `fkCandMem_idx` (`strCandMemId`),
  KEY `fkCandPos_idx` (`strCandPosId`),
  KEY `fkCandParty_idx` (`intCandParId`),
  CONSTRAINT `fkCandMem` FOREIGN KEY (`strCandMemId`) REFERENCES `tblMember` (`strMemberId`) ON UPDATE CASCADE,
  CONSTRAINT `fkCandParty` FOREIGN KEY (`intCandParId`) REFERENCES `tblParty` (`intPartyId`) ON UPDATE CASCADE,
  CONSTRAINT `fkCandPos` FOREIGN KEY (`strCandPosId`) REFERENCES `tblPosition` (`strPositionId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblCandidate`
--

LOCK TABLES `tblCandidate` WRITE;
/*!40000 ALTER TABLE `tblCandidate` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblCandidate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblDynamicField`
--

DROP TABLE IF EXISTS `tblDynamicField`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblDynamicField` (
  `intDynFieldId` int(11) NOT NULL AUTO_INCREMENT,
  `strDynFieldName` varchar(100) NOT NULL,
  `blDynStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`intDynFieldId`),
  UNIQUE KEY `strDynFieldName_UNIQUE` (`strDynFieldName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblDynamicField`
--

LOCK TABLES `tblDynamicField` WRITE;
/*!40000 ALTER TABLE `tblDynamicField` DISABLE KEYS */;
INSERT INTO `tblDynamicField` VALUES (1,'region',0),(2,'chapter',1),(3,'department',1),(5,'gender',1);
/*!40000 ALTER TABLE `tblDynamicField` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblMember`
--

DROP TABLE IF EXISTS `tblMember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblMember` (
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
-- Dumping data for table `tblMember`
--

LOCK TABLES `tblMember` WRITE;
/*!40000 ALTER TABLE `tblMember` DISABLE KEYS */;
INSERT INTO `tblMember` VALUES ('CODE001','Carlo','Labrague','Jumagdao','carlojumagdao@silidaralan.org',0,NULL,'12unjk',0,0,'2016-06-21 07:41:20','2016-06-21 15:07:14'),('CODE002','Gabriel','','Jumagdao','gabrieljumagdao@gmail.com',NULL,NULL,'mK2Ejp',0,0,'2016-06-21 13:38:43','2016-06-21 13:38:43'),('CODE003','Cristina','','Jumagdao','cristinajumagdao@gmail.com',NULL,NULL,'0g5olD',0,0,'2016-06-21 15:08:33','2016-06-21 15:27:37');
/*!40000 ALTER TABLE `tblMember` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblMemberDetail`
--

DROP TABLE IF EXISTS `tblMemberDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblMemberDetail` (
  `intMemDeId` int(11) NOT NULL AUTO_INCREMENT,
  `strMemDeMemId` varchar(45) NOT NULL,
  `strMemDeFieldName` varchar(45) NOT NULL,
  `strMemDeFieldData` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`intMemDeId`),
  UNIQUE KEY `intMemDeId_UNIQUE` (`intMemDeId`),
  KEY `fkMemDeMem_idx` (`strMemDeMemId`),
  KEY `fkMemDeFieldName_idx1` (`strMemDeFieldName`),
  CONSTRAINT `fkMemDeFieldName` FOREIGN KEY (`strMemDeFieldName`) REFERENCES `tblDynamicField` (`strDynFieldName`) ON UPDATE CASCADE,
  CONSTRAINT `fkMemDeMemId` FOREIGN KEY (`strMemDeMemId`) REFERENCES `tblMember` (`strMemberId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblMemberDetail`
--

LOCK TABLES `tblMemberDetail` WRITE;
/*!40000 ALTER TABLE `tblMemberDetail` DISABLE KEYS */;
INSERT INTO `tblMemberDetail` VALUES (37,'CODE001','department','Finance'),(38,'CODE001','chapter','Luzon'),(39,'CODE002','department','IT'),(40,'CODE002','chapter','Luzon'),(41,'CODE003','department','Finance'),(42,'CODE003','chapter','Visayas'),(44,'CODE003','gender','Female');
/*!40000 ALTER TABLE `tblMemberDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblMemberForm`
--

DROP TABLE IF EXISTS `tblMemberForm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblMemberForm` (
  `intMemForm` int(11) NOT NULL AUTO_INCREMENT,
  `strMemFormTitle` varchar(100) NOT NULL,
  `strMemForm` text NOT NULL,
  PRIMARY KEY (`intMemForm`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblMemberForm`
--

LOCK TABLES `tblMemberForm` WRITE;
/*!40000 ALTER TABLE `tblMemberForm` DISABLE KEYS */;
INSERT INTO `tblMemberForm` VALUES (2,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5}]}'),(3,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Region\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(4,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(5,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]}]}'),(6,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Age\",\"type\":\"element-number\",\"required\":false,\"position\":8},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":9,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}'),(7,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Age\",\"type\":\"element-number\",\"required\":false,\"position\":7},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":8,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":9,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}'),(8,'Organization Member Form','{\"title\":\"Organization Member Form\",\"fields\":[{\"title\":\"Member ID\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":1},{\"title\":\"First Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":2},{\"title\":\"Middle Name\",\"type\":\"element-single-line-text-default\",\"required\":false,\"position\":3},{\"title\":\"Last Name\",\"type\":\"element-single-line-text-default\",\"required\":true,\"position\":4},{\"title\":\"Email\",\"type\":\"element-email\",\"required\":true,\"position\":5},{\"title\":\"Department\",\"type\":\"element-dropdown\",\"required\":false,\"position\":6,\"choices\":[{\"title\":\"Finance\",\"value\":\"Finance\",\"checked\":true},{\"title\":\"IT\",\"value\":\"IT\",\"checked\":false},{\"title\":\"Marketing\",\"value\":\"Marketing\",\"checked\":false}]},{\"title\":\"Chapter\",\"type\":\"element-checkboxes\",\"required\":false,\"position\":7,\"choices\":[{\"title\":\"Luzon\",\"value\":\"Luzon\",\"checked\":false},{\"title\":\"Visayas\",\"value\":\"Visayas\",\"checked\":false},{\"title\":\"Mindanao\",\"value\":\"Mindanao\",\"checked\":false}]},{\"title\":\"Gender\",\"type\":\"element-multiple-choice\",\"required\":false,\"position\":8,\"choices\":[{\"title\":\"Male\",\"value\":\"Male\",\"checked\":true},{\"title\":\"Female\",\"value\":\"Female\",\"checked\":false}]}]}');
/*!40000 ALTER TABLE `tblMemberForm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblParty`
--

DROP TABLE IF EXISTS `tblParty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblParty` (
  `intPartyId` int(11) NOT NULL AUTO_INCREMENT,
  `strPartyName` varchar(45) NOT NULL,
  `strPartyLeader` varchar(45) DEFAULT NULL,
  `txtPartyPic` text,
  `strPartyColor` varchar(45) NOT NULL DEFAULT '#ffffff',
  `blPartyDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intPartyId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblParty`
--

LOCK TABLES `tblParty` WRITE;
/*!40000 ALTER TABLE `tblParty` DISABLE KEYS */;
INSERT INTO `tblParty` VALUES (1,'Independent','None','none','#ffffff',0),(2,'Liberal Party','Benigno \"Ninoy\" Aquino III',NULL,'#f7df02',0),(3,'United Nationalist Alliance','Jejomar Binay',NULL,'#e89517',0);
/*!40000 ALTER TABLE `tblParty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPosition`
--

DROP TABLE IF EXISTS `tblPosition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPosition` (
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
-- Dumping data for table `tblPosition`
--

LOCK TABLES `tblPosition` WRITE;
/*!40000 ALTER TABLE `tblPosition` DISABLE KEYS */;
INSERT INTO `tblPosition` VALUES ('POS001','President','',1,0),('POS002','Vice President of Marketing in North Chapter','#c72727',1,0);
/*!40000 ALTER TABLE `tblPosition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblPositionDetail`
--

DROP TABLE IF EXISTS `tblPositionDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblPositionDetail` (
  `intPosDeId` int(11) NOT NULL AUTO_INCREMENT,
  `strPosDePosId` varchar(45) NOT NULL,
  `strPosDeFieldName` varchar(80) NOT NULL,
  `strPosDeFieldData` varchar(80) NOT NULL,
  PRIMARY KEY (`intPosDeId`),
  KEY `fkPosDePos_idx` (`strPosDePosId`),
  KEY `fkPosDeFieldName_idx` (`strPosDeFieldName`),
  CONSTRAINT `fkPosDePosId` FOREIGN KEY (`strPosDePosId`) REFERENCES `tblPosition` (`strPositionId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblPositionDetail`
--

LOCK TABLES `tblPositionDetail` WRITE;
/*!40000 ALTER TABLE `tblPositionDetail` DISABLE KEYS */;
INSERT INTO `tblPositionDetail` VALUES (32,'POS002','department','Marketing'),(33,'POS002','chapter','Luzon'),(34,'POS002','chapter','Visayas');
/*!40000 ALTER TABLE `tblPositionDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSecurityQuestion`
--

DROP TABLE IF EXISTS `tblSecurityQuestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSecurityQuestion` (
  `intSecQuesId` int(11) NOT NULL AUTO_INCREMENT,
  `strSecQuestion` varchar(100) NOT NULL,
  `blSecQuesDelete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`intSecQuesId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSecurityQuestion`
--

LOCK TABLES `tblSecurityQuestion` WRITE;
/*!40000 ALTER TABLE `tblSecurityQuestion` DISABLE KEYS */;
INSERT INTO `tblSecurityQuestion` VALUES (1,'What is your mother\'s maiden name?',0),(2,'What is your favorite pet\'s name?',0),(3,'Who is your first love?',1);
/*!40000 ALTER TABLE `tblSecurityQuestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblSetting`
--

DROP TABLE IF EXISTS `tblSetting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblSetting` (
  `intSettingId` int(11) NOT NULL AUTO_INCREMENT,
  `strSetElecName` varchar(100) NOT NULL,
  `strSetElecDesc` text NOT NULL,
  `datSetStart` date NOT NULL,
  `datSetEnd` date NOT NULL,
  `blSetSurvey` tinyint(1) NOT NULL DEFAULT '0',
  `blSetParty` tinyint(1) NOT NULL DEFAULT '0',
  `txtSetLogo` text,
  PRIMARY KEY (`intSettingId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblSetting`
--

LOCK TABLES `tblSetting` WRITE;
/*!40000 ALTER TABLE `tblSetting` DISABLE KEYS */;
INSERT INTO `tblSetting` VALUES (1,'TUP National Election','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sit amet massa enim. Ut id semper lorem. Nulla faucibus augue ac tortor viverra eleifend. Mauris condimentum ultrices erat, sit amet dictum leo malesuada quis. In justo mi, cursus ut sapien vel, faucibus tincidunt dui. Donec ac pulvinar ante, vitae dapibus ligula. Nullam ut libero a tortor aliquet condimentum finibus vel lectus. Mauris ex sem, sollicitudin ac aliquet sed, lobortis in neque. Praesent sit amet lectus congue, vehicula turpis in, venenatis felisa.','2016-06-18','2016-06-20',0,1,NULL);
/*!40000 ALTER TABLE `tblSetting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblVoteDetail`
--

DROP TABLE IF EXISTS `tblVoteDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblVoteDetail` (
  `intVDId` int(11) NOT NULL AUTO_INCREMENT,
  `strVDVHCode` varchar(45) NOT NULL,
  `strVDCandId` varchar(45) NOT NULL,
  PRIMARY KEY (`strVDVHCode`,`strVDCandId`),
  UNIQUE KEY `intVDId_UNIQUE` (`intVDId`),
  KEY `fkVDCandId_idx` (`strVDCandId`),
  CONSTRAINT `fkVDCandId` FOREIGN KEY (`strVDCandId`) REFERENCES `tblCandidate` (`strCandId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblVoteDetail`
--

LOCK TABLES `tblVoteDetail` WRITE;
/*!40000 ALTER TABLE `tblVoteDetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblVoteDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblVoteHeader`
--

DROP TABLE IF EXISTS `tblVoteHeader`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblVoteHeader` (
  `intVHId` int(11) NOT NULL AUTO_INCREMENT,
  `strVHCode` varchar(45) NOT NULL,
  `strVHMemId` varchar(45) NOT NULL,
  `datVHVoted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strVHMemId`,`strVHCode`),
  UNIQUE KEY `intVHId_UNIQUE` (`intVHId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblVoteHeader`
--

LOCK TABLES `tblVoteHeader` WRITE;
/*!40000 ALTER TABLE `tblVoteHeader` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblVoteHeader` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-23  0:15:49
