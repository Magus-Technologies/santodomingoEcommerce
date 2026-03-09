<?php
/**
 * Banners Promocionales - Consumidor de API
 * Carga banners promocionales desde la API de Laravel
 */

require "../config.php";

// Obtener banners desde la API
$apiUrl = API_URL . '/api/public/banners-promocionales';

try {
    $response = @file_get_contents($apiUrl);
    
    if ($response === false) {
        throw new Exception("No se pudo conectar con la API");
    }
    
    $data = json_decode($response, true);
    
    if (!isset($data['success']) || !$data['success']) {
        throw new Exception("Error en la respuesta de la API");
    }
    
    $banners = $data['data'] ?? [];
    
    // Filtrar banners activos
    $bannersActivos = array_filter($banners, function($banner) {
        return $banner['estado'] === '1';
    });
    
    // Tomar máximo 3 banners
    $bannersMostrar = array_slice($bannersActivos, 0, 3);
    
} catch (Exception $e) {
    // Si hay error, mostrar array vacío
    $bannersMostrar = [];
    error_log("Error cargando banners: " . $e->getMessage());
}
?>

<!-- START SECTION BANNER -->
<div class="section pb_20 small_pt">
    <div class="custom-container">
        <div class="row">
            <?php if (count($bannersMostrar) > 0): ?>
                <?php foreach ($bannersMostrar as $banner): ?>
                    <div class="col-md-4">
                        <div class="sale-banner mb-3 mb-md-4">
                            <a class="hover_effect1" href="<?= htmlspecialchars($banner['url'] ?? 'javascript:void(0)') ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?= htmlspecialchars($banner['imagen_url'] ?? $banner['imagen']) ?>" alt="Promoción" class="img-fluid">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-12">
                    <p class="text-center text-muted">No hay promociones disponibles</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->
