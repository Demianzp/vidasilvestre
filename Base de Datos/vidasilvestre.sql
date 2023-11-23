-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2023 a las 00:40:32
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
  `id_persona` int(11) NOT NULL,
  `id_mesa` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acta`
--

INSERT INTO `acta` (`id_acta`, `id_persona`, `id_mesa`, `id_ciclo`, `estado`) VALUES
(1, 0, 0, 0, ''),
(2, 2, 1, 0, ''),
(3, 5, 22, 0, 'Activo'),
(5, 1, 21, 0, 'Activo');

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
(15, 24, 1, ' Activo'),
(16, 23, 1, ' Activo'),
(17, 24, 2, ' Activo'),
(20, 23, 4, ' Activo'),
(22, 23, 1, ' Activo'),
(25, 24, 2, ' Activo'),
(26, 23, 2, ' Activo'),
(27, 24, 1, ' Activo'),
(28, 24, 2, ' Activo'),
(29, 24, 2, ' Activo'),
(30, 24, 15, ' Activo'),
(37, 42, 1, ' Activo'),
(38, 23, 2, ' Activo'),
(39, 42, 4, ' Activo'),
(40, 42, 2, ' Activo'),
(41, 24, 1, 'Activo'),
(42, 23, 3, ' Activo'),
(43, 43, 31, 'Activo'),
(44, 23, 4, 'Activo'),
(45, 24, 31, 'Inactivo'),
(46, 23, 1, 'Inactivo'),
(47, 24, 2, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclo_lectivo`
--

