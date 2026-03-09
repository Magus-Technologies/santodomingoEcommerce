<?php
    session_start();


    require "../dao/Session.php";
    $sessionModel = new Session;
    $validate = $sessionModel->validateSession();

    if ($validate['perfil'] == 'usuarios digital' or $validate['perfil'] == 'admin') {

        if (strlen($_POST['doc']) == 8) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://magustechnologies.com:9091/consulta/dni2/' . $_POST['doc']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data, true);
            $data["data"]["nombre"] = $data["data"]["nombres"] . " " . $data["data"]["apellido_paterno"] . " " . $data["data"]["apellido_materno"];
            echo json_encode($data);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://magustechnologies.com/api/consulta/ruc/' . $_POST['doc']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            echo json_encode($data);
        }
    } else {
        header("Location: ../CYM/");
    }
?>