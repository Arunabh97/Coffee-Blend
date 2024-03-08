-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 05:42 PM
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
(1, 'admin.first', 'admin.first@gmail.com', '$2y$10$7tLmHdyEo1D3COiRRRwhN.vntX5kipFyGpOjd00sSJrpVC7xKrL86', '2024-02-19 15:59:30'),
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
  `date` varchar(200) NOT NULL,
  `time` varchar(200) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(200) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `first_name`, `last_name`, `date`, `time`, `phone`, `message`, `status`, `user_id`, `created_at`) VALUES
(3, 'Rupesh', 'Pandey', '2/24/2024', '2:00am', '7004396959', 'I  need seat which is cozy for 2hrs.', 'Done', 34, '2024-02-23 13:04:58'),
(5, 'Rupesh', 'Pandey', '2/24/2024', '12:00am', '7004396959', 'I need to book a table for 2 seater.', 'Done', 34, '2024-02-23 13:09:57'),
(6, 'Rupesh', 'Pandey', '2/24/2024', '1:00pm', '7004396959', 'I need only one book', 'Pending', 34, '2024-02-23 13:13:23'),
(7, 'Rupesh', 'Pandey', '3/24/2024', '1:30am', '7004396959', 'I need a table', 'Confirmed', 34, '2024-02-23 13:14:01'),
(8, 'Pradeep', 'Mahto', '2/25/2024', '12:00am', '7004396959', 'I have a contion', 'Pending', 35, '2024-02-24 04:45:24');

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
(22, 'Cappuccino', 'menu-1.jpg', '150', 1, 'Espresso, steamed milk, and frothy foam unite in a satisfying cappuccino.', 1, 28, '2024-02-23 07:48:03'),
(23, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 31, '2024-02-23 07:50:33'),
(24, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 32, '2024-02-23 07:55:58'),
(25, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 33, '2024-02-23 08:13:39'),
(28, 'Latte', 'menu-4.jpg', '210', 2, 'Creamy espresso blend with steamed milk, creating a comforting latte.', 1, 34, '2024-02-23 13:19:12'),
(29, 'Cappuccino', 'menu-1.jpg', '150', 1, 'Espresso, steamed milk, and frothy foam unite in a satisfying cappuccino.', 2, 35, '2024-02-24 04:44:41'),
(32, 'Banana Cherry Chocolate', 'dessert-5.jpg', '250', 22, 'Moist layers, fruity bliss, decadent chocolate drizzle. Delightful indulgence.', 1, 38, '2024-02-24 09:15:00'),
(63, 'Cappuccino', 'menu-1.jpg', '150', 1, 'Espresso, steamed milk, and frothy foam unite in a satisfying cappuccino.', 4, 1, '2024-03-07 03:46:47'),
(64, 'Veg Spinach Noodle', 'image_2.jpg', '180', 17, 'Savory spinach noodles, colorful veggies, tofu bites; nutritious, flavorful delight.', 2, 1, '2024-03-07 03:54:32');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_inquiries`
--

INSERT INTO `customer_inquiries` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(4, 'Arunabh', 'arun@gmail.com', 'Sitting issue', 'I am facing sitting issue in your coffee shop', '2024-02-22 07:15:33'),
(6, 'pradeep', 'pradeep@gmail.com', 'i have a query', 'I HAVE PROBLEM', '2024-02-24 04:49:04'),
(7, 'pradeep', 'pradeep@gmail.com', 'i have a query', 'I HAVE PROBLEM', '2024-02-24 04:50:20'),
(8, 'Arunabh', 'arun@gmail.com', 'I have a problem', 'Kindly help', '2024-02-24 05:14:21');

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
  `total_price` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `state`, `street_address`, `town`, `zip_code`, `phone`, `email`, `user_id`, `status`, `total_price`, `created_at`) VALUES
(1, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'jsr', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 1005, '2024-02-20 13:58:01'),
(2, 'Arunabh', 'Das', 'Jharkhand', 'Diman', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 1185, '2024-02-23 09:08:42'),
(6, 'Rupesh', 'Pandey', 'West Bengal', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'rupesh@gmail.com', 34, 'Delivered', 255, '2024-02-23 13:19:40'),
(7, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 1065, '2024-02-27 14:33:00'),
(8, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 1065, '2024-02-27 14:58:52'),
(36, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Cancelled', 46, '2024-03-03 08:10:09'),
(52, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 615, '2024-03-06 14:37:38'),
(57, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 1005, '2024-03-08 13:59:34'),
(58, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 1005, '2024-03-08 14:16:46'),
(59, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Pending', 1005, '2024-03-08 14:28:07'),
(61, 'Arunabh', 'Das', 'Jharkhand', 'Dimna', 'Jamshedpur', 831012, '7004396959', 'arun@gmail.com', 1, 'Delivered', 1005, '2024-03-08 14:40:39');

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
(5, 1, 61, 'Cappuccino', 4, 150.00, 'menu-1.jpg'),
(6, 17, 61, 'Veg Spinach Noodle', 2, 180.00, 'image_2.jpg');

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
(39, 1, 'pay_NiLMYVNInW4SMm', 345.00, 'Success', '2024-03-04 16:26:42');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `type`, `created_at`) VALUES
(1, 'Cappuccino', 'menu-1.jpg', 'Espresso, steamed milk, and frothy foam unite in a satisfying cappuccino.', 150, 'drink', '2024-02-19 16:26:15'),
(2, 'Latte', 'menu-4.jpg', 'Creamy espresso blend with steamed milk, creating a comforting latte.', 210, 'drink', '2024-02-19 16:35:46'),
(3, 'Choclate Coffee', 'menu-2.jpg', 'Rich cocoa and bold coffee combine for a decadent chocolate brew.\n\n\n\n\n', 400, 'drink', '2024-02-19 16:30:25'),
(4, 'Iced coffee', 'menu-3.jpg', '\nChilled perfection: black coffee poured over ice for a refreshing treat.', 210, 'drink', '2024-02-19 16:32:36'),
(8, 'Macchiato', 'menu-5.jpg', 'Bold espresso adorned with a touch of steamed milk perfection.', 300, 'drink', '2024-02-20 13:47:29'),
(9, 'Lemonade', 'drink-1.jpg', 'Zesty citrus refreshment, a sweet and tangy classic summer lemonade drink.', 50, 'drink', '2024-02-20 13:49:14'),
(10, 'Pancake', 'dessert-2.jpg', '\r\nFluffy stacks of golden pancakes, a breakfast favorite with maple syrup.', 250, 'dessert', '2024-02-20 13:51:13'),
(14, 'Pizza', 'image_6.jpg', 'Deliciously cheesy, thin-crust pizza with savory toppings, a classic indulgence.\r\n\r\n\r\n\r\n\r\n', 210, 'appetizer', '2024-02-20 15:28:25'),
(15, 'Red Cake', 'dessert-1.jpg', '\r\nMoist, vibrant red cake layered with luscious cream cheese frosting. Delightful!', 220, 'dessert', '2024-02-21 04:54:39'),
(16, 'Fruit Cake', 'dessert-3.jpg', 'Nutty fruit cake, candied fruits, spices blend, holiday warmth, indulgence.', 250, 'dessert', '2024-02-21 04:55:12'),
(17, 'Veg Spinach Noodle', 'image_2.jpg', 'Savory spinach noodles, colorful veggies, tofu bites; nutritious, flavorful delight.', 180, 'appetizer', '2024-02-21 04:56:49'),
(18, 'Classic Cheeseburger', 'burger-1.jpg', 'Succulent chicken, oozing cheese, crisp veggies—pure satisfaction in every bite.', 150, 'appetizer', '2024-02-22 15:23:25'),
(19, 'Spicy BBQ Burger', 'burger-2.jpg', 'Flame-grilled patty, spicy BBQ sauce, jalapeños, crispy onions—bold flavor.', 180, 'appetizer', '2024-02-22 15:24:16'),
(20, 'Veggie Delight Burger', 'burger-3.jpg', 'Grilled portobello, avocado, Swiss cheese, mixed greens, mayo & tomatoes.', 160, 'appetizer', '2024-02-22 15:27:06'),
(21, 'Blackberry Cheesecake', 'dessert-4.jpg', 'Creamy richness, crumbly crust, topped with luscious blackberries. ', 40, 'dessert', '2024-02-22 15:34:14'),
(22, 'Banana Cherry Chocolate', 'dessert-5.jpg', 'Moist layers, fruity bliss, decadent chocolate drizzle. Delightful indulgence.', 250, 'dessert', '2024-02-22 15:38:53'),
(23, 'Vanilla Patisserie', 'dessert-6.jpg', 'Whipped perfection, subtle vanilla essence, a dance of divine sweetness.', 180, 'dessert', '2024-02-22 15:54:12'),
(24, 'Spaghetti Bolognese', 'image_1.jpg', 'Slow-cooked meat sauce, al dente pasta, sprinkled with Parmesan—Italian comfort.\r\n\r\n\r\n\r\n\r\n', 200, 'appetizer', '2024-02-22 16:25:03'),
(25, 'Veggie Paradise Pizza ', 'image_3.jpg', 'Bursting with colorful veggies, aromatic herbs, gooey cheese—irresistible goodness in every slice.', 300, 'appetizer', '2024-02-22 16:40:03'),
(26, 'Mojito', 'drink-7.jpg', 'Mojito', 1, 'drink', '2024-03-02 05:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) NOT NULL,
  `review` text NOT NULL,
  `rating` int(10) NOT NULL,
  `username` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review`, `rating`, `username`, `created_at`) VALUES
