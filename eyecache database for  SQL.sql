-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2025 at 02:20 PM
-- Server version: 8.0.42
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eyecache`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` int DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `quantity` int DEFAULT '1',
  `added_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `size`, `color`, `quantity`, `added_at`) VALUES
(1, 'nfn99a4i0btdo7kbsd5avllfmp', 1, NULL, NULL, 1, '2025-09-09 06:16:29'),
(2, 'nfn99a4i0btdo7kbsd5avllfmp', 5, NULL, NULL, 1, '2025-09-09 06:17:21'),
(3, '8fcs4oum2mkrvkpfdg8a9gjsrd', 1, NULL, NULL, 3, '2025-09-11 02:35:23'),
(4, '8fcs4oum2mkrvkpfdg8a9gjsrd', 5, NULL, NULL, 1, '2025-09-11 02:39:32'),
(5, 'nfn99a4i0btdo7kbsd5avllfmp', 7, 'M', 'Black', 1, '2025-09-15 05:46:25'),
(6, 'nfn99a4i0btdo7kbsd5avllfmp', 5, 'S', 'Magenta', 1, '2025-09-15 08:19:54'),
(7, 'nfn99a4i0btdo7kbsd5avllfmp', 5, 'S', 'Blue', 1, '2025-09-15 08:20:55'),
(8, 'nfn99a4i0btdo7kbsd5avllfmp', 8, 'null', 'Green', 1, '2025-09-15 08:25:55'),
(9, 'nfn99a4i0btdo7kbsd5avllfmp', 7, 'S', 'Black', 2, '2025-09-15 08:51:59'),
(10, 'nfn99a4i0btdo7kbsd5avllfmp', 8, 'M', 'Blue', 1, '2025-09-15 08:56:05'),
(11, 'nfn99a4i0btdo7kbsd5avllfmp', 1, 'M', 'Red', 1, '2025-09-15 09:02:27'),
(12, 'nfn99a4i0btdo7kbsd5avllfmp', 1, 'S', 'Purple', 1, '2025-09-15 09:05:53'),
(13, 'nfn99a4i0btdo7kbsd5avllfmp', 1, 'S', 'Red', 1, '2025-09-15 09:13:15'),
(14, 'nfn99a4i0btdo7kbsd5avllfmp', 7, 'M', 'Yellow', 1, '2025-09-15 09:18:33'),
(15, 'nfn99a4i0btdo7kbsd5avllfmp', 5, 'S', 'Magenta', 1, '2025-09-15 09:18:41'),
(16, 'nfn99a4i0btdo7kbsd5avllfmp', 5, 'S', 'Magenta', 1, '2025-09-15 09:18:55'),
(17, 'nfn99a4i0btdo7kbsd5avllfmp', 3, 'null', 'Blue', 1, '2025-09-15 09:19:03'),
(18, 'nfn99a4i0btdo7kbsd5avllfmp', 8, 'S', 'Blue', 1, '2025-09-15 09:19:28'),
(19, 'nfn99a4i0btdo7kbsd5avllfmp', 1, 'S', 'Red', 1, '2025-09-15 09:19:36'),
(20, 'nfn99a4i0btdo7kbsd5avllfmp', 4, 'M', 'Red', 1, '2025-09-15 09:32:45'),
(21, 'nfn99a4i0btdo7kbsd5avllfmp', 8, 'S', 'Black', 1, '2025-09-15 09:36:06'),
(25, 'nfn99a4i0btdo7kbsd5avllfmp', 8, 'S', 'Blue', 1, '2025-09-15 09:42:21'),
(26, 'nfn99a4i0btdo7kbsd5avllfmp', 4, 'S', 'Red', 1, '2025-09-15 09:43:21'),
(27, 'nfn99a4i0btdo7kbsd5avllfmp', 7, 'M', 'Yellow', 1, '2025-09-16 18:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_general_ci DEFAULT 'Active',
  `description` text COLLATE utf8mb4_general_ci,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `slug`, `parent_id`, `status`, `description`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'Hellow', 'hello', NULL, 'Active', 'hi', 'uploads/categories/1757931126_scene00001.png', '2025-09-15 10:12:06', '2025-09-15 17:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(2, 'winner', 'maxittiktok@gmail.com', '0710935966', '2025-09-15 17:09:42'),
(3, 'Sithika Cooray', 'sandivesithika@gmail.com', '0721687376', '2025-09-15 17:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(2, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'dnkdkd', '2025-09-11 03:06:10'),
(3, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'wmlwlmowo', '2025-09-11 03:06:33'),
(4, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'wnkwlmww', '2025-09-11 03:06:42'),
(5, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'ddddd', '2025-09-11 03:07:01'),
(6, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'aaaaaaaaa', '2025-09-11 03:07:30'),
(7, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', 'jjjjjjjjjjjjjjjjjjjjjjjjj', '2025-09-11 05:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expected_date` date DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_name`, `quantity`, `price`, `order_date`, `expected_date`, `status`) VALUES
(1, 1, 'Ocean Dust', 2, 8800.00, '2025-09-15 17:04:01', '2025-09-20', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `orders1`
--

CREATE TABLE `orders1` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders1`
--

