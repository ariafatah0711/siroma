-- =====================================================
-- USER PRIVILEGE
-- =====================================================

DROP USER IF EXISTS
    'recruitment_admin'@'localhost',
    'recruitment_reviewer'@'localhost';

CREATE USER 'recruitment_admin'@'localhost'
IDENTIFIED BY 'AdminBD#2026!';

CREATE USER 'recruitment_reviewer'@'localhost'
IDENTIFIED BY 'ReviewerBD#2026!';


-- Hak akses administrator
GRANT SELECT, INSERT, UPDATE, DELETE, EXECUTE
ON `student_org_recruitment_db`.*
TO 'recruitment_admin'@'localhost';


-- Hak akses reviewer pada view
GRANT SELECT
ON `student_org_recruitment_db`.`v_application_details`
TO 'recruitment_reviewer'@'localhost';

GRANT SELECT
ON `student_org_recruitment_db`.`v_division_interest_summary`
TO 'recruitment_reviewer'@'localhost';

GRANT SELECT
ON `student_org_recruitment_db`.`v_recruitment_summary`
TO 'recruitment_reviewer'@'localhost';


-- Reviewer dapat melihat riwayat perubahan status
GRANT SELECT
ON `student_org_recruitment_db`.`application_status_history`
TO 'recruitment_reviewer'@'localhost';


-- Reviewer dapat menjalankan stored procedure penilaian dan laporan
GRANT EXECUTE
ON PROCEDURE `student_org_recruitment_db`.`sp_update_application_status`
TO 'recruitment_reviewer'@'localhost';

GRANT EXECUTE
ON PROCEDURE `student_org_recruitment_db`.`sp_get_recruitment_results`
TO 'recruitment_reviewer'@'localhost';


-- Penerapan REVOKE
-- Hak UPDATE diberikan sementara, kemudian dicabut
-- agar reviewer tidak mengubah tabel applications secara langsung
GRANT UPDATE
ON `student_org_recruitment_db`.`applications`
TO 'recruitment_reviewer'@'localhost';

REVOKE UPDATE
ON `student_org_recruitment_db`.`applications`
FROM 'recruitment_reviewer'@'localhost';


-- Pemeriksaan hak akses
SHOW GRANTS FOR 'recruitment_admin'@'localhost';
SHOW GRANTS FOR 'recruitment_reviewer'@'localhost';
