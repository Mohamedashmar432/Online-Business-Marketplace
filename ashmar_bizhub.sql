-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `authenticate`;
CREATE TABLE `authenticate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `password` varchar(128) NOT NULL,
  `google_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'null',
  `status` int NOT NULL DEFAULT '0',
  `address` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Add your address',
  `plan` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'free plan',
  `profile` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'nono',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `business`;
CREATE TABLE `business` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `business_author` varchar(64) NOT NULL,
  `business_name` varchar(128) NOT NULL,
  `business_type` varchar(64) NOT NULL,
  `business_industry` varchar(64) NOT NULL,
  `description` varchar(1028) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `net_profit` int NOT NULL,
  `business_age` int NOT NULL,
  `deal_price` int NOT NULL,
  `location` varchar(256) NOT NULL,
  `business_file` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bid` int NOT NULL DEFAULT '0',
  `uploaded_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `business_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `authenticate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `name` varchar(65) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `language` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `authenticate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `uid` int NOT NULL,
  `token` varchar(256) NOT NULL,
  `login_time` time NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user_agent` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `active` int NOT NULL DEFAULT '0',
  `fingerprint` varchar(128) NOT NULL,
  KEY `uid` (`uid`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `authenticate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- 2024-10-24 09:13:30
