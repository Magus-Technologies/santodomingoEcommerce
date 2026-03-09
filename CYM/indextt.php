<?php
require "../utils/Tools.php";
require "../dao/NuevoImgresoDao.php";
require "../dao/GrupoCategoriaDao.php";

$grupoCategoriaDao = new GrupoCategoriaDao();
$nuevoImgresoDao= new NuevoImgresoDao();
$tools = new Tools();


$listaGrupos =$grupoCategoriaDao->getListaCate();
$listaNue = $nuevoImgresoDao->getLista();

$dataConf = $tools->getConfiguracion();
print_r($listaGrupos);

?><!DOCTYPE html>
<html lang="es"><head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
<meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

<!-- SITE TITLE -->
<title>CGS-COMPUTER</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="../public/images/favicon.png">
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

<!-- Home Popup Section
<div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row no-gutters">
                    <div class="col-sm-7">
                        <div class="popup_content text-left">
                            <div class="popup-text">
                                <div class="heading_s1">
                                    <h3>Dejanos tu Correo Electrónico para enviarte nuestras Ofertas!</h3>
                                </div>
                                <p>Suscribete para mayor Información.</p>
                            </div>
                            <form method="post">
                            	<div class="form-group">
                                	<input name="email" required type="email" class="form-control" placeholder="Ingresa tu Email">
                                </div>
                                <div class="form-group">
                                	<button class="btn btn-fill-out btn-block text-uppercase" title="Subscribe" type="submit">Suscribete</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>No mostrar nuevamente este aviso!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                    	<div class="background_bg h-100" data-img-src="../public/images/silla.jpg"></div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div> -->
<!-- End Screen Load Popup Section --> 

