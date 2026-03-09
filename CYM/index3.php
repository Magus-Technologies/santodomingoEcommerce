<?php

session_start();
/* var_dump($_SESSION['usuario']);
die(); */
/* echo getcwd(); */
date_default_timezone_set('America/Lima');


require "../utils/Tools.php";
require "../dao/NuevoImgresoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../dao/ProductoDao.php";
require "../extra/TasaCambioApi.php";


$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];
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

/* echo "<pre>";
var_dump($listaNue);
die(); */
$listaNue2 = $productoDao->getLastRegisterSilver(7);

$randonItemProdsss = $productoDao->getRandonRegister(46);
$listaRamMasVen  = array_slice($randonItemProdsss,0,29);

/* var_dump($listaRamMasVen);
die();  */
/* $listaRamTenden = $productoDao->getRandonRegister(12); */
$listaRamTenden = array_slice($randonItemProdsss,30,7);
/* var_dump($listaRamTenden);
die(); */
$listaRamTendenInstagram = array_slice($randonItemProdsss,38,7);
/* var_dump($listaRamTendenInstagram);
die(); */


$listaRamByCat = $productoDao->getDataRandonE();
//die();
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
$listaMarcas = $conexion->query("SELECT * FROM marcra_productos order by nombre_marca asc");

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


?>
<!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>

<!-- SITE TITLE -->
<title>CGS-COMPUTER</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="../public/assets/css/animate.css">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
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

