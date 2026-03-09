<html lang="es" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $dataConf['descripcion'] ?>">
    <meta property="fb:admins" content="<?= $dataConf['redessociales']['id_facebook'] ?>">
    <meta property="og:title" content="<?= $dataConf['titulo'] ?>">
    <meta property="og:type" content="Comercialización de HARDWARE">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="ACEADVANCE">
    <meta property="og:image" content="../public/img/banner/ico.jpg">
    <script>
        const IS_LOGIN = <?= isset($_SESSION['usuario']) ? 'true' : 'false' ?>;
    </script>
    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">