-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2022 a las 19:34:41
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ardental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonoscreditoscompras`
--

CREATE TABLE `abonoscreditoscompras` (
  `codabono` int(11) NOT NULL,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `medioabono` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `fechaabono` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonoscreditosventas`
--

CREATE TABLE `abonoscreditosventas` (
  `codabono` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `medioabono` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montoabono` decimal(12,2) NOT NULL,
  `fechaabono` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `abonoscreditosventas`
--

INSERT INTO `abonoscreditosventas` (`codabono`, `codcaja`, `codventa`, `codpaciente`, `medioabono`, `montoabono`, `fechaabono`, `codsucursal`) VALUES
(1, 3, '1', 'P4', 'EFECTIVO', '3580.00', '2021-12-10 11:23:57', 3),
(2, 3, '2', 'P1', 'EFECTIVO', '100.00', '2022-01-24 23:46:27', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accesosxsucursales`
--

CREATE TABLE `accesosxsucursales` (
  `codaccesoxsuc` int(11) NOT NULL,
  `codusuario` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `accesosxsucursales`
--

INSERT INTO `accesosxsucursales` (`codaccesoxsuc`, `codusuario`, `codsucursal`) VALUES
(12, 'E5', 1),
(13, 'E6', 2),
(14, 'E7', 2),
(15, 'E8', 2),
(16, 'E9', 1),
(17, 'E9', 2),
(18, 'E10', 2),
(19, 'E11', 2),
(20, 'E12', 2),
(21, 'E13', 1),
(22, 'E13', 2),
(23, 'E14', 2),
(24, 'U1', 0),
(30, 'U2', 0),
(39, 'U4', 3),
(40, 'U6', 0),
(43, 'U7', 4),
(44, 'E2', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arqueocaja`
--

CREATE TABLE `arqueocaja` (
  `codarqueo` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `montoinicial` decimal(12,2) NOT NULL,
  `efectivo` decimal(12,2) NOT NULL,
  `cheque` decimal(12,2) NOT NULL,
  `tcredito` decimal(12,2) NOT NULL,
  `tdebito` decimal(12,2) NOT NULL,
  `tprepago` decimal(12,2) NOT NULL,
  `transferencia` decimal(12,2) NOT NULL,
  `electronico` decimal(12,2) NOT NULL,
  `cupon` decimal(12,2) NOT NULL,
  `otros` decimal(12,2) NOT NULL,
  `creditos` decimal(12,2) NOT NULL,
  `abonosefectivo` decimal(12,2) NOT NULL,
  `abonosotros` decimal(12,2) NOT NULL,
  `ingresosefectivo` decimal(12,2) NOT NULL,
  `ingresosotros` decimal(12,2) NOT NULL,
  `egresos` decimal(12,2) NOT NULL,
  `nroticket` int(10) NOT NULL,
  `nronotaventa` int(10) NOT NULL,
  `nrofactura` int(10) NOT NULL,
  `dineroefectivo` decimal(12,2) NOT NULL,
  `diferencia` decimal(12,2) NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaapertura` datetime NOT NULL,
  `fechacierre` datetime NOT NULL,
  `statusarqueo` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `arqueocaja`
--

INSERT INTO `arqueocaja` (`codarqueo`, `codcaja`, `montoinicial`, `efectivo`, `cheque`, `tcredito`, `tdebito`, `tprepago`, `transferencia`, `electronico`, `cupon`, `otros`, `creditos`, `abonosefectivo`, `abonosotros`, `ingresosefectivo`, `ingresosotros`, `egresos`, `nroticket`, `nronotaventa`, `nrofactura`, `dineroefectivo`, `diferencia`, `comentarios`, `fechaapertura`, `fechacierre`, `statusarqueo`) VALUES
(2, 3, '0.00', '3680.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '30168.00', '0.00', '0.00', '0.00', '0.00', '0.00', 2, 1, 0, '0.00', '0.00', 'NINGUNO', '2021-12-08 12:37:51', '0000-00-00 00:00:00', 1),
(3, 4, '100.00', '300.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 0, 0, '0.00', '0.00', 'NINGUNO', '2022-10-18 11:02:27', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `codcaja` int(11) NOT NULL,
  `nrocaja` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomcaja` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`codcaja`, `nrocaja`, `nomcaja`, `codigo`, `codsucursal`) VALUES
(1, '1', '1', 'U2', 1),
(2, 'CAJAS2', 'CAJA2', 'U3', 3),
(3, '1', 'CAJ1', 'U4', 3),
(4, '10', '01', 'U7', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cie10`
--

CREATE TABLE `cie10` (
  `idcie` int(11) NOT NULL,
  `codcie` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombrecie` text COLLATE utf8_spanish_ci NOT NULL,
  `descripcioncie` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idcita` int(11) NOT NULL,
  `codcita` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codespecialista` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `fechacita` date NOT NULL,
  `horacita` time NOT NULL,
  `color` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `statuscita` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `ingresocita` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idcita`, `codcita`, `codespecialista`, `codpaciente`, `descripcion`, `fechacita`, `horacita`, `color`, `statuscita`, `codigo`, `codsucursal`, `ingresocita`) VALUES
(1, '01', 'E2', 'P1', 'ENDODONCIA', '2021-12-03', '08:00:00', '#0071c5', 'EN PROCESO', 'E2', 3, '2021-12-03'),
(2, '02', 'E2', 'P1', 'VALORACION', '2022-01-26', '23:37:00', '#40E0D0', 'EN PROCESO', 'U4', 3, '2022-01-24'),
(3, '03', 'E2', 'P1', 'SADASD', '2022-10-19', '21:29:00', '#0071c5', 'EN PROCESO', 'E2', 4, '2022-10-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idcompra` int(11) NOT NULL,
  `codcompra` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasic` decimal(12,2) NOT NULL,
  `subtotalivanoc` decimal(12,2) NOT NULL,
  `ivac` decimal(12,2) NOT NULL,
  `totalivac` decimal(12,2) NOT NULL,
  `descontadoc` decimal(12,2) NOT NULL,
  `descuentoc` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `totalpagoc` decimal(12,2) NOT NULL,
  `tipocompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formacompra` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creditopagado` decimal(12,2) NOT NULL,
  `fechavencecredito` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapagado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statuscompra` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaemision` date NOT NULL,
  `fecharecepcion` date NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `documsucursal` int(11) NOT NULL,
  `cuitsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfencargado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `pagina_web` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `documsucursal`, `cuitsucursal`, `nomsucursal`, `tlfsucursal`, `correosucursal`, `id_departamento`, `id_provincia`, `direcsucursal`, `documencargado`, `dniencargado`, `nomencargado`, `tlfencargado`, `codmoneda`, `pagina_web`) VALUES
(1, 1, '18633174', 'SOFTWARE ODONTOL&Oacute;GICO', '(144) 7225970', 'ELSAIYA@GMAIL.COM', 3, 11, 'AVENIDA ROMULO, CALLE 51 # 47-48', 16, '14322981', 'RUBEN DARIO CHIRINOS RODRIGUEZ', '(0414) 7225970', 0, 'https://www.ampleadmin.wrappixel.com/ampleadmin-html/ampleadmin-horizontal-nav/icon-material.html');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consentimientoinformado`
--

CREATE TABLE `consentimientoinformado` (
  `idconsentimiento` int(11) NOT NULL,
  `codconsentimiento` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codespecialista` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `procedimiento` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `observaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `doctestigo` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `nombretestigo` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `nofirmapaciente` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `fechaconsentimiento` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `idcotizacion` int(11) NOT NULL,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codespecialista` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `fechacotizacion` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`idcotizacion`, `codcotizacion`, `codpaciente`, `codespecialista`, `subtotalivasi`, `subtotalivano`, `iva`, `totaliva`, `descontado`, `descuento`, `totaldescuento`, `totalpago`, `totalpago2`, `fechacotizacion`, `observaciones`, `codigo`, `codsucursal`) VALUES
(2, '1', 'P3', 'E2', '0.00', '25616.00', '15.00', '0.00', '0.00', '0.00', '0.00', '25616.00', '25616.00', '2021-12-08 16:25:43', '', 'U4', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `creditosxpacientes`
--

CREATE TABLE `creditosxpacientes` (
  `codcredito` int(11) NOT NULL,
  `codpaciente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocredito` decimal(12,2) NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `creditosxpacientes`
--

INSERT INTO `creditosxpacientes` (`codcredito`, `codpaciente`, `montocredito`, `codsucursal`) VALUES
(1, 'P3', '26288.00', 3),
(2, 'P4', '3580.00', 3),
(3, 'P1', '300.00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `departamento`) VALUES
(11, 'LEON'),
(12, 'MASAYA'),
(13, 'MANAGUA'),
(14, 'ESTELI'),
(15, 'MATAGALPA'),
(16, 'BOACO'),
(17, 'SEBACO'),
(18, 'JINOTEGA'),
(19, 'RAAN'),
(20, 'RAAS'),
(21, 'NUEVA SEGOVIA'),
(22, 'CARAZO'),
(23, 'RIVAS'),
(24, 'RIO SAN JUAN'),
(25, 'CHINANDEGA '),
(26, 'GRANADA'),
(27, 'MADRIZ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `coddetallecompra` int(11) NOT NULL,
  `codcompra` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `preciocomprac` decimal(12,2) NOT NULL,
  `precioventac` decimal(12,2) NOT NULL,
  `cantcompra` int(15) NOT NULL,
  `ivaproductoc` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproductoc` decimal(12,2) NOT NULL,
  `descfactura` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentoc` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `lotec` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaelaboracionc` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaexpiracionc` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cotizaciones`
--

CREATE TABLE `detalle_cotizaciones` (
  `coddetallecotizacion` int(11) NOT NULL,
  `codcotizacion` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codmedida` int(11) NOT NULL,
  `cantventa` int(15) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_cotizaciones`
--

INSERT INTO `detalle_cotizaciones` (`coddetallecotizacion`, `codcotizacion`, `idproducto`, `codproducto`, `producto`, `codmarca`, `codpresentacion`, `codmedida`, `cantventa`, `preciocompra`, `precioventa`, `ivaproducto`, `descproducto`, `valortotal`, `totaldescuentov`, `valorneto`, `valorneto2`, `tipodetalle`, `codsucursal`) VALUES
(3, '1', 22, 'S21', 'ENDODONCIA ANTERIOR', 0, 0, 0, 2, '0.00', '5012.00', 'NO', '0.00', '10024.00', '0.00', '10024.00', '0.00', 1, 3),
(4, '1', 23, 'S22', 'ENDOPOSTE', 0, 0, 0, 2, '0.00', '716.00', 'NO', '0.00', '1432.00', '0.00', '1432.00', '0.00', 1, 3),
(5, '1', 28, 'S27', 'LIMPIEZA', 0, 0, 0, 1, '0.00', '800.00', 'NO', '0.00', '800.00', '0.00', '800.00', '0.00', 1, 3),
(6, '1', 16, 'S15', 'RESINA CLASE1', 0, 0, 0, 6, '0.00', '800.00', 'NO', '0.00', '4800.00', '0.00', '4800.00', '0.00', 1, 3),
(7, '1', 24, 'S23', 'RESINA CLASE 3', 0, 0, 0, 2, '0.00', '500.00', 'NO', '0.00', '1000.00', '0.00', '1000.00', '0.00', 1, 3),
(8, '1', 11, 'S10', 'EXODONCIA', 0, 0, 0, 1, '0.00', '400.00', 'NO', '0.00', '400.00', '0.00', '400.00', '0.00', 1, 3),
(9, '1', 19, 'S18', 'CORONA ZIRCONIO MONOLITICO', 0, 0, 0, 1, '0.00', '7160.00', 'NO', '0.00', '7160.00', '0.00', '7160.00', '0.00', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_traspasos`
--

CREATE TABLE `detalle_traspasos` (
  `coddetalletraspaso` int(11) NOT NULL,
  `codtraspaso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codmedida` int(11) NOT NULL,
  `cantidad` int(10) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `fechaexpiracion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `coddetalleventa` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codmedida` int(11) NOT NULL,
  `cantventa` int(15) NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `valortotal` decimal(12,2) NOT NULL,
  `totaldescuentov` decimal(12,2) NOT NULL,
  `valorneto` decimal(12,2) NOT NULL,
  `valorneto2` decimal(12,2) NOT NULL,
  `tipodetalle` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`coddetalleventa`, `codventa`, `idproducto`, `codproducto`, `producto`, `codmarca`, `codpresentacion`, `codmedida`, `cantventa`, `preciocompra`, `precioventa`, `ivaproducto`, `descproducto`, `valortotal`, `totaldescuentov`, `valorneto`, `valorneto2`, `tipodetalle`, `codsucursal`) VALUES
(6, '1', 13, 'S12', 'ENDODONCIA MOLAR', 0, 0, 0, 1, '0.00', '7160.00', 'NO', '0.00', '7160.00', '0.00', '7160.00', '0.00', 1, 3),
(7, '2', 11, 'S10', 'EXODONCIA', 0, 0, 0, 1, '0.00', '400.00', 'NO', '0.00', '400.00', '0.00', '400.00', '0.00', 1, 3),
(8, '1', 29, 'S28', 'BLANQUEAMIENTO', 0, 0, 0, 2, '150.00', '150.00', 'NO', '0.00', '300.00', '0.00', '300.00', '300.00', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE `documentos` (
  `coddocumento` int(11) NOT NULL,
  `documento` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`coddocumento`, `documento`, `descripcion`) VALUES
(1, 'RUC', 'REGISTRO UNICO DE CONTRIBUYENTES'),
(17, 'PASAPORTE', 'PASAPORTE'),
(18, 'CEDULA', 'IDENTIFICACION DE CEDULA'),
(19, 'OTRO', 'OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialistas`
--

CREATE TABLE `especialistas` (
  `idespecialista` int(11) NOT NULL,
  `codespecialista` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tpespecialista` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `documespecialista` int(11) NOT NULL,
  `cedespecialista` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `nomespecialista` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `tlfespecialista` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `sexoespecialista` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direcespecialista` text COLLATE utf8_spanish_ci NOT NULL,
  `correoespecialista` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `especialidad` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `fnacespecialista` date NOT NULL,
  `twitter` text COLLATE utf8_spanish_ci NOT NULL,
  `facebook` text COLLATE utf8_spanish_ci NOT NULL,
  `instagram` text COLLATE utf8_spanish_ci NOT NULL,
  `google` text COLLATE utf8_spanish_ci NOT NULL,
  `claveespecialista` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `especialistas`
--

INSERT INTO `especialistas` (`idespecialista`, `codespecialista`, `tpespecialista`, `documespecialista`, `cedespecialista`, `nomespecialista`, `tlfespecialista`, `sexoespecialista`, `id_departamento`, `id_provincia`, `direcespecialista`, `correoespecialista`, `especialidad`, `fnacespecialista`, `twitter`, `facebook`, `instagram`, `google`, `claveespecialista`) VALUES
(17, 'E2', '1', 1, '2022-00010', 'ALLAN ALBERTO ALVAREZ ROCHA', '(864) 02863', 'MASCULINO', 16, 118, 'BOACO , AV MODESTO DUARTE DE LA CRUZ ROJA 1C AL ESTE , FRENTE AL CAJERO BAC ,  CL&Iacute;NICA INTEGRAL  AR-DENTA', 'A30ROCHA93@GMAIL.COM', 'ENDONCIA', '1991-05-02', '', '', '', '', '$2y$10$Tj70Xzm1n71OvdbZkGQubOlI3wSNzDxZpdhJs14.AL93aPcKVKf5W');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `codhorario` int(11) NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `hora_desde` time NOT NULL,
  `hora_hasta` time NOT NULL,
  `busqueda` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`codhorario`, `codigo`, `hora_desde`, `hora_hasta`, `busqueda`) VALUES
(1, 'U2', '00:00:00', '23:00:00', 1),
(2, 'U3', '00:00:00', '24:00:00', 1),
(3, 'U5', '09:00:00', '23:00:00', 1),
(4, 'E1', '00:00:00', '23:00:00', 1),
(5, 'E10', '09:00:00', '16:00:00', 1),
(6, 'E14', '07:00:00', '10:00:00', 1),
(7, 'E13', '06:00:00', '18:00:00', 1),
(8, 'U6', '00:00:00', '23:00:00', 1),
(11, 'E3', '00:00:00', '23:00:00', 1),
(12, 'E2', '00:00:00', '23:00:00', 1),
(13, 'E4', '00:00:00', '23:00:00', 1),
(14, 'U4', '00:00:00', '23:45:00', 1),
(15, 'U7', '00:00:00', '23:59:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE `impuestos` (
  `codimpuesto` int(11) NOT NULL,
  `nomimpuesto` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `valorimpuesto` decimal(12,2) NOT NULL,
  `statusimpuesto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaimpuesto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`codimpuesto`, `nomimpuesto`, `valorimpuesto`, `statusimpuesto`, `fechaimpuesto`) VALUES
(1, 'IVA', '15.00', 'ACTIVO', '2021-05-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `codkardex` int(11) NOT NULL,
  `codproceso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codresponsable` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `movimiento` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `entradas` int(5) NOT NULL,
  `salidas` int(5) NOT NULL,
  `devolucion` int(5) NOT NULL,
  `stockactual` int(10) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `documento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechakardex` date NOT NULL,
  `tipokardex` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`codkardex`, `codproceso`, `codresponsable`, `codproducto`, `movimiento`, `entradas`, `salidas`, `devolucion`, `stockactual`, `ivaproducto`, `descproducto`, `precio`, `documento`, `fechakardex`, `tipokardex`, `codsucursal`) VALUES
(1, '6', '0', '6', 'ENTRADAS', 450, 0, 0, 450, 'SI', '0.00', '150.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(2, '20', '0', '20', 'ENTRADAS', 450, 0, 0, 450, 'SI', '0.00', '245.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(3, '7', '0', '7', 'ENTRADAS', 170, 0, 0, 170, 'SI', '0.00', '55.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(4, '18', '0', '18', 'ENTRADAS', 268, 0, 0, 268, 'SI', '0.00', '27.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(5, '10', '0', '10', 'ENTRADAS', 1610, 0, 0, 1610, 'SI', '0.00', '15.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(6, '1', '0', '1', 'ENTRADAS', 100, 0, 0, 100, 'SI', '0.00', '350.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(7, '19', '0', '19', 'ENTRADAS', 570, 0, 0, 570, 'SI', '0.00', '45.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(8, '5', '0', '5', 'ENTRADAS', 1300, 0, 0, 1300, 'SI', '0.00', '560.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(9, '4', '0', '4', 'ENTRADAS', 1350, 0, 0, 1350, 'SI', '0.00', '700.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(10, '11', '0', '11', 'ENTRADAS', 1196, 0, 0, 1196, 'SI', '0.00', '25.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(11, '12', '0', '12', 'ENTRADAS', 500, 0, 0, 500, 'SI', '0.00', '25.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(12, '9', '0', '9', 'ENTRADAS', 500, 0, 0, 500, 'SI', '0.00', '245.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(13, '13', '0', '13', 'ENTRADAS', 260, 0, 0, 260, 'SI', '0.00', '45.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(14, '14', '0', '14', 'ENTRADAS', 1500, 0, 0, 1500, 'SI', '0.00', '15.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(15, '15', '0', '15', 'ENTRADAS', 245, 0, 0, 245, 'SI', '0.00', '45.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(16, '2', '0', '2', 'ENTRADAS', 540, 0, 0, 540, 'SI', '0.00', '370.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(17, '16', '0', '16', 'ENTRADAS', 345, 0, 0, 345, 'SI', '0.00', '450.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(18, '8', '0', '8', 'ENTRADAS', 145, 0, 0, 145, 'SI', '0.00', '15.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(19, '3', '0', '3', 'ENTRADAS', 860, 0, 0, 860, 'SI', '0.00', '125.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(20, '17', '0', '17', 'ENTRADAS', 560, 0, 0, 560, 'SI', '0.00', '345.00', 'INVENTARIO INICIAL', '2021-05-12', 2, 1),
(21, '1', 'P203', 'S8', 'SALIDAS', 0, 2, 0, 0, 'SI', '0.00', '22.00', 'VENTA: 1', '2021-11-19', 1, 1),
(22, '1', 'P3', 'S22', 'SALIDAS', 0, 2, 0, 0, 'NO', '0.00', '716.00', 'VENTA: 1', '2021-12-08', 1, 3),
(23, '1', 'P3', 'S18', 'SALIDAS', 0, 2, 0, 0, 'NO', '0.00', '7016.00', 'VENTA: 1', '2021-12-08', 1, 3),
(24, '1', 'P3', 'S27', 'SALIDAS', 0, 1, 0, 0, 'NO', '0.00', '800.00', 'VENTA: 1', '2021-12-08', 1, 3),
(25, '1', 'P3', 'S21', 'SALIDAS', 0, 2, 0, 0, 'NO', '0.00', '5012.00', 'VENTA: 1', '2021-12-08', 1, 3),
(26, '1', 'P3', 'S22', 'DEVOLUCION', 0, 0, 2, 0, 'NO', '0.00', '716.00', 'DEVOLUCION VENTA: 1', '2021-12-08', 1, 3),
(27, '1', 'P3', 'S18', 'DEVOLUCION', 0, 0, 2, 0, 'NO', '0.00', '7016.00', 'DEVOLUCION VENTA: 1', '2021-12-08', 1, 3),
(28, '1', 'P3', 'S27', 'DEVOLUCION', 0, 0, 1, 0, 'NO', '0.00', '800.00', 'DEVOLUCION VENTA: 1', '2021-12-08', 1, 3),
(29, '1', 'P3', 'S21', 'DEVOLUCION', 0, 0, 2, 0, 'NO', '0.00', '5012.00', 'DEVOLUCION VENTA: 1', '2021-12-08', 1, 3),
(30, '1', 'P4', 'S12', 'SALIDAS', 0, 1, 0, 0, 'NO', '0.00', '7160.00', 'VENTA: 1', '2021-12-10', 1, 3),
(31, '2', 'P1', 'S10', 'SALIDAS', 0, 1, 0, 0, 'NO', '0.00', '400.00', 'VENTA: 2', '2022-01-24', 1, 3),
(32, '1', 'P1', 'S28', 'SALIDAS', 0, 2, 0, 0, 'NO', '0.00', '150.00', 'VENTA: 1', '2022-10-18', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tiempo` datetime DEFAULT NULL,
  `detalles` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `paginas` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`id`, `ip`, `tiempo`, `detalles`, `paginas`, `usuario`) VALUES
(1, '::1', '2021-11-21 17:26:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36 Edg/95.0.1020.53', '/softodontologia/index.php', 'HUMBERTO'),
(2, '::1', '2021-11-21 20:15:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36 Edg/95.0.1020.53', '/softodontologia/index.php', 'HUMBERTO'),
(3, '::1', '2021-11-23 00:00:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/softodontologia/index.php', 'HUMBERTO'),
(4, '::1', '2021-11-23 11:31:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(5, '::1', '2021-11-23 11:31:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(6, '::1', '2021-11-23 11:31:15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(7, '::1', '2021-11-23 11:31:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(8, '::1', '2021-11-23 11:31:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(9, '::1', '2021-11-23 11:32:57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36 Edg/96.0.1054.29', '/clinica/index.php', 'HUMBERTO'),
(10, '::1', '2021-11-29 11:37:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'HUMBERTO'),
(11, '::1', '2021-11-29 11:55:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO'),
(12, '::1', '2021-11-29 12:32:16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(13, '192.168.0.103', '2021-11-29 13:27:49', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0', '/index.php', 'CLIMEDENSE'),
(14, '192.168.0.102', '2021-11-29 13:31:54', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(15, '192.168.0.102', '2021-11-29 13:31:55', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(16, '192.168.1.21', '2021-12-02 12:37:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(17, '192.168.1.21', '2021-12-02 23:38:55', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(18, '192.168.1.21', '2021-12-02 23:59:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(19, '192.168.1.21', '2021-12-03 00:01:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(20, '192.168.1.21', '2021-12-03 00:31:35', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(21, '192.168.1.21', '2021-12-03 00:35:10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(22, '192.168.1.21', '2021-12-03 00:47:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', '2021123'),
(23, '192.168.1.21', '2021-12-03 00:57:48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', '2021123'),
(24, '192.168.1.21', '2021-12-03 01:05:38', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(25, '192.168.1.21', '2021-12-03 01:07:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(26, '192.168.1.21', '2021-12-03 01:09:56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'CLIMEDENSE'),
(27, '192.168.1.21', '2021-12-03 01:10:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(28, '192.168.1.21', '2021-12-03 01:18:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(29, '192.168.1.21', '2021-12-03 01:19:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', '4410205910005S'),
(30, '192.168.1.21', '2021-12-03 01:22:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', '4410205910005S'),
(31, '192.168.1.21', '2021-12-03 01:23:30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(32, '192.168.137.1', '2021-12-03 12:42:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(33, '10.100.1.107', '2021-12-03 12:48:25', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(34, '192.168.88.229', '2021-12-06 12:21:11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(35, '192.168.122.138', '2021-12-06 16:21:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36 Edg/95.0.1020.40', '/index.php', '4410205910005S'),
(36, '192.168.0.100', '2021-12-08 11:00:01', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(37, '192.168.0.101', '2021-12-08 13:07:40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36 Edg/95.0.1020.40', '/index.php', 'FRANCISCO1991'),
(38, '192.168.0.100', '2021-12-10 10:39:59', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.93 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(39, '::1', '2022-01-24 23:20:34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO'),
(40, '::1', '2022-01-24 23:23:14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO'),
(41, '::1', '2022-01-24 23:26:09', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO'),
(42, '::1', '2022-01-24 23:27:54', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO'),
(43, '::1', '2022-01-24 23:31:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(44, '::1', '2022-01-24 23:48:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO'),
(45, '::1', '2022-01-25 00:01:44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36', '/index.php', 'FRANCISCO1991'),
(46, '::1', '2022-01-27 22:34:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', '/index.php', 'FRANCISCO'),
(47, '::1', '2022-01-27 22:37:52', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', '/index.php', 'FRANCISCO'),
(48, '::1', '2022-01-27 22:39:06', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', '/index.php', 'FRANCISCO2020'),
(49, '::1', '2022-01-27 23:08:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36 Edg/97.0.1072.69', '/index.php', 'FRANCISCO2020'),
(50, '::1', '2022-01-27 23:56:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36 Edg/97.0.1072.69', '/clinica/index.php', 'FRANCISCO'),
(51, '::1', '2022-10-17 20:49:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(52, '::1', '2022-10-17 20:49:20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(53, '::1', '2022-10-17 20:49:21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(54, '::1', '2022-10-17 20:49:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(55, '::1', '2022-10-17 20:49:22', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(56, '::1', '2022-10-17 20:49:23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(57, '::1', '2022-10-17 20:49:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(58, '::1', '2022-10-17 20:49:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(59, '::1', '2022-10-17 20:49:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(60, '::1', '2022-10-17 20:49:28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(61, '::1', '2022-10-17 20:52:03', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENCHIRINOS'),
(62, '::1', '2022-10-17 20:59:39', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENPAREDES'),
(63, '::1', '2022-10-18 10:29:07', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 Edg/106.0.1370.47', '/clinica/index.php', 'RUBENPAREDES'),
(64, '::1', '2022-10-18 12:02:33', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'RUBENPAREDES'),
(65, '::1', '2022-10-18 12:06:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'DRALLAN'),
(66, '::1', '2022-10-18 12:20:32', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', '2022-00010'),
(67, '::1', '2022-10-18 12:24:27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'DRALLAN'),
(68, '::1', '2022-10-18 12:28:50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', '2022-00010'),
(69, '::1', '2022-10-18 12:29:02', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', '2022-00010'),
(70, '::1', '2022-10-18 12:30:26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'DRALLAN'),
(71, '::1', '2022-10-18 12:34:13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'ARDENTAL'),
(72, '::1', '2022-10-18 13:07:08', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36', '/clinica/index.php', 'DRALLAN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `codmarca` int(11) NOT NULL,
  `nommarca` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`codmarca`, `nommarca`) VALUES
(1, '3M '),
(2, 'A-dec '),
(3, 'A.A.L. '),
(4, 'ABRASIVE '),
(5, 'Ace '),
(6, 'ACKERMAN '),
(7, 'AD-ARZTBEDARF '),
(8, 'ADITEK '),
(9, 'AESCULAP '),
(10, 'AGM DENTAL '),
(11, 'AKZENTA '),
(12, 'AL DENTE '),
(13, 'ALAN '),
(14, 'ALBION '),
(15, 'ALLE '),
(16, 'AMCOR '),
(17, 'AMERICAN DENTAL '),
(18, 'Amoos '),
(19, 'ANGELUS '),
(20, 'ANIOS '),
(21, 'ANTHOGYR '),
(22, 'Apli '),
(23, 'APOZA '),
(24, 'Aquajet '),
(25, 'ARAGO '),
(26, 'ARE&Ntilde;OS '),
(27, 'AS TECHNOLOGY '),
(28, 'ASA DENTAL '),
(29, 'ASEPTONET '),
(30, 'Astar Orthodontics '),
(31, 'Astek Innovations '),
(32, 'Azules de Vergara '),
(33, 'B. BRAUN '),
(34, 'Bader '),
(35, 'BANDELIN '),
(36, 'BAUSCH '),
(37, 'BDT '),
(38, 'Beautone '),
(39, 'BECHT '),
(40, 'BEGO '),
(41, 'Bic '),
(42, 'BIEN AIR '),
(43, 'Bio Art by Mestra '),
(44, 'BIO-ART '),
(45, 'BIOCOSMETICS '),
(46, 'BIODINAMICA '),
(47, 'Bonka '),
(48, 'BONTEMPI '),
(49, 'BOSWORTH '),
(50, 'Buga '),
(51, 'CA-MI '),
(52, 'Calgonit '),
(53, 'CARDEX DENTAL '),
(54, 'CARDIVA '),
(55, 'CARESTREAM '),
(56, 'Carigol '),
(57, 'CARL MARTIN '),
(58, 'CATTANI '),
(59, 'CAVEX '),
(60, 'Cebralin '),
(61, 'CENTRIX '),
(62, 'CENTRO DI ORTODONCIA OPERATIVA '),
(63, 'Cep '),
(64, 'CHIMO '),
(65, 'Chips Ahoy '),
(66, 'Clairefontaine '),
(67, 'Clarben '),
(68, 'Colacao '),
(69, 'COLGATE '),
(70, 'Coltene '),
(71, 'Confezioni Cappello '),
(72, 'COOLIKE '),
(73, 'COPALITE '),
(74, 'CORIDENT '),
(75, 'COSMO M?DICA '),
(76, 'COXO '),
(77, 'CP Gaba '),
(78, 'Cristasol '),
(79, 'CSN INDUSTRIE '),
(80, 'CSP '),
(81, 'Curaden '),
(82, 'CURASAN '),
(83, 'CYTOPLAST '),
(84, 'DAHI '),
(85, 'DATUM DENTAL '),
(86, 'DC DentalCentral '),
(87, 'DE TREY '),
(88, 'DEDECO '),
(89, 'DEGREK '),
(90, 'DEGUDENT '),
(91, 'Delta '),
(92, 'DEMCO '),
(93, 'DENJOY '),
(94, 'DENLUX '),
(95, 'Denmat '),
(96, 'DENTAFLUX '),
(97, 'DENTAID '),
(98, 'DENTAL FORSCHUNG '),
(99, 'DENTAL RESOURCES '),
(100, 'Dental Therapeutics '),
(101, 'DENTAMERICA '),
(102, 'Dentaris '),
(103, 'DENTATUS '),
(104, 'DENTKIST '),
(105, 'DENTRADE '),
(106, 'DENTSPLY '),
(107, 'DERUNGS '),
(108, 'DETAX '),
(109, 'DIATECH '),
(110, 'DIGIMED '),
(111, 'DIRECTA '),
(112, 'DISPOTEX '),
(113, 'DKL '),
(114, 'DMEGA '),
(115, 'DMG '),
(116, 'Doctor Smile '),
(117, 'Dolce Gusto '),
(118, 'DONEGAN '),
(119, 'DR. HINZ '),
(120, 'DREVE DENTAMID '),
(121, 'DS '),
(122, 'DTE '),
(123, 'Durable '),
(124, 'Duracell '),
(125, 'DURR '),
(126, 'DUSTBIN '),
(127, 'DWS '),
(128, 'Eagle '),
(129, 'ECTB '),
(130, 'Edding '),
(131, 'EDENTA '),
(132, 'EDS '),
(133, 'EFFEGI '),
(134, 'EFFEGI BREGA '),
(135, 'Electro Medical Systems '),
(136, 'ELETTROLASER '),
(137, 'EMMEVI '),
(138, 'EMS '),
(139, 'Emtec '),
(140, 'ENGLE '),
(141, 'ERKODENT '),
(142, 'ERNST HINRICHS '),
(143, 'ESPOFA '),
(144, 'Esselte '),
(145, 'Essity Professional Hygiene '),
(146, 'ESTMON '),
(147, 'Ethicon Suturas '),
(148, 'Eurocel '),
(149, 'Eurofins Ingenasa '),
(150, 'EUROKLEE '),
(151, 'EURONDA '),
(152, 'EVE ERNST VETTER '),
(153, 'Exacompta '),
(154, 'Faber-Castell '),
(155, 'FACIDEN '),
(156, 'FAIOT '),
(157, 'FARO '),
(158, 'Fellowes '),
(159, 'FERRIS '),
(160, 'FILLI MANFREDI '),
(161, 'Five '),
(162, 'FKG '),
(163, 'FOMA '),
(164, 'Fontaneda '),
(165, 'FRASACO '),
(166, 'FREUDING '),
(167, 'FREUDING DENTAL + MEDICAL '),
(168, 'GANTER '),
(169, 'GARRISON '),
(170, 'GC '),
(171, 'GEBDI DENTALPRODUKTE '),
(172, 'GEBR. MARTIN '),
(173, 'GERDEX '),
(174, 'Gio '),
(175, 'GNZ Dental '),
(176, 'Gobble Surgical '),
(177, 'Goma-Camps '),
(178, 'GT Medical '),
(179, 'HAGER WERKEN '),
(180, 'Hahnenkrat '),
(181, 'HAHNENKRATT '),
(182, 'HAMMACHER '),
(183, 'HARTMANN '),
(184, 'HARVARD DENTAL INTERNATIONAL '),
(185, 'Hatho '),
(186, 'HAWE-NEOS '),
(187, 'HEDENT '),
(188, 'HEINE '),
(189, 'Hentschel-Dental '),
(190, 'Hercotex '),
(191, 'HOFFMANN DENTAL MANUFAKTUR '),
(192, 'HORICO '),
(193, 'Hornimans '),
(194, 'HPDENT '),
(195, 'HTW '),
(196, 'HU-FRIEDY '),
(197, 'HYGENIC '),
(198, 'Hygienio '),
(199, 'IC MEDICAL '),
(200, 'Icanclave '),
(201, 'IDELT '),
(202, 'IDEM '),
(203, 'Ikm '),
(204, 'IMAGE LEVEL '),
(205, 'Imation '),
(206, 'IMCD '),
(207, 'Imedio '),
(208, 'IMPACK '),
(209, 'Incotrading '),
(210, 'Indas '),
(211, 'Indensa '),
(212, 'INIBSA '),
(213, 'INMOCLINC '),
(214, 'INTENSIV '),
(215, 'ISO-C '),
(216, 'iTero '),
(217, 'IVOCLAR VIVADENT '),
(218, 'IVORY '),
(219, 'JINME '),
(220, 'JOHNSON & JOHNSON '),
(221, 'JORG AND SOHN '),
(222, 'Jota '),
(223, 'KAGER '),
(224, 'Karl Hammacher '),
(225, 'Katia '),
(226, 'KAVO '),
(227, 'KDM '),
(228, 'KDM by Fedesa '),
(229, 'KEMDENT '),
(230, 'Kentzler-Kaschner Dental '),
(231, 'KERR '),
(232, 'KETTENBACH '),
(233, 'KEYSTONE '),
(234, 'Kh-7 '),
(235, 'KIA '),
(236, 'KIKE TOYS '),
(237, 'KIMBERLY-CLARK '),
(238, 'KISAG '),
(239, 'Kit Calm '),
(240, 'KMD dental '),
(241, 'KOHLER '),
(242, 'KOMET '),
(243, 'KRAFIT '),
(244, 'Kulzer '),
(245, 'KUMAPAN '),
(246, 'KURARAY '),
(247, 'Kuss '),
(248, 'L&R ULTRASONICS '),
(249, 'L\'Arome '),
(250, 'LABOMED '),
(251, 'Lagarto '),
(252, 'Lares '),
(253, 'LARIDENT '),
(254, 'LASCOD '),
(255, 'Lavandera '),
(256, 'LAZON MEDICAL LASER '),
(257, 'LEGE ARTIS '),
(258, 'LEONE '),
(259, 'Lewa '),
(260, 'Liderpapel '),
(261, 'LM '),
(262, 'LORCA MARIN '),
(263, 'Luna '),
(264, 'LUZZANI DENTAL '),
(265, 'MA Dental '),
(266, 'Madespa '),
(267, 'MAGICA '),
(268, 'MAILLEFER '),
(269, 'MANI '),
(270, 'Mapelor '),
(271, 'MARATHON '),
(272, 'MARIOTTI '),
(273, 'MATEX '),
(274, 'Mavig '),
(275, 'MDC DENTAL '),
(276, 'MECTRON '),
(277, 'MED PROTECT '),
(278, 'MEDI-KORD '),
(279, 'MEDICAL & BUREAU SERVICES '),
(280, 'MEDICALINE '),
(281, 'Medin '),
(282, 'MEDIPAC '),
(283, 'MEDIT '),
(284, 'Meditrade '),
(285, 'MELAG '),
(286, 'MERZ DENTAL '),
(287, 'MESTRA '),
(288, 'META '),
(289, 'METASYS '),
(290, 'MGK '),
(291, 'MICRO NX '),
(292, 'MICROBRUSH '),
(293, 'MICROLAY '),
(294, 'MICROMEGA '),
(295, 'MICRON '),
(296, 'MIDWEST '),
(297, 'Milan '),
(298, 'Miquelrius '),
(299, 'MIRUSMIX '),
(300, 'Mistol '),
(301, 'MK DENT '),
(302, 'MOCOM '),
(303, 'MONOART '),
(304, 'MONOJECT '),
(305, 'MORITA '),
(306, 'MOYCO '),
(307, 'M?LLER-OMICRON '),
(308, 'Nat?o Sant? '),
(309, 'Navigator '),
(310, 'NELSON '),
(311, 'Nestle '),
(312, 'NEW LIFE RADIOLOGY '),
(313, 'NEW STETIC '),
(314, 'NEWMED '),
(315, 'NORDIN '),
(316, 'NORDISKA '),
(317, 'NORICUM IMPLANTS '),
(318, 'NORITAKE '),
(319, 'NORMON '),
(320, 'NORTH BEL '),
(321, 'NOUVAG '),
(322, 'NSK '),
(323, 'Olimpic '),
(324, 'OMNIA '),
(325, 'OMNIDENT '),
(326, 'ORAL B '),
(327, 'ORANGE DENTAL '),
(328, 'Oreo '),
(329, 'ORTHO TECHNOLOGY '),
(330, 'ORTOALRESA '),
(331, 'Osborn '),
(332, 'Otto Leibinger '),
(333, 'OWANDY '),
(334, 'PACIFIC ORTHODONTICS '),
(335, 'Paperflow '),
(336, 'PD '),
(337, 'PERFECTION P '),
(338, 'PERGUT '),
(339, 'PeriOptix '),
(340, 'Petrus '),
(341, 'PHILIPS '),
(342, 'PIERRE ROLAND '),
(343, 'PILARES LOCATOR '),
(344, 'Pilot '),
(345, 'PMD '),
(346, 'Polirapid '),
(347, 'POLODENT '),
(348, 'Polydentia '),
(349, 'Pool Chemical '),
(350, 'Post-it '),
(351, 'PREMIER '),
(352, 'Prevdent '),
(353, 'PRIME DENTAL '),
(354, 'Procter & Gamble '),
(355, 'PRODONT '),
(356, 'PROGENY '),
(357, 'PROLAX '),
(358, 'PROTECHNO '),
(359, 'PYREX '),
(360, 'Q-Connect '),
(361, 'Quattroti '),
(362, 'QUICKWHITE '),
(363, 'Raclac '),
(364, 'RAYSCAN '),
(365, 'REINER DENTAL '),
(366, 'REITEL '),
(367, 'RELIANCE '),
(368, 'RENFERT '),
(369, 'RESORBA MEDICAL '),
(370, 'REUS '),
(371, 'Rexel '),
(372, 'RINN '),
(373, 'RIPANO '),
(374, 'ROEKO '),
(375, 'RONTGEN-BENDER '),
(376, 'RONVIG '),
(377, 'RUMAR '),
(378, 'S&S Scheftner '),
(379, 'Saimaza '),
(380, 'SAM '),
(381, 'SANOFI '),
(382, 'SANOSIL '),
(383, 'SAREMCO '),
(384, 'SATELEC '),
(385, 'SCHEU-DENTAL '),
(386, 'Schiller '),
(387, 'Schuler '),
(388, 'SCH&Uuml;LKE &amp; MAYR '),
(389, 'SCICAN '),
(390, 'SCORE DENTAL '),
(391, 'Scotch '),
(392, 'Scottex '),
(393, 'SDI '),
(394, 'SEIL GLOBAL '),
(395, 'SEPTODONT '),
(396, 'SH BOSTON '),
(397, 'SHINHUNG '),
(398, 'Shining3D '),
(399, 'SHOFU '),
(400, 'SIGMA '),
(401, 'Silfradent '),
(402, 'SILVER LINE '),
(403, 'SINOL '),
(404, 'Sirio '),
(405, 'SIRONA '),
(406, 'SKS DENTAL '),
(407, 'SMARTDENT '),
(408, 'SMEG '),
(409, 'SOFTYS DENTAL '),
(410, 'Sogo '),
(411, 'Sonz '),
(412, 'SPD '),
(413, 'SPEIKO '),
(414, 'SPITTA VERLAG '),
(415, 'Spofa '),
(416, 'SPS MEDICAL '),
(417, 'Stabilo '),
(418, 'STABILOCK '),
(419, 'Staedtler '),
(420, 'STARLINE '),
(421, 'STERIBLUE '),
(422, 'Stoma Medical '),
(423, 'STRAUSS&CO '),
(424, 'STYL WAX '),
(425, 'STYLOFLAM '),
(426, 'Sultan '),
(427, 'Sultan Helthcare '),
(428, 'SUNSTAR '),
(429, 'SUPERMAX '),
(430, 'SURE ENDO '),
(431, 'Svenska Dentorama '),
(432, 'Swann Morton '),
(433, 'SWISS&WEGMAN '),
(434, 'SYBRONENDO '),
(435, 'TAKILON '),
(436, 'TANDEX '),
(437, 'TDK '),
(438, 'TECHNOFLUX '),
(439, 'TECNODENT '),
(440, 'TeKne Dental '),
(441, 'Tenn '),
(442, 'TEPE '),
(443, 'TERUMO '),
(444, 'Tesa '),
(445, 'TETENAL '),
(446, 'Tipp-Ex '),
(447, 'TOKUYAMA '),
(448, 'Top Ceram '),
(449, 'TOP MONOUSO '),
(450, 'Tork '),
(451, 'TRANSCODENT '),
(452, 'TROWER '),
(453, 'Tuc '),
(454, 'Tuttnauer '),
(455, 'TYCO '),
(456, 'ULTRADENT '),
(457, 'UNIDENT '),
(458, 'UNIVET '),
(459, 'VANNINI '),
(460, 'VARIOS '),
(461, 'vdw-zipperer '),
(462, 'Viakal '),
(463, 'VITA '),
(464, 'Vivochef '),
(465, 'VOCO '),
(466, 'W&H '),
(467, 'Walser '),
(468, 'WASSERMANN '),
(469, 'Wc Net '),
(470, 'WERTHER '),
(471, 'WHALEDENT '),
(472, 'WhaleSpray '),
(473, 'WHIP MIX '),
(474, 'WHITESMILE '),
(475, 'WOODPECKER '),
(476, 'WOSON '),
(477, 'WTS-Wassertechnik '),
(478, 'XENOX '),
(479, 'YETI '),
(480, 'Yosan '),
(481, 'ZHERMACK '),
(482, 'ZILFOR '),
(483, 'ZOLAR '),
(484, 'ZOLL '),
(485, 'ZUMAX MEDICAL ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medidas`
--

CREATE TABLE `medidas` (
  `codmedida` int(11) NOT NULL,
  `nommedida` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `medidas`
--

INSERT INTO `medidas` (`codmedida`, `nommedida`) VALUES
(1, '# 20 (32 MM)'),
(2, '# 27 (12.5 MM)'),
(3, '* 0.035 mg.'),
(4, '* 0.05 %'),
(5, '* 0.1 %'),
(6, '* 0.15 mg.'),
(7, '* 0.15 mg. / 0.03 mg.'),
(8, '* 0.2 % x 2.5 ml.'),
(9, '* 0.3 %'),
(10, '* 0.4 mg.'),
(11, '* 0.5 mg.'),
(12, '* 0.5 mg. / 0.4 mg.'),
(13, '* 0.5 ml.'),
(14, '* 1'),
(15, '* 1 g.'),
(16, '* 1 g. / 100 ml.'),
(17, '* 1 g. / 6 g.'),
(18, '* 1 in.'),
(19, '* 1 mg.'),
(20, '* 1 mg. / 160 mg. / 12.5mg.'),
(21, '* 1 ml.'),
(22, '* 1 onz.'),
(23, '* 1.1 kg.'),
(24, '* 1.100 g.'),
(25, '* 1.25 cm. / 0.90 m.'),
(26, '* 1.25 cm. / 1 m.'),
(27, '* 1.25 cm. / 4.50 m.'),
(28, '* 1.25 cm. / 9.14 m.'),
(29, '* 1.25 mg.'),
(30, '* 1.5 g.'),
(31, '* 1.5 mg.'),
(32, '* 1.5 ml.'),
(33, '* 1.88 g.'),
(34, '* 1/2'),
(35, '* 1/2 l.'),
(36, '* 10'),
(37, '* 10 500'),
(38, '* 10 cc.'),
(39, '* 10 g.'),
(40, '* 10 in.'),
(41, '* 10 mg.'),
(42, '* 10 mg. / 2.5 mg.'),
(43, '* 10 mg. / ml.'),
(44, '* 10 ml.'),
(45, '* 100'),
(46, '* 100 g.'),
(47, '* 100 mcg.'),
(48, '* 100 mg.'),
(49, '* 100 mg. / 150 mg.'),
(50, '* 100 mg. / 2.5 mg.'),
(51, '* 100 mg. / 300 mg.'),
(52, '* 100 mg. / 400 mg.'),
(53, '* 100 mg. / 5 ml.'),
(54, '* 100 mg. x 150 mg.'),
(55, '* 100 ml.'),
(56, '* 1000 mg.'),
(57, '* 1000 ml.'),
(58, '* 10000'),
(59, '* 101 g.'),
(60, '* 105 ml.'),
(61, '* 110 g.'),
(62, '* 1110 mg.'),
(63, '* 115 ml.'),
(64, '* 12'),
(65, '* 12 g.'),
(66, '* 12.5 g.'),
(67, '* 12.5 mg.'),
(68, '* 120 g.'),
(69, '* 120 mg.'),
(70, '* 120 mg. / 5 mg.'),
(71, '* 120 mg. x 600 mg. x 150 mg.'),
(72, '* 120 ml.'),
(73, '* 125 g .'),
(74, '* 125 g.'),
(75, '* 125 mcg.'),
(76, '* 125 mcg. '),
(77, '* 125 mg.'),
(78, '* 125 mg. / 10 mg.'),
(79, '* 125 mg. / 5 ml.'),
(80, '* 125 ml.'),
(81, '* 128'),
(82, '* 12x20 g.'),
(83, '* 13 ml.'),
(84, '* 130 mg.'),
(85, '* 130 ml.'),
(86, '* 14'),
(87, '* 14 g.'),
(88, '* 14.5 g.'),
(89, '* 140'),
(90, '* 140 mg.'),
(91, '* 15'),
(92, '* 15 g.'),
(93, '* 15 mg.'),
(94, '* 15 mg. / 1.5 ml.'),
(95, '* 15 mg. / 1500 mg.'),
(96, '* 15 mg. / 4 mg.'),
(97, '* 15 mg. x 120 ml.'),
(98, '* 15 ml.'),
(99, '* 150'),
(100, '* 150 g.'),
(101, '* 150 mg.'),
(102, '* 150 mg. / 10 mg.'),
(103, '* 150 ml.'),
(104, '* 1500 mg.'),
(105, '* 1500 mg. / 1200 mg.'),
(106, '* 152 ml.'),
(107, '* 16'),
(108, '* 16 g.'),
(109, '* 16 mg.'),
(110, '* 160 mg.'),
(111, '* 160 mg. / 12.5 mg.'),
(112, '* 160 mg. / 2 ml.'),
(113, '* 160 mg. / 5 mg.'),
(114, '* 160 mg. / 800 mg.'),
(115, '* 170 mg.'),
(116, '* 170 mg. / 80 mg.'),
(117, '* 175 mg.'),
(118, '* 18'),
(119, '* 18 g.'),
(120, '* 180 g.'),
(121, '* 180 ml.'),
(122, '* 1800 g.'),
(123, '* 187.5 mg. / 45 mg.'),
(124, '* 190 g.'),
(125, '* 190 ml.'),
(126, '* 2'),
(127, '* 2 in.'),
(128, '* 2 mg.'),
(129, '* 2 mg. / 0.51 mg.'),
(130, '* 2 mg. / 500 mg.'),
(131, '* 2 ml.'),
(132, '* 2 x 1'),
(133, '* 2.5 cm. / 0.9 m.'),
(134, '* 2.5 cm. / 1 m.'),
(135, '* 2.5 cm. / 9.14 m.'),
(136, '* 2.5 mg.'),
(137, '* 2.5 mg. / 0.625 mg.'),
(138, '* 2.5 mg. / 120 mg.'),
(139, '* 2.5 mg. / 2.5 ml.'),
(140, '* 2.5 ml.'),
(141, '* 2.50 cm. / 4.50 m.'),
(142, '* 2.63 g.'),
(143, '* 2.7 mg.'),
(144, '* 20'),
(145, '* 20 cc.'),
(146, '* 20 g.'),
(147, '* 20 mg.'),
(148, '* 20 mg. / 10 mg.'),
(149, '* 20 mg. / 12.5 mg.'),
(150, '* 20 mg. / 5 ml.'),
(151, '* 20 ml.'),
(152, '* 20 ml. / 400 mg.'),
(153, '* 20 ui'),
(154, '* 200'),
(155, '* 200 g.'),
(156, '* 200 mg.'),
(157, '* 200 mg. / 10 mg.'),
(158, '* 200 mg. / 250 mg.'),
(159, '* 200 mg. / 350 mg.'),
(160, '* 200 ml.'),
(161, '* 21'),
(162, '* 21 m.'),
(163, '* 210 g.'),
(164, '* 22'),
(165, '* 22 ml.'),
(166, '* 22.5 mg.'),
(167, '* 220 ml.'),
(168, '* 221 ml.'),
(169, '* 230 mg.'),
(170, '* 2312.50 mg. / 5 g.'),
(171, '* 235 cm.'),
(172, '* 24'),
(173, '* 24 10 / 10'),
(174, '* 24 7.5 / 7.5'),
(175, '* 24 mg.'),
(176, '* 24 ml.'),
(177, '* 240 cc.'),
(178, '* 240 mg.'),
(179, '* 240 ml.'),
(180, '* 2400'),
(181, '* 25'),
(182, '* 25 / 250 cmg.'),
(183, '* 25 / 250 mg.'),
(184, '* 25 / 50 cmg.'),
(185, '* 25 g.'),
(186, '* 25 mcg.'),
(187, '* 25 mg.'),
(188, '* 25 ml.'),
(189, '* 25 ui'),
(190, '* 250'),
(191, '* 250 cm. / 4.5 cm.'),
(192, '* 250 g.'),
(193, '* 250 mg.'),
(194, '* 250 mg. / 5 ml.'),
(195, '* 250 mg. / 5ml.'),
(196, '* 250 mg. / 62.5 mg.'),
(197, '* 250 mg. x 300 mg.'),
(198, '* 250 ml.'),
(199, '* 25000 mg.'),
(200, '* 252 mg.'),
(201, '* 26'),
(202, '* 263 mg.'),
(203, '* 275 mg.'),
(204, '* 28'),
(205, '* 28 ml.'),
(206, '* 280 mg.'),
(207, '* 3'),
(208, '* 3 g.'),
(209, '* 3 in.'),
(210, '* 3 mg.'),
(211, '* 3 mg. / 3 ml.'),
(212, '* 3 ml.'),
(213, '* 3 mm.'),
(214, '* 3 x 12'),
(215, '* 3.5 g.'),
(216, '* 3.5 mg.'),
(217, '* 3/4'),
(218, '* 30'),
(219, '* 30 '),
(220, '* 30 cc.'),
(221, '* 30 g.'),
(222, '* 30 g. / 8 mm.'),
(223, '* 30 mg.'),
(224, '* 30 mg. x 120 ml.'),
(225, '* 30 ml.'),
(226, '* 300 g.'),
(227, '* 300 mg.'),
(228, '* 300 mg. / 12,5 mg.'),
(229, '* 300 mg. / 12.5 mg.'),
(230, '* 300 mg. / 25 mg.'),
(231, '* 300 mg. / 250 mg.'),
(232, '* 300 ml.'),
(233, '* 312.5 mg. x 120 ml.'),
(234, '* 32'),
(235, '* 325 mg.'),
(236, '* 33 mg.'),
(237, '* 330 g.'),
(238, '* 340 g.'),
(239, '* 340 mg.'),
(240, '* 340 ml.'),
(241, '* 35'),
(242, '* 35 ml.'),
(243, '* 350 g.'),
(244, '* 350 ml.'),
(245, '* 36'),
(246, '* 36 g.'),
(247, '* 360 cc.'),
(248, '* 360 ml.'),
(249, '* 37.5 mg. / 500 mg.'),
(250, '* 375 g.'),
(251, '* 375 mg.'),
(252, '* 4'),
(253, '* 4 g.'),
(254, '* 4 in.'),
(255, '* 4 mg.'),
(256, '* 4 mg. / 400 mg.'),
(257, '* 4 mg. / 50 mg.'),
(258, '* 4.8 g.'),
(259, '* 4.8 g. / 5.5 ml.'),
(260, '* 40'),
(261, '* 40 g.'),
(262, '* 40 mg.'),
(263, '* 40 ml.'),
(264, '* 400'),
(265, '* 400 g.'),
(266, '* 400 mg'),
(267, '* 400 mg.'),
(268, '* 400 mg. / 1 mg.'),
(269, '* 400 mg. / 20 ml.'),
(270, '* 400 mg. / 57 mg.'),
(271, '* 400 mg. / 80 mg.'),
(272, '* 400 ml.'),
(273, '* 400 ml. + 120 ml.'),
(274, '* 400 ml. + 125 ml.'),
(275, '* 4000'),
(276, '* 4000000'),
(277, '* 415 ml.'),
(278, '* 420 mg.'),
(279, '* 435 mg.'),
(280, '* 44'),
(281, '* 45'),
(282, '* 45 g.'),
(283, '* 45 ml.'),
(284, '* 450 mg.'),
(285, '* 457 mg. / 5 ml. x 70 ml.'),
(286, '* 47 cm.'),
(287, '* 48'),
(288, '* 48 g.'),
(289, '* 480 mg. / 100 mg.'),
(290, '* 5'),
(291, '* 5 %'),
(292, '* 5 g.'),
(293, '* 5 in.'),
(294, '* 5 mg.'),
(295, '* 5 mg. / 0.25 mg.'),
(296, '* 5 mg. / 1.25 mg.'),
(297, '* 5 mg. / 10 mg. / 500 mg.'),
(298, '* 5 mg. / 120 mg. '),
(299, '* 5 mg. / 30 mg.'),
(300, '* 5 mg. / 5 ml.'),
(301, '* 5 mg. x 120 mg.'),
(302, '* 5 mg. x 30 mg.'),
(303, '* 5 ml.'),
(304, '* 50'),
(305, '* 50 g.'),
(306, '* 50 mcg.'),
(307, '* 50 mg.'),
(308, '* 50 mg. / 500 mg.'),
(309, '* 50 ml.'),
(310, '* 500 g.'),
(311, '* 500 mg.'),
(312, '* 500 mg. / 10 mg. / 5 mg.'),
(313, '* 500 mg. / 125 mg.'),
(314, '* 500 mg. / 2 ml.'),
(315, '* 500 mg. / 2.5 mg.'),
(316, '* 500 mg. / 200 mg.'),
(317, '* 500 mg. / 5 mg.'),
(318, '* 500 mg. / 60 mg. / 4 mg.'),
(319, '* 500 mg. / 65 mg.'),
(320, '* 500 mg. x 4 mg. x 60 mg.'),
(321, '* 500 ml.'),
(322, '* 52'),
(323, '* 530 ml.'),
(324, '* 550 mg.'),
(325, '* 550 ml.'),
(326, '* 56 g.'),
(327, '* 564 mg.'),
(328, '* 565 mg.'),
(329, '* 57 g.'),
(330, '* 575 mg.'),
(331, '* 597 mg.'),
(332, '* 5ml.'),
(333, '* 6'),
(334, '* 6 in.'),
(335, '* 6 mg.'),
(336, '* 60'),
(337, '* 60 cc.'),
(338, '* 60 g.'),
(339, '* 60 mg.'),
(340, '* 60 mg. / 120 mg.'),
(341, '* 60 mg. / 2 ml.'),
(342, '* 60 ml.'),
(343, '* 60 ml. / 250 mg.'),
(344, '* 60 ml. / 500 mg. '),
(345, '* 600 mg.'),
(346, '* 600 mg. / 2 ml.'),
(347, '* 625 mg.'),
(348, '* 65 g.'),
(349, '* 7 in.'),
(350, '* 7 mg.'),
(351, '* 7,5 mg.'),
(352, '* 7.5 cm. / 9.14 m.'),
(353, '* 7.5 mg.'),
(354, '* 7.5 ml.'),
(355, '* 70 g.'),
(356, '* 70 mg.'),
(357, '* 70 ml.'),
(358, '* 700 mg.'),
(359, '* 72'),
(360, '* 730 ml.'),
(361, '* 75'),
(362, '* 75 cc.'),
(363, '* 75 g.'),
(364, '* 75 mcg.'),
(365, '* 75 mg.'),
(366, '* 75 ml.'),
(367, '* 750 mg.'),
(368, '* 750 ml.'),
(369, '* 760 mg.'),
(370, '* 8'),
(371, '* 8 g.'),
(372, '* 8 in.'),
(373, '* 8 mg.'),
(374, '* 8 ml.'),
(375, '* 80'),
(376, '* 80 g.'),
(377, '* 80 mg'),
(378, '* 80 mg.'),
(379, '* 80 mg. / 10 mg.'),
(380, '* 80 mg. / 2 ml.'),
(381, '* 80 ml.'),
(382, '* 800 g.'),
(383, '* 800 mg.'),
(384, '* 800 mg. / 160 mg.'),
(385, '* 81 mg.'),
(386, '* 850 mg.'),
(387, '* 875 mg.'),
(388, '* 875 mg. / 125 mg.'),
(389, '* 88 mcg.'),
(390, '* 89 ml.'),
(391, '* 9 g.'),
(392, '* 9 in.'),
(393, '* 90'),
(394, '* 90 cm.'),
(395, '* 90 g.'),
(396, '* 90 mg.'),
(397, '* 90 ml.'),
(398, '* 900 g.'),
(399, '* 900 mg.'),
(400, '* 95 g.'),
(401, '* 96'),
(402, '* 96.50 mg'),
(403, '* AA'),
(404, '* AA ALCALINA'),
(405, '* AAA'),
(406, '* AAA ALCALINA'),
(407, 'No. 16'),
(408, 'No. 18'),
(409, 'No. 20'),
(410, 'No. 21'),
(411, 'No. 22'),
(412, 'No. 23'),
(413, 'No. 24'),
(414, 'No. 8'),
(415, '* 650 MG.'),
(416, '* 64 ML.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `codmensaje` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subject` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoscajas`
--

CREATE TABLE `movimientoscajas` (
  `codmovimiento` int(11) NOT NULL,
  `codcaja` int(11) NOT NULL,
  `tipomovimiento` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descripcionmovimiento` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montomovimiento` decimal(12,2) NOT NULL,
  `mediomovimiento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechamovimiento` datetime NOT NULL,
  `codarqueo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontologia`
--

CREATE TABLE `odontologia` (
  `idodontologia` int(11) NOT NULL,
  `codcita` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `cododontologia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codespecialista` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tratamientomedico` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cualestratamiento` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `ingestamedicamentos` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cualesingesta` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `alergias` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cualesalergias` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `hemorragias` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cualeshemorragias` varchar(80) CHARACTER SET latin1 NOT NULL,
  `sinositis` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `enfermedadrespiratoria` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `diabetes` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `cardiopatia` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `hepatitis` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `hepertension` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `asistenciaodontologica` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `ultimavisitaodontologia` date NOT NULL,
  `cepillado` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `cuantoscepillados` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `sedadental` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `cuantascedasdental` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `cremadental` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `enjuague` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `sangranencias` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `tomaaguallave` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `elementosconfluor` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `aparatosortodoncia` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `protesis` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `protesisfija` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `protesisremovible` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `labios` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `lengua` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `paladar` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `pisoboca` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `carrillos` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `glandulasalivales` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `maxilar` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `senosmaxilares` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `musculosmasticadores` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `sistemanervioso` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `sistemavascular` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `sistemalinfatico` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `funcionoclusal` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `observacionperiodontal` text COLLATE utf8_spanish_ci NOT NULL,
  `supernumerarios` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `adracion` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `manchas` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `patologiapulpar` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `placablanda` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `placacalificada` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `otrosdental` varchar(35) COLLATE utf8_spanish_ci NOT NULL,
  `observacionexamendental` text COLLATE utf8_spanish_ci NOT NULL,
  `presuntivo` text COLLATE utf8_spanish_ci NOT NULL,
  `definitivo` text COLLATE utf8_spanish_ci NOT NULL,
  `pronostico` text COLLATE utf8_spanish_ci NOT NULL,
  `plantratamiento` text COLLATE utf8_spanish_ci NOT NULL,
  `observacionestratamiento` text COLLATE utf8_spanish_ci NOT NULL,
  `fechaodontologia` datetime NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `idpaciente` int(11) NOT NULL,
  `codpaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `documpaciente` int(11) NOT NULL,
  `cedpaciente` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pnompaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `snompaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `papepaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `sapepaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `fnacpaciente` date NOT NULL,
  `tlfpaciente` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `emailpaciente` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `gruposapaciente` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `estadopaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `ocupacionpaciente` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `sexopaciente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `enfoquepaciente` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direcpaciente` text COLLATE utf8_spanish_ci NOT NULL,
  `nomacompana` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `direcacompana` text COLLATE utf8_spanish_ci NOT NULL,
  `tlfacompana` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `parentescoacompana` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nomresponsable` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `direcresponsable` text COLLATE utf8_spanish_ci NOT NULL,
  `tlfresponsable` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `parentescoresponsable` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `clavepaciente` longtext COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`idpaciente`, `codpaciente`, `documpaciente`, `cedpaciente`, `pnompaciente`, `snompaciente`, `papepaciente`, `sapepaciente`, `fnacpaciente`, `tlfpaciente`, `emailpaciente`, `gruposapaciente`, `estadopaciente`, `ocupacionpaciente`, `sexopaciente`, `enfoquepaciente`, `id_departamento`, `id_provincia`, `direcpaciente`, `nomacompana`, `direcacompana`, `tlfacompana`, `parentescoacompana`, `nomresponsable`, `direcresponsable`, `tlfresponsable`, `parentescoresponsable`, `clavepaciente`) VALUES
(7, 'P1', 18, '7548227240', 'DEMO', 'DEMO', 'DEMO', 'DEMO', '1997-07-04', '78224522555', 'clinica@gmail.com', '00', 'SOLTERO(A)', 'Generico', '00', 'OTRO', 16, 118, 'Generico', '', '', '0000000', '', '', '', '0000000', '', '$2y$10$9O8tc41wJuDLn4ifeSfvV..NJOQH.O7G8SiM3wGXLnERygL.hrEv6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `codpresentacion` int(11) NOT NULL,
  `nompresentacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`codpresentacion`, `nompresentacion`) VALUES
(1, 'UNIDAD'),
(2, 'PAQUETE'),
(3, 'BOTELLA'),
(4, 'GALON'),
(5, 'LITRO'),
(6, 'BOLSAS'),
(7, 'CAJAS'),
(8, 'FRASCOS'),
(9, 'ROLLOS'),
(10, 'KIT'),
(11, 'CAJA X 100 UNIDADES'),
(12, 'TUBO X 15 G'),
(13, 'TUBO X 30 G'),
(14, 'FRASCO X 10 ML'),
(15, 'FRASCO X 100 UNIDADES'),
(16, 'CAJA X 7 UNIDADES'),
(17, 'CAJA X 10 UNIDADES'),
(18, 'CAJA X 30 UNIDADES'),
(19, 'CAJA X 60 UNIDADES'),
(20, 'FRASCO X 25 ML'),
(21, 'FRASCO X 60 ML'),
(22, 'FRASCO X 100 ML'),
(23, 'FRASCO X 120 ML'),
(24, 'FRASCO X 240 ML'),
(25, 'UNIDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `codproducto` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `producto` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codmarca` int(11) NOT NULL,
  `codpresentacion` int(11) NOT NULL,
  `codmedida` int(11) NOT NULL,
  `lote` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `existencia` int(5) NOT NULL,
  `stockminimo` int(5) NOT NULL,
  `stockmaximo` int(5) NOT NULL,
  `ivaproducto` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descproducto` decimal(12,2) NOT NULL,
  `fechaelaboracion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaexpiracion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `stockteorico` int(10) NOT NULL,
  `motivoajuste` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `codproducto`, `producto`, `codmarca`, `codpresentacion`, `codmedida`, `lote`, `preciocompra`, `precioventa`, `existencia`, `stockminimo`, `stockmaximo`, `ivaproducto`, `descproducto`, `fechaelaboracion`, `fechaexpiracion`, `codproveedor`, `stockteorico`, `motivoajuste`, `codsucursal`) VALUES
(1, '6', 'ACIDO ORTOFOSFORICO', 353, 3, 0, '0', '150.00', '170.00', 450, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P4', 0, 'NINGUNO', 1),
(2, '20', 'ACIDO PORCELAIN ETCH', 189, 1, 208, '0', '245.00', '285.00', 450, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(3, '7', 'ADHESIVO', 353, 1, 0, '0', '55.00', '62.00', 170, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(4, '18', 'ADHESIVO SINGLE BOND UNIVERSAL', 1, 1, 13, '0', '27.00', '32.00', 268, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(5, '10', 'AGUJAS', 10, 1, 0, '0', '15.00', '22.00', 1610, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(6, '1', 'ASPIRADORES DE SALIVA', 303, 1, 0, '0', '350.00', '380.00', 100, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(7, '19', 'BARRERA GINGIVAL OPALDAM GREEN', 1, 1, 13, '0', '45.00', '55.00', 570, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 1),
(8, '5', 'BRACKETS ESTETICOS DE ZAFIRO MONOCRISTALINO', 406, 1, 0, '0', '560.00', '590.00', 1300, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(9, '4', 'BRACKETS METALICOS', 406, 1, 0, '0', '700.00', '790.00', 1350, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(10, '11', 'COMPRESAS', 8, 2, 0, '0', '25.00', '33.00', 1196, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 1),
(11, '12', 'EYECTORES', 129, 1, 0, '0', '25.00', '30.00', 500, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 1),
(12, '9', 'FLUOR', 96, 2, 0, '0', '245.00', '280.00', 500, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 1),
(13, '13', 'GASAS', 46, 2, 0, '0', '45.00', '55.00', 260, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(14, '14', 'GUANTES', 1, 1, 0, '0', '15.00', '22.00', 1500, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(15, '15', 'HILO RETRACTOR', 231, 2, 0, '0', '45.00', '65.00', 245, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(16, '2', 'MASCARILLAS', 303, 2, 0, '0', '370.00', '420.00', 540, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(17, '16', 'PROVICOL VOCO', 465, 1, 0, '0', '450.00', '520.00', 345, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P4', 0, 'NINGUNO', 1),
(18, '8', 'SELLADOR', 353, 1, 0, '0', '15.00', '22.00', 145, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P3', 0, 'NINGUNO', 1),
(19, '3', 'VASOS', 303, 1, 0, '0', '125.00', '140.00', 860, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P1', 0, 'NINGUNO', 1),
(20, '17', 'ZETAPLUS L INTRO', 481, 1, 94, '0', '345.00', '370.00', 560, 0, 0, 'SI', '0.00', '0000-00-00', '0000-00-00', 'P2', 0, 'NINGUNO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `codproveedor` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documproveedor` int(11) NOT NULL,
  `cuitproveedor` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nomproveedor` varchar(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `tlfproveedor` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direcproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `emailproveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `vendedor` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `codproveedor`, `documproveedor`, `cuitproveedor`, `nomproveedor`, `tlfproveedor`, `id_departamento`, `id_provincia`, `direcproveedor`, `emailproveedor`, `vendedor`, `fechaingreso`) VALUES
(1, 'P1', 1, '10451248495', 'TREPOLS SAS', '(444) 4444444', 2, 12, 'JR HUANTA 11', 'CCVO@JBLSERVICEPERU.COM', 'JULIAN RENGIFO', '2019-02-13'),
(2, 'P2', 1, '3488729001-J', 'FARMACIA LA QUERENCIA', '(416) 7642234', 2, 20, 'LA CONCORDIA', 'VENTASMOTORED@GMAIL.COM', 'LCDO. JORGE LUIS CAMACHO', '2019-02-13'),
(3, 'P3', 2, '872445162-J', 'LA PROCADORA SAS', '(416) 7652345', 4, 53, 'AL LADO DEL CC MURALLA', 'MOTIC@GMAIL.COM', 'SRA. CARMEN ALICIA CONTRERAS', '2019-02-13'),
(4, 'P4', 1, '00235998745-7', 'LAREL ODONTOLOGICA', '(274) 9986589', 3, 31, 'CALLE PRINCIPAL', 'MURALLA12@GMAIL.COM', 'LICDO. JESUS CARDOZO', '2019-04-30'),
(5, 'P5', 18, '1234567', 'ORTODENTAL', '(123) 456', 0, 13, 'AQUI ALLA', 'PANCHO@GMAIL.COM', 'ZAHERIS', '2021-12-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id_provincia` int(11) NOT NULL,
  `provincia` varchar(250) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id_provincia`, `provincia`, `id_departamento`) VALUES
(113, 'LEON', 11),
(114, 'MANAGUA', 13),
(115, 'SEBACO', 15),
(116, 'DARIO', 15),
(117, 'SAN ISIDRO', 15),
(118, 'BOACO', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciasodontograma`
--

CREATE TABLE `referenciasodontograma` (
  `codreferencia` int(11) NOT NULL,
  `codcita` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `estados` text COLLATE utf8_spanish_ci NOT NULL,
  `fecharegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `referenciasodontograma`
--

INSERT INTO `referenciasodontograma` (`codreferencia`, `codcita`, `codpaciente`, `codsucursal`, `estados`, `fecharegistro`) VALUES
(2, '02', 'P1', 3, 'D17_C5_17-ORTHO Tratamiento de Ortodoncia__D27_C5_17-ORTHO Tratamiento de Ortodoncia', '2022-01-24 11:42:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idservicio` int(11) NOT NULL,
  `codservicio` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `servicio` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `preciocompra` decimal(12,2) NOT NULL,
  `precioventa` decimal(12,2) NOT NULL,
  `ivaservicio` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descservicio` decimal(12,2) NOT NULL,
  `status` int(2) NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idservicio`, `codservicio`, `servicio`, `preciocompra`, `precioventa`, `ivaservicio`, `descservicio`, `status`, `codsucursal`) VALUES
(1, 'S1', 'EXAMEN BUCODENTAL INICIAL', '20.00', '56.00', 'SI', '0.00', 1, 1),
(2, 'S2', 'PROCEDIMIENTOS DE OBTURACI&Oacute;N O LLENADO DENTAL', '45.00', '48.00', 'SI', '0.00', 1, 1),
(3, 'S3', 'EXTRACCIONES DENTALES', '32.00', '35.00', 'SI', '0.00', 1, 1),
(4, 'S4', 'SERVICIOS DE LIMPIEZA DENTAL', '40.00', '42.00', 'SI', '0.00', 1, 1),
(5, 'S5', 'ORTODONCIA', '38.00', '44.00', 'SI', '0.00', 1, 1),
(6, 'S6', 'TRATAMIENTOS DE BLANQUEAMIENTO', '27.00', '33.00', 'SI', '0.00', 1, 1),
(7, 'S7', 'PUENTES DENTALES', '45.00', '52.00', 'SI', '0.00', 1, 1),
(8, 'S8', 'TRATAMIENTOS DE NERVIO', '17.00', '22.00', 'SI', '0.00', 1, 1),
(9, 'S9', 'CARILLAS DENTALES', '24.00', '27.00', 'SI', '0.00', 1, 1),
(11, 'S10', 'EXODONCIA', '0.00', '400.00', 'NO', '0.00', 1, 3),
(12, 'S11', 'PROTESIS TOTAL SUPERIOR INFERIOR', '0.00', '3500.00', 'NO', '0.00', 1, 3),
(13, 'S12', 'ENDODONCIA MOLAR', '0.00', '7160.00', 'NO', '0.00', 1, 3),
(14, 'S13', 'CIRUGIA CORDAL', '0.00', '5370.00', 'NO', '0.00', 1, 3),
(15, 'S14', 'ENDODONCIA PREMOLAR', '0.00', '5000.00', 'NO', '0.00', 1, 3),
(16, 'S15', 'RESINA CLASE1', '0.00', '800.00', 'NO', '0.00', 1, 3),
(17, 'S16', 'RESINA CLASE 2', '0.00', '1000.00', 'NO', '0.00', 1, 3),
(18, 'S17', 'BLANQUEAMIENTO DENTAL', '0.00', '3580.00', 'NO', '0.00', 1, 3),
(19, 'S18', 'CORONA ZIRCONIO MONOLITICO', '0.00', '8950.00', 'NO', '0.00', 1, 3),
(20, 'S19', 'CORONA METAL PORCELANA', '0.00', '5728.00', 'NO', '0.00', 1, 3),
(21, 'S20', 'CORONA METAL ACRILICO', '0.00', '1790.00', 'NO', '0.00', 1, 3),
(22, 'S21', 'ENDODONCIA ANTERIOR', '0.00', '4296.00', 'NO', '0.00', 1, 3),
(23, 'S22', 'ENDOPOSTE', '0.00', '1432.00', 'NO', '0.00', 1, 3),
(24, 'S23', 'RESINA CLASE 3', '0.00', '400.00', 'NO', '0.00', 1, 3),
(25, 'S24', 'RESINA CLASE 5', '0.00', '400.00', 'NO', '0.00', 1, 3),
(26, 'S25', 'REMOVIBLE METALICO', '0.00', '8000.00', 'NO', '0.00', 1, 3),
(27, 'S26', 'RADIOGRAFIA', '0.00', '350.00', 'NO', '0.00', 1, 3),
(28, 'S27', 'LIMPIEZA', '0.00', '800.00', 'NO', '0.00', 1, 3),
(29, 'S28', 'BLANQUEAMIENTO', '150.00', '150.00', 'NO', '0.00', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `codsucursal` int(11) NOT NULL,
  `nrosucursal` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documsucursal` int(11) NOT NULL,
  `cuitsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `direcsucursal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `correosucursal` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfsucursal` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nroactividadsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicioticket` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `inicionotaventa` varchar(30) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `iniciofactura` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaautorsucursal` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `llevacontabilidad` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `documencargado` int(11) NOT NULL,
  `dniencargado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `nomencargado` varchar(120) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tlfencargado` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `descsucursal` decimal(12,2) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `codmoneda2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`codsucursal`, `nrosucursal`, `documsucursal`, `cuitsucursal`, `nomsucursal`, `id_departamento`, `id_provincia`, `direcsucursal`, `correosucursal`, `tlfsucursal`, `nroactividadsucursal`, `inicioticket`, `inicionotaventa`, `iniciofactura`, `fechaautorsucursal`, `llevacontabilidad`, `documencargado`, `dniencargado`, `nomencargado`, `tlfencargado`, `descsucursal`, `codmoneda`, `codmoneda2`) VALUES
(4, '001', 18, 'BOACO', 'CLINICA INTEGRAL  AR-DENTAL', 16, 118, 'AV MODESTO DUARTE DE LA CRUZ ROJA 1C AL ESTE', 'A30ROCHA93@GMAIL.COM', '(864) 02863', '01', '01', '01', '01', '2022-10-18', 'SI', 18, '01', 'ALLAN ALBERTO ALVAREZ ROCHA', '(864) 02863', '0.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposcambio`
--

CREATE TABLE `tiposcambio` (
  `codcambio` int(11) NOT NULL,
  `descripcioncambio` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montocambio` decimal(12,3) NOT NULL,
  `codmoneda` int(11) NOT NULL,
  `fechacambio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiposcambio`
--

INSERT INTO `tiposcambio` (`codcambio`, `descripcioncambio`, `montocambio`, `codmoneda`, `fechacambio`) VALUES
(1, 'TIPO DE CAMBIO PAGINA', '35.500', 9, '2020-11-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposmoneda`
--

CREATE TABLE `tiposmoneda` (
  `codmoneda` int(11) NOT NULL,
  `moneda` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `siglas` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `simbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tiposmoneda`
--

INSERT INTO `tiposmoneda` (`codmoneda`, `moneda`, `siglas`, `simbolo`) VALUES
(1, 'US DOLLAR', 'USD', '$'),
(9, 'CORDOBA', 'C$', 'C$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traspasos`
--

CREATE TABLE `traspasos` (
  `idtraspaso` int(11) NOT NULL,
  `codtraspaso` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `recibe` int(11) NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `fechatraspaso` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamientos`
--

CREATE TABLE `tratamientos` (
  `codtratamiento` int(11) NOT NULL,
  `nomtratamiento` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tratamientos`
--

INSERT INTO `tratamientos` (`codtratamiento`, `nomtratamiento`) VALUES
(1, 'CIRUGIA ORAL'),
(2, 'ENDODONCIA'),
(3, 'ESTETICA'),
(4, 'MEDICINA ORAL'),
(5, 'ODONTOPEDIATRIA'),
(6, 'OPERATORIO'),
(7, 'ORTODONCIA'),
(8, 'PERIODONCIA'),
(9, 'PROTESIS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombres` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `sexo` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `password` longtext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nivel` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `codigo`, `dni`, `nombres`, `sexo`, `direccion`, `telefono`, `email`, `usuario`, `password`, `nivel`, `status`) VALUES
(1, 'U1', '18633175', 'RUBEN DARIO CHIRINOS PAREDES', 'MASCULINO', 'SANTA CRUZ DE MORA', '(414) 7225970', 'ELSAIYA2@GMAIL.COM', 'RUBENPAREDES', '$2y$10$ihFEmUJSqMA3Ey7SKVeiMeFJDUygKVzFSOki4FtXTVcZlBu6NpmPy', 'ADMINISTRADOR(A) GENERAL', 1),
(2, 'U2', '18633174', 'RUBEN DARIO CHIRINOS RODRIGUEZ', 'MASCULINO', 'SANTA CRUZ DE MORA', '(414) 7225970', 'ELSAIYA@GMAIL.COM', 'RUBENCHIRINOS', '$2y$10$iLUvgMMCKSJWS9pz6ZMgB.LuJTCLWqWYShQIyFE2dPjfZw4v1UAyG', 'ADMINISTRADOR(A) SUCURSAL', 1),
(3, 'U3', '16317737', 'MARBELLA PAREDES MARQUEZ', 'FEMENINO', 'SANTA CRUZ DE MORA', '(144) 7225970', 'PAREDESMARBE@GMAIL.COM', 'MARBELLAPEREDES', '$2y$10$Y1xu/N8MgDrGqXeJOSGUU.8m3XjftA4C21rpwUQxg7vsp0Pg05BiK', 'ASISTENTE', 1),
(4, 'U4', '81321310', 'MARIA NUBIA RODRIGUEZ', 'FEMENINO', 'MUCUJEPE CALLE PRINCIPAL', '(274) 9981185', 'MARIANUBIA@GMAIL.COM', 'MARIANUBIA', '$2y$10$Z5ZQMzlLWXqCe1wDP0vPIeAGjok0y9C9s/QoM.IiFJDSqRpmOJWPC', 'CAJERO(A)', 1),
(5, 'U5', '23458749', 'RICHARD JOSE CHIRINOS RODRIGUEZ', 'MASCULINO', 'CABIMAS ESTADO ZULIA', '(144) 8956658', 'RICHARDJ@GMAIL.COM', 'RICHARDCHIRINOS', '$2y$10$kizYB9ugU/gB0p1TIP/lMul2j.GDgvUKdrXfD5iNpRtZ8vHQ4sH4W', 'ADMINISTRADOR(A) SUCURSAL', 1),
(12, 'U6', '00102147', 'ALLAN ALBERTO ALVAREZ ROCHA', 'MASCULINO', 'BOACO , AV MODESTO DUARTE DE LA CRUZ ROJA 1C AL ESTE , FRENTE AL CAJERO BAC ,  CL&Iacute;NICA INTEGRAL  AR-DENTAL', '(864) 02863', 'A30ROCHA93@GMAIL.COM', 'DRALLAN', '$2y$10$jKIsae.MKvMfilLXPvXO/ehk45YRd.AUEZ4DQnIt.hSCaOvQAY446', 'ADMINISTRADOR(A) GENERAL', 1),
(13, 'U7', '15006580', 'ALLAN ALBERTO ALVAREZ ROCHA', 'MASCULINO', 'BOACO , AV MODESTO DUARTE DE LA CRUZ ROJA 1C AL ESTE , FRENTE AL CAJERO BAC ,  CL&Iacute;NICA INTEGRAL  AR-DENTAL', '(864) 02863', 'A30ROCHA9300@GMAIL.COM', 'ARDENTAL', '$2y$10$MhYJ971fX5cU4x5Prrji8eLv7nYz0CZHEiveQQPuvUI0S4OVxqCLa', 'ADMINISTRADOR(A) SUCURSAL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL,
  `tipodocumento` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codcaja` int(11) NOT NULL,
  `codventa` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codfactura` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codserie` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codautorizacion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codpaciente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codespecialista` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `subtotalivasi` decimal(12,2) NOT NULL,
  `subtotalivano` decimal(12,2) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  `totaliva` decimal(12,2) NOT NULL,
  `descontado` decimal(12,2) NOT NULL,
  `descuento` decimal(12,2) NOT NULL,
  `totaldescuento` decimal(12,2) NOT NULL,
  `totalpago` decimal(12,2) NOT NULL,
  `totalpago2` decimal(12,2) NOT NULL,
  `tipopago` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `formapago` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `montopagado` decimal(12,2) NOT NULL,
  `montodevuelto` decimal(12,2) NOT NULL,
  `creditopagado` decimal(12,2) NOT NULL,
  `fechavencecredito` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechapagado` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `statusventa` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fechaventa` datetime NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `codsucursal` int(11) NOT NULL,
  `bandera` int(2) NOT NULL,
  `docelectronico` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idventa`, `tipodocumento`, `codcaja`, `codventa`, `codfactura`, `codserie`, `codautorizacion`, `codpaciente`, `codespecialista`, `subtotalivasi`, `subtotalivano`, `iva`, `totaliva`, `descontado`, `descuento`, `totaldescuento`, `totalpago`, `totalpago2`, `tipopago`, `formapago`, `montopagado`, `montodevuelto`, `creditopagado`, `fechavencecredito`, `fechapagado`, `statusventa`, `fechaventa`, `observaciones`, `codigo`, `codsucursal`, `bandera`, `docelectronico`) VALUES
(1, 'TICKET', 1, '1', '001-1', '001', '8278212221118526056282178688786789369253985596230', 'P203', 'E13', '44.00', '0.00', '12.00', '5.28', '0.00', '0.00', '0.00', '49.28', '34.00', 'CONTADO', 'EFECTIVO', '0.00', '0.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', '2021-11-19 18:03:50', 'SDFDSFDSF', 'U2', 1, 0, 0),
(3, 'TICKET', 3, '1', '01-01', '01', '0101989948748165051721464202245370393782692589959', 'P4', 'E2', '0.00', '7160.00', '15.00', '0.00', '0.00', '0.00', '0.00', '7160.00', '0.00', 'CREDITO', 'CREDITO', '0.00', '0.00', '3580.00', '2021-12-31', '0000-00-00', 'PENDIENTE', '2021-12-10 11:23:57', 'MOLAR 2.7', 'U4', 3, 0, 0),
(4, 'NOTAVENTA', 3, '2', '01-02', '01', '2693389481875231501140839512632964237976819578839', 'P1', 'E2', '0.00', '400.00', '15.00', '0.00', '0.00', '0.00', '0.00', '400.00', '0.00', 'CREDITO', 'CREDITO', '0.00', '0.00', '100.00', '2022-09-24', '0000-00-00', 'PENDIENTE', '2022-01-24 23:46:27', 'SDASDSADASD', 'U4', 3, 0, 0),
(5, 'TICKET', 4, '1', '01-01', '01', '9294614651807270717380010274108152029989968868136', 'P1', 'E2', '0.00', '300.00', '15.00', '0.00', '0.00', '0.00', '0.00', '300.00', '300.00', 'CONTADO', 'EFECTIVO', '150.00', '-150.00', '0.00', '0000-00-00', '0000-00-00', 'PAGADA', '2022-10-18 13:05:38', '', 'U7', 4, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonoscreditoscompras`
--
ALTER TABLE `abonoscreditoscompras`
  ADD PRIMARY KEY (`codabono`);

--
-- Indices de la tabla `abonoscreditosventas`
--
ALTER TABLE `abonoscreditosventas`
  ADD PRIMARY KEY (`codabono`);

--
-- Indices de la tabla `accesosxsucursales`
--
ALTER TABLE `accesosxsucursales`
  ADD PRIMARY KEY (`codaccesoxsuc`);

--
-- Indices de la tabla `arqueocaja`
--
ALTER TABLE `arqueocaja`
  ADD PRIMARY KEY (`codarqueo`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`codcaja`);

--
-- Indices de la tabla `cie10`
--
ALTER TABLE `cie10`
  ADD PRIMARY KEY (`idcie`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idcita`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idcompra`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `consentimientoinformado`
--
ALTER TABLE `consentimientoinformado`
  ADD PRIMARY KEY (`idconsentimiento`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`idcotizacion`);

--
-- Indices de la tabla `creditosxpacientes`
--
ALTER TABLE `creditosxpacientes`
  ADD PRIMARY KEY (`codcredito`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`coddetallecompra`);

--
-- Indices de la tabla `detalle_cotizaciones`
--
ALTER TABLE `detalle_cotizaciones`
  ADD PRIMARY KEY (`coddetallecotizacion`);

--
-- Indices de la tabla `detalle_traspasos`
--
ALTER TABLE `detalle_traspasos`
  ADD PRIMARY KEY (`coddetalletraspaso`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`coddetalleventa`);

--
-- Indices de la tabla `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`coddocumento`);

--
-- Indices de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  ADD PRIMARY KEY (`idespecialista`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`codhorario`);

--
-- Indices de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  ADD PRIMARY KEY (`codimpuesto`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`codkardex`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`codmarca`);

--
-- Indices de la tabla `medidas`
--
ALTER TABLE `medidas`
  ADD PRIMARY KEY (`codmedida`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`codmensaje`);

--
-- Indices de la tabla `movimientoscajas`
--
ALTER TABLE `movimientoscajas`
  ADD PRIMARY KEY (`codmovimiento`);

--
-- Indices de la tabla `odontologia`
--
ALTER TABLE `odontologia`
  ADD PRIMARY KEY (`idodontologia`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`idpaciente`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`codpresentacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indices de la tabla `referenciasodontograma`
--
ALTER TABLE `referenciasodontograma`
  ADD PRIMARY KEY (`codreferencia`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idservicio`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`codsucursal`);

--
-- Indices de la tabla `tiposcambio`
--
ALTER TABLE `tiposcambio`
  ADD PRIMARY KEY (`codcambio`);

--
-- Indices de la tabla `tiposmoneda`
--
ALTER TABLE `tiposmoneda`
  ADD PRIMARY KEY (`codmoneda`);

--
-- Indices de la tabla `traspasos`
--
ALTER TABLE `traspasos`
  ADD PRIMARY KEY (`idtraspaso`);

--
-- Indices de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  ADD PRIMARY KEY (`codtratamiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonoscreditoscompras`
--
ALTER TABLE `abonoscreditoscompras`
  MODIFY `codabono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `abonoscreditosventas`
--
ALTER TABLE `abonoscreditosventas`
  MODIFY `codabono` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `accesosxsucursales`
--
ALTER TABLE `accesosxsucursales`
  MODIFY `codaccesoxsuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `arqueocaja`
--
ALTER TABLE `arqueocaja`
  MODIFY `codarqueo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `codcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cie10`
--
ALTER TABLE `cie10`
  MODIFY `idcie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idcita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `consentimientoinformado`
--
ALTER TABLE `consentimientoinformado`
  MODIFY `idconsentimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `idcotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `creditosxpacientes`
--
ALTER TABLE `creditosxpacientes`
  MODIFY `codcredito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `coddetallecompra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_cotizaciones`
--
ALTER TABLE `detalle_cotizaciones`
  MODIFY `coddetallecotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_traspasos`
--
ALTER TABLE `detalle_traspasos`
  MODIFY `coddetalletraspaso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `coddetalleventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `documentos`
--
ALTER TABLE `documentos`
  MODIFY `coddocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `especialistas`
--
ALTER TABLE `especialistas`
  MODIFY `idespecialista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `codhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `impuestos`
--
ALTER TABLE `impuestos`
  MODIFY `codimpuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `codkardex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `codmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=486;

--
-- AUTO_INCREMENT de la tabla `medidas`
--
ALTER TABLE `medidas`
  MODIFY `codmedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `codmensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientoscajas`
--
ALTER TABLE `movimientoscajas`
  MODIFY `codmovimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `odontologia`
--
ALTER TABLE `odontologia`
  MODIFY `idodontologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `idpaciente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `codpresentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id_provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `referenciasodontograma`
--
ALTER TABLE `referenciasodontograma`
  MODIFY `codreferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idservicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `codsucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tiposcambio`
--
ALTER TABLE `tiposcambio`
  MODIFY `codcambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiposmoneda`
--
ALTER TABLE `tiposmoneda`
  MODIFY `codmoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `traspasos`
--
ALTER TABLE `traspasos`
  MODIFY `idtraspaso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tratamientos`
--
ALTER TABLE `tratamientos`
  MODIFY `codtratamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
