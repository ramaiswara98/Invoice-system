-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 16, 2024 at 08:21 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aedno`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin', 'admin@admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `items_id` varchar(225) NOT NULL,
  `items_date` varchar(225) NOT NULL,
  `user_id` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `items_id`, `items_date`, `user_id`) VALUES
(10, '63', '16-05-24 16:52', '1'),
(11, '69', '16-05-24 16:55', '1'),
(12, '69', '16-05-24 16:55', '1'),
(13, '69', '16-05-24 18:05', '1'),
(14, '65', '16-05-24 18:10', '1'),
(15, '66', '17-05-24 04:01', '1'),
(16, '72', '17-05-24 04:01', '1'),
(17, '72', '17-05-24 04:01', '1');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `currency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `branch_name`, `address`, `email`, `currency_id`) VALUES
(7, 'Branch 1 @ Singapore', 'Singapore', 'branch@aedno.com', 1),
(8, 'Branch 2 @ Indonesia', 'Address', 'branch2@gmail.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `id` int(11) NOT NULL,
  `class_name` varchar(225) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `currency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`id`, `class_name`, `branch_id`, `price`, `currency_id`) VALUES
(26, 'English - Level 1', 7, 100, 1),
(27, 'English - Level 2', 7, 50, 1),
(28, 'Indonesia Level 1', 8, 100000, 2),
(29, 'Indonesia Level 2', 8, 50000, 2),
(34, 'Sains - Level 1', 7, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `code`) VALUES
(1, 'Singapore Dollar', 'SGD'),
(2, 'Indonesian Rupiah', 'IDR');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `student_id` varchar(225) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `student_id`, `status`, `date`) VALUES
(2468, '6', 'Unpaid', '15/05/2024'),
(2470, '8', 'Unpaid', '16/05/2024'),
(2471, '9', 'Unpaid', '16/05/2024'),
(2472, '9', 'Unpaid', '16/05/2024'),
(2473, '7', 'Unpaid', '16/05/2024'),
(2474, '8', 'Unpaid', '16/05/2024'),
(2475, '7', 'Unpaid', '16/05/2024'),
(2476, '6', 'Unpaid', '16/05/2024'),
(2477, '6', 'Unpaid', '16/05/2024'),
(2478, '6', 'Unpaid', '16/05/2024'),
(2479, '8', 'Unpaid', '16/05/2024'),
(2480, '7', 'Paid', '16/05/2024');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `invoice_id`, `class_id`, `qty`, `discount`) VALUES
(65, 2468, 28, 2, 0),
(66, 2468, 29, 1, 0),
(69, 2470, 26, 8, 0),
(70, 2471, 26, 2, 0),
(71, 2472, 26, 0, 0),
(72, 2473, 29, 2, 0),
(73, 2474, 26, 1, 0),
(74, 2475, 28, 1, 0),
(75, 2476, 28, 1, 0),
(76, 2477, 29, 1, 0),
(77, 2478, 29, 1, 0),
(78, 2479, 26, 0, 0),
(79, 2480, 28, 1, 0),
(80, 2480, 29, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `receive`
--

CREATE TABLE `receive` (
  `id` int(11) NOT NULL,
  `receive_no` varchar(225) NOT NULL,
  `receive_date` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `method` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `receive`
--

INSERT INTO `receive` (`id`, `receive_no`, `receive_date`, `amount`, `invoice_id`, `method`) VALUES
(28, 'P782213', '2024-05-16', 200, 2467, 2),
(29, 'P782213', '2024-05-03', 200, 2480, 1);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session` varchar(225) NOT NULL,
  `price` varchar(225) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `school` varchar(225) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `parent_email` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `student_no` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `address`, `school`, `grade`, `parent_name`, `parent_email`, `branch_id`, `student_no`) VALUES
(6, 'Joko Anwar Mahmudding', 'joko@gmail.com', 'West Java', 'SD Rinjani', '5.2', 'Ahmad Dani', 'ahmad@gmail.com', 8, '2005'),
(7, 'Randi Irawan', 'ramaiswara098@gmail.com', 'sidrap', 'SD Wijaya', '4.5', 'Yusuf Aramndo', 'yusuf@gmail.com', 8, '2007'),
(8, 'Jhon Doe', 'jhondoe@gmail.com', 'Singapore', 'Singapore School', '9.2', 'Jhon Doe Sr.', 'JDS@gmail.com', 7, '0998'),
(9, 'Ryan Lee', 'Ryan@lee.com', '', '', '', 'Lee', 'lee@lee.com', 7, 'SGP2024');

-- --------------------------------------------------------

--
-- Table structure for table `tuition_type`
--

CREATE TABLE `tuition_type` (
  `id` int(11) NOT NULL,
  `tuition_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(225) NOT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `last_login` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `branch_id`, `last_login`) VALUES
(1, 'Super Admin', 'superadmin', 'ramaiswara098@gmail.com', '$2y$10$QTJMZa5A0zkxMM3b1CWjwuTjzqZ6VUt2p6rDXML7arL9wdS9kJ8FS', '1', NULL, '2024-05-17 01:42:37'),
(8, 'Admin Branch 1', 'adminbranch3', 'adminbranch1@aedno.com', '$2y$10$61pt1sU7WC26G8yGD4IKfu2nmff4ZpwMOs0YLgXbfIJLTUT4WCWJu', '2', '7', '2024-05-15 15:32:42'),
(9, 'Teacher 1', 'teacher1', 'teacher1@gmail.com', '$2y$10$Vh9B8xvrXWmP7T62DPyeNuLvylzDBMqaMcDjKFotgOvqqf1KoilQ2', '3', '7', '2024-05-16 21:34:57'),
(10, 'Super Admin 02', 'superadmin2', 'ramaiswara098@gmail.com', '$2y$10$Rox8T4uhMcdrX9TPAM8.5ue//OnaCkPOh3y7PzLu2d2OkNLM56pNq', '1', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `receive`
--
ALTER TABLE `receive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currency` (`currency_id`),
  ADD KEY `class` (`class_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `tuition_type`
--
ALTER TABLE `tuition_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2481;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `receive`
--
ALTER TABLE `receive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tuition_type`
--
ALTER TABLE `tuition_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `class_id` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
  ADD CONSTRAINT `invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `class` FOREIGN KEY (`class_id`) REFERENCES `class` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
