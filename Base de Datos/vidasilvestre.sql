-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-11-2024 a las 01:07:20
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
  `dni` int(11) NOT NULL,
  `genero` varchar(11) NOT NULL,
  `ape_nom` varchar(50) NOT NULL,
  `escrito` varchar(11) NOT NULL,
  `oral` varchar(11) NOT NULL,
  `definitivo` varchar(11) NOT NULL,
  `observacion` varchar(20) DEFAULT NULL,
  `id_mesa` int(11) DEFAULT NULL
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
  `estado` varchar(15) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_materia`
--

INSERT INTO `alumno_materia` (`Id_alumno`, `id_persona`, `id_materia`, `id_ciclo`, `estado`, `fecha_inscripcion`) VALUES
(5, 7, 2, 1, 'Inscripto', '2024-10-04'),
(6, 7, 3, 1, 'Inscripto', '2024-10-04'),
(7, 9, 2, 1, 'Inscripto', '2024-10-16'),
(8, 2, 2, 1, 'Inscripto', '2024-10-25'),
(9, 2, 3, 1, 'Inscripto', '2024-10-25'),
(10, 13, 2, 1, 'Inscripto', '2024-10-26'),
(11, 13, 3, 1, 'Inscripto', '2024-10-26'),
(12, 13, 4, 1, 'Inscripto', '2024-10-26'),
(13, 2, 4, 1, 'Inscripto', '2024-10-26'),
(14, 13, 5, 1, 'Inscripto', '2024-11-02');

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
(1, 13, 3, '2024-10-09', NULL, 'Activo');

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
  `id_correlativa` int(11) DEFAULT NULL,
  `año_cursado` int(11) DEFAULT NULL,
  `plan_estudio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correlativa`
--

INSERT INTO `correlativa` (`cod_correlativa`, `id_materia`, `id_correlativa`, `año_cursado`, `plan_estudio`) VALUES
(102, 7, 1, NULL, NULL),
(105, 10, 1, NULL, NULL),
(106, 11, 2, NULL, NULL),
(107, 11, 6, NULL, NULL),
(108, 12, 7, NULL, NULL),
(109, 13, 5, NULL, NULL),
(110, 13, 8, NULL, NULL),
(111, 5, 4, NULL, NULL),
(112, 6, 1, NULL, NULL),
(113, 6, 4, NULL, NULL),
(114, 8, 2, NULL, NULL),
(115, 8, 3, NULL, NULL),
(116, 9, 1, NULL, NULL),
(117, 9, 2, NULL, NULL),
(118, 9, 3, NULL, NULL),
(119, 9, 4, NULL, NULL),
(120, 9, 5, NULL, NULL),
(121, 9, 6, NULL, NULL),
(122, 9, 7, NULL, NULL),
(123, 9, 8, NULL, NULL);

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
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_mesa_examen` int(11) DEFAULT NULL,
  `fecha_inscripcion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`id_inscripcion`, `id_alumno`, `id_mesa_examen`, `fecha_inscripcion`) VALUES
(1, 2, 1, '2024-10-26 02:43:28'),
(2, 2, 2, '2024-10-26 02:48:42');

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
  `año_cursado` varchar(20) NOT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL,
  `plan_estudio` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `Nombre`, `descripcion`, `horas`, `num_resolucion`, `año_cursado`, `id_tipo`, `estado`, `plan_estudio`) VALUES
(1, 'Compresion y Produccion de Texto', '--', '2', '--ssss', '1° Año', 1, 'Activo', '1° Cuatrimestre'),
(2, 'Biologia', '--', '2', '--', '1° Año', 1, 'Activo', '1° Cuatrimestre'),
(3, 'Ecologia', '--', '2', '--', '1° Año', 1, 'Activo', '1° Cuatrimestre'),
(4, 'Contexto Socioeconomico ambiental', '--s', '2', '--', '1° Año', 1, 'Activo', '1° Cuatrimestre'),
(5, 'Informatica Aplicada', '--', '2', '--', '1° Año', 1, 'Activo', '2° Cuatrimestre'),
(6, 'Educacion Ambiental', '--', '2', '--', '1° Año', 1, 'Activo', '2° Cuatrimestre'),
(7, 'Geografia Regional', '--', '2', '--', '1° Año', 1, 'Activo', '2° Cuatrimestre'),
(8, 'Prevencion y Manejo de Fuego en areas protegidas', '--', '2', '-', '1° Año', 1, 'Activo', '2° Cuatrimestre'),
(9, 'Practicas Profesionalizantes 1', '--', '2', '--', '1° Año', 1, 'Activo', 'Anual'),
(10, 'Ingles Tecnico 1', '--', '2', '--', '2° Año', 1, 'Activo', '1° Cuatrimestre'),
(11, 'Educacion Ambienta 2', '--', '3', '--', '2° Año', 1, 'Activo', '1° Cuatrimestre'),
(12, 'Geografía Regional 2', '--', '2', '--', '2° Año', 1, 'Activo', '1° Cuatrimestre'),
(13, 'Primeros Auxilios', '--sss', '3', '--', '2° Año', 1, 'Activo', '1° Cuatrimestre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id_mesa` int(11) NOT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `nombre_mesa` varchar(30) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `estado` varchar(11) DEFAULT NULL,
  `libro` varchar(20) NOT NULL,
  `folio` int(11) DEFAULT NULL,
  `id_t` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa_examen`
--

INSERT INTO `mesa_examen` (`id_mesa`, `id_materia`, `fecha`, `nombre_mesa`, `hora`, `id_ciclo`, `id_tipo`, `estado`, `libro`, `folio`, `id_t`) VALUES
(1, 6, '2024-11-08', 'sdas', '18:45:00', 1, 1, 'Activo', '324324', 32432, 6);

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
(1, 13, 5, 1, 6, 7, 7, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'activo');

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
(13, 'Demi', 'Perez', '2014-06-20', 44231783, '26', 'demi@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123', 1, 'Masculino', 2332423, 'Preceptor', 'Activo'),
(14, 'dwe', 'ooo', '1998-10-02', 12555555, '7777777778', 'lucas@gmail.com', 'jf', '2024-10-16', 'Argentina', 'Jáchal', '123666', 2, 'Masculino', 1757, 'cer', 'Activo'),
(15, 'ssss', 'gomez', '2000-10-17', 45476130, '2343242304', 'ssss23@gmail.com', '9 de julio y san juan', '2024-10-24', 'Argentina', 'Valle Fértil', NULL, 3, 'Masculino', NULL, NULL, 'Activo'),
(16, 'Marcos', 'Gomez', '2000-01-31', 45356179, '2646773882', 'marcos45@gmail.com', '9 de julio', '2024-10-26', 'Argentina', 'Angaco', '123456', 2, 'Masculino', 98292, 'Lic.Sistema Operativo', 'Activo');

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
(2, 'Libre'),
(3, 'Promocional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tribunal`
--

