<?php
session_start();
require "../dao/ProductoDao.php";
require "../dao/GrupoCategoriaDao.php";
require "../utils/Tools.php";

$tools = new Tools();
$grupoCategoriaDao = new GrupoCategoriaDao();
$conexion = (new Conexion())->getConexion();
$productoDao= new ProductoDao();

$listaRamByCat = $productoDao->getDataRandonE();

$listaGrupos =$grupoCategoriaDao->getListaCate();
$dataConf = $tools->getConfiguracion();

$term = array_merge([
    'titulo'      => 'Términos y Condiciones',
    'subtitulo'   => 'Por favor lea detenidamente antes de utilizar nuestros servicios',
    'fecha'       => '',
    'intro'       => '',
    'heroFontSize'=> 3.2,
    'heroPaddingV'=> 28,
    'secciones'   => []
], $dataConf['terminos'] ?? []);

$heroFontSize = (float)($term['heroFontSize'] ?? 3.2);
$heroPaddingV = (int)($term['heroPaddingV'] ?? 80);
$heroPaddingB = $heroPaddingV + 20;

/**
 * Convierte texto plano con marcadores en HTML enriquecido.
 * Sintaxis:
 *   - línea normal   → <p>
 *   - "- texto"      → <ul><li> con círculo rojo
 *   - "1. texto"     → <ol><li> con número rojo
 *   - "! texto"      → recuadro destacado .tc-highlight
 *   línea vacía separa párrafos/listas
 */
function tcRenderContent(string $raw): string {
    $lines  = explode("\n", $raw);
    $html   = '';
    $inUl   = false;
    $inOl   = false;
    $buf    = '';   // acumulador de párrafo

    $flushP = function() use (&$buf, &$html) {
        $t = trim($buf);
        if ($t !== '') $html .= '<p>' . nl2br(htmlspecialchars($t)) . '</p>';
        $buf = '';
    };
    $closeList = function() use (&$inUl, &$inOl, &$html) {
        if ($inUl) { $html .= '</ul>'; $inUl = false; }
        if ($inOl) { $html .= '</ol>'; $inOl = false; }
    };

    foreach ($lines as $raw_line) {
        $line = rtrim($raw_line);

        // Línea vacía: cierra listas/párrafos abiertos
        if ($line === '') {
            $flushP();
            $closeList();
            continue;
        }

        // Recuadro destacado: "! texto"
        if (strncmp($line, '! ', 2) === 0) {
            $flushP(); $closeList();
            $html .= '<div class="tc-highlight">' . htmlspecialchars(substr($line, 2)) . '</div>';
            continue;
        }

        // Lista con viñeta: "- texto" o "* texto"
        if (preg_match('/^[-*] (.+)$/', $line, $m)) {
            $flushP();
            if ($inOl) { $html .= '</ol>'; $inOl = false; }
            if (!$inUl) { $html .= '<ul>'; $inUl = true; }
            $html .= '<li>' . htmlspecialchars($m[1]) . '</li>';
            continue;
        }

        // Lista numerada: "1. texto"
        if (preg_match('/^\d+\.\s+(.+)$/', $line, $m)) {
            $flushP();
            if ($inUl) { $html .= '</ul>'; $inUl = false; }
            if (!$inOl) { $html .= '<ol>'; $inOl = true; }
            $html .= '<li>' . htmlspecialchars($m[1]) . '</li>';
            continue;
        }

        // Párrafo normal
        $closeList();
        $buf .= ($buf ? "\n" : '') . $line;
    }

    $flushP();
    $closeList();
    return $html;
}

?><!DOCTYPE html>
<?php include '../fragment/head_general.php'?>

    <!-- SITE TITLE -->
    <title>Términos y Condiciones</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="../public/favi.png">
<!-- Animation CSS -->
<link rel="stylesheet" href="../public/assets/css/animate.css">
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="../public/assets/bootstrap/css/bootstrap.min.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Raleway:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="../public/assets/css/all.min.css">
<link rel="stylesheet" href="../public/assets/css/ionicons.min.css">
<link rel="stylesheet" href="../public/assets/css/themify-icons.css">
<link rel="stylesheet" href="../public/assets/css/linearicons.css">
<link rel="stylesheet" href="../public/assets/css/flaticon.css">
<link rel="stylesheet" href="../public/assets/css/simple-line-icons.css">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.css">
<link rel="stylesheet" href="../public/assets/owlcarousel/css/owl.theme.default.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="../public/assets/css/magnific-popup.css">
<!-- Slick CSS -->
<link rel="stylesheet" href="../public/assets/css/slick.css">
<link rel="stylesheet" href="../public/assets/css/slick-theme.css">
<!-- Style CSS -->
<link rel="stylesheet" href="../public/assets/css/style.css">
<link rel="stylesheet" href="../public/assets/css/responsive.css">
<!-- Terminos CSS -->
<link rel="stylesheet" href="../public/assets/css/pages/terminos.css">
    <link rel="stylesheet" href="../public/plugin/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .float{
            padding-top: 7px;
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:80px;
            background-color:#25d366;
            color:#FFF;
            border-radius:50px;
            text-align:center;
            font-size:30px;
            box-shadow: 2px 2px 3px #999;
            z-index:100;
        }
    </style>

</head>

<body>

<!-- PROGRESS BAR -->
<div id="tc-progress"></div>

