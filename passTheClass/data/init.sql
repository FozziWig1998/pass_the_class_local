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
  course_name varchar(20) NOT NULL,
  category_name decimal(5,5) DEFAULT NULL,
  PRIMARY KEY(course_name)
  CONSTRAINT course_name FOREIGN KEY(course_name) REFERENCES Course(name),
  CONSTRAINT category_name FOREIGN KEY(category_name) REFERENCES Category(name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Student_Class (
  netId varchar(10) NOT NULL,
  name int(11) NOT NULL,
  PRIMARY KEY(netId),
  KEY name (name)
  CONSTRAINT name FOREIGN KEY (name) REFERENCES Course (name),
  CONSTRAINT Student_Class FOREIGN KEY(netId) REFERENCES Student (netId)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Category_Assignment (
 category_name char(20) NOT NULL,
 assignment_name varchar(50) NOT NULL,
 PRIMARY KEY (category_name, assignment_name),
 KEY assignment_name (assignment_name),
 CONSTRAINT assignment_name FOREIGN KEY (assignment_name) REFERENCES Assignment (name),
 CONSTRAINT category_name FOREIGN KEY (category_name) REFERENCES Category (name)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);
