-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 05:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esms`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(20) NOT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `grade_level` varchar(20) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `grade_level`, `teacher_id`) VALUES
(1, 'Math', 'K', 4),
(2, 'Math', '1', 5),
(3, 'Math', '2', 6),
(4, 'Math', '3', 7),
(5, 'Math', '4', 10),
(6, 'Math', '5', 27),
(7, 'Language Arts', 'K', 4),
(8, 'Language Arts', '1', 5),
(9, 'Language Arts ', '2', 6),
(10, 'Language Arts', '3', 7),
(11, 'Language Arts', '4', 10),
(12, 'Language Arts', '5', 27),
(13, 'Science', 'K', 4),
(14, 'Science', '1', 5),
(15, 'Science', '2', 6),
(16, 'Science', '3', 7),
(17, 'Science', '4', 10),
(18, 'Science', '5', 27),
(19, 'Social Studies', 'K', 4),
(20, 'Social Studies', '1', 5),
(21, 'Social Studies', '2', 6),
(22, 'Social Studies', '3', 7),
(23, 'Social Studies', '4', 10),
(24, 'Social Studies', '5', 27),
(25, 'Recess', 'K-5', NULL),
(26, 'Lunch', 'K-5', NULL),
(27, 'Physical Education', 'K', 4),
(28, 'Physical Education', '1', 5),
(29, 'Physical Education', '2', 6),
(30, 'Physical Education', '3', 7),
(31, 'Physical Education', '4', 10),
(32, 'Physical Education', '5', 27);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `course_id` int(20) DEFAULT NULL,
  `grade` enum('1','2','3','4') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `id`, `course_id`, `grade`) VALUES
(2, 22, 1, '3'),
(3, 22, 7, '3'),
(4, 22, 13, '4'),
(5, 22, 19, '4'),
(12, 25, 1, '4'),
(13, 25, 7, '4'),
(14, 25, 13, '4'),
(15, 25, 19, '4'),
(28, 22, 27, '1'),
(29, 25, 27, '4');

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `homework_id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `hw_name` varchar(50) DEFAULT NULL,
  `assigned_date` varchar(50) DEFAULT NULL,
  `due_date` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`homework_id`, `course_id`, `hw_name`, `assigned_date`, `due_date`, `status`, `id`) VALUES
