-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ngen
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact`
(
    `id`               int                                                     NOT NULL AUTO_INCREMENT,
    `name`             varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `username`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `encryption_key`   varchar(4000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `network_admin_id` int                                                      DEFAULT NULL,
    `contact_type`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `contact_case`     varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci   DEFAULT NULL,
    `discr`            varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `user_id`          int                                                      DEFAULT NULL,
    `created_by_id`    int                                                      DEFAULT NULL,
    `created_at`       datetime                                                 DEFAULT NULL,
    `updated_at`       datetime                                                 DEFAULT NULL,
    `deletedAt`        datetime                                                 DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_4C62E638C9E8B981` (`network_admin_id`),
    KEY `IDX_4C62E63850F71BFB` (`contact_case`),
    KEY `IDX_4C62E638A76ED395` (`user_id`),
    KEY `IDX_4C62E638B03A8386` (`created_by_id`),
    CONSTRAINT `FK_4C62E63850F71BFB` FOREIGN KEY (`contact_case`) REFERENCES `contact_case` (`slug`),
    CONSTRAINT `FK_4C62E638A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_4C62E638B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_4C62E638C9E8B981` FOREIGN KEY (`network_admin_id`) REFERENCES `network_admin` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact`
    DISABLE KEYS */;
INSERT INTO `contact`
VALUES (1, 'email', 'admin@cert.com', NULL, NULL, 'mail', 'all', 'email', 1, 1, '2020-08-31 23:04:29',
        '2020-08-31 23:04:29', NULL),
       (2, 'Undefined', 'Undefined', NULL, 2, 'mail', 'all', 'email', NULL, 1, '2020-09-09 22:16:07',
        '2020-09-09 22:16:07', NULL);
/*!40000 ALTER TABLE `contact`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_case`
--

DROP TABLE IF EXISTS `contact_case`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_case`
(
    `slug`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `description`   varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `level`         int                                                    NOT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_50F71BFBB03A8386` (`created_by_id`),
    CONSTRAINT `FK_50F71BFBB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_case`
--

LOCK TABLES `contact_case` WRITE;
/*!40000 ALTER TABLE `contact_case`
    DISABLE KEYS */;
