-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql105.ezyro.com
-- Generation Time: Oct 09, 2025 at 10:13 AM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ezyro_40089048_eyecache`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `role`) VALUES
(3, 'pramodya dewmini', 'pdewmini@gmail.com', '$2y$10$6zTEXXWZ18wtl50i.OWP1u5Ah4QPt8toeT0HUB5Z/K71kpSD6qKXq', 'super_admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `size`, `color`, `quantity`, `added_at`) VALUES
(78, 13, 12, 'S', 'Blue', 1, '2025-10-09 03:12:08'),
(79, 13, 11, 'S', 'Yellow', 1, '2025-10-09 03:12:31'),
(80, 8, 11, 'S', 'Black', 1, '2025-10-09 04:08:20'),
(81, 16, 11, 'S', 'Black', 1, '2025-10-09 04:29:13'),
(82, 16, 12, 'M', 'Black', 1, '2025-10-09 04:30:53'),
(85, 8, 11, 'S', 'White', 1, '2025-10-09 05:47:51'),
(87, 19, 11, 'S', 'Yellow', 1, '2025-10-09 08:00:40'),
(88, 19, 15, 'S', 'Blue', 1, '2025-10-09 08:01:01'),
(89, 8, 11, 'S', 'Black', 1, '2025-10-09 08:01:59'),
(90, 24, 11, 'S', 'Yellow', 1, '2025-10-09 08:10:07'),
(92, 24, 15, 'S', 'Black', 1, '2025-10-09 08:10:46'),
(93, 21, 11, 'S', 'Yellow', 1, '2025-10-09 08:22:39'),
(95, 21, 12, 'S', 'Black', 1, '2025-10-09 10:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `slug`, `parent_id`, `status`, `description`, `image_path`, `created_at`, `updated_at`) VALUES
(3, 'Female / Casual Wear', 'femalecasualwear', NULL, 'Active', '', NULL, '2025-10-09 04:53:18', '2025-10-09 04:54:44'),
(5, 'Women / Casual Wear', 'womencasualwear', NULL, 'Active', '', NULL, '2025-10-09 04:54:12', '2025-10-09 04:54:12'),
(6, 'Unisex / Casual Wear / Style', 'unisexcasualwearstyle', NULL, 'Active', '', NULL, '2025-10-09 04:55:46', '2025-10-09 04:55:46');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES
(2, 'winner', 'maxittiktok@gmail.com', '0710935966', '2025-09-15 17:09:42'),
(4, 'Sithika Cooray', 'sandivesithika@gmail.com', '0721687376', '2025-10-09 08:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping_address` text DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `expected_date` date DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `shipping_address`, `product_name`, `quantity`, `price`, `order_date`, `expected_date`, `status`) VALUES
(1, 1, NULL, 'Ocean Dust', 2, '8800.00', '2025-09-15 17:04:01', '2025-09-20', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `colors` varchar(255) DEFAULT NULL,
  `sizes` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `status` enum('In Stock','Out of Stock','Low Stock','Draft') DEFAULT 'Draft',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `sku`, `colors`, `sizes`, `price`, `stock`, `status`, `image`, `created_at`, `category_id`) VALUES
