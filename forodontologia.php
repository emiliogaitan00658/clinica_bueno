<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarOdontologia();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarOdontologia();
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
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">

    <!-- css dientes -->
    <link rel="stylesheet" href="assets/css/cssDiente.css">
    <link rel="stylesheet" href="assets/css/cssFormulario.css">
    <link rel="stylesheet" href="assets/css/cssComponentesPersonalizados.css">
    <!-- css dientes -->

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
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 



<!--############################## MODAL PARA BUSQUEDA DE CITAS ######################################-->
<!-- sample modal content -->
<div id="myModalBusqueda" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Búsqueda de Citas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
    <form class="form form-material" name="buscar" id="buscar" action="#">
                            
    <div class="modal-body">

    <?php if ($_SESSION["acceso"] == "especialista") { ?>
    <div class="row">
        <input type="hidden" name="codespecialista" id="codespecialista" value="<?php echo encrypt($_SESSION['codespecialista']); ?>"/>
        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Ingrese Fecha de Búsqueda: <span class="symbol required"></span></label>
                <input type="text" class="form-control expira" name="fecha" id="fecha" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Inicio" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" required="" aria-required="true"/>
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>
    </div>
    
    <?php } else { ?>

    <div class="row">
        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
        <div class="col-md-6"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Seleccione Especialista: <span class="symbol required"></span></label> 
                <i class="fa fa-bars form-control-feedback"></i>
                <select name="codespecialista" id="codespecialista" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $especialista = new Login();
                    $especialista = $especialista->ListarEspecialistas();
                    if($especialista==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($especialista);$i++){ ?>
                    <option value="<?php echo encrypt($especialista[$i]['codespecialista']); ?>"><?php echo $especialista[$i]['nomespecialista'] ?></option>        
                    <?php } } ?>
                </select>   
            </div> 
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Ingrese Fecha de Búsqueda: <span class="symbol required"></span></label>
                <input type="text" class="form-control expira" name="fecha" id="fecha" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Inicio" value="<?php echo date("d-m-Y"); ?>" autocomplete="off" required="" aria-required="true"/>
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>
    </div>
    <?php } ?>

              <div class="text-right">
        <button type="button" onClick="BuscarCitasxDia()" class="btn btn-danger"><span class="fa fa-search"></span> Realizar Búsqueda</button>
        <button type="button" class="btn btn-info" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
              </div><br>

    <div id="muestracitasxdia"></div>
        
    </div>

    </form>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA BUSQUEDA DE CITAS ######################################-->
          
                    
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
    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Odontológia</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Odontológia</li>
                                <li class="breadcrumb-item active" aria-current="page">Gestión de Odontológia</li>
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

<?php  if (isset($_GET['cododontologia'])) {
      
      $reg = $tra->OdontologiaPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updateodontologia" id="updateodontologia" data-id="<?php echo $reg[0]["idodontologia"] ?>" enctype="multipart/form-data">
        
    <?php } else { ?>
        
<form class="form form-material" method="post" action="#" name="saveodontologia" id="saveodontologia" enctype="multipart/form-data"> 

    <?php } ?> 



<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-save"></i> Datos del Paciente </h4>
            </div>
            

<!--############################## MODAL PARA FACTURACION ######################################-->
<!-- sample modal content -->
<div id="myModalFacturacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Gestión de Facturación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                <div id="save">
                    <!-- error will be shown here ! -->
                </div> 

                <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-comment-text-outline"></i> Observaciones de Factura</h2>
                <hr>
                <div class="row">
                    <div class="col-md-12 m-t-5"> 
                        <div class="form-group has-feedback2"> 
                            <label class="control-label">Observaciones: </label> 
                            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
                            <i class="fa fa-comment-o form-control-feedback2"></i> 
                        </div> 
                    </div>
                </div>

                <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-archive"></i> Detalles de Factura</h2><hr>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Tipo Búsqueda: <span class="symbol required"></span></label> 
                            <br>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="busqueda" id="name1" value="1" checked="" onclick="LimpiarTexto();" class="custom-control-input">
                                <label class="custom-control-label" for="name1">SERVICIO</label>
                            </div>
