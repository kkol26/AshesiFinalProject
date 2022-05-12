drop schema if exists utility_data;
create schema utility_data;
use utility_data;


create table if not exists Utility_staff (
User_ID varchar(10) not null,
First_name varchar(20) not null, 
Last_name varchar(20) not null, 
Gender enum('male','female'),
Contact_no varchar(20), 
Date_of_Birth date, 
Username varchar(15) not null, 
Userpassword varchar(10) not null,
primary key(User_ID)
);


create table if not exists Meter (
Meter_ID varchar(10) not null,
Digitaladdress varchar(50) not null unique, 
City char(20), 
Date_issued date, 
Security_code integer,
Operational boolean,
Theft boolean,
Consumption_data json,
PRIMARY KEY (Meter_ID)
);


INSERT INTO Utility_staff(User_ID,First_name,Last_name,Contact_no,Gender,Date_of_Birth,Username,Userpassword) VALUES 
('01','Hamed','Traore','+2250787338887','male','2001-02-27','thamed27','2001TH'),
('02','Jojo' ,'Mensah','+233545101647','male','2000-02-15','mjojo27','2000MJ'),
('03','Nana' ,'Adae','+233205389341','female','1991-07-04','anana04', '1991AN'),
('04','Kweku','Quansah','+233557394556','male','1999-06-12','QKWEKU','1999QK'),
('05','Divine', 'Appiah','+233559280870','female','1995-09-22','ADIVINE','1995AD'),
('06','Sara','Bedu','+233554787398','female','2002-01-19','BSARA','2002BS');

