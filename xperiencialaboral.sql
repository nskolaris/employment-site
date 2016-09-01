-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 01, 2016 at 11:06 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xperiencialaboral`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `avisos`
--

CREATE TABLE IF NOT EXISTS `avisos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `destacado` tinyint(1) NOT NULL DEFAULT '0',
  `permiso_id` int(11) NOT NULL DEFAULT '1',
  `puesto` text COLLATE latin1_spanish_ci NOT NULL,
  `descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `habilitado` int(11) NOT NULL DEFAULT '1',
  `created` timestamp NULL DEFAULT NULL,
  `deleted` timestamp NULL DEFAULT NULL,
  `empresa_producto_id` int(11) NOT NULL,
  `usuario_interno_id` int(11) NOT NULL,
  `aplicantes_count` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `provincia_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `tipotrabajo_id` int(11) NOT NULL,
  `sueldo_bruto` int(11) DEFAULT NULL,
  `nivel_id` int(11) NOT NULL,
  `finicio` datetime NOT NULL,
  `ffin` datetime NOT NULL,
  `extra_data` longtext COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ft_index_name` (`puesto`,`descripcion`,`extra_data`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `avisos_permisos`
--

CREATE TABLE IF NOT EXISTS `avisos_permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aviso_id` int(11) NOT NULL,
  `usuario_interno_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conocimientos_extra`
--

CREATE TABLE IF NOT EXISTS `conocimientos_extra` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `nombre` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `descripcion` text COLLATE latin1_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conocimientos_idioma`
--

CREATE TABLE IF NOT EXISTS `conocimientos_idioma` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `idioma_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_escrito_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_oral_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conoc_idio_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conocimientos_informatica`
--

CREATE TABLE IF NOT EXISTS `conocimientos_informatica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nivel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `software_id` int(10) unsigned NOT NULL DEFAULT '0',
  `descripcion` text COLLATE latin1_spanish_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conoc_inf_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conoc_actividades`
--

CREATE TABLE IF NOT EXISTS `conoc_actividades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `conoc_actividades`
--

INSERT INTO `conoc_actividades` (`id`, `denominacion`) VALUES
(1, 'actividad 1'),
(2, 'actividad 2'),
(3, 'actividad 3');

-- --------------------------------------------------------

--
-- Table structure for table `conoc_idiomas`
--

CREATE TABLE IF NOT EXISTS `conoc_idiomas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `conoc_idiomas`
--

INSERT INTO `conoc_idiomas` (`id`, `denominacion`) VALUES
(1, 'Inglés'),
(2, 'Portugües'),
(3, 'Francés'),
(4, 'Alemán'),
(5, 'Italiano'),
(6, 'Español'),
(7, 'Japonés');

-- --------------------------------------------------------

--
-- Table structure for table `conoc_niveles`
--

CREATE TABLE IF NOT EXISTS `conoc_niveles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `orden` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `conoc_niveles`
--

INSERT INTO `conoc_niveles` (`id`, `denominacion`, `orden`) VALUES
(1, 'Básico', 1),
(2, 'Intermedio', 2),
(3, 'Avanzado', 3);

-- --------------------------------------------------------

--
-- Table structure for table `conoc_nivelesidiomas`
--

CREATE TABLE IF NOT EXISTS `conoc_nivelesidiomas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `orden` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `conoc_nivelesidiomas`
--

INSERT INTO `conoc_nivelesidiomas` (`id`, `denominacion`, `orden`) VALUES
(1, 'Básico', 1),
(2, 'Intermedio', 2),
(3, 'Avanzado', 3),
(4, 'Nativo', 4);

-- --------------------------------------------------------

--
-- Table structure for table `conoc_softwares`
--

CREATE TABLE IF NOT EXISTS `conoc_softwares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `conoc_softwares`
--

INSERT INTO `conoc_softwares` (`id`, `denominacion`) VALUES
(1, 'Internet'),
(2, 'Herramientas gráficas'),
(3, 'Windows'),
(4, 'Office');

-- --------------------------------------------------------

--
-- Table structure for table `curriculumaviso_notas`
--

CREATE TABLE IF NOT EXISTS `curriculumaviso_notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculumaviso_id` int(11) NOT NULL,
  `nota` text NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_aviso`
--

CREATE TABLE IF NOT EXISTS `curriculum_aviso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aviso_id` int(11) NOT NULL DEFAULT '0',
  `usuario_id` int(11) NOT NULL DEFAULT '0',
  `preferido` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `estado` int(11) NOT NULL DEFAULT '0',
  `nuevo` tinyint(1) NOT NULL DEFAULT '1',
  `usuario_interno_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_comercial` varchar(255) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `industria_id` int(11) NOT NULL,
  `provincia_id` int(11) NOT NULL,
  `codigo_postal` varchar(255) NOT NULL,
  `rfc` varchar(255) NOT NULL,
  `calle` varchar(512) NOT NULL,
  `altura` int(11) NOT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `empresas_productos`
--

CREATE TABLE IF NOT EXISTS `empresas_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  `empresa_id` int(11) unsigned NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `usados` int(11) DEFAULT NULL,
  `finicio` date DEFAULT NULL,
  `ffin` date DEFAULT NULL,
  `importe` float DEFAULT NULL,
  `usuario_interno_comprador_id` int(11) unsigned NOT NULL,
  `fultimouso` date DEFAULT NULL,
  `fpagado` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `estadosciviles`
--

CREATE TABLE IF NOT EXISTS `estadosciviles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `estadosciviles`
--

INSERT INTO `estadosciviles` (`id`, `denominacion`) VALUES
(1, 'Soltero/a'),
(2, 'Casado/a'),
(3, 'Divorciado/a'),
(4, 'Viudo/a'),
(5, 'Pareja de hecho');

-- --------------------------------------------------------

--
-- Table structure for table `estudios`
--

CREATE TABLE IF NOT EXISTS `estudios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cant_materiasaprobadas` int(10) unsigned DEFAULT NULL,
  `cant_materiastotales` int(10) unsigned DEFAULT NULL,
  `escala_id` int(10) unsigned DEFAULT '0',
  `finicio` date DEFAULT NULL,
  `ffin` date DEFAULT NULL,
  `ffin_estimada` date DEFAULT NULL,
  `institucion_id` int(10) unsigned NOT NULL DEFAULT '0',
  `institucion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nivel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pais_id` int(10) unsigned NOT NULL DEFAULT '0',
  `promedio` varchar(8) COLLATE latin1_spanish_ci DEFAULT NULL,
  `titulo` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `est_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `estudio_areas`
--

CREATE TABLE IF NOT EXISTS `estudio_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=132 ;

--
-- Dumping data for table `estudio_areas`
--

INSERT INTO `estudio_areas` (`id`, `denominacion`) VALUES
(1, 'Abastecimiento / Compras'),
(2, 'Abogacía / Derecho / Leyes'),
(3, 'Adm. de Empresas'),
(4, 'Agricultura'),
(5, 'Agrimensor'),
(6, 'Aisladores'),
(7, 'Albañilería'),
(8, 'Andamista, soportista'),
(9, 'Antropología'),
(10, 'Armado de encofrado de hormigón armado'),
(11, 'Armado de hierro'),
(12, 'Arquitectura'),
(13, 'Bellas Artes'),
(14, 'Biología'),
(15, 'Bioquímica'),
(16, 'Calderero'),
(17, 'Cañista'),
(18, 'Carpintería de Obra'),
(19, 'Cartografía'),
(20, 'Cerrajero'),
(21, 'Ciencias de la Educación'),
(22, 'Ciencias Políticas'),
(23, 'Colocación de revestimientos plásticos'),
(24, 'Colocador de revestimiento cerámicos'),
(25, 'Colocador de Vidrios'),
(26, 'Comercial / Ventas'),
(27, 'Comercio Int./Ext.'),
(28, 'Computación / Informática'),
(29, 'Comunicación Social'),
(30, 'Contabilidad'),
(31, 'Dibujo Técnico'),
(32, 'Diseño Gráfico'),
(33, 'Economía'),
(34, 'Educación'),
(35, 'Enfermería'),
(36, 'Escribanía'),
(37, 'Estadística'),
(38, 'Filosofía'),
(39, 'Finanzas'),
(40, 'Finanzas'),
(41, 'Geofísica'),
(42, 'Geología'),
(43, 'Herrero de Obra'),
(44, 'Hotelería'),
(45, 'Ing. - otros'),
(46, 'Ing. Aerospacial'),
(47, 'Ing. Agrónomo'),
(48, 'Ing. Agropecuario'),
(49, 'Ing. Alimentos'),
(50, 'Ing. Ambiental'),
(51, 'Ing. Comercial'),
(52, 'Ing. Eléctrica'),
(53, 'Ing. Electromecánico'),
(54, 'Ing. Electrónica'),
(55, 'Ing. en Materiales'),
(56, 'Ing. en Medio Ambiente / Recursos Naturales'),
(57, 'Ing. en Minas'),
(58, 'Ing. en Sistemas'),
(59, 'Ing. Forestal'),
(60, 'Ing. Hidráulica'),
(61, 'Ing. Industrial'),
(62, 'Ing. Informática'),
(63, 'Ing. Matemática'),
(64, 'Ing. Mecánica/Metalúrgica'),
(65, 'Ing. Naval'),
(66, 'Ing. Nuclear'),
(67, 'Ing. Obras Civiles/Construcción'),
(68, 'Ing. Pesquera / Cultivos Marinos'),
(69, 'Ing. Petróleo'),
(70, 'Ing. Química'),
(71, 'Ing. Recursos Hídricos'),
(72, 'Ing. Sonido'),
(73, 'Ing. Telecomunicaciones'),
(74, 'Ing. Transporte'),
(75, 'Instalaciones domiciliarias de electricidad'),
(76, 'instalaciones domiciliarias de gas'),
(77, 'Instalaciones eléctricas de planta'),
(78, 'instalaciones sanitarias domiciliarias'),
(79, 'Instrumentista'),
(80, 'Intérprete'),
(81, 'Lectura e interpretación de planos'),
(82, 'Maestro Mayor de Obras'),
(83, 'Mantenimiento de edificios'),
(84, 'Marketing / Comercialización'),
(85, 'Medicina'),
(86, 'Medio Ambiente'),
(87, 'Montador'),
(88, 'Montador de tabiques y cielorrasos'),
(89, 'Montador electromecánico'),
(90, 'Montaje industrial'),
(91, 'Operación de maquinaria vial'),
(92, 'Organización Industrial'),
(93, 'Otra'),
(94, 'Paisajismo'),
(95, 'Periodismo'),
(96, 'Perito Mercantil'),
(97, 'Pintura de Obra'),
(98, 'Procesos / Calidad Total'),
(99, 'Producción de ladrillos de suelo cemento'),
(100, 'Psicología'),
(101, 'Psicopedagogía'),
(102, 'Publicidad'),
(103, 'Química'),
(104, 'Recursos Humanos / Relac. Ind. / Rlac. Labor.'),
(105, 'Relaciones Públicas'),
(106, 'Secretariado'),
(107, 'Seguridad Industrial'),
(108, 'Seguros'),
(109, 'Sistemas'),
(110, 'Sociología'),
(111, 'Soldadura de Argón'),
(112, 'Soldadura por arcos'),
(113, 'Soldadura de Cañerías'),
(114, 'Soldadura por arco sumergido'),
(115, 'Techista'),
(116, 'Técnico Automotores'),
(117, 'Técnico Construcciones'),
(118, 'Técnico Electricista'),
(119, 'Técnico Electromecánico'),
(120, 'Técnico Electrónico'),
(121, 'Técnico Informática'),
(122, 'Técnico Mecánico'),
(123, 'Técnico Minero'),
(124, 'Técnico Petróleo'),
(125, 'Técnico Químico'),
(126, 'Técnico Salud'),
(127, 'Técnico Seguridad e Higiene'),
(128, 'Terminaciones de carpintería'),
(129, 'Topografía'),
(130, 'Traducción'),
(131, 'Zinguería');

-- --------------------------------------------------------

--
-- Table structure for table `estudio_escalas`
--

