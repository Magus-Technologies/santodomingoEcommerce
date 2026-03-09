<?php

session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
#if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor' || $validate['perfil'] == 'usuarios digital'){
if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){




require "../utils/Tools.php";

require "../dao/ProductoDao.php";



$tools = new Tools();
$productoDao = new ProductoDao();

$dataConf = $tools->getConfiguracion();
$listaProd = $productoDao->getListaProd();

$ban1_nombre = '';
$ban1_url = $dataConf['banner1']['image'];
$ban1_ide = 'javascript:void(0)';

//echo strlen($dataConf['banner1']['prod']);
if (strlen($dataConf['banner1']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner1']['prod']);
    $respPROB1 = $productoDao->getData2();
    //print_r($respPROB1);
    $ban1_nombre = $respPROB1['nombre'];
    //$ban1_ide:""
}

$ban2_nombre = '';
$ban2_url = $dataConf['banner2']['image'];
$ban2_ide = 'javascript:void(0)';

if (strlen($dataConf['banner2']['prod']) > 0) {
    $productoDao->setProdId($dataConf['banner2']['prod']);
    $respPROB2 = $productoDao->getData2();
    //print_r($respPROB1);
    $ban2_nombre = $respPROB2['nombre'];
    //$ban1_ide:""
}

$banerCimg1 = $dataConf['banercentarl1']['image'];
$banerCprod1 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl1']['prod']) > 0) {
    $banerCprod1 = '';
}

$banerCimg2 = $dataConf['banercentarl2']['image'];
$banerCprod2 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl2']['prod']) > 0) {
    $banerCprod2 = '';
}

$banerCimg3 = $dataConf['banercentarl3']['image'];
$banerCprod3 = 'javascript:void(0)';
if (strlen($dataConf['banercentarl3']['prod']) > 0) {
    $banerCprod3 = '';
}

