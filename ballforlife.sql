-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 02:35 PM
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
  `notes` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`ID`, `title`, `description`, `venue`, `startDate`, `endDate`, `color`, `textColor`, `maxPlayer`, `notes`, `created_at`, `is_deleted`, `updated_at`) VALUES
(28, '1st Event', '1st Description', '1st Venue', '2024-11-20 17:00:00', '2024-11-21 19:00:00', '#000000', '#ffffff', 5, '1st Notes', '2024-11-20 19:41:29', 0, '2024-11-20 19:41:29'),
(29, '2nd Event', '2nd Description', '2nd Venue', '2024-11-21 08:00:00', '2024-11-21 10:00:00', '#800000', '#ffffff', 10, '2nd Notes', '2024-11-20 19:43:21', 0, '2024-11-20 19:43:21'),
(30, '3rd Event', '3rd Description', '3rd Venue', '2024-11-20 18:00:00', '2024-11-20 19:00:00', '#0000ff', '#ffffff', 11, '3rd Notes', '2024-11-20 19:44:11', 0, '2024-11-20 19:44:11'),
(31, '4th Event', '4th Description', '4th Venue', '2024-11-20 20:00:00', '2024-11-20 21:10:00', '#ffff00', '#000000', 20, '4th Notes', '2024-11-20 19:45:34', 0, '2024-11-20 21:09:06'),
(32, '5th Title', '5th Description', '5th Venue', '2024-11-12 20:05:00', '2024-11-15 20:10:00', '#00ff00', '#000000', 30, '5th Notes', '2024-11-20 20:04:34', 0, '2024-11-20 21:22:27');

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
(10, 'Admin', 'images/uploads/cover-photos/10_cover_photo2.png', 'images/uploads/profiles/10_user.png', 'Mico', 'Robles', '09230853051', 'Point Guard', 6, 12, 90, '[\"Shooting\",\"Passing\",\"Rebounding\"]', 'mic@gmail.com', '$2y$10$wVGE3lLeHpMb5Pt70Bjs1uDjXAepe6IlTvzwP3wFmTwt1pXrny73O', 'Active', '2024-10-16 15:18:18', 0, '2024-11-18 12:00:03'),
(12, 'Admin', 'images/uploads/cover-photos/12_cover_photo.jpg', 'images/uploads/profiles/12_Signature.jpg', 'Lyka', 'Jiao', '09398192788', 'Center', 5, 4, 60, '[\"Coast2Coast\"]', 'lyka@gmail.com', '$2y$10$mD1xIc9bNBnZfZztpMlqCu9SzsRwhEXROt4S/mpBQGPe1YDgOLgyS', 'Active', '2024-10-16 15:48:11', 0, '2024-11-16 15:29:49'),
(57, 'User', '', 'images/uploads/profiles/57_user.png', 'Juan', 'Cruz', '09283748232', 'Member', 0, 0, 0, '[\"Rebounding\"]', 'juan@gmail.com', '$2y$10$itakTUptqgIN29PMCiildeBDppQJVamETquU9uMMl3p4aLHBBOnV6', 'Active', '2024-11-15 19:11:19', 0, '2024-11-16 20:46:20'),
(62, 'User', 'images/uploads/cover-photos/62_cover_photo.jpg', 'images/uploads/user.png', 'Michol John', 'Robles', '', 'Member', 0, 0, 0, 'null', 'micholrobles27@gmail.com', '', 'Pending', '2024-11-18 12:55:26', 0, '2024-11-18 13:24:00'),
(63, 'User', 'images/uploads/cover-photos/63_cover_photo2.png', 'images/uploads/profiles/63_ROBLES.jpg', 'Mauenice', '', '', 'Member', 0, 0, 0, 'null', 'mauenice188@gmail.com', '', 'Pending', '2024-11-18 12:56:28', 0, '2024-11-18 12:56:57'),
(64, 'User', 'images/uploads/cover-photo.jpg', 'images/uploads/user.png', 'John', 'Wick', '', 'Member', NULL, NULL, NULL, NULL, 'twixnamakulet@gmail.com', '', 'Pending', '2024-11-18 18:12:59', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
