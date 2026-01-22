-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 22, 2026 at 04:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hockey_players`
--

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `contactID` int(4) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `team` varchar(50) NOT NULL,
  `goals` varchar(50) NOT NULL,
  `assists` varchar(50) NOT NULL,
  `points` varchar(50) NOT NULL,
  `gamesPlayed` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`contactID`, `firstName`, `lastName`, `dob`, `team`, `goals`, `assists`, `points`, `gamesPlayed`) VALUES
(1, 'Connor', 'Mcdavid', '1997-01-13', 'Edmonton Oilers', '391', '776', '1167', '763'),
(3, 'Nathan', 'MacKinnon', '1995-09-01', 'Colorado Avalanche', '405', '695', '1100', '918'),
(4, 'Sidney', 'Crosby', '1987-08-07', 'Pittsburg Penguins', '651', '1092', '1743', '1401'),
(5, 'Sam ', 'Reinhart', '1995-11-06', 'Florida Panthers', '318', '348', '666', '823'),
(6, 'Brayden', 'Point', '1996-03-13', 'Tampa Bay Lightning', '317', '348', '665', '694'),
(7, 'Mitch ', 'Marner', '1997-05-05', 'Vegas Golden Knights', '233', '559', '792', '705'),
(8, 'Nick', 'Suzuki', '1999-08-10', 'Montreal Canadiens', '153', '277', '430', '505'),
(9, 'Macklin ', 'Celebrini', '2006-06-13', 'San Jose Sharks', '49', '86', '135', '119'),
(10, 'Anthony ', 'Cirelli', '1997-07-15', 'Tampa Bay Lightning', '137', '185', '322', '555'),
(11, 'Cale ', 'Makar', '1998-10-30', 'Colorado Avalanche', '130', '352', '482', '443');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`contactID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `contactID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
