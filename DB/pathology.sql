/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.1.25-MariaDB : Database - pathology
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pathology` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `pathology`;

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migration` */

insert  into `migration`(`version`,`apply_time`) values ('m000000_000000_base',1464762364),('m130524_201442_init',1464762369);

/*Table structure for table `patient_details` */

DROP TABLE IF EXISTS `patient_details`;

CREATE TABLE `patient_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fk_id` int(11) NOT NULL,
  `pass_code` varchar(255) DEFAULT NULL,
  `gender` char(1) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `height` varchar(100) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `address` text,
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pass_code` (`pass_code`),
  KEY `user_fk_id` (`user_fk_id`),
  CONSTRAINT `patient_details_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `patient_details` */

/*Table structure for table `patient_reports` */

DROP TABLE IF EXISTS `patient_reports`;

CREATE TABLE `patient_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_fk_id` int(11) NOT NULL,
  `exam` varchar(255) NOT NULL,
  `referred_doctor` varchar(255) DEFAULT NULL,
  `sample_no` varchar(255) DEFAULT NULL,
  `doctor_specialization` varchar(255) DEFAULT NULL,
  `prescription_image` varchar(255) DEFAULT NULL,
  `prescrption_text` text,
  `summary` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_fk_id` (`patient_fk_id`),
  KEY `patient_fk_id_2` (`patient_fk_id`),
  CONSTRAINT `patient_reports_ibfk_1` FOREIGN KEY (`patient_fk_id`) REFERENCES `patient_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `patient_reports` */

/*Table structure for table `patient_tests` */

DROP TABLE IF EXISTS `patient_tests`;

CREATE TABLE `patient_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_report_fk_id` int(11) NOT NULL,
  `tests_type_fk_id` int(11) NOT NULL,
  `test_result` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_report_fk_id` (`patient_report_fk_id`,`tests_type_fk_id`),
  KEY `tests_type_fk_id` (`tests_type_fk_id`),
  CONSTRAINT `patient_tests_ibfk_1` FOREIGN KEY (`patient_report_fk_id`) REFERENCES `patient_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patient_tests_ibfk_2` FOREIGN KEY (`tests_type_fk_id`) REFERENCES `tests_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `patient_tests` */

/*Table structure for table `tests_type` */

DROP TABLE IF EXISTS `tests_type`;

CREATE TABLE `tests_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `reference_interval` varchar(255) NOT NULL,
  `specimen_type` varchar(255) DEFAULT NULL,
  `testing_frequency` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `tests_type` */

insert  into `tests_type`(`id`,`name`,`reference_interval`,`specimen_type`,`testing_frequency`,`comments`,`status`,`is_deleted`) values (1,'Glucose, Fasting','70-99 mg/dL','','','3.86-5.45 mmol/L',1,0),(2,'Glucose, Random','70-139 mg/dL','','','3.86-7.66 mmol/L',1,0),(3,'Hemoglobin, Men','13.3-17.7 g/dL','','','133-177 g/L',1,0),(4,'Hemoglobin, Women','11.7-15.7 g/dL','','','117-157 g/L',1,0),(5,'Acetylcholinesterase (ACE), RBC','26.7–49.2 U/g Hb','Blood','','',1,0),(6,'ACH','~10-20u/cc','','','',1,0);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`name`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`user_type`,`status`,`is_deleted`,`created_by`,`created_date`,`modified_by`,`modified_date`) values (1,'Admin','biJ1m60OM5IpTtco7X4hUZ6hy65IBm6M','$2y$13$1c0rxV4FSDS2R33ltmuV3.KDhv92XNwfEPEAxLQARIxT3fA5DPUFm',NULL,'admin@pathologylabs.com',1,1,0,0,'2017-07-14 05:31:36',NULL,NULL),(2,'Operator','34hhOw4_SAQVGh2o1gM1pW_xlLgca0Wu','$2y$13$QF.GBGFWIsMJ3hSChgOC6uehFr.E.eWh39gCFgjU9jGj9XFBrrZiq',NULL,'operator@pathologylabs.com',2,1,0,0,'2016-06-04 03:00:07',NULL,'2016-06-04 03:00:07'),(3,'Patient','5UIsiwaa7Lz9FJluQY8ALf-04pah9x8O','$2y$13$xcDY/NazzOuVC6ra4Of3ReQoKrgQkf/Offw1uyGVdgF7ArV7HgKoe',NULL,'patient@pathologylabs.com',3,1,0,2,'2016-06-04 03:01:08',NULL,'2016-06-04 03:01:08');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
