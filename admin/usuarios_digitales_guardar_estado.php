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
        $sql = "UPDATE cotizaciones SET estado_cotizacion = $objetoPost->estado WHERE id = $objetoPost->id ";
        $result = $conexion->query($sql);

        if ($result) :
            echo json_encode(['estatus' => true, 'id' => $objetoPost->id]);
        else:
            echo json_encode(['estatus' => false, 'mensaje' => $conexion->error]);

        endif;
    } else {
        header("Location: ../CYM/");
    }
?>