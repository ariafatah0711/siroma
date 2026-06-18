-- =====================================================
-- DUMMY DATA
-- Sistem Manajemen Rekrutmen Organisasi Mahasiswa
-- Jalankan setelah Kelompok13_ProjectBD(1).sql selesai dieksekusi.
-- Script ini ditujukan untuk basis data yang masih kosong.
-- =====================================================

USE `student_org_recruitment_db`;

-- -----------------------------------------------------
-- 1. Data pengguna
-- -----------------------------------------------------
INSERT INTO `users`
    (`id`, `student_number`, `full_name`, `email`, `password_hash`, `phone`,
     `faculty`, `study_program`, `entry_year`, `is_active`)
VALUES
    (1, '23010001', 'Andi Pratama', 'andi.pratama@student.ac.id', SHA2('andi123', 256),
     '081234560001', 'Fakultas Ilmu Komputer', 'Sistem Informasi', 2023, 1),
    (2, '23010002', 'Siti Rahma', 'siti.rahma@student.ac.id', SHA2('siti123', 256),
     '081234560002', 'Fakultas Ilmu Komputer', 'Informatika', 2023, 1),
    (3, '24010003', 'Budi Santoso', 'budi.santoso@student.ac.id', SHA2('budi123', 256),
     '081234560003', 'Fakultas Ekonomi', 'Manajemen', 2024, 1),
    (4, '24010004', 'Citra Lestari', 'citra.lestari@student.ac.id', SHA2('citra123', 256),
     '081234560004', 'Fakultas Ilmu Komputer', 'Sistem Informasi', 2024, 1),
    (5, '24010005', 'Dimas Saputra', 'dimas.saputra@student.ac.id', SHA2('dimas123', 256),
     '081234560005', 'Fakultas Teknik', 'Teknik Industri', 2024, 1),
    (6, '24010006', 'Eka Nuraini', 'eka.nuraini@student.ac.id', SHA2('eka123', 256),
     '081234560006', 'Fakultas Ilmu Sosial', 'Ilmu Komunikasi', 2024, 1),
    (7, '24010007', 'Farhan Akbar', 'farhan.akbar@student.ac.id', SHA2('farhan123', 256),
     '081234560007', 'Fakultas Ilmu Komputer', 'Informatika', 2024, 1),
    (8, '24010008', 'Gita Maharani', 'gita.maharani@student.ac.id', SHA2('gita123', 256),
     '081234560008', 'Fakultas Ekonomi', 'Akuntansi', 2024, 1);

-- -----------------------------------------------------
-- 2. Data organisasi
-- -----------------------------------------------------
INSERT INTO `organizations`
    (`id`, `organization_code`, `organization_name`, `description`, `contact_email`, `contact_phone`)
VALUES
    (1, 'BEM-UNI', 'Badan Eksekutif Mahasiswa Universitas',
     'Organisasi eksekutif mahasiswa tingkat universitas.', 'bem@kampus.ac.id', '081234567890'),
    (2, 'HIMSI', 'Himpunan Mahasiswa Sistem Informasi',
     'Organisasi mahasiswa Program Studi Sistem Informasi.', 'himsi@kampus.ac.id', '081234567891');

-- -----------------------------------------------------
-- 3. Data keanggotaan organisasi
-- -----------------------------------------------------
INSERT INTO `organization_members`
    (`id`, `organization_id`, `user_id`, `member_role`, `joined_at`, `is_active`)
VALUES
    (1, 1, 1, 'chairperson', '2025-08-01', 1),
    (2, 1, 2, 'recruitment_admin', '2025-08-01', 1),
    (3, 2, 2, 'interviewer', '2025-09-01', 1);

-- -----------------------------------------------------
-- 4. Data divisi
-- -----------------------------------------------------
INSERT INTO `divisions`
    (`id`, `organization_id`, `division_name`, `description`, `is_active`)
