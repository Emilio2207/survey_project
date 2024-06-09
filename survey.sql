-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-06-2024 a las 13:49:55
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `survey`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

DROP TABLE IF EXISTS `respuestas`;
CREATE TABLE IF NOT EXISTS `respuestas` (
  `ID_encuesta` int NOT NULL AUTO_INCREMENT,
  `genero` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `edad` int NOT NULL,
  `preferencia_bebida` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `page_times` text COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ID_encuesta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
