<?php
session_start();
require "../utils/Tools.php";

$tools = new Tools();

$dataConf = $tools->getConfiguracion();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shopwise is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
    <meta name="keywords" content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">

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
    <style>
        .boxCat {
            border: 1px solid #313131;
            border-radius: 10px;
            background-color: white;
            margin: 10px;
        }

        .boxCat:hover {
            -webkit-box-shadow: -1px -2px 11px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: -1px -2px 11px 0px rgba(0, 0, 0, 0.75);
            box-shadow: -1px -2px 11px 0px rgba(0, 0, 0, 0.75);

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
    <div class="mt-4 staggered-animation-wrap" id="contenedor-primario">
        <div class="custom-container">
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-12 text-center">
                    <h3>Lista de categorias</h3>
                </div>
                <div class="col-md-12 text-center">
                    <button onclick="reserImg()" data-toggle="modal" data-target="#modal-register" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in listaCategorias" :key="item.id_seleccion">
                            <td class="align-middle text-center">{{index + 1}}</td>
                            <td class="align-middle text-center">
                                <img :src="'../public/img/banner/'+item.imagen" style="width:70px;height:70px;object-fit:cover;border-radius:6px;">
                            </td>
                            <td class="align-middle"><strong>{{item.nombre}}</strong></td>
                            <td class="align-middle text-center"><code>{{item.codi_categoria}}</code></td>
                            <td class="align-middle text-center">
                                <span :class="item.estado=='1' ? 'badge badge-success' : 'badge badge-secondary'">
                                    {{item.estado=='1' ? 'Activo' : 'Inactivo'}}
                                </span>
                            </td>
                            <td class="align-middle text-center" style="white-space:nowrap;">
                                <button v-on:click="selecCatFrom(index)" data-toggle="modal" data-target="#modal-actualizar" class="btn btn-primary btn-sm" title="Editar"><i class="fa fa-edit"></i></button>
                                <button v-on:click="toggleEstado(item)" class="btn btn-sm" :class="item.estado=='1' ? 'btn-warning' : 'btn-success'" :title="item.estado=='1' ? 'Desactivar' : 'Activar'">
                                    <i :class="item.estado=='1' ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                </button>
                                <button v-on:click="eliminarCategoria(item)" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr v-if="listaCategorias.length === 0">
                            <td colspan="6" class="text-center text-muted">No hay categorías registradas</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input accept="image/*" type="file" id="fileFee" style="display: none">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Categorias sin agregar:</label>
                            <select v-model="selcCC" @change="onChange($event)" id="selecCatego" class="form-control">
                                <option v-for="item in getListaAdd" :value="item.cod_sub1">{{item.nom_sub1}}</option>
                            </select>

                            <!--button data-toggle="modal" data-target="#modal-icon"  class="btn btn-info"> Selecionar Icono</button-->

                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nombre en Web:</label>
                            <input class="form-control" v-model="nombreCa">

                            <!--button data-toggle="modal" data-target="#modal-icon"  class="btn btn-info"> Selecionar Icono</button-->

                        </div>
                        <div class="form-group text-center">
                            <button onclick="$('#fileFee').click()" class="btn btn-success">Seleccionar Banner</button>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Banner: tamaño recomendable 300 X 310 Pixeles</label>
                            <div class="col-md-12">
                                <img id="imagenPreview" class="prevvvv" style="margin: auto;display: block" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button v-on:click="guardarCategoria()" type="button" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-actualizar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input accept="image/*" type="file" id="fileFee2" style="display: none">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="col-form-label">Categoria:</label>
                            <input disabled v-model="selecCod" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Nombre en Web:</label>
                            <input v-model="editNombre" class="form-control" placeholder="Nombre visible en la tienda">
                        </div>
                        <div class="form-group text-center">
                            <button onclick="$('#fileFee2').click()" class="btn btn-success">Seleccionar Banner</button>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Banner: tamaño recomendable 300 X 310 Pixeles</label>
                            <div class="col-md-12">
                                <img id="imagenPreview2" class="prevvvv" style="margin: auto;display: block" src="../public/img/banner/sinimagen_menu_20sba.jpg">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button v-on:click="actualizarImagen()" type="button" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal-icon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ICONOS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    Seleccione un icono
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn btn-light"><i class="fa fa-microchip"></i></button>
                                <button class="btn btn-light"><i class="fa fa-desktop"></i></button>
                                <button class="btn btn-light"><i class="fa fa-ethernet"></i></button>
                                <button class="btn btn-light"><i class="fa fa-keyboard"></i></button>
                                <button class="btn btn-light"><i class="fa fa-headphones"></i></button>
                                <button class="btn btn-light"><i class="fa fa-hdd"></i></button>
                                <button class="btn btn-light"><i class="fa fa-laptop"></i></button>
                                <button class="btn btn-light"><i class="fa fa-memory"></i></button>
                                <button class="btn btn-light"><i class="fa fa-mobile"></i></button>
                                <button class="btn btn-light"><i class="fa fa-mouse-pointer"></i></button>
                                <button class="btn btn-light"><i class="fa fa-print"></i></button>
                                <button class="btn btn-light"><i class="fa fa-tablet"></i></button>
                                <button class="btn btn-light"><i class="fa fa-tv"></i></button>
                                <button class="btn btn-light"><i class="fa fa-table"></i></button>
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
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content" style="margin-top: 40px">



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
                        <p class="mb-md-0 text-center text-md-left">© 2024 Todos los derechos reservados por <a target="_blank" href="https://magustechnologies.com/">
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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

</body>

<script>
    function reserImg() {
        $(".prevvvv").attr("img", '../public/img/banner/sinimagen_menu_20sba.jpg');
    }
    const APP = new Vue({
        el: "#contenedor-primario",
        data: {
            listaCategorias: [],
            listaOnliCate: [],
            selecCod: '',
            idCatego: '',
            nombreCa: '',
            selcCC: '',
            editNombre: ''
        },
        methods: {
            onChange(event) {
                console.log(event.target.value)
                this.nombreCa = $("#selecCatego option:selected").text()
            },
            selecCatFrom(index) {
                const item = this.listaCategorias[index];
                this.selecCod = item.nombre;
                this.editNombre = item.nombre;
                this.idCatego = item.id_seleccion;
                $("#imagenPreview2").attr("src", '../public/img/banner/' + item.imagen);
            },
            actualizarImagen() {
                if ($("#fileFee2").val().length > 0) {
                    var fd = new FormData();
                    fd.append('file', $("#fileFee2")[0].files[0]);
                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    //var percentComplete = ((evt.loaded / evt.total) * 100);
                                    //APP._data.progreso=percentComplete;
                                }
                            }, false);
                            return xhr;
                        },
                        type: 'POST',
                        url: '../ajax/upload_img_cat.php',
                        data: fd,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            console.log('inicio');
                        },
                        error: function(err) {
                            console.log(err);
                        },
                        success: function(resp) {
                            resp = JSON.parse(resp);
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_categoria.php",
                                data: {
                                    tipo: 'up',
                                    cate: APP._data.idCatego,
                                    imagen: resp.dstos,
                                    nombre: APP._data.editNombre
                                },
                                success: function() {
                                    $('#modal-actualizar').modal('hide');
                                    $("#fileFee2").val("");
                                    $("#imagenPreview2").attr("src", '../public/img/banner/sinimagen_menu_20sba.jpg');
                                    APP.getData();
                                }
                            });
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_categoria.php",
                        data: {
                            tipo: 'up',
                            cate: APP._data.idCatego,
                            imagen: APP._data.listaCategorias.find(c => c.id_seleccion == APP._data.idCatego)?.imagen || '',
                            nombre: APP._data.editNombre
                        },
                        success: function() {
                            $('#modal-actualizar').modal('hide');
                            APP.getData();
                        }
                    });
                }
            },
            guardarCategoria() {
                const codCat = $("#selecCatego").val();
                const nombre = this.nombreCa;
                if ($("#fileFee").val().length > 0) {

                    var fd = new FormData();
                    fd.append('file', $("#fileFee")[0].files[0]);
                    console.log(fd);
                    /*  return */
                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    //var percentComplete = ((evt.loaded / evt.total) * 100);
                                    //APP._data.progreso=percentComplete;
                                }
                            }, false);
                            return xhr;
                        },
                        type: 'POST',
                        url: '../ajax/upload_img_cat.php',
                        data: fd,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            console.log('inicio');
                        },
                        error: function(err) {
                            console.log(err);
                        },
                        success: function(resp) {
                            /*  console.log(resp); */
                            resp = JSON.parse(resp);
                            console.log(resp);
                            /* return false */
                            
                            $.ajax({
                                type: "POST",
                                url: "../ajax/ajs_categoria.php",
                                data: {
                                    tipo: 'in',
                                    cod: codCat,
                                    nom: nombre,
                                    imagen: resp.dstos
                                },
                                success: function(ressss) {
                                    console.log(ressss)
                                    $('#modal-register').modal('hide');
                                    $("#fileFee").val("")
                                    $("#imagenPreview").attr("src", `../public/img/banner/sinimagen_menu_20sba.jpg`)
                                    APP.getData();
                                }
                            });


                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "../ajax/ajs_categoria.php",
                        data: {
                            tipo: 'in',
                            cod: codCat,
                            nom: nombre,
                            imagen: ''
                        },
                        success: function(ressss) {
                            console.log(ressss)
                            $('#modal-register').modal('hide');
                            $("#fileFee").val("")
                            $("#imagenPreview").attr("src", '../public/img/banner/sinimagen_menu_20sba.jpg')
                            APP.getData();
                        }
                    });

                }
            },
            toggleEstado(item) {
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_categoria.php",
                    data: { tipo: 'toggle_estado', id: item.id_seleccion },
                    success: function() {
                        APP.getData();
                    }
                });
            },
            eliminarCategoria(item) {
                if (!confirm('¿Eliminar la categoría "' + item.nombre + '"?')) return;
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_categoria.php",
                    data: { tipo: 'del', id: item.id_seleccion },
                    success: function() {
                        APP.getData();
                    }
                });
            },
            getData() {

                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_categoria.php",
                    data: {
                        tipo: 's'
                    },
                    success: function(resp) {
                        /*  console.log(resp) */
                        APP._data.listaCategorias = JSON.parse(resp);
                    }
                });

            },
            getCategoliasList() {
                $.ajax({
                    type: "POST",
                    url: "../ajax/ajs_categoria.php",
                    data: {
                        tipo: 'lis'
                    },
                    success: function(resp) {
                        /* console.log(resp) */
                        APP._data.listaOnliCate = JSON.parse(resp);
                    }
                });
            }
        },
        computed: {
            getListaAdd() {
                this.selcCC = '';
                var lista = [];
                for (var i = 0; i < this.listaOnliCate.length; i++) {
                    const ttt = this.listaCategorias.find(item => item.codi_categoria == this.listaOnliCate[i].cod_sub1);
                    if (typeof ttt === 'undefined') {
                        lista.push(this.listaOnliCate[i])
                    }

                }
                return lista;
            }
        }
    })

    function seImgFil(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagenPreview').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
    }

    function seImgFil2(fil) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagenPreview2').attr('src', e.target.result);
        };
        //console.log(fil)
        reader.readAsDataURL(fil);
        /* console.log('entra a setimg'); */
    }
    $(document).ready(function() {
        APP.getData();
        APP.getCategoliasList();

        $("#fileFee").change(function() {
            if (this.files && this.files[0]) {
                seImgFil(this.files[0])
            }
           /*  console.log('asd'); */
          /*   $('#imagenPreview').attr('src',this.files[0].name)
            console.log(this.files[0]); */
        });
        $("#fileFee2").change(function() {
            if (this.files && this.files[0]) {
                seImgFil2(this.files[0])

            }
        });
    });
</script>

</html>
