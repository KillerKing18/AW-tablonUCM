<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Evento.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'eventos';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Eventos</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
        <h1>Eventos</h1>
		<p>Esta página se encuentra actualmente en mantenimiento. Vuelve en un tiempo para ver las novedades.</p>
            <!--<div class="proximosEventos">
                <?php
                    //echo Evento::mostrarProximosEventos(0, '');
                ?>
            </div>
            <div class="tusProximosEventos">
                <?php
                    //echo Evento::mostrarProximosEventos(0, $_SESSION['nombre']);
                ?>
            </div>
            <div class="formulario">
				<?php
					//$formularioEvento = new FormularioEvento("form-evento", array( 'action' => 'eventos.php'));
					//$formularioEvento->gestiona();
				?>
            </div>-->
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>