VALUES
    (1, 1, 'Hubungan Masyarakat', 'Mengelola komunikasi dan hubungan eksternal.', 1),
    (2, 1, 'Pengembangan Sumber Daya Mahasiswa', 'Mengelola pengembangan kapasitas mahasiswa.', 1),
    (3, 1, 'Kreatif dan Media', 'Mengelola desain, dokumentasi, dan media sosial.', 1),
    (4, 1, 'Sosial Masyarakat', 'Mengelola kegiatan sosial dan pengabdian masyarakat.', 1),
    (5, 2, 'Akademik', 'Mengelola kegiatan akademik dan pelatihan.', 1),
    (6, 2, 'Riset dan Teknologi', 'Mengelola kegiatan riset dan pengembangan teknologi.', 1),
    (7, 2, 'Komunikasi dan Informasi', 'Mengelola publikasi dan informasi organisasi.', 1);

-- -----------------------------------------------------
-- 5. Data periode rekrutmen
-- Periode 1 dan 2 dibuat terbuka pada tanggal saat script dijalankan
-- agar dapat dipakai untuk menguji trigger dan stored procedure.
-- -----------------------------------------------------
INSERT INTO `recruitment_periods`
    (`id`, `organization_id`, `created_by`, `recruitment_title`, `academic_year`,
     `registration_start_date`, `registration_end_date`, `total_quota`,
     `recruitment_status`, `description`)
VALUES
    (1, 1, 2, 'Open Recruitment BEM 2026', '2025/2026',
     CURDATE() - INTERVAL 7 DAY, CURDATE() + INTERVAL 14 DAY, 20, 'open',
     'Penerimaan anggota baru BEM untuk periode kepengurusan 2026.'),
    (2, 2, 2, 'Open Recruitment HIMSI 2026', '2025/2026',
     CURDATE() - INTERVAL 5 DAY, CURDATE() + INTERVAL 10 DAY, 15, 'open',
     'Penerimaan anggota baru HIMSI untuk periode kepengurusan 2026.'),
    (3, 1, 1, 'Open Recruitment BEM 2025', '2024/2025',
     '2025-01-10', '2025-01-31', 18, 'completed',
     'Periode rekrutmen BEM yang telah selesai.');

-- -----------------------------------------------------
-- 6. Data lamaran melalui stored procedure
-- -----------------------------------------------------
SET @app_1 = NULL;
CALL `sp_submit_application`(
    3, 1, 1, 2,
    'Saya ingin meningkatkan kemampuan komunikasi dan berkontribusi dalam kegiatan mahasiswa.',
    @app_1
);

SET @app_2 = NULL;
CALL `sp_submit_application`(
    4, 1, 2, 3,
    'Saya tertarik mengembangkan program kerja mahasiswa serta kemampuan desain dan publikasi.',
    @app_2
);

SET @app_3 = NULL;
CALL `sp_submit_application`(
    5, 1, 1, 4,
    'Saya ingin memperluas pengalaman organisasi dan terlibat dalam kegiatan sosial mahasiswa.',
    @app_3
);

SET @app_4 = NULL;
CALL `sp_submit_application`(
    6, 1, 3, NULL,
    'Saya memiliki minat pada bidang media kreatif dan ingin membantu publikasi kegiatan organisasi.',
    @app_4
);

SET @app_5 = NULL;
CALL `sp_submit_application`(
    7, 2, 6, 5,
    'Saya ingin mengembangkan kemampuan teknologi sekaligus berkontribusi pada kegiatan akademik HIMSI.',
    @app_5
);

SET @app_6 = NULL;
CALL `sp_submit_application`(
    8, 2, 7, 5,
    'Saya tertarik pada pengelolaan informasi organisasi dan ingin meningkatkan pengalaman kerja tim.',
    @app_6
);

-- -----------------------------------------------------
-- 7. Data dokumen lamaran
-- -----------------------------------------------------
INSERT INTO `application_documents`
    (`application_id`, `document_type`, `original_file_name`, `file_path`)
