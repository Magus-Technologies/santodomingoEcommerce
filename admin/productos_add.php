<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){


require "../utils/Tools.php";
require "../dao/MarcaSeleccionDao.php";
require "../dao/GrupoCategoriaDao.php";

$tools = new Tools();
$marcas = new MarcaSeleccionDao();
$categoria = new GrupoCategoriaDao();

$dataConf = $tools->getConfiguracion();

$listaMarca = $marcas->getDataOnli();
$listaCatego = $categoria->getGategoliaOnli();
$listaCatego2 = $categoria->getGategoliaOnli2();
//echo "sddddddd";
//print_r($listaCatego);

?><!DOCTYPE html>
<html lang="es">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Los Mejores en Hardware.">
<meta name="keywords" content="tarjeta de video, procesador, hardware, laptop, pc gamer, gaming, memoria ram, GPU, CPU, disco duro, ssd, m.2">

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
<link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<style>
    .box-item-img:hover{
        cursor: pointer;
    }
    .box-imageSS:hover{
        cursor: pointer;
        background-color: #ee8577;
    }
    .itemSelct{
        background-color: rgba(69, 68, 238, 0.91);
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

<!-- START SECTION BREADCRUMB -->
<div class="mt-4 staggered-animation-wrap">
    <div class="custom-container">

    </div>
</div>
<!-- END SECTION BREADCRUMB -->


<div class="section">
    <div class="container">
        <div class="row  justify-content-md-center" style="margin-bottom: 20px">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-md-12 text-right">
                    <a href="productos.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Atras</a>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <button class="btn btn-success" data-toggle="modal" data-target="#buscar-productos">Buscar producto</button>
                <button onclick="APP.resetImagenSele()" data-toggle="modal" data-target="#imagenes-prod" class="btn btn-info">Asignar Foto</button>
                <button onclick="APP.guardarProducto()" class="btn btn-primary">Guardar</button>
            </div>
        </div>

        <div class="row" id="contenedorPrimario">
            <div class="col-lg-6 col-md-6 mb-4 mb-md-0">

                <div v-if="listaImagens.length == 0" class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" src='../public/img/productos/sinimagen_mtr_20sba.jpg' data-zoom-image='../public/img/productos/sinimagen_mtr_20sba.jpg' alt="product_img1" />
                        <a href="javascript:void(0)" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>
                    <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                        <div class="item">
                            <a href="javascript:void(0)" class="product_gallery_item active" data-image='../public/img/productos/sinimagen_mtr_20sba.jpg' data-zoom-image='../public/img/productos/sinimagen_mtr_20sba.jpg'>
                                <img src='../public/img/productos/sinimagen_mtr_20sba.jpg' alt="product_small_img1" />
                            </a>
                        </div>
                    </div>
                </div>
                <div v-if="listaImagens.length > 0" class="product-image">
                    <div class="product_img_box">
                        <img id="product_img" :src='getURLImagen(imagenSelectIMG)' :data-zoom-image='getURLImagen(listaImagens[imagenSelect].img)'  alt="product_img1" />
                        <a href="javascript:void(0)" class="product_img_zoom" title="Zoom">
                            <span class="linearicons-zoom-in"></span>
                        </a>
                    </div>
                    <!--div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="true">
                        <div v-for="(item, index) in listaImagens" class="item">
                            <a v-if="index == 0" href="#" class="product_gallery_item active" :data-image='getURLImagen(item.img)' :data-zoom-image='getURLImagen(item.img)' >
                                <img :src='getURLImagen(item.img)' alt="product_small_img1" />
                            </a>
                            <a v-if="index > 0" href="#" class="product_gallery_item active" :data-image='getURLImagen(item.img)' :data-zoom-image='getURLImagen(item.img)' >
                                <img :src='getURLImagen(item.img)' alt="product_small_img1" />
                            </a>
                        </div>
                    </div-->
                </div>
                <div class="col-md-12">
                    <div style="max-width: 100%;overflow: auto" class="box-lg">
                        <div style="overflow: hidden; width: max-content;">
                            <div v-for="(item, index) in listaImagens" v-on:click="cambiarImagen(getURLImagen(item.img))" style="width: 128px;height: 140px;padding: 3px;float: left" class="box-item-img">
                                <img  style="max-width: 100%;max-height: 100%" :src='getURLImagen(item.img)'>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pr_detail">
                    <div class="product_description">
                        <span>Nombre producto en Web</span>
                        <h4 class="product_title"><input style="width: 100%;font-size: 15px;" v-model="dataReProd.nom_pro"></h4>
                        <div class="product_price">
                            <span class="price">${{formatNumerPrecio(dataReProd.precio)}} </span>
                            <!--del>$820.00</del-->
                            <div class="on_sale">
                                <span>Impuestos Incluidos</span>
                            </div>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                            <span class="rating_num">(21)</span>
                        </div>
                        <div class="pr_desc">

                        </div>
                        <div class="product_sort_info">

                            <ul>
                                <li style="color: white">1 Año de Garantía</li>
                                <li><i class="linearicons-shield-check"></i> Garantía <select v-model="dataReProd.garantia">
                                        <option value="0">Sin Garantía</option>
                                        <option value="1 Año de Garantía">1 Año de Garantía</option>
                                        <option value="6 meses de Garantía">6 meses de Garantía</option>
                                        <option value="3 meses de Garantía">3 meses de Garantía</option>
                                        <option value="2 meses de Garantía">2 meses de Garantía</option>
                                        <option value="1 meses de Garantía">1 mes de Garantía</option>
                                    </select></li>
                                <li><i class="linearicons-bag-dollar"></i>Compra en Linea o Tienda (Efectivo o Tarjeta de Credito)</li>
                            </ul>
                        </div>

                        <hr />
                        <div class="cart_extra">
                            <div class="form-group col-md-12">
                                <label>Estado del Proucto</label>
                                <select v-model="dataReProd.estado_prod" class="form-control">
                                    <option value="1">Nuevo</option>
                                    <option value="2">Remate</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1 col-md-12">Categoria Web</label>
                                <select  @change="onChangeCatWeb($event)" id="categori-web" class="form-control" >


                                    <?php
                                    foreach ($listaCatego2 as $cate){
                                        echo "<option value='{$cate['codi_categoria']}'>{$cate['nombre_cate']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div v-if="listaSubCat.length>0" class="col-md-12">
                                <div class="col-md-12">
                                     <span>ETIQUETA</span>
                                </div>
                                <div class="col-md-12">
                                    <select id="subCatSelecct" class="form-control">
                                        <option v-for="(item, index) in listaSubCat" :value="item.sub_id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>
                            <!--div class="cart_btn">
                                <button class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i> Añadir al carrito</button>
                                <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                                <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                            </div-->
                        </div>
                        <hr />
                        <div class="cart_extra">

                            <div  class="col-md-12">
                                <div class="col-md-12">
                                    <span>Contiene</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="col-md-1">*</span>
                                    <input v-model="dataReProd.conten1" class="col-md-10">
                                </div>
                                <div class="col-md-12" style="margin-bottom: 3px;margin-top: 3px">
                                    <span class="col-md-1">*</span>
                                    <input v-model="dataReProd.conten2" class="col-md-10">
                                </div>
                                <div class="col-md-12">
                                    <span class="col-md-1">*</span>
                                    <input v-model="dataReProd.conten3" class="col-md-10">
                                </div>
                            </div>

                        </div>
                        <ul class="product-meta">
                            <li>SKU: <a href="#">..........</a></li>
                            <li>Categoria: {{dataReProd.catego}}</li>
                            <li>Marca: {{dataReProd.marc}}</li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="large_divider clearfix"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Descripción</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Additional-info-tab" data-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Especificación</a>
                            </li>

                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                <div id="summernote-des"></div>
                            </div>
                            <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                <div id="summernote-esp">
                                    <p><br></p>
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><br></p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">

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

            <div class="modal fade" id="buscar-productos" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg"  style=" max-width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2 class="modal-title" id="exampleModalLongTitle">Buscar Productos</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1 col-md-12">Categoria</label>
                                        <select v-model="categori" @change="onCategoria($event)" class="form-control" >
                                            <option value="000">Seleccione</option>
                                            <?php
                                            foreach ($listaCatego as $cate){
                                                echo "<option value='{$cate['cod_sub1']}'>{$cate['nom_sub1']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleInputEmail1 col-md-12">Marcas</label>
                                        <select v-model="marca" @change="onMarca($event)" v-model="marca" class="form-control selectpicker "  data-max="2" >
                                            <option value="000">Todos</option>
                                            <?php
                                            foreach ($listaMarca as $marc){
                                                echo "<option value='{$marc['cod_sub2']}'>{$marc['nom_sub2']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <table id="example" class="table table-striped table-bordered  table-sm" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock</th>
                                            <th>Categoria</th>
                                            <th>Marca</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="imagenes-prod" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h2 class="modal-title" id="exampleModalLongTitle">Imagenes del producto</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <input  multiple="multiple" accept="image/*" type="file" style="display: none" id="fil-imagen">
                                <div class="row text-center" >
                                    <div class="col-md-12 text-center">
                                        <button onclick="$('#fil-imagen').click()" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar Imagen</button>
                                        <button :disabled="imagenSelectLista == -1" v-on:click="dismi()" class="btn btn-success"><i class="fa fa-arrow-left"></i></button>
                                        <button :disabled="imagenSelectLista == -1" v-on:click="aumen()" class="btn btn-success"><i class="fa fa-arrow-right"></i></button>
                                        <button :disabled="imagenSelectLista == -1" v-on:click="eliminarFoto()" class="btn btn-danger"><i class="fa fa-times"></i></button>
                                    </div>

                                </div>
                                <div class="row" style="margin-top: 5px;margin-bottom: 5px">
                                    <div class="col-md-12 text-center">
                                        <h3>lista de imagenes</h3>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <h5>Tamaño recomendado: 800 X 960 pixeles</h5>
                                    </div>
                                </div>
                                <div class="row" style="max-height: 350px;overflow: auto;height: 350px; border: 1px solid #8f8f8f">
                                    <div v-for="(item, index) in listaImagens" class="col-md-4">
                                        <div v-on:click="selectImagenLista(index)"  :class="imagenSelectLista==index?'col-md-12 box-imageSS itemSelct':'col-md-12 box-imageSS'">
                                            <img  style="max-height: 100%; max-height: 165px;margin: auto;display: block;" :src="getURLImagen(item.img)">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
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
                    <p class="mb-md-0 text-center text-md-left">© 2020 Todos los derechos reservados por Compu Vision</p>
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

<script src="../public/assets/js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="../public/js/produc_mnager.js"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>

<script>

    const APP = new Vue({
        el:"#contenedorPrimario",
        data:{
            listaSubCat:[],
            listaCategoria:[],
            listaMarcas:[],
            categori:'000',
            marca:'000',
            imagenSelect:0,
            listaProductos:[],
            listaImagens:[],
            dataReProd:{
                estado_prod:'1',
                conten1:'',
                conten2:'',
                conten3:'',
                cod_prod:'',
                cod_cat:'',
                cod_mar:'',
                nom_pro:'Nombre del producto seleccionado',
                precio:'0.00',
                catego:'',
                garantia:'0',
                marc:'',
            },
            imagenSelectLista:-1,
            imagenGuardadas:0,
            imagenRecorrida:0,
        },
        methods:{
            onChangeCatWeb(event){
                this.verificadirCatExtrac();
            },

            resetImagenSele(){
                this.imagenSelectLista=-1;
            },
            eliminarFoto(){
                this.listaImagens.splice( this.imagenSelectLista, 1 );
                this.imagenSelectLista=-1;
            },
            dismi(){
                if (this.imagenSelectLista!=-1){
                    const itemTmep= this.listaImagens[this.imagenSelectLista]
                    this.listaImagens.splice( this.imagenSelectLista, 1 );
                    if (this.imagenSelectLista>0){
                        this.imagenSelectLista--;
                    }
                    var arrTemp =[];
                    for (var i=0; i<this.listaImagens.length;i++){
                        if (i==this.imagenSelectLista){
                            arrTemp.push(itemTmep);
                        }
                        arrTemp.push(this.listaImagens[i]);
                    }
                }
                this.listaImagens=arrTemp
            },
            aumen(){
                if (this.imagenSelectLista<this.listaImagens.length){
                    const itemTmep= this.listaImagens[this.imagenSelectLista]
                    this.listaImagens.splice( this.imagenSelectLista, 1 );
                    if (this.imagenSelectLista<this.listaImagens.length){
                        this.imagenSelectLista++;
                    }
                    var arrTemp =[];

                    for (var i=0; i<this.listaImagens.length;i++){
                        if (i==this.imagenSelectLista){
                            arrTemp.push(itemTmep);
                        }
                        arrTemp.push(this.listaImagens[i]);
                    }
                    if (this.imagenSelectLista==this.listaImagens.length){
                        arrTemp.push(itemTmep);
                    }
                    this.listaImagens=arrTemp
                }

            },
            selectImagenLista(index){
                this.imagenSelectLista=index
            },
            cambiarImagen(urlv){
                console.log(urlv);
                //this.listaProductos=index;
                $("#product_img").attr("src",urlv);
            },
            getURLImagen(imga){
                return  URL.createObjectURL(imga);
            },
            addImagenLista(imagen){
                this.listaImagens.push(imagen)
            },
            formatNumerPrecio(num){
                return parseFloat(num+"").toFixed(2)
            },
            getDataCategorias(){

            },
            onCategoria(event) {
                console.log(event.target.value)
                this.cargarData()
            },
            onMarca(event) {
                console.log(event.target.value)
                this.cargarData()
            },
            verificadirCatExtrac(){

                    const cat = $("#categori-web").val();
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_categoria.php",
                        data: {tipo:'sub_c',cat},
                        success: function (resp) {
                            console.log(resp);
                            APP._data.listaSubCat= JSON.parse(resp);
                        }
                    });


            },
            productoSeleccionado(prod_cod){
                console.log(prod_cod)
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_productos.php",
                    data: {tipo:'producto-onli',cod:prod_cod},
                    success: function (resp) {
                        resp = JSON.parse(resp);
                        console.log(resp);
                        APP._data.dataReProd.cod_prod=prod_cod;
                        APP._data.dataReProd.cod_cat=resp.cod_cate;
                        APP._data.dataReProd.cod_mar=resp.cod_subc;
                        APP._data.dataReProd.nom_pro=resp.nom_prod;
                        APP._data.dataReProd.precio=resp.precio_venta;
                        APP._data.dataReProd.catego=resp.nom_sub1;
                        APP._data.dataReProd.marc=resp.nom_sub2;
                        /*APP._data.dataReProd={
                            cod_prod:prod_cod,
                                cod_cat:resp.cod_cate,
                                cod_mar:resp.cod_subc,
                                nom_pro:resp.nom_prod,
                                precio:resp.precio_venta,
                                catego:resp.nom_sub1,
                                marc:resp.nom_sub2,

                        }*/
                        APP.verificadirCatExtrac();


                        $("#buscar-productos").modal('hide');
                    }
                });

            },
            recargarDatatable(){
                table.clear().draw(true);
                for (var i = 0; i<this.listaProductos.length;i++){
                    table.row.add( [this.listaProductos[i].nom_prod,
                        this.listaProductos[i].stock,
                        this.listaProductos[i].nom_sub1,
                        this.listaProductos[i].nom_sub2,
                        "<button onclick=\"APP.productoSeleccionado('"+this.listaProductos[i].cod_prod+"')\" class='btn btn-success' style='padding: 10px;padding-top: 5px;padding-bottom: 5px;'><i class='fa fa-check'></i></button>"] ).draw( false );
                }

            },
            cargarData(){
                this.listaProductos=[];

                if(this.categori!='000'){
                    const codCar = this.categori;
                    if(this.marca=='000'){
                        $.ajax({
                            type: "POST",
                            url: "../ajax/ajs_productos.php",
                            data: {tipo:'prod-cat-all',ctg:codCar},
                            success: function (resp) {
                                console.log(resp)
                                resp =  JSON.parse(resp)

                                APP._data.listaProductos = resp
                                setTimeout(function () {
                                    APP.recargarDatatable()
                                },100)
                            }
                        });

                    }else{
                        const codMarca =  this.marca;
                        $.ajax({
                            type: "POST",
                            url: "../ajax/ajs_productos.php",
                            data: {tipo:'prod-cat-marc',ctg:codCar,mrc:codMarca},
                            success: function (resp) {
                                console.log(resp)
                                resp =  JSON.parse(resp)

                                APP._data.listaProductos = resp
                                setTimeout(function () {
                                    APP.recargarDatatable()
                                },100)
                            }
                        });
                    }
                }
            },
            refrescarimagenes(){
                this.listaImagens.forEach(function (element, index) {
                    seImgFil(element,index)
                });
            },
            verificadorGuardado(){
                if (this.imagenRecorrida == this.listaImagens.length){
                    swal("Guardado","","success").then(function () {

                        window.location.href = "./productos.php";
                    })
                }
            },
            guardarImagenProd(prod_id){
                if (this.listaImagens.length>0){
                    this.listaImagens.forEach(function (element, index) {

                        var fd = new FormData();
                        fd.append('file',element.img);
                        fd.append('posicion',index+1);
                        fd.append('produc',prod_id);
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
                            url: '../ajax/upload_img_prod.php',
                            data: fd,
                            contentType: false,
                            cache: false,
                            processData:false,
                            beforeSend: function(){
                                console.log('inicio');
                            },
                            error:function(err){
                                APP._data.imagenRecorrida++;
                                console.log(err);
                                APP.verificadorGuardado()
                            },
                            success: function(resp){
                                APP._data.imagenRecorrida++;
                                console.log(resp);
                                APP._data.imagenGuardadas++
                                APP.verificadorGuardado()

                            }
                        });

                    });
                }else{
                    swal("Guardado","","success").then(function () {

                        window.location.href = "./productos.php";
                    })
                }
            },
            guardarProducto(){

                const codCar = this.categori;
                if (this.dataReProd.cod_prod.length>0){
                    var subca='';
                    if (this.listaSubCat.length>0){
                        subca= $("#subCatSelecct").val();
                    }

                    var dataR = {...this.dataReProd}
                    dataR.descripcion =$('#summernote-des').summernote('code');
                    dataR.especificaciones =$('#summernote-esp').summernote('code');
                    dataR.cod_cat = $("#categori-web").val();
                    dataR.subCat = subca;
                    //dataR.cod_cat = codCar;
                    dataR.tipo ="prod-i";


                    console.log(dataR)
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: dataR,
                        success: function (resp) {
                            console.log(resp)
                            if (isJson(resp)){
                                resp = JSON.parse(resp);
                                APP.guardarImagenProd(resp.prod_ID)

                            }else{
                                console.log("Error")
                            }
                        }
                    });
                }else{
                    swal("Selecione un producto","","warning");
                }


            }
        },
        computed:{
            imagenSelectIMG(){
                return this.listaImagens[this.imagenSelect].img
            },
            primeraImg(){
                return this.listaImagens[0];
            }
        }
    });
    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }
    function seImgFil(fil,id) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPr_'+id).attr('src', e.target.result);
            };
            //console.log(fil)
            reader.readAsDataURL(fil.img);
    }

    var table;
    $( document ).ready(function() {

        $("#fil-imagen").change(function(){
            if (this.files && this.files[0]){
                const L_fil =this.files;
                for (var i = 0; i<L_fil.length;i++){
                    APP._data.listaImagens.push({
                        img:L_fil[i]
                    });
                }

                APP.refrescarimagenes()
                $("#fil-imagen").val("");
            }

        });

        APP.verificadirCatExtrac()
        //APP_PROD.getInfoProduc()
        table =  $('#example').DataTable({
            language: {
                url: '../utils/Spanish.json'
            }
        });
        $('#summernote-esp').summernote({
            height:'400px',
            lang: 'es-ES',
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });
        $('#summernote-des').summernote({
            height:'400px',
            lang: 'es-ES',
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });
        setTimeout(function () {
            $("#example_wrapper").attr("style","width: 100%;")
        },300)

    })
</script>
</html>





<?php } else {
    header("Location: ../CYM/");
}
?>
