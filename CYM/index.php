<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);


session_start();
/* var_dump($_SESSION['usuario']);
die(); */
/* echo getcwd(); */
date_default_timezone_set('America/Lima');


require "../utils/Tools.php";
require "../dao/NuevoImgresoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../dao/ProductoDao.php";
require_once "../extra/TasaCambioApi.php";


$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'] ?? 0;
$isSesionUser = isset($_SESSION['usuario']);
$perfilUser = '';

if ($isSesionUser) {
    $perfilUser = $_SESSION['perfil'];
}

$grupoCategoriaDao = new GrupoCategoriaDao();
$nuevoImgresoDao = new NuevoImgresoDao();
$productoDao = new ProductoDao();
$tools = new Tools();
$conexion = (new Conexion())->getConexion();


$listaGrupos = $grupoCategoriaDao->getListaCate();
//$listaNue = $nuevoImgresoDao->getLista();

$listaNue = $productoDao->getLastRegister(15);

$listaRmaRema = $productoDao->getLastRegisterRemaRema(15);
//var_dump($listaRmaRema);die;
/* echo "<pre>";
var_dump($listaNue);
die(); */
$listaNue2 = $productoDao->getLastRegisterSilver(7);
$randonItemProdsss = $productoDao->getRandonRegister(46);
$listaRamMasVen = array_slice($randonItemProdsss, 0, 29);

/* var_dump($listaRamMasVen);
die();  */
/* $listaRamTenden = $productoDao->getRandonRegister(12); */
$listaRamTenden = array_slice($randonItemProdsss, 30, 7);
/* var_dump($listaRamTenden);
die(); */
$listaRamTendenInstagram = array_slice($randonItemProdsss, 38, 7);
/* var_dump($listaRamTendenInstagram);
die(); */
$listaRamByCat = $productoDao->getDataRandonE();
/*  echo "<pre>";
var_dump($listaRamByCat);
die();  */
$listaOfertas = $productoDao->getDataofertas();
/* echo "<pre>";
var_dump($listaOfertas);
die();
 */

//print_r($listaOfertas);
////////////// BANNER LATERAL
$dataConf = $tools->getConfiguracion();
//var_dump($dataConf);
$usarBanner6 = $dataConf['banner_menu_lateral_6'];
$nuevoArray = [];
foreach ($usarBanner6 as $row) {
    if ($row['estado'] !== '0') {
        $nuevoArray[] = $row;
    }
}
$cantidadIndex = count($nuevoArray);
$randonIndex = rand(0, $cantidadIndex - 1);
$banner6Final = $nuevoArray[$randonIndex];

////////////// BANNER EXTRA//////////////////////////////////////////////////////////
$dataConf = $tools->getConfiguracion();
$usarBannerExtra = $dataConf['banner_extra'];
$nuevoArrayExtra = [];
foreach ($usarBannerExtra as $row) {
    if ($row['estado'] !== '0') {
        $nuevoArrayExtra[] = $row;
    }
}
$cantidadIndexExtra = count($nuevoArrayExtra);
$randonIndexExtra = rand(0, $cantidadIndexExtra - 1);
$banner6FinalExtra = $nuevoArrayExtra[$randonIndexExtra];

$usarBannerExtra2 = isset($dataConf['banner_extra_remate']) ? $dataConf['banner_extra_remate'] : [];
$nuevoArrayExtra2 = [];
foreach ($usarBannerExtra2 as $row) {
    if ($row['estado'] !== '0') {
        $nuevoArrayExtra2[] = $row;
    }
}
$cantidadIndexExtra2 = count($nuevoArrayExtra2);
$randonIndexExtra2 = rand(0, $cantidadIndexExtra2 - 1);
$banner55FinalExtra = isset($nuevoArrayExtra2[$randonIndexExtra2]) ? $nuevoArrayExtra2[$randonIndexExtra2]
    : ['url' => '', 'imagen' => ''];
/* echo "<pre>";
var_dump($banner6FinalExtra);
die();
 */

////////////////// BANNER INFERIOR///////////
$usarBanner6 = $dataConf['banner_inferior'];
$nuevoArrayInferior = [];
foreach ($usarBanner6 as $row) {
    if ($row['estado'] !== '0') {
        $nuevoArrayInferior[] = $row;
    }
}
$cantidadIndexInferior = count($nuevoArrayInferior);
/* $numbers = range(0, $cantidadIndexInferior - 1); */
shuffle($nuevoArrayInferior);
/* $bannerInferiorOk = array_slice($numbers, 0, 1); */
/* echo "<pre>"; */
/* var_dump($bannerInferiorOk); */
$arrayInferioFinal = [];
foreach (array_slice($nuevoArrayInferior, 0, 3) as $article) {
    $arrayInferioFinal[] = $article;
}
/* var_dump($arrayInferioFinal);
die(); */
/* $random = array();
for ($i = 0; $i < 3; $i++) {
    $random[$i] = rand(0, $cantidadIndexInferior - 1);
}
echo "<pre>"; */
/* echo "<pre>";
var_dump($rpta);
die(); */
/* var_dump($banner6Final);
die(); */

/* var_dump($usarBanner6[$randonIndex]);
die(); */
/* print_r($listaRamByCat);
die(); */
$listaMarcas = $conexion->query("SELECT * FROM marcra_productos WHERE estado = 1 order by nombre_marca asc");

$ban1_nombre = '';
$ban1_url = $dataConf['banner1']['image'];
/* echo "<pre>"
var_dump($dataConf);
die(); */
$ban1_ide = 'javascript:void(0)';

//echo strlen($dataConf['banner1']['prod']);
if (strlen($dataConf['banner1']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner1']['prod']);
    $respPROB1 = $productoDao->getData2();
    //print_r($respPROB1);
    if (count($respPROB1) > 0) {
        $ban1_nombre = $respPROB1['nombre'];
        $ban1_ide = "shop-product-detail.php?prod=" . $dataConf['banner1']['prod'];
    }
}

$ban2_nombre = '';
$ban2_url = $dataConf['banner2']['image'];
$ban2_ide = 'javascript:void(0)';

if (strlen($dataConf['banner2']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner2']['prod']);
    $respPROB2 = $productoDao->getData2();
    //print_r($respPROB1);
    $ban2_nombre = $respPROB2['nombre'];
    $ban2_ide = "shop-product-detail.php?prod=" . $dataConf['banner2']['prod'];
}

$banerCimg1 = $dataConf['banercentarl1']['image'];
$banerCprod1 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl1']['prod']) > 0) {

    $banerCprod1 = "shop-product-detail.php?prod=" . $dataConf['banercentarl1']['prod'];
}

$banerCimg2 = $dataConf['banercentarl2']['image'];
$banerCprod2 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl2']['prod']) > 0) {
    $banerCprod2 = "shop-product-detail.php?prod=" . $dataConf['banercentarl2']['prod'];
}

$banerCimg3 = $dataConf['banercentarl3']['image'];
$banerCprod3 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl3']['prod']) > 0) {
    $banerCprod3 = "shop-product-detail.php?prod=" . $dataConf['banercentarl3']['prod'];
}



/* $banerCimg1Prod = $dataConf['bannerprod1']['image'];
$banerCprod1Prod = 'javascript:void(0)';
if (strlen($dataConf['bannerprod1']['prod']) > 0) {

    $banerCprod1Prod = "shop-product-detail.php?prod=" . $dataConf['bannerprod1']['prod'];
} */

$banerCimg2Prod = $dataConf['bannerprod2']['image'];
$banerCprod2Prod = 'javascript:void(0)';
if (strlen($dataConf['bannerprod2']['prod']) > 0) {
    $banerCprod2Prod = "shop-product-detail.php?prod=" . $dataConf['bannerprod2']['prod'];
}

$sqlEXTERNO = "SELECT * FROM delivery_pasos WHERE tipo='E' ";
$RdeliveryP = $productoDao->exeSQL($sqlEXTERNO);

$sqlINTERNO = "SELECT * FROM delivery_pasos WHERE tipo='I' ";
$RdeliveryI = $productoDao->exeSQL($sqlINTERNO);

$vusu = $_SESSION['usuario'];
$sqlf = "SELECT (CASE WHEN vip_estado = '1' THEN 'SI' ELSE 'NO' END) AS vip  FROM usuarios_vip WHERE use_id='$vusu'";
$resulta = $productoDao->exeSQL($sqlf);
foreach ($resulta as $rowpd) {
    $vip = $rowpd['vip'];
}
$vip_status = empty($rowpd['vip']) ? 'NO' : ($rowpd['vip'] === 'SI' ? 'SI' : 'NO');

?>
<!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>
<!-- SITE TITLE -->
<title>VIÑA SANTO DOMINGO</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="../public/assets/css/animate.css">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
    rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="../public/assets/css/all.min.css">
<link rel="stylesheet" href="../public/assets/css/ionicons.min.css">
<link rel="stylesheet" href="../public/assets/css/themify-icons.css">
<link rel="stylesheet" href="../public/assets/css/linearicons.css">
<link rel="stylesheet" href="../public/assets/css/flaticon.css">
<link rel="stylesheet" href="../public/assets/css/simple-line-icons.css">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="../public/assets/css/magnific-popup.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="../public/assets/css/slick.css">
<link rel="stylesheet" href="../public/assets/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="../public/assets/css/style.css?v=2">
<link rel="stylesheet" href="../public/assets/css/responsive.css">
<link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">



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

        .nomobile {
            display: block;
        }

        @media only screen and (max-width: 768px) {
            .nomobile {
                display: none;
            }
        }
    </style>