<!-- LOADER -->
<div class="preloader">
    <div class="lds-ellipsis">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<!-- END LOADER -->

<!-- START HEADER -->
<?php include "../fragment/head_secon.php";?>
<!-- END HEADER -->

<!-- START MAIN CONTENT -->
<div class="main_content">

    <!-- HERO -->
    <section class="tc-hero" style="padding-top:<?= $heroPaddingV ?>px; padding-bottom:<?= $heroPaddingB ?>px;">
        <div class="tc-hero-inner">
            <div class="tc-badge">Documento Legal</div>
            <?php
            $partes = explode(' ', trim($term['titulo']), 2);
            $primera = $partes[0] ?? $term['titulo'];
            $resto   = $partes[1] ?? '';
            ?>
            <h1 style="font-size:<?= $heroFontSize ?>rem;"><?= htmlspecialchars($primera) ?><?php if ($resto): ?><span><?= htmlspecialchars($resto) ?></span><?php endif; ?></h1>
            <?php if ($term['subtitulo']): ?>
            <p class="tc-hero-sub"><?= htmlspecialchars($term['subtitulo']) ?></p>
            <?php else: ?>
            <p class="tc-hero-sub">Por favor lea detenidamente antes de utilizar nuestros servicios</p>
            <?php endif; ?>
            <?php if ($term['fecha']): ?>
            <p class="tc-hero-date">Última actualización: <?= htmlspecialchars($term['fecha']) ?></p>
            <?php endif; ?>
        </div>
        <div class="tc-wave">
            <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#fdf6ec"/>
            </svg>
        </div>
    </section>

    <?php if (!empty($term['secciones'])): ?>
    <!-- TABLE OF CONTENTS -->
    <div class="tc-toc-wrap">
        <div class="tc-toc-card">
            <p class="tc-toc-title">Índice de Contenido</p>
            <?php foreach ($term['secciones'] as $i => $sec): ?>
            <a href="#tc-s<?= $i ?>" class="tc-toc-item">
                <span class="tc-toc-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                <?= htmlspecialchars($sec['titulo'] ?? '') ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- SECTIONS -->
    <div class="tc-main">

        <?php if ($term['intro']): ?>
        <div class="tc-intro">
            <p><?= nl2br(htmlspecialchars($term['intro'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if (empty($term['secciones'])): ?>
        <div class="tc-empty">
            <i class="fa fa-file-alt fa-3x mb-3 d-block"></i>
            Contenido en preparación.
        </div>
        <?php else: ?>
        <?php foreach ($term['secciones'] as $i => $sec): ?>
        <div class="tc-section" id="tc-s<?= $i ?>">
            <div class="tc-section-header">
                <div class="tc-section-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
                <h2 class="tc-section-title"><?= htmlspecialchars($sec['titulo'] ?? '') ?></h2>
            </div>
            <div class="tc-section-body">
                <?= tcRenderContent($sec['contenido'] ?? '') ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

    </div>

</div>
<!-- END MAIN CONTENT -->

<!-- START FOOTER -->
<?php include "../fragment/footer_gen.php"?>
<!-- END FOOTER -->

<!-- BACK TO TOP -->
<button id="tc-back-top" title="Volver arriba" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8 12V4M4 7.5L8 4L12 7.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</button>

<a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

<!-- Latest jQuery -->
<script src="../public/assets/js/jquery-1.12.4.min.js"></script>
<!-- popper min js -->
<script src="../public/assets/js/popper.min.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="../public/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="../public/assets/owlcarousel/js/owl.carousel.min.js"></script>
<!-- magnific-popup min js  -->
<script src="../public/assets/js/magnific-popup.min.js"></script>
<!-- waypoints min js  -->
<script src="../public/assets/js/waypoints.min.js"></script>
<!-- parallax js  -->
<script src="../public/assets/js/parallax.js"></script>
<!-- countdown js  -->
<script src="../public/assets/js/jquery.countdown.min.js"></script>
<!-- imagesloaded js -->
<script src="../public/assets/js/imagesloaded.pkgd.min.js"></script>
<!-- isotope min js -->
<script src="../public/assets/js/isotope.min.js"></script>
<!-- jquery.dd.min js -->
<script src="../public/assets/js/jquery.dd.min.js"></script>
<!-- slick js -->
<script src="../public/assets/js/slick.min.js"></script>
<!-- elevatezoom js -->
<script src="../public/assets/js/jquery.elevatezoom.js"></script>
<!-- scripts js -->
<script src="../public/assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="../public/js/tools.js"></script>
<script src="../public/js/main.js"></script>
<script src="../public/plugin/sweetalert2/vue-swal.js"></script>
<script>
(function() {
    // Progress bar
    var bar = document.getElementById('tc-progress');
    var btn = document.getElementById('tc-back-top');
    window.addEventListener('scroll', function() {
        var total = document.body.scrollHeight - window.innerHeight;
        if (total > 0) bar.style.width = (window.scrollY / total * 100) + '%';
        window.scrollY > 300 ? btn.classList.add('tc-show') : btn.classList.remove('tc-show');
    });

    // Scroll reveal
    var sections = document.querySelectorAll('.tc-section');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, { threshold: 0.1 });
        sections.forEach(function(s) { obs.observe(s); });
    } else {
        sections.forEach(function(s) { s.classList.add('visible'); });
    }
})();
</script>
</body>
</html>
