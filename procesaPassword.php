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
        $actual = $_REQUEST['oldPassword'];
        $nueva1 = $_REQUEST['newPassword1'];
        $nueva2 = $_REQUEST['newPassword2'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->compruebaPassword($actual)){
            if($usuario->compruebaPassword($nueva1))    {
                echo "Error. Tu contraseña no puede ser la misma que estabas usando<br>";
            }
            else{
                if($nueva1 == $nueva2){
                    $usuario->cambiaPassword($nueva1);
                    echo "Se ha cambiado la contraseña correctamente<br>";
                }
                else{
                    echo "No has escrito correctamente la nueva contraseña dos veces<br>";
                }
            }
        }
        else{
            echo "No has escrito correctamente tu contraseña actual<br>";
        }
        echo "<a href='perfil.php'>Volver</a>";
	require("includes/comun/pie.php");
?>


</div>

</body>
</html>