INSERT INTO `contact_case`
VALUES ('all', 'All', 'Send all the problems', 5, NULL, NULL, NULL, NULL),
       ('critical', 'Only Critical', 'Only critical', 1, NULL, NULL, NULL, NULL),
       ('high', 'From High', 'High and worst', 2, NULL, NULL, NULL, NULL),
       ('low', 'From Low', 'Low and worst', 4, NULL, NULL, NULL, NULL),
       ('medium', 'From Medium', 'Medium and worst', 3, NULL, NULL, NULL, NULL),
       ('none', 'Dont contact me', 'Never use this contact', 0, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `contact_case`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ext_translations`
--

DROP TABLE IF EXISTS `ext_translations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ext_translations`
(
    `id`           int                                                     NOT NULL AUTO_INCREMENT,
    `locale`       varchar(8) CHARACTER SET utf8 COLLATE utf8_unicode_ci   NOT NULL,
    `object_class` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `field`        varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `foreign_key`  varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `content`      longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    PRIMARY KEY (`id`),
    UNIQUE KEY `lookup_unique_idx` (`locale`, `object_class`, `field`, `foreign_key`),
    KEY `translations_lookup_idx` (`locale`, `object_class`, `foreign_key`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 56
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci
  ROW_FORMAT = DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ext_translations`
--

LOCK TABLES `ext_translations` WRITE;
/*!40000 ALTER TABLE `ext_translations`
    DISABLE KEYS */;
INSERT INTO `ext_translations`
VALUES (19, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'open', 'Abierto'),
       (26, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'closed', 'Cerrado'),
       (27, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'closed_by_inactivity',
        'Cerrado por inactividad'),
       (28, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'staging', 'En espera'),
       (29, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'undefined', 'Indefinido'),
       (30, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'unresolved', 'Sin resolver'),
       (31, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'removed', 'Eliminado'),
       (32, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentState', 'name', 'stand_by', 'En espera'),
       (33, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentImpact', 'name', 'high', 'Alta'),
       (34, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentImpact', 'name', 'low', 'Baja'),
       (35, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentImpact', 'name', 'medium', 'Media'),
       (36, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentImpact', 'name', 'undefined', 'Sin definir'),
       (37, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentUrgency', 'name', 'high', 'Alta'),
       (38, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentUrgency', 'name', 'low', 'Baja'),
       (39, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentUrgency', 'name', 'medium', 'Media'),
       (40, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentUrgency', 'name', 'undefined', 'Sin definir'),
       (41, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'high_high', 'Critica'),
       (42, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'high_low', 'Media'),
       (43, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'high_medium', 'Alta'),
       (44, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'low_high', 'Media'),
       (45, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'low_low', 'Muy baja'),
       (46, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'low_medium', 'Baja'),
       (47, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'medium_high', 'Alta'),
       (48, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'medium_low', 'Baja'),
       (49, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'medium_medium', 'Media'),
       (50, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentPriority', 'name', 'undefined_undefined',
        'Sin definir'),
       (52, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentTlp', 'name', 'amber', 'AMBAR'),
       (53, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentTlp', 'name', 'green', 'VERDE'),
       (54, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentTlp', 'name', 'red', 'ROJO'),
       (55, 'es', 'CertUnlp\\NgenBundle\\Entity\\Incident\\IncidentTlp', 'name', 'white', 'BLANCO');
/*!40000 ALTER TABLE `ext_translations`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `host`
--

DROP TABLE IF EXISTS `host`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `host`
(
    `id`            int        NOT NULL AUTO_INCREMENT,
    `network_id`    int                                                     DEFAULT NULL,
    `ip`            varchar(39) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `domain`        varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `slug`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `active`        tinyint(1) NOT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_CF2713FD34128B91` (`network_id`),
    KEY `IDX_CF2713FDB03A8386` (`created_by_id`),
    CONSTRAINT `FK_CF2713FD34128B91` FOREIGN KEY (`network_id`) REFERENCES `network` (`id`),
    CONSTRAINT `FK_CF2713FDB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `host`
--

LOCK TABLES `host` WRITE;
/*!40000 ALTER TABLE `host`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `host`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident`
--

DROP TABLE IF EXISTS `incident`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident`
(
    `id`                  int        NOT NULL AUTO_INCREMENT,
    `type`                varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `feed`                varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `state`               varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `reporter_id`         int                                                     DEFAULT NULL,
    `network_id`          int                                                     DEFAULT NULL,
    `date`                datetime   NOT NULL,
    `renotification_date` datetime                                                DEFAULT NULL,
    `created_at`          datetime                                                DEFAULT NULL,
    `updated_at`          datetime                                                DEFAULT NULL,
    `evidence_file_path`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `report_message_id`   varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `slug`                varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `notes`               longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `tlp_state`           varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `assigned_id`         int                                                     DEFAULT NULL,
    `origin_id`           int                                                     DEFAULT NULL,
    `destination_id`      int                                                     DEFAULT NULL,
    `ltd_count`           int        NOT NULL,
    `unattended_state`    varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `unsolved_state`      varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `response_dead_line`  datetime                                                DEFAULT NULL,
    `solve_dead_line`     datetime                                                DEFAULT NULL,
    `priority_id`         int                                                     DEFAULT NULL,
    `created_by_id`       int                                                     DEFAULT NULL,
    `active`              tinyint(1) NOT NULL,
    `deletedAt`           datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_3D03A11A8CDE5729` (`type`),
    KEY `IDX_3D03A11A234044AB` (`feed`),
    KEY `IDX_3D03A11AA393D2FB` (`state`),
    KEY `IDX_3D03A11AE1CFE6F5` (`reporter_id`),
    KEY `IDX_3D03A11A34128B91` (`network_id`),
    KEY `IDX_3D03A11AB8037C6C` (`tlp_state`),
    KEY `IDX_3D03A11AE1501A05` (`assigned_id`),
    KEY `IDX_3D03A11A56A273CC` (`origin_id`),
    KEY `IDX_3D03A11A816C6140` (`destination_id`),
    KEY `IDX_3D03A11A3AA33DF6` (`unattended_state`),
    KEY `IDX_3D03A11AEC6344B7` (`unsolved_state`),
    KEY `IDX_3D03A11A497B19F9` (`priority_id`),
    KEY `IDX_3D03A11AB03A8386` (`created_by_id`),
    CONSTRAINT `FK_3D03A11A234044AB` FOREIGN KEY (`feed`) REFERENCES `incident_feed` (`slug`),
    CONSTRAINT `FK_3D03A11A34128B91` FOREIGN KEY (`network_id`) REFERENCES `network` (`id`),
    CONSTRAINT `FK_3D03A11A3AA33DF6` FOREIGN KEY (`unattended_state`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_3D03A11A497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `incident_priority` (`id`),
    CONSTRAINT `FK_3D03A11A56A273CC` FOREIGN KEY (`origin_id`) REFERENCES `host` (`id`),
    CONSTRAINT `FK_3D03A11A816C6140` FOREIGN KEY (`destination_id`) REFERENCES `host` (`id`),
    CONSTRAINT `FK_3D03A11A8CDE5729` FOREIGN KEY (`type`) REFERENCES `incident_type` (`slug`),
    CONSTRAINT `FK_3D03A11AA393D2FB` FOREIGN KEY (`state`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_3D03A11AB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_3D03A11AB8037C6C` FOREIGN KEY (`tlp_state`) REFERENCES `incident_tlp` (`slug`),
    CONSTRAINT `FK_3D03A11AE1501A05` FOREIGN KEY (`assigned_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_3D03A11AE1CFE6F5` FOREIGN KEY (`reporter_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_3D03A11AEC6344B7` FOREIGN KEY (`unsolved_state`) REFERENCES `incident_state` (`slug`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident`
--

LOCK TABLES `incident` WRITE;
/*!40000 ALTER TABLE `incident`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `incident`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_comment`
--

DROP TABLE IF EXISTS `incident_comment`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_comment`
(
    `id`         int                                                      NOT NULL AUTO_INCREMENT,
    `thread_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `author_id`  int                                                     DEFAULT NULL,
    `body`       longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci      NOT NULL,
    `ancestors`  varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `depth`      int                                                      NOT NULL,
    `created_at` datetime                                                 NOT NULL,
    `state`      int                                                      NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_33BE48B1E2904019` (`thread_id`),
    KEY `IDX_33BE48B1F675F31B` (`author_id`),
    CONSTRAINT `FK_33BE48B1E2904019` FOREIGN KEY (`thread_id`) REFERENCES `incident_comment_thread` (`id`),
    CONSTRAINT `FK_33BE48B1F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_comment`
--

LOCK TABLES `incident_comment` WRITE;
/*!40000 ALTER TABLE `incident_comment`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_comment`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_comment_thread`
--

DROP TABLE IF EXISTS `incident_comment_thread`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_comment_thread`
(
    `id`              varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `incident_id`     int      DEFAULT NULL,
    `permalink`       varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `is_commentable`  tinyint(1)                                              NOT NULL,
    `num_comments`    int                                                     NOT NULL,
    `last_comment_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_E073862F59E53FB9` (`incident_id`),
    CONSTRAINT `FK_E073862F59E53FB9` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_comment_thread`
--

LOCK TABLES `incident_comment_thread` WRITE;
/*!40000 ALTER TABLE `incident_comment_thread`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_comment_thread`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_decision`
--

DROP TABLE IF EXISTS `incident_decision`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_decision`
(
    `id`               int        NOT NULL AUTO_INCREMENT,
    `type`             varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `feed`             varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `tlp`              varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `state`            varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `network`          int                                                     DEFAULT NULL,
    `created_at`       datetime                                                DEFAULT NULL,
    `updated_at`       datetime                                                DEFAULT NULL,
    `auto_saved`       tinyint(1) NOT NULL,
    `active`           tinyint(1) NOT NULL,
    `unattended_state` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `unsolved_state`   varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id`    int                                                     DEFAULT NULL,
    `deletedAt`        datetime                                                DEFAULT NULL,
    `priority_id`      int                                                     DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_7C69DA3B8CDE5729` (`type`),
    KEY `IDX_7C69DA3B234044AB` (`feed`),
    KEY `IDX_7C69DA3B35F44C09` (`tlp`),
    KEY `IDX_7C69DA3BA393D2FB` (`state`),
    KEY `IDX_7C69DA3B608487BC` (`network`),
    KEY `IDX_7C69DA3B3AA33DF6` (`unattended_state`),
    KEY `IDX_7C69DA3BEC6344B7` (`unsolved_state`),
    KEY `IDX_7C69DA3BB03A8386` (`created_by_id`),
    KEY `IDX_7C69DA3B497B19F9` (`priority_id`),
    CONSTRAINT `FK_7C69DA3B234044AB` FOREIGN KEY (`feed`) REFERENCES `incident_feed` (`slug`),
    CONSTRAINT `FK_7C69DA3B497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `incident_priority` (`id`),
    CONSTRAINT `FK_7C69DA3B608487BC` FOREIGN KEY (`network`) REFERENCES `network` (`id`),
    CONSTRAINT `FK_7C69DA3B62A6DC27` FOREIGN KEY (`tlp`) REFERENCES `incident_tlp` (`slug`),
    CONSTRAINT `FK_7C69DA3B7DC9D7A5` FOREIGN KEY (`unattended_state`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_7C69DA3B8CDE5729` FOREIGN KEY (`type`) REFERENCES `incident_type` (`slug`),
    CONSTRAINT `FK_7C69DA3BA393D2FB` FOREIGN KEY (`state`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_7C69DA3BB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_7C69DA3BEC6344B7` FOREIGN KEY (`unsolved_state`) REFERENCES `incident_state` (`slug`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_decision`
--

LOCK TABLES `incident_decision` WRITE;
/*!40000 ALTER TABLE `incident_decision`
    DISABLE KEYS */;
INSERT INTO `incident_decision`
VALUES (1, 'undefined', 'undefined', 'green', 'undefined', NULL, '2020-09-01 01:07:10', '2020-09-01 01:07:10', 0, 1,
        'discarded_by_unattended', 'closed_by_unsolved', NULL, NULL, 5);
/*!40000 ALTER TABLE `incident_decision`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_detected`
--

DROP TABLE IF EXISTS `incident_detected`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_detected`
(
    `id`                 int        NOT NULL AUTO_INCREMENT,
    `incident_id`        int                                                     DEFAULT NULL,
    `assigned_id`        int                                                     DEFAULT NULL,
    `type`               varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `feed`               varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `state`              varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `tlp_state`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `date`               datetime                                                DEFAULT NULL,
    `evidence_file_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `notes`              longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `priority_id`        int                                                     DEFAULT NULL,
    `created_by_id`      int                                                     DEFAULT NULL,
    `active`             tinyint(1) NOT NULL,
    `created_at`         datetime                                                DEFAULT NULL,
    `updated_at`         datetime                                                DEFAULT NULL,
    `reporter_id`        int                                                     DEFAULT NULL,
    `deletedAt`          datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_F997633159E53FB9` (`incident_id`),
    KEY `IDX_F9976331E1501A05` (`assigned_id`),
    KEY `IDX_F99763318CDE5729` (`type`),
    KEY `IDX_F9976331234044AB` (`feed`),
    KEY `IDX_F9976331A393D2FB` (`state`),
    KEY `IDX_F9976331B8037C6C` (`tlp_state`),
    KEY `IDX_F9976331497B19F9` (`priority_id`),
    KEY `IDX_F9976331B03A8386` (`created_by_id`),
    KEY `IDX_F9976331E1CFE6F5` (`reporter_id`),
    CONSTRAINT `FK_F9976331234044AB` FOREIGN KEY (`feed`) REFERENCES `incident_feed` (`slug`),
    CONSTRAINT `FK_F9976331497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `incident_priority` (`id`),
    CONSTRAINT `FK_F997633159E53FB9` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`),
    CONSTRAINT `FK_F99763318CDE5729` FOREIGN KEY (`type`) REFERENCES `incident_type` (`slug`),
    CONSTRAINT `FK_F9976331A393D2FB` FOREIGN KEY (`state`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_F9976331B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_F9976331B8037C6C` FOREIGN KEY (`tlp_state`) REFERENCES `incident_tlp` (`slug`),
    CONSTRAINT `FK_F9976331E1501A05` FOREIGN KEY (`assigned_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_F9976331E1CFE6F5` FOREIGN KEY (`reporter_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_detected`
--

LOCK TABLES `incident_detected` WRITE;
/*!40000 ALTER TABLE `incident_detected`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_detected`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_feed`
--

DROP TABLE IF EXISTS `incident_feed`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_feed`
(
    `slug`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `active`        tinyint(1)                                              NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `description`   varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_C94C3314B03A8386` (`created_by_id`),
    CONSTRAINT `FK_C94C3314B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_feed`
--

LOCK TABLES `incident_feed` WRITE;
/*!40000 ALTER TABLE `incident_feed`
    DISABLE KEYS */;
INSERT INTO `incident_feed`
VALUES ('bro', 'Bro', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('constituency', 'Constituency', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('external_report', 'External report', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('netflow', 'Netflow', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('shadowserver', 'Shadowserver', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('team_cymru', 'Team Cymru', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL, NULL),
       ('undefined', 'Undefined', 1, '2020-09-01 01:07:10', '2020-09-01 01:07:10', NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_feed`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_impact`
--

DROP TABLE IF EXISTS `incident_impact`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_impact`
(
    `slug`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `name`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `description`   varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `active`        tinyint(1)                                              NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_69357CE3B03A8386` (`created_by_id`),
    CONSTRAINT `FK_69357CE3B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_impact`
--

LOCK TABLES `incident_impact` WRITE;
/*!40000 ALTER TABLE `incident_impact`
    DISABLE KEYS */;
INSERT INTO `incident_impact`
VALUES ('high', 'High',
        'A large number of staff are affected and/or not able to do their job. A large number of customers are affected and/or acutely disadvantaged in some way. The financial impact of the Incident is (for example) likely to exceed $10,000. The damage to the reputation of the business is likely to be high. Someone has been injured.',
        NULL, 1, NULL, NULL, NULL),
       ('low', 'Low',
        'A minimal number of staff are affected and/or able to deliver an acceptable service but this requires extra effort.\nA minimal number of customers are affected and/or inconvenienced but not in a significant way.\nThe financial impact of the Incident is (for example) likely to be less than $1,000.\nThe damage to the reputation of the business is likely to be minimal.',
        NULL, 1, NULL, NULL, NULL),
       ('medium', 'Medium',
        'A moderate number of staff are affected and/or not able to do their job properly.\nA moderate number of customers are affected and/or inconvenienced in some way.\nThe financial impact of the Incident is (for example) likely to exceed $1,000 but will not be more than $10,000.\nThe damage to the reputation of the business is likely to be moderate.',
        NULL, 1, NULL, NULL, NULL),
       ('undefined', 'Undefined', 'Undefined', NULL, 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_impact`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_priority`
--

DROP TABLE IF EXISTS `incident_priority`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_priority`
(
    `slug`              varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`              varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `response_time`     int                                                     NOT NULL,
    `resolution_time`   int                                                     NOT NULL,
    `code`              int                                                     NOT NULL,
    `impact`            varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `urgency`           varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`        datetime                                               DEFAULT NULL,
    `updated_at`        datetime                                               DEFAULT NULL,
    `unresponse_time`   int                                                     NOT NULL,
    `unresolution_time` int                                                     NOT NULL,
    `active`            tinyint(1)                                              NOT NULL,
    `id`                int                                                     NOT NULL AUTO_INCREMENT,
    `created_by_id`     int                                                    DEFAULT NULL,
    `deletedAt`         datetime                                               DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_9A63B854989D9B62` (`slug`),
    KEY `IDX_9A63B854C409C007` (`impact`),
    KEY `IDX_9A63B854677C3782` (`urgency`),
    KEY `IDX_9A63B854B03A8386` (`created_by_id`),
    CONSTRAINT `FK_9A63B854677C3782` FOREIGN KEY (`urgency`) REFERENCES `incident_urgency` (`slug`),
    CONSTRAINT `FK_9A63B854B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_9A63B854C409C007` FOREIGN KEY (`impact`) REFERENCES `incident_impact` (`slug`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_priority`
--

LOCK TABLES `incident_priority` WRITE;
/*!40000 ALTER TABLE `incident_priority`
    DISABLE KEYS */;
INSERT INTO `incident_priority`
VALUES ('high_high', 'Critical', 0, 1, 1, 'high', 'high', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 0, 0, 1, 1,
        NULL, NULL),
       ('high_low', 'Medium', 60, 480, 3, 'high', 'low', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080, 1,
        2, NULL, NULL),
       ('high_medium', 'High', 10, 240, 2, 'high', 'medium', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080,
        1, 3, NULL, NULL),
       ('low_high', 'Medium', 60, 480, 3, 'low', 'high', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080, 1,
        4, NULL, NULL),
       ('low_low', 'Very Low', 1440, 10080, 5, 'low', 'low', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080,
        1, 5, NULL, NULL),
       ('low_medium', 'Low', 240, 1440, 4, 'low', 'medium', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080,
        1, 6, NULL, NULL),
       ('medium_high', 'High', 10, 240, 2, 'medium', 'high', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080,
        1, 7, NULL, NULL),
       ('medium_low', 'Low', 240, 1440, 4, 'medium', 'low', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080, 10080,
        1, 8, NULL, NULL),
       ('medium_medium', 'Medium', 60, 480, 3, 'medium', 'medium', '2020-09-01 01:07:16', '2020-09-01 01:07:16', 10080,
        10080, 1, 9, NULL, NULL),
       ('undefined_undefined', 'Undefined', 0, 0, 0, 'undefined', 'undefined', '2020-09-01 01:07:16',
        '2020-09-01 01:07:16', 10080, 10080, 1, 10, NULL, NULL);
/*!40000 ALTER TABLE `incident_priority`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_report`
--

DROP TABLE IF EXISTS `incident_report`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_report`
(
    `slug`              varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `type`              varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `lang`              varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `problem`           longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci    NOT NULL,
    `derivated_problem` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `verification`      longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `recomendations`    longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `more_information`  longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
    `active`            tinyint(1)                                             NOT NULL,
    `created_at`        datetime                                                DEFAULT NULL,
    `updated_at`        datetime                                                DEFAULT NULL,
    `created_by_id`     int                                                     DEFAULT NULL,
    `deletedAt`         datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_6913CB608CDE5729` (`type`),
    KEY `IDX_6913CB60B03A8386` (`created_by_id`),
    CONSTRAINT `FK_6913CB608CDE5729` FOREIGN KEY (`type`) REFERENCES `incident_type` (`slug`),
    CONSTRAINT `FK_6913CB60B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_report`
--

LOCK TABLES `incident_report` WRITE;
/*!40000 ALTER TABLE `incident_report`
    DISABLE KEYS */;
INSERT INTO `incident_report`
VALUES ('blacklist-en', 'blacklist', 'en',
        'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} under your administration has been detected in blacklists. For more information please view the attached file.',
        'Emails sent to certain destinations could be filtered if they contain the IP  {{incident.hostAddress}}.',
        'You can verify the existence of you IP in different blacklists accessing the following site\n\n<div class = \"destacated\">\n\n<pre><code>http://whatismyipaddress.com/blacklist-check\n</code></pre>\n\n</div>',
        'We suggest you to access the corresponding pages to remove those hosts.', NULL, 1, '2018-11-02 14:49:40',
        '2018-11-02 14:49:40', NULL, NULL),
       ('blacklist-es', 'blacklist', 'es',
        'Nos comunicamos con usted para informarle que hemos detectado que el Host {{incident.hostAddress}} el cual esta bajo su administración, ha sido detectado en blacklists, las cuales se encuentran en el archivo adjunto.',
        'Servicios brindados por la IP {{incident.hostAddress}} puede verse afectados por la existencia de dicha IP en la blacklist reportada.',
        'Puede comprobar la existencia de su IP en diferentes blacklist consultando el sitio\n\n<div class=\"destacated\">\n\n<pre><code>http://whatismyipaddress.com/blacklist-check\n</code></pre>\n\n</div>',
        'Le sugerimos acceder a las páginas correspondientes para eliminar dichos hosts de las mismas.', NULL, 1,
        '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('botnet-en', 'botnet', 'en',
        'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is currently infected with malware and part of a BotNet.',
        'The consequences of the host being infected may vary, we can list the following:\n\n<ul>\n<li><p>Excessive consumption of bandwidth by the host.</p></li>\n<li><p>Compromising other hosts.</p></li>\n<li><p>Compromising user information.</p></li>\n<li><p>etc</p></li>\n</ul>',
        'The verification can be achieved analyzing the existing network traffic of the infected host or network, using tools such as:\n\n<div class = \"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\nor\n\n<div class = \"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'The network traffic should be filtered until the problem is solved.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.linuxjournal.com/magazine/detecting-botnets\">http://www.linuxjournal.com/magazine/detecting-botnets</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('botnet-es', 'botnet', 'es',
        'Nos comunicamos con Ud. para informarle que se detectó que el host {{incident.hostAddress}} se encuentra infectado con un malware el cual participa en la formación de una Botnet.',
        'Encontrándose infectado el equipo, existen diversas consecuencias entre las que podemos listas:\n\n<ul>\n<li><p>Consumo excesivo del ancho de banda por parte del host.</p></li>\n<li><p>Compromiso de otros equipos.</p></li>\n<li><p>Compromiso de información propia de los usuarios.</p></li>\n<li><p>etc</p></li>\n</ul>',
        'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como \n\n<div class=\"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\no \n\n<div class=\"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'Se recomienda el filtrado del tráfico hasta que el problema se vea resultó.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.linuxjournal.com/magazine/detecting-botnets\">http://www.linuxjournal.com/magazine/detecting-botnets</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('bruteforce-en', 'bruteforce', 'en',
        'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is involved in brute forcing attacks, most likely due the host being compromised.',
        'This type of attacks are commonly linked to a malware trying to infect other devices inside or outside the network, or possibly an attacker realizing a network scan. Whichever the case, there direct consequences are:\n\n<ul>\n<li><p>Excessive consumption of bandwidth by the host.</p></li>\n<li><p>Compromising other hosts.</p></li>\n<li><p>etc</p></li>\n</ul>',
        'The verification can be achieved analyzing the existing network traffic of the infected host or network, using tools such as:\n\n<div class = \"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\nor\n\n<div class = \"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'The network traffic should be filtered until the problem is solved.\nAttached to this email you can find the connection logs to identify the malicious activity.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks\">http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('bruteforce-es', 'bruteforce', 'es',
        'Se detectaron ataques de fuerza bruta provenientes del host {{incident.hostAddress}}, los cuales probablemente se deban a que el equipo ha sido comprometido.',
        'Este tipo de ataques suelen estar vinculados a un malware que busca infectar otros dispositivos, de la red o no, o a un atacante que utiliza el mismo para realizar un reconocimiento de la red.\nEn cualquiera de los dos casos, existen consecuencias directas de su realización:\n\n<ul>\n<li><p>Consumo excesivo del ancho de banda por parte del host</p></li>\n<li><p>Compromiso de otros equipos</p></li>\n<li><p>etc</p></li>\n</ul>',
        'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como \n\n<div class=\"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\no \n\n<div class=\"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'Adjunto le enviamos logs de conexiones para que pueda identificar la actividad maliciosa del host.\nSe recomienda el filtrado del tráfico hasta que el problema se vea resultó.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks\">http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('cisco_smart_install-en', 'cisco_smart_install', 'en',
        'This report identifies hosts that have the Cisco Smart Install feature running and accessible to the internet at large. This feature can be used to read or potentially modify a switch\'s configuration.',
        'Information leaking, modify configuration, update firmware and even run commands.',
        'Test with Nmap at port 4786. There is more tools to exploit this vulnerability. From swith you can use command `show vstack config` to test if feature is enabled.',
        'If customers find devices in their network that continue to have the Smart Install feature enabled, Cisco strongly recommends that they disable the Smart Install feature with the no vstack configuration command.\n\nOtherwise, customers should apply the appropriate security controls for the Smart Install feature and their environment. The recommendations noted below and in the Security response will avoid the risk of attackers abusing this feature.',
        'More details can be found on Cisco\'s PSIRT blog. https://blogs.cisco.com/security/cisco-psirt-mitigating-and-detecting-potential-abuse-of-cisco-smart-install-feature',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('cisco_smart_install-es', 'cisco_smart_install', 'es',
        'Lo contactamos porque hemos sido informados que el dispositivo con IP {{incident.hostAddress}} tiene habilitado y accesible desde internet la característica \"Cisco Smart Install\".',
        'Podría ser posible leer y modificar la configuración del dispositivo, actualizar el firmware e incluso ejecutar comandos.',
        'Realizar un Nmap al puerto 4786. Tener en cuenta que existen otras herramientas desarrolladas para explotar esta vulnerabilidad.\nDesde el switch se puede utilizar el comando `show vstack config` para verificar si se encuentra habilitado.',
        'Deshabilitar la caracteristica \"Smart Install\" con el comando `no vstack`',
        'https://blogs.cisco.com/security/cisco-psirt-mitigating-and-detecting-potential-abuse-of-cisco-smart-install-feature',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('copyright-en', 'copyright', 'en',
        'We have been notified that the <em>host</em> {{incident.hostAddress}} is distributing copyrighted material. This is due to an improper use of a P2P network.',
        'Legal actions could be taken against the owner of the host responsible.', NULL,
        'The corresponding network traffic should be filtered to solve this problem. If this is not possible, forward the issue to the corresponding users.\n\nAttached to this email you can find a copy of the report we have received.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('copyright-es', 'copyright', 'es',
        'Nos notificaron que el host {{incident.hostAddress}} está distribuyendo material con copyright. Esto se debe probablemente a que se está utilizando indebidamente una red P2P.',
        'La recepción de acciones legales tomadas contra el responsable del host.', NULL,
        'La solución a este incidente consiste en filtrar este tipo de tráfico o, en caso de no ser posible, trasladar la inquietud a los usuarios para que estén al tanto de estas notificaciones.\n\nAdjunto le enviamos una copia del informe que recibimos.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('data_breach-en', 'data_breach', 'en', 'Data Breach',
        'A data breach is the intentional or unintentional release of secure or private/confidential information to an untrusted environment. Other terms for this phenomenon include unintentional information disclosure, data leak and also data spill. For example username and password exposed.',
        'Check evidence',
        '* Invalidate data exposed, for example force users to change credenetials.\n* Check in the logs if for the compromised data had been used.\n* Ask the publisher to remove the leakage information',
        '* Check for compromised data in: https://haveibeenpwned.com/', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('data_breach-es', 'data_breach', 'es', 'Fuga de información.',
        'Pueden verse comprometidas datos sensibles del usuario. Un ejemplo son las credenciales de usuario (username y password) que apliquen a otros sistemas ante una fuga de información.',
        'Revisar la evidencia que se adjunta.',
        '* Invalidar los datos relacionados a la fuga de datos. Por ejemplo forzando el cambio de contraseña\n* Revisar los accesos realizados con los datos\n* Solicitar al que esta publicando los datos que remueva la publicación',
        'Puede chequear adicionalmente: https://haveibeenpwned.com/', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('deface-en', 'deface', 'en',
        'We would like to inform you that we have detected that web page hosted with IP {{incident.hostAddress}} has suffered a defacement\'s attack. This is an attack on a website that changes the visual appearance of the site or a webpage performed by an attacker.',
        'The changes in the existing information of the server indicates that the attackers succeeded to obtain restricted privileges on the server. As a result, the server may be exposed to other types of problems, such as:\n\n<ul>\n<li><p>Malware.</p></li>\n<li><p>Be used to perform more sophisticated attacks.</p></li>\n<li><p>Obtaining more privileges.</p></li>\n<li><p>etc.</p></li>\n</ul>',
        'The defacement\'s attack can be observed in the URL\n\n<div class = \"destacated\">\n\n<pre><code>http://{{incident.hostAddress}}/\n</code></pre>\n\n</div>',
        'We recommend a forensic analysis on the involved server to obtain information about the source of the problem and it\'s extent. On the other hand, we recommend a penetration test analysis over the involved site, which allows early problem identification that could lead to similar situations.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('deface-es', 'deface', 'es',
        'Nos ponemos en contacto con Ud. para informarle que el sitio web que se encuentra en {{incident.hostAddress}} sufrió un ataque de defacement, el cual consiste en la modificación del contenido propio del portal por terceros.',
        'La modificación de la información existente en el servidor indica la obtención de privilegios sobre el mismo por parte de los atacantes. A raíz de esta situación, el servidor puede encontrarse expuesto a otros tipos de problemas, como ser:\n\n<ul>\n<li><p>Alojamiento de malware.</p></li>\n<li><p>Servir como origen de ataques más sofisticados.</p></li>\n<li><p>Obtención de mayores privilegios sobre el mismo.</p></li>\n<li><p>etc.</p></li>\n</ul>',
        'El defacement puede ser observado a través de la URL \n\n<div class=\"destacated\">\n\n<pre><code>http://{{incident.hostAddress}}/\n</code></pre>\n\n</div>',
        'Se recomienda la realización de una forensia sobre el servidor con el objetivo de conocer el origen del problema como así también el alcance del ataque. Por otro lado, se recomienda la realización de un pentest sobre el sitio afectado, el cual permitirá la identificación temprana de otros problemas que podrían derivar en situaciones similares a la presente.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dns_zone_transfer-en', 'dns_zone_transfer', 'en',
        'LWe would like to inform you that we have detected that the DNS <em>server</em> with IP {{incident.hostAddress}} has zone transfer active in some zones, visible at least from our CERT network.',
        '<p class=\"lead\">Problemas derivados</p>\n\nThe <em>server</em> under your administration could be used in DNS amplification attacks.',
        'Use the following command:\n\n<div class = \"destacated\">\n\n<pre><code>dig &lt;zona&gt;.unlp.edu.ar @{{incident.hostAddress}} axfr\n</code></pre>\n\n</div>',
        'We recommend establishing restrictions to the DNS server allowing zone queries only from secondary DNS servers.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868\">http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868</a></p></li>\n<li><p><a href=\"http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868\">http://www.esdebian.org/wiki/transferencias-zonas-bind9</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dns_zone_transfer-es', 'dns_zone_transfer', 'es',
        'Lo contactamos porque hemos detectado que el servidor DNS con IP {{incident.hostAddress}}\ntiene habilitada la transferencia de alguna de sus zonas, al menos desde la\nred de nuestro CERT.',
        'El host bajo su administración podría llegar a ser usado en ataques de\namplificación DNS.',
        'Utilizando el comando:\n\n<div class=\"destacated\">\n\n<pre><code>dig &lt;zona&gt;.unlp.edu.ar @{{incident.hostAddress}} axfr\n</code></pre>\n\n</div>',
        'Se recomienda establecer restricciones en el servidor DNS que permitan la\nconsultas de requerimiento de zona solo desde los servidores DNS secundarios.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868\">http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868</a></p></li>\n<li><p><a href=\"http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868\">http://www.esdebian.org/wiki/transferencias-zonas-bind9</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_chargen-en', 'dos_chargen', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>chargen</strong> service (UDP port 19).',
        NULL,
        'The verification can be achieved analyzing the existing network traffic and observing UDP datagrams from and towards the port 19. Alternatively, it can be verified by manually connecting to the service using the following command:\n\n<div class = \"destacated\">\n\n<pre><code>ncat -u {{incident.hostAddress}} 19\n</code></pre>\n\n</div>',
        'We recommend:\n\n<div class = \"destacated\">\n\n<ul>\n<li><p>Disable corresponding service.</p></li>\n<li><p>Establish firewall rules to filter incoming and outgoing network traffic in the port 19/UDP.</p></li>\n</ul>\n\n</div>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_chargen-es', 'dos_chargen', 'es',
        'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio <strong>chargen</strong>.',
        NULL,
        'El problema puede ser verificado mediante el monitoreo de red que permita observar trafico UDP hacia y desde el puerto 19.\nAlternativamente puede verificarlo conectándose manualmente a dicho servicio mediante el comando:\n\n<div class=\"destacated\">\n\n<pre><code>ncat -u {{incident.hostAddress}} 19\n</code></pre>\n\n</div>',
        'Se recomienda:\n\n<div class=\"destacated\">\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas en el firewall para bloquear de forma entrante y saliente el puerto 19/UDP</p></li>\n</ul>\n\n</div>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_ntp-en', 'dos_ntp', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>NTP service</strong> (UDP port 123).',
        NULL,
        'The verification can be achieved analyzing the server response to the commands <strong><em>NTP readvar</em></strong> and/or <strong><em>NTP monlist</em></strong>. To manually verify if the service responds to these types of commands, use the following commands:\n\n\n<div class = \"destacated\">\n\n<pre><code>ntpq -c readvar [{{incident.hostAddress}}]\nntpdc -n -c monlist [{{incident.hostAddress}}]\n</code></pre>\n\n</div>',
        'To address the <strong><em>NTP readvar</em></strong> issue, we recommend:\n\n\n<div class = \"destacated\">\n\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">Disable</a>\n<code>NTP readvar</code> queries.\n\n</div>\n\nTo address the <strong><em>NTP monlist</em></strong> issue, we recommend:\n\n\n<div class = \"destacated\">\n\nVersions of <code>ntpd</code> previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.\nIf upgrading is not possible, as an alternative disable <code>monlist</code>.\n\n<a href=\"http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm\">More</a>\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">Information</a>\nabout how to disable <code>monlist</code>.\n\n\n</div>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_ntp-es', 'dos_ntp', 'es',
        'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio NTP (UDP 123).',
        NULL,
        'Probablemente su servidor responde a comandos del tipo <strong><em>NTP readvar</em></strong>  y/o a comandos <strong><em>NTP monlist</em></strong>.\nPara testear manualmente si el servicio responde a este tipo de consultas puede utilizar los respectivos comandos:\n\n<div class=\"destacated\">\n\n<pre><code>ntpq -c readvar [{{incident.hostAddress}}]\nntpdc -n -c monlist [{{incident.hostAddress}}]\n</code></pre>\n\n</div>',
        'Para el problema <strong><em>NTP readvar</em></strong>, se recomienda:\n\n<div class=\"destacated\">\n\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">Deshabilitar</a>\nlas consultas <code>NTP readvar</code>.\n\n</div>\n\nPara el problema <strong><em>NTP monlist</em></strong>, se recomienda:\n\n<div class=\"destacated\">\n\nLas versiones de <code>ntpd</code> anteriores a la 4.2.7 son vulnerables por\ndefecto. Por lo tanto, lo más simple es actualizar a la última versión.\n\nEn caso de que actualizar no sea una opción, como alternativa se puede\noptar por deshabilitar la funcionalidad <code>monlist</code>.\n\n<a href=\"http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm\">Más</a>\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">información</a>\nsobre cómo deshabilitar <code>monlist</code>.\n\n\n</div>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_snmp-en', 'dos_snmp', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>SNMP service</strong> (UDP port 161).',
        NULL,
        'The verification can be achieved analyzing the existing network traffic and observing a mayor UDP traffic consumption corresponding to spoofed SNMP queries received.',
        'We recommend:\n\n* Users should be allowed and encouraged to disable SNMP.\n* End-user devices should not be configured with SNMP on by default.\n* End-user devices should not be routinely configured with the “public” SNMP community string.\n* Establish firewall rules to filter unauthorized queries.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('dos_snmp-es', 'dos_snmp', 'es',
        'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio SNMP (UDP 161).',
        NULL,
        'Mediante el monitoreo de red debería observar grandes cantidades de tráfico UDP correspondientes a consultas SNMP spoofeadas recibidas.',
        'Se recomienda:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>\n<li><p>No usar la \"comunidad\" por defecto.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('drupal_remote_code_execution-en', 'drupal_remote_code_execution', 'en',
        'Hemos detectado que el host {{incident.hostAddress}} tiene una version de Drupal insegura. Se trata de una vulnerabilidad que permite ejecutar código remoto arbitrario sin autentificación previa debido a un problema que afecta a múltiples instancias con configuraciones predeterminadas en el núcleo de Drupal versión 6.x 7.x 8.x. .\nSe debe actualizar inmediatamente a una versión de Drupal segura.',
        'La vulnerabilidad permite a un atacante efectuar varios vectores de ataque con el fin de tomar el control de un sitio Web Drupal por completo.',
        'https://github.com/pimps/CVE-2018-7600 (validar vulnerabilidad)',
        'Se debe actualizar inmediatamente a una versión de Drupal segura.',
        'https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2018-7600', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('drupal_remote_code_execution-es', 'drupal_remote_code_execution', 'es',
        'Hemos detectado que el host  {{incident.hostAddress}} tiene una version de Drupal insegura.\n\nSe trata de una vulnerabilidad que permite ejecutar código remoto arbitrario sin autentificación previa debido a un problema que afecta a múltiples instancias con configuraciones predeterminadas en el núcleo de Drupal versión 6.x 7.x 8.x. .',
        'La vulnerabilidad permite a un atacante efectuar varios vectores de ataque con el fin de tomar el control de un sitio Web Drupal por completo.',
        'https://github.com/pimps/CVE-2018-7600 (validar vulnerabilidad)',
        'Se debe actualizar inmediatamente a una versión de Drupal segura.',
        'https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2018-7600', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('heartbleed-en', 'heartbleed', 'en',
        'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} has possible been attacked trough the OpenSSL vulnerability, known as \"<a href=\"http://heartbleed.com/\">Heartbleed</a>\".',
        'This vulnerability allows an attacker to read part of the memory of a client or server, possibly compromising sensible data.',
        'To verify the vulnerability, access the following site and follow the instructions\n\n<div class = \"destacated\">\n\n<pre><code>https://filippo.io/Heartbleed/\n</code></pre>\n\n</div>',
        'We recommend an immediate  upgrade of the OpenSSL library on the compromised host, and reboot all the services linked to the library.\nThe SSL certificate on the host could have been compromised, therefore we recommend generating a new one.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.openssl.org/news/secadv_20140407.txt\">https://www.openssl.org/news/secadv_20140407.txt</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('heartbleed-es', 'heartbleed', 'es',
        'Se detectó que el servidor {{incident.hostAddress}} posiblemente ha sido atacado mediante la\nvulnerabilidad de OpenSSL conocida como\n\"<a href=\"http://heartbleed.com/\">Heartbleed</a>\".',
        'Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o\nun cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de\nun servidor.',
        'Para comprobar que el servicio es vulnerable, acceda al siguiente sitio\nweb y siga las instrucciones. \n\n<div class=\"destacated\">\n\n<pre><code>https://filippo.io/Heartbleed/\n</code></pre>\n\n</div>',
        'Se recomienda actualizar de forma inmediata la librería OpenSSL del\nservidor y reiniciar los servicios que hagan uso de ésta. La vulnerabilidad\n\"Heartbleed\" permite leer fragmentos de la memoria del servicio\nvulnerable. Por este motivo, es posible que el certificado SSL haya sido\ncomprometido y por lo tanto se recomienda regenerarlo.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.openssl.org/news/secadv_20140407.txt\">https://www.openssl.org/news/secadv_20140407.txt</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('information_leakage-en', 'information_leakage', 'en', 'Information leakage',
        'Information leakage happens whenever a system that is designed to be closed to an eavesdropper reveals some information to unauthorized parties nonetheless. For example username and password exposed.',
        'Check evidence',
        '* Invalidate data exposed, for example force users to change credenetials.\n* Check in the logs if for the compromised data had been used.\n* Ask the publisher to remove the leakage information',
        '* Check for compromised data in: https://haveibeenpwned.com/', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('information_leakage-es', 'information_leakage', 'es', 'Fuga de Información',
        'Pueden verse comprometidas datos sensibles del usuario. Un ejemplo son las credenciales de usuario (username y password) que apliquen a otros sistemas ante una fuga de información.',
        'Revisar la evidencia que se adjunta.',
        '* Invalidar los datos relacionados a la fuga de datos. Por ejemplo forzando el cambio de contraseña\n* Revisar los accesos realizados con los datos\n* Solicitar al que esta publicando los datos que remueva la publicación',
        'Puede chequear adicionalmente: https://haveibeenpwned.com/', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40',
        NULL, NULL),
       ('malware-en', 'malware', 'en',
        'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} is currently infected with malware.',
        'Being the host infected, we can list the following consequences:\n\n<ul>\n<li><p>Excessive consumption of bandwidth by the host.</p></li>\n<li><p>Compromising other hosts.</p></li>\n<li><p>Compromising user information.</p></li>\n<li><p>Forming part of a BotNet.</p></li>\n</ul>',
        NULL, 'We recommend to filter the network traffic until the problem is solved.', NULL, 1, '2018-11-02 14:49:40',
        '2018-11-02 14:49:40', NULL, NULL),
       ('malware-es', 'malware', 'es',
        'Nos comunicamos con Ud. porque porque hemos sido informados que el host {{incident.hostAddress}} se encuentra infectado con un malware.',
        'Encontrándose infectado el equipo existen diversas consecuencias, entre las que podemos listar:\n\n<ul>\n<li><p>Consumo excesivo del ancho de banda por parte del host.</p></li>\n<li><p>Compromiso de otros equipos.</p></li>\n<li><p>Compromiso de información propia de los usuarios.</p></li>\n<li><p>Ejecute órdenes de una botnet.</p></li>\n</ul>',
        NULL, 'Se recomienda el filtrado del tráfico hasta que el problema sea resuelto.', NULL, 1,
        '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_chargen-es', 'open_chargen', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Chargen abierto y accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://en.wikipedia.org/wiki/Character_Generator_Protocol\">https://en.wikipedia.org/wiki/Character_Generator_Protocol</a></p></li>\n<li><p><a href=\"https://kb.iweb.com/hc/en-us/articles/230268088-Guide-to-Chargen-Amplification-Issues\">https://kb.iweb.com/hc/en-us/articles/230268088-Guide-to-Chargen-Amplification-Issues</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_dns-en', 'open_dns', 'en',
        'We would like to inform you that we have been notified that the <strong>host/servidor</strong> {{incident.hostAddress}} provides insecure <strong>DNS</strong> services. The service  <a href=\"https://www.us-cert.gov/ncas/alerts/TA13-088A\">responds to recursive queries</a> originated outside your network.',
        'The <em>host</em> under your administration could be used to perform <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplification</a> attacks. This could allow attacks such as:\n\n<ul>\n<li><p>Dos (Denial of service)</p></li>\n<li><p>DDOS (Distributed denial of service)</p></li>\n</ul>\n\nAdditionally , the host could be exposed to DNS cache poisoning or <strong>Pharming</strong>..',
        'Use the following command:\n\n<div class = \"destacated\">\n\n<pre><code>dig +short test.openresolver.com TXT @{{incident.hostAddress}}\n</code></pre>\n\n</div>\n\nor use the following web page:\n\n<div class = \"destacated\">\n\n<pre><code>http://openresolver.com/?ip={{incident.hostAddress}}\n</code></pre>\n\n</div>',
        'Disable recursive answers to queries that does not originate from networks under your administration.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA13-088A\">https://www.us-cert.gov/ncas/alerts/TA13-088A</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_dns-es', 'open_dns', 'es',
        'Lo contactamos porque hemos sido informados que el <strong>host/servidor</strong> {{incident.hostAddress}} brinda servicios de DNS de manera insegura. \nEn particular, la configuración de dicho servicio \n<a href=\"https://www.us-cert.gov/ncas/alerts/TA13-088A\">responde consultas recursivas</a> realizadas desde fuera de la red de la UNLP.',
        'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de\n<a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplificación</a>. Esto\npermitiría realizar ataques a terceros de tipo:\n\n<ul>\n<li><p>DoS (Denegación de servicio)</p></li>\n<li><p>DDoS (Denegación de servicio distribuida)</p></li>\n</ul>\n\nAdicionalmente, el servidor podría verse expuesto a ataques de\nenvenenamiento de caché de DNS o <strong>Pharming</strong>.',
        'Utilizando el comando:\n\n<div class=\"destacated\">\n\n<pre><code>dig +short test.openresolver.com TXT @{{incident.hostAddress}}\n</code></pre>\n\n</div>\n\no vía web a través de la siguiente página:\n\n<div class=\"destacated\">\n\n<pre><code>http://openresolver.com/?ip={{incident.hostAddress}}\n</code></pre>\n\n</div>',
        'Se recomienda desactivar la respuesta recursiva a consultas que no\nprovienen de redes bajo su administración.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA13-088A\">https://www.us-cert.gov/ncas/alerts/TA13-088A</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_elasticsearch-es', 'open_elasticsearch', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Elasticseach abierto y accesible desde Internet.',
        'Por defecto, este servicio no brinda ningun tipo de autenticación, lo que significa que cualquier entidad podria tener acceso instantaneo a sus datos.',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.elastic.co/blog/found-elasticsearch-security\">https://www.elastic.co/blog/found-elasticsearch-security</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ipmi-en', 'open_ipmi', 'en',
        'We would like to inform you that we have been informed that web page hosted with the IP {{incident.hostAddress}} has the Intelligent <strong>Intelligent Platform Management Interface</strong> (IPMI) service, accessible from the Internet.',
        'The host under your administration could be controlled remotely. IPMI provides low level access to the device possibly allowing a system reboot, installation of unknown software, access restricted information, etc.',
        NULL,
        'We recommend:\n\n<ul>\n<li><p>Establish firewall rules and filter unauthorized access to the service.</p></li>\n<li><p>In case the service is not being used, disable it.</p></li>\n</ul>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p>[US-CERT alert TA13-207A] (https://www.us-cert.gov/ncas/alerts/TA13-207A)</p></li>\n<li><p>[Dan Farmer on IPMI security issues] (http://fish2.com/ipmi/)</p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ipmi-es', 'open_ipmi', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio Intelligent Platform Management Interface (IPMI) accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente. IPMI provee acceso a bajo nivel al dispositivo, pudiendo permitir reiniciar el sistema, instalar un nuevo sistema operativo, acceder a información alojada en el sistema, etc.',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>\n<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p>[US-CERT alert TA13-207A] (https://www.us-cert.gov/ncas/alerts/TA13-207A)</p></li>\n<li><p>[Dan Farmer on IPMI security issues] (http://fish2.com/ipmi/)</p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_isakmp-es', 'open_isakmp', 'es',
        'Lo contactamos porque hemos sido informados que el dispositivo {{incident.hostAddress}} contiene una vulnerabilidad en el procesamiento de paquetes IKEv1.',
        'Esta vulnerabilidad podría permitir a un atacante remoto no autentiado recuperar el contenido de la memoria, lo cual podría conducir a la divulgación de información confidencial.',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Actualizar el firmware del dispositivo.</p></li>\n<li><p>Deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160916-ikev1\">https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160916-ikev1</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ldap-en', 'open_ldap', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Lightweight Directory Access Protocol</strong> (LDAP) service, accessible from the Internet.',
        'The <em>host</em> under your administration could be compromising sensitive information.', NULL,
        '<ul>\n<li><p>Establish firewall rules to filter unauthorized queries.</p></li>\n<li><p>Use Transport Layer Security (TLS) encryption in the communication service. (IN o OVER - DAniela)</p></li>\n<li><p>Deny anonymous bind type connections.</p></li>\n<li><p><a href=\"https://www.sans.org/reading-room/whitepapers/directories/securely-implementing-ldap-109\">Additional information</a>.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ldap-es', 'open_ldap', 'es',
        'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} tiene el servicio LDAP accesible desde Internet.',
        'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible.', NULL,
        '<ul>\n<li><p>Establecer reglas de firewall para permitir consultas sólo desde las redes autorizadas.</p></li>\n<li><p>Utilizar TLS en la comunicación con el servicio.</p></li>\n<li><p>No permitir conexiones de manera anónima (Anonymous BIND).</p></li>\n<li><p><a href=\"https://www.sans.org/reading-room/whitepapers/directories/securely-implementing-ldap-109\">Información adicional</a>.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_mdns-es', 'open_mdns', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio mDNS (Multicast DNS) abierto y accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.trustwave.com/Resources/SpiderLabs-Blog/mDNS---Telling-the-world-about-you-(and-your-device)/\">https://www.trustwave.com/Resources/SpiderLabs-Blog/mDNS---Telling-the-world-about-you-(and-your-device)/</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_memcached-en', 'open_memcached', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Memcached</strong> service, accessible from the Internet.',
        'The <em>host</em> under your administration could be used to perform <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplification</a> attacks to third party\'s, like:\n\n<div class = \"destacated\">\n<ul>\n<li><p>Denial of Service attacks (DOS, DDOS).</p></li>\n</ul>\n</div>\n\nAlso, due to the service not providing an authentication mechanism, any third party accessing the Memcache service would have total over the stored information. The following items could be compromised:\n\n<div class = \"destacated\">\n<ul>\n<li><p>Access to sensitive information.</p></li>\n<li><p>Perform a defacement\'s attack to the web server.</p></li>\n<li><p>Perform a Denial of Service attack (DOS) to the server.</p></li>\n</ul>\n</div>',
        'To verify that the service is currently open, use the <code>telnet</code> command in the following way:\n<div class = \"destacated\">\n<pre><code>telnet {{incident.hostAddress}} 11211\nstats items\n</code></pre>\n</div>',
        '<ul>\n<li><p>Establish firewall rules to filter unauthorized queries.</p></li>\n</ul>',
        '<div class = \"destacated\">\n<ul>\n<li><p>memcached.org</p></li>\n<li><p>http://infiltrate.tumblr.com/post/38565427/hacking-memcache</p></li>\n<li><p>http://es.wikipedia.org/wiki/Defacement</p></li>\n</ul>\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_memcached-es', 'open_memcached', 'es',
        'Lo contactamos porque hemos sido informados que el host con {{incident.hostAddress}} contiene\nuna instalación de Memcached accesible desde Internet.',
        'Debido a que este servicio no provee autenticación, cualquier entidad que acceda a la instancia de Memcache, tendrá control total sobre los objetos almacenados, con lo que se podría:\n\n<div class = \"destacated\">\n<ul>\n<li><p>Acceder a la información almacenada</p></li>\n<li><p>Realizar el defacement del servidor WEB</p></li>\n<li><p>Realizar una denegación de servicio sobre el servidor</p></li>\n</ul>\n</div>',
        'Para comprobar que el servicio está abierto, utilice el comando <code>telnet</code> del siguiente modo:\n\n<div class=\"destacated\">\n\n<pre><code>telnet {{incident.hostAddress}} 11211\nstats items\n</code></pre>\n\n</div>',
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Establecer reglas de firewall para denegar las consultas desde hosts/redes no autorizadas.</p></li>\n</ul>',
        '<div class = \"destacated\">\n<ul>\n<li><p>memcached.org</p></li>\n<li><p>http://infiltrate.tumblr.com/post/38565427/hacking-memcache</p></li>\n<li><p>http://es.wikipedia.org/wiki/Defacement</p></li>\n</ul>\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_mongodb-en', 'open_mongodb', 'en',
        'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} has a database (MongoDB) with unrestricted access from the Internet.',
        'The <em>host</em> under your administration could be compromising sensitive information.',
        'To manually verify the connection to the service, use the following command:\n\n<div class = \"destacated\">\n\n<pre><code>mongo {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '* Establish firewall rules to filter unauthorized access.\n* Enable Access Control and Enforce Authentication\n* Configure Role-Based Access Control\n* Run MongoDB with Secure Configuration Options\n* Enable Secure Sockets Layer (SSL) to encrypt communications.\n* Use the loopback address to establish connections to limit exposure.\n* Modify the default port.\n* Ensure that the HTTP status interface, the REST API, and the JSON API are all disabled in production environments to prevent potential data exposure and vulnerability to attackers.\n\n\n\n\n\n\n\n<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://docs.mongodb.com/manual/administration/security-checklist/\">Security checklist</a></p></li>\n<li><p><a href=\"https://docs.mongodb.com/manual/core/security-mongodb-configuration/#bind-ip\">Security configuration</a></p></li>\n</ul>\n\n</div>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://docs.mongodb.com/manual/administration/security-checklist/\">Security checklist</a></p></li>\n<li><p><a href=\"https://docs.mongodb.com/manual/core/security-mongodb-configuration/#bind-ip\">Security configuration</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_mongodb-es', 'open_mongodb', 'es',
        'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} tiene una base de datos MongoDB NoSQL accesible sin restricciones desde Internet.',
        'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible, comprometiendo sistemas que corren él.',
        'Para testear manualmente la conexión al servicio puede utilizar el comando:\n\n<div class=\"destacated\">\n\n<pre><code>mongo {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '<ul>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/security-network/#firewalls\">Agregar</a>\nfirewalls para restringir accesos no autorizados.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/authorization/\">Habilitar</a>\nla autenticación de accesos.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/security-network/#nohttpinterface\">Habilitar</a> el servicio con SSL.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/reference/security/#userAdminAnyDatabase\">Habilitar</a> la autorización de acciones basada en roles.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/security-network/#bind-ip\">Configurar</a>\nlas conexiones en la interfaz de loopback.</p></li>\n<li><p>Alternativamente, se puede <a href=\"http://docs.mongodb.org/manual/core/security-network/#port\">cambiar</a> el puerto de conexión.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/security-network/#nohttpinterface\">Deshabilitar</a> la interfaz http de estado.</p></li>\n<li><p><a href=\"http://docs.mongodb.org/manual/core/security-network/#rest\">Deshabilitar</a>\nla interfaz REST.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_mssql-en', 'open_mssql', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Microsoft SQL Server</strong> service, accessible from the Internet.',
        'The <em>host</em> under your administration could be compromising sensitive information, also could victim of UDP amplification performing Denial of Service (DOS,DDOS) attacks.',
        NULL, 'Establish firewall rules to filter unauthorized access.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n<li><p><a href=\"https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html\">https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html</a></p></li>\n<li><p><a href=\"http://es.wikipedia.org/wiki/SQL_Slammer\">http://es.wikipedia.org/wiki/SQL_Slammer</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_mssql-es', 'open_mssql', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio de resolución de Microsoft SQL Server abierto desde Internet.',
        'El host bajo su administración podría ser usado para revelar información como así también en ataques de amplificación UDP que provoquen denegaciones de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda establecer reglas de firewall para permitir solamente las conexiones al servicio solo desde los servidores autorizados.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n<li><p><a href=\"https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html\">https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html</a></p></li>\n<li><p><a href=\"http://es.wikipedia.org/wiki/SQL_Slammer\">http://es.wikipedia.org/wiki/SQL_Slammer</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_netbios-en', 'open_netbios', 'en',
        'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Network Basic Input/Output System</strong> (NETBIOS) service, accessible from the Internet.',
        'The <em>host</em> under your administration could be used to perform:\n\n<ul>\n<li><p>Denial of Service attacks (DOS, DDOS).</p></li>\n<li><p>Gather information shared within the host.</p></li>\n<li><p>Perform brute force attacks.</p></li>\n<li><p>Malware distribution.</p></li>\n<li><p>Store stolen information.</p></li>\n</ul>',
        NULL,
        'We recommend:\n\n<ul>\n<li><p>Do not use the service over the TCP/IP protocol.</p></li>\n<li><p>Establish firewall rules to filter unauthorized queries.</p></li>\n<li><p>Establish, if possible, access control.</p></li>\n</ul>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_netbios-es', 'open_netbios', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio NETBIOS abierto desde Internet.',
        'El host bajo su administración podría ser usado para:\n\n<ul>\n<li><p>Ataques de amplificación que causen denegación de servicio (DOS, DDOS)</p></li>\n<li><p>Recopilar información compartida en dicho host</p></li>\n<li><p>Realizar ataques de fuerza bruta en caso que el servicio solicite contraseña</p></li>\n<li><p>Distribución de malware</p></li>\n<li><p>Almacenar información robada</p></li>\n</ul>',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>No correr el servicio sobre TCP/IP.</p></li>\n<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ntp_monitor-en', 'open_ntp_monitor', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is providing insecure <strong>Network Time Protocol</strong> (NTP) service by responding to <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-013A\">NTP monlist</a> commands.',
        'The <em>host</em> under your administration could be used to perform <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplification</a> attacks to third party\'s, like:\n\n<ul>\n<li><p>Denial of Service attacks (DOS, DDOS).</p></li>\n</ul>',
        'To manually verify if the service is vulnerable, use the following command:\n\n\n<div class = \"destacated\">\n\n<pre><code>ntpdc -n -c monlist {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        'Versions of  <code>ntpd</code> previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.\nIf upgrading is not possible, as an alternative disable <code>monlist</code>.',
        '<a href=\"http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm\">More</a>\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">information</a>\nabout how to disable <code>monlist</code>.',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ntp_monitor-es', 'open_ntp_monitor', 'es',
        'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} brinda\nel servicio de NTP de manera insegura. En particular, el servicio estaría\nrespondiendo a comandos del tipo\n<a href=\"https://www.us-cert.gov/ncas/alerts/TA14-013A\">NTP monlist</a>.',
        'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de\n<a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplificación</a>. Esto\npermitiría realizar ataques a terceros de tipo:\n\n<ul>\n<li><p>DoS (Denegación de servicio)</p></li>\n<li><p>DDoS (Denegación de servicio distribuida)</p></li>\n</ul>',
        'Para testear manualmente si el servicio es vulnerable a esta falla, puede\nutilizar el comando:\n\n<div class=\"destacated\">\n\n<pre><code>ntpdc -n -c monlist {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        'Las versiones de <code>ntpd</code> anteriores a la 4.2.7 son vulnerables por\ndefecto. Por lo tanto, lo más simple es actualizar a la última versión.\n\nEn caso de que actualizar no sea una opción, como alternativa se puede\noptar por deshabilitar la funcionalidad <code>monlist</code>.',
        '<a href=\"http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm\">Más</a>\n<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">información</a>\nsobre cómo deshabilitar <code>monlist</code>.',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ntp_version-en', 'open_ntp_version', 'en',
        'We would like to inform you that we have been notified that the <em>host</em>  {{incident.hostAddress}} is providing insecure <strong>Network Time Protocol</strong> (NTP) service by responding to <code>NTP readvar</code> commands.',
        '<p class=\"lead\">Problemas derivados</p>\n\nThe <em>host</em>  under your administration could be used to perform <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplification</a> attacks to third party\'s, like:\n\n<ul>\n<li><p>Denial of Service attacks (DOS, DDOS).</p></li>\n</ul>',
        'To manually verify if the service is vulnerable, use the following command:\n\n\n<div class = \"destacated\">\n\n<pre><code>ntpq -c readvar {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">Disable</a>\n<code>NTP readvar</code> queries.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ntp_version-es', 'open_ntp_version', 'es',
        'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} brinda\nel servicio de NTP de manera insegura. En particular, el servicio estaría\nrespondiendo a comandos del tipo <code>NTP readvar</code>.',
        'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de\n<a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplificación</a>. Esto\npermitiría realizar ataques a terceros de tipo:\n\n<ul>\n<li><p>DoS (Denegación de servicio)</p></li>\n<li><p>DDoS (Denegación de servicio distribuida)</p></li>\n</ul>',
        'Para testear manualmente si el servicio es vulnerable a esta falla puede\nutilizar el comando:\n\n<div class=\"destacated\">\n\n<pre><code>ntpq -c readvar {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '<a href=\"http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html\">Deshabilitar</a>\nlas consultas <code>NTP readvar</code>.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_portmap-en', 'open_portmap', 'en',
        'We would like to inform you that we have been notified that the <em>host/server</em>  {{incident.hostAddress}} has the <strong>Portmap</strong> service, accessible from the Internet.',
        'The <em>host</em> under your administration could be used to perform <a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplification</a> attacks to third party\'s, like:\n\n<ul>\n<li><p>Denial of Service attacks (DOS, DDOS).</p></li>\n</ul>\n\nAdditionally, the <strong>host/servidor</strong> could expose other misconfigured services, such as NFS shared folders.',
        'To manually verify if the service is vulnerable, use the following command:\n\n<div class = \"destacated\">\n\n<pre><code>rpcinfo -T udp -p {{incident.hostAddress}}\n</code></pre>\n\n</div>\n\nView the NFS shared folders using the command:\n\n<div class = \"destacated\">\n\n<pre><code>showmount -e {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '<ul>\n<li><p>We recommend filtering unauthorized access to Portmap service, or disabling the service.</p></li>\n<li><p>If NFS shared folders are being used, use proper filtering methods, or deactivate the feature.</p></li>\n</ul>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132\">https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132</a></p></li>\n<li><p><a href=\"http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/\">http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_portmap-es', 'open_portmap', 'es',
        'Lo contactamos porque hemos sido informados que el <strong>host/servidor</strong> {{incident.hostAddress}} brinda el servicio portmap accesible desde Internet.',
        'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de\n<a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">amplificación</a>. Esto \npermitiría realizar ataques a terceros de tipo:\n\n<ul>\n<li><p>DoS (Denegación de servicio)</p></li>\n<li><p>DDoS (Denegación de servicio distribuida)</p></li>\n</ul>\n\nAdicionalmente, el servidor podría exponer otros servicios mal configurados como puede ser carpetas compartidas NFS.',
        'Utilizando el comando:\n\n<div class=\"destacated\">\n\n<pre><code>rpcinfo -T udp -p {{incident.hostAddress}}\n</code></pre>\n\n</div>\n\nY ver carpetas compartidas NFS utilizando el comando:\n\n<div class=\"destacated\">\n\n<pre><code>showmount -e {{incident.hostAddress}}\n</code></pre>\n\n</div>',
        '<ul>\n<li><p>Se recomienda desactivar o filtrar el servicio Portmap para que sólo sea accesible desde las redes que usted necesite.</p></li>\n<li><p>En caso de usar carpetas compartidas NFS evaluar la necesidad. Desactivar, configurar o filtrar adecuadamente.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132\">https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132</a></p></li>\n<li><p><a href=\"http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/\">http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_qotd-es', 'open_qotd', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio QOTD (Quote of the Day) abierto y accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://kb.iweb.com/hc/en-us/articles/230268148-Guide-to-QOTD-Amplification-Issues\">https://kb.iweb.com/hc/en-us/articles/230268148-Guide-to-QOTD-Amplification-Issues</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_rdp-es', 'open_rdp', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio RDP (Remote Desktop Protocol) accesible desde Internet.',
        'Este servicio puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>\n<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://en.wikipedia.org/wiki/Remote_Desktop_Protocol\">https://en.wikipedia.org/wiki/Remote_Desktop_Protocol</a></p></li>\n<li><p><a href=\"https://zeltser.com/remote-desktop-security-risks/\">https://zeltser.com/remote-desktop-security-risks/</a></p></li>\n<li><p><a href=\"https://www.howtogeek.com/175087/how-to-enable-and-secure-remote-desktop-on-windows/\">https://www.howtogeek.com/175087/how-to-enable-and-secure-remote-desktop-on-windows/</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_redis-es', 'open_redis', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Redis abierto y accesible desde Internet.',
        'Por defecto, este servicio no brinda ningun tipo de autenticación, lo que significa que cualquier entidad podria tener acceso instantaneo a sus datos.',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://redis.io/topics/security\">https://redis.io/topics/security</a></p></li>\n<li><p><a href=\"http://antirez.com/news/96\">http://antirez.com/news/96</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_smb-es', 'open_smb', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio SMB (Server Message Block) accesible desde Internet.',
        'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>\n<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://redmondmag.com/articles/2017/02/03/smb-security-flaw-in-windows-systems.aspx\">https://redmondmag.com/articles/2017/02/03/smb-security-flaw-in-windows-systems.aspx</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/current-activity/2017/01/16/SMB-Security-Best-Practices\">https://www.us-cert.gov/ncas/current-activity/2017/01/16/SMB-Security-Best-Practices</a></p></li>\n<li><p><a href=\"https://technet.microsoft.com/en-us/library/dn551363(v=ws.11).aspx\">https://technet.microsoft.com/en-us/library/dn551363(v=ws.11).aspx</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_snmp-en', 'open_snmp', 'en',
        'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Simple Network Management Protocol</strong> (SNMP - UDP port 161) service, accessible from the Internet.',
        'The <em>host</em> under your administration could be used to perform attacks, such as:\n\n<ul>\n<li><p>Obtain unauthorized remote access and information.</p></li>\n<li><p>Brute force attacks.</p></li>\n</ul>',
        NULL,
        'We recommend:\n\n* Users should be allowed and encouraged to disable SNMP.\n* End-user devices should not be configured with SNMP on by default.\n* End-user devices should not be routinely configured with the “public” SNMP community string.\n* Establish firewall rules to filter unauthorized queries.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_snmp-es', 'open_snmp', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone de un servicio SNMP (UDP 161) abierto a redes ajenas de la UNLP.',
        'El host bajo su administración podría llegar a ser usado en ataques de:\n\n<ul>\n<li><p>Obtención de información de dispositivos de red en forma remota no autorizada.</p></li>\n<li><p>Configuración de dispositivos de red en forma remota no autorizada.</p></li>\n<li><p>Ataques de fuerza bruta.</p></li>\n</ul>',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>\n<li><p>No usar la comunidad por defecto.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ssdp-en', 'open_ssdp', 'en',
        'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Simple Service Discovery Protocol</strong> (SSDP) service, accessible from the Internet.',
        'The host under your administration could be used to perform attacks, such as:\n* Denial of Service attacks (DOS, DDOS).',
        NULL,
        'We recommend:\n\n<ul>\n<li><p>Disable the service.</p></li>\n<li><p>Establish firewall rules to filter unauthorized queries.</p></li>\n</ul>',
        '<div class = \"destacated\">\n\n<ul>\n<li><p>[http://es.wikipedia.org/wiki/SSDP] (http://es.wikipedia.org/wiki/SSDP)</p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_ssdp-es', 'open_ssdp', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio SSDP (Simple Service Discovery Protocol) abierto y accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p>[http://es.wikipedia.org/wiki/SSDP] (http://es.wikipedia.org/wiki/SSDP)</p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_telnet-es', 'open_telnet', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio Telnet accesible desde Internet.',
        'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>\n<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://technet.microsoft.com/en-us/library/cc755017%28v=ws.10%29.aspx?f=255&amp;MSPPError=-2147217396\">https://technet.microsoft.com/en-us/library/cc755017%28v=ws.10%29.aspx?f=255&amp;MSPPError=-2147217396</a></p></li>\n<li><p><a href=\"https://interwork.com/qa-how-to-eliminate-the-security-risks-associated-with-telnet-ftp/\">https://interwork.com/qa-how-to-eliminate-the-security-risks-associated-with-telnet-ftp/</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_tftp-es', 'open_tftp', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio TFTP (Trivial file transfer Protocol) abierto y accesible desde Internet.',
        'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).',
        NULL,
        'Se recomienda alguna de las siguientes:\n\n<ul>\n<li><p>Deshabilitar el servicio.</p></li>\n<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://blogs.akamai.com/2016/06/new-ddos-reflectionamplification-method-exploits-tftp.html\">https://blogs.akamai.com/2016/06/new-ddos-reflectionamplification-method-exploits-tftp.html</a></p></li>\n<li><p><a href=\"https://www.us-cert.gov/ncas/alerts/TA14-017A\">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('open_vnc-es', 'open_vnc', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio VNC (Virtual Network Computer/Computing) accesible desde Internet.',
        'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.',
        NULL,
        'Se recomienda:\n\n<ul>\n<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>\n<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>\n</ul>',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://security.stackexchange.com/questions/124958/how-do-i-assess-and-mitigate-the-security-risks-of-a-vnc-tool\">https://security.stackexchange.com/questions/124958/how-do-i-assess-and-mitigate-the-security-risks-of-a-vnc-tool</a></p></li>\n<li><p><a href=\"http://www.mit.edu/~avp/lqcd/ssh-vnc.html\">http://www.mit.edu/~avp/lqcd/ssh-vnc.html</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('phishing_mail-en', 'phishing_mail', 'en',
        'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to send emails containing Phishing.',
        'If this issue is not addressed, the <em>host</em> could be added in public lists of compromised hosts, thus emails from this host will be filtered.',
        'It is likely that the Phishing emails are being sent by a compromised email account.\nAnalyzing the email header, the authenticated user being used to send the emails can be identified (See attached file).',
        '<ul>\n<li><p>Modify the compromised user credentials.</p></li>\n<li><p>Increase awareness related to Phishing attacks in the users.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('phishing_mail-es', 'phishing_mail', 'es',
        'Nos notificaron que el host/servidor {{incident.hostAddress}} está enviando correo con contenido de Phishing.',
        'De no solucionar el problema, el host/servidor puede ser introducido en listas públicas de servidores comprometidos que pueden causar que dicho host/servidor no pueda enviar correos a otros servidores.',
        'Es probable que el Phishing se envíe utilizando una cuenta de correo comprometida.\nAnalizando la cabecera del email de spam adjunto, puede distinguirse el usuario autenticado que realizó el envío del mensaje.',
        'Se recomienda cambiar las credenciales de los usuarios afectados e instruir a los mismos sobre ataques de phishing, probablemente utilizado para el robo de las credenciales del usuario.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('phishing_web-en', 'phishing_web', 'en',
        'We would like to inform you that we have been notified that the <em>server</em> {{incident.hostAddress}} is currently hosting a web service being used to perform Phising attacks.',
        'If this issue is not addressed, the <em>server</em> could be added in public lists of compromised hosts, forcing the web browsers to show security alerts when accessing web pages hosted in the server.',
        'Verify the information in the attached file.',
        'We recommend removing the web content being used to perform the phising attack and request a forensic analysis on the server, as to evaluate what has been compromised.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://support.google.com/chrome/answer/99020?hl=es-419\">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('phishing_web-es', 'phishing_web', 'es',
        'Nos notificaron que el servidor {{incident.hostAddress}} está alojando un sitio web utilizado para ataques de Phishing.',
        'Este problema puede provocar que su servidor sea introducido en listas públicas de servidores comprometidos pudiendo los navegadores disparar alertas de seguridad a los usuarios cuando accedan a cualquier página web alojada en dicho servidor.',
        'Verificar la información enviada en el contenido adjunto.',
        'Se recomienda dar de baja el contenido WEB utilizado para el ataque de phishing y solicitar a CERTUNLP un análisis forense del servidor para \ndeterminar la modalidad utilizada por el atacante y el nivel de compromiso del servidor.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://support.google.com/chrome/answer/99020?hl=es-419\">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('poodle-en', 'poodle', 'en',
        'We would like to inform you that we have been notified that the <em>server</em> {{incident.hostAddress}} is currently vulnerable to Padding Oracle On Downgraded Legacy Encryption (POODLE) attacks.',
        'POODLE is a man-in-the-middle exploit which takes advantage of Internet and security software clients fallback to SSL 3.0. If attackers successfully exploit this vulnerability, sensitive information could be obtained by attackers, compromising confidentiality.',
        'Access the following web page to verify that the services currently provided by your host are in fact, vulnerable to POODLE:\n\n\n<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.poodlescan.com/\">https://www.poodlescan.com/</a></p></li>\n</ul>\n\n</div>',
        'We recommend avoiding the use of the SSLv2 and SSLv3 libraries, use TLS instead.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566\">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('poodle-es', 'poodle', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} es\nvulnerable a POODLE.',
        'POODLE es una falla en SSLv3 que permite a un atacante recuperar\ninformación cifrada, ocasionando de esta forma pérdida de confidencialidad.',
        'Acceda a la siguiente página para verificar que los servicios que usted\nprovee en el host son vulnerables a POODLE:\n\n\n<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://poodletest.ntt-security.com/\">http://poodletest.ntt-security.com/</a></p></li>\n</ul>\n\n</div>',
        'Se recomienda dejar de utilizar las librerías SSLv2 y SSLv3. Como reemplazo\npuede utilizar TLS.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566\">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('rpz_botnet-es', 'rpz_botnet', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ \"BOTNET\".\n\nDicha RPZ, contiene direcciones de red conocidas que están vinculadas a infraestructuras de botnets.\n\n\n<p class=\"lead\">Consideraciones</p>\n\nSe debe tener en cuenta que si la IP informada es un servidor de mail, este reporte podría tratarse de un falso positivo. La razón de ello es que en la detección de SPAM, se evalúan URLs observadas en los correos electrónicos.\n\nPor otro lado, si la IP informada es un servidor de DNS (resolver local) el origen del problema no es el servidor sino el host que le hizo la consulta DNS reportada. En este caso, la manera de detectar el host infectado es registrando las consultas DNS.',
        'Es probable que su PC o servidor que esté intentando acceder a dominios de BOTNETs.\n\nEsto indica que la misma esté comprometido con algún tipo de malware y quiera conectarse a un servidor C&amp;C para esperar instrucciones a ejecutar (DoS, fuerza bruta, envío de spams, etc.).',
        NULL, 'Se recomienda analizar el host de la red para verificar y solucionar el problema.', NULL, 1,
        '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('rpz_dbl-es', 'rpz_dbl', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DBL”.\n\nDicha RPZ, contiene información sobre direcciones de red que son utilizadas como distribuidores de malware, sitios que almacenan malware, redirecciones maliciosas, dominios usados como botnets, servidores de C&amp;C y otras actividades maliciosas.',
        'En la mayoría de los casos puede ser un indicador de que su host está siendo utilizado para enviar spam.',
        'Si es el host es un servidor de correo o DNS, es importante que lo notifique al CeRT. Esto es para estudiar con mayor profundidad el caso y ver si se trata de un falso positivo o si realmente su servidor de correo está comprometido.\n\nSi el host no es un servidor de correo ni un DNS, es muy probable que tenga algún malware y sería útil chequear los procesos corriendo en el mísmo.',
        'Si se trata de un servidor de correo:\n\n<ul>\n<li><p>Verificar la configuración del correo o si hay una cuenta comprometida.</p></li>\n<li><p>Verificar que nuestro host no esté listado en blacklists.</p></li>\n<li><p>Mejorar la infraestructura anti-spam.</p></li>\n</ul>',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('rpz_drop-es', 'rpz_drop', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DROP”.\n\nDicha RPZ, consiste de bloques de red bogons, que fueron robados o liberados para generar spam u operaciones criminales.',
        'Es probable que su dispositivo se encuentre comprometido.',
        'Puede verificar las conexiones establecidas con el comando \"netstat\".\n\n\n<div class=\"destacated\">\n\n<ul>\n<li><p>netstat -ntulp</p></li>\n</ul>\n\n</div>\n\nTambién verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.',
        'Se recomienda aislar el host hasta verificar y solucionar el problema.', NULL, 1, '2018-11-02 14:49:40',
        '2018-11-02 14:49:40', NULL, NULL),
       ('rpz_malware_aggressive-es', 'rpz_malware_aggressive', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “MALWARE-AGGRESSIVE”.\n\nDicha RPZ, contiene direcciones de red conocidas que están vinculadas al malware, que mediante mecanismos normales de scoring no fueron agregados a otra lista, pero deberían ser incluidos por otras razones. Por la naturaleza de esta lista, es posible (aunque poco probable) que se reporten falsos positivos.',
        'Esto indica que es probable que su servidor esté comprometido.',
        'Puede verificar las conexiones establecidas con el comando \"netstat\".\n\n\n<div class=\"destacated\">\n\n<ul>\n<li><p>netstat -ntulp</p></li>\n</ul>\n\n</div>\n\nTambién verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.',
        'Se recomienda aislar el host hasta verificar y solucionar el problema.', NULL, 1, '2018-11-02 14:49:40',
        '2018-11-02 14:49:40', NULL, NULL),
       ('rpz_malware-es', 'rpz_malware', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “MALWARE”.\n\nDicha RPZ, contiene sólo información de direcciones de red asociadas con malwares. Están excluidos de esta lista fuentes de spam y phising, también dominios de redirección.',
        'Esto indica que es probable que su servidor esté comprometido.',
        'Puede verificar las conexiones establecidas con el comando \"netstat\".\n\n\n<div class=\"destacated\">\n\n<ul>\n<li><p>netstat -ntulp</p></li>\n</ul>\n\n</div>\n\nTambién verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.',
        'Se recomienda aislar el host hasta verificar y solucionar el problema.', NULL, 1, '2018-11-02 14:49:40',
        '2018-11-02 14:49:40', NULL, NULL),
       ('scan-en', 'scan', 'en',
        'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is currently performing a Scan process over other devices.',
        'Performing a Scan analysis is likely due to the host being compromised and used to gather information about other hosts inside the network, for possible future attacks. On the other hand, this generates great amount of bandwidth consumption, generating a network speed reduction.',
        'It can be verified by analyzing the existing network traffic, using tools such as:\n\n\n<div class = \"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\nor\n\n<div class = \"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'Remove the access to the network to affected host during the analysis, as to determin it\'s origin.\nIt is likely that attackers had gained privileges over the compromised host, we recommend you to request a forensic analysis on the server, as to evaluate what has been compromised.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://archive.oreilly.com/pub/h/1393\">http://archive.oreilly.com/pub/h/1393</a></p></li>\n<li><p><a href=\"http://inai.de/documents/Chaostables.pdf\">http://inai.de/documents/Chaostables.pdf</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('scan-es', 'scan', 'es',
        'Nos comunicamos con Ud. para comunicarle que el host {{incident.hostAddress}} se encuentra realizando un proceso de Scan sobre otros equipos de la UNLP y/o el exterior.',
        'La realización del proceso de Scan probablemente se deba a que el equipo se encuentre comprometido y siendo utilizado para reconocer otros equipos de la red, los cuales dependiendo del scan, serán luego atacados o no.\nPor otro lado este problema genera la circulación en la red grandes volúmenes de información que generan problemas o pérdidas velocidad en la misma.',
        'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como \n\n<div class=\"destacated\">\n\n<pre><code>tcpdump\n</code></pre>\n\n</div>\n\no \n\n<div class=\"destacated\">\n\n<pre><code>wireshark\n</code></pre>\n\n</div>',
        'Se recomienda quitar el acceso del host afectado a la red durante la realización del análisis que determine el origen del tráfico.\nHabiendo ocurrido una muy probable obtención de privilegios sobre el host por parte de atacantes, se recomienda la realización de una forensia sobre el equipo con el objetivo de determinar la vulnerabilidad que proporcionó dichos privilegios.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.hackingarticles.in/detect-nmap-scan-using-snort/\">http://www.hackingarticles.in/detect-nmap-scan-using-snort/</a></p></li>\n<li><p><a href=\"http://inai.de/documents/Chaostables.pdf\">http://inai.de/documents/Chaostables.pdf</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('shellshock-en', 'shellshock', 'en',
        'We would like to inform you that we have been detected that the <em>host</em> {{incident.hostAddress}} has possible been attacked using the known vulnerability ShellShock.',
        'This vulnerability allows an attacker to read the device memory, possibly compromising sensitive information such as private SSL keys.',
        'Due to the report possible being a false positive, we recommend to verify the existence of the vulnerability using the following commands:\n\n<div class = \"destacated\">\n\n<pre><code>env x=\'() { :;}; echo vulnerable\' bash -c \"echo this is a test\"\n</code></pre>\n\n</div>\n\nIf the execution of the previous command returns the string \"vulnerable\", is most likely that the host has been compromised.',
        'We recommend upgrading bash in an urgent manner, and perform a study to analyze possible backdoors in the compromised host.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html\">http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('shellshock-es', 'shellshock', 'es',
        'Se ha detectado que el servidor con IP {{incident.hostAddress}} posiblemente ha sido atacado mediante la vulnerabilidad conocida como ShellShock.',
        'Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o un cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de un servidor.',
        'Debido a que este reporte puede ser un falso positivo, se recomienda comprobar que el host sea realmente vulnerable a ShellShock:\n\n<div class=\"destacated\">\n\n<pre><code>env x=\'() { :;}; echo vulnerable\' bash -c \"echo esto es una prueba\"\n</code></pre>\n\n</div>\n\nSi la ejecución en bash del comando anterior imprime \"vulnerable\", entonces es probable que el host haya sido comprometido.',
        'Se recomienda actualizar bash de forma urgente y realizar un relevamiento\ncon el fin de comprobar que el host no contenga backdoors.',
        '<p class=\"lead\">Más información</p>\n\n\n<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html\">http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('spam-en', 'spam', 'en',
        'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} is possibly sending SPAM.',
        'If this issue is not addressed, the <em>host</em> could be added in blacklists, thus emails from this host will be filtered.',
        'It is likely that the Phishing emails are being sent by a compromised email account.\nAnalyzing the email header, the authenticated user being used to send the emails can be identified (See attached file).',
        '* Modify the compromised user credentials.\n* Increase awareness related to this issue among the users.', NULL,
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('spam-es', 'spam', 'es', 'Nos notificaron que el host {{incident.hostAddress}} está enviando SPAM.',
        'De no solucionar el problema, su servidor puede ser introducido en distintas blacklists que causarán que dicho servidor no pueda enviar correos a otros servidores.',
        'Es probable que el SPAM se envíe utilizando una cuenta de correo comprometida.\nAnalizando la cabecera del email de spam adjunto, puede distinguirse el usuario autenticado que realizó el envío del mensaje.',
        'Se recomienda cambiar las credenciales de los usuarios afectados e instruir a los mismos sobre los mails de phishing, ataque que probablemente haya sido utilizado para el robo de las credenciales.',
        NULL, 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('sql_injection-en', 'sql_injection', 'en',
        'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} has SQL injection vulnerabilities.',
        'The <em>host</em> under your administration could be compromising sensitive information.', NULL,
        'We recommend analyzing the database related entries that use SQL.',
        '<div class = \"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.owasp.org/index.php/SQL_Injection\">https://www.owasp.org/index.php/SQL_Injection</a></p></li>\n<li><p><a href=\"https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet\">SQL Injection Prevention Cheat Sheet</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('sql_injection-es', 'sql_injection', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene\nvulnerabilidades de SQL Injection.',
        'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible, comprometiendo sistemas que corren él.',
        NULL,
        'Se recomienda revisar la aplicacion verificando todas las entradas que esten relacionadas con la base de datos y el uso de sql.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.owasp.org/index.php/SQL_Injection\">https://www.owasp.org/index.php/SQL_Injection</a></p></li>\n<li><p><a href=\"https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet\">SQL Injection Prevention Cheat Sheet</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('ssl_poodle-es', 'ssl_poodle', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} es\nvulnerable a POODLE.',
        'POODLE es una falla en SSLv3 que permite a un atacante recuperar\ninformación cifrada, ocasionando de esta forma pérdida de confidencialidad.',
        'Acceda a la siguiente página para verificar que los servicios que usted\nprovee en el host son vulnerables a POODLE:\n\n<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.poodlescan.com/\">https://www.poodlescan.com/</a></p></li>\n</ul>\n\n</div>',
        'Se recomienda dejar de utilizar las librerías SSLv2 y SSLv3. Como reemplazo\npuede utilizar TLS.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566\">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL),
       ('suspicious_behavior-es', 'suspicious_behavior', 'es',
        'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} se está comportando de manera sospechosa.',
        'esto se puede deber a\n\n<ul>\n<li><p>El sitio web contiene software malicioso: El sitio podría instalar software malicioso a los usuarios.</p></li>\n<li><p>Sitio engañoso: El sitio web podría realizar una suplantación de identidad.</p></li>\n<li><p>El sitio contiene programas peligrosos: El sitio podría engañar usuarios para instalar programas que causen problemas cuando navegan.</p></li>\n</ul>',
        NULL,
        'Se recomienda verificar la herramienta,aplicación o CMS que este utilizando con el fin de encotrar vulnerabilidades o malware.',
        '<div class=\"destacated\">\n\n<ul>\n<li><p><a href=\"https://www.owasp.org/index.php/Category:Vulnerability_Scanning_Tools\">https://www.owasp.org/index.php/Category:Vulnerability_Scanning_Tools</a></p></li>\n<li><p><a href=\"https://support.google.com/chrome/answer/99020?hl=es-419\">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>\n</ul>\n\n</div>',
        1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, NULL);
/*!40000 ALTER TABLE `incident_report`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_state`
--

DROP TABLE IF EXISTS `incident_state`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_state`
(
    `slug`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `active`        tinyint(1)                                              NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `behavior`      varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `description`   varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_F8A770913BABA0B0` (`behavior`),
    KEY `IDX_F8A77091B03A8386` (`created_by_id`),
    CONSTRAINT `FK_F8A770913BABA0B0` FOREIGN KEY (`behavior`) REFERENCES `state_behavior` (`slug`),
    CONSTRAINT `FK_F8A77091B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_state`
--

LOCK TABLES `incident_state` WRITE;
/*!40000 ALTER TABLE `incident_state`
    DISABLE KEYS */;
INSERT INTO `incident_state`
VALUES ('closed', 'Closed', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', 'closed', NULL, NULL, NULL),
       ('closed_by_inactivity', 'Closed by inactivity', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', 'closed', NULL,
        NULL, NULL),
       ('closed_by_unattended', 'Closed by unattended', 1, '2020-09-01 01:07:25', '2020-09-01 01:07:25', 'closed', NULL,
        NULL, NULL),
       ('closed_by_unsolved', 'Closed by unsolved', 1, '2020-09-01 01:07:25', '2020-09-01 01:07:25', 'closed', NULL,
        NULL, NULL),
       ('discarded_by_unattended', 'Discarded by unattended', 1, '2020-09-01 01:07:25', '2020-09-01 01:07:25',
        'discarded', NULL, NULL, NULL),
       ('discarded_by_unsolved', 'Discarded by unsolved', 1, '2020-09-01 01:07:25', '2020-09-01 01:07:25', 'discarded',
        NULL, NULL, NULL),
       ('initial', 'Initial', 1, '2020-09-01 01:07:29', '2020-09-01 01:07:29', 'new', '', NULL, NULL),
       ('open', 'Open', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', 'on_treatment', NULL, NULL, NULL),
       ('removed', 'Removed', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', 'discarded', NULL, NULL, NULL),
       ('staging', 'Staging', 1, '2020-09-01 01:07:13', '2020-09-01 01:07:13', 'new', NULL, NULL, NULL),
       ('undefined', 'Undefined', 1, '2020-09-01 01:07:10', '2020-09-01 01:07:10', 'new', NULL, NULL, NULL),
       ('unresolved', 'Unresolved', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', 'on_treatment', NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_state`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_state_change`
--

DROP TABLE IF EXISTS `incident_state_change`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_state_change`
(
    `id`             int                                                    NOT NULL AUTO_INCREMENT,
    `incident_id`    int      DEFAULT NULL,
    `responsable_id` int      DEFAULT NULL,
    `date`           datetime DEFAULT NULL,
    `method`         varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `state_edge_id`  int      DEFAULT NULL,
    `created_by_id`  int      DEFAULT NULL,
    `created_at`     datetime DEFAULT NULL,
    `updated_at`     datetime DEFAULT NULL,
    `deletedAt`      datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_7A2C142459E53FB9` (`incident_id`),
    KEY `IDX_7A2C142453C59D72` (`responsable_id`),
    KEY `IDX_7A2C14242F0D3B98` (`state_edge_id`),
    KEY `IDX_7A2C1424B03A8386` (`created_by_id`),
    CONSTRAINT `FK_CCFC5A1D2F0D3B98` FOREIGN KEY (`state_edge_id`) REFERENCES `state_edge` (`id`),
    CONSTRAINT `FK_CCFC5A1D53C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_CCFC5A1D59E53FB9` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`),
    CONSTRAINT `FK_CCFC5A1DB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_state_change`
--

LOCK TABLES `incident_state_change` WRITE;
/*!40000 ALTER TABLE `incident_state_change`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `incident_state_change`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_tlp`
--

DROP TABLE IF EXISTS `incident_tlp`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_tlp`
(
    `slug`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `rgb`           varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `when`          varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `encrypt`       tinyint(1)                                              DEFAULT NULL,
    `why`           varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `information`   varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `description`   varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `name`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `code`          int                                                     DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `active`        tinyint(1)                                             NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_ECC4CA8DB03A8386` (`created_by_id`),
    CONSTRAINT `FK_ECC4CA8DB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_tlp`
--

LOCK TABLES `incident_tlp` WRITE;
/*!40000 ALTER TABLE `incident_tlp`
    DISABLE KEYS */;
INSERT INTO `incident_tlp`
VALUES ('amber', '#ffc000',
        'Sources may use TLP:AMBER when information requires support to be effectively acted upon, yet carries risks to privacy, reputation, or operations if shared outside of the organizations involved. 	',
        0,
        'Recipients may only share TLP:AMBER information with members of their own organization, and with clients or customers who need to know the information to protect themselves or prevent further harm. Sources are at liberty to specify additional intended limits of the sharing: these must be adhered to.\n',
        'TLP:AMBER', 'Limited disclosure, restricted to participants organizations.', 'amber', 2, NULL, 1, NULL, NULL,
        NULL),
       ('green', '#33ff00',
        'Sources may use TLP:GREEN when information is useful for the awareness of all participating organizations as well as with peers within the broader community or sector.	',
        0,
        'Recipients may share TLP:GREEN information with peers and partner organizations within their sector or community, but not via publicly accessible channels. Information in this category can be circulated widely within a particular community. TLP:GREEN information may not be released outside of the community.\n',
        'TLP:GREEN', 'Limited disclosure, restricted to the community.', 'green', 1, NULL, 1, NULL, NULL, NULL),
       ('red', '#ff0033',
        'Sources may use TLP:RED when information cannot be effectively acted upon by additional parties, and could lead to impacts on a party\'s privacy, reputation, or operations if misused.',
        1,
        'Recipients may not share TLP:RED information with any parties outside of the specific exchange, meeting, or conversation in which it was originally disclosed. In the context of a meeting, for example, TLP:RED information is limited to those present at the meeting. In most circumstances, TLP:RED should be exchanged verbally or in person.',
        'TLP:RED', 'Not for disclosure, restricted to participants only.', 'red', 3, NULL, 1, NULL, NULL, NULL),
       ('white', '#FFFFFF',
        'Sources may use TLP:WHITE when information carries minimal or no foreseeable risk of misuse, in accordance with applicable rules and procedures for public release.	',
        0, 'Subject to standard copyright rules, TLP:WHITE information may be distributed without restriction.\n',
        'TLP:WHITE', 'Disclosure is not limited.', 'white', 0, NULL, 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_tlp`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_type`
--

DROP TABLE IF EXISTS `incident_type`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_type`
(
    `slug`              varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`              varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `active`            tinyint(1)                                              NOT NULL,
    `created_at`        datetime                                                DEFAULT NULL,
    `updated_at`        datetime                                                DEFAULT NULL,
    `description`       varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `is_Classification` tinyint(1)                                              NOT NULL,
    `taxonomyValue`     varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id`     int                                                     DEFAULT NULL,
    `deletedAt`         datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_66D22096E371859C` (`taxonomyValue`),
    KEY `IDX_66D22096B03A8386` (`created_by_id`),
    CONSTRAINT `FK_66D22096B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_66D22096E371859C` FOREIGN KEY (`taxonomyValue`) REFERENCES `taxonomy_value` (`slug`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_type`
--

LOCK TABLES `incident_type` WRITE;
/*!40000 ALTER TABLE `incident_type`
    DISABLE KEYS */;
INSERT INTO `incident_type`
VALUES ('blacklist', 'Blacklist', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('botnet', 'Botnet', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('bruteforce', 'Bruteforce', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('cisco_smart_install', 'Cisco Smart Install', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL,
        NULL, NULL),
       ('copyright', 'Copyright', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('data_breach', 'Data Breach', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('deface', 'Deface', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('dns_zone_transfer', 'DNS zone transfer', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL,
        NULL),
       ('dos_chargen', 'DOS chargen', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('dos_ntp', 'DOS NTP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('dos_snmp', 'DOS SNMP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('drupal_remote_code_execution', 'Drupal Remote Code Execution', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39',
        NULL, 0, NULL, NULL, NULL),
       ('heartbleed', 'Heartbleed', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('information_leakage', 'Information Leakage', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL,
        NULL, NULL),
       ('malware', 'Malware', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_chargen', 'Open Chargen', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_dns', 'Open DNS', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_elasticsearch', 'Open Elasticsearch', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL,
        NULL, NULL),
       ('open_ipmi', 'Open IPMI', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_isakmp', 'Open ISAKMP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_ldap', 'Open LDAP', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('open_mdns', 'Open MDNS', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_memcached', 'Open memcached', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_mongodb', 'Open MongoDB', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('open_mssql', 'Open MSSQL', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_netbios', 'Open NetBios', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_ntp_monitor', 'Open NTP monitor', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL,
        NULL),
       ('open_ntp_version', 'Open NTP version', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL,
        NULL),
       ('open_portmap', 'Open Portmap', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('open_qotd', 'Open QOTD', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_rdp', 'Open RDP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_redis', 'Open Redis', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_smb', 'Open SMB', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_snmp', 'Open SNMP', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('open_ssdp', 'Open SSDP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_telnet', 'Open Telnet', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_tftp', 'Open TFTP', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('open_vnc', 'Open VNC', 1, '2018-11-02 14:49:39', '2018-11-02 14:49:39', NULL, 0, NULL, NULL, NULL),
       ('phishing_mail', 'Phishing Mail', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('phishing_web', 'Phishing Web', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('poodle', 'Poodle', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('rpz_botnet', 'RPZ Botnet', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('rpz_dbl', 'RPZ DBL', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('rpz_drop', 'RPZ Drop', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('rpz_malware', 'RPZ Malware', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('rpz_malware_aggressive', 'RPZ Malware Aggressive', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0,
        NULL, NULL, NULL),
       ('scan', 'Scan', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('shellshock', 'Shellshock', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('spam', 'Spam', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('sql_injection', 'SQL Injection', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('ssl_poodle', 'SSL Poodle', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL, NULL, NULL),
       ('suspicious_behavior', 'Suspicious Behavior', 1, '2018-11-02 14:49:40', '2018-11-02 14:49:40', NULL, 0, NULL,
        NULL, NULL),
       ('undefined', 'Undefined', 1, '2020-09-01 01:07:10', '2020-09-01 01:07:10', NULL, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_type`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incident_urgency`
--

DROP TABLE IF EXISTS `incident_urgency`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incident_urgency`
(
    `slug`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `name`          varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `description`   varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `active`        tinyint(1)                                             NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_C0B62D5FB03A8386` (`created_by_id`),
    CONSTRAINT `FK_C0B62D5FB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incident_urgency`
--

LOCK TABLES `incident_urgency` WRITE;
/*!40000 ALTER TABLE `incident_urgency`
    DISABLE KEYS */;
INSERT INTO `incident_urgency`
VALUES ('high', 'High',
        'The damage caused by the Incident increases rapidly.\nWork that cannot be completed by staff is highly time sensitive.\nA minor Incident can be prevented from becoming a major Incident by acting immediately.\nSeveral users with VIP status are affected.',
        NULL, 1, NULL, NULL, NULL),
       ('low', 'Low',
        'The damage caused by the Incident only marginally increases over time.\nWork that cannot be completed by staff is not time sensitive.',
        NULL, 1, NULL, NULL, NULL),
       ('medium', 'Medium',
        'The damage caused by the Incident increases considerably over time.\nA single user with VIP status is affected',
        NULL, 1, NULL, NULL, NULL),
       ('undefined', 'Undefined', 'Undefined', NULL, 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `incident_urgency`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message`
(
    `id`            int                                                     NOT NULL AUTO_INCREMENT,
    `data`          json                                                    NOT NULL,
    `updated_at`    datetime DEFAULT NULL,
    `created_at`    datetime DEFAULT NULL,
    `response`      json     DEFAULT NULL,
    `pending`       tinyint(1)                                              NOT NULL,
    `incident_id`   int      DEFAULT NULL,
    `discr`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_by_id` int      DEFAULT NULL,
    `deletedAt`     datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_B6BD307FB03A8386` (`created_by_id`),
    KEY `IDX_B6BD307F59E53FB9` (`incident_id`),
    CONSTRAINT `FK_B6BD307F59E53FB9` FOREIGN KEY (`incident_id`) REFERENCES `incident` (`id`),
    CONSTRAINT `FK_B6BD307FB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message`
    DISABLE KEYS */;
/*!40000 ALTER TABLE `message`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration_versions`
(
    `version`     varchar(14) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `executed_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
    PRIMARY KEY (`version`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions`
    DISABLE KEYS */;
INSERT INTO `migration_versions`
VALUES ('20181030200031', NULL),
       ('20181101023724', NULL),
       ('20181101151730', NULL),
       ('20181101193934', '2020-09-01 01:07:07'),
       ('20181105152756', '2020-09-01 01:07:08'),
       ('20181106144324', '2020-09-01 01:07:08'),
       ('20181107154751', '2020-09-01 01:07:09'),
       ('20181107171409', '2020-09-01 01:07:09'),
       ('20181108150200', '2020-09-01 01:07:10'),
       ('20181112181948', '2020-09-01 01:07:10'),
       ('20181113234642', '2020-09-01 01:07:10'),
       ('20181114154900', '2020-09-01 01:07:10'),
       ('20181114163414', '2020-09-01 01:07:10'),
       ('20181116205137', '2020-09-01 01:07:10'),
       ('20181121145047', '2020-09-01 01:07:11'),
       ('20181122161904', '2020-09-01 01:07:11'),
       ('20181203143328', '2020-09-01 01:07:12'),
       ('20181204175508', '2020-09-01 01:07:12'),
       ('20181205172456', '2020-09-01 01:07:12'),
       ('20181206161008', '2020-09-01 01:07:12'),
       ('20181206200446', '2020-09-01 01:07:13'),
       ('20181206202847', '2020-09-01 01:07:13'),
       ('20181212022353', '2020-09-01 01:07:13'),
       ('20181213175157', '2020-09-01 01:07:13'),
       ('20181221201343', '2020-09-01 01:07:13'),
       ('20181226144438', '2020-09-01 01:07:13'),
       ('20181226150442', '2020-09-01 01:07:13'),
       ('20181227183249', '2020-09-01 01:07:14'),
       ('20190103142415', '2020-09-01 01:07:14'),
       ('20190104114117', '2020-09-01 01:07:14'),
       ('20190108152658', '2020-09-01 01:07:14'),
       ('20190109171203', '2020-09-01 01:07:14'),
       ('20190109175637', '2020-09-01 01:07:14'),
       ('20190109190541', '2020-09-01 01:07:14'),
       ('20190109203258', '2020-09-01 01:07:14'),
       ('20190110113518', '2020-09-01 01:07:14'),
       ('20190110140618', '2020-09-01 01:07:15'),
       ('20190110142926', '2020-09-01 01:07:15'),
       ('20190110174203', '2020-09-01 01:07:15'),
       ('20190118204831', '2020-09-01 01:07:15'),
       ('20190118210133', '2020-09-01 01:07:15'),
       ('20190130151556', '2020-09-01 01:07:16'),
       ('20190205151815', '2020-09-01 01:07:16'),
       ('20190205155320', '2020-09-01 01:07:16'),
       ('20190207171436', '2020-09-01 01:07:16'),
       ('20190213120523', '2020-09-01 01:07:16'),
       ('20190219175243', '2020-09-01 01:07:16'),
       ('20190221161431', '2020-09-01 01:07:16'),
       ('20190306230829', '2020-09-01 01:07:16'),
       ('20190307172559', '2020-09-01 01:07:16'),
       ('20190307174636', '2020-09-01 01:07:16'),
       ('20190311165337', '2020-09-01 01:07:17'),
       ('20190314135348', '2020-09-01 01:07:17'),
       ('20190326144548', '2020-09-01 01:07:17'),
       ('20190328125024', '2020-09-01 01:07:17'),
       ('20190405010356', '2020-09-01 01:07:20'),
       ('20190405014436', '2020-09-01 01:07:20'),
       ('20190405154000', '2020-09-01 01:07:20'),
       ('20190405164209', '2020-09-01 01:07:20'),
       ('20190405182632', '2020-09-01 01:07:20'),
       ('20190406142130', '2020-09-01 01:07:21'),
       ('20190406160113', '2020-09-01 01:07:21'),
       ('20190408154212', '2020-09-01 01:07:22'),
       ('20190410183044', '2020-09-01 01:07:23'),
       ('20190410205549', '2020-09-01 01:07:23'),
       ('20190417004205', '2020-09-01 01:07:23'),
       ('20190425175303', '2020-09-01 01:07:23'),
       ('20190506203003', '2020-09-01 01:07:24'),
       ('20190612161900', '2020-09-01 01:07:24'),
       ('20190612164137', '2020-09-01 01:07:24'),
       ('20190621144030', '2020-09-01 01:07:25'),
       ('20190624165329', '2020-09-01 01:07:25'),
       ('20190627165727', '2020-09-01 01:07:25'),
       ('20190627174812', '2020-09-01 01:07:25'),
       ('20190701155556', '2020-09-01 01:07:25'),
       ('20190701194227', '2020-09-01 01:07:25'),
       ('20190701195101', '2020-09-01 01:07:25'),
       ('20190701205607', '2020-09-01 01:07:26'),
       ('20190730144109', '2020-09-01 01:07:26'),
       ('20190730172724', '2020-09-01 01:07:27'),
       ('20190731213117', '2020-09-01 01:07:27'),
       ('20190807183208', '2020-09-01 01:07:27'),
       ('20190808204749', '2020-09-01 01:07:27'),
       ('20190813181943', '2020-09-01 01:07:28'),
       ('20190817154516', '2020-09-01 01:07:28'),
       ('20190817155236', '2020-09-01 01:07:28'),
       ('20190820234219', '2020-09-01 01:07:28'),
       ('20190822165943', '2020-09-01 01:07:28'),
       ('20190822172425', '2020-09-01 01:07:29'),
       ('20190822195531', '2020-09-01 01:07:29'),
       ('20190830181310', '2020-09-01 01:07:29'),
       ('20190902142125', '2020-09-01 01:07:29'),
       ('20190917154226', '2020-09-01 01:07:29'),
       ('20190917194350', '2020-09-01 01:07:29'),
       ('20191002200329', '2020-09-01 01:07:29'),
       ('20191008213150', '2020-09-01 01:07:30'),
       ('20191015150036', '2020-09-01 01:07:30'),
       ('20191015234804', '2020-09-01 01:07:30'),
       ('20191017014431', '2020-09-01 01:07:30'),
       ('20191017020440', '2020-09-01 01:07:30'),
       ('20200219135237', '2020-09-01 01:07:30'),
       ('20200520182150', '2020-09-01 01:07:30'),
       ('20200520183552', '2020-09-01 01:07:35'),
       ('20200522153120', '2020-09-01 01:07:35'),
       ('20200702180324', '2020-09-01 01:07:35'),
       ('20200706163511', '2020-09-01 01:07:36'),
       ('20200722170120', '2020-09-01 01:07:37'),
       ('20200807230826', '2020-09-01 01:07:37'),
       ('20200821182659', '2020-09-01 01:07:37'),
       ('20200823155355', '2020-09-01 01:09:21'),
       ('20200826004710', '2020-09-01 01:09:21'),
       ('20200826215540', '2020-09-01 01:09:22'),
       ('20200901023302', '2020-09-01 02:34:34');
/*!40000 ALTER TABLE `migration_versions`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network`
--

DROP TABLE IF EXISTS `network`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network`
(
    `id`                int        NOT NULL AUTO_INCREMENT,
    `network_admin_id`  int                                                                            DEFAULT NULL,
    `network_entity_id` int                                                                            DEFAULT NULL,
    `ip_mask`           int                                                                            DEFAULT NULL,
    `ip`                varchar(39) CHARACTER SET utf8 COLLATE utf8_unicode_ci                         DEFAULT NULL,
    `active`            tinyint(1) NOT NULL,
    `created_at`        datetime                                                                       DEFAULT NULL,
    `updated_at`        datetime                                                                       DEFAULT NULL,
    `domain`            varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci                        DEFAULT NULL,
    `type`              enum ('internal','external','rdap') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `country_code`      varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci                          DEFAULT NULL,
    `ip_start_address`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci                        DEFAULT NULL,
    `ip_end_address`    varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci                        DEFAULT NULL,
    `asn`               varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci                        DEFAULT NULL,
    `created_by_id`     int                                                                            DEFAULT NULL,
    `deletedAt`         datetime                                                                       DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_608487BCC9E8B981` (`network_admin_id`),
    KEY `IDX_608487BC6801DB4` (`network_entity_id`),
    KEY `IDX_608487BCB03A8386` (`created_by_id`),
    CONSTRAINT `FK_608487BC6801DB4` FOREIGN KEY (`network_entity_id`) REFERENCES `network_entity` (`id`),
    CONSTRAINT `FK_608487BCB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_608487BCC9E8B981` FOREIGN KEY (`network_admin_id`) REFERENCES `network_admin` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network`
--

LOCK TABLES `network` WRITE;
/*!40000 ALTER TABLE `network`
    DISABLE KEYS */;
INSERT INTO `network`
VALUES (1, 1, 1, 16, '192.168.0.0', 1, '2020-08-31 22:55:11', '2020-08-31 22:55:11', NULL, 'internal', NULL,
        '192.168.0.0', '192.168.255.255', NULL, 1, NULL),
       (2, 2, 2, 0, '0.0.0.0', 1, '2020-08-31 22:55:11', '2020-08-31 22:55:11', '0', 'internal', NULL, '0.0.0.0',
        '0.0.0.0', NULL, 1, NULL);
/*!40000 ALTER TABLE `network`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_admin`
--

DROP TABLE IF EXISTS `network_admin`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_admin`
(
    `id`            int                                                     NOT NULL AUTO_INCREMENT,
    `name`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `slug`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `active`        tinyint(1)                                              NOT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_4614B42A989D9B62` (`slug`),
    KEY `IDX_4614B42AB03A8386` (`created_by_id`),
    CONSTRAINT `FK_4614B42AB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_admin`
--

LOCK TABLES `network_admin` WRITE;
/*!40000 ALTER TABLE `network_admin`
    DISABLE KEYS */;
INSERT INTO `network_admin`
VALUES (1, 'Support Test', 'support_test_support_organization_test', 1, '2018-11-02 14:49:41', '2018-11-02 14:49:41',
        NULL, NULL),
       (2, 'Undefined', 'undefined', 1, '2020-09-09 22:16:07', '2020-09-09 22:16:07', 1, NULL);
/*!40000 ALTER TABLE `network_admin`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `network_entity`
--

DROP TABLE IF EXISTS `network_entity`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_entity`
(
    `id`            int                                                     NOT NULL AUTO_INCREMENT,
    `name`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `slug`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `active`        tinyint(1)                                              NOT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_6C3B430EB03A8386` (`created_by_id`),
    CONSTRAINT `FK_6C3B430EB03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_entity`
--

LOCK TABLES `network_entity` WRITE;
/*!40000 ALTER TABLE `network_entity`
    DISABLE KEYS */;
INSERT INTO `network_entity`
VALUES (1, 'Test', 'test', '2018-11-02 14:49:41', '2018-11-02 14:49:41', 1, NULL, NULL),
       (2, 'Undefined', 'undefined', '2020-09-09 22:16:18', '2020-09-09 22:16:18', 1, 1, NULL);
/*!40000 ALTER TABLE `network_entity`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state_behavior`
--

DROP TABLE IF EXISTS `state_behavior`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `state_behavior`
(
    `slug`                  varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `name`                  varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `description`           varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `can_edit_fundamentals` tinyint(1)                                              NOT NULL,
    `created_at`            datetime                                                DEFAULT NULL,
    `updated_at`            datetime                                                DEFAULT NULL,
    `can_edit`              tinyint(1)                                              NOT NULL,
    `can_enrich`            tinyint(1)                                              NOT NULL,
    `can_add_history`       tinyint(1)                                              NOT NULL,
    `can_comunicate`        tinyint(1)                                              NOT NULL,
    `discr`                 varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_by_id`         int                                                     DEFAULT NULL,
    `deletedAt`             datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    KEY `IDX_458C617B03A8386` (`created_by_id`),
    CONSTRAINT `FK_458C617B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state_behavior`
--

LOCK TABLES `state_behavior` WRITE;
/*!40000 ALTER TABLE `state_behavior`
    DISABLE KEYS */;
INSERT INTO `state_behavior`
VALUES ('closed', 'Close', 'Close and Incident', 0, '2020-09-01 01:07:24', '2020-09-01 01:07:24', 0, 0, 0, 0, 'closed',
        NULL, NULL),
       ('discarded', 'Discard', 'Discard Incident', 0, '2019-12-09 18:09:02', '2019-12-09 18:09:02', 0, 0, 0, 0,
        'discarded', NULL, NULL),
       ('new', 'New', 'New incident', 1, '2020-09-01 01:07:24', '2020-09-01 01:07:24', 1, 1, 1, 0, 'new', NULL, NULL),
       ('on_treatment', 'On Treatment', 'Open an incident', 0, '2020-09-01 01:07:24', '2020-09-01 01:07:24', 1, 1, 1, 1,
        'on_treatment', NULL, NULL);
/*!40000 ALTER TABLE `state_behavior`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state_edge`
--

DROP TABLE IF EXISTS `state_edge`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `state_edge`
(
    `id`            int                                                     NOT NULL AUTO_INCREMENT,
    `mail_assigned` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `mail_team`     varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `mail_admin`    varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `mail_reporter` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci  DEFAULT NULL,
    `created_at`    datetime                                                DEFAULT NULL,
    `updated_at`    datetime                                                DEFAULT NULL,
    `oldState`      varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `newState`      varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `discr`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `created_by_id` int                                                     DEFAULT NULL,
    `deletedAt`     datetime                                                DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_E1E55AA017EA0C41` (`oldState`),
    KEY `IDX_E1E55AA0CB9A3939` (`newState`),
    KEY `IDX_E1E55AA0D64D0DD2` (`mail_assigned`),
    KEY `IDX_E1E55AA0699B3576` (`mail_team`),
    KEY `IDX_E1E55AA0BCCDAF19` (`mail_admin`),
    KEY `IDX_E1E55AA0AB0121BA` (`mail_reporter`),
    KEY `IDX_E1E55AA0B03A8386` (`created_by_id`),
    CONSTRAINT `FK_E1E55AA017EA0C41` FOREIGN KEY (`oldState`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_E1E55AA0699B3576` FOREIGN KEY (`mail_team`) REFERENCES `contact_case` (`slug`),
    CONSTRAINT `FK_E1E55AA0AB0121BA` FOREIGN KEY (`mail_reporter`) REFERENCES `contact_case` (`slug`),
    CONSTRAINT `FK_E1E55AA0B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`),
    CONSTRAINT `FK_E1E55AA0BCCDAF19` FOREIGN KEY (`mail_admin`) REFERENCES `contact_case` (`slug`),
    CONSTRAINT `FK_E1E55AA0CB9A3939` FOREIGN KEY (`newState`) REFERENCES `incident_state` (`slug`),
    CONSTRAINT `FK_E1E55AA0D64D0DD2` FOREIGN KEY (`mail_assigned`) REFERENCES `contact_case` (`slug`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 82
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state_edge`
--

LOCK TABLES `state_edge` WRITE;
/*!40000 ALTER TABLE `state_edge`
    DISABLE KEYS */;
INSERT INTO `state_edge`
VALUES (12, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'open', 'opening',
        NULL, NULL),
       (14, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'open', 'opening',
        NULL, NULL),
       (17, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'open', 'updating', NULL,
        NULL),
       (18, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'unresolved',
        'discarding', NULL, NULL),
       (22, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'removed', 'discarding',
        NULL, NULL),
       (23, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'unresolved', 'staging',
        'reopening', NULL, NULL),
       (30, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed_by_inactivity', 'staging',
        'reopening', NULL, NULL),
       (32, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'staging', 'new', NULL,
        NULL),
       (33, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'unresolved',
        'discarding', NULL, NULL),
       (34, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'undefined', 'new',
        NULL, NULL),
       (36, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'closed', 'closing',
        NULL, NULL),
       (37, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial', 'removed',
        'discarding', NULL, NULL),
       (41, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'staging', 'updating',
        NULL, NULL),
       (43, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'undefined', 'staging',
        'updating', NULL, NULL),
       (45, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging',
        'discarded_by_unattended', 'discarding', NULL, NULL),
       (46, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'removed', 'removed', 'updating',
        NULL, NULL),
       (47, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'removed', 'staging', 'reopening',
        NULL, NULL),
       (48, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'removed',
        'discarding', NULL, NULL),
       (49, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed', 'staging', 'reopening',
        NULL, NULL),
       (50, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed', 'closed', 'updating',
        NULL, NULL),
       (51, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'closed', 'closing',
        NULL, NULL),
       (53, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'initial',
        'discarded_by_unattended', 'discarding', NULL, NULL),
       (55, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging',
        'discarded_by_unsolved', 'discarding', NULL, NULL),
       (56, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'closed_by_unattended',
        'closing', NULL, NULL),
       (57, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'closed_by_unsolved',
        'closing', NULL, NULL),
       (58, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'staging', 'closed_by_inactivity',
        'closing', NULL, NULL),
       (59, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'undefined', 'undefined',
        'updating', NULL, NULL),
       (65, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'closed_by_inactivity',
        'closing', NULL, NULL),
       (66, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'closed_by_unattended',
        'closing', NULL, NULL),
       (67, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'closed_by_unsolved',
        'closing', NULL, NULL),
       (68, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'discarded_by_unattended',
        'discarding', NULL, NULL),
       (69, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'discarded_by_unsolved',
        'discarding', NULL, NULL),
       (70, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'open', 'closed', 'closing', NULL,
        NULL),
       (72, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed_by_unsolved', 'staging',
        'reopening', NULL, NULL),
       (73, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed_by_unattended', 'staging',
        'reopening', NULL, NULL),
       (74, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'discarded_by_unattended',
        'staging', 'reopening', NULL, NULL),
       (75, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'discarded_by_unsolved',
        'staging', 'reopening', NULL, NULL),
       (76, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed', 'closed', 'updating',
        NULL, NULL),
       (77, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed_by_unsolved',
        'closed_by_unsolved', 'updating', NULL, NULL),
       (78, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'closed_by_unattended',
        'closed_by_unattended', 'updating', NULL, NULL),
       (79, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'discarded_by_unattended',
        'discarded_by_unattended', 'updating', NULL, NULL),
       (80, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'discarded_by_unsolved',
        'discarded_by_unsolved', 'updating', NULL, NULL),
       (81, 'all', 'all', 'all', 'all', '2019-06-12 17:04:56', '2019-06-12 17:04:56', 'unresolved', 'unresolved',
        'updating', NULL, NULL);
/*!40000 ALTER TABLE `state_edge`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxonomy_predicate`
--

DROP TABLE IF EXISTS `taxonomy_predicate`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taxonomy_predicate`
(
    `slug`          varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `description`   varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `expanded`      varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `version`       int                                                      NOT NULL,
    `value`         varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `updated_at`    datetime DEFAULT NULL,
    `active`        tinyint(1)                                               NOT NULL,
    `created_at`    datetime DEFAULT NULL,
    `created_by_id` int      DEFAULT NULL,
    `deletedAt`     datetime DEFAULT NULL,
    PRIMARY KEY (`slug`),
    UNIQUE KEY `UNIQ_28010D241D775834` (`value`),
    KEY `IDX_28010D24B03A8386` (`created_by_id`),
    CONSTRAINT `FK_28010D24B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxonomy_predicate`
--

LOCK TABLES `taxonomy_predicate` WRITE;
/*!40000 ALTER TABLE `taxonomy_predicate`
    DISABLE KEYS */;
INSERT INTO `taxonomy_predicate`
VALUES ('abusive_content', 'Abusive Content.', 'Abusive Content', 1002, 'abusive-content', '2020-08-31 23:05:13', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('availability',
        'By this kind of an attack a system is bombarded with so many packets that the operations are delayed or the system crashes. DoS examples are ICMP and SYN floods, Teardrop attacks and mail-bombing. DDoS often is based on DoS attacks originating from botnets, but also other scenarios exist like DNS Amplification attacks. However, the availability also can be affected by local actions (destruction, disruption of power supply, etc.) – or by Act of God, spontaneous failures or human error, without malice or gross neglect being involved.',
        'Availability', 1002, 'availability', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('fraud', 'Fraud.', 'Fraud', 1002, 'fraud', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('information_content_security',
        'Besides a local abuse of data and systems the information security can be endangered by a successful account or application compromise. Furthermore attacks are possible that intercept and access information during transmission (wiretapping, spoofing or hijacking). Human/configuration/software error can also be the cause.',
        'Information Content Security', 1002, 'information-content-security', '2020-08-31 23:05:13', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('information_gathering', 'Information Gathering.', 'Information Gathering', 1002, 'information-gathering',
        '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('intrusion_attempts', 'Intrusion Attempts.', 'Intrusion Attempts', 1002, 'intrusion-attempts',
        '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('intrusions',
        'A successful compromise of a system or application (service). This can have been caused remotely by a known or new vulnerability, but also by an unauthorised local access. Also includes being part of a botnet.',
        'Intrusions', 1002, 'intrusions', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('malicious_code',
        'Software that is intentionally included or inserted in a system for a harmful purpose. A user interaction is normally necessary to activate the code.',
        'Malicious Code', 1002, 'malicious-code', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('other',
        'All incidents which don\'t fit in one of the given categories should be put into this class. If the number of incidents in this category increases, it is an indicator that the classification scheme must be revised',
        'Other', 1002, 'other', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('test', 'Meant for testing.', 'Test', 1002, 'test', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL,
        NULL),
       ('vulnerable',
        'Open resolvers, world readable printers, vulnerability apparent from Nessus etc scans, virus signatures not up-to-date, etc',
        'Vulnerable', 1002, 'vulnerable', '2020-08-31 23:05:13', 1, '2020-08-31 23:05:13', NULL, NULL);
/*!40000 ALTER TABLE `taxonomy_predicate`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taxonomy_value`
--

DROP TABLE IF EXISTS `taxonomy_value`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `taxonomy_value`
(
    `slug`              varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `description`       varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `expanded`          varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `value`             varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `updated_at`        datetime                                                DEFAULT NULL,
    `version`           int                                                      NOT NULL,
    `taxonomyPredicate` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `active`            tinyint(1)                                               NOT NULL,
    `created_at`        datetime                                                DEFAULT NULL,
    `created_by_id`     int                                                     DEFAULT NULL,
    `deletedAt`         datetime                                                DEFAULT NULL,
    PRIMARY KEY (`slug`),
    UNIQUE KEY `UNIQ_48109C991D775834` (`value`),
    KEY `IDX_48109C9931CA456F` (`taxonomyPredicate`),
    KEY `IDX_48109C99B03A8386` (`created_by_id`),
    CONSTRAINT `FK_48109C9931CA456F` FOREIGN KEY (`taxonomyPredicate`) REFERENCES `taxonomy_predicate` (`slug`),
    CONSTRAINT `FK_48109C99B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taxonomy_value`
--

LOCK TABLES `taxonomy_value` WRITE;
/*!40000 ALTER TABLE `taxonomy_value`
    DISABLE KEYS */;
INSERT INTO `taxonomy_value`
VALUES ('application_compromise',
        'Compromise of an application by exploiting (un-)known software vulnerabilities, e.g. SQL injection.',
        'Application Compromise', 'application-compromise', '2020-08-31 23:05:13', 1002, 'intrusions', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('brute_force',
        'Multiple login attempts (Guessing / cracking of passwords, brute force). This IOC refers to a resource, which has been observed to perform brute-force attacks over a given application protocol.',
        'Login attempts', 'brute-force', '2020-08-31 23:05:13', 1002, 'intrusion_attempts', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('burglary', 'Physical intrusion, e.g. into corporate building or data-centre.', 'Burglary', 'burglary',
        '2020-08-31 23:05:13', 1002, 'intrusions', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('c2_server', 'Command-and-control server contacted by malware on infected systems.', 'C2 Server', 'c2-server',
        '2020-08-31 23:05:13', 1002, 'malicious_code', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('copyright',
        'Offering or Installing copies of unlicensed commercial software or other copyright protected materials (Warez).',
        'Copyright', 'copyright', '2020-08-31 23:05:13', 1002, 'fraud', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('data_leak', 'Leaked confidential information like credentials or personal data.',
        'Leak of confidential information', 'data-leak', '2020-08-31 23:05:13', 1002, 'information_content_security', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('data_loss', 'Loss of data, e.g. caused by harddisk failure or physical theft.', 'Data Loss', 'data-loss',
        '2020-08-31 23:05:13', 1002, 'information_content_security', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('ddos', 'Distributed Denial of Service attack, e.g. SYN-Flood or UDP-based reflection/amplification attacks.',
        'Distributed Denial of Service', 'ddos', '2020-08-31 23:05:13', 1002, 'availability', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('ddos_amplifier',
        'Publicly accessible services that can be abused for conducting DDoS reflection/amplification attacks, e.g. DNS open-resolvers or NTP servers with monlist enabled.',
        'DDoS amplifier', 'ddos-amplifier', '2020-08-31 23:05:13', 1002, 'vulnerable', 1, '2020-08-31 23:05:13', NULL,
        NULL),
       ('dos',
        'Denial of Service attack, e.g. sending specially crafted requests to a web application which causes the application to crash or slow down.',
        'Denial of Service', 'dos', '2020-08-31 23:05:13', 1002, 'availability', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('exploit', 'An attack using an unknown exploit.', 'New attack signature', 'exploit', '2020-08-31 23:05:13',
        1002, 'intrusion_attempts', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('harmful_speech',
        'Discretization or discrimination of somebody, e.g. cyber stalking, racism or threats against one or more individuals.',
        'Harmful Speech', 'harmful-speech', '2020-08-31 23:05:13', 1002, 'abusive_content', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('ids_alert',
        'An attempt to compromise a system or to disrupt any service by exploiting vulnerabilities with a standardised identifier such as CVE name (e.g. buffer overflow, backdoor, cross site scripting, etc.)',
        'Exploitation of known Vulnerabilities', 'ids-alert', '2020-08-31 23:05:13', 1002, 'intrusion_attempts', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('infected_system',
        'System infected with malware, e.g. PC, smartphone or server infected with a rootkit. Most often this refers to a connection to a sinkholed C2 server',
        'Infected System', 'infected-system', '2020-08-31 23:05:13', 1002, 'malicious_code', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('information_disclosure',
        'Publicly accessible services potentially disclosing sensitive information, e.g. SNMP or Redis.',
        'Information disclosure', 'information-disclosure', '2020-08-31 23:05:13', 1002, 'vulnerable', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('malware_configuration', 'URI hosting a malware configuration file, e.g. web-injects for a banking trojan.',
        'Malware Configuration', 'malware-configuration', '2020-08-31 23:05:13', 1002, 'malicious_code', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('malware_distribution',
        'URI used for malware distribution, e.g. a download URL included in fake invoice malware spam or exploit-kits (on websites).',
        'Malware Distribution', 'malware-distribution', '2020-08-31 23:05:13', 1002, 'malicious_code', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('masquerade',
        'Type of attack in which one entity illegitimately impersonates the identity of another in order to benefit from it.',
        'Masquerade', 'masquerade', '2020-08-31 23:05:13', 1002, 'fraud', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('misconfiguration',
        'Software misconfiguration resulting in service availability issues, e.g. DNS server with outdated DNSSEC Root Zone KSK.',
        'Misconfiguration', 'misconfiguration', '2020-08-31 23:05:13', 1002, 'availability', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('other',
        'All incidents which don\'t fit in one of the given categories should be put into this class or the incident is not categorised.',
        'Uncategorised', 'other', '2020-08-31 23:05:13', 1002, 'other', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('outage', 'Outage caused e.g. by air condition failure or natural disaster.', 'Outage', 'outage',
        '2020-08-31 23:05:13', 1002, 'availability', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('phishing',
        'Masquerading as another entity in order to persuade the user to reveal private credentials. This IOC most often refers to a URL, which is used to phish user credentials.',
        'Phishing', 'phishing', '2020-08-31 23:05:13', 1002, 'fraud', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('potentially_unwanted_accessible',
        'Potentially unwanted publicly accessible services, e.g. Telnet, RDP or VNC.',
        'Potentially unwanted accessible services', 'potentially-unwanted-accessible', '2020-08-31 23:05:13', 1002,
        'vulnerable', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('privileged_account_compromise', 'Compromise of a system where the attacker gained administrative privileges.',
        'Privileged Account Compromise', 'privileged-account-compromise', '2020-08-31 23:05:13', 1002, 'intrusions', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('sabotage', 'Physical sabotage, e.g cutting wires or malicious arson.', 'Sabotage', 'sabotage',
        '2020-08-31 23:05:13', 1002, 'availability', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('scanner',
        'Attacks that send requests to a system to discover weaknesses. This also includes testing processes to gather information on hosts, services and accounts. Examples: fingerd, DNS querying, ICMP, SMTP (EXPN, RCPT, ...), port scanning.',
        'Scanning', 'scanner', '2020-08-31 23:05:13', 1002, 'information_gathering', 1, '2020-08-31 23:05:13', NULL,
        NULL),
       ('sniffing', 'Observing and recording of network traffic (wiretapping).', 'Sniffing', 'sniffing',
        '2020-08-31 23:05:13', 1002, 'information_gathering', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('social_engineering',
        'Gathering information from a human being in a non-technical way (e.g. lies, tricks, bribes, or threats).',
        'Social Engineering', 'social-engineering', '2020-08-31 23:05:13', 1002, 'information_gathering', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('spam',
        'Or \'Unsolicited Bulk Email\', this means that the recipient has not granted verifiable permission for the message to be sent and that the message is sent as part of a larger collection of messages, all having a functionally comparable content. This IOC refers to resources, which make up a SPAM infrastructure, be it a harvesters like address verification, URLs in spam e-mails etc.',
        'Spam', 'spam', '2020-08-31 23:05:13', 1002, 'abusive_content', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('system_compromise',
        'Compromise of a system, e.g. unauthorised logins or commands. This includes compromising attempts on honeypot systems.',
        'System Compromise', 'system-compromise', '2020-08-31 23:05:13', 1002, 'intrusions', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('test', 'Meant for testing.', 'Test', 'test', '2020-08-31 23:05:13', 1002, 'test', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('unauthorised_information_access',
        'Unauthorised access to information, e.g. by abusing stolen login credentials for a system or application, intercepting traffic or gaining access to physical documents.',
        'Unauthorised access to information', 'unauthorised-information-access', '2020-08-31 23:05:13', 1002,
        'information_content_security', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('unauthorised_information_modification',
        'Unauthorised modification of information, e.g. by an attacker abusing stolen login credentials for a system or application or a ransomware encrypting data. Also includes defacements.',
        'Unauthorised modification of information', 'unauthorised-information-modification', '2020-08-31 23:05:13',
        1002, 'information_content_security', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('unauthorised_use_of_resources',
        'Using resources for unauthorised purposes including profit-making ventures, e.g. the use of e-mail to participate in illegal profit chain letters or pyramid schemes.',
        'Unauthorised use of resources', 'unauthorised-use-of-resources', '2020-08-31 23:05:13', 1002, 'fraud', 1,
        '2020-08-31 23:05:13', NULL, NULL),
       ('undetermined', 'The categorisation of the incident is unknown/undetermined.', 'Undetermined', 'undetermined',
        '2020-08-31 23:05:13', 1002, 'other', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('unprivileged_account_compromise', 'Compromise of a system using an unprivileged (user/service) account.',
        'Unprivileged Account Compromise', 'unprivileged-account-compromise', '2020-08-31 23:05:13', 1002, 'intrusions',
        1, '2020-08-31 23:05:13', NULL, NULL),
       ('violence', 'Child Sexual Exploitation (CSE), Sexual content, glorification of violence, etc.',
        '(Child) Sexual Exploitation/Sexual/Violent Content', 'violence', '2020-08-31 23:05:13', 1002,
        'abusive_content', 1, '2020-08-31 23:05:13', NULL, NULL),
       ('vulnerable_system',
        'A system which is vulnerable to certain attacks. Example: misconfigured client proxy settings (example: WPAD), outdated operating system version, XSS vulnerabilities, etc.',
        'Vulnerable system', 'vulnerable-system', '2020-08-31 23:05:13', 1002, 'vulnerable', 1, '2020-08-31 23:05:13',
        NULL, NULL),
       ('weak_crypto',
        'Publicly accessible services offering weak crypto, e.g. web servers susceptible to POODLE/FREAK attacks.',
        'Weak crypto', 'weak-crypto', '2020-08-31 23:05:13', 1002, 'vulnerable', 1, '2020-08-31 23:05:13', NULL, NULL);
/*!40000 ALTER TABLE `taxonomy_value`
    ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user`
(
    `id`                    int                                                     NOT NULL AUTO_INCREMENT,
    `username`              varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `username_canonical`    varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email`                 varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `email_canonical`       varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `enabled`               tinyint(1)                                              NOT NULL,
    `salt`                  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `password`              varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `last_login`            datetime                                                DEFAULT NULL,
    `confirmation_token`    varchar(180) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `password_requested_at` datetime                                                DEFAULT NULL,
    `roles`                 longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci     NOT NULL COMMENT '(DC2Type:array)',
    `api_key`               varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `firstname`             varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `lastname`              varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci  NOT NULL,
    `created_at`            datetime                                                NOT NULL,
    `updated_at`            datetime                                                NOT NULL,
    `slug`                  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_by_id`         int                                                     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
    UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
    UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`),
    KEY `IDX_8D93D649B03A8386` (`created_by_id`),
    CONSTRAINT `FK_8D93D649B03A8386` FOREIGN KEY (`created_by_id`) REFERENCES `user` (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user`
    DISABLE KEYS */;
INSERT INTO `user`
VALUES (1, 'admin', 'admin', 'admin@cert.com', 'admin@cert.com', 1, NULL,
        '$2y$13$bCXhBy3fqnVndwQNmY4xx.NfcWRInLD5WMU.WUlK6Q/8zMFRapXBe', '2020-09-09 22:16:18', NULL, NULL,
        'a:1:{i:0;s:8:\"ROLE_API\";}', '648c0082e893290d263a3c33b2ad7dbf05ab769e', 'admin', 'admin',
        '2018-11-02 14:49:40', '2020-09-09 22:16:18', 'admin_admin', NULL);
/*!40000 ALTER TABLE `user`
    ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2020-09-09 22:19:09
