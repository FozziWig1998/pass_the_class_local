CREATE DATABASE pass_the_class;

use pass_the_class;

CREATE TABLE Course (
 name varchar(20) NOT NULL,
 professor char(20) DEFAULT NULL,
 semester char(10) DEFAULT NULL,
 creditHours int(11) DEFAULT NULL,
 PRIMARY KEY (name)
);

CREATE TABLE Assignment (
 name varchar(50) NOT NULL,
 course_name int(11) NOT NULL,
 percentage decimal(5,5) DEFAULT NULL,
 PRIMARY KEY (name,course_name),
 KEY course_CRN (course_name),
 CONSTRAINT course_name FOREIGN KEY (course_name) REFERENCES Course (name)
);

CREATE TABLE Category (
 name char(20) NOT NULL,
 course_name varchar(20) NOT NULL,
 weightage decimal(2,2) DEFAULT NULL,
 PRIMARY KEY (name, course_name)
);


CREATE TABLE Student (
 netId varchar(10) NOT NULL,
 YEAR int(11) DEFAULT NULL,
 PRIMARY KEY (netId)
);

CREATE TABLE Course_Category(
    name varchar(20) NOT NULL,
    percentage decimal(2,2) NOT NULL,
    PRIMARY KEY ()
);
