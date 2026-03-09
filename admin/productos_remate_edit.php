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

<input value="<?=$_GET['prod']?>" id="producto_c" type="hidden">
<div class="section">
    <div class="container">
        <div class="row  justify-content-md-center" style="margin-bottom: 20px">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-md-12 text-right">
                    <a href="productos_remate.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Atras</a>
                </div>
            </div>
            <div class="col-md-12 text-center">
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
                        <img id="product_img" :src='imagenSelectIMG' data-zoom-image=''  alt="product_img1" />
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
                            <div v-for="(item, index) in listaImagens" v-on:click="cambiarImagen(item.foto_id==-1?getURLImagen(item.imagen_url):'../public/img/productos/'+item.imagen_url)" style="width: 128px;height: 140px;padding: 3px;float: left" class="box-item-img">
                                <img  style="max-width: 100%;max-height: 100%" :src='item.foto_id==-1?getURLImagen(item.imagen_url):"../public/img/productos/"+item.imagen_url'>
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
                        <span class="price">$<input id="precioprod" @keypress="onlyNumber" style="width: 100px;font-size: 20px; color: red"> </span>
                        <!--del>$820.00</del-->
                        <div class="on_sale">
                            <span>Precio con impuestos Incluidos</span>
                        </div>
                    </div>    <br> <br> <br>
                    <div class="product_sort_info">
                        <span>Stock: </span><input  style="width: 100px;font-size: 20px;" id="stock_prod"  @keypress="onlyNumber">
                    </div>
                        <div class="product_sort_info">
                            <ul>
                                <li><i class="linearicons-shield-check"></i> 1 Año de Garantía</li>
                                <li><i class="linearicons-sync"></i>Preguntar por Delivery</li>
                                <li><i class="linearicons-bag-dollar"></i>Compra en Linea o Tienda (Efectivo o Tarjeta de Credito)</li>
                            </ul>
                        </div>
                        <div class="cart_extra">

                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1 col-md-12">Marcas</label>
                                <select id="marcaproducto"   v-model="dataReProd.marcaprod"  class="form-control selectpicker "  data-max="2" >
                                    <?php
                                    foreach ($listaMarca as $marc){
                                        echo "<option value='{$marc['cod_sub2']}'>{$marc['nom_sub2']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <hr />
                        <div class="cart_extra">

                            <div v-if="listaSubCat.length>0" class="col-md-12">
                                <div class="col-md-12">
                                    <span>ETIQUETA</span>
                                </div>
                                <div class="col-md-12">
                                    <select v-model="dataReProd.subCat" id="subCatSelecct" class="form-control">
                                        <option v-for="(item, index) in listaSubCat" :value="item.sub_id">{{item.nombre}}</option>
                                    </select>
                                </div>
                            </div>

                        </div>

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
                            <!--li class="nav-item">
                              <a class="nav-link" id="Reviews-tab" data-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Opiniones</a>
                            </li-->
                        </ul>
                        <div class="tab-content shop_info_tab">
                            <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                <div id="summernote-des"></div>
                            </div>
                            <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                <div id="summernote-esp">
                                    <p><br></p>
                                    <table class="table table-bordered">
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
                                <!--div class="comments">
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
                                </div -->
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
                <div class="modal-dialog modal-lg">
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
                                                echo "<option value='{$cate->cod_sub1}'>{$cate->nom_sub1}</option>";
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
                                                echo "<option value='{$marc->cod_sub2}'>{$marc->nom_sub2}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Producto</th>
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
                                <input accept="image/*" type="file" style="display: none" id="fil-imagen">
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
                                            <img  style="max-height: 100%; max-height: 165px;margin: auto;display: block;" :src="item.foto_id==-1?getURLImagen(item.imagen_url):'../public/img/productos/'+item.imagen_url">
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
                    <p class="mb-md-0 text-center text-md-left">© 2020 Todos los derechos reservados por <a target="_blank" href="https://magustechnologies.com/">
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

<script src="../public/assets/js/scripts.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="../public/js/produc_mnager.js"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>

<script src="../public/js/editremate.js">
</script>
</html>
<?php } else {
    header("Location: ../CYM/");
}
?>
