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
-- Table structure for table `cus_mas`
--

CREATE TABLE `cus_mas` (
  `cuid` int(10) UNSIGNED NOT NULL,
  `cuty` int(10) NOT NULL COMMENT 'cust type 1-normal/2-advance',
  `rgtp` int(5) NOT NULL COMMENT 'register type (0-cash/1-credit/2-chq)',
  `brco` int(10) NOT NULL COMMENT 'branch code',
  `cuno` varchar(20) NOT NULL COMMENT 'customer no',
  `funm` varchar(200) NOT NULL COMMENT 'full name',
  `init` varchar(100) NOT NULL COMMENT 'initial',
  `hoad` text NOT NULL COMMENT 'home address',
  `tele` varchar(20) NOT NULL COMMENT 'telephone',
  `mobi` varchar(20) NOT NULL COMMENT 'mobile no',
  `anic` varchar(20) NOT NULL COMMENT 'customer nic',
  `nnic` varchar(20) NOT NULL,
  `onic` varchar(20) NOT NULL,
  `dobi` date NOT NULL COMMENT 'birth day',
  `gend` varchar(15) NOT NULL COMMENT 'gender',
  `titl` varchar(20) NOT NULL COMMENT 'title',
  `cist` varchar(20) NOT NULL COMMENT 'civil status',
  `uimg` varchar(100) NOT NULL COMMENT 'user image',
  `smst` int(1) DEFAULT NULL COMMENT 'sms sending status (1-yes/0-no)',
  `stat` int(2) NOT NULL COMMENT 'statues (0-pending/1-active/2-inactive)',
  `crby` int(10) NOT NULL,
  `crdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mdby` int(10) NOT NULL,
  `mddt` datetime DEFAULT NULL,
  `apby` int(10) NOT NULL COMMENT 'approval by',
  `apdt` datetime NOT NULL COMMENT 'approval date',
  `rmks` text NOT NULL,
  `emil` varchar(100) NOT NULL COMMENT 'customer email',
  `rjby` int(10) NOT NULL COMMENT 'reject by',
  `rjdt` datetime NOT NULL COMMENT 'reject date',
  `rjrs` int(10) NOT NULL COMMENT 'reject reason',
  `rjrm` varchar(100) NOT NULL COMMENT 'reject remarks '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cus_mas`
--

INSERT INTO `cus_mas` (`cuid`, `cuty`, `rgtp`, `brco`, `cuno`, `funm`, `init`, `hoad`, `tele`, `mobi`, `anic`, `nnic`, `onic`, `dobi`, `gend`, `titl`, `cist`, `uimg`, `smst`, `stat`, `crby`, `crdt`, `mdby`, `mddt`, `apby`, `apdt`, `rmks`, `emil`, `rjby`, `rjdt`, `rjrs`, `rjrm`) VALUES
(6, 0, 0, 1, 'TMP', 'ana nanksf dsf', '', 'fsajf fosjfasjf jfaoj', '', '1213123222', '', '', '', '0000-00-00', '', '', '', '', NULL, 1, 1, '2019-10-22 06:02:23', 0, NULL, 0, '0000-00-00 00:00:00', 'dsofjsfospf', 'dosfjdsfj@dsfs', 0, '0000-00-00 00:00:00', 0, ''),
(7, 0, 0, 1, 'TMP', 'gemunu udaya', '', 'aned kiyanne, mona addrressd?', '', '1190212141', '832300613v', '', '', '0000-00-00', '', '', '', '', NULL, 1, 1, '2019-10-22 07:15:14', 1, '2019-10-22 12:45:14', 0, '0000-00-00 00:00:00', 'ewath oneda ', 'ane.ahema.ewa.nee@tibbanam.danawa', 0, '0000-00-00 00:00:00', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cus_mas`
--
ALTER TABLE `cus_mas`
  ADD PRIMARY KEY (`cuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cus_mas`
--
ALTER TABLE `cus_mas`
  MODIFY `cuid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
