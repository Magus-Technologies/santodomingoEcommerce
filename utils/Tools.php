<?php
require "../utils/funciones.php";

class Tools
{
    function getToken($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[rand(0, $max - 1)];
        }

        return $token;
    }

    public function formatoFechaVisual($fecha)
    {
        $fecha = new DateTime($fecha);
        return self::nombreMes(intval($fecha->format('m')) - 1) . " " . $fecha->format('d') . " del, " . $fecha->format('Y');
    }

    function onlyMoney($txt, $mayuscula = null)
    {
        $txt = stringToMayusula($txt, $mayuscula);
        return preg_replace('([^0-9.])', '', $txt);
    }

    function money($n, $decimales = 2)
    {
        if (!is_numeric($n))
            return '0.00';
        $m = number_format($n, $decimales, '.', ',');
        return $m;
    }

    function roundtxt($txt, $cant)
    {
        $puntitos = '';
        if (strlen($txt) > $cant):
            $puntitos = ' ...';
        endif;
        return substr($txt, 0, $cant) . $puntitos;
    }

    function estados_pedido($est)
    {
        switch ($est) {
            case "1":
                return 'En espera';
            case "2":
                return 'Aprobado';
            case "3":
                return 'Rechazado';
            case "4":
                return 'Vendido';
        }
    }

    function estados_cotizacion($est)
    {
        switch ($est) {
            case "-1":
                return 'Rechazado';
            case "0":
                return 'En proceso';
            case "1":
                return 'en revision';
            case "2":
                return 'Aprobado';
                #case "3":
                #    return 'Rechazado';
                #case "4":
                #     return 'Vendido';
        }
    }

    function secure_rand($min, $max)
    {
        return (unpack("N", openssl_random_pseudo_bytes(4)) % ($max - $min)) + $min;
    }

    function abreviaturaMes($mes)
    {
        $meses = array("en", "febr", "mzo", "abr", "my", "jun", "jul", "agto", "sept", "oct", "nov", "dic");

        return $meses[$mes];
    }

    function nombreMes($mes)
    {
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        return $meses[$mes];
    }

    function getConfiguracion()
    {
        return json_decode(file_get_contents("../utils/tsconfig.json"), true);
    }

    function guardarConfiguarion($cnf)
    {
        $filePath = __DIR__ . "/../utils/tsconfig.json";

        // Verifica si la carpeta existe
        if (!is_dir(dirname($filePath))) {
            throw new Exception("Directory does not exist: " . dirname($filePath));
        }

        // Intenta abrir el archivo
        $file = fopen($filePath, "w");
        if (!$file) {
            $error = error_get_last();
            throw new Exception("Failed to open file: $filePath. System error: " . $error['message']);
        }

        // Escribe el contenido JSON
        $json = json_encode($cnf, JSON_PRETTY_PRINT);
        if ($json === false) {
            fclose($file);
            throw new Exception("JSON encoding failed: " . json_last_error_msg());
        }

        $result = fwrite($file, $json . PHP_EOL);
        if ($result === false) {
            fclose($file);
            throw new Exception("Failed to write to file: $filePath");
        }

        fclose($file);
    }
}
