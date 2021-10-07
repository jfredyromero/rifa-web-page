-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 07, 2021 at 06:53 PM
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
  `numero_boleta` varchar(4) NOT NULL COMMENT 'extra1',
  `comprador_ip` varchar(39) NOT NULL COMMENT 'ip',
  `comprador_nombre` varchar(50) NOT NULL COMMENT 'cc_holder',
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
(1, '1234', '169.168.28.1', 'fredy', '102973', '302919', 'jho@hah.com', 'jnbcidsnc', '', '', '', '2021-10-04 13:17:02'),
(2, 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', '', '', '', '2021-10-05 15:02:15'),
(3, '0009', '10.0.0.5', 'APPROVED', '', '3014822371', 'jhon@example.com', '1401551563', 'fc78466d9fdf5c56e54bc690697beb1e', '14ab9bd3-c2d8-4701-b9d1-8615d5a986f4', '', '2021-10-05 18:51:58'),
(4, '9999', '10.0.0.3', 'APPROVED', '1002970732', '3014822371', 'jhon@example.com', '1401551723', '9226c6c8d02672383a7cae83e42f5379', 'fa3af48d-9753-4a90-9e2c-d93b1ad01550', '190001', '2021-10-05 19:31:27'),
(5, '9998', '10.0.0.5', 'PENDING', '1002970732', '3014822371', 'jhon@example.com', '1401551725', 'bb721133c73e12d0f93424388617ab18', '6519ae65-234d-47c5-86e2-6620449a907c', '190001', '2021-10-05 19:34:51'),
(11, '0001', '10.0.0.5', 'APPROVED', '1061820083', '3105110389', 'gigia.munoz@gmail.com', '1401574268', 'af1ee742ef45df1cdd342f7a23aec4c8', '2dbbef0c-80d1-4e7c-8cc6-30663408ab5b', '2342', '2021-10-06 19:50:48'),
(13, '0002', '10.0.0.3', 'APPROVED', '1061820083', '3105110389', 'gigia.munoz@gmail.com', '1401575729', '9fa0b6eab49d3175ffa541a3d72452cb', '27b3cb07-8738-4963-a52d-9655bb471045', '2342', '2021-10-06 21:15:12'),
(15, '0003', '10.0.0.4', 'APPROVED', '1061820083', '3105110389', 'gigia.munoz@gmail.com', '1401576450', '41be991590419bdbdf972228590fdc4c', '6fb9e165-1e41-4fc5-8eb6-3617aa1643c7', '2342', '2021-10-06 21:57:47');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
