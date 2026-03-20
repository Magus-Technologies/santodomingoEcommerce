<?php
    $hoy   = date("Y-m-d");
    $anual = date("Y");
    include "BD.php";

    // Config del sitio
    $tsconfig = [];
    $tsPath = __DIR__ . '/../../tsconfig.json';
    if (file_exists($tsPath)) {
        $tsconfig = json_decode(file_get_contents($tsPath), true) ?? [];
    }
    $nombreEmpresa = $tsconfig['empresa_nombre'] ?? 'VIÑASANTODOMINGO';
    $rucEmpresa    = $tsconfig['empresa_ruc']    ?? '';
    $dirEmpresa    = $tsconfig['empresa_dir']    ?? '';

    $sql0 = "SELECT (CASE WHEN COUNT(lib_id)=0 THEN 1 ELSE COUNT(lib_id)+1 END) AS codirec
             FROM libro_reclamacion";
    $res0      = mysqli_query($con, $sql0);
    $arr0      = mysqli_fetch_array($res0, MYSQLI_ASSOC);
    $numerec   = $arr0['codirec'];
    $codigorec = str_pad($numerec, 8, '0', STR_PAD_LEFT) . '-' . $anual;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($nombreEmpresa) ?> — Libro de Reclamaciones</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="librorec.css">
    <link rel="stylesheet" href="print_lib.css">
</head>
<body>

<!-- ── HERO ── -->
<header class="lr-hero">
    <div class="lr-hero-inner">
        <div class="lr-badge">Documento Oficial</div>
        <h1>Libro de<span>Reclamaciones</span></h1>
        <p class="lr-hero-sub">Código de Protección y Defensa del Consumidor — Ley N° 29571</p>
    </div>
    <div class="lr-wave">
        <svg viewBox="0 0 1440 50" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,25 C360,50 1080,0 1440,25 L1440,50 L0,50 Z" fill="#f4f6f9"/>
        </svg>
    </div>
</header>

<!-- ── BUSCADOR DNI ── -->
<div class="lr-dni-bar">
    <label>Autocompletar con DNI / CE:</label>
    <input type="text" id="numfil" placeholder="Ingrese DNI (8) o RUC (11)" maxlength="11">
    <button class="lr-btn-buscar" id="btnFiltro" type="button">Buscar</button>
    <span id="dni-msg"></span>
</div>