(11, 'Citrine Glow', 'A stylish women\'s casual wear top with a bright citrine tone and comfortable fabric.', '10022644', 'Yellow:#FFFF00,Black:#000000,White:#FFFFFF,Red:#FF0000', 'S,M,L,XL,2XL', '4300.00', 20, 'In Stock', '/assets/images/yellow.jpg', '2025-10-08 18:19:41', 5),
(12, 'Eclipse Black', 'A stylish women\'s casual wear top in elegant black shades, offering comfort and vibrant color options.', '10022643', 'Black:#000000,Blue:#1e90ff,Magenta:#FF00FF,Yellow:#FFFF00', 'S,M,L,XL,2XL', '3500.00', 25, 'In Stock', '/assets/images/download (20).jpeg', '2025-10-08 18:37:22', 5),
(13, 'Eclipse Cap', 'A stylish unisex cap perfect for casual wear and street style, available in multiple vibrant colors.', '10022634', 'Black:#000000,Blue:#1e90ff,Green:#097969,Red:#FF0000,White:#FFFFFF', '', '2500.00', 30, 'In Stock', '/assets/images/Black - Moon - Dad Cap.jpeg', '2025-10-08 18:40:45', 6),
(14, 'Ivory Bloom', 'A charming women\'s casual wear top featuring soft ivory tones and elegant color blends.', '10022646', 'White:#FFFFFF,Beige:#F5F5DC,Pink:#FFC0CB,Gold:#FFD700', 'S,M,L,XL,2XL', '4200.00', 22, 'In Stock', '/assets/images/ivory.jpeg', '2025-10-08 18:44:35', 5),
(15, 'Midnight Mirage', 'An elegant women\'s casual wear piece blending deep midnight hues with a sleek modern look.', '10022645', 'Black:#000000,Blue:#1e90ff,Purple:#800080,White:#FFFFFF', 'S,M,L,XL,2XL', '4500.00', 24, 'In Stock', '/assets/images/MARISA OVERSIZED HOODIE - Medium _ Black.jpeg', '2025-10-08 18:46:08', 5),
(16, 'Ocean Dust', 'A refreshing women\'s casual wear design inspired by ocean hues and soft, vibrant tones.', '10022645', 'Blue:#1e90ff,Black:#000000,Red:#FF0000,Yellow:#FFFF00', 'S,M,L,XL,2XL', '4700.00', 26, 'In Stock', '/assets/images/WhatsApp Image 2025-06-18 at 21.45.25_46520ade.jpg', '2025-10-08 18:47:08', 5),
(17, 'SolarFlare Tee', 'A bold women\'s casual wear tee radiating vibrant solar-inspired colors with a modern design.', '10022635', 'Red:#FF0000,Black:#000000,Purple:#800080,Yellow:#FFFF00', 'S,M,L,XL,2XL', '4600.00', 28, 'In Stock', '/assets/images/solarflare.jpeg', '2025-10-08 18:49:03', 5),
(18, 'Solstice Red', 'A vibrant female casual wear piece blending bold red tones with a sleek, comfortable fit.', '10022637', 'Red:#FF0000,Black:#000000,Blue:#1e90ff,Green:#097969,White:#FFFFFF', 'S,M,L,XL', '4300.00', 27, 'In Stock', '/assets/images/solstice_red.jpeg', '2025-10-08 18:50:08', 3),
(19, 'Smart Item', 'hello', '10022637', '', '', '100.00', 100, 'In Stock', NULL, '2025-10-09 06:02:27', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') NOT NULL DEFAULT 'student',
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `address`, `city`, `postal_code`, `phone`, `password`, `role`, `is_approved`, `created_at`) VALUES
(1, 'John Doe', 'admin@example.com', '', '', '', '', '$2y$10$PTfzW5P1/NMf9uNbA74KZORViBAjBVff97IqmttBTdd8HZw2Fe45K', 'student', 1, '2025-09-15 06:57:17'),
(3, 'Sithika Cooray', 'sandivesithika@gmail.com', '', '', '', '', '$2y$10$fSaiEi7wY7k6HQBk2n76.eBt111HjPZjoWq4UzmE31q/ObzNBHoYm', 'admin', 1, '2025-09-15 12:13:28'),
(6, 'hansi', 'sihu@email.com', '', '', '', '', '$2y$10$GurvUXn.3aBoUmS4v.XvCuYSxVPW0iinRVucF1V5CZqCncVh.k2Ue', '', 1, '2025-09-15 18:56:04'),
(7, 'Sithika', 'mini@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$9xo7crToMA1ZMsveQDwwQO0neVEPXlJUaob8sSCFI2z88TemZYbA.', 'admin', 1, '2025-10-05 18:19:17'),
(8, 'Siththa', 'minione@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$uFhm9iQG7DW7efOt.3HAFO1SaQrB3f01zu2tqgFcjwuDUO6VVqn1.', 'student', 1, '2025-10-05 18:20:02'),
(9, 'Sithika Cooray', 'dew@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$YfBjSvZCLVlmcErXogVboOeZXO/bVig7I0GGwUIoI4rgC52UtDNiy', 'student', 1, '2025-10-05 18:39:01'),
(10, 'Woody Bench', 'hel@gmail.com', '4500 GENTLE STREET CALIFORNIA', 'California', '76191', '6457329164', '$2y$10$D3qMOqifc5xeifFDTC6YR.etmXZIJF/HeM8Me55s.Rh.VYK9UsdMu', 'student', 1, '2025-10-05 18:43:43'),
(11, 'Imasha Fernando', 'imashafernando@gmail.com', '85/1,  Kochchikade, Negombo', 'Negombo', '11540', '0123456789', '$2y$10$1pcr9khhrG9KO1LJBleG/uxJwsc4YZDiNlO9oxu5qnhIa3.B3Ut9O', 'student', 1, '2025-10-07 10:34:13'),
(12, 'Pramodya Dewmini', 'pramodyadewmini5@gmail.com', '250/1,Egodawaththa,Rilhena,pelmadulla', 'Borella', '70070', '0710108280', '$2y$10$n56TvkaTrcrMhRe7SgKDTOVyY4eeeMgpYvzHp4JbkqDf7v2Pl3lQy', 'student', 1, '2025-10-08 04:31:46'),
(14, 'hasini', 'hashinidew@gmail.com', '250/1,Egodawaththa', 'haputhale', '60060', '0710108238', '$2y$10$gksTAqUACRdxQCsTEhHFh.eBnWBxm8ROqC9XobpADpV/TPqPkQwGC', 'student', 1, '2025-10-08 06:51:46'),
(15, 'Bulathsinhalage Sithika Sandive Thavemika Cooray', 'ex@gmail.com', '221/11, Jinarathana Mawatha, Batakeththara, Piliyandala.', 'Piliyandala', '10300', '0710935966', '$2y$10$k3j1I31uHTIipTHlrmIKxekeinP3oE.J3sR3tGLlAjiydQo98.owe', 'admin', 1, '2025-10-08 08:37:47'),
(16, 'Sineli', 'sinelisilva@gmail.com', '245, Cinnamon rd, Kochchikade', 'Kochchikade', '11540', '0123456789', '$2y$10$kozgVrONcPNgwZRFViJJ/.bZpI/Vkf2sFpM3XGdmVtuze3E2uBPSm', 'student', 1, '2025-10-08 12:10:38'),
(17, 'shithuli', 'sithushi@gmail.com', '110.rihanra road', 'kandalama', '60060', '0710108238', '$2y$10$5jjWKWgBjxk4MK1e57w4jewzTE3g6QeIHjOHK6KMqDc63VB4MZHeu', 'student', 1, '2025-10-08 12:20:16'),
(18, 'Pramodya Dewmini', 'pramodyadewmini4@gmail.com', '250/1,Egodawaththa,Rilhena,pelmadulla', 'Borella', '70070', '0710108280', '$2y$10$oRn9qdtdGbkcc1BET3r43uMkjk90AXCONWNzObrimjyoZ2FQTOAJm', 'admin', 1, '2025-10-09 04:38:15'),
(19, 'hansi', 'dewmini@gmail.com', '110,rilhena,pelmadlla', 'rathnapura', '70070', '+976543562', '$2y$10$ih5f2RDeAMjTwuPR0pEr6uAtaQYDrF7m1d1su4oNgYwUXEq5zMdeC', 'student', 1, '2025-10-09 07:57:41'),
(21, 'test', 'test@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$WW9lf8Lsp.AeTfrcbGCthORNkZ2ntmrqDmi0i2zRdSHa0tAYonhAm', 'student', 1, '2025-10-09 08:03:08'),
(22, 'ruhiniDewmini', 'ruhini@gamil.com', 'huthirigamuwa ,haputhale', 'Borella', '70070', '0710108280', '$2y$10$gZ1eVH2LEvI2ccNMNZR.qe.eAySEgNaRmOMxj5uj5AGcj7cWYHrbK', 'admin', 1, '2025-10-09 08:04:28'),
(23, 'SithikaCooray2', 'test2@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$/zuCIBZQRo4cVq4MSIQf2e5BqR3Ix5qlf/1UTyx6VNPwv1I3P7Uc2', 'admin', 1, '2025-10-09 08:05:09'),
(24, 'Pramodya Dewmini', 'pramodyadewmini2@gmail.com', '250/1,Egodawaththa,Rilhena,pelmadulla', 'Borella', '70070', '0710108280', '$2y$10$YvRWAslMWgDfnBUBAKMBquk55d0AvZxzxn81U/aoXdqo8QQBeXCX2', 'student', 1, '2025-10-09 08:09:38'),
(25, 'Bulathsinhalage Sithika Sandive Thavemika Cooray', 'pdewmini@gmail.com', '221/11, Jinarathana Mawatha, Batakeththara, Piliyandala.', 'Piliyandala', '10300', '0710935966', '$2y$10$ATMskGjUA2v.xgKwKcU/uu4K08Qtvz2T.0PA9mtu5k.GsQGvkgnZS', 'student', 1, '2025-10-09 08:23:24'),
(26, 'Bulathsinhalage Sithika Sandive Thavemika Cooray', 'test4@gmail.com', '221/11, Jinarathana Mawatha, Batakeththara, Piliyandala.', 'Piliyandala', '10300', '0710935966', '$2y$10$r.Ek5Ie8BrUJfFDHcJh8Tu7MslwIBns0RMLwRxGhiASUBSGpYEy4O', 'admin', 1, '2025-10-09 08:24:47'),
(28, 'hi', 'ik@gmail.com', '221/11, Jinarathana Mawatha, Batakeththara, Piliyandala.', 'Piliyandala', '10300', '0710935966', '$2y$10$UkMAvUPuZVHG9Uz4CLkVrejzqi1UWOrYCLEHCY8aGPDH0K6.dqHSC', 'student', 1, '2025-10-09 08:34:18'),
(29, 'Sithika Cooray', 'test3@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$pI3C.V581SIBnVzVSGGdKORDcGLTthJQKrkISL1H4bnlWBE.AYbMG', 'admin', 1, '2025-10-09 08:35:47'),
(30, 'test5', 'test5@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$gil1H1BDzbQ461hTSjSZGOGLMdci88D7TUSrj5xiDYklHD4A6yKEq', 'student', 1, '2025-10-09 10:14:02'),
(31, 'test6', 'test6@gmail.com', '221/11, Jinarathana Mawatha, Batakeththa', 'Piliyandala', '10500', '0721687376', '$2y$10$7L93T1Vxc7k3gnNR0gl7QeFBWkmvSZ5TVmDVR6xqH7a3hq.xfspgy', 'admin', 1, '2025-10-09 10:14:56');

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userdetails` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
