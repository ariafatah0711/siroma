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
        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE VIEW `v_application_details` AS
            SELECT
                `a`.`id` AS `application_id`,
                `a`.`application_code` AS `application_code`,
                `u`.`student_number` AS `student_number`,
                `u`.`full_name` AS `full_name`,
                `u`.`email` AS `email`,
                `o`.`organization_code` AS `organization_code`,
                `o`.`organization_name` AS `organization_name`,
                `rp`.`recruitment_title` AS `recruitment_title`,
                `rp`.`academic_year` AS `academic_year`,
                GROUP_CONCAT(DISTINCT CONCAT(`ap`.`preference_order`, '. ', `d`.`division_name`) ORDER BY `ap`.`preference_order` ASC SEPARATOR ', ') AS `division_preferences`,
                COUNT(DISTINCT `ad`.`id`) AS `total_documents`,
                `a`.`final_score` AS `final_score`,
                `a`.`application_status` AS `application_status`,
                `a`.`submitted_at` AS `submitted_at`
            FROM `applications` `a`
            JOIN `users` `u` ON `u`.`id` = `a`.`user_id`
            JOIN `recruitment_periods` `rp` ON `rp`.`id` = `a`.`recruitment_period_id`
            JOIN `organizations` `o` ON `o`.`id` = `rp`.`organization_id`
            LEFT JOIN `application_preferences` `ap` ON `ap`.`application_id` = `a`.`id`
            LEFT JOIN `divisions` `d` ON `d`.`id` = `ap`.`division_id`
            LEFT JOIN `application_documents` `ad` ON `ad`.`application_id` = `a`.`id`
            GROUP BY
                `a`.`id`, `a`.`application_code`, `u`.`student_number`, `u`.`full_name`, `u`.`email`,
                `o`.`organization_code`, `o`.`organization_name`, `rp`.`recruitment_title`,
                `rp`.`academic_year`, `a`.`final_score`, `a`.`application_status`, `a`.`submitted_at`
        SQL);

        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE VIEW `v_division_interest_summary` AS
            SELECT
                `rp`.`id` AS `recruitment_period_id`,
                `rp`.`recruitment_title` AS `recruitment_title`,
                `o`.`organization_name` AS `organization_name`,
                `d`.`id` AS `division_id`,
                `d`.`division_name` AS `division_name`,
                COUNT(`ap`.`id`) AS `total_interested_applicants`,
                SUM(CASE WHEN `ap`.`preference_order` = 1 THEN 1 ELSE 0 END) AS `total_first_choice`,
                SUM(CASE WHEN `ap`.`preference_order` = 2 THEN 1 ELSE 0 END) AS `total_second_choice`
            FROM `recruitment_periods` `rp`
            JOIN `organizations` `o` ON `o`.`id` = `rp`.`organization_id`
            JOIN `divisions` `d` ON `d`.`organization_id` = `rp`.`organization_id`
            LEFT JOIN `applications` `a` ON `a`.`recruitment_period_id` = `rp`.`id`
            LEFT JOIN `application_preferences` `ap` ON `ap`.`application_id` = `a`.`id` AND `ap`.`division_id` = `d`.`id`
            GROUP BY `rp`.`id`, `rp`.`recruitment_title`, `o`.`organization_name`, `d`.`id`, `d`.`division_name`
        SQL);

        DB::unprepared(<<<'SQL'
            CREATE OR REPLACE VIEW `v_recruitment_summary` AS
            SELECT
                `rp`.`id` AS `recruitment_period_id`,
                `o`.`organization_name` AS `organization_name`,
                `rp`.`recruitment_title` AS `recruitment_title`,
                `rp`.`registration_start_date` AS `registration_start_date`,
                `rp`.`registration_end_date` AS `registration_end_date`,
                `rp`.`total_quota` AS `total_quota`,
                `rp`.`recruitment_status` AS `recruitment_status`,
                COUNT(`a`.`id`) AS `total_applicants`,
                SUM(CASE WHEN `a`.`application_status` = 'submitted' THEN 1 ELSE 0 END) AS `total_submitted`,
                SUM(CASE WHEN `a`.`application_status` = 'under_review' THEN 1 ELSE 0 END) AS `total_under_review`,
                SUM(CASE WHEN `a`.`application_status` = 'accepted' THEN 1 ELSE 0 END) AS `total_accepted`,
                SUM(CASE WHEN `a`.`application_status` = 'rejected' THEN 1 ELSE 0 END) AS `total_rejected`,
                GREATEST(`rp`.`total_quota` - SUM(CASE WHEN `a`.`application_status` = 'accepted' THEN 1 ELSE 0 END), 0) AS `remaining_quota`
            FROM `recruitment_periods` `rp`
            JOIN `organizations` `o` ON `o`.`id` = `rp`.`organization_id`
            LEFT JOIN `applications` `a` ON `a`.`recruitment_period_id` = `rp`.`id`
            GROUP BY
                `rp`.`id`, `o`.`organization_name`, `rp`.`recruitment_title`, `rp`.`registration_start_date`,
                `rp`.`registration_end_date`, `rp`.`total_quota`, `rp`.`recruitment_status`
        SQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS `v_recruitment_summary`');
        DB::unprepared('DROP VIEW IF EXISTS `v_division_interest_summary`');
        DB::unprepared('DROP VIEW IF EXISTS `v_application_details`');
    }
};
