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

-- Table structure for table `categories`
--

CREATE TABLE `categories` (
                              `id` int NOT NULL,
                              `name` varchar(100) NOT NULL,
                              `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
                                   `post_id` int NOT NULL,
                                   `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
                             `post_id` int NOT NULL,
                             `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `post_views`
--

CREATE TABLE `post_views` (
                              `id` int NOT NULL,
                              `post_id` int NOT NULL,
                              `ip_address` varchar(50) DEFAULT NULL,
                              `viewed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `settings`
--

CREATE TABLE `settings` (
                            `key` varchar(100) NOT NULL,
                            `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `tags`
--

CREATE TABLE `tags` (
                        `id` int NOT NULL,
                        `name` varchar(100) NOT NULL,
                        `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int NOT NULL,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(100) NOT NULL,
                         `password` varchar(255) NOT NULL,
                         `role` enum('admin','author','editor') DEFAULT 'author',
                         `profile_picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
                         `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Indexes
--

ALTER TABLE `categories`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

ALTER TABLE `comments`
    ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

ALTER TABLE `posts`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `post_categories`
    ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

ALTER TABLE `post_tags`
    ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

ALTER TABLE `post_views`
    ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

ALTER TABLE `settings`
    ADD PRIMARY KEY (`key`);

ALTER TABLE `tags`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

-- AUTO_INCREMENT
--

ALTER TABLE `categories`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `comments`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `posts`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `post_views`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `tags`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- Constraints
--

ALTER TABLE `comments`
    ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

ALTER TABLE `posts`
    ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `post_categories`
    ADD CONSTRAINT `post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

ALTER TABLE `post_tags`
    ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

ALTER TABLE `post_views`
    ADD CONSTRAINT `post_views_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
