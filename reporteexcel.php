<?php
require_once("class/class.php");
    if (isset($_SESSION['acceso'])) {
       if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista" || $_SESSION["acceso"]=="paciente") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "IMPUESTO" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();

$tipo = decrypt($_GET['tipo']);
$documento = decrypt($_GET['documento']);
$extension = $documento == 'EXCEL' ? '.xls' : '.doc';

switch($tipo)
  {
################################## MODULO DE USUARIOS ##################################

case 'USUARIOS': 

$tra = new Login();
$reg = $tra->ListarUsuarios();

$archivo = str_replace(" ", "_","LISTADO DE USUARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>SEXO</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>Nº DE TELEFÓNO</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>USUARIO</th>
           <th>NIVEL</th>
           <th>STATUS</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['sexo']; ?></td>
           <td><?php echo $reg[$i]['direccion']; ?></td>
           <td><?php echo $reg[$i]['telefono']; ?></td>
           <td><?php echo $reg[$i]['email']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['usuario']; ?></td>
           <td><?php echo $reg[$i]['nivel']; ?></td>
           <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nivel'] == 'ADMINISTRADOR(A) GENERAL' ? "*********" : $reg[$i]['gruposnombres']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'HORARIOSUSUARIOS': 

$tra = new Login();
$reg = $tra->ListarHorariosUsuarios();

$archivo = str_replace(" ", "_","LISTADO DE HORARIOS DE USUARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
           <th>Nº DE TELEFÓNO</th>
           <th>NIVEL</th>
           <th>HORA DESDE</th>
           <th>HORA HASTA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['dni']; ?></td>
           <td><?php echo $reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['telefono']; ?></td>
           <td><?php echo $reg[$i]['nivel']; ?></td>
           <td><?php echo $reg[$i]['hora_desde']; ?></td>
           <td><?php echo $reg[$i]['hora_hasta']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'HORARIOSESPECIALISTAS': 

$tra = new Login();
$reg = $tra->ListarHorariosEspecialistas();

$archivo = str_replace(" ", "_","LISTADO DE HORARIOS DE ESPECIALISTAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRES Y APELLIDOS</th>
           <th>Nº DE TELEFÓNO</th>
           <th>ESPECIALIDAD</th>
           <th>HORA DESDE</th>
           <th>HORA HASTA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['cedespecialista']; ?></td>
           <td><?php echo $reg[$i]['nomespecialista']; ?></td>
           <td><?php echo $reg[$i]['tlfespecialista']; ?></td>
           <td><?php echo $reg[$i]['especialidad']; ?></td>
           <td><?php echo $reg[$i]['hora_desde']; ?></td>
           <td><?php echo $reg[$i]['hora_hasta']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'LOGS': 

$archivo = str_replace(" ", "_","LISTADO LOGS DE ACCESO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>IP EQUIPO</th>
           <th>TIEMPO DE ENTRADA</th>
           <th>NAVEGADOR DE ACCESO</th>
           <th>PÁGINAS DE ACCESO</th>
           <th>USUARIOS</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarLogs();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['ip']; ?></td>
           <td><?php echo $reg[$i]['tiempo']; ?></td>
           <td><?php echo $reg[$i]['detalles']; ?></td>
           <td><?php echo $reg[$i]['paginas']; ?></td>
           <td><?php echo $reg[$i]['usuario']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

################################ MODULO DE USUARIOS ##############################


############################### MODULO DE CONFIGURACIONES ###############################



case 'DEPARTAMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DEPARTAMENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE DEPARTAMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDepartamentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['departamento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'PROVINCIAS': 

$archivo = str_replace(" ", "_","LISTADO DE PROVINCIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PROVINCIA</th>
           <th>NOMBRE DE DEPARTAMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProvincias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['departamento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DOCUMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DOCUMENTOS TRIBUTARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE DOCUMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDocumentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOMONEDA': 

$archivo = str_replace(" ", "_","LISTADO DE TIPOS DE MONEDA");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MONEDA</th>
           <th>SIGLAS</th>
           <th>SIMBOLO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoMoneda();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['moneda']; ?></td>
           <td><?php echo $reg[$i]['siglas']; ?></td>
           <td><?php echo $reg[$i]['simbolo']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOCAMBIO': 

$archivo = str_replace(" ", "_","LISTADO DE TIPO DE CAMBIO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>DESCRIPCIÓN DE CAMBIO</th>
           <th>MONTO DE CAMBIO</th>
           <th>TIPO DE MONEDA</th>
           <th>FECHA DE INGRESO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoCambio();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
           <td><?php echo $reg[$i]['montocambio']; ?></td>
           <td><?php echo $reg[$i]['moneda']."/".$reg[$i]['siglas']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'IMPUESTOS': 

$archivo = str_replace(" ", "_","LISTADO DE IMPUESTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE IMPUESTO</th>
           <th>VALOR(%)</th>
           <th>STATUS</th>
           <th>REGISTRO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarImpuestos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
           <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
           <td><?php echo $reg[$i]['statusimpuesto']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MARCAS': 

$archivo = str_replace(" ", "_","LISTADO DE MARCAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MARCA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMarcas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;



case 'PRESENTACIONES': 

$archivo = str_replace(" ", "_","LISTADO DE PRESENTACIONES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PRESENTACIÓN</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarPresentaciones();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nompresentacion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;


case 'MEDIDAS': 

$archivo = str_replace(" ", "_","LISTADO DE MEDIDAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE UNIDAD MEDIDA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMedidas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nommedida']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'MENSAJES': 

$archivo = str_replace(" ", "_","LISTADO MENSAJES DE CONTACTO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRES Y APELLIDOS</th>
           <th>Nº DE TELEFONO</th>
           <th>EMAIL</th>
           <th>ASUNTO</th>
           <th>MENSAJE</th>
           <th>FECHA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarMensajes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['name']; ?></td>
           <td><?php echo $reg[$i]['phone'] == '' ? "*********" : $reg[$i]['phone']; ?></td>
           <td><?php echo $reg[$i]['email']; ?></td>
           <td><?php echo $reg[$i]['subject']; ?></td>
           <td><?php echo $reg[$i]['message']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]["fecha"])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'SUCURSALES': 

$archivo = str_replace(" ", "_","LISTADO DE SUCURSALES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE SUCURSAL</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRE DE SUCURSAL</th>
<?php if ($documento == "EXCEL") { ?>
           <th>DEPARTAMENTO</th>
           <th>PROVINCIA</th>
           <th>DIRECCIÓN</th>
<?php } ?>
           <th>CORREO ELECTRONICO</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>Nº DE ACTIVIDAD</th>
           <th>Nº DE TICKET</th>
           <th>Nº NOTA DE VENTA</th>
           <th>Nº FACTURA</th>
           <th>FECHA DE AUTORIZACIÓN</th>
           <th>LLEVA CONTABILIDAD</th>
           <th>DESCUENTO GLOBAL</th>
           <th>MONEDA NACIONAL</th>
           <th>MONEDA CAMBIO</th>
           <th>Nº DOC. ENCARGADO</th>
<?php } ?>
           <th>NOMBRE DE ENCARGADO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>Nº DE TELÉFONO ENCARGADO</th>
<?php } ?>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarSucursales();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrosucursal']; ?></td>
           <td><?php echo $reg[$i]['documento'].": ".$reg[$i]['cuitsucursal']; ?></td>
           <td><?php echo $reg[$i]['nomsucursal']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['direcsucursal']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['correosucursal']; ?></td>
          <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['nroactividadsucursal']; ?></td>
           <td><?php echo $reg[$i]['inicioticket']; ?></td>
           <td><?php echo $reg[$i]['inicionotaventa']; ?></td>
           <td><?php echo $reg[$i]['iniciofactura']; ?></td>
<td><?php echo $reg[$i]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaautorsucursal'])); ?></td>
           <td><?php echo $reg[$i]['descsucursal']; ?></td>
           <td><?php echo $reg[$i]['llevacontabilidad']; ?></td>
           <td><?php echo $reg[$i]['codmoneda'] == '0' ? "*********" : $reg[$i]['moneda']; ?></td>
           <td><?php echo $reg[$i]['codmoneda2'] == '0' ? "*********" : $reg[$i]['moneda2']; ?></td>
           <td><?php echo $reg[$i]['documento2'].": ".$reg[$i]['dniencargado']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['nomencargado']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['tlfencargado'] == '' ? "*********" : $reg[$i]['tlfencargado']; ?></td>
<?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TRATAMIENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE TRATAMIENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE TRATAMIENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTratamientos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nomtratamiento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CONFIGURACIONES ##############################

























############################### MODULO DE MANTENIMIENTO ###################################
case 'ESPECIALISTAS': 

$archivo = str_replace(" ", "_","LISTADO DE ESPECIALISTAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TARJETA PROFESIONAL</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>Nº DE TELÉFONO</th>
           <th>SEXO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>DEPARTAMENTO</th>
           <th>PROVINCIA</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>ESPECIALIDAD</th>
           <th>FECHA DE NACIMIENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarEspecialistas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['tpespecialista']; ?></td>
           <td><?php echo $reg[$i]['documespecialista'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['cedespecialista']; ?></td>
           <td><?php echo $reg[$i]['nomespecialista']; ?></td>
           <td><?php echo $reg[$i]['tlfespecialista'] == '' ? "*********" : $reg[$i]['tlfespecialista']; ?></td>
           <td><?php echo $reg[$i]['sexoespecialista']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['direcespecialista'] == '' ? "*********" : $reg[$i]['direcespecialista']; ?></td>
           <td><?php echo $reg[$i]['correoespecialista'] == '' ? "*********" : $reg[$i]['correoespecialista']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['especialidad']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fnacespecialista'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;


case 'ESPECIALISTASCSV': 

$archivo = str_replace(" ", "_","LISTADO DE ESPECIALISTAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 
$tra = new Login();
$reg = $tra->ListarEspecialistas();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['codespecialista']; ?></td>
           <td><?php echo $reg[$i]['tpespecialista']; ?></td>
           <td><?php echo $reg[$i]['documespecialista']; ?></td>
           <td><?php echo $reg[$i]['cedespecialista']; ?></td>
           <td><?php echo $reg[$i]['nomespecialista']; ?></td>
           <td><?php echo $reg[$i]['tlfespecialista']; ?></td>
           <td><?php echo $reg[$i]['sexoespecialista']; ?></td>
           <td><?php echo $reg[$i]['id_departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['direcespecialista']; ?></td>
           <td><?php echo $reg[$i]['correoespecialista']; ?></td>
           <td><?php echo $reg[$i]['especialidad']; ?></td>
           <td><?php echo $reg[$i]['fnacespecialista']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;


case 'PACIENTES': 

$archivo = str_replace(" ", "_","LISTADO DE PACIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>PRIMER NOMBRE</th>
           <th>SEGUNDO NOMBRE</th>
           <th>PRIMER APELLIDO</th>
           <th>SEGUNDO APELLIDO</th>
           <th>FECHA DE NACIMIENTO</th>
           <th>Nº DE TELÉFONO</th>
           <th>GRUPO SANGUINEO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>ESTADO LABORAL</th>
           <th>OCUPACIÓN LABORAL</th>
           <th>SEXO</th>
           <th>ENFOQUE DIFERENCIAL</th>
           <th>DEPARTAMENTO</th>
           <th>PROVINCIA</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>NOMBRE DE ACOMPAÑANTE</th>
           <th>DIRECCIÓN DE ACOMPAÑANTE</th>
           <th>TELEFONO DE ACOMPAÑANTE</th>
           <th>PARENTESCO DE ACOMPAÑANTE</th>
           <th>NOMBRE DE RESPONSABLE</th>
           <th>DIRECCIÓN DE RESPONSABLE</th>
           <th>TELEFONO DE RESPONSABLE</th>
           <th>PARENTESCO DE RESPONSABLE</th>
<?php } ?>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarPacientes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documpaciente'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['cedpaciente']; ?></td>
           <td><?php echo $reg[$i]['pnompaciente']; ?></td>
           <td><?php echo $reg[$i]['snompaciente'] == '' ? "*********" : $reg[$i]['snompaciente']; ?></td>
           <td><?php echo $reg[$i]['papepaciente']; ?></td>
           <td><?php echo $reg[$i]['sapepaciente'] == '' ? "*********" : $reg[$i]['sapepaciente']; ?></td>
           <td><?php echo $reg[$i]['fnacpaciente'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fnacpaciente'])); ?></td>
           <td><?php echo $reg[$i]['tlfpaciente'] == '' ? "*********" : $reg[$i]['tlfpaciente']; ?></td>
           <td><?php echo $reg[$i]['gruposapaciente']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['estadopaciente']; ?></td>
           <td><?php echo $reg[$i]['ocupacionpaciente']; ?></td>
           <td><?php echo $reg[$i]['sexopaciente']; ?></td>
           <td><?php echo $reg[$i]['enfoquepaciente']; ?></td>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['direcpaciente'] == '' ? "*********" : $reg[$i]['direcpaciente']; ?></td>
           <td><?php echo $reg[$i]['nomacompana'] == '' ? "*********" : $reg[$i]['nomacompana']; ?></td>
           <td><?php echo $reg[$i]['direcacompana'] == '' ? "*********" : $reg[$i]['direcacompana']; ?></td>
           <td><?php echo $reg[$i]['tlfacompana'] == '' ? "*********" : $reg[$i]['tlfacompana']; ?></td>
           <td><?php echo $reg[$i]['parentescoacompana'] == '' ? "*********" : $reg[$i]['parentescoacompana']; ?></td>
           <td><?php echo $reg[$i]['nomresponsable'] == '' ? "*********" : $reg[$i]['nomresponsable']; ?></td>
           <td><?php echo $reg[$i]['direcresponsable'] == '' ? "*********" : $reg[$i]['direcresponsable']; ?></td>
           <td><?php echo $reg[$i]['tlfresponsable'] == '' ? "*********" : $reg[$i]['tlfresponsable']; ?></td>
           <td><?php echo $reg[$i]['parentescoresponsable'] == '' ? "*********" : $reg[$i]['parentescoresponsable']; ?></td>
<?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;


case 'PACIENTESCSV': 

$archivo = str_replace(" ", "_","LISTADO DE PACIENTES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 
$tra = new Login();
$reg = $tra->ListarPacientes();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['documpaciente']; ?></td>
           <td><?php echo $reg[$i]['cedpaciente']; ?></td>
           <td><?php echo $reg[$i]['pnompaciente']; ?></td>
           <td><?php echo $reg[$i]['snompaciente']; ?></td>
           <td><?php echo $reg[$i]['papepaciente']; ?></td>
           <td><?php echo $reg[$i]['sapepaciente']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fnacpaciente'])); ?></td>
           <td><?php echo $reg[$i]['tlfpaciente']; ?></td>
           <td><?php echo $reg[$i]['gruposapaciente']; ?></td>
           <td><?php echo $reg[$i]['estadopaciente']; ?></td>
           <td><?php echo $reg[$i]['ocupacionpaciente']; ?></td>
           <td><?php echo $reg[$i]['sexopaciente']; ?></td>
           <td><?php echo $reg[$i]['enfoquepaciente']; ?></td>
           <td><?php echo $reg[$i]['id_departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['direcpaciente']; ?></td>
           <td><?php echo $reg[$i]['nomacompana']; ?></td>
           <td><?php echo $reg[$i]['direcacompana']; ?></td>
           <td><?php echo $reg[$i]['tlfacompana']; ?></td>
           <td><?php echo $reg[$i]['parentescoacompana']; ?></td>
           <td><?php echo $reg[$i]['nomresponsable']; ?></td>
           <td><?php echo $reg[$i]['direcresponsable']; ?></td>
           <td><?php echo $reg[$i]['tlfresponsable']; ?></td>
           <td><?php echo $reg[$i]['parentescoresponsable']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;



case 'PROVEDORES': 

$archivo = str_replace(" ", "_","LISTADO DE PROVEDORES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>TIPO DE DOCUMENTO</th>
           <th>Nº DE DOCUMENTO</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <th>Nº DE TELÉFONO</th>
<?php if ($documento == "EXCEL") { ?>
           <th>DEPARTAMENTO</th>
           <th>PROVINCIA</th>
           <th>DIRECCIÓN DOMICILIARIA</th>
           <th>CORREO ELECTRONICO</th>
<?php } ?>
           <th>VENDEDOR</th>
           <th>FECHA INGRESO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProveedores();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documproveedor'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor']; ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
           <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
           <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['direcproveedor'] == '' ? "*********" : $reg[$i]['direcproveedor']; ?></td>
           <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['vendedor']; ?></td>
           <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaingreso'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

################################# MODULO DE MANTENIMIENTO ################################
























################################# MODULO DE SERVICIOS ################################
case 'SERVICIOS':

$tra = new Login();
$reg = $tra->ListarServicios(); 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS DE (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE SERVICIO</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>PRECIO MONEDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>STATUS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> "; 
$simbolo2 = ($cambio == "" ? "" : "<strong>".$cambio[0]['simbolo']."</strong> "); 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
          <td><?php echo $reg[$i]['moneda2'] == '' ? "*****" : "<strong>".$reg[$i]['simbolo2']."</strong> ".$moneda; ?></td>
          <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descservicio']; ?></td>
          <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'SERVICIOSCSV': 

$tra = new Login();
$reg = $tra->ListarServicios();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS DE (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $reg[$i]['precioventa']; ?></td>
          <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descservicio']; ?></td>
          <td><?php echo $reg[$i]['status']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'SERVICIOSVENDIDOS':

$tra = new Login();
$reg = $tra->BuscarServiciosVendidos();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE SERVICIO</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>PRECIO VENTA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$PrecioTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal+=$reg[$i]['precioventa'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $VendidosTotal; ?></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'SERVICIOSXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarServiciosxVendedor();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS VENDIDOS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE SERVICIO</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>PRECIO VENTA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$PrecioTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal+=$reg[$i]['precioventa'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $VendidosTotal; ?></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'SERVICIOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();

$tra = new Login();
$reg = $tra->ListarServicios();

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE SERVICIO</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>STATUS</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>PRECIO <?php echo $cambio[0]['siglas']; ?></th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0; 
for($i=0;$i<sizeof($reg);$i++){
$TotalCompra+=$reg[$i]['preciocompra'];

$Descuento = $reg[$i]['descservicio']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$TotalVenta+=$reg[$i]['precioventa'];
$TotalMoneda+=(empty($reg[$i]['montocambio']) ? "0.00" : number_format($PrecioFinal / $reg[$i]['montocambio'], 2, '.', ','));
$moneda = (empty($cambio[0]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $cambio[0]['montocambio'], 2, '.', ','));

$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : "<strong>".$cambio[0]['simbolo']."</strong> "); 
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descservicio']; ?></td>
          <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
          <td><?php echo $simbolo2.$moneda; ?></td>
         </tr>
        <?php } ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********"); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $simbolo2.number_format($TotalMoneda, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'KARDEXSERVICIOS':

$detalle = new Login();
$detalle = $detalle->DetalleKardexServicio();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexServicio();

$archivo = str_replace(" ", "_","KARDEX DEL SERVICIO (".portales($detalle[0]['servicio'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
           <th>COSTO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
$Descuento = $kardex[$i]['descproducto']/100;
$PrecioDescuento = $kardex[$i]['precio']*$Descuento;
$PrecioFinal = $kardex[$i]['precio']-$PrecioDescuento;
$simbolo = "<strong>".$detalle[0]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo $kardex[$i]['entradas']; ?></td>
          <td><?php echo $kardex[$i]['salidas']; ?></td>
          <td><?php echo $kardex[$i]['devolucion']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
           <td><?php echo $kardex[$i]['descproducto']; ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>

          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
          <?php } else { ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
          <?php } ?>

<?php } ?>
          <td><?php echo $kardex[$i]['documento']; ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE SERVICIO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $detalle[0]['codservicio']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['servicio']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo $TotalEntradas; ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo $TotalSalidas; ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo $TotalDevolucion; ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.$detalle[0]['preciocompra'] : "**********"); ?><br>
<strong>PRECIO VENTA:</strong> <?php echo $simbolo.$detalle[0]['precioventa']; ?>
<?php
break;

case 'KARDEXSERVICIOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarKardexServiciosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE SERVICIOS VALORIZADO POR FECHAS ( DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE SERVICIO</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>VENDIDO</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$VendidosTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$simbolo="";
$a=1;
for($i=0;$i<sizeof($reg);$i++){

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];

$SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$TotalGanancia+=$SumVenta-$SumCompra;  
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codservicio']; ?></td>
          <td><?php echo $reg[$i]['servicio']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?>%</td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
  <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ',') : "**********"); ?></td>
  <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
        <tr>
            <td colspan="5"></td>
            <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
            <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
            <td><strong><?php echo $VendidosTotal; ?></strong></td>
            <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
            <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
            <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
          </tr>
</table>
<?php
break;
################################# MODULO DE SERVICIOS ################################




























################################# MODULO DE PRODUCTOS ################################
case 'PRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>LOTE</th>
<?php } ?>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>STOCK MINIMO</th>
           <th>STOCK MAXIMO</th>
<?php } ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php if ($documento == "EXCEL") { ?>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXPIRACIÓN</th>
           <th>PROVEEDOR</th>
<?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalArticulos=0;
$simbolo = 0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalVenta+=$reg[$i]['precioventa']-$reg[$i]['descproducto']/100;
$TotalArticulos+=$reg[$i]['existencia'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codpresentacion'] == '' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']; ?></td>
           <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
<?php } ?>
           <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           
           <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>

<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['stockmaximo'] == '0' ? "*********" : $reg[$i]['stockmaximo']; ?></td>
<?php } ?>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
<?php if ($documento == "EXCEL") { ?>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
<?php } ?>
         </tr>
        <?php } ?>
         <tr>
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="7"></td>
  <?php } else { ?>
           <td colspan="4"></td>
  <?php } ?>
<td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********"); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $TotalArticulos; ?></td>
<?php if ($documento == "EXCEL") { ?>
<td colspan="7"></td>
<?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCSV':

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>LOTE</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>STOCK MINIMO</th>
           <th>STOCK MAXIMO</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>FECHA DE ELABORACIÓN</th>
           <th>FECHA DE EXPIRACIÓN</th>
           <th>PROVEEDOR</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['codmarca']; ?></td>
           <td><?php echo $reg[$i]['codpresentacion']; ?></td>
           <td><?php echo $reg[$i]['codmedida']; ?></td>
           <td><?php echo $reg[$i]['lote']; ?></td>
           <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
           <td><?php echo $reg[$i]['precioventa']; ?></td>
           <td><?php echo $reg[$i]['existencia']; ?></td>
           <td><?php echo $reg[$i]['stockminimo']; ?></td>
           <td><?php echo $reg[$i]['stockmaximo']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto']; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
  <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
  <td><?php echo $reg[$i]['fechaexpiracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaexpiracion'])); ?></td>
           <td><?php echo $reg[$i]['codproveedor']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'PRODUCTOSVENDIDOS':

$tra = new Login();
$reg = $tra->BuscarProductosVendidos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 

$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
          <td colspan="8"></td>
          <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
          <td><strong><?php echo $ExisteTotal; ?></strong></td>
          <td><strong><?php echo $VendidosTotal; ?></strong></td>
          <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarProductosxVendedor();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS VENDIDOS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>VENDIDO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 

$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?>%</td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
          <td colspan="8"></td>
          <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
          <td><strong><?php echo $ExisteTotal; ?></strong></td>
          <td><strong><?php echo $VendidosTotal; ?></strong></td>
          <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSXMONEDA':

$tra = new Login();
$reg = $tra->ListarProductos();

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC</th>
<?php } ?>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>PRECIO <?php echo $cambio[0]['siglas']; ?></th>
           <th>EXISTENCIA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0;
$TotalArticulos=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalCompra+=$reg[$i]['preciocompra'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$TotalVenta+=$reg[$i]['precioventa'];
$TotalMoneda+=(empty($reg[$i]['montocambio']) ? "0.00" : number_format($PrecioFinal / $reg[$i]['montocambio'], 2, '.', ','));
$moneda = (empty($cambio[0]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $cambio[0]['montocambio'], 2, '.', ',')); 
$TotalArticulos+=$reg[$i]['existencia'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : "<strong>".$cambio[0]['simbolo']."</strong> ");
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codproducto']; ?></td>
           <td><?php echo $reg[$i]['producto']; ?></td>
           <td><?php echo $reg[$i]['nommarca']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['codpresentacion'] == '' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
           <td><?php echo $reg[$i]['codmedida'] == '0' ? "*********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
<?php } ?>
           <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>
           <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo2.$moneda; ?></td>
         </tr>
        <?php } ?>
         <tr>
  <?php if ($documento == "EXCEL") { ?>
           <td colspan="8"></td>
  <?php } else { ?>
           <td colspan="4"></td>
  <?php } ?>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********"); ?></td>
<td><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></td>
<td><?php echo $simbolo2.number_format($TotalMoneda, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'KARDEXPRODUCTOS':

$detalle = new Login();
$detalle = $detalle->DetalleKardexProducto();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();

$archivo = str_replace(" ", "_","KARDEX DEL PRODUCTO (".portales($detalle[0]['producto'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>MOVIMIENTO</th>
           <th>ENTRADAS</th>
           <th>SALIDAS</th>
           <th>DEVOLUCIÓN</th>
           <th>EXISTENCIA</th>
<?php if ($documento == "EXCEL") { ?>
           <th><?php echo $impuesto; ?></th>
           <th>DESCUENTO</th>
           <th>PRECIO</th>
           <th>COSTO</th>
<?php } ?>
           <th>DOCUMENTO</th>
           <th>FECHA KARDEX</th>
         </tr>
      <?php 

if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
$Descuento = $kardex[$i]['descproducto']/100;
$PrecioDescuento = $kardex[$i]['precio']*$Descuento;
$PrecioFinal = $kardex[$i]['precio']-$PrecioDescuento;
$simbolo = "<strong>".$detalle[0]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $kardex[$i]['movimiento']; ?></td>
          <td><?php echo $kardex[$i]['entradas']; ?></td>
          <td><?php echo $kardex[$i]['salidas']; ?></td>
          <td><?php echo $kardex[$i]['devolucion']; ?></td>
          <td><?php echo $kardex[$i]['stockactual']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $kardex[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
           <td><?php echo $kardex[$i]['descproducto']; ?></td>
           <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>

          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
          <?php } else { ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
          <?php } ?>

<?php } ?>
          <td><?php echo $kardex[$i]['documento']; ?></td>
          <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<strong>DETALLE DE PRODUCTO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['producto']; ?><br>
<strong>PRESENTACIÓN:</strong> <?php echo $detalle[0]['nompresentacion']; ?><br>
<strong>MARCA:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
<strong>UNIDAD MEDIDA:</strong> <?php echo $detalle[0]['nommedida'] == '' ? "*****" : $detalle[0]['nommedida']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo $TotalEntradas; ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo $TotalSalidas; ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo $TotalDevolucion; ?><br>
<strong>EXISTENCIA:</strong> <?php echo $detalle[0]['existencia']; ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
<strong>PRECIO VENTA:</strong> <?php echo $simbolo.$detalle[0]['precioventa']; ?>
<?php
break;

case 'KARDEXPRODUCTOSVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexProductosValorizado(); 

$archivo = str_replace(" ", "_","KARDEX DE PRODUCTOS VALORIZADO DE SUCURSAL: (".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>EXISTENCIA</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
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
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?>%</td>
          <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<font color='red'>".$reg[$i]['existencia']."</font color>" : "<font color='blue'>".$reg[$i]['existencia']."</font color>"; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="10"></td>
<td><?php echo $ExisteTotal; ?></strong></td>
<td><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></td>
<td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></td>
<td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'KARDEXPRODUCTOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarKardexProductosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS VALORIZADO POR FECHAS ( DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN DE PRODUCTO</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>UNIDAD MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>PRECIO COMPRA</th>
           <th>PRECIO VENTA</th>
           <th>VENDIDO</th>
           <th>TOTAL VENTA</th>
           <th>TOTAL COMPRA</th>
           <th>GANANCIAS</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$VendidosTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$simbolo="";
$a=1;
for($i=0;$i<sizeof($reg);$i++){

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];

$SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$TotalGanancia+=$SumVenta-$SumCompra;  
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?>%</td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
          <td colspan="8"></td>
          <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
          <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
          <td><strong><?php echo $VendidosTotal; ?></strong></td>
          <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
          <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
          <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
         </tr>
</table>
<?php
break;
################################# MODULO DE PRODUCTOS ################################















################################# MODULO DE TRASPASOS #################################
case 'TRASPASOS':

$tra = new Login();
$reg = $tra->ListarTraspasos(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['sumarticulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codtraspaso']; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
           <td><?php echo $reg[$i]['sumarticulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center">
           <td colspan="6"></td>
<td><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXSUCURSAL':

$tra = new Login();
$reg = $tra->BuscarTraspasosxSucursal(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS DE SUCURSAL (N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['sumarticulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codtraspaso']; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
           <td><?php echo $reg[$i]['sumarticulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center">
           <td colspan="6"></td>
<td><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarTraspasosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE TRASPASO</th>
           <th>SUCURSAL QUE ENVIA</th>
           <th>SUCURSAL QUE RECIBE</th>
           <th>OBSERVACIONES</th>
           <th>FECHA DE EMISIÓN</th>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['sumarticulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr align="center" class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codtraspaso']; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
           <td><?php echo $reg[$i]['sumarticulos']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
           <?php } ?>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr align="center">
           <td colspan="6"></td>
<td><?php echo $TotalArticulos; ?></strong></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSTRASPASOS':

$tra = new Login();
$reg = $tra->BuscarProductosTraspasos(); 

$archivo = str_replace(" ", "_","LISTADO DE DETALLES TRASPASOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>TRASPASADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal += $reg[$i]['precioventa'];
$ExisteTotal += $reg[$i]['existencia'];
$VendidosTotal += $reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['existencia']; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $ExisteTotal; ?></strong></td>
<td><?php echo $VendidosTotal; ?></strong></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;
################################## MODULO DE TRASPASOS ###################################



















############################### MODULO DE COMPRAS ###############################
case 'COMPRAS':

$tra = new Login();
$reg = $tra->ListarCompras(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COMPRAS");
} else {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COMPRAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasic'];
$TotalExento+=$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcompra']; ?></td>
            <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
            <td><?php echo $reg[$i]['tipocompra']; ?></td>
            <td><?php echo $reg[$i]['formacompra']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CUENTASXPAGAR':

$tra = new Login();
$reg = $tra->ListarCuentasxPagar(); 

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COMPRAS POR PAGAR");
} else {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COMPRAS POR PAGAR EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <th>IMPORTE TOTAL</th>
           <th>IMPORTE ABONADO</th>
           <th>IMPORTE DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

           <td><?php 
      if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statuscompra"]."</font color>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statuscompra"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statuscompra"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
      <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
      <?php } ?>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>

         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarComprasxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS EN (SUCURSAL ".$reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']." Y PROVEEDOR ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasic'];
$TotalExento+=$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcompra']; ?></td>
            <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
            <td><?php echo $reg[$i]['tipocompra']; ?></td>
            <td><?php echo $reg[$i]['formacompra']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasic'];
$TotalExento+=$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcompra']; ?></td>
            <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
            <td><?php echo $reg[$i]['tipocompra']; ?></td>
            <td><?php echo $reg[$i]['formacompra']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSCOMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarCreditosxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <th>IMPORTE TOTAL</th>
           <th>IMPORTE ABONADO</th>
           <th>IMPORTE DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

           <td><?php 
      if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statuscompra"]."</font color>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statuscompra"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statuscompra"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
      <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
      <?php } ?>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>

         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CREDITOS DE COMPRAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COMPRA</th>
           <th>NOMBRE DE PROVEEDOR</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>FECHA RECEPCIÓN</th>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>Nº DE ARTICULOS</th>
           <th>IMPORTE TOTAL</th>
           <th>IMPORTE ABONADO</th>
           <th>IMPORTE DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalImporte+=$reg[$i]['totalpagoc'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpagoc']-$reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codcompra']; ?></td>
           <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
           <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

          <td><?php 
      if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statuscompra"]."</font color>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statuscompra"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statuscompra"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
      <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
      <?php } ?>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>

         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;
############################### MODULO DE COMPRAS ###############################
























################################## MODULO DE COTIZACIONES ###################################
case 'COTIZACIONES':

$tra = new Login();
$reg = $tra->ListarCotizaciones(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COTIZACIONES");
} else {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE COTIZACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COTIZACIÓN</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <th>FECHA EMISIÓN</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacotizacion'])); ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COTIZACIÓN</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <th>FECHA EMISIÓN</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacotizacion'])); ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXESPECIALISTA':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxEspecialista(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES DEL (ESPECIALISTA : ".$reg[0]["cedespecialista"].": ".$reg[0]['nomespecialista']." ".$reg[0]['especialidad']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COTIZACIÓN</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <th>FECHA EMISIÓN</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacotizacion'])); ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxPaciente(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº COTIZACIÓN</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>FECHA EMISIÓN</th>
           <th>OBSERVACIONES</th>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacotizacion'])); ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCOTIZADOS':

$tra = new Login();
$reg = $tra->BuscarProductosCotizados(); 

$archivo = str_replace(" ", "_","LISTADO DE DETALLES COTIZADOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal += $reg[$i]['precioventa'];
$ExisteTotal += $reg[$i]['existencia'];
$VendidosTotal += $reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? "**********" : $reg[$i]['existencia']; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $ExisteTotal; ?></strong></td>
<td><?php echo $VendidosTotal; ?></strong></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;

case 'COTIZADOSXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxVendedor(); 

$archivo = str_replace(" ", "_","LISTADO DE DETALLES COTIZADOS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>CÓDIGO</th>
           <th>DESCRIPCIÓN</th>
           <th>MARCA</th>
           <th>PRESENTACIÓN</th>
           <th>MEDIDA</th>
           <th><?php echo $impuesto; ?></th>
           <th>DESC.</th>
           <th>PRECIO VENTA</th>
           <th>EXISTENCIA</th>
           <th>COTIZADO</th>
           <th>MONTO TOTAL</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$PrecioTotal += $reg[$i]['precioventa'];
$ExisteTotal += $reg[$i]['existencia'];
$VendidosTotal += $reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$PagoTotal += $PrecioFinal*$reg[$i]['cantidad']; 
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
          <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
          <td><?php echo $reg[$i]['descproducto']; ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo $reg[$i]['tipodetalle'] == '1' ? "**********" : $reg[$i]['existencia']; ?></td>
          <td><?php echo $reg[$i]['cantidad']; ?></td>
          <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
         </tr>
        <?php } } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
<td><?php echo $ExisteTotal; ?></strong></td>
<td><?php echo $VendidosTotal; ?></strong></td>
<td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
         </tr>
</table>
<?php
break;
################################## MODULO DE COTIZACIONES ###################################





            
















############################### MODULO DE CITAS ###############################
case 'CITAS':

$tra = new Login();
$reg = $tra->ListarCitas(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO DE CITAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE CITAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>DESCRIPCIÓN DE CITA</th>
           <th>FECHA CITA</th>
           <th>HORA CITA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA INGRESO</th>
           <th>STATUS</th>
           <th>REGISTRADO</th>
           <?php } ?>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                            <tr class="even_row">
                            <td><?php echo $a++; ?></td>
                            <td><?php echo $reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
                            <td><?php echo $reg[$i]['cedpaciente']." : ".$reg[$i]['pacientes']; ?></td>
                            <td><?php echo $reg[$i]['descripcion']; ?></td>
                            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                            <?php if ($documento == "EXCEL") { ?>
                            <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                            <td><?php 
      if($reg[$i]["statuscita"] == 'VERIFICADA') { echo "<font color='green'>".$reg[$i]["statuscita"]."</font color>"; } 
      elseif($reg[$i]["statuscita"] == 'EN PROCESO') { echo "<font color='blue'>".$reg[$i]["statuscita"]."</font color>"; }
      else { echo "<font color='red'>".$reg[$i]["statuscita"]."</font color>"; } ?></td>
                            <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                              <?php } ?>
        <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'CITASXFECHAS':

$tra = new Login();
$reg = $tra->BusquedaCitasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CITAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>DESCRIPCIÓN DE CITA</th>
           <th>FECHA CITA</th>
           <th>HORA CITA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA INGRESO</th>
           <th>STATUS</th>
           <th>REGISTRADO</th>
           <?php } ?>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                              <tr class="even_row">
                              <td><?php echo $a++; ?></td>
                              <td><?php echo $reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
                              <td><?php echo $reg[$i]['cedpaciente']." : ".$reg[$i]['pacientes']; ?></td>
                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <?php if ($documento == "EXCEL") { ?>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
      if($reg[$i]["statuscita"] == 'VERIFICADA') { echo "<font color='green'>".$reg[$i]["statuscita"]."</font color>"; } 
      elseif($reg[$i]["statuscita"] == 'EN PROCESO') { echo "<font color='blue'>".$reg[$i]["statuscita"]."</font color>"; }
      else { echo "<font color='red'>".$reg[$i]["statuscita"]."</font color>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                              <?php } ?>
                          <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'CITASXESPECIALISTA':

$tra = new Login();
$reg = $tra->BusquedaCitasxEspecialistas(); 

$archivo = str_replace(" ", "_","LISTADO DE CITAS DEL (ESPECIALISTA: ".$reg[0]["cedespecialista"].": ".$reg[0]["nomespecialista"]." Y FECHAS DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y  SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DOCUMENTO</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>DESCRIPCIÓN DE CITA</th>
           <th>FECHA CITA</th>
           <th>HORA CITA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA INGRESO</th>
           <th>STATUS</th>
           <th>REGISTRADO</th>
           <?php } ?>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                              <tr class="even_row">
                              <td><?php echo $a++; ?></td>
                              <td><?php echo $reg[$i]['cedpaciente']; ?></td>
                              <td><?php echo $reg[$i]['pacientes']; ?></td>
                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <?php if ($documento == "EXCEL") { ?>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
      if($reg[$i]["statuscita"] == 'VERIFICADA') { echo "<font color='green'>".$reg[$i]["statuscita"]."</font color>"; } 
      elseif($reg[$i]["statuscita"] == 'EN PROCESO') { echo "<font color='blue'>".$reg[$i]["statuscita"]."</font color>"; }
      else { echo "<font color='red'>".$reg[$i]["statuscita"]."</font color>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                              <?php } ?>
                          <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'CITASXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarCitasxPaciente(); 

$archivo = str_replace(" ", "_","LISTADO DE CITAS DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['pacientes']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DOCUMENTO</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE CITA</th>
           <th>FECHA CITA</th>
           <th>HORA CITA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA INGRESO</th>
           <th>STATUS</th>
           <th>REGISTRADO</th>
           <?php } ?>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                              <tr class="even_row">
                              <td><?php echo $a++; ?></td>
                              <td><?php echo $reg[$i]['cedespecialista']; ?></td>
                              <td><?php echo $reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <?php if ($documento == "EXCEL") { ?>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
      if($reg[$i]["statuscita"] == 'VERIFICADA') { echo "<font color='green'>".$reg[$i]["statuscita"]."</font color>"; } 
      elseif($reg[$i]["statuscita"] == 'EN PROCESO') { echo "<font color='blue'>".$reg[$i]["statuscita"]."</font color>"; }
      else { echo "<font color='red'>".$reg[$i]["statuscita"]."</font color>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                              <?php } ?>
                          <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CITAS ###############################
























##################################### MODULO DE CAJAS ###################################
case 'CAJAS':

$tra = new Login();
$reg = $tra->ListarCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE CAJAS ASIGNADAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
<?php if($_SESSION['acceso']=="administradorG"){ ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja']; ?></td>
           <td><?php echo $reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
<?php if($_SESSION['acceso']=="administradorG"){ ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ARQUEOS':

$tra = new Login();
$reg = $tra->ListarArqueos(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
<?php if ($documento == "EXCEL") { ?>
           <th>RESPONSABLE</th>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
<?php } ?>
           <th>INICIAL</th>
           <th>TOTAL EN VENTAS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>VENTAS EN EFECTIVO</th>
           <th>VENTAS EN OTROS</th>
           <th>VENTAS A CREDITOS</th>
           <th>ABONOS EN EFECTIVO</th>
           <th>ABONOS EN OTROS</th>
           <th>INGRESOS EN EFECTIVO</th>
           <th>INGRESOS EN OTROS</th>
           <th>EGRESOS</th>
<?php } ?>
           <th>TOTAL EFECTIVO</th>
           <th>EFECTIVO EN CAJA</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {


$TotalVentas = 0;
$VentasEfectivo = 0;
$VentasOtros = 0;
$TotalCreditos = 0;
$AbonosEfectivo = 0;
$AbonosOtros = 0;
$IngresosEfectivo = 0;
$IngresosOtros = 0;
$TotalEgresos = 0;
$TotalEfectivo = 0;
$TotalCaja = 0;
$TotalDiferencia = 0;

$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";

$TotalVentas += $reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$VentasEfectivo += $reg[$i]['efectivo'];

$VentasOtros += $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$TotalEfectivo += $reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'];

$TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['ingresosotros'];


$TotalCreditos += $reg[$i]['creditos'];
$AbonosEfectivo += $reg[$i]['abonosefectivo'];
$AbonosOtros += $reg[$i]['abonosotros'];
$IngresosEfectivo += $reg[$i]['ingresosefectivo'];
$IngresosOtros += $reg[$i]['ingresosotros'];
$TotalEgresos += $reg[$i]['egresos'];
$TotalCaja += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
<?php if ($documento == "EXCEL") { ?>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>

            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
         <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($VentasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCreditos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
         </tr>
<?php } ?>
</table>
<?php
break;

case 'ARQUEOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarArqueosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>APERTURA</th>
           <th>CIERRE</th>
           <th>OBSERVACIONES</th>
           <th>INICIAL</th>
           <th>TOTAL EN VENTAS</th>
<?php if ($documento == "EXCEL") { ?>
           <th>VENTAS EN EFECTIVO</th>
           <th>VENTAS EN OTROS</th>
           <th>VENTAS A CREDITOS</th>
           <th>ABONOS EN EFECTIVO</th>
           <th>ABONOS EN OTROS</th>
           <th>INGRESOS EN EFECTIVO</th>
           <th>INGRESOS EN OTROS</th>
           <th>EGRESOS</th>
<?php } ?>
           <th>TOTAL EFECTIVO</th>
           <th>EFECTIVO EN CAJA</th>
           <th>DIFERENCIA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {


$TotalVentas = 0;
$VentasEfectivo = 0;
$VentasOtros = 0;
$TotalCreditos = 0;
$AbonosEfectivo = 0;
$AbonosOtros = 0;
$IngresosEfectivo = 0;
$IngresosOtros = 0;
$TotalEgresos = 0;
$TotalEfectivo = 0;
$TotalCaja = 0;
$TotalDiferencia = 0;

$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";

$TotalVentas += $reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$VentasEfectivo += $reg[$i]['efectivo'];

$VentasOtros += $reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$TotalEfectivo += $reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'];

$TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['ingresosotros'];


$TotalCreditos += $reg[$i]['creditos'];
$AbonosEfectivo += $reg[$i]['abonosefectivo'];
$AbonosOtros += $reg[$i]['abonosotros'];
$IngresosEfectivo += $reg[$i]['ingresosefectivo'];
$IngresosOtros += $reg[$i]['ingresosotros'];
$TotalEgresos += $reg[$i]['egresos'];
$TotalCaja += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
           <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
           <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['creditos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['abonosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['ingresosotros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['egresos'], 2, '.', ','); ?></td>
<?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>

            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
         <tr>
         <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="3"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($VentasEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($VentasOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCreditos, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($AbonosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($IngresosOtros, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
<?php } ?>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
         </tr>
<?php } ?>
</table>
<?php
break;

case 'MOVIMIENTOS':

$tra = new Login();
$reg = $tra->ListarMovimientos(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>FECHA MOVIMIENTO</th>
           <th>MONTO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalIngresos=0;
$TotalEgresos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
          <tr>
           <td colspan="6"></td>
<td><strong>TOTAL INGRESOS</strong></td>
<td><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></td>
          </tr>
          <tr>
           <td colspan="6"></td>
<td><strong>TOTAL EGRESOS</strong></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
          </tr>
        <?php } ?>
</table>
<?php
break;

case 'MOVIMIENTOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarMovimientosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE CAJA</th>
           <th>RESPONSABLE</th>
           <th>DESCRIPCIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>FECHA MOVIMIENTO</th>
           <th>MONTO</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalIngresos=0;
$TotalEgresos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
           <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
           <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
           <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
           <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
           <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
         </tr>
        <?php } ?>
          <tr>
           <td colspan="6"></td>
<td><strong>TOTAL INGRESOS</strong></td>
<td><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></td>
          </tr>
          <tr>
           <td colspan="6"></td>
<td><strong>TOTAL EGRESOS</strong></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
          </tr>
        <?php } ?>
</table>
<?php
break;
#################################### MODULO DE CAJAS ####################################






















################################## MODULO DE ODONTOLOGIA ###################################
case 'ODONTOLOGIA':

$tra = new Login();
$reg = $tra->ListarOdontologia(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO DE CONSULTAS ODONTOLOGICAS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE CONSULTAS ODONTOLOGICAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CONSULTA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
            <?php if ($documento == "EXCEL") { ?>
           <th>PRONOSTICO</th>
           <th>TRATAMIENTO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>FECHA</th>
           <th>HORA</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo $reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento']; ?></td>
           <?php } ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ODONTOLOGIAXFECHAS':

$tra = new Login();
$reg = $tra->BuscarOdontologiaxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CONSULTAS ODONTOLOGICAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CONSULTA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
            <?php if ($documento == "EXCEL") { ?>
           <th>PRONOSTICO</th>
           <th>TRATAMIENTO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>FECHA</th>
           <th>HORA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo $reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento']; ?></td>
           <?php } ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ODONTOLOGIAXESPECIALISTA':

$tra = new Login();
$reg = $tra->BuscarOdontologiaxEspecialista(); 

$archivo = str_replace(" ", "_","LISTADO DE CONSULTAS ODONTOLOGICAS DEL (ESPECIALISTA : ".$reg[0]["cedespecialista"].": ".$reg[0]["nomespecialista"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CONSULTA</th>
           <th>NOMBRE DE PACIENTE</th>
            <?php if ($documento == "EXCEL") { ?>
           <th>PRONOSTICO</th>
           <th>TRATAMIENTO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>FECHA</th>
           <th>HORA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo $reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento']; ?></td>
           <?php } ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'ODONTOLOGIAXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarOdontologiaxPaciente(); 

$archivo = str_replace(" ", "_","HISTORIA ODONTOLOGICA DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CONSULTA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
            <?php if ($documento == "EXCEL") { ?>
           <th>PRONOSTICO</th>
           <th>TRATAMIENTO</th>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>FECHA</th>
           <th>HORA</th>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo $reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento']; ?></td>
           <?php } ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'CONSENTIMIENTOS':

$tra = new Login();
$reg = $tra->ListarConsentimientos(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO DE CONSENTIMIENTOS INFORMADO");
} else {
$archivo = str_replace(" ", "_","LISTADO DE CONSENTIMIENTOS INFORMADO EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>NOMBRE DE TESTIGO</th>
           <th>PROCEDIMIENTO</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>OBSERVACIONES</th>
           <?php } ?>
           <th>FECHA</th>
           <th>HORA</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo $reg[$i]['doctestigo'] == "" ? "**********" : $reg[$i]['doctestigo'].": ".$reg[$i]['nombretestigo']; ?></td>
            <td><?php echo $reg[$i]['procedimiento']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $reg[$i]['observaciones']; ?></td>
            <?php } ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaconsentimiento'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaconsentimiento'])); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } } ?>
</table>
<?php
break;
################################## MODULO DE ODONTOLOGIA ################################
























################################## MODULO DE VENTAS ###################################
case 'VENTAS':

$tra = new Login();
$reg = $tra->ListarVentas(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE FACTURACIÓN");
} else {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE FACTURACIÓN EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <th>STATUS</th>
           <th>VENCE CREDITO</th>
           <th>DIAS VENC.</th>
           <?php } ?>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
            <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo $reg[$i]['tipopago']; ?></td>
            <td><?php echo $reg[$i]['formapago']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            
            <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>


            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="12"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarVentasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE FACTURACIÓN EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <th>STATUS</th>
           <th>VENCE CREDITO</th>
           <th>DIAS VENC.</th>
           <?php } ?>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo $reg[$i]['tipopago']; ?></td>
            <td><?php echo $reg[$i]['formapago']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            
            <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>


            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="4"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarVentasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE FACTURACIÓN POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <th>STATUS</th>
           <th>VENCE CREDITO</th>
           <th>DIAS VENC.</th>
           <?php } ?>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
            <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo $reg[$i]['tipopago']; ?></td>
            <td><?php echo $reg[$i]['formapago']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            
            <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>


            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="12"></td>' : '<td colspan="4"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXESPECIALISTA':

$tra = new Login();
$reg = $tra->BuscarVentasxEspecialista(); 

$archivo = str_replace(" ", "_","LISTADO DE FACTURACIÓN DEL (ESPECIALISTA : ".$reg[0]["cedespecialista"].": ".$reg[0]['nomespecialista']." ".$reg[0]['especialidad']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº FACTURA</th>
           <th>DESCRIPCIÓN DE PACIENTE</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <th>STATUS</th>
           <th>VENCE CREDITO</th>
           <th>DIAS VENC.</th>
           <?php } ?>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
            <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo $reg[$i]['tipopago']; ?></td>
            <td><?php echo $reg[$i]['formapago']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            
            <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>


            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="4"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'VENTASXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarVentasxPaciente(); 

$archivo = str_replace(" ", "_","LISTADO DE FACTURACIÓN DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº DE CAJA</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>FECHA EMISIÓN</th>
           <th>TIPO</th>
           <th>MÉTODO</th>
           <th>OBSERVACIONES</th>
           <th>STATUS</th>
           <th>VENCE CREDITO</th>
           <th>DIAS VENC.</th>
           <?php } ?>
           <th>Nº DE DETALLES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>TOTAL GRAVADO</th>
           <th>TOTAL EXENTO</th>
           <th>TOTAL <?php echo $impuesto; ?></th>
           <th>TOTAL DESC</th>
           <?php } ?>
           <th>IMPORTE TOTAL</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalGravado=0;
$TotalExento=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalArticulos+=$reg[$i]['articulos'];
$TotalGravado+=$reg[$i]['subtotalivasi'];
$TotalExento+=$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
            <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
            <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaventa'])); ?></td>
            <td><?php echo $reg[$i]['tipopago']; ?></td>
            <td><?php echo $reg[$i]['formapago']; ?></td>
            <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
            
            <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>


            <?php } ?>
            <td><?php echo $reg[$i]['articulos']; ?></td>
            <?php if ($documento == "EXCEL") { ?>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
            <?php } ?>
            <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
            <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
          <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="4"></td>'; ?>
<td><?php echo $TotalArticulos; ?></td>
           <?php if ($documento == "EXCEL") { ?>
<td><?php echo $simbolo.number_format($TotalGravado, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalExento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
           <?php } ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;
################################## MODULO DE VENTAS ################################




















################################## MODULO DE CREDITOS #################################
case 'CREDITOS':

$tra = new Login();
$reg = $tra->ListarCreditos(); 

if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE CREDITOS");
} else {
$archivo = str_replace(" ", "_","LISTADO GENERAL DE CREDITOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>OBSERVACIONES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
           <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]['cedpaciente']." ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'CREDITOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE CRÉDITOS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"])).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>NOMBRE DE PACIENTE</th>
           <th>OBSERVACIONES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
           <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]['cedpaciente']." ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;


case 'CREDITOSXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarCreditosxPacientes(); 

$archivo = str_replace(" ", "_","LISTADO DE CRÉDITOS DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>OBSERVACIONES</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;

case 'DETALLESCREDITOSXPACIENTE':

$tra = new Login();
$reg = $tra->BuscarCreditosxDetalles(); 

$archivo = str_replace(" ", "_","LISTADO DETALLES DE CRÉDITOS DEL (PACIENTE : ".$reg[0]["cedpaciente"].": ".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>Nº FACTURA</th>
           <th>NOMBRE DE ESPECIALISTA</th>
           <th>OBSERVACIONES</th>
           <th>DETALLES DE FACTURA</th>
           <?php if ($documento == "EXCEL") { ?>
           <th>STATUS</th>
           <th>DIAS VENC.</th>
           <th>FECHA VENCE</th>
           <th>FECHA PAGADO</th>
           <?php } ?>
           <th>FECHA DE EMISIÓN</th>
           <th>IMPORTE TOTAL</th>
           <th>TOTAL ABONO</th>
           <th>TOTAL DEBE</th>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
         </tr>
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago'] - $reg[$i]['creditopagado'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['codfactura']; ?></td>
           <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></td>
           <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
           <td><?php echo "<font size='10px'>".$reg[$i]['detalles']."</font size>"; ?></td>

           <?php if ($documento == "EXCEL") { ?>
           <td><?php 
      if($reg[$i]["statusventa"] == 'PAGADA') { echo "<font color='green'>".$reg[$i]["statusventa"]."</font color>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<font color='red'>".$reg[$i]["statusventa"]."</font color>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<font color='red'>VENCIDA</font color>"; } 
      else { echo "<font color='blue'>".$reg[$i]["statusventa"]."</font color>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

      <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
      <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

      <?php } ?>
           
           <td><?php echo date("d-m-Y h:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['nomsucursal']; ?></td><?php } ?>
         </tr>
        <?php } ?>
         <tr>
           <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<?php if ($_SESSION['acceso'] == "administradorG") { ?><td></td><?php } ?>
         </tr>
        <?php } ?>
</table>
<?php
break;
################################# MODULO DE CREDITOS ###################################


}
 
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