?><!DOCTYPE html>
<html lang="es">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Los Mejores en Hardware.">
    <meta name="keywords"
          content="tarjeta de video, procesador, hardware, laptop, pc gamer, gaming, memoria ram, GPU, CPU, disco duro, ssd, m.2">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">

    <style>
        .contenendorBanes {
            background-color: #dedede;
            height: 500px;
            overflow: auto;
            padding: 5px;
        }

        .box-banerr {
            background-color: #ffffff;
            border: 1px solid #868686;
            border-radius: 10px;
            height: 230px;
            padding: 5px;
            padding-top: 10px;
        }

        .box-banerr:hover {
            -webkit-box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            box-shadow: 0px 3px 20px 3px rgba(0, 0, 0, 0.75);
            cursor: pointer;
        }

        .bodNeutral {
            float: left;
            margin-bottom: 15px;
        }

        .boton-custo {
            background-color: #b70000;
            color: white;
            padding: 10px;
            width: 35px;
            border-radius: 50%;
        }

        .boton-custo2 {
            background-color: #2470eb;
            color: white;
            padding: 10px;
            width: 35px;
            border-radius: 50%;
        }

        .boton-custo2:hover {
            cursor: pointer;
            background-color: #2470eb;
        }

        .boton-custo:hover {
            cursor: pointer;
            background-color: #9c0000;
        }

        .boton-custo3 {
            background-color: #ebb930;
            color: white;
            padding: 10px;
            width: 35px;
            border-radius: 50%;
        }

        .boton-custo3:hover {
            cursor: pointer;
            background-color: #ebb930;
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
<script>
	function guardarWhatsapp() {
		const what = $("#linkwhatsapp-config").val();
		$.ajax({
			type: "POST",
			url: "../ajax/ajs_configuracione.php",
			data: {tipo: 'whatsapp', link: what},
			success: function (ressss) {
				console.log(ressss)
				$('#whatsapp-modal').modal('hide');
			}
		});
	}
</script>

<!-- Modal -->
<div class="modal fade" id="whatsapp-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Link WhatsApp</label>
                    <input type="text" value="<?=$dataConf['whatsapp']?>" class="form-control" id="linkwhatsapp-config"
                           aria-describedby="emailHelp" placeholder="">
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="guardarWhatsapp()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<div class="custom-container" id="contenedor-principal">.
    <div class="modal fade" id="addTelefoo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Numero de telefono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre:</label>
                        <input placeholder="" v-model="dataRTel.nombre" type="text"
                               class="form-control recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Numero:</label>
                        <input placeholder="" @keypress="onlyNumber" v-model="dataRTel.numero" type="text"
                               class="form-control recipient-name-prod">
                    </div>

                </div>
                <div class="modal-footer">
                    <button v-on:click="agregarNumero()" type="button" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edtWhatsapp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Numero de telefono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre:</label>
                        <input placeholder="" v-model="dataConf.redessociales.whatsapp[itemselect].nombre" type="text"
                               class="form-control recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Numero:</label>
                        <input placeholder="" @keypress="onlyNumber"
                               v-model="dataConf.redessociales.whatsapp[itemselect].numero" type="text"
                               class="form-control recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Dias:</label>
                        <div class="input-group" style="margin-bottom: 5px;">
                            <div class="input-group-addon btn btn-default">DESDE:</div>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].dia1"
                                    class="form-control recipient-name-prod">
                                <option value="1">LUNES</option>
                                <option value="2">MARTES</option>
                                <option value="3">MIERCOLES</option>
                                <option value="4">JUEVES</option>
                                <option value="5">VIERNES</option>
                                <option value="6">SABADO</option>
                                <option value="0">DOMINGO</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon btn btn-default">HASTA:</div>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].dia2"
                                    class="form-control recipient-name-prod">
                                <option value="1">LUNES</option>
                                <option value="2">MARTES</option>
                                <option value="3">MIERCOLES</option>
                                <option value="4">JUEVES</option>
                                <option value="5">VIERNES</option>
                                <option value="6">SABADO</option>
                                <option value="0">DOMINGO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">HORARIO:</label>
                        <div class="input-group" style="margin-bottom: 5px;">
                            <div class="input-group-addon btn btn-default">DESDE:</div>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].hora1"
                                    style="width: 200px;margin-right: 5px;" class="recipient-name-prod">

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].modo1" style="width: 200px"
                                    class="recipient-name-prod">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon btn btn-default">HASTA:</div>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].hora2"
                                    style="width: 200px;margin-right: 5px;" class="recipient-name-prod">

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select v-model="dataConf.redessociales.whatsapp[itemselect].modo2" style="width: 200px"
                                    class="recipient-name-prod">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Mensaje predefinido:</label>
                        <input placeholder="" v-model="dataConf.redessociales.whatsapp[itemselect].mensaje" type="text"
                               class="form-control recipient-name-prod">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addWhatsapp" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Numero de telefono</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nombre:</label>
                        <input placeholder="" v-model="dataRwhat.nombre" type="text"
                               class="form-control recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Numero:</label>
                        <input placeholder="" @keypress="onlyNumber" v-model="dataRwhat.numero" type="text"
                               class="form-control recipient-name-prod">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Dias:</label>
                        <div class="input-group" style="margin-bottom: 5px;">
                            <div class="input-group-addon btn btn-default">DESDE:</div>
                            <select v-model="dataRwhat.dia1" class="form-control recipient-name-prod">
                                <option value="1">LUNES</option>
                                <option value="2">MARTES</option>
                                <option value="3">MIERCOLES</option>
                                <option value="4">JUEVES</option>
                                <option value="5">VIERNES</option>
                                <option value="6">SABADO</option>
                                <option value="0">DOMINGO</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon btn btn-default">HASTA:</div>
                            <select v-model="dataRwhat.dia2" class="form-control recipient-name-prod">
                                <option value="1">LUNES</option>
                                <option value="2">MARTES</option>
                                <option value="3">MIERCOLES</option>
                                <option value="4">JUEVES</option>
                                <option value="5">VIERNES</option>
                                <option value="6">SABADO</option>
                                <option value="0">DOMINGO</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">HORARIO:</label>
                        <div class="input-group" style="margin-bottom: 5px;">
                            <div class="input-group-addon btn btn-default">DESDE:</div>
                            <select v-model="dataRwhat.hora1" style="width: 200px;margin-right: 5px;"
                                    class="recipient-name-prod">

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select v-model="dataRwhat.modo1" style="width: 200px" class="recipient-name-prod">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon btn btn-default">HASTA:</div>
                            <select v-model="dataRwhat.hora2" style="width: 200px;margin-right: 5px;"
                                    class="recipient-name-prod">

                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <select v-model="dataRwhat.modo2" style="width: 200px" class="recipient-name-prod">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Mensaje predefinido:</label>
                        <input placeholder="" v-model="dataRwhat.mensaje" type="text"
                               class="form-control recipient-name-prod">
                    </div>

                </div>
                <div class="modal-footer">
                    <button v-on:click="agregarwhat()" type="button" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><h2>Configuración principal de la web</h2></div>
        <div class="col-md-12 text-center" style="margin: 20px;">
            <button v-on:click="cargarGuardar()" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
        </div>

        <div class="col-md-12"
             style="border: 1px solid #aba8a8;border-radius: 10px;margin-bottom: 100px;padding-top: 10px;">


            <div class="col-md-12" style="overflow: hidden">
                <div style="float: left" class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <h4>Información de la web</h4>
                        </div>

                    </div>


                    <div class="form-group row">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Titulo</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.titulo" class="form-control" id="inputTelefono"
                                   placeholder="Titulo web">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Descripcion</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.descripcion" class="form-control" id="inputTelefono"
                                   placeholder="Descripcion web">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Direccion</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.direccion" class="form-control" id="staticEmail"
                                   placeholder="Email............">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.email" class="form-control" id="staticEmail"
                                   placeholder="Email............">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTelefono" class="col-sm-2 col-form-label">Telefono Principal</label>
                        <div class="col-sm-10">
                            <input v-model="dataConf.numero_central" maxlength="25" type="text" class="form-control"
                                   id="inputTelefono" placeholder="00000000">
                        </div>
                    </div>

                </div>
                <div style="float: left" class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <h4>Redes sociales</h4>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="staticfacebook" class="col-sm-2 col-form-label">Id Facebook</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.id_facebook" class="form-control"
                                   id="staticfacebookl" placeholder="Id Facebook">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticfacebook" class="col-sm-2 col-form-label">Facebook</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.facebook" class="form-control"
                                   placeholder="link ...  ">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputtwitter" class="col-sm-2 col-form-label">Twitter</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.twitter" class="form-control"
                                   placeholder="link .......">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputtwitter" class="col-sm-2 col-form-label">YouTube</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.youtube" class="form-control"
                                   placeholder="link .......">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputtwitter" class="col-sm-2 col-form-label">Instagram</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.instagram" class="form-control"
                                   placeholder="link .......">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputtwitter" class="col-sm-2 col-form-label">Google Plus</label>
                        <div class="col-sm-10">
                            <input type="text" v-model="dataConf.redessociales.google_plus" class="form-control"
                                   placeholder="link .......">
                        </div>
                    </div>


                </div>
            </div>
            <div class="form-group row">
                <label for="inputwhatsapp" class="col-sm-2 col-form-label">Whatsapp</label>
                <div class="col-sm-10">
                    <div class="form-group row">
                        <span data-toggle="modal" data-target="#addWhatsapp" class="btn btn-success"><i
                                    class="fa fa-plus"></i></span>

                        <div class="col-md-12">
                            <br>
                            <table class="table" style="width:100%">
                                <tr>

                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Numero</th>
                                    <th class="text-center">Dias</th>
                                    <th class="text-center">Horario</th>
                                    <th class="text-center">Mensaje</th>
                                    <th class="text-center">Activo</th>
                                    <th class="text-center"></th>
                                </tr>
                                <tr v-for="(item, index) in dataConf.redessociales.whatsapp">


                                    <td class="text-center">{{item.nombre}}</td>
                                    <td class="text-center">{{item.numero}}</td>
                                    <td class="text-center">{{visualisador(item.dia1)}} - {{visualisador(item.dia2)}}
                                    </td>
                                    <td class="text-center">{{item.hora1}} {{item.modo1}} - {{item.hora2}}
                                        {{item.modo2}}
                                    </td>
                                    <td class="text-center">{{item.mensaje}}</td>
                                    <td class="text-center"><input v-model="item.estado" type="checkbox"></td>
                                    <td class="text-center">
                                        <i v-on:click="dismi(index)" class="boton-custo3 fa fa-arrow-up"></i>
                                        <i v-on:click="aumen(index)" class="boton-custo3 fa fa-arrow-down"></i>
                                        <i v-on:click="actualizarWatsapp(index)" class="boton-custo2 fa fa-edit"></i>
                                        <i v-on:click="eliminarWhatsapp(index)" class="boton-custo fa fa-times"></i>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <div class="form-group row">
                <label for="inputTelefono" class="col-sm-2 col-form-label">Otros Telefonos</label>
                <div class="col-sm-10">
                    <div class="col-md-12">
                        <span data-toggle="modal" data-target="#addTelefoo" class="btn btn-success"><i
                                    class="fa fa-plus"></i></span>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <table class="table" style="width:100%">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Numero</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                            <tr v-for="(item, index) in dataConf.telefonos">
                                <td class="text-center">{{item.nombre}}</td>
                                <td class="text-center">{{item.numero}}</td>
                                <td class="text-center"><i v-on:click="eliminarTelefono(index)"
                                                           class="boton-custo fa fa-times"></i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
