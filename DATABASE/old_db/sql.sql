create table `wardTreatment`(
    `id` int(255) not null primary key auto_increment,
    `patientID` varchar(255) not null,
    `staffID` varchar(255) not null,
    `treatment` varchar(255) not null,
    `details` varchar(255) not null,
    `treatDateTime` varchar(255) not null,
    `doe` timestamp
)engine = InnoDB;
