-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2021 at 08:55 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cloudchase_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories_tbl`
--

CREATE TABLE `accessories_tbl` (
  `product_id` int(11) NOT NULL,
  `acc_name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accessories_tbl`
--

INSERT INTO `accessories_tbl` (`product_id`, `acc_name`, `description`, `price`, `quantity`) VALUES
(1, 'Drip Tip 810 & 510', '', 150, 27),
(2, 'Vape Band', '', 50, 31),
(3, 'Battery Case', '', 30, 16),
(4, 'Zeus X Bubble Glass Legit', '', 200, 21),
(5, 'Aegis Max Silicon', '', 200, 10);

-- --------------------------------------------------------

--
-- Table structure for table `hardwares_tbl`
--

CREATE TABLE `hardwares_tbl` (
  `product_id` int(11) NOT NULL,
  `hardware_name` varchar(250) NOT NULL,
  `hardware_type` enum('MOD','AUTOMIZERS','PODS','OCC & RBA','BATTERY & CHARGERS','WIRES & COTTONS') NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hardwares_tbl`
--

INSERT INTO `hardwares_tbl` (`product_id`, `hardware_name`, `hardware_type`, `description`, `price`, `quantity`) VALUES
(1, 'Aegis Solot Kit', 'MOD', '', 2200, 7),
(2, 'Aegis Legend Mod', 'MOD', '', 1900, 10),
(3, 'Dejavu Mecha Full Mech', 'MOD', '', 1800, 8),
(4, 'Oxva Arbiter RTA', 'AUTOMIZERS', '', 1400, 6),
(5, 'Dejavu RDTA', 'AUTOMIZERS', '', 1200, 12),
(6, 'Geekvape Talo X RDA', 'AUTOMIZERS', '', 1200, 15),
(7, 'Requiem RDA by Vandy Vape', 'AUTOMIZERS', '', 1200, 10),
(8, 'Oxva Origin X', 'PODS', '', 1500, 6),
(9, 'Oxva Veocity', 'PODS', '', 1800, 11),
(10, 'Aegis Boost Luxury', 'PODS', 'Limited Edition (5 coils)', 1800, 5),
(11, 'Lost Vape Gemini Hybrid', 'PODS', '', 1500, 7),
(12, 'Uwell Koko Prime', 'PODS', '', 1400, 3),
(13, 'Oxva OCC .3', 'OCC & RBA', '', 220, 10),
(14, 'Oxva OCC .2', 'OCC & RBA', '', 220, 10),
(15, 'Oxva UniPro OCC .15', 'OCC & RBA', '', 220, 8),
(16, 'Oxva UniPro RBA', 'OCC & RBA', '', 600, 10),
(17, 'Drag S OCC .2', 'OCC & RBA', '', 220, 10),
(18, 'Drag X OCC .15', 'OCC & RBA', '', 220, 10),
(19, 'Koko Caliburn OCC', 'OCC & RBA', '', 220, 8),
(20, 'Aegis Boost Pro OCC .4', 'OCC & RBA', '', 220, 10),
(21, 'XTAR MC2 Charger ', 'BATTERY & CHARGERS', '', 250, 10),
(22, 'Molicel 18650 Battery', 'BATTERY & CHARGERS', '', 250, 15),
(23, 'Molicel 21700 Bateery', 'BATTERY & CHARGERS', '', 500, 20),
(24, 'Vapemix Wires Clapton 28g, 26g', 'WIRES & COTTONS', '', 210, 10),
(25, 'RAM Fused Clapton 26g, 28g', 'WIRES & COTTONS', '', 220, 15),
(26, 'Intensity Wires Clapton 24g ', 'WIRES & COTTONS', '', 210, 15),
(27, 'Muji Cotton ', 'WIRES & COTTONS', '5 per PAD', 5, 20);

-- --------------------------------------------------------

--
-- Table structure for table `juices_tbl`
--

CREATE TABLE `juices_tbl` (
  `product_id` int(11) NOT NULL,
  `juice_name` varchar(250) NOT NULL,
  `juice_type` enum('Freebase','Salt Nic') NOT NULL,
  `flavor_type` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `juices_tbl`
--

INSERT INTO `juices_tbl` (`product_id`, `juice_name`, `juice_type`, `flavor_type`, `description`, `price`, `quantity`) VALUES
(1, 'Drizzle All day Havoc 2.0 Avocado 3mg/6mg', 'Freebase', 'PASTRY', '', 250, 20),
(2, 'iClouds Halo halo 6mg', 'Freebase', 'PASTRY', '', 300, 15),
(3, 'Dark Elixir 3mg', 'Freebase', 'MENTHOL', '', 300, 10),
(4, 'Flavairy Lychee & Peach 6mg', 'Freebase', 'MENTHOL', '', 200, 10),
(5, 'Sir Jack Melong Yakult 3mg', 'Freebase', 'FRUITY', '', 250, 10),
(6, 'Abang King Maria Ozawa 3mg', 'Freebase', 'FRUITY', '', 230, 10),
(7, 'Drizzle Salt Avocado Melon 30mg', 'Salt Nic', 'PASTRY', '', 300, 10),
(8, 'Mr. Onurbs Arctic Grapes & Currant 20mg', 'Salt Nic', 'MENTHOL', '', 400, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `address` text NOT NULL,
  `contact_num` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `password`, `lastname`, `firstname`, `role`, `status`, `birthdate`, `address`, `contact_num`) VALUES
(1, 'admin', 'admin', 'Jaylo', 'Angelica Mae', 'Administrator', 'Active', '1995-03-24', 'Bibincahan, Sorsogon City', '09123456789'),
(2, 'jogie', '12345', 'Escanilla', 'Jorge', 'Customer', 'Active', '1993-05-17', 'Balogo, Sorsogon', '09380841639');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `hardwares_tbl`
--
ALTER TABLE `hardwares_tbl`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `juices_tbl`
--
ALTER TABLE `juices_tbl`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories_tbl`
--
ALTER TABLE `accessories_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hardwares_tbl`
--
ALTER TABLE `hardwares_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `juices_tbl`
--
ALTER TABLE `juices_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
