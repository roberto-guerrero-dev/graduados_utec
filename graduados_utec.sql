-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2025 a las 10:31:47
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
-- Base de datos: `graduados_utec`
--
CREATE DATABASE IF NOT EXISTS `graduados_utec` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `graduados_utec`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_BuscarGraduados` (IN `p_fecha_inicio` DATE, IN `p_fecha_fin` DATE, IN `p_modalidad` VARCHAR(50), IN `p_genero` VARCHAR(10), IN `p_carrera` VARCHAR(100), IN `p_facultad` VARCHAR(100))   BEGIN
    SELECT *
    FROM v_graduados_carreras
    WHERE 
        (p_fecha_inicio IS NULL OR fecha_graduacion >= p_fecha_inicio)
        AND (p_fecha_fin IS NULL OR fecha_graduacion <= p_fecha_fin)
        AND (p_modalidad IS NULL OR p_modalidad = '' OR modalidad = p_modalidad)
        AND (p_genero IS NULL OR p_genero = '' OR genero = p_genero)
        AND (p_carrera IS NULL OR p_carrera = '' OR carrera = p_carrera)
        AND (p_facultad IS NULL OR p_facultad = '' OR facultad = p_facultad);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_as|127.0.0.1', 'i:1;', 1750918594),
('laravel_cache_as|127.0.0.1:timer', 'i:1750918594;', 1750918594),
('laravel_cache_guerrerov.robertocarlos00@gmail.|127.0.0.1', 'i:2;', 1750918342),
('laravel_cache_guerrerov.robertocarlos00@gmail.|127.0.0.1:timer', 'i:1750918342;', 1750918342);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `codigo_carrera` int(11) NOT NULL,
  `id_facultad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `modalidad` varchar(50) NOT NULL,
  `activo` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `codigo_carrera`, `id_facultad`, `nombre`, `modalidad`, `activo`) VALUES
