-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2025 at 03:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hardware_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `user_type` enum('admin','Guest','Contractor') DEFAULT 'Guest'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerID`, `full_name`, `mobile`, `username`, `password`, `created_at`, `user_type`) VALUES
(2, 'Admin User', '09999999999', 'admin', 'admin123', NULL, 'admin'),
(3, 'white ponsica', '09995137792', 'white', '$2y$10$V2/WN/YZ8IDuZYpUsuGegekWeNt.Z9jzRchoNOggbET.2brG5IGoe', NULL, 'Guest'),
(5, 'oscar wegies', '09999994999', 'oscarb', '$2y$10$Pk7mJbS3BFN/qqoaV.6jru08GAWxcEFBiDv4TJDV1m3HKc0TOR4Se', NULL, 'Guest'),
(6, 'baby boy', '0123456879', 'boy', '$2y$10$CdP.9p/WSD47D4XLIvzFk.6zCgDlUwieP/obtglaVnjhJF2uOWXBW', NULL, 'Contractor'),
(7, 'ryan noay', '09995137802', 'ryan', '$2y$10$eQxQNbVpddy3.pG9GPSJD.SRT8nBH8qwPNSkb.o4DV0XrkEtvMKv2', NULL, 'Guest'),
(8, 'mingoy ryan', '099999', 'reg123', '$2y$10$FLgdm1yfVTgohHXtdJ8dCutgQdWWqVdRkki7LFHvkYlOFaNqxFcua', NULL, ''),
(9, 'asdasdas', '123123123132', 'rrrrr', '$2y$10$8bCa5paBgcMSMd9IViR9SOoZPM7B7FqnsEYgT/vAOTYLHAQs3Wwq.', NULL, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `deliveryID` int(11) NOT NULL,
  `deliveryDate` date DEFAULT NULL,
  `deliveryStatus` varchar(50) DEFAULT NULL,
  `purchaseOrderID` int(11) DEFAULT NULL,
  `customerID` int(11) DEFAULT NULL,
  `deliveryAddress` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`deliveryID`, `deliveryDate`, `deliveryStatus`, `purchaseOrderID`, `customerID`, `deliveryAddress`) VALUES
(1, '2025-11-28', 'pending', 1, 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `materialID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_file` varchar(255) DEFAULT 'resources/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`materialID`, `title`, `details`, `price`, `image_file`) VALUES
(1, 'sample1', 'sample1', 1212.00, 'uploads/sampleImage.png'),
(4, 'sample3', 'sample3w', 123.00, 'uploads/sampleImage.png'),
(5, 'sample4', 'sample4', 123.00, 'uploads/sampleImage.png'),
(6, 'sample5', 'sample5', 12321.00, 'uploads/sampleImage.png'),
(7, 'shakoy', 'kinilo', 8.00, 'uploads/shak.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `material_supplier`
--

CREATE TABLE `material_supplier` (
  `MaterialID` int(11) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `SupplyPrice` decimal(10,2) DEFAULT NULL,
  `LeadTime` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(100) NOT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder`
--

CREATE TABLE `purchaseorder` (
  `PurchaseOrderID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `ProjectID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseorder`
--

INSERT INTO `purchaseorder` (`PurchaseOrderID`, `OrderDate`, `TotalAmount`, `Status`, `CustomerID`, `ProjectID`) VALUES
(1, '2025-11-26', 123.00, 'Pending', 7, NULL),
(2, '2025-11-26', 1220.00, 'Pending', 2, NULL),
(3, '2025-11-26', 12321.00, 'Pending', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorder_material`
--

CREATE TABLE `purchaseorder_material` (
  `PurchaseOrderID` int(11) NOT NULL,
  `MaterialID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` decimal(10,2) DEFAULT NULL,
  `Subtotal` decimal(10,2) GENERATED ALWAYS AS (`Quantity` * `UnitPrice`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchaseorder_material`
--

INSERT INTO `purchaseorder_material` (`PurchaseOrderID`, `MaterialID`, `Quantity`, `UnitPrice`) VALUES
(1, 5, 1, 123.00),
(2, 1, 1, 1212.00),
(2, 7, 1, 8.00),
(3, 6, 1, 12321.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierName` varchar(100) NOT NULL,
  `ContactPerson` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`deliveryID`),
  ADD KEY `PurchaseOrderID` (`purchaseOrderID`),
  ADD KEY `CustomerID` (`customerID`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`materialID`);

--
-- Indexes for table `material_supplier`
--
ALTER TABLE `material_supplier`
  ADD PRIMARY KEY (`MaterialID`,`SupplierID`),
  ADD KEY `SupplierID` (`SupplierID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ProjectID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD PRIMARY KEY (`PurchaseOrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ProjectID` (`ProjectID`);

--
-- Indexes for table `purchaseorder_material`
--
ALTER TABLE `purchaseorder_material`
  ADD PRIMARY KEY (`PurchaseOrderID`,`MaterialID`),
  ADD KEY `MaterialID` (`MaterialID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `deliveryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `materialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  MODIFY `PurchaseOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`purchaseOrderID`) REFERENCES `purchaseorder` (`PurchaseOrderID`);

--
-- Constraints for table `material_supplier`
--
ALTER TABLE `material_supplier`
  ADD CONSTRAINT `material_supplier_ibfk_1` FOREIGN KEY (`MaterialID`) REFERENCES `material` (`materialID`),
  ADD CONSTRAINT `material_supplier_ibfk_2` FOREIGN KEY (`SupplierID`) REFERENCES `supplier` (`SupplierID`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`customerID`);

--
-- Constraints for table `purchaseorder`
--
ALTER TABLE `purchaseorder`
  ADD CONSTRAINT `purchaseorder_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`customerID`),
  ADD CONSTRAINT `purchaseorder_ibfk_2` FOREIGN KEY (`ProjectID`) REFERENCES `project` (`ProjectID`);

--
-- Constraints for table `purchaseorder_material`
--
ALTER TABLE `purchaseorder_material`
  ADD CONSTRAINT `purchaseorder_material_ibfk_1` FOREIGN KEY (`PurchaseOrderID`) REFERENCES `purchaseorder` (`PurchaseOrderID`),
  ADD CONSTRAINT `purchaseorder_material_ibfk_2` FOREIGN KEY (`MaterialID`) REFERENCES `material` (`materialID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
