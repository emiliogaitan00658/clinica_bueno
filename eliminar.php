<?php
require_once("class/class.php");
$tra = new Login();
$tipo = decrypt($_GET['tipo']);
switch($tipo)
	{
case 'USUARIOS':
$tra->EliminarUsuarios();
exit;
break;

case 'HORARIOSUSUARIOS':
$tra->EliminarHorariosUsuarios();
exit;
break;

case 'HORARIOSESPECIALISTAS':
$tra->EliminarHorariosEspecialistas();
exit;
break;

case 'DEPARTAMENTOS':
$tra->EliminarDepartamentos();
exit;
break;

case 'PROVINCIAS':
$tra->EliminarProvincias();
exit;
break;

case 'DOCUMENTOS':
$tra->EliminarDocumentos();
exit;
break;

case 'TIPOMONEDA':
$tra->EliminarTipoMoneda();
exit;
break;

case 'TIPOCAMBIO':
$tra->EliminarTipoCambio();
exit;
break;

case 'MEDIOSPAGOS':
$tra->EliminarMediosPagos();
exit;
break;

case 'IMPUESTOS':
$tra->EliminarImpuestos();
exit;
break;

case 'SUCURSALES':
$tra->EliminarSucursales();
exit;
break;

case 'TRATAMIENTOS':
$tra->EliminarTratamientos();
exit;
break;

case 'MENSAJES':
$tra->EliminarMensajes();
exit;
break;

case 'MARCAS':
$tra->EliminarMarcas();
exit;
break;

case 'PRESENTACIONES':
$tra->EliminarPresentaciones();
exit;
break;

case 'MEDIDAS':
$tra->EliminarMedidas();
exit;
break;

case 'ESPECIALISTAS':
$tra->EliminarEspecialistas();
exit;
break;

case 'REINICIARESPECIALISTA':
$tra->ReiniciarClaveEspecialistas();
exit;
break;

case 'PACIENTES':
$tra->EliminarPacientes();
exit;
break;

case 'PROVEEDORES':
$tra->EliminarProveedores();
exit;
break;

case 'SERVICIOS':
$tra->EliminarServicios();
exit;
break;

case 'PRODUCTOS':
$tra->EliminarProductos();
exit;
break;

case 'TRASPASOS':
$tra->EliminarTraspasos();
exit;
break;

case 'DETALLESTRASPASOS':
$tra->EliminarDetallesTraspasos();
exit;
break;

case 'COMPRAS':
$tra->EliminarCompras();
exit;
break;

case 'PAGARFACTURA':
$tra->PagarCompras();
exit;
break;

case 'DETALLESCOMPRAS':
$tra->EliminarDetalleCompras();
exit;
break;

case 'COTIZACIONES':
$tra->EliminarCotizaciones();
exit;
break;

case 'DETALLESCOTIZACIONES':
$tra->EliminarDetalleCotizaciones();
exit;
break;

case 'CANCELARCITA':
$tra->CancelarCitas();
exit;
break;

case 'CITAS':
$tra->EliminarCitas();
exit;
break;

case 'CAJAS':
$tra->EliminarCajas();
exit;
break;

case 'MOVIMIENTOS':
$tra->EliminarMovimientos();
exit;
break;

case 'REFERENCIAS':
$tra->EliminarReferenciaTratamiento();
exit;
break;

case 'ODONTOLOGIA':
$tra->EliminarOdontologia();
exit;
break;

case 'CONSENTIMIENTO':
$tra->EliminarConsentimiento();
exit;
break;

case 'VENTAS':
$tra->EliminarVentas();
exit;
break;

case 'DETALLESVENTAS':
$tra->EliminarDetalleVentas();
exit;
break;

}
?>