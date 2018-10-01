-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2018 at 04:29 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quatmedics`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedlist`
--

CREATE TABLE `bedlist` (
  `bedNumber` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `bedDescription` varchar(255) NOT NULL,
  `BedCharge` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Dumping data for table `birth`
--

INSERT INTO `birth` (`babyID`, `centerID`, `babyFirstName`, `babyOtherName`, `babylastName`, `fullname`, `dob`, `motherName`, `fatherName`, `birthTime`, `country`, `status`, `dateRegistered`, `doe`) VALUES
('18-000001', '', '', '', '', '  ', '2008-04-20', 'fjhfkf', 'jhfjkfjfkj', '18:50:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:19:16'),
('18-000002', '', 'dfsdfsd', 'gerertert', '', 'dfsdfsd gerertert ', '2036-03-17', 'wfwefewrt  ewrhwerty', 'et erthghdhdh', '23:58:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:21:55'),
('18-000003', '', 'dfsdfsd', 'gerertert', '', 'dfsdfsd gerertert ', '2036-03-17', 'wfwefewrt  ewrhwerty', 'et erthghdhdh', '23:58:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:22:50'),
('18-000004', '', 'dfsdfsd', 'gerertert', '', 'dfsdfsd gerertert ', '2036-03-17', 'wfwefewrt  ewrhwerty', 'et erthghdhdh', '23:58:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:23:17'),
('bhuyb18-000005', '', 'fvdvsd', 'kjhfjh', 'bhuyb', 'fvdvsd kjhfjh bhuyb', '2015-10-29', 'hvmjvmjh jh jvv', 'fcfch', '09:56:00', 'GHANA', 'living', '2018-09-29', '2018-09-29 11:05:16'),
('hjgkh18-000005', '', 'wweerqwer', 'ghgjfghjfg', 'hjgkhfg', 'wweerqwer ghgjfghjfg hjgkhfg', '1980-01-03', 'jhfjhgjfjfkj', 'fufjudjufjv', '09:39:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:23:54'),
('hjgkh18-000006', '', 'wweerqwer', 'ghgjfghjfg', 'hjgkhfg', 'wweerqwer ghgjfghjfg hjgkhfg', '1980-01-03', 'jhfjhgjfjfkj', 'fufjudjufjv', '09:39:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:26:01'),
('sdfsd18-000007', '', 'asdasdasd', 'asdasdasda', 'sdfsdfsdfsd', 'asdasdasd asdasdasda sdfsdfsdfsd', '2018-09-18', 'wfwefewrt  ewrhwerty', 'jhfjkfjfkj', '07:10:00', 'GHANA', 'living', '2018-09-28', '2018-09-28 15:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `bloodbank`
--

CREATE TABLE `bloodbank` (
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
  `bloodID` varchar(255) NOT NULL,
  `bloodGroup` varchar(255) NOT NULL,
  `charge` varchar(200) NOT NULL,
  `bloodBags` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bloodgroup_tb`
--

INSERT INTO `bloodgroup_tb` (`bloodID`, `bloodGroup`, `charge`, `bloodBags`, `doe`) VALUES
('BD - 241826', 'O-positive', '', '3', '2018-09-24 12:53:17');

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
('Annan-000005', 'ABCD -000001', 'Annan-000005', 'jannan', '1234', 'WARD', '2018-09-26', '2018-09-26 09:13:45'),
('Berch-000004', 'ABCD -000001', 'Berch-000004', 'kberchie', '1234', 'PHARMACY', '2018-09-26', '2018-09-26 09:24:27'),
('Effah-000003', 'ABCD -000001', 'Effah-000003', 'geffah', '1234', 'LABORATORY', '2018-09-26', '2018-09-26 08:56:27'),
('Kanfr-000001', 'ABCD -000001', 'Kanfr-000001', 'rkanfrah', '12345', 'CONSULTATION', '2018-09-22', '2018-09-25 09:14:08'),
('Uke-000002', 'ABCD -000001', 'Uke-000002', 'duke', '1234', 'OPD', '2018-09-25', '2018-09-25 17:11:47');

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
  `status` varchar(30) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consultID`, `patientID`, `staffID`, `bodyTemperature`, `mode`, `insuranceType`, `insuranceNumber`, `company`, `pulseRate`, `respirationRate`, `bloodPressure`, `weight`, `otherHealth`, `roomID`, `status`, `doe`) VALUES
('CON-ABCD -000003', 'qqqqq-000004', 'Kanfr-000001', '434', '', '', '', '', '55q', '444', '434444444', '533', 'ggg', 'CR-ABCD -000002', 'sent_to_consulting', '2018-09-25 09:46:03'),
('CON-ABCD -000004', 'dfdf-000002', 'Kanfr-000001', '24', '', '', '', '', '78', '987', '67', '9788', 'HJJ', 'CR-ABCD -000002', 'sent_to_pharmacy', '2018-09-26 10:00:43'),
('CON-ABCD -000005', 'dfdf-000002', 'Kanfr-000001', '243', '', '', '', '', '987', '9879', '77864', '878', 'hoh89', 'CR-ABCD -000002', 'sent_to_pharmacy', '2018-09-26 10:09:53'),
('CON-ABCD -000006', 'PNT-0001', 'Kanfr-000001', '768', '', '', '', '', '875', '756', '564', '3456', '87ghjgh', 'CR-ABCD -000001', 'sent_to_lab', '2018-09-25 09:37:26'),
('CON-ABCD -000007', 'qqqqq-000004', 'Uke-000002', '253', 'Insurance', 'NHIS', '123587796325', '', '456', '4563', '45645', '65756', 'h  nfnf 4545', 'CR-ABCD -000001', 'sent_to_consulting', '2018-10-01 12:11:04'),
('consult-0001', 'PNT-0001', 'Kanfr-000001', '50', '', '', '', '', '45', '45', '45', '90', NULL, 'CR-ABCD -000003', 'sent_to_pharmacy', '2018-09-25 10:00:11'),
('consult-0002', 'PNT-0001', 'Kanfr-000001', '52', '', '', '', '', '25', '25', '15', '90', NULL, 'CR-ABCD -000003', 'sent_to_lab', '2018-09-25 09:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `consultingroom`
--

CREATE TABLE `consultingroom` (
  `roomID` varchar(255) NOT NULL,
  `roomName` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultingroom`
--

INSERT INTO `consultingroom` (`roomID`, `roomName`, `centerID`, `dateRegistered`, `doe`) VALUES
('CR-ABCD -000001', '1', 'ABCD -000001', '2018-09-17', '2018-09-25 08:55:14'),
('CR-ABCD -000002', '2', 'ABCD -000001', '2018-09-17', '2018-09-25 08:55:18'),
('CR-ABCD -000003', '3', 'ABCD -000001', '2018-09-17', '2018-09-17 16:04:51'),
('CR-ABCD -000004', '4', 'ABCD -000001', '2018-09-17', '2018-09-25 08:55:29');

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

--
-- Dumping data for table `death`
--

INSERT INTO `death` (`deathID`, `patientID`, `centerID`, `deathDate`, `deathTime`, `reason`, `dateRegistered`, `doe`) VALUES
('bhuyb-000001', 'bhuyb18-000005', '', '2016-10-30', '10:57:00', 'sdsdv d df fdghdf ghdfghdg hd', '2018-09-29', '2018-09-29 13:21:05');

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
('CONSULTATION', 'ABCD -000001', 'CONSULTATION', '', '2018-09-14 10:36:15'),
('LABORATORY', 'ABCD -000001', 'LABORATORY', '', '2018-09-14 10:40:32'),
('OPD', 'ABCD -000001', 'OPD', '', '2018-09-25 20:51:23'),
('PHARMACY', 'ABCD -000001', 'PHARMACY', '', '2018-09-14 10:40:19'),
('WARD', 'ABCD -000001', 'WARD', '', '2018-09-14 10:40:19');

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
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctorappointment`
--

INSERT INTO `doctorappointment` (`appointNumber`, `staffID`, `patientID`, `appointmentDate`, `appointmentTime`, `doe`) VALUES
('APTMNT-1', 'Kanfr-000001', 'PNT-0001', '2018-09-27', '15:01', '2018-09-25 11:12:37'),
('APTMNT-2', 'Kanfr-000001', 'fgdfg-000003', '2018-09-14', '14:00', '2018-09-25 11:13:52');

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
('lab001', 'Malaria Test', 'ABCD -000001', '2018-09-16 10:41:49'),
('lab002', 'DNA Test', 'ABCD -000001', '2018-09-16 10:56:12'),
('lab003', 'CT Scan', 'ABCD -000001', '2018-09-16 10:56:12');

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
(1, 'LABREQ-1', 'CON-ABCD -000006', 'lab001', 'ABCD -000001', 'PNT-0001', '', 'uploads/5ba8db3b253265.36862409.pdf', '', 'CR-ABCD -000001', 'sent_to_consulting', '2018-09-25 09:25:16'),
(2, 'LABREQ-2', 'CON-ABCD -000006', 'lab002', 'ABCD -000001', 'PNT-0001', '', 'uploads/5ba8db3b253265.36862409.pdf', '', 'CR-ABCD -000001', 'sent_to_consulting', '2018-09-25 09:25:21'),
(7, 'LABREQ-3', 'CON-ABCD -000006', 'lab001', 'ABCD -000001', 'PNT-0001', 'Kanfr-000001', '', '', 'CR-ABCD -000001', 'sent_to_lab', '2018-09-25 09:32:36'),
(8, 'LABREQ-4', 'CON-ABCD -000006', 'lab001', 'ABCD -000001', 'PNT-0001', 'Kanfr-000001', 'uploads/ABCD -000001/labresults/5bb0eb1d39ef98.81615485.pdf', '', 'CR-ABCD -000001', 'sent_to_consulting', '2018-09-30 15:26:21'),
(9, 'LABREQ-5', 'consult-0002', 'lab002', 'ABCD -000001', 'PNT-0001', 'Kanfr-000001', 'uploads/5bb0db8ce43e12.80421914.pdf', '', 'CR-ABCD -000003', 'sent_to_consulting', '2018-09-30 14:19:56');

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
  `userName` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accessLevel` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicalcenter`
--

INSERT INTO `medicalcenter` (`centerID`, `centerName`, `centerCategory`, `centerLocation`, `numOfStaff`, `centerHistory`, `dateregistered`, `numOfBranches`, `userName`, `password`, `accessLevel`, `doe`) VALUES
('ABCD -000001', 'ABCD HOSPITAL', 'Hospital', 'LAPAZ', '10', 'NA', '0000-00-00', '2', 'abc', '12345', 'center_admin', '2018-09-25 11:32:08'),
('fhf-000005', 'fhf', 'Hospital', 'fkhfkhf', '57687', 'nmbhmb,bh', '2018-09-28', '76', 'fkhj', '46767865', 'center_admin', '2018-09-28 12:03:55'),
('fjhh-000006', 'fjhh', 'Hospital', 'gfjhgfjf', '676587', 'dfsfsd hi hiuhihih hiuhh', '2018-09-28', '5476', 'fhjfjhjb', 'jfffhf', 'center_admin', '2018-09-28 12:24:50'),
('kgbmn-000003', 'kgbmnhgtfy', 'Hospital', 'yfkguvj', '899', 'knknk', '2018-09-28', '78', 'jkvbjkh', 'bbbbbb', 'center_admin', '2018-09-28 11:52:42'),
('kgbmn-000004', 'kgbmnhgtfy', 'Hospital', 'yfkguvj', '899', 'knknk', '2018-09-28', '78', 'jkvbjkh', 'bbbbbb', 'center_admin', '2018-09-28 12:02:32'),
('mnbmn-000002', 'mnbmnbb', 'Hospital', 'bbjh', '45', 'bnmbm', '2018-09-28', '775', 'qwerty', '123456', 'center_admin', '2018-09-28 11:45:08'),
('QWERT-000007', 'QWERTY HOSPITAL', 'Hospital', 'yfkguvj', '12', 'AJFWJEF WEFWEF ', '2018-09-30', '32', 'QwertyAdmin', '1234', 'center_admin', '2018-09-30 15:10:30');

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
('ABCD -000001', 'bhuyb18-000005', 'fvdvsd', 'kjhfjh', 'bhuyb', '2015-10-29', '', '', '', '', '', 'hvmjvmjh jh jvv', '', '', '', '', '', '', 'dead', '', '', '2018-09-30 17:19:09'),
('ABCD -000001', 'dfdf-000002', 'fgsdfg', 'vcbcv', 'dfdf', '2002-03-29', 'Female', 'A-negative', 'gfhfh', '453455', '', 'fgdsf', '', '765', 'gbfd', 'gfb fdfb', 'ABCD -000001', 'patient_busy', '', '', '2018-09-17', '2018-09-23 17:33:13'),
('ABCD -000001', 'fgdfg-000003', 'bbdfb dfbdf', 'ewrt', 'fgdfgdfg', '2014-03-29', 'Male', 'O-negative', 'jhgdf', '34768693', '', 'fghh ghd ghdgh', '', '65474', 'gdfhdfhg fgndf', 'fhdfhdfgh fdghertwe etjytje', '', '', '', '', '2018-09-17', '2018-09-30 17:19:16'),
('ABCD -000001', 'PNT-0001', 'Godwin', 'Goodman', 'Effah', '1995-05-0', 'Male', 'O-Positive', 'Accra', '0541524233', 'Obuasi', 'Mr Effah', 'Male', '0269807823', 'Father', '', 'ABCD -000001', 'patient_busy', '', '', '2018-15-09', '2018-09-23 17:57:06'),
('ABCD -000001', 'qqqqq-000004', 'kkkkkkk', 'ccccc', 'qqqqqq', '2014-04-29', 'Male', 'B-positive', 'nnn', '666666666', '', 'tyuuuuu', '', '77777', 'fffffffffffff', 'iuuuuuuu', 'ABCD -000001', 'patient_busy', '', '', '2018-09-21', '2018-10-01 12:06:52'),
('ABCD -000001', 'qqqqq-000006', 'cccccccccccccc', 'sss', 'qqqqqqqqqq', '1999-03-15', 'Male', 'A-negative', 'kjfjfhjfh', '3435343', '', 'ddfbdf dfbdfb', '', '5345655546', 'dfdfhf', 'cnndfg dghddh', '', '', '', 'uploads/ABCD -000001/patient/qqqqq-000006_1538384396.jpg', '2018-10-01', '2018-10-01 08:59:56');

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
('PHA-1', 'ABCD -000001', 'ABCD HOSPITAL PHARMACY', '2018-09-17', '2018-09-17 18:19:10');

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
(1, 'PRSCB-1', 'PARA', '2X1', 'Prescibed', '', '2018-09-17 19:48:13'),
(2, 'PRSCB-2', 'Malaquine', '1x3', 'Prescibed', '', '2018-09-17 19:49:35'),
(3, 'PRSCB-3', 'HIV Meds', '1x3', 'Prescibed', '', '2018-09-25 10:00:10'),
(4, 'PRSCB-4', 'vvvvvvv', '1x2', 'Prescibed', '', '2018-09-26 10:00:43'),
(5, 'PRSCB-4', 'ggggggggg', '1x2', 'Prescibed', '', '2018-09-26 10:00:43'),
(6, 'PRSCB-4', 'eeeeeeeeeeee', '2x4', 'Prescibed', '', '2018-09-26 10:00:43'),
(7, 'PRSCB-5', 'qqqqqqqqqqq', '2x4', 'served', 'ryrtyrty', '2018-09-29 11:59:44'),
(8, 'PRSCB-5', '11111eeeeeeeeeeee', '1x4', 'served', 'gdgertyerty', '2018-09-27 14:07:18');

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
(1, 'PNT-0001', 'PRSCB-1', 'staff-0001', 'pharmacy-1', 'headache', 'has fever', 'Prescibed', '', '2018-09-17', '2018-09-17 19:48:13'),
(2, 'PNT-0001', 'PRSCB-2', 'staff-0001', 'pharmacy-1', 'feverish, cold,', 'has malaria', 'Prescibed', '', '2018-09-17', '2018-09-17 19:49:35'),
(3, 'PNT-0001', 'PRSCB-3', 'Kanfr-000001', 'PHA-1', 'all the symptoms', 'Patient has HIV', 'Prescibed', '', '2018-09-25', '2018-09-25 10:00:10'),
(4, 'dfdf-000002', 'PRSCB-4', 'Kanfr-000001', 'PHA-1', 'ddfsdfs', 'rert', 'Prescibed', '', '2018-09-26', '2018-09-26 10:00:43'),
(5, 'dfdf-000002', 'PRSCB-5', 'Kanfr-000001', 'PHA-1', 'fbgbbbbbbbbbbbbbbbbbbbb', 'wefwef fwe', 'Prescibed', '5f175e09c5de7c64', '2018-09-26', '2018-09-26 10:09:52');

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
  `dateEmployed` varchar(255) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `staffType`, `centerID`, `departmentID`, `firstName`, `lastName`, `otherName`, `gender`, `staffCategory`, `dob`, `specialty`, `license`, `dateEmployed`, `dateRegistered`, `doe`) VALUES
('Annan-000005', '', 'ABCD -000001', 'WARD', 'Justice', 'Annan', '', 'Male', 'Nurse', '2000-09-11', 'general nurse', '', '', '2018-09-26', '2018-09-27 16:37:45'),
('Berch-000004', '', 'ABCD -000001', 'PHARMACY', 'Kofi', 'Berchie', '', 'Male', 'Doctor', '2006-11-19', 'pharmacy', '', '', '2018-09-26', '2018-09-27 16:37:50'),
('Effah-000003', '', 'ABCD -000001', 'LABORATORY', 'Godwin', 'Effah', 'Goodman', 'Male', 'Doctor', '2006-07-22', 'lab technician', '', '', '2018-09-26', '2018-09-27 16:38:36'),
('Kanfr-000001', '', 'ABCD -000001', 'CONSULTATION', 'Richard', 'Kanfrah', '', 'Male', 'Doctor', '2003-08-18', 'pharmacy', '', '', '2018-09-22', '2018-09-27 16:38:39'),
('Uke-000002', '', 'ABCD -000001', 'OPD', 'David', 'Uke', 'Yaw', 'Male', 'Nurse', '2001-03-20', 'nurse', '', '', '2018-09-25', '2018-09-27 16:38:43');

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
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `admitDate` varchar(255) NOT NULL,
  `dischargeDate` varchar(255) NOT NULL,
  `admitDetails` longtext NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wardassigns`
--

INSERT INTO `wardassigns` (`assignID`, `wardID`, `patientID`, `staffID`, `admitDate`, `dischargeDate`, `admitDetails`, `doe`) VALUES
('ASSIGN-0001', 'ward-002', 'PNT-0001', 'staff-0001', '2018-09-17', '2018-09-27', '', '2018-09-25 09:58:44'),
('ASSIGN-2', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-19', '2018-09-27', '', '2018-09-25 09:58:49'),
('ASSIGN-3', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-28', '2018-09-26', '', '2018-09-25 09:59:06'),
('ASSIGN-4', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-26', '2018-09-25', 'Treatment And Observation', '2018-09-25 09:59:11'),
('ASSIGN-5', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-26', '2018-09-25', 'Treatment And Observation', '2018-09-25 09:59:15'),
('ASSIGN-6', 'WARD-001', 'PNT-0001', 'Kanfr-000001', '2018-09-25', '2018-09-27', 'Operation', '2018-09-25 09:59:20');

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
('WARD-001', 'ABCD-000001', 'Maternity Ward', '20', '2018-09-16', '2018-09-16 12:40:20'),
('WARD-002', 'ABCD-000001', 'Emergency Ward', '10', '2018-09-16', '2018-09-16 12:41:10');

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
  ADD KEY `wardID` (`wardID`);

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
  ADD KEY `donorID` (`donorID`),
  ADD KEY `bloodID` (`bloodID`);

--
-- Indexes for table `bloodgroup_tb`
--
ALTER TABLE `bloodgroup_tb`
  ADD PRIMARY KEY (`bloodID`);

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
-- Indexes for table `doctorappointment`
--
ALTER TABLE `doctorappointment`
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
-- Indexes for table `wardtreatmet`
--
ALTER TABLE `wardtreatmet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `labresults`
--
ALTER TABLE `labresults`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `prescribedmeds`
--
ALTER TABLE `prescribedmeds`
  MODIFY `prescribeid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `prescribeID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `wardtreatmet`
--
ALTER TABLE `wardtreatmet`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bedlist`
--
ALTER TABLE `bedlist`
  ADD CONSTRAINT `bedlist_ibfk_1` FOREIGN KEY (`wardID`) REFERENCES `wardlist` (`wardID`);

--
-- Constraints for table `bloodbank`
--
ALTER TABLE `bloodbank`
  ADD CONSTRAINT `bloodbank_ibfk_1` FOREIGN KEY (`bloodID`) REFERENCES `bloodgroup_tb` (`bloodID`);

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
