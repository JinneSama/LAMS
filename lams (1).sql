-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 04, 2025 at 08:45 AM
-- Server version: 8.0.21
-- PHP Version: 7.3.21

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Id`, `AttendeeId`, `DateAttended`, `AttendanceType`) VALUES
(1, 4, '2024-07-07 10:20:40', 0),
(2, 4, '2024-07-07 10:24:37', 1),
(3, 4, '2024-07-07 10:26:08', 2),
(4, 5, '2024-07-07 10:50:50', 1),
(5, 6, '2025-07-31 20:46:00', 1),
(6, 6, '2025-07-31 20:46:00', 2),
(7, 4, '2024-07-07 11:41:24', 1),
(8, 5, '2024-07-07 12:56:32', 2),
(9, 11, '2025-07-31 20:46:00', 1),
(10, 11, '2025-07-31 20:46:00', 2),
(11, 12, '2024-07-08 19:00:44', 1),
(12, 12, '2024-07-08 19:01:15', 2),
(13, 2, '2024-07-08 19:08:14', 1),
(14, 4, '2024-07-08 19:08:32', 2),
(15, 4, '2024-07-09 17:03:06', 1),
(16, 4, '2025-07-31 20:46:00', 2),
(17, 4, '2025-07-31 20:46:00', 1),
(18, NULL, NULL, NULL),
(19, 5, '2025-08-01 19:39:16', 1),
(20, 5, '2025-08-01 19:40:31', 1),
(21, 5, '2025-08-01 19:44:16', 2),
(22, 5, '2025-08-01 19:47:22', 1),
(23, 5, '2025-08-01 19:47:26', 2),
(24, 5, '2025-08-01 19:49:19', 2),
(25, 5, '2025-08-01 20:06:32', 1),
(26, 5, '2025-08-01 20:07:02', 2),
(27, 5, '2025-08-01 20:08:41', 1),
(28, 5, '2025-08-01 20:08:49', 2),
(29, 5, '2025-08-01 20:10:26', 1),
(30, 5, '2025-08-02 17:25:25', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`Id`, `FirstName`, `MiddleName`, `LastName`, `NameExt`, `Course`, `Year`, `DateEnrolled`, `SchoolId`, `ImagePath`) VALUES
(4, 'dasdasd', 'kjl', 'adsad', 'jkl', 1, 2122, '2025-08-08 00:00:00', 'dajskdaksdlj', NULL),
(5, 'MA CLARIZA', '', 'JULIAN', '', 1, 0, '2024-07-19 00:00:00', '8374828', 'uploads/1754126251_generation-5c16ddeb-602e-4880-9dcc-ec30fafdc5e3.png'),
(6, 'anti', 'anti', 'anti', 'anti', 1, 0, '2025-07-30 00:00:00', '12345', 'uploads/1754121810_d68f71c0-8ff0-422f-86e7-b8569a4b6160.jfif'),
(7, 'ama', 'ama', 'ama', 'ama', 1, 0, '2025-07-15 00:00:00', '1234', 'uploads/1754121725_494369809_9310881429039555_6235063275262608999_n.jpg'),
(8, 'yttutuhkhkjh', 'jggjjg', 'hgghhg', 'hgghhg', 1, 0, '2025-08-08 00:00:00', 'gyghgh', 'uploads/688d9f5feff2b_d68f71c0-8ff0-422f-86e7-b8569a4b6160.jfif'),
(11, 'someone', 'someone', 'someone', 'someone', 1, 0, '2025-07-14 00:00:00', '123456', 'uploads/688dba709132d_53447c09-8781-4c8a-9a59-10f9416eecdb.jfif'),
(12, 'sample', 'sample', 'sample', 'sample', 1, 0, '2025-07-20 00:00:00', '12222222', 'uploads/688d8751b5d72_Screenshot 2025-04-07 154507.png'),
(13, 'xdasdasd', 'xasdxasd', 'xadxa', 'anti', 1, 111, '0000-00-00 00:00:00', NULL, NULL),
(14, 'ad', 'asd', 'sasasassa', 'sad', 2, 121, '1970-01-01 00:00:00', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

DROP TABLE IF EXISTS `college`;
CREATE TABLE IF NOT EXISTS `college` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `CollegeName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`Id`, `CollegeName`) VALUES
(1, 'Engineering'),
(15, 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `CourseName` varchar(128) DEFAULT NULL,
  `CollegeId` int NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Id`, `CourseName`, `CollegeId`) VALUES
(1, 'BSIT', 1),
(2, 'BSECE', 1),
(3, 'BSCpE', 1),
(4, 'xd', 15),
(5, 'xd', 15),
(6, 'sdax', 1),
(7, 'dasdsd', 15);

-- --------------------------------------------------------

--
-- Table structure for table `passwordreset`
--

DROP TABLE IF EXISTS `passwordreset`;
CREATE TABLE IF NOT EXISTS `passwordreset` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `UserId` int DEFAULT NULL,
  `IsReset` bit(1) DEFAULT b'0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `passwordreset`
--

INSERT INTO `passwordreset` (`Id`, `UserId`, `IsReset`) VALUES
(1, 4, b'1'),
(2, 4, b'1'),
(3, 5, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Id`, `RoleName`) VALUES
(1, 'Administrator'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `RoleId` int DEFAULT NULL,
  `FailedAttempts` int DEFAULT '0',
  `LastFailedAttempt` datetime DEFAULT NULL,
  `IsLocked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `username`, `password`, `RoleId`, `FailedAttempts`, `LastFailedAttempt`, `IsLocked`) VALUES
(4, 'user', '$2y$10$dIr2nidNjVHhV6fu8KybpOh.Lr/kggFuNpfu7BqZlMS7p78MzyXQ.', 2, 0, NULL, 0),
(5, 'admin', '$2y$10$3PmUY1gwq/KaoznxWDLJleZVfTuVStp3P.ezli0FSqyLGDpOdaXMG', 1, 3, '2025-08-03 17:40:17', 0),
(10, 'jinne', '$2y$10$4LnWFlNRUrp4Zd/KNfCvBu1imp5/LVhFGpvqTBebKxYmeQmom2aCu', 2, 1, '2025-08-03 17:30:20', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
