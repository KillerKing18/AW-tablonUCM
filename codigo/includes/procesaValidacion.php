<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

$text = $_POST['text'];
$caso = $_POST['caso'];

switch($caso){
    case 'usuario':
        if(isset($_SESSION['nombre']) && $_SESSION['nombre'] === $text)
            echo -1;
        else if(!Usuario::buscaUsuario($text))
            echo 0;
        else
            echo 1;    
        break;
    case 'email':
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->email() === $text)
            echo 1;
        else
            echo 0; 
        break;
}
?>