-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: jul-dev
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
-- Table structure for table `tze_email_newsletter`
--

DROP TABLE IF EXISTS `tze_email_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_email_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nws_email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nws_subscribed` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AB2B3778D5D52DEC` (`nws_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_email_newsletter`
--

LOCK TABLES `tze_email_newsletter` WRITE;
/*!40000 ALTER TABLE `tze_email_newsletter` DISABLE KEYS */;
INSERT INTO `tze_email_newsletter` VALUES (1,'julienrajerison5@gmail.com',1);
/*!40000 ALTER TABLE `tze_email_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tze_message_newsletter`
--

DROP TABLE IF EXISTS `tze_message_newsletter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_message_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_message_newsletter`
--

LOCK TABLES `tze_message_newsletter` WRITE;
/*!40000 ALTER TABLE `tze_message_newsletter` DISABLE KEYS */;
INSERT INTO `tze_message_newsletter` VALUES (1);
/*!40000 ALTER TABLE `tze_message_newsletter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tze_message_newsletter_translation`
--

DROP TABLE IF EXISTS `tze_message_newsletter_translation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_message_newsletter_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `message_newsletter_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_newsletter_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tze_message_newsletter_translation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_5839731D2C2AC5D3` (`translatable_id`),
  CONSTRAINT `FK_5839731D2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tze_message_newsletter` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_message_newsletter_translation`
--

LOCK TABLES `tze_message_newsletter_translation` WRITE;
/*!40000 ALTER TABLE `tze_message_newsletter_translation` DISABLE KEYS */;
INSERT INTO `tze_message_newsletter_translation` VALUES (1,1,'aaaa','<p>zaaaaaaaaaaaaa</p>','fr');
/*!40000 ALTER TABLE `tze_message_newsletter_translation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tze_role`
--

DROP TABLE IF EXISTS `tze_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rl_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_role`
--

LOCK TABLES `tze_role` WRITE;
/*!40000 ALTER TABLE `tze_role` DISABLE KEYS */;
INSERT INTO `tze_role` VALUES (1,'Superadmin'),(2,'Admin'),(3,'Member');
/*!40000 ALTER TABLE `tze_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tze_slide`
--

DROP TABLE IF EXISTS `tze_slide`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sld_first_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_second_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_third_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_slide`
--

LOCK TABLES `tze_slide` WRITE;
/*!40000 ALTER TABLE `tze_slide` DISABLE KEYS */;
INSERT INTO `tze_slide` VALUES (1,'EA','AE','ZA','/upload/slide/bf0361049750c3fff61ee95d82deeb3b.png'),(2,'Testeaaaa','teste','Aaaaa','/upload/slide/b9cd6557092a9a53b2d3292666e6a4f1.png');
/*!40000 ALTER TABLE `tze_slide` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tze_user`
--

DROP TABLE IF EXISTS `tze_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tze_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tze_role_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `usr_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_date_create` datetime DEFAULT NULL,
  `usr_date_update` datetime DEFAULT NULL,
  `usr_phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_is_valid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_canonical_UNIQUE` (`username_canonical`),
  UNIQUE KEY `email_canonical_UNIQUE` (`email_canonical`),
  UNIQUE KEY `confirmation_token_UNIQUE` (`confirmation_token`),
  KEY `IDX_A98A6686CC5EF58D` (`tze_role_id`),
  CONSTRAINT `FK_A98A6686CC5EF58D` FOREIGN KEY (`tze_role_id`) REFERENCES `tze_role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tze_user`
--

LOCK TABLES `tze_user` WRITE;
/*!40000 ALTER TABLE `tze_user` DISABLE KEYS */;
INSERT INTO `tze_user` VALUES (1,1,'julien','julien','julienrajerison5@gmail.com','julienrajerison5@gmail.com',1,NULL,'$2y$13$CzOV8aI87NL0iqDviZz/SemLlKUhfRxLFpQ/s0c1pk2PcFPSCexxK','2019-02-14 13:29:59',NULL,NULL,'a:1:{i:0;s:15:\"ROLE_SUPERADMIN\";}','teste','teste','teste','2019-01-24 22:59:34','2019-01-24 23:03:28','0329473033',NULL,0);
/*!40000 ALTER TABLE `tze_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190124205803'),('20190128053150'),('20190128102308'),('20190214103107');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'jul-dev'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-14 14:34:48
