-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2023 at 05:46 PM
-- Server version: 10.6.11-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gulfsmo_faster_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `fees` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `fees`, `created_at`, `updated_at`) VALUES
(1, 'الامارات العربية المتحدة', 400, NULL, '2022-12-15 21:10:47'),
(2, 'الكويت', 600, NULL, '2022-12-15 21:01:24'),
(3, 'قطر', 0, '2022-12-05 17:14:55', '2022-12-15 21:00:06'),
(4, 'مدن الشحن', 0, '2022-12-05 17:20:14', '2023-01-01 16:15:01'),
(5, 'جازان', 0, '2022-12-05 17:36:20', '2022-12-15 20:55:22'),
(6, 'الأردن', 0, '2022-12-15 21:15:11', '2022-12-15 21:15:11'),
(7, 'تركيا', 0, '2022-12-15 22:04:23', '2022-12-15 22:04:23');

-- --------------------------------------------------------

--
-- Table structure for table `area_price_histories`
--

CREATE TABLE `area_price_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `from` timestamp NULL DEFAULT NULL,
  `to` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area_services`
--

CREATE TABLE `area_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `is_sending` tinyint(1) NOT NULL DEFAULT 0,
  `is_resiving` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area_services`
--

INSERT INTO `area_services` (`id`, `service_id`, `area_id`, `is_sending`, `is_resiving`, `created_at`, `updated_at`) VALUES
(82, 3, 7, 1, 0, '2022-12-20 10:28:10', '2022-12-20 10:28:10'),
(83, 3, 6, 1, 0, '2022-12-20 10:28:34', '2022-12-20 10:28:34'),
(88, 3, 3, 1, 0, '2022-12-20 10:30:00', '2022-12-20 10:30:00'),
(89, 3, 2, 1, 0, '2022-12-20 10:30:11', '2022-12-20 10:30:11'),
(90, 3, 1, 1, 0, '2022-12-20 10:30:19', '2022-12-20 10:30:19'),
(113, 1, 5, 1, 1, '2022-12-20 10:39:45', '2022-12-20 10:39:45'),
(114, 2, 5, 0, 1, '2022-12-20 10:39:45', '2022-12-20 10:39:45'),
(115, 3, 5, 0, 1, '2022-12-20 10:39:45', '2022-12-20 10:39:45'),
(116, 4, 5, 1, 1, '2022-12-20 10:39:45', '2022-12-20 10:39:45'),
(117, 2, 4, 1, 0, '2023-01-01 16:15:01', '2023-01-01 16:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `sub_area_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `message_token` text DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `discount_rate` double DEFAULT 0,
  `account_balance` double DEFAULT 0,
  `is_has_custom_price` tinyint(1) NOT NULL DEFAULT 0,
  `in_accounts_order` tinyint(1) NOT NULL DEFAULT 0,
  `is_guest` tinyint(1) NOT NULL DEFAULT 0,
  `civil_registry` varchar(100) DEFAULT NULL,
  `client_type` enum('normal','company') DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `activity` varchar(100) DEFAULT NULL,
  `name_in_invoice` varchar(100) DEFAULT NULL,
  `bank_account_owner` varchar(100) DEFAULT NULL,
  `bank_account_number` int(11) DEFAULT NULL,
  `iban_number` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `fullname`, `area_id`, `sub_area_id`, `email`, `address`, `password`, `message_token`, `phone`, `is_active`, `is_approved`, `discount_rate`, `account_balance`, `is_has_custom_price`, `in_accounts_order`, `is_guest`, `civil_registry`, `client_type`, `bank`, `activity`, `name_in_invoice`, `bank_account_owner`, `bank_account_number`, `iban_number`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', 2, 4, 'admin@gmail.com', 'admin@gmail.com', '$2y$10$G3kP2B20BlCROHGZAASZge4QKBwwS8nR44CTDxqxUxv0aWXIfuDua', NULL, '+123 0915477450', 1, 1, 0, 0, 0, 0, 0, 'admin@gmail.com', 'company', 'بنك الرياض', NULL, NULL, 'admin@gmail.com', 123, 0, NULL, '2022-11-27 16:28:15', '2022-11-27 16:28:15'),
(2, 'Guest User', 1, 1, 'ashley64@example.com', '148 Yundt Plaza', '$2y$10$gakfeMRxqRZTELtCyGVKW.NdFJrsoj8pkFmMTXWrrlj0oNY0jjrF6', NULL, '+1-541-305-1353', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-28 15:51:17', '2022-11-28 15:51:17'),
(3, 'Guest User', 1, 1, 'blick.marvin@example.net', '56814 Nikolaus Forge', '$2y$10$208monIzdZdfmRdzvND0/uMLAfuLOOYLQBoOCGmIP8b9QARZYSCCa', NULL, '+1-934-310-5842', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-29 22:22:07', '2022-11-29 22:22:07'),
(4, 'اسم المتجر', 1, 3, 'storeemail@gmail.con', 'عنوان المتجر', '$2y$10$iQbwOLi446UKsohQUPaYwumJEQZ2RXRink0FVUintkf1g8aS.Wmqu', NULL, '+123 10', 1, 1, 10, 0, 0, 0, 1, '123456', 'company', 'بنك الرياض', NULL, NULL, 'اسم صاحب الحساب', 10, 123456789, NULL, '2022-11-29 22:24:34', '2022-11-29 22:31:38'),
(5, 'Guest User', 1, 1, 'jaiden81@example.com', '949 Arch Gateway Apt. 781', '$2y$10$Hwf8lZA2WQrCORDOWEUNxuKBWItilolfEoUvdghBCP80X/mlQPvwy', NULL, '(617) 268-3529', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-30 09:18:51', '2022-11-30 09:18:51'),
(6, 'Guest User', 1, 3, 'kertzmann.kory@example.net', '49937 Pauline Hollow Apt. 975', '$2y$10$IbXLezOAU/ylplc30792NOFNi9Ei.o2KjJ4aADYjTMTXaDVmgpdEK', NULL, '+1.682.582.2220', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-11-30 09:33:08', '2022-11-30 09:33:08'),
(7, 'Guest User', 1, 11, 'ukilback@example.com', '50034 Pacocha Valleys', '$2y$10$lJ4WcXjar8M.aQb/VDiL/.7v10vIwOwL1e8wxl0IWHGkYIHLUd5r.', NULL, '+1.320.376.2247', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-05 17:35:46', '2022-12-05 17:35:46'),
(8, 'متجر جديد', 1, 1, 'newstore@gmail.com', 'شارع ....', '$2y$10$o.ZTWdNRsqgoWshvBo7niuIuyssW64aIyhOSP/30UdpSEzNjINb.G', 'cCpy_Bh1TkGu68Rucv22A9:APA91bEOd8lKu2TeowK2ujX-pnwv5eC37WgryjDsa6sjIi9lLKyRhIjpHOT2ydNTW_dWEzK_SIJqUI5f9BMuimszfQJb8uYhSGCPQH7-1LOgVMJ_NNwza2X0Lbo7SSfUGzXJpUhGYdXJ', '+966512345678', 1, 1, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-05 17:50:01', '2022-12-05 17:51:38'),
(9, 'ahmed', 1, 1, 'ahmedict1@gmail.com', 'العنوان', '$2y$10$NrahApXIt.Osbw8Xw.y8YelJiRgHCS2YI.21dPQ5/MWpZbc0O8bMS', 'fgSZ_U_jjUKDsKfbdPfapA:APA91bGJ5KGInBRzDpIN6XzSTxKvN3cmjooBMO0ET5gSj0jA2YObHfW9ccRtyv2D_qRCDM0Mzf1QyPA66J6eSH8GzQiIK0aEeUthsoO1iNTmqaba8IaEgCQGgIxaEFwwNI4KOZEtKc8f', '+9665123123666', 1, 1, 0, 32, 0, 0, 0, NULL, 'company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-05 17:55:22', '2023-01-01 14:55:38'),
(10, 'Guest User', 1, 8, 'laverne53@example.net', '80645 Hudson Mountain', '$2y$10$LbIGgUnXIphWsx3uezAljOrnMj7SyGYKdGAEX5BCWoTZEnsZwJr2a', NULL, '347-498-6544', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-09 11:37:24', '2022-12-09 11:37:24'),
(11, 'Guest User', 1, 10, 'abshire.ruby@example.net', '7951 Wintheiser Streets', '$2y$10$76y.ZASLF2ewzJ847PrhAuqh/c038u1Go7jQahoh7kXWrPXzXNPsy', NULL, '1-786-746-6924', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-10 04:44:56', '2022-12-10 04:44:56'),
(12, 'Guest User', 1, 2, 'nbednar@example.com', '75939 Melany Stravenue Suite 949', '$2y$10$l3rGOCiY.trl9kK9emPBI.3HNClxA6H3dhhwEKlzsXZHRZtm2.6mC', NULL, '+1-667-588-1538', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-10 14:24:29', '2022-12-10 14:24:29'),
(13, 'Guest User', 1, 1, 'jannie88@example.net', '3489 Prosacco Islands Apt. 135', '$2y$10$GzYb0hW0tU2BRQfWzexWt.xxLC2..U3..i.G8.YCkEB9.f9Vj6WyC', NULL, '820.223.0097', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-10 15:09:10', '2022-12-10 15:09:10'),
(14, 'Guest User', 1, 2, 'brooklyn.gleason@example.net', '6169 Treutel Mission', '$2y$10$7grBR4Zu2sauRnBZfIa1Se.DC1Jwi6jfbdqliQCVHIado3/KAwAEu', NULL, '+1 (864) 873-8901', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-13 11:58:45', '2022-12-13 11:58:45'),
(15, 'waleed', 1, 1, 'wh1122111@gmail.com', 'sabya', '$2y$10$Zn0mx.8iOsPgdjLtjXhAYubj1TC5iDxhyALxe8nh/tzykG2caMMry', 'cYr2nmRTxUtfoJhosRtGc8:APA91bHblGYsp8BVmXYNYZfGmXOYPFtSalYY5Xor-u99hbmUEFLGyMm6OiesOPt20l8p9gmCvg-rIytJoI1QyZa0kCCYtURrN10WWII2QXAM3Jp9xcQdV-3MTCqygnm8PtYsqVFkP5Hn', '+966578887373', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-14 03:30:11', '2022-12-14 03:30:11'),
(16, 'عمار', 1, 1, 'zazaza112244550@gmail.com', 'صبياء', '$2y$10$zOBngX/s1zMbyLrxYN.1U./5APe0zsbWKIU5hCcz.lTgFdjL8u8xi', 'dEGtmP6kSOycNNK9RsxjBi:APA91bFbkrK8WeVOPxzXu4ya5fGUDg1IxwZnJN4ON12zAzLrqbnG4WLz7fQMF0IqiTuUsy9dTTsnVmLaA4MYK43c4gKjMzDdcGwYkILxeao2VjwEYRMM-1_73pd-I6UcMwiaT1yLELCl', '+966559744223', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-14 11:59:22', '2022-12-14 11:59:22'),
(17, 'omer abdalmonem', 1, 1, 'omeradalmonem45@gmai.com', 'Kartume', '$2y$10$S3TQaO2DKyYTPtdRt.FdWeA8H3FhHDmsHXq2xMB2lXD51DGTwmKUS', 'd_ELNDRXl0-us8_2kqD510:APA91bHG5mDh8FzjclHzfFN6OwUeZ9G1T2YgjDyGs-i0jpBZq0mZMyRzJl8r2EXn6x6Illyko6eaoE_OHlLNyQs-TPOwG5bp_xwb4H_MKRv4LO5kYupwxB7f7VjDUUTBW5j5ws4Ar0KJ', '+966903086047', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-17 19:46:57', '2022-12-17 19:46:57'),
(18, 'omer abdalmonem', 1, 1, 'omerabdalmonem45@gmail.com', 'khartoum', '$2y$10$gkt1bv0cmp06Stm9sEe9SejL85PLgfMacpPoEOOTWbXe3dP0xugqu', 'd_ELNDRXl0-us8_2kqD510:APA91bHG5mDh8FzjclHzfFN6OwUeZ9G1T2YgjDyGs-i0jpBZq0mZMyRzJl8r2EXn6x6Illyko6eaoE_OHlLNyQs-TPOwG5bp_xwb4H_MKRv4LO5kYupwxB7f7VjDUUTBW5j5ws4Ar0KJ', '+966249903086047', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-17 20:07:31', '2022-12-17 20:07:31'),
(19, 'Guest User', 1, 41, 'wbecker@example.net', '2134 Dare Point', '$2y$10$orKriBFwh.cqLLtsOZC77OosZ7dyczQfnUEGVjgWtZZoSoaaKhJZS', NULL, '541.377.3243', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-17 20:08:36', '2022-12-17 20:08:36'),
(20, 'name', 1, 17, 'omerabdalmonem45@gmail.com', '2095 Nader Station', '$2y$10$t9KypD.SGWFobBeMJnk54.o4I4mejQe6ZAGDEUM/T2CIKNohZAqFe', 'd_ELNDRXl0-us8_2kqD510:APA91bHG5mDh8FzjclHzfFN6OwUeZ9G1T2YgjDyGs-i0jpBZq0mZMyRzJl8r2EXn6x6Illyko6eaoE_OHlLNyQs-TPOwG5bp_xwb4H_MKRv4LO5kYupwxB7f7VjDUUTBW5j5ws4Ar0KJ', '00241234567', 1, 1, 0, 5, 0, 0, 0, NULL, 'company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-17 20:09:03', '2023-01-01 14:54:10'),
(21, 'Guest User', 1, 44, 'erwin.jacobs@example.com', '946 Funk Burg Suite 496', '$2y$10$noPSP0T/Vk54.77626gAr.Fu23OqHmbmFg9p3XdwWbUeXtSRWySGG', NULL, '718.718.4388', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-19 15:49:02', '2022-12-19 15:49:02'),
(22, 'ahmed', 1, 31, 'ahmedict1@gmail.com', '7356 Krajcik Springs Suite 117', '$2y$10$21H1OVBIQR2w9kdR7dikVexC6f4EwAWX3xkgJkf7hW4Bdm3esqKua', 'cCpy_Bh1TkGu68Rucv22A9:APA91bEOd8lKu2TeowK2ujX-pnwv5eC37WgryjDsa6sjIi9lLKyRhIjpHOT2ydNTW_dWEzK_SIJqUI5f9BMuimszfQJb8uYhSGCPQH7-1LOgVMJ_NNwza2X0Lbo7SSfUGzXJpUhGYdXJ', '0125107010', 1, 1, 0, 1, 0, 0, 0, NULL, 'company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-20 09:50:32', '2023-01-01 14:55:38'),
(23, 'احمد علي', 1, 5, 'ahmedict1@gmail.com', '28716 Yost Mall', '$2y$10$LH2fEk1QEKRcLsVrw3yXouT3kl6jD5SqKRlnILJKA47unGNx7s6o.', 'cCS48DmASie3lAkEg0V90l:APA91bEYXEBLJwgZi0TcA4v8ruTJXmgrotXEot6cm9HWlQjO-CaIG3XbZ7znoSLxAJg3diS9BMPc5V6h9jcx5KimrjRR8n-RxzNqfNw4tf-5zqHjuU6gJ3tur2xEOK70qgYyIkJTwBGg', '0124107010', 1, 1, 0, 1410, 0, 0, 0, NULL, 'company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-23 11:30:40', '2023-01-01 14:55:38'),
(24, 'Guest User', 1, 15, 'danny45@example.com', '2864 Thompson Turnpike', '$2y$10$mGxwUdCC47WbvpVruNmwj.Pd5Osiw.f9qO4s7q2fJxt4M9OYTT8jy', NULL, '571-740-8916', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-24 00:05:55', '2022-12-24 00:05:55'),
(25, 'Guest User', 1, 20, 'dexter58@example.net', '23235 Callie Squares', '$2y$10$E4CFzMVAjJr19m4EH9VwQO.0tAX07wjzjlh7IWs0z96P.EQL.DtQC', NULL, '1-734-933-3156', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-24 00:07:30', '2022-12-24 00:07:30'),
(26, 'عايشه احمد', 1, 1, 'ayshs12@icloud.com', '‏أبو سبيله', '$2y$10$USbTzd/C1u/9.cTOm6nSpeLsVBx8waRfvE3BHDOT/Sr0cPlyc4I7a', 'cVW0FgGPF0DvnIDlfb-LNG:APA91bGsEMSzkPhymE4Xm8o7dQhxLPOHsvbdEOvYVUP8LTBqd6EHECQWSUSahImS7tjyxmqXhx_GCWM4atpJMWjW10_kw5ZuMY97xMogN5uAEJSXXIkLtPys86JWFeDbg9qewCwa0uBK', '+966502842945', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-12-27 21:38:52', '2022-12-27 21:38:52'),
(27, 'سيف الامير', 1, 1, 'nooorameer59@gmail.com', 'الخضراء الشماليه', '$2y$10$iRCE3khshNTPfbSzxr4rVeiovnzxPu.yJbBIi1finiEyOGfzceQnO', 'daCAz-UYHEbQgtSApOSiqi:APA91bFk6J3zV0_Qj3YOBu0-BFPX4blLppjQyD4P8Gs-N3ZP33PY4BwC9whUgegcu9IxAs82EzUFdZS1Tx7eRLGWQrdsendLfcg9-I24NyxGs2jGsudJLvK0fQokVm2V1KKorYdsf-zo', '+966534147967', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 09:00:22', '2023-01-01 09:00:22'),
(28, 'سيف الامير', 1, 39, 'nooorameer59@gmail.com', '35145 Kemmer Alley', '$2y$10$6yqnWGCzD592/xvZ22rjU.UamOnhVXInJsOHP/qPxvVguNRDWTxVi', 'daCAz-UYHEbQgtSApOSiqi:APA91bFk6J3zV0_Qj3YOBu0-BFPX4blLppjQyD4P8Gs-N3ZP33PY4BwC9whUgegcu9IxAs82EzUFdZS1Tx7eRLGWQrdsendLfcg9-I24NyxGs2jGsudJLvK0fQokVm2V1KKorYdsf-zo', '0534147967', 1, 1, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 09:39:52', '2023-01-01 14:55:38'),
(29, 'Guest User', 1, 19, 'pstamm@example.net', '79123 Vivien Green Apt. 419', '$2y$10$BfUoDsGq65lgI1hCp1f1ceWfM6tmiExX80mtqwMgpx7/Q0uVlQcYi', NULL, '1-760-338-6477', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 14:22:56', '2023-01-01 14:22:56'),
(30, 'اسم المستخدم', 1, 1, 'ahmedictt1@gmail.com', 'البريد العنوزان', '$2y$10$f1ESeqd1Yaq69/fH4NMq9.4Zvwre02mEGsLX5gXmW7ev9HAtxXV7K', 'cCS48DmASie3lAkEg0V90l:APA91bEYXEBLJwgZi0TcA4v8ruTJXmgrotXEot6cm9HWlQjO-CaIG3XbZ7znoSLxAJg3diS9BMPc5V6h9jcx5KimrjRR8n-RxzNqfNw4tf-5zqHjuU6gJ3tur2xEOK70qgYyIkJTwBGg', '+966111111111', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 14:28:54', '2023-01-01 14:28:54'),
(31, 'احمد علي', 1, 1, 'ahmedict6@gmail.com', 'الخرطوم', '$2y$10$0k1ajyX8lSUVUdoNSL3xeuQsEZsO8ZWmMgqZDNe72rcCb4BjNf7ky', 'cCS48DmASie3lAkEg0V90l:APA91bEYXEBLJwgZi0TcA4v8ruTJXmgrotXEot6cm9HWlQjO-CaIG3XbZ7znoSLxAJg3diS9BMPc5V6h9jcx5KimrjRR8n-RxzNqfNw4tf-5zqHjuU6gJ3tur2xEOK70qgYyIkJTwBGg', '+966124107010', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 14:30:29', '2023-01-01 14:30:29'),
(32, 'احمد علي', 1, 1, 'ahmedict1@themsc.net', 'الخرطوم', '$2y$10$Va/Sbdx8qz7CIIt/D0b7/urlVBzPDpSTu/V7IyD0u.qtNfbhKcHZy', 'cCS48DmASie3lAkEg0V90l:APA91bEYXEBLJwgZi0TcA4v8ruTJXmgrotXEot6cm9HWlQjO-CaIG3XbZ7znoSLxAJg3diS9BMPc5V6h9jcx5KimrjRR8n-RxzNqfNw4tf-5zqHjuU6gJ3tur2xEOK70qgYyIkJTwBGg', '+966124107012', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 14:39:39', '2023-01-01 14:39:39'),
(33, 'ahmed ali', 1, 1, 'ahmed.ali@themsc.net', 'khrouttom', '$2y$10$eB7PApUKr6SQDeE9s1j24.Hd10dKm/hF4XUNkROCtMUteF0pj/vzi', 'cCS48DmASie3lAkEg0V90l:APA91bEYXEBLJwgZi0TcA4v8ruTJXmgrotXEot6cm9HWlQjO-CaIG3XbZ7znoSLxAJg3diS9BMPc5V6h9jcx5KimrjRR8n-RxzNqfNw4tf-5zqHjuU6gJ3tur2xEOK70qgYyIkJTwBGg', '+966124107013', 1, 1, 0, 15, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 14:41:30', '2023-01-01 14:55:18'),
(34, 'احمد علي حسن', 1, 1, 'info@themsc.net', 'الخرطوم ...', '$2y$10$snZ2aP8Cq6HRK3N3g0H6s.vrqh5X/r.NCsB.2GRNDNjAn95qbl4DK', 'eG68v6mXQ56AkGAyo0LMKm:APA91bFKuvVZYWghak1dJRl6tN4Yvkv9NXY6uJa7sV-0a9cNnh3wpCSl1FlP21Ekm9fbba3U2SK8bj9zLwwa4qtC2mJkSJQR3VTpbaiQ__OJvcrRV3_EIEiDUANK8hXxgbmeBqo6-apC', '+966124107014', 1, 1, 0, 2345, 0, 1, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 15:13:05', '2023-01-02 15:16:34'),
(35, 'البندري', 1, 1, 'Bno_911@hotmail.com', 'الرياض', '$2y$10$4vtVAtCz3LhwuCsrCRsaAeSgFoIm1E/ke5Z4nJhjftNC8V3suYWKu', 'cfASBTHn_kbzhvLljrqVpv:APA91bH-WacfckZEyI_VgJqWmHnR45qPJZeOy9lbDRVTV-W3rxvmV2Md40I0pMMbKGdjMzGm6vajkucUHsXic5fdEFemQVbL8vUsRD3pT8-KhlCeKfllx6pNvNpjL0b6NgrE7LiUYcYC', '+966594940027', 1, 0, 0, 0, 0, 0, 0, NULL, 'normal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-01 18:44:57', '2023-01-01 18:44:57'),
(36, 'Guest User', 1, 11, 'prosacco.itzel@example.net', '9106 Bailey Islands Apt. 802', '$2y$10$gKIU7EWuPWOek2KQ4nOJJOKD9TXhC2TVSfl8gLzLbgNYB.c6.feCS', NULL, '+15515140151', 1, 1, 0, 0, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-01-02 16:49:33', '2023-01-02 16:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `clients_files`
--

CREATE TABLE `clients_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `fileable_id` bigint(20) UNSIGNED NOT NULL,
  `fileable_type` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients_files`
--

INSERT INTO `clients_files` (`id`, `file`, `type`, `fileable_id`, `fileable_type`, `created_at`, `updated_at`) VALUES
(1, '/images/profile_23_01_01-1672605343.png', 'driving_license', 7, 'App\\Models\\Representative', '2023-01-01 18:35:43', '2023-01-01 18:35:43'),
(2, '/images/profile_23_01_01-1672605343.png', 'identify_image', 7, 'App\\Models\\Representative', '2023-01-01 18:35:43', '2023-01-01 18:35:43'),
(3, '/images/profile_23_01_01-1672605343.png', 'form_image', 7, 'App\\Models\\Representative', '2023-01-01 18:35:43', '2023-01-01 18:35:43'),
(4, '/images/profile_23_01_01-1672605371.png', 'driving_license', 8, 'App\\Models\\Representative', '2023-01-01 18:36:11', '2023-01-01 18:36:11'),
(5, '/images/profile_23_01_01-1672605371.png', 'identify_image', 8, 'App\\Models\\Representative', '2023-01-01 18:36:11', '2023-01-01 18:36:11'),
(6, '/images/profile_23_01_01-1672605371.png', 'form_image', 8, 'App\\Models\\Representative', '2023-01-01 18:36:11', '2023-01-01 18:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `clients_tokens`
--

CREATE TABLE `clients_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `api_secret_token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_service_prices`
--

CREATE TABLE `client_service_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('pickup','delivery') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fire_base_notification_histories`
--

CREATE TABLE `fire_base_notification_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `notifcation` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `type` enum('client','representative') NOT NULL DEFAULT 'client',
  `area_id` int(11) DEFAULT NULL,
  `notification_date` varchar(100) DEFAULT NULL,
  `topic` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_client_statements`
--

CREATE TABLE `issue_client_statements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total_shiping_type` int(11) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `total_deleviry_fess` int(11) DEFAULT NULL,
  `total_order_fess` int(11) DEFAULT NULL,
  `total_service_fess` int(11) DEFAULT NULL,
  `total_fess` int(11) DEFAULT NULL,
  `orders_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`orders_ids`)),
  `issue_date` timestamp NULL DEFAULT NULL,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_service_charges` int(11) DEFAULT NULL,
  `total_cod_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issue_client_statements`
--

INSERT INTO `issue_client_statements` (`id`, `total_shiping_type`, `client_id`, `total_deleviry_fess`, `total_order_fess`, `total_service_fess`, `total_fess`, `orders_ids`, `issue_date`, `status`, `created_at`, `updated_at`, `total_service_charges`, `total_cod_amount`) VALUES
(1, 0, 20, 0, 0, 0, 195, '[7,8,9,10,11]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:54:10', '2023-01-01 14:54:10', 200, 5),
(2, 0, 33, 0, 0, 0, -210, '[51]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:55:18', '2023-01-01 14:55:18', 40, 250),
(3, 0, 9, 0, 0, 0, -3568, '[1,2,3,4,5,6,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:55:38', '2023-01-01 14:55:38', 1165, 4733),
(4, 0, 22, 0, 0, 0, 39, '[12]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:55:38', '2023-01-01 14:55:38', 40, 1),
(5, 0, 23, 0, 0, 0, 37, '[39,40,41,42,43,44,45,46,47]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:55:38', '2023-01-01 14:55:38', 320, 283),
(6, 0, 28, 0, 0, 0, 105, '[48,49,50]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 14:55:38', '2023-01-01 14:55:38', 105, 0),
(7, 0, 34, 0, 0, 0, -1528, '[52,53,54,55,56,57,58]', '2022-12-31 22:00:00', 'unpaid', '2023-01-01 17:32:45', '2023-01-01 17:32:45', 280, 1808);

-- --------------------------------------------------------

--
-- Table structure for table `issue_photos`
--

CREATE TABLE `issue_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(100) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(100) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_08_18_090610_create_permission_tables', 1),
(6, '2021_08_21_104831_create_areas_table', 1),
(7, '2021_08_22_114221_create_sub_areas_table', 1),
(8, '2021_08_23_075314_create_area_price_histories_table', 1),
(9, '2021_08_23_112605_create_services_table', 1),
(10, '2021_08_23_122113_create_service_notes_table', 1),
(11, '2021_08_25_114013_create_clients_table', 1),
(12, '2021_08_26_141647_create_representatives_table', 1),
(13, '2021_08_28_070858_create_representative_areas_table', 1),
(14, '2021_08_29_122032_create_transactions_types_table', 1),
(15, '2021_08_29_122033_create_transactions_table', 1),
(16, '2021_08_29_122034_create_orders_table', 1),
(17, '2021_09_04_084451_create_serial_settings_table', 1),
(18, '2021_09_14_120259_create_cache_table', 1),
(19, '2021_09_14_131818_create_organization_profiles_table', 1),
(20, '2021_10_10_095209_create_settings_table', 1),
(21, '2021_10_10_100310_create_representative_orders_per_days_table', 1),
(22, '2021_10_10_101741_create_representative_orders_percentages_table', 1),
(23, '2021_10_11_070847_create_order_ranges_table', 1),
(24, '2021_10_13_073702_create_order_trackings_table', 1),
(25, '2022_01_05_090017_servives_price', 1),
(26, '2022_01_31_092917_create_is_service_models_table', 1),
(27, '2022_02_12_163423_create_client_service_prices_table', 1),
(28, '2022_02_15_061041_create_clients_tokens_table', 1),
(29, '2022_03_12_095204_create_fire_base_notification_histories_table', 1),
(30, '2022_03_26_081041_order_full_data_vue', 1),
(31, '2022_03_26_082653_representative_percentages_union_representative_per_days', 1),
(32, '2022_04_13_084417_create_issue_client_statements_table', 1),
(33, '2022_04_13_184413_create_issue_photos_table', 1),
(34, '2022_04_17_113912_create_clients_files_table', 1),
(35, '2022_09_18_112147_create_jobs_table', 1),
(36, '2022_10_17_151311_add_c_o_d_filed_to_service_price', 1),
(37, '2022_11_05_125814_issue_client_statements_edit_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tracking_number` varchar(100) NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `representative_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_phone` varchar(100) NOT NULL,
  `sender_area_id` bigint(20) UNSIGNED NOT NULL,
  `sender_sub_area_id` bigint(20) UNSIGNED NOT NULL,
  `sender_address` text NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone_no` varchar(100) NOT NULL,
  `receiver_area_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_sub_area_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_address` text NOT NULL,
  `police_file` varchar(100) DEFAULT NULL,
  `receipt_file` varchar(100) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_police_file_sent` tinyint(1) NOT NULL DEFAULT 0,
  `delivery_fees` double DEFAULT NULL,
  `order_fees` double DEFAULT NULL,
  `total_fees` double DEFAULT NULL,
  `payment_method` enum('on_sending','on_receiving','balance') NOT NULL,
  `is_company_fees_collected` tinyint(1) NOT NULL DEFAULT 0,
  `is_client_payment_made` tinyint(1) NOT NULL DEFAULT 0,
  `order_date` timestamp NOT NULL DEFAULT '2022-11-27 16:26:53',
  `delivery_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','pickup','inProgress','delivered','completed','returned','canceled') NOT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_payment_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_sn` varchar(100) NOT NULL,
  `order_weight` varchar(100) DEFAULT NULL,
  `order_value` varchar(100) DEFAULT NULL,
  `number_of_pieces` int(11) DEFAULT NULL,
  `is_collected` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tracking_number`, `service_id`, `client_id`, `representative_id`, `sender_name`, `sender_phone`, `sender_area_id`, `sender_sub_area_id`, `sender_address`, `receiver_name`, `receiver_phone_no`, `receiver_area_id`, `receiver_sub_area_id`, `receiver_address`, `police_file`, `receipt_file`, `note`, `is_police_file_sent`, `delivery_fees`, `order_fees`, `total_fees`, `payment_method`, `is_company_fees_collected`, `is_client_payment_made`, `order_date`, `delivery_date`, `status`, `transaction_id`, `client_payment_transaction_id`, `invoice_sn`, `order_weight`, `order_value`, `number_of_pieces`, `is_collected`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '2706050', 1, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 13, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 5, 13, 'الشارع العام', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-15 21:43:44', NULL, 'completed', 1, NULL, 'INV-2022-0000', '1', '1', 1, 1, 0, '2022-12-15 21:43:44', '2023-01-01 17:50:48'),
(2, '1419848', 2, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 13, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 4, 9, 'الشارع العام', '', '', NULL, 0, 30, 1, 1, 'balance', 1, 0, '2022-12-15 21:44:13', NULL, 'completed', 1, NULL, 'INV-2022-0001', '1', '1', 1, 1, 0, '2022-12-15 21:44:13', '2023-01-01 17:50:48'),
(3, '8571521', 1, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 12, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 5, 12, 'الشارع العام', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-15 22:28:26', NULL, 'completed', 1, NULL, 'INV-2022-0002', '1', '1', 1, 1, 0, '2022-12-15 22:28:26', '2023-01-01 17:50:48'),
(4, '1313985', 1, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 14, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 5, 14, 'الشارع العام', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-15 22:29:38', NULL, 'completed', 1, NULL, 'INV-2022-0003', '1', '220', 1, 1, 0, '2022-12-15 22:29:38', '2023-01-01 17:50:48'),
(5, '8563060', 2, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 14, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 4, 9, 'الشارع العام', '', '', NULL, 0, 30, 1, 1, 'balance', 1, 0, '2022-12-15 22:30:28', '2022-12-24 10:12:49', 'completed', 1, NULL, 'INV-2022-0004', '1', '1', 2, 1, 0, '2022-12-15 22:30:28', '2023-01-01 17:50:48'),
(6, '8996954', 3, 9, 2, 'طيبة', '٠٥٥٥٥٥٥٥٥٥', 5, 14, 'البلد', 'محمد', '٠٥٣٣٣٣٣٣٣٣', 6, 37, 'الشارع العام', '', '', NULL, 0, 20, 1, 1, 'balance', 1, 0, '2022-12-15 22:35:39', NULL, 'completed', 1, NULL, 'INV-2022-0005', '1', '2', 1, 1, 0, '2022-12-15 22:35:39', '2023-01-01 17:50:48'),
(7, '1588416', 1, 20, 2, 'omer', '123', 5, 19, 'المعلم', 'عمار', '٣٢١', 5, 16, 'العنوان', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-17 20:11:09', NULL, 'completed', 1, NULL, 'INV-2022-0006', '1', '1', 1, 1, 0, '2022-12-17 20:11:09', '2023-01-01 17:50:48'),
(8, '5626053', 1, 20, 2, 'omer', '123', 5, 19, 'المعلم', 'عمار', '٣٢١', 5, 16, 'العنوان', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-17 20:32:51', NULL, 'completed', 1, NULL, 'INV-2022-0007', '1', '1', 1, 1, 0, '2022-12-17 20:32:51', '2023-01-01 17:50:48'),
(9, '6389901', 1, 20, 2, 'omer', '123', 5, 19, 'المعلم', 'عمار', '٣٢١', 5, 16, 'العنوان', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-17 20:34:41', NULL, 'completed', 1, NULL, 'INV-2022-0008', '1', '1', 1, 1, 0, '2022-12-17 20:34:41', '2023-01-01 17:50:48'),
(10, '7487877', 1, 20, 2, 'omer', '123', 5, 19, 'المعلم', 'عمار', '٣٢١', 5, 16, 'العنوان', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-18 02:27:17', NULL, 'completed', 1, NULL, 'INV-2022-0009', '1', '1', 1, 1, 0, '2022-12-18 02:27:17', '2023-01-01 17:50:48'),
(11, '9330795', 1, 20, 2, 'omer', '123', 5, 19, 'المعلم', 'عمار', '٣٢١', 5, 16, 'العنوان', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-18 02:44:04', NULL, 'completed', 2, NULL, 'INV-2022-0010', '1', '1', 1, 1, 0, '2022-12-18 02:44:04', '2023-01-01 17:51:20'),
(12, '5384647', 1, 22, 2, 'ahmed', '12410', 5, 14, 'test', 'ali', '2021', 5, 15, 'test', '', '', 'note', 0, 40, 1, 1, 'balance', 1, 0, '2022-12-20 09:53:33', NULL, 'completed', 2, NULL, 'INV-2022-0011', '1', '1', 1, 1, 0, '2022-12-20 09:53:33', '2023-01-01 17:51:20'),
(13, '6073846', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 01:20:12', NULL, 'completed', 2, NULL, 'INV-2022-0012', '1', '0', 1, 1, 0, '2022-12-24 01:20:12', '2023-01-01 17:51:20'),
(14, '2029083', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 01:21:40', NULL, 'completed', 2, NULL, 'INV-2022-0013', '1', '200', 0, 1, 0, '2022-12-24 01:21:40', '2023-01-01 17:51:20'),
(15, '4107825', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 02:16:10', NULL, 'completed', 3, NULL, 'INV-2022-0014', '1', '0', 0, 1, 0, '2022-12-24 02:16:10', '2023-01-01 17:51:36'),
(16, '5547720', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:06:28', NULL, 'completed', 3, NULL, 'INV-2022-0015', '1', '200', 1, 1, 0, '2022-12-24 03:06:28', '2023-01-01 17:51:36'),
(17, '3880679', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:07:56', NULL, 'completed', 3, NULL, 'INV-2022-0016', '1', '0', 2, 1, 0, '2022-12-24 03:07:56', '2023-01-01 17:51:36'),
(18, '7054099', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:13:07', NULL, 'completed', 3, NULL, 'INV-2022-0017', '1', '0', 0, 1, 0, '2022-12-24 03:13:07', '2023-01-01 17:51:36'),
(19, '1788231', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:13:56', NULL, 'completed', 3, NULL, 'INV-2022-0018', '1', '0', 0, 1, 0, '2022-12-24 03:13:56', '2023-01-01 17:51:36'),
(20, '3153588', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:15:39', NULL, 'completed', 3, NULL, 'INV-2022-0019', '1', '10', 1, 1, 0, '2022-12-24 03:15:39', '2023-01-01 17:51:36'),
(21, '3767830', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:16:26', NULL, 'completed', 3, NULL, 'INV-2022-0020', '1', '0', 1, 1, 0, '2022-12-24 03:16:26', '2023-01-01 17:51:36'),
(22, '347240', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 13, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:38:15', NULL, 'completed', 3, NULL, 'INV-2022-0021', '1', '0', 0, 1, 0, '2022-12-24 03:38:15', '2023-01-01 17:51:36'),
(23, '7056274', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:39:49', NULL, 'completed', 3, NULL, 'INV-2022-0022', '1', '0', 0, 1, 0, '2022-12-24 03:39:49', '2023-01-01 17:51:36'),
(24, '8721392', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 12, 'الرجيع', 'نورة', '0559744223', 5, 12, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:41:33', NULL, 'completed', 3, NULL, 'INV-2022-0023', '1', '200', 0, 1, 0, '2022-12-24 03:41:33', '2023-01-01 17:51:36'),
(25, '8855985', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 12, 'الرجيع', 'نورة', '0559744223', 5, 12, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:41:51', NULL, 'completed', 4, NULL, 'INV-2022-0024', '1', '200', 0, 1, 0, '2022-12-24 03:41:51', '2023-01-01 17:51:51'),
(26, '8667653', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 12, 'الرجيع', 'نورة', '0559744223', 5, 12, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:43:18', NULL, 'completed', 4, NULL, 'INV-2022-0025', '1', '0', 0, 1, 0, '2022-12-24 03:43:18', '2023-01-01 17:51:51'),
(27, '986579', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 12, 'الرجيع', 'نورة', '0559744223', 5, 13, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:44:47', NULL, 'completed', 4, NULL, 'INV-2022-0026', '1', '0', 1, 1, 0, '2022-12-24 03:44:47', '2023-01-01 17:51:51'),
(28, '7225947', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 12, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:46:37', NULL, 'completed', 4, NULL, 'INV-2022-0027', '1', '0', 0, 1, 0, '2022-12-24 03:46:37', '2023-01-01 17:51:51'),
(29, '9806301', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 13, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:47:22', NULL, 'completed', 4, NULL, 'INV-2022-0028', '1', '0', 0, 1, 0, '2022-12-24 03:47:22', '2023-01-01 17:51:51'),
(30, '6482911', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:48:06', NULL, 'completed', 4, NULL, 'INV-2022-0029', '1', '0', 0, 1, 0, '2022-12-24 03:48:06', '2023-01-01 17:51:51'),
(31, '1009372', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:48:17', NULL, 'completed', 4, NULL, 'INV-2022-0030', '1', '0', 0, 1, 0, '2022-12-24 03:48:17', '2023-01-01 17:51:51'),
(32, '1478686', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:49:14', NULL, 'completed', 4, NULL, 'INV-2022-0031', '1', '200', 0, 1, 0, '2022-12-24 03:49:14', '2023-01-01 17:51:51'),
(33, '5528804', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:50:19', NULL, 'completed', 4, NULL, 'INV-2022-0032', '1', '0', 1, 1, 0, '2022-12-24 03:50:19', '2023-01-01 17:51:51'),
(34, '4776313', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:54:40', NULL, 'completed', 4, NULL, 'INV-2022-0033', '1', '1', 0, 1, 0, '2022-12-24 03:54:40', '2023-01-01 17:51:51'),
(35, '4770740', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:55:57', NULL, 'completed', 5, NULL, 'INV-2022-0034', '1', '1000', 0, 1, 0, '2022-12-24 03:55:57', '2023-01-01 17:52:07'),
(36, '6008749', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:56:37', '2022-12-24 03:12:43', 'completed', 5, NULL, 'INV-2022-0035', '1', '1000', 0, 1, 0, '2022-12-24 03:56:37', '2023-01-01 17:52:07'),
(37, '683660', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:57:15', '2022-12-24 02:12:15', 'completed', 5, NULL, 'INV-2022-0036', '1', '1000', 0, 1, 0, '2022-12-24 03:57:15', '2023-01-01 17:52:07'),
(38, '7662556', 1, 9, 2, 'متجر طيبة', '0559744223', 5, 14, 'الرجيع', 'نورة', '0559744223', 5, 14, 'الزاكي', '', '', NULL, 0, 40, 1, 1, 'balance', 1, 0, '2022-12-24 03:57:33', '2022-12-24 02:12:48', 'completed', 5, NULL, 'INV-2022-0037', '1', '500', 0, 1, 0, '2022-12-24 03:57:33', '2023-01-01 17:52:07'),
(39, '7135794', 1, 23, 2, 'ahmed', '123', 5, 16, 'الخرطوم', 'احمد', '321', 5, 16, 'طوك', '', '', 'نجربه', 0, 40, 250, 250, 'balance', 1, 0, '2022-12-24 13:00:36', NULL, 'completed', 5, NULL, 'INV-2022-0038', '3', '20', 350, 1, 0, '2022-12-24 13:00:36', '2023-01-01 17:52:07'),
(40, '2183331', 3, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'احمد', '321', 2, 30, 'طوك', '', '', 'نجربه', 0, 20, 250, 250, 'balance', 1, 0, '2022-12-24 13:02:29', NULL, 'completed', 5, NULL, 'INV-2022-0039', '3', '350', 20, 1, 0, '2022-12-24 13:02:29', '2023-01-01 17:52:07'),
(41, '3752246', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'احمد', '2235', 5, 15, 'احمد معلم', '', '', 'نجربه', 0, 40, 250, 250, 'balance', 1, 0, '2022-12-25 15:54:29', NULL, 'completed', 5, NULL, 'INV-2022-0040', '3', '20', 350, 1, 0, '2022-12-25 15:54:29', '2023-01-01 17:52:07'),
(42, '9375426', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'اا', '22', 5, 13, 'مممممم', '', '', 'نجربه', 0, 40, 10, 10, 'balance', 1, 0, '2022-12-25 15:58:35', NULL, 'completed', 5, NULL, 'INV-2022-0041', '1', '10', 1, 1, 0, '2022-12-25 15:58:35', '2023-01-01 17:52:07'),
(43, '7074718', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'احمد البه', '09123456', 5, 14, 'الخرطوم', '', '', 'نجربه', 0, 40, 0, 0, 'balance', 1, 0, '2022-12-25 17:08:32', NULL, 'completed', 5, NULL, 'INV-2022-0042', '1', '0', 1, 1, 0, '2022-12-25 17:08:32', '2023-01-01 17:52:07'),
(44, '4540097', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'احمد دد', '369', 5, 17, 'تجربه', '', '', 'نجربه', 0, 40, 250, 250, 'balance', 1, 0, '2022-12-25 17:14:49', NULL, 'completed', 5, NULL, 'INV-2022-0043', '1', '0', 1, 1, 0, '2022-12-25 17:14:49', '2023-01-01 17:52:07'),
(45, '3015702', 2, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'احمددد', '321', 4, 11, 'معلم ..ز', '', '', 'نجربه', 0, 30, 0, 0, 'balance', 1, 0, '2022-12-25 17:16:12', NULL, 'completed', 6, NULL, 'INV-2022-0044', '1', '0', 1, 1, 0, '2022-12-25 17:16:12', '2023-01-01 17:52:16'),
(46, '6920966', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'خهعع', '322', 5, 12, 'تتت', '', '', 'نجربه', 0, 40, 250, 250, 'balance', 1, 0, '2022-12-25 17:17:48', NULL, 'completed', 6, NULL, 'INV-2022-0045', '1', '33', 1, 1, 0, '2022-12-25 17:17:48', '2023-01-01 17:52:16'),
(47, '8315842', 1, 23, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 't', '123', 5, 14, 'gg', '', '', 'نجربه', 0, 40, 150, 150, 'balance', 1, 0, '2022-12-31 12:13:56', '2022-12-31 00:12:36', 'completed', 6, NULL, 'INV-2022-0046', '1', '200', 1, 1, 0, '2022-12-31 12:13:56', '2023-01-01 17:52:16'),
(48, '3440949', 1, 28, NULL, 'متجر', '0534147967', 5, 18, 'الخضراء الشماليه', 'هاله', '0534147967', 5, 12, 'ابوعريش', '', '', NULL, 0, 40, 0, 0, 'balance', 0, 0, '2023-01-01 09:42:55', NULL, 'canceled', NULL, NULL, 'INV-2023-0047', '1', '0', 1, 1, 0, '2023-01-01 09:42:55', '2023-01-01 14:55:38'),
(49, '2513107', 1, 28, NULL, 'متجر', '0534147967', 5, 18, 'الخضراء الشماليه', 'هاله', '0534147967', 5, 12, 'ابوعريش', '', '', NULL, 0, 40, 0, 0, 'balance', 0, 0, '2023-01-01 09:43:03', NULL, 'canceled', NULL, NULL, 'INV-2023-0048', '1', '0', 1, 1, 0, '2023-01-01 09:43:03', '2023-01-01 14:55:38'),
(50, '5998359', 1, 28, 3, 'متجر', '0534147967', 5, 18, 'الخضراء الشماليه', 'هاله', '0534147967', 5, 12, 'ابوعريش', '', '', NULL, 0, 40, 0, 0, 'balance', 0, 0, '2023-01-01 09:43:26', NULL, 'canceled', NULL, NULL, 'INV-2023-0049', '1', '0', 1, 1, 0, '2023-01-01 09:43:26', '2023-01-01 18:14:51'),
(51, '212260', 1, 33, 2, 'ahmed', '123', 5, 17, 'الخرطوم', 'omer mohmed', '123456789', 5, 14, 'الخرطوم شرق', '', '', 'نجربه', 0, 40, 15, 15, 'balance', 1, 0, '2023-01-01 14:51:39', '2023-01-01 02:01:12', 'completed', 6, NULL, 'INV-2023-0050', '1', '250', 1, 1, 0, '2023-01-01 14:51:39', '2023-01-01 17:52:16'),
(52, '181614', 1, 34, 2, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'عمار', '05212121256', 5, 12, 'جيزان بالقرب من مسجد ..', '', '', 'ملاحظه', 0, 40, 100, 100, 'balance', 1, 0, '2023-01-01 15:49:03', NULL, 'completed', 6, NULL, 'INV-2023-0051', '5', '250', 1, 1, 0, '2023-01-01 15:49:03', '2023-01-01 17:52:16'),
(53, '1874764', 1, 34, 3, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'احمد علي', '058231645', 5, 15, 'جيزان', '', '', 'ملاحظه', 0, 40, 22, 22, 'balance', 1, 0, '2023-01-01 15:56:47', NULL, 'completed', 6, NULL, 'INV-2023-0052', '1', '258', 1, 1, 0, '2023-01-01 15:56:47', '2023-01-01 18:14:51'),
(54, '4442894', 1, 34, 2, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'احمد', '0523164587', 5, 16, 'حي محمد خالد', '', '', 'ملاحظه', 0, 40, 360, 360, 'balance', 1, 0, '2023-01-01 17:09:22', NULL, 'completed', 2, NULL, 'INV-2023-0053', '1', '250', 1, 1, 0, '2023-01-01 17:09:22', '2023-01-01 17:51:20'),
(55, '1834510', 1, 34, 2, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'عمر محمد سالم', '0525234654', 5, 16, 'الشارع', '', '', 'ملاحظه', 0, 40, 30, 30, 'balance', 0, 0, '2023-01-01 17:16:44', '2023-01-01 06:01:47', 'delivered', NULL, NULL, 'INV-2023-0054', '1', '250', 1, 1, 0, '2023-01-01 17:16:44', '2023-01-01 18:10:47'),
(56, '8176918', 1, 34, 8, 'عمار', '052345678', 5, 16, 'جيزان بالقرب من ...', 'احمد خالد', '0564345487', 5, 14, 'العنوان', '', '', 'ملاحظه', 0, 40, 65, 65, 'balance', 1, 0, '2023-01-01 17:17:36', NULL, 'completed', 7, NULL, 'INV-2023-0055', '1', '200', 1, 1, 0, '2023-01-01 17:17:36', '2023-01-01 19:03:22'),
(57, '7232364', 1, 34, 8, 'احمد علي حسند', '052345678', 5, 16, 'جيزان بالقرب من ...', 'خالد محمد', '0532164575', 5, 20, 'معلم', '', '', 'ملاحظه', 0, 40, 258, 258, 'balance', 1, 0, '2023-01-01 17:18:24', NULL, 'completed', 7, NULL, 'INV-2023-0056', '1', '350', 1, 1, 0, '2023-01-01 17:18:24', '2023-01-01 19:03:22'),
(58, '4745152', 1, 34, 2, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'خالد', '05236545', 5, 23, 'الشارع', '', '', 'ملاحظه', 0, 40, 250, 250, 'balance', 1, 0, '2023-01-01 17:19:30', '2023-01-01 05:01:54', 'completed', 2, NULL, 'INV-2023-0057', '1', '250', 1, 1, 0, '2023-01-01 17:19:30', '2023-01-01 17:51:20'),
(59, '5454332', 1, 34, 8, 'احمد علي حسن', '052345678', 5, 16, 'جيزان بالقرب من ...', 'احمد علي حسن', '0525', 5, 12, 'الشارع', '', '', 'ملاحظه', 0, 40, 250, 250, 'balance', 1, 0, '2023-01-01 18:02:08', NULL, 'completed', 7, NULL, 'INV-2023-0058', '1', '250', 1, 0, 0, '2023-01-01 18:02:08', '2023-01-01 19:03:22'),
(60, '8956183', 3, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'احمد', '052345557', 2, 30, 'حي الشاطئ', '', '', 'ملاحظه', 0, 20, 250, 250, 'balance', 0, 0, '2023-01-01 18:08:40', '2023-01-01 06:01:43', 'inProgress', NULL, NULL, 'INV-2023-0059', '1', '0', 1, 0, 0, '2023-01-01 18:08:40', '2023-01-02 14:37:58'),
(61, '8597789', 1, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'hh', '6665', 5, 12, 'yyh', '', '', 'ملاحظه', 0, 40, 22, 22, 'balance', 1, 0, '2023-01-01 18:47:37', NULL, 'inProgress', 7, NULL, 'INV-2023-0060', '1', '22', 1, 0, 0, '2023-01-01 18:47:37', '2023-01-02 14:37:58'),
(62, '1796035', 3, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'gg', '3688', 6, 41, 'yyv', '', '', 'ملاحظه', 0, 20, 250, 250, 'balance', 1, 0, '2023-01-01 18:47:57', NULL, 'completed', 7, NULL, 'INV-2023-0061', '1', '0', 1, 0, 0, '2023-01-01 18:47:57', '2023-01-01 19:03:22'),
(63, '4149625', 1, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'uhb', '699', 5, 15, 'ggv', '', '', 'ملاحظه', 0, 40, 25, 25, 'balance', 1, 0, '2023-01-01 18:48:22', NULL, 'completed', 7, NULL, 'INV-2023-0062', '1', '250', 1, 0, 0, '2023-01-01 18:48:22', '2023-01-01 19:03:22'),
(64, '2090488', 1, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'hh', '880', 5, 13, 'fc', '', '', 'ملاحظه', 0, 40, 258, 258, 'balance', 0, 0, '2023-01-01 19:45:34', NULL, 'inProgress', NULL, NULL, 'INV-2023-0063', '1', '250', 1, 0, 0, '2023-01-01 19:45:34', '2023-01-01 19:45:44'),
(65, '1379184', 1, 34, 8, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'g', '25', 5, 13, 'g', '', '', 'ملاحظه', 0, 40, 200, 200, 'balance', 0, 0, '2023-01-02 15:07:25', '2023-01-02 03:01:55', 'delivered', NULL, NULL, 'INV-2023-0064', '1', '280', 1, 0, 0, '2023-01-02 15:07:25', '2023-01-02 15:10:55'),
(66, '134088', 1, 34, NULL, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'uu', '28', 5, 12, 'gg', '', '', 'ملاحظه', 0, 40, 0, 0, 'balance', 0, 0, '2023-01-02 15:14:24', NULL, 'pending', NULL, NULL, 'INV-2023-0065', '1', '20', 1, 0, 0, '2023-01-02 15:14:24', '2023-01-02 15:14:24'),
(67, '8829364', 1, 34, NULL, 'احمد علي حسن', '052345678', 5, 15, 'جيزان بالقرب من ...', 'gg', '55', 5, 12, 'gh', '', '', 'ملاحظه', 0, 40, 5, 5, 'balance', 0, 0, '2023-01-02 15:16:34', NULL, 'pending', NULL, NULL, 'INV-2023-0066', '1', '25', 1, 0, 0, '2023-01-02 15:16:34', '2023-01-02 15:16:34');

-- --------------------------------------------------------

--
-- Stand-in structure for view `orders_full_data`
-- (See below for the actual view)
--
CREATE TABLE `orders_full_data` (
`id` bigint(20) unsigned
,`service_id` bigint(20) unsigned
,`tracking_number` varchar(100)
,`receipt_file` varchar(100)
,`number_of_pieces` int(11)
,`note` text
,`client_id` bigint(20) unsigned
,`representative_id` bigint(20) unsigned
,`sender_name` varchar(100)
,`sender_phone` varchar(100)
,`sender_area_id` bigint(20) unsigned
,`sender_sub_area_id` bigint(20) unsigned
,`sender_address` text
,`receiver_name` varchar(100)
,`receiver_phone_no` varchar(100)
,`receiver_area_id` bigint(20) unsigned
,`receiver_sub_area_id` bigint(20) unsigned
,`receiver_address` text
,`police_file` varchar(100)
,`is_police_file_sent` tinyint(1)
,`delivery_fees` double
,`order_fees` double
,`total_fees` double
,`order_value` varchar(100)
,`payment_method` enum('on_sending','on_receiving','balance')
,`is_company_fees_collected` tinyint(1)
,`order_date` timestamp
,`order_weight` varchar(100)
,`delivery_date` timestamp
,`status` enum('pending','pickup','inProgress','delivered','completed','returned','canceled')
,`transaction_id` bigint(20) unsigned
,`invoice_sn` varchar(100)
,`is_deleted` tinyint(1)
,`created_at` timestamp
,`updated_at` timestamp
,`client_name` varchar(100)
,`representative_name` varchar(100)
,`service_name` varchar(100)
,`sender_area_name` varchar(100)
,`sender_sub_area_name` varchar(100)
,`receiver_area_name` varchar(100)
,`receiver_sub_area_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `order_ranges`
--

CREATE TABLE `order_ranges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_trackings`
--

CREATE TABLE `order_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `whats_sent` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `by` varchar(100) NOT NULL,
  `note` text NOT NULL,
  `note_ar` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_trackings`
--

INSERT INTO `order_trackings` (`id`, `order_id`, `date`, `whats_sent`, `status`, `user_id`, `by`, `note`, `note_ar`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-12-15 09:12:44', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-15 23:43:44', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-15 23:43:44', '2022-12-15 21:43:44', '2022-12-15 21:43:44'),
(2, 2, '2022-12-15 09:12:13', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-15 23:44:13', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-15 23:44:13', '2022-12-15 21:44:13', '2022-12-15 21:44:13'),
(3, 3, '2022-12-16 10:12:26', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-16 00:28:26', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-16 00:28:26', '2022-12-15 22:28:26', '2022-12-15 22:28:26'),
(4, 4, '2022-12-16 10:12:38', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-16 00:29:38', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-16 00:29:38', '2022-12-15 22:29:38', '2022-12-15 22:29:38'),
(5, 5, '2022-12-16 10:12:28', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-16 00:30:28', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-16 00:30:28', '2022-12-15 22:30:28', '2022-12-15 22:30:28'),
(6, 6, '2022-12-16 10:12:39', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-16 00:35:39', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-16 00:35:39', '2022-12-15 22:35:39', '2022-12-15 22:35:39'),
(7, 5, '2022-12-16 10:12:39', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2022-12-15 22:42:39', '2022-12-15 22:42:39'),
(8, 4, '2022-12-16 10:12:47', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2022-12-15 22:42:47', '2022-12-15 22:42:47'),
(9, 5, '2022-12-16 10:12:35', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-15 22:44:35', '2022-12-15 22:44:35'),
(10, 4, '2022-12-16 10:12:39', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-15 22:44:39', '2022-12-15 22:44:39'),
(11, 7, '2022-12-17 08:12:09', 0, 'pending', 0, 'name', 'New Order is add by name on  2022-12-17 22:11:09', 'تمت اضافه عنصر بواسطه nameفي2022-12-17 22:11:09', '2022-12-17 20:11:09', '2022-12-17 20:11:09'),
(12, 8, '2022-12-17 08:12:51', 0, 'pending', 0, 'name', 'New Order is add by name on  2022-12-17 22:32:51', 'تمت اضافه عنصر بواسطه nameفي2022-12-17 22:32:51', '2022-12-17 20:32:51', '2022-12-17 20:32:51'),
(13, 9, '2022-12-17 08:12:41', 0, 'pending', 0, 'name', 'New Order is add by name on  2022-12-17 22:34:41', 'تمت اضافه عنصر بواسطه nameفي2022-12-17 22:34:41', '2022-12-17 20:34:41', '2022-12-17 20:34:41'),
(14, 10, '2022-12-18 02:12:17', 0, 'pending', 0, 'name', 'New Order is add by name on  2022-12-18 04:27:17', 'تمت اضافه عنصر بواسطه nameفي2022-12-18 04:27:17', '2022-12-18 02:27:17', '2022-12-18 02:27:17'),
(15, 11, '2022-12-18 02:12:05', 0, 'pending', 0, 'name', 'New Order is add by name on  2022-12-18 04:44:04', 'تمت اضافه عنصر بواسطه nameفي2022-12-18 04:44:04', '2022-12-18 02:44:05', '2022-12-18 02:44:05'),
(16, 12, '2022-12-20 09:12:33', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-20 11:53:33', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-20 11:53:33', '2022-12-20 09:53:33', '2022-12-20 09:53:33'),
(17, 5, '2022-12-24 10:12:49', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2022-12-23 22:03:49', '2022-12-23 22:03:49'),
(18, 13, '2022-12-24 01:12:12', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 03:20:12', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 03:20:12', '2022-12-24 01:20:12', '2022-12-24 01:20:12'),
(19, 14, '2022-12-24 01:12:40', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 03:21:40', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 03:21:40', '2022-12-24 01:21:40', '2022-12-24 01:21:40'),
(20, 15, '2022-12-24 02:12:10', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 04:16:10', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 04:16:10', '2022-12-24 02:16:10', '2022-12-24 02:16:10'),
(21, 16, '2022-12-24 03:12:28', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:06:28', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:06:28', '2022-12-24 03:06:28', '2022-12-24 03:06:28'),
(22, 17, '2022-12-24 03:12:56', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:07:56', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:07:56', '2022-12-24 03:07:56', '2022-12-24 03:07:56'),
(23, 18, '2022-12-24 03:12:07', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:13:07', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:13:07', '2022-12-24 03:13:07', '2022-12-24 03:13:07'),
(24, 19, '2022-12-24 03:12:56', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:13:56', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:13:56', '2022-12-24 03:13:56', '2022-12-24 03:13:56'),
(25, 20, '2022-12-24 03:12:39', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:15:39', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:15:39', '2022-12-24 03:15:39', '2022-12-24 03:15:39'),
(26, 21, '2022-12-24 03:12:26', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:16:26', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:16:26', '2022-12-24 03:16:26', '2022-12-24 03:16:26'),
(27, 22, '2022-12-24 03:12:15', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:38:15', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:38:15', '2022-12-24 03:38:15', '2022-12-24 03:38:15'),
(28, 23, '2022-12-24 03:12:49', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:39:49', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:39:49', '2022-12-24 03:39:49', '2022-12-24 03:39:49'),
(29, 24, '2022-12-24 03:12:33', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:41:33', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:41:33', '2022-12-24 03:41:33', '2022-12-24 03:41:33'),
(30, 25, '2022-12-24 03:12:51', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:41:51', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:41:51', '2022-12-24 03:41:51', '2022-12-24 03:41:51'),
(31, 26, '2022-12-24 03:12:18', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:43:18', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:43:18', '2022-12-24 03:43:18', '2022-12-24 03:43:18'),
(32, 27, '2022-12-24 03:12:47', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:44:47', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:44:47', '2022-12-24 03:44:47', '2022-12-24 03:44:47'),
(33, 28, '2022-12-24 03:12:37', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:46:37', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:46:37', '2022-12-24 03:46:37', '2022-12-24 03:46:37'),
(34, 29, '2022-12-24 03:12:22', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:47:22', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:47:22', '2022-12-24 03:47:22', '2022-12-24 03:47:22'),
(35, 30, '2022-12-24 03:12:06', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:48:06', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:48:06', '2022-12-24 03:48:06', '2022-12-24 03:48:06'),
(36, 31, '2022-12-24 03:12:17', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:48:17', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:48:17', '2022-12-24 03:48:17', '2022-12-24 03:48:17'),
(37, 32, '2022-12-24 03:12:14', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:49:14', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:49:14', '2022-12-24 03:49:14', '2022-12-24 03:49:14'),
(38, 33, '2022-12-24 03:12:19', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:50:19', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:50:19', '2022-12-24 03:50:19', '2022-12-24 03:50:19'),
(39, 34, '2022-12-24 03:12:40', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:54:40', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:54:40', '2022-12-24 03:54:40', '2022-12-24 03:54:40'),
(40, 35, '2022-12-24 03:12:57', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:55:57', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:55:57', '2022-12-24 03:55:57', '2022-12-24 03:55:57'),
(41, 36, '2022-12-24 03:12:37', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:56:37', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:56:37', '2022-12-24 03:56:37', '2022-12-24 03:56:37'),
(42, 37, '2022-12-24 03:12:15', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:57:15', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:57:15', '2022-12-24 03:57:15', '2022-12-24 03:57:15'),
(43, 38, '2022-12-24 03:12:33', 0, 'pending', 0, 'ahmed', 'New Order is add by ahmed on  2022-12-24 05:57:33', 'تمت اضافه عنصر بواسطه ahmedفي2022-12-24 05:57:33', '2022-12-24 03:57:33', '2022-12-24 03:57:33'),
(44, 39, '2022-12-24 01:12:36', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-24 15:00:36', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-24 15:00:36', '2022-12-24 13:00:36', '2022-12-24 13:00:36'),
(45, 40, '2022-12-24 01:12:29', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-24 15:02:29', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-24 15:02:29', '2022-12-24 13:02:29', '2022-12-24 13:02:29'),
(46, 38, '2022-12-24 01:12:40', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2022-12-24 13:03:40', '2022-12-24 13:03:40'),
(47, 38, '2022-12-24 02:12:14', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-24 14:05:14', '2022-12-24 14:05:14'),
(48, 36, '2022-12-24 02:12:19', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-24 14:05:19', '2022-12-24 14:05:19'),
(49, 37, '2022-12-24 02:12:23', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-24 14:05:23', '2022-12-24 14:05:23'),
(50, 34, '2022-12-24 02:12:37', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-24 14:05:37', '2022-12-24 14:05:37'),
(51, 35, '2022-12-24 02:12:39', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-24 14:23:39', '2022-12-24 14:23:39'),
(52, 38, '2022-12-24 02:12:48', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2022-12-24 14:23:48', '2022-12-24 14:23:48'),
(53, 37, '2022-12-24 02:12:15', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2022-12-24 14:52:15', '2022-12-24 14:52:15'),
(54, 36, '2022-12-24 03:12:43', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2022-12-24 15:10:43', '2022-12-24 15:10:43'),
(55, 41, '2022-12-25 03:12:29', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 17:54:29', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 17:54:29', '2022-12-25 15:54:29', '2022-12-25 15:54:29'),
(56, 42, '2022-12-25 03:12:35', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 17:58:35', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 17:58:35', '2022-12-25 15:58:35', '2022-12-25 15:58:35'),
(57, 43, '2022-12-25 05:12:32', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 19:08:32', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 19:08:32', '2022-12-25 17:08:32', '2022-12-25 17:08:32'),
(58, 44, '2022-12-25 05:12:49', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 19:14:49', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 19:14:49', '2022-12-25 17:14:49', '2022-12-25 17:14:49'),
(59, 45, '2022-12-25 05:12:12', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 19:16:12', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 19:16:12', '2022-12-25 17:16:12', '2022-12-25 17:16:12'),
(60, 46, '2022-12-25 05:12:49', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-25 19:17:48', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-25 19:17:48', '2022-12-25 17:17:49', '2022-12-25 17:17:49'),
(61, 47, '2022-12-31 00:12:56', 0, 'pending', 0, 'احمد علي', 'New Order is add by احمد علي on  2022-12-31 14:13:56', 'تمت اضافه عنصر بواسطه احمد عليفي2022-12-31 14:13:56', '2022-12-31 12:13:56', '2022-12-31 12:13:56'),
(62, 47, '2022-12-31 00:12:19', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2022-12-31 12:25:19', '2022-12-31 12:25:19'),
(63, 47, '2022-12-31 00:12:26', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2022-12-31 12:25:26', '2022-12-31 12:25:26'),
(64, 47, '2022-12-31 00:12:36', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2022-12-31 12:25:36', '2022-12-31 12:25:36'),
(65, 48, '2023-01-01 09:01:55', 0, 'pending', 0, 'سيف الامير', 'New Order is add by سيف الامير on  2023-01-01 11:42:55', 'تمت اضافه عنصر بواسطه سيف الاميرفي2023-01-01 11:42:55', '2023-01-01 09:42:55', '2023-01-01 09:42:55'),
(66, 49, '2023-01-01 09:01:03', 0, 'pending', 0, 'سيف الامير', 'New Order is add by سيف الامير on  2023-01-01 11:43:03', 'تمت اضافه عنصر بواسطه سيف الاميرفي2023-01-01 11:43:03', '2023-01-01 09:43:03', '2023-01-01 09:43:03'),
(67, 50, '2023-01-01 09:01:26', 0, 'pending', 0, 'سيف الامير', 'New Order is add by سيف الامير on  2023-01-01 11:43:26', 'تمت اضافه عنصر بواسطه سيف الاميرفي2023-01-01 11:43:26', '2023-01-01 09:43:26', '2023-01-01 09:43:26'),
(68, 51, '2023-01-01 02:01:39', 0, 'pending', 0, 'ahmed ali', 'New Order is add by ahmed ali on  2023-01-01 16:51:39', 'تمت اضافه عنصر بواسطه ahmed aliفي2023-01-01 16:51:39', '2023-01-01 14:51:39', '2023-01-01 14:51:39'),
(69, 51, '2023-01-01 02:01:47', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2023-01-01 14:52:47', '2023-01-01 14:52:47'),
(70, 51, '2023-01-01 02:01:56', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2023-01-01 14:52:56', '2023-01-01 14:52:56'),
(71, 51, '2023-01-01 02:01:12', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2023-01-01 14:53:12', '2023-01-01 14:53:12'),
(72, 46, '2023-01-01 02:01:38', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2023-01-01 14:57:38', '2023-01-01 14:57:38'),
(73, 52, '2023-01-01 03:01:03', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 17:49:03', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 17:49:03', '2023-01-01 15:49:03', '2023-01-01 15:49:03'),
(74, 53, '2023-01-01 03:01:47', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 17:56:47', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 17:56:47', '2023-01-01 15:56:47', '2023-01-01 15:56:47'),
(75, 54, '2023-01-01 05:01:22', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 19:09:22', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 19:09:22', '2023-01-01 17:09:22', '2023-01-01 17:09:22'),
(76, 54, '2023-01-01 05:01:07', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2023-01-01 17:12:07', '2023-01-01 17:12:07'),
(77, 55, '2023-01-01 05:01:44', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 19:16:44', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 19:16:44', '2023-01-01 17:16:44', '2023-01-01 17:16:44'),
(78, 56, '2023-01-01 05:01:36', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 19:17:36', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 19:17:36', '2023-01-01 17:17:36', '2023-01-01 17:17:36'),
(79, 57, '2023-01-01 05:01:24', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 19:18:24', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 19:18:24', '2023-01-01 17:18:24', '2023-01-01 17:18:24'),
(80, 58, '2023-01-01 05:01:30', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 19:19:30', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 19:19:30', '2023-01-01 17:19:30', '2023-01-01 17:19:30'),
(81, 58, '2023-01-01 05:01:37', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2023-01-01 17:33:37', '2023-01-01 17:33:37'),
(82, 58, '2023-01-01 05:01:54', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2023-01-01 17:33:54', '2023-01-01 17:33:54'),
(83, 59, '2023-01-01 06:01:08', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 20:02:08', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 20:02:08', '2023-01-01 18:02:08', '2023-01-01 18:02:08'),
(84, 60, '2023-01-01 06:01:40', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 20:08:40', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 20:08:40', '2023-01-01 18:08:40', '2023-01-01 18:08:40'),
(85, 60, '2023-01-01 06:01:20', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2023-01-01 18:09:20', '2023-01-01 18:09:20'),
(86, 59, '2023-01-01 06:01:24', 0, 'pickup', 0, 'representative', 'order has been accepted by representative ( اسم المندوب )', NULL, '2023-01-01 18:09:24', '2023-01-01 18:09:24'),
(87, 60, '2023-01-01 06:01:26', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2023-01-01 18:10:26', '2023-01-01 18:10:26'),
(88, 55, '2023-01-01 06:01:33', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( اسم المندوب )', NULL, '2023-01-01 18:10:33', '2023-01-01 18:10:33'),
(89, 60, '2023-01-01 06:01:43', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2023-01-01 18:10:43', '2023-01-01 18:10:43'),
(90, 55, '2023-01-01 06:01:47', 0, 'delivered', 0, 'representative', 'order has been delivered by representative ( اسم المندوب )', NULL, '2023-01-01 18:10:47', '2023-01-01 18:10:47'),
(91, 61, '2023-01-01 06:01:37', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 20:47:37', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 20:47:37', '2023-01-01 18:47:37', '2023-01-01 18:47:37'),
(92, 62, '2023-01-01 06:01:57', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 20:47:57', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 20:47:57', '2023-01-01 18:47:57', '2023-01-01 18:47:57'),
(93, 63, '2023-01-01 06:01:22', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 20:48:22', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 20:48:22', '2023-01-01 18:48:22', '2023-01-01 18:48:22'),
(94, 64, '2023-01-01 07:01:34', 0, 'pending', 0, 'احمد علي حسن', 'New Order is add by احمد علي حسن on  2023-01-01 21:45:34', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-01 21:45:34', '2023-01-01 19:45:34', '2023-01-01 19:45:34'),
(95, 64, '2023-01-01 07:01:44', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( ahmed )', NULL, '2023-01-01 19:45:44', '2023-01-01 19:45:44'),
(96, 65, '2023-01-02 03:01:25', 0, 'pending', 0, 'احمد علي حسن', 'تم اضافه طلب جديد بواسطهاحمد علي حسن بتاريخ  2023-01-02 17:07:25', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-02 17:07:25', '2023-01-02 15:07:25', '2023-01-02 15:07:25'),
(97, 65, '2023-01-02 03:01:38', 0, 'pickup', 0, 'representative', 'تم استلام الطلب بواسطه ( ahmed )', NULL, '2023-01-02 15:09:38', '2023-01-02 15:09:38'),
(98, 65, '2023-01-02 03:01:53', 0, 'inProgress', 0, 'representative', 'order in progress with representative ( ahmed )', NULL, '2023-01-02 15:09:53', '2023-01-02 15:09:53'),
(99, 65, '2023-01-02 03:01:55', 0, 'delivered', 0, 'representative', 'تم تسليم الطلب عبر المندوب  ( ahmed )', NULL, '2023-01-02 15:10:55', '2023-01-02 15:10:55'),
(100, 66, '2023-01-02 03:01:24', 0, 'pending', 0, 'احمد علي حسن', 'تم اضافه طلب جديد بواسطهاحمد علي حسن بتاريخ  2023-01-02 17:14:24', 'تمت اضافه عنصر بواسطه احمد علي حسنفي2023-01-02 17:14:24', '2023-01-02 15:14:24', '2023-01-02 15:14:24'),
(101, 67, '2023-01-02 03:01:34', 0, 'جديد', 0, 'احمد علي حسن', ' تم اضافه طلب جديد بواسطه  احمد علي حسن بتاريخ  2023-01-02 17:16:34', ' تمت اضافه عنصر بواسطه  احمد علي حسنفي2023-01-02 17:16:34', '2023-01-02 15:16:34', '2023-01-02 15:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `organization_profiles`
--

CREATE TABLE `organization_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(100) NOT NULL,
  `whatsapp_no` varchar(100) NOT NULL,
  `pravicy_en` text DEFAULT NULL,
  `pravicy_ar` text DEFAULT NULL,
  `countery_key` varchar(100) NOT NULL DEFAULT '+123',
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organization_profiles`
--

INSERT INTO `organization_profiles` (`id`, `logo`, `name`, `address`, `phone_no`, `whatsapp_no`, `pravicy_en`, `pravicy_ar`, `countery_key`, `email`, `created_at`, `updated_at`) VALUES
(1, 'logos/logo.png', 'Faster', 'KSA, Riyadh', '96623323093', '96623323093', NULL, NULL, '+966', 'info@faster.com', NULL, '2022-12-16 14:56:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `guard_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'roles-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(2, 'users-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(3, 'areas-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(4, 'services-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(5, 'organization-profile-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(6, 'clients-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(7, 'representatives-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(8, 'representatives-orders-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(9, 'representatives-fees-collection-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(10, 'orders-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(11, 'reports-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(12, 'orders-importCSV-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(13, 'general-settings-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(14, 'representatives-payment-management', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(100) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Client', 2, 'Guest User', '0ba386cee76bd13da677273c1c618dbde12b5150004bd4b7a1720d691876cf02', '[\"*\"]', '2022-11-28 15:53:01', '2022-11-28 15:51:17', '2022-11-28 15:53:01'),
(2, 'App\\Models\\Client', 3, 'Guest User', 'db97ca16b17498b209faad0466864e7bc4754371de21bb3d1367ba43b4591838', '[\"*\"]', '2022-11-29 22:22:19', '2022-11-29 22:22:07', '2022-11-29 22:22:19'),
(3, 'App\\Models\\Client', 4, 'Guest User', '094c1c6ba7768aa5ae7a12d2f313c4820972ab8bfe29acbaf235b8bf1f6e1073', '[\"*\"]', '2022-11-29 22:31:50', '2022-11-29 22:24:34', '2022-11-29 22:31:50'),
(9, 'App\\Models\\Client', 10, 'Guest User', 'da3c0d3514117fb41a7b81b8a559d123f08ecbfa12fb608ab68216bba79d7933', '[\"*\"]', '2022-12-10 04:40:19', '2022-12-09 11:37:24', '2022-12-10 04:40:19'),
(12, 'App\\Models\\Client', 12, 'Guest User', '324c64d9043efbe75e30b8f2c981cda66fa5cd72633f80c07841ee67e785134f', '[\"*\"]', '2022-12-10 14:25:16', '2022-12-10 14:24:29', '2022-12-10 14:25:16'),
(20, 'App\\Models\\Client', 14, 'Guest User', '2456003b9c75c21e3212916401810893dd02c0fee9c3a9236a2ebb8b72b007f3', '[\"*\"]', '2022-12-13 11:59:12', '2022-12-13 11:58:45', '2022-12-13 11:59:12'),
(25, 'App\\Models\\Client', 20, 'Guest User', '54ac72ced05ebab9491aa35b55bfbf3796b84ae62621b2b22feea4ca0354a79d', '[\"*\"]', '2022-12-20 20:15:26', '2022-12-17 20:09:03', '2022-12-20 20:15:26'),
(26, 'App\\Models\\Client', 20, 'xiBi91OWwH', 'c674da532622f7a2ff7e05efb487b04cee6824e52d0cb2905ab15b50375ceb20', '[\"*\"]', NULL, '2022-12-17 20:11:08', '2022-12-17 20:11:08'),
(27, 'App\\Models\\Client', 21, 'Guest User', 'f1afefc9a1b4ada2a7de3978aee8692d2eb9014d5f78e0ad8df107f2c00b8059', '[\"*\"]', '2022-12-19 15:56:04', '2022-12-19 15:49:02', '2022-12-19 15:56:04'),
(28, 'App\\Models\\Client', 22, 'Guest User', '764c1a19530e3525474fdac337e8b93a6d462d5dae13d8ab29ac9ebd475ff464', '[\"*\"]', '2022-12-20 10:05:39', '2022-12-20 09:50:32', '2022-12-20 10:05:39'),
(29, 'App\\Models\\Client', 22, 'YojJntO51P', '4df299f2d7f3cbc5a0908c2b63ea1bc82d301ca466bb7f5aac6199c77dfdf869', '[\"*\"]', NULL, '2022-12-20 09:53:32', '2022-12-20 09:53:32'),
(35, 'App\\Models\\Client', 24, 'Guest User', 'd3cdb817ae9ad894f6d26f6b847f9f3c9e02445a7aee1f39616a72aba92e83c0', '[\"*\"]', '2022-12-24 00:06:13', '2022-12-24 00:05:55', '2022-12-24 00:06:13'),
(37, 'App\\Models\\Client', 9, 'eecef88eecf7f6c3', '12afb41987b5a41b754fbf76b477c3b8c467e4dcff4395a81733a880853087dc', '[\"*\"]', '2022-12-27 18:10:03', '2022-12-24 00:43:47', '2022-12-27 18:10:03'),
(38, 'App\\Models\\Client', 9, '5D3B5C3E-64AC-4039-941B-6B57D640CF35', 'aa37e9101006a2aba46c7b1efe530ad748c0b6bd36f9b9b0d057fac241ba99dc', '[\"*\"]', NULL, '2022-12-24 02:08:35', '2022-12-24 02:08:35'),
(43, 'App\\Models\\Client', 28, 'Guest User', '41828b01773c80b6e5e3da5e8e24f2a282fae126e639c34764d7e10769057df4', '[\"*\"]', '2023-01-01 09:47:49', '2023-01-01 09:39:52', '2023-01-01 09:47:49'),
(44, 'App\\Models\\Client', 28, 'LUXd5WGovM', '83acc789987f6d2c1f04f3d1a49d83dba2be64ef99e4102c7f24b1dfc53a3977', '[\"*\"]', NULL, '2023-01-01 09:42:55', '2023-01-01 09:42:55'),
(45, 'App\\Models\\Client', 28, 'Nc4G7aIZ3c', '503a3a88f6525966f6d109e2cc64ce8c4f4b6e875faba62ec41bb7e7c8e584c1', '[\"*\"]', NULL, '2023-01-01 09:43:02', '2023-01-01 09:43:02'),
(46, 'App\\Models\\Client', 28, 'ygn11d1NxU', '8107300a66c69ec8f0d0a2af69c974900f17d3a84e7a0cce2cdf27d4dde51d4c', '[\"*\"]', NULL, '2023-01-01 09:43:25', '2023-01-01 09:43:25'),
(51, 'App\\Models\\Client', 34, 'd090d723f11d8c17', 'fe0acb023fa5af1308f3ae861cf148bd2b2a6d3103cc923fb3b16f157e49648e', '[\"*\"]', '2023-01-02 16:57:33', '2023-01-01 17:08:41', '2023-01-02 16:57:33'),
(53, 'App\\Models\\Representative', 8, 'd090d723f11d8c17', '18843c5bcd2c7963df866d3c892b80bcfdc40bb556f36c661058fe5a4e1eaa87', '[\"*\"]', '2023-01-02 16:56:57', '2023-01-01 18:42:32', '2023-01-02 16:56:57'),
(54, 'App\\Models\\Client', 36, 'Guest User', '1f1eb5b6c7f5e265d6bf1c6959e997fed196158530c87c8d7887436074e36a22', '[\"*\"]', '2023-01-02 16:57:22', '2023-01-02 16:49:33', '2023-01-02 16:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `representatives`
--

CREATE TABLE `representatives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `message_token` text DEFAULT NULL,
  `account_balance` double DEFAULT 0,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `representatives`
--

INSERT INTO `representatives` (`id`, `fullname`, `email`, `password`, `address`, `phone`, `is_active`, `is_approved`, `message_token`, `account_balance`, `area_id`, `sub_area_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'deriverGeust', 'msctesteremail@themsc.net', '', NULL, '+249 0915477450', 1, 1, NULL, 0, 1, 1, NULL, '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(2, 'اسم المندوب', 'ahmedict1@gmail.com', '$2y$10$kbQidM1NKrOz9/2OkY/T3OSSL7QPPZ4WlVoDXFxuv5yLYay.AQ75K', 'العنوان', '+123 249124107010', 1, 1, 'e5NA-gE8Qqq90v4yTzxGCH:APA91bEYDD_4wMi_1_PywQpV3X-hMB6siRrI4461jQGBupZzq1mcRbkNywYAHo7yYbtQs-1mdoVt66BzrSmwVI6J1FE4L4Agbw8CMZ_Uya3e2-_v9iCHOn0udVdEEt3PnK0XlsvK9xnp', 1005, 5, 14, NULL, '2022-12-01 15:14:42', '2023-01-01 17:52:16'),
(3, 'اسم المندوب', 'ahmedictt6@gmail.com', '$2y$10$p9dUKrEjGvQ6KeQwiu5MS.MnZIxdIApR5Smw8lD278R7Uk3h1wO0C', 'عنوانالمندوب', '+966124107010', 1, 1, 'Instance of \'Future<String?>\'', 0, 1, 1, NULL, '2022-12-01 15:21:13', '2022-12-01 15:23:47'),
(5, 'إبراهيم عرفه غازي', 'anasib246@gmail.com', '$2y$10$lYcBBkTG3As07sX20BEm5.Yjp5o6IBN8C79ryhNK4/7D3VBoEDJA.', 'الرياض', '+966583466541', 1, 0, 'Instance of \'Future<String?>\'', 0, 4, 9, NULL, '2022-12-16 14:25:56', '2022-12-16 14:25:56'),
(7, 'ahmed', 'info@themsc.net', '$2y$10$R5lhhdaegJYn0yGNuO1/LetYjRYh9.EC1j2U8uJAtmIGlnuVXFYjG', 'الحي', '+966556464637', 1, 1, 'Instance of \'Future<String?>\'', 0, 5, 18, NULL, '2023-01-01 18:35:43', '2023-01-01 18:42:02'),
(8, 'ahmed', 'free@themsc.net', '$2y$10$0lVLmZwwwYhjnbUGt/XT/O.3PU9A2IJKb.7OGY9qoGfTVBFMedpoy', 'الحي', '+966556494637', 1, 1, 'e5NA-gE8Qqq90v4yTzxGCH:APA91bEYDD_4wMi_1_PywQpV3X-hMB6siRrI4461jQGBupZzq1mcRbkNywYAHo7yYbtQs-1mdoVt66BzrSmwVI6J1FE4L4Agbw8CMZ_Uya3e2-_v9iCHOn0udVdEEt3PnK0XlsvK9xnp', 110, 5, 18, NULL, '2023-01-01 18:36:11', '2023-01-01 19:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `representative_areas`
--

CREATE TABLE `representative_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `representative_id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subarea_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `representative_areas`
--

INSERT INTO `representative_areas` (`id`, `representative_id`, `area_id`, `subarea_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 2, '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(2, 1, NULL, 1, '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(3, 1, NULL, 3, '2022-11-27 16:26:54', '2022-11-27 16:26:54'),
(102, 3, NULL, 12, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(103, 3, NULL, 13, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(104, 3, NULL, 14, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(105, 3, NULL, 15, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(106, 3, NULL, 16, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(107, 3, NULL, 17, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(108, 3, NULL, 18, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(109, 3, NULL, 19, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(110, 3, NULL, 20, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(111, 3, NULL, 21, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(112, 3, NULL, 22, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(113, 3, NULL, 23, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(114, 3, NULL, 24, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(115, 3, NULL, 25, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(116, 3, NULL, 26, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(117, 3, NULL, 27, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(118, 3, NULL, 28, '2022-12-23 22:00:07', '2022-12-23 22:00:07'),
(204, 2, NULL, 15, NULL, NULL),
(205, 2, NULL, 16, NULL, NULL),
(206, 2, NULL, 19, NULL, NULL),
(224, 8, NULL, 12, NULL, NULL),
(225, 8, NULL, 13, NULL, NULL),
(226, 8, NULL, 14, NULL, NULL),
(227, 8, NULL, 15, NULL, NULL),
(228, 8, NULL, 16, NULL, NULL),
(229, 8, NULL, 17, NULL, NULL),
(230, 8, NULL, 18, NULL, NULL),
(231, 8, NULL, 19, NULL, NULL),
(232, 8, NULL, 20, NULL, NULL),
(233, 8, NULL, 21, NULL, NULL),
(234, 8, NULL, 22, NULL, NULL),
(235, 8, NULL, 23, NULL, NULL),
(236, 8, NULL, 24, NULL, NULL),
(237, 8, NULL, 25, NULL, NULL),
(238, 8, NULL, 26, NULL, NULL),
(239, 8, NULL, 27, NULL, NULL),
(240, 8, NULL, 28, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `representative_orders_percentages`
--

CREATE TABLE `representative_orders_percentages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `representative_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `deserve` int(11) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `payment_date` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `representative_orders_percentages`
--

INSERT INTO `representative_orders_percentages` (`id`, `representative_id`, `order_id`, `deserve`, `is_paid`, `payment_date`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(2, 2, 2, 15, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(3, 2, 3, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(4, 2, 4, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(5, 2, 5, 15, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(6, 2, 6, 10, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(7, 2, 7, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(8, 2, 8, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(9, 2, 9, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(10, 2, 10, 20, 0, NULL, NULL, '2023-01-01 17:50:48', '2023-01-01 17:50:48'),
(11, 2, 11, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(12, 2, 12, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(13, 2, 13, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(14, 2, 14, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(15, 2, 54, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(16, 2, 58, 20, 0, NULL, NULL, '2023-01-01 17:51:20', '2023-01-01 17:51:20'),
(17, 2, 15, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(18, 2, 16, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(19, 2, 17, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(20, 2, 18, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(21, 2, 19, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(22, 2, 20, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(23, 2, 21, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(24, 2, 22, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(25, 2, 23, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(26, 2, 24, 20, 0, NULL, NULL, '2023-01-01 17:51:36', '2023-01-01 17:51:36'),
(27, 2, 25, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(28, 2, 26, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(29, 2, 27, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(30, 2, 28, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(31, 2, 29, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(32, 2, 30, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(33, 2, 31, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(34, 2, 32, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(35, 2, 33, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(36, 2, 34, 20, 0, NULL, NULL, '2023-01-01 17:51:51', '2023-01-01 17:51:51'),
(37, 2, 35, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(38, 2, 36, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(39, 2, 37, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(40, 2, 38, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(41, 2, 39, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(42, 2, 40, 10, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(43, 2, 41, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(44, 2, 42, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(45, 2, 43, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(46, 2, 44, 20, 0, NULL, NULL, '2023-01-01 17:52:07', '2023-01-01 17:52:07'),
(47, 2, 45, 15, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(48, 2, 46, 20, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(49, 2, 47, 20, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(50, 2, 51, 20, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(51, 2, 52, 20, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(52, 2, 53, 20, 0, NULL, NULL, '2023-01-01 17:52:16', '2023-01-01 17:52:16'),
(53, 8, 56, 20, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22'),
(54, 8, 57, 20, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22'),
(55, 8, 59, 20, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22'),
(56, 8, 61, 20, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22'),
(57, 8, 62, 10, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22'),
(58, 8, 63, 20, 0, NULL, NULL, '2023-01-01 19:03:22', '2023-01-01 19:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `representative_orders_per_days`
--

CREATE TABLE `representative_orders_per_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `representative_id` bigint(20) UNSIGNED NOT NULL,
  `orders_count` int(11) NOT NULL,
  `deserve` int(11) NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `payment_date` timestamp NULL DEFAULT NULL,
  `transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `representative_percentages_union_representative_per_days`
-- (See below for the actual view)
--
CREATE TABLE `representative_percentages_union_representative_per_days` (
`representative_id` bigint(20) unsigned
,`deserve` int(11)
,`is_paid` tinyint(1)
,`payment_date` timestamp
,`transaction_id` bigint(20) unsigned
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `guard_name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2022-11-27 16:26:54', '2022-11-27 16:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
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
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `serial_settings`
--

CREATE TABLE `serial_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inv_no` int(11) NOT NULL,
  `trans_no` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `serial_settings`
--

INSERT INTO `serial_settings` (`id`, `inv_no`, `trans_no`, `created_at`, `updated_at`) VALUES
(1, 67, 7, NULL, '2023-01-02 15:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `descr` text DEFAULT NULL,
  `is_fill_sender` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `photo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` double NOT NULL,
  `cod` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `descr`, `is_fill_sender`, `is_active`, `photo`, `created_at`, `updated_at`, `price`, `cod`) VALUES
(1, 'توصيل الطلبات للمتاجر', '', 1, 1, 'services/C7AWQmp2rlc0efvfKQEcXvjYzGa82LTR9YPAFFyd.jpg', NULL, '2022-12-10 04:38:07', 40, 35),
(2, 'شحن الطلبات للمتاجر', '', 1, 1, 'services/RErRy3kbH1vphKF3lZqjvMuMxEegx9ju4aLGAKro.jpg', NULL, '2022-12-10 04:37:42', 30, NULL),
(3, 'الشحن الدولي ', '', 0, 1, 'services/A0Bxp7oMPjnfqDcCV1lxG7FdgeL88D0OwVQft45p.jpg', NULL, '2022-12-10 04:35:53', 20, NULL),
(4, 'استرجاع الطلبات', 'الطلبات', 0, 1, 'services/eiOLsFtVnwMx37xq1GTUpB0i4tH6Q3nKrp80Ii5F.jpg', NULL, '2022-12-10 04:35:21', 10, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_notes`
--

CREATE TABLE `service_notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'order_return_price', '300', NULL, NULL),
(2, 'representative_deserves_calculation_method', 'percentage', NULL, NULL),
(3, 'representative_percentage', '50', NULL, NULL),
(4, 'exceeding_order_ranges_bounce', '100', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_areas`
--

CREATE TABLE `sub_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_areas`
--

INSERT INTO `sub_areas` (`id`, `area_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'دبي', NULL, '2022-12-15 21:12:41'),
(2, 1, 'العين', NULL, '2022-12-15 21:12:18'),
(3, 2, 'مبارك الكبير', NULL, '2022-12-15 21:02:48'),
(4, 2, 'العاصمة', NULL, '2022-12-15 21:02:01'),
(5, 1, 'عجمان', NULL, '2022-12-15 21:12:06'),
(6, 1, 'أبو ظبي', NULL, '2022-12-15 21:11:51'),
(7, 3, 'الدوحة', '2022-12-05 17:17:16', '2022-12-15 21:00:48'),
(8, 4, 'أبها', '2022-12-05 17:28:29', '2022-12-15 20:58:22'),
(9, 4, 'الرياض', '2022-12-05 17:35:15', '2022-12-05 17:35:15'),
(10, 4, 'جده', '2022-12-05 17:35:22', '2022-12-05 17:35:22'),
(11, 4, 'الطائف', '2022-12-05 17:35:32', '2022-12-15 20:58:35'),
(12, 5, 'ابوعريش', '2022-12-05 17:36:44', '2022-12-05 17:36:44'),
(13, 5, 'صبيا', '2022-12-15 20:48:52', '2022-12-15 20:48:52'),
(14, 5, 'جيزان', '2022-12-15 20:49:05', '2022-12-15 20:49:05'),
(15, 5, 'الحريضة', '2022-12-15 20:52:23', '2022-12-15 20:52:23'),
(16, 5, 'الدرب', '2022-12-15 20:52:30', '2022-12-15 20:52:30'),
(17, 5, 'بيش', '2022-12-15 20:52:34', '2022-12-15 20:52:34'),
(18, 5, 'ضمد', '2022-12-15 20:52:40', '2022-12-15 20:52:40'),
(19, 5, 'الشقيري', '2022-12-15 20:52:46', '2022-12-15 20:52:46'),
(20, 5, 'هروب', '2022-12-15 20:52:53', '2022-12-15 20:52:53'),
(21, 5, 'العارضة', '2022-12-15 20:52:59', '2022-12-15 20:52:59'),
(22, 5, 'أحد المسارحة', '2022-12-15 20:53:10', '2022-12-15 20:53:10'),
(23, 5, 'الطوال', '2022-12-15 20:53:14', '2022-12-15 20:53:14'),
(24, 5, 'صامطة', '2022-12-15 20:53:21', '2022-12-15 20:53:21'),
(25, 5, 'المضايا', '2022-12-15 20:53:26', '2022-12-15 20:53:26'),
(26, 5, 'الداير ', '2022-12-15 20:53:34', '2022-12-15 20:53:34'),
(27, 5, 'العيدابي', '2022-12-15 20:53:39', '2022-12-15 20:53:39'),
(28, 5, 'عيبان', '2022-12-15 20:53:44', '2022-12-15 20:53:44'),
(29, 2, 'الأحمدي', '2022-12-15 21:03:23', '2022-12-15 21:03:23'),
(30, 2, 'الجهراء', '2022-12-15 21:03:49', '2022-12-15 21:03:49'),
(31, 2, 'الفروانية', '2022-12-15 21:04:12', '2022-12-15 21:04:12'),
(32, 2, 'حولي', '2022-12-15 21:04:19', '2022-12-15 21:04:19'),
(33, 1, 'الفجرة', '2022-12-15 21:13:07', '2022-12-15 21:13:07'),
(34, 1, 'رأس الخيمة', '2022-12-15 21:13:22', '2022-12-15 21:13:22'),
(35, 1, 'الشارقة', '2022-12-15 21:13:32', '2022-12-15 21:13:32'),
(36, 1, 'ام القيوين', '2022-12-15 21:13:50', '2022-12-15 21:13:50'),
(37, 6, 'البلقاء', '2022-12-15 21:15:56', '2022-12-15 21:15:56'),
(38, 6, 'المفرق', '2022-12-15 21:16:03', '2022-12-15 21:16:03'),
(39, 6, 'عمان', '2022-12-15 21:16:11', '2022-12-15 21:16:11'),
(40, 6, 'العقبة', '2022-12-15 21:16:17', '2022-12-15 21:16:30'),
(41, 6, 'اربد', '2022-12-15 21:16:43', '2022-12-15 21:16:43'),
(42, 6, 'الكرك', '2022-12-15 21:16:50', '2022-12-15 21:16:50'),
(43, 6, 'معان', '2022-12-15 21:16:56', '2022-12-15 21:16:56'),
(44, 6, 'الزرقاء', '2022-12-15 21:17:03', '2022-12-15 21:17:03'),
(45, 6, 'طفيلة', '2022-12-15 21:17:11', '2022-12-15 21:17:11'),
(46, 6, 'مادبا', '2022-12-15 21:17:21', '2022-12-15 21:17:21'),
(47, 4, '002211', '2023-01-01 16:27:13', '2023-01-01 16:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trans_sn` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `representative_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` double NOT NULL,
  `transaction_type_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `trans_sn`, `user_id`, `client_id`, `representative_id`, `date`, `amount`, `transaction_type_id`, `created_at`, `updated_at`) VALUES
(1, 'TRANS-2023-0000', 1, NULL, 2, '2023-01-01 05:01:48', 10, 1, NULL, NULL),
(2, 'TRANS-2023-0001', 1, NULL, 2, '2023-01-01 05:01:20', 614, 1, NULL, NULL),
(3, 'TRANS-2023-0002', 1, NULL, 2, '2023-01-01 05:01:36', 10, 1, NULL, NULL),
(4, 'TRANS-2023-0003', 1, NULL, 2, '2023-01-01 05:01:51', 10, 1, NULL, NULL),
(5, 'TRANS-2023-0004', 1, NULL, 2, '2023-01-01 05:01:07', 1014, 1, NULL, NULL),
(6, 'TRANS-2023-0005', 1, NULL, 2, '2023-01-01 05:01:16', 537, 1, NULL, NULL),
(7, 'TRANS-2023-0006', 1, NULL, 8, '2023-01-01 07:01:22', 870, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions_types`
--

CREATE TABLE `transactions_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `is_fees_collection` tinyint(1) NOT NULL DEFAULT 0,
  `is_representative_payment` tinyint(1) NOT NULL DEFAULT 0,
  `is_client_payment` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions_types`
--

INSERT INTO `transactions_types` (`id`, `type`, `is_fees_collection`, `is_representative_payment`, `is_client_payment`, `created_at`, `updated_at`) VALUES
(1, 'fees_collection', 1, 0, 0, NULL, NULL),
(2, 'representative_payment', 0, 1, 0, NULL, NULL),
(3, 'client_payment', 0, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `photo` varchar(100) DEFAULT 'users_profile/user.png',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mohammed zahir', 'admin@gmail.com', NULL, '$2y$10$JKyj3Mh1aRbD0OmI3ys4/enjbS2zylUeLuCoXqwb3r/x5BcM.Fc7S', 'users_profile/user.png', 'mx4IHrhptzZq1OUivxxQTk8ubyvDTvK2DY93vzrP9WjX2V5WcJv5Wvh7flZX', '2022-11-27 16:26:54', '2022-11-27 16:26:54');

-- --------------------------------------------------------

--
-- Structure for view `orders_full_data`
--
DROP TABLE IF EXISTS `orders_full_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`gulfsmo`@`localhost` SQL SECURITY DEFINER VIEW `orders_full_data`  AS SELECT `orders`.`id` AS `id`, `orders`.`service_id` AS `service_id`, `orders`.`tracking_number` AS `tracking_number`, `orders`.`receipt_file` AS `receipt_file`, `orders`.`number_of_pieces` AS `number_of_pieces`, `orders`.`note` AS `note`, `orders`.`client_id` AS `client_id`, `orders`.`representative_id` AS `representative_id`, `orders`.`sender_name` AS `sender_name`, `orders`.`sender_phone` AS `sender_phone`, `orders`.`sender_area_id` AS `sender_area_id`, `orders`.`sender_sub_area_id` AS `sender_sub_area_id`, `orders`.`sender_address` AS `sender_address`, `orders`.`receiver_name` AS `receiver_name`, `orders`.`receiver_phone_no` AS `receiver_phone_no`, `orders`.`receiver_area_id` AS `receiver_area_id`, `orders`.`receiver_sub_area_id` AS `receiver_sub_area_id`, `orders`.`receiver_address` AS `receiver_address`, `orders`.`police_file` AS `police_file`, `orders`.`is_police_file_sent` AS `is_police_file_sent`, `orders`.`delivery_fees` AS `delivery_fees`, `orders`.`order_fees` AS `order_fees`, `orders`.`total_fees` AS `total_fees`, `orders`.`order_value` AS `order_value`, `orders`.`payment_method` AS `payment_method`, `orders`.`is_company_fees_collected` AS `is_company_fees_collected`, `orders`.`order_date` AS `order_date`, `orders`.`order_weight` AS `order_weight`, `orders`.`delivery_date` AS `delivery_date`, `orders`.`status` AS `status`, `orders`.`transaction_id` AS `transaction_id`, `orders`.`invoice_sn` AS `invoice_sn`, `orders`.`is_deleted` AS `is_deleted`, `orders`.`created_at` AS `created_at`, `orders`.`updated_at` AS `updated_at`, `clients`.`fullname` AS `client_name`, `representatives`.`fullname` AS `representative_name`, `services`.`name` AS `service_name`, `sender_area`.`name` AS `sender_area_name`, `sender_sub_area`.`name` AS `sender_sub_area_name`, `receiver_area`.`name` AS `receiver_area_name`, `receiver_sub_area`.`name` AS `receiver_sub_area_name` FROM (((((((`orders` left join `representatives` on(`representatives`.`id` = `orders`.`representative_id`)) left join `clients` on(`clients`.`id` = `orders`.`client_id`)) left join `services` on(`services`.`id` = `orders`.`service_id`)) left join `areas` `sender_area` on(`sender_area`.`id` = `orders`.`sender_area_id`)) left join `sub_areas` `sender_sub_area` on(`sender_sub_area`.`id` = `orders`.`sender_sub_area_id`)) left join `areas` `receiver_area` on(`receiver_area`.`id` = `orders`.`receiver_area_id`)) left join `sub_areas` `receiver_sub_area` on(`receiver_sub_area`.`id` = `orders`.`receiver_sub_area_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `representative_percentages_union_representative_per_days`
--
DROP TABLE IF EXISTS `representative_percentages_union_representative_per_days`;

CREATE ALGORITHM=UNDEFINED DEFINER=`gulfsmo_faster_dev`@`localhost` SQL SECURITY DEFINER VIEW `representative_percentages_union_representative_per_days`  AS SELECT `representative_orders_percentages`.`representative_id` AS `representative_id`, `representative_orders_percentages`.`deserve` AS `deserve`, `representative_orders_percentages`.`is_paid` AS `is_paid`, `representative_orders_percentages`.`payment_date` AS `payment_date`, `representative_orders_percentages`.`transaction_id` AS `transaction_id`, `representative_orders_percentages`.`created_at` AS `created_at`, `representative_orders_percentages`.`updated_at` AS `updated_at` FROM `representative_orders_percentages` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_price_histories`
--
ALTER TABLE `area_price_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_price_histories_area_id_foreign` (`area_id`);

--
-- Indexes for table `area_services`
--
ALTER TABLE `area_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_services_service_id_foreign` (`service_id`),
  ADD KEY `area_services_area_id_foreign` (`area_id`);

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
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_area_id_foreign` (`area_id`),
  ADD KEY `clients_sub_area_id_foreign` (`sub_area_id`);

--
-- Indexes for table `clients_files`
--
ALTER TABLE `clients_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients_tokens`
--
ALTER TABLE `clients_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_tokens_client_id_foreign` (`client_id`);

--
-- Indexes for table `client_service_prices`
--
ALTER TABLE `client_service_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_service_prices_client_id_foreign` (`client_id`),
  ADD KEY `client_service_prices_service_id_foreign` (`service_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fire_base_notification_histories`
--
ALTER TABLE `fire_base_notification_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issue_client_statements`
--
ALTER TABLE `issue_client_statements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_client_statements_client_id_foreign` (`client_id`);

--
-- Indexes for table `issue_photos`
--
ALTER TABLE `issue_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_photos_issue_foreign` (`issue`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_service_id_foreign` (`service_id`),
  ADD KEY `orders_client_id_foreign` (`client_id`),
  ADD KEY `orders_representative_id_foreign` (`representative_id`),
  ADD KEY `orders_sender_area_id_foreign` (`sender_area_id`),
  ADD KEY `orders_sender_sub_area_id_foreign` (`sender_sub_area_id`),
  ADD KEY `orders_receiver_area_id_foreign` (`receiver_area_id`),
  ADD KEY `orders_receiver_sub_area_id_foreign` (`receiver_sub_area_id`),
  ADD KEY `orders_transaction_id_foreign` (`transaction_id`),
  ADD KEY `orders_client_payment_transaction_id_foreign` (`client_payment_transaction_id`);

--
-- Indexes for table `order_ranges`
--
ALTER TABLE `order_ranges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_trackings`
--
ALTER TABLE `order_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_trackings_order_id_foreign` (`order_id`);

--
-- Indexes for table `organization_profiles`
--
ALTER TABLE `organization_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `representatives`
--
ALTER TABLE `representatives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representatives_area_id_foreign` (`area_id`),
  ADD KEY `representatives_sub_area_id_foreign` (`sub_area_id`);

--
-- Indexes for table `representative_areas`
--
ALTER TABLE `representative_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representative_areas_representative_id_foreign` (`representative_id`),
  ADD KEY `representative_areas_area_id_foreign` (`area_id`),
  ADD KEY `representative_areas_subarea_id_foreign` (`subarea_id`);

--
-- Indexes for table `representative_orders_percentages`
--
ALTER TABLE `representative_orders_percentages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representative_orders_percentages_representative_id_foreign` (`representative_id`),
  ADD KEY `representative_orders_percentages_order_id_foreign` (`order_id`),
  ADD KEY `representative_orders_percentages_transaction_id_foreign` (`transaction_id`);

--
-- Indexes for table `representative_orders_per_days`
--
ALTER TABLE `representative_orders_per_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representative_orders_per_days_representative_id_foreign` (`representative_id`),
  ADD KEY `representative_orders_per_days_transaction_id_foreign` (`transaction_id`);

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
-- Indexes for table `serial_settings`
--
ALTER TABLE `serial_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_notes`
--
ALTER TABLE `service_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_notes_service_id_foreign` (`service_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_areas`
--
ALTER TABLE `sub_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_areas_area_id_foreign` (`area_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_client_id_foreign` (`client_id`),
  ADD KEY `transactions_representative_id_foreign` (`representative_id`),
  ADD KEY `transactions_transaction_type_id_foreign` (`transaction_type_id`);

--
-- Indexes for table `transactions_types`
--
ALTER TABLE `transactions_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `area_price_histories`
--
ALTER TABLE `area_price_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `area_services`
--
ALTER TABLE `area_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `clients_files`
--
ALTER TABLE `clients_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients_tokens`
--
ALTER TABLE `clients_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_service_prices`
--
ALTER TABLE `client_service_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fire_base_notification_histories`
--
ALTER TABLE `fire_base_notification_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_client_statements`
--
ALTER TABLE `issue_client_statements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `issue_photos`
--
ALTER TABLE `issue_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `order_ranges`
--
ALTER TABLE `order_ranges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_trackings`
--
ALTER TABLE `order_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `organization_profiles`
--
ALTER TABLE `organization_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `representatives`
--
ALTER TABLE `representatives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `representative_areas`
--
ALTER TABLE `representative_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `representative_orders_percentages`
--
ALTER TABLE `representative_orders_percentages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `representative_orders_per_days`
--
ALTER TABLE `representative_orders_per_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `serial_settings`
--
ALTER TABLE `serial_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_notes`
--
ALTER TABLE `service_notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_areas`
--
ALTER TABLE `sub_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transactions_types`
--
ALTER TABLE `transactions_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area_price_histories`
--
ALTER TABLE `area_price_histories`
  ADD CONSTRAINT `area_price_histories_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Constraints for table `area_services`
--
ALTER TABLE `area_services`
  ADD CONSTRAINT `area_services_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `area_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `clients_sub_area_id_foreign` FOREIGN KEY (`sub_area_id`) REFERENCES `sub_areas` (`id`);

--
-- Constraints for table `clients_tokens`
--
ALTER TABLE `clients_tokens`
  ADD CONSTRAINT `clients_tokens_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `client_service_prices`
--
ALTER TABLE `client_service_prices`
  ADD CONSTRAINT `client_service_prices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `client_service_prices_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `issue_client_statements`
--
ALTER TABLE `issue_client_statements`
  ADD CONSTRAINT `issue_client_statements_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `issue_photos`
--
ALTER TABLE `issue_photos`
  ADD CONSTRAINT `issue_photos_issue_foreign` FOREIGN KEY (`issue`) REFERENCES `issue_client_statements` (`id`);

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `orders_client_payment_transaction_id_foreign` FOREIGN KEY (`client_payment_transaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `orders_receiver_area_id_foreign` FOREIGN KEY (`receiver_area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `orders_receiver_sub_area_id_foreign` FOREIGN KEY (`receiver_sub_area_id`) REFERENCES `sub_areas` (`id`),
  ADD CONSTRAINT `orders_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`),
  ADD CONSTRAINT `orders_sender_area_id_foreign` FOREIGN KEY (`sender_area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `orders_sender_sub_area_id_foreign` FOREIGN KEY (`sender_sub_area_id`) REFERENCES `sub_areas` (`id`),
  ADD CONSTRAINT `orders_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `orders_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `order_trackings`
--
ALTER TABLE `order_trackings`
  ADD CONSTRAINT `order_trackings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `representatives`
--
ALTER TABLE `representatives`
  ADD CONSTRAINT `representatives_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `representatives_sub_area_id_foreign` FOREIGN KEY (`sub_area_id`) REFERENCES `sub_areas` (`id`);

--
-- Constraints for table `representative_areas`
--
ALTER TABLE `representative_areas`
  ADD CONSTRAINT `representative_areas_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `representative_areas_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`),
  ADD CONSTRAINT `representative_areas_subarea_id_foreign` FOREIGN KEY (`subarea_id`) REFERENCES `sub_areas` (`id`);

--
-- Constraints for table `representative_orders_percentages`
--
ALTER TABLE `representative_orders_percentages`
  ADD CONSTRAINT `representative_orders_percentages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `representative_orders_percentages_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`),
  ADD CONSTRAINT `representative_orders_percentages_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `representative_orders_per_days`
--
ALTER TABLE `representative_orders_per_days`
  ADD CONSTRAINT `representative_orders_per_days_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`),
  ADD CONSTRAINT `representative_orders_per_days_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_notes`
--
ALTER TABLE `service_notes`
  ADD CONSTRAINT `service_notes_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

--
-- Constraints for table `sub_areas`
--
ALTER TABLE `sub_areas`
  ADD CONSTRAINT `sub_areas_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `transactions_representative_id_foreign` FOREIGN KEY (`representative_id`) REFERENCES `representatives` (`id`),
  ADD CONSTRAINT `transactions_transaction_type_id_foreign` FOREIGN KEY (`transaction_type_id`) REFERENCES `transactions_types` (`id`),
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
