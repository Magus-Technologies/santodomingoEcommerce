<?php

session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {




    require "../utils/Tools.php";
    require "../dao/ProductoDao.php";

    $tools = new Tools();
    $productoDao = new ProductoDao();

    $dataConf = $tools->getConfiguracion();

    $listaProd22 = $productoDao->getListaProd();

    $listaProd = $productoDao->exeSQL("SELECT 
  prod.prod_id,
  prod.nombre,
  cate.nombre_cate,
  exclu.*
FROM
  productos_exclusivos AS exclu 
  INNER JOIN producto AS prod 
    ON exclu.prod_id = prod.prod_id 
  INNER JOIN grupo_seleccion AS cate 
    ON prod.categoria = cate.codi_categoria ");
    //print_r($listaProd);

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
        <!-- Slick CSS -->
        <link rel="stylesheet" href="../public/assets/css/slick.css">
        <link rel="stylesheet" href="../public/assets/css/slick-theme.css">
        <!-- Style CSS -->
        <link rel="stylesheet" href="../public/assets/css/style.css">
        <link rel="stylesheet" href="../public/assets/css/responsive.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

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
        <?php include "../fragment/nav_bar_admin.php" ?>>
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
                    <div class="col-md-12 text-center">
                        <h2>Lisa de productos exclusivos</h2>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-md-12 text-right">
                        <a href="productos_oferta_add.php" data-toggle="modal" data-target="#modal_listaProduc" class="btn btn-success"><i class="fa fa-plus"></i> Agregar</a>
                    </div>
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaProd as $row) {       ?>
                                <tr>
                                    <td style="color: white"><?= $row['id_exclu'] ?></td>
                                    <td><?= $row['nombre'] ?></td>
                                    <td><?= $row['nombre_cate'] ?></td>
                                    <td><button onclick="eliminar(<?= $row['id_exclu'] ?>)" style="padding: 10px;padding-left: 15px;" class="btn btn-danger"><i class="fa fa-times"></i></button></td>
                                </tr>
                            <?php    }

                            ?>


                        </tbody>
                    </table>
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
                            <table id="tabla-productos" class="table table-striped table-bordered" style="width:100%">
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
                                    foreach ($listaProd22 as $row) {       ?>
                                        <tr>
                                            <td id="nom_<?= $row['prod_id'] ?>"><?= $row['nom_prod'] ?></td>
                                            <td><?= $row['categoria'] ?></td>
                                            <td><?= $row['marca'] ?></td>
                                            <td id="stock_<?= $row['prod_id'] ?>"><?= $row['stock'] ?></td>
                                            <td id="precio_<?= $row['prod_id'] ?>"><?= $row['precio'] ?></td>
                                            <td><button onclick="selectProducto(<?= $row['prod_id'] ?>)" style="padding: 10px;padding-left: 15px;" class="btn btn-info"><i class="fa fa-check"></i></button></td>
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
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    </body>

    <script>
        function eliminar(exclu) {
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_exclusivo.php",
                data: {
                    tipo: 'del',
                    excl: exclu
                },
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                }
            });
        }

        function selectProducto(ide) {

            const nom = ($("#nom_" + ide).text());
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_exclusivo.php",
                data: {
                    tipo: 'in',
                    prod: ide
                },
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                }
            });

        }

        var table;
        $(document).ready(function() {
            //APP_PROD.getInfoProduc()

            table = $('#example').DataTable({
                "order": [
                    [0, "desc"]
                ],
                language: {
                    url: '../utils/Spanish.json'
                }
            });

            $('#tabla-productos').DataTable({
                language: {
                    url: '../utils/Spanish.json'
                }
            });



        })
    </script>

    </html>




<?php } else {
    header("Location: ../CYM/");
}
?>
