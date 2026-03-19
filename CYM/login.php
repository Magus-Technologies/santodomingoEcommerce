<?php
session_start();
require "../dao/ProductoDao.php";
require "../utils/Tools.php";

$conexion = (new Conexion())->getConexion();
$productoDao = new ProductoDao();
$tools = new Tools();

$dataConf = $tools->getConfiguracion();


$tipolink = $_GET['v'];
if ($tipolink != '') {
    $vmsg = "Para ver nuestro catalogo de precios VIP debe ingresar a nuestro sistema";

}

?><!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>
<!-- SITE TITLE -->
<title>VIÑASANTODOMINGO</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="../public/assets/css/animate.css">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<style>
    .lik-ho:hover {
        color: #FF324D;
    }

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
    <?php
    include "../fragment/head_secon.php";

    if ($isSesionUser) {
        // header("Location: ./");
    }
    ?>
    <!-- END HEADER -->

    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Iniciar sesi&oacute;n</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Iniciar sesi&oacute;n</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START LOGIN SECTION -->
        <div class="login_register_wrap section">
            <div class="container">
                <h4 class="text-center"><?= $vmsg ?> </h4><br>
                <div class="row justify-content-center">

                    <div class="col-xl-6 col-md-10">
                        <div class="login_wrap" id="primary">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h3>Iniciar sesi&oacute;n</h3>

                                </div>
                                <form method="post" v-on:submit.prevent="verificar">
                                    <div class="form-group">
                                        <input v-model="user" type="text" required="" class="form-control" name="email"
                                            placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input v-model="clave" class="form-control" required="" type="password"
                                            name="password" placeholder="Contraseña">
                                    </div>
                                    <div class="login_footer form-group">

                                        <a class="lik-ho" href="javascript:void(0)" @click="reset_password_ver()">¿Se te
                                            olvidó tu contraseña?</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block" name="login"
                                            style="background-color:#232323; color:#fff;">Iniciar sesi&oacute;n</button>
                                    </div>
                                </form>
                                <form id="login" method="post" action="../auth/login.php" style="display: none">
                                    <input name="user" v-model="user">
                                    <input name="clave" v-model="clave">
                                    <input name="ruta" value="index">
                                </form>

                                <div class="different_login">
                                    <span> O</span>
                                </div>
                                <ul class="btn-login list_none text-center">

                                </ul>
                                <div class="form-note text-center">¿No tienes una cuenta?<a href="signup.php">
                                        Regístrate ahora</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END LOGIN SECTION -->

        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb" style="background-color:#880107 !important;">
            <img class="d-none d-lg-block" src="../public/images/wine.png" alt="bg_newsletter" style="position: absolute;
  width: 276px;
  top: -110px;
  left: 25px;" />
            <div class="custom-container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="newsletter_text text_white">
                            <h3>Somos VIÑASANTODOMINGO los mejores en VINOS Y PISCO</h3>
                            <p>Recibe las mejores Ofertas en Vino y Pisco SUSCR&Iacute;BETE</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="newsletter_form2 rounded_input">
                            <form id="formPromociones">
                                <input type="email" required name="emailRegistrar" id="emailRegistrar"
                                    class="form-control" placeholder="Ingresa tu Email">
                                <button type="button" class="btn btn-dark btn-radius"
                                    style="background-color:#232323!important;"
                                    id="btnRegistrar">Suscr&iacute;bete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- START SECTION SUBSCRIBE NEWSLETTER -->

    </div>
    <!-- END MAIN CONTENT -->

        <!-- START FOOTER -->
    <?php include "../fragment/footer_gen.php" ?>
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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="../public/js/main.js?v=2"></script>
    <script src="../public/plugin/sweetalert2/vue-swal.js"></script>


</body>
<script>

    const APP = new Vue({
        el: "#primary",
        data: {
            user: '',
            clave: '',
            listaProd: [],
            total_pago: 0,
            subTotal_pago: 0,
            flete_pago: 0,
        },
        methods: {
            reset_password_ver() {
                swal({
                    text: 'Ingres su email',
                    content: "input",
                    buttons: {
                        cancel: "Cancelar",
                        confirm: "Enviar"

                    }
                })
                    .then((value) => {
                        if (value) {
                            $(".preloader").show()
                            console.log(value);
                            $.ajax({
                                type: "POST",
                                url: '../auth/reset_password.php',
                                data: { email: value },
                                success: function (resp) {
                                    $(".preloader").hide()
                                    console.log(resp);
                                    if (resp == 'true') {
                                        swal({
                                            title: "Enviado",
                                            text: "Se envio un Email, para recuperar su contraseña",
                                            icon: "success",
                                        });

                                    } else {
                                        swal({
                                            title: "Alerta",
                                            text: "Email no encontrado",
                                            icon: "warning",
                                        });
                                    }
                                }
                            });

                        }

                    });
            },
            operationTotal(cnt, prec) {
                return (parseInt(cnt + "") * parseFloat(prec + "")).toFixed(2);
            },
            recargarLista() {
                this.listaProd = CARRITO._data.listaCarrito;
            },
            precesar() {
                location.href = "order-completed.php";
            },
            verificar() {
                console.log("dddddddd")

                $.ajax({
                    type: "POST",
                    url: "../auth/login.php",
                    data: { user: this.user, clave: this.clave, vr: 'org', carrito: JSON.stringify(CARRITO._data.listaCarrito) },
                    success: function (resp) {
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
                this.total_pago = parseFloat(this.subTotal_pago) + parseFloat(this.flete_pago);
                return this.total_pago.toFixed(2)
            }
        }
    });
</script>

</html>
