-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 11, 2026 at 06:55 AM
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
-- Database: `AUTO Parts`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `orders_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `orders_name`, `product_id`, `quantity`, `total_price`) VALUES
(1, 'สมชาย', 1, 1, 14000.00),
(2, 'ล้อแม็ก', 2, 1, 12000.00),
(3, 'เบอะเเต่ง', 3, 1, 6500.00),
(4, 'ไฟหน้าแต่ง', 4, 1, 11000.00),
(5, 'ชุดเบรกแต่ง', 5, 1, 10000.00),
(11, 'สมชาย', 2, 4, 136000.00),
(15, 'สมชาย', 6, 1, 12000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `products_id` int(11) NOT NULL,
  `products_name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`products_id`, `products_name`, `category`, `price`, `stock`, `image_url`) VALUES
(1, 'โช้คหน้าถุงลม CEIKA Air Ride Coilover Kit for Ford Ranger T6', 'Suspension', 30000.00, 19, 'https://ceika-store.com/cdn/shop/files/CEIKA_Air_ride_coilover_kit_73668089-28ed-4e66-a193-702119df304b_2000x.png?v=1764334323'),
(2, 'ล้อแม็กซ์ M3 18\" 6รู139 ET30 ล้อไม่ล้น V SERIES (4วง)', 'Wheels', 34000.00, 0, 'https://down-th.img.susercontent.com/file/th-11134207-7r98w-lvq4dmaxwm713d'),
(3, 'เบาะแต่งรถ เบาะแต่ง เบาะซิ่ง เบาะรถแต่ง', 'Interior', 34000.00, 4, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLVKgQPVA6UbNAYx_IJw3GGp9Tay6lun2BSHuClLEcfhG6t84OpGv6L34&s=10'),
(4, 'ไฟหลัง LED อัตโนมัติสำหรับ 2023 2022 Isuzu D-MAX', 'Lighting', 2000.00, 15, 'https://down-th.img.susercontent.com/file/th-11134207-81ztf-mib6ik96gg7cb6.webp'),
(5, 'ชุดคลัทช์ BRC 11\" ตรงรุ่น D-max 2020 เครื่อง 3.0', 'Brake', 2000.00, 5, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBk9FOvArXO4gJflXVOmML99LtWc8n4BJkpY_QyZ215m0HkJZCx-BKkLCX&s=10'),
(6, 'ท่อสูตรกระบะซิ่ง ออกท้ายปลายไดร์สี มีพักกลางใบเล็ก', 'Exterior', 12000.00, 10, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxilZoSFMztdFSVHEDn_WYdvqmGrSL8AFbm4PtmgBFgLd5CWz-cONLNao&s=10'),
(7, 'พวงมาลัยแต่ง MOMO ขนาด 12.5 นิ้ว ก้านตรง หนังน้ำเงิน พร้อมคอแต่ง', 'Interior', 1200.00, 15, 'https://img.lazcdn.com/g/ff/kf/S7ca87560a73942cfa364f3d762f93569a.jpg_720x720q80.jpg'),
(8, 'หัวเกียร์แต่งรถกระบะ Revo / D-Max (งานไดร์สี)', 'Interior', 560.00, 20, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTR2Sx_XG6LQgo2njOg_4pYG-5c24t6Be3LD_PPNUPFoarS8SyvaMw-Pvg&s=10'),
(9, 'แต่งเครื่องเสียงรถยนต์ D-Max All New ชุดตู้ซับพร้อมลำโพง', 'Interior', 12000.00, 5, 'https://i.ytimg.com/vi/2i37dtPH4uU/maxresdefault.jpg'),
(10, 'โลโก้ LOGO ISUZU สีไทเท ครอบโลโก้หน้ากระจัง D-Max 2020', 'Exterior', 300.00, 25, 'https://sg-test-11.slatic.net/p/2a8985b1f989fbd4eccb1ad805fbadab.jpg'),
(11, 'คอหนา SWIFT คอพวงมาลัยแต่ง สำหรับ Suzuki Swift (ก่อนปี 2018)', 'Interior', 2000.00, 10, 'https://down-th.img.susercontent.com/file/th-11134207-7r992-lqllrik8vb384b');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '1234', 'admin', '2026-09-11 04:46:48'),
(2, 'cm', '4321', 'user', '2026-09-11 04:46:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`products_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `products_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