CREATE TABLE `tribunal` (
  `id_t` int(11) NOT NULL,
  `presidente` varchar(50) NOT NULL,
  `primer` varchar(50) DEFAULT NULL,
  `segundo` varchar(50) DEFAULT NULL,
  `fecha_1` date NOT NULL,
  `fecha_2` date NOT NULL,
  `observacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tribunal`
--

INSERT INTO `tribunal` (`id_t`, `presidente`, `primer`, `segundo`, `fecha_1`, `fecha_2`, `observacion`) VALUES
(6, 'Demi Perez', '', '', '2024-10-18', '2024-10-18', ''),
(7, 'dwe ooo', '', '', '2024-10-21', '2024-10-21', ''),
(8, 'Marcos Gomez', 'dwe ooo', 'dwe ooo', '2024-10-31', '2024-10-30', '--');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acta`
--
ALTER TABLE `acta`
  ADD PRIMARY KEY (`id_acta`),
  ADD UNIQUE KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `alumno_materia`
--
ALTER TABLE `alumno_materia`
  ADD PRIMARY KEY (`Id_alumno`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`);

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
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_mesa_examen` (`id_mesa_examen`);

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
  ADD UNIQUE KEY `id_t` (`id_t`),
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
-- Indices de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  ADD PRIMARY KEY (`id_t`);

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
  MODIFY `Id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `asignar`
--
ALTER TABLE `asignar`
  MODIFY `id_asignar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `correlativa`
--
ALTER TABLE `correlativa`
  MODIFY `cod_correlativa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `examen`
--
ALTER TABLE `examen`
  MODIFY `id_examen_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tribunal`
--
ALTER TABLE `tribunal`
  MODIFY `id_t` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acta`
--
ALTER TABLE `acta`
  ADD CONSTRAINT `acta_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `mesa_examen` (`id_mesa`);

--
-- Filtros para la tabla `alumno_materia`
--
ALTER TABLE `alumno_materia`
  ADD CONSTRAINT `alumno_materia_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `alumno_materia_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `alumno_materia_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`);

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
  ADD CONSTRAINT `fkb_materia_correlativa` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`id_mesa_examen`) REFERENCES `mesa_examen` (`id_mesa`);

--
-- Filtros para la tabla `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`);

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `fkb_ciclo_mesa` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`),
  ADD CONSTRAINT `fkb_materia_mesa` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `fkb_tribunal_mesa` FOREIGN KEY (`id_t`) REFERENCES `tribunal` (`id_t`),
  ADD CONSTRAINT `mesa_examen_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`);

--
-- Filtros para la tabla `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `nota_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fkb_persona_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
