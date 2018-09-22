

create table `bloodGroup_tb`(
    `bloodID` varchar(255) not null primary key,
    `bloodGroup` varchar(255) not null,
    `charge` varchar(200) not null,
    `bloodBags` varchar(255) not null,
    `doe` timestamp
)engine = InnoDB;



-- new tables
create table `bloodBank`(
    `bloodID` varchar(255) not null,
     `donorID` varchar(255) not null primary key,
     `centerID` varchar(255) not null,
    -- `charge` varchar(200) not null, //does not belong
    `amtAvail` varchar(255) not null,
    `donorName` varchar(255) not null,
    `gender` varchar(10) not null,
    `bloodGroup` varchar(100) not null,
    `homeAddress` varchar(255) not null,
    `phoneNumber` varchar(20) not null,
     `dob` varchar(50) not null,
     `lastDonate` varchar(50) not null,
    `doe` timestamp,
    index(donorID),
    foreign key(bloodID) references `bloodGroup_tb`(bloodID)
)engine = InnoDB;



