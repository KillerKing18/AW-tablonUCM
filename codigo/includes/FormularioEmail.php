<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioEmail extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<label>Nuevo email:</label>
                <input name="email" type="email" id="email" maxlength="40" class="validacion" required=""></input>
                <button type="submit" id="cambiar">Actualizar</button>';
    }

    public function procesaFormulario($datos)
    {
        $erroresFormulario = array();

        $email = $_REQUEST['email'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->email() !== $email)
            $usuario->cambiaEmail($email);
        else
            $erroresFormulario[] = "Error. Tu nuevo email no puede ser el mismo que el antiguo";

        return $erroresFormulario;
    }
}