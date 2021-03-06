-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 29 Septembre 2020 à 13:07
-- Version du serveur :  5.7.31-0ubuntu0.18.04.1
-- Version de PHP :  7.2.33-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `free_ads`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `advertisements`
--

INSERT INTO `advertisements` (`id`, `user_id`, `category_id`, `title`, `description`, `photos`, `price`, `city`, `created_at`, `updated_at`) VALUES
(1, 1, '3', 'Harry Potter and the Philosopher\'s Stone book', 'Brand new Harry Potter first book', 'X2EzKX3SJ3maQ37mKN2DIn2svkFtcCe9cE3ocDVQ.jpeg', 8, 'Paris', '2020-05-13 11:53:04', '2020-05-13 11:53:04'),
(2, 1, '2', 'Succulent plants x16', 'Pretty succulent plants', 'myYIiS977KUKT2MXwrRcYRjm2HtPXTyquQ2Cf1Ec.jpeg', 15, 'Paris', '2020-05-13 11:54:10', '2020-05-13 11:54:10'),
(3, 2, '2', 'Wallpaper rolls x5', 'Stunning blue patterned wallpaper rolls', 'cIFtQkAg3DsGMIpWLn3wxRzMwZ4zFx7L3RG4UAyU.jpeg', 25, 'Poulx', '2020-05-13 11:55:56', '2020-05-13 11:55:56'),
(4, 2, '5', 'Honda CBR650R', '................', 'ZWwuM4DcRu8sztqTEL95aNJjuVJE3BP2ne0gwnVk.png, iPlRl2UOZanUIwl6gdovR3YZf00veMlUbkX7ezKM.png', 7100, 'Poulx', '2020-05-13 11:56:42', '2020-05-13 11:56:42'),
(5, 2, '2', 'Stand mixer x2', 'KitchenAid', '5GK39OeeFdIu8X0hHEFNxCPSBZqZx2JvMkUcWhvn.jpeg', 120, 'Paris', '2020-05-13 13:26:56', '2020-05-13 13:26:56'),
(6, 1, '1', 'Sharp Aquos SHF32 phone', 'Sharp Aquos SHF32 phone (white)', '7iimVjYihExNVqIIWZZUikXPp5W1nmAZel0XnNK4.jpeg', 200, 'Lille', '2020-05-14 16:39:47', '2020-05-14 16:39:47'),
(7, 1, '3', 'Harmonica', 'Beautiful  blue and orange harmonica', 'wdMazo4u8h5kYzKHFWAuHxSBLk0HvPPKU5011XLG.jpeg, z7BX9Lw91IYbn27e4H63c2qXXLXhRaz3004FBZ0i.jpeg', 50, 'Paris', '2020-09-06 08:36:09', '2020-09-06 08:36:09');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', '2020-05-13 15:27:17', NULL),
(2, 'Home, Garden', '2020-05-13 15:27:17', NULL),
(3, 'Books, Movies, Music', '2020-05-13 15:27:17', NULL),
(4, 'Sporting Goods', '2020-05-13 15:27:17', NULL),
(5, 'Cars, Motorcycles', '2020-05-13 15:27:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_08_181843_create_advertisements_table', 1),
(5, '2020_05_12_101747_create_cities_table', 1),
(6, '2020_05_12_101831_create_categories_table', 1),
(7, '2020_05_12_123855_create_category_user_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `city`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Christelle', 'Paris', 'christelle.b@mail.com', '2020-05-13 11:52:41', '$2y$10$odjEoa15rEvDCUXGAfjYJO8wbmxMCxMAhq0OA8yqiejQag4pAYLaW', NULL, '2020-05-13 11:52:26', '2020-09-06 08:35:03'),
(2, 'Viphada', 'Poulx', 'viphada.s@mail.com', '2020-05-13 11:54:46', '$2y$10$CCRyPfCQjSqybATauYKHze/OKr6wXjrNwgtOO774dN09Xs4QYdC8W', NULL, '2020-05-13 11:54:37', '2020-05-13 13:23:53'),
(3, 'Emy', 'Paris', 'emy.maine@mail.com', '2020-05-13 13:24:30', '$2y$10$O.sOtqrHG6MupHnFgqff5.kl4RkA8Gmtq74boFwMyFTqUowNXhXHu', NULL, '2020-05-13 13:24:14', '2020-05-13 13:33:28');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advertisements_user_id_foreign` (`user_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `advertisements`
--
ALTER TABLE `advertisements`
  ADD CONSTRAINT `advertisements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
