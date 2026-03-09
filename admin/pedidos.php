<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){



require "../utils/Tools.php";
require "../dao/ProductoDao.php";

$tools = new Tools();
$productoDao = new ProductoDao();

$dataConf = $tools->getConfiguracion();
//print_r($listaProd);

$sql = "SELECT pd.*,p.nombre,prod_cod,pe.*,u.nombres,te.nombre AS tipoenvio,tp.nombre AS tipopago,
SUM(precio * cantidad) AS total 
FROM pedido_detalles AS pd 
JOIN pedidos AS pe ON pe.pedido_id=pd.id_pedido
LEFT JOIN tipo_envio AS te ON pe.tipo_envio=te.id_tipo_envio
LEFT JOIN tipo_pago AS tp ON pe.tipo_pago=tp.id_tipo_pago
JOIN usuarios u ON u.use_id = pe.id_usuario
JOIN producto p ON p.prod_id = pd.id_producto  GROUP BY pd.id_pedido ORDER BY pe.pedido_id DESC ";
$result = $productoDao->exeSQL($sql);

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
                <div class="col-md-12 text-center">
                    <h2>Pedidos Actuales</h2>
                </div>
            </div>
            <div>



            
                <table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Pedido</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Tipo Envio</th>
                            <th class="text-center">Tipo Pago</th>
                            <th class="text-center">Celular</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Ver</th>
                            <th class="text-center">Descargar</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $row_ped) { ?>
                            <tr>
                                <td class="text-center"><?= $row_ped['pedido_id'] ?></td>
                                <td class="text-center"><?= $row_ped['nombres'] ?></td>
                                <td class="text-center"><?= $row_ped['fecha'] ?></td>
                                <td class="text-center"><?= $row_ped['total'] ?></td>
                                <td class="text-center"><?= $row_ped['tipoenvio'] ?></td>
                                <td class="text-center"><?= $row_ped['tipopago'] ?></td>
                                <td class="text-center">
                                    <?= $row_ped['celular'] ?> |&nbsp;
                                    <a href="<?= 'https://api.whatsapp.com/send?phone=51' . $row_ped['celular'] . '&text=' . utf8_encode('Buen dia, genero un pedido en nuestra web; N:') . $row_ped['pedido_id'];  ?>" title="Escribele al Cliente" target="_blank" rel="nofollow">
                                        <b style="font-weight: bold; font-size: 20px; color: green;" onmouseout="this.style.color='green'" onmouseover="this.style.color='red'">...<i class="fab fa-whatsapp"></i></b>
                                    </a>
                                </td>
                                <td class="text-center"><?= $tools->estados_pedido($row_ped['estado']) ?></td>
                                <td class="text-center"><a href="pedidos_vew.php?pd=<?= $row_ped['pedido_id'] ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                <td>

                                    <a class="btn btn-success" id="btnDescargarPedidos" target="_blank" href="../CYM/lista_pedidos_cliente.php/<?= $row_ped['pedido_id'] ?>"><i class='fa fa-download'></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
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
    function eliminarProd(prod) {
        $.ajax({
            type: "POST",
            url: "../ajax/ajs_productos.php",
            data: {
                tipo: 'del_prod_admin',
                prod
            },
            success: function() {
                location.reload();
            }
        });

    }

    $(document).ready(function() {
        //APP_PROD.getInfoProduc()

        $('#example').DataTable({
            "order": [
                [0, "desc"]
            ],
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
