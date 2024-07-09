-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 09, 2024 at 09:21 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(8, 5, '2024-07-07 12:56:32', 2),
(9, 11, '2024-07-08 18:56:29', 1),
(10, 11, '2024-07-08 18:58:09', 2),
(11, 12, '2024-07-08 19:00:44', 1),
(12, 12, '2024-07-08 19:01:15', 2),
(13, 2, '2024-07-08 19:08:14', 1),
(14, 2, '2024-07-08 19:08:32', 2),
(15, 2, '2024-07-09 17:03:06', 1),
(16, 2, '2024-07-09 17:03:27', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(11, 'someone', 'someone', 'someone', 'someone', 2, NULL, '2024-09-19 00:00:00', '123456', 'uploads/image_668bc5b400c91.png'),
(12, 'sample', 'sample', 'sample', 'sample', 3, NULL, '2024-12-26 00:00:00', '12222222', 'uploads/image_668bc6b20057e.png');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `usertype` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `usertype`) VALUES
(4, 'admin', '$2y$10$jf1vtu30hOAEkZ5XekbJGu24zH15FX3OErD6w3uZL/oPu7RDk./Zy', 'Administrator'),
(5, 'user', '$2y$10$z8gwWNeU53Qi.9yCvRu3kuTcddZ8KMDo.p5XhMVRa8GKw/JfAbI3y', 'User');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
