/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - paginatca
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`paginatca` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `paginatca`;

/*Table structure for table `foro` */

DROP TABLE IF EXISTS `foro`;

CREATE TABLE `foro` (
  `id_foro` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `mensaje` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_foro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `foro` */

/*Table structure for table `tipo_usuarios` */

DROP TABLE IF EXISTS `tipo_usuarios`;

CREATE TABLE `tipo_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tipo_usuarios` */

insert  into `tipo_usuarios`(`id`,`tipo`) values 
(1,'admin'),
(2,'basico');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` int(11) NOT NULL DEFAULT 2,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_tipo_usuario` (`tipo_usuario`),
  CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`usuario`,`password`,`tipo_usuario`,`otp`,`otp_expires_at`,`created_at`,`updated_at`,`is_verified`) values 
(1,'victoria','$2y$10$YVTv6j/0lCuLwUU2eadaiOynkclbVENcQZiN7oglNbEq3.gSlNHYO',1,NULL,NULL,NULL,NULL,1),
(11,'Brayam','$2y$10$IIS8wa0RXkxp0qxhs2tPOe8r4VKgcBTYiCZTnx9vHzHa5igo6oNiG',1,NULL,NULL,NULL,NULL,1),
(26,'22786@virtual.utsc.edu.mx','$2y$12$BhzQiPUBL314huEoVhg9ZuQlypydPHXH3dNmNV59L8LN.ByHCcr9e',2,'509755','2026-03-24 05:23:17',NULL,'2026-03-24 05:18:17',1),
(32,'brayamsoto477@gmail.com','$2y$12$psL5H8H0GV./koo7qjViP.ComH74BAbRTZzfRq3HSa5QpSvwYSY0O',2,NULL,NULL,'2026-03-24 08:50:08','2026-03-24 23:06:23',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
