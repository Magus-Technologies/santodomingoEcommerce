<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../utils/Tools.php";

$grupoCategoriaDao = new GrupoCategoriaDao();
$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();
$tools = new Tools();
$dataConf = $tools->getConfiguracion();
$listaRamByCat = $productoDao->getDataRandonE();

$listaGrupos =$grupoCategoriaDao->getListaCate();
$listProdBan = $productoDao->getRandomInfo(1);
$palabra ="";
if (isset($_GET['search'])){
    $palabra =$_GET['search'];
}

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
<style>
    .on-click-cont:hover{
        cursor: pointer;
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
<?php include "../fragment/head_secon.php";?>
<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini" style="padding-bottom: 20px;padding-top: 20px;">
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
                    <li style="font-size: 18px;color: #ff3d57;">TC: <span style="color: white">-</span> <strong><?=$tc?></strong></li>
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
    <input value="<?=$palabra?>" id="palabra" type="hidden">
    <div class="custom-container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
                <form action="shop-list-prod-remates.php" method="GET" style="padding-bottom: 20px;display: block;margin: auto;" class="col-md-12">
                    <div class="search-container">
                        <input class="rounded-left-input" name="search" placeholder="Buscar producto en COMPUTER." required="" type="text">
                        <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                    </div>                </form>
            </div>
        </div>
    	<div class="row">
			<div class="col-lg-9" id="content_principal">

                <div class="row shop_container grid">
                    <div v-for="(item, index) in listaHoja" class="col-md-4 col-6 col-lg-3">
                        <div class="product">
                            <div class="product_img">
                                <a :href="'shop-product-detail.php?prod='+item.prod_id">
                                    <img :src="'../public/img/productos/'+item.imagen1" alt="product_img1">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li class="add-to-cart"><a v-on:click="agregarCarritoProd(index)" href="javascript:void(0);"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                        <!--<li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>-->

                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title titulo_prod" ><a  :href="'shop-product-detail.php?prod='+item.prod_id">{{item.nombre}}</a></h6>
                                <div class="product_price">
                                    <span class="price">${{formatNumerPrecio(item.precio_prod)}}</span>
                                    <span class=""><strong> S/. {{getCamBio(item.precio_prod)}}</strong></span>
                                    <!--del>$88.00</del>
                                    <div class="on_sale">
                                        <span>Ahorra $20.00</span>
                                    </div-->
                                </div>
                                <div class="rating_wrap">

                                    <span class="rating_num">
                                          <strong>Stock: <a href="javascript:void(0)">
                                                <span v-if="formartNumberStock(item.stock_prod)==0" style="font-weight: lighter;color: #d70000"> Sin Stock</span>
                                                <span v-if="formartNumberStock(item.stock_prod)<=10&&formartNumberStock(item.stock_prod)>0" style="font-weight: lighter;color: #03ad01"> {{formartNumberStock(item.stock_prod)}} en Stock</span>
                                                <span v-if="formartNumberStock(item.stock_prod)>10" style="font-weight: lighter;color: #03ad01">+ de 10 en Stock</span>
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
                                        <li class="add-to-cart"><a v-on:click="agregarCarritoProd(index)" href="javascript:void(0);"><i class="icon-basket-loaded"></i> Añadir al carrito</a></li>
                                        <!--<li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>-->
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
                    <div class="widget" style="    border: 1px solid #4746EB;">
                        <div style="
                            background-color: #4746EB;
                            overflow: auto;
                            padding-top: 4px;
                            padding-left: 6px;
                        ">
                            <h5 class="widget_title" style="text-transform: uppercase;
                                color: white;
                                margin-bottom: 11px;
                            ">Categorias</h5>
                        </div>
                        <ul class="widget_categories" style=" padding-left: 16px; padding-right: 5px;">
                            <?php
                            foreach ($listaGrupos as $catRow){
                                echo '<li><a style="font-weight: bold"  href="shop-list-ctg.php?ctg='.$catRow['codi_categoria'].'"><span class="categories_name">'.$catRow['nombre'].'</span><span class="categories_num"></span></a></li>';
                            }
                            ?>

                        </ul>
                    </div>

                    <div class="widget">
                        <div style="border: 1px solid #4746EB;">
                            <div style="
                            background-color: #4746EB;
                            overflow: auto;
                            padding-top: 4px;
                            padding-left: 6px;
                            ">
                                <h5 style="text-transform: uppercase;
                                color: white;
                                margin-bottom: 11px;
                                " class="widget_title">Filtrar por</h5>
                            </div>
                            <div style="padding: 11px;">
                                <div class="widget">
                                    <h5 class="widget_title">Disponibilidad</h5>
                                    <ul  class="list_brand">
                                        <li>
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="en-stock" id="en-stock" value="en-stock" >
                                                <label class="form-check-label" for="en-stock" >
                                                    <span>EN STOCK</span></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="widget">
                                    <h5 class="widget_title">Rango de Precio</h5>
                                    <div class="filter_price">
                                        <span onclick="APP_PROD.getFiltrar()" class="on-click-cont" style="/* left: 115%; */padding-left: 8px;padding-top: 3px;/* top: -15px; */width: 30px;border-radius: 5px;height: 30px;float: right;background-color: #4746EB;/* margin-bottom: 200px; */color: white;bottom: 15px;position: relative;"><i class="fa fa-search"></i></span>
                                        <div style="width: 80%" id="price_filter" data-min="0" data-max="5000" data-min-value="0" data-max-value="5000" data-price-sign="$" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                            <!--div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 20.6%; width: 18.6%;"></div-->
                                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 20.6%;"></span>
                                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 39.2%;"></span>

                                        </div>
                                        <div class="price_range">
                                            <span>Price: <span id="flt_price">$103 - $196</span></span>
                                            <input  type="hidden" id="price_first" value="103">
                                            <input  type="hidden" id="price_second" value="196">
                                        </div>
                                    </div>
                                </div>
                                <div class="widget">
                                    <h5 class="widget_title">Filtrar por</h5>
                                    <div class="product_size_switch">

                                    </div>
                                </div>

                                <div class="widget">
                                    <h5 class="widget_title">Otras Marcas</h5>
                                    <ul id="listaMarcas" class="list_brand">


                                    </ul>
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
<script src="../public/js/tools.js"></script>
<script src="../public/js/main.js?v=2"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>

<script>

    var $container22;
    const APP_PROD = new Vue({
        el:"#content_principal",
        data:{
            valueUSDMin:0,
            valueUSDMax:5000,
            palabra:'',
            listaProdGene:[],
            listaBusquedaE:[],
            listaMarcar:[],
            listaHoja:[],
            cntPorHoja:0,
            cntItemPorHoja:12,
            cntHojas:0,
            hojaActual:1,
            cantidadProd:0,
            lasrId:0,
            listaMarcaFiltro:[],
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
            agregarFiltroMarca(mar){
                this.listaMarcaFiltro.push(mar)
            },
            eliminarFiltroMarca(mar){
                var index = this.listaMarcaFiltro.indexOf(mar);
                this.listaMarcaFiltro.splice(index, 1);
            },
            setListaMarcas(){
                this.listaMarcar=[];
                for (var i=0;i<this.listaProdGene.length;i++){
                    this.listaMarcar.push(this.listaProdGene[i].marca);
                }
                this.listaMarcar = this.listaMarcar.filter(function (value, index, self) {
                    return self.indexOf(value) === index;
                })

                this.listaMarcar.forEach(function (item,index) {
                    $("#listaMarcas").append('<li>\n' +
                        '                                <div class="custome-checkbox">\n' +
                        '                                    <input class="input-check-marc form-check-input" type="checkbox" name="'+item+'" id="'+item+'" value="'+item+'">\n' +
                        '                                    <label class="form-check-label" for="'+item+'"><span>'+item+'</span></label>\n' +
                        '                                </div>\n' +
                        '                            </li>');
                })
            },
            getFiltrar(){
                this.valueUSDMin = parseFloat( $("#price_first").val());
                this.valueUSDMax = parseFloat($("#price_second").val());
                this.resetFiter()
            },
            getDataProdListaPag2(){
                const cnt = this.cntItemPorHoja;
                const min = this.lasrId;
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'pag-search-remate22'},
                    success: function (resq) {

                        resq= JSON.parse(resq);
                        resq = resq.reverse();
                        //console.log(resq);
                       // APP_PROD._data.listaHoja= resq
                        APP_PROD._data.listaProdGene= resq
                        APP_PROD._data.listaBusquedaE= resq
                        APP_PROD.getPreparePagination2();
                        APP_PROD.setListaMarcas();
                        // console.log(resq);
                        $(".scrollup").click()
                    }
                });

            },
            resetFiter(){
                this.listaBusquedaE=[];
                for (var i=0;i<this.listaProdGene.length;i++){
                    const precioProd =parseFloat(this.listaProdGene[i].precio_prod+"");
                    //console.log(precioProd +"<<<<")
                   // console.log(precioProd+"  "+this.valueUSDMin +"#"+ precioProd+"   "+this.valueUSDMax)
                    if (precioProd>=this.valueUSDMin && precioProd<=this.valueUSDMax){
                        //console.log("a")
                        if (this.listaMarcaFiltro.length>0){
                            //console.log("b")
                            //console.log(this.listaProdGene[i].marca)
                            //console.log(this.listaMarcaFiltro.indexOf(this.listaProdGene[i].marca))
                            if (this.listaMarcaFiltro.indexOf(this.listaProdGene[i].marca)!=-1){
                                //console.log("c")
                                if (en_stock_filtro){
                                    if (parseFloat(this.listaProdGene[i].stock)>0){
                                        this.listaBusquedaE.push(this.listaProdGene[i]);
                                    }
                                }else{
                                    this.listaBusquedaE.push(this.listaProdGene[i]);
                                }
                            }

                        }else{
                            if (en_stock_filtro){
                                if (parseFloat(this.listaProdGene[i].stock)>0){
                                    this.listaBusquedaE.push(this.listaProdGene[i]);
                                }
                            }else{
                                this.listaBusquedaE.push(this.listaProdGene[i]);
                            }
                        }

                    }
                }
                this.getPreparePagination2();

            },
            getPreparePagination2(){
                this.cntHojas = Math.ceil(this.listaBusquedaE.length/this.cntItemPorHoja);
                this.viewDataHojaSc();
            },
            viewDataHojaSc(){
                this.listaHoja=[];
                //this.numCntHojas = Math.ceil(this.listaProductos.length/this.itemMaximo);
                for (var i=(this.hojaActual-1)*this.cntItemPorHoja; i < this.cntItemPorHoja * this.hojaActual; i++ ){
                    if (i<this.listaBusquedaE.length){
                        this.listaHoja.push(this.listaBusquedaE[i]);
                    }else{
                        break;
                    }
                }
                $(".scrollup").click()
            },

            agregarCarritoProd(index){
                //swal('Opción no habilitada',"","warning")
                const  prod = this.listaHoja[index];
                CARRITO.setCarrito(prod);
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
                this.viewDataHojaSc();
                /*if (this.hojaActual==1){
                    this.lasrId=0;
                }else{
                    this.lasrId = this.listaHoja[this.listaHoja.length-1].prod_id
                }

                this.getDataProdListaPag();*/
            },
            setSwithHoja(num){
                console.log(num);

                if ( this.hojaActual+num > 0&& this.hojaActual+num <= this.cntHojas){
                    this.hojaActual+=num;
                    /*if (this.hojaActual==1){
                        this.lasrId=0;
                    }else{
                        this.lasrId = this.listaHoja[this.listaHoja.length-1].prod_id
                    }*/
                    this.viewDataHojaSc();
                    //this.getDataProdListaPag();
                }

            },
            getDataProdListaPag(){
                const cnt = this.cntItemPorHoja;
                const min = this.lasrId;
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'pag-search',cnt,min,pal:APP_PROD._data.palabra},
                    success: function (resq) {
                       // console.log(resq);
                        resq= JSON.parse(resq);
                        APP_PROD._data.listaHoja= resq
                       // console.log(resq);
                        $(".scrollup").click()
                    }
                });

            },

            getDataCountProd(){
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'pag-search-count',pal:APP_PROD._data.palabra},
                    success: function (resp) {
                        if (isJson(resp)){
                            resp=JSON.parse(resp);
                            if (resp.res){
                                APP_PROD._data.cantidadProd = parseInt(resp.cnt);
                                APP_PROD.getPreparePagination();
                            }else {

                            }
                        }else{

                        }
                        console.log(resp)
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
    var en_stock_filtro=false
    $( document ).ready(function() {
        $("#en-stock").change(function() {
            en_stock_filtro=this.checked;
            APP_PROD.resetFiter();
        });
        APP_PROD.establecerTC();

        APP_PROD._data.palabra=$("#palabra").val();
        APP_PROD.getDataProdListaPag2()
        $('#price_first').on('input',function(e){
            //console.log("assss")
            APP_PROD.getFiltrar();
        });

        setTimeout(function () {
            $( '.input-check-marc' ).on( 'click', function() {
                //console.log($(this).val())
                if( $(this).is(':checked') ){
                    // Hacer algo si el checkbox ha sido seleccionado
                    APP_PROD.agregarFiltroMarca($(this).val());
                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    APP_PROD.eliminarFiltroMarca($(this).val());
                }
                APP_PROD.resetFiter();
            });
        },1500)

        //APP_PROD.getDataCountProd()

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