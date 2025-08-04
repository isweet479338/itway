-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 04, 2025 at 08:25 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Torrance Yost', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(2, 'Kiera Daugherty', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(3, 'Prof. Demarco Collier I', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(4, 'Ms. Berneice Halvorson IV', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(5, 'Dr. Immanuel Langworth I', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(6, 'Jermain Little', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(7, 'Pamela Schmitt', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(8, 'Velma Russel', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(9, 'Everett Weber', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(10, 'Dr. Samson Davis II', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(11, 'Dr. Russel Gusikowski DDS', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(12, 'Dr. Abel Kautzer V', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(13, 'Mrs. Jazmyne Bernhard', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(14, 'Anne Von', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(15, 'Earlene Marquardt', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(16, 'Sylvia Runolfsdottir', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(17, 'Myles Brakus', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(18, 'Mrs. Linnea Labadie I', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(19, 'Rocky Mitchell PhD', '2025-08-04 12:36:01', '2025-08-04 12:36:01'),
(20, 'Prof. Eileen Schuster Sr.', '2025-08-04 12:36:01', '2025-08-04 12:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_04_181110_create_sales_table', 2),
(5, '2025_08_04_193701_sale_item', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int NOT NULL DEFAULT '0',
  `unit` varchar(50) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sell_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `qty`, `unit`, `buy_price`, `sell_price`, `created_at`, `updated_at`) VALUES
