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
  PRIMARY KEY (`id`),
  KEY `fk_tipo_usuario` (`tipo_usuario`),
  CONSTRAINT `fk_tipo_usuario` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuarios` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`usuario`,`password`,`tipo_usuario`,`otp`,`otp_expires_at`,`created_at`,`updated_at`) values 
(1,'victoria','$2y$10$YVTv6j/0lCuLwUU2eadaiOynkclbVENcQZiN7oglNbEq3.gSlNHYO',1,NULL,NULL,NULL,NULL),
(11,'Brayam','$2y$10$IIS8wa0RXkxp0qxhs2tPOe8r4VKgcBTYiCZTnx9vHzHa5igo6oNiG',1,NULL,NULL,NULL,NULL),
(12,'Prueba','$2y$10$7bQrhYNZj2IQ7Rx.Y4kVGOMisbxxakcd2Tx3WiM39Pagod66dzYza',1,NULL,NULL,NULL,NULL),
(13,'Prueba 2','$2y$10$lRyErc835UpCde7IkNYxOOxAc1rFn8/KYRqZyi16logn161iGR3Uu',2,NULL,NULL,NULL,NULL),
(14,'Prueba 3','$2y$10$5vFkkjCIY/vkHyFui77ScehlcWjpzHCL5ASHN0M6mmMQdz0T6qZdC',2,NULL,NULL,NULL,NULL),
(15,'Test','$2y$10$CKMDIwehy8H.ZwFI9z3IjenQDuA5GEFoxOTomlIjTEiY3WPqOs7Mi',2,NULL,NULL,NULL,NULL),
(16,'Test 2','$2y$10$UxLtwasiniy0yLKkLiSkROv65QNhuEdJ5zplFC0lOaok68aANgtLG',2,NULL,NULL,NULL,NULL),
(17,'test 3','$2y$10$v.aHiTzNfo7YSHzzDjCsYuw0yDyriOCVPqJNxwHLZDfA6y6vzDekK',2,NULL,NULL,NULL,NULL),
(18,'test 4','$2y$10$9g.dhKw82Ax5DyjYqrne9eq4kb7wmdhcham2jQ9hb9hfBMWXoKj1O',2,NULL,NULL,NULL,NULL),
(19,'test 5','$2y$10$1aPT.jzZZpjGIt6OUxOd/ezE1ewfhs3Df6K/UZPdo9nCt9TO7lCQO',2,NULL,NULL,NULL,NULL),
(20,'brayamsoto477@gmail.com','$2y$10$KH0lX62AXC9WvKinue7RzOaddCF/Zy2ByX65F38U3CtStUfix.BAC',2,NULL,NULL,NULL,NULL),
(21,'prueba@reg.com','$2y$10$YH3kk8abJiO2MHAlhH3QyOYn/JMQgXAMoyweBfsCP9yXZFWpTJVE.',2,NULL,NULL,NULL,NULL),
(22,'prueba2@reg.com','$2y$10$m1zjyCV1gJeFhZL/AMVlRuNhnxUTZGNyPpoG.2ZDnWtAQx35GDZTe',2,NULL,NULL,NULL,NULL),
(23,'prueba3@reg.com','$2y$10$fpDwvXiIhwdd1WQXUaEv8.c7ZapVmxu98papolDMMVOtz6jXwUgtu',2,NULL,NULL,NULL,NULL),
(24,'test@gmail.com','$2y$10$ybhgsBhk7qhVuoGI/mfepOpStRaZ.6MzoY8dd36IWDByfQAvWmtiC',2,NULL,NULL,NULL,NULL),
(25,'test2@gmail.com','$2y$10$.PjVJC7Wu9chTEChRrec9.qsAkRCipRvYxfdePQsvyLo0mHdogWLu',2,NULL,NULL,NULL,NULL),
(26,'22786@virtual.utsc.edu.mx','$2y$12$BhzQiPUBL314huEoVhg9ZuQlypydPHXH3dNmNV59L8LN.ByHCcr9e',2,NULL,NULL,NULL,'2026-03-24 00:34:06'),
(27,'test3@gmail.com','$2y$10$vnh4ZrEsEhi.Ffv15L0kJ.jRUpSmIVuNtBavGe7t8Z6gL17Vq1Uq6',2,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