CREATE TABLE IF NOT EXISTS `estudio_escalas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `estudio_escalas`
--

INSERT INTO `estudio_escalas` (`id`, `denominacion`) VALUES
(1, '1 - 10'),
(2, 'A - D');

-- --------------------------------------------------------

--
-- Table structure for table `estudio_instituciones`
--

CREATE TABLE IF NOT EXISTS `estudio_instituciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pais_id` int(10) unsigned NOT NULL DEFAULT '0',
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1315 ;

--
-- Dumping data for table `estudio_instituciones`
--

INSERT INTO `estudio_instituciones` (`id`, `pais_id`, `denominacion`) VALUES
(1, 1, 'UADE'),
(2, 1, 'Universidad Austral'),
(3, 1, 'Universidad Catolica de Cordoba'),
(4, 1, 'Universidad de Belgrano'),
(5, 1, 'Universidad de Buenos Aires'),
(6, 1, 'Universidad del Salvador'),
(7, 1, 'Universidad Nacional de Catamarca'),
(8, 1, 'Universidad Nacional de Cordoba'),
(9, 1, 'Universidad Nacional de Entre Rios'),
(10, 1, 'Universidad Nacional de La Plata'),
(11, 1, 'Universidad Nacional de Lomas de Zamora'),
(12, 1, 'Universidad Nacional de Lujan'),
(13, 1, 'Universidad Nacional de Mar del Plata'),
(14, 1, 'Universidad Nacional de Rio Cuarto'),
(15, 1, 'Universidad Nacional de Rosario'),
(16, 1, 'Universidad Nacional de San Juan'),
(17, 1, 'Universidad Nacional de San Luis'),
(18, 1, 'Universidad Nacional de Tucuman'),
(19, 1, 'Universidad Nacional del Comahue'),
(20, 1, 'Universidad Nacional del Litoral'),
(21, 1, 'Universidad Nacional del Sur'),
(22, 1, 'Universidad de La Matanza'),
(23, 1, 'UCEL'),
(24, 2, 'UNICEN'),
(25, 1, 'Universidad Catolica Argentina'),
(26, 1, 'Universidad de Congreso'),
(27, 1, 'Universidad de Palermo'),
(28, 1, 'Universidad de San Andres'),
(29, 1, 'Universidad Nacional de Cuyo'),
(30, 1, 'Universidad Nacional de Misiones'),
(31, 1, 'Universidad Nacional de Quilmes'),
(32, 1, 'Universidad Nacional de Villa Maria'),
(33, 1, 'Universidad Nacional del Nordeste'),
(34, 1, 'Universidad Virtual de Quilmes'),
(35, 1, 'C.E.M.A.'),
(36, 1, 'I.D.E.A.'),
(37, 1, 'U.T.D.T.'),
(38, 1, 'I.A.E.'),
(39, 1, 'I.T.B.A.'),
(40, 1, 'U.C.E.S.'),
(41, 24, 'Babson College'),
(42, 24, 'Columbia Business School'),
(43, 24, 'Harvard Business School'),
(44, 24, 'J.L.Kellog Graduate School of Management'),
(45, 24, 'The Amos Tuck School of Business'),
(46, 24, 'University of California at Berkeley'),
(47, 24, 'University of Illinois'),
(48, 24, 'University of Maryland'),
(49, 24, 'Wharton School of Business'),
(50, 24, 'University of Pennsylvania'),
(51, 2, 'Universidade Federal do Parana'),
(52, 2, 'Universidade Federal de Santa Catarina'),
(53, 2, 'Universidade Catolica de Brasilia'),
(54, 2, 'Universidade Catolica de Pernambuco'),
(55, 2, 'Universidade de Brasilia'),
(56, 2, 'Universidade Estadual Paulista'),
(57, 2, 'Universidade Federal de Santa Maria'),
(58, 2, 'Universidade Federal do Ceara'),
(59, 8, 'Universidad Antonio Narino'),
(60, 8, 'Universidad Nacional de Colombia'),
(61, 8, 'Universidad Pontificia Bolivariana'),
(62, 8, 'Universidad de Antioquia'),
(63, 8, 'Universidad de los Andes'),
(64, 23, 'Augustana University College'),
(65, 23, 'Brandon University'),
(66, 23, 'Brock University'),
(67, 23, 'Carleton University'),
(68, 23, 'Concordia University'),
(69, 23, 'Dalhousie University'),
(70, 23, 'Leakhead University'),
(71, 23, 'Lakeland College'),
(72, 23, 'Laurentian University'),
(73, 23, 'McGill University'),
(74, 23, 'McMaster University'),
(75, 23, 'Memorial University of Newfoundland'),
(76, 23, 'Mount Allison University'),
(77, 23, 'Queens University at Kingston'),
(78, 23, 'Royal Roads University'),
(79, 23, 'Saint Marys University'),
(80, 23, 'Simon Fraser University'),
(81, 23, 'St. Francis Xavier University'),
(82, 23, 'St. Thomas University'),
(83, 23, 'Technical University of Nova Scotia'),
(84, 23, 'Trent University'),
(85, 23, 'Trinity Western University'),
(86, 23, 'University of Alberta'),
(87, 23, 'University of British Columbia'),
(88, 23, 'University of Guelph'),
(89, 23, 'University of Kings College'),
(90, 23, 'Université de Montréal'),
(91, 23, 'University of New Brunswick'),
(92, 23, 'University of Northern British Columbia'),
(93, 23, 'University of Ottawa'),
(94, 23, 'University of Prince Edward Island'),
(95, 23, 'University of Regina'),
(96, 23, 'University of Saskatchewan'),
(97, 23, 'University of Toronto'),
(98, 23, 'University of Waterloo'),
(99, 23, 'University of Winnipeg'),
(100, 23, 'York University'),
(101, 23, 'Assumption University'),
(102, 23, 'Bishops University'),
(103, 23, 'British Columbia Institute of Technology'),
(104, 23, 'Laval University'),
(105, 23, 'Malaspina University-College'),
(106, 23, 'Mount Saint Vincent University'),
(107, 23, 'Nipissing University'),
(108, 23, 'Okanagan University College'),
(109, 23, 'Technical University of British Columbia'),
(110, 23, 'Télé-université'),
(111, 23, 'Université de Sherbrooke'),
(112, 23, 'Université du Québec'),
(113, 23, 'Université du Québec à Chicoutimi'),
(114, 23, 'Université du Québec à Montréal'),
(115, 23, 'Université du Québec en Abitibi-Témiscamingue'),
(116, 23, 'Université Laval'),
(117, 23, 'University of Manitoba'),
(118, 23, 'Université de Moncton'),
(119, 23, 'University of St. Jeromes College'),
(120, 23, 'University of Victoria'),
(121, 23, 'University of Windsor'),
(122, 7, 'U. del Bío Bío'),
(123, 7, 'U. Diego Portales'),
(124, 7, 'U. de la Frontera'),
(125, 7, 'U. Adolfo Ibáñez'),
(126, 7, 'U. Arturo Prat'),
(127, 7, 'U. Austral'),
(128, 7, 'U. Católica de Valparaíso'),
(129, 7, 'U. Católica del Norte'),
(130, 7, 'U. Central'),
(131, 7, 'U. de Antofagasta'),
(132, 7, 'U. de Atacama'),
(133, 7, 'U. de Chile'),
(134, 7, 'U. de Concepción'),
(135, 7, 'U. de la Serena'),
(136, 7, 'U. de Los Lagos'),
(137, 7, 'U. de Magallanes'),
(138, 7, 'U. de Santiago de Chile'),
(139, 7, 'U. de Tarapacá'),
(140, 7, 'U. de Viña del Mar'),
(141, 7, 'U. del Pacífico'),
(142, 7, 'U. Metropolitana de Ciencias de la Educación'),
(143, 7, 'Pontificia Universidad Católica de Chile'),
(144, 7, 'U. Católica de Temuco'),
(145, 7, 'U. de Ciencias de la Informática'),
(146, 7, 'U. de Playa Ancha'),
(147, 7, 'U. de Valparaíso'),
(148, 18, 'ITESM'),
(149, 18, 'Universidad Autonoma de Aguascalientes'),
(150, 18, 'Universidad Autonoma de Baja California Norte'),
(151, 18, 'Universidad Autonoma de Baja California Sur'),
(152, 18, 'Universidad Autonoma de Chihuahua'),
(153, 18, 'Universidad Autonoma de Guadalajara'),
(154, 18, 'Universidad Autonoma de Nayarit'),
(155, 18, 'Universidad Autonoma de Nuevo Leon'),
(156, 18, 'Universidad Autonoma de Yucatan'),
(157, 18, 'Universidad Autonoma de Zacatecas'),
(158, 18, 'Universidad Autonoma del Carmen'),
(159, 18, 'Universidad Autonoma del Estado de Mexico'),
(160, 18, 'Universidad de Colima'),
(161, 18, 'Universidad de Guadalajara'),
(162, 18, 'Universidad del Noreste'),
(163, 18, 'Universidad Iberoamericana'),
(164, 18, 'Universidad Intercontinental'),
(165, 18, 'Universidad Jose Vasconcelos de Oaxaca'),
(166, 18, 'Universidad Juarez Autonoma de Tabasco'),
(167, 18, 'Universidad Justo Sierra'),
(168, 18, 'Universidad Nacional Autonoma de Mexico'),
(169, 18, 'Universidad Olmeca'),
(170, 18, 'Universidad Veracruzana'),
(171, 18, 'UAEM'),
(172, 18, 'Universidad Autonoma Metropolitana'),
(173, 18, 'Universidad de Guanajuato'),
(174, 18, 'Universidad de las Americas'),
(175, 18, 'Universidad de Monterrey'),
(176, 18, 'Universidad del Mar'),
(177, 18, 'Universidad Virtual'),
(178, 1, 'Universidad Tecnologica Nacional'),
(179, 24, 'California Institute of Technology'),
(180, 24, 'Harvard University (MA)'),
(181, 24, 'Massachusetts Inst. of Technology'),
(182, 24, 'Princeton University (NJ)'),
(183, 24, 'Yale University (CT)'),
(184, 24, 'Stanford University (CA)'),
(185, 24, 'Duke University (NC)'),
(186, 24, 'Johns Hopkins University (MD)'),
(187, 24, 'Columbia University (NY)'),
(188, 24, 'Cornell University (NY)'),
(189, 24, 'Dartmouth College (NH)'),
(190, 24, 'University of Chicago'),
(191, 24, 'Brown University (RI)'),
(192, 24, 'Northwestern University (IL)'),
(193, 24, 'Rice University (TX)'),
(194, 24, 'Washington University (MO)'),
(195, 24, 'Emory University (GA)'),
(196, 24, 'University of Notre Dame (IN)'),
(197, 24, 'University of California Berkeley'),
(198, 24, 'Vanderbilt University (TN)'),
(199, 24, 'University of Virginia'),
(200, 24, 'Carnegie Mellon University (PA)'),
(201, 24, 'Georgetown University (DC)'),
(202, 24, 'University of California Los Angeles'),
(203, 24, 'University of Michigan Ann Arbor'),
(204, 24, 'Univ. of North Carolina Chapel Hill'),
(205, 24, 'Wake Forest University (NC)'),
(206, 24, 'College of William and Mary (VA)'),
(207, 24, 'Tufts University (MA)'),
(208, 24, 'Brandeis University (MA)'),
(209, 24, 'University of California San Diego'),
(210, 24, 'University of Rochester (NY)'),
(211, 24, 'Case Western Reserve Univ. (OH)'),
(212, 24, 'Lehigh University (PA)'),
(213, 24, 'New York University'),
(214, 24, 'Univ. of Illinois Urbana-Champaign'),
(215, 24, 'University of Wisconsin Madison'),
(216, 24, 'Boston College'),
(217, 24, 'Georgia Institute of Technology'),
(218, 24, 'University of California Davis'),
(219, 24, 'University of Southern California'),
(220, 24, 'Tulane University (LA)'),
(221, 24, 'Univ. of California Santa Barbara'),
(222, 24, 'University of Texas Austin'),
(223, 24, 'University of Washington'),
(224, 24, 'Yeshiva University (NY)'),
(225, 24, 'University of California Irvine'),
(226, 24, 'University of Florida'),
(227, 24, 'American University (DC)'),
(228, 24, 'Auburn University (AL)'),
(229, 24, 'Baylor University (TX)'),
(230, 24, 'Boston University'),
(231, 24, 'Brigham Young Univ. Provo (UT)'),
(232, 24, 'Catholic University of America (DC)'),
(233, 24, 'Clarkson University (NY)'),
(234, 24, 'Clark University (MA)'),
(235, 24, 'Clemson University (SC)'),
(236, 24, 'Colorado School of Mines'),
(237, 24, 'Colorado State University'),
(238, 24, 'Duquesne University (PA)'),
(239, 24, 'Florida State University'),
(240, 24, 'Fordham University (NY)'),
(241, 24, 'George Washington University (DC)'),
(242, 24, 'Illinois Institute of Technology'),
(243, 24, 'Indiana University Bloomington'),
(244, 24, 'Iowa State University'),
(245, 24, 'Loyola University Chicago'),
(246, 24, 'Marquette University (WI)'),
(247, 24, 'Miami University Oxford (OH)'),
(248, 24, 'Michigan State University'),
(249, 24, 'Michigan Technological University'),
(250, 24, 'North Carolina State U. Raleigh'),
(251, 24, 'Ohio State University Columbus'),
(252, 24, 'Ohio University'),
(253, 24, 'Pepperdine University (CA)'),
(254, 24, 'Purdue Univ. West Lafayette (IN)'),
(255, 24, 'Rensselaer Polytechnic Inst. (NY)'),
(256, 24, 'Rutgers Newark (NJ)'),
(257, 24, 'Rutgers New Brunswick (NJ)'),
(258, 24, 'Southern Methodist University (TX)'),
(259, 24, 'Stevens Institute of Technology (NJ)'),
(260, 24, 'St. Louis University'),
(261, 24, 'SUNY Albany'),
(262, 24, 'SUNY Binghamton'),
(263, 24, 'SUNY Buffalo'),
(264, 24, 'SUNY Stony Brook'),
(265, 24, 'Syracuse University (NY)'),
(266, 24, 'Texas A&M Univ. College Station'),
(267, 24, 'Texas Christian University'),
(268, 24, 'University of Alabama'),
(269, 24, 'University of Arizona'),
(270, 24, 'Univ. of California Riverside'),
(271, 24, 'Univ. of California Santa Cruz'),
(272, 24, 'University of Colorado Boulder'),
(273, 24, 'University of Connecticut'),
(274, 24, 'University of Delaware'),
(275, 24, 'University of Denver'),
(276, 24, 'University of Georgia'),
(277, 24, 'University of Iowa'),
(278, 24, 'University of Kansas'),
(279, 24, 'University of Kentucky'),
(280, 24, 'Univ. of Maryland College Park'),
(281, 24, 'Univ. of Massachusetts Amherst'),
(282, 24, 'University of Miami (FL)'),
(283, 24, 'Univ. of Minnesota Twin Cities'),
(284, 24, 'Univ. of Missouri Columbia'),
(285, 24, 'University of Missouri Rolla'),
(286, 24, 'Univ. of Nebraska Lincoln'),
(287, 24, 'University of New Hampshire'),
(288, 24, 'University of Oregon'),
(289, 24, 'University of Pittsburgh'),
(290, 24, 'University of San Diego'),
(291, 24, 'Univ. of South Carolina Columbia'),
(292, 24, 'Univ. of Tennessee Knoxville'),
(293, 24, 'University of Vermont'),
(294, 24, 'Virginia Tech'),
(295, 24, 'Washington State University'),
(296, 24, 'Worcester Polytechnic Inst. (MA)'),
(297, 1, 'AAAP'),
(298, 18, 'Universidad ICEL'),
(299, 1, 'Universidad Nacional de General Sarmiento'),
(300, 13, 'Universidad del Tachira'),
(301, 1, 'Universidad Nacional de Tres de Febrero'),
(302, 10, 'Universidad Nacional'),
(303, 10, 'Universidad Catolica'),
(304, 12, 'Red Acadamica Uruguaya'),
(305, 12, 'Universidad Catolica del Uruguay'),
(306, 12, 'Universidad de Uruguay'),
(307, 12, 'Universidad ORT'),
(308, 32, 'Lincoln University'),
(309, 32, 'Liverpool John Moores University'),
(310, 32, 'London Guildhall University'),
(311, 32, 'Loughborough University'),
(312, 32, 'Manchester Metropolitan University'),
(313, 32, 'Middlesex University'),
(314, 32, 'Nottingham Trent University'),
(315, 32, 'Open University'),
(316, 32, 'Oxford Brookes University'),
(317, 32, 'Oxford University'),
(318, 32, 'Richmond University'),
(319, 32, 'Sheffield Hallam University'),
(320, 32, 'South Bank University'),
(321, 32, 'Staffordshire University'),
(322, 32, 'Sussex University'),
(323, 32, 'Thames Valley University'),
(324, 32, 'UMIST'),
(325, 32, 'University of Bath'),
(326, 32, 'University of Birmingham'),
(327, 32, 'University of Bradford'),
(328, 32, 'University of Brighton'),
(329, 32, 'University of Bristol'),
(330, 32, 'University of Buckingham'),
(331, 32, 'University of Cambridge'),
(332, 32, 'University of Central England'),
(333, 32, 'University of Central Lancashire'),
(334, 32, 'University of Derby'),
(335, 32, 'University of Durham'),
(336, 32, 'University of East Anglia'),
(337, 32, 'University of East London'),
(338, 32, 'University of Essex'),
(339, 32, 'University of Exeter'),
(340, 32, 'University of Greenwich'),
(341, 32, 'University of Hertfordshire'),
(342, 32, 'University of Huddersfield'),
(343, 32, 'University of Hull'),
(344, 32, 'University of Kent at Canterbury'),
(345, 32, 'University of Leicester'),
(346, 32, 'University of Liverpool'),
(347, 32, 'University of Luton'),
(348, 32, 'University of Manchester'),
(349, 32, 'University of Newcastle upon Tyne'),
(350, 32, 'University of North London'),
(351, 32, 'University of Northumbria'),
(352, 32, 'University of Nottingham'),
(353, 32, 'University of Plymouth'),
(354, 32, 'University of Portsmouth'),
(355, 32, 'University of Reading'),
(356, 32, 'University of Salford'),
(357, 32, 'University of Sheffield'),
(358, 32, 'University of Southampton'),
(359, 32, 'University of Sunderland'),
(360, 32, 'University of Surrey'),
(361, 32, 'University of Teesside'),
(362, 32, 'University of Warwick'),
(363, 32, 'University of West England'),
(364, 32, 'University of Westminster'),
(365, 32, 'University of Wolverhampton'),
(366, 32, 'University of York'),
(367, 32, 'University of Ulster'),
(368, 32, 'Glasgow Caledonian University'),
(369, 32, 'Heriot-Watt University'),
(370, 32, 'Napier University'),
(371, 32, 'Robert Gordon University'),
(372, 32, 'University of Aberdeen'),
(373, 32, 'University of Abertay Dundee'),
(374, 32, 'University of Dundee'),
(375, 32, 'University of Edinburgh'),
(376, 32, 'University of Glasgow'),
(377, 32, 'University of Paisley'),
(378, 32, 'University of St Andrews'),
(379, 32, 'University of Stirling'),
(380, 32, 'University of Strathclyde'),
(381, 32, 'Athrofa Prifysgol Cymru, Caerdydd'),
(382, 32, 'University of Glamorgan'),
(383, 32, 'University of Wales'),
(384, 32, 'University of Wales College'),
(385, 36, 'HSG - Universität St. Gallen'),
(386, 36, 'Università della Svizzera Italiana'),
(387, 36, 'Universitäre Hochschule Luzern'),
(388, 36, 'Universität Basel'),
(389, 36, 'Universität Bern'),
(390, 36, 'Universität Freiburg'),
(391, 36, 'Universität Zürich'),
(392, 36, 'Université de Genève'),
(393, 36, 'Université de Lausanne'),
(394, 36, 'Université de Neuchâtel'),
(395, 21, 'Euskal Herriko Unibertsitatea'),
(396, 21, 'Universidad Alfonso X'),
(397, 21, 'Universidad Antonio de Nebrija'),
(398, 21, 'Universidad Autonoma de Madrid'),
(399, 21, 'Universidad Británica en España'),
(400, 21, 'Universidad Carlos III de Madrid'),
(401, 21, 'Universidad Católica de Ávila'),
(402, 21, 'Universidad Complutense de Madrid'),
(403, 21, 'Universidad de Alicante'),
(404, 21, 'Universidad de Almeria'),
(405, 21, 'Universidad de Burgos'),
(406, 21, 'Universidad de Cadiz'),
(407, 21, 'Universidad de Cantabria'),
(408, 21, 'Universidad de Castilla-La Mancha'),
(409, 21, 'Universidad de Cordoba'),
(410, 21, 'Universidad de Extremadura'),
(411, 21, 'Universidad de Granada'),
(412, 21, 'Universidad de Huelva'),
(413, 21, 'Universidad de Jaén'),
(414, 21, 'Universidad de La Laguna'),
(415, 21, 'Universidad de La Rioja'),
(416, 21, 'U. de Las Palmas de Gran Canaria'),
(417, 21, 'Universidad de Malaga'),
(418, 21, 'Universidad de Murcia'),
(419, 21, 'Universidad de Navarra'),
(420, 21, 'Universidad de Oviedo'),
(421, 21, 'Universidad de Salamanca'),
(422, 21, 'Universidad de Sevilla'),
(423, 21, 'Universidad de Valladolid'),
(424, 21, 'Universidad de Zaragoza'),
(425, 21, 'Universidad Europea de Madrid'),
(426, 21, 'Universidad Miguel Hernández'),
(427, 21, 'Universidad Nacional de Educacion a Distancia'),
(428, 21, 'Universidad Publica de Navarra'),
(429, 21, 'Universidad Rey Juan Carlos'),
(430, 21, 'Universidad San Pablo'),
(431, 21, 'Universidade da Coruña'),
(432, 21, 'Universidade de Santiago'),
(433, 21, 'Universitat Autonoma de Barcelona'),
(434, 21, 'Universitat de Barcelona'),
(435, 21, 'Universitat de Girona'),
(436, 21, 'Universitat de les Illes Balears'),
(437, 21, 'Universitat de Lleida'),
(438, 21, 'Universitat Internacional de Catalunya'),
(439, 21, 'Universitat Jaume I'),
(440, 21, 'Universitat Obierta de Cataluniya'),
(441, 21, 'Universitat Pompeu Fabra'),
(442, 21, 'Universitat Rovira i Virgili'),
(443, 21, 'Universitat Ramon Llull'),
(444, 25, 'American University of Paris'),
(445, 25, 'Université de Bordeaux'),
(446, 25, 'Université de Bourgogne'),
(447, 25, 'Université de Bretagne Occidentale'),
(448, 25, 'Université de Caen Basse-Normandie'),
(449, 25, 'Université de Cergy-Pontoise'),
(450, 25, 'Université de Clermont-Ferrand'),
(451, 25, 'Université de Franche-Comté'),
(452, 25, 'Université de Haute-Alsace'),
(453, 25, 'Université de Lille'),
(454, 25, 'Université de Limoges'),
(455, 25, 'Université de Lyon'),
(456, 25, 'Université de Marne-la-Vallée'),
(457, 25, 'Université de Metz'),
(458, 25, 'Université de Montpellier'),
(459, 25, 'Université de Nice'),
(460, 25, 'Université de Paris'),
(461, 25, 'Université de Pau'),
(462, 25, 'Université de Perpignan'),
(463, 25, 'Université de Picardie Jules Verne'),
(464, 25, 'Université de Poitiers'),
(465, 25, 'Université de Reims'),
(466, 25, 'Université de Rennes'),
(467, 25, 'Université de Saint-Etienne'),
(468, 25, 'Université de Savoie'),
(469, 25, 'Université de Strasbourg'),
(470, 25, 'Université de Toulon-Var'),
(471, 25, 'Université de Toulouse'),
(472, 25, 'Université de Tours'),
(473, 25, 'Université de Valenciennes'),
(474, 25, 'Université de Versailles'),
(475, 25, 'Université du Havre'),
(476, 25, 'Université du Maine'),
(477, 25, 'Université Grenoble'),
(478, 25, 'Université Lille'),
(479, 25, 'Université Michel de Montaigne'),
(480, 25, 'Université Montesquieu'),
(481, 25, 'Université Nancy'),
(482, 25, 'Université Strasbourg II'),
(483, 25, 'Université Virtuelle Ridelloise'),
(484, 25, 'Universite d''Aix-Marseille'),
(485, 25, 'Universite d''Angers'),
(486, 25, 'Universite d''Angers'),
(487, 25, 'Universite d''Avignon'),
(488, 25, 'Universite d''Orleans'),
(489, 1, 'CAECE'),
(490, 1, 'INST. SAN PIO X'),
(491, 1, 'Universidad de Morón'),
(492, 18, 'Universidad Anáhuac'),
(493, 1, 'UCA de Rosario'),
(494, 1, 'Austral de Rosario'),
(495, 1, 'Universidad Blas Pascal'),
(496, 1, 'UESIGLO 21'),
(497, 1, 'Universidad Católica de Mendoza'),
(498, 1, 'Universidad de Aconcagua'),
(499, 24, 'Thunderbird School of Intl Management'),
(500, 1, 'U.A.I'),
(501, 18, 'Universidad Panamericana'),
(502, 2, 'Associação Franciscana de Ensino Senhor Bom Jesus'),
(503, 2, 'Centro Regional Universitário - Creupi'),
(504, 2, 'Centro Universitário da Grande Dourados - Unigran'),
(505, 2, 'Centro Universitário Ibero-Americano - Unibero'),
(506, 2, 'Centro Universitário Moacyr Sreder Bastos'),
(507, 2, 'Centro Universitário Monte Serrat - Unimonte'),
(508, 2, 'Centro Universitário Positivo - UnicenP'),
(509, 2, 'Ensino Superior de Olinda - Aeso'),
(510, 2, 'Faculdade Anhanguera de Ciências Humanas - Fach'),
(511, 2, 'Faculdade de Agudos - Faag.'),
(512, 2, 'Faculdade de Belas Artes de São Paulo'),
(513, 2, 'Faculdade de Direito do Oeste de Minas - Fadom'),
(514, 2, 'Faculdades Associadas de São Paulo - FASP'),
(515, 2, 'Faculdades COC'),
(516, 2, 'Faculdades Integradas de Jacarepaguá - FIJ'),
(517, 2, 'Faculdades Metropolitanas Unidas - FMU'),
(518, 2, 'Faculdades Planalto'),
(519, 2, 'Faculdades Tancredo Neves'),
(520, 2, 'Fundação Armando Álvares Penteado - Faap'),
(521, 2, 'Fundação Educacional de Barretos'),
(522, 2, 'Fundação Educacional Dom André Arcoverde'),
(523, 2, 'Fundação Eurípides Soares da Rocha'),
(524, 2, 'Fundação Getúlio Vargas - FGV'),
(525, 2, 'Fundação Gildasio Amado'),
(526, 2, 'Fundação Universidade Federal do Rio Grande - Furg'),
(527, 2, 'Instituição Toledo de Ensino - ITE'),
(528, 2, 'Instituto Adventista de Ensino'),
(529, 2, 'Instituto Batista de Educação Religiosa'),
(530, 2, 'Instituto Filadélfia de Londrina'),
(531, 2, 'Instituto Mauá de Tecnologia - IMT'),
(532, 2, 'Institutos Paraibanos de Educação'),
(533, 2, 'Pontifícia Universidade Católica - PUC-Campinas'),
(534, 2, 'Pontifícia Universidade Católica do Paraná - PUC'),
(535, 2, 'Unibahia'),
(536, 2, 'Uniderp UniverCidade'),
(537, 2, 'Universidade Anhembi-Morumbi'),
(538, 2, 'Universidade Bandeirante de São Paulo - Uniban'),
(539, 2, 'Universidade Braz Cubas - UBC'),
(540, 2, 'Universidade Castelo Branco - UCB'),
(541, 2, 'Universidade Católica de Brasília - UCB'),
(542, 2, 'Universidade Católica de Goiás - UCG'),
(543, 2, 'Universidade Católica de Pelotas - UCPEL'),
(544, 2, 'Universidade Católica de Pernambuco - Unicap'),
(545, 2, 'Universidade Católica de Salvador - UCSal'),
(546, 2, 'Universidade Católica de Santos - UniSantos'),
(547, 2, 'Universidade Católica Dom Bosco'),
(548, 2, 'Universidade Católica Petrópolis'),
(549, 2, 'Universidade Cidade de São Paulo - Unicid'),
(550, 2, 'Universidade Cruzeiro do Sul - Unicsul'),
(551, 2, 'Universidade da Amazônia - Unama'),
(552, 2, 'Universidade da Região da Campanha -'),
(553, 2, 'Universidade de Alfenas - Unifenas'),
(554, 2, 'Universidade de Brasília - UnB'),
(555, 2, 'Universidade de Cruz Alta - RS -'),
(556, 2, 'Universidade de Cuiabá - UNIC'),
(557, 2, 'Universidade de Franca'),
(558, 2, 'Universidade de Marília - Unimar'),
(559, 2, 'Universidade de Passo Fundo - UPF'),
(560, 2, 'Universidade de Pernambuco - UPE'),
(561, 2, 'Universidade de Santa Cruz do Sul'),
(562, 2, 'Universidade de Santo Amaro - Unisa'),
(563, 2, 'Universidade de São Paulo - USP'),
(564, 2, 'Universidade de Sorocaba'),
(565, 2, 'Universidade do Amazonas'),
(566, 2, 'Universidade do Estado de Santa Catarina - Udesc'),
(567, 2, 'Universidade do Estado do Rio de Janeiro - Uerj'),
(568, 2, 'Universidade do Extremo Sul Catarinense - Unesc'),
(569, 2, 'Universidade do Grande Rio'),
(570, 2, 'Universidade do Oeste de Santa Catarina - Unoesc'),
(571, 2, 'Universidade do Oeste Paulista'),
(572, 2, 'Universidade do Rio de Janeiro - Unirio'),
(573, 2, 'Universidade do Sagrado Coração - USC'),
(574, 2, 'Universidade do Sul de Santa Catarina - Unisul'),
(575, 2, 'Universidade do Vale do Itajaí - Univali'),
(576, 2, 'Universidade do Vale do Paraiba - Univap'),
(577, 2, 'Universidade do Vale do Rio dos Sinos - Unisinos'),
(578, 2, 'Universidade Eduardo Mondlane - Moçambique'),
(579, 2, 'Universidade Estácio de Sá'),
(580, 2, 'Universidade Estadual de Anápolis - Uniana'),
(581, 2, 'Universidade Estadual de Campinas - Unicamp'),
(582, 2, 'Universidade Estadual de Feira de Santana - UEFS'),
(583, 2, 'Universidade Estadual de Londrina'),
(584, 2, 'Universidade Estadual de Maringá - UEM'),
(585, 2, 'Universidade Estadual de Mato Grosso do Sul - UEMS'),
(586, 2, 'Universidade Estadual de Minas Gerais - UEMG'),
(587, 2, 'Universidade Estadual de Montes Claros'),
(588, 2, 'Universidade Estadual de Ponta Grossa'),
(589, 2, 'Universidade Estadual de Santa Cruz - UESC'),
(590, 2, 'Universidade Estadual do Ceará - UECE'),
(591, 2, 'Universidade Estadual do Norte Fluminense'),
(592, 2, 'Universidade Estadual do Sudoeste da Bahia'),
(593, 2, 'Universidade Estadual Paulista - Unesp'),
(594, 2, 'Universidade Federal da Bahia - UFBA'),
(595, 2, 'Universidade Federal da Paraíba - UFPB'),
(596, 2, 'Universidade Federal de Alagoas'),
(597, 2, 'Universidade Federal de Goiás - UFG'),
(598, 2, 'Universidade Federal de Juiz de Fora - UFJF'),
(599, 2, 'Universidade Federal de Lavras - UFLA'),
(600, 2, 'Universidade Federal de Mato Grosso - UFMT'),
(601, 2, 'Universidade Federal de Mato Grosso do Sul'),
(602, 2, 'Universidade Federal de Minas Gerais - UFMG'),
(603, 2, 'Universidade Federal de Ouro Preto - Ufop'),
(604, 2, 'Universidade Federal de Pelotas'),
(605, 2, 'Universidade Federal de Pernambuco - UFPE'),
(606, 2, 'Universidade Federal de Rondônia'),
(607, 2, 'Universidade Federal de Santa Catarina - UFSC'),
(608, 2, 'Universidade Federal de Santa Maria - UFSM'),
(609, 2, 'Universidade Federal de São Carlos - Ufscar'),
(610, 2, 'Universidade Federal de São Paulo - Unifesp'),
(611, 2, 'Universidade Federal de Sergipe - UFS'),
(612, 2, 'Universidade Federal de Uberlândia - UFU'),
(613, 2, 'Universidade Federal de Viçosa - UFV'),
(614, 2, 'Universidade Federal do Acre - Ufac'),
(615, 2, 'Universidade Federal do Ceará - UFC'),
(616, 2, 'Universidade Federal do Espírito Santo - Ufes'),
(617, 2, 'Universidade Federal do Maranhão - UFM'),
(618, 2, 'Universidade Federal do Pará - UFPA'),
(619, 2, 'Universidade Federal do Paraná - UFPR'),
(620, 2, 'Universidade Federal do Piauí - UFPI'),
(621, 2, 'Universidade Federal do Rio de Janeiro - UFRJ'),
(622, 2, 'Universidade Federal do Rio Grande do Norte - UFRN'),
(623, 2, 'Universidade Federal do Rio Grande do Sul - UFRGS'),
(624, 2, 'Universidade Federal Fluminense - UFF'),
(625, 2, 'Universidade Federal Rural de Pernambuco'),
(626, 2, 'Universidade Gama Filho - UGF'),
(627, 2, 'Universidade Guarulhos - UnG'),
(628, 2, 'Universidade Ibirapuera - Unib'),
(629, 2, 'Universidade Iguaçu'),
(630, 2, 'Universidade Luterana do Brasil - Ulbra'),
(631, 2, 'Universidade Metodista de Piracicaba - Unimep'),
(632, 2, 'Universidade Metodista de São Paulo - Umesp'),
(633, 2, 'Universidade Norte do Paraná - Unopar'),
(634, 2, 'Universidade Paranaense - Unipar'),
(635, 2, 'Universidade Paulista - UNIP'),
(636, 2, 'Universidade Potiguar - UnP'),
(637, 2, 'Universidade Presidente Antônio Carlos - Unipac'),
(638, 2, 'Universidade Regional de Blumenau - Furb'),
(639, 2, 'Universidade Regional do Cariri - Urca'),
(640, 2, 'Universidade Ribeirão Preto - Unaerp'),
(641, 2, 'Universidade Salgado de Oliveira - Universo'),
(642, 2, 'Universidade Salvador - Unifacs'),
(643, 2, 'Universidade Santa Cecília - Unisanta'),
(644, 2, 'Universidade Santa Úrsula'),
(645, 2, 'Universidade São Francisco'),
(646, 2, 'Universidade São Judas Tadeu'),
(647, 2, 'Universidade São Marcos'),
(648, 2, 'Universidade Tiradentes'),
(649, 2, 'Universidade Vale do Rio Doce - Univale'),
(650, 2, 'Universidade Veiga de Almeida Univille'),
(651, 2, 'Escola Superior de Propaganda e Marketing - ESPM SP'),
(652, 2, 'Escola Superior de Propaganda e Marketing - ESPM RJ'),
(653, 2, 'Escola Superior de Propaganda e Marketing - ESPM RS'),
(654, 2, 'Pontifícia Universidade Católica - PUC SP'),
(655, 2, 'Pontifícia Universidade Católica - PUC RJ'),
(656, 2, 'Pontifícia Universidade Católica - PUC RS'),
(657, 2, 'Instituto de Tecnologia e Aeronáutica - ITA S.J. dos Campos'),
(658, 2, 'Ibmec São Paulo'),
(659, 18, 'ITESO'),
(660, 18, 'IPADE'),
(661, 18, 'UNITEC'),
(662, 18, 'ITAM'),
(663, 13, 'C.U. de Administración y Mercadeo'),
(664, 13, 'C.U. de Caracas'),
(665, 13, 'C.U. de Enfermería Ctro Médico Caracas'),
(666, 13, 'C.U. de Enfermería de la Gob del D.F.'),
(667, 13, 'C.U. de Enfermería, Cruz Roja de Vzla.'),
(668, 13, 'C.U. de Los Teques Cecilio Acosta'),
(669, 13, 'C.U. de Psicopedagogía'),
(670, 13, 'C.U. de Rehabilitación'),
(671, 13, 'C.U. Dr. Rafael Belloso Chacín'),
(672, 13, 'C.U. Fermín Toro'),
(673, 13, 'C.U. Francisco de Miranda'),
(674, 13, 'C.U. Jean Piaget'),
(675, 13, 'C.U. Monseñor de Talavera'),
(676, 13, 'C.U. Prof. José Lorenzo Pérez'),
(677, 13, 'I.U. Avepane'),
(678, 13, 'I.U. Carlos Soublette'),
(679, 13, 'I.U. de Barlovento'),
(680, 13, 'I.U. de Danza'),
(681, 13, 'I.U. de Edu Especializada (EDECAS)'),
(682, 13, 'I.U. de Estudios Musicales'),
(683, 13, 'I.U. de Estudios SupA/P A Reverón'),
(684, 13, 'I.U. de la Audición y El Lenguaje. IVAL'),
(685, 13, 'I.U. de La Frontera'),
(686, 13, 'I.U. de la Marina Mercante Esc Náutica'),
(687, 13, 'I.U. de la Policía Científica'),
(688, 13, 'I.U. de la Policía Metropolitana'),
(689, 13, 'I.U. de Mercadotecnia'),
(690, 13, 'I.U. de Nuevas Profesiones'),
(691, 13, 'I.U. de Profesiones Gerenciales'),
(692, 13, 'I.U. de Relaciones Públicas'),
(693, 13, 'I.U. de Seguros'),
(694, 13, 'I.U. de Teatro'),
(695, 13, 'I.U. de TecnologíaDon R Gallegos'),
(696, 13, 'I.U. de TecnologíaJ A Anzoátegui'),
(697, 13, 'I.U. de Tecnología Alonso Gamero'),
(698, 13, 'I.U. de Tecnología Américo Vespucio'),
(699, 13, 'I.U. de Tecnología Andrés Eloy Blanco'),
(700, 13, 'I.U. de Tecnología Don R Betancourt'),
(701, 13, 'I.U. de Tecnología Eustacio Guevara'),
(702, 13, 'I.U. de Tecnología F Rivero Palacios'),
(703, 13, 'I.U. de Tecnología J Navarro Vallenilla'),
(704, 13, 'I.U. de Tecnología Pedro Emilio Coll'),
(705, 13, 'I.U. de Tecnología Agr R Los Andes'),
(706, 13, 'I.U. de Tecnología Agr Simón Bolívar'),
(707, 13, 'I.U. de Tecnología Aguntín Codazzi'),
(708, 13, 'I.U. de Tecnología Antonio J de Sucre'),
(709, 13, 'I.U. de Tecnología Antonio Ricaurte'),
(710, 13, 'I.U. de Tecnología Antonio Ricaurte'),
(711, 13, 'I.U. de Tecnología Bomberil'),
(712, 13, 'I.U. de Tecnología Cristobal Mendoza'),
(713, 13, 'I.U. de Tecnología de Adm Industrial'),
(714, 13, 'I.U. de Tecnología de Adm Y Hda Pública'),
(715, 13, 'I.U. de Tecnología de Cabimas'),
(716, 13, 'I.U. de Tecnología de Caripito'),
(717, 13, 'I.U. de Tecnología de Cumaná'),
(718, 13, 'I.U. de Tecnología de Ejido'),
(719, 13, 'I.U. de Tecnología de la Victoria'),
(720, 13, 'I.U. de Tecnología de los Llanos'),
(721, 13, 'I.U. de Tecnología de Puerto Cabello'),
(722, 13, 'I.U. de Tecnología de Seg Industrial'),
(723, 13, 'I.U. de Tecnología de Valencia'),
(724, 13, 'I.U. de Tecnología de Yaracuy'),
(725, 13, 'I.U. de Tecnología del Mar'),
(726, 13, 'I.U. de Tecnología del O Mariscal Sucre'),
(727, 13, 'I.U. de Tecnología Delfín Mendoza'),
(728, 13, 'I.U. de Tecnología Dr. J G Hernández'),
(729, 13, 'I.U. de Tecnología Elias Calixto Pompa'),
(730, 13, 'I.U. de Tecnología Henry Pittier'),
(731, 13, 'I.U. de Tecnología Industrial'),
(732, 13, 'I.U. de Tecnología Isaac Newton'),
(733, 13, 'I.U. de Tecnología J L Chirino'),
(734, 13, 'I.U. de Tecnología J P Pérez Alfonzo'),
(735, 13, 'I.U. de Tecnología M Briceño Iragorry'),
(736, 13, 'I.U. de Tecnología para la Informática'),
(737, 13, 'I.U. de Tecnología Pascal'),
(738, 13, 'I.U. de Tecnología R Blanco Fombona'),
(739, 13, 'I.U. de Tecnología R Loero Arismendi'),
(740, 13, 'I.U. de Tecnología READIC'),
(741, 13, 'I.U. de Tecnología Tomas Lander'),
(742, 13, 'I.U. de Tecnología Venezuela'),
(743, 13, 'I.U. Jesús Enrique Lossada'),
(744, 13, 'I.U. Nacional de Est Penitenciarios'),
(745, 13, 'I.U. Pedagógico Mon Arias Blanco'),
(746, 13, 'I.U. Politécnico de la F Armada'),
(747, 13, 'I.U. Politécnico Santiago Mariño'),
(748, 13, 'I.U. YMCA Lope Mendoza'),
(749, 13, 'Instituto de Estudios Superiores de Administración (IESA)'),
(750, 13, 'Universidad Alejandro de Humboldt'),
(751, 13, 'Universidad Bicentenaria de Aragua'),
(752, 13, 'Universidad Católica Andrés Bello'),
(753, 13, 'Universidad Católica del Táchira'),
(754, 13, 'Universidad Cecilio Acosta'),
(755, 13, 'Universidad Central de Venezuela'),
(756, 13, 'Universidad Centro Occidental Lisandro Alvarado'),
(757, 13, 'Universidad de Carabobo'),
(758, 13, 'Universidad de los Andes'),
(759, 13, 'Universidad de Oriente'),
(760, 13, 'Universidad del Zulia'),
(761, 13, 'Universidad Fermín Toro'),
(762, 13, 'Universidad José Antonio Páez'),
(763, 13, 'Universidad José María Vargas'),
(764, 13, 'Universidad Metropolitana'),
(765, 13, 'Universidad Nacional Abierta'),
(766, 13, 'Universidad Nacional ExpFrancisco de Miranda'),
(767, 13, 'Universidad Nacional Exp de Guayana'),
(768, 13, 'Universidad Nacional Exp de los Llanos Occ E Zamora'),
(769, 13, 'Universidad Nacional Exp del Táchira'),
(770, 13, 'Universidad Nacional Exp Politécnica A J de Sucre'),
(771, 13, 'Universidad Nacional Exp Rafael María Baralt'),
(772, 13, 'Universidad Nacional Exp Rómulo Gallegos'),
(773, 13, 'Universidad Nacional Expl Simón Rodríguez'),
(774, 13, 'Universidad Nororiental Gran Mariscal de Ayacucho'),
(775, 13, 'Universidad Nueva Esparta'),
(776, 13, 'Universidad Pedagógica Experimental Libertador'),
(777, 13, 'Universidad Rafael Belloso Chacín'),
(778, 13, 'Universidad Rafael Urdaneta'),
(779, 13, 'Universidad Santa María'),
(780, 13, 'Universidad Simón Bolívar'),
(781, 13, 'Universidad Sur del Lago Jesús María Semprum'),
(782, 13, 'Universidad Tecnológico del Centro'),
(783, 13, 'Universidad Valle de Momboy'),
(784, 13, 'Universidad Yacambú'),
(785, 7, 'U. Técnica Federico Santa María'),
(786, 7, 'U. de Los Andes'),
(787, 7, 'U. Finis Terrae'),
(788, 7, 'U. Mayor'),
(789, 7, 'U. Andrés Bello'),
(790, 7, 'Inacap'),
(791, 7, 'Uniacc'),
(792, 7, 'U. del Desarrollo'),
(793, 2, 'Faculdade Oswaldo Cruz'),
(794, 2, 'Universidade São Camilo'),
(795, 2, 'Faculdades Associadas Ipiranga'),
(796, 2, 'Faculdade Campos Salles'),
(797, 18, 'Centro de Estudios Universitarios de Monterrey'),
(798, 2, 'Instituto Presbiteriano Mackenzie'),
(799, 18, 'ULSA'),
(800, 2, 'Faculdade de Engenharia Industrial - FEI'),
(801, 1, 'Universidad Argentina John F. Kennedy'),
(802, 1, 'UMS'),
(803, 1, 'E.S.H.'),
(804, 1000, 'Otra'),
(805, 7, 'U. de las Americas'),
(806, 7, 'Esc. de Contadores Auditores de Santiago'),
(807, 7, 'Esc. Latinoamericana de Idiomas ELADI'),
(808, 7, 'Esc. Moderna de Música'),
(809, 7, 'Esc. Nacional de Relaciones Públicas'),
(810, 7, 'Inst. AIEP'),
(811, 7, 'Inst. Alpes'),
(812, 7, 'Inst. Carlos Casanueva'),
(813, 7, 'Inst. CEPECH'),
(814, 7, 'Inst. CIISA'),
(815, 7, 'Inst. de Arte y Comunicación ARCOS'),
(816, 7, 'Inst. de Ciencias y Artes INCACEA'),
(817, 7, 'Inst. de Formación Empresarial IFE'),
(818, 7, 'Inst. de las Comunicaciones PROCOM'),
(819, 7, 'Inst. de Providencia'),
(820, 7, 'Inst. del Pacífico'),
(821, 7, 'Inst. DuocUC'),
(822, 7, 'Inst. EACE'),
(823, 7, 'Inst. EATRI'),
(824, 7, 'Inst. ECACEC'),
(825, 7, 'Inst. ESUCOMEX'),
(826, 7, 'Inst. INSEC'),
(827, 7, 'Inst. INTEC'),
(828, 7, 'Inst. La Araucana'),
(829, 7, 'Inst. Latinoamericano de Comercio Exterior'),
(830, 7, 'Inst. Los Leones'),
(831, 7, 'Inst. Luis Galdames'),
(832, 7, 'Inst. Manpower'),
(833, 7, 'Inst. Profesional John F. Kennedy'),
(834, 7, 'Inst. Simón Bolivar'),
(835, 7, 'Inst. Superior de Ciencias y Artes de la Comunicación'),
(836, 7, 'Inst. Superior de Electrónica Gamma'),
(837, 7, 'Inst. ZIPTER'),
(838, 7, 'Otra'),
(839, 7, 'U. Academia de Humanismo Cristiano'),
(840, 7, 'U. Alberto Hurtado'),
(841, 7, 'U. Alonso de Ovalle'),
(842, 7, 'U. ARCIS'),
(843, 7, 'U. Bernardo O Higgins'),
(844, 7, 'U. Bolivariana'),
(845, 7, 'U. Católica Blas Cañas'),
(846, 7, 'U. Católica Cardenal Raúl Silva E.'),
(847, 7, 'U. de Aconcagua'),
(848, 7, 'U. de Talca'),
(849, 7, 'U. del Mar'),
(850, 7, 'U. Francisco de Aguirre de la Serena'),
(851, 7, 'U. Francisco de Vitoria'),
(852, 7, 'U. Gabriela Mistral'),
(853, 7, 'U. Iberoamericana'),
(854, 7, 'U. Internacional SEK'),
(855, 7, 'U. La República'),
(856, 7, 'U. Mariano Egaña'),
(857, 7, 'U. Miguel de Cervantes'),
(858, 7, 'U. Santo Tomás'),
(859, 7, 'U. Tecnológica Metropolitana'),
(860, 7, 'U. Tecnológica Vicente Pérez Rosales'),
(861, 18, 'Universidad del Valle de Mexico'),
(862, 52, 'Otra'),
(863, 54, 'Otra'),
(864, 53, 'Otra'),
(865, 56, 'Otra'),
(866, 57, 'Otra'),
(867, 58, 'Otra'),
(868, 59, 'Otra'),
(869, 60, 'Otra'),
(870, 62, 'Otra'),
(871, 61, 'Otra'),
(872, 64, 'Otra'),
(873, 63, 'Otra'),
(874, 66, 'Otra'),
(875, 65, 'Otra'),
(876, 68, 'Otra'),
(877, 67, 'Otra'),
(878, 69, 'Otra'),
(879, 70, 'Otra'),
(880, 18, 'Instituto Politécnico Nacional'),
(881, 18, 'ITESM Campus Aguascalientes'),
(882, 18, 'ITESM Campus Chiapas'),
(883, 18, 'ITESM Campus Chihuahua'),
(884, 18, 'ITESM Campus Cd. Juárez'),
(885, 18, 'ITESM Campus Laguna'),
(886, 18, 'ITESM Campus Saltillo'),
(887, 18, 'ITESM Campus Colima'),
(888, 18, 'ITESM Campus Cd. de México'),
(889, 18, 'ITESM Campus Edo. de México'),
(890, 18, 'ITESM Campus Toluca'),
(891, 18, 'ITESM Campus Irapuato'),
(892, 18, 'ITESM Campus León'),
(893, 18, 'ITESM Campus Hidalgo'),
(894, 18, 'ITESM Campus Guadalajara'),
(895, 18, 'ITESM Campus Morelos'),
(896, 18, 'ITESM Campus Eugenio Garza Sada'),
(897, 18, 'ITESM Campus Monterrey'),
(898, 18, 'ITESM Campus Queretaro'),
(899, 18, 'ITESM Campus San Luis Potosi'),
(900, 18, 'ITESM Campus Mazatlán'),
(901, 18, 'ITESM Campus Sinaloa'),
(902, 18, 'ITESM Campus Cd. Obregón'),
(903, 18, 'ITESM Campus Guaymas'),
(904, 18, 'ITESM Campus Sonora Norte'),
(905, 18, 'ITESM Campus Tampico'),
(906, 18, 'ITESM Campus Central de Veracruz'),
(907, 18, 'ITESM Campus Zacatecas'),
(908, 21, 'Universitat de València'),
(909, 21, 'Universidad Politécnica de Valencia'),
(910, 13, 'I.U. de Gerencia y Tecnología'),
(911, 1, 'O.R.T.'),
(912, 1, 'Universidad Católica de Salta'),
(913, 1, 'Universidad de la Marina Mercante'),
(914, 1, 'Universidad de Mendoza'),
(915, 1, 'Universidad del Museo Social Argentino'),
(916, 1, 'Universidad Nacional de Formosa'),
(917, 1, 'Universidad Nacional de Jujuy'),
(918, 1, 'Universidad Nacional de La Pampa'),
(919, 1, 'I.A.S.E'),
(920, 1, 'Universidad Nacional de la Patagonia Austral'),
(921, 1, 'U. Nacional de la Patagonia San Juan Bosco'),
(922, 1, 'Universidad Nacional de La Rioja'),
(923, 1, 'Universidad Nacional de Lanús'),
(924, 1, 'Universidad Nacional de Salta'),
(925, 1, 'Universidad Nacional de Santiago del Estero'),
(926, 1, 'U. Nacional del centro de la Prov. de Bs. As.'),
(927, 13, 'Instituto Venezolano de Investigaciones Científicas'),
(928, 5, 'Universidad Andina Simón Bolívar'),
(929, 5, 'Universidad Autónoma Juan Misael Saracho'),
(930, 5, 'Universidad Católica Boliviana de Cochabamba'),
(931, 5, 'Universidad Católica Boliviana de La Paz'),
(932, 5, 'Universidad Católica Boliviana de Santa Cruz'),
(933, 5, 'Universidad Católica del Valle'),
(934, 5, 'Universidad Mayor de San Andrés'),
(935, 5, 'Universidad Mayor de San Simón'),
(936, 5, 'Universidad Nur'),
(937, 5, 'Universidad Privada Boliviana'),
(938, 5, 'Universidad Técnica de Oruro'),
(939, 5, 'Universidad Católica Boliviana Regional Cochabamba'),
(940, 5, 'Univ. Autónoma Gabriel René Moreno de Santa Cruz de la Sierra'),
(941, 5, 'UTEPSA'),
(942, 11, 'Pontificia Universidad Católica del Perú'),
(943, 11, 'Instituto de Estudios Europeos'),
(944, 11, 'Universidad Alas Peruanas'),
(945, 11, 'Universidad de Lima'),
(946, 11, 'Universidad de San Martín de Porres'),
(947, 11, 'Universidad del Pacífico'),
(948, 11, 'Universidad Inca Garcilaso de la Vega'),
(949, 11, 'Universidad N. Wiener'),
(950, 11, 'Universidad Nacional de Ingeniería'),
(951, 11, 'Universidad Nacional Federico Villarreal'),
(952, 11, 'Universidad Nacional Mayor de San Marcos'),
(953, 11, 'Universidad Peruana de Ciencias Aplicadas'),
(954, 11, 'Universidad Ricardo Palma'),
(955, 11, 'Universidad San Ignacio de Loyola'),
(956, 11, 'Universidad Tecnológica del Perú'),
(957, 11, 'Universidad Nacional de Piura'),
(958, 11, 'Universidad Nacional San Antonio Abad de Cusco'),
(959, 11, 'Universidad Nacional San Agustínde Arequipa'),
(960, 9, 'Corporación para el Desarrollo de la Educación Universitaria'),
(961, 9, 'Escuela Politécnica del Ejército'),
(962, 9, 'Escuela Politécnica Nacional'),
(963, 9, 'Escuela Superior Politécnica de Chimbonazo'),
(964, 9, 'Escuela Superior Politécnica del Litoral'),
(965, 9, 'Pontífica Universidad Católica del Ecuador'),
(966, 9, 'SEK - Ecuador'),
(967, 9, 'Universidad Andina Simón Bolívar'),
(968, 9, 'Universidad Casa Grande'),
(969, 9, 'Universidad Católica de Santiago de Guayaquil'),
(970, 9, 'Universidad Central del Ecuador'),
(971, 9, 'Universidad de Cuenca'),
(972, 9, 'Universidad de Especialidades Espíritu Santo'),
(973, 9, 'Universidad de Guayaquil'),
(974, 9, 'Universidad del Azuay'),
(975, 9, 'Universidad del Pacífico'),
(976, 9, 'Universidad Santa María - Campus Guayaquil'),
(977, 9, 'Universidad Laica Vicente Rocafuerte'),
(978, 9, 'Universidad Nacional de Chimbonazo'),
(979, 9, 'Universidad Nacional de Loja'),
(980, 9, 'Universidad San Francisco de Quito'),
(981, 9, 'Universidad Técnica de Cotopaxi'),
(982, 9, 'Universidad Técnica Particular de Loja'),
(983, 9, 'Universidad Tecnológica Equinoccial'),
(984, 9, 'Academia Latinoamericana de Español'),
(985, 9, 'Universidad Técnica de Machala'),
(986, 2, 'Business School São Paulo'),
(987, 2, 'Escola de Administração de Empresas São Paulo (EAESP/FGV)'),
(988, 2, 'Universidade de Mogi das Cruzes'),
(989, 2, 'Universidade Mackenzie'),
(990, 1, 'FLACSO'),
(991, 5, 'Universidad Privada de Santa Cruz de la Sierra'),
(992, 5, 'Universidad Autónoma Tomás Frías'),
(993, 71, 'Otra'),
(994, 21, 'Universidad de Alcalá'),
(995, 21, 'Universidad de León'),
(996, 21, 'Universidad Pablo de Olavide'),
(997, 21, 'Universidad Politécnica de Cartagena'),
(998, 21, 'Universidad Politécnica de Cataluña'),
(999, 21, 'Universidad Politécnica de Madrid'),
(1000, 21, 'Universidad Camilo José Cela'),
(1001, 21, 'Universidad Cardenal Herrera (CEU)'),
(1002, 21, 'Universidad Católica San Antonio de Murcia'),
(1003, 21, 'Universidad de Deusto'),
(1004, 21, 'Mondragón Unibertsitatea'),
(1005, 21, 'Universidad Pontificia Comillas (ICAI-ICADE)'),
(1006, 21, 'Universidad Pontificia de Salamanca'),
(1007, 21, 'Universidad SEK de Segovia'),
(1008, 21, 'Universidad de Vic'),
(1009, 21, 'Universidad Internacional de Andalucía'),
(1010, 21, 'Universidad Internacional Menéndez Pelayo'),
(1011, 73, 'Otra'),
(1012, 21, 'Instituto de Empresa'),
(1013, 2, 'FIAP - Faculdade de Informatica e Administragco Paulista'),
(1014, 2, 'Faculdades do Nordeste - Fanor'),
(1015, 74, 'Otra'),
(1016, 75, 'Otra'),
(1017, 18, 'Centro de Estudios Universitarios Londres'),
(1018, 18, 'Universidad del Distrito Federal'),
(1019, 18, 'ISEC'),
(1020, 18, 'Universidad de la Comunicación'),
(1021, 32, 'Coventry University'),
(1022, 18, 'Centro de Investigación y Docencia Económicas'),
(1023, 18, 'Centro Universitario de Idiomas'),
(1024, 18, 'Centro Universitario Grupo Sol (CUGS)'),
(1025, 18, 'Centro Universitario Narvarte'),
(1026, 18, 'CONALEP'),
(1027, 18, 'Centro de Estudios Avanzados en Administración'),
(1028, 18, 'Centro de Estudios en Ciencias de la Comunicación'),
(1029, 18, 'Centro de Estudios Superiores San Angel'),
(1030, 18, 'Colegio Superior de Gastronomía'),
(1031, 18, 'Universidad del Tepeyac'),
(1032, 18, 'Escuela Bancaria Comercial'),
(1033, 18, 'Instituto de Mercadotecnia y Publicidad'),
(1034, 18, 'Universidad Autónoma del Estado de Hidalgo'),
(1035, 18, 'Universidad Chapultepec'),
(1036, 18, 'Universidad del Claustro de Sor Juana'),
(1037, 18, 'Universidad Franco Mexicana'),
(1038, 18, 'Universidad Hispanoamericana'),
(1039, 18, 'Universidad Insurgentes'),
(1040, 18, 'Universidad Latina'),
(1041, 18, 'Universidad Mexicana'),
(1042, 18, 'Universidad Simón Bolivar'),
(1043, 18, 'Universidad Tecnológica Americana (UTECA)'),
(1044, 18, 'Escuela Panamericana de Hoteleria'),
(1045, 26, 'Università degli Studi dell''Aquila'),
(1046, 26, 'Università degli Studi di Chieti G. d''Annunzio'),
(1047, 26, 'Università degli Studi di Teramo'),
(1048, 26, 'Università degli Studi della Basilicata'),
(1049, 26, 'Università degli Studi della Calabria'),
(1050, 26, 'Università degli Studi di Reggio Calabria'),
(1051, 26, 'Istituto universitario navale di Napoli'),
(1052, 26, 'Istituto Universitario Orientale'),
(1053, 26, 'Seconda Università degli Studi di Napoli'),
(1054, 26, 'Università degli Studi del Sannio'),
(1055, 26, 'Università degli Studi di Napoli Federico II'),
(1056, 26, 'Università degli Studi di Salerno'),
(1057, 26, 'Istituto per la formazione al giornalismo (IFG) - Bologna'),
(1058, 26, 'Università Cattolica del Sacro Cuore - Piacenza'),
(1059, 26, 'Università degli Studi di Bologna'),
(1060, 26, 'Università degli Studi di Ferrara'),
(1061, 26, 'Università degli Studi di Modena'),
(1062, 26, 'Università degli Studi di Parma'),
(1063, 26, 'Università degli Studi di Trieste'),
(1064, 26, 'Università degli Studi di Udine'),
(1065, 26, 'Libera università internazionale degli studi sociali LUISS Guido Carli'),
(1066, 26, 'Libero istituto universitario ''Campus bio-medico'' di Roma'),
(1067, 26, 'Università Cattolica del Sacro Cuore - Roma'),
(1068, 26, 'Università degli Studi della Tuscia'),
(1069, 26, 'Università degli Studi di Cassino'),
(1070, 26, 'Università degli Studi di Roma -La Sapienza-'),
(1071, 26, 'Università degli Studi di Roma -Tor Vergata-'),
(1072, 26, 'Università degli Studi Roma Tre'),
(1073, 26, 'Università degli Studi di Genova'),
(1074, 26, 'Libera Università di Lingue e Comunicazione (IULM)'),
(1075, 26, 'Interior Design Institute (IDI)'),
(1076, 26, 'Libero istituto universitario Carlo Cattaneo (LIUC)'),
(1077, 26, 'Politecnico di Milano'),
(1078, 26, 'Università Cattolica del Sacro Cuore - Brescia'),
(1079, 26, 'Università Cattolica del Sacro Cuore - Milano'),
(1080, 26, 'Università Commerciale Luigi Bocconi'),
(1081, 26, 'Università degli Studi dell''Insubria'),
(1082, 26, 'Università degli Studi di Bergamo'),
(1083, 26, 'Università degli Studi di Brescia'),
(1084, 26, 'Università degli Studi di Milano'),
(1085, 26, 'Università degli Studi di Milano-Bicocca'),
(1086, 26, 'Università degli Studi di Pavia'),
(1087, 26, 'Università degli Studi di Ancona'),
(1088, 26, 'Università degli Studi di Camerino'),
(1089, 26, 'Università degli Studi di Macerata'),
(1090, 26, 'Università degli Studi di Urbino'),
(1091, 26, 'Accademia di Belle Arti di Urbino'),
(1092, 26, 'Politecnico di Torino'),
(1093, 26, 'Università degli Studi di Torino'),
(1094, 26, 'Università degli Studi di Torino sede di Alessandria'),
(1095, 26, 'Politecnico di Bari'),
(1096, 26, 'Università degli Studi di Bari'),
(1097, 26, 'Università degli Studi di Lecce'),
(1098, 26, 'Università degli Studi di Cagliari'),
(1099, 26, 'Università degli studi di Sassari'),
(1100, 26, 'Università degli Studi di Catania'),
(1101, 26, 'Università degli Studi di Messina'),
(1102, 26, 'Università degli Studi di Palermo'),
(1103, 26, 'Scuola Normale Superiore di Pisa'),
(1104, 26, 'Scuola superiore Sant''Anna di Pisa'),
(1105, 26, 'Università degli Studi di Firenze'),
(1106, 26, 'Università degli Studi di Pisa'),
(1107, 26, 'Università degli Studi di Siena'),
(1108, 26, 'Accademia di Belle Arti di Carrara'),
(1109, 26, 'Università degli Studi di Trento'),
(1110, 26, 'Università degli Studi di Perugia'),
(1111, 26, 'Istituto universitario di architettura di Venezia'),
(1112, 26, 'Università degli Studi di Padova'),
(1113, 26, 'Università degli Studi di Venezia Ca'' Foscari'),
(1114, 26, 'Università degli Studi di Verona'),
(1115, 26, 'Istituto Statale d''Arte di Venezia'),
(1116, 26, 'Esu Venezia'),
(1117, 50, 'Uniwersytet Gdanski'),
(1118, 50, 'Uniwersytet im. Adama Mickiewicza w Poznaniu'),
(1119, 50, 'Uniwersytet Jagiellonski w Krakowie'),
(1120, 50, 'Uniwersytet Lodzki'),
(1121, 50, 'Uniwersytet Mikolaja Kopernika w Toruniu'),
(1122, 50, 'Uniwersytet Slaski'),
(1123, 50, 'Uniwersytet Szczecinski'),
(1124, 50, 'Uniwersytet Marii Curie-Sklodowskiej w Lublinie'),
(1125, 50, 'Uniwersytet w Bialymstoku'),
(1126, 50, 'Uniwersytet Opolski'),
(1127, 50, 'Uniwersytet Warszawski'),
(1128, 50, 'Uniwersytet Wroclawski'),
(1129, 50, 'Uniwersytet Warmiñsko-Mazurski w Olsztynie'),
(1130, 50, 'Uniwersytet Kardynala Stefana Wyszyñskiego w Warszawie'),
(1131, 50, 'Akademia Muzyczna im. Fryderyka Chopina w Warszawie'),
(1132, 50, 'Akademia Muzyczna im. Ignacego Jana Paderewskiego w Poznaniu'),
(1133, 50, 'Akademia Muzyczna w Krakowie'),
(1134, 50, 'Akademia Muzyczna w Lodzi'),
(1135, 50, 'Akademia Muzyczna im. Stanislawa Moniuszki w Gdansku'),
(1136, 50, 'Akademia Muzyczna im. Karola Szymanowskiego w Katowicach'),
(1137, 50, 'Akademia Muzyczna im. Feliksa Nowowiejskiego w Bydgoszczy'),
(1138, 50, 'Akademia Sztuk Pieknych im. Wladyslawa Strzeminskiego w Lodzi'),
(1139, 50, 'Akademia Sztuk Pieknych im. Jana Matejki w Krakowie'),
(1140, 50, 'Akademia Sztuk Pieknych w Gdansku'),
(1141, 50, 'Akademia Sztuk Pieknych w Poznaniu'),
(1142, 50, 'Akademia Sztuk Pieknych w Warszawie'),
(1143, 50, 'Akademia Sztuk Pieknych we Wroclawiu'),
(1144, 50, 'Akademia Teatralna im. Aleksandra Zelwerowicza w Warszawie'),
(1145, 50, 'Panstwowa Wyzsza Szkola Teatralna im. Ludwika Solskiego w Krakowie'),
(1146, 50, 'Akademia Medyczna w Warszawie'),
(1147, 50, 'Slaska Akademia Medyczna w Katowicach'),
(1148, 50, 'Akademia Medyczna im. Karola Marcinkowskiego w Poznaniu'),
(1149, 50, 'Akademia Medyczna im. Ludwika Rydygiera w Bydgoszczy'),
(1150, 50, 'Akademia Medyczna im.Piastów Slaskich we Wroclawiu'),
(1151, 50, 'Akademia Medyczna w Bialymstoku'),
(1152, 50, 'Akademia Medyczna w Gdansku'),
(1153, 50, 'Akademia Medyczna w Lublinie'),
(1154, 50, 'Akademia Medyczna w Lodzi'),
(1155, 50, 'Collegium Medicum Uniwersytetu Jagiellonskiego w Krakowie'),
(1156, 50, 'Pomorska Akademia Medyczna w Szczecinie'),
(1157, 50, 'Szkola Glówna Handlowa w Warszawie'),
(1158, 50, 'Akademia Ekonomiczna w Poznaniu'),
(1159, 50, 'Akademia Ekonomiczna w Krakowie'),
(1160, 50, 'Akademia Ekonomiczna im. Oskara Langego we Wroclawiu'),
(1161, 50, 'Akademia Ekonomiczna im. Karola Adamieckiego w Katowicach'),
(1162, 50, 'Akademia Górniczo-Hutnicza im. Stanislawa Staszica w Krakowie'),
(1163, 50, 'Politechnika Bialostocka'),
(1164, 50, 'Politechnika Czestochowska'),
(1165, 50, 'Politechnika Gdanska'),
(1166, 50, 'Politechnika Krakowska im. Tadeusza Kosciuszki'),
(1167, 50, 'Politechnika Lubelska'),
(1168, 50, 'Politechnika Lodzka'),
(1169, 50, 'Politechnika Opolska'),
(1170, 50, 'Politechnika Poznanska'),
(1171, 50, 'Politechnika Szczecinska'),
(1172, 50, 'Politechnika Slaska w Gliwicach'),
(1173, 50, 'Politechnika Swietokrzyska'),
(1174, 50, 'Politechnika Warszawska'),
(1175, 50, 'Politechnika Wroclawska'),
(1176, 50, 'Politechnika Zielonogórska'),
(1177, 50, 'Wyzsza Szkola Morska w Gdyni'),
(1178, 50, 'Wyzsza Szkola Morska w Szczecinie'),
(1179, 34, 'Albert-Ludwigs-Universität Freiburg'),
(1180, 34, 'Augustana-Hochschule Neuendettelsau'),
(1181, 34, 'Bauhaus Universität Weimar'),
(1182, 34, 'Bayerische Julius-Maximilians-Universität Würzburg'),
(1183, 34, 'Bergische Universität Gesamthochschule Wuppertal'),
(1184, 34, 'Bildungswissenschaftliche Hochschule Flensburg, Universität'),
(1185, 34, 'Brandenburgische Technische Universität Cottbus'),
(1186, 34, 'Carl von Ossietzky Universität Oldenburg'),
(1187, 34, 'Christian-Albrechts-Universität Kiel'),
(1188, 34, 'Deutsche Hochschule für Verwaltungswissenschaften Speyer'),
(1189, 34, 'Deutsche Sporthochschule Köln'),
(1190, 34, 'E.A.P. Europäische Wirtschaftshochschule Berlin'),
(1191, 34, 'Eberhard-Karls-Universität Tübingen'),
(1192, 34, 'Ernst-Moritz-Arndt Universität Greifswald'),
(1193, 34, 'Europa-Universität Viadrina Frankfurt (Oder)'),
(1194, 34, 'European Business School Schloß Reichartshausen'),
(1195, 34, 'Fernuniversität Gesamthochschule Hagen'),
(1196, 34, 'Freie Universität Berlin'),
(1197, 34, 'Friedrich-Alexander Universität Erlangen-Nürnberg');
INSERT INTO `estudio_instituciones` (`id`, `pais_id`, `denominacion`) VALUES
(1198, 34, 'Friedrich-Schiller Universität Jena'),
(1199, 34, 'Georg-August Universität Göttingen'),
(1200, 34, 'Gerhard-Mercator Universität Gesamthochschule Duisburg'),
(1201, 34, 'Gustav-Siewerth-Akademie'),
(1202, 34, 'Handelshochschule Leipzig'),
(1203, 34, 'Heinrich-Heine Universität Düsseldorf'),
(1204, 34, 'Hochschule für Jüdische Studien Heidelberg'),
(1205, 34, 'Hochschule für Philosophie München'),
(1206, 34, 'Hochschule für Wirtschaft und Politik Hamburg'),
(1207, 34, 'Hochschule Vechta'),
(1208, 34, 'Humboldt Universität Berlin'),
(1209, 34, 'International University in Germany'),
(1210, 34, 'Internationales Hochschulinstitut Zittau'),
(1211, 34, 'Johann Wolfgang Goethe Universität Frankfurt am Main'),
(1212, 34, 'Johannes-Gutenberg Universität Mainz'),
(1213, 34, 'Justus Liebig Universität Gießen'),
(1214, 34, 'Katholische Universität Eichstätt'),
(1215, 34, 'Kirchliche Hochschule Bethel'),
(1216, 34, 'Kirchliche Hochschule Wuppertal'),
(1217, 34, 'Ludwig-Maximilians-Universität München'),
(1218, 34, 'Lutherische Theologische Hochschule Oberursel'),
(1219, 34, 'Martin-Luther Universität Halle-Wittenberg'),
(1220, 34, 'Medizinische Hochschule Hannover'),
(1221, 34, 'Medizinische Universität Lübeck'),
(1222, 34, 'Otto-Friedrich Universität Bamberg'),
(1223, 34, 'Otto-von-Guericke Universität Magdeburg'),
(1224, 34, 'Phillips-Universität Marburg'),
(1225, 34, 'Philosophisch-Theologische Hochschule der Salesianer Don Boscos'),
(1226, 34, 'Philosophisch-Theologische Hochschule Münster'),
(1227, 34, 'Philosophisch-Theologische Hochschule Sankt Georgen'),
(1228, 34, 'Private Universität Witten/Herdecke'),
(1229, 34, 'Pädagogische Hochschule Erfurt/Mühlhausen'),
(1230, 34, 'Pädagogische Hochschule Freiburg'),
(1231, 34, 'Pädagogische Hochschule Heidelberg'),
(1232, 34, 'Pädagogische Hochschule Karlsruhe'),
(1233, 34, 'Pädagogische Hochschule Ludwigsburg'),
(1234, 34, 'Pädagogische Hochschule Schwäbisch Gmünd'),
(1235, 34, 'Pädagogische Hochschule Weingarten'),
(1236, 34, 'Rheinisch Westfälische Technische Hochschule Aachen'),
(1237, 34, 'Rheinische Friedrich-Wilhelms Universität Bonn'),
(1238, 34, 'Ruhr-Universität Bochum'),
(1239, 34, 'Ruprecht-Karls-Universität Heidelberg'),
(1240, 34, 'Technische Universität Bergakademie Freiberg'),
(1241, 34, 'Technische Universität Berlin'),
(1242, 34, 'Technische Universität Carolo-Wilhelmina Braunschweig'),
(1243, 34, 'Technische Universität Chemnitz-Zwickau'),
(1244, 34, 'Technische Universität Clausthal'),
(1245, 34, 'Technische Universität Darmstadt'),
(1246, 34, 'Technische Universität Dresden'),
(1247, 34, 'Technische Universität Hamburg-Harburg'),
(1248, 34, 'Technische Universität Ilmenau'),
(1249, 34, 'Technische Universität München'),
(1250, 34, 'Theologische Fakultät Fulda'),
(1251, 34, 'Theologische Fakultät Paderborn'),
(1252, 34, 'Theologische Fakultät Trier'),
(1253, 34, 'Theologische Hochschule Friedensau'),
(1254, 34, 'Tierärztliche Hochschule Hannover'),
(1255, 34, 'Universität Augsburg'),
(1256, 34, 'Universität Bayreuth'),
(1257, 34, 'Universität Bielefeld'),
(1258, 34, 'Universität Bremen'),
(1259, 34, 'Universität der Bundeswehr Hamburg'),
(1260, 34, 'Universität der Bundeswehr München'),
(1261, 34, 'Universität des Saarlandes'),
(1262, 34, 'Universität Dortmund'),
(1263, 34, 'Universität Erfurt'),
(1264, 34, 'Universität Essen'),
(1265, 34, 'Universität Fridericana Karlsruhe (Technische Hochschule)'),
(1266, 34, 'Universität Hamburg'),
(1267, 34, 'Universität Hannover'),
(1268, 34, 'Universität Hildesheim'),
(1269, 34, 'Universität Hohenheim'),
(1270, 34, 'Universität Kaiserslautern'),
(1271, 34, 'Universität Kassel'),
(1272, 34, 'Universität Koblenz-Landau'),
(1273, 34, 'Universität Konstanz'),
(1274, 34, 'Universität Köln'),
(1275, 34, 'Universität Leipzig'),
(1276, 34, 'Universität Lüneburg'),
(1277, 34, 'Universität Mannheim'),
(1278, 34, 'Universität Osnabrück'),
(1279, 34, 'Universität Paderborn'),
(1280, 34, 'Universität Passau'),
(1281, 34, 'Universität Potsdam'),
(1282, 34, 'Universität Regensburg'),
(1283, 34, 'Universität Rostock'),
(1284, 34, 'Universität Siegen'),
(1285, 34, 'Universität Stuttgart'),
(1286, 34, 'Universität Trier'),
(1287, 34, 'Universität Ulm'),
(1288, 34, 'Westfälische Wilhelms-Universität Münster'),
(1289, 31, 'Akademie der bildenden Künste Wien'),
(1290, 31, 'Donau-Universität Krems'),
(1291, 31, 'Montanuniversität Leoben'),
(1292, 31, 'Technische Universität Graz'),
(1293, 31, 'Technische Universität Wien'),
(1294, 31, 'Universität für angewandte Kunst Wien'),
(1295, 31, 'Universität für Bodenkultur Wien'),
(1296, 31, 'Universität für künstlerische und industrielle Gestaltung Linz'),
(1297, 31, 'Universität für Musik und darstellende Kunst Wien'),
(1298, 31, 'Universität für Musik und darstellende Kunst Graz'),
(1299, 31, 'Universität Graz Universität Innsbruck'),
(1300, 31, 'Universität Klagenfurt'),
(1301, 31, 'Universität Linz'),
(1302, 31, 'Universität Mozarteum Salzburg'),
(1303, 31, 'Universität Salzburg'),
(1304, 31, 'Universität Vienna'),
(1305, 31, 'Veterinärmedizinische Universität Wien'),
(1306, 31, 'Wirtschaftsuniversität Wien'),
(1307, 18, 'Benemérita Universidad Autónoma de Puebla'),
(1308, 7, 'Liceo Industrial DOMINGO MATTE PÉREZ'),
(1309, 7, 'Liceo BANJAMÍN DÁVILA'),
(1310, 7, 'Liceo CIENCIA Y TECNOLOGÍA A-112'),
(1311, 18, 'Universidad Interamericana del Norte'),
(1312, 1, 'Universidad Católica de La Plata'),
(1313, 1, 'Maimonides'),
(1314, 1, 'Escuela Argentina de Negocios');

-- --------------------------------------------------------

--
-- Table structure for table `estudio_niveles`
--

CREATE TABLE IF NOT EXISTS `estudio_niveles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `orden` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `estudio_niveles`
--

