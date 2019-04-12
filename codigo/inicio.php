<?php
require_once __DIR__.'/includes/config.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
$_SESSION['seccion'] = 'inicio';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Portada</title>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
?>

	<div id="contenido">
		<h1>Bienvenido a tablónUCM</h1>
		<p>La página se encuentra actualmente en mantenimiento. Vuelve en un tiempo para ver las novedades.</p>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>