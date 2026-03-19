<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();

if(isset($_SESSION['usuario']) && $validate['perfil'] == 'admin' || $validate['perfil'] == 'vendedor'){
require "../config.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestra Seleccion - Admin</title>
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="../public/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/css/linearicons.css">
    <link rel="stylesheet" href="../public/assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <link rel="stylesheet" href="../public/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <style>
        body { background: #f4f6f9; }
        .page-header {
            background: #fff;
            padding: 18px 24px;
            border-left: 4px solid #880107;
            margin-bottom: 24px;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,.07);
        }
        .page-header h3 { color: #880107; font-weight: 700; margin: 0; }
        .card-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            overflow: hidden;
            transition: transform .2s;
        }
        .card-item:hover { transform: translateY(-3px); }
        .card-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .card-item .card-body { padding: 12px 14px; }
        .card-item .card-body h6 { font-weight: 700; margin-bottom: 4px; color: #333; }
        .card-item .card-body small { color: #888; }
        .badge-estado-1 { background: #28a745; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 20px; }
        .badge-estado-0 { background: #dc3545; color: #fff; font-size: 11px; padding: 2px 8px; border-radius: 20px; }
        .btn-accion { font-size: 12px; padding: 4px 10px; }
        .modal-header { background: #880107; color: #fff; }
        .modal-header .close { color: #fff; opacity: 1; }
        .img-modal-preview {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #eee;
            margin-bottom: 8px;
        }
        #alertaToken { display: none; }
        .loading-overlay {
            position: fixed; top:0; left:0; width:100%; height:100%;
            background: rgba(255,255,255,.7);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999; display: none;
        }
    </style>
</head>
<body>
<?php include "../fragment/nav_bar_admin.php"; ?>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner-border text-danger" style="width:3rem;height:3rem;"></div>
</div>

<div class="container" style="margin-top: 40px; padding-bottom: 60px;">

    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3><i class="fa fa-th-large"></i> &nbsp;Nuestra Selecci&oacute;n</h3>
                <p class="text-muted mb-0" style="margin-top:4px; font-size:14px;">
                    Gestiona las categor&iacute;as que aparecen en la secci&oacute;n <strong>"Nuestra Selecci&oacute;n"</strong> de la tienda.
                </p>
            </div>
            <button class="btn btn-danger" onclick="abrirModalNuevo()">
                <i class="fa fa-plus"></i> &nbsp;Nueva Categor&iacute;a
            </button>
        </div>
    </div>

    <!-- Alerta sin token -->
    <div class="alert alert-warning" id="alertaToken">
        <i class="fa fa-exclamation-triangle"></i>
        &nbsp;No se encontr&oacute; el token de autenticaci&oacute;n.
        Por favor inicia sesi&oacute;n en el <a href="../CYM/login.php">Sistema de Gesti&oacute;n</a> primero.
    </div>

    <!-- Grid de categorías -->
    <div class="row" id="gridSeleccion">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-danger"></div>
            <p class="text-muted mt-2">Cargando categor&iacute;as...</p>
        </div>
    </div>

</div>

<!-- Modal Crear / Editar -->
<div class="modal fade" id="modalSeleccion" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo">Nueva Categor&iacute;a</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id" value="">

                <div class="form-group">
                    <label class="font-weight-bold small">Imagen</label>
                    <img id="modalImgPreview" src="../public/img/banner/sinimagen_menu_20sba.jpg" class="img-modal-preview">
                    <input type="file" id="modalImgFile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                           class="form-control-file" style="font-size:13px;">
                    <small class="text-muted">M&aacute;x. 2MB. Formatos: jpg, png, gif, webp</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold small">Nombre de la categor&iacute;a <span class="text-danger">*</span></label>
                    <input type="text" id="modal_nombre" class="form-control" placeholder="Ej: Vinos Tintos" maxlength="100">
                </div>

                <div class="form-group">
                    <label class="font-weight-bold small">Categor&iacute;a</label>
                    <select id="modal_codigo" class="form-control" style="width:100%">
                        <option value="">-- Selecciona una categor&iacute;a --</option>
                    </select>
                    <small class="text-muted">Busca por nombre o c&oacute;digo</small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold small">Estado</label>
                    <select id="modal_estado" class="form-control">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm" id="btnGuardar" onclick="guardar()">
                    <i class="fa fa-save"></i> &nbsp;Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal confirmar eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#dc3545;color:#fff;">
                <h5 class="modal-title">Eliminar</h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Deseas eliminar la categor&iacute;a <strong id="nombreEliminar"></strong>?</p>
                <input type="hidden" id="idEliminar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar()">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    var TOKEN = localStorage.getItem('auth_token') || '';
    var categoriasCache = [];

    // Inicializar Select2
    $('#modal_codigo').select2({
        theme: 'bootstrap-5',
        placeholder: 'Busca por nombre...',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#modalSeleccion')
    });

    // Cargar categorías desde la API
    function cargarCategorias(codigoSeleccionado) {
        if (categoriasCache.length > 0) {
            poblarSelect(codigoSeleccionado);
            return;
        }
        $.post('../ajax/proxy_seleccion.php', { tipo: 'categorias' }, function(resp) {
            if (resp.success && resp.data) {
                categoriasCache = resp.data;
                poblarSelect(codigoSeleccionado);
            }
        }, 'json');
    }

    function poblarSelect(valorActual) {
        var $sel = $('#modal_codigo');
        $sel.empty().append('<option value="">-- Selecciona una categoría --</option>');
        $.each(categoriasCache, function(i, cat) {
            if (cat.estado != '1') return;
            var opt = new Option(cat.nombre + ' (ID: ' + cat.id + ')', cat.id, false, String(cat.id) === String(valorActual));
            $sel.append(opt);
        });
        $sel.trigger('change');
    }

    // Preview imagen al seleccionar
    document.getElementById('modalImgFile').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('modalImgPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    function mostrarLoading(v) {
        document.getElementById('loadingOverlay').style.display = v ? 'flex' : 'none';
    }

    // ─── Cargar lista ───────────────────────────────────────────────────────────
    function cargarLista() {
        $.ajax({
            type: 'POST',
            url: '../ajax/proxy_seleccion.php',
            data: { tipo: 'lista', token: TOKEN },
            success: function(resp) {
                if (resp.success) {
                    renderGrid(resp.data);
                } else {
                    $('#gridSeleccion').html('<div class="col-12"><div class="alert alert-danger">Error al cargar los datos.</div></div>');
                }
            },
            error: function() {
                if (!TOKEN) { $('#alertaToken').show(); }
                $('#gridSeleccion').html('<div class="col-12"><div class="alert alert-danger">No se pudo conectar con la API.</div></div>');
            }
        });
    }

    function renderGrid(items) {
        if (!items || items.length === 0) {
            $('#gridSeleccion').html('<div class="col-12 text-center py-5"><i class="fa fa-inbox fa-3x text-muted"></i><p class="text-muted mt-2">No hay categorias registradas.</p></div>');
            return;
        }
        var html = '';
        $.each(items, function(i, item) {
            var img = item.imagen_url || '../public/img/banner/sinimagen_menu_20sba.jpg';
            var badgeEstado = item.estado == '1'
                ? '<span class="badge-estado-1">Activo</span>'
                : '<span class="badge-estado-0">Inactivo</span>';
            html += '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">' +
                '<div class="card-item">' +
                    '<img src="' + img + '" onerror="this.src=\'../public/img/banner/sinimagen_menu_20sba.jpg\'">' +
                    '<div class="card-body">' +
                        '<h6>' + escHtml(item.nombre_cate) + '</h6>' +
                        '<small class="d-block mb-1">Cod: ' + escHtml(item.codi_categoria || '-') + '</small>' +
                        badgeEstado +
                        '<div class="mt-2 d-flex" style="gap:6px;">' +
                            '<button class="btn btn-sm btn-outline-primary btn-accion flex-fill" onclick="abrirModalEditar(' + item.id_seleccion + ')">' +
                                '<i class="fa fa-edit"></i> Editar' +
                            '</button>' +
                            '<button class="btn btn-sm btn-outline-danger btn-accion flex-fill" onclick="abrirModalEliminar(' + item.id_seleccion + ', \'' + escHtml(item.nombre_cate) + '\')">' +
                                '<i class="fa fa-trash"></i>' +
                            '</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>';
        });
        $('#gridSeleccion').html(html);
    }

    // ─── Modal nuevo ────────────────────────────────────────────────────────────
    function abrirModalNuevo() {
        $('#modalTitulo').text('Nueva Categoria');
        $('#edit_id').val('');
        $('#modal_nombre').val('');
        $('#modal_codigo').val('').trigger('change');
        $('#modal_estado').val('1');
        $('#modalImgPreview').attr('src', '../public/img/banner/sinimagen_menu_20sba.jpg');
        $('#modalImgFile').val('');
        cargarCategorias('');
        $('#modalSeleccion').modal('show');
    }

    // ─── Modal editar ───────────────────────────────────────────────────────────
    function abrirModalEditar(id) {
        mostrarLoading(true);
        $.ajax({
            type: 'POST',
            url: '../ajax/proxy_seleccion.php',
            data: { tipo: 'get', id: id, token: TOKEN },
            success: function(resp) {
                mostrarLoading(false);
                if (resp.success) {
                    var d = resp.data;
                    $('#modalTitulo').text('Editar Categoria');
                    $('#edit_id').val(d.id_seleccion);
                    $('#modal_nombre').val(d.nombre_cate);
                    $('#modal_estado').val(d.estado);
                    cargarCategorias(d.codi_categoria || '');
                    $('#modalImgPreview').attr('src', d.imagen_url || '../public/img/banner/sinimagen_menu_20sba.jpg');
                    $('#modalImgFile').val('');
                    $('#modalSeleccion').modal('show');
                } else {
                    alert('No se pudo cargar la categoria');
                }
            },
            error: function() {
                mostrarLoading(false);
                alert('Error de conexion');
            }
        });
    }

    // ─── Guardar (crear o actualizar) ───────────────────────────────────────────
    function guardar() {
        var nombre = $('#modal_nombre').val().trim();
        if (!nombre) { alert('El nombre de la categoria es requerido'); return; }

        var id     = $('#edit_id').val();
        var tipo   = id ? 'actualizar' : 'crear';
        var fd     = new FormData();

        fd.append('tipo',           tipo);
        fd.append('token',          TOKEN);
        fd.append('nombre_cate',    nombre);
        fd.append('codi_categoria', $('#modal_codigo').val() || '');
        fd.append('estado',         $('#modal_estado').val());
        if (id) fd.append('id', id);

        var imgFile = document.getElementById('modalImgFile').files[0];
        if (imgFile) fd.append('imagen', imgFile);

        mostrarLoading(true);
        $.ajax({
            type: 'POST',
            url: '../ajax/proxy_seleccion.php',
            data: fd,
            processData: false,
            contentType: false,
            success: function(resp) {
                mostrarLoading(false);
                if (resp.success) {
                    $('#modalSeleccion').modal('hide');
                    cargarLista();
                } else {
                    alert('Error: ' + (resp.message || 'No se pudo guardar'));
                }
            },
            error: function() {
                mostrarLoading(false);
                alert('Error de conexion con la API');
            }
        });
    }

    // ─── Eliminar ───────────────────────────────────────────────────────────────
    function abrirModalEliminar(id, nombre) {
        $('#idEliminar').val(id);
        $('#nombreEliminar').text(nombre);
        $('#modalEliminar').modal('show');
    }

    function confirmarEliminar() {
        var id = $('#idEliminar').val();
        mostrarLoading(true);
        $.ajax({
            type: 'POST',
            url: '../ajax/proxy_seleccion.php',
            data: { tipo: 'eliminar', id: id, token: TOKEN },
            success: function(resp) {
                mostrarLoading(false);
                $('#modalEliminar').modal('hide');
                if (resp.success) {
                    cargarLista();
                } else {
                    alert('Error: ' + (resp.message || 'No se pudo eliminar'));
                }
            },
            error: function() {
                mostrarLoading(false);
                alert('Error de conexion');
            }
        });
    }

    function escHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    // Iniciar
    if (!TOKEN) { $('#alertaToken').show(); }
    cargarLista();
</script>
</body>
</html>
<?php } else { header("Location: ../CYM/"); } ?>
