-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2019 at 12:44 PM
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
-- Table structure for table `syst_update`
--

CREATE TABLE `syst_update` (
  `auid` int(10) NOT NULL COMMENT 'id',
  `mesg` text NOT NULL COMMENT 'message',
  `date` date NOT NULL COMMENT 'syst down date',
  `frtm` time NOT NULL COMMENT 'down from time',
  `totm` time NOT NULL COMMENT 'down to time',
  `crdt` datetime NOT NULL COMMENT 'create date',
  `crby` int(10) NOT NULL COMMENT 'create by',
  `stat` int(10) NOT NULL COMMENT 'statues (0-pending/-1-Executed/2-rject)',
  `mdby` varchar(100) NOT NULL COMMENT 'modify by',
  `mddt` datetime NOT NULL COMMENT 'modify date'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='System Update Down Details';

--
-- Dumping data for table `syst_update`
--

INSERT INTO `syst_update` (`auid`, `mesg`, `date`, `frtm`, `totm`, `crdt`, `crby`, `stat`, `mdby`, `mddt`) VALUES
(1, 'sfsf', '2019-09-27', '12:40:00', '13:40:00', '2019-09-27 12:40:35', 1, 1, '1', '2019-09-27 14:15:52'),
(2, 'aneee apoooii..', '2019-09-27', '14:18:00', '15:18:00', '2019-09-27 14:18:30', 1, 1, '', '0000-00-00 00:00:00'),
(3, 'apppoooo', '2019-09-27', '14:25:00', '15:20:00', '2019-09-27 14:20:12', 1, 1, '', '0000-00-00 00:00:00'),
(4, 'tyryry', '2019-09-27', '15:08:00', '16:08:00', '2019-09-27 15:08:21', 1, 1, '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `syst_update`
--
ALTER TABLE `syst_update`
  ADD PRIMARY KEY (`auid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `syst_update`
--
ALTER TABLE `syst_update`
  MODIFY `auid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
