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
-- Структура таблицы `forum_answers`
--

CREATE TABLE `forum_answers` (
  `id` int(11) NOT NULL,
  `id_of_theme` int(4) DEFAULT '0',
  `user_name` varchar(45) DEFAULT 'NULL',
  `message` varchar(4500) DEFAULT 'NULL',
  `time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Ответы в темах';

--
-- Дамп данных таблицы `forum_answers`
--

INSERT INTO `forum_answers` (`id`, `id_of_theme`, `user_name`, `message`, `time`) VALUES
(1, 1, 'Рома', 'Я думаю, что это неплохое начало123', 1508691684),
(2, 1, 'Рома', 'Я думаю, что это неплохое начало123', 1508691685),
(3, 1, 'Рома', 'Я думаю, что это неплохое начало123', 1508691686),
(4, 1, 'Рома', 'Я думаю, что это неплохое начало123', 1508691687),
(5, 2, 'Рома', 'Я думаю, что это неплохое начало123', 1508691688),
(6, 2, 'Рома', 'Я думаю, что это неплохое начало123', 1508691689),
(7, 2, 'Рома', 'Я думаю, что это неплохое начало123', 1508691690),
(8, 2, 'Рома', 'Я думаю, что это неплохое начало123', 1508691691),
(9, 8, 'roman', 'it\'s very good', 1514473478),
(10, 8, 'ro', NULL, 1514473565),
(11, 8, 'goga ', 'go go power rangers!', 1514473617),
(12, 8, 'kome on', 'sadma privet', 1514474045),
(13, 1, 'ДА', 'ЭТО ПЕЗДАТОЕ НАЧАЛО', 1514474094),
(14, 1, 'рпар', 'апрпар', 1514474116),
(15, 1, 'орорпоп', 'опроо', 1514474121),
(16, 1, 'bhhf', 'ghfhfghg', 1514474209),
(17, 1, 'asdasd', 'asdasdasd', 1514474824),
(18, 1, 'asdadasd', 'asdasd', 1514474829),
(19, 1, 'LFKFyf ', 'oijasdalksjd\r\nasdlkajdlskad\r\nasdl;kjasd\r\n', 1514474863),
(20, 1, 'dssrrsrs', 'g\r\ng\r\ng\r\ng\r\ng\r\n', 1514474890),
(21, 11, 'Что за вопрос?', 'А?\r\n', 1514474950),
(22, 11, 'апераап', 'рапрара', 1514481606),
(23, 4, '\'l;\'l\'', 'k;jkjip89', 1514986053),
(24, 12, 'xcvxcvv', 'xcvxcvxv', 1514986070);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `forum_answers`
--
ALTER TABLE `forum_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_of_theme` (`id_of_theme`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `forum_answers`
--
ALTER TABLE `forum_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `forum_answers`
--
ALTER TABLE `forum_answers`
  ADD CONSTRAINT `forum_answers_ibfk_1` FOREIGN KEY (`id_of_theme`) REFERENCES `forum_themes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
