-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-05-2024 a las 04:53:15
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
-- Base de datos: `tienda_online2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` tinyint(3) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `id_categoria`, `activo`) VALUES
(1, 'PC GAMER', '<br><h3>Componentes:</h3></br>\r\n    <ul>\r\n        <li>\r\n            <h5>Procesador</h5>\r\n            <p>Intel Core i9-10900K</p>\r\n        </li>\r\n        <li>\r\n            <h5>Tarjeta Gráfica</h5>\r\n            <p>NVIDIA GeForce RTX 3090</p>\r\n        </li>\r\n        <li>\r\n            <h5>memoria RAM</h5>\r\n            <p>Corsair Vengeance RGB Pro 32 GB (2 x 16 GB) DDR4-3600</p>\r\n        </li>\r\n        <li>\r\n            <h5>Motherboard</h5>            <p>ASUS ROG Maximus XII Hero (Wi-Fi)</p>\r\n        </li>\r\n        <li>\r\n            <h5>Almacenamiento</h5>\r\n            <p>Samsung 970 EVO Plus 1 TB NVMe SSD</p>\r\n        </li>\r\n        <li>\r\n            <h5>Fuente de poder</h5>\r\n            <p>Corsair RM850x 850W 80+ Gold</p>\r\n        </li>\r\n        <li>\r\n            <h5>Gabinete</h5>\r\n            <p>NZXT H710i</p>\r\n        </li>\r\n        <li>\r\n            <h5>Sistema de refrigeración</h5>\r\n            <p>NZXT Kraken Z73</p>\r\n        </li>', 10000.00, 15, 1, 1),
(2, 'RTX 3090', '<li>\r\n    <h2>Tarjeta Gráfica: Gigabyte GeForce RTX 3090 Gaming OC</h2>\r\n    <p>La Gigabyte GeForce RTX 3090 Gaming OC es una potente tarjeta gráfica diseñada para ofrecer un rendimiento excepcional en juegos de alta gama, renderizado 3D y aplicaciones de creación de contenido. Equipada con la arquitectura Ampere de NVIDIA, la RTX 3090 ofrece trazado de rayos en tiempo real y tecnologías de inteligencia artificial para una experiencia de juego inigualable.</p>\r\n    <ul>\r\n        <li>Modelo: Gigabyte GeForce RTX 3090 Gaming OC</li>\r\n        <li>Memoria VRAM: 24 GB GDDR6X</li>\r\n        <li>Interfaz: PCIe 4.0 x16</li>\r\n        <li>Salidas de video: 3x DisplayPort 1.4a, 2x HDMI 2.1</li>\r\n    </ul>\r\n</li>\r\n', 7500.00, 8, 1, 1),
(3, 'Monitor Samsung 32\'\' Curvo FHD HDMI', '<li>\r\n    <h2>Monitor: Samsung 32\'\' Curvo FHD HDMI</h2>\r\n    <p>El monitor Samsung 32\'\' Curvo FHD HDMI es una excelente opción para los jugadores y creadores de contenido que buscan una experiencia inmersiva. Con su pantalla curva de 32 pulgadas y resolución Full HD, ofrece imágenes nítidas y colores vibrantes que hacen que los juegos y películas cobren vida.</p>\r\n    <ul>\r\n        <li>Modelo: Samsung 32\'\' Curvo FHD HDMI</li>\r\n        <li>Tamaño de la pantalla: 32 pulgadas</li>\r\n        <li>Resolución: Full HD (1920 x 1080)</li>\r\n        <li>Tecnología de pantalla: Curvado</li>\r\n        <li>Conectividad: HDMI, DisplayPort, VGA, USB</li>\r\n    </ul>\r\n</li>\r\n', 800.00, 35, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
