-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 06 2026 г., 13:58
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `record_keeping`
--

-- --------------------------------------------------------

--
-- Структура таблицы `defects`
--

CREATE TABLE `defects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point_id` int(11) NOT NULL,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` enum('high','medium','low') COLLATE utf8mb4_unicode_ci DEFAULT 'medium',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('open','in_progress','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `defects`
--

INSERT INTO `defects` (`id`, `title`, `point_id`, `category`, `severity`, `description`, `status`, `photo_path`, `created_by`, `created_at`) VALUES
(2, '2', 4, 'other', 'medium', '22', 'open', NULL, 1, '2026-06-06 10:53:37');

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('room','rack','workspace','other') COLLATE utf8mb4_unicode_ci DEFAULT 'room',
  `room_number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '319Б'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `room_number`) VALUES
(1, 'Кабинет 335', 'room', '335А'),
(2, 'Кабинет 319', 'room', '319Б'),
(3, 'Кабинет 311', 'room', '311'),
(4, 'Кабинет 345', 'room', '345'),
(5, 'Кабинет 301', 'room', '301');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cable','connector','socket','fastener','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` enum('m','pcs') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `materials`
--

INSERT INTO `materials` (`id`, `name`, `type`, `unit`, `quantity`) VALUES
(1, 'Кабель UTP 5e', 'cable', 'm', '980.00'),
(2, 'Коннектор RJ45', 'connector', 'pcs', '499.00'),
(3, 'Розетка RJ45', 'socket', 'pcs', '200.00');

-- --------------------------------------------------------

--
-- Структура таблицы `material_usage`
--

CREATE TABLE `material_usage` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `point_id` int(11) DEFAULT NULL,
  `defect_id` int(11) DEFAULT NULL,
  `used_by` int(11) NOT NULL,
  `used_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `network_points`
--

CREATE TABLE `network_points` (
  `id` int(11) NOT NULL,
  `label` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('socket','switch','cable_run','patch_cord') COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `location_end_id` int(11) DEFAULT NULL,
  `status` enum('active','defect','decommissioned') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `last_check` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `network_points`
--

INSERT INTO `network_points` (`id`, `label`, `type`, `location_id`, `location_end_id`, `status`, `last_check`) VALUES
(1, 'Розетка-01', 'socket', 2, NULL, 'active', '2026-06-01'),
(2, 'Розетка-02', 'socket', 2, NULL, 'active', '2026-06-01'),
(3, 'Розетка-03', 'socket', 2, NULL, 'active', '2026-06-01'),
(4, 'Розетка-04', 'socket', 2, NULL, 'active', '2026-06-01'),
(5, 'Розетка-05', 'socket', 2, NULL, 'active', '2026-06-01'),
(6, 'Розетка-06', 'socket', 2, NULL, 'active', '2026-06-01'),
(7, 'Розетка-07', 'socket', 2, NULL, 'active', '2026-06-01'),
(8, 'Розетка-08', 'socket', 2, NULL, 'active', '2026-06-01'),
(9, 'Кабель-01', 'cable_run', 2, 1, 'active', '2026-05-28'),
(10, 'Кабель-02', 'cable_run', 2, 1, 'active', '2026-05-28'),
(11, 'Кабель-03', 'cable_run', 2, 1, 'active', '2026-05-28'),
(12, 'Кабель-044', 'cable_run', 2, 1, 'active', '2026-05-28'),
(13, 'Патч-корд-01', 'patch_cord', 2, NULL, 'active', '2026-06-01'),
(14, 'Патч-корд-02', 'patch_cord', 2, NULL, 'active', '2026-06-01'),
(15, 'Патч-корд-03', 'patch_cord', 2, NULL, 'active', '2026-06-01'),
(16, 'Патч-корд-044', 'patch_cord', 5, NULL, 'active', '2026-06-06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','operator') COLLATE utf8mb4_unicode_ci DEFAULT 'operator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password_hash`, `role`) VALUES
(1, 'андо', '$2y$10$7xm7tnRCOg/GJ6bRtYJZ9.ggNwMKB/v4.4hBzCxL2GHRAe8iYrEEy', 'operator');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `defects`
--
ALTER TABLE `defects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `point_id` (`point_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material_usage`
--
ALTER TABLE `material_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_id` (`material_id`),
  ADD KEY `point_id` (`point_id`),
  ADD KEY `defect_id` (`defect_id`),
  ADD KEY `used_by` (`used_by`);

--
-- Индексы таблицы `network_points`
--
ALTER TABLE `network_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label` (`label`),
  ADD KEY `location_id` (`location_id`),
  ADD KEY `fk_network_points_location_end` (`location_end_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `defects`
--
ALTER TABLE `defects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `material_usage`
--
ALTER TABLE `material_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `network_points`
--
ALTER TABLE `network_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `defects`
--
ALTER TABLE `defects`
  ADD CONSTRAINT `defects_ibfk_1` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `defects_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `material_usage`
--
ALTER TABLE `material_usage`
  ADD CONSTRAINT `material_usage_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  ADD CONSTRAINT `material_usage_ibfk_2` FOREIGN KEY (`point_id`) REFERENCES `network_points` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_usage_ibfk_3` FOREIGN KEY (`defect_id`) REFERENCES `defects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `material_usage_ibfk_4` FOREIGN KEY (`used_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
