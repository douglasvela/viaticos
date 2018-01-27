-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2018 a las 03:30:56
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mtps`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vyp_pasajes`
--

CREATE TABLE `vyp_pasajes` (
  `id_solicitud_pasaje` int(11) NOT NULL,
  `fecha_mision` datetime NOT NULL,
  `no_expediente` varchar(15) NOT NULL,
  `empresa_visitada` varchar(30) NOT NULL,
  `direccion_empresa` varchar(30) NOT NULL,
  `nr` varchar(10) NOT NULL,
  `hora_salida` time NOT NULL,
  `hora_llegada` int(11) NOT NULL,
  `monto_pasaje` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `vyp_pasajes`
--
ALTER TABLE `vyp_pasajes`
  ADD PRIMARY KEY (`id_solicitud_pasaje`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `vyp_pasajes`
--
ALTER TABLE `vyp_pasajes`
  MODIFY `id_solicitud_pasaje` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
