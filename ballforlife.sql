-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 06:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ballforlife`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `ID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`ID`, `email`, `otp`, `created_at`) VALUES
(1, 'twixnamakulet@gmail.com', '604406', '2025-02-13 15:34:51'),
(2, 'twixnamakulet@gmail.com', '427063', '2025-02-13 15:37:24'),
(3, 'twixnamakulet@gmail.com', '384877', '2025-02-13 15:38:42'),
(4, 'twixnamakulet@gmail.com', '365600', '2025-02-13 15:41:33'),
(5, 'twixnamakulet@gmail.com', '418522', '2025-02-13 15:42:08'),
(6, 'twixnamakulet@gmail.com', '455871', '2025-02-13 15:42:57'),
(7, 'twixnamakulet@gmail.com', '930272', '2025-02-13 15:45:38'),
(8, 'twixnamakulet@gmail.com', '509022', '2025-02-13 15:48:18'),
(9, 'twixnamakulet@gmail.com', '631913', '2025-02-13 15:50:54'),
(10, 'twixnamakulet@gmail.com', '127161', '2025-02-13 15:54:46'),
(11, 'twixnamakulet@gmail.com', '764546', '2025-02-13 15:55:24'),
(12, 'twixnamakulet@gmail.com', '797176', '2025-02-13 15:59:16'),
(13, 'twixnamakulet@gmail.com', '124583', '2025-02-13 16:00:40');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `ID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `venue` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `color` varchar(10) NOT NULL,
  `textColor` varchar(10) NOT NULL,
  `maxPlayer` int(11) NOT NULL,
  `gameFee` varchar(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`ID`, `title`, `description`, `venue`, `startDate`, `endDate`, `color`, `textColor`, `maxPlayer`, `gameFee`, `notes`, `created_at`, `is_deleted`, `updated_at`) VALUES
(1, '1st Game', 'Game for A Cause', 'Uncle Drew Court', '2025-02-14 18:00:00', '2025-02-14 21:00:00', '#ff00ff', '#ffffff', 30, '500', 'Bring money, towels, and water.', '2025-02-13 16:11:00', 0, '2025-02-13 16:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `schedules-appointment`
--

CREATE TABLE `schedules-appointment` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `schedID` int(11) NOT NULL,
  `receipt` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules-appointment`
--

INSERT INTO `schedules-appointment` (`ID`, `userID`, `schedID`, `receipt`, `status`, `remarks`, `created_at`, `is_deleted`, `updated_at`) VALUES
(1, 85, 1, 'images/uploads/receipts/85_ROBLES, MICHOL JOHN CAYETANO 5750.jpg', 'Rejected', NULL, '2025-02-13 16:12:02', 0, '2025-02-13 16:13:55'),
(2, 86, 1, 'images/uploads/receipts/86_WIN_20240619_18_34_43_Pro.jpg', 'Joined', NULL, '2025-02-13 16:18:10', 0, '2025-02-13 16:18:37');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `role` text NOT NULL,
  `coverPhoto` varchar(255) NOT NULL,
  `profilePic` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `contactnum` char(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `heightFeet` int(2) DEFAULT NULL,
  `heightInch` int(2) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `role`, `coverPhoto`, `profilePic`, `firstname`, `lastname`, `contactnum`, `position`, `heightFeet`, `heightInch`, `weight`, `skills`, `email`, `password`, `status`, `created_at`, `is_deleted`, `updated_at`) VALUES
(62, 'Admin', 'images/uploads/cover-photos/62_cover_photo.jpg', 'images/uploads/user.png', 'Michol John', 'Robles', '', 'Member', 0, 0, 0, 'null', 'micholrobles27@gmail.com', '', 'Active', '2024-11-18 12:55:26', 0, '2024-12-13 17:37:23'),
(85, 'User', 'images/uploads/cover-photo.jpg', 'images/uploads/user.png', 'Twix', 'Kulet', '09230853052', 'Member', NULL, NULL, NULL, NULL, 'twixnamakulet@gmail.com', '$2y$10$bnF9BILuHa5xm3VFbcsAJuSuTSUnFPeEigqS2a1/pa3PlD0b.SnLW', 'Active', '2025-02-13 16:00:58', 0, '2025-02-13 16:09:02'),
(86, 'User', 'images/uploads/cover-photo.jpg', 'images/uploads/user.png', 'Mauenice', '', '', 'Member', NULL, NULL, NULL, NULL, 'mauenice188@gmail.com', '$2y$10$GPbTDrrQAbs4Ns6wAca4i.wjZ4KQLZxEJX5q02PTuh8MAUS8XHzb6', 'Active', '2025-02-13 16:15:11', 0, '2025-02-13 16:17:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `schedules-appointment`
--
ALTER TABLE `schedules-appointment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_userID` (`userID`),
  ADD KEY `fk_schedID` (`schedID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules-appointment`
--
ALTER TABLE `schedules-appointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedules-appointment`
--
ALTER TABLE `schedules-appointment`
  ADD CONSTRAINT `fk_schedID` FOREIGN KEY (`schedID`) REFERENCES `schedules` (`ID`),
  ADD CONSTRAINT `fk_userID` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
