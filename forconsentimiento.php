<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="especialista") {

$tra = new Login();
$ses = $tra->ExpiraSession();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarConsentimiento();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarConsentimiento();
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
    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Consentimientos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Odontológia</li>
                                <li class="breadcrumb-item active" aria-current="page">Gestión de Consentimientos</li>
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

<?php  if (isset($_GET['codconsentimiento'])) {
      
      $reg = $tra->ConsentimientosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updateconsentimiento" id="updateconsentimiento" data-id="<?php echo $reg[0]["codconsentimiento"] ?>">
        
    <?php } else { ?>
        
<form class="form form-material" method="post" action="#" name="saveconsentimiento" id="saveconsentimiento"> 

    <?php } ?>  


<?php  if (isset($_GET['codconsentimiento'])) { ?>
      
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-paste"></i> Consentimiento Informado patra Odontológia</h4>
            </div>
            
            <div id="save">
            <!-- error will be shown here ! -->
            </div>

        <div class="form-body">

        <div class="card-body">

    <div class="row">
      <div class="col-md-12">
        <p align="justify">YO: <?php echo "<strong>".$reg[0]['nompaciente']." ".$reg[0]['apepaciente']."</strong>"; ?> <?php echo $variable = ( edad($reg[0]['fnacpaciente']) >= '18' ? " MAYOR DE EDAD" : " MENOR DE EDAD");  ?>, IDENTIFICADO CON <?php echo "<strong>".$reg[0]['documento4']." N&deg; ".$reg[0]['cedpaciente']."</strong>"; ?> DE <?php echo "<strong>".$departamento = ($reg[0]['departamento3'] == '' ? "" : $reg[0]['departamento3'])." ".$provincia = ($reg[0]['provincia3'] == '' ? "" : $reg[0]['provincia3'])." ".$reg[0]['direcpaciente']."</strong>"; ?>, Y COMO PACIENTE O COMO RESPONSABLE DEL PACIENTE AUTORIZÓ AL DR.(A) <?php echo "<strong>".$reg[0]['nomespecialista']."</strong>"; ?>, <?php echo "<strong>".$reg[0]['documento3']." N&deg; ".$reg[0]['cedespecialista']."</strong>"; ?>, CON PROFESIÓN O ESPECIALIDAD <?php echo "<strong>".$reg[0]['especialidad']."</strong>"; ?>, PARA LA REALIZACIÓN DEL PROCEDIMIENTO<br><br>

        <textarea class="form-control" name="procedimiento" id="procedimiento" onkeyup="this.value=this.value.toUpperCase();" style="width:100%;background:#f0f9fc;border-radius:5px 5px 5px 5px;" autocomplete="off" placeholder="Ingrese Procedimiento" rows="2" required="" aria-required="true"><?php echo $reg[0]['procedimiento']; ?></textarea> <br>

        TENIENDO EN CUENTA QUE HE SIDO INFORMADO CLARAMENTE SOBRE LOS RIESGOS QUE SE PUEDEN PRESENTAR, SIENDO ESTOS: <br><br>

        <textarea class="form-control" name="observaciones" id="observaciones" onkeyup="this.value=this.value.toUpperCase();" style="width:100%;background:#f0f9fc;border-radius:5px 5px 5px 5px;" autocomplete="off" placeholder="Ingrese Observaciones" rows="3" required="" aria-required="true"><?php echo $reg[0]['observaciones']; ?></textarea><br> 

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
                <input type="hidden" name="proceso" id="proceso" value="update"/>
                <input type="hidden" name="codconsentimiento" id="codconsentimiento" value="<?php echo $reg[0]['codconsentimiento']; ?>"/>
                <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo $reg[0]['codsucursal']; ?>"/>
                <input type="hidden" name="codpaciente" id="codpaciente" value="<?php echo $reg[0]['codpaciente']; ?>"/>
                <input type="hidden" name="codespecialista" id="codespecialista" value="<?php echo $reg[0]['codespecialista']; ?>"/>
                <input type="text" class="form-control" name="doctestigo" id="doctestigo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº Documento Testigo" value="<?php echo $reg[0]['doctestigo']; ?>" autocomplete="off" required="" aria-required="true"/>  
                <i class="fa fa-pencil form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group has-feedback">
                <label class="control-label">Nombre de Testigo: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="nombretestigo" id="nombretestigo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Testigo" value="<?php echo $reg[0]['nombretestigo']; ?>" autocomplete="off" required="" aria-required="true"/>  
                <i class="fa fa-pencil form-control-feedback"></i> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">El Paciente no puede firmar por: </label>
                <input type="text" class="form-control" name="nofirmapaciente" id="nofirmapaciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese El Paciente no puede firmar por" value="<?php echo $reg[0]['nofirmapaciente']; ?>" autocomplete="off" required="" aria-required="true"/>  
                <i class="fa fa-pencil form-control-feedback"></i> 
            </div>
        </div>
    </div>

            <div class="text-right">
<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>
<button class="btn btn-info" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button>
             </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->
        
<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-save"></i> Búsqueda del Paciente </h4>
            </div>
            
            <div id="save">
            <!-- error will be shown here ! -->
            </div>

        <div class="form-body">

        <div class="card-body">

        <?php if ($_SESSION['acceso'] == "especialista") { ?>

        <div class="row">
            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"> 
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Búsqueda de Paciente: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['codconsentimiento'])) { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
                    <input type="hidden" name="codespecialista" id="codespecialista" <?php if (isset($reg[0]['codespecialista'])) { ?> value="<?php echo $reg[0]['codespecialista']; ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION['codespecialista']); ?>" <?php } ?>>
                    <input type="hidden" name="codpaciente" id="codpaciente">
                    <input type="text" class="form-control" name="search_paciente" id="search_paciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda de Paciente" autocomplete="off" required="required"/> 
                    <i class="fa fa-search form-control-feedback"></i> 
                </div>
            </div> 
        </div>

        <?php } else { ?>

        <div class="row">
            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"> 
            <div class="col-md-8">
                <div class="form-group has-feedback">
                    <label class="control-label">Búsqueda de Paciente: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['codconsentimiento'])) { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
                    <input type="hidden" name="codpaciente" id="codpaciente">
                    <input type="text" class="form-control" name="search_paciente" id="search_paciente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda de Paciente" autocomplete="off" required="required"/> 
                    <i class="fa fa-search form-control-feedback"></i> 
                </div>
            </div> 

            <div class="col-md-4"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Seleccione Especialista: <span class="symbol required"></span></label> 
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select name="codespecialista" id="codespecialista" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $especialista = new Login();
                        $especialista = $especialista->ListarEspecialistas();
                        if($especialista==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($especialista);$i++){ ?>
                        <option value="<?php echo encrypt($especialista[$i]['codespecialista']); ?>"><?php echo $especialista[$i]['nomespecialista'] ?></option>        
                        <?php } } ?>
                    </select>   
                </div> 
            </div>
        </div>
        <?php } ?>

                <div class="text-right">
                    <button type="button" onClick="BuscarPacienteConsentimiento()" class="btn btn-danger"><span class="fa fa-search"></span> Realizar Búsqueda</button>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Row -->

<div id="muestraconsentimiento"></div>

<?php } ?>

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
        document.location.href='panel'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>