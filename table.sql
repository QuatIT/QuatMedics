create table `wardMeds`(
	`medID` int(255) null primary key auto_increment,
	`assignID` varchar(255) null,
	`patientID` varchar(255) null,
	`staffID` varchar(255) null,
	`wardID` varchar(255) null,
	`medicine` varchar(255) null,
	`dosage` varchar(255) null,
	`doe` timestamp,
)engine = InnoDB;

create table `Prices`(
	`serviceID` varchar(255) null primary key,
	`centerID` varchar(255) null,
	`serviceName` varchar(255) null, /* COnsultation ... etc*/
	`servicePrice` decimal(10,2) null,
	`serviceType` varchar(255) null,
	`dateInsert` date null,
	`doe` timestamp
)engine = InnoDB;

create table `PaymentFixed`(
	`id` int(255) null primary key auto_increment,
	`patientID` varchar(255) null,
	`centerID` varchar(50) null,
	`paymode` varchar(255) null,
	`serviceName` varchar(255) null, /* OPD, consultation,  */
	`servicePrice` varchar(255) null,
	`serviceType` varchar(255) null,
	`status` varchar(255) null, /* paid , Not paid */
	`dateinsert` date null,
	`doe` timestamp
)engine = InnoDB;

create table `MedsPrices`(
	`id` int(255) null primary key auto_increment,
	`patientID` varchar(255) null,
	`centerID` varchar(50) null,
	`paymode` varchar(255) null,
	`medName` varchar(255) null,
	`medPrice` double(10,2) null,
	`status` varchar(255) null,
	`dateInsert` date null,
	`doe` timestamp
)engine = InnoDB;

create table `labPayment`(
	`id` int(255) null primary key auto_increment,
	`patientID` varchar(255) null,
	`centerID` varchar(255) null,
	`paymode` varchar(255) null,
	`labName` varchar(255) null,
	`labPrice` decimal(10,2) null,
	`status` varchar(255) null,
	`dateInsert` date null,
	`doe` timestamp
)engine = InnoDB;

create table `accounts`(
	`accountID` int(255) not null primary key auto_increment,
	`centerID` varchar(255) not null,
	`accountName` varchar(255) not null, /* OPD, CONSULTATION ETC..*/
	`accountType` varchar(255) not null, /* CREDIT DEBIT ACCOUNT..*/
	`dateInsert` date not null,
	`doe` timestamp
)engine = InnoDB;

create table `transactionAccount`(
	`id` int(255) not null primary key auto_increment,
	`creditAcc` varchar(255) not null,
	`debitAcc` varchar(255) not null,
	`Amount` decimal(10,2) not null,
	`patientID` varchar(255) not null,
	`staffID` varchar(255) not null,
	`activity` varchar(255) not null,
	`dateInsert` date not null,
	`doe` timestamp
)engine = InnoDB;
