-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 11:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthtok`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(255) NOT NULL,
  `blogbody` varchar(255) NOT NULL,
  `blogtitle` varchar(255) NOT NULL,
  `image_01` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blogbody`, `blogtitle`, `image_01`, `created_at`) VALUES
(1, 'and here is the body of the blog', 'here is the title of the blog', 'Screenshot_20240223-134659.png', '2024-08-30'),
(2, 'and here is the body of the blog', 'another blog title', 'Screenshot_20240223-134659.png', '2024-08-30'),
(3, 'incoming great news anticipate ', 'great news', 'IMG-20240923-WA0048.jpg', '2024-09-23');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `DoctorEmail` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `A_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `DoctorEmail`, `email`, `reason`, `created_at`, `A_status`) VALUES
(18, 0, 'james769@gmail.com', 'wilfredc685@gmail.com', '', '2024-09-02', 'confirmed'),
(19, 0, 'james769@gmail.com', 'prosper67@gmail.com', '', '2024-09-21', 'unconfirmed'),
(21, 10, 'doctor@example.com', 'patient@example.com', 'Consultation', '2024-09-24', 'unconfirmed');

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` int(255) NOT NULL,
  `DoctorEmail` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `myMessage` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `DoctorEmail`, `email`, `myMessage`, `timestamp`) VALUES
(28, 'prosper67@gmail.com', 'james769@gmail.com', 'ehh', '2024-09-24 12:37:00'),
(29, 'prosper67@gmail.com', 'james769@gmail.com', 'bishop', '2024-09-24 13:21:45'),
(32, 'james769@gmail.com', 'wilfredc685@gmail.com', 'hi sir', '2024-09-24 15:40:25'),
(33, 'james769@gmail.com', 'wilfredc685@gmail.com', 'how are ', '2024-09-24 15:42:15'),
(34, 'james769@gmail.com', 'wilfredc685@gmail.com', 'how are you', '2024-09-24 15:42:52'),
(35, 'james769@gmail.com', 'wilfredc685@gmail.com', 'great right', '2024-09-24 15:45:04'),
(36, 'james769@gmail.com', 'wilfredc685@gmail.com', 'hope', '2024-09-24 15:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `like_box`
--

CREATE TABLE `like_box` (
  `id` int(255) NOT NULL,
  `DoctorEmail` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `like_box`
--

INSERT INTO `like_box` (`id`, `DoctorEmail`, `email`) VALUES
(18, 'james769@gmail.com', 'prosper67@gmail.com'),
(21, 'enakeno@gmaIl.com', 'wilfredc685@gmail.com'),
(24, 'james769@gmail.com', 'wilfredc685@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `messageseen`
--

CREATE TABLE `messageseen` (
  `id` int(255) NOT NULL,
  `DoctorEmail` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Lmessage` varchar(255) NOT NULL,
  `messageId` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messageseen`
--

INSERT INTO `messageseen` (`id`, `DoctorEmail`, `email`, `Lmessage`, `messageId`) VALUES
(67, 'prosper67@gmail.com', 'james769@gmail.com', '', ''),
(68, 'wilfredc685@gmail.com', 'james769@gmail.com', '', ''),
(69, 'james769@gmail.com', 'wilfredc685@gmail.com', '', ''),
(70, 'wilfredc685@gmail.com', 'james769@gmail.com', 'hi sir', '32'),
(71, 'wilfredc685@gmail.com', 'james769@gmail.com', 'how are ', '33'),
(72, 'wilfredc685@gmail.com', 'james769@gmail.com', 'how are you', '34'),
(73, 'wilfredc685@gmail.com', 'james769@gmail.com', 'great right', '35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userpassword` varchar(255) NOT NULL,
  `userrole` varchar(500) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `dateOfBirth` varchar(255) NOT NULL,
  `image_01` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `userpassword`, `userrole`, `gender`, `department`, `dateOfBirth`, `image_01`) VALUES
(2, 'chris', 'prosper685@gmail.com', 'password1', 'patient', '', '', '', ''),
(3, 'Christopher ', 'wilfredc685@gmail.com', 'password1', 'patient', '', '', '', 'IMG-20240923-WA0046.jpg'),
(4, 'prosper', 'prosper67@gmail.com', 'password2', 'patient', '', '', '', ''),
(5, 'james', 'james769@gmail.com', 'passwordA', 'practitioner', '', '', '', 'Screenshot_20240223-134659.png'),
(6, 'blessing', 'blessing12@gmail.com', 'passwordB', 'practitioner', '', '', '', ''),
(7, 'enakeno', 'enakeno@gmaIl.com', 'passwordC', 'practitioner', 'Male', 'cardiologist', '1996-08-09', ''),
(8, 'peace ofure', 'peace@gmail.com', '$2y$10$SuzUv2R6zpdRt1FJJIn1DeqrQAvh2PWK0yxX42.eRvS0DrhxCn9Fa', 'practitioner', 'Female', 'optometry', '1977-09-12', ''),
(10, 'amazingmax', 'joshuaademax@gmail.com', '$2y$10$I2kqakKwW9yC8S5afN4nxe9GHqcSNH7/vFom3XFjGdwMIUT.eGkM6', 'practitioner', 'male', 'Dentist', '2020-07-18', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `like_box`
--
ALTER TABLE `like_box`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messageseen`
--
ALTER TABLE `messageseen`
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
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `like_box`
--
ALTER TABLE `like_box`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messageseen`
--
ALTER TABLE `messageseen`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
