<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "especialista" || $_SESSION["acceso"] == "paciente") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();

        if (isset($_POST["proceso"]) and $_POST["proceso"] == "save") {
            $reg = $tra->RegistrarPacientes();
            exit;
        } elseif (isset($_POST["proceso"]) and $_POST["proceso"] == "update") {
            $reg = $tra->ActualizarPacientes();
            exit;
        }
        function generador_codigo()
        {
            $longitud = 10;
            $key = '';
            $pattern = '1234567890';
            $max = strlen($pattern) - 1;
            for ($i = 0; $i < $longitud; $i++) $key .= $pattern{mt_rand(0, $max)};

            return $key;
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
                            <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Pacientes
                            </h5>
                        </div>
                        <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                            <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                                <ol class="breadcrumb mb-0 justify-content-end p-0">
                                    <li class="breadcrumb-item">Mantenimientos</li>
                                    <li class="breadcrumb-item active" aria-current="page">Gestión de Pacientes</li>
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

                    <?php if (isset($_GET['codpaciente']) || $_SESSION['acceso'] == "paciente") {

                    $reg = $tra->PacientesPorId(); ?>

                    <form class="form form-material" method="post" action="#"
                          name="<?php echo $_SESSION['acceso'] == "paciente" ? "updatepacientesession" : "updatepaciente"; ?>"
                          id="<?php echo $_SESSION['acceso'] == "paciente" ? "updatepacientesession" : "updatepaciente"; ?>"
                          data-id="<?php echo $reg[0]["codpaciente"] ?>">

                        <?php } else { ?>

                        <form class="form form-material" method="post" action="#" name="savepaciente" id="savepaciente">

                            <?php } ?>

                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-danger">
                                            <h4 class="card-title text-white"><i class="fa fa-save"></i> Datos del
                                                Paciente </h4>
                                        </div>

                                        <div id="save">
                                            <!-- error will be shown here ! -->
                                        </div>

                                        <div class="form-body">

                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Tipo de Documento: <span
                                                                        class="symbol required"></span></label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <input type="hidden" name="proceso"
                                                                   id="proceso" <?php if (isset($reg[0]['codpaciente']) || $_SESSION['acceso'] == "paciente") { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
                                                            <input type="hidden" class="form-control" name="codpaciente"
                                                                   id="codpaciente" <?php if (isset($reg[0]['codpaciente'])) { ?> value="<?php echo $reg[0]['codpaciente']; ?>"<?php } ?>/>
                                                            <?php if (isset($reg[0]['documpaciente'])) { ?>
                                                                <select name="documpaciente" id="documpaciente"
                                                                        class='form-control' required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <?php
                                                                    $doc = new Login();
                                                                    $doc = $doc->ListarDocumentos();
                                                                    if ($doc == "") {
                                                                        echo "";
                                                                    } else {
                                                                        for ($i = 0; $i < sizeof($doc); $i++) { ?>
                                                                            <option value="<?php echo $doc[$i]['coddocumento'] ?>"<?php if (!(strcmp($reg[0]['documpaciente'], htmlentities($doc[$i]['coddocumento'])))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>><?php echo $doc[$i]['documento'] ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="documpaciente" id="documpaciente"
                                                                        class='form-control' required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <?php
                                                                    $doc = new Login();
                                                                    $doc = $doc->ListarDocumentos();
                                                                    if ($doc == "") {
                                                                        echo "";
                                                                    } else {
                                                                        for ($i = 0; $i < sizeof($doc); $i++) { ?>
                                                                            <option value="<?php echo $doc[$i]['coddocumento'] ?>"><?php echo $doc[$i]['documento'] ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nº de Documento: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="cedpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nº de Documento" <?php if (isset($reg[0]['cedpaciente'])) {
                                                                       ?> value="<?php echo $reg[0]['cedpaciente']; ?>" <?php }else{
                                                            ?>
                                                            value="<?php echo generador_codigo() ?>"
                                                            <?php }
                                                            ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-bolt form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Primer Nombre: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="pnompaciente"
                                                                   id="pnompaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Primer Nombre" <?php if (isset($reg[0]['pnompaciente'])) { ?> value="<?php echo $reg[0]['pnompaciente']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Segundo Nombre: </label>
                                                            <input type="text" class="form-control" name="snompaciente"
                                                                   id="snompaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Segundo Nombre" <?php if (isset($reg[0]['snompaciente'])) { ?> value="<?php echo $reg[0]['snompaciente']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Primer Apellido: <span
                                                                        class="symbol required"></span></label>
                                                            <input type="text" class="form-control" name="papepaciente"
                                                                   id="papepaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Primer Apellido" <?php if (isset($reg[0]['papepaciente'])) { ?> value="<?php echo $reg[0]['papepaciente']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Segundo Apellido: </label>
                                                            <input type="text" class="form-control" name="sapepaciente"
                                                                   id="sapepaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Segundo Apellido" <?php if (isset($reg[0]['sapepaciente'])) { ?> value="<?php echo $reg[0]['sapepaciente']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Fecha de Nacimiento: </label>
                                                            <input type="text" class="form-control calendario"
                                                                   name="fnacpaciente" id="fnacpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   autocomplete="off"
                                                                   placeholder="Ingrese Fecha de Nacimiento" <?php if (isset($reg[0]['fnacpaciente'])) { ?> value="<?php echo $reg[0]['fnacpaciente'] == '0000-00-00' ? "" : date("d-m-Y", strtotime($reg[0]['fnacpaciente'])); ?>" <?php } ?>
                                                                   required="" aria-required="true">
                                                            <i class="fa fa-calendar form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nº de Teléfono: <span
                                                                        class="symbol"></span></label>
                                                            <input type="text" class="form-control phone-inputmask"
                                                                   name="tlfpaciente" id="tlfpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nº de Teléfono" <?php if (isset($reg[0]['tlfpaciente'])) { ?> value="<?php echo $reg[0]['tlfpaciente']; ?>" <?php } else {  ?>  value="0000000" <?php } ?>
                                                                   autocomplete="off" />
                                                            <i class="fa fa-phone form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Correo Electronico: </label>
                                                            <input type="text" class="form-control" name="emailpaciente"
                                                                   id="emailpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Correo Electronico" <?php
                                                            if (isset($reg[0]['emailpaciente'])) { ?>
                                                                value="<?php echo $reg[0]['emailpaciente']; ?>"
                                                            <?php } else { ?>
                                                                value="clinica@gmail.com"
                                                            <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-envelope-o form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Grupo Sanguineo: <span
                                                                        class="symbol required"></span></label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['gruposapaciente'])) { ?>
                                                                <select name="gruposapaciente" id="gruposapaciente"
                                                                        class="form-control" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option
                                                                            value="00"<?php if (!(strcmp('00', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>GENERICO
                                                                    </option>
                                                                    <option
                                                                            value="A RH-"<?php if (!(strcmp('A RH-', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>A RH-
                                                                    </option>
                                                                    <option value="A RH+"<?php if (!(strcmp('A RH+', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>A RH+
                                                                    </option>
                                                                    <option value="AB RH-"<?php if (!(strcmp('AB RH-', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>AB RH-
                                                                    </option>
                                                                    <option value="AB RH+"<?php if (!(strcmp('AB RH+', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>AB RH+
                                                                    </option>
                                                                    <option value="B RH-"<?php if (!(strcmp('B RH-', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>B RH-
                                                                    </option>
                                                                    <option value="B RH+"<?php if (!(strcmp('B RH+', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>B RH+
                                                                    </option>
                                                                    <option value="O RH-"<?php if (!(strcmp('O RH-', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>O RH-
                                                                    </option>
                                                                    <option value="O RH+"<?php if (!(strcmp('O RH+', $reg[0]['gruposapaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>O RH+
                                                                    </option>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="gruposapaciente" id="gruposapaciente"
                                                                        class="form-control" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option selected value="00">GENERICO</option>
                                                                    <option value="A RH-">A RH-</option>
                                                                    <option value="A RH+">A RH+</option>
                                                                    <option value="AB RH-">AB RH-</option>
                                                                    <option value="AB RH+">AB RH+</option>
                                                                    <option value="B RH-">B RH-</option>
                                                                    <option value="B RH+">B RH+</option>
                                                                    <option value="O RH-">O RH-</option>
                                                                    <option value="O RH+">O RH+</option>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Estado Civil: <span
                                                                        class="symbol required"></span></label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['estadopaciente'])) { ?>
                                                                <select name="estadopaciente" id="estadopaciente"
                                                                        class="form-control" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option value="SIN DETALLES"<?php if (!(strcmp('SIN DETALLES', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> SIN DETALLES
                                                                    </option>
                                                                    <option value="SOLTERO(A)"<?php if (!(strcmp('SOLTERO(A)', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> SOLTERO(A)
                                                                    </option>
                                                                    <option value="CASADO(A)"<?php if (!(strcmp('CASADO(A)', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> CASADO(A)
                                                                    </option>
                                                                    <option value="VIUDO(A)"<?php if (!(strcmp('VIUDO(A)', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> VIUDO(A)
                                                                    </option>
                                                                    <option value="DIVORCIADO(A)"<?php if (!(strcmp('DIVORCIADO(A)', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> DIVORCIADO(A)
                                                                    </option>
                                                                    <option value="CONCUBINO(A)"<?php if (!(strcmp('CONCUBINO(A)', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> CONCUBINO(A)
                                                                    </option>
                                                                    <option value="UNION LIBRE"<?php if (!(strcmp('UNION LIBRE', $reg[0]['estadopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>> UNION LIBRE
                                                                    </option>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="estadopaciente" id="estadopaciente"
                                                                        class="form-control" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option selected value="SIN DETALLES"> SIN
                                                                        DETALLES
                                                                    </option>
                                                                    <option value="SOLTERO(A)"> SOLTERO(A)</option>
                                                                    <option value="CASADO(A)"> CASADO(A)</option>
                                                                    <option value="VIUDO(A)"> VIUDO(A)</option>
                                                                    <option value="DIVORCIADO(A)"> DIVORCIADO(A)
                                                                    </option>
                                                                    <option value="CONCUBINO(A)"> CONCUBINO(A)</option>
                                                                    <option value="UNION LIBRE"> UNION LIBRE</option>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Ocupación Laboral: <span
                                                                        class="symbol"></span></label>
                                                            <input type="text" class="form-control"
                                                                   name="ocupacionpaciente" id="ocupacionpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Ocupación Laboral" <?php if (isset($reg[0]['ocupacionpaciente'])) { ?> value="<?php echo $reg[0]['ocupacionpaciente']; ?>" <?php } else {  ?>  value="Generico" <?php } ?>
                                                                   autocomplete="off" />
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Sexo: <span
                                                                        class="symbol"></span></label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['sexopaciente'])) { ?>
                                                                <select name="sexopaciente" id="sexopaciente"
                                                                        class="form-control">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option selected value="00">GENERICO</option>
                                                                    <option value="MASCULINO"<?php if (!(strcmp('MASCULINO', $reg[0]['sexopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>MASCULINO
                                                                    </option>
                                                                    <option value="FEMENINO"<?php if (!(strcmp('FEMENINO', $reg[0]['sexopaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>FEMENINO
                                                                    </option>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="sexopaciente" id="sexopaciente"
                                                                        class="form-control">
                                                                    <option value=""> -- SELECCIONE --</option>
								    <option selected value="00">GENERICO</option>
                                                                    <option value="MASCULINO">MASCULINO</option>
                                                                    <option value="FEMENINO">FEMENINO</option>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Opciones: <span
                                                                        class="symbol required"></span></label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['enfoquepaciente'])) { ?>
                                                                <select name="enfoquepaciente" id="enfoquepaciente"
                                                                        class="form-control">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option selected
                                                                            value="OTRO"<?php if (!(strcmp('OTRO', $reg[0]['enfoquepaciente']))) {
                                                                        echo "selected=\"selected\"";
                                                                    } ?>>OTRO
                                                                    </option>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="enfoquepaciente" id="enfoquepaciente"
                                                                        class="form-control">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <option selected value="OTRO">OTRO</option>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Seleccione
                                                                Departamento: </label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['id_departamento'])) { ?>
                                                                <select class="form-control" id="id_departamento"
                                                                        name="id_departamento"
                                                                        onChange="CargaProvincias(this.form.id_departamento.value);"
                                                                        required="" aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <?php
                                                                    $departamento = new Login();
                                                                    $departamento = $departamento->ListarDepartamentos();
                                                                    if ($departamento == "") {
                                                                        echo "";
                                                                    } else {
                                                                        for ($i = 0; $i < sizeof($departamento); $i++) { ?>
                                                                            <option value="<?php echo $departamento[$i]['id_departamento'] ?>"<?php if (!(strcmp($reg[0]['id_departamento'], htmlentities($departamento[$i]['id_departamento'])))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>><?php echo $departamento[$i]['departamento'] ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select class="form-control" id="id_departamento"
                                                                        name="id_departamento"
                                                                        onChange="CargaProvincias(this.form.id_departamento.value);"
                                                                        required="" aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <?php
                                                                    $departamento = new Login();
                                                                    $departamento = $departamento->ListarDepartamentos();
                                                                    if ($departamento == "") {
                                                                        echo "";
                                                                    } else {
                                                                        for ($i = 0; $i < sizeof($departamento); $i++) { ?>
                                                                            <option value="<?php echo $departamento[$i]['id_departamento'] ?>"><?php echo $departamento[$i]['departamento'] ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Seleccione Ciudad: </label>
                                                            <i class="fa fa-bars form-control-feedback"></i>
                                                            <?php if (isset($reg[0]['id_provincia'])) { ?>
                                                                <select name="id_provincia" id="id_provincia"
                                                                        class="form-control" tabindex="6" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SELECCIONE --</option>
                                                                    <?php
                                                                    $provincia = new Login();
                                                                    $provincia = $provincia->ListarProvincias();
                                                                    if ($provincia == "") {
                                                                        echo "";
                                                                    } else {
                                                                        for ($i = 0; $i < sizeof($provincia); $i++) { ?>
                                                                            <option value="<?php echo $provincia[$i]['id_provincia'] ?>"<?php if (!(strcmp($reg[0]['id_provincia'], htmlentities($provincia[$i]['id_provincia'])))) {
                                                                                echo "selected=\"selected\"";
                                                                            } ?>><?php echo $provincia[$i]['provincia'] ?></option>
                                                                        <?php }
                                                                    } ?>
                                                                </select>
                                                            <?php } else { ?>
                                                                <select name="id_provincia" id="id_provincia"
                                                                        class="form-control" tabindex="6" required=""
                                                                        aria-required="true">
                                                                    <option value=""> -- SIN RESULTADOS --</option>
                                                                </select>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Dirección Domiciliaria: <span
                                                                        class="symbol"></span></label>
                                                            <input type="text" class="form-control" name="direcpaciente"
                                                                   id="direcpaciente"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Dirección Domiciliaria" <?php if (isset($reg[0]['direcpaciente'])) { ?> value="<?php echo $reg[0]['direcpaciente']; ?>" <?php } else {  ?>  value="Generico" <?php } ?>
                                                                   autocomplete="off" />
                                                            <i class="fa fa-map-marker form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->


                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-danger">
                                            <h4 class="card-title text-white"><i class="fa fa-save"></i> Datos del
                                                Acompañante</h4>
                                        </div>

                                        <div id="save">
                                            <!-- error will be shown here ! -->
                                        </div>

                                        <div class="form-body">

                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nombre y Apellidos: </label>
                                                            <input type="text" class="form-control" name="nomacompana"
                                                                   id="nomacompana"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nombre y Apellidos" <?php if (isset($reg[0]['nomacompana'])) { ?> value="<?php echo $reg[0]['nomacompana']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Dirección
                                                                Domiciliaria: </label>
                                                            <input type="text" class="form-control" name="direcacompana"
                                                                   id="direcacompana"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Dirección Domiciliaria" <?php if (isset($reg[0]['direcacompana'])) { ?> value="<?php echo $reg[0]['direcacompana']; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-map-marker form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nº de Teléfono: </label>
                                                            <input type="text" class="form-control phone-inputmask"
                                                                   name="tlfacompana" id="tlfacompana"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nº de Teléfono" <?php if (isset($reg[0]['tlfacompana'])) { ?> value="<?php echo $reg[0]['tlfacompana']; ?>" <?php }else{  ?> value="<?php echo "0000000"; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-phone form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Parentesco: </label>
                                                            <input type="text" class="form-control"
                                                                   name="parentescoacompana" id="parentescoacompana"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Parentesco" <?php if (isset($reg[0]['parentescoacompana'])) { ?> value="<?php echo $reg[0]['parentescoacompana']; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->


                            <!-- Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-danger">
                                            <h4 class="card-title text-white"><i class="fa fa-save"></i> Datos de
                                                Responsable</h4>
                                        </div>

                                        <div id="save">
                                            <!-- error will be shown here ! -->
                                        </div>

                                        <div class="form-body">

                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nombre y Apellidos: </label>
                                                            <input type="text" class="form-control"
                                                                   name="nomresponsable" id="nomresponsable"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nombre y Apellidos" <?php if (isset($reg[0]['nomresponsable'])) { ?> value="<?php echo $reg[0]['nomresponsable']; ?>" <?php } ?>
                                                                   autocomplete="off" required="" aria-required="true"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Dirección
                                                                Domiciliaria: </label>
                                                            <input type="text" class="form-control"
                                                                   name="direcresponsable" id="direcresponsable"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Dirección Domiciliaria" <?php if (isset($reg[0]['direcresponsable'])) { ?> value="<?php echo $reg[0]['direcresponsable']; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-map-marker form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Nº de Teléfono: </label>
                                                            <input type="text" class="form-control phone-inputmask"
                                                                   name="tlfresponsable" id="tlfresponsable"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Nº de Teléfono" <?php if (isset($reg[0]['tlfresponsable'])) { ?> value="<?php echo $reg[0]['tlfresponsable']; ?>" <?php }else{  ?> value="<?php echo "0000000"; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-phone form-control-feedback"></i>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group has-feedback">
                                                            <label class="control-label">Parentesco: </label>
                                                            <input type="text" class="form-control"
                                                                   name="parentescoresponsable"
                                                                   id="parentescoresponsable"
                                                                   onKeyUp="this.value=this.value.toUpperCase();"
                                                                   placeholder="Ingrese Parentesco" <?php if (isset($reg[0]['parentescoresponsable'])) { ?> value="<?php echo $reg[0]['parentescoresponsable']; ?>" <?php } ?>
                                                                   autocomplete="off"/>
                                                            <i class="fa fa-pencil form-control-feedback"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-right">
                                                    <?php if (isset($_GET['codpaciente']) || $_SESSION['acceso'] == "paciente") { ?>
                                                        <button type="submit" name="btn-update" id="btn-update"
                                                                class="btn btn-danger"><span class="fa fa-edit"></span>
                                                            Actualizar
                                                        </button>
                                                        <button class="btn btn-info" type="reset"><span
                                                                    class="fa fa-trash-o"></span> Cancelar
                                                        </button>
                                                    <?php } else { ?>
                                                        <button type="submit" name="btn-submit" id="btn-submit"
                                                                class="btn btn-danger"><span class="fa fa-save"></span>
                                                            Guardar
                                                        </button>
                                                        <button class="btn btn-info" type="reset"><span
                                                                    class="fa fa-trash-o"></span> Limpiar
                                                        </button>
                                                    <?php } ?>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->

                        </form>

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
        <script type="text/javascript" src="assets/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>
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