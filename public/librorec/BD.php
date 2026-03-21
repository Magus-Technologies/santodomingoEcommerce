<?php
$_isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);
if ($_isLocal) {
    define('DB_HOST', 'localhost:33068');
    define('DB_USER', 'root');
    define('DB_PASS', '7616');
    define('DB_NAME', 'Ecommerce');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'C4l4b4za$$');
    define('DB_NAME', 'Ecommerce');
}
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        die("imposible conectarse: ".mysqli_connect_error());
    }
    if (@mysqli_connect_errno()) {
        die("Conexin fall: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

   mysqli_query($con,"SET CHARACTER SET 'utf8'");
mysqli_query($con,"SET SESSION collation_connection ='utf8_unicode_ci'");

?>
