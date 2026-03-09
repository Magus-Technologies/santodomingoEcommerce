<?php
session_start();

require "../dao/ProductoDao.php";
require "../utils/Tools.php";
$conexion = (new Conexion())->getConexion();
$productoDao = new ProductoDao();
$tools = new Tools();

$dataConf = $tools->getConfiguracion();
$idusu=$_SESSION['usuario'];
$sql = "SELECT *, DATE_FORMAT(lib_date,'%d/%m/%Y') AS fecha2 
	FROM libro_reclamacion rr, usuarios uu 
	WHERE rr.lib_emailcli = uu.email AND uu.use_id='$idusu'";
$result = $productoDao->exeSQL($sql);

$sql2 = "SELECT vip_id FROM usuarios_vip WHERE use_id='$idusu'";
$result2 = $productoDao->exeSQL($sql2);
foreach ($result2 as $rowvp) {
	$vipu = $rowvp['vip_id'];
 }





?>
<!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>
<!-- SITE TITLE -->
<title>COMPUTER</title>
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
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
                        <h1>Mi cuenta</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Mi cuenta</li>
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
            <div id="contenedor-vue" class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        <div class="dashboard_menu">
                            <ul class="nav nav-tabs flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="account-detail-tab" data-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true"><i class="ti-id-badge"></i>Detalles de la cuenta</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false"><i class="ti-shopping-cart-full"></i>Pedidos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="shopping-tab" data-toggle="tab" href="#shopping" role="tab" aria-controls="shopping" aria-selected="false"><i class="ti-bag"></i>Compras</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reclaim-tab" data-toggle="tab" href="#reclaim" role="tab" aria-controls="shopping" aria-selected="false"><i class="ti-id-badge"></i>Reclamos</a>
                                </li>
                                <li hidden class="nav-item">
                                    <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="true"><i class="ti-location-pin"></i>Mi
                                        dirección</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="../auth/logout.php"><i class="ti-lock"></i>Cerrar sesión</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Dashboard</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>From your account dashboard. you can easily check &amp; view your <a href="javascript:void(0);" onclick="$('#orders-tab').trigger('click')">recent
                                                orders</a>, manage your <a href="javascript:void(0);" onclick="$('#address-tab').trigger('click')">shipping
                                                and billing addresses</a> and <a href="javascript:void(0);" onclick="$('#account-detail-tab').trigger('click')">edit
                                                your password and account details.</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Mis pedidos</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Descargar</th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in lista_pedidos">
                                                        <td>#{{item.pedido_id}}</td>
                                                        <td>{{item.fecha}}</td>
                                                        <td>{{estador(item.estado)}}</td>
                                                        <td>

                                                            <a class="btn btn-primary" id="btnDescargarPedidos" target="_blank" :href="'../CYM/lista_pedidos_cliente.php/' + item.pedido_id"><i class='fa fa-download'></i></a>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="shopping" role="tabpanel" aria-labelledby="shopping-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Mis Compras</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nro </th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Descargar</th>
                                                        <th></th>
                                                        <!-- <th></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in lista_comras">
                                                        <td>#{{item.compra_id}}</td>
                                                        <td>{{item.fecha}}</td>
                                                        <td>{{estador(item.estado)}}</td>
                                                        <td>

                                                            <a class="btn btn-primary" id="btnDescargarPedidos" target="_blank" :href="'../CYM/lista_compras_cliente.php/' + item.compra_id"><i class='fa fa-download'></i></a>
                                                        </td>
                                                        <td v-if="(item.archivo||'').length>5"><a :href="'../public/data/files/compras/<?=$_SESSION['usuario']?>/'+item.archivo" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
                                                        <td></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reclaim" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Mis Reclamos</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Detalle</th>
                                                    <th class="text-center">Respuesta</th>
                                                    <th class="text-center">Ver</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($result as $row_ped) { ?>
                                                    <tr>
                                                        <td class="text-center"><?= $row_ped['lib_code'] ?></td>
                                                        <td class="text-center"><?= $row_ped['fecha2'] ?></td>
                                                        <td class="text-center"><?=$row_ped['lib_serdesc']?></td>
                                                        <td class="text-center"><?=$row_ped['lib_respuesta']?></td>

                                                        <td class="text-center">
                                                            <a class="btn btn-xs btn-warning" target="_blank" href="../public/librorec/libroresp.php?id=<?=$row_ped['lib_id'];?>&opc=N" style="color: white"><i class="fa fa-edit"></i></a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">

                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3 mb-lg-0">
                                            <div class="card-header">
                                                <h3>Billing Address</h3>
                                            </div>
                                            <div class="card-body">
                                                <address>House #15<br>Road #1<br>Block #C <br>Angali <br> Vedora <br>1212
                                                </address>
                                                <p>New York</p>
                                                <a href="#" class="btn btn-fill-out">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3>Shipping Address</h3>
                                            </div>
                                            <div class="card-body">
                                                <address>House #15<br>Road #1<br>Block #C <br>Angali <br> Vedora <br>1212
                                                </address>
                                                <p>New York</p>
                                                <a href="#" class="btn btn-fill-out">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade  active show" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Detalles de mi cuenta</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($_SESSION['usuario'])) : ?>
                                            <form id="cambiar_nombre">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Nombres <span class="required">*</span></label>
                                                        <input value="<?= $_SESSION['nombres'] ?>" id="cambiarName" name="cambiarName" class="form-control" type="text">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Email <span class="required">*</span></label>
                                                        <input value="<?= $_SESSION['email'] ?>" disabled class="form-control" type="email">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn " name="submit" value="Submit" 
								style="background-color:#232323; color:#fff; !important">Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
						<h4 class="mt-3">Zona VIP</h4>
						
					       <form id="solicitar_vip">
						    <input type="hidden" value="<?= $_SESSION['usuario'] ?>" class="form-control" id="usupermi">
                                                <div class="row">
                                                   
                                                    <div class="form-group col-md-12">
                                                        <label>Email <span class="required">*</span></label>
                                                        <input value="<?= $_SESSION['email'] ?>" disabled class="form-control" type="email">
                                                    </div>
                                                    <div class="col-md-12">
							  <?php if ($vipu=="") : ?>	
                                                        <button type="submit" class="btn " name="submit" value="Submit" 
								style="background-color:#232323; color:#fff; !important"> Solicitar Acceso
                                                        </button>
	   						  <?php endif; ?>
							   <?php if ($vipu=="1") : ?>
								<label>Estatus</label>
							 	<input value="<?='HABILITADO'?>" disabled class="form-control">
	   						  <?php endif; ?>
							   <?php if ($vipu=="0") : ?>
								<label>Estatus</label>
							 	<input value="<?='EN ESPERA'?>" disabled class="form-control">
	   						  <?php endif; ?>

                                                    </div>
                                                </div>
                                            </form>	


                                            <form method="post" name="enq" v-on:submit.prevent="cambiar_pass" class="mt-5">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Nuevo contraseña <span class="required">*</span></label>
                                                        <input v-model="npasword" required="" class="form-control" name="npassword" type="password">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn " name="submit" value="Submit" style="background-color:#232323; color:#fff; !important"
>Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input v-model="dat.nombre" type="text" disabled placeholder="Nombres" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input v-model="dat.apellido" type="text" disabled placeholder="Apellidos" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input v-model="dat.num_doc" type="text" disabled placeholder="Nr DNI / RUC" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input v-model="dat.celular" type="text" disabled placeholder="Celular" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <input v-model="dat.email" disabled type="text" name="email" placeholder="Email" class="form-control">
                                    </div>
                                    <div class="form-group mb-0">
                                        <textarea v-model="dat.notas" disabled rows="3" name="nota" placeholder="" class="form-control"></textarea>
                                    </div>
                                    <div class="heading_s1">
                                        <h4>Productos</h4>
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th class="text-center">Cnt</th>
                                                    <th class="text-center">Precio</th>
                                                    <th class="text-center">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in dat.productos">
                                                    <td>{{item.nombre}}</td>
                                                    <td class="text-center">{{item.cantidad}}</td>
                                                    <td class="text-center">${{formatNumeberDecimal(item.precio)}}</td>
                                                    <td class="text-center">${{importe_prodd(item.cantidad,item.precio)}}</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                                                    <td class="text-center">${{total_productos}}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->

        <!-- START SECTION SUBSCRIBE NEWSLETTER -->
        <div class="section bg_default small_pt small_pb" style="background-color:#1c15f7 !important">
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
                                <button type="submit" style="background-color:#232323 !important"
 class="btn btn-dark rounded-0" name="submit" value="Submit">
                                    Suscribir
                                </button>
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
    <script src="../public/js/main.js?v=2"></script>
    <script src="../public/js/tools.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        const APP = new Vue({
            el: '#contenedor-vue',
            data: {
                dat: {
                    nombre: '',
                    apellido: '',
                    num_doc: '',
                    celular: '',
                    email: '',
                    notas: '',
                    productos: []
                },
                npasword: '',
                lista_pedidos: [],
                lista_comras:[],
                lista_comras22:[],
            },
            methods: {
                importe_prodd(cnt, prec) {
                    return (parseFloat(cnt) * parseFloat(prec)).toFixed(2);
                },
                formatNumeberDecimal(num) {
                    return parseFloat(num + '').toFixed(2);
                },
                getPedidosData(pedido) {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'data-pdds-user',
                            pedido
                        },
                        success: function(resp) {

                            resp = JSON.parse(resp);
                            if (resp.res) {
                                APP._data.dat.apellido = resp.data.apellido
                                APP._data.dat.celular = resp.data.celular
                                APP._data.dat.email = resp.data.email
                                APP._data.dat.nombre = resp.data.nombre
                                APP._data.dat.notas = resp.data.notas
                                APP._data.dat.num_doc = resp.data.nun_doc
                                APP._data.dat.productos = resp.data.productos

                            }


                        }
                    });
                },
                getListaPedidos() {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'lts-pdds-user'
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp);
                            resp = resp.reverse();
                            APP._data.lista_comras22 = resp;
                            APP._data.lista_pedidos = resp;
                        }
                    });
                },
                getListaCompras() {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'lts-comp-user'
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp);
                            resp = resp.reverse();
                            console.log(resp);
                            APP._data.lista_comras = resp;
                        }
                    });
                },
                cambiar_pass() {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'chg-pass-user',
                            npss: this.npasword
                        },
                        success: function(resp) {
                            console.log(resp);
                            resp = JSON.parse(resp);
                            if (resp.res) {
                                APP._data.npasword = '';
                                alertExito("Contraseña cambiada", "")
                            } else {
                                alertAdvertencia("Alerta", "No se pudo cambiar la contraseña")
                            }
                        }
                    });

                },
                estador(est) {
                    switch (est) {
                        case "1":
                            return 'Preparando';
                        case "2":
                            return 'Enviado';
                        case "3":
                            return 'Recibido';
                        case "4":
                            return 'Vendido';
                    }
                },
            },
            computed: {
                temd(){
                },
                total_productos() {
                    var total = 0;
                   /* for (var i = 0; i < this.dat.productos.length; i++) {
                        total += parseFloat(this.dat.productos[i].cantidad + "") * parseFloat(this.dat.productos[i].precio + "");
                    }*/
                    return total.toFixed(2);
                }
            }
        });

        $(document).ready(function() {
            //APP.getListaPedidos();
            //APP.getListaCompras();

	      $('#solicitar_vip').submit(function(e) {
                e.preventDefault()
                if ($('#usupermi').val() !== '') {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'chg-vip-user',
                            name: $('#usupermi').val()
                        },
                        success: function(resp) {
                            console.log(resp);
                            resp = JSON.parse(resp);
                            if (resp.res) {
                                APP._data.npasword = '';
                                alertExito("Solicitud exitosa, este cambio se vera reflejado cuando el administrador acepte la solicitud", "")
                            } else {
                                alertAdvertencia("Alerta", "No se realizar la solicitud")
                            }
                        }
                    });
                } else {
                    alertAdvertencia("Alerta", "No puede dejar el nombre en blanco")
                }
            })


	
	



            $('#cambiar_nombre').submit(function(e) {
                e.preventDefault()
                if ($('#cambiarName').val() !== '') {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_consulta.php",
                        data: {
                            tipo: 'chg-name-user',
                            name: $('#cambiarName').val()
                        },
                        success: function(resp) {
                            console.log(resp);
                            resp = JSON.parse(resp);
                            if (resp.res) {
                                APP._data.npasword = '';
                                alertExito("Cambio exitoso, este cambio se verá reflejado cuando vuelva a iniciar sesion", "")
                            } else {
                                alertAdvertencia("Alerta", "No se pudo cambiar la contraseña")
                            }
                        }
                    });
                } else {
                    alertAdvertencia("Alerta", "No puede dejar el nombre en blanco")
                }
            })



            $("#btnDescargarPedidos").click(function() {
                let idCliente = $(this).attr('data-id')
                console.log(idCliente);
                $.ajax({
                    type: "POST",
                    url: "../CYM/lista_pedidos_cliente.php",
                    data: {
                        idCliente: idCliente
                    },
                    success: function(resp) {
                        /*  resp = JSON.parse(resp);
                         resp = resp.reverse(); */
                        console.log(resp);
                    }
                });
            })
        });
    </script>
</body>

</html>