<!-- ── FORMULARIO ── -->
<div class="lr-main">
<form id="asForm" autocomplete="off">

    <!-- META: Negocio / Fecha / N° -->
    <div class="lr-meta-card">
        <div class="lr-meta-item" style="flex:2; min-width:200px;">
            <label>Establecimiento</label>
            <input type="text" id="negocio" name="negocio" value="<?= htmlspecialchars($nombreEmpresa) ?>" readonly>
        </div>
        <?php if ($rucEmpresa): ?>
        <div class="lr-meta-item" style="flex:1;">
            <label>RUC</label>
            <input type="text" value="<?= htmlspecialchars($rucEmpresa) ?>" readonly>
        </div>
        <?php endif; ?>
        <div class="lr-meta-item" style="flex:2; min-width:160px;">
            <label>Dirección</label>
            <input type="text" id="tienda" name="tienda" value="<?= htmlspecialchars($dirEmpresa) ?>" readonly>
        </div>
        <div class="lr-meta-item" style="flex:1; min-width:130px;">
            <label>Fecha</label>
            <input type="date" id="fecharec" value="<?= $hoy ?>" readonly>
        </div>
        <div class="lr-meta-item" style="flex:1; min-width:130px;">
            <label>N° de hoja</label>
            <input type="text" id="numrecla" name="numrecla" value="<?= htmlspecialchars($codigorec) ?>" readonly>
        </div>
    </div>

    <!-- SECCIÓN 1 -->
    <div class="lr-section">
        <div class="lr-section-header">
            <div class="lr-section-num">1</div>
            <p class="lr-section-title">Identificación del Consumidor Reclamante</p>
        </div>
        <div class="lr-section-body">

            <div class="lr-row">
                <div class="lr-field full">
                    <label>Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre y apellidos">
                </div>
            </div>
            <div class="lr-row">
                <div class="lr-field full">
                    <label>Domicilio *</label>
                    <input type="text" id="domicilio" name="domicilio" placeholder="Dirección completa">
                </div>
            </div>
            <div class="lr-row">
                <div class="lr-field">
                    <label>DNI / CE *</label>
                    <input type="text" id="dni" name="dni" placeholder="Número de documento" maxlength="11">
                </div>
                <div class="lr-field">
                    <label>Teléfono *</label>
                    <input type="text" id="telefono" name="telefono" placeholder="9XXXXXXXX" maxlength="9">
                </div>
                <div class="lr-field" style="flex:2;">
                    <label>Correo electrónico *</label>
                    <input type="email" id="email" name="email" placeholder="correo@ejemplo.com">
                </div>
            </div>

            <!-- Menor de edad -->
            <label class="lr-check-label">
                <input type="checkbox" id="menor" name="menor" value="1">
                Menor de edad (completar datos del apoderado)
            </label>

            <div id="bloque-apoderado">
                <div class="lr-row">
                    <div class="lr-field full">
                        <label>Nombre del apoderado</label>
                        <input type="text" id="nombre_padre" name="nombre_padre" placeholder="Nombre completo del apoderado" disabled>
                    </div>
                </div>
                <div class="lr-row">
                    <div class="lr-field full">
                        <label>Domicilio del apoderado</label>
                        <input type="text" id="domicilio_padre" name="domicilio_padre" placeholder="Dirección del apoderado" disabled>
                    </div>
                </div>
                <div class="lr-row">
                    <div class="lr-field">
                        <label>DNI / CE</label>
                        <input type="text" id="dni_padre" name="dni_padre" maxlength="11" disabled>
                    </div>
                    <div class="lr-field">
                        <label>Teléfono</label>
                        <input type="text" id="telefono_padre" name="telefono_padre" maxlength="9" disabled>
                    </div>
                    <div class="lr-field" style="flex:2;">
                        <label>Correo electrónico</label>
                        <input type="text" id="email_padre" name="email_padre" disabled>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SECCIÓN 2 -->
    <div class="lr-section">
        <div class="lr-section-header">
            <div class="lr-section-num">2</div>
            <p class="lr-section-title">Identificación del Bien Contratado</p>
        </div>
        <div class="lr-section-body">

            <div class="lr-radio-group">
                <label class="lr-radio-opt">
                    <input type="radio" name="tipo_bien" id="producto" value="producto">
                    <span><strong>Producto</strong><small>Bien adquirido</small></span>
                </label>
                <label class="lr-radio-opt">
                    <input type="radio" name="tipo_bien" id="servicio" value="servicio">
                    <span><strong>Servicio</strong><small>Servicio contratado</small></span>
                </label>
            </div>

            <div class="lr-row">
                <div class="lr-field" style="flex:2;">
                    <label>Descripción del producto o servicio *</label>
                    <input type="text" id="descripcion" name="descripcion" placeholder="Describa el bien o servicio">
                </div>
                <div class="lr-field" style="flex:1;">
                    <label>Monto reclamado (S/)</label>
                    <input type="text" id="monto" name="monto" placeholder="0.00">
                </div>
            </div>

        </div>
    </div>

    <!-- SECCIÓN 3 -->
    <div class="lr-section">
        <div class="lr-section-header">
            <div class="lr-section-num">3</div>
            <p class="lr-section-title">Detalle de la Reclamación y Pedido del Consumidor</p>
        </div>
        <div class="lr-section-body">

            <div class="lr-radio-group">
                <label class="lr-radio-opt">
                    <input type="radio" name="tipo_reclamo" id="reclamo" value="reclamo">
                    <span>
                        <strong>Reclamo</strong>
                        <small>Disconformidad relacionada al producto o servicio</small>
                    </span>
                </label>
                <label class="lr-radio-opt">
                    <input type="radio" name="tipo_reclamo" id="queja" value="queja">
                    <span>
                        <strong>Queja</strong>
                        <small>Malestar o descontento respecto a la atención</small>
                    </span>
                </label>
            </div>

            <div class="lr-row">
                <div class="lr-field full">
                    <label>Detalle del reclamo / queja *</label>
                    <textarea id="detalle" name="detalle" rows="5" placeholder="Describa con detalle el motivo de su reclamo o queja..."></textarea>
                </div>
            </div>
            <div class="lr-row">
                <div class="lr-field full">
                    <label>Pedido del consumidor *</label>
                    <textarea id="pedido" name="pedido" rows="4" placeholder="Indique qué solución espera recibir..."></textarea>
                </div>
            </div>

            <div class="lr-actions">
                <button type="button" class="lr-btn lr-btn-outline" onclick="window.print()">
                    &#128438; Imprimir
                </button>
                <button type="submit" class="lr-btn lr-btn-primary" id="btnEnviar">
                    &#9993; Enviar reclamación
                </button>
            </div>

        </div>
    </div>

    <!-- SECCIÓN 4 — Solo lectura -->
    <div class="lr-section">
        <div class="lr-section-header">
            <div class="lr-section-num">4</div>
            <p class="lr-section-title">Observaciones y Acciones del Proveedor</p>
        </div>
        <div class="lr-section-body">
            <div class="lr-row">
                <div class="lr-field">
                    <label>Fecha de comunicación de respuesta</label>
                    <input type="date" id="fecres" readonly>
                </div>
            </div>
            <div class="lr-row">
                <div class="lr-field full">
                    <label>Respuesta del proveedor</label>
                    <textarea id="respuesta" rows="4" readonly placeholder="(Será completado por el proveedor en un plazo máximo de 30 días)"></textarea>
                </div>
            </div>
            <p class="lr-resp-nota">Esta sección es completada exclusivamente por el proveedor.</p>
        </div>
    </div>

    <!-- Nota legal -->
    <div class="lr-legal">
        &#9432; La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.<br>
        &#9432; El proveedor deberá dar respuesta en un plazo no mayor a <strong>30 días calendario</strong>, improrrogables.
    </div>

