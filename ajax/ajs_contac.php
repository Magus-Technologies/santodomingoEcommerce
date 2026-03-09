<?php

$tipo = $_POST['tipo'];

if ($tipo == 's'){
    echo file_get_contents("../fragment/content_contac.php");
}elseif ($tipo=='i'){
    $file = fopen("../fragment/content_contac.php", "w");
    fwrite($file, $_POST['datai']. PHP_EOL);
    fclose($file);
}