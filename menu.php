<?php
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"] == "administradorS" || $_SESSION["acceso"] == "secretaria" || $_SESSION["acceso"] == "cajero" || $_SESSION["acceso"] == "especialista" || $_SESSION["acceso"] == "paciente") {

        $count = new Login();
        $p = $count->ContarRegistros();
        ?>

        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                                class="fa fa-navicon"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="javascript:void(0)">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->

                            <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "paciente") {

                                if (file_exists("fotos/logo_principal.png")) {
                                    echo "<img src='fotos/logo_principal.png' width='170' height='50' alt='Logo Principal' class='dark-logo'>";
                                } else {
                                    echo "<img src='' alt='Logo Principal' class='dark-logo'>";
                                }

                            } else {

                                if (file_exists("fotos/sucursales/" . $_SESSION['cuitsucursal'] . ".png")) {
                                    echo "<img src='fotos/sucursales/" . $_SESSION['cuitsucursal'] . ".png' width='170' height='50' alt='Logo Sucursal' class='dark-logo'>";
                                } else {
                                    echo "<img src='fotos/logo_principal.png' width='170' height='50' alt='Logo Principal' class='dark-logo'>";
                                }
                            }
                            ?>
                            <!-- <img src="assets/images/logo.png" width="185" height="40" alt="Logo Principal" class="dark-logo">
                              Light Logo icon
                             <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo">-->
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="" alt="" class="dark-logo">
                            <!-- Light Logo text
                            <img src="assets/images/logo-icon.png" class="light-logo" alt="homepage">-->
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                       data-toggle="collapse" data-target="#navbarSupportedContent"
                       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                                class="mdi mdi-dots-horizontal"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin6">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->

                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a
                                    class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                    data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>

                        <?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION['acceso'] == "secretaria" || $_SESSION['acceso'] == "cajero" || $_SESSION['acceso'] == "especialista") { ?>
                            <!-- ============================================================== -->
                            <!-- Iconos de Sucursal -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle waves-effect waves-dark text-dark"><strong><i
                                                class="mdi mdi-bank font-24  text-info"></i>
                                        (<?php echo $_SESSION['nomsucursal']; ?>)</strong>
                                </a>
                            </li>
                            <!-- ============================================================== -->
                            <!-- End Iconos de Sucursal -->
                            <!-- ============================================================== -->
                        <?php } ?>

                        <!-- Reloj start-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark hour text-dark"><i
                                        class="mdi mdi-calendar-clock font-24 text-info"></i> <span
                                        id="spanreloj"></span>
                            </a>
                        </li>
                        <!-- Reloj end -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!--                        <li class="nav-item search-box"> -->
                        <!--                            <form class="app-search d-none d-lg-block order-lg-2">-->
                        <!--                                <input type="text" class="form-control" placeholder="Búsqueda...">-->
                        <!--                                <a href="" class="active"><i class="fa fa-search"></i></a>-->
                        <!--                            </form>-->
                        <!--                        </li>-->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle waves-effect waves-dark pro-pic d-flex mt-2 pr-0 leading-none simple"
                               href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <?php if ($_SESSION['acceso'] == "especialista") {

                                    if (file_exists("fotos/" . $_SESSION['codigo'] . ".jpg")) {
                                        echo "<img src='fotos/" . $_SESSION['codigo'] . ".jpg?' width='50' height='50' class='rounded-circle'>";
                                    } else {
                                        echo "<img src='fotos/avatar.png' width='40' height='40' class='rounded-circle'>";
                                    }

                                } else {

                                    if (file_exists("fotos/" . $_SESSION['dni'] . ".jpg")) {
                                        echo "<img src='fotos/" . $_SESSION['dni'] . ".jpg?' width='50' height='50' class='rounded-circle'>";
                                    } else {
                                        echo "<img src='fotos/avatar.png' width='40' height='40' class='rounded-circle'>";
                                    }
                                }
                                ?>
                                <span class="ml-2 d-lg-block">
                                    <h5 class="text-dark mb-0"><?php echo $_SESSION['nombres']; ?></h5>
                                    <small class="text-info mb-0"><?php echo $_SESSION['acceso'] == "especialista" ? $_SESSION['especialidad'] : $_SESSION['nivel']; ?></small>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <div class="d-flex no-block align-items-center p-3 mb-2 border-bottom">
                                    <div class=""><?php if ($_SESSION['acceso'] == "especialista") {

                                            if (file_exists("fotos/" . $_SESSION['codigo'] . ".jpg")) {
                                                echo "<img src='fotos/" . $_SESSION['codigo'] . ".jpg?' width='40' height='40' class='rounded-circle'>";
                                            } else {
                                                echo "<img src='fotos/avatar.png' width='40' height='40' class='rounded-circle'>";
                                            }

                                        } else {

                                            if (file_exists("fotos/" . $_SESSION['dni'] . ".jpg")) {
                                                echo "<img src='fotos/" . $_SESSION['dni'] . ".jpg?' width='40' height='40' class='rounded-circle'>";
                                            } else {
                                                echo "<img src='fotos/avatar.png' width='40' height='40' class='rounded-circle'>";
                                            }
                                        }
                                        ?></div>
                                    <div class="ml-2">
                                        <h5 class="mb-0"><abbr
                                                    title="Nombres y Apellidos"><?php echo $_SESSION['nombres']; ?></abbr>
                                        </h5>
                                        <p class="mb-0 text-muted"><abbr
                                                    title="Correo Electrónico"><?php echo $_SESSION['email']; ?></abbr>
                                        </p>
                                        <p class="mb-0 text-muted"><abbr
                                                    title="Nº de Teléfono"><?php echo $_SESSION['telefono']; ?></abbr>
                                        </p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="perfil"><i class="fa fa-user"></i> Ver Perfil</a>
                                <a class="dropdown-item" href="password"><i class="fa fa-edit"></i> Actualizar Password</a>
                                <!--                                <a class="dropdown-item" href="bloqueo"><i class="fa fa-clock-o"></i> Bloquear Sesión</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->


        <?php
        switch ($_SESSION['acceso']) {

            case 'administradorG': ?>

                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-settings"></i><span class="hide-menu">Herramientas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span
                                                        class="hide-menu">Usuarios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="usuarios" class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Usuarios</span></a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="horarios_usuarios"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Horario de
                                                        Usuarios</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="horarios_especialistas"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Horario de Espec.</a>
                                                </li>

                                                <li class="sidebar-item"><a href="logs" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Historial de Acceso</span></a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span class="hide-menu">Configuración</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="configuracion"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Perfil General</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="departamentos"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Departamentos</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="provincias" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Ciudad</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="documentos" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Docum.
                                                        Tributarios</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="monedas" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Tipos de Moneda</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="cambios" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Tipos de Cambio</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="impuestos" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Impuestos</a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="sucursales" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Sucursales</a></li>

                                        <li class="sidebar-item"><a href="tratamientos" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span
                                                        class="hide-menu"> Tratamientos </span></a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="mensajes" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Mensajes</a></li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-receipt"></i><span-->
<!--                                                        class="hide-menu">Productos</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="marcas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Marcas</a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="presentaciones" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Presentaciones</a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="medidas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Unidad de Medida</a>-->
<!--                                                </li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span class="hide-menu">Base de Datos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="backup" class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Backup</span></a></li>

                                                <li class="sidebar-item"><a href="restore" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Restore</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-folder-multiple"></i><span class="hide-menu">Mantenimiento</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Personal</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="especialistas"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Especialistas</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="pacientes" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Pacientes</a></li>

<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="proveedores" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Proveedores</a></li>-->

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="servicios" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Búsqueda General</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosvendidos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios Vendidos </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="serviciosxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Servicios x Vendedor</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosxmoneda"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios x Moneda </span></a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="buscakardexservicio"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Kardex de Servicios</span></a></li>

                                                <li class="sidebar-item"><a href="kardexserviciosvalorizadoxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>

                                            </ul>
                                        </li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span-->
<!--                                                        class="hide-menu">Almacen</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="forproducto" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Nuevo Producto</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productos" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Búsqueda General</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosvendidos"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos Vendidos </span></a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxvendedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Productos x Vendedor</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxmoneda"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos x Moneda </span></a>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Productos</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="buscakardexproducto"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Kardex de Productos</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="kardexproductosvalorizado"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Kardex Valorizado</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="kardexproductosvalorizadoxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span
                                                        class="hide-menu">Traspasos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="traspasos" class="sidebar-link"><i
                                                                class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="traspasosxsucursal"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Traspasos x Sucursal</span></a></li>

                                                <li class="sidebar-item"><a href="traspasosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Traspasos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="productostraspasos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Productos Traspasos</span></a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

<!--                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                            href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                class="mdi mdi-cart"></i><span class="hide-menu">Compras </span></a>-->
<!--                                    <ul aria-expanded="false" class="collapse first-level">-->
<!---->
<!--                                        <li class="sidebar-item"><a href="compras" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>-->
<!--                                        </li>-->
<!---->
<!--                                        <li class="sidebar-item"><a href="cuentasxpagar" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Cuentas por Pagar </span></a>-->
<!--                                        </li>-->
<!---->
<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span-->
<!--                                                        class="hide-menu">Reportes </span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="comprasxproveedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Compras x Proveedor</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="comprasxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Compras x Fechas</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="creditoscomprasxproveedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cards-variant"></i><span-->
<!--                                                                class="hide-menu"> Créditos x Proveedor </span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="creditoscomprasxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cards-variant"></i><span-->
<!--                                                                class="hide-menu"> Créditos x Fechas </span></a></li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-scale-balance"></i><span
                                                class="hide-menu">Cotizaciones </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="cotizaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="cotizacionesxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Paciente</span></a></li>

                                                <li class="sidebar-item"><a href="productoscotizados"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Detalles Cotizados</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Cotizados x Vendedor</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Calendario de Citas</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="citasxfechas" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Citas x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="citasxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="citasxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-desktop-mac"></i><span
                                                class="hide-menu">Cajas </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="cajas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Control de Cajas</a></li>

                                        <li class="sidebar-item"><a href="arqueos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Arqueos de Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="movimientos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Movimientos en Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="arqueosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Arqueos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="movimientosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Movimientos x Fechas</span></a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-tooth"></i><span class="hide-menu">Odontograma</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="odontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

<!--                                        <li class="sidebar-item"><a href="consentimientos" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-priority-low"></i><span class="hide-menu"> Consentimientos</span></a>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="odontologiaxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Odontolog. x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart-plus"></i><span
                                                class="hide-menu">Facturación </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="facturaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="facturacionxcaja"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Facturación x Cajas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Paciente</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu">Créditos </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="creditos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Consulta General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxfechas" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Fechas </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxpaciente" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Paciente </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxdetalles" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Detalles </span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"> Cerrar Sesión</span></a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->


                <?php
                break;
            case 'administradorS': ?>

                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-settings"></i><span class="hide-menu">Herramientas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span
                                                        class="hide-menu">Usuarios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="usuarios" class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Usuarios</span></a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="horarios_usuarios"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Horario de
                                                        Usuarios</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="horarios_especialistas"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Horario de Espec.</a>
                                                </li>

                                                <li class="sidebar-item"><a href="logs" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Historial de Acceso</span></a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span class="hide-menu">Configuración</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="departamentos"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Departamentos</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="provincias" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Ciudad</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="documentos" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Docum.
                                                        Tributarios</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="monedas" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Tipos de Moneda</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="cambios" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Tipos de Cambio</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="impuestos" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Impuestos</a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="mensajes" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Mensajes</a></li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-receipt"></i><span-->
<!--                                                        class="hide-menu">Productos</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="marcas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Marcas</a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="presentaciones" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Presentaciones</a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="medidas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Unidad de Medida</a>-->
<!--                                                </li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a href="tratamientos" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span
                                                        class="hide-menu"> Tratamientos </span></a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span class="hide-menu">Base de Datos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="backup" class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Backup</span></a></li>

                                                <li class="sidebar-item"><a href="restore" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Restore</span></a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="graficos" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Gráficos</a></li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-folder-multiple"></i><span class="hide-menu">Mantenimiento</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Personal</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="especialistas"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Especialistas</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="pacientes" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Pacientes</a></li>

<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="proveedores" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Proveedores</a></li>-->

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="servicios" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Búsqueda General</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosvendidos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios Vendidos </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="serviciosxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Servicios x Vendedor</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosxmoneda"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios x Moneda </span></a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="buscakardexservicio"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Kardex de Servicios</span></a></li>

                                                <li class="sidebar-item"><a href="kardexserviciosvalorizadoxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>

                                            </ul>
                                        </li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span-->
<!--                                                        class="hide-menu">Almacen</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="forproducto" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Nuevo Producto</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productos" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Búsqueda General</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosvendidos"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos Vendidos </span></a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxvendedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Productos x Vendedor</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxmoneda"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos x Moneda </span></a>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Productos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="buscakardexproducto"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Kardex de Productos</span></a></li>

                                                <li class="sidebar-item"><a href="kardexproductosvalorizado"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Kardex Valorizado</span></a></li>

                                                <li class="sidebar-item"><a href="kardexproductosvalorizadoxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span
                                                        class="hide-menu">Traspasos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="fortraspaso" class="sidebar-link"><i
                                                                class="mdi mdi-cards-variant"></i><span
                                                                class="hide-menu"> Nuevo Traspaso </span></a></li>

                                                <li class="sidebar-item"><a href="traspasos" class="sidebar-link"><i
                                                                class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="traspasosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Traspasos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="productostraspasos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Productos Traspasos</span></a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

<!--                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                            href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                class="mdi mdi-cart"></i><span class="hide-menu">Compras </span></a>-->
<!--                                    <ul aria-expanded="false" class="collapse first-level">-->
<!---->
<!--                                        <li class="sidebar-item"><a href="forcompra" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Compra </span></a>-->
<!--                                        </li>-->
<!---->
<!--                                        <li class="sidebar-item"><a href="compras" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>-->
<!--                                        </li>-->
<!---->
<!--                                        <li class="sidebar-item"><a href="cuentasxpagar" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Cuentas por Pagar </span></a>-->
<!--                                        </li>-->
<!---->
<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span-->
<!--                                                        class="hide-menu">Reportes </span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="comprasxproveedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Compras x Proveedor</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="comprasxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Compras x Fechas</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="creditoscomprasxproveedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cards-variant"></i><span-->
<!--                                                                class="hide-menu"> Créditos x Proveedor </span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="creditoscomprasxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cards-variant"></i><span-->
<!--                                                                class="hide-menu"> Créditos x Fechas </span></a></li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-scale-balance"></i><span
                                                class="hide-menu">Cotizaciones </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forcotizacion" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Cotización </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="cotizaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="cotizacionesxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Paciente</span></a></li>

                                                <li class="sidebar-item"><a href="productoscotizados"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Detalles Cotizados</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Cotizados x Vendedor</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Cita</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="citasxfechas" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Citas x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="citasxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="citasxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-desktop-mac"></i><span
                                                class="hide-menu">Cajas </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="cajas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Control de Cajas</a></li>

                                        <li class="sidebar-item"><a href="arqueos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Arqueos de Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="movimientos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Movimientos en Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="arqueosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Arqueos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="movimientosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Movimientos x Fechas</span></a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-tooth"></i><span class="hide-menu">Odontograma</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forodontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Odontograma</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="odontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

<!--                                        <li class="sidebar-item"><a href="consentimientos" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-priority-low"></i><span class="hide-menu"> Consentimientos</span></a>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="odontologiaxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Odontolog. x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart-plus"></i><span
                                                class="hide-menu">Facturación </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forfacturacion" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Facturación </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="facturaspendientes" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Facturas Pendientes </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="facturaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="facturacionxcaja"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Facturación x Cajas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Paciente</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu">Créditos </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="creditos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nuevo Pago </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxfechas" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Fechas </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxpaciente" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Paciente </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxdetalles" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Detalles </span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"></span> Cerrar Sesión</a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->


                <?php
                break;
            case 'secretaria': ?>

                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-settings"></i><span class="hide-menu">Herramientas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span class="hide-menu">Configuración</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="departamentos"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Departamentos</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="provincias" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Ciudad</a></li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="documentos" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Docum.
                                                        Tributarios</a></li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="mensajes" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Mensajes</a></li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-receipt"></i><span-->
<!--                                                        class="hide-menu">Productos</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="marcas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Marcas</a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="presentaciones" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Presentaciones</a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="medidas" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Unidad de Medida</a>-->
<!--                                                </li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a href="tratamientos" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span
                                                        class="hide-menu"> Tratamientos </span></a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="graficos" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Gráficos</a></li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-folder-multiple"></i><span class="hide-menu">Mantenimiento</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Personal</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="especialistas"
                                                                            aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Especialistas</a>
                                                </li>

                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                            href="pacientes" aria-expanded="false"><i
                                                                class="mdi mdi-clipboard-text"></i>Pacientes</a></li>

<!--                                                <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"-->
<!--                                                                            href="proveedores" aria-expanded="false"><i-->
<!--                                                                class="mdi mdi-clipboard-text"></i>Proveedores</a></li>-->

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="servicios" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Búsqueda General</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosvendidos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios Vendidos </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="serviciosxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Servicios x Vendedor</span></a></li>

                                                <li class="sidebar-item"><a href="serviciosxmoneda"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Servicios x Moneda </span></a>
                                                </li>

                                            </ul>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Servicios</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="buscakardexservicio"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Kardex de Servicios</span></a></li>

                                                <li class="sidebar-item"><a href="kardexserviciosvalorizadoxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>

                                            </ul>
                                        </li>

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span-->
<!--                                                        class="hide-menu">Almacen</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="forproducto" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Nuevo Producto</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productos" class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Búsqueda General</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosvendidos"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos Vendidos </span></a>-->
<!--                                                </li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxvendedor"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-rounded-corner"></i><span-->
<!--                                                                class="hide-menu"> Productos x Vendedor</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="productosxmoneda"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-cart-plus"></i><span class="hide-menu"> Productos x Moneda </span></a>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->

<!--                                        <li class="sidebar-item"><a-->
<!--                                                    class="sidebar-link has-arrow waves-effect waves-dark"-->
<!--                                                    href="javascript:void(0)" aria-expanded="false"><i-->
<!--                                                        class="mdi mdi-collage"></i><span class="hide-menu">Kardex Productos</span></a>-->
<!--                                            <ul aria-expanded="false" class="collapse second-level">-->
<!---->
<!--                                                <li class="sidebar-item"><a href="buscakardexproducto"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Kardex de Productos</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="kardexproductosvalorizado"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Kardex Valorizado</span></a></li>-->
<!---->
<!--                                                <li class="sidebar-item"><a href="kardexproductosvalorizadoxfechas"-->
<!--                                                                            class="sidebar-link"><i-->
<!--                                                                class="mdi mdi-priority-low"></i><span-->
<!--                                                                class="hide-menu"> Valorizado x Fechas</span></a></li>-->
<!---->
<!--                                            </ul>-->
<!--                                        </li>-->

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-receipt"></i><span
                                                        class="hide-menu">Traspasos</span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="traspasos" class="sidebar-link"><i
                                                                class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                                </li>

                                                <li class="sidebar-item"><a href="traspasosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Traspasos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="productostraspasos"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Productos Traspasos</span></a></li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart"></i><span class="hide-menu">Compras </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forcompra" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Compra </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="compras" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="cuentasxpagar" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Cuentas por Pagar </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="comprasxproveedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Compras x Proveedor</span></a></li>

                                                <li class="sidebar-item"><a href="comprasxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Compras x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="creditoscomprasxproveedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cards-variant"></i><span
                                                                class="hide-menu"> Créditos x Proveedor </span></a></li>

                                                <li class="sidebar-item"><a href="creditoscomprasxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-cards-variant"></i><span
                                                                class="hide-menu"> Créditos x Fechas </span></a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-scale-balance"></i><span
                                                class="hide-menu">Cotizaciones </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forcotizacion" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Cotización </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="cotizaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="cotizacionesxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Paciente</span></a></li>

                                                <li class="sidebar-item"><a href="productoscotizados"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Detalles Cotizados</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Cotizados x Vendedor</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Cita</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="citasxfechas" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Citas x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="citasxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="citasxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-desktop-mac"></i><span
                                                class="hide-menu">Cajas </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="arqueos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Arqueos de Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="movimientos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Movimientos en Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="arqueosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Arqueos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="movimientosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Movimientos x Fechas</span></a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-tooth"></i><span class="hide-menu">Odontograma</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="odontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a href="consentimientos" class="sidebar-link"><i
                                                        class="mdi mdi-priority-low"></i><span class="hide-menu"> Consentimientos</span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="odontologiaxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Odontolog. x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart-plus"></i><span
                                                class="hide-menu">Facturación </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="facturaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="facturacionxcaja"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Facturación x Cajas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Paciente</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu">Créditos </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="creditos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nuevo Pago </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxfechas" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Fechas </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxpaciente" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Paciente </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxdetalles" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Detalles </span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"></span> Cerrar Sesión</a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->


                <?php
                break;
            case 'cajero': ?>


                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="especialistas" class="sidebar-link"><i
                                                class="mdi mdi-account-switch"></i><span class="hide-menu"> Especialistas</span></a>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="pacientes" class="sidebar-link"><i
                                                class="mdi mdi-account-multiple"></i><span
                                                class="hide-menu"> Pacientes</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="servicios" class="sidebar-link"><i
                                                class="mdi mdi-folder-multiple"></i><span
                                                class="hide-menu"> Servicios</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="productos" class="sidebar-link"><i
                                                class="mdi mdi-cube"></i><span class="hide-menu"> Productos</span></a>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-scale-balance"></i><span
                                                class="hide-menu">Cotizaciones </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forcotizacion" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Cotización </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="cotizaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="cotizacionesxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Paciente</span></a></li>

                                                <li class="sidebar-item"><a href="productoscotizados"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Detalles Cotizados</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxvendedor"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Cotizados x Vendedor</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Cita</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="citasxfechas" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Citas x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="citasxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="citasxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-desktop-mac"></i><span
                                                class="hide-menu">Cajas </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="arqueos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Arqueos de Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="movimientos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Movimientos en Caja </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="arqueosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Arqueos x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="movimientosxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Movimientos x Fechas</span></a></li>

                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart-plus"></i><span
                                                class="hide-menu">Facturación </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="facturaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="facturaspendientes" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Facturas Pendientes </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="facturacionxcaja"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Facturación x Cajas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxespecialista"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Espec.</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Paciente</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu">Créditos </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="creditos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxfechas" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Fechas </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxpaciente" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Paciente </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxdetalles" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Detalles </span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"></span> Cerrar Sesión</a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->

                <?php
                break;
            case 'especialista': ?>

                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="datos" class="sidebar-link"><i
                                                class="mdi mdi-account-edit"></i><span
                                                class="hide-menu"> Mis Datos</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="pacientes" class="sidebar-link"><i
                                                class="mdi mdi-account-multiple"></i><span
                                                class="hide-menu"> Pacientes</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="servicios" class="sidebar-link"><i
                                                class="mdi mdi-folder-multiple"></i><span
                                                class="hide-menu"> Servicios</span></a></li>

<!--                                <li class="sidebar-item waves-effect"><a href="productos" class="sidebar-link"><i-->
<!--                                                class="mdi mdi-cube"></i><span class="hide-menu"> Productos</span></a>-->
<!--                                </li>-->

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-scale-balance"></i><span
                                                class="hide-menu">Cotizaciones </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="forcotizacion" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Nueva Cotización </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="cotizaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="cotizacionesxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="cotizacionesxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Cotización x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Cita</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="citasxfechas" class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Citas x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="citasxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Citas x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-tooth"></i><span class="hide-menu">Odontograma</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forodontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Odontograma</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="odontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                        <li class="sidebar-item"><a href="consentimientos" class="sidebar-link"><i
                                                        class="mdi mdi-priority-low"></i><span class="hide-menu"> Consentimientos</span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="odontologiaxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Odontolog. x Fechas </span></a></li>

                                                <li class="sidebar-item"><a href="odontologiaxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-priority-low"></i><span
                                                                class="hide-menu"> Odontolog. x Paciente</span></a></li>

                                            </ul>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-cart-plus"></i><span
                                                class="hide-menu">Facturación </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="facturaciones" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="facturaspendientes" class="sidebar-link"><i
                                                        class="mdi mdi-cart"></i><span class="hide-menu"> Facturas Pendientes </span></a>
                                        </li>

                                        <li class="sidebar-item"><a
                                                    class="sidebar-link has-arrow waves-effect waves-dark"
                                                    href="javascript:void(0)" aria-expanded="false"><i
                                                        class="mdi mdi-collage"></i><span
                                                        class="hide-menu">Reportes </span></a>
                                            <ul aria-expanded="false" class="collapse second-level">

                                                <li class="sidebar-item"><a href="facturacionxfechas"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Fechas</span></a></li>

                                                <li class="sidebar-item"><a href="facturacionxpaciente"
                                                                            class="sidebar-link"><i
                                                                class="mdi mdi-rounded-corner"></i><span
                                                                class="hide-menu"> Facturación x Paciente</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>


                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu">Créditos </span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a href="creditos" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Búsqueda General </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxfechas" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Fechas </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxpaciente" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Paciente </span></a>
                                        </li>

                                        <li class="sidebar-item"><a href="creditosxdetalles" class="sidebar-link"><i
                                                        class="mdi mdi-cards-variant"></i><span class="hide-menu"> Créditos x Detalles </span></a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"></span> Cerrar Sesión</a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->

                <?php
                break;
            case 'paciente': ?>

                <!-- ============================================================== -->
                <!-- Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->
                <aside class="left-sidebar">
                    <!-- Sidebar scroll-->
                    <div class="scroll-sidebar">
                        <!-- Sidebar navigation-->
                        <nav class="sidebar-nav">
                            <ul id="sidebarnav">
                                <!-- User Profile-->
                                <li class="nav-small-cap"><i class="mdi mdi-dots-horizontal"></i> <span
                                            class="hide-menu">MENU</span></li>

                                <li class="sidebar-item waves-effect"><a href="panel" class="sidebar-link"><i
                                                class="mdi mdi-home"></i><span class="hide-menu"> Inicio</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="forpaciente" class="sidebar-link"><i
                                                class="mdi mdi-account-edit"></i><span
                                                class="hide-menu"> Mis Datos</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="cotizaciones" class="sidebar-link"><i
                                                class="mdi mdi-calculator"></i><span
                                                class="hide-menu"> Cotizaciones</span></a></li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-calendar-multiple"></i><span
                                                class="hide-menu">Citas</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="forcita" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Nueva Cita</a></li>

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="citas" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

                                    </ul>
                                </li>

                                <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark"
                                                            href="javascript:void(0)" aria-expanded="false"><i
                                                class="mdi mdi-tooth"></i><span class="hide-menu">Odontológia</span></a>
                                    <ul aria-expanded="false" class="collapse first-level">

                                        <li class="sidebar-item"><a class="sidebar-link waves-effect waves-dark"
                                                                    href="odontologia" aria-expanded="false"><i
                                                        class="mdi mdi-clipboard-text"></i>Búsqueda General</a></li>

<!--                                        <li class="sidebar-item"><a href="consentimientos" class="sidebar-link"><i-->
<!--                                                        class="mdi mdi-priority-low"></i><span class="hide-menu"> Consentimientos</span></a>-->
<!--                                        </li>-->

                                    </ul>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="facturaciones" class="sidebar-link"><i
                                                class="mdi mdi-file-multiple"></i><span
                                                class="hide-menu"> Facturación</span></a></li>

                                <li class="sidebar-item waves-effect"><a href="creditos" class="sidebar-link"><i
                                                class="mdi mdi-credit-card"></i><span class="hide-menu"> Créditos</span></a>
                                </li>

                                <li class="sidebar-item waves-effect"><a href="logout" class="sidebar-link"><i
                                                class="mdi mdi-power"></i><span class="hide-menu"></span> Cerrar Sesión</a>
                                </li>

                            </ul>
                        </nav>
                        <!-- End Sidebar navigation -->
                    </div>
                    <!-- End Sidebar scroll-->
                </aside>
                <!-- ============================================================== -->
                <!-- End Left Sidebar - style you can find in sidebar.scss  -->
                <!-- ============================================================== -->

                <?php
                break;
        } ?>


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