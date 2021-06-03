-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2020 at 03:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `charitymanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `starting_date` date NOT NULL,
  `starting_time` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `files` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `title`, `duration`, `starting_date`, `starting_time`, `location`, `description`, `files`) VALUES
(7, 'Agathian visit', 1, '2020-07-03', '06:50', 'Petaling Jaya', 'Cleaning, teaching, vloging', 0x3130323333313736385f343534383730343235313832313731365f333234383037373130343533343139303233315f6f2e706e67),
(9, 'Food donation', 2, '2020-07-10', '09:52', 'Ampang', 'Food donation to orphanage ', 0x3130323333313736385f343534383730343235313832313731365f333234383037373130343533343139303233315f6f2e706e67),
(10, 'Senior citizen welfare', 3, '2020-07-29', '11:52', 'Putra Jaya', 'Interview, give medication, give clothings', 0x3130323333313736385f343534383730343235313832313731365f333234383037373130343533343139303233315f6f2e706e67),
(11, 'Kinder garden school visit', 1, '2020-07-25', '08:00', 'Vikas international school, klang', 'Spend a day with kids to teach them various stuffs', 0x3130323333313736385f343534383730343235313832313731365f333234383037373130343533343139303233315f6f2e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE `useraccounts` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`user_id`, `fullname`, `username`, `email`, `password`, `birthday`, `phone`, `address`, `state`, `zip`) VALUES
(19, 'Faiyaz Khan', 'faiyaz', 'faiyazkhan@gmail.com', '$2y$10$286f0lsGi7rO4A29WkrKxuY9o28FBAZJ8UjQrqdNLlOFO5.k8IY7u', '1997-05-13', 1121721029, 'Jalan pantai murni 1, Pantai Hillpark Phase 2, Pantai Hillpark', 'Kuala Lumpur', 59200),
(20, 'Shahan Ali Pranto', 'shahan', 'shahan@gmail.com', '$2y$10$Gae16ljl2w4PxwPpwJi/xOV2gYjbbfrKX..HHxmVdDLx6efzfG4XG', '1997-06-17', 1176821982, 'Bangsar south,49/b', 'Kuala Lumpur', 31415);

-- --------------------------------------------------------

--
-- Table structure for table `volinproject`
--

CREATE TABLE `volinproject` (
  `volinproject_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `vol_id` int(11) NOT NULL,
  `task` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `volinproject`
--

INSERT INTO `volinproject` (`volinproject_id`, `project_id`, `vol_id`, `task`) VALUES
(24, 7, 15, 'buy stuff'),
(25, 7, 18, 'gregergergre'),
(26, 9, 12, 'ewgwegweg'),
(27, 9, 24, 'sgegweg');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `vol_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `nric` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`vol_id`, `fullname`, `nric`, `age`, `nationality`, `phone`, `email`, `address`) VALUES
(12, 'Dunkin', 'er31414', 50, 'Malaysian', 43434343, 'dunkin@gmail.com', 'deg ew gweg'),
(15, 'Bucky', 'fvq2141', 35, 'gwegweg', 142141541, 'bucky@gmail.com', 'sdgsgwge'),
(18, 'Jordan', 'q14124', 21, 'fqfqfq', 214124124, 'jordan@yahoo.com', 'gewegwe gwg weg'),
(21, 'joe', 'bh1352', 31, 'regherherh', 246248828, 'joe@gmail.com', 'rgwrgwregwr'),
(23, 'jeem', 'gew2121', 32, 'kgykgyyg', 2147483647, 'jeem@gmail.com', 'wgeg wegewgw'),
(24, 'Jaimey', 'jm31515', 32, 'vwebweb', 827326, 'jaimey@gmail.com', 'dbhbhsbbrbrb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `useraccounts`
--
ALTER TABLE `useraccounts`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `volinproject`
--
ALTER TABLE `volinproject`
  ADD PRIMARY KEY (`volinproject_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `vol_id` (`vol_id`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`vol_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `useraccounts`
--
ALTER TABLE `useraccounts`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `volinproject`
--
ALTER TABLE `volinproject`
  MODIFY `volinproject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `vol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `volinproject`
--
ALTER TABLE `volinproject`
  ADD CONSTRAINT `volinproject_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volinproject_ibfk_2` FOREIGN KEY (`vol_id`) REFERENCES `volunteers` (`vol_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