INSERT INTO `estudio_niveles` (`id`, `denominacion`, `orden`) VALUES
(1, 'Doctorado en Curso', 72),
(2, 'Doctorado Graduado', 75),
(3, 'Doctorado Incompleto', 70),
(4, 'Maestría en Curso', 52),
(5, 'Maestría Graduado', 55),
(6, 'Maestría Incompleto', 50),
(7, 'PhD en Curso', 78),
(8, 'PhD Graduado', 80),
(9, 'PhD Incompleto', 76),
(10, 'Posgrado en Curso', 42),
(11, 'Posgrado Graduado', 45),
(12, 'Posgrado Incompleto', 40),
(13, 'Primaria en Curso', 3),
(14, 'Primaria Graduado', 6),
(15, 'Primaria Incompleta', 2),
(16, 'Secundario en Curso', 12),
(17, 'Secundario Graduado', 14),
(18, 'Secundario Incompleto', 10),
(19, 'Técnico en Curso', 17),
(20, 'Técnico Graduado', 19),
(21, 'Técnico Incompleto', 15),
(22, 'Terciario en Curso', 22),
(23, 'Terciario Graduado', 25),
(24, 'Terciario Incompleto', 20),
(25, 'Universidad en Curso', 32),
(26, 'Universidad Graduado', 35),
(27, 'Universitario Incompleto', 30);

