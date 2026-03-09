<?php
session_start();


require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){


require "../utils/Tools.php";
require "../dao/MarcaSeleccionDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../dao/ProductoDao.php";

$tools = new Tools();
$marcas = new MarcaSeleccionDao();
$categoria = new GrupoCategoriaDao();
$productoDao= new ProductoDao();

$dataConf = $tools->getConfiguracion();

$listaMarca = $marcas->getDataOnli();
$listaCatego = $categoria->getGategoliaOnli();

$oferta = $_GET['ofert'];


//echo "sddddddd";
//print_r($listaCatego);


?><!DOCTYPE html>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
<style>
    .box-item-img:hover{
        cursor: pointer;
    }
    .box-imageSS:hover{
        cursor: pointer;
        background-color: #ee8577;
    }
    .itemSelct{
        background-color: rgba(69, 68, 238, 0.91);
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

<input id="oferta" type="hidden" value="<?=$oferta?>">
<div class="section">
    <div class="container">
        <div class="row  justify-content-md-center" style="margin-bottom: 20px">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-md-12 text-right">
                    <a href="ofertas.php" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Atras</a>
                </div>
            </div>
            <div class="col-md-12 text-center">

                <button onclick="APP.guardarOferta()" class="btn btn-primary">Guardar</button>
                <button onclick="APP.eliminarOferta()" class="btn btn-danger">Eliminar</button>
            </div>
        </div>

        <div class="row" id="contenedor">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Producto</label>
                    <input type="hidden" id="id_prod">
                    <input v-model="dataR.nombre" disabled type="text" class="form-control" id="producto-select" aria-describedby="emailHelp" placeholder="nombre del producto">
                    <small style="font-size: 16px; font-weight: bold;" id="textoAyuda" class="form-text text-muted"></small>
                </div>
                <div class="form-group col-md-4" style="float: left;">
                    <label for="exampleInputPassword1">Termino</label>
                    <input v-model="dataR.termino" id="termino" type="date" class="form-control" placeholder="">
                </div>
                <div class="form-group col-md-4" style="float: left;">
                    <label for="exampleInputPassword1">Cantidad</label>
                    <input v-model="dataR.cantidad" id="cantidad" type="text" class="form-control" @keypress="onlyNumber" placeholder="cantidad de oferta">
                </div>
                <div class="form-group col-md-4" style="float: left;">
                    <label for="exampleInputPassword1">precio</label>
                    <input v-model="dataR.precio" id="precio" type="text" class="form-control" @keypress="onlyNumber" placeholder="Precio de oferta">
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

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

<script src="../public/assets/js/scripts.js"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>

</body>

<script>
    const APP = new Vue({
        el:'#contenedor',
        data:{
            dataR:{
                oferId:'',
                idProd:'',
                nombre:'',
                termino:'',
                cantidad:'',
                precio:''
            }
        },
        methods:{
            getDataOfert(){
              const ofer = $("#oferta").val();
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_ofertas.php",
                    data: {tipo:'se',ofer},
                    success: function (resp) {
                        resp = JSON.parse(resp)
                        console.log(resp);
                        APP._data.dataR={
                            oferId:ofer,
                            idProd:resp.prod_i,
                            nombre:resp.nombre,
                            termino:resp.fecha_termino,
                            cantidad:resp.cantidad,
                            precio:resp.precio_oferta
                        }

                    }
                });

            },
            eliminarOferta(){
                const ofer = $("#oferta").val();
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_ofertas.php",
                    data: {tipo:'del',ofer},
                    success: function (resp) {
                        resp = JSON.parse(resp)
                        if (resp.res){
                            location.href ="ofertas.php";
                        }else{
                            swal("No se pudo eliminar esta oferta","","warning");
                        }

                    }
                });
            },
            guardarOferta(){


                    const dataR={...this.dataR}
                    dataR.tipo='up'

                    $.ajax({
                        type: "POST",
                        url: '../ajax/ajs_ofertas.php',
                        data: dataR,
                        success: function (resp) {
                            resp = JSON.parse(resp)
                            if (resp.res){
                                location.href ="ofertas.php";
                            }else{
                                swal("No se pudo guardar esta oferta","Complete todos los campos ","warning");
                            }
                            console.log(resp);
                        }
                    });


            },
            onlyNumber ($event) {
                //console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
                    $event.preventDefault();
                }
            }
        }
    });
    var stockPR=0;
    function selectProducto(ide) {
        $("#id_prod").val(ide);
        $("#producto-select").val($("#nom_"+ide).text());

        const stockC = $("#stock_"+ide).text();
        const precioC = $("#precio_"+ide).text();
        stockPR=stockC;
       $("#textoAyuda").text("Stock actual: " + parseInt(stockC) + ",  precio actual: $"+parseFloat(precioC));
        $('#modal_listaProduc').modal('hide');
    }

    function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }


    var table;
    $( document ).ready(function() {

         APP.getDataOfert();


        /*$("#producto-select").focus(function () {
            $("#modal_listaProduc").modal('show');
        })*/



    })
</script>
</html>




<?php } else {
    header("Location: ../CYM/");
}
?>
