<?php
session_start();
require "../dao/ProductoDao.php";
require "../utils/Tools.php";

$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();
$tools = new Tools();

$dataConf = $tools->getConfiguracion();
$is_valid=false;
$usuario_____='';
if (isset($_GET['token'])){
    $sql ="select * from usuarios where token_reset='{$_GET['token']}'";
    if ($rowww=$conexion->query($sql)->fetch_assoc()){
        $usuario_____=$rowww['use_id'];
        $is_valid=true;
    }
}


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

if ($isSesionUser){
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
            		<h1>Recuperación de contraseña</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active">Recuperación de contraseña</li>
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
                <div class="login_wrap"  id="primary">
            		<div class="padding_eight_all bg-white">

                        <?php

                        if ($is_valid){ ?>
                            <div class="heading_s1">
                                <h3>Nueva contraseña</h3>
                            </div>
                            <form method="post" v-on:submit.prevent="verificar">
                                <input id="token" type="hidden" value="<?=$_GET['token']?>">
                                <input id="user-s" type="hidden" value="<?=base64_encode(base64_encode($usuario_____))?>">
                                <div class="form-group">
                                    <input v-model="clave" class="form-control" required="" type="password" name="password" placeholder="Nueva Contraseña">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-fill-out btn-block" name="login">Cambiar contraseña</button>
                                </div>
                            </form>
                        <?php
                        }else{  ?>

                        <div class="heading_s1 text-center" >
                            <h3>Token no Valido</h3>
                        </div>

                            <?php
                        }

                        ?>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END LOGIN SECTION -->

<!-- START SECTION SUBSCRIBE NEWSLETTER -->
<div class="section bg_default small_pt small_pb">
	<div class="container">	
    	<div class="row align-items-center">	
            <div class="col-md-6">
                <div class="heading_s1 mb-md-0 heading_light">
                    <h3>Recibe las mejores Ofertas en Gaming y Streaming</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="newsletter_form">
                    <form>
                        <input type="text" required="" class="form-control rounded-0" placeholder="Enter Email Address">
                        <button type="submit" class="btn btn-dark rounded-0" name="submit" value="Submit">Subscr&iacute;bete</button>
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
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>


</body>
<script>
    const APP = new Vue({
        el:"#primary",
        data:{
            clave:''
        },
        methods:{
            verificar(){
                console.log("dddddddd")

                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_consulta.php",
                    data:{
                        tipo:'reset-pass-user',
                        user: $("#user-s").val(),
                        clave:this.clave,
                        token:$("#token").val()
                    },
                    success: function (resp) {
                        console.log(resp);
                        resp = JSON.parse(resp);
                        if (resp.res){
                            swal("Alerta","Contraseña Actualizada","success")
                                .then(function (){
                                    location.href="./login.php";
                                })
                        }else{
                            swal("Alerta","No se pudo cambiar la contraseña","warning")
                        }
                    }
                });

                // $("#login").submit()
            }
        }
    });
</script>
</html>