-- --------------------------------------------------------

--
-- Table structure for table `experiencias`
--

CREATE TABLE IF NOT EXISTS `experiencias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL DEFAULT '0',
  `descripcion` text COLLATE latin1_spanish_ci,
  `empresa` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `finicio` date DEFAULT NULL,
  `ffin` date DEFAULT NULL,
  `industria_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nivelpuesto_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pais_id` int(10) unsigned NOT NULL DEFAULT '0',
  `puesto` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exp_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `laboral_areas`
--

CREATE TABLE IF NOT EXISTS `laboral_areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=161 ;

--
-- Dumping data for table `laboral_areas`
--

INSERT INTO `laboral_areas` (`id`, `denominacion`) VALUES
(22, 'Administración'),
(23, 'Comercial'),
(24, 'Diseño'),
(25, 'Finanzas'),
(26, 'Internet'),
(27, 'Investigación y Desarrollo'),
(28, 'Legal'),
(29, 'Logística'),
(30, 'Marketing'),
(31, 'Prácticas Profesionales'),
(32, 'Produccion / Mantenimiento'),
(34, 'Tecnologia / Sistemas'),
(35, 'Ventas'),
(36, 'Otros'),
(48, 'Recursos Humanos'),
(52, 'Creatividad'),
(53, 'Multimedia'),
(54, 'Distribución'),
(55, 'Jóvenes Profesionales'),
(56, 'Compras'),
(57, 'Consultoria'),
(58, 'Contabilidad'),
(59, 'Ingenieria'),
(60, 'Relaciones Institucionales/Publicas'),
(61, 'Seguridad Industrial/Medio Ambiente'),
(70, 'Mantenimiento'),
(80, 'Comunicacion'),
(81, 'Periodismo'),
(82, 'Abastecimiento'),
(83, 'Auditoría'),
(84, 'Calidad'),
(85, 'Comercio Exterior'),
(86, 'Comunicaciones Internas'),
(87, 'Comunicaciones Externas'),
(88, 'Control de Gestión'),
(89, 'E-commerce'),
(90, 'Impuestos'),
(91, 'Medio Ambiente'),
(92, 'Planeamiento'),
(93, 'Salud'),
(94, 'Gerencia / Dirección General'),
(111, 'Traduccion'),
(120, 'Educación'),
(150, 'Servicios'),
(160, 'Producción');

