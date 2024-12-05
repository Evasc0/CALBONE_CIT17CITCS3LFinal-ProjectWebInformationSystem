-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 11:13 AM
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
-- Database: `my_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(10, 'ada', NULL, 23.00, '2024-12-05 08:55:38'),
(11, 'ade', NULL, 45.00, '2024-12-05 08:58:37'),
(12, 'tea', NULL, 55.00, '2024-12-05 09:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'juan dela cruz', 'qwerty@gmail', '$2y$10$69MTvhpQwCEWCLjnlVN/aOEoJD8JtkyHUSEoC1wyGWt1VhWgZYeIW', 'User'),
(2, 'Juswa', 'juswa@gmail.com', '$2y$10$K1NNJgPEDhCePCRJ58nUmeeiJPfBU5.Dqz65NqxS3Q4N67sXlvodW', 'User'),
(4, 'eweff', 'wewwe@gmail.com', '$2y$10$e4FArZYkoUcdYCVWfDlQIOvieLDMtZtDZHZIALaAjZclBvhOD8wta', 'User'),
(5, 'basco', 'basco@gmail.com', '$2y$10$gztWqZEdTTj9QwKFqXEJSuHROx/53ArpfelODt3iDpE9wTUR6nrjG', 'User'),
(6, 'cong', 'cong@gmail.com', '$2y$10$RnnRJywV.GN/h7cNxedaNekzIAnYb2OlMeQt1aHQt8z7NDf8eTouu', 'User'),
(7, 'eva', 'eva@gmail.com', '$2y$10$qIapPkEkBp.b.bLk/0uezOr7d/XLBFh105UbZUfsqANMiyZRJfdzy', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
