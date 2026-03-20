<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if (!(isset($_SESSION['usuario']) && ($validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'))) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VIÑASANTODOMINGO</title>
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
    <link rel="stylesheet" href="../public/assets/css/animate.css">
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="../public/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/css/linearicons.css">
    <link rel="stylesheet" href="../public/assets/css/flaticon.css">
    <link rel="stylesheet" href="../public/assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../public/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../public/assets/css/slick.css">
    <link rel="stylesheet" href="../public/assets/css/slick-theme.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <style>
        .badge-active   { background:#28a745; color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; }
        .badge-inactive { background:#6c757d; color:#fff; padding:4px 10px; border-radius:20px; font-size:12px; }
        .drag-handle { cursor:grab; color:#aaa; }
        .drag-handle:active { cursor:grabbing; }
        tr.sortable-ghost { opacity:.4; background:#ece6a3; }
        .page-title { border-left:4px solid #c7161d; padding-left:12px; margin-bottom:24px; }
        .btn-rojo { background:#c7161d; border-color:#c7161d; color:#fff; }
        .btn-rojo:hover { background:#a01018; border-color:#a01018; color:#fff; }
    </style>
</head>

<body>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span><span></span><span></span>
    </div>
</div>
<!-- END LOADER -->

<!-- START HEADER -->
<?php include "../fragment/nav_bar_admin.php" ?>
<!-- END HEADER -->

<div id="app" class="custom-container" style="margin-top:100px; padding:20px;">

    <h4 class="page-title"><i class="fas fa-bars mr-2"></i>Menú de Navegación</h4>

    <!-- CATEGORÍAS DE FACTURA — referencia para construir URLs del menú -->
    <div class="card mb-4" style="border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,.08); border:none;">
        <div class="card-header bg-white py-3" style="border-bottom:2px solid #6c757d; border-radius:10px 10px 0 0;">
            <span class="font-weight-bold"><i class="fas fa-list mr-2 text-secondary"></i>Categorías del Sistema de Facturación</span>
            <small class="text-muted ml-2">— Usa el ID para construir la URL del menú: <code>shop-list-ctg.php?ctg=<strong>{id}</strong></code></small>
        </div>
        <div class="card-body p-0">
            <div v-if="loadingCats" class="text-center py-3"><i class="fas fa-spinner fa-spin text-secondary"></i></div>
            <table v-else class="table table-sm table-hover mb-0">
                <thead><tr><th style="width:80px">ID</th><th>Nombre Categoría</th><th>URL para el menú</th><th style="width:110px"></th></tr></thead>
                <tbody>
                    <tr v-for="cat in categorias" :key="cat.id">
                        <td class="align-middle"><span class="badge badge-secondary">{{ cat.id }}</span></td>
                        <td class="align-middle font-weight-bold">{{ cat.nombre }}</td>
                        <td class="align-middle text-muted" style="font-size:13px;">shop-list-ctg.php?ctg={{ cat.id }}</td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn-outline-secondary" title="Copiar URL"
                                @click="copiarUrl('shop-list-ctg.php?ctg=' + cat.id)">
                                <i class="fas fa-copy mr-1"></i>Copiar URL
                            </button>
                        </td>
                    </tr>
                    <tr v-if="categorias.length === 0">
                        <td colspan="4" class="text-center text-muted py-3">No se pudo cargar las categorías. Verifica que Laravel esté corriendo.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,.08); border:none;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3"
             style="border-bottom:2px solid #c7161d; border-radius:10px 10px 0 0;">
            <span class="font-weight-bold">Ítems del menú</span>
            <button class="btn btn-rojo btn-sm" @click="abrirNuevo">
                <i class="fas fa-plus mr-1"></i> Agregar ítem
            </button>
        </div>
        <div class="card-body p-0">
            <div v-if="cargando" class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>
            <table v-else class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;"></th>
                        <th>Título</th>
                        <th>URL</th>
                        <th>Estado</th>
                        <th style="width:160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="sortable-body">
                    <tr v-for="(item, idx) in items" :key="idx">
                        <td class="drag-handle text-center align-middle">
                            <i class="fas fa-grip-vertical"></i>
                        </td>
                        <td class="align-middle font-weight-bold">{{ item.titulo }}</td>
                        <td class="align-middle text-muted" style="font-size:13px;">{{ item.url }}</td>
                        <td class="align-middle">
                            <span :class="item.estado === '1' ? 'badge-active' : 'badge-inactive'">
                                {{ item.estado === '1' ? 'Activo' : 'Oculto' }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <button class="btn btn-sm btn-outline-primary mr-1" title="Editar" @click="abrirEditar(idx)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm mr-1"
                                :class="item.estado === '1' ? 'btn-outline-secondary' : 'btn-outline-success'"
                                :title="item.estado === '1' ? 'Ocultar del menú' : 'Mostrar en menú'"
                                @click="toggleEstado(idx)">
                                <i :class="item.estado === '1' ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar" @click="eliminar(idx)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="items.length === 0">
                        <td colspan="5" class="text-center text-muted py-4">No hay ítems en el menú.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-muted" style="font-size:12px; border-radius:0 0 10px 10px;">
            <i class="fas fa-info-circle mr-1"></i>
            Arrastra las filas para reordenar. Los cambios se guardan automáticamente.
        </div>
    </div>

    <!-- Modal agregar/editar -->
    <div class="modal fade" id="modal-item" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#c7161d; color:#fff;">
                    <h5 class="modal-title">{{ modoEditar ? 'Editar ítem' : 'Agregar ítem al menú' }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="form.titulo"
                               placeholder="Ej: VINO TINTO">
                        <small class="text-muted">Se mostrará en mayúsculas en el menú.</small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="form.url"
                               placeholder="Ej: shop-list-ctg.php?ctg=001">
                        <small class="text-muted">Ruta relativa desde la carpeta CYM/</small>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Estado</label>
                        <select class="form-control" v-model="form.estado">
                            <option value="1">Activo (visible en menú)</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-rojo" @click="guardarItem" :disabled="guardando">
                        {{ guardando ? 'Guardando...' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</div><!-- /#app -->

<!-- START FOOTER -->
<footer class="footer_dark">
    <div class="footer_top">
        <div class="container">
            <div class="row"></div>
        </div>
    </div>
    <div class="bottom_footer border-top-tran">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-md-0 text-center text-md-left">© 2024 Todos los derechos reservados por
                        <a target="_blank" href="https://magustechnologies.com/"><strong>MAGUS TECHNOLOGIES</strong></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display:none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Scripts (mismo orden que confBaner.php) -->
<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../public/assets/owlcarousel/js/owl.carousel.min.js"></script>
<script src="../public/assets/js/magnific-popup.min.js"></script>
<script src="../public/assets/js/waypoints.min.js"></script>
<script src="../public/assets/js/parallax.js"></script>
<script src="../public/assets/js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>

<script>
new Vue({
    el: '#app',
    data: {
        items: [],
        cargando: true,
        guardando: false,
        modoEditar: false,
        editIdx: -1,
        form: { titulo: '', url: '', estado: '1' },
        categorias: [],
        loadingCats: true
    },
    mounted: function() {
        this.cargarMenu();
        this.cargarCategorias();
    },
    methods: {
        cargarMenu: function() {
            var self = this;
            self.cargando = true;
            $.post('../ajax/ajs_configuracione.php', { tipo: 'menu_nav_s' }, function(res) {
                self.items = res || [];
                self.cargando = false;
                self.$nextTick(function() { self.initSortable(); });
            }, 'json').fail(function() {
                self.items = [];
                self.cargando = false;
            });
        },
        initSortable: function() {
            var el = document.getElementById('sortable-body');
            if (!el) return;
            var self = this;
            Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    var moved = self.items.splice(evt.oldIndex, 1)[0];
                    self.items.splice(evt.newIndex, 0, moved);
                    self.guardarTodo();
                }
            });
        },
        abrirNuevo: function() {
            this.modoEditar = false;
            this.editIdx = -1;
            this.form = { titulo: '', url: '', estado: '1' };
            $('#modal-item').modal('show');
        },
        abrirEditar: function(idx) {
            this.modoEditar = true;
            this.editIdx = idx;
            this.form = Object.assign({}, this.items[idx]);
            $('#modal-item').modal('show');
        },
        guardarItem: function() {
            if (!this.form.titulo.trim() || !this.form.url.trim()) {
                alert('El título y la URL son obligatorios.');
                return;
            }
            var item = {
                titulo: this.form.titulo.trim().toUpperCase(),
                url: this.form.url.trim(),
                estado: this.form.estado
            };
            if (this.modoEditar) {
                this.$set(this.items, this.editIdx, item);
            } else {
                this.items.push(item);
            }
            $('#modal-item').modal('hide');
            this.guardarTodo();
        },
        toggleEstado: function(idx) {
            this.items[idx].estado = this.items[idx].estado === '1' ? '0' : '1';
            this.$forceUpdate();
            this.guardarTodo();
        },
        eliminar: function(idx) {
            if (!confirm('¿Eliminar "' + this.items[idx].titulo + '" del menú?')) return;
            this.items.splice(idx, 1);
            this.guardarTodo();
        },
        cargarCategorias: function() {
            var self = this;
            $.post('../ajax/ajs_shop_factura.php', { tipo: 'categorias' }, function(res) {
                self.loadingCats = false;
                if (res && res.success && res.data) {
                    self.categorias = res.data;
                }
            }, 'json').fail(function() { self.loadingCats = false; });
        },
        copiarUrl: function(url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('URL copiada: ' + url);
            }).catch(function() {
                prompt('Copia esta URL:', url);
            });
        },
        guardarTodo: function() {
            var self = this;
            self.guardando = true;
            $.post('../ajax/ajs_configuracione.php', {
                tipo: 'menu_nav_IN',
                data: JSON.stringify(self.items)
            }, function(res) {
                self.guardando = false;
                if (!res.res) alert('Error al guardar el menú.');
            }, 'json').fail(function() {
                self.guardando = false;
                alert('Error de conexión al guardar.');
            });
        }
    }
});
</script>
</body>
</html>
