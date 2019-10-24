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
-- Table structure for table `stock_req_sub2`
--

CREATE TABLE `stock_req_sub2` (
  `auid` int(11) NOT NULL COMMENT 'Auto id',
  `rqid` int(11) NOT NULL COMMENT 'Request Id',
  `sbid` int(11) NOT NULL COMMENT 'Stock_req_sub id',
  `sttp` int(11) NOT NULL COMMENT 'Stock Type (1-warehouse/2-branch)',
  `stid` int(11) NOT NULL COMMENT 'Stock id',
  `itid` int(11) NOT NULL COMMENT 'Item Id',
  `asqty` double NOT NULL COMMENT 'Assigned Qty',
  `stat` int(11) NOT NULL COMMENT '(1-active/0-Inavtive)',
  `inpr` int(11) NOT NULL COMMENT '(0-No/1-Yes)',
  `inid` int(11) NOT NULL COMMENT 'issue note id',
  `crby` int(11) NOT NULL COMMENT 'Created by',
  `crdt` datetime NOT NULL COMMENT 'Created date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Requested goods issue from stock details';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_req_sub2`
--
ALTER TABLE `stock_req_sub2`
  ADD PRIMARY KEY (`auid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_req_sub2`
--
ALTER TABLE `stock_req_sub2`
  MODIFY `auid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Auto id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
