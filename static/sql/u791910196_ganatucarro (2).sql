-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 19, 2021 at 11:18 PM
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
(1, '5800', '10.0.0.5', 'Jhon Fredy', '1002970732', '3014822371', 'jhonrom@unicauca.edu.co', '1401676969', 'bf4a702005aa2d3fd36296c3ab8bc117', '1a324857-021a-4fb0-b7ad-ce5f6d8e1cd8', NULL, '2021-10-13 18:23:07'),
(2, '6102', '10.0.0.5', 'Jhon Fredy', '1002970732', '3014822371', 'jhonrom@unicauca.edu.co', '1401676969', 'bf4a702005aa2d3fd36296c3ab8bc117', '1a324857-021a-4fb0-b7ad-ce5f6d8e1cd8', '366afa7ab6ecdf320d9d640ff494d815', '2021-10-13 18:23:07'),
(3, '2014', '10.0.0.4', 'Lina Muñoz', '1061820073', '3105110389', 'gigia.munoz@gmail.com', '1401756785', '664c9be415da308047e0abd50bae4438', '3f631fad-21e0-45af-ae98-58a09214d1c5', '366afa7ab6ecdf320d9d640ff494d815', '2021-10-18 14:19:17'),
(4, '4700', '10.0.0.4', 'Lina Muñoz', '1061820073', '3105110389', 'gigia.munoz@gmail.com', '1401756785', '664c9be415da308047e0abd50bae4438', '3f631fad-21e0-45af-ae98-58a09214d1c5', '366afa7ab6ecdf320d9d640ff494d815', '2021-10-18 14:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `referidos`
--

CREATE TABLE `referidos` (
  `codigo` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `referido` varchar(50) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referidos`
--

INSERT INTO `referidos` (`codigo`, `referido`) VALUES
('366afa7ab6ecdf320d9d640ff494d815', 'Gana tu Moto');

-- --------------------------------------------------------

--
-- Table structure for table `ver_datos`
--

CREATE TABLE `ver_datos` (
  `id` int(11) NOT NULL,
  `datos` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ver_datos`
--

INSERT INTO `ver_datos` (`id`, `datos`) VALUES
(1, 'Hola'),
(2, '<h5>Campo 1: merchantId = 508029</h5><h5>Campo 2: merchant_name = Test PayU Test comercio</h5><h5>Campo 3: merchant_address = Av 123 Calle 12</h5><h5>Campo 4: telephone = 7512354</h5><h5>Campo 5: merchant_url = http://pruebaslapv.xtrweb.com</h5><h5>Campo 6: transactionState = 4</h5><h5>Campo 7: lapTransactionState = APPROVED</h5><h5>Campo 8: message = APPROVED</h5><h5>Campo 9: referenceCode = 0f1c486e04cf2066d71648d38afa66e2</h5><h5>Campo 10: reference_pol = 1401551301</h5><h5>Campo 11: transactionId = 1899b890-fbc0-4470-acf4-df4c5e8cec9f</h5><h5>Campo 12: description = Test PAYU</h5><h5>Campo 13: trazabilityCode = CRED - 777276672</h5><h5>Campo 14: cus = CRED - 777276672</h5><h5>Campo 15: orderLanguage = es</h5><h5>Campo 16: extra1 = 24537</h5><h5>Campo 17: extra2 = </h5><h5>Campo 18: extra3 = </h5><h5>Campo 19: polTransactionState = 4</h5><h5>Campo 20: signature = 09d14e9c7ace67261b003ff7b5bc701f</h5><h5>Campo 21: polResponseCode = 1</h5><h5>Campo 22: lapResponseCode = APPROVED</h5><h5>Campo 23: risk = </h5><h5>Campo 24: polPaymentMethod = 10</h5><h5>Campo 25: lapPaymentMethod = VISA</h5><h5>Campo 26: polPaymentMethodType = 2</h5><h5>Campo 27: lapPaymentMethodType = CREDIT_CARD</h5><h5>Campo 28: installmentsNumber = 1</h5><h5>Campo 29: TX_VALUE = 50000.00</h5><h5>Campo 30: TX_TAX = .00</h5><h5>Campo 31: currency = COP</h5><h5>Campo 32: lng = es</h5><h5>Campo 33: pseCycle = </h5><h5>Campo 34: buyerEmail = jhon@example.com</h5><h5>Campo 35: pseBank = </h5><h5>Campo 36: pseReference1 = </h5><h5>Campo 37: pseReference2 = </h5><h5>Campo 38: pseReference3 = </h5><h5>Campo 39: authorizationCode = 210110</h5><h5>Campo 40: TX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 41: TX_TAX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 42: TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE = .00</h5><h5>Campo 43: processingDate = 2021-10-05</h5>'),
(3, '<h5>Campo 1: merchantId = 508029</h5><h5>Campo 2: merchant_name = Test PayU Test comercio</h5><h5>Campo 3: merchant_address = Av 123 Calle 12</h5><h5>Campo 4: telephone = 7512354</h5><h5>Campo 5: merchant_url = http://pruebaslapv.xtrweb.com</h5><h5>Campo 6: transactionState = 4</h5><h5>Campo 7: lapTransactionState = APPROVED</h5><h5>Campo 8: message = APPROVED</h5><h5>Campo 9: referenceCode = 0f1c486e04cf2066d71648d38afa66e2</h5><h5>Campo 10: reference_pol = 1401551301</h5><h5>Campo 11: transactionId = 1899b890-fbc0-4470-acf4-df4c5e8cec9f</h5><h5>Campo 12: description = Test PAYU</h5><h5>Campo 13: trazabilityCode = CRED - 777276672</h5><h5>Campo 14: cus = CRED - 777276672</h5><h5>Campo 15: orderLanguage = es</h5><h5>Campo 16: extra1 = 24537</h5><h5>Campo 17: extra2 = </h5><h5>Campo 18: extra3 = </h5><h5>Campo 19: polTransactionState = 4</h5><h5>Campo 20: signature = 09d14e9c7ace67261b003ff7b5bc701f</h5><h5>Campo 21: polResponseCode = 1</h5><h5>Campo 22: lapResponseCode = APPROVED</h5><h5>Campo 23: risk = </h5><h5>Campo 24: polPaymentMethod = 10</h5><h5>Campo 25: lapPaymentMethod = VISA</h5><h5>Campo 26: polPaymentMethodType = 2</h5><h5>Campo 27: lapPaymentMethodType = CREDIT_CARD</h5><h5>Campo 28: installmentsNumber = 1</h5><h5>Campo 29: TX_VALUE = 50000.00</h5><h5>Campo 30: TX_TAX = .00</h5><h5>Campo 31: currency = COP</h5><h5>Campo 32: lng = es</h5><h5>Campo 33: pseCycle = </h5><h5>Campo 34: buyerEmail = jhon@example.com</h5><h5>Campo 35: pseBank = </h5><h5>Campo 36: pseReference1 = </h5><h5>Campo 37: pseReference2 = </h5><h5>Campo 38: pseReference3 = </h5><h5>Campo 39: authorizationCode = 210110</h5><h5>Campo 40: TX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 41: TX_TAX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 42: TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE = .00</h5><h5>Campo 43: processingDate = 2021-10-05</h5>'),
(4, '<h5>Campo 1: payment_method_type = 2</h5><h5>Campo 2: date = 2021.10.05 04:53:15</h5><h5>Campo 3: pse_reference3 = </h5><h5>Campo 4: pse_reference2 = </h5><h5>Campo 5: franchise = VISA</h5><h5>Campo 6: commision_pol = 0.00</h5><h5>Campo 7: pse_reference1 = </h5><h5>Campo 8: shipping_city = </h5><h5>Campo 9: bank_referenced_name = </h5><h5>Campo 10: sign = 14f27751bf0215f4f536207b916c7874</h5><h5>Campo 11: extra2 = </h5><h5>Campo 12: extra3 = </h5><h5>Campo 13: operation_date = 2021-10-05 16:53:15</h5><h5>Campo 14: billing_address = </h5><h5>Campo 15: payment_request_state = A</h5><h5>Campo 16: extra1 = ajs7</h5><h5>Campo 17: bank_id = 10</h5><h5>Campo 18: nickname_buyer = </h5><h5>Campo 19: payment_method = 10</h5><h5>Campo 20: attempts = 1</h5><h5>Campo 21: transaction_id = d3c64d4d-4ef5-497d-9e86-c8ab737fac59</h5><h5>Campo 22: transaction_date = 2021-10-05 16:53:15</h5><h5>Campo 23: test = 0</h5><h5>Campo 24: exchange_rate = 1.00</h5><h5>Campo 25: ip = 10.0.0.5</h5><h5>Campo 26: reference_pol = 1401551337</h5><h5>Campo 27: cc_holder = APPROVED</h5><h5>Campo 28: tax = 0.00</h5><h5>Campo 29: antifraudMerchantId = </h5><h5>Campo 30: pse_bank = </h5><h5>Campo 31: transaction_type = AUTHORIZATION_AND_CAPTURE</h5><h5>Campo 32: state_pol = 4</h5><h5>Campo 33: billing_city = </h5><h5>Campo 34: phone = 3014822371</h5><h5>Campo 35: error_message_bank = </h5><h5>Campo 36: shipping_country = CO</h5><h5>Campo 37: error_code_bank = 11</h5><h5>Campo 38: cus = CRED - 777603547</h5><h5>Campo 39: customer_number = </h5><h5>Campo 40: description = Test PAYU</h5><h5>Campo 41: merchant_id = 508029</h5><h5>Campo 42: authorization_code = 796049</h5><h5>Campo 43: currency = COP</h5><h5>Campo 44: shipping_address = </h5><h5>Campo 45: cc_number = ************7203</h5><h5>Campo 46: installments_number = 1</h5><h5>Campo 47: nickname_seller = </h5><h5>Campo 48: value = 50000.00</h5><h5>Campo 49: transaction_bank_id = 796049</h5><h5>Campo 50: billing_country = CO</h5><h5>Campo 51: cardType = DEBIT</h5><h5>Campo 52: response_code_pol = 1</h5><h5>Campo 53: payment_method_name = VISA</h5><h5>Campo 54: office_phone = </h5><h5>Campo 55: email_buyer = jhon@example.com</h5><h5>Campo 56: payment_method_id = 2</h5><h5>Campo 57: response_message_pol = APPROVED</h5><h5>Campo 58: account_id = 512321</h5><h5>Campo 59: bank_referenced_code = DEBIT</h5><h5>Campo 60: airline_code = </h5><h5>Campo 61: pseCycle = </h5><h5>Campo 62: risk = </h5><h5>Campo 63: reference_sale = eff61d4614d68873c0ac752f4cb15509</h5><h5>Campo 64: additional_value = 0.00</h5>'),
(5, '<h5>Campo 1: merchantId = 508029</h5><h5>Campo 2: merchant_name = Test PayU Test comercio</h5><h5>Campo 3: merchant_address = Av 123 Calle 12</h5><h5>Campo 4: telephone = 7512354</h5><h5>Campo 5: merchant_url = http://pruebaslapv.xtrweb.com</h5><h5>Campo 6: transactionState = 4</h5><h5>Campo 7: lapTransactionState = APPROVED</h5><h5>Campo 8: message = APPROVED</h5><h5>Campo 9: referenceCode = eff61d4614d68873c0ac752f4cb15509</h5><h5>Campo 10: reference_pol = 1401551337</h5><h5>Campo 11: transactionId = d3c64d4d-4ef5-497d-9e86-c8ab737fac59</h5><h5>Campo 12: description = Test PAYU</h5><h5>Campo 13: trazabilityCode = CRED - 777603547</h5><h5>Campo 14: cus = CRED - 777603547</h5><h5>Campo 15: orderLanguage = es</h5><h5>Campo 16: extra1 = ajs7</h5><h5>Campo 17: extra2 = </h5><h5>Campo 18: extra3 = </h5><h5>Campo 19: polTransactionState = 4</h5><h5>Campo 20: signature = 14f27751bf0215f4f536207b916c7874</h5><h5>Campo 21: polResponseCode = 1</h5><h5>Campo 22: lapResponseCode = APPROVED</h5><h5>Campo 23: risk = </h5><h5>Campo 24: polPaymentMethod = 10</h5><h5>Campo 25: lapPaymentMethod = VISA</h5><h5>Campo 26: polPaymentMethodType = 2</h5><h5>Campo 27: lapPaymentMethodType = CREDIT_CARD</h5><h5>Campo 28: installmentsNumber = 1</h5><h5>Campo 29: TX_VALUE = 50000.00</h5><h5>Campo 30: TX_TAX = .00</h5><h5>Campo 31: currency = COP</h5><h5>Campo 32: lng = es</h5><h5>Campo 33: pseCycle = </h5><h5>Campo 34: buyerEmail = jhon@example.com</h5><h5>Campo 35: pseBank = </h5><h5>Campo 36: pseReference1 = </h5><h5>Campo 37: pseReference2 = </h5><h5>Campo 38: pseReference3 = </h5><h5>Campo 39: authorizationCode = 796049</h5><h5>Campo 40: TX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 41: TX_TAX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 42: TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE = .00</h5><h5>Campo 43: processingDate = 2021-10-05</h5>'),
(6, '<h5>Campo 1: merchantId = 508029</h5><h5>Campo 2: merchant_name = Test PayU Test comercio</h5><h5>Campo 3: merchant_address = Av 123 Calle 12</h5><h5>Campo 4: telephone = 7512354</h5><h5>Campo 5: merchant_url = http://pruebaslapv.xtrweb.com</h5><h5>Campo 6: transactionState = 4</h5><h5>Campo 7: lapTransactionState = APPROVED</h5><h5>Campo 8: message = APPROVED</h5><h5>Campo 9: referenceCode = eff61d4614d68873c0ac752f4cb15509</h5><h5>Campo 10: reference_pol = 1401551337</h5><h5>Campo 11: transactionId = d3c64d4d-4ef5-497d-9e86-c8ab737fac59</h5><h5>Campo 12: description = Test PAYU</h5><h5>Campo 13: trazabilityCode = CRED - 777603547</h5><h5>Campo 14: cus = CRED - 777603547</h5><h5>Campo 15: orderLanguage = es</h5><h5>Campo 16: extra1 = ajs7</h5><h5>Campo 17: extra2 = </h5><h5>Campo 18: extra3 = </h5><h5>Campo 19: polTransactionState = 4</h5><h5>Campo 20: signature = 14f27751bf0215f4f536207b916c7874</h5><h5>Campo 21: polResponseCode = 1</h5><h5>Campo 22: lapResponseCode = APPROVED</h5><h5>Campo 23: risk = </h5><h5>Campo 24: polPaymentMethod = 10</h5><h5>Campo 25: lapPaymentMethod = VISA</h5><h5>Campo 26: polPaymentMethodType = 2</h5><h5>Campo 27: lapPaymentMethodType = CREDIT_CARD</h5><h5>Campo 28: installmentsNumber = 1</h5><h5>Campo 29: TX_VALUE = 50000.00</h5><h5>Campo 30: TX_TAX = .00</h5><h5>Campo 31: currency = COP</h5><h5>Campo 32: lng = es</h5><h5>Campo 33: pseCycle = </h5><h5>Campo 34: buyerEmail = jhon@example.com</h5><h5>Campo 35: pseBank = </h5><h5>Campo 36: pseReference1 = </h5><h5>Campo 37: pseReference2 = </h5><h5>Campo 38: pseReference3 = </h5><h5>Campo 39: authorizationCode = 796049</h5><h5>Campo 40: TX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 41: TX_TAX_ADMINISTRATIVE_FEE = .00</h5><h5>Campo 42: TX_TAX_ADMINISTRATIVE_FEE_RETURN_BASE = .00</h5><h5>Campo 43: processingDate = 2021-10-05</h5>'),
(7, '1'),
(8, '2'),
(9, '50000.00'),
(10, '50000'),
(11, '3dc47fa8d14507c902ff8577af7645ac'),
(12, 'bb0a451a7c59ca58b74dde62a5acc3f2'),
(13, '50000.00'),
(14, '500000'),
(15, '199f8c6ff990680fc1c50b9ad72f91ad'),
(16, 'cff33412c60bd426067dcb6de76a39a6'),
(17, '50000.00'),
(18, '50000.0'),
(19, 'eacecabe4c76f7cb8c3d9aca3de44764'),
(20, 'f78b26290921fca02a07e64ec46e5362'),
(21, ''),
(22, 'da5054b09f83f3eaa34e12dbe0fd4483'),
(23, '50000.0'),
(24, 'COP'),
(25, '4'),
(26, '2032f117487bdce289b167cb46281703'),
(27, '1889c04c957f83278cf8bf7311a088ea'),
(28, '508029'),
(29, 'fc78466d9fdf5c56e54bc690697beb1e'),
(30, '50000.0'),
(31, 'COP'),
(32, '4'),
(33, 'fc584d4456a0e24c0cf42f6af4ca073c'),
(34, 'fc584d4456a0e24c0cf42f6af4ca073c'),
(35, '3'),
(36, '508029'),
(37, '69190219b1451242b19405dfcec76716'),
(38, '50000.0'),
(39, 'COP'),
(40, '4'),
(41, '140e35c64fc24c0385ce761a9d6561fa'),
(42, '140e35c64fc24c0385ce761a9d6561fa'),
(43, '3'),
(44, '3'),
(45, ''),
(46, ''),
(47, '3'),
(48, '1002970732'),
(49, ''),
(50, '3'),
(51, '1002970732'),
(52, '190001'),
(53, '3'),
(54, '3'),
(55, 'hola soy un dato'),
(56, 'Subida a la base de datos 1593'),
(57, 'QR creado 1593'),
(58, 'Email enviado 1593'),
(59, 'SMS enviado 1593'),
(60, 'Subida a la base de datos 1949'),
(61, 'QR creado 1949'),
(62, 'Email enviado 1949'),
(63, 'SMS enviado 1949'),
(64, 'Subida a la base de datos 2574'),
(65, 'QR creado 2574'),
(66, 'Email enviado 2574'),
(67, 'SMS enviado 2574'),
(68, 'Subida a la base de datos 1593'),
(69, 'QR creado 1593'),
(70, 'Email enviado 1593'),
(71, 'SMS enviado 1593'),
(72, 'Subida a la base de datos 1949'),
(73, 'QR creado 1949'),
(74, 'Email enviado 1949'),
(75, 'SMS enviado 1949'),
(76, 'Subida a la base de datos 2574'),
(77, 'QR creado 2574'),
(78, 'Email enviado 2574'),
(79, 'SMS enviado 2574'),
(80, 'Subida a la base de datos 1593'),
(81, 'QR creado 1593'),
(82, 'Email enviado 1593'),
(83, 'SMS enviado 1593'),
(84, 'Subida a la base de datos 1949'),
(85, 'QR creado 1949'),
(86, 'Email enviado 1949'),
(87, 'SMS enviado 1949'),
(88, 'Subida a la base de datos 2574'),
(89, 'QR creado 2574'),
(90, 'Email enviado 2574'),
(91, 'SMS enviado 2574'),
(92, 'Subida a la base de datos 2752'),
(93, 'QR creado 2752'),
(94, 'Email enviado 2752'),
(95, 'SMS enviado 2752'),
(96, 'Subida a la base de datos 6337'),
(97, 'QR creado 6337'),
(98, 'Email enviado 6337'),
(99, 'SMS enviado 6337'),
(100, 'Subida a la base de datos 6609'),
(101, 'QR creado 6609'),
(102, 'Email enviado 6609'),
(103, 'SMS enviado 6609'),
(104, 'Subida a la base de datos 2752'),
(105, 'QR creado 2752'),
(106, 'Email enviado 2752'),
(107, 'SMS enviado 2752'),
(108, 'Subida a la base de datos 6337'),
(109, 'QR creado 6337'),
(110, 'Email enviado 6337'),
(111, 'SMS enviado 6337'),
(112, 'Subida a la base de datos 6609'),
(113, 'QR creado 6609'),
(114, 'Email enviado 6609'),
(115, 'SMS enviado 6609'),
(116, 'Subida a la base de datos 2752'),
(117, 'QR creado 2752'),
(118, 'Email enviado 2752'),
(119, 'SMS enviado 2752'),
(120, 'Subida a la base de datos 6337'),
(121, 'QR creado 6337'),
(122, 'Email enviado 6337'),
(123, 'SMS enviado 6337'),
(124, 'Subida a la base de datos 6609'),
(125, 'QR creado 6609'),
(126, 'Email enviado 6609'),
(127, 'SMS enviado 6609'),
(128, 'Subida a la base de datos 2740'),
(129, 'Subida a la base de datos 4358'),
(130, 'Subida a la base de datos 4374'),
(131, 'Subida a la base de datos 5933'),
(132, 'Subida a la base de datos 2594'),
(133, 'QR creado 2594'),
(134, 'Subida a la base de datos 8468'),
(135, 'QR creado 8468'),
(136, 'Subida a la base de datos 8534'),
(137, 'QR creado 8534'),
(138, 'Subida a la base de datos 1755'),
(139, 'QR creado 1755'),
(140, 'Email enviado 1755'),
(141, 'Subida a la base de datos 2338'),
(142, 'QR creado 2338'),
(143, 'Email enviado 2338'),
(144, 'Subida a la base de datos 6348'),
(145, 'QR creado 6348'),
(146, 'Email enviado 6348'),
(147, 'SMS enviado 9063'),
(148, 'SMS enviado 2321'),
(149, 'SMS enviado 8829'),
(150, 'SMS enviado 8566'),
(151, 'Sii entró'),
(152, 'Sii entró'),
(153, 'Sii entró'),
(154, 'Acabo de hacer un insert'),
(155, 'Acabo de hacer un insert AQUIII'),
(156, 'Acabo de hacer un insert AQUIII'),
(157, 'Aquiiii entre sii'),
(158, 'Aquiiii entre sii'),
(159, 'Funciona?'),
(160, 'Funciona?'),
(161, 'Sii entró'),
(162, 'Sii es POST'),
(163, 'Sii aprobo'),
(164, 'Firma correcta'),
(165, 'Sii entró'),
(166, 'Sii entró'),
(167, 'Sii entró'),
(168, 'Sii entró'),
(169, 'Sii entró'),
(170, 'Sii es POST'),
(171, 'Sii entró'),
(172, 'Sii entró'),
(173, 'Funciona ya mismo'),
(174, 'Sii entró');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_boleta` (`numero_boleta`),
  ADD KEY `referido_del_codigo` (`codigo_referido`);

--
-- Indexes for table `referidos`
--
ALTER TABLE `referidos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `ver_datos`
--
ALTER TABLE `ver_datos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ver_datos`
--
ALTER TABLE `ver_datos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `referido_del_codigo` FOREIGN KEY (`codigo_referido`) REFERENCES `referidos` (`codigo`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