(1, 28, 2, 'Licenciatura en Ciencias Jurídicas', 'Presencial', b'0'),
(2, 27, 3, 'Técnico en Ingeniería de Software', 'Semipresencial', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE `correos` (
  `id_correo` int(11) NOT NULL,
  `carnet_graduado` varchar(40) NOT NULL,
  `correo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`id_correo`, `carnet_graduado`, `correo`) VALUES
(25, '2121212121', 'pablop@gmail.com'),
(36, '2121212127', 'correo@gmail.com'),
(35, '2323232322', 'ejemplo0101@gmail.com'),
(31, '2525252525', 'jorge2@gmail.com'),
(32, '2525252525', 'jorge@gmail.com'),
(22, '2717932022', 'correo@gmail.com'),
(26, '2929292929', 'maria@gmail.com'),
(24, '7878787878', 'josegonz@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE `facultades` (
  `id_facultad` int(11) NOT NULL,
  `codigo_facultad` varchar(20) NOT NULL,
  `nombre_facultad` varchar(100) NOT NULL,
  `activo` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`id_facultad`, `codigo_facultad`, `nombre_facultad`, `activo`) VALUES
(2, 'CE', 'Facultad de Ciencias Empresariales', b'0'),
(3, 'FICA', 'Facultad de Informática y Ciencias Aplicadas', b'0'),
(4, 'DER', 'Facultad de Derecho', b'1'),
(5, 'CSLS', 'Facultad de Ciencias Sociales', b'0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduados`
--

CREATE TABLE `graduados` (
  `id_graduado` int(11) NOT NULL,
  `carnet_graduado` varchar(40) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `activo` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `graduados`
--

INSERT INTO `graduados` (`id_graduado`, `carnet_graduado`, `nombres`, `apellidos`, `genero`, `activo`) VALUES
(19, '2717932022', 'Roberto Carlos', 'Guerrero Vasquez', 'Masculino', b'1'),
(20, '2525252525', 'Jorge', 'Perez', 'Masculino', b'1'),
(21, '7878787878', 'José', 'Gonzales', 'Masculino', b'1'),
(22, '2121212121', 'Pablo', 'Perez', 'Masculino', b'1'),
(23, '2929292929', 'Maria', 'Flores', 'Femenino', b'1'),
(24, '2121212127', 'asdf', 'adssdf', 'Masculino', b'0'),
(25, '2323232322', 'ejemplo0101', 'ejemplo0101', 'Masculino', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `graduados_carreras`
--

CREATE TABLE `graduados_carreras` (
  `id_graduados_carreras` int(11) NOT NULL,
  `carnet_graduado` varchar(40) NOT NULL,
  `id_carrera` int(11) NOT NULL,
  `fecha_graduacion` date NOT NULL,
  `ciclo_graduacion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `graduados_carreras`
--

INSERT INTO `graduados_carreras` (`id_graduados_carreras`, `carnet_graduado`, `id_carrera`, `fecha_graduacion`, `ciclo_graduacion`) VALUES
(1, '2717932022', 1, '2025-06-25', '01-2025'),
(2, '2525252525', 1, '2024-01-18', '01-2024'),
(3, '7878787878', 1, '2022-11-21', '02-2022'),
(4, '2121212121', 2, '2024-07-16', '01-2024'),
(5, '2929292929', 2, '2024-01-01', '01-2024'),
(6, '2121212127', 2, '2025-06-26', '01-2025'),
(7, '2323232322', 1, '2025-06-26', '01-2025');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_25_024051_add_deleted_at_to_graduados_carreras', 2),
(5, '2025_06_25_025251_add_deleted_at_to_graduados_carreras', 3),
(6, '2025_06_25_025359_add_deleted_at_to_graduados_carreras', 4),
(7, '2025_06_25_025655_add_deleted_at_to_graduados_carreras', 5),
(8, '2025_06_25_034545_remove_deleted_at_to_graduados_carreras', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Yse0Sh3Eba3VngItKvNa0V5Uz6PNj38LgYt4QQN3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDBSUXFidlNBdFRXajdRaThzQkc1ZnlGaXdrbzhiMzExY0hGTzhMcyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1750926600);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

CREATE TABLE `telefonos` (
  `id_telefono` int(11) NOT NULL,
  `carnet_graduado` varchar(40) NOT NULL,
  `telefono` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `telefonos`
--

INSERT INTO `telefonos` (`id_telefono`, `carnet_graduado`, `telefono`) VALUES
(25, '2121212121', '79797979'),
(33, '2121212127', '76767676'),
(32, '2323232322', '22222222'),
(29, '2525252525', '71717171'),
(22, '2717932022', '78190901'),
(26, '2929292929', '71717171'),
(24, '7878787878', '71727374');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Roberto Carlos Guerrero Vasquez', 'guerrerov.robertocarlos00@gmail.com', NULL, '$2y$12$5xbtxXbltYXDcwIv3HIF2./hrfezIDTrT481f2GEOYkc8TXTlfubG', NULL, '2025-05-07 11:28:25', '2025-06-05 10:05:13'),
(3, 'ejemplo 2', 'ejemplo@gmail.com', NULL, '$2y$12$YqYupSWCwHoOEP8NUMRR5e/r9n8EQFhdwc7w9HDRDzOzCZcOtMCCi', NULL, '2025-05-09 13:35:22', '2025-05-24 10:07:32');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_graduados_carreras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_graduados_carreras` (
`id` int(11)
,`carnet_graduado` varchar(40)
,`nombre` varchar(101)
,`genero` varchar(20)
,`id_carrera` int(11)
,`carrera` varchar(200)
,`facultad` varchar(100)
,`modalidad` varchar(50)
,`fecha_graduacion` date
,`ciclo_graduacion` varchar(20)
,`telefonos` mediumtext
,`correos` mediumtext
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_graduados_carreras`
--
DROP TABLE IF EXISTS `v_graduados_carreras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_graduados_carreras`  AS SELECT `gc`.`id_graduados_carreras` AS `id`, `g`.`carnet_graduado` AS `carnet_graduado`, concat(`g`.`nombres`,' ',`g`.`apellidos`) AS `nombre`, `g`.`genero` AS `genero`, `c`.`id_carrera` AS `id_carrera`, `c`.`nombre` AS `carrera`, `f`.`nombre_facultad` AS `facultad`, `c`.`modalidad` AS `modalidad`, `gc`.`fecha_graduacion` AS `fecha_graduacion`, `gc`.`ciclo_graduacion` AS `ciclo_graduacion`, group_concat(distinct `t`.`telefono` separator ', ') AS `telefonos`, group_concat(distinct `cr`.`correo` separator ', ') AS `correos` FROM (((((`graduados_carreras` `gc` join `graduados` `g` on(`gc`.`carnet_graduado` = `g`.`carnet_graduado`)) join `carreras` `c` on(`gc`.`id_carrera` = `c`.`id_carrera`)) join `facultades` `f` on(`c`.`id_facultad` = `f`.`id_facultad`)) left join `telefonos` `t` on(`g`.`carnet_graduado` = `t`.`carnet_graduado`)) left join `correos` `cr` on(`g`.`carnet_graduado` = `cr`.`carnet_graduado`)) GROUP BY `gc`.`id_graduados_carreras`, `g`.`carnet_graduado`, `g`.`nombres`, `g`.`apellidos`, `g`.`genero`, `c`.`id_carrera`, `c`.`nombre`, `f`.`nombre_facultad`, `c`.`modalidad`, `gc`.`fecha_graduacion`, `gc`.`ciclo_graduacion` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`),
  ADD KEY `fk_facultades_carreras` (`id_facultad`);

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id_correo`),
  ADD UNIQUE KEY `uq_correo_graduado` (`carnet_graduado`,`correo`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`id_facultad`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `graduados`
--
ALTER TABLE `graduados`
  ADD PRIMARY KEY (`id_graduado`),
  ADD UNIQUE KEY `carnet_graduado` (`carnet_graduado`);

--
-- Indices de la tabla `graduados_carreras`
--
ALTER TABLE `graduados_carreras`
  ADD PRIMARY KEY (`id_graduados_carreras`),
  ADD KEY `fk_carnet_carrera` (`carnet_graduado`),
  ADD KEY `fk_id_carrera` (`id_carrera`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id_telefono`),
  ADD UNIQUE KEY `uq_telefono_graduado` (`carnet_graduado`,`telefono`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id_correo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `facultades`
--
ALTER TABLE `facultades`
  MODIFY `id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `graduados`
--
ALTER TABLE `graduados`
  MODIFY `id_graduado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `graduados_carreras`
--
ALTER TABLE `graduados_carreras`
  MODIFY `id_graduados_carreras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id_telefono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `fk_facultades_carreras` FOREIGN KEY (`id_facultad`) REFERENCES `facultades` (`id_facultad`);

--
-- Filtros para la tabla `correos`
--
ALTER TABLE `correos`
  ADD CONSTRAINT `fk_graduado_correo` FOREIGN KEY (`carnet_graduado`) REFERENCES `graduados` (`carnet_graduado`);

--
-- Filtros para la tabla `graduados_carreras`
--
ALTER TABLE `graduados_carreras`
  ADD CONSTRAINT `fk_carnet_carrera` FOREIGN KEY (`carnet_graduado`) REFERENCES `graduados` (`carnet_graduado`),
  ADD CONSTRAINT `fk_id_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`);

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `fk_graduado_telefono` FOREIGN KEY (`carnet_graduado`) REFERENCES `graduados` (`carnet_graduado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
