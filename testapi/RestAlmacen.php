<?php
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

  $url = "";
  $ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Origin: http://localhost/public_html/testapi/RestAlmacen.php'
       ));

	$response = curl_exec($ch);
	$err = curl_error($ch);
	curl_close($ch);

if ($err) {
    echo 'Error: ' . $err;
} else {
    echo $response;
    /*
echo $data = json_decode($response, true);
foreach ($data['data'] as $item) {
    echo $item['name'];
   }*/

}

 
?>
