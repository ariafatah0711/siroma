<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_delete_application`');
        DB::unprepared(<<<'SQL'
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
            END
        SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_recruitment_results`');
        DB::unprepared(<<<'SQL'
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
            END
        SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_submit_application`');
        DB::unprepared(<<<'SQL'
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
            END
        SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_update_application_status`');
        DB::unprepared(<<<'SQL'
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
            END
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_update_application_status`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_submit_application`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_recruitment_results`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_delete_application`');
    }
};
