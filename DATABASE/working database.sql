-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2018 at 08:05 PM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

create database `quatmedics`;
use `quatmedics`;

--
-- Database: `quatmedics`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedlist`
--

CREATE TABLE `bedlist` (
  `bedNumber` varchar(255) NOT NULL,
  `wardID` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `centeruser`
--

CREATE TABLE `centeruser` (
  `userID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `accessLevel` varchar(10) NOT NULL,
  `dateRegistered` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `centeruser`
--

INSERT INTO `centeruser` (`userID`, `centerID`, `userName`, `password`, `accessLevel`, `dateRegistered`, `doe`) VALUES
('dsdf-000001', 'ABCD -000001', 'asd', '1234', 'CONSULTATI', '2018-09-14', '2018-09-14 11:31:04');

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
  `labType` varchar(255) NOT NULL,
    `consultingRoom` varchar(255) not null,
    `status` varchar(255) not null,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `labresults`
--

CREATE TABLE `labresults` (
  `labResultID` varchar(255) NOT NULL,
  `labID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `labResult` varchar(255) NOT NULL,
  `labDate` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
    `hometown` varchar(255) not null,
    `guardianName` varchar(255) not null,
    `guardianGender` varchar(255) not null,
    `guardianPhone` varchar(255) not null,
    `guardianRelation` varchar(255) not null,
    `guardianAddress` varchar(255) not null,
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacy`
--

CREATE TABLE `pharmacy` (
  `pharmacyID` varchar(255) NOT NULL,
  `centerID` varchar(255) NOT NULL,
  `dateRegistered` varchar(50) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `prescribeID` varchar(255) NOT NULL,
  `patientID` varchar(255) NOT NULL,
  `staffID` varchar(255) NOT NULL,
  `pharmacyID` varchar(255) NOT NULL,
  `prescription` varchar(255) NOT NULL,
  `prescribeStatus` varchar(255) NOT NULL,
  `datePrescribe` varchar(255) NOT NULL,
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
('dsdf-000001', '', 'CONSULTATION', 'asdas', 'dsdf', 'asdas', 'Male', 'Doctor', '2017-03-03', 'nkjh', '', '', '2018-09-14', '2018-09-14 11:31:04');

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
  `doe` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `bedlist`
--
ALTER TABLE `bedlist`
  ADD KEY `wardID` (`wardID`);

--
-- Indexes for table `centeruser`
--
ALTER TABLE `centeruser`
  ADD PRIMARY KEY (`userID`),
  ADD KEY `centerID` (`centerID`);

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
  ADD PRIMARY KEY (`labResultID`),
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
-- Constraints for dumped tables
--

--
-- Constraints for table `bedlist`
--
ALTER TABLE `bedlist`
  ADD CONSTRAINT `bedlist_ibfk_1` FOREIGN KEY (`wardID`) REFERENCES `wardlist` (`wardID`);

--
-- Constraints for table `centeruser`
--
ALTER TABLE `centeruser`
  ADD CONSTRAINT `centeruser_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);

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

--
-- Constraints for table `wardlist`
--
ALTER TABLE `wardlist`
  ADD CONSTRAINT `wardlist_ibfk_1` FOREIGN KEY (`centerID`) REFERENCES `medicalcenter` (`centerID`);
  
  
create table`consultingRoom`(
    `roomID` varchar(255) not null primary key,
    `centerID` varchar(255) not null primary key,
    `roomName` varchar(255) not null,
    `dateRegistered` varchar(255) not null,
    `doe` timestamp,
     index(centerID),
    foreign key (centerID) REFERENCES patient(centerID)
)engine = InnoDB;

create table `consultation`(
    `consultID` varchar(255) not null,
    `patientID` varchar(255) not null,
    `staffID` varchar(255) not null,
    `bodyTemperature` varchar(255) not null,
    `pulseRate` varchar(255) not null,
    `respirationRate` varchar(255) not null,
    `bloodPressure` varchar(255) not null,
    `weight` varchar(255) not null,
    `otherHealth` longtext null,
    `roomID` varchar(255) not null,
    `doe` timestamp,
    index(patientID),
    foreign key (patientID) REFERENCES patient(patientID)
)engine = InnoDB;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
