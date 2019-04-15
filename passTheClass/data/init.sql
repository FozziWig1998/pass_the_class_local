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

CREATE TABLE Course_Category (
  Course.name varchar(20) NOT NULL,
  Category.percentage decimal(5,5) DEFAULT NULL,
  PRIMARY KEY(Course.name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Student_Class (
  Student.netId varchar(10) NOT NULL,
  Course.name int(11) NOT NULL,
  PRIMARY KEY(Student.netId),
  KEY Course.name (Course.name)
  CONSTRAINT Course.name FOREIGN KEY (Course.name) REFERENCES Course (name),
  CONSTRAINT Student_Class FOREIGN KEY(Student.netId) REFERENCES Student (netId)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Category_Assignment (
 Category.name char(20) NOT NULL,
 Assignment.name varchar(50) NOT NULL,
 PRIMARY KEY (Category.name, Assignment.name),
 KEY Assignment.name (Assignment.name),
 CONSTRAINT Assignment.name FOREIGN KEY (Assignment.name) REFERENCES Assignment (name),
 CONSTRAINT Category.name FOREIGN KEY (Category.name) REFERENCES Category (name)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);