<style>
    .float {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 80px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .texto-palpitante {
        color: #000000;
        animation-name: colorpalpitante2;
        animation-duration: 1.5s;
        animation-iteration-count: infinite;
    }

    @keyframes colorpalpitante2 {
        from {
            color: black;
        }

        to {
            color: #ffffff;
        }
    }

    .panel-palpitante {
        background-color: white;
        animation-name: colorpalpitante;
        animation-duration: 1.5s;
        animation-iteration-count: infinite;
    }


    @keyframes colorpalpitante {
        from {
            background-color: white;
            color: black
        }

        to {
            background-color: #ff324d;
            color: white
        }
    }

    <?php
    if ($body_class == 'desktop') { ?>.menu-var {
        color: white;
    }

    .menu-var:hover {
        color: #f7324d;
    }

    <?php
    }
    ?>
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
    <div class="custom-container" style="padding: 11px; width: 100%;overflow: hidden">
        <i class="ti-location-pin" style="float: left"></i>
        <p style="float: left; margin: 0px;"><strong><?= $dataConf['direccion'] ?></strong></p>
    </div>
    <header class="header_wrap">

        <?php //include "../fragment/head_index.php"
        ?>

        <?php include "../fragment/nav_bar_index.php" ?> // 1s


        <div style="background-color: #232323;" class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-3">
                        <div class="categories_wrap">
                            <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn">
                                <i class="linearicons-menu"></i><span>CATEGORÍA DE PRODUCTOS</span>
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
                                                        <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"><img style="max-width: 28px;" src="../public/iconos/<?= $catRow['icono'] ?>">
                                                            <span><?= $catRow['nombre'] ?></span></a>
                                                        <div class="dropdown-menu">
                                                            <ul class="mega-menu d-lg-flex">
                                                                <li class="mega-menu-col col-lg-8">
                                                                    <ul class="d-lg-flex">
                                                                        <li class="mega-menu-col col-lg-8">
                                                                            <ul>

                                                                                <?php
                                                                                foreach ($resSUb as $rowMar) { ?>
                                                                                    <li class=""> <strong><a class="dropdown-header" href="shop-list-ctg.php?ctg=<?= $catRow['codi_categoria'] ?>&sub=<?= $rowMar['sub_id'] ?>" style="color:red"><?= $rowMar['nombre'] ?></a></strong>
                                                                                    </li>
                                                                                <?php }
                                                                                ?>

                                                                            </ul>
                                                                            <ul>
                                                                                <li class="dropdown-header text-cennter">Productos</li>
                                                                                <?php
                                                                                if ($body_class == 'desktop') :
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
                                                                                else :
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
                                                                        <a href="javascript:void(0)"><img src="../public/img/banner/<?= $catRow['imagen'] ?>" alt="menu_banner"></a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>

                                                <?php  } else {
                                                    $resSUb = $grupoCategoriaDao->getSubCat($catRow['id_seleccion']);

                                                ?>
                                                    <li class="dropdown dropdown-mega-menu">
                                                        <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"><img style="max-width: 28px;" src="../public/iconos/<?= $catRow['icono'] ?>">
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
                                                                                    <li class=""> <strong><a class="dropdown-header" href="shop-list-ctg.php?ctg=<?= $catRow['codi_categoria'] ?>&sub=<?= $rowMar['nombre'] ?>"><?= $rowMar['nombre'] ?></a></strong>
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
                                                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-mrc.php?mrc=<?= $rowMar['marca'] ?>&grp=<?= $catRow['codi_categoria'] ?>"><?= $rowMar['nombre'] ?></a>
                                                                                    </li>
                                                                                <?php }
                                                                                ?>

                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="mega-menu-col col-lg-5">
                                                                    <div class="header-banner2">
                                                                        <a href="javascript:void(0)"><img src="../public/img/banner/<?= $catRow['imagen'] ?>" alt="menu_banner"></a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                <?php     }
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
                                </ul>
                                <div class="more_categories">Más categorías</div>
                            </div>
                        </div>
                    </div>















                    <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                        <nav class="navbar navbar-expand-lg">
                            <button style="color: white;" class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false">
                                <span class="ion-android-menu"></span>
                            </button>
                            <div class="pr_search_icon">
                                <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                            </div>
                            <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
                                <ul class="navbar-nav" <?= $body_class == 'desktop' ? ' style="backgroud:black;" ' : ' ' ?>>

                                    <li class="dropdown dropdown-mega-menu">
                                        <a class="dropdown-toggle nav-link menu-var" href="#" data-toggle="dropdown">MARCAS</a>
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

                                    <li class="dropdown panel-palpitante">
                                        <a class="nav-link texto-palpitante " href="shop-list-prod-ofertas.php">OFERTAS</a>

                                    </li>


                                    <li>
                                        <a class="nav-link menu-var" href="shop-list-prod.php?search=+&type=last">NOVEDADES</a>

                                    </li>

                                    <li class="dropdown panel-palpitante">
                                        <a class="nav-link texto-palpitante" href="shop-list-prod-remate.php">PC armadas</a>

                                    </li>
                                    <li class="">
                                        <a class="nav-link menu-var " href="./shop-list-prod-exclu.php">EXCLUSIVOS</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link  menu-var" href="./shop-list-prod-mac.php?marc=071">SILVER VOLT</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link  menu-var" href="./contact.php">Contactanos</a>
                                    </li>
                                    <li class="">
                                        <a class="nav-link  menu-var" href="./about.php">ACERCA DE NOSOTROS</a>
                                    </li>
                                    <li class="">
                                        <span class="nav-link" style="color: #fe324d;font-size: 20px;padding-bottom: 7px;padding-top: 16px;">Tc: <?= $tc ?></span>
                                    </li>
                                </ul>
                            </div>

                        </nav>
                    </div>
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
    </style>

    <!-- START SECTION BANNER -->
    <div class="mt-4 staggered-animation-wrap">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-7 offset-lg-3">
                    <div class="banner_section shop_el_slider">
                        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
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

                                        <div class="carousel-item <?= ($countBan == 1)  ? 'active' : '' ?>   background_bg" style="cursor: pointer;" onclick="location.href='<?= $rowBan['url']  ?>';" data-img-src="../public/img/banner/<?= $rowBan['imagen']  ?> " style="">
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

    <!-- END MAIN CONTENT -->
    <div class="main_content">
        <!-- START SECTION SHOP -->
        <div class="section small_pt pb-0">
            <div class="custom-container">
                <div class="row">
                    <div class="col-xl-3 d-none d-xl-block">
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
                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading_tab_header">
                                    <div class="heading_s2">
                                        <h4>Productos Exclusivos</h4>
                                    </div>
                                    <div class="tab-style2">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tabmenubar" aria-expanded="false">
                                            <span class="ion-android-menu"></span>
                                        </button>
                                        <ul class="nav nav-tabs justify-content-center justify-content-md-end" id="tabmenubar" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="arrival-tab" data-toggle="tab" href="#arrival" role="tab" aria-controls="arrival" aria-selected="true">Nuevos Ingresos</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="sellers-tab" data-toggle="tab" href="#sellers" role="tab" aria-controls="sellers" aria-selected="false">Los mas Vendido</a>
                                            </li>
                                            <!--  <li hidden class="nav-item">
                                                <a class="nav-link" id="featured-tab" data-toggle="tab" href="#featured__" role="tab" aria-controls="featured" aria-selected="false">Ofertas Especiales</a>
                                            </li> -->
                                            <li class="nav-item">
                                                <a class="nav-link" id="special-tab" data-toggle="tab" href="#special" role="tab" aria-controls="special" aria-selected="false">Ofertas Especiales</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="tab_slider">
                                    <div class="tab-pane fade show active" id="arrival" role="tabpanel" aria-labelledby="arrival-tab">
                                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                                            <?php
                                            foreach ($listaNue as $proN) {
                                                if (!is_null($proN['precio_ofertaa'])) {
                                                    $ahorro = $proN['precio'] - $proN['precio_ofertaa'];
                                                    $precioProd =  number_format($proN['precio'], 2, '.', ',');
                                                    $ahorro = number_format($ahorro, 2, '.', ',');
                                                    $precioCambio = number_format($tc * $proN['precio_ofertaa'], 2, '.', ',');
                                                    $ahorroSol = $tc * $ahorro;
                                                    $precioProdSol =  number_format($tc * $precioProd, 2, '.', ',');
                                                    $ahorroSol = number_format($tc * $ahorro, 2, '.', ',');
                                                    $ahorroSol = number_format(floatval(0), 2);
                                                } else {
                                                    $precioProd =  number_format($proN['precio'], 2, '.', ',');
                                                    $precioCambio = number_format($tc * $proN['precio'], 2, '.', ',');
                                                }

                                            ?>
                                                <?php if ($proN['stock'] !== '0.000' && $proN['estado'] == '1') : ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <?php


                                                            ?>

                                                            <div class="product_img">
                                                                <a href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>">
                                                                    <img style="max-width: 540px; max-height: 600px;" src="../public/img/productos/<?= $proN['imagen1'] ?>" alt="el_img3">
                                                                    <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/img/productos/<?= $proN['imagen2'] ?>" alt="el_hover_img3">
                                                                    <!--img style="max-width: 540px; max-height: 600px;" src="../public/images/Exclusivos/c_i7.jpg" alt="el_img3">
                                                        <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/images/Exclusivos/c_i72.jpg" alt="el_hover_img3"-->
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li class="add-to-cart"><a onclick="CARRITO.espe_prod_carr(<?= $proN['prod_id'] ?>)" href="javascript:void(0)"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $proN['prod_id'] ?>" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $proN['prod_id'] ?>" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a style="white-space: normal" href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>"><?= $proN['nombre'] ?></a></h6>
                                                                <?php if (!is_null($proN['precio_ofertaa'])) : ?>
                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <span class="price">$<?= $proN['precio_ofertaa'] ?></span>
                                                                        <del>$<?= $precioProd ?></del>
                                                                        <div class="on_sale">
                                                                            <span>Ahorre $<?= $ahorro ?></span>
                                                                        </div>
                                                                        <br>
                                                                        <span class="price">S/. <?= $precioCambio ?></span>
                                                                        
                                                                        <del><span> S/. <?php echo $precioProdSol; ?></span></del>
                                                                    </div>

                                                                <?php else : ?>
                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <span class="price">$<?= $precioProd ?></span>
                                                                        <span> <strong>S/. <?php echo $precioCambio; ?></strong></span>
                                                                        <!--div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                                    </div>
                                                                <?php endif; ?>

                                                                <div class="rating_wrap">
                                                                    <!--div class="rating">
                                                            <div class="product_rate" style="width:87%"></div>
                                                        </div-->
                                                                    <span class="rating_num"><strong>Stock: <a href="javascript:void(0)"><?php
                                                                                                                                            if ($proN['stock'] == 0) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                                            } elseif ($proN['stock'] > 10) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                                            } else {
                                                                                                                                                echo  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($proN['stock'], 0, '.', ',') . " en Stock</span>";
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
                                            <?php }
                                            ?>


                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="sellers" role="tabpanel" aria-labelledby="sellers-tab">
                                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                            <?php
                                            foreach ($listaRamMasVen as $itemMV) {
                                                if ((!is_null($itemMV['precio_ofertaa']))) {
                                                    $ahorro = $itemMV['precio'] - $itemMV['precio_ofertaa'];
                                                    $precioProd =  number_format($itemMV['precio'], 2, '.', ',');
                                                    $ahorro = number_format($ahorro, 2, '.', ',');
                                                    $precioCambio = number_format($tc * $itemMV['precio_ofertaa'], 2, '.', ',');
                                                    $ahorroSol = $tc * $ahorro;
                                                    $precioProdSol =  number_format($tc * $precioProd, 2, '.', ',');
                                                    $ahorroSol = number_format($tc * $ahorro, 2, '.', ',');
                                                    $ahorroSol = number_format(floatval(0), 2);
                                                } else {
                                                    $precioProd =  number_format($itemMV['precio'], 2, '.', ',');
                                                    $precioCambio = number_format($tc * $itemMV['precio'], 2, '.', ',');
                                                }
                                            ?>
                                                <?php if ($itemMV['stock'] !== '0.000' && $itemMV['estado'] !== '0') : ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <div class="product_img">
                                                                <a href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>">
                                                                    <img src="../public/img/productos/<?= $itemMV['imagen1'] ?>" alt="el_img7">
                                                                    <img class="product_hover_img" src="../public/img/productos/<?= $itemMV['imagen2'] ?>" alt="el_hover_img7">
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li class="add-to-cart"><a onclick="CARRITO.espe_prod_carr(<?= $itemMV['prod_id'] ?>)" href="javascript:void(0)"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $itemMV['prod_id'] ?>" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $itemMV['prod_id'] ?>" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a style="white-space: normal" href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>"><?= $itemMV['nombre'] ?></a></h6>
                                                                <?php if ((!is_null($itemMV['precio_ofertaa']))) : ?>
                                                                    <div style="font-size: 13px;" class="product_price">
                                                                        <span class="price">$<?= $itemMV['precio_ofertaa'] ?></span>
                                                                        <del>$<?= $precioProd ?></del>
                                                                        <div class="on_sale">
                                                                            <span>Ahorre $<?= $ahorro ?></span>
                                                                        </div>
                                                                        <br>
                                                                        <span class="price">S/. <?= $precioCambio ?></span>
                                                                        <del><span> S/. <?php echo $precioProdSol; ?></span></del>
                                                                    </div>

                                                                <?php else : ?>
                                                                    <div class="product_price">
                                                                        <span class="price">$<?= $precioProd ?></span>
                                                                        <span> <strong>S/. <?php echo $precioCambio; ?></strong></span>
                                                                        <!--div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="rating_wrap">

                                                                    <span class="rating_num"><strong>Stock: <a href="javascript:void(0)"><?php
                                                                                                                                            if ($itemMV['stock'] == 0) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                                            } elseif ($itemMV['stock'] > 10) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                                            } else {
                                                                                                                                                echo  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($itemMV['stock'], 0, '.', ',') . " en Stock</span>";
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
                                            <?php     }
                                            ?>



                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="featured__" role="tabpanel" aria-labelledby="sellers-tab">

                                    </div>
                                    <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                                            <?php
                                            foreach ($listaOfertas as $proN) {
                                                $ahorro = $proN['precio'] - $proN['precio_oferta'];
                                                $precioProd =  number_format($proN['precio'], 2, '.', ',');
                                                $ahorro = number_format($ahorro, 2, '.', ',');
                                                $precioCambio = number_format($tc * $proN['precio_oferta'], 2, '.', ',');
                                                $ahorroSol = $tc * $ahorro;
                                                $precioProdSol =  number_format($tc * $precioProd, 2, '.', ',');
                                                $ahorroSol = number_format($tc * $ahorro, 2, '.', ',');
                                                $ahorroSol = number_format(floatval(0), 2);
                                                /* var_dump($ahorro); */

                                                //$stockTEM = $ofeItem['cantidad'] - 2;
                                                // $progreso =  ($stockTEM * 100)/$ofeItem['cantidad'];
                                                //$progreso = number_format($progreso, 0, '', '');
                                            ?>
                                                <?php if ($proN['stock'] !== '0.000' && $proN['estado'] == '1') : ?>
                                                    <div class="item">
                                                        <div class="product_wrap">
                                                            <?php

                                                            ?>

                                                            <div class="product_img">
                                                                <a href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>">
                                                                    <img style="max-width: 540px; max-height: 600px;" src="../public/img/productos/<?= $proN['imagen1'] ?>" alt="el_img3">
                                                                    <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/img/productos/<?= $proN['imagen2'] ?>" alt="el_hover_img3">
                                                                    <!--img style="max-width: 540px; max-height: 600px;" src="../public/images/Exclusivos/c_i7.jpg" alt="el_img3">
                                                        <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/images/Exclusivos/c_i72.jpg" alt="el_hover_img3"-->
                                                                </a>
                                                                <div class="product_action_box">
                                                                    <ul class="list_none pr_action_btn">
                                                                        <li class="add-to-cart"><a onclick="CARRITO.espe_prod_carr(<?= $proN['prod_id'] ?>)" href="javascript:void(0)"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                                                        <li><a href="shop-compare.php?prod=<?= $proN['prod_id'] ?>" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                                        <li><a href="shop-quick-view.php?prod=<?= $proN['prod_id'] ?>" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                                        <li><a href="javascript:void(0)"><i class="icon-heart"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="product_info">
                                                                <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a style="white-space: normal" href="shop-product-detail.php?prod=<?= $proN['prod_id'] ?>"><?= $proN['nombre'] ?></a></h6>
                                                                <div style="font-size: 13px;" class="product_price">
                                                                    <span class="price">$<?= $proN['precio_oferta'] ?></span>
                                                                    <del>$<?= $precioProd ?></del>
                                                                    <div class="on_sale">
                                                                        <span>Ahorre $<?= $ahorro ?></span>
                                                                    </div>
                                                                </div>
                                                                <div style="font-size: 13px;" class="product_price">
                                                                    <span class="price">S/. <?= $precioCambio ?></span>
                                                                    <del>S/. <?= $precioProdSol ?></del>

                                                                </div>
                                                                <div class="rating_wrap">

                                                                    <span class="rating_num"><strong>Stock: <a href="javascript:void(0)"><?php
                                                                                                                                            if ($proN['stock'] == 0) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                                            } elseif ($proN['stock'] > 10) {
                                                                                                                                                echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                                            } else {
                                                                                                                                                echo  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($proN['stock'], 0, '.', ',') . " en Stock</span>";
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
                                            <?php }
                                            ?>
                                        </div>
                                    </div>
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
                    <?php foreach ($arrayInferioFinal as $row) : ?>
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
                                <h4>Ofertas</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style3" data-loop="false" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
                            <?php
                            // print_r($listaOfertas);
                            foreach ($listaOfertas as $ofeItem) {


                                $precioFormat = number_format($ofeItem['precio'], 2, '.', ',');
                                $stockTEM = $ofeItem['cantidad'] - 2;
                                $progreso =  ($stockTEM * 100) / $ofeItem['cantidad'];
                                $progreso = number_format($progreso, 0, '', '');

                                $precioCambio = number_format($tc * $ofeItem['precio_oferta'], 2, '.', ',');

                                $precioProdSol =  number_format($tc * $ofeItem['precio'], 2, '.', ',');

                            ?>
                                <?php if ($ofeItem['stock'] > 0) : ?>

                                    <div class="item">

                                        <div class="deal_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php?prod=<?= $ofeItem['prod_id'] ?>">
                                                    <img src="../public/img/productos/<?php echo $ofeItem['imagen1'] ?>" alt="el_img1">
                                                </a>
                                            </div>
                                            <div class="deal_content">
                                                <div class="product_info">
                                                    <h5 class="product_title"><a href="shop-product-detail.php?prod=<?= $ofeItem['prod_id'] ?>"><?= $ofeItem['nombre'] ?></a></h5>
                                                    <div class="product_price">
                                                        <span class="price">$<?= $ofeItem['precio_oferta'] ?></span>
                                                        <del>$<?= $precioFormat ?></del>
                                                    </div>
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
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?= $progreso ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $progreso ?>%"> <?= $progreso ?>% </div>
                                                    </div>
                                                </div>
                                                <div class="countdown_time countdown_style4 mb-4 " data-time="<?= $ofeItem['fecha_termino'] ?> 12:00:00"></div>
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

        <!-- END SECTION SHOP -->

        <!-- START SECTION SHOP -->
        <div class="section small_pt small_pb">
            <div class="custom-container">
                <div class="row">

                    <div class="col-xl-3 d-none d-xl-block">

                        <div class="sale-banner">
                            <a class="hover_effect1" href="<?= $banner6FinalExtra['url'] ?>">
                                <img src="../public/img/banner/<?= $banner6FinalExtra['imagen'] ?>" alt="shop_banner_img10">
                            </a>
                        </div>

                    </div>

                    <div class="col-xl-9">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading_tab_header">
                                    <div class="heading_s2">
                                        <h4>Productos de Tendencia</h4>
                                    </div>
                                    <div class="view_all">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>

                                    <?php
                                    foreach ($listaRamMasVen as $itemMV) {

                                        if ((!is_null($itemMV['precio_ofertaa']))) {
                                            $ahorro = $itemMV['precio'] - $itemMV['precio_ofertaa'];
                                            $ahorroSol = $tc * $ahorro;
                                            $precioProd =  number_format($itemMV['precio'], 2, '.', ',');
                                            $ahorro = number_format($ahorro, 2, '.', ',');
                                            $precioCambio = number_format($tc * $itemMV['precio_ofertaa'], 2, '.', ',');                                          
                                            $precioProdSol =  number_format($tc * $precioProd, 2, '.', ',');
                                            $ahorroSol = number_format($tc * $ahorro, 2, '.', ',');
                                            $ahorroSol = number_format(floatval(0), 2);
                                        } else {
                                            $precioProd =  number_format($itemMV['precio'], 2, '.', ',');
                                            $precioCambio = number_format($tc * $itemMV['precio'], 2, '.', ',');
                                        }
                                    ?>
                                        <?php if ($itemMV['stock'] !== '0.000') : ?>
                                            <div class="item">
                                                <div class="product_wrap">
                                                    <div class="product_img">
                                                        <a href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>">
                                                            <img src="../public/img/productos/<?= $itemMV['imagen1'] ?>" alt="el_img7">
                                                            <img class="product_hover_img" src="../public/img/productos/<?= $itemMV['imagen2'] ?>" alt="el_hover_img7">
                                                        </a>
                                                        <div class="product_action_box">
                                                            <ul class="list_none pr_action_btn">
                                                                <li class="add-to-cart"><a onclick="CARRITO.espe_prod_carr(<?= $itemMV['prod_id'] ?>)" href="javascript:void(0)"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                                                <li><a href="shop-compare.php?prod=<?= $itemMV['prod_id'] ?>" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                                <li><a href="shop-quick-view.php?prod=<?= $itemMV['prod_id'] ?>" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                                <li><a href="javascript:void(0)"><i class="icon-heart"></i></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product_info">
                                                        <h6 class="product_title" <?= $body_class == 'desktop' ? ' style="height: 40px;" ' : ' ' ?>><a style="white-space: normal" href="shop-product-detail.php?prod=<?= $itemMV['prod_id'] ?>"><?= $itemMV['nombre'] ?></a></h6>
                                                        <?php if ((!is_null($itemMV['precio_ofertaa']))) : ?>
                                                            <div style="font-size: 13px;" class="product_price">
                                                                <span class="price">$<?= $itemMV['precio_ofertaa'] ?></span>
                                                                <del>$<?= $precioProd ?></del>
                                                                <div class="on_sale">
                                                                    <span>Ahorre $<?= $ahorro ?></span>
                                                                </div>
                                                                <br>
                                                                <span class="price">S/. <?= $precioCambio ?></span>
                                                                <del><span> S/. <?php echo $precioProdSol; ?></span></del>
                                                            </div>







                                                        <?php else : ?>
                                                            <div class="product_price">
                                                                <span class="price">$<?= $precioProd ?></span>
                                                                <span> <strong>S/. <?php echo $precioCambio; ?></strong></span>
                                                                <!--div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="rating_wrap">

                                                            <span class="rating_num"><strong>Stock: <a href="javascript:void(0)"><?php
                                                                                                                                    if ($itemMV['stock'] == 0) {
                                                                                                                                        echo "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                                                                                                    } elseif ($itemMV['stock'] > 10) {
                                                                                                                                        echo "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                                                                                                    } else {
                                                                                                                                        echo  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($itemMV['stock'], 0, '.', ',') . " en Stock</span>";
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
                                    <?php     }
                                    ?>




                                </div>
                            </div>
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
                        <div class="client_logo carousel_slider owl-carousel owl-theme nav_style3" data-dots="false" data-nav="true" data-margin="30" data-loop="true" data-autoplay="true" data-responsive='{"0":{"items": "2"}, "480":{"items": "3"}, "767":{"items": "4"}, "991":{"items": "5"}, "1199":{"items": "6"}}'>
                            <?php
                            foreach ($listaMarcas as $rowMarc) {
                                if (strlen($rowMarc['imagen']) > 0) {
                            ?>
                                    <div class="item">
                                        <div class="cl_logo">
                                            <a href="shop-list-prod-mac.php?marc=<?= $rowMarc['cod_marca'] ?>"><img src="../public/img/marcas/<?= $rowMarc['imagen'] ?>" alt="cl_logo" /></a>
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

        <!-- START SECTION SHOP -->
        <div class="section pt-0 pb_20">
            <div class="custom-container">
                <div class="row">

                    <?php
                    foreach ($listaRamByCat as $rowBC) {

                        $contadorBC = 0;
                        $rowHTMLPOR1 = "";
                        $rowHTMLPOR2 = "";
                        foreach ($rowBC['productos'] as $rowProBC) {

                            $precioProd =  number_format($rowProBC['precio'], 2, '.', ',');
                            $ahorroPR = $rowProBC['precio'] - $rowProBC['precio_ofertaa'];
                            $precioProdCambio =  number_format($rowProBC['precio'] * $tc, 2, '.', ',');


                            $precioFRealSol = number_format($rowProBC['precio_ofertaa'] * $tc, 2, '.', ',');
                            $precioFormatSol = number_format($rowProBC['precio'] * $tc, 2, '.', ',');
                            $ahorroPRSol = number_format($ahorroPR * $tc, 2, '.', ',');
                            $temp_stock = "";
                            if ($rowProBC['stock'] > 0) {
                                if ($rowProBC['stock'] == 0) {
                                    $temp_stock = "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                }
                                if ($rowProBC['stock'] > 10) {
                                    $temp_stock = "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                } else {
                                    $temp_stock =  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($rowProBC['stock'], 0, '.', ',') . " en Stock</span>";
                                }
                                $temp_stock = "<strong>Stock: <a href=\"javascript:void(0)\">" . $temp_stock . "</a></strong>";

                                // echo $contadorBC."    ---------------------    ";

                                if ($contadorBC < 3) {
/*  <h6 class="product_title titulo_prod"><a href="shop-product-detail.php?prod=' . $ofeItem['prod_id'] . '">' . $ofeItem['nombre'] . '</a></h6>
                                                    <div class="product_price">
                                                        <span class="price">$' . $ofeItem['precio_oferta'] . '</span>
                                                        <del>$' . $precioFormat . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra $' . $ahorroPR . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="product_price">
                                                        <span class="price">S/. ' . $precioFRealSol . '</span>
                                                        <del>S/.' . $precioFormatSol . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra S/. ' . $ahorroPRSol . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="rating_wrap">
                                                        
                                                        <span class="rating_num">' . $temp_stock . '</span>
                                                    </div>
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                </div> */
                                    if (!is_null($rowProBC['precio_ofertaa'])) {
                                        $rowHTMLPOR1 = $rowHTMLPOR1 . '<div class="product_wrap"> <div class="product_img">
                                        <a href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">
                                            <img src="../public/img/productos/' . $rowProBC['imagen1'] . '" alt="el_img7">
                                            <img class="product_hover_img" src="../public/img/productos/' . $rowProBC['imagen2'] . '" alt="el_hover_img7">
                                        </a>
                                    </div>

                                    <div class="product_info">
                                    <h6 class="product_title titulo_prod" ><a href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">' . $rowProBC['nombre'] . '</a></h6>
                                    <div class="product_price mt-4">

                                            <span class="price">$' . $rowProBC['precio_ofertaa'] . '</span>
                                                <del>$' . $precioProd . '</del>
                                        <div class="on_sale">
                                                <span>Ahorra $' . $ahorroPR . '</span>
                                        </div>
                                    </div>
                                    
                                    <div class="product_price">
                                            <span class="price">S/. ' . $precioFRealSol . '</span>
                                            <del>S/.' . $precioFormatSol . '</del>
                                        <div class="on_sale">
                                            <span>Ahorra S/. ' . $ahorroPRSol . '</span>
                                        </div>
                                    </div>
                                

                                    <div class="rating_wrap">
                                         
                                        <span class="rating_num" style="margin-left:0">' . $temp_stock . '</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p></p>
                                    </div>
                                </div>
                                </div>
                                    ';
                                    } else {
                                        $rowHTMLPOR1 = $rowHTMLPOR1 . '<div class="product_wrap">
                                        <div class="product_img">
                                            <a href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">
                                                <img src="../public/img/productos/' . $rowProBC['imagen1'] . '" alt="el_img7">
                                                <img class="product_hover_img" src="../public/img/productos/' . $rowProBC['imagen2'] . '" alt="el_hover_img7">
                                            </a>
                                        </div>
                                        <div class="product_info">
                                            <h6 class="product_title titulo_prod" ><a href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">' . $rowProBC['nombre'] . '</a></h6>
                                            <div class="product_price">
                                                <span class="price">$' . $precioProd . ' </span>
                                                <span class=""><strong> S/. ' . $precioProdCambio . '</strong></span>
                                                
                                            </div>
                                            <div class="rating_wrap">
                                                 
                                                <span class="rating_num">' . $temp_stock . '</span>
                                            </div>
                                            <div class="pr_desc">
                                                <p></p>
                                            </div>
                                        </div>
                                    </div>';
                                    }
                                }/*  else {
                                    $rowHTMLPOR2 = $rowHTMLPOR2 . '<div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">
                                                    <img src="../public/img/productos/' . $rowProBC['imagen1'] . '" alt="el_img7">
                                                    <img class="product_hover_img" src="../public/img/productos/' . $rowProBC['imagen2'] . '" alt="el_hover_img7">
                                                </a>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title titulo_prod" ><a style= href="shop-product-detail.php?prod=' . $rowProBC['prod_id'] . '">' . $rowProBC['nombre'] . '</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$' . $precioProd . '</span>
                                                    
                                                </div>
                                                <div class="rating_wrap">
                                                    
                                                    <span class="rating_num">' . $temp_stock . '</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p></p>
                                                </div>
                                            </div>
                                        </div>';
                                } */
                                $contadorBC++;
                            }
                        }


                    ?>
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="heading_tab_header">
                                        <div class="heading_s2">
                                            <h4><?= $rowBC['nombre'] ?></h4>
                                        </div>
                                        <div class="view_all">
                                            <a href="./shop-list-prod.php?search=+" class="text_default"><span>Ver todo</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                                        <div class="item">
                                            <?= $rowHTMLPOR1 ?>
                                        </div>
                                        <div class="item">
                                            <?= $rowHTMLPOR2 ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="heading_tab_header">
                                    <div class="heading_s2">
                                        <h4>Productos en Oferta</h4>
                                    </div>
                                    <div class="view_all">
                                        <a href="./shop-list-prod-ofertas.php" class="text_default"><span>Ver Todo</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5 owl-loaded owl-drag" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive="{&quot;0&quot;:{&quot;items&quot;: &quot;1&quot;}, &quot;380&quot;:{&quot;items&quot;: &quot;1&quot;}, &quot;640&quot;:{&quot;items&quot;: &quot;2&quot;}, &quot;991&quot;:{&quot;items&quot;: &quot;1&quot;}}">


                                    <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(-1080px, 0px, 0px); transition: all 0s ease 0s; width: 3240px;">


                                            <?php
                                            $htmlEXOFER = '';

                                            $contadorOFJSJD = 0;
                                            foreach ($listaOfertas as $ofeItem) {
                                                $ahorroPR = $ofeItem['precio'] - $ofeItem['precio_oferta'];
                                                $precioFormat = number_format($ofeItem['precio'], 2, '.', ',');



                                                $precioFRealSol = number_format($ofeItem['precio_oferta'] * $tc, 2, '.', ',');
                                                $precioFormatSol = number_format($ofeItem['precio'] * $tc, 2, '.', ',');
                                                $ahorroPRSol = number_format($ahorroPR * $tc, 2, '.', ',');

                                                $ahorroPR = number_format($ahorroPR, 2, '.', ',');


                                                $temp_stock = "";
                                                if ($ofeItem['stock'] == 0) {
                                                    $temp_stock = "<span style='font-weight: lighter;color: #d70000'>Sin Stock</span>";
                                                } elseif ($ofeItem['stock'] > 10) {
                                                    $temp_stock = "<span style='font-weight: lighter;color: #03ad01'>+ de 10 en Stock</span>";
                                                } else {
                                                    $temp_stock =  "<span style='font-weight: lighter;color: #03ad01'>" . number_format($ofeItem['stock'], 0, '.', ',') . " en Stock</span>";
                                                }
                                                $temp_stock = "<strong>Stock: <a href=\"javascript:void(0)\">" . $temp_stock . "</a></strong>";


                                                if ($contadorOFJSJD == 0) {
                                                    $htmlEXOFER = $htmlEXOFER . '<div class="owl-item cloned" style="width: 520px; margin-right: 20px;">
                                        <div class="item">';
                                                }


                                                if ($contadorOFJSJD == 2) {
                                                    $htmlEXOFER  = $htmlEXOFER . '<div class="product_wrap">
                                                <div class="product_img">
                                                    <a href="shop-product-detail.php?prod=' . $ofeItem['prod_id'] . '">
                                                       
                                                        <img  style="" src="../public/img/productos/' . $ofeItem['imagen1'] . '" alt="el_img3">
                                                        <img  class="product_hover_img" src="../public/img/productos/' . $ofeItem['imagen2'] . '" alt="el_hover_img3">
                                                    </a>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title titulo_prod"><a href="shop-product-detail.php?prod=' . $ofeItem['prod_id'] . '">' . $ofeItem['nombre'] . '</a></h6>
                                                    <div class="product_price">
                                                        <span class="price">$' . $ofeItem['precio_oferta'] . '</span>
                                                        <del>$' . $precioFormat . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra $' . $ahorroPR . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="product_price">
                                                        <span class="price">S/. ' . $precioFRealSol . '</span>
                                                        <del>S/.' . $precioFormatSol . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra S/. ' . $ahorroPRSol . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="rating_wrap">
                                                        
                                                        <span class="rating_num">' . $temp_stock . '</span>
                                                    </div>
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>';
                                                    $htmlEXOFER = $htmlEXOFER . '    </div> </div>';
                                                    $contadorOFJSJD = 0;
                                                } else {
                                                    $htmlEXOFER  = $htmlEXOFER . '<div class="product_wrap">
                                                <div class="product_img">
                                                    <a href="shop-product-detail.php?prod=' . $ofeItem['prod_id'] . '">
                                                       
                                                        <img  style="" src="../public/img/productos/' . $ofeItem['imagen1'] . '" alt="el_img3">
                                                        <img  class="product_hover_img" src="../public/img/productos/' . $ofeItem['imagen2'] . '" alt="el_hover_img3">
                                                    </a>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title titulo_prod"><a href="shop-product-detail.php?prod=' . $ofeItem['prod_id'] . '">' . $ofeItem['nombre'] . '</a></h6>
                                                    <div class="product_price">
                                                        <span class="price">$' . $ofeItem['precio_oferta'] . '</span>
                                                        <del>$' . $precioFormat . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra $' . $ahorroPR . '</span>
                                                        </div>
                                                    </div>
                                                     <div class="product_price">
                                                        <span class="price">S/. ' . $precioFRealSol . '</span>
                                                        <del>S/.' . $precioFormatSol . '</del>
                                                        <div class="on_sale">
                                                            <span>Ahorra S/. ' . $ahorroPRSol . '</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="rating_wrap">
                                                       
                                                        <span class="rating_num">' . $temp_stock . '</span>
                                                    </div>
                                                    <div class="pr_desc">
                                                        <p></p>
                                                    </div>
                                                </div>
                                            </div>';
                                                    $contadorOFJSJD++;
                                                }
                                            }
                                            if ($contadorOFJSJD > 0) {
                                                $htmlEXOFER = $htmlEXOFER . '    </div> </div>';
                                            }
                                            ?>



                                            <?= $htmlEXOFER ?>



                                        </div>
                                    </div>
                                    <div class="owl-nav">
                                        <button type="button" role="presentation" class="owl-prev"><i class="ion-ios-arrow-left"></i></button>
                                        <button type="button" role="presentation" class="owl-next"><i class="ion-ios-arrow-right"></i></button>
                                    </div>
                                    <div class="owl-dots disabled"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->

        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb">
            <div class="custom-container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="newsletter_text text_white">
                            <h3>Unete a La Mejor Empresa en Productos GAMING</h3>
                            <p> Registrate para recibir Nuestras PROMOCIONES. </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter_form2 rounded_input">
                            <form id="formPromociones">
                                <input type="email" required name="emailRegistrar" id="emailRegistrar" class="form-control" placeholder="Ingresa tu Email">
                                <button type="button" class="btn btn-dark btn-radius" id="btnRegistrar">Suscribete</button>
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
    <footer class="bg_gray">
        <div class="footer_top small_pt pb_20">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="widget">
                            <div class="footer_logo">
                                <a href="./"><img src="../public/assets/images/cym.png" alt="logo" /></a>
                            </div>
                            <p class="mb-3">Empresa Reconocida en Productos GAMING</p>
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
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="widget">
                            <h6 class="widget_title">Productos</h6>
                            <ul class="widget_links">
                                <li><a href="./shop-list-ctg.php?ctg=005">Tarjeta de Video</a></li>
                                <li><a href="./shop-list-ctg.php?ctg=001">Procesadores</a></li>
                                <li><a href="./shop-list-ctg.php?ctg=010">Monitores</a></li>
                                <li><a href="./shop-list-ctg.php?ctg=002">Placa Madre</a></li>
                                <li><a href="./shop-list-ctg.php?ctg=012-014">Mouse</a></li>
                                <li><a href="./shop-list-ctg.php?ctg=012-014">Teclado</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="widget">

                            <ul class="widget_instafeed instafeed_col4">
                                <?php foreach ($listaRamTendenInstagram as $val) :
                                    /*    var_dump($val); */
                                ?>
                                    <li><a href="shop-product-detail.php?prod=<?= $val['prod_id'] ?>"><img src="../public/img/productos/<?php echo $val['imagen1'] ?>" alt="insta_img"><span class="insta_icon"></span></a></li>
                                <?php endforeach; ?>
                            </ul>
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
                                <div class="col-md-4">
                                    <div class="icon_box icon_box_style2">
                                        <div class="icon">
                                            <i class="flaticon-shipped"></i>
                                        </div>
                                        <div class="icon_box_content">
                                            <h5>Consultar Nuestro Delivery</h5>
                                            <p>Contamos con todos los Protocolos de Bioseguridad</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="icon_box icon_box_style2">
                                        <div class="icon">
                                            <i class="flaticon-money-back"></i>
                                        </div>
                                        <div class="icon_box_content">
                                            <h5>Todos Nuestros Productos Incluyen Garantía</h5>
                                            <p>Siempre Guarde su Boleta o Factura de Compra</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="icon_box icon_box_style2">
                                        <div class="icon">
                                            <i class="flaticon-support"></i>
                                        </div>
                                        <div class="icon_box_content">
                                            <h5>Contamos con Nuestro Soporte Técnico</h5>
                                            <p>Pueden Traer su Ordenador Con Nosotros</p>
                                        </div>
                                    </div>
                                </div>
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
                        <p class="mb-lg-0 text-center">© <?= date('Y') ?> Todos los derechos reservados por <a target="_blank" href="https://magustechnologies.com/"><strong>MAGUS TECHNOLOGIES</strong></a> </p>
                    </div>
                    <div class="col-lg-4 order-lg-first">
                        <div class="widget mb-lg-0">
                            <ul class="social_icons text-center text-lg-left">

                                <li><a href="<?= $dataConf['redessociales']['facebook'] ?>" class="sc_facebook"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['twitter'] ?>" class="sc_twitter"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['google_plus'] ?>" class="sc_google"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['youtube'] ?>" class="sc_youtube"><i class="ion-social-youtube-outline"></i></a></li>
                                <li><a href="<?= $dataConf['redessociales']['instagram'] ?>" class="sc_instagram"><i class="ion-social-instagram-outline"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <ul class="footer_payment text-center text-lg-right">
                            <li><a href="#"><img src="../public/assets/images/visa.png" alt="visa"></a></li>
                            <li><a href="#"><img src="../public/assets/images/discover.png" alt="discover"></a></li>
                            <li><a href="#"><img src="../public/assets/images/master_card.png" alt="master_card"></a></li>
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
            background-color: #1094f4;
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
            background-color: #1094f4;
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
            background-color: #1094f4;
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
            background-color: #1094f4;
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
            background-color: #1094f4;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }
    </style>
    <a href="https://m.me/<?= $dataConf['redessociales']['id_facebook'] ?>" id="botn_facebook" class="<?= $body_class == 'desktop' ? 'float2' : 'float2m' ?>" target="_blank">
        <img style="max-width: 37px;" src="../public/facebook-messenger-brands.svg" class="my-float"></img>
    </a>
    <span href=" " id="botn_telegram" class="<?= $body_class == 'desktop' ? 'float3' : 'float3m' ?>" target="_blank">
        <img style="max-width: 37px;" src="../public/telegram_ico.png" class="my-float"></img>
    </span>

    <div style="display: none" class="<?= $body_class == 'desktop' ? 'contenedor_telegram' : 'contenedor_telegramM' ?> apertura_what">
        <div style="width: 100%;text-align: center">
            <h4 style="color: #009237">¿Con quien quieres hablar?</h4>
        </div>
        <div class="contenedor_inferior" style="">
            <?php

            $dia = date('w');
            $hora = date('g');
            $modo = date('A');
            //echo  $dia . "<>".$hora.'<>'.$modo;
            foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
                if ($whats['estado']) {
                    if (isset($whats['dia1']) && isset($whats['dia2']) && isset($whats['hora2']) && isset($whats['hora1']) && isset($whats['hora2']) && isset($whats['hora1'])) {
                        $val1 = $whats['dia1'] <= $dia || $whats['dia2'] >= $dia;
                        $val2 = false;

                        if ($whats['modo1'] == "AM" && $whats['modo2'] == "PM") {
                            // echo "modo1<br>";
                            if ($modo == $whats['modo1']) {
                                $val2 = $whats['hora1'] <= $hora;
                            } elseif ($modo == $whats['modo2']) {
                                $val2 = $whats['hora2'] > $hora;
                            }
                        } elseif ($whats['modo1'] == "PM" && $whats['modo2'] == "AM") {
                            if ($modo == $whats['modo1']) {
                                $val2 = $whats['hora1'] <= $hora;
                            } elseif ($modo == $whats['modo2']) {
                                $val2 = $whats['hora2'] > $hora;
                            }
                        }

                        if ($hora . ':' . $modo == '12:PM') {
                            $val2 = !$val2;
                        } elseif ($hora . ':' . $modo == '12:AM') {
                            $val2 = !$val2;
                        }

                        //echo ($val1?'a':'b')."<>". ($val2?'a':'b');


                        if ($val1 && $val2) {

                            echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
                        <a target="_blank" href="https://t.me/' . str_replace(' ', '', $whats['nombre']) . '">
                            <i class="btn-icon2 " style="float: left; margin-right: 5px;" >  </i>
                            <div style="float: left">
                                 <strong>' . $whats['nombre'] . '</strong> 
                            </div>
                        </a>
                    </div>';
                        }
                    } else {
                        echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
            <a target="_blank" href="https://t.me/' . str_replace(' ', '', $whats['nombre']) . '">
                <i  class="btn-icon2 " style="float: left; margin-right: 5px;"> </i> 
                <div style="float: left">
                     <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                </div>
            </a>
        </div>';
                    }
                }
            }
            ?>

        </div>
    </div>

    <div style="display: none" class="contenedor_wapsa apertura_what">
        <div style="width: 100%;text-align: center">
            <h4 style="color: #009237">¿Con quien quieres hablar?</h4>
        </div>
        <div class="contenedor_inferior" style="">
            <?php

            $dia = date('w');
            $hora = date('g');
            $modo = date('A');
            //echo  $dia . "<>".$hora.'<>'.$modo;
            foreach ($dataConf['redessociales']['whatsapp'] as $whats) {
                if ($whats['estado']) {
                    if (isset($whats['dia1']) && isset($whats['dia2']) && isset($whats['hora2']) && isset($whats['hora1']) && isset($whats['hora2']) && isset($whats['hora1'])) {
                        $val1 = $whats['dia1'] <= $dia || $whats['dia2'] >= $dia;
                        $val2 = false;

                        if ($whats['modo1'] == "AM" && $whats['modo2'] == "PM") {
                            // echo "modo1<br>";
                            if ($modo == $whats['modo1']) {
                                $val2 = $whats['hora1'] <= $hora;
                            } elseif ($modo == $whats['modo2']) {
                                $val2 = $whats['hora2'] > $hora;
                            }
                        } elseif ($whats['modo1'] == "PM" && $whats['modo2'] == "AM") {
                            if ($modo == $whats['modo1']) {
                                $val2 = $whats['hora1'] <= $hora;
                            } elseif ($modo == $whats['modo2']) {
                                $val2 = $whats['hora2'] > $hora;
                            }
                        }

                        if ($hora . ':' . $modo == '12:PM') {
                            $val2 = !$val2;
                        } elseif ($hora . ':' . $modo == '12:AM') {
                            $val2 = !$val2;
                        }

                        //echo ($val1?'a':'b')."<>". ($val2?'a':'b');


                        if ($val1 && $val2) {

                            echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
                        <a target="_blank" href="https://api.whatsapp.com/send?phone=' . $whats['numero'] . '&text=' . $whats['mensaje'] . '">
                            <i  class="btn-icon fa fa-whatsapp" style="float: left; margin-right: 5px;"> </i> 
                            <div style="float: left">
                                 <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                            </div>
                        </a>
                    </div>';
                        }
                    } else {
                        echo '<div style="width: 100%;height: 50px;margin-bottom: 3px;">
            <a target="_blank" href="https://api.whatsapp.com/send?phone=' . $whats['numero'] . '&text=' . $whats['mensaje'] . '">
                <i  class="btn-icon fa fa-whatsapp" style="float: left; margin-right: 5px;"> </i> 
                <div style="float: left">
                     <strong>' . $whats['nombre'] . '</strong><br>' . $whats['numero'] . '
                </div>
            </a>
        </div>';
                    }
                }
            }
            ?>

        </div>
    </div>
    <span id="botn_whapsa" class="<?= $body_class == 'desktop' ? 'float' : 'floatm' ?>" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </span>






    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <!-- Latest jQuery -->
    <script src="../public/assets/js/jquery-1.12.4.min.js"></script>
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
    <script src="../public/js/main.js?v=4"></script>
    <script src="../public/js/tools.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.onload = function() {

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
    </script>

</body>

</html>
