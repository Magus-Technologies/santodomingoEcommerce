<?php
/**
 * Script para revisar la estructura de la tabla usuarios
 * Acceder a: http://localhost/public_html/revisar_tabla_usuarios.php
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Revisar Tabla Usuarios</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 900px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
echo "h1 { color: #333; border-bottom: 3px solid #007bff; padding-bottom: 10px; }";
echo "h2 { color: #555; margin-top: 30px; }";
echo ".section { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #007bff; }";
echo "table { width: 100%; border-collapse: collapse; margin-top: 10px; }";
echo "th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }";
echo "th { background: #007bff; color: white; }";
echo "tr:hover { background: #f5f5f5; }";
echo "code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }";
echo ".info { background: #d1ecf1; border-left: 4px solid #17a2b8; padding: 15px; margin: 10px 0; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>🔍 Estructura de la Tabla Usuarios</h1>";

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "<p style='color: red;'><strong>❌ Error de conexión:</strong> " . $conn->connect_error . "</p>";
    } else {
        // Obtener estructura de la tabla
        echo "<h2>Columnas de la Tabla 'usuarios'</h2>";
        echo "<div class='section'>";
        
        $sql = "DESCRIBE usuarios";
        $result = $conn->query($sql);
        
        if ($result) {
            echo "<table>";
            echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Por Defecto</th><th>Extra</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><code>" . $row['Field'] . "</code></td>";
                echo "<td>" . $row['Type'] . "</td>";
                echo "<td>" . $row['Null'] . "</td>";
                echo "<td>" . $row['Key'] . "</td>";
                echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
                echo "<td>" . $row['Extra'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'><strong>Error:</strong> " . $conn->error . "</p>";
        }
        
        echo "</div>";
        
        // Mostrar algunos registros
        echo "<h2>Registros de Ejemplo</h2>";
        echo "<div class='section'>";
        
        $sql = "SELECT * FROM usuarios LIMIT 5";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $fields = $result->fetch_fields();
            echo "<table>";
            echo "<tr>";
            foreach ($fields as $field) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";
            
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . (strlen($value) > 50 ? substr($value, 0, 50) . "..." : $value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay registros en la tabla usuarios</p>";
        }
        
        echo "</div>";
        
        // Información adicional
        echo "<h2>Información de la Tabla</h2>";
        echo "<div class='info'>";
        echo "<strong>Nombre de la tabla:</strong> usuarios<br>";
        echo "<strong>Base de datos:</strong> " . DB_NAME . "<br>";
        echo "<strong>Total de registros:</strong> ";
        
        $count_result = $conn->query("SELECT COUNT(*) as total FROM usuarios");
        if ($count_result) {
            $count_row = $count_result->fetch_assoc();
            echo $count_row['total'] . "<br>";
        }
        
        echo "</div>";
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>❌ Excepción:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p style='text-align: center;'>";
echo "<a href='test_proyecto.php'>← Volver a Prueba Integral</a>";
echo "</p>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
