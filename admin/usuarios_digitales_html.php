<?php
    session_start();

    // Verificar la sesión y roles
    if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
        http_response_code(403); // Acceso prohibido
        die();
    }

    // Incluir archivos necesarios
    require "../utils/Tools.php";
    require_once "../utils/Conexion.php";

    // Establecer conexión a la base de datos
    $conexion = (new Conexion())->getConexion();

    $q = $_GET['q'] ?? '';
    $q = onlyTrim($q);
    $q = strtolower($q);
    $q = addslashes($q);
    // Construir la consulta SQL
    if (onlyTrim($q) == ''):
        $sql = "SELECT use_id AS id, CONCAT(IF(dni<>'',CONCAT(dni,' | '),''),nombres) AS text FROM usuarios ORDER BY nombres ASC";
    else:
        $sql = "SELECT use_id AS id, CONCAT(IF(dni<>'',CONCAT(dni,' | '),''),nombres) AS text FROM usuarios
                    WHERE (nombres LIKE '%$q%' OR email LIKE '%$q%')                  
                 ORDER BY nombres ASC";
    endif;

    $resultado = $conexion->query($sql);

    // Construir el array de resultados
    $usuarios = [['id' => '0', 'text' => '-- Todos --']];
    while ($row = $resultado->fetch_assoc()) {
        $usuarios[] = $row;
    }

    // Devolver resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($usuarios);
?>
