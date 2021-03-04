-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2020 at 04:37 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_farming`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `farmer_id` int(100) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(500) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`farmer_id`, `user_name`, `user_email`, `user_password`, `user_type`) VALUES
(1, 'Tomal Ghosh', 'tomal.ghosh@somaiya.edu', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(2, 'Nagraj Vallakati', 'nagraj.v@somaiya.edu', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(3, 'Shatayu Thakur', 'shatayu.t@somaiya.edui', 'e10adc3949ba59abbe56e057f20f883e', 'user'),
(4, 'Yash Deshpande', 'deshpande.y@somaiya.edu', 'e10adc3949ba59abbe56e057f20f883e', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`farmer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `farmer_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
