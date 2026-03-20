<?php


$isSesionUser = isset($_SESSION['usuario']);
$perfilUser = '';

//echo $isSesionUser?'11111111111':'222222222222';
if ($isSesionUser) {
    $perfilUser = $_SESSION['perfil'];
    if ($perfilUser == 'usuario') {
        header("Location: ../CYM");
    }
} else {
    header("Location: ../CYM/");
}

?>
<header class="header_wrap fixed-top header_with_topbar">

    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="../public/images/cym.png" alt="logo" style="height:50px;" />
                </a>
                <!--button style="padding: 5px;padding-left: 12px;margin-left: 5px;}" class="btn btn-info"><i class="fa fa-edit"></i></button-->
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent"
                    style="background-color:#c7161d">
                    <ul class="navbar-nav">

                        <li class="testing">
                            <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#"
                                style="color:#fff">Tienda</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="../CYM/">Inicio</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="../admin">Administrar</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="http://localhost/public_html/CYM/">Panel Admin</a>
                                    </li>
                                    <?php if ($_SESSION['perfil'] == 'admin' or $_SESSION['perfil'] == 'vendedor'): ?>
                                        <li>
                                            <a class="dropdown-item nav-link nav_item" href="./reclamosrec.php">Reclamos</a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="./Deliveryp.php">Delivery
                                            Externo</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="./Deliveryi.php">Delivery
                                            Arequipa</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link nav_item" href="./bancos.php">Bancos </a>
                                    </li>

                                </ul>
                            </div>
                        </li>

                        <?php if ($_SESSION['perfil'] == 'usuarios digital' or $_SESSION['perfil'] == 'admin'): ?>
                            <li>
                                <a class="nav-link nav_item" href="./usuarios_digitales_cotizaciones.php"
                                    style="color:#fff">Cotizaciones</a>
                            </li>
                            <?php if ($_SESSION['perfil'] == 'usuarios digital'): ?>
                                <li>
                                    <a class="nav-link nav_item" href="./usuarios_digitales_ingresos.php" style="color:#fff">Mis
                                        ingresos</a>
                                </li>
                            <?php endif; ?>

                        <?php endif; ?>
                        <?php if ($_SESSION['perfil'] == 'admin'): ?>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="nav-link dropdown-toggle " href="#"
                                    style="color:#fff">Configuracion</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="./">Principal</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./confBaner.php">Banners</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./menu.php">Men&uacute; de Navegaci&oacute;n</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./librorec.php">Libro de Reclamaciones</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./nosotros.php">P&aacute;gina Nosotros</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./terminos.php">T&eacute;rminos y Condiciones</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./conf_seleccion.php">Nuestra Selecci&oacute;n</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./usuarios.php">Usuarios
                                                Vendedores</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item"
                                                href="./usuarios_digitales.php">Usuarios Digitales</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item"
                                                href="./usuarios_promociones.php">Usuarios
                                                Suscritos</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./formas_pago.php">Formas
                                                de
                                                Pago</a></li>

                                    </ul>

                                </div>

                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="nav-link dropdown-toggle " href="#"
                                    style="color:#fff">Productos</a>
                                <div class="dropdown-menu">


                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="./productos.php">Lista de
                                                Productos</a></li>
                                        <li><a class="dropdown-item nav-link nav_item"
                                                href="./categorias.php">Categorias</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./marcas.php">Marcas</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./productos_remate.php">Productos en Remate</a>
                                        </li>


                                    </ul>

                                </div>

                            </li>

                            <li class="dropdown">
                                <a data-toggle="dropdown" class="nav-link dropdown-toggle " href="#"
                                    style="color:#fff">Listas</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        <li><a class="dropdown-item nav-link nav_item" href="./productos_pc_armadas.php">Pc
                                                Armadas</a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./ofertas.php">Ofertas</a>
                                        </li>
                                        <li><a class="dropdown-item nav-link nav_item" href="./exclusivo.php">Exclusivos</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a class="nav-link nav_item" href="./contacto.php" style="color:#fff">Contacto</a>
                            </li>
                            <li>
                                <a class="nav-link nav_item" href="./nosotros.php" style="color:#fff">Nosotros</a>
                            </li>
                            <li>
                                <a class="nav-link nav_item" href="./pedidos.php" style="color:#fff">Pedidos</a>
                            </li>
                            <li>
                                <a class="nav-link nav_item" href="./compras.php" style="color:#fff">Compras</a>
                            </li>
                        <?php endif; ?>

                        <li><a class="nav-link nav_item" href="../auth/logout.php" style="color:#fff">Salir</a></li>
                    </ul>
                </div>

            </nav>
        </div>
    </div>
</header>