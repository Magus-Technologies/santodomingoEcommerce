<?php

    require_once "../utils/Conexion.php";

    $conexion = (new Conexion())->getConexion();

    $perfil = $_POST['rol'] ?? '4';
    $reload = isset($_POST['rol']) ? 'usuarios_digitales.php' : 'usuarios.php';
    $sql = "insert into usuarios set
                            nombres='{$_POST['nombres']}', 
                            clave='{$_POST['clave']}',
                            email='{$_POST['email']}', 
                            idrol='$perfil',
                            token_reset=''";

    $conexion->query($sql);

    header("Location: $reload");