(1, 5, 'tempora laborum mollitia', 399, 'pcs', 70.16, 45.14, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(2, 4, 'ducimus in vel', 323, 'pcs', 78.80, 168.14, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(3, 7, 'quo culpa eveniet', 162, 'pcs', 42.72, 58.67, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(4, 7, 'corporis voluptas et', 205, 'pcs', 89.78, 129.89, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(5, 4, 'odio nemo aliquid', 349, 'pcs', 93.53, 187.04, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(6, 4, 'dicta mollitia nam', 337, 'pcs', 70.92, 21.32, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(7, 4, 'voluptas numquam deleniti', 206, 'pcs', 58.58, 129.26, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(8, 4, 'sed odio voluptatem', 53, 'pcs', 52.83, 183.07, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(9, 1, 'asperiores eaque tenetur', 225, 'pcs', 50.40, 164.96, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(10, 5, 'beatae voluptatum et', 220, 'pcs', 30.63, 60.49, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(11, 5, 'cumque quia atque', 273, 'pcs', 78.39, 115.23, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(12, 10, 'voluptatum nisi in', 79, 'pcs', 23.56, 133.35, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(13, 8, 'delectus ea qui', 12, 'pcs', 93.17, 30.05, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(14, 10, 'qui rerum et', 159, 'pcs', 30.52, 84.44, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(15, 6, 'in aut nihil', 397, 'pcs', 73.93, 129.46, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(16, 7, 'qui sint sit', 208, 'pcs', 77.54, 59.27, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(17, 7, 'nesciunt debitis eum', 305, 'pcs', 36.55, 187.73, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(18, 9, 'magni vero harum', 59, 'pcs', 56.81, 81.18, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(19, 7, 'saepe eos voluptatum', 105, 'pcs', 92.53, 52.49, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(20, 5, 'laudantium nisi quasi', 483, 'pcs', 35.81, 149.70, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(21, 9, 'quae aliquam est', 165, 'pcs', 10.56, 90.40, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(22, 2, 'qui est eveniet', 282, 'pcs', 96.54, 170.44, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(23, 3, 'dicta cumque enim', 11, 'pcs', 42.75, 139.09, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(24, 9, 'assumenda esse qui', 246, 'pcs', 62.48, 47.19, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(25, 5, 'mollitia error qui', 382, 'pcs', 74.85, 76.43, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(26, 6, 'voluptas ut modi', 90, 'pcs', 78.89, 53.16, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(27, 7, 'est iure accusamus', 255, 'pcs', 54.55, 129.62, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(28, 6, 'dolorum ratione nesciunt', 358, 'pcs', 64.94, 117.99, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(29, 8, 'tempora eligendi non', 415, 'pcs', 92.47, 150.51, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(30, 7, 'omnis perferendis reiciendis', 107, 'pcs', 66.24, 66.25, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(31, 2, 'doloribus quo porro', 487, 'pcs', 52.58, 148.33, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(32, 10, 'illo quis consequatur', 494, 'pcs', 84.91, 152.66, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(33, 5, 'saepe molestiae eum', 283, 'pcs', 97.62, 165.40, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(34, 8, 'vel maiores explicabo', 380, 'pcs', 89.66, 126.95, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(35, 1, 'tempora numquam pariatur', 244, 'pcs', 36.11, 156.33, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(36, 2, 'id ea ut', 193, 'pcs', 35.99, 119.18, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(37, 10, 'porro id rem', 333, 'pcs', 79.75, 188.69, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(38, 5, 'in sit aliquid', 291, 'pcs', 79.73, 199.52, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(39, 2, 'tempora numquam voluptatem', 316, 'pcs', 86.10, 163.52, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(40, 8, 'voluptate laborum facere', 49, 'pcs', 91.76, 100.24, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(41, 2, 'reiciendis labore cum', 9, 'pcs', 75.06, 29.29, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(42, 6, 'quisquam explicabo non', 330, 'pcs', 14.02, 184.46, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(43, 5, 'voluptatem id sunt', 17, 'pcs', 52.90, 91.38, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(44, 10, 'expedita repellendus dolores', 192, 'pcs', 54.78, 110.06, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(45, 2, 'ad perferendis ut', 239, 'pcs', 79.61, 124.32, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(46, 1, 'delectus ipsa quia', 65, 'pcs', 49.97, 32.75, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(47, 3, 'sed sit provident', 12, 'pcs', 34.11, 164.48, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(48, 1, 'corrupti et laudantium', 83, 'pcs', 37.92, 190.48, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(49, 2, 'ipsum vero ipsa', 443, 'pcs', 79.80, 136.69, '2025-08-04 12:55:43', '2025-08-04 12:55:43'),
(50, 10, 'esse deserunt reprehenderit', 227, 'pcs', 47.89, 164.59, '2025-08-04 12:55:43', '2025-08-04 12:55:43');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int UNSIGNED NOT NULL,
  `customer_id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `by` varchar(100) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `date`, `subtotal`, `discount`, `tax`, `total`, `by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, '2025-08-04', 60.49, 0.00, 6.05, 66.54, 'Shohidul Islam', '2025-08-04 14:13:32', '2025-08-04 13:42:16', '2025-08-04 14:13:32'),
(2, 15, '2025-08-04', 1244.97, 0.00, 124.50, 1369.47, 'Shohidul Islam', NULL, '2025-08-04 13:43:02', '2025-08-04 13:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint UNSIGNED NOT NULL,
  `sale_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `discount`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, 60.49, 0.00, 60.49, '2025-08-04 13:42:16', '2025-08-04 13:42:16'),
(2, 2, 24, 11, 47.19, 0.00, 519.09, '2025-08-04 13:43:02', '2025-08-04 13:43:02'),
(3, 2, 10, 12, 60.49, 0.00, 725.88, '2025-08-04 13:43:02', '2025-08-04 13:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('r6dj0xV07wvRIQPyi2h3MW5ldZryZdaNJ8QyeMHD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibjQwa0RVM2xzT0JOa0tLQ0kwbHZyNXRtMldUalptWnRNZ25xU0ZsWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYWxlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1754338633);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shohidul Islam', 'isweet479338@gmail.com', NULL, '$2y$12$glA3IlACiKWGahX7Z8eCx.4fnABxe8bHIFOdP7BSS6MJhnCF9w7e2', NULL, '2025-08-04 12:26:28', '2025-08-04 12:26:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_index` (`sale_id`),
  ADD KEY `sale_items_product_id_index` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
