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
    //print_r($listaProd);

    $sql = "SELECT * FROM tipo_pago";
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
        <meta name="description" content="Los Mejores en Hardware.">
<meta name="keywords" content="tarjeta de video, procesador, hardware, laptop, pc gamer, gaming, memoria ram, GPU, CPU, disco duro, ssd, m.2">

        <title>VIÑASANTODOMINGO</title>
        <!-- Favicon Icon -->
        <link rel="shortcut icon" type="image/x-icon" href="">
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
                        <h2>Tipos de Pago</h2>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 5px;">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal_add_user">Agregar</button>
                    <div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div style="background-color: #ff324d;color: white" class="modal-header">
                                    <h3 style="color: white" class="modal-title" id="exampleModalLabel">Nueva Forma de Pago</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="form_pago_add.php" method="post">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label>Nombre</label>
                                            <input name="nombre" required type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div style="background-color: #ff324d;color: white" class="modal-header">
                                    <h3 style="color: white" class="modal-title" id="exampleModalLabel">Nuevo Vendedor</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editarFrmFormaPago">
                                    <input name="idTipoPago" id="idTipoPago" type="hidden" class="form-control" value="">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombres</label>
                                            <input name="nombreEdit" type="text" class="form-control" id="nombreEdit">
                                        </div>
                                        <div class="form-group">
                                            <label>Visible</label>
                                            <select name="estadoEdit" id="estadoEdit" class="form-control">
                                                <option value="0">No Visible</option>
                                                <option value="1">Visible</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                </div>
                <div>
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">Tipo Pago</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row_ped) { ?>
                                <tr>
                                    <td class="text-center">#<?= $row_ped['id_tipo_pago'] ?></td>
                                    <td class="text-center"><?= $row_ped['nombre'] ?></td>
                                    <td class="text-center"><?php
                                                            if ($row_ped['estado'] == '0') {
                                                                echo "No visible";
                                                            } else if ($row_ped['estado'] == '1') {
                                                                echo "Visible";
                                                            }
                                                            ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-xs btn-warning" id="btnEditar" onclick="editUsuario(<?php echo $row_ped['id_tipo_pago'] ?>)" style="color: white"><i class="fa fa-edit"></i></button>
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
                            <p class="mb-md-0 text-center text-md-left">© 2025 Todos los derechos reservados por Magus Technologies</p>
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>

    <script>
        /*  function eliminarProd(prod) {
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

    } */

        function deleteUsuario(id) {
            Swal.fire({
                title: '¿Que desea eliminar el usuario',
                showDenyButton: true,
                confirmButtonText: 'Confirmar',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "contro_del_user.php",
                        data: {
                            tipo: 'del_prod_admin',
                            id
                        },
                        success: function(resp) {
                            let data = JSON.parse(resp)
                            if (data.res) {
                                Swal.fire(
                                    'Bien',
                                    data.msj,
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.msj,
                                })
                            }
                        }
                    });
                }
            })

        }

        function editUsuario(id) {

            $("#modal_edit_user").modal("show");
            $("#modal_edit_user")
                .find(".modal-title")
                .text("Editar forma de pago N° " + id);
            $.ajax({
                url: "contro_get_forma_pago.php",
                data: {
                    id: id,
                },
                type: "post",
                success: function(resp) {
                    let data = JSON.parse(resp)
                    console.log(data);
                    $('#nombreEdit').val(data.nombre)
                    $('#estadoEdit').val(data.estado)

                    $('#idTipoPago').val(id)
                }
            })
        }

        /*    function editClave(id) {

               $("#modal_edit_user_pass").modal("show");
               $("#modal_edit_user_pass")
                   .find(".modal-title")
                   .text("Editar usuario N° " + id);
               $.ajax({
                   url: "contro_get_user.php",
                   data: {
                       id: id,
                   },
                   type: "post",
                   success: function(resp) {
                       let data = JSON.parse(resp)
                       console.log(data);
                     
                       $('#idTipoPagoPass').val(data.use_id)
                   }
               })
           } */




        $(document).ready(function() {
            $('#editarFrmFormaPago').submit(function(e) {
                e.preventDefault()
                if ($('#nombreEdit').val() == '') {
                    $("#modal_edit_user").modal("hide");
                    Swal.fire({
                        title: 'No puede dejar campos vacios',
                        icon: 'question',
                        iconHtml: '!!',
                        cancelButtonText: 'ok',
                    })
                } else {
                    let data = $(this).serializeArray();
                    /*  console.log(data);
                     return */
                    $.ajax({
                        url: "contro_edit_forma_pago.php",
                        data: data,
                        type: "post",
                        success: function(resp) {
                            let data = JSON.parse(resp)
                            if (data.res) {
                                $("#modal_edit_user").modal("hide");
                                Swal.fire(
                                    'Bien',
                                    data.msj,
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                $("#modal_edit_user").modal("hide");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.msj,
                                })
                            }
                        }
                    })
                }

            })
            $('#editarFrmFormaPagoPass').submit(function(e) {
                e.preventDefault()
                if ($('#claveEditUser').val() == '') {
                    $("#modal_edit_user_pass").modal("hide");
                    Swal.fire({
                        title: 'No puede dejar campos vacios',
                        icon: 'question',
                        iconHtml: '!!',
                        cancelButtonText: 'ok',
                    })
                } else {
                    let data = $(this).serializeArray();
                    /* console.log(data);
                    return */
                    $.ajax({
                        url: "contro_edit_user_pass.php",
                        data: data,
                        type: "post",
                        success: function(resp) {
                            let data = JSON.parse(resp)
                            console.log(resp);
                            if (data.res) {
                                $("#modal_edit_user_pass").modal("hide");
                                Swal.fire(
                                    'Bien',
                                    data.msj,
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                $("#modal_edit_user_pass").modal("hide");
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.msj,
                                })
                            }
                        }
                    })
                }

            })

            $('#btnBorrar').click(function() {
                let id = $(this).attr('data-id')
                /* console.log(id);
                console.log('hola'); */
            })
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
