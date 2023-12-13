-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 10:45 AM
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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerId`, `customerType`, `customerFirstName`, `customerLastName`, `customerEmail`, `customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`, `customerIsActive`) VALUES
('3s18', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700138810, 0),
('BLEC', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700488839, 0),
('Db44', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700489527, 0),
('HN41', 'guest', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700472680, 0),
('J0WI', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700490130, 0),
('N18h', 'customer', 'Tariks', 'Zarouali', 'hupp@hupp', '06 24330105', 'ad', 'ad', 1700556638, 0),
('pdoW', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700489010, 0),
('Q8PP', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700489445, 0),
('Sumz', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700556649, 1),
('WKjT', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700556662, 1),
('xr6x', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700492587, 0),
('Yriu', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '06 24330105', 'kievit 57', '3972PH', 1700488982, 0);

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

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employeeId`, `employeeStoreId`, `employeeFirstName`, `employeeLastName`, `employeeZipCode`, `employeeRole`, `employeeIsActive`, `employeeCreateDate`, `employeeDescription`) VALUES
('3MXY', 'zqtF', 'ttaasd', 'rtt', 't123', 'baker', 0, 1700139321, 'a'),
('Ae3k', 'zqtF', 'tt', 'rtt', 't123', 'deliverer', 1, 1700557009, 'rewr'),
('f5yz', 'zqtF', 'tt', 'rtt', 't123', 'baker', 1, 1700557016, 'wrewr'),
('iRIk', '0eB5', 'tta', 'rtt', 't123', 'baker', 0, 1699954387, 'as'),
('RXqt', 'zqtF', 'sdf', 'sdf', 'dsf', 'baker', 1, 1700557021, 'dsf'),
('uSBu', '4jCx', 'tt', 'rtt', 't123', 'baker', 1, 1700842548, 'ju'),
('X3Hs', 'zqtF', 'sdf', 'dsf', 'dsf', 'baker', 1, 1700557026, 'dsf');

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

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ingredientId`, `ingredientName`, `ingredientIsActive`, `ingredientDescription`, `ingredientCreateDate`, `ingredientPrice`) VALUES
('BoOQ', 'pepperonia', 0, 'halal pepperoni ', 1700139078, '0.00'),
('kTrI', 'pepperoni', 1, 'halal pepperoni ', 1700495277, '6.99'),
('my0d', 'pepperoni', 1, 'halal pepperoni ', 1700495271, '6.99'),
('Pg5H', 'pepperoni', 1, 'halal pepperoni ', 1700495286, '6.99'),
('R3Qk', 'pepperoni', 1, 'halal pepperoni ', 1700820758, '6.99'),
('SFL0', 'pepperoni', 0, 'halal pepperoni a', 1699954453, '6.99'),
('UE2Q', 'pepperoni', 1, 'halal pepperoni a', 1700493831, '6.99');

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription`) VALUES
('7W29', 'Sumz', 'zqtF', 1700142604, 'inTheMake', 'succes', '0.21', 'aad'),
('BljK', 'J0WI', 'zqtF', 1700557267, 'inTheMake', 'succes', '0.21', 'asdad'),
('PClR', 'J0WI', 'zqtF', 1700557272, 'inTheMake', 'succes', '2.22', 'adasd'),
('q5zN', 'J0WI', 'zqtF', 1700557263, 'inTheMake', 'succes', '0.20', 'asda');

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
  `productOwner` varchar(4) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text DEFAULT NULL,
  `productPrice` decimal(6,2) NOT NULL,
  `productType` enum('pizza','coupons','drinks','snacks','custompizza') NOT NULL,
  `productIsActive` tinyint(1) NOT NULL,
  `productCreateDate` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`) VALUES
('5a7M', 'J0WI', 'hello', 'da', '2.22', 'pizza', 0, 1700559417),
('Fvh6', 'J0WI', 'hello', 'da', '2.22', 'pizza', 0, 1700558009),
('Kqjd', 'J0WI', 'hello', 'da', '2.22', 'pizza', 1, 1700558278),
('l3j3', 'J0WI', 'hello', 'da', '2.22', 'pizza', 0, 1700558287),
('ma7r', 'J0WI', 'hello', 'da', '2.22', 'pizza', 1, 1700558002),
('p4pU', 'J0WI', 'hello', 'da', '2.22', 'pizza', 0, 1700558026),
('RrHy', 'J0WI', 'hello', 'da', '2.22', 'pizza', 1, 1700558019);

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

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promotionId`, `promotionName`, `promotionDescription`, `promotionIsActive`, `promotionCreateDate`, `promotionEndDate`) VALUES
('3GhD', 'eastera', 'easters', 1, 1700558554, 0),
('9gTe', 'easter', 'a', 1, 1700558514, 1700866800),
('BP6U', 'easter', 'christmas action with sales', 1, 1700471623, 1700866800),
('c2Fj', 'easter', 'easter', 1, 1700558533, 1700607600),
('il9a', 'easter', 'easter', 0, 1700473039, 0),
('LDEX', 'easter', 'easter', 0, 1700472447, 1701385200),
('ntHZ', 'easter', 'christmas action with sales', 0, 1700144856, 1700175600),
('vRuW', 'easter', 'easter', 0, 1700472950, 1700521200),
('YBiW', 'easter', 'easter', 0, 1700471659, 1700089200);

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewId`, `reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewDescription`, `reviewCreateDate`, `reviewIsActive`) VALUES
('9z8W', '3s18', '', '2.00', '1', 1700142722, 0),
('Jx6b', '3s18', '', '2.00', 'a', 1700142772, 0),
('JYHE', 'Sumz', 'Kqjd', '5.00', 'mad', 1700558711, 0),
('KYf6', '3s18', '', '13.00', '13', 1700143855, 0),
('MKrZ', '3s18', '', '78.00', '98', 1700144167, 0),
('niVt', '3s18', 'LIDk', '2.00', '1edsdfasd', 1700144274, 1),
('o6m2', '3s18', '', '2.00', '1', 1700142678, 0),
('U7j1', 'J0WI', 'Kqjd', '5.00', 'dsa', 1700558707, 1),
('v0Cj', '3s18', '', '13.00', 'a', 1700143706, 0),
('V6dw', 'J0WI', 'Kqjd', '5.00', 'asdad', 1700558717, 1),
('VzKk', 'J0WI', 'Kqjd', '5.00', 'asdd', 1700558714, 1),
('WkH5', '3s18', '', '2.00', 'a', 1700142661, 0),
('YQbd', '3s18', '', '2.00', '1', 1700142701, 0);

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `screenId` varchar(4) NOT NULL,
  `screenCreateDate` int(10) NOT NULL,
  `screenIsActive` tinyint(1) NOT NULL,
  `screenEntityId` varchar(4) NOT NULL,
  `screenEntity` varchar(50) NOT NULL,
  `screenScope` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId`, `screenEntity`, `screenScope`) VALUES
