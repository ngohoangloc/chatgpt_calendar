-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2025 at 06:04 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatgpt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('4atcjpi5209m984nj4uglq9tmqi9epos', '::1', 1736869438, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836393433383b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('6sfpu0t5goo98qrkvtflsjc7blgfsuan', '::1', 1736867843, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836373834333b6c6f67696e7c623a313b),
('7qjf3mkbdiva1ih7td8i5meh7plg2ep4', '::1', 1736868757, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836383735373b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('85e0b3pjeeuah45s8lnm5q14rdsuot3e', '::1', 1736866478, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836363437383b),
('9j4ni0emghcsefv3jlakaqves84mkj6g', '::1', 1736869816, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836393831363b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('e0ep3i5pldko1nrte4hns1evh84j79aq', '::1', 1736872670, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363837323637303b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('hi49m9qeoad9smsmm8oruro4imic13ji', '::1', 1736865986, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836353938363b),
('hos6l9po221p3bm5fmoqo0k7db690k26', '::1', 1736872844, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363837323637303b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('kbue6fdduldfafbuja0uo927ec31i2ur', '::1', 1736867179, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836373137393b6c6f67696e7c623a313b),
('pguhl0k8tm1hhj3ch2s3qt3it69b4smi', '::1', 1736868443, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836383434333b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b),
('uc5i8fc1no2t9qsv39lif8cja7gn24it', '::1', 1736867505, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363836373530353b6c6f67696e7c623a313b),
('vvm1jpd3o8c5na598llc83r4c9m5jun3', '::1', 1736870175, 0x5f5f63695f6c6173745f726567656e65726174657c693a313733363837303137353b6c6f67696e7c623a313b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` varchar(36) COLLATE utf8mb4_swedish_ci NOT NULL,
  `title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `model` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `mode` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `created_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `role` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `function_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `function_arguments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci,
  `timestamp` datetime NOT NULL,
  `conversation` varchar(36) COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ADMIN', '2025-01-14 17:03:10', '2025-01-14 17:03:10', NULL),
(2, 'Giáo viên', '2025-01-14 17:03:10', '2025-01-14 17:03:10', NULL),
(3, 'Phụ huynh', '2025-01-14 17:03:10', '2025-01-14 17:03:10', NULL),
(4, 'Học sinh', '2025-01-14 17:03:10', '2025-01-14 17:03:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setting_meta`
--

CREATE TABLE `setting_meta` (
  `id` int UNSIGNED NOT NULL,
  `setting_id` int UNSIGNED NOT NULL,
  `setting_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int UNSIGNED NOT NULL DEFAULT '4',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `name`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'nhloc@nctu.edu.vn', 'Lộc Ngô Hoàng', 1, '2025-01-14 17:08:02', '2025-01-14 17:31:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_conversation` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation` (`conversation`),
  ADD KEY `fk_user_message` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_setting_role` (`role_id`);

--
-- Indexes for table `setting_meta`
--
ALTER TABLE `setting_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_setting_meta` (`setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_meta`
--
ALTER TABLE `setting_meta`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `fk_user_conversation` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_user_message` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `fk_setting_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `setting_meta`
--
ALTER TABLE `setting_meta`
  ADD CONSTRAINT `fk_setting_meta` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
