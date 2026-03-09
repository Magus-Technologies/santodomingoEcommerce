<?php
date_default_timezone_set('America/Lima');

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

$isSesionUser = isset($_SESSION['usuario']);
$perfilUser = '';

//echo $isSesionUser?'11111111111':'222222222222';
if ($isSesionUser) {
    $perfilUser = $_SESSION['perfil'];
}

?>
<style>
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 160px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none;
        z-index: 1000;
    }

    .dropdown:hover .dropdown-menu,
    .dropdown:focus-within .dropdown-menu {
        display: block;
    }

    .nav-options-i {
        position: relative;
    }

    .dropdown-item {
        padding: 8px 20px 8px 20px;
        color: #333;
        font-size: 14px;
        text-transform: capitalize;
    }

    .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .dropdown-menu ul {
        list-style-type: none;
        padding-left: 0;
        margin: 0;
    }

    .dropdown-menu li {
        list-style: none;
    }

    @media (max-width: 576px) {

        /* Estilos para m�vil */
        ifmobile {
            display: block;
            color: #fff;
        }
    }

    @media (min-width: 577px) {
        .ifmobile {
            display: none;
        }
    }
</style>

<?php
$body_class = 'desktop';

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $body_class = "tablet";
    $divice = 2;
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {

    $body_class = "mobile";
    $divice = 1;
}

if ($body_class == 'desktop') { ?>
    <style>
        .titulo_prod {
            height: 40px;
        }

        .titulo_prod>a {
            white-space: normal
        }
    </style>
<?php } elseif ($body_class == 'mobile') { ?>
    <style>
        .titulo_prod {
            height: 34px;
        }

        .titulo_prod>a {
            white-space: normal
        }
    </style>
<?php } elseif ($body_class == 'tablet') { ?>
    <style>
        .titulo_prod {
            height: 34px;
        }

        .titulo_prod>a {
            white-space: normal
        }
    </style>
<?php }

?>





<?php
require_once "../extra/TasaCambioApi.php";

$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

$vusu = $_SESSION['usuario'];
$sqlf = "SELECT (CASE WHEN vip_estado = '1' THEN 'SI' ELSE 'NO' END) AS vip  FROM usuarios_vip WHERE use_id='$vusu'";
$resulta = $productoDao->exeSQL($sqlf);
foreach ($resulta as $rowpd) {
    $vip = $rowpd['vip'];
}
$vip_status = empty($rowpd['vip']) ? 'NO' : ($rowpd['vip'] === 'SI' ? 'SI' : 'NO');


