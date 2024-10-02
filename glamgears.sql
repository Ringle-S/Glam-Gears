-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 04:57 PM
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
-- Database: `glamgears`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `blog_desc` text NOT NULL,
  `blog_text` mediumtext NOT NULL,
  `category` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blog_id`, `user_id`, `title`, `img_name`, `blog_desc`, `blog_text`, `category`, `status`, `created_at`) VALUES
(1, 45291, 'The Future of Gaming: Console Wars or Cloud Gaming?', 'blog5.png', ' Discuss the latest trends in the gaming industry, including the battle between consoles and cloud gaming platforms.', 'The gaming industry is undergoing a significant transformation. Traditional console gaming is facing competition from cloud gaming services that offer on-demand access to games without the need for powerful hardware. As technology progresses, the line between console and cloud gaming is becoming increasingly blurred. The future of gaming will likely involve a combination of both platforms, catering to different player preferences and technological advancements.', 'console', 'active', '2024-08-16 15:52:37'),
(2, 45291, 'Virtual Reality: Immerse Yourself in New Worlds', 'blog6.png', 'Delve into the world of virtual reality and explore its potential to revolutionize entertainment, gaming, and education.', 'Virtual reality (VR) is redefining the way we experience digital content. By creating immersive environments that simulate real-world experiences, VR has captured the imagination of people worldwide. From gaming and entertainment to education and training, VR offers endless possibilities. As technology advances, we can expect even more realistic and interactive VR experiences that blur the lines between the virtual and physical worlds.', 'vr', 'active', '2024-08-16 16:13:35'),
(3, 10031, 'The Internet of Things (IoT): A Connected World', 'blog4.png', ' Understand the concept of IoT and its potential to revolutionize various industries and daily life.', 'Virtual reality (VR) is redefining the way we experience digital content. By creating immersive environments that simulate real-world experiences, VR has captured the imagination of people worldwide. From gaming and entertainment to education and training, VR offers endless possibilities. As technology advances, we can expect even more realistic and interactive VR experiences that blur the lines between the virtual and physical worlds.', 'iot', 'active', '2024-08-16 16:16:02'),
(4, 52895, 'The Next Generation of Smartphones: What to Expect', 'Group 42.png', 'Stay updated on the latest trends in smartphone technology and what to look for in your next device', 'Smartphones continue to evolve at a rapid pace, with new features and innovations emerging every year. In this blog post, we&#39;ll discuss the key trends shaping the smartphone market, including foldable phones, advanced cameras, and improved battery life.', 'smartphone', 'inactive', '2024-08-27 04:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_on`) VALUES
(30, 52895, 72211, 1, '2024-09-14 10:32:43'),
(40, 45291, 72211, 1, '2024-09-15 09:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `contacts_queries`
--

CREATE TABLE `contacts_queries` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  `contact_message` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts_queries`
--

INSERT INTO `contacts_queries` (`contact_id`, `contact_name`, `contact_email`, `contact_message`, `status`, `created_at`) VALUES
(1, 'Karthick Raj', 'karthick@gmail.com', 'Many users already have downloaded jQuery from Google when visiting another site. As a result, it will be loaded from cache when they visit your site, which leads to faster loading time. Also, most CDN\'s will make sure that once a user requests a file fro', 'unread', '2024-08-14 14:07:34'),
(2, 'Karthick Raj', 'karthick@gmail.com', 'Many users already have downloaded jQuery from Google when visiting another site. As a result, it will be loaded from cache when they visit your site, which leads to faster loading time. Also, most CDN\'s will make sure that once a user requests a file fro', 'unread', '2024-08-14 14:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_id` int(10) NOT NULL,
  `coupon_code` varchar(50) NOT NULL,
  `coupon_value` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_id`, `coupon_code`, `coupon_value`, `created_at`) VALUES
(1, 10235, 'MEGAOFF20', 0.20, '2024-08-13 18:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `merchant_name` varchar(60) NOT NULL,
  `business_name` varchar(60) NOT NULL,
  `merchant_email` varchar(320) NOT NULL,
  `merchant_phone` bigint(13) NOT NULL,
  `merchant_pass` varchar(30) NOT NULL,
  `user_type` varchar(10) NOT NULL DEFAULT 'merchant',
  `merchant_status` tinyint(1) NOT NULL DEFAULT 0,
  `userid` int(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant_id`, `merchant_name`, `business_name`, `merchant_email`, `merchant_phone`, `merchant_pass`, `user_type`, `merchant_status`, `userid`, `date_created`, `date_updated`) VALUES
