<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/UsuarioDao.php";
require "../utils/Tools.php";

require_once "../extra/TasaCambioApi.php";


$tasaCambioApi = new TasaCambioApi();
$cambio = $tasaCambioApi->getTasaCambio();
$tc = $cambio['cambio'];

/* echo $tc; */
/* die(); */

$conexion = (new Conexion())->getConexion();
$tools = new Tools();
$productoDao = new ProductoDao();
$dataConf = $tools->getConfiguracion();

$departementos = $conexion->query("SELECT * FROM sys_dir_departamento")->fetch_all(MYSQLI_ASSOC);
$formEnvio = $conexion->query("SELECT * FROM tipo_envio")->fetch_all(MYSQLI_ASSOC);
$formPago = $conexion->query("SELECT * FROM tipo_pago")->fetch_all(MYSQLI_ASSOC);
/* var_dump($departementos); */
$isLogin = false;

if (isset($_SESSION['usuario'])) {
    $isLogin = true;
}


?>
<!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>

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
<link rel="stylesheet" href="../public/assets/css/pc.css">
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
    <div style="display: none" id="loader-menor">
        <div class="loadingio-spinner-double-ring-8kmkrab6ncg">
            <div class="ldio-407auvblvok">
                <div></div>
                <div></div>
                <div>
                    <div></div>
                </div>
                <div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Screen Load Popup Section -->

    <!-- START HEADER -->
    <?php include "../fragment/head_secon.php"; ?>
    <!-- END HEADER -->


    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP -->
        <div class="section" style="padding: 0;">
            <div class="container">
                <div class="explanation">
                    <h1>Arma y cotiza tu propia computadora</h1>
                    <p>Si necesitas asesor&iacute;a, solo d&iacute;noslo.</p>
                </div>
                <div class="summary-products">
                    <div class="summary">
                        <div class="categories-header">
                            <h2>Categor&iacute;as</h2>
                        </div>
                        <ul>
                            <li class="category-item" data-category="001">
                                <a href="#" class="category-link" data-category="001">Vino Tinto</a>
                                <div class="selected-product" id="selected-product-001">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="002">
                                <a href="#" class="category-link" data-category="002">Vino Blanco</a>
                                <div class="selected-product" id="selected-product-002">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="004">
                                <a href="#" class="category-link" data-category="004">Vino Rosado</a>
                                <div class="selected-product" id="selected-product-004">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="003">
                                <a href="#" class="category-link" data-category="003">Espumante</a>
                                <div class="selected-product" id="selected-product-003">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="006">
                                <a href="#" class="category-link" data-category="006">Pisco</a>
                                <div class="selected-product" id="selected-product-006">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="007">
                                <a href="#" class="category-link" data-category="007">Gabinete</a>
                                <div class="selected-product" id="selected-product-007">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="005">
                                <a href="#" class="category-link" data-category="005">Fuente</a>
                                <div class="selected-product" id="selected-product-005">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                            <li class="category-item" data-category="008">
                                <a href="#" class="category-link" data-category="008">Ventilaci&oacute;n</a>
                                <div class="selected-product" id="selected-product-008">
                                    <div class="category-title">Procesador</div>
                                    <div class="product-details"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="products">
                        <h2>Productos</h2>
                        <div class="product-list" id="product-list">
                            <?php
                            // use app\controllers\productsController;

                            // $controller = new productsController();
                            // $categoryId = 1; // Default category to display
                            // $cpuCategory = null; // Initialize with null
                            // $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page or default to 1
                            // echo $controller->listProductsController(1, $categoryId, $cpuCategory, $page);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div class="assembly-service">
                        <label>
                            Servicio de ensamble profesional (incluye armado y testeo) S/ 35.90
                            <input type="checkbox" id="assembly-checkbox">
                        </label>
                    </div>
                    <div class="button disabled" id="total-price">S/ 0.00</div>
                    <div class="action-button">
			
                        <a href="#" class="button form-cotizacion" style="background-color: #4746EB !important;">Enviar cotizaci&oacute;n</a>
                        <a href="#" class="button" style="background-color: #4746EB !important;">Agregar al carrito</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
        <div class="modal fade" id="cotizacionModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index: 10000">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h3 class="modal-title" id="exampleModalLabel">Datos de Cotizacion</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre y Apellidos</label>
                            <input type="text" class="form-control" id="nombre" aria-d>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer">
			 <button id="btnImprimircoti" type="button" class="btn btn-primary">Imprimir</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="btnPagarIzipay" type="button" class="btn btn-primary button send-quotation">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="heading_s1 mb-md-0 heading_light">
                            <h3>Suscr&iacute;bete a nuestro bolet&iacute;n</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter_form">
                            <form action="#">
                                <input type="text" required="" class="form-control rounded-0" placeholder="Introduzca la direcci&oacute;n de correo electr&oacute;nico">
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
    <?php include "../fragment/footer_gen.php" ?>
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

    <script src="../public/plugin/sweetalert2/vue-swal.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://js.openpay.pe/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://js.openpay.pe/openpay-data.v1.min.js"></script>
    <!-- 3 : theme néon should be loaded in the HEAD section   -->
    <script src="../public/js/products.js"></script>
</body>

</html>
