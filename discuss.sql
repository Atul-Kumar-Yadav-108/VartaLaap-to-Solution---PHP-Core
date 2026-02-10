-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2026 at 11:14 AM
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
-- Database: `discuss`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `category` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'IT'),
(2, 'python'),
(3, 'larave'),
(4, 'javascript');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `comment` text NOT NULL,
  `question_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `question_id`, `user_id`) VALUES
(1, 'test', 3, 1),
(2, 'making food where hindi', 3, 1),
(3, '<script>alert(\"Hello\")</script>', 10, 1),
(4, 'print(\"Hello\");', 1, 2),
(5, 'html is a languge to build web structure which help to build the skeleton of the web page', 10, 2),
(7, 'werehtfgbvdsv', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `description`, `category`, `user_id`) VALUES
(1, 'test55', 'test55', 'Python', 2),
(2, 'Laravel', 'This is a php framework which helps use to do task very efficently...', 'Laravel', 2),
(3, 'what is ram', 'thiad;kalkf  ashl ahsdfjah ', 'IT', 1),
(5, 'asdflka', 'skhgoisavnuay', 'Laravel', 2),
(7, 'adhlai asod ia', 'auiuva;eriovjaus ah dflkadjhfdld ahdlaj', 'IT', 2),
(8, 'test2', 'test2', 'IT', 2),
(9, 'deis', 'kdaklj adakjd a', 'Laravel', 2),
(10, 'html', 'what is html', 'IT', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `favourite` varchar(50) NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user' COMMENT 'user || admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `address`, `favourite`, `profile`, `role`) VALUES
(1, 'Jyoti', '$2y$10$FHCgGmJX7UoYhNZqN5A.IeTuZhssDRGrugjXKHSc9MQ7o1GV/FSFy', 'jyoti@example.com', 'UP', 'bhatni', '1_robo1-removebg-preview.png', 'user'),
(2, 'Atul', '$2y$10$kMw3YgmMfI6TNxa0iWOV9.uyMnIb58qu1IQIn945zxHP1FwtWVjWG', 'atul@gmail.com', 'Pune Maharashtra', 'bhatni', '2_2605354_379101-PBVBK6-873.jpg', 'admin'),
(3, 'Balram', '$2y$10$FGnoneCcTGSN7bdRs2P7P.PxwqAwIV/DJay9ncQCCqYZPML8mSqCC', 'balram@gmail.com', 'pokhrapar rampur bhatni deoria up', 'ludo', NULL, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
