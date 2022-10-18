<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
  if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista" || $_SESSION["acceso"]=="paciente") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
    
$tra = new Login();
?>


<?php
############################# CARGAR USUARIOS ############################
if (isset($_GET['CargaUsuarios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Documento</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Usuario</th>
                                                    <th>Nivel</th>
                                                    <th>Status</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON USUARIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td><?php echo $reg[$i]['telefono']; ?></td>
                                               <td><?php echo $reg[$i]['usuario']; ?></td>
                                               <td><?php echo $reg[$i]['nivel']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['gruposnombres'] == '' ? "*********" : $reg[$i]['gruposnombres']; ?></strong></td><?php } ?>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalUser" data-backdrop="static" data-keyboard="false" onClick="UpdateUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["dni"]; ?>','<?php echo $reg[$i]["nombres"]; ?>','<?php echo $reg[$i]["sexo"]; ?>','<?php echo $reg[$i]["direccion"]; ?>','<?php echo $reg[$i]["telefono"]; ?>','<?php echo $reg[$i]["email"]; ?>','<?php echo $reg[$i]["usuario"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["status"]; ?>','update'); CargarSucursalesAsignadasxUsuarios('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["gruposid"]; ?>')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["dni"]); ?>','<?php echo encrypt("USUARIOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR USUARIOS ############################
?>






<?php
############################# CARGAR HORARIOS DE USUARIOS ############################
if (isset($_GET['CargaHorariosUsuarios'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Usuario</th>
                                                    <th>Hora Desde</th>
                                                    <th>Hora Hasta</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarHorariosUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON HORARIO DE ACCESO ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                          <tr role="row" class="odd">
                <td><?php echo $a++; ?></td>
                <td><?php echo $reg[$i]['nombres']."<br> <strong>(".$reg[$i]['nivel'].")</strong>"; ?></td>
                <td><?php echo $reg[$i]['hora_desde']; ?></td>
                <td><?php echo $reg[$i]['hora_hasta']; ?></td>
                          <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateHorarioUsuario('<?php echo $reg[$i]["codhorario"]; ?>','<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo $reg[$i]["hora_desde"]; ?>','<?php echo $reg[$i]["hora_hasta"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarHorarioUsuario('<?php echo encrypt($reg[$i]["codhorario"]); ?>','<?php echo encrypt("HORARIOSUSUARIOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR HORARIOS DE USUARIOS ############################
?>






<?php
############################# CARGAR HORARIOS DE ESPECIALISTAS ############################
if (isset($_GET['CargaHorariosEspecialistas'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Hora Desde</th>
                                                    <th>Hora Hasta</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarHorariosEspecialistas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON HORARIO DE ACCESO ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                          <tr role="row" class="odd">
                <td><?php echo $a++; ?></td>
                <td><?php echo $reg[$i]['nomespecialista']."<br> <strong>(".$reg[$i]['especialidad'].")</strong>"; ?></td>
                <td><?php echo $reg[$i]['hora_desde']; ?></td>
                <td><?php echo $reg[$i]['hora_hasta']; ?></td>
                          <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateHorarioEspecialista('<?php echo $reg[$i]["codhorario"]; ?>','<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo $reg[$i]["hora_desde"]; ?>','<?php echo $reg[$i]["hora_hasta"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarHorarioEspecialista('<?php echo encrypt($reg[$i]["codhorario"]); ?>','<?php echo encrypt("HORARIOSESPECIALISTAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR HORARIOS DE ESPECIALISTAS ############################
?>



<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
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
$reg = $tra->ListarLogs();

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
############################# CARGAR DEPARTAMENTOS ############################
if (isset($_GET['CargaDepartamentos'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Departamento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDepartamentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DEPARTAMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['departamento']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDepartamento('<?php echo $reg[$i]['id_departamento']; ?>','<?php echo $reg[$i]["departamento"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDepartamento('<?php echo encrypt($reg[$i]["id_departamento"]); ?>','<?php echo encrypt("DEPARTAMENTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVINCIAS ############################
?>




<?php
############################# CARGAR PROVINCIAS ############################
if (isset($_GET['CargaProvincias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Departamento</th>
                                                    <th>Provincia</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProvincias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVINCIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['departamento']; ?></td>
                                               <td><?php echo $reg[$i]['provincia']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateProvincia('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["provincia"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarProvincia('<?php echo encrypt($reg[$i]["id_provincia"]); ?>','<?php echo encrypt("PROVINCIAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVINCIAS ############################
?>





<?php
############################# CARGAR TIPOS DE DOCUMENTOS ############################
if (isset($_GET['CargaDocumentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción de Documento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDocumentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE DOCUMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['documento']; ?></td>
                                               <td><?php echo $reg[$i]['descripcion']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDocumento('<?php echo $reg[$i]["coddocumento"]; ?>','<?php echo $reg[$i]["documento"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDocumento('<?php echo encrypt($reg[$i]["coddocumento"]); ?>','<?php echo encrypt("DOCUMENTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE DOCUMENTOS ############################
?>





<?php
############################# CARGAR TIPOS DE MONEDA ############################
if (isset($_GET['CargaMonedas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Moneda</th>
                                                    <th>Siglas</th>
                                                    <th>Simbolo</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoMoneda();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE MONEDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['moneda']; ?></td>
                                               <td><?php echo $reg[$i]['siglas']; ?></td>
                                               <td><?php echo $reg[$i]['simbolo']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoMoneda('<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["moneda"]; ?>','<?php echo $reg[$i]["siglas"]; ?>','<?php echo $reg[$i]["simbolo"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarTipoMoneda('<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt("TIPOMONEDA"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE MONEDA ############################
?>



<?php
############################# CARGAR TIPOS DE CAMBIO ############################
if (isset($_GET['CargaCambios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Cambio</th>
                                                    <th>Monto de Cambio</th>
                                                    <th>Tipo Moneda</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO DE MONEDA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
                                               <td><?php echo $reg[$i]['montocambio']; ?></td>
  <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
                    <td>
<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoCambio('<?php echo $reg[$i]["codcambio"]; ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo number_format($reg[$i]["montocambio"], 3, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo encrypt("TIPOCAMBIO"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TIPOS DE CAMBIO ############################
?>



<?php
############################# CARGAR IMPUESTOS ############################
if (isset($_GET['CargaImpuestos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Impuesto</th>
                                                    <th>Valor (%)</th>
                                                    <th>Status</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
                                               <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
<td><?php echo $status = ( $reg[$i]['statusimpuesto'] == 'ACTIVO' ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statusimpuesto']."</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statusimpuesto']."</span>"); ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateImpuesto('<?php echo $reg[$i]["codimpuesto"]; ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo number_format($reg[$i]["valorimpuesto"], 2, '.', ''); ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo encrypt("IMPUESTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
 <?php 
   } 
############################# CARGAR IMPUESTOS ############################
?>





<?php
############################# CARGAR SUCURSALES ############################
if (isset($_GET['CargaSucursales'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Logo</th>
                                                    <th>N° de Documento</th>
                                                    <th>Razón Social</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Encargado</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSucursales();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUCURSALES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php
$directory='fotos/sucursales/';

if (is_dir($directory)) {
$dirint = dir($directory);
    while (($archivo = $dirint->read()) !== false) {
              
    if ($archivo != "." && $archivo != ".." && substr_count($archivo , ".png")==1 || substr_count($archivo , ".PNG")==1 ){
    
    echo '';
       }
    } $dirint->close(); 
  } else { } ?>
     <?php if (file_exists("fotos/sucursales/".$reg[$i]["cuitsucursal"].".png")){
    echo "<img src='fotos/sucursales/".$reg[$i]["cuitsucursal"].".png?' class='img-rounded' style='margin:0px;' width='50' height='40'>";
       }else{
    echo "<img src='fotos/ninguna.png' class='img-rounded' style='margin:0px;' width='50' height='40'>";  
    } ?>
  </a></td>
                                               <td><?php echo $reg[$i]['cuitsucursal']; ?></td>
                                               <td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td>
                                               <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
                                               <td><?php echo $reg[$i]['correosucursal']; ?></td>
                                               <td><?php echo $reg[$i]['nomencargado']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSucursal" data-backdrop="static" data-keyboard="false" onClick="UpdateSucursal('<?php echo $reg[$i]["codsucursal"]; ?>','<?php echo $reg[$i]["nrosucursal"]; ?>','<?php echo $reg[$i]["documsucursal"]; ?>','<?php echo $reg[$i]["cuitsucursal"]; ?>','<?php echo $reg[$i]["nomsucursal"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["direcsucursal"]; ?>','<?php echo $reg[$i]["correosucursal"]; ?>','<?php echo $reg[$i]["tlfsucursal"]; ?>','<?php echo $reg[$i]["nroactividadsucursal"]; ?>','<?php echo $reg[$i]["inicioticket"]; ?>','<?php echo $reg[$i]["inicionotaventa"]; ?>','<?php echo $reg[$i]["iniciofactura"]; ?>','<?php echo $reg[$i]["fechaautorsucursal"]; ?>','<?php echo $reg[$i]["llevacontabilidad"]; ?>','<?php echo $reg[$i]["documencargado"]; ?>','<?php echo $reg[$i]["dniencargado"]; ?>','<?php echo $reg[$i]["nomencargado"]; ?>','<?php echo $reg[$i]["tlfencargado"]; ?>','<?php echo number_format($reg[$i]["descsucursal"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["codmoneda2"]; ?>','update'); SelectProvincia('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("SUCURSALES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR SUCURSALES ############################
?>






<?php
############################# CARGAR TRATAMIENTOS ############################
if (isset($_GET['CargaTratamientos'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Tratamiento</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTratamientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRATAMIENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nomtratamiento']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTratamiento('<?php echo $reg[$i]["codtratamiento"]; ?>','<?php echo $reg[$i]["nomtratamiento"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarTratamiento('<?php echo encrypt($reg[$i]["codtratamiento"]); ?>','<?php echo encrypt("TRATAMIENTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TRATAMIENTOS ############################
?>




<?php
############################# CARGAR MENSAJES ############################
if (isset($_GET['CargaMensajes'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombres</th>
                                                    <th>N° de Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Asunto</th>
                                                    <th>Mensaje</th>
                                                    <th>Recibido</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMensajes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MENSAJES DE CONTACTO ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                  <tr role="row" class="odd">
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['name']; ?></td>
                                  <td><?php echo $reg[$i]['phone'] == '' ? "*********" : $reg[$i]['phone']; ?></td>
                                  <td><?php echo $reg[$i]['email']; ?></td>
                                  <td><?php echo $reg[$i]['subject']; ?></td>
                                  <td><?php echo $reg[$i]['message']; ?></td>
                                  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]["fecha"])); ?></td>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerMensaje('<?php echo encrypt($reg[$i]["codmensaje"]); ?>')"><i class="fa fa-eye"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarMensaje('<?php echo encrypt($reg[$i]["codmensaje"]); ?>','<?php echo encrypt("MENSAJES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MENSAJES ############################
?>





<?php
############################# CARGAR MARCAS ############################
if (isset($_GET['CargaMarcas'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Marcas</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nommarca']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMarca('<?php echo $reg[$i]["codmarca"]; ?>','<?php echo $reg[$i]["nommarca"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt("MARCAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR MARCAS ############################
?>





<?php
############################# CARGAR PRESENTACIONES ############################
if (isset($_GET['CargaPresentaciones'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Presentaciones</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nompresentacion']; ?></td>
                                               <td>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdatePresentacion('<?php echo $reg[$i]["codpresentacion"]; ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo encrypt("PRESENTACIONES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PRESENTACIONES ############################
?>





<?php
############################# CARGAR MEDIDAS ############################
if (isset($_GET['CargaMedidas'])) { 
?>
<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Medida</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMedidas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $reg[$i]['codmedida']; ?></td>
                                               <td><?php echo $reg[$i]['nommedida']; ?></td>
                                               <td>
<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateMedida('<?php echo $reg[$i]["codmedida"]; ?>','<?php echo $reg[$i]["nommedida"]; ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarMedida('<?php echo encrypt($reg[$i]["codmedida"]); ?>','<?php echo encrypt("MEDIDAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR UNIDADES ############################
?>





<?php
############################# CARGAR ESPECIALISTAS ############################
if (isset($_GET['CargaEspecialistas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Tarj. Profesional</th>
                                                    <th>N° de Documento</th>
                                                    <th>Nombres y Apellidos</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Email</th>
                                                    <th>Especialidad</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>Sucursal</th><?php } ?>
<?php echo $var = ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS" ? "<th>Acciones</th>" : "<th><span class='mdi mdi-drag-horizontal'></span></th>"); ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarEspecialistas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ESPECIALISTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['tpespecialista']; ?></td>
<td><?php echo $documento = ($reg[$i]['documespecialista'] == '0' ? "" : $reg[$i]['documento'])." ".$reg[$i]['cedespecialista']; ?></td>
                                               <td><?php echo $reg[$i]['nomespecialista']; ?></td>
                                               <td><?php echo $reg[$i]['tlfespecialista']; ?></td>
                                               <td><?php echo $reg[$i]['correoespecialista']; ?></td>
                                               <td><?php echo $reg[$i]['especialidad']; ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['gruposnombres'] == '' ? "*********" : $reg[$i]['gruposnombres']; ?></strong></td><?php } ?>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerEspecialista('<?php echo encrypt($reg[$i]["codespecialista"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalEspecialista" data-backdrop="static" data-keyboard="false" onClick="UpdateEspecialista('<?php echo $reg[$i]["codespecialista"]; ?>','<?php echo $reg[$i]["tpespecialista"]; ?>','<?php echo $reg[$i]["documespecialista"]; ?>','<?php echo $reg[$i]["cedespecialista"]; ?>','<?php echo $reg[$i]["nomespecialista"]; ?>','<?php echo $reg[$i]["tlfespecialista"]; ?>','<?php echo $reg[$i]["sexoespecialista"]; ?>','<?php echo $reg[$i]["id_departamento"] == '0' ? "" : $reg[$i]['id_departamento']; ?>','<?php echo $reg[$i]["direcespecialista"]; ?>','<?php echo $reg[$i]["correoespecialista"]; ?>','<?php echo $reg[$i]["especialidad"]; ?>','<?php echo $reg[$i]["fnacespecialista"] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[$i]["fnacespecialista"])); ?>','<?php echo $reg[$i]["twitter"]; ?>','<?php echo $reg[$i]["facebook"]; ?>','<?php echo $reg[$i]["instagram"]; ?>','<?php echo $reg[$i]["google"]; ?>','update'); SelectProvincia('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>'); CargaSucursales('<?php echo $reg[$i]["codespecialista"]; ?>','<?php echo $reg[$i]["gruposid"]; ?>')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-warning btn-rounded" onClick="ReiniciarClaveEspecialista('<?php echo encrypt($reg[$i]["codespecialista"]); ?>','<?php echo encrypt($reg[$i]["cedespecialista"]); ?>','<?php echo encrypt("REINICIARESPECIALISTA") ?>')" title="Reiniciar Clave" ><i class="fa fa-key"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarEspecialista('<?php echo encrypt($reg[$i]["codespecialista"]); ?>','<?php echo encrypt($reg[$i]["cedespecialista"]); ?>','<?php echo encrypt("ESPECIALISTAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
<?php } ?> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR ESPECIALISTAS ############################
?>










<?php
############################# CARGAR PACIENTES ############################
if (isset($_GET['CargaPacientes'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Nombres</th>
                                                    <th>Apellidos</th>
                                                    <th>Grupo Sang.</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Acompañante</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPacientes();

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
                               <td><?php echo $reg[$i]['pnompaciente']." ".$reg[$i]['snompaciente']; ?></td>
                               <td><?php echo $reg[$i]['papepaciente']." ".$reg[$i]['sapepaciente']; ?></td>
                               <td><?php echo $reg[$i]['gruposapaciente']; ?></td>
                               <td><?php echo $reg[$i]['tlfpaciente'] == '' ? "***********" : $reg[$i]['tlfpaciente']; ?></td>
                               <td><?php echo $reg[$i]['nomacompana'] == '' ? "***********" : $reg[$i]['nomacompana']; ?></td>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerPaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdatePaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") { ?>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarPaciente('<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt("PACIENTES"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
<?php } ?>

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PACIENTES ############################
?>









<?php
############################# CARGAR PROVEEDORES ############################
if (isset($_GET['CargaProveedores'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombres de Proveedor</th>
                                                    <th>Correo Electrónico</th>
                                                    <th>Nº de Teléfono</th>
                                                    <th>Vendedor</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
<td><?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
           <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><i class="fa fa-eye"></i></button>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="UpdateProveedor('<?php echo $reg[$i]["codproveedor"]; ?>','<?php echo $reg[$i]["documproveedor"]; ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','update'); SelectProvincia('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>')"><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt("PROVEEDORES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR PROVEEDORES ############################
?>
















<?php
############################# CARGAR SERVICIOS ############################
if (isset($_GET['CargaServicios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Servicio</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th>Precio Moneda</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Descto</th>
                                                    <th>Status</th>
          <?php echo $var = ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><span class='mdi mdi-drag-horizontal'></span></th>"); ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarServicios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SERVICIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                              <tr role="row" class="odd">
                                              <td><?php echo $a++; ?></td>
                                              <td><?php echo $reg[$i]['servicio']; ?></td>
                                              <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.$reg[$i]['preciocompra'] : "**********"); ?></td>
              <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
              <td><?php echo $reg[$i]['moneda2'] == '' ? "*****" : "<strong>".$reg[$i]['simbolo2']."</strong> ".$moneda; ?></td>
              <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                                              <td><?php echo $reg[$i]['descservicio']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerServicio('<?php echo encrypt($reg[$i]["codservicio"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") { ?>
<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalServicio" data-backdrop="static" data-keyboard="false" onClick="UpdateServicio('<?php echo $reg[$i]["codservicio"]; ?>','<?php echo $reg[$i]["servicio"]; ?>','<?php echo number_format($reg[$i]["preciocompra"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["precioventa"], 2, '.', ''); ?>','<?php echo $reg[$i]["ivaservicio"]; ?>','<?php echo number_format($reg[$i]["descservicio"], 2, '.', ''); ?>','<?php echo $reg[$i]["status"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarServicio('<?php echo encrypt($reg[$i]["codservicio"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("SERVICIOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
<?php } ?> 

</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR SERVICIOS ############################
?>







<?php
############################# CARGAR KARDEX SERVICIOS VALORIZADO ############################
if (isset($_GET['CargaKardexServiciosValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Servicio</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Descto</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarKardexServiciosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON KARDEX DE SERVICIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$precioTotal=0;
$pagoTotal=0;
$compraTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$precioTotal+=$reg[$i]['precioventa'];
$pagoTotal+=$reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descservicio']/100;
$compraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$sumventa = $reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descservicio']/100; 
$sumcompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];

$TotalGanancia+=$sumventa-$sumcompra;
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                              <td><?php echo $reg[$i]['codservicio']; ?></td>
                                              <td><?php echo $reg[$i]['servicio']; ?></td>
              <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.$reg[$i]['preciocompra'] : "**********"); ?></td>
              <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
              <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
              <td><?php echo $reg[$i]['descproducto']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['existencia']-$reg[$i]['descproducto']/100, 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($sumventa-$sumcompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX SERVICIOS VALORIZADO ############################
?>






<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Presentación</th>
                                                    <th>Medida</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th>Precio Moneda</th>
                                                    <th>Stock</th>
                                                    <th>Lote</th>
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Descto</th>
                                                    <th>Elab.</th>
                                                    <th>Exp.</th>
        <?php echo $var = ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><span class='mdi mdi-drag-horizontal'></span></th>"); ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
?>
                            <tr role="row" class="odd">
                            <td><?php echo $a++; ?></td>
              <td><?php echo $reg[$i]['codproducto']; ?></td>
              <td><?php echo $reg[$i]['producto']; ?></td>
              <td><?php echo $reg[$i]['nommarca']; ?></td>
              <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
              <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
              <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
              <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
              <td><?php echo $reg[$i]['moneda2'] == '' ? "*****" : "<strong>".$reg[$i]['simbolo2']."</strong> ".$moneda; ?></td>
                      
              <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<span class='badge badge-pill badge-danger2'>".$reg[$i]['existencia']."</span>" : "<span class='badge badge-pill badge-info'>".$reg[$i]['existencia']."</span>"; ?></td>
              
              <td><?php echo $reg[$i]['lote'] == '0' ? "******" : $reg[$i]['lote']; ?></td>
              
              <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
              <td><?php echo $reg[$i]['descproducto']; ?></td>

              <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "********" : "<span class='badge badge-pill badge-dark'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>
              
              <td><?php 
              if($reg[$i]['fechaexpiracion'] == '' || $reg[$i]['fechaexpiracion'] == '0000-00-00'){ 
                echo "********"; 
              } elseif($reg[$i]['fechaexpiracion'] != "0000-00-00" && date("Y-m-d") >= $reg[$i]['fechaexpiracion']){ 
                echo "<span class='badge badge-pill badge-purple'>".date("d-m-Y",strtotime($reg[$i]['fechaexpiracion']))."</span>"; 
              } else { 
                echo "<span class='badge badge-pill badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaexpiracion']))."</span>"; 
              } ?></td>

                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") { ?>
<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PRODUCTOS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
<?php } ?>

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
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
if (isset($_GET['CargaKardexProductosValorizado'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Presentación</th>
                                                    <th>Medida</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th>Existencia</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc</th>
                                                    <th>Total Venta</th>
                                                    <th>Total Compra</th>
                                                    <th>Ganancias</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarKardexProductosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON KARDEX DE PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$simbolo="";
$a=1;
for($i=0;$i<sizeof($reg);$i++){

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia']; 

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['existencia'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$VentaTotal+=$PrecioFinal*$reg[$i]['existencia'];

$SumVenta = $PrecioFinal*$reg[$i]['existencia']; 
$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['existencia'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$TotalGanancia+=$SumVenta-$SumCompra; 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['codproducto']; ?></td>
                                               <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                    <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
                    <td><?php echo $reg[$i]['existencia']; ?></td>
                    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                    <td><?php echo $reg[$i]['descproducto']; ?></td>
                    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
?>













<?php
############################# CARGAR TRASPASOS ############################
if (isset($_GET['CargaTraspasos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Sucursal Envia</th>
                                                    <th>Sucursal Recibe</th>
                                                    <th>Nº Artículos</th>
                                                    <th>Observaciones</th>
                                                    <th>Fecha de Traspaso</th>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr role="row" class="odd">
                                <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codtraspaso']; ?></td>
                    <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>: ".$reg[$i]['nomencargado']; ?></td>
                    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>: ".$reg[$i]['nomencargado2']; ?></td>
                    <td><?php echo $reg[$i]['sumarticulos']; ?></td>
                    <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechatraspaso'])); ?></td>
                                               <td>                    
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso'] == "administradorS"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["recibe"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("TRASPASOS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                               </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR TRASPASOS ############################
?>










<?php
############################# CARGAR COMPRAS ############################
if (isset($_GET['CargaCompras'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº de Artic</th>
                                                    <th>SubTotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc.</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCompras();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>

      <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>

      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>

      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPagada('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("P"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "P"; ?>','<?php echo encrypt("COMPRAS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
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
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Compra</th>
                                                    <th>Descripción de Proveedor</th>
                                                    <th>Nº de Artic</th>
                                                    <th>Imp. Total</th>
                                                    <th>Abonado</th>
                                                    <th>Debe</th>
                                                    <th>Status</th>
                                                    <th>Dias Venc.</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCuentasxPagar();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CUENTAS POR PAGAR A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>

  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCompraPendiente('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo "D"; ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-danger btn-rounded" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosCompra" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoCompra('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
'<?php echo $reg[$i]["nomproveedor"]; ?>',
'<?php echo $reg[$i]["codcompra"]; ?>',
'<?php echo number_format($reg[$i]["totalpagoc"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?>',
'<?php echo number_format($total = ( $reg[$i]['creditopagado'] == '' ? "0.00" : $reg[$i]['creditopagado']), 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-refresh"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "D" ?>','<?php echo encrypt("COMPRAS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-warning btn-rounded" title="Imprimir Abonos"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
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
############################# CARGAR COTIZACIONES ############################
if (isset($_GET['CargaCotizaciones'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Cotización</th>
                                                    <th>Descripción de Especialista</th>
                                                    <th>Descripción de Paciente</th>
                                                    <th>SubTotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc.</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso'] == "paciente"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCotizaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES A PACIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                               <tr role="row" class="odd">
                                                 <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcotizacion']; ?></td>
                    <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
                    <td><?php echo $documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedpaciente']." ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacotizacion'])); ?></td>
                    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso'] == "paciente"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>                    
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero"){ ?>

  <button type="button" class="btn btn-outline-warning btn-rounded" data-placement="left" title="Procesar a Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="ProcesaCotizacion(
  '<?php echo encrypt($reg[$i]["codcotizacion"]); ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo $reg[$i]["codpaciente"]; ?>',
  '<?php echo $reg[$i]['codpaciente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'])." ".$reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?>',
  '<?php echo $reg[$i]["totalpago"]; ?>'); CargarDatosCajero();"><i class="fa fa-folder-open-o"></i></button>

<?php } ?>

<?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("COTIZACIONES"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

<?php } ?> 

<a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                               </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR COTIZACIONES ############################
?>











<?php
############################# CARGAR CITAS ############################
if (isset($_GET['CargaCitas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
<?php if ($_SESSION['acceso'] != "especialista") { ?><th>Nombre de Especialista</th><?php } ?>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Descripción</th>
                                                    <th>Fecha Cita</th>
                                                    <th>Hora Cita</th>
                                                    <th>Status</th>
                                                    <th>Registrado</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCitas();

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
<?php if ($_SESSION['acceso'] != "especialista") { ?><td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td><?php } ?>
                                <td><?php echo $documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'])." ".$reg[$i]['cedpaciente'].": ".$reg[$i]['pacientes']; ?></td>
                                <td><?php echo $reg[$i]['descripcion']; ?></td>
                                <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                                <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
<td><?php 
if($reg[$i]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statuscita']."</span>"; } 
elseif($reg[$i]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statuscita']."</span>"; } ?></td>
                                <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCita('<?php echo encrypt($reg[$i]["codcita"]); ?>')"><i class="fa fa-eye"></i></button>


<?php if ($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista") { ?><button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCitaGeneral('<?php echo encrypt($reg[$i]["codcita"]); ?>','<?php echo encrypt("CITAS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button><?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CITAS ############################
?>








<?php
############################# CARGAR CAJAS ############################
if (isset($_GET['CargaCajas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Caja</th>
                                                    <th>Nombre de Caja</th>
                                                    <th>Nº Documento</th>
                                                    <th>Responsable</th>
                                                    <th>Nivel</th>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['nrocaja']; ?></td>
                                               <td><?php echo $reg[$i]['nomcaja']; ?></td>
                                               <td><?php echo $reg[$i]['dni']; ?></td>
                                               <td><?php echo $reg[$i]['nombres']; ?></td>
                                               <td><?php echo $reg[$i]['nivel']; ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>

<?php if ($_SESSION["acceso"]=="administradorG") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codigo"]; ?>','update'); CargaUsuarios('<?php echo encrypt($reg[$i]["codsucursal"]); ?>'); SelectUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>');"><i class="fa fa-edit"></i></button>

<?php } else { ?>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo $reg[$i]["codcaja"]; ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codigo"]; ?>','update')"><i class="fa fa-edit"></i></button>

<?php } ?>
                                 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo encrypt("CAJAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

       
<?php 
} 
############################# CARGAR CAJAS ############################
?>










<?php
########################## CARGAR ARQUEOS DE CAJAS ##########################
if (isset($_GET['CargaArqueos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                <thead>
                                                <tr role="row">
                                                <th>N°</th>
                                                <th>Caja</th>
                                                <th>Responsable</th>
                                                <th>Hora de Apertura</th>
                                                <th>Hora de Cierre</th>
                                                <th>Monto Inicial</th>
                                                <th>Total en Ventas</th>
                                                <th>Efectivo en Caja</th>
                                                <th>Diferencia en Caja</th>
<?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
                                                <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarArqueos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";  
?>
                              <tr role="row" class="odd">
                            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
            <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
            <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
            <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
  <?php if($_SESSION['acceso']=="administradorG"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "cajero"){ ?>

  <?php if($reg[$i]["statusarqueo"] == 1){ ?>

<button type="button" class="btn btn-outline-dark btn-rounded" data-placement="left" title="Cerrar Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCierre" data-backdrop="static" data-keyboard="false" onClick="CerrarArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>',
  '<?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?>',
  '<?php echo $reg[$i]["dni"].": ".$reg[$i]["nombres"]; ?>',
  '<?php echo number_format($reg[$i]["montoinicial"], 2, '.', ''); ?>',
  '<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?>',
  '<?php echo number_format($reg[$i]["efectivo"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["cheque"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["tcredito"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["tdebito"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["tprepago"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["transferencia"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["electronico"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["cupon"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["otros"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["creditos"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["abonosefectivo"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["abonosotros"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["ingresosefectivo"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["ingresosotros"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["egresos"], 2, '.', ''); ?>',
  '<?php echo number_format($reg[$i]["montoinicial"] + $reg[$i]["efectivo"] + $reg[$i]["abonosefectivo"] + $reg[$i]["ingresosefectivo"] - $reg[$i]["egresos"], 2, '.', ''); ?>')"><i class="fa fa-archive"></i></button>

<?php } } ?>

<?php if($reg[$i]["statusarqueo"] != 1){ ?>  

<a href="reportepdf?codarqueo=<?php echo encrypt($reg[$i]['codarqueo']); ?>&tipo=<?php echo encrypt("TICKETCIERRE"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<?php } ?></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>

 <?php
   } 
######################### CARGAR ARQUEOS DE CAJAS #########################
?>











<?php
######################## CARGAR MOVIMIENTOS EN CAJAS #######################
if (isset($_GET['CargaMovimientos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                                                 <thead>
                                                 <tr role="row">
                                                  <th>N°</th>
                                                  <th>Caja</th>
                                                  <th>Responsable</th>
                                                  <th>Tipo</th>
                                                  <th>Descripción</th>
                                                  <th>Monto</th>
                                                  <th>Método</th>
                                                  <th>Fecha</th>
<?php if($_SESSION['acceso']=="administradorG"){ ?><th>Sucursal</th><?php } ?>
        <?php echo $var = ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" ? "<th>Acciones</th>" : "<th><span class='mdi mdi-drag-horizontal'></span></th>"); ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
                                  <td><?php echo $reg[$i]['nombres']; ?></td>
                                  <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
                                  <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
                                  <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
                                  <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
                                  <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
<?php if($_SESSION['acceso']=="administradorG"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if ($_SESSION["acceso"]=="administradorS" && $reg[$i]['statusarqueo']=="1") { ?>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMovimiento" data-backdrop="static" data-keyboard="false" onClick="UpdateMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["tipomovimiento"]; ?>','<?php echo $reg[$i]["descripcionmovimiento"]; ?>','<?php echo $reg[$i]["montomovimiento"]; ?>','<?php echo $reg[$i]["mediomovimiento"]; ?>','<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?>','<?php echo encrypt($reg[$i]["codarqueo"]); ?>','update')"><i class="fa fa-edit"></i></button>
 
<?php } ?> 

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt("MOVIMIENTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>



</td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
######################## CARGAR MOVIMIENTOS EN CAJAS #######################
?>













<?php
############################# CARGAR ODONTOLOGIA ############################
if (isset($_GET['CargaOdontologias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Observaciones</th>
                                                    <th>Pronóstico</th>
                                                    <th>Tratamiento</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarOdontologia();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRATAMIENTOS ODONTOLOGICOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
                                               <tr role="row" class="odd">
                                <td><?php echo $a++; ?></td>
                                <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td>
                                <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                                <td><?php echo $reg[$i]['observacionexamendental'] == "" ? "**********" : $reg[$i]['observacionexamendental']; ?></td>
                                <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
                                <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
                                <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                                <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerOdontologia('<?php echo encrypt($reg[$i]["cododontologia"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateOdontologia('<?php echo encrypt($reg[$i]["codcita"]); ?>','<?php echo encrypt($reg[$i]["cododontologia"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

<!--<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarOdontologia('<?php echo encrypt($reg[$i]["codcita"]); ?>','<?php echo encrypt($reg[$i]["cododontologia"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("ODONTOLOGIA"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>-->

<?php } ?>

<a href="reportepdf?cododontologia=<?php echo encrypt($reg[$i]['cododontologia']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHAODONTOLOGICA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

</td>
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

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Nombre de Especialista</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Nombre de Testigo</th>
                                                    <th>Fecha</th>
                                                    <th>Hora</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Sucursal</th><?php } ?>
                                                    
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><th>Ver</th><?php } else { ?><th>Acciones</th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarConsentimientos();

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
              <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td>
              <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td> 
              <td><?php echo $reg[$i]['doctestigo'] == "" ? "**********" : $reg[$i]['doctestigo'].": ".$reg[$i]['nombretestigo']; ?></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaconsentimiento'])); ?></td>
              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaconsentimiento'])); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="paciente") { ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>
<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista"){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateConsentimiento('<?php echo encrypt($reg[$i]["codconsentimiento"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>
 
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarConsentimiento('<?php echo encrypt($reg[$i]["codconsentimiento"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("CONSENTIMIENTO"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

<?php } ?>

<a href="reportepdf?codconsentimiento=<?php echo encrypt($reg[$i]['codconsentimiento']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHACONSENTIMIENTO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CONSENTIMIENTOS ############################
?>











<?php
############################# CARGAR PENDIENTES ############################
if (isset($_GET['CargaVentasPendientes'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Descripción de Especialista</th>
                                                    <th>Descripción de Paciente</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Detalles</th>
          <?php if ($_SESSION['acceso'] != "especialista") { ?><th><span class="mdi mdi-drag-horizontal"></span></th><?php } ?>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarVentasPendientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FACTURAS PENDIENTES DE PACIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                               <tr role="row" class="odd">
                                                 <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
                    <td><?php echo $documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedpaciente']." ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
                    <td class="font-10 bold"><?php echo $reg[$i]['detalles']; ?></td>

                    <?php if ($_SESSION['acceso'] != "especialista") { ?><td>                    

<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false" onClick="CobrarVenta('<?php echo encrypt($reg[$i]["idventa"]); ?>',
  '<?php echo encrypt($reg[$i]["codventa"]); ?>',
  '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
  '<?php echo $reg[$i]["totalpago"]; ?>',
  '<?php echo encrypt($reg[$i]["codpaciente"]); ?>',
  '<?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']; ?>',
  '<?php echo $reg[$i]['codpaciente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?>',
  '<?php echo $reg[$i]["observaciones"]; ?>'); CargarDatosCajero();"><i class="mdi mdi-calculator"></i></button>

</td><?php } ?>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR FACTURACIONES PENDIENTES ############################
?>









<?php
############################# CARGAR FACTURACIONES ############################
if (isset($_GET['CargaVentas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Caja</th>
                                                    <th>N° de Factura</th>
                                                    <th>Descripción de Especialista</th>
                                                    <th>Descripción de Paciente</th>
                                                    <th>SubTotal</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc.</th>
                                                    <th>Imp. Total</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Status</th>
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION["acceso"]=="paciente"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarVentas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FACTURACIONES A PACIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                               <tr role="row" class="odd">
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
                    <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
                    <td><?php echo $documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedpaciente']." ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
                    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
      <?php if($_SESSION['acceso']=="administradorG" || $_SESSION["acceso"]=="paciente"){ ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
                                               <td>                    
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

<?php if($reg[$i]['statusventa']!='PAGADA'){ ?>
<button type="button" class="btn btn-outline-info btn-rounded" onClick="UpdateVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>
<?php } ?>

<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("VENTAS"); ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button> 

<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                               </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR FACTURACIONES ############################
?>




















<?php
############################# CARGAR CREDITOS ############################
if (isset($_GET['CargaCreditos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>N° de Factura</th>
                                                    <th>Nº de Documento</th>
                                                    <th>Nombre de Paciente</th>
                                                    <th>Imp. Total</th>
                                                    <th>Abono</th>
                                                    <th>Debe</th>
                                                    <th>Status</th>
                                                    <th>Dias Venc</th>
                                                    <th>Fecha Emisión</th>
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION["acceso"]=="paciente"){ ?><th>Sucursal</th><?php } ?>
                                                    <th>Acciones</th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS DE VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]["codfactura"]; ?></td>
  <td><?php echo "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedpaciente']; ?></td>
  <td><?php echo $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  
  <?php if ($_SESSION["acceso"]=="administradorG" || $_SESSION["acceso"]=="paciente") { ?><td><strong><?php echo $reg[$i]['nomsucursal']; ?></strong></td><?php }  ?>
                         <td>
<button type="button" class="btn btn-outline-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

<?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="cajero" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado']){ ?>

<button type="button" class="btn btn-outline-info btn-rounded" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false" 
onClick="AbonoCredito('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>',
'<?php echo encrypt($reg[$i]["codventa"]); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cedpaciente"]; ?>',
'<?php echo $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?>',
'<?php echo $reg[$i]["codfactura"]; ?>',
'<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
'<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
'<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>',
'<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

<?php } ?>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-warning btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
                                              </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table></div>
 <?php
   } 
############################# CARGAR CREDITOS ############################
?>


<!-- Datatables-->
  <script src="assets/plugins/datatables/dataTables.min.js"></script>
  <script src="assets/plugins/datatables/datatable-basic.init.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
      $('#default_order').dataTable();
    } );
  </script>


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