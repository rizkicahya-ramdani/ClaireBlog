-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2025 at 11:07 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Teknologi', 'teknologi'),
(2, 'Bisnis', 'bisnis'),
(3, 'Lifestyle', 'lifestyle'),
(4, 'Education', 'education'),
(5, 'Health', 'health'),
(6, 'Travel', 'travel'),
(7, 'Food', 'food'),
(8, 'Entertainment', 'entertainment'),
(9, 'Olahraga', 'olahraga'),
(10, 'Finance', 'finance'),
(11, 'Animasi', 'animasi');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(7, 5, 'Cara Cepat Belajar Bahasa Inggris', 'cara-cepat-belajar-bahasa-inggris', 'Berikut adalah cara cepat belajar bahasa Inggris', 'uploads/1753278893_AdobeStock_50098553.jpeg', 'published', '2025-07-23 13:54:53', '2025-07-23 13:54:53'),
(9, 4, 'Inilah 5 Tips untuk Menjadi Programmer di 2026', 'inilah-5-tips-untuk-menjadi-programmer-di-2025', 'Saya akan memberi tips untuk menjadi Programmer di tahun 2026', 'uploads/1753280151_danial-igdery-FCHlYvR5gJI-unsplash.jpg', 'published', '2025-07-23 14:15:51', '2025-07-28 12:00:35'),
(10, 8, 'Pengertian HTML (Tag, Attribut, dan Value)', 'pengertian-html-tag-attribut-dan-value', 'Nah temen-temen yang mau belajar programming pasti ngga asing dong sama yang namanya HTML, kali ini saya akan mengajari kalian bagaimana penggunakan HTML dalam sebuah pembuatan website', 'uploads/1753280551_glenn-carstens-peters-npxXWgQ33ZQ-unsplash.jpg', 'published', '2025-07-23 14:22:31', '2025-07-23 14:22:31'),
(11, 5, 'When Yah! Ini adalah 5 Anime Romance Terbaik Saat Ini', '5-anime-romance-terbaik-saat-ini', 'Bagi kalian yang suka menonton anime, saya akan merekomendasikan 5 Anime dengan genre Romance terbaik saat ini.', 'uploads/1753517616_kaoru-hana.webp', 'published', '2025-07-26 08:13:36', '2025-07-28 10:03:32'),
(12, 5, '5 Anime Genre Action Terbaik Sepanjang Masa!', '5-anime-genre-action-terbaik-sepanjang-masa', '5 Anime Genre Action Terbaik Sepanjang Masa! Simak berikut ini.', 'uploads/1753519416_0_9WjoQgbcY_v-eNK2.jpg', 'published', '2025-07-26 08:43:36', '2025-07-28 09:49:19'),
(13, 9, 'Cara Menjalankan Ubuntu di Windows 11', 'cara-menjalankan-ubuntu-di-windows-11', 'Berikut adalah cara menjalankan Ubuntu di Windows 11', 'uploads/1753617834_gnome-ubuntu-desktop.jpg', 'published', '2025-07-27 12:03:54', '2025-07-27 12:03:54'),
(14, 9, 'Menakjubkan! Inilah 5 Spot Foto Paling Indah di Jogja', 'menakjubkan-inilah-5-spot-foto-paling-indah-di-jogja', 'Wow bagi kalian yang ingin ke Jogja tetapi tidak tau spot-spot ini rugi deh. Karena pada postingan kali ini, saya akan menunjukkan 5 Spot Foto Paling Indah di Jogja.', 'uploads/1753633184_a2931a1a38e9f9e6579fd4736021647c.jpg', 'published', '2025-07-27 16:19:44', '2025-07-27 16:19:44'),
(15, 4, '5 Tips Menjaga Kesehatan Tubuh', '5-tips-menjaga-kesehatan-tubuh', 'Berikut adalah 5 Tips menjaga kesehatan tubuh, simak berikut ini.', 'uploads/1753704353_Kesehatan-Anak.jpg', 'published', '2025-07-28 12:05:53', '2025-07-28 12:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(9, 1),
(13, 1),
(9, 2),
(9, 4),
(15, 5),
(14, 6),
(11, 8),
(12, 8),
(11, 11),
(12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_views`
--

CREATE TABLE `post_views` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `viewed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(100) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','author','editor') DEFAULT 'author',
  `profile_picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_picture`, `created_at`) VALUES
(2, 'fauzitaufiq', 'taufiqfauzi@gmail.com', '0bd9897bf12294ce35fdc0e21065c8a7', 'author', 'uploads/1753091941_Mahiru Shiina - The Angel Next Door.jpeg', '2025-07-19 12:31:38'),
(3, 'nanana77', 'nanasyarifuddin@gmail.com', 'bb9ec852de3e8f7609d3676ede4444fa', 'author', '', '2025-07-19 16:17:04'),
(4, 'shandika_affandi', 'shandikaaffandi@gmail.com', '$2y$10$Cg8.5R5Xu3HWu8BWs7P0dOgUifGMXhOJojyvw3B9TPAHCNX/tpsw.', 'author', 'uploads/1753105333_WhatsApp Image 2025-06-23 at 13.56.31_20e79688.jpg', '2025-07-21 13:41:49'),
(5, 'afiatunnur', 'afiatunnur@gmail.com', '$2y$10$C1YijEYIoE5u16TxFafEAOxWvdMBvCvSBGS7eEL.2z/5NuBtoMQC2', 'author', 'uploads/1753105753_Firefly _ ★.jpg', '2025-07-21 13:44:15'),
(6, 'dimasrachmad', 'dimasrachmad@gmail.com', '$2y$10$A47I60RWDmVgM1nMKnzEf.1AuQQ/IuDptbMVEPLOP1UEgJu34IC/u', 'author', 'uploads/default.png', '2025-07-21 13:50:05'),
(7, 'nikkosyarief', 'nikkosyarief@gmail.com', '$2y$10$oX63BeC90ikhD9aUAPIZ5eLKjrO6A3OQuAX.9ilgypeZZ4BhgV0ha', 'author', 'uploads/default.png', '2025-07-21 13:52:51'),
(8, 'aprilladaru', 'aprilladaru@gmail.com', '$2y$10$89LFBDNWkXid8p628I3m9u9DReUiPqhmG93B0xBH8vStx3sc1mdyS', 'author', 'uploads/1753106628_Screenshot (5).png', '2025-07-21 14:02:34'),
(9, 'rizkicahya', 'rizkicahya@gmail.com', '$2y$10$G/2OE7T9yLCzm58Vx1dnJOg1l/ZxU/smLf..Z6Mb4lE0EwjNMBeL6', 'author', 'uploads/1753106743_Screenshot (12).png', '2025-07-21 14:05:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `post_views`
--
ALTER TABLE `post_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post_views`
--
ALTER TABLE `post_views`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_views`
--
ALTER TABLE `post_views`
  ADD CONSTRAINT `post_views_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
