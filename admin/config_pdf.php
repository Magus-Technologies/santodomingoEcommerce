<?php
session_start();
require "../dao/Session.php";
$sessionModel = new Session;
$validate = $sessionModel->validateSession();
if (!isset($_SESSION['usuario']) || !in_array($validate['perfil'], ['admin'])) {
    header('Location: ../CYM/login.php'); exit;
}
require "../utils/Tools.php";
$tools = new Tools();
$dataConf = $tools->getConfiguracion();
$pdf = $dataConf['pdf_empresa'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuración PDF - Admin</title>
    <link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/assets/css/all.min.css">
    <link rel="stylesheet" href="../public/assets/css/themify-icons.css">
    <link rel="stylesheet" href="../public/assets/css/style.css">
    <style>
        :root { --rojo: #c7161d; --crema: #ece6a3; }
        body { background: #f4f6f9; }
        .page-header { background: var(--rojo); color: #fff; padding: 18px 28px; border-radius: 10px; margin-bottom: 24px; display: flex; align-items: center; gap: 14px; }
        .page-header h2 { margin: 0; font-size: 20px; font-weight: 700; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 14px rgba(0,0,0,0.08); }
        .card-header { background: var(--rojo); color: #fff; border-radius: 12px 12px 0 0 !important; padding: 14px 22px; font-weight: 600; font-size: 15px; }
        .card-header i { margin-right: 8px; color: var(--crema); }
        .form-label { font-size: 13px; font-weight: 600; color: #555; }
        .form-control { border-radius: 8px; font-size: 14px; }
        .form-control:focus { border-color: var(--rojo); box-shadow: 0 0 0 0.2rem rgba(199,22,29,0.15); }
        .btn-guardar { background: var(--rojo); color: #fff; border: none; border-radius: 8px; padding: 10px 28px; font-weight: 600; font-size: 14px; }
        .btn-guardar:hover { background: #a01218; color: #fff; }
        .logo-preview { max-height: 80px; border-radius: 6px; border: 1px solid #ddd; padding: 6px; background: #fff; }
        .preview-box { background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 20px; margin-top: 20px; }
        .preview-box h6 { color: var(--rojo); font-weight: 700; border-bottom: 2px solid var(--rojo); padding-bottom: 6px; margin-bottom: 14px; }
        .alert-success { border-radius: 8px; }
    </style>
</head>
<body>
<?php include "../fragment/nav_bar_admin.php"; ?>

<div class="container mt-4 mb-5">
    <div class="page-header">
        <i class="ti-file" style="font-size:22px; color:var(--crema);"></i>
        <h2>Configuración del PDF de Pedidos</h2>
    </div>

    <div id="alerta" style="display:none;" class="alert alert-success"><i class="ti-check"></i> Guardado correctamente.</div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><i class="ti-briefcase"></i>Datos de la Empresa</div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="pdf_empresa" value="<?= htmlspecialchars($pdf['empresa'] ?? 'Ace Advance Group S.A.C') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RUC</label>
                        <input type="text" class="form-control" id="pdf_ruc" maxlength="11" value="<?= htmlspecialchars($pdf['ruc'] ?? '20613235168') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="pdf_direccion" value="<?= htmlspecialchars($pdf['direccion'] ?? 'Av Bolivia 180 int 318 tercer piso, Lima, Peru') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Garantía (texto columna)</label>
                        <input type="text" class="form-control" id="pdf_garantia" value="<?= htmlspecialchars($pdf['garantia'] ?? '12 meses') ?>">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Logo del PDF</label><br>
                        <?php $logoActual = $pdf['logo'] ?? '../public/images/cym.png'; ?>
                        <img src="<?= htmlspecialchars($logoActual) ?>" id="logoPreview" class="logo-preview mb-2 d-block" alt="Logo actual">
                        <input type="file" class="form-control mt-2" id="logoFile" accept="image/*">
                        <small class="text-muted">Formatos: JPG, PNG. Máx 2MB.</small>
                    </div>
                    <button class="btn btn-guardar" onclick="guardar()"><i class="ti-save"></i> Guardar Configuración</button>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="preview-box">
                <h6><i class="ti-eye"></i> Vista Previa del encabezado PDF</h6>
                <div style="border:1px solid #ddd; border-radius:8px; padding:14px; background:#fafafa;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <div>
                            <img id="prevLogo" src="<?= htmlspecialchars($logoActual) ?>" style="max-height:60px; max-width:160px;">
                        </div>
                        <div style="text-align:right; border:2px solid #333; padding:8px 14px; border-radius:4px; min-width:160px;">
                            <div style="font-size:12px;"><strong>COTIZACION: #0001</strong></div>
                            <div style="font-size:12px; margin-top:4px;"><strong>RUC: <span id="prevRuc"><?= $pdf['ruc'] ?? '20613235168' ?></span></strong></div>
                        </div>
                    </div>
                    <div style="margin-top:10px; font-size:12px;">
                        <div><strong>Empresa:</strong> <span id="prevEmpresa"><?= htmlspecialchars($pdf['empresa'] ?? 'Ace Advance Group S.A.C') ?></span></div>
                        <div><strong>Dirección:</strong> <span id="prevDireccion"><?= htmlspecialchars($pdf['direccion'] ?? 'Av Bolivia 180 int 318 tercer piso, Lima, Peru') ?></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
// Preview en tiempo real
document.getElementById('pdf_empresa').addEventListener('input', function() {
    document.getElementById('prevEmpresa').textContent = this.value;
});
document.getElementById('pdf_ruc').addEventListener('input', function() {
    document.getElementById('prevRuc').textContent = this.value;
});
document.getElementById('pdf_direccion').addEventListener('input', function() {
    document.getElementById('prevDireccion').textContent = this.value;
});
document.getElementById('logoFile').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    if (file.size > 2 * 1024 * 1024) { alert('El logo no debe superar 2MB.'); this.value = ''; return; }
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('logoPreview').src = e.target.result;
        document.getElementById('prevLogo').src = e.target.result;
    };
    reader.readAsDataURL(file);
});

function guardar() {
    const logoFile = document.getElementById('logoFile').files[0];
    const formData = new FormData();
    formData.append('tipo', 'save_pdf_config');
    formData.append('empresa', document.getElementById('pdf_empresa').value);
    formData.append('ruc', document.getElementById('pdf_ruc').value);
    formData.append('direccion', document.getElementById('pdf_direccion').value);
    formData.append('garantia', document.getElementById('pdf_garantia').value);
    if (logoFile) formData.append('logo', logoFile);

    $.ajax({
        url: '../ajax/ajs_configuracione.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(resp) {
            resp = JSON.parse(resp);
            if (resp.res) {
                Swal.fire({ icon: 'success', title: 'Guardado', text: 'Configuración del PDF actualizada.', timer: 2000, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: resp.msg || 'No se pudo guardar.' });
            }
        }
    });
}
</script>
</body>
</html>
