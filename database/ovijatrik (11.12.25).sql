-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 04:27 PM
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
-- Database: `ovijatrik`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_debit_credit_ledger` (IN `transType` DECIMAL(1,0), IN `projectID` DECIMAL(8,0), IN `transAmount` DECIMAL(25,2), IN `added_on` DATETIME, IN `added_by` INT, IN `ip` VARCHAR(50))  DETERMINISTIC BEGIN

DECLARE v_ledger  DECIMAL(3);

SET v_ledger = NULL;

SELECT ledger_id INTO v_ledger FROM debit_credit_ledger WHERE project_id = projectID;

	IF v_ledger IS NOT NULL THEN 
	
		IF transType = -1 OR transType = -2 OR transType = -3 THEN
		  UPDATE debit_credit_ledger SET ledger_amount = ledger_amount - transAmount
		  WHERE ledger_id = v_ledger;
		
		ELSEIF transType = 1 OR transType = 2 OR transType = 3 THEN	
			UPDATE debit_credit_ledger SET ledger_amount = ledger_amount + transAmount
			WHERE ledger_id = v_ledger;

		END IF;
	ELSE
		INSERT INTO debit_credit_ledger(project_id,ledger_amount,ledger_added_on,ledger_added_by,ledger_edited_on,ledger_edited_by,operation_ip) 
		VALUES(projectID,transAmount,added_on,added_by,NULL,NULL,ip);
	END IF;
	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `about_bn` text DEFAULT NULL,
  `about_img` varchar(191) DEFAULT NULL,
  `banner_img` varchar(190) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `message_bn` text DEFAULT NULL,
  `message_img` varchar(191) DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `mission_bn` text DEFAULT NULL,
  `mission_img` varchar(191) DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `vision_bn` text DEFAULT NULL,
  `vision_img` varchar(191) DEFAULT NULL,
  `history` text DEFAULT NULL,
  `history_img` varchar(191) DEFAULT NULL,
  `why_choose` text DEFAULT NULL,
  `why_choose_img` varchar(191) DEFAULT NULL,
  `why_best` text DEFAULT NULL,
  `why_best_img` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `email_2` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `mobile_2` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `address_2` varchar(191) DEFAULT NULL,
  `working_hour` varchar(150) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `logo_dark` varchar(255) DEFAULT NULL,
  `facebook` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `instagram` varchar(191) DEFAULT NULL,
  `linkedin` varchar(191) DEFAULT NULL,
  `satisfactions` varchar(191) DEFAULT NULL,
  `projects` varchar(191) DEFAULT NULL,
  `visitors` varchar(191) DEFAULT NULL,
  `happy_clients` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>active, 0=>inactive',
  `created_by` bigint(20) NOT NULL DEFAULT 1,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `title`, `about`, `about_bn`, `about_img`, `banner_img`, `message`, `message_bn`, `message_img`, `mission`, `mission_bn`, `mission_img`, `vision`, `vision_bn`, `vision_img`, `history`, `history_img`, `why_choose`, `why_choose_img`, `why_best`, `why_best_img`, `email`, `email_2`, `mobile`, `mobile_2`, `address`, `address_2`, `working_hour`, `logo`, `logo_dark`, `facebook`, `twitter`, `instagram`, `linkedin`, `satisfactions`, `projects`, `visitors`, `happy_clients`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Ovijatrik', 'Ovijatrik Foundation has been working since 2005 to improve the quality of life for underprivileged people in society. Our core goal is to create opportunities for education, healthcare, and livelihood. We believe that a better and more equitable society can be built only through collective effort. Over the last two decades, we have provided support to thousands of families and brought positive changes to their lives.', 'অভিযাত্রিক ফাউন্ডেশন ২০০৫ সাল থেকে সমাজের সুবিধা-বঞ্চিত মানুষের জীবনযাত্রার মান উন্নয়নে কাজ করে চলেছে। শিক্ষা, স্বাস্থ্যসেবা এবং জীবিকা অর্জনের সুযোগ সৃষ্টি করাই আমাদের মূল লক্ষ্য। আমাদের বিশ্বাস, সম্মিলিত প্রচেষ্টার মাধ্যমেই একটি উন্নত ও সমতাপূর্ণ সমাজ গঠন করা সম্ভব। গত দুই দশকে আমরা হাজার হাজার পরিবারকে সহায়তা প্রদান করেছি এবং তাদের জীবনে ইতিবাচক পরিবর্তন এনেছি।', NULL, 'uploads/abouts/banner-img-2023-01-28.jpg', 'Earlier we specialized in Image clipping path/portrait photo editing in Photoshop and offered only basic image retouching services. Today we provide the widest range of professional online retouching services of the highest level. Our retouchers make any kind of Photoshop work for all photography genres and of any level of complexity. Our mission is to offer fast, affordable, secure, and high-quality photo retouching help for beginning and professional Online sellers/photographers/ who can’t or don’t have time to do image editing on their own.', 'আমি গভীরভাবে বিশ্বাস করি যে, সামান্য সহানুভূতিও বহু মানুষের জীবন পাল্টে দিতে পারে। আসুন আমরা সবাই মিলে এই মহান উদ্যোগে শামিল হই এবং আগামী প্রজন্মের জন্য একটি উজ্জ্বল ভবিষ্যৎ তৈরি করি। আপনার ছোট একটি দানও এনে দিতে পারে বিশাল পরিবর্তন।', 'founderImg-20251028-62.jpg', 'OUR mission is to ensure the basic rights of every individual: providing access to quality education, good health, and opportunities for self-reliance. We specifically focus on the empowerment of women and children so that they can become leaders for their own and their community\'s future.', 'আমাদের লক্ষ্য হলো প্রতিটি ব্যক্তির মৌলিক অধিকার নিশ্চিত করা: মানসম্মত শিক্ষা, সুস্বাস্থ্য এবং স্বনির্ভরতার সুযোগ প্রদান। আমরা বিশেষভাবে নারী ও শিশুদের ক্ষমতায়নের উপর জোর দিই যাতে তারা নিজেদের এবং তাদের সম্প্রদায়ের ভবিষ্যতের জন্য নেতা হতে পারে।', NULL, 'A World free from poverty, illiteracy, and discrimination; where every child gets the opportunity to dream and fulfill it. We are committed to building a sustainable and humane society where compassion is the guiding principle of our journey.', 'দারিদ্র্য, নিরক্ষরতা এবং বৈষম্যমুক্ত একটি পৃথিবী; যেখানে প্রতিটি শিশু স্বপ্ন দেখার এবং তা পূরণ করার সুযোগ পাবে। আমরা একটি টেকসই এবং মানবিক সমাজ গড়ে তুলতে প্রতিশ্রুতিবদ্ধ যেখানে করুণা আমাদের যাত্রার পথপ্রদর্শক নীতি।', NULL, '<font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">Advance Retouch</font> Company History page.', 'uploads/abouts/history-img-2023-01-19.png', NULL, NULL, NULL, NULL, 'info@ovijatrik.com', 'rimonitsolution@gmail.com', '01707335090', '01925335090', 'Tambulpur Bazar,&nbsp;Pirgachha,&nbsp;Rangpur, Bangladesh.', NULL, '<p>24 Hours 7 Days</p>', 'uploads/abouts/light_1764350180.png', 'uploads/abouts/dark_1764692435.png', 'www.facebook.com/ovijatrik', 'www.twitter.com/advanceretoucher', 'www.instagram.com/advanceretoucher', 'www.linkedin.com/ovijatrik', '7', '521', '1463', '380', 1, 2, 1, '2022-04-09 09:56:48', '2025-12-02 10:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` decimal(3,0) NOT NULL,
  `account_name` varchar(75) NOT NULL,
  `account_no` varchar(75) DEFAULT NULL,
  `account_type` decimal(1,0) NOT NULL,
  `bank_name` varchar(75) DEFAULT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 1,
  `current_balance` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_name`, `account_no`, `account_type`, `bank_name`, `status`, `current_balance`) VALUES
(101, 'Cash', '', 2, NULL, 1, 19000.00),
(102, 'Rocket', '01707832654', 2, NULL, 1, 0.00),
(103, 'Bkash', '01521313200', 2, 'Bkash', 1, 3000.00),
(104, 'Nagad', '01970717892', 2, 'Nagad', 1, 0.00),
(105, 'Islami Bank', '20502676552207816', 2, 'Islami Bank', 1, 40000.00),
(106, 'Cash', '', 1, NULL, 1, 27500.00),
(107, 'Bkash', '01521313200', 1, 'Bkash', 1, 3500.00);

--
-- Triggers `accounts`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_account_id` BEFORE INSERT ON `accounts` FOR EACH ROW BEGIN
DECLARE max_id 	  DECIMAL(3);
SELECT MAX(account_id) INTO max_id FROM accounts;
 IF max_id IS NOT NULL THEN
  SET NEW.account_id = max_id+1;
 ELSE
 SET NEW.account_id = 101;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` decimal(3,0) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_name_bn` varchar(100) DEFAULT NULL,
  `category_type` decimal(1,0) NOT NULL DEFAULT 1 COMMENT '1- Main Category, 2- Expense Category',
  `status` decimal(1,0) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_name_bn`, `category_type`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(101, 'Medical care', 'চিকিৎসা সেবা ', 1, 1, 1, '2024-05-27 22:52:19', NULL, NULL, '::1'),
(102, 'Religious Activities', 'ধর্মীয় কার্যক্রম', 1, 1, 1, '2024-05-27 22:52:36', 1, NULL, '::1'),
(103, 'Tube Well', 'নলকূপ', 1, 1, 1, '2024-05-27 22:53:02', 1, NULL, '::1'),
(104, 'General', 'সাধারন', 1, 1, 1, '2025-10-03 20:27:50', 1, NULL, '::1'),
(105, 'Loan', 'লোন', 1, 1, 1, '2025-12-03 20:56:18', NULL, NULL, '::1');

--
-- Triggers `categories`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_category_id` BEFORE INSERT ON `categories` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(3);
SELECT MAX(category_id) INTO max_id FROM categories;
 IF max_id IS NOT NULL THEN
  SET NEW.category_id = max_id+1;
 ELSE
 SET NEW.category_id = 101;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `subject` text DEFAULT NULL,
  `message` longtext NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>active, 0=>inactive',
  `created_by` bigint(20) NOT NULL DEFAULT 1,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `debit_credit_ledger`
