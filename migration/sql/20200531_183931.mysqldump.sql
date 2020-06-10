-- MariaDB dump 10.17  Distrib 10.4.13-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: clearance3
-- ------------------------------------------------------
-- Server version	10.4.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_department_id_fk` (`department_id`),
  CONSTRAINT `activity_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity`
--

LOCK TABLES `activity` WRITE;
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` VALUES (1,'Completing Defense',1,'2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'Graduation Payment',2,'2020-05-20 00:00:00','2020-05-19 17:00:00'),(3,'Library Clearance',3,'2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_requirement`
--

DROP TABLE IF EXISTS `activity_requirement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  `depends_on_activity_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_requirement_activity_id_fk` (`activity_id`),
  KEY `activity_requirement_depends_on_activity_id_fk` (`depends_on_activity_id`),
  CONSTRAINT `activity_requirement_activity_id_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activity_requirement_depends_on_activity_id_fk` FOREIGN KEY (`depends_on_activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_requirement`
--

LOCK TABLES `activity_requirement` WRITE;
/*!40000 ALTER TABLE `activity_requirement` DISABLE KEYS */;
INSERT INTO `activity_requirement` VALUES (1,2,1,'2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,3,2,'2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `activity_requirement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alembic_version`
--

DROP TABLE IF EXISTS `alembic_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alembic_version` (
  `version_num` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`version_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alembic_version`
--

LOCK TABLES `alembic_version` WRITE;
/*!40000 ALTER TABLE `alembic_version` DISABLE KEYS */;
INSERT INTO `alembic_version` VALUES ('edbab2aaeb8f');
/*!40000 ALTER TABLE `alembic_version` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puis_student_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_card_uq` (`card`),
  KEY `card_puis_student_id_fk` (`puis_student_id`),
  CONSTRAINT `card_puis_student_id_fk` FOREIGN KEY (`puis_student_id`) REFERENCES `puis_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card`
--

LOCK TABLES `card` WRITE;
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` VALUES (1,'001201300034',1,'2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'001201400056',2,'2020-05-20 00:00:00','2020-05-19 17:00:00'),(3,'001201400012',3,'2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs`
--

DROP TABLE IF EXISTS `cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_status_id` int(11) NOT NULL,
  `signed_by_user_id` int(11) NOT NULL,
  `puis_student_activity_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `cs_cs_status_id_fk` (`cs_status_id`),
  KEY `cs_signed_by_user_id_fk` (`signed_by_user_id`),
  KEY `cs_puis_student_activity_id_fk` (`puis_student_activity_id`),
  KEY `cs_department_id_fk` (`department_id`),
  CONSTRAINT `cs_cs_status_id_fk` FOREIGN KEY (`cs_status_id`) REFERENCES `cs_status` (`id`),
  CONSTRAINT `cs_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  CONSTRAINT `cs_puis_student_activity_id_fk` FOREIGN KEY (`puis_student_activity_id`) REFERENCES `puis_student_activity` (`id`),
  CONSTRAINT `cs_signed_by_user_id_fk` FOREIGN KEY (`signed_by_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs`
--

LOCK TABLES `cs` WRITE;
/*!40000 ALTER TABLE `cs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_status`
--

DROP TABLE IF EXISTS `cs_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cs_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_status`
--

LOCK TABLES `cs_status` WRITE;
/*!40000 ALTER TABLE `cs_status` DISABLE KEYS */;
INSERT INTO `cs_status` VALUES (1,'Uncheck','2020-05-20','2020-05-19 17:00:00'),(2,'Checked','2020-05-20','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `cs_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Faculty','Cubicle','2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'Finance','Finance Dept.','2020-05-20 00:00:00','2020-05-19 17:00:00'),(3,'Library','Adam Kurniawan','2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodi`
--

DROP TABLE IF EXISTS `prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `prodi_prodi_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodi`
--

LOCK TABLES `prodi` WRITE;
/*!40000 ALTER TABLE `prodi` DISABLE KEYS */;
INSERT INTO `prodi` VALUES (1,'CIT - Information Technology Study Program','2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'EEN  Electrical Engineering Study Program','2020-05-20 00:00:00','2020-05-19 17:00:00'),(3,'IEN  Industrial Engineering Study Program','2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `prodi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puis_student`
--

DROP TABLE IF EXISTS `puis_student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puis_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `defense_date` date NOT NULL,
  `prodi_id` int(11) NOT NULL,
  `puis_student_status_id` int(11) NOT NULL,
  `toga_size_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `puis_student_student_id_uindex` (`student_id`),
  KEY `puis_student_prodi_id_fk` (`prodi_id`),
  KEY `puis_student_puis_student_status_id_fk` (`puis_student_status_id`),
  KEY `puis_student_toga_size_id_fk` (`toga_size_id`),
  CONSTRAINT `puis_student_prodi_id_fk` FOREIGN KEY (`prodi_id`) REFERENCES `prodi` (`id`),
  CONSTRAINT `puis_student_puis_student_status_id_fk` FOREIGN KEY (`puis_student_status_id`) REFERENCES `puis_student_status` (`id`),
  CONSTRAINT `puis_student_toga_size_id_fk` FOREIGN KEY (`toga_size_id`) REFERENCES `toga_size` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puis_student`
--

LOCK TABLES `puis_student` WRITE;
/*!40000 ALTER TABLE `puis_student` DISABLE KEYS */;
INSERT INTO `puis_student` VALUES (1,'I Made Primayana Martha','primamartha@gmail.com',2013,'1995-11-09','2018-07-01',1,1,2,'2020-05-20 00:00:00','2020-06-01 10:32:37','001'),(2,'Alpinta Harjanto','primamartha@gmail.com',2014,'1996-06-25','2018-05-12',2,2,2,'2020-05-20 00:00:00','2020-06-01 10:32:37','002'),(3,'Andre Leo','andreleo2604@gmail.com',2014,'1996-04-26','2020-01-06',3,2,2,'2020-05-20 00:00:00','2020-06-01 10:32:37','003');
/*!40000 ALTER TABLE `puis_student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puis_student_activity`
--

DROP TABLE IF EXISTS `puis_student_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puis_student_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `puis_student_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `signed_by_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `puis_student_activity_puis_student_id_activity_id_uq` (`puis_student_id`,`activity_id`),
  KEY `puis_student_activity_activity_id_fk` (`activity_id`),
  KEY `puis_student_activity_signed_by_user_id` (`signed_by_user_id`),
  CONSTRAINT `puis_student_activity_activity_id_fk` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `puis_student_activity_puis_student_id_fk` FOREIGN KEY (`puis_student_id`) REFERENCES `puis_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `puis_student_activity_signed_by_user_id` FOREIGN KEY (`signed_by_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puis_student_activity`
--

LOCK TABLES `puis_student_activity` WRITE;
/*!40000 ALTER TABLE `puis_student_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `puis_student_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `puis_student_status`
--

DROP TABLE IF EXISTS `puis_student_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puis_student_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `puis_student_status_status_uindex` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `puis_student_status`
--

LOCK TABLES `puis_student_status` WRITE;
/*!40000 ALTER TABLE `puis_student_status` DISABLE KEYS */;
INSERT INTO `puis_student_status` VALUES (1,'graduate','2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'ungraduate','2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `puis_student_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_role_uindex` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'staff','2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `toga_size`
--

DROP TABLE IF EXISTS `toga_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `toga_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `toga_size`
--

LOCK TABLES `toga_size` WRITE;
/*!40000 ALTER TABLE `toga_size` DISABLE KEYS */;
INSERT INTO `toga_size` VALUES (1,'M','2020-05-20 00:00:00','2020-05-19 17:00:00'),(2,'L','2020-05-20 00:00:00','2020-05-19 17:00:00'),(3,'XL','2020-05-20 00:00:00','2020-05-19 17:00:00');
/*!40000 ALTER TABLE `toga_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email_uindex` (`email`),
  UNIQUE KEY `user_username_uindex` (`username`),
  KEY `user_department_id_fk` (`department_id`),
  KEY `user_roles_id_fk` (`roles_id`),
  CONSTRAINT `user_department_id_fk` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_roles_id_fk` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (4,'admin','admin@example.com','$pbkdf2-sha512$25000$NsbYG6OUMoZwDuEcY6xVCg$hr8hr1dsDhLw9ZItU6Dn5oi8gKJCxVTabbxAiOou6trospeR8Hh7Y0/phCU2T2gWDxnC5PBSbj9QfrRiiQqvQw',1,1,'2020-05-31 12:00:56','2020-05-30 22:01:07'),(5,'imouto','imouto@example.com','imouto',1,2,'2020-05-31 12:00:56','2020-05-31 05:00:56');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-02 10:26:35
