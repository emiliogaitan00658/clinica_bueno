<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION["acceso"]=="administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarArqueos();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->CerrarArqueos();
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

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
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


<!--############################## MODAL PARA VER DETALLE DE ARQUEO ######################################-->
<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Arqueo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            <div class="modal-body">

                <div id="muestraarqueomodal"></div> 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA VER DETALLE DE ARQUEO ######################################-->


<!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->
<!-- sample modal content -->
<div id="myModalArqueo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Arqueos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="savearqueo" id="savearqueo">
                
            <div class="modal-body">

        <?php if ($_SESSION["acceso"]=="administradorG") { ?>

            <div class="row">
                <div class="col-md-6"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="codsucursal" id="codsucursal" class="form-control" onChange="CargaCajas(this.form.codsucursal.value);" required="" aria-required="true">
                            <option value="">-- SELECCIONE --</option>
                            <?php
                            $sucursal = new Login();
                            $sucursal = $sucursal->ListarSucursales();
                            if($sucursal==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($sucursal);$i++){
                            ?>
                            <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].":".$sucursal[$i]['nomsucursal']; ?></option>       
                            <?php } } ?>
                        </select>
                    </div> 
                </div>

                <div class="col-md-6"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Seleccione Caja: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="codcaja" id="codcaja" class="form-control" required="" aria-required="true">
                            <option value=""> -- SIN RESULTADOS -- </option>
                        </select>
                    </div> 
                </div>
            </div> 


        <?php } else { ?> 

            <input type="hidden" name="codsucursal" id="codsucursal"> 

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Caja: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="codcaja" id="codcaja" class='form-control' required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $caja = new Login();
                            $caja = $caja->ListarCajas();
                            if($caja==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($caja);$i++){
                            ?>
                        <option value="<?php echo encrypt($caja[$i]['codcaja']); ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>         
                        <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

          <?php } ?>

          <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Hora de Apertura: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="save"/>
                    <input type="hidden" name="codarqueo" id="codarqueo">
                    <input type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Hora de Apertura" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Inicial: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="montoinicial" id="montoinicial" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto Inicial" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>
        </div>
    </div>

            <div class="modal-footer">
                <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-info" type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codsucursal').value = '',
                document.getElementById('codcaja').value = '',
                document.getElementById('codarqueo').value = '',
                document.getElementById('fecharegistro').value = '',
                document.getElementById('montoinicial').value = ''
                " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->

<!--############################## MODAL PARA CERRAR DE ARQUEO ######################################-->
<!-- sample modal content -->
<div id="myModalCierre" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
            <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Cerrar Caja <label id="nrocaja"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="cerrararqueo" id="cerrararqueo" action="#">
                
        <div class="modal-body">

        <h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-account-outline"></i> Cajero</h4><hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Caja: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="update"/>
                    <input type="hidden" name="codarqueo" id="codarqueo"/>
                    <br /><abbr title="Nº de Caja"><label id="txtcaja"></label></abbr>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Cajero: <span class="symbol required"></span></label>
                    <br /><abbr title="Nombre de Cajero"><label id="txtnombre"></label></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Apertura: <span class="symbol required"></span></label>
                    <br /><abbr title="Monto Apertura"><label id="txtmonto"></label></abbr>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha Apertura: <span class="symbol required"></span></label>
                    <br /><abbr title="Fecha Apertura"><label id="txtapertura"></label></abbr>
                </div>
            </div>
        </div>

        <h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Ventas a Contado</h4><hr>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Efectivo: <span class="symbol required"></span></label>
                    <br /><abbr title="Efectivo"><label id="efectivo"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Cheque: <span class="symbol required"></span></label>
                    <br /><abbr title="Cheque"><label id="cheque"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tarjeta Débito: <span class="symbol required"></span></label>
                    <br /><abbr title="Tarjeta Débito"><label id="tdebito"></label></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tarjeta Crédito: <span class="symbol required"></span></label>
                    <br /><abbr title="Tarjeta Crédito"><label id="tcredito"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tarjeta Prepago: <span class="symbol required"></span></label>
                    <br /><abbr title="Tarjeta Prepago"><label id="tprepago"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Transferencia: <span class="symbol required"></span></label>
                    <br /><abbr title="Transferencia"><label id="transferencia"></label></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Dinero Electrónico: <span class="symbol required"></span></label>
                    <br /><abbr title="Dinero Electrónico"><label id="electronico"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Cupón: <span class="symbol required"></span></label>
                    <br /><abbr title="Cupón"><label id="cupon"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Otros: <span class="symbol required"></span></label>
                    <br /><abbr title="Otros"><label id="otros"></label></abbr>
                </div>
            </div>
        </div>

        <h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Ventas a Crédito</h4><hr>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Créditos: <span class="symbol required"></span></label>
                    <br /><abbr title="Créditos"><label id="creditos"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Abono Efectivo: <span class="symbol required"></span></label>
                    <br /><abbr title="Abono Efectivo"><label id="abonosefectivo"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Abono Otros: <span class="symbol required"></span></label>
                    <br /><abbr title="Abono Otros"><label id="abonosotros"></label></abbr>
                </div>
            </div>
        </div>

        <h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cash-usd"></i> Movimientos</h4><hr>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Ingresos Efectivo: <span class="symbol required"></span></label>
                    <br /><abbr title="Ingresos Efectivo"><label id="ingresosefectivo"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Ingresos Otros: <span class="symbol required"></span></label>
                    <br /><abbr title="Ingresos Otros"><label id="ingresosotros"></label></abbr>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Egresos: <span class="symbol required"></span></label>
                    <br /><abbr title="Egresos"><label id="egresos"></label></abbr>
                </div>
            </div>
        </div>

        <h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-scale-balance"></i> Balance en Caja</h4><hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Hora de Cierre: <span class="symbol required"></span></label>
                    <input type="hidden" name="fecharegistro2" id="fecharegistro2"/>
                    <br /><abbr title="Hora de Cierre"><label id="fechacierre"></label></abbr>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Estimado en Caja: <span class="symbol required"></span></label>
                    <input type="hidden" name="estimado" id="estimado"/>
                    <br /><abbr title="Estimado en Caja"><label id="estimado"></label></abbr>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Efectivo Disponible: <span class="symbol required"></span></label>
                    <input type="hidden" name="diferencia" id="diferencia" value="0.00" readonly=""/>
                    <input type="text" class="form-control cierrecaja" name="dineroefectivo" id="dineroefectivo" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Efectivo" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Observaciones: </label>
                    <textarea type="text" class="form-control" name="comentarios" id="comentarios" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones de Cierre" autocomplete="off" required="" aria-required="true"></textarea>
                    <i class="fa fa-comment-o form-control-feedback"></i> 
                </div>
            </div>
        </div>
        
        </div>

            <div class="modal-footer">
                <button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-archive"></span> Cerrar Caja</button>
                <button class="btn btn-info" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->    
<!--############################## MODAL PARA CERRAR DE ARQUEO ######################################-->


<!--############################## MODAL PARA CERRAR DE ARQUEO ######################################-->
<!-- sample modal content -->
<div id="myModalCierre2222" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
            <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-tasks"></i> Cerrar <label id="nrocaja"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="savecerrararqueo" id="savecerrararqueo" action="#">
                
               <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Cajero: <span class="symbol required"></span></label>
                            <input type="hidden" name="codarqueo" id="codarqueo"/>
                            <input type="hidden" name="proceso" id="proceso" value="update"/>
                            <input type="text" class="form-control" name="responsable" id="responsable" placeholder="Ingrese Nombre Cajero" autocomplete="off" disabled=""aria-required="true"/> 
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Monto Inicial: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="montoinicial" id="montoinicial" autocomplete="off" placeholder="Monto Inicial" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Ingresos: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="ingresos" id="ingresos" autocomplete="off" placeholder="Ingrese Monto de Ingresos" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Egresos: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="egresos" id="egresos" autocomplete="off" placeholder="Monto de Egresos" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div>
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Créditos: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="creditos" id="creditos" autocomplete="off" placeholder="Monto de Créditos" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Abonos de Crédito: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="abonos" id="abonos" autocomplete="off" placeholder="Abono de Créditos" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i>
                      </div>
                   </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Estimado en Caja: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="estimado" id="estimado" autocomplete="off" placeholder="Estimado en Caja" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Efectivo Disponible: <span class="symbol required"></span></label>
                            <input type="text" class="form-control cierrecaja" name="dineroefectivo" id="dineroefectivo" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Efectivo" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Diferencia en Caja: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="diferencia" id="diferencia" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Diferencia en Caja" autocomplete="off" readonly="" aria-required="true"/>  
                            <i class="fa fa-tint form-control-feedback"></i>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Hora de Apertura: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="fechaapertura" id="fechaapertura" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Hora de Apertura" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-clock-o form-control-feedback"></i> 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label">Hora de Cierre: <span class="symbol required"></span></label>
                            <input type="text" class="form-control" name="fecharegistro2" id="fecharegistro2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Hora de Cierre" autocomplete="off" readonly="" aria-required="true"/> 
                            <i class="fa fa-clock-o form-control-feedback"></i> 
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group has-feedback">
                            <label class="control-label">Observaciones: </label>
                            <input type="text" class="form-control" name="comentarios" id="comentarios" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones de Cierre" autocomplete="off" required="" aria-required="true"/> 
                            <i class="fa fa-comment-o form-control-feedback"></i> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-archive"></span> Cerrar Caja</button>
                <button class="btn btn-info" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->    
<!--############################## MODAL PARA CERRAR DE ARQUEO ######################################-->

    
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
        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Consulta General</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Cajas de Ventas</li>
                                <li class="breadcrumb-item active" aria-current="page">Arqueos de Caja</li>
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

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Caja</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

            <div class="form-body">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                          <div class="btn-group m-b-20">
                            <?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="cajero") { ?>
                            <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Arqueo" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalArqueo" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Nuevo</button>
                            <?php } ?>

                            <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipo=<?php echo encrypt("ARQUEOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                           <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                           <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                        </div>
                    </div>
                </div>

                <div id="arqueos"></div>

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
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <!-- script jquery -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/jscript">
    $('#arqueos').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#arqueos').load("consultas?CargaArqueos=si");
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