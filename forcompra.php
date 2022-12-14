<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION["acceso"]=="administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarCompras();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarCompras();
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
     <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gesti??n de Compras</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Compras</li>
                                <li class="breadcrumb-item active" aria-current="page">Compras</li>
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
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gesti??n de Compras</h4>
            </div>

<?php if (isset($_GET['codcompra']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
      
$reg = $tra->ComprasPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatecompra" id="updatecompra" data-id="<?php echo $reg[0]["codcompra"] ?>">
        
<?php } else { ?>
        
 <form class="form form-material" method="post" action="#" name="savecompra" id="savecompra">

<?php } ?>
           

                <div id="save">
                   <!-- error will be shown here ! -->
               </div>

               <div class="form-body">

            <div class="card-body">

    
<input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['idcompra'])) { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
<input type="hidden" name="idcompra" id="idcompra" <?php if (isset($reg[0]['idcompra'])) { ?> value="<?php echo encrypt($reg[0]['idcompra']); ?>" <?php } ?>>
<input type="hidden" name="compra" id="compra" <?php if (isset($reg[0]['codcompra'])) { ?> value="<?php echo encrypt($reg[0]['codcompra']); ?>" <?php } ?>>

<input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"<?php } ?>>
<input type="hidden" name="sucursal" id="sucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } ?>>
<input type="hidden" name="status" id="status" <?php if (isset($reg[0]['idcompra'])) { ?> value="<?php echo decrypt($_GET["status"]); ?>" <?php } ?>>
    
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row"> 
        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">N?? de Compra: <span class="symbol required"></span></label>
                <input class="form-control" type="text" name="codcompra" id="codcompra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="N?? Compra" <?php if (isset($reg[0]['codcompra'])) { ?> value="<?php echo $reg[0]['codcompra']; ?>" readonly="" <?php } else { ?> required="" aria-required="true" <?php } ?>>
                <i class="fa fa-flash form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Fecha de Emisi??n: <span class="symbol required"></span></label> 
                <input type="text" class="form-control calendario" name="fechaemision" id="fechaemision" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Emisi??n" <?php if (isset($reg[0]['fechaemision'])) { ?> value="<?php echo $reg[0]['fechaemision'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>"<?php } ?> required="" aria-required="true">
                <i class="fa fa-calendar form-control-feedback"></i>  
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Fecha de Recepci??n: <span class="symbol required"></span></label> 
                <input type="text" class="form-control calendario" name="fecharecepcion" id="fecharecepcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Recepci??n" <?php if (isset($reg[0]['fecharecepcion'])) { ?> value="<?php echo $reg[0]['fecharecepcion'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?>"<?php } ?> required="" aria-required="true">
                 <i class="fa fa-calendar form-control-feedback"></i>  
            </div> 
        </div>

        <div class="col-md-3"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
                <i class="fa fa-bars form-control-feedback"></i>
                <?php if (isset($reg[0]['codproveedor'])) { ?>
                <select name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $proveedor = new Login();
                $proveedor = $proveedor->ListarProveedores();
                if($proveedor==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($proveedor);$i++){ ?>
                <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"<?php if (!(strcmp($reg[0]['codproveedor'], htmlentities($proveedor[$i]['codproveedor'])))) {echo "selected=\"selected\""; } ?>><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
                <?php } } ?>
                </select>
                <?php } else { ?>
                <select name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $proveedor = new Login();
                $proveedor = $proveedor->ListarProveedores();
                if($proveedor==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($proveedor);$i++){ ?>
                <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
                <?php } } ?>
                </select>
                <?php } ?>  
            </div> 
        </div>
    </div>

    <div class="row"> 
        <div class="col-md-12"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Observaciones: </label>
                <input class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" <?php if (isset($reg[0]['observaciones'])) { ?> value="<?php echo $reg[0]['observaciones']; ?>" <?php } ?> required="" aria-required="true">
                <i class="fa fa-comments form-control-feedback"></i> 
            </div> 
        </div>
    </div>


