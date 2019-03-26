<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistro.php';
?><!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registro</title>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
	require("includes/comun/sidebarIzq.php");
?>

	<div id="contenido">
		<h1>Registro de usuario</h1>

	<?php
		$formularioRegistro = new FormularioRegistro("form-registro");
		$formularioRegistro->gestiona();

	?>


	</div>

<?php
	require("includes/comun/sidebarDer.php");
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>