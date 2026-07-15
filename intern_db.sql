-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 08, 2026 at 03:06 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intern_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'Starters'),
(2, 'Main Course'),
(3, 'Desserts'),
(4, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `item_name`, `category_id`, `price`) VALUES
(1, 'Soup', 1, 120.00),
(2, 'Pizza', 2, 350.00),
(3, 'Ice Cream', 3, 100.00),
(4, 'Coke', 4, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` int NOT NULL,
  `menu_id` int NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('Pending','Preparing','Prepared','Served','Order Closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_status` enum('Unpaid','Paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `table_number`, `menu_id`, `quantity`, `status`, `payment_status`, `created_at`) VALUES
(1, 'Jane', 1, 1, 3, 'Preparing', 'Unpaid', '2026-07-07 05:17:33'),
(2, 'Allie', 2, 2, 2, 'Preparing', 'Unpaid', '2026-07-07 05:17:33'),
(4, '', 4, 3, 2, '', 'Paid', '2026-07-07 05:17:33'),
(5, '', 3, 4, 4, 'Order Closed', 'Paid', '2026-07-07 05:17:33'),
(6, '', 1, 1, 6, 'Pending', 'Unpaid', '2026-07-07 05:17:33'),
(7, '', 5, 3, 5, '', 'Paid', '2026-07-07 05:17:33'),
(8, '', 5, 3, 11, 'Order Closed', 'Paid', '2026-07-07 05:17:33'),
(9, '', 4, 1, 7, 'Order Closed', 'Paid', '2026-07-07 05:24:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'Chef'),
(4, 'Waiter'),
(5, 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Alice', 'alice10@gmail.com', '$2y$10$KuJopQ0ZoVcublAJOQINaO6y4FlfuRlKE3fxazAIPdGK8Z8HrRyPK', 'Chef'),
(2, 'Kat Gilbert', 'kat006@gmail.com', 'mystic123', 'Waiter'),
(3, 'Elena Forbes', 'elena411@gmail.com', '$2y$10$jZ6w7vst9XKh3kypBgOCoO3CV.Arq1kA7Jw3bD4pLLYnUyWuwfXPy', 'Cashier'),
(5, 'Stef', 'stef004@gmail.com', '$2y$10$ecHle64481H9IRnHCkJpg.kR0O3kRhvzQpCrn58cNjkcqXq5vFLyG', 'Manager'),
(6, 'Jenna', 'email657@yahoo.com', '$2y$10$.RUMyZk9J8MUBN3903EpTOutz.LI7pGERQXNiFXVkP8DUTGi8Rn2S', 'admin'),
(10, 'Ben', 'ben@gmail.com', '$2y$10$jJoQg0P7Bh4l5yfB2/NPx.SvPZK2nuFXTPRw5/cJ0hIvh7S9pxenm', 'Waiter'),
(8, 'John', 'jon1234@gmail.com', '$2y$10$nSi3bUqUPFgnQ/r1..SNyOJJfGSEmsubgKh9N271ewt5tNB2o8FWG', 'Chef'),
(9, 'Sam', 'sam123@gmail.com', '$2y$10$LOFTJW0kWB6AEhTI5WeiLuQEPwrwyHlfVJMdkMD5MwQzkiFNe9eka', 'Manager'),
(7, 'Ariel', 'ariel@example.com', 'a123', 'Waiter');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
