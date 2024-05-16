-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2024 a las 02:11:48
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
-- Base de datos: `vidasilvestre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acta`
--

CREATE TABLE `acta` (
  `id_acta` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_materia`
--

CREATE TABLE `alumno_materia` (
  `Id_alumno` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `id_nota` int(11) DEFAULT NULL,
  `cod_correlativa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignar`
--

CREATE TABLE `asignar` (
  `id_asignar` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `fecha_i` date DEFAULT NULL,
  `fecha_b` date DEFAULT NULL,
  `Estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignar`
--

INSERT INTO `asignar` (`id_asignar`, `id_persona`, `id_materia`, `fecha_i`, `fecha_b`, `Estado`) VALUES
(1, 6, 2, NULL, NULL, 'Activo'),
(2, 7, 3, NULL, NULL, 'Activo'),
(3, 5, 3, NULL, NULL, 'Activo'),
(4, 6, 2, NULL, NULL, 'Activo'),
(5, 6, 3, '0000-00-00', NULL, 'Activo'),
(6, 7, 3, '0000-00-00', NULL, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo_lectivo`
--

CREATE TABLE `ciclo_lectivo` (
  `id_ciclo` int(11) NOT NULL,
  `nombre_ciclo` varchar(50) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `Estado` varchar(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ciclo_actual` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclo_lectivo`
--

INSERT INTO `ciclo_lectivo` (`id_ciclo`, `nombre_ciclo`, `fecha_inicio`, `fecha_fin`, `Estado`, `created_at`, `updated_at`, `ciclo_actual`) VALUES
(1, '2024', '2024-03-03', '2025-03-03', 'Activo', '2024-05-09 19:57:14', '2024-05-15 00:07:29', 1),
(2, '2025', '2025-03-09', '2026-03-12', 'Activo', '2024-05-09 19:59:29', '2024-05-15 00:07:29', 0),
(3, '2026', '2024-05-16', '2024-05-15', 'Activo', '2024-05-15 00:07:44', '2024-05-15 00:07:44', 0);

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
  `nombre_curso` varchar(50) DEFAULT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `Nombre` varchar(15) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `horas` varchar(5) DEFAULT NULL,
  `num_resolucion` varchar(11) DEFAULT NULL,
  `plan_estudio` varchar(11) DEFAULT NULL,
  `año_cursado` varchar(5) NOT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `Nombre`, `descripcion`, `horas`, `num_resolucion`, `plan_estudio`, `año_cursado`, `id_tipo`, `estado`) VALUES
(1, '\'Lengua\'', '\'Lengua\'', '2', '0', '\'1\'', '', 1, 'Inactivo'),
(2, '\'Matematica\'', '\'Matematica aplicada\'', '2', '213123', '\'1\'', '', 2, 'Activo'),
(3, '\'Geografia\'', '\'Geografia basica\'', '5', '324234', '2', '3', 2, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id_mesa` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nombre_mesa` varchar(20) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `Nota_1` decimal(5,2) DEFAULT NULL,
  `Nota_2` decimal(5,2) DEFAULT NULL,
  `Nota_3` decimal(5,2) DEFAULT NULL,
  `Nota_4` decimal(5,2) DEFAULT NULL,
  `Calif_Regularidad` decimal(5,2) DEFAULT NULL,
  `Calif_1_Ex_Final` decimal(5,2) DEFAULT NULL,
  `Calif_2_Ex_Final` decimal(5,2) DEFAULT NULL,
  `Calif_Final` decimal(5,2) DEFAULT NULL,
  `Primera_Per_Re_Ev_Dic` decimal(5,2) DEFAULT NULL,
  `Segunda_Per_Re_Ev_Dic` decimal(5,2) DEFAULT NULL,
  `Primera_Per_Re_Ev_Feb` decimal(5,2) DEFAULT NULL,
  `Segunda_Per_Re_Ev_Feb` decimal(5,2) DEFAULT NULL,
  `Calificacion_Definitiva` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `apellido` varchar(35) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `DNI` int(11) NOT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email_correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(55) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `pais` varchar(55) DEFAULT NULL,
  `ciudad` varchar(55) DEFAULT NULL,
  `contraseña` varchar(10) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `genero` varchar(15) DEFAULT NULL,
  `legajo` int(11) DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--


INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `DNI`, `celular`, `email_correo`, `direccion`, `fecha_ingreso`, `pais`, `ciudad`, `contraseña`, `id_rol`, `genero`, `legajo`, `titulo`, `estado`) VALUES
(1, 'Juan', 'Castro', '1997-05-01', 44231783, '2646054711', 'adminjuan@gmail.com', '9 de julio y san juan', '2006-05-03', 'Argentina', 'Angaco', 'admin123', 3, 'Masculino', 2332423, '332423', 'Activo'),
(2, 'Juan', 'Perez', '1997-05-01', 44231783, '2646054711', 'jua2n@gmail.com', '9 de julio y san juan', '2006-05-03', 'Argentina', 'Angaco', '123cas', 1, 'Masculino', 2332423, '332423', 'Activo'),
(3, 'Juan Ignacio', 'Perez', '2003-05-23', 44145158, '2645128932', 'juan@gmail.com', 'La cañada', '2023-03-02', 'Argentina', 'Calingasta', 'juan23w3', 1, 'Masculino', NULL, NULL, 'Activo'),
(4, 'Juan Alberto', 'Sosa', '2004-02-02', 44327649, '2343241222', 'juanalberto23@gmail.com', '9 de julion 23', '2024-04-30', 'Argentina', 'Zonda', 'alberto23', 1, 'Masculino', NULL, NULL, 'Activo'),
(5, 'Cristian', 'Castro', '2005-02-01', 34423412, '3242343243', 'cristiann@gmail.com', '2e2', '0000-00-00', 'Argentina', 'Albardón', 'admin1221', 2, 'Masculino', NULL, NULL, 'Activo'),
(6, 'Marta', 'Castro', '2024-05-28', 34554452, '2648309212', 'marta@gmail.com', 'ee', '0000-00-00', 'Argentina', 'Zonda', '1231313', 2, 'Femenino', 23424, ' assadd  ', 'Activo'),
(7, 'ssss', 'SS', '2002-02-02', 23424242, '2443234231', 'admin21n@gmail.com', 'dad34', '0000-00-00', 'Argentina', '25 de Mayo', '123131', 2, 'Masculino', 0, ' eqeq ', 'Activo');
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `nombre_tipo`) VALUES
(1, 'Regular'),
(2, 'Promocional'),
(3, 'Libre');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acta`
--
ALTER TABLE `acta`
  ADD PRIMARY KEY (`id_acta`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_ciclo` (`id_ciclo`);

--
-- Indices de la tabla `alumno_materia`
--
ALTER TABLE `alumno_materia`
  ADD PRIMARY KEY (`Id_alumno`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`),
  ADD KEY `cod_correlativa` (`cod_correlativa`);

--
-- Indices de la tabla `asignar`
--
ALTER TABLE `asignar`
  ADD PRIMARY KEY (`id_asignar`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_materia` (`id_materia`);

--
-- Indices de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  ADD PRIMARY KEY (`id_ciclo`);

--
-- Indices de la tabla `correlativa`
--
ALTER TABLE `correlativa`
  ADD PRIMARY KEY (`cod_correlativa`),
  ADD KEY `id_materia` (`id_materia`);

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
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acta`
--
ALTER TABLE `acta`
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumno_materia`
--
ALTER TABLE `alumno_materia`
  MODIFY `Id_alumno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asignar`
--
ALTER TABLE `asignar`
  MODIFY `id_asignar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acta`
--
ALTER TABLE `acta`
  ADD CONSTRAINT `acta_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `acta_ibfk_2` FOREIGN KEY (`id_mesa`) REFERENCES `mesa_examen` (`id_mesa`),
  ADD CONSTRAINT `acta_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`);

--
-- Filtros para la tabla `alumno_materia`
--
ALTER TABLE `alumno_materia`
  ADD CONSTRAINT `alumno_materia_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `alumno_materia_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `alumno_materia_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`),
  ADD CONSTRAINT `alumno_materia_ibfk_4` FOREIGN KEY (`cod_correlativa`) REFERENCES `correlativa` (`cod_correlativa`);

--
-- Filtros para la tabla `asignar`
--
ALTER TABLE `asignar`
  ADD CONSTRAINT `asignar_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `asignar_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `correlativa`
--
ALTER TABLE `correlativa`
  ADD CONSTRAINT `correlativa_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`);

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `mesa_examen_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `mesa_examen_ibfk_2` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`),
  ADD CONSTRAINT `mesa_examen_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`);

--
-- Filtros para la tabla `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `nota_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
