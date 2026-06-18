-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: siroma_db
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `application_status_history`
--

DROP TABLE IF EXISTS `application_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_status_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint unsigned DEFAULT NULL,
  `application_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `change_note` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_application_status_history_app_date` (`application_id`,`changed_at`),
  CONSTRAINT `fk_application_status_history_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_status_history`
--

LOCK TABLES `application_status_history` WRITE;
/*!40000 ALTER TABLE `application_status_history` DISABLE KEYS */;
INSERT INTO `application_status_history` VALUES (1,1,'APP-20260616-CAED8424',NULL,'submitted','Aplikasi dibuat melalui sp_submit_application.','2026-06-15 18:05:29'),(2,1,'APP-20260616-CAED8424','submitted','under_review','Seleksi dimulai oleh reviewer.','2026-06-15 18:09:20'),(3,1,'APP-20260616-CAED8424','under_review','rejected','kureng\n','2026-06-15 18:32:42'),(4,1,'APP-20260616-CAED8424','rejected','submitted','Status diubah langsung melalui perintah UPDATE.','2026-06-15 18:33:25'),(5,1,'APP-20260616-CAED8424','submitted','under_review','Seleksi dimulai oleh reviewer.','2026-06-15 18:36:20'),(6,1,'APP-20260616-CAED8424','under_review','interview','Berkas dinyatakan lolos. Pendaftar masuk ke tahap wawancara.','2026-06-15 18:36:42'),(7,1,'APP-20260616-CAED8424','interview','accepted','bagus bre','2026-06-15 18:49:37'),(8,2,'APP-20260616-0D7D9CCE',NULL,'submitted','Aplikasi dibuat melalui sp_submit_application.','2026-06-16 04:08:38'),(9,2,'APP-20260616-0D7D9CCE','submitted','under_review','Seleksi dimulai oleh reviewer.','2026-06-16 04:14:19'),(10,2,'APP-20260616-0D7D9CCE','under_review','rejected','kureng kureng kureng','2026-06-16 04:14:32');
/*!40000 ALTER TABLE `application_status_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-18 14:11:48
