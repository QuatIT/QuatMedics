Create database `quatMedics`;
    use `quatMedics`;

create table `medicalcenter`(
    `centerID` varchar(255) not null primary key,
    `centerName` varchar(255) not null,
    `centerCategory` varchar(50) not null, /*Hopital, Clinic, etc*/
    `centerLocation` varchar(255) not null,
    `numOfStaff` varchar(255) not null,
    `centerHistory` longtext not null, /*Date established, lincensed etc*/
    `dateregistered` date not null,
    `doe` timestamp
)engine = InnoDB;

create table `department`(
    `departmentID` varchar(255) not null primary key,
    `centerID` varchar(255) not null,
    `departmentName` varchar(255) not null,
    `dateCreated` varchar(255) not null,
    `doe` timestamp,
    index(centerID),
    foreign key (centerID) references `medicalcenter`(centerID)
)engine = InnoDB;

create table `patient`(
    `centerID` varchar(255) not null,
    `patientID` varchar(255) not null primary key,
    `firstName` varchar(100) not null,
    `otherName` varchar(100) not null,
    `lastName` varchar(100) not null,
    `dob` varchar(50) not null,
    `gender` varchar(10) not null,
    `bloodGroup` varchar(100) not null,
    `homeAddress` varchar(255) not null,
    `phoneNumber` varchar(20) not null,
    `dateRegistered` varchar(50) not null,
    `doe` timestamp,
    index (centerID),
    foreign key (centerID) references `medicalcenter`(centerID)
)engine = InnoDB;

create table `doctors`(
    `doctorID` varchar(255) not null primary key,
    `departmentID` varchar(255) not null,
    `title` varchar(20) not null,
    `firstName` varchar(255) not null,
    `lastName` varchar(255) not null,
    `otherName` varchar(255) not null,
    `gender` varchar(10) not null,
    `dob` varchar(50) not null,
    `specialty` varchar(200) not null,
    `license` varchar(255) not null,
    `dateEmployed` varchar(255) not null,
    `dateRegistered` varchar(255) not null,
    `doe` timestamp,
    index(departmentID),
    foreign key (departmentID) references `department`(departmentID)
)engine = InnoDB;

create table `nurses`(
    `nurseID` varchar(255) not null,
    `departmentID` varchar(255) not null,
    `firstName` varchar(255) not null,
    `lastName` varchar(255) not null,
    `otherName` varchar(255) not null,
    `dob` date not null,
    `gender` varchar(10) not null,
    `license` varchar(255) not null,
    `dateEmployed` varchar(255) not null,
    `dateRegistered` varchar(255) not null,
    `doe` timestamp,
    index(departmentID),
    foreign key (departmentID) references `department`(departmentID)
)engine = InnoDB;

create table `wardList`(
    `wardID` varchar(255) not null primary key,
    `centerID` varchar(255) not null,
    `wardName` varchar(255) not null,
    `numOfBeds` varchar(255) not null,
    `dateRegistered` varchar(255) not null,
    `doe` timestamp,
    index(centerID),
    foreign key (centerID) references `medicalcenter`(centerID)
)engine = InnoDB;

create table `wardAssigns`(
    `assignID` varchar(255) not null primary key,
    `wardID` varchar(255) not null,
    `patientID` varchar(255) not null,
    `doctorID` varchar(255) not null,
    `admitDate` varchar(255) not null,
    `dischargeDate` varchar(255) not null,
    `doe` timestamp,
    index(patientID),
    foreign key(patientID) references `patient`(patientID)
)engine = InnoDB;

create table `bedList`(
    `bedNumber` varchar(255) not null,
    `wardID` varchar(255) not null,
    `doe` timestamp,
    index(wardID),
    foreign key(wardID) references `wardList`(wardID)
)engine = InnoDB;

create table `doctorAppointment`(
    `appointNumber` varchar(255) not null,
    `doctorID` varchar(255) not null,
    `patientID` varchar(255) not null,
    `appointmentDate` varchar(255) not null,
    `appointmentTime` varchar(255) not null,
    `doe` timestamp,
    index(doctorID),
    foreign key(doctorID) references `doctor`(doctorID)
)engine = InnoDB;

create table `pharmacy`(
    `pharmacyID` varchar(255) not null primary key,
    `centerID` varchar(255) not null,
    `dateRegistered` varchar(50) not null,
    `doe` timestamp,
    index(centerID),
    foreign key(centerID) references `medicalcenter`(centerID)
)engine = InnoDB;

create table `prescriptions`(
    `prescribeID` varchar(255) not null primary key,
    `patientID` varchar(255) not null,
    `doctorID` varchar(255) not null,
    `pharmacyID` varchar(255) not null,
    `prescription` varchar(255) not null,
    `prescribeStatus` varchar(255) not null, /*prescibed, carried out, etc..*/
    `datePrescribe` varchar(255) not null,
    `doe` timestamp,
    index(patientID),
    foreign key (patientID) references `patient`(patientID)
)engine = InnoDB;

create table `labList`(
    `labID` varchar(255) not null primary key,
    `labName` varchar(255) not null,
    `centerID` varchar(255) not null,
    `labType` varchar(255) not null,
    `doe` timestamp,
    index(centerID),
    foreign key(centerID) references `medicalcenter`(centerID)
)engine = InnoDB;

create table `labResults`(
    `labResultID` varchar(255) not null primary key,
    `labID` varchar(255) not null,
    `patientID` varchar(255) not null,
    `doctorID` varchar(255) not null,
    `labResult` varchar(255) not null,
    `labDate` varchar(255) not null,
    `doe` timestamp,
    index(patientID),
    foreign key(patientID) references `patient`(patientID)
)engine = InnoDB;

-- new tables
create table `bloodBank`(
    `bloodID` varchar(255) not null primary key,
     `donorID` varchar(255) not null,
    `charge` varchar(255) not null,
    `amtAvail` varchar(255) not null,
    `donorName` varchar(255) not null,
    `gender` varchar(10) not null,
    `bloodGroup` varchar(100) not null,
    `homeAddress` varchar(255) not null,
    `phoneNumber` varchar(20) not null,
     `dob` varchar(50) not null,
    `doe` timestamp,
    index(donorID),
    foreign key(bloodID) references `bloodGroup_tb`(bloodID)
)engine = InnoDB;

create table `bloodGroup_tb`(
    `bloodID` varchar(255) not null primary key,
    `bloodGroup` varchar(255) not null,
    `bloodBags` varchar(255) not null,
    `doe` timestamp,
    index(bloodID),
    foreign key(bloodGroup) references `bloodBank`(bloodGroup_tb)
)engine = InnoDB;
