-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2024 a las 03:57:31
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_ramos_jorge`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `descripcion_categoria` varchar(100) NOT NULL,
  `activo_categoria` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `descripcion_categoria`, `activo_categoria`) VALUES
(1, 'Pelota de futbol 11', 1),
(2, 'Pelota de futbol 5', 1),
(3, 'Botin de futbol 5', 1),
(4, 'Botin de futbol 11', 1),
(5, 'Canilleras de futbol', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `consulta_nombre` varchar(25) NOT NULL,
  `consulta_apellido` varchar(25) NOT NULL,
  `consulta_email` varchar(100) NOT NULL,
  `consulta_mensaje` varchar(500) NOT NULL,
  `consulta_leido` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `consulta_nombre`, `consulta_apellido`, `consulta_email`, `consulta_mensaje`, `consulta_leido`) VALUES
(123129, 'Jorge Raul', 'Ramos Morton', 'jpdjorgito12@gmail.com', 'consulta', 'NO'),
(123130, 'asdasd', 'asdasd', 'jpdjorgito12@gmail.com', 'asdasd', 'NO'),
(123131, 'asdasd', 'asdasd', 'jpdjorgito12@gmail.com', 'asdasdasd', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id_perfil` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id_perfil`, `descripcion`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `imagen_producto` varchar(200) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio_producto` float(10,2) NOT NULL,
  `precio_vta_producto` float(10,2) NOT NULL,
  `stock_producto` int(11) NOT NULL,
  `stock_min_producto` int(11) NOT NULL,
  `eliminado_producto` varchar(10) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `imagen_producto`, `id_categoria`, `precio_producto`, `precio_vta_producto`, `stock_producto`, `stock_min_producto`, `eliminado_producto`) VALUES
(1, 'Botin futbol 5 marca Puma', '', 3, 60000.00, 60000.00, 5, 0, 'NO'),
(2, 'Pelota futbol 5 marca Nassau', '', 2, 24500.00, 24500.00, 10, 0, 'NO'),
(3, 'Canilleras de futbol marca Speedportal', '', 5, 4500.00, 4500.00, 10, 0, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `perfil_id` int(11) NOT NULL,
  `baja` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `email`, `pass`, `perfil_id`, `baja`) VALUES
(123140, 'Administrador', 'Sabrozon', 'admin', 'admin@gmail.com', '$2y$10$iU9pbYE.VR86qtyxszNoa.wDFjN1.6AZmChAwyUbP8ZAddSxhmeea', 1, 'NO'),
(123141, 'Jorge Raul', 'Ramos Morton', 'pancaseroo', 'jpd_jorgito_12@hotmail.com', '$2y$10$noYs.T2eakjsXiEvEJOE2.l4mNvjK48s.06buERdZrhQTsa02jCjK', 2, 'NO'),
(123142, 'Jorge Raul', 'Ramos Morton', 'pancasero', 'jpdjorgito12@gmail.com', '$2y$10$tCEYDuGRGKPmihOOTDpdH.mr5GeecZZLMpE82jGOmgshWPqOHgOgy', 2, 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_consultas`
--

CREATE TABLE `usuarios_consultas` (
  `id_consulta_usuario` int(11) NOT NULL,
  `usuario_consulta_nombre` varchar(25) NOT NULL,
  `usuario_consulta_apellido` varchar(25) NOT NULL,
  `usuario_consulta_email` varchar(100) NOT NULL,
  `usuario_consulta_mensaje` varchar(500) NOT NULL,
  `usuario_consulta_leido` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `perfil_id` (`perfil_id`);

--
-- Indices de la tabla `usuarios_consultas`
--
ALTER TABLE `usuarios_consultas`
  ADD PRIMARY KEY (`id_consulta_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123132;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123143;

--
-- AUTO_INCREMENT de la tabla `usuarios_consultas`
--
ALTER TABLE `usuarios_consultas`
  MODIFY `id_consulta_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`perfil_id`) REFERENCES `perfiles` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
