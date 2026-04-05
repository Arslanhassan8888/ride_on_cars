-- -- phpMyAdmin SQL Dump
-- -- version 5.2.1
-- -- https://www.phpmyadmin.net/
-- --
-- -- Host: 127.0.0.1:3306
-- -- Generation Time: Apr 05, 2026 at 03:03 PM
-- -- Server version: 9.1.0
-- -- PHP Version: 8.3.14

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
-- SET time_zone = "+00:00";


-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- --
-- -- Database: `ride_on_cars`
-- --

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `products`
-- --

-- DROP TABLE IF EXISTS `products`;
-- CREATE TABLE IF NOT EXISTS `products` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `name` varchar(255) DEFAULT NULL,
--   `brand` varchar(100) DEFAULT NULL,
--   `price` decimal(10,2) DEFAULT NULL,
--   `age_range` varchar(50) DEFAULT NULL,
--   `description` text,
--   `image` varchar(255) DEFAULT NULL,
--   `rating` int DEFAULT NULL,
--   `stock` int DEFAULT NULL,
--   `long_description` text,
--   PRIMARY KEY (`id`)
-- ) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --
-- -- Dumping data for table `products`
-- --

-- INSERT INTO `products` (`id`, `name`, `brand`, `price`, `age_range`, `description`, `image`, `rating`, `stock`, `long_description`) VALUES
-- (1, 'Mercedes Ride-On Car', 'Mercedes', 209.99, '4-7 years', 'Luxury electric ride-on car with LED lights and music system', 'mercedes1.jpg', 5, 10, 'This premium Mercedes ride-on car offers a realistic driving experience with LED headlights, music system, and smooth acceleration. Designed for comfort and safety.'),
-- (2, 'Audi Ride-On Car', 'Audi', 179.99, '3-5 years', 'Stylish and safe electric car for kids with smooth driving', 'audi1.jpg', 4, 8, 'The Audi ride-on car combines modern design with safety features. It includes seat belts, parental remote control, and soft start technology.'),
-- (3, 'BMW Ride-On Car', 'BMW', 199.99, '3-6 years', 'Premium BMW ride-on with powerful motor and LED lights', 'bmw1.jpg', 5, 12, 'The BMW ride-on car combines style and performance. Equipped with dual motors, LED lights, and comfortable seating for long playtime.'),
-- (4, 'Lamborghini Ride-On Car', 'Lamborghini', 249.99, '4-7 years', 'Supercar design with fast acceleration and LED lights', 'lambo1.jpg', 5, 6, 'This Lamborghini ride-on car delivers a sporty experience with fast acceleration, realistic engine sounds, and premium design.'),
-- (5, 'Range Rover Ride-On', 'Range Rover', 189.99, '3-6 years', 'Strong SUV style ride-on with durable build and parental control', 'range1.jpg', 4, 9, 'The Range Rover ride-on is designed for comfort and durability. It includes remote control for parents and smooth suspension.'),
-- (6, 'Mini Cooper Ride-On', 'Mini', 159.99, '3-5 years', 'Compact and fun ride-on perfect for younger children', 'mini1.jpg', 4, 11, 'This Mini Cooper ride-on car is compact, stylish, and easy to control. Perfect for beginners with safe speed limits.'),
-- (7, 'Ford Ranger Ride-On', 'Ford', 169.99, '3-6 years', 'Pickup style ride-on with strong wheels and off-road design', 'ford1.jpg', 4, 7, 'The Ford Ranger ride-on features rugged tires, durable body, and a pickup-style design perfect for adventurous kids.'),
-- (8, 'Jeep Ride-On Car', 'Jeep', 199.99, '4-7 years', 'Off-road electric ride-on with rugged design and LED lights', 'jeep1.jpg', 5, 5, 'This Jeep ride-on car is perfect for off-road style play. It includes strong suspension, LED lights, and powerful motors.'),
-- (9, 'Bugatti Ride-On', 'Bugatti', 259.99, '4-7 years', 'Luxury supercar for kids with premium finish', 'bugatti1.jpg', 5, 4, 'The Bugatti ride-on car offers a luxury driving experience with high-quality materials, smooth ride, and stunning design.'),
-- (10, 'Tesla Ride-On Car', 'Tesla', 229.99, '4-7 years', 'Modern electric ride-on with smooth driving and silent motor', 'tesla1.jpg', 5, 6, 'This Tesla ride-on car delivers a modern and smooth experience with silent motor technology and sleek design.'),
-- (11, 'Ferrari Ride-On', 'Ferrari', 239.99, '4-7 years', 'Classic Ferrari design with speed control and music system', 'ferrari1.jpg', 5, 5, 'The Ferrari ride-on car is designed for young drivers who love speed and style, with built-in music and safety features.'),
-- (12, 'McLaren Ride-On', 'McLaren', 249.99, '4-7 years', 'High-end sports car with sleek design and LED lights', 'mclaren1.jpg', 5, 3, 'This McLaren ride-on car features a sleek design, high performance motor, and premium lighting system.'),
-- (13, 'Porsche Ride-On', 'Porsche', 219.99, '4-7 years', 'Elegant ride-on car with realistic driving experience', 'porsche1.jpg', 4, 6, 'The Porsche ride-on car combines elegance and performance with smooth driving and comfortable seating.'),
-- (14, 'Nissan Ride-On', 'Nissan', 169.99, '3-6 years', 'Reliable and fun ride-on with smooth controls', 'nissan1.jpg', 4, 10, 'This Nissan ride-on car is reliable and easy to control, making it ideal for everyday play.'),
-- (15, 'Toyota Ride-On', 'Toyota', 159.99, '3-6 years', 'Affordable and durable ride-on perfect for everyday use', 'toyota1.jpg', 5, 16, 'The Toyota ride-on car is designed for durability and comfort, perfect for daily use and long-lasting fun.');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `reviews`
-- --

