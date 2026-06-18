-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table siroma_db.applications
DROP TABLE IF EXISTS `applications`;
CREATE TABLE IF NOT EXISTS `applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `recruitment_period_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `motivation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_score` decimal(5,2) DEFAULT NULL,
  `application_status` enum('submitted','under_review','interview','accepted','rejected','withdrawn') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `reviewer_notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reviewed_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_applications_recruitment_user` (`recruitment_period_id`,`user_id`),
  UNIQUE KEY `uq_applications_code` (`application_code`),
  KEY `fk_applications_user` (`user_id`),
  KEY `idx_applications_recruitment_status_date` (`recruitment_period_id`,`application_status`,`submitted_at`),
  CONSTRAINT `fk_applications_recruitment` FOREIGN KEY (`recruitment_period_id`) REFERENCES `recruitment_periods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_applications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.applications: ~2 rows (approximately)
INSERT INTO `applications` (`id`, `application_code`, `recruitment_period_id`, `user_id`, `motivation`, `final_score`, `application_status`, `reviewer_notes`, `submitted_at`, `reviewed_at`, `updated_at`) VALUES
	(1, 'APP-20260616-CAED8424', 1, 5, 'pengen belajr heheheheheheheh  pengen belajr heheheheheheheh pengen belajr hehehehehehehehpengen belajr heheheheheheheh pengen belajr hehehehehehehehpengen belajr hehehehehehehehpengen belajr heheheheheheheh', 76.00, 'accepted', 'bagus bre', '2026-06-15 18:05:29', '2026-06-16 01:49:37', '2026-06-15 18:49:37'),
	(2, 'APP-20260616-0D7D9CCE', 4, 5, 'sedang mencoba apply sih ini semoga bisa................', 0.00, 'rejected', 'kureng kureng kureng', '2026-06-16 04:08:38', '2026-06-16 11:14:32', '2026-06-16 04:14:32');

-- Dumping structure for table siroma_db.application_documents
DROP TABLE IF EXISTS `application_documents`;
CREATE TABLE IF NOT EXISTS `application_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint unsigned NOT NULL,
  `document_type` enum('cv','portfolio','certificate','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `original_file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_application_documents_path` (`application_id`,`file_path`),
  CONSTRAINT `fk_application_documents_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.application_documents: ~4 rows (approximately)
INSERT INTO `application_documents` (`id`, `application_id`, `document_type`, `original_file_name`, `file_path`, `uploaded_at`) VALUES
	(1, 1, 'cv', 'ARIA FATAH ANOM - CV.pdf', 'applications/1/5nLeA1BNoyrhYoK6348qpG4uQymJrdAK0jYkHrcn.pdf', '2026-06-15 11:05:29'),
	(2, 1, 'portfolio', 'ARIA FATAH ANOM - Portofolio.pdf', 'applications/1/akt8GALII780JPEv3jMV1sQp7VdauGodS6ijWnoI.pdf', '2026-06-15 11:05:29'),
	(3, 2, 'cv', 'ARIA FATAH ANOM - CV.pdf', 'applications/2/76mWYhNHADTTYPiLoIf3FSaOcsgc5Tcr7aHh09AJ.pdf', '2026-06-15 21:08:39'),
	(4, 2, 'portfolio', 'ARIA FATAH ANOM - Portofolio.pdf', 'applications/2/XnvGyB2Hwn54CBOUnxPsygv9JlAPcvBOnwDhySO2.pdf', '2026-06-15 21:08:39');

-- Dumping structure for table siroma_db.application_preferences
DROP TABLE IF EXISTS `application_preferences`;
CREATE TABLE IF NOT EXISTS `application_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint unsigned NOT NULL,
  `division_id` bigint unsigned NOT NULL,
  `preference_order` tinyint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_application_preferences_division` (`application_id`,`division_id`),
  UNIQUE KEY `uq_application_preferences_order` (`application_id`,`preference_order`),
  KEY `idx_application_preferences_division_order` (`division_id`,`preference_order`),
  CONSTRAINT `fk_application_preferences_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_application_preferences_division` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.application_preferences: ~3 rows (approximately)
INSERT INTO `application_preferences` (`id`, `application_id`, `division_id`, `preference_order`) VALUES
	(3, 1, 1, 1),
	(4, 1, 2, 2),
	(5, 2, 11, 1);

-- Dumping structure for table siroma_db.application_status_history
DROP TABLE IF EXISTS `application_status_history`;
CREATE TABLE IF NOT EXISTS `application_status_history` (
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

-- Dumping data for table siroma_db.application_status_history: ~10 rows (approximately)
INSERT INTO `application_status_history` (`id`, `application_id`, `application_code`, `old_status`, `new_status`, `change_note`, `changed_at`) VALUES
	(1, 1, 'APP-20260616-CAED8424', NULL, 'submitted', 'Aplikasi dibuat melalui sp_submit_application.', '2026-06-15 18:05:29'),
	(2, 1, 'APP-20260616-CAED8424', 'submitted', 'under_review', 'Seleksi dimulai oleh reviewer.', '2026-06-15 18:09:20'),
	(3, 1, 'APP-20260616-CAED8424', 'under_review', 'rejected', 'kureng\n', '2026-06-15 18:32:42'),
	(4, 1, 'APP-20260616-CAED8424', 'rejected', 'submitted', 'Status diubah langsung melalui perintah UPDATE.', '2026-06-15 18:33:25'),
	(5, 1, 'APP-20260616-CAED8424', 'submitted', 'under_review', 'Seleksi dimulai oleh reviewer.', '2026-06-15 18:36:20'),
	(6, 1, 'APP-20260616-CAED8424', 'under_review', 'interview', 'Berkas dinyatakan lolos. Pendaftar masuk ke tahap wawancara.', '2026-06-15 18:36:42'),
	(7, 1, 'APP-20260616-CAED8424', 'interview', 'accepted', 'bagus bre', '2026-06-15 18:49:37'),
	(8, 2, 'APP-20260616-0D7D9CCE', NULL, 'submitted', 'Aplikasi dibuat melalui sp_submit_application.', '2026-06-16 04:08:38'),
	(9, 2, 'APP-20260616-0D7D9CCE', 'submitted', 'under_review', 'Seleksi dimulai oleh reviewer.', '2026-06-16 04:14:19'),
	(10, 2, 'APP-20260616-0D7D9CCE', 'under_review', 'rejected', 'kureng kureng kureng', '2026-06-16 04:14:32');

-- Dumping structure for table siroma_db.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.cache: ~1 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-spatie.permission.cache', 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:12:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:10:"view users";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:12:"manage users";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:18:"view organizations";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:20:"manage organizations";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:14:"view divisions";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:16:"manage divisions";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:24:"view recruitment periods";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:7;a:4:{s:1:"a";i:8;s:1:"b";s:26:"manage recruitment periods";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:8;a:4:{s:1:"a";i:9;s:1:"b";s:17:"view applications";s:1:"c";s:3:"web";s:1:"r";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:9;a:4:{s:1:"a";i:10;s:1:"b";s:19:"create applications";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:3;}}i:10;a:4:{s:1:"a";i:11;s:1:"b";s:19:"review applications";s:1:"c";s:3:"web";s:1:"r";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:"a";i:12;s:1:"b";s:19:"delete applications";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}}s:5:"roles";a:3:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:11:"super_admin";s:1:"c";s:3:"web";}i:1;a:3:{s:1:"a";i:2;s:1:"b";s:8:"reviewer";s:1:"c";s:3:"web";}i:2;a:3:{s:1:"a";i:3;s:1:"b";s:9:"applicant";s:1:"c";s:3:"web";}}}', 1781632736);

-- Dumping structure for table siroma_db.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.cache_locks: ~0 rows (approximately)

-- Dumping structure for table siroma_db.divisions
DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` bigint unsigned NOT NULL,
  `division_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_divisions_organization_name` (`organization_id`,`division_name`),
  CONSTRAINT `fk_divisions_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.divisions: ~11 rows (approximately)
INSERT INTO `divisions` (`id`, `organization_id`, `division_name`, `description`, `is_active`) VALUES
	(1, 1, 'Hubungan Masyarakat', 'Mengelola komunikasi dan hubungan eksternal.', 1),
	(2, 1, 'Pengembangan Sumber Daya Mahasiswa', 'Mengelola pengembangan kapasitas mahasiswa.', 1),
	(3, 1, 'Kreatif dan Media', 'Mengelola desain, dokumentasi, dan media sosial.', 1),
	(4, 1, 'Sosial Masyarakat', 'Mengelola kegiatan sosial dan pengabdian masyarakat.', 1),
	(5, 2, 'Pendidikan dan Pelatihan', 'Mengelola kegiatan akademik dan pelatihan coding.', 1),
	(6, 2, 'Riset dan Teknologi', 'Mengembangkan aplikasi dan riset siber mahasiswa.', 1),
	(7, 2, 'Hubungan Mahasiswa', 'Menjembatani aspirasi mahasiswa Teknik Informatika.', 1),
	(8, 3, 'Penetration Testing', 'Pembelajaran teknik pentest aplikasi web, jaringan, dan sistem.', 1),
	(9, 3, 'Digital Forensics', 'Analisis insiden siber, malware, dan pemulihan data.', 1),
	(10, 3, 'Security Operations', 'Monitoring sistem pertahanan siber dan blue teaming.', 1),
	(11, 4, 'RND', NULL, 1);

-- Dumping structure for table siroma_db.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table siroma_db.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.jobs: ~0 rows (approximately)

-- Dumping structure for table siroma_db.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.job_batches: ~0 rows (approximately)

-- Dumping structure for table siroma_db.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.migrations: ~16 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_06_12_143805_create_permission_tables', 1),
	(5, '2026_06_12_144923_create_organizations_table', 1),
	(6, '2026_06_12_144924_create_divisions_table', 1),
	(7, '2026_06_12_144925_create_organization_members_table', 1),
	(8, '2026_06_12_144925_create_recruitment_periods_table', 1),
	(9, '2026_06_12_144926_create_applications_table', 1),
	(10, '2026_06_12_144927_create_application_preferences_table', 1),
	(11, '2026_06_12_144928_create_application_documents_table', 1),
	(12, '2026_06_12_144932_create_application_status_histories_table', 1),
	(13, '2026_06_12_144933_create_siroma_views', 1),
	(14, '2026_06_12_144934_create_siroma_stored_procedures', 1),
	(15, '2026_06_12_144935_create_siroma_triggers', 1),
	(16, '2026_06_12_164216_add_contact_phone_to_organizations_table', 1);

-- Dumping structure for table siroma_db.model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table siroma_db.model_has_roles
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.model_has_roles: ~5 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(2, 'App\\Models\\User', 3),
	(2, 'App\\Models\\User', 4),
	(3, 'App\\Models\\User', 5);

-- Dumping structure for table siroma_db.organizations
DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `contact_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_organizations_code` (`organization_code`),
  UNIQUE KEY `uq_organizations_name` (`organization_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.organizations: ~4 rows (approximately)
INSERT INTO `organizations` (`id`, `organization_code`, `organization_name`, `description`, `contact_email`, `contact_phone`, `created_at`) VALUES
	(1, 'BEM', 'Badan Eksekutif Mahasiswa', 'Organisasi eksekutif mahasiswa tingkat tinggi kampus.', 'bem@localhost', '081234567890', '2026-06-15 17:58:04'),
	(2, 'HIMA-TI', 'Himpunan Mahasiswa Teknik Informatika', 'Organisasi kemahasiswaan untuk program studi Teknik Informatika.', 'hima@localhost', '081234567891', '2026-06-15 17:58:04'),
	(3, 'NFCC', 'Nurul Fikri Cyber Security Community', 'Unit kegiatan mahasiswa yang fokus pada pembelajaran keamanan siber.', 'nfcc@localhost', '081234567892', '2026-06-15 17:58:04'),
	(4, 'GDGNF', 'Google Developer Group Nurul Fikri', NULL, 'gdgnf@localhost', '0812412431', '2026-06-15 20:42:36');

-- Dumping structure for table siroma_db.organization_members
DROP TABLE IF EXISTS `organization_members`;
CREATE TABLE IF NOT EXISTS `organization_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `organization_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `member_role` enum('chairperson','recruitment_admin','interviewer','member') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `joined_at` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_organization_members` (`organization_id`,`user_id`),
  KEY `fk_organization_members_user` (`user_id`),
  CONSTRAINT `fk_organization_members_organization` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_organization_members_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.organization_members: ~3 rows (approximately)
INSERT INTO `organization_members` (`id`, `organization_id`, `user_id`, `member_role`, `joined_at`, `is_active`) VALUES
	(1, 1, 2, 'recruitment_admin', '2025-08-01', 1),
	(2, 2, 3, 'recruitment_admin', '2025-08-01', 1),
	(3, 3, 4, 'recruitment_admin', '2025-08-01', 1);

-- Dumping structure for table siroma_db.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table siroma_db.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.permissions: ~12 rows (approximately)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'view users', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(2, 'manage users', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(3, 'view organizations', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(4, 'manage organizations', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(5, 'view divisions', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(6, 'manage divisions', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(7, 'view recruitment periods', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(8, 'manage recruitment periods', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(9, 'view applications', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(10, 'create applications', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(11, 'review applications', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(12, 'delete applications', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03');

-- Dumping structure for table siroma_db.recruitment_periods
DROP TABLE IF EXISTS `recruitment_periods`;
CREATE TABLE IF NOT EXISTS `recruitment_periods` (
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

-- Dumping data for table siroma_db.recruitment_periods: ~4 rows (approximately)
INSERT INTO `recruitment_periods` (`id`, `organization_id`, `created_by`, `recruitment_title`, `academic_year`, `registration_start_date`, `registration_end_date`, `total_quota`, `recruitment_status`, `description`, `created_at`, `updated_at`) VALUES
	(1, 1, 2, 'Open Recruitment BEM 2026', '2025/2026', '2026-06-15', '2026-06-30', 20, 'open', 'Penerimaan anggota baru Badan Eksekutif Mahasiswa (BEM) periode 2026.', '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(2, 2, 3, 'Open Recruitment HIMA TI 2026', '2025/2026', '2026-06-15', '2026-06-30', 15, 'open', 'Bergabunglah dengan Himpunan Mahasiswa Teknik Informatika (HIMA TI) 2026.', '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(3, 3, 4, 'Open Recruitment NF Cyber Security 2026', '2025/2026', '2026-06-15', '2026-06-30', 10, 'open', 'Pendaftaran anggota baru Nurul Fikri Cyber Security Community (NFCC) 2026.', '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(4, 4, NULL, 'Open Rekrutmen GDGNF', '2026', '2026-06-02', '2026-07-18', 50, 'open', NULL, '2026-06-15 20:53:46', '2026-06-15 21:08:26');

-- Dumping structure for table siroma_db.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'super_admin', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(2, 'reviewer', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03'),
	(3, 'applicant', 'web', '2026-06-15 10:58:03', '2026-06-15 10:58:03');

-- Dumping structure for table siroma_db.role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.role_has_permissions: ~22 rows (approximately)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(3, 2),
	(5, 2),
	(7, 2),
	(9, 2),
	(11, 2),
	(3, 3),
	(5, 3),
	(7, 3),
	(9, 3),
	(10, 3);

-- Dumping structure for table siroma_db.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table siroma_db.sessions: ~3 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('9fxqpyzbplAzzUOVNWm7KiJa6Fx3vMGbYHXTlsSn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiSzZDYmU0RENZZnIyM1J6MUY2akhDc2ZMRUowYU80ZWUxNFdLNzdSRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kaXZpc2lvbnMiO3M6NToicm91dGUiO3M6NDA6ImZpbGFtZW50LmFkbWluLnJlc291cmNlcy5kaXZpc2lvbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI2ZDYxYTY0MjU4ZjJkMTg5OGY3NmE5MTgxMjk0OTQ2OTdhNmM0ZDE1NmY5NDU5MGMwZTdlOWEzMGY2OTc1YThkIjtzOjY6InRhYmxlcyI7YTo1OntzOjQwOiI3ZWI4M2QxMmQ1NGU5MzNjODY3YjdlMGRiOTMzNzk3OF9jb2x1bW5zIjthOjY6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoic3R1ZGVudF9udW1iZXIiO3M6NToibGFiZWwiO3M6MzoiTklNIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJmdWxsX25hbWUiO3M6NToibGFiZWwiO3M6MTI6Ik5hbWEgTGVuZ2thcCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NToiZW1haWwiO3M6NToibGFiZWwiO3M6NToiRW1haWwiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjc6ImZhY3VsdHkiO3M6NToibGFiZWwiO3M6ODoiRmFrdWx0YXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InJvbGVzLm5hbWUiO3M6NToibGFiZWwiO3M6NDoiUm9sZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToiaXNfYWN0aXZlIjtzOjU6ImxhYmVsIjtzOjU6IkFrdGlmIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiIxOWY2NDZiNWIwOTcyNGVhMGRmYTAxM2Q0YWYzNGYyOV9jb2x1bW5zIjthOjM6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNzoib3JnYW5pemF0aW9uX2NvZGUiO3M6NToibGFiZWwiO3M6NDoiS29kZSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTc6Im9yZ2FuaXphdGlvbl9uYW1lIjtzOjU6ImxhYmVsIjtzOjE1OiJOYW1hIE9yZ2FuaXNhc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJjb250YWN0X2VtYWlsIjtzOjU6ImxhYmVsIjtzOjU6IkVtYWlsIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiJjM2ViYzkxNTA1YzIwMmZiNTQwODIwOGVkMWNhZGY0MV9jb2x1bW5zIjthOjc6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czozMDoib3JnYW5pemF0aW9uLm9yZ2FuaXphdGlvbl9uYW1lIjtzOjU6ImxhYmVsIjtzOjEwOiJPcmdhbmlzYXNpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNzoicmVjcnVpdG1lbnRfdGl0bGUiO3M6NToibGFiZWwiO3M6MTU6Ikp1ZHVsIFJla3J1dG1lbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImFjYWRlbWljX3llYXIiO3M6NToibGFiZWwiO3M6NDoiVC5BLiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTg6InJlY3J1aXRtZW50X3N0YXR1cyI7czo1OiJsYWJlbCI7czo2OiJTdGF0dXMiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjIzOiJyZWdpc3RyYXRpb25fc3RhcnRfZGF0ZSI7czo1OiJsYWJlbCI7czo1OiJNdWxhaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjU7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjE6InJlZ2lzdHJhdGlvbl9lbmRfZGF0ZSI7czo1OiJsYWJlbCI7czo3OiJTZWxlc2FpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToidG90YWxfcXVvdGEiO3M6NToibGFiZWwiO3M6NToiS3VvdGEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fXM6NDA6IjZjNDU1YTdiZGYyMjEzNWYxNmQ0NTVhYTY3ZDgwOTJkX2NvbHVtbnMiO2E6Mzp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjMwOiJvcmdhbml6YXRpb24ub3JnYW5pemF0aW9uX25hbWUiO3M6NToibGFiZWwiO3M6MTA6Ik9yZ2FuaXNhc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJkaXZpc2lvbl9uYW1lIjtzOjU6ImxhYmVsIjtzOjExOiJOYW1hIERpdmlzaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToiaXNfYWN0aXZlIjtzOjU6ImxhYmVsIjtzOjU6IkFrdGlmIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fX1zOjQwOiJmNjk0NjlhYjk1YjYxMDg3YmQ3ZWM5ZjcyMmVjNjhlMF9jb2x1bW5zIjthOjg6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoiYXBwbGljYXRpb25fY29kZSI7czo1OiJsYWJlbCI7czo0OiJLb2RlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoidXNlci5mdWxsX25hbWUiO3M6NToibGFiZWwiO3M6OToiUGVuZGFmdGFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxODoidXNlci5zdHVkeV9wcm9ncmFtIjtzOjU6ImxhYmVsIjtzOjU6IlByb2RpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ4OiJyZWNydWl0bWVudFBlcmlvZC5vcmdhbml6YXRpb24ub3JnYW5pemF0aW9uX25hbWUiO3M6NToibGFiZWwiO3M6MTA6Ik9yZ2FuaXNhc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJkaXZpc2lfcGlsaWhhbiI7czo1OiJsYWJlbCI7czoxNDoiUGlsaWhhbiBEaXZpc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE4OiJhcHBsaWNhdGlvbl9zdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiZmluYWxfc2NvcmUiO3M6NToibGFiZWwiO3M6NToiTmlsYWkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJzdWJtaXR0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlRnbCBEYWZ0YXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fX1zOjg6ImZpbGFtZW50IjthOjA6e319', 1781583701),
	('A5Dwa9z7ybwyAmlQZ0spzWM6ND3ltZCw7bfxUpfR', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOWZqMkdmS3VDT0xadzJVcEY2WGdrbXNvMzRLQWxOMEFSaEZrTmlFYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9hcHBsaWNhdGlvbnMiO3M6NToicm91dGUiO3M6NDM6ImZpbGFtZW50LmFkbWluLnJlc291cmNlcy5hcHBsaWNhdGlvbnMuaW5kZXgiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiI1NjhjZmU5N2M3MDY5MzcxNjlkZDQ5OTY4NWE1Nzc2YjQyNjUxZDY2NWUzZjE2OGZhMWQ1ODYxMTYwY2E1NTFlIjtzOjY6InRhYmxlcyI7YToxOntzOjQwOiJmNjk0NjlhYjk1YjYxMDg3YmQ3ZWM5ZjcyMmVjNjhlMF9jb2x1bW5zIjthOjg6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNjoiYXBwbGljYXRpb25fY29kZSI7czo1OiJsYWJlbCI7czo0OiJLb2RlIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNDoidXNlci5mdWxsX25hbWUiO3M6NToibGFiZWwiO3M6OToiUGVuZGFmdGFyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxODoidXNlci5zdHVkeV9wcm9ncmFtIjtzOjU6ImxhYmVsIjtzOjU6IlByb2RpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjQ4OiJyZWNydWl0bWVudFBlcmlvZC5vcmdhbml6YXRpb24ub3JnYW5pemF0aW9uX25hbWUiO3M6NToibGFiZWwiO3M6MTA6Ik9yZ2FuaXNhc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE0OiJkaXZpc2lfcGlsaWhhbiI7czo1OiJsYWJlbCI7czoxNDoiUGlsaWhhbiBEaXZpc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE4OiJhcHBsaWNhdGlvbl9zdGF0dXMiO3M6NToibGFiZWwiO3M6NjoiU3RhdHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiZmluYWxfc2NvcmUiO3M6NToibGFiZWwiO3M6NToiTmlsYWkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo3O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJzdWJtaXR0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IlRnbCBEYWZ0YXIiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9fX19', 1781583169),
	('zX7ObScbWGrqlagXHSEzqaqfZYAFHg03Qpz2hH3F', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibU9XTHJ1ZFdHdnIxek9Eck5FY2x1WTRSVjJVTFFHcm9RRjdWSEJXOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9maWwiO3M6NToicm91dGUiO3M6MTI6InByb2ZpbGUuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1781583585);

-- Dumping structure for procedure siroma_db.sp_delete_application
DROP PROCEDURE IF EXISTS `sp_delete_application`;
DELIMITER //
CREATE PROCEDURE `sp_delete_application`(
        IN p_application_id BIGINT UNSIGNED,
        IN p_delete_reason VARCHAR(500)
    )
main_block: BEGIN
        DECLARE v_application_count INT DEFAULT 0;
        DECLARE v_application_status VARCHAR(30) DEFAULT NULL;
        DECLARE v_application_code VARCHAR(30) DEFAULT NULL;

        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            ROLLBACK;
            RESIGNAL;
        END;

        SELECT COUNT(*), MAX(application_status), MAX(application_code)
        INTO v_application_count, v_application_status, v_application_code
        FROM applications
        WHERE id = p_application_id;

        IF v_application_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Aplikasi yang akan dihapus tidak ditemukan.';
        END IF;

        IF v_application_status NOT IN ('submitted', 'withdrawn') THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Aplikasi hanya dapat dihapus ketika berstatus submitted atau withdrawn.';
        END IF;

        START TRANSACTION;

        INSERT INTO application_status_history (application_id, application_code, old_status, new_status, change_note)
        VALUES (p_application_id, v_application_code, v_application_status, 'deleted', COALESCE(NULLIF(TRIM(p_delete_reason), ''), 'Aplikasi dihapus.'));

        DELETE FROM applications
        WHERE id = p_application_id;

        COMMIT;
    END//
DELIMITER ;

-- Dumping structure for procedure siroma_db.sp_get_recruitment_results
DROP PROCEDURE IF EXISTS `sp_get_recruitment_results`;
DELIMITER //
CREATE PROCEDURE `sp_get_recruitment_results`(
        IN p_recruitment_period_id BIGINT UNSIGNED,
        IN p_status_filter VARCHAR(20),
        OUT p_total_applicants INT
    )
main_block: BEGIN
        DECLARE v_recruitment_count INT DEFAULT 0;

        SELECT COUNT(*)
        INTO v_recruitment_count
        FROM recruitment_periods
        WHERE id = p_recruitment_period_id;

        IF v_recruitment_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Periode rekrutmen tidak ditemukan.';
        END IF;

        IF p_status_filter IS NOT NULL
           AND p_status_filter NOT IN ('submitted', 'under_review', 'interview', 'accepted', 'rejected', 'withdrawn') THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Filter status tidak valid.';
        END IF;

        SELECT COUNT(*)
        INTO p_total_applicants
        FROM applications
        WHERE recruitment_period_id = p_recruitment_period_id
          AND (p_status_filter IS NULL OR application_status = p_status_filter);

        SELECT
            a.application_code,
            u.student_number,
            u.full_name,
            u.study_program,
            GROUP_CONCAT(CONCAT(ap.preference_order, '. ', d.division_name) ORDER BY ap.preference_order SEPARATOR ', ') AS division_preferences,
            a.final_score,
            a.application_status,
            a.submitted_at,
            a.reviewed_at
        FROM applications a
        JOIN users u ON u.id = a.user_id
        LEFT JOIN application_preferences ap ON ap.application_id = a.id
        LEFT JOIN divisions d ON d.id = ap.division_id
        WHERE a.recruitment_period_id = p_recruitment_period_id
          AND (p_status_filter IS NULL OR a.application_status = p_status_filter)
        GROUP BY
            a.id, a.application_code, u.student_number, u.full_name, u.study_program,
            a.final_score, a.application_status, a.submitted_at, a.reviewed_at
        ORDER BY a.final_score DESC, a.submitted_at ASC;
    END//
DELIMITER ;

-- Dumping structure for procedure siroma_db.sp_submit_application
DROP PROCEDURE IF EXISTS `sp_submit_application`;
DELIMITER //
CREATE PROCEDURE `sp_submit_application`(
        IN p_user_id BIGINT UNSIGNED,
        IN p_recruitment_period_id BIGINT UNSIGNED,
        IN p_first_division_id BIGINT UNSIGNED,
        IN p_second_division_id BIGINT UNSIGNED,
        IN p_motivation TEXT,
        OUT p_application_id BIGINT UNSIGNED
    )
main_block: BEGIN
        DECLARE v_user_count INT DEFAULT 0;
        DECLARE v_recruitment_count INT DEFAULT 0;
        DECLARE v_division_count INT DEFAULT 0;
        DECLARE v_duplicate_count INT DEFAULT 0;
        DECLARE v_organization_id BIGINT UNSIGNED DEFAULT NULL;
        DECLARE v_application_code VARCHAR(30) DEFAULT NULL;

        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            ROLLBACK;
            SET p_application_id = NULL;
            RESIGNAL;
        END;

        SET p_application_id = NULL;

        SELECT COUNT(*)
        INTO v_user_count
        FROM users
        WHERE id = p_user_id AND is_active = TRUE;

        IF v_user_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User tidak ditemukan atau akun tidak aktif.';
        END IF;

        SELECT COUNT(*), MAX(organization_id)
        INTO v_recruitment_count, v_organization_id
        FROM recruitment_periods
        WHERE id = p_recruitment_period_id
          AND recruitment_status = 'open'
          AND CURRENT_DATE BETWEEN registration_start_date AND registration_end_date;

        IF v_recruitment_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Periode rekrutmen tidak tersedia atau sudah ditutup.';
        END IF;

        IF p_first_division_id IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pilihan divisi pertama wajib diisi.';
        END IF;

        IF p_motivation IS NULL OR CHAR_LENGTH(TRIM(p_motivation)) < 20 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Motivasi wajib diisi minimal 20 karakter.';
        END IF;

        SELECT COUNT(*)
        INTO v_duplicate_count
        FROM applications
        WHERE recruitment_period_id = p_recruitment_period_id AND user_id = p_user_id;

        IF v_duplicate_count > 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User sudah mendaftar pada periode rekrutmen ini.';
        END IF;

        SELECT COUNT(*)
        INTO v_division_count
        FROM divisions
        WHERE id = p_first_division_id AND organization_id = v_organization_id AND is_active = TRUE;

        IF v_division_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pilihan divisi pertama tidak valid untuk organisasi tersebut.';
        END IF;

        IF p_second_division_id IS NOT NULL THEN
            IF p_second_division_id = p_first_division_id THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pilihan divisi kedua harus berbeda dari pilihan pertama.';
            END IF;

            SELECT COUNT(*)
            INTO v_division_count
            FROM divisions
            WHERE id = p_second_division_id AND organization_id = v_organization_id AND is_active = TRUE;

            IF v_division_count = 0 THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pilihan divisi kedua tidak valid untuk organisasi tersebut.';
            END IF;
        END IF;

        START TRANSACTION;

        INSERT INTO applications (application_code, recruitment_period_id, user_id, motivation, application_status)
        VALUES ('', p_recruitment_period_id, p_user_id, TRIM(p_motivation), 'submitted');

        SET p_application_id = LAST_INSERT_ID();

        SELECT application_code
        INTO v_application_code
        FROM applications
        WHERE id = p_application_id;

        INSERT INTO application_preferences (application_id, division_id, preference_order)
        VALUES (p_application_id, p_first_division_id, 1);

        IF p_second_division_id IS NOT NULL THEN
            INSERT INTO application_preferences (application_id, division_id, preference_order)
            VALUES (p_application_id, p_second_division_id, 2);
        END IF;

        INSERT INTO application_status_history (application_id, application_code, old_status, new_status, change_note)
        VALUES (p_application_id, v_application_code, NULL, 'submitted', 'Aplikasi dibuat melalui sp_submit_application.');

        COMMIT;
    END//
DELIMITER ;

-- Dumping structure for procedure siroma_db.sp_update_application_status
DROP PROCEDURE IF EXISTS `sp_update_application_status`;
DELIMITER //
CREATE PROCEDURE `sp_update_application_status`(
        IN p_application_id BIGINT UNSIGNED,
        IN p_new_status VARCHAR(20),
        IN p_final_score DECIMAL(5,2),
        IN p_reviewer_notes VARCHAR(500)
    )
main_block: BEGIN
        DECLARE v_application_count INT DEFAULT 0;

        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SET @application_status_note = NULL;
            ROLLBACK;
            RESIGNAL;
        END;

        IF p_new_status IS NULL
           OR p_new_status NOT IN ('submitted', 'under_review', 'interview', 'accepted', 'rejected', 'withdrawn') THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Status aplikasi tidak valid.';
        END IF;

        IF p_final_score IS NOT NULL AND (p_final_score < 0 OR p_final_score > 100) THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nilai akhir harus berada pada rentang 0 sampai 100.';
        END IF;

        IF p_new_status IN ('accepted', 'rejected') AND p_final_score IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nilai akhir wajib diisi untuk status accepted atau rejected.';
        END IF;

        SELECT COUNT(*)
        INTO v_application_count
        FROM applications
        WHERE id = p_application_id;

        IF v_application_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Aplikasi tidak ditemukan.';
        END IF;

        START TRANSACTION;

        SET @application_status_note = NULLIF(TRIM(p_reviewer_notes), '');

        UPDATE applications
        SET application_status = p_new_status,
            final_score = p_final_score,
            reviewer_notes = p_reviewer_notes,
            reviewed_at = CASE
                WHEN p_new_status IN ('under_review', 'interview', 'accepted', 'rejected') THEN CURRENT_TIMESTAMP
                ELSE reviewed_at
            END
        WHERE id = p_application_id;

        SET @application_status_note = NULL;

        COMMIT;
    END//
DELIMITER ;

-- Dumping structure for table siroma_db.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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

-- Dumping data for table siroma_db.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `student_number`, `full_name`, `email`, `password_hash`, `phone`, `faculty`, `study_program`, `entry_year`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, '00000001', 'Super Admin', 'admin@localhost', '$2y$12$GNqMi4a/X24PdF/4Bppo2e3KXZoD4S3UH1OsNaaOWRem3nRmBq1m2', '081234560001', 'Direktorat IT', 'Infrastruktur', '2022', 1, '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(2, '00000002', 'Reviewer BEM', 'bem@localhost', '$2y$12$2y4omwsQg7sgT3yhwlqxBuND9vxJFZdQJuFodtQkxuebgUKBHzFnq', '081234560002', 'Fakultas Ilmu Komputer', 'Sistem Informasi', '2023', 1, '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(3, '00000003', 'Reviewer HIMA TI', 'hima@localhost', '$2y$12$yt1Q1G87ac2QKJ97CfbHn.6llHpNOQxIU1WqIV6.zrIBHV0mQOYdW', '081234560003', 'Fakultas Ilmu Komputer', 'Informatika', '2023', 1, '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(4, '00000004', 'Reviewer NFCC', 'nfcc@localhost', '$2y$12$rTb1GVaiXui5ZZAHJCVXc.8ukyrWbx0txJspGoD3O11Sknq/ZHWVa', '081234560004', 'Fakultas Ilmu Komputer', 'Informatika', '2023', 1, '2026-06-15 17:58:04', '2026-06-15 17:58:04'),
	(5, '24010001', 'aria', 'aria@localhost', '$2y$12$3ayVBygxpR6LcHvg/iBbHugOfKLKHC9rDh4hBGVaLcT2LmSMTPCcu', '081234560005', 'Fakultas Ilmu Komputer', 'Informatika', '2024', 1, '2026-06-15 17:58:04', '2026-06-15 17:58:04');

-- Dumping structure for view siroma_db.v_application_details
DROP VIEW IF EXISTS `v_application_details`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_application_details` (
	`application_id` BIGINT UNSIGNED NOT NULL,
	`application_code` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`student_number` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`full_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`organization_code` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`organization_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`recruitment_title` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`academic_year` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`division_preferences` TEXT NULL COLLATE 'utf8mb4_unicode_ci',
	`total_documents` BIGINT NOT NULL,
	`final_score` DECIMAL(5,2) NULL,
	`application_status` ENUM('submitted','under_review','interview','accepted','rejected','withdrawn') NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`submitted_at` TIMESTAMP NOT NULL
) ENGINE=MyISAM;

-- Dumping structure for view siroma_db.v_division_interest_summary
DROP VIEW IF EXISTS `v_division_interest_summary`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_division_interest_summary` (
	`recruitment_period_id` BIGINT UNSIGNED NOT NULL,
	`recruitment_title` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`organization_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`division_id` BIGINT UNSIGNED NOT NULL,
	`division_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`total_interested_applicants` BIGINT NOT NULL,
	`total_first_choice` DECIMAL(23,0) NULL,
	`total_second_choice` DECIMAL(23,0) NULL
) ENGINE=MyISAM;

-- Dumping structure for view siroma_db.v_recruitment_summary
DROP VIEW IF EXISTS `v_recruitment_summary`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `v_recruitment_summary` (
	`recruitment_period_id` BIGINT UNSIGNED NOT NULL,
	`organization_name` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`recruitment_title` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`registration_start_date` DATE NOT NULL,
	`registration_end_date` DATE NOT NULL,
	`total_quota` INT UNSIGNED NOT NULL,
	`recruitment_status` ENUM('draft','open','closed','completed') NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`total_applicants` BIGINT NOT NULL,
	`total_submitted` DECIMAL(23,0) NULL,
	`total_under_review` DECIMAL(23,0) NULL,
	`total_accepted` DECIMAL(23,0) NULL,
	`total_rejected` DECIMAL(23,0) NULL,
	`remaining_quota` DECIMAL(24,0) NULL
) ENGINE=MyISAM;

-- Dumping structure for trigger siroma_db.trg_applications_au_log_status
DROP TRIGGER IF EXISTS `trg_applications_au_log_status`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_applications_au_log_status` AFTER UPDATE ON `applications` FOR EACH ROW BEGIN
        IF NOT (OLD.application_status <=> NEW.application_status) THEN
            INSERT INTO application_status_history (application_id, application_code, old_status, new_status, change_note)
            VALUES (
                NEW.id,
                NEW.application_code,
                OLD.application_status,
                NEW.application_status,
                COALESCE(@application_status_note, 'Status diubah langsung melalui perintah UPDATE.')
            );
        END IF;
    END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger siroma_db.trg_applications_bi_validate_submission
DROP TRIGGER IF EXISTS `trg_applications_bi_validate_submission`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_applications_bi_validate_submission` BEFORE INSERT ON `applications` FOR EACH ROW BEGIN
        DECLARE v_open_period_count INT DEFAULT 0;

        SELECT COUNT(*)
        INTO v_open_period_count
        FROM recruitment_periods rp
        WHERE rp.id = NEW.recruitment_period_id
          AND rp.recruitment_status = 'open'
          AND CURRENT_DATE BETWEEN rp.registration_start_date AND rp.registration_end_date;

        IF v_open_period_count = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pendaftaran hanya dapat dilakukan pada periode rekrutmen yang sedang dibuka.';
        END IF;

        IF NEW.application_code IS NULL OR TRIM(NEW.application_code) = '' THEN
            SET NEW.application_code = CONCAT(
                'APP-',
                DATE_FORMAT(CURRENT_TIMESTAMP, '%Y%m%d'),
                '-',
                UPPER(SUBSTRING(REPLACE(UUID(), '-', ''), 1, 8))
            );
        END IF;
    END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger siroma_db.trg_recruitment_periods_bi_validate_dates
DROP TRIGGER IF EXISTS `trg_recruitment_periods_bi_validate_dates`;
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_recruitment_periods_bi_validate_dates` BEFORE INSERT ON `recruitment_periods` FOR EACH ROW BEGIN
        IF NEW.registration_end_date < NEW.registration_start_date THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tanggal penutupan tidak boleh sebelum tanggal pembukaan.';
        END IF;

        IF NEW.total_quota IS NULL OR NEW.total_quota = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Kuota rekrutmen harus lebih dari 0.';
        END IF;
    END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_application_details`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_application_details` AS select `a`.`id` AS `application_id`,`a`.`application_code` AS `application_code`,`u`.`student_number` AS `student_number`,`u`.`full_name` AS `full_name`,`u`.`email` AS `email`,`o`.`organization_code` AS `organization_code`,`o`.`organization_name` AS `organization_name`,`rp`.`recruitment_title` AS `recruitment_title`,`rp`.`academic_year` AS `academic_year`,group_concat(distinct concat(`ap`.`preference_order`,'. ',`d`.`division_name`) order by `ap`.`preference_order` ASC separator ', ') AS `division_preferences`,count(distinct `ad`.`id`) AS `total_documents`,`a`.`final_score` AS `final_score`,`a`.`application_status` AS `application_status`,`a`.`submitted_at` AS `submitted_at` from ((((((`applications` `a` join `users` `u` on((`u`.`id` = `a`.`user_id`))) join `recruitment_periods` `rp` on((`rp`.`id` = `a`.`recruitment_period_id`))) join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) left join `application_preferences` `ap` on((`ap`.`application_id` = `a`.`id`))) left join `divisions` `d` on((`d`.`id` = `ap`.`division_id`))) left join `application_documents` `ad` on((`ad`.`application_id` = `a`.`id`))) group by `a`.`id`,`a`.`application_code`,`u`.`student_number`,`u`.`full_name`,`u`.`email`,`o`.`organization_code`,`o`.`organization_name`,`rp`.`recruitment_title`,`rp`.`academic_year`,`a`.`final_score`,`a`.`application_status`,`a`.`submitted_at`;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_division_interest_summary`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_division_interest_summary` AS select `rp`.`id` AS `recruitment_period_id`,`rp`.`recruitment_title` AS `recruitment_title`,`o`.`organization_name` AS `organization_name`,`d`.`id` AS `division_id`,`d`.`division_name` AS `division_name`,count(`ap`.`id`) AS `total_interested_applicants`,sum((case when (`ap`.`preference_order` = 1) then 1 else 0 end)) AS `total_first_choice`,sum((case when (`ap`.`preference_order` = 2) then 1 else 0 end)) AS `total_second_choice` from ((((`recruitment_periods` `rp` join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) join `divisions` `d` on((`d`.`organization_id` = `rp`.`organization_id`))) left join `applications` `a` on((`a`.`recruitment_period_id` = `rp`.`id`))) left join `application_preferences` `ap` on(((`ap`.`application_id` = `a`.`id`) and (`ap`.`division_id` = `d`.`id`)))) group by `rp`.`id`,`rp`.`recruitment_title`,`o`.`organization_name`,`d`.`id`,`d`.`division_name`;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `v_recruitment_summary`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `v_recruitment_summary` AS select `rp`.`id` AS `recruitment_period_id`,`o`.`organization_name` AS `organization_name`,`rp`.`recruitment_title` AS `recruitment_title`,`rp`.`registration_start_date` AS `registration_start_date`,`rp`.`registration_end_date` AS `registration_end_date`,`rp`.`total_quota` AS `total_quota`,`rp`.`recruitment_status` AS `recruitment_status`,count(`a`.`id`) AS `total_applicants`,sum((case when (`a`.`application_status` = 'submitted') then 1 else 0 end)) AS `total_submitted`,sum((case when (`a`.`application_status` = 'under_review') then 1 else 0 end)) AS `total_under_review`,sum((case when (`a`.`application_status` = 'accepted') then 1 else 0 end)) AS `total_accepted`,sum((case when (`a`.`application_status` = 'rejected') then 1 else 0 end)) AS `total_rejected`,greatest((`rp`.`total_quota` - sum((case when (`a`.`application_status` = 'accepted') then 1 else 0 end))),0) AS `remaining_quota` from ((`recruitment_periods` `rp` join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) left join `applications` `a` on((`a`.`recruitment_period_id` = `rp`.`id`))) group by `rp`.`id`,`o`.`organization_name`,`rp`.`recruitment_title`,`rp`.`registration_start_date`,`rp`.`registration_end_date`,`rp`.`total_quota`,`rp`.`recruitment_status`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
