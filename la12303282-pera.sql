-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2022 at 10:48 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql6477000`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booth`
--

CREATE TABLE `tbl_booth` (
  `id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `booth_name` varchar(10) NOT NULL,
  `box_id` int(2) UNSIGNED NOT NULL DEFAULT 0,
  `status` int(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 : sale\r\n1 : sold\r\n2: pause\r\n3: pause and sale'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_booth`
--

INSERT INTO `tbl_booth` (`id`, `booth_name`, `box_id`, `status`) VALUES
(1, 'T-1', 0, 0),
(2, 'U-1', 0, 0),
(3, 'V-1', 0, 0),
(4, 'W-1', 0, 0),
(5, 'X-1', 0, 0),
(6, 'T-2', 0, 0),
(7, 'U-2', 0, 0),
(8, 'V-2', 0, 0),
(9, 'W-2', 0, 0),
(10, 'X-2', 0, 0),
(11, 'T-3', 0, 0),
(12, 'U-3', 0, 0),
(13, 'V-3', 0, 0),
(14, 'W-3', 0, 0),
(15, 'X-3', 0, 0),
(16, 'T-4', 0, 0),
(17, 'U-4', 0, 0),
(18, 'V-4', 0, 0),
(19, 'W-4', 0, 0),
(20, 'X-4', 0, 0),
(21, 'T-5', 0, 0),
(22, 'U-5', 0, 0),
(23, 'V-5', 0, 0),
(24, 'W-5', 0, 0),
(25, 'L-1', 1, 0),
(26, 'M-1', 1, 0),
(27, 'N-1', 1, 0),
(28, 'O-1', 1, 0),
(29, 'P-1', 1, 0),
(30, 'Q-1', 1, 0),
(31, 'R-1', 1, 0),
(32, 'S-1', 1, 0),
(33, 'L-2', 1, 0),
(34, 'M-2', 1, 0),
(35, 'N-2', 1, 0),
(36, 'O-2', 1, 0),
(37, 'P-2', 1, 0),
(38, 'Q-2', 1, 0),
(39, 'R-2', 1, 0),
(40, 'S-2', 1, 0),
(41, 'L-3', 1, 0),
(42, 'M-3', 1, 0),
(43, 'N-3', 1, 0),
(44, 'O-3', 1, 0),
(45, 'P-3', 1, 0),
(46, 'Q-3', 1, 0),
(47, 'R-3', 1, 0),
(48, 'S-3', 1, 0),
(49, 'L-4', 1, 0),
(50, 'M-4', 1, 0),
(51, 'N-4', 1, 0),
(52, 'O-4', 1, 0),
(53, 'P-4', 1, 0),
(54, 'Q-4', 1, 0),
(55, 'R-4', 1, 0),
(56, 'S-4', 1, 0),
(57, 'AB-1', 3, 0),
(58, 'C-1', 2, 0),
(59, 'D-1', 2, 0),
(60, 'E-1', 2, 0),
(61, 'F-1', 2, 0),
(62, 'G-1', 2, 0),
(63, 'H-1', 2, 0),
(64, 'J-1', 2, 0),
(65, 'K-1', 2, 0),
(66, 'AB-2', 3, 0),
(67, 'C-2', 2, 0),
(68, 'D-2', 2, 0),
(69, 'E-2', 2, 0),
(70, 'F-2', 2, 0),
(71, 'G-2', 2, 0),
(72, 'H-2', 2, 0),
(73, 'J-2', 2, 0),
(74, 'K-2', 2, 0),
(75, 'AB-3', 3, 0),
(76, 'C-3', 2, 0),
(77, 'D-3', 2, 0),
(78, 'E-3', 2, 0),
(79, 'F-3', 2, 0),
(80, 'G-3', 2, 0),
(81, 'H-3', 2, 0),
(82, 'J-3', 2, 0),
(83, 'K-3', 2, 0),
(84, 'AB-4', 3, 0),
(85, 'C-4', 2, 0),
(86, 'D-4', 2, 0),
(87, 'E-4', 2, 0),
(88, 'F-4', 2, 0),
(89, 'G-4', 2, 0),
(90, 'H-4', 2, 0),
(91, 'J-4', 2, 0),
(92, 'K-4', 2, 0),
(93, 'AB-5', 3, 0),
(94, 'C-5', 2, 0),
(95, 'D-5', 2, 0),
(96, 'E-5', 2, 0),
(97, 'F-5', 2, 0),
(98, 'G-5', 2, 0),
(99, 'H-5', 2, 0),
(100, 'J-5', 2, 0),
(101, 'K-5', 2, 0),
(102, 'AB-6', 3, 0),
(103, 'C-6', 2, 0),
(104, 'D-6', 2, 0),
(105, 'E-6', 2, 0),
(106, 'F-6', 2, 0),
(107, 'G-6', 2, 0),
(108, 'H-6', 2, 0),
(109, 'J-6', 2, 0),
(110, 'K-6', 2, 0),
(111, 'AB-7', 3, 0),
(112, 'C-7', 2, 0),
(113, 'D-7', 2, 0),
(114, 'E-7', 2, 0),
(115, 'F-7', 2, 0),
(116, 'G-7', 2, 0),
(117, 'H-7', 2, 0),
(118, 'J-7', 2, 0),
(119, 'K-7', 2, 0),
(120, 'AB-8', 3, 0),
(121, 'C-8', 2, 0),
(122, 'D-8', 2, 0),
(123, 'E-8', 2, 0),
(124, 'F-8', 2, 0),
(125, 'WH-1', 4, 0),
(126, 'WH-2', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_box`
--

CREATE TABLE `tbl_box` (
  `id` int(2) UNSIGNED NOT NULL,
  `box_name` varchar(50) NOT NULL,
  `seat_count` int(4) UNSIGNED NOT NULL,
  `price_regular` int(11) UNSIGNED NOT NULL,
  `price_night` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_box`
--

INSERT INTO `tbl_box` (`id`, `box_name`, `seat_count`, `price_regular`, `price_night`) VALUES
(0, '口イヤルボックス', 24, 3000, 2000),
(1, '口イヤルシート', 32, 3000, 2000),
(2, 'ペラ坊シート', 60, 2000, 2000),
(3, 'ペアシート', 8, 4000, 2000),
(4, '車椅子シート', 2, 2000, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_time`
--

CREATE TABLE `tbl_time` (
  `id` int(10) UNSIGNED DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_time`
--

INSERT INTO `tbl_time` (`id`, `start_time`, `end_time`) VALUES
(0, '00:00:00', '16:29:59'),
(1, '16:30:00', '23:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `id` int(11) UNSIGNED NOT NULL,
  `booth_id` int(11) UNSIGNED NOT NULL,
  `status` int(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 : sale\r\n1 : sold\r\n2 : pause\r\n3: not sale ',
  `booth_name` varchar(20) NOT NULL,
  `booth_type` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL COMMENT '\r\n',
  `price` varchar(50) NOT NULL,
  `age` varchar(20) NOT NULL,
  `entrance_time` datetime DEFAULT NULL,
  `exit_time` datetime DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `is_deleted` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 : undeleted\r\n1 : deleted '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `logout_time` datetime DEFAULT NULL,
  `is_selected` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 : deselect\r\n1 : selected ',
  `is_deleted` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 : undelete\r\n1: deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `user_name`, `login_time`, `logout_time`, `is_selected`, `is_deleted`) VALUES
(1, 'admin', '0000-00-00 00:00:00', NULL, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_booth`
--
ALTER TABLE `tbl_booth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_box`
--
ALTER TABLE `tbl_box`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_transactions`
--
ALTER TABLE `tbl_transactions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
