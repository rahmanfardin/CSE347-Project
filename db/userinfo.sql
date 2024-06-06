-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2024 at 10:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `userinfo`
--
CREATE DATABASE IF NOT EXISTS `userinfo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `userinfo`;

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `appid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fathername` varchar(50) NOT NULL,
  `mothername` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `nid` varchar(60) NOT NULL,
  `address` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL,
  `printStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application`
--

INSERT INTO `application` (`appid`, `username`, `fname`, `lname`, `fathername`, `mothername`, `DOB`, `email`, `phone`, `nid`, `address`, `status`, `printStatus`) VALUES
(19, 'user1', 'fardin', 'Rahman', 'Azizur Rahman', 'dspijasoifjoi', '2024-05-14', 'mohammadfardinrahman@gmail.com', '01601327346', 'fdfasfasdfd', 'house 305, east rampura', 'approved', 'not'),
(22, 'ntn', 'fsafd', 'fasfds', 'fasfafdsfasddf', 'ffdsfas', '2024-05-09', 'fdsfsdf@gmail.com', 'fasdfsdaf', 'ffasfsdffasdf', 'fafdfasdf', 'approved', 'not'),
(23, 'reemu', 'Redita Sultana', 'Reemu', 'XYZ', 'ABC', '2002-07-22', 'reemu1409@gmail.com', '0171000000', '123456789', 'Dhaka r bairer Gram', 'approved', 'not');

--
-- Triggers `application`
--
DROP TRIGGER IF EXISTS `new passport`;
DELIMITER $$
CREATE TRIGGER `new passport` AFTER UPDATE ON `application` FOR EACH ROW BEGIN
    IF NEW.status = 'approved' THEN
        INSERT INTO `passport` (fname, lname, fathername, mothername, email, phone, nid, address, username, DOB, DOD, DOE)
        VALUES (
            NEW.fname, 
            NEW.lname, 
            NEW.fathername,
            NEW.mothername,
            NEW.email, 
            NEW.phone, 
            NEW.nid, 
            NEW.address, 
            NEW.username,
            NEW.DOB,
            CURDATE(),  -- Today's date (DOD)
            DATE_ADD(CURDATE(), INTERVAL 5 YEAR)  -- 5 years from today (DOE)
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `passport`
--

DROP TABLE IF EXISTS `passport`;
CREATE TABLE `passport` (
  `PassportID` int(50) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `fathername` varchar(60) NOT NULL,
  `mothername` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `nid` varchar(60) NOT NULL,
  `address` varchar(500) NOT NULL,
  `username` varchar(50) NOT NULL,
  `DOB` date DEFAULT NULL,
  `DOD` date DEFAULT NULL,
  `DOE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passport`
--

INSERT INTO `passport` (`PassportID`, `fname`, `lname`, `fathername`, `mothername`, `email`, `phone`, `nid`, `address`, `username`, `DOB`, `DOD`, `DOE`) VALUES
(10, 'fardin', 'Rahman', 'Azizur Rahman', 'dspijasoifjoi', 'mohammadfardinrahman@gmail.com', '01601327346', 'fdfasfasdfd', 'house 305, east rampura', 'user1', '2024-05-14', '2024-05-30', '2029-05-30'),
(12, 'fsafd', 'fasfds', 'fasfafdsfasddf', 'ffdsfas', 'fdsfsdf@gmail.com', 'fasdfsdaf', 'ffasfsdffasdf', 'fafdfasdf', 'ntn', '2024-05-09', '2024-06-01', '2029-06-01'),
(13, 'Redita Sultana', 'Reemu', 'XYZ', 'ABC', 'reemu1409@gmail.com', '0171000000', '123456789', 'Dhaka r bairer Gram', 'reemu', '2002-07-22', '2024-06-06', '2029-06-06');

--
-- Triggers `passport`
--
DROP TRIGGER IF EXISTS `passportValid`;
DELIMITER $$
CREATE TRIGGER `passportValid` AFTER INSERT ON `passport` FOR EACH ROW BEGIN
    INSERT INTO `passportvalidity` (PassportID, isRevoked, isValid)
    VALUES (
        NEW.PassportID, 
        'false', 
        'true'
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `passportvalidity`
--

DROP TABLE IF EXISTS `passportvalidity`;
CREATE TABLE `passportvalidity` (
  `PassportID` int(11) NOT NULL,
  `isRevoked` varchar(50) NOT NULL,
  `isValid` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passportvalidity`
--

