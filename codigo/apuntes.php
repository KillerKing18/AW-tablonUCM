<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Archivo.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
    $_SESSION['seccion'] = 'apuntes';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Mis apuntes</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
            <!--<div class="asignaturas">
                <?php
                    // Mostrar asignaturas marcadas
                ?>
            </div>-->
            <div class="archivos">
                <?php
                    echo Archivo::generaArchivosUsuario($_SESSION['nombre']);
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>