-- --------------------------------------------------------

--
-- Table structure for table `laboral_industrias`
--

CREATE TABLE IF NOT EXISTS `laboral_industrias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=88 ;

--
-- Dumping data for table `laboral_industrias`
--

INSERT INTO `laboral_industrias` (`id`, `denominacion`) VALUES
(7, 'Agropecuaria'),
(8, 'Arquitectura'),
(9, 'Banca / Financiera'),
(10, 'Consultoría'),
(11, 'Consumo masivo'),
(12, 'Comercio'),
(13, 'Defensa'),
(14, 'Educación'),
(15, 'Energía'),
(16, 'Farmacéutica'),
(17, 'Gobierno'),
(18, 'Internet'),
(19, 'Jurídica'),
(20, 'Manufactura'),
(21, 'Publicidad / Marketing / RRPP'),
(23, 'Minería / Petróleo / Gas'),
(24, 'Medios'),
(25, 'ONGs'),
(26, 'Transporte'),
(27, 'Otra'),
(29, 'Servicios'),
(30, 'Entretenimiento'),
(31, 'Diseño'),
(32, 'Financiera'),
(33, 'Química'),
(34, 'Seguros'),
(35, 'Supermercado / Hipermercado'),
(36, 'Pesca'),
(37, 'Forestal'),
(38, 'Biotecnología'),
(39, 'Telecomunicaciones'),
(40, 'Informática / Tecnología'),
(41, 'Construcción'),
(42, 'Automotriz'),
(44, 'Salud'),
(45, 'Turismo'),
(46, 'Hotelería'),
(48, 'Imprenta'),
(50, 'Holding'),
(51, 'Inmobiliaria'),
(52, 'Siderurgia'),
(53, 'Textil'),
(60, 'Agro-Industrial'),
(70, 'Gastronomia'),
(71, 'Alimenticia'),
(72, 'Artesanal'),
(73, 'Información e Investigación'),
(75, 'Correo'),
(76, 'Editorial'),
(77, 'Ganadería'),
(78, 'AFJP'),
(79, 'Higiene y Perfumería'),
(80, 'Papelera'),
(81, 'Laboratorio'),
(82, 'Petroquímica'),
(83, 'Retail'),
(84, 'Transportadora'),
(85, 'Tabacalera'),
(87, 'Plásticos');

-- --------------------------------------------------------

--
-- Table structure for table `laboral_nivelespuestos`
--

CREATE TABLE IF NOT EXISTS `laboral_nivelespuestos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=37 ;

