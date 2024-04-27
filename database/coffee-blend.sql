-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 06:38 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee-blend`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `email`, `password`, `created_at`) VALUES
(1, 'admin.first', 'admin@gmail.com', '$2y$10$iGjJ1g6SPFVKOv1/6cgSnu0R8fiUAZPpgfKY0WOTYogv2Wmk6.BNS', '2024-02-19 15:59:30'),
(2, 'admin.second', 'admin.second@gmail.com', '$2y$10$Lq0xQZjCPCePskIZ0pkGyOq8eZrEhP1B89D9Ac/S18z0OmnQ5pMDe', '2024-02-21 06:26:10'),
(9, 'admin.third', 'admin.third@gmail.com', '$2y$10$F5ZWlaak9hoyU1lnzqpiO.CymqxWEvNIY3LpXE8ETdmCn8H7DGP8m', '2024-02-25 14:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `seats` int(10) NOT NULL,
  `date` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `first_name`, `last_name`, `seats`, `date`, `time`, `phone`, `message`, `status`, `user_id`, `created_at`) VALUES
(3, 'Rupesh', 'Pandey', 1, '2/24/2024', '2:00am', '7004396959', 'I  need seat which is cozy for 2hrs.', 'Done', 34, '2024-02-23 13:04:58'),
(5, 'Rupesh', 'Pandey', 2, '2/24/2024', '12:00am', '7004396959', 'I need to book a table for 2 seater.', 'Done', 34, '2024-02-23 13:09:57'),
(6, 'Rupesh', 'Pandey', 1, '2/24/2024', '1:00pm', '7004396959', 'I need only one book', 'Pending', 34, '2024-02-23 13:13:23'),
(7, 'Rupesh', 'Pandey', 0, '3/24/2024', '1:30am', '7004396959', 'I need a table', 'Confirmed', 34, '2024-02-23 13:14:01'),
(8, 'Pradeep', 'Mahto', 0, '2/25/2024', '12:00am', '7004396959', 'I have a contion', 'Pending', 35, '2024-02-24 04:45:24'),
(17, 'Arunabh', 'Das', 4, '2024-04-01', '09:30', '7004396959', 'Hey there i need to book seat for mine family of 4', 'Done', 1, '2024-03-30 04:36:07'),
(18, 'Arunabh', 'Das', 2, '2024-04-02', '08:00', '7004396959', 'Hi! I\'d like to make a reservation for two for the coffee pairing dinner on 1 April.', 'Cancelled', 1, '2024-03-30 08:44:22'),
(20, 'Arunabh', 'Das', 10, '2024-04-11', '08:00', '7004396959', 'Hey! I\'m planning a birthday party and would like to book your venue for a coffee-themed celebration.', 'In Progress', 1, '2024-04-10 09:09:47'),
(22, 'Priya', 'Kumari', 6, '2024-04-16', '08:00', '8234034905', 'Hi there! I\'d like to reserve a spot for the coffee brewing workshop on tom 8am. Can you confirm my booking?', '', 51, '2024-04-15 07:32:02'),
(23, 'Priya', 'Kumari', 5, '2024-04-17', '14:30', '8271729269', 'Hello! I\'m interested in booking a private coffee tasting for a group of 5 people.', 'Pending', 51, '2024-04-15 09:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `price` varchar(10) NOT NULL,
  `pro_id` int(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `quantity` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `name`, `image`, `price`, `pro_id`, `description`, `quantity`, `user_id`, `created_at`) VALUES
(23, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 31, '2024-02-23 07:50:33'),
(24, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 32, '2024-02-23 07:55:58'),
(25, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 33, '2024-02-23 08:13:39'),
(28, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 34, '2024-02-23 13:19:12'),
(32, 'Banana Cherry Chocolate', 'dessert-5.jpg', '250', 22, 'Moist layers, fruity bliss, decadent chocolate drizzle. Delightful indulgence.', 1, 38, '2024-02-24 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_inquiries`
--

