<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
if (!(isset($_SESSION['usuario']) && ($validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'))) {
    header("Location: login.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Términos y Condiciones — Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
    <link rel="stylesheet" href="../public/assets/css/animate.css">
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        body { background: #f4f6f9; }
        .page-title { border-left: 4px solid #c7161d; padding-left: 12px; margin-bottom: 24px; }
        .btn-rojo { background: #c7161d; border-color: #c7161d; color: #fff; }
        .btn-rojo:hover { background: #a01018; color: #fff; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        .card-header-rojo { background: #c7161d; color: #fff; border-radius: 10px 10px 0 0; padding: 14px 20px; font-weight: 600; }
        .card-header-dark { background: #343a40; color: #fff; border-radius: 10px 10px 0 0; padding: 14px 20px; font-weight: 600; }
        .section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; margin-bottom: 6px; display: block; }
        .seccion-card { background: #fff; border: 1px solid #e9ecef; border-radius: 8px; padding: 18px; margin-bottom: 14px; position: relative; }
        .seccion-card .drag-handle { cursor: grab; color: #adb5bd; margin-right: 10px; }
        .seccion-card .drag-handle:active { cursor: grabbing; }
        .seccion-num { background: #c7161d; color: #fff; border-radius: 50%; width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; margin-right: 8px; flex-shrink: 0; }
        .save-toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: none; }
        .sortable-ghost { opacity: .4; background: #ece6a3; }
    </style>
</head>
<body>
<?php include "../fragment/nav_bar_admin.php" ?>

<div id="app" class="custom-container" style="margin-top:100px; padding:20px 30px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0"><i class="fas fa-file-contract mr-2"></i>Términos y Condiciones</h4>
        <div>
            <a href="../CYM/term.php" target="_blank" class="btn btn-outline-secondary btn-sm mr-2">
                <i class="fas fa-eye mr-1"></i> Ver página
            </a>
            <button class="btn btn-rojo btn-sm" @click="guardar" :disabled="guardando">
                <i class="fas fa-save mr-1"></i> {{ guardando ? 'Guardando...' : 'Guardar cambios' }}
            </button>
        </div>
    </div>

    <!-- ENCABEZADO -->
    <div class="card mb-4">
        <div class="card-header-rojo"><i class="fas fa-heading mr-2"></i>Encabezado de la página</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="section-label">Título principal</label>
                        <input type="text" class="form-control" v-model="d.titulo" placeholder="Términos y Condiciones">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="section-label">Subtítulo / descripción breve</label>
                        <input type="text" class="form-control" v-model="d.subtitulo" placeholder="Lea atentamente antes de usar nuestro sitio">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label class="section-label">Fecha de vigencia</label>
                        <input type="date" class="form-control" v-model="d.fecha">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-0">
                        <label class="section-label">Tamaño del título — <strong>{{ d.heroFontSize || 3.2 }}rem</strong></label>
                        <input type="range" class="form-control-range mt-2" v-model.number="d.heroFontSize"
                            min="1.4" max="5.0" step="0.1">
                        <div class="d-flex justify-content-between" style="font-size:11px;color:#adb5bd;">
                            <span>Pequeño</span><span>Grande</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="section-label">Alto del encabezado — <strong>{{ d.heroPaddingV || 28 }}px</strong></label>
                        <input type="range" class="form-control-range mt-2" v-model.number="d.heroPaddingV"
                            min="10" max="120" step="5">
                        <div class="d-flex justify-content-between" style="font-size:11px;color:#adb5bd;">
                            <span>Compacto</span><span>Amplio</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BIENVENIDA -->
    <div class="card mb-4">
        <div class="card-header-rojo"><i class="fas fa-quote-left mr-2"></i>Recuadro de bienvenida</div>
        <div class="card-body">
            <div class="form-group mb-0">
                <label class="section-label">Texto introductorio (aparece antes de las secciones con borde rojo a la izquierda)</label>
                <textarea class="form-control" v-model="d.intro" rows="3"
                    placeholder="Bienvenido. Al acceder o utilizar nuestro sitio web y servicios, usted acepta..."></textarea>
            </div>
        </div>
    </div>

    <!-- SECCIONES -->
    <div class="card mb-4">
        <div class="card-header-dark d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list-ul mr-2"></i>Secciones</span>
            <button class="btn btn-sm btn-light" @click="agregarSeccion">
                <i class="fas fa-plus mr-1"></i> Agregar sección
            </button>
        </div>
        <div class="card-body" id="secciones-body">

            <div v-if="cargando" class="text-center py-5">
                <i class="fas fa-spinner fa-spin fa-2x text-secondary"></i>
            </div>

            <div v-else-if="d.secciones.length === 0" class="text-center text-muted py-5">
                <i class="fas fa-file-alt fa-2x mb-2 d-block"></i>
                Sin secciones. Haz clic en "Agregar sección".
            </div>

            <div v-for="(sec, i) in d.secciones" :key="sec._id" class="seccion-card">
                <div class="d-flex align-items-start">
                    <i class="fas fa-grip-vertical drag-handle mt-1"></i>
                    <span class="seccion-num">{{ i + 1 }}</span>
                    <div class="flex-grow-1">
                        <div class="form-group">
                            <label class="section-label">Título de la sección</label>
                            <input type="text" class="form-control" v-model="sec.titulo"
                                :placeholder="'Ej: ' + (i+1) + '. Uso del sitio web'">
                        </div>
                        <div class="form-group mb-0">
                            <label class="section-label">Contenido</label>
                            <textarea class="form-control" v-model="sec.contenido" rows="6"
                                placeholder="Escriba el contenido..."></textarea>
                            <small class="text-muted d-block mt-1">
                                <strong>- texto</strong> → lista con punto &nbsp;|&nbsp;
                                <strong>1. texto</strong> → lista numerada &nbsp;|&nbsp;
                                <strong>! texto</strong> → recuadro destacado &nbsp;|&nbsp;
                                línea vacía → separador de párrafo
                            </small>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger ml-3 mt-1" @click="eliminarSeccion(i)" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white text-muted" style="font-size:12px; border-radius:0 0 10px 10px;">
            <i class="fas fa-grip-vertical mr-1"></i> Arrastra las secciones para reordenarlas.
        </div>
    </div>

    <!-- Toast -->
    <div class="save-toast" id="saveToast">
        <div class="alert alert-success shadow mb-0">
            <i class="fas fa-check-circle mr-2"></i> ¡Guardado correctamente!
        </div>
    </div>

</div><!-- /#app -->

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../public/assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script>
var _uid = 0;
function uid() { return ++_uid; }

new Vue({
    el: '#app',
    data: {
        cargando: true,
        guardando: false,
        d: {
            titulo: 'Términos y Condiciones',
            subtitulo: 'Lea atentamente antes de usar nuestro sitio',
            fecha: '<?= date('Y-m-d') ?>',
            intro: '',
            heroFontSize: 3.2,
            heroPaddingV: 28,
            secciones: []
        }
    },
    mounted: function() {
        var self = this;
        $.post('../ajax/ajs_configuracione.php', { tipo: 'terminos_S' }, function(res) {
            if (res && res.titulo) {
                self.d = Object.assign({ heroFontSize: 3.2, heroPaddingV: 28, intro: '' }, res);
                if (!self.d.secciones) self.$set(self.d, 'secciones', []);
                self.d.secciones.forEach(function(s) { if (!s._id) self.$set(s, '_id', uid()); });
            }
            self.cargando = false;
            self.$nextTick(function() { self.initSortable(); });
        }, 'json').fail(function() { self.cargando = false; });
    },
    methods: {
        agregarSeccion: function() {
            this.d.secciones.push({ _id: uid(), titulo: '', contenido: '' });
            this.$nextTick(function() { this.initSortable(); }.bind(this));
        },
        eliminarSeccion: function(i) {
            if (!confirm('¿Eliminar esta sección?')) return;
            this.d.secciones.splice(i, 1);
        },
        initSortable: function() {
            var el = document.getElementById('secciones-body');
            if (!el || el._sortable) return;
            var self = this;
            el._sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                onEnd: function(evt) {
                    var moved = self.d.secciones.splice(evt.oldIndex, 1)[0];
                    self.d.secciones.splice(evt.newIndex, 0, moved);
                }
            });
        },
        guardar: function() {
            var self = this;
            self.guardando = true;
            var payload = JSON.parse(JSON.stringify(self.d));
            payload.secciones.forEach(function(s) { delete s._id; });
            $.post('../ajax/ajs_configuracione.php', {
                tipo: 'terminos_IN',
                data: JSON.stringify(payload)
            }, function(res) {
                self.guardando = false;
                if (res && res.res) {
                    var t = document.getElementById('saveToast');
                    t.style.display = 'block';
                    setTimeout(function() { t.style.display = 'none'; }, 3000);
                } else {
                    alert('Error al guardar.');
                }
            }, 'json');
        }
    }
});
</script>
</body>
</html>
