<?php

/*if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}*/

session_start();

/* $_SESSION['usuario'] = '3';
            $_SESSION['perfil'] = 'admin';
            $_SESSION['nombres'] ='admin';
            $_SESSION['email'] = 'admin';*/
var_dump($_SESSION);

echo "aaaaaaaa";
