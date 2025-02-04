-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 03, 2025 at 07:38 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fruit_veg_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('superadmin','admin') DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(3, 'superadmin', '$2y$10$Zx4sZPKlWW8fLYFqurNscOm5U5HudZFnpdj9ZQc39HcLDoDzV8ydq', 'abdulmajeedsualihu2000@gmail.com', 'superadmin', '2025-02-02 15:46:12'),
(5, 'cant', '$2y$10$0.noYRggyXYJ0qdx/UNuQuJ0A7GwP7da.xVrgJ/z4K.BgitWtjR7C', 'abdulmajeed@gmail.com', 'admin', '2025-02-03 06:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

DROP TABLE IF EXISTS `admin_logs`;
CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `action`, `timestamp`, `ip_address`) VALUES
(1, 9, 'Logged in', '2025-02-02 14:21:29', '::1'),
(2, 9, 'Logged in', '2025-02-02 14:22:53', '::1'),
(3, 9, 'Logged in', '2025-02-02 14:23:35', '::1'),
(4, 9, 'Logged in', '2025-02-02 14:24:03', '::1'),
(5, 9, 'Logged in', '2025-02-02 14:25:46', '::1'),
(6, 6, 'Logged in', '2025-02-02 15:07:51', '::1'),
(7, 6, 'Logged in', '2025-02-02 15:15:31', '::1'),
(8, 9, 'Logged in', '2025-02-02 15:20:46', '::1'),
(9, 3, 'Logged in', '2025-02-02 17:19:30', '::1'),
(10, 3, 'Logged in', '2025-02-02 22:05:26', '::1'),
(11, 3, 'Logged in', '2025-02-02 22:08:25', '::1'),
(12, 3, 'Logged in', '2025-02-02 22:09:49', '::1'),
(13, 3, 'Logged in', '2025-02-02 22:09:57', '::1'),
(14, 3, 'Logged in', '2025-02-02 22:12:12', '::1'),
(15, 3, 'Logged in', '2025-02-02 22:12:38', '::1'),
(16, 3, 'Logged in', '2025-02-03 06:14:57', '::1'),
(17, 3, 'Logged in', '2025-02-03 06:26:54', '::1'),
(18, 3, 'Logged in', '2025-02-03 06:28:55', '::1'),
(19, 3, 'Logged in', '2025-02-03 06:34:45', '::1'),
(20, 3, 'Logged in', '2025-02-03 06:36:44', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_on`) VALUES
(27, 11, 1, 69, '2025-02-02 08:37:43'),
(28, 11, 2, 17, '2025-02-02 08:56:08'),
(33, 9, 1, 1, '2025-02-02 13:32:33'),
(36, 0, 1, 1, '2025-02-03 06:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', '123-456-7890', '123 Main St, Springfield', '2025-01-30 21:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 5, 'Cantell', 'abdulmajeedsualihu2000@gmail.com', 'dasde', '2025-01-31 08:26:20'),
(2, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'uhuhj', '2025-02-01 17:38:00'),
(3, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'Hey, Thank you soo much', '2025-02-02 07:58:54'),
(4, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'Hey King ', '2025-02-02 08:00:07'),
(5, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'Hey, Thank you soo much', '2025-02-02 08:00:24'),
(6, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'I love you all', '2025-02-02 08:00:45'),
(7, 11, 'cantellkawai', 'abdulmajeedsualihu2000@gmail.com', 'Hey Jeed', '2025-02-02 08:03:49'),
(8, 9, 'Chris Amoako', 'abdulmajeedsualihu2000@gmail.com', 'Thank you for your service\r\n', '2025-02-02 11:16:10'),
(9, 9, 'Chris Amoako', 'abdulmajeedsualihu2000@gmail.com', 'My goods have arrived\r\n', '2025-02-02 11:17:06'),
(10, 5, 'Cantell', 'abdulmajeedsualihu2000@gmail.com', 'As a busy working man, this fruit and vegetable delivery site has been a lifesaver. It\'s so easy to order wholesome and fresh products for my family, and it frees up time that I can spend with my loved ones. I can\'t thank this site enough for making my life easier! ', '2025-02-03 07:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int DEFAULT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `order_number` varchar(50) NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expected_delivery` date DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `address`, `payment_method`, `status`, `order_number`, `order_date`, `created_at`, `expected_delivery`) VALUES
(1, 7, 1.50, 'Kumasi-Ashanti', 'Mobile Money', 'Pending', '', '2025-01-31 11:12:38', '2025-01-31 11:17:12', NULL),
(2, 7, 4.35, 'ssa', 'Cash on Delivery', 'Pending', 'ORD-679CB4632EAE5', '2025-01-31 11:30:43', '2025-01-31 11:30:43', '2025-02-07'),
(3, 7, 1.80, '21', 'Mobile Money', 'Delivered', 'ORD-679CB4BDEC39E', '2025-01-31 11:32:13', '2025-01-31 11:32:13', '2025-02-07'),
(4, 7, 0.75, 'ere', 'Cash on Delivery', 'Shipped', 'ORD-679CB741444D8', '2025-01-31 11:42:57', '2025-01-31 11:42:57', '2025-02-07'),
(5, 6, 4.25, 'Kumawu', 'Cash on Delivery', 'Pending', 'ORD-679CE1F10F943', '2025-01-31 14:45:05', '2025-01-31 14:45:05', '2025-02-07'),
(6, 6, 6.00, 'Tamale', 'Credit Card', 'Pending', 'ORD-679CE3C283432', '2025-01-31 14:52:50', '2025-01-31 14:52:50', '2025-02-07'),
(7, 6, 4.25, 'Sekyere', 'Mobile Money', 'Cancelled', 'ORD-679CE4591A547', '2025-01-31 14:55:21', '2025-01-31 14:55:21', '2025-02-07'),
(8, 8, 2.00, '344', 'Cash on Delivery', 'Pending', 'ORD-679CF774D0CF9', '2025-01-31 16:16:52', '2025-01-31 16:16:52', '2025-02-07'),
(9, 8, 24.15, 'Kumasi', 'Cash on Delivery', 'Pending', 'ORD-679CFCA9B040B', '2025-01-31 16:39:05', '2025-01-31 16:39:05', '2025-02-07'),
(10, 6, 51.00, 'Ghana', 'Credit Card', 'Pending', 'ORD-679E4B43ED391', '2025-02-01 16:26:43', '2025-02-01 16:26:43', '2025-02-08'),
(11, 9, 76.50, 'Amoako Junction', 'Cash on Delivery', 'Cancelled', 'ORD-679E507163EEB', '2025-02-01 16:48:49', '2025-02-01 16:48:49', '2025-02-08'),
(12, 10, 22.50, 'KsTU gate 3', 'Cash on Delivery', 'Shipped', 'ORD-679E5311EF020', '2025-02-01 17:00:01', '2025-02-01 17:00:01', '2025-02-08'),
(13, 9, 18.00, 'Kumawu', 'Cash on Delivery', 'Cancelled', 'ORD-679F56D3AD9B5', '2025-02-02 11:28:19', '2025-02-02 11:28:19', '2025-02-09'),
(14, 9, 1.80, 'finTech', 'Cash on Delivery', 'Shipped', 'ORD-679F584B64103', '2025-02-02 11:34:35', '2025-02-02 11:34:35', '2025-02-09'),
(15, 5, 9.75, 'Kmawu', 'Cash on Delivery', 'Cancelled', 'ORD-67A061EA7A748', '2025-02-03 06:27:54', '2025-02-03 06:27:54', '2025-02-10');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 3, 2, 5.00),
(2, 1, 5, 1, 15.50),
(3, 1, 3, 2, 5.00),
(4, 1, 5, 1, 15.50),
(5, 1, 1, 1, 0.00),
(6, 0, 2, 1, 0.00),
(7, 2, 4, 2, 0.00),
(8, 2, 2, 1, 0.00),
(9, 3, 4, 1, 0.00),
(10, 4, 2, 1, 0.00),
(11, 5, 2, 1, 0.00),
(12, 5, 1, 1, 0.00),
(13, 5, 3, 1, 0.00),
(14, 6, 2, 8, 0.00),
(15, 7, 3, 1, 0.00),
(16, 7, 1, 1, 0.00),
(17, 7, 2, 1, 0.00),
(18, 8, 3, 1, 0.00),
(19, 9, 4, 13, 0.00),
(20, 9, 2, 1, 0.00),
(21, 10, 2, 68, 0.00),
(22, 11, 3, 21, 0.00),
(23, 11, 1, 23, 0.00),
(24, 12, 1, 15, 0.00),
(25, 13, 4, 10, 0.00),
(26, 14, 4, 1, 0.00),
(27, 15, 2, 13, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` enum('Fruit','Vegetable') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `created_at`) VALUES
(1, 'Apple', 'Fruit', 1.50, 'apple.jpg', '2025-01-30 17:05:21'),
(2, 'Banana', 'Fruit', 0.75, 'banana.jpg', '2025-01-30 17:05:21'),
(3, 'Carrot', 'Vegetable', 2.00, 'carrot.jpg', '2025-01-30 17:05:21'),
(4, 'Tomato', 'Vegetable', 1.80, 'tomato.jpg', '2025-01-30 17:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `value`) VALUES
(1, 'website_title', 'Fruit & Veg Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `address` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `created_at`, `address`) VALUES
(1, 'John Doe', 'john@example.com', '$2y$10$abcdefghijklm...', 'customer', '2025-01-30 17:05:19', ''),
(2, 'Jane Smith', 'jane@example.com', '$2y$10$mnopqrstuvwx...', 'customer', '2025-01-30 17:05:19', ''),
(20, 'Abdulmajeed Sualihu', 'cantellkawai@gma.com', '$2y$10$ngmI.9p2Aad//wmQfqtJD.eemqqQz7oMOqxdLrRogkvYb3z68I.qK', 'customer', '2025-02-02 17:09:25', ''),
(4, 'Ye Feng', 'admin_jeed@gmail.com', '$2y$10$OvATr1Jvyc8./erFJcZM4.F9q36FnXmj7G45UW7j0FjgbNWx5ov2a', 'customer', '2025-01-30 20:49:20', ''),
(5, 'Cantell', 'cantellkawai@gmail.com', '$2y$10$OrrgDq2iM2LI9DI5QOS2SeZiShi4BzJIT4U.pt7os.evLVloPOLC2', 'customer', '2025-01-30 22:13:12', ''),
(6, 'Ye Feng', 'cantell@gmail.com', '$2y$10$gQJLD0E1YKP.lQCFMQSDieesK77H1oaTpg3hRvehA0AYKtKH6KR22', 'customer', '2025-01-31 09:39:44', ''),
(11, 'cantellkawai', 'christian@gmail.com', '$2y$10$s81M2AUPBFYbHK9E/LjoQu2rhnKf3oAz3/tlGnPs2ShonNnGOo1Bm', 'customer', '2025-02-01 17:23:51', ''),
(8, 'cantell', 'cant@gmail.com', '$2y$10$9OKlhnWRpIA/xBfh/jr4JORkz62HsTWbO5KxNiF3ijIq/apB5nPda', 'customer', '2025-01-31 14:56:05', 'Effiduase-kumawu road'),
(9, 'Chris Amoako', 'christianamoakorighteous@gmail.com', '$2y$10$NL4cpmIYXODdu5mPJ0.gZe4GLHDCBeQpUGgIZ/FIQsQVgocPzmbQq', 'customer', '2025-02-01 16:47:07', '002,Abu Dhabi\r\n003'),
(10, 'Sadeeq Musah', 'sadeeq@gmail.com', '$2y$10$WnsAd6mde/P7CTq42ZCmFuVYJfh1UP6LiM06Szc/Z/J26X8wWu98.', 'customer', '2025-02-01 16:56:44', '002,Abu Dhabi\r\n003'),
(21, 'abdulmajeedsualihu', 'cantell@mail.com', '$2y$10$4Y4vkX01UUFylNUbyG2LoOk5/LOWMWr2XhizfNIZOwDgbQn3BSStu', 'customer', '2025-02-02 22:04:57', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE IF NOT EXISTS `user_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `action`, `timestamp`, `ip_address`) VALUES
(1, 1, 'Logged In', '2025-02-02 13:34:36', '::1'),
(2, 1, 'Logged In', '2025-02-02 13:34:36', '::1'),
(3, 0, 'Logged In', '2025-02-02 13:40:42', '::1'),
(4, 1, 'Logged in', '2025-02-02 13:50:41', '::1'),
(5, 1, 'Logged in', '2025-02-02 13:52:21', '::1'),
(6, 1, 'Logged in', '2025-02-02 13:53:42', '::1'),
(7, 9, 'Logged in', '2025-02-02 13:58:52', '::1'),
(8, 9, 'Logged in', '2025-02-02 13:59:29', '::1'),
(9, 9, 'Logged in', '2025-02-02 14:01:22', '::1'),
(10, 9, 'Logged in', '2025-02-02 14:01:26', '::1'),
(11, 9, 'Logged in', '2025-02-02 14:01:38', '::1'),
(12, 9, 'Logged in', '2025-02-02 14:02:42', '::1'),
(13, 9, 'Logged in', '2025-02-02 14:02:46', '::1'),
(14, 9, 'Logged in', '2025-02-02 14:03:06', '::1'),
(15, 9, 'Logged in', '2025-02-02 14:05:00', '::1'),
(16, 9, 'Logged in', '2025-02-02 14:05:00', '::1'),
(17, 9, 'Logged in', '2025-02-02 14:05:08', '::1'),
(18, 9, 'Logged in', '2025-02-02 14:09:21', '::1'),
(19, 9, 'Logged in', '2025-02-02 14:18:38', '::1'),
(20, 6, 'Logged in', '2025-02-02 15:03:14', '::1'),
(21, 6, 'Logged in', '2025-02-02 15:04:37', '::1'),
(22, 6, 'Logged in', '2025-02-02 15:04:42', '::1'),
(23, 6, 'Logged in', '2025-02-02 15:05:03', '::1'),
(24, 6, 'Logged in', '2025-02-02 15:05:22', '::1'),
(25, 6, 'Logged in', '2025-02-02 15:05:50', '::1'),
(26, 9, 'Logged in', '2025-02-02 15:06:06', '::1'),
(27, 9, 'Logged in', '2025-02-02 15:18:52', '::1'),
(28, 9, 'Logged in', '2025-02-02 15:19:21', '::1'),
(29, 5, 'Logged in', '2025-02-02 16:19:55', '::1'),
(30, 5, 'Logged in', '2025-02-02 16:20:55', '::1'),
(31, 5, 'Logged in', '2025-02-02 16:22:01', '::1'),
(32, 5, 'Logged in', '2025-02-02 16:23:17', '::1'),
(33, 5, 'Logged in', '2025-02-02 16:25:04', '::1'),
(34, 5, 'Logged in', '2025-02-02 16:25:33', '::1'),
(35, 5, 'Logged in', '2025-02-02 16:26:08', '::1'),
(36, 5, 'Logged in', '2025-02-02 16:32:28', '::1'),
(37, 5, 'Logged in', '2025-02-02 16:37:02', '::1'),
(38, 5, 'Logged in', '2025-02-02 16:37:18', '::1'),
(39, 5, 'Logged in', '2025-02-02 16:38:36', '::1'),
(40, 5, 'Logged in', '2025-02-02 16:39:00', '::1'),
(41, 5, 'Logged in', '2025-02-02 16:39:21', '::1'),
(42, 5, 'Logged in', '2025-02-02 16:39:42', '::1'),
(43, 5, 'Logged in', '2025-02-02 16:40:54', '::1'),
(44, 5, 'Logged in', '2025-02-02 16:42:27', '::1'),
(45, 5, 'Logged in', '2025-02-02 16:42:54', '::1'),
(46, 5, 'Logged in', '2025-02-02 16:43:24', '::1'),
(47, 5, 'Logged in', '2025-02-02 16:43:29', '::1'),
(48, 5, 'Logged in', '2025-02-02 16:44:05', '::1'),
(49, 5, 'Logged in', '2025-02-02 16:44:26', '::1'),
(50, 5, 'Logged in', '2025-02-02 16:44:49', '::1'),
(51, 5, 'Logged in', '2025-02-02 16:45:05', '::1'),
(52, 5, 'Logged in', '2025-02-02 16:46:19', '::1'),
(53, 5, 'Logged in', '2025-02-02 16:46:59', '::1'),
(54, 5, 'Logged in', '2025-02-02 16:47:31', '::1'),
(55, 5, 'Logged in', '2025-02-02 16:47:58', '::1'),
(56, 5, 'Logged in', '2025-02-02 16:53:16', '::1'),
(57, 5, 'Logged in', '2025-02-02 16:53:40', '::1'),
(58, 5, 'Logged in', '2025-02-02 16:53:53', '::1'),
(59, 5, 'Logged in', '2025-02-02 17:08:59', '::1'),
(60, 5, 'Logged in', '2025-02-02 17:09:07', '::1'),
(61, 20, 'Logged in', '2025-02-02 17:09:25', '::1'),
(62, 20, 'Logged in', '2025-02-02 17:09:45', '::1'),
(63, 20, 'Logged in', '2025-02-02 17:13:19', '::1'),
(64, 20, 'Logged in', '2025-02-02 17:14:31', '::1'),
(65, 20, 'Logged in', '2025-02-02 17:26:23', '::1'),
(66, 20, 'Logged in', '2025-02-02 22:02:31', '::1'),
(67, 20, 'Logged in', '2025-02-02 22:03:03', '::1'),
(68, 6, 'Logged in', '2025-02-02 22:03:18', '::1'),
(69, 21, 'Logged in', '2025-02-02 22:04:57', '::1'),
(70, 5, 'Logged in', '2025-02-02 22:14:05', '::1'),
(71, 5, 'Logged in', '2025-02-03 05:36:52', '::1'),
(72, 5, 'Logged in', '2025-02-03 06:09:08', '::1'),
(73, 5, 'Logged in', '2025-02-03 06:09:29', '::1'),
(74, 5, 'Logged in', '2025-02-03 06:27:19', '::1'),
(75, 5, 'Logged in', '2025-02-03 06:27:36', '::1'),
(76, 5, 'Logged in', '2025-02-03 06:27:41', '::1'),
(77, 5, 'Logged in', '2025-02-03 06:34:50', '::1'),
(78, 5, 'Logged in', '2025-02-03 06:36:35', '::1'),
(79, 5, 'Logged in', '2025-02-03 07:26:14', '::1'),
(80, 5, 'Logged in', '2025-02-03 07:26:25', '::1'),
(81, 5, 'Logged in', '2025-02-03 07:26:39', '::1'),
(82, 5, 'Logged in', '2025-02-03 07:27:07', '::1'),
(83, 5, 'Logged in', '2025-02-03 07:27:09', '::1'),
(84, 5, 'Logged in', '2025-02-03 07:27:10', '::1'),
(85, 5, 'Logged in', '2025-02-03 07:27:10', '::1'),
(86, 5, 'Logged in', '2025-02-03 07:28:24', '::1'),
(87, 5, 'Logged in', '2025-02-03 07:28:27', '::1'),
(88, 5, 'Logged in', '2025-02-03 07:28:33', '::1'),
(89, 5, 'Logged in', '2025-02-03 07:28:59', '::1'),
(90, 5, 'Logged in', '2025-02-03 07:29:51', '::1'),
(91, 5, 'Logged in', '2025-02-03 07:36:25', '::1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
