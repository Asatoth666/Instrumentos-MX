-- Base de datos: `instrumentos_db`
CREATE DATABASE IF NOT EXISTS `instrumentos_db`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `instrumentos_db`;

-- Tabla: categorias
CREATE TABLE `categorias` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Guitarras'),
(2, 'Bajos'),
(3, 'Baterias'),
(4, 'Teclados/Pianos'),
(5, 'Violines');

-- Tabla: usuarios
CREATE TABLE `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `apellidoP` VARCHAR(150) NOT NULL,
  `apellidoM` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) UNIQUE NOT NULL,
  `contrasena` VARCHAR(255) NOT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `rol` ENUM('usuario','admin') DEFAULT 'usuario',
  `token_recuperacion` VARCHAR(255) DEFAULT NULL,
  `expira_token` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: instrumentos
CREATE TABLE `instrumentos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(150) NOT NULL,
  `descripcion` TEXT DEFAULT NULL,
  `categoria_id` INT UNSIGNED DEFAULT NULL,
  `precio` DECIMAL(10,2) NOT NULL CHECK (`precio` >= 0),
  `stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `imagen` VARCHAR(255) DEFAULT NULL,
  `fecha_agregado` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `marca` VARCHAR(100) DEFAULT NULL,
  `descuento` DECIMAL(5,2) DEFAULT 0.00 CHECK (`descuento` >= 0 AND `descuento` <= 100),
  `estado` ENUM('activo','inactivo') DEFAULT 'activo',
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`),
  CONSTRAINT `instrumentos_ibfk_1` FOREIGN KEY (`categoria_id`) 
    REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla: compras
CREATE TABLE `compras` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT UNSIGNED NOT NULL,
  `instrumento_id` INT UNSIGNED NOT NULL,
  `cantidad` INT UNSIGNED NOT NULL CHECK (`cantidad` > 0),
  `total` DECIMAL(10,2) NOT NULL CHECK (`total` >= 0),
  `fecha` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `instrumento_id` (`instrumento_id`),
  CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`instrumento_id`) 
    REFERENCES `instrumentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

