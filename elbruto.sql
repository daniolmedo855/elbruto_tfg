-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2025 a las 01:03:08
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `elbruto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

CREATE TABLE `animal` (
  `id_animal` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `danio` float NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `animal`
--

INSERT INTO `animal` (`id_animal`, `nombre`, `danio`, `imagen`) VALUES
(1, 'Oso', 1.5, 'animal_1.png'),
(2, 'Lobo', 1.1, 'animal_2.png'),
(3, 'Perro', 0.8, 'animal_3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspecto`
--

CREATE TABLE `aspecto` (
  `id_aspecto` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aspecto`
--

INSERT INTO `aspecto` (`id_aspecto`, `imagen`) VALUES
(1, 'aspecto_1.png'),
(2, 'aspecto_2.png'),
(3, 'aspecto_3.png'),
(4, 'aspecto_4.png'),
(5, 'aspecto_5.png'),
(6, 'aspecto_6.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bruto`
--

CREATE TABLE `bruto` (
  `id_bruto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT 1 CHECK (`nivel` between 1 and 100),
  `vida` int(11) NOT NULL DEFAULT 50,
  `fuerza` int(11) NOT NULL DEFAULT 1,
  `velocidad` int(11) NOT NULL DEFAULT 1,
  `puntos_arena` int(11) NOT NULL DEFAULT 0,
  `experiencia` int(11) NOT NULL DEFAULT 0 CHECK (`experiencia` between 0 and 10),
  `id_usuario` int(11) NOT NULL,
  `id_aspecto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bruto`
--

INSERT INTO `bruto` (`id_bruto`, `nombre`, `nivel`, `vida`, `fuerza`, `velocidad`, `puntos_arena`, `experiencia`, `id_usuario`, `id_aspecto`) VALUES
(106, 'dani', 5, 60, 10, 6, 22, 9, 22, 2),
(123, 'koala', 1, 60, 5, 7, 1, 2, 28, 1),
(200, 'bruto1_1', 1, 50, 1, 1, 0, 0, 30, 1),
(201, 'bruto1_2', 1, 50, 1, 1, 0, 0, 30, 2),
(202, 'bruto2_1', 1, 50, 1, 1, 0, 0, 31, 1),
(203, 'bruto2_2', 1, 50, 1, 1, 0, 0, 31, 2),
(204, 'bruto3_1', 1, 50, 1, 1, 0, 0, 32, 1),
(205, 'bruto3_2', 1, 50, 1, 1, 0, 0, 32, 2),
(206, 'bruto4_1', 1, 50, 1, 1, 0, 0, 33, 1),
(207, 'bruto4_2', 1, 50, 1, 1, 0, 0, 33, 2),
(208, 'bruto5_1', 1, 50, 1, 1, 0, 0, 34, 1),
(209, 'bruto5_2', 1, 50, 1, 1, 0, 0, 34, 2),
(210, 'bruto6_1', 1, 50, 1, 1, 0, 0, 35, 1),
(211, 'bruto6_2', 1, 50, 1, 1, 0, 0, 35, 2),
(212, 'bruto7_1', 1, 50, 1, 1, 0, 0, 36, 1),
(213, 'bruto7_2', 1, 50, 1, 1, 0, 0, 36, 2),
(214, 'bruto8_1', 1, 50, 1, 1, 0, 0, 37, 1),
(215, 'bruto8_2', 1, 50, 1, 1, 0, 0, 37, 2),
(216, 'bruto9_1', 1, 50, 1, 1, 0, 0, 38, 1),
(217, 'bruto9_2', 1, 50, 1, 1, 0, 0, 38, 2),
(218, 'bruto10_1', 1, 50, 1, 1, 0, 0, 39, 1),
(219, 'bruto10_2', 1, 50, 1, 1, 0, 0, 39, 2),
(220, 'Izquierdo', 1, 60, 5, 7, 0, 1, 28, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bruto_animal`
--

CREATE TABLE `bruto_animal` (
  `id_bruto` int(11) NOT NULL,
  `id_animal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bruto_animal`
--

INSERT INTO `bruto_animal` (`id_bruto`, `id_animal`) VALUES
(106, 2),
(220, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bruto_habilidad`
--

CREATE TABLE `bruto_habilidad` (
  `id_bruto` int(11) NOT NULL,
  `id_habilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bruto_habilidad`
--

INSERT INTO `bruto_habilidad` (`id_bruto`, `id_habilidad`) VALUES
(123, 2),
(200, 1),
(201, 2),
(202, 3),
(203, 4),
(204, 5),
(205, 6),
(206, 7),
(207, 8),
(208, 9),
(209, 10),
(210, 1),
(211, 2),
(212, 3),
(213, 4),
(214, 5),
(215, 6),
(216, 7),
(217, 8),
(218, 9),
(219, 10),
(220, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bruto_herramienta`
--

CREATE TABLE `bruto_herramienta` (
  `id_bruto` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bruto_herramienta`
--

INSERT INTO `bruto_herramienta` (`id_bruto`, `id_herramienta`) VALUES
(123, 7),
(200, 1),
(201, 2),
(202, 3),
(203, 4),
(204, 5),
(205, 6),
(206, 7),
(207, 1),
(208, 2),
(209, 3),
(210, 4),
(211, 5),
(212, 6),
(213, 7),
(214, 1),
(215, 2),
(216, 3),
(217, 4),
(218, 5),
(219, 6),
(220, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combate`
--

CREATE TABLE `combate` (
  `id_combate` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_ganador` int(11) NOT NULL,
  `id_perdedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `combate`
--

INSERT INTO `combate` (`id_combate`, `fecha`, `id_ganador`, `id_perdedor`) VALUES
(210, '2025-06-27 00:00:00', 123, 106),
(211, '2025-06-27 00:00:00', 106, 220);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `efecto`
--

CREATE TABLE `efecto` (
  `id_efecto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `efecto`
--

INSERT INTO `efecto` (`id_efecto`, `nombre`) VALUES
(8, 'contraataque'),
(9, 'desarmar'),
(4, 'esquivar'),
(1, 'fuerza'),
(6, 'fuerza_arma_blanca'),
(10, 'fuerza_arma_pesada'),
(7, 'fuerza_puño'),
(5, 'multigolpe'),
(3, 'velocidad'),
(2, 'vida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `efecto_habilidad`
--

CREATE TABLE `efecto_habilidad` (
  `id_efecto` int(11) NOT NULL,
  `id_habilidad` int(11) NOT NULL,
  `multiplicador` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `efecto_habilidad`
--

INSERT INTO `efecto_habilidad` (`id_efecto`, `id_habilidad`, `multiplicador`) VALUES
(1, 1, 1.5),
(2, 4, 1.5),
(2, 9, 1.3),
(2, 10, 1.1),
(3, 3, 1.5),
(4, 2, 1.5),
(4, 11, 1.3),
(5, 8, 1.2),
(6, 5, 1.5),
(7, 6, 2),
(8, 7, 1.3),
(9, 12, 1.5),
(10, 13, 1.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `efecto_herramienta`
--

CREATE TABLE `efecto_herramienta` (
  `id_efecto` int(11) NOT NULL,
  `id_herramienta` int(11) NOT NULL,
  `multiplicador` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `efecto_herramienta`
--

INSERT INTO `efecto_herramienta` (`id_efecto`, `id_herramienta`, `multiplicador`) VALUES
(5, 1, 1.3),
(5, 3, 1.15),
(5, 4, 1.3),
(5, 5, 0.9),
(5, 6, 0.4),
(8, 2, 1.1),
(8, 6, 0.7),
(9, 2, 1.15),
(9, 4, 2),
(9, 5, 1.1),
(9, 6, 1.1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidad`
--

CREATE TABLE `habilidad` (
  `id_habilidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `habilidad`
--

INSERT INTO `habilidad` (`id_habilidad`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'Fuerza de Hercules', '¡Lo sabemos, eres capaz de levantar un tanque de guerra! Pero de momento nada de eso... ¡tienes un adversario que destrozar!', 'habilidad_1.png'),
(2, 'Agilidad Felina', 'Si estás aburrido, siempre puedes ir a masacrar al bruto de enfrente.', 'habilidad_2.png'),
(3, 'Golpe del Rayo', 'Eres más rápido que tu propia sombra. ¡Si yo fuera tu adversario, empezaría a rezar!', 'habilidad_3.png'),
(4, 'Vitalidad', '¡Tu esperanza de vida ha aumentado! Ahora podrás resistir más tiempo en pie frente a tu adversario.', 'habilidad_4.png'),
(5, 'Maestro de Armas', 'Tu dominio de las armas blancas ha hecho de ti un tipo muy, pero muy peligroso.', 'habilidad_5.png'),
(6, 'Artes Marciales', '¡Las clases de Chuck Norrs han dado sus frutos! Puedes ser feo y tonto... pero nadie se reirá de ti.', 'habilidad_6.png'),
(7, 'Belicoso', 'Después de todo eres un tipo generoso... ¡Cuando te tocan devuelves el golpe enseguida y hasta sin razón!', 'habilidad_7.png'),
(8, 'Tornado de golpes', 'la cucaracha, la cucaracha, ya no puede caminar, porque tu bruto, porque tu bruto, tararararara.', 'habilidad_8.png'),
(9, 'Armadura', 'Una armadura: mucho mejor que una camiseta limpia. También sirve para frenar los golpes.', 'habilidad_9.png'),
(10, 'Piel reforzada', 'La evolución se hace a base de golpes. Tu Bruto posee ahora una piel más resistente.', 'habilidad_10.png'),
(11, 'Intocable', 'Evitas los golpes fácilmente. Eso puede enojar mucho a tu enemigo.', 'habilidad_11.png'),
(12, 'Choque', 'Tus golpes son tan espectaculares que tu adversario deja caer su propia arma... ¡Es muy útil para ganar nuevos fans!', 'habilidad_12.png'),
(13, 'Brazo Fuerte', 'Manipulas las armas pesadas como si nada gracias a tus musculos de acero. Eres el Swarchanegger de la maza.', 'habilidad_13.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramienta`
--

CREATE TABLE `herramienta` (
  `id_herramienta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `tipo` varchar(10) NOT NULL CHECK (`tipo` in ('blanca','pesada')),
  `danio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `herramienta`
--

INSERT INTO `herramienta` (`id_herramienta`, `nombre`, `imagen`, `tipo`, `danio`) VALUES
(1, 'Cuchillo', 'herramienta_1.png', 'blanca', 7),
(2, 'Espadon', 'herramienta_2.png', 'blanca', 10),
(3, 'Cimitarra', 'herramienta_3.png', 'blanca', 10),
(4, 'Sai', 'herramienta_4.png', 'blanca', 8),
(5, 'Hueso de Mamut', 'herramienta_5.png', 'pesada', 14),
(6, 'Maza', 'herramienta_6.png', 'pesada', 30),
(7, 'Hacha', 'herramienta_7.png', 'pesada', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `tipo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `contrasenia`, `tipo`) VALUES
(22, 'koala', '$2y$10$.LV8rf/gBNIRr6C7R0g8Lu8WavvzARSqmrvZSVmp7odiEGpwIk04a', 0),
(24, 'daniel', '$2y$10$isEs3BHQZ010AYK4oNmoC.cMsrPYDdW0qiWCJ8Hjuqc1N3o0XFmk.', 0),
(28, 'admin', '$2y$10$L9KWzctnwLD.F9aAy84GQed6b2uccNy4AOZ5bxhOOowdNKuxRvJFO', 1),
(30, 'user1', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(31, 'user2', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(32, 'user3', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(33, 'user4', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(34, 'user5', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(35, 'user6', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(36, 'user7', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(37, 'user8', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(38, 'user9', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0),
(39, 'user10', '$2y$10$zqEw3RA8mJYm8kkKeCmLC.vcqnA3ONw5rJ.V5C7Km3jOLFYZrNSiq', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `animal`
--
ALTER TABLE `animal`
  ADD PRIMARY KEY (`id_animal`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `aspecto`
--
ALTER TABLE `aspecto`
  ADD PRIMARY KEY (`id_aspecto`);

--
-- Indices de la tabla `bruto`
--
ALTER TABLE `bruto`
  ADD PRIMARY KEY (`id_bruto`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `fk_br_us` (`id_usuario`),
  ADD KEY `fk_br_as` (`id_aspecto`);

--
-- Indices de la tabla `bruto_animal`
--
ALTER TABLE `bruto_animal`
  ADD PRIMARY KEY (`id_bruto`,`id_animal`),
  ADD KEY `fk_ba_an` (`id_animal`);

--
-- Indices de la tabla `bruto_habilidad`
--
ALTER TABLE `bruto_habilidad`
  ADD PRIMARY KEY (`id_bruto`,`id_habilidad`),
  ADD KEY `fk_bha_ha` (`id_habilidad`);

--
-- Indices de la tabla `bruto_herramienta`
--
ALTER TABLE `bruto_herramienta`
  ADD PRIMARY KEY (`id_bruto`,`id_herramienta`),
  ADD KEY `fk_bhe_he` (`id_herramienta`);

--
-- Indices de la tabla `combate`
--
ALTER TABLE `combate`
  ADD PRIMARY KEY (`id_combate`),
  ADD KEY `fk_co_brg` (`id_ganador`),
  ADD KEY `fk_co_brp` (`id_perdedor`);

--
-- Indices de la tabla `efecto`
--
ALTER TABLE `efecto`
  ADD PRIMARY KEY (`id_efecto`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `efecto_habilidad`
--
ALTER TABLE `efecto_habilidad`
  ADD PRIMARY KEY (`id_efecto`,`id_habilidad`),
  ADD KEY `fk_eha_ha` (`id_habilidad`);

--
-- Indices de la tabla `efecto_herramienta`
--
ALTER TABLE `efecto_herramienta`
  ADD PRIMARY KEY (`id_efecto`,`id_herramienta`),
  ADD KEY `fk_ehe_he` (`id_herramienta`);

--
-- Indices de la tabla `habilidad`
--
ALTER TABLE `habilidad`
  ADD PRIMARY KEY (`id_habilidad`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  ADD PRIMARY KEY (`id_herramienta`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `animal`
--
ALTER TABLE `animal`
  MODIFY `id_animal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `aspecto`
--
ALTER TABLE `aspecto`
  MODIFY `id_aspecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `bruto`
--
ALTER TABLE `bruto`
  MODIFY `id_bruto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT de la tabla `combate`
--
ALTER TABLE `combate`
  MODIFY `id_combate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `efecto`
--
ALTER TABLE `efecto`
  MODIFY `id_efecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `habilidad`
--
ALTER TABLE `habilidad`
  MODIFY `id_habilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `herramienta`
--
ALTER TABLE `herramienta`
  MODIFY `id_herramienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bruto`
--
ALTER TABLE `bruto`
  ADD CONSTRAINT `fk_br_as` FOREIGN KEY (`id_aspecto`) REFERENCES `aspecto` (`id_aspecto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_br_us` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bruto_animal`
--
ALTER TABLE `bruto_animal`
  ADD CONSTRAINT `fk_ba_an` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ba_br` FOREIGN KEY (`id_bruto`) REFERENCES `bruto` (`id_bruto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `bruto_habilidad`
--
ALTER TABLE `bruto_habilidad`
  ADD CONSTRAINT `fk_bha_br` FOREIGN KEY (`id_bruto`) REFERENCES `bruto` (`id_bruto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bha_ha` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidad` (`id_habilidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bruto_herramienta`
--
ALTER TABLE `bruto_herramienta`
  ADD CONSTRAINT `fk_bhe_br` FOREIGN KEY (`id_bruto`) REFERENCES `bruto` (`id_bruto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_bhe_he` FOREIGN KEY (`id_herramienta`) REFERENCES `herramienta` (`id_herramienta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `combate`
--
ALTER TABLE `combate`
  ADD CONSTRAINT `fk_co_brg` FOREIGN KEY (`id_ganador`) REFERENCES `bruto` (`id_bruto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_co_brp` FOREIGN KEY (`id_perdedor`) REFERENCES `bruto` (`id_bruto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `efecto_habilidad`
--
ALTER TABLE `efecto_habilidad`
  ADD CONSTRAINT `fk_eha_ef` FOREIGN KEY (`id_efecto`) REFERENCES `efecto` (`id_efecto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_eha_ha` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidad` (`id_habilidad`) ON DELETE CASCADE;

--
-- Filtros para la tabla `efecto_herramienta`
--
ALTER TABLE `efecto_herramienta`
  ADD CONSTRAINT `fk_ehe_ef` FOREIGN KEY (`id_efecto`) REFERENCES `efecto` (`id_efecto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ehe_he` FOREIGN KEY (`id_herramienta`) REFERENCES `herramienta` (`id_herramienta`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