('v2pB', 1701077657, 1, 'niVt', 'review', 'asd'),
('Y4Fh', 1700843887, 1, '5a7M', 'product', 'main'),
('YeyJ', 1700842786, 1, 'Sumz', 'customer', 'main'),
('YViM', 1700842314, 1, 'Ae3k', 'customer', 'main');

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

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`storeId`, `storeStreetName`, `storeCity`, `storePhone`, `storeZipCode`, `storeEmail`, `storeManager`, `storeIsActive`, `storeCreateDate`) VALUES
('0eB5', 'oaklane 12', 'sdaa', '23132', 'qwe', '21wq', NULL, 0, 1699954377),
('4jCx', 'oaklane 12', 'sda', '23132ads', 'qwe', '21wq', NULL, 1, 1700559103),
('giLA', 'oaklane 12', 'sda', '23132', 'qwe', '21wq', NULL, 1, 1700559078),
('T9y1', 'oaklane 12', 'sda', '23132', 'qwe', '21wq', NULL, 1, 1700559086),
('zIDp', 'oaklane 12', 'sda', '23132', 'qwe', '21wq', NULL, 1, 1700559094),
('zqtF', 'oaklane 12', 'sda', 'a', 'qwe', '21wq', NULL, 1, 1699954581);

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
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicleId`, `vehicleStoreId`, `vehicleMaintenanceDate`, `vehicleType`, `vehicleIsActive`, `vehicleCreateDate`) VALUES
('FoBZ', 'zqtF', 2023, 'scooter', 1, 1700144612),
('KKuk', '4jCx', 2023, 'scooter', 1, 1700559341),
('lh5P', '4jCx', 2023, 'scooter', 1, 1700559345),
('Pns4', '4jCx', 2023, 'scooter', 1, 1700559338),
('PR9r', '4jCx', 2023, 'scooter', 1, 1700559310);

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