<?php } elseif ($body_class == 'mobile') { ?>
    <style>
        @font-face {
            font-family: movilfontlema;
            src: url(../public/pristina.woff);
        }

        .titulo_prod {
            height: 32px;
        }

        .titulo_prod>a {
            white-space: normal
        }

        .nomobile {
            display: block;
        }

        @media only screen and (max-width: 768px) {
            .nomobile {
                display: none;
            }
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

        .nomobile {
            display: block;
        }

        @media only screen and (max-width: 768px) {
            .nomobile {
                display: none;
            }
        }
    </style>
<?php }

?>

<style>
    <?php
    if ($body_class == 'desktop') { ?>.menu-var {
        color: white;
    }

    .menu-var:hover {
        color: #f7324d;
    }


    <?php
    }
    ?>@media (max-width: 576px) {

        /* Estilos para m�vil */
        ifmobile {
            display: block;
        }
    }

    @media (min-width: 577px) {
        .ifmobile {
            display: none;
        }
    }
</style>

</head>

<body>

    <!-- LOADER
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>-->
    <!-- END LOADER -->


    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <div class="fluid-container" style="padding: 11px; width: 100%;overflow: hidden; background-color: #880107;">

        <p style="text-align: center; margin: 0px; color: #fff;"><i class="ti-location-pin"></i>
            <strong><?= $dataConf['direccion'] ?></strong>
        </p>
    </div>
    <header class="header_wrap">
        <?php include "../fragment/nav_bar_index.php" ?>
        <div style="background-color: #232323; height: 68px;margin-top:-2px;"
            class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
            <div class="custom-container">
                <div class="row">
                    <div class="" style="width: 20%">
                        <div class="categories_wrap">
                            <!--<button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn pink">
                                <i class="linearicons-menu"></i><span>CATEGOR&iacute;A DE PRODUCTOS </span>
                            </button>
                            <div id="navCatContent" class="nav_cat navbar collapse"> -->

                            <button type="button" data-toggle="collapse" data-target="#navCatContent"
                                aria-expanded="false" class="categories_btn  pink">
                                <i class="linearicons-menu"></i>&nbsp;&nbsp;<span>CATEGOR&iacute;A DE PRODUCTOS</span>
                            </button>
                            <div id="navCatContent" class="nav_cat navbar collapse">
                                <ul>
                                    <?php

                                    $contador = 0;
                                    $rowHTMLLISTECAt = "";
                                    foreach ($listaGrupos as $catRow) {

                                        if ($contador < 11) {
                                            if ($catRow['estado'] == 2) {
                                                if (true) {

                                                    $resSUb = $grupoCategoriaDao->getSubCat($catRow['id_seleccion']);

                                                    $listaProdRR = $productoDao->getListDataPR($catRow['codi_categoria'], 6); ?>
                                                    <li class="dropdown dropdown-mega-menu">
                                                        <a class="dropdown-item nav-link dropdown-toggler" href="#"
                                                            data-toggle="dropdown"><img style="max-width: 28px;"
                                                                src="../public/iconos/<?= $catRow['icono'] ?>">
                                                            <span><?= $catRow['nombre'] ?></span></a>
                                                        <div class="dropdown-menu">
                                                            <ul class="mega-menu d-lg-flex">
                                                                <li class="mega-menu-col col-lg-8">
                                                                    <ul class="d-lg-flex">
                                                                        <li class="mega-menu-col col-lg-8">
                                                                            <ul>

                                                                                <?php
                                                                                foreach ($resSUb as $rowMar) { ?>
                                                                                    <li class=""> <strong><a class="dropdown-header"
                                                                                                href="shop-list-ctg.php?ctg=<?= $catRow['codi_categoria'] ?>&sub=<?= $rowMar['sub_id'] ?>"
                                                                                                style="color:red"><?= $rowMar['nombre'] ?></a></strong>
                                                                                    </li>
                                                                                <?php }
                                                                                ?>

                                                                            </ul>
                                                                            <ul>
                                                                                <li class="dropdown-header text-cennter">Productos</li>
                                                                                <?php
                                                                                if ($body_class == 'desktop'):
                                                                                    foreach ($listaProdRR as $rowPrC) { ?>
                                                                                        <li><a style="display: block;
    
    padding: .5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    background-color: transparent;
    border: 0;
" href="shop-product-detail.php?prod=<?= $rowPrC['prod_id'] ?>"><?= $rowPrC['nombre'] ?></a></li>
                                                                                    <?php }
                                                                                else:
                                                                                    foreach ($listaProdRR as $rowPrC) { ?>
                                                                                        <li><a style="display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    background-color: transparent;
    text-overflow: ellipsis;
    border: 0;
" href="shop-product-detail.php?prod=<?= $rowPrC['prod_id'] ?>"><?= $rowPrC['nombre'] ?></a></li>


                                                                                <?php }
                                                                                endif; ?>

                                                                            </ul>
                                                                        </li>

                                                                    </ul>
                                                                </li>
                                                                <li class="mega-menu-col col-lg-4">
                                                                    <div class="header-banner2">
                                                                        <a href="javascript:void(0)"><img
                                                                                src="../public/img/banner/<?= $catRow['imagen'] ?>"
                                                                                alt="menu_banner"></a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                <?php } else {
                                                    $resSUb = $grupoCategoriaDao->getSubCat($catRow['id_seleccion']);

                                                ?>
                                                    <li class="dropdown dropdown-mega-menu">
                                                        <a class="dropdown-item nav-link dropdown-toggler" href="#"
                                                            data-toggle="dropdown"><img style="max-width: 28px;"
                                                                src="../public/iconos/<?= $catRow['icono'] ?>">
                                                            <span><?= $catRow['nombre'] ?></span></a>
                                                        <div class="dropdown-menu">
                                                            <ul class="mega-menu d-lg-flex">
                                                                <li class="mega-menu-col col-lg-7">
                                                                    <ul class="d-lg-flex">
                                                                        <li class="mega-menu-col col-lg-4">
                                                                            <ul>
                                                                                <li class="dropdown-header"></li>
                                                                                <?php
                                                                                foreach ($resSUb as $rowMar) { ?>
                                                                                    <li class=""> <strong><a class="dropdown-header"
                                                                                                href="shop-list-ctg.php?ctg=<?= $catRow['codi_categoria'] ?>&sub=<?= $rowMar['nombre'] ?>"><?= $rowMar['nombre'] ?></a></strong>
                                                                                    </li>
                                                                                <?php }
                                                                                ?>

                                                                            </ul>
                                                                        </li>
                                                                        <li class="mega-menu-col col-lg-7">
                                                                            <ul>
                                                                                <li class="dropdown-header">MARCAS</li>
                                                                                <?php
                                                                                foreach ($catRow['marcas'] as $rowMar) { ?>
                                                                                    <li><a class="dropdown-item nav-link nav_item"
                                                                                            href="shop-list-mrc.php?mrc=<?= $rowMar['marca'] ?>&grp=<?= $catRow['codi_categoria'] ?>"><?= $rowMar['nombre'] ?></a>
                                                                                    </li>
                                                                                <?php }
                                                                                ?>

                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="mega-menu-col col-lg-5">
                                                                    <div class="header-banner2">
                                                                        <a href="javascript:void(0)"><img
                                                                                src="../public/img/banner/<?= $catRow['imagen'] ?>"
                                                                                alt="menu_banner"></a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                <?php }
                                                ?>

                                    <?php
                                            } else {
                                                echo '<li><a class="dropdown-item nav-link nav_item" href="shop-list-ctg.php?ctg=' . $catRow['codi_categoria'] . '"><img style="max-width: 28px;" src="../public/iconos/' . $catRow['icono'] . '"> <span>' . $catRow['nombre'] . '</span></a></li>';
                                            }
                                        } else {


                                            $rowHTMLLISTECAt = $rowHTMLLISTECAt . '<li><a class="dropdown-item nav-link nav_item" href="shop-list-ctg.php?ctg=' . $catRow['codi_categoria'] . '"><img style="max-width: 28px;" src="../public/iconos/' . $catRow['icono'] . '"> <span>' . $catRow['nombre'] . '</span></a></li>';
                                        }
                                        $contador++;
                                    }
                                    ?>
                                    <li>
                                        <ul class="more_slide_open">
                                            <?= $rowHTMLLISTECAt ?>
                                        </ul>
                                    </li>
                                    <li class="ifmobile" style='background-color:red;'>
                                        <a class="dropdown-item" style="color:#fff;" href="#" data-toggle="collapse"
                                            data-target="#navCatContent" aria-expanded="false"><span class="fa fa-close"
                                                style="max-width: 20px; font-size: 20px;"></span> CERRAR</a>
                                    </li>

                                </ul>
                                <div class="more_categories">M&aacute;s categor&iacute;as</div>

                            </div>
                        </div>
                    </div>















                    <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                        <nav class="navbar navbar-expand-lg">
                            <button style="color: white;" class="navbar-toggler side_navbar_toggler" type="button"
                                data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false">
                                <span class="ion-android-menu"></span>
                            </button>
                            <!--<div class="pr_search_icon">
                                <a href="javascript:void(0);" style="color: white;" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                            </div>-->
                            <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                                <ul class="navbar-nav" <?= $body_class == 'desktop' ? ' style="background:#232323;" ' : ' style="background:#232323;"' ?>>

                                    <li class="dropdown dropdown-mega-menu nav-options-i">
                                        <a class="dropdown-toggle nav-link menu-var" href="#"
                                            data-toggle="dropdown">MARCAS</a>
                                        <div class="dropdown-menu">
                                            <ul class="mega-menu d-lg-flex">

                                                <?php
                                                $listaMar = [];
                                                $contadorMAc = 0;
                                                $listaTemp = [];
                                                foreach ($listaMarcas as $marc) {
                                                    $listaTemp[] = $marc;
                                                    if ($contadorMAc < 7) {
                                                        $listaMar[] = $listaTemp;
                                                        $listaTemp = [];
                                                        $contadorMAc = 0;
                                                    }
                                                    $contadorMAc++;
                                                }
                                                if (count($listaTemp) > 0) {
                                                    $listaMar[] = $listaTemp;
                                                    $listaTemp = [];
                                                }

                                                foreach ($listaMar as $itemMarc) {
                                                    echo '<li class="mega-menu-col col-lg-3">
                                                        <ul>';
                                                    foreach ($itemMarc as $tempMarcc) {

                                                        echo '<li><a class="dropdown-item nav-link nav_item"
                                                                   href="shop-list-prod-mac.php?marc=' . $tempMarcc['cod_marca'] . '">' . $tempMarcc['nombre_marca'] . '</a></li>';
                                                    }
                                                    echo '</ul>
                                                    </li>';
                                                } ?>
                                            </ul>
                                        </div>
                                    </li>

                                    <?php
                                    $_menuNav2 = $dataConf['menu_nav'] ?? [];
                                    foreach ($_menuNav2 as $_item2):
                                        if (($_item2['estado'] ?? '1') !== '1') continue;
                                    ?>
                                    <li class="nav-options-i">
                                        <a class="nav-link menu-var" href="<?= htmlspecialchars($_item2['url']) ?>"><?= htmlspecialchars($_item2['titulo']) ?></a>
                                    </li>
                                    <?php endforeach; ?>
                                    <li class="nav-options-i ifmobile">
                                        <a class="nav-link  menu-var" href="./banks.php">METODOS DE PAGO</a>
                                    </li>
                                    <li class="nav-options-i ifmobile">
                                        <a class="nav-link  menu-var" href="./delivery.php">ENVIOS A TODO EL PERU</a>
                                    </li>
                                    <li class="nav-options-i ifmobile">
                                        <a class="nav-link  menu-var" href="./office.php">DELIVERY A CAÑETE</a>
                                    </li>
                                    <li class="nav-options-i ifmobile" style="background-color:red;">
                                        <a class="nav-link  menu-var" style="color: white;" type="button"
                                            data-toggle="collapse" data-target="#navbarSidetoggle"
                                            aria-expanded="false">
                                            <span class="fa fa-close"></span> CERRAR
                                        </a>


                                    </li>



                                    <li class="nav-options-i">
                                        <span class="nav-link"
                                            style="color: #fff;font-size: 20px;padding-bottom: 7px;padding-top: 16px;">Tc:
                                            <?= $tc ?></span>
                                    </li>
                                </ul>
                            </div>
                        </nav>


                    </div>
                </div>
            </div>
        </div>
        <div class="nomobile" style="padding: 11px; width: 100%;overflow: hidden; background-color: #fff;">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-3">&nbsp; </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9" style="margin-left:30%;">
                    <a href="./banks.php"
                        style="text-align: center; margin: 0px; display: inline-block; padding: 0px 5px; margin-right: 20px; color:#c7161d;"><strong>
                            METODOS DE PAGO </strong></a>
                    <a href="#"
                        style="text-align: center; margin: 0px; color: #880107; display: inline-block; padding: 0px 5px; margin-right: 20px;"
                        class=""><strong> | </strong></a>
                    <a href="./delivery.php"
                        style="text-align: center; margin: 0px;  display: inline-block; padding: 0px 5px; margin-right: 20px; color:#c7161d;"><strong>
                            ENVIOS A TODO EL PERU </strong></a>
                    <a href="#"
                        style="text-align: center; margin: 0px; color: #880107; display: inline-block; padding: 0px 5px; margin-right: 20px; "
                        class=""><strong> | </strong></a>
                    <a href="./office.php"
                        style="text-align: center; margin: 0px; display: inline-block; padding: 0px 5px; margin-right: 20px; color:#c7161d;"><strong>
                            DELIVERY A CAÑETE </strong></a>
                </div>
            </div>
        </div>

    </header>
    <!-- END HEADER -->
    <style>
        @media only screen and (max-width: 600px) {
            .carousel-item {
                background-size: contain !important;
                background-repeat: no-repeat;
            }
        }

        /* Altura fija para tarjetas de Remate y Tendencia */
        #owl-productos-remate .product_img,
        #owl-productos-tendencia .product_img {
            height: 220px;
            overflow: hidden;
        }

        #owl-productos-remate .product_img img,
        #owl-productos-tendencia .product_img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            max-width: none !important;
            max-height: none !important;
        }
    </style>
    <!-- START SECTION BANNER -->
    <div class=" py-3 staggered-animation-wrap"
        style="background-image: url('../public/images/bgwine.webp');margin-top: -1px; background-size: cover; background-repeat: no-repeat;">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="banner_section shop_el_slider">
                        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow"
                            data-ride="carousel">
                            <div class="carousel-inner">

                                <?php
                                $countBan = 1;
                                $soloVisibles = [];
                                foreach ($dataConf['banner_pricipal'] as $rowBan) {

                                    if ($rowBan['estado'] == '1') {
                                        $soloVisibles[] = $rowBan;

                                        /*    echo "<pre>";
                                    var_dump($soloVisibles); */
                                        $dataExtraBann = '';
                                        if (strlen($rowBan['prod']) > 0) {

                                            $PrecioProdBan = 0;
                                            $sql = "SELECT
                                          id_ofer,
                                          producto_id,
                                          precio_oferta,
                                          cantidad,
                                          cantidad_stock,
                                          fecha_termino
                                        FROM ofertas_productos WHERE producto_id = " . $rowBan['prod'];
                                            if ($rowPRodBan = $conexion->query($sql)->fetch_assoc()) {
                                                $PrecioProdBan = $rowPRodBan['precio_oferta'];
                                            } else {
                                                $productoDao->setProdId($rowBan['prod']);
                                                $PrecioProdBan = $productoDao->getData()['precio'];
                                            }
                                        }

                                ?>

                                        <div class="carousel-item <?= ($countBan == 1) ? 'active' : '' ?>   background_bg"
                                            style="cursor: pointer;" onclick="location.href='<?= $rowBan['url'] ?>';"
                                            data-img-src="../public/img/banner/<?= $rowBan['imagen'] ?> " style="">
                                            <div class="banner_slide_content banner_content_inner">
                                                <div class="col-lg-7 col-10">

                                                </div>
                                            </div>
                                        </div>

                                <?php
                                        $countBan++;
                                    }
                                }

                                ?>



                            </div>

                            <ol class="carousel-indicators indicators_style3">
                                <?php
                                $countIDRFF = 0;
                                /*    echo "<pre>";
                                var_dump($soloVisibles); */

                                foreach ($soloVisibles as $rowBan) {

                                    if ($countIDRFF == 0) {
                                        echo '<li data-target="#carouselExampleControls" data-slide-to="' . $countIDRFF . '" class="active"></li>';
                                    } else {
                                        echo '<li data-target="#carouselExampleControls" data-slide-to="' . $countIDRFF . '" ></li>';
                                    }
                                ?>

                                <?php
                                    $countIDRFF++;
                                }

                                ?>
                            </ol>

                        </div>
                    </div>
                </div>
                <div class="col-lg-2 d-none d-lg-block">

                    <div class="shop_banner2 el_banner1">
                        <a href="<?= $ban1_ide ?>" class="hover_effect1" style="padding: 0px;">
                            <div class="">
                                <img src="../public/img/banner/<?= $ban1_url ?>" alt="shop_banner_img6">
                            </div>
                        </a>
                    </div>
                    <div class="shop_banner2 el_banner2">
                        <a href="<?= $ban2_ide ?>" class="hover_effect1" style="padding: 0px;">

                            <div class="">
                                <img src="../public/img/banner/<?= $ban2_url ?>" alt="shop_banner_img7">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BANNER -->

    <div class="main_content">
        <!-- START CATEGORY CARDS SECTION -->
        <div class="section pt-5 pb-5" style="background-color: #fdfaf7;">
            <div class="custom-container">
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <div class="heading_s1 mb-4">
                            <h2
                                style="font-family: 'Playfair Display', serif; color: #4a0404; font-size: 3rem; font-weight: 700; margin-bottom: 10px;">
                                Nuestra Selección</h2>
                            <p
                                style="font-style: italic; color: #8d6e63; font-size: 1.1rem; font-family: 'Poppins', sans-serif;">
                                Descubre las mejores cepas y etiquetas exclusivas</p>
                            <div style="width: 60px; height: 3px; background: #c7161d; margin: 20px auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4" id="gridNuestraSeleccion">
                    <!-- Cargado via JS para no bloquear la página -->
                </div>
            </div>
        </div>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap');

            .wine-cat-card-wrapper {
                text-decoration: none !important;
                display: block;
            }

            .wine-card {
                border-radius: 20px;
                overflow: hidden;
                position: relative;
                transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                background: #fff;
            }

            .wine-img-container {
                position: relative;
                height: 320px;
                overflow: hidden;
            }

            .wine-img-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.6s ease;
            }

            .wine-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(180deg, rgba(74, 4, 4, 0) 40%, rgba(74, 4, 4, 0.8) 100%);
                opacity: 0.8;
                transition: opacity 0.3s ease;
            }

            .wine-cat-label {
                position: absolute;
                bottom: 25px;
                left: 20px;
                right: 20px;
                color: #fff;
                z-index: 2;
                text-align: center;
            }

            .wine-cat-label h4 {
                font-family: 'Playfair Display', serif;
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 5px;
                color: #fff;
            }

            .wine-cat-label p {
                font-size: 0.75rem;
                letter-spacing: 2px;
                opacity: 0;
                transform: translateY(10px);
                transition: all 0.3s ease;
                color: #fff;
            }

            /* Hover states */
            .wine-cat-card-wrapper:hover .wine-card {
                transform: translateY(-8px);
                box-shadow: 0 15px 30px rgba(74, 4, 4, 0.2) !important;
            }

            .wine-cat-card-wrapper:hover .wine-img-container img {
                transform: scale(1.1);
            }

            .wine-cat-card-wrapper:hover .wine-overlay {
                opacity: 1;
                background: linear-gradient(180deg, rgba(74, 4, 4, 0.2) 0%, rgba(74, 4, 4, 0.9) 100%);
            }

            .wine-cat-card-wrapper:hover .wine-cat-label p {
                opacity: 1;
                transform: translateY(0);
            }

            .wine-cat-card-wrapper:hover .wine-cat-label h4 {
                color: #f3e5ab;
                /* Gold accent */
            }
        </style>
        <!-- END CATEGORY CARDS SECTION -->

        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-0">
            <div class="custom-container">
                <div class="row">
                    <div class="col-xl-3 d-none d-xl-none">
                        <div class="sale-banner">
                            <?php $usarBanner6 = $dataConf['banner_menu_lateral_6'];
                            $cantidadIndex = count($usarBanner6);
                            /* echo "<pre>"; */
                            $randonIndex = rand(0, $cantidadIndex - 1);

                            /*  var_dump($usarBanner6[$randonIndex]);
                            die(); */ ?>
                            <a class="hover_effect1" href="<?= $banner6Final['url'] ?>">
                                <img src="../public/img/banner/<?= $banner6Final['imagen'] ?>" alt="shop_banner_img6">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading_tab_header">
                                    <div class="heading_s2">
                                        <h4><img src="../public/wineicon.png" class="iconotitulo">Productos Exclusivos
                                        </h4>
                                    </div>
                                    <div class="tab-style2">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                            data-target="#tabmenubar" aria-expanded="false">
                                            <span class="ion-android-menu"></span>
                                        </button>
                                        <ul class="nav nav-tabs justify-content-center justify-content-md-end"
                                            id="tabmenubar" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="arrival-tab" data-toggle="tab"
                                                    href="#arrival" role="tab" aria-controls="arrival"
                                                    aria-selected="true">Nuevos Ingresos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="sellers-tab" data-toggle="tab" href="#sellers"
                                                    role="tab" aria-controls="sellers" aria-selected="false">Los mas
                                                    Vendido</a>
                                            </li>
                                            <!--  <li hidden class="nav-item">
                                                <a class="nav-link" id="featured-tab" data-toggle="tab" href="#featured__" role="tab" aria-controls="featured" aria-selected="false">Ofertas Especiales</a>
                                            </li> -->
                                            <li class="nav-item">
                                                <a class="nav-link" id="special-tab" data-toggle="tab" href="#special"
                                                    role="tab" aria-controls="special" aria-selected="false">Ofertas
                                                    Especiales</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="tab_slider">
                                    <div class="tab-pane fade show active" id="arrival" role="tabpanel"
                                        aria-labelledby="arrival-tab">
                                        <div class="product_slider owl-carousel owl-theme dot_style1"
                                            id="owl-nuevos-ingresos"
                                            data-loop="true" data-margin="20"
                                            data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                                        </div>
                                    </div>
                                    <?php /* LEGACY PHP LOOP — reemplazado por AJAX/API */ if(false) { foreach ($listaNue as $proN) { ?>
                                                //var_dump($proN);
                                                //die();
                                                if (!is_null($proN['precio_ofertaa'])) {
                                                    $ahorro = $proN['precio'] - $proN['precio_ofertaa'];
                                                    $precioProd = number_format($proN['precio'], 2, '.', ',');
                                                    $ahorro = number_format($ahorro, 2, '.', ',');
                                                    $precioCambio = number_format(1 * $proN['precio_ofertaa'], 2, '.', ',');
                                                    $ahorroSol = 1 * $ahorro;
                                                    $precioProdSol = number_format(1 * floatval($precioProd), 2, '.', ',');
                                                    $ahorroSol = number_format(1 * $ahorro, 2, '.', ',');
                                                    $ahorroSol = number_format(floatval(0), 2);
                                                } else {
                                                    if ($proN['tipo_pro'] == 2) {
                                                        $precioProd = number_format($proN['precio_prod'], 2, '.', ',');
                                                        $precioCambio = number_format(1 * $proN['precio_prod'], 2, '.', ',');
                                                    } else {
                                                        $precioProd = number_format($proN['precio'], 2, '.', ',');
                                                        $precioCambio = number_format(1 * $proN['precio'], 2, '.', ',');
                                                    }
                                                }

                                            ?>
                                                <?php if (($proN['stock'] !== '0.000' || $proN['stock_prod'] !== '0') && $proN['estado'] == '1'): ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <?php


                                                            ?>

                                                            <div class="product_img">
                                                                <?php
                                                                $url_detalle = '';
                                                                if ($proN['tipo_pro'] == 2) {
                                                                    $url_detalle = 'shop-product-detail-remate.php?prod=' . $proN['prod_id'];
                                                                } else {
                                                                    $url_detalle = 'shop-product-detail.php?prod=' . $proN['prod_id'];
                                                                }
                                                                ?>
                                                                <a href="<?= $url_detalle ?>">
                                                                    <img style="max-width: 540px; max-height: 600px;"
                                                                        src="../public/img/productos/<?= $proN['imagen1'] ?>"
                                                                        alt="el_img3">
                                                                    <img style="max-width: 540px; max-height: 600px;"
                                                                        class="product_hover_img"
                                                                        src="../public/img/productos/<?= $proN['imagen2'] ?>"
                                                                        alt="el_hover_img3">
                                                                    <!--img style="max-width: 540px; max-height: 600px;" src="../public/images/Exclusivos/c_i7.jpg" alt="el_img3">
                                                        <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/images/Exclusivos/c_i72.jpg" alt="el_hover_img3"-->
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li <?= $proN['tipo_pro'] == 2 ? 'hidden' : '' ?>
                                                                            class="add-to-cart"><a
                                                                                onclick="CARRITO.espe_prod_carr(<?= $proN['prod_id'] ?>)"
                                                                                href="javascript:void(0)"><i
                                                                                    class="icon-basket-loaded"></i> A�adir al
                                                                                carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $proN['prod_id'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $proN['prod_id'] ?>&stok=<?= $proN['stock_prod'] + $proN['stock'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i
                                                                                    class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>>
                                                                    <a style="white-space: normal"
                                                                        href="<?= $url_detalle ?>"><?= $proN['nombre'] ?></a>
                                                                </h6>
                                                                <?php if (!is_null($proN['precio_ofertaa'])): ?>
                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <!--<span class="price">$<?= $proN['precio_ofertaa'] ?></span>
                                                                        <del>$<?= $precioProd ?></del>
                                                                        <div class="on_sale">
                                                                            <span>Ahorre $<?= $ahorro ?></span>
                                                                        </div>
                                                                        <br>
                                                                        <span class="price">S/. <?= $precioCambio ?></span>-->

                                                                        <span><strong> S/.
                                                                                <?php echo $precioProdSol; ?></strong></span>
                                                                    </div>

                                                                <?php else: ?>

                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <!--<span class="price">$<?= $precioProd ?></span>-->
                                                                        <span> <strong>S/.
                                                                                <?php echo $precioCambio; ?></strong></span>
                                                                        <!--div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                                    </div>
                                                                <?php endif; ?>

                                                                <div class="rating_wrap">
                                                                    <!--div class="rating">
                                                            <div class="product_rate" style="width:87%"></div>
                                                        </div-->
                                                                    <span class="rating_num"><strong>Stock: <a
                                                                                href="javascript:void(0)"><?php
                                                                                                            if ($proN['stock_prod'] == 0) {
                                                                                                                if ($proN['stock'] == 0) {
                                                                                                                    echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                } elseif ($proN['stock'] > 10) {
                                                                                                                    echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                } else {
                                                                                                                    echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($proN['stock'], 0, '.', ',') . " en Stock</span>";
                                                                                                                }
                                                                                                            } else {
                                                                                                                if ($proN['stock_prod'] == 0) {
                                                                                                                    echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                } elseif ($proN['stock_prod'] > 10) {
                                                                                                                    echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                } else {
                                                                                                                    echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($proN['stock_prod'], 0, '.', ',') . " en Stock</span>";
                                                                                                                }
                                                                                                            }

                                                                                                            ?></a></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="pr_desc">
                                                                    <p></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif;
                                                ?>
                                            <?php } } ?>
                                    <div class="tab-pane fade" id="sellers" role="tabpanel"
                                        aria-labelledby="sellers-tab">
                                        <div class="product_slider owl-carousel owl-theme dot_style1"
                                            id="owl-mas-vendidos"
                                            data-loop="true" data-margin="20"
                                            data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                                        </div>
                                    </div>
                                    <?php /* LEGACY MAS VENDIDOS */ if(false) { foreach ($listaRamMasVen as $itemMV) { ?>
                                                if ((!is_null($itemMV['precio_ofertaa']))) {
                                                    $ahorro = $itemMV['precio'] - $itemMV['precio_ofertaa'];
                                                    $precioProd = number_format($itemMV['precio'], 2, '.', ',');
                                                    $ahorro = number_format($ahorro, 2, '.', ',');
                                                    $precioCambio = number_format(1 * $itemMV['precio_ofertaa'], 2, '.', ',');
                                                    $ahorroSol = 1 * $ahorro;
                                                    $precioProdSol = number_format(1 * $precioProd, 2, '.', ',');
                                                    $ahorroSol = number_format(1 * $ahorro, 2, '.', ',');
                                                    $ahorroSol = number_format(floatval(0), 2);
                                                } else {
                                                    $precioProd = number_format($itemMV['precio'], 2, '.', ',');
                                                    $precioCambio = number_format(1 * $itemMV['precio'], 2, '.', ',');
                                                }
                                            ?>
                                                <?php if ($itemMV['stock'] !== '0.000' && $itemMV['estado'] !== '0'): ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <div class="product_img">
                                                                <a
                                                                    href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>">
                                                                    <img src="../public/img/productos/<?= $itemMV['imagen1'] ?>"
                                                                        alt="el_img7">
                                                                    <img class="product_hover_img"
                                                                        src="../public/img/productos/<?= $itemMV['imagen2'] ?>"
                                                                        alt="el_hover_img7">
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li class="add-to-cart"><a
                                                                                onclick="CARRITO.espe_prod_carr(<?= $itemMV['prod_id'] ?>)"
                                                                                href="javascript:void(0)"><i
                                                                                    class="icon-basket-loaded"></i> A�adir al
                                                                                carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $itemMV['prod_id'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $itemMV['prod_id'] ?>&stok=<?= $itemMV['stock'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i
                                                                                    class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a
                                                                        style="white-space: normal"
                                                                        href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>"><?= $itemMV['nombre'] ?></a>
                                                                </h6>
                                                                <?php if ((!is_null($itemMV['precio_ofertaa']))): ?>
                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <span class="price">$<?= $itemMV['precio_ofertaa'] ?></span>
                                                                        <del>$<?= $precioProd ?></del>
                                                                        <div class="on_sale">
                                                                            <span>Ahorre $<?= $ahorro ?></span>
                                                                        </div>
                                                                        <br>
                                                                        <!--<span class="price">S/. <?= $precioCambio ?></span>-->
                                                                        <del><span> S/. <?php echo $precioProdSol; ?></span></del>
                                                                    </div>

                                                                <?php else: ?>
                                                                    <div class="product_price">
                                                                        <!--<span class="price">$<?= $precioProd ?></span>-->
                                                                        <span> <strong>S/.
                                                                                <?php echo $precioCambio; ?></strong></span>
                                                                        <!--div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="rating_wrap">

                                                                    <span class="rating_num"><strong>Stock: <a
                                                                                href="javascript:void(0)"><?php
                                                                                                            if ($itemMV['stock'] == 0) {
                                                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                            } elseif ($itemMV['stock'] > 10) {
                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                            } else {
                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($itemMV['stock'], 0, '.', ',') . " en Stock</span>";
                                                                                                            }
                                                                                                            ?></a></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="pr_desc">
                                                                    <p></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php } } ?>
                                    <div class="tab-pane fade" id="featured__" role="tabpanel"
                                        aria-labelledby="sellers-tab">
                                    </div>
                                    <div class="tab-pane fade" id="special" role="tabpanel"
                                        aria-labelledby="special-tab">
                                        <div class="product_slider owl-carousel owl-theme dot_style1"
                                            id="owl-ofertas-especiales"
                                            data-loop="true" data-margin="20"
                                            data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                                        </div>
                                    </div>
                                    <?php /* LEGACY OFERTAS */ if(false) { foreach ($listaOfertas as $proN) { ?>
                                                $ahorro = $proN['precio'] - $proN['precio_oferta'];
                                                $precioProd = number_format($proN['precio'], 2, '.', ',');
                                                $ahorro = number_format($ahorro, 2, '.', ',');
                                                $precioCambio = number_format(1 * $proN['precio_oferta'], 2, '.', ',');
                                                $ahorroSol = 1 * $ahorro;
                                                $precioProdSol = number_format(1 * floatval($precioProd), 2, '.', ',');
                                                $ahorroSol = number_format(1 * $ahorro, 2, '.', ',');
                                                $ahorroSol = number_format(floatval(0), 2);
                                                /* var_dump($ahorro); */

                                                //$stockTEM = $ofeItem['cantidad'] - 2;
                                                // $progreso =  ($stockTEM * 100)/$ofeItem['cantidad'];
                                                //$progreso = number_format($progreso, 0, '', '');
                                            ?>
                                                <?php if ($proN['stock'] !== '0.000' && $proN['estado'] == '1'): ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <?php

                                                            ?>

                                                            <div class="product_img">
                                                                <a href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>">
                                                                    <img style="max-width: 540px; max-height: 600px;"
                                                                        src="../public/img/productos/<?= $proN['imagen1'] ?>"
                                                                        alt="el_img3">
                                                                    <img style="max-width: 540px; max-height: 600px;"
                                                                        class="product_hover_img"
                                                                        src="../public/img/productos/<?= $proN['imagen2'] ?>"
                                                                        alt="el_hover_img3">
                                                                    <!--img style="max-width: 540px; max-height: 600px;" src="../public/images/Exclusivos/c_i7.jpg" alt="el_img3">
                                                        <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/images/Exclusivos/c_i72.jpg" alt="el_hover_img3"-->
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li class="add-to-cart"><a
                                                                                onclick="CARRITO.espe_prod_carr(<?= $proN['prod_id'] ?>)"
                                                                                href="javascript:void(0)"><i
                                                                                    class="icon-basket-loaded"></i> A�adir al
                                                                                carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $proN['prod_id'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $proN['prod_id'] ?>&stok=<?= $proN['stock'] ?>"
                                                                                class="popup-ajax"><i
                                                                                    class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i
                                                                                    class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a
                                                                        style="white-space: normal"
                                                                        href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>"><?= $proN['nombre'] ?></a>
                                                                </h6>
                                                                <!--<div style="font-size: 13px;" class="product_price">
                                                                    <span class="price">$<?= $proN['precio_oferta'] ?></span>
                                                                    <del>$<?= $precioProd ?></del>
                                                                    <div class="on_sale">
                                                                        <span>Ahorre $<?= $ahorro ?></span>
                                                                    </div>
                                                                </div>-->
                                                                <div style="font-size: 13px;" class="product_price">
                                                                    <span class="price">S/. <?= $precioCambio ?></span>
                                                                    <del>S/. <?= $precioProdSol ?></del>

                                                                </div>
                                                                <div class="rating_wrap">

                                                                    <span class="rating_num"><strong>Stock: <a
                                                                                href="javascript:void(0)"><?php
                                                                                                            if ($proN['stock'] == 0) {
                                                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                            } elseif ($proN['stock'] > 10) {
                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                            } else {
                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($proN['stock'], 0, '.', ',') . " en Stock</span>";
                                                                                                            }
                                                                                                            ?></a></strong></span>
                                                                </div>
                                                                <div class="pr_desc">
                                                                    <p></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->

        <!-- START SECTION BANNER -->
        <div class="section pb_20 small_pt">
            <div class="custom-container">
                <div class="row">
                    <?php foreach ($arrayInferioFinal as $row): ?>
                        <div class="col-md-4">
                            <div class="sale-banner mb-3 mb-md-4">
                                <a class="hover_effect1" href="<?= $row['url'] ?>">
                                    <img src="../public/img/banner/<?= $row['imagen'] ?>" alt="shop_banner_img7">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- END SECTION BANNER -->

        <!-- START SECTION SHOP -->
        <div class="section pt-0 pb-0">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4><img src="../public/wineicon.png" class="iconotitulo">Descripcion de producto</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style3" data-loop="false"
                            data-dots="false" data-nav="true" data-margin="30"
                            data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
                            <?php
                            foreach ($listaOfertas as $key => $ofeItem) {

                                $precioFormat = number_format($ofeItem['precio'], 2, '.', ',');
                                $stockTEM = $ofeItem['cantidad'] == 0 ? $ofeItem['cantidad'] : $ofeItem['cantidad'] - 2;
                                $progreso = $stockTEM == 0 ? 0 : ($stockTEM * 100) / $ofeItem['cantidad'];
                                $progreso = number_format($progreso, 0, '', '');

                                $precioCambio = number_format(1 * $ofeItem['precio_oferta'], 2, '.', ',');

                                $precioProdSol = number_format(1 * $ofeItem['precio'], 2, '.', ',');

                            ?>
                                <?php if ($ofeItem['stock'] > 0): ?>

                                    <div class="item">

                                        <div class="deal_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php?prod=<?= $ofeItem['prod_id'] ?>">
                                                    <img src="../public/img/productos/<?php echo $ofeItem['imagen1'] ?>"
                                                        alt="el_img1">
                                                </a>
                                            </div>
                                            <div class="deal_content">
                                                <div class="product_info">
                                                    <h5 class="product_title"><a
                                                            href="shop-product-detail.php?prod=<?= $ofeItem['prod_id'] ?>"><?= $ofeItem['nombre'] ?></a>
                                                    </h5>
                                                    <!--<div class="product_price">
                                                        <span class="price">$<?= $ofeItem['precio_oferta'] ?></span>
                                                        <del>$<?= $precioFormat ?></del>
                                                    </div>-->
                                                    <div class="product_price">
                                                        <span class="price">S/. <?= $precioCambio ?></span>
                                                        <del>S/. <?= $precioProdSol ?></del>
                                                    </div>
                                                </div>
                                                <div class="deal_progress">
                                                    <span class="stock-sold">

                                                        <strong>Stock: <a href="javascript:void(0)"><?php

                                                                                                    $stock = substr($ofeItem['stock'], 0, -4);;
                                                                                                    if ($ofeItem['stock'] >= 10) {
                                                                                                        echo "<span style='font-weight: lighter;color: black'>+ 10</span>";
                                                                                                    } elseif ($ofeItem['stock'] > 0 && $ofeItem['stock'] < 10) {
                                                                                                        echo "<span style='font-weight: lighter;color: black'>{$stock} </span>";
                                                                                                    }
                                                                                                    ?></a></strong>

                                                    </span>
                                                    <!--span class="stock-available">Disponible: <strong><?= $ofeItem['cantidad'] - $stockTEM ?></strong></span-->
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar"
                                                            aria-valuenow="<?= $progreso ?>" aria-valuemin="0"
                                                            aria-valuemax="100" style="width:<?= $progreso ?>%">
                                                            <?= $progreso ?>%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="countdown_time countdown_style4 mb-4 "
                                                    data-time="<?= $ofeItem['fecha_termino'] ?> 12:00:00"></div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endif; ?>
                            <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br />
        <!-- END SECTION SHOP -->
        <?php
        $tradicion = $dataConf['seccion_tradicion'] ?? ['imagen' => '', 'titulo' => 'Expertos en Vino'];
        $tradicionBg = !empty($tradicion['imagen'])
            ? 'background-image: url(\'../public/img/banner/' . htmlspecialchars($tradicion['imagen']) . '\');'
            : '';
        ?>
        <div class="section tradicion" id="parallax-tradicion"
             style="padding-bottom: 90px;padding-top: 90px;<?= $tradicionBg ?>">
            <div class="custom-container">
                <div class="row align-items-center">
                    <div class="col-md-6" style=" margin: auto;">
                        <div class="text_white text-center">
                            <img src="../public/wgicon.png" style="width: 100px; filter: brightness(0) invert();" /><br>
                            <span style="font-size: 14px;">TRADICIÓN</span><br>
                            <span style="font-size: 43px;font-weight: bold; color:<?= htmlspecialchars($tradicion['color'] ?? '#ffffff') ?>;"><?= htmlspecialchars($tradicion['titulo']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section small_pt small_pb">
            <div class="custom-container">
                <div class="row">

                    <div class="col-xl-3 d-none d-xl-block">

                        <div class="sale-banner">
                            <a class="hover_effect1" href="<?= $banner55FinalExtra['url'] ?>">
                                <img src="../public/img/banner/<?= $banner55FinalExtra['imagen'] ?>"
                                    alt="shop_banner_img10">
                            </a>
                        </div>

                    </div>

                    <div class="col-xl-9">
                        <div class="col-12">
                            <div class="heading_tab_header">
                                <div class="heading_s2">
                                    <h4><img src="../public/wineicon.png" class="iconotitulo">Productos En Remate</h4>
                                </div>
                                <div class="view_all">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="owl-productos-remate" class="product_slider carousel_slider owl-carousel owl-theme dot_style1"
                                    data-loop="true" data-margin="20"
                                    data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                    <?php if(false) { $rematesProcesados = [];
                                    foreach ($listaRmaRema as $remate) {
                                        if (in_array($remate['prod_id'], $rematesProcesados)) { continue; }
                                        $rematesProcesados[] = $remate['prod_id'];
                                        if (isset($remate['precio_ofertaa']) && !is_null($remate['precio_ofertaa'])) {
                                            $ahorro = $remate['precio'] - $remate['precio_ofertaa'];
                                            $precioProd = number_format($remate['precio'], 2, '.', ',');
                                            $ahorro = number_format($ahorro, 2, '.', ',');
                                            $precioCambio = number_format(1 * $remate['precio_ofertaa'], 2, '.', ',');
                                            $ahorroSol = 1 * $ahorro;
                                            $precioProdNumerico = floatval(str_replace(',', '', $precioProd));
                                            $precioProdSol = is_numeric($precioProdNumerico) ? number_format(1 * $precioProdNumerico, 2, '.', ',') : '0.2';
                                            $ahorroSol = number_format(1 * $ahorro, 2, '.', ',');
                                            $ahorroSol = number_format(floatval(0), 2);
                                        } else {
                                            if ($remate['tipo_pro'] == 2) {
                                                $precioProd = number_format($remate['precio_prod'], 2, '.', ',');
                                                $precioCambio = number_format(1 * $remate['precio_prod'], 2, '.', ',');
                                            } else {
                                                $precioProd = number_format($remate['precio'], 2, '.', ',');
                                                $precioCambio = number_format(1 * $remate['precio'], 2, '.', ',');
                                            }
                                        }
                                    ?>
                                        <?php if (($remate['stock'] !== '0.000' || $remate['stock_prod'] !== '0') && $remate['estado'] == '1'): ?>
                                            <div class="item">
                                                <div class="product_wrap">
                                                    <div class="product_img">
                                                        <?php
                                                        $url_detalle = '';
                                                        if ($remate['tipo_pro'] == 2) {
                                                            $url_detalle = 'shop-product-detail-remate.php?prod=' . $remate['prod_id'];
                                                        } else {
                                                            $url_detalle = 'shop-product-detail.php?prod=' . $remate['prod_id'];
                                                        }
                                                        ?>
                                                        <a href="<?= $url_detalle ?>">
                                                            <img src="../public/img/productos/<?= $remate['imagen1'] ?>"
                                                                alt="el_img3">
                                                            <img class="product_hover_img"
                                                                src="../public/img/productos/<?= $remate['imagen2'] ?>"
                                                                alt="el_hover_img3">
                                                        </a>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li <?= $remate['tipo_pro'] == 2 ? 'hidden' : '' ?>
                                                                    class="add-to-cart">
                                                                    <a onclick="CARRITO.espe_prod_carr(<?= $remate['prod_id'] ?>)"
                                                                        href="javascript:void(0)">
                                                                        <i class="icon-basket-loaded"></i> Añadir al carrito
                                                                    </a>
                                                                </li>
                                                                <li><a href="shop-compare.php?prod=<?= $remate['prod_id'] ?>"
                                                                        class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                                <li><a href="shop-quick-view.php?prod=<?= $remate['prod_id'] ?>"
                                                                        class="popup-ajax"><i
                                                                            class="icon-magnifier-add"></i></a></li>
                                                                <li><a href="javascript:void(0)"><i class="icon-heart"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>>
                                                            <a style="white-space: normal"
                                                                href="<?= $url_detalle ?>"><?= $remate['nombre'] ?></a>
                                                        </h6>
                                                        <?php if (!is_null($remate['precio_ofertaa'])): ?>
                                                            <div style="font-size: 13px;" class="product_price">
                                                                <br>
                                                                <span class="price">S/. <?= $precioCambio ?></span>
                                                                <del><span>S/. <?php echo $precioProdSol; ?></span></del>
                                                            </div>
                                                        <?php else: ?>
                                                            <div style="font-size: 13px;" class="product_price">
                                                                <span><strong>S/. <?php echo $precioCambio; ?></strong></span>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="rating_wrap">
                                                            <span class="rating_num"><strong>Stock: <a
                                                                        href="javascript:void(0)">
                                                                        <?php
                                                                        if ($remate['stock_prod'] == 0) {
                                                                            if ($remate['stock'] == 0) {
                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                            } elseif ($remate['stock'] > 10) {
                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                            } else {
                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($remate['stock'], 0, '.', ',') . " en Stock</span>";
                                                                            }
                                                                        } else {
                                                                            if ($remate['stock_prod'] == 0) {
                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                            } elseif ($remate['stock_prod'] > 10) {
                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                            } else {
                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>" . number_format($remate['stock_prod'], 0, '.', ',') . " en Stock</span>";
                                                                            }
                                                                        }
                                                                        ?></a></strong></span>
                                                        </div>
                                                        <div class="pr_desc">
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php } } ?>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!-- START SECTION SHOP -->
        <div class="section small_pt small_pb">
            <div class="custom-container">
                <div class="row">

                    <div class="col-xl-3 d-none d-xl-block">

                        <div class="sale-banner">
                            <a class="hover_effect1" href="<?= $banner6FinalExtra['url'] ?>">
                                <img src="../public/img/banner/<?= $banner6FinalExtra['imagen'] ?>"
                                    alt="shop_banner_img10">
                            </a>
                        </div>

                    </div>

                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading_tab_header">
                                    <div class="heading_s2">
                                        <h4><img src="../public/wineicon.png" class="iconotitulo">Productos de Tendencia
                                        </h4>
                                    </div>
                                    <div class="view_all">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="owl-productos-tendencia" class="product_slider carousel_slider owl-carousel owl-theme dot_style1"
                                    data-loop="true" data-margin="20"
                                    data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->



        <!-- START SECTION SHOP -->
        <div class="section pt-0 pb_20">
            <div class="custom-container">
                <div class="row">

                    <!-- Columna 1: Productos Destacados -->
                    <div class="col-lg-4">
                        <div class="heading_tab_header mb-3">
                            <div class="heading_s2"><h4>Productos Destacados</h4></div>
                            <div class="view_all">
                                <a href="./shop-list-prod.php?search=+" class="text_default"><span>Ver todo</span></a>
                            </div>
                        </div>
                        <div id="owl-productos-destacados"
                            class="owl-carousel owl-theme"
                            data-loop="true" data-autoplay="true" data-margin="0" data-nav="true" data-dots="false">
                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                        </div>
                    </div>

                    <!-- Columna 2: Productos Mejor Valorados -->
                    <div class="col-lg-4">
                        <div class="heading_tab_header mb-3">
                            <div class="heading_s2"><h4>Productos Mejor Valorados</h4></div>
                            <div class="view_all">
                                <a href="./shop-list-prod.php?search=+" class="text_default"><span>Ver todo</span></a>
                            </div>
                        </div>
                        <div id="owl-mejor-valorados"
                            class="owl-carousel owl-theme"
                            data-loop="true" data-autoplay="true" data-margin="0" data-nav="true" data-dots="false">
                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                        </div>
                    </div>

                    <!-- Columna 3: Productos En Oferta -->
                    <div class="col-lg-4">
                        <div class="heading_tab_header mb-3">
                            <div class="heading_s2"><h4>Productos En Oferta</h4></div>
                            <div class="view_all">
                                <a href="./shop-list-prod-ofertas.php" class="text_default"><span>Ver Todo</span></a>
                            </div>
                        </div>
                        <div id="owl-ofertas-vigentes"
                            class="owl-carousel owl-theme"
                            data-loop="true" data-autoplay="true" data-margin="0" data-nav="true" data-dots="false">
                            <div class="item"><div class="text-center py-4"><div class="spinner-border text-danger"></div></div></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
        <!-- START SECTION CLIENT LOGO -->
        <div class="section pt-0 small_pb">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>Nuestras Marcas</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="client_logo carousel_slider owl-carousel owl-theme nav_style3" data-dots="false"
                            data-nav="true" data-margin="30" data-loop="true" data-autoplay="true"
                            data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}, "1199":{"items": "6"}}'>
                            <?php
                            foreach ($listaMarcas as $rowMarc) {
                                if (strlen($rowMarc['imagen']) > 0) {
                            ?>
                                    <div class="item">
                                        <div class="cl_logo">
                                            <a href="shop-list-prod-mac.php?marc=<?= $rowMarc['cod_marca'] ?>"><img
                                                    src="../public/img/marcas/<?= $rowMarc['imagen'] ?>" alt="cl_logo" /></a>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION CLIENT LOGO -->

        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb" style="background-color:#880107 !important; position:relative;">
            <?php
            $suscImg = $dataConf['suscripcion_imagen'] ?? '';
            if (!empty($suscImg) && !str_starts_with($suscImg, 'http')) $suscImg = '../public/img/banner/' . $suscImg;
            if (empty($suscImg)) $suscImg = '../public/images/wine.png';
            ?>
            <img src="<?= htmlspecialchars($suscImg) ?>" alt="bg_newsletter" class="d-none d-lg-block" style="position:absolute; left:0; top:50%; transform:translateY(-50%); height:100%; width:auto; max-height:160px;">
            <div class="custom-container" style="padding-left:130px;">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="newsletter_text text_white">
                            <h3><?= htmlspecialchars($dataConf['suscripcion_titulo'] ?? 'Somos VIÑASANTODOMINGO los mejores en VINOS Y PISCO') ?></h3>
                            <p><?= htmlspecialchars($dataConf['suscripcion_parrafo'] ?? 'Recibe las mejores Ofertas en Vino y Pisco SUSCRÍBETE') ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter_form2 rounded_input">
                            <form id="formPromociones">
                                <input type="email" required name="emailRegistrar" id="emailRegistrar"
                                    class="form-control" placeholder="Ingresa tu Email">
                                <button type="button" class="btn btn-dark btn-radius"
                                    style="background-color:#232323!important;"
                                    id="btnRegistrar">Suscr&iacute;bete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- START SECTION SUBSCRIBE NEWSLETTER -->

    </div>
    <!-- END MAIN CONTENT -->

    <!-- START FOOTER -->
    <footer class="footer_dark">
        <div class="footer_top small_pt pb_20">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="widget">
                            <div class="footer_logo">
                                <?php $fLogo = !empty($dataConf['footer_logo']) ? (str_starts_with($dataConf['footer_logo'],'http') ? $dataConf['footer_logo'] : '../public/img/banner/'.$dataConf['footer_logo']) : '../public/logo.svg'; ?>
                                <a href="./"><img src="<?= $fLogo ?>" alt="logo" style="width: 280px;" /></a>
                            </div>
                            <p class="mb-3"><?= htmlspecialchars($dataConf['footer_tagline'] ?? 'Los mejores en Vino y Pisco') ?></p>
                            <ul class="contact_info">
                                <li>
                                    <i class="ti-location-pin"></i>
                                    <p><?= $dataConf['direccion'] ?></p>
                                </li>
                                <li>
                                    <i class="ti-email"></i>
                                    <a href="<?= $dataConf['email'] ?>"><?= $dataConf['email'] ?></a>
                                </li>
                                <?php
                                foreach ($dataConf['telefonos'] as $telf) {
                                    echo '<li>
                                <i class="ti-mobile"></i>
                                <p>' . $telf['numero'] . '</p>
                            </li>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">Empresa</h6>
                            <ul class="widget_links">
                                <li><a href="about.php">Nosotros</a></li>
                                <li><a href="contact.php">Contactanos</a></li>
                                <li><a href="term.php">Terminos y Condiciones</a></li>
                                <li>
                                    <a href="../public/librorec/libro.php" target="_blank">
                                        <img src="../public/librorec/libro2.png" style="filter: brightness(0) invert();"
                                            alt="libro reclamaciones"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">Productos</h6>
                            <ul class="widget_links">
                                <?php foreach ($dataConf['footer_productos'] ?? [] as $fp): ?>
                                <li><a href="./<?= htmlspecialchars($fp['url']) ?>"><?= htmlspecialchars($fp['nombre']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="widget">
                            <?php $fImg = $dataConf['footer_imagen'] ?? ''; if (!empty($fImg) && !str_starts_with($fImg,'http')) $fImg = '../public/img/banner/'.$fImg; ?>
                            <?php if (!empty($fImg)): ?><img src="<?= htmlspecialchars($fImg) ?>" class="img-fluid"><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="middle_footer">
            <div class="custom-container">
                <div class="row">
                    <div class="col-12">
                        <div class="shopping_info">
                            <div class="row justify-content-center">
                                <?php
                                $icons = ['flaticon-shipped','flaticon-money-back','flaticon-support'];
                                foreach (($dataConf['footer_servicios'] ?? []) as $k => $srv):
                                $icon = $icons[$k] ?? 'flaticon-support';
                                ?>
                                <div class="col-md-4">
                                    <div class="icon_box icon_box_style2">
                                        <div class="icon"><i class="<?= $icon ?>"></i></div>
                                        <div class="icon_box_content">
                                            <h5><?= htmlspecialchars($srv['titulo']) ?></h5>
                                            <p><?= htmlspecialchars($srv['descripcion']) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4">
                        <p class="mb-lg-0 text-center">&copy; <?= date('Y') ?> Todos los derechos reservados por <a
                                target="_blank" href="https://magustechnologies.com/"><strong>MAGUS
                                    TECHNOLOGIES</strong></a> </p>
                    </div>
                    <div class="col-lg-4 order-lg-first">
                        <div class="widget mb-lg-0">
                            <ul class="social_icons text-center text-lg-left">

                                <li><a href="<?= $dataConf['redessociales']['facebook'] ?>" class="sc_facebook"><i
                                            class="ion-social-facebook"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['twitter'] ?>" class="sc_twitter"><i
                                            class="ion-social-twitter"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['google_plus'] ?>" class="sc_google"><i
                                            class="ion-social-googleplus"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['youtube'] ?>" class="sc_youtube"><i
                                            class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['instagram'] ?>" class="sc_instagram"><i
                                            class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ul class="footer_payment text-center text-lg-right">
                            <li><a href="#"><img src="../public/assets/images/visa.png" alt="visa"></a></li>
                            <li><a href="#"><img src="../public/assets/images/discover.png" alt="discover"></a></li>
                            <li><a href="#"><img src="../public/assets/images/master_card.png" alt="master_card"></a>
                            </li>
                            <!--li><a href="#"><img src="../public/assets/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="../public/assets/images/amarican_express.png" alt="amarican_express"></a></li-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <style>
        .contenedor_telegram {
            width: 275px;
            height: 380px;
            background-color: #ffffff;
            padding-top: 7px;
            position: fixed;
            bottom: 83px;
            right: 307px;
            color: #FFF;
            border-radius: 5px;
            z-index: 100;
            border: 1px solid #264ecc;
            overflow: hidden;
            -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        }

        .contenedor_wapsa {
            width: 275px;
            height: 380px;
            background-color: #ffffff;
            padding-top: 7px;
            position: fixed;
            bottom: 83px;
            right: 82px;
            color: #FFF;
            border-radius: 5px;
            z-index: 100;
            border: 1px solid green;
            overflow: hidden;
            -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        }

        .apertura_what {
            animation-name: animacion_whapBox;
            animation-duration: 0.7s;
        }

        @keyframes animacion_whapBox {
            0% {
                width: 0px;
                height: 0px;
            }

            100% {
                width: 275px;
                height: 380px;
            }
        }

        .contenedor_inferior {
            padding: 15px;
            margin: 10px;
            background-color: #f3f3f3;
            height: 292px;
            border-radius: 5px;
            overflow: auto;
        }

        .float:hover {
            cursor: pointer;
        }

        .btn-icon2 {
            padding: 10px;
            background-color: #c7161d;
            color: white;
            border-radius: 50%;
        }

        .btn-icon {
            padding: 10px;
            background-color: #1bc159;
            color: white;
            border-radius: 50%;
        }

        .float2 {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 172px;
            background-color: #c7161d;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float3 {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 268px;
            background-color: #c7161d;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .contenedor_telegramM {
            width: 275px;
            height: 380px;
            background-color: #ffffff;
            padding-top: 7px;
            position: fixed;
            bottom: 156px;
            right: 93px;
            color: #FFF;
            border-radius: 5px;
            z-index: 100;
            border: 1px solid #264ecc;
            overflow: hidden;
            -webkit-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
            box-shadow: 12px 13px 16px -8px rgba(0, 0, 0, 0.75);
        }

        .floatm {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 70px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float2m {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 130px;
            right: 70px;
            background-color: #c7161d;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float3m {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 218px;
            right: 70px;
            background-color: #c7161d;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        #toggle-buttons {
            padding-top: 7px;
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 80px;
            background-color: #c7161d;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
            cursor: pointer;
        }

        #close-buttons {
            padding-top: 7px;
            position: fixed;
            width: 30px;
            height: 30px;
            bottom: 110px;
            right: 80px;
            background-color: #f5f5f5;
            color: #000;
            border-radius: 15px;
            text-align: center;
            font-size: 13px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
            cursor: pointer;
        }
    </style>

    <div class="button-container">
        <!--<span id="toggle-buttons">+</span>-->
        <div id="buttons" style="">
            <!--<span id="close-buttons">?</span>-->
            <a href="https://m.me/<?= $dataConf['redessociales']['id_facebook'] ?>" id="botn_facebook"
                class="<?= $body_class == 'desktop' ? 'float2' : 'float2m' ?>" target="_blank">
                <img style="max-width: 37px;" src="../public/facebook-messenger-brands.svg" class="my-float"></img>
            </a>
            <span href=" " id="botn_telegram" class="<?= $body_class == 'desktop' ? 'float3' : 'float3m' ?>"
                target="_blank">
                <img style="max-width: 37px;" src="../public/telegram_ico.png" class="my-float"></img>
            </span>
            <span id="botn_whapsa" class="<?= $body_class == 'desktop' ? 'float' : 'floatm' ?>" target="_blank">
                <i class="fa fa-whatsapp my-float"></i>
            </span>
        </div>
    </div>


    <div style="display: none"
        class="<?= $body_class == 'desktop' ? 'contenedor_telegram' : 'contenedor_telegramM' ?> apertura_what">
        <div style="width: 100%;text-align: center">
            <h4 style="color: #009237">¿Con quien quieres hablar?</h4>
        </div>
        <div class="contenedor_inferior">
            <?php
            $diaActual = (int)date('w'); // 0 a 6
            $horaActual = (int)date('H'); // 0 a 23

            foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
                if (!$whats['estado']) continue;

                // --- 1. VALIDACIÓN DE DÍAS ---
                $d1 = (int)$whats['dia1'];
                $d2 = (int)$whats['dia2'];

                if ($d1 <= $d2) {
                    $val1 = ($diaActual >= $d1 && $diaActual <= $d2);
                } else {
                    // Rango cruzado, ej: de Sábado (6) a Lunes (1)
                    $val1 = ($diaActual >= $d1 || $diaActual <= $d2);
                }

                // --- 2. VALIDACIÓN DE HORAS (Conversión a 24h) ---
                $h1 = (int)$whats['hora1'];
                $h2 = (int)$whats['hora2'];

                // Convertir inicio
                $horaInicio = ($whats['modo1'] == "PM" && $h1 < 12) ? $h1 + 12 : $h1;
                if ($whats['modo1'] == "AM" && $h1 == 12) $horaInicio = 0;

                // Convertir fin
                $horaFin = ($whats['modo2'] == "PM" && $h2 < 12) ? $h2 + 12 : $h2;
                if ($whats['modo2'] == "AM" && $h2 == 12) $horaFin = 0;

                // Comparar
                $val2 = ($horaActual >= $horaInicio && $horaActual < $horaFin);

                // --- 3. MOSTRAR RESULTADO ---
                $linkTelegram = 'https://t.me/' . str_replace(' ', '', $whats['nombre']);
            ?>
                <div style="width: 100%; height: 50px; margin-bottom: 3px;">
                    <a target="_blank" href="<?php echo $linkTelegram; ?>">
                        <i class="btn-icon2" style="float: left; margin-right: 5px;"></i>
                        <div style="float: left">
                            <strong><?php echo $whats['nombre']; ?></strong><br>
                            <?php echo $whats['numero']; ?>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>

        </div>
    </div>

    <div style="display: none" class="contenedor_wapsa apertura_what">
        <div style="width: 100%;text-align: center">
            <h4 style="color: #009237">Nuestros Asesores VIÑASANTODOMINGO</h4>
        </div>
        <div class="contenedor_inferior">
            <?php
            $dia = (int)date('w'); // 0 (domingo) a 6 (sábado)
            $horaActual = (int)date('H');

            foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
                if (!$whats['estado']) continue;

                // 1. Corregir validación de días
                $d1 = (int)$whats['dia1'];
                $d2 = (int)$whats['dia2'];

                if ($d1 <= $d2) {
                    $val1 = ($dia >= $d1 && $dia <= $d2);
                } else {
                    // Caso cuando el rango cruza la semana (ej: de Viernes [5] a Lunes [1])
                    $val1 = ($dia >= $d1 || $dia <= $d2);
                }

                // 2. Convertir horas a formato 24h correctamente
                $h1 = (int)$whats['hora1'];
                $h2 = (int)$whats['hora2'];

                $horaInicio = ($whats['modo1'] == 'PM' && $h1 < 12) ? $h1 + 12 : $h1;
                if ($whats['modo1'] == 'AM' && $h1 == 12) $horaInicio = 0;

                $horaFin = ($whats['modo2'] == 'PM' && $h2 < 12) ? $h2 + 12 : $h2;
                if ($whats['modo2'] == 'AM' && $h2 == 12) $horaFin = 0;

                // 3. Validar si la hora actual está en el rango
                // Nota: Usamos <= $horaFin para que si atiende hasta las 8 PM, se muestre a las 8:00
                $val2 = ($horaActual >= $horaInicio && $horaActual <= $horaFin);

            ?>
                <div style="width:100%;height:50px;margin-bottom:3px;">
                    <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $whats['numero']; ?>&text=<?php echo urlencode($whats['mensaje']); ?>">
                        <i class="btn-icon fa fa-whatsapp" style="float:left;margin-right:5px;"></i>
                        <div style="float:left">
                            <strong><?php echo $whats['nombre']; ?></strong><br>
                            <?php echo $whats['numero']; ?>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>

        </div>
    </div>






    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <!-- Latest jQuery -->
    <script src="../public/assets/js/jquery-1.12.4.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- popper min js -->
    <script src="../public/assets/js/popper.min.js"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- owl-carousel min js  -->
    <script src="../public/assets/owlcarousel/js/owl.carousel.min.js"></script>
    <!-- magnific-popup min js  -->
    <script src="../public/assets/js/magnific-popup.min.js"></script>
    <!-- waypoints min js  -->
    <script src="../public/assets/js/waypoints.min.js"></script>
    <!-- parallax js  -->
    <script src="../public/assets/js/parallax.js"></script>
    <!-- countdown js  -->
    <script src="../public/assets/js/jquery.countdown.min.js"></script>
    <!-- imagesloaded js -->
    <script src="../public/assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope min js -->
    <script src="../public/assets/js/isotope.min.js"></script>
    <!-- jquery.dd.min js -->
    <script src="../public/assets/js/jquery.dd.min.js"></script>
    <!-- slick js -->
    <script src="../public/assets/js/slick.min.js"></script>
    <!-- elevatezoom js -->
    <script src="../public/assets/js/jquery.elevatezoom.js"></script>
    <!-- scripts js -->
    <script src="../public/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../public/js/main.js?v=18.06"></script>
    <script src="../public/js/tools.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // $(document).ready(function() {
        //     // Mostrar el men� al cargar la p�gina
        //     var position = $('#categorias-trigger').position();
        //     var topPosition = position.top + $('#categorias-trigger').outerHeight();
        //     var leftPosition = position.left;

        //     $('#categorias-menu').css({
        //         top: topPosition,
        //         left: leftPosition
        //     }).show();

        //     // Configurar el evento de clic para mostrar/ocultar el men�
        //     $('#categorias-trigger').click(function() {
        //         $('#categorias-menu').toggle();
        //     });
        // });

        document.addEventListener('DOMContentLoaded', function() {
            var toggleButtons = document.getElementById('toggle-buttons');
            var closeButtons = document.getElementById('close-buttons');
            var buttonsContainer = document.getElementById('buttons');

            toggleButtons.addEventListener('click', function() {
                buttonsContainer.style.display = 'block';
            });

            closeButtons.addEventListener('click', function() {
                buttonsContainer.style.display = 'none';
            });
        });
        window.onload = function() {
            $('#alertavip').click(function() {
                alert('Usted no tiene permisos para acceder al area VIP');

            });




            $('#btnRegistrar').click(function() {
                let data = $('#formPromociones').serializeArray()
                if ($('#emailRegistrar').val() !== '') {
                    $.ajax({
                        url: "../ajax/ajs_registrardos_x_promocion.php",
                        data: data,
                        type: "post",
                        success: function(resp) {
                            let data = JSON.parse(resp)
                            if (data.res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Bien',
                                    text: data.msj,
                                })

                                $.ajax({
                                    type: "POST",
                                    url: '../auth/promociones.php',
                                    data: {
                                        email: $('#emailRegistrar').val()
                                    },
                                    success: function(respuesta) {
                                        $(".preloader").hide()
                                        console.log(respuesta);
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    url: '../auth/avisar_suscripcion.php',
                                    data: {
                                        email: $('#emailRegistrar').val()
                                    },
                                    success: function(respuesta) {
                                        $(".preloader").hide()
                                        console.log(respuesta);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: '!!',
                                    text: data.msj,
                                })
                            }
                            $('#emailRegistrar').val('')
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: '!!',
                        text: 'Ingrese un correo valido',
                    })
                }

            })

            $("#botn_telegram").hover(
                function() {
                    $(".contenedor_telegramM").attr("style", "display: block")
                },
                function() {
                    setTimeout(function() {
                        if (!valConst) {
                            $(".contenedor_telegramM").attr("style", "display: none")
                        }
                    }, 100)

                }
            );
            $(".contenedor_telegramM").hover(
                function() {
                    valConst = true;
                },
                function() {
                    valConst = false;
                    $(".contenedor_telegramM").attr("style", "display: none")
                }
            );
        };

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var section = $('.tradicion');
            if (section.length) {
                var diff = scroll - section.offset().top;
                section.css({
                    'background-position-y': (diff * 0.2) + 'px'
                });
            }
        });
    </script>

    <script>
    // ── Secciones Home: Nuevos Ingresos / Más Vendidos / Ofertas Especiales ──
    $(document).ready(function() {
        var PROXY = '../ajax/proxy_ecommerce_home.php';

        function imgOrPlaceholder(url, nombre) {
            if (url) {
                return '<img src="' + url + '" style="width:100%;height:220px;object-fit:cover;" alt="' + nombre + '" ' +
                    'onerror="this.style.display=\'none\';this.nextElementSibling.style.display=\'flex\'">' +
                    '<div style="display:none;width:100%;height:220px;background:#f0f0f0;align-items:center;justify-content:center;flex-direction:column;">' +
                        '<i class="fa fa-image fa-3x" style="color:#ccc;"></i>' +
                        '<small style="color:#aaa;margin-top:6px;">' + nombre + '</small>' +
                    '</div>';
            }
            return '<div style="width:100%;height:220px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;flex-direction:column;">' +
                '<i class="fa fa-image fa-3x" style="color:#ccc;"></i>' +
                '<small style="color:#aaa;margin-top:6px;text-align:center;padding:0 8px;">' + nombre + '</small>' +
            '</div>';
        }

        function cardProducto(p) {
            var precio = 'S/. ' + parseFloat(p.precio).toFixed(2);
            return '<div class="item">' +
                '<div class="product_wrap">' +
                    '<div class="product_img">' +
                        '<a href="javascript:void(0)">' + imgOrPlaceholder(p.imagen, p.nombre) + '</a>' +
                    '</div>' +
                    '<div class="product_info">' +
                        '<h6 class="product_title"><a style="white-space:normal" href="javascript:void(0)">' + p.nombre + '</a></h6>' +
                        '<div class="product_price" style="font-size:13px;"><strong>' + precio + '</strong></div>' +
                        (p.categoria ? '<small class="text-muted">' + p.categoria + '</small>' : '') +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        function cardOferta(o) {
            var fechaFin = o.fecha_fin ? ' hasta ' + o.fecha_fin.substring(0,10) : '';
            return '<div class="item">' +
                '<div class="product_wrap">' +
                    '<div class="product_img">' +
                        '<a href="javascript:void(0)">' + imgOrPlaceholder(o.imagen, o.nombre) + '</a>' +
                    '</div>' +
                    '<div class="product_info">' +
                        '<h6 class="product_title"><a style="white-space:normal" href="javascript:void(0)">' + o.nombre + '</a></h6>' +
                        '<div class="product_price" style="font-size:13px;">' +
                            '<span class="price">S/. ' + parseFloat(o.precio_oferta).toFixed(2) + '</span> ' +
                            '<del>S/. ' + parseFloat(o.precio).toFixed(2) + '</del>' +
                        '</div>' +
                        '<small class="text-muted">' + o.descuento + ' de descuento' + fechaFin + '</small>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        function initOwl(id) {
            var $el = $('#' + id);
            if ($el.hasClass('owl-loaded')) {
                $el.trigger('destroy.owl.carousel').removeClass('owl-loaded');
            }
            $el.owlCarousel({
                loop: true, margin: 20, dots: true,
                responsive: { 0:{items:1}, 481:{items:2}, 768:{items:3}, 991:{items:4} }
            });
        }

        function cargarSeccion(seccion, owlId, buildCard) {
            $.get(PROXY, { seccion: seccion }, function(resp) {
                if (!resp.success || !resp.data || !resp.data.length) {
                    $('#' + owlId).html('<div class="item"><p class="text-muted text-center py-3">Sin datos disponibles.</p></div>');
                } else {
                    var html = '';
                    $.each(resp.data, function(i, item) { html += buildCard(item); });
                    $('#' + owlId).html(html);
                }
                initOwl(owlId);
            }, 'json').fail(function() {
                $('#' + owlId).html('<div class="item"><p class="text-muted text-center py-3">No se pudo conectar con la API.</p></div>');
                initOwl(owlId);
            });
        }

        function cardRemate(r) {
            var moneda = (r.moneda === 'USD') ? '$' : 'S/.';
            var precioHtml;
            if (r.precio_remate) {
                precioHtml = '<span class="price">' + moneda + ' ' + parseFloat(r.precio_remate).toFixed(2) + '</span> ' +
                             '<del>' + moneda + ' ' + parseFloat(r.precio).toFixed(2) + '</del>';
            } else {
                precioHtml = '<strong>' + moneda + ' ' + parseFloat(r.precio).toFixed(2) + '</strong>';
            }
            var stockHtml;
            var s = parseInt(r.stock);
            if (s <= 0) stockHtml = "<span style='color:#d70000'>Sin Stock</span>";
            else        stockHtml = "<span style='color:#03ad01'>" + s + " en Stock</span>";

            return '<div class="item">' +
                '<div class="product_wrap">' +
                    '<div class="product_img">' +
                        '<a href="javascript:void(0)">' + imgOrPlaceholder(r.imagen_url, r.nombre) + '</a>' +
                    '</div>' +
                    '<div class="product_info">' +
                        '<h6 class="product_title"><a style="white-space:normal" href="javascript:void(0)">' + r.nombre + '</a></h6>' +
                        '<div class="product_price" style="font-size:13px;">' + precioHtml + '</div>' +
                        '<div class="rating_wrap"><span class="rating_num"><strong>Stock: ' + stockHtml + '</strong></span></div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        function cargarRemate() {
            $.get('../ajax/proxy_remate.php', { accion: 'listar' }, function(resp) {
                var owlId = 'owl-productos-remate';
                if (!resp.success || !resp.data || !resp.data.length) {
                    $('#' + owlId).html('<div class="item"><p class="text-muted text-center py-3">Sin productos en remate.</p></div>');
                } else {
                    var html = '';
                    $.each(resp.data, function(i, item) { html += cardRemate(item); });
                    $('#' + owlId).html(html);
                }
                initOwl(owlId);
            }, 'json').fail(function() {
                var owlId = 'owl-productos-remate';
                $('#' + owlId).html('<div class="item"><p class="text-muted text-center py-3">No se pudo cargar.</p></div>');
                initOwl(owlId);
            });
        }

        function cardTendencia(p) {
            var moneda = (p.moneda === 'USD') ? '$' : 'S/.';
            var precio = moneda + ' ' + parseFloat(p.precio).toFixed(2);
            var s = parseInt(p.stock);
            var stockHtml = s <= 0
                ? "<span style='font-weight:lighter;color:#d70000'>Sin Stock</span>"
                : "<span style='font-weight:lighter;color:#03ad01'>" + s + " en Stock</span>";

            var imgHtml = p.imagen_url
                ? '<img src="' + p.imagen_url + '" alt="' + p.nombre + '" style="max-width:540px;max-height:600px;"' +
                  ' onerror="this.style.display=\'none\'">' +
                  '<img class="product_hover_img" src="' + p.imagen_url + '" alt="' + p.nombre + '" style="max-width:540px;max-height:600px;">'
                : '<div style="height:220px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">' +
                  '<i class="fa fa-image fa-3x" style="color:#ccc;"></i></div>';

            return '<div class="item">' +
                '<div class="product_wrap">' +
                    '<div class="product_img">' +
                        '<a href="javascript:void(0)">' + imgHtml + '</a>' +
                        '<div class="product_action_box">' +
                            '<ul class="list_none pr_action_btn">' +
                                '<li class="add-to-cart"><a href="javascript:void(0)"><i class="icon-basket-loaded"></i> A&ntilde;adir al carrito</a></li>' +
                                '<li><a href="javascript:void(0)"><i class="icon-shuffle"></i></a></li>' +
                                '<li><a href="javascript:void(0)"><i class="icon-magnifier-add"></i></a></li>' +
                                '<li><a href="javascript:void(0)"><i class="icon-heart"></i></a></li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                    '<div class="product_info">' +
                        '<h6 class="product_title" style="height:40px;"><a style="white-space:normal" href="javascript:void(0)">' + p.nombre + '</a></h6>' +
                        '<div class="product_price" style="font-size:13px;"><strong>' + precio + '</strong></div>' +
                        '<div class="rating_wrap"><span class="rating_num"><strong>Stock: <a href="javascript:void(0)">' + stockHtml + '</a></strong></span></div>' +
                        '<div class="pr_desc"><p></p></div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        cargarSeccion('nuevos-ingresos',         'owl-nuevos-ingresos',       cardProducto);
        cargarSeccion('mas-vendidos',             'owl-mas-vendidos',          cardProducto);
        cargarSeccion('ofertas-especiales',       'owl-ofertas-especiales',    cardOferta);
        cargarSeccion('productos-de-tendencia',   'owl-productos-tendencia',   cardTendencia);
        cargarRemate();

        // ── Secciones: Destacados / Mejor Valorados / En Oferta ──
        function getStockLabel(s) {
            s = parseInt(s);
            if (!s || s <= 0) return "<span style='color:#d70000'>Sin Stock</span>";
            return "<span style='color:#03ad01'>" + s + " en Stock</span>";
        }

        function starsHtml(rating) {
            var html = '';
            for (var i = 1; i <= 5; i++) {
                html += (i <= Math.round(rating)) ? '&#9733;' : '&#9734;';
            }
            return '<span style="color:#f5a623;font-size:14px;">' + html + '</span>';
        }

        // Card estilo lista horizontal: imagen izq + info der (igual al screenshot)
        function cardLista(imagen, nombre, precioHtml, stockHtml2) {
            var imgHtml = imagen
                ? '<img src="' + imagen + '" alt="' + nombre + '" style="width:90px;height:90px;object-fit:cover;" onerror="this.src=\'\';">'
                : '<div style="width:90px;height:90px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;"><i class="fa fa-camera fa-2x" style="color:#ccc;"></i></div>';
            return '<div class="item">' +
                '<div style="display:flex;align-items:center;gap:14px;padding:12px;border:1px solid #eee;border-radius:4px;background:#fff;">' +
                    '<div style="flex-shrink:0;">' + imgHtml + '</div>' +
                    '<div style="flex:1;">' +
                        '<h6 style="font-size:13px;font-weight:600;margin-bottom:6px;white-space:normal;line-height:1.3;">' + nombre + '</h6>' +
                        '<div style="font-size:13px;color:#c8232c;margin-bottom:4px;">' + precioHtml + '</div>' +
                        '<div style="font-size:12px;">' + stockHtml2 + '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }

        function cardDestacado(p) {
            return cardLista(p.imagen, p.nombre,
                '<strong>S/. ' + parseFloat(p.precio).toFixed(2) + '</strong>',
                '<strong>Stock: ' + getStockLabel(p.stock) + '</strong>'
            );
        }

        function cardMejorValorado(p) {
            return cardLista(p.imagen, p.nombre,
                '<strong>S/. ' + parseFloat(p.precio).toFixed(2) + '</strong>',
                '<strong>Stock: ' + getStockLabel(p.stock) + '</strong>'
            );
        }

        function cardOfertaCol(o) {
            var precioHtml2 = '<strong>S/. ' + parseFloat(o.precio_oferta || o.precio).toFixed(2) + '</strong>' +
                (o.precio_oferta ? ' <del style="color:#999;">S/. ' + parseFloat(o.precio).toFixed(2) + '</del>' : '');
            return cardLista(o.imagen, o.nombre, precioHtml2, '<strong>Stock: ' + getStockLabel(o.stock) + '</strong>');
        }

        // Agrupa array en páginas de N elementos
        function paginar(arr, n) {
            var pages = [];
            for (var i = 0; i < arr.length; i += n) {
                pages.push(arr.slice(i, i + n));
            }
            return pages;
        }

        // Construye HTML del owl: cada .item contiene 3 cards apiladas verticalmente
        function buildPages(data, buildCard, pageSize) {
            var pages = paginar(data, pageSize);
            var html = '';
            $.each(pages, function(i, page) {
                html += '<div class="item">';
                $.each(page, function(j, item) {
                    html += buildCard(item);
                });
                html += '</div>';
            });
            return html;
        }

        function initOwlCol(id, timeout) {
            var $el = $('#' + id);
            if ($el.hasClass('owl-loaded')) {
                $el.trigger('destroy.owl.carousel').removeClass('owl-loaded');
            }
            $el.owlCarousel({
                items: 1, loop: true, margin: 0, dots: false, nav: true,
                autoplay: true, autoplayTimeout: timeout, autoplayHoverPause: true
            });
        }

        function cargarColumna(seccion, owlId, buildCard, timeout) {
            $.get(PROXY, { seccion: seccion }, function(resp) {
                var data = (resp.success && resp.data && resp.data.length) ? resp.data : null;
                var html = '';
                if (data) {
                    html = buildPages(data, buildCard, 3);
                } else {
                    $.get(PROXY, { seccion: 'nuevos-ingresos' }, function(r2) {
                        if (r2.success && r2.data && r2.data.length) {
                            var fallback = r2.data.sort(function() { return 0.5 - Math.random(); });
                            html = buildPages(fallback, cardDestacado, 3);
                        } else {
                            html = '<div class="item"><p class="text-muted text-center py-3">Sin datos.</p></div>';
                        }
                        $('#' + owlId).html(html);
                        initOwlCol(owlId, timeout);
                    }, 'json');
                    return;
                }
                $('#' + owlId).html(html);
                initOwlCol(owlId, timeout);
            }, 'json').fail(function() {
                $('#' + owlId).html('<div class="item"><p class="text-muted text-center py-3">No se pudo conectar.</p></div>');
                initOwlCol(owlId, timeout);
            });
        }

        cargarColumna('productos-mas-rentables',       'owl-productos-destacados', cardDestacado,     3500);
        cargarColumna('productos-mejor-valorados-mes', 'owl-mejor-valorados',      cardMejorValorado, 4000);
        cargarColumna('ofertas-especiales',            'owl-ofertas-vigentes',     cardOfertaCol,     4500);
    });
    </script>

    <script>
    // Nuestra Selección — carga después de Vue y main.js para evitar conflictos
    $(document).ready(function() {
        $.post('../ajax/proxy_seleccion.php', { tipo: 'lista' }, function(resp) {
            if (!resp.success || !resp.data || !resp.data.length) return;
            var html = '';
            $.each(resp.data, function(i, cat) {
                if (cat.estado != '1') return;
                var img = cat.imagen_url || '../public/img/banner/sinimagen_menu_20sba.jpg';
                var url = cat.codi_categoria ? 'shop-list-ctg.php?ctg=' + encodeURIComponent(cat.codi_categoria) : '#';
                html += '<div class="col-lg-3 col-md-6 col-sm-6 mb-4">' +
                    '<a href="' + url + '" class="wine-cat-card-wrapper">' +
                        '<div class="wine-card shadow-sm border-0">' +
                            '<div class="wine-img-container">' +
                                '<img src="' + img + '" class="img-fluid" alt="' + cat.nombre_cate + '" onerror="this.src=\'../public/img/banner/sinimagen_menu_20sba.jpg\'">' +
                                '<div class="wine-overlay"></div>' +
                                '<div class="wine-cat-label">' +
                                    '<h4 class="m-0">' + cat.nombre_cate + '</h4>' +
                                    '<p class="m-0 small text-uppercase">Explorar Colecci&oacute;n <i class="ti-arrow-right"></i></p>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                    '</a>' +
                '</div>';
            });
            $('#gridNuestraSeleccion').html(html);
        }, 'json');
    });
    </script>

</body>

</html>
