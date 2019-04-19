use pass_the_class;

CREATE TABLE Course (
 id INT(11) UNSIGNED AUTO_INCREMENT,
 name varchar(20) NOT NULL,
 professor char(20) DEFAULT NULL,
 semester char(15) DEFAULT NULL,
 creditHours int(11) DEFAULT NULL,
 PRIMARY KEY (name),
 KEY (id)
);

CREATE TABLE Category (
 id INT(11) UNSIGNED AUTO_INCREMENT,
 name char(20) NOT NULL,
 weightage decimal(6,3) DEFAULT NULL,
 course_name varchar(20) NOT NULL,
 FOREIGN KEY(course_name) REFERENCES Course(name),
 PRIMARY KEY (name, course_name),
 KEY (id)
);


CREATE TABLE Assignment (
 id INT(11) UNSIGNED AUTO_INCREMENT,
 assignment_name varchar(50) NOT NULL,
 percentage decimal(6,3) DEFAULT NULL,
 due_date DATE NOT NULL DEFAULT '2019-05-18',
 category_name char(20) NOT NULL,
 course_name varchar(20) NOT NULL,
 FOREIGN KEY (category_name) REFERENCES Category(name),
 FOREIGN KEY(course_name) REFERENCES Course(name),
 PRIMARY KEY (assignment_name, course_name, category_name),
 KEY (id)
);


CREATE TABLE Student (
 id INT(11) UNSIGNED AUTO_INCREMENT,
 netId varchar(10) NOT NULL,
 YEAR int(11) DEFAULT NULL,
 PRIMARY KEY (netId),
 KEY (id)
);

CREATE TABLE Course_Category (
  course_name varchar(20) NOT NULL,
  category_name char(20) NOT NULL,
  PRIMARY KEY(course_name),
  FOREIGN KEY(course_name) REFERENCES Course(name),
  FOREIGN KEY(category_name) REFERENCES Category(name)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Student_Class (
  netId varchar(10) NOT NULL,
  name varchar(20) NOT NULL,
  PRIMARY KEY(netId, name),
  FOREIGN KEY (name) REFERENCES Course (name),
  FOREIGN KEY(netId) REFERENCES Student (netId)
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE Category_Assignment (
 category_name char(20) NOT NULL,
 assignment_name varchar(50) NOT NULL,
 PRIMARY KEY (category_name, assignment_name),
 FOREIGN KEY (assignment_name) REFERENCES Assignment (assignment_name),
 FOREIGN KEY (category_name) REFERENCES Category (name)
 ON DELETE CASCADE
 ON UPDATE CASCADE
);
