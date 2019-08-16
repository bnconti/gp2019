-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2019 at 02:22 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdp`
--

-- --------------------------------------------------------

--
-- Table structure for table `autor_publicaciones`
--

CREATE TABLE `autor_publicaciones` (
  `persona_id` int(11) NOT NULL,
  `publicaciones_id` int(11) NOT NULL,
  `rol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `autor_publicaciones`
--

INSERT INTO `autor_publicaciones` (`persona_id`, `publicaciones_id`, `rol`) VALUES
(3, 2, 'Autor'),
(6, 1, 'Autor'),
(7, 2, 'Autor'),
(7, 4, 'Autor'),
(8, 3, 'Autor'),
(9, 4, 'Autor');

-- --------------------------------------------------------

--
-- Stand-in structure for view `codirectorproyecto`
-- (See below for the actual view)
--
CREATE TABLE `codirectorproyecto` (
`id` int(11)
,`nombre` varchar(45)
,`apellido` varchar(45)
,`proyectoid` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `instituciones`
--

CREATE TABLE `instituciones` (
  `id` int(11) NOT NULL,
  `institucion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instituciones`
--

INSERT INTO `instituciones` (`id`, `institucion`) VALUES
(1, 'UNNOBA');

-- --------------------------------------------------------

--
-- Table structure for table `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `cant_volumenes` int(11) DEFAULT NULL,
  `cant_pags` int(11) NOT NULL,
  `referato` varchar(45) NOT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `libros`
--

INSERT INTO `libros` (`id`, `ISBN`, `cant_volumenes`, `cant_pags`, `referato`, `publicaciones_id`) VALUES
(1, '9789873724312', 1, 320, 'No', 4);

-- --------------------------------------------------------

--
-- Table structure for table `partes_libros`
--

CREATE TABLE `partes_libros` (
  `id` int(11) NOT NULL,
  `titulo_parte` varchar(90) NOT NULL,
  `tipo_parte` varchar(45) NOT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `volumen` int(11) DEFAULT NULL,
  `tomo` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `cant_pags` int(11) NOT NULL,
  `pag_inicial` int(11) DEFAULT NULL,
  `pag_final` int(11) DEFAULT NULL,
  `referato` varchar(45) NOT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `cuit_cuil` varchar(45) NOT NULL,
  `usuarios_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`id`, `apellido`, `nombre`, `cuit_cuil`, `usuarios_id`) VALUES
(1, 'Conti', 'Bruno Nicolás', '20362788987', 1),
(2, 'Gómez', 'José', '20331112227', 2),
(3, 'Hugo', 'Ramón', '20251231237', NULL),
(4, 'Mónica', 'Sarobe', '20301231237', NULL),
(5, 'Mercedes', 'Guasch', '20251112227', NULL),
(6, 'Charne', 'Javier', '20247896547', NULL),
(7, 'Esnaola', 'Leonardo', '20304322237', NULL),
(8, 'Jaszczyszyn', 'Adrián', '20268651437', NULL),
(9, 'Ahmad', 'Tamara', '20289533457', NULL),
(10, 'Gutiérrez', 'María', '20304198797', 3);

-- --------------------------------------------------------

--
-- Table structure for table `personas_proyectos`
--

CREATE TABLE `personas_proyectos` (
  `personas_id` int(11) NOT NULL,
  `proyectos_id` int(11) NOT NULL,
  `funcion_desempeniada` varchar(45) DEFAULT NULL,
  `inicio_participacion` date DEFAULT NULL,
  `fin_participacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resolucion` varchar(45) NOT NULL,
  `expediente` varchar(45) NOT NULL,
  `tipo_actividad` varchar(45) DEFAULT NULL,
  `tipo_proyecto` varchar(45) DEFAULT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `director_id` int(11) NOT NULL,
  `codirector_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyectos`
--

INSERT INTO `proyectos` (`id`, `titulo`, `resolucion`, `expediente`, `tipo_actividad`, `tipo_proyecto`, `desde`, `hasta`, `descripcion`, `director_id`, `codirector_id`) VALUES
(1, 'Fenotipado de alta capacidad con relevamiento de datos en campo', '5122/2018', '2019/05', 'Investigación aplicada', 'Investigación', '2019-08-15', '2019-10-17', 'Proyectos de Innovación y Transferencia de Tecnología de la Región del Noroeste de Buenos Aires (PRITT NOBA). Entidad adoptante: INTA.', 3, 7),
(2, 'Informática y Tecnologías Emergentes', '1623/2019', '548/2019', 'Investigación aplicada', 'Voluntariado', '2019-08-01', '2019-10-23', 'Acreditado y Financiado por UNNOBA con evaluación externa en el marco de la convocatoria a Subsidios de Investigación Bianuales (SIB 2019)', 4, NULL),
(3, 'Vinculación interdisciplinaria Informática Enfermería', '1383/2017', '2629/17', 'Investigación aplicada', 'Extensión', '2019-08-15', '2020-03-17', 'Descripción de ejemplo', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `idioma` varchar(45) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `doi` varchar(45) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `resumen` text,
  `keywords` text,
  `pais_edicion` varchar(45) DEFAULT NULL,
  `editorial` varchar(45) DEFAULT NULL,
  `ciudad_edicion` varchar(45) DEFAULT NULL,
  `estado_publicacion` varchar(45) DEFAULT NULL,
  `impreso` tinyint(1) DEFAULT '0',
  `digital` tinyint(1) DEFAULT '0',
  `instituciones_id` int(11) DEFAULT NULL,
  `codirector_id` int(11) DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `proyectos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `titulo`, `idioma`, `fecha_publicacion`, `doi`, `url`, `resumen`, `keywords`, `pais_edicion`, `editorial`, `ciudad_edicion`, `estado_publicacion`, `impreso`, `digital`, `instituciones_id`, `codirector_id`, `director_id`, `proyectos_id`) VALUES
(1, 'Software Defined Storage', 'Inglés', '2019-08-01', '10.1234/99', NULL, 'Resumen de ejemplo', 'Redes', NULL, NULL, NULL, NULL, 0, 0, 1, NULL, 3, 2),
(2, 'Detección automática de emociones mediante algoritmos inteligentes', 'Español', '2019-08-02', NULL, NULL, 'Resumen de ejemplo', 'Tecnología, innovación', 'Argentina', 'UNNOBA', NULL, NULL, 1, 1, NULL, NULL, NULL, NULL),
(3, 'QoS in Linux: its application on free Internet infrastructure', 'Inglés', '2019-08-15', NULL, NULL, NULL, NULL, 'Argentina', 'Ejemplo', NULL, 'Publicado', 0, 1, NULL, NULL, NULL, NULL),
(4, 'Manual de uso docente UNNOBA', 'Español', '2019-08-15', NULL, NULL, NULL, NULL, 'Argentina', 'Editorial UNNOBA', NULL, 'Publicado', 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `revistas_articulos`
--

CREATE TABLE `revistas_articulos` (
  `id` int(11) NOT NULL,
  `titulo_revista` varchar(45) NOT NULL,
  `issn` varchar(45) DEFAULT NULL,
  `referato` varchar(250) NOT NULL,
  `pag_inicial` int(11) DEFAULT NULL,
  `pag_final` int(11) DEFAULT NULL,
  `volumen` int(11) DEFAULT NULL,
  `tomo` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `revistas_articulos`
--

INSERT INTO `revistas_articulos` (`id`, `titulo_revista`, `issn`, `referato`, `pag_inicial`, `pag_final`, `volumen`, `tomo`, `numero`, `publicaciones_id`) VALUES
(1, 'JCSYT', '12344321', 'Nacional', NULL, NULL, NULL, NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablaarticulos`
-- (See below for the actual view)
--
CREATE TABLE `tablaarticulos` (
`id` int(11)
,`titulo` varchar(200)
,`autores` text
,`titulo_revista` varchar(45)
,`editorial` varchar(45)
,`fecha` varchar(14)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablalibros`
-- (See below for the actual view)
--
CREATE TABLE `tablalibros` (
`id` int(11)
,`titulo` varchar(200)
,`autores` text
,`ISBN` varchar(45)
,`editorial` varchar(45)
,`anio` int(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablapartelibros`
-- (See below for the actual view)
--
CREATE TABLE `tablapartelibros` (
`id` int(11)
,`titulo_parte` varchar(90)
,`tipo_parte` varchar(45)
,`titulo` varchar(200)
,`autores` text
,`ISBN` varchar(45)
,`editorial` varchar(45)
,`anio` int(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablaproyectos`
-- (See below for the actual view)
--
CREATE TABLE `tablaproyectos` (
`id` int(11)
,`titulo` varchar(255)
,`resolucion` varchar(45)
,`expediente` varchar(45)
,`nombre` varchar(91)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablatesis`
-- (See below for the actual view)
--
CREATE TABLE `tablatesis` (
`id` int(11)
,`titulo` varchar(200)
,`autor` varchar(91)
,`fecha_publicacion` varchar(72)
,`nivel_educativo` varchar(45)
,`titulo_obtenido` varchar(100)
,`institucion` varchar(45)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `tablatrabajos`
-- (See below for the actual view)
--
CREATE TABLE `tablatrabajos` (
`id` int(11)
,`titulo` varchar(200)
,`autores` text
,`anio` int(4)
,`tipo_trabajo` varchar(45)
,`nombre_evento` varchar(100)
,`tipo_evento` varchar(45)
);

-- --------------------------------------------------------

--
-- Table structure for table `tesis_tesinas`
--

CREATE TABLE `tesis_tesinas` (
  `id` int(11) NOT NULL,
  `nivel_educativo` varchar(45) NOT NULL,
  `titulo_obtenido` varchar(100) DEFAULT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tesis_tesinas`
--

INSERT INTO `tesis_tesinas` (`id`, `nivel_educativo`, `titulo_obtenido`, `publicaciones_id`) VALUES
(1, 'Posgrado', 'Maestría', 1);

-- --------------------------------------------------------

--
-- Table structure for table `titulos`
--

CREATE TABLE `titulos` (
  `id` int(11) NOT NULL,
  `grado` varchar(45) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `instituciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trabajos_en_eventos`
--

CREATE TABLE `trabajos_en_eventos` (
  `id` int(11) NOT NULL,
  `tipo_trabajo` varchar(45) NOT NULL,
  `tipo_publicacion` varchar(45) NOT NULL,
  `titulo_librorevista` varchar(45) NOT NULL,
  `ISSN_ISBN` varchar(45) DEFAULT NULL,
  `nombre_evento` varchar(100) NOT NULL,
  `tipo_evento` varchar(45) NOT NULL,
  `alcance_geografico` varchar(45) NOT NULL,
  `pais_evento` varchar(45) NOT NULL,
  `ciudad_evento` varchar(45) DEFAULT NULL,
  `fecha_evento` date NOT NULL,
  `institucion_organizadora` varchar(100) DEFAULT NULL,
  `publicaciones_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trabajos_en_eventos`
--

INSERT INTO `trabajos_en_eventos` (`id`, `tipo_trabajo`, `tipo_publicacion`, `titulo_librorevista`, `ISSN_ISBN`, `nombre_evento`, `tipo_evento`, `alcance_geografico`, `pais_evento`, `ciudad_evento`, `fecha_evento`, `institucion_organizadora`, `publicaciones_id`) VALUES
(1, 'Artículo Completo', 'Revista', 'Revista UNNOBA', NULL, 'I Congreso Multidisciplinario de la UNNOBA', 'Conferencia', 'Nacional', 'Argentina', NULL, '2019-08-15', 'UNNOBA', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `gender`, `locale`, `picture`, `link`, `created`, `modified`) VALUES
(1, 'google', '106111728934417648822', 'Bruno Nicolás', 'Conti', 'bruno.n.conti@gmail.com', '', 'en', 'https://lh3.googleusercontent.com/-bRdvX01GaX8/AAAAAAAAAAI/AAAAAAAAAJA/pnMw_PFBtM8/photo.jpg', '', '2019-08-16 12:20:50', '2019-08-16 12:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `mail_itt` varchar(45) NOT NULL,
  `gmail` varchar(45) NOT NULL,
  `rol` varchar(45) NOT NULL,
  `cargo` varchar(45) NOT NULL,
  `dedicacion` varchar(45) NOT NULL,
  `aceptado` tinyint(1) NOT NULL,
  `es_admin` tinyint(1) NOT NULL,
  `remember_token` text,
  `timestamp` datetime DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail_itt`, `gmail`, `rol`, `cargo`, `dedicacion`, `aceptado`, `es_admin`, `remember_token`, `timestamp`, `password`) VALUES
(1, 'bnconti@comunidad.unnoba.edu.ar', 'bruno.n.conti@gmail.com', 'Becario de Posgrado', 'Profesor adjunto', 'Simple', 1, 1, NULL, NULL, '$2y$10$U5pUcCnWpqFQBA3u.yxhneF8Fj0MJx2gICzlB1XH5N9CleNWi6c92'),
(2, 'jgomez@comunidad.unnoba.edu.ar', 'jose_gomez@gmail.com', 'Personal de apoyo', 'Profesor adjunto', 'Semiexclusiva', 1, 0, NULL, NULL, '$2y$10$Txz8raRRuvSlZlOdNLzRHuvqWIea9HRf/fSYQ17ze3Rkg1avumTvS'),
(3, 'mgutierrez@comunidad.unnoba.edu.ar', 'mag@hotmail.com', 'Estudiante', 'Ayudante de segunda', 'Semiexclusiva', 0, 0, NULL, NULL, '$2y$10$Ka33GZhzHFkTNmTJadcVcebFw/V7GfoZ4aUcEPcTXQFtg6c0nrYlq');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_titulos`
--

CREATE TABLE `usuarios_titulos` (
  `usuarios_id` int(11) NOT NULL,
  `titulos_id` int(11) NOT NULL,
  `finalizado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `codirectorproyecto`
--
DROP TABLE IF EXISTS `codirectorproyecto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `codirectorproyecto`  AS  select `persona`.`id` AS `id`,`persona`.`nombre` AS `nombre`,`persona`.`apellido` AS `apellido`,`proyectos`.`id` AS `proyectoid` from (`persona` join `proyectos` on((`persona`.`id` = `proyectos`.`codirector_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `tablaarticulos`
--
DROP TABLE IF EXISTS `tablaarticulos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablaarticulos`  AS  select `art`.`id` AS `id`,`pu`.`titulo` AS `titulo`,group_concat(concat(`pe`.`nombre`,' ',`pe`.`apellido`) separator ', ') AS `autores`,`art`.`titulo_revista` AS `titulo_revista`,`pu`.`editorial` AS `editorial`,concat(monthname(`pu`.`fecha_publicacion`),'-',year(`pu`.`fecha_publicacion`)) AS `fecha` from (((`revistas_articulos` `art` join `publicaciones` `pu` on((`pu`.`id` = `art`.`publicaciones_id`))) join `autor_publicaciones` `autor` on((`pu`.`id` = `autor`.`publicaciones_id`))) join `persona` `pe` on((`pe`.`id` = `autor`.`persona_id`))) group by `art`.`id`,`pu`.`titulo`,`art`.`titulo_revista`,`pu`.`editorial`,concat(monthname(`pu`.`fecha_publicacion`),'-',year(`pu`.`fecha_publicacion`)) ;

-- --------------------------------------------------------

--
-- Structure for view `tablalibros`
--
DROP TABLE IF EXISTS `tablalibros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablalibros`  AS  select `l`.`id` AS `id`,`pu`.`titulo` AS `titulo`,group_concat(concat(`pe`.`nombre`,' ',`pe`.`apellido`) separator ', ') AS `autores`,`l`.`ISBN` AS `ISBN`,`pu`.`editorial` AS `editorial`,year(`pu`.`fecha_publicacion`) AS `anio` from (((`libros` `l` join `publicaciones` `pu` on((`pu`.`id` = `l`.`publicaciones_id`))) join `autor_publicaciones` `autor` on((`pu`.`id` = `autor`.`publicaciones_id`))) join `persona` `pe` on((`pe`.`id` = `autor`.`persona_id`))) group by `l`.`id`,`pu`.`titulo`,`l`.`ISBN`,`pu`.`editorial`,year(`pu`.`fecha_publicacion`) ;

-- --------------------------------------------------------

--
-- Structure for view `tablapartelibros`
--
DROP TABLE IF EXISTS `tablapartelibros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablapartelibros`  AS  select `p`.`id` AS `id`,`p`.`titulo_parte` AS `titulo_parte`,`p`.`tipo_parte` AS `tipo_parte`,`pu`.`titulo` AS `titulo`,group_concat(concat(`pe`.`nombre`,' ',`pe`.`apellido`) separator ', ') AS `autores`,`p`.`ISBN` AS `ISBN`,`pu`.`editorial` AS `editorial`,year(`pu`.`fecha_publicacion`) AS `anio` from (((`partes_libros` `p` join `publicaciones` `pu` on((`pu`.`id` = `p`.`publicaciones_id`))) join `autor_publicaciones` `autor` on((`pu`.`id` = `autor`.`publicaciones_id`))) join `persona` `pe` on((`pe`.`id` = `autor`.`persona_id`))) group by `p`.`id`,`p`.`titulo_parte`,`p`.`tipo_parte`,`pu`.`titulo`,`p`.`ISBN`,`pu`.`editorial`,year(`pu`.`fecha_publicacion`) ;

-- --------------------------------------------------------

--
-- Structure for view `tablaproyectos`
--
DROP TABLE IF EXISTS `tablaproyectos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablaproyectos`  AS  select `pro`.`id` AS `id`,`pro`.`titulo` AS `titulo`,`pro`.`resolucion` AS `resolucion`,`pro`.`expediente` AS `expediente`,concat(`per`.`nombre`,' ',`per`.`apellido`) AS `nombre` from (`proyectos` `pro` join `persona` `per` on((`per`.`id` = `pro`.`director_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `tablatesis`
--
DROP TABLE IF EXISTS `tablatesis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablatesis`  AS  select `te`.`id` AS `id`,`publi`.`titulo` AS `titulo`,concat(`pe`.`nombre`,' ',`pe`.`apellido`) AS `autor`,date_format(`publi`.`fecha_publicacion`,'%d-%M-%Y') AS `fecha_publicacion`,`te`.`nivel_educativo` AS `nivel_educativo`,`te`.`titulo_obtenido` AS `titulo_obtenido`,`insti`.`institucion` AS `institucion` from ((((`tesis_tesinas` `te` join `publicaciones` `publi` on((`publi`.`id` = `te`.`publicaciones_id`))) join `autor_publicaciones` `autor` on((`autor`.`publicaciones_id` = `publi`.`id`))) join `persona` `pe` on((`autor`.`persona_id` = `pe`.`id`))) join `instituciones` `insti` on((`publi`.`instituciones_id` = `insti`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `tablatrabajos`
--
DROP TABLE IF EXISTS `tablatrabajos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tablatrabajos`  AS  select `tra`.`id` AS `id`,`pu`.`titulo` AS `titulo`,group_concat(concat(`pe`.`nombre`,' ',`pe`.`apellido`) separator ', ') AS `autores`,year(`pu`.`fecha_publicacion`) AS `anio`,`tra`.`tipo_trabajo` AS `tipo_trabajo`,`tra`.`nombre_evento` AS `nombre_evento`,`tra`.`tipo_evento` AS `tipo_evento` from (((`trabajos_en_eventos` `tra` join `publicaciones` `pu` on((`pu`.`id` = `tra`.`publicaciones_id`))) join `autor_publicaciones` `autor` on((`pu`.`id` = `autor`.`publicaciones_id`))) join `persona` `pe` on((`pe`.`id` = `autor`.`persona_id`))) group by `tra`.`id`,`pu`.`titulo`,year(`pu`.`fecha_publicacion`),`tra`.`tipo_trabajo`,`tra`.`nombre_evento`,`tra`.`tipo_evento` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autor_publicaciones`
--
ALTER TABLE `autor_publicaciones`
  ADD PRIMARY KEY (`persona_id`,`publicaciones_id`),
  ADD KEY `fk_persona_has_publicaciones_publicaciones1_idx` (`publicaciones_id`),
  ADD KEY `fk_persona_has_publicaciones_persona1_idx` (`persona_id`);

--
-- Indexes for table `instituciones`
--
ALTER TABLE `instituciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_libros_publicaciones1_idx` (`publicaciones_id`);

--
-- Indexes for table `partes_libros`
--
ALTER TABLE `partes_libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_partes_libros_publicaciones1_idx` (`publicaciones_id`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_persona_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `personas_proyectos`
--
ALTER TABLE `personas_proyectos`
  ADD PRIMARY KEY (`personas_id`,`proyectos_id`),
  ADD KEY `fk_usuarios_has_proyectos_proyectos1_idx` (`proyectos_id`),
  ADD KEY `fk_usuarios_has_proyectos_personas1_idx` (`personas_id`) USING BTREE;

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proyectos_autoridades1_idx` (`director_id`),
  ADD KEY `fk_proyectos_autoridades2_idx` (`codirector_id`);

--
-- Indexes for table `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publicaciones_instituciones1_idx` (`instituciones_id`),
  ADD KEY `fk_publicaciones_persona1_idx` (`codirector_id`),
  ADD KEY `fk_publicaciones_persona2_idx` (`director_id`),
  ADD KEY `fk_publicaciones_proyectos1_idx` (`proyectos_id`);

--
-- Indexes for table `revistas_articulos`
--
ALTER TABLE `revistas_articulos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_revistas_articulos_publicaciones1_idx` (`publicaciones_id`);

--
-- Indexes for table `tesis_tesinas`
--
ALTER TABLE `tesis_tesinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tesis_tesinas_publicaciones1_idx` (`publicaciones_id`);

--
-- Indexes for table `titulos`
--
ALTER TABLE `titulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_titulos_instituciones_idx` (`instituciones_id`);

--
-- Indexes for table `trabajos_en_eventos`
--
ALTER TABLE `trabajos_en_eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_trabajos_en_eventos_publicaciones1_idx` (`publicaciones_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD UNIQUE KEY `mail_itt_UNIQUE` (`mail_itt`);

--
-- Indexes for table `usuarios_titulos`
--
ALTER TABLE `usuarios_titulos`
  ADD PRIMARY KEY (`usuarios_id`,`titulos_id`),
  ADD KEY `fk_usuarios_has_titulos_titulos1_idx` (`titulos_id`),
  ADD KEY `fk_usuarios_has_titulos_usuarios1_idx` (`usuarios_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instituciones`
--
ALTER TABLE `instituciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `partes_libros`
--
ALTER TABLE `partes_libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `revistas_articulos`
--
ALTER TABLE `revistas_articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tesis_tesinas`
--
ALTER TABLE `tesis_tesinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `titulos`
--
ALTER TABLE `titulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trabajos_en_eventos`
--
ALTER TABLE `trabajos_en_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `autor_publicaciones`
--
ALTER TABLE `autor_publicaciones`
  ADD CONSTRAINT `fk_persona_has_publicaciones_persona1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_persona_has_publicaciones_publicaciones1` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `fk_libros_publicaciones1` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `partes_libros`
--
ALTER TABLE `partes_libros`
  ADD CONSTRAINT `fk_partes_libros_publicaciones1` FOREIGN KEY (`publicaciones_id`) REFERENCES `publicaciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_persona_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_proyectos_autoridades1` FOREIGN KEY (`director_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proyectos_autoridades2` FOREIGN KEY (`codirector_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
