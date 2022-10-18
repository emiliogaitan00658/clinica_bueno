<?php
include_once('fpdf/pdf.php');
require_once("class/class.php");
//ob_end_clean();
ob_start();

$casos = array (

                  'USUARIOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarUsuarios',

                                    'output' => array('Listado General de Usuarios.pdf', 'I')

                                  ),

                  'HORARIOSUSUARIOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarHorariosUsuarios',

                                    'output' => array('Listado General de Horarios de Usuarios.pdf', 'I')

                                  ),

                  'HORARIOSESPECIALISTAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarHorariosEspecialistas',

                                    'output' => array('Listado General de Horarios de Especialistas.pdf', 'I')

                                  ),

                  'LOGS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarLogs',

                                    'output' => array('Listado General Logs de Acceso.pdf', 'I')

                                  ),

                  'DEPARTAMENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarDepartamentos',

                                    'output' => array('Listado General de Departamentos.pdf', 'I')

                                  ),

                  'PROVINCIAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarProvincias',

                                    'output' => array('Listado General de Provincias.pdf', 'I')

                                  ),

                  'DOCUMENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarDocumentos',

                                    'output' => array('Listado General de Tipos de Documentos.pdf', 'I')

                                  ),

                  'TIPOMONEDA' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTiposMonedas',

                                    'output' => array('Listado General de Tipos de Moneda.pdf', 'I')

                                  ),

                'TIPOCAMBIO' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTiposCambio',

                                    'output' => array('Listado General de Tipos de Cambio.pdf', 'I')

                                  ),
                  
                  'IMPUESTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarImpuestos',

                                    'output' => array('Listado General de Impuestos.pdf', 'I')

                                  ),

                  'MENSAJES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarMensajes',

                                    'output' => array('Listado General de Mensajes de Contacto.pdf', 'I')

                                  ),

                  'SUCURSALES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarSucursales',

                                    'output' => array('Listado General de Sucursales.pdf', 'I')

                                  ),

                  'TRATAMIENTOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarTratamientos',

                                    'output' => array('Listado General de Tratamientos.pdf', 'I')

                                  ),

                  'MARCAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMarcas',

                                    'output' => array('Listado General de Marcas.pdf', 'I')

                                  ),

                  'PRESENTACIONES' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarPresentaciones',

                                    'output' => array('Listado General de Presentaciones.pdf', 'I')

                                  ),

                  'MEDIDAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMedidas',

                                    'output' => array('Listado General de Medidas.pdf', 'I')

                                  ),

                  'ESPECIALISTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarEspecialistas',

                                    'output' => array('Listado General de Especialistas.pdf', 'I')

                                  ),

                  'PACIENTES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarPacientes',

                                    'output' => array('Listado General de Pacientes.pdf', 'I')

                                  ),
                  
                  'PROVEDORES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProveedores',

                                    'output' => array('Listado General de Proveedores.pdf', 'I')

                                  ),

                  'SERVICIOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarServicios',

                                    'output' => array('Listado General de Servicios.pdf', 'I')

                                  ),

                  'SERVICIOSVENDIDOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarServiciosVendidos',

                                    'output' => array('Listado de Servicios Vendidos.pdf', 'I')

                                  ),

                  'SERVICIOSXVENDEDOR' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarServiciosVendidosxVendedor',

                                    'output' => array('Listado de Servicios Vendidos por Vendedor.pdf', 'I')

                                  ),

                  'SERVICIOSXMONEDA' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarServiciosxMoneda',

                                    'output' => array('Listado de Servicios por Moneda.pdf', 'I')

                                  ),

                 'KARDEXSERVICIOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexServicios',

                                    'output' => array('Listado de Kardex por Servicio.pdf', 'I')

                                  ),

                  'KARDEXSERVICIOSVALORIZADOXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexServiciosValorizadoxFechas',

                                    'output' => array('Listado de Kardex Servicios Valorizado por Fechas.pdf', 'I')

                                  ),

                 'PRODUCTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductos',

                                    'output' => array('Listado General de Productos.pdf', 'I')

                                  ),

                 'PRODUCTOSMINIMO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosMinimo',

                                    'output' => array('Listado de Productos en Stock Minimo.pdf', 'I')

                                  ),

                 'PRODUCTOSMAXIMO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosMaximo',

                                    'output' => array('Listado de Productos en Stock Maximo.pdf', 'I')

                                  ),

                  'PRODUCTOSVENDIDOS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarProductosVendidos',

                                    'output' => array('Listado de Servicios Vendidos.pdf', 'I')

                                  ),

                  'PRODUCTOSXVENDEDOR' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarProductosVendidosxVendedor',

                                    'output' => array('Listado de Productos Vendidos por Vendedor.pdf', 'I')

                                  ),

                 'PRODUCTOSXMONEDA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosxMoneda',

                                    'output' => array('Listado de Productos en Stock Maximo.pdf', 'I')

                                  ),

                 'KARDEXPRODUCTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexProductos',

                                    'output' => array('Listado de Kardex por Producto.pdf', 'I')

                                  ),

                  'KARDEXPRODUCTOSVALORIZADO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexProductosValorizado',

                                    'output' => array('Listado de Kardex Productos Valorizado.pdf', 'I')

                                  ),

                  'KARDEXPRODUCTOSVALORIZADOXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarKardexProductosValorizadoxFechas',

                                    'output' => array('Listado de Kardex Productos Valorizado por Fechas.pdf', 'I')

                                  ),

                 'FACTURATRASPASO' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'FacturaTraspaso',

                                    'output' => array('Factura de Traspasos.pdf', 'I')

                                  ),

                  'TRASPASOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasos',

                                    'output' => array('Listado de Traspasos.pdf', 'I')

                                  ),

                  'TRASPASOSXSUCURSAL' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasosxSucursal',

                                    'output' => array('Listado de Traspasos por Sucursal.pdf', 'I')

                                  ),

                  'TRASPASOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarTraspasosxFechas',

                                    'output' => array('Listado de Traspasos por Fechas.pdf', 'I')

                                  ),

                  'PRODUCTOSTRASPASOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosTraspasos',

                                    'output' => array('Listado de Productos Traspasados.pdf', 'I')

                                  ),

                 'FACTURACOMPRA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'FacturaCompra',

                                    'output' => array('Factura de Compra.pdf', 'I')

                                  ),

                 'COMPRAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCompras',

                                    'output' => array('Listado General de Compras.pdf', 'I')

                                  ),

                 'CUENTASXPAGAR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCuentasxPagar',

                                    'output' => array('Listado General de Cuentas por Pagar.pdf', 'I')

                                  ),

              'COMPRASXPROVEEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarComprasxProveedor',

                                    'output' => array('Listado de Compras por Proveedor.pdf', 'I')

                                  ),

              'COMPRASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarComprasxFechas',

                                    'output' => array('Listado de Compras por Fechas.pdf', 'I')

                                  ),

        
                  'TICKETCOMPRA' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TicketCreditoCompra',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Abonos.pdf', 'I')

                                  ),

                  'CREDITOSCOMPRASXPROVEEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxProveedor',

                                    'output' => array('Listado de Creditos por Proveedor.pdf', 'I')

                                  ),

                  'CREDITOSCOMPRASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosComprasxFechas',

                                    'output' => array('Listado de Creditos de Compras por Fechas.pdf', 'I')

                                  ),
        
                  'FACTURACOTIZACION' => array(

                                    'medidas' => array('P', 'mm', 'A4'),
                                    //'medidas' => array('L', 'mm', 'A5'),

                                    'func' => 'FacturaCotizacion',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Factura de Cotización.pdf', 'I')

                                  ),

                  'COTIZACIONES' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizaciones',

                                    'output' => array('Listado General de Cotizaciones.pdf', 'I')

                                  ),

                  'COTIZACIONESXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizacionesxFechas',

                                    'output' => array('Listado de Cotizaciones por Fechas.pdf', 'I')

                                  ),

                  'COTIZACIONESXESPECIALISTA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizacionesxEspecialista',

                                    'output' => array('Listado de Cotizaciones por Especialista.pdf', 'I')

                                  ),

                  'COTIZACIONESXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizacionesxPaciente',

                                    'output' => array('Listado de Cotizaciones por Paciente.pdf', 'I')

                                  ),

                  'PRODUCTOSCOTIZADOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarProductosCotizados',

                                    'output' => array('Listado de Productos Cotizados.pdf', 'I')

                                  ),

                  'COTIZADOSXVENDEDOR' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCotizadosxVendedor',

                                    'output' => array('Listado de Productos Cotizados por Vendedor.pdf', 'I')

                                  ),

                  'CITAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCitas',

                                    'output' => array('Listado General de Citas Odontologicas.pdf', 'I')

                                  ),

                  'CITASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCitasxFechas',

                                    'output' => array('Listado de Citas por Fechas.pdf', 'I')

                                  ),

                  'CITASXESPECIALISTA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCitasxEspecialista',

                                    'output' => array('Listado de Citas por Especialista.pdf', 'I')

                                  ),

                  'CITASXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCitasxPaciente',

                                    'output' => array('Listado de Citas por Paciente.pdf', 'I')

                                  ),

                  'CAJAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarCajas',

                                    'output' => array('Listado General de Cajas.pdf', 'I')

                                  ),
        
                  'TICKETCIERRE' => array(

                                    'medidas' => array('P','mm','cierre'),
                                    //'medidas' => array('L', 'mm', 'A5'),
                                    //'medidas' => array('P','mm','mitad'),

                                    'func' => 'TicketCierre',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Cierre.pdf', 'I')

                                  ),

                  'ARQUEOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarArqueos',

                                    'output' => array('Listado General de Arqueos de Cajas.pdf', 'I')

                                  ),

                  'ARQUEOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarArqueosxFechas',

                                    'output' => array('Listado de Arqueos por Fechas.pdf', 'I')

                                  ),

                  'MOVIMIENTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarMovimientos',

                                    'output' => array('Listado General de Movimientos en Caja.pdf', 'I')

                                  ),

                  'MOVIMIENTOSXFECHAS' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaListarMovimientosxFechas',

                                    'output' => array('Listado de Movimientos por Fechas.pdf', 'I')

                                  ),

                  'FICHAODONTOLOGICA' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'FichaOdontologica',

                                    'output' => array('Ficha Odontológica.pdf', 'I')

                                  ),

                 'ODONTOLOGIA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarOdontologia',

                                    'output' => array('Listado General de Consultas Odontológicas.pdf', 'I')

                                  ),

              'ODONTOLOGIAXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarOdontologiaxFechas',

                                    'output' => array('Listado de Consultas Odontológicas por Fechas.pdf', 'I')

                                  ),

              'ODONTOLOGIAXESPECIALISTA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarOdontologiaxEspecialista',

                                    'output' => array('Listado de Consultas Odontológicas por Especialista.pdf', 'I')

                                  ),

              'ODONTOLOGIAXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarOdontologiaxPaciente',

                                    'output' => array('Listado de Consultas Odontológicas por Paciente.pdf', 'I')

                                  ),

                 'FICHACONSENTIMIENTO' => array(

                                    'medidas' => array('P', 'mm', 'A4'),

                                    'func' => 'TablaConsentimientoInformado',

                                    'output' => array('Consentimientos Informado.pdf', 'I')

                                  ),

                 'CONSENTIMIENTOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarConsentimientos',

                                    'output' => array('Listado General de Consentimientos Informado.pdf', 'I')

                                  ),
        
                  'TICKET' => array(

                                    'medidas' => array('P','mm','ticket2'),

                                    'func' => 'TicketVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Venta.pdf', 'I')

                                  ),

                  'FACTURA' => array(

                                    //'medidas' => array('P', 'mm', 'A4'), //FACTURA #1
                                    'medidas' => array('P','mm','mitad'), //FACTURA #2
                                    //'medidas' => array('P','mm','ticket2'), //FACTURA #3

                                    'func' => 'FacturaVenta2',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Factura de Ventas.pdf', 'I')

                                  ),
        
                  'NOTAVENTA' => array(

                                    'medidas' => array('P', 'mm', 'A4'),
                                    //'medidas' => array('L', 'mm', 'A5'),

                                    'func' => 'NotaVenta',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Nota de Venta.pdf', 'I')

                                  ),

                  'VENTAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentas',

                                    'output' => array('Listado General de Facturas.pdf', 'I')

                                  ),

                  'VENTASXCAJAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxCajas',

                                    'output' => array('Listado de Factura por Cajas.pdf', 'I')

                                  ),

                  'VENTASXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxFechas',

                                    'output' => array('Listado de Factura por Fechas.pdf', 'I')

                                  ),

                  'VENTASXESPECIALISTA' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxEspecialista',

                                    'output' => array('Listado de Factura por Especialista.pdf', 'I')

                                  ),

                  'VENTASXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarVentasxPaciente',

                                    'output' => array('Listado de Factura por Paciente.pdf', 'I')

                                  ),
        
                  'TICKETCREDITO' => array(

                                    'medidas' => array('P','mm','ticket'),

                                    'func' => 'TicketCredito',

                                    'setPrintFooter' => 'true',

                                    'output' => array('Ticket de Credito.pdf', 'I')

                                  ),

                  'CREDITOS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditos',

                                    'output' => array('Listado General de Creditos.pdf', 'I')

                                  ),

                  'CREDITOSXFECHAS' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxFechas',

                                    'output' => array('Listado de Creditos por Fechas.pdf', 'I')

                                  ),

                  'CREDITOSXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarCreditosxPaciente',

                                    'output' => array('Listado de Creditos por Paciente.pdf', 'I')

                                  ),

                  'DETALLESCREDITOSXPACIENTE' => array(

                                    'medidas' => array('L', 'mm', 'LEGAL'),

                                    'func' => 'TablaListarDetallesCreditosxPaciente',

                                    'output' => array('Listado de Detalles Creditos por Paciente.pdf', 'I')

                                  ),
                    );

 
$tipo = decrypt($_GET['tipo']);

if ($tipo == 'TICKET') {

  $caso_data = $casos[$tipo];
  $pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
  $pdf->AddPage();
  $pdf->SetAuthor("Ing. Emilio Gaitan");
  $pdf->SetCreator("FPDF Y PHP");
  $pdf->{$caso_data['func']}();
  //$pdf->AutoPrint(false);
  $pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
  ob_end_flush();

} else {

  $caso_data = $casos[$tipo];
  $pdf = new PDF($caso_data['medidas'][0], $caso_data['medidas'][1], $caso_data['medidas'][2]);
  $pdf->AddPage();
  $pdf->SetAuthor("Ing. Emilio Gaitan");
  $pdf->SetCreator("FPDF Y PHP");
  $pdf->{$caso_data['func']}();
  $pdf->Output($caso_data['output'][0], $caso_data['output'][1]);
  ob_end_flush();
}
?>