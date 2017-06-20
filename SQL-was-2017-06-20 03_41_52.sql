-- --------------------------------------------------------
-- Hostitel:                     127.0.0.1
-- Verze serveru:                10.1.16-MariaDB - mariadb.org binary distribution
-- OS serveru:                   Win32
-- HeidiSQL Verze:               9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportování struktury databáze pro
CREATE DATABASE IF NOT EXISTS `was` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci */;
USE `was`;

-- Exportování struktury pro tabulka was.access
CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_tag` int(11) DEFAULT NULL,
  `id_action` int(11) DEFAULT NULL,
  `time_arrived` datetime DEFAULT NULL,
  `locality` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL,
  `source_visit` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL,
  `web_print` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL,
  `time_departure` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_access_posts` (`id_post`),
  KEY `FK_access_user` (`id_user`),
  KEY `FK_access_tag` (`id_tag`),
  KEY `FK_access_action` (`id_action`),
  CONSTRAINT `FK_access_action` FOREIGN KEY (`id_action`) REFERENCES `action` (`id`),
  CONSTRAINT `FK_access_posts` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_access_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`),
  CONSTRAINT `FK_access_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Přístupy k příspěvku';

-- Exportování dat pro tabulku was.access: ~0 rows (přibližně)
DELETE FROM `access`;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
/*!40000 ALTER TABLE `access` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.action
CREATE TABLE IF NOT EXISTS `action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Akce přístupů';

-- Exportování dat pro tabulku was.action: ~4 rows (přibližně)
DELETE FROM `action`;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
INSERT INTO `action` (`id`, `name`) VALUES
	(1, 'Proklik'),
	(2, 'Stažení'),
	(3, 'Uložení'),
	(4, 'Sdílení');
/*!40000 ALTER TABLE `action` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) DEFAULT NULL,
  `table_to_exist` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `id_to_exist` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `short_text` varchar(256) COLLATE utf8_czech_ci DEFAULT NULL,
  `photo` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `long_text` longtext COLLATE utf8_czech_ci,
  `properties` longtext COLLATE utf8_czech_ci,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_posts_type` (`id_type`),
  CONSTRAINT `FK_posts_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Příspěvky';

-- Exportování dat pro tabulku was.posts: ~0 rows (přibližně)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.post_tag
CREATE TABLE IF NOT EXISTS `post_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_post` int(11) NOT NULL DEFAULT '0',
  `id_tag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_post_tag_posts` (`id_post`),
  KEY `FK_post_tag_tag` (`id_tag`),
  CONSTRAINT `FK_post_tag_posts` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_post_tag_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku was.post_tag: ~0 rows (přibližně)
DELETE FROM `post_tag`;
/*!40000 ALTER TABLE `post_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_tag` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Role uživatele';

-- Exportování dat pro tabulku was.role: ~2 rows (přibližně)
DELETE FROM `role`;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`id`, `name`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Tagy příspěvku';

-- Exportování dat pro tabulku was.tag: ~10 rows (přibližně)
DELETE FROM `tag`;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `name`, `deleted`) VALUES
	(1, 'umění', 0),
	(2, 'IT', 0),
	(4, 'vlog', 0),
	(5, 'novinka', 0),
	(6, 'matematika', 0),
	(7, 'věda', 0),
	(8, 'hudba', 0),
	(10, 'experiment', 0),
	(13, 'experimenty', 1),
	(14, 'ekonomie', 0);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.type
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Typ příspěvku';

-- Exportování dat pro tabulku was.type: ~5 rows (přibližně)
DELETE FROM `type`;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` (`id`, `name`, `deleted`) VALUES
	(1, 'Obrázek', 0),
	(2, 'Příspěvek', 0),
	(3, 'Produkt', 0),
	(4, 'Reklama2', 1),
	(5, 'Reklama', 0);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `password` varchar(4096) COLLATE utf8_czech_ci DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `street` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `zip_code` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `registred` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `FK__role` (`id_role`),
  CONSTRAINT `FK__role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku was.user: ~3 rows (přibližně)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `firstname`, `surname`, `username`, `password`, `id_role`, `street`, `city`, `zip_code`, `state`, `registred`) VALUES
	(1, 'Jan', 'Novák', 'jannovak', '$2y$10$sktGgUyHw6VYYcNLsyQgQuI5M4qQPxF5GqZ5bSgZFmMreqh9AhvAC', 1, 'Pražská 1', 'Praha 1', '11111', 'Česká Republika', '2017-06-12 17:48:25'),
	(2, 'Josef', 'Novák', 'josefnovak', '$2y$10$F9AFGX2KeyUdYn1i0z9KZ.r5eoWk3qV2GfHvyEXW1.XcpTHv7oX/6', 2, NULL, NULL, NULL, NULL, '2017-06-12 17:50:14'),
	(3, 'Kristýna', 'Nováková', 'kristynanovakova', '$2y$10$Ib5EQ80dyAqKbPZFsOWjHOWkceTjbAVtYYL6dxeaA91G1nyVYcBue', 2, NULL, NULL, NULL, NULL, '2017-06-12 17:50:14');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
