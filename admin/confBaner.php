<?php


session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){



require "../utils/Tools.php";
require "../dao/ProductoDao.php";


$tools = new Tools();
$productoDao = new ProductoDao();

$dataConf = $tools->getConfiguracion();
$listaProd = $productoDao->getListaProd();

$banner_prod_1 = $dataConf['bannerprod1']['image'];
$banner_prod_2 = $dataConf['bannerprod2']['image'];


$ban1_nombre = '';
$ban1_url = $dataConf['banner1']['image'];
$ban1_ide = 'javascript:void(0)';

//echo strlen($dataConf['banner1']['prod']);
if (strlen($dataConf['banner1']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner1']['prod']);
    $respPROB1 = $productoDao->getData2();
    //print_r($respPROB1);
    $ban1_nombre = $respPROB1['nombre'];
    //$ban1_ide:""
}

$ban2_nombre = '';
$ban2_url = $dataConf['banner2']['image'];
$ban2_ide = 'javascript:void(0)';

if (strlen($dataConf['banner2']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner2']['prod']);
    $respPROB2 = $productoDao->getData2();
    //print_r($respPROB1);
    $ban2_nombre = $respPROB2['nombre'];
    //$ban1_ide:""
}

$banerCimg1 = $dataConf['banercentarl1']['image'];
$banerCprod1 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl1']['prod']) > 0) {
    $banerCprod1 = '';
}

$banerCimg2 = $dataConf['banercentarl2']['image'];
$banerCprod2 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl2']['prod']) > 0) {
    $banerCprod2 = '';
}

$banerCimg3 = $dataConf['banercentarl3']['image'];
$banerCprod3 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl3']['prod']) > 0) {
    $banerCprod3 = '';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
    <meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">
    <title>VIÑASANTODOMINGO</title>
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
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <style>
        .contenendorBanes {
            background-color: #dedede;
            height: 500px;
            overflow: auto;
            padding: 5px;
        }

        .box-banerr {
            background-color: #ffffff;
            border: 1px solid #868686;
            border-radius: 10px;
            height: 230px;
            padding: 5px;
            padding-top: 10px;
        }

        .box-banerr:hover {
            -webkit-box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            cursor: pointer;
        }

        .bodNeutral {
            float: left;
            margin-bottom: 15px;
        }
    </style>

</head>


<body>

    <!-- LOADER -->
    <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- END LOADER -->

    <!-- Home Popup Section -->

    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <?php include "../fragment/nav_bar_admin.php" ?>
    <!-- END HEADER -->
    <script>
        function guardarWhatsapp() {
            const what = $("#linkwhatsapp-config").val();
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_configuracione.php",
                data: {
                    tipo: 'whatsapp',
                    link: what
                },
                success: function(ressss) {
                    console.log(ressss)
                    $('#whatsapp-modal').modal('hide');
                }
            });
        }
    </script>
    <!-- Modal -->
    <div class="modal fade" id="whatsapp-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Link WhatsApp</label>
                        <input type="text" value="<?= $dataConf['whatsapp'] ?>" class="form-control" id="linkwhatsapp-config" aria-describedby="emailHelp" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="guardarWhatsapp()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- START SECTION BREADCRUMB -->
    <div class="mt-4 staggered-animation-wrap">
        <div class="custom-container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Banner Principal</h3>
                        </div>
                        <div class="col-md-12">
                            <a href="banner_principal.php" class="form-control btn btn-primary">Editar Banner</a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-md-12">
                            <h3>Banner Lateral</h3>
                        </div>
                        <div class="col-md-12">
                            <button data-toggle="modal" data-target="#baner1" type="button" class="form-control btn btn-primary">Editar Banner 1</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px;">
                            <button data-toggle="modal" data-target="#baner2" type="button" class="form-control btn btn-primary">Editar Banner 2</button>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px;">
                            <a href="banner_lateral_6.php" class="form-control btn btn-primary">Editar Banner 6</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner_section shop_el_slider">
                        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
                            <div class="carousel-inner">

                                <?php
                                $countBan = 1;
                                foreach ($dataConf['banner_pricipal'] as $rowBan) {

                                ?>
                                    <div class="carousel-item <?= ($countBan == 1) ? 'active' : '' ?> background_bg" data-img-src="../public/img/banner/<?= $rowBan['imagen'] ?>">
                                        <div class="banner_slide_content banner_content_inner">
                                            <div class="col-lg-7 col-10">
                                                <div class="banner_content3 overflow-hidden">
                                                    <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s"><?= $rowBan['titulo_peque'] ?></h5>
                                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s"><?= $rowBan['titulo'] ?></h2>
                                                    <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s"><?= $rowBan['parrafo'] ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    $countBan++;
                                }
                                ?>



                            </div>
                            <ol class="carousel-indicators indicators_style3">
                                <?php
                                $countIDRFF = 0;
                                foreach ($dataConf['banner_pricipal'] as $rowBan) {
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

                            <div class=" ">
                                <img src="../public/img/banner/<?= $ban1_url ?>" alt="shop_banner_img6">
                            </div>
                        </a>
                    </div>
                    <div class="shop_banner2 el_banner2">
                        <a href="<?= $ban2_ide ?>" class="hover_effect1" style="padding: 0px;">

                            <div class=" ">
                                <img src="../public/img/banner/<?= $ban2_url ?>" alt="shop_banner_img7">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content" style="margin-top: 40px">

        <div class="col-md-12 ">
            <div class="row  justify-content-md-center">
                <h3>Banner Inferior (Seccion abajo de productos exclusivos)</h3>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row  justify-content-md-center">
                <div class="row">
                    <div class="col-md-12">
                        <a href="banner_inferior.php" class="form-control btn btn-primary">Editar Banner inferior</a>
                    </div>
                </div>
            </div>
        </div>

        <!--   <div class="section pb_20 small_pt">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-12 text-center" style="margin-bottom: 5px;">
                            <button data-toggle="modal" data-target="#baner1Central" onclick="eliminarBaner1Infecrior()" class="btn btn-info"><i class="fa fa-edit"></i></button>
                        </div>
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="javascript:void(0)">
                                <img src="../public/img/banner/<?= $banerCimg1 ?>" alt="shop_banner_img7">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 text-center" style="margin-bottom: 5px;">
                            <button data-toggle="modal" data-target="#baner2Central" onclick="eliminarBaner1Infecrior()" class="btn btn-info"><i class="fa fa-edit"></i></button>
                        </div>
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="javascript:void(0)">
                                <img src="../public/img/banner/<?= $banerCimg2 ?>" alt="shop_banner_img8">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-md-12 text-center" style="margin-bottom: 5px;">
                            <button data-toggle="modal" data-target="#baner3Central" onclick="eliminarBaner1Infecrior()" class="btn btn-info"><i class="fa fa-edit"></i></button>
                        </div>
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="javascript:void(0)">
                                <img src="../public/img/banner/<?= $banerCimg3 ?>" alt="shop_banner_img9">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->


    </div>
    <div class="container" style="margin-top: 40px">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>Banner Extra (Seccion  de Productos en Remate)</h3>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-5">
        <div class="row  justify-content-md-center">
            <div class="row">
                <div class="col-md-12">
                    <a href="banner_extra_remate.php" class="form-control btn btn-primary">Editar Banner Extra</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 40px">
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>Banner Extra (Seccion al lado de Productos en tendencia)</h3>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-5">
        <div class="row  justify-content-md-center">
            <div class="row">
                <div class="col-md-12">
                    <a href="banner_extra.php" class="form-control btn btn-primary">Editar Banner Extra</a>
                </div>
            </div>
        </div>
    </div>
<!-- 
    <div class="section small_pt pb-0">
        <div class="custom-container">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="sale-banner">
                        <a class="hover_effect1" href="javascript:void(0)">
                            <img src="../public/img/banner/<?= $banner_prod_1 ?>" alt="shop_banner_img6">
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 d-none d-xl-block">
                    <button data-toggle="modal" data-target="#baner1editar" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</button>
                    <br>
                    <p>Dimenciones recomendables para el banner en pixeles es: <strong>385 x 535</strong></p>
                </div>
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="sale-banner">
                        <a class="hover_effect1" href="javascript:void(0)">
                            <img src="../public/img/banner/<?= $banner_prod_2 ?>" alt="shop_banner_img6">
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 d-none d-xl-block">
                    <button data-toggle="modal" data-target="#baner2editar" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</button>
                    <br>
                    <p>Dimenciones recomendables para el banner en pixeles es: <strong>385 x 535</strong></p>
                </div>
            </div>
        </div>
    </div>
 -->

    <div class="modal fade" id="baner1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner1" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prod1">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner1').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner1" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBaner1()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="baner1Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner1i" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prodBi1">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner1i').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner1i" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBanerC1()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="baner2Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner2i" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prodBi2">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner2i').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner2i" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBanerC2()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="baner3Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner3i" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prodBi3">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner3i').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner3i" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBanerC3()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="baner2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner2" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner2').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner2" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBaner2()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>





    <div class="modal fade" id="baner1editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 1</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner1iprod" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prodBi1prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner1iprod').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner1iproddd" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBanerC1prod()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="baner2editar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Banner 2</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input accept="image/*" id="fill_img_banner2iprod" type="file" style="display: none">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                        <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod" id="recipient-name-prodBi2prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Banner:</label>
                        <div class="col-md-12 text-center">
                            <button onclick="$('#fill_img_banner2iprod').click()" class="btn btn-primary">Seleccionar Banner</button>
                        </div>
                        <div class="col-md-12 text-center">
                            <img id="imagen_baner2iproddd" style="display: block;margin: auto;max-height: 450px;" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button onclick="guardarBanerC2prod()" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modal_listaProduc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style=" max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliga el producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Lista de productos</label>
                    </div>
                    <div class="form-group">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoria</th>
                                    <th>Marca</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($listaProd as $row) {       ?>
                                    <tr>
                                        <td id="nom_<?= $row['prod_id'] ?>"><?= $row['nom_prod'] ?></td>
                                        <td><?= $row['categoria'] ?></td>
                                        <td><?= $row['marca'] ?></td>
                                        <td><?= $row['stock'] ?></td>
                                        <td><?= $row['precio'] ?></td>
                                        <td><button onclick="selectProducto(<?= $row['prod_id'] ?>)" style="padding: 10px;padding-left: 15px;" class="btn btn-info"><i class="fa fa-edit"></i></button></td>
                                    </tr>
                                <?php    }

                                ?>


                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- END MAIN CONTENT -->

    <!-- START FOOTER -->
    <footer class="footer_dark">
        <div class="footer_top">
            <div class="container">
                <div class="row">

                </div>
            </div>
        </div>
        <div class="bottom_footer border-top-tran">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-md-0 text-center text-md-left">© 2024 Todos los derechos reservados por <a target="_blank" href="https://magustechnologies.com/">
                                    <strong>MAGUS TECHNOLOGIES</strong>
                                </a></p>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
        </div>
    </footer>
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <input id="id_prod" type="hidden">
</body>
<script>
    function guardarBanerC1prod() {
        if ($("#fill_img_banner1iprod").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner1iprod")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner1_prod',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner1').modal('hide');
                            $("#fill_img_banner1iprod").val("")
                            //$("#imagen_baner1").attr("src","../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }
    }

    function guardarBanerC2prod() {
        if ($("#fill_img_banner2iprod").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner2iprod")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner2_prod',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner1').modal('hide');
                            $("#fill_img_banner2iprod").val("")
                            //$("#imagen_baner1").attr("src","../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }
    }


    function guardarBanerC1() {
        if ($("#fill_img_banner1i").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner1i")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner1cen',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner1').modal('hide');
                            $("#fill_img_banner1").val("")
                            //$("#imagen_baner1").attr("src","../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }
    }


    function guardarBanerC2() {
        if ($("#fill_img_banner2i").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner2i")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner2cen',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner2').modal('hide');
                            $("#fill_img_banner2").val("")
                            //$("#imagen_baner1").attr("src","../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }
    }

    function guardarBanerC3() {
        if ($("#fill_img_banner3i").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner3i")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner3cen',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner2').modal('hide');
                            $("#fill_img_banner3").val("")
                            //$("#imagen_baner1").attr("src","../public/img/banner/sinimagen_menu_20sba.jpg")
                            //location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }
    }

    function eliminarBaner1Infecrior() {

    }

    function guardarBaner1() {
        if ($("#fill_img_banner1").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner1")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner1',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner1').modal('hide');
                            $("#fill_img_banner1").val("")
                            $("#imagen_baner1").attr("src", "../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }

    }

    function guardarBaner2() {
        if ($("#fill_img_banner2").val().length > 0) {
            var fd = new FormData();
            fd.append('file', $("#fill_img_banner2")[0].files[0]);
            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            //var percentComplete = ((evt.loaded / evt.total) * 100);
                            //APP._data.progreso=percentComplete;
                        }
                    }, false);
                    return xhr;
                },
                type: 'POST',
                url: '../ajax/upload_img_banner.php',
                data: fd,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    console.log('inicio');
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    console.log(resp);
                    resp = JSON.parse(resp);
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_configuracione.php",
                        data: {
                            tipo: 'banner2',
                            prod: $("#id_prod").val(),
                            imagen: resp.dstos
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#baner2').modal('hide');
                            $("#fill_img_banner2").val("")
                            $("#imagen_baner2").attr("src", "../public/img/banner/sinimagen_menu_20sba.jpg")
                            location.reload();
                            //APP.getData();
                        }
                    });


                }
            });
        }

    }

    function selectProducto(ide) {
        $("#id_prod").val(ide);
        $(".recipient-name-prod").val($("#nom_" + ide).text());
        $('#modal_listaProduc').modal('hide');
    }

    function seImgFil(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner1').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil1i(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner1i').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil2i(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner2i').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil3i(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner3i').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil2(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner2').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil1extra(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner1iproddd').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }


    function seImgFil2extra(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagen_baner2iproddd').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }


    $(document).ready(function() {

        // APP_BANN.getBanerPrincipal();
        $("#fill_img_banner2iprod").change(function() {
            if (this.files && this.files[0]) {
                seImgFil2extra(this.files[0])

            }
        });

        $("#fill_img_banner1iprod").change(function() {
            if (this.files && this.files[0]) {
                seImgFil1extra(this.files[0])

            }
        });

        $("#fill_img_banner1").change(function() {
            if (this.files && this.files[0]) {
                seImgFil(this.files[0])

            }
        });
        $("#fill_img_banner1i").change(function() {
            if (this.files && this.files[0]) {
                seImgFil1i(this.files[0])

            }
        });
        $("#fill_img_banner2i").change(function() {
            if (this.files && this.files[0]) {
                seImgFil2i(this.files[0])

            }
        });
        $("#fill_img_banner3i").change(function() {
            if (this.files && this.files[0]) {
                seImgFil3i(this.files[0])

            }
        });
        $("#fill_img_banner2").change(function() {
            if (this.files && this.files[0]) {
                seImgFil2(this.files[0])

            }
        });

        $(".recipient-name-prod").focus(function() {
            $('#modal_listaProduc').modal('show');
        })


        $('#example').DataTable({
            language: {
                url: '../utils/Spanish.json'
            }
        });
    });
</script>

</html>

<?php } else {
    header("Location: ../CYM/");
}
?>
