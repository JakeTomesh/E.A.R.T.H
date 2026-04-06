-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 14, 2026 at 05:12 PM
-- Server version: 8.0.43
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `earth`
--

-- --------------------------------------------------------

--
-- Table structure for table `AlertLog`
--

CREATE TABLE `AlertLog` (
  `id` int UNSIGNED NOT NULL,
  `emission_type_id` int UNSIGNED NOT NULL,
  `co2e_quantity` decimal(18,4) NOT NULL,
  `co2e_unit_type_id` int UNSIGNED NOT NULL DEFAULT '10',
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `emission_log_id` int UNSIGNED NOT NULL,
  `threshold_limit_id` int UNSIGNED NOT NULL,
  `licensee_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `AlertLog`
--

INSERT INTO `AlertLog` (`id`, `emission_type_id`, `co2e_quantity`, `co2e_unit_type_id`, `message`, `date_created`, `emission_log_id`, `threshold_limit_id`, `licensee_id`) VALUES
(13, 5, 336.7700, 10, 'Refrigerant leakage from cooling systems exceeds threshold.', '2026-03-08 16:16:35', 37, 8, 2),
(14, 5, 626.4000, 10, 'Refrigerant leakage from cooling systems exceeds threshold.', '2026-03-08 17:41:44', 78, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `BaseUnitType`
--

CREATE TABLE `BaseUnitType` (
  `id` int NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `BaseUnitType`
--

INSERT INTO `BaseUnitType` (`id`, `code`) VALUES
(4, 'CO2E'),
(1, 'ENERGY'),
(3, 'MASS'),
(2, 'VOLUME');

-- --------------------------------------------------------

--
-- Table structure for table `EarthUser`
--

CREATE TABLE `EarthUser` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_type_id` int UNSIGNED NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT NULL,
  `licensee_id` int NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `EarthUser`
--

INSERT INTO `EarthUser` (`id`, `email`, `first_name`, `last_name`, `username`, `password_hash`, `role_type_id`, `date_created`, `date_updated`, `licensee_id`, `is_active`) VALUES
(1, 'ops.engineer@example.com', 'Alex', 'Rivera', 'ARivera', '$2y$10$89ex1Tsx0h.RiYQj84h/O.3TVOTMqSE8U6yFmUnN2sNksV/6.hmC.', 1, '2026-01-22 17:43:12', '2026-02-23 21:47:36', 1, 0),
(2, 'sustainability@example.com', 'Sam', 'Nguyen', 'SNguyen', '$2y$10$C4.W9xswYsVdJlMuNneiHuGSc1zhmJLgXjtBdjgupRInMuS/7PyjS', 1, '2026-01-22 17:43:12', '2026-02-23 21:52:34', 1, 1),
(3, 'facility.manager@example.com', 'Jamie', 'Patel', 'JPatel', '$2y$10$qJe7xUdV7Y1GXsv41/BWDutroQViO8/cJlZi77olYEE8indWvY24G', 1, '2026-01-22 17:43:12', '2026-02-23 21:54:26', 2, 1),
(4, 'admin@example.com', 'Casey', 'Morgan', 'CMorgan', '$2y$10$K3axOq6AVP3xEBJjn4fPdOFWX8ZT0sICPm5uK8Rq8KW5lPxoMPFH2', 2, '2026-01-22 17:43:12', '2026-02-23 21:53:44', 3, 1),
(11, 'test@test.com', 'Jake', 'Tomesh', 'JTomesh', '$2y$10$JWCgf8XrR70CKrIu3dWdoePPQ4RGcuVjPSK5F6oNUe4yKFwuU4hPS', 2, '2026-01-28 21:08:01', '2026-02-06 21:46:08', 1, 1),
(16, 'JDoe@test.com', 'John', 'Doe', 'JDoe', '$2y$10$uSg2bRTZrbdy3iiVRiGWkueg2.JZtH2cPUrFaANBNUMya2Xga17be', 1, '2026-01-30 22:00:45', '2026-02-23 21:10:42', 1, 0),
(19, 'Abangsberg@test.com', 'Andy', 'Bangsberg', 'ABangsberg', '$2y$10$Uw7AhJGQgkJ8BSnwhMaxRuH4NGphpSHKyQgN7/F7bLIlYfgvyj7Z.', 2, '2026-03-08 15:42:20', '2026-03-08 15:42:20', 2, 1),
(20, 'JRybacki@test.com', 'Jeff', 'Rybacki', 'JRybacki', '$2y$10$AMTagwTmqio3.8Bkebm6kOs8Bv.7njk6lZFFEmi79ZQBhdCKcx4cG', 1, '2026-03-08 15:47:51', '2026-03-08 15:47:51', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `EmissionFactor`
--

CREATE TABLE `EmissionFactor` (
  `id` int UNSIGNED NOT NULL,
  `emission_type_id` int UNSIGNED NOT NULL,
  `physical_unit_type_id` int UNSIGNED NOT NULL,
  `co2e_unit_type_id` int UNSIGNED NOT NULL DEFAULT '10',
  `licensee_id` int NOT NULL,
  `factor` decimal(18,6) NOT NULL,
  `date_updated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `EmissionFactor`
--

INSERT INTO `EmissionFactor` (`id`, `emission_type_id`, `physical_unit_type_id`, `co2e_unit_type_id`, `licensee_id`, `factor`, `date_updated`) VALUES
(1, 1, 1, 10, 1, 0.400000, '2026-02-18'),
(2, 2, 1, 10, 1, 0.000000, '2026-02-18'),
(3, 4, 5, 10, 1, 2.680000, '2025-01-01'),
(4, 5, 8, 10, 1, 2088.000000, '2025-01-01'),
(10, 6, 5, 10, 1, 0.000500, '2026-03-02'),
(11, 3, 1, 10, 1, 0.180900, '2026-03-02'),
(12, 7, 8, 10, 1, 0.020000, '2026-03-02'),
(13, 8, 8, 10, 1, 0.640000, '2026-03-02'),
(14, 1, 1, 10, 2, 0.400000, '2026-02-18'),
(15, 2, 1, 10, 2, 0.004000, '2026-03-06'),
(16, 3, 1, 10, 2, 0.180900, '2026-03-02'),
(17, 4, 5, 10, 2, 2.680000, '2025-01-01'),
(18, 5, 8, 10, 2, 2088.000000, '2025-01-01'),
(19, 6, 5, 10, 2, 0.000500, '2026-03-02'),
(20, 7, 8, 10, 2, 0.020000, '2026-03-02'),
(21, 8, 8, 10, 2, 0.640000, '2026-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `EmissionLog`
--

CREATE TABLE `EmissionLog` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `emission_type_id` int UNSIGNED NOT NULL,
  `physical_quantity` decimal(18,4) NOT NULL,
  `unit_type_id` int UNSIGNED NOT NULL,
  `notes` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emission_start_date` date NOT NULL,
  `emission_end_date` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `co2e_quantity` decimal(18,4) NOT NULL,
  `co2e_unit_type_id` int UNSIGNED NOT NULL DEFAULT '10',
  `emission_factor_id` int UNSIGNED NOT NULL,
  `licensee_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `EmissionLog`
--

INSERT INTO `EmissionLog` (`id`, `user_id`, `emission_type_id`, `physical_quantity`, `unit_type_id`, `notes`, `emission_start_date`, `emission_end_date`, `date_created`, `co2e_quantity`, `co2e_unit_type_id`, `emission_factor_id`, `licensee_id`) VALUES
(17, 16, 1, 9082.0000, 1, 'Weekend power usage from grid.', '2026-02-06', '2026-02-08', '2026-03-06 17:02:13', 3632.8000, 10, 1, 1),
(18, 11, 1, 100.0000, 2, '', '2026-03-01', '2026-03-06', '2026-03-06 18:24:08', 40000.0000, 10, 14, 2),
(19, 11, 3, 177.0000, 12, '', '2026-02-09', '2026-02-13', '2026-03-06 18:24:35', 9383.9300, 10, 16, 2),
(20, 11, 4, 200.0000, 6, '', '2026-02-16', '2026-02-20', '2026-03-06 18:24:53', 2028.9800, 10, 17, 2),
(21, 11, 6, 16000.0000, 5, '', '2026-02-07', '2026-02-10', '2026-03-06 18:25:15', 8.0000, 10, 19, 2),
(22, 11, 8, 590.0000, 9, '', '2026-03-06', '2026-03-06', '2026-03-06 18:25:32', 171.2800, 10, 21, 2),
(23, 20, 1, 34.5000, 1, 'Single day energy usage.', '2026-03-01', '2026-03-01', '2026-03-08 16:07:26', 13.8000, 10, 14, 2),
(24, 20, 1, 31.2000, 1, 'Daily energy usage.', '2026-03-02', '2026-03-08', '2026-03-08 16:08:04', 12.4800, 10, 14, 2),
(25, 20, 1, 40.2000, 1, 'Daily energy usage.', '2026-03-03', '2026-03-03', '2026-03-08 16:08:26', 16.0800, 10, 14, 2),
(26, 20, 3, 2.6000, 4, 'Combustion heating daily useage.', '2026-03-04', '2026-03-04', '2026-03-08 16:11:19', 13.7800, 10, 16, 2),
(27, 20, 3, 2.3000, 4, 'Combustion heating daily useage.', '2026-03-05', '2026-03-05', '2026-03-08 16:11:32', 12.1900, 10, 16, 2),
(28, 20, 1, 245.0000, 1, 'Weekly energy usage.', '2026-02-22', '2026-02-28', '2026-03-08 16:12:12', 98.0000, 10, 14, 2),
(29, 20, 3, 18.4000, 4, 'Weekly heating natural gas usage.', '2026-02-22', '2026-02-28', '2026-03-08 16:12:48', 97.5500, 10, 16, 2),
(30, 20, 8, 12.0000, 8, 'Weekly waste  to landfill.', '2026-02-22', '2026-02-28', '2026-03-08 16:13:14', 7.6800, 10, 21, 2),
(31, 20, 1, 267.0000, 1, 'Weekly energy usage.', '2026-02-15', '2026-02-21', '2026-03-08 16:13:38', 106.8000, 10, 14, 2),
(32, 20, 5, 3.6000, 8, 'Weekly coolant leakage amount.', '2026-02-15', '2026-02-21', '2026-03-08 16:14:11', 7516.8000, 10, 18, 2),
(33, 20, 3, 21.5000, 4, 'Weekly natural gas usage.', '2026-02-15', '2026-02-21', '2026-03-08 16:14:33', 113.9900, 10, 16, 2),
(34, 20, 8, 12.0000, 8, 'Weekly waste to landfill.', '2026-02-15', '2026-02-21', '2026-03-08 16:14:53', 7.6800, 10, 21, 2),
(35, 20, 1, 1040.0000, 1, 'Monthly energy usage.', '2026-01-01', '2026-01-31', '2026-03-08 16:15:27', 416.0000, 10, 14, 2),
(36, 20, 3, 88.0000, 4, 'Monthly gas combustion usage.', '2026-01-01', '2026-01-31', '2026-03-08 16:15:59', 466.5500, 10, 16, 2),
(37, 20, 5, 5.0000, 8, 'Monthly coolant leakage amount.', '2026-01-01', '2026-01-31', '2026-03-08 16:16:35', 10440.0000, 10, 18, 2),
(38, 20, 6, 1640.0000, 6, 'Daily water usage for cooling.', '2026-03-01', '2026-03-01', '2026-03-08 16:20:23', 3.1000, 10, 19, 2),
(39, 20, 6, 1922.0000, 6, 'Daily water usage for cooling.', '2026-03-02', '2026-03-02', '2026-03-08 16:20:38', 3.6400, 10, 19, 2),
(40, 20, 6, 1672.0000, 6, 'Daily water usage for cooling.', '2026-03-03', '2026-03-03', '2026-03-08 16:20:51', 3.1600, 10, 19, 2),
(41, 20, 6, 1845.0000, 6, 'Daily water usage for cooling.', '2026-03-04', '2026-03-04', '2026-03-08 16:21:06', 3.4900, 10, 19, 2),
(42, 20, 6, 1388.0000, 6, 'Daily water usage for cooling.', '2026-03-05', '2026-03-05', '2026-03-08 16:21:18', 2.6300, 10, 19, 2),
(43, 20, 6, 1866.0000, 6, 'Daily water usage for cooling.', '2026-03-05', '2026-03-05', '2026-03-08 16:21:33', 3.5300, 10, 19, 2),
(44, 20, 6, 1722.0000, 6, 'Daily water usage for cooling.', '2026-03-06', '2026-03-06', '2026-03-08 16:21:53', 3.2600, 10, 19, 2),
(45, 20, 6, 1344.0000, 6, 'Daily water usage for cooling.', '2026-03-07', '2026-03-07', '2026-03-08 16:22:05', 2.5400, 10, 19, 2),
(46, 20, 6, 11855.0000, 6, 'Weekly water usage for cooling.', '2026-02-15', '2026-02-21', '2026-03-08 16:22:27', 22.4400, 10, 19, 2),
(47, 20, 6, 12777.0000, 6, 'Weekly water usage for cooling.', '2026-02-22', '2026-02-28', '2026-03-08 16:22:42', 24.1800, 10, 19, 2),
(48, 20, 6, 15422.0000, 6, 'Weekly water usage for cooling.', '2026-02-08', '2026-02-14', '2026-03-08 16:22:57', 29.1900, 10, 19, 2),
(49, 20, 6, 52988.0000, 6, 'Monthly water usage for cooling.', '2026-01-01', '2026-01-31', '2026-03-08 16:23:25', 100.2900, 10, 19, 2),
(50, 16, 1, 36.4000, 1, 'Daily energy grid usage.', '2026-03-01', '2026-03-01', '2026-03-08 17:31:14', 14.5600, 10, 1, 1),
(51, 16, 1, 31.2000, 1, 'Daily energy grid usage.', '2026-03-02', '2026-03-02', '2026-03-08 17:31:34', 12.4800, 10, 1, 1),
(52, 16, 1, 29.7000, 1, 'Daily energy grid usage.', '2026-03-03', '2026-03-03', '2026-03-08 17:31:47', 11.8800, 10, 1, 1),
(53, 16, 1, 33.6000, 1, 'Daily energy grid usage.', '2026-03-04', '2026-03-04', '2026-03-08 17:32:30', 13.4400, 10, 1, 1),
(54, 16, 1, 28.9000, 1, 'Daily energy grid usage.', '2026-03-05', '2026-03-05', '2026-03-08 17:32:47', 11.5600, 10, 1, 1),
(55, 16, 1, 31.2000, 1, 'Daily energy grid usage.', '2026-03-06', '2026-03-06', '2026-03-08 17:33:01', 12.4800, 10, 1, 1),
(56, 16, 1, 28.8000, 1, 'Daily energy grid usage.', '2026-03-07', '2026-03-07', '2026-03-08 17:33:18', 11.5200, 10, 1, 1),
(57, 16, 3, 2.5000, 4, 'Daily gas combustion usage.', '2026-03-01', '2026-03-01', '2026-03-08 17:33:48', 13.2500, 10, 11, 1),
(58, 16, 3, 2.1000, 4, 'Daily gas combustion usage.', '2026-03-02', '2026-03-02', '2026-03-08 17:34:08', 11.1300, 10, 11, 1),
(59, 16, 3, 2.6000, 4, 'Daily gas combustion usage.', '2026-03-03', '2026-03-03', '2026-03-08 17:34:22', 13.7800, 10, 11, 1),
(60, 16, 3, 2.2000, 4, 'Daily gas combustion usage.', '2026-03-03', '2026-03-03', '2026-03-08 17:34:58', 11.6600, 10, 11, 1),
(61, 16, 3, 3.9000, 4, 'Daily gas combustion usage.', '2026-03-04', '2026-03-04', '2026-03-08 17:35:08', 20.6800, 10, 11, 1),
(62, 16, 3, 3.8000, 4, 'Daily gas combustion usage.', '2026-03-05', '2026-03-05', '2026-03-08 17:35:20', 20.1500, 10, 11, 1),
(63, 16, 3, 2.2000, 4, 'Daily gas combustion usage.', '2026-03-06', '2026-03-06', '2026-03-08 17:35:32', 11.6600, 10, 11, 1),
(64, 16, 3, 2.1000, 4, 'Daily gas combustion usage.', '2026-03-07', '2026-03-07', '2026-03-08 17:35:41', 11.1300, 10, 11, 1),
(65, 16, 6, 1899.0000, 6, 'Daily water cooling usage.', '2026-03-01', '2026-03-01', '2026-03-08 17:36:28', 3.5900, 10, 10, 1),
(66, 16, 6, 1789.0000, 6, 'Daily water cooling usage.', '2026-03-02', '2026-03-02', '2026-03-08 17:36:48', 3.3900, 10, 10, 1),
(67, 16, 6, 1675.0000, 6, 'Daily water cooling usage.', '2026-03-03', '2026-03-03', '2026-03-08 17:37:04', 3.1700, 10, 10, 1),
(68, 16, 6, 1908.0000, 6, 'Daily water cooling usage.', '2026-03-04', '2026-03-04', '2026-03-08 17:37:20', 3.6100, 10, 10, 1),
(69, 16, 6, 1587.0000, 6, 'Daily water cooling usage.', '2026-03-05', '2026-03-05', '2026-03-08 17:37:42', 3.0000, 10, 10, 1),
(70, 16, 6, 2290.0000, 6, 'Daily water cooling usage.', '2026-03-06', '2026-03-06', '2026-03-08 17:38:17', 4.3300, 10, 10, 1),
(71, 16, 6, 1599.0000, 6, 'Daily water cooling usage.', '2026-03-07', '2026-03-07', '2026-03-08 17:38:31', 3.0300, 10, 10, 1),
(72, 16, 1, 320.0000, 1, 'Weekly electricity grid usage.', '2026-02-08', '2026-02-14', '2026-03-08 17:39:27', 128.0000, 10, 1, 1),
(73, 16, 1, 287.0000, 1, 'Weekly electricity grid usage.', '2026-02-15', '2026-02-21', '2026-03-08 17:39:50', 114.8000, 10, 1, 1),
(74, 16, 1, 477.0000, 1, 'Weekly electricity grid usage.', '2026-02-22', '2026-02-28', '2026-03-08 17:40:03', 190.8000, 10, 1, 1),
(75, 16, 3, 18.4000, 4, 'Weekly gas combustion amount.', '2026-02-08', '2026-02-14', '2026-03-08 17:40:38', 97.5500, 10, 11, 1),
(76, 16, 3, 23.1000, 4, 'Weekly gas combustion amount.', '2026-02-15', '2026-02-21', '2026-03-08 17:40:52', 122.4700, 10, 11, 1),
(77, 16, 3, 44.0000, 4, 'Weekly gas combustion amount.', '2026-02-22', '2026-02-28', '2026-03-08 17:41:05', 233.2700, 10, 11, 1),
(78, 16, 5, 2.1000, 8, 'Weekly refrigerant leakage amount.', '2026-02-08', '2026-02-14', '2026-03-08 17:41:44', 4384.8000, 10, 4, 1),
(79, 16, 8, 13.2000, 8, 'Weekly landfill waste amount.', '2026-02-08', '2026-02-14', '2026-03-08 17:42:25', 8.4500, 10, 13, 1),
(80, 16, 8, 66.0000, 8, 'Weekly landfill waste amount.', '2026-02-22', '2026-02-28', '2026-03-08 17:42:50', 42.2400, 10, 13, 1),
(81, 16, 1, 1302.0000, 1, 'Monthly electricity grid usage.', '2026-01-01', '2026-01-31', '2026-03-08 17:43:37', 520.8000, 10, 1, 1),
(82, 16, 3, 89.0000, 4, 'Monthly gas combustion amount.', '2026-01-01', '2026-01-31', '2026-03-08 17:44:05', 471.8500, 10, 11, 1),
(83, 16, 8, 58.0000, 8, 'Monthly landfill waste amount.', '2026-01-01', '2026-01-31', '2026-03-08 17:44:31', 37.1200, 10, 13, 1),
(84, 16, 6, 53777.0000, 6, 'Monthly water cooling usage.', '2026-01-01', '2026-01-31', '2026-03-08 17:45:13', 101.7800, 10, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `EmissionType`
--

CREATE TABLE `EmissionType` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scope` int NOT NULL,
  `base_unit_type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `EmissionType`
--

INSERT INTO `EmissionType` (`id`, `name`, `scope`, `base_unit_type_id`) VALUES
(1, 'Electricity - Grid', 2, 1),
(2, 'Electricity - Renewable (PPA / On-site)', 2, 1),
(3, 'Natural Gas - On-site Combustion', 1, 1),
(4, 'Diesel Fuel - Backup Generators', 1, 2),
(5, 'Refrigerant Leakage - Cooling Systems', 1, 3),
(6, 'Water Usage - Cooling', 3, 2),
(7, 'Waste - Electronic (E-waste)', 3, 3),
(8, 'Waste - General / Landfilled', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `Licensee`
--

CREATE TABLE `Licensee` (
  `id` int NOT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_key` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Licensee`
--

INSERT INTO `Licensee` (`id`, `company`, `company_key`) VALUES
(1, 'NeuralForge Data Systems', 'NFDS-7A9C2E41-B4D8-4F1E-9C3A-8D72E6A91F20'),
(2, 'Helios Compute Infrastructure', 'HCI-2F8D9B0C-61A4-43F0-A7E9-5C8B12D47AEE'),
(3, 'Atlas AI Cloud Operations', 'AACO-91E3C4A8-6D72-4E1B-BF5A-29C7D8E2046F');

-- --------------------------------------------------------

--
-- Table structure for table `RoleType`
--

CREATE TABLE `RoleType` (
  `id` int UNSIGNED NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `RoleType`
--

INSERT INTO `RoleType` (`id`, `role`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `ThresholdLimit`
--

CREATE TABLE `ThresholdLimit` (
  `id` int UNSIGNED NOT NULL,
  `emission_type_id` int UNSIGNED NOT NULL,
  `co2e_limit` decimal(18,4) NOT NULL,
  `co2e_unit_type_id` int UNSIGNED NOT NULL,
  `licensee_id` int NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ThresholdLimit`
--

INSERT INTO `ThresholdLimit` (`id`, `emission_type_id`, `co2e_limit`, `co2e_unit_type_id`, `licensee_id`, `date_updated`) VALUES
(1, 1, 500.0000, 10, 1, '2026-03-02 22:06:01'),
(2, 4, 306.0000, 10, 1, '2026-03-02 22:06:10'),
(3, 5, 50.0000, 10, 1, '2026-03-02 22:06:23'),
(4, 6, 10000.0000, 10, 1, '2026-03-02 22:07:59'),
(5, 8, 100.0000, 10, 1, '2026-03-02 22:07:09'),
(6, 1, 500.0000, 10, 2, '2026-03-02 22:06:01'),
(7, 4, 306.0000, 10, 2, '2026-03-02 22:06:10'),
(8, 5, 50.0000, 10, 2, '2026-03-02 22:06:23'),
(9, 6, 10000.0000, 10, 2, '2026-03-02 22:07:59'),
(10, 8, 100.0000, 10, 2, '2026-03-02 22:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `UnitType`
--

CREATE TABLE `UnitType` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_base_unit` tinyint(1) NOT NULL DEFAULT '0',
  `conversion_factor` decimal(18,6) NOT NULL,
  `base_unit_type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `UnitType`
--

INSERT INTO `UnitType` (`id`, `code`, `name`, `is_base_unit`, `conversion_factor`, `base_unit_type_id`) VALUES
(1, 'kWh', 'Kilowatt-hour', 1, 1.000000, 1),
(2, 'MWh', 'Megawatt-hour', 0, 1000.000000, 1),
(3, 'Wh', 'Watt-hour', 0, 0.001000, 1),
(4, 'therm', 'Therm', 0, 29.307107, 1),
(5, 'L', 'Liter', 1, 1.000000, 2),
(6, 'gal', 'US Gallon', 0, 3.785412, 2),
(7, 'm3', 'Cubic meter', 0, 1000.000000, 2),
(8, 'kg', 'Kilogram', 1, 1.000000, 3),
(9, 'lb', 'Pound', 0, 0.453592, 3),
(10, 'kgCO2e', 'Kilograms CO2e', 1, 1.000000, 4),
(12, 'MMBtu', 'Million BTU', 0, 293.071070, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `AlertLog`
--
ALTER TABLE `AlertLog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alert_co2e_unit` (`co2e_unit_type_id`),
  ADD KEY `fk_alert_emission_log` (`emission_log_id`),
  ADD KEY `fk_alert_threshold` (`threshold_limit_id`),
  ADD KEY `idx_alert_type_date` (`emission_type_id`,`date_created`),
  ADD KEY `fk_licensee_id` (`licensee_id`);

--
-- Indexes for table `BaseUnitType`
--
ALTER TABLE `BaseUnitType`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `EarthUser`
--
ALTER TABLE `EarthUser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_earthuser_role_type` (`role_type_id`),
  ADD KEY `fk_earthuser_licensee_key` (`licensee_id`) USING BTREE;

--
-- Indexes for table `EmissionFactor`
--
ALTER TABLE `EmissionFactor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_emissionfactor` (`licensee_id`,`emission_type_id`,`physical_unit_type_id`),
  ADD UNIQUE KEY `licensee_id` (`licensee_id`,`emission_type_id`,`physical_unit_type_id`),
  ADD KEY `fk_emfactor_emission_type` (`emission_type_id`),
  ADD KEY `fk_emfactor_physical_unit` (`physical_unit_type_id`),
  ADD KEY `fk_emfactor_co2e_unit` (`co2e_unit_type_id`),
  ADD KEY `fk_licensee_id` (`licensee_id`);

--
-- Indexes for table `EmissionLog`
--
ALTER TABLE `EmissionLog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emlog_co2e_unit_type_id` (`co2e_unit_type_id`),
  ADD KEY `fk_emlog_emission_factor_id` (`emission_factor_id`),
  ADD KEY `fk_emlog_user_id` (`user_id`) USING BTREE,
  ADD KEY `fk_emlog_unit_type_id` (`unit_type_id`) USING BTREE,
  ADD KEY `fk_emlog_emission_type_id` (`emission_type_id`) USING BTREE,
  ADD KEY `fk_licensee_id` (`licensee_id`);

--
-- Indexes for table `EmissionType`
--
ALTER TABLE `EmissionType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Licensee`
--
ALTER TABLE `Licensee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `RoleType`
--
ALTER TABLE `RoleType`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ThresholdLimit`
--
ALTER TABLE `ThresholdLimit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `licensee_id` (`licensee_id`,`emission_type_id`,`co2e_unit_type_id`),
  ADD KEY `fk_threshold_emission_type` (`emission_type_id`),
  ADD KEY `fk_threshold_co2e_unit` (`co2e_unit_type_id`),
  ADD KEY `fk_licensee_id` (`licensee_id`);

--
-- Indexes for table `UnitType`
--
ALTER TABLE `UnitType`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_unittype_code` (`code`),
  ADD KEY `fk_unit_base_type` (`base_unit_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `AlertLog`
--
ALTER TABLE `AlertLog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `BaseUnitType`
--
ALTER TABLE `BaseUnitType`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `EarthUser`
--
ALTER TABLE `EarthUser`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `EmissionFactor`
--
ALTER TABLE `EmissionFactor`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `EmissionLog`
--
ALTER TABLE `EmissionLog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `EmissionType`
--
ALTER TABLE `EmissionType`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `RoleType`
--
ALTER TABLE `RoleType`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ThresholdLimit`
--
ALTER TABLE `ThresholdLimit`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `UnitType`
--
ALTER TABLE `UnitType`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AlertLog`
--
ALTER TABLE `AlertLog`
  ADD CONSTRAINT `fk_alert_co2e_unit` FOREIGN KEY (`co2e_unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alert_emission_log` FOREIGN KEY (`emission_log_id`) REFERENCES `EmissionLog` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alert_emission_type` FOREIGN KEY (`emission_type_id`) REFERENCES `EmissionType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alert_threshold` FOREIGN KEY (`threshold_limit_id`) REFERENCES `ThresholdLimit` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `EarthUser`
--
ALTER TABLE `EarthUser`
  ADD CONSTRAINT `fk_earthuser_role_type` FOREIGN KEY (`role_type_id`) REFERENCES `RoleType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `EmissionFactor`
--
ALTER TABLE `EmissionFactor`
  ADD CONSTRAINT `fk_emfactor_co2e_unit` FOREIGN KEY (`co2e_unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emfactor_emission_type` FOREIGN KEY (`emission_type_id`) REFERENCES `EmissionType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emfactor_physical_unit` FOREIGN KEY (`physical_unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `EmissionLog`
--
ALTER TABLE `EmissionLog`
  ADD CONSTRAINT `fk_emlog_co2e_unit` FOREIGN KEY (`co2e_unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emlog_emission_factor` FOREIGN KEY (`emission_factor_id`) REFERENCES `EmissionFactor` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emlog_emission_type` FOREIGN KEY (`emission_type_id`) REFERENCES `EmissionType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emlog_unit` FOREIGN KEY (`unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emlog_user` FOREIGN KEY (`user_id`) REFERENCES `EarthUser` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `ThresholdLimit`
--
ALTER TABLE `ThresholdLimit`
  ADD CONSTRAINT `fk_threshold_co2e_unit` FOREIGN KEY (`co2e_unit_type_id`) REFERENCES `UnitType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_threshold_emission_type` FOREIGN KEY (`emission_type_id`) REFERENCES `EmissionType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `UnitType`
--
ALTER TABLE `UnitType`
  ADD CONSTRAINT `fk_unit_base_type` FOREIGN KEY (`base_unit_type_id`) REFERENCES `BaseUnitType` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
