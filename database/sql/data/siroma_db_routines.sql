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
-- Temporary view structure for view `v_division_interest_summary`
--

DROP TABLE IF EXISTS `v_division_interest_summary`;
/*!50001 DROP VIEW IF EXISTS `v_division_interest_summary`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_division_interest_summary` AS SELECT 
 1 AS `recruitment_period_id`,
 1 AS `recruitment_title`,
 1 AS `organization_name`,
 1 AS `division_id`,
 1 AS `division_name`,
 1 AS `total_interested_applicants`,
 1 AS `total_first_choice`,
 1 AS `total_second_choice`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_application_details`
--

DROP TABLE IF EXISTS `v_application_details`;
/*!50001 DROP VIEW IF EXISTS `v_application_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_application_details` AS SELECT 
 1 AS `application_id`,
 1 AS `application_code`,
 1 AS `student_number`,
 1 AS `full_name`,
 1 AS `email`,
 1 AS `organization_code`,
 1 AS `organization_name`,
 1 AS `recruitment_title`,
 1 AS `academic_year`,
 1 AS `division_preferences`,
 1 AS `total_documents`,
 1 AS `final_score`,
 1 AS `application_status`,
 1 AS `submitted_at`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `v_recruitment_summary`
--

DROP TABLE IF EXISTS `v_recruitment_summary`;
/*!50001 DROP VIEW IF EXISTS `v_recruitment_summary`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `v_recruitment_summary` AS SELECT 
 1 AS `recruitment_period_id`,
 1 AS `organization_name`,
 1 AS `recruitment_title`,
 1 AS `registration_start_date`,
 1 AS `registration_end_date`,
 1 AS `total_quota`,
 1 AS `recruitment_status`,
 1 AS `total_applicants`,
 1 AS `total_submitted`,
 1 AS `total_under_review`,
 1 AS `total_accepted`,
 1 AS `total_rejected`,
 1 AS `remaining_quota`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `v_division_interest_summary`
--

/*!50001 DROP VIEW IF EXISTS `v_division_interest_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_division_interest_summary` AS select `rp`.`id` AS `recruitment_period_id`,`rp`.`recruitment_title` AS `recruitment_title`,`o`.`organization_name` AS `organization_name`,`d`.`id` AS `division_id`,`d`.`division_name` AS `division_name`,count(`ap`.`id`) AS `total_interested_applicants`,sum((case when (`ap`.`preference_order` = 1) then 1 else 0 end)) AS `total_first_choice`,sum((case when (`ap`.`preference_order` = 2) then 1 else 0 end)) AS `total_second_choice` from ((((`recruitment_periods` `rp` join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) join `divisions` `d` on((`d`.`organization_id` = `rp`.`organization_id`))) left join `applications` `a` on((`a`.`recruitment_period_id` = `rp`.`id`))) left join `application_preferences` `ap` on(((`ap`.`application_id` = `a`.`id`) and (`ap`.`division_id` = `d`.`id`)))) group by `rp`.`id`,`rp`.`recruitment_title`,`o`.`organization_name`,`d`.`id`,`d`.`division_name` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_application_details`
--

/*!50001 DROP VIEW IF EXISTS `v_application_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_application_details` AS select `a`.`id` AS `application_id`,`a`.`application_code` AS `application_code`,`u`.`student_number` AS `student_number`,`u`.`full_name` AS `full_name`,`u`.`email` AS `email`,`o`.`organization_code` AS `organization_code`,`o`.`organization_name` AS `organization_name`,`rp`.`recruitment_title` AS `recruitment_title`,`rp`.`academic_year` AS `academic_year`,group_concat(distinct concat(`ap`.`preference_order`,'. ',`d`.`division_name`) order by `ap`.`preference_order` ASC separator ', ') AS `division_preferences`,count(distinct `ad`.`id`) AS `total_documents`,`a`.`final_score` AS `final_score`,`a`.`application_status` AS `application_status`,`a`.`submitted_at` AS `submitted_at` from ((((((`applications` `a` join `users` `u` on((`u`.`id` = `a`.`user_id`))) join `recruitment_periods` `rp` on((`rp`.`id` = `a`.`recruitment_period_id`))) join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) left join `application_preferences` `ap` on((`ap`.`application_id` = `a`.`id`))) left join `divisions` `d` on((`d`.`id` = `ap`.`division_id`))) left join `application_documents` `ad` on((`ad`.`application_id` = `a`.`id`))) group by `a`.`id`,`a`.`application_code`,`u`.`student_number`,`u`.`full_name`,`u`.`email`,`o`.`organization_code`,`o`.`organization_name`,`rp`.`recruitment_title`,`rp`.`academic_year`,`a`.`final_score`,`a`.`application_status`,`a`.`submitted_at` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `v_recruitment_summary`
--

/*!50001 DROP VIEW IF EXISTS `v_recruitment_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `v_recruitment_summary` AS select `rp`.`id` AS `recruitment_period_id`,`o`.`organization_name` AS `organization_name`,`rp`.`recruitment_title` AS `recruitment_title`,`rp`.`registration_start_date` AS `registration_start_date`,`rp`.`registration_end_date` AS `registration_end_date`,`rp`.`total_quota` AS `total_quota`,`rp`.`recruitment_status` AS `recruitment_status`,count(`a`.`id`) AS `total_applicants`,sum((case when (`a`.`application_status` = 'submitted') then 1 else 0 end)) AS `total_submitted`,sum((case when (`a`.`application_status` = 'under_review') then 1 else 0 end)) AS `total_under_review`,sum((case when (`a`.`application_status` = 'accepted') then 1 else 0 end)) AS `total_accepted`,sum((case when (`a`.`application_status` = 'rejected') then 1 else 0 end)) AS `total_rejected`,greatest((`rp`.`total_quota` - sum((case when (`a`.`application_status` = 'accepted') then 1 else 0 end))),0) AS `remaining_quota` from ((`recruitment_periods` `rp` join `organizations` `o` on((`o`.`id` = `rp`.`organization_id`))) left join `applications` `a` on((`a`.`recruitment_period_id` = `rp`.`id`))) group by `rp`.`id`,`o`.`organization_name`,`rp`.`recruitment_title`,`rp`.`registration_start_date`,`rp`.`registration_end_date`,`rp`.`total_quota`,`rp`.`recruitment_status` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-18 14:11:50
