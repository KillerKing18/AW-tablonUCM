<?php
require_once __DIR__.'/includes/config.php';
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
	require("includes/comun/cabecera.php");
	require("includes/comun/sidebarIzq.php");
?>

	<div id="contenido">
		<h1>Sube tus apuntes</h1>
		<div class="info">
		<p> Sólo se puede subir 1 único archivo. Si necesitas subir varios archivos para que tu contenido sea consistente, puedes comprimirlos en un archivo .zip o .rar </p>
		</div>
		<div class="campos">
			<label>Facultad</label>
			<select name="facultad">
			   <option value="1">Windows Vista</option>
			</select>
			<label>Grado</label>
			<select name="grado">
			   <option value="1">Windows Vista</option>
			</select>
			<label>Curso</label>
			<select name="curso">
			   <option value="1">Windows Vista</option>
			</select>
			<label>Asignatura</label>
			<select name="asignatura">
			   <option value="1">Windows Vista</option>
			</select>
			<label>Categoría</label>
			<select name="categoria">
			   <option value="1">Windows Vista</option>
			</select>
		</div>
		<div class="observaciones">
			<label>Observaciones</label>
			<textarea rows="4" cols="50"></textarea>
		</div>
		<div class="archivo">
			<input type="file" id="archivo">
			<button type="submit" name="subir">Subir</button>
		</div>
	</div>

<?php

	require("includes/comun/sidebarDer.php");
	require("includes/comun/pie.php");

?>


</div>

</body>
</html>