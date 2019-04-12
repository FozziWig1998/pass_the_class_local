CREATE DATABASE pass_the_class;

use pass_the_class;

CREATE TABLE Course (
 CRN int(11) NOT NULL,
 professor char(20) DEFAULT NULL,
 semester char(10) DEFAULT NULL,
 creditHours int(11) DEFAULT NULL,
 PRIMARY KEY (CRN)
);

CREATE TABLE Assignment (
 name varchar(50) NOT NULL,
 course_CRN int(11) NOT NULL,
 percentage decimal(5,5) DEFAULT NULL,
 PRIMARY KEY (name,course_CRN),
 KEY course_CRN (course_CRN),
 CONSTRAINT course_CRN FOREIGN KEY (course_CRN) REFERENCES Course (CRN)
);

CREATE TABLE Category (
 name char(20) NOT NULL,
 weightage decimal(2,2) DEFAULT NULL,
 PRIMARY KEY (name)
);


CREATE TABLE Student (
 netId varchar(10) NOT NULL,
 YEAR int(11) DEFAULT NULL,
 PRIMARY KEY (netId)
);
