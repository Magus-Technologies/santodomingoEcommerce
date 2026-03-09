<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../utils/Tools.php";

$grupoCategoriaDao = new GrupoCategoriaDao();
$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();
$tools = new Tools();

$listaRamByCat = $productoDao->getDataRandonE();

$listaGrupos =$grupoCategoriaDao->getListaCate();
$listProdBan = $productoDao->getRandomInfo(2);
$grupo =$_GET['grp'];
$marca =$_GET['mrc'];

$dataConf = $tools->getConfiguracion();

$sql="SELECT cod_sub1 as codi_categoria, nom_sub1 as nombre FROM sopsub1 WHERE cod_sub1 != '000' ORDER BY cod_sub1";
$listaGrupos = $conexion->query($sql);

?><!DOCTYPE html>
<?php include '../fragment/head_general.php'?>
    <!-- SITE TITLE -->
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
<script>
    const gtp = '<?=$grupo?>';
    const mrc = '<?=$marca?>';
</script>
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
<?php include "../fragment/head_secon.php";?>
<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini"  style="padding-bottom: 20px;padding-top: 20px;">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Productos</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li hidden class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li hidden class="breadcrumb-item"><a href="#">Pagina</a></li>
                    <li class="breadcrumb-item active">Tasa de cambio: <span style="color: white">-</span> <strong><?=$tc?></strong></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION SHOP -->
<div class="section" style="padding-top: 29px;">
	<div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <form action="shop-list-prod.php" method="GET" style="padding-bottom: 20px;display: block;margin: auto;" class="col-md-9">
                   <div class="search-container">
                        <input class="rounded-left-input" name="search" placeholder="Buscar producto en COMPUTER." required="" type="text">
                        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                    </div>                </form>
            </div>
        </div>
    	<div class="row">
			<div class="col-lg-9" id="content_principal">
            	<div class="row align-items-center mb-4 pb-1">
                    <div class="col-12">
                        <div class="product_header">
                            <div class="product_header_left">
                                <div class="">
                                   <!--  <select class="form-control form-control-sm">
                                        <option value="order">Ordenar Por</option>
                                        <option value="3 cooler">3 Cooler</option>
                                        <option value="4 cooler">4 Cooler Fuente</option>
                                        <option value="6 cooler">6 Cooler</option>
                                        <option value="Fuente de Poder">Incluye Fuente de Poder</option>
                                    </select>-->
                                </div>
                            </div>
                            <div class="product_header_right">
                            	<div class="products_view">
                                    <a href="javascript:Void(0);" class="shorting_icon grid active"><i class="ti-view-grid"></i></a>
                                    <a href="javascript:Void(0);" class="shorting_icon list"><i class="ti-layout-list-thumb"></i></a>
                                </div>
                                <div class="">
                                    <!--
                                    <select class="form-control form-control-sm">
                                        <option value="">Showing</option>
                                        <option value="9">9</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                    </select>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row shop_container grid">
                    <div v-for="(item, index) in listaHoja" class="col-md-4 col-6 col-lg-3">
                        <div class="product">
                            <div class="product_img">
                                <a :href="'shop-product-detail.php?prod='+item.prod_id">
                                    <img :src="'../public/img/productos/'+item.imagen1" :alt="item.nombre">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                        <!--<li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>-->
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a :href="'shop-product-detail.php?prod='+item.prod_id">{{item.nombre}}</a></h6>
                                <div class="product_price">
                                    <span class="price">${{formatNumerPrecio(item.precio)}}</span>
                                    <span class=""><strong> S/. {{getCamBio(item.precio)}}</strong></span>
                                    <!--del>$88.00</del>
                                    <div class="on_sale">
                                        <span>Ahorra $20.00</span>
                                    </div-->
                                </div>
                                <div class="rating_wrap">

                                    <span class="rating_num">
                                          <strong>Stock: <a href="javascript:void(0)">
                                                <span v-if="formartNumberStock(item.stock)==0" style="color: #d70000"> Sin Stock</span>
                                                <span v-if="formartNumberStock(item.stock)<=10&&formartNumberStock(item.stock)>0" style="color: #03ad01"> {{formartNumberStock(item.stock)}} en Stock</span>
                                                <span v-if="formartNumberStock(item.stock)>10" style="color: #03ad01">+ de 10 en Stock</span>
                                            </a></strong>
                                    </span>
                                </div>
                                <div class="pr_desc">
                                    <p>* {{item.content1}}</p>
                                    <p>* {{item.content2}}</p>
                                    <p>* {{item.content3}}</p>
                                </div>
                                <!--div class="pr_switch_wrap">
                                    <div class="product_color_switch">
                                        <span class="active" data-color="#87554B"></span>
                                        <span data-color="#333333"></span>
                                        <span data-color="#DA323F"></span>
                                    </div>
                                </div-->
                                <div class="list_product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                        <li><a href="shop-compare.php" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.php" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        		<div class="row">
                    <div class="col-12">
                        <ul class="pagination mt-3 justify-content-center pagination_style1">
                            <li v-on:click="setSwithHoja(-1)" class="page-item"><a class="page-link" href="javascript:void(0)"><i class="linearicons-arrow-left"></i></a></li>

                            <li v-for="item  in getPagNum" :class="hojaActual==item?'page-item active':'page-item'" v-on:click="setNumHoja(item)"><a class="page-link" href="javascript:void(0)">{{item}}</a></li>

                            <li v-on:click="setSwithHoja(1)"  class="page-item"><a class="page-link"  href="javascript:void(0)"><i class="linearicons-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
        	</div>
            <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
            	<div class="sidebar">
                	<div class="widget">
                        <h5 class="widget_title">Categorias</h5>
                        <ul class="widget_categories">
                            <?php
                            $contadorCCc = 0;
                            foreach ($listaGrupos as $catRow){
                                echo '<li><a href="shop-list-ctg.php?ctg='.$catRow['codi_categoria'].'"><span class="categories_name">'.$catRow['nombre'].'</span><span class="categories_num"></span></a></li>';


                            }
                            ?>

                        </ul>
                    </div>


                    <?php
                    foreach ($listProdBan as $wid){  ?>
                        <div class="widget">
                            <div class="shop_banner">
                                <div class="banner_img overlay_bg_20">
                                    <img src="../public/img/productos/<?=$wid['imagen1']?>" alt="sidebar_banner_img">
                                </div>
                                <div class="shop_bn_content2 text_white">
                                    <h5 class="text-uppercase shop_subtitle"><?=$wid['nombre']?></h5>
                                    <!--h3 class="text-uppercase shop_title">Sale 30% Off</h3-->
                                    <a href="shop-product-detail.php?prod=<?=$wid['prod_id']?>" class="btn btn-white rounded-0 btn-sm text-uppercase">Compra Ahora</a>
                                </div>
                            </div>
                        </div>
                    <?php  }
                    ?>



                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb">
	<div class="container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Suscríbete a nuestro boletín</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form">
                    <form action="#">
                        <input type="text" required="" class="form-control rounded-0" placeholder="Introduzca la dirección de correo electrónico">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Suscribir</button>
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
<?php include "../fragment/footer_gen.php"?>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a> 

