<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';
require_once __DIR__.'/includes/FormularioRegistro.php';
?><!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
	require("includes/comun/sidebarIzq.php");
?>

	<div id="contenido">
		<div class="tab">
		  <button class="tablinks" onclick="openTab(event, 'Login')" id="defaultOpen">Login</button>
		  <button class="tablinks" onclick="openTab(event, 'Registro')">Registro</button>
		</div>
		
		<div id="Login" class="tabcontent">
			<?php
			$formularioLogin = new FormularioLogin("form-login");
			$formularioLogin->gestiona();
			?>
		</div>
		<div id="Registro" class="tabcontent">
			<?php
			$formularioRegistro = new FormularioRegistro("form-registro");
			$formularioRegistro->gestiona();
			?>
		</div>

	</div>

<?php
	require("includes/comun/sidebarDer.php");
	require("includes/comun/pie.php");
?>


</div>
<script  src="js/tab.js"></script>
</body>
</html>