?>
<input type="hidden" value="<?= $tc ?>" id="tasa_cambio">
<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header" style="background: #880107;border:none">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="lng_dropdown mr-2">
                            <!--
                            <select name="countries" class="custome_select">
                                <option value='en' data-image="../public/assets/images/eng.png" data-title="English">English</option>
                                <option value='fn' data-image="../public/assets/images/fn.png" data-title="France">France</option>
                                <option value='us' data-image="../public/assets/images/us.png" data-title="United States">United States</option>
                            </select> -->
                            <i class="ti-location-pin"
                                style="float: left; color: #fff;font-size: 19px;transform: translateY(4px);"></i>&nbsp;
                            <p style="float: left; margin: 0px; font-size: 14px; color: #fff;">
                                <strong><?= $dataConf['direccion'] ?></strong>
                            </p>
                        </div>
                        <div class="mr-3">
                            <!--
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="USD">USD</option>
                                <option value='EUR' data-title="EUR">EUR</option>
                                <option value='GBR' data-title="GBR">GBR</option>
                            </select>-->
                        </div>
                        <ul class="contact_detail text-center text-lg-left">
                            <!--
                            <li><i class="ti-mobile"></i><span>994 009 195</span></li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center text-md-right">
                        <ul class="header_list">

                            <?php
                            if ($isSesionUser) {
                                if ($perfilUser != 'usuario') {
                                    if ($perfilUser == 'vendedor') {
                                        echo '<li><a href="../admin/pedidos.php" class="text-white"><i class="ti-control-shuffle"></i><span>Administrar</span></a></li>';
                                    } else {
                                        echo '<li><a href="../admin/" class="text-white"><i class="ti-control-shuffle"></i><span>Administrar</span></a></li>';
                                    }
                                }
                                echo '<li><a href="./my-account.php" class="text-white"><i class="ti-agenda"></i><span>Mi Cuenta</span></a></li>';
                                echo '<li><a href="../auth/logout.php" class="text-white"><i class="ti-user"></i><span>Cerrar Sesi&oacute;n</span></a></li>';
                            } else {
                                echo '<li><a href="./login.php" class="text-white"><i class="ti-user"></i><span>Iniciar Sesi&oacute;n</span></a></li>';
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

    //$listaMarcas = $conexion->query("SELECT * FROM marcra_productos");
    $listaOfertas = $productoDao->getDataofertas();
    $listaMarcas = $conexion->query("SELECT * FROM marcra_productos WHERE estado='1' order by nombre_marca asc ");
    ?>
    <div class="bottom_header main_menu_uppercase" style="background:#c7161d;">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a style="width: 30%;" class="navbar-brand" href="index.php">
                    <img src="../public/images/cym.png" width="50%" alt="logo" />
                </a>
                <button style="color: white;" class="navbar-toggler side_navbar_toggler" type="button"
                    data-toggle="collapse" data-target="#navbarSidetoggleE" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <!--<div class="pr_search_icon">
                                <a href="javascript:void(0);" style="color: white;" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                            </div>-->
                <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggleE">
                    <ul class="navbar-nav" <?= $body_class == 'desktop' ? ' style="background:#c7161d;" ' : ' style="background:#232323;"' ?>>


                        <li>
                            <a class="nav-link nav-options" href="index.php"><span><span>INICIO</span></a>
                        </li>

                        <li class="dropdown  nav-options-i">
                            <a class="nav-link " href="shop-list-prod-remate.php">VINO TINTO</a>

                        </li>

                        <li>
                            <a class="nav-link nav-options" href="shop-list-prod.php?search=+&type=last">VINO BLANCO</a>

                        </li>
                        <li class="dropdown  nav-options-i">
                            <a class="nav-link  " href="shop-list-prod-ofertas.php">VINO ROSADO</a>

                        </li>
                        <li class="">
                            <a class="nav-link nav-options" href="./shop-list-prod-exclu.php">PISCO</a>
                        </li>
                        <li class="dropdown  nav-options-i">
                            <a class="nav-link   " href="#">DISTRIBUCION</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <?php
                                    $vipUrl = '';

                                    // Determinar si el usuario tiene acceso VIP
                                    if ($isSesionUser && $perfilUser != 'usuario') {
                                        $vipUrl = 'shop-list-vip.php?search=+&type=last+&v=vp';
                                        $textLink = '';  // Texto alertas
                                    } elseif ($isSesionUser == "") {
                                        $vipUrl = 'login.php?v=vp';
                                        $textLink = '';
                                    } elseif (($perfilUser == 'usuario' || $perfilUser == 'Usuario') && $vip_status == 'SI') {
                                        $vipUrl = 'shop-list-vip.php?search=+&type=last+&v=vp';
                                        $textLink = '';     //
                                    } else {
                                        $vipUrl = '#';
                                        $textLink = 'alertavip';
                                    }
                                    ?>

                                    <li style="list-style: none; font-size: 14px;"><a class="dropdown-item nav_item"
                                            style="background-color:#fff; color:#000;" href="<?= $vipUrl ?>"
                                            id="<?= $textLink ?>">Precio VIP </a></li>
                                    <li style="list-style: none; font-size: 14px;"><a class="dropdown-item nav-item "
                                            style="background-color:#fff;  color:#000;"
                                            href="shop-list-distri.php?search=+&type=last+&v=dt">Precio
                                            Distribuci&oacute;n</a></li>
                                </ul>
                            </div>

                        </li>
                        <li class="">
                            <a class="nav-link nav-options" href="./contact.php">CONTACTANOS</a>
                        </li>
                        <li class="ifmobile" style="background-color:red;">
                            <a class="nav-link nav-options" href="#"
                                onclick="document.getElementById('navbarSidetoggleE').classList.remove('show'); return false;">
                                <span class="fa fa-close" style="max-width: 20px; font-size: 20px;"></span> CERRAR
                            </a>
                        </li>


                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:void(0);" class="nav-link search_trigger"></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form action="shop-list-prod.php" method="GET">
                                <input name="search" type="text" placeholder="Buscar" class="form-control"
                                    id="search_input">
                                <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                        <div class="search_overlay"></div>
                    </li>
                    <li class="dropdown cart_dropdown" id="content-carrito"><a class="nav-link cart_trigger"
                            style="color:#fff;" id="btnMostarCarrito" href="#" data-toggle="dropdown"><i
                                class="linearicons-bag2"></i><span v-if="listaCarrito.length>0"
                                class="cart_count">{{listaCarrito.length}}</span><span class="amount"><span
                                    class="currency_symbol">S/</span>{{totalCar}}</span></a>
                        <div class="cart_box cart_right dropdown-menu dropdown-menu-right" id="divCarrito">
                            <ul class="cart_list">
                                <li v-for="(item, index) in listaCarrito" style="color:#fff;">
                                    <a href="#" @click="eliminarProdCarrito(index)" class="item_remove"><i
                                            class="ion-close"></i></a>
                                    <a href="#"><img style="max-width: 80px;max-height: 80px"
                                            :src="'../public/img/productos/'+item.imagen"
                                            alt="cart_thumb1">{{item.nombre_prod}}</a>
                                    <span class="cart_quantity" style="color:#fff;"> {{item.cantidad}} x <span
                                            class="cart_amount"> <span
                                                class="price_symbole">S/</span></span>{{item.precio}}</span>
                                </li>
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_total"><strong>Subtotal:</strong> <span class="cart_price"> <span
                                            class="price_symbole">S/</span></span>{{totalCar}}</p>
                                <p class="cart_buttons"><a href="shop-cart.php" class="btn btn-fill-line view-cart">Ver
                                        carrito</a><a href="checkout.php" class="btn btn-fill-out checkout">Pagar</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>



</header>
<script>
    var showCarrito = false
    var showNav = false
    window.addEventListener('DOMContentLoaded', (event) => {
        const element = document.getElementById("btnMostarCarrito");
        const showNavButton = document.getElementById("showNav");
        if (element) {
            element.addEventListener("click", myFunction);
        }
        if (showNavButton) {
            showNavButton.addEventListener("click", myFunctionNav);
        }


        function myFunction() {
            showCarrito = !showCarrito
            if (showCarrito) {
                document.getElementById("divCarrito").classList.add("show");
            } else {
                document.getElementById("divCarrito").classList.remove("show");
            }
        }

        function myFunctionNav() {
            showNav = !showNav
            console.log('showNav');
            if (showNav) {
                document.getElementById("navbarSupportedContent").classList.add("show");
            } else {
                document.getElementById("navbarSupportedContent").classList.remove("show");
            }
        }
    });

    window.onload = function () {
        $('#alertavip').click(function () {
            alert('Usted no tiene permisos para acceder al area VIP');

        });

</script>
