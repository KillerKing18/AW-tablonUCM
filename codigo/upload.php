<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioUpload.php';
if(!isset($_SESSION['login']))
    header('Location: login.php');
$_SESSION['seccion'] = 'upload';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Upload</title>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/selectores.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>
    <div id="contenedor">
        <?php
			require("includes/comun/cabecera.php");
		?>
        <div id="contenido">
            <h1>Sube tus apuntes</h1>
            <div class="info">
                <p> Sólo se puede subir 1 único archivo. Si necesitas subir varios archivos para que tu contenido sea
                    consistente, puedes comprimirlos en un archivo .zip o .rar </p>
            </div>
            <div class="formulario">
				<?php
					$formularioUpload = new FormularioUpload("form-upload", array( 'action' => 'upload.php'));
					$formularioUpload->gestiona();
				?>
            </div>
        </div>

		<?php
			require("includes/comun/pie.php");
		?>
    </div>
</body>

</html>