-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.1.0-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for school
CREATE DATABASE IF NOT EXISTS `school` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `school`;

-- Dumping structure for table school.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `start_class` timestamp NULL DEFAULT current_timestamp(),
  `end_class` timestamp NULL DEFAULT current_timestamp(),
  `grades` tinyint(2) NOT NULL DEFAULT 0,
  `approve` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.classes: ~2 rows (approximately)
INSERT INTO `classes` (`id`, `teacher_id`, `student_id`, `subject_name`, `start_class`, `end_class`, `grades`, `approve`, `created_at`) VALUES
	(1, 4, 2, 'English', '2024-01-16 04:23:17', '2025-03-11 20:08:17', 3, 0, '2024-04-16 07:00:35'),
	(2, 4, 2, 'English', '2024-03-11 21:03:29', '2025-02-03 22:40:06', 6, 0, '2024-04-16 07:00:35');

-- Dumping structure for table school.grades
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(3) DEFAULT '0A',
  `grade` tinyint(2) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.grades: ~6 rows (approximately)
INSERT INTO `grades` (`id`, `name`, `grade`, `created_at`) VALUES
	(1, '1A', 1, '2024-03-19 15:23:14'),
	(2, '2A', 2, '2024-03-19 15:23:28'),
	(3, '3A', 3, '2024-03-19 15:23:34'),
	(4, '4A', 4, '2024-03-19 15:23:40'),
	(5, '5A', 5, '2024-03-19 15:23:44'),
	(6, '6A', 6, '2024-03-19 15:23:50'),
	(7, '7A', 7, '2024-03-19 15:23:57');

-- Dumping structure for table school.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table school.posts: ~0 rows (approximately)

