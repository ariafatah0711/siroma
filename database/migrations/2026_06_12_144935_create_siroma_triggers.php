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
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_recruitment_periods_bi_validate_dates`');
        DB::unprepared(<<<'SQL'
            CREATE TRIGGER `trg_recruitment_periods_bi_validate_dates`
            BEFORE INSERT ON `recruitment_periods`
            FOR EACH ROW
            BEGIN
                IF NEW.registration_end_date < NEW.registration_start_date THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tanggal penutupan tidak boleh sebelum tanggal pembukaan.';
                END IF;

                IF NEW.total_quota IS NULL OR NEW.total_quota = 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Kuota rekrutmen harus lebih dari 0.';
                END IF;
            END
        SQL);

        DB::unprepared('DROP TRIGGER IF EXISTS `trg_applications_au_log_status`');
        DB::unprepared(<<<'SQL'
            CREATE TRIGGER `trg_applications_au_log_status`
            AFTER UPDATE ON `applications`
            FOR EACH ROW
            BEGIN
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
            END
        SQL);

        DB::unprepared('DROP TRIGGER IF EXISTS `trg_applications_bi_validate_submission`');
        DB::unprepared(<<<'SQL'
            CREATE TRIGGER `trg_applications_bi_validate_submission`
            BEFORE INSERT ON `applications`
            FOR EACH ROW
            BEGIN
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
            END
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_applications_bi_validate_submission`');
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_applications_au_log_status`');
        DB::unprepared('DROP TRIGGER IF EXISTS `trg_recruitment_periods_bi_validate_dates`');
    }
};
