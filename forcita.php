<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "especialista" || $_SESSION["acceso"] == "paciente") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        if (isset($_POST["proceso"]) and $_POST["proceso"] == "save") {
            $reg = $tra->RegistrarCitas();
            exit;
        } elseif (isset($_POST["proceso"]) and $_POST["proceso"] == "update") {
            $reg = $tra->ActualizarCitas();
            exit;
        } elseif (isset($_POST['Event'][2]) and $_POST['Event'][2] == "editdate") {
            $reg = $tra->ActualizarFechaCitas();
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
            <!-- timepicker CSS -->
            <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
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

            <!-- FullCalendar -->
            <link href="assets/css/fullcalendar.min.css" rel="stylesheet"/>
            <link href="assets/css/calendar.css" rel="stylesheet"/>
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
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
        </div>

        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
             data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">


            <!--############################## MODAL PARA AGREGAR CITA ######################################-->
            <!-- sample modal content -->
            <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i>
                                Gestión de Citas</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img
                                        src="assets/images/close.png"/></button>
                        </div>

                        <form class="form form-material" method="POST" name="savecitas" id="savecitas">

                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Búsqueda de Paciente: <span
                                                        class="symbol required"></span></label>
                                            <input type="hidden" name="proceso" id="proceso" value="save"/>
                                            <input type="hidden" name="codcita" id="codcita">
                                            <input type="hidden" name="codpaciente" id="codpaciente"
                                                   value="<?php echo $_SESSION["acceso"] == "paciente" ? $_SESSION["codpaciente"] : ''; ?>"/>
                                            <input type="hidden" name="delete" id="delete">
                                            <input type="hidden" name="cancelar" id="cancelar">
                                            <?php if ($_SESSION["acceso"] == "paciente") { ?>
                                                <input type="text" class="form-control" name="search_paciente"
                                                       id="search_paciente"
                                                       onKeyUp="this.value=this.value.toUpperCase();"
                                                       placeholder="Ingrese Criterio para la Búsqueda de Paciente"
                                                       value="<?php echo $_SESSION["acceso"] == "paciente" ? $_SESSION["documento"] . " " . $_SESSION["cedpaciente"] . " : " . $_SESSION["pnompaciente"] . " " . $_SESSION["snompaciente"] . " " . $_SESSION["papepaciente"] . " " . $_SESSION["sapepaciente"] : ''; ?>"
                                                       disabled="" autocomplete="off" required="required"/>
                                            <?php } else { ?>
                                                <input type="text" class="form-control" name="search_paciente"
                                                       id="search_paciente"
                                                       onKeyUp="this.value=this.value.toUpperCase();"
                                                       placeholder="Ingrese Criterio para la Búsqueda de Paciente"
                                                       autocomplete="off" required="required"/>
                                            <?php } ?>
                                            <i class="fa fa-search form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($_SESSION["acceso"] == "paciente") { ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">Seleccione Sucursal: <span
                                                            class="symbol required"></span></label>
                                                <i class="fa fa-bars form-control-feedback"></i>
                                                <select name="codsucursal" id="codsucursal" class="form-control"
                                                        onChange="CargaEspecialistas(this.form.codsucursal.value);"
                                                        required="" aria-required="true">
                                                    <option value=""> -- SELECCIONE --</option>
                                                    <?php
                                                    $sucursal = new Login();
                                                    $sucursal = $sucursal->ListarSucursales();
                                                    if ($sucursal == "") {
                                                        echo "";
                                                    } else {
                                                        for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                            ?>
                                                            <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'] . ": " . $sucursal[$i]['nomsucursal']; ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">Seleccione Especialista: <span
                                                            class="symbol required"></span></label>
                                                <i class="fa fa-bars form-control-feedback"></i>
                                                <select name="codespecialista" id="codespecialista" class="form-control"
                                                        required="" aria-required="true">
                                                    <option value=""> -- SIN RESULTADOS --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                <?php } else if ($_SESSION["acceso"] == "especialista") { ?>

                                    <input type="hidden" name="codsucursal" id="codsucursal">
                                    <input type="hidden" name="codespecialista" id="codespecialista"
                                           value="<?php echo encrypt($_SESSION['codespecialista']); ?>"/>

                                <?php } else { ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">Seleccione Especialista: <span
                                                            class="symbol required"></span></label>
                                                <i class="fa fa-bars form-control-feedback"></i>
                                                <input type="hidden" name="codsucursal" id="codsucursal">
                                                <select name="codespecialista" id="codespecialista" class='form-control'
                                                        required="" aria-required="true">
                                                    <option value=""> -- SELECCIONE --</option>
                                                    <?php
                                                    $especialista = new Login();
                                                    $especialista = $especialista->ListarEspecialistas();
                                                    if ($especialista == "") {
                                                        echo "";
                                                    } else {
                                                        for ($i = 0; $i < sizeof($especialista); $i++) { ?>
                                                            <option value="<?php echo encrypt($especialista[$i]['codespecialista']); ?>"><?php echo $especialista[$i]['nomespecialista'] ?></option>
                                                        <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback2">
                                            <label class="control-label">Motivo de Cita: <span
                                                        class="symbol required"></span></label>
                                            <textarea class="form-control" name="descripcion" id="descripcion"
                                                      onKeyUp="this.value=this.value.toUpperCase();"
                                                      placeholder="Ingrese Descripción de Cita" autocomplete="off"
                                                      required="" rows="1" aria-required="true"></textarea>
                                            <i class="fa fa-comments form-control-feedback2"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Seleccione Color: <span
                                                        class="symbol required"></span></label>
                                            <i class="fa fa-bars form-control-feedback"></i>
                                            <select name="color" id="color" class='form-control' required=""
                                                    aria-required="true">
                                                <option value="">-- SELECCIONE --</option>
                                                <option style="color:#0071c5;" value="#0071c5">&#9724; Azul oscuro
                                                </option>
                                                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                                <option style="color:#008000;" value="#008000">&#9724; Verde</option>
                                                <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
                                                <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>
                                                <option style="color:#000;" value="#000">&#9724; Negro</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Fecha de Cita: <span
                                                        class="symbol required"></span></label>
                                            <input type="text" class="form-control expira" name="fechacita"
                                                   id="fechacita" onKeyUp="this.value=this.value.toUpperCase();"
                                                   placeholder="Ingrese Fecha de Cita" autocomplete="off"
                                                   value="<?php echo date("d-m-Y"); ?>" required=""
                                                   aria-required="true"/>
                                            <i class="fa fa-calendar form-control-feedback"></i>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Hora de Cita: <span
                                                        class="symbol required"></span></label>
                                            <input class="form-control" type="text" name="horacita" id="horacita"
                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                   placeholder="Ingrese Hora de Cita" autocomplete="off"
                                                   value="<?php echo date("H:i"); ?>" required="" aria-required="true">
                                            <i class="fa fa-clock-o form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span
                                            class="fa fa-save"></span> Guardar
                                </button>

                                <?php if ($_SESSION["acceso"] != "paciente") { ?>
                                    <button class="btn btn-warning" type="button" id="cancelaevento"
                                            onClick="CancelarCita(document.getElementById('cancelar').value,'<?php echo encrypt("CANCELARCITA") ?>')"
                                            title="Cancelar"><span class="fa fa-times-circle-o"></span> Cancelar
                                    </button>

                                    <button class="btn btn-success" type="button" id="deletevento"
                                            onClick="EliminarCita(document.getElementById('delete').value,'<?php echo encrypt("CITAS") ?>')"
                                            title="Eliminar"><span class="fa fa-trash-o"></span> Eliminar
                                    </button>

                                    <button class="btn btn-info" type="reset" class="close" onClick="Cerrar();"
                                            data-dismiss="modal" aria-text="true"><span class="fa fa-trash-o"></span>
                                        Cerrar
                                    </button>

                                <?php } else { ?>

                                    <button class="btn btn-info" type="reset" class="close" onClick="Limpiar();"
                                            data-dismiss="modal" aria-text="true"><span class="fa fa-trash-o"></span>
                                        Cerrar
                                    </button>
                                <?php } ?>

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
                            <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Citas
                            </h5>
                        </div>
                        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                            <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                                <ol class="breadcrumb mb-0 justify-content-end p-0">
                                    <li class="breadcrumb-item">Citas Odontológicas</li>
                                    <li class="breadcrumb-item active" aria-current="page">Gestión de Citas</li>
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

                    <div id="save">
                        <!-- error will be shown here ! -->
                    </div>

                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-12">

                            <div id="cargacalendario"></div>

                        </div>
                    </div>
                    <!--End Row -->

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
        <link rel="stylesheet" href="assets/calendario/jquery-ui.css"/>
        <script src="assets/calendario/jquery-ui.js"></script>
        <script src="assets/script/jscalendario.js"></script>
        <script src="assets/script/autocompleto.js"></script>
        <!-- Calendario -->

        <!-- jQuery -->
        <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
        <script src="assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript">
            $('body').on('focus', "#horacita", function () {
                $(this).timepicker({showMeridian: false});
            });
        </script>

        <script type="text/jscript">
    $('#cargacalendario').append('<center><i class="fa fa-spin fa-spinner"></i> Por Favor Espere, Cargando Calendario ......</center>').fadeIn("slow");
     setTimeout(function() {
    $('#cargacalendario').load("calendario?Calendario_Secundario=si");
    }, 100);

        </script>
        <!-- jQuery -->

        </body>
        </html>

    <?php } else { ?>
        <script type='text/javascript' language='javascript'>
            alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')
            document.location.href = 'panel'
        </script>
    <?php }
} else { ?>
    <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')
        document.location.href = 'logout'
    </script>
<?php } ?>