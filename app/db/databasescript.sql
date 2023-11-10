-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2023 at 01:17 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzaplaza`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerId` varchar(4) NOT NULL,
  `customerType` enum('customer','guest','admin') NOT NULL,
  `customerFirstName` varchar(255) NOT NULL,
  `customerLastName` varchar(255) NOT NULL,
  `customerEmail` varchar(255) NOT NULL,
  `customerPhone` varchar(12) NOT NULL,
  `customerAddress` varchar(255) NOT NULL,
  `customerZipCode` varchar(10) NOT NULL,
  `customerCreateDate` int(10) NOT NULL,
  `customerIsActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeId` varchar(4) NOT NULL,
  `employeeStoreId` varchar(4) NOT NULL,
  `employeeFirstName` varchar(255) NOT NULL,
  `employeeLastName` varchar(255) NOT NULL,
  `employeeZipCode` varchar(12) NOT NULL,
  `employeeRole` enum('baker','deliverer','manager') NOT NULL,
  `employeeIsActive` int(1) NOT NULL,
  `employeeCreateDate` int(10) NOT NULL,
  `employeeDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredientId` varchar(4) NOT NULL,
  `ingredientName` varchar(255) NOT NULL,
  `ingredientIsActive` int(1) NOT NULL,
  `ingredientDescription` varchar(255) DEFAULT NULL,
  `ingredientCreateDate` int(10) NOT NULL,
  `ingredientPrice` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orderhasproducts`
--

CREATE TABLE `orderhasproducts` (
  `orderId` varchar(4) NOT NULL,
  `productId` varchar(4) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` varchar(4) NOT NULL,
  `orderCustomerId` varchar(4) NOT NULL,
  `orderStoreId` varchar(4) NOT NULL,
  `orderCreateDate` int(10) NOT NULL,
  `orderState` enum('inTheMake','inOven','isDelivered') NOT NULL,
  `orderStatus` enum('succes','pending','failed') NOT NULL,
  `orderPrice` decimal(6,2) NOT NULL,
  `orderDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `producthasingredients`
--

CREATE TABLE `producthasingredients` (
  `productId` varchar(4) NOT NULL,
  `ingredientId` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` varchar(4) NOT NULL,
  `productOwner` varchar(4) DEFAULT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text DEFAULT NULL,
  `productPrice` decimal(6,2) NOT NULL,
  `productType` enum('pizza','coupons','drinks','snacks','custompizza') NOT NULL,
  `productIsActive` tinyint(1) NOT NULL,
  `productCreateDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promotionId` varchar(4) NOT NULL,
  `promotionName` varchar(255) NOT NULL,
  `promotionDescription` varchar(255) DEFAULT NULL,
  `promotionIsActive` int(1) NOT NULL,
  `promotionCreateDate` int(10) NOT NULL,
  `promotionEndDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` varchar(4) NOT NULL,
  `reviewCustomerId` varchar(4) NOT NULL,
  `reviewEntityId` varchar(4) NOT NULL,
  `reviewRating` decimal(6,2) NOT NULL,
  `reviewDescription` varchar(255) DEFAULT NULL,
  `reviewCreateDate` int(10) NOT NULL,
  `reviewIsActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `screenId` varchar(4) NOT NULL,
  `screenCreateDate` int(10) NOT NULL,
  `screenIsActive` tinyint(1) NOT NULL,
  `screenEntityId` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId`) VALUES
('1VEl', 1699617186, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `storeId` varchar(4) NOT NULL,
  `storeStreetName` varchar(255) NOT NULL,
  `storeCity` varchar(255) NOT NULL,
  `storePhone` varchar(12) NOT NULL,
  `storeZipCode` varchar(12) NOT NULL,
  `storeEmail` varchar(255) NOT NULL,
  `storeManager` varchar(4) DEFAULT NULL,
  `storeIsActive` int(1) NOT NULL,
  `storeCreateDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicleId` varchar(4) NOT NULL,
  `vehicleStoreId` varchar(4) NOT NULL,
  `vehicleMaintenanceDate` int(10) NOT NULL,
  `vehicleType` enum('scooter','car','bike') NOT NULL,
  `vehicleIsActive` int(1) NOT NULL,
  `vehicleCreateDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employeeId`),
  ADD KEY `employeeStoreId` (`employeeStoreId`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredientId`);

--
-- Indexes for table `orderhasproducts`
--
ALTER TABLE `orderhasproducts`
  ADD PRIMARY KEY (`orderId`,`productId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `orderCustomerId` (`orderCustomerId`),
  ADD KEY `orderStoreId` (`orderStoreId`);

--
-- Indexes for table `producthasingredients`
--
ALTER TABLE `producthasingredients`
  ADD PRIMARY KEY (`productId`,`ingredientId`),
  ADD KEY `ingredientId` (`ingredientId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `productOwner` (`productOwner`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotionId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `reviewCustomerId` (`reviewCustomerId`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`screenId`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`storeId`),
  ADD KEY `storeManager` (`storeManager`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicleId`),
  ADD KEY `vehicles_ibfk_1` (`vehicleStoreId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`employeeStoreId`) REFERENCES `stores` (`storeId`) ON UPDATE CASCADE;

--
-- Constraints for table `orderhasproducts`
--
ALTER TABLE `orderhasproducts`
  ADD CONSTRAINT `orderhasproducts_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orderhasproducts_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`orderCustomerId`) REFERENCES `customers` (`customerId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`orderStoreId`) REFERENCES `stores` (`storeId`) ON UPDATE CASCADE;

--
-- Constraints for table `producthasingredients`
--
ALTER TABLE `producthasingredients`
  ADD CONSTRAINT `producthasingredients_ibfk_1` FOREIGN KEY (`ingredientId`) REFERENCES `ingredients` (`ingredientId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `producthasingredients_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`productOwner`) REFERENCES `customers` (`customerId`) ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`reviewCustomerId`) REFERENCES `customers` (`customerId`) ON UPDATE CASCADE;

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`storeManager`) REFERENCES `employees` (`employeeId`) ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`vehicleStoreId`) REFERENCES `stores` (`storeId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
