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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faculty` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `study_program` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entry_year` year DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_student_number` (`student_number`),
  UNIQUE KEY `uq_users_email` (`email`),
  KEY `idx_users_full_name` (`full_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'00000001','Super Admin','admin@localhost','$2y$12$GNqMi4a/X24PdF/4Bppo2e3KXZoD4S3UH1OsNaaOWRem3nRmBq1m2','081234560001','Direktorat IT','Infrastruktur',2022,1,'2026-06-15 17:58:04','2026-06-15 17:58:04'),(2,'00000002','Reviewer BEM','bem@localhost','$2y$12$2y4omwsQg7sgT3yhwlqxBuND9vxJFZdQJuFodtQkxuebgUKBHzFnq','081234560002','Fakultas Ilmu Komputer','Sistem Informasi',2023,1,'2026-06-15 17:58:04','2026-06-15 17:58:04'),(3,'00000003','Reviewer HIMA TI','hima@localhost','$2y$12$yt1Q1G87ac2QKJ97CfbHn.6llHpNOQxIU1WqIV6.zrIBHV0mQOYdW','081234560003','Fakultas Ilmu Komputer','Informatika',2023,1,'2026-06-15 17:58:04','2026-06-15 17:58:04'),(4,'00000004','Reviewer NFCC','nfcc@localhost','$2y$12$rTb1GVaiXui5ZZAHJCVXc.8ukyrWbx0txJspGoD3O11Sknq/ZHWVa','081234560004','Fakultas Ilmu Komputer','Informatika',2023,1,'2026-06-15 17:58:04','2026-06-15 17:58:04'),(5,'24010001','aria','aria@localhost','$2y$12$3ayVBygxpR6LcHvg/iBbHugOfKLKHC9rDh4hBGVaLcT2LmSMTPCcu','081234560005','Fakultas Ilmu Komputer','Informatika',2024,1,'2026-06-15 17:58:04','2026-06-15 17:58:04');
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

-- Dump completed on 2026-06-18 14:11:49
