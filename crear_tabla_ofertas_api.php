<?php
/**
 * Script para crear la tabla ofertas_productos_api sin restricción de clave foránea
 */

require_once __DIR__ . '/config/database.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset(DB_CHARSET);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

echo "=== CREANDO TABLA PARA OFERTAS DE API ===\n\n";

// Crear tabla sin restricción de clave foránea
$sql = "CREATE TABLE IF NOT EXISTS ofertas_productos_api (
    id_ofer INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    precio_oferta DECIMAL(10, 2) NOT NULL,
    cantidad_stock INT NOT NULL,
    stock_actual INT,
    fecha_termino DATE NOT NULL,
    estado INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql)) {
    echo "✓ Tabla 'ofertas_productos_api' creada exitosamente\n";
} else {
    echo "✗ Error al crear tabla: " . $conn->error . "\n";
}

// Verificar estructura
$result = $conn->query("DESCRIBE ofertas_productos_api");
if ($result) {
    echo "\nEstructura de la tabla:\n";
    while ($row = $result->fetch_assoc()) {
        echo "  - {$row['Field']}: {$row['Type']}\n";
    }
}

$conn->close();
echo "\n=== COMPLETADO ===\n";
?>