VALUES
    (@app_1, 'cv', 'CV_Budi_Santoso.pdf', '/uploads/applications/budi/cv.pdf'),
    (@app_1, 'certificate', 'Sertifikat_Budi.pdf', '/uploads/applications/budi/sertifikat.pdf'),
    (@app_2, 'cv', 'CV_Citra_Lestari.pdf', '/uploads/applications/citra/cv.pdf'),
    (@app_2, 'portfolio', 'Portofolio_Citra.pdf', '/uploads/applications/citra/portofolio.pdf'),
    (@app_3, 'cv', 'CV_Dimas_Saputra.pdf', '/uploads/applications/dimas/cv.pdf'),
    (@app_4, 'portfolio', 'Portofolio_Eka.pdf', '/uploads/applications/eka/portofolio.pdf'),
    (@app_5, 'cv', 'CV_Farhan_Akbar.pdf', '/uploads/applications/farhan/cv.pdf'),
    (@app_5, 'certificate', 'Sertifikat_Farhan.pdf', '/uploads/applications/farhan/sertifikat.pdf'),
    (@app_6, 'cv', 'CV_Gita_Maharani.pdf', '/uploads/applications/gita/cv.pdf');

-- -----------------------------------------------------
-- 8. Perubahan status melalui stored procedure
-- Perubahan ini otomatis dicatat oleh trigger
-- trg_applications_au_log_status.
-- -----------------------------------------------------
CALL `sp_update_application_status`(
    @app_1, 'accepted', 88.50,
    'Komunikasi baik dan sesuai dengan kebutuhan divisi.'
);

CALL `sp_update_application_status`(
    @app_2, 'rejected', 72.00,
    'Kemampuan cukup baik, tetapi belum memenuhi kebutuhan divisi.'
);

CALL `sp_update_application_status`(
    @app_3, 'under_review', NULL,
    'Dokumen telah diperiksa dan menunggu penilaian akhir.'
);

CALL `sp_update_application_status`(
    @app_5, 'accepted', 91.00,
    'Kemampuan teknis dan motivasi sangat sesuai.'
);

CALL `sp_update_application_status`(
    @app_6, 'withdrawn', NULL,
    'Pendaftar mengundurkan diri dari proses seleksi.'
);

-- -----------------------------------------------------
-- 9. Pemeriksaan data dummy
-- -----------------------------------------------------
SELECT * FROM `users` ORDER BY `id`;
SELECT * FROM `organizations` ORDER BY `id`;
SELECT * FROM `divisions` ORDER BY `organization_id`, `id`;
SELECT * FROM `recruitment_periods` ORDER BY `id`;
SELECT * FROM `applications` ORDER BY `id`;
SELECT * FROM `application_preferences` ORDER BY `application_id`, `preference_order`;
SELECT * FROM `application_documents` ORDER BY `application_id`, `id`;
SELECT * FROM `application_status_history` ORDER BY `changed_at`, `id`;

-- -----------------------------------------------------
-- 10. Pengujian view
-- -----------------------------------------------------
SELECT * FROM `v_application_details` ORDER BY `application_id`;
SELECT * FROM `v_division_interest_summary`
ORDER BY `recruitment_period_id`, `division_id`;
SELECT * FROM `v_recruitment_summary`
ORDER BY `recruitment_period_id`;

-- -----------------------------------------------------
-- 11. Pengujian stored procedure hasil rekrutmen
-- -----------------------------------------------------
SET @total_applicants = 0;
CALL `sp_get_recruitment_results`(1, NULL, @total_applicants);
SELECT @total_applicants AS `total_applicants_period_1`;

SET @total_accepted = 0;
CALL `sp_get_recruitment_results`(1, 'accepted', @total_accepted);
SELECT @total_accepted AS `total_accepted_period_1`;
