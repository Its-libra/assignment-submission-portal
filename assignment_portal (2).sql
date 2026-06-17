-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 06:14 AM
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
-- Database: `assignment_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `email`, `password`) VALUES
(1, 'admin_001', 'admin001@gmail.com', 'a1@123'),
(2, 'admin_002', 'admin002@gmail.com', 'a2@123');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `due_date` date NOT NULL,
  `sub_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `title`, `description`, `due_date`, `sub_id`, `file_name`) VALUES
(11, 'DS_1', 'Assignment-1', '2025-07-01', 11, '1749708806_DS301_Data_Structures_Assignment.pdf'),
(12, 'OOP_1', 'Assignment-1', '2025-07-01', 12, '1749708997_OOP302_Object_Oriented_Programming__C____Assignment.pdf'),
(13, 'DBMS_1', 'Assignment-1', '2025-07-01', 13, '1749709049_DBMS303_Database_Management_Systems_Assignment.pdf'),
(14, 'OOP_2', 'Assignment 2', '2025-06-25', 12, '1750996908_OOP302_Object_Oriented_Programming__C____Assignment.pdf'),
(15, 'PY_1', 'PYTHON ASSIGNMENT 1', '2025-06-27', 18, '1751022621_PY404_Python_Programming_Assignment.pdf'),
(16, 'OS_1', 'OS_assignemnt_1', '2025-07-10', 14, '1751037835_OS304_Operating_Systems_Assignment.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(100) NOT NULL,
  `faculty_email` varchar(100) NOT NULL,
  `faculty_pass` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `faculty_username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`faculty_id`, `faculty_name`, `faculty_email`, `faculty_pass`, `admin_id`, `faculty_username`) VALUES
(13, 'Mr Mehta', 'mehta@gmail.com', '1210', 1, 'faculty_01'),
(14, 'Ms Sharma', 'abc@gmail.com', '1234', 2, 'faculty_02'),
(18, 'Ms Tanvi', 'makwanatanvi680@gmail.com', '1210', 2, 'tanvi_1210');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `s_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_email` varchar(100) NOT NULL,
  `enroll_no` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`s_id`, `faculty_id`, `s_name`, `s_email`, `enroll_no`, `pass`) VALUES
(4, 13, 'Aarya Patel', 'aaryapatel@gmail.com', 'CE101', '101'),
(5, 13, 'Rohan Mehta', 'rohan@gmail.com', 'CE102', '102'),
(6, 13, 'Sneha Shah', 'sneha@gmail.com', 'CE103', '103'),
(7, 13, 'Arjun Verma', 'arjun@gmail.com', 'CE104', '104'),
(8, 13, 'Priya Desai', 'priya@gmail.com', 'CE105', '105'),
(9, 14, 'Karan Joshi', 'karan@gmail.com', 'CE106', '106'),
(10, 14, 'Aditya Sharma', 'aditya@gmail.com', 'CE107', '107'),
(11, 14, 'Mitali Thakker', 'mitali@gmail.com', 'CE108', '108'),
(12, 14, 'Krisha Parmar', 'krisha@gmail.com', 'CE109', '109'),
(13, 14, 'Harsh Mehta', 'harsh@gmail.com', 'CE110', '110'),
(14, 13, 'Makwana Tanvi', 'tanvi@gmail.com', 'CE111', '111'),
(15, 13, 'Rahul', 'rahul@gmail.com', 'CE112', '112'),
(17, 13, 'Makwana Tanvi', 'makwanatanvi680@gmail.com', 'CE113', '113');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `sub_id` int(11) NOT NULL,
  `sub_code` varchar(20) NOT NULL,
  `sub_name` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`sub_id`, `sub_code`, `sub_name`, `admin_id`) VALUES
(11, 'DS301', 'Data Structures', 1),
(12, 'OOP302', 'Object-Oriented Programming(C++)', 1),
(13, 'DBMS303', 'Database Managemet Systems', 2),
(14, 'OS304', 'Operating Systems', 2),
(15, 'JAVA401', 'Java Programming ', 1),
(16, 'SE402', 'Software Engineering ', 1),
(17, 'WEB403', 'Web Technology', 2),
(18, 'PY404', 'Python Programming ', 2),
(19, 'CC501', 'Cloud Computing ', 1),
(20, 'AI502', 'Artificial Intelligence', 2);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submission_id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `submitted_at` date NOT NULL,
  `grade` varchar(10) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`submission_id`, `assignment_id`, `s_id`, `file_name`, `file_type`, `submitted_at`, `grade`, `remarks`) VALUES
(10, 11, 4, 'uploads/1749817360_DS_Assignment_1.pdf', 'application/pdf', '2025-06-13', 'A+', 'Excellent'),
(11, 11, 5, 'uploads/1749817393_DS_Assignment_1.pdf', 'application/pdf', '2025-06-13', 'A+', 'Excellent'),
(12, 11, 6, 'uploads/1749817426_DS_Assignment_1.pdf', 'application/pdf', '2025-06-13', 'B', 'Good'),
(13, 11, 7, 'uploads/1749817502_DS_Assignment_1.pdf', 'application/pdf', '2025-06-13', 'B', 'Good'),
(14, 13, 17, 'uploads/1751038563_SB Collect.pdf', 'application/pdf', '2025-06-27', 'A+', 'Excellent'),
(15, 11, 17, 'uploads/1751112654_DS_Assignment_1.pdf', 'application/pdf', '2025-06-28', 'A+', 'Excellent'),
(16, 15, 17, 'uploads/1751112746_PY404_Python_Programming_Assignment.pdf', 'application/pdf', '2025-06-28', 'B', 'Good'),
(17, 14, 17, 'uploads/1751112783_OOP302_Object-Oriented_Programming_(C++)_Assignment.pdf', 'application/pdf', '2025-06-28', 'B', 'Good');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `foreign key` (`admin_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `s_id` (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `submission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`);

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `s_id` FOREIGN KEY (`s_id`) REFERENCES `students` (`s_id`),
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`assignment_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
