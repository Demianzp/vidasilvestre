-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2023 a las 21:00:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vida_silvestre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acta`
--

CREATE TABLE `acta` (
  `id_acta` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `nota` varchar(10) DEFAULT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativa`
--

CREATE TABLE `correlativa` (
  `cod_correlativa` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_correlativa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `nombre_curso` varchar(50) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `horas` varchar(5) NOT NULL,
  `año` int(11) NOT NULL,
  `num_resolucion` int(11) NOT NULL,
  `plan_estudio` int(11) NOT NULL,
  `Tipo` varchar(25) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `nombre`, `descripcion`, `horas`, `año`, `num_resolucion`, `plan_estudio`, `Tipo`, `estado`) VALUES
(1, 'Lengua', 'Lengua aplicada', '3', 2023, 1230, 111, 'Regular', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id_mesa` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` int(11) NOT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa_examen`
--

INSERT INTO `mesa_examen` (`id_mesa`, `id_materia`, `fecha`, `hora`, `tipo`, `estado`) VALUES
(1, 1, '2023-10-17', 19, 'Regular', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `apellido` varchar(35) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `DNI` int(11) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email_correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(55) DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `pais` varchar(55) DEFAULT NULL,
  `ciudad` varchar(55) DEFAULT NULL,
  `contraseña` varchar(10) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `genero` varchar(15) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `DNI`, `celular`, `email_correo`, `direccion`, `fecha_ingreso`, `pais`, `ciudad`, `contraseña`, `id_rol`, `genero`, `estado`) VALUES
(1, 'Agustin', 'inon', '2002-04-05', 44061050, '264-561-3042', 'correo@ejemplo.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123456', 1, NULL, NULL),
(2, 'Demian', 'nose_uwu', '2004-10-05', 56465546, '264-852-7895', 'corrreoejemplo@gmail.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123uwu122', 1, NULL, NULL),
(3, 'Maxi', 'Olmos', '2002-04-05', 54654213, '264-852-3042', 'correo@gmail.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '987654', 1, NULL, NULL),
(4, 'Camila', 'Luzero', '1992-04-05', 44526862, '264-561-4651', 'correo123@gamil.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123hola', 1, NULL, NULL),
(5, 'Agustin', 'Lopez', '2003-10-31', 44324170, '', 'agustin23@gmail.com', 'Aguilera', '2018-07-23', 'Argentina', 'Angaco', 'agus34', 3, 'Masculino', 'Activo'),
(7, 'Demian', 'Montaña', '2004-10-31', 45471425, '2646058717', 'demian@gmail.com', 'Calle San juan', '2017-01-22', 'Argentina', '9 de Julio', '12345', 1, 'Seleccione su G', 'Activo'),
(8, 'Axel', 'Nievas', '2003-01-23', 45473156, '2646058717', 'axel@gmail.com', 'Alem', '2017-02-23', 'Argentina', 'Valle Fértil', '12345', 1, 'Masculino', 'Activo'),
(9, 'Lujan', 'Molina', '2003-09-27', 45214117, '+542646058717', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Activo'),
(10, 'Lujan', 'Molina', '2003-09-27', 45214117, '+542646058717', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Activo'),
(11, 'Lujan', 'Molina', '2003-09-27', 45214117, '+542646058717', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Activo'),
(12, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Activo'),
(13, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Activo'),
(14, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Activo'),
(15, 'Nahuel', 'Nievas', '2004-02-12', 45473153, '2646557616', 'nahu@gmail.com', 'Vallecito', '2021-03-12', 'Argentina', 'Valle Fértil', '23dx5', 1, 'Masculino', 'Activo'),
(16, 'Nahuel', 'Nievas', '2004-02-12', 45473153, '2646557616', 'nahu@gmail.com', 'Vallecito', '2021-03-12', 'Argentina', 'Valle Fértil', '23dx5', 1, 'Masculino', 'Activo'),
(17, 'm', 'o', '2023-10-18', 12345678, '2123213124', 'maxi@gmail.com', 'a', '2023-10-18', 'Argentina', 'Ullum', '123', 3, 'Masculino', 'Activo'),
(18, 'm', 'o', '2023-10-18', 12345678, '2123213124', 'maxi@gmail.com', 'a', '2023-10-18', 'Argentina', 'Ullum', '123', 3, 'Masculino', 'Activo'),
(19, 'w', 'e', '2023-10-26', 42341223, '2544145095', 'adsad@gmail.com', 'afe', '2023-10-25', 'Argentina', 'Zonda', '234', 1, 'Masculino', 'Activo'),
(20, 'QQ', 'SAA', '2022-04-23', 45421242, '2745382749', 'sffe@gmail.com', 'DF', '2018-02-12', 'Argentina', 'Zonda', '234', 1, 'Masculino', 'Activo'),
(21, 'A', 'a', '2023-10-26', 11111111, '1222314144', 'm@gmail.com', 'd', '2023-10-04', 'Argentina', 'Rawson', '123', 3, 'Masculino', 'Activo'),
(22, 'Ian', 'Gomez', '2000-07-23', 42462163, '2646548727', 'ian@gmail.com', 'vwvew', '2017-03-23', 'Argentina', 'Valle Fértil', '1234sx', 1, 'Masculino', 'Activo'),
(23, 'adwa', 'ddw', '2002-02-23', 42323431, '3242342341', 'add@gmail.com', 'dwada', '2010-02-22', 'Argentina', 'San Martín', '32323', 2, 'Femenino', 'Activo'),
(24, 'asdsad', 'qwdwdq', '2002-10-31', 43242333, '2342343343', 'asdsad@gmail.com', 'asdaasdsad', '2017-03-22', 'Argentina', 'Zonda', '232432', 2, 'Masculino', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol`) VALUES
(1, 'Alumno'),
(2, 'Profesor'),
(3, 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acta`
--
ALTER TABLE `acta`
  ADD PRIMARY KEY (`id_acta`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `correlativa`
--
ALTER TABLE `correlativa`
  ADD PRIMARY KEY (`cod_correlativa`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_correlativa` (`id_correlativa`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id_curso`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id_materia`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acta`
--
ALTER TABLE `acta`
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correlativa`
--
ALTER TABLE `correlativa`
  MODIFY `cod_correlativa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acta`
--
ALTER TABLE `acta`
  ADD CONSTRAINT `acta_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `acta_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa_examen` (`id_mesa`);

--
-- Filtros para la tabla `correlativa`
--
ALTER TABLE `correlativa`
  ADD CONSTRAINT `correlativa_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `correlativa_ibfk_2` FOREIGN KEY (`id_correlativa`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `mesa_examen_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
