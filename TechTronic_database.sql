-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 12, 2023 at 03:32 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TechTronic_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `zip` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `street` char(80) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` char(12) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `state_id`, `city`, `zip`, `street`, `phone_number`) VALUES
(1, 5, 'Los Angeles', '91765', '4844 Roosevelt Wilson Lane', '909-860-3329'),
(2, 9, 'Miami', '33601', '1042 Eastland Avenue', '813-379-7482'),
(4, 5, 'Richmond', '94801', '1322 Wayside Lane', '510-235-8681'),
(5, 9, 'Jacksonville', '32547', '1827 Pointed Leaf Ln', '850-200-4037'),
(17, 32, 'Bronx', '10463', '274 Upper Depew Ave', '718-953-0143'),
(18, 5, 'Richmond', '94801', '1311 Wayside Lane', '510-235-8681'),
(26, 9, 'Miami', '33601', '1042 Eastland Avenue', '813-379-7482'),
(27, 5, 'Richmond', '94801', '1322 Wayside Lane', '510-235-8681'),
(28, 5, 'Richmond', '94801', '1322 Wayside Lane', '510-235-8681'),
(29, 5, 'Richmond', '94801', '1322 Wayside Lane', '510-235-8681'),
(30, 49, 'Appleton', '54913', '1953 Rockford Mountain Lane', '920-810-7627'),
(31, 49, 'Appleton', '54913', '1953 Rockford Mountain Lane', '920-810-7627');

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `admin_id` int(11) NOT NULL,
  `login` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` char(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`admin_id`, `login`, `password_hash`) VALUES
(1, 'tt-admin', '$2y$12$/7uBO7kmHXUFiyXDIJUUv.mldV0Pb10oPMITZDzQDu12a83Fq4AhC');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cv_id` int(11) NOT NULL,
  `amount` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_item_id`, `user_id`, `cv_id`, `amount`) VALUES
