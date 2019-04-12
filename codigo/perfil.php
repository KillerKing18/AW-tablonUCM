<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Usuario.php';
require_once __DIR__.'/includes/FormularioNombreUsuario.php';
require_once __DIR__.'/includes/FormularioEmail.php';
require_once __DIR__.'/includes/FormularioPassword.php';
require_once __DIR__.'/includes/FormularioImagen.php';
require_once __DIR__.'/includes/FormularioBorrarCuenta.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
$_SESSION['seccion'] = 'perfil';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="estilo.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Perfil</title>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/perfil.js"></script>
	<script type="text/javascript" src="js/validacion.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
?>

	<div id="contenido">
        <h1>Perfil</h1>
            <div class="info" id="final">
			
            </div>
			<div class="forms">
				<div class="form-nombreUsuario">
					<h3>Cambiar nombre de usuario</h3>
					<?php
						$formularioNombreUsuario = new FormularioNombreUsuario("form-nombreUsuario", array( 'action' => 'perfil.php'));
						$formularioNombreUsuario->gestiona();
					?>
				</div>
				<div class="form-email">
					<h3>Cambiar email</h3>
					<?php
						$formularioEmail = new FormularioEmail("form-email", array( 'action' => 'perfil.php'));
						$formularioEmail->gestiona();
					?>
				</div>
				<div class="form-password">
					<h3>Cambiar contraseña</h3>
					<?php
						$formularioPassword = new FormularioPassword("form-password", array( 'action' => 'perfil.php'));
						$formularioPassword->gestiona();
					?>
				</div>
				<div class="form-imagen">
					<?php
						$formularioImagen = new FormularioImagen("form-imagen", array( 'action' => 'perfil.php'));
						$formularioImagen->gestiona();
					?>
				</div>
				<div class="form-borrarCuenta">
					<h3>Borrar cuenta</h3>
					<p>Atención: Todos los archivos, eventos, comentarios y valoraciones asociados a tu cuenta serán borrados automáticamente.</p>
					<?php
						$formularioBorrarCuenta = new FormularioBorrarCuenta("form-borrarCuenta", array( 'action' => 'perfil.php'));
						$formularioBorrarCuenta->gestiona();
					?>
				</div>
			</div>
			<div class="info" id="provisional">
				<?php 	// Mirar explicacion en perfil.js
                    $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
                    echo $usuario->mostrarPerfil();
				?>
            </div>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>