<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){



require "../utils/Tools.php";
require "../dao/MarcaSeleccionDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../dao/ProductoDao.php";
require "../utils/ApiExterna.php";

$tools = new Tools();
$marcas = new MarcaSeleccionDao();
$categoria = new GrupoCategoriaDao();
$productoDao = new ProductoDao();
$apiExterna = new ApiExterna();

$dataConf = $tools->getConfiguracion();

$listaMarca = $marcas->getDataOnli();
$listaCatego = $categoria->getGategoliaOnli();

// Obtener productos de la API externa
$apiResponse = $apiExterna->getProductos(1, 1000);
$listaProd = [];
if ($apiResponse['success'] && isset($apiResponse['data'])) {
    foreach ($apiResponse['data'] as $prod) {
        $listaProd[] = [
            'prod_id' => $prod['id_producto'],
            'nom_prod' => $prod['nombre'],
            'categoria' => $prod['categoria_id'],
            'marca' => 'N/A',
            'stock' => $prod['cantidad'],
            'precio' => $prod['precio']
        ];
    }
}


//echo "sddddddd";
//print_r($listaCatego);

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


    <div class="section">
        <div class="container">
            <div class="row  justify-content-md-center" style="margin-bottom: 20px">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-md-12 text-right">
                        <a href="ofertas.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Atras</a>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal_listaProduc">Buscar producto</button>
                    <button onclick="APP.guardarOferta()" class="btn btn-primary">Guardar</button>
                </div>
            </div>

            <div class="row" id="contenedor">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Producto</label>
                        <input type="hidden" id="id_prod">
                        <input disabled type="text" class="form-control" id="producto-select" aria-describedby="emailHelp" placeholder="nombre del producto">
                        <small style="font-size: 16px; font-weight: bold;" id="textoAyuda" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group col-md-4" style="float: left;">
                        <label for="exampleInputPassword1">Termino</label>
                        <input id="termino" type="date" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4" style="float: left;">
                        <label for="exampleInputPassword1">Cantidad</label>
                        <input id="cantidad" type="text" class="form-control" @keypress="onlyNumber" placeholder="cantidad de oferta">
                    </div>
                    <div class="form-group col-md-4" style="float: left;">
                        <label for="exampleInputPassword1">precio</label>
                        <input id="precio" type="text" class="form-control" @keypress="onlyNumber" placeholder="Precio de oferta">
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
                                <label for="recipient-name" class="col-form-label">Buscar producto</label>
                                <input type="text" id="buscar-producto" class="form-control" placeholder="Buscar por nombre o código...">
                            </div>
                            <div class="form-group">
                                <table id="tabla-productos" class="table table-striped table-bordered table-sm" style="width:100%">
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
                                        foreach ($listaProd as $row) {       ?>
                                            <tr>
                                                <td id="nom_<?= $row['prod_id'] ?>"><?= htmlspecialchars($row['nom_prod']) ?></td>
                                                <td><?= htmlspecialchars($row['categoria']) ?></td>
                                                <td><?= htmlspecialchars($row['marca']) ?></td>
                                                <td id="stock_<?= $row['prod_id'] ?>"><?= $row['stock'] ?></td>
                                                <td id="precio_<?= $row['prod_id'] ?>"><?= number_format($row['precio'], 2) ?></td>
                                                <td><button onclick="selectProducto(<?= $row['prod_id'] ?>)" style="padding: 10px;padding-left: 15px;" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></button></td>
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

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>

<script>
    const APP = new Vue({
        el: '#contenedor',
        data: {

        },
        methods: {
            guardarOferta() {
                if (($("#id_prod").val() + "").length > 0) {
                    // Validar que el precio de oferta sea menor que el precio real
                    // y que la cantidad no exceda el stock disponible
                    if (parseFloat($("#precio").val()) > parseFloat(precioC)) {
                        swal("No se pudo guardar esta oferta", "El precio de oferta debe ser menor al precio real ($" + parseFloat(precioC) + ")", "warning");
                    } else if (parseFloat($("#cantidad").val()) > parseFloat(stockC)) {
                        swal("No se pudo guardar esta oferta", "La cantidad no puede exceder el stock disponible (" + parseInt(stockC) + " unidades)", "warning");
                    } else {
                        if ($('#termino').val() !== '' && $('#cantidad').val() !== '' && $('#precio').val() !== '') {
                            const dataR = {
                                tipo: 'in',
                                prod: $("#id_prod").val(),
                                termino: $("#termino").val(),
                                precio: $("#precio").val(),
                                cantidad: $("#cantidad").val(),
                                stocA: stockPR
                            }

                            $.ajax({
                                type: "POST",
                                url: '../ajax/ajs_ofertas.php',
                                data: dataR,
                                success: function(resp) {
                                    resp = JSON.parse(resp)
                                    if (resp.res) {
                                        location.href = "ofertas.php";
                                    } else {
                                        swal("No se pudo guardar esta oferta", "No se puede agregar mas de 1 oferta por producto", "warning");
                                    }
                                    console.log(resp);
                                }
                            });
                        }else{
                            swal("No se pudo guardar esta oferta", "Llene todos los campos", "warning");
                        }

                    }
                } else {
                    swal("No ha seleccionado un producto", "", "warning");
                }
            },
            onlyNumber($event) {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
            }
        }
    });
    var stockPR = 0;
    var precioC
    var stockC
    function selectProducto(ide) {
        $("#id_prod").val(ide);
        $("#producto-select").val($("#nom_" + ide).text());

         stockC = $("#stock_" + ide).text();
        precioC = $("#precio_" + ide).text();
        stockPR = stockC;
        $("#textoAyuda").text("Stock actual: " + parseInt(stockC) + ",  precio actual: $" + parseFloat(precioC));
        $('#modal_listaProduc').modal('hide');
    }

    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }


    var table;
    $(document).ready(function() {

        table = $('#tabla-productos').DataTable({
            language: {
                url: '../utils/Spanish.json'
            }
        });

        // Búsqueda en tiempo real
        $('#buscar-producto').on('keyup', function() {
            table.search(this.value).draw();
        });

    })
</script>

</html>




<?php } else {
    header("Location: ../CYM/");
}
?>