--

CREATE TABLE `debit_credit_ledger` (
  `ledger_id` decimal(3,0) NOT NULL COMMENT 'Primary Key - 3 Digit Number (NNN)',
  `project_id` decimal(8,0) DEFAULT NULL,
  `account_id` decimal(3,0) DEFAULT 101,
  `ledger_amount` decimal(25,2) DEFAULT 0.00,
  `ledger_added_on` datetime NOT NULL,
  `ledger_added_by` int(11) NOT NULL DEFAULT 0,
  `ledger_edited_on` datetime DEFAULT NULL,
  `ledger_edited_by` int(11) DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `debit_credit_ledger`
--

INSERT INTO `debit_credit_ledger` (`ledger_id`, `project_id`, `account_id`, `ledger_amount`, `ledger_added_on`, `ledger_added_by`, `ledger_edited_on`, `ledger_edited_by`, `operation_ip`) VALUES
(101, 10000001, 101, 31000.00, '2025-12-06 18:52:51', 1, NULL, NULL, '127.0.0.1'),
(102, 10000002, 101, 14000.00, '2025-12-06 18:54:51', 1, NULL, NULL, '::1'),
(103, 10000006, 101, 1000.00, '2025-12-06 18:55:23', 1, NULL, NULL, '::1'),
(104, 10000005, 101, 35000.00, '2025-12-09 15:59:27', 1, NULL, NULL, '::1'),
(105, 10000008, 101, 0.00, '2025-12-09 17:04:14', 1, NULL, NULL, '::1'),
(106, 10000009, 101, 12000.00, '2025-12-09 18:04:16', 1, NULL, NULL, '::1');

--
-- Triggers `debit_credit_ledger`
--
DELIMITER $$
CREATE TRIGGER `debit_credit_ledger_before_insert_trigger` BEFORE INSERT ON `debit_credit_ledger` FOR EACH ROW BEGIN
DECLARE  max_id  decimal(3);
select max(ledger_id) into max_id from debit_credit_ledger;
if  max_id is not null then
	set new.ledger_id = max_id+1;
else
	set new.ledger_id =101;
end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) UNSIGNED NOT NULL,
  `emp_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `salary` decimal(12,2) NOT NULL DEFAULT 0.00,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_no`, `name`, `phone_no`, `email`, `designation`, `department`, `join_date`, `salary`, `bank_name`, `bank_account`, `address`, `photo`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(3, 'OV101', 'Arif Islam', '01752458645', 'arif@ovijatrik.org', 'Founder', 'Head', '2025-10-01', 50000.00, NULL, NULL, 'dfgfhfh', NULL, 1, '2025-10-21 17:48:26', 1, '2025-10-23 16:32:43', 1),
