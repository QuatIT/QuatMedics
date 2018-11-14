create table `wardMeds`(
	`medID` int(255) not null primary key auto_increment,
	`assignID` varchar(255) not null,
	`patientID` varchar(255) not null,
	`staffID` varchar(255) not null,
	`wardID` varchar(255) not null,
	`medicine` varchar(255) not null,
	`dosage` varchar(255) not null,
	`doe` timestamp,
)engine = InnoDB;

create table `Prices`(
	`serviceID` varchar(255) not null primary key,
	`centerID` varchar(255) not null,
	`serviceName` varchar(255) not null, /* COnsultation ... etc*/
	`servicePrice` decimal(10,2) not null,
	`serviceType` varchar(255) not null,
	`dateInsert` date not null,
	`doe` timestamp
)engine = InnoDB;

create table `PaymentFixed`(
	`id` int(255) not null primary key auto_increment,
	`patientID` varchar(255) not null,
	`paymode` varchar(255) not null,
	`Name` varchar(255) not null, /* OPD, consultation,  */
	`price` varchar(255) not null,
	`status` varchar(255) not null, /* paid , Not paid */
	`dateinsert` date not null,
	`doe` timestamp
)engine = InnoDB;

create table `MedsPrices`(
	`id` int(255) not null primary key auto_increment,
	`patientID` varchar(255) not null,
	`paymode` varchar(255) not null,
	`medName` varchar(255) not null,
	`medPrice` double(10,2) not null,
	`status` varchar(255) not null,
	`dateInsert` date not null,
	`doe` timestamp
)engine = InnoDB;

create table `labPayment`(
	`id` int(255) not null primary key auto_increment,
	`patientID` varchar(255) not null,
	`paymode` varchar(255) not null,
	`labName` varchar(255) not null,
	`labPrice` decimal(10,2) not null,
	`status` varchar(255) not null,
	`dateInsert` date not null,
	`doe` timestamp
)engine = InnoDB;
