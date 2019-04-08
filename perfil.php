<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Usuario.php';
if(!isset($_SESSION['login']))
	header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Perfil</title>
</head>

<body>

<div id="contenedor">

<?php
	require("includes/comun/cabecera.php");
?>

	<div id="contenido">
        <h1>Perfil</h1>
        <img src="img/user.png" />
        <a href="a.php">Cambiar imagen </a>
        <br>
        <?php
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            echo "Nombre de usuario: ".$usuario->nombreUsuario();
            echo "<br>";
             //echo "Valoracion: ".$usuario->valoracion();
            echo "E-mail: ".$usuario->email();
        ?>
        <h3>Cambiar contraseña</h3>
        <form action='procesaPassword.php' method='post'>
            Contraseña actual: <input type='password' name='oldPassword'><br>
            Contraseña nueva: <input type='password' name='newPassword1'><br>
            Repita la nueva contraseña: <input type='password' name='newPassword2'>
            <input type ='submit' value = 'Cambiar contraseña'> 
        </form>
	</div>

<?php
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>