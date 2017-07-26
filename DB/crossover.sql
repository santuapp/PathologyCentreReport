--
-- Database: `crossover`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1464762364),
('m130524_201442_init', 1464762369);

-- --------------------------------------------------------

--
-- Table structure for table `patient_details`
--

CREATE TABLE IF NOT EXISTS `patient_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fk_id` int(11) NOT NULL,
  `pass_code` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
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
  KEY `user_fk_id` (`user_fk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `patient_details`
--

INSERT INTO `patient_details` (`id`, `user_fk_id`, `pass_code`, `gender`, `dob`, `height`, `weight`, `blood_group`, `address`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 3, 'PL123', 'm', '1987-01-15', '5''11"', '73', 'B+', '', 2, '2016-06-04 03:01:08', NULL, '2016-06-04 03:01:08');

-- --------------------------------------------------------

--
-- Table structure for table `patient_reports`
--

CREATE TABLE IF NOT EXISTS `patient_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_fk_id` int(11) NOT NULL,
  `exam` varchar(255) NOT NULL,
  `referred_doctor` varchar(255) NOT NULL,
  `doctor_specialization` varchar(255) NOT NULL,
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
  KEY `patient_fk_id_2` (`patient_fk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `patient_reports`
--

INSERT INTO `patient_reports` (`id`, `patient_fk_id`, `exam`, `referred_doctor`, `doctor_specialization`, `prescription_image`, `prescrption_text`, `summary`, `status`, `is_deleted`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 'EX01', 'Dr Rupesh K Gupta', 'General Surgeon', NULL, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\r\n\r\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.\r\n\r\nQui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', 1, 0, 2, '2016-06-04 03:05:37', NULL, '2016-06-04 03:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `patient_tests`
--

CREATE TABLE IF NOT EXISTS `patient_tests` (
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
  KEY `tests_type_fk_id` (`tests_type_fk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `patient_tests`
--

INSERT INTO `patient_tests` (`id`, `patient_report_fk_id`, `tests_type_fk_id`, `test_result`, `is_deleted`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 1, 2, '90 mg/dL', 0, 2, '2016-06-04 03:07:09', NULL, '2016-06-04 03:07:09'),
(2, 1, 1, '80 mg/dL', 0, 2, '2016-06-04 03:07:23', NULL, '2016-06-04 03:07:23'),
(3, 1, 3, '15 g/dL', 0, 2, '2016-06-04 03:07:41', NULL, '2016-06-04 03:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `tests_type`
--

CREATE TABLE IF NOT EXISTS `tests_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `reference_interval` varchar(255) NOT NULL,
  `specimen_type` varchar(255) DEFAULT NULL,
  `testing_frequency` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tests_type`
--

INSERT INTO `tests_type` (`id`, `name`, `reference_interval`, `specimen_type`, `testing_frequency`, `comments`, `status`, `is_deleted`) VALUES
(1, 'Glucose, Fasting', '70-99 mg/dL', '', '', '3.86-5.45 mmol/L', 1, 0),
(2, 'Glucose, Random', '70-139 mg/dL', '', '', '3.86-7.66 mmol/L', 1, 0),
(3, 'Hemoglobin, Men', '13.3-17.7 g/dL', '', '', '133-177 g/L', 1, 0),
(4, 'Hemoglobin, Women', '11.7-15.7 g/dL', '', '', '117-157 g/L', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `user_type`, `status`, `is_deleted`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'Admin', 'biJ1m60OM5IpTtco7X4hUZ6hy65IBm6M', '$2y$13$1c0rxV4FSDS2R33ltmuV3.KDhv92XNwfEPEAxLQARIxT3fA5DPUFm', NULL, 'admin@pathologylabs.com', 1, 1, 0, 0, '0000-00-00 00:00:00', NULL, NULL),
(2, 'Operator', '34hhOw4_SAQVGh2o1gM1pW_xlLgca0Wu', '$2y$13$QF.GBGFWIsMJ3hSChgOC6uehFr.E.eWh39gCFgjU9jGj9XFBrrZiq', NULL, 'operator@pathologylabs.com', 2, 1, 0, 0, '2016-06-04 03:00:07', NULL, '2016-06-04 03:00:07'),
(3, 'Patient', '5UIsiwaa7Lz9FJluQY8ALf-04pah9x8O', '$2y$13$xcDY/NazzOuVC6ra4Of3ReQoKrgQkf/Offw1uyGVdgF7ArV7HgKoe', NULL, 'patient@pathologylabs.com', 3, 1, 0, 2, '2016-06-04 03:01:08', NULL, '2016-06-04 03:01:08');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_details`
--
ALTER TABLE `patient_details`
  ADD CONSTRAINT `patient_details_ibfk_1` FOREIGN KEY (`user_fk_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_reports`
--
ALTER TABLE `patient_reports`
  ADD CONSTRAINT `patient_reports_ibfk_1` FOREIGN KEY (`patient_fk_id`) REFERENCES `patient_details` (`id`);

--
-- Constraints for table `patient_tests`
--
ALTER TABLE `patient_tests`
  ADD CONSTRAINT `patient_tests_ibfk_1` FOREIGN KEY (`patient_report_fk_id`) REFERENCES `patient_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_tests_ibfk_2` FOREIGN KEY (`tests_type_fk_id`) REFERENCES `tests_type` (`id`);