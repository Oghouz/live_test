-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  Dim 05 fév. 2023 à 16:49
-- Version du serveur :  5.7.28
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `video_chat`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `type`, `name`, `first_name`, `last_name`, `email`, `password`, `remember_token`, `activated`, `created_at`, `updated_at`) VALUES
(1, 1, 'Administrator', 'Merdan', 'Memet', 'admin@admin.com', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', NULL, 1, '2023-02-03 08:57:24', '2023-02-03 08:57:26');

-- --------------------------------------------------------

--
-- Structure de la table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `live_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sender` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_live_id_foreign` (`live_id`),
  KEY `chat_messages_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `live_id`, `user_id`, `sender`, `message`, `created_at`) VALUES
(1, 11, 3, 'Moussine', 'hjkhjkh', '2022-12-12 20:04:57'),
(2, 11, 1, 'Mardan', 'hkjhkjhjkuioio', '2022-12-12 20:05:13'),
(3, 11, 3, 'Moussine', 'iouiouioiou564654 hjghhjghj', '2022-12-12 20:05:16'),
(4, 11, 1, 'Mardan', 'fdf4 45fd4g56df4 56g4f5d6 gdfgjkj  jkhjkhjk\nkljkljklj', '2022-12-12 20:05:22'),
(5, 11, 3, 'Moussine', 'ghjghjghjg', '2022-12-12 20:10:20'),
(6, 11, 3, 'Moussine', '123', '2022-12-12 20:14:59'),
(7, 11, 3, 'Moussine', 'hjkhjkhjk', '2022-12-12 20:22:51'),
(8, 17, 3, 'Moussine', 'jkljkljkl', '2023-01-31 13:57:52'),
(9, 17, 1, 'Mardan', 'fgdffdshghjhghjkgh khjgk', '2023-01-31 13:58:10'),
(10, 17, 1, 'Mardan', 'test message from admin', '2023-01-31 18:43:06'),
(11, 17, 3, 'Moussine', 'Hi:)', '2023-01-31 18:43:20'),
(12, 17, 3, 'Moussine', 'dqsfsdfsd', '2023-01-31 19:12:23'),
(13, 17, 1, 'Mardan', 'dfrsdfgdgdsfg', '2023-01-31 19:12:28');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `live`
--

DROP TABLE IF EXISTS `live`;
CREATE TABLE IF NOT EXISTS `live` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) NOT NULL,
  `started_at` datetime DEFAULT NULL,
  `ended_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chat` tinyint(1) NOT NULL DEFAULT '0',
  `onLive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `live`
--

INSERT INTO `live` (`id`, `title`, `description`, `created_by`, `started_at`, `ended_at`, `created_at`, `updated_at`, `token`, `chat`, `onLive`) VALUES
(13, 'demo 1', 'c\'est un test', 3, '2022-11-22 18:29:59', NULL, '2022-11-22 17:29:56', '2022-11-22 17:29:56', NULL, 0, 0),
(12, 'demo 1', 'dfdsfq dfqsd fqsdf d', 3, '2022-11-22 17:42:31', '2022-11-22 15:16:35', '2022-11-22 14:16:13', '2022-11-22 14:16:13', NULL, 0, 0),
(11, 'Demo Live 11', 'Captation monocam ou multicam, streaming live ou enregistrement pour la postproduction. Plateforme centralisée. Services: Accompagnement sur mesure, Un seul interlocuteur, Un panel de service, Captation et diffusion, Interaction en direct.\r\n\r\nCaptation et diffusion de la vidéo de votre événement hybride en live streaming à partir de 1990 euros. Estimation immédiate et devis en ligne.', 1, '2022-12-19 10:33:57', '2022-12-19 10:31:11', '2022-11-22 07:49:16', '2022-11-22 07:49:16', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c', 0, 0),
(10, 'diffusion réunion dev', 'concernant le project live stream', 1, '2022-11-22 08:35:46', '2022-11-22 09:30:00', '2022-11-22 07:35:36', '2022-11-22 07:35:36', NULL, 0, 0),
(8, 'TEST 1', 'c\'est une test', 1, '2022-11-21 22:42:46', '2022-11-21 22:45:03', '2022-11-21 21:01:09', '2022-11-21 21:01:09', NULL, 0, 0),
(9, 'test 2', '456456456456', 1, '2022-11-22 07:52:41', '2022-11-22 07:58:10', '2022-11-22 06:52:37', '2022-11-22 06:52:37', NULL, 0, 0),
(14, 'demo 3', 'huhyg uiyuiyui yuiy iuyui', 3, '2022-11-22 19:11:35', NULL, '2022-11-22 18:09:10', '2022-11-22 18:09:10', NULL, 0, 0),
(15, 'demo 1', 'kjkljkljkl', 3, '2022-11-22 19:15:50', NULL, '2022-11-22 18:15:46', '2022-11-22 18:15:46', NULL, 0, 0),
(16, 'demo 1', 'ghrhhjyn', 3, '2022-11-22 19:19:32', '2022-11-22 19:21:53', '2022-11-22 18:19:30', '2022-11-22 18:19:30', NULL, 0, 0),
(17, 'Dior the fall winter 2023-24 fashion show in live streaming', 'At Paris Fashion Week, the Kim Jones fashion show will be streamed live on Friday 20 January at 3.00 pm.\r\n', 1, '2023-02-04 20:42:32', '2023-01-31 18:52:15', '2023-01-31 12:05:04', '2023-01-31 12:05:04', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_01_11_162018_add_login_meta_data_to_users_table', 1),
(6, '2021_01_19_152802_create_wossop_messages_table', 1),
(7, '2021_01_27_170401_add_about_and_avatar_to_users_table', 1),
(8, '2022_11_21_165809_create_live_table', 2),
(9, '2022_12_09_082333_create_chat_messages_table', 3),
(10, '2023_02_03_084655_create_admin_table', 4);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `avatar_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`, `last_login_at`, `last_login_ip`, `about`, `avatar_path`) VALUES
(1, 'Mardan', 'mardan@test.com', '2022-10-20 07:39:05', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', 1, NULL, '2022-10-17 09:20:00', '2022-10-17 09:20:02', NULL, NULL, NULL, NULL),
(2, 'Raziye', 'raziye@test.com', '2022-10-20 07:39:07', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', 2, NULL, '2022-10-17 09:20:17', '2022-10-17 09:20:19', NULL, NULL, NULL, NULL),
(3, 'Moussine', 'moussine@test.com', '2022-10-21 07:39:05', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', 2, 'iAHQzsqVtAKZMR0cHSrEfRkeyiCXg9Fv5ElKUKiU5lcKS11jdpi9QUAEw6Mo', '2022-10-17 11:44:19', '2022-10-17 11:44:22', NULL, NULL, NULL, NULL),
(4, 'Oghouz', 'oghouz@test.com', '2022-10-21 07:39:05', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', 2, NULL, '2022-10-21 07:38:17', '2022-10-21 07:38:23', NULL, NULL, NULL, NULL),
(5, 'Oghlan', 'oghlan@test.com', '2022-10-21 07:39:05', '$2y$10$BuV/ff4yOv97jh5TB/oWqeDCXdGKOt8I1JlgLKiKGYkuijmC/ccW2', 2, NULL, '2022-10-21 07:38:37', '2022-10-21 07:38:41', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `wossop_messages`
--

DROP TABLE IF EXISTS `wossop_messages`;
CREATE TABLE IF NOT EXISTS `wossop_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `receiver` bigint(20) UNSIGNED NOT NULL,
  `sender` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
