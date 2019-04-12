<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/Archivo.php';

$id = $_POST['id'];
$caso = $_POST['caso'];

switch($caso){
    case 'borrarArchivo':
        Archivo::borrarArchivo($id);
        break;
    case 'borrarUsuario':
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $usuario->borrarUsuario();
        break;
}
?>