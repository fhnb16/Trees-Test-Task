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

-- Дамп данных таблицы fhnb16_test.internet-clients_datatrees: ~14 rows (приблизительно)
INSERT INTO `internet-clients_datatrees` (`id`, `parent`, `title`, `description`) VALUES
	(1, 0, 'Section 1', 'Lorem ipsum dolor sit amet'),
	(2, 0, 'Section 2', 'Sed ut perspiciatis unde omnis'),
	(3, 2, 'Subsection 2.1', 'At vero eos et accusamus et iusto'),
	(4, 2, 'Subsection 2.2', 'Phasellus iaculis facilisis sagittis'),
	(5, 2, 'Subsection 2.3', 'Cras eget mi erat. Quisque at metus odio'),
	(6, 0, 'Section 3', 'Maecenas mollis rhoncus ligula, eget ultrices sem'),
	(7, 6, 'Subsection 3.1', 'Praesent pharetra arcu ullamcorper arcu iaculis'),
	(8, 6, 'Subsection 3.2', 'Etiam aliquet, mauris a scelerisque finibus'),
	(9, 0, 'Section 4', 'Fusce ut tempor est'),
	(10, 7, 'Subsection 3.1.1', 'Aenean in ex id leo dapibus molestie eget id nibh'),
	(11, 7, 'Subsection 3.1.2', 'Quisque finibus erat et ante malesuada facilisis'),
	(12, 7, 'Subsection 3.1.3', 'Phasellus accumsan, ex accumsan scelerisque consequat'),
	(13, 7, 'Subsection 3.1.4', 'Nunc fringilla nisl sed neque tincidunt faucibus'),
	(14, 12, 'Subsection 3.1.3.1', '0_o');

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

-- Дамп данных таблицы fhnb16_test.internet-clients_users: ~3 rows (приблизительно)
INSERT INTO `internet-clients_users` (`id`, `role`, `username`, `password`, `email`, `Description`) VALUES
	(1, 'admin', 'fhnb16', 'def4764dd83385e70b371c3accb3904b', 'artur@fhnb.ru', 'md5+salt'),
	(2, 'user', 'TestUser', '291ad2c4ece30eec7a3ed89b42a03198', 'username@domain.com', '123456'),
	(3, 'moderator', 'Moder1337', '126e2556dfe608847adc360f134cb79b', 'test@test.test', '12345678');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