(4, 'OV102', 'Sakib All', '01521320230', 'sakib@gmail.com', 'Accountant', 'HQ', '2025-10-01', 25000.00, NULL, NULL, 'dinajpur', NULL, 1, '2025-11-26 15:56:07', 1, '2025-11-26 15:56:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL COMMENT 'Primary Key -  Digit Number (N)',
  `expense_no` varchar(50) NOT NULL COMMENT 'Auto Generate',
  `expense_type` decimal(1,0) DEFAULT NULL COMMENT '1 - Project Expense, 2- Others Expense',
  `expense_cat_id` int(11) DEFAULT NULL,
  `fiscal_year` varchar(20) DEFAULT NULL,
  `account_id` decimal(3,0) NOT NULL,
  `project_id` decimal(8,0) DEFAULT NULL,
  `expense_date` date DEFAULT NULL,
  `expense_remarks` mediumtext DEFAULT NULL,
  `expense_amount` decimal(25,2) NOT NULL DEFAULT 0.00,
  `receiver_name` varchar(255) DEFAULT NULL,
  `pay_method_id` decimal(3,0) DEFAULT 101,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `mobile_account_no` varchar(15) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `transaction_no` varchar(100) DEFAULT NULL,
  `status` decimal(1,0) DEFAULT 0,
  `decline_remarks` mediumtext DEFAULT NULL,
  `expense_added_on` datetime DEFAULT current_timestamp(),
  `expense_added_by` int(11) DEFAULT NULL,
  `expense_edited_by` int(11) DEFAULT NULL,
  `expense_edited_on` timestamp NULL DEFAULT NULL,
  `operation_ip` varchar(50) DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_no`, `expense_type`, `expense_cat_id`, `fiscal_year`, `account_id`, `project_id`, `expense_date`, `expense_remarks`, `expense_amount`, `receiver_name`, `pay_method_id`, `bank_account_no`, `mobile_account_no`, `bank_name`, `transaction_no`, `status`, `decline_remarks`, `expense_added_on`, `expense_added_by`, `expense_edited_by`, `expense_edited_on`, `operation_ip`) VALUES
(43, 'OVPEXP-2512001', 1, NULL, '2025-2026', 103, 10000006, '2025-12-04', NULL, 4000.00, 'Self', 101, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-07 00:58:42', 1, NULL, NULL, '::1'),
(44, 'OVPEXP-2512002', 1, NULL, '2025-2026', 103, 10000002, '2025-12-06', NULL, 5000.00, 'rimon', 101, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-07 01:01:09', 1, NULL, NULL, '::1'),
(45, 'OVJEXP-2512001', 2, 1, '2025-2026', 107, 10000001, '2025-12-06', NULL, 500.00, NULL, 102, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-07 01:01:53', 1, NULL, NULL, '::1'),
(46, 'OVPEXP-2512003', 1, NULL, '2025-2026', 103, 10000005, '2025-12-09', NULL, 5000.00, 'Self', 102, NULL, '0152131200', NULL, 'tdf6565', 1, NULL, '2025-12-09 22:01:35', 1, NULL, NULL, '::1'),
(47, 'OVPEXP-2512004', 1, NULL, '2025-2026', 103, 10000008, '2025-12-09', NULL, 7000.00, 'Self', 102, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-09 23:20:37', 1, NULL, NULL, '::1'),
(48, 'OVPEXP-2512005', 1, NULL, '2025-2026', 102, 10000009, '2025-12-10', NULL, 3000.00, 'Self', 104, NULL, NULL, NULL, NULL, 1, NULL, '2025-12-10 00:05:31', 1, NULL, NULL, '::1'),
(49, 'OVJEXP-2512002', 2, 1, '2025-2026', 107, 10000001, '2025-12-09', 'test', 1000.00, NULL, 102, NULL, '01521313200', NULL, 'dfgfd46546', 1, NULL, '2025-12-10 09:26:17', 1, NULL, NULL, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `expense_cat_id` int(11) NOT NULL COMMENT 'Primary Key - 5 Digit Number (NNNNN)',
  `expense_cat_name` varchar(255) NOT NULL,
  `expense_cat_name_bn` varchar(255) DEFAULT NULL,
  `status` decimal(1,0) DEFAULT 0,
  `expense_cat_added_on` datetime DEFAULT current_timestamp(),
  `expense_cat_added_by` int(11) DEFAULT NULL,
  `expense_cat_edited_by` int(11) DEFAULT NULL,
  `expense_cat_edited_on` timestamp NULL DEFAULT NULL,
  `operation_ip` varchar(50) DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`expense_cat_id`, `expense_cat_name`, `expense_cat_name_bn`, `status`, `expense_cat_added_on`, `expense_cat_added_by`, `expense_cat_edited_by`, `expense_cat_edited_on`, `operation_ip`) VALUES
(1, 'Electricity Bill', NULL, 1, '2024-12-16 19:22:26', 1, NULL, NULL, '103.83.232.22'),
(2, 'Shop Rent', NULL, 1, '2024-12-16 19:22:43', 1, NULL, NULL, '103.83.232.22'),
(3, 'Carrying Cost', NULL, 1, '2024-12-16 19:22:56', 1, NULL, NULL, '103.83.232.22'),
(4, 'Wifi Bill', NULL, 1, '2024-12-16 19:23:17', 1, NULL, NULL, '103.83.232.22'),
(5, 'Mobile Bill', NULL, 1, '2024-12-16 19:23:28', 1, NULL, NULL, '103.83.232.22'),
(6, 'Tea Bill', NULL, 1, '2024-12-16 19:23:39', 1, NULL, NULL, '103.83.232.22'),
(7, 'Others', NULL, 1, '2024-12-16 19:23:48', 1, NULL, NULL, '103.83.232.22');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `false_receipts`
--

CREATE TABLE `false_receipts` (
  `fls_receipt_id` int(11) NOT NULL COMMENT 'Primary Key -  Digit Number (N)',
  `fls_receipt_no` varchar(20) NOT NULL COMMENT 'Auto Generate',
  `fiscal_year` varchar(20) DEFAULT NULL,
  `account_id` decimal(3,0) NOT NULL,
  `project_id` decimal(8,0) DEFAULT NULL,
  `fls_receipt_date` date DEFAULT NULL,
  `donar_name` varchar(255) DEFAULT NULL,
  `pay_method_id` decimal(3,0) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `mobile_account_no` varchar(15) DEFAULT NULL,
  `transaction_no` varchar(100) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `fls_receipt_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `posting_type` decimal(1,0) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operation_ip` varchar(50) DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `false_receipts`
--

INSERT INTO `false_receipts` (`fls_receipt_id`, `fls_receipt_no`, `fiscal_year`, `account_id`, `project_id`, `fls_receipt_date`, `donar_name`, `pay_method_id`, `bank_account_no`, `bank_name`, `mobile_account_no`, `transaction_no`, `remarks`, `fls_receipt_amount`, `posting_type`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(11, 'OVJDR1125002', '2025-2026', 102, 10000002, '2025-11-27', 'rimom', 104, NULL, NULL, '01521313200', 'dfgfd46546', 'test', 2500.00, 1, 1, '2025-11-28 11:30:27', 1, '2025-11-28 00:24:10', '127.0.0.1'),
(12, 'OVJDR2512001', '2025-2026', 104, 10000006, '2025-12-01', 'Rimon', 103, NULL, NULL, '01521313200', NULL, NULL, 1500.00, 1, 1, '2025-12-01 23:38:45', NULL, NULL, '127.0.0.1'),
(13, 'OVJDR1225002', '2025-2026', 103, 10000006, '2025-12-06', 'Asha', 102, NULL, NULL, '01521313200', NULL, NULL, 50000.00, 1, 1, '2025-12-06 22:40:46', NULL, NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `fiscal_years`
--

CREATE TABLE `fiscal_years` (
  `fiscal_year_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fiscal_years`
--

INSERT INTO `fiscal_years` (`fiscal_year_id`, `name`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, '2025-2026', '2025-07-01', '2026-06-30', 1, '2025-08-02 15:55:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` decimal(3,0) NOT NULL COMMENT 'Foreign Key- categories: category_id',
  `caption` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `order_list` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>active, 0=>inactive',
  `created_by` bigint(20) NOT NULL DEFAULT 1,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `category_id`, `caption`, `image`, `order_list`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 101, 'test 1', 'uploads/galleries/gallery-20250719-860.png', NULL, 0, 1, NULL, '2025-07-19 11:11:41', '2025-07-19 11:11:41'),
