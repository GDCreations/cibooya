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
-- Table structure for table `stock_req_sub`
--

CREATE TABLE `stock_req_sub` (
  `auid` int(11) NOT NULL,
  `rqid` int(10) NOT NULL COMMENT 'Request bundle id',
  `rsbc` int(10) NOT NULL COMMENT 'branch id',
  `itid` int(10) NOT NULL COMMENT 'item id',
  `reqty` int(11) NOT NULL COMMENT 'request quantity',
  `asqty` int(10) NOT NULL COMMENT 'assigned quantity',
  `dscr` varchar(100) NOT NULL COMMENT 'description',
  `crby` int(5) NOT NULL COMMENT 'create by',
  `crdt` datetime NOT NULL COMMENT 'create date',
  `mdby` int(5) NOT NULL COMMENT 'modify by',
  `mddt` datetime DEFAULT NULL COMMENT 'modify date',
  `stat` int(11) NOT NULL COMMENT 'Status (0-pending/1-Checked/2-Reject/3-Assigned/4-Issued/5-Recieved/6-Inact)',
  `apby` int(10) NOT NULL COMMENT 'approval by',
  `apdt` datetime DEFAULT NULL COMMENT 'approval date',
  `rjby` int(10) NOT NULL COMMENT 'reject by',
  `rjdt` datetime DEFAULT NULL COMMENT 'reject date',
  `rmk` text NOT NULL COMMENT 'Remark (reject)',
  `asby` int(11) NOT NULL COMMENT 'Assigned by',
  `asdt` datetime DEFAULT NULL COMMENT 'Assigned date',
  `isby` int(11) NOT NULL COMMENT 'Issued by',
  `isdt` datetime DEFAULT NULL COMMENT 'Issued date'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='branch stock';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_req_sub`
--
ALTER TABLE `stock_req_sub`
  ADD PRIMARY KEY (`auid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_req_sub`
--
ALTER TABLE `stock_req_sub`
  MODIFY `auid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
