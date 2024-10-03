-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-10-2024 a las 01:52:16
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
  `cod_correlativa` int(11) DEFAULT NULL,
  `estado` varchar(15) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_materia`
--

INSERT INTO `alumno_materia` (`Id_alumno`, `id_persona`, `id_materia`, `id_ciclo`, `id_nota`, `cod_correlativa`, `estado`, `fecha_inscripcion`) VALUES
(5, 7, 2, 1, NULL, NULL, 'Inscripto', '2024-10-04'),
(6, 7, 3, 1, NULL, NULL, 'Inscripto', '2024-10-04');

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
(1, '2024', '2024-06-19', '2024-06-26', 'Activo', '2024-06-08 13:24:14', '2024-09-25 16:24:16', 1),
(2, '2025', '2024-09-25', '2024-09-17', 'Activo', '2024-09-14 15:43:44', '2024-09-14 15:43:44', 0),
(3, '2026', '2024-09-22', '2024-09-13', 'Activo', '2024-09-22 05:29:26', '2024-09-25 16:24:16', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativa`
--

CREATE TABLE `correlativa` (
  `cod_correlativa` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_correlativa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correlativa`
--

INSERT INTO `correlativa` (`cod_correlativa`, `id_materia`, `id_correlativa`) VALUES
(1, 6, 5),
(2, 7, 2),
(3, 7, 5),
(4, 8, 2),
(5, 9, 3),
(6, 9, 4),
(7, 10, 2),
(8, 10, 3),
(9, 10, 4),
(10, 10, 5),
(11, 10, 6),
(12, 10, 7),
(13, 10, 8),
(14, 10, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen`
--

CREATE TABLE `examen` (
  `id_examen_tipo` int(11) NOT NULL,
  `nombre_examen` varchar(255) NOT NULL,
  `tipo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `examen`
--

INSERT INTO `examen` (`id_examen_tipo`, `nombre_examen`, `tipo`) VALUES
(1, 'Nota1', 'regular'),
(2, 'Nota2', 'regular'),
(3, 'Nota3', 'regular'),
(4, 'Nota4', 'regular'),
(5, 'Calif. Regular', 'mostrar'),
(6, 'Calif. 1º Ex. Final', 'final'),
(7, 'Calif. 2º Ex. Final', 'final'),
(8, 'Calif. Final', 'final'),
(9, '1º Per. Ev. Dic.', 'final'),
(10, '2º Per. Ev. Dic.', 'final'),
(11, '1º Per. Ev. Feb.', 'final'),
(12, '2º Per. Ev. Feb.', 'final'),
(13, 'Calificación Definitiva', 'mostrar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `horas` varchar(5) DEFAULT NULL,
  `num_resolucion` varchar(15) DEFAULT NULL,
  `año_cursado` varchar(5) NOT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL,
  `plan_estudio` enum('1° Cuatrimestre','2° Cuatrimestre') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `Nombre`, `descripcion`, `horas`, `num_resolucion`, `año_cursado`, `id_tipo`, `estado`, `plan_estudio`) VALUES
(1, 'Lengua', '--', '3', 'ASD23', '1', 2, 'Inactivo', '1° Cuatrimestre'),
(2, 'Compresión y Producción de texto', 'CyPT', '3', 'ASD123', '1', 2, 'Activo', '1° Cuatrimestre'),
(3, 'Biologia', '--', '3', 'ASD123', '1', 2, 'Activo', '1° Cuatrimestre'),
(4, 'Ecologia', '--', '3', 'ASD123', '1', 2, 'Activo', '1° Cuatrimestre'),
(5, 'Contexto socioeconomico ambiental', '--', '3', 'ASD123', '1', 2, 'Activo', '1° Cuatrimestre'),
(6, 'Informatica Aplicada', '--', '3', 'ASD123', '2', 2, 'Activo', '2° Cuatrimestre'),
(7, 'Educación Ambiental 1', '--', '3', 'ASD123', '2', 2, 'Activo', '2° Cuatrimestre'),
(8, 'Geografia Regional', '--', '2', 'asd123', '1', 2, 'Activo', '2° Cuatrimestre'),
(9, 'Prevencion y Manejo de Fuego en áreas protegidas ', '--', '2', 'ASD123', '1', 2, 'Activo', '2° Cuatrimestre'),
(10, 'Practicas Profesionalizantes 1', '--', '3', 'ASD123', '1', 2, 'Activo', '2° Cuatrimestre');

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
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `n1` float DEFAULT NULL,
  `n2` float DEFAULT NULL,
  `n3` float DEFAULT NULL,
  `n4` float DEFAULT NULL,
  `n5` float DEFAULT NULL,
  `n6` float DEFAULT NULL,
  `n7` float DEFAULT NULL,
  `n8` float DEFAULT NULL,
  `n9` float DEFAULT NULL,
  `n10` float DEFAULT NULL,
  `n11` float DEFAULT NULL,
  `n12` float DEFAULT NULL,
  `n13` float DEFAULT NULL,
  `estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nota`
--

INSERT INTO `nota` (`id`, `id_persona`, `id_materia`, `id_ciclo`, `n1`, `n2`, `n3`, `n4`, `n5`, `n6`, `n7`, `n8`, `n9`, `n10`, `n11`, `n12`, `n13`, `estado`) VALUES
(69, 7, 2, 1, 1, 2, 3, 4.5, 10, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(70, 7, 1, 1, 1, 3, 2, 3, 4.5, 0, 2.3, 0, 0, 0, 0, 0, 0, 'activo'),
(71, 7, 7778, 1, 0, 0, 0, 0, 0, 0, 0, 6.6, 0, 0, 0, 0, 0, 'activo'),
(72, 7, 3, 1, 7, 2, 90, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(73, 7, 4, 1, 7, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(74, 7, 5, 1, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(75, 7, 5, 1, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(76, 7, 3, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(77, 7, 3, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(78, 7, 4, 2, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(79, 7, 1, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(80, 7, 1, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(81, 7, 5, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(82, 7, 7778, 2, 78, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(83, 7, 2, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(84, 7, 1, 3, 1, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 'activo'),
(85, 7, 2, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(86, 7, 7778, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(87, 7, 5, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(88, 7, 4, 3, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(89, 7, 3, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(90, 7, 4, 3, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(91, 7, 4, 3, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo'),
(92, 7, 4, 3, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'activo');

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
(2, 'Luis', 'Mercado', '2014-06-20', 44231781, '26', 'aadminjuan@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123', 1, 'Masculino', NULL, NULL, 'Activo'),
(3, 'Facundo', 'Ramirez', '2014-06-20', 44231782, '26', 'aaadminjuan@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123', 1, 'Masculino', NULL, NULL, 'Activo'),
(7, 'Juan', 'Perez', '2014-06-20', 44231783, '26', 'adminjuan@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123', 1, 'Masculino', NULL, NULL, 'Activo'),
(9, 'maxi', 'olmos', '0000-00-00', 0, NULL, 'm@gmail.com', NULL, NULL, NULL, NULL, '123', 3, NULL, NULL, NULL, 'Activo'),
(13, 'Demi', 'Perez', '2014-06-20', 44231783, '26', 'dem23@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123456', 2, 'Masculino', 2332423, 'Preceptor', 'Activo');

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
  ADD KEY `cod_correlativa` (`cod_correlativa`),
  ADD KEY `fk_alumno_materia_nota` (`id_nota`);

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
-- Indices de la tabla `examen`
--
ALTER TABLE `examen`
  ADD PRIMARY KEY (`id_examen_tipo`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nota_persona` (`id_persona`),
  ADD KEY `fk_nota_materia` (`id_materia`),
  ADD KEY `fk_nota_ciclo` (`id_ciclo`);

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
  MODIFY `Id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `asignar`
--
ALTER TABLE `asignar`
  MODIFY `id_asignar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `correlativa`
--
ALTER TABLE `correlativa`
  MODIFY `cod_correlativa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id_examen_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