--
-- Dumping data for table `laboral_nivelespuestos`
--

INSERT INTO `laboral_nivelespuestos` (`id`, `denominacion`) VALUES
(1, 'Analista Junior'),
(2, 'Analista Semi Senior'),
(3, 'Analista Senior'),
(4, 'Asesor'),
(5, 'Asistente'),
(7, 'Becario'),
(10, 'Consultor'),
(11, 'Coordinador de Area / Sección / Depto.'),
(12, 'Director de Area'),
(13, 'Director de División'),
(14, 'Director General'),
(15, 'Encargado'),
(16, 'Gerente de Area'),
(17, 'Gerente de División'),
(18, 'Gerente General'),
(19, 'Jefe Area / Sección / Depto.'),
(20, 'Joven Profesional'),
(21, 'Líder de Proyecto'),
(25, 'Otro'),
(26, 'Pasante'),
(27, 'Presidente / Director Ejecutivo'),
(28, 'Recepcionista'),
(29, 'Secretaria'),
(30, 'Secretaria Bilingüe'),
(31, 'Secretaria de Directorio'),
(32, 'Socio'),
(33, 'Subgerente Area'),
(34, 'Supervisor'),
(35, 'Trainee / Práctica Profesional'),
(36, 'Vicepresidente');

-- --------------------------------------------------------

