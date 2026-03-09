<?php
    session_start();


    require "../dao/Session.php";
    require_once "../extra/TasaCambioApi.php";

    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();


    $tasaCambioApi = new TasaCambioApi();
    $cambio = $tasaCambioApi->getTasaCambio();
    $tc = $cambio['cambio'] ?? 0;

    if (isset($_SESSION['usuario']) && ($validate['perfil'] == 'admin' or $validate['perfil'] == 'usuarios digital')) {


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

                .autocomplete-item {
                    cursor: pointer;
                }

                .autocomplete-item:hover h6 {
                    color: white;
                }

                .autocomplete-item:hover {
                    background-color: #007bff;
                    color: white;
                }

                .autocomplete-item:hover .price, .autocomplete-item:hover span {
                    color: #d9cdcf;
                }

                #tabla-datos tbody td {
                    vertical-align: middle;
                }

                .form-group {
                    margin-bottom: 5px !important;
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
                                                        <div class="form-group col-lg-3 col-md-3">
                                                            <label for="example-text-input" class="col-form-label">Stock
                                                                Actual</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input disabled
                                                                       class="form-control text-center prod_stock_prod"
                                                                       type="text"
                                                                       placeholder="0" name="prod_stock">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-3 col-md-3">
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
                                                        <div class="form-group col-lg-3 col-md-3">
                                                            <label for="example-text-input"
                                                                   class="col-form-label">Precio</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input required
                                                                       class="form-control text-center prod_precio_prod_soles prod_precio_prod2"
                                                                       type="text" readonly="true"
                                                                       placeholder="0"
                                                                       id="example-text-input" name="prod_precio"
                                                                       step="0.01">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-3 col-md-3">
                                                            <label for="example-text-input"
                                                                   class="col-form-label">Otro Precio</label>
                                                            <div class="col-sm-6 col-md-12">
                                                                <input required
                                                                       class="form-control text-center prod_otro_precio_prod_soles prod_otro_precio_prod2"
                                                                       type="number"
                                                                       placeholder="0"
                                                                       id="example-text-input" name="otro_precio_prod"
                                                                       step="0.01">
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-lg-3">
                                                            <label for="example-text-input"
                                                                   class="col-form-label">Serie</label>
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
                                                    <!--<th>Serie</th>-->
                                                    <th>Cantidad</th>
                                                    <th>P. Unit. Sugerido</th>
                                                    <th>Total. Sugerido</th>
                                                    <th>P. Unit.</th>

                                                    <!--<th>Sub Total</th>-->
                                                    <!--<th>Comision</th>-->
                                                    <th style="color: #02a499;font-weight: 700;font-size: 15px">Total
                                                    </th>
                                                    <th>Mi comision</th>
                                                    <th>Mi comision Extra</th>
                                                    <th style="color: #02a499;font-weight: 700;font-size: 15px">Mi
                                                        ganancia
                                                    </th>
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
                                                    <!--<div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <div class="col-md-4">
                                                                <label class="control-label">Tipo de cambio</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" id="tipo_cambio" readonly="true"
                                                                       class="form-control" value="<? /*=$tc*/ ?>">
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    <div class="form-group row mb-2">
                                                        <label class="col-lg-4 control-label">Tipo de cambio</label>
                                                        <div class="col-lg-8">

                                                            <div class="input-group">
                                                                <input type="text" id="tipo_cambio" readonly="true"
                                                                       class="form-control" value="<?=$tc?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <label class="control-label"
                                                                   style="font-weight: 600;font-size: 16px;">Aplicar
                                                                IGV</label>
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
                                                        <label class="control-label"
                                                               style="font-weight: 600;font-size: 16px;">Cliente</label>
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
                                                            <input type="text"
                                                                   placeholder="email del cliente"
                                                                   name="email"
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
                                                            <label class="control-label"
                                                                   style="font-weight: 600;font-size: 16px;">Observaciones</label>
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
                                                                <div class="col-md-12" style="padding: 0">
                                                                    <div class="form-group ">
                                                                        <label class="control-label"
                                                                               style="font-weight: 600;font-size: 16px;">Ganancias</label>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <div class="form-group  mb-2">
                                                                            <div class="col-lg-12">
                                                                                <div class="row">
                                                                                    <div class="col-md-4"
                                                                                         style="padding: 0 !important;">
                                                                                        <div class="form-group ">
                                                                                            <label class="control-label">Comisiones</label>
                                                                                            <div class="col-lg-12">
                                                                                                <input type="text"
                                                                                                       id="total_comisiones"
                                                                                                       name="total_comisiones"
                                                                                                       style="padding: 0 !important;"
                                                                                                       class="form-control text-center"
                                                                                                       readonly="true"
                                                                                                       value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4"
                                                                                         style="padding: 0 !important;">
                                                                                        <div class="form-group ">
                                                                                            <label class="control-label">Comisiones
                                                                                                extra</label>
                                                                                            <div class="col-lg-12">
                                                                                                <input
                                                                                                        id="total_comisiones_extra"
                                                                                                        name="total_comisiones_extra"
                                                                                                        style="padding: 0 !important;"
                                                                                                        type="text"
                                                                                                        class="form-control text-center"
                                                                                                        readonly="true"
                                                                                                        value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4"
                                                                                         style="padding: 0 !important;">
                                                                                        <div class="form-group ">
                                                                                            <label class="control-label">Total
                                                                                                ganancia
                                                                                                extra</label>
                                                                                            <div class="col-lg-12">
                                                                                                <input
                                                                                                        id="total_comisiones_ganancia"
                                                                                                        name="total_comisiones_ganancia"
                                                                                                        style="padding: 0 !important;"
                                                                                                        type="text"
                                                                                                        class="form-control text-center"
                                                                                                        readonly="true"
                                                                                                        value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!---->
                                                    <!---->
                                                    <!---->
                                                    <div class="form-group  mb-2">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group ">
                                                                        <label class="control-label"
                                                                               style="font-weight: 600;font-size: 16px;">Monto
                                                                            de Paga</label>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->
                                                                        <div class="form-group  mb-2">
                                                                            <div class="col-lg-12">
                                                                                <div class="row">
                                                                                    <div class="col-md-6"
                                                                                         style="padding: 0 !important;">
                                                                                        <div class="form-group ">
                                                                                            <label class="control-label">Total
                                                                                                Soles</label>
                                                                                            <div class="col-lg-12">
                                                                                                <input type="text"
                                                                                                       style="padding: 0 !important;"
                                                                                                       class="form-control text-center"
                                                                                                       readonly="true"
                                                                                                       id="total_pagar"
                                                                                                       name="total_pagar"
                                                                                                       value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6"
                                                                                         style="padding: 0 !important;">
                                                                                        <div class="form-group ">
                                                                                            <label class="control-label">Total
                                                                                                es USD</label>
                                                                                            <div class="col-lg-12">
                                                                                                <input
                                                                                                        style="padding: 0 !important;"
                                                                                                        type="text"
                                                                                                        class="form-control text-center"
                                                                                                        readonly="true"
                                                                                                        id="total_pagar_usd"
                                                                                                        name="total_pagar_usd"
                                                                                                        value="0.00">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!---->
                                                                        <!---->
                                                                        <!---->

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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="padding-left: 5px">
                                                    <div class="bg-primary pv-15 text-center  p-3"
                                                         style="color: white">
                                                        <h1 class="mv-0 font-400" id="suma_pedido_soles"
                                                            style="font-size: 2.4em;color: #FFF !important;">
                                                            $/ 0
                                                        </h1>
                                                        <input type="hidden" name="suma_pedido_soles"
                                                               id="suma_pedido_soles_input">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" style="padding-right: 5px">
                                                    <div class="bg-primary pv-15 text-center  p-3"
                                                         style="color: white">
                                                        <h1 class="mv-0 font-400" id="suma_pedido_usd"
                                                            style="font-size: 2.4em;color: #FFF !important;">
                                                            S/ 0
                                                        </h1>
                                                        <input type="hidden" name="suma_pedido_usd"
                                                               id="suma_pedido_usd_input">
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

				var producto = {};
				$("#input_buscar_productos").on('input', function () {
					$("#input_buscar_productos").autocomplete({
						//source: '../admin/usuarios_digitales_productos.php',
						source: function (request, response) {
							console.log(request.term)
							$.ajax({
								url: '../admin/usuarios_digitales_productos.php',
								data: {
									term: request.term
								},
								success: function (data) {
									data = JSON.parse(data);
									response($.map(data, function (item) {
										return {
											label: item.nombre, // Nombre que se muestra en la lista
											value: item.id, // Valor que se asigna al input cuando se selecciona
											imagen: item.imagen, // URL de la imagen
											datos: item // Puedes mantener todos los datos en caso necesario
										};
									}));
								}
							});
						},
						minLength: 1,
						select: function (event, ui) {
							event.preventDefault();
							console.log(ui.item);
							var datos = ui.item.datos;
							for (var clave in datos) {
								if (datos.hasOwnProperty(clave)) {
									var valor = datos[clave];
									$('.prod_' + clave).val(valor);
								}
							}
							producto = datos;
							$("#input_buscar_productos").val('');
							$(".prod_otro_precio_prod_soles").val(datos.precio_prod_soles);
							//$(".prod_otro_precio_prod").val(datos.precio_prod);
							/*$('.prod_nombre').val();*/
						},
						open: function (event, ui) {
							// Añadir la imagen al menú desplegable
							var $menu = $(this).autocomplete("widget");
							$menu.find("li").each(function () {
								var item = $(this).data("ui-autocomplete-item");
								var soles = item.datos.precio_prod * <?=$tc?>;
								soles = parseFloat(soles).toFixed(2);

								var span = `<div class='product_info' style="padding: 0;">
                                                <h6 class='product_title'>
                                                    <div style='white-space: normal'>
                                                         ${item.datos.nombre}
                                                    </div>
                                                </h6>
                                                <div class='product_price'>
                                                    <span class='price'>S/. ${soles} </span>
                                                    <span style="margin-left: 30px">
                                                        <strong>$ ${item.datos.precio_prod}</strong>
                                                    </span>
                                                </div>
                                                    <div class='rating_wrap'>
                                                        <span class='rating_num'>
                                                            <strong>Stock:
                                                                <span style='font-weight: lighter;color: #03ad01'>${item.datos.stock_prod} en Stock</span>
                                                            </strong>
                                                        </span>
                                                    </div>
                                                </div>`;
								$(this).html("<div class='autocomplete-item' style='display: flex;border-bottom: 1px solid #ddd;padding: 10px'>" +
									"<img src='" + item.imagen + "' style='width: 100px; height: 100px; margin-right: 10px;'>" +
									span +
									"</div>");
							});
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
					$('.prod_otro_precio_prod').val(0);
				}


				function agregarFila(formulario) {

					const nuevaFila = document.createElement('tr');

					var total = parseFloat(formulario.otro_precio_prod.value * formulario.prod_cantidad.value);
					total = total.toFixed(2);

					var micomision = total * (0.05 / 100);
					micomision = parseFloat(micomision).toFixed(2)

					var comision_extra = total - (formulario.prod_precio.value * parseInt(formulario.prod_cantidad.value));
					comision_extra = comision_extra.toFixed(2)

					var mi_ganancia = parseFloat(comision_extra) + parseFloat(micomision);
					mi_ganancia = mi_ganancia.toFixed(2)


					var total_sugerido = formulario.prod_precio.value * parseInt(formulario.prod_cantidad.value);
					total_sugerido = total_sugerido.toFixed(2);

					nuevaFila.innerHTML = `
                                            <td class='contador_fila'>0</td>
                                            <td>
                                                ${formulario.prod_nombre.value}
                                            </td>
                                            <td style="text-align: right;">
                                                ${parseInt(formulario.prod_cantidad.value)}
                                            </td>
                                            <td style="text-align: right;font-weight: 600;color: red;;">
                                                ${formulario.prod_precio.value}
                                            </td>
                                            <td style="text-align: right;font-weight: 600;color: red;">
                                                ${total_sugerido}
                                            </td>
                                            <td style="text-align: right">
                                                ${formulario.otro_precio_prod.value}
                                            </td>
                                            <!--<td>
                                               0.05 %
                                            </td>-->

                                            <td style="text-align: right;color: #02a499;font-weight: 700;font-size: 15px">
                                                ${total}
                                            </td>
                                            <td style="text-align: right">
                                               ${micomision}
                                            </td>
                                            <td style="text-align: right">
                                                ${comision_extra}
                                            </td>
                                            <td style="text-align: right;color: #02a499;font-weight: 700;font-size: 15px">
                                                ${mi_ganancia}
                                            </td>
                                            <td class='inputs-elementos'>
                                                <input type='hidden' name='ids[]' value='${formulario.prod_id.value}'>
                                                <input type='hidden' name='cantidad[]' value='${formulario.prod_cantidad.value}'>
                                                <input type='hidden' name='produc_precio[]' value='${formulario.prod_precio.value}'>
                                                <input type='hidden' name='produc_total_venta[]' value='${total_sugerido}'>
                                                <input type='hidden' name='otro_produc_precio[]' value='${formulario.otro_precio_prod.value}'>
                                                <input type='hidden' name='otro_produc_total_venta[]' value='${total}'>
                                                <input type='hidden' name='mi_comision[]' value='${micomision}'>
                                                <input type='hidden' name='mi_comision_extra[]' value='${comision_extra}'>
                                                <input type='hidden' name='mi_ganancia[]' value='${mi_ganancia}'>
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


					recontarFilas();
					limpiarDatos();
				}

				//var comisiones = 0;
				//var comisiones_extra = 0;
				//var total_comisiones_ganancia = 0;

				function recontarFilas() {
					var elementos = document.querySelectorAll('.contador_fila');
					elementos.forEach((elemento, indice) => {
						elemento.innerHTML = ++indice;
					});

					var todos_elementos_input = [];

					const tdElements = document.querySelectorAll('.inputs-elementos');
					tdElements.forEach(td => {
						const inputs = td.querySelectorAll('input');
						var elementos_input = {};
						inputs.forEach(input => {
							var name = (input.name).replace('[]', '')
							var valor = input.value;
							console.log(input.value)
							if (name !== 'ids')
								elementos_input[name] = parseFloat(parseFloat(valor).toFixed(2));
						});
						todos_elementos_input.push(elementos_input);
					});

					$('#total_comisiones').val('S/. ' + sum_colum(todos_elementos_input, 'mi_comision'));
					$('#total_comisiones_extra').val('S/. ' + sum_colum(todos_elementos_input, 'mi_comision_extra'));
					$('#total_comisiones_ganancia').val('S/. ' + sum_colum(todos_elementos_input, 'mi_ganancia'));

					$('#total_pagar').val('S/. ' + sum_colum(todos_elementos_input, 'otro_produc_total_venta'));

					var total_en_usd = sum_colum(todos_elementos_input, 'otro_produc_total_venta') / <?=$tc?>;
					$('#total_pagar_usd').val('$/. ' + total_en_usd.toFixed(2));

					var check = document.getElementById('aplicar_igv').value;
					if (check === '1') {
						$('#suma_pedido_soles').html('S/. ' + (sum_colum(todos_elementos_input, 'otro_produc_total_venta') * 1.18).toFixed(2));
						$('#suma_pedido_usd').html('$/. ' + (total_en_usd * 1.18).toFixed(2));
					} else {
						$('#suma_pedido_soles').html('S/. ' + sum_colum(todos_elementos_input, 'otro_produc_total_venta').toFixed(2));
						$('#suma_pedido_usd').html('$/. ' + (total_en_usd).toFixed(2));
					}

					$('#suma_pedido_soles_input').val($('#suma_pedido_soles').html());
					$('#suma_pedido_usd_input').val($('#suma_pedido_usd').html());
					console.log(todos_elementos_input)
					//const suma = todos_elementos_input.reduce((total, valor) => total + valor, 0);

				}

				function sum_colum(arreglo, propiedad) {
					const suma = arreglo.map(objeto => objeto[propiedad]).reduce((total, valor) => total + valor, 0);
					const sumaConDecimales = parseFloat(suma.toFixed(2));
					return sumaConDecimales;
				}

				$(document).on('change', '#aplicar_igv', function () {
					recontarFilas();
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
					//var formData = $(this).serialize();  // Serializar los datos del formulario

					var parametros = new FormData($(this)[0]);

					console.log(this.getAttribute('ruta'))
					// Enviar la solicitud AJAX
					$.ajax({
						type: 'POST',
						url: '../admin/' + this.getAttribute('ruta'),
						data: parametros,
						contentType: false,
						processData: false,
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
							setTimeout(function () {
								window.location.href = 'usuarios_digitales_cotizaciones.php';
							}, 2000);
						},
						error: function () {
							console.error('Error en la solicitud AJAX');
							// Manejar errores aquí
						}
					});

				});

				//$(document).on('input', '.prod_otro_precio_prod', function () {
				$(document).on('blur', '.prod_otro_precio_prod', function () {
					var otro_precio = this.value;
					otro_precio = parseFloat(otro_precio).toFixed(2);
					producto.precio_prod = parseFloat(producto.precio_prod).toFixed(2);
					if (parseFloat(producto.precio_prod) >= parseFloat(otro_precio)) {
						this.value = producto.precio_prod;
					} else {
						this.value = otro_precio;
					}

					//this.value = otro_precio;
				});
			})


        </script>

        </html>


    <?php } else {
        header("Location: ../CYM/");
    }
?>
