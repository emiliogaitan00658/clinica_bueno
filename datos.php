<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$reg = $tra->EspecialistasPorId();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarMisDatos();
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
            <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Actualizar Mis Datos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Actualizar</li>
                                <li class="breadcrumb-item active" aria-current="page">Mis Datos</li>
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
                <h4 class="card-title text-white"><i class="fa fa-save"></i> Actualizar Mis Datos</h4>
            </div>
            <form class="form-material" method="post" data-id="<?php echo $reg[0]["codespacielista"] ?>" action="#" name="updatedatos" id="updatedatos" enctype="multipart/form-data">

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

           <div class="form-body">

            <div class="card-body">

             <div class="row">
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tarjeta Profesional: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="tpespecialista" id="tpespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Tarjeta Profesional" autocomplete="off" value="<?php echo $reg[0]['tpespecialista']; ?>" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <input type="hidden" name="proceso" id="proceso" value="update"/>
                        <input type="hidden" class="form-control" name="codespecialista" id="codespecialista" value="<?php echo encrypt($reg[0]['codespecialista']); ?>"/>
                        <input type="hidden" class="form-control" name="cedespecialista" id="cedespecialista" value="<?php echo $reg[0]['cedespecialista']; ?>" required="" aria-required="true"/>
                        <select name="documespecialista" id="documespecialista" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $doc = new Login();
                        $doc = $doc->ListarDocumentos();
                        if($doc==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($doc);$i++){ ?>
                        <option value="<?php echo $doc[$i]['coddocumento'] ?>"<?php if (!(strcmp($reg[0]['documespecialista'], htmlentities($doc[$i]['coddocumento'])))) { echo "selected=\"selected\""; } ?>><?php echo $doc[$i]['documento'] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="cedula" id="cedula" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" value="<?php echo $reg[0]['cedespecialista']; ?>" disabled="" required="" aria-required="true"/> 
                        <i class="fa fa-bolt form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombres y Apellidos: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="nomespecialista" id="nomespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombres y Apellidos" autocomplete="off" value="<?php echo $reg[0]['nomespecialista']; ?>" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                        <input type="text" class="form-control phone-inputmask" name="tlfespecialista" id="tlfespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" value="<?php echo $reg[0]['tlfespecialista']; ?>" required="" aria-required="true"/>  
                        <i class="fa fa-phone form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Sexo: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select name="sexoespecialista" id="sexoespecialista" class="form-control" required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <option value="MASCULINO"<?php if (!(strcmp('MASCULINO', $reg[0]['sexoespecialista']))) {echo "selected=\"selected\"";} ?>>MASCULINO</option>
                            <option value="FEMENINO"<?php if (!(strcmp('FEMENINO', $reg[0]['sexoespecialista']))) {echo "selected=\"selected\"";} ?>>FEMENINO</option>
                        </select> 
                    </div>
                </div>

                <div class="col-md-3">
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
                                <option value="<?php echo $departamento[$i]['id_departamento'] ?>"<?php if (!(strcmp($reg[0]['id_departamento'], htmlentities($departamento[$i]['id_departamento'])))) { echo "selected=\"selected\""; } ?>><?php echo $departamento[$i]['departamento'] ?></option>
                            <?php } } ?>
                        </select>
                    </div>
               </div>

               <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Seleccione Provincia: </label>
                        <i class="fa fa-bars form-control-feedback"></i> 
                        <select name="id_provincia" id="id_provincia" class="form-control" tabindex="6" required="" aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $provincia = new Login();
                            $provincia = $provincia->ListarProvincias();
                            if($provincia==""){ 
                                echo "";
                            } else {
                            for($i=0;$i<sizeof($provincia);$i++){ ?>
                                <option value="<?php echo $provincia[$i]['id_provincia'] ?>"<?php if (!(strcmp($reg[0]['id_provincia'], htmlentities($provincia[$i]['id_provincia'])))) { echo "selected=\"selected\""; } ?>><?php echo $provincia[$i]['provincia'] ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="direcespecialista" id="direcespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" autocomplete="off" value="<?php echo $reg[0]['direcespecialista']; ?>" required="" aria-required="true"/>  
                        <i class="fa fa-map-marker form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Correo Electronico: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="correoespecialista" id="correoespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" value="<?php echo $reg[0]['correoespecialista']; ?>" required="" aria-required="true"/> 
                        <i class="fa fa-envelope-o form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Especialidad: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="especialidad" id="especialidad" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Especialidad" autocomplete="off" value="<?php echo $reg[0]['especialidad']; ?>" required="" aria-required="true">
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Fecha de Nacimiento: </label>
                        <input type="text" class="form-control fnacimiento" name="fnacespecialista" id="fnacespecialista" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Nacimiento" autocomplete="off" value="<?php echo $reg[0]['fnacespecialista'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fnacespecialista'])); ?>" required="" aria-required="true">
                        <i class="fa fa-calendar form-control-feedback"></i> 
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Twitter: </label>
                        <input type="text" class="form-control" name="twitter" id="twitter" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Red Social Twitter" autocomplete="off" value="<?php echo $reg[0]['twitter']; ?>" required="" aria-required="true"/> 
                        <i class="fa fa-twitter form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Facebook: </label>
                        <input type="text" class="form-control" name="facebook" id="facebook" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['facebook']; ?>" placeholder="Ingrese Red Social Facebook" required="" aria-required="true">
                        <i class="fa fa-facebook form-control-feedback"></i> 
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Instagram: </label>
                        <input type="text" class="form-control" name="instagram" id="instagram" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['instagram']; ?>" placeholder="Ingrese Red Social Instagram" required="" aria-required="true">
                        <i class="fa fa-instagram form-control-feedback"></i> 
                    </div>
                </div> 

                <div class="col-md-3">
                    <div class="form-group has-feedback">
                        <label class="control-label">Red Social Google-Plus: </label>
                        <input type="text" class="form-control" name="google" id="google" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]['google']; ?>" placeholder="Ingrese Red Social Google-Plus" required="" aria-required="true">
                        <i class="fa fa-google-plus form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                      <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 90px; height: 110px;">
                        <?php if (file_exists("fotos/".$reg[0]['codespecialista'].".jpg")){
                            echo "<img src='fotos/".$reg[0]['codespecialista'].".jpg?".date('h:i:s')."' class='img-rounded' border='0' width='90' height='110' title='Logo' data-rel='tooltip'>";
                        } else {
                            echo "<img src='fotos/img.png' class='img-rounded' border='0' width='90' height='110' title='Sin Logo' data-rel='tooltip'>"; 
                        } ?>
                    </div>
                    <div>
                      <span class="btn btn-danger btn-file">
                          <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-file-image-o"></i> Fotografia</span>
                          <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-paint-brush"></i> Fotografia</span>
                          <input type="file" size="10" data-original-title="Subir Logo Principal" data-rel="tooltip" placeholder="Suba su Logo Principal" name="imagen" id="imagen" tabindex="15"/>
                      </span>
                      <a href="#" class="btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> Remover</a><small><p>Para Subir su Fotografia debe tener en cuenta:<br> * La Fotografia debe ser extension.jpg<br> * La imagen no debe ser mayor de 50 KB</p></small>                             
                    </div>
                  </div>
              </div>
          </div>

          <div class="text-right">
            <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>
            <button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button>
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