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
