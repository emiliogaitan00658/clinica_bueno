<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarEspecialistas();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarEspecialistas();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="cargaespecialistas")
{
$reg = $tra->CargaEspecialistas();
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



<!--############################## MODAL PARA VER DETALLE DE ESPECIALISTA ######################################-->
<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Especialista</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                <div id="muestraespecialistamodal"></div> 

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
<!--############################## MODAL PARA VER DETALLE DE ESPECIALISTA ######################################-->  

                  
<?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") { ?>

<!--############################## MODAL PARA VER CARGA MASIVA DE ESPECIALISTAS ######################################-->
<!-- sample modal content -->
<div id="myModalCargaMasiva" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Carga Masiva</h4>
                <button type="button" onClick="ModalEspecialista()" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
            <form class="form form-material" name="cargaespecialistas" id="cargaespecialistas" action="#" enctype="multipart/form-data">
                
             <div class="modal-body">

             <div class="row">
                <div class="col-md-12"> 
                    <div class="form-group has-feedback">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="form-group has-feedback"> 
                    <label class="control-label">Realice la Búsqueda del Archivo (CSV): <span class="symbol required"></span></label>
                    <div class="input-group">
                    <div class="form-control" data-trigger="fileinput"><i class="fa fa-file-archive-o fileinput-exists"></i>
                        <span class="fileinput-filename"></span>
                    </div>
                    <input type="hidden" name="proceso" value="cargaespecialistas"/>
                    <span class="input-group-addon btn btn-success btn-file">
                    <span class="fileinput-new"><i class="fa fa-cloud-upload"></i> Selecciona Archivo</span>
                    <span class="fileinput-exists"><i class="fa fa-file-archive-o"></i> Cambiar</span>
                    <input type="file" class="btn btn-default" data-original-title="Suba su Archivo CSV" data-rel="tooltip" placeholder="Suba su Imagen" name="sel_file" id="sel_file" autocomplete="off" required="" aria-required="true">
                    </span>
                    <a href="#" class="input-group-addon btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Quitar</a>
                            </div><small><p>Para realizar la Carga masiva de Especialistas el archivo debe de ser extensión (CSV Delimitado por Comas). Debe de llevar la cantidad de filas y columnas explicadas para la Carga exitosa de los registros.<br></small>
                            <div id="divespecialista"></div>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
            
        </div>

        <div class="modal-footer">
            <button type="button" onClick="CargaDivEspecialista()" class="btn btn-success"><span class="fa fa-eye"></span> Ver Detalles</button>
            <button type="submit" name="btn-especialista" id="btn-especialista" class="btn btn-danger"><span class="fa fa-cloud-upload"></span> Cargar</button>
            <button type="button" onClick="ModalEspecialista()" class="btn btn-info" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
        </div>
    </form>

</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA VER CARGA MASIVA DE ESPECIALISTAS ######################################-->


<!--############################## MODAL PARA REGISTRO DE NUEVO ESPECIALISTA ######################################-->
<!-- sample modal content -->
<div id="myModalEspecialista" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Especialistas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
    <form class="form form-material" method="post" action="#" name="saveespecialista" id="saveespecialista" enctype="multipart/form-data">
                
            <div class="modal-body">

            <h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-account-settings"></i> Datos Personales</h2><hr>    

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tarjeta Profesional: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="tpespecialista" id="tpespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Tarjeta Profesional" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <input type="hidden" name="proceso" id="proceso" value="save"/>
                        <input type="hidden" class="form-control" name="codespecialista" id="codespecialista"/>
                        <select name="documespecialista" id="documespecialista" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $doc = new Login();
                        $doc = $doc->ListarDocumentos();
                        if($doc==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($doc);$i++){ ?>
                        <option value="<?php echo $doc[$i]['coddocumento'] ?>"><?php echo $doc[$i]['documento'] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="cedespecialista" id="cedespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-bolt form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombres y Apellidos: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="nomespecialista" id="nomespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombres y Apellidos" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                        <input type="text" class="form-control phone-inputmask" name="tlfespecialista" id="tlfespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-phone form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Sexo: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="sexoespecialista" id="sexoespecialista" class="form-control" required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <option value="MASCULINO">MASCULINO</option>
                            <option value="FEMENINO">FEMENINO</option>
                        </select> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Departamento: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select class="form-control" id="id_departamento" name="id_departamento" onChange="CargaProvincias(this.form.id_departamento.value);" required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $departamento = new Login();
                            $departamento = $departamento->ListarDepartamentos();
                            if($departamento==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($departamento);$i++){ ?>
                                <option value="<?php echo $departamento[$i]['id_departamento'] ?>"><?php echo $departamento[$i]['departamento'] ?></option>
                            <?php } } ?>
                        </select>
                    </div>
               </div>

               <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Ciudad: </label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <select name="id_provincia" id="id_provincia" class="form-control" tabindex="6" required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="direcespecialista" id="direcespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-map-marker form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Correo Electronico: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="correoespecialista" id="correoespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-envelope-o form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Especialidad: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="especialidad" id="especialidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Especialidad" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div> 

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Fecha de Nacimiento: </label>
                        <input type="text" class="form-control fnacimiento" name="fnacespecialista" id="fnacespecialista" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha de Nacimiento" required="" aria-required="true">
                        <i class="fa fa-calendar form-control-feedback"></i> 
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Twitter: </label>
                        <input type="text" class="form-control" name="twitter" id="twitter" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Red Social Twitter" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-twitter form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Facebook: </label>
                        <input type="text" class="form-control" name="facebook" id="facebook" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Red Social Facebook" required="" aria-required="true">
                        <i class="fa fa-facebook form-control-feedback"></i> 
                    </div>
                </div> 

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Instagram: </label>
                        <input type="text" class="form-control" name="instagram" id="instagram" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Red Social Instagram" required="" aria-required="true">
                        <i class="fa fa-instagram form-control-feedback"></i> 
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Google-Plus: </label>
                        <input type="text" class="form-control" name="google" id="google" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Red Social Google-Plus" required="" aria-required="true">
                        <i class="fa fa-google-plus form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4"> 
                    <div class="form-group has-feedback">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="form-group has-feedback"> 
                                <label class="control-label">Realice la Búsqueda de Foto: </label>
                                <div class="input-group">
                                    <div class="form-control" data-trigger="fileinput"><i class="fa fa-file-photo-o fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-danger btn-file">
                                        <span class="fileinput-new"><i class="fa fa-cloud-upload"></i> Selecciona Imagen</span>
                                        <span class="fileinput-exists"><i class="fa fa-file-photo-o"></i> Cambiar</span>
                                        <input type="file" class="btn btn-default" data-original-title="Subir Imagen" data-rel="tooltip" placeholder="Suba su Imagen" name="imagen" id="imagen" autocomplete="off" title="Buscar Archivo">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Quitar</a>
                                </div><small>Para Subir la Foto debe tener en cuenta:<br> * La Fotografia debe ser extension.jpg<br> * La imagen no debe ser mayor de 50 KB</small>
                            </div>
                        </div>
                    </div> 
                </div>

            </div>

    <?php if ($_SESSION['acceso'] == "administradorG") { ?>

        <h2 class="card-subtitle text-dark"><i class="font-22 mdi mdi-bank"></i> Sucursales</h2><hr>

        <!--ABRE SUCURSALES -->
        <div id="muestrasucursales">

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
                <div class="col-md-4">
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

        </div>
        <!--CIERRE SUCURSALES -->

    <?php } ?>
            
        </div>

            <div class="modal-footer">
                <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-info" type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codespecialista').value = '',
                document.getElementById('tpespecialista').value = '',
                document.getElementById('documespecialista').value = '',
                document.getElementById('cedespecialista').value = '',
                document.getElementById('nomespecialista').value = '',
                document.getElementById('tlfespecialista').value = '',
                document.getElementById('sexoespecialista').value = '',
                document.getElementById('id_departamento').value = '',
                document.getElementById('id_provincia').value = '',
                document.getElementById('direcespecialista').value = '',
                document.getElementById('correoespecialista').value = '',
                document.getElementById('especialidad').value = '',
                document.getElementById('fnacespecialista').value = '',
                document.getElementById('codsucursal').value = '',
                document.getElementById('imagen').value = ''
                " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE NUEVO ESPECIALISTA ######################################-->

<?php } ?>
    
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
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Especialistas</li>
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
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Especialistas</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

            <div class="form-body">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-7">

                          <div class="btn-group m-b-20">
                            <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS") { ?>
                            <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false"><span class="fa fa-cloud-upload text-dark"></span> Cargar</button>

                            <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Especialista" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalEspecialista" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Nuevo</button>
                            <?php } ?>

                        <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-folder-open"></i> Reportes</button>
                            <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                                <a class="dropdown-item" href="reportepdf?tipo=<?php echo encrypt("ESPECIALISTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                                <a class="dropdown-item" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ESPECIALISTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                                <a class="dropdown-item" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ESPECIALISTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-word-o text-dark"></span> Word</a>

                                <a class="dropdown-item" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ESPECIALISTASCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

                            </div>
                        </div> 

                        </div>
                    </div>
                </div>

                <div id="especialistas"></div>

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
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
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
    $('#especialistas').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#especialistas').load("consultas?CargaEspecialistas=si");
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