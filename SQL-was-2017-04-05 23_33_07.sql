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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Akce přístupů';

-- Exportování dat pro tabulku was.action: ~0 rows (přibližně)
DELETE FROM `action`;
/*!40000 ALTER TABLE `action` DISABLE KEYS */;
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
  `id_tag` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_posts_type` (`id_type`),
  KEY `FK_posts_tag` (`id_tag`),
  CONSTRAINT `FK_posts_tag` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id`),
  CONSTRAINT `FK_posts_type` FOREIGN KEY (`id_type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Příspěvky';

-- Exportování dat pro tabulku was.posts: ~0 rows (přibližně)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Role uživatele';

-- Exportování dat pro tabulku was.role: ~0 rows (přibližně)
DELETE FROM `role`;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.tag
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci ROW_FORMAT=COMPACT COMMENT='Tagy příspěvku';

-- Exportování dat pro tabulku was.tag: ~0 rows (přibližně)
DELETE FROM `tag`;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` (`id`, `name`) VALUES
	(1, 'umění'),
	(2, 'IT'),
	(3, 'ekonomie'),
	(4, 'vlog'),
	(5, 'novinka');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.type
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Typ příspěvku';

-- Exportování dat pro tabulku was.type: ~1 rows (přibližně)
DELETE FROM `type`;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` (`id`, `name`) VALUES
	(1, 'Obrázek');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;

-- Exportování struktury pro tabulka was.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `street` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `zip_code` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `registred` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__role` (`id_role`),
  CONSTRAINT `FK__role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- Exportování dat pro tabulku was.user: ~0 rows (přibližně)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
