<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {
    require_once "../extra/TasaCambioApi.php";


    $tasaCambioApi = new TasaCambioApi();
    $cambio = $tasaCambioApi->getTasaCambio();
    $tc = $cambio['cambio'];


    require "../utils/Tools.php";
    require "../dao/ProductoDao.php";
    require "../extra/ProductosApi.php";

    $tools = new Tools();
    $productoDao = new ProductoDao();
    $productosApi = new ProductosApi();
    $dataConf = $tools->getConfiguracion();
    //print_r($listaProd);

    $sql = "SELECT com.*,u.nombres,sys_dir_departamento.dep_nombre,sys_dir_provincia.pro_nombre,sys_dir_distrito.dis_nombre,tipo_pago.nombre AS tipopago,
tipo_envio.nombre AS tipoenvio,com.costo_flete
FROM compras AS com 
JOIN usuarios u ON u.use_id = com.id_usuario 
LEFT JOIN  sys_dir_departamento ON sys_dir_departamento.dep_id=com.departamento_id
LEFT JOIN  sys_dir_provincia ON sys_dir_provincia.pro_id=com.provincia_id
LEFT JOIN sys_dir_distrito ON sys_dir_distrito.dis_id=com.distrito_id
LEFT JOIN tipo_pago ON tipo_pago.id_tipo_pago=com.tipo_pago
LEFT JOIN tipo_envio ON tipo_envio.id_tipo_envio=com.tipo_envio
WHERE com.compra_id ='{$_GET['pd']}'";

    $data_pedido = $productoDao->exeSQL($sql)->fetch_assoc();
    /* echo "<pre>";
var_dump($data_pedido);
die();  */
    /*   */
    $sql = "SELECT com.*,u.nombres 
    FROM compras AS com 
    JOIN usuarios AS u ON u.use_id = com.usuario_cambio_estado where com.compra_id ='{$_GET['pd']}' ";
    $cambioestado = $productoDao->exeSQL($sql)->fetch_assoc();


    /* $sql2 = "SELECT com.*,u.nombres 
FROM compras AS com 
JOIN usuarios AS u ON u.use_id = com.usuario_cambio_estado ";
$UserCambioEstado = $productoDao->exeSQL($sql2)->fetch_assoc();
var_dump($cambioestado);
die(); */
    /* echo "<pre>";
var_dump($sql2);
die();  */
    /* var_dump($cambioestado);
die(); */

    $sql = "SELECT c.*,p.nombre,prod_cod FROM compras_detalles AS c JOIN producto p ON p.prod_id = c.id_producto WHERE c.id_compra='{$_GET['pd']}'";

    $lista_ped = $productoDao->exeSQL($sql);
    $lista_estados = [
        ["est" => 1, "nom" => 'En espera'],
        ["est" => 2, "nom" => 'Aprobado'],
        ["est" => 3, "nom" => 'Rechazado'],
        ["est" => 4, "nom" => 'Vendido']   
];
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
        <link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">
    </head>

    <body>

        <input id="user-client-selt" type="hidden" value="<?= $data_pedido['id_usuario'] ?>">

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


        <div class="section" style="padding-top: 10px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="compras.php" class="btn btn-warning">Regresar</a>
                        <button onclick="guardaresado()" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                <div class="row  justify-content-md-center" style="margin-bottom: 20px">
                    <div class="col-md-12 text-center">
                        <h2>Detalle de la Compra: #<?= $_GET['pd'] ?></h2>
                    </div>

                </div>
                <div class="mt-3 mb-3">
                    <label style="font-weight: bold;font-size: 18px;">Ultimo cambio realizado por:
                        <?php if (is_null($cambioestado)) : ?>
                        <?php else :
                            echo $cambioestado['nombres'] ?>
                        <?php endif; ?>

                    </label>
                </div>
                <input type="hidden" value="<?= $_GET['pd'] ?>" id="id_pedido_norl">
                <div class="row">
                    <input onchange="previewFile(this);" style="display: none" type="file" id="file-selt-ssl">
                    <div class="form-group col-md-8">

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button onclick="$('#file-selt-ssl').click()" class="btn btn-info">Agregar Documento</button>
                            </div>
                            <input value="<?= $data_pedido['archivo'] ?>" id="fil-doc-tempp" onkeyup="return false;" onkeydown="return false;" type="text" class="form-control" placeholder=".............." aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                                <a id="fil-doc-tempp-a" <?= strlen($data_pedido['archivo']) > 0 ? 'target="_blank"' : '' ?> href="<?= strlen($data_pedido['archivo']) > 0 ? '../public/data/files/compras/' . $data_pedido['id_usuario'] . "/" . $data_pedido['archivo'] : 'javascript:void(0)' ?>" class="btn btn-success">Ver</a>
                            </div>
                            <div class="input-group-prepend">
                                <button onclick="eliminar_doc()" class="btn btn-danger">Eliminar</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Estado </label>
                        <select id="estado-pedido-selet" class="form-control">
                            <?php

                            foreach ($lista_estados as $est_item) {
                                if ($data_pedido['estado'] == $est_item['est']) {
                                    echo "<option selected value='" . $est_item['est'] . "' >" . $est_item['nom'] . "</option>";
                                } else {
                                    echo "<option value='" . $est_item['est'] . "' >" . $est_item['nom'] . "</option>";
                                }
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div style="display: none" class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Usuario </label>
                        <input disabled value="<?= $data_pedido['nombres'] ?>" class="form-control" type="text">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fecha </label>
                        <input disabled value="<?= $data_pedido['fecha'] ?>" class="form-control" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Cliente </label>
                        <input disabled value="<?= $data_pedido['nombre'] ?>" class="form-control" name="phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input disabled value="<?= $data_pedido['email'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Deparmatento</label>
                        <input disabled value="<?= $data_pedido['dep_nombre'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Provincia</label>
                        <input disabled value="<?= $data_pedido['pro_nombre'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Distrito</label>
                        <input disabled <?php
                                        if ($data_pedido['dis_nombre'] !== null) : ?> value="<?= $data_pedido['dis_nombre'] ?>" <?php else : ?> value="<?= $data_pedido['distrito_opcional'] ?>" <?php endif; ?> class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Direccion</label>
                        <input disabled value="<?= $data_pedido['direccion'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Celular</label>
                        <input disabled value="<?= $data_pedido['celular'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Nor. Documento</label>
                        <input disabled value="<?= $data_pedido['nun_doc'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Forma de pago</label>
                        <input disabled value="<?= $data_pedido['tipopago'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tipo Envio</label>
                        <input disabled value="<?= $data_pedido['tipoenvio'] ?>" class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nota</label>
                        <textarea disabled class="form-control"><?= $data_pedido['notas'] ?></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Cod Producto</th>
                                    <th>Producto</th>
                                    <th class="text-center">Cnt</th>
                                    <th class="text-center">Precio</th>
                                    <th class="text-center">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_lis = 0;
                                $costeFlete = 0;
                                $porcentajeACobrar = 0;
                                $porcentajeACobrarDol = 0;
                                $porcentajeACobrarSol = 0;
                                if ($data_pedido['costo_flete'] == 7) {
                                    $costeFlete = ($data_pedido['costo_flete']);
                                } else if ($data_pedido['costo_flete'] == 30) {
                                    $costeFlete = ($data_pedido['costo_flete']);
                                    $costeFlete = number_format($costeFlete, 2, ".", ",");
                                } else {
                                    $costeFlete = 0;
                                }

                                $monedaFlete = '';
                                if ($data_pedido['costo_flete'] == 7) {
                                    $monedaFlete = '$ ';
                                } else if ($data_pedido['costo_flete'] == 30) {
                                    $monedaFlete = 'S/ ';
                                } else {
                                    $monedaFlete = '$ ';
                                }


                                $total = 0;
                                $totalSoles = 0;
                                foreach ($lista_ped as $row_pd) {
                                    $conRay = $productosApi->getDataProd($row_pd['prod_cod']);
                                    /* $total_lis += $row_pd['precio'] * $row_pd['cantidad']; */

                                    $total_lis += $row_pd['precio'] * $row_pd['cantidad'];

                                    $precio = number_format($row_pd['precio'], 2, '.', ',');
                                    $importe = number_format($row_pd['precio'] * $row_pd['cantidad'], 2, '.', ',');
                                    $total  = doubleval($total_lis);
                                    if ($data_pedido['costo_flete'] == 7) {
                                        $total = $total + ($data_pedido['costo_flete']);
                                        $porcentajeACobrarDol = ($total * 0.05);
                                        $total = $total + $porcentajeACobrarDol;
                                        $total = number_format($total, 2, ".", ",");
                                    } else {
                                        $total = $total + (intval($data_pedido['costo_flete']) / $tc);
                                        $porcentajeACobrarDol = ($total * 0.05);
                                        $total = $total + $porcentajeACobrarDol;
                                        $total = number_format($total, 2, ".", ",");
                                    }

                                 /*    if ($data_pedido['costo_flete'] == 7) {
                                        $totalSoles = ($total_lis * $tc);
                                        $totalSoles = ($totalSoles + (intval($data_pedido['costo_flete']) / $tc));
                                        $porcentajeACobrarSol = ($totalSoles * 0.05);
                                        $totalSoles = $totalSoles + $porcentajeACobrarSol;
                                        $totalSoles = number_format($totalSoles, 2, ".", ",");
                                    } else {
                                        $totalSoles = ($total_lis * $tc);
                                        $totalSoles = ($totalSoles + (intval($data_pedido['costo_flete'])));
                                        $porcentajeACobrarSol = ($totalSoles * 0.05);
                                    } */

                                ?>
                                    <tr>
                                        <td class="text-center"><?= $row_pd['prod_cod'] ?></td>
                                        <td><?= $row_pd['nombre'] ?></td>
                                        <td class="text-center"><?= $row_pd['cantidad'] ?></td>
                                        <td class="text-center">$<?= number_format($row_pd['precio'], 2, ".", ",") ?></td>
                                        <td class="text-center">$<?= number_format($row_pd['precio'] * $row_pd['cantidad'], 2, ".", ",") ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <?php
                            /*     if ($data_pedido['costo_flete'] == 7) {
                                    $porcentajeACobrar = $porcentajeACobrarDol;
                                } else if ($data_pedido['costo_flete'] == 30) {
                                    $porcentajeACobrar = $porcentajeACobrarSol;
                                } else {
                                    $porcentajeACobrar = 0;
                                }

 */
                             /*    if($data_pedido['moneda_id'] == 1){
                                    $total = $totalSoles;
                                }else{
                                    $total = $total;
                                } */
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>SubTotal</strong></td>
                                    <td class="text-center">$<?= number_format($total_lis, 2, ".", ",") ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Flete</strong></td>
                                    <td class="text-center"><?= $monedaFlete . '' . $costeFlete ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Comision</strong></td>
                                    <td class="text-center">$<?= number_format($porcentajeACobrarDol, 2, ".", ",") ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td class="text-center">$<?= number_format($total, 2, ".", ",") ?></td>
                                </tr>
                            </tfoot>
                        </table>
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
        <script src="../public/plugin/sweetalert2/vue-swal.js"></script>
    </body>

    <script>
        function previewFile(input) {
            if ($("#file-selt-ssl").val().length > 0) {
                var fd = new FormData();
                fd.append('file', $("#file-selt-ssl")[0].files[0]);
                fd.append('clien', $("#user-client-selt").val());
                fd.append('pedido', "<?= $_GET['pd'] ?>");
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                $('.progress-bar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);

                            }
                        }, false);
                        return xhr;
                    },
                    type: 'POST',
                    url: '../ajax/upload_file_doc_clie_compras.php',
                    data: fd,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        console.log('inicio');
                        $(".progress").show()
                        $('.progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0);
                    },
                    error: function(err) {
                        console.log(err);
                        swal("Alerta", "No se pudo subir el archivo", "warning");
                    },
                    success: function(resp) {
                        console.log(resp);
                        resp = JSON.parse(resp);
                        if (resp.res) {
                            $("#fil-doc-tempp").val(resp.dstos)
                            $("#fil-doc-tempp-a").attr("href", "../public/data/files/" + $("#user-client-selt").val() + "/" + resp.dstos)
                            $("#fil-doc-tempp-a").attr("target", "_blank")
                        } else {
                            swal("Alerta", "No se pudo subir el archivo", "warning");
                        }
                        setTimeout(function() {
                            $('.progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0);
                            $(".progress").hide()
                        }, 1000)
                    }
                });
            }
        }

        function guardaresado() {
            $.ajax({
                type: "POST",
                url: '../ajax/ajs_consulta.php',
                data: {
                    tipo: 'udt-compra-estd',
                    pedido: $("#id_pedido_norl").val(),
                    estado: $("#estado-pedido-selet").val()
                },
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                }
            });
        }

        function eliminar_doc() {
            $.ajax({
                type: "POST",
                url: '../ajax/ajs_consulta.php',
                data: {
                    tipo: 'del-pedido-nrl',
                    pedido: $("#id_pedido_norl").val()
                },
                success: function(resp) {
                    console.log(resp);
                    location.reload();
                }
            });

        }


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
