<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION["acceso"]=="administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarCotizaciones();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarCotizaciones();
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
     <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Cotizaciones</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Cotizaciones</li>
                                <li class="breadcrumb-item active" aria-current="page">Cotizaciones</li>
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
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Cotización</h4>
            </div>

<?php if (isset($_GET['codcotizacion']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
      
$reg = $tra->CotizacionesPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatecotizacion" id="updatecotizacion" data-id="<?php echo $reg[0]["codcotizacion"] ?>">

<?php } else if (isset($_GET['codcotizacion']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
      
$reg = $tra->CotizacionesPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="agregacotizacion" id="agregacotizacion" data-id="<?php echo $reg[0]["codcotizacion"] ?>">
        
<?php } else { ?>
        
 <form class="form form-material" method="post" action="#" name="savecotizacion" id="savecotizacion">

<?php } ?>
 

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

    <div class="form-body">

            <div class="card-body">
  
<input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codcotizacion']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codcotizacion']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>

<input type="hidden" name="idcotizacion" id="idcotizacion" <?php if (isset($reg[0]['idcotizacion'])) { ?> value="<?php echo $reg[0]['idcotizacion']; ?>"<?php } ?>>
<input type="hidden" name="codcotizacion" id="codcotizacion" <?php if (isset($reg[0]['codcotizacion'])) { ?> value="<?php echo encrypt($reg[0]['codcotizacion']); ?>"<?php } ?>>
<input type="hidden" name="cotizacion" id="cotizacion" <?php if (isset($reg[0]['codcotizacion'])) { ?> value="<?php echo encrypt($reg[0]['codcotizacion']); ?>"<?php } ?>>

<input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>" <?php } ?>>
<input type="hidden" name="sucursal" id="sucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } ?>>
    
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <?php if ($_SESSION['acceso'] == "especialista") { ?>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Búsqueda de Paciente: <span class="symbol required"></span></label>
                <input type="hidden" name="codespecialista" id="codespecialista" <?php if (isset($reg[0]['codespecialista'])) { ?> value="<?php echo $reg[0]['codespecialista']; ?>" <?php } else { ?> value="<?php echo $_SESSION['codespecialista']; ?>" <?php } ?>>
                <input type="hidden" name="codpaciente" id="codpaciente" <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $reg[0]['codpaciente']; ?>" <?php } ?>>
                <input type="text" class="form-control" name="search_paciente" id="search_paciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda de Paciente" autocomplete="off"  <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'])." ".$reg[0]['cedpaciente']." : ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>" <?php } ?> required="required"/>
                <i class="fa fa-search form-control-feedback"></i> 
            </div>
        </div>
    </div>

    <?php } else { ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Búsqueda de Especialista: <span class="symbol required"></span></label>
                <input type="hidden" name="codespecialista" id="codespecialista" <?php if (isset($reg[0]['codespecialista'])) { ?> value="<?php echo $reg[0]['codespecialista']; ?>" <?php } ?>>
                <input type="text" class="form-control" name="search_especialista" id="search_especialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda de Especialista" autocomplete="off"  <?php if (isset($reg[0]['codespecialista'])) { ?> value="<?php echo $reg[0]['cedespecialista']." : ".$reg[0]['nomespecialista']; ?>" <?php } ?> required="required"/>
                <i class="fa fa-search form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Búsqueda de Paciente: <span class="symbol required"></span></label>
                <input type="hidden" name="codpaciente" id="codpaciente" <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $reg[0]['codpaciente']; ?>" <?php } ?>>
                <input type="text" class="form-control" name="search_paciente" id="search_paciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda de Paciente" autocomplete="off"  <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $reg[0]['cedpaciente']." : ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>" <?php } ?> required="required"/>
                <i class="fa fa-search form-control-feedback"></i> 
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="row"> 
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Observaciones: </label>
                <input class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" <?php if (isset($reg[0]['observaciones'])) { ?> value="<?php echo $reg[0]['observaciones']; ?>" <?php } ?> required="" aria-required="true">
                <i class="fa fa-comments form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    
<?php if (isset($_GET['codcotizacion']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallescotizacionupdate">

    <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
$simbolo = "<strong>".$reg[0]['simbolo']."</strong>";
?>
                <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantventa[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCotizacion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantventa"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadventabd[]" id="cantidadventabd" value="<?php echo $detalle[$i]["cantventa"]; ?>">
      <input type="hidden" name="coddetallecotizacion[]" id="coddetallecotizacion" value="<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo encrypt($detalle[$i]["codproducto"]); ?>">
      <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo encrypt($detalle[$i]["tipodetalle"]); ?>">
      <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
      </td>
      
      <td class="text-left"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == "" ? "******" : $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['nommedida'] == "" ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>

      <td><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><strong><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

      <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></strong></td>
      
      <td><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ','); ?>">
        <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><strong><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? $reg[0]['iva']."%" : "(E)"; ?></strong></td>
      
      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'SI' ? $detalle[$i]['valorneto'] : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == 'NO' ? $detalle[$i]['valorneto'] : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

        <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo $detalle[$i]['valorneto2']; ?>" >

        <strong> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetallesCotizacionUpdate('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[0]["codpaciente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
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
                            <td width="30"><?php echo $simbolo; ?>  <label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi']+$reg[0]['subtotalivano'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi']+$reg[0]['subtotalivano'], 2, '.', ''); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></td>
                            <td><?php echo $simbolo; ?>  <label id="lblgravado" name="lblgravado"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtgravado" id="txtgravado" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label>Exento 0%:</label></td>
                            <td><?php echo $simbolo; ?> <label id="lblexento" name="lblexento"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtexento" id="txtexento" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label>
                            <input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></td>
                            <td><?php echo $simbolo; ?>  <label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label>Descontado %:</label></td>
                            <td><?php echo $simbolo; ?> <label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label>Desc. Global <input class="number bold" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:40px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></td>
                            <td><?php echo $simbolo; ?>  <label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?></label>
                            <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?>"/></td>
                        </tr>
                        <tr>
                            <td><label>Importe Total:</label></td>
                            <td> 
                            <?php echo $simbolo; ?> <label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label>
                            <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
                            <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>
                            </td>
                        </tr>
                        </table>

                    </div>
                    <!-- /.col -->

                </div>


    </div>

<?php } else { ?>

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

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
                            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                            <input type="text" class="form-control agregar" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad">
                            <i class="fa fa-bolt form-control-feedback"></i> 
                        </div> 
                    </div> 
                </div>

                <div class="pull-right">
                    <button type="button" id="Agregar" class="btn btn-success"><span class="fa fa-cart-plus"></span> Agregar</button>
                </div></br>

                <div class="table-responsive m-t-40">
                    <table id="carrito" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="16%">Cantidad</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
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
                            <td> <label id="lbldescuento" name="lbldescuento">0.00</label>
                            <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></td>
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


<?php } ?> 


              <div class="text-right">
<?php  if (isset($_GET['codcotizacion']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button class="btn btn-danger" type="submit" name="btn-update" id="btn-update"><span class="fa fa-edit"></span> Actualizar</button></span>
<a href="cotizaciones"><button class="btn btn-info" type="button"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codcotizacion']) && decrypt($_GET["proceso"])=="A") { ?>  
<button class="btn btn-info" type="submit" name="btn-agregar" id="btn-agregar"><span class="fa fa-plus"></span> Agregar</button>
<button class="btn btn-dark" type="button" id="vaciar2"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button class="btn btn-danger" type="submit" name="btn-submit" id="btn-submit" disabled=""><span class="fa fa-save"></span> Guardar</button></span>
<button class="btn btn-info" type="button" id="vaciar"><i class="fa fa-trash-o"></i> Limpiar</button>
<?php } ?>
</div>

          </div>
       </div>
     </form>
   </div>
  </div>
</div>
<!-- End Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
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
    <script type="text/javascript" src="assets/script/jscotizaciones.js"></script>
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