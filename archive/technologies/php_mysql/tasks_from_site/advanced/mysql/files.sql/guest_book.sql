-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Янв 03 2018 г., 16:51
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
-- Структура таблицы `guest_book`
--

CREATE TABLE `guest_book` (
  `record_id` int(11) NOT NULL,
  `date_time` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Message` varchar(4500) NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT '127.0.0.1',
  `public` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `guest_book`
--

INSERT INTO `guest_book` (`record_id`, `date_time`, `Name`, `Message`, `ip_address`, `public`) VALUES
(1, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(2, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(3, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(4, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(5, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(6, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(7, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(8, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(9, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(10, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(11, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(12, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(13, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(14, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(15, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(16, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(17, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(18, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(19, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(20, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(21, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(22, 1508073606, 'dadadasd', 'sadadasdasd', '::1', 1),
(23, 1508073606, '5196511', '956+2226++2+2+62625262', '::1', 1),
(24, 1508073606, '5196511', '956+2226++2+2+62625262', '::1', 1),
(25, 1508073606, 'yhfghfhfgh', 'fghfghfhfh g hf  hfh', '::1', 1),
(26, 1508073674, 'Вузап', 'Кэ\\\\\\\'мон мадафака', '::1', 1),
(27, 1508073763, 'Вузап', 'Кэ\\\'мон мадафака', '::1', 1),
(28, 1508073823, 'Вузап', 'Кэ\'мон мадафака', '::1', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `guest_book`
--
ALTER TABLE `guest_book`
  ADD PRIMARY KEY (`record_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `guest_book`
--
ALTER TABLE `guest_book`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
