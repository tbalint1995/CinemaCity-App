-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2023 at 01:23 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mozi_teszt_tb`
--

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `name`, `date`, `start_time`, `end_time`, `price`, `created_at`, `updated_at`) VALUES
(1, 'A galaxis őrzői: 3. rész', '2023-05-25', '10:00:00', '12:00:00', '10.50', '2023-05-14 23:05:25', NULL),
(2, 'A csendes lány', '2023-05-31', '20:00:00', '23:00:00', '8.00', '2023-05-14 23:05:25', NULL),
(19, 'Avatar', '2023-05-25', '13:30:00', '15:30:00', '10.00', '2023-05-17 22:52:23', '2023-05-17 23:13:18'),
(20, 'Gladiátor', '2023-05-27', '20:00:00', '23:00:00', '11.00', '2023-05-17 23:26:15', '2023-05-18 13:08:17'),
(21, 'Halálos iramban 10.', '2023-05-18', '10:30:00', '12:00:00', '14.00', '2023-05-18 13:10:21', '2023-05-18 15:20:30');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint UNSIGNED NOT NULL,
  `movie_id` bigint UNSIGNED NOT NULL,
  `row_col` char(2) NOT NULL,
  `row` tinyint(1) NOT NULL,
  `col` char(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `movie_id`, `row_col`, `row`, `col`, `name`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(33, 1, '2E', 2, 'E', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL),
(34, 1, '2F', 2, 'F', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL),
(35, 1, '2G', 2, 'G', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL),
(36, 1, '2H', 2, 'H', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL),
(37, 1, '2I', 2, 'I', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL),
(38, 1, '2J', 2, 'J', 'Kala', 'Pál', 'kalapal@kalap.ka', '2023-05-18 15:23:01', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
