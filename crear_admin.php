<?php
/**
 * Script para crear usuario administrador con acceso total
 * Acceder a: http://localhost/public_html/crear_admin.php
 */

require_once 'config/database.php';

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Crear Administrador</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }";
echo "h1 { color: #333; border-bottom: 3px solid #28a745; padding-bottom: 10px; }";
echo ".success { color: green; font-weight: bold; background: #d4edda; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".error { color: red; font-weight: bold; background: #f8d7da; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".info { color: #004085; background: #d1ecf1; padding: 15px; border-radius: 4px; margin: 10px 0; }";
echo ".credentials { background: #f9f9f9; padding: 15px; border-left: 4px solid #28a745; margin: 15px 0; font-family: monospace; }";
echo "code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; }";
echo "a { color: #28a745; text-decoration: none; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>👨‍💼 Crear Administrador con Acceso Total</h1>";

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        echo "<div class='error'>❌ Error de conexión: " . $conn->connect_error . "</div>";
    } else {
        // Datos del administrador
        $email = 'test@test.com';
        $clave = 'test123456';
        $nombres = 'Usuario Test';
        $perfil = 'admin';
        
        // Verificar si el usuario ya existe
        $check_sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result->num_rows > 0) {
            echo "<div class='info'>ℹ️ El usuario ya existe en la base de datos</div>";
            
            $user = $check_result->fetch_assoc();
            echo "<div class='credentials'>";
            echo "<strong>Credenciales del Usuario Existente:</strong><br>";
            echo "Email: <code>" . $user['email'] . "</code><br>";
            echo "Clave: <code>" . $user['clave'] . "</code><br>";
            echo "Perfil: <code>" . $user['perfil'] . "</code><br>";
            echo "ID: <code>" . $user['use_id'] . "</code><br>";
            echo "</div>";
        } else {
            // Crear el usuario administrador
            $insert_sql = "INSERT INTO usuarios (nombres, email, clave, perfil) 
                          VALUES ('$nombres', '$email', '$clave', '$perfil')";
            
            if ($conn->query($insert_sql) === TRUE) {
                $user_id = $conn->insert_id;
                
                echo "<div class='success'>✅ Usuario administrador creado exitosamente!</div>";
                
                echo "<div class='credentials'>";
                echo "<strong>Credenciales de Acceso (ADMIN):</strong><br><br>";
                echo "Email: <code>" . $email . "</code><br>";
                echo "Contraseña: <code>" . $clave . "</code><br>";
                echo "Perfil: <code>" . $perfil . "</code><br>";
                echo "ID Usuario: <code>" . $user_id . "</code><br>";
                echo "</div>";
                
                echo "<div class='info'>";
                echo "<strong>✅ Acceso Total Configurado:</strong><br>";
                echo "• Panel Administrativo<br>";
                echo "• Gestión de Productos<br>";
                echo "• Gestión de Pedidos<br>";
                echo "• Gestión de Usuarios<br>";
                echo "• Reportes y Estadísticas<br>";
                echo "• Configuración del Sistema<br>";
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
echo "<a href='CYM/login.php'>Ir a Login →</a>";
echo "</p>";
echo "</div>";
echo "</body>";
echo "</html>";
?>
