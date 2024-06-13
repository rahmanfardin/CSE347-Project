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
