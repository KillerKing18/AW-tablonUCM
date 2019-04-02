<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Universidad.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');

if(isset($_FILES['archivo'])){
	$error = $_FILES['archivo']['error']; 
	switch ($error){
	case 0:
		$sizeError= '';
		$file_name = $_FILES['archivo']['name'];
		$file_size = $_FILES['archivo']['size'];
		$file_tmp = $_FILES['archivo']['tmp_name'];
		$tmp_file_ext = explode('.',$file_name);
		$file_ext = strtolower(end($tmp_file_ext));

		if(!file_exists('archivos')){
			if(mkdir('archivos', 0777, true))
				echo "<script type='text/javascript'>alert('Se ha creado una carpeta nueva');</script>";
			else
				echo "<script type='text/javascript'>alert('No se ha podido crear la carpeta');</script>";
		}
		if(move_uploaded_file($file_tmp,"archivos/".$file_name))
			echo "<script type='text/javascript'>alert('Archivo subido correctamente');</script>";
		else
			echo "<script type='text/javascript'>alert('Se ha producido un error al subir el archivo');</script>";
		break;
	case 4:
		echo "<script type='text/javascript'>alert('No se subió ningún fichero.');</script>";
		break;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
<script type="text/javascript">

function habilitarSiguienteSelector(idAnterior, idSiguiente, valorAnterior, stringSiguientePorDefecto, options){
	// Poner la opcion seleccionada cuando el usuario presionó actualizar
	var opcionAnteriorSeleccionada = '<option value="' + valorAnterior + '">' + valorAnterior + '</option>';
	document.getElementById(idAnterior).innerHTML = opcionAnteriorSeleccionada;
	// Habilitar siguiente selector rellenarlo con sus opciones gracias a la base de datos según las opciones anteriormente seleccionadas
	document.getElementById(idSiguiente).disabled = false;
	options = '<option value="0" disabled selected>Elija ' + stringSiguientePorDefecto + '</option>' + options;
	document.getElementById(idSiguiente).innerHTML = options;
}
function vaciarCampos(){
	document.getElementById("facultad").disabled = true;
	document.getElementById("grado").disabled = true;
	document.getElementById("curso").disabled = true;
	document.getElementById("asignatura").disabled = true;
	document.getElementById("categoria").disabled = true;
}

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
		<div class="formulario">
			<form action = "" name="campos" method="post" enctype="multipart/form-data"> 
				<label>Facultad</label>
				<select name="facultad" id="facultad">
					<?php
						$options = Universidad::creaOpcionesFacultades();
						echo "<script type='text/javascript'>document.getElementById('facultad').innerHTML = '" . $options . "';</script>";
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
				<button id="actualizar" type="submit">Actualizar</button>
				<button onclick="vaciarCampos();" type="submit">Vaciar</button>
				<label>Observaciones</label>
				<textarea rows="4" cols="50"></textarea>
				<input type="file" name="archivo">
				<button type="submit" name="subir">Subir</button>
			</form>
		</div>
	</div>

<?php
	require("includes/comun/pie.php");

?>


</div>
<?php
	if(isset($_POST['facultad']) && $_POST['facultad'] !== 0){
		$resultado = Universidad::devuelveGrados($_REQUEST['facultad']);
		$options = '';
		while ($fila = $resultado->fetch_assoc()) {
			$options .= '<option value="' . $fila["grado"] . '">' . $fila["grado"] . '</option>';
		}
		$resultado->free();
		echo "<script type='text/javascript'>habilitarSiguienteSelector('facultad', 'grado', '" . $_POST["facultad"] . "', 'un grado', '" . $options . "');</script>";
		if(isset($_POST['grado']) && $_POST['grado'] !== 0){
			$resultado = Universidad::devuelveCursos($_REQUEST['facultad'], $_REQUEST['grado']);
			$options = '';
			while ($fila = $resultado->fetch_assoc()) {
				$options .= '<option value="' . $fila["curso"] . '">' . $fila["curso"] . '</option>';
			}
			$resultado->free();
			echo "<script type='text/javascript'>habilitarSiguienteSelector('grado', 'curso', '" . $_POST["grado"] . "', 'un curso', '" . $options . "');</script>";
			if(isset($_POST['curso']) && $_POST['curso'] !== 0){
				$resultado = Universidad::devuelveAsignaturas($_REQUEST['facultad'], $_REQUEST['grado'], $_REQUEST['curso']);
				$options = '';
				while ($fila = $resultado->fetch_assoc()) {
					$options .= '<option value="' . $fila["asignatura"] . '">' . $fila["asignatura"] . '</option>';
				}
				$resultado->free();
				echo "<script type='text/javascript'>habilitarSiguienteSelector('curso', 'asignatura', '" . $_POST["curso"] . "', 'una asignatura', '" . $options . "');</script>";
				if(isset($_POST['asignatura']) && $_POST['asignatura'] !== 0){
					$options = '';
					$options .= '<option value="Teoria">Teoría</option>';
					$options .= '<option value="Ejercicios">Ejercicios</option>';
					$options .= '<option value="Practicas">Prácticas</option>';
					$options .= '<option value="Examenes">Exámenes</option>';
					echo "<script type='text/javascript'>habilitarSiguienteSelector('asignatura', 'categoria', '" . $_POST["asignatura"] . "', 'una categoría', '" . $options . "');</script>";
				}
			}
		}
	}
	
	
	
?>
</body>
</html>