(75, 1, 6, 1),
(76, 1, 91, 1),
(77, 1, 96, 1),
(78, 1, 117, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image_path` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `feature_1_name` int(11) NOT NULL,
  `feature_2_name` int(11) NOT NULL,
  `feature_3_name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image_path`, `feature_1_name`, `feature_2_name`, `feature_3_name`) VALUES
(1, 'Smartphones', '1.jpg', 3, 4, 5),
(2, 'Laptops', '2.jpg', 3, 4, 5),
(3, 'Smartwatches', '3.jpg', 3, 1, 6),
(4, 'Wireless earbuds', '4.jpg', 7, 15, 6),
(11, 'Tablets', '11.jpg', 3, 4, 5),
(17, 'Monitors', '17.jpg', 3, 14, 22);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`color_id`, `color_name`) VALUES
(1, 'Silver'),
(2, 'Space Grey'),
(3, 'Gold'),
(4, 'White'),
(5, 'Phantom Black'),
(6, 'Phantom Violet'),
(7, 'Black'),
(8, 'Midnight'),
(9, 'Phantom Silver'),
(10, 'Sierra Blue'),
(12, 'Phantom Pink'),
(14, 'Alpine Green'),
(15, 'Blue'),
(16, 'Red'),
(17, 'Starlight'),
(18, 'Graphite'),
(19, 'Pink Gold'),
(20, 'Awesome Blue'),
(21, 'Awesome Black'),
(22, 'Awesome Peach'),
(23, 'Green'),
(24, 'Burgundy'),
(25, 'Phantom White'),
(26, 'Olive'),
(27, 'Violet'),
(28, 'Starlight / Nike Band'),
(29, 'Gold / Dark Cherry'),
(30, 'Silver Steel'),
(31, 'Sequoia Green'),
(32, 'Pink Gold / Silver'),
(33, 'Silver / Camel'),
(34, 'Black / Navy'),
(35, 'Silver / Tide Green'),
(36, 'White/Black'),
(37, 'Silver / Navy'),
(38, 'Black / Tide Blue'),
(39, 'Black / Camel'),
(40, 'Purple'),
(41, 'Gray'),
(42, 'Platinum Silver'),
(43, 'Arctic White'),
(44, 'Phantom Green'),
(45, 'Lavender'),
(46, 'Cream');

-- --------------------------------------------------------

--
-- Table structure for table `color_versions`
--

CREATE TABLE `color_versions` (
  `cv_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `price` decimal(7,2) UNSIGNED NOT NULL,
  `discount_price` decimal(7,2) UNSIGNED DEFAULT NULL,
  `main_image_id` int(11) DEFAULT NULL,
  `amount` smallint(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `color_versions`
--

INSERT INTO `color_versions` (`cv_id`, `product_id`, `color_id`, `price`, `discount_price`, `main_image_id`, `amount`) VALUES
(1, 1, 5, '1099.00', '999.00', 1, 5),
(2, 1, 9, '1099.00', '979.00', 24, 0),
(3, 3, 6, '799.00', NULL, 7, 8),
(4, 3, 5, '799.00', NULL, 8, 17),
(5, 2, 2, '2499.00', NULL, 203, 3),
(6, 2, 1, '2449.00', NULL, 198, 9),
(7, 4, 7, '379.99', '359.00', 10, 5),
(8, 4, 1, '379.99', '344.99', 16, 9),
(9, 5, 8, '429.00', '399.00', 22, 17),
(10, 6, 5, '849.00', NULL, 165, 3),
(11, 8, 10, '999.00', NULL, 31, 6),
(15, 3, 9, '799.00', NULL, 50, 7),
(17, 12, 12, '649.00', NULL, 56, 6),
(26, 13, 3, '1099.00', NULL, 62, 16),
(27, 13, 14, '1099.00', NULL, 66, 10),
(28, 14, 15, '699.00', NULL, 71, 21),
(29, 14, 8, '699.00', NULL, 77, 0),
(30, 14, 16, '699.00', NULL, 81, 16),
(31, 15, 17, '759.00', NULL, 85, 13),
(32, 15, 23, '799.00', NULL, 89, 4),
(34, 16, 15, '499.00', NULL, 95, 41),
(35, 16, 4, '499.00', NULL, 98, 36),
(36, 17, 8, '429.00', NULL, 101, 20),
(37, 17, 17, '429.00', NULL, 105, 20),
(50, 20, 18, '1099.00', NULL, 114, 7),
(51, 21, 18, '699.00', NULL, 126, 23),
(52, 21, 19, '699.00', NULL, 120, 16),
(53, 22, 1, '899.00', NULL, 132, 10),
(54, 23, 20, '598.00', NULL, 172, 30),
(55, 23, 21, '598.00', NULL, 183, 28),
(56, 23, 22, '598.00', NULL, 176, 30),
(57, 5, 23, '429.00', NULL, 189, 19),
(58, 5, 16, '429.00', NULL, 193, 16),
(59, 31, 1, '1999.00', '1949.00', 208, 17),
(60, 31, 2, '1999.00', NULL, 213, 14),
(61, 33, 1, '2599.00', NULL, 218, 22),
(62, 33, 2, '2599.00', NULL, 223, 20),
(63, 34, 2, '5899.00', NULL, 228, 3),
(64, 35, 1, '3499.00', NULL, 234, 12),
(65, 36, 2, '6099.00', NULL, 240, 5),
(66, 37, 2, '1299.00', NULL, 244, 17),
(67, 38, 1, '1199.00', '1099.99', 248, 10),
(68, 39, 24, '1199.00', NULL, 251, 18),
(69, 39, 5, '1199.00', NULL, 263, 22),
(70, 39, 23, '1199.00', NULL, 257, 19),
(71, 40, 5, '1399.00', NULL, 269, 14),
(72, 40, 23, '1399.00', NULL, 275, 11),
(73, 40, 24, '1429.00', NULL, 281, 7),
(74, 41, 19, '799.00', NULL, 287, 34),
(75, 41, 23, '799.00', NULL, 292, 31),
(76, 41, 25, '749.00', NULL, 297, 38),
(77, 42, 5, '999.00', NULL, 302, 24),
(78, 42, 23, '999.00', NULL, 307, 28),
(82, 44, 18, '149.00', '129.00', 313, 57),
(83, 44, 26, '149.00', NULL, 318, 68),
(84, 44, 27, '149.00', '129.00', 323, 45),
(85, 45, 1, '199.00', '149.00', 328, 24),
(86, 45, 27, '199.00', '149.00', 333, 19),
(87, 46, 4, '249.00', NULL, 338, 27),
(88, 47, 4, '179.00', NULL, 342, 56),
(89, 5, 28, '499.00', NULL, 347, 8),
(90, 48, 28, '599.00', NULL, 350, 10),
(91, 48, 29, '599.00', NULL, 351, 7),
(92, 48, 30, '899.00', NULL, 353, 16),
(93, 49, 8, '399.00', '349.00', 355, 32),
(94, 49, 31, '799.00', NULL, 357, 9),
(95, 50, 32, '249.00', '209.00', 365, 24),
(96, 50, 33, '249.00', '229.00', 366, 21),
(97, 51, 34, '299.00', NULL, 368, 13),
(98, 51, 1, '299.00', '239.00', 370, 30),
(99, 52, 23, '279.99', '239.99', 375, 43),
(100, 52, 35, '279.00', NULL, 380, 23),
(101, 52, 36, '279.00', NULL, 383, 29),
(102, 51, 33, '299.00', NULL, 385, 14),
(103, 53, 35, '329.00', NULL, 387, 16),
(104, 53, 23, '329.00', '289.00', 389, 58),
(105, 53, 37, '329.00', '299.00', 394, 11),
(106, 54, 1, '349.99', '309.99', 396, 31),
(107, 54, 38, '349.99', NULL, 401, 16),
(108, 55, 1, '399.99', '369.90', 403, 6),
(109, 4, 39, '379.99', NULL, 408, 14),
(110, 56, 39, '429.00', NULL, 410, 13),
(111, 56, 1, '429.00', '399.00', 412, 20),
(112, 57, 40, '749.00', NULL, 427, 80),
(113, 57, 15, '749.00', NULL, 432, 60),
(114, 57, 41, '749.00', NULL, 422, 93),
(115, 58, 41, '799.00', NULL, 437, 45),
(116, 58, 15, '799.00', NULL, 442, 50),
(117, 59, 41, '999.00', NULL, 447, 40),
(118, 59, 40, '999.00', NULL, 452, 50),
(119, 60, 1, '249.00', NULL, 457, 75),
(120, 61, 7, '199.00', NULL, 460, 90),
(121, 61, 15, '199.00', NULL, 464, 70),
(122, 62, 42, '1369.99', NULL, 468, 24),
(123, 63, 42, '1669.99', NULL, 474, 29),
(124, 63, 43, '1669.99', '1599.99', 481, 22),
(125, 64, 42, '2844.00', NULL, 483, 8),
(126, 65, 2, '1099.00', NULL, 490, 24),
(129, 65, 1, '1099.00', NULL, 493, 28),
(130, 66, 2, '1599.00', '1499.00', 496, 12),
(131, 67, 2, '799.00', NULL, 499, 48),
(132, 67, 1, '799.00', NULL, 502, 50),
(133, 68, 1, '1099.00', '999.00', 505, 33),
(134, 69, 1, '1599.00', NULL, 521, 35),
(135, 70, 5, '1799.00', NULL, 526, 47),
(136, 70, 44, '1799.00', '1699.00', 532, 58),
(137, 70, 9, '1799.00', NULL, 543, 50),
(138, 71, 5, '999.00', '929.00', 567, 35),
(139, 71, 23, '999.00', NULL, 555, 42),
(140, 71, 45, '999.00', NULL, 561, 40),
(142, 71, 46, '999.00', NULL, 549, 45),
(143, 72, 7, '2099.00', NULL, 573, 4),
(144, 73, 7, '599.00', NULL, 579, 23),
(145, 74, 1, '4999.00', NULL, 584, 2),
(146, 75, 7, '429.00', '399.00', 586, 62);

-- --------------------------------------------------------

--
-- Table structure for table `ordered_products`
--

CREATE TABLE `ordered_products` (
  `op_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `cv_id` int(11) DEFAULT NULL,
  `ordered_amount` smallint(6) UNSIGNED NOT NULL,
  `value` decimal(7,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ordered_products`
--

INSERT INTO `ordered_products` (`op_id`, `order_id`, `cv_id`, `ordered_amount`, `value`) VALUES
(1, 1, 11, 1, '999.00'),
(2, 1, 6, 1, '4099.00'),
(3, 1, 9, 2, '399.00'),
(4, 2, 8, 1, '364.99'),
(6, 4, 7, 1, '379.99'),
(7, 4, 2, 1, '1199.00'),
(8, 5, 64, 1, '3499.00'),
(9, 5, 1, 1, '1099.00'),
(14, 8, 67, 1, '1099.99'),
(15, 8, 53, 1, '899.00'),
(18, 10, 76, 1, '749.00'),
(19, 10, 57, 2, '429.00'),
(20, 10, 27, 1, '1099.00'),
(21, 10, 70, 1, '1199.00'),
(22, 10, 5, 1, '2499.00'),
(23, 10, 61, 1, '2599.00'),
(24, 10, 50, 2, '1099.00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(201) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_order` datetime NOT NULL,
  `delivery_type` tinyint(4) NOT NULL,
  `deliver_to_address` int(11) DEFAULT NULL,
  `deliver_to_shop` int(11) DEFAULT NULL,
  `payment_type` tinyint(4) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `order_price` decimal(12,2) UNSIGNED NOT NULL,
  `is_paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `customer_name`, `date_of_order`, `delivery_type`, `deliver_to_address`, `deliver_to_shop`, `payment_type`, `order_status`, `order_price`, `is_paid`) VALUES
(1, NULL, 'Adam Mąka', '2021-11-14 12:12:36', 4, NULL, 2, 2, 4, '5896.00', 1),
(2, 1, 'John Smith', '2021-11-14 12:19:45', 2, 18, NULL, 3, 4, '377.98', 0),
(4, 1, 'John Smith', '2022-03-16 13:03:12', 4, NULL, 1, 3, 3, '1578.99', 0),
(5, NULL, 'Adam Mąka', '2022-03-27 21:03:20', 2, 26, NULL, 2, 3, '4598.00', 1),
(8, 1, 'John Smith', '2022-03-27 21:13:54', 3, 28, NULL, 1, 2, '1998.99', 1),
(10, 13, 'Martin J Lee', '2022-04-21 18:46:59', 1, 31, NULL, 2, 1, '11225.99', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery`
--

CREATE TABLE `order_delivery` (
  `delivery_id` tinyint(4) NOT NULL,
  `delivery_name` char(25) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_description` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_cost` decimal(6,2) NOT NULL,
  `min_order_value` decimal(5,2) NOT NULL,
  `icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_delivery`
--

INSERT INTO `order_delivery` (`delivery_id`, `delivery_name`, `delivery_description`, `delivery_cost`, `min_order_value`, `icon`) VALUES
(1, 'Express courier', 'Your order at your place tomorrow', '24.99', '-1.00', 'fast-truck.png'),
(2, 'Courier delivery', 'UPS, FedEx or DHL', '12.99', '999.00', 'truck.svg'),
(3, 'Postal delivery', 'United States Postal Service', '9.99', '599.00', 'postal-icon.png'),
(4, 'Delivery to the store', 'Receive the package in our store', '0.00', '0.00', 'store-icon.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment`
--

CREATE TABLE `order_payment` (
  `payment_id` tinyint(4) NOT NULL,
  `payment_name` char(25) COLLATE utf8_unicode_ci NOT NULL,
  `payment_description` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `icon` char(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_payment`
--

INSERT INTO `order_payment` (`payment_id`, `payment_name`, `payment_description`, `icon`) VALUES
(1, 'Credit/Debit card', 'Visa, Mastercard, American Express', 'credit-card-icon.svg'),
(2, 'PayPal', 'Pay with your PayPal account', 'paypal.svg'),
(3, 'Cash on delivery', 'Payment upon receipt of the order', 'cash-icon.svg');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `status_id` tinyint(4) NOT NULL,
  `status_name` char(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`status_id`, `status_name`) VALUES
(1, 'Pending payment'),
(2, 'Completing and packing'),
(3, 'Shipped'),
(4, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `producers`
--

CREATE TABLE `producers` (
  `producer_id` int(11) NOT NULL,
  `producer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `producers`
--

INSERT INTO `producers` (`producer_id`, `producer_name`) VALUES
(1, 'Samsung'),
(2, 'Apple'),
(3, 'Xiaomi'),
(4, 'Asus'),
(5, 'Acer'),
(6, 'JBL'),
(8, 'HP'),
(11, 'Dell'),
(12, 'Gigabyte');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name_base` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `product_name_version` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `warranty` tinyint(4) DEFAULT NULL,
  `feature_1_val` int(11) NOT NULL,
  `feature_2_val` int(11) NOT NULL,
  `feature_3_val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `producer_id`, `category_id`, `product_name_base`, `product_name_version`, `warranty`, `feature_1_val`, `feature_2_val`, `feature_3_val`) VALUES
(1, 1, 1, 'SAMSUNG Galaxy S21', 'Ultra', 24, 4, 5, 6),
(2, 2, 2, 'APPLE MacBook', 'Pro 16&quot;', 12, 43, 44, 45),
(3, 1, 1, 'SAMSUNG Galaxy S21', '+', 24, 10, 11, 6),
(4, 1, 3, 'SAMSUNG Galaxy Watch 4', 'Classic 46mm', 18, 12, 13, 14),
(5, 2, 3, 'APPLE Watch 7', '45mm', 18, 15, 70, 14),
(6, 1, 1, 'SAMSUNG Galaxy S21', '+', 24, 10, 17, 6),
(8, 2, 1, 'APPLE iPhone 13', 'Pro', 12, 30, 19, 20),
(12, 1, 1, 'SAMSUNG Galaxy S21', '', 24, 28, 11, 6),
(13, 2, 1, 'APPLE iPhone 13', 'Pro Max', 12, 29, 19, 20),
(14, 2, 1, 'APPLE iPhone 13', 'Mini', 12, 31, 32, 20),
(15, 2, 1, 'APPLE iPhone 13', '', 12, 30, 32, 20),
(16, 3, 1, 'XIAOMI 11', 'Lite', 24, 33, 17, 34),
(17, 2, 1, 'APPLE iPhone SE', '2022', 12, 35, 36, 20),
(20, 1, 11, 'SAMSUNG Galaxy Tab S8', 'Ultra', 24, 37, 11, 38),
(21, 1, 11, 'SAMSUNG Galaxy Tab S8', '', 24, 39, 11, 38),
(22, 1, 11, 'SAMSUNG Galaxy Tab S8', '+', 24, 40, 11, 38),
(23, 1, 1, 'SAMSUNG Galaxy A53', '', 24, 41, 19, 42),
(31, 2, 2, 'APPLE MacBook', 'Pro 14&quot;', 12, 46, 44, 45),
(33, 2, 2, 'APPLE MacBook', 'Pro 14&quot;', 12, 46, 47, 45),
(34, 2, 2, 'APPLE MacBook', 'Pro Max 14&quot;', 12, 46, 48, 49),
(35, 2, 2, 'APPLE MacBook', 'Pro 16&quot;', 12, 43, 50, 45),
(36, 2, 2, 'APPLE MacBook', 'Pro Max 16&quot;', 12, 43, 48, 49),
(37, 2, 2, 'APPLE MacBook', 'Pro 13.3&quot;', 12, 7, 17, 9),
(38, 2, 2, 'APPLE MacBook', 'Air 13.3&quot;', 12, 7, 44, 9),
(39, 1, 1, 'SAMSUNG Galaxy S22', 'Ultra', 24, 53, 11, 54),
(40, 1, 1, 'SAMSUNG Galaxy S22', 'Ultra', 24, 53, 55, 54),
(41, 1, 1, 'SAMSUNG Galaxy S22', '', 24, 56, 11, 54),
(42, 1, 1, 'SAMSUNG Galaxy S22', '+', 24, 58, 11, 54),
(44, 1, 4, 'SAMSUNG Galaxy Buds', '2', 24, 60, 61, 62),
(45, 1, 4, 'SAMSUNG Galaxy Buds', 'Pro', 24, 60, 64, 65),
(46, 2, 4, 'APPLE AirPods', 'Pro', 12, 60, 68, 65),
(47, 2, 4, 'APPLE AirPods', 'III', 12, 67, 68, 65),
(48, 2, 3, 'APPLE Watch 7', '45mm LTE', 18, 15, 70, 69),
(49, 2, 3, 'APPLE Watch 7', '41mm', 18, 71, 72, 14),
(50, 1, 3, 'SAMSUNG Galaxy Watch 4', '40mm', 24, 73, 74, 14),
(51, 1, 3, 'SAMSUNG Galaxy Watch 4', '40mm LTE', 24, 73, 74, 69),
(52, 1, 3, 'SAMSUNG Galaxy Watch 4', '44mm', 24, 12, 13, 14),
(53, 1, 3, 'SAMSUNG Galaxy Watch 4', '44mm LTE', 24, 12, 13, 69),
(54, 1, 3, 'SAMSUNG Galaxy Watch 4', 'Classic 42mm', 24, 73, 74, 14),
(55, 1, 3, 'SAMSUNG Galaxy Watch 4', 'Classic 42mm LTE', 24, 73, 74, 14),
(56, 1, 3, 'SAMSUNG Galaxy Watch 4', 'Classic 46mm LTE', 24, 12, 13, 69),
(57, 3, 1, 'XIAOMI 12', '', 24, 76, 11, 77),
(58, 3, 1, 'XIAOMI 12', '', 24, 76, 17, 77),
(59, 3, 1, 'XIAOMI 12', 'Pro', 24, 78, 79, 77),
(60, 3, 3, 'XIAOMI Watch S1', '', 24, 80, 81, 14),
(61, 3, 3, 'XIAOMI Watch S1', 'Active', 24, 80, 81, 14),
(62, 11, 2, 'DELL XPS', '13', 24, 87, 8, 83),
(63, 11, 2, 'DELL XPS', '13', 24, 89, 44, 90),
(64, 11, 2, 'DELL XPS', '15', 24, 93, 94, 95),
(65, 2, 11, 'APPLE iPad', 'Pro 12.9&quot;', 12, 100, 11, 9),
(66, 2, 11, 'APPLE iPad', 'Pro 12.9&quot; 5G', 12, 100, 8, 9),
(67, 2, 11, 'APPLE iPad', 'Pro 11&quot;', 12, 101, 11, 9),
(68, 2, 11, 'APPLE iPad', 'Pro 11&quot; 5G', 12, 101, 17, 9),
(69, 2, 17, 'APPLE Studio Display', '27&quot;', 12, 102, 52, 104),
(70, 1, 1, 'SAMSUNG Galaxy Z Fold 3', '5G', 24, 105, 79, 6),
(71, 1, 1, 'SAMSUNG Galaxy Z Flip 3', '5G', 24, 107, 11, 6),
(72, 1, 17, 'SAMSUNG Odyssey Neo', 'G9', 24, 109, 110, 111),
(73, 1, 17, 'SAMSUNG Odyssey', 'G7', 24, 112, 110, 113),
(74, 2, 17, 'APPLE Pro Display XDR', '6K', 12, 114, 115, 116),
(75, 12, 17, 'GIGABYTE G32', '', 24, 117, 118, 113);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `image_path`, `cv_id`) VALUES
(1, '1_1.jpg', 1),
(2, '1_2.jpg', 1),
(3, '1_3.jpg', 1),
(4, '1_4.jpg', 1),
(5, '1_5.jpg', 1),
(6, '1_6.jpg', 1),
(7, '3_1.jpg', 3),
(8, '4_1.jpg', 4),
(10, '7_1.jpg', 7),
(11, '7_2.jpg', 7),
(12, '7_3.jpg', 7),
(13, '7_4.jpg', 7),
(14, '7_5.jpg', 7),
(15, '7_6.jpg', 7),
(16, '8_1.jpg', 8),
(17, '8_2.jpg', 8),
(18, '8_3.jpg', 8),
(19, '8_4.jpg', 8),
(20, '8_5.jpg', 8),
(21, '8_6.jpg', 8),
(22, '9_1.jpg', 9),
(24, '2_1.jpg', 2),
(25, '2_2.jpg', 2),
(26, '2_3.jpg', 2),
(31, '11_1.jpg', 11),
(35, '9_32.jpg', 9),
(46, '2_44.jpg', 2),
(48, '2_47.jpg', 2),
(49, '2_49.jpg', 2),
(50, '15_50.png', 15),
(51, '15_51.png', 15),
(56, '17_56.jpg', 17),
(57, '17_57.jpg', 17),
(58, '17_58.jpg', 17),
(62, '26_59.jpg', 26),
(63, '26_63.jpg', 26),
(64, '26_64.jpg', 26),
(65, '26_65.jpg', 26),
(66, '27_66.jpg', 27),
(67, '27_67.jpg', 27),
(68, '27_68.jpg', 27),
(69, '27_69.jpg', 27),
(70, '27_70.jpg', 27),
(71, '28_71.jpg', 28),
(72, '28_72.jpg', 28),
(73, '28_73.jpg', 28),
(74, '28_74.jpg', 28),
(77, '29_75.jpg', 29),
(78, '29_78.jpg', 29),
(79, '29_79.jpg', 29),
(80, '29_80.jpg', 29),
(81, '30_81.jpg', 30),
(82, '30_82.jpg', 30),
(83, '30_83.jpg', 30),
(84, '30_84.jpg', 30),
(85, '31_85.jpg', 31),
(86, '31_86.jpg', 31),
(87, '31_87.jpg', 31),
(88, '31_88.jpg', 31),
(89, '32_89.jpg', 32),
(90, '32_90.jpg', 32),
(91, '32_91.jpg', 32),
(92, '32_92.jpg', 32),
(93, '32_93.jpg', 32),
(94, '32_94.jpg', 32),
(95, '34_95.jpg', 34),
(96, '34_96.jpg', 34),
(97, '34_97.jpg', 34),
(98, '35_98.jpg', 35),
(99, '35_99.jpg', 35),
(100, '35_100.jpg', 35),
(101, '36_101.jpg', 36),
(102, '36_102.jpg', 36),
(103, '36_103.jpg', 36),
(104, '36_104.jpg', 36),
(105, '37_105.jpg', 37),
(106, '37_106.jpg', 37),
(107, '37_107.jpg', 37),
(108, '37_108.jpg', 37),
(114, '50_109.jpg', 50),
(115, '50_115.jpg', 50),
(116, '50_116.jpg', 50),
(117, '50_117.jpg', 50),
(118, '50_118.jpg', 50),
(119, '50_119.jpg', 50),
(120, '52_120.jpg', 52),
(121, '52_121.jpg', 52),
(122, '52_122.jpg', 52),
(123, '52_123.jpg', 52),
(124, '52_124.jpg', 52),
(126, '51_126.jpg', 51),
(127, '51_127.jpg', 51),
(128, '51_128.jpg', 51),
(129, '51_129.jpg', 51),
(130, '51_130.jpg', 51),
(132, '53_132.jpg', 53),
(133, '53_133.jpg', 53),
(134, '53_134.jpg', 53),
(135, '53_135.jpg', 53),
(136, '53_136.jpg', 53),
(165, '4_1.jpg', 10),
(172, '54_166.jpg', 54),
(173, '54_173.jpg', 54),
(174, '54_174.jpg', 54),
(175, '54_175.jpg', 54),
(176, '56_176.jpg', 56),
(177, '56_177.jpg', 56),
(178, '56_178.jpg', 56),
(179, '56_179.jpg', 56),
(183, '55_180.jpg', 55),
(184, '55_184.jpg', 55),
(185, '55_185.jpg', 55),
(188, '55_186.jpg', 55),
(189, '57_189.jpg', 57),
(190, '57_190.jpg', 57),
(191, '57_191.jpg', 57),
(192, '57_192.jpg', 57),
(193, '58_193.jpg', 58),
(194, '58_194.jpg', 58),
(195, '50_119.jpg', 53),
(196, '50_119.jpg', 51),
(197, '50_119.jpg', 52),
(198, '6_198.jpg', 6),
(199, '6_199.jpg', 6),
(200, '6_200.jpg', 6),
(201, '6_201.jpg', 6),
(202, '6_202.jpg', 6),
(203, '5_203.jpg', 5),
(204, '5_204.jpg', 5),
(205, '5_205.jpg', 5),
(207, '5_207.jpg', 5),
(208, '59_208.jpg', 59),
(209, '59_209.jpg', 59),
(210, '59_210.jpg', 59),
(211, '59_211.jpg', 59),
(212, '59_212.jpg', 59),
(213, '60_213.jpg', 60),
(214, '60_214.jpg', 60),
(215, '60_215.jpg', 60),
(216, '60_216.jpg', 60),
(217, '60_217.jpg', 60),
(218, '59_208.jpg', 61),
(219, '59_209.jpg', 61),
(220, '59_210.jpg', 61),
(221, '59_211.jpg', 61),
(222, '59_212.jpg', 61),
(223, '60_213.jpg', 62),
(224, '60_214.jpg', 62),
(225, '60_215.jpg', 62),
(226, '60_216.jpg', 62),
(227, '60_217.jpg', 62),
(228, '60_213.jpg', 63),
(229, '60_214.jpg', 63),
(230, '60_215.jpg', 63),
(231, '60_216.jpg', 63),
(233, '60_217.jpg', 63),
(234, '6_198.jpg', 64),
(235, '6_199.jpg', 64),
(236, '6_200.jpg', 64),
(237, '6_201.jpg', 64),
(238, '6_202.jpg', 64),
(240, '5_203.jpg', 65),
(241, '5_204.jpg', 65),
(242, '5_205.jpg', 65),
(243, '5_207.jpg', 65),
(244, '66_244.jpg', 66),
(245, '66_245.jpg', 66),
(246, '66_246.jpg', 66),
(247, '66_247.jpg', 66),
(248, '67_248.jpg', 67),
(249, '67_249.jpg', 67),
(250, '67_250.jpg', 67),
(251, '68_251.jpg', 68),
(252, '68_252.jpg', 68),
(253, '68_253.jpg', 68),
(254, '68_254.jpg', 68),
(255, '68_255.jpg', 68),
(256, '68_256.jpg', 68),
(257, '70_257.jpg', 70),
(258, '70_258.jpg', 70),
(259, '70_259.jpg', 70),
(260, '70_260.jpg', 70),
(261, '70_261.jpg', 70),
(262, '70_262.jpg', 70),
(263, '69_263.jpg', 69),
(264, '69_264.jpg', 69),
(265, '69_265.jpg', 69),
(266, '69_266.jpg', 69),
(267, '69_267.jpg', 69),
(268, '69_268.jpg', 69),
(269, '69_263.jpg', 71),
(270, '69_264.jpg', 71),
(271, '69_265.jpg', 71),
(272, '69_266.jpg', 71),
(273, '69_267.jpg', 71),
(274, '69_268.jpg', 71),
(275, '70_257.jpg', 72),
(276, '70_258.jpg', 72),
(277, '70_259.jpg', 72),
(278, '70_260.jpg', 72),
(279, '70_261.jpg', 72),
(280, '70_262.jpg', 72),
(281, '68_251.jpg', 73),
(282, '68_252.jpg', 73),
(283, '68_253.jpg', 73),
(284, '68_254.jpg', 73),
(285, '68_255.jpg', 73),
(286, '68_256.jpg', 73),
(287, '74_287.jpg', 74),
(288, '74_288.jpg', 74),
(289, '74_289.jpg', 74),
(290, '74_290.jpg', 74),
(291, '74_291.jpg', 74),
(292, '75_292.jpg', 75),
(293, '75_293.jpg', 75),
(294, '75_294.jpg', 75),
(295, '75_295.jpg', 75),
(296, '75_296.jpg', 75),
(297, '76_297.jpg', 76),
(298, '76_298.jpg', 76),
(299, '76_299.jpg', 76),
(300, '76_300.jpg', 76),
(301, '76_301.jpg', 76),
(302, '77_302.jpg', 77),
(303, '77_303.jpg', 77),
(304, '77_304.jpg', 77),
(305, '77_305.jpg', 77),
(306, '77_306.jpg', 77),
(307, '78_307.jpg', 78),
(308, '78_308.jpg', 78),
(309, '78_309.jpg', 78),
(310, '78_310.jpg', 78),
(311, '78_311.jpg', 78),
(313, '82_312.jpg', 82),
(314, '82_314.jpg', 82),
(315, '82_315.jpg', 82),
(316, '82_316.jpg', 82),
(317, '82_317.jpg', 82),
(318, '83_318.jpg', 83),
(319, '83_319.jpg', 83),
(320, '83_320.jpg', 83),
(321, '83_321.jpg', 83),
(322, '82_317.jpg', 83),
(323, '84_323.jpg', 84),
(324, '84_324.jpg', 84),
(325, '84_325.jpg', 84),
(326, '84_326.jpg', 84),
(327, '82_317.jpg', 84),
(328, '85_328.jpg', 85),
(329, '85_329.jpg', 85),
(330, '85_330.jpg', 85),
(331, '85_331.jpg', 85),
(332, '85_332.jpg', 85),
(333, '86_333.jpg', 86),
(334, '86_334.jpg', 86),
(335, '86_335.jpg', 86),
(336, '86_336.jpg', 86),
(337, '86_337.jpg', 86),
(338, '87_338.jpg', 87),
(339, '87_339.jpg', 87),
(340, '87_340.jpg', 87),
(341, '87_341.jpg', 87),
(342, '88_342.jpg', 88),
(343, '88_343.jpg', 88),
(344, '88_344.jpg', 88),
(345, '88_345.jpg', 88),
(346, '88_346.jpg', 88),
(347, '89_347.jpg', 89),
(348, '89_348.jpg', 89),
(349, '89_348.jpg', 90),
(350, '89_347.jpg', 90),
(351, '91_351.jpg', 91),
(352, '91_352.jpg', 91),
(353, '92_353.jpg', 92),
(354, '92_354.jpg', 92),
(355, '9_1.jpg', 93),
(356, '9_32.jpg', 93),
(357, '94_357.jpg', 94),
(358, '94_358.jpg', 94),
(363, '95_359.jpg', 95),
(365, '95_364.jpg', 95),
(366, '96_366.jpg', 96),
(367, '96_367.jpg', 96),
(368, '97_368.jpg', 97),
(369, '97_369.jpg', 97),
(370, '98_370.jpg', 98),
(371, '98_371.jpg', 98),
(372, '98_372.jpg', 98),
(373, '98_373.jpg', 98),
(374, '98_374.jpg', 98),
(375, '99_375.jpg', 99),
(376, '99_376.jpg', 99),
(377, '99_377.jpg', 99),
(378, '99_378.jpg', 99),
(379, '99_379.jpg', 99),
(380, '100_380.jpg', 100),
(382, '100_381.jpg', 100),
(383, '101_383.jpg', 101),
(384, '101_384.jpg', 101),
(385, '96_366.jpg', 102),
(386, '96_367.jpg', 102),
(387, '100_380.jpg', 103),
(388, '100_381.jpg', 103),
(389, '99_375.jpg', 104),
(390, '99_376.jpg', 104),
(391, '99_377.jpg', 104),
(392, '99_378.jpg', 104),
(393, '99_379.jpg', 104),
(394, '105_394.jpg', 105),
(395, '105_395.jpg', 105),
(396, '106_396.jpg', 106),
(397, '106_397.jpg', 106),
(398, '106_398.jpg', 106),
(399, '106_399.jpg', 106),
(400, '106_400.jpg', 106),
(401, '107_401.jpg', 107),
(402, '107_402.jpg', 107),
(403, '106_396.jpg', 108),
(404, '106_397.jpg', 108),
(405, '106_398.jpg', 108),
(406, '106_399.jpg', 108),
(407, '106_400.jpg', 108),
(408, '109_408.jpg', 109),
(409, '109_409.jpg', 109),
(410, '109_408.jpg', 110),
(411, '109_409.jpg', 110),
(412, '8_1.jpg', 111),
(413, '8_2.jpg', 111),
(414, '8_3.jpg', 111),
(416, '8_5.jpg', 111),
(417, '8_6.jpg', 111),
(422, '114_418.jpg', 114),
(423, '114_423.jpg', 114),
(424, '114_424.jpg', 114),
(425, '114_425.jpg', 114),
(426, '114_426.jpg', 114),
(427, '112_427.jpg', 112),
(428, '112_428.jpg', 112),
(429, '112_429.jpg', 112),
(430, '112_430.jpg', 112),
(431, '112_431.jpg', 112),
(432, '113_432.jpg', 113),
(433, '113_433.jpg', 113),
(434, '113_434.jpg', 113),
(435, '113_435.jpg', 113),
(436, '113_436.jpg', 113),
(437, '114_418.jpg', 115),
(438, '114_423.jpg', 115),
(439, '114_424.jpg', 115),
(440, '114_425.jpg', 115),
(441, '114_426.jpg', 115),
(442, '113_432.jpg', 116),
(443, '113_433.jpg', 116),
(444, '113_434.jpg', 116),
(445, '113_435.jpg', 116),
(446, '113_436.jpg', 116),
(447, '117_447.jpg', 117),
(448, '117_448.jpg', 117),
(449, '117_449.jpg', 117),
(450, '117_450.jpg', 117),
(451, '117_451.jpg', 117),
(452, '118_452.jpg', 118),
(453, '118_453.jpg', 118),
(454, '118_454.jpg', 118),
(455, '118_455.jpg', 118),
(456, '118_456.jpg', 118),
(457, '119_457.jpg', 119),
(458, '119_458.jpg', 119),
(459, '119_459.jpg', 119),
(460, '120_460.jpg', 120),
(461, '120_461.jpg', 120),
(462, '120_462.jpg', 120),
(463, '120_463.jpg', 120),
(464, '121_464.jpg', 121),
(465, '121_465.jpg', 121),
(466, '121_466.jpg', 121),
(467, '121_467.jpg', 121),
(468, '122_468.jpg', 122),
(469, '122_469.jpg', 122),
(470, '122_470.jpg', 122),
(471, '122_471.jpg', 122),
(472, '122_472.jpg', 122),
(473, '122_473.jpg', 122),
(474, '122_468.jpg', 123),
(475, '122_469.jpg', 123),
(476, '122_470.jpg', 123),
(477, '122_471.jpg', 123),
(478, '122_472.jpg', 123),
(480, '122_473.jpg', 123),
(481, '124_481.jpg', 124),
(482, '124_482.jpg', 124),
(483, '125_483.jpg', 125),
(487, '125_484.png', 125),
(488, '125_488.png', 125),
(489, '125_489.png', 125),
(490, '126_490.jpg', 126),
(491, '126_491.jpg', 126),
(492, '126_492.jpg', 126),
(493, '129_493.jpg', 129),
(494, '129_494.jpg', 129),
(495, '129_495.jpg', 129),
(496, '126_490.jpg', 130),
(497, '126_491.jpg', 130),
(498, '126_492.jpg', 130),
(499, '131_499.jpg', 131),
(500, '131_500.jpg', 131),
(501, '131_501.jpg', 131),
(502, '132_502.jpg', 132),
(503, '132_503.jpg', 132),
(504, '132_504.jpg', 132),
(505, '132_502.jpg', 133),
(506, '132_503.jpg', 133),
(507, '132_504.jpg', 133),
(521, '134_520.jpg', 134),
(522, '134_522.jpg', 134),
(523, '134_523.jpg', 134),
(524, '134_524.jpg', 134),
(525, '134_525.jpg', 134),
(526, '135_526.jpg', 135),
(527, '135_527.jpg', 135),
(528, '135_528.jpg', 135),
(529, '135_529.jpg', 135),
(530, '135_530.jpg', 135),
(531, '135_531.jpg', 135),
(532, '136_532.jpg', 136),
(533, '136_533.jpg', 136),
(534, '136_534.jpg', 136),
(535, '136_535.jpg', 136),
(536, '136_536.jpg', 136),
(537, '136_537.jpg', 136),
(543, '137_538.jpg', 137),
(544, '137_544.jpg', 137),
(545, '137_545.jpg', 137),
(546, '137_546.jpg', 137),
(547, '137_547.jpg', 137),
(548, '137_548.jpg', 137),
(549, '142_549.jpg', 142),
(550, '142_550.jpg', 142),
(551, '142_551.jpg', 142),
(552, '142_552.jpg', 142),
(553, '142_553.jpg', 142),
(554, '142_554.jpg', 142),
(555, '139_555.jpg', 139),
(556, '139_556.jpg', 139),
(557, '139_557.jpg', 139),
(558, '139_558.jpg', 139),
(559, '139_559.jpg', 139),
(560, '139_560.jpg', 139),
(561, '140_561.jpg', 140),
(562, '140_562.jpg', 140),
(563, '140_563.jpg', 140),
(564, '140_564.jpg', 140),
(565, '140_565.jpg', 140),
(566, '140_566.jpg', 140),
(567, '138_567.jpg', 138),
(568, '138_568.jpg', 138),
(569, '138_569.jpg', 138),
(570, '138_570.jpg', 138),
(571, '138_571.jpg', 138),
(572, '138_572.jpg', 138),
(573, '143_573.jpg', 143),
(575, '143_574.jpg', 143),
(576, '143_576.jpg', 143),
(577, '143_577.jpg', 143),
(578, '143_578.jpg', 143),
(579, '144_579.jpg', 144),
(580, '144_580.jpg', 144),
(581, '144_581.jpg', 144),
(582, '144_582.jpg', 144),
(583, '144_583.jpg', 144),
(584, '145_584.jpg', 145),
(585, '145_585.jpg', 145),
(586, '146_586.jpg', 146),
(587, '146_587.jpg', 146),
(588, '146_588.jpg', 146),
(589, '146_589.jpg', 146),
(590, '146_590.jpg', 146),
(591, '146_591.jpg', 146);

-- --------------------------------------------------------

--
-- Table structure for table `product_specification`
--

CREATE TABLE `product_specification` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sn_id` int(11) NOT NULL,
  `sv_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_specification`
--

INSERT INTO `product_specification` (`id`, `product_id`, `sn_id`, `sv_id`) VALUES
(1, 1, 2, 3),
(2, 1, 1, 1),
(4, 2, 14, 51),
(5, 35, 14, 51),
(6, 31, 14, 51),
(7, 36, 14, 51),
(8, 33, 14, 51),
(9, 34, 14, 51),
(10, 1, 14, 51),
(11, 39, 14, 51),
(12, 39, 1, 1),
(13, 39, 2, 3),
(14, 40, 14, 51),
(15, 40, 1, 1),
(16, 40, 2, 3),
(17, 41, 1, 57),
(18, 41, 14, 51),
(19, 41, 2, 3),
(20, 42, 1, 59),
(21, 42, 14, 51),
(22, 42, 2, 3),
(23, 15, 14, 52),
(24, 44, 8, 63),
(25, 45, 8, 63),
(26, 46, 8, 63),
(28, 47, 16, 63),
(29, 53, 15, 75),
(30, 57, 14, 51),
(31, 58, 14, 51),
(32, 59, 14, 51),
(33, 62, 2, 92),
(34, 62, 17, 63),
(35, 62, 18, 85),
(36, 62, 19, 86),
(37, 62, 20, 88),
(38, 63, 2, 92),
(39, 63, 17, 63),
(40, 63, 18, 85),
(41, 63, 19, 91),
(42, 63, 20, 88),
(43, 64, 2, 96),
(44, 64, 17, 63),
(45, 64, 18, 97),
(46, 64, 19, 98),
(47, 64, 20, 99),
(48, 66, 21, 63),
(49, 46, 16, 63),
(50, 70, 23, 106),
(51, 70, 14, 51),
(52, 71, 23, 108);

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `shop_id` int(5) NOT NULL,
  `shop_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`shop_id`, `shop_name`, `address_id`) VALUES
(1, 'TechTronic Los Angeles', 1),
(2, 'TechTronic Florida', 5),
(3, 'TechTronic New York', 17);

-- --------------------------------------------------------

--
-- Table structure for table `specification_names`
--

CREATE TABLE `specification_names` (
  `sn_id` int(11) NOT NULL,
  `specification_name` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specification_names`
--

INSERT INTO `specification_names` (`sn_id`, `specification_name`) VALUES
(1, 'Battery'),
(2, 'Operating System'),
(3, 'Display'),
(4, 'RAM / Storage'),
(5, 'Processor'),
(6, 'Connectivity'),
(7, 'Noise Reduction'),
(8, 'Microfons'),
(14, 'Refresh Rate'),
(15, 'Waterproof'),
(16, 'MagSafe'),
(17, 'Touch Screen'),
(18, 'Graphic Card'),
(19, 'Weight'),
(20, 'Ram Speed'),
(21, '5G'),
(22, 'Brightness'),
(23, 'Second Display');

-- --------------------------------------------------------

--
-- Table structure for table `specification_values`
--

CREATE TABLE `specification_values` (
  `sv_id` int(11) NOT NULL,
  `specification_value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specification_values`
--

INSERT INTO `specification_values` (`sv_id`, `specification_value`) VALUES
(1, '5000 mAh'),
(2, 'IOS'),
(3, 'Android'),
(4, '6.8&quot;, 3200 x 1440px, Dynamic AMOLED 2X'),
(5, '12/128 GB'),
(6, 'Qualcomm Snapdragon 888'),
(7, '13.3&quot;, 2560 x 1600px'),
(8, '8/512 GB'),
(9, 'Apple M1'),
(10, '6.7&quot;, 1080 x 2400px, Dynamic AMOLED 2X'),
(11, '8/128 GB'),
(12, 'Round 1.4&quot;, 450 x 450px'),
(13, '361 mAh'),
(14, 'Bluetooth, NFC, WiFi'),
(15, 'Square 1.9&quot;, 368 x 448px'),
(16, '?, up to 18 hours'),
(17, '8/256 GB'),
(19, '6/128 GB'),
(20, 'Apple A15 Bionic'),
(28, '6.2&quot;, 1080 x 2400px, Dynamic AMOLED 2X'),
(29, '6.7&quot;, 2778 x 1284px, OLED, Super Retina XDR'),
(30, '6.1&quot;, 2532 x 1170px, OLED, Super Retina XDR'),
(31, '5.4&quot;, 2340 x 1080px, OLED, Super Retina XDR'),
(32, '4/128 GB'),
(33, '6.55&quot;, 2400 x 1080px, AMOLED'),
(34, 'Qualcomm Snapdragon 778G'),
(35, '4.7&quot;, 1334 x 750px, IPS,Retina HD'),
(36, '4/64 GB'),
(37, '14.6&quot;, 2960 x 1848px, Super AMOLED'),
(38, 'Qualcomm SM8450'),
(39, '11&quot;, 2560 x 1600px, TFT'),
(40, '12.4&quot;, 2800 x 1752px, Super AMOLED'),
(41, '6.5&quot;, 2400 x 1080px, Super AMOLED'),
(42, 'Exynos 1200'),
(43, '16.2&quot;, 3456 x 2234px, 120Hz'),
(44, '16/512 GB'),
(45, 'Apple M1 Pro'),
(46, '14.2&quot;, 3024 x 1964px, 120Hz'),
(47, '32GB / 1TB'),
(48, '64GB / 8TB'),
(49, 'Apple M1 Max'),
(50, '32GB / 2TB'),
(51, '120Hz'),
(52, '60Hz'),
(53, '6.8&quot;, 3080 x 1440px, Dynamic AMOLED 2X'),
(54, 'Exynos 2200'),
(55, '12/512 GB'),
(56, '6.1&quot;, 2340 x 1080px, Dynamic AMOLED 2X'),
(57, '3700 mAh'),
(58, '6.6&quot;, 2340 x 1080px, Dynamic AMOLED 2X'),
(59, '4500 mAh'),
(60, 'Active (ANC)'),
(61, 'IPX2'),
(62, 'Bluetooth 5.2'),
(63, 'Yes'),
(64, 'IPX7'),
(65, 'Bluetooth 5.0'),
(66, 'No'),
(67, 'Passive'),
(68, 'IPX4'),
(69, '4G (LTE) eSIM, Bluetooth, NFC, WiFi'),
(70, '309 mAh'),
(71, 'Square 1.69&quot;, 352 x 430px'),
(72, '284 mAh'),
(73, 'Round 1.2&quot;, 396 x 396 px'),
(74, '247 mAh'),
(75, 'IP68'),
(76, '6.28&quot;, 2400 x 1080px, AMOLED'),
(77, 'Snapdragon 8 Gen 1'),
(78, '6.73&quot;, 3200 x 1440px, AMOLED'),
(79, '12/256 GB'),
(80, 'Round 1.43&quot;, 466 x 466px'),
(81, '470 mAh'),
(82, '13.4&quot;, 1920 x 1200px, 60Hz'),
(83, 'Intel Core i5-1135G7'),
(84, 'Windows 11'),
(85, 'Intel Iris Xe Graphics'),
(86, '1.2 kg'),
(87, '13.4&quot;, 3456 x 2160px, 60Hz'),
(88, '4267 MHz'),
(89, '13.4&quot;, 3840 x 2400px, 60Hz'),
(90, 'Intel Core i7-1185G7'),
(91, '1.27 kg'),
(92, 'Windows 11 Home'),
(93, '15.6&quot;, 3840 x 2400px, 60Hz'),
(94, '16 GB / 1TB'),
(95, 'Intel Core i9-12900HK'),
(96, 'Windows 11 Pro'),
(97, 'NVIDIA GeForce RTX 3050 Ti'),
(98, '1.92 kg'),
(99, '4800 MHz'),
(100, '12.9&quot;, 2732 x 2048px, Liquid Retina XDR'),
(101, '11&quot;, 2388 x 1668px, Liquid Retina'),
(102, '27&quot;, 5120 x 2880px, Retina'),
(103, '600'),
(104, '600 nits'),
(105, '7.2&quot;, 2208 &times; 1768px, Dynamic AMOLED 2X'),
(106, '6.2&quot;, 2268 x 832px, Dynamic AMOLED 2X'),
(107, '6.7&quot;, 2640 x 1080px, Dynamic AMOLED 2X'),
(108, '1.9&quot;, 512 x 260px, Super AMOLED'),
(109, '49&quot;, 5120 x 1440px, VA'),
(110, '240 Hz'),
(111, '420 nits'),
(112, '27&quot;, 2560 x 1440px, VA'),
(113, '350 nits'),
(114, '32&quot;, 6016x 3384px, Retina XDR'),
(115, '60 Hz'),
(116, '500 nits'),
(117, '32&quot;, 2560 x 1440px, VA'),
(118, '165 Hz');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(320) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password_hash`, `first_name`, `last_name`, `address_id`) VALUES
(1, 'johnsmith@gmail.com', '$2y$12$2SuZW7CvuYPOLs6qplp56.Fa6NLoLtrzGK.na7dKX2I0E9dp4HXN.', 'John', 'Smith', 4),
(13, 'martin_lee@mail.net', '$2y$12$9Thn5S9eMLbv/8jc1iucNeQNonfX0l75JlwFmmSrO1yqwxQPywyIi', 'Martin J', 'Lee', 30);

-- --------------------------------------------------------

--
-- Table structure for table `us_states`
--

CREATE TABLE `us_states` (
  `state_id` int(11) NOT NULL,
  `state_name` char(14) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `us_states`
--

INSERT INTO `us_states` (`state_id`, `state_name`) VALUES
(1, 'Alabama'),
(2, 'Alaska'),
(3, 'Arizona'),
(4, 'Arkansas'),
(5, 'California'),
(6, 'Colorado'),
(7, 'Connecticut'),
(8, 'Delaware'),
(9, 'Florida'),
(10, 'Georgia'),
(11, 'Hawaii'),
(12, 'Idaho'),
(13, 'Illinois'),
(14, 'Indiana'),
(15, 'Iowa'),
(16, 'Kansas'),
(17, 'Kentucky'),
(18, 'Louisiana'),
(19, 'Maine'),
(20, 'Maryland'),
(21, 'Massachusetts'),
(22, 'Michigan'),
(23, 'Minnesota'),
(24, 'Mississippi'),
(25, 'Missouri'),
(26, 'Montana'),
(27, 'Nebraska'),
(28, 'Nevada'),
(29, 'New Hampshire'),
(30, 'New Jersey'),
(31, 'New Mexico'),
(32, 'New York'),
(33, 'North Carolina'),
(34, 'North Dakota'),
(35, 'Ohio'),
(36, 'Oklahoma'),
(37, 'Oregon'),
(38, 'Pennsylvania'),
(39, 'Rhode Island'),
(40, 'South Carolina'),
(41, 'South Dakota'),
(42, 'Tennessee'),
(43, 'Texas'),
(44, 'Utah'),
(45, 'Vermont'),
(46, 'Virginia'),
(47, 'Washington'),
(48, 'West Virginia'),
(49, 'Wisconsin'),
(50, 'Wyoming');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `feature_1_name` (`feature_1_name`),
  ADD KEY `feature_2_name` (`feature_2_name`),
  ADD KEY `feature_3_name` (`feature_3_name`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `color_versions`
--
ALTER TABLE `color_versions`
  ADD PRIMARY KEY (`cv_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `main_image_id` (`main_image_id`);

--
-- Indexes for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`op_id`),
  ADD KEY `ordered_products_ibfk_2` (`order_id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_status` (`order_status`),
  ADD KEY `delivery_type` (`delivery_type`),
  ADD KEY `payment_type` (`payment_type`),
  ADD KEY `deliver_to` (`deliver_to_address`),
  ADD KEY `deliver_to_shop` (`deliver_to_shop`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_delivery`
--
ALTER TABLE `order_delivery`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `order_payment`
--
ALTER TABLE `order_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `producers`
--
ALTER TABLE `producers`
  ADD PRIMARY KEY (`producer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `producer_id` (`producer_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `feature_1_val` (`feature_1_val`),
  ADD KEY `feature_2_val` (`feature_2_val`),
  ADD KEY `feature_3_val` (`feature_3_val`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `cv_id` (`cv_id`);

--
-- Indexes for table `product_specification`
--
ALTER TABLE `product_specification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_specification_ibfk_2` (`sn_id`),
  ADD KEY `sv_id` (`sv_id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`shop_id`),
  ADD KEY `shops_ibfk_1` (`address_id`);

--
-- Indexes for table `specification_names`
--
ALTER TABLE `specification_names`
  ADD PRIMARY KEY (`sn_id`);

--
-- Indexes for table `specification_values`
--
ALTER TABLE `specification_values`
  ADD PRIMARY KEY (`sv_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `us_states`
--
ALTER TABLE `us_states`
  ADD PRIMARY KEY (`state_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `color_versions`
--
ALTER TABLE `color_versions`
  MODIFY `cv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_delivery`
--
ALTER TABLE `order_delivery`
  MODIFY `delivery_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_payment`
--
ALTER TABLE `order_payment`
  MODIFY `payment_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `status_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `producers`
--
ALTER TABLE `producers`
  MODIFY `producer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=592;

--
-- AUTO_INCREMENT for table `product_specification`
--
ALTER TABLE `product_specification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `shop_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `specification_names`
--
ALTER TABLE `specification_names`
  MODIFY `sn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `specification_values`
--
ALTER TABLE `specification_values`
  MODIFY `sv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `us_states`
--
ALTER TABLE `us_states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `us_states` (`state_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`cv_id`) REFERENCES `color_versions` (`cv_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`feature_1_name`) REFERENCES `specification_names` (`sn_id`),
  ADD CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`feature_2_name`) REFERENCES `specification_names` (`sn_id`),
  ADD CONSTRAINT `categories_ibfk_3` FOREIGN KEY (`feature_3_name`) REFERENCES `specification_names` (`sn_id`);

--
-- Constraints for table `color_versions`
--
ALTER TABLE `color_versions`
  ADD CONSTRAINT `color_versions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `color_versions_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `color_versions_ibfk_3` FOREIGN KEY (`main_image_id`) REFERENCES `product_images` (`image_id`) ON DELETE SET NULL;

--
-- Constraints for table `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD CONSTRAINT `ordered_products_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordered_products_ibfk_3` FOREIGN KEY (`cv_id`) REFERENCES `color_versions` (`cv_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`order_status`) REFERENCES `order_status` (`status_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`delivery_type`) REFERENCES `order_delivery` (`delivery_id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`payment_type`) REFERENCES `order_payment` (`payment_id`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`deliver_to_address`) REFERENCES `address` (`address_id`),
  ADD CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`deliver_to_shop`) REFERENCES `shops` (`shop_id`),
  ADD CONSTRAINT `orders_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`producer_id`) REFERENCES `producers` (`producer_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`feature_1_val`) REFERENCES `specification_values` (`sv_id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`feature_2_val`) REFERENCES `specification_values` (`sv_id`),
  ADD CONSTRAINT `products_ibfk_5` FOREIGN KEY (`feature_3_val`) REFERENCES `specification_values` (`sv_id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`cv_id`) REFERENCES `color_versions` (`cv_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_specification`
--
ALTER TABLE `product_specification`
  ADD CONSTRAINT `product_specification_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_specification_ibfk_2` FOREIGN KEY (`sn_id`) REFERENCES `specification_names` (`sn_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_specification_ibfk_3` FOREIGN KEY (`sv_id`) REFERENCES `specification_values` (`sv_id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
