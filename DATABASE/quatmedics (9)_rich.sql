-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2018 at 05:30 PM
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
('Kanfr-000001', 'ABCD -000001', '', 'rkanfrah', '12345', 'CONSULTATION', '2018-09-22', '2018-09-22 01:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consultID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `bodyTemperature` varchar(255) NOT NULL,
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

INSERT INTO `consultation` (`consultID`, `patientID`, `staffID`, `bodyTemperature`, `pulseRate`, `respirationRate`, `bloodPressure`, `weight`, `otherHealth`, `roomID`, `status`, `doe`) VALUES
('CON-ABCD -000003', 'qqqqq-000004', 'Kanfr-000001', '434', '55q', '444', '434444444', '533', 'ggg', 'CR-ABCD -000002', 'CONSULTED', '2018-09-22 02:01:17'),
('CON-ABCD -000004', 'dfdf-000002', 'Kanfr-000001', '24', '78', '987', '67', '9788', 'HJJ', 'CR-ABCD -000002', '', '2018-09-23 16:53:10'),
('CON-ABCD -000005', 'dfdf-000002', 'Kanfr-000001', '243', '987', '9879', '77864', '878', 'hoh89', 'CR-ABCD -000002', '', '2018-09-23 17:33:13'),
('CON-ABCD -000006', 'PNT-0001', 'Kanfr-000001', '768', '875', '756', '564', '3456', '87ghjgh', 'CR-ABCD -000001', 'CONSULTED', '2018-09-24 08:50:32'),
('consult-0001', 'PNT-0001', 'staff-0001', '50', '45', '45', '45', '90', NULL, '1', 'CONSULTED', '2018-09-17 18:08:51'),
('consult-0002', 'PNT-0001', 'staff-0001', '52', '25', '25', '15', '90', NULL, 'CR-ABCD -000003', 'CONSULTED', '2018-09-20 10:35:52');

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
('CR-ABCD -000001', '2', 'ABCD -000001', '2018-09-17', '2018-09-17 12:01:05'),
('CR-ABCD -000002', '345', 'ABCD -000001', '2018-09-17', '2018-09-17 16:04:12'),
('CR-ABCD -000003', '3', 'ABCD -000001', '2018-09-17', '2018-09-17 16:04:51'),
('CR-ABCD -000004', '5', 'ABCD -000001', '2018-09-17', '2018-09-17 16:08:00');

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
('ODP', 'ABCD -000001', 'ODP', '', '2018-09-14 10:36:15'),
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
(1, 'REQUEST1', 'CON-ABCD -000006', 'lab001', 'ABCD -000001', 'PNT-0001', '', 'uploads/5ba8db3b253265.36862409.pdf', '', 'CR-ABCD -000001', 'sent_to_consulting', '2018-09-24 15:05:13'),
(2, 'REQUEST1', 'CON-ABCD -000006', 'lab002', 'ABCD -000001', 'PNT-0001', '', 'uploads/5ba8db3b253265.36862409.pdf', '', 'CR-ABCD -000001', 'sent_to_consulting', '2018-09-24 15:05:06');

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
('ABCD -000001', 'ABCD HOSPITAL', 'Hospital', 'LAPAZ', '10', 'NA', '0000-00-00', '2', 'abc', '12345', 'center_admin', '2018-09-14 09:41:18');

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
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`centerID`, `patientID`, `firstName`, `otherName`, `lastName`, `dob`, `gender`, `bloodGroup`, `homeAddress`, `phoneNumber`, `hometown`, `guardianName`, `guardianGender`, `guardianPhone`, `guardianRelation`, `guardianAddress`, `lock_center`, `patient_status`, `dateRegistered`, `doe`) VALUES
('ABCD -000001', 'dfdf-000002', 'fgsdfg', 'vcbcv', 'dfdf', '2002-03-29', 'Female', 'A-negative', 'gfhfh', '453455', '', 'fgdsf', '', '765', 'gbfd', 'gfb fdfb', 'ABCD -000001', 'patient_busy', '2018-09-17', '2018-09-23 17:33:13'),
('ABCD -000001', 'fgdfg-000003', 'bbdfb dfbdf', 'ewrt', 'fgdfgdfg', '2014-03-29', 'Male', 'O-negative', 'jhgdf', '34768693', '', 'fghh ghd ghdgh', '', '65474', 'gdfhdfhg fgndf', 'fhdfhdfgh fdghertwe etjytje', '', '', '2018-09-17', '2018-09-17 10:21:52'),
('ABCD -000001', 'PNT-0001', 'Godwin', 'Goodman', 'Effah', '1995-05-0', 'Male', 'O-Positive', 'Accra', '0541524233', 'Obuasi', 'Mr Effah', 'Male', '0269807823', 'Father', '', 'ABCD -000001', 'patient_busy', '2018-15-09', '2018-09-23 17:57:06'),
('ABCD -000001', 'qqqqq-000004', 'kkkkkkkkkkkkkkkkkkkkkkkkkk', 'ccccccccccccc', 'qqqqqqqqqqqqqqqqqqqqqqqq', '2014-04-29', 'Male', 'B-positive', 'nnnnnnnnnnnnnnnnn', '66666666666666', '', 'tyuuuuuuuuuuuuuuu', '', '777777777777777777', 'fffffffffffff', 'iuuuuuuuuuuuuuuuu', '', '', '2018-09-21', '2018-09-21 11:08:51');

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
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescribedmeds`
--

INSERT INTO `prescribedmeds` (`prescribeid`, `prescribeCode`, `medicine`, `dosage`, `prescribeStatus`, `doe`) VALUES
(1, 'PRSCB-1', 'PARA', '2X1', 'Prescibed', '2018-09-17 19:48:13'),
(2, 'PRSCB-2', 'Malaquine', '1x3', 'Prescibed', '2018-09-17 19:49:35');

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
  `datePrescribe` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`prescribeID`, `patientID`, `prescribeCode`, `staffID`, `pharmacyID`, `symptoms`, `diagnose`, `prescribeStatus`, `datePrescribe`, `doe`) VALUES
(1, 'PNT-0001', 'PRSCB-1', 'staff-0001', 'pharmacy-1', 'headache', 'has fever', 'Prescibed', '2018-09-17', '2018-09-17 19:48:13'),
(2, 'PNT-0001', 'PRSCB-2', 'staff-0001', 'pharmacy-1', 'feverish, cold,', 'has malaria', 'Prescibed', '2018-09-17', '2018-09-17 19:49:35');

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

INSERT INTO `staff` (`staffID`, `staffType`, `departmentID`, `firstName`, `lastName`, `otherName`, `gender`, `staffCategory`, `dob`, `specialty`, `license`, `dateEmployed`, `dateRegistered`, `doe`) VALUES
('Kanfr-000001', '', 'CONSULTATION', 'Richard', 'Kanfrah', '', 'Male', 'Doctor', '2003-08-18', 'pharmacy', '', '', '2018-09-22', '2018-09-22 01:35:38');

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
('assign-0001', 'ward-002', 'PNT-0001', 'staff-0001', '2018-09-17', '2018-09-27', '', '2018-09-17 17:56:53'),
('assign-2', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-19', '2018-09-27', '', '2018-09-17 18:01:44'),
('assign-3', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-28', '2018-09-26', '', '2018-09-17 18:04:21'),
('assign-4', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-26', '2018-09-25', 'Treatment And Observation', '2018-09-17 18:05:43'),
('assign-5', 'ward-001', 'PNT-0001', 'staff-0001', '2018-09-26', '2018-09-25', 'Treatment And Observation', '2018-09-17 18:08:51');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `prescribedmeds`
--
ALTER TABLE `prescribedmeds`
  MODIFY `prescribeid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `prescribeID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
