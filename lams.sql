-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 07, 2024 at 08:18 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lams`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `AttendeeId` int DEFAULT NULL,
  `DateAttended` datetime DEFAULT NULL,
  `AttendanceType` int DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Id`, `AttendeeId`, `DateAttended`, `AttendanceType`) VALUES
(1, 4, '2024-07-07 10:20:40', 0),
(2, 4, '2024-07-07 10:24:37', 1),
(3, 4, '2024-07-07 10:26:08', 2),
(4, 5, '2024-07-07 10:50:50', 1),
(5, 6, '2024-07-07 11:13:24', 1),
(6, 6, '2024-07-07 11:19:42', 2),
(7, 4, '2024-07-07 11:41:24', 1),
(8, 5, '2024-07-07 12:56:32', 2);

-- --------------------------------------------------------

--
-- Table structure for table `attendancetype`
--

DROP TABLE IF EXISTS `attendancetype`;
CREATE TABLE IF NOT EXISTS `attendancetype` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `TypeName` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendancetype`
--

INSERT INTO `attendancetype` (`Id`, `TypeName`) VALUES
(1, 'Time In'),
(2, 'Time Out');

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

DROP TABLE IF EXISTS `attendee`;
CREATE TABLE IF NOT EXISTS `attendee` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(128) DEFAULT NULL,
  `MiddleName` varchar(128) DEFAULT NULL,
  `LastName` varchar(128) DEFAULT NULL,
  `NameExt` varchar(45) DEFAULT NULL,
  `Course` int DEFAULT NULL,
  `Year` int DEFAULT NULL,
  `DateEnrolled` datetime DEFAULT NULL,
  `SchoolId` varchar(128) DEFAULT NULL,
  `ImagePath` varchar(999) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`Id`, `FirstName`, `MiddleName`, `LastName`, `NameExt`, `Course`, `Year`, `DateEnrolled`, `SchoolId`, `ImagePath`) VALUES
(2, ' Junnie', 'Carnate', 'Silao', 'jr', 1, NULL, '1997-12-19 00:00:00', '13-103838383', NULL),
(4, 'dasdasd', 'kjl', 'adsad', 'jkl', 1, NULL, '3233-12-31 00:00:00', 'dajskdaksdlj', 'uploads/image_668964ad15354.jpg'),
(5, 'MA CLARIZA', '', 'JULIAN', '', 3, NULL, '2024-07-19 00:00:00', '8374828', 'uploads/image_668a001960672.jpg'),
(6, 'anti', 'anti', 'anti', 'anti', 2, NULL, '3333-09-19 00:00:00', '12345', 'uploads/image_668a0786562a9.jpg'),
(7, 'ama', 'ama', 'ama', 'ama', 1, NULL, '2024-07-18 00:00:00', '1234', 'uploads/image_668a1852459c6.png'),
(8, 'yttutu', 'jggjjg', 'hgghhg', 'hgghhg', 1, NULL, '2024-07-23 00:00:00', 'gyghgh', 'uploads/image_668a19fb08889.png'),
(9, 'hgghfghf', 'gnvhgn', 'ngfghf', '', 1, NULL, '2024-07-23 00:00:00', 'hffgfhfhhffh', 'uploads/image_668a1a3021c2e.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Id`, `CourseName`) VALUES
(1, 'BSIT'),
(2, 'BSECE'),
(3, 'BSCpE');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
