<?php
session_start();

require "../config.php";
require "../utils/Tools.php";

$tools = new Tools();
$dataConf = $tools->getConfiguracion();

// Obtener marcas activas desde la API de facturación
try {
    $response = @file_get_contents(API_URL . '/api/public/marcas');
    if ($response === false) throw new Exception("No se pudo conectar con la API");
    $data = json_decode($response, true);
    $marcas = ($data['success'] ?? false) ? ($data['data'] ?? []) : [];
} catch (Exception $e) {
    $marcas = [];
    error_log("Error cargando marcas: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<?php include '../fragment/head_general.php' ?>
<title>Marcas - VIÑASANTODOMINGO</title>
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
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.default.min.css">
<link rel="stylesheet" href="../public/assets/css/magnific-popup.css">
<link rel="stylesheet" href="../public/assets/css/slick.css">
<link rel="stylesheet" href="../public/assets/css/slick-theme.css">
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/responsive.css">
<style>
    .marca-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background-color: #fff;
        margin-bottom: 20px;
        padding: 20px 15px;
        text-align: center;
        transition: box-shadow 0.2s;
        display: block;
        color: inherit;
        text-decoration: none;
    }
    .marca-card:hover {
        box-shadow: 0 4px 18px rgba(0,0,0,0.13);
        text-decoration: none;
        color: inherit;
    }
    .marca-card img {
        max-width: 120px;
        max-height: 70px;
        object-fit: contain;
        display: block;
        margin: 0 auto 12px;
    }
    .marca-card .sin-logo {
        width: 120px;
        height: 70px;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 6px;
        color: #bbb;
        font-size: 12px;
    }
    .marca-card h6 {
        font-weight: 600;
        font-size: 14px;
        margin: 0;
    }
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
<?php include "../fragment/head_secon.php"; ?>
<!-- END HEADER -->

<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini" style="padding-bottom:20px;padding-top:20px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Marcas</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Marcas</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START MAIN CONTENT -->
<div class="main_content">
<div class="section" style="padding-top:30px;padding-bottom:40px;">
    <div class="container">

        <?php if (empty($marcas)): ?>
            <div class="text-center text-muted py-5">
                <p>No hay marcas disponibles en este momento.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($marcas as $marca): ?>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="shop-list-mrc.php?grp=&mrc=<?= htmlspecialchars($marca['cod_marca']) ?>" class="marca-card">
                            <?php if (!empty($marca['imagen_url'])): ?>
                                <img src="<?= htmlspecialchars($marca['imagen_url']) ?>"
                                     alt="<?= htmlspecialchars($marca['nombre_marca']) ?>">
                            <?php else: ?>
                                <div class="sin-logo">Sin logo</div>
                            <?php endif; ?>
                            <h6><?= htmlspecialchars($marca['nombre_marca']) ?></h6>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>
</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
<?php include "../fragment/footer_gen.php" ?>
<!-- END FOOTER -->

<a href="#" class="scrollup" style="display:none;"><i class="ion-ios-arrow-up"></i></a>

<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<script>$(".preloader").hide()</script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../public/assets/owlcarousel/js/owl.carousel.min.js"></script>
<script src="../public/assets/js/magnific-popup.min.js"></script>
<script src="../public/assets/js/waypoints.min.js"></script>
<script src="../public/assets/js/parallax.js"></script>
<script src="../public/assets/js/jquery.countdown.min.js"></script>
<script src="../public/assets/js/imagesloaded.pkgd.min.js"></script>
<script src="../public/assets/js/isotope.min.js"></script>
<script src="../public/assets/js/slick.min.js"></script>
<script src="../public/assets/js/scripts.js"></script>
<script src="../public/js/main.js?v=8"></script>

</body>
</html>