CREATE TABLE `customer_inquiries` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_inquiries`
--

INSERT INTO `customer_inquiries` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(4, 'Arunabh', 'arun@gmail.com', 'Discounts for Bulk Orders and Recurring Bookings?', 'Are there any promotional offers or discounts available for bulk orders or recurring bookings, and how can I avail of them?', 'closed', '2024-02-22 07:15:33'),
(8, 'Arunabh', 'arun@gmail.com', 'Understanding Terms for Bookings', 'Can you provide information about your booking cancellation policy, including any applicable refund processes and deadlines?', 'pending', '2024-02-24 05:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `state` varchar(200) NOT NULL,
  `street_address` varchar(200) NOT NULL,
  `town` varchar(200) NOT NULL,
  `zip_code` int(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `status` varchar(200) NOT NULL,
  `discount` int(10) NOT NULL,
  `total_price` int(10) NOT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `pay_type` varchar(200) NOT NULL,
  `pay_status` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `state`, `street_address`, `town`, `zip_code`, `phone`, `email`, `user_id`, `status`, `discount`, `total_price`, `pay_id`, `pay_type`, `pay_status`, `created_at`) VALUES
(84, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 915, NULL, '', '', '2024-03-25 05:45:41'),
(87, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'In Progress', 5, 795, NULL, '', '', '2024-03-26 13:18:19'),
(88, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 465, NULL, '', '', '2024-03-26 13:24:25'),
(103, 'Arunabh', 'Das', 'Jharkhand', 'Mango', 'Kolkata', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 1195, NULL, '', '', '2024-04-01 05:04:40'),
(132, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 5, 405, NULL, '', '', '2024-04-01 08:07:38'),
(133, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 845, NULL, '', '', '2024-04-01 08:31:54'),
(134, 'Pratush', 'Kumar', 'Jharkhand', 'Kurmruh Basti, Near Big Bazar Road', 'Jamshedpur', 831012, '8271729269', 'pratyush@gmail.com', 14, 'Pending', 5, 145, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 04:44:42'),
(135, 'Pratush', 'Kumar', 'Jharkhand', 'Kurmruh Basti, Near Big Bazar Road', 'Jamshedpur', 831012, '8271729269', 'pratyush@gmail.com', 14, 'Pending', 5, 545, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 05:11:13'),
(136, 'Pratush', 'Kumar', 'Jharkhand', 'Kurmruh Basti, Near Big Bazar Road', 'Jamshedpur', 831012, '8271729269', 'pratyush@gmail.com', 14, 'Cancelled', 5, 285, NULL, 'Online Payment', 'Completed', '2024-04-02 05:36:10'),
(137, 'Pratush', 'Kumar', 'Jharkhand', 'Kurmruh Basti, Near Big Bazar Road', 'Jamshedpur', 831012, '8271729269', 'pratyush@gmail.com', 14, 'Delivered', 5, 405, NULL, 'Cash On Delivery', 'Completed', '2024-04-02 05:40:15'),
(138, 'Pratush', 'Kumar', 'Jharkhand', 'Kurmruh Basti, Near Big Bazar Road', 'Jamshedpur', 831012, '8271729269', 'pratyush@gmail.com', 14, 'In Progress', 5, 1645, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 05:41:18'),
(143, 'Abhijit', 'Mahato', 'Jharkhand', 'Street 14, Jugsalai', 'Jamshedpur', 831012, '9155603647', 'abhijit@gmail.com', 24, 'Delivered', 5, 845, 95, 'Online Payment', 'Completed', '2024-04-02 06:22:07'),
(144, 'Abhijit', 'Mahato', 'Jharkhand', 'Street 14, Jugsalai', 'Jamshedpur', 831012, '9155603647', 'abhijit@gmail.com', 24, 'Shipped', 5, 405, 96, 'Online Payment', 'Completed', '2024-04-02 06:25:37'),
(145, 'Abhijit', 'Mahato', 'Jharkhand', 'Street 14, Jugsalai', 'Jamshedpur', 831012, '9155603647', 'abhijit@gmail.com', 24, 'In Progress', 5, 405, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 06:28:57'),
(146, 'Pradeep', 'Mahto', 'Jharkhand', 'Street 18, Adityapur more, Adityapur ', 'Jamshedpur', 831005, '8234034905', 'pradeep@gmail.com', 46, 'Delivered', 5, 345, 97, 'Online Payment', 'Completed', '2024-04-02 07:51:06'),
(147, 'Pradeep', 'Mahto', 'Jharkhand', 'Street 18, Adityapur more, Adityapur', 'Jamshedpur', 831005, '8234034905', 'pradeep@gmail.com', 46, 'Cancelled', 5, 345, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 08:02:38'),
(148, 'Pradeep', 'Mahto', 'Jharkhand', 'Street 18, Adityapur more, Adityapur', 'Jamshedpur', 831005, '8234034905', 'pradeep@gmail.com', 46, 'Shipped', 5, 585, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 08:03:21'),
(149, 'Pradeep', 'Mahto', 'Jharkhand', 'Street 18, Adityapur more, Adityapur', 'Jamshedpur', 831005, '8234034905', 'pradeep@gmail.com', 46, 'Shipped', 5, 665, 98, 'Online Payment', 'Completed', '2024-04-02 08:05:25'),
(150, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 465, NULL, 'Cash On Delivery', 'Pending', '2024-04-02 15:02:16'),
(151, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 1995, NULL, 'Cash On Delivery', 'Completed', '2024-04-05 04:25:12'),
(152, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 230, NULL, 'Cash On Delivery', 'Pending', '2024-04-05 09:33:08'),
(153, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 5, 945, NULL, 'Cash On Delivery', 'Pending', '2024-04-05 15:09:57'),
(154, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 885, 99, 'Online Payment', 'Completed', '2024-04-11 16:04:22'),
(155, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 885, NULL, 'Cash On Delivery', 'Pending', '2024-04-11 16:05:35'),
(156, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 195, 100, 'Online Payment', 'Completed', '2024-04-11 16:09:11'),
(157, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 195, 101, 'Online Payment', 'Completed', '2024-04-11 16:10:57'),
(158, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 195, 102, 'Online Payment', 'Completed', '2024-04-11 16:13:47'),
(159, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 195, 103, 'Online Payment', 'Completed', '2024-04-11 16:15:36'),
(160, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 345, 104, 'Online Payment', 'Completed', '2024-04-11 16:19:24'),
(161, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 5, 345, 105, 'Online Payment', 'Completed', '2024-04-11 16:20:47'),
(162, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Shipped', 5, 345, 106, 'Online Payment', 'Completed', '2024-04-11 16:22:06'),
(163, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 5, 195, 107, 'Online Payment', 'Completed', '2024-04-11 16:23:47'),
(164, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 25, 1075, 108, 'Online Payment', 'Completed', '2024-04-11 16:30:23'),
(165, 'Uttam', 'Gorai', 'Jharkhand', 'HNo14, Road No-15, Ulidih', 'Jamshedpur', 831011, '8698874856', 'uttam@gmail.com', 47, 'Delivered', 25, 205, NULL, 'Cash On Delivery', 'Completed', '2024-04-12 04:47:02'),
(169, 'Uttam', 'Gorai', 'Jharkhand', 'HNo14, Ulidih', 'Jamshedpur', 831011, '8698874856', 'uttam@gmail.com', 47, 'Delivered', 25, 545, NULL, 'Cash On Delivery', 'Completed', '2024-04-12 07:47:50'),
(171, 'Uttam', 'Gorai', 'Jharkhand', 'HNo14, Ulidih', 'Jamshedpur', 831011, '8698874856', 'uttam@gmail.com', 47, 'Delivered', 25, 445, 115, 'Online Payment', 'Completed', '2024-04-12 08:04:40'),
(172, 'Uttam', 'Gorai', 'Jharkhand', 'HNo14, Ulidih', 'Jamshedpur', 831011, '8698874856', 'uttam@gmail.com', 47, 'Delivered', 5, 345, NULL, 'Cash On Delivery', 'Completed', '2024-04-12 08:05:55'),
(173, 'Uttam', 'Gorai', 'Jharkhand', 'HNo14, Ulidih', 'Jamshedpur', 831011, '8698874856', 'uttam@gmail.com', 47, 'Delivered', 5, 705, 116, 'Online Payment', 'Completed', '2024-04-12 08:08:20'),
(174, 'Arunabh', 'Das', 'Jharkhand', 'Dimna, Mango', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 5, 545, 117, 'Online Payment', 'Completed', '2024-04-16 03:31:29'),
(177, 'Priya', 'Kumari', 'Jharkhand', 'Mango', 'Kolkata', 831005, '8698874856', 'priya@gmail.com', 51, 'Pending', 5, 545, NULL, 'Cash On Delivery', 'Pending', '2024-04-17 07:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_id`, `order_id`, `product_name`, `quantity`, `price`, `product_image`) VALUES
(38, 47, 84, 'Chicken Wings', 3, 250.00, 'appetizer-5.jpg'),
(39, 5, 84, 'Iced Americano', 1, 120.00, 'menu-6.jpg'),
(41, 1, 87, 'Cappuccino', 5, 150.00, 'menu-1.jpg'),
(42, 2, 88, 'Latte', 2, 210.00, 'menu-4.jpg'),
(63, 1, 103, 'Cappuccino', 6, 150.00, 'menu-1.jpg'),
(64, 10, 103, 'Pancake', 1, 250.00, 'dessert-2.jpg'),
(94, 19, 132, 'Spicy BBQ Burger', 2, 180.00, 'burger-2.jpg'),
(95, 3, 133, 'Choclate Coffee', 2, 400.00, 'menu-2.jpg'),
(96, 9, 134, 'Lemonade', 2, 50.00, 'drink-1.jpg'),
(97, 16, 135, 'Red Velvet Cupcake', 5, 100.00, 'dessert-15.jpg'),
(98, 39, 136, 'Tiramisu', 2, 120.00, 'dessert-10.jpeg'),
(99, 6, 137, 'Mocha', 2, 180.00, 'menu-7.jpeg'),
(100, 3, 138, 'Choclate Coffee', 4, 400.00, 'menu-2.jpg'),
(101, 3, 143, 'Choclate Coffee', 2, 400.00, 'menu-2.jpg'),
(102, 23, 144, 'Vanilla Patisserie', 2, 180.00, 'dessert-6.jpg'),
(103, 23, 145, 'Vanilla Patisserie', 2, 180.00, 'dessert-6.jpg'),
(104, 46, 146, 'Shrimp Cocktail', 1, 300.00, 'appetizer-4.jpeg'),
(105, 18, 147, 'Classic Cheeseburger', 2, 150.00, 'burger-1.jpg'),
(106, 19, 148, 'Spicy BBQ Burger', 3, 180.00, 'burger-2.jpg'),
(107, 5, 149, 'Iced Americano', 1, 120.00, 'menu-6.jpg'),
(108, 47, 149, 'Chicken Wings', 2, 250.00, 'appetizer-5.jpg'),
(109, 14, 150, 'Pizza', 2, 210.00, 'image_6.jpg'),
(110, 18, 151, 'Classic Cheeseburger', 3, 150.00, 'burger-1.jpg'),
(111, 1, 151, 'Cappuccino', 10, 150.00, 'menu-1.jpg'),
(112, 18, 152, 'Classic Cheeseburger', 1, 150.00, 'burger-1.jpg'),
(113, 1, 153, 'Cappuccino', 6, 150.00, 'menu-1.jpg'),
(114, 1, 154, 'Cappuccino', 4, 150.00, 'menu-1.jpg'),
(115, 42, 154, 'Bread Pudding', 2, 120.00, 'dessert-13.jpeg'),
(116, 1, 155, 'Cappuccino', 4, 150.00, 'menu-1.jpg'),
(117, 42, 155, 'Bread Pudding', 2, 120.00, 'dessert-13.jpeg'),
(118, 1, 156, 'Cappuccino', 1, 150.00, 'menu-1.jpg'),
(119, 1, 157, 'Cappuccino', 1, 150.00, 'menu-1.jpg'),
(120, 1, 158, 'Cappuccino', 1, 150.00, 'menu-1.jpg'),
(121, 1, 159, 'Cappuccino', 1, 150.00, 'menu-1.jpg'),
(122, 1, 160, 'Cappuccino', 2, 150.00, 'menu-1.jpg'),
(123, 1, 161, 'Cappuccino', 2, 150.00, 'menu-1.jpg'),
(124, 1, 162, 'Cappuccino', 2, 150.00, 'menu-1.jpg'),
(125, 1, 163, 'Cappuccino', 1, 150.00, 'menu-1.jpg'),
(126, 2, 164, 'Latte', 5, 210.00, 'menu-4.jpg'),
(127, 19, 165, 'Spicy BBQ Burger', 1, 180.00, 'burger-2.jpg'),
(131, 21, 169, 'Blackberry Cheesecake', 2, 80.00, 'dessert-4.jpg'),
(132, 19, 169, 'Spicy BBQ Burger', 2, 180.00, 'burger-2.jpg'),
(134, 4, 171, 'Iced coffee', 2, 210.00, 'menu-3.jpg'),
(135, 7, 172, 'Affogato', 2, 150.00, 'menu-8.jpeg'),
(136, 34, 173, 'Cold Brew', 2, 150.00, 'menu-9.jpeg'),
(137, 19, 173, 'Spicy BBQ Burger', 2, 180.00, 'burger-2.jpg'),
(138, 4, 174, 'Iced coffee', 1, 210.00, 'menu-3.jpg'),
(139, 21, 174, 'Blackberry Cheesecake', 1, 80.00, 'dessert-4.jpg'),
(140, 14, 174, 'Pizza', 1, 210.00, 'image_6.jpg'),
(143, 10, 177, 'Pancake', 2, 250.00, 'dessert-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Success',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `payment_id`, `amount_paid`, `status`, `timestamp`) VALUES
(36, 1, 'pay_NhXXBUw7rAquvC', 46.00, 'Success', '2024-03-02 15:42:07'),
(38, 1, 'pay_Nhp7upMCyBscwC', 46.00, 'Success', '2024-03-03 08:54:38'),
(39, 1, 'pay_NiLMYVNInW4SMm', 345.00, 'Success', '2024-03-04 16:26:42'),
(40, 1, 'pay_NoWie7PWBDGYkv', 265.00, 'Success', '2024-03-20 07:27:15'),
(41, 1, 'pay_NowtxWlQhEaQEd', 195.00, 'Success', '2024-03-21 09:04:01'),
(42, 1, 'pay_NqTuIpDtldInQV', 915.00, 'Success', '2024-03-25 06:08:57'),
(43, 1, 'pay_NqUb1H8TFDlqz4', 150.00, 'Success', '2024-03-25 06:47:15'),
(44, 1, 'pay_NtDg4ASvDx4t9y', 285.00, 'Success', '2024-04-01 04:06:23'),
(45, 1, 'pay_NtDg4ASvDx4t9y', 285.00, 'Success', '2024-04-01 04:24:50'),
(46, 1, 'pay_NtDg4ASvDx4t9y', 285.00, 'Success', '2024-04-01 04:26:11'),
(47, 1, 'pay_NtEHKRnJR31mPC', 345.00, 'Success', '2024-04-01 04:39:53'),
(48, 1, 'pay_NtEHKRnJR31mPC', 345.00, 'Success', '2024-04-01 04:41:24'),
(49, 1, 'pay_NtEHKRnJR31mPC', 345.00, 'Success', '2024-04-01 04:41:25'),
(50, 1, 'pay_NtEHKRnJR31mPC', 345.00, 'Success', '2024-04-01 04:41:28'),
(51, 1, 'pay_NtEHKRnJR31mPC', 345.00, 'Success', '2024-04-01 04:41:45'),
(52, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:47:20'),
(53, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:48:27'),
(54, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:49:15'),
(55, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:49:16'),
(56, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:49:38'),
(57, 1, 'pay_NtEPDFSruOkzjG', 615.00, 'Success', '2024-04-01 04:52:06'),
(58, 1, 'pay_NtEbfhWRANhOiq', 445.00, 'Success', '2024-04-01 04:59:09'),
(59, 1, 'pay_NtEhW6mNXpXWSV', 1195.00, 'Success', '2024-04-01 05:04:40'),
(60, 1, 'pay_NtEqC01fceRMI8', 845.00, 'Success', '2024-04-01 05:12:53'),
(61, 1, 'pay_NtExTJ2sUfBAw8', 725.00, 'Success', '2024-04-01 05:19:47'),
(62, 1, 'pay_NtF2cBQoJ7kk82', 645.00, 'Success', '2024-04-01 05:24:39'),
(63, 1, 'pay_NtF6xmqnChPWuo', 445.00, 'Success', '2024-04-01 05:28:45'),
(64, 1, 'pay_NtF9KUOhDQWgux', 445.00, 'Success', '2024-04-01 05:31:00'),
(65, 1, 'pay_NtFBDPQC94GxzD', 545.00, 'Success', '2024-04-01 05:32:47'),
(66, 1, 'pay_NtFDGbq1pyF4vH', 1545.00, 'Success', '2024-04-01 05:34:43'),
(67, 1, 'pay_NtFI559GUtr4gI', 195.00, 'Success', '2024-04-01 05:39:17'),
(68, 1, 'pay_NtFPJegdGQjNJb', 1305.00, 'Success', '2024-04-01 05:46:08'),
(69, 1, 'pay_NtFSHlYQb3Roqu', 195.00, 'Success', '2024-04-01 05:48:57'),
(70, 1, 'pay_NtFVZQQ9C5veDI', 345.00, 'Success', '2024-04-01 05:52:03'),
(71, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:53:45'),
(72, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:54:17'),
(73, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:54:31'),
(74, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:55:40'),
(75, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:55:51'),
(76, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:56:07'),
(77, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:56:19'),
(78, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:57:00'),
(79, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:57:28'),
(80, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:58:09'),
(81, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:58:10'),
(82, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:58:12'),
(83, 1, 'pay_NtFXNrvOZj0DEC', 345.00, 'Success', '2024-04-01 05:59:15'),
(84, 14, 'pay_NtdkqZhVbDy95k', 285.00, 'Success', '2024-04-02 05:35:10'),
(85, 14, 'pay_NtdkqZhVbDy95k', 285.00, 'Success', '2024-04-02 05:35:41'),
(86, 14, 'pay_NtdkqZhVbDy95k', 285.00, 'Success', '2024-04-02 05:35:43'),
(87, 14, 'pay_NtdkqZhVbDy95k', 285.00, 'Success', '2024-04-02 05:36:10'),
(88, 24, 'pay_NteHrn8FBoGXvk', 845.00, 'Success', '2024-04-02 06:06:26'),
(95, 24, 'pay_NteHrn8FBoGXvk', 845.00, 'Success', '2024-04-02 06:22:07'),
(96, 24, 'pay_Ntec8HiVIAyZpM', 405.00, 'Success', '2024-04-02 06:25:37'),
(97, 46, 'pay_Ntg4QKhjY1aJUl', 345.00, 'Success', '2024-04-02 07:51:06'),
(98, 46, 'pay_NtgJVWhwatu5qU', 665.00, 'Success', '2024-04-02 08:05:25'),
(99, 1, 'pay_NxNHYtxUcgDEvr', 885.00, 'Success', '2024-04-11 16:04:22'),
(100, 1, 'pay_NxNMes4XCMmOII', 195.00, 'Success', '2024-04-11 16:09:11'),
(101, 1, 'pay_NxNOVkI6wOyFRi', 195.00, 'Success', '2024-04-11 16:10:57'),
(102, 1, 'pay_NxNRSNdsgIxRfl', 195.00, 'Success', '2024-04-11 16:13:47'),
(103, 1, 'pay_NxNRSNdsgIxRfl', 195.00, 'Success', '2024-04-11 16:15:36'),
(104, 1, 'pay_NxNXPyXUGHQFNp', 345.00, 'Success', '2024-04-11 16:19:24'),
(105, 1, 'pay_NxNXPyXUGHQFNp', 345.00, 'Success', '2024-04-11 16:20:47'),
(106, 1, 'pay_NxNaHFE9lk9Sul', 345.00, 'Success', '2024-04-11 16:22:06'),
(107, 1, 'pay_NxNc3kxwePoEZv', 195.00, 'Success', '2024-04-11 16:23:47'),
(108, 1, 'pay_NxNj2EgvQkgZKa', 1075.00, 'Success', '2024-04-11 16:30:23'),
(109, 47, 'pay_Nxb9ADvgIWyD7G', 165.00, 'Success', '2024-04-12 05:38:06'),
(110, 47, 'pay_NxbDlBtyVjfk8T', 285.00, 'Success', '2024-04-12 05:42:40'),
(111, 47, 'pay_NxdVExK5EOB7wy', 205.00, 'Success', '2024-04-12 07:56:24'),
(112, 47, 'pay_NxdVExK5EOB7wy', 205.00, 'Success', '2024-04-12 07:58:07'),
(113, 47, 'pay_NxdVExK5EOB7wy', 205.00, 'Success', '2024-04-12 07:58:09'),
(114, 47, 'pay_NxdZj4AEPMw42V', 205.00, 'Success', '2024-04-12 08:00:38'),
(115, 47, 'pay_NxddyOZcMJpeXn', 445.00, 'Success', '2024-04-12 08:04:40'),
(116, 47, 'pay_NxdhouENDkFXCb', 705.00, 'Success', '2024-04-12 08:08:20'),
(117, 1, 'pay_Nz97pvbelXLX8n', 545.00, 'Success', '2024-04-16 03:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(10) NOT NULL,
  `type` varchar(200) NOT NULL,
  `stock_quantity` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `type`, `stock_quantity`, `created_at`) VALUES
(1, 'Cappuccino', 'menu-1.jpg', 'Espresso, steamed milk, and frothy foam unite in a satisfying cappuccino.', 150, 'drink', 24, '2024-02-19 16:26:15'),
(2, 'Latte', 'menu-4.jpg', 'Creamy espresso blend with steamed milk, creating a comforting latte.', 210, 'drink', 85, '2024-02-19 16:35:46'),
(3, 'Choclate Coffee', 'menu-2.jpg', 'Rich cocoa and bold coffee combine for a decadent chocolate brew.\r\n\r\n\r\n\r\n\r\n', 400, 'drink', 90, '2024-02-19 16:30:25'),
(4, 'Iced coffee', 'menu-3.jpg', 'Chilled perfection: black coffee poured over ice for a refreshing treat.', 210, 'drink', 97, '2024-02-19 16:32:36'),
(5, 'Iced Americano', 'menu-6.jpg', 'A refreshing blend of espresso and water over ice, delivering a bold, smooth taste. ', 120, 'drink', 90, '2024-03-24 14:35:51'),
(6, 'Mocha', 'menu-7.jpeg', 'Rich espresso blended with creamy chocolate, topped with frothy milk.', 180, 'drink', 96, '2024-03-24 14:42:49'),
(7, 'Affogato', 'menu-8.jpeg', 'A decadent Italian treat, espresso poured over vanilla gelato.', 150, 'drink', 98, '2024-03-24 14:49:49'),
(8, 'Macchiato', 'menu-5.jpg', 'Bold espresso adorned with a touch of steamed milk perfection.', 300, 'drink', 100, '2024-02-20 13:47:29'),
(9, 'Lemonade', 'drink-1.jpg', 'Zesty citrus refreshment, a sweet and tangy classic summer lemonade drink.', 50, 'drink', 98, '2024-02-20 13:49:14'),
(10, 'Pancake', 'dessert-2.jpg', 'Fluffy stacks of golden pancakes, a breakfast favorite with maple syrup.', 250, 'dessert', 88, '2024-02-20 13:51:13'),
(14, 'Pizza', 'image_6.jpg', 'Deliciously cheesy, thin-crust pizza with savory toppings, a classic indulgence.\r\n\r\n\r\n\r\n\r\n', 210, 'appetizer', 95, '2024-02-20 15:28:25'),
(15, 'Apple Crisp', 'dessert-14.jpg', 'Deliciously baked apples with a crispy oat topping, served warm.', 150, 'dessert', 90, '2024-02-21 04:54:39'),
(16, 'Red Velvet Cupcake', 'dessert-15.jpg', 'Decadent red velvet cupcake topped with creamy frosting.', 100, 'dessert', 80, '2024-02-21 04:55:12'),
(17, 'Veg Spinach Noodle', 'image_2.jpg', 'Savory spinach noodles, colorful veggies, tofu bites; nutritious, flavorful delight.', 180, 'appetizer', 98, '2024-02-21 04:56:49'),
(18, 'Classic Cheeseburger', 'burger-1.jpg', 'Succulent chicken, oozing cheese, crisp veggies—pure satisfaction in every bite.', 150, 'appetizer', 0, '2024-02-22 15:23:25'),
(19, 'Spicy BBQ Burger', 'burger-2.jpg', 'Flame-grilled patty, spicy BBQ sauce, jalapeños, crispy onions—bold flavor.', 180, 'appetizer', 90, '2024-02-22 15:24:16'),
(20, 'Veggie Delight Burger', 'burger-3.jpg', 'Grilled portobello, avocado, Swiss cheese, mixed greens, mayo & tomatoes.', 160, 'appetizer', 98, '2024-02-22 15:27:06'),
(21, 'Blackberry Cheesecake', 'dessert-4.jpg', 'Creamy richness, crumbly crust, topped with luscious blackberries. ', 80, 'dessert', 85, '2024-02-22 15:34:14'),
(23, 'Vanilla Patisserie', 'dessert-6.jpg', 'Whipped perfection, subtle vanilla essence, a dance of divine sweetness.', 180, 'dessert', 96, '2024-02-22 15:54:12'),
(24, 'Spaghetti Bolognese', 'image_1.jpg', 'Slow-cooked meat sauce, al dente pasta, sprinkled with Parmesan—Italian comfort.\r\n\r\n\r\n\r\n\r\n', 200, 'appetizer', 100, '2024-02-22 16:25:03'),
(25, 'Veggie Paradise Pizza ', 'image_3.jpg', 'Bursting with colorful veggies, aromatic herbs, gooey cheese—irresistible goodness in every slice.', 300, 'appetizer', 100, '2024-02-22 16:40:03'),
(30, 'Croissant', 'dessert-7.jpg', 'Flaky, buttery pastry from France, popular worldwide. Light, airy, perfect for breakfast or a snack.\r\n\r\n\r\n\r\n\r\n', 80, 'dessert', 100, '2024-03-19 14:16:33'),
(34, 'Cold Brew', 'menu-9.jpeg', 'Smooth and refreshing, our Cold Brew is perfect for coffee lovers.', 150, 'drink', 96, '2024-03-24 14:52:10'),
(35, 'Chai Latte', 'menu-10.jpeg', 'Indulge in the aromatic blend of spices in our comforting Chai Latte.', 120, 'drink', 100, '2024-03-24 14:55:18'),
(36, 'Frappuccino', 'menu-11.jpeg', 'Indulge in our creamy Frappuccino blend, a delightful frosty treat.', 250, 'drink', 100, '2024-03-24 15:04:28'),
(37, 'Chocolate Brownie', 'dessert-8.jpeg', 'Decadent chocolate brownie: rich, fudgy, and topped with walnuts.', 150, 'dessert', 100, '2024-03-24 15:17:03'),
(38, 'New York Cheesecake', 'dessert-9.jpeg', 'Creamy, rich cheesecake on a graham cracker crust. A decadent delight.', 150, 'dessert', 100, '2024-03-24 15:20:09'),
(39, 'Tiramisu', 'dessert-10.jpeg', 'Creamy layers of mascarpone cheese, coffee-soaked ladyfingers, dusted with cocoa.', 120, 'dessert', 90, '2024-03-24 15:24:12'),
(40, 'Lemon Tart', 'dessert-11.jpeg', 'Luscious lemon tart with tangy citrus filling and buttery crust.', 150, 'dessert', 98, '2024-03-24 15:27:58'),
(41, 'Panna Cotta', 'dessert-12.jpeg', 'Creamy Italian dessert with vanilla bean, served with berry compote.', 140, 'dessert', 100, '2024-03-24 15:29:49'),
(42, 'Bread Pudding', 'dessert-13.jpeg', 'Warm and comforting dessert made with bread, eggs, milk, and spices.', 120, 'dessert', 96, '2024-03-24 15:33:24'),
(43, 'Bruschetta ', 'appetizer-1.jpg', 'Classic Italian appetizer: toasted bread topped with tomatoes, garlic, basil.', 200, 'appetizer', 100, '2024-03-25 03:51:34'),
(44, 'Nachos with Salsa', 'appetizer-2.jpg', 'Crunchy corn chips topped with zesty salsa and creamy guacamole.', 250, 'appetizer', 100, '2024-03-25 03:56:39'),
(45, 'Mini Quiches', 'appetizer-3.jpg', 'Delicious bite-sized quiches filled with savory goodness. Perfect for sharing.', 200, 'appetizer', 100, '2024-03-25 03:59:46'),
(46, 'Shrimp Cocktail', 'appetizer-4.jpeg', 'Plump shrimp served chilled with tangy cocktail sauce and lemon.', 300, 'appetizer', 98, '2024-03-25 04:02:06'),
(47, 'Chicken Wings', 'appetizer-5.jpg', 'Deliciously crispy chicken wings, seasoned to perfection, served with dipping sauce.', 250, 'appetizer', 98, '2024-03-25 04:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `image` varchar(220) NOT NULL,
  `review` text NOT NULL,
  `rating` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `image`, `review`, `rating`, `username`, `created_at`) VALUES
(1, 'cap.jpeg', 'The cappuccino was a blend of rich espresso, velvety steamed milk, and a perfect layer of foamy micro-foam. The balance of flavors was impeccable, creating a satisfying and indulgent experience.', 2, 'Arunabh', '2024-02-21 14:51:30'),
(2, 'blend.jpeg', 'Coffee-blend service excels with rich flavors, pleasing aroma, impeccable presentation.', 4, 'Arunabh', '2024-02-21 15:17:08'),
(3, 'DeWatermark.ai_1713159575321.jpeg', 'The ambiance was cozy, with soft lighting and comfortable seating, creating a warm and inviting atmosphere perfect for a relaxed evening.', 4, 'Pradeep', '2024-04-15 05:39:42'),
(4, 'DeWatermark.ai_1713158216738.jpeg', 'Impressive quality, exceeded expectations. Prompt shipping. Will order again soon. Highly recommended for anyone seeking top-notch products.', 4, 'Pratyush', '2024-04-15 05:18:30'),
(5, 'DeWatermark.ai_1713158019768.jpeg', 'Excellent product, fast delivery, highly recommended. Will definitely purchase again. Five stars all around!', 5, 'Uttam', '2024-04-15 05:13:55'),
(6, 'aromatic.jpeg', 'Cozy spot, aromatic brews, friendly staff; perfect for a caffeine fix. Limited seating, but the vibe compensates. Recommended!', 2, 'Arunabh', '2024-02-22 06:45:49'),
(9, '', 'Great service, quick delivery. The product exceeded my expectations. Definitely recommend this company!', 4, 'Pratyush', '2024-04-15 05:23:32'),
(14, 'about.jpg', 'Quaint ambiance, aromatic brews, cozy corners for conversation. Friendly staff, delectable pastries. A haven for coffee lovers seeking solace and stimulation. Highly recommended!', 4, 'Arunabh', '2024-03-20 05:40:42'),
(15, '', 'Fantastic experience overall. The product arrived quickly and was exactly as described. Will definitely buy from here again!', 3, 'Abhijeet', '2024-04-15 05:29:43'),
(16, 'DeWatermark.ai_1713159042569.jpeg', 'Superb customer service, fast shipping. Product exceeded expectations, excellent quality. Highly recommend this company for all your needs!', 5, 'Abhijeet', '2024-04-15 05:30:57'),
(17, 'DeWatermark.ai_1713159259697.jpeg', 'Fast delivery, top-notch product quality, and exceptional service. Exceeded expectations in every way. Highly recommend for anyone seeking reliable and satisfying shopping experiences.', 4, 'Pradeep', '2024-04-15 05:34:24'),
(18, 'amb.jpeg', 'Outstanding coffee and welcoming ambiance. The staff is friendly, creating a delightful experience. A perfect blend of taste and atmosphere, making it a must-visit for coffee enthusiasts.', 4, 'Arunabh', '2024-02-22 06:27:15'),
(19, 'staff.jpeg', 'An exceptional experience! The cozy ambiance, friendly staff, and delectable coffee made my visit delightful. I highly recommend this place. A perfect blend of taste and atmosphere.', 3, 'Arunabh', '2024-02-22 06:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `street_address` varchar(200) NOT NULL,
  `town` varchar(200) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `street_address`, `town`, `zip_code`, `phone`, `password`, `created_at`) VALUES
(1, 'Arunabh', 'Das', 'Arunabh', 'arun@gmail.com', '', '', '', '', '$2y$10$n/mAtlbnRI3qS8Vo6ZVv9e8u/9.8N79SC5RLjVuYgVa1KJ5IU6ZDe', '2024-02-19 15:54:27'),
(14, 'Pratush', 'Kumar', 'Pratyush', 'pratyush@gmail.com', '', '', '', '', '$2y$10$MQiUSRJDd2pM0hlgVe.hu.xntLfqNdu/LhPPaH6kunXFZDmbfIzTa', '2024-02-23 07:17:12'),
(24, 'Abhijit', 'Mahato', 'Abhijeet', 'abhijit@gmail.com', '', '', '', '', '$2y$10$qizqFfDaWzSVRxNjPqAnD.Xx4LkX6qJRHqt4Fc1hkajvuEN9jGl4a', '2024-02-23 07:34:41'),
(46, 'Pradeep', 'Mahto', 'Pradeep', 'pradeep@gmail.com', '', '', '', '', '$2y$10$qWqFFH/913sKzyp6Eqg5puTV.gXTF2jl5GP9MHKOS5afZrveIZJ/i', '2024-03-30 05:18:12'),
(47, 'Uttam', 'Gorai', 'Uttam', 'uttam@gmail.com', 'HNo14, Ulidih', 'Jamshedpur', '831011', '8698874856', '$2y$10$n/mAtlbnRI3qS8Vo6ZVv9e8u/9.8N79SC5RLjVuYgVa1KJ5IU6ZDe', '2024-04-07 04:08:53'),
(51, 'Priya', 'Kumari', 'Priya', 'priya@gmail.com', '', '', '', '', '$2y$10$3NiesB8eXR9C5DhZjVKCzeE57RebIPYltJrgDzYK/lYPZpFS6TTaG', '2024-04-15 06:52:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminname` (`adminname`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_inquiries`
--
ALTER TABLE `customer_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `payment_id` (`pay_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `customer_inquiries`
--
ALTER TABLE `customer_inquiries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pay_id`) REFERENCES `payments` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
