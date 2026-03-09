<?php
    session_start();


    require "../dao/Session.php";
    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();

    if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'usuarios digital') {


        require "../utils/Tools.php";
        require "../dao/ProductoDao.php";
        require_once "../utils/Conexion.php";

        $conexion = (new Conexion())->getConexion();


        $tools = new Tools();
        $productoDao = new ProductoDao();

        $dataConf = $tools->getConfiguracion();
//print_r($listaProd);

        if ($_SESSION['idrol'] == 1):
            $sql = "SELECT a.*,b.nombres AS vendedor FROM  cotizaciones a LEFT JOIN usuarios b ON a.idusuario = b.use_id
                                 ORDER BY a.fecha_create ASC ";
        else:
            $sql = "SELECT a.*,b.nombres AS vendedor FROM  cotizaciones a LEFT JOIN usuarios b ON a.idusuario = b.use_id WHERE a.idusuario = " . $_SESSION['usuario'] . '
                                    ORDER BY a.fecha_create ASC';
        endif;

        $result = $conexion->query($sql);
        $result = $result->fetch_all(MYSQLI_ASSOC);


        $sql = "SELECT use_id AS id, CONCAT(IF(dni<>'',CONCAT(dni,' | '),''),nombres) AS text FROM usuarios ORDER BY nombres ASC";

        $usuarios = $conexion->query($sql);
        $usuarios = $usuarios->fetch_all(MYSQLI_ASSOC);
        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <!-- Meta -->
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="Anil z" name="author">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description"
                  content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
            <meta name="keywords"
                  content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

            <title>VIÑASANTODOMINGO</title>
            <!-- Favicon Icon -->
            <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
            <!-- Animation CSS -->
            <link rel="stylesheet" href="../public/assets/css/animate.css">
            <!-- Latest Bootstrap min CSS -->
            <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
            <!-- Google Font -->
            <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap"
                  rel="stylesheet">
            <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
                  rel="stylesheet">
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


            <style>
                .btn {
                    padding: 5px 12px !important;
                }

                .btn i {
                    font-size: 13px;
                    margin-right: 0px;
                }

                .btn-success-2 {
                    color: #fff;
                    background-color: #02a499 !important;
                    border-color: #02a499;
                }

                .dataTables_wrapper .dataTables_paginate {
                    text-align: center; /* Centra el contenido */
                }

                input, select {
                    height: 46px !important;
                }

                .select2-container .select2-selection--single {
                    height: 46px !important;
                }

                .select2-container--default
                .select2-selection--single
                .select2-selection__rendered {
                    line-height: 43px !important;
                }

                #example_filter {
                    display: none !important;
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
                    <div class="col-md-12 text-center">
                        <h2>Cotizaciones Actuales</h2>
                    </div>
                </div>
                <style>
                    .row-with-elements {
                        display: flex;
                        justify-content: space-between;
                        width: 100%;
                    }
                </style>
                <!---->
                <!---->
                <!---->
                <!---->
                <div class="row" style="margin-bottom: 5px; text-align: end;">
                    <div style="display: inline-block; margin-left: 10px; width: 100%">
                        <div style="display: inline-block;margin-left: 20px">
                            <label>Total Comisiones:</label>
                            <h2 id="ingreso_comisiones">S/. 0.00</h2>
                        </div>
                        <div style="display: inline-block;margin-left: 20px">
                            <label>Total extras:</label>
                            <h2 id="ingreso_comisiones_extra">S/. 0.00</h2>
                        </div>
                        <div style="display: inline-block;margin-left: 20px">
                            <label>Total Pago:</label>
                            <h2 id="ingreso_suma_comisones">S/. 0.00</h2>
                        </div>
                    </div>
                </div>

                <!---->
                <!---->
                <!---->
                <div class="row" style="margin-bottom: 5px;">
                    <div class="row-with-elements">
                        <a class="btn btn-primary" href="usuarios_digitales_cotizacion.php">Agregar</a>
                        <?php if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin'): ?>
                            <div style="display: inline-block">
                                <label>Usuario : </label>
                                <select class="select2" style="width: 250px">
                                    <option value="0">-- Todos --</option>
                                    <?php foreach ($usuarios as $m): ?>
                                        <option value="<?=$m['id']?>"><?=$m['text']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-12">
                        <div id="example_filter2" class="dataTables_filter" style="display: inline-block;">
                            <label>Buscar: </label>
                            <input type="search"
                                   class="form-control form-control-sm"
                                   placeholder=""
                                   aria-controls="example">
                        </div>
                        <div style="display: inline-block; margin-left: 10px;">
                            <label>Desde:</label>
                            <input type="date" id="fechaDesde" class="form-control" style="width: 160px;"
                                   value="<?=date('Y-m-d')?>">
                        </div>
                        <div style="display: inline-block; margin-left: 10px;">
                            <label>Hasta:</label>
                            <input type="date" id="fechaHasta" class="form-control" style="width: 160px;"
                                   value="<?=date('Y-m-d')?>">
                        </div>
                    </div>
                </div>

                <div class="row">


                    <table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <?php if ($_SESSION['idrol'] == 1): ?>
                                <th class="text-center">Vendedor</th>
                            <?php endif; ?>

                            <th class="text-center">Cliente</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Comisiones</th>
                            <th class="text-center">Tipo Cambio</th>
                            <th class="text-center">Codigo Cotizacion</th>
                            <th class="text-center">Celular</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center"
                                style="min-width: <?=$_SESSION['idrol'] == 1 ? '145px;' : '79px;'?>;width: <?=$_SESSION['idrol'] == 1 ? '145px;' : '79px;'?>">
                                Opciones
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <!--Tabla que envia datos-->
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
                            <p class="mb-md-0 text-center text-md-left">© <?=date('Y')?> Todos los derechos reservados
                                por <a
                                        target="_blank" href="https://magustechnologies.com/">
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
        <!-- END FOOTER -->
        <!-- END FOOTER -->

        <!---->
        <!---->
        <!---->
        <!---->
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

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>

        <!-- jQuery CDN -->

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <?php if ($_SESSION['idrol'] == 1): ?>
            <div class="modal fade" id="modal-new-banner" tabindex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel"
                 aria-hidden="true" style="z-index:  10000">
                <div class="modal-dialog modal-lg">
                    <form id="actualizar-estado" class="modal-content" ruta="usuarios_digitales_guardar_estado.php">
                        <div class="modal-header text-center">
                            <h3 class="modal-title" id="exampleModalLabel">Gestionar</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Estado:</label>
                                <div style="display: flex;align-items: center;margin-bottom: 5px">
                                    <input type="radio" name="estado" class="form-control estado-0" value="0"
                                           style="height: 18px !important;width: 25px;margin-right: 10px;">
                                    <div>
                                        <span class="badge badge-primary">Pendiente</span>
                                    </div>
                                </div>
                                <div style="display: flex;align-items: center;margin-bottom: 5px">
                                    <input type="radio" name="estado" class="form-control estado-1" value="1"
                                           style="height: 18px !important;width: 25px;margin-right: 10px;">
                                    <div>
                                        <span class="badge badge-warning">En proceso</span>
                                    </div>
                                </div>
                                <div style="display: flex;align-items: center;margin-bottom: 5px">
                                    <input type="radio" name="estado" class="form-control estado-2" value="2"
                                           style="height: 18px !important;width: 25px;margin-right: 10px;">
                                    <div>
                                        <span class="badge badge-success">Aprobado</span>
                                    </div>
                                </div>
                                <div style="display: flex;align-items: center;margin-bottom: 5px">
                                    <input type="radio" name="estado" class="form-control estado-3" value="3"
                                           style="height: 18px !important;width: 25px;margin-right: 10px;">
                                    <div>
                                        <span class="badge badge-danger">Rechazado</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button id="cerrar_modal" type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        </body>

        <script>
			var estadosArray = [
				'<span class="badge badge-primary">Pendiente</span>',      // Estado 0
				'<span class="badge badge-warning">En proceso</span>',     // Estado 1
				'<span class="badge badge-success">Aprobado</span>',       // Estado 2
				'<span class="badge badge-danger">Rechazado</span>'        // Estado 3
			];

			$(document).on('submit', '#actualizar-estado', function () {
				event.preventDefault()
				var id = this.getAttribute('data-id');
				$.ajax({
					type: 'POST',
					url: '../admin/usuarios_digitales_guardar_estado.php',
					data: {
						id: id,
						estado: $("input[name^='estado']:checked").val()
					}, success: function (response) {
						var data = JSON.parse(response);
						if (data.estatus) {
							var estado = $("input[name^='estado']:checked").val();
							$('.estado-num-' + id).html(estadosArray[estado]);
							Swal.fire({
								icon: 'success',
								title: 'Guardado correctamente',
								showConfirmButton: false,
								timer: 2000
							});
							$('#cerrar_modal').click();
							datatable.ajax.reload()
							//location.reload();
						} else {
							Swal.fire({
								icon: 'success',
								title: 'Error aL guardar',
								showConfirmButton: false,
								timer: 2000
							});
						}
					},
					error: function () {
						console.error('Error en la solicitud AJAX');
					}
				});
			});
			/**/
			/**/
			/**/
			$(document).on('click', '.gestionar', function () {
				var btn = this;
				$.ajax({
					type: 'POST',
					url: '../admin/usuarios_digitales_consulta_cotizacion.php',
					data: {
						id: this.getAttribute('data-id'),
					},
					success: function (response) {
						var data = JSON.parse(response);
						$('.estado-' + data.estado_cotizacion).prop('checked', true);
						$('.estado-' + data.estado_cotizacion).closest('form').attr('data-id', btn.getAttribute('data-id'));
						$('.estado-' + data.estado_cotizacion).closest('form').attr('data-estado', data.estado_cotizacion);
						console.log(datatable)

					}
					,
					error: function () {
						console.error('Error en la solicitud AJAX');
					}
				})
				;
			});

			function eliminarProd(prod) {
				$.ajax({
					type: "POST",
					url: "../ajax/ajs_productos.php",
					data: {
						tipo: 'del_prod_admin',
						prod
					},
					success: function () {
						location.reload();
					}
				});

			}

			var datatable = '';
			$(document).ready(function () {
				//APP_PROD.getInfoProduc()

				datatable = $('#example').DataTable({
					"order": [
						[0, "desc"]
					],
					"lengthChange": false,
					processing: true,
					serverSide: true,
					ajax: {
						url: '../admin/usuarios_digitales_cotizaciones_html.php',
						type: 'GET',
						data: function (d) {
							d.idusuario = $('.select2').val();
							d.fechaDesde = $('#fechaDesde').val();
							d.fechaHasta = $('#fechaHasta').val();
							return d;
						},
						dataSrc: function (json) {
							// Actualizar elementos HTML con los datos adicionales
							$('#ingreso_comisiones').text('S/. ' + json.ingreso_comisiones);
							$('#ingreso_comisiones_extra').text('S/. ' + json.ingreso_comisiones_extra);
							$('#ingreso_suma_comisones').text('S/. ' + json.ingreso_suma_comisones);

							// Devolver los datos para DataTables
							return json.data;
						}
					},
					language: {
						url: '../utils/Spanish.json'
					}
				});

                <?php if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin'):?>
				$('.select2').select2({
					placeholder: 'Selecciona una opción',
					minimumInputLength: 0,
					ajax: {
						url: '../admin/usuarios_digitales_html.php',
						dataType: 'json',
						delay: 250,
						data: function (params) {
							return {
								q: params.term
							};
						},
						processResults: function (data) {
							// Procesar los resultados de la búsqueda y cargar AJAX
							return {
								results: data
							};
						},
						cache: true
					}
				});

				$('.select2').on('change', function () {
					datatable.ajax.reload();
				});



                <?php endif;?>

				$('#example_filter2 input').on('input', function () {
					datatable.search(this.value).draw();

				});

				$('#fechaDesde, #fechaHasta').change(function () {
					datatable.ajax.reload();
				});

			})
        </script>

        </html>


    <?php } else {
        header("Location: ../CYM/");
    }
?>
