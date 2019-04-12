<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioBorrarCuenta extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<button type="submit" id="borrar">Borrar cuenta</button>';
    }

    public function procesaFormulario($datos)
    {
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $usuario->borrarUsuario();
        unset($_SESSION['login']);
        unset($_SESSION['esAdmin']);
        unset($_SESSION['nombre']);
        session_destroy();

        echo "<script>document.location.href = 'login.php';</script>";
    }
}