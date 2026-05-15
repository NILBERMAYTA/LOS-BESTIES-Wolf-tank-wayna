-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.4.3 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla wayna_db.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `ID_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`ID_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `ID_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `nacionalidad` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.donaciones
CREATE TABLE IF NOT EXISTS `donaciones` (
  `N_donacion` int NOT NULL AUTO_INCREMENT,
  `ID_cliente` int NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_donacion` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'completado',
  PRIMARY KEY (`N_donacion`),
  KEY `FK_donacion_cliente` (`ID_cliente`),
  CONSTRAINT `FK_donacion_cliente` FOREIGN KEY (`ID_cliente`) REFERENCES `clientes` (`ID_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.emprendedores
CREATE TABLE IF NOT EXISTS `emprendedores` (
  `ID_emprendedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `historia` text,
  `perfil` varchar(255) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_emprendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.logs_actividad
CREATE TABLE IF NOT EXISTS `logs_actividad` (
  `ID_log` int NOT NULL AUTO_INCREMENT,
  `ID_usuario` int NOT NULL,
  `accion` varchar(255) NOT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_log`),
  KEY `FK_log_usuario` (`ID_usuario`),
  CONSTRAINT `FK_log_usuario` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `ID_producto` int NOT NULL AUTO_INCREMENT,
  `ID_emprendedor` int NOT NULL,
  `ID_categoria` int NOT NULL,
  `Nombre_Producto` varchar(100) NOT NULL,
  `Precio` decimal(10,2) NOT NULL,
  `Stock` int NOT NULL,
  `Descripcion` text,
  PRIMARY KEY (`ID_producto`),
  KEY `FK_emprendedor_prod` (`ID_emprendedor`),
  KEY `FK_producto_categoria` (`ID_categoria`),
  CONSTRAINT `FK_emprendedor_prod` FOREIGN KEY (`ID_emprendedor`) REFERENCES `emprendedores` (`ID_emprendedor`),
  CONSTRAINT `FK_producto_categoria` FOREIGN KEY (`ID_categoria`) REFERENCES `categorias` (`ID_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `ID_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) NOT NULL,
  PRIMARY KEY (`ID_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.transacciones
CREATE TABLE IF NOT EXISTS `transacciones` (
  `ID_transaccion` int NOT NULL AUTO_INCREMENT,
  `ID_emprendedor` int NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `tipo` enum('venta','donacion') NOT NULL,
  `metodo_pago` varchar(50) DEFAULT 'QR BISA',
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID_transaccion`),
  KEY `FK_transaccion_emprendedor` (`ID_emprendedor`),
  CONSTRAINT `FK_transaccion_emprendedor` FOREIGN KEY (`ID_emprendedor`) REFERENCES `emprendedores` (`ID_emprendedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla wayna_db.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `rol` enum('admin','emprendedor','cliente') DEFAULT 'cliente',
  PRIMARY KEY (`ID_usuario`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
