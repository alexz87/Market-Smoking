-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Час створення: Трв 15 2022 р., 04:31
-- Версія сервера: 5.7.26
-- Версія PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База даних: `alexproger`
--

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(64) NOT NULL,
  `optional` varchar(32) NOT NULL,
  `price` int(11) UNSIGNED NOT NULL,
  `sale` int(11) UNSIGNED NOT NULL,
  `img` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `title`, `optional`, `price`, `sale`, `img`) VALUES
(11, 'Одноразовая pod-система Elf Bar 1500 Disposable', 'Банан', 300, 50, 'item-1.png'),
(21, 'Электронная сигарета Joyetech VAAL 1500 Puffs 5%', 'Банан', 230, 0, 'item-2.png'),
(31, 'Электронная сигарета Puff Bar Plus Disposable', 'Банан', 549, 0, 'item-3.png'),
(12, 'Одноразовая pod-система Elf Bar 1500 Disposable', 'Клубника', 300, 50, 'item-1.png'),
(13, 'Одноразовая pod-система Elf Bar 1500 Disposable', 'Вишня', 300, 50, 'item-1.png'),
(14, 'Одноразовая pod-система Elf Bar 1500 Disposable', 'Малина', 300, 50, 'item-1.png'),
(22, 'Электронная сигарета Joyetech VAAL 1500 Puffs 5%', 'Клубника', 230, 0, 'item-2.png'),
(23, 'Электронная сигарета Joyetech VAAL 1500 Puffs 5%', 'Вишня', 230, 0, 'item-2.png'),
(24, 'Электронная сигарета Joyetech VAAL 1500 Puffs 5%', 'Малина', 230, 0, 'item-2.png'),
(32, 'Электронная сигарета Puff Bar Plus Disposable', 'Клубника', 549, 0, 'item-3.png'),
(33, 'Электронная сигарета Puff Bar Plus Disposable', 'Вишня', 549, 0, 'item-3.png'),
(34, 'Электронная сигарета Puff Bar Plus Disposable', 'Малина', 549, 0, 'item-3.png');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `id` (`id`);
