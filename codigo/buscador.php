<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioBusqueda.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Buscar</title>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/selectoresBusqueda.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
			require("includes/comun/cabecera.php");
		?>
        <div id="contenido">
            <h1>Busca tus apuntes</h1>
            <div class="info">
                <p> Desde aquí podrás buscar los archivos que necesites </p>
            </div>
            <div class="formulario">
				<?php
					$formularioBusqueda = new FormularioBusqueda("form-search", array( 'action' => 'buscador.php'));
					$formularioBusqueda->gestiona();
				?>
            </div>
        </div>

		<?php
			require("includes/comun/pie.php");
		?>
    </div>
</body>

</html>