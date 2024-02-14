CREATE DATABASE IF NOT EXISTS `app`;

CREATE USER 'app_db_user'@'%' IDENTIFIED BY '123456';

GRANT ALL PRIVILEGES ON app.* TO 'app_db_user'@'%';

FLUSH PRIVILEGES;

USE `app`;

CREATE TABLE `users` (
     `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
     `uuid` varchar(36) NOT NULL,
     `email` varchar(255) NOT NULL,
     `name` varchar(64) NOT NULL,
     `lastName` varchar(64) NOT NULL,
     `status` tinyint(1) NOT NULL DEFAULT '1',
     `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (`id`),
     UNIQUE KEY `uuid` (`uuid`),
     UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

