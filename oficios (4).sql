-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2017 a las 00:47:36
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `comparar_fechas_internas` (IN `id` INT)  BEGIN

DECLARE fecha_actual DATE default DATE_FORMAT(now(),'%Y-%m-%d');
DECLARE termino DATE;
DECLARE nuevo_estatus VARCHAR(90);

SELECT fecha_termino from emision_interna where id_recepcion_int = id into termino;

IF (fecha_actual > termino)
	THEN
		UPDATE emision_interna as t SET t.`status`='No Contestado' where t.id_recepcion_int = id;
	END IF;
	
END$$

DELIMITER ;

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
(1, 4, 13, 5, 'Dar respuesta', '15:23:56', '2017-10-03'),
(2, 2, 10, 1, '    \r\n         ', '16:40:32', '2017-10-03'),
(3, 4, 13, 8, '    \r\n         ', '10:05:07', '2017-11-30');

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
(2, 4, 15, 33, 'Dar respuesta lo más pronto posible', '2017-09-26', '13:03:07'),
(4, 4, 14, 49, '    \r\n     ', '2017-10-16', '13:35:20'),
(5, 4, 14, 51, 'Realizar la respuesta lo mas pronto posible', '2017-10-16', '13:50:40'),
(6, 4, 13, 54, '    \r\n     ', '2017-10-24', '09:40:50'),
(7, 4, 15, 56, '    \r\n     ', '2017-10-30', '13:40:02'),
(8, 7, 22, 48, '    \r\n     ', '2017-10-30', '14:58:49'),
(9, 4, 13, 58, '    \r\n   ', '2017-10-31', '14:42:02'),
(10, 4, 15, 60, '    \r\n   ', '2017-11-09', '14:49:16'),
(11, 4, 13, 64, '    \r\n   ', '2017-11-23', '14:24:04'),
(17, 4, 14, 69, '\r\n   ', '2017-12-04', '11:13:41'),
(18, 4, 13, 70, '    \r\n   ', '2017-12-04', '11:17:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_archivisticos`
--

CREATE TABLE `codigos_archivisticos` (
  `id_codigo` int(11) NOT NULL,
  `codigo` varchar(300) NOT NULL,
  `descripcion` text NOT NULL,
  `fondo` text NOT NULL,
  `sub_fondo` text NOT NULL,
  `seccion` text NOT NULL,
  `serie` text NOT NULL,
  `subserie` text NOT NULL,
  `letra` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que guarda todos los codigos archivisticos del CSEIIO con base en el Manual de Procedimientos para la Organización y Custodia del acervo Documental del CSEIIO\r\n';

--
-- Volcado de datos para la tabla `codigos_archivisticos`
--

INSERT INTO `codigos_archivisticos` (`id_codigo`, `codigo`, `descripcion`, `fondo`, `sub_fondo`, `seccion`, `serie`, `subserie`, `letra`) VALUES
(1, 'PEO-IV-1C', 'Investigacion, difusión y acervos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1C.- Investigacion, difusión y acervos', 'Sin Serie', 'Sin Subserie', 'Sin Letra'),
(2, 'PEO-IV-2C-1-I-a', 'Polizas de Egresos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '1.- Contabilidad', 'I.- Estados Financieros', 'a.- Polizas de Egresos'),
(3, 'PEO-IV-2C-1-I-b', 'Polizas de Ingresos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '1.- Contabilidad', 'I.- Estados Financieros', 'b.- Polizas de Ingresos'),
(4, 'PEO-IV-2C-1-I-c', 'Polizas de Diaro', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '1.- Contabilidad', 'I.- Estados Financieros', 'c.- Polizas de Diario'),
(5, 'PEO-IV-2C-1-II-a', 'Dictamen de Observaciones', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '1.- Contabilidad', 'II. Auditorias', 'a.- Dictamen de Observaciones'),
(6, 'PEO-IV-2C-1-II-b', 'Solventaciones ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '1.- Contabilidad', 'II. Auditorias', 'b.- Solventaciones'),
(7, 'PEO-IV-2C-2-I', 'Presupuestos a Ejercer (POA)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '2.- Presupuestos ', 'I.- Presupuestos a Ejercer (POA)', 'Sin Letra'),
(8, 'PEO-IV-2C-2-II', 'Cuentas por Liquidar Certificadas (CLC)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '2.- Presupuestos ', 'II.- Cuentas por Liquidar Certificadas (CLC)', 'Sin Letra'),
(9, 'PEO-IV-2C-2-III', 'Modificaciones Presupuestales', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '2.- Presupuestos ', 'III.- Modificaciones Presupuestales', 'Sin Letra'),
(10, 'PEO-IV-2C-2-IV', 'Correspondencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '2.- Presupuestos ', 'IV.- Correspondencia ', 'Sin Letra'),
(11, 'PEO-IV-2C-3-I', 'Estados de Cuenta Bancarios', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '3.- Financieros', 'I.- Estados de Cuenta Bancarios', 'Sin Letra'),
(12, 'PEO-IV-2C-3-II', 'Chequeras', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '3.- Financieros', 'II.- Chequeras', 'Sin Letra'),
(13, 'PEO-IV-2C-3-III', 'Anticipos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '3.- Financieros', 'III.- Anticipos', 'Sin Letra'),
(14, 'PEO-IV-2C-3-IV', 'Facturas Pendientes de Pago', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '3.- Financieros', 'IV.- Facturas Pendientes de Pago', 'Sin Letra'),
(15, 'PEO-IV-2C-4-I', 'Correspondencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'I.- Correspondencia', 'Sin Letra'),
(16, 'PEO-IV-2C-4-II-a', 'Recategorizaciones', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'II.- Expedientes', 'a.- Recategorizaciones'),
(17, 'PEO-IV-2C-4-II-b', 'Cambios y Reubicaciones', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'II.- Expedientes', 'b.- Cambios y Reubicaciones'),
(18, 'PEO-IV-2C-4-III-a', 'Incidencias', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'III.- Nóminas', 'a.- Incidencias'),
(19, 'PEO-IV-2C-4-III-b', 'Recibo de N?minas ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'III.- Nóminas', 'b.- Recibo de Nóminas'),
(20, 'PEO-IV-2C-4-IV', 'Polizas de Seguro(Último Ejercicio)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'IV.- Polizas de Seguro(Último Ejercicio)', 'Sin Letra'),
(21, 'PEO-IV-2C-4-V-a', 'Altas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'a.- Altas'),
(22, 'PEO-IV-2C-4-V-b', 'Bajas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'b.- Bajas'),
(23, 'PEO-IV-2C-4-V-c', 'Modificaciones de Salario', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'c.- Modificaciones de Salario'),
(24, 'PEO-IV-2C-4-V-d', 'Pagos Oportunos Extemporaneos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'd.- Pagos Oportunos Extemporaneos'),
(25, 'PEO-IV-2C-4-V-e', 'Incapacidades', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'e.- Incapacidades'),
(26, 'PEO-IV-2C-4-V-f', 'Dictamen 2010-2015', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'V.- Seguridad Social (IMSS)', 'f.- Dictamen 2010-2015'),
(27, 'PEO-IV-2C-4-VI-a', 'Creditos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '4.- Humanos', 'VI.- INFONAVIT', 'a.- Creditos'),
(28, 'PEO-IV-2C-5-I', 'Correspondencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'I.- Correspondencia', 'Sin Letra'),
(29, 'PEO-IV-2C-5-II-a', 'Sistema Integral para el Control de Inventarios', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'II.- Patrimonio', 'a.- Sistema Integral para el Control de Inventarios'),
(30, 'PEO-IV-2C-5-II-b', 'Planta Vehicular', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'II.- Patrimonio', 'b.- Planta Vehicular'),
(31, 'PEO-IV-2C-5-II-c', 'Poliza de Seguros', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'II.- Patrimonio', 'c.- Poliza de Seguros'),
(32, 'PEO-IV-2C-5-II-d', 'Mantenimiento', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'II.- Patrimonio', 'd.- Mantenimiento'),
(33, 'PEO-IV-2C-5-III', 'Inventarios', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2C.- Administrativa', '5.- Bienes y Servicios Generales y Patrimonio', 'III.- Inventario', 'Sin Letra'),
(34, 'PEO-IV-3C-I', 'Trasparencia', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '3C.- Jurídico', 'Sin Serie', 'I.- Trasparencia', 'Sin Letra'),
(35, 'PEO-IV-3C-II', 'Correspondencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '3C.- Jurídico', 'Sin Serie', 'II.- Correspondencia ', 'Sin Letra'),
(36, 'PEO-IV-3C-III', 'Juicios', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '3C.- Jurídico', 'Sin Serie', 'III.- Juicios', 'Sin Letra'),
(37, 'PEO-IV-1S-a', 'Plan Operativo Anual(POA) (Documento Original Resguardado en Dirección Administrativa)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', 'Sin Serie', 'Sin Subserie', 'a.- Plan Operativo Anual(POA) (Documento Original Resguardado en Dirección Administrativa)'),
(38, 'PEO-IV-1S-1-I', 'Expedientes de Alumnos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'I.- Expedientes de Alumnos', 'Sin Letra'),
(39, 'PEO-IV-1S-1-II', 'Altas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'II.- Altas', 'Sin Letra'),
(40, 'PEO-IV-1S-1-III', 'Bajas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'III.- Bajas', 'Sin Letra'),
(41, 'PEO-IV-1S-1-IV', 'Desertores', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'IV.- Desertores', 'Sin Letra'),
(42, 'PEO-IV-1S-1-V-a', 'Parciales', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'V.- Certificados', 'a.- Parciales'),
(43, 'PEO-IV-1S-1-V-b', 'Terminales', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'V.- Certificados', 'b.- Terminales'),
(44, 'PEO-IV-1S-1-VI', 'Autenticidad de Certificados', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'VI.- Autenticidad de Certificados', 'Sin Letra'),
(45, 'PEO-IV-1S-1-VII-a', 'Certificados (Cancelados) - Inutilizados', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'VII.- Certificados (Cancelados) ', 'a.- Inutilizados'),
(46, 'PEO-IV-1S-1-VII-b', 'Certificados (Cancelados) - Utilizados', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '1.- Control Escolar', 'VII.- Certificados (Cancelados) ', 'b.- Utilizados'),
(47, 'PEO-IV-1S-2-I', 'Información Estadística', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '2.- Estadistica y Evaluación', 'I.- Información Estadística', 'Sin Letra'),
(48, 'PEO-IV-1S-2-II', 'Becas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '2.- Estadistica y Evaluación', 'II.- Becas', 'Sin Letra'),
(49, 'PEO-IV-1S-3-I', 'Programa de inversión para la construcción, mantenimiento y equipamiento de espacios educativos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'I.-Programa de inversión para la construcción, mantenimiento y equipamiento de espacios educativos', 'Sin Letra'),
(50, 'PEO-IV-1S-3-II', 'Proyectos arquitectónicos de los planteles', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '1S.- Planeación\r\n', '3.- Infraestructura, Programación y Presupuesto\r\n', 'II.- Proyectos arquitectónicos de los planteles', 'Sin Letra'),
(51, 'PEO-IV-1S-3-III', 'Programa de ampliación a la cobertura', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'III.-Programa de ampliación a la cobertura', 'Sin Letra'),
(52, 'PEO-IV-1S-3-IV', 'Estudios de factibilidad para la creación de nuevos planteles', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'IV.- Estudios de factibilidad para la creación de nuevos planteles', 'Sin Letra'),
(53, 'PEO-IV-1S-3-V', 'Proyecto para el avance de la autonomía de gestión escolar(PAAGES)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'V.- Proyecto para el avance de la autonomía de gestión escolar(PAAGES)', 'Sin Letra'),
(54, 'PEO-IV-1S-3-VI', 'Informes de obra y mantenimiento', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'VI.- Informes de obra y mantenimiento', 'Sin Letra'),
(55, 'PEO-IV-1S-3-VII', 'Expedientes técnicos', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '3.- Infraestructura, Programación y Presupuesto', 'VII.- Expedientes técnicos', 'Sin Letra'),
(58, 'PEO-IV-1S-4-I-a', 'Bachilleratos (BICs)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'I.- Solicitudes (Impresos)', 'a.- Bachilleratos (BICs)'),
(59, 'PEO-IV-1S-4-I-b', 'Dependencias', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'I.- Solicitudes (Impresos)', 'b.- Dependencias'),
(60, 'PEO-IV-1S-4-I-c', 'Internas', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'I.- Solicitudes (Impresos)', 'c.- Internas'),
(61, 'PEO-IV-1S-4-II-a', 'Bachilleratos y Licenciatura', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'II.- Calidad de Internet (Digital)', 'a.- Bachilleratos y Licenciatura'),
(62, 'PEO-IV-1S-4-II-b', 'Correos Institucionales ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'II.- Calidad de Internet (Digital)', 'b.- Correos Institucionales '),
(63, 'PEO-IV-1S-4-II-c', 'Cambios de Configuración de Paginas Web', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'II.- Calidad de Internet (Digital)', 'c.- Cambios de Configuracion de Paginas Web'),
(64, 'PEO-IV-1S-4-III-a', 'Sistemas de Servicios Escolares (SISE)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'III.- Sistema (Digital)', 'a.- Sistemas de Servicios Escolares (SISE)'),
(65, 'PEO-IV-1S-4-III-b', 'Sistema de Inventarios', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'III.- Sistema (Digital)', 'b.- Sistema de Inventarios'),
(66, 'PEO-IV-1S-4-III-c', 'Sistema de Evaluación Docente y Directivos de Planteles', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'III.- Sistema (Digital)', 'c.- Sistema de Evaluacion Docente y Directivos de Planteles'),
(67, 'PEO-IV-1S-4-III-d', 'Acervo Digital (Biblioteca Virtual en Red)', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '1S.- Planeación', '4.- Tecnologias y Comunicacion', 'III.- Sistema (Digital)', 'd.- Acervo Digital (Biblioteca Virtual en Red)'),
(68, 'PEO-IV-2S-1-I', 'Correspondencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2S.- Estudios Superiores', '1.- Académico', 'I.- Correspondencia', 'Sin Letra'),
(69, 'PEO-IV-2S-1-II-a', 'Planeacion Académica - Docencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2S.- Estudios Superiores', '1.- Academico', 'II.- Planeacion Academica', 'a.- Docencia'),
(70, 'PEO-IV-2S-1-II-b', 'Planeacion Académica - Investigacion ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2S.- Estudios Superiores', '1.- Academico', 'II.- Planeacion Academica', 'b.- Investigacion'),
(71, 'PEO-IV-2S-1-II-c', 'Planeacion Académica - Extension y Vinculacion', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2S.- Estudios Superiores', '1.- Academico', 'II.- Planeacion Academica', 'c.- Extension y Vinculacion'),
(72, 'PEO-IV-2S-1-III-a', 'Seguimiento y Evaluación - Docencia ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '2S.- Estudios Superiores', '1.- Academico', 'III.- Seguimiento y Evalacuacion', 'a.- Docencia'),
(73, 'PEO-IV-4S-1-I', '15 SAN ANTONIO HUITEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '1.- Valles Centrales', 'I.- 15 SAN ANTONIO HUITEPEC', 'Sin Letra'),
(74, 'PEO-IV-4S-1-II', '29 TEOTITLÁN DEL VALLE', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '1.- Valles Centrales', 'II.- 29 TEOTITLÁN DEL VALLE', 'Sin Letra'),
(75, 'PEO-IV-4S-1-III', '42 EL GACHUPIN', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '1.- Valles Centrales', 'III.- 42 EL GACHUPÍN', 'Sin Letra'),
(76, 'PEO-IV-4S-2-I', '1 GUELATAO DE JUÁREZ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'I.- 1 GUELATAO DE JUÁREZ', 'Sin Letra'),
(77, 'PEO-IV-4S-2-II', '2 SANTA MARIA ALOTEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'II.- 2 SANTA MARIA ALOTEPEC', 'Sin Letra'),
(78, 'PEO-IV-4S-2-III', '5 SANTIAGO CHOAPAM', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'III.- 5 SANTIAGO CHOAPAM', 'Sin Letra'),
(79, 'PEO-IV-4S-2-IV', '6 SAN CRISTOBAL LACHIROAG', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'VI.- 6 SAN CRISTOBAL LACHIROAG', 'Sin Letra'),
(80, 'PEO-IV-4S-2-V', '14 JALTEPEC DE CANDAYOC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'V.- 14 JALTEPEC DE CANDAYOC', 'Sin Letra'),
(81, 'PEO-IV-4S-2-VI', '16 SANTO DOMINGO TEPUXTEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'VI.- 16 SANTO DOMINGO TEPUXTEPEC', 'Sin Letra'),
(82, 'PEO-IV-4S-2-VII', '17 SANTIAGO LALOPA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'VII.- 17 SANTIAGO LALOPA', 'Sin Letra'),
(83, 'PEO-IV-4S-2-VIII', '26 SAN ANDRES SOLAGA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'VIII.- 26 SAN ANDRES SOLAGA', 'Sin Letra'),
(84, 'PEO-IV-4S-2-IX', '39 SANTA MARÍA TEMAXCALAPA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'IX.- 39 SANTA MARIA TEMAXCALAPA', 'Sin Letra'),
(85, 'PEO-IV-4S-2-X', '40 SAN BARTOLOME ZOOGOCHO', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', 'X.- 40 SAN BARTOLOME ZOOGOCHO', 'Sin Letra'),
(86, 'PEO-IV-4S-2-XI', ' 44 SANTA MARIA YAVICHE', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '2.- Sierra Norte', ' XI.- 44 SANTA MARIA YAVICHE', 'Sin Letra'),
(87, 'PEO-IV-4S-3-I', '9 SANTIAGO  XOCHILTEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '3.- Sierra Sur', 'I.- 9 SANTIAGO  XOCHILTEPEC', 'Sin Letra'),
(88, 'PEO-IV-4S-3-II', '13 SANTIAGO XANICA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '3.- Sierra Sur', 'II.- 13 SANTIAGO XANICA', 'Sin Letra'),
(89, 'PEO-IV-4S-3-III', '35 SAN VICENTE COATLAN', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '3.- Sierra Sur', 'III.- 35 SAN VICENTE COATLAN', 'Sin Letra'),
(90, 'PEO-IV-4S-3-IV', '36 EL CARRIZAL', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '3.- Sierra Sur', 'IV.- 36 EL CARRIZAL', 'Sin Letra'),
(91, 'PEO-IV-4S-3-V', '37 LLANO VIBORA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '3.- Sierra Sur', 'V.- 37 LLANO VIBORA', 'Sin Letra'),
(92, 'PEO-IV-4S-4-I', '8 SANTA MARIA NUTIO', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '4.- Costa', 'I.- 8 SANTA MARIA NUTIO', 'Sin Letra'),
(93, 'PEO-IV-4S-4-II', '21 SANTIAGO IXTLAYUTLA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '4.- Costa', 'II.- 21 SANTIAGO IXTLAYUTLA', 'Sin Letra'),
(94, 'PEO-IV-4S-4-III', '22 SAN JOSE DE LAS FLORES', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '4.- Costa', 'III.- 22 SAN JOSE DE LAS FLORES', 'Sin Letra'),
(95, 'PEO-IV-4S-4-IV', '24 SANTIAGO TETEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '4.- Costa', 'IV.- 24 SANTIAGO TETEPEC', 'Sin Letra'),
(96, 'PEO-IV-4S-4-V', '38 ARROYO SUCHILT', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '4.- Costa', 'V.- 38 ARROYO SUCHILT', 'Sin Letra'),
(97, 'PEO-IV-4S-5-I', '4 SANTA MARIA CHIMALAPA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'I.- 4 SANTA MARIA CHIMALAPA', 'Sin Letra'),
(98, 'PEO-IV-4S-5-II', '12 SAN MIGUEL CHIMALAPA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'II.- 12 SAN MIGUEL CHIMALAPA', 'Sin Letra'),
(99, 'PEO-IV-4S-5-III', '27 ALVARO OBREGON', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'III.- 27 ALVARO OBREGON', 'Sin Letra'),
(100, 'PEO-IV-4S-5-IV', '32 SANTIAGO IXTALTEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'IV.- 32 SANTIAGO IXTALTEPEC', 'Sin Letra'),
(101, 'PEO-IV-4S-5-V', '41 BENITO JUAREZ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'V.- 41 BENITO JUAREZ', 'Sin Letra'),
(102, 'PEO-IV-4S-5-VI', '43 LA BLANCA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '5.- Istmo', 'VI.- 43 LA BLANCA', 'Sin Letra'),
(103, 'PEO-IV-4S-6-II', '18 SAN AGUSTIN TLACOTEPEC', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'II.- 18 SAN AGUSTIN TLACOTEPEC', 'Sin Letra'),
(104, 'PEO-IV-4S-6-III', '25 SAN MARTIN PERAS', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'III.- 25 SAN MARTIN PERAS', 'Sin Letra'),
(105, 'PEO-IV-4S-6-IV', '30 SAN JERONIMO NUCHITA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'IV.- 30 SAN JERONIMO NUCHITA', 'Sin Letra'),
(106, 'PEO-IV-4S-6-V', '31 SAN MIGUEL AHUEHUETITL?N', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'V.- 31 SAN MIGUEL AHUEHUETITLAN', 'Sin Letra'),
(107, 'PEO-IV-4S-6-VI', '33 LAZARO CARDENAS ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'VI.- 33 LAZARO CARDENAS ', 'Sin Letra'),
(108, 'PEO-IV-4S-6-VII', '45 SANPEDRO ÑUMÍ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '6.- Mixteca', 'VII.- 45 SANPEDRO ÑUMÍ', 'Sin Letra'),
(109, 'PEO-IV-4S-7-I', '3 ELOXOCHITLAN DE FLORES MAGON', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'I.- 3 ELOXOCHITLAN DE FLORES MAGON', 'Sin Letra'),
(110, 'PEO-IV-4S-7-II', '11 MAZATLAN VILLA DE FLORES', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'II.- 11 MAZATLAN VILLA DE FLORES', 'Sin Letra'),
(111, 'PEO-IV-4S-7-III', '19 SANTA MARIA TEOPOXCO', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'III.- 19 SANTA MARIA TEOPOXCO', 'Sin Letra'),
(112, 'PEO-IV-4S-7-IV', '20 SAN PEDRO SOCHIAPAM', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'IV.- 20 SAN PEDRO SOCHIAPAM', 'Sin Letra'),
(113, 'PEO-IV-4S-7-V', '23 SAN BARTOLOME AYAUTLA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'V.- 23 SAN BARTOLOME AYAUTLA', 'Sin Letra'),
(114, 'PEO-IV-4S-7-VI', '28 SANTOS REYES PAPALO', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'VI.- 28 SANTOS REYES PAPALO', 'Sin Letra'),
(115, 'PEO-IV-4S-7-VII', '34 SAN LORENZO CUANECUILTITLA', 'PEO.- Poder Ejecutivo del Estado de Oaxaca', 'VI.- CSEIIO', '4S.- Bachilleratos Integrales Comunitarios', '7.- Cañada', 'VII.- 34 SAN LORENZO CUANECUILTITLA', 'Sin Letra'),
(116, 'PEO-IV-2S-1-III-b', 'Seguimiento y Evaluacion - Investigacion ', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'III.- Seguimiento y Evalacuacion', 'b.- Investigación\r\n'),
(117, 'PEO-IV-2S-1-III-c', 'Seguimiento y Evaluacion - Extensión y Vinculacion\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'III.- Seguimiento y Evalacuacion\r\n', 'c.- Extensión y Vinculacion\r\n'),
(118, 'PEO-IV-2S-1-IV-a\r\n', 'Expedientes - Practica Profesional \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'IV.- Expedientes\r\n', 'a.- Practicas Profesionales\r\n'),
(119, 'PEO-IV-2S-1-IV-b\r\n', 'Expedientes - Servicio Social\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'IV.- Expedientes\r\n', 'b.- Servicio Social\r\n'),
(120, 'PEO-IV-2S-1-IV-c\r\n', 'Expedientes - Titulacion\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'IV.- Expedientes\r\n', 'c.- Titulacion\r\n'),
(121, 'PEO-IV-2S-1-V\r\n', 'Selección de Academicos \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'V.- Selección de Académicos \r\n', 'Sin Letra\r\n'),
(122, 'PEO-IV-2S-1-VI\r\n', 'Convenios\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '1.- Academico\r\n', 'VI.- Convenios\r\n', 'Sin Letra\r\n'),
(123, 'PEO-IV-2S-2-I\r\n', 'Correspondencia \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '2.- Programas y Proyectos Especiales\r\n', 'I.- Correspondencia\r\n', 'Sin Letra\r\n'),
(124, 'PEO-IV-2S-2-II-a\r\n', 'Seguimiento a Egresados\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '2.- Programas y Proyectos Especiales\r\n', 'II.- Programa\r\n', 'a.-Seguimiento a Egresados\r\n'),
(125, 'PEO-IV-2S-2-III-a\r\n', 'Vinculación Comunitaria\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '2.- Programas y Proyectos Especiales\r\n', 'III.- Proyectos\r\n', 'a.- Vinculacion Comunitaria \r\n'),
(126, 'PEO-IV-2S-3-I\r\n', 'Correspondencia \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '3.- Publicaciones \r\n', 'I.-Correspondiencia \r\n', 'Sin Letra\r\n'),
(127, 'PEO-IV-2S-3-II-a\r\n', 'Trabajos\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '3.- Publicaciones \r\n', 'II.- Seguimiento Editorial Académico\r\n', 'a.- Trabajos\r\n'),
(128, 'PEO-IV-2S-3-II-b\r\n', 'Capacitaciones\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '2S.- Estudios Superiores\r\n', '3.- Publicaciones \r\n', 'II.- Seguimiento Editorial Académico\r\n', 'b.- Capacitaciones\r\n'),
(129, 'PEO-IV-3S-1-I\r\n', 'Correspondencia \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'I.- Correspondencia\r\n', 'Sin Letra\r\n'),
(130, 'PEO-IV-3S-1-II-a\r\n', 'Planeación Academica - Inicial\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'II.- Planeación Académica\r\n', 'a.- Inicial\r\n'),
(131, 'PEO-IV-3S-1-II-b\r\n', 'Planeación Academica - Seguimiento\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'II.- Planeación Académica\r\n', 'b.- Seguimiento\r\n'),
(132, 'PEO-IV-3S-1-II-c\r\n', 'Planeación Academica - Final\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'II.- Planeación Académica\r\n', 'c.- Final\r\n'),
(133, 'PEO-IV-3S-1-III\r\n', 'Desempeño Academico \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'III.- Desempeño Académico\r\n', 'Sin Letra\r\n'),
(134, 'PEO-IV-3S-1-IV\r\n', 'Supervisión Academica\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '1.- Seguimiento y Evaluación\r\n', 'IV.- Supervisión Academica\r\n', 'Sin Letra\r\n'),
(135, 'PEO-IV-3S-2-I\r\n', 'Correspondencia \r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '2. Vinculación y Servicios Comunitarios\r\n', 'I.- Correspondencia \r\n', 'Sin Letra\r\n'),
(136, 'PEO-IV-3S-2-II\r\n', 'Informes de los asesores promotores(Impreso y Digital)\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '2. Vinculación y Servicios Comunitarios\r\n', 'II.- Informes de los asesores promotores(Impreso y Digital)\r\n', 'Sin Letra\r\n'),
(137, 'PEO-IV-3S-2-III-a\r\n', 'Formacion para el desarrollo comunitario\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '2. Vinculación y Servicios Comunitarios\r\n', 'III.- Plan de estudio de la unidad de contenido (Digital)\r\n', 'a.- Formacion para el desarrollo comunitario\r\n'),
(138, 'PEO-IV-3S-2-III-b\r\n', 'Desarrollo Comunitario\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '2. Vinculación y Servicios Comunitarios\r\n', 'III.- Plan de estudio de la unidad de contenido (Digital)\r\n', 'b.- Desarrollo Comunitario\r\n'),
(139, 'PEO-IV-3S-2-IV\r\n', 'Supervision (bachilleratos) (impreso y digital)\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '2. Vinculación y Servicios Comunitarios\r\n', 'IV.- Supervisión (bachilleratos) (impreso y digital)\r\n', 'Sin Letra\r\n'),
(140, 'PEO-IV-3S-3-I-a\r\n', 'Adecuación de plan y programa de estudio\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'I.- Programas Educativos\r\n', 'a.- Adecuacion de plan y programa de estudio\r\n'),
(141, 'PEO-IV-3S-3-II-a\r\n', 'Eventos: Academicos - Culturales y Deportivos\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'II.- Extensión Educativa\r\n', 'a.- Eventos: Academicos - Culturales y Deportivos\r\n'),
(142, 'PEO-IV-3S-3-II-b\r\n', 'Vinculos Institucionales: Correspondencia y Convenios\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'II.- Extensión Educativa\r\n', 'b.- Vinculos Institucionales: Correspondencia y Convenios\r\n'),
(143, 'PEO-IV-3S-3-II-c\r\n', 'Planeación de las actividades academicas(Digital): Proyecto de Lectura-Lengua Indigena-Tutorias y Orientacion Educativa\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'II.- Extensión Educativa\r\n', 'c.- Planeación de las actividades academicas(Digital): Proyecto de Lectura-Lengua Indigena-Tutorias y Orientacion Educativa\r\n'),
(144, 'PEO-IV-3S-3-II-d\r\n', 'Desempeño Académico (Digital): Base de datos de asesores investigadores, Instrumentos de seguimiento y evaluación y programa de capacitacion y actualizacion\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'II.- Extensión Educativa\r\n', 'd.- Desempeño Académico (Digital): Base de datos de asesores investigadores, Instrumentos de seguimiento y evaluacion y programa de capacitacion y actualizacion\r\n'),
(145, 'PEO-IV-3S-3-II-e\r\n', 'Material Didactico(Digital)\r\n', 'PEO.- Poder Ejecutivo del Estado de Oaxaca\r\n', 'VI.- CSEIIO\r\n', '3S.- Desarrollo Académico\r\n', '3.- Diseño Curricular\r\n', 'II.- Extensión Educativa\r\n', 'e.- Material Didactico(Digital)\r\n');

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
(1, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:41:18', '2017-11-10'),
(2, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:43:08', '2017-11-10'),
(3, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:12:34', '2017-11-13'),
(4, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:12:40', '2017-11-13'),
(5, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:33:40', '2017-11-13'),
(6, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:39:48', '2017-11-13'),
(7, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:34:43', '2017-11-13'),
(8, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:07:20', '2017-11-14'),
(9, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:07:27', '2017-11-14'),
(10, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:24:33', '2017-11-14'),
(11, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:57:00', '2017-11-14'),
(12, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '15:58:16', '2017-11-14'),
(13, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '16:59:12', '2017-11-14'),
(14, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:06:28', '2017-11-14'),
(15, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '17:19:09', '2017-11-14'),
(16, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:25:08', '2017-11-15'),
(17, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:25:15', '2017-11-15'),
(18, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:15:55', '2017-11-15'),
(19, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:17:55', '2017-11-15'),
(20, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:32:59', '2017-11-15'),
(21, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:34:14', '2017-11-15'),
(22, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:14:40', '2017-11-15'),
(23, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '14:35:12', '2017-11-15'),
(24, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:46:34', '2017-11-15'),
(25, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:15:14', '2017-11-15'),
(26, 'plan_infra', 'ING. EUGENIO GALINDO TORRES', '16:21:56', '2017-11-15'),
(27, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:37:15', '2017-11-15'),
(28, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '17:09:15', '2017-11-15'),
(29, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:02:10', '2017-11-16'),
(30, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:02:15', '2017-11-16'),
(31, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:26:13', '2017-11-17'),
(32, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:26:20', '2017-11-17'),
(33, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:09:22', '2017-11-21'),
(34, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:09:56', '2017-11-21'),
(35, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:16:18', '2017-11-21'),
(36, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:19:20', '2017-11-21'),
(37, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:33:06', '2017-11-21'),
(38, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:59:50', '2017-11-21'),
(39, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:04:52', '2017-11-21'),
(40, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:57:01', '2017-11-22'),
(41, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:57:10', '2017-11-22'),
(42, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:34:07', '2017-11-22'),
(43, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:35:10', '2017-11-22'),
(44, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:46:27', '2017-11-23'),
(45, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:56:09', '2017-11-23'),
(46, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:27:53', '2017-11-23'),
(47, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:54:09', '2017-11-23'),
(48, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:57:46', '2017-11-23'),
(49, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:00:32', '2017-11-23'),
(50, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:26:25', '2017-11-23'),
(51, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:26:51', '2017-11-23'),
(52, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '17:36:49', '2017-11-23'),
(53, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:20:38', '2017-11-24'),
(54, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:32:09', '2017-11-24'),
(55, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:32:30', '2017-11-24'),
(56, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:56:47', '2017-11-24'),
(57, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:02:27', '2017-11-24'),
(58, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:02:43', '2017-11-24'),
(59, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:03:11', '2017-11-24'),
(60, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:30:22', '2017-11-24'),
(61, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:32:18', '2017-11-24'),
(62, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '14:04:35', '2017-11-24'),
(63, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '17:15:53', '2017-11-24'),
(64, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:12:38', '2017-11-27'),
(65, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:12:43', '2017-11-27'),
(66, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:20:13', '2017-11-27'),
(67, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:20:55', '2017-11-28'),
(68, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:21:24', '2017-11-28'),
(69, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:23:56', '2017-11-28'),
(70, 'dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', '10:04:22', '2017-11-28'),
(71, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:07:24', '2017-11-28'),
(72, 'unidad_juridica', 'LIC. PAVEL ALDRETE GARCÍA', '11:16:01', '2017-11-28'),
(73, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:16:37', '2017-11-28'),
(74, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '15:55:34', '2017-11-28'),
(75, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:01:44', '2017-11-28'),
(76, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '18:19:23', '2017-11-28'),
(77, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '18:21:17', '2017-11-28'),
(78, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:50:14', '2017-11-29'),
(79, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '09:50:19', '2017-11-29'),
(80, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:50:27', '2017-11-29'),
(81, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:00:10', '2017-11-29'),
(82, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:10:13', '2017-11-29'),
(83, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:54:59', '2017-11-29'),
(84, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:17:05', '2017-11-29'),
(85, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '12:17:16', '2017-11-29'),
(86, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:48:32', '2017-11-29'),
(87, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:05:34', '2017-11-30'),
(88, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:05:43', '2017-11-30'),
(89, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:06:41', '2017-11-30'),
(90, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:04:54', '2017-11-30'),
(91, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '10:05:29', '2017-11-30'),
(92, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:18:27', '2017-11-30'),
(93, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:18:52', '2017-11-30'),
(94, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '13:19:13', '2017-11-30'),
(95, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '15:01:29', '2017-11-30'),
(96, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '15:02:33', '2017-11-30'),
(97, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:18:57', '2017-11-30'),
(98, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '16:20:20', '2017-11-30'),
(99, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '08:57:31', '2017-12-01'),
(100, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '08:57:37', '2017-12-01'),
(101, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:36:29', '2017-12-01'),
(102, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '09:39:56', '2017-12-01'),
(103, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:40:27', '2017-12-01'),
(104, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:59:47', '2017-12-01'),
(105, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:00:43', '2017-12-01'),
(106, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '11:01:01', '2017-12-01'),
(107, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:18:59', '2017-12-01'),
(108, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '14:20:05', '2017-12-01'),
(109, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '14:49:27', '2017-12-01'),
(110, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '16:10:17', '2017-12-01'),
(111, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:25:36', '2017-12-01'),
(112, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '16:54:32', '2017-12-01'),
(113, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '17:34:57', '2017-12-01'),
(114, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:10:45', '2017-12-04'),
(115, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '09:10:53', '2017-12-04'),
(116, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '10:00:13', '2017-12-04'),
(117, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '10:02:27', '2017-12-04'),
(118, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '11:15:39', '2017-12-04'),
(119, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '11:17:43', '2017-12-04'),
(120, 'plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', '11:24:28', '2017-12-04'),
(121, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '12:54:29', '2017-12-04'),
(122, 'dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', '13:10:12', '2017-12-04'),
(123, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:16:00', '2017-12-04'),
(124, 'dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', '13:19:20', '2017-12-04'),
(125, 'unidad_juridica', 'LIC. PAVEL ALDRETE GARCÍA', '13:19:53', '2017-12-04'),
(126, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '13:20:20', '2017-12-04'),
(127, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '14:07:24', '2017-12-04'),
(128, 'recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', '14:07:36', '2017-12-04');

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
(34, 'Sin Departamentos', 5),
(35, 'Sin Departamentos', 6);

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
(7, 'Dirección de Desarrollo Académico'),
(8, 'No Requiere Respuesta');

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
  `respondido` int(11) DEFAULT '0' COMMENT '0 = No ha sido respondido, 1 = Ya fue respondido',
  `tieneRespuesta` int(11) DEFAULT '1' COMMENT '1 =  Si requiere respuesta, 0 = No requiere respuesta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `emision_interna`
--

INSERT INTO `emision_interna` (`id_recepcion_int`, `num_oficio`, `fecha_emision`, `hora_emision`, `asunto`, `tipo_recepcion`, `tipo_documento`, `emisor`, `cargo`, `dependencia`, `direccion_destino`, `fecha_termino`, `archivo_oficio`, `status`, `prioridad`, `observaciones`, `flag_direciones`, `flag_deptos`, `tipo_dias`, `respondido`, `tieneRespuesta`) VALUES
(1, 'CSEIIO/DP/098/2017', '2017-09-04', '16:51:31', 'Solicitud de Material para Comisión', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 2, '2017-09-06', 'oficioaplaneacionpdf.pdf', 'Fuera de Tiempo', 'Alta', 'Turnar a bienes y servicios', 1, 1, 1, 1, 1),
(2, 'CSEIIO/DA/074/017', '2017-09-05', '10:31:53', 'Solicitud de personal de informatica', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-09-08', 'oficioaplaneacionpdf.pdf', 'No Contestado', 'Alta', 'Turnar a Tecnología', 1, 1, 1, 0, 1),
(3, 'CSEIIO/DA/234/2017', '2017-09-05', '11:42:37', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-09-08', 'resplaneacionpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 1),
(4, 'CSEIIO/DA/264/2017', '2017-10-03', '11:40:18', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-10-06', 'oficioexamplepdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 1),
(5, 'CSEIIO/DA/1234/2017', '2017-10-03', '15:20:07', 'Solicitud de información de tecnologia', 'Interno', 'Memorandúm', 'C.P MARIO ANTONIO REYES BAUTISTA', 'DIRECTOR ADMINISTRATIVO', 'CSEIIO', 4, '2017-10-06', 'oficioaplaneacionpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 1),
(6, 'CSEIIO/DP/1234/2017', '2017-10-04', '12:35:07', 'Solicitud de información', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 5, '2017-10-06', 'estadosdecuentapdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 1),
(7, 'CSEIIO/BS/1234/2017', '2017-10-04', '16:45:11', 'Solicitud de información', 'Interno', 'Memorandúm', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 4, '2017-10-06', 'bienesoficiopdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 0, 1, 1, 1),
(8, 'CSEIIO/BS/1254/2017', '2017-10-04', '16:59:39', 'Solicitud de información de tecnologia', 'Interno', 'Memorandúm', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 4, '2017-10-06', 'bienesoficiopdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 1, 1, 1, 1),
(9, 'CSEIIO/DP/567/2017', '2017-10-31', '15:57:19', 'Solicitud de información de algo', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 2, '2017-11-03', 'formatolicjacobopdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 1),
(10, 'CSEIIO/DTYC/567/2017', '2017-10-31', '18:05:35', 'Solicitud de informacion', 'Interno', 'Memorandúm', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 2, '2017-11-03', 'formatolicjacobopdf.pdf', 'No Contestado', 'Alta', 'Turnar a bienes', 1, 0, 1, 0, 1),
(11, 'CSEIIO/DP/568/2017', '2017-11-28', '11:15:20', 'Solicitud de Información de Proveedores', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 5, '2017-12-01', 'UJpdf.pdf', 'No Contestado', 'Alta', 'Se requiere lo mas pronto posible \r\n       ', 1, 0, 1, 0, 1),
(12, 'CSEIIO/DP/571/2017', '2017-11-28', '12:33:43', 'Solicitud de informacion', 'Interno', 'Memorandúm', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 2, '2017-11-30', 'oficioexamplepdf.pdf', 'Pendiente', 'Alta', 'Dar respuesta pronta\r\n       ', 1, 0, 1, 0, 1),
(13, 'CSEIIO/DTYC/600/2017', '2017-11-30', '14:00:50', 'Solicitud de material', 'Interno', 'Memorandúm', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 2, '2017-12-01', 'solicituddevehiculospdf.pdf', 'Pendiente', 'Alta', 'Dar pronta respuesta  ', 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `clave_area` varchar(50) NOT NULL,
  `nombre_empleado` varchar(50) DEFAULT NULL,
  `direccion` int(11) DEFAULT NULL,
  `departamento` int(11) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `email_personal` varchar(150) DEFAULT NULL,
  `isDir` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`clave_area`, `nombre_empleado`, `direccion`, `departamento`, `descripcion`, `email`, `email_personal`, `isDir`) VALUES
('academico_academias', 'LIC. DALILA CARBALLIDO GARCÍA', 7, 22, 'JEFA DE DEPARTAMENTO', NULL, NULL, NULL),
('academico_curricular', 'DEPARTAMENTO DE DISEÑO CURRICULAR', 7, 32, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('academico_evaluacion', 'DEPARTAMENTO DE SEGUIMIENTO Y EVALUACIÓN', 7, 18, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('academico_extension', 'LIC. MIREYA AQUINO DIEGO', 7, 17, 'JEFA DE DEPARTAMENTO', NULL, NULL, NULL),
('academico_recepcion', 'CLARA ELENA CABALLERO LOPEZ', 7, 31, 'RECEPCIÓN ACADÉMICA', NULL, NULL, NULL),
('academico_subdireccion', 'LIC. DORA PATRICIA LUNA TORRES', 7, 7, 'JEFA DE DEPARTAMENTO', NULL, NULL, NULL),
('academico_vinculacion', 'ING.JULIÁN EDUARDO HERNÁNDEZ RUIZ', 7, 16, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('acervo', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', 6, 34, 'UNIDAD DE ACERVO', NULL, NULL, 1),
('admin_bienes', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 2, 10, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('admin_contabilidad', 'C.P LUIS ANTONIO SANTOS LÓPEZ', 2, 9, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('admin_financieros', 'LIC. ARACELI COLÍN JIMENEZ', 2, 11, 'JEFA DE DEPARTAMENTO', NULL, NULL, NULL),
('admin_rh', 'LIC. JENNY JASMÍN LÓPEZ ANTONIO', 2, 8, 'JEFA DE DEPARTAMENTO', NULL, NULL, NULL),
('dir_academico', 'LIC. JORGE GIL LÓPEZ ESTEVA', 7, NULL, 'DIRECTOR ACADÉMICO', NULL, NULL, 1),
('dir_admin', 'C.P MARIO ANTONIO REYES BAUTISTA', 2, NULL, 'DIRECTOR ADMINISTRATIVO', 'j.alejandrochimal92@gmail.com', 'desarrollador2@cseiio.edu.mx', 1),
('dir_general', 'PROFA. EMILIA GARCÍA GUZMÁN', 1, NULL, 'DIRECTORA GENERAL', NULL, NULL, 1),
('dir_planeacion', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 4, NULL, 'DIRECTOR DE PLANEACIÓN', 'j.alejandrochimal92@gmail.com', 'desarrollador2@cseiio.edu.mx', 1),
('dir_uesa', 'ARQ. DAVID RUIZ NIVÓN', 3, NULL, 'DIRECTOR DE LA UESA', NULL, NULL, 1),
('plan_cescolar', 'LIC. AMADA CRUZ NIETO', 4, 12, 'JEFA DE DEPARTAMENTO', 'control.escolar@ejemplo.com', NULL, NULL),
('plan_estadistica', 'ING. DAVID ERNESTO HERNÁNDEZ AVENDAÑO', 4, 14, 'JEFE DE DEPARTAMENTO', 'desarrollador2@cseiio.edu.mx', NULL, NULL),
('plan_infra', 'ING. EUGENIO GALINDO TORRES', 4, 15, 'JEFE DE DEPARTAMENTO', 'desarrollador2@cseiio.edu.mx', NULL, NULL),
('plan_tecnologia', 'ING. ROMEO CANSINO LÓPEZ', 4, 13, 'JEFE DE DEPARTAMENTO', 'j.alejandrochimal92@gmail.com', 'desarrollador2@cseiio.edu.mx', NULL),
('recepcion_dir', 'RECEPCIONISTA DE DIRECCIÓN GENERAL', 1, 33, 'RECEPCIÓN DE DIRECCIÓN GENERAL', NULL, NULL, NULL),
('recepcion_oficialia', 'UNIDAD CENTRAL DE CORRESPONDENCIA', 1, 23, 'Unidad Central de Correspondencia', 'desarrolladorcseiio2@gmail.com', NULL, NULL),
('sysadmin', 'SYSTEM WEBADMIN ', 4, 13, 'ADMINISTRADOR', NULL, NULL, NULL),
('uesa_academico', 'DEPARTAMENTO ACADÉMICO DE LA UESA', 3, 20, 'JEFE DE DEPARTAMENTO', 'uesa.academico@ejemplo.com', NULL, NULL),
('uesa_proyectos', 'DEPARTAMENTO DE PROYECTOS ESPECIALES DE LA UESA', 3, 19, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('uesa_publicaciones', 'LIC. OSCAR SANTIAGO SERRANO HERRERA', 3, 21, 'JEFE DE DEPARTAMENTO', NULL, NULL, NULL),
('unidad_juridica', 'LIC. PAVEL ALDRETE GARCÍA', 5, 34, 'JEFE DE UNIDAD JURIDICA', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficios_salida`
--

CREATE TABLE `oficios_salida` (
  `id_oficio_salida` int(11) NOT NULL,
  `num_oficio` varchar(300) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `hora_emision` time DEFAULT NULL,
  `asunto` varchar(300) DEFAULT NULL,
  `tipo_emision` varchar(300) DEFAULT NULL,
  `tipo_documento` varchar(300) DEFAULT NULL,
  `emisor_principal` varchar(300) DEFAULT NULL,
  `titular` varchar(300) DEFAULT NULL,
  `dependencia` varchar(300) DEFAULT NULL,
  `quien_realiza_oficio` varchar(300) DEFAULT NULL,
  `cargo` varchar(300) DEFAULT NULL,
  `remitente` varchar(300) DEFAULT NULL,
  `cargo_remitente` varchar(300) DEFAULT NULL,
  `dependencia_remitente` varchar(300) DEFAULT NULL,
  `archivo` varchar(300) DEFAULT NULL,
  `observaciones` varchar(300) DEFAULT NULL,
  `codigo_archivistico` int(11) DEFAULT NULL,
  `tieneRespuesta` int(11) DEFAULT '1' COMMENT '1= Si tiene respuesta, 0 = No tiene respuesta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla que almacena los oficios que el CSEIIO emite a otras dependencia ';

--
-- Volcado de datos para la tabla `oficios_salida`
--

INSERT INTO `oficios_salida` (`id_oficio_salida`, `num_oficio`, `fecha_emision`, `hora_emision`, `asunto`, `tipo_emision`, `tipo_documento`, `emisor_principal`, `titular`, `dependencia`, `quien_realiza_oficio`, `cargo`, `remitente`, `cargo_remitente`, `dependencia_remitente`, `archivo`, `observaciones`, `codigo_archivistico`, `tieneRespuesta`) VALUES
(1, 'CSEIIO/DG/1001/2017', '2017-09-26', '17:01:00', 'Solicitud de estado de becas', 'Externo', 'Oficio', 'Direccion General', 'Profra. Emilia García Guzman', 'Direccion General', 'Ing. David Ernesto Hernandez Avendaño', 'Jefe del Departamento de Estadística ', 'Lic. Raul Sandoval Frias', 'Delegado de PROSPERA en Oaxaca', 'PROSPERA ', 'estadisticapdf.pdf', 'Ninguna', 48, 1),
(2, 'CSEIIO/D.G/1235/2017', '2017-10-30', '15:26:29', 'Solicitud de informacion de becas', 'Externo', 'Oficio', 'Direccion General', 'Profra. Emilia García Guzman', 'Direccion General', 'ING. DAVID HERNANDEZ AVENDAÑO', 'JEFE DEL DEPTO DE ESTADISTCA', 'Lic. Juan Pedro Ruiz', 'Secretario de PROSPERA OAXACA', 'PROSPERA', 'croquisReducidopdf.pdf', 'Ninguna', 48, 1),
(3, 'CSEIIO/DG/1256/2017', '2017-11-27', '14:18:26', 'Solicitud de información de becas', 'Externo', 'Oficio', 'Direccion General', 'Profra. Emilia García Guzman', 'Direccion General', 'Lic. Jacobo Sanchez López', 'Director de Planeación', 'Dr. Alejandro Robles Martinez ', 'Director de PROSPERA', 'PROSPERA', 'estadisticapdf.pdf', 'Ninguna', 48, 1),
(4, 'CSEIIO/DG/1257/2017', '2017-11-27', '14:26:33', 'Solicitud de información tecnológica ', 'Externo', 'Oficio', 'Direccion General', 'Profra. Emilia García Guzman', 'Direccion General', 'Ing. Romeo Cansino López', 'Jefe del Departamento de Tecnología y Comunicación', 'Lic. Jose Herrerias Lopez', 'Director de Tecnología e Innovación del Gobierno del Estado', 'Director de Tecnología e Innovación del Gobierno del Estado', 'parquetecnologicopdf.pdf', 'Urge entregar', 63, 1),
(5, 'CSEIIO/DG/2000/2017', '2017-11-27', '17:43:00', 'Invitación', 'Externo', 'Oficio', 'Direccion General', 'Profra. Emilia García Guzman', 'Direccion General', 'Ing. Romeo Cansino López', 'Jefe del Departamento de Tecnología y Comunicación', 'Lic. Jose Herrerias Lopez', 'Director de Tecnología e Innovación del Gobierno del Estado', 'Ciudad Administrativa', 'ejemplo2pdf.pdf', 'Ninguna', 63, 0);

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
  `asignado` int(11) DEFAULT '0' COMMENT '0 = No ha sido asignado, 1= Ya fue asignado',
  `requiereRespuesta` int(11) DEFAULT '1' COMMENT '1 = Requiere Respuesta, 0 =  No require Respuesta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recepcion_oficios`
--

INSERT INTO `recepcion_oficios` (`id_recepcion`, `num_oficio`, `fecha_recepcion`, `hora_recepcion`, `asunto`, `tipo_recepcion`, `tipo_documento`, `emisor`, `dependencia_emite`, `cargo`, `direccion_destino`, `fecha_termino`, `archivo_oficio`, `status`, `prioridad`, `observaciones`, `flag_direciones`, `flag_deptos`, `tipo_dias`, `respondido`, `asignado`, `requiereRespuesta`) VALUES
(33, 'IOCIFED/DP/123/2017', '2017-09-26', '13:01:55', 'Solicitud de información ', 'Externo', 'Oficio', 'Lic. Jose Alberto Martinez Fernandez', 'IOCIFED', 'Coordinador de IOCIFED', 4, '2017-09-29', 'inepdf.pdf', 'Contestado', 'Alta', 'Turnar a Infraestructura', 1, 1, 1, 1, 0, 1),
(34, 'IOCIFED/DP/130/2017', '2017-09-26', '15:26:59', 'Solicitud de información de planteles', 'Externo', 'Oficio', 'Lic. Jose Alberto Martinez Fernandez', 'IOCIFED', 'Coordinador de IOCIFED', 4, '2017-09-29', 'oficioapoyoestadisticapdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(35, 'SEP/DG/DP/0998/2017', '2017-09-27', '16:38:21', 'Convocatoria para ingreso', 'Externo', 'Oficio', 'Lic. Maria Eugenia Comenares Robles', 'SEP', 'Coordinadora de Servicios Académicos de la SEP', 7, '2017-09-27', 'academicopdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 0, 0, 0, 1),
(36, 'INE/DEPURACION/2345/2017', '2017-09-28', '09:40:34', 'Solicitud de Apoderado Legal', 'Externo', 'Oficio', 'Arq. Raul Vallejo Almatiz', 'INE', 'Coordinador de Depuración del INE', 5, '2017-09-27', 'inepdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 0, 0, 1, 0, 1),
(37, 'SEP/DG/DP/1009/2017', '2017-09-28', '09:41:35', 'Solicitud de apoyo', 'Externo', 'Oficio', 'Lic. Maria Eugenia Comenares Robles', 'SEP', 'Coordinadora de Servicios Académicos de la SEP', 7, '2017-09-29', 'oficioexamplepdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 0, 1),
(38, 'OFICIO UNAM/1567/2017', '2017-09-28', '09:43:10', 'Solicitud de matricula de la UESA', 'Externo', 'Oficio', 'Ing. Raul Maximino Santos', 'UNAM Ingenieria ', 'Rector de la Unidad de Ingeneria de la UNAM', 3, '2017-09-29', 'uesapdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 0, 1),
(39, 'DEMS-2017-1358', '2017-10-02', '10:12:38', 'Cuarto Concurso Nacional de Fotografía ', 'Externo', 'Oficio', 'M.A Isaías Jiménez Díaz', 'CGEMSyCyT', 'Director de Educación Media Superior', 4, '2017-10-06', '03CSEIIOpdf.pdf', 'Contestado', 'Alta', 'Turnar al departamento correspondiente', 1, 0, 1, 1, 0, 1),
(40, 'SEP/123/RG/234/UJ', '2017-10-10', '12:40:42', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-13', 'oficio1pdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 0, 1, 0, 1),
(41, 'SEP/123/RG/234/345', '2017-10-10', '12:43:03', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-11', 'oficio2pdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(42, 'SEP/123/RG/234/389', '2017-10-12', '13:45:35', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-17', 'academicopdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 0, 1, 0, 1),
(43, 'SEP/123/RG/234/378', '2017-10-12', '13:51:37', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Ortiz Cabrera', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-14', 'academicopdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 0, 0, 1, 0, 1),
(44, 'SEP/123/RG/234/390', '2017-10-12', '14:04:05', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-18', 'inepdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(45, 'SEP/123/RG/234/456', '2017-10-12', '14:31:33', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Ortiz Cabrera', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-19', 'semsplaneacionpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(46, 'SEP/123/RG/234/378', '2017-10-12', '14:38:15', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-19', 'guiapersonalizaturedTG788vnpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(47, 'SEP/123/RG/234/389', '2017-10-12', '16:18:16', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 1, '2017-10-14', 'inepdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 0, 1),
(48, 'SEP/123/RG/234/378', '2017-10-12', '16:24:26', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 7, '2017-10-13', 'inventariotecnologiapdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 1, 0, 0, 0, 1),
(49, 'SEP/123/RG/234/378', '2017-10-12', '16:25:10', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-19', 'oficioapoyoestadisticapdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 0, 1),
(50, 'SEP/123/RG/234/389', '2017-10-12', '16:26:38', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-18', 'inepdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(51, 'SEP/123/RG/234/UJ', '2017-10-12', '16:28:34', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-19', 'oficiodesolicituddecableUTPParaexteriorespdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 0, 1),
(52, 'SEP/123/RG/234/3889', '2017-10-12', '16:58:51', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Ortiz Cabrera', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-20', 'estadisticapdf.pdf', 'Fuera de Tiempo', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(53, 'SEP/123/RG/234/391', '2017-10-23', '17:26:21', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-27', 'academicopdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(54, 'SEP/123/RG/294/378', '2017-10-23', '17:41:23', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Ortiz Cabrera', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-10-27', 'inepdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 0, 1),
(55, 'INE/DEPURACION/9908/2017', '2017-10-24', '11:49:26', 'Solicitud de apoderado legal', 'Externo', 'Oficio', 'Lic. Anuard Martínez Vázquez', 'Instituto Nacional Electoral', 'Jefe del Departamento de Depuración del INE', 5, '2017-10-27', 'UJpdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 0, 1, 1, 0, 1),
(56, 'IEBO/PLANEACION/TEC/123/2017', '2017-10-30', '11:39:24', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Gabriel Santos Diaz', 'IEBO', 'Director de Planeaciòn del IEBO', 4, '2017-11-03', 'croquisReducidopdf.pdf', 'Contestado', 'Alta', 'Ninguna', 1, 1, 1, 1, 0, 1),
(57, 'IEBO/PLANEACION/TEC/124/2017', '2017-10-30', '14:09:45', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Gabriel Santos Diaz', 'IEBO', 'Director General del IEBO', 4, '2017-11-03', 'formatoregistroTICSpdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 0, 1),
(58, 'ACD/1267/2017', '2017-10-31', '14:21:05', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'SEP', 'Coordinador de Educacion superior SEP', 4, '2017-11-03', 'formatolicjacobopdf.pdf', 'Fuera de Tiempo', 'Alta', 'Realizar la respuesta lo mas pronto posible\r\n       ', 1, 1, 1, 1, 0, 1),
(59, 'SEMS/DG/0456/2017', '2017-11-08', '10:40:28', 'Solicitud de información ', 'Externo', 'Oficio', 'Lic. Anuard Martínez Vázquez', 'Subsecretaria de Educación Media Superior', 'Director General de la SEMS', 7, '2017-11-17', 'ejemplopdf.pdf', 'No Contestado', 'Alta', 'Ninguna', 1, 0, 1, 0, 0, 1),
(60, 'SEMS/DG/0457/2017', '2017-11-08', '12:46:12', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Subsecretaria de Educación Media Superior', 'Director General de la SEMS', 4, '2017-11-13', 'ejemplo2pdf.pdf', 'No Contestado', 'Alta', 'Realizar la contestación lo mas pronto posible', 1, 1, 1, 0, 0, 1),
(61, 'IFT/DG/DTYC/1567/2017', '2017-11-21', '13:02:54', 'Solicitud de información tecnológica ', 'Externo', 'Oficio', 'Lic. Anselmo Benitez Díaz', 'Instituto Federal de Telecomunicaciones', 'Director General del Instituto Federal de Telecomunicaciones', 4, '2017-11-24', 'AudioEventoDeLenguas2017pdf.pdf', 'No Contestado', 'Alta', 'Dar respuesta lo más pronto posible       ', 1, 0, 1, 0, 0, 1),
(63, 'IFT/DG/DTYC/1568/2017', '2017-11-22', '10:08:09', 'Solicitud de parque de red', 'Externo', 'Oficio', 'Lic. Anselmo Benitez Díaz', 'Instituto Federal de Telecomunicaciones', 'Director General del Instituto Federal de Telecomunicaciones', 4, '2017-11-28', 'MicrofonosEventoDeLenguas2017pdf.pdf', 'No Contestado', 'Alta', 'Dar respuesta lo mas pronto posible', 1, 0, 1, 0, 0, 1),
(64, 'IFT/DG/DTYC/1569/2017', '2017-11-23', '14:00:15', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Instituto Federal de Telecomunicaciones', 'Director General del Instituto Federal de Telecomunicaciones', 4, '2017-11-28', 'AudioEventoDeLenguas2017pdf.pdf', 'Fuera de Tiempo', 'Alta', '    \r\n       ', 1, 1, 1, 1, 0, 1),
(65, 'IFT/DG/DTYC/1569/2017', '2017-11-24', '16:41:02', 'Boletín de Información', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Instituto Federal de Telecomunicaciones', 'Director General del Instituto Federal de Telecomunicaciones', 8, '2017-11-24', 'CROQUISBAJOELLAURELpdf.pdf', 'No Contestado', 'Baja', 'Documento Informativo\r\n       ', 1, 0, 1, 0, 0, 0),
(66, 'IFT/DG/DTYC/1570/2017', '2017-11-24', '17:04:12', 'Comunicado', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Instituto Federal de Telecomunicaciones', 'Director General del Instituto Federal de Telecomunicaciones', 8, '2017-11-24', 'Cartelpdf.pdf', 'No Contestado', 'Media', 'Documento Informativo', 1, 0, 1, 0, 0, 0),
(68, 'ACD/1268/2017', '2017-11-27', '11:13:29', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Anuard Martínez Vázquez', 'Subsecretaria de Educación Media Superior', 'Coordinador de la SEMS', 4, '2017-11-30', 'MicrofonosEventoDeLenguas2017pdf.pdf', 'No Contestado', 'Alta', 'Dar respuesta lo mas pronto posible    ', 1, 0, 1, 0, 0, 1),
(69, 'ACD/1269/2017', '2017-12-04', '10:01:07', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Subsecretaria de Educación Media Superior', 'Coordinador de la SEMS', 4, '2017-12-08', 'estadisticapdf.pdf', 'Pendiente', 'Alta', '    \r\n       ', 1, 1, 1, 0, 0, 1),
(70, 'ACD/1280/2017', '2017-12-04', '11:16:21', 'Solicitud de informacion', 'Externo', 'Oficio', 'Lic. Alberto Salgado Robles', 'Subsecretaria de Educación Media Superior', 'Coordinador de la SEMS', 4, '2017-12-08', 'guiapersonalizaturedTG788vnpdf.pdf', 'Pendiente', 'Alta', '    \r\n       ', 1, 1, 1, 0, 0, 1);

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
  `oficio_emision` int(11) DEFAULT NULL,
  `codigo_archivistico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta_interna`
--

INSERT INTO `respuesta_interna` (`id_respuesta_int`, `num_oficio`, `fecha_respuesta`, `hora_respuesta`, `asunto`, `tipo_respuesta`, `tipo_documento`, `num_oficio_respuesta`, `emisor`, `cargo`, `dependencia`, `receptor`, `acuse_respuesta`, `anexos`, `oficio_emision`, `codigo_archivistico`) VALUES
(1, 'CSEIIO/DA/234/2017', '2017-09-05', '13:44:40', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'CSEIIO/D.P/0294/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'C.P MARIO ANTONIO REYES BAUTISTA', 'Folio_3_Oficio_de_respuesta.pdf', 'default.pdf', 3, 37),
(2, 'CSEIIO/DA/264/2017', '2017-10-03', '15:07:47', 'Solicitud de apoyo', 'Interno', 'Memorandúm', 'CSEIIO/D.P/0456/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'C.P MARIO ANTONIO REYES BAUTISTA', 'Folio_4_Oficio_de_respuesta.pdf', 'default.pdf', 4, 37),
(3, 'CSEIIO/DA/1234/2017', '2017-10-03', '15:38:22', 'Solicitud de información de tecnologia', 'Interno', 'Memorandúm', 'CSEIIO/DTYC/0456/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'C.P MARIO ANTONIO REYES BAUTISTA', 'Folio_5_Oficio_de_respuesta.pdf', 'default.pdf', 5, 37),
(4, 'CSEIIO/DP/098/2017', '2017-10-03', '16:42:07', 'Solicitud de Material para Comisión', 'Interno', 'Memorandúm', 'CSEIIO/DBSG/0456/2017', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'Folio_1_Oficio_de_respuesta.pdf', 'default.pdf', 1, 10),
(5, 'CSEIIO/BS/1234/2017', '2017-10-04', '17:01:03', 'Solicitud de información', 'Interno', 'Memorandúm', 'CSEIIO/D.P/0486/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 'Folio_7_Oficio_de_respuesta.pdf', 'default.pdf', 7, 49),
(6, 'CSEIIO/BS/1254/2017', '2017-12-04', '09:53:58', 'Solicitud de información de tecnologia', 'Interno', 'Memorandúm', 'CSEIIO/DTYC/2001/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'LIC. SALVADOR AVENDAÑO HERNÁNDEZ', 'Folio_8_Oficio_de_respuesta.pdf', 'default.pdf', 8, 1);

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
  `oficio_recepcion` int(11) DEFAULT NULL,
  `codigo_archivistico` int(11) DEFAULT NULL COMMENT 'Al relizar la respuesta se asigna un codigo al oficio de respuesta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta_oficios`
--

INSERT INTO `respuesta_oficios` (`id_respuesta`, `num_oficio`, `fecha_respuesta`, `hora_respuesta`, `asunto`, `tipo_respuesta`, `tipo_documento`, `num_oficio_salida`, `emisor`, `cargo`, `dependencia`, `receptor`, `acuse_respuesta`, `anexos`, `oficio_recepcion`, `codigo_archivistico`) VALUES
(1, 'IOCIFED/DP/123/2017', '2017-09-26', '14:04:51', 'Solicitud de información ', 'Externo', 'Oficio', 'CSEIIO/D.G/0234/2017', 'ING. EUGENIO GALINDO TORRES', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Jose Alberto Martinez Fernandez', 'Folio_33_Oficio_de_respuesta_IOCIFEDDP1232017.pdf', 'default.pdf', 33, 49),
(2, 'IOCIFED/DP/130/2017', '2017-09-26', '15:38:21', 'Solicitud de información de planteles', 'Externo', 'Oficio', 'CSEIIO/D.G/0235/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Jose Alberto Martinez Fernandez', 'Folio_34_Oficio_de_respuesta_IOCIFEDDP1302017.pdf', 'default.pdf', 34, 51),
(3, 'INE/DEPURACION/2345/2017', '2017-09-28', '10:42:29', 'Solicitud de Apoderado Legal', 'Externo', 'Oficio', 'CSEIIO/UJ/0234/2017', 'LIC. BEATRIZ DOMINGUEZ AGUILAR', 'JEFA DE UNIDAD JURIDICA', 'CSEIIO', 'Arq. Raul Vallejo Almatiz', 'Folio_36_Oficio_de_respuesta_INEDEPURACION23452017.pdf', 'default.pdf', 36, 35),
(4, 'DEMS-2017-1358', '2017-10-03', '11:44:58', 'Cuarto Concurso Nacional de Fotografía ', 'Externo', 'Oficio', 'CSEIIO/D.G/1234/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'M.A Isaías Jiménez Díaz', 'Folio_39_Oficio_de_respuesta_DEMS-2017-1358.pdf', 'default.pdf', 39, 59),
(5, 'SEP/123/RG/234/UJ', '2017-10-12', '13:55:50', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2345/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_40_Oficio_de_respuesta_SEP123RG234UJ.pdf', 'default.pdf', 40, 38),
(6, 'SEP/123/RG/234/345', '2017-10-12', '13:57:27', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2346/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_41_Oficio_de_respuesta_SEP123RG234345.pdf', 'default.pdf', 41, 47),
(7, 'SEP/123/RG/234/389', '2017-10-13', '13:01:24', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/1223/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_42_Oficio_de_respuesta_SEP123RG234389.pdf', 'default.pdf', 42, 44),
(8, 'SEP/123/RG/234/378', '2017-10-16', '09:20:48', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2349/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Ortiz Cabrera', 'Folio_43_Oficio_de_respuesta_SEP123RG234378.pdf', 'default.pdf', 43, 48),
(9, 'SEP/123/RG/234/390', '2017-10-16', '09:24:47', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2350/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_44_Oficio_de_respuesta_SEP123RG234390.pdf', 'default.pdf', 44, 37),
(10, 'SEP/123/RG/234/456', '2017-10-16', '09:46:10', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2351/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Ortiz Cabrera', 'Folio_45_Oficio_de_respuesta_SEP123RG234456.pdf', 'default.pdf', 45, 47),
(11, 'SEP/123/RG/234/378', '2017-10-16', '09:49:23', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2352/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_46_Oficio_de_respuesta_SEP123RG234378.pdf', 'default.pdf', 46, 47),
(12, 'SEP/123/RG/234/389', '2017-10-16', '09:52:05', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2353/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_50_Oficio_de_respuesta_SEP123RG234389.pdf', 'Folio_50_Anexos_SEP123RG234389.pdf', 50, 38),
(13, 'SEP/123/RG/234/378', '2017-10-16', '13:49:05', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2353/2017', 'ING. DAVID ERNESTO HERNÁNDEZ AVENDAÑO', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_49_Oficio_de_respuesta_SEP123RG234378.pdf', 'default.pdf', 49, 48),
(14, 'SEP/123/RG/234/UJ', '2017-10-16', '13:52:03', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2354/2017', 'ING. DAVID ERNESTO HERNÁNDEZ AVENDAÑO', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_51_Oficio_de_respuesta_SEP123RG234UJ.pdf', 'default.pdf', 51, 48),
(15, 'SEP/123/RG/234/391', '2017-10-23', '17:37:42', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DP/2352/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_53_Oficio_de_respuesta_SEP123RG234391.pdf', 'Folio_53_Anexos_SEP123RG234391.pdf', 53, 52),
(16, 'SEP/123/RG/294/378', '2017-10-24', '09:43:02', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DG/2353/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Alberto Ortiz Cabrera', 'Folio_54_Oficio_de_respuesta_SEP123RG294378.pdf', 'default.pdf', 54, 59),
(17, 'SEP/123/RG/234/3889', '2017-10-24', '11:22:22', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DG/2358/2017', 'LIC. JACOBO SÁNCHEZ LÓPEZ', 'DIRECTOR DE PLANEACIÓN', 'CSEIIO', 'Lic. Alberto Ortiz Cabrera', 'Folio_52_Oficio_de_respuesta_SEP123RG2343889.pdf', 'default.pdf', 52, 47),
(18, 'INE/DEPURACION/9908/2017', '2017-10-24', '11:51:33', 'Solicitud de apoderado legal', 'Externo', 'Oficio', 'CSEIIO/DG/2360/2017', 'LIC. PAVEL ALDRETE GARCÍA', 'JEFE DE UNIDAD JURIDICA', 'CSEIIO', 'Lic. Anuard Martínez Vázquez', 'Folio_55_Oficio_de_respuesta_INEDEPURACION99082017.pdf', 'Folio_55_Anexos_INEDEPURACION99082017.zip', 55, 35),
(19, 'IEBO/PLANEACION/TEC/123/2017', '2017-10-30', '14:42:19', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/D.G/1234/2017', 'ING. EUGENIO GALINDO TORRES', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Gabriel Santos Diaz', 'Folio_56_Oficio_de_respuesta_IEBOPLANEACIONTEC1232017.pdf', 'default.pdf', 56, 49),
(20, 'ACD/1267/2017', '2017-11-14', '17:54:32', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DG/2357/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_56_Oficio_de_respuesta_IEBOPLANEACIONTEC1232017.pdf', 'default.pdf', 58, 63),
(21, 'IFT/DG/DTYC/1569/2017', '2017-12-04', '09:55:13', 'Solicitud de informacion', 'Externo', 'Oficio', 'CSEIIO/DG/2002/2017', 'ING. ROMEO CANSINO LÓPEZ', 'JEFE DE DEPARTAMENTO', 'CSEIIO', 'Lic. Alberto Salgado Robles', 'Folio_56_Oficio_de_respuesta_IEBOPLANEACIONTEC1232017.pdf', 'default.pdf', 64, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta_oficios_salida`
--

CREATE TABLE `respuesta_oficios_salida` (
  `id_respuesta_salida` int(11) NOT NULL,
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
  `acuse_respuesta` varchar(300) DEFAULT NULL,
  `anexos` varchar(300) DEFAULT NULL,
  `oficio_emision` int(11) DEFAULT NULL,
  `codigo_archivistico` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuesta_oficios_salida`
--

INSERT INTO `respuesta_oficios_salida` (`id_respuesta_salida`, `num_oficio`, `fecha_respuesta`, `hora_respuesta`, `asunto`, `tipo_respuesta`, `tipo_documento`, `num_oficio_salida`, `emisor`, `cargo`, `dependencia`, `receptor`, `acuse_respuesta`, `anexos`, `oficio_emision`, `codigo_archivistico`) VALUES
(1, 'CSEIIO/DG/2000/2017', '2017-12-04', '14:54:23', 'Invitación', 'Externo', 'Oficio', 'CA/DTIIGE/2003/2017', 'Lic. Jose Herrerias Lopez', 'Director de Tecnología e Innovación del Gobierno del Estado', 'Ciudad Administrativa', 'CSEIIO', 'Folio_5_Oficio_de_respuesta_CSEIIODG20002017.pdf', 'default.pdf', 5, 63);

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

--
-- Volcado de datos para la tabla `turnado_copias_deptos`
--

INSERT INTO `turnado_copias_deptos` (`id_turcopia`, `id_depto_destino`, `id_oficio_emitido`, `observacion`) VALUES
(1, 10, 13, 'Para su conocimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnado_copias_depto_externa`
--

CREATE TABLE `turnado_copias_depto_externa` (
  `id_turcopia` int(11) NOT NULL,
  `id_depto_destino` int(11) DEFAULT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `nombre_emisor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turnado_copias_depto_externa`
--

INSERT INTO `turnado_copias_depto_externa` (`id_turcopia`, `id_depto_destino`, `id_recepcion`, `observaciones`, `nombre_emisor`) VALUES
(1, 21, 39, 'Para su conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(2, 13, 56, 'Para conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(3, 13, 66, 'Para su conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA');

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

--
-- Volcado de datos para la tabla `turnado_copias_dir`
--

INSERT INTO `turnado_copias_dir` (`id_turcopia`, `id_direccion_destino`, `id_oficio_emitido`, `observacion`) VALUES
(1, 4, 13, 'Para su conocimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnado_copias_dir_externas`
--

CREATE TABLE `turnado_copias_dir_externas` (
  `id_turcopia` int(11) NOT NULL,
  `id_direccion_destino` int(11) DEFAULT NULL,
  `id_recepcion` int(11) DEFAULT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `nombre_emisor` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turnado_copias_dir_externas`
--

INSERT INTO `turnado_copias_dir_externas` (`id_turcopia`, `id_direccion_destino`, `id_recepcion`, `observaciones`, `nombre_emisor`) VALUES
(1, 4, 39, 'Para su conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(2, 2, 56, 'Para conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(3, 3, 56, 'Para conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(4, 3, 66, 'Para su conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA'),
(5, 4, 66, 'Para su conocimiento', 'UNIDAD CENTRAL DE CORRESPONDENCIA');

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
(1, 'dir_general', '12345', 2),
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
(24, 'acervo', '12345', 2),
(25, 'uesa_publicaciones', '12345', 3);

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `codigos_archivisticos`
--
ALTER TABLE `codigos_archivisticos`
  ADD PRIMARY KEY (`id_codigo`);

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
-- Indices de la tabla `oficios_salida`
--
ALTER TABLE `oficios_salida`
  ADD PRIMARY KEY (`id_oficio_salida`),
  ADD KEY `FK_oficios_salida_codigos_archivisticos` (`codigo_archivistico`);

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
  ADD KEY `FK_respuesta_interna_emision_interna` (`oficio_emision`),
  ADD KEY `FK_respuesta_interna_codigos_archivisticos` (`codigo_archivistico`);

--
-- Indices de la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `FK_respuesta_oficios_recepcion_oficios` (`oficio_recepcion`),
  ADD KEY `FK_respuesta_oficios_codigos_archivisticos` (`codigo_archivistico`);

--
-- Indices de la tabla `respuesta_oficios_salida`
--
ALTER TABLE `respuesta_oficios_salida`
  ADD PRIMARY KEY (`id_respuesta_salida`),
  ADD KEY `FK_respuesta_oficios_salida_oficios_salida` (`oficio_emision`),
  ADD KEY `FK_respuesta_oficios_salida_codigos_archivisticos` (`codigo_archivistico`);

--
-- Indices de la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK_turnado_copias_deptos_departamentos` (`id_depto_destino`),
  ADD KEY `FK_turnado_copias_deptos_emision_interna` (`id_oficio_emitido`);

--
-- Indices de la tabla `turnado_copias_depto_externa`
--
ALTER TABLE `turnado_copias_depto_externa`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK_turnado_copias_depto_externa_departamentos` (`id_depto_destino`),
  ADD KEY `FK_turnado_copias_depto_externa_recepcion_oficios` (`id_recepcion`);

--
-- Indices de la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK__direcciones` (`id_direccion_destino`),
  ADD KEY `FK_turnado_copias_dir_emision_interna` (`id_oficio_emitido`);

--
-- Indices de la tabla `turnado_copias_dir_externas`
--
ALTER TABLE `turnado_copias_dir_externas`
  ADD PRIMARY KEY (`id_turcopia`),
  ADD KEY `FK_turnado_copias_dir_externas_direcciones` (`id_direccion_destino`),
  ADD KEY `FK_turnado_copias_dir_externas_recepcion_oficios` (`id_recepcion`);

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
-- AUTO_INCREMENT de la tabla `asignacion_interna`
--
ALTER TABLE `asignacion_interna`
  MODIFY `id_asignacion_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `asignacion_oficio`
--
ALTER TABLE `asignacion_oficio`
  MODIFY `id_asignacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `codigos_archivisticos`
--
ALTER TABLE `codigos_archivisticos`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- AUTO_INCREMENT de la tabla `crtl_acceso`
--
ALTER TABLE `crtl_acceso`
  MODIFY `id_acceso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `emision_interna`
--
ALTER TABLE `emision_interna`
  MODIFY `id_recepcion_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `oficios_salida`
--
ALTER TABLE `oficios_salida`
  MODIFY `id_oficio_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `recepcion_oficios`
--
ALTER TABLE `recepcion_oficios`
  MODIFY `id_recepcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT de la tabla `respuesta_interna`
--
ALTER TABLE `respuesta_interna`
  MODIFY `id_respuesta_int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `respuesta_oficios_salida`
--
ALTER TABLE `respuesta_oficios_salida`
  MODIFY `id_respuesta_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_depto_externa`
--
ALTER TABLE `turnado_copias_depto_externa`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `turnado_copias_dir_externas`
--
ALTER TABLE `turnado_copias_dir_externas`
  MODIFY `id_turcopia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `oficios_salida`
--
ALTER TABLE `oficios_salida`
  ADD CONSTRAINT `FK_oficios_salida_codigos_archivisticos` FOREIGN KEY (`codigo_archivistico`) REFERENCES `codigos_archivisticos` (`id_codigo`);

--
-- Filtros para la tabla `recepcion_oficios`
--
ALTER TABLE `recepcion_oficios`
  ADD CONSTRAINT `FK_recepcion_oficios_direcciones` FOREIGN KEY (`direccion_destino`) REFERENCES `direcciones` (`id_direccion`);

--
-- Filtros para la tabla `respuesta_interna`
--
ALTER TABLE `respuesta_interna`
  ADD CONSTRAINT `FK_respuesta_interna_codigos_archivisticos` FOREIGN KEY (`codigo_archivistico`) REFERENCES `codigos_archivisticos` (`id_codigo`),
  ADD CONSTRAINT `FK_respuesta_interna_emision_interna` FOREIGN KEY (`oficio_emision`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `respuesta_oficios`
--
ALTER TABLE `respuesta_oficios`
  ADD CONSTRAINT `FK_respuesta_oficios_codigos_archivisticos` FOREIGN KEY (`codigo_archivistico`) REFERENCES `codigos_archivisticos` (`id_codigo`),
  ADD CONSTRAINT `FK_respuesta_oficios_recepcion_oficios` FOREIGN KEY (`oficio_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `respuesta_oficios_salida`
--
ALTER TABLE `respuesta_oficios_salida`
  ADD CONSTRAINT `FK_respuesta_oficios_salida_codigos_archivisticos` FOREIGN KEY (`codigo_archivistico`) REFERENCES `codigos_archivisticos` (`id_codigo`),
  ADD CONSTRAINT `FK_respuesta_oficios_salida_oficios_salida` FOREIGN KEY (`oficio_emision`) REFERENCES `oficios_salida` (`id_oficio_salida`);

--
-- Filtros para la tabla `turnado_copias_deptos`
--
ALTER TABLE `turnado_copias_deptos`
  ADD CONSTRAINT `FK_turnado_copias_deptos_departamentos` FOREIGN KEY (`id_depto_destino`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_turnado_copias_deptos_emision_interna` FOREIGN KEY (`id_oficio_emitido`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `turnado_copias_depto_externa`
--
ALTER TABLE `turnado_copias_depto_externa`
  ADD CONSTRAINT `FK_turnado_copias_depto_externa_departamentos` FOREIGN KEY (`id_depto_destino`) REFERENCES `departamentos` (`id_area`),
  ADD CONSTRAINT `FK_turnado_copias_depto_externa_recepcion_oficios` FOREIGN KEY (`id_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `turnado_copias_dir`
--
ALTER TABLE `turnado_copias_dir`
  ADD CONSTRAINT `FK__direcciones` FOREIGN KEY (`id_direccion_destino`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_turnado_copias_dir_emision_interna` FOREIGN KEY (`id_oficio_emitido`) REFERENCES `emision_interna` (`id_recepcion_int`);

--
-- Filtros para la tabla `turnado_copias_dir_externas`
--
ALTER TABLE `turnado_copias_dir_externas`
  ADD CONSTRAINT `FK_turnado_copias_dir_externas_direcciones` FOREIGN KEY (`id_direccion_destino`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `FK_turnado_copias_dir_externas_recepcion_oficios` FOREIGN KEY (`id_recepcion`) REFERENCES `recepcion_oficios` (`id_recepcion`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuarios_empleados` FOREIGN KEY (`clave_area`) REFERENCES `empleados` (`clave_area`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
