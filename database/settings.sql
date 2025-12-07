-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 11:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psk`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `type` enum('string','integer','boolean','json','text','email','url','image','color','password') NOT NULL DEFAULT 'string',
  `description` text DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `label`, `value`, `type`, `description`, `group`, `is_private`, `created_at`, `updated_at`) VALUES
(1, 'website_name', NULL, 'PSK Outfit', 'string', '', 'General', 0, '2025-12-06 23:16:39', '2025-12-06 23:16:39'),
(2, 'website_tag', NULL, 'Buy your favorite outfit', 'string', '', 'General', 0, '2025-12-06 23:17:18', '2025-12-06 23:17:18'),
(3, 'logo', NULL, 'settings/gAWvoTGhTFwNI9Zk8xcpmz8lso9pdvnlYDfb1sk5.png', 'image', '', 'General', 0, '2025-12-06 23:18:12', '2025-12-06 23:18:12'),
(4, 'white_logo', NULL, 'settings/z429wDv9qESAn95EswLejhoD7hOeV5c7OS6tpYAb.png', 'image', '', 'General', 0, '2025-12-06 23:20:18', '2025-12-06 23:20:18'),
(5, 'favicon', NULL, 'settings/WHWRcwUmTbUIoFyneJ41PiGkeZp5FPofQIGspSJD.png', 'image', '', 'General', 0, '2025-12-06 23:20:52', '2025-12-06 23:20:52'),
(6, 'phone', NULL, '+8801929190241', 'string', '', 'General', 0, '2025-12-06 23:21:35', '2025-12-06 23:21:35'),
(7, 'address', NULL, '37 W 24th St, New York, NY', 'string', '', 'General', 0, '2025-12-06 23:22:10', '2025-12-06 23:22:10'),
(8, 'email', NULL, 'support@mail.com', 'email', '', 'General', 0, '2025-12-06 23:22:42', '2025-12-06 23:22:42'),
(9, 'copyright', NULL, 'Copyright @ Zenis 2025. All right reserved.', 'string', '', 'General', 0, '2025-12-06 23:23:22', '2025-12-06 23:23:22'),
(10, 'footer_about', NULL, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi, distinctio molestiae error ullam obcaecati dolorem inventore.', 'text', '', 'General', 0, '2025-12-06 23:23:58', '2025-12-06 23:23:58'),
(11, 'footer_contact_text', NULL, 'It is a long established fact that reader distracted looking layout It is a long established fact.', 'text', '', 'General', 0, '2025-12-06 23:26:04', '2025-12-06 23:26:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`),
  ADD KEY `settings_group_index` (`group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