(1, 'The cappuccino was a delightful blend of rich espresso, velvety steamed milk, and a perfect layer of foamy micro-foam. The balance of flavors was impeccable, creating a satisfying and indulgent experience.', 2, 'Arunabh', '2024-02-21 14:51:30'),
(2, 'Coffee-blend service excels with rich flavors, pleasing aroma, impeccable presentation.', 4, 'Arunabh', '2024-02-21 15:17:08'),
(3, 'An exceptional experience! The cozy ambiance, friendly staff, and delectable coffee made my visit delightful. I highly recommend this place. A perfect blend of taste and atmosphere.', 3, 'Arunabh', '2024-02-22 06:24:55'),
(5, 'Outstanding coffee and welcoming ambiance. The staff is friendly, creating a delightful experience. A perfect blend of taste and atmosphere, making it a must-visit for coffee enthusiasts.', 4, 'Arunabh', '2024-02-22 06:27:15'),
(6, 'Cozy spot, aromatic brews, friendly staff; perfect for a caffeine fix. Limited seating, but the vibe compensates. Recommended!', 2, 'Arunabh', '2024-02-22 06:45:49');

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
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Arunabh', 'Das', 'Arunabh', 'arun@gmail.com', '$2y$10$P3JgBBl9676SsQUncFIIju/XPAjlmg2VWDi1aB60la5.p1QIYnIka', '2024-02-19 15:54:27'),
(14, 'Pratush', 'Kumar', 'Pratyush', 'pratyush@gmail.com', '$2y$10$MQiUSRJDd2pM0hlgVe.hu.xntLfqNdu/LhPPaH6kunXFZDmbfIzTa', '2024-02-23 07:17:12'),
(24, 'Abhijit', 'Mahato', 'Abhi', 'abhijit@gmail.com', '$2y$10$vQdPaHcpNRwjk.RvC6MnpunsRLL5h35FLw.58kBpJy/GJPt5iEbvK', '2024-02-23 07:34:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `customer_inquiries`
--
ALTER TABLE `customer_inquiries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

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
