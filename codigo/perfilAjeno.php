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
    <title>Perfil ajeno</title>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/cabecera.js"></script>
</head>

<body>

    <div id="contenedor">

        <?php
	        require("includes/comun/cabecera.php");
        ?>

        <div id="contenido">
            <div class="perfilAjeno">
                <?php
                    if(isset($_REQUEST['id']))
                        echo Usuario::mostrarPerfilAjeno($_REQUEST['id']);
                    else{
                        echo '<h1>Perfil ajeno</h1>';
                        echo '<p>Oops! Parece que salió algo mal...</p>';
                    }
                    
                ?>
            </div>
        </div>

        <?php
            require("includes/comun/pie.php");
        ?>

    </div>
</body>

</html>