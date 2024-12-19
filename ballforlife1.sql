-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 12:40 PM
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
(1, 'micholrobles27@gmail.com', '845674', '2024-12-13 18:44:48'),
(9, 'twixnamakulet@gmail.com', '206177', '2024-12-13 19:31:41'),
(10, 'twixnamakulet@gmail.com', '940237', '2024-12-13 19:33:46'),
(11, 'twixnamakulet@gmail.com', '922984', '2024-12-13 19:35:17'),
(12, 'twixnamakulet@gmail.com', '918055', '2024-12-13 19:38:45'),
(13, 'twixnamakulet@gmail.com', '400057', '2024-12-13 19:39:42'),
(14, 'twixnamakulet@gmail.com', '662099', '2024-12-13 19:45:29'),
(15, 'twixnamakulet@gmail.com', '928775', '2024-12-13 19:57:23'),
(16, 'twixnamakulet@gmail.com', '210614', '2024-12-13 20:00:25'),
(17, 'twixnamakulet@gmail.com', '529052', '2024-12-13 20:01:18'),
(18, 'twixnamakulet@gmail.com', '776038', '2024-12-13 20:01:37');

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
(43, 'First Game of the Year', 'This is a game for a cause', 'Uncle Drew Court', '2024-12-16 17:00:00', '2024-12-16 22:00:00', '#0000ff', '#ffffff', 20, '500', 'Please bring towels, bottles, and extra money.', '2024-12-14 16:26:28', 0, '2024-12-14 16:26:28'),
(44, 'BATTLE OF THE BALLERS GAMERS', 'DFJKGSAHFJKSAHDGJKFHASDKL', 'FDJSKAHFKSA', '2024-12-17 16:00:00', '2024-12-17 17:00:00', '#800000', '#ffffff', 12, '500', '', '2024-12-17 17:37:45', 0, '2024-12-17 17:49:18'),
(45, 'testing ', 'fgkdshjagfhjk', 'testing', '2024-12-19 17:00:00', '2024-12-20 20:00:00', '#800000', '#ffffff', 15, '100', '', '2024-12-17 17:58:00', 0, '2024-12-17 18:14:42'),
(46, 'testing ulefdasssssssssssssssssss', 'dfsafdas', 'testing ulefdsjklakkakakakakakakakakaka', '2024-12-13 15:00:00', '2024-12-13 18:00:00', '#800000', '#ffffff', 123, '123', '', '2024-12-17 18:02:18', 0, '2024-12-17 18:03:01');

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
(13, 76, 43, 'images/uploads/receipts/76_Drivers License.jpg', 'Joined', NULL, '2024-12-14 16:27:09', 0, '2024-12-14 16:27:36'),
(14, 62, 46, 'images/uploads/receipts/62_ROBLES, MICHOL JOHN CAYETANO 5750.jpg', 'Pending', NULL, '2024-12-17 18:02:34', 0, '2024-12-17 18:02:34'),
(15, 62, 45, 'images/uploads/receipts/76_Drivers License.jpg', 'Pending', NULL, '2024-12-17 18:06:54', 0, '2024-12-17 18:06:54');

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
(75, 'User', 'images/uploads/cover-photo.jpg', 'images/uploads/user.png', 'Mauenice', '', '', 'Member', NULL, NULL, NULL, NULL, 'mauenice188@gmail.com', '$2y$10$4GYlGZR3rC0pdjcSlvi0AeuoD6FhoFY8kUpmlzQhVeCLGcs8ZGnaW', 'Active', '2024-12-13 19:51:37', 0, '2024-12-14 16:04:37'),
(76, 'User', 'images/uploads/cover-photo.jpg', 'images/uploads/user.png', 'Twix', 'Jiao', '09283716232', 'Member', 0, 0, 0, 'null', 'twixnamakulet@gmail.com', '$2y$10$XhKanauNq5QutOrv88lXAe0X5D0RMHHDY04/1n5VlB0P17lfK8TQu', 'Active', '2024-12-13 20:02:13', 0, '2024-12-14 16:04:41');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `schedules-appointment`
--
ALTER TABLE `schedules-appointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
