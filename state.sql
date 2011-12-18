-- phpMyAdmin SQL Dump
-- version 3.4.9-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2011 at 05:10 PM
-- Server version: 5.5.19
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `state`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` int(10) NOT NULL,
  `city` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `city`) VALUES
(1, 1, 'Москва'),
(2, 1, 'Уфа'),
(3, 1, 'Екатеринбург'),
(4, 2, 'Пхукет'),
(5, 2, 'Паттая'),
(6, 2, 'Чиангмай'),
(7, 3, 'Джакарта'),
(8, 3, 'Денпасар'),
(9, 3, 'Кута');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pkey',
  `country` varchar(128) NOT NULL COMMENT 'название страны',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country`) VALUES
(1, 'Россия'),
(2, 'Таиланд'),
(3, 'Индонезия');

-- --------------------------------------------------------

--
-- Table structure for table `estates`
--

CREATE TABLE IF NOT EXISTS `estates` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pkey',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'UTC время создания объекта',
  `type_id` int(10) NOT NULL COMMENT 'тип объекта',
  `city_id` int(10) NOT NULL COMMENT 'связь с городом',
  `stars` tinyint(4) NOT NULL COMMENT 'кол-во звёзд',
  `rooms` tinyint(4) NOT NULL COMMENT 'кол-во комнат',
  `bar` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'бар 1 : 0',
  `pool` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'бассейн 1 : 0',
  `bath` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'ванная 1 : 0',
  `shower` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'душ 1 : 0',
  `cctv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'видео-наблюдение 1 : 0',
  `internet` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'интернет 1 : 0',
  `tv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'кабельное 1 : 0',
  `parking` tinyint(1) NOT NULL COMMENT 'парковка 1 : 0',
  `title` varchar(255) NOT NULL COMMENT 'название объекта',
  `description` varchar(1024) NOT NULL COMMENT 'описание',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`,`stars`,`rooms`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pkey',
  `estate_id` int(10) NOT NULL COMMENT 'связь с объектом недвижимости',
  `preview` varchar(128) NOT NULL COMMENT 'миниатюра',
  `photo` varchar(128) NOT NULL COMMENT 'основное изображение',
  PRIMARY KEY (`id`),
  KEY `estate_id` (`estate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'pkey',
  `type` varchar(32) NOT NULL COMMENT 'название типа',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'Квартира'),
(2, 'Дом'),
(3, 'Гостиница'),
(4, 'Вилла'),
(5, 'Бунгало'),
(6, 'Гестхауз');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
