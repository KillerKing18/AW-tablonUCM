<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Universidad.php';
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
<?php
if(!isset($_SESSION['login']))
	header('Location: login.php');
?>
<script type="text/javascript">
function carga(){
	document.getElementById("facultad").addEventListener("change", habilitarGrado, false);
	document.getElementById("grado").addEventListener("change", habilitarCurso, false);
	document.getElementById("curso").addEventListener("change", habilitarAsignatura, false);
	document.getElementById("asignatura").addEventListener("change", habilitarCategoria, false);
}
function habilitarGrado(e){
	document.getElementById("grado").disabled = false;
	<?php
		$resultado = Universidad::devuelveGrados("Facultad de Informática");
		$cadena = "<option value='0' disabled selected>Elija un grado</option>";
		while ($fila = $resultado->fetch_assoc()) {
			$cadena .= "<option value=" . $fila["grado"] . ">" . $fila["grado"] . "</option>";
		}
		$resultado->free();
	?>
	document.getElementById("grado").innerHTML = "<?php echo $cadena ?>";
}
function habilitarCurso(){
	document.getElementById("curso").disabled = false;
	<?php
		$resultado = Universidad::devuelveCursos("Facultad de Informática", "Grado en Ingeniería Informática");
		$cadena = "<option value='0' disabled selected>Elija un curso</option>";
		while ($fila = $resultado->fetch_assoc()) {
			$cadena .= "<option value=" . $fila["curso"] . ">" . $fila["curso"] . "</option>";
		}
		$resultado->free();
	?>
	document.getElementById("curso").innerHTML = "<?php echo $cadena ?>";
}
function habilitarAsignatura(){
	document.getElementById("asignatura").disabled = false;
	<?php
		$resultado = Universidad::devuelveAsignaturas("Facultad de Informática", "Grado en Ingeniería Informática", "Segundo");
		$cadena = "<option value='0' disabled selected>Elija una asignatura</option>";
		while ($fila = $resultado->fetch_assoc()) {
			$cadena .= "<option value=" . $fila["asignatura"] . ">" . $fila["asignatura"] . "</option>";
		}
		$resultado->free();
	?>
	document.getElementById("asignatura").innerHTML = "<?php echo $cadena ?>";
}
function habilitarCategoria(){
	document.getElementById("categoria").disabled = false;
	var cadena = "<option value='0' disabled selected>Elija una asignatura</option>";
	cadena += "<option value='Teoria'>Teoría</option>";
	cadena += "<option value='Ejercicios'>Ejercicios</option>";
	cadena += "<option value='Practicas'>Prácticas</option>";
	cadena += "<option value='Examenes'>Exámenes</option>";

	document.getElementById("categoria").innerHTML = cadena;
}


window.addEventListener("load", carga, false);
</script>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
?>

	<div id="contenido">
		<h1>Sube tus apuntes</h1>
		<div class="info">
		<p> Sólo se puede subir 1 único archivo. Si necesitas subir varios archivos para que tu contenido sea consistente, puedes comprimirlos en un archivo .zip o .rar </p>
		</div>
		<div class="campos">
			<form name="campos" method="post"> 
				<label>Facultad</label>
				<select name="facultad" id="facultad">
					<option value="0" disabled selected>Elija una facultad</option>
					<?php
					$resultado = Universidad::devuelveFacultades();
					while ($fila = $resultado->fetch_assoc()) {
						echo "<option value=" . $fila["facultad"] . ">" . $fila["facultad"] . "</option>";
					}
					$resultado->free();
					?>
				</select>
				<label>Grado</label>
				<select name="grado" id="grado" disabled>
					<option value="0" disabled selected>Elija un grado</option>
				</select>
				<label>Curso</label>
				<select name="curso" id="curso" disabled>
					<option value="0" disabled selected>Elija un curso</option>
				</select>
				<label>Asignatura</label>
				<select name="asignatura" id="asignatura" disabled>
					<option value="0" disabled selected>Elija una asignatura</option>
				</select>
				<label>Categoría</label>
				<select name="categoria" id="categoria" disabled>
					<option value="0" disabled selected>Elija una categoría</option>
				</select>
			</form>
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
	require("includes/comun/pie.php");

?>


</div>

</body>
</html>