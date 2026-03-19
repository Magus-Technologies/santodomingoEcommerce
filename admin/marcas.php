<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
if (isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor') {

    require "../utils/Tools.php";
    require "../config.php";
    $tools = new Tools();
    $dataConf = $tools->getConfiguracion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Marcas — Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        .marca-img { max-width:90px; max-height:55px; object-fit:contain; }
        .sin-img   { width:90px; height:55px; background:#f0f0f0; display:inline-flex;
                     align-items:center; justify-content:center; font-size:11px;
                     color:#aaa; border-radius:4px; }
    </style>
</head>
<body>

<div class="preloader"><div class="lds-ellipsis"><span></span><span></span><span></span></div></div>

<?php include "../fragment/nav_bar_admin.php" ?>

<!-- Vue controla TODO desde aquí -->
<div id="app">

<div class="mt-4">
    <div class="custom-container">

        <div class="row mb-3">
            <div class="col-12 text-center">
                <h3>Lista de Marcas</h3>
            </div>
            <div class="col-12 text-center mt-2">
                <button data-toggle="modal" data-target="#modal-agregar" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Agregar
                </button>
            </div>
        </div>

        <table class="table table-bordered table-hover bg-white">
            <thead class="thead-dark">
                <tr>
                    <th>Marca</th>
                    <th class="text-center" style="width:130px">Logo</th>
                    <th class="text-center" style="width:140px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="loading">
                    <td colspan="3" class="text-center text-muted py-3">Cargando...</td>
                </tr>
                <tr v-for="(item, index) in lista" :key="item.marca_id">
                    <td class="align-middle">{{ item.nombre }}</td>
                    <td class="text-center align-middle">
                        <img v-if="item.imagen" class="marca-img"
                             :src="'../public/img/marcas/' + item.imagen" :alt="item.nombre">
                        <div v-else class="sin-img mx-auto">Sin logo</div>
                    </td>
                    <td class="text-center align-middle">
                        <button class="btn btn-outline-primary btn-sm"
                                v-on:click="abrirEditar(index)"
                                data-toggle="modal" data-target="#modal-editar">
                            <i class="fa fa-upload"></i> Cambiar logo
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>

<!-- ===== MODAL AGREGAR ===== -->
<div class="modal fade" id="modal-agregar" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Marca</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label>Seleccionar Marca</label>
                    <select class="form-control" id="selectMarca" v-model="selecMarca">
                        <option value="">— Seleccionar —</option>
                        <option v-for="m in marcasApi" :key="m.cod_marca"
                                :value="m.cod_marca">
                            {{ m.nombre_marca }}
                        </option>
                    </select>
                    <small v-if="cargandoMarcas" class="text-muted">Cargando marcas...</small>
                    <small v-if="errorMarcas" class="text-danger">{{ errorMarcas }}</small>
                </div>

                <div class="form-group text-center">
                    <button type="button" onclick="$('#fileNuevo').click()" class="btn btn-success btn-sm">
                        <i class="fa fa-image"></i> Seleccionar Logo
                    </button>
                    <input type="file" id="fileNuevo" accept="image/*" style="display:none">
                </div>

                <div class="form-group text-center">
                    <small class="text-muted">Tamaño recomendado: 163 × 85 px</small><br>
                    <img id="previewNuevo" src="../public/img/marcas/sin_imagen.png"
                         style="max-width:163px; max-height:85px; object-fit:contain; margin-top:8px">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" v-on:click="guardar()"
                        :disabled="!selecMarca || guardando"
                        class="btn btn-primary">
                    <span v-if="guardando"><i class="fa fa-spinner fa-spin"></i> Guardando...</span>
                    <span v-else>Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL CAMBIAR LOGO ===== -->
<div class="modal fade" id="modal-editar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar logo — {{ marcaEditar ? marcaEditar.nombre : '' }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <input type="file" id="fileEditar" accept="image/*" style="display:none">
            <div class="modal-body text-center">
                <button type="button" onclick="$('#fileEditar').click()" class="btn btn-success btn-sm mb-3">
                    <i class="fa fa-image"></i> Seleccionar imagen
                </button>
                <p class="text-muted" style="font-size:11px">Recomendado: 163 × 85 px</p>
                <img id="previewEditar" src="../public/img/marcas/sin_imagen.png"
                     style="max-width:150px; max-height:90px; object-fit:contain; display:block; margin:auto">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                <button type="button" v-on:click="guardarEditar()"
                        :disabled="!archivoEditar || guardandoEditar"
                        class="btn btn-primary btn-sm">
                    <span v-if="guardandoEditar"><i class="fa fa-spinner fa-spin"></i> Guardando...</span>
                    <span v-else>Guardar</span>
                </button>
            </div>
        </div>
    </div>
</div>

</div><!-- fin #app -->

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script>$(".preloader").hide()</script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script>
const APP = new Vue({
    el: '#app',
    data: {
        lista: [],
        loading: true,
        marcasApi: [],
        cargandoMarcas: false,
        errorMarcas: '',
        selecMarca: '',
        archivoNuevo: null,
        guardando: false,
        marcaEditar: null,
        archivoEditar: null,
        guardandoEditar: false,
    },
    methods: {
        // Carga marcas del ecommerce (compuvision)
        getData() {
            this.loading = true;
            $.ajax({
                type: 'POST', url: '../ajax/ajs_marcas.php',
                data: { tipo: 'all' },
                success: function(resp) {
                    APP._data.lista    = JSON.parse(resp);
                    APP._data.loading  = false;
                }
            });
        },

        // Carga nombres desde la BD de facturación (mismo servidor MySQL)
        cargarMarcasApi() {
            this.cargandoMarcas = true;
            this.errorMarcas    = '';
            $.ajax({
                type: 'POST',
                url: '../ajax/ajs_marcas.php',
                data: { tipo: 'marcas_facturacion' },
                success: function(resp) {
                    APP._data.marcasApi      = JSON.parse(resp);
                    APP._data.cargandoMarcas = false;
                },
                error: function() {
                    APP._data.errorMarcas    = 'No se pudieron cargar las marcas.';
                    APP._data.cargandoMarcas = false;
                }
            });
        },

        guardar() {
            if (!this.selecMarca) return;
            const marca  = this.marcasApi.find(m => m.cod_marca == this.selecMarca);
            const nombre = marca ? marca.nombre_marca : this.selecMarca;
            this.guardando = true;

            const subir = (callback) => {
                if (!this.archivoNuevo) { callback(''); return; }
                var fd = new FormData();
                fd.append('file', this.archivoNuevo);
                $.ajax({
                    type: 'POST', url: '../ajax/upload_img_mar.php',
                    data: fd, contentType: false, cache: false, processData: false,
                    success: function(r) { callback(JSON.parse(r).dstos); }
                });
            };

            subir((imagen) => {
                $.ajax({
                    type: 'POST', url: '../ajax/ajs_marcas.php',
                    data: { tipo: 'in', cod: this.selecMarca, nom: nombre, imagen: imagen },
                    success: () => {
                        this.guardando    = false;
                        this.selecMarca   = '';
                        this.archivoNuevo = null;
                        $('#fileNuevo').val('');
                        $('#previewNuevo').attr('src', '../public/img/marcas/sin_imagen.png');
                        $('#modal-agregar').modal('hide');
                        this.getData();
                    }
                });
            });
        },

        abrirEditar(index) {
            this.marcaEditar  = this.lista[index];
            this.archivoEditar = null;
            $('#fileEditar').val('');
            const src = this.marcaEditar.imagen
                ? '../public/img/marcas/' + this.marcaEditar.imagen
                : '../public/img/marcas/sin_imagen.png';
            $('#previewEditar').attr('src', src);
        },

        guardarEditar() {
            if (!this.archivoEditar) return;
            const marca = this.marcaEditar;
            this.guardandoEditar = true;
            var fd = new FormData();
            fd.append('file', this.archivoEditar);
            $.ajax({
                type: 'POST', url: '../ajax/upload_img_mar.php',
                data: fd, contentType: false, cache: false, processData: false,
                success: function(r) {
                    r = JSON.parse(r);
                    $.ajax({
                        type: 'POST', url: '../ajax/ajs_marcas.php',
                        data: { tipo: 'up', marc: marca.marca_id, imagen: r.dstos },
                        success: function() {
                            APP._data.guardandoEditar = false;
                            $('#modal-editar').modal('hide');
                            APP.getData();
                        }
                    });
                }
            });
        }
    }
});

$(document).ready(function() {
    APP.getData();
    APP.cargarMarcasApi();

    $('#fileNuevo').change(function() {
        if (this.files && this.files[0]) {
            APP._data.archivoNuevo = this.files[0];
            var reader = new FileReader();
            reader.onload = e => $('#previewNuevo').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#fileEditar').change(function() {
        if (this.files && this.files[0]) {
            APP._data.archivoEditar = this.files[0];
            var reader = new FileReader();
            reader.onload = e => $('#previewEditar').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#modal-agregar').on('hidden.bs.modal', function() {
        APP._data.selecMarca   = '';
        APP._data.archivoNuevo = null;
        $('#fileNuevo').val('');
        $('#previewNuevo').attr('src', '../public/img/marcas/sin_imagen.png');
    });
});
</script>
</body>
</html>
<?php } else {
    header("Location: ../CYM/");
} ?>
