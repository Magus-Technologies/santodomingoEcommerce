<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {



    require "../utils/Tools.php";

    $tools = new Tools();
    $dataConf = $tools->getConfiguracion();

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
                        <h2>Productos Registrados como Remate</h2>
                    </div>
                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio Normal</th>
                                <th>Precio Remate</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyRemate">
                            <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Ajustar Precio -->
                <div class="modal fade" id="modalAjustarPrecio" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Ajustar Precio de Remate</h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="ajustarId">
                                <p id="ajustarNombre" class="font-weight-bold mb-2"></p>
                                <div class="form-group">
                                    <label>Precio Normal: <strong id="ajustarPrecioNormal"></strong></label>
                                </div>
                                <div class="form-group">
                                    <label>Costo: <strong id="ajustarCosto" class="text-muted"></strong></label>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrecioRemate">Precio de Remate (S/.)</label>
                                    <input type="number" id="inputPrecioRemate" class="form-control" step="0.01" min="0" placeholder="Ej: 18.00">
                                    <small class="text-muted">Se recomienda igual o menor al costo.</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="guardarPrecioRemate()">Guardar</button>
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
        var dataTable;

        function cargarRemate() {
            $.ajax({
                url: "../ajax/proxy_remate.php?accion=listar",
                type: "GET",
                dataType: "json",
                success: function(resp) {
                    var tbody = $('#tbodyRemate');
                    tbody.empty();
                    if (!resp.success || !resp.data || resp.data.length === 0) {
                        tbody.html('<tr><td colspan="5" class="text-center">No hay productos en remate.</td></tr>');
                        return;
                    }
                    $.each(resp.data, function(i, row) {
                        var precioNormal = row.precio ? 'S/ ' + parseFloat(row.precio).toFixed(2) : '-';
                        var precioRem    = row.precio_remate ? '<span class="badge badge-danger">S/ ' + parseFloat(row.precio_remate).toFixed(2) + '</span>' : '<span class="text-muted">Sin ajuste</span>';
                        var stock        = row.stock !== undefined ? row.stock : '-';
                        var tr = '<tr>' +
                            '<td>' + (row.nombre || '') + '</td>' +
                            '<td>' + precioNormal + '</td>' +
                            '<td>' + precioRem + '</td>' +
                            '<td>' + stock + '</td>' +
                            '<td>' +
                            '<button onclick="abrirAjuste(' + row.id + ',\'' + (row.nombre||'').replace(/'/g,"\\'") + '\',' + (row.precio||0) + ',' + (row.costo||0) + ',' + (row.precio_remate||0) + ')" class="btn btn-info btn-sm mr-1"><i class="fa fa-edit"></i> Ajustar Precio</button>' +
                            '<button onclick="quitarRemate(' + row.id + ')" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Quitar</button>' +
                            '</td>' +
                            '</tr>';
                        tbody.append(tr);
                    });
                    if (dataTable) { dataTable.destroy(); }
                    dataTable = $('#example').DataTable({ language: { url: '../utils/Spanish.json' } });
                },
                error: function() {
                    $('#tbodyRemate').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar productos.</td></tr>');
                }
            });
        }

        function abrirAjuste(id, nombre, precio, costo, precioRemate) {
            $('#ajustarId').val(id);
            $('#ajustarNombre').text(nombre);
            $('#ajustarPrecioNormal').text('S/ ' + parseFloat(precio).toFixed(2));
            $('#ajustarCosto').text('S/ ' + parseFloat(costo).toFixed(2));
            $('#inputPrecioRemate').val(precioRemate > 0 ? parseFloat(precioRemate).toFixed(2) : '');
            $('#modalAjustarPrecio').modal('show');
        }

        function guardarPrecioRemate() {
            var id           = $('#ajustarId').val();
            var precioRemate = $('#inputPrecioRemate').val();
            if (!precioRemate || isNaN(precioRemate) || parseFloat(precioRemate) < 0) {
                alert('Ingrese un precio válido');
                return;
            }
            $.ajax({
                url: "../ajax/proxy_remate.php",
                type: "POST",
                data: { accion: 'actualizar', id: id, precio_remate: precioRemate },
                dataType: "json",
                success: function(resp) {
                    if (resp.success) {
                        $('#modalAjustarPrecio').modal('hide');
                        if (dataTable) { dataTable.destroy(); dataTable = null; }
                        cargarRemate();
                    } else {
                        alert(resp.message || 'Error al guardar');
                    }
                },
                error: function() { alert('Error de conexión'); }
            });
        }

        function quitarRemate(id) {
            if (!confirm('¿Quitar este producto del remate?')) return;
            $.ajax({
                url: "../ajax/proxy_remate.php",
                type: "POST",
                data: { accion: 'quitar', id: id },
                dataType: "json",
                success: function(resp) {
                    if (resp.success) {
                        if (dataTable) { dataTable.destroy(); dataTable = null; }
                        cargarRemate();
                    } else {
                        alert(resp.message || 'Error al quitar del remate');
                    }
                },
                error: function() { alert('Error de conexión'); }
            });
        }

        $(document).ready(function() {
            cargarRemate();
        });
    </script>

    </html>



<?php } else {
    header("Location: ../CYM/");
}
?>
