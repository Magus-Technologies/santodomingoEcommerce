<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../utils/Tools.php";

$productoDao = new ProductoDao();
$grupoCategoriaDao = new GrupoCategoriaDao();
$conexion = (new Conexion())->getConexion();
$tools = new Tools();

$dataConf = $tools->getConfiguracion();
$listaRamByCat = $productoDao->getDataRandonE();
//$listaGrupos =$grupoCategoriaDao->getListaCate();

$produc = $_GET['prod'];
$productoDao->setProdId($produc);
$data = $productoDao->getData22();
//print_r($data);

/*$productoDao->setCategoria($data['categoria_cod']);
$listaRelacionada = $productoDao->getListRandon(10);*/
$listaRelacionada = [];

//print_r($data);




?><!DOCTYPE html>
<?php include '../fragment/head_general.php'?>
    <!-- SITE TITLE -->
    <title>ACEADVANCE | GAMING</title>
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
<!-- jquery-ui CSS -->
<link rel="stylesheet" href="../public/assets/css/jquery-ui.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="../public/assets/css/slick.css">
<link rel="stylesheet" href="../public/assets/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/responsive.css">
<link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .float{
            padding-top: 7px;
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:80px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
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

<!-- End Screen Load Popup Section --> 

<!-- START HEADER -->
<?php

include "../fragment/head_secon.php";


$precio = number_format($data['precio_prod'], 2, '.', ',');
$dataExtraBann = '<span class="price">$'.$precio.'</span>';

$dataExtraBannSol = '<span class="price"> S/. '.number_format($data['precio_prod']*$tc, 2, '.', ',').'</span>';
?>
<!-- END HEADER -->

<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <form action="shop-list-prod.php" method="GET" style="padding-bottom: 20px;display: block;margin: auto;" class="col-md-9">
                <div class="input-group">
                    <input class="form-control" name="search" placeholder="Buscar producto..." required="" type="text">
                    <button type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini" style="padding-bottom: 20px;padding-top: 20px;">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Detalle del Producto</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li  hidden class="breadcrumb-item"><a href="#">inicio</a></li>
                    <li  hidden class="breadcrumb-item"><a href="#">Ofertas</a></li>
                    <li style="font-size: 18px;">TC: <span style="color: white">-</span> <strong><?=$tc?></strong></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section">
	<div class="container">
		<div class="row">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                <div class="product-image">
                <?php

                if (count($data['imagenes'])>0){

                $img = $data['imagenes'][0];

                ?>

                    <div class="product_img_box">
                        <input id="image_pro" value="<?=$img['imagen_url']?>" type="hidden">
                        <img id="product_img" src='../public/img/productos/<?=$img['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$img['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                        <a href="#" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>

                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">

                        <?php
                        $contadorImg =1;
                        foreach ($data['imagenes'] as $ima){
                            if ($contadorImg==1){ ?>
                                <div class="item">
                                    <a href="#" class="product_gallery_item active" data-image='../public/img/productos/<?=$ima['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$ima['imagen_url']?>'>
                                        <img src='../public/img/productos/<?=$ima['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                                    </a>
                                </div>
                            <?php   }else{?>
                                <div class="item">
                                    <a href="#" class="product_gallery_item" data-image='../public/img/productos/<?=$ima['imagen_url']?>' data-zoom-image='../public/img/productos/<?=$ima['imagen_url']?>'>
                                        <img src='../public/img/productos/<?=$ima['imagen_url']?>' alt="<?=$img['imagen_url']?>" />
                                    </a>
                                </div>
                            <?php    }

                            $contadorImg++;
                        }
                        ?>



                    </div>



                    <?php


                    }
                    ?>

                </div>



            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <input value="<?=$data['nom_prod']?>" id="nombre_prod" type="hidden">

                        <input value="<?=$_GET['prod']?>" id="id_prod" type="hidden">
                        <input value="<?=$precio?>" id="precio_prod" type="hidden">
                        <h4 class="product_title"><a href="#"><?=$data['nombre']?></a></h4>
                        <div class="product_price">
                            <?=$dataExtraBann?>
                            <div class="on_sale">
                                <span>Impuestos Incluidos</span>
                            </div>
                        </div>
                        <br><br>
                        <div class="product_price">
                            <?=$dataExtraBannSol?>
                            <div class="on_sale">
                                <span>Impuestos Incluidos</span>
                            </div>
                        </div>
                        <div style="display: none" class="rating_wrap">
                                <div class="rating">
                                    <div class="product_rate" style="width:80%"></div>
                                </div>
                                <span class="rating_num">(21)</span>
                            </div>
                        <div class="pr_desc" style="height: 17px;width: 100%;">
                        </div>
                        <div class="product_sort_info">
                            <ul>
                                <li><i class="linearicons-sync"></i>Preguntar por Delivery</li>
                                <li><i class="linearicons-bag-dollar"></i>Compra en Linea o Tienda (Efectivo o Tarjeta de Credito)</li>
                            </ul>
                        </div>
                       
                       
                    <hr />
                    <div class="cart_extra"  id="primary">
                        <input type="hidden" value="<?=$data['stock_prod']?>" id="stock">
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input v-on:click="min()" type="button" value="-" class="minus">
                                <input type="text" disabled name="quantity" v-model="cantidad" value="" title="Qty" class="qty" size="4">
                                <input v-on:click="sum()" type="button" value="+" class="plus">
                            </div>
                        </div>
                        <div class="cart_btn">
                            <button v-on:click="agregarCarrito()" :disabled="validated"  class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Añadir al carrito</button>
                            <!--a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a-->
                        </div>
                    </div>
                    <hr />
                    <ul class="product-meta">
                        <li> <strong>Stock: <a href="javascript:void(0)"><?php
                                if ($data['stock_prod']==0){
                                    echo "Sin Stock";
                                }elseif($data['stock_prod']>10){
                                    echo "+ de 10 en Stock";
                                }else{
                                    echo  number_format($data['stock_prod'], 0, '.', ',') . " en Stock";
                                }
                                ?></a></strong></li>
                        <li style="display: none">Categoria: <a href="javascript:void(0)"><?=$data['categoria']?></a></li>
                        <li style="display: none">Marca: <a href="javascript:void(0)" rel="tag"><?=$data['marca']?></a></li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="row">
        	<div class="col-12">
            	<div class="large_divider clearfix"></div>
            </div>
        </div>
        <div class="row" style="width: 100%;">
        	<div class="col-12">
            	<div class="tab-style3">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Descripción</a>
                      	</li>
                      	<li class="nav-item">
                        	<a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Especificación</a>
                      	</li>
                      	<!--li class="nav-item">
                        	<a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Opiniones</a>
                      	</li-->
                    </ul>
                	<div class="tab-content shop_info_tab">
                      	<div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                            <?=$data['descripcion']?>
                      	</div>
                      	<div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                            <?=$data['caracteristicas']?>
                      	</div>
                      	<div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                        	<div class="comments">
                            	<h5 class="product_tab_title">2 Review For <span>Blue Dress For Woman</span></h5>
                                <ul class="list_none comment_list mt-4">
                                    <li>
                                        <div class="comment_img">
                                            <img src="../public/assets/images/user1.jpg" alt="user1"/>
                                        </div>
                                        <div class="comment_block">
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:80%"></div>
                                                </div>
                                            </div>
                                            <p class="customer_meta">
                                                <span class="review_author">Alea Brooks</span>
                                                <span class="comment-date">March 5, 2018</span>
                                            </p>
                                            <div class="description">
                                                <p>Lorem Ipsumin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="comment_img">
                                            <img src="../public/assets/images/user2.jpg" alt="user2"/>
                                        </div>
                                        <div class="comment_block">
                                            <div class="rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:60%"></div>
                                                </div>
                                            </div>
                                            <p class="customer_meta">
                                                <span class="review_author">Grace Wong</span>
                                                <span class="comment-date">June 17, 2018</span>
                                            </p>
                                            <div class="description">
                                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                        	</div>
                            <div class="review_form field_form">
                                <h5>Add a review</h5>
                                <form class="row mt-3">
                                    <div class="form-group col-12">
                                        <div class="star_rating">
                                            <span data-value="1"><i class="far fa-star"></i></span>
                                            <span data-value="2"><i class="far fa-star"></i></span> 
                                            <span data-value="3"><i class="far fa-star"></i></span>
                                            <span data-value="4"><i class="far fa-star"></i></span>
                                            <span data-value="5"><i class="far fa-star"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <textarea required="required" placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input required="required" placeholder="Enter Name *" class="form-control" name="name" type="text">
                                     </div>
                                    <div class="form-group col-md-6">
                                        <input required="required" placeholder="Enter Email *" class="form-control" name="email" type="email">
                                    </div>
                                   
                                    <div class="form-group col-12">
                                        <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Submit Review</button>
                                    </div>
                                </form>
                            </div>
                      	</div>
                	</div>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-12">
            	<div class="small_divider"></div>
            	<div class="divider"></div>
                <div class="medium_divider"></div>
            </div>
        </div>
        <div class="row" style="margin-top: 50px;">
        	<div class="col-md-12" style="max-width: 1080px; display: none" >
            	<div class="heading_s1">
                	<h3>Productos Relacionados</h3>
                </div>
            	<div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "5"}}'>
                    <?php
                    foreach ($listaRelacionada as $rowPR){
                        $precioRel = number_format($rowPR['precio'], 2, '.', ',');
                        ?>
                        <div class="item">
                            <div class="product">
                                <div class="product_img">
                                    <a href="shop-product-detail.php">
                                        <img src="../public/img/productos/<?=$rowPR['imagen1']?>" alt="product_img1">
                                    </a>
                                    <div class="product_action_box">
                                        <ul class="list_none pr_action_btn">
                                            <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                            <li><a href="shop-compare.php"><i class="icon-shuffle"></i></a></li>
                                            <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                            <li><a href="#"><i class="icon-heart"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product_info">
                                    <h6 class="product_title"><a href="shop-product-detail.php?prod=<?=$rowPR['prod_id']?>"><?=$rowPR['nombre']?></a></h6>
                                    <div class="product_price">
                                        <span class="price">$<?=$precioRel?></span>
                                        <!--del>$55.25</del>
                                        <div class="on_sale">
                                            <span>35% Off</span>
                                        </div-->
                                    </div>
                                    <div class="rating_wrap">
                                        <div class="rating">
                                            <div class="product_rate" style="width:80%"></div>
                                        </div>
                                        <span class="rating_num">(21)</span>
                                    </div>
                                    <div class="pr_desc">
                                        <p></p>
                                    </div>
                                    <!--div class="pr_switch_wrap">
                                        <div class="product_color_switch">
                                            <span class="active" data-color="#87554B"></span>
                                            <span data-color="#333333"></span>
                                            <span data-color="#DA323F"></span>
                                        </div>
                                    </div-->
                                </div>
                            </div>
                        </div>
                    <?php     }
                    ?>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
   <?php require_once "../fragment/plantilla_suscribete.php"?>