CREATE TABLE `ciclo_lectivo` (
  `id_ciclo` int(11) NOT NULL,
  `nombre_ciclo` varchar(50) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `Estado` varchar(11) NOT NULL,
  `id_mesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclo_lectivo`
--

INSERT INTO `ciclo_lectivo` (`id_ciclo`, `nombre_ciclo`, `fecha_inicio`, `fecha_fin`, `Estado`, `id_mesa`) VALUES
(1, '2023', '2023-11-02', '2024-11-07', 'Activo', 0),
(2, '2022', '2023-11-02', '2024-11-07', 'Activo', 0),
(3, '2019', '2023-11-01', '2023-11-03', 'Activo', 16),
(5, '2018', '2023-11-13', '2023-11-17', 'Activo', 1),
(12, '2017', '2017-06-06', '2018-07-18', 'Activo', 0),
(13, '2002', '2004-06-17', '2005-03-17', 'Activo', 0),
(14, '2009', '2009-05-17', '2010-07-17', 'Activo', 0),
(15, '2001', '2001-03-17', '2002-03-17', 'Activo', 0);

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
-- Estructura de tabla para la tabla `estadoalumno`
--

CREATE TABLE `estadoalumno` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `id_nota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estadoalumno`
--

INSERT INTO `estadoalumno` (`id`, `id_persona`, `id_materia`, `id_ciclo`, `id_nota`) VALUES
(15, 1, 3, 1, 0),
(16, 2, 1, 1, 0),
(18, 9, 2, 0, 0),
(19, 30, 1, 0, 0),
(20, 30, 2, 0, 0),
(21, 36, 1, 0, 0),
(22, 36, 2, 0, 0),
(23, 26, 1, 0, 0),
(24, 26, 2, 0, 0),
(25, 30, 2, 0, 0),
(26, 30, 3, 0, 0),
(27, 20, 1, 0, 0),
(28, 20, 4, 0, 0),
(29, 9, 3, 0, 0),
(30, 36, 31, 0, 0),
(31, 25, 31, 0, 0),
(32, 19, 2, 0, 0),
(33, 22, 1, 0, 0),
(34, 20, 2, 0, 0),
(35, 20, 3, 0, 0),
(36, 22, 2, 0, 0),
(37, 22, 3, 0, 0),
(38, 9, 31, 0, 0),
(39, 27, 31, 0, 0),
(40, 9, 2, 0, 0),
(41, 9, 1, 0, 0),
(42, 19, 4, 0, 0),
(43, 19, 31, 0, 0),
(44, 19, 4, 0, 0),
(45, 10, 31, 2, 0),
(46, 25, 4, 2, 0),
(47, 10, 1, 2, 0),
(48, 26, 31, 2, 0),
(49, 15, 2, 2, 0),
(50, 15, 31, 2, 0),
(51, 15, 4, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id_materia` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `horas` varchar(5) NOT NULL,
  `año` int(11) NOT NULL,
  `num_resolucion` int(11) NOT NULL,
  `plan_estudio` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id_materia`, `Nombre`, `descripcion`, `horas`, `año`, `num_resolucion`, `plan_estudio`, `id_tipo`, `estado`) VALUES
(1, 'Lengua', 'Lengua aplicada', '3', 2023, 1230, 111, 2, 'Activo'),
(2, 'Biologia 2', 'Biologia aplicada', '3', 2023, 23, 23, 1, 'Activo'),
(3, 'Programacion 3', '--', '1', 2020, 23, 23, 1, 'Activo'),
(4, 'Geografia', '---', '2', 2020, 2020, 2020, 2, 'Activo'),
(5, 'DDD', 'DD', '2', 2020, 2020, 2020, 0, 'Inactivo'),
(6, 'D', '2', '2', 2, 2, 2, 0, ''),
(7, 'ddd', 'dwqdqwd', '0', 2, 2, 2, 0, ''),
(8, 'qq', 'qq', '0', 2020, 2020, 2020, 0, ''),
(9, 'qq', 'qq', '0', 2020, 2020, 2020, 0, ''),
(10, 'qq', 'qqq', '0', 2, 2, 2, 0, ''),
(11, 'sasa', 'qq', '0', 2, 0, 0, 0, ''),
(12, 'de', 'eee', '1', 1, 1, 1, 0, ''),
(13, 'e', 'e', '2', 2, 2, 2, 0, ''),
(14, 'mAAA', 'q', '21', 2, 1, 0, 0, ''),
(15, 'Matematica', '---', '2', 2023, 0, 0, 0, ''),
(16, 'wwww', 'q', '2', 2023, 22, 22, 0, ''),
(17, 'qqqq', 'qqq', '2', 2023, 0, 22, 0, ''),
(18, 'qqqqqq', 'qqq', '2', 2023, 2, 2, 0, ''),
(19, 'ww', 'w', '2', 2023, 2, 2, 0, ''),
(20, 'www', 'www', '2', 2, 2, 2, 0, ''),
(21, 'dddddddddddddql', 'ddd', '2', 2023, 2023, 2023, 0, ''),
(22, 'w', 'w', '2', 2, 2, 2, 0, ''),
(23, 'wwww', 'www', '2', 2, 2, 2, 0, ''),
(24, '\'qqqqrf\'', '\'q\'', '1', 11, 11, 0, 0, ''),
(25, 'Lengua', '\'q\'', '2', 2023, 2023, 1111, 2, 'Inactivo'),
(31, 'Matematica', '.--', '2', 2023, 2023, 2023, 1, 'Activo'),
(35, '\'cascsac\'', '\'qwdqwd\'', '2', 2023, 22, 0, 1, 'Inactivo');

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
(1, 1, '2023-10-17', 'Mesa4', '13:53:43', 1, '2023-11-01', 1, 'Activo'),
(6, 5, '2023-11-02', 'Nose', '12:40:06', 2, '2023-11-15', 2, 'Activo'),
(11, 2, '2023-11-07', 'Biologia de 2023', '03:52:00', 1, '2023-11-14', 1, 'Activo'),
(12, 1, '2023-12-01', 'Mesa1', '09:00:00', 2, '2023-11-14', 1, 'Activo'),
(13, 2, '2023-12-02', 'Mesa2', '14:30:00', 2, '2023-11-15', 2, 'Activo'),
(14, 3, '2023-12-03', 'Mesa3', '11:45:00', 1, '2023-11-15', 1, 'Activo'),
(16, 15, '2023-11-22', 'Mesa77', '16:06:00', 1, '2023-11-29', 3, 'Activo'),
(17, 2, '2023-11-15', 'Mesa 333', '07:18:00', 2, '2023-11-07', 3, 'Activo'),
(18, 15, '2023-08-07', 'Mesa23', '08:04:00', 1, '2023-09-14', 1, 'Activo'),
(19, 14, '2023-11-07', 'Mesa34', '23:20:00', 3, '2023-11-14', 3, 'Activo'),
(20, 1, '2023-11-06', 'Lengua mes3', '00:46:00', 5, '2023-11-13', 3, 'Activo'),
(21, 1, '2023-11-06', 'Lengua mes3', '00:46:00', 5, '2023-11-13', 3, 'Activo'),
(22, 19, '2023-10-31', 'WWW', '12:41:00', 2, '2012-01-13', 2, 'Activo'),
(23, 3, '2023-11-01', 'P3', '18:14:00', 5, '2023-11-04', 3, 'Activo'),
(24, 2, '2023-11-01', 'mesa23', '12:41:00', 13, '2023-11-15', 1, 'Activo'),
(25, 1, '2023-11-01', 'mesa33', '15:09:00', 13, '2023-11-14', 2, 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `nota1` float NOT NULL,
  `nota2` float NOT NULL,
  `nota3` float NOT NULL,
  `nota4` float NOT NULL,
  `Nota_F` float NOT NULL,
  `fecha_n1` date NOT NULL,
  `fecha_n2` date NOT NULL,
  `fecha_n3` date NOT NULL,
  `fecha_n4` date NOT NULL,
  `fecha_nF` date NOT NULL
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
  `estado` varchar(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `nombre`, `apellido`, `fecha_nacimiento`, `DNI`, `celular`, `email_correo`, `direccion`, `fecha_ingreso`, `pais`, `ciudad`, `contraseña`, `id_rol`, `genero`, `estado`, `id_ciclo`, `id`) VALUES
(1, 'Agustin', 'inon', '2002-04-05', 44061050, '264-561-3042', 'correo@ejemplo.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123456', 1, 'Masculino', 'Inactivo', 1, 0),
(2, 'Demian', 'nose_uwu', '2004-10-05', 56465546, '264-852-7895', 'corrreoejemplo@gmail.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123uwu122', 1, '', 'Inactivo', 0, 0),
(3, 'Maxi', 'Olmos', '2002-04-05', 54654213, '264-852-3042', 'correo@gmail.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '987654', 1, '', '', 0, 0),
(4, 'Camila', 'Luzero', '1992-04-05', 44526862, '264-561-4651', 'correo123@gamil.com', '123 Calle Principal', '2023-10-06', 'Argentina', 'san-juan', '123hola', 1, '', '', 0, 0),
(5, 'Agustin', 'Lopez', '2003-10-31', 44324170, '', 'agustin23@gmail.com', 'Aguilera', '2018-07-23', 'Argentina', 'Angaco', 'agus34', 3, 'Masculino', 'Activo', 0, 0),
(7, 'Demian', 'Montaña', '2004-10-31', 45471425, '2646058712', 'demian@gmail.com', 'Calle San juan', '2017-01-22', 'Argentina', '9 de Julio', '12345', 1, 'Masculino', 'Inactivo', 0, 0),
(8, 'Axel Michel', 'Nievas', '2003-01-23', 45473151, '2646058711', 'axel@gmail.com', 'Alem', '2017-02-23', 'Argentina', 'Valle Fértil', '12345', 1, 'Masculino', 'Inactivo', 0, 0),
(9, 'Lujan Marii', 'Molina Calivar', '2003-09-27', 45214110, '2646058713', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Activo', 0, 0),
(10, 'Lujan', 'Molina', '2003-09-27', 23432432, '+542646058717', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Activo', 0, 0),
(11, 'Lujan', 'Molina', '2003-09-27', 45214117, '+542646058717', 'luja23@gmail.com', 'Calle Laprida', '2022-03-01', 'Argetina', 'San Martín', '2325sx', 1, 'Femenino', 'Inactivo', 0, 0),
(12, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Activo', 0, 0),
(13, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Inactivo', 0, 0),
(14, 'Camila', 'Lucero', '2003-10-18', 45213116, '+542645412901', 'cami@gmail.com', 'Aguilera', '2023-10-10', 'Argentina', 'Zonda', '123sxV', 1, 'Femenino', 'Inactivo', 0, 0),
(15, 'Nahuel', 'Nievas', '2004-02-12', 45473151, '2646557616', 'nahu@gmail.com', 'Vallecito', '2021-03-12', 'Argentina', 'Valle Fértil', '23dx5', 1, 'Masculino', 'Activo', 0, 0),
(16, 'Nahuel', 'Nievas', '2004-02-12', 45473153, '2646557616', 'nahu@gmail.com', 'Vallecito', '2021-03-12', 'Argentina', 'Valle Fértil', '23dx5', 1, 'Masculino', 'Inactivo', 0, 0),
(17, 'm', 'o', '2023-10-18', 12345678, '2123213124', 'maxi@gmail.com', 'a', '2023-10-18', 'Argentina', 'Ullum', '123', 3, 'Masculino', 'Activo', 0, 0),
(18, 'm', 'o', '2023-10-18', 12345678, '2123213124', 'maxi@gmail.com', 'a', '2023-10-18', 'Argentina', 'Ullum', '123', 3, 'Masculino', 'Activo', 0, 0),
(19, 'Leonel', 'Montaña', '2023-10-26', 42341223, '2544145095', 'adsad@gmail.com', 'afe', '2023-10-25', 'Argentina', 'Zonda', '234', 1, 'Masculino', 'Activo', 0, 0),
(20, 'Ulises', 'Castro', '2022-04-23', 45421242, '2745382749', 'ulises@gmail.com', 'DF', '2018-02-12', 'Argentina', 'Zonda', '234', 1, 'Masculino', 'Activo', 0, 0),
(21, 'A', 'a', '2023-10-26', 11111111, '1222314144', 'm@gmail.com', 'd', '2023-10-04', 'Argentina', 'Rawson', '123', 3, 'Masculino', 'Activo', 0, 0),
(22, 'Ian', 'Gomez', '2000-07-23', 42462163, '2646548727', 'ian@gmail.com', 'vwvew', '2017-03-23', 'Argentina', 'Valle Fértil', '1234sx', 1, 'Masculino', 'Activo', 0, 0),
(23, 'Juan', 'Gomez', '2002-02-23', 42323430, '3242342323', 'addw@gmail.com', 'dwada', '2010-02-22', 'Argentina', 'San Martín', '32323', 2, 'Femenino', 'Activo', 0, 0),
(24, 'Miguel', 'Sanchez', '2002-10-31', 43242333, '2342343341', 'asdsad@gmail.com', 'asdaasdsad', '2017-03-22', 'Argentina', 'Zonda', '232432', 2, 'Masculino', 'Activo', 0, 0),
(25, 'Santiago', 'Rodriguez', '2000-02-23', 24423432, '2646058717', 'ddad@gmail.com', 'ffwffaf', '2021-02-20', 'Argentina', 'Zonda', '3424', 1, 'Masculino', 'Activo', 0, 0),
(26, 'Demian', 'Gomez', '2003-01-23', 44231416, '2646537616', 'demwe@gmail.com', 'VALLL', '2003-02-22', 'Argentina', 'Valle Fértil', '1234sx', 1, 'Masculino', 'Activo', 0, 0),
(27, 'Federico', 'Lopez', '2003-03-23', 24234363, '2646237732', 'feder@gmail.com', 'dfsfsd', '2010-03-12', 'Argentina', '25 de Mayo', '1234', 1, 'Masculino', 'Activo', 0, 0),
(28, 'Maria', 'Montaña', '2003-11-26', 23234232, '1213131212', 'adadsas@gmail.com', 'dadadsad', '2023-11-13', 'Argentina', '25 de Mayo', '12313', 1, 'Masculino', 'Inactivo', 0, 0),
(29, 'dada', 'wddww', '2004-02-23', 24234242, '2342342342', 'awd@gmail.com', 'wdwqd', '2023-10-29', 'Argentina', 'Zonda', '1231231', 1, 'Masculino', 'Activo', 0, 0),
(30, 'wdwdwd', 'wdd', '2023-10-29', 23467342, '5643623423', 'ddd@gmail.com', 'dd', '2023-12-09', 'Argentina', 'Zonda', '2343', 1, 'Masculino', 'Activo', 0, 0),
(31, 'dad', 'ff', '2023-11-25', 23423232, '1232123212', 'wqfw@gmail.com', 'sfdsfsd', '2023-12-01', 'Argentina', 'Zonda', '324234', 1, 'Masculino', 'Inactivo', 0, 0),
(32, 'qq', 'qq', '2023-11-27', 23423423, '2332332112', '0', '0', '0000-00-00', '0', '25', '324324', 1, 'Masculino', 'Inactivo', 0, 0),
(33, 'qq', 'qqqq', '2023-12-06', 23432434, '4223423423', '0', '0', '0000-00-00', '0', '25', '434343', 1, 'Masculino', 'Inactivo', 0, 0),
(34, 'ee', 'www', '2023-10-29', 23434322, '2332432412', '0', '0', '0000-00-00', '0', '25', '32423', 1, 'Masculino', 'Inactivo', 0, 0),
(35, 'sss', 'sssssss', '2023-11-20', 49049483, '2646538930', 'dem@gmail.com', 'dddddd', '2023-11-29', 'Argentina', '25 de Mayo', '32323', 1, 'Masculino', 'Inactivo', 0, 0),
(36, 'ddddddd', 'ddd', '2023-10-29', 23432433, '2438393932', 'dadd@gmail.com', 'sfff', '2023-12-06', 'Argentina', 'Zonda', '2343423', 1, 'Masculino', 'Activo', 0, 0),
(37, 'Nombre', 'Apellido', '0000-00-00', 0, '', '', '', '0000-00-00', '', '', '', 1, '', '', 0, 0),
(38, 'www', 'wwwwwww', '2023-11-29', 3233233, '3333333322', 'dedwdw@gmail.com', 'dsdsf', '2023-12-09', 'Argentina', 'Ullum', '3333', 2, 'Otros', 'Inactivo', 0, 0),
(39, 'xxxxxxxxxxX', 'DD', '2023-10-30', 2332423, '3234234566', 'QQQDX@gmail.COM', 'DDD', '2023-12-06', 'Argentina', 'Zonda', '45564', 2, 'Otros', 'Inactivo', 0, 0),
(40, 'dem', 'ww', '2023-11-26', 2332323, '2213131212', 'dem@gmail.com', 'ww', '2023-12-06', 'Argentina', '25 de Mayo', '23432', 2, 'Otros', 'Inactivo', 0, 0),
(41, 'Demian', 'Nievas', '2023-12-06', 2324234, '2333232323', 'adem@gmail.com', 'wewewe', '2023-04-03', 'Argentina', 'Valle Fértil', '2342423', 2, 'Otros', 'Inactivo', 0, 0),
(42, 'Lupus', 'Castro', '1998-11-26', 12232121, '2423434322', 'lupus45@gmail.com', 'FFF', '2023-12-07', 'Argentina', 'Zonda', '324123', 2, 'Otros', 'Inactivo', 0, 0),
(43, 'Demian', 'Guillermo', '2023-05-17', 24432390, '2646963631', 'demad@gmail.com', 'cacacw', '2023-09-13', 'Argentina', 'Zonda', '2345', 2, 'Otros', 'Activo', 0, 0);

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
  ADD PRIMARY KEY (`id_ciclo`),
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
-- Indices de la tabla `estadoalumno`
--
ALTER TABLE `estadoalumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `id_ciclo` (`id_ciclo`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_persona_2` (`id_persona`),
  ADD KEY `id_nota` (`id_nota`);

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
  ADD PRIMARY KEY (`id_nota`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_ciclo` (`id_ciclo`),
  ADD KEY `id` (`id`);

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
  MODIFY `id_acta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `asignar`
--
ALTER TABLE `asignar`
  MODIFY `id_asignar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `ciclo_lectivo`
--
ALTER TABLE `ciclo_lectivo`
  MODIFY `id_ciclo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- AUTO_INCREMENT de la tabla `estadoalumno`
--
ALTER TABLE `estadoalumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id_materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `mesa_examen`
--
ALTER TABLE `mesa_examen`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignar`
--
ALTER TABLE `asignar`
  ADD CONSTRAINT `asignar_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`),
  ADD CONSTRAINT `asignar_ibfk_2` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id_materia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
