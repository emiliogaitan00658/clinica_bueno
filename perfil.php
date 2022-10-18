<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista" || $_SESSION["acceso"]=="paciente") {

$tra = new Login();
$ses = $tra->ExpiraSession();        
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
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">                    
    
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
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Perfil</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Principal</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Mi Perfil</li>
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
               

<?php if ($_SESSION['acceso'] == "paciente") {

$new = new Login();
$reg = $new->PacientesPorId();
?>

<!-- Row -->
<div class="row">
    <div class="col-lg-5">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-image"></i> Foto de Perfil</h4>
            </div>

            <div class="form-body">

             <div class="card-body">
                <center class="mt-4"> 
            <?php if (isset($reg[0]['cedpaciente'])) {
                if (file_exists("fotos/".$reg[0]['cedpaciente'].".jpg")){
                  echo "<img src='fotos/".$reg[0]['cedpaciente'].".jpg?' width='150' class='rounded-circle'>"; 
                      } else {
                  echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                      } } else {
                  echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                    } ?>
                        <h4 class="card-title mt-2"><?php echo $reg[0]['pnompaciente']." ".$reg[0]['snompaciente']." ".$reg[0]['papepaciente']." ".$reg[0]['sapepaciente']; ?></h4>
                        <h5 class="card-title mt-2"><?php echo $_SESSION['nivel']; ?></h5>
                        <h6 class="card-subtitle"><?php echo $reg[0]['emailpaciente']; ?></h6>
                    </center>
                </div>
            </div>
        </div>
    </div>
<!--</div>
End Row -->

<!-- Row 
<div class="row">-->
    <div class="col-lg-7">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Perfil de Paciente</h4>
            </div>
            <form class="form form-material" method="post" action="#">

                <div class="form-body">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Documento"><?php echo $reg[0]["documento"]." ".$reg[0]['cedpaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nombre y Apellidos: <span class="symbol required"></span></label>
                                <br /><abbr title="Nombre y Apellidos"><?php echo $reg[0]['pnompaciente']." ".$reg[0]['snompaciente']." ".$reg[0]['papepaciente']." ".$reg[0]['sapepaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Fecha de Nacimiento: <span class="symbol required"></span></label>
                                <br /><abbr title="Fecha de Nacimiento"><?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "0000-00-00" : date("Y-m-d",strtotime($reg[0]['fnacpaciente'])); ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Telefono: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Telefono"><?php echo $reg[0]['tlfpaciente'] == "" ? "**********" : $reg[0]['tlfpaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Correo Electronico: <span class="symbol required"></span></label>
                                <br /><abbr title="Correo Electronico"><?php echo $reg[0]['emailpaciente'] == "" ? "**********" : $reg[0]['emailpaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Grupo Sanguineo: <span class="symbol required"></span></label>
                                <br /><abbr title="Grupo Sanguineo"><?php echo $reg[0]['gruposapaciente'] == "" ? "**********" : $reg[0]['gruposapaciente']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Estado Laboral: <span class="symbol required"></span></label>
                                <br /><abbr title="Estado Laboral"><?php echo $reg[0]['estadopaciente'] == "" ? "**********" : $reg[0]['estadopaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Ocupación Laboral: <span class="symbol required"></span></label>
                                <br /><abbr title="Ocupación Laboral"><?php echo $reg[0]['ocupacionpaciente'] == "" ? "**********" : $reg[0]['ocupacionpaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Sexo: <span class="symbol required"></span></label>
                                <br /><abbr title="Sexo"><?php echo $reg[0]['sexopaciente'] == "" ? "**********" : $reg[0]['sexopaciente']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Enfoque Diferencial: <span class="symbol required"></span></label>
                                <br /><abbr title="Enfoque Diferencial"><?php echo $reg[0]['enfoquepaciente'] == "" ? "**********" : $reg[0]['enfoquepaciente']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Departamento: <span class="symbol required"></span></label>
                                <br /><abbr title="Departamento"><?php echo $reg[0]['id_departamento'] == "0" ? "**********" : $reg[0]['departamento']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Provincia: <span class="symbol required"></span></label>
                                <br /><abbr title="Provincia"><?php echo $reg[0]['id_provincia'] == "0" ? "**********" : $reg[0]['provincia']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                                <br /><abbr title="Dirección Domiciliaria"><?php echo $reg[0]['direcpaciente']; ?></abbr>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Row -->

<?php } elseif ($_SESSION['acceso'] == "especialista") {

$new = new Login();
$reg = $new->EspecialistasPorId(); 
?>

<!-- Row -->
<div class="row">
    <div class="col-lg-5">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Foto de Perfil</h4>
            </div>

            <div class="form-body">

             <div class="card-body">
                <center class="mt-4"> 
            <?php if (isset($reg[0]['cedespecialista'])) {
                        if (file_exists("fotos/".$reg[0]['codespecialista'].".jpg")){
                            echo "<img src='fotos/".$reg[0]['codespecialista'].".jpg?' width='150' class='rounded-circle'>"; 
                        } else {
                            echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                        } } else {
                            echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                        } ?>
                        <h4 class="card-title mt-2"><?php echo $reg[0]['nomespecialista']; ?></h4>
                        <h5 class="card-title mt-2"><?php echo $_SESSION['nivel']; ?></h5>
                        <h6 class="card-subtitle"><?php echo $reg[0]['correoespecialista']; ?></h6>
                    </center>
                </div>
            </div>
        </div>
    </div>
<!--</div>
End Row -->

<!-- Row 
<div class="row">-->
    <div class="col-lg-7">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Perfil de Especialista</h4>
            </div>
            <form class="form form-material" method="post" action="#">

                <div class="form-body">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Tarjeta Profesional: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Tarjeta Profesional"><?php echo $reg[0]['tpespecialista']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Documento"><?php echo $reg[0]["documento"]." ".$reg[0]['cedespecialista']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nombre y Apellidos: <span class="symbol required"></span></label>
                                <br /><abbr title="Nombre y Apellidos"><?php echo $reg[0]['nomespecialista']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Sexo de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Sexo de Usuario"><?php echo $reg[0]['sexoespecialista']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Departamento: <span class="symbol required"></span></label>
                                <br /><abbr title="Departamento"><?php echo $reg[0]['id_departamento'] == "0" ? "**********" : $reg[0]['departamento']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Provincia: <span class="symbol required"></span></label>
                                <br /><abbr title="Provincia"><?php echo $reg[0]['id_provincia'] == "0" ? "**********" : $reg[0]['provincia']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                                <br /><abbr title="Dirección Domiciliaria"><?php echo $reg[0]['direcespecialista']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Teléfono"><?php echo $reg[0]['tlfespecialista']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Correo de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Correo de Usuario"><?php echo $reg[0]['correoespecialista']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Especialidad: <span class="symbol required"></span></label>
                                <br /><abbr title="Especialidad"><?php echo $reg[0]['especialidad']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Fecha de Nacimiento: <span class="symbol required"></span></label>
                                <br /><abbr title="Fecha de Nacimiento"><?php echo date("d-m-Y",strtotime($reg[0]['fnacespecialista'])); ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Edad: <span class="symbol required"></span></label>
                                <br /><abbr title="Edad"><?php echo edad($reg[0]['fnacespecialista'])." AÑOS"; ?></abbr> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Row -->

<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-5">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Foto de Perfil</h4>
            </div>

            <div class="form-body">

             <div class="card-body">
                <center class="mt-4"> 
            <?php if (isset($_SESSION['dni'])) {
                if (file_exists("fotos/".$_SESSION['dni'].".jpg")){
                  echo "<img src='fotos/".$_SESSION['dni'].".jpg?' width='150' class='rounded-circle'>"; 
                      } else {
                  echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                      } } else {
                  echo "<img src='fotos/avatar.png' width='150' class='rounded-circle'>"; 
                    } ?>
                        <h4 class="card-title mt-2"><?php echo $_SESSION['nombres']; ?></h4>
                        <h5 class="card-title mt-2"><?php echo $_SESSION['nivel']; ?></h5>
                        <h6 class="card-subtitle"><?php echo $_SESSION['email']; ?></h6>
                    </center>
                </div>
            </div>
        </div>
    </div>
<!--</div>
End Row -->

<!-- Row 
<div class="row">-->
    <div class="col-lg-7">
        <div class="card ">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Perfil de Usuario</h4>
            </div>
            <form class="form form-material" method="post" action="#">

                <div class="form-body">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Documento"><?php echo $_SESSION['dni']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nombre de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Nombre de Usuario"><?php echo $_SESSION['nombres']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Sexo de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Sexo de Usuario"><?php echo $_SESSION['sexo']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                                <br /><abbr title="Dirección Domiciliaria"><?php echo $_SESSION['direccion']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                                <br /><abbr title="Nº de Teléfono"><?php echo $_SESSION['telefono']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Correo de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Correo de Usuario"><?php echo $_SESSION['email']; ?></abbr>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Usuario de Acceso: <span class="symbol required"></span></label>
                                <br /><abbr title="Usuario de Acceso"><?php echo $_SESSION['usuario']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Nivel de Acceso: <span class="symbol required"></span></label>
                                <br /><abbr title="Nivel de Acceso"><?php echo $_SESSION['nivel']; ?></abbr>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group has-feedback">
                                <label class="control-label">Status de Usuario: <span class="symbol required"></span></label>
                                <br /><abbr title="Status de Usuario"><?php echo $status = ( $_SESSION['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></abbr> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Row -->

<?php } ?>
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
       $('#modelos').load("consultas?CargaModelos=si");
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