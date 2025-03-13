-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-03-2025 a las 09:57:55
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
-- Base de datos: `agenda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigo`
--

CREATE TABLE `amigo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `f_nac` date NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `amigo`
--

INSERT INTO `amigo` (`id`, `nombre`, `apellidos`, `f_nac`, `usuario`) VALUES
(35, 'Beth', 'Miller', '1990-02-06', 1),
(36, 'Natalia', 'Gómez', '2013-06-30', 1),
(37, 'Sergio', 'Sánchez', '2003-09-15', 1),
(38, 'Carlos', 'Ruiz', '2014-11-12', 1),
(39, 'Ana', 'Romero', '2015-12-12', 1),
(40, 'Fernando', 'Molina', '2006-03-20', 1),
(41, 'Pedro', 'Cortés', '2001-02-02', 3),
(42, 'Miguel', 'Marín', '2007-06-24', 3),
(43, 'Noelia', 'Vega', '2005-04-05', 3),
(44, 'Enrique', 'Muñoz', '1994-10-20', 3),
(45, 'Irene', 'León', '2010-12-09', 4),
(46, 'Rafael', 'Castillo', '2006-08-03', 4),
(47, 'Luis', 'Herrera', '2005-06-02', 4),
(48, 'Sonia', 'Ríos', '2008-01-28', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `plataforma` varchar(100) NOT NULL,
  `lanzamiento` int(4) NOT NULL,
  `img` varchar(250) NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`id`, `titulo`, `plataforma`, `lanzamiento`, `img`, `usuario`) VALUES
(1, 'Fornite', 'PC', 2017, '../img/Erica/descarga5.jfif', 1),
(2, 'MineCraft', 'PC', 2009, '../img/Fran/BentoHero_4x_Vanilla_1920x1080.jpg', 4),
(3, 'WOW', 'PC', 2004, '../img/Erica/descarga2.jfif', 1),
(17, 'MineCraft', 'PC', 2000, '../img/Erica/2x1_NSwitch_Minecraft_image1280w.jpg', 1),
(18, 'Marvel Rivals', 'PC', 2024, '../img/Erica/Marvel_Rivals.webp', 1),
(19, 'Goat Simulator', 'PC', 2015, '../img/Erica/descarga6.jfif', 1),
(20, 'Goat Simulator', 'PC', 2015, '../img/Redu/descarga6.jfif', 3),
(21, 'Mario Wonder', 'PC', 2020, '../img/Redu/descarga4.jfif', 3),
(22, 'Call of Duty', 'PC', 2017, '../img/Redu/call.jpeg', 3),
(23, 'Mario Kart', 'PC', 2023, '../img/Fran/Mario-Kart-8-Deluxe_2022_11-21-22_004.png', 4),
(24, 'Valorant', 'PC', 2020, '../img/Fran/valorant.jpeg', 4),
(25, 'Resident Evil 4', 'PC', 2019, '../img/Fran/resident.jpeg', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` bigint(20) UNSIGNED NOT NULL,
  `amigo` bigint(20) UNSIGNED NOT NULL,
  `juego` bigint(20) UNSIGNED NOT NULL,
  `f_prestamo` date NOT NULL,
  `devuelto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id`, `usuario`, `amigo`, `juego`, `f_prestamo`, `devuelto`) VALUES
(10, 1, 37, 1, '2025-02-08', 1),
(11, 1, 39, 18, '2025-02-10', 0),
(12, 1, 38, 1, '2025-02-11', 0),
(13, 3, 42, 21, '2025-02-13', 0),
(14, 3, 44, 22, '2025-02-10', 0),
(15, 4, 48, 25, '2025-02-12', 0),
(16, 4, 47, 23, '2025-02-10', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasenia` varchar(20) NOT NULL,
  `tipo` set('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contrasenia`, `tipo`) VALUES
(1, 'Erica', 'hola123', 'usuario'),
(2, 'Maite', 'hola123', 'usuario'),
(3, 'Redu', 'hola123', 'usuario'),
(4, 'Fran', 'hola123', 'usuario'),
(5, 'admin', 'admin', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_amigo_usuario` (`usuario`);

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_juego_usuario` (`usuario`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_prestamo_usuario` (`usuario`),
  ADD KEY `fk_prestamo_amigo` (`amigo`),
  ADD KEY `fk_prestamo_juego` (`juego`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amigo`
--
ALTER TABLE `amigo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `juego`
--
ALTER TABLE `juego`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigo`
--
ALTER TABLE `amigo`
  ADD CONSTRAINT `fk_amigo_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juego`
--
ALTER TABLE `juego`
  ADD CONSTRAINT `fk_juego_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_prestamo_amigo` FOREIGN KEY (`amigo`) REFERENCES `amigo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_juego` FOREIGN KEY (`juego`) REFERENCES `juego` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prestamo_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
