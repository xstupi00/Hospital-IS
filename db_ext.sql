-- --------------------------------------------
-- Project: IS for hospital, IIS 2018, VUT FIT
-- Authors: xstupi00 AT stud.fit.vutbr.cz
--          xzubri00 AT stud.fit.vutbr.cz
-- --------------------------------------------

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS=0;
SET time_zone = 'SYSTEM';
USE xzubri00;

-- ---------------------------------------------
-- -------- dropping (deleting) tables ---------
-- ---------------------------------------------
DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS Doctor; 
DROP TABLE IF EXISTS Nurse; 
DROP TABLE IF EXISTS Patient; 
DROP TABLE IF EXISTS Department; 
DROP TABLE IF EXISTS Examination; 
DROP TABLE IF EXISTS Hospitalization; 
DROP TABLE IF EXISTS Medication;
DROP TABLE IF EXISTS Administration_Of_Medication; 
DROP TABLE IF EXISTS User;

-- -------------------------------------
-- -------- creating of tables ---------
-- -------------------------------------
CREATE TABLE User(
  User_ID INTEGER NOT NULL AUTO_INCREMENT,
  Person_ID INTEGER NOT NULL,
  Username VARCHAR(50) NOT NULL,
  Password VARCHAR(50) NOT NULL,
  Email VARCHAR(50) NOT NULL,
  PRIMARY KEY(User_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


CREATE TABLE Person (
    Person_ID INTEGER NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Surname VARCHAR(50) NOT NULL,
    `Date of birth` DATE,
    Sex CHAR(1),
    `ID number` VARCHAR(10),
    City VARCHAR(50),
    Street VARCHAR(50),
    Country VARCHAR(50),
    Zip VARCHAR(5),
    PRIMARY KEY(Person_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Doctor (
    Doctor_ID INTEGER NOT NULL,
    Specialization VARCHAR(50) NOT NULL,
    Degree VARCHAR(50),
    `Actual state` VARCHAR(10) DEFAULT 'active',
    `Turn out date` DATE DEFAULT NULL,
    PRIMARY KEY(Doctor_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Nurse (
    Nurse_ID INTEGER NOT NULL,
    Degree VARCHAR(50),
    Department_ID INTEGER NOT NULL,
    Competence VARCHAR(50) DEFAULT 'full',
    `Actual state` VARCHAR(10) DEFAULT 'active',
    `Turn out date` DATE DEFAULT NULL,
    PRIMARY KEY(Nurse_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Patient (
    Patient_ID INTEGER NOT NULL,
    Weight DOUBLE NOT NULL,
    Height DOUBLE NOT NULL,
    `Health condition` VARCHAR(50) NOT NULL,
    `Date of registration` DATE NOT NULL,
    `Date of death` DATE DEFAULT NULL,
    PRIMARY KEY(Patient_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Department (
    Department_ID INTEGER NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    `Number of beds` INTEGER NOT NULL,
    `Number of rooms` INTEGER NOT NULL,
    `Visit time from` VARCHAR(5) NOT NULL,
    `Visit time to` VARCHAR(5) NOT NULL,
    Floor INTEGER NOT NULL,
    PRIMARY KEY(Department_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Examination (
    Examination_ID INTEGER NOT NULL AUTO_INCREMENT,
    Doctor_ID INTEGER NOT NULL,
    Department_ID INTEGER NOT NULL,
    Hospitalization_ID INTEGER NOT NULL,
    Type VARCHAR(50) NOT NULL,
    `Date` DATE NOT NULL,        
    `Medical record` VARCHAR(1000) NOT NULL,
    PRIMARY KEY(Examination_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Hospitalization (
    Hospitalization_ID INTEGER NOT NULL AUTO_INCREMENT,
    Doctor_ID INTEGER NOT NULL,
    Department_ID INTEGER NOT NULL,
    Patient_ID INTEGER NOT NULL,
    `Date` DATE NOT NULL,
    `Hospitalization record` VARCHAR(1000) NOT NULL,
    PRIMARY KEY(Hospitalization_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Medication ( 
    Medication_ID INTEGER NOT NULL AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    `Maximal dose` INTEGER NOT NULL,
    Form VARCHAR(50) NOT NULL,
    `Active substance` VARCHAR(50) NOT NULL,
    `Side effect` VARCHAR(50),
    PRIMARY KEY(Medication_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE Administration_Of_Medication (
    Adm_of_med_ID INTEGER NOT NULL AUTO_INCREMENT,
    Doctor_ID INTEGER NOT NULL,
    Medication_ID INTEGER NOT NULL,
    Hospitalization_ID INTEGER NOT NULL,
    `Procedure` VARCHAR(50),
    `Date` DATE NOT NULL,
    Frequency INTEGER NOT NULL,
    `Way of use` VARCHAR(50) NOT NULL,
    PRIMARY KEY(Adm_of_med_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- set FOREIGN KEYS
ALTER TABLE Doctor ADD CONSTRAINT FK_PERSON_ID_D FOREIGN KEY (Doctor_ID) REFERENCES Person(Person_ID);
ALTER TABLE Nurse ADD CONSTRAINT FK_PERSON_ID_N FOREIGN KEY (Nurse_ID) REFERENCES Person(Person_ID);
ALTER TABLE Patient ADD CONSTRAINT FK_PERSON_ID_P FOREIGN KEY (Patient_ID) REFERENCES Person(Person_ID);
ALTER TABLE User ADD CONSTRAINT FK_PERSON_ID_U FOREIGN KEY (Person_ID) REFERENCES Person(Person_ID);

ALTER TABLE Administration_Of_Medication ADD CONSTRAINT FK_DOCTOR_ID_A FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID);
ALTER TABLE Administration_Of_Medication ADD CONSTRAINT FK_MEDICATION_ID_A FOREIGN KEY (Medication_ID) REFERENCES Medication(Medication_ID);
ALTER TABLE Administration_Of_Medication ADD CONSTRAINT FK_HOSPITALIZATION_ID_A FOREIGN KEY (Hospitalization_ID) REFERENCES Hospitalization(Hospitalization_ID);

ALTER TABLE Hospitalization ADD CONSTRAINT FK_DOCTOR_ID_H FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID);
ALTER TABLE Hospitalization ADD CONSTRAINT FK_DEPARTMENT_ID_H FOREIGN KEY (Department_ID) REFERENCES Department(Department_ID);
ALTER TABLE Hospitalization ADD CONSTRAINT FK_PATIENT_ID_H FOREIGN KEY (Patient_ID) REFERENCES Patient(Patient_ID);

ALTER TABLE Examination ADD CONSTRAINT FK_DOCTOR_ID_E FOREIGN KEY (Doctor_ID) REFERENCES Doctor(Doctor_ID);
ALTER TABLE Examination ADD CONSTRAINT FK_DEPARTMENT_ID_E FOREIGN KEY (Department_ID) REFERENCES Department(Department_ID);
ALTER TABLE Examination ADD CONSTRAINT FK_HOSPITALIZATION_ID_E FOREIGN KEY (Hospitalization_ID) REFERENCES Hospitalization(Hospitalization_ID);

ALTER TABLE Nurse ADD CONSTRAINT FK_DEPARTMENT_ID_N FOREIGN KEY (Department_ID) REFERENCES Department(Department_ID);

-- set CONSTRAINTS 
ALTER TABLE Department ADD CONSTRAINT CNT_COUNT_OF_BEDS CHECK (`Number of beds` > 0);
ALTER TABLE Department ADD CONSTRAINT CNT_COUNT_OF_ROOMS CHECK (`Number of rooms` > 0);
ALTER TABLE Administration_Of_Medication ADD CONSTRAINT CNT_FREQUENCY CHECK (Frequency > 0);
ALTER TABLE Patient ADD CONSTRAINT CHECK_WEIGHT CHECK (Weight > 0); 
ALTER TABLE Patient ADD CONSTRAINT CHECK_HEIGHT CHECK (Height > 0); 

-- insert VALUES to TABLES
INSERT INTO Person (Person_ID, Name, Surname) VALUES
  (0, 'admin', 'admin');

INSERT INTO Person (Name, Surname, `Date of birth`, Sex, `ID number`, City, Street, Country, Zip) VALUES
  ('Dwayne',    'Duff',     STR_TO_DATE('1953-06-17', '%Y-%m-%d'), 'M', '9901047574', 'Melbourne', 'Chesterfield 32',      'Australia',     '32904'), -- 1
  ('Carmelita', 'Clukey',   STR_TO_DATE('1964-01-18', '%Y-%m-%d'), 'F', '9712080650', 'Honolulu', 'Goldfield Rd. 12',      'United States', '96815'), -- 2
  ('Terica',    'Tague',    STR_TO_DATE('1969-01-24', '%Y-%m-%d'), 'F', '9210056559', 'Chicago', 'Shirley Ave 15',         'Canada',		'60185'), -- 3
  ('Erica',     'Ernert',   STR_TO_DATE('1963-04-28', '%Y-%m-%d'), 'F', '9609279130', 'Chevy Case', 'Pilgrim Avenue 19',   'United States', '20815'), -- 4
  ('Magda',     'Montoro',  STR_TO_DATE('1976-02-16', '%Y-%m-%d'), 'F', '9111118115', 'South Windsor', 'Bownma St. 10',    'Australia',     '06074'), -- 5
  ('Charlyn',   'Cissell',  STR_TO_DATE('1985-12-04', '%Y-%m-%d'), 'F', '9558238525', 'Orlando', 'S. Mangnolia St. 11',    'United States', '32806'), -- 6
  ('Rufina',    'Ruocco',   STR_TO_DATE('1950-05-14', '%Y-%m-%d'), 'F', '9606086622', 'Waxhaw', 'Stillwater Drive Apt 54', 'United States', '28173'), -- 7
  ('John', 	    'Friedrich',STR_TO_DATE('1987-09-15', '%Y-%m-%d'), 'M', '9255117091', 'Prague', 'Hlavni 1', 			   'Czech Republic','08601'), -- 8
  ('Maria', 	'Curry',    STR_TO_DATE('1917-02-12', '%Y-%m-%d'), 'F', '9912198989', 'Warsaw', 'Jana Pavla II 2', 		   'Poland',        '02485'), -- 9
  ('Milda', 	'Metzinger',STR_TO_DATE('1971-09-28', '%Y-%m-%d'), 'F', '9901253131', 'Halethorpe', 'Glenwood Drive 167',  'Canada',        '54880'), -- 10
  ('Conrad',    'Cypert',   STR_TO_DATE('1947-09-24', '%Y-%m-%d'), 'M', '9312130355', 'Strijpem', 'Rue Campanules 187',    'Belgium',       '96201'), -- 11
  ('Alyson',    'Amore',    STR_TO_DATE('1970-03-12', '%Y-%m-%d'), 'F', '9660239754', 'Winona', 'Hartford Ave 9542',       'USA', 			'55987'), -- 12
  ('Del',       'Dlneen',   STR_TO_DATE('1955-02-06', '%Y-%m-%d'), 'M', '9853215042', 'Minnesota', 'Orchard Street 3957',  'USA',           '55437'), -- 13
  ('Garrett',   'Grieves',  STR_TO_DATE('1958-02-27', '%Y-%m-%d'), 'M', '9853113941', 'Haine-Saint-Pet', 'Rue Fouramont 3','Belgium', 		'70019'), -- 14
  ('Ernle',     'Engetson', STR_TO_DATE('1966-04-19', '%Y-%m-%d'), 'M', '9805072134', 'Ciney', 'Lodewijk De Raetlaan 310', 'Belgium', 		'55901'), -- 15
  ('Conrad',    'Cypert',   STR_TO_DATE('1974-09-24', '%Y-%m-%d'), 'M', '9312130355', 'Strijpem', 'Rue des Campanules 187','Belgium', 		'96202'), -- 16
  ('Herschel',  'Hennisen', STR_TO_DATE('1984-11-16', '%Y-%m-%d'), 'M', '9911211706', 'South Windsor', 'Bowman St. 170',   'USA', 			'06074'),-- 17
  ('Junior',    'Janz',     STR_TO_DATE('1974-03-13', '%Y-%m-%d'), 'M', '9712074383', 'Warner Robins', 'Rock Creek 7163',  'USA', 			'02127'), -- 18
  ('Gayle',     'Gorski',   STR_TO_DATE('1943-03-09', '%Y-%m-%d'), 'M', '9153076636', 'Hackensack', 'Addison Drive 3',     'USA', 			'21227'), -- 19
  ('Milagros',  'Musto',    STR_TO_DATE('1960-07-18', '%Y-%m-%d'), 'M', '9258245975', 'Hialeah', 'Branch Street 54',      'USA', 			'33010'), -- 20
  ('Simon',  'Neznamy',    STR_TO_DATE('1960-07-18', '%Y-%m-%d'), 'M', '9610192684', 'Hertnik', 'Lucky 43',       'Slovakia',       '08642'); -- 21

INSERT INTO Doctor (Doctor_ID, Specialization, Degree) VALUES
  (1, 'Anesthesiologist',     'MUDr., prim.'),
  (2, 'Dermatologist',        'MUDr.'),
  (3, 'Neurologist',          'MUDr.'),
  (4, 'Neurosurgerist',       'MRCSs, MUDr.'),
  (5, 'Pediatrist', 		  'PaedDr.'),
  (6, 'Psychiatrist',         'MClinPscychol'),
  (7, 'Surgerist', 			  'MUDr., DrSc.');

INSERT INTO Department (Department_ID, Name, `Number of beds`, `Number of rooms`, `Visit time from`, `Visit time to`, Floor) VALUES
  (1, 'Neurology',   15, 7,  '14:00', '15:30', 1),
  (2, 'Urology',     20, 10, '14:30', '16:30', 2),
  (3, 'Radiology',   10, 5,  '14:30', '17:00', 3),
  (4, 'Cardiology',  15, 8,  '14:00', '15:00', 4),
  (5, 'Orthopaedics', 6, 3,  '15:00', '15:00', 5),
  (6, 'Surgery',     50, 25, '14:45', '16:00', 1),
  (7, 'Gynecology',  10, 5,  '14:30', '16:00', 2),
  (8, 'Pediatrics',  30, 15, '15:15', '16:45', 3),
  (9, 'Psychiatry',  30, 30, '15:00', '15:30', 4);

INSERT INTO Nurse (Nurse_ID, Degree, Department_ID, Competence) VALUES
  (8,  'Mgr.',   1, 'full'),
  (9,  'Bc.',    2, 'limited'),
  (10, 'Mgr.',   3, 'full'),
  (11, 'Bc.',    4, 'limited'),
  (12, 'Mgr.',   5, 'full'),
  (13, 'PharmPC.', 6, 'full'),
  (14, 'Mgr.',   7, 'full');

INSERT INTO User (Person_ID, Username, Password, Email) VALUES
  (0, 'admin',   'admin', 'admin@stud.fit.vutbr.cz'),
  (1, 'doc',     'doc',   'dwayneduff@gmail.com'), -- Dwayne Duff - Doctor
  (2, 'doc2',    'doc2',  'carmelita@gmail.com'), -- Carmelita  - Doctor
  (3, 'doc3',    'doc3',  'terica@gmail.com@gmail.com'), -- Terica - Doctor
  (4, 'doc4',    'doc4',  'ericaernert@gmail.com'), -- Erica Ernert - Nurse
  (5, 'doc5',    'doc5',  'magdamontoro@gmail.com'), -- magdamontoro - Nurse
  (6, 'doc6',    'doc6',  'charlyncissell@gmail.com'),
  (7, 'doc7',    'doc7',  'rufinaruocco@gmail.com'), -- Dwayne Duff - Doctor
  (8, 'nurse',    'nurse',  'fohnfriedrich@gmail.com'), -- Carmelita  - Doctor
  (9, 'nurse1',   'nurse1',  'mariacurry@gmail.com'), -- Terica - Doctor
  (10, 'nurse2',  'nurse2', 'mildametzinger@gmail.com'), -- Erica Ernert - Nurse
  (11, 'nurse3', 'nurse3','conradcypert@gmail.com'), -- magdamontoro - Nurse
  (12, 'nurse4', 'nurse4','alysonamore@gmail.com'),
  (13, 'nurse5', 'nurse5','deldlneen@gmail.com'), -- Dwayne Duff - Doctor
  (14, 'nurse6', 'nurse6','garrettgrieves@gmail.com'); -- Carmelita  - Doctor



INSERT INTO Patient (Patient_ID, Weight, Height, `Health condition`, `Date of registration`, `Date of death`) VALUES
  (15, FORMAT(82,2), FORMAT(178,2), 'Psychically labile',   STR_TO_DATE('2018-11-15', '%Y-%m-%d'), NULL),
  (16, FORMAT(75,2), FORMAT(188,2), 'Asthmatic',            STR_TO_DATE('2018-12-03', '%Y-%m-%d'), NULL),
  (17, FORMAT(82,2), FORMAT(175,2), 'Allergic',             STR_TO_DATE('2016-11-23', '%Y-%m-%d'), STR_TO_DATE('2018-11-23', '%Y-%m-%d')),
  (18, FORMAT(98,2), FORMAT(201,2), 'Susceptible to flu',   STR_TO_DATE('2018-03-30', '%Y-%m-%d'), NULL),
  (19, FORMAT(84,2), FORMAT(190,2), 'Asthmatic',            STR_TO_DATE('2017-10-19', '%Y-%m-%d'), NULL),
  (20, FORMAT(87,2), FORMAT(192,2),  'Psychically labile',   STR_TO_DATE('2018-02-28', '%Y-%m-%d'), NULL),
  (21, FORMAT(89,2), FORMAT(201,2),  'Susceptible to flu',   STR_TO_DATE('2018-03-30', '%Y-%m-%d'), STR_TO_DATE('2018-12-01', '%Y-%m-%d'));



INSERT INTO Hospitalization (Doctor_ID, Department_ID, Patient_ID, `Date`, `Hospitalization record`) VALUES
  (1, 1, 15, STR_TO_DATE('2017-02-27', '%Y-%m-%d'), 'The patient is a 35-year-old female. She reports headaches.'),
  (2, 2, 16, STR_TO_DATE('2016-11-23', '%Y-%m-%d'), 'She has no esophageal problems, but she does need lab work done in August'),
  (3, 3, 17, STR_TO_DATE('2016-18-01', '%Y-%m-%d'), 'The patient was administered 3 n at peak stress.'),
  (4, 4, 18, STR_TO_DATE('2018-01-11', '%Y-%m-%d'), 'The patient is after surgery.'),
  (5, 5, 19, STR_TO_DATE('2017-11-30', '%Y-%m-%d'), 'Lumbosacral spine, multiple views of the lumbar spine were obtained.'),
  (9, 6, 20, STR_TO_DATE('2017-09-25', '%Y-%m-%d'), 'The patient presents to the offi w a reactione .'),
  (7, 7, 21, STR_TO_DATE('2017-11-30', '%Y-%m-%d'), 'The patient comes in for follow  a and he wasee.'),
  (1, 8, 15, STR_TO_DATE('2016-05-23', '%Y-%m-%d'), 'There is a little bit of superior sclerosis at the acetabula bilaterally.'),
  (2, 9, 16, STR_TO_DATE('2018-11-30', '%Y-%m-%d'), 'Hips, two views of the right and left hip were obtained.'),
  (3, 1, 17, STR_TO_DATE('2018-07-30', '%Y-%m-%d'), 'The floor was completely intact and the creamasteric fibers and internal spermatic fascia opened'),
  (4, 3, 18, STR_TO_DATE('2016-04-30', '%Y-%m-%d'), 'CT was performed of the upper abdomen following the administration of IV contrast utilizing standard protocol.'),
  (5, 5, 19, STR_TO_DATE('2018-01-30', '%Y-%m-%d'), 'This is a well-appearing thin middle-aged female'),
  (6, 7, 20, STR_TO_DATE('2018-12-01', '%Y-%m-%d'), 'I did a left parallel angle incision.'),
  (7, 4, 21, STR_TO_DATE('2016-12-31', '%Y-%m-%d'), 'She has had multiple sex partners in her life');

INSERT INTO Examination (Doctor_ID, Department_ID, Hospitalization_ID, Type, `Date`, `Medical record`) VALUES
  (1, 1, 1, 'CT',            STR_TO_DATE('2016-11-24',  '%Y-%m-%d'), 'CT was performed of the upper aom.'),
  (2, 2, 2, 'Sonography',    STR_TO_DATE('2016-11-30',  '%Y-%m-%d'), 'The obvious structures knesndotact.'),
  (3, 3, 3, 'MRI',           STR_TO_DATE('2014-08-04',  '%Y-%m-%d'), 'There are five vertebrae with rended.'),
  (4, 4, 4, 'Done Density',  STR_TO_DATE('2014-08-14',  '%Y-%m-%d'), 'There is slight right contrinuam.'),
  (5, 5, 5, 'CT',            STR_TO_DATE('2016-11-24',  '%Y-%m-%d'), 'CT was performed of the upper aom.'),
  (6, 6, 6, 'Sonography',    STR_TO_DATE('2016-11-30',  '%Y-%m-%d'), 'The obvious structures knesndotact.'),
  (7, 7, 7, 'MRI',           STR_TO_DATE('2014-08-04',  '%Y-%m-%d'), 'There are five vertebrae with rended.'),
  (1, 8, 8, 'Done Density',  STR_TO_DATE('2014-08-14',  '%Y-%m-%d'), 'There is tight left contrinuam too long.'),
  (2, 9, 9, 'CT',            STR_TO_DATE('2016-11-24',  '%Y-%m-%d'), 'CT was performed of the upper aom.'),
  (5, 4, 10, 'Sonography',    STR_TO_DATE('2016-11-30',  '%Y-%m-%d'), 'The obvious structures knesndotact.'),
  (6, 4, 11, 'MRI',           STR_TO_DATE('2014-08-04',  '%Y-%m-%d'), 'There are four vertebrae with rended.'),
  (7, 1, 12, 'Done Density',  STR_TO_DATE('2014-08-14',  '%Y-%m-%d'), 'There is slight left contrinuam.'),
  (1, 2, 13, 'MRI',           STR_TO_DATE('2014-08-04',  '%Y-%m-%d'), 'There are two vertebrae with rended.'),
  (7, 3, 14, 'Done Density',  STR_TO_DATE('2014-08-14',  '%Y-%m-%d'), 'There is slight center contrinuam.');

INSERT INTO Medication (Name, `Maximal dose`, Form, `Active substance`, `Side effect`) VALUES
  ('Codeine',           360,    'syrup',    '3-Methylmorphine',     'dizziness'),
  ('Acetaminophen',     4000,   'liquid',   'Acetaminophen',        'yellow skin'),
  ('Lexapro',           10,     'pill',     'Escitalopram',         'ejaculatory disorder'),
  ('Viagra',            100,    'pill',     'Sildenafil citrate',   'dyspepsia'),
  ('Ibuprofen', 		3200,   'tablet',   'Genpril', 				'pregnancy'),
  ('Xanax', 			2,      'tablet',   'Niravam', 				'pregnancy'),
  ('Amoxicillin', 		500,    'capsule',  'Moxatag', 				'drug abuse'),
  ('Lyrica', 			100,    'capsule',  'Pregabalin', 			'depresion'),
  ('Lisinopril', 		80,     'tablet', '  Prinivil', 			'pregnancy');

INSERT INTO Administration_Of_Medication (Doctor_ID, Medication_ID, Hospitalization_ID, `Procedure`, `Date`, Frequency, `Way of use`) VALUES
  (1, 1, 1, 'buccal',       STR_TO_DATE('2017-09-29', '%Y-%m-%d'), 3, 'injection'),
  (2, 2, 2, 'rectal',       STR_TO_DATE('2017-12-28', '%Y-%m-%d'), 1, 'infusion'),
  (3, 3, 3, 'oral',         STR_TO_DATE('2017-07-14', '%Y-%m-%d'), 1, 'solid state'),
  (4, 4, 4, 'sublingual',   STR_TO_DATE('2018-01-08', '%Y-%m-%d'), 4, 'infusion'),
  (5, 5, 5, 'buccal',       STR_TO_DATE('2017-11-01', '%Y-%m-%d'), 3, 'injection'),
  (6, 6, 6, 'rectal',       STR_TO_DATE('2017-04-23', '%Y-%m-%d'), 8, 'infusion'),
  (7, 7, 7, 'oral',         STR_TO_DATE('2017-08-29', '%Y-%m-%d'), 1, 'injectione'),
  (1, 7, 8, 'sublingual',   STR_TO_DATE('2018-01-25', '%Y-%m-%d'), 3, 'solid state'),
  (2, 8, 9, 'buccal',       STR_TO_DATE('2017-12-09', '%Y-%m-%d'), 3, 'injection'),
  (4, 9, 10, 'rectal',      STR_TO_DATE('2017-01-18', '%Y-%m-%d'), 7, 'infusion'),
  (4, 1, 11, 'oral',        STR_TO_DATE('2017-05-04', '%Y-%m-%d'), 5, 'solid state'),
  (5, 2, 12, 'sublingual',  STR_TO_DATE('2018-01-25', '%Y-%m-%d'), 2, 'injection'),
  (1, 8, 13, 'oral',        STR_TO_DATE('2017-07-24', '%Y-%m-%d'), 5, 'infusion'),
  (7, 9, 14, 'sublingual',  STR_TO_DATE('2018-01-05', '%Y-%m-%d'), 8, 'solid state');
