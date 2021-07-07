-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-07-2021 a las 06:36:22
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tp_entornos_graficos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catedras`
--

CREATE TABLE `catedras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `definicion` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_jefe_catedra` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamados`
--

CREATE TABLE `llamados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `requisitos` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vacantes` int(11) NOT NULL,
  `calificado` tinyint(1) NOT NULL,
  `id_catedra` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `llamados`
--
DELIMITER $$
CREATE TRIGGER `validar_vacantes` BEFORE INSERT ON `llamados` FOR EACH ROW BEGIN
                IF NEW.vacantes < 1 OR NEW.vacantes > 100
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El número de vacantes debe estar entre 1 y 100';
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dni` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `imagen_dni` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_usuario` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `clave` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nombre_apellido` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `curriculum_vitae` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verificada` tinyint(1) NOT NULL,
  `codigo_cambiar_clave` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fecha_hora_max_cambiar_clave` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `dni`, `imagen_dni`, `nombre_usuario`, `clave`, `nombre_apellido`, `email`, `telefono`, `api_token`, `curriculum_vitae`, `verificada`, `codigo_cambiar_clave`, `fecha_hora_max_cambiar_clave`) VALUES
(1, '42531073', 'DNI_wcirb1JUgPk.pdf', 'GianRase', '$2y$10$D.8bYOPzDRYAG2AlpcpgwuswMFuzaAyeIksYHPeP7IsMoNZSdmMIy', 'Gianfranco Raselli', 'gianrase4@gmail.com', '3482334910', 'd5PQOt2HLHC68qR0rHLhHSNNHwG0Uy1S0pd6u2iGPGOKEDZeaahlJNqVki4B2', 'CV_edmaE1XUwl5.pdf', 1, 'xgRr0sdCbg11625718100jGZnD8fduY', '2021-07-08 01:21:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas_catedras`
--

CREATE TABLE `personas_catedras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_catedra` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas_roles`
--

CREATE TABLE `personas_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_rol` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas_roles`
--

INSERT INTO `personas_roles` (`id`, `id_persona`, `id_rol`) VALUES
(2, 1, 1),
(3, 1, 2),
(1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones`
--

CREATE TABLE `postulaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `estado` enum('Postulado','No elegido','Elegido') COLLATE utf8mb4_unicode_ci NOT NULL,
  `puntaje` int(11) DEFAULT NULL,
  `comentarios` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_persona` bigint(20) UNSIGNED NOT NULL,
  `id_llamado` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `postulaciones`
--
DELIMITER $$
CREATE TRIGGER `validar_puntaje` BEFORE INSERT ON `postulaciones` FOR EACH ROW BEGIN
                IF NEW.puntaje < 1 OR NEW.puntaje > 100
                THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El puntaje debe estar entre 1 y 100';
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` enum('Administrador','Jefe Catedra','Usuario') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Jefe Catedra'),
(3, 'Usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catedras`
--
ALTER TABLE `catedras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `catedras_descripcion_unique` (`descripcion`),
  ADD KEY `catedras_id_jefe_catedra_foreign` (`id_jefe_catedra`);

--
-- Indices de la tabla `llamados`
--
ALTER TABLE `llamados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `llamados_id_catedra_fecha_inicio_unique` (`id_catedra`,`fecha_inicio`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_dni_unique` (`dni`),
  ADD UNIQUE KEY `personas_nombre_usuario_unique` (`nombre_usuario`),
  ADD UNIQUE KEY `personas_imagen_dni_unique` (`imagen_dni`),
  ADD UNIQUE KEY `personas_api_token_unique` (`api_token`),
  ADD UNIQUE KEY `personas_curriculum_vitae_unique` (`curriculum_vitae`),
  ADD UNIQUE KEY `personas_codigo_cambiar_clave_unique` (`codigo_cambiar_clave`);

--
-- Indices de la tabla `personas_catedras`
--
ALTER TABLE `personas_catedras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_catedras_id_persona_id_catedra_unique` (`id_persona`,`id_catedra`),
  ADD KEY `personas_catedras_id_catedra_foreign` (`id_catedra`);

--
-- Indices de la tabla `personas_roles`
--
ALTER TABLE `personas_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_roles_id_persona_id_rol_unique` (`id_persona`,`id_rol`),
  ADD KEY `personas_roles_id_rol_foreign` (`id_rol`);

--
-- Indices de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `postulaciones_id_persona_id_llamado_unique` (`id_persona`,`id_llamado`),
  ADD KEY `postulaciones_id_llamado_foreign` (`id_llamado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_descripcion_unique` (`descripcion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catedras`
--
ALTER TABLE `catedras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `llamados`
--
ALTER TABLE `llamados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `personas_catedras`
--
ALTER TABLE `personas_catedras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas_roles`
--
ALTER TABLE `personas_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `catedras`
--
ALTER TABLE `catedras`
  ADD CONSTRAINT `catedras_id_jefe_catedra_foreign` FOREIGN KEY (`id_jefe_catedra`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `llamados`
--
ALTER TABLE `llamados`
  ADD CONSTRAINT `llamados_id_catedra_foreign` FOREIGN KEY (`id_catedra`) REFERENCES `catedras` (`id`);

--
-- Filtros para la tabla `personas_catedras`
--
ALTER TABLE `personas_catedras`
  ADD CONSTRAINT `personas_catedras_id_catedra_foreign` FOREIGN KEY (`id_catedra`) REFERENCES `catedras` (`id`),
  ADD CONSTRAINT `personas_catedras_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);

--
-- Filtros para la tabla `personas_roles`
--
ALTER TABLE `personas_roles`
  ADD CONSTRAINT `personas_roles_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `personas_roles_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `postulaciones`
--
ALTER TABLE `postulaciones`
  ADD CONSTRAINT `postulaciones_id_llamado_foreign` FOREIGN KEY (`id_llamado`) REFERENCES `llamados` (`id`),
  ADD CONSTRAINT `postulaciones_id_persona_foreign` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
