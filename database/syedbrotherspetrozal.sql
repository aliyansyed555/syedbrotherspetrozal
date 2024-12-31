-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 31, 2024 at 01:01 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `syedbrotherspetrozal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:2:{i:0;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"owner-access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:1;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"manager-access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:3;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"client_admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}}}', 1735548605);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `card_payments`
--

DROP TABLE IF EXISTS `card_payments`;
CREATE TABLE IF NOT EXISTS `card_payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double NOT NULL,
  `card_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `transaction_type` enum('deposit','withdrawal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'deposit',
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_payments_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card_payments`
--

INSERT INTO `card_payments` (`id`, `card_number`, `amount`, `card_type`, `remarks`, `transaction_type`, `account_number`, `petrol_pump_id`, `date`, `created_at`, `updated_at`) VALUES
(2, '0000 11111 4444', 2898, 'PSO', NULL, 'deposit', NULL, 1, '2024-11-01', NULL, NULL),
(7, '111', 2898, 'PSO', NULL, 'deposit', NULL, 1, '2024-11-02', NULL, NULL),
(10, '111111111111', 2898, 'PSO', NULL, 'deposit', NULL, 1, '2024-11-01', NULL, NULL),
(11, '110000000', 1100, 'PSO', NULL, 'deposit', NULL, 7, '2024-12-05', NULL, NULL),
(12, '1234', 2000, 'PSO', NULL, 'deposit', NULL, 7, '2024-12-06', NULL, NULL),
(13, '11123', 500, 'PSO', NULL, 'deposit', NULL, 7, '2024-12-06', NULL, NULL),
(14, '1111111111', 30000, 'PSO', NULL, 'deposit', NULL, 7, '2024-12-07', NULL, NULL),
(20, '1111111111', 10000, 'PSO', NULL, 'deposit', NULL, 11, '2024-12-07', NULL, NULL),
(21, '1111111111', 5000, 'PSO', NULL, 'deposit', NULL, 11, '2024-12-08', NULL, NULL),
(22, 'xxxx-xxxx-xxxx-xxxx', -11000, NULL, 'diesel', 'withdrawal', 'aveen', 11, '2024-12-09', '2024-12-10 08:38:26', '2024-12-10 08:38:26'),
(23, '2345', 10, 'PSO', NULL, 'deposit', NULL, 14, '2024-12-06', NULL, NULL),
(24, '641', 1, 'PSO', NULL, 'deposit', NULL, 17, '2024-12-03', NULL, NULL),
(25, '1111111111', 11000, 'PSO', NULL, 'deposit', NULL, 18, '2024-12-09', NULL, NULL),
(26, '500000000', 8000, 'PSO', NULL, 'deposit', NULL, 15, '2024-12-26', NULL, NULL),
(27, '1200', 10000, 'Other', NULL, 'deposit', NULL, 15, '2024-12-26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `card_payments_transfers`
--

DROP TABLE IF EXISTS `card_payments_transfers`;
CREATE TABLE IF NOT EXISTS `card_payments_transfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_payments_transfers_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `user_id`, `address`, `created_at`, `updated_at`) VALUES
(3, 'RSF Brothers', 3, 'Sargodha, Pakistan', '2024-11-11 22:24:20', '2024-11-11 22:24:20'),
(8, 'Petrozal', 2, 'Lahore, Punjab, Pakistan', NULL, NULL),
(9, 'Rana Group', 28, 'Street 12 A Rifle range Road', '2024-11-15 21:58:51', '2024-11-15 21:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customers_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `petrol_pump_id`, `created_at`, `updated_at`) VALUES
(2, 'Tucker Delaney', '+929836774573', 'Dolorem aspernatur a', 1, '2024-11-23 19:04:37', '2024-11-23 19:13:59'),
(3, 'Kristen Larsen', '+923533656325', 'Non ut eos minus qui', 1, '2024-11-23 19:08:48', '2024-11-23 19:14:15'),
(5, 'Hayfa Baker', '+923851514302', 'Voluptatem et ipsum', 1, '2024-11-23 19:12:16', '2024-11-23 19:21:51'),
(9, 'Asad', '03331236767', 'muslimabad', 7, '2024-12-05 17:12:14', '2024-12-05 17:12:14'),
(10, 'Ali', '03215458246', 'Sargodha', 8, '2024-12-06 20:08:01', '2024-12-06 20:08:01'),
(11, 'Ali', '03216849842', 'hjgsdbfu', 9, '2024-12-06 20:27:00', '2024-12-06 20:27:00'),
(12, 'Ali', '03215458246', 'jygbufgjh', 10, '2024-12-06 21:01:43', '2024-12-06 21:01:43'),
(13, 'Muhammad Anas', '3331236768', 'Muslimabad mehboob cotton road, house', 11, '2024-12-08 14:49:12', '2024-12-08 14:49:12'),
(14, 'Ali', '03236546495', 'hmg sjbs', 13, '2024-12-09 11:18:20', '2024-12-09 11:18:20'),
(15, 'Umer', '03215458246', 'rtdectdv', 14, '2024-12-09 11:56:36', '2024-12-09 11:56:36'),
(16, 'Sohail Ahmad Toor', '03215458246', 'Sargodha', 15, '2024-12-10 12:25:14', '2024-12-10 12:25:14'),
(17, 'RSF Dealer', '03215458246', 'Sargodha', 15, '2024-12-10 12:52:28', '2024-12-10 12:52:28'),
(18, 'Haji Rauf', '03215458246', 'jhdgbsdf', 15, '2024-12-10 12:53:08', '2024-12-10 12:53:08'),
(19, 'Supply rent', '03215458246', 'nhsdgcbjhdgsfc', 15, '2024-12-11 12:04:12', '2024-12-11 12:04:12'),
(20, 'Sohail Ahmad Toor', '03215458246', 'dkjgybcgs', 16, '2024-12-11 12:28:32', '2024-12-11 12:28:32'),
(21, 'Haji Rauf', '03215458246', 'duybuywd', 16, '2024-12-11 12:28:44', '2024-12-11 12:28:44'),
(22, 'RSF Dealer', '03216546851', 'jsdtnfdw', 16, '2024-12-11 12:29:00', '2024-12-11 12:29:00'),
(23, 'Sohail', '03215458246', 'hdsfbgvfd', 17, '2024-12-11 20:12:48', '2024-12-11 20:12:48'),
(24, 'Rauf', '03216549445', 'fdgfdgsfg', 12, '2024-12-13 11:24:25', '2024-12-13 11:24:25'),
(25, 'RSF Delaer', '03216531685', 'fdshghsfgh', 12, '2024-12-13 11:25:04', '2024-12-13 11:25:04'),
(26, 'Asad', '03345667712', 'asadfghjj', 18, '2024-12-13 12:27:38', '2024-12-13 12:27:38'),
(27, 'awais', '03456789345', 'qwerttyui', 18, '2024-12-13 12:27:56', '2024-12-13 12:27:56'),
(28, 'M Amir Shahzad', '03068802685', 'Vip town, Opposite aziz bhati town,', 15, '2024-12-23 11:28:37', '2024-12-23 11:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `customer_credits`
--

DROP TABLE IF EXISTS `customer_credits`;
CREATE TABLE IF NOT EXISTS `customer_credits` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `bill_amount` double NOT NULL DEFAULT '0',
  `amount_paid` double NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `is_special` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'no need to add into cash in hand',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_credits_customer_id_foreign` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_credits`
--

INSERT INTO `customer_credits` (`id`, `bill_amount`, `amount_paid`, `balance`, `remarks`, `date`, `is_special`, `created_at`, `updated_at`, `customer_id`) VALUES
(19, 14000, 7000, 7000, 'petrol', '2024-12-14', 1, '2024-12-27 15:18:52', '2024-12-27 15:18:52', 18),
(20, 20000, 10000, 17000, 'diesel', '2024-12-15', 1, '2024-12-27 15:19:20', '2024-12-27 15:19:20', 18),
(22, 0, 16000, 1000, NULL, '2024-12-17', 0, NULL, NULL, 18),
(23, 0, 10000, -9000, NULL, '2024-12-17', 0, NULL, NULL, 18),
(24, 7000, 0, -2000, NULL, '2024-12-18', 0, NULL, NULL, 18),
(25, 7000, 0, 5000, NULL, '2024-12-18', 0, NULL, NULL, 18),
(28, 14000, 10000, 9000, 'petrol', '2024-12-19', 1, '2024-12-27 15:40:24', '2024-12-27 15:40:24', 18),
(29, 10000, 10000, 9000, 'petrol', '2024-12-20', 0, NULL, NULL, 18),
(30, 0, 20000, -11000, NULL, '2024-12-21', 1, '2024-12-27 15:42:31', '2024-12-27 15:42:31', 18),
(31, 15000, 0, 4000, NULL, '2024-12-20', 0, NULL, NULL, 18),
(32, 2000, 0, 6000, 'petrol', '2024-12-21', 0, NULL, NULL, 18),
(33, 0, 12000, -6000, 'petrol', '2024-12-22', 0, NULL, NULL, 18),
(34, 12000, 0, 12000, 'petrol', '2024-12-22', 0, NULL, NULL, 19),
(35, 5000, 0, 5000, NULL, '2024-12-25', 0, NULL, NULL, 18),
(36, 0, 10000, -5000, NULL, '2024-12-26', 1, '2024-12-29 10:22:43', '2024-12-29 10:22:43', 18);

-- --------------------------------------------------------

--
-- Table structure for table `daily_reports`
--

DROP TABLE IF EXISTS `daily_reports`;
CREATE TABLE IF NOT EXISTS `daily_reports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_expense` decimal(10,2) DEFAULT NULL COMMENT 'Daily expense amount',
  `expense_detail` text COLLATE utf8mb4_unicode_ci COMMENT 'Details of the expense',
  `pump_rent` decimal(16,2) DEFAULT NULL COMMENT 'Rent amount for the pump',
  `bank_deposit` decimal(16,2) DEFAULT NULL COMMENT 'Amount deposited in the bank',
  `cash_in_hand` decimal(16,2) DEFAULT NULL COMMENT 'Amount Stay in Hand',
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bank account number',
  `date` date NOT NULL COMMENT 'Date for the record',
  `tuck_shop_rent` float(6,2) DEFAULT NULL,
  `tuck_shop_earning` float(6,2) DEFAULT NULL,
  `service_station_earning` float(6,2) DEFAULT NULL,
  `service_station_rent` float(6,2) DEFAULT NULL,
  `tyre_shop_earning` float(6,2) DEFAULT NULL,
  `tyre_shop_rent` float(6,2) DEFAULT NULL,
  `lube_shop_earning` float(6,2) DEFAULT NULL,
  `lube_shop_rent` float(6,2) DEFAULT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL COMMENT 'Foreign key referencing petrol_pumps table',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_reports_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_reports`
--

INSERT INTO `daily_reports` (`id`, `daily_expense`, `expense_detail`, `pump_rent`, `bank_deposit`, `cash_in_hand`, `account_number`, `date`, `tuck_shop_rent`, `tuck_shop_earning`, `service_station_earning`, `service_station_rent`, `tyre_shop_earning`, `tyre_shop_rent`, `lube_shop_earning`, `lube_shop_rent`, `petrol_pump_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, 242000.00, NULL, '2024-12-28', 0.00, 0.00, 200.00, 0.00, 300.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(2, NULL, NULL, NULL, NULL, 334000.00, NULL, '2024-12-30', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(3, NULL, NULL, NULL, NULL, 365000.00, NULL, '2024-12-31', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(4, NULL, NULL, NULL, NULL, 383500.00, NULL, '2024-12-08', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(5, NULL, NULL, NULL, NULL, 390000.00, NULL, '2024-12-09', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(6, NULL, NULL, NULL, NULL, 373500.00, NULL, '2024-12-15', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(7, NULL, NULL, NULL, NULL, 373500.00, NULL, '2024-12-16', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(8, NULL, NULL, NULL, NULL, 366600.00, NULL, '2024-12-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(9, NULL, NULL, NULL, NULL, 381600.00, NULL, '2024-12-16', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(10, NULL, NULL, NULL, NULL, 379150.00, NULL, '2024-12-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(11, NULL, NULL, NULL, NULL, 372690.00, NULL, '2024-12-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(12, NULL, NULL, NULL, NULL, 362230.00, NULL, '2024-12-18', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(13, NULL, NULL, NULL, NULL, 362230.00, NULL, '2024-12-18', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(14, NULL, NULL, NULL, NULL, 395230.00, NULL, '2024-12-20', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(15, NULL, NULL, NULL, NULL, 373500.00, NULL, '2024-12-20', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(16, NULL, NULL, NULL, NULL, 363150.00, NULL, '2024-12-21', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(17, NULL, NULL, NULL, NULL, 374000.00, NULL, '2024-12-22', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 15, NULL, NULL),
(18, NULL, NULL, NULL, NULL, 365450.00, NULL, '2024-12-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `daily_reports_22`
--

DROP TABLE IF EXISTS `daily_reports_22`;
CREATE TABLE IF NOT EXISTS `daily_reports_22` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `daily_expense` decimal(10,2) DEFAULT NULL COMMENT 'Daily expense amount',
  `expense_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Details of the expense',
  `pump_rent` decimal(16,2) DEFAULT NULL COMMENT 'Rent amount for the pump',
  `bank_deposit` decimal(16,2) DEFAULT NULL COMMENT 'Amount deposited in the bank',
  `cash_in_hand` decimal(16,2) DEFAULT NULL COMMENT 'Amount Stay in Hand',
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bank account number',
  `date` date NOT NULL COMMENT 'Date for the record',
  `tuck_shop_rent` float(6,2) DEFAULT NULL,
  `tuck_shop_earning` float(6,2) DEFAULT NULL,
  `service_station_earning` float(6,2) DEFAULT NULL,
  `service_station_rent` float(6,2) DEFAULT NULL,
  `tyre_shop_earning` float(6,2) DEFAULT NULL,
  `tyre_shop_rent` float(6,2) DEFAULT NULL,
  `lube_shop_earning` float(6,2) DEFAULT NULL,
  `lube_shop_rent` float(6,2) DEFAULT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL COMMENT 'Foreign key referencing petrol_pumps table',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_reports_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_reports_22`
--

INSERT INTO `daily_reports_22` (`id`, `daily_expense`, `expense_detail`, `pump_rent`, `bank_deposit`, `cash_in_hand`, `account_number`, `date`, `tuck_shop_rent`, `tuck_shop_earning`, `service_station_earning`, `service_station_rent`, `tyre_shop_earning`, `tyre_shop_rent`, `lube_shop_earning`, `lube_shop_rent`, `petrol_pump_id`, `created_at`, `updated_at`) VALUES
(6, 800.00, 'Some espces', 2000.00, 25000.00, 66542.00, '110000011', '2024-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(7, 10000.00, 'copy 20,  pencils 9800', 200000.00, 150000.00, 498275.52, 'sachi muchiiii', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(8, 10000.00, 'copy 20,  pencils 9800', 100000.00, 200000.00, 1766975.52, 'sachi muchiiii', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(9, 10000.00, 'copy 20,  pencils 9800', 300000.00, 100000.00, 499275.52, '1234567', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(10, 5000.00, 'copy 20,  pencils 4800', 10000.00, 20000.00, 500317.48, '2345678', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(11, NULL, NULL, NULL, NULL, 0.00, NULL, '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL),
(12, 0.00, NULL, 0.00, 0.00, 0.00, '0', '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(13, 1500.00, 'Staff Exp=1500', 0.00, 0.00, 422.00, '0', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL),
(14, 1500.00, 'Some espces', 2000.00, 25000.00, 597345.24, NULL, '2024-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(15, 20000.00, 'copy 20,  pencils 9800', 150000.00, 200000.00, 589745.24, 'sachi muchiiii', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, NULL, NULL),
(16, 10000.00, 'copy 20,  pencils 9800', 50000.00, 10000.00, 13318.38, 'sachi muchiiii', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL),
(17, 2000.00, 'copy 20,  pencils 1880', 10000.00, 2000.00, 2469.66, 'sachi muchiiii', '2024-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL),
(18, 0.00, '0', 0.00, 0.00, 7587.40, '0', '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL),
(19, 0.00, '0', 0.00, 0.00, 7574.50, '0', '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, NULL),
(20, 100.00, 'hbgnu', 20.00, 50.00, 8561.95, '02565', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, NULL),
(21, NULL, NULL, NULL, NULL, 8592.94, NULL, '2024-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL),
(22, 10.00, 'Staff', 0.00, 0.00, 9999.55, '0', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, NULL),
(23, 10.00, 'Staff', 0.00, 0.00, 11247.00, '0', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, NULL, NULL),
(24, 10.00, 'Staff Exp', 0.00, 0.00, 8097.40, '0', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL),
(25, 0.00, '0', 0.00, 0.00, 8856.14, '0', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL),
(26, 10.00, '0', 5.00, 5.00, 10353.62, '0', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL),
(27, 0.00, '0', 0.00, 81108879.09, 191170.94, '0', '2024-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(28, 1400.00, 'Staff Exp=1400', 0.00, 0.00, 277249.35, '0', '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(29, 1400.00, 'Staff Exp=1500', 0.00, 0.00, 204244.10, '0', '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(30, NULL, NULL, NULL, NULL, 14716.22, NULL, '2024-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, NULL, NULL),
(31, 1400.00, 'staff expenses', NULL, NULL, 427186.72, NULL, '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(32, 168100.00, 'Staff Exp=1400, RSF Exp=166700', 0.00, 0.00, 317900.35, '0', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(33, 1900.00, 'Staff EXp=1400, Supply Inam=500', 0.00, 0.00, 270487.01, '0', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(34, 37515.00, 'Staff EXp=1400, Bijli Bill=36115', 0.00, 0.00, 151134.59, '0', '2024-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(35, NULL, NULL, NULL, 81007479.09, 142966.97, '0', '2024-12-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(36, 1400.00, 'Staff Exp=1400', 100000.00, 0.00, 191170.94, '0', '2024-12-02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(37, 1400.00, 'Staff EXp=1400', 0.00, 0.00, 277249.35, '0', '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(38, 1400.00, 'Staff Exp=1400', 0.00, 0.00, 204244.10, '0', '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(39, 1400.00, 'Staff Exp=1400', 0.00, 0.00, 394186.72, '0', '2024-12-05', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(40, 168100.00, 'Staff Exp=1400, RSF Exp=166700', 0.00, 0.00, 284900.35, '0', '2024-12-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, NULL, NULL),
(41, 0.00, '0', 0.00, 0.00, 11112.36, '0', '2024-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, NULL, NULL),
(42, NULL, 'Supply Rent', NULL, -20.00, NULL, '234165', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, '2024-12-11 20:16:25', '2024-12-11 20:16:25'),
(43, 10.00, 'Staff Exp=10', 1.00, 1.00, 1250.55, '6824', '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, NULL, NULL),
(44, 1900.00, 'hdygb', 0.00, 0.00, 522386.66, '0', '2024-12-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL),
(45, 37515.00, 'gfhfgh', 0.00, 0.00, 436951.30, '0', '2024-12-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL),
(46, 2000.00, 'jghjh', 0.00, 0.00, 494636.88, '0', '2024-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL),
(47, 1400.00, 'jll;', 0.00, 0.00, 619398.93, '0', '2024-12-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, NULL),
(48, 10000.00, 'copy 20,  pencils 9800', 10000.00, 50000.00, 161842.76, 'sachi muchiiii', '2024-12-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 18, NULL, NULL),
(49, 1000.00, 'testing', 2000.00, 100.00, 150922.59, 'testing bank', '2024-12-04', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(50, NULL, NULL, NULL, NULL, 152284.59, NULL, '2024-12-27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(51, NULL, NULL, NULL, NULL, 152284.59, NULL, '2024-12-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, NULL, NULL),
(52, NULL, NULL, NULL, NULL, 152284.59, NULL, '2024-12-04', 12.00, 0.00, 0.00, 23.00, 0.00, 33.00, 0.00, 44.00, 15, NULL, NULL),
(53, 1000.00, 'testing', 30000.00, 5570.00, 200000.79, 'testing bank', '2024-12-26', 1200.00, 0.00, 0.00, 1400.00, 0.00, 1600.00, 2000.00, 0.00, 15, NULL, NULL),
(54, 12.00, 'testing', 100.00, 100.00, 153493.59, 'testing bank', '2024-12-26', 111.00, 0.00, 10.00, 0.00, 0.00, 0.00, 500.00, 0.00, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dip_records`
--

DROP TABLE IF EXISTS `dip_records`;
CREATE TABLE IF NOT EXISTS `dip_records` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `reading_in_mm` double NOT NULL,
  `reading_in_ltr` double NOT NULL,
  `date` date NOT NULL,
  `tank_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dip_records_tank_id_foreign` (`tank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dip_records`
--

INSERT INTO `dip_records` (`id`, `reading_in_mm`, `reading_in_ltr`, `date`, `tank_id`, `created_at`, `updated_at`) VALUES
(1, 345, 1250, '2024-12-06', 11, '2024-12-06 16:19:13', '2024-12-06 16:19:13'),
(2, 321, 1000, '2024-12-05', 19, '2024-12-06 21:10:45', '2024-12-06 21:10:45'),
(3, 321, 1000, '2024-12-05', 20, '2024-12-06 21:10:57', '2024-12-06 21:10:57'),
(4, 321, 1000, '2024-12-05', 21, '2024-12-06 21:11:07', '2024-12-06 21:11:07'),
(5, 496, 5100, '2024-12-06', 12, '2024-12-07 14:05:25', '2024-12-07 14:05:25'),
(6, 250, 3000, '2024-12-07', 23, '2024-12-08 14:48:11', '2024-12-08 14:48:11'),
(7, 270, 4000, '2024-12-07', 24, '2024-12-08 14:48:26', '2024-12-08 14:48:26'),
(8, 290, 5000, '2024-12-07', 22, '2024-12-08 14:48:44', '2024-12-08 14:48:44'),
(9, 14, 990, '2024-12-05', 29, '2024-12-09 12:19:48', '2024-12-09 12:19:48'),
(10, 587, 991, '2024-12-05', 30, '2024-12-09 12:20:07', '2024-12-09 12:20:07'),
(11, 341, 992, '2024-12-05', 31, '2024-12-09 12:20:33', '2024-12-09 12:20:33'),
(12, 450, 2870, '2024-12-09', 23, '2024-12-10 09:12:45', '2024-12-10 09:12:45'),
(13, 321, 2970, '2024-12-06', 29, '2024-12-10 11:47:05', '2024-12-10 11:47:05'),
(14, 210, 987, '2024-12-06', 30, '2024-12-10 11:47:19', '2024-12-10 11:47:19'),
(15, 45, 987, '2024-12-06', 31, '2024-12-10 11:47:30', '2024-12-10 11:47:30'),
(16, 21, 2967, '2024-12-06', 29, '2024-12-10 12:02:22', '2024-12-10 12:02:22'),
(17, 312, 984, '2024-12-06', 30, '2024-12-10 12:02:45', '2024-12-10 12:02:45'),
(18, 321, 984, '2024-12-06', 31, '2024-12-10 12:02:55', '2024-12-10 12:02:55'),
(19, 321, 1010, '2024-12-05', 25, '2024-12-10 12:07:49', '2024-12-10 12:07:49'),
(20, 321, 1010, '2024-12-05', 26, '2024-12-10 12:08:08', '2024-12-10 12:08:08'),
(21, 321, 1010, '2024-12-05', 27, '2024-12-10 12:08:23', '2024-12-10 12:08:23'),
(22, 321, 1009, '2024-12-06', 25, '2024-12-10 12:12:05', '2024-12-10 12:12:05'),
(23, 321, 1009, '2024-12-06', 26, '2024-12-10 12:12:14', '2024-12-10 12:12:14'),
(24, 321, 1009, '2024-12-06', 27, '2024-12-10 12:12:35', '2024-12-10 12:12:35'),
(25, 321, 1005, '2024-12-07', 25, '2024-12-10 12:17:31', '2024-12-10 12:17:31'),
(26, 321, 1005, '2024-12-07', 26, '2024-12-10 12:17:39', '2024-12-10 12:17:39'),
(27, 321, 1005, '2024-12-07', 27, '2024-12-10 12:17:49', '2024-12-10 12:17:49'),
(28, 432, 2618.71, '2024-12-03', 32, '2024-12-10 12:50:38', '2024-12-10 12:50:38'),
(29, 192, 820.09, '2024-12-03', 33, '2024-12-10 12:50:48', '2024-12-10 12:50:48'),
(30, 398, 2326.5, '2024-12-04', 32, '2024-12-10 12:59:01', '2024-12-10 12:59:01'),
(31, 175, 717.45, '2024-12-04', 33, '2024-12-10 12:59:14', '2024-12-10 12:59:14'),
(32, 302, 1562.2, '2024-12-06', 32, '2024-12-11 11:57:38', '2024-12-11 11:57:38'),
(33, 108, 360.82, '2024-12-06', 33, '2024-12-11 11:57:53', '2024-12-11 11:57:53'),
(34, 782, 6061.2, '2024-12-07', 32, '2024-12-11 12:07:12', '2024-12-11 12:07:12'),
(35, 390, 2280.12, '2024-12-07', 33, '2024-12-11 12:07:22', '2024-12-11 12:07:22'),
(36, 375, 2166.32, '2024-12-08', 33, '2024-12-11 12:15:20', '2024-12-11 12:15:20'),
(37, 754, 5742.99, '2024-12-08', 32, '2024-12-11 12:15:33', '2024-12-11 12:15:33'),
(38, 470, 2932.99, '2024-12-02', 34, '2024-12-11 12:31:02', '2024-12-11 12:31:02'),
(39, 208, 928.42, '2024-12-02', 35, '2024-12-11 12:31:32', '2024-12-11 12:31:32'),
(40, 432, 2618.71, '2024-12-03', 34, '2024-12-11 12:35:50', '2024-12-11 12:35:50'),
(41, 192, 820.09, '2024-12-03', 35, '2024-12-11 12:36:00', '2024-12-11 12:36:00'),
(42, 398, 2326.5, '2024-12-04', 34, '2024-12-11 12:39:40', '2024-12-11 12:39:40'),
(43, 175, 717.45, '2024-12-04', 35, '2024-12-11 12:39:52', '2024-12-11 12:39:52'),
(44, 350, 1935, '2024-12-05', 34, '2024-12-11 17:00:59', '2024-12-11 17:00:59'),
(45, 150, 565.72, '2024-12-05', 35, '2024-12-11 17:01:10', '2024-12-11 17:01:10'),
(46, 302, 1562.2, '2024-12-06', 34, '2024-12-11 17:04:00', '2024-12-11 17:04:00'),
(47, 108, 360.82, '2024-12-06', 35, '2024-12-11 17:04:10', '2024-12-11 17:04:10'),
(48, 321, 1000, '2024-12-03', 36, '2024-12-11 20:31:05', '2024-12-11 20:31:05'),
(49, 321, 1000, '2024-12-03', 37, '2024-12-11 20:31:21', '2024-12-11 20:31:21'),
(50, 321, 1000, '2024-12-03', 38, '2024-12-11 20:31:36', '2024-12-11 20:31:36'),
(51, 782, 6061.2, '2024-12-07', 39, '2024-12-13 11:33:36', '2024-12-13 11:33:36'),
(52, 390, 2280.12, '2024-12-07', 40, '2024-12-13 11:33:46', '2024-12-13 11:33:46'),
(53, 754, 5742.99, '2024-12-08', 39, '2024-12-13 11:36:57', '2024-12-13 11:36:57'),
(54, 375, 2166.32, '2024-12-08', 40, '2024-12-13 11:37:09', '2024-12-13 11:37:09'),
(55, 714, 5347.4, '2024-12-09', 39, '2024-12-13 11:42:50', '2024-12-13 11:42:50'),
(56, 348, 1981.08, '2024-12-09', 40, '2024-12-13 11:43:01', '2024-12-13 11:43:01'),
(57, 680, 4990.73, '2024-12-10', 39, '2024-12-13 11:50:14', '2024-12-13 11:50:14'),
(58, 334, 1838.83, '2024-12-10', 40, '2024-12-13 11:51:16', '2024-12-13 11:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_salary` decimal(15,2) NOT NULL DEFAULT '0.00',
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employees_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `address`, `total_salary`, `petrol_pump_id`, `created_at`, `updated_at`) VALUES
(1, 'Sigourney Mack', '03130000000', 'At facere qui conseq', 25000.00, 1, '2024-11-23 22:24:15', '2024-11-25 15:14:10'),
(2, 'Brielle Helfman', '+923384773644', 'Iusto illum tempori', 10000.00, 1, '2024-11-23 22:24:51', '2024-11-25 15:13:35'),
(3, 'Phoebe Sharpe', '+923473341189', 'Quia ipsam nostrum v', 15000.00, 1, '2024-11-23 22:24:55', '2024-11-25 15:14:04'),
(5, 'Muhammad Usman Khalid', '03167522589', 'Chak No. 89 NB Sillanwali Road', 5000.00, 7, '2024-12-05 17:12:45', '2024-12-05 17:41:26'),
(6, 'Asad', '03167522589', 'Chak No. 89 NB Sillanwali Road', 5000.15, 7, '2024-12-05 17:41:47', '2024-12-05 22:08:54'),
(7, 'Darryl Norman', '+923743345967', 'Perferendis exercita', 0.00, 7, '2024-12-05 17:42:14', '2024-12-05 17:42:14'),
(8, 'fazool', '03456789089', 'Muslimabad mehboob cotton road, house', 27000.00, 7, '2024-12-06 09:45:24', '2024-12-06 09:45:24'),
(9, 'Ali', '03215458246', 'Sargodha', 10000.00, 8, '2024-12-06 20:07:35', '2024-12-06 20:07:35'),
(10, 'Ali', '03215458246', 'hdg fxcy', 10000.00, 9, '2024-12-06 20:27:21', '2024-12-06 20:27:21'),
(11, 'Ali', '03216546485', 'gvyfytvfvyf', 10000.00, 10, '2024-12-06 21:02:34', '2024-12-06 21:02:34'),
(12, 'SYed', '3331236767', 'Muslimabad mehboob cotton road, house n', 12000.00, 11, '2024-12-08 14:49:40', '2024-12-08 14:49:40'),
(13, 'Ali', '03215458246', 'HGGvhv,j', 10000.00, 13, '2024-12-09 11:17:53', '2024-12-09 11:17:53'),
(14, 'Umer', '03216549804', 'uyvfykuf b', 10000.00, 14, '2024-12-09 11:58:10', '2024-12-09 11:58:10'),
(15, 'Haji Zahid', '03215458246', 'dscsdferwdf', 35000.00, 15, '2024-12-11 12:02:47', '2024-12-11 12:02:47'),
(16, 'Ali', '3201651891', 'GFDVbgsu', 10000.00, 17, '2024-12-11 20:13:00', '2024-12-11 20:13:00'),
(17, 'ali', '03466783256', 'awaisdfgh', 12000.00, 18, '2024-12-13 12:28:32', '2024-12-13 12:28:32'),
(18, 'john', '03455724667', 'asdghjkk', 10000.00, 18, '2024-12-13 12:28:58', '2024-12-13 12:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `employee_wages`
--

DROP TABLE IF EXISTS `employee_wages`;
CREATE TABLE IF NOT EXISTS `employee_wages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount_received` double NOT NULL,
  `employee_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_wages_employee_id_foreign` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_wages`
--

INSERT INTO `employee_wages` (`id`, `amount_received`, `employee_id`, `date`, `created_at`, `updated_at`) VALUES
(9, 2000, 1, '2024-11-01', NULL, NULL),
(10, 1000, 5, '2024-12-05', NULL, NULL),
(11, 2000, 7, '2024-12-05', NULL, NULL),
(12, 1000, 8, '2024-12-06', NULL, NULL),
(13, 4000, 5, '2024-12-06', NULL, NULL),
(14, 100, 11, '2024-12-05', NULL, NULL),
(15, 12000, 5, '2024-12-07', NULL, NULL),
(25, 10000, 12, '2024-12-07', NULL, NULL),
(26, 972, 12, '2024-12-08', NULL, NULL),
(33, 100, 14, '2024-12-05', NULL, NULL),
(34, 10, 14, '2024-12-07', NULL, NULL),
(35, 10, 13, '2024-12-05', NULL, NULL),
(36, 20000, 15, '2024-12-08', NULL, NULL),
(37, 10000, 17, '2024-12-09', NULL, NULL),
(38, 500, 15, '2024-12-03', NULL, NULL),
(39, 500, 15, '2024-12-26', NULL, NULL),
(40, 1200, 15, '2024-12-26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_prices`
--

DROP TABLE IF EXISTS `fuel_prices`;
CREATE TABLE IF NOT EXISTS `fuel_prices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `selling_price` double NOT NULL,
  `fuel_type_id` bigint UNSIGNED NOT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `loss_gain_value` float(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fuel_prices_fuel_type_id_foreign` (`fuel_type_id`),
  KEY `fuel_prices_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_prices`
--

INSERT INTO `fuel_prices` (`id`, `selling_price`, `fuel_type_id`, `petrol_pump_id`, `date`, `loss_gain_value`, `created_at`, `updated_at`) VALUES
(3, 250, 13, 4, '2024-11-01', 0.00, '2024-11-18 23:05:05', '2024-11-19 22:18:45'),
(4, 280, 1, 1, '2024-11-01', 0.00, '2024-11-19 16:51:15', '2024-11-19 16:51:15'),
(5, 260, 2, 1, '2024-11-05', 0.00, '2024-11-20 21:25:50', '2024-11-20 21:25:50'),
(6, 265, 1, 1, '2024-12-05', 0.00, '2024-11-25 16:14:02', '2024-12-02 15:20:59'),
(11, 222, 1, 1, '2024-11-02', 0.00, '2024-12-02 15:21:17', '2024-12-02 15:21:17'),
(13, 205, 2, 1, '2024-11-01', 0.00, '2024-12-02 16:22:16', '2024-12-02 16:22:16'),
(14, 207, 2, 1, '2024-11-02', 0.00, '2024-12-02 16:22:57', '2024-12-02 16:22:57'),
(15, 250.14, 2, 7, '2024-12-05', 0.00, '2024-12-05 17:07:11', '2024-12-05 17:07:11'),
(16, 260.14, 1, 7, '2024-12-05', 0.00, '2024-12-05 17:07:28', '2024-12-05 17:07:28'),
(17, 259.9, 1, 8, '2024-12-05', 0.00, '2024-12-06 20:02:25', '2024-12-06 20:02:25'),
(18, 253.8, 2, 8, '2024-12-05', 0.00, '2024-12-06 20:02:48', '2024-12-06 20:02:48'),
(19, 264.99, 4, 8, '2024-12-05', 0.00, '2024-12-06 20:03:01', '2024-12-06 20:03:01'),
(20, 255.12, 1, 9, '2024-12-04', 0.00, '2024-12-06 20:25:37', '2024-12-06 20:25:37'),
(21, 250.11, 2, 9, '2024-12-04', 0.00, '2024-12-06 20:25:47', '2024-12-06 20:25:47'),
(22, 256.99, 4, 9, '2024-12-04', 0.00, '2024-12-06 20:26:01', '2024-12-06 20:26:01'),
(23, 255, 1, 10, '2024-12-04', 0.00, '2024-12-06 21:00:20', '2024-12-06 21:00:20'),
(24, 250, 2, 10, '2024-12-04', 0.00, '2024-12-06 21:00:28', '2024-12-06 21:00:28'),
(25, 256, 4, 10, '2024-12-04', 0.00, '2024-12-06 21:00:38', '2024-12-06 21:00:38'),
(26, 250.12, 2, 11, '2024-12-07', 0.00, '2024-12-08 14:45:07', '2024-12-08 14:45:07'),
(27, 255.14, 1, 11, '2024-12-07', 0.00, '2024-12-08 14:45:18', '2024-12-08 14:45:18'),
(28, 260.15, 4, 11, '2024-12-07', 0.00, '2024-12-08 14:45:30', '2024-12-08 14:45:30'),
(29, 250.45, 2, 13, '2024-12-04', 0.00, '2024-12-09 11:22:44', '2024-12-09 11:22:44'),
(30, 252.14, 1, 13, '2024-12-04', 0.00, '2024-12-09 11:23:03', '2024-12-09 11:23:03'),
(31, 256.15, 4, 13, '2024-12-04', 0.00, '2024-12-09 11:25:14', '2024-12-09 11:25:14'),
(32, 250.15, 2, 14, '2024-12-04', 0.00, '2024-12-09 11:53:47', '2024-12-09 11:53:47'),
(33, 252.15, 1, 14, '2024-12-04', 0.00, '2024-12-09 11:54:06', '2024-12-09 11:54:06'),
(34, 255.15, 4, 14, '2024-12-04', 0.00, '2024-12-09 11:54:15', '2024-12-09 11:54:15'),
(35, 254.1, 2, 15, '2024-12-02', 0.00, '2024-12-10 12:29:54', '2024-12-10 12:29:54'),
(36, 260.95, 1, 15, '2024-12-02', 0.00, '2024-12-10 12:30:04', '2024-12-29 14:10:59'),
(37, 254.1, 2, 16, '2024-12-01', 0.00, '2024-12-11 12:18:29', '2024-12-11 12:18:29'),
(38, 260.93, 1, 16, '2024-12-01', 0.00, '2024-12-11 12:18:41', '2024-12-11 12:18:41'),
(39, 252.4, 2, 17, '2024-12-03', 0.00, '2024-12-11 20:09:51', '2024-12-11 20:09:51'),
(40, 254.5, 1, 17, '2024-12-03', 0.00, '2024-12-11 20:10:03', '2024-12-11 20:10:03'),
(41, 256.65, 4, 17, '2024-12-03', 0.00, '2024-12-11 20:10:13', '2024-12-11 20:10:13'),
(42, 254.1, 2, 12, '2024-12-07', 0.00, '2024-12-13 11:26:05', '2024-12-13 11:26:05'),
(43, 260.93, 1, 12, '2024-12-07', 0.00, '2024-12-13 11:26:27', '2024-12-13 11:26:27'),
(44, 253.12, 2, 18, '2024-12-04', 0.00, '2024-12-13 12:37:23', '2024-12-13 12:37:23'),
(45, 255.15, 1, 18, '2024-12-04', 0.00, '2024-12-13 12:37:42', '2024-12-13 12:37:42'),
(46, 260.13, 4, 18, '2024-12-04', 0.00, '2024-12-13 12:37:59', '2024-12-13 12:37:59'),
(47, 230, 2, 15, '2024-12-08', 0.00, '2024-12-16 15:16:32', '2024-12-16 15:16:32'),
(48, 265, 1, 15, '2024-12-30', 0.00, '2024-12-29 14:19:41', '2024-12-29 14:19:41'),
(49, 270, 1, 15, '2024-12-31', 0.00, '2024-12-29 14:21:04', '2024-12-29 14:21:04'),
(50, 123, 1, 15, '2024-12-09', 0.00, '2024-12-29 14:22:20', '2024-12-29 14:22:20'),
(51, 289, 1, 15, '2024-12-31', 0.00, '2024-12-29 14:41:36', '2024-12-29 14:41:36'),
(52, 300, 1, 15, '2024-12-08', 400.00, '2024-12-29 14:42:30', '2024-12-29 14:42:30'),
(53, 310, 2, 15, '2024-12-02', -300.00, '2024-12-29 14:44:33', '2024-12-29 14:44:33'),
(54, 280, 1, 15, '2025-01-17', 200.00, '2024-12-29 14:45:38', '2024-12-29 14:45:38'),
(55, 270, 1, 15, '2025-01-19', -100.00, '2024-12-29 14:47:14', '2024-12-29 14:47:14'),
(56, 315, 1, 15, '2024-12-04', 0.00, '2024-12-29 15:08:45', '2024-12-29 15:08:45'),
(57, 320, 1, 15, '2024-12-11', 0.00, '2024-12-29 15:09:11', '2024-12-29 15:09:11'),
(58, 55, 1, 15, '2024-12-04', -1000893.81, '2024-12-29 15:14:45', '2024-12-29 15:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_purchases`
--

DROP TABLE IF EXISTS `fuel_purchases`;
CREATE TABLE IF NOT EXISTS `fuel_purchases` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `fuel_type_id` bigint UNSIGNED NOT NULL,
  `quantity_ltr` double NOT NULL,
  `buying_price_per_ltr` double NOT NULL,
  `purchase_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fuel_purchases_petrol_pump_id_foreign` (`petrol_pump_id`),
  KEY `fuel_purchases_fuel_type_id_foreign` (`fuel_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_purchases`
--

INSERT INTO `fuel_purchases` (`id`, `petrol_pump_id`, `fuel_type_id`, `quantity_ltr`, `buying_price_per_ltr`, `purchase_date`, `created_at`, `updated_at`) VALUES
(1, 7, 2, 5000, 245.14, '2024-12-05', '2024-12-05 17:08:31', '2024-12-05 17:08:31'),
(2, 7, 2, 4000, 245.14, '2024-12-03', '2024-12-05 17:09:14', '2024-12-05 17:09:14'),
(3, 7, 1, 5000, 250.14, '2024-12-05', '2024-12-05 17:25:52', '2024-12-05 17:25:52'),
(4, 7, 2, 5000, 245.14, '2024-12-07', '2024-12-06 16:32:21', '2024-12-06 16:32:21'),
(5, 8, 2, 16378, 246.68, '2024-12-05', '2024-12-06 20:05:01', '2024-12-06 20:05:01'),
(6, 8, 1, 8480, 253.03, '2024-12-05', '2024-12-06 20:05:55', '2024-12-06 20:05:55'),
(7, 8, 4, 7144, 257.49, '2024-12-05', '2024-12-06 20:06:20', '2024-12-06 20:06:20'),
(8, 9, 2, 10, 246.68, '2024-12-04', '2024-12-06 20:38:25', '2024-12-06 20:38:25'),
(9, 9, 1, 10, 253.03, '2024-12-04', '2024-12-06 20:38:41', '2024-12-06 20:38:41'),
(10, 9, 4, 10, 257.49, '2024-12-04', '2024-12-06 20:38:53', '2024-12-06 20:38:53'),
(11, 10, 1, 1000, 249.5, '2024-12-05', '2024-12-06 21:05:45', '2024-12-06 21:05:45'),
(12, 10, 2, 1000, 244.5, '2024-12-05', '2024-12-06 21:06:05', '2024-12-06 21:06:05'),
(13, 10, 4, 1000, 253.03, '2024-12-05', '2024-12-06 21:06:20', '2024-12-06 21:06:20'),
(14, 11, 2, 5000, 245.14, '2024-12-07', '2024-12-08 14:46:06', '2024-12-08 14:46:06'),
(15, 11, 1, 3000, 250.14, '2024-12-07', '2024-12-08 14:46:24', '2024-12-08 14:46:24'),
(16, 11, 4, 4000, 255.14, '2024-12-07', '2024-12-08 14:46:43', '2024-12-08 14:46:43'),
(17, 13, 2, 1010, 245, '2024-12-05', '2024-12-09 11:34:10', '2024-12-09 11:34:10'),
(18, 13, 1, 1010, 250, '2024-12-05', '2024-12-09 11:34:50', '2024-12-09 11:34:50'),
(19, 13, 4, 1010, 252, '2024-12-05', '2024-12-09 11:35:12', '2024-12-09 11:35:12'),
(20, 14, 2, 1000, 245.15, '2024-12-04', '2024-12-09 11:54:47', '2024-12-09 11:54:47'),
(21, 14, 1, 1000, 247.14, '2024-12-04', '2024-12-09 11:55:17', '2024-12-09 11:55:17'),
(22, 14, 4, 1000, 250.42, '2024-12-04', '2024-12-09 11:55:38', '2024-12-09 11:55:38'),
(23, 14, 2, 991, 250.15, '2024-12-05', '2024-12-09 12:41:58', '2024-12-09 12:41:58'),
(24, 14, 2, 991, 250.15, '2024-12-05', '2024-12-09 12:43:28', '2024-12-09 12:43:28'),
(25, 14, 2, 1, 245.15, '2024-12-06', '2024-12-09 12:45:59', '2024-12-09 12:45:59'),
(26, 15, 2, 187575.45, 250, '2024-12-02', '2024-12-10 12:43:47', '2024-12-10 12:43:47'),
(27, 15, 1, 128912.46, 250, '2024-12-02', '2024-12-10 12:44:07', '2024-12-10 12:44:07'),
(28, 15, 2, 2932.99, 244.86, '2024-12-03', '2024-12-10 12:46:48', '2024-12-10 12:46:48'),
(29, 15, 1, 928.42, 251.19, '2024-12-03', '2024-12-10 12:47:28', '2024-12-10 12:47:28'),
(30, 15, 2, 5000, 244.86, '2024-12-07', '2024-12-11 11:59:29', '2024-12-11 11:59:29'),
(31, 15, 1, 2000, 251.19, '2024-12-07', '2024-12-11 11:59:43', '2024-12-11 11:59:43'),
(32, 16, 2, 187154.03, 254.1, '2024-12-01', '2024-12-11 12:25:11', '2024-12-11 12:25:11'),
(33, 16, 1, 128749.5, 260.93, '2024-12-01', '2024-12-11 12:25:41', '2024-12-11 12:25:41'),
(34, 16, 2, 3286.2, 244.86, '2024-12-02', '2024-12-11 12:26:52', '2024-12-11 12:26:52'),
(35, 16, 1, 1090.38, 251.19, '2024-12-02', '2024-12-11 12:27:27', '2024-12-11 12:27:27'),
(36, 17, 2, 1000, 248.5, '2024-12-03', '2024-12-11 20:23:29', '2024-12-11 20:23:29'),
(37, 17, 1, 1000, 250.5, '2024-12-03', '2024-12-11 20:23:45', '2024-12-11 20:23:45'),
(38, 17, 4, 1000, 252.48, '2024-12-03', '2024-12-11 20:24:02', '2024-12-11 20:24:02'),
(39, 16, 2, 5000, 244.86, '2024-12-07', '2024-12-13 11:13:43', '2024-12-13 11:13:43'),
(40, 16, 1, 2000, 251.19, '2024-12-07', '2024-12-13 11:13:58', '2024-12-13 11:13:58'),
(41, 12, 2, 6562.2, 244.86, '2024-12-07', '2024-12-13 11:27:13', '2024-12-13 11:27:13'),
(42, 12, 1, 2360.82, 251.19, '2024-12-07', '2024-12-13 11:27:29', '2024-12-13 11:27:29'),
(43, 12, 2, 75.4, 244.86, '2024-12-10', '2024-12-13 11:45:30', '2024-12-13 11:45:30'),
(44, 12, 1, 7, 251.19, '2024-12-10', '2024-12-13 11:46:05', '2024-12-13 11:46:05'),
(45, 18, 2, 10000, 240.13, '2024-12-03', '2024-12-13 12:38:56', '2024-12-13 12:38:56'),
(46, 18, 1, 5000, 230.45, '2024-12-03', '2024-12-13 12:39:56', '2024-12-13 12:39:56'),
(47, 15, 1, 2500, 255, '2024-12-30', '2024-12-29 14:32:19', '2024-12-29 14:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_types`
--

DROP TABLE IF EXISTS `fuel_types`;
CREATE TABLE IF NOT EXISTS `fuel_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fuel_types_company_id_foreign` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fuel_types`
--

INSERT INTO `fuel_types` (`id`, `name`, `created_at`, `updated_at`, `company_id`) VALUES
(1, 'Diesel', '2024-11-15 22:39:40', '2024-11-15 22:39:40', 3),
(2, 'Petrol', '2024-11-15 22:41:24', '2024-11-15 22:41:24', 3),
(4, 'Hi Octaine', '2024-11-15 22:44:05', '2024-11-15 22:44:05', 3),
(7, 'Octane 92', '2024-11-16 13:35:37', '2024-11-16 13:35:37', 3),
(11, 'Diesel', '2024-11-18 23:00:16', '2024-11-18 23:00:16', 9),
(12, 'Petrol', '2024-11-18 23:00:31', '2024-11-18 23:00:31', 9),
(13, 'Hi-Super', '2024-11-19 19:43:03', '2024-11-19 19:43:03', 9),
(14, 'BENZENE 95', '2024-11-30 10:47:06', '2024-11-30 10:47:06', 3),
(15, 'pp2', '2024-12-13 12:16:42', '2024-12-13 12:16:42', 3);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_02_130936_create_permission_tables', 2),
(5, '2024_11_03_174125_create_personal_access_tokens_table', 3),
(8, '2024_11_04_162919_create_personal_access_tokens_table', 4),
(9, '2024_11_11_091202_create_companies_table', 4),
(13, '2024_11_12_143828_create_team_members_table', 5),
(14, '2024_11_13_181953_alter_table_users_add_soft_delete', 6),
(15, '2024_11_13_221041_add_address_phone_image_to_users_table', 7),
(16, '2024_11_14_115108_add_verification_token_to_users_table', 8),
(19, '2024_11_15_092048_create_petrol_pumps_table', 9),
(20, '2024_11_15_215247_create_fuel_types_table', 10),
(21, '2024_11_16_144827_create_fuel_prices_table', 11),
(22, '2024_11_17_162029_remove_buying_price_from_fuel_prices_table', 12),
(23, '2024_11_19_170055_create_tanks_table', 13),
(26, '2024_11_20_021145_create_tank_stocks_table', 14),
(27, '2024_11_21_151717_create_nozzles_table', 15),
(28, '2024_11_22_013657_create_nozzle_readings_table', 16),
(29, '2024_11_23_172537_create_customers_table', 17),
(30, '2024_11_23_185500_add_phone_to_customers_table', 18),
(33, '2024_11_23_213201_create_customer_credits_table', 19),
(34, '2024_11_23_215237_create_employees_table', 20),
(35, '2024_11_23_215525_create_employee_wages_table', 21),
(36, '2024_11_24_012012_create_products_table', 22),
(37, '2024_11_25_150856_add_total_salary_to_employees_table', 23),
(39, '2024_11_26_041741_create_card_payments_table_and_transfers_table', 24),
(41, '2024_11_26_152329_create_extras_table', 25),
(42, '2024_11_30_214639_rename_products_to_product_data_in_product_sales', 26),
(43, '2024_12_03_134420_create_fuel_purchases_table', 27),
(44, '2024_12_04_160735_remove_reading_in_mm_from_tank_stocks_table', 28),
(45, '2024_12_05_152452_create_dip_records_table', 28),
(46, '2024_12_07_220913_create_tank_transfers_table', 29),
(47, '2024_12_08_011924_add_buying_price_to_products_table', 29),
(48, '2024_12_08_025602_add_profit_to_product_sales_table', 29),
(49, '2024_12_10_023451_add_columns_to_card_payments_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\TeamMember', 1),
(3, 'App\\Models\\TeamMember', 2),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(3, 'App\\Models\\TeamMember', 8),
(2, 'App\\Models\\User', 8),
(3, 'App\\Models\\TeamMember', 9),
(2, 'App\\Models\\User', 9),
(3, 'App\\Models\\TeamMember', 10),
(3, 'App\\Models\\TeamMember', 11),
(3, 'App\\Models\\TeamMember', 12),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 26),
(2, 'App\\Models\\User', 28),
(3, 'App\\Models\\User', 29);

-- --------------------------------------------------------

--
-- Table structure for table `nozzles`
--

DROP TABLE IF EXISTS `nozzles`;
CREATE TABLE IF NOT EXISTS `nozzles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `tank_id` bigint UNSIGNED NOT NULL,
  `fuel_type_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nozzles_petrol_pump_id_foreign` (`petrol_pump_id`),
  KEY `nozzles_tank_id_foreign` (`tank_id`),
  KEY `nozzles_fuel_type_id_foreign` (`fuel_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nozzles`
--

INSERT INTO `nozzles` (`id`, `name`, `petrol_pump_id`, `tank_id`, `fuel_type_id`, `created_at`, `updated_at`) VALUES
(2, 'N2', 1, 2, 1, '2024-11-21 23:38:00', '2024-11-21 23:38:00'),
(3, 'N3', 1, 2, 1, '2024-11-21 23:38:07', '2024-11-21 23:38:07'),
(9, 'Pt 1', 1, 5, 2, '2024-12-02 15:27:55', '2024-12-02 15:27:55'),
(10, 'Pt 2', 1, 5, 2, '2024-12-02 15:28:08', '2024-12-02 15:28:08'),
(11, '1', 7, 11, 2, '2024-12-05 17:05:59', '2024-12-05 17:05:59'),
(12, '2', 7, 11, 2, '2024-12-05 17:06:13', '2024-12-05 17:06:13'),
(13, '3', 7, 12, 1, '2024-12-05 17:06:28', '2024-12-05 17:06:28'),
(14, '4', 7, 12, 1, '2024-12-05 17:06:40', '2024-12-05 17:06:40'),
(15, 'syed', 7, 12, 1, '2024-12-06 13:38:48', '2024-12-06 13:38:48'),
(16, 'Nosal 1', 8, 14, 2, '2024-12-06 20:11:57', '2024-12-06 20:11:57'),
(17, 'Nosal 2', 8, 14, 2, '2024-12-06 20:12:15', '2024-12-06 20:12:15'),
(18, 'Nosal 3', 8, 14, 2, '2024-12-06 20:12:25', '2024-12-06 20:12:25'),
(19, 'Nosal 4', 8, 14, 2, '2024-12-06 20:12:39', '2024-12-06 20:12:39'),
(20, 'Nosal 5', 8, 14, 2, '2024-12-06 20:13:00', '2024-12-06 20:13:00'),
(21, 'Nosal 6', 8, 14, 2, '2024-12-06 20:13:14', '2024-12-06 20:13:14'),
(22, 'Nosal 7', 8, 14, 2, '2024-12-06 20:13:22', '2024-12-06 20:13:22'),
(23, 'Nosal 8', 8, 14, 2, '2024-12-06 20:13:33', '2024-12-06 20:13:33'),
(24, 'Nosal 1', 8, 13, 1, '2024-12-06 20:13:45', '2024-12-06 20:13:45'),
(25, 'Nosal 2', 8, 13, 1, '2024-12-06 20:13:55', '2024-12-06 20:13:55'),
(26, 'Nosal 3', 8, 13, 1, '2024-12-06 20:14:08', '2024-12-06 20:14:08'),
(27, 'Nosal 4', 8, 13, 1, '2024-12-06 20:14:16', '2024-12-06 20:14:16'),
(28, 'HOBC 1', 8, 15, 4, '2024-12-06 20:14:35', '2024-12-06 20:14:35'),
(29, 'HOBC 2', 8, 15, 4, '2024-12-06 20:14:45', '2024-12-06 20:14:45'),
(30, 'Nosal 1', 9, 17, 1, '2024-12-06 20:23:06', '2024-12-06 20:23:06'),
(31, 'Nosal 2', 9, 17, 1, '2024-12-06 20:23:16', '2024-12-06 20:23:16'),
(32, 'Nosal 1', 9, 16, 2, '2024-12-06 20:23:27', '2024-12-06 20:23:27'),
(33, 'Nosal 2', 9, 16, 2, '2024-12-06 20:23:43', '2024-12-06 20:23:43'),
(34, 'Nosal 1', 9, 18, 4, '2024-12-06 20:24:15', '2024-12-06 20:24:15'),
(35, 'Nosal 2', 9, 18, 4, '2024-12-06 20:24:23', '2024-12-06 20:24:23'),
(36, '1', 10, 19, 1, '2024-12-06 21:00:56', '2024-12-06 21:00:56'),
(37, '1', 10, 20, 2, '2024-12-06 21:01:04', '2024-12-06 21:01:04'),
(38, '1', 10, 21, 4, '2024-12-06 21:01:14', '2024-12-06 21:01:14'),
(39, '1', 11, 22, 2, '2024-12-08 14:47:14', '2024-12-08 14:47:14'),
(40, '2', 11, 23, 1, '2024-12-08 14:47:23', '2024-12-08 14:47:23'),
(41, '3', 11, 24, 4, '2024-12-08 14:47:35', '2024-12-08 14:47:35'),
(42, 'Nosal 1', 13, 25, 2, '2024-12-09 11:21:32', '2024-12-09 11:21:32'),
(43, 'Nosal 1', 13, 26, 1, '2024-12-09 11:21:44', '2024-12-09 11:21:44'),
(44, 'Nosal 1', 13, 27, 4, '2024-12-09 11:21:56', '2024-12-09 11:21:56'),
(45, 'Nosal 1', 14, 29, 2, '2024-12-09 12:00:46', '2024-12-09 12:01:17'),
(46, 'Nosa 1', 14, 30, 1, '2024-12-09 12:01:37', '2024-12-09 12:01:37'),
(47, 'Nosal 1', 14, 31, 4, '2024-12-09 12:01:57', '2024-12-09 12:01:57'),
(48, 'Nozzle 1', 15, 32, 2, '2024-12-10 12:24:04', '2024-12-10 12:24:04'),
(49, 'Nozzle 2', 15, 32, 2, '2024-12-10 12:24:18', '2024-12-10 12:24:18'),
(50, 'Nozzle 1', 15, 33, 1, '2024-12-10 12:24:30', '2024-12-10 12:24:30'),
(51, 'Nozzle 2', 15, 33, 1, '2024-12-10 12:24:43', '2024-12-10 12:24:43'),
(52, 'Nozzle 2', 14, 29, 2, '2024-12-10 13:59:17', '2024-12-10 13:59:17'),
(53, 'Petrol 1', 16, 34, 2, '2024-12-11 12:19:55', '2024-12-11 12:19:55'),
(54, 'Petrol 2', 16, 34, 2, '2024-12-11 12:20:05', '2024-12-11 12:20:05'),
(55, 'Diesel 1', 16, 35, 1, '2024-12-11 12:20:16', '2024-12-11 12:20:16'),
(56, 'Diesel 2', 16, 35, 1, '2024-12-11 12:20:32', '2024-12-11 12:20:32'),
(57, 'Nozzle 1', 17, 37, 1, '2024-12-11 20:21:12', '2024-12-11 20:21:12'),
(58, 'Nozzle 1', 17, 36, 2, '2024-12-11 20:21:32', '2024-12-11 20:21:32'),
(59, 'Nozzle 1', 17, 38, 4, '2024-12-11 20:21:50', '2024-12-11 20:21:50'),
(60, 'Nozzle 1', 12, 39, 2, '2024-12-13 11:28:14', '2024-12-13 11:28:14'),
(61, 'Nozzle 2', 12, 39, 2, '2024-12-13 11:28:23', '2024-12-13 11:28:23'),
(62, 'Nozzle 1', 12, 40, 1, '2024-12-13 11:28:34', '2024-12-13 11:28:34'),
(63, 'Diesel 1', 18, 41, 1, '2024-12-13 12:22:08', '2024-12-13 12:22:08'),
(64, 'Diesel 2', 18, 41, 1, '2024-12-13 12:23:24', '2024-12-13 12:23:24'),
(65, 'Diesel 3', 18, 42, 1, '2024-12-13 12:24:10', '2024-12-13 12:24:10'),
(66, 'Diesel 4', 18, 42, 1, '2024-12-13 12:24:26', '2024-12-13 12:24:26'),
(67, 'Petrol 5', 18, 43, 2, '2024-12-13 12:24:44', '2024-12-13 12:24:44'),
(68, 'Petrol 6', 18, 43, 2, '2024-12-13 12:25:06', '2024-12-13 12:25:06'),
(69, 'Petrol 7', 18, 43, 2, '2024-12-13 12:25:23', '2024-12-13 12:25:23'),
(70, 'Petrol 8', 18, 43, 2, '2024-12-13 12:26:30', '2024-12-13 12:26:30'),
(71, 'Testing23Dec', 15, 32, 2, '2024-12-23 11:22:35', '2024-12-23 11:22:35');

-- --------------------------------------------------------

--
-- Table structure for table `nozzle_readings`
--

DROP TABLE IF EXISTS `nozzle_readings`;
CREATE TABLE IF NOT EXISTS `nozzle_readings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `analog_reading` decimal(8,2) NOT NULL,
  `digital_reading` decimal(8,2) NOT NULL,
  `nozzle_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nozzle_readings_nozzle_id_foreign` (`nozzle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=381 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nozzle_readings`
--

INSERT INTO `nozzle_readings` (`id`, `analog_reading`, `digital_reading`, `nozzle_id`, `date`, `created_at`, `updated_at`) VALUES
(29, 97.00, 99.00, 2, '2024-11-01', NULL, NULL),
(30, 98.00, 100.00, 3, '2024-11-01', NULL, NULL),
(31, 97.00, 98.00, 9, '2024-11-01', NULL, NULL),
(32, 97.00, 99.00, 10, '2024-11-01', NULL, NULL),
(33, 1000.00, 1002.00, 11, '2024-12-05', NULL, NULL),
(34, 503.00, 506.00, 12, '2024-12-05', NULL, NULL),
(35, 113.00, 120.00, 13, '2024-12-05', NULL, NULL),
(36, 129.00, 420.00, 14, '2024-12-05', NULL, NULL),
(37, 2000.00, 2002.00, 11, '2024-12-05', NULL, NULL),
(38, 2500.00, 2506.00, 12, '2024-12-05', NULL, NULL),
(39, 2113.00, 2120.00, 13, '2024-12-05', NULL, NULL),
(40, 129.00, 420.00, 14, '2024-12-05', NULL, NULL),
(41, 0.00, 0.00, 15, '2024-12-05', NULL, NULL),
(42, 2000.00, 2002.00, 11, '2024-12-06', NULL, NULL),
(43, 2500.00, 2500.00, 12, '2024-12-06', NULL, NULL),
(44, 2113.00, 2120.00, 13, '2024-12-06', NULL, NULL),
(45, 129.00, 420.00, 14, '2024-12-06', NULL, NULL),
(46, 0.00, 0.00, 15, '2024-12-06', NULL, NULL),
(47, 2000.00, 2002.00, 11, '2024-12-06', NULL, NULL),
(48, 2500.00, 2500.00, 12, '2024-12-06', NULL, NULL),
(49, 2115.00, 2122.00, 13, '2024-12-06', NULL, NULL),
(50, 131.00, 422.00, 14, '2024-12-06', NULL, NULL),
(51, 10.00, 10.00, 15, '2024-12-06', NULL, NULL),
(52, 4.00, 4.00, 30, '2024-12-04', NULL, NULL),
(53, 3.00, 3.00, 31, '2024-12-04', NULL, NULL),
(54, 3.00, 3.00, 32, '2024-12-04', NULL, NULL),
(55, 2.00, 2.00, 33, '2024-12-04', NULL, NULL),
(56, 1.00, 1.00, 34, '2024-12-04', NULL, NULL),
(57, 1.00, 1.00, 35, '2024-12-04', NULL, NULL),
(58, 0.00, 2.00, 36, '2024-12-04', NULL, NULL),
(59, 0.00, 4.00, 37, '2024-12-04', NULL, NULL),
(60, 0.00, 2.00, 38, '2024-12-04', NULL, NULL),
(61, 0.00, 4.00, 36, '2024-12-05', NULL, NULL),
(62, 0.00, 6.00, 37, '2024-12-05', NULL, NULL),
(63, 0.00, 4.00, 38, '2024-12-05', NULL, NULL),
(68, 2500.00, 2500.00, 11, '2024-12-10', NULL, NULL),
(69, 2500.00, 2500.00, 12, '2024-12-10', NULL, NULL),
(70, 2115.00, 2122.00, 13, '2024-12-10', NULL, NULL),
(71, 131.00, 422.00, 14, '2024-12-10', NULL, NULL),
(72, 10.00, 10.00, 15, '2024-12-10', NULL, NULL),
(73, 2500.00, 2500.00, 11, '2024-12-07', NULL, NULL),
(74, 2500.00, 2500.00, 12, '2024-12-07', NULL, NULL),
(75, 2115.00, 2122.00, 13, '2024-12-07', NULL, NULL),
(76, 131.00, 422.00, 14, '2024-12-07', NULL, NULL),
(77, 10.00, 10.00, 15, '2024-12-07', NULL, NULL),
(93, 120.00, 120.00, 39, '2024-12-07', NULL, NULL),
(94, 120.00, 120.00, 40, '2024-12-07', NULL, NULL),
(95, 120.00, 120.00, 41, '2024-12-07', NULL, NULL),
(96, 130.00, 130.00, 39, '2024-12-08', NULL, NULL),
(97, 130.00, 130.00, 40, '2024-12-08', NULL, NULL),
(98, 130.00, 130.00, 41, '2024-12-08', NULL, NULL),
(99, 0.00, 10.00, 42, '2024-12-03', NULL, NULL),
(100, 0.00, 10.00, 43, '2024-12-03', NULL, NULL),
(101, 0.00, 10.00, 44, '2024-12-03', NULL, NULL),
(120, 0.00, 10.00, 45, '2024-12-04', NULL, NULL),
(121, 0.00, 10.00, 46, '2024-12-04', NULL, NULL),
(122, 0.00, 10.00, 47, '2024-12-04', NULL, NULL),
(123, 0.00, 12.00, 45, '2024-12-05', NULL, NULL),
(124, 0.00, 12.00, 46, '2024-12-05', NULL, NULL),
(125, 0.00, 12.00, 47, '2024-12-05', NULL, NULL),
(126, 140.00, 140.00, 39, '2024-12-09', NULL, NULL),
(127, 140.00, 140.00, 40, '2024-12-09', NULL, NULL),
(128, 140.00, 140.00, 41, '2024-12-09', NULL, NULL),
(129, 0.00, 14.00, 45, '2024-12-06', NULL, NULL),
(130, 0.00, 14.00, 46, '2024-12-06', NULL, NULL),
(131, 0.00, 14.00, 47, '2024-12-06', NULL, NULL),
(132, 0.00, 15.00, 45, '2024-12-07', NULL, NULL),
(133, 0.00, 15.00, 46, '2024-12-07', NULL, NULL),
(134, 0.00, 15.00, 47, '2024-12-07', NULL, NULL),
(135, 0.00, 1.00, 42, '2024-12-05', NULL, NULL),
(136, 0.00, 1.00, 43, '2024-12-05', NULL, NULL),
(137, 1.00, 1.00, 44, '2024-12-05', NULL, NULL),
(138, 0.00, 2.00, 42, '2024-12-06', NULL, NULL),
(139, 0.00, 2.00, 43, '2024-12-06', NULL, NULL),
(140, 0.00, 2.00, 44, '2024-12-06', NULL, NULL),
(141, 0.00, 4.00, 42, '2024-12-07', NULL, NULL),
(142, 0.00, 4.00, 43, '2024-12-07', NULL, NULL),
(143, 0.00, 4.00, 44, '2024-12-07', NULL, NULL),
(152, 0.00, 23329.79, 48, '2024-12-02', NULL, NULL),
(153, 0.00, 164245.66, 49, '2024-12-02', NULL, NULL),
(154, 0.00, 97432.38, 50, '2024-12-02', NULL, NULL),
(155, 0.00, 31480.08, 51, '2024-12-02', NULL, NULL),
(156, 0.00, 23374.84, 48, '2024-12-03', NULL, NULL),
(157, 0.00, 164570.35, 49, '2024-12-03', NULL, NULL),
(158, 0.00, 97541.71, 50, '2024-12-03', NULL, NULL),
(159, 0.00, 31480.08, 51, '2024-12-03', NULL, NULL),
(160, 0.00, 23429.49, 48, '2024-12-04', NULL, NULL),
(161, 0.00, 164859.47, 49, '2024-12-04', NULL, NULL),
(162, 0.00, 97645.35, 50, '2024-12-04', NULL, NULL),
(163, 0.00, 31480.08, 51, '2024-12-04', NULL, NULL),
(164, 150.00, 150.00, 39, '2024-12-10', NULL, NULL),
(165, 150.00, 150.00, 40, '2024-12-10', NULL, NULL),
(166, 150.00, 150.00, 41, '2024-12-10', NULL, NULL),
(167, 0.00, 23486.68, 48, '2024-12-05', NULL, NULL),
(168, 0.00, 165257.73, 49, '2024-12-05', NULL, NULL),
(169, 0.00, 97799.08, 50, '2024-12-05', NULL, NULL),
(170, 0.00, 31480.08, 51, '2024-12-05', NULL, NULL),
(171, 0.00, 23561.12, 48, '2024-12-06', NULL, NULL),
(172, 0.00, 165596.86, 49, '2024-12-06', NULL, NULL),
(173, 0.00, 98004.98, 50, '2024-12-06', NULL, NULL),
(174, 0.00, 31480.08, 51, '2024-12-06', NULL, NULL),
(175, 0.00, 23625.06, 48, '2024-12-07', NULL, NULL),
(176, 0.00, 166011.57, 49, '2024-12-07', NULL, NULL),
(177, 0.00, 98090.68, 50, '2024-12-07', NULL, NULL),
(178, 0.00, 31480.08, 51, '2024-12-07', NULL, NULL),
(179, 0.00, 23625.06, 48, '2024-12-08', NULL, NULL),
(180, 0.00, 166331.16, 49, '2024-12-08', NULL, NULL),
(181, 0.00, 98205.48, 50, '2024-12-08', NULL, NULL),
(182, 0.00, 31480.08, 51, '2024-12-08', NULL, NULL),
(183, 0.00, 23258.82, 53, '2024-12-01', NULL, NULL),
(184, 0.00, 163895.21, 54, '2024-12-01', NULL, NULL),
(185, 0.00, 97269.42, 55, '2024-12-01', NULL, NULL),
(186, 0.00, 31480.08, 56, '2024-12-01', NULL, NULL),
(187, 0.00, 23329.79, 53, '2024-12-02', NULL, NULL),
(188, 0.00, 164245.66, 54, '2024-12-02', NULL, NULL),
(189, 0.00, 97432.38, 55, '2024-12-02', NULL, NULL),
(190, 0.00, 31480.08, 56, '2024-12-02', NULL, NULL),
(191, 0.00, 23374.84, 53, '2024-12-03', NULL, NULL),
(192, 0.00, 164570.35, 54, '2024-12-03', NULL, NULL),
(193, 0.00, 97541.71, 55, '2024-12-03', NULL, NULL),
(194, 0.00, 31480.08, 56, '2024-12-03', NULL, NULL),
(195, 0.00, 23429.49, 53, '2024-12-04', NULL, NULL),
(196, 0.00, 164859.47, 54, '2024-12-04', NULL, NULL),
(197, 0.00, 97645.35, 55, '2024-12-04', NULL, NULL),
(198, 0.00, 31480.08, 56, '2024-12-04', NULL, NULL),
(199, 0.00, 23486.68, 53, '2024-12-05', NULL, NULL),
(200, 0.00, 165257.73, 54, '2024-12-05', NULL, NULL),
(201, 0.00, 97799.08, 55, '2024-12-05', NULL, NULL),
(202, 0.00, 31480.08, 56, '2024-12-05', NULL, NULL),
(203, 0.00, 23561.12, 53, '2024-12-06', NULL, NULL),
(204, 0.00, 165596.86, 54, '2024-12-06', NULL, NULL),
(205, 0.00, 98004.98, 55, '2024-12-06', NULL, NULL),
(206, 0.00, 31480.08, 56, '2024-12-06', NULL, NULL),
(207, 0.00, 6.00, 42, '2024-12-08', NULL, NULL),
(208, 0.00, 6.00, 43, '2024-12-08', NULL, NULL),
(209, 0.00, 6.00, 44, '2024-12-08', NULL, NULL),
(210, 0.00, 2.00, 57, '2024-12-03', NULL, NULL),
(211, 0.00, 2.00, 58, '2024-12-03', NULL, NULL),
(212, 0.00, 2.00, 59, '2024-12-03', NULL, NULL),
(217, 0.00, 63.94, 60, '2024-12-07', NULL, NULL),
(218, 0.00, 414.71, 61, '2024-12-07', NULL, NULL),
(219, 0.00, 85.70, 62, '2024-12-07', NULL, NULL),
(220, 0.00, 118.71, 60, '2024-12-08', NULL, NULL),
(221, 0.00, 734.30, 61, '2024-12-08', NULL, NULL),
(222, 0.00, 200.50, 62, '2024-12-08', NULL, NULL),
(223, 0.00, 168.99, 60, '2024-12-09', NULL, NULL),
(224, 0.00, 1121.21, 61, '2024-12-09', NULL, NULL),
(225, 0.00, 386.74, 62, '2024-12-09', NULL, NULL),
(226, 0.00, 253.25, 60, '2024-12-10', NULL, NULL),
(227, 0.00, 1456.56, 61, '2024-12-10', NULL, NULL),
(228, 0.00, 530.99, 62, '2024-12-10', NULL, NULL),
(229, 120.00, 120.00, 63, '2024-12-09', NULL, NULL),
(230, 120.00, 120.00, 64, '2024-12-09', NULL, NULL),
(231, 120.00, 120.00, 65, '2024-12-09', NULL, NULL),
(232, 120.00, 120.00, 66, '2024-12-09', NULL, NULL),
(233, 120.00, 120.00, 67, '2024-12-09', NULL, NULL),
(234, 120.00, 120.00, 68, '2024-12-09', NULL, NULL),
(235, 120.00, 120.00, 69, '2024-12-09', NULL, NULL),
(236, 120.00, 120.00, 70, '2024-12-09', NULL, NULL),
(237, 0.00, 23625.06, 48, '2024-12-04', NULL, NULL),
(238, 0.00, 166331.16, 49, '2024-12-04', NULL, NULL),
(239, 0.00, 98205.48, 50, '2024-12-04', NULL, NULL),
(240, 0.00, 31480.08, 51, '2024-12-04', NULL, NULL),
(241, 100.00, 23630.06, 48, '2024-12-27', NULL, NULL),
(242, 0.00, 166331.16, 49, '2024-12-27', NULL, NULL),
(243, 0.00, 0.00, 71, '2024-12-27', NULL, NULL),
(244, 0.00, 98205.48, 50, '2024-12-27', NULL, NULL),
(245, 0.00, 31480.08, 51, '2024-12-27', NULL, NULL),
(246, 100.00, 23630.06, 48, '2024-12-03', NULL, NULL),
(247, 0.00, 166331.16, 49, '2024-12-03', NULL, NULL),
(248, 0.00, 0.00, 71, '2024-12-03', NULL, NULL),
(249, 0.00, 98205.48, 50, '2024-12-03', NULL, NULL),
(250, 0.00, 31480.08, 51, '2024-12-03', NULL, NULL),
(251, 100.00, 23630.06, 48, '2024-12-04', NULL, NULL),
(252, 0.00, 166331.16, 49, '2024-12-04', NULL, NULL),
(253, 0.00, 0.00, 71, '2024-12-04', NULL, NULL),
(254, 0.00, 98205.48, 50, '2024-12-04', NULL, NULL),
(255, 0.00, 31480.08, 51, '2024-12-04', NULL, NULL),
(266, 200.00, 24000.00, 48, '2024-12-26', NULL, NULL),
(267, 0.00, 166331.16, 49, '2024-12-26', NULL, NULL),
(268, 0.00, 0.00, 71, '2024-12-26', NULL, NULL),
(269, 0.00, 98205.48, 50, '2024-12-26', NULL, NULL),
(270, 0.00, 31480.08, 51, '2024-12-26', NULL, NULL),
(271, 300.00, 24050.00, 48, '2024-12-26', NULL, NULL),
(272, 0.00, 166331.16, 49, '2024-12-26', NULL, NULL),
(273, 0.00, 0.00, 71, '2024-12-26', NULL, NULL),
(274, 0.00, 98205.48, 50, '2024-12-26', NULL, NULL),
(275, 0.00, 31480.08, 51, '2024-12-26', NULL, NULL),
(276, 400.00, 25100.00, 48, '2024-12-28', NULL, NULL),
(277, 0.00, 166331.16, 49, '2024-12-28', NULL, NULL),
(278, 0.00, 0.00, 71, '2024-12-28', NULL, NULL),
(279, 0.00, 98205.48, 50, '2024-12-28', NULL, NULL),
(280, 0.00, 31480.08, 51, '2024-12-28', NULL, NULL),
(281, 400.00, 25500.00, 48, '2024-12-30', NULL, NULL),
(282, 0.00, 166331.16, 49, '2024-12-30', NULL, NULL),
(283, 0.00, 0.00, 71, '2024-12-30', NULL, NULL),
(284, 0.00, 98205.48, 50, '2024-12-30', NULL, NULL),
(285, 0.00, 31480.08, 51, '2024-12-30', NULL, NULL),
(286, 400.00, 25600.00, 48, '2024-12-31', NULL, NULL),
(287, 0.00, 166331.16, 49, '2024-12-31', NULL, NULL),
(288, 0.00, 0.00, 71, '2024-12-31', NULL, NULL),
(289, 0.00, 98205.48, 50, '2024-12-31', NULL, NULL),
(290, 0.00, 31480.08, 51, '2024-12-31', NULL, NULL),
(291, 400.00, 25650.00, 48, '2024-12-08', NULL, NULL),
(292, 0.00, 166331.16, 49, '2024-12-08', NULL, NULL),
(293, 0.00, 0.00, 71, '2024-12-08', NULL, NULL),
(294, 0.00, 98205.48, 50, '2024-12-08', NULL, NULL),
(295, 0.00, 31480.08, 51, '2024-12-08', NULL, NULL),
(296, 400.00, 25750.00, 48, '2024-12-09', NULL, NULL),
(297, 0.00, 166331.16, 49, '2024-12-09', NULL, NULL),
(298, 0.00, 0.00, 71, '2024-12-09', NULL, NULL),
(299, 0.00, 98205.48, 50, '2024-12-09', NULL, NULL),
(300, 0.00, 31480.08, 51, '2024-12-09', NULL, NULL),
(301, 400.00, 25800.00, 48, '2024-12-15', NULL, NULL),
(302, 0.00, 166331.16, 49, '2024-12-15', NULL, NULL),
(303, 0.00, 0.00, 71, '2024-12-15', NULL, NULL),
(304, 0.00, 98205.48, 50, '2024-12-15', NULL, NULL),
(305, 0.00, 31480.08, 51, '2024-12-15', NULL, NULL),
(306, 400.00, 25850.00, 48, '2024-12-16', NULL, NULL),
(307, 0.00, 166331.16, 49, '2024-12-16', NULL, NULL),
(308, 0.00, 0.00, 71, '2024-12-16', NULL, NULL),
(309, 0.00, 98205.48, 50, '2024-12-16', NULL, NULL),
(310, 0.00, 31480.08, 51, '2024-12-16', NULL, NULL),
(311, 400.00, 25870.00, 48, '2024-12-17', NULL, NULL),
(312, 0.00, 166331.16, 49, '2024-12-17', NULL, NULL),
(313, 0.00, 0.00, 71, '2024-12-17', NULL, NULL),
(314, 0.00, 98205.48, 50, '2024-12-17', NULL, NULL),
(315, 0.00, 31480.08, 51, '2024-12-17', NULL, NULL),
(316, 400.00, 25890.00, 48, '2024-12-16', NULL, NULL),
(317, 0.00, 166331.16, 49, '2024-12-16', NULL, NULL),
(318, 0.00, 0.00, 71, '2024-12-16', NULL, NULL),
(319, 0.00, 98205.48, 50, '2024-12-16', NULL, NULL),
(320, 0.00, 31480.08, 51, '2024-12-16', NULL, NULL),
(336, 400.00, 25895.00, 48, '2024-12-17', NULL, NULL),
(337, 0.00, 166331.16, 49, '2024-12-17', NULL, NULL),
(338, 0.00, 0.00, 71, '2024-12-17', NULL, NULL),
(339, 0.00, 98205.48, 50, '2024-12-17', NULL, NULL),
(340, 0.00, 31480.08, 51, '2024-12-17', NULL, NULL),
(341, 400.00, 25898.00, 48, '2024-12-17', NULL, NULL),
(342, 0.00, 166331.16, 49, '2024-12-17', NULL, NULL),
(343, 0.00, 0.00, 71, '2024-12-17', NULL, NULL),
(344, 0.00, 98205.48, 50, '2024-12-17', NULL, NULL),
(345, 0.00, 31480.08, 51, '2024-12-17', NULL, NULL),
(346, 400.00, 25899.00, 48, '2024-12-18', NULL, NULL),
(347, 0.00, 166331.16, 49, '2024-12-18', NULL, NULL),
(348, 0.00, 0.00, 71, '2024-12-18', NULL, NULL),
(349, 0.00, 98205.48, 50, '2024-12-18', NULL, NULL),
(350, 0.00, 31480.08, 51, '2024-12-18', NULL, NULL),
(351, 400.00, 25899.00, 48, '2024-12-18', NULL, NULL),
(352, 0.00, 166331.16, 49, '2024-12-18', NULL, NULL),
(353, 0.00, 0.00, 71, '2024-12-18', NULL, NULL),
(354, 0.00, 98205.48, 50, '2024-12-18', NULL, NULL),
(355, 0.00, 31480.08, 51, '2024-12-18', NULL, NULL),
(356, 400.00, 26000.00, 48, '2024-12-20', NULL, NULL),
(357, 0.00, 166331.16, 49, '2024-12-20', NULL, NULL),
(358, 0.00, 0.00, 71, '2024-12-20', NULL, NULL),
(359, 0.00, 98205.48, 50, '2024-12-20', NULL, NULL),
(360, 0.00, 31480.08, 51, '2024-12-20', NULL, NULL),
(361, 400.00, 26050.00, 48, '2024-12-20', NULL, NULL),
(362, 0.00, 166331.16, 49, '2024-12-20', NULL, NULL),
(363, 0.00, 0.00, 71, '2024-12-20', NULL, NULL),
(364, 0.00, 98205.48, 50, '2024-12-20', NULL, NULL),
(365, 0.00, 31480.08, 51, '2024-12-20', NULL, NULL),
(366, 400.00, 26055.00, 48, '2024-12-21', NULL, NULL),
(367, 0.00, 166331.16, 49, '2024-12-21', NULL, NULL),
(368, 0.00, 0.00, 71, '2024-12-21', NULL, NULL),
(369, 0.00, 98205.48, 50, '2024-12-21', NULL, NULL),
(370, 0.00, 31480.08, 51, '2024-12-21', NULL, NULL),
(371, 400.00, 26055.00, 48, '2024-12-22', NULL, NULL),
(372, 0.00, 166331.16, 49, '2024-12-22', NULL, NULL),
(373, 0.00, 0.00, 71, '2024-12-22', NULL, NULL),
(374, 0.00, 98205.48, 50, '2024-12-22', NULL, NULL),
(375, 0.00, 31480.08, 51, '2024-12-22', NULL, NULL),
(376, 400.00, 26070.00, 48, '2024-12-25', NULL, NULL),
(377, 0.00, 166331.16, 49, '2024-12-25', NULL, NULL),
(378, 0.00, 0.00, 71, '2024-12-25', NULL, NULL),
(379, 0.00, 98205.48, 50, '2024-12-25', NULL, NULL),
(380, 0.00, 31480.08, 51, '2024-12-25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'owner-access', 'web', '2024-11-16 17:19:08', '2024-11-16 17:19:08'),
(5, 'manager-access', 'web', '2024-11-16 17:19:08', '2024-11-16 17:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petrol_pumps`
--

DROP TABLE IF EXISTS `petrol_pumps`;
CREATE TABLE IF NOT EXISTS `petrol_pumps` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `petrol_pumps_company_id_foreign` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `petrol_pumps`
--

INSERT INTO `petrol_pumps` (`id`, `company_id`, `name`, `location`, `created_at`, `updated_at`) VALUES
(1, 3, 'Demo 1', 'Lahore, pk', '2024-11-16 17:17:25', '2024-11-16 17:17:25'),
(4, 9, 'Rana 1 pump', 'ISB', '2024-11-18 22:53:16', '2024-11-18 22:53:16'),
(7, 3, 'PSO', 'Sargodha, Pk', '2024-12-05 17:04:00', '2024-12-05 17:04:00'),
(8, 3, 'Gujjar', 'Lahore', '2024-12-06 19:59:01', '2024-12-06 19:59:01'),
(9, 3, 'Test', 'RSF', '2024-12-06 20:21:02', '2024-12-06 20:21:02'),
(10, 3, 'Test 2', 'RSF', '2024-12-06 20:55:34', '2024-12-06 20:55:34'),
(11, 3, 'free', 'Pakistan', '2024-12-08 14:42:10', '2024-12-08 14:42:10'),
(12, 3, 'Shaikhupura test', 'RSF', '2024-12-09 11:13:52', '2024-12-09 11:13:52'),
(13, 3, 'Latest Test', 'RSF', '2024-12-09 11:14:35', '2024-12-09 11:14:35'),
(14, 3, 'New Test', 'RSF', '2024-12-09 11:50:27', '2024-12-09 11:50:27'),
(15, 3, 'Bhatti', 'RSF', '2024-12-10 12:22:47', '2024-12-10 12:22:47'),
(16, 3, 'Bhatti New Test', 'RSF', '2024-12-11 12:17:08', '2024-12-11 12:17:08'),
(17, 3, 'Final Test', 'RSF', '2024-12-11 20:09:12', '2024-12-11 20:09:12'),
(18, 3, 'Hascol', 'punjab', '2024-12-13 12:17:21', '2024-12-13 12:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `products_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `company`, `price`, `buying_price`, `created_at`, `updated_at`, `petrol_pump_id`) VALUES
(1, 'Frances Robles', 'Shell', 319, 0.00, '2024-11-24 16:47:17', '2024-11-25 02:10:35', 1),
(2, 'Kaden Franco', 'Mosley Moreno Plc', 107, 0.00, '2024-11-24 17:02:34', '2024-11-24 17:02:34', 1),
(4, '5W - 40', 'Shell', 1000, 0.00, '2024-12-05 17:16:19', '2024-12-05 17:16:19', 7),
(5, '5W - 20', 'Total', 1100, 0.00, '2024-12-05 20:08:46', '2024-12-05 20:08:46', 7),
(6, 'Open Oil', 'PSO', 500, 0.00, '2024-12-06 20:08:30', '2024-12-06 20:08:30', 8),
(7, 'Open Oil', 'PSO', 500, 0.00, '2024-12-06 20:28:37', '2024-12-06 20:28:37', 9),
(8, 'Open Oil', 'PSO', 500, 0.00, '2024-12-06 21:02:58', '2024-12-06 21:02:58', 10),
(9, 'open oil', 'shell', 1000, 950.00, '2024-12-08 14:50:02', '2024-12-08 14:50:02', 11),
(10, 'Open Oil', 'PSO', 500, 543.00, '2024-12-09 11:15:39', '2024-12-09 11:16:28', 13),
(11, 'Blaz 0.7', 'PSO', 500, 543.00, '2024-12-09 12:00:09', '2024-12-09 12:00:09', 14),
(12, 'Open Oil', 'PSO', 500, 500.00, '2024-12-10 12:25:33', '2024-12-10 12:25:33', 15),
(13, 'Open Oil', 'PSO', 500, 500.00, '2024-12-11 12:19:03', '2024-12-11 12:19:03', 16),
(14, 'Open Oil', 'PSO', 500, 543.00, '2024-12-11 20:13:32', '2024-12-11 20:13:32', 17),
(15, 'open oil', 'pso', 1200, 1100.00, '2024-12-13 15:45:52', '2024-12-13 15:45:52', 18),
(16, 'PSO 5w30', 'PSO', 1000, 950.00, '2024-12-29 09:55:49', '2024-12-29 09:55:49', 15),
(17, 'Marshall Chavez', 'Perez Wheeler Traders', 302, 59.00, '2024-12-29 10:02:17', '2024-12-29 10:02:17', 15);

-- --------------------------------------------------------

--
-- Table structure for table `product_inventory`
--

DROP TABLE IF EXISTS `product_inventory`;
CREATE TABLE IF NOT EXISTS `product_inventory` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_inventory_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_inventory`
--

INSERT INTO `product_inventory` (`id`, `quantity`, `date`, `created_at`, `updated_at`, `product_id`) VALUES
(1, '700', '2024-11-01', '2024-11-25 02:27:32', '2024-11-25 02:27:43', 1),
(2, '200', '2024-11-01', '2024-11-25 14:12:49', '2024-11-25 14:12:49', 1),
(3, '450', '2024-11-02', '2024-11-25 14:14:35', '2024-11-25 14:14:35', 1),
(4, '950', '2024-11-01', '2024-11-25 14:15:41', '2024-11-25 14:15:41', 1),
(5, '500', '2024-11-01', '2024-11-25 14:29:29', '2024-11-25 14:29:29', 2),
(6, '700', '2024-11-02', '2024-11-25 14:29:37', '2024-11-25 14:29:37', 2),
(7, '800', '2024-11-03', '2024-11-25 14:29:48', '2024-11-25 14:29:48', 2),
(8, '600', '2024-11-06', '2024-11-25 14:33:37', '2024-11-25 14:33:37', 2),
(9, '500', '2024-11-09', '2024-11-30 10:33:34', '2024-11-30 10:33:34', 1),
(10, '99', '2024-11-13', '2024-11-30 10:33:50', '2024-11-30 10:33:50', 1),
(18, '-2', '2024-11-01', NULL, NULL, 1),
(19, '-1', '2024-11-01', NULL, NULL, 2),
(20, '-2', '2024-12-05', NULL, NULL, 4),
(21, '10', '2024-12-05', '2024-12-06 18:04:39', '2024-12-06 18:04:39', 4),
(22, '-2', '2024-12-06', NULL, NULL, 4),
(23, '-2', '2024-12-06', NULL, NULL, 4),
(24, '5', '2024-12-05', '2024-12-06 20:09:00', '2024-12-06 20:09:00', 6),
(25, '-2', '2024-12-04', NULL, NULL, 7),
(26, '-1', '2024-12-05', NULL, NULL, 8),
(27, '-2', '2024-12-10', NULL, NULL, 4),
(28, '-4', '2024-12-07', NULL, NULL, 5),
(33, '2000', '2024-12-07', '2024-12-08 15:00:29', '2024-12-08 15:00:29', 9),
(35, '-2', '2024-12-07', NULL, NULL, 9),
(36, '-4', '2024-12-08', NULL, NULL, 9),
(37, '10', '2024-12-04', '2024-12-09 11:16:48', '2024-12-09 11:16:48', 10),
(38, '-1', '2024-12-05', NULL, NULL, 11),
(39, '10', '2024-12-05', '2024-12-09 12:23:43', '2024-12-09 12:23:43', 11),
(40, '-1', '2024-12-06', NULL, NULL, 11),
(41, '-1', '2024-12-07', NULL, NULL, 11),
(42, '-1', '2024-12-05', NULL, NULL, 10),
(43, '165', '2024-12-03', '2024-12-10 12:48:02', '2024-12-10 12:48:02', 12),
(44, '-5', '2024-12-05', NULL, NULL, 12),
(45, '165', '2024-12-01', '2024-12-11 12:19:14', '2024-12-11 12:19:14', 13),
(46, '-5', '2024-12-05', NULL, NULL, 13),
(47, '10', '2024-12-03', '2024-12-11 20:22:13', '2024-12-11 20:22:13', 14),
(48, '-1', '2024-12-03', NULL, NULL, 14),
(49, '-2', '2024-12-09', NULL, NULL, 15),
(50, '-2', '2024-12-26', NULL, NULL, 12),
(51, '-1', '2024-12-26', NULL, NULL, 12),
(52, '500', '2024-12-04', '2024-12-29 09:56:06', '2024-12-29 09:56:06', 16),
(53, '1000', '2024-12-04', '2024-12-29 10:02:29', '2024-12-29 10:02:29', 17);

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

DROP TABLE IF EXISTS `product_sales`;
CREATE TABLE IF NOT EXISTS `product_sales` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `profit` decimal(10,2) DEFAULT NULL COMMENT 'Profit for the sale',
  `product_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_sales_petrol_pump_id_foreign` (`petrol_pump_id`)
) ;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`id`, `amount`, `profit`, `product_data`, `date`, `created_at`, `updated_at`, `petrol_pump_id`) VALUES
(8, 745, NULL, '[{\"product_id\": \"1\", \"product_qty\": \"2\"}, {\"product_id\": \"2\", \"product_qty\": \"1\"}]', '2024-11-01', NULL, NULL, 1),
(9, 2000, NULL, '[{\"product_id\":\"4\",\"product_qty\":\"2\"}]', '2024-12-05', NULL, NULL, 7),
(10, 2000, NULL, '[{\"product_id\":\"4\",\"product_name\":\"5W - 40\",\"product_price\":\"1000\",\"product_qty\":\"2\",\"total\":\"2000\"}]', '2024-12-06', NULL, NULL, 7),
(11, 2000, NULL, '[{\"product_id\":\"4\",\"product_name\":\"5W - 40\",\"product_price\":\"1000\",\"product_qty\":\"2\",\"total\":\"2000\"}]', '2024-12-06', NULL, NULL, 7),
(12, 1000, NULL, '[{\"product_id\":\"7\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"product_qty\":\"2\",\"total\":\"1000\"}]', '2024-12-04', NULL, NULL, 9),
(13, 500, NULL, '[{\"product_id\":\"8\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-05', NULL, NULL, 10),
(14, 2000, NULL, '[{\"product_id\":\"4\",\"product_name\":\"5W - 40\",\"product_price\":\"1000\",\"product_qty\":\"2\",\"total\":\"2000\"}]', '2024-12-10', NULL, NULL, 7),
(15, 4400, NULL, '[{\"product_id\":\"5\",\"product_name\":\"5W - 20\",\"product_price\":\"1100\",\"product_qty\":\"4\",\"total\":\"4400\"}]', '2024-12-07', NULL, NULL, 7),
(21, 2000, 100.00, '[{\"product_id\":\"9\",\"product_name\":\"open oil\",\"product_price\":\"1000\",\"buying_price\":\"950\",\"product_qty\":\"2\",\"total\":\"2000\"}]', '2024-12-07', NULL, NULL, 11),
(22, 4000, 200.00, '[{\"product_id\":\"9\",\"product_name\":\"open oil\",\"product_price\":\"1000\",\"buying_price\":\"950\",\"product_qty\":\"4\",\"total\":\"4000\"}]', '2024-12-08', NULL, NULL, 11),
(23, 500, -43.00, '[{\"product_id\":\"11\",\"product_name\":\"Blaz 0.7\",\"product_price\":\"500\",\"buying_price\":\"543\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-05', NULL, NULL, 14),
(24, 500, -43.00, '[{\"product_id\":\"11\",\"product_name\":\"Blaz 0.7\",\"product_price\":\"500\",\"buying_price\":\"543\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-06', NULL, NULL, 14),
(25, 500, -43.00, '[{\"product_id\":\"11\",\"product_name\":\"Blaz 0.7\",\"product_price\":\"500\",\"buying_price\":\"543\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-07', NULL, NULL, 14),
(26, 500, -43.00, '[{\"product_id\":\"10\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"543\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-05', NULL, NULL, 13),
(27, 2500, 0.00, '[{\"product_id\":\"12\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"500\",\"product_qty\":\"5\",\"total\":\"2500\"}]', '2024-12-05', NULL, NULL, 15),
(28, 2500, 0.00, '[{\"product_id\":\"13\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"500\",\"product_qty\":\"5\",\"total\":\"2500\"}]', '2024-12-05', NULL, NULL, 16),
(29, 500, -43.00, '[{\"product_id\":\"14\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"543\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-03', NULL, NULL, 17),
(30, 2400, 200.00, '[{\"product_id\":\"15\",\"product_name\":\"open oil\",\"product_price\":\"1200\",\"buying_price\":\"1100\",\"product_qty\":\"2\",\"total\":\"2400\"}]', '2024-12-09', NULL, NULL, 18),
(31, 1000, 0.00, '[{\"product_id\":\"12\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"500\",\"product_qty\":\"2\",\"total\":\"1000\"}]', '2024-12-26', NULL, NULL, 15),
(32, 500, 0.00, '[{\"product_id\":\"12\",\"product_name\":\"Open Oil\",\"product_price\":\"500\",\"buying_price\":\"500\",\"product_qty\":\"1\",\"total\":\"500\"}]', '2024-12-26', NULL, NULL, 15);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'web', '2024-11-16 17:19:08', '2024-11-16 17:19:08'),
(2, 'client_admin', 'web', '2024-11-16 17:19:08', '2024-11-16 17:19:08'),
(3, 'manager', 'web', '2024-11-16 17:19:08', '2024-11-16 17:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 2),
(5, 2),
(5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Z901sJgoPozI4pcpD4D3s6mdLi6kRj75D76KhKsr', 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWWszcndPR09UQ0dWQVZBeUtnODFKWkJCQWJUSXpYak52T3BVTGVzUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cDovL3N5ZWRicm90aGVyc3BldHJvemFsLmxvY2FsIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTI6Imh0dHA6Ly9zeWVkYnJvdGhlcnNwZXRyb3phbC5sb2NhbC9wdW1wLzE1L2FuYWx5dGljcz9lbmRfZGF0ZT0yMDI0LTEyLTMmc3RhcnRfZGF0ZT0yMDI0LTEyLTAxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1735487763);

-- --------------------------------------------------------

--
-- Table structure for table `tanks`
--

DROP TABLE IF EXISTS `tanks`;
CREATE TABLE IF NOT EXISTS `tanks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `petrol_pump_id` bigint UNSIGNED NOT NULL,
  `fuel_type_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tanks_fuel_type_id_foreign` (`fuel_type_id`),
  KEY `tanks_petrol_pump_id_foreign` (`petrol_pump_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanks`
--

INSERT INTO `tanks` (`id`, `name`, `petrol_pump_id`, `fuel_type_id`, `created_at`, `updated_at`) VALUES
(2, 'tank 2', 1, 1, '2024-11-19 18:19:40', '2024-11-19 18:19:40'),
(5, 'Tank 4', 1, 2, '2024-11-19 19:41:17', '2024-11-19 19:41:17'),
(6, 'Tank 1', 4, 13, '2024-11-19 19:43:10', '2024-11-19 19:43:10'),
(11, 'Petrol Red', 7, 2, '2024-12-05 17:05:04', '2024-12-05 17:05:04'),
(12, 'Diesel Green', 7, 1, '2024-12-05 17:05:17', '2024-12-05 17:05:17'),
(13, 'Diesel 1', 8, 1, '2024-12-06 20:00:18', '2024-12-06 20:00:18'),
(14, 'Petrol 1', 8, 2, '2024-12-06 20:00:28', '2024-12-06 20:00:28'),
(15, 'Hi Octaine', 8, 4, '2024-12-06 20:00:47', '2024-12-06 20:00:47'),
(16, 'Petrol 1', 9, 2, '2024-12-06 20:21:21', '2024-12-06 20:21:47'),
(17, 'Diesel 1', 9, 1, '2024-12-06 20:22:36', '2024-12-06 20:22:36'),
(18, 'HOBC 1', 9, 4, '2024-12-06 20:22:45', '2024-12-06 20:22:45'),
(19, 'HSD 1', 10, 1, '2024-12-06 20:59:45', '2024-12-06 20:59:45'),
(20, 'PMG 1', 10, 2, '2024-12-06 20:59:56', '2024-12-06 20:59:56'),
(21, 'HOBC 1', 10, 4, '2024-12-06 21:00:05', '2024-12-06 21:00:05'),
(22, 'Petrol', 11, 2, '2024-12-08 14:44:26', '2024-12-08 14:44:26'),
(23, 'Diesel', 11, 1, '2024-12-08 14:44:35', '2024-12-08 14:44:35'),
(24, 'Hi Octane', 11, 4, '2024-12-08 14:44:46', '2024-12-08 14:44:46'),
(25, 'Petrol 1', 13, 2, '2024-12-09 11:20:25', '2024-12-09 11:20:25'),
(26, 'Diesel 1', 13, 1, '2024-12-09 11:20:57', '2024-12-09 11:20:57'),
(27, 'Hi Octaine 1', 13, 4, '2024-12-09 11:21:12', '2024-12-09 11:21:12'),
(28, '1010', 13, 2, '2024-12-09 11:32:13', '2024-12-09 11:32:13'),
(29, 'Petrol 1', 14, 2, '2024-12-09 11:51:09', '2024-12-09 11:51:09'),
(30, 'Diesel 1', 14, 1, '2024-12-09 11:51:21', '2024-12-09 11:51:21'),
(31, 'Hi Octaine 1', 14, 4, '2024-12-09 11:51:38', '2024-12-09 11:51:38'),
(32, 'Petrol 1', 15, 2, '2024-12-10 12:23:22', '2024-12-10 12:23:22'),
(33, 'Diesel 1', 15, 1, '2024-12-10 12:23:31', '2024-12-10 12:23:31'),
(34, 'Petrol 1', 16, 2, '2024-12-11 12:17:46', '2024-12-11 12:17:46'),
(35, 'Diesel 1', 16, 1, '2024-12-11 12:17:54', '2024-12-11 12:17:54'),
(36, 'Petrol 1', 17, 2, '2024-12-11 20:10:26', '2024-12-11 20:10:26'),
(37, 'Diesel 1', 17, 1, '2024-12-11 20:10:39', '2024-12-11 20:10:39'),
(38, 'Hi Octain 1', 17, 4, '2024-12-11 20:11:02', '2024-12-11 20:11:02'),
(39, 'Petrol 1', 12, 2, '2024-12-13 11:25:22', '2024-12-13 11:25:22'),
(40, 'Diesel 1', 12, 1, '2024-12-13 11:25:29', '2024-12-13 11:25:29'),
(41, 'Diesel Tank 1', 18, 1, '2024-12-13 12:18:03', '2024-12-13 12:18:03'),
(42, 'Diesel Tank 2', 18, 1, '2024-12-13 12:18:28', '2024-12-13 12:18:28'),
(43, 'Petrol Tank 1', 18, 2, '2024-12-13 12:18:46', '2024-12-13 12:18:46'),
(44, 'Hu Schwartz', 15, 14, '2024-12-29 11:12:21', '2024-12-29 11:12:21'),
(47, 'Diesel 2', 15, 1, '2024-12-29 14:31:08', '2024-12-29 14:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `tank_stocks`
--

DROP TABLE IF EXISTS `tank_stocks`;
CREATE TABLE IF NOT EXISTS `tank_stocks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `reading_in_ltr` decimal(11,2) NOT NULL,
  `tank_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tank_stocks_tank_id_foreign` (`tank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tank_stocks`
--

INSERT INTO `tank_stocks` (`id`, `reading_in_ltr`, `tank_id`, `date`, `created_at`, `updated_at`) VALUES
(1, 1000.00, 2, '2024-11-01', '2024-11-20 17:39:57', '2024-11-20 20:53:12'),
(5, 5000.00, 11, '2024-12-05', '2024-12-05 17:08:31', '2024-12-05 17:08:31'),
(6, 4000.00, 11, '2024-12-03', '2024-12-05 17:09:14', '2024-12-05 17:09:14'),
(7, 5000.00, 12, '2024-12-05', '2024-12-05 17:25:52', '2024-12-05 17:25:52'),
(8, 5000.00, 11, '2024-12-07', '2024-12-06 16:32:21', '2024-12-06 16:32:21'),
(9, 0.00, 11, '2024-12-06', NULL, NULL),
(10, -14.00, 12, '2024-12-06', NULL, NULL),
(11, 16378.00, 14, '2024-12-05', '2024-12-06 20:05:01', '2024-12-06 20:05:01'),
(12, 8480.00, 13, '2024-12-05', '2024-12-06 20:05:55', '2024-12-06 20:05:55'),
(13, 7144.00, 15, '2024-12-05', '2024-12-06 20:06:20', '2024-12-06 20:06:20'),
(14, 10.00, 16, '2024-12-04', '2024-12-06 20:38:25', '2024-12-06 20:38:25'),
(15, 10.00, 17, '2024-12-04', '2024-12-06 20:38:41', '2024-12-06 20:38:41'),
(16, 10.00, 18, '2024-12-04', '2024-12-06 20:38:53', '2024-12-06 20:38:53'),
(17, -7.00, 17, '2024-12-04', NULL, NULL),
(18, -5.00, 16, '2024-12-04', NULL, NULL),
(19, -2.00, 18, '2024-12-04', NULL, NULL),
(20, -2.00, 19, '2024-12-04', NULL, NULL),
(21, -4.00, 20, '2024-12-04', NULL, NULL),
(22, -2.00, 21, '2024-12-04', NULL, NULL),
(23, 1000.00, 19, '2024-12-05', '2024-12-06 21:05:45', '2024-12-06 21:05:45'),
(24, 1000.00, 20, '2024-12-05', '2024-12-06 21:06:05', '2024-12-06 21:06:05'),
(25, 1000.00, 21, '2024-12-05', '2024-12-06 21:06:20', '2024-12-06 21:06:20'),
(26, -2.00, 19, '2024-12-05', NULL, NULL),
(27, -2.00, 20, '2024-12-05', NULL, NULL),
(28, -2.00, 21, '2024-12-05', NULL, NULL),
(29, -498.00, 11, '2024-12-10', NULL, NULL),
(30, 0.00, 12, '2024-12-10', NULL, NULL),
(31, 0.00, 11, '2024-12-07', NULL, NULL),
(32, 0.00, 12, '2024-12-07', NULL, NULL),
(33, 5000.00, 22, '2024-12-07', '2024-12-08 14:46:06', '2024-12-08 14:46:06'),
(34, 3000.00, 23, '2024-12-07', '2024-12-08 14:46:24', '2024-12-08 14:46:24'),
(35, 4000.00, 24, '2024-12-07', '2024-12-08 14:46:43', '2024-12-08 14:46:43'),
(51, -120.00, 22, '2024-12-07', NULL, NULL),
(52, -120.00, 23, '2024-12-07', NULL, NULL),
(53, -120.00, 24, '2024-12-07', NULL, NULL),
(54, -10.00, 22, '2024-12-08', NULL, NULL),
(55, -10.00, 23, '2024-12-08', NULL, NULL),
(56, -10.00, 24, '2024-12-08', NULL, NULL),
(57, -10.00, 25, '2024-12-03', NULL, NULL),
(58, -10.00, 26, '2024-12-03', NULL, NULL),
(59, -10.00, 27, '2024-12-03', NULL, NULL),
(60, 1010.00, 25, '2024-12-05', '2024-12-09 11:34:10', '2024-12-09 11:34:10'),
(61, 0.00, 28, '2024-12-05', '2024-12-09 11:34:10', '2024-12-09 11:34:10'),
(62, 1010.00, 26, '2024-12-05', '2024-12-09 11:34:50', '2024-12-09 11:34:50'),
(63, 1010.00, 27, '2024-12-05', '2024-12-09 11:35:12', '2024-12-09 11:35:12'),
(82, 1000.00, 29, '2024-12-04', '2024-12-09 11:54:47', '2024-12-09 11:54:47'),
(83, 1000.00, 30, '2024-12-04', '2024-12-09 11:55:17', '2024-12-09 11:55:17'),
(84, 1000.00, 31, '2024-12-04', '2024-12-09 11:55:38', '2024-12-09 11:55:38'),
(85, -10.00, 29, '2024-12-04', NULL, NULL),
(86, -10.00, 30, '2024-12-04', NULL, NULL),
(87, -10.00, 31, '2024-12-04', NULL, NULL),
(88, -2.00, 29, '2024-12-05', NULL, NULL),
(89, -2.00, 30, '2024-12-05', NULL, NULL),
(90, -2.00, 31, '2024-12-05', NULL, NULL),
(91, 991.00, 29, '2024-12-05', '2024-12-09 12:41:58', '2024-12-09 12:41:58'),
(92, 991.00, 29, '2024-12-05', '2024-12-09 12:43:28', '2024-12-09 12:43:28'),
(93, 1.00, 29, '2024-12-06', '2024-12-09 12:45:59', '2024-12-09 12:45:59'),
(94, -10.00, 22, '2024-12-09', NULL, NULL),
(95, -10.00, 23, '2024-12-09', NULL, NULL),
(96, -10.00, 24, '2024-12-09', NULL, NULL),
(97, -2.00, 29, '2024-12-06', NULL, NULL),
(98, -2.00, 30, '2024-12-06', NULL, NULL),
(99, -2.00, 31, '2024-12-06', NULL, NULL),
(100, -1.00, 29, '2024-12-07', NULL, NULL),
(101, -1.00, 30, '2024-12-07', NULL, NULL),
(102, -1.00, 31, '2024-12-07', NULL, NULL),
(103, 9.00, 25, '2024-12-05', NULL, NULL),
(104, 9.00, 26, '2024-12-05', NULL, NULL),
(105, 9.00, 27, '2024-12-05', NULL, NULL),
(106, -1.00, 25, '2024-12-06', NULL, NULL),
(107, -1.00, 26, '2024-12-06', NULL, NULL),
(108, -1.00, 27, '2024-12-06', NULL, NULL),
(109, -2.00, 25, '2024-12-07', NULL, NULL),
(110, -2.00, 26, '2024-12-07', NULL, NULL),
(111, -2.00, 27, '2024-12-07', NULL, NULL),
(116, -187575.45, 32, '2024-12-02', NULL, NULL),
(117, -128912.46, 33, '2024-12-02', NULL, NULL),
(118, 187575.45, 32, '2024-12-02', '2024-12-10 12:43:47', '2024-12-10 12:43:47'),
(119, 128912.46, 33, '2024-12-02', '2024-12-10 12:44:07', '2024-12-10 12:44:07'),
(120, 2932.99, 32, '2024-12-03', '2024-12-10 12:46:48', '2024-12-10 12:46:48'),
(121, 928.42, 33, '2024-12-03', '2024-12-10 12:47:28', '2024-12-10 12:47:28'),
(122, -369.74, 32, '2024-12-03', NULL, NULL),
(123, -109.33, 33, '2024-12-03', NULL, NULL),
(124, -343.77, 32, '2024-12-04', NULL, NULL),
(125, -103.64, 33, '2024-12-04', NULL, NULL),
(126, -8.00, 22, '2024-12-10', NULL, NULL),
(127, -8.00, 23, '2024-12-10', NULL, NULL),
(128, -8.00, 24, '2024-12-10', NULL, NULL),
(129, -455.45, 32, '2024-12-05', NULL, NULL),
(130, -153.73, 33, '2024-12-05', NULL, NULL),
(131, -413.57, 32, '2024-12-06', NULL, NULL),
(132, -205.90, 33, '2024-12-06', NULL, NULL),
(133, 5000.00, 32, '2024-12-07', '2024-12-11 11:59:29', '2024-12-11 11:59:29'),
(134, 2000.00, 33, '2024-12-07', '2024-12-11 11:59:43', '2024-12-11 11:59:43'),
(135, -478.65, 32, '2024-12-07', NULL, NULL),
(136, -85.70, 33, '2024-12-07', NULL, NULL),
(137, -319.59, 32, '2024-12-08', NULL, NULL),
(138, -114.80, 33, '2024-12-08', NULL, NULL),
(139, -187154.03, 34, '2024-12-01', NULL, NULL),
(140, -128749.50, 35, '2024-12-01', NULL, NULL),
(141, 187154.03, 34, '2024-12-01', '2024-12-11 12:25:11', '2024-12-11 12:25:11'),
(142, 128749.50, 35, '2024-12-01', '2024-12-11 12:25:41', '2024-12-11 12:25:41'),
(143, 3286.20, 34, '2024-12-02', '2024-12-11 12:26:52', '2024-12-11 12:26:52'),
(144, 1090.38, 35, '2024-12-02', '2024-12-11 12:27:27', '2024-12-11 12:27:27'),
(145, -421.42, 34, '2024-12-02', NULL, NULL),
(146, -162.96, 35, '2024-12-02', NULL, NULL),
(147, -369.74, 34, '2024-12-03', NULL, NULL),
(148, -109.33, 35, '2024-12-03', NULL, NULL),
(149, -343.77, 34, '2024-12-04', NULL, NULL),
(150, -103.64, 35, '2024-12-04', NULL, NULL),
(151, -455.45, 34, '2024-12-05', NULL, NULL),
(152, -153.73, 35, '2024-12-05', NULL, NULL),
(153, -413.57, 34, '2024-12-06', NULL, NULL),
(154, -205.90, 35, '2024-12-06', NULL, NULL),
(155, -1.00, 25, '2024-12-08', NULL, NULL),
(156, -1.00, 26, '2024-12-08', NULL, NULL),
(157, -1.00, 27, '2024-12-08', NULL, NULL),
(158, 1000.00, 36, '2024-12-03', '2024-12-11 20:23:29', '2024-12-11 20:23:29'),
(159, 1000.00, 37, '2024-12-03', '2024-12-11 20:23:45', '2024-12-11 20:23:45'),
(160, 1000.00, 38, '2024-12-03', '2024-12-11 20:24:02', '2024-12-11 20:24:02'),
(161, -1.00, 37, '2024-12-03', NULL, NULL),
(162, -1.00, 36, '2024-12-03', NULL, NULL),
(163, -1.00, 38, '2024-12-03', NULL, NULL),
(164, 5000.00, 34, '2024-12-07', '2024-12-13 11:13:43', '2024-12-13 11:13:43'),
(165, 2000.00, 35, '2024-12-07', '2024-12-13 11:13:58', '2024-12-13 11:13:58'),
(168, 6562.20, 39, '2024-12-07', '2024-12-13 11:27:13', '2024-12-13 11:27:13'),
(169, 2360.82, 40, '2024-12-07', '2024-12-13 11:27:29', '2024-12-13 11:27:29'),
(170, -478.65, 39, '2024-12-07', NULL, NULL),
(171, -85.70, 40, '2024-12-07', NULL, NULL),
(172, -374.36, 39, '2024-12-08', NULL, NULL),
(173, -114.80, 40, '2024-12-08', NULL, NULL),
(174, -437.19, 39, '2024-12-09', NULL, NULL),
(175, -186.24, 40, '2024-12-09', NULL, NULL),
(176, 75.40, 39, '2024-12-10', '2024-12-13 11:45:30', '2024-12-13 11:45:30'),
(177, 7.00, 40, '2024-12-10', '2024-12-13 11:46:05', '2024-12-13 11:46:05'),
(178, -419.61, 39, '2024-12-10', NULL, NULL),
(179, -144.25, 40, '2024-12-10', NULL, NULL),
(180, 10000.00, 43, '2024-12-03', '2024-12-13 12:38:56', '2024-12-13 12:38:56'),
(181, 4000.00, 41, '2024-12-03', '2024-12-13 12:39:56', '2024-12-13 12:39:56'),
(182, 1000.00, 42, '2024-12-03', '2024-12-13 12:39:56', '2024-12-13 12:39:56'),
(183, -238.00, 41, '2024-12-09', NULL, NULL),
(184, -238.00, 42, '2024-12-09', NULL, NULL),
(185, -478.00, 43, '2024-12-09', NULL, NULL),
(186, 0.00, 32, '2024-12-04', NULL, NULL),
(187, 0.00, 33, '2024-12-04', NULL, NULL),
(188, -5.00, 32, '2024-12-27', NULL, NULL),
(189, 0.00, 33, '2024-12-27', NULL, NULL),
(190, 0.00, 32, '2024-12-03', NULL, NULL),
(191, 0.00, 33, '2024-12-03', NULL, NULL),
(192, 0.00, 32, '2024-12-04', NULL, NULL),
(193, 0.00, 33, '2024-12-04', NULL, NULL),
(198, -369.94, 32, '2024-12-26', NULL, NULL),
(199, 0.00, 33, '2024-12-26', NULL, NULL),
(200, -50.00, 32, '2024-12-26', NULL, NULL),
(201, 0.00, 33, '2024-12-26', NULL, NULL),
(202, -1050.00, 32, '2024-12-28', NULL, NULL),
(203, 0.00, 33, '2024-12-28', NULL, NULL),
(204, -400.00, 32, '2024-12-30', NULL, NULL),
(205, 0.00, 33, '2024-12-30', NULL, NULL),
(206, -100.00, 32, '2024-12-31', NULL, NULL),
(207, 0.00, 33, '2024-12-31', NULL, NULL),
(208, -50.00, 32, '2024-12-08', NULL, NULL),
(209, 0.00, 33, '2024-12-08', NULL, NULL),
(210, -100.00, 32, '2024-12-09', NULL, NULL),
(211, 0.00, 33, '2024-12-09', NULL, NULL),
(212, -50.00, 32, '2024-12-15', NULL, NULL),
(213, 0.00, 33, '2024-12-15', NULL, NULL),
(214, -50.00, 32, '2024-12-16', NULL, NULL),
(215, 0.00, 33, '2024-12-16', NULL, NULL),
(216, -20.00, 32, '2024-12-17', NULL, NULL),
(217, 0.00, 33, '2024-12-17', NULL, NULL),
(218, -20.00, 32, '2024-12-16', NULL, NULL),
(219, 0.00, 33, '2024-12-16', NULL, NULL),
(226, -5.00, 32, '2024-12-17', NULL, NULL),
(227, 0.00, 33, '2024-12-17', NULL, NULL),
(228, -3.00, 32, '2024-12-17', NULL, NULL),
(229, 0.00, 33, '2024-12-17', NULL, NULL),
(230, -1.00, 32, '2024-12-18', NULL, NULL),
(231, 0.00, 33, '2024-12-18', NULL, NULL),
(232, 0.00, 32, '2024-12-18', NULL, NULL),
(233, 0.00, 33, '2024-12-18', NULL, NULL),
(234, -101.00, 32, '2024-12-20', NULL, NULL),
(235, 0.00, 33, '2024-12-20', NULL, NULL),
(236, -50.00, 32, '2024-12-20', NULL, NULL),
(237, 0.00, 33, '2024-12-20', NULL, NULL),
(238, -5.00, 32, '2024-12-21', NULL, NULL),
(239, 0.00, 33, '2024-12-21', NULL, NULL),
(240, 0.00, 32, '2024-12-22', NULL, NULL),
(241, 0.00, 33, '2024-12-22', NULL, NULL),
(242, -15.00, 32, '2024-12-25', NULL, NULL),
(243, 0.00, 33, '2024-12-25', NULL, NULL),
(244, 0.00, 33, '2024-12-30', '2024-12-29 14:32:19', '2024-12-29 14:32:19'),
(245, 2500.00, 47, '2024-12-30', '2024-12-29 14:32:19', '2024-12-29 14:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `tank_transfers`
--

DROP TABLE IF EXISTS `tank_transfers`;
CREATE TABLE IF NOT EXISTS `tank_transfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `quantity_ltr` double NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `tank_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tank_transfers_tank_id_foreign` (`tank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tank_transfers`
--

INSERT INTO `tank_transfers` (`id`, `quantity_ltr`, `date`, `tank_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2024-12-07', 22, NULL, NULL),
(2, 2, '2024-12-07', 23, NULL, NULL),
(3, 2, '2024-12-07', 24, NULL, NULL),
(4, 2, '2024-12-08', 22, NULL, NULL),
(5, 2, '2024-12-08', 23, NULL, NULL),
(6, 2, '2024-12-08', 24, NULL, NULL),
(7, 0, '2024-12-03', 25, NULL, NULL),
(8, 0, '2024-12-03', 26, NULL, NULL),
(9, 0, '2024-12-03', 27, NULL, NULL),
(10, 0, '2024-12-04', 29, NULL, NULL),
(11, 0, '2024-12-04', 30, NULL, NULL),
(12, 0, '2024-12-04', 31, NULL, NULL),
(13, 1, '2024-12-05', 29, NULL, NULL),
(14, 1, '2024-12-05', 30, NULL, NULL),
(15, 1, '2024-12-05', 31, NULL, NULL),
(16, 2, '2024-12-09', 22, NULL, NULL),
(17, 2, '2024-12-09', 23, NULL, NULL),
(18, 2, '2024-12-09', 24, NULL, NULL),
(19, 0, '2024-12-06', 29, NULL, NULL),
(20, 1, '2024-12-06', 30, NULL, NULL),
(21, 1, '2024-12-06', 31, NULL, NULL),
(22, 0, '2024-12-07', 29, NULL, NULL),
(23, 0, '2024-12-07', 30, NULL, NULL),
(24, 0, '2024-12-07', 31, NULL, NULL),
(25, 0, '2024-12-05', 25, NULL, NULL),
(26, 0, '2024-12-05', 26, NULL, NULL),
(27, 0, '2024-12-05', 27, NULL, NULL),
(28, 0, '2024-12-05', 28, NULL, NULL),
(29, 0, '2024-12-06', 25, NULL, NULL),
(30, 0, '2024-12-06', 26, NULL, NULL),
(31, 0, '2024-12-06', 27, NULL, NULL),
(32, 0, '2024-12-06', 28, NULL, NULL),
(33, 0, '2024-12-07', 25, NULL, NULL),
(34, 0, '2024-12-07', 26, NULL, NULL),
(35, 0, '2024-12-07', 27, NULL, NULL),
(36, 0, '2024-12-07', 28, NULL, NULL),
(41, 0, '2024-12-02', 32, NULL, NULL),
(42, 0, '2024-12-02', 33, NULL, NULL),
(43, 0, '2024-12-03', 32, NULL, NULL),
(44, 0, '2024-12-03', 33, NULL, NULL),
(45, 0, '2024-12-04', 32, NULL, NULL),
(46, 0, '2024-12-04', 33, NULL, NULL),
(47, 2, '2024-12-10', 22, NULL, NULL),
(48, 2, '2024-12-10', 23, NULL, NULL),
(49, 2, '2024-12-10', 24, NULL, NULL),
(58, 0, '2024-12-05', 32, NULL, NULL),
(59, 0, '2024-12-05', 33, NULL, NULL),
(60, 0, '2024-12-06', 32, NULL, NULL),
(61, 0, '2024-12-06', 33, NULL, NULL),
(62, 0, '2024-12-07', 32, NULL, NULL),
(63, 0, '2024-12-07', 33, NULL, NULL),
(64, 0, '2024-12-08', 32, NULL, NULL),
(65, 0, '2024-12-08', 33, NULL, NULL),
(66, 0, '2024-12-01', 34, NULL, NULL),
(67, 0, '2024-12-01', 35, NULL, NULL),
(68, 0, '2024-12-02', 34, NULL, NULL),
(69, 0, '2024-12-02', 35, NULL, NULL),
(70, 0, '2024-12-03', 34, NULL, NULL),
(71, 0, '2024-12-03', 35, NULL, NULL),
(72, 0, '2024-12-04', 34, NULL, NULL),
(73, 0, '2024-12-04', 35, NULL, NULL),
(74, 0, '2024-12-05', 34, NULL, NULL),
(75, 0, '2024-12-05', 35, NULL, NULL),
(76, 0, '2024-12-06', 34, NULL, NULL),
(77, 0, '2024-12-06', 35, NULL, NULL),
(78, 1, '2024-12-08', 25, NULL, NULL),
(79, 1, '2024-12-08', 26, NULL, NULL),
(80, 1, '2024-12-08', 27, NULL, NULL),
(81, 0, '2024-12-08', 28, NULL, NULL),
(82, 1, '2024-12-03', 36, NULL, NULL),
(83, 1, '2024-12-03', 37, NULL, NULL),
(84, 1, '2024-12-03', 38, NULL, NULL),
(87, 0, '2024-12-07', 39, NULL, NULL),
(88, 0, '2024-12-07', 40, NULL, NULL),
(89, 0, '2024-12-08', 39, NULL, NULL),
(90, 0, '2024-12-08', 40, NULL, NULL),
(91, 0, '2024-12-09', 39, NULL, NULL),
(92, 0, '2024-12-09', 40, NULL, NULL),
(93, 0, '2024-12-10', 39, NULL, NULL),
(94, 0, '2024-12-10', 40, NULL, NULL),
(95, 2, '2024-12-09', 41, NULL, NULL),
(96, 2, '2024-12-09', 42, NULL, NULL),
(97, 2, '2024-12-09', 43, NULL, NULL),
(98, 0, '2024-12-04', 32, NULL, NULL),
(99, 0, '2024-12-04', 33, NULL, NULL),
(100, 0, '2024-12-27', 32, NULL, NULL),
(101, 0, '2024-12-27', 33, NULL, NULL),
(102, 0, '2024-12-03', 32, NULL, NULL),
(103, 0, '2024-12-03', 33, NULL, NULL),
(104, 0, '2024-12-04', 32, NULL, NULL),
(105, 0, '2024-12-04', 33, NULL, NULL),
(110, 0, '2024-12-26', 32, NULL, NULL),
(111, 0, '2024-12-26', 33, NULL, NULL),
(112, 0, '2024-12-26', 32, NULL, NULL),
(113, 0, '2024-12-26', 33, NULL, NULL),
(114, 0, '2024-12-28', 32, NULL, NULL),
(115, 0, '2024-12-28', 33, NULL, NULL),
(116, 0, '2024-12-30', 32, NULL, NULL),
(117, 0, '2024-12-30', 33, NULL, NULL),
(118, 0, '2024-12-31', 32, NULL, NULL),
(119, 0, '2024-12-31', 33, NULL, NULL),
(120, 0, '2024-12-08', 32, NULL, NULL),
(121, 0, '2024-12-08', 33, NULL, NULL),
(122, 0, '2024-12-09', 32, NULL, NULL),
(123, 0, '2024-12-09', 33, NULL, NULL),
(124, 0, '2024-12-15', 32, NULL, NULL),
(125, 0, '2024-12-15', 33, NULL, NULL),
(126, 0, '2024-12-16', 32, NULL, NULL),
(127, 0, '2024-12-16', 33, NULL, NULL),
(128, 0, '2024-12-17', 32, NULL, NULL),
(129, 0, '2024-12-17', 33, NULL, NULL),
(130, 0, '2024-12-16', 32, NULL, NULL),
(131, 0, '2024-12-16', 33, NULL, NULL),
(138, 0, '2024-12-17', 32, NULL, NULL),
(139, 0, '2024-12-17', 33, NULL, NULL),
(140, 0, '2024-12-17', 32, NULL, NULL),
(141, 0, '2024-12-17', 33, NULL, NULL),
(142, 0, '2024-12-18', 32, NULL, NULL),
(143, 0, '2024-12-18', 33, NULL, NULL),
(144, 0, '2024-12-18', 32, NULL, NULL),
(145, 0, '2024-12-18', 33, NULL, NULL),
(146, 0, '2024-12-20', 32, NULL, NULL),
(147, 0, '2024-12-20', 33, NULL, NULL),
(148, 0, '2024-12-20', 32, NULL, NULL),
(149, 0, '2024-12-20', 33, NULL, NULL),
(150, 0, '2024-12-21', 32, NULL, NULL),
(151, 0, '2024-12-21', 33, NULL, NULL),
(152, 0, '2024-12-22', 32, NULL, NULL),
(153, 0, '2024-12-22', 33, NULL, NULL),
(154, 0, '2024-12-25', 32, NULL, NULL),
(155, 0, '2024-12-25', 33, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
CREATE TABLE IF NOT EXISTS `team_members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_user_id_foreign` (`user_id`),
  KEY `team_members_company_id_foreign` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
(7, 26, 3, '2024-11-14 17:20:22', '2024-11-14 17:20:22'),
(9, 29, 3, '2024-11-16 17:09:39', '2024-11-16 17:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `address`, `phone_number`, `image`, `verification_token`) VALUES
(2, 'Usman Rajput', 'usmanrana18989@gmail.com', '2024-11-14 16:19:52', '$2y$12$3/3w.UKj3/hj97Fsx16sp.OA6z6EvGffP16zhoFqzJEb.H5bKzuJi', NULL, '2024-11-05 12:09:29', '2024-11-14 17:19:03', NULL, 'Chak No. 89 NB Sillanwali Road', '03167522589', 'profile_images/bCvSFYEsbrm7Zve0vHOG548AdgjZ8yRs0ibS7Dvv.png', NULL),
(3, 'Shehnshah Gillani', 'gillani@petrozal.com', '2024-11-14 16:58:23', '$2y$12$T5lk3I6GVwDLqLFuprzj3.CnrYPEyVvyUEkvsviON/yEWi6vd2EoK', NULL, '2024-11-05 12:09:29', '2024-12-05 16:49:58', NULL, 'Railway Station Road, Sargodha', '03221122111', 'profile_images/4ut6m75ZbO5WrCsewKRUY4JIRqmMRIfdKFXy31Nf.png', NULL),
(26, 'Aliyan Syed', 'aliyan.syed555@gmail.com', NULL, '$2y$12$j0249qk8wnEhnfLtWAhkguOeEobrKtODPmgE6M.0cHcd4ubPVFu5y', NULL, '2024-11-14 17:20:22', '2024-12-06 04:57:27', NULL, NULL, NULL, 'profile_images/NRVWPG9TeeMppjV1sRRv5OB8XoZ73abKmQRC7eLd.jpg', '68bZqIdVAzgVjunsR1ByZ3ZENtVs5c5SSftlI9C0mnPxmzTJPhzvR0gkdZ7r'),
(28, 'Rana Sb', 'rana@gmail.com', NULL, '$2y$12$odeI.fkwzsahx3swU4ZPueVf3hyBH0nqeG.Vbv.ZEd5QG1sh8G4Gm', NULL, '2024-11-15 21:58:32', '2024-11-15 21:58:32', NULL, NULL, NULL, NULL, NULL),
(29, 'awdwad', 'awd@mail.vom', NULL, '$2y$12$GD0iZVHePmEq.wEivOLSH.F1xNiwMfvADlaxFMjr8y2NZ0Hy0giH6', NULL, '2024-11-16 17:09:39', '2024-11-16 17:09:39', NULL, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card_payments`
--
ALTER TABLE `card_payments`
  ADD CONSTRAINT `card_payments_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `card_payments_transfers`
--
ALTER TABLE `card_payments_transfers`
  ADD CONSTRAINT `card_payments_transfers_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_credits`
--
ALTER TABLE `customer_credits`
  ADD CONSTRAINT `customer_credits_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daily_reports`
--
ALTER TABLE `daily_reports`
  ADD CONSTRAINT `daily_reports_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dip_records`
--
ALTER TABLE `dip_records`
  ADD CONSTRAINT `dip_records_tank_id_foreign` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_wages`
--
ALTER TABLE `employee_wages`
  ADD CONSTRAINT `employee_wages_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_prices`
--
ALTER TABLE `fuel_prices`
  ADD CONSTRAINT `fuel_prices_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fuel_prices_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_purchases`
--
ALTER TABLE `fuel_purchases`
  ADD CONSTRAINT `fuel_purchases_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fuel_purchases_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel_types`
--
ALTER TABLE `fuel_types`
  ADD CONSTRAINT `fuel_types_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `nozzles`
--
ALTER TABLE `nozzles`
  ADD CONSTRAINT `nozzles_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nozzles_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nozzles_tank_id_foreign` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nozzle_readings`
--
ALTER TABLE `nozzle_readings`
  ADD CONSTRAINT `nozzle_readings_nozzle_id_foreign` FOREIGN KEY (`nozzle_id`) REFERENCES `nozzles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `petrol_pumps`
--
ALTER TABLE `petrol_pumps`
  ADD CONSTRAINT `petrol_pumps_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_inventory`
--
ALTER TABLE `product_inventory`
  ADD CONSTRAINT `product_inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD CONSTRAINT `product_sales_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tanks`
--
ALTER TABLE `tanks`
  ADD CONSTRAINT `tanks_fuel_type_id_foreign` FOREIGN KEY (`fuel_type_id`) REFERENCES `fuel_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tanks_petrol_pump_id_foreign` FOREIGN KEY (`petrol_pump_id`) REFERENCES `petrol_pumps` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tank_stocks`
--
ALTER TABLE `tank_stocks`
  ADD CONSTRAINT `tank_stocks_tank_id_foreign` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tank_transfers`
--
ALTER TABLE `tank_transfers`
  ADD CONSTRAINT `tank_transfers_tank_id_foreign` FOREIGN KEY (`tank_id`) REFERENCES `tanks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `team_members`
--
ALTER TABLE `team_members`
  ADD CONSTRAINT `team_members_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