-- DROP TABLE IF EXISTS `reviews`;
-- CREATE TABLE IF NOT EXISTS `reviews` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `user_id` int DEFAULT NULL,
--   `name` varchar(100) DEFAULT NULL,
--   `location` varchar(100) DEFAULT NULL,
--   `rating` int DEFAULT NULL,
--   `message` text,
--   `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`)
-- ) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --
-- -- Dumping data for table `reviews`
-- --

-- INSERT INTO `reviews` (`id`, `user_id`, `name`, `location`, `rating`, `message`, `created_at`) VALUES
-- (1, 1, 'Sarah Johnson', 'London', 5, 'My daughter absolutely loves her pink convertible! The quality is amazing and the battery lasts for hours. Best purchase ever!', '2026-04-02 11:41:32'),
-- (2, 2, 'Michael Chen', 'Manchester', 5, 'The SUV we bought is perfect for our twins. The parental remote control gives us peace of mind. Highly recommended!', '2026-04-02 11:41:32'),
-- (3, 3, 'Emily Rodriguez', 'Birmingham', 5, 'Excellent customer service and fast shipping. The jeep is sturdy and my son plays with it every day!', '2026-04-02 11:41:32'),
-- (4, 4, 'David Thompson', 'Leeds', 5, 'Amazing quality! The sports car looks exactly like the pictures. My son was thrilled when he saw it.', '2026-04-02 11:41:32'),
-- (5, 5, 'Lisa Anderson', 'Liverpool', 4, 'Great product overall. The battery life is good and the car is well-built. Very happy with the purchase!', '2026-04-02 11:41:32'),
-- (6, 6, 'James Wilson', 'Glasgow', 5, 'My kids love their new ride-on car! It is sturdy, safe, and the remote control feature is fantastic.', '2026-04-02 11:41:32'),
-- (7, 7, 'Christopher Brown', 'Edinburgh', 5, 'Exceptional build quality and handles well on different surfaces. Highly recommended!', '2026-04-02 11:41:32'),
-- (8, 8, 'Amanda Taylor', 'Bristol', 5, 'My son absolutely loves his monster truck! Big, powerful, and safe. Customer service was also very helpful.', '2026-04-02 11:41:32'),
-- (9, 9, 'Daniel Martinez', 'Sheffield', 5, 'Perfect gift for my niece. She loves the pink color and drives it around every day!', '2026-04-02 11:41:32'),
-- (10, NULL, 'Usman Hassan', 'Manchester', 5, 'Excellent Service', '2026-04-02 14:24:22');

-- -- --------------------------------------------------------

-- --
-- -- Table structure for table `users`
-- --

-- DROP TABLE IF EXISTS `users`;
-- CREATE TABLE IF NOT EXISTS `users` (
--   `id` int NOT NULL AUTO_INCREMENT,
--   `name` varchar(100) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `password` varchar(255) NOT NULL,
--   `role` varchar(20) DEFAULT 'user',
--   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
--   PRIMARY KEY (`id`),
--   UNIQUE KEY `email` (`email`)
-- ) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --
-- -- Dumping data for table `users`
-- --

-- INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
-- (1, 'Arslan', 'arslan@gmail.com', '$2y$10$nkEljJYeh5bBt2z4NhW9/OqfxR3dWs.IetwOH662j8LBPMqMDFXVa', 'admin', '2026-04-01 16:37:10'),
-- (2, 'Usman Hassan', 'usman@gmail.com', '$2y$10$ho4pROq4JQAaz8UVU7RhfurUDDr09WRlIsHosz8KrrKPUlxmqAt2S', 'user', '2026-04-01 17:01:07');
-- COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
