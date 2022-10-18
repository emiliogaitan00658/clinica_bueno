<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
  if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

$con = new Login();
$con = $con->ConfiguracionPorId();

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "0" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0" : $imp[0]['valorimpuesto']);
    
$tra = new Login();
?>



<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Ip de Máquina</th>
                                                    <th>Fecha</th>
                                                    <th>Navegador</th>
                                                    <th>Usuario</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaLogs();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS DE ACCESO ACTUALMENTE</center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['ip']; ?></td>
                                               <td><?php echo $reg[$i]['tiempo']; ?></td>
                                               <td><?php echo $reg[$i]['detalles']; ?></td>
                                               <td><?php echo $reg[$i]['usuario']; ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR LOGS DE USUARIOS ############################
?>






<?php
############################# CARGAR PACIENTES ############################
if (isset($_GET['CargaPacientes'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>G. Sang.</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Acompañante</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaPacientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PACIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
    <td><?php echo "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cedpaciente']; ?></td>
                               <td><?php echo $reg[$i]['nompaciente']; ?></td>
                               <td><?php echo $reg[$i]['apepaciente']; ?></td>
                               <td><?php echo $reg[$i]['gruposapaciente']; ?></td>
                               <td><?php echo $reg[$i]['tlfpaciente'] == '' ? "***********" : $reg[$i]['tlfpaciente']; ?></td>
                               <td><?php echo $reg[$i]['nomacompana'] == '' ? "***********" : $reg[$i]['nomacompana']; ?></td>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerPaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdatePaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarPaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt("PACIENTES") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PACIENTES ############################
?>










<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Img</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Presentación</th>
                                                    <th>Medida</th>
                                                    <th>Precio #1</th>
                                                    <th>Precio #2</th>
                                                    <th>Stock</th>
                                                    <th><?php echo $impuesto == '' ? "Impuesto" : $imp[0]['nomimpuesto']; ?> </th>
                                                    <th>Descto</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><a href="#" data-placement="left" title="Ver Imagen" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-sm" data-backdrop="static" data-keyboard="false" onClick="VerImagen('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]['codsucursal']) ?>')"><?php if (file_exists("fotos/productos/".$reg[$i]["codproducto"].".jpg")){
    echo "<img src='fotos/productos/".$reg[$i]["codproducto"].".jpg?' class='img-rounded' style='margin:0px;' width='50' height='45'>"; 
}else{
   echo "<img src='fotos/ninguna.png' class='img-rounded' style='margin:0px;' width='50' height='50'>";  
} 
     ?></a></td>
  <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>
                                               <td><?php echo $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                                              <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
<td><?php echo $reg[$i]['moneda2'] == '' ? "**********" : "<strong>".$reg[$i]['simbolo2']."</strong> ".number_format($reg[$i]['precioventa']/$reg[$i]['montocambio'], 2, '.', ','); ?></td>
                                               <td><?php echo $reg[$i]['existencia']; ?></td>
                                               <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $imp[0]["valorimpuesto"]."%" : "(E)"; ?></td>
                                               <td><?php echo $reg[$i]['descproducto']; ?></td>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PRODUCTOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PRODUCTOS ############################
?>











<?php
############################# CARGAR COMPRAS ############################
if (isset($_GET['CargaCompras'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº de Artic</th>
                                                    <th>SubTotal</th>
                                                    <th><?php echo $impuesto == '' ? "Impuesto" : $imp[0]['nomimpuesto']; ?></th>
                                                    <th>Desc.</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaCompras();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>

      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>

      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>

      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPagada('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("P"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("P"); ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR COMPRAS ############################
?>





<?php
############################# CARGAR CUENTAS POR PAGAR ############################
if (isset($_GET['CargaCuentasxPagar'])) { 
?>
<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº de Artic</th>
                                                    <th>SubTotal</th>
                                                    <th><?php echo $impuesto == '' ? "Impuesto" : $imp[0]['nomimpuesto']; ?></th>
                                                    <th>Desc.</th>
                                                    <th>Imp. Total</th>
                                                    <th>Vencidos</th>
                                                    <th>Status</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaCuentasxPagar();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CUENTAS POR PAGAR A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
      elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPendiente('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo "D"; ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-danger btn-rounded" onClick="PagarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PAGARFACTURA") ?>')" title="Pagar Factura" ><i class="fa fa-refresh"></i></button> 

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("D") ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CUENTAS POR PAGAR ############################
?>






<?php
############################# CARGAR CITAS ############################
if (isset($_GET['CargaCitas'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha Cita</th>
                                                    <th>Hora Cita</th>
                                                    <th>Status</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaCitas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CITAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedespecialista']; ?>"><?php echo $reg[$i]['nomespecialista']; ?></abbr></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']).": ".$reg[$i]['cedpaciente']; ?>"><?php echo $reg[$i]['pacientes']; ?></abbr></td>

                                <td><?php echo $reg[$i]['descripcion']; ?></td>
                                <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                                <td><?php echo date("h:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
<td><?php 
if($reg[$i]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statuscita']."</span>"; } 
elseif($reg[$i]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statuscita']."</span>"; } ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCita('<?php echo encrypt($reg[$i]["codcita"]); ?>')"><i class="fa fa-eye"></i></button>


<?php if ($_SESSION['acceso'] != "administradorG") { ?><button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCita('<?php echo encrypt($reg[$i]["codcita"]); ?>','<?php echo encrypt("CITAS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button><?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CITAS ############################
?>








<?php
############################# CARGAR ODONTOLOGIA ############################
if (isset($_GET['CargaOdontologias'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Tratamiento</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaOdontologia();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CONSULTAS ODONTOLOGIA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo $reg[$i]['cedespecialista']; ?>"><?php echo $reg[$i]['nomespecialista']; ?></abbr></td>

  <td><abbr title="<?php echo $reg[$i]['cedpaciente']; ?>"><?php echo $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></abbr></td>

                                <td><?php echo $reg[$i]['plantratamiento']; ?></td>
                                <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                                <td><?php echo date("h:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerOdontologia('<?php echo encrypt($reg[$i]["cododontologia"]); ?>')"><i class="fa fa-eye"></i></button>


<?php if ($_SESSION['acceso'] != "administradorG") { ?><button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarOdontologia('<?php echo encrypt($reg[$i]["cododontologia"]); ?>','<?php echo encrypt("ODONTOLOGIA") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button><?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR ODONTOLOGIA ############################
?>









<?php
############################# CARGAR CONSENTIMIENTOS ############################
if (isset($_GET['CargaConsentimientos'])) { 
?>

<div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Nombre de Testigo</th>
                                                    <th>Fecha</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaConsentimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CONSENTIMIENTOS INFORMADOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo $reg[$i]['cedespecialista']; ?>"><?php echo $reg[$i]['nomespecialista']; ?></abbr></td>

  <td><abbr title="<?php echo $reg[$i]['cedpaciente']; ?>"><?php echo $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></abbr></td>

  <td><abbr title="<?php echo $reg[$i]['doctestigo']; ?>"><?php echo $reg[$i]['nombretestigo']; ?></abbr></td>

                                <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaconsentimiento'])); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
                                               <td>
<a href="reportepdf?codconsentimiento=<?php echo encrypt($reg[$i]['codconsentimiento']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("CONSENTIMIENTO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<?php if ($_SESSION['acceso'] != "administradorG") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateConsentimiento('<?php echo encrypt($reg[$i]["codconsentimiento"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>
 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarConsentimiento('<?php echo encrypt($reg[$i]["codconsentimiento"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("CONSENTIMIENTO") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button><?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CONSENTIMIENTOS ############################
?>



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