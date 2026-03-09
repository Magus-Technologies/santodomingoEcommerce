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

            <title>ACEADVANCE</title>
            <title>ACEADVANCE</title>
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

                <div class="row" style="margin-bottom: 5px;">
                    <div class="row-with-elements">
                        <a class="btn btn-primary" href="usuarios_digitales_cotizacion.php">Agregar</a>
                        <select class="select2" style="width: 300px">
                            <option>opcion1</option>
                            <option>opcion1</option>
                            <option>opcion1</option>
                            <option>opcion1</option>
                        </select>
                    </div>
                </div>
                <div>


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
                            <th class="text-center">Tipo Cambio</th>
                            <th class="text-center">Codigo Cotizacion</th>
                            <th class="text-center">Celular</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Opciones</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($result as $row_ped) { ?>
                                <tr>
                                    <td class="text-center"><?=$row_ped['id']?></td>
                                    <?php if ($_SESSION['idrol'] == 1): ?>
                                        <td class="text-center"><?=$row_ped['vendedor']?></td>
                                    <?php endif; ?>
                                    <td class="text-center"><?=$row_ped['nombres']?></td>
                                    <td class="text-center"><?=$row_ped['fecha_create']?></td>
                                    <td class="text-center">
                                        <div style="width: max-content">
                                            S/. <?=money($row_ped['suma_pedido_soles'])?></div>
                                    </td>
                                    <td class="text-center"><?=$row_ped['tipo_cambio']?></td>
                                    <td class="text-center"><?=$row_ped['serie_cotizacion']?></td>
                                    <td class="text-center">
                                        <div style="width: max-content">
                                            <?=$row_ped['telefono']?> |
                                            <a href="<?='https://api.whatsapp.com/send?phone=51' . $row_ped['telefono'] . '&text=' . utf8_encode('Buen dia, genere una cotizacion para usted; N: ') . $row_ped['serie_cotizacion'];?>"
                                               title="Escribele al Cliente" target="_blank" rel="nofollow">
                                                <b style="font-weight: bold; font-size: 20px; color: green;"
                                                   onmouseout="this.style.color='green'"
                                                   onmouseover="this.style.color='red'">
                                                    <i class="fab fa-whatsapp"></i></b>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center estado-num-<?=$row_ped['id']?>">
                                        <?php if ($row_ped['estado_cotizacion'] == 0): ?>
                                            <span class="badge badge-primary">Pendiente</span>
                                        <?php elseif ($row_ped['estado_cotizacion'] == 1): ?>
                                            <span class="badge badge-warning">En proceso</span>
                                        <?php elseif ($row_ped['estado_cotizacion'] == 2): ?>
                                            <span class="badge badge-success">Aprobado</span>
                                        <?php elseif ($row_ped['estado_cotizacion'] == 3): ?>
                                            <span class="badge badge-danger">Rechazado</span>
                                        <?php endif; ?>
                                    </td>
                                    <!--<td class="text-center">
                                        <a href="usuarios_digitales_cotizacion_editar.php?pd=<?/*=$row_ped['id']*/ ?>"
                                           class="btn btn-primary"><i class="fa fa-eye"></i>
                                        </a>
                                    </td>-->
                                    <td>
                                        <div style="width: max-content">
                                            <a href="usuarios_digitales_cotizacion_editar.php?pd=<?=$row_ped['id']?>"
                                               class="btn btn-primary"><i class="fa fa-eye"></i>
                                            </a>
                                            <?php if ($_SESSION['idrol'] == 1): # Si es admin ?>
                                                <a class="btn btn-success" id="btnDescargarPedidos" target="_blank"
                                                   href="../admin/lista_pedidos_cotizaciones.php/<?=$row_ped['id']?>">
                                                    <i class='fa fa-download'></i>
                                                </a>
                                            <?php elseif ($_SESSION['idrol'] == 2): #si es usuario ?>
                                                <a class="btn btn-success" id="btnDescargarPedidos" target="_blank"
                                                   href="../admin/lista_pedidos_cotizaciones.php/<?=$row_ped['id']?>">
                                                    <i class='fa fa-download'></i>
                                                </a>
                                            <?php elseif ($_SESSION['idrol'] == 3): # si es usuario digital ?>
                                                <a class="btn btn-success" id="btnDescargarPedidos" target="_blank"
                                                   href="../admin/lista_pedidos_cotizaciones.php/<?=$row_ped['id']?>">
                                                    <i class='fa fa-download'></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['idrol'] == 1): ?>
                                                <a class="btn btn-success-2 gestionar" target="_blank"
                                                   data-toggle="modal" data-target="#modal-new-banner"
                                                   data-id="<?=$row_ped['id']?>">
                                                    <i class='fa fa-check'></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>

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
					language: {
						url: '../utils/Spanish.json'
					}
				});

				$('.select2').select2({
					placeholder: 'Selecciona una opción',
					minimumInputLength: 1, // Mínimo de caracteres para empezar la búsqueda
					ajax: {
						url: 'ruta/a/tu/script/php-o-python',
						dataType: 'json',
						delay: 250, // Retraso en milisegundos antes de enviar la solicitud
						data: function (params) {
							console.log(params);
							return {
								q: params.term // Término de búsqueda que el usuario ha introducido
							};
						},
						processResults: function (data) {
							console.log(data);
							return {
								results: data
							};
						},
						cache: true
					}
				});

			})
        </script>

        </html>


    <?php } else {
        header("Location: ../CYM/");
    }
?>
