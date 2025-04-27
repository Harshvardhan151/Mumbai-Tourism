-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 12:03 PM
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
-- Database: `mumbaitourism`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'abc', 'abc@gmail.com', '', 'improve your site', '2025-04-18 11:13:05'),
(2, 'xcx', 'xyz@yahoo.com', '', 'test', '2025-04-20 03:41:39');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `hotel_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `location` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`hotel_id`, `name`, `description`, `location`, `price`, `rating`, `image_url`) VALUES
(1, 'The Taj Mahal Palace', NULL, '', 15000.00, NULL, NULL),
(2, 'ITC Maratha', NULL, '', 10000.00, NULL, NULL),
(3, 'Trident, Nariman Point', NULL, '', 12000.00, NULL, NULL),
(4, 'Abode Bombay', NULL, '', 8000.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_reservations`
--

CREATE TABLE `hotel_reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Not Paid',
  `payment_method` varchar(50) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_reviews`
--

CREATE TABLE `hotel_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_reviews`
--

INSERT INTO `hotel_reviews` (`review_id`, `user_id`, `hotel_id`, `rating`, `comment`, `review_date`) VALUES
(1, 6, 1, 5, 'nice service', '2025-04-24 10:19:39'),
(2, 6, 3, 5, 'luxurious rooms', '2025-04-24 15:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `guests` int(11) DEFAULT NULL CHECK (`guests` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `restaurant_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `location` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `cuisine` text DEFAULT NULL,
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`restaurant_id`, `name`, `description`, `location`, `price`, `rating`, `cuisine`, `image_url`) VALUES
(1, 'Leopold Cafe', 'A legendary cafe known for its vibrant atmosphere and delicious food.', 'Colaba ', 800.00, 4.50, 'Continental', NULL),
(2, 'Bademiya', 'Famous for its late-night kebabs and street food experience.', 'Fort', 500.00, 4.40, 'Middle Eastern', NULL),
(3, 'Britannia & Co.', 'Known for its authentic Parsi cuisine, including the famous Berry Pulao.', 'Colaba', 700.00, 4.60, 'Parsi', NULL),
(4, 'Kyani & Co.', 'One of Mumbai’s oldest Irani cafes, serving classic bun maska and chai.', 'Marine Drive', 300.00, 4.30, 'Parsi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_reservations`
--

CREATE TABLE `restaurant_reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `guests` int(11) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Not Paid',
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_reservations`
--

INSERT INTO `restaurant_reservations` (`reservation_id`, `user_id`, `restaurant_id`, `name`, `date`, `time`, `guests`, `payment_status`, `payment_method`) VALUES
(1, 1, 1, 'ABC', '2025-04-18', '20:20:00', 4, 'Not Paid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_reviews`
--

CREATE TABLE `restaurant_reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `restaurant_reviews`
--

INSERT INTO `restaurant_reviews` (`review_id`, `user_id`, `restaurant_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 4, 'Good food', '2025-04-18 10:46:13'),
(2, 6, 1, 5, 'good food', '2025-04-18 11:29:37'),
(3, 2, 2, 4, 'TACO TUESDAYYY', '2025-04-21 11:48:47'),
(4, 2, 3, 3, 'bland food', '2025-04-21 12:05:16'),
(5, 6, 2, 5, 'good food', '2025-04-23 18:11:57'),
(6, 2, 1, 2, 'found hair in my food', '2025-04-24 10:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `spot_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `location` text NOT NULL,
  `rating` decimal(3,2) DEFAULT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `image_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`spot_id`, `name`, `description`, `location`, `rating`, `image_url`) VALUES
(1, 'Gateway of India', NULL, '', 4.70, NULL),
(2, 'Marine Drive', NULL, '', 4.50, NULL),
(3, 'Elephanta Caves', NULL, '', 4.60, NULL),
(4, 'Prince of Wales Museum', NULL, '', 4.40, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` text DEFAULT 'user',
  `profile_pic` text DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `registration_time`, `role`, `profile_pic`, `last_login`) VALUES
(1, 'abc', 'abc@gmail.com', '$2y$10$s/khc4zLsKk/29xKwEcYjOBOQPMChHxnvx5AdvA/ucrGnVSHzbDSC', '2025-04-18 10:37:21', 'user', NULL, NULL),
(2, 'lebronjameshairline', 'lebron@yahoo.com', '$2y$10$SjP4kxjb5q7hPf1Gwqr39uqLP2yeUbIui11mkJ7MNwzOApYkPlXz.', '2025-04-18 11:20:18', 'user', NULL, NULL),
(5, 'xyz', 'xyz@yahoo.com', '$2y$10$B5mIoL7QNK52DuqKBUEYPeXCi9qqftK5w5CNYw98dsKXow7chxhB.', '2025-04-18 11:22:31', 'user', NULL, NULL),
(6, 'harshvardhan', 'harshvardhan.poyrekar@gmail.com', '$2y$10$5pzqqHLp8bh7cUanzWABdOeWJ.qCW27rIuwZUrP2d5Yv9d8IAInWW', '2025-04-18 11:28:33', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `hotel_reviews`
--
ALTER TABLE `hotel_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`hotel_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hotel_id` (`hotel_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- Indexes for table `restaurant_reservations`
--
ALTER TABLE `restaurant_reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant_reviews`
--
ALTER TABLE `restaurant_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`restaurant_id`);

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`spot_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`) USING HASH,
  ADD UNIQUE KEY `email` (`email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `hotel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hotel_reviews`
--
ALTER TABLE `hotel_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `restaurant_reservations`
--
ALTER TABLE `restaurant_reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `restaurant_reviews`
--
ALTER TABLE `restaurant_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `spot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotel_reservations`
--
ALTER TABLE `hotel_reservations`
  ADD CONSTRAINT `hotel_reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `hotel_reservations_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `hotel_reviews`
--
ALTER TABLE `hotel_reviews`
  ADD CONSTRAINT `hotel_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `hotel_reviews_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`hotel_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`) ON DELETE SET NULL;

--
-- Constraints for table `restaurant_reservations`
--
ALTER TABLE `restaurant_reservations`
  ADD CONSTRAINT `restaurant_reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `restaurant_reservations_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`restaurant_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
