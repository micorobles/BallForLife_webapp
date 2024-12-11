-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 10:22 AM
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
(28, '1st Event', '1st Description', '1st Venue', '2024-11-20 17:00:00', '2024-11-22 19:00:00', '#000000', '#ffffff', 5, '', '1st Notes', '2024-11-20 19:41:29', 0, '2024-11-21 04:15:47'),
(29, '2nd Event', '2nd Description', '2nd Venue', '2024-11-21 08:00:00', '2024-11-21 10:10:00', '#800000', '#ffffff', 10, '', '2nd Notes', '2024-11-20 19:43:21', 0, '2024-11-21 04:14:19'),
(30, '3rd Event', '3rd Description', '3rd Venue', '2024-11-20 18:00:00', '2024-11-20 19:00:00', '#0000ff', '#ffffff', 11, '', '3rd Notes', '2024-11-20 19:44:11', 0, '2024-11-20 19:44:11'),
(31, '4th Event', '4th Description', '4th Venue', '2024-11-29 20:00:00', '2024-11-30 21:10:00', '#ffff00', '#000000', 20, '', '4th Notes', '2024-11-28 19:45:34', 0, '2024-11-29 14:39:51'),
(32, '5th Title', '5th Description', '5th Venue', '2024-11-12 20:05:00', '2024-11-15 10:10:00', '#00ff00', '#000000', 30, '', '5th Notes', '2024-11-20 20:04:34', 0, '2024-11-22 12:48:20'),
(33, '6th Title', 'Lorem ipsum odor amet, consectetuer adipiscing elit. Quam nostra sociosqu diam lacus praesent praesent dignissim. Dictum orci cras felis vivamus vehicula nisi pharetra cubilia. Ultrices vestibulum auctor dignissim mattis blandit aliquam augue iaculis soda', '6th Venue', '2024-11-23 10:15:00', '2024-11-23 22:00:00', '#ff00ff', '#ffffff', 30, '', 'Sociosqu dictum cras faucibus dolor; praesent habitant. Arcu tellus feugiat turpis sociosqu risus feugiat ac. Ligula nec metus praesent amet ac vivamus himenaeos tortor. Risus ullamcorper quis egestas mauris urna dolor. Hac nibh adipiscing sed curae imper', '2024-11-22 12:50:15', 0, '2024-11-22 16:44:23'),
(34, 'Papawis ni Renato', 'Sociosqu dictum cras faucibus dolor; praesent habitant. Arcu tellus feugiat turpis sociosqu risus feugiat ac. Ligula nec metus praesent amet ac vivamus himenaeos tortor. Risus ullamcorper quis egestas mauris urna dolor. Hac nibh adipiscing sed curae imper', 'Avida Settings Covered Court', '2024-12-19 17:00:00', '2024-12-25 22:00:00', '#704172', '#ffffff', 59, '500', 'Vehicula natoque platea faucibus parturient vivamus quam conubia lobortis. Lectus integer enim litora imperdiet, primis senectus. Posuere semper suspendisse mauris rutrum neque mus velit. Mattis praesent posuere mollis arcu hac eget sagittis ridiculus por', '2024-11-22 14:04:59', 0, '2024-12-10 16:35:36'),
(35, 'examplee', 'example', 'example', '2024-12-05 15:00:00', '2024-12-06 15:30:00', '#00ffff', '#000000', 50, '150', 'example', '2024-11-22 14:41:44', 0, '2024-12-04 18:01:25'),
(37, 'fdsa', 'afds', 'afds', '2024-12-14 00:00:00', '2024-12-15 00:00:00', '#800000', '#ffffff', 0, '', '', '2024-12-04 19:21:47', 1, '2024-12-04 19:21:57'),
(38, 'Game For A Cause', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', 'Regal Homes Covered Court', '2024-12-14 17:00:00', '2024-12-14 22:00:00', '#000000', '#ffffff', 20, '600', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2024-12-05 16:00:26', 0, '2024-12-05 16:00:26'),
(41, 'title', '', 'venue', '2024-12-18 00:30:00', '2024-12-18 01:00:00', '#800000', '#ffffff', 300, '550', '', '2024-12-09 17:57:59', 1, '2024-12-09 17:58:07');

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
(1, 10, 35, 'images/uploads/receipts/10_WIN_20240619_18_34_46_Pro.jpg', 'Joined', NULL, '2024-11-25 18:17:35', 0, '2024-12-05 15:21:10'),
(5, 10, 34, 'images/uploads/receipts/10_sidebar-popup-logo.png', 'Pending', NULL, '2024-11-25 20:37:17', 0, '2024-12-11 16:45:55'),
(6, 57, 35, 'images/uploads/receipts/57_note.png', 'Rejected', NULL, '2024-11-25 20:50:59', 0, '2024-12-05 15:21:17'),
(8, 57, 38, 'images/uploads/receipts/57_Vaccine card.jpg', 'Joined', NULL, '2024-12-10 17:00:27', 0, '2024-12-10 17:05:42'),
(9, 57, 34, 'images/uploads/receipts/57_Signature.jpg', 'Pending', NULL, '2024-12-10 17:02:32', 0, '2024-12-10 17:02:32'),
(10, 12, 34, 'images/uploads/receipts/12_ROBLES.jpg', 'Joined', NULL, '2024-12-11 17:12:04', 0, '2024-12-11 17:12:30'),
(11, 12, 38, 'images/uploads/receipts/12_ROBLES.jpg', 'Pending', NULL, '2024-12-11 17:12:13', 0, '2024-12-11 17:12:13');

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
(10, 'Admin', 'images/uploads/cover-photos/10_cover_photo2.png', 'images/uploads/profiles/10_10_IMG_20240918_210154_155.jpg', 'Mico', 'Robles', '09230853051', 'Point Guard', 6, 12, 90, '[\"Shooting\",\"Passing\",\"Rebounding\"]', 'mic@gmail.com', '$2y$10$wVGE3lLeHpMb5Pt70Bjs1uDjXAepe6IlTvzwP3wFmTwt1pXrny73O', 'Active', '2024-10-16 15:18:18', 0, '2024-11-25 17:25:26'),
(12, 'Admin', 'images/uploads/cover-photos/12_cover_photo.jpg', 'images/uploads/profiles/12_Signature.jpg', 'Lyka', 'Jiao', '09398192788', 'Center', 5, 4, 60, '[\"Coast2Coast\"]', 'lyka@gmail.com', '$2y$10$53da/kKna/Ptp14hvn9lR.Y9x3wQml2v5M8mz6DjNuHoLRn6VtyWC', 'Active', '2024-10-16 15:48:11', 0, '2024-12-11 17:02:09'),
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
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `schedules-appointment`
--
ALTER TABLE `schedules-appointment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