<!-- START HEADER -->
<header class="header_wrap">

    <?php include "../fragment/head_index.php"?>

    <?php include "../fragment/nav_bar_index.php"?>
    <div class="bottom_header dark_skin main_menu_uppercase border-top border-bottom">
    	<div class="custom-container">
            <div class="row"> 
            	<div class="col-lg-3 col-md-4 col-sm-6 col-3">
                	<div class="categories_wrap">
                        <button type="button" data-toggle="collapse" data-target="#navCatContent" aria-expanded="false" class="categories_btn">
                            <i class="linearicons-menu"></i><span>NUESTROS PRODUCTOS GAMING</span>
                        </button>
                        <div id="navCatContent" class="nav_cat navbar collapse">
                            <ul>
                                <?php
                                foreach ($listaGrupos as $catRow){ ?>

                                <?php
                                    if ($catRow['desplegable']==0){   ?>
                                        <li><a class="dropdown-item nav-link nav_item" href="coming-soon.html"> <span><?=$catRow['nombre_grupo'] ?></span></a></li>
                                    <?php      }else{   ?>
                                        <li class="dropdown dropdown-mega-menu">
                                            <a class="dropdown-item nav-link dropdown-toggler" href="#" data-toggle="dropdown"><i class="flaticon-plugins"></i> <span><?=$catRow['nombre_grupo'] ?></span></a>
                                            <div class="dropdown-menu">
                                                <ul class="mega-menu d-lg-flex">
                                                    <li class="mega-menu-col col-lg-7">
                                                        <ul class="d-lg-flex">
                                                            <li class="mega-menu-col col-lg-6">
                                                                <ul>
                                                                    <li class="dropdown-header">Productos</li>
                                                                    <?php
                                                                    foreach ($catRow['categorias'] as $rowCat){ ?>
                                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list-ctg.php?ctg=<?=$rowCat['codi_categoria']?>"><?=$rowCat['nombre']?></a></li>
                                                                    <?php  }
                                                                    ?>

                                                                </ul>
                                                            </li>
                                                            <li class="mega-menu-col col-lg-4">
                                                                <ul>
                                                                    <li class="dropdown-header">MARCAS</li>
                                                                    <?php
                                                                    foreach ($catRow['marcas'] as $rowMar){ ?>
                                                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list-mrc.php?mrc=<?=$rowMar['marca']?>&grp=<?=$catRow['grupo_id']?>"><?=$rowMar['nombre']?></a></li>
                                                                    <?php  }
                                                                    ?>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-5">
                                                        <div class="header-banner2">
                                                            <a href="#"><img src="../public/img/banner/<?=$catRow['imagen'] ?>" alt="menu_banner"></a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    <?php    }

                                }
                                ?>
                                <!--li>
                                	<ul class="more_slide_open">
                                    	<li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html"><i class="flaticon-fax"></i> <span>Fax Machine</span></a></li>
                                        <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.html"><i class="flaticon-mouse"></i> <span>Mouse</span></a></li>
                                    </ul>
                                </li-->
                            </ul>
                            <div class="more_categories">More Categories</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-6 col-9">
                	<nav class="navbar navbar-expand-lg">
                    	<button class="navbar-toggler side_navbar_toggler" type="button" data-toggle="collapse" data-target="#navbarSidetoggle" aria-expanded="false"> 
                            <span class="ion-android-menu"></span>
                        </button>
                        <div class="pr_search_icon">
                            <a href="javascript:void(0);" class="nav-link pr_search_trigger"><i class="linearicons-magnifier"></i></a>
                        </div> 
                        <div class="collapse navbar-collapse mobile_side_menu" id="navbarSidetoggle">
							<ul class="navbar-nav">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Inicio</a>
                                    <div class="dropdown-menu">
                                        <ul> 
                                            <li><a class="dropdown-item nav-link nav_item" href="about.html">Nosotros</a></li> 
                                            <li><a class="dropdown-item nav-link nav_item" href="contact.php">Contactanos</a></li>
                                            
                                        </ul>
                                    </div>   
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Lanzamientos</a>
                                    <div class="dropdown-menu">
                                        <ul> 
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Monitores</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Tarjetas de Video</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Procesadores</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Placa Madre</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Mouse</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Teclado</a></li>
                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Auriculares</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Productos</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-3">
                                                <ul> 
                                                    <li class="dropdown-header">Tarjeta de Video Serie 30</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">VIDEO MSI GEFORCE RTX 3080 </a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">VIDEO GIGABYTE GEFORCE RTX 3080 </a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">VIDEO MSI GEFORCE RTX 3090 VENTUS </a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">VIDEO ZOTAC GEFORCE RTX 3070s</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">VIDEO ZOTAC GEFORCE RTX 3080</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Procesador AMD 5ta. Generación</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Curabitur laoreet</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Vivamus in tortor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Procesador Intel 10º Generación</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Donec vitae facilisis</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Quisque condimentum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Etiam ac rutrum</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Donec vitae ante ante</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Donec porttitor</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <ul>
                                                    <li class="dropdown-header">Periféricos</li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Mouse</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Teclados</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Auriculares</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Memoria Ram</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">Disco Duro</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div class="d-lg-flex menu_banners">
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="../public/images/Exclusivos/ban1.jpg" alt="shop_banner_img7">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="header-banner">
                                                    <div class="sale-banner">
                                                        <a class="hover_effect1" href="#">
                                                            <img src="../public/images/shop_banner_img8.jpg" alt="shop_banner_img8">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Blog</a>
                                    <div class="dropdown-menu dropdown-reverse">
                                        <ul>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Grids</a>
                                                <div class="dropdown-menu">
                                                    <ul> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-four-columns.html">4 columns</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-left-sidebar.html">Left Sidebar</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-right-sidebar.html">right Sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-left-sidebar.html">Standard Left Sidebar</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-standard-right-sidebar.html">Standard right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Masonry</a>
                                                <div class="dropdown-menu">
                                                    <ul> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-three-columns.html">3 columns</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-four-columns.html">4 columns</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-left-sidebar.html">Left Sidebar</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-masonry-right-sidebar.html">right Sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">Single Post</a>
                                                <div class="dropdown-menu">
                                                    <ul> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single.html">Default</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-slider.html">slider post</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-video.html">video post</a></li> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-single-audio.html">audio post</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li>
                                                <a class="dropdown-item menu-link dropdown-toggler" href="#">List</a>
                                                <div class="dropdown-menu">
                                                    <ul> 
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-left-sidebar.html">left sidebar</a></li>
                                                        <li><a class="dropdown-item nav-link nav_item" href="blog-list-right-sidebar.html">right sidebar</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown dropdown-mega-menu">
                                    <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">Ofertas</a>
                                    <div class="dropdown-menu">
                                        <ul class="mega-menu d-lg-flex">
                                            <li class="mega-menu-col col-lg-9">
                                                <ul class="d-lg-flex">
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul> 
                                                            <li class="dropdown-header">Shop Page Layout</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list.html">shop List view</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-left-sidebar.php">shop List Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-list-right-sidebar.html">shop List Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-load-more.html">Shop Load More</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Other Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-cart.php">Cart</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="checkout.php">Checkout</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="my-account.php">My Account</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="wishlist.html">Wishlist</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="compare.html">compare</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="order-completed.php">Order Completed</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="mega-menu-col col-lg-4">
                                                        <ul>
                                                            <li class="dropdown-header">Product Pages</li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail.php">Default</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-left-sidebar.html">Left Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-right-sidebar.html">Right Sidebar</a></li>
                                                            <li><a class="dropdown-item nav-link nav_item" href="shop-product-detail-thumbnails-left.html">Thumbnails Left</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-3">
                                                <div class="header_banner">
                                                    <div class="header_banner_content">
                                                        <div class="shop_banner">
                                                            <div class="banner_img overlay_bg_40">
                                                                <img src="../public/images/shop_banner3.jpg" alt="shop_banner"/>
                                                            </div> 
                                                            <div class="shop_bn_content">
                                                                <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                                <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                                <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li><a class="nav-link nav_item" href="contact.php">Contactanos</a></li>
                            </ul>
                        </div>
                        <div class="contact_phone contact_support">
                            <i class="linearicons-phone-wave"></i>
                            <span>994 009 195</span>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END HEADER -->

