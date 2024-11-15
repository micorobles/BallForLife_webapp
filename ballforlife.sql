-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 01:08 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `coverPhoto`, `profilePic`, `firstname`, `lastname`, `contactnum`, `position`, `heightFeet`, `heightInch`, `weight`, `skills`, `email`, `password`, `status`, `created_at`, `is_deleted`, `updated_at`) VALUES
(10, 'images/uploads/cover-photos/10_cover_photo2.png', 'images/uploads/profiles/10_IMG_20240918_210154_155.jpg', 'Mico', 'Robles', '09230853051', 'Point Guard', 6, 12, 90, '[\"Shooting\",\"Passing\",\"Rebounding\"]', 'mic@gmail.com', '$2y$10$wVGE3lLeHpMb5Pt70Bjs1uDjXAepe6IlTvzwP3wFmTwt1pXrny73O', 'Active', '2024-10-16 07:18:18', 0, '2024-11-15 08:15:34'),
(12, 'images/uploads/cover-photos/12_cover_photo.jpg', 'images/uploads/profiles/12_Signature.jpg', 'Lyka', 'Jiao', '09398192788', 'Center', 5, 4, 60, '[\"Coast2Coast\"]', 'lyka@gmail.com', '$2y$10$mA.1YYCIsU6Qt0raHWrJYuHYKI8OpDDrBeYuZkLQxOX3JhGSx6tIK', 'Pending', '2024-10-16 07:48:11', 0, '2024-11-15 08:15:42'),
(57, '', 'images/uploads/profiles/57_user.png', 'Juan', 'Cruz', '09283748232', 'Member', 0, 0, 0, '[\"Rebounding\"]', 'juan@gmail.com', '$2y$10$DfGeTk4Sg.NRjaPX.E83euRfyZoF1DBiR/W6chhRyutAe/4sBPJCK', 'Pending', '2024-11-15 11:11:19', 0, '2024-11-15 11:19:50'),
(59, '', 'https://lh3.googleusercontent.com/a/ACg8ocK4ctI-RyP6SWaClHkWvh1XRKh7JBnzCPAyt-W2TaFFqbW1bICK=s96-c', 'Michol John', 'Robles', '', 'Member', NULL, NULL, NULL, NULL, 'micholrobles27@gmail.com', '', 'Pending', '2024-11-15 11:35:55', 0, NULL);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
