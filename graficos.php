<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession();
$con = $tra->ContarRegistros();
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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gráficos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Gráficos</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Gráficos</li>
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

        <?php } else { ?>

        <!-- ============================================================== -->
        <!-- Graficos Individual por Sucursal -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Gráfico de Registros
                    </h5>
                    <div id="chart-container">
                        <canvas id="bar-chart" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Pacientes", "Proveedores", "Productos", "Compras", "Ventas"],
                            datasets: [
                            {
                                label: "Cantidad Nº",
                                backgroundColor: ["#2f323e", "#3e95cd","#0a4f90","#f0ad4e","#900a16"],
                                data: [<?php echo $con[0]['pacientes'] ?>,<?php echo $con[0]['proveedores'] ?>,<?php echo $con[0]['productos'] ?>,<?php echo $con[0]['compras'] ?>,<?php echo $con[0]['ventas'] ?>]
                            }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Cantidad de Registros'
                            }
                        }
                    });
                    </script>
                    </div>
                </div>
            </div>

    <?php  
    $compra = new Login();
    $commes = $compra->SumaCompras();

    $cotizacion = new Login();
    $cotmes = $cotizacion->SumaCotizaciones();

    $venta = new Login();
    $venmes = $venta->SumaVentas();

    $ingresos = new Login();
    $ingresomes = $ingresos->SumaIngresos();

    $egresos = new Login();
    $egresomes = $egresos->SumaEgresos();
    ?>

            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Compras del Año <?php echo date("Y"); ?>  
                    </h5>
                    <div id="chart-container">
                        <canvas id="bar-chart2" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart2"), {
                        type: 'bar',
                        data: {
                            labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                            datasets: [
                            {
                            label: "Monto Mensual",
                            backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#25AECD","#008080","#00FFFF","#3cba9f","#2E64FE","#e8c3b9","#F7BE81","#FA5858"],
                            data: [<?php 

                              if($commes == "") { echo 0; } else {

                                  $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                                  foreach($commes as $row) {
                                    $mes = $row['mes'];
                                    $meses[$mes] = $row['totalmes'];
                                }
                                foreach($meses as $mes) {
                                    echo "{$mes},"; } } ?>]
                                }]
                            },
                            options: {
                                legend: { display: false },
                                title: {
                                    display: true,
                                    text: 'Suma de Monto Mensual'
                                }
                            }
                        });
                    </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Cotizaciones del Año <?php echo date("Y"); ?>  
                    </h5>
                    <div id="chart-container">
                        <canvas id="bar-chart3" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart3"), {
                        type: 'bar',
                        data: {
                            labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                            datasets: [
                            {
                                label: "Monto Mensual",
                    backgroundColor: ["#CACFD8","#F2D6C4","#7B82EC","#ff7676","#987DDB","#E8AC9E","#7DA5EA","#8EE1BC","#D3E37D","#E399DA","#F7BE81","#FA5858"],
                    data: [<?php 

                      if($cotmes == "") { echo 0; } else {

                          $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                          foreach($cotmes as $row) {
                            $mes = $row['mes'];
                            $meses[$mes] = $row['totalmes'];
                        }
                        foreach($meses as $mes) {
                            echo "{$mes},"; } } ?>]
                        }]
                    },
                    options: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Ventas del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                        <canvas id="bar-chart4" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart4"), {
                    type: 'bar',
                    data: {
                        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                        datasets: [
                        {
                            label: "Monto Mensual",
                            backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#7B82EC","#8EE1BC","#D3E37D","#E8AC9E","#2E64FE","#E399DA","#F7BE81","#FA5858"],
                            data: [<?php 

                              if($venmes == "") { echo 0; } else {

                                  $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                                  foreach($venmes as $row) {
                                    $mes = $row['mes'];
                                    $meses[$mes] = $row['totalmes'];
                                }
                                foreach($meses as $mes) {
                                    echo "{$mes},"; } } ?>]
                                }]
                            },
                            options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title text-uppercase mb-0">
                        Ingresos y Egresos del Año <?php echo date("Y"); ?>
                    </h5>
                    <div id="chart-container">
                        <canvas id="bar-chart5" width="800" height="400"></canvas>
                    </div>
                    <script>
                    // Bar chart
                    new Chart(document.getElementById("bar-chart5"), {
                    type: 'bar',
                    data: {
                        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
                        datasets: [
                        {
                            label: "Ingresos",
                            backgroundColor: ["#ff7676","#3e95cd","#808080","#F38630","#7B82EC","#8EE1BC","#D3E37D","#E8AC9E","#2E64FE","#E399DA","#F7BE81","#FA5858"],
                            data: [<?php 

                            if($ingresomes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($ingresomes as $row) {
                                    $mes = $row['mesingreso'];
                                    $meses[$mes] = $row['totalingresos'];
                            }
                            foreach($meses as $mes) {
                                echo "{$mes},";
                            } } ?>]
                        },
                        {
                            label: "Egresos",
                            backgroundColor: ["#FA5858","#32abad","#1b5d7b","#ed3d17","#a27777","#0d165f","#00FFFF","#620b0b","#6ba34d","#b1af2f","#b12f3f","#217c41"],
                            data: [<?php 

                            if($egresomes == "") { echo 0; } else {

                            $meses = array(1 => 0, 2=> 0, 3=> 0, 4=> 0, 5=> 0, 6=> 0, 7=> 0, 8=> 0, 9=> 0, 10=> 0, 11=> 0, 12 => 0);
                            foreach($egresomes as $row) {
                                    $mes = $row['mesegreso'];
                                    $meses[$mes] = $row['totalegresos'];
                            }
                            foreach($meses as $mes) {
                                echo "{$mes},";
                            } } ?>]
                        }]
                            },
                            options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Suma de Monto Mensual'
                            }
                        }
                    });
                    </script>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0">
                            5 Productos Mas Vendidos del Año <?php echo date("Y"); ?>
                        </h5>
                        <div id="chart-container">
                            <canvas id="DoughnutChart" width="600" height="300"></canvas>
                        </div>
                        <script>
                        $(document).ready(function () {
                            showGraphDoughnutPV();
                        });
                        </script>
                    </div>
                </div>
            </div>

            <!--<div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0">
                            Total en Ventas del Año <?php echo date("Y"); ?>
                        </h5>
                        <div id="chart-container">
                            <canvas id="DoughnutChart2" width="800" height="500"></canvas>
                        </div>
                        <script>
                        $(document).ready(function () {
                            showGraphDoughnutVU();
                        });
                        </script>
                    </div>
                </div>
            </div>-->
        </div>
        <!-- ============================================================== -->
        <!-- Graficos Individual por Sucursal  -->
        <!-- ============================================================== -->



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