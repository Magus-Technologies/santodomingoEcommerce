<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
if (!(isset($_SESSION['usuario']) && ($validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'))) {
    header("Location: login.php"); exit;
}
$esAdmin = ($validate['perfil'] == 'admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Libro de Reclamaciones — Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
    <link rel="stylesheet" href="../public/assets/css/animate.css">
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        body { background: #f4f6f9; }
        .page-title { border-left: 4px solid #c7161d; padding-left: 12px; margin-bottom: 24px; }
        .card  { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        .card-header-rojo { background: #c7161d; color: #fff; border-radius: 10px 10px 0 0; padding: 14px 20px; font-weight: 600; }

        /* Stats */
        .stat-card { background:#fff; border-radius:10px; padding:20px 22px; box-shadow:0 2px 10px rgba(0,0,0,.07); text-align:center; }
        .stat-card .valor { font-size:2rem; font-weight:800; color:#232323; line-height:1; }
        .stat-card .etiq  { font-size:11px; color:#888; text-transform:uppercase; letter-spacing:.5px; margin-top:6px; }
        .stat-card i { font-size:1.6rem; margin-bottom:8px; display:block; }
        .stat-pend i { color:#ffc107; }
        .stat-resp i { color:#28a745; }
        .stat-tot  i { color:#c7161d; }

        /* Tabla */
        .table thead th { background:#f8f9fa; font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:#6c757d; border-bottom:2px solid #dee2e6; }
        .table td { vertical-align:middle; font-size:13px; }
        .badge-pend { background:#fff3cd; color:#856404; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-resp { background:#d1e7dd; color:#0a3622; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:700; }
        .badge-tipo { background:#f0f0f0; color:#555; padding:3px 9px; border-radius:20px; font-size:11px; }
        .badge-reclamo { background:#fde8e8; color:#c7161d; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }
        .badge-queja   { background:#fff3cd; color:#856404; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; }

        /* Búsqueda */
        .search-input { border:1px solid #dee2e6; border-radius:6px; padding:7px 12px; font-size:13px; outline:none; }
        .search-input:focus { border-color:#c7161d; box-shadow:0 0 0 3px rgba(199,22,29,.08); }

        /* Modal */
        .modal-header-rojo { background:#c7161d; color:#fff; border-radius:6px 6px 0 0; }
        .modal-header-rojo .close { color:#fff; opacity:1; }
        .campo-label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#adb5bd; margin-bottom:4px; }
        .campo-val   { font-size:13px; color:#333; margin-bottom:14px; }
        .seccion-sep { background:#f8f9fa; border-radius:6px; padding:8px 14px; font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:.5px; margin:16px 0 12px; }

        .btn-rojo { background:#c7161d; border-color:#c7161d; color:#fff; }
        .btn-rojo:hover { background:#a01018; color:#fff; }
        .save-toast { position:fixed; bottom:24px; right:24px; z-index:9999; display:none; }
    </style>
</head>
<body>
<?php include "../fragment/nav_bar_admin.php" ?>

<div id="app" class="custom-container" style="margin-top:100px; padding:20px 30px;">

    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0"><i class="fas fa-book mr-2"></i>Libro de Reclamaciones</h4>
        <a href="../public/librorec/libro.php" target="_blank" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-external-link-alt mr-1"></i> Ver formulario público
        </a>
    </div>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card stat-tot">
                <i class="fas fa-book"></i>
                <div class="valor">{{ total }}</div>
                <div class="etiq">Total reclamaciones</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card stat-pend">
                <i class="fas fa-clock"></i>
                <div class="valor">{{ pendientes }}</div>
                <div class="etiq">Pendientes de respuesta</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stat-card stat-resp">
                <i class="fas fa-check-circle"></i>
                <div class="valor">{{ respondidas }}</div>
                <div class="etiq">Respondidas</div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card">
        <div class="card-header-rojo d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list mr-2"></i>Listado de reclamaciones</span>
            <input type="text" class="search-input" v-model="buscar" placeholder="&#128269; Buscar por nombre, DNI, N°...">
        </div>
        <div class="card-body p-0">

            <div v-if="cargando" class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>

            <div v-else-if="listaFiltrada.length === 0" class="text-center text-muted py-5">
                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                {{ buscar ? 'Sin resultados para "' + buscar + '"' : 'No hay reclamaciones registradas.' }}
            </div>

            <div v-else class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>N° Hoja</th>
                            <th>Fecha</th>
                            <th>Consumidor</th>
                            <th>DNI</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Días hábiles</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="r in listaFiltrada" :key="r.lib_id">
                            <td><strong>{{ r.lib_code }}</strong></td>
                            <td>{{ r.lib_date }}</td>
                            <td>{{ r.lib_cliente }}</td>
                            <td>{{ r.lib_DNI }}</td>
                            <td>
                                <span :class="r.lib_tiporec === 'reclamo' ? 'badge-reclamo' : 'badge-queja'">
                                    {{ r.lib_tiporec === 'reclamo' ? 'Reclamo' : 'Queja' }}
                                </span>
                            </td>
                            <td>
                                <span v-if="respondida(r)" class="badge-resp">&#10003; Respondida</span>
                                <span v-else class="badge-pend">&#9679; Pendiente</span>
                            </td>
                            <td>
                                <span v-if="!respondida(r)" :class="diasHabiles(r.lib_date) > 25 ? 'text-danger font-weight-bold' : (diasHabiles(r.lib_date) > 20 ? 'text-warning font-weight-bold' : 'text-muted')">
                                    {{ diasHabiles(r.lib_date) }} / 30
                                </span>
                                <span v-else class="text-success">—</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" @click="verDetalle(r)">
                                    <i class="fas fa-eye mr-1"></i> Ver
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL DETALLE / RESPUESTA -->
    <div class="modal fade" id="modalDetalle" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" v-if="sel">
                <div class="modal-header modal-header-rojo">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt mr-2"></i>
                        Hoja N° {{ sel.lib_code }}
                        <small class="ml-2 font-weight-normal" style="font-size:12px;opacity:.8;">{{ sel.lib_date }}</small>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <!-- Consumidor -->
                    <div class="seccion-sep"><i class="fas fa-user mr-1"></i> Consumidor reclamante</div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="campo-label">Nombre</div>
                            <div class="campo-val">{{ sel.lib_cliente }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="campo-label">DNI / CE</div>
                            <div class="campo-val">{{ sel.lib_DNI }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="campo-label">Email</div>
                            <div class="campo-val" style="word-break:break-all;">{{ sel.lib_emailcli }}</div>
                        </div>
                    </div>

                    <!-- Bien -->
                    <div class="seccion-sep"><i class="fas fa-box mr-1"></i> Bien contratado</div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="campo-label">Tipo</div>
                            <div class="campo-val">
                                <span class="badge-tipo">{{ sel.lib_tiposer }}</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="campo-label">Tipo reclamación</div>
                            <div class="campo-val">
                                <span :class="sel.lib_tiporec === 'reclamo' ? 'badge-reclamo' : 'badge-queja'">{{ sel.lib_tiporec }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Detalle -->
                    <div class="seccion-sep"><i class="fas fa-comment-alt mr-1"></i> Detalle y pedido</div>
                    <div class="campo-label">Detalle del reclamo</div>
                    <div class="campo-val" style="background:#f8f9fa;border-radius:6px;padding:10px 14px;white-space:pre-wrap;">{{ sel.lib_detalle }}</div>

                    <!-- Respuesta — solo admin -->
                    <?php if ($esAdmin): ?>
                    <div class="seccion-sep"><i class="fas fa-reply mr-1"></i> Respuesta del proveedor</div>
                    <div class="form-group">
                        <label class="campo-label">Fecha de respuesta</label>
                        <input type="date" class="form-control form-control-sm" v-model="respFecha" style="max-width:180px;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="campo-label">Texto de respuesta</label>
                        <textarea class="form-control" v-model="respTexto" rows="5"
                            :placeholder="respondida(sel) ? '' : 'Escriba la respuesta al consumidor...'"
                            :readonly="respondida(sel)"></textarea>
                        <small v-if="respondida(sel)" class="text-success"><i class="fas fa-check-circle mr-1"></i>Ya respondida el {{ sel.lib_fecres }}</small>
                    </div>
                    <?php else: ?>
                    <div class="seccion-sep"><i class="fas fa-reply mr-1"></i> Respuesta del proveedor</div>
                    <div class="campo-val" style="background:#f8f9fa;border-radius:6px;padding:10px 14px;white-space:pre-wrap;">
                        {{ sel.lib_respuesta || '(Sin respuesta aún)' }}
                    </div>
                    <?php endif; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                    <?php if ($esAdmin): ?>
                    <button type="button" class="btn btn-rojo btn-sm" @click="guardarRespuesta"
                        :disabled="guardando || respondida(sel)">
                        <i class="fas fa-save mr-1"></i>
                        {{ guardando ? 'Guardando...' : (respondida(sel) ? 'Ya respondida' : 'Guardar respuesta') }}
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="save-toast" id="saveToast">
        <div class="alert alert-success shadow mb-0">
            <i class="fas fa-check-circle mr-2"></i> Respuesta guardada correctamente.
        </div>
    </div>

</div>

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../public/assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script>
new Vue({
    el: '#app',
    data: {
        cargando: true,
        lista: [],
        buscar: '',
        sel: null,
        respFecha: '',
        respTexto: '',
        guardando: false
    },
    computed: {
        listaFiltrada: function() {
            var b = this.buscar.toLowerCase().trim();
            if (!b) return this.lista;
            return this.lista.filter(function(r) {
                return (r.lib_code   || '').toLowerCase().includes(b) ||
                       (r.lib_cliente|| '').toLowerCase().includes(b) ||
                       (r.lib_DNI    || '').toLowerCase().includes(b) ||
                       (r.lib_tiporec|| '').toLowerCase().includes(b);
            });
        },
        total:       function() { return this.lista.length; },
        pendientes:  function() { var self = this; return this.lista.filter(function(r) { return !self.respondida(r); }).length; },
        respondidas: function() { var self = this; return this.lista.filter(function(r) { return  self.respondida(r); }).length; }
    },
    mounted: function() {
        this.cargar();
    },
    methods: {
        cargar: function() {
            var self = this;
            self.cargando = true;
            $.post('../public/librorec/libroreclama.php', { opcion: 1 }, function(res) {
                try { self.lista = JSON.parse(res) || []; } catch(e) { self.lista = []; }
                self.cargando = false;
            }).fail(function() { self.cargando = false; });
        },
        respondida: function(r) {
            return r && r.lib_respuesta && r.lib_respuesta.trim().length > 0;
        },
        diasHabiles: function(fecha) {
            var hoy  = new Date();
            var ini  = new Date(fecha);
            var diff = Math.floor((hoy - ini) / (1000 * 60 * 60 * 24));
            return diff;
        },
        verDetalle: function(r) {
            this.sel       = r;
            this.respFecha = r.lib_fecres && r.lib_fecres !== '0000-00-00' ? r.lib_fecres : new Date().toISOString().slice(0,10);
            this.respTexto = r.lib_respuesta || '';
            $('#modalDetalle').modal('show');
        },
        guardarRespuesta: function() {
            var self = this;
            if (!self.respTexto.trim()) { alert('Escriba la respuesta antes de guardar.'); return; }
            self.guardando = true;
            $.post('../public/librorec/libroreclama.php', {
                opcion: 3,
                idre:   self.sel.lib_id,
                resppo: self.respTexto,
                fecres: self.respFecha
            }, function() {
                self.sel.lib_respuesta = self.respTexto;
                self.sel.lib_fecres    = self.respFecha;
                self.guardando = false;
                $('#modalDetalle').modal('hide');
                var t = document.getElementById('saveToast');
                t.style.display = 'block';
                setTimeout(function() { t.style.display = 'none'; }, 3000);
            }).fail(function() {
                self.guardando = false;
                alert('Error al guardar.');
            });
        }
    }
});
</script>
</body>
</html>