<?php if (isset($_GET['codcompra']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallescompraupdate">

    <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripci??n</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acci??n</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
$simbolo = "<strong>".$reg[0]['simbolo']."</strong>";
?>
                <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantcompra[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantcompra"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadcomprabd[]" id="cantidadcomprabd" value="<?php echo $detalle[$i]["cantcompra"]; ?>">
      <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo encrypt($detalle[$i]["codproducto"]); ?>">
      </td>      
     
      <td class="text-left"><input type="hidden" name="precioventa[]" id="precioventa" value="<?php echo number_format($detalle[$i]["precioventac"], 2, '.', ''); ?>"><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) : MEDIDA (<?php echo $detalle[$i]['codmedida'] == 0 ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>

      <td><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocomprac"], 2, '.', ','); ?>"><strong><?php echo number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>

      <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ','); ?>"><strong><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></strong></td>
      
      <td>
    <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
    <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
    <strong><label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></strong></td>

      <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproductoc"]; ?>"><strong><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? $reg[0]['ivac']."%" : "(E)"; ?></strong></td>
      
      <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? $detalle[$i]['valorneto'] : "0.00"; ?>">

        <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproductoc'] == 'NO' ? $detalle[$i]['valorneto'] : "0.00"; ?>">

        <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?>" ><strong> <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></strong></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetallesComprasUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
            </div>

            <hr>

            <div class="row">

                <!-- .col -->
                <div class="col-md-6">
                    <h3 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cash-multiple"></i> M??todos de Pago</h3><hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="control-label">Condici??n de Pago: <span class="symbol required"></span></label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="contado" value="CONTADO" <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CONTADO") { ?> checked="checked" <?php } else { ?> checked="checked" disabled="" <?php } ?> onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="contado">CONTADO</label>
                                </div><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="credito" value="CREDITO" <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CREDITO") { ?> checked="checked" disabled="" <?php } ?> onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="credito">CR??DITO</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6"> 
                            <div class="form-group has-feedback"> 
                                <label class="control-label">M??todo de Pago: <span class="symbol required"></span></label>
                                <i class="fa fa-bars form-control-feedback"></i>
                                <?php if (isset($reg[0]['formacompra'])) { ?>
                                <select name="formacompra" id="formacompra" class="form-control" <?php if($reg[0]['tipocompra'] == 'CREDITO'){ ; ?> disabled="" <?php } ?> required="" aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <option value="EFECTIVO"<?php if (!(strcmp('EFECTIVO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>EFECTIVO</option>
                                    <option value="CHEQUE"<?php if (!(strcmp('CHEQUE', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>CHEQUE</option>
                                    <option value="TARJETA DE CREDITO"<?php if (!(strcmp('TARJETA DE CREDITO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA DE CR??DITO</option>
                                    <option value="TARJETA DE DEBITO"<?php if (!(strcmp('TARJETA DE DEBITO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA DE D??BITO</option>
                                    <option value="TARJETA PREPAGO"<?php if (!(strcmp('TARJETA PREPAGO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA PREPAGO</option>
                                    <option value="TRANSFERENCIA"<?php if (!(strcmp('TRANSFERENCIA', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TRANSFERENCIA</option>
                                    <option value="DINERO ELECTRONICO"<?php if (!(strcmp('DINERO ELECTRONICO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>DINERO ELECTR??NICO</option>
                                    <option value="CUPON"<?php if (!(strcmp('CUPON', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>CUP??N</option>
                                    <option value="OTROS"<?php if (!(strcmp('OTROS', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>OTROS</option>
                                </select>
                                <?php } else { ?>
                                <select name="formacompra" id="formacompra" class="form-control" required="" aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <option value="EFECTIVO">EFECTIVO</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TARJETA DE CREDITO">TARJETA DE CR??DITO</option>
                                    <option value="TARJETA DE DEBITO">TARJETA DE D??BITO</option>
                                    <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                    <option value="DINERO ELECTRONICO">DINERO ELECTR??NICO</option>
                                    <option value="CUPON">CUP??N</option>
                                    <option value="OTROS">OTROS</option>
                                </select>
                                <?php } ?>
                            </div> 
                        </div>
                    </div>

                    <div id="muestra_metodo"><!-- metodo de pago -->

                     <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CREDITO") { ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label class="control-label">Fecha Vence Cr??dito: <span class="symbol required"></span></label>
                                <input type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" <?php if (isset($reg[0]['fechavencecredito'])) { ?> value="<?php echo $reg[0]['fechavencecredito'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechavencecredito'])); ?>" <?php } ?> placeholder="Ingrese Fecha Vencimiento" aria-required="true">
                                <i class="fa fa-calendar form-control-feedback"></i>
                            </div>
                        </div>
                    </div>
                     
                    <?php } ?>   
                        
                    </div><!-- end metodo de pago -->

                </div>
                <!-- /.col -->


                <!-- .col -->  
                <div class="col-md-6">

                    <table class="table2 text-right" style="overflow: hidden;" width="100">
                    <tr>
                        <td width="70"><label>Subtotal:</label></td>
                        <td width="30"><?php echo $simbolo; ?> <label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasic']+$reg[0]['subtotalivanoc'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasic']+$reg[0]['subtotalivanoc'], 2, '.', ''); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Gravado <?php echo number_format($reg[0]['ivac'], 2, '.', '') ?>%:</label></td>
                        <td><?php echo $simbolo; ?> <label id="lblgravado" name="lblgravado"><?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtgravado" id="txtgravado" value="<?php echo number_format($reg[0]['subtotalivasic'], 2, '.', ''); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Exento 0%:</label></td>
                        <td><?php echo $simbolo; ?> <label id="lblexento" name="lblexento"><?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtexento" id="txtexento" value="<?php echo number_format($reg[0]['subtotalivanoc'], 2, '.', ''); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['ivac'], 2, '.', ''); ?>%:</label>
                        <input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo $reg[0]['ivac'] ?>"></td>
                        <td><?php echo $simbolo; ?> <label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totalivac'], 2, '.', ''); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Descontado %:</label></td>
                        <td><?php echo $simbolo; ?> <label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontadoc'], 2, '.', ''); ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Desc. Global <input class="number bold" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:40px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuentoc'], 2, '.', ''); ?>">%:</label></td>
                        
                        <td><?php echo $simbolo; ?> <label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', '') ?></label><input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuentoc'], 2, '.', '') ?>"/></td>
                    </tr>
                    <tr>
                        <td><label>Importe Total:</label></td>
                        <td> 
                        <?php echo $simbolo; ?> <label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?></label>
                        <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpagoc'], 2, '.', ''); ?>"/>
                        </td>
                    </tr>
                    </table>

                </div>
                <!-- /.col -->

            </div>


    </div>    

<?php } else { ?>

    <input type="hidden" name="producto" id="producto">
    <input type="hidden" name="marca" id="marca">
    <input type="hidden" name="presentacion" id="presentacion">
    <input type="hidden" name="medida" id="medida">

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                   <label class="control-label">Realice la B??squeda de Producto: <span class="symbol required"></span></label>
                   <input type="hidden" name="codproducto" id="codproducto"/>
                   <input type="text" class="form-control" name="busquedaproductoc" id="busquedaproductoc" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la B??squeda por C??digo, Descripci??n o Marca">
                   <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <input class="form-control" type="text" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="">
                    <i class="fa fa-usd form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Cantidad Compra: <span class="symbol required"></span></label>
                    <input type="text" class="form-control agregacompra" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad Compra" autocomplete="off">
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Dcto en Compra: <span class="symbol required"></span></label>
                    <input class="form-control agregacompra" type="text" name="descfactura" id="descfactura" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento en Compra" value="0.00">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Dcto en Venta: <span class="symbol required"></span></label>
                    <input class="form-control agregacompra" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento en Venta" value="0.00">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>
        </div>
 
        <div class="row">

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label"><?php echo $impuesto == '' ? "Impuesto" : $imp[0]['nomimpuesto']; ?> de Producto: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select name="ivaproducto" id="ivaproducto" class="form-control">
                        <option value="">SELECCIONE</option>
                        <option value="SI">SI</option>
                        <option value="NO">NO</option>
                    </select> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="hidden" name="porcentaje" id="porcentaje" <?php if ($_SESSION['acceso'] == "administradorG") { ?> value="0.00" <?php } else { ?> value="<?php echo $_SESSION['porcentaje']; ?>" <?php } ?>>
                    <input class="form-control calculoprecio agregacompra" type="text" name="preciocompra" id="preciocompra" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Compra">
                    <input type="hidden" name="precioconiva" id="precioconiva" value="0.00">                        
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>                                                                                                                             
            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Precio de Venta: <span class="symbol required"></span></label>
                    <input class="form-control agregacompra" type="text" name="precioventa" id="precioventa" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Precio de Venta" value="0.00">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div> 

            <div class="col-md-2">
                <div class="form-group has-feedback"> 
                    <label class="control-label">N?? de Lote: <span class="symbol required"></span></label>
                    <input class="form-control agregacompra" type="text" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="N?? de Lote" value="0">
                    <i class="fa fa-flash form-control-feedback"></i> 
                </div> 
            </div>
                    
            <div class="col-md-2">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Elaboraci??n: </label>
                    <input type="text" class="form-control calendario agregacompra" name="fechaelaboracion" id="fechaelaboracion" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Elab." autocomplete="off"/>
                    <i class="fa fa-calendar form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Expiraci??n: </label>
                    <input type="text" class="form-control expira agregacompra" name="fechaexpiracion" id="fechaexpiracion" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Exp." autocomplete="off"/>  
                    <i class="fa fa-calendar form-control-feedback"></i>
                </div>
            </div>
        </div>  

        
        <div class="pull-right">
    <button type="button" id="AgregaCompra" class="btn btn-success"><span class="fa fa-cart-plus"></span> Agregar</button>
        </div></br>

        <div class="table-responsive m-t-40">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Cantidad</th>
                        <th>Descripci??n</th>
                        <th>Precio Unit.</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acci??n</th>
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
                    <h3 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cash-multiple"></i> M??todos de Pago</h3><hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="control-label">Condici??n de Pago: <span class="symbol required"></span></label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="contado" value="CONTADO" checked="" onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="contado">CONTADO</label>
                                </div><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="credito" value="CREDITO" onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="credito">CR??DITO</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6"> 
                            <div class="form-group has-feedback"> 
                                <label class="control-label">M??todo de Pago: <span class="symbol required"></span></label>
                                <i class="fa fa-bars form-control-feedback"></i>
                                <select name="formacompra" id="formacompra" class="form-control" required="" aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <option value="EFECTIVO">EFECTIVO</option>
                                    <option value="CHEQUE">CHEQUE</option>
                                    <option value="TARJETA DE CREDITO">TARJETA DE CR??DITO</option>
                                    <option value="TARJETA DE DEBITO">TARJETA DE D??BITO</option>
                                    <option value="TARJETA PREPAGO">TARJETA PREPAGO</option>
                                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                    <option value="DINERO ELECTRONICO">DINERO ELECTR??NICO</option>
                                    <option value="CUPON">CUP??N</option>
                                    <option value="OTROS">OTROS</option>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <div id="muestra_metodo"><!-- metodo de pago -->
                        
                    </div><!-- end metodo de pago -->

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
                        </td>
                    </tr>
                    </table>

                </div>
                <!-- /.col -->

            </div>

<?php } ?> 


              <div class="text-right">
<?php  if (isset($_GET['codcompra']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button class="btn btn-danger" type="submit" name="btn-update" id="btn-update"><span class="fa fa-edit"></span> Actualizar</button></span>
<button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button> 
<?php } else if (isset($_GET['codcompra']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button class="btn btn-info" type="submit" name="btn-agregar" id="btn-agregar"><span class="fa fa-plus"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar2"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button class="btn btn-danger" type="submit" name="btn-submit" id="btn-submit"><span class="fa fa-save"></span> Guardar</button></span>
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
    <script type="text/javascript" src="assets/script/jscompras.js"></script>
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