INSERT INTO `passportvalidity` (`PassportID`, `isRevoked`, `isValid`) VALUES
(10, 'true', 'false'),
(12, 'true', 'false'),
(13, 'false', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `appid` int(11) NOT NULL,
  `paymentStatus` varchar(50) NOT NULL DEFAULT 'notpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`appid`, `paymentStatus`) VALUES
(21, 'paid'),
(22, 'paid'),
(23, 'paid');

--
-- Triggers `payment`
--
DROP TRIGGER IF EXISTS `update_application_status_on_payment`;
DELIMITER $$
CREATE TRIGGER `update_application_status_on_payment` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
    IF NEW.paymentStatus = 'paid' THEN
        UPDATE `application`
        SET `status` = 'Pending Approval'  
        WHERE `appid` = NEW.appid;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `renewapplication`
--

DROP TABLE IF EXISTS `renewapplication`;
CREATE TABLE `renewapplication` (
  `PassportID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renewapplication`
--

INSERT INTO `renewapplication` (`PassportID`, `username`) VALUES
(10, 'user1'),
(10, 'user1');

--
-- Triggers `renewapplication`
--
DROP TRIGGER IF EXISTS `renew_passport`;
DELIMITER $$
CREATE TRIGGER `renew_passport` AFTER INSERT ON `renewapplication` FOR EACH ROW BEGIN
    DECLARE currentDate DATE;
    DECLARE expireDate DATE;

    SET currentDate = CURDATE(); 
    SET expireDate = DATE_ADD(currentDate, INTERVAL 5 YEAR);

    UPDATE `passport`
    SET 
        `DOD` = currentDate, 
        `DOE` = expireDate
    WHERE `PassportID` = NEW.PassportID AND `username` = NEW.username;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `revokeapplication`
--

DROP TABLE IF EXISTS `revokeapplication`;
CREATE TABLE `revokeapplication` (
  `revokeID` int(11) NOT NULL,
  `PassportID` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revokeapplication`
--

INSERT INTO `revokeapplication` (`revokeID`, `PassportID`, `status`) VALUES
(12, 10, 'approved'),
(13, 12, 'approved');

--
-- Triggers `revokeapplication`
--
DROP TRIGGER IF EXISTS `changeValidity`;
DELIMITER $$
CREATE TRIGGER `changeValidity` AFTER UPDATE ON `revokeapplication` FOR EACH ROW BEGIN
  IF NEW.status = 'approved' THEN  -- Check if the updated status is 'approved'
    UPDATE passportvalidity
    SET isRevoked = 'true',
        isValid = 'false'
    WHERE PassportID = NEW.PassportID;  -- Update passportvalidity table based on PassportID
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

DROP TABLE IF EXISTS `usertable`;
CREATE TABLE `usertable` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `userType` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`id`, `name`, `email`, `username`, `password`, `userType`) VALUES
(5, 'Fardin Rahman', 'mfardinr@gmail.com', 'neutronslayer', '464f46564cdd937ff3e3e64f605fa70ac3b822e952a55a924adee933271f32d0', 'admin'),
(13, 'admin1', 'admin1@gmail.com', 'admin1', '25f43b1486ad95a1398e3eeb3d83bc4010015fcc9bedb35b432e00298d5021f7', 'admin'),
(18, 'auth1', 'auth1@gmail.com', 'auth1', '31a433abae24092df8636e752d03f0dc1d08b5e292549b68eb5f64755f38903c', 'auth'),
(19, 'user1', 'user1@gmail.com', 'user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90', 'user'),
(20, 'approver1', 'approver1@gmail.com', 'approver1', 'e973de4808e055b3238a774fbfba4bea8f563b24ff0d60fdb84023588251786f', 'app'),
(21, 'user2', 'user2@gmail.com', 'user2', '6025d18fe48abd45168528f18a82e265dd98d421a7084aa09f61b341703901a3', 'user'),
(22, 'NTN', 'NTN@gmail.com', 'ntn', '86475f5e72acb469f359fa04817d701b5eb7eb380f1ddb635292b7454cb10ce7', 'user'),
(23, 'Redita Sultana', 'redita1409@gmail.com', 'reemu', 'a3ad2fc989d361b3692d13c2e25d2db6aa057fe44cbe100ad3561f8534ed3cbf', 'user'),
(24, 'Fardin Rahman', 'mohammadfardinrahman@gmail.com', 'fardin', '24b625baf04f34f08deafbd3b00f1a4869fe3d314ee766fa1f922bb92b483492', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`appid`);

--
-- Indexes for table `passport`
--
ALTER TABLE `passport`
  ADD PRIMARY KEY (`PassportID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `passportvalidity`
--
ALTER TABLE `passportvalidity`
  ADD PRIMARY KEY (`PassportID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD UNIQUE KEY `appid` (`appid`);

--
-- Indexes for table `revokeapplication`
--
ALTER TABLE `revokeapplication`
  ADD PRIMARY KEY (`revokeID`),
  ADD UNIQUE KEY `PassportID` (`PassportID`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `application`
--
ALTER TABLE `application`
  MODIFY `appid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `passport`
--
ALTER TABLE `passport`
  MODIFY `PassportID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `revokeapplication`
--
ALTER TABLE `revokeapplication`
  MODIFY `revokeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
