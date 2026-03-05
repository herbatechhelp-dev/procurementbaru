-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 30, 2026 at 03:16 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pr_system_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_request_id` bigint UNSIGNED NOT NULL,
  `pr_item_id` bigint UNSIGNED DEFAULT NULL,
  `approver_id` bigint UNSIGNED DEFAULT NULL,
  `approver_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approval_type` enum('om','gm','procurement') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`id`, `purchase_request_id`, `pr_item_id`, `approver_id`, `approver_role`, `approval_type`, `status`, `notes`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-24 19:57:49', '2025-12-24 19:57:49'),
(2, 1, 1, 2, 'operational_manager', 'om', 'approved', 'Q', '2025-12-24 20:01:15', '2025-12-24 20:01:15', '2025-12-24 20:01:15'),
(3, 1, 1, 3, 'general_manager', 'gm', 'rejected', 'a', '2025-12-24 20:01:37', '2025-12-24 20:01:37', '2025-12-24 20:01:37'),
(4, 1, 1, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-24 20:38:34', '2025-12-24 20:38:34', '2025-12-24 20:38:34'),
(5, 1, 2, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-24 20:38:40', '2025-12-24 20:38:40', '2025-12-24 20:38:40'),
(6, 1, 1, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-24 20:38:57', '2025-12-24 20:38:57', '2025-12-24 20:38:57'),
(7, 1, 2, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-24 20:39:03', '2025-12-24 20:39:03', '2025-12-24 20:39:03'),
(8, 1, 1, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-24 20:43:22', '2025-12-24 20:43:22', '2025-12-24 20:43:22'),
(9, 1, 2, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-24 20:43:25', '2025-12-24 20:43:25', '2025-12-24 20:43:25'),
(10, 1, 1, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-24 21:09:07', '2025-12-24 21:09:07', '2025-12-24 21:09:07'),
(11, 2, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-25 04:43:57', '2025-12-25 04:43:57'),
(12, 2, 3, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 04:52:03', '2025-12-25 04:52:03', '2025-12-25 04:52:03'),
(13, 2, 3, 3, 'general_manager', 'gm', 'rejected', 'A', '2025-12-25 04:52:19', '2025-12-25 04:52:19', '2025-12-25 04:52:19'),
(14, 2, 3, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 04:52:52', '2025-12-25 04:52:52', '2025-12-25 04:52:52'),
(15, 2, 3, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-25 04:52:58', '2025-12-25 04:52:58', '2025-12-25 04:52:58'),
(16, 2, 3, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-25 04:53:09', '2025-12-25 04:53:09', '2025-12-25 04:53:09'),
(17, 3, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-25 04:59:01', '2025-12-25 04:59:01'),
(18, 4, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-25 06:30:34', '2025-12-25 06:30:34'),
(19, 4, 7, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 06:32:43', '2025-12-25 06:32:43', '2025-12-25 06:32:43'),
(20, 4, 8, 2, 'operational_manager', 'om', 'rejected', 'Masih kurang Qtynya', '2025-12-25 06:32:58', '2025-12-25 06:32:58', '2025-12-25 06:32:58'),
(21, 4, 9, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 06:33:11', '2025-12-25 06:33:11', '2025-12-25 06:33:11'),
(22, 4, 7, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-25 06:33:45', '2025-12-25 06:33:45', '2025-12-25 06:33:45'),
(23, 4, 9, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-25 06:33:48', '2025-12-25 06:33:48', '2025-12-25 06:33:48'),
(24, 4, 7, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-25 06:34:16', '2025-12-25 06:34:16', '2025-12-25 06:34:16'),
(25, 4, 9, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-25 06:34:19', '2025-12-25 06:34:19', '2025-12-25 06:34:19'),
(26, 4, 7, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 06:46:54', '2025-12-25 06:46:54', '2025-12-25 06:46:54'),
(27, 4, 8, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 06:47:00', '2025-12-25 06:47:00', '2025-12-25 06:47:00'),
(28, 4, 8, 3, 'general_manager', 'gm', 'rejected', 'X', '2025-12-25 06:47:13', '2025-12-25 06:47:13', '2025-12-25 06:47:13'),
(29, 4, 7, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-25 06:47:17', '2025-12-25 06:47:17', '2025-12-25 06:47:17'),
(30, 4, 7, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-25 06:51:27', '2025-12-25 06:51:27', '2025-12-25 06:51:27'),
(31, 3, 4, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 09:02:47', '2025-12-25 09:02:47', '2025-12-25 09:02:47'),
(32, 3, 5, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 09:02:50', '2025-12-25 09:02:50', '2025-12-25 09:02:50'),
(33, 3, 6, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-25 09:02:53', '2025-12-25 09:02:53', '2025-12-25 09:02:53'),
(34, 5, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 02:00:27', '2025-12-26 02:00:27'),
(35, 5, 10, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:00:47', '2025-12-26 02:00:47', '2025-12-26 02:00:47'),
(36, 5, 11, 2, 'operational_manager', 'om', 'rejected', 'ada reject', '2025-12-26 02:00:59', '2025-12-26 02:00:59', '2025-12-26 02:00:59'),
(38, 5, 13, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:01:05', '2025-12-26 02:01:05', '2025-12-26 02:01:05'),
(40, 5, 10, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:01:49', '2025-12-26 02:01:49', '2025-12-26 02:01:49'),
(41, 5, 13, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:01:51', '2025-12-26 02:01:51', '2025-12-26 02:01:51'),
(42, 5, 10, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-26 02:02:14', '2025-12-26 02:02:14', '2025-12-26 02:02:14'),
(43, 5, 13, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-26 02:02:17', '2025-12-26 02:02:17', '2025-12-26 02:02:17'),
(60, 12, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 02:36:04', '2025-12-26 02:36:04'),
(61, 12, 14, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:36:33', '2025-12-26 02:36:33', '2025-12-26 02:36:33'),
(62, 12, 14, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:36:51', '2025-12-26 02:36:51', '2025-12-26 02:36:51'),
(63, 12, 14, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-26 02:37:34', '2025-12-26 02:37:34', '2025-12-26 02:37:34'),
(64, 13, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 02:42:52', '2025-12-26 02:42:52'),
(65, 13, 15, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:43:21', '2025-12-26 02:43:21', '2025-12-26 02:43:21'),
(66, 13, 16, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:43:26', '2025-12-26 02:43:26', '2025-12-26 02:43:26'),
(67, 13, 18, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:43:32', '2025-12-26 02:43:32', '2025-12-26 02:43:32'),
(68, 13, 17, 2, 'operational_manager', 'om', 'rejected', 'apakah specs seperti ini  masuk dalam kebutuhan', '2025-12-26 02:44:07', '2025-12-26 02:44:07', '2025-12-26 02:44:07'),
(69, 14, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 02:44:18', '2025-12-26 02:44:18'),
(70, 13, 15, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:45:07', '2025-12-26 02:45:07', '2025-12-26 02:45:07'),
(71, 13, 18, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:45:14', '2025-12-26 02:45:14', '2025-12-26 02:45:14'),
(72, 13, 16, 3, 'general_manager', 'gm', 'rejected', 'Apakah Kabel LAN tidak kelebihan?', '2025-12-26 02:45:32', '2025-12-26 02:45:32', '2025-12-26 02:45:32'),
(73, 14, 17, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:46:04', '2025-12-26 02:46:04', '2025-12-26 02:46:04'),
(74, 14, 17, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:46:10', '2025-12-26 02:46:10', '2025-12-26 02:46:10'),
(75, 15, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 02:46:20', '2025-12-26 02:46:20'),
(76, 15, 16, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 02:46:46', '2025-12-26 02:46:46', '2025-12-26 02:46:46'),
(77, 15, 16, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 02:46:56', '2025-12-26 02:46:56', '2025-12-26 02:46:56'),
(78, 14, 17, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-26 02:47:06', '2025-12-26 02:47:06', '2025-12-26 02:47:06'),
(79, 15, 16, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-26 02:47:11', '2025-12-26 02:47:11', '2025-12-26 02:47:11'),
(81, 17, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 03:37:46', '2025-12-26 03:37:46'),
(82, 17, 21, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 03:38:18', '2025-12-26 03:38:18', '2025-12-26 03:38:18'),
(83, 17, 22, 2, 'operational_manager', 'om', 'rejected', 'A', '2025-12-26 04:10:28', '2025-12-26 04:10:28', '2025-12-26 04:10:28'),
(84, 18, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 04:11:26', '2025-12-26 04:11:26'),
(85, 18, 22, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 04:13:21', '2025-12-26 04:13:21', '2025-12-26 04:13:21'),
(86, 18, 22, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-26 04:13:55', '2025-12-26 04:13:55', '2025-12-26 04:13:55'),
(87, 19, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 04:29:02', '2025-12-26 04:29:02'),
(88, 20, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-26 04:29:02', '2025-12-26 04:29:02'),
(89, 19, 23, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-26 04:34:32', '2025-12-26 04:34:32', '2025-12-26 04:34:32'),
(90, 21, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 00:48:33', '2025-12-30 00:48:33'),
(91, 21, 25, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 01:14:51', '2025-12-30 01:14:51', '2025-12-30 01:14:51'),
(93, 21, 28, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 01:15:04', '2025-12-30 01:15:04', '2025-12-30 01:15:04'),
(94, 21, 27, 2, 'operational_manager', 'om', 'rejected', 'sd', '2025-12-30 01:15:08', '2025-12-30 01:15:08', '2025-12-30 01:15:08'),
(95, 21, 29, 2, 'operational_manager', 'om', 'rejected', 'd', '2025-12-30 01:15:12', '2025-12-30 01:15:12', '2025-12-30 01:15:12'),
(100, 25, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 01:22:49', '2025-12-30 01:22:49'),
(101, 25, 27, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 01:23:26', '2025-12-30 01:23:26', '2025-12-30 01:23:26'),
(102, 25, 29, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 01:23:29', '2025-12-30 01:23:29', '2025-12-30 01:23:29'),
(103, 25, 27, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 01:23:41', '2025-12-30 01:23:41', '2025-12-30 01:23:41'),
(104, 25, 29, 3, 'general_manager', 'gm', 'rejected', 'A', '2025-12-30 01:23:48', '2025-12-30 01:23:48', '2025-12-30 01:23:48'),
(106, 27, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 01:27:29', '2025-12-30 01:27:29'),
(107, 28, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 01:32:00', '2025-12-30 01:32:00'),
(108, 29, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 01:33:27', '2025-12-30 01:33:27'),
(109, 29, 36, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:01:34', '2025-12-30 02:01:34', '2025-12-30 02:01:34'),
(115, 32, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:11:03', '2025-12-30 02:11:03'),
(116, 32, 37, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:14:45', '2025-12-30 02:14:45', '2025-12-30 02:14:45'),
(117, 28, 32, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:31:18', '2025-12-30 02:31:18', '2025-12-30 02:31:18'),
(118, 28, 33, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:31:31', '2025-12-30 02:31:31', '2025-12-30 02:31:31'),
(119, 28, 34, 2, 'operational_manager', 'om', 'rejected', 'A', '2025-12-30 02:31:37', '2025-12-30 02:31:37', '2025-12-30 02:31:37'),
(120, 28, 35, 2, 'operational_manager', 'om', 'rejected', 'V', '2025-12-30 02:31:43', '2025-12-30 02:31:43', '2025-12-30 02:31:43'),
(121, 33, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:32:11', '2025-12-30 02:32:11'),
(122, 33, 34, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:32:34', '2025-12-30 02:32:34', '2025-12-30 02:32:34'),
(123, 33, 35, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:32:37', '2025-12-30 02:32:37', '2025-12-30 02:32:37'),
(124, 33, 34, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 02:33:11', '2025-12-30 02:33:11', '2025-12-30 02:33:11'),
(125, 33, 35, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 02:33:14', '2025-12-30 02:33:14', '2025-12-30 02:33:14'),
(126, 34, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:38:20', '2025-12-30 02:38:20'),
(127, 34, 38, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:38:34', '2025-12-30 02:38:34', '2025-12-30 02:38:34'),
(128, 32, 37, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 02:39:07', '2025-12-30 02:39:07', '2025-12-30 02:39:07'),
(129, 27, 31, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:42:27', '2025-12-30 02:42:27', '2025-12-30 02:42:27'),
(130, 27, 31, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 02:42:47', '2025-12-30 02:42:47', '2025-12-30 02:42:47'),
(131, 33, 34, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-30 02:45:17', '2025-12-30 02:45:17', '2025-12-30 02:45:17'),
(132, 33, 35, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-30 02:45:23', '2025-12-30 02:45:23', '2025-12-30 02:45:23'),
(133, 35, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:47:14', '2025-12-30 02:47:14'),
(134, 35, 39, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:49:19', '2025-12-30 02:49:19', '2025-12-30 02:49:19'),
(135, 35, 41, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:49:27', '2025-12-30 02:49:27', '2025-12-30 02:49:27'),
(136, 35, 42, 2, 'operational_manager', 'om', 'rejected', 'v', '2025-12-30 02:49:38', '2025-12-30 02:49:38', '2025-12-30 02:49:38'),
(137, 35, 40, 2, 'operational_manager', 'om', 'rejected', 'x', '2025-12-30 02:49:46', '2025-12-30 02:49:46', '2025-12-30 02:49:46'),
(138, 36, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:49:58', '2025-12-30 02:49:58'),
(139, 36, 40, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:52:47', '2025-12-30 02:52:47', '2025-12-30 02:52:47'),
(140, 36, 42, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:52:52', '2025-12-30 02:52:52', '2025-12-30 02:52:52'),
(141, 37, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:53:17', '2025-12-30 02:53:17'),
(142, 37, 43, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:55:03', '2025-12-30 02:55:03', '2025-12-30 02:55:03'),
(143, 37, 43, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 02:55:24', '2025-12-30 02:55:24', '2025-12-30 02:55:24'),
(149, 39, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 02:59:34', '2025-12-30 02:59:34'),
(150, 39, 29, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:59:50', '2025-12-30 02:59:50', '2025-12-30 02:59:50'),
(151, 39, 30, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 02:59:52', '2025-12-30 02:59:52', '2025-12-30 02:59:52'),
(152, 39, 29, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 03:00:05', '2025-12-30 03:00:05', '2025-12-30 03:00:05'),
(153, 39, 30, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 03:00:10', '2025-12-30 03:00:10', '2025-12-30 03:00:10'),
(154, 40, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 03:06:36', '2025-12-30 03:06:36'),
(155, 40, 44, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 03:08:08', '2025-12-30 03:08:08', '2025-12-30 03:08:08'),
(156, 40, 45, 2, 'operational_manager', 'om', 'approved', NULL, '2025-12-30 03:08:10', '2025-12-30 03:08:10', '2025-12-30 03:08:10'),
(157, 40, 46, 2, 'operational_manager', 'om', 'rejected', 'c', '2025-12-30 03:08:16', '2025-12-30 03:08:16', '2025-12-30 03:08:16'),
(158, 41, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2025-12-30 03:08:33', '2025-12-30 03:08:33'),
(159, 36, 40, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 03:12:51', '2025-12-30 03:12:51', '2025-12-30 03:12:51'),
(160, 36, 42, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 03:13:02', '2025-12-30 03:13:02', '2025-12-30 03:13:02'),
(161, 39, 29, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-30 03:13:23', '2025-12-30 03:13:23', '2025-12-30 03:13:23'),
(162, 39, 30, 4, 'procurement', 'procurement', 'approved', NULL, '2025-12-30 03:13:26', '2025-12-30 03:13:26', '2025-12-30 03:13:26'),
(163, 40, 44, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 04:32:46', '2025-12-30 04:32:46', '2025-12-30 04:32:46'),
(164, 40, 45, 3, 'general_manager', 'gm', 'approved', NULL, '2025-12-30 04:32:48', '2025-12-30 04:32:48', '2025-12-30 04:32:48'),
(165, 42, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 06:34:14', '2026-01-21 06:34:14'),
(166, 43, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 06:37:36', '2026-01-21 06:37:36'),
(167, 44, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 06:44:50', '2026-01-21 06:44:50'),
(168, 44, 49, 2, 'operational_manager', 'om', 'approved', NULL, '2026-01-21 06:49:28', '2026-01-21 06:49:28', '2026-01-21 06:49:28'),
(169, 45, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 07:07:42', '2026-01-21 07:07:42'),
(170, 45, 50, 8, 'operational_manager', 'om', 'approved', NULL, '2026-01-21 07:13:23', '2026-01-21 07:13:23', '2026-01-21 07:13:23'),
(171, 46, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 07:15:44', '2026-01-21 07:15:44'),
(172, 47, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 07:19:07', '2026-01-21 07:19:07'),
(173, 48, NULL, NULL, 'operational_manager', 'om', 'pending', NULL, NULL, '2026-01-21 08:08:21', '2026-01-21 08:08:21'),
(174, 44, 49, 3, 'general_manager', 'gm', 'approved', NULL, '2026-01-21 08:48:12', '2026-01-21 08:48:12', '2026-01-21 08:48:12'),
(175, 44, 49, 4, 'procurement', 'procurement', 'approved', NULL, '2026-01-21 09:41:58', '2026-01-21 09:41:58', '2026-01-21 09:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-proc@prsystem.com|127.0.0.1', 'i:1;', 1766714344),
('laravel-cache-proc@prsystem.com|127.0.0.1:timer', 'i:1766714344;', 1766714344),
('laravel-cache-qc@prhbt|127.0.0.1', 'i:1;', 1766730642),
('laravel-cache-qc@prhbt|127.0.0.1:timer', 'i:1766730642;', 1766730642),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:19:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"create pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"view pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"edit pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"delete pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"approve pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:9:\"reject pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:9:\"export pr\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:4;i:2;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"manage departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"view departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:18:\"create departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"edit departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"delete departments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"view dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"view reports\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}}s:5:\"roles\";a:5:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"superadmin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"procurement\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:4:\"user\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:19:\"operational_manager\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"general_manager\";s:1:\"c\";s:3:\"web\";}}}', 1769829250);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `code`, `name`, `manager`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Information Technology', NULL, NULL, 1, '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(2, 'HRD', 'Human Resource Development', NULL, NULL, 1, '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(3, 'FIN', 'Finance', NULL, NULL, 1, '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(4, 'PROD', 'Production', NULL, NULL, 1, '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(5, 'MKT', 'Marketing', NULL, NULL, 1, '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(6, 'QC', 'Quality Control', 'QC', NULL, 1, '2025-12-26 03:28:27', '2025-12-26 03:28:27'),
(7, 'QA', 'Quality Assurance', NULL, NULL, 1, '2026-01-21 06:31:56', '2026-01-21 06:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"4c268260-46be-45ea-bd24-914be3603ae8\",\"displayName\":\"Illuminate\\\\Notifications\\\\Events\\\\BroadcastNotificationCreated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:60:\\\"Illuminate\\\\Notifications\\\\Events\\\\BroadcastNotificationCreated\\\":3:{s:10:\\\"notifiable\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:41:\\\"App\\\\Notifications\\\\PrSubmittedNotification\\\":2:{s:15:\\\"purchaseRequest\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:26:\\\"App\\\\Models\\\\PurchaseRequest\\\";s:2:\\\"id\\\";i:48;s:9:\\\"relations\\\";a:2:{i:0;s:10:\\\"department\\\";i:1;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:2:\\\"id\\\";s:36:\\\"d1e1b4fa-04e2-449d-b39a-36e6efabec1f\\\";}s:4:\\\"data\\\";a:6:{s:5:\\\"pr_id\\\";i:48;s:9:\\\"pr_number\\\";s:18:\\\"PR-QA-007-20260121\\\";s:14:\\\"requester_name\\\";s:17:\\\"Quality Assurance\\\";s:7:\\\"message\\\";s:65:\\\"PR Baru PR-QA-007-20260121 telah diajukan oleh Quality Assurance.\\\";s:4:\\\"type\\\";s:6:\\\"new_pr\\\";s:3:\\\"url\\\";s:47:\\\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/48\\\";}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1768982901,\"delay\":null}', 0, NULL, 1768982901, 1768982901);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_25_010705_create_permission_tables', 1),
(5, '2025_12_25_014825_create_departments_table', 1),
(6, '2025_12_25_014852_create_purchase_requests_table', 1),
(7, '2025_12_25_014913_create_pr_items_table', 1),
(8, '2025_12_25_014941_create_approvals_table', 1),
(10, '2025_12_25_015500_add_fields_to_users_table', 1),
(11, '2025_12_25_094500_create_settings_table', 1),
(12, '2025_12_25_094501_create_uoms_table', 1),
(13, '2025_12_25_015020_create_notifications_table', 2),
(14, '2025_12_25_041921_add_procurement_timestamps_to_pr_items_table', 3),
(15, '2025_12_25_112217_add_processed_at_to_pr_items_table', 4),
(16, '2025_12_25_133000_change_due_date_to_string_in_pr_items_table', 5),
(17, '2025_12_30_074500_create_purposes_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 6),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('00deb1d2-6cc5-4a6d-b42c-9b4aeb3f72b9', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'kupat\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 03:08:10', '2025-12-30 03:08:10'),
('03199db8-a3a8-46d0-b11c-ddc358e20e1a', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"Item \'c\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 02:55:10', '2025-12-30 02:52:52', '2025-12-30 02:55:10'),
('07410ed0-98dd-4be7-a6f7-413a89eca9c0', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 8, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', '2026-01-21 07:07:32', '2026-01-21 06:49:28', '2026-01-21 07:07:32'),
('08d9fa01-40cc-4360-bed7-ac1f7f469c5b', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":28,\"pr_number\":\"PR-IT-007-20251230\",\"message\":\"Item \'Keyboard Logitech\' ditolak. Alasan: V\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/28\"}', '2025-12-30 02:33:07', '2025-12-30 02:31:43', '2025-12-30 02:33:07'),
('0933c32a-ea05-449d-94c5-3390738625a4', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":34,\"pr_number\":\"PR-IT-013-20251230\",\"message\":\"PR PR-IT-013-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/34\"}', '2025-12-30 02:38:52', '2025-12-30 02:38:34', '2025-12-30 02:38:52'),
('0cdd12a9-f191-414d-b3a1-ac243cc22add', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":47,\"pr_number\":\"PR-QA-006-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-006-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/47\"}', NULL, '2026-01-21 07:19:07', '2026-01-21 07:19:07'),
('0d3c6bfc-a3b5-4e71-b051-662f5b1bdcad', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"PR PR-IT-012-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:32:48', '2025-12-30 02:32:37', '2025-12-30 02:32:48'),
('0f7ffd63-63e1-4b5e-89a3-4e75f1c27362', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Mouse\' sedang dalam proses pemesanan (Ordered).\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:45:52', '2025-12-30 02:45:28', '2025-12-30 02:45:52'),
('10f2177e-df7d-4dc0-88b5-4a6b193916a3', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":27,\"pr_number\":\"PR-IT-006-20251230\",\"message\":\"Item \'Sample Containers\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/27\"}', '2025-12-30 02:42:32', '2025-12-30 02:42:27', '2025-12-30 02:42:32'),
('148d57b9-3bed-48af-9bbb-d15636d30867', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":41,\"pr_number\":\"PR-IT-020-20251230\",\"message\":\"Item yang ditolak dari PR-IT-019-20251230 telah dipindahkan ke PR baru PR-IT-020-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/41\"}', NULL, '2025-12-30 03:08:30', '2025-12-30 03:08:30'),
('17129599-e8e3-41f6-a417-df5e39d1b2f0', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 5, '{\"item_id\":2,\"item_name\":\"kupat\",\"pr_number\":\"HRD-001-20251225\",\"message\":\"Item kupat has been delivered.\"}', NULL, '2025-12-24 20:53:06', '2025-12-24 20:53:06'),
('1729ffea-ea85-4bb4-9ee3-8a06ca644eb6', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":37,\"pr_number\":\"PR-IT-016-20251230\",\"message\":\"Item \'A\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/37\"}', '2025-12-30 03:04:58', '2025-12-30 02:55:24', '2025-12-30 03:04:58'),
('1b75253d-f64d-4dcb-ab44-f15d62ce40f3', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":27,\"pr_number\":\"PR-IT-006-20251230\",\"message\":\"PR PR-IT-006-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/27\"}', '2025-12-30 02:42:43', '2025-12-30 02:42:27', '2025-12-30 02:42:43'),
('1b991ce4-415d-48cb-a79e-37222f3976c3', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 6, '{\"item_id\":14,\"item_name\":\"A\",\"pr_number\":\"PR-IT-251226-0003\",\"message\":\"Item A has been delivered.\"}', '2025-12-30 02:01:11', '2025-12-26 02:38:10', '2025-12-30 02:01:11'),
('1d95d08e-d614-41cf-b0b3-fa755619a1cd', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 1, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"PR PR-IT-019-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', '2025-12-30 07:46:25', '2025-12-30 04:32:48', '2025-12-30 07:46:25'),
('2658777b-2f9a-4805-8799-6e6283b5c4f5', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"PR PR-IT-012-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:43:32', '2025-12-30 02:33:14', '2025-12-30 02:43:32'),
('27f2c67c-a4f1-4bff-9e0a-3c5c8d9cee3d', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"Item \'B\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', NULL, '2025-12-30 03:12:51', '2025-12-30 03:12:51'),
('28d35dbc-bea1-465b-ba2b-2893bb6306c0', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Keyboard Logitech\' sedang dalam proses pemesanan (Ordered).\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:45:51', '2025-12-30 02:45:33', '2025-12-30 02:45:51'),
('2c8d63d5-dacc-4d11-9cbf-87ba1eb2f164', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":38,\"pr_number\":\"PR-IT-017-20251230\",\"message\":\"Item \'vgeg\' ditolak. Alasan: v\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/38\"}', '2025-12-30 02:59:32', '2025-12-30 02:59:22', '2025-12-30 02:59:32'),
('2d4f6cf4-b1a0-4539-b4f5-12bc424b5918', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":32,\"pr_number\":\"PR-IT-011-20251230\",\"message\":\"PR PR-IT-011-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/32\"}', '2025-12-30 02:43:29', '2025-12-30 02:39:07', '2025-12-30 02:43:29'),
('3347dc9d-7d7f-4350-97d2-9f88ef0bd68f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":32,\"pr_number\":\"PR-IT-011-20251230\",\"message\":\"Item \'AB\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/32\"}', '2025-12-30 02:37:09', '2025-12-30 02:14:45', '2025-12-30 02:37:09'),
('33defc35-e50f-4496-acec-be436bf4dcd2', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":45,\"pr_number\":\"PR-QA-004-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-004-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/45\"}', NULL, '2026-01-21 07:07:42', '2026-01-21 07:07:42'),
('3b4dd3c9-b0c3-424e-b2b3-bee16d28c09b', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 06:49:28', '2026-01-21 06:49:28'),
('3f6f071b-34d0-47f1-9d3e-e98b9b7c378f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item yang ditolak dari PR-IT-017-20251230 telah dipindahkan ke PR baru PR-IT-018-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:04:58', '2025-12-30 02:59:34', '2025-12-30 03:04:58'),
('4190496b-a0c4-4cdd-94c0-915568666c15', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":31,\"pr_number\":\"PR-IT-010-20251230\",\"message\":\"Item \'AB\' was rejected. Reason: X\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/31\"}', '2025-12-30 02:10:53', '2025-12-30 02:08:56', '2025-12-30 02:10:53'),
('475176e4-b213-464f-a316-2f4ecc4d6147', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":28,\"pr_number\":\"PR-IT-007-20251230\",\"message\":\"Item \'Mouse\' ditolak. Alasan: A\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/28\"}', '2025-12-30 02:37:02', '2025-12-30 02:31:37', '2025-12-30 02:37:02'),
('488d3fe5-9ea3-4041-b66f-605671401a80', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":37,\"pr_number\":\"PR-IT-016-20251230\",\"message\":\"PR PR-IT-016-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/37\"}', '2025-12-30 02:55:20', '2025-12-30 02:55:03', '2025-12-30 02:55:20'),
('4bbe0a21-a54f-4cb5-89b0-72da04effd00', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'A\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 04:32:46', '2025-12-30 04:32:46'),
('528cc1ea-c306-423a-9bf7-f3194358fd45', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":45,\"pr_number\":\"PR-QA-004-20260121\",\"message\":\"PR PR-QA-004-20260121 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/45\"}', '2026-01-21 09:41:26', '2026-01-21 07:13:23', '2026-01-21 09:41:26'),
('56a3ae32-0cb3-4301-be82-b935620cf1d1', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'vgeg\' sedang dalam proses pemesanan (Ordered).\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', NULL, '2025-12-30 04:32:02', '2025-12-30 04:32:02'),
('5d7e54e7-8b64-4ec7-82a2-8e960f5398e5', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 4, '{\"pr_id\":30,\"pr_number\":\"PR-IT-009-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"New PR PR-IT-009-20251230 submitted by IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/30\"}', '2025-12-30 02:43:33', '2025-12-30 02:02:11', '2025-12-30 02:43:33'),
('5f8bc1a5-df0b-4473-bfb5-7ec80afaf680', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":31,\"pr_number\":\"PR-IT-010-20251230\",\"message\":\"Your rejected items from PR-IT-009-20251230 have been moved to a new PR PR-IT-010-20251230 for revision.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/31\"}', '2025-12-30 02:07:01', '2025-12-30 02:04:30', '2025-12-30 02:07:01'),
('6176e00f-cac3-426e-bcb6-57ed320ac094', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":46,\"pr_number\":\"PR-QA-005-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-005-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/46\"}', NULL, '2026-01-21 07:15:44', '2026-01-21 07:15:44'),
('61dd8392-3d05-4f45-8e99-5ad7c930df7c', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'vgeg\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:00:31', '2025-12-30 02:59:50', '2025-12-30 03:00:31'),
('65fcd496-77e0-49cf-a2e6-8cc0ff65a74e', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":27,\"pr_number\":\"PR-IT-006-20251230\",\"message\":\"PR PR-IT-006-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/27\"}', '2025-12-30 02:43:27', '2025-12-30 02:42:47', '2025-12-30 02:43:27'),
('66072705-a890-4af9-b2f9-c9f4a192369a', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'kupat\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', '2025-12-30 07:46:26', '2025-12-30 04:32:48', '2025-12-30 07:46:26'),
('68cde241-af04-413e-9027-20ab193e7a15', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":35,\"pr_number\":\"PR-IT-014-20251230\",\"message\":\"Item \'c\' ditolak. Alasan: v\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/35\"}', '2025-12-30 03:04:58', '2025-12-30 02:49:38', '2025-12-30 03:04:58'),
('6b13b1ca-9d6b-447f-92dd-e499cffbafa0', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 6, '{\"item_id\":3,\"item_name\":\"Bakso 1\",\"pr_number\":\"IT-001-20251225\",\"message\":\"Item Bakso 1 has been delivered.\"}', '2025-12-30 02:01:17', '2025-12-25 04:53:39', '2025-12-30 02:01:17'),
('6b1f8a38-0285-45ca-b0e0-b5e01ef0ba12', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"Item \'B\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 03:04:58', '2025-12-30 02:52:47', '2025-12-30 03:04:58'),
('754c529c-bece-46f7-99aa-017d3f7c260f', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":32,\"pr_number\":\"PR-IT-011-20251230\",\"message\":\"PR PR-IT-011-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/32\"}', '2025-12-30 02:39:03', '2025-12-30 02:14:45', '2025-12-30 02:39:03'),
('76178d35-b0ef-4de6-b15b-23723be49833', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 1, '{\"pr_id\":45,\"pr_number\":\"PR-QA-004-20260121\",\"message\":\"PR PR-QA-004-20260121 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/45\"}', NULL, '2026-01-21 07:13:23', '2026-01-21 07:13:23'),
('77c38056-613f-4887-b7f5-2e3fb04568cf', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 5, '{\"item_id\":1,\"item_name\":\"Sample Containers\",\"pr_number\":\"HRD-001-20251225\",\"message\":\"Item Sample Containers has been delivered.\"}', NULL, '2025-12-25 04:24:04', '2025-12-25 04:24:04'),
('78e6d8c8-aff3-4a7e-ad2d-41515f5e8028', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"PR PR-QA-003-20260121 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', '2026-01-21 09:41:50', '2026-01-21 08:48:12', '2026-01-21 09:41:50'),
('79e57661-e669-4036-828c-5325643c0f84', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 3, '{\"pr_id\":34,\"pr_number\":\"PR-IT-013-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"PR Baru PR-IT-013-20251230 telah diajukan oleh IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/34\"}', '2025-12-30 02:38:54', '2025-12-30 02:38:20', '2025-12-30 02:38:54'),
('7ae40a1c-ab17-484e-bf8e-15e7311e84dc', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 5, '{\"item_id\":1,\"item_name\":\"Sample Containers\",\"pr_number\":\"HRD-001-20251225\",\"message\":\"Item Sample Containers has been delivered.\"}', NULL, '2025-12-25 04:23:53', '2025-12-25 04:23:53'),
('7ebf121e-8074-4d83-80a8-75f27d4c51dd', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":28,\"pr_number\":\"PR-IT-007-20251230\",\"message\":\"Item \'Monitor Xiaomi\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/28\"}', '2025-12-30 02:37:06', '2025-12-30 02:31:31', '2025-12-30 02:37:06'),
('8122613b-c7a4-4a85-b392-30b02be40af5', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 2, '{\"pr_id\":34,\"pr_number\":\"PR-IT-013-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"PR Baru PR-IT-013-20251230 telah diajukan oleh IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/34\"}', '2025-12-30 02:38:31', '2025-12-30 02:38:20', '2025-12-30 02:38:31'),
('8900d955-c2d1-40d5-814d-f60069d40696', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'vgeg\' sedang dalam proses pemesanan (Ordered).\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 04:32:27', '2025-12-30 04:32:02', '2025-12-30 04:32:27'),
('89c881ca-f87d-4f68-83a7-b2a5931e696a', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":38,\"pr_number\":\"PR-IT-017-20251230\",\"message\":\"Item \'s\' ditolak. Alasan: v\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/38\"}', '2025-12-30 02:59:30', '2025-12-30 02:59:25', '2025-12-30 02:59:30'),
('8b1db21b-9c0c-42ee-8b7a-cf7fcbe12c8b', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"PR PR-QA-003-20260121 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 06:49:28', '2026-01-21 06:49:28'),
('8d471101-0250-47ba-9d57-cb841f17df8d', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":42,\"pr_number\":\"PR-QA-001-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-001-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/42\"}', NULL, '2026-01-21 06:34:15', '2026-01-21 06:34:15'),
('8d4bf805-e2b2-494d-be04-1e7125f6d861', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'s\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:00:30', '2025-12-30 02:59:52', '2025-12-30 03:00:30'),
('8ef69999-f816-4f06-a915-7d90d842d4b3', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-003-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 06:44:50', '2026-01-21 06:44:50'),
('8f23831a-6a1c-4b72-8513-ac253a7ad211', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":27,\"pr_number\":\"PR-IT-006-20251230\",\"message\":\"Item \'Sample Containers\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/27\"}', '2025-12-30 02:42:51', '2025-12-30 02:42:47', '2025-12-30 02:42:51'),
('90d721b5-5238-4c2e-bc19-042054215fc7', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":35,\"pr_number\":\"PR-IT-014-20251230\",\"message\":\"Item \'B\' ditolak. Alasan: x\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/35\"}', '2025-12-30 02:49:49', '2025-12-30 02:49:46', '2025-12-30 02:49:49'),
('92dd3e70-1667-4f61-a50f-9ba9eb4b849f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item yang ditolak dari PR-IT-007-20251230 telah dipindahkan ke PR baru PR-IT-012-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:33:06', '2025-12-30 02:32:11', '2025-12-30 02:33:06'),
('9332e6d1-8525-4559-a0ff-41575c3d52bf', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":37,\"pr_number\":\"PR-IT-016-20251230\",\"message\":\"Item \'A\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/37\"}', '2025-12-30 02:55:05', '2025-12-30 02:55:03', '2025-12-30 02:55:05'),
('940157e4-0a83-45fa-ae0d-ee899ade6c6e', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 09:41:58', '2026-01-21 09:41:58'),
('9613f68f-eaf8-4d1a-8826-ca90740e3154', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'s\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:13:32', '2025-12-30 03:13:26', '2025-12-30 03:13:32'),
('961df93e-727e-40e8-9d08-5f0ee44c0b0c', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"PR PR-IT-015-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 03:13:07', '2025-12-30 03:13:02', '2025-12-30 03:13:07'),
('98541666-d96a-44b1-9fb7-c39b69ad8df6', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Keyboard Logitech\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:45:54', '2025-12-30 02:45:23', '2025-12-30 02:45:54'),
('98fa54f0-c793-4edd-8b21-5b1ebafb39e6', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":32,\"pr_number\":\"PR-IT-011-20251230\",\"message\":\"Item yang ditolak dari PR-IT-010-20251230 telah dipindahkan ke PR baru PR-IT-011-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/32\"}', '2025-12-30 02:11:17', '2025-12-30 02:11:03', '2025-12-30 02:11:17'),
('9a7ab94e-e6ce-4647-98c0-217a76d012f5', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"PR PR-IT-018-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:00:03', '2025-12-30 02:59:52', '2025-12-30 03:00:03'),
('9df6e272-935a-4de7-b00b-eebe85c3cd29', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":38,\"pr_number\":\"PR-IT-017-20251230\",\"message\":\"Item yang ditolak dari PR-IT-005-20251230 telah dipindahkan ke PR baru PR-IT-017-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/38\"}', '2025-12-30 02:58:15', '2025-12-30 02:58:14', '2025-12-30 02:58:15'),
('9e936d0c-6d49-4267-ab4a-043a3b1293ef', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":35,\"pr_number\":\"PR-IT-014-20251230\",\"message\":\"Item \'A\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/35\"}', '2025-12-30 03:04:58', '2025-12-30 02:49:19', '2025-12-30 03:04:58'),
('a338f286-9c15-4932-b1a3-14f02ff63584', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":26,\"pr_number\":\"PR-IT-005-20251230\",\"message\":\"Item \'vgeg\' ditolak. Alasan: X\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/26\"}', '2025-12-30 03:04:58', '2025-12-30 02:58:01', '2025-12-30 03:04:58'),
('a680343c-f218-4a2e-8662-d65af97544ab', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 8, '{\"pr_id\":45,\"pr_number\":\"PR-QA-004-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-004-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/45\"}', '2026-01-21 07:16:22', '2026-01-21 07:07:42', '2026-01-21 07:16:22'),
('a698e854-c7fa-4b08-bb6e-b406f00cccd3', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'A\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 03:08:08', '2025-12-30 03:08:08'),
('add828af-8ab0-4aa1-b10f-75fd529157b7', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":43,\"pr_number\":\"PR-QA-002-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-002-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/43\"}', NULL, '2026-01-21 06:37:36', '2026-01-21 06:37:36'),
('adf3a52b-e6d8-4a47-970d-3ad53e99ee68', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":26,\"pr_number\":\"PR-IT-005-20251230\",\"message\":\"Item \'s\' ditolak. Alasan: X\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/26\"}', '2025-12-30 02:58:09', '2025-12-30 02:58:06', '2025-12-30 02:58:09'),
('b263bb7e-eda4-4346-9634-1fc40be24f01', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"PR PR-IT-015-20251230 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 03:12:48', '2025-12-30 02:52:52', '2025-12-30 03:12:48'),
('b5580439-4b71-4783-83d0-ddf4d9d96078', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', '2026-01-21 09:24:01', '2026-01-21 08:48:12', '2026-01-21 09:24:01'),
('b6785876-51c5-4762-ad96-a254c30c8d2f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":34,\"pr_number\":\"PR-IT-013-20251230\",\"message\":\"Item \'Sample Containers\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/34\"}', '2025-12-30 02:42:07', '2025-12-30 02:38:34', '2025-12-30 02:42:07'),
('b6be9414-e477-4d5d-91cb-ed994d202664', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Keyboard Logitech\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:33:34', '2025-12-30 02:33:14', '2025-12-30 02:33:34'),
('bcafe8a7-e924-4699-b993-9047ff77d2c7', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 4, '{\"pr_id\":34,\"pr_number\":\"PR-IT-013-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"PR Baru PR-IT-013-20251230 telah diajukan oleh IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/34\"}', '2025-12-30 02:43:31', '2025-12-30 02:38:20', '2025-12-30 02:43:31'),
('c2e60e0b-5a67-4afe-b484-e0bf415552ef', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 3, '{\"pr_id\":30,\"pr_number\":\"PR-IT-009-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"New PR PR-IT-009-20251230 submitted by IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/30\"}', '2025-12-30 02:07:22', '2025-12-30 02:02:11', '2025-12-30 02:07:22'),
('c356d11e-b1f1-4204-8d64-57871c954e80', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'A\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', '2025-12-30 07:46:28', '2025-12-30 04:32:46', '2025-12-30 07:46:28'),
('c390401f-401e-47b9-82c7-1cb0f315cdb7', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":30,\"pr_number\":\"PR-IT-009-20251230\",\"message\":\"Item \'A\' was rejected. Reason: A\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/30\"}', '2025-12-30 02:03:09', '2025-12-30 02:02:51', '2025-12-30 02:03:09'),
('c556625a-6754-41eb-a2f2-8c0b82b7f57f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":32,\"pr_number\":\"PR-IT-011-20251230\",\"message\":\"Item \'AB\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/32\"}', '2025-12-30 02:42:04', '2025-12-30 02:39:07', '2025-12-30 02:42:04'),
('c7d4e58e-8734-491f-a132-7f341e10822e', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"PR PR-IT-018-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:13:09', '2025-12-30 03:00:10', '2025-12-30 03:13:09'),
('c9cd4a9b-a0e2-454a-9566-0b36dbbc975e', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":37,\"pr_number\":\"PR-IT-016-20251230\",\"message\":\"PR PR-IT-016-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/37\"}', NULL, '2025-12-30 02:55:24', '2025-12-30 02:55:24'),
('cb9fcac6-a9c6-4248-a393-f2be699dfe09', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 2, '{\"pr_id\":30,\"pr_number\":\"PR-IT-009-20251230\",\"requester_name\":\"IT SUPPORT\",\"message\":\"New PR PR-IT-009-20251230 submitted by IT SUPPORT.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/30\"}', '2025-12-30 02:04:52', '2025-12-30 02:02:11', '2025-12-30 02:04:52'),
('cde7b612-52cf-4211-8a10-6bf2576cea8e', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 3, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"PR PR-QA-003-20260121 menunggu persetujuan General Manager.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', '2026-01-21 06:50:32', '2026-01-21 06:49:28', '2026-01-21 06:50:32'),
('cfe02e49-0f5f-4869-9db7-9fd9ead50ab3', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'kupat\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 04:32:48', '2025-12-30 04:32:48'),
('d1495c89-59f4-4eba-9879-d2c943b93f85', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 1, '{\"pr_id\":45,\"pr_number\":\"PR-QA-004-20260121\",\"message\":\"Item \'a\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/45\"}', NULL, '2026-01-21 07:13:23', '2026-01-21 07:13:23'),
('d1e1b4fa-04e2-449d-b39a-36e6efabec1f', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":48,\"pr_number\":\"PR-QA-007-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-007-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/48\"}', NULL, '2026-01-21 08:08:21', '2026-01-21 08:08:21'),
('da50e33c-eb9d-42f8-b27f-cb423cdcf26f', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Keyboard Logitech\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:33:01', '2025-12-30 02:32:37', '2025-12-30 02:33:01'),
('daf2f792-f96c-47b7-81ed-70163d4c448c', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'vgeg\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:13:33', '2025-12-30 03:13:23', '2025-12-30 03:13:33'),
('dec0fb97-d5ad-4cb5-8590-24f3d00e8545', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 8, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 09:41:58', '2026-01-21 09:41:58'),
('e2e309cb-b661-4b66-bed8-c5bf88f44808', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'s\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:00:27', '2025-12-30 03:00:10', '2025-12-30 03:00:27'),
('e342fd86-42df-4284-bcf7-144e948c8928', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 1, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"PR PR-QA-003-20260121 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 08:48:12', '2026-01-21 08:48:12'),
('e404cbcd-64d9-47d8-b026-19155e9ed4af', 'App\\Notifications\\ItemDeliveredNotification', 'App\\Models\\User', 5, '{\"item_id\":1,\"item_name\":\"Sample Containers\",\"pr_number\":\"HRD-001-20251225\",\"message\":\"Item Sample Containers has been delivered.\"}', NULL, '2025-12-24 20:53:01', '2025-12-24 20:53:01'),
('e7bdf4fe-c201-4d94-80b5-23ddd040ebe3', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 1, '{\"pr_id\":46,\"pr_number\":\"PR-QA-005-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-005-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/46\"}', NULL, '2026-01-21 07:16:37', '2026-01-21 07:16:37'),
('eb30a925-dc07-4d43-8555-a25490847920', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Mouse\' telah disetujui oleh Procurement.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:45:55', '2025-12-30 02:45:17', '2025-12-30 02:45:55'),
('eb32c1aa-8dfe-4ff5-9c55-c862dc3498df', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"Item \'C\' ditolak. Alasan: c\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 03:08:16', '2025-12-30 03:08:16'),
('f1fdc701-4704-4ebe-968a-7417094d31cd', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":35,\"pr_number\":\"PR-IT-014-20251230\",\"message\":\"Item \'Krupuk\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/35\"}', '2025-12-30 03:04:58', '2025-12-30 02:49:27', '2025-12-30 03:04:58'),
('f64239b0-f466-465c-ab55-f866d52af897', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Mouse\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:37:01', '2025-12-30 02:33:11', '2025-12-30 02:37:01'),
('f68f3ed5-c351-4f8e-85d5-35255f2dfdee', 'App\\Notifications\\PrSubmittedNotification', 'App\\Models\\User', 8, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"requester_name\":\"Quality Assurance\",\"message\":\"PR Baru PR-QA-003-20260121 telah diajukan oleh Quality Assurance.\",\"type\":\"new_pr\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', '2026-01-21 06:49:14', '2026-01-21 06:44:50', '2026-01-21 06:49:14'),
('f799e1fe-82b2-4a15-ba14-d1ec50e145ef', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"Item \'c\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 03:13:35', '2025-12-30 03:13:02', '2025-12-30 03:13:35'),
('f7de0eb2-2fe0-4d15-bc1e-87a35923582a', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 8, '{\"pr_id\":44,\"pr_number\":\"PR-QA-003-20260121\",\"message\":\"Item \'x\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/44\"}', NULL, '2026-01-21 08:48:12', '2026-01-21 08:48:12'),
('fc9b9b62-13d4-49af-a726-991249474134', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":36,\"pr_number\":\"PR-IT-015-20251230\",\"message\":\"Item yang ditolak dari PR-IT-014-20251230 telah dipindahkan ke PR baru PR-IT-015-20251230 untuk direvisi.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/36\"}', '2025-12-30 03:04:58', '2025-12-30 02:49:58', '2025-12-30 03:04:58'),
('fd4df375-fa3b-4a93-ac38-46d9180116d0', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":28,\"pr_number\":\"PR-IT-007-20251230\",\"message\":\"Item \'SSD 4TB SATA\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/28\"}', '2025-12-30 02:37:07', '2025-12-30 02:31:19', '2025-12-30 02:37:07'),
('ff259fce-85ed-42ef-b274-320805ef93a9', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":39,\"pr_number\":\"PR-IT-018-20251230\",\"message\":\"Item \'vgeg\' telah disetujui oleh General Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/39\"}', '2025-12-30 03:00:28', '2025-12-30 03:00:05', '2025-12-30 03:00:28'),
('ff70208c-edd8-48c6-8637-03f7664702b6', 'App\\Notifications\\PrActionRequiredNotification', 'App\\Models\\User', 4, '{\"pr_id\":40,\"pr_number\":\"PR-IT-019-20251230\",\"message\":\"PR PR-IT-019-20251230 menunggu proses Procurement.\",\"type\":\"action_required\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/40\"}', NULL, '2025-12-30 04:32:48', '2025-12-30 04:32:48'),
('ffe42cfd-bcdb-41b0-96bb-2f5e12afc710', 'App\\Notifications\\PrStatusUpdatedNotification', 'App\\Models\\User', 6, '{\"pr_id\":33,\"pr_number\":\"PR-IT-012-20251230\",\"message\":\"Item \'Mouse\' telah disetujui oleh Operational Manager.\",\"type\":\"status_update\",\"url\":\"http:\\/\\/pr-system-rev2.test\\/purchase-requests\\/33\"}', '2025-12-30 02:33:03', '2025-12-30 02:32:34', '2025-12-30 02:33:03');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(2, 'view pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(3, 'edit pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(4, 'delete pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(5, 'approve pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(6, 'reject pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(7, 'export pr', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(8, 'manage users', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(9, 'view users', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(10, 'create users', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(11, 'edit users', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(12, 'delete users', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(13, 'manage departments', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(14, 'view departments', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(15, 'create departments', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(16, 'edit departments', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(17, 'delete departments', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(18, 'view dashboard', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(19, 'view reports', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `pr_items`
--

CREATE TABLE `pr_items` (
  `id` bigint UNSIGNED NOT NULL,
  `purchase_request_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `quantity` int NOT NULL,
  `uom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_price` decimal(15,2) DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `due_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved_om','rejected_om','approved_gm','rejected_gm','approved_proc','rejected_proc','ordered','delivered','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reject_reason` text COLLATE utf8mb4_unicode_ci,
  `rejected_by` bigint UNSIGNED DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `ordered_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `revision_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pr_items`
--

INSERT INTO `pr_items` (`id`, `purchase_request_id`, `item_name`, `description`, `quantity`, `uom`, `estimated_price`, `total_price`, `due_date`, `attachment`, `status`, `reject_reason`, `rejected_by`, `rejected_at`, `processed_at`, `ordered_at`, `delivered_at`, `completed_at`, `revision_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sample Containers', 'A', 10, 'BOX', 0.00, 0.00, '2025-12-26', 'pr-attachments/bywjuoI8pygyMb422NB0RteJbbfwbxmCQ4cwCtHP.pdf', 'completed', NULL, NULL, NULL, NULL, NULL, '2025-12-25 04:24:04', '2025-12-25 04:24:07', 1, '2025-12-24 19:57:49', '2025-12-25 04:24:07'),
(2, 1, 'kupat', 'e', 12, 'BOX', 0.00, 0.00, NULL, 'pr-attachments/4r3z7sol8sQ0kyHP2ZX9HPQRc5hJ89U8MtTunFk7.pdf', 'completed', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-24 19:57:49', '2025-12-24 20:56:38'),
(3, 2, 'Bakso 1', 'a', 1, 'BOX', 0.00, 0.00, '2025-12-26', 'pr-attachments/PXW7GlLHZAcXO40LODPQNgMKA8CkJCMv5cnRBC8Y.xlsx', 'completed', NULL, NULL, NULL, NULL, '2025-12-25 04:53:20', '2025-12-25 04:53:39', '2025-12-25 04:53:47', 1, '2025-12-25 04:43:57', '2025-12-25 04:53:47'),
(4, 3, 'A', 'A', 1, 'BOX', 0.00, 0.00, '2025-12-31', 'pr-attachments/nG8Qyy2wCdJZUw8Ra6XwRnViSTUD3YgSivl7rXmk.pdf', 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-25 04:59:01', '2025-12-25 09:02:47'),
(5, 3, 'B', 'B', 1, 'Pcs', 0.00, 0.00, '2025-12-31', 'pr-attachments/t4IrSr8ixFGt0MHmIrbu3s6VN86D0wyB0Pq6j38t.docx', 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-25 04:59:01', '2025-12-25 09:02:50'),
(6, 3, 'C', 'A', 1, 'Pcs', 0.00, 0.00, '2025-12-27', 'pr-attachments/uICFQzsINSF3TNbVmqBLBAyBpr5uuhZUR6LRrgGe.pdf', 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-25 04:59:01', '2025-12-25 09:02:53'),
(7, 4, 'A', 'adss', 1, 'Pcs', 0.00, 0.00, '2025-12-31', 'pr-attachments/tiYobxM55QpBrDNoGcnIdgnQWRaDkiU5rh2ZUjpk.pdf', 'ordered', NULL, NULL, NULL, NULL, '2025-12-25 08:37:16', NULL, NULL, 1, '2025-12-25 06:30:34', '2025-12-25 08:37:16'),
(8, 4, 'BV', 'sudah sesuai Specs', 1, 'BOX', 0.00, 0.00, 'urgent', 'pr-attachments/cBQiYZa8Zvc8HfYBhAPFiXCfkVKhxLQ9DWReC5l9.pdf', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-12-25 06:30:34', '2025-12-25 06:48:37'),
(9, 4, 'C', 'dafefef', 3, 'BOX', 0.00, 0.00, 'dibeikan', 'pr-attachments/JX8I9UX0BgqlA6DVWJa20FaGeGADcj8hFOWzF7nE.pdf', 'approved_proc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-25 06:30:34', '2025-12-25 06:34:19'),
(10, 5, 'A', 'Di lihat atcnya', 1, 'BOX', 0.00, 0.00, '2025-12-31', 'pr-attachments/kHr0c1rYcOLihtwzS4Mlazqle1hj5t7tEApD6yQ9.pdf', 'ordered', NULL, NULL, NULL, NULL, '2025-12-26 02:02:21', NULL, NULL, 0, '2025-12-26 02:00:27', '2025-12-26 02:02:21'),
(11, 5, 'B', 'Di lihat atcnya', 1, 'BOX', 0.00, 0.00, 'urgent', 'pr-attachments/aLMQBNoOYgQhob2pLDJzSb5CYdwkQuavtn0UXpEh.pdf', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-26 02:00:27', '2025-12-26 02:02:37'),
(13, 5, 'D', 'sesuai request', 1, 'BOX', 0.00, 0.00, 'segera', NULL, 'ordered', NULL, NULL, NULL, NULL, '2025-12-26 02:02:23', NULL, NULL, 0, '2025-12-26 02:00:27', '2025-12-26 02:02:23'),
(14, 12, 'A', '70', 10, 'BOX', 0.00, 0.00, '2025-12-31', 'pr-attachments/blvxbkgy9Qm4aVMY5fjmvA6DTp4RlK0OyzKmrLnq.pdf', 'completed', NULL, NULL, NULL, NULL, '2025-12-26 02:37:37', '2025-12-26 02:38:10', '2025-12-26 02:38:39', 2, '2025-12-26 02:32:51', '2025-12-26 02:38:39'),
(15, 13, 'PC', 'Disesuaikan Speksnya', 1, 'Unit', 0.00, 0.00, 'urgent', 'pr-attachments/NpKFkhLZ9arZY0nxO0O2eUKHBsWRAoEP6DlpOpu3.pdf', 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-26 02:42:52', '2025-12-26 02:45:07'),
(16, 15, 'Kabel Lan', 'Disesuaikan Speksnya', 2, 'Pcs', 0.00, 0.00, 'urgent', 'pr-attachments/bpAVZAFapT9VxsN62LcQBPJK30lOTKQhsjdYRifB.pdf', 'ordered', NULL, NULL, NULL, NULL, '2025-12-26 02:47:13', NULL, NULL, 1, '2025-12-26 02:42:52', '2025-12-26 02:47:13'),
(17, 14, 'SSD 4TB SATA', 'sesuai specs', 1, 'Unit', 0.00, 0.00, 'urgent', 'pr-attachments/dUHcNFtRVQadLbzp33zZCncbyqmUMAQGrRHgK7v9.pdf', 'ordered', NULL, NULL, NULL, NULL, '2025-12-26 02:47:18', NULL, NULL, 1, '2025-12-26 02:42:52', '2025-12-26 02:47:18'),
(18, 13, 'Monitor', 'sesuai speks', 1, 'Unit', 0.00, 0.00, 'segera', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-26 02:42:52', '2025-12-26 02:45:14'),
(21, 17, 'Alat Timbang', 'A', 1, 'Unit', 0.00, 0.00, '2025-12-31', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-26 03:37:46', '2025-12-26 03:38:18'),
(22, 18, 'Pipet +', 'AB', 1, 'Unit', 0.00, 0.00, '2025-12-31', 'pr-attachments/fUshwumQTcSSWtPX30Hk9wC6VhmYecWV3tLzKwjA.pdf', 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-26 03:37:46', '2025-12-26 04:13:55'),
(23, 19, 'Sample Containers', 'A', 1, 'Unit', 0.00, 0.00, '1 januari 2026', 'pr-attachments/IBZ3XQ5q1vi0UW3SBIGHxa8i6cEKkGOSX1XO1HvX.pdf', 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-26 04:29:02', '2025-12-26 04:34:32'),
(24, 20, 'Sample Containers', 'A', 1, 'Unit', 0.00, 0.00, '1 januari 2026', 'pr-attachments/BbVCr48odkSE6u49LNaQKakyuStfGsGbePFklBc1.pdf', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-26 04:29:02', '2025-12-26 04:29:02'),
(25, 21, 'Sample Containers', '1', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 00:48:33', '2025-12-30 01:14:51'),
(27, 25, 'Krupuk', '1', 1, 'Pcs', 0.00, 0.00, 'urgent', 'pr-attachments/OZAfhnEht9UNZwiEbSavSfzBw8PN6btU0s2Wj2KQ.pdf', 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-12-30 01:13:51', '2025-12-30 01:23:41'),
(28, 21, 'D', '1', 1, 'BOX', 0.00, 0.00, 'segera', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 01:14:42', '2025-12-30 01:15:04'),
(29, 39, 'vgeg', '1', 1, 'Pcs', 0.00, 0.00, '21/1/26', NULL, 'ordered', NULL, NULL, NULL, NULL, '2025-12-30 04:32:01', NULL, NULL, 5, '2025-12-30 01:14:42', '2025-12-30 04:32:01'),
(30, 39, 's', 'ev', 1, 'BOX', 0.00, 0.00, '2025-12-31', NULL, 'approved_proc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-12-30 01:24:12', '2025-12-30 03:13:26'),
(31, 27, 'Sample Containers', '1', 1, 'BOX', 0.00, 0.00, '2025-12-31', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 01:27:29', '2025-12-30 02:42:47'),
(32, 28, 'SSD 4TB SATA', 'Sesuai dengan file', 1, 'Unit', 0.00, 0.00, 'As soon As Posible', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 01:32:00', '2025-12-30 02:31:18'),
(33, 28, 'Monitor Xiaomi', 'Sesuai dengan file', 1, 'Unit', 0.00, 0.00, 'As soon As Posible', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 01:32:00', '2025-12-30 02:31:31'),
(34, 33, 'Mouse', 'Sesuai dengan file', 1, 'Unit', 0.00, 0.00, 'ASAP', NULL, 'ordered', NULL, NULL, NULL, NULL, '2025-12-30 02:45:28', NULL, NULL, 1, '2025-12-30 01:32:00', '2025-12-30 02:45:28'),
(35, 33, 'Keyboard Logitech', 'a', 1, 'Unit', 0.00, 0.00, 'segera', NULL, 'ordered', NULL, NULL, NULL, NULL, '2025-12-30 02:45:33', NULL, NULL, 1, '2025-12-30 01:32:00', '2025-12-30 02:45:33'),
(36, 29, 'Sample Containers', '1', 1, 'BOX', 0.00, 0.00, '21/1/26', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 01:33:27', '2025-12-30 02:01:34'),
(37, 32, 'AB', '12', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2025-12-30 01:37:10', '2025-12-30 02:39:07'),
(38, 34, 'Sample Containers', 'a', 1, 'Pcs', 0.00, 0.00, '2025-12-31', 'pr-attachments/lLSHuvVMzRpKvg7tC2SQMJb0AWzF7fIJ2QKM148X.jpg', 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 02:38:20', '2025-12-30 02:38:34'),
(39, 35, 'A', '1', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 02:47:14', '2025-12-30 02:49:19'),
(40, 36, 'B', '1', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-30 02:47:14', '2025-12-30 03:12:51'),
(41, 35, 'Krupuk', '1', 1, 'BOX', 0.00, 0.00, 'urgent', NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 02:47:14', '2025-12-30 02:49:27'),
(42, 36, 'c', '2', 3, 'BOX', 0.00, 0.00, 'segera', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-30 02:47:14', '2025-12-30 03:13:02'),
(43, 37, 'A', 'Q', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 02:53:17', '2025-12-30 02:55:24'),
(44, 40, 'A', '1', 1, 'Pcs', 0.00, 0.00, '1 januari 2026', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 03:06:36', '2025-12-30 04:32:46'),
(45, 40, 'kupat', '1', 1, 'Pcs', 0.00, 0.00, '2025-12-31', NULL, 'approved_gm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-12-30 03:06:36', '2025-12-30 04:32:48'),
(46, 41, 'C', '1', 1, 'BOX', 0.00, 0.00, 'dibeikan', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-12-30 03:06:36', '2025-12-30 03:08:30'),
(47, 42, 'Perawatan Mesin Timbang', NULL, 1, 'Unit', 0.00, 0.00, 'ASAP', NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 06:34:14', '2026-01-21 06:34:14'),
(48, 43, 'A', NULL, 1, 'BOX', 0.00, 0.00, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 06:37:36', '2026-01-21 06:37:36'),
(49, 44, 'x', NULL, 1, 'BOX', 0.00, 0.00, NULL, NULL, 'approved_proc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 06:44:50', '2026-01-21 09:41:58'),
(50, 45, 'a', NULL, 1, 'BOX', 0.00, 0.00, NULL, NULL, 'approved_om', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 07:07:42', '2026-01-21 07:13:23'),
(51, 46, 'vv', NULL, 100, 'Pcs', 0.00, 0.00, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 07:15:44', '2026-01-21 07:16:37'),
(52, 47, 'x', NULL, 1, 'BOX', 0.00, 0.00, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 07:19:07', '2026-01-21 07:19:07'),
(53, 48, 'y', NULL, 1, 'BOX', 0.00, 0.00, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-01-21 08:08:21', '2026-01-21 08:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_requests`
--

CREATE TABLE `purchase_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `pr_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `request_date` date NOT NULL,
  `purpose` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','pending','approved_om','rejected_om','approved_gm','rejected_gm','approved_proc','rejected_proc','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_requests`
--

INSERT INTO `purchase_requests` (`id`, `pr_number`, `user_id`, `department_id`, `request_date`, `purpose`, `status`, `total_amount`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'HRD-001-20251225', 5, 2, '2025-12-25', 'A', 'approved_proc', 0.00, NULL, '2025-12-24 19:57:49', '2025-12-24 20:43:25'),
(2, 'IT-001-20251225', 6, 1, '2025-12-25', 'sss', 'approved_proc', 0.00, NULL, '2025-12-25 04:43:57', '2025-12-25 04:53:09'),
(3, 'IT-002-20251225', 6, 1, '2025-12-25', 'CV', 'approved_om', 0.00, NULL, '2025-12-25 04:59:01', '2025-12-25 09:02:53'),
(4, 'IT-003-20251225', 6, 1, '2026-01-31', 'XCSDX', 'pending', 0.00, NULL, '2025-12-25 06:30:34', '2025-12-25 06:30:34'),
(5, 'IT-001-20251226', 6, 1, '2025-12-31', 'Untuk pengadaan APD dan Product Electrik', 'pending', 0.00, NULL, '2025-12-26 02:00:27', '2025-12-26 02:00:27'),
(12, 'PR-IT-251226-0003', 6, 1, '2025-12-26', 'Untuk pengadaan APD dan Product Electrik (Revision)', 'approved_proc', 0.00, 'Revision from IT-251227-20251226', '2025-12-26 02:36:04', '2025-12-26 02:37:34'),
(13, 'IT-251227-20251226', 6, 1, '2026-01-16', 'Pengadaan Aset Server Perusahaan', 'pending', 0.00, '\n[System] Item \'SSD 512 SATA\' revised to PR-IT-251226-0004.\n[System] Item \'Kabel Lan\' revised to PR-IT-251226-0005.', '2025-12-26 02:42:52', '2025-12-26 02:46:20'),
(14, 'PR-IT-251226-0004', 6, 1, '2025-12-26', 'Pengadaan Aset Server Perusahaan (Revision)', 'approved_proc', 0.00, 'Revision from IT-251227-20251226', '2025-12-26 02:44:18', '2025-12-26 02:47:06'),
(15, 'PR-IT-251226-0005', 6, 1, '2025-12-26', 'Pengadaan Aset Server Perusahaan (Revision)', 'approved_proc', 0.00, 'Revision from IT-251227-20251226', '2025-12-26 02:46:20', '2025-12-26 02:47:11'),
(17, 'PR-QC-001-20251226', 7, 6, '2025-12-31', 'Untuk pengadaan alat QC', 'pending', 0.00, '\n[System] Item \'Pipet\' revised to PR-QC-002-20251226.', '2025-12-26 03:37:46', '2025-12-26 04:11:26'),
(18, 'PR-QC-002-20251226', 7, 6, '2025-12-26', 'Untuk pengadaan alat QC (Revision)', 'approved_gm', 0.00, 'Revision from PR-QC-001-20251226', '2025-12-26 04:11:26', '2025-12-26 04:13:55'),
(19, 'PR-QC-003-20251226', 7, 6, '2025-12-31', 'XCSDX', 'approved_om', 0.00, NULL, '2025-12-26 04:29:02', '2025-12-26 04:34:32'),
(20, 'PR-QC-004-20251226', 7, 6, '2025-12-31', 'XCSDX', 'pending', 0.00, NULL, '2025-12-26 04:29:02', '2025-12-26 04:29:02'),
(21, 'PR-IT-001-20251230', 6, 1, '2025-12-30', 'Biaya Pembelian Packaging Material', 'pending', 0.00, '\n[System] Item \'LAN\' revised to PR-IT-002-20251230.\n[System] Items (Krupuk, vgeg) revised to PR-IT-003-20251230.', '2025-12-30 00:48:33', '2025-12-30 01:19:51'),
(25, 'PR-IT-004-20251230', 6, 1, '2025-12-30', 'Biaya Registrasi Produk', 'approved_om', 0.00, 'Bulk Revision from PR-IT-003-20251230\n[System] Items (vgeg) revised to PR-IT-005-20251230.', '2025-12-30 01:22:49', '2025-12-30 01:23:53'),
(27, 'PR-IT-006-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Raw Material', 'approved_gm', 0.00, NULL, '2025-12-30 01:27:29', '2025-12-30 02:42:47'),
(28, 'PR-IT-007-20251230', 6, 1, '2026-01-10', 'Beban Alat-alat dan Perlengkapan', 'pending', 0.00, '\n[System] Items (Mouse, Keyboard Logitech) revised to PR-IT-012-20251230.', '2025-12-30 01:32:00', '2025-12-30 02:32:11'),
(29, 'PR-IT-008-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Raw Material', 'approved_om', 0.00, NULL, '2025-12-30 01:33:27', '2025-12-30 02:01:34'),
(32, 'PR-IT-011-20251230', 6, 1, '2025-12-30', 'Biaya Pembelian Packaging Material', 'approved_gm', 0.00, 'Bulk Revision from PR-IT-010-20251230', '2025-12-30 02:11:03', '2025-12-30 02:39:07'),
(33, 'PR-IT-012-20251230', 6, 1, '2025-12-30', 'Beban Alat-alat dan Perlengkapan', 'approved_proc', 0.00, 'Bulk Revision from PR-IT-007-20251230', '2025-12-30 02:32:11', '2025-12-30 02:45:23'),
(34, 'PR-IT-013-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Packaging Material', 'approved_om', 0.00, NULL, '2025-12-30 02:38:20', '2025-12-30 02:38:34'),
(35, 'PR-IT-014-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Packaging Material', 'pending', 0.00, '\n[System] Items (B, c) revised to PR-IT-015-20251230.', '2025-12-30 02:47:14', '2025-12-30 02:49:58'),
(36, 'PR-IT-015-20251230', 6, 1, '2025-12-30', 'Biaya Pembelian Packaging Material', 'approved_gm', 0.00, 'Bulk Revision from PR-IT-014-20251230', '2025-12-30 02:49:58', '2025-12-30 03:13:02'),
(37, 'PR-IT-016-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Raw Material', 'approved_gm', 0.00, NULL, '2025-12-30 02:53:17', '2025-12-30 02:55:24'),
(39, 'PR-IT-018-20251230', 6, 1, '2025-12-30', 'Biaya Pembelian Raw Material', 'approved_proc', 0.00, 'Bulk Revision from PR-IT-017-20251230', '2025-12-30 02:59:34', '2025-12-30 03:13:26'),
(40, 'PR-IT-019-20251230', 6, 1, '2026-01-10', 'Biaya Pembelian Packaging Material', 'approved_gm', 0.00, '\n[System] Items (C) revised to PR-IT-020-20251230.', '2025-12-30 03:06:36', '2025-12-30 04:32:48'),
(41, 'PR-IT-020-20251230', 6, 1, '2025-12-30', 'Biaya Pembelian Packaging Material', 'pending', 0.00, 'Bulk Revision from PR-IT-019-20251230', '2025-12-30 03:08:30', '2025-12-30 03:08:33'),
(42, 'PR-QA-001-20260121', 8, 7, '2026-01-23', 'Biaya Kalibrasi', 'pending', 0.00, NULL, '2026-01-21 06:34:14', '2026-01-21 06:34:14'),
(43, 'PR-QA-002-20260121', 8, 7, '2026-01-21', 'Biaya Pembelian Raw Material', 'pending', 0.00, NULL, '2026-01-21 06:37:36', '2026-01-21 06:37:36'),
(44, 'PR-QA-003-20260121', 8, 7, '2026-01-21', 'Biaya Pembelian Raw Material', 'approved_proc', 0.00, NULL, '2026-01-21 06:44:50', '2026-01-21 09:41:58'),
(45, 'PR-QA-004-20260121', 8, 7, '2026-01-21', 'Biaya Pembelian Packaging Material', 'approved_om', 0.00, NULL, '2026-01-21 07:07:42', '2026-01-21 07:13:23'),
(46, 'PR-QA-005-20260121', 8, 7, '2026-01-23', 'Biaya Pembelian Packaging Material', 'pending', 0.00, NULL, '2026-01-21 07:15:44', '2026-01-21 07:15:44'),
(47, 'PR-QA-006-20260121', 8, 7, '2026-01-21', 'Biaya Pembelian Packaging Material', 'pending', 0.00, NULL, '2026-01-21 07:19:07', '2026-01-21 07:19:07'),
(48, 'PR-QA-007-20260121', 8, 7, '2026-01-21', 'Biaya Pembelian Packaging Material', 'pending', 0.00, NULL, '2026-01-21 08:08:21', '2026-01-21 08:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `purposes`
--

CREATE TABLE `purposes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purposes`
--

INSERT INTO `purposes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Biaya Pembelian Raw Material', '2025-12-30 00:48:07', '2025-12-30 00:48:07'),
(2, 'Biaya Pembelian Packaging Material', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(3, 'Biaya Pembuatan Sampel Produk', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(4, 'Biaya Pembuatan Sampel Kemasan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(5, 'Biaya Uji Eksternal NPD', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(6, 'Biaya Registrasi Produk', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(7, 'Biaya Panel Produk', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(8, 'Biaya Pengujian Material', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(9, 'Biaya Pengujian Packaging Material', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(10, 'Biaya Pengujian Produk Jadi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(11, 'Biaya Perawatan Alat dan Instrumen QC', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(12, 'Biaya Perbaikan Alat dan Instrumen QC', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(13, 'Biaya Sewa Gedung, Mesin dan Kendaraan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(14, 'Biaya Renovasi & Instalasi Bangunan Sewa', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(15, 'Biaya Perawatan Bangunan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(16, 'Biaya Perawatan Mesin dan Peralatan (supporting utility)', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(17, 'Biaya Perbaikan Mesin dan Peralatan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(18, 'Biaya Kalibrasi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(19, 'Biaya Perawatan Kendaraan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(20, 'Biaya Bongkar Muat', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(21, 'Biaya Pengiriman', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(22, 'Sertifikasi dan Audit', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(23, 'Biaya Telepon & Internet', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(24, 'Biaya listrik dan Air', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(25, 'Biaya Materai', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(26, 'Beban Alat-alat dan Perlengkapan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(27, 'Biaya Administrasi Bank', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(28, 'Biaya Transfer', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(29, 'Biaya BBM, Parkir & Tol', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(30, 'ATK dan P3K', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(31, 'Iuran Keanggotaan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(32, 'Biaya Perjalanan Dinas', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(33, 'Biaya Konsumsi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(34, 'Biaya software', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(35, 'Biaya CSR', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(36, 'Beban Operasional Rumah Tangga (Air minum, Gas, dll)', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(37, 'Beban Alat-alat dan Perlengkapan Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(38, 'Peralatan sanitasi Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(39, 'Baju Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(40, 'Sepatu Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(41, 'Masker Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(42, 'Hairnet Caps Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(43, 'Sarung Tangan Produksi', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(44, 'Pelatihan Karyawan', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(45, 'Outbond', '2025-12-30 00:52:37', '2025-12-30 00:52:37'),
(46, 'A', '2025-12-30 00:52:55', '2025-12-30 00:52:55');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(2, 'operational_manager', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(3, 'general_manager', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(4, 'procurement', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37'),
(5, 'user', 'web', '2025-12-24 19:55:37', '2025-12-24 19:55:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(2, 2),
(5, 2),
(6, 2),
(18, 2),
(2, 3),
(5, 3),
(6, 3),
(18, 3),
(1, 4),
(2, 4),
(3, 4),
(5, 4),
(6, 4),
(7, 4),
(18, 4),
(19, 4),
(1, 5),
(2, 5),
(3, 5),
(7, 5),
(18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('MO8hzZIOFGIBOUy4AmG1Oi0leXV1yOB6MzGfhT7d', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVDUzd3dqVTNFSDk2a0VPckhqZ240S0dCdzRKWXM5TWtTdUx1bU1XUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9wci1zeXN0ZW0tcmV2Mi50ZXN0L25vdGlmaWNhdGlvbnMvY2hlY2siO3M6NToicm91dGUiO3M6MTk6Im5vdGlmaWNhdGlvbnMuY2hlY2siO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NjE6Im5vdGlmaWNhdGlvbl9wb3B1cF9zaG93bl85NDAxNTdlNC0wYTgzLTQ1ZmEtYWUwZC1lZTg5OWFkZTZjNmUiO2I6MTt9', 1769742947);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'HBT PR', '2025-12-24 20:00:50', '2025-12-25 08:52:48'),
(2, 'app_logo', 'settings/hTPJy7Lmk0U5uVxpDksGwmickKD79tXljp9nfTED.png', '2025-12-24 21:10:22', '2025-12-24 21:10:22'),
(3, 'app_favicon', 'settings/B2M0SVOuhnLuPTRo3EFwM25uOXHoNTJv6DieD4OZ.png', '2025-12-24 21:10:22', '2025-12-24 21:10:22'),
(4, 'signature_om', 'settings/wQ9TksWmsQDJEd3JglXvdwhmkj1GeRBAulV3SFQ2.jpg', '2025-12-25 08:53:41', '2025-12-30 02:35:59'),
(5, 'signature_gm', 'settings/Psw956zJyX03CanDAFLHFVoDilWoqt5eKvE16G3q.jpg', '2025-12-25 08:58:35', '2025-12-30 02:35:59'),
(6, 'signature_proc', 'settings/YxDpmtAG0FGYcUQsMejhzlJrRLz0mpIpMzRWsUQE.png', '2025-12-25 08:59:07', '2025-12-25 08:59:34'),
(7, 'export_logo', 'settings/IJriB2tqwWbjUjTj5D3cy5K8gwjlOj0k8iV00niu.png', '2025-12-26 01:48:11', '2025-12-26 01:48:11');

-- --------------------------------------------------------

--
-- Table structure for table `uoms`
--

CREATE TABLE `uoms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uoms`
--

INSERT INTO `uoms` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'BOX', NULL, '2025-12-24 19:57:14', '2025-12-24 19:57:14'),
(2, 'Pcs', NULL, '2025-12-25 04:37:59', '2025-12-25 04:37:59'),
(3, 'Unit', NULL, '2025-12-26 02:40:00', '2025-12-26 02:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `employee_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `employee_id`, `department_id`, `phone`, `position`) VALUES
(1, 'Super Admin', 'superadmin@prsystem.com', NULL, '$2y$12$4usTjkDMn8wYJDlAG5Ida.cxh3lmnY5ebDBXrWwybzPHQTj0Fx.gq', NULL, '2025-12-24 19:55:38', '2025-12-24 19:55:38', 'SA001', 1, '081234567890', 'System Administrator'),
(2, 'Operational Manager', 'om@prsystem.com', NULL, '$2y$12$YBkdS2yLVBRFGt3Rhce7i.egNUX33UQvmTw02BIIWdXq4PFuMve0e', NULL, '2025-12-24 19:55:38', '2026-01-21 07:17:27', 'OM001', 4, '081234567891', 'Operational Manager'),
(3, 'Lisa Hana', 'gm@prsystem.com', NULL, '$2y$12$O.5qe9y4RA56a.TxdHO0lOMOkjlOYjXZA.Si8rmhmHubHkvoSDCKe', NULL, '2025-12-24 19:55:38', '2025-12-25 08:56:04', 'GM001', 1, '081234567892', 'General Manager'),
(4, 'Procurement Staff', 'procurement@prsystem.com', NULL, '$2y$12$EtWOgZijCSxcKdvCok6MCenEZLSI9NVTKrY6FIDVf27d06oxm/gCO', NULL, '2025-12-24 19:55:38', '2025-12-24 19:55:38', 'PROC001', 3, '081234567893', 'Procurement Staff'),
(5, 'Regular User', 'user@prsystem.com', NULL, '$2y$12$j7R4vfHp53l5IINvp.CRxOc.gAdjOMIFxEVoDAY19JxswwBIgWFWi', NULL, '2025-12-24 19:55:38', '2025-12-24 19:55:38', 'USR001', 2, '081234567894', 'Staff'),
(6, 'IT SUPPORT', 'its@hbt.id', NULL, '$2y$12$bEwkYVtAVJYd6OOQznMbKe/DpINWVbi7gByuOBAFrEVwoi40gteIq', NULL, '2025-12-25 04:33:50', '2025-12-25 04:33:50', '001', 1, '0898988', 'Spv'),
(7, 'Quality Control', 'qc@prhbt.id', NULL, '$2y$12$PCvHuX4QphD4ZOOjcUM7GOA8KGYXKvUXigT1g8oXEoRQJftqBvUrO', NULL, '2025-12-26 03:29:29', '2025-12-26 09:01:32', '01', 6, '089', 'SPV'),
(8, 'Quality Assurance', 'qa@hbt.id', NULL, '$2y$12$hS.DdemLnaZ916p.oPZ6zeQ7Um.tIxI8IkfTJUXWZdeuvUivlxv1e', NULL, '2026-01-21 06:32:27', '2026-01-21 06:32:27', '13', 7, NULL, NULL),
(9, 'Rifqi Aulawi Yunahar', 'operationalmanager@hbt.id', NULL, '$2y$12$A/hUgMHZT6azIHygJjmJGeV48d29p7Ota1QXt4WqhdqQc/v6ijsne', NULL, '2026-01-21 07:18:18', '2026-01-21 07:18:18', '111', 1, '08518238', 'Operational Manager');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approvals_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `approvals_pr_item_id_foreign` (`pr_item_id`),
  ADD KEY `approvals_approver_id_foreign` (`approver_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `pr_items`
--
ALTER TABLE `pr_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pr_items_purchase_request_id_foreign` (`purchase_request_id`),
  ADD KEY `pr_items_rejected_by_foreign` (`rejected_by`);

--
-- Indexes for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchase_requests_pr_number_unique` (`pr_number`),
  ADD KEY `purchase_requests_user_id_foreign` (`user_id`),
  ADD KEY `purchase_requests_department_id_foreign` (`department_id`);

--
-- Indexes for table `purposes`
--
ALTER TABLE `purposes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purposes_name_unique` (`name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `uoms`
--
ALTER TABLE `uoms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uoms_name_unique` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_employee_id_unique` (`employee_id`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `pr_items`
--
ALTER TABLE `pr_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `purposes`
--
ALTER TABLE `purposes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `uoms`
--
ALTER TABLE `uoms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_approver_id_foreign` FOREIGN KEY (`approver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `approvals_pr_item_id_foreign` FOREIGN KEY (`pr_item_id`) REFERENCES `pr_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `approvals_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pr_items`
--
ALTER TABLE `pr_items`
  ADD CONSTRAINT `pr_items_purchase_request_id_foreign` FOREIGN KEY (`purchase_request_id`) REFERENCES `purchase_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pr_items_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `purchase_requests`
--
ALTER TABLE `purchase_requests`
  ADD CONSTRAINT `purchase_requests_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