<!-- Latest jQuery --> 
<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script>
    $(".preloader").hide()
</script>
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
<script src="../public/js/main.js?v=8"></script>
<script src="../public/js/tools.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>

<script>
    var $container22;
    const APP_PROD = new Vue({
        el:"#content_principal",
        data:{
            listaHoja:[],
            cntPorHoja:0,
            cntItemPorHoja:12,
            cntHojas:0,
            hojaActual:1,
            cantidadProd:0,
            lasrId:0,
            tc:1,

        },
        methods:{
            getCamBio(precio){
                return (parseFloat(precio)*this.tc).toFixed(2);
            },
            establecerTC(){
                this.tc = parseFloat($("#tasa_cambio").val());
            },
            formartNumberStock(num){
                return parseInt(num+"");
            },
            formatNumerPrecio(num){
                return parseFloat(num+"").toFixed(2)
            },
            getPreparePagination(){
                this.cntHojas = Math.ceil(this.cantidadProd/this.cntItemPorHoja);
                this.getDataProdListaPag();
            },
            setNumHoja(num){
                this.hojaActual=num;
                if (this.hojaActual==1){
                    this.lasrId=0;
                }else{
                    this.lasrId = this.listaHoja[this.listaHoja.length-1].prod_id
                }

                this.getDataProdListaPag();
            },
            setSwithHoja(num){
                console.log(num);
                if ( this.hojaActual+num > 0&& this.hojaActual+num <= this.cntHojas){
                    this.hojaActual+=num;
                    if (this.hojaActual==1){
                        this.lasrId=0;
                    }else{
                        this.lasrId = this.listaHoja[this.listaHoja.length-1].prod_id
                    }
                    this.getDataProdListaPag();
                }

            },
            getDataProdListaPag(){
                const cnt = this.cntItemPorHoja;
                const min = this.lasrId;
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'pag-gtp-mrc',cnt,min,gtp,mrc},
                    success: function (resq) {
                        console.log(resq);
                        resq= JSON.parse(resq);
                        APP_PROD._data.listaHoja= resq
                        console.log(resq);
                        $(".scrollup").click()
                    }
                });

            },
            getDataCountProd(){
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'pag-gtp-mrc-count',gtp,mrc},
                    success: function (resp) {
                        console.log(resp)
                        if (isJson(resp)){
                            resp=JSON.parse(resp);
                            if (resp.res){
                                APP_PROD._data.cantidadProd = parseInt(resp.cnt);
                                APP_PROD.getPreparePagination();
                            }else {

                            }
                        }else{

                        }

                    }
                });

            }
        },
        computed:{
            getPagNum(){
                var numero =[];
                for (var i =1 ; i<= this.cntHojas;i++){
                    numero.push(i);
                }
                console.log(numero)
                return numero;
            }
        }
    });

    $( document ).ready(function() {
        APP_PROD.establecerTC();
        APP_PROD.getDataCountProd()

        /*setTimeout(function () {
            $('.shorting_icon').on('click',function() {
                if ($(this).hasClass('grid')) {
                    $('.shop_container').removeClass('list').addClass('grid');
                    $(this).addClass('active').siblings().removeClass('active');
                }
                else if($(this).hasClass('list')) {
                    $('.shop_container').removeClass('grid').addClass('list');
                    $(this).addClass('active').siblings().removeClass('active');
                }
                $(".shop_container").append('<div class="loading_pr"><div class="mfp-preloader"></div></div>');
                setTimeout(function(){
                    $('.loading_pr').remove();
                    $container.isotope('layout');
                }, 800);
            });
        })*/

    });
</script>
</html>