-- Dumping structure for table school.scores
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `grades_id` int(11) NOT NULL,
  `subject_names` varchar(250) DEFAULT NULL,
  `score` int(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `grades_id` (`grades_id`),
  CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `scores_ibfk_3` FOREIGN KEY (`grades_id`) REFERENCES `grades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.scores: ~4 rows (approximately)
INSERT INTO `scores` (`id`, `student_id`, `teacher_id`, `grades_id`, `subject_names`, `score`, `created_at`) VALUES
	(1, 2, 4, 6, 'Science', 6, '2024-04-16 00:00:35'),
	(2, 2, 4, 5, 'Science', 1, '2024-04-16 00:00:35'),
	(3, 2, 4, 6, 'Geography', 7, '2024-04-16 00:00:35'),
	(4, 2, 4, 2, 'Science', 11, '2024-04-16 00:00:35');

-- Dumping structure for table school.students
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `age` int(11) DEFAULT 0,
  `sex` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.students: ~1 rows (approximately)
INSERT INTO `students` (`id`, `student_id`, `lastname`, `age`, `sex`) VALUES
	(1, 2, 'mordon', 18, 'male');

-- Dumping structure for table school.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `allowed` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.subjects: ~19 rows (approximately)
INSERT INTO `subjects` (`id`, `name`, `allowed`) VALUES
	(1, 'Mathematics', 1),
	(9, 'Computer Science', 1),
	(12, 'Physical Education', 1),
	(13, 'Foreign Language', 1),
	(14, 'Economics', 1),
	(15, 'Psychology', 1),
	(16, 'Sociology', 1),
	(19, 'Business', 1),
	(20, 'Engineering', 1),
	(22, 'math', 1),
	(28, 'P.E (Physical Education)', 1),
	(29, 'drama', 1),
	(33, 'I.T (Information Technology)', 1),
	(34, 'foreign languages', 1),
	(35, 'social studies', 1),
	(36, 'technology', 1),
	(38, 'graphic design', 1),
	(40, 'algebra', 1),
	(41, 'geometry', 1);

-- Dumping structure for table school.subjects_repositories
CREATE TABLE IF NOT EXISTS `subjects_repositories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.subjects_repositories: ~4 rows (approximately)
INSERT INTO `subjects_repositories` (`id`, `name`, `created_at`) VALUES
	(1, 'Math', '2024-03-21 08:16:48'),
	(2, 'English', '2024-03-21 08:16:55'),
	(3, 'Bahasa Indonesia', '2024-03-21 08:17:05'),
	(4, 'Chemistry', '2024-03-21 08:17:22');

-- Dumping structure for table school.teachers
CREATE TABLE IF NOT EXISTS `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `teacher_lastname` varchar(100) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `subjects_taught` varchar(100) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `teacher_id` (`teacher_id`),
  CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.teachers: ~1 rows (approximately)
INSERT INTO `teachers` (`id`, `teacher_id`, `qualification`, `teacher_lastname`, `experience`, `subjects_taught`, `specialization`, `created_at`) VALUES
	(1, 4, 'kjaldj', 'lajkd', 2, 'Business', 'jlajsdlf', '2024-04-16 07:00:29');

-- Dumping structure for table school.userinformation
CREATE TABLE IF NOT EXISTS `userinformation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `phone_number` bigint(13) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `userinformation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.userinformation: ~0 rows (approximately)

-- Dumping structure for table school.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `roles` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table school.users: ~10 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `roles`) VALUES
	(1, 'Bethany Hill IV', 'admin@gmail.com', '$2y$10$Gsv8VwAM6H8nzrf6CkqMwOL52qsEjs3TAiwsATkkXWOs47GoHNDIG', '2024-04-16 06:57:33', 0),
	(2, 'Jordon Lemke', 'teacher@gmail.com', '$2y$10$XURNO0Cb7y/7c1Ajc/pI1OYG4rlnmjfQRfnATTyyKZc6DneZEBwku', '2024-04-16 06:57:33', 2),
	(3, 'Rosalee Pfannerstill', 'student@gmail.com', '$2y$10$oyh7iSbVINqeoJDH./8MROKWVte6yCpsWTO3kg.h3jgPKk23dBPEa', '2024-04-16 06:57:33', 1),
	(4, 'Mr. Evan Goldner I', 'zion.little@luettgen.info', '$2y$10$VSKY/dvhnql7qMLcykEWsO0hsZVnI/46qAPGXKmnC8UkSlJxv8cxO', '2024-04-16 06:57:34', 2),
	(5, 'Anna Buckridge', 'friesen.gregorio@yahoo.com', '$2y$10$qbRCu43B1xPy1jr2oE4l2.f7/dDd7YOZTls6QfbHuPZX6XO77cx9W', '2024-04-16 06:57:34', 2),
	(6, 'Dr. Dante Ward', 'kamron.abernathy@gmail.com', '$2y$10$8g6OingLU2CxKU1VvBHJ4eUPcYdhnKhxYhiyOu5.Pn7GFlo.kpHyC', '2024-04-16 06:57:34', 1),
	(7, 'Lura D\'Amore', 'josianne55@connelly.com', '$2y$10$t62UPJMekwYYB5D5ZDzI7eI72lhJc8Q8zXbBKxbbc.IV1.9gGB4ge', '2024-04-16 06:57:34', 0),
	(8, 'Dereck Jones', 'ckris@hotmail.com', '$2y$10$NVKcsle53nXzEWvdOrcvoeqh36hHgd9K5DQlho/JHMjzV9VI0h6mm', '2024-04-16 06:57:34', 0),
	(9, 'Taurean Denesik', 'adaugherty@hotmail.com', '$2y$10$zUbiQdPItcISuEkR6O34uumbnCjIol4OxoSzmW0oXXVV13TV9OfEq', '2024-04-16 06:57:34', 0),
	(10, 'Mariah Moen IV', 'sipes.mark@dicki.biz', '$2y$10$FSfENkS9mVF9ulJfsRvgCeB1XlXy7bJtCfKWkwSoJ4d6Uhu/j86E6', '2024-04-16 06:57:34', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