--
-- Table structure for table `laboral_tipostrabajos`
--

CREATE TABLE IF NOT EXISTS `laboral_tipostrabajos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `laboral_tipostrabajos`
--

INSERT INTO `laboral_tipostrabajos` (`id`, `denominacion`) VALUES
(1, 'Media Jornada'),
(2, 'Jornada completa'),
(3, 'Temporario'),
(4, 'Contrato a Plazo fijo');

-- --------------------------------------------------------

--
-- Table structure for table `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `usuario_interno_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `texto` longtext NOT NULL,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notas_procesos`
--

CREATE TABLE IF NOT EXISTS `notas_procesos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nota` text NOT NULL,
  `proceso_id` int(10) unsigned NOT NULL,
  `usuarios_internos_id` int(10) unsigned NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `notas_procesos`
--

INSERT INTO `notas_procesos` (`id`, `nota`, `proceso_id`, `usuarios_internos_id`, `created`, `deleted`) VALUES
(1, 'Primera nota de prueba Ã±', 1, 1, '2008-07-18 12:31:00', NULL),
(2, 'Esta es otra nota. \nCon enters y cosas', 1, 1, '2008-07-18 21:44:12', NULL),
(3, 'Otra mas con mucho contenido\nOtra mas con mucho contenido\nOtra mas con mucho contenido\nOtra mas con mucho contenido\nOtra mas con mucho contenido\nOtra mas con mucho contenido\n', 1, 1, '2008-07-18 21:46:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1001 ;

--
-- Dumping data for table `paises`
--

INSERT INTO `paises` (`id`, `denominacion`) VALUES
(1, 'Argentina'),
(2, 'Brasil'),
(5, 'Bolivia'),
(7, 'Chile'),
(8, 'Colombia'),
(9, 'Ecuador'),
(10, 'Paraguay'),
(11, 'Perú'),
(12, 'Uruguay'),
(13, 'Venezuela'),
(14, 'Costa Rica'),
(15, 'El Salvador'),
(16, 'Guatemala'),
(17, 'Honduras'),
(18, 'Mexico'),
(19, 'Nicaragua'),
(20, 'Panamá'),
(21, 'Espana'),
(22, 'Portugal'),
(23, 'Canada'),
(24, 'Estados Unidos'),
(25, 'Francia'),
(26, 'Italia'),
(27, 'Puerto Rico'),
(28, 'Republica Dominicana'),
(29, 'Cuba'),
(30, 'Australia'),
(31, 'Austria'),
(32, 'Inglaterra'),
(33, 'Dinamarca'),
(34, 'Alemania'),
(35, 'Grecia'),
(36, 'Suiza'),
(37, 'Rusia'),
(38, 'Holanda'),
(39, 'Japon'),
(40, 'Israel'),
(50, 'Polonia'),
(52, 'China'),
(53, 'Bélgica'),
(54, 'Bulgaria'),
(56, 'Croacia'),
(57, 'Eslovaquia'),
(58, 'Eslovenia'),
(59, 'Estonia'),
(60, 'Finlandia'),
(61, 'Hungria'),
(62, 'India'),
(63, 'Irlanda'),
(64, 'Letonia'),
(65, 'Lituania'),
(66, 'Noruega'),
(67, 'Nueva Zelanda'),
(68, 'Corea'),
(69, 'Rumania'),
(70, 'Singapur'),
(71, 'Escocia'),
(73, 'Suecia'),
(74, 'Irak'),
(75, 'Emiratos Arabes'),
(1000, 'Internacional');

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permisos`
--

INSERT INTO `permisos` (`id`, `denominacion`) VALUES
(1, 'Todos'),
(2, 'Yo'),
(3, 'Especifico');

-- --------------------------------------------------------

--
-- Table structure for table `preferencias_areas`
--

CREATE TABLE IF NOT EXISTS `preferencias_areas` (
  `preferencia_id` int(10) unsigned NOT NULL DEFAULT '0',
  `area_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`preferencia_id`,`area_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preferencias_laborales`
--

CREATE TABLE IF NOT EXISTS `preferencias_laborales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sueldo_bruto` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pref_usu_FK` (`usuario_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `preferencias_laborales`
--

INSERT INTO `preferencias_laborales` (`id`, `usuario_id`, `sueldo_bruto`) VALUES
(1, 1, NULL),
(2, 5, 9500),
(3, 8, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `preferencias_nivelespuestos`
--

CREATE TABLE IF NOT EXISTS `preferencias_nivelespuestos` (
  `nivel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `preferencia_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`nivel_id`,`preferencia_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preferencias_tipostrabajos`
--

CREATE TABLE IF NOT EXISTS `preferencias_tipostrabajos` (
  `preferencia_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tipo_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`preferencia_id`,`tipo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presentaciones`
--

CREATE TABLE IF NOT EXISTS `presentaciones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `descripcion` text COLLATE latin1_spanish_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pres_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) DEFAULT NULL,
  `descripcion` text,
  `prod_categoria_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `denominacion`, `descripcion`, `prod_categoria_id`) VALUES
(1, 'Plan Premium (1 aviso)', '1 aviso', 1),
(2, 'Plan Premium (5 avisos)', '5 avisos', 1),
(3, 'Plan Premium (10 avisos)', '10 avisos', 1),
(4, 'Plan Destacado (1 aviso)', '1 aviso', 2),
(5, 'Plan Destacado (5 avisos)', '5 avisos', 2),
(6, 'Plan Destacado (10 avisos)', '10 avisos', 2),
(7, 'Suscripcion 1 mes', '1 mes', 3),
(8, 'Suscripcion 3 meses', '3 meses', 3),
(9, 'Suscripcion 6 meses', '6 meses', 3),
(10, 'Suscripcion 12 meses', '12 meses', 3);

-- --------------------------------------------------------

--
-- Table structure for table `prod_categorias`
--

CREATE TABLE IF NOT EXISTS `prod_categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `prod_categorias`
--

INSERT INTO `prod_categorias` (`id`, `denominacion`) VALUES
(1, 'Plan Premuim'),
(2, 'Plan Destacado'),
(3, 'Suscripción');

-- --------------------------------------------------------

--
-- Table structure for table `prod_config`
--

CREATE TABLE IF NOT EXISTS `prod_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `dias_vigencia` int(11) DEFAULT NULL,
  `importe` float DEFAULT NULL,
  `nivel_destacado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `prod_config`
--

INSERT INTO `prod_config` (`id`, `producto_id`, `cantidad`, `dias_vigencia`, `importe`, `nivel_destacado`) VALUES
(1, 1, 1, NULL, 100, 2),
(2, 2, 5, NULL, 7000, 2),
(3, 3, 10, NULL, 30000, 2),
(4, 4, 1, NULL, 700, 1),
(5, 5, 5, NULL, 1000, 1),
(6, 6, 10, NULL, 1900, 1),
(7, 7, NULL, 30, 1, 0),
(8, 8, NULL, 90, 1, 0),
(9, 9, NULL, 180, 1, 0),
(10, 10, NULL, 365, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pais_id` int(10) unsigned NOT NULL DEFAULT '0',
  `denominacion` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=508 ;

--
-- Dumping data for table `provincias`
--

INSERT INTO `provincias` (`id`, `pais_id`, `denominacion`) VALUES
(1, 1, 'Buenos Aires'),
(2, 1, 'La Pampa'),
(3, 1, 'Capital Federal'),
(4, 1, 'Cordoba'),
(5, 1, 'Catamarca'),
(6, 1, 'Chaco'),
(7, 1, 'Chubut'),
(8, 1, 'Corrientes'),
(9, 1, 'Entre Ríos'),
(10, 1, 'Formosa'),
(11, 1, 'Jujuy'),
(12, 1, 'La Rioja'),
(13, 1, 'Mendoza'),
(14, 1, 'Misiones'),
(15, 1, 'Neuquen'),
(16, 1, 'Rio Negro'),
(17, 1, 'Salta'),
(18, 1, 'San Juan'),
(19, 1, 'San Luis'),
(20, 1, 'Santa Cruz'),
(21, 1, 'Santa Fe'),
(22, 1, 'Santiago del Estero'),
(23, 1, 'Tierra del Fuego'),
(24, 1, 'Tucuman'),
(25, 18, 'Aguascalientes'),
(26, 18, 'Baja California Norte'),
(27, 18, 'Baja California Sur'),
(28, 18, 'Campeche'),
(29, 18, 'Chiapas'),
(30, 18, 'Chihuahua'),
(31, 18, 'Coahuila'),
(32, 18, 'Colima'),
(33, 18, 'Distrito Federal'),
(34, 18, 'Durango'),
(35, 18, 'Guanajuato'),
(36, 18, 'Guerrero'),
(37, 18, 'Hidalgo'),
(38, 18, 'Jalisco'),
(39, 18, 'Estado de Mexico'),
(40, 18, 'Michoacán'),
(41, 18, 'Morelos'),
(42, 18, 'Nayarit'),
(43, 18, 'Nuevo Leon'),
(44, 18, 'Oaxaca'),
(45, 18, 'Puebla'),
(46, 18, 'Queretaro'),
(47, 18, 'Quintana Roo'),
(48, 18, 'San Luis Potosí'),
(49, 18, 'Sinaloa'),
(50, 18, 'Sonora'),
(51, 18, 'Tabasco'),
(52, 18, 'Tamaulipas'),
(53, 18, 'Tlaxcala'),
(54, 18, 'Veracruz'),
(55, 18, 'Yucatán'),
(56, 18, 'Zacatecas'),
(57, 12, 'Artigas'),
(58, 12, 'Canelones'),
(59, 12, 'Cerrolargo'),
(60, 12, 'Colonia'),
(61, 12, 'Durazno'),
(62, 12, 'Flores'),
(63, 12, 'Florida'),
(64, 12, 'Piedra Alta'),
(65, 12, 'Lavalleja'),
(66, 12, 'Maldonado'),
(67, 12, 'Rio negro'),
(68, 12, 'Rocha'),
(69, 12, 'Rivera'),
(70, 12, 'Soriano'),
(71, 12, 'Salto'),
(72, 12, 'Tacuarembo'),
(73, 12, 'Montevideo'),
(74, 12, 'Paysandu'),
(75, 12, 'San Jose'),
(76, 12, 'Soriano'),
(77, 12, 'Treinta y Tres'),
(78, 21, 'Alava'),
(79, 21, 'Albacete'),
(80, 21, 'Alicante'),
(81, 21, 'Almería'),
(82, 21, 'Asturias'),
(83, 21, 'Ávila'),
(84, 21, 'Badajoz'),
(85, 21, 'Islas Baleares'),
(86, 21, 'Barcelona'),
(87, 21, 'Burgos'),
(88, 21, 'Cáceres'),
(89, 21, 'Cádiz'),
(90, 21, 'Cantabria'),
(91, 21, 'Castellón'),
(92, 21, 'Ceuta'),
(93, 21, 'Ciudad Real'),
(94, 21, 'Córdoba'),
(95, 21, 'Cuenca'),
(96, 21, 'Gerona'),
(97, 21, 'Granada'),
(98, 21, 'Guadalajara'),
(99, 21, 'Guipúzcoa'),
(100, 21, 'Huelva'),
(101, 21, 'Huesca'),
(102, 21, 'Jaén'),
(103, 21, 'La Coruña'),
(104, 21, 'La Rioja'),
(105, 21, 'Las Palmas'),
(106, 21, 'León'),
(107, 21, 'Lérida'),
(108, 21, 'Lugo'),
(109, 21, 'Madrid'),
(110, 21, 'Málaga'),
(111, 21, 'Murcia'),
(112, 21, 'Navarra'),
(113, 21, 'Orense'),
(114, 21, 'Palencia'),
(115, 21, 'Pontevedra'),
(116, 21, 'Salamanca'),
(117, 21, 'Segovia'),
(118, 21, 'Sevilla'),
(119, 21, 'Soria'),
(120, 21, 'Tarragona'),
(121, 21, 'Teruel'),
(122, 21, 'Toledo'),
(123, 21, 'Valencia'),
(124, 21, 'Valladolid'),
(125, 21, 'Vizcaya'),
(126, 21, 'Zamora'),
(127, 21, 'Zaragoza'),
(128, 2, 'Acre'),
(129, 2, 'Alagoas'),
(130, 2, 'Amapá'),
(131, 2, 'Amazonas'),
(132, 2, 'Bahia'),
(133, 2, 'Ceará'),
(134, 2, 'Distrito Federal'),
(135, 2, 'Espírito Santo'),
(136, 2, 'Goiás'),
(137, 2, 'Maranhão'),
(138, 2, 'Mato Grosso'),
(139, 2, 'Mato Grosso do Sul'),
(140, 2, 'Minas Gerais'),
(141, 2, 'Pará'),
(142, 2, 'Paraíba'),
(143, 2, 'Paraná'),
(144, 2, 'Pernambuco'),
(145, 2, 'Piauí'),
(146, 2, 'Rio de Janeiro'),
(147, 2, 'Rio Grande do Norte'),
(148, 2, 'Rio Grande do Sul'),
(149, 2, 'Rondônia'),
(150, 2, 'Roraima'),
(151, 2, 'Santa Catarina'),
(152, 2, 'São Paulo'),
(153, 2, 'Sergipe'),
(154, 2, 'Tocantins'),
(155, 7, 'I Región'),
(156, 7, 'II Región'),
(157, 7, 'III Región'),
(158, 7, 'IV Región'),
(159, 7, 'V Región'),
(160, 7, 'VI Región'),
(161, 7, 'VII Región'),
(162, 7, 'VIII Región'),
(163, 7, 'IX Región'),
(164, 7, 'X Región'),
(165, 7, 'Región Metropolitana'),
(166, 7, 'XI Región'),
(167, 7, 'XII Región'),
(168, 13, 'Anzoátegui'),
(169, 13, 'Aragua'),
(170, 13, 'Barinas'),
(171, 13, 'Bolívar'),
(172, 13, 'Carabobo'),
(173, 13, 'Distrito Capital'),
(174, 13, 'Falcón'),
(175, 13, 'Lara'),
(176, 13, 'Mérida'),
(177, 13, 'Miranda'),
(178, 13, 'Monagas'),
(179, 13, 'Nueva Esparta'),
(180, 13, 'Portuguesa'),
(181, 13, 'Sucre'),
(182, 13, 'Táchira'),
(183, 13, 'Trujillo'),
(184, 13, 'Vargas'),
(185, 13, 'Yaracuy'),
(186, 13, 'Zulia'),
(187, 5, 'Chuquisaca'),
(188, 5, 'Cochabamba'),
(189, 5, 'La Paz'),
(190, 5, 'Oruro'),
(191, 5, 'Potosí'),
(192, 5, 'Santa Cruz'),
(193, 5, 'Tarija'),
(194, 14, 'Alajuela'),
(195, 14, 'Cartago'),
(196, 14, 'Guanacaste'),
(197, 14, 'Heredia'),
(198, 14, 'Limón'),
(199, 14, 'Puntarenas'),
(200, 14, 'San José'),
(201, 10, 'Alto Paraná'),
(202, 10, 'Caaguazú'),
(203, 10, 'Central'),
(204, 10, 'Guairá'),
(205, 10, 'Itapúa'),
(206, 22, 'Lisboa'),
(207, 22, 'Oporto'),
(208, 22, 'Portel'),
(209, 27, 'Aguada'),
(210, 27, 'Aguadilla'),
(211, 27, 'Arecibo'),
(212, 27, 'Arroyo'),
(213, 27, 'Barranquitas'),
(214, 27, 'Bayamón'),
(215, 27, 'Cabo Rojo'),
(216, 27, 'Caguas'),
(217, 27, 'Camuy'),
(218, 27, 'Canóvanas'),
(219, 27, 'Carolina'),
(220, 27, 'Cataño'),
(221, 27, 'Cayey'),
(222, 27, 'Ceiba'),
(223, 27, 'Ciales'),
(224, 27, 'Coamo'),
(225, 27, 'Dorado'),
(226, 27, 'Guaynabo'),
(227, 27, 'Gurabo'),
(228, 27, 'Hatillo'),
(229, 27, 'Humacao'),
(230, 27, 'Isabela'),
(231, 27, 'Juana Díaz'),
(232, 27, 'Lares'),
(233, 27, 'Manatí'),
(234, 27, 'Maricao'),
(235, 27, 'Maunabo'),
(236, 27, 'Mayagüez'),
(237, 27, 'Naranjito'),
(238, 27, 'Orocovis'),
(239, 27, 'Ponce'),
(240, 27, 'Quebradillas'),
(241, 27, 'Rincón'),
(242, 27, 'San Germán'),
(243, 27, 'San Juan'),
(244, 27, 'San Lorenzo'),
(245, 27, 'Utuado'),
(246, 11, 'Ancash'),
(247, 11, 'Arequipa'),
(248, 11, 'Callao (Provincia Constitucional)'),
(249, 11, 'Cusco'),
(250, 11, 'Huancavelica'),
(251, 11, 'Ica'),
(252, 11, 'Junín'),
(253, 11, 'La Libertad'),
(254, 11, 'Lambayeque'),
(255, 11, 'Lima'),
(256, 11, 'Loreto'),
(257, 11, 'Madre de Dios'),
(258, 11, 'Piura'),
(259, 11, 'Puno'),
(260, 11, 'San Martin'),
(261, 11, 'Tacna'),
(262, 16, 'Guatemala'),
(263, 16, 'Huehuetenango'),
(264, 16, 'Jalapa'),
(265, 16, 'Sacatepéquez'),
(266, 16, 'Sololá'),
(267, 28, 'Distrito Nacional'),
(268, 28, 'La Vega'),
(269, 28, 'Puerto Plata'),
(270, 28, 'Salcedo'),
(271, 28, 'San Pedro de Macorís'),
(272, 28, 'Santiago'),
(273, 15, 'La Libertad'),
(274, 15, 'San Salvador'),
(275, 15, 'San Vicente'),
(276, 29, 'La Habana'),
(277, 29, 'Matanzas'),
(278, 20, 'Colón'),
(279, 20, 'Herrera'),
(280, 20, 'Panamá'),
(281, 8, 'Antioquia'),
(282, 8, 'Arauca'),
(283, 8, 'Atlántico'),
(284, 8, 'Bolívar'),
(285, 8, 'Boyacá'),
(286, 8, 'Caldas'),
(287, 8, 'Casanare'),
(288, 8, 'Cauca'),
(289, 8, 'Cesar'),
(290, 8, 'Córdoba'),
(291, 8, 'Cundinamarca'),
(292, 8, 'Huila'),
(293, 8, 'Magdalena'),
(294, 8, 'Meta'),
(295, 8, 'Nariño'),
(296, 8, 'Norte de Santander'),
(297, 8, 'Quindío'),
(298, 8, 'Risaralda'),
(299, 8, 'San Andrés y Providencia'),
(300, 8, 'Santander'),
(301, 8, 'Sucre'),
(302, 8, 'Tolima'),
(303, 8, 'Valle del Cauca'),
(304, 24, 'Alabama'),
(305, 24, 'Alaska'),
(306, 24, 'Arizona'),
(307, 24, 'Arkansas'),
(308, 24, 'California'),
(309, 24, 'Colorado'),
(310, 24, 'Connecticut'),
(311, 24, 'Delaware'),
(312, 24, 'Florida'),
(313, 24, 'Georgia'),
(314, 24, 'Hawaii'),
(315, 24, 'Idaho'),
(316, 24, 'Illinois'),
(317, 24, 'Indiana'),
(318, 24, 'Iowa'),
(319, 24, 'Kansas'),
(320, 24, 'Kentucky'),
(321, 24, 'Louisiana'),
(322, 24, 'Maine'),
(323, 24, 'Maryland'),
(324, 24, 'Massachusetts'),
(325, 24, 'Michigan'),
(326, 24, 'Minnesota'),
(327, 24, 'Mississippi'),
(328, 24, 'Missouri'),
(329, 24, 'Montana'),
(330, 24, 'Nebraska'),
(331, 24, 'Nevada'),
(332, 24, 'New Hampshire'),
(333, 24, 'New Jersey'),
(334, 24, 'New Mexico'),
(335, 24, 'New York'),
(336, 24, 'North Carolina'),
(337, 24, 'North Dakota'),
(338, 24, 'Ohio'),
(339, 24, 'Oklahoma'),
(340, 24, 'Oregon'),
(341, 24, 'Pennsylvania'),
(342, 24, 'Rhode Island'),
(343, 24, 'South Carolina'),
(344, 24, 'South Dakota'),
(345, 24, 'Tennessee'),
(346, 24, 'Texas'),
(347, 24, 'Utah'),
(348, 24, 'Vermont'),
(349, 24, 'Virginia'),
(350, 24, 'Washington'),
(351, 24, 'Washington,D.C.'),
(352, 24, 'West Virginia'),
(353, 24, 'Wisconsin'),
(354, 24, 'Wyoming'),
(355, 17, 'Provincias'),
(356, 19, 'Provincias'),
(357, 23, 'Provincias'),
(358, 25, 'Provincias'),
(359, 26, 'Provincias'),
(360, 30, 'Provincias'),
(361, 31, 'Provincias'),
(362, 32, 'Provincias'),
(363, 33, 'Provincias'),
(364, 34, 'Provincias'),
(365, 35, 'Provincias'),
(366, 36, 'Provincias'),
(367, 37, 'Provincias'),
(368, 38, 'Otra'),
(369, 39, 'Provincias'),
(370, 18, 'Guadalajara'),
(371, 18, 'Monterrey'),
(372, 13, 'Amazonas'),
(373, 13, 'Delta Amacuro'),
(374, 13, 'Apure'),
(375, 13, 'Guarico'),
(376, 50, 'Provincias'),
(377, 1000, 'Provincias'),
(378, 21, 'Melilla'),
(379, 21, 'Tenerife'),
(380, 52, 'Beijing'),
(381, 53, 'Brussels'),
(382, 54, 'Burgas'),
(383, 53, 'Antwerpen'),
(384, 54, 'Grad Sofiya'),
(385, 53, 'Brabant Wallon'),
(386, 54, 'Khaskovo'),
(387, 53, 'Hainaut'),
(388, 54, 'Lovech'),
(389, 53, 'Liege'),
(390, 54, 'Montana'),
(391, 53, 'Limburg'),
(392, 54, 'Plovdiv'),
(393, 53, 'Luxembourg'),
(394, 54, 'Ruse'),
(395, 53, 'Namur'),
(396, 54, 'Sofiya'),
(397, 53, 'Oost-Vlaanderen'),
(398, 54, 'Varna'),
(399, 53, 'Vlaams Brabant'),
(400, 53, 'West-Vlaanderen'),
(401, 56, 'Zagreb'),
(402, 57, 'Bratislava'),
(403, 58, 'Ljubljana'),
(404, 59, 'Tallinn'),
(405, 60, 'Helsinki'),
(406, 61, 'Budapest'),
(407, 62, 'New Delhi'),
(408, 64, 'Riga'),
(409, 63, 'Dublin'),
(410, 65, 'Vilnius'),
(411, 66, 'Oslo'),
(412, 67, 'Wellington'),
(413, 68, 'Pyongyang'),
(414, 69, 'Bucharest'),
(415, 70, 'Singapore'),
(416, 52, 'Provincias'),
(417, 53, 'Provincias'),
(418, 54, 'Provincias'),
(419, 56, 'Provincias'),
(420, 57, 'Provincias'),
(421, 58, 'Provincias'),
(422, 59, 'Provincias'),
(423, 60, 'Provincias'),
(424, 61, 'Provincias'),
(425, 63, 'Provincias'),
(426, 64, 'Provincias'),
(427, 64, 'Provincias'),
(428, 65, 'Provincias'),
(429, 66, 'Provincias'),
(430, 67, 'Provincias'),
(431, 68, 'Provincias'),
(432, 69, 'Provincias'),
(433, 70, 'Provincias'),
(434, 5, 'Beni'),
(435, 5, 'Pando'),
(436, 11, 'Amazonas'),
(437, 11, 'Apurimac'),
(438, 11, 'Ayacucho'),
(439, 11, 'Cajamarca'),
(440, 11, 'Huánuco'),
(441, 11, 'Moquegua'),
(442, 11, 'Pasco'),
(443, 11, 'Tumbes'),
(444, 11, 'Ucayali'),
(445, 9, 'Archipiélago Galápagos'),
(446, 9, 'Azuay'),
(447, 9, 'Bolívar'),
(448, 9, 'Cañar'),
(449, 9, 'Carchi'),
(450, 9, 'Cotopaxi'),
(451, 9, 'Chimbonazo'),
(452, 9, 'El Oro'),
(453, 9, 'Esmeraldas'),
(454, 9, 'Guayas'),
(455, 9, 'Imbabura'),
(456, 9, 'Loja'),
(457, 9, 'Los Ríos'),
(458, 9, 'Manabí'),
(459, 9, 'Morona Santiago'),
(460, 9, 'Napo'),
(461, 9, 'Orellana'),
(462, 9, 'Pastaza'),
(463, 9, 'Pichincha'),
(464, 9, 'Sucumbíos'),
(465, 9, 'Tungurahua'),
(466, 9, 'Zamora Chinchipe'),
(467, 13, 'Cojedes'),
(468, 71, 'Provincias'),
(469, 73, 'Blekinge'),
(470, 73, 'Bohuslän'),
(471, 73, 'Dalarna'),
(472, 73, 'Dalecarlia'),
(473, 73, 'Dalsland'),
(474, 73, 'Gotland'),
(475, 73, 'Gästrikland'),
(476, 73, 'Halland'),
(477, 73, 'Hälsingland'),
(478, 73, 'Härjedalen'),
(479, 73, 'Jämtland'),
(480, 73, 'Lappland'),
(481, 73, 'Medelpad'),
(482, 73, 'Norrbotten'),
(483, 73, 'Närke'),
(484, 73, 'Skåne'),
(485, 73, 'Småland'),
(486, 73, 'Södermanland'),
(487, 73, 'Uppland'),
(488, 73, 'Värmland'),
(489, 73, 'Västerbotten'),
(490, 73, 'Västmanland'),
(491, 73, 'Ångermanland'),
(492, 73, 'Öland'),
(493, 73, 'Östergötland'),
(494, 74, 'Provincias'),
(495, 75, 'Provincias'),
(496, 38, 'Drenthe'),
(497, 38, 'Flevoland'),
(498, 38, 'Friesland'),
(499, 38, 'Gelderland'),
(500, 38, 'Groningen'),
(501, 38, 'Limburg'),
(502, 38, 'Noord Brabant'),
(503, 38, 'Noord Holland'),
(504, 38, 'Overijssel'),
(505, 38, 'Utrecht'),
(506, 38, 'Zeeland'),
(507, 38, 'Zuid Holland');

-- --------------------------------------------------------

--
-- Table structure for table `referencias`
--

CREATE TABLE IF NOT EXISTS `referencias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `nombre` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `telefono` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ref_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(64) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `habilitado` tinyint(1) NOT NULL DEFAULT '1',
  `padre` text COLLATE latin1_spanish_ci NOT NULL,
  `profundidad` int(8) NOT NULL DEFAULT '0',
  `deleted` timestamp NULL DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `denominacion` (`denominacion`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `denominacion`, `habilitado`, `padre`, `profundidad`, `deleted`, `created`) VALUES
(1, 'Administrador', 1, '1', 0, NULL, '0000-00-00 00:00:00'),
(2, 'CEO', 1, '2', 0, NULL, '0000-00-00 00:00:00'),
(3, 'Gerente Comercial', 1, '3', 0, NULL, '0000-00-00 00:00:00'),
(4, 'Consultor Comercial', 1, '4', 0, NULL, '0000-00-00 00:00:00'),
(5, 'Gerente de RRHH', 1, '5', 0, NULL, '0000-00-00 00:00:00'),
(6, 'Selector', 1, '6', 0, NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sexos`
--

CREATE TABLE IF NOT EXISTS `sexos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(16) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sexos`
--

INSERT INTO `sexos` (`id`, `denominacion`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE IF NOT EXISTS `slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(512) NOT NULL,
  `url` varchar(512) DEFAULT NULL,
  `borrador` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `image`, `url`, `borrador`) VALUES
(9, 'slide-1.png', 'javascript:ToogleRegisterPopup();', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tiposdocumentos`
--

CREATE TABLE IF NOT EXISTS `tiposdocumentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tiposdocumentos`
--

INSERT INTO `tiposdocumentos` (`id`, `denominacion`) VALUES
(1, 'Licencia'),
(2, 'Credencial de elector'),
(3, 'Pasaporte'),
(4, 'CURP');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `password` varchar(512) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `token` varchar(1024) COLLATE latin1_spanish_ci DEFAULT NULL,
  `datos_minimos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usu_mail_unique` (`email`),
  KEY `usu_ema_pass` (`email`,`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `created`, `modified`, `deleted`, `token`, `datos_minimos`) VALUES
(1, 'email@email.com', '912ec803b2ce49e4a541068d495ab570', '2014-12-12 11:55:25', '2014-12-12 11:55:25', NULL, NULL, 0),
(2, 'nskolaris@enclave.com.ar', '81dc9bdb52d04dc20036dbd8313ed055', '2015-05-28 17:13:35', '2015-05-28 17:24:56', NULL, '25b0427302fffdbc01e561df2c994b81', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_datospersonales`
--

CREATE TABLE IF NOT EXISTS `usuarios_datospersonales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `apellido` varchar(64) COLLATE latin1_spanish_ci DEFAULT NULL,
  `ciudad` varchar(128) COLLATE latin1_spanish_ci DEFAULT NULL,
  `codigo_postal` varchar(16) COLLATE latin1_spanish_ci DEFAULT NULL,
  `cuil` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `dispuesto_reubicacion` tinyint(1) DEFAULT NULL,
  `domicilio` text COLLATE latin1_spanish_ci,
  `estadocivil_id` int(10) unsigned NOT NULL DEFAULT '0',
  `fnacimiento` date DEFAULT NULL,
  `nrodocumento` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pais_nacionalidad_id` int(10) unsigned NOT NULL DEFAULT '0',
  `posee_licenciaconducir` tinyint(1) DEFAULT NULL,
  `provincia_residencia_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sexo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `telefono_hogar` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `telefono_celular` varchar(32) COLLATE latin1_spanish_ci DEFAULT NULL,
  `tipodocumento_id` int(10) unsigned NOT NULL DEFAULT '0',
  `usuario_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dat_usu_FK` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_internos`
--

CREATE TABLE IF NOT EXISTS `usuarios_internos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` text COLLATE latin1_spanish_ci NOT NULL,
  `telefono` varchar(255) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol_id` int(8) NOT NULL DEFAULT '1',
  `deleted` timestamp NULL DEFAULT NULL,
  `empresa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
