<?php
/**
 * Script para crear usuario administrador del Ecommerce
 * USO: Acceder una sola vez desde el navegador, luego ELIMINAR este archivo.
 * URL: http://localhost/demo/public_html/crear_admin.php
 */
require_once "utils/Conexion.php";

// Configura aquí las credenciales del admin
$nombres = "Administrador";
$email   = "admin@vinaasantodomingo.com";
$clave   = "Admin2024!";
$perfil  = "admin"; // opciones: admin | vendedor | usuarios digital | usuario

$conexion = (new Conexion())->getConexion();

// Verificar si ya existe
$check = $conexion->query("SELECT use_id FROM usuarios WHERE email = '$email'");
if ($check->num_rows > 0) {
    echo "<div style='font-family:monospace;padding:20px;background:#fff3cd;border:1px solid #ffc107;'>
            Ya existe un usuario con el email <strong>$email</strong>.<br>
            Si deseas cambiar la clave, edita directamente en la BD.
          </div>";
    exit;
}

$stmt = $conexion->prepare("INSERT INTO usuarios VALUES (NULL, ?, ?, ?, ?, '')");
$stmt->bind_param("ssss", $nombres, $email, $clave, $perfil);

if ($stmt->execute()) {
    $id = $stmt->insert_id;
    $stmt->close();
    echo "<div style='font-family:monospace;padding:20px;background:#d4edda;border:1px solid #28a745;'>
            Usuario administrador creado correctamente.<br><br>
            <strong>ID:</strong> $id<br>
            <strong>Nombre:</strong> $nombres<br>
            <strong>Email:</strong> $email<br>
            <strong>Clave:</strong> $clave<br>
            <strong>Perfil:</strong> $perfil<br><br>
            <span style='color:red;font-weight:bold;'>ELIMINA ESTE ARCHIVO del servidor.</span>
          </div>";
} else {
    echo "<div style='font-family:monospace;padding:20px;background:#f8d7da;border:1px solid #dc3545;'>
            Error al crear el usuario: " . $conexion->error . "
          </div>";
}
