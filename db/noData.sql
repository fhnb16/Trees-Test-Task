-- --------------------------------------------------------
-- Хост:                         mysql.fhnb16.myjino.ru
-- Версия сервера:               10.5.16-MariaDB-log - MariaDB Server
-- Операционная система:         Linux
-- HeidiSQL Версия:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES cp1251 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных fhnb16_test
CREATE DATABASE IF NOT EXISTS `fhnb16_test` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `fhnb16_test`;

-- Дамп структуры для таблица fhnb16_test.internet-clients_datatrees
CREATE TABLE IF NOT EXISTS `internet-clients_datatrees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL DEFAULT 0,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Test Task for internet-clients.com.\r\nTable with Data Trees';

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица fhnb16_test.internet-clients_users
CREATE TABLE IF NOT EXISTS `internet-clients_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('guest','user','moderator','admin') NOT NULL DEFAULT 'user',
  `username` text DEFAULT NULL,
  `password` char(128) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Test Task for internet-clients.com.\r\nTable with users';

-- Экспортируемые данные не выделены.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
