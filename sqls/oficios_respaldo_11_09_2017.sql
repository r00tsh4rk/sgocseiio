-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-09-2017 a las 16:38:56
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oficios`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `comparar_fechas` (IN `idcurso` INT)  BEGIN

DECLARE fecha_actual DATE default DATE_FORMAT(now(),'%Y-%m-%d');
DECLARE termino DATE;
DECLARE nuevo_estatus VARCHAR(90);

SELECT fecha_termino from recepcion_oficios where id_recepcion = idcurso into termino;

IF (fecha_actual > termino)
	THEN
		UPDATE recepcion_oficios as t SET t.`status`='No Contestado' where t.id_recepcion = idcurso;
	END IF;
	
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `comparar_fechas_internas` ()  BEGIN

DECLARE fecha_actual DATE default DATE_FORMAT(now(),'%Y-%m-%d');
DECLARE termino DATE;
DECLARE nuevo_estatus VARCHAR(90);

SELECT fecha_termino from emision_interna where id_recepcion_int = idcurso into termino;

IF (fecha_actual > termino)
	THEN
		UPDATE emision_interna as t SET t.`status`='No Contestado' where t.id_recepcion_int = idcurso;
	END IF;
	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_direcciones`
--

CREATE TABLE `asignacion_direcciones` (
  `id_asignacion` int(11) NOT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `observaciones` text,
  `hora_asignacion` time DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asignacion_direcciones`
--

INSERT INTO `asignacion_direcciones` (`id_asignacion`, `id_direccion`, `id_recepcion`, `observaciones`, `hora_asignacion`, `fecha_asignacion`) VALUES
(3, 4, 17, 'Turnar a Tecnologia', '15:58:20', '2017-08-25'),
(4, 4, 18, 'Turnar al área correspondiente\r\n   ', '09:56:41', '2017-09-01'),
(5, 4, 19, 'Turnar a tecnologia\r\n   ', '12:08:37', '2017-09-01'),
(6, 5, 20, 'Dar contestación ', '09:23:06', '2017-09-04'),
(7, 4, 21, 'Turnar a la dirección de planeación\r\n   ', '12:49:30', '2017-09-04'),
(8, 4, 22, 'Turnar al Depto. de Infra   ', '09:31:13', '2017-09-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_interna`
--

CREATE TABLE `asignacion_interna` (
  `id_asignacion_int` int(11) NOT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `observaciones` text,
  `hora_asignacion` time DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que sirve para realizar la asignacion del oficio, desde la direccion en turno al departamento que debe de responder el oficio';

--
-- Volcado de datos para la tabla `asignacion_interna`
--

INSERT INTO `asignacion_interna` (`id_asignacion_int`, `id_direccion`, `id_area`, `id_recepcion`, `observaciones`, `hora_asignacion`, `fecha_asignacion`) VALUES
(2, 2, 10, 1, '    \r\n         ', '12:19:41', '2017-09-05'),
(3, 4, 13, 2, 'Dar respuesta lo mas pronto posible\r\n         ', '12:33:10', '2017-09-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacion_oficio`
--

CREATE TABLE `asignacion_oficio` (
  `id_asignacion` int(11) NOT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `id_area` int(11) DEFAULT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `observaciones` text,
  `fecha_asignacion` date DEFAULT NULL,
  `hora_asignacion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que sirve para realizar la asignacion del oficio, desde la direccion en turno al departamento que debe de responder el oficio';

--
-- Volcado de datos para la tabla `asignacion_oficio`
--

INSERT INTO `asignacion_oficio` (`id_asignacion`, `id_direccion`, `id_area`, `id_recepcion`, `observaciones`, `fecha_asignacion`, `hora_asignacion`) VALUES
(2, 4, 13, 18, 'Realizar la respuesta lo más pronto posible \r\n   ', '2017-09-01', '10:00:13'),
(3, 4, 13, 19, 'Dar respuesta lo mas pronto posible', '2017-09-01', '13:15:03'),
(4, 4, 13, 21, 'Responder a la solicitud', '2017-09-04', '13:13:05'),
(5, 4, 15, 22, 'Realizar la respuesta lo mas pronto posible', '2017-09-06', '09:51:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crtl_acceso`
--

CREATE TABLE `crtl_acceso` (
  `id_acceso` int(11) NOT NULL,
  `clave_area` varchar(100) NOT NULL DEFAULT '0',
  `nombre` varchar(300) NOT NULL DEFAULT '0',
  `hora_acceso` time DEFAULT NULL,
  `fecha_acceso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `crtl_acceso`
--

INSERT INTO `crtl_acceso` (`id_acceso`, `clave_area`, `nombre`, `hora_acceso`, `fecha_acceso`) VALUES
(1, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '11:35:26', '2017-08-11'),
(2, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '11:36:35', '2017-08-11'),
(3, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:37:47', '2017-08-11'),
(4, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '11:38:28', '2017-08-11'),
(5, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:00:58', '2017-08-11'),
(6, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '15:03:39', '2017-08-11'),
(7, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:28:00', '2017-08-11'),
(8, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:32:53', '2017-08-11'),
(9, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:14:27', '2017-08-14'),
(10, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:21:27', '2017-08-14'),
(11, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:22:05', '2017-08-14'),
(12, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:49:39', '2017-08-14'),
(13, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:47:28', '2017-08-14'),
(14, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '12:55:34', '2017-08-14'),
(15, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:56:24', '2017-08-14'),
(16, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '17:16:40', '2017-08-14'),
(17, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:17:10', '2017-08-14'),
(18, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '17:42:20', '2017-08-14'),
(19, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:45:04', '2017-08-14'),
(20, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '17:45:55', '2017-08-14'),
(21, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '08:57:24', '2017-08-15'),
(22, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:03:04', '2017-08-15'),
(23, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:12:40', '2017-08-15'),
(24, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:15:08', '2017-08-15'),
(25, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:57:32', '2017-08-15'),
(26, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '13:06:55', '2017-08-15'),
(27, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:24:13', '2017-08-15'),
(28, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:27:13', '2017-08-16'),
(29, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:27:32', '2017-08-16'),
(30, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:40:18', '2017-08-16'),
(31, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:53:36', '2017-08-16'),
(32, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:54:09', '2017-08-16'),
(33, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:57:28', '2017-08-16'),
(34, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:57:50', '2017-08-16'),
(35, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:58:49', '2017-08-16'),
(36, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:11:27', '2017-08-16'),
(37, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:12:10', '2017-08-16'),
(38, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:14:38', '2017-08-16'),
(39, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:15:27', '2017-08-16'),
(40, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:25:48', '2017-08-16'),
(41, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:26:23', '2017-08-16'),
(42, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '12:12:07', '2017-08-16'),
(43, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:16:14', '2017-08-16'),
(44, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:55:03', '2017-08-16'),
(45, 'dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', '13:19:58', '2017-08-16'),
(46, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:22:14', '2017-08-16'),
(47, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:50:58', '2017-08-16'),
(48, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:56:18', '2017-08-16'),
(49, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:56:34', '2017-08-16'),
(50, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:01:10', '2017-08-16'),
(51, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:49:28', '2017-08-16'),
(52, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '16:50:09', '2017-08-16'),
(53, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:00:07', '2017-08-17'),
(54, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:22:41', '2017-08-17'),
(55, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '10:45:36', '2017-08-17'),
(56, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '10:49:10', '2017-08-17'),
(57, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:58:11', '2017-08-17'),
(58, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:58:51', '2017-08-17'),
(59, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:40:35', '2017-08-17'),
(60, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:46:32', '2017-08-17'),
(61, 'dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', '14:48:15', '2017-08-17'),
(62, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '17:03:36', '2017-08-17'),
(63, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:39:00', '2017-08-18'),
(64, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '15:38:23', '2017-08-18'),
(65, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:10:34', '2017-08-21'),
(66, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:38:12', '2017-08-21'),
(67, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '12:24:39', '2017-08-21'),
(68, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '15:55:42', '2017-08-21'),
(69, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:21:19', '2017-08-22'),
(70, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:58:37', '2017-08-22'),
(71, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '12:02:27', '2017-08-22'),
(72, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:04:34', '2017-08-22'),
(73, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '12:06:46', '2017-08-22'),
(74, 'admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', '12:09:44', '2017-08-22'),
(75, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '13:07:43', '2017-08-22'),
(76, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:09:31', '2017-08-22'),
(77, 'admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', '13:09:48', '2017-08-22'),
(78, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '13:44:37', '2017-08-22'),
(79, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:45:14', '2017-08-22'),
(80, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:46:34', '2017-08-22'),
(81, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:53:17', '2017-08-22'),
(82, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:01:49', '2017-08-22'),
(83, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:40:32', '2017-08-22'),
(84, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '15:43:28', '2017-08-22'),
(85, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:58:23', '2017-08-22'),
(86, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '17:05:27', '2017-08-22'),
(87, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '17:06:50', '2017-08-22'),
(88, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:07:19', '2017-08-22'),
(89, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:05:44', '2017-08-23'),
(90, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:18:22', '2017-08-23'),
(91, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:59:08', '2017-08-23'),
(92, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '10:08:50', '2017-08-23'),
(93, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '11:00:54', '2017-08-23'),
(94, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '11:51:16', '2017-08-23'),
(95, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '12:03:07', '2017-08-23'),
(96, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '12:06:46', '2017-08-23'),
(97, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:07:47', '2017-08-23'),
(98, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '12:10:04', '2017-08-23'),
(99, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:13:56', '2017-08-23'),
(100, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '12:15:10', '2017-08-23'),
(101, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:16:16', '2017-08-23'),
(102, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:17:08', '2017-08-23'),
(103, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '12:22:16', '2017-08-23'),
(104, 'admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', '12:23:52', '2017-08-23'),
(105, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:24:41', '2017-08-23'),
(106, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '14:12:26', '2017-08-23'),
(107, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:17:10', '2017-08-24'),
(108, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:17:20', '2017-08-24'),
(109, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:33:58', '2017-08-24'),
(110, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:34:20', '2017-08-24'),
(111, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:09:36', '2017-08-24'),
(112, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '16:17:36', '2017-08-24'),
(113, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:23:25', '2017-08-24'),
(114, 'plan_infra', 'ING. EUGENIO GALINDO TORRES', '16:31:33', '2017-08-24'),
(115, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:36:04', '2017-08-24'),
(116, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:36:36', '2017-08-24'),
(117, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '16:53:41', '2017-08-24'),
(118, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '17:16:34', '2017-08-24'),
(119, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:17:22', '2017-08-24'),
(120, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:22:40', '2017-08-24'),
(121, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '17:23:22', '2017-08-24'),
(122, 'admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', '17:24:44', '2017-08-24'),
(123, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '17:33:49', '2017-08-24'),
(124, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:17:55', '2017-08-25'),
(125, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:18:02', '2017-08-25'),
(126, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:27:41', '2017-08-25'),
(127, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:32:17', '2017-08-25'),
(128, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:32:46', '2017-08-25'),
(129, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:36:40', '2017-08-25'),
(130, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:42:34', '2017-08-25'),
(131, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '16:47:46', '2017-08-25'),
(132, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:48:07', '2017-08-25'),
(133, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:23:20', '2017-08-28'),
(134, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:23:29', '2017-08-28'),
(135, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:25:58', '2017-08-28'),
(136, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '10:34:34', '2017-08-30'),
(137, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '10:34:40', '2017-08-30'),
(138, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '10:35:26', '2017-08-30'),
(139, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:42:02', '2017-08-30'),
(140, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:43:33', '2017-08-30'),
(141, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '13:52:28', '2017-08-30'),
(142, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:55:52', '2017-08-30'),
(143, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:56:09', '2017-08-30'),
(144, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:29:18', '2017-08-30'),
(145, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '14:30:56', '2017-08-30'),
(146, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:35:15', '2017-08-30'),
(147, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:16:06', '2017-08-31'),
(148, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:16:24', '2017-08-31'),
(149, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '14:13:37', '2017-08-31'),
(150, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '14:25:23', '2017-08-31'),
(151, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '14:29:52', '2017-08-31'),
(152, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:32:16', '2017-08-31'),
(153, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:34:18', '2017-08-31'),
(154, 'plan_infra', 'ING. EUGENIO GALINDO TORRES', '15:04:08', '2017-08-31'),
(155, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '15:04:24', '2017-08-31'),
(156, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '15:07:05', '2017-08-31'),
(157, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '15:07:22', '2017-08-31'),
(158, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '15:07:56', '2017-08-31'),
(159, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:39:22', '2017-09-01'),
(160, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:39:31', '2017-09-01'),
(161, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:41:53', '2017-09-01'),
(162, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:55:39', '2017-09-01'),
(163, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:56:58', '2017-09-01'),
(164, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:57:23', '2017-09-01'),
(165, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:05:49', '2017-09-01'),
(166, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:33:38', '2017-09-01'),
(167, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:36:47', '2017-09-01'),
(168, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:34:47', '2017-09-01'),
(169, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '11:35:18', '2017-09-01'),
(170, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:36:47', '2017-09-01'),
(171, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '11:38:35', '2017-09-01'),
(172, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '11:48:25', '2017-09-01'),
(173, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '11:52:27', '2017-09-01'),
(174, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:13:51', '2017-09-01'),
(175, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '16:28:59', '2017-09-01'),
(176, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '16:34:59', '2017-09-01'),
(177, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:35:16', '2017-09-01'),
(178, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '16:43:46', '2017-09-01'),
(179, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '16:50:54', '2017-09-01'),
(180, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:09:07', '2017-09-04'),
(181, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:09:50', '2017-09-04'),
(182, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:21:40', '2017-09-04'),
(183, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:23:41', '2017-09-04'),
(184, 'u_juridica', '', '09:24:17', '2017-09-04'),
(185, 'u_juridica', '', '09:26:43', '2017-09-04'),
(186, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:28:06', '2017-09-04'),
(187, 'u_juridica', '', '09:28:42', '2017-09-04'),
(188, 'u_juridica', '', '09:29:06', '2017-09-04'),
(189, 'dir_uesa', 'ARQ. DAVID RUIZ NIVÓN', '09:31:11', '2017-09-04'),
(190, 'dir_uesa', 'ARQ. DAVID RUIZ NIVÓN', '09:31:17', '2017-09-04'),
(191, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:31:39', '2017-09-04'),
(192, 'juridico', '', '09:33:06', '2017-09-04'),
(193, 'academico_recepcion', 'CLARA ELENA CABALLERO LOPEZ', '09:33:52', '2017-09-04'),
(194, 'academico_recepcion', 'CLARA ELENA CABALLERO LOPEZ', '09:34:16', '2017-09-04'),
(195, 'recepcion_dir', 'RECEPCIONISTA DE DIRECCIÓN GENERAL', '09:34:32', '2017-09-04'),
(196, 'academico_academias', 'LIC. DALILA CARBALLIDO GARCÍA', '09:34:51', '2017-09-04'),
(197, 'admin_financieros', 'LIC. ARACELI COLÍN JIMENEZ', '09:35:06', '2017-09-04'),
(198, 'admin_contabilidad', 'C.P LUIS ANTONIO SANTOS LÓPEZ', '09:35:27', '2017-09-04'),
(199, 'plan_estadistica', 'ING. DAVID ERNESTO HERNÁNDEZ AVENDAÑO', '09:35:50', '2017-09-04'),
(200, 'unidad_juridica', '', '09:37:21', '2017-09-04'),
(201, 'dir_juridico', '', '09:40:23', '2017-09-04'),
(202, 'unidad_juridica', '', '09:41:57', '2017-09-04'),
(203, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '09:56:01', '2017-09-04'),
(204, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:56:23', '2017-09-04'),
(205, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:27:05', '2017-09-04'),
(206, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:32:22', '2017-09-04'),
(207, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:40:25', '2017-09-04'),
(208, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:41:45', '2017-09-04'),
(209, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:42:03', '2017-09-04'),
(210, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:42:38', '2017-09-04'),
(211, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:43:00', '2017-09-04'),
(212, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:43:12', '2017-09-04'),
(213, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '12:48:55', '2017-09-04'),
(214, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '12:49:49', '2017-09-04'),
(215, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:50:00', '2017-09-04'),
(216, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:50:13', '2017-09-04'),
(217, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:53:53', '2017-09-04'),
(218, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:54:36', '2017-09-04'),
(219, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:56:28', '2017-09-04'),
(220, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:56:39', '2017-09-04'),
(221, 'acervo', 'UNIDAD DE ACERVO', '12:57:30', '2017-09-04'),
(222, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:57:45', '2017-09-04'),
(223, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '12:58:03', '2017-09-04'),
(224, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:02:54', '2017-09-04'),
(225, 'unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', '13:03:08', '2017-09-04'),
(226, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:08:39', '2017-09-04'),
(227, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:13:21', '2017-09-04'),
(228, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:22:24', '2017-09-04'),
(229, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:23:22', '2017-09-04'),
(230, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '13:23:35', '2017-09-04'),
(231, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:33:07', '2017-09-04'),
(232, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '13:35:32', '2017-09-04'),
(233, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:14:48', '2017-09-04'),
(234, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '14:16:00', '2017-09-04'),
(235, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:18:24', '2017-09-04'),
(236, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:24:08', '2017-09-04'),
(237, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '14:30:54', '2017-09-04'),
(238, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:31:08', '2017-09-04'),
(239, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '16:57:26', '2017-09-04'),
(240, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:22:06', '2017-09-05'),
(241, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:22:12', '2017-09-05'),
(242, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '09:51:06', '2017-09-05'),
(243, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:34:52', '2017-09-05'),
(244, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:35:09', '2017-09-05'),
(245, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:17:06', '2017-09-05'),
(246, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:17:17', '2017-09-05'),
(247, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '11:31:27', '2017-09-05'),
(248, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:42:56', '2017-09-05'),
(249, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '11:43:53', '2017-09-05'),
(250, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:44:42', '2017-09-05'),
(251, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '12:01:38', '2017-09-05'),
(252, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:32:43', '2017-09-05'),
(253, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '13:45:40', '2017-09-05'),
(254, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:46:24', '2017-09-05'),
(255, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '13:47:39', '2017-09-05'),
(256, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '09:16:36', '2017-09-06'),
(257, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '09:30:09', '2017-09-06'),
(258, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:42:59', '2017-09-06'),
(259, 'plan_infra', 'ING. EUGENIO GALINDO TORRES', '09:54:38', '2017-09-06'),
(260, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:59:51', '2017-09-06'),
(261, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '10:01:10', '2017-09-06'),
(262, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '10:02:18', '2017-09-06'),
(263, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:03:46', '2017-09-06'),
(264, 'recepcion_oficialia', 'OFICIALIA DE PARTES CSEIIO', '12:53:25', '2017-09-06'),
(265, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:31:12', '2017-09-06'),
(266, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:46:00', '2017-09-08'),
(267, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:48:24', '2017-09-08'),
(268, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:05:38', '2017-09-08'),
(269, 'dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', '13:42:59', '2017-09-08'),
(270, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:43:57', '2017-09-08'),
(271, 'dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', '13:44:21', '2017-09-08'),
(272, 'dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', '13:46:36', '2017-09-08'),
(273, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '15:02:39', '2017-09-08'),
(274, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '15:02:46', '2017-09-08'),
(275, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:27:28', '2017-09-11'),
(276, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:27:34', '2017-09-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_area` int(11) NOT NULL,
  `nombre_area` varchar(100) DEFAULT NULL,
  `direccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_area`, `nombre_area`, `direccion`) VALUES
(7, 'Sudirección de Programas Educativos', 7),
(8, 'Departamento de Recursos Humanos', 2),
(9, 'Departamento de Contabilidad y Presupuesto', 2),
(10, 'Departamento de Bienes y Servicios Generales y Patrimonio', 2),
(11, 'Departamento de Recursos Financieros', 2),
(12, 'Departamento de Control Escolar', 4),
(13, 'Departamento de Tecnología y Comunicación', 4),
(14, 'Departamento de Estadística y Evaluación', 4),
(15, 'Departamento de Infraestructura, Programación y Presupuesto', 4),
(16, 'Departamento de Vinculación y Servicios Comunitarios', 7),
(17, 'Departamento de Extensión Educativa', 7),
(18, 'Departamento de Seguimiento y Evaluación ', 7),
(19, 'Departamento de Proyectos Especiales UESA', 3),
(20, 'Departamento Académico de Estudios Superiores', 3),
(21, 'Departamento de Publicaciones de Estudios Superiores', 3),
(22, 'Departamento de Académias', 7),
(23, 'Recepción', 1),
(25, 'Coordinación de Ciencias Naturales', 7),
(26, 'Coordinación de Matemáticas', 7),
(27, 'Coordinación de Orientación Educativa', 7),
(28, 'Coordinación de Lengua Indigena', 7),
(29, 'Cordinación de Lenguaje y Comunicación', 7),
(30, 'Coordinación de Ciencias Sociales', 7),
(31, 'Recepción Académica', 7),
(32, 'Departamento de Diseño Curricular', 7),
(33, 'Secretaria Particular de Dirección General', 1),
(34, 'Sin Departamentos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `nombre_direccion` varchar(100) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `nombre_direccion`) VALUES
(1, 'Dirección General'),
(2, 'Dirección Administrativa'),
(3, 'Dirección de Estudios Superiores'),
(4, 'Dirección de Planeación'),
(5, 'Unidad Jurídica'),
(6, 'Unidad de Acervo'),
(7, 'Dirección de Desarrollo Académico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emision_interna`
--

CREATE TABLE `emision_interna` (
  `id_recepcion_int` int(11) NOT NULL,
  `num_oficio` varchar(300) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `hora_emision` time DEFAULT NULL,
  `asunto` varchar(300) DEFAULT NULL,
  `tipo_recepcion` varchar(300) DEFAULT NULL COMMENT 'Interno =  Documento que se maneja en Oficinas Centrales, Externo = Documento que llega de Dependencia Externa',
  `tipo_documento` varchar(300) DEFAULT NULL COMMENT 'Oficio, Morandum, Circular',
  `emisor` varchar(300) DEFAULT NULL,
  `cargo` varchar(300) DEFAULT NULL,
  `dependencia` varchar(300) DEFAULT NULL,
  `direccion_destino` int(11) DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `archivo_oficio` varchar(300) DEFAULT NULL,
  `status` varchar(300) DEFAULT NULL COMMENT 'Pendiente, Contestado, Fuera de Plazo',
  `prioridad` varchar(300) DEFAULT NULL COMMENT 'Alta, Media, Baja',
  `observaciones` varchar(300) DEFAULT NULL,
  `flag_direciones` int(11) DEFAULT '0' COMMENT '0 = No entregado 1= Entregado',
  `flag_deptos` int(11) DEFAULT '0' COMMENT '0 = No entregado, 1 = Entregado',
  `tipo_dias` int(11) DEFAULT '0' COMMENT '0 =Dias Habiles, 1 = Dias Naturales',
  `respondido` int(11) DEFAULT '0' COMMENT '0 = No ha sido respondido, 1 = Ya fue respondido'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emision_interna`
--

INSERT INTO `emision_interna` (`id_recepcion_int`, `num_oficio`, `fecha_emision`, `hora_emision`, `asunto`, `tipo_recepcion`, `tipo_documento`, `emisor`, `cargo`, `dependencia`, `direccion_destino`, `fecha_termino`, `archivo_oficio`, `status`, `prioridad`, `observaciones`, `flag_direciones`, `flag_deptos`, `tipo_dias`, `respondido`) VALUES
(1, 'CSEIIO/DP/098/2017', '2017-09-04', '16:51:31', 'Solicitud de Material para Comisión', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 2, '2017-09-06', 'oficioaplaneacionpdf.pdf', 'Pendiente', 'Alta', 'Turnar a bienes y servicios', 1, 1, 1, 0),
(2, 'CSEIIO/DA/074/017', '2017-09-05', '10:31:53', 'Solicitud de personal de informatica', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-09-08', 'oficioaplaneacionpdf.pdf', 'Pendiente', 'Alta', 'Turnar a Tecnología', 1, 1, 1, 0),
(3, 'CSEIIO/DA/234/2017', '2017-09-05', '11:42:37', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-09-08', 'resplaneacionpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `clave_area` varchar(50) NOT NULL,
  `nombre_empleado` varchar(50) DEFAULT NULL,
  `direccion` int(11) DEFAULT NULL,
  `departamento` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`clave_area`, `nombre_empleado`, `direccion`, `departamento`, `descripcion`) VALUES
('academico_academias', 'LIC. DALILA CARBALLIDO GARCÍA', 7, 22, 'JEFA DE DEPARTAMENTO'),
('academico_curricular', 'DEPARTAMENTO DE DISEÑO CURRICULAR', 7, 32, 'JEFE DE DEPARTAMENTO'),
('academico_evaluacion', 'DEPARTAMENTO DE SEGUIMIENTO Y EVALUACIÓN', 7, 18, 'JEFE DE DEPARTAMENTO'),
('academico_extension', 'LIC. MIREYA AQUINO DIEGO', 7, 17, 'JEFA DE DEPARTAMENTO'),
('academico_recepcion', 'CLARA ELENA CABALLERO LOPEZ', 7, 31, 'RECEPCIÓN ACADÉMICA'),
('academico_subdireccion', 'LIC. DORA PATRICIA LUNA TORRES', 7, 7, 'JEFA DE DEPARTAMENTO'),
('academico_vinculacion', 'ING.JULIÁN EDUARDO HERNÁNDEZ RUIZ', 7, 16, 'JEFE DE DEPARTAMENTO'),
('acervo', 'UNIDAD DE ACERVO', 6, 34, 'UNIDAD DE ACERVO'),
('admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 2, 10, 'JEFE DE DEPARTAMENTO'),
('admin_contabilidad', 'C.P LUIS ANTONIO SANTOS LÓPEZ', 2, 9, 'JEFE DE DEPARTAMENTO'),
('admin_financieros', 'LIC. ARACELI COLÍN JIMENEZ', 2, 11, 'JEFA DE DEPARTAMENTO'),
('admin_rh', 'LIC. JENNY JASMÍN LÓPEZ ANTONIO', 2, 8, 'JEFA DE DEPARTAMENTO'),
('dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', 7, NULL, 'DIRECTOR ACADÉMICO'),
('dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', 2, NULL, 'DIRECTOR ADMINISTRATIVO'),
('dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', 1, NULL, 'DIRECTORA GENERAL'),
('dir_juridico', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', 5, NULL, 'JEFA DE UNIDAD JURIDICA'),
('dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 4, NULL, 'DIRECTOR DE PLANEACIÓN'),
('dir_uesa', 'ARQ. DAVID RUIZ NIVÓN', 3, NULL, 'DIRECTOR DE LA UESA'),
('plan_cescolar', 'LIC. AMADA CRUZ NIETO', 4, 12, 'JEFA DE DEPARTAMENTO'),
('plan_estadistica', 'ING. DAVID ERNESTO HERNÁNDEZ AVENDAÑO', 4, 14, 'JEFE DE DEPARTAMENTO'),
('plan_infra', 'ING. EUGENIO GALINDO TORRES', 4, 15, 'JEFE DE DEPARTAMENTO'),
('plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', 4, 13, 'JEFE DE DEPARTAMENTO'),
('recepcion_dir', 'RECEPCIONISTA DE DIRECCIÓN GENERAL', 1, 33, 'RECEPCIÓN DE DIRECCIÓN GENERAL'),
('recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', 1, 23, 'Unidad Central de Correspondencia'),
('sysadmin', 'SYSTEM WEBADMIN ', 4, 13, 'ADMINISTRADOR'),
('uesa_academico', 'DEPARTAMENTO ACADÉMICO DE LA UESA', 3, 20, 'JEFE DE DEPARTAMENTO'),
('uesa_proyectos', 'DEPARTAMENTO DE PROYECTOS ESPECIALES DE LA UESA', 3, 19, 'JEFE DE DEPARTAMENTO'),
('uesa_publicaciones', 'LIC. OSCAR SANTIAGO SERRANO HERRERA', 3, 21, 'JEFE DE DEPARTAMENTO'),
('unidad_juridica', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', 5, 34, 'JEFA DE UNIDAD JURIDICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcion_oficios`
--

CREATE TABLE `recepcion_oficios` (
  `id_recepcion` int(11) NOT NULL,
  `num_oficio` varchar(300) DEFAULT NULL,
  `fecha_recepcion` date DEFAULT NULL,
  `hora_recepcion` time DEFAULT NULL,
  `asunto` varchar(300) DEFAULT NULL,
  `tipo_recepcion` varchar(300) DEFAULT NULL COMMENT 'Interno =  Documento que se maneja en Oficinas Centrales, Externo = Documento que llega de Dependencia Externa',
  `tipo_documento` varchar(300) DEFAULT NULL COMMENT 'Oficio, Morandum, Circular',
  `emisor` varchar(300) DEFAULT NULL COMMENT 'Nombre del funcionario que emite el oficio',
  `dependencia_emite` varchar(300) DEFAULT NULL COMMENT 'Dependencia que emite el oficio',
  `cargo` varchar(300) DEFAULT NULL COMMENT 'Cargo de quien emite el oficio',
  `direccion_destino` int(11) DEFAULT NULL,
  `fecha_termino` date NOT NULL,
  `archivo_oficio` varchar(300) DEFAULT NULL,
  `status` varchar(300) DEFAULT NULL COMMENT 'Pendiente, Contestado, Fuera de Tiempo, No Contestado',
  `prioridad` varchar(300) DEFAULT NULL COMMENT 'Alta, Media, Baja',
  `observaciones` varchar(300) DEFAULT NULL,
  `flag_direciones` int(11) DEFAULT '0' COMMENT '0 = No entregado 1= Entregado',
  `flag_deptos` int(11) DEFAULT '0' COMMENT '0 = No entregado, 1 = Entregado',
  `tipo_dias` int(11) DEFAULT '0' COMMENT '0 =Dias Habiles, 1 = Dias Naturales',
  `respondido` int(11) DEFAULT '0' COMMENT '0 = No ha sido respondido, 1 = Ya fue respondido',
  `asignado` int(11) DEFAULT '0' COMMENT '0 = No ha sido asignado, 1= Ya fue asignado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recepcion_oficios`
--

INSERT INTO `recepcion_oficios` (`id_recepcion`, `num_oficio`, `fecha_recepcion`, `hora_recepcion`, `asunto`, `tipo_recepcion`, `tipo_documento`, `emisor`, `dependencia_emite`, `cargo`, `direccion_destino`, `fecha_termino`, `archivo_oficio`, `status`, `prioridad`, `observaciones`, `flag_direciones`, `flag_deptos`, `tipo_dias`, `respondido`, `asignado`) VALUES
(17, 'SA/DTI/1234/2017', '2017-08-25', '12:43:39', 'Solicitud de parque tecnologico ', 'Externo', 'Oficio', 'Ing. Felix Nieto Santiago', 'Dirección de Tecnologías Información', 'Director de Tecnologías de Informacion del Gobierno del Estado', 1, '2017-08-31', 'oficioaplaneacionpdf.pdf', 'Contestado', 'Alta', 'Turnar a direccion de planeacion', 1, 0, 1, 1, 1),
(18, 'SEMS/IN/DP/234/2017', '2017-09-01', '09:53:22', 'Solicitud de información de personal informatico', 'Externo', 'Oficio', 'Ing. Raul Martinez Barenca', 'SEMS', 'Coordinador Estatal de la SEMS', 1, '2017-09-04', 'semsplaneacionpdf.pdf', 'Contestado', 'Alta', 'Turnar a direccion de planeacion', 1, 1, 1, 1, 1),
(19, 'SA/DTI/1234/2017', '2017-09-01', '11:51:18', 'Solicitud de parque tecnologico ', 'Externo', 'Oficio', 'Ing. Felix Nieto Santiago', 'Dirección de Tecnologías Información del Gobierno del Estado de Oaxaca', 'Director de Tecnologías de Informacion del Gobierno del Estado', 1, '2017-09-08', 'parquetecnologicopdf.pdf', 'Contestado', 'Alta', 'Turnar a direccion de planeacion', 1, 1, 1, 1, 1),
(20, 'INE/DEP/023/2017', '2017-09-04', '09:18:36', 'Solicitud de padrón de Bachilleratos ', 'Externo', 'Oficio', 'Arq. Jose López Cruz', 'Instituto Nacional Electoral ', 'Jefe de Departamento de Depuración', 1, '2017-09-07', 'inepdf.pdf', 'Contestado', 'Alta', 'Turnar a la Unidad Juridica', 1, 0, 1, 1, 1),
(21, 'SA/DTI/2341/2017', '2017-09-04', '12:48:36', 'Alta de cuentas de correo electronico', 'Externo', 'Oficio', 'Ing. Felix Enrrique Nieto Santiago', 'Dirección de Tecnologías de Información del Gobierno del Estado', 'Director de Tecnologías de Información del Gob. del Estado', 1, '2017-09-08', 'restecnolgiapdf.pdf', 'Contestado', 'Alta', 'Turnar a la dirección correspondiente', 1, 1, 1, 1, 1),
(22, 'IOCIFED/076/2017', '2017-09-06', '09:24:37', 'Solicitud de Georeferencias de los BIC´s', 'Externo', 'Oficio', 'Lic. Pérez Matus', 'IOCIFED', 'Director de IOCIFED', 1, '2017-09-08', 'CANSINOpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_interna`
--

CREATE TABLE `respuesta_interna` (
  `id_respuesta_int` int(11) NOT NULL,
  `num_oficio` varchar(300) DEFAULT NULL,
  `fecha_respuesta` date DEFAULT NULL,
  `hora_respuesta` time DEFAULT NULL,
  `asunto` varchar(300) DEFAULT NULL,
  `tipo_respuesta` varchar(300) DEFAULT NULL,
  `tipo_documento` varchar(300) DEFAULT NULL,
  `num_oficio_respuesta` varchar(300) DEFAULT NULL,
  `emisor` varchar(300) DEFAULT NULL,
  `cargo` varchar(300) DEFAULT NULL,
  `dependencia` varchar(300) DEFAULT NULL,
  `receptor` varchar(300) DEFAULT NULL,
  `acuse_respuesta` varchar(300) DEFAULT NULL COMMENT 'Archivo de acuse de respuesta',
  `anexos` varchar(300) DEFAULT NULL COMMENT 'Archivo de anexos',
  `oficio_emision` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta_interna`
--

INSERT INTO `respuesta_interna` (`id_respuesta_int`, `num_oficio`, `fecha_respuesta`, `hora_respuesta`, `asunto`, `tipo_respuesta`, `tipo_documento`, `num_oficio_respuesta`, `emisor`, `cargo`, `dependencia`, `receptor`, `acuse_respuesta`, `anexos`, `oficio_emision`) VALUES
(1, 'CSEIIO/DA/234/2017', '2017-09-05', '13:44:40', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'CSEIIO/D.P/0294/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'C.P MARIO ANTONIO REYES BAUTISTA', 'Folio_3_Oficio_de_respuesta.pdf', 'default.pdf', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_oficios`
--

CREATE TABLE `respuesta_oficios` (
  `id_respuesta` int(11) NOT NULL,
  `num_oficio` varchar(300) DEFAULT NULL,
  `fecha_respuesta` date DEFAULT NULL,
  `hora_respuesta` time DEFAULT NULL,
  `asunto` varchar(300) DEFAULT NULL,
  `tipo_respuesta` varchar(300) DEFAULT NULL,
  `tipo_documento` varchar(300) DEFAULT NULL,
  `num_oficio_salida` varchar(300) DEFAULT NULL,
  `emisor` varchar(300) DEFAULT NULL,
  `cargo` varchar(300) DEFAULT NULL,
  `dependencia` varchar(300) DEFAULT NULL,
  `receptor` varchar(300) DEFAULT NULL,
  `acuse_respuesta` varchar(300) DEFAULT NULL COMMENT 'Archivo de acuse de respuesta',
  `anexos` varchar(300) DEFAULT NULL COMMENT 'Archivo de anexos',
  `oficio_recepcion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta_oficios`
--

INSERT INTO `respuesta_oficios` (`id_respuesta`, `num_oficio`, `fecha_respuesta`, `hora_respuesta`, `asunto`, `tipo_respuesta`, `tipo_documento`, `num_oficio_salida`, `emisor`, `cargo`, `dependencia`, `receptor`, `acuse_respuesta`, `anexos`, `oficio_recepcion`) VALUES
(5, 'SA/DTI/1234/2017', '2017-08-31', '13:06:14', 'Solicitud de parque tecnologico ', 'Externo', 'Oficio', 'CSEIIO/D.P/089/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Ing. Felix Nieto Santiago', 'Folio_17_Oficio_de_respuesta_SADTI12342017.pdf', 'default.pdf', 17),
(6, 'SEMS/IN/DP/234/2017', '2017-09-01', '11:03:08', 'Solicitud de información de personal informatico', 'Externo', 'Oficio', 'CSEIIO/DTYC/045/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Ing. Raul Martinez Barenca', 'Folio_18_Oficio_de_respuesta_SEMSINDP2342017.docx', 'Folio_18_Anexos_SEMSINDP2342017.zip', 18),
(7, 'SA/DTI/1234/2017', '2017-09-01', '16:50:24', 'Solicitud de parque tecnologico ', 'Externo', 'Oficio', 'CSEIIO/DTYC/046/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Ing. Felix Nieto Santiago', 'Folio_19_Oficio_de_respuesta_SADTI12342017.pdf', 'default.pdf', 19),
(8, 'INE/DEP/023/2017', '2017-09-04', '13:06:30', 'Solicitud de padrón de Bachilleratos ', 'Externo', 'Oficio', 'CSEIIO/UJ/234/2017', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', 'JEFA DE UNIDAD JURIDICA', 'CSEIIO', 'Arq. Jose López Cruz', 'Folio_20_Oficio_de_respuesta_INEDEP0232017.pdf', 'default.pdf', 20),
(9, 'SA/DTI/2341/2017', '2017-09-04', '13:21:41', 'Alta de cuentas de correo electronico', 'Externo', 'Oficio', 'CSEIIO/DTYC/078/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Ing. Felix Enrrique Nieto Santiago', 'Folio_21_Oficio_de_respuesta_SADTI23412017.pdf', 'Folio_21_Anexos_SADTI23412017.xlsx', 21),
(10, 'IOCIFED/076/2017', '2017-09-06', '09:58:56', 'Solicitud de Georeferencias de los BIC´s', 'Externo', 'Oficio', 'CSEIIO/DG/0567/2017', 'ING. EUGENIO GALINDO TORRES', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Pérez Matus', 'Folio_22_Oficio_de_respuesta_IOCIFED0762017.pdf', 'Folio_22_Anexos_IOCIFED0762017.rar', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnado_copias_deptos`
--

CREATE TABLE `turnado_copias_deptos` (
  `id_turcopia` int(11) NOT NULL,
  `id_depto_destino` int(11) DEFAULT NULL,
  `id_oficio_emitido` int(11) DEFAULT NULL,
  `observacion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnado_copias_dir`
--

CREATE TABLE `turnado_copias_dir` (
  `id_turcopia` int(11) NOT NULL,
  `id_direccion_destino` int(11) DEFAULT NULL,
  `id_oficio_emitido` int(11) DEFAULT NULL,
  `observacion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `clave_area` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL COMMENT '1 = Recepcion, 2 =Directores de Area, 3 = Jefe de Depto, 4=Admin, 5= Direccion General'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `clave_area`, `password`, `nivel`) VALUES
(1, 'dir_general', '12345', 5),
(2, 'dir_uesa', '12345', 2),
(3, 'dir_admin', '12345', 2),
(4, 'dir_planeacion', '12345', 2),
(6, 'plan_infra', '12345', 3),
(7, 'plan_estadistica', '12345', 3),
(8, 'plan_tecnologia', '12345', 3),
(9, 'admin_contabilidad', '12345', 3),
(10, 'admin_financieros', '12345', 3),
(13, 'recepcion_dir', '12345', 2),
(14, 'academico_recepcion', '12345', 2),
(15, 'recepcion_oficialia', '12345', 1),
(16, 'sysadmin', 'fadeca2512', 4),
(17, 'dir_academico', '12345', 2),
(18, 'academico_academias', '12345', 3),
(19, 'admin_bienes', '12345', 3),
(22, 'unidad_juridica', '12345', 2),
(24, 'acervo', '12345', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacion_direcciones`
--
ALTER TABLE `asignacion_direcciones`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `FK_asignacion_direcciones_direcciones` (`id_direccion`),
  ADD KEY `FK_asignacion_direcciones_recepcion_oficios` (`id_recepcion`);

--
-- Indices de la tabla `asignacion_interna`
--
ALTER TABLE `asignacion_interna`
  ADD PRIMARY KEY (`id_asignacion_int`),
  ADD KEY `FK_asignacion_interna_direcciones` (`id_direccion`),
  ADD KEY `FK_asignacion_interna_departamentos` (`id_area`),
  ADD KEY `FK_asignacion_interna_emision_interna` (`id_recepcion`);

--
-- Indices de la tabla `asignacion_oficio`
--
ALTER TABLE `asignacion_oficio`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `FK_asignacion_oficio_direcciones` (`id_direccion`),
  ADD KEY `FK_asignacion_oficio_departamentos` (`id_area`),
  ADD KEY `FK_asignacion_oficio_recepcion_oficios` (`id_recepcion`);

--
-- Indices de la tabla `crtl_acceso`
--
ALTER TABLE `crtl_acceso`
  ADD PRIMARY KEY (`id_acceso`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `FK_departamentos_direcciones` (`direccion`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `emision_interna`
--
ALTER TABLE `emision_interna`
  ADD PRIMARY KEY (`id_recepcion_int`),
  ADD KEY `FK_emision_interna_direcciones` (`direccion_destino`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`clave_area`),
  ADD KEY `FK_empleados_direcciones` (`direccion`),
  ADD KEY `FK_empleados_departamentos` (`departamento`);

--
-- Indices de la tabla `recepcion_oficios`
--
ALTER TABLE `recepcion_oficios`
  ADD PRIMARY KEY (`id_recepcion`),
  ADD KEY `FK_recepcion_oficios_direcciones` (`direccion_destino`);

--
-- Indices de la tabla `respuesta_interna`
--
ALTER TABLE `respuesta_interna`
  ADD PRIMARY KEY (`id_respuesta_int`),
  ADD KEY `FK_respuesta_interna_emision_interna` (`oficio_emision`);

--
-- Indices de la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `FK_respuesta_oficios_recepcion_oficios` (`oficio_recepcion`);

--
-- Indices de la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK_turnado_copias_deptos_departamentos` (`id_depto_destino`),
  ADD KEY `FK_turnado_copias_deptos_emision_interna` (`id_oficio_emitido`);

--
-- Indices de la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK__direcciones` (`id_direccion_destino`),
  ADD KEY `FK_turnado_copias_dir_emision_interna` (`id_oficio_emitido`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `FK_usuarios_empleados` (`clave_area`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignacion_direcciones`
--
ALTER TABLE `asignacion_direcciones`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `asignacion_interna`
--
ALTER TABLE `asignacion_interna`
  MODIFY `id_asignacion_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `asignacion_oficio`
--
ALTER TABLE `asignacion_oficio`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `crtl_acceso`
--
ALTER TABLE `crtl_acceso`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `emision_interna`
--
ALTER TABLE `emision_interna`
  MODIFY `id_recepcion_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `recepcion_oficios`
--
ALTER TABLE `recepcion_oficios`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `respuesta_interna`
--
ALTER TABLE `respuesta_interna`
  MODIFY `id_respuesta_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacion_direcciones`
--
ALTER TABLE `asignacion_direcciones`
  ADD CONSTRAINT `FK_asignacion_direcciones_direcciones` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_asignacion_direcciones_recepcion_oficios` FOREIGN KEY (`id_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `asignacion_interna`
--
ALTER TABLE `asignacion_interna`
  ADD CONSTRAINT `FK_asignacion_interna_departamentos` FOREIGN KEY (`id_area`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_asignacion_interna_direcciones` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_asignacion_interna_emision_interna` FOREIGN KEY (`id_recepcion`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `asignacion_oficio`
--
ALTER TABLE `asignacion_oficio`
  ADD CONSTRAINT `FK_asignacion_oficio_departamentos` FOREIGN KEY (`id_area`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_asignacion_oficio_direcciones` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_asignacion_oficio_recepcion_oficios` FOREIGN KEY (`id_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `FK_departamentos_direcciones` FOREIGN KEY (`direccion`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `emision_interna`
--
ALTER TABLE `emision_interna`
  ADD CONSTRAINT `FK_emision_interna_direcciones` FOREIGN KEY (`direccion_destino`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `FK_empleados_departamentos` FOREIGN KEY (`departamento`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_empleados_direcciones` FOREIGN KEY (`direccion`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `recepcion_oficios`
--
ALTER TABLE `recepcion_oficios`
  ADD CONSTRAINT `FK_recepcion_oficios_direcciones` FOREIGN KEY (`direccion_destino`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `respuesta_interna`
--
ALTER TABLE `respuesta_interna`
  ADD CONSTRAINT `FK_respuesta_interna_emision_interna` FOREIGN KEY (`oficio_emision`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  ADD CONSTRAINT `FK_respuesta_oficios_recepcion_oficios` FOREIGN KEY (`oficio_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  ADD CONSTRAINT `FK_turnado_copias_deptos_departamentos` FOREIGN KEY (`id_depto_destino`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_turnado_copias_deptos_emision_interna` FOREIGN KEY (`id_oficio_emitido`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  ADD CONSTRAINT `FK__direcciones` FOREIGN KEY (`id_direccion_destino`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_turnado_copias_dir_emision_interna` FOREIGN KEY (`id_oficio_emitido`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuarios_empleados` FOREIGN KEY (`clave_area`) REFERENCES `empleados` (`clave_area`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
