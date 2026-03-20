<?php
if (!isset($dataConf)) {
    require_once __DIR__ . '/../utils/Tools.php';
    $dataConf = (new Tools())->getConfiguracion();
}
$n = array_merge([
    'titulo' => 'Sobre Nosotros', 'subtitulo' => 'Conoce nuestra historia',
    'descripcion' => '', 'imagen_principal' => '',
    'cta_texto' => 'Ver productos', 'cta_url' => 'shop-list-prod.php',
    'historia' => '',
    'mision' => '', 'mision_icono' => 'fas fa-rocket',
    'vision' => '', 'vision_icono' => 'fas fa-eye',
    'valores' => '', 'valores_icono' => 'fas fa-star',
    'stats' => [], 'equipo' => []
], $dataConf['nosotros'] ?? []);
?>
<style>
/* ── HERO ── */
.nos-hero {
    position: relative;
    background: linear-gradient(135deg, #c7161d 0%, #6b0009 100%);
    color: #fff;
    padding: 90px 0 70px;
    overflow: hidden;
    text-align: center;
}
.nos-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.nos-hero-content { position: relative; z-index: 1; }
.nos-hero h1 { font-size: 3rem; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 14px; }
.nos-hero p { font-size: 1.15rem; opacity: .85; max-width: 540px; margin: 0 auto 28px; }
.nos-hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: #ece6a3;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 6px 18px;
    border-radius: 20px;
    margin-bottom: 20px;
}
.nos-hero-wave {
    position: absolute;
    bottom: -1px; left: 0; width: 100%;
}

