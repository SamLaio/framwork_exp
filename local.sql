-- --------------------------------------------------------
-- 主機:                           127.0.0.1
-- 服務器版本:                        5.6.17 - MySQL Community Server (GPL)
-- 服務器操作系統:                      Win64
-- HeidiSQL 版本:                  9.1.0.4883
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 導出 framwork_exp 的資料庫結構
CREATE DATABASE IF NOT EXISTS `framwork_exp` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `framwork_exp`;


-- 導出  表 framwork_exp.flow 結構
DROP TABLE IF EXISTS `flow`;
CREATE TABLE IF NOT EXISTS `flow` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `rebk` int(11) DEFAULT NULL,
  `date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在導出表  framwork_exp.flow 的資料：~0 rows (大約)
/*!40000 ALTER TABLE `flow` DISABLE KEYS */;
INSERT INTO `flow` (`seq`, `name`, `content`, `rebk`, `date`) VALUES
	(1, 'test', 'test', NULL, '2014-12-29 11:10:59'),
	(2, 'test2', 'test2', 1, '2014-12-29 16:20:10');
/*!40000 ALTER TABLE `flow` ENABLE KEYS */;


-- 導出  表 framwork_exp.user 結構
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `seq` int(11) NOT NULL,
  `account` longtext COLLATE utf8_unicode_ci NOT NULL,
  `pswd` longtext COLLATE utf8_unicode_ci NOT NULL,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在導出表  framwork_exp.user 的資料：~0 rows (大約)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`seq`, `account`, `pswd`, `name`) VALUES
	(0, 'admin', '2a235d94ad2e78be3bb7aa500366ddb2', 'admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
