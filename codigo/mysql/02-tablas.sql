-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-04-2018 a las 18:38:26
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tablonucm`
--
CREATE DATABASE IF NOT EXISTS `tablonucm` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tablonucm`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombreUsuario` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(80) NOT NULL,
  `rol` varchar(10) NOT NULL,
  `imagen` boolean NOT NULL,
  `extensionImagen` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `universidad` (
  `id` int(11) NOT NULL,
  `facultad` varchar(80) NOT NULL,
  `grado` varchar(80) NOT NULL,
  `curso` varchar(80) NOT NULL,
  `asignatura` varchar(80) NOT NULL,
  `zip` boolean NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `archivos` (
  `id` int(11) NOT NULL,
  `nombreArchivo` varchar(80) NOT NULL,
  `categoria` varchar(80) NOT NULL,
  `asignatura` varchar(80) NOT NULL,
  `curso` varchar(80) NOT NULL,
  `grado` varchar(80) NOT NULL,
  `facultad` varchar(80) NOT NULL,
  `autor` varchar(15) NOT NULL,
  `observaciones` varchar(140) NOT NULL,
  `tamano` int(15) NOT NULL,
  `fecha` varchar(80) NOT NULL,
  `formato` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valoracionesarchivos` (
  `idArchivo` int(11) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `puntuacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valoracionesusuarios` (
  `usuarioReceptor` varchar(15) NOT NULL,
  `usuarioEmisor` varchar(15) NOT NULL,
  `puntuacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombreUsuario`);

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoracionesarchivos`
--
ALTER TABLE `valoracionesarchivos`
  ADD PRIMARY KEY (`idArchivo`, `usuarioEmisor`);

--
-- Indices de la tabla `valoracionesusuarios`
--
ALTER TABLE `valoracionesusuarios`
  ADD PRIMARY KEY (`usuarioReceptor`, `usuarioEmisor`);
  
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

--
-- Claves foráneas de la tabla `archivos`
--
ALTER TABLE `archivos` 
  ADD FOREIGN KEY (`autor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `valoracionesarchivos`
--
ALTER TABLE `valoracionesarchivos` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`idArchivo`) 
  REFERENCES `archivos`(`id`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

--
-- Claves foráneas de la tabla `valoracionesusuarios`
--
ALTER TABLE `valoracionesusuarios` 
  ADD FOREIGN KEY (`usuarioEmisor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE,
  ADD FOREIGN KEY (`usuarioReceptor`) 
  REFERENCES `usuarios`(`nombreUsuario`)
  ON UPDATE CASCADE
  ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
