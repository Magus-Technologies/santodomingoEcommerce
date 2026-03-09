00  m                                i<?php
 /*$ch = curl_init();
 $v1_validado  = 'PRUEBA';
 $v2_validado = 'LOCAL';
 curl_setopt($ch, CURLOPT_URL, "https://magustechnologies.com/factura_cgs/datosrec.php?variable1=" . $v1_validado . "&variable2=" . $v2_validado);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 //ejecutar la solicitud
 $output = curl_exec($ch);
 // Cerrar cURL
 curl_close($ch); 
 // Decodificar la respuesta JSON
 $data1 = json_decode($output, true);
*/


$url = 'https://magustechnologies.com/factura_santodomingo/datosrec.php';
$curl = curl_init();
$fields = array(
    'field_name_1' => 'Value 1',
    'field_name_2' => 'Value 2',
    'field_name_3' => 'Value 3'
);
$fields_string = http_build_query($fields);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
$data = curl_exec($curl);
curl_close($curl);

$data1 = json_decode($data, true);

print_r ($fields);
 ?>