<!-- START SECTION BANNER -->
<div class="mt-4 staggered-animation-wrap">
	<div class="custom-container">
    	<div class="row">
        	<div class="col-lg-7 offset-lg-3">
            	<div class="banner_section shop_el_slider">
                    <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active background_bg" data-img-src="../public/images/asus31.png">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-7 col-10">
                                        <div class="banner_content3 overflow-hidden">
                                            <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Estamos en Oferta por Lanzamiento</h5>
                                            <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Video MSI Geforce RTX 3070 Gaming X Trio 8GB</h2>
                                            <h4 class="staggered-animation mb-4 product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">$840.00</span><del>$860.00</del></h4>
                                            <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="../public/images/teros.png">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-8 col-10">
                                        <div class="banner_content3 overflow-hidden">
                                            <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Descuentos Exclusivos</h5>
                                            <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">MONITOR 27 LED TEROS TE-3170N CURVO</h2>
                                            <h4 class="staggered-animation mb-3 mb-sm-4 product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">$199.00</span><del>$210.00</del></h4>
                                            <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item background_bg" data-img-src="../public/images/amd5.png">
                                <div class="banner_slide_content banner_content_inner">
                                    <div class="col-lg-8 col-10">
                                        <div class="banner_content3 overflow-hidden">
                                            <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Vive la Nueva Experiencia de la 5ta. Generación</h5>
                                            <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">CPU AMD RYZEN 5 5600X 6 CORE</h2>
                                            <h4 class="staggered-animation mb-4 product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">$369.00</span><del>$390.25</del></h4>
                                            <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators indicators_style3">
                            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="1"></li>
                            <li data-target="#carouselExampleControls" data-slide-to="2"></li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 d-none d-lg-block">
            	<div class="shop_banner2 el_banner1">
                	<a href="#" class="hover_effect1">
                    	<div class="el_title text_black">
                        	<h6>MB GIGABYTE Z390 MASTER</h6>
                            <span>25% off</span>
                        </div>
                        <div class="el_img">
                			<img src="../public/images/Z390.png" alt="shop_banner_img6">
                        </div>
                    </a>
                </div>
                <div class="shop_banner2 el_banner2">
                	<a href="#" class="hover_effect1">
                		<div class="el_title text_black">
                        	<h6>MONITOR 27 IPS GIGABYTE G27Q</h6>
                            <span><u>Comprar Ahora</u></span>
                        </div>
                        <div class="el_img">
                			<img src="../public/images/giga1.png" alt="shop_banner_img7">
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
                	<a class="hover_effect1" href="#">
                		<img src="../public/images/Exclusivos/case1.jpg" alt="shop_banner_img6">
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
                                        <a class="nav-link" id="sellers-tab" data-toggle="tab" href="#sellers" role="tab" aria-controls="sellers" aria-selected="false">Los mas Vendidos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="featured-tab" data-toggle="tab" href="#featured" role="tab" aria-controls="featured" aria-selected="false">Próximos Ingresos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="special-tab" data-toggle="tab" href="#special" role="tab" aria-controls="special" aria-selected="false">Ofertas Especiales
            </a>
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
                                    foreach ($listaNue as $proN){
                                        $precioProd =  number_format($proN['precio'], 2, '.', ',');

                                        ?>
                                        <div class="item">
                                            <div class="product_wrap">
                                                <?php if ($proN['nuevo'] == 1 ){
                                                    echo '<span class="pr_flash">Nuevo</span>';
                                                } ?>

                                                <div class="product_img">
                                                    <a href="shop-product-detail.php">
                                                        <img  style="max-width: 540px; max-height: 600px;" src="../public/img/productos/<?=$proN['imagen1']?>" alt="el_img3">
                                                        <img  style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/img/productos/<?=$proN['imagen2']?>" alt="el_hover_img3">
                                                        <!--img style="max-width: 540px; max-height: 600px;" src="../public/images/Exclusivos/c_i7.jpg" alt="el_img3">
                                                        <img style="max-width: 540px; max-height: 600px;" class="product_hover_img" src="../public/images/Exclusivos/c_i72.jpg" alt="el_hover_img3"-->
                                                    </a>
                                                    <div class="product_action_box">
                                                        <ul class="list_none pr_action_btn">
                                                            <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                            <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                            <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                            <li><a href="#"><i class="icon-heart"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product_info">
                                                    <h6 class="product_title"><a href="shop-product-detail.php"><?=$proN['nom_prod'] ?></a></h6>
                                                    <div class="product_price">
                                                        <span class="price">$<?=$precioProd?></span>
                                                        <!--del>$510.00</del>
                                                        <div class="on_sale">
                                                            <span>Ahorre $30.00</span>
                                                        </div-->
                                                    </div>
                                                    <div class="rating_wrap">
                                                        <div class="rating">
                                                            <div class="product_rate" style="width:87%"></div>
                                                        </div>
                                                        <span class="rating_num">(25)</span>
                                                    </div>
                                                    <div class="pr_desc">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>


                                </div>
                            </div>
                            <div class="tab-pane fade" id="sellers" role="tabpanel" aria-labelledby="sellers-tab">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/m1.jpg" alt="el_img7">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/m11.jpg" alt="el_hover_img7">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">MOUSE AULA S12 WIRED GAMING 3500DPI USB</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$9.00</span>
                                                    <del>$15.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $6.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <span class="pr_flash bg-danger">Hot</span>
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t2.jpg" alt="el_img8">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t2.jpg" alt="el_hover_img8">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO ANCREU G21 PUNK COLOR FULL USB</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$8.00</span>
                                                    <del>$20.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $12.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:68%"></div>
                                                    </div>
                                                    <span class="rating_num">(15)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/h4.jpg" alt="el_img9">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/h44.jpg" alt="el_hover_img9">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">HEADSET SADES A6 BLACK / ORANGE 7.1 LED PLUG USB</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$23.00</span>
                                                    <del>$35.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $12.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:87%"></div>
                                                    </div>
                                                    <span class="rating_num">(25)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <span class="pr_flash bg-success">Sale</span>
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/h5.jpg" alt="el_img10">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/h55.jpg" alt="el_hover_img10">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">HEADSET AULA S600 BLACK CONECTOR 3.5MM</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$21.00</span>
                                                    <del>$30.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $21.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:87%"></div>
                                                    </div>
                                                    <span class="rating_num">(25)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t5.jpg" alt="el_img11">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t5.jpg" alt="el_hover_img11">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO Y MOUSE ANCREU G21 COMBO COLOR BLACK USB</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$10.00</span>
                                                    <del>$20.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $10.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:70%"></div>
                                                    </div>
                                                    <span class="rating_num">(22)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/h6.jpg" alt="el_img12">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/h66.jpg" alt="el_hover_img12">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">HEADSET SADES SA903 BLACK / RED 7.1 USB+3.5MM</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$22.00</span>
                                                    <del>$35.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $13.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="featured" role="tabpanel" aria-labelledby="featured-tab">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <span class="pr_flash bg-danger">Hot</span>
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t6.jpg" alt="el_img8">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t66.jpg" alt="el_hover_img8">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO MOTOSPEED CK80 BLUE SWITCH MECHANICAL USB MULTIMEDIA RGB SERIES GAMERS</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$45.00</span>
                                                    <del>$70.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $25.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:68%"></div>
                                                    </div>
                                                    <span class="rating_num">(15)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t7.jpg" alt="el_img4">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t77.jpg" alt="el_hover_img4">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO MOTOSPEED K61 RGB KAILH MECHANICAL USB RGB SERIES GAMERS</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$37.00</span>
                                                    <del>$65.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $28.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:70%"></div>
                                                    </div>
                                                    <span class="rating_num">(22)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t8.jpg" alt="el_img11">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t88.jpg" alt="el_hover_img11">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO MOTOSPEED GK82 WIRELESS MECHANICAL MINI USB RECEPTOR BLUE SWITCH</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$35.00</span>
                                                    <del>$55.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre un $20.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:70%"></div>
                                                    </div>
                                                    <span class="rating_num">(22)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/t9.jpg" alt="el_img1">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/t99.jpg" alt="el_hover_img1">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">TECLADO MOTOSPEED K61 RGB OUTEM SWITCH BLUE MECHANICAL USB RGB SERIES GAMERS</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$28.00</span>
                                                    <del>$55.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $27.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/Exclusivos/h7.jpg" alt="el_img7">
                                                    <img class="product_hover_img" src="../public/images/Exclusivos/h7.jpg" alt="el_hover_img7">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">HEADSET F01 PARA PC / PORTATIL/ CELULAR BLUETOOTH</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$13.00</span>
                                                    <del>$18.00</del>
                                                    <div class="on_sale">
                                                        <span>Ahorre Un $5.00</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <span class="pr_flash bg-danger">Hot</span>
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img6.jpg" alt="el_img6">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img6.jpg" alt="el_hover_img6">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Samsung Smart Phone</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$55.00</span>
                                                    <del>$95.00</del>
                                                    <div class="on_sale">
                                                        <span>25% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:68%"></div>
                                                    </div>
                                                    <span class="rating_num">(15)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="special" role="tabpanel" aria-labelledby="special-tab">
                                <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img2.jpg" alt="el_img2">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img2.jpg" alt="el_hover_img2">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Smart Watch External</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$55.00</span>
                                                    <del>$95.00</del>
                                                    <div class="on_sale">
                                                        <span>25% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:68%"></div>
                                                    </div>
                                                    <span class="rating_num">(15)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img5.jpg" alt="el_img5">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img5.jpg" alt="el_hover_img5">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Smart Televisions</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$45.00</span>
                                                    <del>$55.25</del>
                                                    <div class="on_sale">
                                                        <span>35% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img9.jpg" alt="el_img9">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img9.jpg" alt="el_hover_img9">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">oppo Reno3 Pro</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$68.00</span>
                                                    <del>$99.00</del>
                                                    <div class="on_sale">
                                                        <span>20% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:87%"></div>
                                                    </div>
                                                    <span class="rating_num">(25)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img7.jpg" alt="el_img7">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img7.jpg" alt="el_hover_img7">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Audio Theaters</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$45.00</span>
                                                    <del>$55.25</del>
                                                    <div class="on_sale">
                                                        <span>35% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img5.jpg" alt="el_img5">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img5.jpg" alt="el_hover_img5">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Smart Televisions</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$45.00</span>
                                                    <del>$55.25</del>
                                                    <div class="on_sale">
                                                        <span>35% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="product_wrap">
                                            <div class="product_img">
                                                <a href="shop-product-detail.php">
                                                    <img src="../public/images/el_img12.jpg" alt="el_img12">
                                                    <img class="product_hover_img" src="../public/images/el_hover_img12.jpg" alt="el_hover_img12">
                                                </a>
                                                <div class="product_action_box">
                                                    <ul class="list_none pr_action_btn">
                                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product_info">
                                                <h6 class="product_title"><a href="shop-product-detail.php">Sound Equipment for Low</a></h6>
                                                <div class="product_price">
                                                    <span class="price">$45.00</span>
                                                    <del>$55.25</del>
                                                    <div class="on_sale">
                                                        <span>35% Off</span>
                                                    </div>
                                                </div>
                                                <div class="rating_wrap">
                                                    <div class="rating">
                                                        <div class="product_rate" style="width:80%"></div>
                                                    </div>
                                                    <span class="rating_num">(21)</span>
                                                </div>
                                                <div class="pr_desc">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        	<div class="col-md-4">
            	<div class="sale-banner mb-3 mb-md-4">
                	<a class="hover_effect1" href="#">
                		<img src="../public/images/Exclusivos/ban1.jpg" alt="shop_banner_img7">
                    </a>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="sale-banner mb-3 mb-md-4">
                	<a class="hover_effect1" href="#">
                		<img src="../public/images/Exclusivos/ban2.jpg" alt="shop_banner_img8">
                    </a>
                </div>
            </div>
            <div class="col-md-4">
            	<div class="sale-banner mb-3 mb-md-4">
                	<a class="hover_effect1" href="#">
                		<img src="../public/images/Exclusivos/ban3.jpg" alt="shop_banner_img9">
                    </a>
                </div>
            </div>
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
                        <h4>Oferta del Día</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="product_slider carousel_slider owl-carousel owl-theme nav_style3" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "650":{"items": "2"}, "1199":{"items": "2"}}'>
            		<div class="item">
                        <div class="deal_wrap">
                            <div class="product_img">
                                <a href="shop-product-detail.php">
                                    <img src="../public/images/audio1.png" alt="el_img1">
                                </a>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h5 class="product_title"><a href="shop-product-detail.php">HEADSET ANCREU K10 PRO BLACK LED RGB SERIES GAMING</a></h5>
                                    <div class="product_price">
                                        <span class="price">$18.00</span>
                                        <del>$30.00</del>
                                    </div>
                                </div>
                                <div class="deal_progress">
                                    <span class="stock-sold">Already Sold: <strong>6</strong></span>
                                    <span class="stock-available">Available: <strong>8</strong></span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100" style="width:46%"> 46% </div>
                                    </div>
                                </div>
                                <div class="countdown_time countdown_style4 mb-4" data-time="2020/12/02 12:30:15"></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal_wrap">
                            <div class="product_img">
                                <a href="shop-product-detail.php">
                                    <img src="../public/images/teclado1.png" alt="el_img2">
                                </a>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h5 class="product_title"><a href="shop-product-detail.php">TECLADO MOTOSPEED K82 RGB PINK MECHANICAL WIRED</a></h5>
                                    <div class="product_price">
                                        <span class="price">$34.00</span>
                                        <del>$55.00</del>
                                    </div>
                                </div>
                                <div class="deal_progress">
                                    <span class="stock-sold">Already Sold: <strong>4</strong></span>
                                    <span class="stock-available">Available: <strong>22</strong></span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="26" aria-valuemin="0" aria-valuemax="100" style="width:26%"> 26% </div>
                                    </div>
                                </div>
                                <div class="countdown_time countdown_style4 mb-4" data-time="2020/09/02 12:30:15"></div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="deal_wrap">
                            <div class="product_img">
                                <a href="shop-product-detail.php">
                                    <img src="../public/images/el_img3.jpg" alt="el_img3">
                                </a>
                            </div>
                            <div class="deal_content">
                                <div class="product_info">
                                    <h5 class="product_title"><a href="shop-product-detail.php">Nikon HD camera</a></h5>
                                    <div class="product_price">
                                        <span class="price">$68.00</span>
                                        <del>$99.25</del>
                                    </div>
                                </div>
                                <div class="deal_progress">
                                    <span class="stock-sold">Already Sold: <strong>16</strong></span>
                                    <span class="stock-available">Available: <strong>20</strong></span>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width:28%"> 28% </div>
                                    </div>
                                </div>
                                <div class="countdown_time countdown_style4 mb-4" data-time="2020/09/02 12:30:15"></div>
                            </div>
                        </div>
                    </div>
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
                	<a class="hover_effect1" href="#">
                		<img src="../public/images/Exclusivos/silla1.jpg" alt="shop_banner_img10">
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
                            	<a href="#" class="text_default"><i class="linearicons-power"></i> <span>View All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/p1.jpg" alt="el_img2">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/p11.jpg" alt="el_hover_img2">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">PLACA GIGABYTE Z390 AORUS MASTER LGA 1151 INTEL Z390 HDMI SATA 6GB/S USB 3.1 ATX</a></h6>
                                        <div class="product_price">
                                            <span class="price">$220.00</span>
                                            <del>$299.00</del>
                                            <div class="on_sale">
                                                <span>Ahorre $79.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/mo1.jpg" alt="el_img5">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/mo11.jpg" alt="el_hover_img5">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">MONITOR 32 LED ASUS TUF GAMING VG328H1B FULL HD 1080P 165HZ (OC) 1MS HDMI/VGA CURVO</a></h6>
                                        <div class="product_price">
                                            <span class="price">$399.00</span>
                                            <del>$429.00</del>
                                            <div class="on_sale">
                                                <span>Ahorra $30.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/pro1.jpg" alt="el_img9">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/pro11.jpg" alt="el_hover_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">CPU AMD RYZEN 9 5900X 12/24TH 3.7GHZ 64MB AM4 TURBO CORE 4.8GHZ S/G</a></h6>
                                        <div class="product_price">
                                            <span class="price">$709.00</span>
                                            <del>$740.00</del>
                                            <div class="on_sale">
                                                <span>Ahorra $31.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/moni1.jpg" alt="el_img7">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/moni11.jpg" alt="el_hover_img7">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">MONITOR 27 IPS GIGABYTE G27Q 27 144HZ 1440P GAMING</a></h6>
                                        <div class="product_price">
                                            <span class="price">$420.00</span>
                                            <del>$445.00</del>
                                            <div class="on_sale">
                                                <span>Ahorra $25.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/p2.jpg" alt="el_img5">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/p22.jpg" alt="el_hover_img5">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">PLACA ASROCK Z390 PRO4/A/ASRK LGA 1151</a></h6>
                                        <div class="product_price">
                                            <span class="price">$135.00</span>
                                            <del>$155.00</del>
                                            <div class="on_sale">
                                                <span>Ahorra $20.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/Exclusivos/tar1.jpg" alt="el_img12">
                                            <img class="product_hover_img" src="../public/images/Exclusivos/tar11.jpg" alt="el_hover_img12">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Add To Cart</a></li>
                                                <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">VIDEO ASUS GEFORCE TUF GTX 1660 SUPER 6GB OC TUF-GTX1660S-O6G GAMING 6GB 192-BIT GDDR6 PCI EX</a></h6>
                                        <div class="product_price">
                                            <span class="price">$299.00</span>
                                            <del>$320.00</del>
                                            <div class="on_sale">
                                                <span>Ahorra $21.00</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
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
                	<div class="item">
                    	<div class="cl_logo">
                        	<img src="../public/images/cl_logo1.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo2.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo3.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo4.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo5.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo6.png" alt="cl_logo"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="cl_logo">
                        	<img src="../public/images/cl_logo7.png" alt="cl_logo"/>
                        </div>
                    </div>
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
        	<div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>Productos Destacados</h4>
                            </div>
                            <div class="view_all">
                            	<a href="#" class="text_default"><span>View All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img2.jpg" alt="el_img2">
                                            <img class="product_hover_img" src="../public/images/el_hover_img2.jpg" alt="el_hover_img2">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Smart Watch External</a></h6>
                                        <div class="product_price">
                                            <span class="price">$55.00</span>
                                            <del>$95.00</del>
                                            <div class="on_sale">
                                                <span>25% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img1.jpg" alt="el_img1">
                                            <img class="product_hover_img" src="../public/images/el_hover_img1.jpg" alt="el_hover_img1">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Red &amp; Black Headphone</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <span class="pr_flash">New</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img3.jpg" alt="el_img3">
                                            <img class="product_hover_img" src="../public/images/el_hover_img3.jpg" alt="el_hover_img3">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Nikon HD camera</a></h6>
                                        <div class="product_price">
                                            <span class="price">$68.00</span>
                                            <del>$99.00</del>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img5.jpg" alt="el_img5">
                                            <img class="product_hover_img" src="../public/images/el_hover_img5.jpg" alt="el_hover_img5">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Smart Televisions</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img9.jpg" alt="el_img9">
                                            <img class="product_hover_img" src="../public/images/el_hover_img9.jpg" alt="el_hover_img9">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">oppo Reno3 Pro</a></h6>
                                        <div class="product_price">
                                            <span class="price">$68.00</span>
                                            <del>$99.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img7.jpg" alt="el_img7">
                                            <img class="product_hover_img" src="../public/images/el_hover_img7.jpg" alt="el_hover_img7">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Audio Theaters</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        	</div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>Productos Mejor Valorados</h4>
                            </div>
                            <div class="view_all">
                            	<a href="#" class="text_default"><span>View All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img5.jpg" alt="el_img5">
                                            <img class="product_hover_img" src="../public/images/el_hover_img5.jpg" alt="el_hover_img5">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Smart Televisions</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img12.jpg" alt="el_img12">
                                            <img class="product_hover_img" src="../public/images/el_hover_img12.jpg" alt="el_hover_img12">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Sound Equipment for Low</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img4.jpg" alt="el_img4">
                                            <img class="product_hover_img" src="../public/images/el_hover_img4.jpg" alt="el_hover_img4">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Audio Equipment</a></h6>
                                        <div class="product_price">
                                            <span class="price">$69.00</span>
                                            <del>$89.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:70%"></div>
                                            </div>
                                            <span class="rating_num">(22)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <span class="pr_flash bg-danger">Hot</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img6.jpg" alt="el_img6">
                                            <img class="product_hover_img" src="../public/images/el_hover_img6.jpg" alt="el_hover_img6">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Samsung Smart Phone</a></h6>
                                        <div class="product_price">
                                            <span class="price">$55.00</span>
                                            <del>$95.00</del>
                                            <div class="on_sale">
                                                <span>25% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <span class="pr_flash bg-danger">Hot</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img8.jpg" alt="el_img8">
                                            <img class="product_hover_img" src="../public/images/el_hover_img8.jpg" alt="el_hover_img8">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Surveillance camera</a></h6>
                                        <div class="product_price">
                                            <span class="price">$55.00</span>
                                            <del>$95.00</del>
                                            <div class="on_sale">
                                                <span>25% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <span class="pr_flash bg-success">Sale</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img10.jpg" alt="el_img10">
                                            <img class="product_hover_img" src="../public/images/el_hover_img10.jpg" alt="el_hover_img10">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">classical Headphone</a></h6>
                                        <div class="product_price">
                                            <span class="price">$68.00</span>
                                            <del>$99.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        	</div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <div class="heading_tab_header">
                            <div class="heading_s2">
                                <h4>Productos en Oferta</h4>
                            </div>
                            <div class="view_all">
                            	<a href="#" class="text_default"><span>View All</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product_slider carousel_slider product_list owl-carousel owl-theme nav_style5" data-nav="true" data-dots="false" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "1"}, "380":{"items": "1"}, "640":{"items": "2"}, "991":{"items": "1"}}'>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img11.jpg" alt="el_img11">
                                            <img class="product_hover_img" src="../public/images/el_hover_img11.jpg" alt="el_hover_img11">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Basics High-Speed HDMI</a></h6>
                                        <div class="product_price">
                                            <span class="price">$69.00</span>
                                            <del>$89.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:70%"></div>
                                            </div>
                                            <span class="rating_num">(22)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img7.jpg" alt="el_img7">
                                            <img class="product_hover_img" src="../public/images/el_hover_img7.jpg" alt="el_hover_img7">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Audio Theaters</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">

                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <span class="pr_flash bg-danger">Hot</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img8.jpg" alt="el_img8">
                                            <img class="product_hover_img" src="../public/images/el_hover_img8.jpg" alt="el_hover_img8">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Surveillance camera</a></h6>
                                        <div class="product_price">
                                            <span class="price">$55.00</span>
                                            <del>$95.00</del>
                                            <div class="on_sale">
                                                <span>25% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img5.jpg" alt="el_img5">
                                            <img class="product_hover_img" src="../public/images/el_hover_img5.jpg" alt="el_hover_img5">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Smart Televisions</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img9.jpg" alt="el_img9">
                                            <img class="product_hover_img" src="../public/images/el_hover_img9.jpg" alt="el_hover_img9">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">oppo Reno3 Pro</a></h6>
                                        <div class="product_price">
                                            <span class="price">$68.00</span>
                                            <del>$99.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_wrap">
                                    <div class="product_img">
                                        <a href="shop-product-detail.php">
                                            <img src="../public/images/el_img1.jpg" alt="el_img1">
                                            <img class="product_hover_img" src="../public/images/el_hover_img1.jpg" alt="el_hover_img1">
                                        </a>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.php">Red &amp; Black Headphone</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                    </div>
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

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb">
	<div class="custom-container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
            	<div class="newsletter_text text_white">
                    <h3>Join Our Newsletter Now</h3>
                    <p> Register now to get updates on promotions. </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form2 rounded_input">
                    <form>
                        <input type="text" required="" class="form-control" placeholder="Enter Email Address">
                        <button type="submit" class="btn btn-dark btn-radius" name="submit" value="Submit">Subscribe</button>
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
                            <a href="#"><img src="../public/images/logo_dark.png" alt="logo"/></a>
                        </div>
                        <p class="mb-3">If you are going to use of Lorem Ipsum need to be sure there isn't anything hidden of text</p>
                        <ul class="contact_info">
                            <li>
                                <i class="ti-location-pin"></i>
                                <p>123 Street, Old Trafford, NewYork, USA</p>
                            </li>
                            <li>
                                <i class="ti-email"></i>
                                <a href="mailto:info@sitename.com">info@sitename.com</a>
                            </li>
                            <li>
                                <i class="ti-mobile"></i>
                                <p>+ 457 789 789 65</p>
                            </li>
                        </ul>
                    </div>
        		</div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">Useful Links</h6>
                        <ul class="widget_links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Location</a></li>
                            <li><a href="#">Affiliates</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                	<div class="widget">
                        <h6 class="widget_title">My Account</h6>
                        <ul class="widget_links">
                            <li><a href="#">My Account</a></li>
                            <li><a href="#">Discount</a></li>
                            <li><a href="#">Returns</a></li>
                            <li><a href="#">Orders History</a></li>
                            <li><a href="#">Order Tracking</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                	<div class="widget">
                        <h6 class="widget_title">Instagram</h6>
                        <ul class="widget_instafeed instafeed_col4">
                            <li><a href="#"><img src="../public/images/insta_img1.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img2.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img3.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img4.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img5.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img6.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img7.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
                            <li><a href="#"><img src="../public/images/insta_img8.jpg" alt="insta_img"><span class="insta_icon"><i class="ti-instagram"></i></span></a></li>
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
                                    	<h5>Free Delivery</h5>
                                        <p>Phasellus blandit massa enim elit of passage varius nunc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">	
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-money-back"></i>
                                    </div>
                                    <div class="icon_box_content">
                                    	<h5>30 Day Returns Guarantee</h5>
                                        <p>Phasellus blandit massa enim elit of passage varius nunc.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">	
                                <div class="icon_box icon_box_style2">
                                    <div class="icon">
                                        <i class="flaticon-support"></i>
                                    </div>
                                    <div class="icon_box_content">
                                    	<h5>27/4 Online Support</h5>
                                        <p>Phasellus blandit massa enim elit of passage varius nunc.</p>
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
                    <p class="mb-lg-0 text-center">© 2020 All Rights Reserved by Bestwebcreator</p>
                </div>
                <div class="col-lg-4 order-lg-first">
                    <div class="widget mb-lg-0">
                        <ul class="social_icons text-center text-lg-left">
                            <li><a href="#" class="sc_facebook"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#" class="sc_twitter"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#" class="sc_google"><i class="ion-social-googleplus"></i></a></li>
                            <li><a href="#" class="sc_youtube"><i class="ion-social-youtube-outline"></i></a></li>
                            <li><a href="#" class="sc_instagram"><i class="ion-social-instagram-outline"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="footer_payment text-center text-lg-right">
                        <li><a href="#"><img src="../public/images/visa.png" alt="visa"></a></li>
                        <li><a href="#"><img src="../public/images/discover.png" alt="discover"></a></li>
                        <li><a href="#"><img src="../public/images/master_card.png" alt="master_card"></a></li>
                        <li><a href="#"><img src="../public/images/paypal.png" alt="paypal"></a></li>
                        <li><a href="#"><img src="../public/images/amarican_express.png" alt="amarican_express"></a></li>
                    </ul>
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
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="../public/js/main.js?v=2"></script>
<script src="../public/js/tools.js"></script>
</body>
</html>
