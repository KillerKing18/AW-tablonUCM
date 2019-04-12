<?php
require_once __DIR__.'/includes/config.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
else if (!$_SESSION['esAdmin'])
    header('Location: inicio.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Administrar</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
        <h1>Administrar</h1>
		<p>Esta página se encuentra actualmente en mantenimiento. Vuelve en un tiempo para ver las novedades.</p>
            <!--<div class="ultimosArchivos">
                <?php
                    //echo Archivo::mostrarUltimosArchivos();
                ?>
            </div>
            <div class="ultimosEventos">
                <?php
                    //echo Evento::mostrarUltimosEventos();
                ?>
            </div>
            <div class="reportes">
				<?php
					//echo Reporte::mostrarReportes();
				?>
            </div>-->
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>