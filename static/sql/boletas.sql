-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 14, 2021 at 08:50 PM
-- Server version: 10.5.12-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u791910196_ganatucarro`
--

-- --------------------------------------------------------

--
-- Table structure for table `boletas`
--

CREATE TABLE `boletas` (
  `id` int(11) NOT NULL,
  `numero_boleta` varchar(20) NOT NULL COMMENT 'extra1',
  `comprador_ip` varchar(39) NOT NULL COMMENT 'ip',
  `comprador_nombre` varchar(50) NOT NULL COMMENT 'extra2',
  `comprador_cedula` varchar(15) NOT NULL COMMENT 'extra2',
  `comprador_celular` varchar(15) NOT NULL COMMENT 'phone',
  `comprador_correo` varchar(50) NOT NULL COMMENT 'email_buyer',
  `referencia_pago` varchar(100) NOT NULL COMMENT 'reference_pol',
  `referencia_venta` varchar(100) NOT NULL COMMENT 'reference_sale',
  `id_transaccion` varchar(100) NOT NULL COMMENT 'transaction_id',
  `codigo_referido` varchar(50) DEFAULT NULL COMMENT 'extra3',
  `fecha_compra` datetime NOT NULL COMMENT 'transaction_date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `boletas`
--

INSERT INTO `boletas` (`id`, `numero_boleta`, `comprador_ip`, `comprador_nombre`, `comprador_cedula`, `comprador_celular`, `comprador_correo`, `referencia_pago`, `referencia_venta`, `id_transaccion`, `codigo_referido`, `fecha_compra`) VALUES
(1, '5800', '10.0.0.5', 'Jhon Fredy', '1002970732', '3105110389', 'jhonrom@unicauca.edu.co', '1401676969', 'bf4a702005aa2d3fd36296c3ab8bc117', '1a324857-021a-4fb0-b7ad-ce5f6d8e1cd8', '', '2021-10-13 18:23:07'),
(2, '6102', '10.0.0.5', 'Jhon Fredy', '1002970732', '3105110389', 'jhonrom@unicauca.edu.co', '1401676969', 'bf4a702005aa2d3fd36296c3ab8bc117', '1a324857-021a-4fb0-b7ad-ce5f6d8e1cd8', '', '2021-10-13 18:23:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_boleta` (`numero_boleta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
