<?php
require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

class FormularioPassword extends Form{

    public function generaCamposFormulario($datosIniciales)
    {
        return  '<label>Contraseña actual:</label>
                <input type="password" name="oldPassword" maxlength="80" required=""></input>
                <label>Contraseña nueva:</label>
                <input type="password" name="newPassword" id="password1" maxlength="80" class="validacion" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*.{7}" required=""></input>
                <label>Repita la nueva contraseña:</label>
                <input type="password" name="newPassword2" id="password2" maxlength="80" class="validacion" required=""></input>
                <button type="submit" id="cambiar">Actualizar</button>';
    }

    public function procesaFormulario($datos)
    {
        $erroresFormulario = array();

        $actual = $_REQUEST['oldPassword'];
        $nueva1 = $_REQUEST['newPassword'];
        $nueva2 = $_REQUEST['newPassword2'];
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        if($usuario->compruebaPassword($actual))
            if($usuario->compruebaPassword($nueva1)) 
                $erroresFormulario[] = "Error. Tu nueva contraseña no puede ser la misma que la antigua";
            else
                if($nueva1 === $nueva2)
                    $usuario->cambiaPassword($nueva1);
                else
                    $erroresFormulario[] = "Las nuevas contraseñas no coinciden";
        else
            $erroresFormulario[] = "No has escrito correctamente tu contraseña actual";

        return $erroresFormulario;
    }
}