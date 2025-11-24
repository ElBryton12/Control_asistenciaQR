-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2025 a las 03:36:32
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_asistencia`
--
CREATE DATABASE IF NOT EXISTS `control_asistencia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `control_asistencia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `empleado_id` int(11) NOT NULL,
  `hora` time NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `empleado_id`, `hora`, `fecha`, `tipo`) VALUES
(1, 1, '23:47:32', '2025-05-10', 'Salida'),
(3, 2, '14:44:02', '2025-05-15', 'Entrada'),
(4, 2, '14:44:25', '2025-05-15', 'Salida'),
(5, 2, '15:32:55', '2025-05-19', 'Entrada'),
(6, 2, '15:33:06', '2025-05-19', 'Salida'),
(7, 2, '15:33:21', '2025-05-19', 'Entrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
-- ACTUALIZADO: Se incluye soporte para QR y ajuste de longitud de código
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `documento_numero` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,          -- Modificado a VARCHAR(50) y permite NULL
  `imagen_qr` varchar(100) DEFAULT NULL       -- Nueva columna agregada
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellidos`, `documento_numero`, `telefono`, `codigo`, `imagen_qr`) VALUES
(1, 'empleado1', 'perez', '789456124', '999999999', '1234', NULL),
(2, 'empleado2', 'torres', '369852147', '123456789', '321', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `login` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `imagen` varchar(64) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1,
  `rol` enum('ADMIN','GUARDIA') NOT NULL DEFAULT 'GUARDIA'   -- 🔹 Nueva columna
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `login`, `email`, `password`, `imagen`, `estado`, `rol`) VALUES
(1, 'admin', 'apellidos', 'admin', 'admin@admin.com',
 '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918',
 '1746935836.png', 1, 'ADMIN'),
(2, 'guardia', 'apellidos', 'guardia', 'guardia@admin.com',
 '', '1746935836.png', 0, 'GUARDIA');

-- --------------------------------------------------------
-- Índices para tablas volcadas
-- --------------------------------------------------------

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empleado_id` (`empleado_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_codigo` (`codigo`); -- Nuevo índice para búsquedas rápidas por código

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------
-- AUTO_INCREMENT de las tablas volcadas
-- --------------------------------------------------------

ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- --------------------------------------------------------
-- Restricciones para tablas volcadas
-- --------------------------------------------------------

ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
