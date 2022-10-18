<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista" || $_SESSION["acceso"]=="paciente") {

$tra = new Login();
$ses = $tra->ExpiraSession();
$con = $tra->ContarRegistros();
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
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
    <!-- timepicker CSS -->
    <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">

    <!-- script jquery -->
    <script src="assets/script/jquery.min.js"></script> 
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/plugins/chart.js/chart.min.js"></script>
    <script type="text/javascript" src="assets/script/graficos.js"></script>
    <!-- script jquery -->

    <!-- FullCalendar -->
    <link href="assets/css/fullcalendar.min.css" rel="stylesheet" /> 
    <link href="assets/css/calendar.css" rel="stylesheet" />
    <!-- FullCalendar -->

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
    <!--<div id="main-wrapper" data-layout="horizontal" data-navbarbg="skin6" data-sidebartype="mini-sidebar" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">-->

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 



<!--############################## MODAL PARA AGREGAR CITA ######################################-->
<!-- sample modal content -->
<div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Cita</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>

            <form class="form form-material" method="POST" name="savecitas" id="savecitas">
            
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Sucursal: <span class="symbol required"></span></label>
                            <br /><abbr title="Nombre de Sucursal"><label id="sucursal"></label></abbr>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Paciente: <span class="symbol required"></span></label>
                            <br /><abbr title="Nombre de Paciente"><label id="nompaciente"></label></abbr>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Nombre de Especialista: <span class="symbol required"></span></label>
                            <br /><abbr title="Nombre de Especialista"><label id="nomespecialista"></label></abbr>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Motivo de Cita: <span class="symbol required"></span></label>
                            <br /><abbr title="Motivo de Cita"><label id="movitocita"></label></abbr>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Fecha de Cita: <span class="symbol required"></span></label>
                            <br /><abbr title="Fecha de Cita"><label id="fechacita"></label></abbr>
                        </div>
                    </div>
                </div>  

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Hora de Cita: <span class="symbol required"></span></label>
                            <br /><abbr title="Hora de Cita"><label id="horacita"></label></abbr>
                        </div>
                    </div>
                </div>  

            </div>

            <div class="modal-footer">
  <button class="btn btn-info" type="reset" class="close" onClick="Cerrar();" data-dismiss="modal" aria-text="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA AGREGAR CITA ######################################-->


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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Inicio</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Principal</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Inicio</li>
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
                <!-- First Cards Row  -->
                <!-- ============================================================== -->

        <?php if ($_SESSION['acceso'] == "administradorG") { ?> 

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Sucursales</h5>
                        <div class="d-flex align-items-center mb-2 mt-4">
                            <h2 class="mb-0 display-5"><i class="fa fa-bank text-info"></i></h2>
                            <div class="ml-auto">
                                <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['sucursales']; ?></span></h2>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Usuarios</h5>
                        <div class="d-flex align-items-center mb-2 mt-4">
                            <h2 class="mb-0 display-5"><i class="fa fa-user text-danger"></i></h2>
                            <div class="ml-auto">
                                <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['usuarios']; ?></span></h2>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase">Pacientes</h5>
                        <div class="d-flex align-items-center mb-2 mt-4">
                            <h2 class="mb-0 display-5"><i class="fa fa-users text-warning"></i></h2>
                            <div class="ml-auto">
                                <h2 class="mb-0 display-6"><span class="font-normal"><?php echo $con[0]['pacientes']; ?></span></h2>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="col-md-6 col-lg-3">-->
<!--                <div class="card">-->
<!--                    <div class="card-body">-->
<!--                        <h5 class="card-title text-uppercase">Proveedores</h5>-->
<!--                        <div class="d-flex align-items-center mb-2 mt-4">-->
<!--                            <h2 class="mb-0 display-5"><i class="fa fa-truck text-success"></i></h2>-->
<!--                            <div class="ml-auto">-->
<!--                                <h2 class="mb-0 display-6"><span class="font-normal">--><?php //echo $con[0]['proveedores']; ?><!--</span></h2>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="progress">-->
<!--                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>

        <!-- ============================================================== -->
        <!-- Grafico por Sucursales  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0">
                            Gráficos de Sucursales del Año <?php echo date("Y"); ?>
                        </h5>
                        <div id="chart-container">
                            <canvas id="barChart" width="400" height="100"></canvas>
                        </div>
                        <script>
                            $(document).ready(function () {
                                showGraphBarS();
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Grafico por Sucursales  -->
        <!-- ============================================================== -->

    <?php } elseif ($_SESSION['acceso'] == "especialista") { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">


    <div class="row">

        <!-- .col -->
        <div class="col-md-4">

            <div class="row">

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user"></i></h2>
                                </div>
                                <div>
                                <a href="pacientes"><h4 class="card-title text-white">Pacientes</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['pacientes']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-folder-open"></i></h2>
                                </div>
                                <div>
                                <a href="servicios"><h4 class="card-title text-white">Servicios</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['servicios']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cubes"></i></h2>
                                </div>
                                <div>
                                <a href="productos"><h4 class="card-title text-white">Productos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['productos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calculator"></i></h2>
                                </div>
                                <div>
                                <a href="forcotizacion"><h4 class="card-title text-white">Cotizaciones</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['cotizaciones']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calendar"></i></h2>
                                </div>
                                <div>
                                <a href="forcita"><h4 class="card-title text-white">Citas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['citas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-diamond"></i></h2>
                                </div>
                                <div>
                                <a href="forodontologia"><h4 class="card-title text-white">Odontologia</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['odontologia']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col -->


        
        <!-- .col -->  
        <div class="col-md-8">

            <div class="row">
                <div class="col-lg-12">
                            
                <div id="cargacalendario"></div>

                </div>
            </div>

        </div>
       <!-- /.col -->

                                   
    </div>


    </div>
</div>
<!-- End Row -->

    <?php } elseif ($_SESSION['acceso'] == "paciente") { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">


    <div class="row">

        <!-- .col -->
        <div class="col-md-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calendar"></i></h2>
                                </div>
                                <div>
                                <a href="citas"><h4 class="card-title text-white">Citas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['citas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-diamond"></i></h2>
                                </div>
                                <div>
                                <a href="odontologia"><h4 class="card-title text-white">Odontologia</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['odontologia']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calculator"></i></h2>
                                </div>
                                <div>
                                <a href="cotizaciones"><h4 class="card-title text-white">Cotizaciones</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['cotizaciones']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-clipboard"></i></h2>
                                </div>
                                <div>
                                <a href="facturaciones"><h4 class="card-title text-white">Facturas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['ventas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.col -->

        
        <!-- .col -->  
        <div class="col-md-8">

            <div class="row">
                <div class="col-lg-12">
                            
                <div id="cargacalendario"></div>

                </div>
            </div>

        </div>
       <!-- /.col -->

                                   
    </div>


    </div>
</div>
<!-- End Row -->

    <?php } elseif ($_SESSION['acceso'] == "cajero") { ?>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">


    <div class="row">

        <!-- .col -->
        <div class="col-md-4">

            <div class="row">

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user-md"></i></h2>
                                </div>
                                <div>
                                <a href="especialistas"><h4 class="card-title text-white">Especialistas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['especialistas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user"></i></h2>
                                </div>
                                <div>
                                <a href="pacientes"><h4 class="card-title text-white">Pacientes</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['pacientes']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-folder-open"></i></h2>
                                </div>
                                <div>
                                <a href="servicios"><h4 class="card-title text-white">Servicios</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['servicios']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cubes"></i></h2>
                                </div>
                                <div>
                                <a href="productos"><h4 class="card-title text-white">Productos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['productos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calculator"></i></h2>
                                </div>
                                <div>
                                <a href="forcotizacion"><h4 class="card-title text-white">Cotizaciones</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['cotizaciones']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calendar"></i></h2>
                                </div>
                                <div>
                                <a href="forcita"><h4 class="card-title text-white">Citas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['citas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <a href="arqueos"><h4 class="card-title text-white">Ingresos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['ingresos'] == "" ? "0.00" : $con[0]['ingresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <a href="arqueos"><h4 class="card-title text-white">Egresos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['egresos'] == "" ? "0.00" : $con[0]['egresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
        <!-- /.col -->


        
        <!-- .col -->  
        <div class="col-md-8">

            <div class="row">
                <div class="col-lg-12">
                            
                <div id="cargacalendario"></div>

                </div>
            </div>

        </div>
       <!-- /.col -->

                                   
    </div>


    </div>
</div>
<!-- End Row -->


<?php } else { ?>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">

    <div class="row">

        <!-- .col -->
        <div class="col-md-4">

            <div class="row">

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user-md"></i></h2>
                                </div>
                                <div>
                                <a href="especialistas"><h4 class="card-title text-white">Especialistas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['especialistas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-user"></i></h2>
                                </div>
                                <div>
                                <a href="pacientes"><h4 class="card-title text-white">Pacientes</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['pacientes']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-folder-open"></i></h2>
                                </div>
                                <div>
                                <a href="servicios"><h4 class="card-title text-white">Servicios</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['servicios']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cubes"></i></h2>
                                </div>
                                <div>
                                <a href="productos"><h4 class="card-title text-white">Productos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['productos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-cart-plus"></i></h2>
                                </div>
                                <div>
                                <a href="forcompra"><h4 class="card-title text-white">Compras</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['compras']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calculator"></i></h2>
                                </div>
                                <div>
                                <a href="forcotizacion"><h4 class="card-title text-white">Cotizaciones</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['cotizaciones']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-calendar"></i></h2>
                                </div>
                                <div>
                                <a href="forcita"><h4 class="card-title text-white">Citas</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['citas']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-diamond"></i></h2>
                                </div>
                                <div>
                                <a href="<?php echo $_SESSION['acceso'] == "secretaria" ? "odontologia" : "forodontologia"; ?>"><h4 class="card-title text-white">Odontologia</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['odontologia']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <a href="arqueos"><h4 class="card-title text-white">Ingresos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['ingresos'] == "" ? "0.00" : $con[0]['ingresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mr-3 align-self-center">
                                <h2 class="text-white"><i class="fa fa-usd"></i></h2>
                                </div>
                                <div>
                                <a href="arqueos"><h4 class="card-title text-white">Egresos</h4></a>
                                <h4 class="card-subtitle text-white"><?php echo $con[0]['egresos'] == "" ? "0.00" : $con[0]['egresos']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
        <!-- /.col -->

        
        <!-- .col -->  
        <div class="col-md-8">

            <div class="row">
                <div class="col-lg-12">
                            
                <div id="cargacalendario"></div>

                </div>
            </div>

        </div>
       <!-- /.col -->

                                   
    </div>


    </div>
</div>
<!-- End Row -->



    <?php } ?> 

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
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>
    
    <!-- FullCalendar -->
    <script src='assets/js/moment.min.js'></script>
    <script src='assets/plugins/fullcalendar/fullcalendar.min.js'></script>
    <script src='assets/plugins/fullcalendar/locale/es.js'></script>
    <!-- FullCalendar -->

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
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
    <script type="text/javascript" src="assets/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>

    <script type="text/jscript">
    $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
     setTimeout(function() {
    $('#cargacalendario').load("calendario?Calendario_Principal=si");
    }, 100);
    </script>
    <!-- jQuery -->

</body>
</html>

<?php } else { ?>   
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
        document.location.href='logout'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>