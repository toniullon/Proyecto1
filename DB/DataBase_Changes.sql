DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT COMMENT 'Id de la tabla',
  `rol` varchar(50) NOT NULL COMMENT 'Nombre del rol',
  `estado` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 para si y 0 para no',
  PRIMARY KEY (`id_rol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;