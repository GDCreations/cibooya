-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2019 at 08:40 AM
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
-- Table structure for table `syst_mesg`
--

CREATE TABLE `syst_mesg` (
  `chid` int(10) NOT NULL COMMENT 'change id',
  `cmtp` int(10) NOT NULL COMMENT 'message type (0-All user/1-user level/2-user)',
  `uslv` int(10) DEFAULT NULL COMMENT 'user level',
  `mgus` int(10) DEFAULT NULL COMMENT 'message user',
  `swnt` int(5) NOT NULL COMMENT 'sweet notification (0-no/1-yes) ',
  `mdle` varchar(100) NOT NULL COMMENT 'change module',
  `chng` text NOT NULL COMMENT 'remarks',
  `crdt` datetime NOT NULL COMMENT 'change date',
  `crby` int(10) NOT NULL COMMENT 'change by',
  `stat` int(10) NOT NULL COMMENT 'statues (0-inactive/-1-active/2-rject)',
  `mdby` varchar(100) NOT NULL COMMENT 'user who made the change',
  `mddt` datetime NOT NULL COMMENT 'updated date'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='System Message';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `syst_mesg`
--
ALTER TABLE `syst_mesg`
  ADD PRIMARY KEY (`chid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `syst_mesg`
--
ALTER TABLE `syst_mesg`
  MODIFY `chid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'change id';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
