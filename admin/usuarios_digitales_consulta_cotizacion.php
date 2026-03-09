<?php
    session_start();


    require "../dao/Session.php";
    require "../utils/Tools.php";
    require_once "../utils/Conexion.php";


    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();
    if ($validate['perfil'] == 'usuarios digital' or $validate['perfil'] == 'admin') {
        $conexion = (new Conexion())->getConexion();
        $objetoPost = new stdClass();

        foreach ($_POST as $clave => $valor) {
            $objetoPost->$clave = $valor;
        }


        $sql = "SELECT * FROM cotizaciones WHERE id = $objetoPost->id ";
        $result = $conexion->query($sql);
        $registro = $result->fetch_assoc();
        echo json_encode($registro);
    } else {
        header("Location: ../CYM/");
    }
?>