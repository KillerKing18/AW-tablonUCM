<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Resultado</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/archivos.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
            <div class="archivo">
                <?php
                    Archivo::generarResultado();
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>