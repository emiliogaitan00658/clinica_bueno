<?php
require_once("class/class.php");
?>
<script src="assets/script/jscalendario.js"></script>
<script src="assets/script/autocompleto.js"></script> 

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();

$new = new Login();
?>


<?php 
######################## BUSCA PROVINCIAS POR DEPARTAMENTOS ########################
if (isset($_GET['BuscaProvincias']) && isset($_GET['id_departamento'])) {
  
  $departamento = $new->ListarProvinciasXDepartamento();

  $id_departamento = limpiar($_GET['id_departamento']);

 if($id_departamento=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>

  <?php } else { ?>

    <option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($departamento);$i++){
    ?>
<option value="<?php echo $departamento[$i]['id_provincia']; ?>"><?php echo $departamento[$i]['provincia']; ?></option>
    <?php 
    }
  }
}
######################## BUSCA PROVINCIAS POR DEPARTAMENTOS ########################
?>

<?php 
######################## SELECCIONE PROVINCIA POR DEPARTAMENTO ########################
if (isset($_GET['SeleccionaProvincia']) && isset($_GET['id_departamento']) && isset($_GET['id_provincia'])) {
  
   $provincia = $new->SeleccionaProvincia();
  ?>
    </div>
  </div>
       <option value=""> -- SELECCIONE -- </option>
  <?php for($i=0;$i<sizeof($provincia);$i++){ ?>
<option value="<?php echo $provincia[$i]['id_provincia']; ?>"<?php if (!(strcmp($_GET['id_provincia'], htmlentities($provincia[$i]['id_provincia'])))) {echo "selected=\"selected\"";} ?>><?php echo $provincia[$i]['provincia']; ?></option>
<?php
   } 
}
######################## SELECCIONE PROVINCIA POR DEPARTAMENTO ########################
?>


<?php
######################## MOSTRAR USUARIO EN VENTANA MODAL ############################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 
$reg = $new->UsuariosPorId();
?>

  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Nº de Documento:</strong> <?php echo $reg[0]['dni']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direccion']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['telefono']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td><strong>Usuario de Acceso: </strong> <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td><strong>Nivel de Acceso: </strong> <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <tr>
  <td><strong>Status de Acceso: </strong> <?php echo $status = ( $reg[0]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
  <?php if($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td><strong>Sucursal Asignada: </strong> <?php echo $reg[0]['gruposnombres'] == "" ? "**********" : $reg[0]['gruposnombres']; ?></td>
  </tr>
  <?php } ?>
</table>  

  <?php
   } 
######################## MOSTRAR USUARIO EN VENTANA MODAL ############################
?>


<?php 
########################## BUSCA USUARIOS POR SUCURSALES #############################
if (isset($_GET['BuscaUsuariosxSucursal']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCA USUARIOS POR SUCURSALES ##########################
?>


<?php 
######################## SELECCIONE USUARIOS POR SUCURSAL ########################
if (isset($_GET['MuestraUsuario']) && isset($_GET['codigo']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"<?php if (!(strcmp($_GET['codigo'], htmlentities($usuario[$i]['codigo'])))) { echo "selected=\"selected\"";} ?>><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres']; ?></option>
<?php
   } 
}
######################## SELECCIONE USUARIOS POR SUCURSAL #######################
?>

<!--########################### LISTAR SUCURSALES ##########################-->
<?php if (isset($_GET['MuestraSucursalesUsuarios']) && isset($_GET['nivel'])): ?>

<?php 
$sucursal = new Login();
$suc = $sucursal->ListarSucursales();

if($suc==""){  

} else if($_SESSION['acceso'] == "administradorG" && $_GET['nivel']!="ADMINISTRADOR(A) GENERAL"){  
?>

<h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-bank"></i> Sucursales</h2><hr>

<div class="row"> 
              
<?php
$a=1;
for($i=0;$i<sizeof($suc);$i++){ 
?>

    <div class="col-md-4 m-t-10">
        <div class="form-check">
            <div class="custom-control custom-radio">
                <input type="checkbox" class="custom-control-input" name="codsucursal[]" id="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>" value="<?php echo $suc[$i]['codsucursal'] ?>">
                   <label class="custom-control-label" for="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>">
                   <?php echo $suc[$i]['nomsucursal'] ?>
                   </label>
            </div>
        </div>
    </div>
                        <?php } ?>
                    </div> 
        <?php } ?>

<?php endif; ?>
<!--########################### LISTAR SUCURSALES ##########################-->

<!--########################### LISTAR SUCURSALES ASIGNADAS POR USUARIO ##########################-->
<?php if (isset($_GET['MuestraSucursalesAsignadasxUsuarios']) && isset($_GET['codigo']) && isset($_GET['nivel']) && isset($_GET['gruposid'])): ?>

<?php 
$sucursal = new Login();
$suc = $sucursal->ListarSucursales();

if($suc==""){  

} else if($_SESSION['acceso'] == "administradorG" && $_GET['nivel']!="ADMINISTRADOR(A) GENERAL"){  
?>

<h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-bank"></i> Sucursales</h2><hr>

<div class="row"> 
              
<?php
$a=1;
for($i=0;$i<sizeof($suc);$i++){ 
?>

    <div class="col-md-4 m-t-10">
        <div class="form-check">
            <div class="custom-control custom-radio">
                <input type="checkbox" class="custom-control-input" name="codsucursal[]" id="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>" value="<?php echo $suc[$i]['codsucursal'] ?>" <?php 

$explode = explode(", ", $_GET['gruposid']);

foreach($explode as $meschecked){

echo $meschecked == $suc[$i]['codsucursal'] ? "checked=\"checked\"":'';  } ?>>
                   <label class="custom-control-label" for="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>">
                   <?php echo $suc[$i]['nomsucursal'] ?>
                   </label>
            </div>
        </div>
    </div>
                        <?php } ?>
                    </div> 
        <?php } ?>

<?php endif; ?>
<!--########################### LISTAR SUCURSALES ASIGNADAS POR USUARIO ##########################-->




<?php
######################## MOSTRAR MENSAJE DE CONTACTO EN VENTANA MODAL ############################
if (isset($_GET['BuscaMensajeModal']) && isset($_GET['codmensaje'])) { 
$reg = $new->MensajesPorId();
?>

  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['name']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['phone'] == '' ? "***********" : $reg[0]['phone']; ?></td>
  </tr>
  <tr>
    <td><strong>Email: </strong> <?php echo $reg[0]['email']; ?></td>
  </tr> 
  <tr>
    <td><strong>Asunto: </strong> <?php echo $reg[0]['subject']; ?></td>
  </tr>
  <tr>
    <td><strong>Mensaje: </strong> <?php echo $reg[0]['message']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha: </strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]["fecha"])); ?></td>
  </tr>
</table>  

  <?php
   } 
######################## MOSTRAR MENSAJE DE CONTACTO EN VENTANA MODAL ############################
?>


<?php 
########################## BUSCA TIPO PERSONA PARA HORARIO #############################
if (isset($_GET['MuestraTipoBusqueda']) && isset($_GET['busqueda'])) {
  
if(decrypt($_GET['busqueda']) == '1'){ //SI ES USUARIO

$usuario = new Login();
$usuario = $usuario->ListarTiposUsuarios();
?>
<option value=""> -- SELECCIONE -- </option>
<?php
for($i=0;$i<sizeof($usuario);$i++){
?>
<option value="<?php echo encrypt($usuario[$i]['codigo']); ?>"><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres']; ?></option>
<?php 
} 

} else if(decrypt($_GET['busqueda']) == '2'){ // SI ES ESPECIALISTA

$especialista = new Login();
$especialista = $especialista->ListarTiposEspecialistas();
?>
<option value=""> -- SELECCIONE -- </option>
<?php
for($i=0;$i<sizeof($especialista);$i++){
?>
<option value="<?php echo encrypt($especialista[$i]['codespecialista']); ?>"><?php echo $especialista[$i]['cedespecialista'].": ".$especialista[$i]['nomespecialista']; ?></option>
<?php 
    }
  } 
}
############################# BUSCA TIPO PERSONA PARA HORARIO ##########################
?>













