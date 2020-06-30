-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2020 a las 23:44:27
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
-- Estructura de tabla para la tabla `p2_mascotas`
--

CREATE TABLE `p2_mascotas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `p2_mascotas`
--

INSERT INTO `p2_mascotas` (`id`, `nombre`, `edad`, `id_cliente`) VALUES
(1, 'benito', 8, 2),
(2, 'negra', 7, 2),
(3, 'Filipo', 9, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p2_turnos`
--

CREATE TABLE `p2_turnos` (
  `id` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_veterinario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `p2_turnos`
--

INSERT INTO `p2_turnos` (`id`, `id_mascota`, `fecha`, `hora`, `id_veterinario`) VALUES
(1, 1, '2020-06-09', '11:00:00', 1),
(2, 1, '2020-06-11', '11:30:00', 1),
(4, 1, '2020-06-29', '09:30:00', 1),
(5, 1, '2020-06-29', '10:30:00', 1),
(6, 1, '2020-06-29', '11:30:00', 1),
(7, 2, '2020-06-29', '12:30:00', 1),
(8, 3, '2020-06-29', '13:30:00', 1),
(9, 2, '2020-06-30', '13:30:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p2_usuarios`
--

CREATE TABLE `p2_usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `pass` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `p2_usuarios`
--

INSERT INTO `p2_usuarios` (`id`, `email`, `type`, `pass`) VALUES
(1, 'veterinario@gmail.com', 2, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzQi.gZ3HoQRav4zomm2PKY9_qx_7fBky_jz5jmQ25Noyt6M'),
(2, 'cliente@gmail.com', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzQi.gZ3HoQRav4zomm2PKY9_qx_7fBky_jz5jmQ25Noyt6M'),
(5, 'otro@gmail.com', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzQi.gZ3HoQRav4zomm2PKY9_qx_7fBky_jz5jmQ25Noyt6M'),
(7, 'otro2@gmail.com', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzQi.gZ3HoQRav4zomm2PKY9_qx_7fBky_jz5jmQ25Noyt6M'),
(8, 'otro3@gmail.com', 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjEyMzQi.gZ3HoQRav4zomm2PKY9_qx_7fBky_jz5jmQ25Noyt6M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p2_usuarios_types`
--

CREATE TABLE `p2_usuarios_types` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `p2_usuarios_types`
--

INSERT INTO `p2_usuarios_types` (`id`, `type`) VALUES
(1, 'cliente'),
(2, 'veterinario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sk_alumnos`
--

CREATE TABLE `sk_alumnos` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `dni` int(11) NOT NULL,
  `promedio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sk_alumnos`
--

INSERT INTO `sk_alumnos` (`id`, `Nombre`, `dni`, `promedio`) VALUES
(1, 'Perez', 29747505, 9),
(2, 'Gutierrez', 31224305, 10),
(3, 'Manson', 123456789, 6),
(4, 'Manson', 123456789, 6),
(5, 'Manson', 123456789, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `p2_mascotas`
--
ALTER TABLE `p2_mascotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dueños` (`id_cliente`);

--
-- Indices de la tabla `p2_turnos`
--
ALTER TABLE `p2_turnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mascota` (`id_mascota`),
  ADD KEY `veterinario` (`id_veterinario`);

--
-- Indices de la tabla `p2_usuarios`
--
ALTER TABLE `p2_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `user_types` (`type`);

--
-- Indices de la tabla `p2_usuarios_types`
--
ALTER TABLE `p2_usuarios_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `sk_alumnos`
--
ALTER TABLE `sk_alumnos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `p2_mascotas`
--
ALTER TABLE `p2_mascotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `p2_turnos`
--
ALTER TABLE `p2_turnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `p2_usuarios`
--
ALTER TABLE `p2_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `p2_usuarios_types`
--
ALTER TABLE `p2_usuarios_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sk_alumnos`
--
ALTER TABLE `sk_alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `p2_mascotas`
--
ALTER TABLE `p2_mascotas`
  ADD CONSTRAINT `dueños` FOREIGN KEY (`id_cliente`) REFERENCES `p2_usuarios` (`id`);

--
-- Filtros para la tabla `p2_turnos`
--
ALTER TABLE `p2_turnos`
  ADD CONSTRAINT `mascotas` FOREIGN KEY (`id_mascota`) REFERENCES `p2_mascotas` (`id`),
  ADD CONSTRAINT `veterinario` FOREIGN KEY (`id_veterinario`) REFERENCES `p2_usuarios` (`id`);

--
-- Filtros para la tabla `p2_usuarios`
--
ALTER TABLE `p2_usuarios`
  ADD CONSTRAINT `user_types` FOREIGN KEY (`type`) REFERENCES `p2_usuarios_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