<!-- START SECTION SUBSCRIBE NEWSLETTER -->

</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
    <?php include "../fragment/footer_gen.php"?>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 

<!-- Latest jQuery --> 
<script src="../public/assets/js/jquery-1.12.4.min.js"></script> 
<!-- jquery-ui --> 
<script src="../public/assets/js/jquery-ui.js"></script>
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
    <script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>
<script>
    const APP = new Vue({
        el:'#primary',
        data:{
            cantidad:1,
            validated:false
        },
        methods:{

            agregarCarrito(){
                if (parseFloat($("#stock").val()+"")>0){
                    swal('Opción no habilitada',"","warning")
                    /*CARRITO.addProductCarr({
                        cantidad:this.cantidad,
                        cod_prod:$("#cod_prod").val(),
                        imagen:$("#image_pro").val(),
                        nombre_prod: $("#nombre_prod").val(),
                        precio:$("#precio_prod").val(),
                        prod_id:$("#id_prod").val()
                    });
                    swal('Agregado',"","success")*/
                }else{
                    swal('No hay stock disponible',"","warning")

                }
            },
            iniciador(){
                if (parseFloat($("#stock").val()+"")<=0){
                    this.cantidad = '';
                }
            },
            min(){
               if (this.cantidad>1){
                   this.cantidad--;
               }
            },
            sum(){
                if (this.cantidad<$("#stock").val()){
                    this.cantidad++;
                }
            }
        },
        computed:{

        }
    });

    $( document ).ready(function() {
        APP.iniciador();
    });
</script>
</html>
