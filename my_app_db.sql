-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 18, 2026 at 10:22 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-06-17-070531', 'App\\Database\\Migrations\\CreateRolesTable', 'default', 'App', 1781684335, 1),
(2, '2026-06-17-070532', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1781684335, 1),
(3, '2026-06-17-070533', 'App\\Database\\Migrations\\CreateUserProfilesTable', 'default', 'App', 1781684335, 1),
(4, '2026-06-17-070534', 'App\\Database\\Migrations\\CreatePasswordResetsTable', 'default', 'App', 1781684335, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Admin'),
(4, 'Manager'),
(3, 'Staff'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) UNSIGNED NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role_id`, `status`, `reset_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'System', 'Admin', 'admin@admin.com', '$2y$10$O6NU.d4gWvscaRFADNAUmOjBzhvc8.9inG6XRXapNUjv5vN5fcbSe', 1, 'active', NULL, '2026-06-17 06:10:00', '2026-06-17 06:10:00', NULL),
(3, 'abhi', 'mehta', 'abhi.mehta@gmail.com', '$2y$10$R0bNLzBLmxN4JG1dMDArCOavclqPbttElztx2eHyYl8sec0uVMeci', 2, 'active', 'db2d54964e134f7d368977b7e04ecb28', '2026-06-17 11:02:50', '2026-06-18 01:40:06', NULL),
(4, 'vrunda', 'parekh', 'vrunda6013@gmail.com', '$2y$10$vQVIiG.x/DNhVMetS4DEM.jcjiDdKUcbDG0tMsBARfJpS1bOevD9i', 2, 'active', NULL, '2026-06-17 23:35:22', '2026-06-18 01:39:15', NULL),
(5, 'dhvani', 'parekh', 'dhvani@gmail.com', '$2y$10$pP7W6aflJOQwiOGkBAAqkO8yTQoFZ7MoVRX3e9O1EB/zUH4SXYpga', 4, 'active', NULL, '2026-06-18 02:02:37', '2026-06-18 02:02:37', NULL),
(6, 'bhumi', 'parekh', 'bhumi@gmail.com', '$2y$10$Btumg9nDF5I0Jx0UJs/Q0Oq4mXHEkivHyHH4paV/UQGaivWfd8ZBa', 3, 'active', NULL, '2026-06-18 02:30:04', '2026-06-18 02:30:04', NULL),
(7, 'test', 'data', 'test@gmail.com', '$2y$10$6njLH842UXxLPLXtYE5BLuNN/hRTxncEGbu824eG4nRzfzf1PsW1G', 2, 'active', NULL, '2026-06-18 04:26:18', '2026-06-18 04:26:18', NULL),
(8, 'vrunda', 'parekh', 'vrundaparekh18@gmail.com', '$2y$10$Y2.2/6jC1HVG3qJYSgeOkOb3B2Ocb/kiGjXa3Z9BeXmToCOOAShpu', 2, 'active', NULL, '2026-06-18 04:27:40', '2026-06-18 04:27:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` text,
  `profile_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `dob`, `gender`, `address`, `profile_pic`) VALUES
(1, 1, '1990-01-01', 'male', 'Admin Headquarters', NULL),
(2, 3, '1997-10-03', 'male', 'vesu surat', '1781764663_da305b9d830c192a7574.jpg'),
(3, 4, '1997-10-20', 'female', '307, silver appartment', '1781759121_9e90e59bbff2f84bc87b.jpg'),
(4, 5, '2006-12-13', 'female', 'baroda', '1781769517_948b485ac7d337d813a5.jpg'),
(5, 6, '1980-08-07', 'female', '', '1781769604_437ff1030d46a7ba159b.jpg'),
(6, 7, '1995-10-11', 'other', '', '1781776578_dae4870fa5183be6fd8f.jpg'),
(7, 8, '1997-01-12', 'other', '', '1781776660_c489f7f41ce029230610.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
