<?php

$urlDNI = 'http://magustechnologies.com:9091/consulta/dni2/';
$urlRUC = 'https://magustechnologies.com/api/consulta/ruc/';

if ($_POST['tipo'] == 'dni') {
    $url = $urlDNI . $_POST['doc'];
    //echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
} else if ($_POST['tipo'] == 'ruc') {
    $url = $urlRUC . $_POST['doc'];
    /* echo $url; */

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
}

echo json_encode($data);
