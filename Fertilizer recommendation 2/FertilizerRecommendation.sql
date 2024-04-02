-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2023 at 06:40 PM
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
-- Database: `FertilizerRecommendation`
--

-- --------------------------------------------------------

--
-- Table structure for table `DataAnalyticsFramework`
--

CREATE TABLE `DataAnalyticsFramework` (
  `frameworkID` int(11) NOT NULL,
  `framework` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `component` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DataReading`
--

CREATE TABLE `DataReading` (
  `readingID` int(11) NOT NULL,
  `soilMoisture` decimal(10,2) DEFAULT NULL,
  `soilTemperature` decimal(10,2) DEFAULT NULL,
  `potassiumContent` decimal(10,2) DEFAULT NULL,
  `nitrogenContent` decimal(10,2) DEFAULT NULL,
  `phosphorous` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Farm`
--

CREATE TABLE `Farm` (
  `farmID` int(11) NOT NULL,
  `farmName` varchar(100) DEFAULT NULL,
  `contactInfo` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `farmSize` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `FertilizerRecommendationSystem`
--

CREATE TABLE `FertilizerRecommendationSystem` (
  `recommendationID` int(11) NOT NULL,
  `cropType` varchar(100) DEFAULT NULL,
  `soilCondition` varchar(100) DEFAULT NULL,
  `fertilizer` varchar(100) DEFAULT NULL,
  `applicationGuidelines` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Sensor`
--

CREATE TABLE `Sensor` (
  `sensorID` int(11) NOT NULL,
  `sensorName` varchar(100) DEFAULT NULL,
  `sensorType` varchar(50) DEFAULT NULL,
  `farmID` int(11) DEFAULT NULL,
  `userData` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `contactInfo` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `DataAnalyticsFramework`
--
ALTER TABLE `DataAnalyticsFramework`
  ADD PRIMARY KEY (`frameworkID`);

--
-- Indexes for table `DataReading`
--
ALTER TABLE `DataReading`
  ADD PRIMARY KEY (`readingID`);

--
-- Indexes for table `Farm`
--
ALTER TABLE `Farm`
  ADD PRIMARY KEY (`farmID`);

--
-- Indexes for table `FertilizerRecommendationSystem`
--
ALTER TABLE `FertilizerRecommendationSystem`
  ADD PRIMARY KEY (`recommendationID`);

--
-- Indexes for table `Sensor`
--
ALTER TABLE `Sensor`
  ADD PRIMARY KEY (`sensorID`),
  ADD KEY `farmID` (`farmID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Sensor`
--
ALTER TABLE `Sensor`
  ADD CONSTRAINT `Sensor_ibfk_1` FOREIGN KEY (`farmID`) REFERENCES `Farm` (`farmID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
