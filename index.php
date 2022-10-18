<?php
require_once("class/class.php");

$con = new Login();
$con = $con->ConfiguracionPorId();

$tra = new Login();

if (isset($_POST["proceso"]) and $_POST["proceso"] == "login") {
    $log = $tra->Logueo();
    exit;
} elseif (isset($_POST["proceso"]) and $_POST["proceso"] == "recuperar") {
    $reg = $tra->RecuperarPassword();
    exit;
} elseif (isset($_POST["proceso"]) and $_POST["proceso"] == "msj_contact") {
    $reg = $tra->EnviarMensaje();
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title></title>
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/css/animate.min.css" rel="stylesheet">
    <link href="template/css/font-awesome.min.css" rel="stylesheet">
    <link href="template/css/lightbox.css" rel="stylesheet">
    <link href="template/css/main.css" rel="stylesheet">
    <script src="template/js/all.min.js"></script>
    <link id="css-preset" href="template/css/presets/preset1.css" rel="stylesheet">
    <link href="template/css/responsive.css" rel="stylesheet">
    <!--<script src="template/js/588d62cb43.js" crossorigin="anonymous"></script>-->
    <script src="https://kit.fontawesome.com/588d62cb43.js" crossorigin="anonymous"></script>
    <!-- script jquery -->
    <script src="assets/script/jquery.min.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!--[if lt IE 9]>
    <script src="template/js/html5shiv.js"></script>
    <script src="template/js/respond.min.js"></script>
    <![endif]-->


    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
</head><!--/head-->
<style>
    body {
        background-image: url("nuevo_logo/pexels-ksenia-chernaya-7695182.jpg");
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 70vh;
    }
    @media only screen and (max-width: 990px) {
        .maximo {
            display: none !important; } }
    @media only screen and (min-width: 989px) {
        .minimo {
            display: none !important; } }
</style>
<body>
<form class="form form-material center-block bg-light maximo" style="width: 35%;margin-top: 3px; padding: 3em; background-color:#f7fafc!important
;border-radius:6px; opacity: 1!important;" name="formrecover" id="formrecover" action="">

    <div>
        <div>
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white text-center" id="myModalLabel">Linkdentalnic</h4>
            </div>

            <div class="modal-body"><!-- modal-body ! -->

                <div id="loginform"><!-- loginform ! -->

                    <form class="form form-material" name="formlogin" id="formlogin" action="">

                        <div id="login">
                            <!-- error will be shown here ! -->
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Ingrese su Usuario: <span
                                                class="symbol required"></span></label>
                                    <input type="hidden" name="proceso" value="login"/>
                                    <input type="text" class="form-control" placeholder="Ingrese su Usuario"
                                           name="usuario" id="usuario" onKeyUp="this.value=this.value.toUpperCase();"
                                           autocomplete="off" required="" aria-required="true">
                                    <i class="fa fa-user form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback2">
                                    <div class="campo">
                                        <label class="control-label">Ingrese su Password: <a
                                                    class="symbol required"></a></label>
                                        <input class="form-control" type="password" placeholder="Ingrese su Password"
                                               name="password" id="txtPassword"
                                               onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                               required="" aria-required="true"><span id="show_password"
                                                                                      class="fa fa-eye icon"
                                                                                      onclick="MostrarPassword()"></span>
                                    </div>
                                    <i class="fa fa-key form-control-feedback2"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Sucursal: </label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="codsucursal" id="codsucursal" class="form-control" required=""
                                            aria-required="true">
                                        <option value="<?php echo encrypt("0"); ?>"> -- SELECCIONE --</option>
                                        <?php
                                        $sucursal = new Login();
                                        $sucursal = $sucursal->ListarSucursales();
                                        if ($sucursal == "") {
                                            echo "";
                                        } else {
                                            for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                ?>
                                                <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['nomsucursal']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Tipo Ingreso: <a
                                                class="symbol required"></a></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="tipo" id="tipo" class="form-control" required="" aria-required="true">
                                        <option value=""> -- SELECCIONE --</option>
                                        <option value="<?php echo encrypt("1"); ?>">ADMINISTRACIÓN</option>
                                        <option value="<?php echo encrypt("2"); ?>">ESPECIALISTA</option>
                                        <option value="<?php echo encrypt("3"); ?>">PACIENTE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i
                                            class="fa fa-lock"></i> Olvidaste tu Contraseña?</a>
                            </div>
                        </div>

                        <div class="modal-footer m-t-20">
                            <div class="col-md-6">
                                <button type="submit" name="btn-login" id="btn-login"
                                        class="btn btn-info btn-lg btn-block waves-effect waves-light"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Iniciar Sesión"><span class="fa fa-sign-in"></span> Acceder
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-lg btn-block waves-effect waves-light"
                                        data-dismiss="modal" onclick="document.getElementById('usuario').value = '',
                                        document.getElementById('txtPassword').value = '',
                                        document.getElementById('codsucursal').value = '<?php echo encrypt("0"); ?>',
                                        document.getElementById('tipo').value = ''"><span
                                            class="fa fa-times-circle"></span> Cerrar
                                </button>
                            </div>
                        </div>

                    </form>

                </div><!-- loginform ! -->


                <div id="recoverform" style="display: none;"><!-- recoverform ! -->

                    <form class="form form-material" name="formrecover" id="formrecover" action="">

                        <div id="recover">
                            <!-- error will be shown here ! -->
                        </div>

                        <div class="row">
                            <div class="col-md-12 m-t-5">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Correo Electrónico: <span
                                                class="symbol required"></span></label>
                                    <input type="hidden" name="proceso" value="recuperar"/>
                                    <input type="text" class="form-control" name="email" id="email"
                                           onKeyUp="this.value=this.value.toUpperCase();"
                                           placeholder="Ingrese su Correo Electronico" autocomplete="off" required=""
                                           aria-required="true"/>
                                    <i class="fa fa-envelope-o form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Tipo Ingreso: <a
                                                class="symbol required"></a></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="tipo" id="tipo" class="form-control" required="" aria-required="true">
                                        <option value=""> -- SELECCIONE --</option>
                                        <option value="<?php echo encrypt("4"); ?>">ADMINISTRACIÓN</option>
                                        <option value="<?php echo encrypt("5"); ?>">ESPECIALISTA</option>
                                        <option value="<?php echo encrypt("6"); ?>">PACIENTE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"><i
                                            class="fa fa-arrow-circle-left"></i> Acceder al Sistema</a> <br>
                            </div>
                        </div>


                        <div class="modal-footer m-t-20">
                            <div class="col-md-6">
                                <button type="submit" name="btn-recuperar" id="btn-recuperar"
                                        class="btn btn-info btn-lg btn-block waves-effect waves-light"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Recuperar Password"><span
                                            class="fa fa-check-square-o"></span> Recuperar Password
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-lg btn-block waves-effect waves-light"
                                        data-dismiss="modal" onclick="document.getElementById('email').value = '',
                      document.getElementById('tipo').value = ''"><span class="fa fa-times-circle"></span> Cerrar
                                </button>
                            </div>
                        </div>

                    </form>

                </div><!-- recoverform ! -->


            </div><!-- modal-body ! -->

        </div>
        <!-- /.modal-content -->
    </div>
</form>

<form class="form form-material center-block bg-light minimo" style="width: 85%;margin-top: 3px; padding: 3em; background-color:#f7fafc!important
;border-radius:6px; opacity: 1!important;" name="formrecover" id="formrecover" action="">

    <div>
        <div>
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white text-center" id="myModalLabel">Linkdentalnic</h4>
            </div>

            <div class="modal-body"><!-- modal-body ! -->

                <div id="loginform"><!-- loginform ! -->

                    <form class="form form-material" name="formlogin" id="formlogin" action="">

                        <div id="login">
                            <!-- error will be shown here ! -->
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Ingrese su Usuario: <span
                                                class="symbol required"></span></label>
                                    <input type="hidden" name="proceso" value="login"/>
                                    <input type="text" class="form-control" placeholder="Ingrese su Usuario"
                                           name="usuario" id="usuario" onKeyUp="this.value=this.value.toUpperCase();"
                                           autocomplete="off" required="" aria-required="true">
                                    <i class="fa fa-user form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback2">
                                    <div class="campo">
                                        <label class="control-label">Ingrese su Password: <a
                                                    class="symbol required"></a></label>
                                        <input class="form-control" type="password" placeholder="Ingrese su Password"
                                               name="password" id="txtPassword"
                                               onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off"
                                               required="" aria-required="true"><span id="show_password"
                                                                                      class="fa fa-eye icon"
                                                                                      onclick="MostrarPassword()"></span>
                                    </div>
                                    <i class="fa fa-key form-control-feedback2"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Sucursal: </label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="codsucursal" id="codsucursal" class="form-control" required=""
                                            aria-required="true">
                                        <option value="<?php echo encrypt("0"); ?>"> -- SELECCIONE --</option>
                                        <?php
                                        $sucursal = new Login();
                                        $sucursal = $sucursal->ListarSucursales();
                                        if ($sucursal == "") {
                                            echo "";
                                        } else {
                                            for ($i = 0; $i < sizeof($sucursal); $i++) {
                                                ?>
                                                <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['nomsucursal']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Tipo Ingreso: <a
                                                class="symbol required"></a></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="tipo" id="tipo" class="form-control" required="" aria-required="true">
                                        <option value=""> -- SELECCIONE --</option>
                                        <option value="<?php echo encrypt("1"); ?>">ADMINISTRACIÓN</option>
                                        <option value="<?php echo encrypt("2"); ?>">ESPECIALISTA</option>
                                        <option value="<?php echo encrypt("3"); ?>">PACIENTE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i
                                            class="fa fa-lock"></i> Olvidaste tu Contraseña?</a>
                            </div>
                        </div>

                        <div class="modal-footer m-t-20">
                            <div class="col-md-6">
                                <button type="submit" name="btn-login" id="btn-login"
                                        class="btn btn-info btn-lg btn-block waves-effect waves-light"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Iniciar Sesión"><span class="fa fa-sign-in"></span> Acceder
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-lg btn-block waves-effect waves-light"
                                        data-dismiss="modal" onclick="document.getElementById('usuario').value = '',
                                        document.getElementById('txtPassword').value = '',
                                        document.getElementById('codsucursal').value = '<?php echo encrypt("0"); ?>',
                                        document.getElementById('tipo').value = ''"><span
                                            class="fa fa-times-circle"></span> Cerrar
                                </button>
                            </div>
                        </div>

                    </form>

                </div><!-- loginform ! -->


                <div id="recoverform" style="display: none;"><!-- recoverform ! -->

                    <form class="form form-material" name="formrecover" id="formrecover" action="">

                        <div id="recover">
                            <!-- error will be shown here ! -->
                        </div>

                        <div class="row">
                            <div class="col-md-12 m-t-5">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Correo Electrónico: <span
                                                class="symbol required"></span></label>
                                    <input type="hidden" name="proceso" value="recuperar"/>
                                    <input type="text" class="form-control" name="email" id="email"
                                           onKeyUp="this.value=this.value.toUpperCase();"
                                           placeholder="Ingrese su Correo Electronico" autocomplete="off" required=""
                                           aria-required="true"/>
                                    <i class="fa fa-envelope-o form-control-feedback"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                    <label class="control-label">Seleccione Tipo Ingreso: <a
                                                class="symbol required"></a></label>
                                    <i class="fa fa-bars form-control-feedback"></i>
                                    <select name="tipo" id="tipo" class="form-control" required="" aria-required="true">
                                        <option value=""> -- SELECCIONE --</option>
                                        <option value="<?php echo encrypt("4"); ?>">ADMINISTRACIÓN</option>
                                        <option value="<?php echo encrypt("5"); ?>">ESPECIALISTA</option>
                                        <option value="<?php echo encrypt("6"); ?>">PACIENTE</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"><i
                                            class="fa fa-arrow-circle-left"></i> Acceder al Sistema</a> <br>
                            </div>
                        </div>


                        <div class="modal-footer m-t-20">
                            <div class="col-md-6">
                                <button type="submit" name="btn-recuperar" id="btn-recuperar"
                                        class="btn btn-info btn-lg btn-block waves-effect waves-light"
                                        data-toggle="tooltip" data-placement="top" title=""
                                        data-original-title="Recuperar Password"><span
                                            class="fa fa-check-square-o"></span> Recuperar Password
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger btn-lg btn-block waves-effect waves-light"
                                        data-dismiss="modal" onclick="document.getElementById('email').value = '',
                      document.getElementById('tipo').value = ''"><span class="fa fa-times-circle"></span> Cerrar
                                </button>
                            </div>
                        </div>

                    </form>

                </div><!-- recoverform ! -->


            </div><!-- modal-body ! -->

        </div>
        <!-- /.modal-content -->
    </div>
</form>

</body>
<footer id="footer" style="margin-top: 1em">
    <div class="footer-bottom bg-success">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <i class="fa fa-copyright"></i> <span class="current-year"></span>.
                </div>
                <div class="col-sm-6">
                    <p class="pull-right">Gracias Por utilizar este servicio<a href="https://www.instagram.com/linkdentalnic/" class="btn btn-link">LINKDENTALNIC</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="assets/js/jquery.js"></script>
<script type="text/javascript" src="template/js/password.js"></script>
<!-- Custom Theme JavaScript -->
<script type="text/javascript" src="template/js/custom.js"></script>
<!-- jQuery -->
<script type="text/javascript" src="template/js/bootstrap.min.js"></script>
<!---->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="template/js/jquery.inview.min.js"></script>
<script type="text/javascript" src="template/js/wow.min.js"></script>
<script type="text/javascript" src="template/js/mousescroll.js"></script>
<script type="text/javascript" src="template/js/smoothscroll.js"></script>
<script type="text/javascript" src="template/js/jquery.countTo.js"></script>
<script type="text/javascript" src="template/js/lightbox.min.js"></script>
<script type="text/javascript" src="template/js/main.js"></script>

<!-- jQuery -->
<script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>

</body>
</html>