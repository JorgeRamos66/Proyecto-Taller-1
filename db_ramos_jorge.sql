-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2024 a las 04:10:39
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
  `consulta_registrado` varchar(2) NOT NULL DEFAULT 'NO',
  `consulta_leido` varchar(2) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id_consulta`, `consulta_nombre`, `consulta_apellido`, `consulta_email`, `consulta_mensaje`, `consulta_registrado`, `consulta_leido`) VALUES
(123129, 'Jorge Raul', 'Ramos Morton', 'jpdjorgito12@gmail.com', 'consulta', '', 'SI'),
(123130, 'asdasd', 'asdasd', 'jpdjorgito12@gmail.com', 'asdasd', '', 'SI'),
(123131, 'asdasd', 'asdasd', 'jpdjorgito12@gmail.com', 'asdasdasd', '', 'SI'),
(123132, 'Jorge Raul', 'Cantero Loebarth', 'jpdjorgito12@gmail.com', 'soy el admin xd', '', 'SI'),
(123133, 'Clelia Raquel', 'Ramos Morton', 'vallvalenchu@gmail.com', 'la concha de la loraaa', '', 'NO'),
(123134, 'Jorge Raul', 'Ramos Morton', 'jpdjorgito12@gmail.com', 'consultaxdddd', '', 'NO'),
(123135, 'Administrador', 'Sabrozon', 'admin@gmail.com', 'soy el admin xd', 'NO', 'SI'),
(123137, 'Jorge Raul', 'Ramos Morton', 'jpdjorgito12@gmail.com', 'consultaasdasd', 'NO', 'NO'),
(123138, 'Administrador', 'Sabrozon', 'admin@gmail.com', 'pruebaaa', 'NO', 'NO'),
(123140, 'Jorge Raul', 'Ramos Morton', 'jpdjorgito12@gmail.com', 'soy el admin xdasdasdasd', 'NO', 'NO'),
(123142, 'Administrador', 'Sabrozon', 'admin@gmail.com', 'prueba numero mil xd', 'SI', 'NO'),
(123143, 'Jorge Ramos', 'Morton Raul', 'lawea@hotmail.com', 'prueba de usuario no registrado dejando mensaje', 'NO', 'NO'),
(123144, 'Marcos', 'Alonso', 'marcos@live.com.ar', 'prueba de consulta del señor marcos, quien esta registrado', 'SI', 'NO');

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
  `nombre_producto` varchar(25) NOT NULL,
  `imagen_producto` varchar(200) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `precio_producto` float(10,2) NOT NULL,
  `marca_producto` varchar(25) NOT NULL,
  `descripcion_producto` varchar(100) NOT NULL,
  `stock_producto` int(11) NOT NULL,
  `eliminado_producto` varchar(10) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `imagen_producto`, `id_categoria`, `precio_producto`, `marca_producto`, `descripcion_producto`, `stock_producto`, `eliminado_producto`) VALUES
(8, 'AFA 23', '1719199254_d572463f8cf98c4500cc.webp', 1, 5400.00, 'Adidas', 'Una pelota de futbol de la seleccion argentina', 0, 'SI'),
(9, 'Predator Club Pastor', '1719199618_adbcebd5d814caa70376.webp', 4, 54000.00, 'Adidas', 'Un botin de futbol 11 hecho por una marca de reconocimiento mundial.', 3, 'NO'),
(10, 'Predator Accuracy', '1719199697_01978cdc816419464a19.webp', 1, 11000.00, 'Adidas', 'Un botin de futbol 11 hecho por una prestigiosa marca.', 2, 'NO'),
(11, 'Kick off', '1719205772_e73fbdb84e67b757460b.webp', 1, 2200.00, 'Nassau', 'Una pelota de futbol de buena calidad y a un precio accesible.', 12, 'NO'),
(12, 'Canilleras de futbol	', '1719198057_07dfb721c7304029b8fd.webp', 5, 3000.00, 'Adidas', 'Canilleras de futbol 5 y 11, hechas en colaboracion con Messi', 5, 'NO'),
(13, 'Brazuca top training', '1719357385_f37924bbed186715267f.jpg', 1, 34000.00, 'Adidas', 'Una pelota de futbol con tematica brazilera.', 5, 'NO'),
(14, 'Magia Match Ball', '1719357459_c2e84b2bdd09322d8cd9.jpg', 1, 35000.00, 'Nike', 'Una pelota de futbol de la marca Nike hecha para un nivel profesional.', 7, 'NO'),
(15, 'Matis 500', '1719357531_caceb0d634cd581c1956.jpg', 2, 23000.00, 'Penalty', 'Una pelota de futbol 5 de increíble calidad, hecha para durar.', 22, 'NO'),
(16, 'Retro II', '1719357586_66989d06b00dee154e3c.webp', 2, 12020.00, 'Topper ', 'Una pelota de futbol 5 de precio accesible.', 1, 'NO'),
(17, 'MAX 500 D', '1719357675_3d1d26c7f56959e0306f.jpeg', 2, 33000.00, 'Penalty ', 'Una pelota de futbol 5 disponible en 3 colores, blanca, negra y naranja.', 0, 'NO'),
(18, 'King Dexter', '1719357715_d027228e6774db22e1e3.jpeg', 5, 3000.00, 'Puma ', 'Canilleras de Fútbol de una marca prestigiosa. ', 13, 'NO'),
(19, 'Standalone Guard', '1719357764_82b72f60b36c31f75ed2.jpeg', 5, 5400.00, 'Puma ', 'Canilleras de futbol Unisex.', 69, 'NO'),
(20, 'Plasti LitmusAzul', '1719357821_652896352e02fd1a5c8e.jpg', 5, 13000.00, 'Procer', 'Canillera de alta calidad.', 3, 'NO'),
(21, 'Bravo Xxiii', '1719358256_2f01d87db635846ffd58.webp', 1, 24500.00, 'Penalty ', 'Una pelota de futbol.', 3, 'NO'),
(22, 'Player 20', '1719358306_1f3cfa8d49aac6029596.jpg', 1, 22150.00, 'Kappa', 'Una pelota de futbol bien bonita.', 2, 'NO'),
(23, 'Indoor Victory', '1719358492_c94b4055bcdc1be3bc52.png', 3, 56000.00, 'Kappa', 'Un botin de futbol 5 hecho por una marca de reconocimiento mundial.', 3, 'NO'),
(24, 'Kaiser II', '1719358533_ba85716a2d2778a04d73.webp', 3, 67000.00, 'Topper ', 'Un botin de futbol 5 de alta calidad y durabilidad.', 10, 'NO'),
(25, 'Crazyfast 3', '1719358569_57acabe19e53b601ce5e.webp', 3, 76000.00, 'Adidas', 'Un botin de futbol 11 hecho por una marca de reconocimiento mundial.', 1, 'NO'),
(26, 'Stingray II', '1719358652_e6f715a845059d179381.webp', 4, 45050.00, 'Topper ', 'Un botin de futbol 11 un poco mas accesible y de una marca muy conocida.', 21, 'NO'),
(27, 'Veloce Fg', '1719358724_a92648ef89eb6a83f38d.webp', 1, 56400.00, 'Kappa', 'Un botin de futbol 11 hecho para los profesionales.', 4, 'SI');

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
(123141, 'Jorge Raul', 'Ramos Morton', 'pancaseroo', 'jpd_jorgito_12@hotmail.com', '$2y$10$noYs.T2eakjsXiEvEJOE2.l4mNvjK48s.06buERdZrhQTsa02jCjK', 2, 'SI'),
(123142, 'Jorge Raul', 'Ramos Morton', 'pancasero', 'jpdjorgito12@gmail.com', '$2y$10$szbACntNIZlK/yQeg0EN0ezD0jWX3A3MXCuU0pJcie.NCKWX2ZOwK', 2, 'NO'),
(123143, 'Clelia Raquel', 'Canteros Loebarth', 'cler', 'jpd_jorgito_12s@hotmail.com', '$2y$10$k01s6M4eRKb1/nmUL1JAHumbClKtvlfF0WskixDZIs/uDIVb7leFS', 2, 'NO'),
(123144, 'Jorge Ramos', 'Cantero Loebarth', '36468588', 'vallvalenchu@gmail.com', '$2y$10$x5bfMfz0McCusDARxnfjTeKKy/HUoc0QTQefeb.d/LBEE3Mr4nS6O', 2, 'NO'),
(123145, 'clelia', 'canteros', 'clerloe1', 'clelialoebarth@gmail.com', '$2y$10$UbVE3aOZkjn0cOQBxllY6.tf9bgtOY8xV06MdftmOf9SpvcEAuIMq', 2, 'NO'),
(123146, 'Marcos', 'Alonso', 'marcos', 'marcos@live.com.ar', '$2y$10$X2nLA.wSmOcxstspBe1imOtkRqDTkeVA33tdW0VX6fNcBYp3JKRxe', 2, 'NO');

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
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123145;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123147;

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
