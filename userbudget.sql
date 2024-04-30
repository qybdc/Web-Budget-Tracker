-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 12:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budgettracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `userbudget`
--

CREATE TABLE `userbudget` (
  `id` int(11) NOT NULL,
  `Housing` decimal(7,2) NOT NULL,
  `Utilities` decimal(7,2) NOT NULL,
  `Food` decimal(7,2) NOT NULL,
  `Transportation` decimal(7,2) NOT NULL,
  `Healthcare` decimal(7,2) NOT NULL,
  `DebtRepay` decimal(7,2) NOT NULL,
  `Savings` decimal(7,2) NOT NULL,
  `Personal` decimal(7,2) NOT NULL,
  `Other` decimal(7,2) NOT NULL,
  `Total` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userbudget`
--

INSERT INTO `userbudget` (`id`, `Housing`, `Utilities`, `Food`, `Transportation`, `Healthcare`, `DebtRepay`, `Savings`, `Personal`, `Other`, `Total`) VALUES
(1, 50.00, 50.00, 50.00, 50.00, 50.00, 50.00, 50.00, 50.00, 50.00, 500.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userbudget`
--
ALTER TABLE `userbudget`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userbudget`
--
ALTER TABLE `userbudget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
