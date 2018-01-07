-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 03 2018 г., 16:48
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
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`id`, `name`, `age`, `salary`) VALUES
(65, 'Дима', 23, 500),
(66, 'Петя', 25, 500),
(68, 'Коля', 30, 1000),
(69, 'Иван', 27, 500),
(70, 'Кирилл', 28, 1000),
(71, 'Дима', 23, 400),
(72, 'Петя', 25, 500),
(74, 'Коля', 30, 1000),
(75, 'Иван', 27, 500),
(76, 'Кирилл', 28, 1000),
(78, 'Петя', 25, 500),
(79, 'Вася', 23, 500),
(81, 'Иван', 27, 500),
(83, 'Дима', 23, 400),
(84, 'Петя', 25, 500),
(85, 'Вася', 23, 500);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
