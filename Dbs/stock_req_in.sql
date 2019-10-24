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
-- Table structure for table `stock_req_in`
--

CREATE TABLE `stock_req_in` (
  `inid` int(11) NOT NULL,
  `inno` varchar(20) NOT NULL COMMENT 'issue note number',
  `vno` varchar(20) NOT NULL COMMENT 'Vehicle Number',
  `drnm` varchar(200) NOT NULL COMMENT 'Driver name',
  `mbno` bigint(20) NOT NULL COMMENT 'Contact Number',
  `inpr` int(11) NOT NULL COMMENT 'issue note print times',
  `rmk` text NOT NULL COMMENT 'Remark (reject)',
  `crby` int(5) NOT NULL COMMENT 'create by',
  `crdt` datetime NOT NULL COMMENT 'create date',
  `stat` int(11) NOT NULL COMMENT 'status (0-deactive/1-active)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='branch stock';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `stock_req_in`
--
ALTER TABLE `stock_req_in`
  ADD PRIMARY KEY (`inid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `stock_req_in`
--
ALTER TABLE `stock_req_in`
  MODIFY `inid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
