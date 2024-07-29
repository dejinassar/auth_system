-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2024 at 11:33 AM
-- Server version: 8.0.37-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auth_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`) VALUES
(4, 'Ibrahim  Nassar ', 'dejinassar@gmail.com', 'dfghjkoui');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profile_picture` varchar(100) NOT NULL DEFAULT 'default.png, '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `profile_picture`) VALUES
(1, 'Ibrahim', 'Nassar', 'dejinassar@gmail.com', '$2y$10$qo7KfM4SO8cMeNi05siunelFTkJs9oAeIgVJWcK9EdK4v1fVYt5Oe', '1720351964311.jpeg'),
(2, 'Ibrahim', 'Nassar', 'dejinassar@gmail.com', '$2y$10$sI0onjLgrMeaLOkjJuo/BeDOUo/fmcqLfR1k3GSBs0o8vCYPG3JmC', 'default.png, '),
(3, 'Bola', 'Ahmad', 'ibr2544@gmail.com', '$2y$10$nTk63q7QmP7nqRk99ibb0OEF9fJPrm6Fhh2sD9dFrn2TBelJmTyCy', 'default.png, '),
(4, 'Tolani', 'Tolani', 'tolani@gmail.com', '$2y$10$ZKQhsN0Az9Wok0mTtlDckOuIBovtCVh3zg8NWtAsDzvUhkYTkkn6y', 'default.png, '),
(5, 'uejkrj', 'jhwerjhjkr', 'ty@gmail.com', '$2y$10$F/ArhO52kRrJRl2iQZu8/O4QPwgcGFz6RXzJ2x5pKKvBTulgyP3aW', 'default.png, ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
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
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
