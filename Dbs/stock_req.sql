-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2019 at 06:33 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `stock_req`
--

CREATE TABLE `stock_req` (
  `rqid` int(10) NOT NULL COMMENT 'Request bundle id',
  `rqno` varchar(20) NOT NULL COMMENT 'Request number',
  `rqfr` int(10) NOT NULL COMMENT 'Request From 1-warehouse / 2-branch',
  `rsbc` int(10) NOT NULL COMMENT 'Request sender branch',
  `rrbc` int(10) NOT NULL COMMENT 'Request Receive branch / warehouse',
  `stat` int(10) NOT NULL COMMENT 'status (0- pending / 1-approved / 2-cancelled / 3-received /4-Issue_Rej/5-Issued)',
  `crby` int(10) NOT NULL COMMENT 'Created by',
  `crdt` datetime NOT NULL COMMENT 'Created date',
  `apby` int(10) NOT NULL COMMENT 'approved by',
  `apdt` datetime DEFAULT NULL COMMENT 'approved date',
  `mdby` int(11) NOT NULL COMMENT 'Modified by',
  `mddt` datetime DEFAULT NULL COMMENT 'Modified date',
  `rjby` int(11) NOT NULL COMMENT 'Reject by',
  `rjdt` datetime DEFAULT NULL COMMENT 'Reject Date',
  `isrby` int(11) NOT NULL COMMENT 'Issuing reject by',
  `isrdt` datetime DEFAULT NULL COMMENT 'Issuing reject date',
  `reby` int(11) NOT NULL COMMENT 'Received checked by',
  `redt` datetime DEFAULT NULL COMMENT 'received date',
  `rmk` varchar(100) NOT NULL COMMENT 'remark'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_req`
--
ALTER TABLE `stock_req`
  ADD PRIMARY KEY (`rqid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_req`
--
ALTER TABLE `stock_req`
  MODIFY `rqid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Request bundle id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
