<?php
    session_start();


    require "../dao/Session.php";
    require_once "../extra/TasaCambioApi.php";

    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();


    $tasaCambioApi = new TasaCambioApi();
    $cambio = $tasaCambioApi->getTasaCambio();
    $tc = $cambio['cambio'] ?? 0;

    if (isset($_SESSION['usuario']) && $validate['perfil'] == 'usuarios digital') {


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

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
            <style>


                .container-fluid .btn {
                    display: inline-block;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #5b626b;
                    text-align: center;
                    vertical-align: middle;
                    cursor: pointer;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                    background-color: transparent;
                    border: 1px solid transparent;
                    padding: .375rem .75rem;
                    font-size: .875rem;
                    border-radius: .25rem;
                    -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                }

                .container-fluid .form-control {
                    display: block;
                    width: 100%;
                    padding: .375rem .75rem;
                    font-size: .875rem;
                    font-weight: 400;
                    line-height: 1.5;
                    color: #495057;
                    background-color: #fff;
                    background-clip: padding-box;
                    border: 1px solid #ced4da;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    border-radius: .25rem;
                    -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
                    height: 36px;
                }

                .container-fluid .btn-success {
                    color: #fff;
                    background-color: #02a499;
                    border-color: #02a499;
                }

                .container-fluid {
                    font-size: 13px;
                }

                .container-fluid input {
                    font-size: 13px;
                }

                .btn-danger {
                    color: #fff !important;
                    background-color: #dc3545 !important;
                    border-color: #dc3545 !important;
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

        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row" id="container-vue">
                    <div class="col-12 row">
                        <div class="col-md-8">
                            <div class="card ">
                                <div class="card-body">
                                    <h4 class="card-title">Productos</h4>
                                    <div class="card-title-desc">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="form-horizontal" id="form-producto">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-2 control-label">Buscar</label>
                                                    <div class="col-lg-10">

                                                        <div class="input-group">
                                                            <input type="text"
                                                                   placeholder="Consultar Productos"
                                                                   class="form-control ui-autocomplete-input"
                                                                   id="input_buscar_productos" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-2 control-label">Descripción</label>
                                                    <div class="col-lg-10">
                                                        <input required type="text"
                                                               placeholder="Descripción"
                                                               class="form-control prod_nombre" name="prod_nombre"
                                                               readonly="true">
                                                    </div>
                                                    <input type="text"
                                                           class="form-control prod_prod_id"
                                                           style="display: none !important;"
                                                           name="prod_id">
                                                </div>
                                                <div class="form-groupw ">
                                                    <div class="row" style="margin-right: 0;">
                                                        <div class="form-group col-lg-4 col-md-4">
                                                            <label for="example-text-input" class="col-form-label">Stock
                                                                Actual</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input disabled
                                                                       class="form-control text-center prod_stock_prod"
                                                                       type="text"
                                                                       placeholder="0" name="prod_stock">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-4 col-md-4">
                                                            <label for="example-text-input"
                                                                   class="col-form-label">Cantidad</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input required
                                                                       class="form-control text-center prod_cantidad"
                                                                       type="number"
                                                                       placeholder="0"
                                                                       id="example-text-input" name="prod_cantidad">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-4 col-md-4">
                                                            <label for="example-text-input"
                                                                   class="col-form-label">Precio</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input required
                                                                       class="form-control text-center prod_precio_prod"
                                                                       type="text" readonly="true"
                                                                       placeholder="0"
                                                                       id="example-text-input" name="prod_precio">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label for="example-text-input"
                                                                   class="col-sm-4 col-form-label">Serie
                                                                Producto</label>
                                                            <div class="col-sm-12">
                                                                <input
                                                                        class="form-control text-left prod_prod_cod"
                                                                        type="text" placeholder="0" name="prod_cod">
                                                            </div>
                                                        </div>
                                                        <!--<div class="col-lg-2">
                                                            <button id="submit-a-product" type="submit" class="btn btn-success"><i
                                                                        class="fa fa-check"></i> Agregar
                                                        </div>-->
                                                        <div class="form-group col-lg-3">

                                                        </div>
                                                        <div class="form-group col-lg-3">
                                                            <label for="example-text-input" style="visibility: hidden"
                                                                   class="col-sm-4 col-form-label">Serie</label>
                                                            <div class="col-sm-12" style="text-align: right;">
                                                                <button style="width: 100%" id="submit-a-product"
                                                                        type="submit"
                                                                        class="btn btn-success"><i
                                                                            class="fa fa-check"></i> Agregar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>


                                            </form>
                                        </div>

                                        <div class="col-md-12 mt-5">
                                            <div class="row">
                                                <div class="text-left col-md-9">
                                                    <h4>Detalle Cotizacion</h4>
                                                </div>
                                            </div>
                                            <table class="table" id="tabla-datos">
                                                <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Producto</th>
                                                    <th>Serie</th>
                                                    <th>Cantidad</th>
                                                    <th>P. Unit.</th>
                                                    <th>Sub Total</th>
                                                    <th>Comision</th>
                                                    <th>Mi Comision</th>
                                                    <th>Total</th>

                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="col-md-12">
                                        <form id="form-confirmar" class="widget padding-0 white-bg"
                                              ruta="usuarios_digitales_save.php"
                                              role="form">
                                            <div class="padding-20 text-center">
                                                <div class="form-horizontal">
                                                    <!--<div class="form-group row mb-2">
                                                        <label class="col-lg-4 control-label">Tipo de cambio</label>
                                                        <div class="col-lg-8">

                                                            <div class="input-group">
                                                                <input type="text" id="tipo_cambio" readonly="true"
                                                                       class="form-control" value="<?/*=$tc*/?>">
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="control-label">Aplicar IGV</label>
                                                            <select class="form-control" id="aplicar_igv"
                                                                    name="aplica_igv">
                                                                <option value="0">NO</option>
                                                                <option value="1">SI</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-md-6" style="padding: 0 !important;">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Fecha
                                                                            Emisión</label>
                                                                        <div class="col-lg-12">
                                                                            <input type="date"
                                                                                   style="padding: 0 !important;"
                                                                                   placeholder="dd/mm/aaaa"
                                                                                   class="form-control text-center"
                                                                                   readonly="true"
                                                                                   value="<?=date('Y-m-d')?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="padding: 0 !important;">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Fecha
                                                                            Vencimiento</label>
                                                                        <div class="col-lg-12">
                                                                            <input disabled
                                                                                   style="padding: 0 !important;"
                                                                                   type="date"
                                                                                   placeholder="dd/mm/aaaa"
                                                                                   class="form-control text-center"
                                                                                   readonly="true"
                                                                                   value="<?=date('Y-m-d', strtotime(date('Y-m-d') . ' + 10 days'))?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-4 control-label">Cliente</label>
                                                    </div>

                                                    <div class="form-group mb-2">
                                                        <div class="col-lg-12">
                                                            <div class="input-group"
                                                                 style="display: flex;flex-wrap: nowrap;">
                                                                <input id="input_datos_cliente" type="text"
                                                                       name="dni_ruc"
                                                                       placeholder="Ingrese Documento" required
                                                                       minlength="7"
                                                                       class="form-control" maxlength="11">
                                                                <div class="input-group-prepend">
                                                                    <button class="btn btn-success" id="buscar_cliente"
                                                                            type="button">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <input type="text"
                                                                   placeholder="Nombre del cliente"
                                                                   name="nombres" required
                                                                   class="form-control ui-autocomplete-input"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <input type="text"
                                                                   placeholder="telefono del cliente"
                                                                   name="telefono" required
                                                                   class="form-control ui-autocomplete-input"
                                                                   autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                       placeholder="Dirección 1"
                                                                       name="direccion"
                                                                       class="form-control ui-autocomplete-input"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <label>Observaciones</label>
                                                            <div class="input-group">

                                                                <input type="text" placeholder="" name="notas"
                                                                       class="form-control ui-autocomplete-input"
                                                                       autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group  mb-2">

                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Monto de
                                                                            Paga</label>
                                                                        <div class="col-lg-12">
                                                                            <input type="text" placeholder=""
                                                                                   id="total_pagar" readonly="true"
                                                                                   value="0"
                                                                                   class="form-control text-center">
                                                                            <input type="text" placeholder=""
                                                                                   id="total_pagar_usd" readonly="true"
                                                                                   value="0"
                                                                                   class="form-control text-center">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <div type="button"
                                                                 class="btn btn-success"
                                                                 id="btn_finalizar_pedido">
                                                                <i class="fa fa-save"></i> Guardar
                                                            </div>
                                                            <input type="submit" style="display: none"
                                                                   class="btn btn-success"
                                                                   id="btn_finalizar_pedido_2">

                                                            <!--<button style="width: 100%"
                                                                    type="submit"
                                                                    class="btn btn-success"><i
                                                                        class="fa fa-check"></i> Guardar
                                                            </button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="padding-right: 5px">
                                                    <div class="bg-primary pv-15 text-center  p-3"
                                                         style="color: white">
                                                        <h1 class="mv-0 font-400" id="suma_pedido_usd"
                                                            style="font-size: 2.4em;color: #FFF !important;">
                                                            $/ 0
                                                        </h1>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="padding-left: 5px">
                                                    <div class="bg-primary pv-15 text-center  p-3"
                                                         style="color: white">
                                                        <h1 class="mv-0 font-400" id="suma_pedido_soles"
                                                            style="font-size: 2.4em;color: #FFF !important;">
                                                            S/ 0
                                                        </h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="datos_inputs" style="display: none">

                                            </div>
                                        </form>
                                    </div>
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
        <div id="respuesta"></div>
        <!-- END FOOTER -->

        <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

        <!-- Latest jQuery -->
        <script src="../public/assets/js/jquery-1.12.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
					success: function () {
						location.reload();
					}
				});

			}

			$(document).ready(function () {
				//APP_PROD.getInfoProduc()

				$('#example').DataTable({
					"order": [
						[0, "desc"]
					],
					language: {
						url: '../utils/Spanish.json'
					}
				});

				var tipo_cambio = $('#tipo_cambio').val();
				tipo_cambio = parseFloat(tipo_cambio);

				var suma_pedido_soles = 0;
				var producto = {};
				$("#input_buscar_productos").on('input', function () {
					$("#input_buscar_productos").autocomplete({
						source: '../admin/usuarios_digitales_productos.php',
						minLength: 1,
						select: function (event, ui) {
							event.preventDefault();
							console.log(ui.item);
							var datos = ui.item;
							for (var clave in datos) {
								if (datos.hasOwnProperty(clave)) {
									var valor = datos[clave];
									//console.log("Clave: " + clave + ", Valor: " + valor);
									$('.prod_' + clave).val(valor);
									// Aquí puedes hacer algo con cada clave y valor, por ejemplo:
									// Asignar el valor a un campo HTML con clase prod_nombre

								}
							}
							producto = datos;
							$("#input_buscar_productos").val('');
							/*$('.prod_nombre').val();*/
						}
					});
				});

				$('#form-producto').submit(function (event) {
					event.preventDefault(); // Evita que se envíe el formulario por defecto
					if (this.prod_id.value === '') {
						alert('Seleccione un producto')
						return
					}

					agregarFila(this)
				});

				function limpiarDatos() {
					for (var clave in producto) {
						if (producto.hasOwnProperty(clave)) {
							$('.prod_' + clave).val('');
						}
					}
					producto = {};
					$('.prod_cantidad').val(0);
				}


				function agregarFila(formulario) {

					console.log(formulario);
					console.log(formulario.elements);
					console.log(formulario.prod_nombre.value);


					const nuevaFila = document.createElement('tr');

					var subtotal = parseFloat(formulario.prod_precio.value * formulario.prod_cantidad.value);
					subtotal = subtotal.toFixed(2);

					var total = parseFloat(subtotal * 1.2).toFixed(2);
					var micomision = subtotal * 0.2;
					micomision = parseFloat(micomision).toFixed(2)

					suma_pedido_soles = parseFloat(suma_pedido_soles) + parseFloat(total);
					console.log(suma_pedido_soles)
					console.log(suma_pedido_soles)
					console.log(suma_pedido_soles)
					console.log(suma_pedido_soles)
					suma_pedido_soles = (suma_pedido_soles).toFixed(2);
					suma_pedido_usd = suma_pedido_soles / tipo_cambio;
					suma_pedido_usd = (suma_pedido_usd).toFixed(2);


					// Contenido de la nueva fila
					nuevaFila.innerHTML = `
                                            <td class='contador_fila'>0</td>
                                            <td>
                                                ${formulario.prod_nombre.value}
                                            </td>
                                            <td>
                                                ${formulario.prod_cod.value}
                                            </td>
                                            <td>
                                                ${formulario.prod_cantidad.value}
                                            </td>
                                            <td>
                                                ${formulario.prod_precio.value}
                                            </td>
                                            <td>
                                                ${subtotal}
                                            </td>
                                            <td>
                                               0.2 %
                                            </td>
                                            <td>
                                               ${micomision}
                                            </td>
                                            <td>
                                                ${total}
                                            </td>

                                            <td>
                                                <input type='hidden' name='ids[]' value='${formulario.prod_id.value}'>
                                                <input type='hidden' name='cantidad[]' value='${formulario.prod_cantidad.value}'>
                                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-prod">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                                <!--<button class="btn btn-info btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </button>-->
                                            </td>
                                        `;

					// Agregar la fila al cuerpo de la tabla
					document.querySelector('#tabla-datos tbody').appendChild(nuevaFila);
					$('#total_pagar').val('S/ ' + suma_pedido_soles);
					$('#total_pagar_usd').val('$/ ' + (suma_pedido_soles / <?=$tc?>).toFixed(2));
					$('#suma_pedido_soles').html('S/ ' + suma_pedido_soles);
					$('#suma_pedido_usd').html('$/ ' + suma_pedido_usd);
					recontarFilas();
					limpiarDatos();
				}

				function recontarFilas() {
					var elementos = document.querySelectorAll('.contador_fila');
					elementos.forEach((elemento, indice) => {
						elemento.innerHTML = ++indice;
					});
				}

				$(document).on('change', '#aplicar_igv', function () {
					if (this.value === '0') {
						$('#suma_pedido_soles').html('S/ ' + suma_pedido_soles);
						$('#suma_pedido_usd').html('$/ ' + suma_pedido_usd);
					} else {
						$('#suma_pedido_soles').html('S/ ' + (suma_pedido_soles * 1.18).toFixed(2));
						$('#suma_pedido_usd').html('$/ ' + (suma_pedido_usd * 1.18).toFixed(2));
					}
				});
				$(document).on('click', '.btn-eliminar-prod', function () {
					const filaAEliminar = this.closest('tr');
					filaAEliminar.remove();
					recontarFilas();
				});


				$(document).on('click', '#buscar_cliente', function () {
					$.ajax({
						type: 'POST',
						url: '../admin/usuarios_digitales_consulta_documento.php',
						data: {doc: this.value},
						success: function (response) {
							console.log(response)
						},
						error: function () {
							console.error('Error en la solicitud AJAX');
						}
					});
				});

				$(document).on('click', '#btn_finalizar_pedido', function () {
					$('#datos_inputs').html($('#tabla-datos').html());
					$('#btn_finalizar_pedido_2').click();
					//$('#form-confirmar').submit();
				});

				$(document).on('submit', '#form-confirmar', function (event) {
					event.preventDefault();
					var formData = $(this).serialize();  // Serializar los datos del formulario
					console.log(this.getAttribute('ruta'))
					// Enviar la solicitud AJAX
					$.ajax({
						type: 'POST',
						url: '../admin/' + this.getAttribute('ruta'),
						data: formData,
						success: function (response) {
							console.log(response);
							$('#respuesta').html(response);
							$('#form-producto')[0].reset();
							$('#form-confirmar')[0].reset();
							$('#datos_inputs').html('');
							$('#tabla-datos tbody').html('');

							Swal.fire({
								icon: 'success',
								title: 'Cotizacion generada',
								showConfirmButton: false,
								timer: 2000
							});
							setTimeout(function() {
								window.location.href = 'usuarios_digitales_cotizaciones.php';
							}, 2000);
							// Manejar la respuesta exitosa aquí
						},
						error: function () {
							console.error('Error en la solicitud AJAX');
							// Manejar errores aquí
						}
					});

				});
			})


        </script>

        </html>


    <?php } else {
        header("Location: ../CYM/");
    }
?>
