-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 15 2017 г., 11:32
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myblog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` mediumint(9) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(500) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `created_at`, `title`, `text`) VALUES
(1, 2, '2017-03-16 04:19:24', '', 'Ilya\'s example post'),
(42, 2, '2017-03-30 11:24:25', 'qwe123', 'pochta2id@gmail.com'),
(43, 2, '2017-03-30 11:24:37', '111', '222'),
(44, 2, '2017-03-30 11:25:28', '222', '333'),
(45, 2, '2017-03-30 15:00:47', '21', '12'),
(46, 2, '2017-03-30 15:09:53', '3333', '44444'),
(47, 2, '2017-03-30 15:13:16', '34343', 'dfdfdf'),
(48, 2, '2017-03-30 15:13:44', '23', '2323'),
(49, 2, '2017-03-30 15:13:52', '23', '2323dfdf'),
(50, 2, '2017-03-30 15:25:25', '12', '21'),
(51, 2, '2017-03-30 15:26:30', '999', '8888'),
(52, 2, '2017-03-30 15:27:02', '343434', 'dfdfdf'),
(53, 2, '2017-03-30 15:27:48', '11111', '222222'),
(54, 2, '2017-03-30 15:28:50', '22222', '33333'),
(55, 2, '2017-03-30 15:29:34', 'My first real post', 'It was very long story. But i need it. I wanted to know it.'),
(56, 2, '2017-03-30 15:29:50', 'Second one', 'It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. It was very long story. But i need it. I wanted to know it. '),
(57, 2, '2017-03-30 15:34:06', '2', ''),
(58, 2, '2017-03-30 15:40:53', '2112', '1212'),
(59, 2, '2017-03-30 15:48:55', '1', '2'),
(60, 2, '2017-03-30 15:54:01', '', ''),
(61, 2, '2017-03-30 15:54:36', '', ''),
(62, 2, '2017-03-30 16:04:02', '', ''),
(63, 2, '2017-03-30 16:04:09', '2121', ''),
(64, 2, '2017-03-30 16:11:11', '', ''),
(65, 2, '2017-03-30 16:11:18', '1212', ''),
(66, 2, '2017-03-30 16:12:03', '', ''),
(67, 2, '2017-03-30 16:15:51', '1', '2'),
(68, 2, '2017-03-30 16:15:55', '', ''),
(69, 2, '2017-03-30 16:15:59', '', ''),
(70, 2, '2017-03-30 16:23:00', '333', '4444'),
(71, 2, '2017-03-30 16:24:20', '32323', '232323'),
(72, 2, '2017-03-30 16:25:06', '', ''),
(73, 2, '2017-03-30 16:25:08', '', ''),
(74, 2, '2017-03-30 16:25:44', '11', ''),
(75, 2, '2017-03-30 16:25:44', '11', ''),
(76, 2, '2017-03-30 16:26:05', '6666', ''),
(77, 2, '2017-03-30 16:26:05', '6666', ''),
(78, 2, '2017-03-30 16:31:57', '777', ''),
(79, 2, '2017-03-30 16:31:57', '777', ''),
(80, 2, '2017-03-30 16:33:01', '888', ''),
(81, 2, '2017-03-30 16:33:01', '888', ''),
(82, 2, '2017-03-30 16:37:09', '1111', ''),
(83, 2, '2017-03-30 16:37:09', '1111', ''),
(84, 2, '2017-03-30 16:40:40', '2222', ''),
(85, 2, '2017-03-30 16:41:32', '', ''),
(86, 2, '2017-03-30 16:41:41', '', ''),
(87, 2, '2017-03-30 16:43:40', '21', ''),
(88, 2, '2017-03-30 16:44:07', '33', ''),
(89, 2, '2017-03-30 16:45:49', '44444', ''),
(90, 2, '2017-03-30 16:56:32', '6666', ''),
(91, 2, '2017-03-30 16:58:12', '', ''),
(92, 2, '2017-03-30 16:59:50', '21212', 'dfdf'),
(93, 2, '2017-03-30 17:02:01', '222', 'gggggggg'),
(94, 2, '2017-03-31 02:41:37', '898', '       '),
(95, 2, '2017-03-31 04:38:50', 'dfdfdf dfdfdf d', ''),
(96, 2, '2017-03-31 05:38:55', 'dfdf', '1212'),
(97, 2, '2017-03-31 05:59:45', '212', 'dfdfdf'),
(98, 2, '2017-03-31 05:59:49', 'dfd', 'fdfdfd'),
(99, 2, '2017-03-31 06:03:56', '', ''),
(100, 2, '2017-03-31 06:04:39', '4545454', ''),
(101, 2, '2017-03-31 06:04:47', '', ''),
(102, 2, '2017-03-31 06:06:58', '', ''),
(103, 2, '2017-03-31 06:07:03', '', 'fdfdfd'),
(104, 2, '2017-03-31 06:08:51', '', 'dfdf'),
(105, 2, '2017-03-31 06:08:55', 'ffffffffff', ''),
(106, 2, '2017-03-31 06:09:01', 'f', ''),
(107, 2, '2017-03-31 06:13:27', '', 'dfdfd'),
(108, 2, '2017-03-31 06:14:00', '21212', ''),
(109, 2, '2017-03-31 06:14:04', '55555555555', ''),
(110, 2, '2017-03-31 06:14:37', '', ''),
(111, 2, '2017-03-31 06:16:10', 'dfdf', 'dfdfd'),
(112, 2, '2017-03-31 06:16:14', '22222221', ''),
(113, 2, '2017-03-31 06:16:57', '', ''),
(114, 2, '2017-03-31 06:17:07', '', ''),
(115, 2, '2017-03-31 06:17:14', 'dfdfd', 'dfdf'),
(116, 2, '2017-03-31 06:19:42', 'ggggggghhh', 'dfasfddsa'),
(117, 2, '2017-03-31 06:25:00', 'dfdfdfdf', 'dfdfdf'),
(118, 2, '2017-03-31 06:27:03', 'dfdf', 'dfdfdf'),
(119, 2, '2017-05-20 03:05:03', 'my new post', 'this is text'),
(120, 2, '2017-05-20 03:07:29', 'one more post', 'text of this post\nla la la\ntra ta ta'),
(121, 2, '2017-05-20 03:07:52', 'more and more', 'text also'),
(122, 2, '2017-05-20 03:08:12', 'little', 'yes'),
(123, 2, '2017-05-20 03:08:20', 'super', 'new'),
(124, 2, '2017-05-20 03:11:25', 'yes yes yes', 'no no'),
(125, 2, '2017-05-20 03:11:33', 'yes', 'no'),
(126, 2, '2017-05-20 03:14:07', '123', 'dsds'),
(127, 2, '2017-05-20 03:14:12', 'fdfd', 'dfdfdf'),
(128, 2, '2017-05-20 03:14:20', 'dfdf', 'dfdfdf'),
(129, 2, '2017-05-20 03:14:31', 'dfdfd', 'fdfdf'),
(130, 2, '2017-05-20 03:16:11', '1212', '12'),
(131, 2, '2017-05-20 03:16:45', '12212', '12121'),
(132, 2, '2017-05-20 03:19:50', 'sds', 'dsd'),
(133, 2, '2017-05-20 03:19:55', '555', '454545'),
(134, 2, '2017-05-20 03:20:11', 'dfdfd', 'fdfa'),
(135, 2, '2017-05-20 03:20:15', '343', 'ddf'),
(136, 2, '2017-05-20 03:20:59', '999', '909090'),
(137, 2, '2017-05-20 03:36:00', '00000000', '000000000000');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` smallint(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hash` varchar(1000) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `hash`, `email`) VALUES
(2, 'ilya', '$2y$10$o.0aKSJPwh06h8oInc4ZnO71Gi4qAybq1xnNiuSnsu3DS6xABLAOC', 'pochta2id@gmail.com');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
