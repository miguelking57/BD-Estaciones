-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.17.0.7270
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for tp_computacion_ii
CREATE DATABASE IF NOT EXISTS `tp_computacion_ii` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `tp_computacion_ii`;

-- Dumping structure for table tp_computacion_ii.estaciones
CREATE TABLE IF NOT EXISTS `estaciones` (
  `id_estacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_estacion`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tp_computacion_ii.estaciones: ~22 rows (approximately)
INSERT INTO `estaciones` (`id_estacion`, `nombre`, `latitud`, `longitud`, `localidad`, `provincia`, `pais`) VALUES
	(1, 'Estación Central VB', 34.54003770, -58.55884130, 'Villa Ballester', 'Buenos Aires', 'Argentina'),
	(2, 'Estación Costanera', -37.21500000, -56.97300000, 'Villa Gesell', 'Buenos Aires', 'Argentina'),
	(3, 'Subestación Tortuguitas Sur', -34.48333300, -58.75000000, 'Tortuguitas', 'Buenos Aires', 'Argentina'),
	(4, 'Nodo Pilar Industrial', -34.45878000, -58.91421000, 'Pilar', 'Buenos Aires', 'Argentina'),
	(5, 'Central San Miguel', -34.54333000, -58.71222000, 'San Miguel', 'Buenos Aires', 'Argentina'),
	(6, 'Estación Costera VL', -34.52444000, -58.48194000, 'Vicente López', 'Buenos Aires', 'Argentina'),
	(7, 'Nodo Norte San Isidro', -34.47083000, -58.52861000, 'San Isidro', 'Buenos Aires', 'Argentina'),
	(8, 'Subestación Quilmes Este', -34.72904000, -58.25373000, 'Quilmes', 'Buenos Aires', 'Argentina'),
	(9, 'Central EPEC Centro', -31.41350000, -64.18105000, 'Córdoba Capital', 'Córdoba', 'Argentina'),
	(10, 'Estación Rosario Norte', -32.94682000, -60.63932000, 'Rosario', 'Santa Fe', 'Argentina'),
	(11, 'Subestación Godoy Cruz', -32.89084000, -68.82717000, 'Godoy Cruz', 'Mendoza', 'Argentina'),
	(12, 'Central Patagónica Viedma', -40.81345000, -62.99668000, 'Viedma', 'Río Negro', 'Argentina'),
	(13, 'Subestación Tierra del Fuego', -54.80190000, -68.30300000, 'Ushuaia', 'Tierra del Fuego', 'Argentina'),
	(14, 'Central Neuquén Sur', -38.95160000, -68.05910000, 'Neuquén', 'Neuquén', 'Argentina'),
	(15, 'Parque Solar San Juan', -31.53750000, -68.53640000, 'San Juan', 'San Juan', 'Argentina'),
	(16, 'Nodo Norte Salta', -24.78210000, -65.42320000, 'Salta', 'Salta', 'Argentina'),
	(17, 'Estación Tucumán Histórica', -26.82410000, -65.22260000, 'San Miguel de Tucumán', 'Tucumán', 'Argentina'),
	(18, 'Subestación Venado', -33.74560000, -61.96880000, 'Venado Tuerto', 'Santa Fe', 'Argentina'),
	(19, 'Central Litoral Paraná', -31.73190000, -60.53380000, 'Paraná', 'Entre Ríos', 'Argentina'),
	(20, 'Nodo Corrientes Este', -27.46920000, -58.83060000, 'Corrientes', 'Corrientes', 'Argentina'),
	(21, 'Estación Frontera Posadas', -27.36700000, -55.89600000, 'Posadas', 'Misiones', 'Argentina'),
	(22, 'Central Andina Bariloche', -41.13340000, -71.31020000, 'Bariloche', 'Río Negro', 'Argentina');

-- Dumping structure for table tp_computacion_ii.lecturas
CREATE TABLE IF NOT EXISTS `lecturas` (
  `id_lectura` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_sensor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_lectura`),
  KEY `id_sensor` (`id_sensor`),
  CONSTRAINT `lecturas_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `sensores` (`id_sensor`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tp_computacion_ii.lecturas: ~13 rows (approximately)
INSERT INTO `lecturas` (`id_lectura`, `valor`, `fecha`, `hora`, `id_sensor`) VALUES
	(1, 22.50, '2026-04-29', '10:00:00', 2),
	(2, 23.80, '2026-04-29', '11:00:00', 2),
	(3, 5500.00, '2026-04-29', '10:30:00', 3),
	(4, 218.50, '2026-04-29', '08:15:00', 4),
	(5, 45.20, '2026-04-29', '08:20:00', 5),
	(6, 9800.00, '2026-04-29', '08:25:00', 6),
	(7, 222.10, '2026-04-29', '09:00:00', 7),
	(8, 10500.00, '2026-04-29', '09:05:00', 8),
	(9, 219.00, '2026-04-29', '10:30:00', 11),
	(10, 225.50, '2026-04-29', '11:45:00', 14),
	(11, 12000.00, '2026-04-29', '12:00:00', 17),
	(12, 215.50, '2026-04-10', '08:00:00', 1),
	(13, 221.00, '2026-04-15', '09:00:00', 1),
	(14, 221.50, '2026-04-29', '08:00:00', 18),
	(15, 48.20, '2026-04-29', '08:05:00', 19),
	(16, 11200.00, '2026-04-29', '09:15:00', 20),
	(17, 217.80, '2026-04-29', '10:30:00', 21),
	(18, 224.00, '2026-04-29', '11:00:00', 22),
	(19, 8900.00, '2026-04-29', '11:05:00', 23),
	(20, 35.60, '2026-04-29', '12:00:00', 24);

-- Dumping structure for table tp_computacion_ii.sensores
CREATE TABLE IF NOT EXISTS `sensores` (
  `id_sensor` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `id_estacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sensor`),
  KEY `id_estacion` (`id_estacion`),
  CONSTRAINT `sensores_ibfk_1` FOREIGN KEY (`id_estacion`) REFERENCES `estaciones` (`id_estacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table tp_computacion_ii.sensores: ~17 rows (approximately)
INSERT INTO `sensores` (`id_sensor`, `tipo`, `id_estacion`) VALUES
	(1, 'Tensión', 1),
	(2, 'Corriente', 1),
	(3, 'Potencia', 1),
	(4, 'Tensión', 3),
	(5, 'Corriente', 3),
	(6, 'Potencia', 3),
	(7, 'Tensión', 4),
	(8, 'Potencia', 4),
	(9, 'Corriente', 5),
	(10, 'Coseno Fi', 5),
	(11, 'Tensión', 6),
	(12, 'Corriente', 6),
	(13, 'Potencia', 6),
	(14, 'Tensión', 9),
	(15, 'Potencia', 9),
	(16, 'Corriente', 11),
	(17, 'Potencia', 11),
	(18, 'Tensión', 13),
	(19, 'Corriente', 13),
	(20, 'Potencia', 14),
	(21, 'Tensión', 16),
	(22, 'Tensión', 18),
	(23, 'Potencia', 18),
	(24, 'Corriente', 22);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
