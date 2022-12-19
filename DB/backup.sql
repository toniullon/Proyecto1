/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.27 : Database - fastfood_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT COMMENT 'Id de la tabla',
  `rol` varchar(50) NOT NULL COMMENT 'Nombre del rol',
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 para si y 0 para no',
  PRIMARY KEY (`id_rol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `roles` */

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(200) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `departamento` varchar(200) DEFAULT NULL,
  `cargo` varchar(250) DEFAULT NULL,
  `ci` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `password_admin` varchar(250) DEFAULT '5e60965bdc88ef5057b30a5174ffaf48',
  `fecha_registro` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '2' COMMENT '2 contraseña expirada, 1 activo, 0 inactivo',
  `id_rol` int DEFAULT NULL COMMENT 'Rol asignado al funcionario',
  `id_sucursal` int DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`,`nombre_usuario`),
  UNIQUE KEY `USUARIO_YA_EXISTE` (`nombre_usuario`),
  KEY `rol_idx` (`id_rol`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id_usuario`,`nombre_usuario`,`nombre`,`apellido`,`departamento`,`cargo`,`ci`,`email`,`telefono`,`celular`,`direccion`,`password`,`password_admin`,`fecha_registro`,`estado`,`id_rol`,`id_sucursal`,`ultimo_acceso`) values 
(1,'admin','Admin','Sistema','Tecnico','Desarrollo','5550712','','','','','21232f297a57a5a743894a0e4a801fc3','5e60965bdc88ef5057b30a5174ffaf48','2022-12-16 09:04:20',2,0,0,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
