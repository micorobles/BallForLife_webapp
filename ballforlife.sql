-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 12:39 PM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `profilePic` varchar(70) NOT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `profilePic`, `firstname`, `lastname`, `contactnum`, `position`, `heightFeet`, `heightInch`, `weight`, `skills`, `email`, `password`, `status`, `created_at`, `is_deleted`, `updated_at`) VALUES
(10, 'images/profiles/user.png', 'Mico', 'robles', '09230853051', 'Member', 5, 11, 90, 'Dribbling, Shooting, Passing', 'mic@gmail.com', '$2y$10$v2ttbe9G6xKuPjSgy1KmouXekoFOemgMbmqCXloqNjpBMFH7brEq6', 'active', '2024-10-16 07:18:18', 0, '2024-10-19 10:37:10'),
(12, '/images/profiles/user.png', 'lyka', 'jiao', '09398192788', 'Member', NULL, NULL, NULL, NULL, 'lyka@gmail.com', '$2y$10$mvkYecOZvXnpIm2M4sbLCews1KsH1OVR0aDyb6cBHg6JpwNnY3/Sy', 'active', '2024-10-16 07:48:11', 0, '2024-10-16 07:48:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
