-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2019 at 12:45 PM
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
-- Database: `stock_mng`
--

-- --------------------------------------------------------

--
-- Table structure for table `syst_changelog`
--

CREATE TABLE `syst_changelog` (
  `chid` int(10) NOT NULL,
  `rcdt` date NOT NULL COMMENT 'release date',
  `rfno` text NOT NULL COMMENT 'send mail to',
  `rmks` text NOT NULL COMMENT 'remarks',
  `poby` varchar(100) NOT NULL COMMENT 'post by',
  `stat` int(10) NOT NULL COMMENT '0-pending/1-send/2-reject',
  `crby` int(10) NOT NULL,
  `crdt` datetime NOT NULL COMMENT 'change date',
  `snby` int(10) NOT NULL COMMENT 'send by',
  `sndt` datetime NOT NULL COMMENT 'send date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='system update Release Notes' ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `syst_changelog`
--
ALTER TABLE `syst_changelog`
  ADD PRIMARY KEY (`chid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `syst_changelog`
--
ALTER TABLE `syst_changelog`
  MODIFY `chid` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
