<?php
session_start();

require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {

    require "../utils/Tools.php";
    require "../dao/ProductoDao.php";

    $tools = new Tools();
    $productoDao = new ProductoDao();

    $dataConf = $tools->getConfiguracion();
    /* 
var_dump($dataConf['banner_menu_lateral_6']);
die(); */
    $listaProd22 = $productoDao->getListaProd();

    $listaProd = $productoDao->exeSQL("SELECT 
  prod.prod_id,
  prod.nombre,
  cate.nombre_cate,
  exclu.*
FROM
  productos_exclusivos AS exclu 
  INNER JOIN producto AS prod 
    ON exclu.prod_id = prod.prod_id 
  INNER JOIN grupo_seleccion AS cate 
    ON prod.categoria = cate.codi_categoria ");
    //print_r($listaProd);

?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="Anil z" name="author">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Los Mejores en Vino y Pisco.">
<meta name="keywords" content="tarjeta de video, procesador, hardware, laptop, pc gamer, gaming, memoria ram, GPU, CPU, disco duro, ssd, m.2">

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

            .active-ban {
                background-color: #e4a6a6;
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
        <?php include "../fragment/nav_bar_admin.php" ?>>
        <!-- END HEADER -->

        <!-- START SECTION BREADCRUMB -->
        <div class="mt-4 staggered-animation-wrap">
            <div class="custom-container">

            </div>
        </div>
        <!-- END SECTION BREADCRUMB -->


        <div class="section" id="modalBanerPrinc">

            <div class="container">
                <div class="row  justify-content-md-center" style="margin-bottom: 20px">
                    <div class="col-md-12 text-center">
                        <h2>Banner Inferior</h2>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-md-12 text-center" style="margin: 10px;">
                        <a href="./" class="btn btn-warning">Salir</a>
                    </div>
                    <div class="col-md-12 text-center" style="margin: 10px;">
                        <button onclick="iniciarProgreso()" data-toggle="modal" data-target="#modal-new-banner" class="btn btn-primary">Agregar</button>
                        <button v-on:click="editar_banner()" class="btn btn-info">Editar</button>
                        <button v-on:click="dismi()" class="btn btn-success"><i class="fa fa-arrow-left"></i></button>
                        <button v-on:click="aumen()" class="btn btn-success"><i class="fa fa-arrow-right"></i></button>
                        <button v-on:click="eliminarBanner()" class="btn btn-danger"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Tamaño maximo 2mb</h3>
                    </div>
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="contenendorBanes col-md-12">
                                <div v-for="(iten, index) in listaBaner" v-on:click="selecIntem(index)" class="col-md-6 bodNeutral">
                                    <div :class="indice==index?'active-ban box-banerr':'box-banerr'" style="overflow: hidden;">
                                        <div class="col-md-6" style="float: left;">
                                            <div class="col-md-12">
                                                <span style="font-size:15px;font-weight: bold;">{{iten.titulo}}</span>
                                            </div>
                                            <div class="col-md-12" v-if="iten.estado === '0'">
                                                <span>No visible</span>
                                            </div>
                                            <div class="col-md-12" v-else-if="iten.estado === '1'">
                                                <span>Visible</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="float: left;">
                                            <img :src="'../public/img/banner/'+iten.imagen" style="max-width: 100%; max-height: 100%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-new-banner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:  10000">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h3 class="modal-title" id="exampleModalLabel">Agregar Banner</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Banner:</label>
                                <input id="filBann" type="file" accept="image/*" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Nombre o Titulo grande:</label>
                                <input v-model="dataR.titulo" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Url:</label>
                                <input v-model="dataR.url" type="text" class="form-control">
                            </div>

                        </div>
                        <div style="padding: 5px;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="guardarBann()" type="button" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-edt-banner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="z-index:  10000">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h3 class="modal-title" id="exampleModalLabel">Editar Banner</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Nuevo Banner:</label>
                                <input id="filBannedt" type="file" accept="image/*" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Nombre o Titulo grande:</label>
                                <input v-model="dataE.titulo" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Url:</label>
                                <input v-model="dataE.url" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Estado:</label>
                                <select name="idEstadoEditar" id="idEstadoEditar" class="form-control" v-model="dataE.estado">
                                    <option value="0">No visible</option>
                                    <option value="1">Vsible</option>
                                </select>
                            </div>


                        </div>
                        <div style="padding: 5px;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-on:click="guardarBannedt()" type="button" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal_listaProduc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <table id="tabla-productos" class="table table-striped table-bordered" style="width:100%">
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
                                    foreach ($listaProd22 as $row) {       ?>
                                        <tr>
                                            <td id="nom_<?= $row['prod_id'] ?>"><?= $row['nom_prod'] ?></td>
                                            <td><?= $row['categoria'] ?></td>
                                            <td><?= $row['marca'] ?></td>
                                            <td id="stock_<?= $row['prod_id'] ?>"><?= $row['stock'] ?></td>
                                            <td id="precio_<?= $row['prod_id'] ?>"><?= $row['precio'] ?></td>
                                            <td><span type="button" onclick="selectProducto(<?= $row['prod_id'] ?>)" style="padding: 10px;padding-left: 15px;" class="btn btn-info"><i class="fa fa-check"></i></span></td>
                                        </tr>
                                    <?php    }

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
                            <p class="mb-md-0 text-center text-md-left">© 2020 Todos los derechos reservados por Compu Vision</p>
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
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
        <script src="../public/plugin/sweetalert2/vue-swal.js"></script>
    </body>

    <script>
        function iniciarProgreso() {
            $('.progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0);
        }

        function selectProducto(ide) {

            $('#modal_listaProduc').modal('hide');
            APP_BANN.setDataInfoPRo(ide, $("#nom_" + ide).text());
        }

        const APP_BANN = new Vue({
            el: '#modalBanerPrinc',
            data: {
                indice: -1,
                listaBaner: [],
                nomProd: '',
                dataR: {
                    "imagen": "",
                    "titulo": "",
                    "titulo_peque": "",
                    "parrafo": "",
                    "enlazado": "",
                    "prod": "",
                    "pocision": 3,
                    "estado": "1",
                    "url": ""

                },
                dataE: {
                    "imagen": "",
                    "titulo": "",
                    "titulo_peque": "",
                    "parrafo": "",
                    "enlazado": "",
                    "prod": "",
                    "pocision": 3,
                    "estado": "",
                    "url": ""
                }
            },
            methods: {
                editar_banner() {
                    if (this.indice != -1) {
                        const data_e = this.listaBaner[this.indice];
                        this.dataE = {
                            index: -1,
                            imagen: data_e.imagen,
                            titulo: data_e.titulo,
                            titulo_peque: data_e.titulo_peque,
                            parrafo: data_e.parrafo,
                            enlazado: data_e.enlazado,
                            prod: data_e.prod,
                            pocision: 3,
                            url: data_e.url,
                            estado: data_e.estado,

                        }
                        console.log(data_e);
                        $('#modal-edt-banner').modal('show')
                    }
                },
                selecIntem(index) {
                    this.indice = index;
                },
                eliminarBanner() {
                    if (this.indice != -1) {
                        this.listaBaner.splice(this.indice, 1);
                        this.indice = -1;
                        this.guardarDataBanner();
                    }

                },
                dismi() {
                    if (this.indice != -1) {
                        const itemTmep = this.listaBaner[this.indice]
                        this.listaBaner.splice(this.indice, 1);
                        if (this.indice > 0) {
                            this.indice--;
                        }
                        var arrTemp = [];
                        for (var i = 0; i < this.listaBaner.length; i++) {
                            if (i == this.indice) {
                                arrTemp.push(itemTmep);
                            }
                            arrTemp.push(this.listaBaner[i]);
                        }
                        this.listaBaner = arrTemp
                        this.guardarDataBanner();
                    }

                },
                aumen() {
                    if (this.indice != -1) {
                        if (this.indice < this.listaBaner.length) {
                            const itemTmep = this.listaBaner[this.indice]
                            this.listaBaner.splice(this.indice, 1);
                            if (this.indice < this.listaBaner.length) {
                                this.indice++;
                            }
                            var arrTemp = [];

                            for (var i = 0; i < this.listaBaner.length; i++) {
                                if (i == this.indice) {
                                    arrTemp.push(itemTmep);
                                }
                                arrTemp.push(this.listaBaner[i]);
                            }
                            if (this.indice == this.listaBaner.length) {
                                arrTemp.push(itemTmep);
                            }
                            this.listaBaner = arrTemp;
                            this.guardarDataBanner();
                        }
                    }


                },
                guardarBannedt() {
                    if ($("#filBannedt").val().length > 0) {
                        if ($("#filBannedt")[0].files[0].size < 2000000) {
                            var fd = new FormData();
                            console.log(fd);
                            return
                            fd.append('file', $("#filBannedt")[0].files[0]);
                            $.ajax({
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = ((evt.loaded / evt.total) * 100);
                                            $('.progress-bar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                                        }
                                    }, false);
                                    return xhr;
                                },
                                type: 'POST',
                                url: '../ajax/upload_img_banner_inferior.php',
                                data: fd,
                                contentType: false,
                                cache: false,
                                processData: false,
                                beforeSend: function() {
                                    console.log('inicio');
                                    $('.progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0);
                                },
                                error: function(err) {
                                    swal('Error al subir la imagen', "", "error")
                                    console.log(err);
                                },
                                success: function(resp) {
                                    console.log(resp);
                                    if (isJson(resp)) {
                                        resp = JSON.parse(resp);
                                        APP_BANN._data.nomProd = '';
                                        APP_BANN._data.dataE.imagen = resp.dstos;
                                        APP_BANN._data.listaBaner[APP_BANN._data.indice] = APP_BANN._data.dataE
                                        APP_BANN._data.dataE = {
                                            "imagen": "",
                                            "titulo": "",
                                            "titulo_peque": "",
                                            "parrafo": "",
                                            "enlazado": "",
                                            "prod": "",
                                            "pocision": 3,
                                            "estado": "1",
                                            "url": ""

                                        };
                                        $('#modal-edt-banner').modal('hide');
                                        $("#filBannedt").val('')
                                        APP_BANN.guardarDataBanner();
                                    } else {
                                        swal('Error al guardar la imagen', "", "error")
                                    }

                                }
                            });
                        } else {
                            swal('la imagen supera los 2MB', "", "warning")
                        }
                    } else {
                        $('#modal-edt-banner').modal('hide');
                        this.listaBaner[this.indice] = this.dataE
                        APP_BANN.guardarDataBanner();
                    }
                },
                guardarBann() {
                    if ($("#filBann").val().length > 0) {
                        if ($("#filBann")[0].files[0].size < 2000000) {
                            var fd = new FormData();
                            fd.append('file', $("#filBann")[0].files[0]);
                            $.ajax({
                                xhr: function() {
                                    var xhr = new window.XMLHttpRequest();
                                    xhr.upload.addEventListener("progress", function(evt) {
                                        if (evt.lengthComputable) {
                                            var percentComplete = ((evt.loaded / evt.total) * 100);
                                            $('.progress-bar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                                        }
                                    }, false);
                                    return xhr;
                                },
                                type: 'POST',
                                url: '../ajax/upload_img_banner_inferior.php',
                                data: fd,
                                contentType: false,
                                cache: false,
                                processData: false,
                                beforeSend: function() {
                                    console.log('inicio');
                                    $('.progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0);
                                },
                                error: function(err) {
                                    swal('Error al subir la imagen', "", "error")
                                    console.log(err);
                                },
                                success: function(resp) {
                                    console.log(resp);
                                    if (isJson(resp)) {
                                        resp = JSON.parse(resp);
                                        APP_BANN._data.nomProd = '';
                                        APP_BANN._data.dataR.imagen = resp.dstos;
                                        APP_BANN._data.listaBaner.push(APP_BANN._data.dataR)
                                        APP_BANN._data.dataR = {
                                            "imagen": "",
                                            "titulo": "",
                                            "titulo_peque": "",
                                            "parrafo": "",
                                            "enlazado": "",
                                            "prod": "",
                                            "pocision": 3,
                                            "estado": "1",
                                            "url": ""

                                        };
                                        $('#modal-new-banner').modal('hide');
                                        $("#filBann").val('')
                                        APP_BANN.guardarDataBanner();
                                    } else {
                                        swal('Error al guardar la imagen', "", "error")
                                    }

                                }
                            });
                        } else {
                            swal('la imagen supera los 2MB', "", "warning")
                        }

                    } else {
                        swal('Seleccione una imagen', "", "warning")
                    }
                },
                guardarDataBanner() {
                    const DataR = {
                        tipo: 'banner_inferior_IN',
                        data: JSON.stringify(this.listaBaner)
                    }
                    $.ajax({
                        type: "POST",
                        url: '../ajax/ajs_configuracione.php',
                        data: DataR,
                        success: function(resp) {
                            console.log(resp);
                        }
                    });
                },
                setDataInfoPRo(id, nom) {
                    this.dataR.prod = id + "";
                    this.nomProd = nom;

                },
                getBanerPrincipal() {
                    $.ajax({
                        type: "POST",
                        url: '../ajax/ajs_configuracione.php',
                        data: {
                            tipo: 'banner_inferior'
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp)
                            APP_BANN._data.listaBaner = resp
                            console.log(resp);
                        }
                    });

                }
            }
        });



        var table;
        $(document).ready(function() {
            APP_BANN.getBanerPrincipal();
            //APP_PROD.getInfoProduc()

            table = $('#example').DataTable({
                "order": [
                    [0, "desc"]
                ],
                language: {
                    url: '../utils/Spanish.json'
                }
            });

            $('#tabla-productos').DataTable({
                language: {
                    url: '../utils/Spanish.json'
                }
            });



        })

        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>

    </html>
<?php } else {
    header("Location: ../CYM/");
}
?>
