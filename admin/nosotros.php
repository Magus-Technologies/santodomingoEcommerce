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
    <title>Nosotros — Admin</title>
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
    <link rel="stylesheet" href="../public/assets/css/animate.css">
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="../public/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        body { background: #f4f6f9; }
        .page-title { border-left: 4px solid #c7161d; padding-left: 12px; margin-bottom: 24px; }
        .btn-rojo { background: #c7161d; border-color: #c7161d; color: #fff; }
        .btn-rojo:hover { background: #a01018; color: #fff; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
        .card-header-rojo { background: #c7161d; color: #fff; border-radius: 10px 10px 0 0; padding: 14px 20px; font-weight: 600; }
        .card-header-dark { background: #343a40; color: #fff; border-radius: 10px 10px 0 0; padding: 14px 20px; font-weight: 600; }
        .section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; margin-bottom: 6px; display: block; }
        .stat-card, .miembro-card { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 14px; position: relative; }
        .remove-btn { position: absolute; top: 8px; right: 8px; }
        .preview-img { width: 64px; height: 64px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6; }
        .tab-pill { cursor: pointer; padding: 8px 18px; border-radius: 20px; font-size: 13px; font-weight: 600; color: #6c757d; background: #e9ecef; transition: all .2s; user-select: none; }
        .tab-pill.active { background: #c7161d; color: #fff; }
        .save-toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: none; }
    </style>
</head>
<body>
<?php include "../fragment/nav_bar_admin.php" ?>

<div id="app" class="custom-container" style="margin-top:100px; padding:20px 30px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0"><i class="fas fa-building mr-2"></i>Página "Sobre Nosotros"</h4>
        <div>
            <a href="../CYM/about.php" target="_blank" class="btn btn-outline-secondary btn-sm mr-2">
                <i class="fas fa-eye mr-1"></i> Ver página
            </a>
            <button class="btn btn-rojo btn-sm" @click="guardar" :disabled="guardando">
                <i class="fas fa-save mr-1"></i> {{ guardando ? 'Guardando...' : 'Guardar cambios' }}
            </button>
        </div>
    </div>

    <!-- TABS -->
    <div class="d-flex flex-wrap mb-4" style="gap:8px;">
        <span class="tab-pill" :class="{active: tab==='general'}" @click="tab='general'">
            <i class="fas fa-info-circle mr-1"></i>General
        </span>
        <span class="tab-pill" :class="{active: tab==='mvv'}" @click="tab='mvv'">
            <i class="fas fa-bullseye mr-1"></i>Misión / Visión / Valores
        </span>
        <span class="tab-pill" :class="{active: tab==='stats'}" @click="tab='stats'">
            <i class="fas fa-chart-bar mr-1"></i>Estadísticas
        </span>
        <span class="tab-pill" :class="{active: tab==='equipo'}" @click="tab='equipo'">
            <i class="fas fa-users mr-1"></i>Equipo
        </span>
    </div>

    <!-- TAB: GENERAL -->
    <div v-show="tab==='general'">
        <div class="card mb-4">
            <div class="card-header-rojo"><i class="fas fa-heading mr-2"></i>Encabezado principal</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="section-label">Título</label>
                            <input type="text" class="form-control" v-model="d.titulo" placeholder="Sobre Nosotros">
                        </div>
                        <div class="form-group">
                            <label class="section-label">Subtítulo</label>
                            <input type="text" class="form-control" v-model="d.subtitulo" placeholder="Conoce nuestra historia">
                        </div>
                        <div class="form-group">
                            <label class="section-label">Descripción principal</label>
                            <textarea class="form-control" v-model="d.descripcion" rows="5" placeholder="Texto introductorio..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="section-label">Texto botón CTA</label>
                                    <input type="text" class="form-control" v-model="d.cta_texto" placeholder="Ver productos">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-0">
                                    <label class="section-label">URL botón CTA</label>
                                    <input type="text" class="form-control" v-model="d.cta_url" placeholder="shop-list-prod.php">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="section-label">Imagen principal (URL o ruta relativa)</label>
                            <input type="text" class="form-control mb-2" v-model="d.imagen_principal" placeholder="../public/img/nosotros/portada.jpg">
                            <div v-if="d.imagen_principal" class="text-center">
                                <img :src="d.imagen_principal" class="img-fluid rounded" style="max-height:200px; object-fit:cover; width:100%;">
                            </div>
                            <div v-else class="d-flex align-items-center justify-content-center rounded" style="height:200px; background:#e9ecef; color:#adb5bd;">
                                <div class="text-center"><i class="fas fa-image fa-3x mb-2 d-block"></i><small>Sin imagen</small></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header-dark"><i class="fas fa-history mr-2"></i>Historia / Quiénes somos</div>
            <div class="card-body">
                <label class="section-label">Texto (se permite HTML básico como &lt;strong&gt;, &lt;br&gt;)</label>
                <textarea class="form-control" v-model="d.historia" rows="7" placeholder="Cuéntanos la historia de la empresa..."></textarea>
            </div>
        </div>
    </div>

    <!-- TAB: MVV -->
    <div v-show="tab==='mvv'">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header-rojo"><i class="fas fa-rocket mr-2"></i>Misión</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="section-label">Ícono FontAwesome</label>
                            <input type="text" class="form-control" v-model="d.mision_icono" placeholder="fas fa-rocket">
                            <div class="text-center mt-2"><i :class="d.mision_icono || 'fas fa-rocket'" style="font-size:30px; color:#c7161d;"></i></div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="section-label">Texto</label>
                            <textarea class="form-control" v-model="d.mision" rows="6" placeholder="Nuestra misión es..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header-dark"><i class="fas fa-eye mr-2"></i>Visión</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="section-label">Ícono FontAwesome</label>
                            <input type="text" class="form-control" v-model="d.vision_icono" placeholder="fas fa-eye">
                            <div class="text-center mt-2"><i :class="d.vision_icono || 'fas fa-eye'" style="font-size:30px; color:#343a40;"></i></div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="section-label">Texto</label>
                            <textarea class="form-control" v-model="d.vision" rows="6" placeholder="Nuestra visión es..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header-rojo"><i class="fas fa-star mr-2"></i>Valores</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="section-label">Ícono FontAwesome</label>
                            <input type="text" class="form-control" v-model="d.valores_icono" placeholder="fas fa-star">
                            <div class="text-center mt-2"><i :class="d.valores_icono || 'fas fa-star'" style="font-size:30px; color:#c7161d;"></i></div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="section-label">Texto</label>
                            <textarea class="form-control" v-model="d.valores" rows="6" placeholder="Nuestros valores son..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: STATS -->
    <div v-show="tab==='stats'">
        <div class="card mb-4">
            <div class="card-header-rojo d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-bar mr-2"></i>Estadísticas destacadas</span>
                <button class="btn btn-sm btn-light" @click="agregarStat"><i class="fas fa-plus mr-1"></i>Agregar</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div v-for="(stat, i) in d.stats" :key="i" class="col-md-3 mb-3">
                        <div class="stat-card">
                            <button class="btn btn-sm btn-outline-danger remove-btn" @click="d.stats.splice(i,1)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="form-group">
                                <label class="section-label">Ícono</label>
                                <input type="text" class="form-control form-control-sm" v-model="stat.icono" placeholder="fas fa-users">
                                <div class="text-center mt-1">
                                    <i :class="stat.icono || 'fas fa-star'" style="font-size:24px; color:#c7161d;"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="section-label">Valor</label>
                                <input type="text" class="form-control form-control-sm" v-model="stat.valor" placeholder="500+">
                            </div>
                            <div class="form-group mb-0">
                                <label class="section-label">Etiqueta</label>
                                <input type="text" class="form-control form-control-sm" v-model="stat.label" placeholder="Clientes">
                            </div>
                        </div>
                    </div>
                    <div v-if="!d.stats || d.stats.length===0" class="col-12 text-center text-muted py-5">
                        <i class="fas fa-chart-bar fa-2x mb-2 d-block"></i>Sin estadísticas. Haz clic en "Agregar".
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: EQUIPO -->
    <div v-show="tab==='equipo'">
        <div class="card mb-4">
            <div class="card-header-rojo d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users mr-2"></i>Miembros del equipo</span>
                <button class="btn btn-sm btn-light" @click="agregarMiembro"><i class="fas fa-plus mr-1"></i>Agregar</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div v-for="(m, i) in d.equipo" :key="i" class="col-md-3 mb-4">
                        <div class="miembro-card">
                            <button class="btn btn-sm btn-outline-danger remove-btn" @click="d.equipo.splice(i,1)">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="text-center mb-3">
                                <img v-if="m.imagen" :src="m.imagen" class="preview-img">
                                <div v-else class="preview-img d-inline-flex align-items-center justify-content-center" style="background:#dee2e6;">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="section-label">Nombre completo</label>
                                <input type="text" class="form-control form-control-sm" v-model="m.nombre" placeholder="Juan Pérez">
                            </div>
                            <div class="form-group">
                                <label class="section-label">Cargo</label>
                                <input type="text" class="form-control form-control-sm" v-model="m.cargo" placeholder="Gerente General">
                            </div>
                            <div class="form-group">
                                <label class="section-label">URL de imagen</label>
                                <input type="text" class="form-control form-control-sm" v-model="m.imagen" placeholder="../public/img/equipo/foto.jpg">
                            </div>
                            <div class="form-group mb-0">
                                <label class="section-label">Descripción breve</label>
                                <textarea class="form-control form-control-sm" v-model="m.descripcion" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div v-if="!d.equipo || d.equipo.length===0" class="col-12 text-center text-muted py-5">
                        <i class="fas fa-users fa-2x mb-2 d-block"></i>Sin miembros. Haz clic en "Agregar".
                    </div>
                </div>
            </div>
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
var DEFAULT = {
    titulo: 'Sobre Nosotros', subtitulo: 'Conoce nuestra historia',
    descripcion: '', imagen_principal: '',
    cta_texto: 'Ver productos', cta_url: 'shop-list-prod.php',
    historia: '',
    mision: '', mision_icono: 'fas fa-rocket',
    vision: '', vision_icono: 'fas fa-eye',
    valores: '', valores_icono: 'fas fa-star',
    stats: [
        { icono: 'fas fa-calendar-alt', valor: '10+', label: 'Años de experiencia' },
        { icono: 'fas fa-users', valor: '500+', label: 'Clientes satisfechos' },
        { icono: 'fas fa-box', valor: '1000+', label: 'Productos disponibles' },
        { icono: 'fas fa-truck', valor: '24h', label: 'Despacho rápido' }
    ],
    equipo: []
};

new Vue({
    el: '#app',
    data: { tab: 'general', d: JSON.parse(JSON.stringify(DEFAULT)), guardando: false },
    mounted: function() {
        var self = this;
        $.post('../ajax/ajs_configuracione.php', { tipo: 'nosotros_S' }, function(res) {
            if (res && Object.keys(res).length > 0) {
                self.d = Object.assign(JSON.parse(JSON.stringify(DEFAULT)), res);
                if (!self.d.stats) self.$set(self.d, 'stats', []);
                if (!self.d.equipo) self.$set(self.d, 'equipo', []);
            }
        }, 'json');
    },
    methods: {
        agregarStat: function() {
            this.d.stats.push({ icono: 'fas fa-star', valor: '', label: '' });
        },
        agregarMiembro: function() {
            this.d.equipo.push({ nombre: '', cargo: '', imagen: '', descripcion: '' });
        },
        guardar: function() {
            var self = this;
            self.guardando = true;
            $.post('../ajax/ajs_configuracione.php', {
                tipo: 'nosotros_IN',
                data: JSON.stringify(self.d)
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
