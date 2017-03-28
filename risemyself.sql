-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for osx10.6 (i386)
--
-- Host: localhost    Database: risemyself
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Category identifier',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT 'Default is category  for experts, i.e. type of  user =  2',
  `title` varchar(255) NOT NULL COMMENT 'Name of category',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,2,'Psychologists'),(2,2,'Nutritionists');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedbacks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Feedback identifier',
  `title` varchar(45) NOT NULL DEFAULT 'Untitled' COMMENT 'Title of Feedback',
  `feedback` tinytext NOT NULL COMMENT 'Feedback text',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

LOCK TABLES `feedbacks` WRITE;
/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,'Untitled','Ja tu nista ne  bi  menjao');
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meetings`
--

DROP TABLE IF EXISTS `meetings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meetings` (
  `id` int(10) unsigned NOT NULL COMMENT 'Meeting identifier',
  `customer_id` int(10) unsigned NOT NULL COMMENT 'Customer user identifier',
  `expert_id` int(10) unsigned NOT NULL COMMENT 'Expert user identifier',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time of meeting',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `customer_fk_idx` (`customer_id`),
  KEY `expert_fk_idx` (`expert_id`),
  CONSTRAINT `customer_fk_meet` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `expert_fk_meet` FOREIGN KEY (`expert_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meetings`
--

LOCK TABLES `meetings` WRITE;
/*!40000 ALTER TABLE `meetings` DISABLE KEYS */;
/*!40000 ALTER TABLE `meetings` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Note identifier',
  `meeting_id` int(10) unsigned NOT NULL COMMENT 'Related meeting identifier',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Related user identifier',
  `note` text NOT NULL COMMENT 'Notes from meeting',
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_id_UNIQUE` (`id`),
  KEY `customer_fk_note_idx` (`user_id`),
  KEY `meeting_fk_idx` (`meeting_id`),
  CONSTRAINT `meeting_fk` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('strahinja.s.banovic@gmail.com','120dd917261dc5ba375de3f6fa29f36a205e8528885e8b0eb46dfec7b5c85928','2016-08-13 03:27:01');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `customer_id` int(10) unsigned NOT NULL COMMENT 'Related customer user identifier',
  `expert_id` int(10) unsigned NOT NULL COMMENT 'Related expert user identifier',
  `rating` tinyint(5) unsigned NOT NULL COMMENT 'Rating points',
  `review` varchar(255) NOT NULL DEFAULT 'Described review wasn''t left.',
  PRIMARY KEY (`customer_id`,`expert_id`),
  UNIQUE KEY `UNIQUE` (`customer_id`,`expert_id`),
  KEY `expert_fk_idx` (`expert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (4,3,4,'Very Good'),(4,5,5,'Awesome'),(4,6,3,'Good.'),(4,7,2,'Can pass'),(4,8,1,'Aweful');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `searches`
--

DROP TABLE IF EXISTS `searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `searches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Search identifier',
  `text` varchar(255) NOT NULL COMMENT 'Searched text',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `searches`
--

LOCK TABLES `searches` WRITE;
/*!40000 ALTER TABLE `searches` DISABLE KEYS */;
INSERT INTO `searches` VALUES (1,'ovo'),(2,'ono'),(3,'ovo'),(4,'do'),(5,'jaja');
/*!40000 ALTER TABLE `searches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_category`
--

DROP TABLE IF EXISTS `user_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_category` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'Related User identifier',
  `category_id` int(10) unsigned NOT NULL COMMENT 'Related Category identifier',
  PRIMARY KEY (`user_id`,`category_id`),
  KEY `user_fk_idx` (`user_id`),
  KEY `category_fk_idx` (`category_id`),
  CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_category`
--

LOCK TABLES `user_category` WRITE;
/*!40000 ALTER TABLE `user_category` DISABLE KEYS */;
INSERT INTO `user_category` VALUES (3,1),(5,2),(6,2),(7,1),(8,1);
/*!40000 ALTER TABLE `user_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User Identifier',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UnKnown' COMMENT 'First name of User',
  `middlename` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Person',
  `email` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Email  of User',
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Username of User',
  `password` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Password',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT 'Type  of User\ntype  0 = admin\ntype  1 = customer\ntype  2 = expert',
  `authorized` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Does User confirm his email address?\nYes = 1\nNo  = 0',
  `suspended` tinyint(1) NOT NULL DEFAULT '0',
  `state` int(10) unsigned DEFAULT NULL COMMENT 'State ID from  states teble',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'City where user lives',
  `zipcode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Zip  Code where User lives',
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Profile Image of User',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Sex of User\nUndefined = 0\nMale = 1\nFemale = 2',
  `birthday` timestamp NULL DEFAULT NULL,
  `price` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT 'Price  per  hour for  Experts',
  `remember_token` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Token',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time of creating record',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and  time of updating record',
  `payment` varchar(45) CHARACTER SET utf8 DEFAULT 'TODO' COMMENT 'TODO',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Strahinja','Sebastian','Banovic','strahinja.s.banovic@gmail.com','straja','$2y$10$E1JrmwgjW/2Xf0TjCsbGBOh/D3ZmGEp91E/lJ2Tz.YYi6kg8NiLey',0,1,0,NULL,NULL,NULL,NULL,0,NULL,25.00,'oAJR8UpURslSLlom1BI9S3WxYN2Qdl7Ncm6AOZRGf8x2ML9wprYfZDjSb4Ek','2016-08-13 04:11:25','2016-08-16 14:29:03','TODO'),(2,'Oliver',NULL,'Milenovic','oliver.milenovic@gmail.com','oli','$2y$10$mZjKcXFNNvsawOFMEaTzHO7CpHMP.smC7YZ1W.bb1iQPxka0n/Ky2',0,1,0,NULL,NULL,NULL,NULL,0,NULL,12.59,NULL,'2016-08-13 04:16:36','2016-08-13 04:16:36','TODO'),(3,'Test1',NULL,'Test','testis','test1','asdfasdf',2,1,0,NULL,NULL,NULL,NULL,0,NULL,10.00,NULL,'2016-08-16 13:50:15','2016-08-16 13:50:15','TODO'),(4,'Test2',NULL,'Test','tst','test2','asdfsdaf',1,1,0,NULL,NULL,NULL,NULL,0,NULL,0.00,NULL,'2016-08-16 13:50:15','2016-08-16 13:50:15','TODO'),(5,'Test3',NULL,'Test','tests','test3','asdfdsafa',2,1,0,NULL,NULL,NULL,NULL,0,NULL,11.00,NULL,'2016-08-16 13:50:15','2016-08-16 13:50:15','TODO'),(6,'Test4',NULL,'Test','asdfadsf','test4','asdfasdf',2,1,0,NULL,NULL,NULL,NULL,0,NULL,20.00,NULL,'2016-08-16 17:49:27','2016-08-16 17:49:27','TODO'),(7,'Test5',NULL,'Test','asdfasdfasdfasd','test5','assdfasdfasdfasfd',2,1,0,NULL,NULL,NULL,NULL,0,NULL,0.00,NULL,'2016-08-16 17:49:27','2016-08-16 17:49:27','TODO'),(8,'Test6',NULL,'Test','asdf','test6','asdfasdfasdfasdfasdfasdf',2,1,0,NULL,NULL,NULL,NULL,0,NULL,0.00,NULL,'2016-08-16 17:51:04','2016-08-16 17:51:04','TODO');
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

-- Dump completed on 2016-08-16 19:56:07
