-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 12:38 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bedan`
--

-- --------------------------------------------------------

--
-- Table structure for table `train_countdown`
--

CREATE TABLE `train_countdown` (
  `train_id` int(11) NOT NULL,
  `countdown_time` int(11) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `train_countdown`
--

INSERT INTO `train_countdown` (`train_id`, `countdown_time`, `last_updated`) VALUES
(1, -1, '2025-01-29 15:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `train_status`
--

CREATE TABLE `train_status` (
  `train_id` int(11) NOT NULL,
  `current_station` int(11) NOT NULL,
  `direction` enum('FORWARD','BACKWARD') NOT NULL,
  `last_update_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `train_status`
--

INSERT INTO `train_status` (`train_id`, `current_station`, `direction`, `last_update_time`) VALUES
(1, 2, 'FORWARD', '2025-01-29 17:04:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `train_countdown`
--
ALTER TABLE `train_countdown`
  ADD PRIMARY KEY (`train_id`);

--
-- Indexes for table `train_status`
--
ALTER TABLE `train_status`
  ADD PRIMARY KEY (`train_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
