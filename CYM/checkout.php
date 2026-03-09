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
<title>VI�ASANTODOMINGO</title>
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

<style>
    @charset "US-ASCII";
    @import "http://fonts.googleapis.com/css?family=Lato:300,400,700";
    * {

        font-size: 16px;
        font-weight: 300;
    }
    ::-webkit-input-placeholder {
        font-style: italic;
    }
    :-moz-placeholder {
        font-style: italic;
    }
    ::-moz-placeholder {
        font-style: italic;
    }
    :-ms-input-placeholder {
        font-style: italic;
    }

    body {
        float: left;
        margin: 0;
        padding: 0;
        width: 100%;
    }
    strong {
        font-weight: 700;
    }
    a {
        cursor: pointer;
        display: block;
        text-decoration: none;
    }
    .bta  {


        border-radius: 5px 5px 5px 5px;
        -webkit-border-radius: 5px 5px 5px 5px;
        -moz-border-radius: 5px 5px 5px 5px;
        text-align: center;
        font-size: 21px;
        font-weight: 400;
        padding: 12px 0;
        width: 100%;
        display: table;
        background: #E51F04;
        background: -moz-linear-gradient(top,  #333 0%, #333 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#333), color-stop(100%,#333));
        background: -webkit-linear-gradient(top,  #333 0%,#333 100%);
        background: -o-linear-gradient(top,  #333 0%,#333 100%);
        background: -ms-linear-gradient(top,  #333 0%,#333 100%);
        background: linear-gradient(top,  #333 0%,#333 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#333', endColorstr='#333',GradientType=0 );
    }
    a.button {
        border-radius: 5px 5px 5px 5px;
        -webkit-border-radius: 5px 5px 5px 5px;
        -moz-border-radius: 5px 5px 5px 5px;
        text-align: center;
        font-size: 21px;
        font-weight: 400;
        padding: 12px 0;
        width: 100%;
        display: table;
        background: #E51F04;
        background: -moz-linear-gradient(top,  #ff324d 0%, #ff324d 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff324d), color-stop(100%,#ff324d));
        background: -webkit-linear-gradient(top,  #ff324d 0%,#ff324d 100%);
        background: -o-linear-gradient(top,  #ff324d 0%,#ff324d 100%);
        background: -ms-linear-gradient(top,  #ff324d 0%,#ff324d 100%);
        background: linear-gradient(top,  #ff324d 0%,#ff324d 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff324d', endColorstr='#ff324d',GradientType=0 );
    }
    a.button i {
        margin-right: 10px;
    }
    a.button.disabled {
        background: none repeat scroll 0 0 #ccc;
        cursor: default;
    }
    .bkng-tb-cntnt {
        float: left;
        width: 800px;
    }
    .bkng-tb-cntnt a.button {
        color: #fff;
        float: right;
        font-size: 18px;
        padding: 5px 20px;
        width: auto;
    }
    .bkng-tb-cntnt a.button.o {
        background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
        color: #e51f04;
        border: 1px solid #e51f04;
    }
    .bkng-tb-cntnt a.button i {
        color: #fff;
    }
    .bkng-tb-cntnt a.button.o i {
        color: #e51f04;
    }
    .bkng-tb-cntnt a.button.right i {
        float: right;
        margin: 2px 0 0 10px;
    }
    .bkng-tb-cntnt a.button.left {
        float: left;
    }
    .bkng-tb-cntnt a.button.disabled.o {
        border-color: #ccc;
        color: #ccc;
    }
    .bkng-tb-cntnt a.button.disabled.o i {
        color: #ccc;
    }
    .pymnts {
        float: left;
        width: 800px;
    }
    .pymnts * {
        float: left;
    }

    .sctn-row {
        margin-bottom: 35px;
        width: 800px;
    }
    .sctn-col {
        width: 375px;
    }
    .sctn-col.l {
        width: 425px;
    }
    .sctn-col input {
        border: 1px solid #ccc;
        font-size: 18px;
        line-height: 24px;
        padding: 10px 12px;
        width: 333px;
    }
    .sctn-col label {
        font-size: 24px;
        line-height: 24px;
        margin-bottom: 10px;
        width: 100%;
    }
    .sctn-col.x3 {
        width: 300px;
    }
    .sctn-col.x3.last {
        width: 200px;
    }
    .sctn-col.x3 input {
        width: 210px;
    }
    .sctn-col.x3 a {
        float: right;
    }
    .pymnts-sctn {
        width: 800px;
    }
    .pymnt-itm {
        margin: 0 0 3px;
        width: 800px;
    }
    .pymnt-itm h2 {
        background-color: #e9e9e9;
        font-size: 24px;
        line-height: 24px;
        margin: 0;
        padding: 28px 0 28px 20px;
        width: 780px;
    }
    .pymnt-itm.active h2 {
        cursor: default;
    }
    .pymnt-itm div.pymnt-cntnt {
        display: none;
    }
    .pymnt-itm.active div.pymnt-cntnt {
        background-color: #f7f7f7;
        display: block;
        padding: 0 0 30px;
        width: 100%;
    }

    .pymnt-cntnt div.sctn-row {
        margin: 20px 30px 0;
        width: 740px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col {
        width: 345px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.l {
        width: 395px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col input {
        width: 303px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.half {
        width: 155px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.half.l {
        float: left;
        width: 190px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.half input {
        width: 113px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.cvv {
        background-image: url("../public/pay/img/cvv.png");
        background-position: 156px center;
        background-repeat: no-repeat;
        padding-bottom: 30px;
    }
    .pymnt-cntnt div.sctn-row div.sctn-col.cvv div.sctn-col.half input {
        width: 110px;
    }
    .openpay {
        float: right;
        height: 60px;
        margin: 10px 30px 0 0;
        width: 435px;
    }
    .openpay div.logo {
        background-image: url("../public/pay/img/openpay.png");
        background-position: left bottom;
        background-repeat: no-repeat;
        border-right: 1px solid #ccc;
        font-size: 12px;
        font-weight: 400;
        height: 45px;
        padding: 0px 20px 0 0;
    }
    .openpay div.shield {
        background-image: url("../public/pay/img/security.png");
        background-position: left bottom;
        background-repeat: no-repeat;
        font-size: 12px;
        font-weight: 400;
        margin-left: 20px;
        padding: 20px 0 0 40px;
        width: 200px;
    }
    .card-expl {
        float: left;
        height: 80px;
        margin: 20px 0;
        width: 800px;
    }
    .card-expl div {
        background-position: left 45px;
        background-repeat: no-repeat;
        height: 70px;
        padding-top: 10px;
    }
    .card-expl div.debit {
        background-image: url("../public/pay/img/cards2.png");
        margin-left: 20px;
        width: 540px;
    }
    .card-expl div.credit {
        background-image: url("../public/pay/img/cards1.png");
        border-right: 1px solid #ccc;
        margin-left: 30px;
        width: 209px;
    }
    .card-expl h4 {
        font-weight: 400;
        margin: 0;
    }
</style>

<style>
    @keyframes ldio-407auvblvok {
        0% {
            transform: rotate(0)
        }

        100% {
            transform: rotate(360deg)
        }
    }

    .ldio-407auvblvok div {
        box-sizing: border-box !important
    }

    .ldio-407auvblvok>div {
        position: absolute;
        width: 79.92px;
        height: 79.92px;
        top: 15.540000000000001px;
        left: 15.540000000000001px;
        border-radius: 50%;
        border: 8.88px solid #000;
        border-color: #626ed4 transparent #626ed4 transparent;
        animation: ldio-407auvblvok 1s linear infinite;
    }

    .ldio-407auvblvok>div:nth-child(2),
    .ldio-407auvblvok>div:nth-child(4) {
        width: 59.940000000000005px;
        height: 59.940000000000005px;
        top: 25.53px;
        left: 25.53px;
        animation: ldio-407auvblvok 1s linear infinite reverse;
    }

    .ldio-407auvblvok>div:nth-child(2) {
        border-color: transparent #02a499 transparent #02a499
    }

    .ldio-407auvblvok>div:nth-child(3) {
        border-color: transparent
    }

    .ldio-407auvblvok>div:nth-child(3) div {
        position: absolute;
        width: 100%;
        height: 100%;
        transform: rotate(45deg);
    }

    .ldio-407auvblvok>div:nth-child(3) div:before,
    .ldio-407auvblvok>div:nth-child(3) div:after {
        content: "";
        display: block;
        position: absolute;
        width: 8.88px;
        height: 8.88px;
        top: -8.88px;
        left: 26.64px;
        background: #626ed4;
        border-radius: 50%;
        box-shadow: 0 71.04px 0 0 #626ed4;
    }

    .ldio-407auvblvok>div:nth-child(3) div:after {
        left: -8.88px;
        top: 26.64px;
        box-shadow: 71.04px 0 0 0 #626ed4;
    }

    .ldio-407auvblvok>div:nth-child(4) {
        border-color: transparent;
    }

    .ldio-407auvblvok>div:nth-child(4) div {
        position: absolute;
        width: 100%;
        height: 100%;
        transform: rotate(45deg);
    }

    .ldio-407auvblvok>div:nth-child(4) div:before,
    .ldio-407auvblvok>div:nth-child(4) div:after {
        content: "";
        display: block;
        position: absolute;
        width: 8.88px;
        height: 8.88px;
        top: -8.88px;
        left: 16.650000000000002px;
        background: #02a499;
        border-radius: 50%;
        box-shadow: 0 51.06px 0 0 #02a499;
    }

    .ldio-407auvblvok>div:nth-child(4) div:after {
        left: -8.88px;
        top: 16.650000000000002px;
        box-shadow: 51.06px 0 0 0 #02a499;
    }

    .loadingio-spinner-double-ring-8kmkrab6ncg {
        width: 111px;
        height: 111px;
        display: inline-block;
        overflow: hidden;
        background: rgba(255, 255, 255, 0);
    }

    .ldio-407auvblvok {
        width: 100%;
        height: 100%;
        position: relative;
        transform: translateZ(0) scale(1);
        backface-visibility: hidden;
        transform-origin: 0 0;
        /* see note above */
    }

    .ldio-407auvblvok div {
        box-sizing: content-box;
    }

    /* generated by https://loading.io/ */
</style>
<style>
    .float {
        padding-top: 7px;
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        right: 80px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    #loader-menor {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        width: 100%;
        height: 100%;
        display: none;
        background-color: #ffffff96;
        line-height: 100vh;
        text-align: center;
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

    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container">
            <!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Ingreso de datos para proceder con su pedido</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="#">Pag</a></li>
                        <li class="breadcrumb-item active">Pedidos</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP -->
        <div class="section">
            <div id="primary" class="container">
                <?php
                if (!$isLogin) {
                    // var_dump($_SESSION);

                    $_SESSION["ruta"] = "./checkout.php";

                ?>
                    <div class="row justify-content-md-center">
                        <div class="col-lg-6 ">
                            <div class="toggle_info">
                                <span><i class="fas fa-user"></i> Inicie sesion para continuar </span>
                            </div>
                            <div class="panel-collapse login_form collapse show" id="loginform">
                                <div class="panel-body">
                                    <p>Es necesario iniciar sesión para continuar con el pago de su pedido, ingrese sus datos a continuación.</p>
                                    <form method="post" v-on:submit.prevent="verificar">
                                        <div class="form-group">
                                            <input v-model="user" type="text" required="" class="form-control" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input   v-model="clave" class="form-control" required="" type="password" name="password" placeholder="Contraseña">
                                        </div>
                                        <div class="login_footer form-group">

                                            <a href="#">¿Se te olvidó tu contraseña?</a>
                                        </div>
                                        <div class="form-group">
					    <button type="submit" class="btn btn-fill-out btn-block" name="login">Iniciar sesi&oacute;n</button>
                                        </div>
                                    </form>
                                    <form id="login" method="post" action="../auth/login.php" style="display: none">
                                        <input name="user" v-model="user">
                                        <input name="clave" v-model="clave">
                                        <input name="ruta" value="checkout">
                                    </form>
                                    <div class="different_login"><span> O</span></div>
                                    <ul class="btn-login list_none text-center"></ul>
                                    <div class="form-note text-center">¿No tienes una cuenta?<a href="signup.php"> Regístrate ahora</a></div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="medium_divider"></div>
                            <div class="divider center_icon"><i class="linearicons-credit-card"></i></div>
                            <div class="medium_divider"></div>
                        </div>
                    </div>
                <?php
                } else {
                    if (isset($_SESSION["ruta"])) {
                        unset($_SESSION["ruta"]);
                    }
                ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="heading_s1">
                                <h4>Ingrese sus datos personales</h4>
                            </div>
                            <form id="frmAgregarInfo" v-on:submit.prevent="precesar($event)">
                                <input style="display: none" type="submit" id="procesar-pedido">
                                <input name="tipo" type="hidden" value="prodce-prod">
                                <input id="tenx-extdr" name="carr" style="display: none">

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" required placeholder="DNI / RUC" name="ndoc" id="ndoc" onkeypress="return onlyNumberKey(event)">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-primary btn-sm" @click="buscarDoc()"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input disabled type="text" required class="form-control" name="nombre" id="nombreCliente" placeholder="Cliente (*)">
                                </div>
                                <div class="form-group">
                                    <input type="text" required class="form-control" name="direccion" id="direccionCliente" placeholder="Direccion  (*)">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" required type="text" autocomplete="off" id='campoCelular' name="phone" placeholder="Celular  (*)" onkeypress="return onlyNumberKey(event)" maxlength="9">
                                </div>
                                <div class="form-group">
                                    <select name="departamentoAgregar" id="departamentoAgregar" class="form-control" required>
                                        <option value="" selected>SELECCIONE DEPARTAMENTO (*)</option>
                                        <?php foreach ($departementos as $row) : ?>
                                            <option value="<?= $row['dep_cod'] ?>"><?= $row['dep_nombre'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="provinciaAgregar" id="provinciaAgregar" class="form-control" required>
                                        <option value="" selected>SELECCIONE PROVINCIA (*)</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="distritoAgregar" id="distritoAgregar" class="form-control">
                                        <option value="" selected>SELECCIONE DISTRITO (*)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="formEnvioAgregar" id="formEnvioAgregar" class="form-control" required>
                                        <option value="" selected>Forma de Envio (*)</option>
                                        <?php foreach ($formEnvio as $row) : ?>
                                            <option value="<?= $row['id_tipo_envio'] ?>"><?= $row['nombre'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="formaPagoAgregar" id="formaPagoAgregar" class="form-control" required>
                                        <option value="" selected>Tipo de pago (*)</option>
                                        <?php foreach ($formPago as $row) : ?>
                                            <option value="<?= $row['id_tipo_pago'] ?>"><?= $row['nombre'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input class="form-control" required type="email" name="email" placeholder="Email (*)" id="emailAdd">
                                </div>

                                <div hidden class="heading_s1">
                                    <h4>Datos de tarjeta</h4>
                                    <p style="margin-top: 0;padding-top: 0;">Solo llenar si se pagara la compra con tarjeta (*)</p>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nombreClienteTarjeta" id="nombreClienteTarjeta" placeholder="Nombres (*)">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="apellidoClienteTarjeta" id="apellidoClienteTarjeta" placeholder="Apellidos  (*)">
                                    </div>
                                </div>

                                <div class="heading_s1">
                                    <label><input required id="chekTedm" type="checkbox"> He leído y acepto los <a style="display: contents;color: #ff324d;" href="../public/TÉRMINOS%20Y%20CONDICIONES.pdf" target="_blank">términos y condiciones</a> y las <a style="display: contents;color: #ff324d;" href="../public/POLÍTICA DE PRIVACIDAD.pdf" target="_blank">políticas de privacidad</a>  </label>
                                </div>
                                <div class="heading_s1">
                                    <h4>Información Adicional</h4>
                                </div>
                                <div class="form-group mb-3">
                                    <textarea rows="5" class="form-control" name="nota" placeholder="Otras notas......"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="order_review">
                                <div class="heading_s1">
                                    <h4>Su Orden</h4>
                                </div>
                                <div class="table-responsive order_table">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in listaProd">
                                                <td>{{item.nombre_prod}} <span class="product-qty">x {{item.cantidad}}</span></td>
                                                <td>S/.{{operationTotal(item.cantidad,item.precio)}}</td>

                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SubTotal</th>
                                                <td class="product-subtotal">S/{{subTotal}}</td>
                                            </tr>
                                            <tr>
                                                <th>Envio</th>
                                                <td class="product-subtotal">S/{{flete_pago}}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="product-subtotal">S/{{total}}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="payment_method">
                                    <div class="heading_s1">
                                        <h4>Proceso:</h4>
                                    </div>
                                    <div class="payment_option">
                                        <div class="custome-radio">
                                            <input hidden class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios3" value="option3" checked="">
                                            <label hidden class="form-check-label" for="exampleRadios3">Direct Bank Transfer</label>
                                            <p data-method="option3" class="payment-text">Contactar por WhatsApp al asesor de venta con el número de pedido que se le asignar&aacute;, para proceder con su compra.</p>
                                        </div>
                                        <div hidden class="custome-radio">
                                            <input class="form-check-input" type="radio" name="payment_option" id="exampleRadios4" value="option4">
                                            <label class="form-check-label" for="exampleRadios4">Check Payment</label>
                                            <p data-method="option4" class="payment-text">Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                        </div>
                                        <div hidden class="custome-radio">
                                            <input class="form-check-input" type="radio" name="payment_option" id="exampleRadios5" value="option5">
                                            <label class="form-check-label" for="exampleRadios5">Paypal</label>
                                            <p data-method="option5" class="payment-text">Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)" onclick=" fleteProcesaaaaa()" class="btn btn-fill-out">Solicitar Cotizaci&oacute;n</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-fill-out" style="color: white;">Pago Con Tarjeta</a>
                                    </div>
                                    <div>
                                        <div class="col-md-12">

                                            <p class="mt-2" style="padding-bottom: 0;margin-bottom: 0;"><b>Pagos con tarjeta de cr&eacute;dito o d&eacute;bito 5% m&aacute;s.</p>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                </div>
                            </div>
                            <div class="order_review mt-3">
                                <h3>Costo por envío</h3>
                                <p style="margin-bottom: 0;">Dentro de Lima : S/ 30.00</p>
                                <p style="margin-bottom: 0;">Fuera de Lima : $ 7.00</p>
                            </div>

                        </div>

                    </div>



                    <div class="modal fade" id="modal-new-banner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:  10000">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h3 class="modal-title" id="exampleModalLabel">Elegir Tipo de Cambio</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="frmPagarCulqi">
                                    <div class="modal-body">


                                        <div>
                                            <input type="radio" id="USD" name="moneda" v-bind:value="total" checked />
                                            <label for="usd">$ {{totalConTarjeta}}</label>

                                        </div>

                                        <div>
                                            <input type="radio" id="PEN" name="moneda" v-bind:value="totalConvertido" />
                                            <label for="pen">S/ {{totalConTarjetaConvertido}} </label>
                                        </div>






                                        <div class="modal-footer">
                                            <button id="btnPagarCulqi" type="button" class="btn btn-primary">Pagar</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php     }
                ?>



            </div>
        </div>
        <!-- END SECTION SHOP -->
   </div>
        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="heading_s1 mb-md-0 heading_light">
                            <h3>Suscríbete a nuestro boletín</h3>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter_form">
                            <form action="#">
                                <input type="text" required="" class="form-control rounded-0" placeholder="Introduzca la dirección de correo electrónico">
                                <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Suscribir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- START SECTION SUBSCRIBE NEWSLETTER -->

    
    <!-- END MAIN CONTENT -->

    <!-- START FOOTER -->
    <?php include "../fragment/footer_gen.php" ?>
    <!-- END FOOTER -->
    <div class="modal fade" id="exampleModalpay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="background: #f0f8ff00;border: 0;">
                <div class="modal-body">
                    <div class="bkng-tb-cntnt">
                        <div class="pymnts">
                            <form action="#" method="POST" id="payment-form">
                                <input type="hidden" name="token_id" id="token_id">
                                <input type="hidden" name="nombre" value="" id="nomclitr">
                                <input type="hidden" name="ape" value="" id="apeclitr">
                                <div class="pymnt-itm card active">
                                    <h2>Tarjeta de crédito o débito</h2>
                                    <div class="pymnt-cntnt">
                                        <div class="card-expl">
                                            <div class="credit"><h4>Tarjetas de crédito</h4></div>
                                            <div class="debit"><h4>Tarjetas de débito</h4></div>
                                        </div>
                                        <div class="sctn-row">
                                            <div class="sctn-col l">
                                                <label>Nombre del titular</label><input id="nomTitula" required type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name">
                                            </div>
                                            <div class="sctn-col">
                                                <label>Número de tarjeta</label><input onkeypress="return onlyNumberKey(event)" minlength="15" maxlength="16" required type="text" autocomplete="off" data-openpay-card="card_number"></div>
                                        </div>
                                        <div class="sctn-row">
                                            <div class="sctn-col l">
                                                <label>Fecha de expiración</label>
                                                <div class="sctn-col half l"><input onkeypress="return onlyNumberKey(event)" minlength="2" maxlength="2" required type="text" placeholder="Mes" data-openpay-card="expiration_month"></div>
                                                <div class="sctn-col half l"><input onkeypress="return onlyNumberKey(event)" minlength="2" maxlength="2" required type="text" placeholder="Año" data-openpay-card="expiration_year"></div>
                                            </div>
                                            <div class="sctn-col cvv"><label>Código de seguridad</label>
                                                <div class="sctn-col half l"><input onkeypress="return onlyNumberKey(event)" minlength="3" maxlength="4" required type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2"></div>
                                            </div>
                                        </div>
                                        <div class="openpay"><div class="logo">Transacciones realizadas vía:</div>
                                            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
                                        </div>
                                        <div class="sctn-row">
                                            <button style="    color: #fff;
    float: right;
    font-size: 18px;
    padding: 5px 20px;    border: 0;margin-left: 12px;
    width: auto;" data-dismiss="modal" class="bta rght"  >Cerrar</button>
                                            <a onclick="$('#butmid').click()" class="button rght" id="pay-button">Pagar</a>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" style="display: none" id="butmid"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





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

    <script>

        const tCanbio=<?= $tc; ?>;

        function esFormatoEmail(cadena) {
            const formatoEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return formatoEmail.test(cadena);
        }

        let moneda=''
        let monto=''
        const listadis=[
            "ANCON",
            "CARABAYLLO",
            "CHACLACAYO",
            "CIENEGUILLA",
            "COMAS",
            "LOS OLIVOS",
            "LURIGANCHO",
            "LURIN",
            "PUCUSANA",
            "PUENTE PIEDRA",
            "PUNTA HERMOSA",
            "PUNTA NEGRA",
            "SAN BARTOLO",
            "SAN JUAN DE LURIGANCHO",
            "SAN JUAN DE MIRAFLORES",
            "SAN MARTIN DE PORRES",
            "SANTA MARIA DEL MAR",
            "SANTA ROSA",
            "VILLA EL SALVADOR",
            "VILLA MARIA DEL TRIUNFO",

        ]


        /*Culqi.options({
            lang: 'auto',
            // modal: false,
            installments: true,
            // customButton: 'Pagar',
            style: {
                logo: 'https://compuvisionperu.pe/public/favi.png',
                maincolor: '#ff0426',
                buttontext: '#ffffff',
                maintext: '#4A4A4A',
                desctext: '#4A4A4A'
            }
        });*/

        const APP = new Vue({
            el: "#primary",
            data: {
                user: '',
                clave: '',
                listaProd: [],
                total_pago: 0,
                subTotal_pago: 0,
                flete_pago: 0,
                moneda: '1',
                isEnvio: false,
                totalTransac: 0,
		    listaCarrito:[]
            },
            methods: {
                monedaFlete() {
                    return this.flete_pago == 7 ? '$' : (this.flete_pago == 30 ? 'S/' : '$')
                },
                operationTotal(cnt, prec) {
                    return (parseInt(cnt + "") * parseFloat(prec + "")).toFixed(2);
                },
                recargarLista() {
                    const vue=this
                    console.log("-----------------************--------------------")
			this.listaCarrito = CARRITO._data.listaCarrito;


                    
			  CARRITO._data.fun=(lista)=>{
                        console.log(lista);
                        vue.listaProd=lista
                    }
                    if (loaDataP){
                        loaDataP=false
                        CARRITO.getUsuarioCarrito()
                    }
			
                    //this.listaProd = CARRITO._data.listaCarrito;
                    //this.listaProd=this.listaProd.filter(itemm=>itemm.stock?true:false).filter(itemm=>itemm.cantidad<=itemm.stock-2)
                },
                buscarDoc() {
                    let dni = 'dni'
                    let ruc = 'ruc'
                    if ($('#ndoc').val().length == 8) {
                        $("#loader-menor").show();
                        $.ajax({
                            type: "POST",
                            url: "../ajax/ajs_consultas_doc.php",
                            data: {
                                doc: $('#ndoc').val(),
                                tipo: dni,
                            },
                            success: function(resp) {
                                $("#loader-menor").hide();
                                resp = JSON.parse(resp);
                                let data = JSON.parse(resp)
                                console.log(data);
                                if (data.res) {
                                    let nombres = data.data.nombres + ' ' + data.data.apellido_paterno + ' ' + data.data.apellido_materno
                                    $('#nombreCliente').val(nombres)
                                    $('#nomTitula').val(nombres)
                                    $('#nomclitr').val(data.data.nombres)
                                    $('#apeclitr').val(data.data.apellido_paterno + ' ' + data.data.apellido_materno)
                                    console.log(data.nombre);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.msj,
                                    })
                                }
                            }
                        });
                    } else if ($('#ndoc').val().length == 11) {
                        $("#loader-menor").show();
                        $.ajax({
                            type: "POST",
                            url: "../ajax/ajs_consultas_doc.php",
                            data: {
                                doc: $('#ndoc').val(),
                                tipo: ruc,
                            },
                            success: function(resp) {
                                $("#loader-menor").hide();
                                resp = JSON.parse(resp);
                                let data = JSON.parse(resp)
                                console.log(data);
                                if (data.res) {
                                    $('#nombreCliente').val(data.data.razon_social)
                                    $('#direccionCliente').val(data.data.direccion)
                                    console.log(data.nombre);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.msj,
                                    })
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Documento no valido',
                        })
                    }

                },
                precesar(evt) {
                    $("#tenx-extdr").val(JSON.stringify(this.listaProd));

                    /*      this.total = this.total  */
                    console.log($(evt.target).serialize());
                    /* procesar-compra */
                    /*   return */




                    if ((($('#distritoAgregar').val()) == 'SELECCIONE') || $('#provinciaAgregar').val() == 'SELECCIONE') {
                        console.log($('#distritoAgregar').val() + "distrito combo");

                        Swal.fire({
                            icon: 'info',
                            text: 'Complete correctamente el formulario',
                        })
                    } else {
                        if ($('#formEnvioAgregar').val() == '') {
                            Swal.fire({
                                icon: 'info',
                                text: 'Seleccione una forma de envio',
                            })
                        } else {
                            $("#loader-menor").show()
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_consulta.php?total="+APP._data.subTotal_pago+"&nomc="+$("#nombreCliente").val(),
                                data: $(evt.target).serialize(),
                                success: function(resp) {
                                    $("#loader-menor").hide()
                                    //console.log(resp);
                                    resp = JSON.parse(resp);
                                    console.log(resp);
                                   if (resp.res) {
                                        Swal.fire(
                                            'Bien',
                                            'Cotizaci�n enviada correctamente',
                                            'success'
                                        )
                                    } else {
                                        Swal.fire({
                                            icon: 'info',
                                            text: 'Su carrito esta vacio, ingrese productos',
                                        })
                                    }
                                }
                            });
                        }

                    }



                },
                verificar() {
                    console.log("dddddddd")

                    $.ajax({
                        type: "POST",
                        url: "../auth/login.php",
                        data: {
                            user: this.user,
                            clave: this.clave,
                            vr: 'org',
                            carrito: JSON.stringify(CARRITO._data.listaCarrito)
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp);
                            console.log(resp);
                            if (resp.res) {
                                $("#login").submit();
                            } else {
                                swal(resp.msg, "", "error")
                            }
                        }
                    });

                    // $("#login").submit()
                }
            },
            computed: {
                subTotal() {
                    this.subTotal_pago = 0;
                    for (var i = 0; i < this.listaProd.length; i++) {
                        this.subTotal_pago += parseInt(this.listaProd[i].cantidad + "") * parseFloat(this.listaProd[i].precio + "");
                    }
                    return this.subTotal_pago.toFixed(2);
                },
                total() {
                    if (this.isEnvio) {
                        if (this.flete_pago == 7) {
                            this.total_pago = parseFloat(this.subTotal_pago) + parseFloat(this.flete_pago);
                        } else if (this.flete_pago == 30) {
                            this.total_pago = parseFloat(this.subTotal_pago) + (parseFloat(this.flete_pago) / <?php echo $tc; ?>)
                        } else {
                            this.total_pago = parseFloat(this.subTotal_pago) + 0
                        }
                    } else {
                        this.total_pago = parseFloat(this.subTotal_pago) + 0
                    }

                    return this.total_pago.toFixed(2)
                },
                totalConvertido() {
                    let totalConvertido = 0;


                    if (this.isEnvio) {
                        if (this.flete_pago == 7) {
                            totalConvertido = ((this.total+7) * <?php echo $tc; ?>)
                            console.log('803');
                        } else if (this.flete_pago == 30) {
                            totalConvertido = ((this.total+(30/<?php echo $tc; ?>)) * <?php echo $tc; ?>)
                            console.log('806');
                        } else {
                            totalConvertido = (this.total * <?php echo $tc; ?>)
                            console.log('808');
                        }
                    } else {
                        totalConvertido = (this.total * <?php echo $tc; ?>) + this.flete_pago
                    }


                    return totalConvertido.toFixed(2)
                },
                totalConTarjeta() {
                    let totalTarjeta = 0


                    totalTarjeta = ((parseFloat(this.total) ) * 0.05) + (parseFloat(this.total))
                    console.log(totalTarjeta);
                    return totalTarjeta.toFixed(2)
                    /* this.total_pago.toFixed(2) */
                },
                totalConTarjetaConvertido() {
                    let totalTarjeta = 0

                    totalTarjeta = parseFloat(this.totalConTarjeta ) * <?php echo $tc; ?>;
                    console.log(totalTarjeta);
                    return totalTarjeta.toFixed(2)
                    /* this.total_pago.toFixed(2) */
                }
                /*  envioProvincia() {
                     let envioProvincia = 0;
                     envioProvincia = this.totalConvertido

                     return envioProvincia.toFixed(2)
                 },
                 envioLima() {

                 } */

            }
        });

        function onlyNumberKey(evt) {

            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
        var selected_Id

        /*   Culqi.publicKey = 'pk_test_evIVkqvLwkEkRNY5'; */
        $(document).ready(function() {
            /*OpenPay.setId('mknezia3udhml9m9mnon');
            OpenPay.setApiKey('pk_832f069b507a45dca170a3456dde4583');*/

            //P
            OpenPay.setId('mpqeozsvp9heu93igzij');
            OpenPay.setApiKey('pk_1078ca158de14225a05c3c4a3e861ac3');

            OpenPay.setSandboxMode(false);
            //var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");

            /* 
                        $('#formEnvioAgregar').change(function() {
                            console.log($(this).val());
                            if ($(this).val() == 2) {
                                if ($('#departamentoAgregar').val() == 15 && $('#provinciaAgregar').val() == 01) {
                                    console.log('es lima y lima');
                                    APP._data.isEnvio = true
                                    APP._data.flete_pago = 30
                                } else {
                                    APP._data.isEnvio = true
                                    APP._data.flete_pago = 7
                                }
                            } else {
                                APP._data.isEnvio = false
                                APP._data.flete_pago = 0
                            }
                        }) */
            APP.recargarLista()
            console.log((CARRITO._data.listaCarrito));

            $('#btnPagarCulqi').click(function() {

                if ($('#frmPagarCulqi').serializeArray().length === 0) {
                    console.log('marque una opcion');
                } else {
                    console.log($('#frmPagarCulqi').serializeArray());
                    selected_Id = $('input[name="moneda"]:checked').attr('id');
                    var precioPagar = $('input[name="moneda"]:checked').attr('value');
                    console.log(selected_Id);
                    console.log(precioPagar);
                    if (selected_Id == 'USD') {
                        moneda= 'USD'
                        monto= parseFloat(APP.totalConTarjeta).toFixed(2)

                    } else {
                        //APP._data.moneda = '2'
                        //APP._data.totalTransac = parseFloat(APP.totalConTarjetaConvertido).toFixed(2).replace('.', '')
                        moneda= 'PEN'
                        monto= parseFloat(APP.totalConTarjetaConvertido).toFixed(2)
                    }

                    $('#modal-new-banner').modal('hide')
                    $('#exampleModalpay').modal('show')


                }


                /* Culqi.options({
                    lang: 'auto',
                    // modal: false,
                    installments: true,
                    // customButton: 'Pagar',
                    style: {
                     
                        maincolor: '#ff0426',
                        buttontext: '#ffffff',
                        maintext: '#4A4A4A',
                        desctext: '#4A4A4A'
                    }
                }); */
            })

            $("#payment-form").submit((evt)=>{
                evt.preventDefault();
                $("#exampleModalpay").modal('hide');
                $("#loader-menor").show()
                OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);
            })
            $('#procesar-compra').click(function() {
                //$("#exampleModalpay").modal('show');
                //


                /*  $("#tenx-extdr").val(JSON.stringify(APP._data.listaProd));
                  console.log(object); 
                 console.log($('#frmAgregarInfo').serialize());
                 $('#modal-new-banner').modal('show')
                procesar - compras  */
                /*  $('#formEnvioAgregar').change(function() { */
                /*  console.log($(this).val()); */
                if ($('#formEnvioAgregar').val() == 2) {
                    if ($('#departamentoAgregar').val() == '15' && $('#provinciaAgregar').val() == '01') {
                        console.log('es lima y lima');
                        APP._data.isEnvio = true
                        APP._data.flete_pago = 30
                    } else {
                        APP._data.isEnvio = true
                        APP._data.flete_pago = 7
                    }
                } else {
                    APP._data.isEnvio = false
                    APP._data.flete_pago = 0
                }
                /*  }) */
                console.log($('#frmAgregarInfo').serializeArray());
                /*   return */

                /*  console.log($('#distritoAgregar').val());
                 return */
                if ((($('#distritoAgregar').val()) == '') || $('#provinciaAgregar').val() == '') {
                    console.log($('#distritoAgregar').val() + "distrito combo");

                    console.log($('#provinciaAgregar').val() + "provincia");
                    Swal.fire({
                        icon: 'info',
                        text: 'Llene todos los campos obligatorios',
                    })
                    console.log('entra aca');
                }
                if ((($('#distritoAgregar').val()) == 'SELECCIONE') || $('#provinciaAgregar').val() == 'SELECCIONE') {
                    console.log($('#distritoAgregar').val() + "distrito combo");

                    console.log($('#provinciaAgregar').val() + "provincia");
                    Swal.fire({
                        icon: 'info',
                        text: 'Llene todos los campos obligatorios',
                    })
                    console.log('entra aca');
                } else {
                    console.log($('#distritoAgregar').val() + "distrito combo");

                    console.log($('#provinciaAgregar').val() + "provincia");
                    console.log('else');
                    if ($('#formEnvioAgregar').val() == '' || $('#ndoc').val() == '' || $('#nombreCliente').val() == '' || $('#direccionCliente').val() == '' || $('#formaPagoAgregar').val() == '' || $('#emailAdd').val() == '') {
                        Swal.fire({
                            icon: 'info',
                            text: 'Llene todos los campos obligatorios',
                        })
                    } else {
                        if (!$("#chekTedm").is(':checked')){
                            Swal.fire({
                                icon: 'info',
                                text: 'Acepte los términos y condiciones  y las políticas privacidad',
                            })
                        }else{
                            if ($('#campoCelular').val().length < 9) {
                                Swal.fire({
                                    icon: 'info',
                                    text: 'El numero de celular debe tener 9 digitos',
                                })
                            } else {
                                if (esFormatoEmail($("#emailAdd").val())){
                                    $('#modal-new-banner').modal('show')
                                }else{
                                    Swal.fire({
                                        icon: 'info',
                                        text: 'El Email no tiene el formato adecuado',
                                    })
                                }

                                /*    console.log(JSON.stringify(APP._data.listaProd));  */
                            }
                        }

                    }
                }

            })




            $("#departamentoAgregar").change(function() {
                if ($("#departamentoAgregar").val() !== '') {
                    let data = {
                        name: "idDep",
                        value: $("#departamentoAgregar").val()
                    }
                    $.ajax({
                        url: "../ajax/ajs_provincias.php",
                        type: "POST",
                        data: data,
                        success: function(resp) {
                            let data = JSON.parse(resp);
                            console.log(data);
                            $('#provinciaAgregar').empty()
                            $("provinciaAgregar").remove()
                            $('#provinciaAgregar')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option selected>SELECCIONE  (*)</option>')
                                .val('SELECCIONE')
                            $('#distritoAgregar')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option selected>SELECCIONE</option>')
                                .val('SELECCIONE')
                            /*  $('#distritoAgregar').empty() */
                            data.forEach(element => {
                                $('#provinciaAgregar').append($('<option>', {
                                    value: element.pro_cod,
                                    text: element.pro_nombre
                                }));
                            });

                        },
                    });
                } else {
                    $("provinciaAgregar").remove()
                    $('#provinciaAgregar')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option selected>SELECCIONE</option>')
                        .val('SELECCIONE')
                    console.log('object');
                    $('#distritoAgregar')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option selected>SELECCIONE</option>')
                        .val('SELECCIONE')
                    console.log('object');
                }
            })

            $("#provinciaAgregar").change(function() {
                if ($("#provinciaAgregar").val() !== '' && $("#departamentoAgregar").val() !== '') {
                    let data = [{
                            name: "idProv",
                            value: $("#provinciaAgregar").val()
                        },
                        {
                            name: "idDep",
                            value: $("#departamentoAgregar").val()
                        }
                    ]
                    $.ajax({
                        url: "../ajax/ajs_distritos.php",
                        type: "POST",
                        data: data,
                        success: function(resp) {
                            let data = JSON.parse(resp);
                            console.log(data);
                            $('#distritoAgregar').empty()
                            if (data.length !== 0) {

                                data.forEach(element => {
                                    const stadoOpc=listadis.findIndex(eee=>eee===element.dis_nombre)>-1
                                    $('#distritoAgregar').append($('<option>', {
                                        disabled:stadoOpc,
                                        value: element.dis_id,
                                        text: element.dis_nombre+(stadoOpc?' - Sin cobertura':'')
                                    }));
                                });
                            } else {
                                $('#distritoAgregar')
                                    .find('option')
                                    .remove()
                                    .end()
                                    .append('<option selected>SELECCIONE</option>')
                                    .val('SELECCIONE')
                            }

                        },
                    });
                }
            })
        });

        var success_callbak = function(response) {
            var token_id = response.data.id;
            console.log(response.data)
            var deviceDataId = OpenPay.deviceData.setup("formId");
            var data = {
                //frm2: $('#fpayment-form').serializeArray(),
                tipoMoneda: moneda,
                forpago: $("#formEnvioAgregar").val(),
                nomc: $("#nomclitr").val(),
                apec: $("#apeclitr").val(),
                monto: monto,
                carr: JSON.stringify(APP._data.listaProd),
                token: token_id,
                email: '',
                deviceDataId: deviceDataId,
                frm: $('#frmAgregarInfo').serializeArray(),
                monedaUsada: APP._data.moneda,
                flete: APP._data.flete_pago,
                totalTransac: APP._data.totalTransac

            };
            $.ajax({
                type: "POST",
                url: "../ajax/ajs_compras.php",
                data: data,
                success: function(resp) {

                    resp = JSON.parse(resp);
                    console.log(resp);
                    /* return */
                    //console.log(resp);
                    /*  resp = JSON.parse(resp); */
                    /*   console.log(JSON.parse(resp));
                      return */
                    /*   return */
                    $("#loader-menor").hide()
                    if (resp.res) {
                        $('#modal-new-banner').modal('hide')

                        Swal.fire(
                            'Bien',
                            'Compra exitosa',
                            'success'
                        ).then(function() {
                            location.href = "my-account.php";
                        });

                    } else {
                        Swal.fire({
                            icon: 'info',
                            text: 'La tarjeta que ingreso es inválida  ',
                        })
                    }
                }
            });
        };

        var error_callbak = function(response) {
            var desc = response.data.description != undefined ?
                response.data.description : response.message;
            alert("ERROR [" + response.status + "] " + desc);
            $("#pay-button").prop("disabled", false);
            $("#loader-menor").hide()

        };

        function culqi() {
            if (Culqi.token) { // ¡Objeto Token creado exitosamente!
                console.log(APP._data.totalTransac);
                var token = Culqi.token.id;
                var email = Culqi.token.email;
                /*   var formPago = Culqi.formPago; */
                var data = {
                    moneda: $('#frmPagarCulqi').serializeArray(),
                    tipoMoneda: selected_Id,
                    carr: JSON.stringify(APP._data.listaProd),
                    token: token,
                    email: email,
                    frm: $('#frmAgregarInfo').serializeArray(),
                    monedaUsada: APP._data.moneda,
                    flete: APP._data.flete_pago,
                    totalTransac: APP._data.totalTransac,
                    nombreTarjeta: $('#nombreClienteTarjeta').val(),
                    apellidoClienteTarjeta: $('#apellidoClienteTarjeta').val(),

                };
                /*  data.tidoc = $("#tidoDoc").val()
                 data.numero_cli = $("#numero-doc").val()
                 data.nombre_cli = $("#nombre-cli").val()
                 data.direccion_cli = $("#direccion-cli").val() */
                /*  url: "../ajax/ajs_consulta.php", */
                /*  console.log(data);
                 return */
                $("#loader-menor").show()

                /*   return */
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_compras.php",
                    data: data,
                    success: function(resp) {
                        $("#loader-menor").hide()
                        resp = JSON.parse(resp);
                        console.log(resp);


                       /* if (resp.res) {
                            $('#modal-new-banner').modal('hide')

                            Swal.fire(
                                'Bien',
                                'Compra exitosa',
                                'success'
                            ).then(function() {
                                location.href = "my-account.php";
                            });

                        } else {
                            Swal.fire({
                                icon: 'info',
                                text: "La tarjeta que ingreso es invalida  ",
                            })
                        }*/
                    }
                });
                /*   _ajax("../ajax/ajs_compras.php", "POST",
                      data,
                      function(resp) {
                          console.log(resp);
                          return
                          if (resp.res) {
                              alertExito("comprado", "Se le enviara un mensaje de confirmacion")
                                  .then(function() {
                                      location.href = _URL + '/cursos'
                                  })
                          } else {
                              alertAdvertencia(resp.msg)
                          }
                      }
                  ) */

            } else {
                console.log(Culqi.error);
            }



        }
        function fleteProcesaaaaa(){
            if ($('#formEnvioAgregar').val() == 2) {
                if ($('#departamentoAgregar').val() == '15' && $('#provinciaAgregar').val() == '01') {
                    console.log('es lima y lima');
                    APP._data.isEnvio = true
                    APP._data.flete_pago = 30
                } else {
                    APP._data.isEnvio = true
                    APP._data.flete_pago = 7
                }
            } else {
                APP._data.isEnvio = false
                APP._data.flete_pago = 0
            }
            $('#procesar-pedido').click()
        }
    </script>

</body>

</html>
