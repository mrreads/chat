-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 04 2020 г., 18:23
-- Версия сервера: 8.0.19
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `chat`
--

-- --------------------------------------------------------

--
-- Структура таблицы `grupi`
--

CREATE TABLE `grupi` (
  `id_grupi` int NOT NULL,
  `number_grupi` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `grupi`
--

INSERT INTO `grupi` (`id_grupi`, `number_grupi`) VALUES
(1, 'Группа 1'),
(2, 'Группа 2');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id_message` int NOT NULL,
  `text_message` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `time_message` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_author` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id_message`, `text_message`, `time_message`, `id_author`) VALUES
(88, 'Я пишу', '2020-07-04 18:11:52', 13),
(89, 'Я из первой группы!', '2020-07-04 18:11:56', 13),
(90, 'Я тоже пишу', '2020-07-04 18:12:16', 10),
(91, 'И я пишу вместе с вами', '2020-07-04 18:12:28', 2),
(92, 'Тестовое сообщение', '2020-07-04 18:21:21', 2),
(93, '*****', '2020-07-04 18:21:22', 2),
(94, 'Проверка', '2020-07-04 18:21:32', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id_role` int NOT NULL,
  `name_role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `name_role`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `login_user` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name_user` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_user` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_role` int NOT NULL,
  `id_grupi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `login_user`, `name_user`, `password_user`, `id_role`, `id_grupi`) VALUES
(1, 'admin', 'root', '123', 1, 1),
(2, 'user', 'Юзерь', '123', 2, 1),
(7, 'mrreads', 'ReaD', '123', 2, 1),
(8, '123', '123', '123', 2, 1),
(9, 'фывфывфы', 'фывфыв', 'фывфыв', 2, 1),
(10, 'zxc', 'zxc', 'zxc', 2, 1),
(11, 'qwe', 'dfasdf', '123', 2, 1),
(12, 'test_reg', 'test_reg', '123', 2, 1),
(13, 'qwer', 'Qwer', 'qwer', 2, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `grupi`
--
ALTER TABLE `grupi`
  ADD PRIMARY KEY (`id_grupi`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `author-id_user_idx` (`id_author`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_group` (`id_grupi`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `grupi`
--
ALTER TABLE `grupi`
  MODIFY `id_grupi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `author-id_user` FOREIGN KEY (`id_author`) REFERENCES `users` (`id_user`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_grupi`) REFERENCES `grupi` (`id_grupi`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
