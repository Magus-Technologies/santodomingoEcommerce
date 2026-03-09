<?php
session_start();
require "../dao/ProductoDao.php";
require "../utils/Tools.php";

$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();
$tools = new Tools();

$dataConf = $tools->getConfiguracion();
?><!DOCTYPE html>
<?php include '../fragment/head_general.php'?>
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .float{
            padding-top: 7px;
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:80px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
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
<!-- LOADER -->
<?php include "../fragment/preloader.php" ?>
<!-- END LOADER -->

<!-- Home Popup Section -->

<!-- End Screen Load Popup Section --> 

<!-- START HEADER -->
<?php include "../fragment/head_secon.php";?>
<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container"><!-- STRART CONTAINER -->
        <div class="row align-items-center">
        	<div class="col-md-6">
                <div class="page-title">
            		<h1>Register</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Register</li>
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
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
            		<div id="cont-promary" class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Crea una cuenta</h3>
                        </div>

                        <form v-if="iusVerificado===1"  v-on:submit.prevent="verificar()">
                            <div class="form-group">
                                <input v-model="nombre" autocomplete="off" type="text" required="" class="form-control" name="name" placeholder="Introduzca su nombre">
                            </div>
                            <div class="form-group">
                                <input autocomplete="off"  v-model="email" type="email" required="" class="form-control" name="email" placeholder="Introduce tu correo electrónico">
                                <label v-if="emailUsado" class="" style="color: red;font-size: 13px;">Este Email está siendo usado</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block" name="register" style="background-color:#232323; color:#fff;">Continuar</button>
                            </div>
                        </form>
                        <form v-else-if="iusVerificado===2"  v-on:submit.prevent="verificarEmailCode()">
                            <div class="form-group">
                                <input v-model="codeVddd" autocomplete="off" type="text" required="" class="form-control" name="name" placeholder="Codigo de Verificacion">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-fill-out btn-block" name="register" style="background-color:#232323; color:#fff;">Verificar</button>
                            </div>
                        </form>
                        <form v-else  v-on:submit.prevent="registrar()">

                            <div class="form-group">
                                <input v-model="clave"  class="form-control" required="" type="password" name="password" placeholder="Contraseña">
                                <label v-if="valClave" class="" style="color: red;font-size: 13px;">Debe ser mayor a 6 caracteres</label>

                            </div>
                            <div class="form-group">

                                <input v-model="claveConfir"  class="form-control" required="" type="password" name="password" placeholder="Confirmar contraseña">
                                <label v-if="noClaveIgual"  class="" style="color: red;font-size: 13px;">contraseña no coincide</label>

                            </div>
                            <!--div class="login_footer form-group">
                                <div class="chek-form">
                                    <div class="custome-checkbox">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                        <label class="form-check-label" for="exampleCheckbox2"><span>Estoy de acuerdo con los términos &amp; Política.</span></label>
                                    </div>
                                </div>
                            </div-->
                            <div class="form-group">
                                <button type="submit" class="btn btn-block" name="register" style="background-color:#232323; color:#fff;">Registrarse</button>
                            </div>
                        </form>
                        <!--div class="different_login">
                            <span> or</span>
                        </div>
                        <ul class="btn-login list_none text-center">
                            <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>
                            <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>
                        </ul-->
                        <div class="form-note text-center">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN SECTION -->

<!-- START SECTION SUBSCRIBE NEWSLETTER
<div class="section bg_default small_pt small_pb">
	<div class="container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Subscribe Our Newsletter</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form">
                    <form>
                        <input type="text" required="" class="form-control rounded-0" placeholder="Enter Email Address">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- START SECTION SUBSCRIBE NEWSLETTER -->

</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
<?php include "../fragment/footer_gen.php"?>
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
<script src="../public/js/tools.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>


</body>
<script>
    const APP = new Vue({
        el: "#cont-promary",
        data:{
            iusVerificado:1,
            nombre:'',
            email:'',
            clave:'',
            claveConfir:'',
            valClave:false,
            emailUsado:false,
            codeVddd:'',
            codigoVer:''

        },
        methods:{
            verificarEmailCode(){
                if (this.codeVddd.toString()===this.codigoVer.toString()){
                    this.iusVerificado=3
                }else{
                    swal("Codigo No Valido","","warning");
                }
            },
            verificar(){
                var min = 10000;
                var max = 90000;

                var x = Math.floor(Math.random()*(max-min+1)+min);
                this.codigoVer=x
                $("#loader-menor").show()
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_verificador.php",
                    data: {co:x,email:this.email,nombre:this.nombre,tipo:'v'},
                    success: function (resp) {
                        $("#loader-menor").hide()
                        resp= JSON.parse(resp);
                        if (resp.res){
                            swal("Codigo Enviado, Revice su bandeja", {
                                icon: "success",
                            })
                                .then(function () {
                                    APP._data.iusVerificado=2
                                });
                        }else{
                            swal(resp.msg,"","warning");
                        }

                    }
                })

            },
            registrar(){
                if (this.clave.length>5){
                    var datos = {
                        nombre:this.nombre,
                        email:this.email,
                        clave:this.clave,
                        tipo:'v'
                    }
                    $.ajax({
                        type: "POST",
                        url: "../auth/registrar.php",
                        data: datos,
                        success: function (resp) {
                            resp= JSON.parse(resp);
                            if (!resp.res){

                                datos.tipo='i';
                                $("#loader-menor").show()
                                $.ajax({
                                    type: "POST",
                                    url:  "../auth/registrar.php",
                                    data: datos,
                                    success: function (res) {
                                        $("#loader-menor").hide()
                                        if (isJson(res)){
                                            res=JSON.parse(res);
                                            if (res.res){
                                                swal("Registrado", {
                                                    icon: "success",
                                                })
                                                    .then(function () {
                                                        location.href =res.ruta;
                                                    });
                                            }else{
                                                swal("Error","","warning");
                                            }
                                        }else{
                                            swal("Error","","warning");
                                        }

                                    }
                                });


                            }else{
                                swal("Este Email ya está siendo usado", {
                                    icon: "info",
                                }).then(function () {
                                    APP._data.emailUsado=true;
                                });
                            }
                            //console.log(resp);
                        }
                    });
                }else{
                    swal("Alerta","La clave de tener más de 5 caracteres","warning");
                    this.valClave=true;
                }


            }
        },
        computed:{
            noClaveIgual(){
                var val = false;
                if (this.valClave){
                    if(this.clave.length>5){
                        this.valClave=false
                    }
                }
                if(this.clave.length>0){
                    if(this.claveConfir.length>0){
                        val = this.clave != this.claveConfir;
                    }
                }
                return val;
            }
        }
    });
</script>

<script>
    
</script>
</html>
