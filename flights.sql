-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019 m. Sau 18 d. 14:38
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.11-4+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flights`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `category`
--

CREATE TABLE `category` (
  `id` int(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Super Deals'),
(2, 'Christmas Vacations'),
(3, 'Summer Vacations');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `flight`
--

CREATE TABLE `flight` (
  `id` int(20) NOT NULL,
  `name` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `flight_from` varchar(20) COLLATE utf8_lithuanian_ci NOT NULL,
  `flight_to` varchar(20) COLLATE utf8_lithuanian_ci NOT NULL,
  `price` float NOT NULL,
  `flight_category` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Sukurta duomenų kopija lentelei `flight`
--

INSERT INTO `flight` (`id`, `name`, `description`, `flight_from`, `flight_to`, `price`, `flight_category`) VALUES
(1, 'Hawaii Vacation', 'Have a nice vacation in the exotic state of Hawaii!', 'Kaunas', 'Hawaii', 1999.99, 1),
(2, 'Poland Fantastic!', 'Take a nice trip to Poland', 'Kaunas', 'Warsaw', 1219.59, 2),
(3, 'Russia Trip', 'A very cold and fun trip to Moscow!', 'Kaunas', 'Moscow', 299.99, 3),
(11, 'Poland is kill', 'Take a nice trip to Poland', 'Kaunas', 'Warsaw', 9999, 1),
(15, 'Bahamas and Chill', 'Chill out with a nice summer vacation in the Bahamas', 'Vilnius', 'Bahamas', 9999.99, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
