<?php
/**
 * Script para crear usuario administrador de prueba
 * Acceder a: http://localhost/public_html/crear_admin_test.php
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Crear Admin de Prueba</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
echo "h1 { color: #333; border-bottom: 3px solid #dc3545; padding-bottom: 10px; }";
echo ".success { color: green; font-weight: bold; background: #d4edda; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".error { color: red; font-weight: bold; background: #f8d7da; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".info { color: #004085; background: #d1ecf1; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".credentials { background: #f9f9f9; padding: 15px; border-left: 4px solid #dc3545; margin: 15px 0; font-family: monospace; }";
echo "code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }";
echo "table { width: 100%; border-collapse: collapse; margin-top: 10px; }";
echo "th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }";
echo "th { background: #dc3545; color: white; }";
echo "a { color: #dc3545; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo ".warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>👨‍💼 Crear Usuario Administrador de Prueba</h1>";

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "<div class='error'>❌ Error de conexión: " . $conn->connect_error . "</div>";
    } else {
        // Datos del usuario administrador
        $email = 'admin@test.com';
        $password = 'admin123456';
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $nombre = 'Administrador';
        $apellido = 'Test';
        $documento = '87654321';
        $telefono = '999999998';
        $estado = 1;
        
        // Verificar si el usuario ya existe
        $check_sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            echo "<div class='info'>ℹ️ El usuario administrador ya existe en la base de datos</div>";
            
            // Mostrar datos del usuario existente
            $user = $check_result->fetch_assoc();
            echo "<div class='credentials'>";
            echo "<strong>Credenciales del Administrador Existente:</strong><br>";
            echo "Email: <code>" . $user['email'] . "</code><br>";
            echo "ID: <code>" . $user['use_id'] . "</code><br>";
            echo "Nombre: <code>" . $user['nombres'] . "</code><br>";
            echo "</div>";
        } else {
            // Crear el usuario administrador
            $insert_sql = "INSERT INTO usuarios (email, password, nombres, apellidos, documento, telefono, estado, fecha_registro) 
                          VALUES ('$email', '$password_hash', '$nombre', '$apellido', '$documento', '$telefono', $estado, NOW())";
            
            if ($conn->query($insert_sql) === TRUE) {
                $user_id = $conn->insert_id;
                
                echo "<div class='success'>✅ Usuario administrador creado exitosamente!</div>";
                
                echo "<div class='credentials'>";
                echo "<strong>Credenciales de Acceso (ADMIN):</strong><br><br>";
                echo "Email: <code>" . $email . "</code><br>";
                echo "Contraseña: <code>" . $password . "</code><br>";
                echo "ID Usuario: <code>" . $user_id . "</code><br>";
                echo "</div>";
                
                // Mostrar información adicional
                echo "<div class='info'>";
                echo "<strong>Información del Usuario:</strong><br>";
                echo "Nombre: " . $nombre . " " . $apellido . "<br>";
                echo "Documento: " . $documento . "<br>";
                echo "Teléfono: " . $telefono . "<br>";
                echo "Estado: Activo<br>";
                echo "Fecha de Registro: " . date('Y-m-d H:i:s') . "<br>";
                echo "</div>";
                
                echo "<div class='warning'>";
                echo "<strong>⚠️ Nota Importante:</strong><br>";
                echo "Este usuario tiene acceso de administrador. Asegúrate de cambiar la contraseña en producción.";
                echo "</div>";
            } else {
                echo "<div class='error'>❌ Error al crear el usuario: " . $conn->error . "</div>";
            }
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Excepción: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<p style='text-align: center;'>";
echo "<a href='crear_usuario_test.php'>← Crear Usuario Regular</a> | ";
echo "<a href='test_proyecto.php'>Volver a Prueba Integral →</a>";
echo "</p>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