<?php
######################### MOSTRAR SUCURSAL EN VENTANA MODAL ##########################
if (isset($_GET['BuscaSucursalModal']) && isset($_GET['codsucursal'])) { 

$reg = $new->SucursalesPorId();
?>
  
  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Nº de Sucursal: </strong> <?php echo $reg[0]['nrosucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documsucursal'] == '0' ? "Documento" : $reg[0]['documento'] ?>: </strong> <?php echo $reg[0]['cuitsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Razòn Social: </strong> <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['departamento']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['provincia']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Sucursal: </strong> <?php echo $reg[0]['direcsucursal']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['correosucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfsucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Actividad: </strong> <?php echo $reg[0]['nroactividadsucursal']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Inicio de Ticket: </strong> <?php echo $reg[0]['inicioticket']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Inicio Nota de Venta: </strong> <?php echo $reg[0]['inicionotaventa']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Inicio de Factura: </strong> <?php echo $reg[0]['iniciofactura']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Autorización: </strong> <?php echo $reg[0]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal'])); ?></td>
  </tr> 
  <tr>
    <td><strong>Lleva Contabilidad: </strong> <?php echo $reg[0]['llevacontabilidad']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº <?php echo $reg[0]['documencargado'] == '0' ? "Documento" : $reg[0]['documento2'] ?> de Encargado:</strong> <?php echo $reg[0]['dniencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Encargado:</strong> <?php echo $reg[0]['nomencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Telèfono:</strong> <?php echo $reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado']; ?></td>
  </tr>
  <tr>
    <td><strong>Descuento Global en Ventas: </strong> <?php echo $reg[0]['descsucursal']; ?>%</td>
  </tr>  
  <tr>
    <td><strong>Moneda Nacional: </strong> <?php echo $reg[0]['codmoneda'] == '0' ? "*********" : $reg[0]['moneda']; ?></td>
  </tr> 
  <tr>
    <td><strong>Moneda Tipo de Cambio:</strong> <?php echo $reg[0]['codmoneda2'] == '0' ? "*********" : $reg[0]['moneda2']; ?></td>
  </tr>   
</table>
<?php 
} 
######################### MOSTRAR SUCURSAL EN VENTANA MODAL #########################
?>










<?php 
######################## MUESTRA DIV ESPECIALISTA ########################
if (isset($_GET['BuscaDivEspecialista'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Especialistas, el archivo Excel, debe estar estructurado de 17 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Especialista. (Ejemplo: E1, E2, E3, E4....)<br>
  2. Nº de Tarjeta Profesional.<br>
  3. Tipo de Documento. (Debera de Ingresar el Nº de Documento a la que corresponde)<br>
  4. Nº de Documento.<br>
  5. Nombre de Especialista.<br>
  6. Nº de Teléfono.<br>
  7. Sexo de Especialista. (MASCULINO / FEMENINO)<br>
  8. Departamento. (Debera de Ingresar el Nº de Departamento a la que corresponde)<br>
  9. Provincia. (Debera de Ingresar el Nº de Provincia a la que corresponde)<br>
  10. Dirección Domiciliaria. <br>
  11. Correo Electronico.<br>
  12. Especialidad.<br>
  13. Fecha de Nacimiento.<br>
  14. Red Social Twitter.<br>
  15. Red Social Facebook.<br>
  16. Red Social Instagram.<br>
  17. Red Social Google-Plus.<br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a href="fotos/especialistas.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Especialistas, deben de ser cargados como se explica, para evitar problemas de datos del Especialista dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
######################## MUESTRA DIV ESPECIALISTA ########################
?>

<?php
######################## MOSTRAR ESPECIALISTA EN VENTANA MODAL ############################
if (isset($_GET['BuscaEspecialistaModal']) && isset($_GET['codespecialista'])) { 
$reg = $new->EspecialistasPorId();
?>

  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº Tarjeta Profesional:</strong> <?php echo $reg[0]['tpespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documespecialista'] == '0' ? "Documento" : $reg[0]['documento']; ?>:</strong> <?php echo $reg[0]['cedespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres y Apellidos:</strong> <?php echo $reg[0]['nomespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfespecialista'] == '' ? "***********" : $reg[0]['tlfespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo: </strong> <?php echo $reg[0]['sexoespecialista']; ?></td>
  </tr> 
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria: </strong> <?php echo $reg[0]['direcespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['correoespecialista'] == '' ? "*********" : $reg[0]['correoespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Especialidad: </strong> <?php echo $reg[0]['especialidad']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Nacimiento: </strong> <?php echo $reg[0]['fnacespecialista'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fnacespecialista'])); ?></td>
  </tr>
  <tr>
    <td><strong>Red Social Twitter: </strong> <?php echo $reg[0]['twitter'] == '' ? "*********" : $reg[0]['twitter']; ?></td>
  </tr>
  <tr>
    <td><strong>Red Social Facebook: </strong> <?php echo $reg[0]['facebook'] == '' ? "*********" : $reg[0]['facebook']; ?></td>
  </tr>
  <tr>
    <td><strong>Red Social Instagram: </strong> <?php echo $reg[0]['instagram'] == '' ? "*********" : $reg[0]['instagram']; ?></td>
  </tr>
  <tr>
    <td><strong>Red Social Google-Plus: </strong> <?php echo $reg[0]['google'] == '' ? "*********" : $reg[0]['google']; ?></td>
  </tr>
  <?php if($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td><strong>Sucursal Asignada: </strong> <?php echo $reg[0]['gruposnombres']; ?></td>
  </tr>
  <?php } ?>
</table>  

  <?php
   } 
######################## MOSTRAR ESPECIALISTA EN VENTANA MODAL ############################
?>

<!--########################### LISTAR SUCURSALES ASIGNADAS ##########################-->
<?php if (isset($_GET['MuestraSucursalesAsignadas']) && isset($_GET['codespecialista']) && isset($_GET['gruposid'])): ?>

<?php 
$sucursal = new Login();
$suc = $sucursal->ListarSucursales();

if($suc==""){  

} else { ?>

<div class="row"> 
              
<?php
$a=1;
for($i=0;$i<sizeof($suc);$i++){ 
?>

    <div class="col-md-4 m-t-10">
        <div class="form-check">
            <div class="custom-control custom-radio">
                <input type="checkbox" class="custom-control-input" name="codsucursal[]" id="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>" value="<?php echo $suc[$i]['codsucursal'] ?>" <?php 

$explode = explode(", ", $_GET['gruposid']);

foreach($explode as $meschecked){

echo $meschecked == $suc[$i]['codsucursal'] ? "checked=\"checked\"":'';  } ?>>

                   <label class="custom-control-label" for="codsucursal_<?php echo $suc[$i]['codsucursal'] ?>">
                   <?php echo $suc[$i]['nomsucursal'] ?>
                   </label>
            </div>
        </div>
    </div>
                        <?php } ?>
                    </div> 
        <?php } ?>

<?php endif; ?>
<!--########################### LISTAR SUCURSALES ASIGNADAS ##########################-->

<?php 
########################## BUSCA ESPECIALISTAS POR SUCURSALES #############################
if (isset($_GET['BuscaEspecialistasxSucursal']) && isset($_GET['codsucursal'])) {
  
$especialista = $new->BuscarEspecialistasxSucursal();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($especialista);$i++){
    ?>
<option value="<?php echo $especialista[$i]['codespecialista']; ?>"><?php echo $especialista[$i]['cedespecialista'].": ".$especialista[$i]['nomespecialista']; ?></option>
    <?php 
   } 
}
############################# BUSCA ESPECIALISTAS POR SUCURSALES ##########################
?>








<?php 
######################## MUESTRA DIV PACIENTES ########################
if (isset($_GET['BuscaDivPaciente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Pacientes, el archivo Excel, debe estar estructurado de 26 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Paciente. (Ejemplo: P1, P2, P3, P4....)<br>
  2. Tipo de Documento. (Debera de Ingresar el Nº de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Primer Nombre.<br>
  5. Segundo Nombre.<br>
  6. Primer Apellido.<br>
  7. Segundo Apellido.<br>
  8. Fecha de Nacimiento.<br>
  9. Nº de Teléfono.<br>
  10. Correo Electronico.<br>
  11. Grupo Sanguineo.<br>
  12. Estado Civil.<br>
  13. Ocupación Laboral.<br>
  14. Sexo.<br>
  15. Enfoque Diferencial.<br>
  16. Departamento. (Debera de Ingresar el Nº de Departamento a la que corresponde)<br>
  17. Provincia. (Debera de Ingresar el Nº de Provincia a la que corresponde)<br>
  18. Dirección Domiciliaria.<br>
  19. Nombre de Acompañante.<br>
  20. Dirección de Acompañante.<br>
  21. Nº de Teléfono de Acompañante.<br>
  22. Parentesco de Acompañante.<br>
  23. Nombre de Responsable.<br>
  24. Dirección de Responsable.<br>
  25. Nº de Teléfono de Responsable.<br>
  26. Parentesco de Responsable.<br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a href="fotos/pacientes.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Pacientes, deben de ser cargados como se explica, para evitar problemas de datos del Paciente dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
######################## MUESTRA DIV PACIENTES ########################
?>

<?php
######################## MOSTRAR PACIENTES EN VENTANA MODAL ############################
if (isset($_GET['BuscaPacienteModal']) && isset($_GET['codpaciente'])) { 
$reg = $new->PacientesPorId();
?>

  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documpaciente'] == '0' ? "Documento" : $reg[0]['documento']; ?>:</strong> <?php echo $reg[0]['cedpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres:</strong> <?php echo $reg[0]['pnompaciente']." ".$reg[0]['snompaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Apellidos:</strong> <?php echo $reg[0]['papepaciente']." ".$reg[0]['sapepaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Nacimiento:</strong> <?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])); ?></td>
  </tr>
  <tr>
    <td><strong>Edad:</strong> <?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "*********" : edad($reg[0]['fnacpaciente'])." AÑOS"; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong> <?php echo $reg[0]['tlfpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electronico:</strong> <?php echo $reg[0]['emailpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Grupo Sanguineo:</strong> <?php echo $reg[0]['gruposapaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Estado Civil:</strong> <?php echo $reg[0]['estadopaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Ocupación Laboral:</strong> <?php echo $reg[0]['ocupacionpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Sexo:</strong> <?php echo $reg[0]['sexopaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Enfoque Diferencial:</strong> <?php echo $reg[0]['enfoquepaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento']; ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección Domiciliaria:</strong> <?php echo $reg[0]['direcpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Acompañante:</strong> <?php echo $reg[0]['nomacompana'] == '' ? "*********" : $reg[0]['nomacompana']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Acompañante:</strong> <?php echo $reg[0]['direcacompana'] == '' ? "*********" : $reg[0]['direcacompana']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono de Acompañante:</strong> <?php echo $reg[0]['tlfacompana'] == '' ? "*********" : $reg[0]['tlfacompana']; ?></td>
  </tr>
  <tr>
    <td><strong>Parentesco de Acompañante:</strong> <?php echo $reg[0]['parentescoacompana'] == '' ? "*********" : $reg[0]['parentescoacompana']; ?></td>
  </tr>

  <tr>
    <td><strong>Nombre de Responsable:</strong> <?php echo $reg[0]['nomresponsable'] == '' ? "*********" : $reg[0]['nomresponsable']; ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Responsable:</strong> <?php echo $reg[0]['direcresponsable'] == '' ? "*********" : $reg[0]['direcresponsable']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono de Responsable:</strong> <?php echo $reg[0]['tlfresponsable'] == '' ? "*********" : $reg[0]['tlfresponsable']; ?></td>
  </tr>
  <tr>
    <td><strong>Parentesco de Responsable:</strong> <?php echo $reg[0]['parentescoresponsable'] == '' ? "*********" : $reg[0]['parentescoresponsable']; ?></td>
  </tr>
</table>  

  <?php
   } 
######################## MOSTRAR PACIENTES EN VENTANA MODAL ############################
?>


















<?php 
############################# MUESTRA DIV PROVEEDOR #############################
if (isset($_GET['BuscaDivProveedor'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Proveedores, el archivo Excel, debe estar estructurado de 11 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Proveedor. (Ejemplo: P1, P2, P3, P4, P5......)<br>
  2. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Nombre de Proveedor (Ingresar Nombre de Proveedor).<br>
  5. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  7. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  6. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  8. Dirección de Proveedor.<br>
  9. Correo Electronico.<br>
  10. Nombre de Vendedor.<br>
  11. Nº de Teléfono de Vendedor. (Formato: (9999) 9999999).<br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a href="fotos/proveedores.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Proveedores, deben de ser cargados como se explica, para evitar problemas de datos del Proveedor dentro del Sistema.<br><br>
   </div>
</div>
<?php 
  }
############################ MUESTRA DIV PROVEEDOR #############################
?>

<?php
########################### MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $new->ProveedoresPorId();
?>
  
  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "Documento" : $reg[0]['documento'] ?>:</strong> <?php echo $reg[0]['cuitproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres de Proveedor:</strong> <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono: </strong> <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Departamento: </strong> <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td><strong>Provincia: </strong> <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td><strong>Dirección de Proveedor: </strong> <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Correo Electrónico: </strong> <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr> 
  <tr>
    <td><strong>Vendedor: </strong> <?php echo $reg[0]['vendedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Ingreso: </strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
?>



























<?php 
########################### BUSQUEDA DE SERVICIOS POR SUCURSAL ##########################
if (isset($_GET['BuscaServiciosxSucursal']) && isset($_GET['codsucursal'])) { 

$codsucursal = limpiar($_GET['codsucursal']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {
  
$reg = $new->ListarServicios();   
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios de la Sucursal <?php echo $reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("SERVICIOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table2 table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
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
                                                    <th><i class="mdi mdi-drag-horizontal"></i></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['servicio']; ?></td>
              <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".$reg[$i]['preciocompra']; ?></td>
              <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".$reg[$i]['precioventa']; ?></td>
              <td><?php echo $reg[$i]['moneda2'] == '' ? "*****" : "<strong>".$reg[$i]['simbolo2']."</strong> ".$moneda; ?></td>
              <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                                              <td><?php echo $reg[$i]['descservicio']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
                                               <td>
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerServicio('<?php echo encrypt($reg[$i]["codservicio"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE SERVICIOS POR SUCURSAL ##########################
?>

<?php 
############################# MUESTRA DIV SERVICIO #############################
if (isset($_GET['BuscaDivServicio'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Servicios, el archivo Excel, debe estar estructurado de 9 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br>

  1. Código de Servicio. (Ejemplo: S1, S2, S3, S4, S5......)<br>
  2. Nombre de Servicio.<br>
  3. Precio Compra. (Numeros con 2 decimales).<br>
  4. Precio Venta. (Numeros con 2 decimales).<br>
  5. <?php echo $impuesto; ?> de Servicio. (Ejem. SI o NO).<br>
  6. Descuento de Servicio. (Numeros con 2 decimales).<br>
  7. Status. (Activo = 1 / Inactivo = 0).<br>
  8. Código de Sucursal.<br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a href="fotos/servicios.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Servicios, deben de ser cargados como se explica, para evitar problemas de datos del Servicio dentro del Sistema.<br><br>
   </div>
</div>
<?php 
  }
############################ MUESTRA DIV SERVICIO #############################
?>

<?php
########################### MOSTRAR SERVICIO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaServicioModal']) && isset($_GET['codservicio']) && isset($_GET['codsucursal'])) { 

$reg = $new->ServiciosPorId();
?>
  
  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codservicio']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres de Servicio:</strong> <?php echo $reg[0]['servicio']; ?></td>
  </tr>
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta: </strong> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $reg[0]['moneda2'] == '' ? "**********" : "Precio ".$reg[0]['siglas2']; ?>: </strong> 
      <?php echo $moneda = (empty($reg[0]['montocambio']) ? "0.00" : number_format($reg[0]['precioventa'] / $reg[0]['montocambio'], 2, '.', ',')); ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo $reg[0]['descservicio']."%"; ?></td>
  </tr> 
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['status'] = 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>

<?php if ($_SESSION['acceso'] == "administradorG") { ?>
    <tr>
    <td><strong>Sucursal: </strong> <?php echo $reg[0]['nomsucursal']; ?></td>  
    </tr>
<?php } ?>
</table>
<?php 
} 
########################## MOSTRAR SERVICIO EN VENTANA MODAL ##########################
?>

<?php 
########################### BUSQUEDA DE SERVICIOS VENDIDOS ##########################
if (isset($_GET['BuscaServiciosVendidos']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarServiciosVendidos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios Vendidos por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Servicio</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codservicio']; ?></td>
                      <td><?php echo $reg[$i]['servicio']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE SERVICIOS VENDIDOS ##########################
?>


<?php 
########################### BUSQUEDA DE SERVICIOS VENDIDOS POR VENDEDOR ##########################
if (isset($_GET['BuscaServiciosxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarServiciosxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios Vendidos por Vendedor y Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("SERVICIOSXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Servicio</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codservicio']; ?></td>
                      <td><?php echo $reg[$i]['servicio']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE SERVICIOS VENDIDOS POR VENDEDOR ##########################
?>


<?php 
########################### BUSQUEDA DE SERVICIOS POR MONEDA ##########################
if (isset($_GET['BuscaServiciosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
  
$reg = $new->ListarServicios();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Servicios al Cambio de Moneda</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SERVICIOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Moneda de Cambio: </label> <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?>
        </div>
      </div>

          <div id="div3"><table id="datatable-responsive" class="table2 table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr>
                                                    <th>N°</th>
                                                    <th>Descripción de Servicio</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc</th>
                                                    <th>Status</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th>Precio <?php echo $cambio[0]['siglas']; ?></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

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
                              <tr>
                              <td><?php echo $a++; ?></td>
                              <td><?php echo $reg[$i]['servicio']; ?></td>
              <td><?php echo $reg[$i]['ivaservicio'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                              <td><?php echo $reg[$i]['descservicio']; ?></td>
<td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
              <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
              <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
              <td><?php echo $simbolo2.$moneda; ?></td>
                                               </tr>
                                                <?php } ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMoneda, 2, '.', ','); ?></strong></td>
                      </tr>
        <?php } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE SERVICIOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR SERVICIO ########################
if (isset($_GET['BuscaKardexServicio']) && isset($_GET['codsucursal']) && isset($_GET['codservicio'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codservicio = limpiar($_GET['codservicio']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codservicio=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL SERVICIO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {

$detalle = new Login();
$detalle = $detalle->DetalleKardexServicio();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexServicio();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos por Servicio</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codservicio=<?php echo $codservicio; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
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
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo $kardex[$i]['entradas']; ?></td>
                                  <td><?php echo $kardex[$i]['salidas']; ?></td>
                                  <td><?php echo $kardex[$i]['devolucion']; ?></td>
                                  <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
                                  <td><?php echo $kardex[$i]['descproducto']; ?></td>
                                  <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo $simbolo.number_format($PrecioFinal*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo $kardex[$i]['documento']; ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <strong>Detalles de Servicio</strong><br>
          <strong>Código:</strong> <?php echo $detalle[0]['codservicio']; ?><br>
          <strong>Descripción:</strong> <?php echo $detalle[0]['servicio']; ?><br>
          <strong>Total Entradas:</strong> <?php echo $TotalEntradas; ?><br>
          <strong>Total Salidas:</strong> <?php echo $TotalSalidas; ?><br>
          <strong>Total Devolución:</strong> <?php echo $TotalDevolucion; ?><br>
          <strong>Precio Compra:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
          <strong>Precio Venta:</strong> <?php echo $simbolo.$detalle[0]['precioventa']; ?>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR SERVICIO ########################
?>


<?php 
########################### BUSQUEDA KARDEX SERVICIOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaKardexServiciosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarKardexServiciosValorizadoxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Servicios Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("KARDEXSERVICIOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXSERVICIOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción de Servicio</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio Compra</th>
                                  <th>Precio Venta</th>
                                  <th>Vendido</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="5"></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX SERVICIOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>





























<?php 
########################### BUSQUEDA DE PRODUCTOS POR SUCURSAL ##########################
if (isset($_GET['BuscaProductosxSucursal']) && isset($_GET['codsucursal'])) { 

$codsucursal = limpiar($_GET['codsucursal']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {
  
$reg = $new->ListarProductos();   

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos de la Sucursal <?php echo $reg[0]['nomsucursal']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
              <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                  <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOSMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOSMAXIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Máximo</a>

                  </div>
              </div> 

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table2 table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
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
                                                    <th><?php echo $impuesto; ?> </th>
                                                    <th>Descto</th>
                                                    <th>Elab.</th>
                                                    <th>Exp.</th>
                                                    <th><i class="mdi mdi-drag-horizontal"></i></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 
if($reg==""){ 

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ','));  
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['codproducto']; ?></td>
              <td><?php echo $reg[$i]['producto']; ?></td>
              <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
              <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
              <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
              <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
              <td><?php echo "<strong>".$reg[$i]['simbolo']."</strong> ".number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
              <td><?php echo $reg[$i]['moneda2'] == '' ? "*****" : "<strong>".$reg[$i]['simbolo2']."</strong> ".$moneda; ?></td>
                      
              <td><?php echo $reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? "<span class='badge badge-pill badge-danger2'>".$reg[$i]['existencia']."</span>" : "<span class='badge badge-pill badge-info'>".$reg[$i]['existencia']."</span>"; ?></td>
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
<button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
 </td>
                                               </tr>
                                                <?php } } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS POR SUCURSAL ##########################
?>

<?php 
############################# MUESTRA DIV PRODUCTO ############################
if (isset($_GET['BuscaDivProducto'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"><strong> Para poder realizar la Carga Masiva de Productos, el archivo Excel, debe estar estructurado de 17 columnas, la cuales tendrán las siguientes especificaciones:</strong></font><br><br>

  1. Código de Producto (Ejem. 0001).<br>
  2. Nombre de Producto.<br>
  3. Marca de Producto (Deberá ingresar el Nº de Marca a la que corresponde o colocar Cero (0))<br>
  4. Presentación (Deberá ingresar el Nº de Presentación a la que corresponde o colocar Cero (0))<br>
  5. Unidad de Medida (Deberá ingresar el Nº de Medida a la que corresponde o colocar Cero (0)e).<br>
  6. Lote de Producto (En caso de no tener colocar Cero (0)).<br>
  7. Precio Compra. (Numeros con 2 decimales).<br>
  8. Precio Venta. (Numeros con 2 decimales).<br>
  9. Existencia. (Debe de ser solo enteros).<br>
  10. Stock Minimo. (Debe de ser solo enteros).<br>
  11. Stock Máximo. (Debe de ser solo enteros).<br>
  12. <?php echo $impuesto; ?> de Producto. (Ejem. SI o NO).<br>
  13. Descuento de Producto. (Numeros con 2 decimales).<br>
  14. Fecha de Elaboración. (Formato: 0000-00-00).<br>
  15. Fecha de Expiración. (Formato: 0000-00-00).<br>
  16. Proveedor. (Debe de verificar a que codigo pertenece el Proveedor existente).<br>
  17. Código de Sucursal.<br><br>

  <font color="red"><strong> NOTA:</strong></font><br>
  a) El Archivo no debe de tener cabecera, solo deben estar los registros a grabar.<br>
  b) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  c) Descargar Plantilla <a href="fotos/productos.csv">AQUI</a>. (La Cabecera deberá de ser eliminada al momento de hacer la Carga Masiva)<br>
  d) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  e) Deben de tener en cuenta que la carga masiva de Productos, deben de ser cargados como se explica, para evitar problemas de datos del Producto dentro del Sistema.<br><br>
    </div>
</div>                                 
<?php 
  }
############################# MUESTRA DIV PRODUCTO #############################
?>

<?php
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId();  
?>
  
  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td><strong>Producto:</strong> <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
  <td><strong>Proveedor: </strong><?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td><strong>Marca: </strong> <?php echo $reg[0]['nommarca']; ?></td>
  </tr>
  <tr>
    <td><strong>Presentación: </strong> <?php echo $reg[0]['codpresentacion'] == '0' ? "*********" : $reg[0]['nompresentacion']; ?></td>
  </tr> 
  <tr>
    <td><strong>Unidad de Medida: </strong> <?php echo $reg[0]['codmedida'] == '0' ? "*********" : $reg[0]['nommedida']; ?></td>
  </tr> 
  <tr>
    <td><strong>Nº de Lote: </strong> <?php echo $reg[0]['lote'] == '' ? "*********" : $reg[0]['lote']; ?></td>
  </tr>  
  <tr>
    <td><strong>Precio de Compra: </strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
  </tr> 
  <tr>
    <td><strong>Precio de Venta: </strong> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong><?php echo $reg[0]['moneda2'] == '' ? "**********" : "Precio ".$reg[0]['siglas2']; ?>: </strong> 
      <?php echo $moneda = (empty($reg[0]['montocambio']) ? "0.00" : number_format($reg[0]['precioventa'] / $reg[0]['montocambio'], 2, '.', ',')); ?></td>
  </tr>
  <tr>
    <td><strong>Existencia: </strong> <?php echo $reg[0]['existencia']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Minimo: </strong> <?php echo $reg[0]['stockminimo'] == '0' ? "*********" : $reg[0]['stockminimo']; ?></td>
  </tr> 
  <tr>
    <td><strong>Stock Máximo: </strong> <?php echo $reg[0]['stockmaximo'] == '0' ? "*********" : $reg[0]['stockmaximo']; ?></td>
  </tr> 
  <tr>
    <td><strong><?php echo $impuesto; ?>: </strong> <?php echo $reg[0]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td><strong>Descuento: </strong> <?php echo $reg[0]['descproducto']."%"; ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Elaboración: </strong> <?php echo $reg[0]['fechaelaboracion'] == '' || $reg[0]['fechaexpiracion'] == '0000-00-00' ? "********" : "<span class='badge badge-pill badge-dark'>".date("d-m-Y",strtotime($reg[0]['fechaelaboracion']))."</span>"; ?></td>
  </tr> 
  <tr>
    <td><strong>Fecha de Expiración: </strong> <?php if($reg[0]['fechaexpiracion'] == '' || $reg[0]['fechaexpiracion'] == '0000-00-00'){ echo "********"; } elseif($reg[0]['fechaexpiracion'] != "0000-00-00" && date("Y-m-d") >= $reg[0]['fechaexpiracion']){ echo "<span class='badge badge-pill badge-purple'>".date("d-m-Y",strtotime($reg[0]['fechaexpiracion']))."</span>"; } else { echo "<span class='badge badge-pill badge-success'>".date("d-m-Y",strtotime($reg[0]['fechaexpiracion']))."</span>"; } ?></td>
  </tr>
  <tr>
    <td><strong>Status: </strong> <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-pill badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>

<?php if ($_SESSION['acceso'] == "administradorG") { ?>
    <tr>
    <td><strong>Sucursal: </strong> <?php echo $reg[0]['nomsucursal']; ?></td>  
    </tr>
<?php } ?>

</table>
<?php 
} 
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS VENDIDOS ##########################
if (isset($_GET['BuscaProductosVendidos']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosVendidos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Vendidos por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS VENDIDOS ##########################
?>


<?php 
########################### BUSQUEDA DE PRODUCTOS VENDIDOS POR VENDEDOR ##########################
if (isset($_GET['BuscaProductosxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Vendidos por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['precioventa']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS VENDIDOS POR VENDEDOR ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
if (isset($_GET['BuscaProductosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
  
$reg = $new->ListarProductos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos al Cambio de Moneda</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Moneda de Cambio: </label> <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?>
        </div>
      </div>

          <div id="div3"><table id="datatable-responsive" class="table2 table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                                 <thead>
                                                 <tr role="row">
                                                    <th>N°</th>
                                                    <th>Código</th>
                                                    <th>Nombre de Producto</th>
                                                    <th>Marca</th>
                                                    <th>Presentación</th>
                                                    <th>Medida</th>
                                                    <th><?php echo $impuesto; ?></th>
                                                    <th>Desc</th>
                                                    <th>Precio Compra</th>
                                                    <th>Precio Venta</th>
                                                    <th>Precio <?php echo $cambio[0]['siglas']; ?></th>
                                                 </tr>
                                                 </thead>
                                                 <tbody class="BusquedaRapida">

<?php 

if($reg==""){ 

} else {
 
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0; 
for($i=0;$i<sizeof($reg);$i++){
$TotalCompra+=$reg[$i]['preciocompra'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

$TotalVenta+=$reg[$i]['precioventa'];
$TotalMoneda+=(empty($reg[$i]['montocambio']) ? "0.00" : number_format($PrecioFinal / $reg[$i]['montocambio'], 2, '.', ','));
$moneda = (empty($cambio[0]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $cambio[0]['montocambio'], 2, '.', ',')); 

$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
$simbolo2 = ($cambio[0]['simbolo'] == "" ? "" : "<strong>".$cambio[0]['simbolo']."</strong> "); 
?>
                                               <tr role="row" class="odd">
                                               <td><?php echo $a++; ?></td>
                                               <td><?php echo $reg[$i]['codproducto']; ?></td>
                                               <td><?php echo $reg[$i]['producto']; ?></td>
                                               <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?></td>
                      <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
                      <td><?php echo $simbolo.$reg[$i]['precioventa']; ?></td>
                      <td><?php echo $simbolo2.$moneda; ?></td>
                                               </tr>
                            <?php } ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($TotalCompra, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $simbolo2.number_format($TotalMoneda, 2, '.', ','); ?></strong></td>
                      </tr>
                    <?php } ?>
                                            </tbody>
                                     </table>
                         </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codsucursal']) && isset($_GET['codproducto'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codproducto = limpiar($_GET['codproducto']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codproducto=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {

$detalle = new Login();
$detalle = $detalle->DetalleKardexProducto();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos por Producto</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
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
                              <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $kardex[$i]['movimiento']; ?></td>
                                  <td><?php echo $kardex[$i]['entradas']; ?></td>
                                  <td><?php echo $kardex[$i]['salidas']; ?></td>
                                  <td><?php echo $kardex[$i]['devolucion']; ?></td>
                                  <td><?php echo number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
                          <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
                          <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
                          <?php } else { ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
                          <?php } ?>
                                  <td><?php echo $kardex[$i]['stockactual']; ?></td>
                                  <td><?php echo $kardex[$i]['documento']; ?></td>
                                  <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <strong>Detalles de Producto</strong><br>
          <strong>Código:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
          <strong>Descripción:</strong> <?php echo $detalle[0]['producto']; ?><br>
          <strong>Marca:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
          <strong>Presentación:</strong> <?php echo $detalle[0]['codpresentacion'] == '0' ? "*********" : $detalle[0]['nompresentacion']; ?><br>
          <strong>Unidad de Medida:</strong> <?php echo $detalle[0]['codmedida'] == '0' ? "**********" : $detalle[0]['nommedida']; ?><br>
          <strong>Total Entradas:</strong> <?php echo $TotalEntradas; ?><br>
          <strong>Total Salidas:</strong> <?php echo $TotalSalidas; ?><br>
          <strong>Total Devolución:</strong> <?php echo $TotalDevolucion; ?><br>
          <strong>Existencia:</strong> <?php echo $detalle[0]['existencia']; ?><br>
          <strong>Precio Compra:</strong> <?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ',') : "**********"); ?><br>
          <strong>Precio Venta:</strong> <?php echo $simbolo.$detalle[0]['precioventa']; ?>
            </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
######################## BUSQUEDA DE KARDEX POR PRODUCTOS ########################
?>

<?php 
########################### BUSQUEDA KARDEX VALORIZADO POR SUCURSAL ##########################
if (isset($_GET['BuscaKardexProductosValorizado']) && isset($_GET['codsucursal'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->ListarKardexProductosValorizado();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Valorizado por Sucursal</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>N°</th>
                                  <th>Código</th>
                                  <th>Nombre de Producto</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio Compra</th>
                                  <th>Precio Venta</th>
                                  <th>Existencia</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $valor."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['existencia']; ?></td>
                      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['existencia'], 2, '.', ','); ?></td>
                      <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['existencia'], 2, '.', ',') : "**********"); ?></td>
                      <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $ExisteTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX VALORIZADO POR SUCURSAL ##########################
?>

<?php 
########################### BUSQUEDA KARDEX VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaKardexProductosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarKardexProductosValorizadoxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Kardex Valorizado por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>N°</th>
                                  <th>Código</th>
                                  <th>Nombre de Producto</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio Compra</th>
                                  <th>Precio Venta</th>
                                  <th>Vendido</th>
                                  <th>Total Venta</th>
                                  <th>Total Compra</th>
                                  <th>Ganancias</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                      <td><?php echo $a++; ?></div></td>
                      <td><?php echo $reg[$i]['codproducto']; ?></td>
                      <td><?php echo $reg[$i]['producto']; ?></td>
                      <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
                      <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "**********" : $reg[$i]['nompresentacion']; ?></td>
                      <td><?php echo $reg[$i]['codmedida'] == '0' ? "**********" : $reg[$i]['nommedida']; ?></td>
                      <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? $reg[$i]['iva']."%" : "(E)"; ?></td>
                      <td><?php echo $reg[$i]['descproducto']; ?>%</td>
                      <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ',') : "**********"); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
                      <td><?php echo $reg[$i]['cantidad']; ?></td>
                      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($reg[$i]['preciocompra']*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
                      <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($PrecioCompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $VendidosTotal; ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
                        <td><strong><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $simbolo.number_format($CompraTotal, 2, '.', ',') : "**********"); ?></strong></td>
                        <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA KARDEX VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>































<?php
######################## MOSTRAR TRASPASO EN VENTANA MODAL ########################
if (isset($_GET['BuscaTraspasoModal']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
              <div class="col-md-12">
                <div class="pull-left">
                    <address>
  <h4><b class="text-dark">SUCURSAL ENVIA</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>
  <br/>DIREC: <?php echo $reg[0]['id_provincia'] == '0' ? "" : $reg[0]['provincia']; ?> <?php echo $reg[0]['id_departamento'] == '' ? "" : $reg[0]['departamento']; ?> <?php echo $reg[0]['direcsucursal'] == '' ? "*********" : $reg[0]['direcsucursal']; ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal'] == '' ? "**********" : $reg[0]['correosucursal']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/> <?php echo $reg[0]['nomencargado']; ?></p>

  <h4><b class="text-dark">TRASPASO Nº <?php echo $reg[0]['codtraspaso']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  <br/> OBSERVACIONES: <?php echo $reg[0]['observaciones'] == "" ? "**********" : $reg[0]['observaciones']; ?></p>
                    </address>
                </div>

                <div class="pull-right text-right">
                  <address>
  <h4><b class="text-dark">SUCURSAL RECIBE</b></h4>
                    <p class="text-muted m-l-30"><?php echo $reg[0]['nomsucursal2']; ?>
                      <br/>DIREC: <?php echo $reg[0]['id_provincia2'] == '0' ? "" : $reg[0]['provincia2']; ?> <?php echo $reg[0]['id_departamento2'] == '' ? "" : $reg[0]['departamento2']; ?> <?php echo $reg[0]['direcsucursal2'] == '' ? "*********" : $reg[0]['direcsucursal2']; ?>
                      <br/> EMAIL: <?php echo $reg[0]['correosucursal2'] == '' ? "**********" : $reg[0]['correosucursal2']; ?>
                      <br/> Nº <?php echo $reg[0]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[0]['documento2'] ?>: <?php echo $reg[0]['cuitsucursal2']; ?> - TLF: <?php echo $reg[0]['tlfsucursal2']; ?>
                      <br/> <?php echo $reg[0]['nomencargado2']; ?></p>

                    </address>
                  </div>
              </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
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
$detalle = $tra->VerDetallesTraspasos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == "" ? "******" : $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['nommedida'] == "" ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>
      <td><?php echo $detalle[$i]['cantidad']; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleTraspasoModal('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESTRASPASOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['descontado'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[0]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################## MOSTRAR TRASPASO EN VENTANA MODAL ########################
?>

<?php
######################### MOSTRAR DETALLES DE TRASPASOS UPDATE ##########################
if (isset($_GET['MuestraDetallesTraspasoUpdate']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();

?>

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
$detalle = $tra->VerDetallesTraspasos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
$simbolo = "<strong>".$reg[0]['simbolo']."</strong>";
?>
                <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoTraspaso(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantidad"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadbd[]" id="cantidadbd" value="<?php echo $detalle[$i]["cantidad"]; ?>">
      <input type="hidden" name="coddetalletraspaso[]" id="coddetalletraspaso" value="<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo encrypt($detalle[$i]["codproducto"]); ?>">
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
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetallesTraspasoUpdate('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[0]["recibe"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESTRASPASOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
<?php
  } 
######################### MOSTRAR DETALLES DE TRASPASOS UPDATE ##########################
?>

<?php
########################## BUSQUEDA TRASPASOS POR SUCURSAL ##########################
if (isset($_GET['BuscaTraspasosxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxSucursal();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos por Sucursal </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXSUCURSAL") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?>
      
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Traspaso</th>
                                  <th>Sucursal que Recibe</th>
                                  <th>Nº de Articulos</th>
                                  <th>Fecha Trapasos</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['sumarticulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codtraspaso']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
    <td><?php echo $reg[$i]['sumarticulos']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA TRASPASOS POR SUCURSAL ##########################
?>

<?php
########################## BUSQUEDA TRASPASOS POR FECHAS ##########################
if (isset($_GET['BuscaTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Traspaso</th>
                                  <th>Sucursal que Recibe</th>
                                  <th>Nº de Articulos</th>
                                  <th>Fecha Trapasos</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['sumarticulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codtraspaso']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
    <td><?php echo $reg[$i]['sumarticulos']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA TRASPASOS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
if (isset($_GET['BuscaProductoTraspasos']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarProductosTraspasos();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Productos Traspasos </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSTRASPASOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSTRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSTRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="text-center">
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Traspasado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><?php echo $ExisteTotal; ?></td>
                        <td><?php echo $VendidosTotal; ?></td>
                        <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
?>






























<?php
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCompraPagadaModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
      elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "**********************" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "**********************" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "**********************" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "**********************" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
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
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['codmedida'] == 0 ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleCompraPagadaModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['ivac'], 2, '.', '') ?>%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ','); ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['descontadoc'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuentoc'], 2, '.', '') ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
?>

<?php
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
if (isset($_GET['BuscaCompraPendienteModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/>Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº COMPRA <?php echo $reg[0]['codcompra']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
      elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "**********************" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "**********************" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "**********************" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "**********************" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                              <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
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
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['codmedida'] == 0 ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>
      <td><?php echo $detalle[$i]['cantcompra']; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['preciocomprac'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproductoc'] == 'SI' ? number_format($reg[0]['ivac'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleCompraPendienteModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['ivac'], 2, '.', '') ?>%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivasic'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivanoc'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['ivac'], 2, '.', ','); ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalivac'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['descontadoc'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuentoc'], 2, '.', '') ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaldescuentoc'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalpagoc'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL ######################
?>


<?php
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
if (isset($_GET['MuestraDetallesCompraUpdate']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();

?>

<div class="table-responsive m-t-20">
            <table class="table2 table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio Unit.</th>
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
$detalle = $tra->VerDetallesCompras();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){ 
$simbolo = "<strong>".$reg[0]['simbolo']."</strong>"; 
?>
                                 <tr>
      <td>
      <input type="text"step="0.01" min="0.50" class="form-control cantidad bold" name="cantcompra[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo $detalle[$i]["cantcompra"]; ?>" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" required="" aria-required="true">
      <input type="hidden" name="cantidadcomprabd[]" id="cantidadcomprabd" value="<?php echo $detalle[$i]["cantcompra"]; ?>">
      </td>
      
      <td>
      <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo $detalle[$i]["coddetallecompra"]; ?>">
      <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
      <?php echo $detalle[$i]['codproducto']; ?>
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
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleCompraUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
            </div>

            <hr>

            <div class="row">

                <!-- .col -->
                <div class="col-md-6">
                    <h3 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cash-multiple"></i> Métodos de Pago</h3><hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                                <br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="contado" value="CONTADO" <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CONTADO") { ?> checked="checked" <?php } else { ?> checked="checked" disabled="" <?php } ?> onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="contado">CONTADO</label>
                                </div><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="tipocompra" id="credito" value="CREDITO" <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CREDITO") { ?> checked="checked" disabled="" <?php } ?> onclick="CargaCondicionesPagos();" class="custom-control-input">
                                <label class="custom-control-label" for="credito">CRÉDITO</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6"> 
                            <div class="form-group has-feedback"> 
                                <label class="control-label">Método de Pago: <span class="symbol required"></span></label>
                                <i class="fa fa-bars form-control-feedback"></i>
                                <?php if (isset($reg[0]['formacompra'])) { ?>
                                <select name="formacompra" id="formacompra" class="form-control" <?php if($reg[0]['tipocompra'] == 'CREDITO'){ ; ?> disabled="" <?php } ?> required="" aria-required="true">
                                    <option value=""> -- SELECCIONE -- </option>
                                    <option value="EFECTIVO"<?php if (!(strcmp('EFECTIVO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>EFECTIVO</option>
                                    <option value="CHEQUE"<?php if (!(strcmp('CHEQUE', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>CHEQUE</option>
                                    <option value="TARJETA DE CREDITO"<?php if (!(strcmp('TARJETA DE CREDITO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA DE CRÉDITO</option>
                                    <option value="TARJETA DE DEBITO"<?php if (!(strcmp('TARJETA DE DEBITO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA DE DÉBITO</option>
                                    <option value="TARJETA PREPAGO"<?php if (!(strcmp('TARJETA PREPAGO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TARJETA PREPAGO</option>
                                    <option value="TRANSFERENCIA"<?php if (!(strcmp('TRANSFERENCIA', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>TRANSFERENCIA</option>
                                    <option value="DINERO ELECTRONICO"<?php if (!(strcmp('DINERO ELECTRONICO', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>DINERO ELECTRÓNICO</option>
                                    <option value="CUPON"<?php if (!(strcmp('CUPON', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>CUPÓN</option>
                                    <option value="OTROS"<?php if (!(strcmp('OTROS', $reg[0]['formacompra']))) { echo "selected=\"selected\"";} ?>>OTROS</option>
                                </select>
                                <?php } else { ?>
                                <select name="formacompra" id="formacompra" class="form-control" required="" aria-required="true">
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
                                <?php } ?>
                            </div> 
                        </div>
                    </div>

                    <div id="muestra_metodo"><!-- metodo de pago -->

                     <?php if (isset($reg[0]['tipocompra']) && $reg[0]['tipocompra'] == "CREDITO") { ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-feedback">
                                <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label>
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
<?php
  } 
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
?>


<?php
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
if (isset($_GET['BuscaComprasxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Tipo</th>
                              <th>Método</th>
                              <th>Fecha Emis.</th>
                              <th>Fecha Recep.</th>
                              <th>Nº Articulos</th>
                              <th>SubTotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc.</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
                    <td><?php echo $reg[$i]['tipocompra']; ?></td>
                    <td><?php echo $reg[$i]['formacompra']; ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
                    <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
?>


<?php
######################### BUSQUEDA COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Nombre de Proveedor</th>
                              <th>Tipo</th>
                              <th>Método</th>
                              <th>Fecha Emis.</th>
                              <th>Fecha Recep.</th>
                              <th>Nº Articulos</th>
                              <th>SubTotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc.</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'];
$TotalImpuesto+=$reg[$i]['totalivac'];
$TotalDescuento+=$reg[$i]['totaldescuentoc'];
$TotalImporte+=$reg[$i]['totalpagoc'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
<td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
                    <td><?php echo $reg[$i]['tipocompra']; ?></td>
                    <td><?php echo $reg[$i]['formacompra']; ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
                    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
                    <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasic']+$reg[$i]['subtotalivanoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalivac'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivac'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuentoc'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COMPRAS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA CREDITOS POR PROVEEDOR ##########################
if (isset($_GET['BuscaCreditosxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos de Compras por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha Emis.</th>
                              <th>Fecha Recep.</th>
                              <th>Nº Articulos</th>
                              <th>Imp. Total</th>
                              <th>Total Abono</th>
                              <th>Total Debe</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
      
      <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-warning btn-rounded" title="Imprimir Abonos"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR PROVEEDOR ##########################
?>


<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i>  Créditos de Compras por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

       <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Compra</th>
                              <th>Nombre de Proveedor</th>
                              <th>Status</th>
                              <th>Dias Venc.</th>
                              <th>Fecha Emis.</th>
                              <th>Fecha Recep.</th>
                              <th>Nº Articulos</th>
                              <th>Imp. Total</th>
                              <th>Total Abono</th>
                              <th>Total Debe</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcompra']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      
      <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
      elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

      <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>
     
      <td><?php echo $reg[$i]['articulos']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpagoc']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-warning btn-rounded" title="Imprimir Abonos"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo $TotalArticulos; ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
?>































<?php
######################## MOSTRAR COTIZACION EN VENTANA MODAL ########################
if (isset($_GET['BuscaCotizacionModal']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº DE COTIZACIÓN <?php echo $reg[0]['codcotizacion']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechacotizacion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PACIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcpaciente'] == '' ? "*********" : $reg[0]['direcpaciente']; ?> <?php echo $reg[0]['departamento2'] == '' ? "*********" : strtoupper($reg[0]['departamento2']); ?> <?php echo $reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2']; ?> 
  <br/> Nº <?php echo $reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cedpaciente']; ?> - TLF: <?php echo $reg[0]['tlfpaciente'] == '' ? "******" : $reg[0]['tlfpaciente']; ?></p>

  <h4><b class="text-danger">ESPECIALISTA</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomespecialista'].", ".$reg[0]['especialidad']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcespecialista'] == '' ? "*********" : $reg[0]['direcespecialista']; ?> <?php echo $reg[0]['departamento3'] == '' ? "*********" : strtoupper($reg[0]['departamento3']); ?> <?php echo $reg[0]['provincia3'] == '' ? "*********" : $reg[0]['provincia3']; ?> 
  <br/> Nº <?php echo $reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4'] ?>: <?php echo $reg[0]['cedespecialista']; ?> - TLF: <?php echo $reg[0]['tlfespecialista'] == '' ? "******" : $reg[0]['tlfespecialista']; ?></p>
                                           
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
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

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == "" ? "******" : $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['nommedida'] == "" ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleCotizacionModal('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[0]["codpaciente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['descontado'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[0]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################## MOSTRAR COTIZACION EN VENTANA MODAL ########################
?>


<?php
######################### MOSTRAR DETALLES DE COTIZACION UPDATE ##########################
if (isset($_GET['MuestraDetallesCotizacionUpdate']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();

?>

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
                            <td><?php echo $simbolo; ?>  <label id="lblexento" name="lblexento"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label>
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
                            <td><?php echo $simbolo; ?>  <label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?></label></td>
                            <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?>"/>
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
<?php
  } 
######################### MOSTRAR DETALLES DE COTIZACION UPDATE ##########################
?>

<?php
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Cotización</th>
                                  <th>Descripción de Especialista</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA COTIZACIONES POR ESPECIALISTA ##########################
if (isset($_GET['BusquedaCotizacionesxEspecialista']) && isset($_GET['codsucursal']) && isset($_GET['codespecialista'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codespecialista = limpiar($_GET['codespecialista']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codespecialista=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL ESPECIALISTA CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxEspecialista();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Especialista </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&tipo=<?php echo encrypt("COTIZACIONESXESPECIALISTA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']); ?> de Especialista: </label> <?php echo $reg[0]['cedespecialista']; ?><br>

            <label class="control-label">Nombre de Especialista: </label> <?php echo $reg[0]['nomespecialista']; ?><br>

        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Cotización</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
  
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COTIZACIONES POR ESPECIALISTA ##########################
?>


<?php
########################## BUSQUEDA COTIZACIONES POR PACIENTE ##########################
if (isset($_GET['BusquedaCotizacionesxPaciente']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxPaciente();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Paciente </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&tipo=<?php echo encrypt("COTIZACIONESXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>

        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Cotización</th>
                                  <th>Descripción de Especialista</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codcotizacion']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOTIZACION") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA COTIZACIONES POR PACIENTE ##########################
?>


<?php
########################## BUSQUEDA PRODUCTOS COTIZADOS ##########################
if (isset($_GET['BuscaProductoCotizados']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarProductosCotizados();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Cotizados por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSCOTIZADOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="text-center">
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><?php echo $ExisteTotal; ?></td>
                        <td><?php echo $VendidosTotal; ?></td>
                        <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA PRODUCTOS COTIZADOS ##########################
?>

<?php
########################## BUSQUEDA PRODUCTOS COTIZADOS POR VENDEDOR ##########################
if (isset($_GET['BuscaCotizacionesxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codigo = limpiar($_GET['codigo']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
} else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxVendedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Cotizados por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZADOSXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZADOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZADOSXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="text-center">
                                  <th>Nº</th>
                                  <th>Código</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Presentación</th>
                                  <th>Medida</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc</th>
                                  <th>Precio de Venta</th>
                                  <th>Existencia</th>
                                  <th>Cotizado</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
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
                        <?php  }  ?>
                      <tr>
                        <td colspan="8"></td>
                        <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
                        <td><?php echo $ExisteTotal; ?></td>
                        <td><?php echo $VendidosTotal; ?></td>
                        <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
                      </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA PRODUCTOS COTIZADOS POR VENDEDOR ##########################
?>




































<?php
############################# MOSTRAR CITAS ODONTOLOGICAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaCitaModal']) && isset($_GET['codcita'])) { 

$reg = $new->CitasPorId();

?>
  
  <div class="row">
  <table border="0">
  <tr>
    <td><strong>Nº de <?php echo $documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Especialista:</strong> <?php echo $reg[0]['cedespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Especialista:</strong> <?php echo $reg[0]['nomespecialista']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']); ?> de Paciente:</strong> <?php echo $reg[0]['cedpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres de Paciente:</strong> <?php echo $reg[0]['pnompaciente']." ".$reg[0]['snompaciente']; ?></td>
  </tr>
  <tr>
  <td><strong>Apellidos de Paciente:</strong> <?php echo $reg[0]['papepaciente']." ".$reg[0]['sapepaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Edad:</strong> <?php echo edad($reg[0]['fnacpaciente']); ?> AÑOS</td>
  </tr>
  <tr>
    <td><strong>Motivo de Cita:</strong> <?php echo $reg[0]['descripcion']; ?></td>
  </tr>
  <tr>
    <td><strong>Status de Cita:</strong> <?php 
if($reg[0]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]['statuscita']."</span>"; } 
elseif($reg[0]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[0]['statuscita']."</span>"; } ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Cita:</strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechacita'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora de Cita:</strong> <?php echo date("H:i:s",strtotime($reg[0]['fechacita'])); ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Ingreso:</strong> <?php echo date("d-m-Y",strtotime($reg[0]['ingresocita'])); ?></td>
  </tr>
  <tr>
    <td><strong>Registrado por:</strong> <?php echo $nombres = ($reg[0]['nombres'] == "" ? $reg[0]['cedespecialista2']." : ".$reg[0]['nomespecialista2']." (".$reg[0]['especialidad2'].")" : $reg[0]['dni']." : ".$reg[0]['nombres']); ?></td>
  </tr>
  <?php if($_SESSION['acceso']=="administradorG"){ ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>
</div> 
  <?php
   } 
############################# MOSTRAR CITAS ODONTOLOGICAS EN VENTANA MODAL ############################
?>

<?php 
########################### BUSQUEDA DE CITAS ODONTOLOGICAS POR FECHAS ##########################
if (isset($_GET['BusquedaCitasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
 $citas = new Login();
 $reg = $citas->BusquedaCitasxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Citas Odontológicas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CITASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CITASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CITASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>N°</th>
                                  <th>Nombre de Especialista</th>
                                  <th>Nombre de Paciente</th>
                                  <th>Descripción</th>
                                  <th>Fecha Cita</th>
                                  <th>Hora Cita</th>
                                  <th>Ingreso</th>
                                  <th>Status</th>
                                  <th>Registrado</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                              <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedespecialista']; ?>"><?php echo $reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></abbr></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']).": ".$reg[$i]['cedpaciente']; ?>"><?php echo $reg[$i]['pacientes']; ?></abbr></td>

                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
if($reg[$i]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statuscita']."</span>"; } 
elseif($reg[$i]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statuscita']."</span>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                                </tr>
                        <?php } ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE CITAS ODONTOLOGICAS POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA DE CITAS ODONTOLOGICAS POR ESPECIALISTAS ##########################
if (isset($_GET['BusquedaCitasxEspecialista']) && isset($_GET['codsucursal']) && isset($_GET['codespecialista']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codespecialista = limpiar($_GET['codespecialista']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codespecialista=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE ESPECIALISTA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
 $citas = new Login();
 $reg = $citas->BusquedaCitasxEspecialistas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Citas Odontológicas por Especialista</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CITASXESPECIALISTA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CITASXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CITASXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Especialista: </label> <?php echo $reg[0]['cedespecialista']; ?><br>

            <label class="control-label">Nombre de Especialista: </label> <?php echo $reg[0]['nomespecialista']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>N°</th>
                                  <th>Nombre de Paciente</th>
                                  <th>Descripción</th>
                                  <th>Fecha Cita</th>
                                  <th>Hora Cita</th>
                                  <th>Ingreso</th>
                                  <th>Status</th>
                                  <th>Registrado</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                              <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']).": ".$reg[$i]['cedpaciente']; ?>"><?php echo $reg[$i]['pacientes']; ?></abbr></td>

                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
if($reg[$i]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statuscita']."</span>"; } 
elseif($reg[$i]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statuscita']."</span>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                                </tr>
                        <?php } ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
    <?php
    } 
  }
########################### BUSQUEDA DE CITAS ODONTOLOGICAS POR ESPECIALISTAS ##########################
?>


<?php
########################## BUSQUEDA CITAS POR PACIENTE ##########################
if (isset($_GET['BusquedaCitasxPaciente']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCitasxPaciente();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Citas por Paciente </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&tipo=<?php echo encrypt("CITASXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CITASXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CITASXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['pacientes']; ?>

        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>N°</th>
                                  <th>Nombre de Especialista</th>
                                  <th>Descripción</th>
                                  <th>Fecha Cita</th>
                                  <th>Hora Cita</th>
                                  <th>Ingreso</th>
                                  <th>Status</th>
                                  <th>Registrado</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                              <td><?php echo $a++; ?></td>

  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedespecialista']; ?>"><?php echo $reg[$i]['nomespecialista']." (".$reg[$i]['especialidad'].")"; ?></abbr></td>

                              <td><?php echo $reg[$i]['descripcion']; ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                              <td><?php echo date("d-m-Y",strtotime($reg[$i]['ingresocita'])); ?></td>
                              <td><?php 
if($reg[$i]['statuscita']=='VERIFICADA') { 
  echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]['statuscita']."</span>"; } 
elseif($reg[$i]['statuscita']=='EN PROCESO') {  
  echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]['statuscita']."</span>"; }
else { echo "<span class='badge badge-pill badge-dark'><i class='fa fa-times'></i> ".$reg[$i]['statuscita']."</span>"; } ?></td>
                              <td><?php echo $nombres = ($reg[$i]['nombres'] == "" ? $reg[$i]['nomespecialista2']." (".$reg[$i]['especialidad2'].")" : $reg[$i]['nombres']); ?></td>
                                </tr>
                        <?php } ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CITAS POR PACIENTE ##########################
?>




























<?php 
############################# BUSCAR CAJERO PARA COBRO VENTA #############################
if (isset($_GET['MuestraDatosCajeroVenta'])) {
  
$caja = new Login();
$caja = $caja->CajasUsuarioPorId();
?>
    <div class="row">
        <div class="col-md-6">
            <h4 class="mb-0 font-light">Nº de Caja:</h4>
            <input type="hidden" name="codcaja" id="codcaja" value="<?php echo $caja == '' ? "0" : encrypt($caja[0]["codcaja"]); ?>">
            <h4 class="mb-0 font-medium"><label id="nrocaja" name="nrocaja"><?php echo $caja == '' ? "NO TIENE CAJA ABIERTA" : $caja[0]["nrocaja"].": ".$caja[0]["nomcaja"]; ?></label></h4>
        </div>

        <div class="col-md-6">
            <h4 class="mb-0 font-light">Nombre de Cajero:</h4>
            <h4 class="mb-0 font-medium"><label id="nomcajero" name="nomcajero"><?php echo $caja == '' ? "***************" : $caja[0]["nombres"]; ?></label></h4>
        </div>
    </div>

    <hr>


<?php 
}
############################# BUSCAR CAJERO PARA COBRO VENTA ##########################
?>


<?php
####################### MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCajaModal']) && isset($_GET['codcaja'])) { 

$reg = $new->CajasPorId();
?>
  
  <table class="table-responsive" border="0"> 
  <tr>
    <td><strong>Nº de Caja:</strong> <?php echo $reg[0]['nrocaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable de Caja: </strong> <?php echo $reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
<?php 
} 
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL #########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->BuscarCajasxSucursal();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo encrypt($caja[$i]['codcaja']) ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasAbiertasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->ListarCajasAbiertas();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo $caja[$i]['codcaja']; ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL #######################
if (isset($_GET['BuscaArqueoModal']) && isset($_GET['codarqueo'])) { 

$reg = $new->ArqueoCajaPorId();

$TotalVentas = $reg[0]['efectivo']+$reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

$VentaOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros'];

$TotalEfectivo = $reg[0]['montoinicial']+$reg[0]['efectivo']+$reg[0]['ingresosefectivo']+$reg[0]['abonosefectivo']-$reg[0]['egresos'];

$TotalOtros = $reg[0]['cheque']+$reg[0]['tcredito']+$reg[0]['tdebito']+$reg[0]['tprepago']+$reg[0]['transferencia']+$reg[0]['electronico']+$reg[0]['cupon']+$reg[0]['otros']+$reg[0]['abonosotros']+$reg[0]['ingresosotros'];

$simbolo = "<strong>".$reg[0]['simbolo']."</strong> ";
?>
  
  <table class="table-responsive" border="0">

  <tr>
    <td><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-account-outline"></i> Cajero</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Apertura:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo $cierre = ( $reg[0]['statusarqueo'] == '1' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))); ?></td>
  </tr>
  <tr>
    <td><strong>Monto Inicial:</strong> <?php echo $simbolo.number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Ventas a Contado</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['efectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Cheque:</strong> <?php echo $simbolo.number_format($reg[0]['cheque'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Crédito:</strong> <?php echo $simbolo.number_format($reg[0]['tcredito'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Débito:</strong> <?php echo $simbolo.number_format($reg[0]['tdebito'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Tarjeta Prepago:</strong> <?php echo $simbolo.number_format($reg[0]['tprepago'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Transferencia:</strong> <?php echo $simbolo.number_format($reg[0]['transferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Dinero Electrónico:</strong> <?php echo $simbolo.number_format($reg[0]['electronico'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Cupón:</strong> <?php echo $simbolo.number_format($reg[0]['cupon'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Otros:</strong> <?php echo $simbolo.number_format($reg[0]['otros'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Crédito:</strong> <?php echo $simbolo.number_format($reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cart-plus"></i> Abonos de Créditos</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Abonos Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['abonosefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Abonos Otros:</strong> <?php echo $simbolo.number_format($reg[0]['abonosotros'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-cash-usd"></i> Movimientos</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Ingresos Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['ingresosefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ingresos Otros:</strong> <?php echo $simbolo.number_format($reg[0]['ingresosotros'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Egresos:</strong> <?php echo $simbolo.number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-scale-balance"></i> Balance en Caja</h4><hr></td>
  </tr>

  <tr>
    <td><strong>Total en Ventas:</strong> <?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ventas en Efectivo:</strong> <?php echo $simbolo.number_format($reg[0]['efectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Ventas en Otros:</strong> <?php echo $simbolo.number_format($VentaOtros, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total en Efectivo:</strong> <?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Total en Otros:</strong> <?php echo $simbolo.number_format($TotalOtros, 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><strong>Efectivo en Caja:</strong> <?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Diferencia:</strong> <?php echo $simbolo.number_format($reg[0]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td><strong>Observaciones:</strong> <?php echo $reg[0]['comentarios'] == '' ? "**********" : $reg[0]['comentarios']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
  
  <?php
   } 
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
?>


<?php
########################## BUSQUEDA ARQUEOS DE CAJA POR FECHAS ##########################
if (isset($_GET['BuscaArqueosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarArqueosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Hora de Apertura</th>
                                  <th>Hora de Cierre</th>
                                  <th>Monto Inicial</th>
                                  <th>Total en Ventas</th>
                                  <th>Total en Efectivo</th>
                                  <th>Efectivo en Caja</th>
                                  <th>Diferencia en Caja</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$TotalVentas = 0;
$TotalEfectivo = 0;
$TotalCaja = 0;
$TotalDiferencia = 0;

$a=1; 
for($i=0;$i<sizeof($reg);$i++){

$TotalVentas += $reg[$i]['efectivo']+$reg[$i]['cheque']+$reg[$i]['tcredito']+$reg[$i]['tdebito']+$reg[$i]['tprepago']+$reg[$i]['transferencia']+$reg[$i]['electronico']+$reg[$i]['cupon']+$reg[$i]['otros'];

$TotalEfectivo += $reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'];
$TotalCaja += $reg[$i]['dineroefectivo'];
$TotalDiferencia += $reg[$i]['diferencia'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
            <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
            <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['efectivo']+$reg[$i]['tdebito']+$reg[$i]['tcredito']+$reg[$i]['otros'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['efectivo']+$reg[$i]['ingresosefectivo']+$reg[$i]['abonosefectivo']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="4"></td>
<td><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##########################
?>




















<?php
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL #####################
if (isset($_GET['BuscaMovimientoModal']) && isset($_GET['codmovimiento'])) { 

$reg = $new->MovimientosPorId();
$simbolo = "<strong>".$reg[0]['simbolo']."</strong> ";
?>
  
<table class="table-responsive" border="0">
  <tr>
    <td><strong>Nombre de Caja:</strong> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td><strong>Tipo de Movimiento:</strong> <?php echo $tipo = ( $reg[0]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
  </tr>
  <tr>
    <td><strong>Descripción de Movimiento:</strong> <?php echo $reg[0]['descripcionmovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Monto de Movimiento:</strong> <?php echo $simbolo.number_format($reg[0]['montomovimiento'], 2, '.', ','); ?></td>
    </tr>
  <tr>
    <td><strong>Método de Movimiento:</strong> <?php echo $reg[0]['mediomovimiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Hora Cierre:</strong> <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])); ?></td>
  </tr>
  <tr>
    <td><strong>Responsable:</strong> <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>

<?php
  } 
##################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL ######################
?>

<?php
######################### BUSQUEDA MOVIMIENTOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaMovimientosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarMovimientosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos en Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo Movimiento</th>
                                  <th>Descripción</th>
                                  <th>Método de Movimiento</th>
                                  <th>Fecha Movimiento</th>
                                  <th>Monto</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalIngresos=0;
$TotalEgresos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$TotalIngresos+= ($reg[$i]['tipomovimiento'] == 'INGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$TotalEgresos+= ($reg[$i]['tipomovimiento'] == 'EGRESO' ? $reg[$i]['montomovimiento'] : "0.00");
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
<td><?php echo $status = ( $reg[$i]['tipomovimiento'] == 'INGRESO' ? "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]['tipomovimiento']."</span>" : "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> ".$reg[$i]['tipomovimiento']."</span>"); ?></td>
<td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
              <td><?php echo $reg[$i]['mediomovimiento']; ?></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechamovimiento'])); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
                                </tr>
                        <?php  }  ?>
          <tr>
           <td colspan="4"></td>
<td><strong>Total Ingresos</strong></td>
<td><?php echo $simbolo.number_format($TotalIngresos, 2, '.', ','); ?></td>
          </tr>
          <tr>
           <td colspan="4"></td>
<td><strong>Total Egresos</strong></td>
<td><?php echo $simbolo.number_format($TotalEgresos, 2, '.', ','); ?></td>
          </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
####################### BUSQUEDA MOVIMIENTOS DE CAJAS POR FECHAS ########################
?>







































<?php 
########################### BUSQUEDA DE CITAS DIARIA PARA ODONTOLOGIA ##########################
if (isset($_GET['BuscaCitasxDia']) && isset($_GET['codespecialista']) && isset($_GET['fecha'])) { 

//$codsucursal = limpiar($_GET['codsucursal']);
$codespecialista = limpiar($_GET['codespecialista']); 
$fecha = limpiar($_GET['fecha']);
   
 /*if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else*/ if($codespecialista=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE ESPECIALISTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($fecha=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else {
  
 $citas = new Login();
 $reg = $citas->BuscarCitasxFecha();  
 ?>

  <h3 class="card-subtitle m-t-2"><i class="fa fa-calendar"></i> Citas Odontológicas de Fecha <?php echo date("d-m-Y", strtotime($fecha)); ?></h3><hr>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>N°</th>
                          <th>Nombre de Paciente</th>
                          <th>Descripción</th>
                          <th>Fecha Cita</th>
                          <th><span class="mdi mdi-drag-horizontal"></span></th>
                        </tr>
                      </thead>
                      <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                        <tr>
                          <td><?php echo $a++; ?></td>
                          <td><?php echo $reg[$i]['nompaciente']." ".$reg[$i]["apepaciente"]; ?></td>
                          <td><?php echo $reg[$i]['descripcion']; ?></td>
                          <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacita'])); ?></td>
                          <td><button type="button" class="btn btn-info btn-rounded" data-placement="left" data-dismiss="modal" title="Asignar" onClick="AsignaCita('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codcita"]); ?>','<?php echo $reg[$i]["codcita"]; ?>','<?php echo encrypt($reg[$i]["codespecialista"]); ?>','<?php echo encrypt($reg[$i]["codpaciente"]); ?>','<?php echo $reg[$i]["codpaciente"]; ?>','<?php echo $reg[$i]["cedpaciente"]; ?>','<?php echo $reg[$i]["nompaciente"]; ?>','<?php echo $reg[$i]["apepaciente"]; ?>','<?php echo $reg[$i]["sexopaciente"]; ?>','<?php echo $reg[$i]["gruposapaciente"]; ?>','<?php echo $reg[$i]["ocupacionpaciente"]; ?>','<?php echo $reg[$i]["estadopaciente"]; ?>','<?php echo $reg[$i]['fnacpaciente'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[$i]["fnacpaciente"])); ?>','<?php echo $reg[$i]["tlfpaciente"]; ?>','<?php echo $reg[$i]["direcpaciente"]; ?>','<?php echo $reg[$i]["nomacompana"]; ?>','<?php echo $reg[$i]["parentescoacompana"]; ?>')"><i class="mdi mdi-account-plus"></i></button></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                  </table></div>
  <?php
  } 
}
########################### BUSQUEDA DE CITAS DIARIA PARA ODONTOLOGIA ##########################
?>

<?php 
########################### BUSQUEDA DE HISTORIAL DE PACIENTE ##########################
if (isset($_GET['BuscaHistorialPaciente']) && isset($_GET['codpaciente']) && isset($_GET['codsucursal'])) { 

$codpaciente = limpiar($_GET['codpaciente']);
$codsucursal = limpiar($_GET['codsucursal']); 
   
  
$historial = new Login();
$reg = $historial->BusquedaHistorialPacientes();  
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Historial de Paciente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      
    <div id="div"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Nombre de Especialista</th>
                            <th>Pronóstico</th>
                            <th>Tratamiento</th>
                            <th>Observaciones</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th><span class="mdi mdi-drag-horizontal"></span></th>
                          </tr>
                        </thead>
                        <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                          <tr>
                        <td><?php echo $a++; ?></td>
                        <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td>
                        <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
                        <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
                        <td><?php echo $reg[$i]['observacionestratamiento'] == "" ? "**********" : $reg[$i]['observacionestratamiento']; ?></td>
                        <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                        <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                        <td><a href="reportepdf?cododontologia=<?php echo encrypt($reg[$i]['cododontologia']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHAODONTOLOGICA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                          </tr>
                  <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php 
}
########################### BUSQUEDA DE HISTORIAL DE PACIENTE ##########################
?>

<?php
############################# FUNCION TABLA REFERENCIAS DE ODONTOGRAMA ############################
if (isset($_GET['BuscaTablaTratamiento']) && isset($_GET['codcita']) && isset($_GET['codpaciente'])) { 

$codcita=$_GET['codcita'];
$codpaciente=$_GET['codpaciente'];

$tra = new Login();
$reg = $tra->TratamientosOdontograma();
?>

<table id="tablaTratamiento" class="table2 table-striped table-bordered border display">
    <tbody>
<?php 
if($reg == "" || $reg[0]['estados'] == ""){

echo "";

} else {

$explode = explode("__",$reg[0]['estados']);
$listaSimple = array_values(array_unique($explode));

for($cont=0; $cont<COUNT($listaSimple); $cont++):
# Listo 3 variables donde guardare lo que me retorne el explode de cada posicion del array.
list($diente,$caradiente,$referencias) = explode("_",$listaSimple[$cont]);
?>
<tr class="text-center font-12">
<td><?php echo $diente; ?></td>
<td><?php echo $caradiente; ?></td>
<td><?php echo $referencias; ?></td>
<td><span style="cursor: pointer;" title="Eliminar" onClick="EliminarReferencia('<?php echo $cont ?>','<?php echo encrypt($reg[0]["codcita"]); ?>','<?php echo encrypt($reg[0]["codpaciente"]); ?>','<?php echo encrypt($reg[0]["codsucursal"]); ?>','<?php echo encrypt("REFERENCIAS") ?>')"><i class="mdi mdi-delete font-22 text-danger"></i></span></td>
</tr>

<?php endfor; } ?>
            
    </tbody>
</table>
<?php
   } 
############################# FUNCION TABLA REFERENCIAS DE ODONTOGRAMA ############################
?>

<?php
######################## MOSTRAR ODONTOLOGIA EN VENTANA MODAL ############################
if (isset($_GET['BuscaOdontologiaModal']) && isset($_GET['cododontologia']) && isset($_GET['codsucursal'])) { 
$reg = $new->OdontologiaPorId();
?>

  <table class="table-responsive" border="0">
  <tr>
    <td><strong>Código:</strong> <?php echo $reg[0]['codpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de <?php echo $reg[0]['documpaciente'] == '0' ? "Documento" : $reg[0]['documento']; ?>:</strong> <?php echo $reg[0]['cedpaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Nombres:</strong> <?php echo $reg[0]['nompaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Apellidos:</strong> <?php echo $reg[0]['apepaciente']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha de Nacimiento:</strong> <?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fnacpaciente'])); ?></td>
  </tr>
  <tr>
    <td><strong>Edad:</strong> <?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "*********" : edad($reg[0]['fnacpaciente'])." AÑOS"; ?></td>
  </tr>
  <tr>
    <td><strong>Nº de Teléfono:</strong> <?php echo $reg[0]['tlfpaciente']; ?></td>
  </tr>

  <tr>
    <td><strong>Presuntivo:</strong></td>
  </tr> 

  <tr>
    <td>
    <?php 
    $explode = explode(",,",utf8_decode(strtoupper($reg[0]['presuntivo'])));
    $a=1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($idciepresuntivo,$presuntivo) = explode("/",$explode[$cont]);

    if($idciepresuntivo==""){
      echo "***********";
    } else {
    echo $a++. "). ".$presuntivo."<br>";
    }
    endfor;
    ?>
     </td>
  </tr> 

  <tr>
    <td><strong>Definitivo:</strong></td>
  </tr> 

  <tr>
    <td>
    <?php 
    $explode = explode(",,",utf8_decode(strtoupper($reg[0]['definitivo'])));
    $a=1;
    for($cont=0; $cont<COUNT($explode); $cont++):
    list($idciedefinitivo,$definitivo) = explode("/",$explode[$cont]);

    if($idciedefinitivo==""){
      echo "***********";
    } else {
    echo $a++. "). ".$definitivo."<br>";
    }
    endfor;
    ?>
     </td>
  </tr> 

  <tr>
    <td><strong>Pronóstico:</strong> <?php echo $reg[0]['pronostico'] == "" ? "**********" : $reg[0]['pronostico']; ?></td>
  </tr>
  <tr>
    <td><strong>Tratamiento:</strong> <?php echo $reg[0]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[0]['plantratamiento']); ?></td>
  </tr>
  <tr>
    <td><strong>Observaciones:</strong> <?php echo $reg[0]['observacionestratamiento'] == "" ? "**********" : $reg[0]['observacionestratamiento']; ?></td>
  </tr>
  <tr>
    <td><strong>Fecha:</strong> <?php echo date("d-m-Y",strtotime($reg[0]['fechaodontologia'])); ?></td>
  </tr>
  <tr>
    <td><strong>Hora:</strong> <?php echo date("H:i:s",strtotime($reg[0]['fechaodontologia'])); ?></td>
  </tr>
<?php if ($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td><strong>Sucursal:</strong> <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?> 
</table>  

  <?php
   } 
######################## MOSTRAR ODONTOLOGIA EN VENTANA MODAL ############################
?>

<?php
######################### BUSQUEDA ODONTOLOGIA POR FECHAS ########################
if (isset($_GET['BusquedaOdontologiaxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarOdontologiaxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Consultas Odontológicas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ODONTOLOGIAXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Consulta</th>
                              <th>Nombre de Especialista</th>
                              <th>Nombre de Paciente</th>
                              <th>Observaciones</th>
                              <th>Pronostico</th>
                              <th>Tratamiento</th>
                              <th>Fecha</th>
                              <th>Hora</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo $reg[$i]['observacionexamendental'] == "" ? "**********" : $reg[$i]['observacionexamendental']; ?></td>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                    <td>
<a href="reportepdf?cododontologia=<?php echo encrypt($reg[$i]['cododontologia']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHAODONTOLOGICA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA ODONTOLOGIA POR FECHAS ##########################
?>

<?php
######################### BUSQUEDA ODONTOLOGIA POR ESPECIALISTAS ########################
if (isset($_GET['BusquedaOdontologiaxEspecialista']) && isset($_GET['codsucursal']) && isset($_GET['codespecialista']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codespecialista = limpiar($_GET['codespecialista']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codespecialista=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE ESPECIALISTA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarOdontologiaxEspecialista();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Consultas Odontológicas por Especialista</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ODONTOLOGIAXESPECIALISTA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Especialista: </label> <?php echo $reg[0]['cedespecialista']; ?><br>

            <label class="control-label">Nombre de Especialista: </label> <?php echo $reg[0]['nomespecialista']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Consulta</th>
                              <th>Nombre de Paciente</th>
                              <th>Observaciones</th>
                              <th>Pronostico</th>
                              <th>Tratamiento</th>
                              <th>Fecha</th>
                              <th>Hora</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedpaciente'].": ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
            <td><?php echo $reg[$i]['observacionexamendental'] == "" ? "**********" : $reg[$i]['observacionexamendental']; ?></td>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                    <td>
<a href="reportepdf?cododontologia=<?php echo encrypt($reg[$i]['cododontologia']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHAODONTOLOGICA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA ODONTOLOGIA POR ESPECIALISTAS ##########################
?>

<?php
######################### BUSQUEDA ODONTOLOGIA POR PACIENTE ########################
if (isset($_GET['BusquedaOdontologiaxPaciente']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarOdontologiaxPaciente();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Consultas Odontológicas por Paciente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
          <div class="btn-group m-b-20">
          <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&tipo=<?php echo encrypt("ODONTOLOGIAXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

          <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ODONTOLOGIAXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Consulta</th>
                              <th>Nombre de Especialista</th>
                              <th>Observaciones</th>
                              <th>Pronostico</th>
                              <th>Tratamiento</th>
                              <th>Fecha</th>
                              <th>Hora</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
            <td><?php echo $reg[$i]['cododontologia']; ?></td>
            <td><?php echo $reg[$i]['cedespecialista'].": ".$reg[$i]['nomespecialista']; ?></td>
            <td><?php echo $reg[$i]['observacionexamendental'] == "" ? "**********" : $reg[$i]['observacionexamendental']; ?></td>
            <td><?php echo $reg[$i]['pronostico'] == "" ? "**********" : $reg[$i]['pronostico']; ?></td>
            <td><?php echo $reg[$i]['plantratamiento'] == "" ? "**********" : str_replace(",",", ", $reg[$i]['plantratamiento']); ?></td>
            <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaodontologia'])); ?></td>
            <td><?php echo date("H:i:s",strtotime($reg[$i]['fechaodontologia'])); ?></td>
                    <td>
<a href="reportepdf?cododontologia=<?php echo encrypt($reg[$i]['cododontologia']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FICHAODONTOLOGICA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA ODONTOLOGIA POR PACIENTE ##########################
?>

























<?php
############################# BUSQUEDA DE CONSENTIMIENTO INFORMADO ##################################
if (isset($_GET['BuscaConsentimientoInformado']) && isset($_GET['codpaciente']) && isset($_GET['codespecialista'])) { 
  
  $codpaciente = $_GET['codpaciente'];
  $codespecialista = $_GET['codespecialista'];

if($codpaciente=="") {

echo "<center><div class='alert alert-danger'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</div></center>";
exit;
   
 } elseif($codespecialista=="") {

echo "<center><div class='alert alert-danger'>";
echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
echo "<span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE ESPECIALISTA PARA TU BÚSQUEDA </div></center>";
exit;
    
} else {

$pa = new Login();
$pa = $pa->BuscarPacientes();

$esp = new Login();
$esp = $esp->EspecialistasPorId();

?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-paste"></i> Consentimiento Informado patra Odontológia</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

    <div class="row">
      <div class="col-md-12">
        <p align="justify">YO: <?php echo "<strong>".$pa[0]['nompaciente']." ".$pa[0]['apepaciente']."</strong>"; ?> <?php echo $variable = ( edad($pa[0]['fnacpaciente']) >= '18' ? " MAYOR DE EDAD" : " MENOR DE EDAD");  ?>, IDENTIFICADO CON <?php echo "<strong>".$pa[0]['documento']." N&deg; ".$pa[0]['cedpaciente']."</strong>"; ?> DE <?php echo "<strong>".$departamento = ($pa[0]['id_departamento'] == '0' ? "" : $pa[0]['departamento'])." ".$provincia = ($pa[0]['id_provincia'] == '0' ? "" : $pa[0]['provincia'])." ".$pa[0]['direcpaciente']."</strong>"; ?>, Y COMO PACIENTE O COMO RESPONSABLE DEL PACIENTE AUTORIZÓ AL DR.(A) <?php echo "<strong>".$esp[0]['nomespecialista']."</strong>"; ?>, <?php echo "<strong>".$esp[0]['documento']." N&deg; ".$esp[0]['cedespecialista']."</strong>"; ?>, CON PROFESIÓN O ESPECIALIDAD <?php echo "<strong>".$esp[0]['especialidad']."</strong>"; ?>, PARA LA REALIZACIÓN DEL PROCEDIMIENTO<br><br>

        <textarea class="form-control" name="procedimiento" id="procedimiento" onkeyup="this.value=this.value.toUpperCase();" style="width:100%;background:#f0f9fc;border-radius:5px 5px 5px 5px;" autocomplete="off" placeholder="Ingrese Procedimiento" rows="2" required="" aria-required="true"></textarea> <br>

        TENIENDO EN CUENTA QUE HE SIDO INFORMADO CLARAMENTE SOBRE LOS RIESGOS QUE SE PUEDEN PRESENTAR, SIENDO ESTOS: <br><br>

        <textarea class="form-control" name="observaciones" id="observaciones" onkeyup="this.value=this.value.toUpperCase();" style="width:100%;background:#f0f9fc;border-radius:5px 5px 5px 5px;" autocomplete="off" placeholder="Ingrese Observaciones" rows="3" required="" aria-required="true"></textarea><br> 

        COMPRENDO Y ACEPTO QUE DURANTE EL PROCEDIMIENTO PUEDEN APARECER CIRCUNSTANCIAS IMPREVISIBLES O INESPERADAS, QUE PUEDAN REQUERIR UNA EXTENSIÓN DEL PROCEDIMIENTO ORIGINAL O LA REALIZACIÓIN DE OTRO PROCEDIMIENTO NO MENCIONADO ARRIBA.<br><br>

        AL FIRMAR ESTE DOCUMENTO RECONOZCO QUE LOS HE LEIDO O QUE ME HA SIDO LEÍDO Y EXPLICADO Y QUE COMPRENDO PERFECTAMENTE SU CONTENIDO.<br><br>

        SE ME HAN DADO AMPLIAS OPORTUNIDADES DE FORMULAR PREGUNTAS Y QUE TODAS LAS PREGUNTAS QUE HE FORMULADO HAN SIDO RESPONDIDAS O EXPLICADAS EN FORMA SATISFACTORIA.<br><br>

        ACEPTO QUE LA MEDICINA NO ES UNA CIENCIA EXACTA Y QUE NO SE ME HAN GARANTIZADO LOS RESULTADOS QUE SE ESPERAN DE LA INTERVENCIÓN QUIRÚRGICA O PROCEDIMIENTOS DIAGNÓSTICOS, TERAPÉUTICOS U ODONTOLÓGICOS, EN EL SENTIDO DE QUE LA PRÁCTICA DE LA INTERVENCIÓN O PROCEDIMIENTOS QUE REQUIERO COMPROMETE UNA ACTIVIDAD DE MEDIO, PERO NO DE RESULTADO.<br><br>

        COMPRENDIENDO ESTAS LIMITACIONES, DOY MI CONSENTIMIENTO PARA LA REALIZACIÓN DEL PROCEDIMIENTO Y FIRMO A CONTINUACIÓN:</p><hr />
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="form-group has-feedback">
          <label class="control-label">Nº Documento Testigo: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="doctestigo" id="doctestigo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº Documento Testigo" autocomplete="off" required="" aria-required="true"/>  
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group has-feedback">
          <label class="control-label">Nombre de Testigo: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="nombretestigo" id="nombretestigo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Testigo" autocomplete="off" required="" aria-required="true"/>  
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group has-feedback">
          <label class="control-label">El Paciente no puede firmar por: </label>
          <input type="text" class="form-control" name="nofirmapaciente" id="nofirmapaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese El Paciente no puede firmar por" autocomplete="off" required="" aria-required="true"/>  
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div>
      </div>
    </div>

            <div class="text-right">
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
<button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Limpiar</button>
             </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<?php
    }
 } 
############################# BUSQUEDA DE CONSENTIMIENTO INFORMADO ##################################
?>


































<?php
######################## MOSTRAR VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaVentaModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº DE FACTURA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">CONDICIÓN PAGO: <?php echo $reg[0]['tipopago']; ?>
  <br>MÉTODO PAGO: <?php echo $reg[0]['formapago']; ?>
  <br>STATUS: 
  <td><?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
      elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?></td>

  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-danger">PACIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcpaciente'] == '' ? "*********" : $reg[0]['direcpaciente']; ?> <?php echo $reg[0]['departamento2'] == '' ? "*********" : strtoupper($reg[0]['departamento2']); ?> <?php echo $reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2']; ?> 
  <br/> Nº <?php echo $reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cedpaciente']; ?> - TLF: <?php echo $reg[0]['tlfpaciente'] == '' ? "******" : $reg[0]['tlfpaciente']; ?></p>

  <h4><b class="text-danger">ESPECIALISTA</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomespecialista'].", ".$reg[0]['especialidad']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcespecialista'] == '' ? "*********" : $reg[0]['direcespecialista']; ?> <?php echo $reg[0]['departamento3'] == '' ? "*********" : strtoupper($reg[0]['departamento3']); ?> <?php echo $reg[0]['provincia3'] == '' ? "*********" : $reg[0]['provincia3']; ?> 
  <br/> Nº <?php echo $reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4'] ?>: <?php echo $reg[0]['cedespecialista']; ?> - TLF: <?php echo $reg[0]['tlfespecialista'] == '' ? "******" : $reg[0]['tlfespecialista']; ?></p>
                                           
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
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
$detalle = $tra->VerDetallesVentas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == "" ? "******" : $detalle[$i]['nommarca']; ?>) : MEDIDA (<?php echo $detalle[$i]['nommedida'] == "" ? "******" : $detalle[$i]['nommedida']; ?>)</small></td>
      <td><?php echo $detalle[$i]['cantventa']; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] == 'SI' ? number_format($reg[0]['iva'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetalleVentaModal('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codpaciente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($SubTotal, 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></p>
<p><b>Total Exento 0%:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['descontado'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%):</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo "<strong>".$reg[0]['simbolo']."</strong> ".number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

  <?php
       }
   } 
######################## MOSTRAR VENTA EN VENTANA MODAL ########################
?>


<?php
######################### MOSTRAR DETALLES DE VENTA UPDATE ##########################
if (isset($_GET['MuestraDetallesVentaUpdate']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();

?>

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
$detalle = $tra->VerDetallesVentas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
$simbolo = "<strong>".$reg[0]['simbolo']."</strong>";
?>
                <tr>
      <td>
      <input type="text" step="1" min="1" class="form-control cantidad bold" name="cantventa[]" id="cantidad_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoVenta(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" style="width: 80px;background:#e4e7ea;border-radius:5px 5px 5px 5px;" onfocus="this.style.background=('#B7F0FF')" onfocus="this.style.background=('#B7F0FF')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e4e7ea');" title="Ingrese Cantidad" value="<?php echo $detalle[$i]["cantventa"]; ?>" required="" aria-required="true">
      <input type="hidden" name="cantidadventabd[]" id="cantidadventabd" value="<?php echo $detalle[$i]["cantventa"]; ?>">
      <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>">
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
<button type="button" class="btn btn-outline-dark btn-rounded" onClick="EliminarDetallesVentaUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table>
            </div>

            <hr>

            <div class="row">

                    <!-- .col -->
                    <div class="col-md-6">
                        <h3 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cash-multiple"></i> Métodos de Pago</h3><hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                                    <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="tipodocumento" id="ticket" value="TICKET" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "TICKET") { ?> checked="checked" <?php } else { ?> checked="checked" <?php } ?> class="custom-control-input">
                                    <label class="custom-control-label" for="ticket">TICKET </label>
                                    </div><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="tipodocumento" id="notaventa" value="NOTAVENTA" <?php if (isset($reg[0]['tipodocumento']) && $reg[0]['tipodocumento'] == "NOTAVENTA") { ?> checked="checked" <?php } ?> class="custom-control-input">
                                    <label class="custom-control-label" for="notaventa">NOTA DE VENTA </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                                    <br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="tipopago" id="contado" value="CONTADO" <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CONTADO") { ?> checked="checked" <?php } ?> disabled="" onclick="CargaCondicionesPagos();" class="custom-control-input">
                                    <label class="custom-control-label" for="contado">CONTADO</label>
                                    </div><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" name="tipopago" id="credito" value="CREDITO" <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CREDITO") { ?> checked="checked" <?php } ?> disabled="" onclick="CargaCondicionesPagos();" class="custom-control-input">
                                    <label class="custom-control-label" for="credito">CRÉDITO</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="muestra_metodo"><!-- metodo de pago -->

                        <?php if (isset($reg[0]['tipopago']) && $reg[0]['tipopago'] == "CONTADO") { ?>

                        <div class="row">
                            <div class="col-md-6"> 
                                <div class="form-group has-feedback"> 
                                    <label class="control-label">Método de Pago: <span class="symbol required"></span></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <?php if (isset($reg[0]['formapago'])) { ?>
                                    <select name="formapago" id="formapago" class="form-control" required="" disabled="" aria-required="true">
                                        <option value=""> -- SELECCIONE -- </option>
                                        <option value="EFECTIVO"<?php if (!(strcmp('EFECTIVO', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>EFECTIVO</option>
                                        <option value="CHEQUE"<?php if (!(strcmp('CHEQUE', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>CHEQUE</option>
                                        <option value="TARJETA DE CREDITO"<?php if (!(strcmp('TARJETA DE CREDITO', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>TARJETA DE CRÉDITO</option>
                                        <option value="TARJETA DE DEBITO"<?php if (!(strcmp('TARJETA DE DEBITO', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>TARJETA DE DÉBITO</option>
                                        <option value="TARJETA PREPAGO"<?php if (!(strcmp('TARJETA PREPAGO', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>TARJETA PREPAGO</option>
                                        <option value="TRANSFERENCIA"<?php if (!(strcmp('TRANSFERENCIA', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>TRANSFERENCIA</option>
                                        <option value="DINERO ELECTRONICO"<?php if (!(strcmp('DINERO ELECTRONICO', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>DINERO ELECTRÓNICO</option>
                                        <option value="CUPON"<?php if (!(strcmp('CUPON', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>CUPÓN</option>
                                        <option value="OTROS"<?php if (!(strcmp('OTROS', $reg[0]['formapago']))) { echo "selected=\"selected\"";} ?>>OTROS</option>
                                    </select>
                                    <?php } else { ?>
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
                                    <?php } ?>
                                </div> 
                            </div>

                            <div class="col-md-6"> 
                                <div class="form-group has-feedback">
                                    <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                                    <input type="hidden" name="montodevuelto" id="montodevuelto" <?php if (isset($reg[0]['montodevuelto'])) { ?> value="<?php echo $reg[0]['montodevuelto']; ?>" <?php } else { ?> value="0.00" <?php } ?> >
                                    <input class="form-control" type="text" name="montopagado" id="montopagado" autocomplete="off" placeholder="Monto Recibido" onKeyUp="CalculoDevolucion();" <?php if (isset($reg[0]['montopagado'])) { ?> value="<?php echo $reg[0]['montopagado']; ?>" <?php } else { ?> value="0" <?php } ?> required="" aria-required="true"><i class="fa fa-tint form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <?php } else { ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group has-feedback">
                                        <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label>
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
                            <td><?php echo $simbolo; ?>  <label id="lblexento" name="lblexento"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label>
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
                            <td><?php echo $simbolo; ?>  <label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?></label></td>
                            <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', '') ?>"/>
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
<?php
  } 
######################### MOSTRAR DETALLES DE VENTA UPDATE ##########################
?>


<?php
########################## BUSQUEDA VENTAS POR CAJAS ##########################
if (isset($_GET['BuscaVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturación por Caja </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Especialista</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Tipo</th>
                                  <th>Método</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $reg[$i]['tipopago']; ?></td>
                    <td><?php echo $reg[$i]['formapago']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR CAJAS ##########################
?>

<?php
########################## BUSQUEDA VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturación por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Caja</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Especialista</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Tipo</th>
                                  <th>Método</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $reg[$i]['tipopago']; ?></td>
                    <td><?php echo $reg[$i]['formapago']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="9"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA VENTAS POR ESPECIALISTA ##########################
if (isset($_GET['BusquedaVentasxEspecialista']) && isset($_GET['codsucursal']) && isset($_GET['codespecialista'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codespecialista = limpiar($_GET['codespecialista']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codespecialista=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL ESPECIALISTA CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxEspecialista();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturación por Especialista </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&tipo=<?php echo encrypt("VENTASXESPECIALISTA") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codespecialista=<?php echo $codespecialista; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXESPECIALISTA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[0]['documento4']); ?> de Especialista: </label> <?php echo $reg[0]['cedespecialista']; ?><br>

            <label class="control-label">Nombre de Especialista: </label> <?php echo $reg[0]['nomespecialista']; ?><br>

        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Caja</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Tipo</th>
                                  <th>Método</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']." ".$reg[$i]['cedpaciente']." : ".$reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
                    <td><?php echo $reg[$i]['tipopago']; ?></td>
                    <td><?php echo $reg[$i]['formapago']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR ESPECIALISTA ##########################
?>

<?php
########################## BUSQUEDA VENTAS POR PACIENTE ##########################
if (isset($_GET['BusquedaVentasxPaciente']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxPaciente();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Facturación por Paciente </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&tipo=<?php echo encrypt("VENTASXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>

        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Caja</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Especialista</th>
                                  <th>Tipo</th>
                                  <th>Método</th>
                                  <th>Status</th>
                                  <th>Fecha Emisión</th>
                                  <th>SubTotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc.</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['articulos']; 
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$simbolo = "<strong>".$reg[$i]['simbolo']."</strong> ";
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]["nrocaja"].": ".$reg[$i]["nomcaja"]; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
            <td><?php echo $reg[$i]['documespecialista'] == '0' ? "DOCUMENTO" : $reg[$i]['documento4']." ".$reg[$i]['cedespecialista']." : ".$reg[$i]['nomespecialista']; ?></td>
                    <td><?php echo $reg[$i]['tipopago']; ?></td>
                    <td><?php echo $reg[$i]['formapago']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
                    
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo $reg[$i]['iva']; ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA VENTAS POR PACIENTE ##########################
?>




























<?php
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
if (isset($_GET['BuscaCreditoModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CreditosPorId();

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-danger">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-danger">Nº DE FACTURA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">TOTAL FACTURA: <?php echo $reg[0]['simbolo']." ".number_format($reg[0]['totalpago'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $reg[0]['simbolo']." ".number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $reg[0]['simbolo']." ".number_format($reg[0]['totalpago'] - $reg[0]['creditopagado'], 2, '.', ','); ?>
  
  <br>STATUS: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
      elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
      elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>

  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
        elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>

  <h4><b class="text-danger">PACIENTE </b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['codpaciente'] == '0' ? "CONSUMIDOR FINAL" : $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcpaciente'] == '' ? "*********" : $reg[0]['direcpaciente']; ?> <?php echo $reg[0]['departamento2'] == '' ? "*********" : strtoupper($reg[0]['departamento2']); ?> <?php echo $reg[0]['provincia2'] == '' ? "*********" : $reg[0]['provincia2']; ?>
  <br/> Nº <?php echo $reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cedpaciente']; ?> - TLF: <?php echo $reg[0]['tlfpaciente'] == '' ? "******" : $reg[0]['tlfpaciente']; ?></p>


                                        </address>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table2 table-hover">
                               <thead>
                        <tr><th colspan="4"><h4><b class="text-danger">DETALLES</b></h4></th></tr>
                        <tr>
                        <th>#</th>
                        <th>Nº de Caja</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                        </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonos();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $detalle[$i]['nrocaja'].": ".$detalle[$i]['nomcaja']; ?></td>
      <td><?php echo $reg[0]['simbolo']." ".number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
      <td><?php echo date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono'])); ?></td>
                                                </tr>
                                      <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                              </div>
                <!-- .row -->
  <?php
   } 
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
?>

<?php
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Nº de Documento</th>
                                  <th>Descripción de Paciente</th>
                                  <th>Observaciones</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['codpaciente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cedpaciente']; ?></td>
  <td><?php echo $reg[$i]['codpaciente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nompaciente']." ".$reg[$i]['apepaciente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      
      <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>
<?php } ?>

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-warning btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA CREDITOS POR PACIENTE ##########################
if (isset($_GET['BuscaCreditosxPacientes']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxPacientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Paciente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&tipo=<?php echo encrypt("CREDITOSXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Observaciones</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>

    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      
      <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>
<?php } ?>

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-warning btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA CREDITOS POR PACIENTE ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS POR PACIENTE ##########################
if (isset($_GET['BuscaDetallesCreditosxPacientes']) && isset($_GET['codsucursal']) && isset($_GET['codpaciente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codpaciente = limpiar($_GET['codpaciente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codpaciente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PACIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosxDetalles();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Créditos por Paciente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSXPACIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codpaciente=<?php echo $codpaciente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSXPACIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documpaciente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Paciente: </label> <?php echo $reg[0]['cedpaciente']; ?><br>

            <label class="control-label">Nombre de Paciente: </label> <?php echo $reg[0]['nompaciente']." ".$reg[0]['apepaciente']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Observaciones</th>
                                  <th>Detalles</th>
                                  <th>Status</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>

    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td class="font-10 bold"><?php echo $reg[$i]['detalles']; ?></td>
      
      <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

<td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "0"; } 
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
        elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
           <td><?php echo $simbolo.number_format($reg[$i]['totalpago'] - $reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>
<?php } ?>

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-warning btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-outline-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

</td>
                                  </tr>
                        <?php  }  ?>
         <tr>
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
                              </tbody>
                          </table>
                      </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php
  
   }
 } 
########################## BUSQUEDA DETALLES CREDITOS POR PACIENTE ##########################
?>