<!--                            <div class="custom-control custom-radio custom-control-inline">-->
<!--                                <input type="radio" name="busqueda" id="name2" value="2" onclick="LimpiarTexto();" class="custom-control-input">-->
<!--                                <label class="custom-control-label" for="name2">PRODUCTO</label>-->
<!--                            </div>-->
                        </div>
                    </div>

                    <div class="col-md-3"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Descripción: <span class="symbol required"></span></label>
                            <input type="hidden" name="idproducto" id="idproducto">
                            <input type="hidden" name="codproducto" id="codproducto">
                            <input type="hidden" name="producto" id="producto">
                            <input type="hidden" name="codmarca" id="codmarca">
                            <input type="hidden" name="marca" id="marca">
                            <input type="hidden" name="codpresentacion" id="codpresentacion">
                            <input type="hidden" name="presentacion" id="presentacion">
                            <input type="hidden" name="codmedida" id="codmedida">
                            <input type="hidden" name="medida" id="medida">
                            <input type="hidden" name="preciocompra" id="preciocompra"> 
                            <input type="hidden" name="precioconiva" id="precioconiva">
                            <input type="hidden" name="ivaproducto" id="ivaproducto">
                            <input type="text" class="form-control" name="search_busqueda" id="search_busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio de Búsqueda">
                            <i class="fa fa-pencil form-control-feedback"></i> 
                        </div> 
                    </div> 

                    <div class="col-md-2"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Existencia: <span class="symbol required"></span></label>
                            <input class="form-control" type="text" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="">
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div> 
                    </div> 

                    <div class="col-md-2"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Precio: <span class="symbol required"></span></label>
                            <input class="form-control" type="text" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio">
                            <i class="fa fa-usd form-control-feedback"></i> 
                        </div> 
                    </div>

                    <div class="col-md-2"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Descuento: <span class="symbol required"></span></label>
                            <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Descuento" title="Ingrese Descuento">
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div> 
                    </div> 

                    <div class="col-md-1"> 
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Cant: <span class="symbol required"></span></label>
                            <input type="text" class="form-control agregar" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad">
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div> 
                    </div> 
                </div>

                <div class="pull-right">
                    <button type="button" id="Agregar" class="btn btn-success"><span class="fa fa-cart-plus"></span> Agregar</button>
                    <button type="button" id="vaciar" class="btn btn-dark"><span class="fa fa-trash"></span> Vaciar</button>
                </div></br>

                <div class="table-responsive m-t-40">
                    <table id="carrito" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="16%">Cantidad</th>
                                <th>Descripción</th>
                                <th>Precio Unit.</th>
                                <th>Valor Total</th>
                                <th>Desc %</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Valor Neto</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan=8><h4>NO HAY DETALLES AGREGADOS</h4></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <hr>

                <div class="row">

                    <!-- .col -->
                    <div class="col-md-6">
                    </div>
                    <!-- /.col -->


                    <!-- .col -->  
                    <div class="col-md-6">

                        <table class="table2 text-right" style="overflow: hidden;" width="100">
                        <tr>
                            <td width="70"><label>Subtotal:</label></td>
                            <td width="30"> <label id="lblsubtotal" name="lblsubtotal">0.00</label>
                            <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/></td>
                        </tr>
                        <tr>
                            <td><label>Gravado <?php echo $valor; ?>%:</label></td>
                            <td> <label id="lblgravado" name="lblgravado">0.00</label>
                            <input type="hidden" name="txtgravado" id="txtgravado" value="0.00"/></td>
                        </tr>
                        <tr>
                            <td><label>Exento 0%:</label></td>
                            <td> <label id="lblexento" name="lblexento">0.00</label>
                            <input type="hidden" name="txtexento" id="txtexento" value="0.00"/></td>
                        </tr>
                        <tr>
                            <td><label><?php echo $impuesto; ?> <?php echo $valor; ?>%:</label>
                            <input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo $valor; ?>"></td>
                            <td> <label id="lbliva" name="lbliva">0.00</label>
                            <input type="hidden" name="txtIva" id="txtIva" value="0.00"/></td>
                        </tr>
                        <tr>
                            <td><label>Descontado %:</label></td>
                            <td> <label id="lbldescontado" name="lbldescontado">0.00</label>
                            <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/></td>
                        </tr>
                        <tr>
                            <td><label>Desc. Global <input class="number bold" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:40px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="0.00">%:</label></td>
                            <td> <label id="lbldescuento" name="lbldescuento">0.00</label></td>
                            <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
                        </tr>
                        <tr>
                            <td><label>Importe Total:</label></td>
                            <td> 
                            <label id="lbltotal" name="lbltotal">0.00</label>
                            <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
                            <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
                            </td>
                        </tr>
                        </table>


                    </div>
                    <!-- /.col -->
                </div>


                </div><!-- end modal-body -->
              
              <div class="modal-footer">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" disabled="" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button></span>
                <button type="button" class="btn btn-info" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA FACTURACION ######################################-->    


        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                    
                    <input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['cododontologia'])) { ?> value="update" <?php } else { ?>  value="save" <?php } ?>/>

                    <input type="hidden" name="idodontologia" id="idodontologia" <?php if (isset($reg[0]['idodontologia'])) { ?> value="<?php echo encrypt($reg[0]['idodontologia']); ?>" <?php } ?>>
                    <input type="hidden" name="cododontologia" id="cododontologia" <?php if (isset($reg[0]['cododontologia'])) { ?> value="<?php echo encrypt($reg[0]['cododontologia']); ?>" <?php } ?>/>

                    <input type="hidden" name="codcita" id="codcita" <?php if (isset($reg[0]['codcita'])) { ?> value="<?php echo encrypt($reg[0]['codcita']); ?>" <?php } ?>/>
                    <input type="hidden" name="cita" id="cita" <?php if (isset($reg[0]['codcita'])) { ?> value="<?php echo $reg[0]['codcita']; ?>" <?php } ?>/>
                    
                    <input type="hidden" name="codpaciente" id="codpaciente" <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo encrypt($reg[0]['codpaciente']); ?>" <?php } ?>/>
                    <input type="hidden" name="paciente" id="paciente" <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $reg[0]['codpaciente']; ?>" <?php } ?>/> 
                    
                    <input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>" <?php } ?>/>
                    <input type="hidden" name="sucursal" id="sucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo $reg[0]['codsucursal']; ?>" <?php } else { ?> value="<?php echo $_SESSION["codsucursal"]; ?>" <?php } ?>/>

                    <input type="hidden" name="codespecialista" id="codespecialista" <?php if (isset($reg[0]['codespecialista'])) { ?> value="<?php echo encrypt($reg[0]['codespecialista']); ?>" <?php } ?>/>

                    <?php if (isset($reg[0]['idodontologia'])) { ?>
                    <input type="text" class="form-control" name="cedpaciente" id="cedpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" style="width:100%;height:40px;background:#f0f0f1;" autocomplete="off" value="<?php echo $reg[0]['cedpaciente']; ?>" disabled=""/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cedpaciente" id="cedpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" style="width:100%;height:40px;background:#f0f0f1;" autocomplete="off" readonly="" aria-required="true" data-placement="left" title="Nuevo Especialista" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalBusqueda" data-backdrop="static" data-keyboard="false"/>
                    <?php } ?>
                    <i class="fa fa-search form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Paciente: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="nompaciente" id="nompaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Paciente" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['nompaciente'])) { ?> value="<?php echo $reg[0]['nompaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Apellido de Paciente: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="apepaciente" id="apepaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Apellido de Paciente" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['apepaciente'])) { ?> value="<?php echo $reg[0]['apepaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Sexo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="sexopaciente" id="sexopaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Sexo" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['sexopaciente'])) { ?> value="<?php echo $reg[0]['sexopaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Grupo Sanguineo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="gruposapaciente" id="gruposapaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Grupo Sanguineo" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['gruposapaciente'])) { ?> value="<?php echo $reg[0]['gruposapaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Ocupación Laboral: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="ocupacionpaciente" id="ocupacionpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Ocupación Laboral" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['ocupacionpaciente'])) { ?> value="<?php echo $reg[0]['ocupacionpaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Estado Civil: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="estadopaciente" id="estadopaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Estado Civil" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['estadopaciente'])) { ?> value="<?php echo $reg[0]['estadopaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Nacimiento: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="fnacpaciente" id="fnacpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Nacimiento" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['fnacpaciente'])) { ?> value="<?php echo date("d-m-Y",strtotime($reg[0]['fnacpaciente'])); ?>" <?php } ?> disabled="" aria-required="true">
                    <i class="fa fa-calendar form-control-feedback"></i> 
                </div>
            </div> 
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                    <input type="text" class="form-control phone-inputmask" name="tlfpaciente" id="tlfpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['tlfpaciente'])) { ?> value="<?php echo $reg[0]['tlfpaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-phone form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="direcpaciente" id="direcpaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['direcpaciente'])) { ?> value="<?php echo $reg[0]['direcpaciente']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-map-marker form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Acompañante: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="nomacompana" id="nomacompana" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Acompañante" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['nomacompana'])) { ?> value="<?php echo $reg[0]['nomacompana']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Parentesco de Acompañante: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="parentescoacompana" id="parentescoacompana" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Parentesco de Acompañante" style="width:100%;height:40px;background:#f0f9fc;" autocomplete="off" <?php if (isset($reg[0]['parentescoacompana'])) { ?> value="<?php echo $reg[0]['parentescoacompana']; ?>" <?php } ?> disabled="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div id="muestrahistorial"></div>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="mdi mdi-tooth"></i> Odontograma</h4>
            </div>

    <div class="form-body">

    <div class="card-body">

    <div class="row">
        <div class="col-md-12">

            <div id="seccionDientes" class="sombraFormulario"></div>          

        </div>
    </div>

    <hr>

    <div class="row">

        <div class="col-md-2">
            <section class="displayInlineBlockMiddle">
            <div class="dienteGeneral" id="dienteGeneral">

                <div id="C1" onClick="seleccionarCara(this.id);"></div>
                <div id="C2" onClick="seleccionarCara(this.id);"></div>
                <div id="C3" onClick="seleccionarCara(this.id);"></div>
                <div id="C4" onClick="seleccionarCara(this.id);"></div>
                <div id="C5" onClick="seleccionarCara(this.id);"></div>

            <input type="text" id="txtIdentificadorDienteGeneral" name="txtIdentificadorDienteGeneral" value="DXX" disabled="">
            </div>
            </section>
        </div>

        <div class="col-md-4">
            <div class="displayInlineBlockMiddle">
                <div id="odontograma" class="formulario sombraFormulario labelPequenio">

                <div class="tituloFormulario">DATOS DEL TRATAMIENTO</div>
                <div class="contenidoInterno">
                    <label for=""><b>Diente Tratado:</b></label>
                    <input type="text" id="txtDienteTratado" name="txtDienteTratado" class="textAlignCenter" size="4" readonly="readonly">
                    <br>
                    <label for=""><b>Cara Tratada:</b></label>
                    <input type="text" id="txtCaraTratada" name="txtCaraTratada" class="textAlignCenter" size="4" readonly="readonly">
                    <br>
                    <label for=""><b>Referencias:</b></label>
                    <select id="cbxEstado" name="cbxEstado" style="white">
                        <option value="">-- SELECCIONE REFERENCIA --</option>
                       <option value="1-C Cirugia de Cordales">Cirugia de Cordales</option>
<option value="2-RR Restauracion de Resina">Restauracion de Resina</option>
<option value="3-RA Restauracion de Amalgama">Restauracion de Amalgama</option>
<option value="4-L Limpieza Dentales">Limpieza Dentales</option>
<option value="5-EN Endondoncia en Molares">Endondoncia en Molares</option>
<option value="6-CO Corona Individuales de procelana">Corona Individuales de procelana</option>
<option value="7-PR Protesis Fija de Procelana">Protesis Fija de Procelana</option>
<option value="8-PR Protesis R Bilateral Colados">Protesis R Bilateral Colados</option>
<option value="9-PR Protesis R Bilateral Alamabre">Protesis R Bilateral Alamabre</option>
<option value="10-PR Protesis U Bilateral Alamabre">Protesis U Bilateral Alamabre</option>
<option value="11-PR Protesis U Bilateral Valplast">Protesis U Bilateral Valplast</option>
<option value="12-PR Protesus B Bilateral Valplast">Protesus B Bilateral Valplast</option>
<option value="18-Extracciones">Extracciones</option>
<option value="13-PR Protesis Totales">Protesis Totales</option>
<option value="14-GUA Guardas Oclusales">Guardas Oclusales</option>
<option value="15-RX Radiografia Dentales">Radiografia Dentales</option>
<option value="16-BLA Blanqueamiento Dental">Blanqueamiento Dental</option>
<option value="17-ORTHO Tratamiento de Ortodoncia">Tratamiento de Ortodoncia</option>

                        </select>
                        <br></br>

        <div class="text-right">
            <button type="button" id="guarda" class="btn btn-danger waves-effect waves-light" <?php if (isset($reg[0]['cododontologia'])) { ?>  <?php } else { ?> disabled="" <?php } ?> onClick="guardarTratamiento();"><span class="fa fa-save"></span> Registrar</button>

            <button type="button" id="agrega" class="btn btn-success waves-effect waves-light" <?php if (isset($reg[0]['cododontologia'])) { ?>  <?php } else { ?> disabled="" <?php } ?> onClick="agregarTratamiento($('#txtDienteTratado').val(), $('#txtCaraTratada').val(), $('#cbxEstado').val());"><span class="fa fa-share"></span> Agregar</button>
        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div id="divTratamiento" class="displayInlineBlockTop sombraFormulario" style="width: 100%;height:210px;overflow-y: scroll;scrollbar-width: thin;white-space: nowrap">
                <table id="tablaTratamiento" class="table2 table-striped table-bordered border display">
                <tbody>
                </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fileinput text-center fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 190px; height: 170px;">
                <div id="foto"><?php if (isset($reg[0]['cododontologia'])) {
                if (file_exists("fotos/odontograma/F_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".jpg")){
                    echo "<img src='fotos/odontograma/F_".$reg[0]['codcita']."_".$reg[0]['codpaciente']."_".$reg[0]['codsucursal'].".jpg?".date('h:i:s')."' class='rounded-circle' width='190' height='170'>"; 
                } else {
                    echo "<img src='fotos/img.png' class='rounded-circle' width='190' height='170'>"; 
                } } else {
                    echo "<img src='fotos/img.png' class='rounded-circle' width='190' height='170'>"; 
                } ?></div>
                </div>
                <div>
                <span class="btn btn-success btn-file">
                <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-file-image-o"></i> Fotografia</span>
                <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-paint-brush"></i> </span>
                <input type="file" size="10" data-original-title="Subir Fotografia" data-rel="tooltip" placeholder="Suba su Fotografia" name="imagen" id="imagen"/>
                </span>
                <a href="#" class="btn btn-dark fileinput-exists" onclick="CargaFoto();" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> </a>                             
                </div>
            </div>
        </div>
                   
    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-folder-open-o"></i> Antecedentes Médicos</h4>
            </div>
            
        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Tratamiento Médico: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tratamientomedico" id="tratamiento1" value="SI" <?php if (isset($reg[0]['tratamientomedico']) && $reg[0]['tratamientomedico'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaTratamiento(this.form.tratamientomedico.value);" class="custom-control-input">
                    <label class="custom-control-label" for="tratamiento1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tratamientomedico" id="tratamiento2" value="NO" <?php if (isset($reg[0]['tratamientomedico']) && $reg[0]['tratamientomedico'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaTratamiento(this.form.tratamientomedico.value);" class="custom-control-input">
                    <label class="custom-control-label" for="tratamiento2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tratamientomedico" id="tratamiento3" value="NO SABE" <?php if (isset($reg[0]['tratamientomedico']) && $reg[0]['tratamientomedico'] == "NO SABE") { ?> checked="checked" <?php } ?> onclick="ActivaTratamiento(this.form.tratamientomedico.value);" class="custom-control-input">
                    <label class="custom-control-label" for="tratamiento3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Indica Tratamiento Médico: </label>
                    <?php if (isset($reg[0]['cualestratamiento'])) { ?>
                    <input type="text" class="form-control" name="cualestratamiento" id="cualestratamiento" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Tratamiento Médico" autocomplete="off" <?php if ($reg[0]['cualestratamiento']!="") { ?> value="<?php echo $reg[0]['cualestratamiento']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cualestratamiento" id="cualestratamiento" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Tratamiento Médico" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Ingesta de Medicamentos: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="ingestamedicamentos" id="ingesta1" value="SI" <?php if (isset($reg[0]['ingestamedicamentos']) && $reg[0]['ingestamedicamentos'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaMedicamento(this.form.ingestamedicamentos.value);" class="custom-control-input">
                    <label class="custom-control-label" for="ingesta1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="ingestamedicamentos" id="ingesta2" value="NO" <?php if (isset($reg[0]['ingestamedicamentos']) && $reg[0]['ingestamedicamentos'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaMedicamento(this.form.ingestamedicamentos.value);" class="custom-control-input">
                    <label class="custom-control-label" for="ingesta2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="ingestamedicamentos" id="ingesta3" value="NO SABE" <?php if (isset($reg[0]['ingestamedicamentos']) && $reg[0]['ingestamedicamentos'] == "NO SABE") { ?> checked="checked" <?php } ?> onclick="ActivaMedicamento(this.form.ingestamedicamentos.value);" class="custom-control-input">
                    <label class="custom-control-label" for="ingesta3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Indica Cuales Medicamentos: </label>
                    <?php if (isset($reg[0]['cualesingesta'])) { ?>
                    <input type="text" class="form-control" name="cualesingesta" id="cualesingesta" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Medicamentos" autocomplete="off" 
                    <?php if ($reg[0]['cualesingesta']!="") { ?> value="<?php echo $reg[0]['cualesingesta']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cualesingesta" id="cualesingesta" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Medicamentos" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Reacciones Alérgicas: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="alergias" id="alergias1" value="SI" <?php if (isset($reg[0]['alergias']) && $reg[0]['alergias'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaAlergias(this.form.alergias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="alergias1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="alergias" id="alergias2" value="NO" <?php if (isset($reg[0]['alergias']) && $reg[0]['alergias'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaAlergias(this.form.alergias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="alergias2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="alergias" id="alergias3" value="NO SABE" <?php if (isset($reg[0]['alergias']) && $reg[0]['alergias'] == "NO SABE") { ?> checked="checked" <?php } ?> onclick="ActivaAlergias(this.form.alergias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="alergias3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Indica Cuales Alérgicas: </label>
                    <?php if (isset($reg[0]['cualesalergias'])) { ?>
                    <input type="text" class="form-control" name="cualesalergias" id="cualesalergias" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Alérgicas" autocomplete="off" 
                    <?php if ($reg[0]['cualesalergias']!="") { ?> value="<?php echo $reg[0]['cualesalergias']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cualesalergias" id="cualesalergias" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Alérgicas" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Hemorragias: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hemorragias" id="hemorragias1" value="SI" <?php if (isset($reg[0]['hemorragias']) && $reg[0]['hemorragias'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaHemorragia(this.form.hemorragias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="hemorragias1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hemorragias" id="hemorragias2" value="NO" <?php if (isset($reg[0]['hemorragias']) && $reg[0]['hemorragias'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaHemorragia(this.form.hemorragias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="hemorragias2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hemorragias" id="hemorragias3" value="NO SABE" <?php if (isset($reg[0]['hemorragias']) && $reg[0]['hemorragias'] == "NO SABE") { ?> checked="checked" <?php } ?> onclick="ActivaHemorragia(this.form.hemorragias.value);" class="custom-control-input">
                    <label class="custom-control-label" for="hemorragias3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Indica Cuales Hemorragias: </label>
                    <?php if (isset($reg[0]['cualeshemorragias'])) { ?>
                    <input type="text" class="form-control" name="cualeshemorragias" id="cualeshemorragias" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Hemorragias" autocomplete="off" 
                    <?php if ($reg[0]['cualeshemorragias']!="") { ?> value="<?php echo $reg[0]['cualeshemorragias']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cualeshemorragias" id="cualeshemorragias" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuales Hemorragias" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Sinositis: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sinositis" id="sinositis1" value="SI" <?php if (isset($reg[0]['sinositis']) && $reg[0]['sinositis'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="sinositis1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sinositis" id="sinositis2" value="NO" <?php if (isset($reg[0]['sinositis']) && $reg[0]['sinositis'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="sinositis2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sinositis" id="sinositis3" value="NO SABE" <?php if (isset($reg[0]['sinositis']) && $reg[0]['sinositis'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="sinositis3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Enfermedad Respiratoria: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="enfermedadrespiratoria" id="respiratoria1" value="SI" <?php if (isset($reg[0]['enfermedadrespiratoria']) && $reg[0]['enfermedadrespiratoria'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="respiratoria1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="enfermedadrespiratoria" id="respiratoria2" value="NO" <?php if (isset($reg[0]['enfermedadrespiratoria']) && $reg[0]['enfermedadrespiratoria'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="respiratoria2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="enfermedadrespiratoria" id="respiratoria3" value="NO SABE" <?php if (isset($reg[0]['enfermedadrespiratoria']) && $reg[0]['enfermedadrespiratoria'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="respiratoria3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Diabetes: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="diabetes" id="diabetes1" value="SI" <?php if (isset($reg[0]['diabetes']) && $reg[0]['diabetes'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="diabetes1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="diabetes" id="diabetes2" value="NO" <?php if (isset($reg[0]['diabetes']) && $reg[0]['diabetes'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="diabetes2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="diabetes" id="diabetes3" value="NO SABE" <?php if (isset($reg[0]['diabetes']) && $reg[0]['diabetes'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="diabetes3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Cardiopatia: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cardiopatia" id="cardiopatia1" value="SI" <?php if (isset($reg[0]['cardiopatia']) && $reg[0]['cardiopatia'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="cardiopatia1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cardiopatia" id="cardiopatia2" value="NO" <?php if (isset($reg[0]['cardiopatia']) && $reg[0]['cardiopatia'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="cardiopatia2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cardiopatia" id="cardiopatia3" value="NO SABE" <?php if (isset($reg[0]['cardiopatia']) && $reg[0]['cardiopatia'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="cardiopatia3">NO SABE</label>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Hepatitis: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepatitis" id="hepatitis1" value="SI" <?php if (isset($reg[0]['hepatitis']) && $reg[0]['hepatitis'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepatitis1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepatitis" id="hepatitis2" value="NO" <?php if (isset($reg[0]['hepatitis']) && $reg[0]['hepatitis'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepatitis2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepatitis" id="hepatitis3" value="NO SABE" <?php if (isset($reg[0]['hepatitis']) && $reg[0]['hepatitis'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepatitis3">NO SABE</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Hipertensión Arterial: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepertension" id="hepertension1" value="SI" <?php if (isset($reg[0]['hepertension']) && $reg[0]['hepertension'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepertension1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepertension" id="hepertension2" value="NO" <?php if (isset($reg[0]['hepertension']) && $reg[0]['hepertension'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepertension2">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="hepertension" id="hepertension3" value="NO SABE" <?php if (isset($reg[0]['hepertension']) && $reg[0]['hepertension'] == "NO SABE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="hepertension3">NO SABE</label>
                    </div>
                </div>
            </div>
        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Hábitos de Salud Oral</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Asistencia a Odontología: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="asistenciaodontologica" id="asistencia1" value="SI" <?php if (isset($reg[0]['asistenciaodontologica']) && $reg[0]['asistenciaodontologica'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaAsistencia(this.form.asistenciaodontologica.value);" class="custom-control-input">
                    <label class="custom-control-label" for="asistencia1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="asistenciaodontologica" id="asistencia2" value="NO" <?php if (isset($reg[0]['asistenciaodontologica']) && $reg[0]['asistenciaodontologica'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaAsistencia(this.form.asistenciaodontologica.value);" class="custom-control-input">
                    <label class="custom-control-label" for="asistencia2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Ingrese Fecha Ultima Visita: </label>
                    <?php if (isset($reg[0]['ultimavisitaodontologia'])) { ?>
                    <input type="text" class="form-control calendario" name="ultimavisitaodontologia" id="ultimavisitaodontologia" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha Ultima Visita" autocomplete="off" 
                    <?php if ($reg[0]['ultimavisitaodontologia']!="0000-00-00") { ?> value="<?php echo date("d-m-Y",strtotime($reg[0]['ultimavisitaodontologia'])); ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control calendario" name="ultimavisitaodontologia" id="ultimavisitaodontologia" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha Ultima Visita" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-calendar form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Cepillado Diario: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cepillado" id="cepillado1" value="SI" <?php if (isset($reg[0]['cepillado']) && $reg[0]['cepillado'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaCepillado(this.form.cepillado.value);" class="custom-control-input">
                    <label class="custom-control-label" for="cepillado1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cepillado" id="cepillado2" value="NO" <?php if (isset($reg[0]['cepillado']) && $reg[0]['cepillado'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaCepillado(this.form.cepillado.value);" class="custom-control-input">
                    <label class="custom-control-label" for="cepillado2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Indica Cuantas Veces al Día: </label>
                    <?php if (isset($reg[0]['cuantoscepillados'])) { ?>
                    <input type="text" class="form-control" name="cuantoscepillados" id="cuantoscepillados" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuantas Veces al Día" autocomplete="off" 
                    <?php if ($reg[0]['cuantoscepillados']!="") { ?> value="<?php echo $reg[0]['cuantoscepillados']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cuantoscepillados" id="cuantoscepillados" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuantas Veces al Día" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Seda Dental: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sedadental" id="seda1" value="SI" <?php if (isset($reg[0]['sedadental']) && $reg[0]['sedadental'] == "SI") { ?> checked="checked" <?php } ?> onclick="ActivaSeda(this.form.sedadental.value);" class="custom-control-input">
                    <label class="custom-control-label" for="seda1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sedadental" id="seda2" value="NO" <?php if (isset($reg[0]['sedadental']) && $reg[0]['sedadental'] == "NO") { ?> checked="checked" <?php } ?> onclick="ActivaSeda(this.form.sedadental.value);" class="custom-control-input">
                    <label class="custom-control-label" for="seda2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Ingrese Cuantas Veces al Día: </label>
                    <?php if (isset($reg[0]['cuantascedasdental'])) { ?>
                    <input type="text" class="form-control" name="cuantascedasdental" id="cuantascedasdental" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuantas Veces al Día" autocomplete="off" 
                    <?php if ($reg[0]['cuantascedasdental']!="") { ?> value="<?php echo $reg[0]['cuantascedasdental']; ?>" <?php } else { ?> disabled="" <?php } ?> required="" aria-required="true"/>
                    <?php } else { ?>
                    <input type="text" class="form-control" name="cuantascedasdental" id="cuantascedasdental" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Cuantas Veces al día" autocomplete="off" disabled="" required="" aria-required="true"/> 
                    <?php } ?>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Crema Dental: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cremadental" id="crema1" value="SI" <?php if (isset($reg[0]['cremadental']) && $reg[0]['cremadental'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="crema1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="cremadental" id="crema2" value="NO" <?php if (isset($reg[0]['cremadental']) && $reg[0]['cremadental'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="crema2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Enjuague: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="enjuague" id="enjuague1" value="SI" <?php if (isset($reg[0]['enjuague']) && $reg[0]['enjuague'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="enjuague1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="enjuague" id="enjuague2" value="NO" <?php if (isset($reg[0]['enjuague']) && $reg[0]['enjuague'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="enjuague2">NO</label>
                    </div>
                </div>
            </div>
        </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Estado Periodontal</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Sangran Encias al Cepillar: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sangranencias" id="sangran1" value="SI" <?php if (isset($reg[0]['sangranencias']) && $reg[0]['sangranencias'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="sangran1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sangranencias" id="sangran2" value="NO" <?php if (isset($reg[0]['sangranencias']) && $reg[0]['sangranencias'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="sangran2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Toma Agua de la Llave: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tomaaguallave" id="llave1" value="SI" <?php if (isset($reg[0]['tomaaguallave']) && $reg[0]['tomaaguallave'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="llave1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="tomaaguallave" id="llave2" value="NO" <?php if (isset($reg[0]['tomaaguallave']) && $reg[0]['tomaaguallave'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="llave2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Aplican elementos que contienen Fluor: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="elementosconfluor" id="fluor1" value="SI" <?php if (isset($reg[0]['elementosconfluor']) && $reg[0]['elementosconfluor'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="fluor1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="elementosconfluor" id="fluor2" value="NO" <?php if (isset($reg[0]['elementosconfluor']) && $reg[0]['elementosconfluor'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="fluor2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Aparatos de Ortodoncia: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="aparatosortodoncia" id="aparatos1" value="SI" <?php if (isset($reg[0]['aparatosortodoncia']) && $reg[0]['aparatosortodoncia'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="aparatos1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="aparatosortodoncia" id="aparatos2" value="NO" <?php if (isset($reg[0]['aparatosortodoncia']) && $reg[0]['aparatosortodoncia'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="aparatos2">NO</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Protésis: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="protesis" id="protesis1" value="SI" <?php if (isset($reg[0]['protesis']) && $reg[0]['protesis'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="protesis1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="protesis" id="protesis2" value="NO" <?php if (isset($reg[0]['protesis']) && $reg[0]['protesis'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="protesis2">NO</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Tipo de Protésis: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="protesisfija" id="protesisfija" value="FIJA" <?php if (isset($reg[0]['protesisfija']) && $reg[0]['protesisfija'] == "FIJA") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="protesisfija">FIJA</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="protesisremovible" id="protesisremovible" value="REMOVIBLE" <?php if (isset($reg[0]['protesisremovible']) && $reg[0]['protesisremovible'] == "REMOVIBLE") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="protesisremovible">REMOVIBLE</label>
                    </div>
                </div>
            </div>
        </div>

  <h4 class="card-subtitle m-t-10"><i class="fa fa-tasks"></i> Articulacion Temporo-Mandibular</h4><hr>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Labios: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="labios" id="labios1" value="NORMAL" <?php if (isset($reg[0]['labios']) && $reg[0]['labios'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="labios1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="labios" id="labios2" value="ANORMAL" <?php if (isset($reg[0]['labios']) && $reg[0]['labios'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="labios2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Lengua: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="lengua" id="lengua1" value="NORMAL" <?php if (isset($reg[0]['lengua']) && $reg[0]['lengua'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="lengua1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="lengua" id="lengua2" value="ANORMAL" <?php if (isset($reg[0]['lengua']) && $reg[0]['lengua'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="lengua2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Paladar: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="paladar" id="paladar1" value="NORMAL" <?php if (isset($reg[0]['paladar']) && $reg[0]['paladar'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="paladar1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="paladar" id="paladar2" value="ANORMAL" <?php if (isset($reg[0]['paladar']) && $reg[0]['paladar'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="paladar2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Piso de la Boca: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="pisoboca" id="pisoboca1" value="NORMAL" <?php if (isset($reg[0]['pisoboca']) && $reg[0]['pisoboca'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="pisoboca1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="pisoboca" id="pisoboca2" value="ANORMAL" <?php if (isset($reg[0]['pisoboca']) && $reg[0]['pisoboca'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="pisoboca2">ANORMAL</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Carrillos: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="carrillos" id="carrillos1" value="NORMAL" <?php if (isset($reg[0]['carrillos']) && $reg[0]['carrillos'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="carrillos1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="carrillos" id="carrillos2" value="ANORMAL" <?php if (isset($reg[0]['carrillos']) && $reg[0]['carrillos'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="carrillos2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Glandulas Salivales: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="glandulasalivales" id="glandulas1" value="NORMAL" <?php if (isset($reg[0]['glandulasalivales']) && $reg[0]['glandulasalivales'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="glandulas1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="glandulasalivales" id="glandulas2" value="ANORMAL" <?php if (isset($reg[0]['glandulasalivales']) && $reg[0]['glandulasalivales'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="glandulas2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Maxilar: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="maxilar" id="maxilar1" value="NORMAL" <?php if (isset($reg[0]['maxilar']) && $reg[0]['maxilar'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="maxilar1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="maxilar" id="maxilar2" value="ANORMAL" <?php if (isset($reg[0]['maxilar']) && $reg[0]['maxilar'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="maxilar2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Senos Maxilares: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="senosmaxilares" id="senosmaxilares1" value="NORMAL" <?php if (isset($reg[0]['senosmaxilares']) && $reg[0]['senosmaxilares'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="senosmaxilares1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="senosmaxilares" id="senosmaxilares2" value="ANORMAL" <?php if (isset($reg[0]['senosmaxilares']) && $reg[0]['senosmaxilares'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="senosmaxilares2">ANORMAL</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Musculos Masticadores: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="musculosmasticadores" id="musculos1" value="NORMAL" <?php if (isset($reg[0]['musculosmasticadores']) && $reg[0]['musculosmasticadores'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="musculos1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="musculosmasticadores" id="musculos2" value="ANORMAL" <?php if (isset($reg[0]['musculosmasticadores']) && $reg[0]['musculosmasticadores'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="musculos2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Sistema Nervioso: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemanervioso" id="nervioso1" value="NORMAL" <?php if (isset($reg[0]['sistemanervioso']) && $reg[0]['sistemanervioso'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="nervioso1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemanervioso" id="nervioso2" value="ANORMAL" <?php if (isset($reg[0]['sistemanervioso']) && $reg[0]['sistemanervioso'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="nervioso2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Vascular: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemavascular" id="vascular1" value="NORMAL" <?php if (isset($reg[0]['sistemavascular']) && $reg[0]['sistemavascular'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="vascular1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemavascular" id="vascular2" value="ANORMAL" <?php if (isset($reg[0]['sistemavascular']) && $reg[0]['sistemavascular'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="vascular2">ANORMAL</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Linfático Regional: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemalinfatico" id="linfatico1" value="NORMAL" <?php if (isset($reg[0]['sistemalinfatico']) && $reg[0]['sistemalinfatico'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="linfatico1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="sistemalinfatico" id="linfatico2" value="ANORMAL" <?php if (isset($reg[0]['sistemalinfatico']) && $reg[0]['sistemalinfatico'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="linfatico2">ANORMAL</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Función Oclusal: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="funcionoclusal" id="oclusal1" value="NORMAL" <?php if (isset($reg[0]['funcionoclusal']) && $reg[0]['funcionoclusal'] == "NORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="oclusal1">NORMAL</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="funcionoclusal" id="oclusal2" value="ANORMAL" <?php if (isset($reg[0]['funcionoclusal']) && $reg[0]['funcionoclusal'] == "ANORMAL") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="oclusal2">ANORMAL</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Observaciones Periodontal: </label> 
                    <textarea class="form-control" type="text" name="observacionperiodontal" id="observacionperiodontal" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones Periodontal" rows="1"><?php if (isset($reg[0]['observacionperiodontal'])) { echo $reg[0]['observacionperiodontal']; } ?></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-paste"></i> Exámen Dental</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Supernumerarios: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="supernumerarios" id="supernumerarios1" value="SI" <?php if (isset($reg[0]['supernumerarios']) && $reg[0]['supernumerarios'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="supernumerarios1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="supernumerarios" id="supernumerarios2" value="NO" <?php if (isset($reg[0]['supernumerarios']) && $reg[0]['supernumerarios'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="supernumerarios2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Adración: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="adracion" id="adracion1" value="SI" <?php if (isset($reg[0]['adracion']) && $reg[0]['adracion'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="adracion1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="adracion" id="adracion2" value="NO" <?php if (isset($reg[0]['adracion']) && $reg[0]['adracion'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="adracion2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Manchas: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="manchas" id="manchas1" value="SI" <?php if (isset($reg[0]['manchas']) && $reg[0]['manchas'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="manchas1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="manchas" id="manchas2" value="NO" <?php if (isset($reg[0]['manchas']) && $reg[0]['manchas'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="manchas2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Patología Pulpar: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="patologiapulpar" id="pulpar1" value="SI" <?php if (isset($reg[0]['patologiapulpar']) && $reg[0]['patologiapulpar'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="pulpar1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="patologiapulpar" id="pulpar2" value="NO" <?php if (isset($reg[0]['patologiapulpar']) && $reg[0]['patologiapulpar'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="pulpar2">NO</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Placa Blanda: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="placablanda" id="blanda1" value="SI" <?php if (isset($reg[0]['placablanda']) && $reg[0]['placablanda'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="blanda1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="placablanda" id="blanda2" value="NO" <?php if (isset($reg[0]['placablanda']) && $reg[0]['placablanda'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="blanda2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Placa Calificada: </label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="placacalificada" id="calificada1" value="SI" <?php if (isset($reg[0]['placacalificada']) && $reg[0]['placacalificada'] == "SI") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="calificada1">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="placacalificada" id="calificada2" value="NO" <?php if (isset($reg[0]['placacalificada']) && $reg[0]['placacalificada'] == "NO") { ?> checked="checked" <?php } ?> class="custom-control-input">
                    <label class="custom-control-label" for="calificada2">NO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Otros Exámen Dental: </label> 
                    <textarea class="form-control" type="text" name="otrosdental" id="otrosdental" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" <?php if (isset($reg[0]['otrosdental'])) { ?> value="<?php echo $reg[0]['otrosdental']; ?>" <?php } ?> placeholder="Ingrese Otros Exámen Dental" required="" aria-required="true"></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Observaciones Exámen Dental: </label> 
                    <textarea class="form-control" type="text" name="observacionexamendental" id="observacionexamendental" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones Exámen Dental" autocomplete="off" <?php if (isset($reg[0]['observacionexamendental'])) { ?> value="<?php echo $reg[0]['observacionexamendental']; ?>" <?php } ?> required="" aria-required="true"></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-paste"></i> Diagnóstico y Pronóstico</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group has-feedback">
                <table width="100%" id="tabla"><tr> 

<a class="btn btn-success btn-rounded" onClick="AddDxPresuntivo()"><i class="fa fa-plus-circle text-white"></i></a>&nbsp;
<a class="btn btn-danger btn-rounded" onClick="DeleteDxPresuntivo()"><i class="fa fa-trash-o text-white"></i></a><br></br>

                    <td>
            <?php
            if (isset($reg[0]['presuntivo'])) {

            $explode = explode(",,",$reg[0]['presuntivo']);
            for($cont=0; $cont<COUNT($explode); $cont++):
            list($idciepresuntivo,$presuntivo) = explode("/",$explode[$cont]);
            ?>
                <div class="col-md-12">
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Dx Presuntivo: </label>
                        <input type="hidden" name="idciepresuntivo[]<?php echo $cont; ?>" id="idciepresuntivo<?php echo $cont; ?>" value="<?php echo $idciepresuntivo; ?>"/>
                        <input type="text" class="form-control" name="presuntivo[]<?php echo $cont; ?>" id="presuntivo<?php echo $cont; ?>" onKeyUp="this.value=this.value.toUpperCase(); autocompletar(this.name);" value="<?php echo $presuntivo; ?>" placeholder="Ingrese Nombre de Dx para tu Busqueda" title="Ingrese Dx Presuntivo">
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                </div>

            <?php endfor; 

            } else { ?>

                <div class="col-md-12">
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Dx Presuntivo: </label>
                        <input type="hidden" name="idciepresuntivo[]" id="idciepresuntivo"/>
                        <input type="text" class="form-control" name="presuntivo[]" id="presuntivo" onKeyUp="this.value=this.value.toUpperCase(); autocompletar(this.name);" placeholder="Ingrese Nombre de Dx para tu Busqueda" title="Ingrese Dx Presuntivo">
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                </div>

            <?php } ?>

                 </td></tr><input type="hidden" name="var_cont">
                </table>
                </div> 
            </div>

            <div class="col-md-6"> 
                <div class="form-group has-feedback">
                <table width="100%" id="tabla2"><tr> 

<a class="btn btn-success btn-rounded" onClick="AddDxDefinitivo()"><i class="fa fa-plus-circle text-white"></i></a>&nbsp;
<a class="btn btn-danger btn-rounded" onClick="DeleteDxDefinitivo()"><i class="fa fa-trash-o text-white"></i></a><br></br>

                    <td>
            <?php
            if (isset($reg[0]['definitivo'])) {

            $explode = explode(",,",$reg[0]['definitivo']);
            for($cont=0; $cont<COUNT($explode); $cont++):
            list($idciedefinitivo,$definitivo) = explode("/",$explode[$cont]);    
            ?>

                <div class="col-md-12">
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Dx Definitivo: </label>
                        <input type="hidden" name="idciedefinitivo[]" id="idciedefinitivo" value="<?php echo $idciedefinitivo; ?>"/>
                        <input type="text" class="form-control" name="definitivo[]" id="definitivo" onKeyUp="this.value=this.value.toUpperCase(); autocompletar2(this.name);" value="<?php echo $definitivo; ?>" placeholder="Ingrese Nombre de Dx para tu Busqueda" title="Ingrese Dx Definitivo">
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                </div>

            <?php endfor; 

            } else { ?>

                <div class="col-md-12">
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Dx Definitivo: </label>
                        <input type="hidden" name="idciedefinitivo[]" id="idciedefinitivo"/>
                        <input type="text" class="form-control" name="definitivo[]" id="definitivo" onKeyUp="this.value=this.value.toUpperCase(); autocompletar2(this.name);" placeholder="Ingrese Nombre de Dx para tu Busqueda" title="Ingrese Dx Definitivo">
                        <i class="fa fa-pencil form-control-feedback"></i>
                    </div>
                </div>

            <?php } ?>

            </td></tr><input type="hidden" name="var_cont">
                </table>
                </div> 
            </div>
        </div>

        <div class="row">
          <div class="col-md-12"> 
            <div class="form-group has-feedback2"> 
              <label class="control-label">Pronóstico: </label> 
              <textarea class="form-control" type="text" name="pronostico" id="pronostico" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Pronóstico" rows="1"><?php if (isset($reg[0]['pronostico'])) { echo $reg[0]['pronostico']; } ?></textarea>
              <i class="fa fa-comment-o form-control-feedback2"></i> 
            </div> 
          </div>
        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-paste"></i> Plan de Tratamiento</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <?php 
        $tratamiento = new Login();
        $tratamiento = $tratamiento->ListarTratamientos();

        if($tratamiento==""){  

        } else { ?>

        <div class="row"> 

        <?php
        $a=1;
        for($i=0;$i<sizeof($tratamiento);$i++){ 
        ?>

            <div class="col-md-3 m-t-5">
                    <div class="custom-control custom-radio">
                        <input type="checkbox" class="custom-control-input" name="plantratamiento[]" id="codtratamiento_<?php echo $tratamiento[$i]['codtratamiento'] ?>" value="<?php echo $tratamiento[$i]['nomtratamiento']; ?>"
                        <?php
                        if (isset($reg[0]['plantratamiento'])) {
                        $news = explode(",", $reg[0]['plantratamiento']);
                        foreach ($news as $value){
                        echo $value === $tratamiento[$i]['nomtratamiento'] ? "checked=\"checked\"" :''; 
                        } 
                        } ?>>

                        <label class="custom-control-label" for="codtratamiento_<?php echo $tratamiento[$i]['codtratamiento'] ?>">
                        <?php echo $tratamiento[$i]['nomtratamiento']; ?>
                        </label>
                </div>
            </div>
        <?php } ?>
        
        </div> 
        <?php } ?>

        <div class="row">
          <div class="col-md-12 m-t-20"> 
            <div class="form-group has-feedback2"> 
              <label class="control-label">Observaciones de Tratamiento: </label> 
              <textarea class="form-control" type="text" name="observacionestratamiento" id="observacionestratamiento" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones de Tratamiento" rows="1"><?php if (isset($reg[0]['observacionperiodontal'])) { echo $reg[0]['observacionperiodontal']; } ?></textarea>
              <i class="fa fa-comment-o form-control-feedback2"></i> 
            </div> 
          </div>
        </div>

            <div class="text-right">
    <?php  if (isset($_GET['cododontologia'])) { ?>
<span id="submit_update"><button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button></span>
<button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button> 
    <?php } else { ?>
<button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Continuar Facturación" data-original-title="" data-href="#" disabled="" data-toggle="modal" data-target="#myModalFacturacion"><span class="fa fa-calculator"></span> Continuar</button>
<button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Limpiar</button>
    <?php } ?>  
             </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

    </form>

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
    <script src="assets/js/popper.min.js"></script> 
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

    <!-- Custom file upload -->
    <script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/agrega_filas.js"></script>
    <script type="text/javascript" src="assets/script/jsAcciones.js"></script>
    <script type="text/javascript" src="assets/script/html2canvas.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jsdetalles.js"></script>
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
    <script src="assets/plugins/datatables/dataTables.min.js"></script>
    <script src="assets/plugins/datatables/datatable-basic.init.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
      $('#default_order').dataTable();
    } );
    </script>
    <!-- jQuery -->

    <script>
    cargarTratamientos("divTratamiento", "funciones.php?BuscaTablaTratamiento=si&codcita="+$('#codcita').val()+"&codpaciente="+$('#codpaciente').val()+"&codsucursal="+$('#codsucursal').val(), '', '');
    cargarDientes("seccionDientes", "dientes.php", '', $('#codcita').val(), $('#codpaciente').val(), $('#codsucursal').val());
    </script>
         
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