INSERT INTO `orders1` (`id`, `customer_id`, `order_date`, `total_amount`, `shipping_address`, `status`) VALUES
(2, 2, '2026-09-08', 100.00, 'hello', 'Pending'),
(3, 2, '2025-09-19', 1500.00, '124 street nugegoda', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `color`, `price`, `image`) VALUES
(1, 'SolarFlare Tee', 'Red', 3990.00, 'assets/Black - Moon - Dad Cap.jpeg'),
(2, 'Midnight Mirage Hoodie', 'Black', 6990.00, 'assets/download (19).jpeg'),
(3, 'Eclipse Cap', 'White', 1990.00, 'assets/download (20).jpeg'),
(4, 'Solstice Red', 'Deep Crimson', 4500.00, 'assets/Essential Heavyweight Oversized Hoodie - Mid Green _ S.jpeg'),
(5, 'Eclipse Black', 'Pure Black', 6990.00, 'assets/ivory.jpeg'),
(6, 'Ivory Bloom', 'Soft Cream', 4200.00, 'assets/MARISA OVERSIZED HOODIE - Medium _ Black.jpeg'),
(7, 'Citrine Glow', 'Light Yellow', 4300.00, 'assets/Shen Fashion_ The Rising Star in Sustainable Luxury » Styling Outfits.jpeg'),
(8, 'Ocean Dust', 'Dusty Teal', 4400.00, 'assets/WhatsApp Image 2025-06-18 at 21.40.33_1ce8d19f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `products1`
--

CREATE TABLE `products1` (
  `id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sku` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int DEFAULT '0',
  `status` enum('In Stock','Out of Stock','Low Stock','Draft') COLLATE utf8mb4_general_ci DEFAULT 'Draft',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products1`
--

INSERT INTO `products1` (`id`, `product_name`, `description`, `category`, `sku`, `price`, `stock`, `status`, `image`, `created_at`) VALUES
(2, 'helloww123', 'hello', 'Hello', 'hello', 100.00, 199, 'In Stock', 'uploads/1757944878_scene00001.png', '2025-09-15 14:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `userdetails`
--

CREATE TABLE `userdetails` (
  `user_id` int NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userdetails`
--

INSERT INTO `userdetails` (`user_id`, `full_name`, `email`, `address`, `city`, `postal_code`, `phone`, `password`, `created_at`) VALUES
(1, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', '250/1,Egodawaththa,Rilhena,pelmadulla', 'Borella', '70070', '0710108280', '$2y$10$rlC/d30nzEovELVkdbrJYe9wcm7CBUkk/5l4/c1XaBrB6F4O6YdTO', '2025-09-15 16:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('super_admin','manager','staff') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'John Doe', 'admin@example.com', '$2y$10$PTfzW5P1/NMf9uNbA74KZORViBAjBVff97IqmttBTdd8HZw2Fe45K', 'super_admin', '2025-09-15 06:57:17'),
(3, 'Sithika Cooray', 'sandivesithika@gmail.com', '$2y$10$fSaiEi7wY7k6HQBk2n76.eBt111HjPZjoWq4UzmE31q/ObzNBHoYm', 'super_admin', '2025-09-15 12:13:28'),
(6, 'hansi', 'sihu@email.com', '$2y$10$GurvUXn.3aBoUmS4v.XvCuYSxVPW0iinRVucF1V5CZqCncVh.k2Ue', 'staff', '2025-09-15 18:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `users_tba`
--

CREATE TABLE `users_tba` (
  `id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('super_admin','manager','staff') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `role`) VALUES
(3, 'pramodya dewmini', 'pdewmini@gmail.com', '$2y$10$6zTEXXWZ18wtl50i.OWP1u5Ah4QPt8toeT0HUB5Z/K71kpSD6qKXq', 'super_admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders1`
--
ALTER TABLE `orders1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products1`
--
ALTER TABLE `products1`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `userdetails`
--
ALTER TABLE `userdetails`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_tba`
--
ALTER TABLE `users_tba`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders1`
--
ALTER TABLE `orders1`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `userdetails`
--
ALTER TABLE `userdetails`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_tba`
--
ALTER TABLE `users_tba`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdetails` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