(7, 1, 'Subtraction Worksheet 1', '2025-04-28', '2025-05-01', NULL, NULL),
(8, 1, 'Addition Worksheet 1', '2025-04-29', '2025-05-02', NULL, NULL),
(9, 7, 'Chapter 1 Summary', '2025-04-27', '2025-05-01', NULL, NULL),
(10, 13, 'Worksheet 1', '2025-04-21', '2025-05-01', NULL, NULL),
(11, 19, 'Worksheet 1', '2025-04-29', '2025-05-02', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `course_id` int(20) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `user_id`, `course_id`, `start_time`, `end_time`, `day`, `teacher_id`) VALUES
(1, 22, 7, '08:45:00', '09:50:00', 'Monday', 4),
(2, 22, 19, '09:55:00', '10:55:00', 'Monday', 4),
(3, 22, 26, '11:00:00', '11:30:00', 'Monday', 4),
(4, 22, 25, '11:30:00', '12:00:00', 'Monday', 4),
(5, 22, 1, '12:10:00', '13:10:00', 'Monday', 4),
(6, 22, 13, '13:20:00', '14:20:00', 'Monday', 4),
(7, 22, 27, '14:30:00', '15:30:00', 'Monday', 4),
(8, 22, 7, '08:45:00', '09:45:00', 'Tuesday', 4),
(9, 22, 19, '09:55:00', '10:55:00', 'Tuesday', 4),
(10, 22, 26, '11:00:00', '11:30:00', 'Tuesday', 4),
(11, 22, 25, '11:30:00', '12:00:00', 'Tuesday', 4),
(12, 22, 1, '12:10:00', '13:10:00', 'Tuesday', 4),
(13, 22, 13, '13:20:00', '14:20:00', 'Tuesday', 4),
(14, 22, 27, '14:30:00', '15:30:00', 'Tuesday', 4),
(15, 22, 7, '08:45:00', '09:45:00', 'Wednesday', 4),
(16, 22, 19, '09:55:00', '10:55:00', 'Wednesday', 4),
(17, 22, 26, '11:00:00', '11:30:00', 'Wednesday', 4),
(18, 22, 25, '11:30:00', '12:00:00', 'Wednesday', 4),
(19, 22, 1, '12:10:00', '13:10:00', 'Wednesday', 4),
(20, 22, 13, '13:20:00', '14:20:00', 'Wednesday', 4),
(21, 22, 27, '14:30:00', '15:30:00', 'Wednesday', 4),
(22, 22, 7, '08:45:00', '09:45:00', 'Thursday', 4),
(23, 22, 19, '09:55:00', '10:55:00', 'Thursday', 4),
(24, 22, 26, '11:00:00', '11:30:00', 'Thursday', 4),
(25, 22, 25, '11:30:00', '12:00:00', 'Thursday', 4),
(26, 22, 1, '12:10:00', '13:10:00', 'Thursday', 4),
(27, 22, 13, '13:20:00', '14:20:00', 'Thursday', 4),
(28, 22, 27, '14:30:00', '15:30:00', 'Thursday', 4),
(29, 22, 7, '08:45:00', '09:45:00', 'Friday', 4),
(30, 22, 19, '09:55:00', '10:55:00', 'Friday', 4),
(31, 22, 26, '11:00:00', '11:30:00', 'Friday', 4),
(32, 22, 25, '11:30:00', '12:00:00', 'Friday', 4),
(33, 22, 1, '12:10:00', '13:10:00', 'Friday', 4),
(34, 22, 13, '13:20:00', '14:20:00', 'Friday', 4),
(35, 22, 27, '14:30:00', '15:30:00', 'Friday', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `fName` varchar(50) DEFAULT NULL,
  `lName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userType` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fName`, `lName`, `email`, `password`, `userType`, `phone`) VALUES
(1, 'ESMS', 'Admin', 'admin@esms.com', 'password', 'admin', '1234567890'),
(3, 'parent ', 'one', 'parent1@esms.com', 'password', 'parent', '1112223333'),
(4, 'Teacher', 'One', 'teacher1@esms.com', 'password', 'teacher', '1111111111'),
(5, 'Teacher', 'Two', 'teacher2@esms.com', 'password', 'teacher', '1111111112'),
(6, 'Teacher', 'Three', 'teacher3@esms.com', 'password', 'teacher', '1111111113'),
(7, 'Teacher', 'Four', 'teacher4@esms.com', 'password', 'teacher', '1111111114'),
(10, 'Teacher', 'Five', 'teacher5@esms.com', 'password', 'teacher', '1111111115'),
(22, 'student', 'one', 'student1@esms.com', 'password', 'student', 'NULL'),
(23, 'parent', 'two', 'parent2@esms.com', 'password', 'parent', '123089123'),
(24, 'john', 'doe', 'johndoe@esms.com', 'password', 'teacher', '129038123'),
(25, 'student', 'two', 'student2@esms.com', 'password', 'student', 'NULL'),
(26, 'parent', 'three', 'parent3@esms.com', 'password', 'parent', '12093812'),
(27, 'teacher', 'teacher', 'teacherteacher@esms.com', 'password', 'teacher', '109283123'),
(28, 'student', 'three', 'student3@esms.com', 'password', 'student', 'NULL'),
(29, 'parent', 'four', 'parent4@esms.com', 'password', 'parent', '109238123'),
(30, 'teacher', 'john', 'teacherjohn@esms.com', 'password', 'teacher', '10928312321'),
(31, 'student', 'adam', 'studentadam@esms.com', 'password', 'student', 'NULL'),
(32, 'parent', 'jim', 'parentjim@esms.com', 'password', 'parent', '0981232131'),
(33, 'teacher', 'max', 'teachermax@esms.com', 'password', 'teacher', '0981232103'),
(34, 'student', 'richard', 'studentrichard@esms.com', 'password', 'student', 'NULL'),
(35, 'parent', 'nancy', 'parentnancy@esms.com', 'password', 'parent', '0912839012'),
(36, 'Math', 'Teacher', 'mathteacher@esms.com', 'password', 'teacher', '983289312'),
(37, '1st', 'Grader', '1stgrader@esms.com', 'password', 'student', 'NULL'),
(38, '1st grader', 'parent', '1stgraderparent@esms.com', 'password', 'parent', '1231231231'),
(39, 'Science ', 'Teacher', 'scienceteacher@esms.com', 'password', 'teacher', '1111111111'),
(40, '2nd', 'Grader', '2ndgrader@esms.com', 'password', 'student', 'NULL'),
(41, '2nd grader', 'parent', '2ndgraderparent@esms.com', 'password', 'parent', '11123123'),
(42, 'Social Studies', 'Teacher', 'socialstudiesteacher@esms.com', 'password', 'teacher', '1231231232'),
(43, '3rd grade', 'student', '3rdgradestudent@esms.com', 'password', 'student', 'NULL'),
(44, '3rd grader', 'parent', '3rdgraderparent@esms.com', 'password', 'parent', '12312312');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_teacherId` (`teacher_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `fk_course` (`course_id`),
  ADD KEY `fk_user` (`id`);

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`homework_id`),
  ADD KEY `fk` (`course_id`),
  ADD KEY `fk_userid` (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `fk_courses` (`course_id`),
  ADD KEY `fkey_student_ID` (`user_id`),
  ADD KEY `fkey_teacher_ID` (`teacher_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `homework_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_teacherId` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `fk_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_courses` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `fkey_student_ID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fkey_teacher_ID` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
