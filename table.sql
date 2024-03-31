CREATE TABLE students(
  id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
  student_id INT(11) NOT NULL UNIQUE, 
  lastname VARCHAR(100) NOT NULL, 
  sex VARCHAR(10) NOT NULL, 
  email VARCHAR(100) NOT NULL, 
  
  FOREIGN KEY (student_id) REFERENCES users(id) 
  ON UPDATE CASCADE ON DELETE CASCADE
);
/* insert into students */
INSERT INTO students (student_id, lastname, sex, email)
VALUES(2, 'Sultani', 'Male', 'backup-omer@gmail.com');
CREATE TABLE teachers(
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  teacher_id INT(11) NOT NULL UNIQUE, 
  qualification VARCHAR(100) DEFAULT NULL,
  experience INT(11) DEFAULT NULL,
  subjects_taught VARCHAR(100) DEFAULT NULL,
  specialization VARCHAR(100) DEFAULT NULL, 
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(teacher_id) REFERENCES users(id) 
  ON UPDATE CASCADE ON DELETE CASCADE
);
/* insert into teacher */
INSERT INTO teachers (teacher_id, qualification,experience, subjects_taught, specialization)
VALUES(4, 'Graduated from Bachalor, English litrature.',10, 'English, Math, Computer',
'In English area.')
CREATE TABLE classes (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  teacher_id INT(11) DEFAULT NULL, 
  student_id INT(11) NOT NULL, 
  subject_name VARCHAR(100) NOT NULL, 
  start_class TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP, 
  end_class TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  grades TINYINT(2) NOT NULL DEFAULT 0,
  FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON UPDATE CASCADE ON DELETE CASCADE
);
/* insert into teacher */
INSERT INTO classes (teacher_id, student_id,subject_name, grades)
VALUES(
  4, 2, 'Eglish', 1
);

CREATE TABLE userinformation(
  id INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY, 
  user_id INT(11) NOT NULL, 
  country VARCHAR(50) DEFAULT NULL, 
  address VARCHAR(250) DEFAULT NULL,  
  zip_code VARCHAR(20) DEFAULT NULL, 
  phone_number BIGINT(13) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) 
  ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE table subjects(
  id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name VARCHAR(100) NOT NULL, 
  entrol TINYINT(1) DEFAULT 1
);
CREATE TABLE scores (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  student_id INT(11) NOT NULL, 
  teacher_id INT(11) NOT NULL, 
  class_id INT(11) NOT NULL, 
  subject_name VARCHAR(11) NOT NULL, 
  score INT(4) DEFAULT 0,
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES students(student_id) 
  ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id) 
  ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (class_id) REFERENCES teachers(id) 
  ON UPDATE CASCADE ON DELETE CASCADE
);
INSERT INTO scores(student_id, teacher_id, class_id, subject_name, score) values (2, 4, 3,'English', 90);
SELECT * FROM scores
INNER JOIN classes ON scores.id = classes.id
INNER JOIN teachers ON scores.teacher_id = teachers.teacher_id
INNER JOIN students ON scores.student_id = students.student_id
INNER JOIN users ON teachers.teacher_id = users.id
WHERE students.student_id = $user_id
ORDER BY YEAR(classes.start_class), classes.grades ASC;

/* create table grades */

CREATE TABLE grades (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
  name CHAR(3) DEFAULT '0A', 
  grade TINYINT(2) DEFAULT '0',
  created_at TIMESTAMP default CURRENT_TIMESTAMP
);

insert into grades (name,grade) values('1A',1);

CREATE TABLE subjects_repositories(
 id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
 name VARCHAR(100) NOT NULL , 
 
 created_at TIMESTAMP default CURRENT_TIMESTAMP
);

insert into subjects_repositories (name) values('Math');