</div>


<div class="modal fade" id="baner1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baner 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input accept="image/*" id="fill_img_banner1" type="file" style="display: none">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                    <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod"
                           id="recipient-name-prod1">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Banner:</label>
                    <div class="col-md-12 text-center">
                        <button onclick="$('#fill_img_banner1').click()" class="btn btn-primary">Seleccionar Banner
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="imagen_baner1" style="display: block;margin: auto;max-height: 450px;"
                             src="../public/img/banner/sinimagen_menu_20sba.jpg">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="guardarBaner1()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="baner1Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baner 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input accept="image/*" id="fill_img_banner1i" type="file" style="display: none">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                    <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod"
                           id="recipient-name-prodBi1">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Banner:</label>
                    <div class="col-md-12 text-center">
                        <button onclick="$('#fill_img_banner1i').click()" class="btn btn-primary">Seleccionar Banner
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="imagen_baner1i" style="display: block;margin: auto;max-height: 450px;"
                             src="../public/img/banner/sinimagen_menu_20sba.jpg">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="guardarBanerC1()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="baner2Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baner 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input accept="image/*" id="fill_img_banner2i" type="file" style="display: none">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                    <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod"
                           id="recipient-name-prodBi2">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Banner:</label>
                    <div class="col-md-12 text-center">
                        <button onclick="$('#fill_img_banner2i').click()" class="btn btn-primary">Seleccionar Banner
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="imagen_baner2i" style="display: block;margin: auto;max-height: 450px;"
                             src="../public/img/banner/sinimagen_menu_20sba.jpg">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="guardarBanerC2()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="baner3Central" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baner 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input accept="image/*" id="fill_img_banner3i" type="file" style="display: none">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                    <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod"
                           id="recipient-name-prodBi3">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Banner:</label>
                    <div class="col-md-12 text-center">
                        <button onclick="$('#fill_img_banner3i').click()" class="btn btn-primary">Seleccionar Banner
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="imagen_baner3i" style="display: block;margin: auto;max-height: 450px;"
                             src="../public/img/banner/sinimagen_menu_20sba.jpg">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="guardarBanerC3()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="baner2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Baner 2</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input accept="image/*" id="fill_img_banner2" type="file" style="display: none">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Enlazar a producto:</label>
                    <input placeholder="Click para buscar" type="text" class="form-control recipient-name-prod"
                           id="recipient-name-prod">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Banner:</label>
                    <div class="col-md-12 text-center">
                        <button onclick="$('#fill_img_banner2').click()" class="btn btn-primary">Seleccionar Banner
                        </button>
                    </div>
                    <div class="col-md-12 text-center">
                        <img id="imagen_baner2" style="display: block;margin: auto;max-height: 450px;"
                             src="../public/img/banner/sinimagen_menu_20sba.jpg">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button onclick="guardarBaner2()" type="button" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_listaProduc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" style=" max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliga el producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Lista de productos</label>
                </div>
                <div class="form-group">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($listaProd as $row) { ?>
                                <tr>
                                    <td id="nom_<?=$row['prod_id']?>"><?=$row['nom_prod']?></td>
                                    <td><?=$row['categoria']?></td>
                                    <td><?=$row['marca']?></td>
                                    <td><?=$row['stock']?></td>
                                    <td><?=$row['precio']?></td>
                                    <td>
                                        <button onclick="selectProducto(<?=$row['prod_id']?>)"
                                                style="padding: 10px;padding-left: 15px;" class="btn btn-info"><i
                                                    class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                            <?php }

                        ?>


                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>


</div>


<!-- END MAIN CONTENT -->

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
                    <p class="mb-md-0 text-center text-md-left"> 2024 Todos los derechos reservados por <a
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
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>
<input id="id_prod" type="hidden">
</body>
<script src="../public/js/indadminconfg.js?v=5"></script>
</html>
<?php }
    else {
        header("Location: ../CYM/");
    }