/* ── STATS ── */
.nos-stats-wrap { background: #fff; padding: 0; }
.nos-stat-item {
    padding: 40px 20px;
    text-align: center;
    border-right: 1px solid #f0f0f0;
    transition: background .2s;
}
.nos-stat-item:last-child { border-right: none; }
.nos-stat-item:hover { background: #fdf5f5; }
.nos-stat-item i { font-size: 2rem; color: #c7161d; margin-bottom: 10px; display: block; }
.nos-stat-item .valor { font-size: 2.2rem; font-weight: 800; color: #232323; line-height: 1; }
.nos-stat-item .etiq { font-size: 12px; color: #888; margin-top: 6px; text-transform: uppercase; letter-spacing: .5px; }

/* ── DESCRIPCIÓN ── */
.nos-desc { padding: 80px 0; }
.nos-desc-img {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 20px 20px 0 #f5e0e0, 0 4px 30px rgba(199,22,29,.12);
}
.nos-desc-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.nos-desc-tag {
    display: inline-block;
    background: #fdf0f0;
    color: #c7161d;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 14px;
}
.nos-desc-text { font-size: 15px; color: #555; line-height: 1.9; }
.nos-desc h2 { font-size: 2rem; font-weight: 800; color: #1a1a1a; margin-bottom: 16px; }
.nos-btn {
    display: inline-block;
    margin-top: 22px;
    background: #c7161d;
    color: #fff;
    font-weight: 700;
    padding: 13px 30px;
    border-radius: 30px;
    text-decoration: none;
    font-size: 14px;
    transition: .2s;
    box-shadow: 0 4px 14px rgba(199,22,29,.35);
}
.nos-btn:hover { background: #a01018; color: #fff; transform: translateY(-1px); }

/* ── MVV ── */
.nos-mvv { padding: 80px 0; background: #f8f9fa; }
.nos-mvv-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px 28px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    height: 100%;
    border-top: 4px solid transparent;
    transition: border-color .2s, transform .2s;
}
.nos-mvv-card:hover { border-top-color: #c7161d; transform: translateY(-4px); }
.nos-mvv-icon {
    width: 70px; height: 70px;
    border-radius: 50%;
    background: #fdf0f0;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.nos-mvv-icon i { font-size: 1.8rem; color: #c7161d; }
.nos-mvv-card h5 { font-weight: 800; font-size: 1.1rem; color: #1a1a1a; margin-bottom: 12px; }
.nos-mvv-card p { color: #777; font-size: 14px; line-height: 1.8; margin: 0; }

/* ── EQUIPO ── */
.nos-equipo { padding: 80px 0; }
.miembro-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px 20px 24px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    transition: transform .2s;
}
.miembro-card:hover { transform: translateY(-5px); }
.miembro-foto-wrap {
    position: relative;
    width: 100px; height: 100px;
    margin: 0 auto 18px;
}
.miembro-foto-wrap img {
    width: 100px; height: 100px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 0 0 3px #c7161d;
}
.miembro-avatar {
    width: 100px; height: 100px;
    border-radius: 50%;
    background: #f0f0f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: #ccc;
    box-shadow: 0 0 0 3px #e9ecef;
}
.miembro-card h6 { font-weight: 800; color: #1a1a1a; margin-bottom: 4px; font-size: 15px; }
.miembro-card .cargo {
    font-size: 11px; color: #c7161d; font-weight: 700;
    text-transform: uppercase; letter-spacing: .8px; margin-bottom: 12px;
}
.miembro-card p { font-size: 13px; color: #888; line-height: 1.6; margin: 0; }

/* ── CTA ── */
.nos-cta {
    background: linear-gradient(135deg, #c7161d, #8a0009);
    color: #fff; padding: 70px 0; text-align: center;
    position: relative; overflow: hidden;
}
.nos-cta::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.nos-cta-content { position: relative; z-index: 1; }
.nos-cta h3 { font-size: 2rem; font-weight: 800; margin-bottom: 12px; }
.nos-cta p { opacity: .85; margin-bottom: 28px; font-size: 15px; }
.nos-cta a {
    background: #fff; color: #c7161d;
    font-weight: 800; padding: 14px 36px;
    border-radius: 30px; text-decoration: none;
    font-size: 15px; display: inline-block;
    transition: .2s; box-shadow: 0 4px 20px rgba(0,0,0,.2);
}
.nos-cta a:hover { background: #ece6a3; color: #8a0009; transform: translateY(-2px); }

/* ── SECTION TITLE ── */
.nos-section-title { text-align: center; margin-bottom: 50px; }
.nos-section-title .badge-tag {
    display: inline-block; background: #fdf0f0; color: #c7161d;
    font-size: 11px; font-weight: 700; letter-spacing: 2px;
    text-transform: uppercase; padding: 5px 14px;
    border-radius: 20px; margin-bottom: 12px;
}
.nos-section-title h3 { font-size: 2rem; font-weight: 800; color: #1a1a1a; margin-bottom: 10px; }
.nos-section-title p { color: #888; font-size: 14px; max-width: 500px; margin: 0 auto; }
.nos-divider { width: 50px; height: 4px; background: #c7161d; border-radius: 2px; margin: 12px auto 0; }
</style>

<!-- HERO -->
<div class="nos-hero">
    <div class="container nos-hero-content">
        <span class="nos-hero-badge"><i class="fas fa-building mr-1"></i> Quiénes Somos</span>
        <h1><?= htmlspecialchars($n['titulo']) ?></h1>
        <p><?= htmlspecialchars($n['subtitulo']) ?></p>
    </div>
    <svg class="nos-hero-wave" viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg">
        <path fill="#ffffff" fill-opacity="1" d="M0,32L48,37.3C96,43,192,53,288,53.3C384,53,480,43,576,37.3C672,32,768,32,864,37.3C960,43,1056,53,1152,53.3C1248,53,1344,43,1392,37.3L1440,32L1440,60L0,60Z"/>
    </svg>
</div>

<!-- STATS -->
<?php if (!empty($n['stats'])): ?>
<div class="nos-stats-wrap" style="border-bottom:1px solid #f0f0f0;">
    <div class="container-fluid px-0">
        <div class="row no-gutters">
            <?php foreach ($n['stats'] as $stat): ?>
            <div class="col-6 col-md">
                <div class="nos-stat-item">
                    <i class="<?= htmlspecialchars($stat['icono'] ?? 'fas fa-star') ?>"></i>
                    <div class="valor"><?= htmlspecialchars($stat['valor'] ?? '') ?></div>
                    <div class="etiq"><?= htmlspecialchars($stat['label'] ?? '') ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- DESCRIPCIÓN + IMAGEN -->
<?php if ($n['descripcion'] || $n['imagen_principal'] || $n['historia']): ?>
<div class="nos-desc">
    <div class="container">
        <div class="row align-items-center" style="gap: 0;">
            <?php if ($n['imagen_principal']): ?>
            <div class="col-md-5 mb-5 mb-md-0">
                <div class="nos-desc-img" style="height:380px;">
                    <img src="<?= htmlspecialchars($n['imagen_principal']) ?>" alt="Nosotros">
                </div>
            </div>
            <div class="col-md-7 pl-md-5">
            <?php else: ?>
            <div class="col-12">
            <?php endif; ?>
                <span class="nos-desc-tag"><i class="fas fa-history mr-1"></i> Nuestra Historia</span>
                <h2><?= htmlspecialchars($n['titulo']) ?></h2>
                <?php if ($n['descripcion']): ?>
                <p class="nos-desc-text"><?= nl2br(htmlspecialchars($n['descripcion'])) ?></p>
                <?php endif; ?>
                <?php if ($n['historia']): ?>
                <div class="nos-desc-text mt-3"><?= $n['historia'] ?></div>
                <?php endif; ?>
                <?php if ($n['cta_texto'] && $n['cta_url']): ?>
                <a href="<?= htmlspecialchars($n['cta_url']) ?>" class="nos-btn">
                    <?= htmlspecialchars($n['cta_texto']) ?> <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- MISIÓN / VISIÓN / VALORES -->
<?php if ($n['mision'] || $n['vision'] || $n['valores']): ?>
<div class="nos-mvv">
    <div class="container">
        <div class="nos-section-title">
            <span class="badge-tag"><i class="fas fa-bullseye mr-1"></i> Principios</span>
            <h3>Misión, Visión y Valores</h3>
            <div class="nos-divider"></div>
        </div>
        <div class="row">
            <?php if ($n['mision']): ?>
            <div class="col-md-4 mb-4">
                <div class="nos-mvv-card">
                    <div class="nos-mvv-icon"><i class="<?= htmlspecialchars($n['mision_icono']) ?>"></i></div>
                    <h5>Misión</h5>
                    <p><?= nl2br(htmlspecialchars($n['mision'])) ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($n['vision']): ?>
            <div class="col-md-4 mb-4">
                <div class="nos-mvv-card">
                    <div class="nos-mvv-icon"><i class="<?= htmlspecialchars($n['vision_icono']) ?>" style="color:#343a40;"></i></div>
                    <h5>Visión</h5>
                    <p><?= nl2br(htmlspecialchars($n['vision'])) ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($n['valores']): ?>
            <div class="col-md-4 mb-4">
                <div class="nos-mvv-card">
                    <div class="nos-mvv-icon"><i class="<?= htmlspecialchars($n['valores_icono']) ?>"></i></div>
                    <h5>Valores</h5>
                    <p><?= nl2br(htmlspecialchars($n['valores'])) ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- EQUIPO -->
<?php if (!empty($n['equipo'])): ?>
<div class="nos-equipo">
    <div class="container">
        <div class="nos-section-title">
            <span class="badge-tag"><i class="fas fa-users mr-1"></i> Equipo</span>
            <h3>Nuestro Equipo</h3>
            <div class="nos-divider"></div>
        </div>
        <div class="row justify-content-center">
            <?php foreach ($n['equipo'] as $m): ?>
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="miembro-card">
                    <div class="miembro-foto-wrap">
                        <?php if (!empty($m['imagen'])): ?>
                            <img src="<?= htmlspecialchars($m['imagen']) ?>" alt="<?= htmlspecialchars($m['nombre'] ?? '') ?>">
                        <?php else: ?>
                            <div class="miembro-avatar"><i class="fas fa-user"></i></div>
                        <?php endif; ?>
                    </div>
                    <h6><?= htmlspecialchars($m['nombre'] ?? '') ?></h6>
                    <div class="cargo"><?= htmlspecialchars($m['cargo'] ?? '') ?></div>
                    <?php if (!empty($m['descripcion'])): ?>
                    <p><?= htmlspecialchars($m['descripcion']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- CTA -->
<?php if ($n['cta_texto'] && $n['cta_url']): ?>
<div class="nos-cta">
    <div class="nos-cta-content">
        <h3>¿Listo para conocer nuestros productos?</h3>
        <p>Encuentra todo lo que necesitas en nuestra tienda.</p>
        <a href="<?= htmlspecialchars($n['cta_url']) ?>">
            <?= htmlspecialchars($n['cta_texto']) ?> <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>
<?php endif; ?>
