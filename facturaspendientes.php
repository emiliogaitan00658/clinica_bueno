<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="cierreventa")
{
$reg = $tra->CobrarVenta();
exit;
}       
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj()" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 


<!--############################## MODAL PARA VER DETALLE DE FACTURA ######################################-->
    <!-- sample modal content -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="myLargeModalLabel"><font color="white"><i class="fa fa-tasks"></i> Detalle de Factura</font></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">
                    <p><div id="muestraventamodal"></div></p>
                </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<!--############################## MODAL PARA VER DETALLE DE FACTURA ######################################-->   

 <!--############################## MODAL PARA CIERRE DE VENTA ######################################-->
<!-- sample modal content -->
<div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Cierre de Venta</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
    <form class="form form-material" name="cobrarventa" id="cobrarventa" action="#">

    <div class="modal-body">

        <div id="datos_cajero_cobro"></div>

        <div class="row">
            <div class="col-md-4">
                <h4 class="mb-0 font-light">Total a Pagar</h4>
                <h4 class="mb-0 font-medium"><label id="txtTotal" name="txtTotal"></label></h4>
            </div>

            <div class="col-md-4">
                <h4 class="mb-0 font-light">Total Recibido</h4>
                <h4 class="mb-0 font-medium"><label id="txtpagado" name="txtpagado">0.00</label></h4>
            </div>

            <div class="col-md-4">
                <h4 class="mb-0 font-light">Total Cambio</h4>
                <h4 class="mb-0 font-medium"><label id="textcambio" name="textcambio">0.00</label></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <h4 class="mb-0 font-light">N° Documento</h4>
                <h4 class="mb-0 font-medium"> <label id="txtdocumento" name="txtdocumento"></label></h4>
            </div>

            <div class="col-md-8">
                <h4 class="mb-0 font-light">Nombre del Paciente</h4>
                <h4 class="mb-0 font-medium"> <label id="txtpaciente" name="txtpaciente"></label></h4>
            </div>
        </div>
        
        <hr>
        <input type="hidden" name="proceso" id="proceso" value="cierreventa"/>
        <input type="hidden" name="idventa" id="idventa">
        <input type="hidden" name="codventa" id="codventa">
        <input type="hidden" name="codsucursal" id="codsucursal">
        <input type="hidden" name="codpaciente" id="codpaciente">
        <input type="hidden" name="txtTotal" id="txtTotal">

        <h3 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cash-multiple"></i> Métodos de Pago</h3><hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tipodocumento" id="ticket" value="TICKET" checked="" class="custom-control-input">
                    <label class="custom-control-label" for="ticket">TICKET </label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tipodocumento" id="factura" value="FACTURA" class="custom-control-input">
                    <label class="custom-control-label" for="factura">FACTURA </label>
                    </div>
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tipodocumento" id="notaventa" value="NOTAVENTA" class="custom-control-input">
                    <label class="custom-control-label" for="notaventa">NOTA DE VENTA </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="tipopago" id="contado" value="CONTADO" checked="" onclick="CargaCondicionesPagos();" class="custom-control-input">
                        <label class="custom-control-label" for="contado">CONTADO</label>
                    </div><br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" name="tipopago" id="credito" value="CREDITO" onclick="CargaCondicionesPagos();" class="custom-control-input">
                        <label class="custom-control-label" for="credito">CRÉDITO</label>
                    </div>
                </div>
            </div>
        </div>

        <div id="muestra_metodo"><!-- metodo de pago -->

        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Método de Pago: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select name="formapago" id="formapago" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="EFECTIVO">EFECTIVO</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="TARJETA DE CREDITO">TARJETA DE CRÉDITO</option>
                    <option value="TARJETA DE DEBITO">TARJETA DE DÉBITO</option>
                    <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="DINERO ELECTRONICO">DINERO ELECTRÓNICO</option>
                    <option value="CUPON">CUPÓN</option>
                    <option value="OTROS">OTROS</option>
                    </select>
                </div> 
            </div>

            <div class="col-md-6"> 
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                    <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00">
                    <input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucion();" value="0" required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        </div><!-- end metodo de pago -->

        <div class="row"> 
            <div class="col-md-12"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Observaciones: </label>
                    <input class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" required="" aria-required="true">
                    <i class="fa fa-comments form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="modal-footer">
            <div id="submit_cierre"><button type="submit" name="btn-cerrar" id="btn-cerrar" class="btn btn-danger"><span class="fa fa-print"></span> Facturar e Imprimir</button></div>
            <button type="button" class="btn btn-info" onclick="CerrarCobro();" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
        </div>
    
    </div>

    </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA CIERRE DE VENTA ######################################-->            
                    
    
        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->
   

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Facturación</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Facturación</li>
                                <li class="breadcrumb-item active" aria-current="page">Pendientes</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

        <div id="save">
        <!-- error will be shown here ! -->
        </div>      
               
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturas Pendientes</h4>
            </div>

            <div class="form-body">

                <div class="card-body">

                <div id="ventas_pendientes"></div>

            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/script/jquery.min.js"></script> 
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jsventas.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/jscript">
    $('#ventas_pendientes').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#ventas_pendientes').load("consultas?CargaVentasPendientes=si");
     }, 200);
    </script>
    <!-- jQuery -->
    

</body>
</html>

<?php } else { ?>   
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
        document.location.href='panel'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>