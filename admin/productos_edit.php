<?php
session_start();
require_once "../utils/Conexion.php";
$conexion = (new Conexion())->getConexion();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {


    require "../utils/Tools.php";
    require "../dao/MarcaSeleccionDao.php";
    require "../dao/GrupoCategoriaDao.php";
    require "../dao/ProductoDao.php";


    $tools = new Tools();
    $marcas = new MarcaSeleccionDao();
    $categoria = new GrupoCategoriaDao();
    $productoDao = new ProductoDao();


    $dataConf = $tools->getConfiguracion();

    $listaMarca = $marcas->getDataOnli();
    $sql2 = "SELECT * FROM grupo_seleccion ORDER BY nombre_cate ASC";
    $resp2 = $conexion->query($sql2);
    $listaCatego = [];
    foreach ($resp2 as $row) {
        $listaCatego[] = $row;
    }
    /* $listaCatego = $categoria->getGategoliaOnli(); */
    $productoDao->setProdId($_GET['prod']);
    $respuestaProductoDao = $productoDao->getData();
    $codigoCategoria = $respuestaProductoDao['categoria_cod'];
    $sub_cat = $respuestaProductoDao['sub_cat'];
    $marcaSEL = $respuestaProductoDao['marca'];


    $sqlmarcas ="SELECT * FROM marcra_productos WHERE estado = 1 order by nombre_marca asc";
	$respmar = $conexion->query($sqlmarcas);
	$listaMarc = [];
    	foreach ($respmar as $row) {
        $listaMarc[] = $row;
    	}
   
    $filtrado = $_GET['prod'];
    $selmarcas ="SELECT m.cod_marca, m.nombre_marca FROM marcra_productos m, producto p WHERE prod_id ='$filtrado' AND m.cod_marca = p.marca";
	$respsel = $conexion->query($selmarcas);
	foreach ($respsel as $row) {
      	$codsel = $row['cod_marca'];
		$marsel = $row['nombre_marca'];
    	}


    


    $sql = "SELECT 
    sub_categoria.* 
  FROM
    sub_categoria 
    INNER JOIN grupo_seleccion 
      ON sub_categoria.id_catego = grupo_seleccion.id_seleccion 
  WHERE grupo_seleccion.codi_categoria ='$codigoCategoria'";
    $resp = $conexion->query($sql);
    $respuesta = [];
    foreach ($resp as $row) {
        $respuesta[] = $row;
    }
    /*  echo "<pre>";
    var_dump($respuesta);

    die();  */

    /* die(); */
    /*   echo "<pre>";
     var_dump($listaCatego);
    die();  */
?>
    <!DOCTYPE html>
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
            .box-item-img:hover {
                cursor: pointer;
            }

            .box-imageSS:hover {
                cursor: pointer;
                background-color: #ee8577;
            }

            .itemSelct {
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

        <input value="<?= $_GET['prod'] ?>" id="producto_c" type="hidden">
        <input value="<?= $codigoCategoria ?>" id="cod_categoria_default" type="hidden">
        <div class="section">
            <div class="container">
                <div class="row  justify-content-md-center" style="margin-bottom: 20px">
                    <div class="row" style="margin-bottom: 20px">
                        <div class="col-md-12 text-right">
                            <a href="productos.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Atras</a>
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
                                <img id="product_img" :src='imagenSelectIMG' data-zoom-image='' alt="product_img1" />
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
                                        <img style="max-width: 100%;max-height: 100%" :src='item.foto_id==-1?getURLImagen(item.imagen_url):"../public/img/productos/"+item.imagen_url'>
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

                                    <!-- <div class="col-md-12">
                                        <span>ETIQUETA</span>
                                    </div> -->
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <span>CATEGORIA</span>
                                        </div>
                                        <div class="col-md-12">
                                            <select v-model="dataReProd.cod_cat" id="catSelect" class="form-control">
                                                 <?php

                                                foreach ($listaCatego as $cate) : ?>

                                                    <option value="<?= $cate['codi_categoria'] ?>" <? if ($cate['codi_categoria'] ==  $codigoCategoria) echo " selected" ?>><?= $cate['nombre_cate'] ?></option>
                                                    <option value='<?php echo $cate['codi_categoria'] ?>'><?php echo $cate['nombre_cate'] ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div v-if="listaSubCat.length>0" class="col-md-12" style="display:none;">
                                        <div class="col-md-12">
                                            <span>ETIQUETA</span>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-group">
                                            <select v-model="dataReProd.subCat" id="subCatSelecct" class="form-control">
                                                <option v-for="(item, index) in listaSubCat" :value="item.sub_id">{{item.nombre}}</option>
                                            </select>
  		                             <span  data-toggle="modal" data-target="#addSUB" class="btn btn-success"><i class="fa fa-plus"></i></span>
                                           </div>
                                        </div>
                                    </div>

						 <div class="col-md-12">
                                        <div class="col-md-12">
                                            <span>MARCA </span>
                                        </div>
                                        <div class="col-md-12">
                                            <select v-model="dataReProd.marcaNew" id="marcaNew" name="marcaNew" class="form-control">
                                                <?php foreach ($listaMarc as $marc): ?>
       							 <option value="<?php echo $marc['cod_marca']; ?>" 
					                   <?php echo ($marc['cod_marca'] == $codsel) ? 'selected' : ''; ?>>
						             <?php echo $marc['nombre_marca']; ?>
							        </option>
							      <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>


                                </div>

                                <div class="cart_extra">

                                    <div class="col-md-12">
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

                                <div class="cart_extra">
                                    <div class="col-md-12">
                                        <span>Estado</span>
                                    </div>
                                    <select v-model="dataReProd.estado" class="form-control" id="estadoSelect">
                                        <option value="0">No visible</option>
                                        <option value="1">Visible</option>
                                    </select>
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

	     <div class="modal fade" id="addSUB" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    			<div class="modal-dialog modal-lg">
			     <div class="modal-content">
			        <div class="modal-header">
			                <h5 class="modal-title" id="exampleModalLabel">Agregar Etiqueta</h5>
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               		            <span aria-hidden="true">&times;</span>
		                    </button>
		            </div>
            		    <div class="modal-body">
                		    <div class="form-group col-md-12">
                                  <input type="text" v-model="addetiqueta" id="addetiqueta" class="form-control" name="addetiqueta"  required="required">
                              </div>
    		            </div>
		            <div class="modal-footer">
               		 <button @click="agregarEtiqueta(addetiqueta)" type="button" class="btn btn-primary">Guardar</button>
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		            </div>
		        </div>
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
                                                <select v-model="categori" @change="onCategoria($event)" class="form-control">
                                                    <option value="000">Seleccione</option>
                                                    <?php
                                                    foreach ($listaCatego as $cate) {
                                                        echo "<option value='{$cate->cod_sub1}'>{$cate->nom_sub1}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1 col-md-12">Marcas</label>
                                                <select v-model="marca" @change="onMarca($event)" v-model="marca" class="form-control selectpicker " data-max="2">
                                                    <option value="000">Todos</option>
                                                    <?php
                                                    foreach ($listaMarca as $marc) {
                                                        echo "<option value='{$marc->cod_sub2}'>{$marc->nom_sub2}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
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
                                        <input accept="image/*" type="file" style="display: none" id="fil-imagen" multiple="multiple">
                                        <div class="row text-center">
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
                                                <div v-on:click="selectImagenLista(index)" :class="imagenSelectLista==index?'col-md-12 box-imageSS itemSelct':'col-md-12 box-imageSS'">
                                                    <img style="max-height: 100%; max-height: 165px;margin: auto;display: block;" :src="item.foto_id==-1?getURLImagen(item.imagen_url):'../public/img/productos/'+item.imagen_url">
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
            el: "#contenedorPrimario",
            data: {
                listaSubCat: [],
                listaCategoria: [],
                listaMarcas: [],
                categori: '000',
                marca: '000',
                imagenSelect: 0,
                listaProductos: [],
                listaImagens: [],
		    addetiqueta: '',
                dataReProd: {
                    subCat: '',
                    conten1: '',
                    conten2: '',
                    conten3: '',
                    id_prod: '',
                    cod_prod: '',
                    cod_cat: '',
                    cod_mar: '',
                    nom_pro: 'Nombre del producto seleccionado',
                    precio: '0.00',
                    catego: '',
                    marc: '',
                    garantia: '0',
                    estado: '',
			  marcaNew:''
                },
                imagenSelectLista: -1,
                imagenGuardadas: 0,
                imagenRecorrida: 0,
                listaImgEliminar: [],
            },
            methods: {
		 agregarEtiqueta(nombre) {
			this.addetiqueta = nombre;
			const nuevaCategoria = {
			  id: APP._data.listaSubCat.length + 1,
			  nombre: this.addetiqueta
			 };
			
			APP._data.listaSubCat.push(nuevaCategoria);
			$("#addSUB").modal("hide")
			console.log(nombre);
		    },
              cargarDataProd() {
                    const idProd = $("#producto_c").val()
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: {
                            idProd,
                            tipo: 'prod-s-data'
                        },
                        success: function(res) {
                            console.log(res + 'lionea 634')
                            res = JSON.parse(res);
                            APP._data.dataReProd = {
                                id_prod: res.prod_id,
                                cod_prod: '',
                                cod_cat: res.categoria_cod,
                                cod_mar: '',
                                subCat: res.sub_cat,
                                conten1: res.content1,
                                conten2: res.content2,
                                conten3: res.content3,
                                nom_pro: res.nombre,
                                precio: APP.formatNumerPrecio(res.precio),
                                catego: res.categoria,
                                marc: res.marca,
                                garantia: res.garantia,
                                estado: res.estado,
					  marcaNew:res.marca_cod
                            };
					
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_categoria.php",
                                data: {
                                    tipo: 'sub_c',
                                    cat: res.categoria_cod
                                },
                                success: function(respp) {
                                    console.log(respp + ' linea 660');
                                    APP._data.listaSubCat = JSON.parse(respp);
                                }
                            });
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_categoria.php",
                                data: {
                                    tipo: 'lis',
                                    cat: res.categoria_cod
                                },
                                success: function(resp) {
                                    console.log(resp + 'linea 675');
                                    APP._data.listaCategoria = JSON.parse(resp);
                                }
                            });
                            APP._data.listaImagens = res.imagenes;

                            $('#summernote-des').summernote('code', res.descripcion)
                            $('#summernote-esp').summernote('code', res.caracteristicas)
                            /*   console.log(res); */
                        }
                    });

                },
                resetImagenSele() {
                    this.imagenSelectLista = -1;
                },
                eliminarFoto() {
                    const itemTemp = this.listaImagens[this.imagenSelectLista]
                    if (itemTemp.foto_id != -1) {
                        this.listaImgEliminar.push(itemTemp)
                    }
                    this.listaImagens.splice(this.imagenSelectLista, 1);
                    this.imagenSelectLista = -1;
                },
                dismi() {
                    if (this.imagenSelectLista != -1) {
                        const itemTmep = this.listaImagens[this.imagenSelectLista]
                        this.listaImagens.splice(this.imagenSelectLista, 1);
                        if (this.imagenSelectLista > 0) {
                            this.imagenSelectLista--;
                        }
                        var arrTemp = [];
                        for (var i = 0; i < this.listaImagens.length; i++) {
                            if (i == this.imagenSelectLista) {
                                arrTemp.push(itemTmep);
                            }
                            arrTemp.push(this.listaImagens[i]);
                        }
                    }
                    this.listaImagens = arrTemp
                    this.reorganisarNumeros();
                },
                aumen() {
                    if (this.imagenSelectLista < this.listaImagens.length) {
                        const itemTmep = this.listaImagens[this.imagenSelectLista]
                        this.listaImagens.splice(this.imagenSelectLista, 1);
                        if (this.imagenSelectLista < this.listaImagens.length) {
                            this.imagenSelectLista++;
                        }
                        var arrTemp = [];

                        for (var i = 0; i < this.listaImagens.length; i++) {
                            if (i == this.imagenSelectLista) {
                                arrTemp.push(itemTmep);
                            }
                            arrTemp.push(this.listaImagens[i]);
                        }
                        if (this.imagenSelectLista == this.listaImagens.length) {
                            arrTemp.push(itemTmep);
                        }
                        this.listaImagens = arrTemp
                        this.reorganisarNumeros();
                    }

                },
                reorganisarNumeros() {
                    for (var i = 0; i < this.listaImagens.length; i++) {
                        this.listaImagens[i].orden = i + 1;
                    }
                },
                selectImagenLista(index) {
                    this.imagenSelectLista = index
                },
                cambiarImagen(urlv) {
                    /* console.log(urlv); */
                    //this.listaProductos=index;
                    $("#product_img").attr("src", urlv);
                },
                getURLImagen(imga) {
                    return URL.createObjectURL(imga);
                },
                addImagenLista(imagen) {
                    this.listaImagens.push(imagen)
                },
                formatNumerPrecio(num) {
                    return parseFloat(num + "").toFixed(2)
                },
                getDataCategorias() {

                },
                onCategoria(event) {
                    console.log(event.target.value)
                    this.cargarData()
                    /* $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_categoria.php",
                        data: {
                            tipo: 'sub_c',
                            cat: event.target.value
                        },
                        success: function(respp) {
                            console.log(respp + ' linea 660');
                            APP._data.listaSubCat = JSON.parse(respp);
                        }
                    });  */

                },
                onMarca(event) {
                    console.log(event.target.value)
                    this.cargarData()
                },
                onSubSelect(event) {
                    /* console.log(event.target.value) */
                    /* this.cargarData() */
                    /* this.dataReProd.subCat = event.target.value */
                },
                productoSeleccionado(prod_cod) {
                    console.log(prod_cod)
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: {
                            tipo: 'producto-onli',
                            cod: prod_cod
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp);
                            console.log('linea 755');
                            APP._data.dataReProd = {
                                cod_prod: prod_cod,
                                cod_cat: resp.cod_cate,
                                cod_mar: resp.cod_subc,
                                nom_pro: resp.nombre,
                                precio: resp.precio_venta,
                                catego: resp.nom_sub1,
                                marc: resp.nom_sub2,
                            }

                            $("#buscar-productos").modal('hide');
                        }
                    });

                },
                recargarDatatable() {
                    table.clear().draw(true);
                    for (var i = 0; i < this.listaProductos.length; i++) {
                        table.row.add([this.listaProductos[i].nom_prod, this.listaProductos[i].nom_sub1, this.listaProductos[i].nom_sub2, "<button onclick=\"APP.productoSeleccionado('" + this.listaProductos[i].cod_prod + "')\" class='btn btn-success' style='padding: 10px;padding-top: 5px;padding-bottom: 5px;'><i class='fa fa-check'></i></button>"]).draw(false);
                    }

                },
                cargarData() {
                    this.listaProductos = [];

                    if (this.categori != '000') {
                        const codCar = this.categori;
                        if (this.marca == '000') {
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_productos.php",
                                data: {
                                    tipo: 'prod-cat-all',
                                    ctg: codCar
                                },
                                success: function(resp) {
                                    console.log(resp)
                                    resp = JSON.parse(resp)

                                    APP._data.listaProductos = resp
                                    setTimeout(function() {
                                        APP.recargarDatatable()
                                    }, 100)
                                }
                            });

                        } else {
                            const codMarca = this.marca;
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_productos.php",
                                data: {
                                    tipo: 'prod-cat-marc',
                                    ctg: codCar,
                                    mrc: codMarca
                                },
                                success: function(resp) {
                                    resp = JSON.parse(resp)
                                    //console.log(resp)
                                    APP._data.listaProductos = resp
                                    setTimeout(function() {
                                        APP.recargarDatatable()
                                    }, 100)
                                }
                            });
                        }
                    }
                },
                refrescarimagenes() {
                    this.listaImagens.forEach(function(element, index) {
                        seImgFil(element, index)
                    });
                },
                verificadorGuardado() {
                    if (this.imagenRecorrida == this.listaImagens.length) {
                        swal("Guardado", "", "success").then(function() {

                             window.location.href = "./productos.php"; 
                        })
                    }
                },
                guardarImagenProd(prod_id) {
                    if (this.listaImagens.length > 0) {
                        this.listaImagens.forEach(function(element, index) {
                            if (element.foto_id == -1) {
                                var fd = new FormData();
                                fd.append('file', element.imagen_url);
                                fd.append('posicion', element.orden);
                                fd.append('produc', APP._data.dataReProd.id_prod);
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
                                    processData: false,
                                    beforeSend: function() {
                                        console.log('inicio');
                                    },
                                    error: function(err) {
                                        APP._data.imagenRecorrida++;
                                        console.log(err);
                                        APP.verificadorGuardado()
                                    },
                                    success: function(resp) {
                                        APP._data.imagenRecorrida++;
                                        console.log(resp);
                                        APP._data.imagenGuardadas++
                                        APP.verificadorGuardado()

                                    }
                                });
                            } else {
                                element.tipo = 'u'

                                $.ajax({
                                    type: "POST",
                                    url: '../ajax/ajs_imagen.php',
                                    data: element,
                                    success: function(resp) {
                                        APP._data.imagenRecorrida++;
                                        APP.verificadorGuardado()
                                        console.log(resp)
                                    }
                                });

                            }


                        });
                    } else {
                        swal("Guardado", "", "success").then(function() {

                             window.location.href = "./productos.php"; 
                        })
                    }
                },
                guardarProducto() {

                    if (this.dataReProd.subCat == undefined || this.dataReProd.subCat == '') {
                        this.dataReProd.subCat = null
                    }

		     if (this.addetiqueta.length>0) {
			this.dataReProd.OsubCat = this.addetiqueta
		     }

                    var dataR = {
                        ...this.dataReProd
                    }
                    dataR.descripcion = $('#summernote-des').summernote('code');
                    dataR.especificaciones = $('#summernote-esp').summernote('code');
                    dataR.tipo = "prod-u";

                    /*  consoe.log(dataR)
                     return */
                    console.log(dataR);
                    /* return */
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_productos.php",
                        data: dataR,
                        success: function(resp) {

                            if (isJson(resp)) {
                                resp = JSON.parse(resp);
                                console.log(resp)
                                var datosElimiar = {
                                    tipo: 'del',
                                    imasgg: JSON.stringify(APP._data.listaImgEliminar)
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "../ajax/ajs_imagen.php",
                                    data: datosElimiar,
                                    success: function(resp) {
                                        console.log(resp)
                                    }
                                });

                                APP.guardarImagenProd(dataR.id_prod)

                            } else {
                                swal("Error en el Servidor", "", "error");
                            }
                        }
                    });



                }
            },
            computed: {
                imagenSelectIMG() {
                    const item = this.listaImagens[this.imagenSelect]
                    return item.foto_id == -1 ? this.getURLImagen(item.imagen_url) : '../public/img/productos/' + item.imagen_url;
                },
                primeraImg() {
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

        function seImgFil(fil, id) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgPr_' + id).attr('src', e.target.result);
            };
            //console.log(fil)
            reader.readAsDataURL(fil.img);
        }

        var table;
        $(document).ready(function() {
            /*   $('.subCatSelecct').change(function() {
                  alert('other value');
              }); */
            APP.cargarDataProd();
            console.log($('#cod_categoria_default').val());
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_categoria.php",
                data: {
                    tipo: 'sub_c',
                    cat: $('#cod_categoria_default').val()
                },
                success: function(respp) {
                    /* console.log(respp + ' linea 660'); */
                    /*   APP._data.listaSubCat = JSON.parse(respp); */
                    let data = JSON.parse(respp);
                    console.log(data);
                    return
                    $("#subCatSelecct").empty()
                    /* return */
                    if (data.length !== 0) {
                        console.log(data);
                        data.forEach(element => {
                            $('#subCatSelecct').append($('<option>', {
                                value: element.sub_id,
                                text: element.nombre
                            }));
                        })
                        /*   data.forEach(element => {
                              $('#subCatSelecct').append($('<option>', {
                                  value: element.sub_id,
                                  text: element.nombre
                              }));
                          }); */
                    } else {
                        /*  $('#subCatSelecct')
                             .find('option')
                             .remove()
                             .end()
                             .append('<option selected>NO HAY ETIQUETAS</option>') */
                    }
                }
            });

            /*  subCatSelecct */

            $('#subCatSelecct').change(function() {
                console.log($('#catSelect').val());
            })

            $('#catSelect').change(function() {
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_categoria.php",
                    data: {
                        tipo: 'sub_c',
                        cat: $('#catSelect').val()
                    },
                    success: function(respp) {
                        let data = JSON.parse(respp);
                        if (!(data.find((obj) => obj.sub_id == APP._data.dataReProd.subCat))) {
                            APP._data.dataReProd.subCat = ''
                            if (data.length > 0) {
                                APP._data.dataReProd.subCat = data[0].sub_id
                            }
                        }
                        APP._data.listaSubCat = data
                        /*  if (data.length !== 0) {
                             console.log(data) */
                        /* $("#subCatSelecct").empty() */
                        /* data.forEach(element => {
                            $('#subCatSelecct').append($('<option>', {
                                value: element.sub_id,
                                text: element.nombre
                            }));
                        }); */
                        /*  APP._data.listaSubCat = data; */
                        /* APP._data.dataReProd.subCat = '' */
                        /* APP._data.listaSubCat = data; */
                        /*   } */
                        /* else {
                                                   $('#subCatSelecct')
                                                       .find('option')
                                                       .remove()
                                                       .end()
                                                       .append('<option selected>NO HAY ETIQUETAS</option>')
                                                   APP._data.dataReProd.subCat = ''
                                                   APP._data.listaSubCat = []
                                                   
                                               } */
                        /*   $("#subCatSelecct").empty()
                          data.forEach(element => {
                              $('#subCatSelecct').append($('<option>', {
                                  value: element.sub_id,
                                  text: element.nombre
                              }));
                          }); */
                    }
                });
            })
            $("#fil-imagen").change(function() {
                if (this.files && this.files[0]) {
                    const L_fil = this.files;
                    for (var i = 0; i < L_fil.length; i++) {

                        APP._data.listaImagens.push({
                            foto_id: -1,
                            imagen_url: L_fil[i],
                            orden: APP._data.listaImagens.length + 1
                        });

                    }


                    //APP.refrescarimagenes()
                    $("#fil-imagen").val("");
                }

            });

            //APP_PROD.getInfoProduc()
            table = $('#example').DataTable({
                language: {
                    url: '../utils/Spanish.json'
                }
            });
            $('#summernote-esp').summernote({
                height: '400px',
                lang: 'es-ES',
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
            $('#summernote-des').summernote({
                height: '400px',
                lang: 'es-ES',
                codemirror: { // codemirror options
                    theme: 'monokai'
                }
            });
            setTimeout(function() {
                $("#example_wrapper").attr("style", "width: 100%;")
            }, 300)

        })
    </script>

    </html>



<?php } else {
    header("Location: ../CYM/");
}
?>
