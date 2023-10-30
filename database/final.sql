-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: db
-- Время создания: Окт 30 2023 г., 07:05
-- Версия сервера: 8.1.0
-- Версия PHP: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `final`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'test', '2023-10-08 08:47:34', '2023-10-08 08:47:34');

-- --------------------------------------------------------

--
-- Структура таблицы `offers`
--

CREATE TABLE `offers` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `offers`
--

INSERT INTO `offers` (`id`, `user_id`, `name`, `description`, `price`, `url`, `active`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 2, 'Новый', 'test', 15, 'test.ru', 1, 0, '2023-10-30 06:52:10', '2023-10-30 06:52:10');

-- --------------------------------------------------------

--
-- Структура таблицы `statistics`
--

CREATE TABLE `statistics` (
  `id` int UNSIGNED NOT NULL,
  `webmaster_id` int UNSIGNED DEFAULT NULL,
  `advertiser_id` int UNSIGNED DEFAULT NULL,
  `offer_id` int UNSIGNED DEFAULT NULL,
  `price` int UNSIGNED DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `hash` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `rejection` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `statistics`
--

INSERT INTO `statistics` (`id`, `webmaster_id`, `advertiser_id`, `offer_id`, `price`, `url`, `hash`, `rejection`, `created_at`) VALUES
(1, 3, 2, 1, 15, 'test.ru', 'aadf4c0ddc0057368026e5f21eb4fabf67185c8358bc3a95fef5c02d3d7dad6b', 0, '2023-10-30 06:57:25');

-- --------------------------------------------------------

--
-- Структура таблицы `subscribe`
--

CREATE TABLE `subscribe` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `offer_id` int UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `hash` varchar(70) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `subscribe`
--

INSERT INTO `subscribe` (`id`, `user_id`, `offer_id`, `name`, `price`, `url`, `hash`, `active`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Новый', 15, 'test.ru', 'aadf4c0ddc0057368026e5f21eb4fabf67185c8358bc3a95fef5c02d3d7dad6b', 1, 0, '2023-10-30 06:56:15', '2023-10-30 06:56:15');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test@test.test', '$2y$10$CKCn7ZJ76lujhhN6nRUgKuLcrxbY.mCGF9tpu5nkGLbrIQAxv8t/.', 'admin', 'active', '2023-10-08 08:44:01', '2023-10-08 08:44:01'),
(2, 'Рекламодатель', 'test2@test.test', '$2y$10$s8UJALNJAh5PvOmQRfDjmO2e6qls6AGhsommXNnGo8RPDDP1rVQeW', 'advertiser', 'active', '2023-10-30 06:50:13', '2023-10-30 06:50:13'),
(3, 'Вебмастер', 'test3@test.test', '$2y$10$FRIQahulSZSfCMqJs6SkPeLOZp2l42eq5LZQIQVqBxusphJpBTOg2', 'webmaster', 'active', '2023-10-30 06:52:49', '2023-10-30 06:52:49');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`user_id`);

--
-- Индексы таблицы `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_statistics_webmaster` (`webmaster_id`),
  ADD KEY `index_foreignkey_statistics_advertiser` (`advertiser_id`),
  ADD KEY `index_foreignkey_statistics_offer` (`offer_id`);

--
-- Индексы таблицы `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`offer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subscribe`
--
ALTER TABLE `subscribe`
  ADD CONSTRAINT `subscribe_ibfk_1` FOREIGN KEY (`offer_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscribe_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
