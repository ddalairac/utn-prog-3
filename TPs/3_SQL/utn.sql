-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2020 a las 01:48:28
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `utn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `Numero` int(11) NOT NULL,
  `pNumero` int(11) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `envios`
--

INSERT INTO `envios` (`Numero`, `pNumero`, `Cantidad`) VALUES
(100, 1, 500),
(100, 2, 1500),
(100, 3, 100),
(101, 2, 55),
(101, 3, 225),
(102, 1, 600),
(102, 3, 300);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `pNumero` int(11) NOT NULL,
  `pNombre` varchar(30) NOT NULL,
  `Precio` float NOT NULL,
  `Tamaño` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`pNumero`, `pNombre`, `Precio`, `Tamaño`) VALUES
(1, 'Caramelos', 1.5, 'Chico'),
(2, 'Cigarrillos', 45.89, 'Mediano'),
(3, 'Gaseosa', 15.8, 'Grande');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedores​`
--

CREATE TABLE `provedores​` (
  `Numero` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Domicilio` varchar(50) NOT NULL,
  `Localidad` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `provedores​`
--

INSERT INTO `provedores​` (`Numero`, `Nombre`, `Domicilio`, `Localidad`) VALUES
(100, 'Perez', 'Perón 876', 'Quilmes'),
(101, 'Gimenez', 'Mitre 750', 'Avellaneda'),
(102, 'Aguirre', 'Boedo 634', 'Bernal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`pNumero`);

--
-- Indices de la tabla `provedores​`
--
ALTER TABLE `provedores​`
  ADD PRIMARY KEY (`Numero`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `pNumero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `provedores​`
--
ALTER TABLE `provedores​`
  MODIFY `Numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
