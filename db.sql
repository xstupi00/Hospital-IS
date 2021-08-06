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
  ('Dwayne',   'Duff',      STR_TO_DATE('1953-06-17', '%Y-%m-%d'), 'M', '9901047574', 'Melbourne', 'Chesterfield 32',     'Australia',    '32904'),
  ('Carmelita', 'Clukey',   STR_TO_DATE('1964-01-18', '%Y-%m-%d'), 'F', '9712080650', 'Honolulu', 'Goldfield Rd. 12',     'United States','96815'),
  ('Terica',    'Tague',    STR_TO_DATE('1969-01-24', '%Y-%m-%d'), 'F', '9210056559', 'Chicago', 'Shirley Ave 15',        'United States','60185'),
  ('Erica',     'Ernert',   STR_TO_DATE('1963-04-28', '%Y-%m-%d'), 'F', '9609279130', 'Chevy Case', 'Pilgrim Avenue 19',  'United States','20815'),
  ('Magda',     'Montoro',  STR_TO_DATE('1976-02-16', '%Y-%m-%d'), 'F', '9111118115', 'South Windsor', 'Bownma St. 10',   'United States','06074'),
  ('Charlyn',   'Cissell',  STR_TO_DATE('1985-12-04', '%Y-%m-%d'), 'F', '9558238525', 'Orlando', 'S. Mangnolia St. 11',   'United States','32806'),
  ('Rufina',    'Ruocco',   STR_TO_DATE('1950-05-14', '%Y-%m-%d'), 'F', '9606086622', 'Waxhaw', 'Stillwater Drive Apt 54','United States','28173'),
  ('Milagros',  'Musto',    STR_TO_DATE('1960-07-18', '%Y-%m-%d'), 'M', '9258245975', 'Hialeah', 'Branch Street 43',      'Algeria',      '33010');

INSERT INTO Doctor (Doctor_ID, Specialization, Degree) VALUES
  (1, 'Anesthesiologist',      'MUDr., prim.'),
  (2, 'Dermatologist',        'MUDr.'),
  (3, 'Neurologist',          'MUDr.');

INSERT INTO Department (Department_ID, Name, `Number of beds`, `Number of rooms`, `Visit time from`, `Visit time to`, Floor) VALUES
  (1, 'Neurology',   15, 7,  '14:00', '15:30', 2),
  (2, 'Urology',     20, 10, '14:30', '16:30', 3),
  (3, 'Radiology',   10, 5,  '14:30', '17:00', 4);

INSERT INTO Nurse (Nurse_ID, Degree, Department_ID, Competence) VALUES
  (4, 'Mgr.',   2, 'full'),
  (5, 'Bc.',    1, 'limited');

INSERT INTO User (Person_ID, Username, Password, Email) VALUES
  (0, 'admin', 'admin', 'admin@stud.fit.vutbr.cz'),
  (1, 'doc', 'doc', 'dwayneduff@gmail.com'), -- Dwayne Duff - Doctor
  (2, 'doc1', 'doc1', 'carmelita@gmail.com'), -- Carmelita  - Doctor
  (3, 'doc2', 'doc2', 'terica@gmail.com'), -- Terica - Doctor
  (4, 'nurse', 'nurse', 'ericaernert@gmail.com'), -- Erica Ernert - Nurse
  (5, 'nurse1', 'nurse1', 'magdamontoro@gmail.com'); -- magdamontoro - Nurse


INSERT INTO Patient (Patient_ID, Weight, Height, `Health condition`, `Date of registration`, `Date of death`) VALUES
  (6, FORMAT(82,2), FORMAT(175,2), 'Allergic',             STR_TO_DATE('2016-11-23', '%Y-%m-%d'), STR_TO_DATE('2018-11-23', '%Y-%m-%d')),
  (7, FORMAT(98,2), FORMAT(201,2), 'Susceptible to flu',   STR_TO_DATE('2018-03-30', '%Y-%m-%d'), NULL),
  (8, FORMAT(84,2), FORMAT(190,2), 'Asthmatic',            STR_TO_DATE('2017-10-19', '%Y-%m-%d'), NULL);


INSERT INTO Hospitalization (Doctor_ID, Department_ID, Patient_ID, `Date`, `Hospitalization record`) VALUES
  (1, 1, 6, STR_TO_DATE('2016-11-23 ', '%Y-%m-%d'), 'The patient is a 35-year-old female. She reports headaches.'),
  (1, 2, 7, STR_TO_DATE('2014-08-02 ', '%Y-%m-%d'), 'The patient was administered 3 n at peak stress.'),
  (2, 1, 6, STR_TO_DATE('2018-01-11 ', '%Y-%m-%d'), 'The patient is after surgery.'),
  (2, 3, 7, STR_TO_DATE('2017-11-30 ', '%Y-%m-%d'), 'The patient comes in for follow  a and he wasee.'),
  (3, 3, 8, STR_TO_DATE('2017-09-25 ', '%Y-%m-%d'), 'The patient presents to the offi w a reactione .');

INSERT INTO Examination (Doctor_ID, Department_ID, Hospitalization_ID, Type, `Date`, `Medical record`) VALUES
  (1, 1, 1, 'CT',            STR_TO_DATE('2016-11-24',  '%Y-%m-%d'), 'CT was performed of the upper aom.'),
  (2, 1, 1, 'Sonography',    STR_TO_DATE('2016-11-30',  '%Y-%m-%d'), 'The obvious structures knesndotact.'),
  (2, 2, 1, 'MRI',           STR_TO_DATE('2014-08-04',  '%Y-%m-%d'), 'There are five vertebrae with rended.'),
  (3, 1, 1, 'Done Density',  STR_TO_DATE('2014-08-14',  '%Y-%m-%d'), 'There is slight right contrinuam.');

INSERT INTO Medication (Name, `Maximal dose`, Form, `Active substance`, `Side effect`) VALUES
  ('Codeine',           360,    'syrup',    '3-Methylmorphine',     'dizziness'),
  ('Acetaminophen',     4000,   'liquid',   'Acetaminophen',        'yellow skin'),
  ('Lexapro',           10,     'pill',     'Escitalopram',         'ejaculatory disorder'),
  ('Viagra',            100,    'pill',     'Sildenafil citrate',   'dyspepsia');

INSERT INTO Administration_Of_Medication (Doctor_ID, Medication_ID, Hospitalization_ID, `Procedure`, `Date`, Frequency, `Way of use`) VALUES
  (1, 1, 1, 'buccal',       STR_TO_DATE('2017-09-29', '%Y-%m-%d'), 3, 'injection'),
  (1, 2, 2, 'rectal',       STR_TO_DATE('2017-12-08', '%Y-%m-%d'), 1, 'infusion'),
  (2, 2, 3, 'oral',         STR_TO_DATE('2017-10-24', '%Y-%m-%d'), 5, 'solid state'),
  (3, 2, 3, 'sublingual',   STR_TO_DATE('2018-01-05', '%Y-%m-%d'), 2, 'solid state');
