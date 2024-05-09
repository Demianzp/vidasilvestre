-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2024 a las 00:22:42
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
  `id_persona` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_materia`
--

CREATE TABLE `alumno_materia` (
  `Id_alumno` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `id_nota` int(11) DEFAULT NULL,
  `cod_correlativa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno_materia`
--

INSERT INTO `alumno_materia` (`Id_alumno`, `id_persona`, `id_materia`, `id_ciclo`, `id_nota`, `cod_correlativa`) VALUES
(7, 4, 42, 16, NULL, NULL),
(8, 4, 41, 16, NULL, NULL),
(9, 6, 41, 16, NULL, NULL),
(10, 8, 41, 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignar`
--

CREATE TABLE `asignar` (
  `id_asignar` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `Estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignar`
--

INSERT INTO `asignar` (`id_asignar`, `id_persona`, `id_materia`, `Estado`) VALUES
(1, 6, 41, 'Activo'),
(2, 7, 42, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo_lectivo`
--

CREATE TABLE `ciclo_lectivo` (
  `id_ciclo` int(11) NOT NULL,
  `nombre_ciclo` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `Estado` varchar(11) DEFAULT 'Activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ciclo_actual` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclo_lectivo`
--

INSERT INTO `ciclo_lectivo` (`id_ciclo`, `nombre_ciclo`, `fecha_inicio`, `fecha_fin`, `Estado`, `created_at`, `updated_at`, `ciclo_actual`) VALUES
(17, '2024', '2024-03-01', '2025-03-07', 'Activo', '2024-05-08 00:14:58', '2024-05-08 00:56:18', 1),
(18, '2026', '2026-05-07', '2027-05-02', 'Activo', '2024-05-08 00:16:44', '2024-05-08 00:43:41', 0),
(19, '2025', '2025-03-23', '2026-03-23', 'Activo', '2024-05-08 00:35:59', '2024-05-08 00:40:39', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativa`
--

CREATE TABLE `correlativa` (
  `cod_correlativa` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_correlativa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id_curso` int(11) NOT NULL,
  `nombre_curso` varchar(50) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `horas` varchar(5) NOT NULL,
  `num_resolucion` varchar(11) NOT NULL,
  `plan_estudio` varchar(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `Nombre`, `descripcion`, `horas`, `num_resolucion`, `plan_estudio`, `id_tipo`, `estado`) VALUES
(41, 'Matematica', '\'--\'', '2', '0', '0', 2, 'Activo'),
(42, 'Lengua ', '\'Lengua\'', '2', 'ME-34-SJ', 'ME-34-SJ', 3, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_examen`
--

CREATE TABLE `mesa_examen` (
  `id_mesa` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `nombre_mesa` varchar(20) NOT NULL,
  `hora` time NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa_examen`
--

INSERT INTO `mesa_examen` (`id_mesa`, `id_materia`, `fecha`, `nombre_mesa`, `hora`, `id_ciclo`, `fecha_fin`, `id_tipo`, `estado`) VALUES
(26, 41, '2023-11-28', 'Mesa1', '08:30:00', 16, '2023-12-19', 1, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_persona` int(11) DEFAULT NULL,
  `id_materia` int(11) DEFAULT NULL,
  `id_ciclo` int(11) DEFAULT NULL,
  `nota1` decimal(5,2) DEFAULT NULL,
  `fecha_n1` date DEFAULT NULL,
  `nota2` decimal(5,2) DEFAULT NULL,
  `fecha_n2` date DEFAULT NULL,
  `nota3` decimal(5,2) DEFAULT NULL,
  `fecha_n3` date DEFAULT NULL,
  `nota4` decimal(5,2) DEFAULT NULL,
  `fecha_n4` date DEFAULT NULL,
  `nota_final` decimal(5,2) DEFAULT NULL,
  `fecha_nota_final` date DEFAULT NULL,
  `promedio` decimal(5,2) DEFAULT NULL
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
  `celular` varchar(15) NOT NULL,
  `email_correo` varchar(100) NOT NULL,
  `direccion` varchar(55) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `pais` varchar(55) NOT NULL,
  `ciudad` varchar(55) NOT NULL,
  `contraseña` varchar(10) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `genero` varchar(15) NOT NULL,
  `legajo` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `DNI`, `celular`, `email_correo`, `direccion`, `fecha_ingreso`, `pais`, `ciudad`, `contraseña`, `id_rol`, `genero`, `legajo`, `titulo`, `estado`) VALUES
(2, 'Demian Agustin', 'Perez', '2004-01-29', 45467149, '2646058767', 'dem23@gmail.com', '9 de Julio y San Juan', '2023-09-19', 'Argentina', 'Angaco', '12345', 3, 'Masculino', 0, '', 'Activo'),
(4, 'Maxi ', 'Sarmiento', '2023-11-01', 45424189, '2646210943', 'maxisarmiento@gmail.com', 'San Juan 7, alem 77.', '2022-01-29', 'Argentina', 'Rivadavia', '2345', 1, 'Masculino', 0, '', 'Activo'),
(5, 'Agustin Bastian', 'Gomez Lopez', '2023-11-28', 44321280, '2646067481', 'agustin78@gmail.com', 'Villa Colon', '2023-11-28', 'Argentina', 'Caucete', '2390xsc', 1, 'Masculino', 0, '', 'Inactivo'),
(6, 'David ', 'Nievas', '2023-11-01', 22073611, '2734542309', 'david@gmail.com', 'Laprida', '2023-11-22', 'Argentina', 'San Martín', '23profe4', 1, 'Masculino', 0, '', 'Activo'),
(7, 'Rocio', 'Cuello', '1978-06-27', 19202321, '2643421890', 'roocue45@gmail.com', '2 Acequias', '2023-11-15', 'Argentina', 'San Martín', '3234122', 2, 'Femenino', 0, '', 'Activo'),
(8, 'Lautaro', 'Correa', '2004-04-15', 45314890, '2645362903', 'lauta12@gmail.com', 'alem y laprida', '2016-03-23', 'Argentina', 'Angaco', '1234lau', 1, 'Masculino', 0, '', 'Activo');

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
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_persona_2` (`id_persona`),
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
  ADD PRIMARY KEY (`id_materia`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_ciclo` (`id_ciclo`);

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
  MODIFY `Id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `asignar`
--
ALTER TABLE `asignar`
  MODIFY `id_asignar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `alumno_materia_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `alumno_materia_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `alumno_materia_ibfk_4` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`),
  ADD CONSTRAINT `alumno_materia_ibfk_5` FOREIGN KEY (`cod_correlativa`) REFERENCES `correlativa` (`cod_correlativa`);

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
  ADD CONSTRAINT `correlativa_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `curso_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`);

--
-- Filtros para la tabla `materia`
--
ALTER TABLE `materia`
  ADD CONSTRAINT `materia_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  ADD CONSTRAINT `mesa_examen_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`),
  ADD CONSTRAINT `mesa_examen_ibfk_2` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `mesa_examen_ibfk_3` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_lectivo` (`id_ciclo`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
