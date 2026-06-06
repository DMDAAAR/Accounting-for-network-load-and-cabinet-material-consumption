-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 07 2026 г., 01:41
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
  `photo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','in_progress','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'open',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `defects`
--

INSERT INTO `defects` (`id`, `title`, `point_id`, `category`, `severity`, `description`, `photo_path`, `status`, `created_by`, `created_at`) VALUES
(2, '2', 4, 'other', 'medium', '22', NULL, 'closed', 1, '2026-06-06 10:53:37'),
(3, 'ваыаыв', 15, 'other', 'medium', 'ываываыв', NULL, 'closed', 1, '2026-06-06 19:32:06'),
(4, 'ыаыаыаы', 15, 'other', 'medium', 'ываываывавыа', NULL, 'closed', 1, '2026-06-06 19:32:46'),
(5, 'вфвфывы', 13, 'other', 'medium', 'фвыфвфы', NULL, 'closed', 1, '2026-06-06 19:32:49'),
(6, 'чсячс', 15, 'other', 'medium', 'ясяс', NULL, 'closed', 1, '2026-06-06 19:33:50'),
(7, 'аываыва', 7, 'other', 'medium', 'ываываыв', NULL, 'closed', 1, '2026-06-06 19:38:15'),
(8, 'вфвф', 6, 'other', 'medium', 'вфывфыв', NULL, 'closed', 1, '2026-06-06 19:38:36'),
(13, 'гаро', 1, 'other', 'medium', 'расширение территории', NULL, 'closed', 1, '2026-06-06 22:19:24'),
(14, 'ыамвм', 14, 'other', 'medium', 'вмавм', '/superproject/uploads/defects/defect_6a24a1a144e71.jpg', 'open', 1, '2026-06-06 22:39:29');

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

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `target_table`, `target_id`, `created_at`) VALUES
(1, 1, 'Вошёл в систему', '', 0, '2026-06-06 21:19:14'),
(2, 1, 'Добавил новый дефект', 'defects', 0, '2026-06-06 21:24:46'),
(3, 1, 'Починил дефект #10 со списанием материалов', 'defects', 10, '2026-06-06 21:24:55'),
(4, 1, 'Починил дефект #4 со списанием материалов', 'defects', 4, '2026-06-06 21:26:34'),
(5, 1, 'Удалил дефект #10', 'defects', 10, '2026-06-06 21:27:36'),
(6, 1, 'Вошёл в систему', '', 0, '2026-06-06 22:08:39'),
(7, 1, 'Добавил новый дефект', 'defects', 0, '2026-06-06 22:17:07'),
(8, 1, 'Удалил дефект #11', 'defects', 11, '2026-06-06 22:17:12'),
(9, 1, 'Удалил дефект #9', 'defects', 9, '2026-06-06 22:17:14'),
(10, 1, 'Добавил новый дефект', 'defects', 0, '2026-06-06 22:18:03'),
(11, 1, 'Удалил дефект #12', 'defects', 12, '2026-06-06 22:18:23'),
(12, 1, 'Добавил новый дефект', 'defects', 0, '2026-06-06 22:19:24'),
(13, 1, 'Обновил дефект #13', 'defects', 13, '2026-06-06 22:20:11'),
(14, 1, 'Починил дефект #13 со списанием материалов', 'defects', 13, '2026-06-06 22:22:53'),
(15, 1, 'Добавил новый дефект', 'defects', 0, '2026-06-06 22:39:29');

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
(1, 'Кабель UTP 5e', 'cable', 'm', '400.00'),
(2, 'Коннектор RJ45', 'connector', 'pcs', '500.00'),
(3, 'Розетка RJ45', 'socket', 'pcs', '500.00');

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

--
-- Дамп данных таблицы `material_usage`
--

INSERT INTO `material_usage` (`id`, `material_id`, `quantity`, `point_id`, `defect_id`, `used_by`, `used_at`, `comment`) VALUES
(1, 1, '200.00', NULL, NULL, 1, '2026-06-06 23:21:18', 'Списано при починке дефекта #9'),
(2, 1, '700.00', NULL, 7, 1, '2026-06-06 23:41:35', 'Списано при починке дефекта #7'),
(3, 2, '400.00', NULL, 7, 1, '2026-06-06 23:41:35', 'Списано при починке дефекта #7'),
(4, 3, '199.00', NULL, 7, 1, '2026-06-06 23:41:35', 'Списано при починке дефекта #7'),
(5, 1, '200.00', NULL, 5, 1, '2026-06-06 23:55:32', 'Списано при починке дефекта #5'),
(6, 3, '300.00', NULL, 5, 1, '2026-06-06 23:55:32', 'Списано при починке дефекта #5'),
(7, 2, '500.00', NULL, 5, 1, '2026-06-06 23:55:32', 'Списано при починке дефекта #5'),
(8, 1, '200.00', NULL, NULL, 1, '2026-06-07 00:24:55', 'Списано при починке дефекта #10'),
(9, 3, '200.00', NULL, 4, 1, '2026-06-07 00:26:34', 'Списано при починке дефекта #4'),
(10, 1, '200.00', NULL, 13, 1, '2026-06-07 01:22:53', 'Списано при починке дефекта #13');

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
(1, 'андо', '$2y$10$7xm7tnRCOg/GJ6bRtYJZ9.ggNwMKB/v4.4hBzCxL2GHRAe8iYrEEy', 'admin');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `material_usage`
--
ALTER TABLE `material_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
