<?php
/**
 * Script para crear usuario de prueba con acceso total
 * Acceder a: http://localhost/public_html/crear_usuario_test.php
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Crear Usuario de Prueba</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
echo "h1 { color: #333; border-bottom: 3px solid #28a745; padding-bottom: 10px; }";
echo ".success { color: green; font-weight: bold; background: #d4edda; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".error { color: red; font-weight: bold; background: #f8d7da; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".info { color: #004085; background: #d1ecf1; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".credentials { background: #f9f9f9; padding: 15px; border-left: 4px solid #28a745; margin: 15px 0; font-family: monospace; }";
echo "code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }";
echo "table { width: 100%; border-collapse: collapse; margin-top: 10px; }";
echo "th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }";
echo "th { background: #28a745; color: white; }";
echo "a { color: #28a745; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>👤 Crear Usuario de Prueba</h1>";

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "<div class='error'>❌ Error de conexión: " . $conn->connect_error . "</div>";
    } else {
        // Datos del usuario de prueba
        $email = 'test@test.com';
        $password = 'test123456';
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $nombre = 'Usuario Test';
        $apellido = 'Test';
        $documento = '12345678';
        $telefono = '999999999';
        $estado = 1;
        
        // Verificar si el usuario ya existe
        $check_sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            echo "<div class='info'>ℹ️ El usuario ya existe en la base de datos</div>";
            
            // Mostrar datos del usuario existente
            $user = $check_result->fetch_assoc();
            echo "<div class='credentials'>";
            echo "<strong>Credenciales del Usuario Existente:</strong><br>";
            echo "Email: <code>" . $user['email'] . "</code><br>";
            echo "ID: <code>" . $user['use_id'] . "</code><br>";
            echo "Nombre: <code>" . $user['nombres'] . "</code><br>";
            echo "</div>";
        } else {
            // Crear el usuario
            $insert_sql = "INSERT INTO usuarios (email, password, nombres, apellidos, documento, telefono, estado, fecha_registro) 
                          VALUES ('$email', '$password_hash', '$nombre', '$apellido', '$documento', '$telefono', $estado, NOW())";
            
            if ($conn->query($insert_sql) === TRUE) {
                $user_id = $conn->insert_id;
                
                echo "<div class='success'>✅ Usuario de prueba creado exitosamente!</div>";
                
                echo "<div class='credentials'>";
                echo "<strong>Credenciales de Acceso:</strong><br><br>";
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
            } else {
                echo "<div class='error'>❌ Error al crear el usuario: " . $conn->error . "</div>";
            }
        }
        
        // Mostrar tabla de usuarios
        echo "<h2>Usuarios en la Base de Datos</h2>";
        $users_sql = "SELECT use_id, email, nombres, apellidos, documento, estado, fecha_registro FROM usuarios LIMIT 10";
        $users_result = $conn->query($users_sql);
        
        if ($users_result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Email</th><th>Nombre</th><th>Documento</th><th>Estado</th><th>Registro</th></tr>";
            
            while ($row = $users_result->fetch_assoc()) {
                $estado_badge = $row['estado'] == 1 ? '✅ Activo' : '❌ Inactivo';
                echo "<tr>";
                echo "<td>" . $row['use_id'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['nombres'] . " " . $row['apellidos'] . "</td>";
                echo "<td>" . $row['documento'] . "</td>";
                echo "<td>" . $estado_badge . "</td>";
                echo "<td>" . $row['fecha_registro'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay usuarios en la base de datos</p>";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Excepción: " . $e->getMessage() . "</div>";
}

echo "<hr>";
echo "<p style='text-align: center;'>";
echo "<a href='test_proyecto.php'>← Volver a Prueba Integral</a> | ";
echo "<a href='CYM/login.php'>Ir a Login →</a>";
echo "</p>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