(3, 101, 'test 3', 'uploads/galleries/gallery-20250719-869.jpeg', NULL, 0, 1, NULL, '2025-07-19 11:12:02', '2025-07-19 11:12:02'),
(4, 103, 'test 4', 'uploads/galleries/gallery-20250719-603.jpg', NULL, 1, 1, 1, '2025-07-19 11:13:32', '2025-08-12 11:51:54'),
(5, 102, 'gallery 5', 'uploads/galleries/gallery-20250722-607.png', NULL, 1, 1, 1, '2025-07-22 12:04:58', '2025-08-12 11:51:46'),
(6, 102, 'test', 'uploads/galleries/gallery-20250812-608.png', NULL, 1, 1, 1, '2025-08-12 11:57:30', '2025-09-01 11:24:18'),
(8, 102, 'test 123', 'uploads/galleries/gallery-20250831-826.jpg', NULL, 1, 1, 1, '2025-08-31 12:44:07', '2025-09-01 09:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `loan_accounts`
--

CREATE TABLE `loan_accounts` (
  `loan_account_id` decimal(2,0) NOT NULL,
  `account_name` varchar(75) NOT NULL,
  `account_no` varchar(75) DEFAULT NULL,
  `account_type` decimal(1,0) NOT NULL,
  `bank_name` varchar(75) DEFAULT NULL,
  `project_id` decimal(8,0) DEFAULT NULL,
  `opening_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `current_balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` decimal(1,0) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_accounts`
--

INSERT INTO `loan_accounts` (`loan_account_id`, `account_name`, `account_no`, `account_type`, `bank_name`, `project_id`, `opening_balance`, `current_balance`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(11, 'Cash', '', 1, NULL, NULL, 0.00, 0.00, 1, 0, '2025-12-03 22:17:00', NULL, NULL, '::1'),
(12, 'Ovijatrik Bkash', '01970717892', 2, 'Bkash', 10000007, 100000.00, 80000.00, 1, 1, '2025-12-03 17:43:07', NULL, '2025-12-05 16:28:09', '::1');

--
-- Triggers `loan_accounts`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_loan_account_id` BEFORE INSERT ON `loan_accounts` FOR EACH ROW BEGIN
DECLARE max_id 	  DECIMAL(2);
SELECT MAX(loan_account_id) INTO max_id FROM loan_accounts;
 IF max_id IS NOT NULL THEN
  SET NEW.loan_account_id = max_id+1;
 ELSE
 SET NEW.loan_account_id = 11;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `loan_transactions`
--

CREATE TABLE `loan_transactions` (
  `loan_transactions_id` decimal(6,0) NOT NULL,
  `loan_transaction_no` varchar(50) NOT NULL COMMENT 'Auto Generate',
  `fiscal_year` varchar(20) DEFAULT NULL,
  `loan_project` decimal(8,0) DEFAULT NULL,
  `loan_account_id` decimal(2,0) DEFAULT NULL,
  `loan_date` date NOT NULL,
  `loan_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `loan_remarks` varchar(255) DEFAULT NULL,
  `decline_remarks` varchar(255) DEFAULT NULL,
  `loan_status` decimal(1,0) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_transactions`
--

INSERT INTO `loan_transactions` (`loan_transactions_id`, `loan_transaction_no`, `fiscal_year`, `loan_project`, `loan_account_id`, `loan_date`, `loan_amount`, `loan_remarks`, `decline_remarks`, `loan_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(100001, 'LOAN-2512001', '2025-2026', 10000001, 12, '2025-12-05', 6000.00, 'test', NULL, 1, 1, '2025-12-05 17:18:36', 1, '2025-12-05 17:18:36', '::1'),
(100002, 'LOAN-2512002', '2025-2026', 10000003, 12, '2025-12-05', 3000.00, 'test', NULL, 1, 1, '2025-12-05 22:45:01', 1, '2025-12-05 22:45:01', '::1'),
(100003, 'LOAN-2512003', '2025-2026', 10000006, 12, '2025-12-05', 5000.00, 'for bkash', NULL, 1, 1, '2025-12-05 22:54:13', NULL, '2025-12-05 22:54:13', '::1');

--
-- Triggers `loan_transactions`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_loan_transactions_id` BEFORE INSERT ON `loan_transactions` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(6);
SELECT MAX(loan_transactions_id) INTO max_id FROM loan_transactions;
 IF max_id IS NOT NULL THEN
  SET NEW.loan_transactions_id = max_id+1;
 ELSE
 SET NEW.loan_transactions_id = 100001;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_08_02_155118_create_fiscal_years_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `money_receipts`
--

CREATE TABLE `money_receipts` (
  `mr_id` decimal(10,0) NOT NULL,
  `mr_no` varchar(50) NOT NULL COMMENT 'Auto Generate',
  `category_id` decimal(3,0) DEFAULT NULL,
  `sub_cat_id` decimal(4,0) DEFAULT NULL,
  `receipt_type` decimal(1,0) NOT NULL COMMENT '1 = Member Collection, 2 = Others Collection',
  `fiscal_year` varchar(20) DEFAULT NULL,
  `month_id` varchar(10) DEFAULT NULL,
  `project_id` decimal(8,0) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `donar_name` varchar(255) DEFAULT NULL,
  `donar_reference` varchar(100) DEFAULT NULL,
  `account_id` decimal(3,0) DEFAULT 101,
  `selected_months` text DEFAULT NULL,
  `pay_method_id` decimal(3,0) DEFAULT NULL,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `mobile_account_no` varchar(15) DEFAULT NULL,
  `transaction_no` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment_remarks` varchar(255) DEFAULT NULL,
  `decline_remarks` varchar(255) DEFAULT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 0 COMMENT '0 - Pending, 1 - Approved, -1 - Declined',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `money_receipts`
--

INSERT INTO `money_receipts` (`mr_id`, `mr_no`, `category_id`, `sub_cat_id`, `receipt_type`, `fiscal_year`, `month_id`, `project_id`, `member_id`, `donar_name`, `donar_reference`, `account_id`, `selected_months`, `pay_method_id`, `bank_account_no`, `mobile_account_no`, `transaction_no`, `bank_name`, `payment_date`, `payment_amount`, `payment_remarks`, `decline_remarks`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(1000000001, 'OVJMD-2512001', NULL, NULL, 1, '2025-2026', NULL, 10000001, 15, NULL, NULL, 106, '[\"2025-07\",\"2025-08\"]', 101, NULL, NULL, NULL, NULL, '2025-12-01', 30000.00, NULL, NULL, 1, 1, '2025-12-07 00:52:51', NULL, NULL, '::1'),
(1000000002, 'OVJMD-2512002', NULL, NULL, 1, '2025-2026', NULL, 10000001, 8, NULL, NULL, 107, '[\"2025-07\"]', 102, NULL, '01521313200', NULL, NULL, '2025-12-02', 2500.00, NULL, NULL, 1, 1, '2025-12-07 00:54:13', NULL, NULL, '::1'),
(1000000003, 'OVJMR-2512001', NULL, NULL, 2, '2025-2026', NULL, 10000002, NULL, 'Rimon', NULL, 101, NULL, 101, NULL, NULL, NULL, NULL, '2025-12-01', 4000.00, NULL, NULL, 1, 1, '2025-12-07 00:54:51', NULL, NULL, '::1'),
(1000000004, 'OVJMR-2512002', NULL, NULL, 2, '2025-2026', NULL, 10000006, NULL, 'Nisa', NULL, 103, NULL, 102, NULL, NULL, NULL, NULL, '2025-12-03', 5000.00, NULL, NULL, 1, 1, '2025-12-07 00:55:23', NULL, NULL, '::1'),
(1000000005, 'OVJMR-2512003', NULL, NULL, 2, '2025-2026', NULL, 10000002, NULL, 'Hasan', NULL, 103, NULL, 102, NULL, NULL, NULL, NULL, '2025-12-04', 15000.00, NULL, NULL, 1, 1, '2025-12-07 00:56:15', NULL, NULL, '::1'),
(1000000006, 'OVJMR-2512004', NULL, NULL, 2, '2025-2026', NULL, 10000005, NULL, 'Aklak', NULL, 105, NULL, 105, NULL, NULL, NULL, NULL, '2025-12-08', 40000.00, NULL, NULL, 1, 1, '2025-12-09 21:59:27', NULL, NULL, '::1'),
(1000000007, 'OVJMD-2512003', NULL, NULL, 1, '2025-2026', NULL, 10000001, 10, NULL, NULL, 106, '[\"2025-07\",\"2025-08\"]', 101, NULL, NULL, NULL, NULL, '2025-12-06', 5000.00, NULL, NULL, 1, 1, '2025-12-09 22:52:44', NULL, NULL, '::1'),
(1000000008, 'OVJMR-2512005', NULL, NULL, 2, '2025-2026', NULL, 10000008, NULL, 'Aklas', NULL, 102, NULL, 104, NULL, '01521313211', 'Tsdf4353', NULL, '2025-12-07', 3000.00, NULL, NULL, 1, 1, '2025-12-09 23:04:14', NULL, NULL, '::1'),
(1000000009, 'OVJMR-2512006', NULL, NULL, 2, '2025-2026', NULL, 10000008, NULL, 'Araf', NULL, 103, NULL, 102, NULL, NULL, NULL, NULL, '2025-12-09', 4000.00, NULL, NULL, 1, 1, '2025-12-09 23:10:20', NULL, NULL, '::1'),
(1000000010, 'OVJMR-2512007', NULL, NULL, 2, '2025-2026', NULL, 10000009, NULL, NULL, NULL, 101, NULL, 101, NULL, NULL, NULL, NULL, '2025-12-01', 15000.00, NULL, NULL, 1, 1, '2025-12-10 00:04:16', NULL, NULL, '::1'),
(1000000011, 'OVJMD-2512004', NULL, NULL, 1, '2025-2026', NULL, 10000001, 10, NULL, NULL, 107, '[\"2025-09\"]', 102, NULL, NULL, NULL, NULL, '2025-12-10', 2500.00, NULL, NULL, 1, 1, '2025-12-11 00:51:08', NULL, NULL, '::1');

--
-- Triggers `money_receipts`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_mr_id` BEFORE INSERT ON `money_receipts` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(10);
SELECT MAX(mr_id) INTO max_id FROM money_receipts;
 IF max_id IS NOT NULL THEN
  SET NEW.mr_id = max_id+1;
 ELSE
 SET NEW.mr_id = 1000000001;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `pay_method_id` decimal(3,0) NOT NULL,
  `pay_method_name` varchar(255) NOT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`pay_method_id`, `pay_method_name`, `status`) VALUES
(101, 'Cash', 1),
(102, 'Bkash', 1),
(103, 'Nagad', 1),
(104, 'Rocket', 1),
(105, 'Bank', 1);

--
-- Triggers `payment_methods`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_pay_method_id` BEFORE INSERT ON `payment_methods` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(3);
SELECT MAX(pay_method_id) INTO max_id FROM payment_methods;
 IF max_id IS NOT NULL THEN
  SET NEW.pay_method_id = max_id+1;
 ELSE
 SET NEW.pay_method_id = 101;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` decimal(8,0) NOT NULL,
  `category_id` decimal(3,0) NOT NULL,
  `sub_cat_id` decimal(5,0) DEFAULT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_title_bn` varchar(255) DEFAULT NULL,
  `project_code` varchar(20) DEFAULT NULL,
  `project_details` longtext DEFAULT NULL,
  `project_details_bn` text DEFAULT NULL,
  `project_start_date` date DEFAULT NULL,
  `project_end_date` date DEFAULT NULL,
  `target_amount` decimal(25,2) DEFAULT 0.00,
  `collection_amount` decimal(25,2) DEFAULT 0.00,
  `total_expense` decimal(25,2) DEFAULT 0.00,
  `loan_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `image` text DEFAULT NULL,
  `additional_link` text DEFAULT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 1 COMMENT '1 = Active, 2 = Complete',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `category_id`, `sub_cat_id`, `project_title`, `project_title_bn`, `project_code`, `project_details`, `project_details_bn`, `project_start_date`, `project_end_date`, `target_amount`, `collection_amount`, `total_expense`, `loan_amount`, `image`, `additional_link`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(10000001, 104, NULL, 'Membership Project', NULL, 'FH001', NULL, NULL, '2025-07-31', NULL, 0.00, 40000.00, 9000.00, 0.00, 'uploads/projects/project-20251019-895.png', NULL, 1, 1, '2025-10-19 09:33:11', 1, '2025-10-19 09:43:59', '::1'),
(10000002, 101, 10001, 'Rahim Mia Cancer Project', NULL, 'FH002', 'Rahim Mia cancer patient.সাফওয়ান (রা.) বলেন, আমি রাসুলুল্লাহ (সা.)-এর কাছে এলাম। তখন তিনি মসজিদে বসা ছিলেন। আমি তাঁকে বললাম, হে আল্লাহর রাসুল, আমি এসেছি ইলম অর্জনের জন্য। নিশ্চয়ই তালেবে ইলমকে ফেরেশতারা ঘিরে রাখে এবং তাদের ডানা দিয়ে ছায়া দিতে থাকে।', NULL, '2025-10-17', NULL, 0.00, 19000.00, 5000.00, 0.00, 'uploads/projects/project-20251025-981.jpg', NULL, 1, 1, '2025-10-19 10:09:34', 1, '2025-10-25 08:29:09', '::1'),
(10000003, 102, 10002, 'Dinajpur Model Mosque', NULL, 'FH102', 'অনেক সময় আমরা মাসজিদে সাদকায়ে জারিয়ায় নিয়াতে দান করি, কিন্তু এরপর কোন আপডেট পাইনা। আমাদের দানের টাকা দিয়ে মাসজিদের কাজটা ঠিক ভাবে সম্পন্ন হলো কিনা সেটা জানতে পারলে দানের উৎসাহ বৃদ্ধি পায়।', NULL, '2025-10-24', NULL, 0.00, 0.00, 0.00, 0.00, 'uploads/projects/project-20251025-267.jpeg', NULL, 1, 1, '2025-10-25 07:56:47', 1, '2025-10-31 08:49:07', '::1'),
(10000004, 102, NULL, 'Tree Planation', NULL, 'FH102', NULL, NULL, '2025-10-27', '2025-10-31', 0.00, 0.00, 0.00, 0.00, 'uploads/projects/project-20251028-643.jpeg', 'https://docs.google.com/document/d/1FAuGaQbcNTn-ZtJ4iPAxjGXnfQpSYnzF/edit?usp=drive_link&ouid=109465824961694489248&rtpof=true&sd=true', 2, 1, '2025-10-28 11:33:36', NULL, '2025-11-22 09:42:13', '::1'),
(10000005, 101, NULL, 'test', NULL, 'FH154', NULL, NULL, '2025-11-12', NULL, 0.00, 40000.00, 5000.00, 0.00, 'uploads/projects/project-20251112-304.jpg', NULL, 1, 1, '2025-11-12 11:39:57', 1, '2025-11-12 11:48:28', '::1'),
(10000006, 102, NULL, 'Land Purchase Project', 'জমি কেনা প্রোজেক্ট', 'FH171', 'দুনিয়ায় অল্প দামে জমি কিংবা ফ্ল্যাট ক্রয়ের অনেক বিজ্ঞাপন চোখে পড়ে আমাদের, কিন্তু মাদ্রাসার জন্য জমি ক্রয়ের সুযোগ আসে খুব কম। অভিযাত্রিক FHP 171 প্রজেক্টে সেই সুযোগ নিয়ে এসেছে আপনাদের সামনে।', 'We see many advertisements in the world for buying land or flats at low prices, but the opportunity to buy land for a madrasa is very rare. The adventurer FHP 171 project brings that opportunity to you.', '2025-11-27', NULL, 0.00, 5000.00, 4000.00, 0.00, 'uploads/projects/project-20251129-303.jpg', NULL, 1, 1, '2025-11-29 10:54:30', NULL, '2025-11-29 10:54:30', '::1'),
(10000007, 105, NULL, 'Loan Project', 'লোন প্রোজেক্ট', 'FH1', NULL, NULL, '2025-12-03', NULL, 0.00, 0.00, 0.00, 0.00, 'uploads/projects/project-20251203-135.png', NULL, 1, 1, '2025-12-03 08:57:42', NULL, '2025-12-03 08:57:42', '::1'),
(10000008, 101, 10001, 'Help for Al amin', 'আল আমিনের সাহায্য প্রোজেক্ট', 'FHP172', 'Help for Al amin', 'আল আমিনের সাহায্য প্রোজেক্ট', '2025-12-05', '2025-12-12', 400000.00, 7000.00, 7000.00, 0.00, 'uploads/projects/project-20251209-177.png', NULL, 1, 1, '2025-12-09 10:49:59', NULL, '2025-12-09 10:49:59', '::1'),
(10000009, 104, NULL, 'Cash Exchange', 'ক্যাশ', 'CP', 'Cash Exchange', 'ক্যাশ', '2025-12-01', NULL, NULL, 15000.00, 3000.00, 0.00, 'uploads/projects/project-20251209-486.png', NULL, 1, 1, '2025-12-09 12:00:12', NULL, '2025-12-09 12:00:12', '::1');

--
-- Triggers `projects`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_project_id` BEFORE INSERT ON `projects` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(8);
SELECT MAX(project_id) INTO max_id FROM projects;
 IF max_id IS NOT NULL THEN
  SET NEW.project_id = max_id+1;
 ELSE
 SET NEW.project_id = 10000001;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_images`
--

CREATE TABLE `project_images` (
  `id` bigint(20) NOT NULL,
  `project_id` decimal(8,0) NOT NULL,
  `image` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_images`
--

INSERT INTO `project_images` (`id`, `project_id`, `image`, `short_description`, `created_at`, `updated_at`) VALUES
(12, 10000004, 'uploads/project_gallery/1764643180_591596063_1253513676804324_7344886815651393602_n.jpg', NULL, '2025-12-01 20:39:40', '2025-12-01 20:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `salary_id` int(11) NOT NULL,
  `salary_no` varchar(50) NOT NULL COMMENT 'Auto Generate',
  `fiscal_year` varchar(20) DEFAULT NULL,
  `salary_year` int(11) NOT NULL,
  `salary_month` int(11) NOT NULL,
  `salary_date` date DEFAULT NULL,
  `total_salary` decimal(15,2) NOT NULL DEFAULT 0.00,
  `project_id` decimal(8,0) DEFAULT NULL,
  `account_id` decimal(3,0) NOT NULL DEFAULT 101,
  `pay_method_id` decimal(3,0) NOT NULL DEFAULT 101,
  `bank_account_no` varchar(50) DEFAULT NULL,
  `mobile_account_no` varchar(15) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `transaction_no` varchar(100) DEFAULT NULL,
  `posting_type` decimal(1,0) NOT NULL DEFAULT 0,
  `status` decimal(1,0) DEFAULT 0,
  `approval_by` int(11) DEFAULT NULL,
  `approval_at` datetime DEFAULT NULL,
  `declined_by` int(11) DEFAULT NULL,
  `declined_at` datetime DEFAULT NULL,
  `decline_remark` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `operation_ip` varchar(50) DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_id`, `salary_no`, `fiscal_year`, `salary_year`, `salary_month`, `salary_date`, `total_salary`, `project_id`, `account_id`, `pay_method_id`, `bank_account_no`, `mobile_account_no`, `bank_name`, `transaction_no`, `posting_type`, `status`, `approval_by`, `approval_at`, `declined_by`, `declined_at`, `decline_remark`, `created_at`, `created_by`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(8, 'OVJSL-7935', '2025-2026', 2025, 7, '2025-08-07', 7500.00, 10000001, 106, 101, NULL, NULL, NULL, NULL, 1, 1, 1, '2025-12-10 15:31:24', NULL, NULL, NULL, '2025-12-10 21:31:04', 1, 1, '2025-12-10 09:31:13', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `salary_details_id` int(11) NOT NULL,
  `salary_id` int(11) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `account_no` varchar(100) DEFAULT NULL,
  `salary_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `salary_details`
--

INSERT INTO `salary_details` (`salary_details_id`, `salary_id`, `employee_id`, `account_no`, `salary_amount`) VALUES
(15, 8, 3, NULL, 5000.00),
(16, 8, 4, NULL, 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `sub_cat_id` decimal(5,0) NOT NULL,
  `category_id` decimal(3,0) NOT NULL,
  `sub_cat_name` varchar(255) NOT NULL,
  `sub_cat_name_bn` varchar(100) DEFAULT NULL,
  `status` decimal(1,0) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`sub_cat_id`, `category_id`, `sub_cat_name`, `sub_cat_name_bn`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `operation_ip`) VALUES
(10001, 101, 'Cancer', 'ক্যানসার', 1, 1, '2025-08-04 17:18:02', 1, '2025-08-04 17:18:02', '::1'),
(10002, 102, 'Mosque', 'মসজিদ', 1, 1, '2025-08-04 17:18:13', 1, '2025-08-04 17:18:13', '::1'),
(10003, 103, 'Rahim miya tube well', 'রহিম মিয়ার টিউব ওয়েল', 1, 1, '2025-09-05 05:25:48', NULL, '2025-09-05 05:25:48', '::1');

--
-- Triggers `sub_categories`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_sub_categories_id` BEFORE INSERT ON `sub_categories` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(5);
SELECT MAX(sub_cat_id) INTO max_id FROM sub_categories;
 IF max_id IS NOT NULL THEN
  SET NEW.sub_cat_id = max_id+1;
 ELSE
 SET NEW.sub_cat_id = 10001;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` decimal(12,0) NOT NULL COMMENT 'Primary Key - 4 Digit Year (YYYY), 2 Digit Month (MM), 6 Digit Number (NNNNNN)',
  `reference_type` varchar(100) DEFAULT NULL,
  `reference_id` decimal(10,0) DEFAULT NULL,
  `fiscal_year` varchar(20) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `project_id` decimal(8,0) DEFAULT NULL,
  `transaction_type` decimal(1,0) NOT NULL COMMENT '1 = money receipt, -1 = expense, 2 = transfer to, -2 = transfer from, -4 = Salary Expense',
  `transaction_date` date NOT NULL,
  `transaction_amount` decimal(25,2) DEFAULT 0.00,
  `account_id` decimal(3,0) DEFAULT 101,
  `pay_method_id` decimal(3,0) DEFAULT 101,
  `transaction_added_on` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_added_by` int(11) NOT NULL DEFAULT 0,
  `transaction_edited_on` datetime DEFAULT NULL,
  `transaction_edited_by` int(11) DEFAULT NULL,
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `reference_type`, `reference_id`, `fiscal_year`, `member_id`, `project_id`, `transaction_type`, `transaction_date`, `transaction_amount`, `account_id`, `pay_method_id`, `transaction_added_on`, `transaction_added_by`, `transaction_edited_on`, `transaction_edited_by`, `operation_ip`) VALUES
(202512000001, 'member_receipt', 1000000001, '2025-2026', 15, 10000001, 1, '2025-12-01', 30000.00, 106, 101, '2025-12-06 18:52:51', 1, NULL, NULL, '127.0.0.1'),
(202512000002, 'member_receipt', 1000000002, '2025-2026', 8, 10000001, 1, '2025-12-02', 2500.00, 107, 101, '2025-12-06 18:54:13', 1, NULL, NULL, '127.0.0.1'),
(202512000003, 'money_receipt', 1000000003, '2025-2026', NULL, 10000002, 1, '2025-12-01', 4000.00, 101, 101, '2025-12-06 18:54:51', 1, NULL, NULL, '::1'),
(202512000004, 'money_receipt', 1000000004, '2025-2026', NULL, 10000006, 1, '2025-12-03', 5000.00, 103, 102, '2025-12-06 18:55:23', 1, NULL, NULL, '::1'),
(202512000005, 'money_receipt', 1000000005, '2025-2026', NULL, 10000002, 1, '2025-12-04', 15000.00, 103, 102, '2025-12-06 18:56:15', 1, NULL, NULL, '::1'),
(202512000006, 'project-expenses', 43, '2025-2026', NULL, 10000006, -1, '2025-12-04', 4000.00, 103, 101, '2025-12-06 18:58:42', 1, NULL, NULL, '::1'),
(202512000007, 'project-expenses', 44, '2025-2026', NULL, 10000002, -1, '2025-12-06', 5000.00, 103, 101, '2025-12-06 19:01:09', 1, NULL, NULL, '::1'),
(202512000008, 'expenses', 45, '2025-2026', NULL, 10000001, -1, '2025-12-06', 500.00, 107, 102, '2025-12-06 19:01:53', 1, NULL, NULL, '::1'),
(202512000009, 'money_receipt', 1000000006, '2025-2026', NULL, 10000005, 1, '2025-12-08', 40000.00, 105, 105, '2025-12-09 15:59:27', 1, NULL, NULL, '::1'),
(202512000010, 'project-expenses', 46, '2025-2026', NULL, 10000005, -1, '2025-12-09', 5000.00, 103, 102, '2025-12-09 16:01:35', 1, NULL, NULL, '::1'),
(202512000011, 'member_receipt', 1000000007, '2025-2026', 10, 10000001, 1, '2025-12-06', 5000.00, 106, 101, '2025-12-09 16:52:44', 1, NULL, NULL, '127.0.0.1'),
(202512000012, 'money_receipt', 1000000008, '2025-2026', NULL, 10000008, 1, '2025-12-07', 3000.00, 102, 104, '2025-12-09 17:04:14', 1, NULL, NULL, '::1'),
(202512000013, 'money_receipt', 1000000009, '2025-2026', NULL, 10000008, 1, '2025-12-09', 4000.00, 103, 102, '2025-12-09 17:10:21', 1, NULL, NULL, '::1'),
(202512000014, 'project-expenses', 47, '2025-2026', NULL, 10000008, -1, '2025-12-09', 7000.00, 103, 102, '2025-12-09 17:20:37', 1, NULL, NULL, '::1'),
(202512000015, 'money_receipt', 1000000010, '2025-2026', NULL, 10000009, 1, '2025-12-01', 15000.00, 101, 101, '2025-12-09 18:04:16', 1, NULL, NULL, '::1'),
(202512000016, 'project-expenses', 48, '2025-2026', NULL, 10000009, -1, '2025-12-10', 3000.00, 102, 104, '2025-12-09 18:05:31', 1, NULL, NULL, '::1'),
(202512000017, 'expenses', 49, '2025-2026', NULL, 10000001, -1, '2025-12-09', 1000.00, 107, 102, '2025-12-10 03:26:17', 1, NULL, NULL, '::1'),
(202512000018, 'salary-expenses', 7, '2025-2026', NULL, 10000001, -1, '2025-09-04', 7500.00, 106, 101, '2025-12-10 15:17:58', 1, NULL, NULL, '::1'),
(202512000019, 'salary-expenses', 8, '2025-2026', NULL, 10000001, -1, '2025-08-07', 7500.00, 106, 101, '2025-12-10 15:31:24', 1, NULL, NULL, '::1'),
(202512000020, 'member_receipt', 1000000011, '2025-2026', 10, 10000001, 1, '2025-12-10', 2500.00, 107, 101, '2025-12-10 18:51:08', 1, NULL, NULL, '127.0.0.1');

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `aftr_insert_transaction_id_trigger` AFTER INSERT ON `transactions` FOR EACH ROW begin
call update_debit_credit_ledger(new.transaction_type,new.project_id,new.transaction_amount,new.transaction_added_on,new.transaction_added_by,new.operation_ip);
end
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `transactions_id_before_insert_trigger` BEFORE INSERT ON `transactions` FOR EACH ROW BEGIN
DECLARE  max_id  decimal(12);
select max(transaction_id) into max_id from transactions where substr( transaction_id ,1,6) = substr((new. transaction_added_on +0),1,6);
if  max_id  is not null then
	set new. transaction_id = max_id +1;
else
	set new. transaction_id =(substr((new. transaction_added_on +0),1,6))*1000000+1;
end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `transfer_id` decimal(6,0) NOT NULL,
  `transfer_no` varchar(50) NOT NULL COMMENT 'Auto Generate',
  `fiscal_year` varchar(20) DEFAULT NULL,
  `from_project` decimal(8,0) DEFAULT NULL,
  `to_project` decimal(8,0) DEFAULT NULL,
  `transfer_date` date NOT NULL,
  `transfer_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `transfer_remarks` varchar(255) DEFAULT NULL,
  `decline_remarks` varchar(255) DEFAULT NULL,
  `transfer_status` decimal(1,0) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `operation_ip` varchar(50) NOT NULL DEFAULT '::1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `transfers`
--
DELIMITER $$
CREATE TRIGGER `bfr_insert_transfer_id` BEFORE INSERT ON `transfers` FOR EACH ROW BEGIN
DECLARE max_id 			DECIMAL(6);
SELECT MAX(transfer_id) INTO max_id FROM transfers;
 IF max_id IS NOT NULL THEN
  SET NEW.transfer_id = max_id+1;
 ELSE
 SET NEW.transfer_id = 100001;
 END IF;
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `member_id` varchar(50) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `monthly_donate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 3,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `member_id`, `emp_id`, `phone_no`, `email`, `email_verified_at`, `password`, `occupation`, `monthly_donate`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'Md.Mahmodul Hasan', '0', NULL, NULL, 'rimonitsolution@gmail.com', NULL, '$2y$12$ebKhaoJzNJk.gdy1YeBN2uhrhyJ1UeQUkr230PjNWA5n.ab7DDSV.', NULL, 0.00, NULL, '2025-07-15 12:02:21', '2025-07-15 12:02:21', 1, 1),
(8, 'Rimon khan', 'OBM001', NULL, '015231313200', 'rimon@gmail.com', NULL, '$2y$12$UI2dZ1UV.JmojGwQ0eajUuVZit/2TovQUcQoRcRKEtRBVrEWyn9si', 'Job', 2500.00, NULL, '2025-09-10 20:22:10', '2025-11-24 11:02:26', 3, 1),
(9, 'Asha', 'OBBM001', NULL, '01707128085', 'asha@gmail.com', NULL, '$2y$12$Dl4tcmiIG4QhJjXh.G.x0OvJSHTeEtJr6jwDzb0UZc/6SlNmuhye6', 'Service', 1500.00, NULL, '2025-09-10 20:23:43', '2025-11-24 11:02:08', 3, 1),
(10, 'Salim Ahmed', 'OBM004', NULL, '01707852365', 'salim@gmail.com', NULL, '$2y$12$PeULRVNhxpxBjq2i/RIaL.vH5B3DpbWTOdQ.RsJ1z8ci087HbBskq', NULL, 2500.00, 'FhomVuONJS7icLy5mviIzmNKtrCalg2TRDU04tE8xCJYF7y8APq2c482DTz7', '2025-10-01 21:52:55', '2025-10-01 21:54:01', 3, 1),
(12, 'Arif Islam', NULL, 3, '01752458645', 'arif@ovijatrik.org', NULL, '$2y$12$Yz/RCGqItLTsKKVhLKSvVe2ZHA3oAjgTu6LDsc5OB.KNYGINUOSlC', NULL, 0.00, NULL, '2025-10-21 11:48:26', '2025-10-23 10:32:43', 2, 1),
(13, 'Asha Akter', 'OBM002', NULL, '01521313200', 'asha12@gmail.com', NULL, '$2y$12$.YP4BYyswNyPQbMZIykCAO/RpkcXs42QyOAGJIcBOKBI7C3ky.oO.', 'Student', 1000.00, NULL, '2025-11-13 10:42:50', '2025-11-24 11:03:22', 3, 1),
(14, 'Sakib All', NULL, 4, '01521320230', 'sakib@gmail.com', NULL, '$2y$12$0tU/fZjC.oaKmD8ErIA/F.spUFlMUxzWEvEsJ1e3QOB1FzemGzNQC', NULL, 0.00, NULL, '2025-11-26 09:56:07', '2025-11-26 09:56:07', 2, 1),
(15, 'Najrin Akter', 'OBBM003', NULL, '01521313255', 'najrin@gmail.com', NULL, '$2y$12$DH7ZjtlvtWBWe2TwFdOsoudzNe5D/.qaRZBt8MC/OPDzzJxE1Xitq', 'Job', 15000.00, NULL, '2025-11-29 10:56:23', '2025-11-29 10:56:41', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` enum('পুরুষ','মহিলা') DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `alt_phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fb_link` varchar(255) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `is_foreign` enum('হ্যাঁ','না') DEFAULT 'না',
  `foreign_country` varchar(100) DEFAULT NULL,
  `foreign_location` varchar(100) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `skills` mediumtext DEFAULT NULL,
  `interest` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debit_credit_ledger`
--
ALTER TABLE `debit_credit_ledger`
  ADD PRIMARY KEY (`ledger_id`),
  ADD KEY `fk_ledger_project_id` (`project_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_no` (`emp_no`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`expense_cat_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `false_receipts`
--
ALTER TABLE `false_receipts`
  ADD PRIMARY KEY (`fls_receipt_id`);

--
-- Indexes for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  ADD PRIMARY KEY (`fiscal_year_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `galleries_caption_unique` (`caption`);

--
-- Indexes for table `loan_accounts`
--
ALTER TABLE `loan_accounts`
  ADD PRIMARY KEY (`loan_account_id`);

--
-- Indexes for table `loan_transactions`
--
ALTER TABLE `loan_transactions`
  ADD PRIMARY KEY (`loan_transactions_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_receipts`
--
ALTER TABLE `money_receipts`
  ADD PRIMARY KEY (`mr_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`pay_method_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_images`
--
ALTER TABLE `project_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`salary_details_id`),
  ADD KEY `salary_id` (`salary_id`),
  ADD KEY `fk_salary_dtls_employee_id` (`employee_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key -  Digit Number (N)', AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `expense_cat_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key - 5 Digit Number (NNNNN)', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `false_receipts`
--
ALTER TABLE `false_receipts`
  MODIFY `fls_receipt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key -  Digit Number (N)', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fiscal_years`
--
ALTER TABLE `fiscal_years`
  MODIFY `fiscal_year_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_images`
--
ALTER TABLE `project_images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `salary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `salary_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `debit_credit_ledger`
--
ALTER TABLE `debit_credit_ledger`
  ADD CONSTRAINT `fk_ledger_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `project_images`
--
ALTER TABLE `project_images`
  ADD CONSTRAINT `project_images_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
