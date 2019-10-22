-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2019 at 09:18 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cibooya`
--

-- --------------------------------------------------------

--
-- Table structure for table `cus_sol`
--

CREATE TABLE `cus_sol` (
  `soid` int(10) UNSIGNED NOT NULL,
  `sode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='customer solutation' ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cus_sol`
--

INSERT INTO `cus_sol` (`soid`, `sode`) VALUES
(1, 'Mr. '),
(2, 'Mrs. '),
(3, 'Miss. '),
(4, 'Dr. '),
(5, 'Rev. '),
(6, 'Ms. '),
(7, 'Prof. ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cus_sol`
--
ALTER TABLE `cus_sol`
  ADD PRIMARY KEY (`soid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cus_sol`
--
ALTER TABLE `cus_sol`
  MODIFY `soid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
