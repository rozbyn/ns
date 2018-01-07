-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 03 2018 г., 16:53
-- Версия сервера: 10.1.25-MariaDB
-- Версия PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `forum_themes`
--

CREATE TABLE `forum_themes` (
  `id` int(4) NOT NULL,
  `user_name` varchar(45) DEFAULT 'NULL',
  `theme_name` varchar(50) DEFAULT 'NULL',
  `message` varchar(4500) DEFAULT 'NULL',
  `time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Темы форума';

--
-- Дамп данных таблицы `forum_themes`
--

INSERT INTO `forum_themes` (`id`, `user_name`, `theme_name`, `message`, `time`) VALUES
(1, 'Рома', 'Первая тема форума', 'Это превая тема моего первого форума, пишите что думаете об этом', 1508691461),
(2, 'Рома', 'Вторая тема форума', 'Это вторая тема моего первого форума, пишите что думаете об этом', 1508691462),
(3, 'Рома', 'Третья тема форума', 'Это третья тема моего первого форума, пишите что думаете об этом', 1508691463),
(4, 'Рома', 'Четвертая тема форума', 'Это четвертая тема моего первого форума, пишите что думаете об этом', 1508691464),
(5, 'Рома', 'Пятая тема форума', 'Это пятая тема моего первого форума, пишите что думаете об этом', 1508691465),
(6, 'Рома', 'Шестая тема форума', 'Это шестая тема моего первого форума, пишите что думаете об этом', 1508691466),
(7, 'Рома', 'Седьмая тема форума', 'Это седьмая тема моего первого форума, пишите что думаете об этом', 1508691467),
(8, 'Рома', 'Восьмая тема форума', 'Это восьмая тема моего первого форума, пишите что думаете об этом', 1508691468),
(9, 'fvdf', 'fdvdvdv', 'fvdfvdvfd', 1514393421),
(10, 'ddd', 'saddas', 'dd', 1514393593),
(11, 'ccvcvv', 'bvbcvvbc', 'bvccbbcvbcv', 1514472383),
(12, 'gggg', 'gggg', 'gggg', 1514986065);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `forum_themes`
--
ALTER TABLE `forum_themes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `forum_themes`
--
ALTER TABLE `forum_themes`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
