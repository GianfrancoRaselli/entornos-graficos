-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 14, 2020 at 12:23 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capitales`
--

-- --------------------------------------------------------

--
-- Table structure for table `capitales`
--

CREATE TABLE `capitales` (
  `id` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `habitantes` int(11) NOT NULL,
  `superficie` float NOT NULL,
  `tieneMetro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `capitales`
--

INSERT INTO `capitales` (`id`, `ciudad`, `pais`, `habitantes`, `superficie`, `tieneMetro`) VALUES
(1, 'Mexico D.F.', 'Mexico', 555666, 23434.3, 1),
(2, 'Barcelona', 'EspaÃ±a', 444333, 1111.11, 0),
(3, 'Buenos Aires', 'Argentina', 888111, 333.33, 1),
(4, 'Medellin', 'Colombia', 999222, 888.88, 0),
(5, 'Lima', 'Peru', 999111, 222.22, 0),
(6, 'Caracas', 'Venezuela', 111222, 111.11, 1),
(7, 'Santiago', 'Chile', 777666, 222.22, 1),
(8, 'Antigua', 'Guatemala', 444222, 877.33, 0),
(9, 'Quito', 'Ecuador', 333111, 999.11, 1),
(10, 'La Habana', 'Cuba', 111222, 333.11, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `capitales`
--
ALTER TABLE `capitales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `capitales`
--
ALTER TABLE `capitales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
