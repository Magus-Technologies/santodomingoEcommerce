<?php
session_start();
require "../dao/ProductoDao.php";
require "../utils/Tools.php";

$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();
$tools = new Tools();
$dataConf = $tools->getConfiguracion();
?><!DOCTYPE html>
<?php include '../fragment/head_general.php'?>

<!-- SITE TITLE -->
    <title>COMPUTER</title>
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

<!-- Home Popup Section
<div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row no-gutters">
                    <div class="col-sm-5">
                    	<div class="background_bg h-100" data-img-src="../public/assets/images/popup_img.jpg"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s4">
                                    <h4>Subscribe and Get 25% Discount!</h4>
                                </div>
                                <p>Subscribe to the newsletter to receive updates about new products.</p>
                            </div>
                            <form method="post">
                            	<div class="form-group">
                                	<input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email">
                                </div>
                                <div class="form-group">
                                	<button class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe" type="submit">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>-->
<!-- End Screen Load Popup Section --> 

<!-- START HEADER -->
<?php include "../fragment/head_secon.php";?>
<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Carrito de compras</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Pagina</a></li>
                    <li class="breadcrumb-item active">Carrito de compras</li>
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
	<div class="container" id="primary">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table">
                	<table class="table">
                    	<thead>
                        	<tr>
                            	<th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Producto</th>
                                <th class="product-price">Precio</th>
                                <th class="product-quantity">Cantidad</th>
                                <th class="product-subtotal">Total</th>
                                <th class="product-remove">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr  v-for="(item, index) in listaCarrito">
                            	<td class="product-thumbnail"><a href="#"><img :src="'../public/img/productos/'+item.imagen" alt="product1"></a></td>
                                <td class="product-name" data-title="Producto"><a href="#">{{item.nombre_prod}}</a></td>
                                <td class="product-price" data-title="Precio">S/{{item.precio}}</td>
                                <td class="product-quantity" data-title="Cantidad"><div class="quantity">
                                <input type="button"  v-on:click="min(index)" value="-" class="minus">
                                <input type="text" disabled name="quantity" v-model="item.cantidad" title="Qty" class="qty" size="4">
                                <input type="button" v-on:click="sum(index)" value="+" class="plus">
                              </div></td>
                              	<td class="product-subtotal" data-title="Total">S/{{sumaPrecioImporte(item.cantidad,item.precio)}}</td>
                                <td class="product-remove" data-title="Borrar"><a v-on:click="eliminar(index)" href="javascript:void(0)"><i class="ti-close"></i></a></td>
                            </tr>

                        </tbody>
                        <tfoot hidden>
                        	<tr>
                            	<td colspan="6" class="px-0">
                                	<div class="row no-gutters align-items-center">

                                    	<div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                            <div class="coupon field_form input-group">
                                                <input type="text" value="" class="form-control form-control-sm" placeholder="Introduce el código de cupón..">
                                                <div class="input-group-append">
                                                	<button disabled class="btn btn-fill-out btn-sm" type="submit">Aplicar cupón</button>
                                                </div>
                                            </div>
                                    	</div>
                                        <div class="col-lg-8 col-md-6 text-left text-md-right">
                                           <!-- <button class="btn btn-line-fill btn-sm" type="submit">Update Cart</button>-->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            	<div class="medium_divider"></div>
            	<div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
            	<div class="medium_divider"></div>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-6">
            </div>
            <div class="col-md-6">
            	<div class="border p-3 p-md-4">
                    <div class="heading_s1 mb-3">
                        <h6>Totales del carrito</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">Car. Subtotal</td>
                                    <td class="cart_total_amount">S/{{totalCar}}</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">Total</td>
                                    <td class="cart_total_amount"><strong>S/{{totalCar}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--a href="checkout.php" class="btn btn-fill-out">Pasar a pagar</a-->
                    <a href="checkout.php" class="btn btn-fill-out">Procesar</a>
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
            listaCarrito:[]
        },
        methods:{
            sumaPrecioImporte(cnt,precio){
                return (parseInt(cnt+"")*parseFloat(precio+"")).toFixed(2);
            },
            reloadDataMain(){
                this.listaCarrito = CARRITO._data.listaCarrito;
            },
            min(index){
                if (this.listaCarrito[index].cantidad>1){
                    this.listaCarrito[index].cantidad--;
                    CARRITO.setDataPass(this.listaCarrito)
                }

            },
            eliminar(index){
                this.listaCarrito.splice( index, 1 );
                CARRITO.setDataPass(this.listaCarrito)
            },
            sum(index){
                if (this.listaCarrito[index].cantidad<this.listaCarrito[index].stock-3){
                    this.listaCarrito[index].cantidad++;
                    CARRITO.setDataPass(this.listaCarrito)
                }

            }
        },
        computed:{
            totalCar(){
                var total= 0.00;
                for (var i=this.listaCarrito.length-1; i>=0;i--){
                    total +=parseInt(this.listaCarrito[i].cantidad+"") * parseFloat(this.listaCarrito[i].precio+"")
                }
                return total.toFixed(2)
            },
        }
    });

    CARRITO.setFuncionExe(APP.reloadDataMain);
</script>
</html>