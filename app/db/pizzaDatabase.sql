-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 10:43 AM
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
  `customerPassword` varchar(50) NOT NULL,
  `customerPhone` varchar(12) DEFAULT NULL,
  `customerAddress` varchar(255) DEFAULT NULL,
  `customerZipCode` varchar(10) DEFAULT NULL,
  `customerCreateDate` int(10) NOT NULL,
  `customerIsActive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerId`, `customerType`, `customerFirstName`, `customerLastName`, `customerEmail`, `customerPassword`, `customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`, `customerIsActive`) VALUES
('6LHu', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', 'd', 1701873941, 1),
('E41M', 'customer', '', '', '', '', NULL, NULL, NULL, 1702651173, 1),
('J0WI', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700490130, 0),
('JW5s', 'customer', '', '', '', '', NULL, NULL, NULL, 1702892166, 1),
('mC8m', 'customer', '', '', '', '', NULL, NULL, NULL, 1702892467, 1),
('pdoW', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700489010, 0),
('ptZJ', 'customer', 'Tarik ', 'Zarouali', 'tarik@tarik.nl', '', '06 24330105', 'kievit 57', '3972PH', 1701090427, 0),
('Q8PP', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700489445, 0),
('Sj9I', 'customer', 'John', 'Doe', 'johndoe@gmail.com', 'CooleKerel01!', NULL, NULL, NULL, 1702637561, 1),
('Sumz', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700556649, 0),
('Tht9', 'admin', 'Tarik ', 'Zarouali', 'tarik@tarik.nl', '', '06 24330105', 'kievit 57', '3972PH', 1701169658, 0),
('TvvT', 'customer', 'ouassim', 'doe', 'ouassimdoe@gmail.com', 'Vruchten01!', NULL, NULL, NULL, 1702892259, 1),
('uaYn', 'customer', 'ouassim', 'doe', 'ouassimdoe@gmail.com', 'Vruchten01!', NULL, NULL, NULL, 1702892262, 1),
('WKjT', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700556662, 0),
('x6bZ', 'customer', '', '', '', '', NULL, NULL, NULL, 1702892244, 1),
('xr6x', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700492587, 0),
('Yriu', 'customer', 'Tarik ', 'Zarouali', 'hupp@hupp', '', '06 24330105', 'kievit 57', '3972PH', 1700488982, 0),
('zWjy', 'customer', 'ouassim', 'Doe', 'ouassimdoe@gmail.com', '', NULL, NULL, NULL, 1702892203, 1);

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
('f5yz', 'zqtF', 'tt', 'rtt', 't123', 'baker', 0, 1700557016, 'wrewr'),
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
('1vC6', 'mushrooms', 1, 'mushrooms', 1701172204, '2.99'),
('4vAE', 'cheese', 1, 'cheese', 1701172160, '2.99'),
('ancX', 'mozarella', 1, 'mozarella ', 1701172241, '2.99'),
('b0WB', 'pepperoni', 1, 'pepperoni', 1701172271, '4.99'),
('bVPW', 'red onions', 1, 'onions', 1701172885, '0.99'),
('tjgY', 'ham', 1, 'meat', 1701172176, '3.99'),
('w7NY', 'tonijn', 1, 'fish', 1701172871, '2.99'),
('wTD8', 'chorizo', 1, 'meat', 1701172194, '3.99'),
('zDwG', 'pesto', 1, 'pesto', 1701172225, '3.99'),
('zS7G', 'tomatoes', 1, 'tomatoes', 1701172215, '2.99');

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

--
-- Dumping data for table `producthasingredients`
--

INSERT INTO `producthasingredients` (`productId`, `ingredientId`) VALUES
('aYSj', '4vAE'),
('l2XV', '1vC6'),
('l2XV', '4vAE'),
('miLe', '4vAE'),
('miLe', 'tjgY'),
('miLe', 'wTD8'),
('omAQ', '4vAE'),
('omAQ', 'zDwG'),
('omAQ', 'zS7G'),
('pGuk', '4vAE'),
('SHQt', '4vAE'),
('SHQt', 'bVPW'),
('SHQt', 'w7NY'),
('Vz4z', 'b0WB');

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
('9DkF', 'Tht9', 'cola', 'soda drink', '4.00', 'drinks', 1, 1701169692),
('aYSj', 'Tht9', 'pizza margharita', 'pizza with cheese', '8.00', 'pizza', 1, 1701169818),
('j22L', 'Tht9', 'fries', 'thin sliced potatoes', '6.99', 'snacks', 1, 1701169717),
('l2XV', 'Tht9', 'mushroom pizza', 'pizza with mushrooms', '13.99', 'pizza', 1, 1701169750),
('miLe', 'Tht9', 'pizza meatlovers', 'pizza with alot of meat', '15.99', 'pizza', 1, 1701169735),
('omAQ', 'Tht9', 'caprese pizza', 'pizza with tomatoes, mozarella and pesto', '12.99', 'pizza', 1, 1701169790),
('pGuk', 'Tht9', '4 cheese pizza', 'pizza with 4 cheeses', '15.99', 'pizza', 1, 1701169769),
('SHQt', 'Tht9', 'Pizza tono', 'Pizza with red onions, cheese and tuna', '12.99', 'pizza', 1, 1701169669),
('Vz4z', 'Tht9', 'Pizza pepperoni', 'Pizza with pepperoni', '9.99', 'pizza', 1, 1701172292);

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
('3GhD', 'eastera', 'easters', 0, 1700558554, 0),
('9gTe', 'easter', 'a', 0, 1700558514, 1700866800),
('BP6U', 'easter', 'christmas action with sales', 0, 1700471623, 1700866800),
('c2Fj', 'easter', 'easter', 0, 1700558533, 1700607600),
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
('37Xl', 'Tht9', 'SHQt', '8.00', 'like the pizza but the onions werent fresh', 1701768104, 1),
('HoTR', 'Tht9', 'aYSj', '7.00', 'dg', 1701768015, 1),
('KoUc', 'Tht9', 'Vz4z', '9.00', 'I love the pepperoni', 1701768116, 1),
('kZrO', 'Tht9', 'j22L', '8.00', 'nice fries!', 1701768026, 1),
('oiCg', 'Tht9', 'miLe', '7.00', 'did not like the ham that much', 1701768058, 1),
('q6FD', 'Tht9', '9DkF', '6.00', 'good', 1701768006, 1),
('SeKs', 'Tht9', 'omAQ', '8.00', 'nice pizza', 1701768073, 1),
('t77X', 'Tht9', 'l2XV', '9.00', 'very good quality mushrooms', 1701768040, 1),
('UGF8', 'Tht9', 'pGuk', '10.00', 'Loved it', 1701768084, 1);

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
('0xd9', 1701100466, 0, '4jCx', 'store', 'main'),
('2iL2', 1701100273, 1, ' giL', 'store', 'main'),
('3LeR', 1701169875, 1, 'pGuk', 'product', 'main'),
('664q', 1701172305, 1, 'Vz4z', 'product', 'main'),
('8GMC', 1701100524, 0, 'FoBZ', 'vehicle', 'main'),
('8ixj', 1701169829, 1, 'aYSj', 'product', 'main'),
('DjQY', 1701092071, 0, '9gTe', 'promotion', 'da'),
('eq2I', 1701099283, 0, 'Ae3k', 'employee', 'main'),
('euUX', 1701092023, 1, 'pfwu', 'product', 'main'),
('H58A', 1701170038, 1, 'j22L', 'product', 'main'),
('HhXe', 1701097869, 1, 'qvOL', 'product', 'main'),
('MYP4', 1701099637, 0, '2f4x', 'ingredient', 'main'),
('oslP', 1701170028, 1, '9DkF', 'product', 'main'),
('QplM', 1701169852, 1, 'miLe', 'product', 'main'),
('qvqq', 1701090438, 0, 'ptZJ', 'customer', 'main'),
('uT3j', 1701096783, 0, 'ptZJ', 'customer', 'main'),
('v2pB', 1701077657, 0, 'niVt', 'review', 'asd'),
('vHjL', 1701169841, 1, 'l2XV', 'product', 'main'),
('wLKg', 1701097846, 0, 'niVt', 'review', 'asdas'),
('x3gE', 1701090470, 1, '3GhD', 'promotion', 'margharita'),
('Xb3k', 1701169886, 1, 'SHQt', 'product', 'main'),
('xNlA', 1701097877, 0, 'ptZJ', 'customer', 'main'),
('Y4Fh', 1700843887, 1, '5a7M', 'product', 'main'),
('YeyJ', 1700842786, 1, 'Sumz', 'customer', 'main'),
('YViM', 1700842314, 0, 'Ae3k', 'customer', 'main'),
('zj1n', 1701169864, 1, 'omAQ', 'product', 'main'),
('zq5b', 1701092089, 0, '9gTe', 'promotion', '4cheese');

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
('giLA', 'oaklane 12', 'sda', '23132', 'qwe', '21wq', NULL, 0, 1700559078),
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
