-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2018 at 11:17 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create database `quatmedics_presentation`;
use `quatmedics_presentation`;

--
-- Database: `quatmedics`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedlist`
--

CREATE TABLE `bedlist` (
  `centerID` varchar(255) NOT NULL,
  `bedID` varchar(255) NOT NULL,
  `bedNumber` varchar(255) NOT NULL,
  `bedDescription` varchar(255) NOT NULL,
  `BedCharge` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bedlist`
--

INSERT INTO `bedlist` (`centerID`, `bedID`, `bedNumber`, `bedDescription`, `BedCharge`, `wardID`, `status`, `doe`) VALUES
('AlTim-000001', 'BED-AlTim-000001-WD-AlTim-1', '1', 'new ', '20', 'WD-AlTim-000002', 'free', '2018-10-26 06:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `birth`
--

CREATE TABLE `birth` (
  `babyID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `babyFirstName` varchar(255) NOT NULL,
  `babyOtherName` varchar(255) NOT NULL,
  `babylastName` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `motherName` varchar(255) NOT NULL,
  `fatherName` varchar(255) NOT NULL,
  `birthTime` time NOT NULL,
  `country` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateRegistered` date NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank`
--

CREATE TABLE `bloodbank` (
  `id` int(11) NOT NULL,
  `bloodID` varchar(255) NOT NULL,
  `donorID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `amtAvail` varchar(255) NOT NULL,
  `donorName` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bloodGroup` varchar(100) NOT NULL,
  `homeAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `lastDonate` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bloodgroup_tb`
--

CREATE TABLE `bloodgroup_tb` (
  `id` int(11) NOT NULL,
  `bloodID` varchar(255) NOT NULL,
  `bloodGroup` varchar(255) NOT NULL,
  `charge` varchar(200) NOT NULL,
  `bloodBags` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bloodgroup_tb`
--

INSERT INTO `bloodgroup_tb` (`id`, `bloodID`, `bloodGroup`, `charge`, `bloodBags`, `centerID`, `doe`) VALUES
(1, 'BLD-AlTim-000001 ', 'AB-positive', '', '', '', '2018-10-25 11:21:27');

-- --------------------------------------------------------

--
-- Table structure for table `centeruser`
--

CREATE TABLE `centeruser` (
  `userID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accessLevel` varchar(20) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centeruser`
--

INSERT INTO `centeruser` (`userID`, `centerID`, `staffID`, `userName`, `password`, `accessLevel`, `dateRegistered`, `doe`) VALUES
('Effah-000003', 'AlTim-000001', 'Effah-000003', 'effah', '1234', 'LABORATORY', '2018-10-23', '2018-10-23 17:01:21'),
('Justi-000005', 'AlTim-000001', 'Justi-000005', 'justice', '1234', 'WARD', '2018-10-23', '2018-10-23 18:55:20'),
('Kanfr-000001', 'AlTim-000001', 'Kanfr-000001', 'rkanfrah', '1234', 'CONSULTATION', '2018-10-23', '2018-10-23 17:34:58'),
('Owoo-000004', 'AlTim-000001', 'Owoo-000004', 'kingsford', '1234', 'PHARMACY', '2018-10-23', '2018-10-23 17:35:03'),
('Smith-000002', 'AlTim-000001', 'Smith-000002', 'Kofi', '1234', 'OPD', '2018-10-23', '2018-10-23 17:38:52'),
('ty-000006', 'AlTim-000001', 'ty-000006', 'rik', '1234', 'OPD', '2018-10-24', '2018-10-24 10:50:55');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consultID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `bodyTemperature` varchar(255) NOT NULL,
  `mode` varchar(255) NOT NULL,
  `insuranceType` varchar(255) NOT NULL,
  `insuranceNumber` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `pulseRate` varchar(255) NOT NULL,
  `respirationRate` varchar(255) NOT NULL,
  `bloodPressure` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `otherHealth` longtext,
  `roomID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consultID`, `patientID`, `staffID`, `bodyTemperature`, `mode`, `insuranceType`, `insuranceNumber`, `company`, `pulseRate`, `respirationRate`, `bloodPressure`, `weight`, `otherHealth`, `roomID`, `centerID`, `status`, `doe`) VALUES
('CON-AlTim-000001', 'Salia-000001', 'Smith-000002', '25', 'Private', '', '', '', '445', '45', '52', '75', 'nothing', 'CR-AlTim-000003', 'AlTim-000001', 'sent_to_pharmacy', '2018-10-23 18:22:28'),
('CON-AlTim-000002', 'Salia-000001', 'Smith-000002', '25', 'Private', '', '', '', '54', '52', '21', '65', '45', 'CR-AlTim-000003', 'AlTim-000001', 'sent_to_ward', '2018-10-23 18:51:39'),
('CON-AlTim-000003', 'hjkjg-000002', 'ty-000006', '7654e', 'Insurance', 'NHIS', '87654e', '', '8765ew', '8765rew', '8765rew', '87654ew', 'jhgfd765r', 'CR-AlTim-000003', 'AlTim-000001', 'sent_to_pharmacy', '2018-10-25 10:30:34'),
('CON-AlTim-000004', 'Owoo-000003', 'ty-000006', '12', 'Insurance', 'Acacia', '12122200', '', '123', '11', '212/12', '96', '', 'CR-AlTim-000003', '', 'sent_to_pharmacy', '2018-10-25 09:53:41'),
('CON-AlTim-000005', 'Salia-000001', 'ty-000006', '1', 'Private', '', '', '', '1', '1', '1', '1', '1', 'CR-AlTim-000001', 'AlTim-000001', 'sent_to_consulting', '2018-10-25 11:39:38'),
('CON-AlTim-000006', 'mensa-000004', 'Smith-000002', '1', 'Company', '', '', 'Battor', '2', '3', '3', '3', '1', 'CR-AlTim-000002', 'AlTim-000001', 'sent_to_ward', '2018-10-26 06:11:24'),
('CON-AlTim-000007', 'hjkjg-000002', 'Smith-000002', '1', 'Insurance', 'Acacia', '12122200', '', '2', '4', '1', '1', 'h', 'CR-AlTim-000002', 'AlTim-000001', 'sent_to_lab', '2018-10-26 08:54:20'),
('CON-AlTim-000008', 'Owoo-000003', 'Smith-000002', '1', 'Insurance', 'NHIS', '12122200', '', '2', '2', '2', '2', '', 'CR-AlTim-000003', 'AlTim-000001', 'sent_to_ward', '2018-10-29 15:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `consultingroom`
--

CREATE TABLE `consultingroom` (
  `roomID` varchar(255) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultingroom`
--

INSERT INTO `consultingroom` (`roomID`, `roomName`, `centerID`, `status`, `dateRegistered`, `doe`) VALUES
('CR-AlTim-000001', 'Children&#39;s Consulting Room', 'AlTim-000001', '', '2018-10-23', '2018-10-26 08:09:39'),
('CR-AlTim-000002', 'Maternity', 'AlTim-000001', 'occupied', '2018-10-23', '2018-10-30 08:31:13'),
('CR-AlTim-000003', 'Consulting Room', 'AlTim-000001', 'occupied', '2018-10-23', '2018-10-30 08:26:10');

-- --------------------------------------------------------

--
-- Table structure for table `death`
--

CREATE TABLE `death` (
  `deathID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `deathDate` date NOT NULL,
  `deathTime` time NOT NULL,
  `reason` longtext NOT NULL,
  `dateRegistered` date NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `departmentID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `departmentName` varchar(255) NOT NULL,
  `dateCreated` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`departmentID`, `centerID`, `departmentName`, `dateCreated`, `doe`) VALUES
('CONSULTATION-1', 'AlTim-000001', 'CONSULTATION', '2018-10-23', '2018-10-23 03:24:36'),
('LABORATORY', 'AlTim-000001', 'LABORATORY', '2018-10-23', '2018-10-23 04:11:08'),
('OPD1', 'AlTim-000001', 'OPD', '2018-10-23', '2018-10-23 02:13:17'),
('PHARMACY-1', 'AlTim-000001', 'PHARMACY', '2018-10-23', '2018-10-23 04:11:11'),
('WARD', 'AlTim-000001', 'WARD', '2018-10-23', '2018-10-23 16:49:03');

-- --------------------------------------------------------

--
-- Table structure for table `docreview_tb`
--

CREATE TABLE `docreview_tb` (
  `ReviewID` int(11) NOT NULL,
  `WardID` varchar(255) NOT NULL,
  `PatientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `DocReview` text NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `docreview_tb`
--

INSERT INTO `docreview_tb` (`ReviewID`, `WardID`, `PatientID`, `staffID`, `DocReview`, `doe`) VALUES
(1, 'WD-AlTim-000001', 'Salia-000001', 'Smith-000002', 'very high', '2018-10-23 18:57:27'),
(2, 'WD-AlTim-000002', 'Owoo-000003', 'ty-000006', 'zxzzxc', '2018-10-25 10:16:26'),
(3, 'WD-AlTim-000002', 'Owoo-000003', 'ty-000006', 'test', '2018-10-25 10:16:43'),
(4, 'WD-AlTim-000002', 'Owoo-000003', 'ty-000006', 'zs', '2018-10-25 10:19:26'),
(5, 'WD-AlTim-000002', 'mensa-000004', 'ty-000006', 'ss', '2018-10-26 08:36:19'),
(6, 'WD-AlTim-000002', 'mensa-000004', 'ty-000006', 'ss', '2018-10-26 08:45:32');

-- --------------------------------------------------------

--
-- Table structure for table `doctorappointment`
--

CREATE TABLE `doctorappointment` (
  `appointNumber` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `appointmentDate` varchar(255) NOT NULL,
  `appointmentTime` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctorappointment`
--

INSERT INTO `doctorappointment` (`appointNumber`, `staffID`, `patientID`, `appointmentDate`, `appointmentTime`, `status`, `doe`) VALUES
('APTMNT-1', 'ty-000006', 'Owoo-000003', '2018-10-31', '00:59', '', '2018-10-25 11:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `lablist`
--

CREATE TABLE `lablist` (
  `labID` varchar(255) NOT NULL,
  `labName` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lablist`
--

INSERT INTO `lablist` (`labID`, `labName`, `centerID`, `doe`) VALUES
('LAB-AlTim-000001', 'CT Scan', 'AlTim-000001', '2018-10-23 17:31:33'),
('LAB-AlTim-000002', 'ANA LAB', 'AlTim-000001', '2018-10-23 17:32:18'),
('LAB-AlTim-000003', 'PTT LAB', 'AlTim-000001', '2018-10-23 17:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `labresults`
--

CREATE TABLE `labresults` (
  `id` int(11) NOT NULL,
  `labRequestID` varchar(255) NOT NULL,
  `consultID` varchar(255) NOT NULL,
  `labID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `labResult` varchar(255) NOT NULL,
  `labDate` varchar(255) NOT NULL,
  `consultingRoom` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `labresults`
--

INSERT INTO `labresults` (`id`, `labRequestID`, `consultID`, `labID`, `centerID`, `patientID`, `staffID`, `labResult`, `labDate`, `consultingRoom`, `status`, `doe`) VALUES
(1, 'LABREQ-1', 'CON-AlTim-000001', 'LAB-AlTim-000002', 'AlTim-000001', 'Salia-000001', 'Kanfr-000001', 'uploads/AlTim-000001/labresults/5bcf65a5545619.48645030.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-25 19:13:59'),
(2, 'LABREQ-2', 'CON-AlTim-000003', 'LAB-AlTim-000002', 'AlTim-000001', 'hjkjg-000002', 'ty-000006', 'uploads/AlTim-000001/labresults/5bd19add18be38.80270494.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-30 08:23:18'),
(3, 'LABREQ-2', 'CON-AlTim-000003', 'LAB-AlTim-000003', 'AlTim-000001', 'hjkjg-000002', 'ty-000006', 'uploads/AlTim-000001/labresults/5bd19add18be38.80270494.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-30 08:23:18'),
(4, 'LABREQ-3', 'CON-AlTim-000007', 'LAB-AlTim-000002', 'AlTim-000001', 'hjkjg-000002', 'Kanfr-000001', 'uploads/AlTim-000001/labresults/5bd2d66a13c109.56567446.pdf', '', 'CR-AlTim-000002', 'Reviewed', '2018-10-30 08:33:31'),
(5, 'LABREQ-4', 'CON-AlTim-000008', 'LAB-AlTim-000001', 'AlTim-000001', 'Owoo-000003', 'Kanfr-000001', 'uploads/AlTim-000001/labresults/5bd72042796219.32827904.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-29 15:01:29'),
(6, 'LABREQ-4', 'CON-AlTim-000008', 'LAB-AlTim-000002', 'AlTim-000001', 'Owoo-000003', 'Kanfr-000001', 'uploads/AlTim-000001/labresults/5bd72042796219.32827904.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-29 15:01:29'),
(7, 'LABREQ-4', 'CON-AlTim-000008', 'LAB-AlTim-000003', 'AlTim-000001', 'Owoo-000003', 'Kanfr-000001', 'uploads/AlTim-000001/labresults/5bd72042796219.32827904.pdf', '', 'CR-AlTim-000003', 'Reviewed', '2018-10-29 15:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `medicalcenter`
--

CREATE TABLE `medicalcenter` (
  `centerID` varchar(255) NOT NULL,
  `centerName` varchar(255) NOT NULL,
  `centerCategory` varchar(50) NOT NULL,
  `centerLocation` varchar(255) NOT NULL,
  `numOfStaff` varchar(255) NOT NULL,
  `centerHistory` longtext NOT NULL,
  `dateregistered` date NOT NULL,
  `numOfBranches` varchar(50) DEFAULT NULL,
  `centerEmail` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accessLevel` varchar(50) NOT NULL,
  `credit` int(255) NOT NULL,
  `creditArr` int(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicalcenter`
--

INSERT INTO `medicalcenter` (`centerID`, `centerName`, `centerCategory`, `centerLocation`, `numOfStaff`, `centerHistory`, `dateregistered`, `numOfBranches`, `centerEmail`, `userName`, `password`, `accessLevel`, `credit`, `creditArr`, `doe`) VALUES
('-000002', '', '', '', '', '', '2018-10-24', '', '', '', '', 'center_admin', 0, 0, '2018-10-24 10:33:19'),
('AlTim-000001', 'AlTime Hospital Center', 'Hospital', 'East Legon', '50', 'A brief history about alTIme Hospital.', '2018-10-23', '1', 'allhospital@gmail.com', 'allTime', 'password', 'center_admin', 0, 0, '2018-10-23 16:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `centerID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `otherName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `bloodGroup` varchar(100) NOT NULL,
  `homeAddress` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `hometown` varchar(255) NOT NULL,
  `guardianName` varchar(255) NOT NULL,
  `guardianGender` varchar(255) NOT NULL,
  `guardianPhone` varchar(255) NOT NULL,
  `guardianRelation` varchar(255) NOT NULL,
  `guardianAddress` varchar(255) NOT NULL,
  `lock_center` varchar(255) NOT NULL,
  `patient_status` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `patient_image` varchar(255) NOT NULL,
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`centerID`, `patientID`, `firstName`, `otherName`, `lastName`, `dob`, `gender`, `bloodGroup`, `homeAddress`, `phoneNumber`, `hometown`, `guardianName`, `guardianGender`, `guardianPhone`, `guardianRelation`, `guardianAddress`, `lock_center`, `patient_status`, `status`, `patient_image`, `dateRegistered`, `doe`) VALUES
('AlTim-000001', 'hjkjg-000002', 'Richard', 'Oseidghhg', 'hjkjgjgh1f', '2018-10-24', 'Male', 'B-positive', 'kjfjfhjfh', '87654', 'uyyu', 'jhkkfjhgjfhkjfhjkh', '', '65474', 'khffuyfyfkf', 'fhdfhdfgh fdghertwe etjytje', 'AlTim-000001', 'patient_busy', '', 'uploads/AlTim-000001/patient/hjkjg-000002_1540406231.pdf', '2018-10-24', '2018-10-26 08:52:54'),
('AlTim-000001', 'mensa-000004', 'Joyce', '', 'mensah', '1988-12-02', 'Female', 'B-positive', '84555 TELEGRAPH RD', '5623645002', 'LOS ANGELES', 'Kofi Menu', '', '5623645002', 'Father', '84555 TELEGRAPH RD, PICO RIVERA', 'AlTim-000001', 'patient_busy', '', 'uploads/AlTim-000001/patient/mensa-000004_1540533374.jpg', '2018-10-26', '2018-10-26 05:57:09'),
('AlTim-000001', 'Owoo-000003', 'Kingsford', 'Kwartey', 'Owoo', '1990-02-04', 'Male', 'B-negative', '84555 TELEGRAPH RD', '0501255474', '', 'Yaw Mensah', '', '5623645002', 'Father', '84555 TELEGRAPH RD, PICO RIVERA', 'AlTim-000001', 'patient_busy', '', 'uploads/AlTim-000001/patient/Owoo-000003_1540459559.jpg', '2018-10-25', '2018-10-29 14:55:57'),
('AlTim-000001', 'Salia-000001', 'Ardil', 'Kwame', 'Salia', '2018-10-16', 'Male', 'O-positive', 'kjfjfhjfh', '0541524233', 'kljgfkhkvjh', 'Mrs Ardil', '', '5345655546', 'Mother', 'Northen', 'AlTim-000001', 'patient_busy', '', 'uploads/AlTim-000001/patient/Salia-000001_1540316511.pdf', '2018-10-23', '2018-10-25 11:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacyID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `pharmacyName` varchar(255) NOT NULL,
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pharmacy`
--

INSERT INTO `pharmacy` (`pharmacyID`, `centerID`, `pharmacyName`, `dateRegistered`, `doe`) VALUES
('PH-AlTim-000002', 'AlTim-000001', 'sfsdf', '2018-10-24', '2018-10-24 09:43:04'),
('Phar-1', 'AlTim-000001', 'AlTime Pharmacy', '2018-10-23', '2018-10-23 04:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `prescribedmeds`
--

CREATE TABLE `prescribedmeds` (
  `prescribeid` int(255) NOT NULL,
  `prescribeCode` varchar(255) NOT NULL,
  `medicine` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `prescribeStatus` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescribedmeds`
--

INSERT INTO `prescribedmeds` (`prescribeid`, `prescribeCode`, `medicine`, `dosage`, `prescribeStatus`, `comment`, `doe`) VALUES
(1, 'PRSCB-1', 'PARA', '2X1', 'served', 'avaialble', '2018-10-23 18:24:43'),
(2, 'PRSCB-1', 'Malaquine', '2X1', 'served', 'available', '2018-10-23 18:24:43'),
(3, 'PRSCB-1', 'HIV Meds', '2X1', 'Prescibed', '', '2018-10-23 18:22:28'),
(4, 'PRSCB-2', 'para', '3x1', 'Prescibed', 'not in stock ', '2018-10-25 10:23:28'),
(5, 'PRSCB-3', 'sdsd', '1', 'served', 'served ', '2018-10-25 10:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `prescribeID` int(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `prescribeCode` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `pharmacyID` varchar(255) NOT NULL,
  `symptoms` longtext NOT NULL,
  `diagnose` longtext NOT NULL,
  `prescribeStatus` varchar(255) NOT NULL,
  `perscriptionCode` varchar(255) NOT NULL,
  `datePrescribe` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`prescribeID`, `patientID`, `prescribeCode`, `staffID`, `pharmacyID`, `symptoms`, `diagnose`, `prescribeStatus`, `perscriptionCode`, `datePrescribe`, `doe`) VALUES
(1, 'Salia-000001', 'PRSCB-1', 'Kanfr-000001', 'Phar-1', 'cough, swollen lips', 'he has HIV', 'Prescibed', 'd6ca01c9', '2018-10-23', '2018-10-23 18:22:27'),
(2, 'Owoo-000003', 'PRSCB-2', 'ty-000006', 'Phar-1', 'vomiting ', 'Malaria ', 'Prescibed', 'b2baeb66', '2018-10-25', '2018-10-25 09:53:41'),
(3, 'hjkjg-000002', 'PRSCB-3', 'ty-000006', 'PH-AlTim-000002', 'sdsd', 'sdssd', 'Prescibed', '3d14886c', '2018-10-25', '2018-10-25 10:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `quatadmin`
--

CREATE TABLE `quatadmin` (
  `adminID` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accessLevel` varchar(255) NOT NULL,
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review_tb`
--

CREATE TABLE `review_tb` (
  `reviewID` int(11) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review_tb`
--

INSERT INTO `review_tb` (`reviewID`, `patientID`, `wardID`, `comments`, `treatment`, `dosage`, `doe`) VALUES
(1, 'Salia-000001', 'WD-AlTim-000001', 'coofjofdjodjojoj', 'weed.<br>tramadol.<br>', '2 ounces.<br>100 pills.<br>', '2018-10-23 18:57:18'),
(2, 'Owoo-000003', 'WD-AlTim-000002', 'Fever ', 'Alaxin .<br>', '3x1.<br>', '2018-10-25 10:15:17'),
(3, 'Owoo-000003', 'WD-AlTim-000002', 'aaa', 'magacid .<br>', '3x1.<br>', '2018-10-25 10:15:56'),
(4, 'Owoo-000003', 'WD-AlTim-000002', 'deedeede', 'Alaxin .<br>.<br>.<br>', '3x1.<br>.<br>.<br>', '2018-10-30 08:17:03'),
(5, 'Owoo-000003', 'WD-AlTim-000002', 'deedeede', 'Alaxin .<br>.<br>.<br>', '3x1.<br>.<br>.<br>', '2018-10-30 08:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `smscredits`
--

CREATE TABLE `smscredits` (
  `id` int(11) NOT NULL,
  `sms_amount` varchar(255) NOT NULL,
  `sms_credit` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `smscredits`
--

INSERT INTO `smscredits` (`id`, `sms_amount`, `sms_credit`, `doe`) VALUES
(1, '1000', '1245', '2018-10-23 05:12:15'),
(2, '2000', '2488', '2018-10-23 18:02:29'),
(3, '45645', '222222222225555', '2018-10-24 10:39:09');

-- --------------------------------------------------------

--
-- Table structure for table `sms_tb`
--

CREATE TABLE `sms_tb` (
  `id` int(11) NOT NULL,
  `requestID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `credit` varchar(255) NOT NULL,
  `transactionID` varchar(255) NOT NULL,
  `senderName` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dateRegistered` date NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_tb`
--

INSERT INTO `sms_tb` (`id`, `requestID`, `centerID`, `staffID`, `amount`, `credit`, `transactionID`, `senderName`, `status`, `dateRegistered`, `doe`) VALUES
(1, 'REQ-SMS-AlTim-000001-000001', 'AlTim-000001', 'AlTim-000001', '1000', '1245', '32524252', 'AllTime', 'sms_pending', '2018-10-23', '2018-10-23 18:14:08');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` varchar(255) NOT NULL,
  `staffType` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `departmentID` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `otherName` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `staffCategory` varchar(10) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `specialty` varchar(200) DEFAULT NULL,
  `license` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateEmployed` varchar(255) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffType`, `centerID`, `departmentID`, `firstName`, `lastName`, `otherName`, `gender`, `staffCategory`, `dob`, `specialty`, `license`, `email`, `dateEmployed`, `dateRegistered`, `doe`) VALUES
('Effah-000003', '', 'AlTim-000001', 'LABORATORY', 'Godwin', 'Effah', 'Goodman', 'Male', 'Psychologi', '2018-10-23', 'psychologist', '', 'godwinabeaku@gmail.com', '', '2018-10-23', '2018-10-23 17:01:21'),
('Justi-000005', '', 'AlTim-000001', 'WARD', 'Justice', 'Justice', 'Osei', 'Male', 'Midwife', '2018-10-01', 'Midwifery', '', 'kingicon05@gmail.com', '', '2018-10-23', '2018-10-23 18:55:20'),
('Kanfr-000001', '', 'AlTim-000001', 'CONSULTATION-1', 'Richard', 'Kanfrah', 'Kofi', 'Male', 'Doctor', '2018-10-23', 'Doctor', '', 'kingicon05@gmail.com', '', '2018-10-23', '2018-10-23 16:53:03'),
('Owoo-000004', '', 'AlTim-000001', 'PHARMACY-1', 'Kingsford', 'Owoo', 'Kwame', 'Male', 'Therapist', '2018-10-16', 'Therapist', '', 'kingsford.owoo@gmail.com', '', '2018-10-23', '2018-10-23 17:21:46'),
('Smith-000002', '', 'AlTim-000001', 'OPD1', 'Kofi', 'Smith', 'Osei', 'Male', 'Nurse', '2018-10-03', 'Nurse', '', 'authenticartmuzik@gmail.com', '', '2018-10-23', '2018-10-23 16:58:32'),
('ty-000006', '', 'AlTim-000001', 'OPD1', 'e', 'ty', 'wr', 'Male', 'Nurse', '2018-10-02', 'pharmacy', '', 'kingicon05@gmail.com', '', '2018-10-24', '2018-10-24 08:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `transferID` varchar(255) NOT NULL,
  `from_centerID` varchar(255) NOT NULL,
  `from_staffID` varchar(255) NOT NULL,
  `to_centerID` varchar(255) NOT NULL,
  `to_staffID` varchar(255) NOT NULL,
  `reason` longtext NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `dateRegistered` date NOT NULL,
  `transfer_status` int(11) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wardassigns`
--

CREATE TABLE `wardassigns` (
  `assignID` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `bedID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `admitDate` varchar(255) NOT NULL,
  `dischargeDate` varchar(255) NOT NULL,
  `admitDetails` longtext NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `consultingroom` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wardassigns`
--

INSERT INTO `wardassigns` (`assignID`, `wardID`, `bedID`, `patientID`, `staffID`, `admitDate`, `dischargeDate`, `admitDetails`, `centerID`, `consultingroom`, `doe`) VALUES
('ASSIGN-1', 'WD-AlTim-000001', '', 'Salia-000001', 'Kanfr-000001', '2018-10-23', '', 'Treatment And Observation', '', '', '2018-10-23 18:51:39'),
('ASSIGN-2', 'WD-AlTim-000002', '', 'Owoo-000003', 'ty-000006', '2018-10-25', '', 'Other Reasons', '', '', '2018-10-25 09:50:35'),
('ASSIGN-3', 'WD-AlTim-000001', 'All Beds Occupied', 'mensa-000004', 'Kanfr-000001', '2018-10-26', '', 'Treatment And Observation', '', '', '2018-10-26 06:11:24'),
('ASSIGN-4', 'WD-AlTim-000002', '', 'Owoo-000003', 'Kanfr-000001', '2018-10-29', '2019-04-10', 'Treatment And Observation', '', '', '2018-10-29 15:04:21');

-- --------------------------------------------------------

--
-- Table structure for table `wardlist`
--

CREATE TABLE `wardlist` (
  `wardID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `wardName` varchar(255) NOT NULL,
  `numOfBeds` varchar(255) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wardlist`
--

INSERT INTO `wardlist` (`wardID`, `centerID`, `wardName`, `numOfBeds`, `dateRegistered`, `doe`) VALUES
('WD-AlTim-000001', 'AlTim-000001', 'Maternity Ward', '10', '2018-10-23', '2018-10-23 17:25:31'),
('WD-AlTim-000002', 'AlTim-000001', 'Emergency Ward', '10', '2018-10-23', '2018-10-23 17:25:45'),
('WD-AlTim-000003', 'AlTim-000001', 'Children Ward', '10', '2018-10-23', '2018-10-23 17:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `wardmeds`
--

CREATE TABLE `wardmeds` (
  `medID` int(255) NOT NULL,
  `assignID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `medicine` varchar(255) NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `diagnoses` varchar(400) NOT NULL,
  `symptoms` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wardmeds`
--

INSERT INTO `wardmeds` (`medID`, `assignID`, `patientID`, `staffID`, `wardID`, `medicine`, `dosage`, `doe`, `diagnoses`, `symptoms`) VALUES
(1, 'ASSIGN-1', 'Salia-000001', 'Kanfr-000001', 'WD-AlTim-000001', 'PARA', '2X1', '2018-10-23 18:51:38', '', ''),
(2, 'ASSIGN-1', 'Salia-000001', 'Kanfr-000001', 'WD-AlTim-000001', 'Malaquine', '2X1', '2018-10-23 18:51:38', '', ''),
(3, 'ASSIGN-2', 'Owoo-000003', 'ty-000006', 'WD-AlTim-000002', 'para', '3x1', '2018-10-25 09:50:34', '', ''),
(4, 'ASSIGN-3', 'mensa-000004', 'Kanfr-000001', 'WD-AlTim-000001', 'Blood (O-positive)', '1pt', '2018-10-26 06:11:24', 'Malaria ', 'fever vomiting '),
(5, 'ASSIGN-3', 'mensa-000004', 'Kanfr-000001', 'WD-AlTim-000001', 'Para', '3x1', '2018-10-26 06:11:24', 'Malaria ', 'fever vomiting ');

-- --------------------------------------------------------

--
-- Table structure for table `wardtreatmet`
--

CREATE TABLE `wardtreatmet` (
  `id` int(255) NOT NULL,
  `assignID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `datetime` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bedlist`
--
ALTER TABLE `bedlist`
  ADD PRIMARY KEY (`bedID`);

--
-- Indexes for table `birth`
--
ALTER TABLE `birth`
  ADD PRIMARY KEY (`babyID`);

--
-- Indexes for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD PRIMARY KEY (`donorID`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `donorID` (`donorID`),
  ADD KEY `bloodID` (`bloodID`);

--
-- Indexes for table `bloodgroup_tb`
--
ALTER TABLE `bloodgroup_tb`
  ADD PRIMARY KEY (`bloodID`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `centeruser`
--
ALTER TABLE `centeruser`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `staffID_2` (`staffID`),
  ADD KEY `centerID` (`centerID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`consultID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `consultingroom`
--
ALTER TABLE `consultingroom`
  ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `death`
--
ALTER TABLE `death`
  ADD PRIMARY KEY (`deathID`),
  ADD UNIQUE KEY `patientID` (`patientID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`departmentID`),
  ADD KEY `centerID` (`centerID`);

--
-- Indexes for table `docreview_tb`
--
ALTER TABLE `docreview_tb`
  ADD PRIMARY KEY (`ReviewID`);

--
-- Indexes for table `doctorappointment`
--
ALTER TABLE `doctorappointment`
  ADD PRIMARY KEY (`appointNumber`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `lablist`
--
ALTER TABLE `lablist`
  ADD PRIMARY KEY (`labID`),
  ADD KEY `centerID` (`centerID`);

--
-- Indexes for table `labresults`
--
ALTER TABLE `labresults`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `medicalcenter`
--
ALTER TABLE `medicalcenter`
  ADD PRIMARY KEY (`centerID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientID`),
  ADD KEY `centerID` (`centerID`);

--
-- Indexes for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD PRIMARY KEY (`pharmacyID`),
  ADD KEY `centerID` (`centerID`);

--
-- Indexes for table `prescribedmeds`
--
ALTER TABLE `prescribedmeds`
  ADD PRIMARY KEY (`prescribeid`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`prescribeID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `quatadmin`
--
ALTER TABLE `quatadmin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `review_tb`
--
ALTER TABLE `review_tb`
  ADD PRIMARY KEY (`reviewID`);

--
-- Indexes for table `smscredits`
--
ALTER TABLE `smscredits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_tb`
--
ALTER TABLE `sms_tb`
  ADD PRIMARY KEY (`requestID`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `departmentID` (`departmentID`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transferID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `wardassigns`
--
ALTER TABLE `wardassigns`
  ADD PRIMARY KEY (`assignID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `wardlist`
--
ALTER TABLE `wardlist`
  ADD PRIMARY KEY (`wardID`),
  ADD KEY `centerID` (`centerID`);

--
-- Indexes for table `wardmeds`
--
ALTER TABLE `wardmeds`
  ADD PRIMARY KEY (`medID`);

--
-- Indexes for table `wardtreatmet`
--
ALTER TABLE `wardtreatmet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodbank`
--
ALTER TABLE `bloodbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bloodgroup_tb`
--
ALTER TABLE `bloodgroup_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `docreview_tb`
--
ALTER TABLE `docreview_tb`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `labresults`
--
ALTER TABLE `labresults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `prescribedmeds`
--
ALTER TABLE `prescribedmeds`
  MODIFY `prescribeid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `prescribeID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `review_tb`
--
ALTER TABLE `review_tb`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `smscredits`
--
ALTER TABLE `smscredits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sms_tb`
--
ALTER TABLE `sms_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `wardmeds`
--
ALTER TABLE `wardmeds`
  MODIFY `medID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `wardtreatmet`
--
ALTER TABLE `wardtreatmet`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `centeruser`
--
ALTER TABLE `centeruser`
  ADD CONSTRAINT `centeruser_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

--
-- Constraints for table `doctorappointment`
--
ALTER TABLE `doctorappointment`
  ADD CONSTRAINT `doctorappointment_ibfk_1` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`);

--
-- Constraints for table `lablist`
--
ALTER TABLE `lablist`
  ADD CONSTRAINT `lablist_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

--
-- Constraints for table `labresults`
--
ALTER TABLE `labresults`
  ADD CONSTRAINT `labresults_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

--
-- Constraints for table `pharmacy`
--
ALTER TABLE `pharmacy`
  ADD CONSTRAINT `pharmacy_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `department` (`departmentID`);

--
-- Constraints for table `wardassigns`
--
ALTER TABLE `wardassigns`
  ADD CONSTRAINT `wardassigns_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
