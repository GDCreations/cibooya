-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2019 at 12:28 PM
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
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `tpid` int(11) NOT NULL COMMENT 'Type Id',
  `tpcd` varchar(10) NOT NULL COMMENT 'Type Code',
  `tpnm` varchar(200) DEFAULT NULL COMMENT 'Type name',
  `stat` int(11) DEFAULT NULL COMMENT '(0-Pending/1-Active/2-Reject/3-Deactive)',
  `remk` varchar(200) DEFAULT NULL COMMENT 'Remark',
  `crby` int(11) DEFAULT NULL COMMENT 'Created By',
  `crdt` datetime DEFAULT NULL COMMENT 'Created Date',
  `mdby` int(11) DEFAULT NULL COMMENT 'Modify By',
  `mddt` datetime DEFAULT NULL COMMENT 'Modify Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`tpid`, `tpcd`, `tpnm`, `stat`, `remk`, `crby`, `crdt`, `mdby`, `mddt`) VALUES
(1, 'TV1', 'Television', 2, '', 1, '2019-09-27 17:55:52', 1, '2019-09-27 18:26:41'),
(2, 'WM1', 'Washing Machine', 1, '', 1, '2019-09-27 18:23:53', 1, '2019-09-27 18:26:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`tpid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `tpid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Type Id', AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