</form>
</div>

<!-- Toasts -->
<div class="lr-toast lr-toast-ok"  id="toast-ok">&#10003; &nbsp;¡Reclamación enviada correctamente!</div>
<div class="lr-toast lr-toast-err" id="toast-err">&#10005; &nbsp;Error al enviar. Intente nuevamente.</div>

<script src="jquery-1.12.3.min.js"></script>
<script src="as_form.js"></script>
<script>
function showToast(id) {
    var el = document.getElementById(id);
    el.style.display = 'block';
    setTimeout(function() { el.style.display = 'none'; }, 3500);
}

// ── Búsqueda DNI / RUC ────────────────────────────────────────
document.getElementById('btnFiltro').addEventListener('click', function() {
    var numfil = document.getElementById('numfil').value.trim();
    var ncarc  = numfil.length;
    var tipo   = ncarc === 8 ? 'dni' : (ncarc === 11 ? 'ruc' : '');
    var msg    = document.getElementById('dni-msg');

    if (!tipo) { msg.textContent = 'Ingrese 8 dígitos (DNI) o 11 (RUC).'; return; }
    msg.textContent = 'Buscando...';

    $.post('libroreclama.php', { opcion: 9, numfil: numfil, tipo: tipo }, function(resp) {
        try {
            var outer = JSON.parse(resp);
            var data  = JSON.parse(outer);
            if (data && data.res) {
                if (tipo === 'ruc') {
                    document.getElementById('nombre').value   = data.data.razon_social || '';
                    document.getElementById('domicilio').value = data.data.direccion && data.data.direccion.length > 4 ? data.data.direccion : '';
                } else {
                    var nom = ((data.data.nombres || '') + ' ' + (data.data.apellido_paterno || '') + ' ' + (data.data.apellido_materno || '')).trim();
                    document.getElementById('nombre').value   = nom;
                    document.getElementById('domicilio').value = '';
                }
                document.getElementById('dni').value = numfil;
                msg.textContent = '';
            } else {
                document.getElementById('dni').value = numfil;
                msg.textContent = 'No encontrado. Complete manualmente.';
            }
        } catch(e) {
            document.getElementById('dni').value = numfil;
            msg.textContent = 'Complete el formulario manualmente.';
        }
    }).fail(function() { msg.textContent = 'Error de conexión.'; });
});

// ── Menor de edad ─────────────────────────────────────────────
document.getElementById('menor').addEventListener('change', function() {
    var bloque = document.getElementById('bloque-apoderado');
    var inputs = bloque.querySelectorAll('input');
    bloque.style.display = this.checked ? 'block' : 'none';
    inputs.forEach(function(inp) { inp.disabled = !this.checked; }.bind(this));
});

// ── Envío ─────────────────────────────────────────────────────
document.getElementById('asForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = document.getElementById('btnEnviar');
    btn.disabled = true;
    btn.textContent = 'Enviando...';

    $.post('libroreclama.php', {
        opcion        : 11,
        fecharec      : document.getElementById('fecharec').value,
        numrecla      : document.getElementById('numrecla').value,
        negocio       : document.getElementById('negocio').value,
        tienda        : document.getElementById('tienda').value,
        nombre        : document.getElementById('nombre').value,
        domicilio     : document.getElementById('domicilio').value,
        dni           : document.getElementById('dni').value,
        telefono      : document.getElementById('telefono').value,
        email         : document.getElementById('email').value,
        menor         : document.querySelector('input[name=menor]:checked') ? 1 : 0,
        nombre_padre  : document.getElementById('nombre_padre').value,
        domicilio_padre: document.getElementById('domicilio_padre').value,
        dni_padre     : document.getElementById('dni_padre').value,
        telefono_padre: document.getElementById('telefono_padre').value,
        email_padre   : document.getElementById('email_padre').value,
        producto      : (document.querySelector('input[name=tipo_bien]:checked') || {}).value || '',
        monto         : document.getElementById('monto').value,
        descripcion   : document.getElementById('descripcion').value,
        reclamo       : (document.querySelector('input[name=tipo_reclamo]:checked') || {}).value || '',
        detalle       : document.getElementById('detalle').value,
        pedido        : document.getElementById('pedido').value
    }, function() {
        showToast('toast-ok');
        document.getElementById('asForm').reset();
        document.getElementById('bloque-apoderado').style.display = 'none';
        setTimeout(function() { location.reload(); }, 2200);
    }).fail(function() {
        showToast('toast-err');
        btn.disabled = false;
        btn.textContent = '✉ Enviar reclamación';
    });
});
</script>
</body>
</html>
