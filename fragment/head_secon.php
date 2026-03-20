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
    /* ── Navbar principal ── */
    .header_wrap { box-shadow: 0 2px 8px rgba(0,0,0,0.18); }

    /* Barra superior */
    .top-header { background: #8a0009 !important; padding: 5px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .header_list { list-style: none; margin: 0; padding: 0; display: flex; gap: 16px; justify-content: flex-end; align-items: center; }
    .header_list li a { color: rgba(255,255,255,0.82); font-size: 12px; text-decoration: none; letter-spacing: 0.3px; transition: color 0.2s; }
    .header_list li a:hover { color: #ece6a3; }
    .header_list li a i { margin-right: 4px; }

    /* Barra de menú */
    .bottom_header { background: #c7161d !important; }
    .bottom_header .navbar { padding: 0; }
    .navbar-brand img { max-height: 40px; width: auto !important; }

    /* Items del menú */
    .nav-options {
        color: #fff !important;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.6px;
        padding: 16px 13px !important;
        transition: color 0.2s, background 0.2s;
        text-decoration: none;
    }
    .nav-options:hover { color: #ece6a3 !important; background: rgba(0,0,0,0.12) !important; }

    /* Dropdown */
    .nav-options-i { position: relative; }
    .nav-options-i .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 180px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(0,0,0,0.13);
        border: none;
        border-radius: 0 0 6px 6px;
        display: none;
        z-index: 1050;
        padding: 6px 0;
    }
    .nav-options-i:hover .dropdown-menu,
    .nav-options-i:focus-within .dropdown-menu { display: block; }
    .nav-options-i .dropdown-menu .dropdown-item {
        color: #333;
        font-size: 13px;
        padding: 9px 18px;
        font-weight: 500;
    }
    .nav-options-i .dropdown-menu .dropdown-item:hover { background: #f5f5f5; color: #c7161d; }
    .nav-options-i .dropdown-menu ul { list-style: none; padding: 0; margin: 0; }
    .nav-options-i .dropdown-menu li { list-style: none; }

    /* Dirección en top bar */
    .top-address { color: rgba(255,255,255,0.82); font-size: 12px; display: flex; align-items: center; gap: 5px; }
    .top-address i { color: #ece6a3; }

    /* Mobile */
    @media (max-width: 991px) {
        .ifmobile { display: block !important; }
        .mobile_side_menu { background: #232323 !important; }
        .mobile_side_menu .nav-options { padding: 12px 18px !important; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .navbar-brand img { max-height: 32px; }
    }
    @media (min-width: 992px) {
        .ifmobile { display: none !important; }
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
    <div class="top-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <span class="top-address">
                    <i class="ti-location-pin"></i>
                    <?= htmlspecialchars($dataConf['direccion'] ?? '') ?>
                </span>
                <ul class="header_list">
                    <?php if ($isSesionUser): ?>
                        <?php if ($perfilUser !== 'usuario'): ?>
                            <?php if ($perfilUser === 'vendedor'): ?>
                                <li><a href="../admin/pedidos.php"><i class="ti-control-shuffle"></i> Administrar</a></li>
                            <?php else: ?>
                                <li><a href="../admin/"><i class="ti-control-shuffle"></i> Administrar</a></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li><a href="./my-account.php"><i class="ti-agenda"></i> Mi Cuenta</a></li>
                        <li><a href="../auth/logout.php"><i class="ti-user"></i> Cerrar Sesión</a></li>
                    <?php else: ?>
                        <li><a href="./login.php"><i class="ti-user"></i> Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <li style="color:rgba(255,255,255,0.5); font-size:12px; align-self:center;">
                        <i class="ti-exchange-vertical" style="color:#ece6a3;"></i> TC: <strong style="color:#ece6a3;"><?= $tc ?></strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php

    //$listaMarcas = $conexion->query("SELECT * FROM marcra_productos");
    $listaOfertas = $productoDao->getDataofertas();
    $listaMarcas = $conexion->query("SELECT * FROM marcra_productos WHERE estado='1' order by nombre_marca asc ");
    if (!isset($dataConf)) {
        if (!class_exists('Tools')) { require __DIR__ . '/../utils/Tools.php'; }
        $dataConf = (new Tools())->getConfiguracion();
    }
    $_menuNav = $dataConf['menu_nav'] ?? [];
    ?>
    <div class="bottom_header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php">
                    <img src="../public/images/cym.png" alt="logo" />
                </a>
                <button class="navbar-toggler side_navbar_toggler" type="button"
                    data-toggle="collapse" data-target="#navbarSidetoggleE" aria-expanded="false"
                    style="color:white; border-color:rgba(255,255,255,0.4);">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggleE">
                    <ul class="navbar-nav">

                        <?php foreach ($_menuNav as $_item): ?>
                        <?php if (($_item['estado'] ?? '1') === '1'):
                            $_hijos = $_item['hijos'] ?? [];
                        ?>
                        <li class="nav-options-i<?= count($_hijos) ? ' dropdown' : '' ?>">
                            <a class="nav-link nav-options" href="<?= htmlspecialchars($_item['url']) ?>"><?= htmlspecialchars($_item['titulo']) ?><?= count($_hijos) ? ' <i class="fa fa-caret-down" style="font-size:10px;"></i>' : '' ?></a>
                            <?php if (count($_hijos)): ?>
                            <div class="dropdown-menu">
                                <ul>
                                    <?php foreach ($_hijos as $_hijo): ?>
                                    <li><a class="dropdown-item" href="<?= htmlspecialchars($_hijo['url']) ?>"><?= htmlspecialchars($_hijo['titulo']) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>

                        <li class="nav-options-i">
                            <a class="nav-link nav-options" href="#">DISTRIBUCIÓN</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <?php
                                    if ($isSesionUser && $perfilUser != 'usuario') {
                                        $vipUrl = 'shop-list-vip.php?search=+&type=last+&v=vp';
                                        $textLink = '';
                                    } elseif ($isSesionUser == "") {
                                        $vipUrl = 'login.php?v=vp';
                                        $textLink = '';
                                    } elseif (($perfilUser == 'usuario' || $perfilUser == 'Usuario') && $vip_status == 'SI') {
                                        $vipUrl = 'shop-list-vip.php?search=+&type=last+&v=vp';
                                        $textLink = '';
                                    } else {
                                        $vipUrl = '#';
                                        $textLink = 'alertavip';
                                    }
                                    ?>
                                    <li><a class="dropdown-item" href="<?= $vipUrl ?>" id="<?= $textLink ?>">Precio VIP</a></li>
                                    <li><a class="dropdown-item" href="shop-list-distri.php?search=+&type=last+&v=dt">Precio Distribución</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="ifmobile" style="background:#b01018;">
                            <a class="nav-link nav-options" href="#"
                                onclick="document.getElementById('navbarSidetoggleE').classList.remove('show'); return false;">
                                <i class="fa fa-close"></i> CERRAR
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
                                            :src="item.imagen && (item.imagen.startsWith('http') || item.imagen.indexOf('/') !== -1) ? item.imagen : '../public/img/productos/'+item.imagen"
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