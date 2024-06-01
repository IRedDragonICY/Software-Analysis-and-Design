-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2024 at 01:55 AM
-- Server version: 10.6.11-MariaDB-1:10.6.11+maria~ubu2004
-- PHP Version: 7.3.33-8+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbscloud_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `agen`
--

CREATE TABLE `agen` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balance_history`
--

CREATE TABLE `balance_history` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` enum('Plus','Minus') NOT NULL,
  `category` enum('Deposit','Pembelian','Refund Saldo','Create Voucher') NOT NULL,
  `balance` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `balance_history`
--

INSERT INTO `balance_history` (`id`, `email`, `type`, `category`, `balance`, `message`, `date`, `time`) VALUES
(1, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan pembelian Voucher ID Pesanan #9328658', '2022-12-12', '10:39:35'),
(2, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan Pembelian Voucher #4805991', '2022-12-12', '12:49:58'),
(3, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan Pembelian Voucher #9949880', '2022-12-12', '13:19:24'),
(4, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan Pembelian Voucher #8067061', '2022-12-12', '14:01:01'),
(5, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan Pembelian Voucher #8530787', '2022-12-12', '18:36:35'),
(6, 'adarmawan106@gmail.com', 'Minus', 'Pembelian', 2000, 'Melakukan Pembelian Voucher #1899854', '2022-12-13', '13:00:28');

-- --------------------------------------------------------

--
-- Table structure for table `bot_telegram`
--

CREATE TABLE `bot_telegram` (
  `id` int(11) NOT NULL,
  `bot_token` varchar(200) NOT NULL,
  `username_bot` varchar(200) NOT NULL,
  `id_owner` varchar(100) NOT NULL,
  `access` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `logo` varchar(500) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `postal_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `logo`, `address`, `city`, `province`, `country`, `postal_code`) VALUES
(1, 'logo-221027-07471bdf95.png', 'Kp Pulojahe ', 'Jakarta Timur', 'Dki Jakarta', 'Indonesia', '13930');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `rate` int(11) NOT NULL,
  `otp` enum('yes','no','ya','tidak') NOT NULL,
  `status` enum('Enable','Disable') NOT NULL,
  `created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`id`, `code`, `rate`, `otp`, `status`, `created`) VALUES
(1, 'DISC25', 25, 'ya', 'Enable', '2023-01-04');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nomor` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `idpel` varchar(100) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL,
  `service` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `note` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `status` enum('Pending','Success','Error','Unpaid','Paid') NOT NULL,
  `date` date NOT NULL,
  `exppay` varchar(50) NOT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `qr_url` varchar(255) DEFAULT NULL,
  `reference` varchar(100) NOT NULL,
  `coupon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `code`, `user`, `category`, `service`, `method`, `note`, `quantity`, `balance`, `status`, `date`, `exppay`, `payment_url`, `qr_url`, `reference`, `coupon`) VALUES
(1, 'INV0001PKMLR', 'admin@mbsid.my.id', 'DG ', 'QRIS', 'QRIS', '', 10802, 10802, 'Unpaid', '2022-10-07', '08-10-2022 05:06:54', NULL, 'https://tripay.co.id/qr/DEV-T053563019YKDDK', 'DEV-T053563019YKDDK', ''),
(2, 'INV0002YT0S8', 'admin@mbsid.my.id', 'DG ', 'QRIS', 'QRIS', '', 10099, 10099, 'Unpaid', '2022-10-07', '08-10-2022 05:08:57', NULL, 'https://tripay.co.id/qr/DEV-T1375663020VD3IP', 'DEV-T1375663020VD3IP', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `idpel` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `service` varchar(100) NOT NULL,
  `method` varchar(100) NOT NULL,
  `penerima` text NOT NULL,
  `metode_pembayaran` varchar(200) NOT NULL,
  `package` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `random_price` int(11) NOT NULL,
  `fix_received` int(11) NOT NULL,
  `status` enum('Pending','Success','Error','Unpaid','Paid') NOT NULL,
  `reference` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `expdate` datetime NOT NULL,
  `exppay` varchar(50) NOT NULL,
  `last_update` datetime NOT NULL,
  `payment_url` varchar(255) DEFAULT NULL,
  `qr_url` varchar(255) DEFAULT NULL,
  `update_by` text NOT NULL,
  `data_invoice` varchar(100) NOT NULL,
  `account` varchar(100) NOT NULL,
  `code_coupon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `code`, `idpel`, `nama`, `category`, `service`, `method`, `penerima`, `metode_pembayaran`, `package`, `price`, `random_price`, `fix_received`, `status`, `reference`, `date`, `expdate`, `exppay`, `last_update`, `payment_url`, `qr_url`, `update_by`, `data_invoice`, `account`, `code_coupon`) VALUES
(6, 'INV0003JXIS7', '', 'admin@mbsid.my.id', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10215, 0, 0, 'Paid', 'DEV-T1375663143YB47N', '2022-10-08', '0000-00-00 00:00:00', '09-10-2022 16:43:48', '2022-10-10 21:45:28', NULL, 'https://tripay.co.id/qr/DEV-T1375663143YB47N', 'System Payment Gateway', '', 'member', ''),
(7, 'INV0003M8WCT', '', 'admin@mbsid.my.id', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10523, 0, 0, 'Paid', 'DEV-T1375663403G3A3S', '2022-10-10', '0000-00-00 00:00:00', '11-10-2022 21:37:10', '2022-10-10 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T1375663403G3A3S', 'System Payment Gateway', '', 'member', ''),
(8, 'INV0003ODIOC', '', 'admin@mbsid.my.id', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10669, 0, 0, 'Unpaid', 'DEV-T137566340605FAQ', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 02:46:11', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T137566340605FAQ', '', '', 'member', ''),
(9, 'INV0003W27AF', '', 'admin@mbsid.my.id', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 100802, 0, 0, 'Unpaid', 'DEV-T13756634070TFIL', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 02:47:37', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T13756634070TFIL', '', '', 'member', ''),
(10, 'INV0003YHJT7', '', 'admin@mbsid.my.id', 'DG ', 'QRIS', 'QRIS', '', '', 'Deposit Member', 10157, 0, 0, 'Unpaid', 'DEV-T1375663408QJM0T', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 02:55:29', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T1375663408QJM0T', '', '', 'member', ''),
(11, 'INV0003O4L5N', '', 'admin@mbsid.my.id', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10620, 0, 0, 'Unpaid', 'DEV-T1375663409QX95E', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 02:57:28', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T1375663409QX95E', '', '', 'member', ''),
(12, 'INV00037BYMP', '', 'admin@mbsid.my.id', 'VA ', 'Maybank Virtual Account', 'Maybank Virtual Account', '399089242784229', '', 'Deposit Member', 100232, 0, 0, 'Unpaid', 'DEV-T1375663410GUJOP', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 03:00:36', '0000-00-00 00:00:00', NULL, NULL, '', '', 'member', ''),
(13, 'INV0003C9REC', '', 'admin@mbsid.my.id', 'VA ', 'BRI Virtual Account', 'BRI Virtual Account', '238807179484933', '', 'Deposit Member', 100964, 0, 0, 'Unpaid', 'DEV-T1375663452UPOOY', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 18:21:04', '0000-00-00 00:00:00', NULL, NULL, '', '', 'member', ''),
(14, 'INV0003A4W5T', '', 'admin@mbsid.my.id', 'DG ', 'QRIS', 'QRIS', '', '', 'Deposit Member', 100206, 0, 0, 'Paid', 'DEV-T1375663454AB9QY', '2022-10-11', '0000-00-00 00:00:00', '12-10-2022 18:31:43', '2022-10-11 19:09:27', NULL, 'https://tripay.co.id/qr/DEV-T1375663454AB9QY', 'System Payment Gateway', '', 'member', ''),
(15, 'INV0003LD4JH', '', 'admin@mbsid.my.id', 'DG ', '', '', '', '', 'Deposit Member', 10958, 0, 0, 'Unpaid', 'DEV-T13756641623PCXO', '2022-10-19', '0000-00-00 00:00:00', '20-10-2022 20:11:47', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T13756641623PCXO', '', '', 'member', ''),
(16, 'INV0003EWAZX', '', 'Adi Darmawan', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10210, 0, 0, 'Unpaid', 'DEV-T053569268ROIFW', '2022-12-01', '0000-00-00 00:00:00', '02-12-2022 05:33:50', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053569268ROIFW', '', '', 'member', ''),
(17, 'INV0003W1FVR', '', 'Adi Darmawan', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10089, 0, 0, 'Unpaid', 'DEV-T053569269GSRSF', '2022-12-01', '0000-00-00 00:00:00', '02-12-2022 05:35:16', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053569269GSRSF', '', '', 'member', ''),
(18, 'INV00039MWVP', '', 'Adi Darmawan', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10310, 0, 0, 'Unpaid', 'DEV-T053569270ASADF', '2022-12-01', '0000-00-00 00:00:00', '02-12-2022 05:36:05', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053569270ASADF', '', '', 'member', ''),
(19, 'INV00035KNZJ', '', 'Adi Darmawan', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10493, 0, 0, 'Unpaid', 'DEV-T053569271WV4DI', '2022-12-01', '0000-00-00 00:00:00', '02-12-2022 05:36:40', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053569271WV4DI', '', '', 'member', ''),
(20, 'INV000301ELO', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10458, 0, 0, 'Error', 'DEV-T053570903Y858Z', '2022-12-09', '0000-00-00 00:00:00', '10-12-2022 22:39:09', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053570903Y858Z', '', '', 'member', ''),
(21, 'INV00032EAY0', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS', 'QRIS', '', '', 'Deposit Member', 10023, 0, 0, 'Unpaid', 'DEV-T053571116ISHMM', '2022-12-11', '0000-00-00 00:00:00', '12-12-2022 06:31:56', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053571116ISHMM', '', '', 'member', ''),
(22, 'INV0003POTN3', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10251, 0, 0, 'Unpaid', 'DEV-T053571117OSOAN', '2022-12-11', '0000-00-00 00:00:00', '12-12-2022 06:33:17', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053571117OSOAN', '', '', 'member', ''),
(23, 'INV0003NYEDJ', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10817, 0, 0, 'Unpaid', 'DEV-T053571120EW75Y', '2022-12-11', '0000-00-00 00:00:00', '12-12-2022 08:12:18', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053571120EW75Y', '', '', 'member', ''),
(24, 'INV0003YONP6', 'adarmawan106@gmail.com', 'addrmwn', 'VA ', 'BNI Virtual Account', 'BNI Virtual Account', '589368833537213', '', 'Deposit Member', 10223, 0, 0, 'Unpaid', 'DEV-T0535711823VQSW', '2022-12-11', '0000-00-00 00:00:00', '12-12-2022 23:50:45', '0000-00-00 00:00:00', NULL, NULL, '', '', 'member', ''),
(25, 'INV000354F85', 'adarmawan106@gmail.com', 'addrmwn', 'VA ', 'BNI Virtual Account', 'BNI Virtual Account', '262194563593832', '', 'Deposit Member', 10572, 0, 0, 'Unpaid', 'DEV-T053571183DDQUP', '2022-12-11', '0000-00-00 00:00:00', '12-12-2022 23:52:02', '0000-00-00 00:00:00', NULL, NULL, '', '', 'member', ''),
(26, 'INV0003DVSVV', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10137, 0, 0, 'Unpaid', 'DEV-T0535712611M3FT', '2022-12-12', '0000-00-00 00:00:00', '13-12-2022 13:20:34', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T0535712611M3FT', '', '', 'member', ''),
(27, 'INV0003D00QL', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10670, 0, 0, 'Unpaid', 'DEV-T053571262GOXAR', '2022-12-12', '0000-00-00 00:00:00', '13-12-2022 13:33:03', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053571262GOXAR', '', '', 'member', ''),
(28, 'INV00039JKP3', 'adarmawan106@gmail.com', 'addrmwn', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10628, 0, 0, 'Unpaid', 'DEV-T053571263K4MZE', '2022-12-12', '0000-00-00 00:00:00', '13-12-2022 13:34:58', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053571263K4MZE', '', '', 'member', ''),
(29, 'INV0004ZXGHV', 'P-0001', 'Adi Darmawan', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Paket Internet 10Mbps', 166500, 127374, 125743, 'Unpaid', 'DEV-T053574829SN8UR', '2022-12-13', '2022-12-30 00:00:00', '15-01-2023 20:25:08', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T053574829SN8UR', '', '', 'user', ''),
(30, 'INV0005FG2GC', 'P-0002', 'Syara', '', '', '', '', '', 'Paket Internet 10Mbps', 166500, 0, 0, 'Unpaid', '', '2022-12-13', '2022-12-30 00:00:00', '', '0000-00-00 00:00:00', NULL, NULL, '', '', 'user', ''),
(31, 'INV0003VIPD6', 'syarawaldana@gmail.com', 'Syara', 'DG ', 'QRIS (ShopeePay)', 'QRIS (ShopeePay)', '', '', 'Deposit Member', 10131, 0, 0, 'Unpaid', 'DEV-T13756748258SQRI', '2023-01-14', '0000-00-00 00:00:00', '15-01-2023 19:57:44', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T13756748258SQRI', '', '', 'member', ''),
(32, 'INV0003CEPGM', 'syarawaldana@gmail.com', 'Syara', 'DG ', 'QRIS', 'QRIS', '', '', 'Deposit Member', 20970, 0, 0, 'Unpaid', 'DEV-T1375674826JMYKT', '2023-01-14', '0000-00-00 00:00:00', '15-01-2023 19:58:30', '0000-00-00 00:00:00', NULL, 'https://tripay.co.id/qr/DEV-T1375674826JMYKT', '', '', 'member', '');

-- --------------------------------------------------------

--
-- Table structure for table `kat_voucher`
--

CREATE TABLE `kat_voucher` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` varchar(255) NOT NULL,
  `tipe` int(11) NOT NULL,
  `log_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`id`, `time`, `user`, `tipe`, `log_desc`) VALUES
(1, '2022-09-18 21:45:42', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(2, '2022-09-19 10:11:00', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(3, '2022-09-19 15:34:01', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(4, '2022-09-19 17:22:08', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(5, '2022-09-19 17:24:32', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(6, '2022-09-19 18:11:17', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(7, '2022-09-19 18:16:36', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(8, '2022-09-19 18:16:38', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(9, '2022-09-19 18:16:47', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(10, '2022-09-19 18:16:49', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(11, '2022-09-19 18:19:03', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(12, '2022-09-19 19:48:24', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(13, '2022-09-19 22:26:14', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(14, '2022-09-20 04:26:24', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(15, '2022-09-21 11:52:41', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(16, '2022-09-21 21:02:22', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(17, '2022-09-22 09:33:00', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(18, '2022-09-22 11:55:55', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(19, '2022-09-22 12:37:15', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(20, '2022-09-22 16:45:39', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(21, '2022-09-22 20:33:17', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(22, '2022-09-23 00:45:25', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(23, '2022-09-23 08:31:59', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(24, '2022-09-23 10:10:06', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(25, '2022-09-23 12:14:35', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(26, '2022-09-30 12:39:11', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(27, '2022-09-30 12:40:22', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(28, '2022-09-30 12:40:25', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(29, '2022-09-30 15:44:26', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(30, '2022-09-30 15:47:54', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(31, '2022-09-30 15:48:05', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(32, '2022-09-30 21:57:13', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(33, '2022-09-30 22:29:30', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(34, '2022-10-01 03:29:33', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(35, '2022-10-04 15:19:19', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(36, '2022-10-04 16:25:45', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(37, '2022-10-04 16:25:49', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(38, '2022-10-05 03:41:11', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(39, '2022-10-05 04:37:21', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(40, '2022-10-05 04:37:25', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(41, '2022-10-05 04:37:36', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(42, '2022-10-05 04:37:45', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(43, '2022-10-06 16:29:47', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(44, '2022-10-06 16:30:13', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(45, '2022-10-06 16:30:17', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(46, '2022-10-06 19:51:47', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(47, '2022-10-06 19:52:15', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(48, '2022-10-06 19:52:17', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(49, '2022-10-06 19:52:20', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(50, '2022-10-06 19:52:49', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(51, '2022-10-06 20:37:00', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(52, '2022-10-06 20:37:10', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(53, '2022-10-06 20:37:28', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(54, '2022-10-06 20:47:00', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(55, '2022-10-07 07:55:29', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(56, '2022-10-08 08:36:34', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(57, '2022-10-10 03:53:17', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(58, '2022-10-10 14:36:54', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(59, '2022-10-10 19:45:03', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(60, '2022-10-11 11:20:08', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(61, '2022-10-11 11:27:54', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(62, '2022-10-11 11:28:13', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(63, '2022-10-11 11:31:32', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(64, '2022-10-11 11:31:36', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(65, '2022-10-11 11:33:25', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(66, '2022-10-11 11:33:28', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(67, '2022-10-11 12:09:36', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(68, '2022-10-11 12:09:39', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(69, '2022-10-11 16:05:20', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(70, '2022-10-11 16:16:29', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(71, '2022-10-11 16:16:36', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(72, '2022-10-11 16:17:14', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(73, '2022-10-11 16:17:17', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(74, '2022-10-19 13:11:25', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(75, '2022-10-19 13:16:18', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(76, '2022-10-19 13:16:21', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(77, '2022-10-19 13:19:36', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(78, '2022-10-19 13:19:47', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(79, '2022-10-19 13:22:53', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(80, '2022-10-19 13:22:55', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(81, '2022-10-19 13:29:35', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(82, '2022-10-19 13:31:57', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(83, '2022-10-19 13:37:04', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(84, '2022-10-19 13:44:19', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(85, '2022-10-19 13:44:24', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(86, '2022-10-19 14:04:38', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(87, '2022-10-19 14:04:40', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(88, '2022-10-19 14:50:33', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(89, '2022-10-19 14:50:36', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(90, '2022-10-20 04:27:48', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(91, '2022-10-20 04:27:49', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(92, '2022-10-20 04:27:53', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(93, '2022-10-20 04:27:58', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(94, '2022-10-20 04:28:09', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(95, '2022-10-20 08:17:12', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(96, '2022-10-20 18:35:29', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(97, '2022-10-20 19:32:48', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(98, '2022-10-21 07:31:11', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(99, '2022-10-21 14:21:42', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(100, '2022-10-22 07:44:18', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(101, '2022-10-22 13:50:00', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(102, '2022-10-22 20:46:44', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(103, '2022-10-24 11:33:03', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(104, '2022-10-26 18:32:49', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(105, '2022-10-26 18:32:52', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(106, '2022-10-26 18:32:57', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(107, '2022-10-26 21:02:23', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(108, '2022-10-26 22:04:16', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(109, '2022-10-27 07:55:29', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(110, '2022-10-27 07:55:31', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(111, '2022-10-27 08:08:57', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(112, '2022-10-27 08:09:54', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(113, '2022-10-27 09:48:38', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(114, '2022-10-27 09:48:40', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(115, '2022-10-27 09:48:42', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(116, '2022-10-27 09:48:46', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(117, '2022-10-27 09:52:09', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(118, '2022-10-27 09:52:11', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(119, '2022-10-27 10:02:48', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(120, '2022-10-27 10:02:50', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(121, '2022-10-27 10:03:01', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(122, '2022-10-27 10:38:09', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(123, '2022-10-28 04:24:32', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(124, '2022-10-28 06:43:10', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(125, '2022-10-28 10:38:44', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(126, '2022-10-29 18:25:30', 'adarmawan106@gmail.com', 0, 'Berhasil Login'),
(127, '2022-10-29 18:25:32', 'adarmawan106@gmail.com', 1, 'Berhasil logout'),
(128, '2022-10-29 18:25:35', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(129, '2022-10-30 03:03:55', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(130, '2022-11-06 03:32:42', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(131, '2022-11-06 10:13:09', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(132, '2022-11-15 14:57:30', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(133, '2022-11-15 14:58:57', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(134, '2022-11-15 14:58:59', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(135, '2022-11-15 15:06:53', 'admin@mbsid.my.id', 1, 'Berhasil logout'),
(136, '2022-11-15 15:06:58', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(137, '2022-11-15 19:42:53', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(138, '2022-11-16 10:25:14', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(139, '2022-11-17 10:51:06', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(140, '2022-11-17 19:22:57', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(141, '2022-11-18 12:14:59', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(142, '2022-11-21 00:11:57', 'admin@mbsid.my.id', 0, 'Berhasil Login'),
(143, '2022-11-26 08:54:27', 'admin@mbsid.my.id', 0, 'Berhasil Login');

-- --------------------------------------------------------

--
-- Table structure for table `logs_voucher`
--

CREATE TABLE `logs_voucher` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `service` varchar(100) NOT NULL,
  `kode` text NOT NULL,
  `harga` double NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `logs_voucher`
--

INSERT INTO `logs_voucher` (`id`, `user`, `service`, `kode`, `harga`, `date`, `time`) VALUES
(1, 'Adi Darmawan', 'test-mbsid', '6eug6zb', 2000, '2022-09-22', '03:38:26'),
(2, 'sriwahyuni@gmail.com', 'test-mbsid', 'k8gzbsc', 5000, '2022-10-23', '03:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE `note` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(500) NOT NULL,
  `account` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`id`, `message`, `date`, `image`, `account`) VALUES
(1, 'test', '2022-12-09 22:58:09', 'catatan-221209-210536ea0b.jpeg', 'Adi Darmawan');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `oid` varchar(100) NOT NULL,
  `idpel` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `paket` varchar(100) NOT NULL,
  `status` enum('Active','Isolir') NOT NULL,
  `billpriod` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `ipstatik` varchar(100) DEFAULT NULL,
  `date` date NOT NULL,
  `expdate` datetime NOT NULL,
  `pppoe_user` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `oid`, `idpel`, `nama`, `paket`, `status`, `billpriod`, `jenis`, `ipstatik`, `date`, `expdate`, `pppoe_user`) VALUES
(1, '169809668926401', 'P-0001', 'Adi Darmawan', 'Paket Internet 10Mbps', 'Active', 'none', 'statis', '192.168.55.2', '2022-09-19', '2022-12-30 00:00:00', ''),
(6, '584642134910528', 'P-0002', 'Syara', 'Paket Internet 10Mbps', 'Active', 'none', 'dinamis', NULL, '2022-12-01', '2022-12-30 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders_voucher`
--

CREATE TABLE `orders_voucher` (
  `id` int(11) NOT NULL,
  `oid` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `service` varchar(50) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `date` date NOT NULL,
  `comment` text DEFAULT NULL,
  `status_v` enum('Belum digunakan','Sudah digunakan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orders_voucher`
--

INSERT INTO `orders_voucher` (`id`, `oid`, `email`, `service`, `kode`, `harga`, `date`, `comment`, `status_v`) VALUES
(1, '5732058', 'adarmawan106@gmail.com', 'test-mbsid', 'hvipre2', 2000, '2022-09-19', NULL, 'Sudah digunakan'),
(2, '9418336', 'adarmawan106@gmail.com', 'test-mbsid', 'vjt3vda', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(3, '2003056', 'adarmawan106@gmail.com', 'test-mbsid', '32v5k8y', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(4, '7097865', 'adarmawan106@gmail.com', 'test-mbsid', 'k64eupz', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(5, '8697691', 'adarmawan106@gmail.com', 'test-mbsid', 'szm56hj', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(6, '5023656', 'adarmawan106@gmail.com', 'test-mbsid', 'gs5xntp', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(7, '9924552', 'adarmawan106@gmail.com', 'test-mbsid', '2ci643n', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(8, '1962000', 'adarmawan106@gmail.com', 'test-mbsid', 'x9fw9cz', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(9, '5120235', 'adarmawan106@gmail.com', 'test-mbsid', 'k8gzbsc', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(10, '7398735', 'adarmawan106@gmail.com', 'test-mbsid', '6eug6zb', 2000, '2022-09-19', NULL, 'Belum digunakan'),
(11, '6906253', 'admin@mbsid.my.id', 'test-mbsid', 'ucrtp', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(12, '4741449', 'admin@mbsid.my.id', 'test-mbsid', 'jft6r', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(13, '3689045', 'admin@mbsid.my.id', 'test-mbsid', 'dthtm', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(14, '7513918', 'admin@mbsid.my.id', 'test-mbsid', 'jwp5x', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(15, '6134982', 'admin@mbsid.my.id', 'test-mbsid', '7v237', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(16, '1894913', 'admin@mbsid.my.id', 'test-mbsid', 'srkzb', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(17, '1769404', 'admin@mbsid.my.id', 'test-mbsid', '4thg8', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(18, '0239821', 'admin@mbsid.my.id', 'test-mbsid', 'xf5s3', 2000, '2022-10-07', 'test-api', 'Belum digunakan'),
(19, '8374550', 'admin@mbsid.my.id', 'test-mbsid', 't5ypu', 2000, '2022-10-12', 'test-api', 'Belum digunakan'),
(20, '3324422', 'admin@mbsid.my.id', 'test-mbsid', 'wby9n', 2000, '2022-10-19', 'test-api', 'Belum digunakan'),
(21, '9165330', 'admin@mbsid.my.id', 'test-mbsid', 'r8xif', 2000, '2022-10-19', 'test-api', 'Belum digunakan'),
(22, '8907510', 'admin@mbsid.my.id', 'test-mbsid', '92ib6', 2000, '2022-10-19', 'test-api', 'Belum digunakan'),
(23, '9029796', 'admin@mbsid.my.id', 'test-mbsid', 'jg93k', 2000, '2022-10-19', 'test-api', 'Belum digunakan'),
(24, '1451281', 'adarmawan106@gmail.com', 'test-mbsid', 'cesnd', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(25, '0322192', 'adarmawan106@gmail.com', 'test-mbsid', '53die', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(26, '2093056', 'adarmawan106@gmail.com', 'test-mbsid', 'd8zy4', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(27, '5409875', 'adarmawan106@gmail.com', 'test-mbsid', 'cm3rj', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(28, '6259797', 'adarmawan106@gmail.com', 'test-mbsid', 'xs25b', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(29, '7397282', 'adarmawan106@gmail.com', 'test-mbsid', '4hbzi', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(30, '8328480', 'adarmawan106@gmail.com', 'test-mbsid', 'vteiw', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(31, '9270370', 'adarmawan106@gmail.com', 'test-mbsid', '8tifp', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(32, '0305677', 'adarmawan106@gmail.com', 'test-mbsid', 'v73bh', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(33, '1086000', 'adarmawan106@gmail.com', 'test-mbsid', 'brgyg', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(34, '8949466', 'adarmawan106@gmail.com', 'test-mbsid', 'p68cr', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(35, '3716674', 'adarmawan106@gmail.com', 'test-mbsid', 'x9pnf', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(36, '3758680', 'adarmawan106@gmail.com', 'test-mbsid', 'tzdbs', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(37, '9328658', 'adarmawan106@gmail.com', 'test-mbsid', 'dwrxg', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(38, '4805991', 'adarmawan106@gmail.com', 'test-mbsid', 'pd7w7', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(39, '9949880', 'adarmawan106@gmail.com', 'test-mbsid', 'f8pj5', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(40, '8067061', 'adarmawan106@gmail.com', 'test-mbsid', '9p328', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(41, '8530787', 'adarmawan106@gmail.com', 'test-mbsid', '23nvj', 2000, '2022-12-12', NULL, 'Belum digunakan'),
(42, '1899854', 'adarmawan106@gmail.com', 'test-mbsid', 'xxm6c', 2000, '2022-12-13', NULL, 'Belum digunakan');

-- --------------------------------------------------------

--
-- Table structure for table `payment_cat`
--

CREATE TABLE `payment_cat` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `payment_cat`
--

INSERT INTO `payment_cat` (`id`, `name`, `category`, `status`) VALUES
(1, 'Bank', 'BK', '0'),
(2, 'Dompet Digital', 'DG', '1'),
(3, 'Virtual Account', 'VA', '1'),
(4, 'Retail', 'RTL', '1'),
(5, 'CASH', 'CSH', '1');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateway`
--

CREATE TABLE `payment_gateway` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code_merchant` varchar(200) NOT NULL,
  `api_url` varchar(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `private_key` varchar(200) NOT NULL,
  `callback` varchar(10) NOT NULL,
  `status` enum('enable','disable') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `payment_gateway`
--

INSERT INTO `payment_gateway` (`id`, `name`, `code_merchant`, `api_url`, `api_key`, `private_key`, `callback`, `status`) VALUES
(1, 'tripay', 'T0535', 'https://tripay.co.id/api-sandbox', 'DEV-MbMX2QMMvM3djRJU8C6u1TBNOOom6xGOxuuTvjmX', '8EqkX-XwY8S-kQveq-sYwv4-ukQM4', '1', 'enable');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `no_rekening` varchar(100) NOT NULL,
  `atas_nama` varchar(200) NOT NULL,
  `note` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `service` text NOT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_code` varchar(50) DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `name`, `no_rekening`, `atas_nama`, `note`, `category`, `service`, `provider`, `provider_code`, `status`) VALUES
(1, 'Maybank Virtual Account', '', '', '', 'VA', 'Maybank Virtual Account', 'tripay', 'MYBVA', '1'),
(2, 'Permata Virtual Account', '', '', '', 'VA', 'Permata Virtual Account', 'tripay', 'PERMATAVA', '1'),
(3, 'BNI Virtual Account', '', '', '', 'VA', 'BNI Virtual Account', 'tripay', 'BNIVA', '1'),
(4, 'BRI Virtual Account', '', '', '', 'VA', 'BRI Virtual Account', 'tripay', 'BRIVA', '1'),
(5, 'Mandiri Virtual Account', '', '', '', 'VA', 'Mandiri Virtual Account', 'tripay', 'MANDIRIVA', '1'),
(6, 'BCA Virtual Account', '', '', '', 'VA', 'BCA Virtual Account', 'tripay', 'BCAVA', '0'),
(7, 'Sinarmas Virtual Account', '', '', '', 'VA', 'Sinarmas Virtual Account', 'tripay', 'SMSVA', '1'),
(8, 'Muamalat Virtual Account', '', '', '', 'VA', 'Muamalat Virtual Account', 'tripay', 'MUAMALATVA', '1'),
(9, 'CIMB Virtual Account', '', '', '', 'VA', 'CIMB Virtual Account', 'tripay', 'CIMBVA', '1'),
(10, 'Sahabat Sampoerna Virtual Account', '', '', '', 'VA', 'Sahabat Sampoerna Virtual Account', 'tripay', 'SAMPOERNAVA', '1'),
(11, 'BSI Virtual Account', '', '', '', 'VA', 'BSI Virtual Account', 'tripay', 'BSIVA', '1'),
(12, 'Alfamart', '', '', '', 'RTL', 'Alfamart', 'tripay', 'ALFAMART', '1'),
(13, 'Indomaret', '', '', '', 'RTL', 'Indomaret', 'tripay', 'INDOMARET', '1'),
(14, 'Alfamidi', '', '', '', 'RTL', 'Alfamidi', 'tripay', 'ALFAMIDI', '1'),
(15, 'QRIS (ShopeePay)', '', '', '', 'DG', 'QRIS (ShopeePay)', 'tripay', 'QRIS', '1'),
(17, 'Tunai ( Bayar di kantor )', '', '', 'Langsung menuju ke kantor kami dengan membawa uang yang sudah ditentukan di sistem dan juga membawa kode pelanggan / identitas diri sesuai awal pertama kali berlangganan', 'CSH', 'Tunai ( Bayar di kantor )', '', '', '1'),
(18, 'QRIS', '', '', '', 'DG', 'QRIS', 'tripay', 'QRIS2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pool`
--

CREATE TABLE `pool` (
  `id` int(11) NOT NULL,
  `pool_host` varchar(200) NOT NULL,
  `pool_range` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `category` enum('Pemasukan','Pengeluaran') NOT NULL,
  `balance` int(11) NOT NULL,
  `asal` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE `router` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `dns` text NOT NULL,
  `ip` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `traffic-interface` varchar(10) NOT NULL,
  `status` enum('Active','Not Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `paket` varchar(200) NOT NULL,
  `harga` float NOT NULL,
  `ppn` float NOT NULL,
  `status` enum('Tersedia','Tidak Tersedia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `paket`, `harga`, `ppn`, `status`) VALUES
(1, 'Paket Internet 10Mbps', 150000, 11, 'Tersedia'),
(2, 'Paket Internet 20Mbps', 210000, 11, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `services_voucher`
--

CREATE TABLE `services_voucher` (
  `id` int(11) NOT NULL,
  `service` text NOT NULL,
  `shared` text NOT NULL,
  `ratelimit` text NOT NULL,
  `timelimit` text NOT NULL,
  `uptime` text NOT NULL,
  `harga` double NOT NULL,
  `status` enum('Active','Not Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `services_voucher`
--

INSERT INTO `services_voucher` (`id`, `service`, `shared`, `ratelimit`, `timelimit`, `uptime`, `harga`, `status`) VALUES
(1, 'test-mbsid', '1', '1M/2M', '4h', '30d', 2000, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `setting_voucher`
--

CREATE TABLE `setting_voucher` (
  `id` int(11) NOT NULL,
  `server` varchar(200) NOT NULL,
  `lenght` varchar(200) NOT NULL,
  `karakter` varchar(200) NOT NULL,
  `template` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `setting_voucher`
--

INSERT INTO `setting_voucher` (`id`, `server`, `lenght`, `karakter`, `template`) VALUES
(1, 'all', '5', 'mix', '');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_setting`
--

CREATE TABLE `smtp_setting` (
  `id` int(11) NOT NULL,
  `api_key` text NOT NULL,
  `nama_smtp` varchar(100) NOT NULL,
  `email_smtp` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp_setting`
--

INSERT INTO `smtp_setting` (`id`, `api_key`, `nama_smtp`, `email_smtp`) VALUES
(1, '000', '000', '000');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL,
  `last_update` datetime NOT NULL,
  `status` enum('Pending','Responded','Closed','Waiting') NOT NULL,
  `seen_user` enum('0','1') NOT NULL,
  `seen_admin` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `code`, `user`, `subject`, `message`, `datetime`, `last_update`, `status`, `seen_user`, `seen_admin`) VALUES
(1, '372696580045842', 'adarmawan106@gmail.com', 'Isi Saldo', 'isi saldo tidak masuk', '2022-12-12 11:48:27', '2022-12-12 11:48:27', 'Pending', '0', '0'),
(2, '777518256532795', 'adarmawan106@gmail.com', 'HALO', 'HALO', '2022-12-12 13:36:24', '2022-12-12 14:43:13', 'Waiting', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_message`
--

CREATE TABLE `tickets_message` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `sender` enum('User','Admin') NOT NULL,
  `user` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets_message`
--

INSERT INTO `tickets_message` (`id`, `ticket_id`, `sender`, `user`, `message`, `datetime`) VALUES
(1, 2, 'User', 'adarmawan106@gmail.com', 'bales', '2022-12-12 14:07:31'),
(2, 2, 'User', 'adarmawan106@gmail.com', 'cobalagi', '2022-12-12 14:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `token_user`
--

CREATE TABLE `token_user` (
  `id` int(11) NOT NULL,
  `data_token` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_create` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nomor` varchar(15) NOT NULL,
  `password` text NOT NULL,
  `balance` int(11) NOT NULL,
  `level` enum('admin','user','member','reseller','developer','cs') NOT NULL,
  `status_account` enum('Active','Non Active') NOT NULL,
  `komisi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `nama`, `nomor`, `password`, `balance`, `level`, `status_account`, `komisi`) VALUES
(1, 'admin@mbsid.my.id', 'Adi Darmawan', '081286228136', '$2y$10$yVlTkj4JldCwPCFWRImBcudQhONOEHb/ZQCeV7m1oCgehiRJkEJl.', 110944, 'developer', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `komisi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `logo_text` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `keyword` text NOT NULL,
  `author` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `title`, `logo`, `logo_text`, `description`, `keyword`, `author`) VALUES
(1, 'MBS ID', 'logo-221229-760e548c28.png', 'MBSID', '', '', 'Adi Darmawan');

-- --------------------------------------------------------

--
-- Table structure for table `whatsapp`
--

CREATE TABLE `whatsapp` (
  `id` int(11) NOT NULL,
  `no_owner` varchar(15) NOT NULL,
  `sender` varchar(15) NOT NULL,
  `tagihan_manual` text NOT NULL,
  `tagihan_otomatis` text NOT NULL,
  `tagihan_terbayar` text NOT NULL,
  `register` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `whatsapp`
--

INSERT INTO `whatsapp` (`id`, `no_owner`, `sender`, `tagihan_manual`, `tagihan_otomatis`, `tagihan_terbayar`, `register`, `status`) VALUES
(4, '085157918225', '085161781291', '', 'Halo Bapak/Ibu yang terhormat,\r\n\r\nID Pelanggan : {id_pelanggan}\r\n\r\ntagihan anda bulan ini sudah terbit dengan nomor invoice :\r\n*{nomor_invoice}*\r\n\r\nApabila tagihan tersebut sampai jatuh tempo belum terbayar maka internet anda otomatis terisolir \r\n\r\n\r\nJatuh tempo pada tanggal \r\n{expdate}\r\n\r\nSilakan Masuk ke halaman web dibawah ini untuk melakukan pembayaran tagihan anda\r\n\r\nLink Website : \r\n{link_web}\r\n\r\nTerimakasih', 'Halo, {nama_customer}\r\n\r\nDengan ID Pelanggan : {id_pelanggan}\r\n\r\nTagihan anda dengan nomor invoice : \r\n{nomor_invoice}\r\n\r\nSudah terbayar\r\n\r\nTerimakasih', 'Terimakasih, anda telah bergabung menjadi pelanggan FIber Delta Network\r\n\r\nDengan ID Pelanggan : {id_pelanggan}\r\n\r\ninformasi akun member area anda adalah : \r\nEmail : {email} \r\nNomor Handphone : {nohp}\r\nPassword : {password}\r\n\r\nSilahkan Masuk ke member area kami untuk melakukan perubahan password pada akun anda \r\n\r\nLink Website : \r\n{link_web}\r\n\r\n\r\nInformasi: \r\nMember area kami di khusus kan untuk membayar tagihan dan juga untuk melihat jatuh tempo layanan internet anda\r\n\r\nNb : Anda bisa masuk ke member area kami dengan email ataupun nomor handphone yg sudah anda kirimkan pada saat pengisian form pemasangan baru\r\n\r\nTerimakasih', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agen`
--
ALTER TABLE `agen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `balance_history`
--
ALTER TABLE `balance_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bot_telegram`
--
ALTER TABLE `bot_telegram`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kat_voucher`
--
ALTER TABLE `kat_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs_voucher`
--
ALTER TABLE `logs_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_voucher`
--
ALTER TABLE `orders_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_cat`
--
ALTER TABLE `payment_cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pool`
--
ALTER TABLE `pool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `router`
--
ALTER TABLE `router`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services_voucher`
--
ALTER TABLE `services_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_voucher`
--
ALTER TABLE `setting_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets_message`
--
ALTER TABLE `tickets_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `token_user`
--
ALTER TABLE `token_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `whatsapp`
--
ALTER TABLE `whatsapp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agen`
--
ALTER TABLE `agen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balance_history`
--
ALTER TABLE `balance_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bot_telegram`
--
ALTER TABLE `bot_telegram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `kat_voucher`
--
ALTER TABLE `kat_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `logs_voucher`
--
ALTER TABLE `logs_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `note`
--
ALTER TABLE `note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders_voucher`
--
ALTER TABLE `orders_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `payment_cat`
--
ALTER TABLE `payment_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_gateway`
--
ALTER TABLE `payment_gateway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pool`
--
ALTER TABLE `pool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `router`
--
ALTER TABLE `router`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services_voucher`
--
ALTER TABLE `services_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting_voucher`
--
ALTER TABLE `setting_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_setting`
--
ALTER TABLE `smtp_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tickets_message`
--
ALTER TABLE `tickets_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `token_user`
--
ALTER TABLE `token_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `whatsapp`
--
ALTER TABLE `whatsapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
