-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2021 at 01:38 PM
-- Server version: 5.6.37
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `errortech`
--

-- --------------------------------------------------------

--
-- Table structure for table `my_users`
--

CREATE TABLE IF NOT EXISTS `my_users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `my_users`
--

INSERT INTO `my_users` (`user_id`, `full_name`, `email`, `password`, `created_by`, `is_admin`, `created_on`) VALUES
(1, 'sowmya', 'sowmya.vejerla@gmail.com', 'bec3a6c1daa91844f3904bd041cde3a4', 1, 1, '2021-06-07 10:37:09'),
(2, 'sowmya1', 'sowmya.veje@gmail.com', '271619d196f58f76fd6095f593aa14cf', 1, 1, '2021-06-07 11:33:53'),
(6, 'test1', 'test1@gmail.com', '05683d55e1601605323f1fd25e86e7c6', 11, 0, '2021-06-07 12:15:19'),
(7, 'test2', 'test2@gmail.com', '0a6b1dfffd2021b579a54e893ba96cff', 11, 0, '2021-06-07 12:15:19'),
(8, 'test4', 'test3@gmail.com', 'f2c16cce2ae4cc0903c2672f62da3ce8', 11, 0, '2021-06-07 12:15:19'),
(9, 'testing', 'testing@gmail.com', 'ae2b1fca515949e5d54fb22b8ed95575', 1, 1, '2021-06-07 12:23:24'),
(10, 'test5', 'test5@gmail.com', '7f7af0ebd6b281f73b6749a9de7c8ada', 11, 0, '2021-06-07 12:25:37'),
(11, 'testing1', 'testing11@gmail.com', '6b7330782b2feb4924020cc4a57782a9', 1, 1, '2021-06-07 12:36:51'),
(12, 'Siva P Sontineni', 's@gmail.com', '1eaf7c068a250a38e3bab770053c14c3', 1, 1, '2021-06-07 12:50:16'),
(13, 'sowmya', 'vejerldda.sowmya@gmail.com', '79ae3eaee97c54fc57b8a72affa26166', 12, 0, '2021-06-07 12:59:32'),
(14, 'sowmya', 'vejerla.sowmya@gmail.com', '350f560349eb07d00e22213593e0b180', 12, 0, '2021-06-07 13:03:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `my_users`
--
ALTER TABLE `my_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `my_users`
--
ALTER TABLE `my_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
