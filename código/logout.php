<?php
require_once __DIR__.'/includes/config.php';

if(!isset($_SESSION['login']))
	header('Location: login.php');
	
//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["nombre"]);


session_destroy();
?><!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabeceraLogin.php");
?>

	<div id="contenido">
		<h1>Gracias por su visita!</h1>
		<a href="login.php">Vuelve a iniciar sesión</a>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>