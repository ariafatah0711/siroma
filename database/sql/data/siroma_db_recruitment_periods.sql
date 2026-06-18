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
-- Table structure for table `recruitment_periods`
--

DROP TABLE IF EXISTS `recruitment_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recruitment_periods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `recruitment_title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `academic_year` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration_start_date` date NOT NULL,
  `registration_end_date` date NOT NULL,
  `total_quota` int unsigned NOT NULL DEFAULT '1',
  `recruitment_status` enum('draft','open','closed','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_recruitment_periods_creator` (`created_by`),
  KEY `idx_recruitment_periods_org_status_dates` (`organization_id`,`recruitment_status`,`registration_start_date`,`registration_end_date`),
  CONSTRAINT `fk_recruitment_periods_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_recruitment_periods_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recruitment_periods`
--

LOCK TABLES `recruitment_periods` WRITE;
/*!40000 ALTER TABLE `recruitment_periods` DISABLE KEYS */;
INSERT INTO `recruitment_periods` VALUES (1,1,2,'Open Recruitment BEM 2026','2025/2026','2026-06-15','2026-06-30',20,'open','Penerimaan anggota baru Badan Eksekutif Mahasiswa (BEM) periode 2026.','2026-06-15 17:58:04','2026-06-15 17:58:04'),(2,2,3,'Open Recruitment HIMA TI 2026','2025/2026','2026-06-15','2026-06-30',15,'open','Bergabunglah dengan Himpunan Mahasiswa Teknik Informatika (HIMA TI) 2026.','2026-06-15 17:58:04','2026-06-15 17:58:04'),(3,3,4,'Open Recruitment NF Cyber Security 2026','2025/2026','2026-06-15','2026-06-30',10,'open','Pendaftaran anggota baru Nurul Fikri Cyber Security Community (NFCC) 2026.','2026-06-15 17:58:04','2026-06-15 17:58:04'),(4,4,NULL,'Open Rekrutmen GDGNF','2026','2026-06-02','2026-07-18',50,'open',NULL,'2026-06-15 20:53:46','2026-06-15 21:08:26');
/*!40000 ALTER TABLE `recruitment_periods` ENABLE KEYS */;
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
