-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 14 2026 г., 11:04
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `server`
--

-- --------------------------------------------------------

--
-- Структура таблицы `divisions`
--

CREATE TABLE `divisions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `divisions`
--

INSERT INTO `divisions` (`id`, `name`, `type`) VALUES
(1, 'razdel_1', 'razdel_1'),
(2, 'razdel_2', 'razdel_2');

-- --------------------------------------------------------

--
-- Структура таблицы `phones`
--

CREATE TABLE `phones` (
  `id` int(10) UNSIGNED NOT NULL,
  `number` varchar(50) NOT NULL,
  `premise_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `phones`
--

INSERT INTO `phones` (`id`, `number`, `premise_id`) VALUES
(1, '88005553535', 1),
(2, '89234470499', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `premises`
--

CREATE TABLE `premises` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `division_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `premises`
--

INSERT INTO `premises` (`id`, `name`, `type`, `division_id`) VALUES
(1, '402', 'ad', 1),
(2, '302', 'rai', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `patronymic` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `division_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `subscribers`
--

INSERT INTO `subscribers` (`id`, `lastname`, `firstname`, `patronymic`, `birthdate`, `division_id`) VALUES
(1, 'qwe', 'qwe', 'qwe', '1982-03-10', 1),
(2, 'artem', 'artem', 'artem', '1967-10-11', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `subscriber_phone`
--

CREATE TABLE `subscriber_phone` (
  `id` int(10) UNSIGNED NOT NULL,
  `subscriber_id` int(10) UNSIGNED NOT NULL,
  `phone_id` int(10) UNSIGNED NOT NULL,
  `assigned_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `subscriber_phone`
--

INSERT INTO `subscriber_phone` (`id`, `subscriber_id`, `phone_id`, `assigned_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-01-14 08:44:33', '2026-01-14 08:44:33', '2026-01-14 08:44:33'),
(2, 2, 2, '2026-01-14 08:49:46', '2026-01-14 08:49:46', '2026-01-14 08:49:46');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'sysadmin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `phone`, `login`, `password`, `role`) VALUES
(1, 'viski', 'viski', NULL, 'viski', 'a839042285ff543ca009bceff233d213', 'admin'),
(2, 'alibabu', 'alibabu', NULL, 'alibabu', '3fa6985e30ccfb37655dc7cd35cdfba3', 'sysadmin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phones_number_unique` (`number`),
  ADD KEY `phones_premise_id_index` (`premise_id`);

--
-- Индексы таблицы `premises`
--
ALTER TABLE `premises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `premises_division_id_index` (`division_id`);

--
-- Индексы таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscribers_division_id_index` (`division_id`);

--
-- Индексы таблицы `subscriber_phone`
--
ALTER TABLE `subscriber_phone`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriber_phone_phone_id_unique` (`phone_id`),
  ADD KEY `subscriber_phone_subscriber_id_index` (`subscriber_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `premises`
--
ALTER TABLE `premises`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `subscriber_phone`
--
ALTER TABLE `subscriber_phone`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_premise_id_fk` FOREIGN KEY (`premise_id`) REFERENCES `premises` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `premises`
--
ALTER TABLE `premises`
  ADD CONSTRAINT `premises_division_id_fk` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD CONSTRAINT `subscribers_division_id_fk` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subscriber_phone`
--
ALTER TABLE `subscriber_phone`
  ADD CONSTRAINT `subscriber_phone_phone_id_fk` FOREIGN KEY (`phone_id`) REFERENCES `phones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriber_phone_subscriber_id_fk` FOREIGN KEY (`subscriber_id`) REFERENCES `subscribers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
