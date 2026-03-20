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
        .pagina-row:hover { background:#f0f4ff; }
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
            <div class="px-3 pt-2 pb-1">
                <input v-model="buscarCat" type="text" class="form-control form-control-sm"
                    placeholder="Buscar categoría..." style="max-width:300px;">
            </div>
            <div v-if="loadingCats" class="text-center py-3"><i class="fas fa-spinner fa-spin text-secondary"></i></div>
            <div v-else style="max-height:200px; overflow-y:auto;">
            <table class="table table-sm table-hover mb-0">
                <thead><tr><th style="width:80px">ID</th><th>Nombre Categoría</th><th>URL para el menú</th><th style="width:110px"></th></tr></thead>
                <tbody>
                    <tr v-for="cat in categoriasFiltradas" :key="cat.id">
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
                    <tr v-if="categoriasFiltradas.length === 0">
                        <td colspan="4" class="text-center text-muted py-3">No se encontraron categorías.</td>
                    </tr>
                </tbody>
            </table>
            </div>
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
                        <td class="align-middle font-weight-bold">
                            {{ item.titulo }}
                            <span v-if="item.hijos && item.hijos.length" class="badge badge-info ml-1" style="font-size:10px;">
                                <i class="fas fa-caret-down"></i> {{ item.hijos.length }} sub-items
                            </span>
                        </td>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background:#c7161d; color:#fff;">
                    <h5 class="modal-title">{{ modoEditar ? 'Editar ítem' : 'Agregar ítem al menú' }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" v-model="form.titulo" placeholder="Ej: VINO TINTO">
                                <small class="text-muted">Se mostrará en mayúsculas en el menú.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">URL</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" v-model="form.url"
                                        :placeholder="(form.hijos && form.hijos.length) ? 'Usa # si tiene sub-items' : 'Ej: shop-list-ctg.php?ctg=001'">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" @click="abrirSelectorPagina('principal')" title="Seleccionar página">
                                            <i class="fas fa-folder-open"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted">Ruta relativa desde CYM/ (usa <code>#</code> si tiene sub-items)</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Estado</label>
                        <select class="form-control" v-model="form.estado">
                            <option value="1">Activo (visible en menú)</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>

                    <!-- SUB-ITEMS -->
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="font-weight-bold mb-0"><i class="fas fa-caret-down mr-1 text-info"></i>Sub-items (dropdown)</label>
                        <button type="button" class="btn btn-sm btn-outline-info" @click="agregarHijo">
                            <i class="fas fa-plus mr-1"></i> Agregar sub-item
                        </button>
                    </div>
                    <div v-if="!form.hijos || form.hijos.length === 0" class="text-muted text-center py-2" style="font-size:13px; background:#f9f9f9; border-radius:6px;">
                        Sin sub-items — aparecerá como enlace directo
                    </div>
                    <div v-for="(hijo, hi) in form.hijos" :key="hi" class="d-flex align-items-center mb-2" style="gap:6px;">
                        <input type="text" class="form-control form-control-sm" v-model="hijo.titulo" placeholder="Título" style="flex:1;">
                        <div class="input-group input-group-sm" style="flex:2;">
                            <input type="text" class="form-control form-control-sm" v-model="hijo.url" placeholder="URL">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="abrirSelectorPagina('hijo', hi)" title="Seleccionar página">
                                    <i class="fas fa-folder-open"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="quitarHijo(hi)" title="Eliminar">
                            <i class="fas fa-times"></i>
                        </button>
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

    <!-- Modal selector de páginas -->
    <div class="modal fade" id="modal-paginas" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#343a40; color:#fff;">
                    <h5 class="modal-title"><i class="fas fa-folder-open mr-2"></i>Seleccionar página</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-3 border-bottom">
                        <input type="text" class="form-control" v-model="buscarPagina" placeholder="Buscar página...">
                    </div>
                    <div style="max-height:400px; overflow-y:auto;">
                        <div v-for="grupo in paginasFiltradas" :key="grupo.grupo">
                            <div class="px-3 py-2" style="background:#f8f9fa; font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:1px; border-bottom:1px solid #e9ecef;">
                                {{ grupo.grupo }}
                            </div>
                            <div v-for="pag in grupo.items" :key="pag.url"
                                 class="d-flex align-items-center px-3 py-2 pagina-row"
                                 style="cursor:pointer; border-bottom:1px solid #f0f0f0;"
                                 @click="seleccionarPagina(pag)">
                                <i class="fas fa-file-code mr-3 text-secondary" style="font-size:18px;"></i>
                                <div>
                                    <div class="font-weight-bold" style="font-size:14px;">{{ pag.label }}</div>
                                    <div class="text-muted" style="font-size:11px;">{{ pag.url }}</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="paginasFiltradas.length === 0" class="text-center text-muted py-4">
                            No se encontraron páginas
                        </div>
                    </div>
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
        form: { titulo: '', url: '', estado: '1', hijos: [] },
        categorias: [],
        loadingCats: true,
        buscarCat: '',
        buscarPagina: '',
        selectorTarget: 'principal', // 'principal' o índice de hijo
        selectorHijoIdx: -1,
        paginas: [
            { grupo: 'Tienda', items: [
                { label: 'Todos los productos', url: 'shop-list-prod.php' },
                { label: 'Productos por categoría', url: 'shop-list-ctg.php?ctg=' },
                { label: 'Productos por marca', url: 'shop-list-prod-mac.php?marc=' },
                { label: 'Ofertas', url: 'shop-list-prod-ofertas.php' },
                { label: 'Productos en remate', url: 'shop-list-prod-remate.php' },
                { label: 'Productos exclusivos', url: 'shop-list-prod-exclu.php' },
                { label: 'Precios VIP', url: 'shop-list-vip.php?search=+&type=last+&v=vp' },
                { label: 'Precios distribución', url: 'shop-list-distri.php?search=+&type=last+&v=dt' },
                { label: 'Marcas', url: 'marcas.php' },
                { label: 'Detalle de producto', url: 'shop-product-detail.php' },
            ]},
            { grupo: 'Carrito y pedidos', items: [
                { label: 'Carrito', url: 'shop-cart.php' },
                { label: 'Checkout / Pagar', url: 'checkout.php' },
                { label: 'Mis pedidos', url: 'lista_pedidos_cliente.php' },
                { label: 'Mis compras', url: 'lista_compras_cliente.php' },
                { label: 'Pedido completado', url: 'order-completed.php' },
            ]},
            { grupo: 'Información', items: [
                { label: 'Inicio', url: 'index.php' },
                { label: 'Nosotros / About', url: 'about.php' },
                { label: 'Contacto', url: 'contact.php' },
                { label: 'Delivery / Envíos', url: 'delivery.php' },
                { label: 'Métodos de pago (Bancos)', url: 'banks.php' },
                { label: 'Delivery a Cañete / Oficina', url: 'office.php' },
                { label: 'Términos y condiciones', url: 'term.php' },
                { label: 'Banners promocionales', url: 'banners-promocionales.php' },
            ]},
            { grupo: 'Cuenta', items: [
                { label: 'Mi cuenta', url: 'my-account.php' },
                { label: 'Iniciar sesión', url: 'login.php' },
                { label: 'Registro', url: 'signup.php' },
            ]},
            { grupo: 'Especiales', items: [
                { label: 'Arma tu PC', url: 'arma-tu-pc.php' },
                { label: 'Comparar productos', url: 'shop-compare.php' },
                { label: 'Enlace externo / sin destino', url: '#' },
            ]}
        ]
    },
    computed: {
        paginasFiltradas: function() {
            var q = this.buscarPagina.toLowerCase().trim();
            if (!q) return this.paginas;
            return this.paginas.map(function(grupo) {
                return {
                    grupo: grupo.grupo,
                    items: grupo.items.filter(function(p) {
                        return p.label.toLowerCase().indexOf(q) !== -1 || p.url.toLowerCase().indexOf(q) !== -1;
                    })
                };
            }).filter(function(g) { return g.items.length > 0; });
        },
        categoriasFiltradas: function() {
            var q = this.buscarCat.toLowerCase().trim();
            if (!q) return this.categorias;
            return this.categorias.filter(function(c) {
                return c.nombre.toLowerCase().indexOf(q) !== -1 || String(c.id).indexOf(q) !== -1;
            });
        }
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
            this.form = { titulo: '', url: '#', estado: '1', hijos: [] };
            $('#modal-item').modal('show');
        },
        abrirEditar: function(idx) {
            this.modoEditar = true;
            this.editIdx = idx;
            var item = this.items[idx];
            this.form = {
                titulo: item.titulo || '',
                url: item.url || '#',
                estado: item.estado || '1',
                hijos: JSON.parse(JSON.stringify(item.hijos || []))
            };
            $('#modal-item').modal('show');
        },
        abrirSelectorPagina: function(target, hijoIdx) {
            this.selectorTarget = target;
            this.selectorHijoIdx = hijoIdx !== undefined ? hijoIdx : -1;
            this.buscarPagina = '';
            $('#modal-paginas').modal('show');
        },
        seleccionarPagina: function(pag) {
            if (this.selectorTarget === 'principal') {
                this.form.url = pag.url;
            } else {
                this.form.hijos[this.selectorHijoIdx].url = pag.url;
            }
            $('#modal-paginas').modal('hide');
        },
        agregarHijo: function() {
            if (!this.form.hijos) this.$set(this.form, 'hijos', []);
            this.form.hijos.push({ titulo: '', url: '' });
        },
        quitarHijo: function(hi) {
            this.form.hijos.splice(hi, 1);
        },
        guardarItem: function() {
            if (!this.form.titulo.trim()) {
                alert('El título es obligatorio.');
                return;
            }
            var hijos = (this.form.hijos || []).filter(function(h) {
                return h.titulo.trim() && h.url.trim();
            }).map(function(h) {
                return { titulo: h.titulo.trim().toUpperCase(), url: h.url.trim() };
            });
            var url = this.form.url.trim() || (hijos.length ? '#' : '');
            if (!url) { alert('La URL es obligatoria.'); return; }
            var item = {
                titulo: this.form.titulo.trim().toUpperCase(),
                url: url,
                estado: this.form.estado,
                hijos: hijos
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