(1, 10031, 'Krishnan', 'Kalai Mobiles', 'krishnan@gmail.com', 999925554, 'krish123', 'admin', 1, 2, '2024-08-08 09:38:35', '2024-10-01 06:05:45'),
(2, 52895, 'Rajan', 'Century TechZ', 'techz@gmail.com', 9586525848, 'raj12345', 'merchant', 1, 3, '2024-08-11 05:33:18', '2024-08-11 05:33:18'),
(4, 45291, 'Ringle Ebenezer', 'Glam Gears', 'ringlestr@gmail.com', 9952185689, 'ringle01', 'admin', 1, 4, '2024-08-16 15:44:02', '2024-08-16 15:44:02'),
(5, 50023, 'wqdwedf', 'fwewfe', 'manna@gmail.com', 6852156984, '12345678', 'merchant', 0, 2, '2024-09-15 14:02:02', '2024-09-15 14:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter` int(11) NOT NULL,
  `news_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`newsletter`, `news_email`) VALUES
(1, 'ringvvvlestr@gmail.com'),
(2, 'ringle.vebenezer@gmail.com'),
(4, 'danielrajdj1903@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `tracking_no` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `confirmation` varchar(30) NOT NULL DEFAULT 'Pending',
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `phone` int(10) NOT NULL,
  `total_amount` int(20) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `tracking_no`, `user_id`, `confirmation`, `fname`, `lname`, `email`, `address`, `state`, `city`, `zipcode`, `phone`, `total_amount`, `coupon_code`, `payment_mode`, `created_at`, `update_at`) VALUES
(1, 86991, 1, 'Pending', 'Karthi', 'kannan', 'manna@gmail.com', '446e,valluvar nagar, kovilpatti', 'TN', 'Tuticorin', 628501, 2147483647, 2471, 'MEGAOFF10', 'COD', '2024-08-16 15:40:31', '2024-08-27 03:38:29'),
(2, 89074, 1, 'Pending', 'aathi', 'velu', 'aathi@gmail.com', '446e,valluvar nagar, kovilpatti', 'TN', 'Tuticorin', 628501, 2147483647, 315, '', 'COD', '2024-08-27 03:37:48', '2024-10-01 04:08:14'),
(3, 89074, 52895, 'Pending', 'aathi', 'velu', 'aathi@gmail.com', '446e,valluvar nagar, kovilpatti', 'TN', 'Tuticorin', 628501, 2147483647, 605, '', 'COD', '2024-08-27 05:00:38', '2024-09-15 14:46:26'),
(55, 84200, 2, 'Pending', 'Karthi', 'kannan', 'manna@gmail.com', '446e,valluvar nagar, kovilpatti', '', 'Tuticorin', 628501, 2147483647, 4199, '', 'COD', '2024-10-02 14:23:50', '2024-10-02 14:23:50'),
(56, 85604, 1, 'Pending', 'Karthi', 'kannan', 'manna@gmail.com', '446e,valluvar nagar, kovilpatti', '', 'Tuticorin', 628501, 2147483647, 56260, '', 'card', '2024-10-02 14:53:50', '2024-10-02 14:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `product_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `order_status` varchar(15) NOT NULL DEFAULT 'Pending',
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `product_id`, `order_id`, `quantity`, `price`, `product_name`, `order_status`, `ordered_at`) VALUES
(1, 76227, 1, 4, 845, 'AirHead Ultimate 131Hz DeadHeardZ', 'completed', '2024-08-16 15:40:31'),
(2, 32523, 2, 3, 350, 'X Gamer Game Console ', 'completed', '2024-08-27 03:37:48'),
(3, 54522, 1, 1, 3025, 'Crazy Wheels for PS5', 'completed', '2024-08-27 05:00:38'),
(57, 76227, 55, 3, 845, 'AirHead Ultimate 131Hz DeadHeardZ', 'completed', '2024-10-02 14:23:50'),
(58, 57705, 55, 1, 354, 'PowerSurge high-capacity power', 'Pending', '2024-10-02 14:23:50'),
(59, 54522, 55, 1, 3025, 'Crazy Wheels for PS5', 'completed', '2024-10-02 14:23:50'),
(60, 72211, 56, 2, 35000, 'Smart Android Television Genz', 'Pending', '2024-10-02 14:53:50'),
(61, 54522, 56, 3, 3025, 'Crazy Wheels for PS5', 'Pending', '2024-10-02 14:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) NOT NULL,
  `track_id` int(10) NOT NULL,
  `cardnumber` int(50) NOT NULL,
  `cardname` varchar(32) NOT NULL,
  `expire_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `track_id`, `cardnumber`, `cardname`, `expire_date`, `created_at`) VALUES
(1, 93305, 2147483647, 'efwefce', '2024-10-24', '2024-10-01 05:33:32'),
(2, 94384, 2147483647, 'efwefce', '2024-10-24', '2024-10-01 05:33:52'),
(3, 91493, 0, '', '0000-00-00', '2024-10-01 06:46:08'),
(4, 83060, 2147483647, 'efwefce', '2024-10-24', '2024-10-01 06:55:34'),
(5, 85604, 2147483647, 'wefefewfwef', '2024-10-11', '2024-10-02 14:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `discount_percent` decimal(2,2) NOT NULL,
  `product_quantity` int(100) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `product_status` varchar(8) NOT NULL DEFAULT 'active',
  `merchant_id` int(100) NOT NULL,
  `main_image_name` varchar(100) NOT NULL,
  `is_featured` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `product_name`, `product_description`, `product_price`, `discount_percent`, `product_quantity`, `category_name`, `brand_name`, `product_status`, `merchant_id`, `main_image_name`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 76227, 'AirHead Ultimate 131Hz DeadHeardZ', 'Headphones are electronic audio device that people wear over their ears. They let people hear sounds on a walkman, MP3 player, mobile phone or computer.                             ', 845.00, 0.40, 93, 'Headphone', 'Oppo', 'active', 10031, 'Blackhead1.png', '1', '2024-09-30 16:33:21', '2024-08-11 15:05:38'),
(2, 32523, 'X Gamer Game Console ', 'CPU: Handles game logic and calculations.   \r\nGPU: Renders graphics and visuals for the game.\r\nMemory: Stores game data, system software, and temporary information.\r\nStorage: Holds game installations and saved data (internal or external).\r\nInput devices: Controllers for player interaction.   \r\nOutput devices: Connect to a television or monitor to display the game.                            ', 350.00, 0.30, 36, 'Joystick', 'Sony', 'active', 10031, 'joystick1.png', '1', '2024-10-01 06:44:59', '2024-08-12 04:57:07'),
(3, 72211, 'Smart Android Television Genz', 'Smart TVs: Internet-connected TVs offering streaming services and apps.   \r\n4K and 8K resolution: Higher pixel counts for sharper images.   \r\nHDR (High Dynamic Range): Improved contrast and color for a more realistic picture.   \r\nTelevision has evolved from a simple entertainment device to a multimedia hub, offering a wide range of content and interactive features.Type the description', 35000.00, 0.30, 29, 'Television', 'Samsung', 'active', 10031, 'TV3.png', '1', '2024-09-30 16:39:06', '2024-08-12 07:37:51'),
(4, 57705, 'PowerSurge high-capacity power', 'Conversion: Translates data or signals from one format to another.   \r\nCompatibility: Ensures seamless operation between different devices or systems.   \r\nInterface: Provides a connection point for two or more components.\r\nIn essence, an adapter is a versatile tool that facilitates connectivity and interoperability in the world of technology.', 354.00, 0.27, 100, 'Charger', 'Nokia', 'active', 52895, 'adapter1.png', '1', '2024-09-30 14:22:10', '2024-08-12 15:04:59'),
(5, 54522, 'Crazy Wheels for PS5', 'Smartwatches have revolutionized the way we interact with technology. Once limited to displaying time and date, these wearable devices have evolved into sophisticated companions that track fitness goals', 3025.00, 0.20, 33, 'console', 'Sony', 'active', 45291, 'Carconsole1.png', '1', '2024-10-02 14:53:50', '2024-08-16 15:47:15'),
(6, 94083, 'Vehicle @MOBILE HOLDER 2xx', 'smartwatches have become indispensable for many. As technology continues to advance, we can expect even more innovative features and functionalities to emerge in the smartwatch market.', 365.00, 0.10, 6, 'accessories', 'Nokia', 'active', 45291, 'mobilestand1.png', '1', '2024-10-01 06:55:34', '2024-08-16 15:49:44'),
(8, 87002, 'Smart watch 121z ', 'Smartwatches are more than just timekeepers; they\'re compact computers that fit on your wrist', 699.00, 0.15, 50, 'smart watch', 'Oppo', 'active', 52895, 'whitewatch1.png', '1', '2024-09-30 14:22:10', '2024-08-27 04:32:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `img_name1` varchar(568) NOT NULL,
  `img_name2` varchar(30) NOT NULL,
  `img_name3` varchar(30) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `img_name1`, `img_name2`, `img_name3`, `uploaded_at`) VALUES
(1, 76227, 'Blackhead2.png', 'Blackhead3.png', 'Blackhead4.png', '2024-09-14 07:39:20'),
(9, 52377, 'console2.png', 'joystick2.png', 'joystick3.png', '2024-09-30 14:55:33'),
(10, 32523, 'console1.png', 'console2.png', 'joystick3.png', '2024-10-01 04:24:23'),
(11, 72211, 'TV1.png', 'adapter6.png', 'TV3.png', '2024-10-01 04:26:06'),
(12, 57705, 'adapter2.png', 'adapter3.png', 'adapter4.png', '2024-10-01 04:28:17'),
(13, 54522, 'Carconsole2.png', 'Carconsole3.png', 'Carconsole1.png', '2024-10-01 04:29:59'),
(14, 94083, 'mobilestand2.png', 'mobilestand3.png', 'mobilestand4.png', '2024-10-01 04:33:17'),
(15, 87002, 'whitewatch2.png', 'whitewatch3.png', 'watch1-1.png', '2024-10-01 04:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(32) NOT NULL,
  `otp` int(10) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `otp`, `created_at`, `update_at`) VALUES
(1, 'karthick raj', 'karthick@gmail.com', 'karthick', 0, '2024-08-08 04:35:00', '2024-08-08 04:35:00'),
(2, 'Krishnan', 'krishnan@gmail.com', 'krish123', 0, '2024-08-08 04:50:08', '2024-08-08 04:50:08'),
(3, 'Raja', 'raj12345@gmail.com', 'raj12345', 0, '2024-08-10 16:33:19', '2024-08-10 16:33:19'),
(4, 'Ringle Ebenezer', 'ringlestr@gmail.com', 'ringle01', 9280, '2024-08-16 15:43:33', '2024-08-31 11:00:04');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `user_id`, `product_id`, `added_on`) VALUES
(7, 10031, 57705, '2024-08-13 06:36:47'),
(8, 10031, 32523, '2024-08-13 07:00:21'),
(9, 1, 76227, '2024-09-14 08:05:02'),
(10, 1, 32523, '2024-09-14 08:06:03'),
(11, 2, 54522, '2024-09-30 14:31:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `contacts_queries`
--
ALTER TABLE `contacts_queries`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`);

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
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `contacts_queries`
--
ALTER TABLE `contacts_queries`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
