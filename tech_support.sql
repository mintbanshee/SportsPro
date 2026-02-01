-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 01, 2026 at 02:27 AM
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
-- Database: `tech_support`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `adminID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`adminID`, `username`, `passwordHash`) VALUES
(1, 'admin', '$2y$10$exampleexampleexampleexampleexampleexampleexampleex');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `countryCode` char(2) NOT NULL,
  `countryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`countryCode`, `countryName`) VALUES
('CA', 'Canada'),
('US', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postalCode` varchar(20) DEFAULT NULL,
  `countryCode` char(2) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passwordHash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `firstName`, `lastName`, `address`, `city`, `state`, `postalCode`, `countryCode`, `phone`, `email`, `passwordHash`) VALUES
(1, 'Alex', 'Morgan', '10 King St', 'Toronto', 'ON', 'M5H 1A1', 'CA', '416-111-2222', 'alex@example.com', NULL),
(2, 'Jamie', 'Lee', '200 Main Ave', 'Buffalo', 'NY', '14201', 'US', '716-333-4444', 'jamie@example.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `incidentID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `techID` int(11) DEFAULT NULL,
  `dateOpened` datetime NOT NULL DEFAULT current_timestamp(),
  `dateClosed` datetime DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`incidentID`, `customerID`, `productCode`, `techID`, `dateOpened`, `dateClosed`, `title`, `description`) VALUES
(1, 1, 'BB10', 1, '2026-01-28 20:52:00', NULL, 'Cannot save league', 'Error appears when saving.'),
(2, 2, 'SC15', NULL, '2026-01-28 20:52:00', NULL, 'Install issue', 'Setup fails at step 2.');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productCode` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `releaseDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productCode`, `name`, `version`, `releaseDate`) VALUES
('BB10', 'Baseball Pro', '1.0', '2025-09-01'),
('SC15', 'Soccer Pro', '1.5', '2025-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `registrationID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `productCode` varchar(10) NOT NULL,
  `registrationDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`registrationID`, `customerID`, `productCode`, `registrationDate`) VALUES
(1, 1, 'BB10', '2026-01-28 20:52:00'),
(2, 2, 'SC15', '2026-01-28 20:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `techID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `passwordHash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`techID`, `firstName`, `lastName`, `email`, `phone`, `passwordHash`) VALUES
(1, 'Taylor', 'Ng', 'tng@sportspro.com', '416-555-9876', NULL),
(2, 'Chris', 'Patel', 'cpatel@sportspro.com', '416-555-4567', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`adminID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryCode`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_customers_country` (`countryCode`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`incidentID`),
  ADD KEY `fk_incident_customer` (`customerID`),
  ADD KEY `fk_incident_product` (`productCode`),
  ADD KEY `fk_incident_tech` (`techID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productCode`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`registrationID`),
  ADD UNIQUE KEY `uq_customer_product` (`customerID`,`productCode`),
  ADD KEY `fk_reg_product` (`productCode`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`techID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `incidentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `registrationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `techID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_country` FOREIGN KEY (`countryCode`) REFERENCES `countries` (`countryCode`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `fk_incident_customer` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incident_product` FOREIGN KEY (`productCode`) REFERENCES `products` (`productCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_incident_tech` FOREIGN KEY (`techID`) REFERENCES `technicians` (`techID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_reg_customer` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reg_product` FOREIGN KEY (`productCode`) REFERENCES `products` (`productCode`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
